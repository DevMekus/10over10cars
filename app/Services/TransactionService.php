<?php

namespace App\Services;

use App\Utils\Response;
use configs\Database;
use App\Services\Activity;
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
                        "on" => "p.userid = v.userid"
                    ]
                ],
                ["t.*", "p.fullname", "v.*"],
                [
                    "OR" => [
                        "t.id" => $id,
                        "t.txnsid" => $id,
                        "v.vin" => $id,
                        "v.userid" => $id,
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
                        "on" => "p.userid = v.userid"
                    ]
                ],
                ["t.*", "p.fullname", "v.*"],
                [],
                ["order" => "t.id DESC"]
            );
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'TransactionService::fetchAllTransactions', ['userid' => $_SESSION['userid']], $th);
            Response::error(500, "An error occurred while fetching transactions");
        }
    }

    public static function sendTransaction($id)
    {
        $data = self::fetchAllTransactions($id);
        if (empty($data)) {
            Response::error(404, "Transaction not found");
        }
        Response::success($data[0], "Transaction found");
    }

    public static function sendAllTransaction()
    {
        $data = self::fetchAllTransactions();
        if (empty($data)) {
            Response::error(404, "Transaction not found");
        }
        Response::success($data, "Transaction found");
    }

    public static function saveNewTransaction($data)
    {
        try {
            $txnsid = $data['txnsid'];
            $transactionTable = Utility::$transaction_tbl;

            $data = self::fetchAllTransactions($txnsid);
            if (!empty($data)) {
                Response::error(404, "Transaction already exists");
            }

            if (Database::insert($transactionTable, $data)) {
                Activity::activity([
                    'userid' =>  $data['user'],
                    'type' => $data['transaction'],
                    'title' => $data['description'],
                ]);
                return true;
            }
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'TransactionService::saveNewTransaction', ['userid' => $_SESSION['userid']], $th);
            return false;
        }
    }
}
