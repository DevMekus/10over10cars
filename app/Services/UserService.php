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
                ["u.*", "a.*", "d.company"],
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
                ["order" => "l.id DESC"]
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
