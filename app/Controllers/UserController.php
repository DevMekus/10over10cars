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

    public function userProfile($id)
    {
        $id = RequestValidator::parseId($id);
        $user = UserService::fetchUserDetails($id);
        if (!empty($user)) Response::success($user, 'user information');
    }

    public function usersProfiles()
    {
        $users = UserService::fetchAllUsersAndData();

        if (!empty($users)) Response::success($users, 'users information');
    }

    public function updateUserProfile($id)
    {
        $id = RequestValidator::parseId($id);
        $data = $_POST;
        $data = RequestValidator::sanitize($data);

        $update = UserService::updateUserInformation($id, $data);
        if ($update) {
            //$user = UserService::fetchUserDetails($id);
            Response::success([], 'Profile update successful');
        }
    }

    public function deleteUserProfile($id)
    {
        $id = RequestValidator::parseId($id);
        $delete = UserService::deleteUserAccount($id);
        if ($delete) Response::success([], 'User account deleted');
    }

    public function fetchUserActivity($id)
    {
        $id = RequestValidator::parseId($id);
        $activity = UserService::fetchActivityLogs($id);
        if (!empty($activity)) Response::success($activity, "user activity");
        Response::error(404, "user activity not found");
    }
}
