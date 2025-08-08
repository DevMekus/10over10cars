<?php

namespace App\Controllers;

use App\Services\UserService;
use App\Utils\RequestValidator;



class UserController
{
    private $user;
    public function __construct()
    {
        $this->user = new UserService();
    }
    public function login()
    {

        $data = RequestValidator::validate([
            'email_address ' => 'require|email_address',
            'user_password' => 'require|min:6'
        ]);

        $data = RequestValidator::sanitize($data);
        return $this->user->attemptLogin($data);
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

        return $this->user->registerNewUser($data);
    }

    public function logout()
    {
        $data = RequestValidator::validate([
            'userid' => 'require|min:7',
        ]);

        $data = RequestValidator::sanitize($data);

        return $this->user->logoutUser($data);
    }


    public function recover()
    {
        $data = RequestValidator::validate([
            'email_address' => 'require|email_address',
        ]);

        $data = RequestValidator::sanitize($data);

        return $this->user->recoverAccount($data);
    }

    public function reset()
    {
        $data = RequestValidator::validate([
            'token' => 'require|min:10',
            'new_password' => 'require|min:6',
        ]);

        $data = RequestValidator::sanitize($data);
        return $this->user->resetPassword($data);
    }
}
