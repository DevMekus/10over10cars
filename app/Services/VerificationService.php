<?php

namespace App\Services;

use App\Utils\Response;
use configs\DB;
use App\Services\Activity;
use App\Utils\Utility;
use App\Services\Paystack;

class VerificationService
{
    protected $db;
    protected $vehicleInfo;
    protected $verification;
    protected $profile;
    protected $transaction;

    public function __construct()
    {
        $this->db = new DB();
        $this->profile = Utility::$profile_tbl;
        $this->vehicleInfo = Utility::$vinInfo_tbl;
        $this->verification = Utility::$verification_tbl;
        $this->transaction = Utility::$transactions_tbl;
    }

    public function getVerificationRequests()
    {

        try {
            $data = $this->db->joinTables(
                "$this->verification r",
                [
                    [
                        "type" => "LEFT",
                        "table" => "$this->profile p",
                        "on" => "r.userid = p.userid"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$this->vehicleInfo v",
                        "on" => "r.vin = v.vin"
                    ]
                ],
                ["r.*", "p.fullname", "v.vehicle_data"],
                [],
                ["order" => "r.id DESC"]
            );

            if (empty($data)) Response::error(404, "Verifications request not found");
            Response::success($data, "Verifications request found");
        } catch (\Throwable $th) {
            Response::error(500, "An error occurred while fetching verification");
            Utility::log($th->getMessage(), 'error', 'VerificationService::getVerificationRequests', ['userid' => $_SESSION['userid']], $th);
        }
    }

    private function findVerificationRequest($id)
    {
        try {
            return $this->db->joinTables(
                "$this->verification r",
                [
                    [
                        "type" => "LEFT",
                        "table" => "$this->profile p",
                        "on" => "r.userid = p.userid"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$this->vehicleInfo v",
                        "on" => "r.vin = v.vin"
                    ]
                ],
                ["r.*", "p.fullname", "v.vehicle_data"],
                [
                    "OR" => [
                        "r.userid"   => $id,
                        "r.id"       => $id,
                        "r.transaction_id" => $id,
                        "r.vin" => $id
                    ]
                ],
                ["order" => "r.id DESC"]
            );
        } catch (\Throwable $th) {
            Response::error(500, "An error occurred while fetching verification");
            Utility::log($th->getMessage(), 'error', 'VerificationService::getVerificationRequests', ['userid' => $_SESSION['userid']], $th);
        }
    }


    public function getVerificationRequest($id)
    {

        try {
            $data = $this->db->joinTables(
                "$this->verification r",
                [
                    [
                        "type" => "LEFT",
                        "table" => "$this->profile p",
                        "on" => "r.userid = p.userid"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$this->vehicleInfo v",
                        "on" => "r.vin = v.vin"
                    ]
                ],
                ["r.*", "p.fullname", "v.vehicle_data"],
                [
                    "OR" => [
                        "r.userid"   => $id,
                        "r.id"       => $id,
                        "r.transaction_id" => $id,
                        "r.vin" => $id
                    ]
                ],
                ["order" => "r.id DESC"]
            );

            if (empty($data)) Response::error(404, "Verifications request not found");
            Response::success($data, "Verifications request found");
        } catch (\Throwable $th) {
            Response::error(500, "An error occurred while fetching verification");
            Utility::log($th->getMessage(), 'error', 'VerificationService::getVerificationRequests', ['userid' => $_SESSION['userid']], $th);
        }
    }

    public function createNewRequest($data)
    {
        $reference = $data['reference'];
        if (!$reference) Response::error(404, "Reference not supplied");

        $verification = Paystack::verifyPaystackPayment($reference);



        if (!$verification['status']) Response::error(401, "Verification failed. " . $verification['message']);

        $paymentData = $verification['data'];

        $amount = $paymentData['amount'] / 100;
        $email = $paymentData['customer']['email'];
        $paymentReference = $paymentData['reference'];


        $verificationTable = [
            'transaction_id' => $paymentReference,
            'userid' => $data['userid'],
            'vin' => $data['vin'],
        ];

        $transactionsTable = [
            'user_id' => $data['userid'],
            'email' => $email,
            'vin' => $data['vin'],
            'reference' => $paymentReference,
            'amount' =>  $amount,
            'currency' => $paymentData['currency'] ?? 'NGN',
            'status' =>  'success',
            'channel' => $paymentData['channel'] ?? 'paystack',
            'payment_method' => $data['method'] ?? 'card',
            'metadata' => null,
        ];
        //   && $this->db->insert($this->transaction, $transactionsTable)

        if (
            $this->db->insert($this->verification, $verificationTable)
            && $this->db->insert($this->transaction, $transactionsTable)
        ) {

            Activity::newActivity([
                'userid' =>  $data['userid'],
                'actions' => "Verification payment successful",
            ]);

            Response::success(['payment' => $verificationTable], 'Verification payment successful');
        }
        Response::error(500, "An error has occurred");
    }

    public function updateVerificationRequest($id, $data)
    {
        try {
            $find = $this->findVerificationRequest($id);
            if (empty($find)) Response::error(404, "Verifications request not found");
            $verification = $find[0];

            $updateArray = [
                'status' => $data['status'] ?? $verification['status']
            ];
            if (
                $this->db->update($this->verification,  $updateArray, ["transaction_id" => $id])
            ) {
                Activity::newActivity([
                    'userid' =>  $_SESSION['userid'],
                    'actions' => 'Verification Request updated',
                ]);
                Response::success([], "Verification Request update Successful");
            }
            Response::error(500, "An error has occurred");
        } catch (\Throwable $th) {
            Response::error(500, "An error occurred while updating verification request");
            Utility::log($th->getMessage(), 'error', 'VerificationService::updateVerificationRequest', ['userid' => $_SESSION['userid']], $th);
        }
    }

    public function deleteVerificationRequest($id)
    {
        try {
            $find = $this->findVerificationRequest($id);
            if (empty($find)) Response::error(404, "Verifications request not found");

            if ($this->db->delete($this->verification, ["transaction_id" => $id])) {
                if (Activity::newActivity([
                    'userid' => $_SESSION['userid'],
                    'actions' => 'Verification request deleted',
                ]));
                Response::success([], "Verification request deleted");
            }

            Response::error(500, "An error has occurred");
        } catch (\Throwable $th) {
            Response::error(500, "An error occurred while deleting verification request");
            Utility::log($th->getMessage(), 'error', 'VerificationService::deleteVerificationRequest', ['userid' => $_SESSION['userid']], $th);
        }
    }
}
