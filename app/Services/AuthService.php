<?php

namespace App\Services;

use App\Utils\Response;
use App\Middleware\AuthMiddleware;
use App\Services\Activity;
use App\Utils\Utility;
use App\Utils\MailClient;
use configs\Database;

class AuthService
{
    public static function attemptLogin($data)
    {

        $profile = Utility::$profile_tbl;
        $accounts = Utility::$accounts_tbl;
        try {
            $user = Database::joinTables(
                $profile,
                [
                    [
                        "type" => "LEFT",
                        "table" => $accounts,
                        "on" => "$profile.userid = $accounts.userid"
                    ]
                ],
                ["$profile.*", "$accounts.*"],
                ["email_address" => $data['email_address']]
            );


            if (empty($user) || !password_verify($data['user_password'], $user[0]['user_password'])) {
                Response::error(401, "Invalid email or password");
            }

            $user = $user[0] ?? null;



            self::checkUserStatus($user);
            $token = AuthMiddleware::generateToken([
                'userid' => $user['userid'],
                'email' => $user['email_address'],
                'role' => $user['role'],
                'exp' => time() + 3600
            ]);

            //--Save session
            $sessions_tbl = Utility::$sessions_tbl;
            $device = Utility::getUserDevice();
            $ip = Utility::getUserIP();

            $session = [
                'userid' => $user['userid'],
                'session_token' =>  $token,
                'device' => $device,
                'ip_address' => $ip,
            ];

            Database::insert($sessions_tbl, $session);

            if (Activity::activity([
                'userid' => $user['userid'],
                'type' => 'login',
                'title' => 'login successful',
            ])) {
                Response::success(['token' => $token], "Login successful");
            }
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'UserService::attemptLogin', ['host' => 'localhost'], $e);
            Response::error(500, "An error has occurred");
        }
    }

    private static function checkUserStatus($user) //passed
    {
        //----Check if the 2F Authentication is ON
        if (
            isset($user['account_status']) && $user['account_status'] !== 'active'
        ) {
            Response::error(401, "Account is not active");
        }

        return true;
    }

    public static function createAccount($data)
    {
        $profile = Utility::$profile_tbl;
        $accounts = Utility::$accounts_tbl;
        try {
            $existingUser = Database::find($profile, $data['email_address'], 'email_address');
            if ($existingUser) {
                Response::error(409, "User already exists");
            }

            $userid = Utility::generate_uniqueId(10);

            $userProfile = [
                'userid' => $userid,
                'fullname' => $data['fullname'],
                'email_address' => $data['email_address'],
                'user_password' => password_hash($data['user_password'], PASSWORD_BCRYPT),
                'phone' => '',
                'location' => '',
                'city_state' => '',
                'country' => '',
                'avatar' => ''
            ];

            $userAccount = [
                'userid' => $userid,
                'status' => $data['role'] !== 'dealer' ? 'active' : 'pending',
                'role' => $data['role'] ?? 'user',
                'memberSince' => date('y-m-d', time()),
            ];

            if (Database::insert($profile, $userProfile) && Database::insert($accounts, $userAccount)) {
                unset($data['user_password']);
                Activity::activity([
                    'userid' => $userid,
                    'type' => 'registration',
                    'title' => 'registration successful',
                ]);
                //self::registrationEmail($data['fullname'], $data['email_address']);
                return true;
            }
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'UserService::registerNewUser', ['host' => 'localhost'], $e);
            Response::error(500, "An error has occurred");
        }
    }

    private static function registrationEmail($username, $email)
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

    public static function logoutUser($data)
    {
        try {
            self::revokeSession($data['userid']);

            header('Authorization: Bearer null');

            Activity::activity([
                'userid' => $data['userid'] ?? $_SESSION['userid'],
                'type' => 'logout',
                'title' => 'logout successful',
            ]);
            return true;
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'AuthService::logout', ['host' => 'localhost'], $e);
            Response::error(500, "An error has occurred");
        }
    }

    public static function recoverAccount($data)
    {
        $profile = Utility::$profile_tbl;
        $accounts = Utility::$accounts_tbl;
        try {
            $existingUser = Database::find($profile, $data['email_address'], 'email_address');
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


            if (Database::update($accounts, $data, ["userid" => $existingUser['userid']])) {
                $resetLink = BASE_URL . "auth/reset-password?token=$token";

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
                    ROOT_PATH . '/app/Services/templates/reset_password.html',
                    $templateData,
                    $existingUser['fullname']
                )) {
                    return true;
                }
            }
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'UserService::recoverAccount', ['host' => 'localhost'], $e);
            Response::error(500, "An error has occurred");
        }
    }

    public static function resetPassword($data)
    {
        $profile = Utility::$profile_tbl;
        $accounts = Utility::$accounts_tbl;
        try {
            $validateToken = Database::find($accounts, $data['token'], 'reset_token');
            if (!$validateToken) Response::error(401, "Wrong token presented");
            $userProfile = [
                'user_password' => password_hash($data['new_password'], PASSWORD_BCRYPT),
            ];
            $userAccount = [
                'reset_token' => null,
                'reset_token_expiration' => null,
            ];
            if (
                Database::update($profile,  $userProfile, ["userid" => $validateToken['userid']])
                && Database::update($accounts,  $userAccount, ["userid" => $validateToken['userid']])
            ) {
                Activity::activity([
                    'userid' => $validateToken['userid'],
                    'type' => 'update',
                    'title' => 'password reset successful',
                ]);
                return true;
            }
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'UserService::resetPassword', ['host' => 'localhost'], $e);
            Response::error(500, "An error has occurred");
        }
    }

    public static function userSessions($id)
    {
        try {
            $session_tbl = Utility::$sessions_tbl;
            $profile = Utility::$profile_tbl;

            return Database::joinTables(
                "$session_tbl s",
                [
                    [
                        "type" => "LEFT",
                        "table" => "$profile p",
                        "on" => "s.userid = p.userid"
                    ],

                ],
                ["s.*", "p.fullname", "p.email_address"],
                [
                    "OR" => [
                        "s.id" => $id,
                        "s.userid" => $id,
                        "p.email_address" => $id,
                        "p.userid" => $id,
                    ]
                ],
                ["s.userid" => $id]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'UserService::userSessions', ['host' => 'localhost'], $e);
            Response::error(500, "An error has occurred");
        }
    }


    public static function activeSessions()
    {
        try {
            $session_tbl = Utility::$sessions_tbl;
            $profile = Utility::$profile_tbl;

            return Database::joinTables(
                "$session_tbl s",
                [
                    [
                        "type" => "LEFT",
                        "table" => "$profile p",
                        "on" => "s.userid = p.userid"
                    ],

                ],
                ["s.*", "p.fullname", "p.email_address"],

            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'UserService::activeSessions', ['host' => 'localhost'], $e);
            Response::error(500, "An error has occurred");
        }
    }

    public static function revokeSession($sessionId)
    {
        try {
            $session_tbl = Utility::$sessions_tbl;
            return Database::delete($session_tbl, ['userid' => $sessionId]);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'UserService::revokeSession', ['host' => 'localhost'], $e);
            Response::error(500, "An error has occurred");
        }
    }
}
