<?php

namespace APP\Services;

use App\Models\User;
use App\Utils\Response;
use App\Middleware\AuthMiddleware;
use App\Services\Activity;
use App\Utils\Utility;
use App\Utils\MailClient;


class AuthService
{

    public function attemptLogin($data) //pass
    {
        try {
            $user = User::findByEmail($data['email_address']);
            if (!$user || !password_verify($data['user_password'], $user['user_password'])) {
                Response::error(401, "Invalid email or password");
            }

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
            Utility::log($e->getMessage(), 'error', 'AuthService::attemptLogin', ['host' => 'localhost'], $e);
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
    public function registerUser($data)
    {

        try {
            $existingUser = User::findByEmail($data['email_address']);
            if ($existingUser) {
                Response::error(409, "User already exists");
            }
            $data['userid'] = Utility::generate_uniqueId(10);
            $data['role_id'] = $data['role'];
            $data['home_address'] = "";
            $data['home_state'] = "";
            $data['home_city'] = "";
            $data['country'] = "";
            $data['phone_number'] = "";
            $data['hash_password'] = password_hash($data['user_password'], PASSWORD_BCRYPT);
            $data['account_status'] = $data['role'] == '1' ? 'active' : 'pending';



            $newUser = User::create($data);

            if (!$newUser) Response::error(500, "Registration failed");

            unset($data['hash_password']);
            unset($data['user_password']);


            if (Activity::newActivity([
                'userid' => $data['userid'],
                'actions' => "New member",
            ])) {
                $this->registrationEmail($data['fullname'], $data['email_address']);
                Response::success(['user' => $data], 'User registration successful');
                return;
            }

            Response::error(500, "An error has occurred");
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'AuthService::registerUser', ['host' => 'localhost'], $e);
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

    public function recoverAccount($data) //pass
    {
        try {
            $user = User::findByEmail($data['email_address']);
            if (!$user) Response::error(404, "User not found");

            $token = bin2hex(random_bytes(32));

            date_default_timezone_set('UTC');
            $expiry = (new \DateTime('+2 hour'))->format('Y-m-d H:i:s');

            $data = [
                'reset_token' => $token,
                'reset_token_expiration' => $expiry,
            ];

            if (User::updateUserAccount($user, $data)) {
                $resetLink = BASE_URL . "/auth/reset-password?token=$token";
                $templateData = [
                    '{{logo_url}}' => BASE_URL . 'assets/images/dark-logo.jpg',
                    '{{user_name}}' => $user['fullname'],
                    '{{platform_name}}' => BRAND_NAME,
                    '{{reset_link}}' => $resetLink,
                    '{{support_url}}' => BASE_URL . 'contact-us',
                    '{{current_year}}' => date('Y'),
                    '{{user_email}}' => $user['email_address']
                ];

                if (MailClient::sendMail(
                    $user['email_address'],
                    'Account Recovery',
                    ROOT_PATH . '/app/templates/account_recovery_email.html',
                    $templateData,
                    $user['fullname']
                )) {
                    Response::success([], "A reset link has been sent to your registered email.");
                }
            }
            Response::error(500, "An error has occurred");
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'AuthService::recoverAccount', ['host' => 'localhost'], $e);
        }
    }

    public function resetPassword($data)
    {
        try {
            $validate = User::validateResetToken($data['token']);
            if (!$validate) Response::error(401, "Wrong token presented");

            $user = User::userData($validate['userid']);

            $newPassword = password_hash($data['new_password'], PASSWORD_BCRYPT);
            $newData = [
                'reset_token' => null,
                'reset_token_expiration' => null,
                'user_password' => $newPassword
            ];

            if (
                User::updateUserAccount($user, $newData)
                && User::updateUserProfile($user, $newData)
            ) {
                if (Activity::newActivity([
                    'userid' => $user['userid'],
                    'actions' => 'Reset password',
                ])) {
                    Response::success([], "Password reset complete");
                }
                Response::error(500, "An error has occurred");
            }

            Response::error(500, "An error has occurred");
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'AuthService::resetPassword', ['host' => 'localhost'], $e);
        }
    }
}
