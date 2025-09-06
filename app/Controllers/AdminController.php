<?php

namespace App\Controllers;

use App\Services\AuthService;
use App\Services\UserService;
use App\Utils\RequestValidator;
use App\Services\DealerService;
use App\Services\NotificationService;
use App\Services\PlansService;
use App\Services\TransactionService;
use App\Services\VehicleService;
use App\Services\VerificationService;
use App\Utils\Response;

/**
 * Class AdminController
 *
 * Handles administration-related API endpoints.
 *
 * @package App\Controllers
 */
class AdminController
{
    /**
     * Fetch and return all application data for the admin dashboard.
     *
     * @param string|int $id User ID of the admin (or current user).
     *
     * @return void Sends JSON response
     */
    public function adminApplicationData($id)
    {
        try {
            $data = [
                'verifications'  => VerificationService::fetchAllVerificationRequest(),
                'vehicles'       => VehicleService::fetchAllVehicleInformation(),
                'dealers'        => DealerService::fetchAllDealersInfo(),
                'txns'           => TransactionService::fetchAllTransactions(),
                'loginActivity'  => UserService::fetchActivityLogs(),
                'users'          => UserService::fetchAllUsersAndData(),
                'profile'        => UserService::fetchUserDetails($id),
                'notification'   => NotificationService::fetchAllNotification(),
                'plans'          => PlansService::fetchAllVerificationPlans(),
            ];

            Response::success($data, "Application data retrieved successfully");
        } catch (\Throwable $e) {
            // Centralized error handling
            Response::error(500, "Failed to fetch application data", [
                'exception' => $e->getMessage(),
            ]);
        }
    }
}
