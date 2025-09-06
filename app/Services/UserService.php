<?php

namespace App\Services;

use App\Utils\Response;
use App\Middleware\AuthMiddleware;
use App\Services\Activity;
use App\Utils\Utility;
use App\Utils\MailClient;
use configs\Database;

/**
 * Class UserService
 *
 * Handles user profile, accounts, and dealer-related CRUD operations.
 * Provides utilities for fetching user details, updating info, deleting accounts,
 * and retrieving user activity logs.
 *
 * @package App\Services
 */
class UserService
{
    /**
     * Fetch user details with related account and dealer information.
     *
     * @param string|int $id User identifier (id, email, or userid).
     * @return array|null User details or null if not found.
     */
    public static function fetchUserDetails($id): ?array
    {
        $profile = Utility::$profile_tbl;
        $accounts = Utility::$accounts_tbl;
        $dealer = Utility::$dealers_tbl;

        try {
            return Database::joinTables(
                "$profile u",
                [
                    [
                        "type"  => "LEFT",
                        "table" => "$accounts a",
                        "on"    => "u.userid = a.userid"
                    ],
                    [
                        "type"  => "LEFT",
                        "table" => "$dealer d",
                        "on"    => "u.userid = d.userid"
                    ]
                ],
                ["u.*", "a.*", "d.company", "d.status AS company_status"],
                [
                    "OR" => [
                        "u.id"            => $id,
                        "u.email_address" => $id,
                        "u.userid"        => $id,
                        "a.userid"        => $id,
                        "a.id"            => $id,
                    ]
                ],
                ["u.userid" => $id]
            );
        } catch (\Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'UserService::fetchUserDetails',
                ['userid' => $id],
                $th
            );
            Response::error(500, "An error occurred while fetching user details");
        }

        return null;
    }

    /**
     * Fetch all users with related account and dealer data.
     *
     * @return array|null List of all users or null if query fails.
     */
    public static function fetchAllUsersAndData(): ?array
    {
        $profile = Utility::$profile_tbl;
        $accounts = Utility::$accounts_tbl;
        $dealer = Utility::$dealers_tbl;

        try {
            return Database::joinTables(
                "$profile u",
                [
                    [
                        "type"  => "LEFT",
                        "table" => "$accounts a",
                        "on"    => "u.userid = a.userid"
                    ],
                    [
                        "type"  => "LEFT",
                        "table" => "$dealer d",
                        "on"    => "u.userid = d.userid"
                    ]
                ],
                ["u.*", "a.*", "d.company", "d.status AS company_status"]
            );
        } catch (\Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'UserService::fetchAllUsersAndData',
                ['userid' => $_SESSION['userid'] ?? null],
                $th
            );
            Response::error(500, "An error occurred while fetching user details");
        }

        return null;
    }

    /**
     * Update user profile and account information.
     *
     * @param string|int $id User identifier.
     * @param array $data Fields to update.
     * @return bool True if updated successfully, false otherwise.
     */
    public static function updateUserInformation($id, array $data): bool
    {
        $profile = Utility::$profile_tbl;
        $accounts = Utility::$accounts_tbl;

        try {
            $userData = self::fetchUserDetails($id);
            if (empty($userData)) {
                Response::error(404, "User not found");
            }

            $user = $userData[0];

            // Build profile update data
            $profileInfo = [
                'fullname'       => $data['fullname'] ?? $user['fullname'],
                'email_address'  => $data['email_address'] ?? $user['email_address'],
                'user_password'  => isset($data['user_password'])
                    ? password_hash($data['user_password'], PASSWORD_BCRYPT)
                    : $user['user_password'],
                'phone'          => $data['phone'] ?? $user['phone'],
                'location'       => $data['location'] ?? $user['location'],
                'city_state'     => $data['city_state'] ?? $user['city_state'],
                'country'        => $data['country'] ?? $user['country'],
            ];

            // Build account update data
            $accountInfo = [
                'status'                => $data['status'] ?? $user['status'],
                'role'                  => $data['role'] ?? $user['role'],
                'reset_token'           => $data['reset_token'] ?? $user['reset_token'],
                'reset_token_expiration' => $data['reset_token_expiration'] ?? $user['reset_token_expiration'],
            ];

            // Handle avatar upload
            if (
                isset($_FILES['dp-upload']) &&
                $_FILES['dp-upload']['error'] === UPLOAD_ERR_OK &&
                is_uploaded_file($_FILES['dp-upload']['tmp_name'])
            ) {
                $targetDir = "public/UPLOADS/avatar/";
                $userAvatar = Utility::uploadDocuments('dp-upload', $targetDir);

                if (!$userAvatar || !$userAvatar['success']) {
                    Response::error(500, "Image upload failed");
                }

                $profileInfo['avatar'] = $userAvatar['files'][0];

                // Remove old avatar
                if (!empty($user['avatar'])) {
                    $filenameFromUrl = basename($user['avatar']);
                    $oldFile = "../public/UPLOADS/avatars/" . $filenameFromUrl;
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
            }

            if (
                Database::update($profile, $profileInfo, ['userid' => $id]) &&
                Database::update($accounts, $accountInfo, ['userid' => $id])
            ) {
                Activity::activity([
                    'userid' => $user['userid'],
                    'type'   => 'update',
                    'title'  => 'profile update',
                ]);
                return true;
            }
        } catch (\Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'UserService::updateUserInformation',
                ['userid' => $id],
                $th
            );
            Response::error(500, "An error occurred while updating user details");
        }

        return false;
    }

    /**
     * Update user password (not yet implemented).
     *
     * @return void
     */
    public static function updateUserPassword(): void
    {
        // TODO: Implement password update logic
    }

    /**
     * Delete a user account and related records.
     *
     * @param string|int $id User identifier.
     * @return bool True if deleted successfully, false otherwise.
     */
    public static function deleteUserAccount($id): bool
    {
        $profile = Utility::$profile_tbl;
        $accounts = Utility::$accounts_tbl;

        try {
            $user = self::fetchUserDetails($id);
            if (empty($user)) {
                Response::error(404, "User not found");
            }

            $userProfile = $user[0];

            // Remove avatar if exists
            if (!empty($userProfile['avatar'])) {
                $filenameFromUrl = basename($userProfile['avatar']);
                $oldFile = "../public/UPLOADS/avatars/" . $filenameFromUrl;
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }

            if (
                Database::delete($profile, ['userid' => $id]) &&
                Database::delete($accounts, ['userid' => $id])
            ) {
                Activity::activity([
                    'userid' => $_SESSION['userid'] ?? null,
                    'type'   => 'delete',
                    'title'  => 'account deleted',
                ]);
                return true;
            }
        } catch (\Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'UserService::deleteUserAccount',
                ['userid' => $id],
                $th
            );
            Response::error(500, "An error occurred while deleting user account");
        }

        return false;
    }

    /**
     * Fetch user activity logs.
     *
     * @param string|int|null $id Optional user identifier.
     * @return array|null List of logs or null if query fails.
     */
    public static function fetchActivityLogs($id = null): ?array
    {
        $logs = Utility::$loginactivity;
        $profile = Utility::$profile_tbl;

        try {
            return Database::joinTables(
                "$logs l",
                [
                    [
                        "type"  => "LEFT",
                        "table" => "$profile p",
                        "on"    => "l.userid = p.userid"
                    ]
                ],
                ["l.*", "p.fullname"],
                $id ? ["l.userid" => $id] : [],
                ["order" => "l.id DESC"]
            );
        } catch (\Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'UserService::fetchActivityLogs',
                ['userid' => $_SESSION['userid'] ?? null],
                $th
            );
            Response::error(500, "An error occurred while fetching activity logs");
        }

        return null;
    }
}
