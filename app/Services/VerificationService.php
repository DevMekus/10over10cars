<?php

namespace App\Services;

use App\Utils\Response;
use configs\Database;
use App\Services\Activity;
use App\Utils\Utility;

class  VerificationService
{

    public static function fetchVerificationRequest($id)
    {
        $verification = Utility::$verifications_tbl;
        $profile = Utility::$profile_tbl;
        $vehicle = Utility::$vehicles_tbl;
        try {
            return Database::joinTables(
                "$verification r",
                [
                    [
                        "type" => "LEFT",
                        "table" => "$profile p",
                        "on" => "r.userid = p.userid"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$vehicle v",
                        "on" => "r.vin = v.vin"
                    ]
                ],
                ["r.*", "p.fullname", "v.*"],
                [
                    "OR" => [
                        "r.userid" => $id,
                        "r.id" => $id,
                        "r.request_id" => $id,
                        "r.vin" => $id
                    ]
                ],
                ["order" => "r.id DESC"]
            );
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'VerificationService::fetchVerificationRequest', ['userid' => $_SESSION['userid']], $th);
            Response::error(500, "An error occurred while fetching verification request");
        }
    }

    public static function fetchAllVerificationRequest()
    {
        $verification = Utility::$verifications_tbl;
        $profile = Utility::$profile_tbl;
        $vehicle = Utility::$vehicles_tbl;
        try {
            return Database::joinTables(
                "$verification r",
                [
                    [
                        "type" => "LEFT",
                        "table" => "$profile p",
                        "on" => "r.userid = p.userid"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$vehicle v",
                        "on" => "r.vin = v.vin"
                    ]
                ],
                ["r.*", "p.fullname", "v.*"],
                [],
                ["order" => "r.id DESC"]
            );
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'VerificationService::fetchAllVerificationRequest', ['userid' => $_SESSION['userid']], $th);
            Response::error(500, "An error occurred while fetching verification requests");
        }
    }

    public static function sendVerificationRequest($id)
    {
        $request = self::fetchVerificationRequest($id);
        if (empty($request)) {
            Response::error(404, "request not found");
        }
        Response::success($request[0], "request found");
    }

    public static function sendAllVerificationRequest()
    {
        $requests = self::fetchAllVerificationRequest();
        if (empty($requests)) {
            Response::error(404, "requests not found");
        }
        Response::success($requests, "requests found");
    }
    public function createNewRequest($data)
    {
        try {
            $reference = $data['reference'];
            $verificationTable = Utility::$verifications_tbl;
            $transactionTable = Utility::$transaction_tbl;

            if (!$reference) Response::error(404, "Reference not supplied");

            $verification = Paystack::verifyPaystackPayment($reference);

            if (!$verification['status']) Response::error(401, "Verification failed. " . $verification['message']);

            $paymentData = $verification['data'];
            $amount = $paymentData['amount'] / 100;
            $paymentReference = $paymentData['reference'];


            $verificationData = [
                'userid' => $data['userid'],
                'request_id' => $paymentReference,
                'vin' => $data['vin'],
                'result' => '',
                'source' => '',
                'plan' => '',
                'result' => '',
            ];

            $transactionData = [
                'txnsid' => $paymentReference,
                'amount' => $amount,
                'vin' => $data['vin'],
                'status' => $paymentData['status'] ?? 'pending',
                'user' => $data['userid'],
                'method' => $paymentData['method'] ?? 'card',
                'notes' => $paymentData['metadata'] ?? '',
                'logs' => $data['logs'] ?? '',
                'description' => $data['logs'] ?? '',
            ];

            if (
                Database::insert($verificationTable, $verificationData)
                && TransactionService::saveNewTransaction($transactionData)
            ) {

                Activity::activity([
                    'userid' =>  $data['userid'],
                    'type' => 'verification',
                    'title' => 'verification successful',
                ]);

                Response::success(['payment' => $verificationTable], 'Verification payment successful');
            }
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'VerificationService::createNewRequest', ['userid' => $_SESSION['userid']], $th);
            Response::error(500, "An error occurred while saving verification request");
        }
    }


    public static function updateVerificationRequest($id, $data)
    {
        $verificationTable = Utility::$verifications_tbl;
        $transactionTable = Utility::$transaction_tbl;

        try {
            $find = self::fetchVerificationRequest($id);
            if (empty($find)) Response::error(404, "Verifications request not found");
            $verification = $find[0];

            $updateArray = [
                'status' => $data['status'] ?? $verification['status'],
                'notes' => $data['notes'] ?? $verification['notes'],
                'logs' => $data['logs'] ?? $verification['logs'],
            ];
            if (
                Database::update($verificationTable,  $updateArray, ["transaction_id" => $id])
            ) {
                Activity::activity([
                    'userid' =>  $_SESSION['userid'],
                    'type' => 'update',
                    'title' => 'verification update successful',
                ]);
                Response::success([], "Verification Request update Successful");
            }
        } catch (\Throwable $th) {

            Utility::log($th->getMessage(), 'error', 'VerificationService::updateVerificationRequest', ['userid' => $_SESSION['userid']], $th);
            Response::error(500, "An error occurred while updating verification request");
        }
    }

    public function deleteVerificationRequest($id)
    {
        $verificationTable = Utility::$verifications_tbl;

        try {
            $find = self::fetchVerificationRequest($id);
            if (empty($find)) Response::error(404, "Verifications request not found");

            if (Database::delete($verificationTable, ["transaction_id" => $id])) {
                if (Activity::activity([
                    'userid' => $_SESSION['userid'],
                    'type' => 'delete',
                    'title' => 'verification delete successful',
                ]));
                Response::success([], "Verification request deleted");
            }
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'VerificationService::deleteVerificationRequest', ['userid' => $_SESSION['userid']], $th);
            Response::error(500, "An error occurred while deleting verification request");
        }
    }
}
