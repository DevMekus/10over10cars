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


class UserController
{

    public function guestApplicationData()
    {
        //----Returning all the application data
        $data = [
            'plans' => PlansService::fetchAllVerificationPlans(),
            'vehicles' => VehicleService::fetchAllVehicleInformation(),
        ];

        Response::success($data, "Application data");
    }


    public function userApplicationData($id)
    {
        //----Returning all the application data
        $id =  RequestValidator::parseId($id);
        $data = [
            'verifications' => VerificationService::fetchVerificationRequest($id),
            'vehicles' => VehicleService::fetchVehicleInformation($id),
            'dealers' => DealerService::fetchDealerInformation($id),
            'txns' => TransactionService::fetchTransaction($id),
            'loginActivity' => UserService::fetchActivityLogs($id),
            'profile' => UserService::fetchUserDetails($id),
            'notification' => NotificationService::fetchAllNotification(),
            'plans' => PlansService::fetchAllVerificationPlans(),
        ];
        Response::success($data, "Application data");
    }




    // public function findUser($id)
    // {
    //     $id = RequestValidator::parseId($id);
    //     UserService::sendUserDetails($id);
    // }

    // public function updateProfile($id)
    // {
    //     $id = RequestValidator::parseId($id);
    //     $data = $_POST;

    //     $data = RequestValidator::sanitize($data);
    //     UserService::updateUserInformation($id, $data);
    // }
}
