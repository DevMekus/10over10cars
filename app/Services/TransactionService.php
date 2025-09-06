<?php

namespace App\Services;

use App\Utils\Response;
use configs\Database;
use App\Services\Activity;
use App\Utils\MailClient;
use App\Utils\Utility;

/**
 * Class TransactionService
 *
 * Handles CRUD operations and related business logic for transactions.
 * Provides methods to fetch, create, update, and delete transaction records,
 * with related joins to profiles and verifications.
 *
 * @package App\Services
 */
class TransactionService
{
    /**
     * Fetch a single transaction by ID, transaction ID, or user.
     *
     * @param string|int $id Transaction ID, TxnSID, or user identifier.
     * @return array|null Transaction details or null if not found.
     */
    public static function fetchTransaction($id): ?array
    {
        $transaction = Utility::$transaction_tbl;
        $profile = Utility::$profile_tbl;
        $verifications = Utility::$verifications_tbl;

        try {
            return Database::joinTables(
                "$transaction t",
                [
                    [
                        "type"  => "LEFT",
                        "table" => "$verifications v",
                        "on"    => "t.txnsid = v.request_id"
                    ],
                    [
                        "type"  => "LEFT",
                        "table" => "$profile p",
                        "on"    => "p.userid = t.user"
                    ]
                ],
                ["t.*", "p.fullname", "v.plan", "v.status AS vehicle_status"],
                [
                    "OR" => [
                        "t.id"     => $id,
                        "t.txnsid" => $id,
                        "t.user"   => $id,
                    ]
                ],
                ["order" => "t.id DESC"]
            );
        } catch (\Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'TransactionService::fetchTransaction',
                ['userid' => $_SESSION['userid'] ?? null],
                $th
            );
            Response::error(500, "An error occurred while fetching transactions");
        }

        return null;
    }

    /**
     * Fetch all transactions.
     *
     * @return array|null List of transactions or null if failed.
     */
    public static function fetchAllTransactions(): ?array
    {
        $transaction = Utility::$transaction_tbl;
        $profile = Utility::$profile_tbl;
        $verifications = Utility::$verifications_tbl;

        try {
            return Database::joinTables(
                "$transaction t",
                [
                    [
                        "type"  => "LEFT",
                        "table" => "$verifications v",
                        "on"    => "t.txnsid = v.request_id"
                    ],
                    [
                        "type"  => "LEFT",
                        "table" => "$profile p",
                        "on"    => "p.userid = t.user"
                    ]
                ],
                ["t.*", "p.fullname", "v.plan", "v.status AS vehicle_status"],
                [],
                ["order" => "t.id DESC"]
            );
        } catch (\Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'TransactionService::fetchAllTransactions',
                ['userid' => $_SESSION['userid'] ?? null],
                $th
            );
            Response::error(500, "An error occurred while fetching transactions");
        }

        return null;
    }

    /**
     * Save a new transaction record.
     *
     * @param array $data Transaction data.
     * @return bool True if successful, false otherwise.
     */
    public static function saveNewTransaction(array $data): bool
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
                    'userid' => $data['user'] ?? '',
                    'type'   => 'transaction',
                    'title'  => 'new transaction saved',
                ]);
                return true;
            }
        } catch (\Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'TransactionService::saveNewTransaction',
                ['userid' => $_SESSION['userid'] ?? null],
                $th
            );
            Response::error(500, "An error occurred while saving transaction");
        }

        return false;
    }

    /**
     * Update the status of a transaction.
     *
     * @param string|int $id Transaction ID.
     * @param array $data Update data.
     * @return bool True if updated successfully, false otherwise.
     */
    public static function updateTransactionStatus($id, array $data): bool
    {
        try {
            $transactionTable = Utility::$transaction_tbl;
            $exists = self::fetchTransaction($id);

            if (empty($exists)) {
                Response::error(404, "Transaction not found");
            }

            $transaction = $exists[0];

            $update = [
                'status' => $data['status'] ?? $transaction['status'],
            ];

            // NOTE: Ensure no accidental trailing spaces in field names.
            if (Database::update($transactionTable, $update, ['txnsid' => $id])) {
                Activity::activity([
                    'userid' => $_SESSION['userid'] ?? null,
                    'type'   => 'transaction',
                    'title'  => 'transaction updated',
                ]);
                return true;
            }
        } catch (\Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'TransactionService::updateTransactionStatus',
                ['userid' => $_SESSION['userid'] ?? null],
                $th
            );
            Response::error(500, "An error occurred while updating transaction");
        }

        return false;
    }

    /**
     * Delete a transaction record.
     *
     * @param string|int $id Transaction ID.
     * @return bool True if deleted successfully, false otherwise.
     */
    public static function deleteTransaction($id): bool
    {
        try {
            $transactionTable = Utility::$transaction_tbl;
            $exists = self::fetchTransaction($id);

            if (empty($exists)) {
                Response::error(404, "Transaction not found");
            }

            if (Database::delete($transactionTable, ['txnsid' => $id])) {
                Activity::activity([
                    'userid' => $_SESSION['userid'] ?? null,
                    'type'   => 'transaction',
                    'title'  => 'transaction deleted',
                ]);
                return true;
            }
        } catch (\Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'TransactionService::deleteTransaction',
                ['userid' => $_SESSION['userid'] ?? null],
                $th
            );
            Response::error(500, "An error occurred while deleting transaction");
        }

        return false;
    }
}
