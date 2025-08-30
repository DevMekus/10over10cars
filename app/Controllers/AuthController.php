<?php

namespace App\Controllers;

use App\Services\AuthService;
use App\Utils\RequestValidator;
use App\Utils\Response;


class AuthController
{

    public function login()
    {

        $data = RequestValidator::validate([
            'email_address ' => 'require|email_address',
            'user_password' => 'require|min:6'
        ]);

        AuthService::attemptLogin($data);
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

        $register = AuthService::createAccount($data);

        if ($register) {
            Response::success([], 'User registration successful');
        }
    }

    public function logout()
    {
        $data = RequestValidator::validate([
            'userid' => 'require|min:7',
        ]);

        $data = RequestValidator::sanitize($data);

        $logout = AuthService::logoutUser($data);
        if ($logout) Response::success([], "User logged out");
    }

    public function recoverAccount()
    {
        $data = RequestValidator::validate([
            'email_address' => 'require|email_address',
        ]);

        $data = RequestValidator::sanitize($data);

        $recover = AuthService::recoverAccount($data);
        if ($recover) {
            Response::success([], "A reset link has been sent to your registered email.");
        }
    }
    public function resetAccountPassword()
    {
        $data = RequestValidator::validate([
            'token' => 'require|min:10',
            'new_password' => 'require|min:6',
        ]);

        $data = RequestValidator::sanitize($data);
        $reset = AuthService::resetPassword($data);
        if ($reset) {
            Response::success([], "Password reset complete");
        }
    }
}
