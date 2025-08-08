<?php

namespace App\Controllers;

use App\Services\AuthService;
use App\Utils\RequestValidator;



class AuthController
{
    private $authService;
    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function login() //pass
    {
        //validate incoming data
        $data = RequestValidator::validate([
            'email_address ' => 'require|email_address',
            'user_password' => 'require|min:6'
        ]);

        //sanitize
        $data = RequestValidator::sanitize($data);

        return $this->authService->attemptLogin($data);
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

        return $this->authService->registerUser($data);
    }

    public function logout()
    {
        $data = RequestValidator::validate([
            'userid' => 'require|min:7',
        ]);

        $data = RequestValidator::sanitize($data);

        return $this->authService->logoutUser($data);
    }

    public function recover()
    {
        $data = RequestValidator::validate([
            'email_address' => 'require|email_address',
        ]);

        $data = RequestValidator::sanitize($data);

        return $this->authService->recoverAccount($data);
    }

    public function reset()
    {
        $data = RequestValidator::validate([
            'token' => 'require|min:10',
            'new_password' => 'require|min:6',
        ]);

        $data = RequestValidator::sanitize($data);
        return $this->authService->resetPassword($data);
    }
}
