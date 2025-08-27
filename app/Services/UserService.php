<?php

namespace App\Services;

use App\Utils\Response;
use App\Middleware\AuthMiddleware;
use App\Services\Activity;
use App\Utils\Utility;
use App\Utils\MailClient;
use configs\Database;

class UserService
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
            ];

            if (Database::insert($profile, $userProfile) && Database::insert($accounts, $userAccount)) {
                unset($data['user_password']);
                Activity::activity([
                    'userid' => $userid,
                    'type' => 'register',
                    'title' => 'registration successful',
                ]);
                //self::registrationEmail($data['fullname'], $data['email_address']);
                Response::success(['user' => $data], 'User registration successful');
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

            header('Authorization: Bearer null');
            if (Activity::activity([
                'userid' => $data['userid'],
                'type' => 'logout',
                'title' => 'logout successful',
            ])) Response::success([], "User logged out");
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
                Response::success([], "Password reset complete");
            }
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'UserService::resetPassword', ['host' => 'localhost'], $e);
            Response::error(500, "An error has occurred");
        }
    }

    public static function fetchUserDetails($id)
    {
        $profile = Utility::$profile_tbl;
        $accounts = Utility::$accounts_tbl;
        $dealer = Utility::$dealers_tbl;
        try {
            return Database::joinTables(
                "$profile u",
                [
                    [
                        "type" => "LEFT",
                        "table" => "$accounts a",
                        "on" => "u.userid = a.userid"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$dealer d",
                        "on" => "u.userid = d.userid"
                    ]
                ],
                ["u.*", "a.*", "d.company"],
                ["u.userid" => $id]
            );
        } catch (\Throwable $th) {

            Utility::log($th->getMessage(), 'error', 'UserService::userDetail', ['userid' => $id], $th);
            Response::error(500, "An error occurred while fetching user details");
        }
    }

    public static function fetchAllUsersAndData()
    {
        $profile = Utility::$profile_tbl;
        $accounts = Utility::$accounts_tbl;
        $dealer = Utility::$dealers_tbl;
        try {
            return Database::joinTables(
                "$profile u",
                [
                    [
                        "type" => "LEFT",
                        "table" => "$accounts a",
                        "on" => "u.userid = a.userid"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$dealer d",
                        "on" => "u.userid = d.userid"
                    ]
                ],
                ["u.*", "a.*", "d.dealer_name"],
            );
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'UserService::userDetail', ['userid' => $_SESSION['userid']], $th);
            Response::error(500, "An error occurred while fetching user details");
        }
    }


    public static function sendUserDetails($id)
    {
        $user = self::fetchUserDetails($id);

        if (!empty($user)) {
            Response::success($user[0], "User found");
        } else {
            Response::error(404, "User not found");
        }
    }

    public static function sendAllUserInformation()
    {
        $users = self::fetchAllUsersAndData();
        if (!empty($users)) {
            Response::success($users, "Users found");
        } else {
            Response::error(404, "Users not found");
        }
    }

    public static function updateUserInformation($id, $data)
    {
        $profile = Utility::$profile_tbl;
        $accounts = Utility::$accounts_tbl;
        try {
            $userData = self::fetchUserDetails($id);

            if (empty($userData)) Response::error(404, "User not found");
            $user = $userData[0];


            $profileInfo = [
                'fullname' => $data['fullname'] ?? $user['fullname'],
                'fullname' => $data['email_address'] ?? $user['email_address'],
                'user_password' => isset($data['user_password']) ? password_hash($data['user_password'], PASSWORD_BCRYPT) : $user['user_password'],
                'phone' => $data['phone'] ?? $user['phone'],
                'location' => $data['location'] ?? $user['location'],
                'city_state' => $data['city_state'] ?? $user['city_state'],
                'country' => $data['country'] ?? $user['country'],
            ];

            $accountInfo = [
                'status' => $data['status'] ?? $user['status'],
                'role' => $data['role'] ?? $user['role'],
            ];

            if (
                isset($_FILES['dp-upload']) &&
                $_FILES['dp-upload']['error'] === UPLOAD_ERR_OK &&
                is_uploaded_file($_FILES['dp-upload']['tmp_name'])
            ) {

                $target_dir =   "public/UPLOADS/avatar/";

                $user_avatar = Utility::uploadDocuments('dp-upload', $target_dir);

                if (!$user_avatar || !$user_avatar['success']) Response::error(500, "Image upload failed");

                $profileInfo['avatar'] = $user_avatar['files'][0];

                if (isset($user['avatar'])) {
                    $filenameFromUrl = basename($user['avatar']);
                    $target_dir = "../public/UPLOADS/avatars/" . $filenameFromUrl;
                    if (file_exists($target_dir))
                        unlink($target_dir);
                }
            }

            if (
                Database::update($profile,  $profileInfo, ["userid" => $id])
                && Database::update($accounts,  $accountInfo, ["userid" => $id])

            ) {
                Activity::activity([
                    'userid' => $user['userid'],
                    'type' => 'update',
                    'title' => 'logout successful',
                ]);
                $currentUserData = self::fetchUserDetails($id);
                Response::success($currentUserData, "Account update successful");
            }
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'UserService::updateUserInformation', ['userid' => $id], $th);
            Response::error(500, "An error occurred while updating user details");
        }
    }

    public static function deleteUserAccount($id)
    {
        $profile = Utility::$profile_tbl;
        $accounts = Utility::$accounts_tbl;
        try {
            $user = self::fetchUserDetails($id);

            if (empty($user)) Response::error(404, "User not found");

            $userProfile = $user[0];


            if (isset($userProfile['avatar'])) {
                $filenameFromUrl = basename($userProfile['avatar']);
                $target_dir = "../public/UPLOADS/avatars/" . $filenameFromUrl;

                if (file_exists($target_dir)) {
                    unlink($target_dir);
                }
            }



            if (
                Database::delete($profile, ["userid" => $id])
                && Database::delete($accounts, ["userid" => $id])
            ) {
                Activity::activity([
                    'userid' => $_SESSION['userid'],
                    'type' => 'delete',
                    'title' => 'account deleted',
                ]);
                Response::success([], "Account deleted successful");
            }
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'UserService::deleteUserAccount', ['userid' => $id], $th);
            Response::error(500, "An error occurred while deleting user account");
        }
    }
    public static function fetchActivityLogs($id = null)
    {
        $logs = Utility::$loginactivity;
        $profile = Utility::$profile_tbl;

        try {
            return Database::joinTables(
                "$logs l",
                [
                    [
                        "type" => "LEFT",
                        "table" => "$profile p",
                        "on" => "l.userid = p.userid"
                    ]
                ],
                ["l.*", "p.fullname"],
                $id ? ["l.userid" => $id] : [],
                ["order" => "l.activity_id DESC"]
            );
            if (empty($logs)) Response::error(404, "Activity logs not found");
            Response::success($logs, "Activity logs found");
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'UserService::fetchActivityLogs', ['userid' => $_SESSION['userid']], $th);
            Response::error(500, "An error occurred while fetching activity logs");
        }
    }



    public static function sendActivityLog($id)
    {
        $log = self::fetchActivityLogs($id);
        if (empty($log)) {
            Response::error(404, "Activity log not found");
        }
        Response::success($log[0], "Activity log found");
    }

    public static function sendAllActivityLog()
    {
        $log = self::fetchActivityLogs();
        if (empty($log)) {
            Response::error(404, "Activity log not found");
        }
        Response::success($log[0], "Activity log found");
    }
}
