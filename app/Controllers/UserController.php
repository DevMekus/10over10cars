<?php

namespace App\Controllers;

use App\Services\UserService;
use App\Services\DealerService;
use App\Services\NotificationService;
use App\Services\PlansService;
use App\Services\TransactionService;
use App\Services\VehicleService;
use App\Services\VerificationService;
use App\Utils\RequestValidator;
use App\Utils\Response;

/**
 * Class UserController
 *
 * Handles user-related operations including profiles,
 * application data, authentication details, and activities.
 */
class UserController
{
    /**
     * Retrieve application data accessible to guests.
     *
     * @return void
     */
    public function guestApplicationData(): void
    {
        try {
            $data = [
                'plans'    => PlansService::fetchAllVerificationPlans(),
                'vehicles' => VehicleService::fetchAllVehicleInformation(),
            ];

            Response::success($data, "Application data");
        } catch (\Throwable $e) {
            Response::error(500, "Error fetching guest data: " . $e->getMessage());
        }
    }

    /**
     * Retrieve application data specific to a user.
     *
     * @param mixed $id User ID
     * @return void
     */
    public function userApplicationData($id): void
    {
        try {
            $id = RequestValidator::parseId($id);

            $data = [
                'verifications' => VerificationService::fetchVerificationRequest($id),
                'vehicles'      => VehicleService::fetchVehicleInformation($id),
                'dealers'       => DealerService::fetchDealerInformation($id),
                'txns'          => TransactionService::fetchTransaction($id),
                'loginActivity' => UserService::fetchActivityLogs($id),
                'profile'       => UserService::fetchUserDetails($id),
                'notification'  => NotificationService::fetchAllNotification(),
                'plans'         => PlansService::fetchAllVerificationPlans(),
            ];

            Response::success($data, "Application data");
        } catch (\Throwable $e) {
            Response::error(500, "Error fetching user application data: " . $e->getMessage());
        }
    }

    /**
     * Retrieve a specific user profile by ID.
     *
     * @param mixed $id User ID
     * @return void
     */
    public function userProfile($id): void
    {
        try {
            $id = RequestValidator::parseId($id);

            $user = UserService::fetchUserDetails($id);

            if (empty($user)) {
                Response::error(404, "User not found");
                return;
            }

            Response::success($user, "User information");
        } catch (\Throwable $e) {
            Response::error(500, "Error fetching user profile: " . $e->getMessage());
        }
    }

    /**
     * Retrieve all user profiles.
     *
     * @return void
     */
    public function usersProfiles(): void
    {
        try {
            $users = UserService::fetchAllUsersAndData();

            if (empty($users)) {
                Response::error(404, "No users found");
                return;
            }

            Response::success($users, "Users information");
        } catch (\Throwable $e) {
            Response::error(500, "Error fetching users: " . $e->getMessage());
        }
    }

    /**
     * Update a user profile.
     *
     * @param mixed $id User ID
     * @return void
     */
    public function updateUserProfile($id): void
    {
        try {
            $id   = RequestValidator::parseId($id);
            $data = RequestValidator::sanitize($_POST);

            $update = UserService::updateUserInformation($id, $data);

            if ($update) {
                Response::success([], "Profile update successful");
                return;
            }

            Response::error(500, "Profile update failed");
        } catch (\Throwable $e) {
            Response::error(500, "Error updating profile: " . $e->getMessage());
        }
    }

    /**
     * Update a user's password.
     *
     * @param mixed $id User ID
     * @return void
     */
    public function updateUserPassword($id): void
    {
        try {
            $id   = RequestValidator::parseId($id);
            $data = RequestValidator::sanitize($_POST);

            $userData = UserService::fetchUserDetails($id);

            if (empty($userData)) {
                Response::error(404, "User not found");
                return;
            }

            $user = $userData[0];

            if (!isset($data['current_password'], $user['user_password'])) {
                Response::error(400, "Missing required password fields");
                return;
            }

            if (password_verify($data['current_password'], $user['user_password'])) {
                $update = UserService::updateUserInformation($id, $data);

                if ($update) {
                    Response::success([], "Password update successful");
                    return;
                }

                Response::error(500, "Password update failed");
                return;
            }

            Response::error(401, "Incorrect password");
        } catch (\Throwable $e) {
            Response::error(500, "Error updating password: " . $e->getMessage());
        }
    }

    /**
     * Delete a user account by ID.
     *
     * @param mixed $id User ID
     * @return void
     */
    public function deleteUserProfile($id): void
    {
        try {
            $id = RequestValidator::parseId($id);

            $delete = UserService::deleteUserAccount($id);

            if ($delete) {
                Response::success([], "User account deleted");
                return;
            }

            Response::error(500, "Failed to delete user account");
        } catch (\Throwable $e) {
            Response::error(500, "Error deleting user: " . $e->getMessage());
        }
    }

    /**
     * Fetch a user's activity logs.
     *
     * @param mixed $id User ID
     * @return void
     */
    public function fetchUserActivity($id): void
    {
        try {
            $id = RequestValidator::parseId($id);

            $activity = UserService::fetchActivityLogs($id);

            if (empty($activity)) {
                Response::error(404, "User activity not found");
                return;
            }

            Response::success($activity, "User activity");
        } catch (\Throwable $e) {
            Response::error(500, "Error fetching user activity: " . $e->getMessage());
        }
    }
}
