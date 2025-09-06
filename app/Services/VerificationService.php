<?php

namespace App\Services;

use App\Utils\Response;
use configs\Database;
use App\Services\Activity;
use App\Utils\MailClient;
use App\Utils\Utility;

/**
 * Class VerificationService
 *
 * Handles verification requests, payments, and related operations.
 * Provides methods to fetch, create, update, and delete verification requests.
 */
class VerificationService
{
    /**
     * Fetch a single verification request by ID, VIN, request_id, or user ID.
     *
     * @param mixed $id Verification request identifier (can be userid, id, request_id, vin).
     * @return array|null Returns the verification request data or null.
     */
    public static function fetchVerificationRequest($id)
    {
        $verification = Utility::$verifications_tbl;
        $profile      = Utility::$profile_tbl;
        $vehicle      = Utility::$vehicles_tbl;
        $dealer       = Utility::$dealers_tbl;
        $transaction  = Utility::$transaction_tbl;

        try {
            return Database::joinTables(
                "$verification r",
                [
                    ["type" => "LEFT", "table" => "$profile p", "on" => "r.userid = p.userid"],
                    ["type" => "LEFT", "table" => "$vehicle v", "on" => "r.vin = v.vin"],
                    ["type" => "LEFT", "table" => "$dealer d", "on" => "d.userid = v.userid"],
                    ["type" => "LEFT", "table" => "$transaction t", "on" => "t.txnsid = r.request_id"]
                ],
                [
                    "r.*",
                    "p.fullname",
                    "v.vin",
                    "v.images",
                    "v.documents",
                    "v.make",
                    "v.model",
                    "v.title",
                    "v.status AS vehicle_status",
                    "d.company",
                    "t.meta_data",
                    "t.amount"
                ],
                [
                    "OR" => [
                        "r.userid"     => $id,
                        "r.id"         => $id,
                        "r.request_id" => $id,
                        "r.vin"        => $id
                    ]
                ],
                ["order" => "r.id DESC"]
            );
        } catch (\Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'VerificationService::fetchVerificationRequest',
                ['userid' => $_SESSION['userid'] ?? null],
                $th
            );
            Response::error(500, "An error occurred while fetching verification request");
        }
    }

    /**
     * Fetch all verification requests.
     *
     * @return array|null List of verification requests.
     */
    public static function fetchAllVerificationRequest()
    {
        $verification = Utility::$verifications_tbl;
        $profile      = Utility::$profile_tbl;
        $vehicle      = Utility::$vehicles_tbl;
        $dealer       = Utility::$dealers_tbl;
        $transaction  = Utility::$transaction_tbl;

        try {
            return Database::joinTables(
                "$verification r",
                [
                    ["type" => "LEFT", "table" => "$profile p", "on" => "r.userid = p.userid"],
                    ["type" => "LEFT", "table" => "$vehicle v", "on" => "r.vin = v.vin"],
                    ["type" => "LEFT", "table" => "$dealer d", "on" => "d.userid = v.userid"],
                    ["type" => "LEFT", "table" => "$transaction t", "on" => "t.txnsid = r.request_id"]
                ],
                [
                    "r.*",
                    "p.fullname",
                    "v.vin",
                    "v.images",
                    "v.documents",
                    "v.make",
                    "v.model",
                    "v.title",
                    "v.status AS vehicle_status",
                    "d.company",
                    "t.meta_data",
                    "t.amount"
                ],
                [],
                ["order" => "r.id DESC"]
            );
        } catch (\Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'VerificationService::fetchAllVerificationRequest',
                ['userid' => $_SESSION['userid'] ?? null],
                $th
            );
            Response::error(500, "An error occurred while fetching verification requests");
        }
    }

    /**
     * Verify payment with Paystack and save verification request.
     *
     * @param array $data Verification data (expects reference, vin, plan, etc.).
     * @return bool Returns true if saved successfully.
     */
    public static function verifyAndSaveRequest($data)
    {
        try {
            $reference = $data['reference'] ?? null;
            $verificationTable = Utility::$verifications_tbl;

            if (!$reference) {
                Response::error(404, "Reference not supplied");
            }

            // Verify payment with Paystack
            $verification = Paystack::verifyPaystackPayment($reference);
            if (!$verification['status']) {
                Response::error(401, "Verification failed. " . $verification['message']);
            }

            $paymentData = $verification['data'];
            $metaData    = $paymentData['metadata']['custom_fields'] ?? [];
            $customerData = [];

            foreach ($metaData as $item) {
                if ($item['display_name'] === 'Name') {
                    $customerData['fullname'] = $item['value'];
                }
                if (strtolower($item['display_name']) === 'email') {
                    $customerData['email_address'] = $item['value'];
                }
            }

            $amount            = $paymentData['amount'] / 100;
            $paymentReference  = $paymentData['reference'];

            // Find user using email
            $user   = UserService::fetchUserDetails($data['email_address'] ?? '');
            $userid = !empty($user) ? $user[0]['userid'] : "";

            // Prepare verification and transaction data
            $verificationData = [
                'userid'     => $userid,
                'request_id' => $paymentReference,
                'vin'        => $data['vin'],
                'plan'       => $data['plan'],
                'date'       => date('Y-m-d'),
            ];

            $transactionData = [
                'txnsid'    => $paymentReference,
                'amount'    => intval($amount),
                'status'    => strtolower($paymentData['gateway_response'] ?? 'pending'),
                'date'      => date('Y-m-d'),
                'user'      => $userid,
                'method'    => $paymentData['channel'] ?? 'card',
                'ip_address' => $paymentData['ip_address'] ?? '',
                'meta_data' => json_encode($customerData),
            ];

            // Save to database
            if (
                Database::insert($verificationTable, $verificationData) &&
                TransactionService::saveNewTransaction($transactionData)
            ) {
                Activity::activity([
                    'userid' => $data['userid'],
                    'type'   => 'verification',
                    'title'  => 'verification successful',
                ]);
                return true;
            }
        } catch (\Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'VerificationService::verifyAndSaveRequest',
                ['userid' => $_SESSION['userid'] ?? null],
                $th
            );
            Response::error(500, "An error occurred while saving verification request");
        }
    }

    /**
     * Update a verification request status or plan.
     *
     * @param mixed $id Verification request identifier.
     * @param array $data Data to update (status, plan).
     * @return bool Returns true if update successful.
     */
    public static function updateVerificationRequest($id, $data)
    {
        $verificationTable = Utility::$verifications_tbl;

        try {
            $exists = self::fetchVerificationRequest($id);
            if (empty($exists)) {
                Response::error(404, "Verification request not found");
            }

            $verification = $exists[0];
            $user         = json_decode($verification['meta_data'], true);

            // Send verification code email if approved
            if (($data['status'] ?? null) === 'approved' && $verification['status'] !== 'approved') {
                $templateData = [
                    '{{logo_url}}'          => BASE_URL . 'assets/images/dark-logo.jpg',
                    '{{user_name}}'         => $user['fullname'] ?? '',
                    '{{platform_name}}'     => BRAND_NAME,
                    '{{verification_code}}' => $verification['request_id'],
                    '{{verification_link}}' => BASE_URL . 'secure/verified?code=' . $verification['request_id'],
                    '{{support_url}}'       => BASE_URL . 'contact-us',
                    '{{current_year}}'      => date('Y'),
                    '{{user_email}}'        => $user['email_address'] ?? ''
                ];

                MailClient::sendMail(
                    $user['email_address'] ?? '',
                    'Verification Code',
                    ROOT_PATH . '/app/Services/templates/send_verification_code.html',
                    $templateData,
                    $user['fullname'] ?? ''
                );
            }

            $updateArray = [
                'status' => $data['status'] ?? $verification['status'],
                'plan'   => $data['plan'] ?? $verification['plan'],
            ];

            if (Database::update($verificationTable, $updateArray, ["request_id" => $id])) {
                Activity::activity([
                    'userid' => $_SESSION['userid'],
                    'type'   => 'update',
                    'title'  => 'verification update successful',
                ]);
                return true;
            }
        } catch (\Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'VerificationService::updateVerificationRequest',
                ['userid' => $_SESSION['userid'] ?? null],
                $th
            );
            Response::error(500, "An error occurred while updating verification request");
        }
    }

    /**
     * Delete a verification request.
     *
     * @param mixed $id Verification request identifier.
     * @return void
     */
    public function deleteVerificationRequest($id)
    {
        $verificationTable = Utility::$verifications_tbl;

        try {
            $find = self::fetchVerificationRequest($id);
            if (empty($find)) {
                Response::error(404, "Verification request not found");
            }

            if (Database::delete($verificationTable, ["transaction_id" => $id])) {
                Activity::activity([
                    'userid' => $_SESSION['userid'],
                    'type'   => 'delete',
                    'title'  => 'verification delete successful',
                ]);
                Response::success([], "Verification request deleted");
            }
        } catch (\Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'VerificationService::deleteVerificationRequest',
                ['userid' => $_SESSION['userid'] ?? null],
                $th
            );
            Response::error(500, "An error occurred while deleting verification request");
        }
    }
}
