<?php

namespace App\Services;

use App\Utils\Response;
use configs\Database;
use App\Services\Activity;
use App\Utils\MailClient;
use App\Utils\Utility;

class TransactionService
{

    public static function fetchTransaction($id)
    {
        $transaction = Utility::$transaction_tbl;
        $profile = Utility::$profile_tbl;
        $verifications = Utility::$verifications_tbl;
        try {
            return Database::joinTables(
                "$transaction t",
                [
                    [
                        "type" => "LEFT",
                        "table" => "$verifications v",
                        "on" => "t.txnsid = v.request_id"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$profile p",
                        "on" => "p.userid = t.user"
                    ]
                ],
                ["t.*", "p.fullname", "v.plan", "v.status AS vehicle_status",],
                [
                    "OR" => [
                        "t.id" => $id,
                        "t.txnsid" => $id,
                        "t.user" => $id,
                    ]
                ],
                ["order" => "t.id DESC"]
            );
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'TransactionService::fetchTransaction', ['userid' => $_SESSION['userid']], $th);
            Response::error(500, "An error occurred while fetching transactions");
        }
    }

    public static function fetchAllTransactions()
    {
        $transaction = Utility::$transaction_tbl;
        $profile = Utility::$profile_tbl;
        $verifications = Utility::$verifications_tbl;
        try {
            return Database::joinTables(
                "$transaction t",
                [
                    [
                        "type" => "LEFT",
                        "table" => "$verifications v",
                        "on" => "t.txnsid = v.request_id"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$profile p",
                        "on" => "p.userid = t.user"
                    ]
                ],
                ["t.*", "p.fullname", "v.plan", "v.status AS vehicle_status",],
                [],
                ["order" => "t.id DESC"]
            );
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'TransactionService::fetchAllTransactions', ['userid' => $_SESSION['userid']], $th);
            Response::error(500, "An error occurred while fetching transactions");
        }
    }



    public static function saveNewTransaction($data)
    {
        try {
            $txnsid = $data['txnsid'];
            $transactionTable = Utility::$transaction_tbl;

            $exists = self::fetchTransaction($txnsid);

            if (!empty($exists)) {
                Response::error(409, "Transaction already exists");
            }

            if (Database::insert($transactionTable, $data)) {
                Activity::activity([
                    'userid' =>  $data['user'] ?? '',
                    'type' => 'transaction',
                    'title' => 'new transaction saved',
                ]);

                return true;
            }
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'TransactionService::saveNewTransaction', ['userid' => $_SESSION['userid']], $th);
            Response::error(500, "An error occurred while saving transaction");
        }
    }

    public static function updateTransactionStatus($id, $data)
    {
        try {

            $transactionTable = Utility::$transaction_tbl;
            $exists = self::fetchTransaction($id);

            if (empty($exists)) {
                Response::error(404, "Transaction not found");
            }

            $transaction = $exists[0];

            $update = [
                'status' => isset($data['status']) ? $data['status'] : $transaction['status'],
            ];

            if (Database::update($transactionTable, $update, ['txnsid ' => $id])) {
                Activity::activity([
                    'userid' =>  $_SESSION['userid'],
                    'type' => 'transaction',
                    'title' => 'transaction updated',
                ]);

                return true;
            }
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'TransactionService::updateTransactionStatus', ['userid' => $_SESSION['userid']], $th);
            Response::error(500, "An error occurred while updating transaction");
        }
    }

    public static function deleteTransaction($id)
    {
        try {

            $transactionTable = Utility::$transaction_tbl;
            $exists = self::fetchTransaction($id);

            if (empty($exists)) {
                Response::error(404, "Transaction not found");
            }


            if (Database::delete($transactionTable, ['txnsid' => $id])) {
                Activity::activity([
                    'userid' =>  $_SESSION['userid'],
                    'type' => 'transaction',
                    'title' => 'transaction deleted',
                ]);

                return true;
            }
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'TransactionService::deleteTransaction', ['userid' => $_SESSION['userid']], $th);
            Response::error(500, "An error occurred while deleting transaction");
        }
    }
}
