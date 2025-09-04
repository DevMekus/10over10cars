<?php

namespace App\Controllers;

use App\Services\UserService;
use App\Utils\RequestValidator;
use App\Services\DealerService;
use App\Services\NotificationService;
use App\Services\PlansService;
use App\Services\TransactionService;
use App\Services\VehicleService;
use App\Services\VerificationService;
use App\Utils\Response;

class TransactionController
{
    public function index()
    {
        $transactions = TransactionService::fetchAllTransactions();
        if (empty($transactions)) Response::error(404, "transactions not found");
        Response::success($transactions, "transactions found");
    }

    public function findTransaction($id)
    {
        $id = RequestValidator::parseId($id);

        $transaction = TransactionService::fetchTransaction($id);
        if (empty($transaction)) Response::error(404, "transaction not found");

        Response::success($transaction, "transaction found");
    }

    public function deleteTransaction($id)
    {
        $id = RequestValidator::parseId($id);
        if (TransactionService::deleteTransaction($id))
            Response::success([], 'Transaction delete');
    }
}
