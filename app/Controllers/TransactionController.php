<?php

namespace App\Controllers;

use App\Services\TransactionService;
use App\Utils\RequestValidator;
use App\Utils\Response;

/**
 * Class TransactionController
 *
 * Handles operations related to transactions such as
 * listing, retrieving, and deleting transactions.
 */
class TransactionController
{
    /**
     * Retrieve all transactions.
     *
     * @return void
     */
    public function index(): void
    {
        try {
            $transactions = TransactionService::fetchAllTransactions();

            if (empty($transactions)) {
                Response::error(404, "Transactions not found");
                return;
            }

            Response::success($transactions, "Transactions found");
        } catch (\Throwable $e) {
            Response::error(500, "Error fetching transactions: " . $e->getMessage());
        }
    }

    /**
     * Retrieve a specific transaction by ID.
     *
     * @param mixed $id Transaction ID
     * @return void
     */
    public function findTransaction($id): void
    {
        try {
            $id = RequestValidator::parseId($id);

            $transaction = TransactionService::fetchTransaction($id);

            if (empty($transaction)) {
                Response::error(404, "Transaction not found");
                return;
            }

            Response::success($transaction, "Transaction found");
        } catch (\Throwable $e) {
            Response::error(500, "Error fetching transaction: " . $e->getMessage());
        }
    }

    /**
     * Delete a specific transaction by ID.
     *
     * @param mixed $id Transaction ID
     * @return void
     */
    public function deleteTransaction($id): void
    {
        try {
            $id = RequestValidator::parseId($id);

            $deleted = TransactionService::deleteTransaction($id);

            if ($deleted) {
                Response::success([], "Transaction deleted successfully");
                return;
            }

            Response::error(500, "Transaction deletion failed");
        } catch (\Throwable $e) {
            Response::error(500, "Error deleting transaction: " . $e->getMessage());
        }
    }
}
