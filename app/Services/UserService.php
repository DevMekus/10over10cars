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
                ["u.*", "a.*", "d.company", "d.status AS company_status"],
                [
                    "OR" => [
                        "u.id" => $id,
                        "u.email_address" => $id,
                        "u.userid" => $id,
                        "a.userid" => $id,
                        "a.id" => $id,
                    ]
                ],
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
                ["u.*", "a.*", "d.company", "d.status AS company_status"],
            );
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'UserService::userDetail', ['userid' => $_SESSION['userid']], $th);
            Response::error(500, "An error occurred while fetching user details");
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
                'fullname' => isset($data['fullname']) ? $data['fullname'] : $user['fullname'],
                'email_address' => isset($data['email_address']) ? $data['email_address'] : $user['email_address'],
                'user_password' => isset($data['user_password']) ? password_hash($data['user_password'], PASSWORD_BCRYPT) : $user['user_password'],
                'phone' => isset($data['phone']) ? $data['phone'] : $user['phone'],
                'location' => isset($data['location']) ? $data['location'] : $user['location'],
                'city_state' => isset($data['city_state']) ? $data['city_state'] : $user['city_state'],
                'country' =>  isset($data['country']) ? $data['country'] : $user['country'],
            ];

            $accountInfo = [
                'status' => isset($data['status']) ? $data['status'] : $user['status'],
                'role' => isset($data['role']) ? $data['role'] : $user['role'],
                'reset_token' => isset($data['reset_token']) ? $data['reset_token'] : $user['reset_token'],
                'reset_token_expiration' => isset($data['reset_token_expiration']) ? $data['reset_token_expiration'] : $user['reset_token'],
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
                Database::update($profile,  $profileInfo, ['userid' => $id])
                && Database::update($accounts,  $accountInfo, ['userid' => $id])

            ) {
                Activity::activity([
                    'userid' => $user['userid'],
                    'type' => 'update',
                    'title' => 'profile update',
                ]);

                return true;
            }
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'UserService::updateUserInformation', ['userid' => $id], $th);
            Response::error(500, "An error occurred while updating user details");
        }
    }

    public static function updateUserPassword() {}

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
                Database::delete($profile, ['userid' => $id])
                && Database::delete($accounts, ['userid' => $id])
            ) {
                Activity::activity([
                    'userid' => $_SESSION['userid'],
                    'type' => 'delete',
                    'title' => 'account deleted',
                ]);
                return true;
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
                ["order" => "l.id DESC"]
            );
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'UserService::fetchActivityLogs', ['userid' => $_SESSION['userid']], $th);
            Response::error(500, "An error occurred while fetching activity logs");
        }
    }
}
