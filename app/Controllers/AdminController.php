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
use GrahamCampbell\ResultType\Result;

class AdminController
{


    public function adminApplicationData($id)
    {
        //----Returning all the application data
        $data = [
            'verifications' => VerificationService::fetchAllVerificationRequest(),
            'vehicles' => VehicleService::fetchAllVehicleInformation(),
            'dealers' => DealerService::fetchAllDealersInfo(),
            'txns' => TransactionService::fetchAllTransactions(),
            'loginActivity' => UserService::fetchActivityLogs(),
            'users' => UserService::fetchAllUsersAndData(),
            'profile' => UserService::fetchUserDetails($id),
            'notification' => NotificationService::fetchAllNotification(),
            'plans' => PlansService::fetchAllVerificationPlans(),
        ];
        Response::success($data, "Application data");
    }
}
