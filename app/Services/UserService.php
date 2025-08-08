<?php

namespace App\Services;

use App\Utils\Response;
use configs\DB;
use App\Middleware\AuthMiddleware;
use App\Services\Activity;
use App\Utils\Utility;
use App\Utils\MailClient;

class UserService
{
    protected $db;
    protected $profile;
    protected $account;

    public function __construct()
    {
        $this->db = new DB();
        $this->profile = "users_tbl";
        $this->account = "accounts_tbl";
    }

    public function attemptLogin($data)
    {
        try {
            $user = $this->db->joinTables(
                $this->profile,
                [
                    [
                        "type" => "LEFT",
                        "table" => $this->account,
                        "on" => "users_tbl.userid = accounts_tbl.userid"
                    ]
                ],
                ["users_tbl.*", "accounts_tbl.*"],
                ["email_address" => $data['email_address']]
            );


            if (empty($user) || !password_verify($data['user_password'], $user[0]['user_password'])) {
                Response::error(401, "Invalid email or password");
            }

            $user = $user[0] ?? null;

            $this->checkUserStatus($user);
            $token = AuthMiddleware::generateToken([
                'id' => $user['userid'],
                'email' => $user['email_address'],
                'role' => $user['role_id'],
                'exp' => time() + 3600
            ]);
            if (Activity::newActivity([
                'userid' => $user['userid'],
                'actions' => "logged In",
            ])) {
                Response::success(['token' => $token], "Login successful");
            }
            Response::error(500, "An error has occurred");
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'UserService::attemptLogin', ['host' => 'localhost'], $e);
        }
    }

    private function checkUserStatus($user) //passed
    {
        if (
            isset($user['account_status']) && $user['account_status'] !== 'active'
        ) {
            Response::error(401, "Account is not active");
        }

        return true;
    }

    public function registerNewUser($data)
    {
        try {
            $existingUser = $this->db->find("users_tbl", $data['email_address'], 'email_address');
            if ($existingUser) {
                Response::error(409, "User already exists");
            }

            $userid = Utility::generate_uniqueId(10);
            $profile = [
                'userid' => $userid,
                'home_address' => '',
                'home_state' => '',
                'home_city' => '',
                'country' => '',
                'phone_number' => '',
                'user_password' => password_hash($data['user_password'], PASSWORD_BCRYPT),
                'fullname' => $data['fullname'],
                'email_address' => $data['email_address'],
                'avatar' => ''
            ];
            $account = [
                'userid' => $userid,
                'role_id' => $data['role'] ?? '2',
                'account_status' => $data['role'] == '1' ? 'active' : 'pending',
            ];

            if ($this->db->insert($this->profile, $profile) && $this->db->insert($this->account, $account)) {
                unset($data['user_password']);
                Activity::newActivity([
                    'userid' => $userid,
                    'actions' => "New member",
                ]);
                $this->registrationEmail($data['fullname'], $data['email_address']);
                Response::success(['user' => $data], 'User registration successful');
            }
            Response::error(500, "An error has occurred");
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'UserService::registerNewUser', ['host' => 'localhost'], $e);
        }
    }

    private function registrationEmail($username, $email)
    {

        $templateData = [
            '{{logo_url}}' => BASE_URL . 'assets/images/dark-logo.jpg',
            '{{banner_image_url}}' => BASE_URL . 'assets/images/emails/registration_banner.jpeg',
            '{{user_name}}' => $username,
            '{{platform_name}}' => BRAND_NAME,
            '{{login_url}}' => BASE_URL . 'auth/login',
            '{{support_url}}' => BASE_URL . 'contact-us',
            '{{current_year}}' => date('Y'),
        ];

        MailClient::sendMail(
            $email,
            'Welcome to ' . BRAND_NAME,
            ROOT_PATH . '/app/templates/registration.html',
            $templateData,
            $username
        );
    }

    public function logoutUser($data)
    {
        try {

            header('Authorization: Bearer null');
            if (Activity::newActivity([
                'userid' => $data['userid'],
                'actions' => 'Logged out',
            ])) Response::success([], "User logged out");
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'AuthService::logout', ['host' => 'localhost'], $e);
        }
    }

    public function recoverAccount($data)
    {
        try {
            $existingUser = $this->db->find($this->profile, $data['email_address'], 'email_address');
            if (!$existingUser) {
                Response::error(404, "User not found");
            }

            $token = bin2hex(random_bytes(32));

            date_default_timezone_set('UTC');
            $expiry = (new \DateTime('+2 hour'))->format('Y-m-d H:i:s');

            $data = [
                'reset_token' => $token,
                'reset_token_expiration' => $expiry,
            ];


            if ($this->db->update($this->account, $data, ["userid" => $existingUser['userid']])) {
                $resetLink = BASE_URL . "/auth/reset-password?token=$token";

                $templateData = [
                    '{{logo_url}}' => BASE_URL . 'assets/images/dark-logo.jpg',
                    '{{user_name}}' => $existingUser['fullname'],
                    '{{platform_name}}' => BRAND_NAME,
                    '{{reset_link}}' => $resetLink,
                    '{{support_url}}' => BASE_URL . 'contact-us',
                    '{{current_year}}' => date('Y'),
                    '{{user_email}}' => $existingUser['email_address']
                ];

                if (MailClient::sendMail(
                    $existingUser['email_address'],
                    'Account Recovery',
                    ROOT_PATH . '/app/templates/account_recovery_email.html',
                    $templateData,
                    $existingUser['fullname']
                )) {
                    Response::success([], "A reset link has been sent to your registered email.");
                }
            }
            Response::error(500, "An error has occurred");
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'UserService::recoverAccount', ['host' => 'localhost'], $e);
        }
    }

    public function resetPassword($data)
    {
        try {
            $validateToken = $this->db->find($this->account, $data['token'], 'reset_token');
            if (!$validateToken) Response::error(401, "Wrong token presented");
            $profile = [
                'user_password' => password_hash($data['new_password'], PASSWORD_BCRYPT),
            ];
            $account = [
                'reset_token' => null,
                'reset_token_expiration' => null,
            ];
            if (
                $this->db->update($this->profile,  $profile, ["userid" => $validateToken['userid']])
                && $this->db->update($this->account,  $account, ["userid" => $validateToken['userid']])
            ) {
                Activity::newActivity([
                    'userid' => $validateToken['userid'],
                    'actions' => 'Reset password',
                ]);
                Response::success([], "Password reset complete");
            }
            Response::error(500, "An error has occurred");
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'UserService::resetPassword', ['host' => 'localhost'], $e);
        }
    }
}
