<?php

namespace App\Controllers;

use App\Services\UserService;
use App\Utils\RequestValidator;
use App\Services\DealerService;
use App\Services\VehicleService;
use App\Services\VerificationService;
use App\Utils\Response;


class UserController
{

    public function guestApplicationData()
    {
        //----Returning all the application data

        $data = [
            'plan' => '',
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
            'txns' => '',
            'loginActivity' => UserService::fetchActivityLogs($id),
            'profile' => UserService::fetchUserDetails($id),
            'notification' => '',
        ];
        Response::success($data, "Application data");
    }


    public function login()
    {

        $data = RequestValidator::validate([
            'email_address ' => 'require|email_address',
            'user_password' => 'require|min:6'
        ]);

        UserService::attemptLogin($data);
    }

    public function register() //pass
    {
        $data = RequestValidator::validate([
            'fullname' => 'require|min:3',
            'email_address' => 'required|email_address',
            'user_password' => 'required|min:6',
            'role' => 'required|min:1'
        ]);

        $data = RequestValidator::sanitize($data);

        UserService::createAccount($data);
    }

    public function logout()
    {
        $data = RequestValidator::validate([
            'userid' => 'require|min:7',
        ]);

        $data = RequestValidator::sanitize($data);

        UserService::logoutUser($data);
    }

    public function recover()
    {
        $data = RequestValidator::validate([
            'email_address' => 'require|email_address',
        ]);

        $data = RequestValidator::sanitize($data);

        UserService::recoverAccount($data);
    }
    public function reset()
    {
        $data = RequestValidator::validate([
            'token' => 'require|min:10',
            'new_password' => 'require|min:6',
        ]);

        $data = RequestValidator::sanitize($data);
        UserService::resetPassword($data);
    }

    public function findUser($id)
    {
        $id = RequestValidator::parseId($id);
        UserService::sendUserDetails($id);
    }

    public function updateProfile($id)
    {
        $id = RequestValidator::parseId($id);
        $data = $_POST;

        $data = RequestValidator::sanitize($data);
        UserService::updateUserInformation($id, $data);
    }

    public function findADealer($id)
    {
        $id = RequestValidator::parseId($id);
        DealerService::sendDealerInformation($id);
    }

    public function dealerRegistration()
    {

        $data = RequestValidator::validate([
            'company' => 'require|min:3',
            'userid' => 'required|address',
            'contact' => 'required|city',
            'phone' => 'required|country',
            'state' => 'required|state',
            'about' => 'required|state'
        ], $_POST);

        $data = RequestValidator::sanitize($data);
        DealerService::saveNewDealerInformation($data);
    }

    public function updateDealerInfo($id)
    {
        $id = RequestValidator::parseId($id);
        $data = RequestValidator::validate([
            'status' => 'require',
        ]);
        $data = RequestValidator::sanitize($data);
        DealerService::updateDealerAccount($id, $data);
    }
}
