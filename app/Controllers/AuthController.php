<?php

namespace App\Controllers;

use App\Services\AuthService;
use App\Utils\RequestValidator;
use App\Utils\Response;

/**
 * Class AuthController
 *
 * Handles user authentication, registration, sessions, and account recovery.
 */
class AuthController
{
    /**
     * Authenticate a user with provided credentials.
     *
     * @return void
     */
    public function login(): void
    {
        try {
            $data = RequestValidator::validate([
                'email_address' => 'required|email',
                'user_password' => 'required|min:6',
            ]);

            $data = RequestValidator::sanitize($data);

            $login = AuthService::attemptLogin($data);

            if ($login) {
                Response::success($login, "Login successful");
            }

            Response::error(401, "Invalid login credentials");
        } catch (\Throwable $e) {
            Response::error(500, "Login failed: " . $e->getMessage());
        }
    }

    /**
     * Register a new user account.
     *
     * @return void
     */
    public function register(): void
    {
        try {
            $data = RequestValidator::validate([
                'fullname'      => 'required|min:3',
                'email_address' => 'required|email',
                'user_password' => 'required|min:6',
                'role'          => 'required|min:1',
            ]);

            $data = RequestValidator::sanitize($data);

            $register = AuthService::createAccount($data);

            if ($register) {
                Response::success([], "User registration successful");
                return;
            }

            Response::error(500, "User registration failed");
        } catch (\Throwable $e) {
            Response::error(500, "Registration failed: " . $e->getMessage());
        }
    }

    /**
     * Log out a user by user ID.
     *
     * @return void
     */
    public function logout(): void
    {
        try {
            $data = RequestValidator::validate([
                'userid' => 'required|min:7',
            ]);

            $data = RequestValidator::sanitize($data);

            $logout = AuthService::logoutUser($data);

            if ($logout) {
                Response::success([], "User logged out");
                return;
            }

            Response::error(500, "Logout failed");
        } catch (\Throwable $e) {
            Response::error(500, "Logout error: " . $e->getMessage());
        }
    }

    /**
     * Initiate account recovery process.
     *
     * @return void
     */
    public function recoverAccount(): void
    {
        try {
            $data = RequestValidator::validate([
                'email_address' => 'required|email',
            ]);

            $data = RequestValidator::sanitize($data);

            $recover = AuthService::recoverAccount($data);

            if ($recover) {
                Response::success([], "A reset link has been sent to your registered email.");
                return;
            }

            Response::error(500, "Account recovery failed");
        } catch (\Throwable $e) {
            Response::error(500, "Recovery error: " . $e->getMessage());
        }
    }

    /**
     * Reset account password using token.
     *
     * @return void
     */
    public function resetAccountPassword(): void
    {
        try {
            $data = RequestValidator::validate([
                'token'        => 'required|min:10',
                'new_password' => 'required|min:6',
            ]);

            $data = RequestValidator::sanitize($data);

            $reset = AuthService::resetPassword($data);

            if ($reset) {
                Response::success([], "Password reset complete");
                return;
            }

            Response::error(500, "Password reset failed");
        } catch (\Throwable $e) {
            Response::error(500, "Reset error: " . $e->getMessage());
        }
    }

    /**
     * Get all sessions for a user.
     *
     * @param mixed $id
     * @return void
     */
    public function getUserSessions($id): void
    {
        try {
            $id = RequestValidator::parseId($id);

            $sessions = AuthService::userSessions($id);

            if (empty($sessions)) {
                Response::error(404, "Sessions not found");
                return;
            }

            Response::success($sessions, "Sessions available");
        } catch (\Throwable $e) {
            Response::error(500, "Error fetching sessions: " . $e->getMessage());
        }
    }

    /**
     * Get all active user sessions.
     *
     * @return void
     */
    public function getActiveSessions(): void
    {
        try {
            $sessions = AuthService::activeSessions();

            if (empty($sessions)) {
                Response::error(404, "Sessions not found");
                return;
            }

            Response::success($sessions, "Sessions available");
        } catch (\Throwable $e) {
            Response::error(500, "Error fetching active sessions: " . $e->getMessage());
        }
    }

    /**
     * Revoke a specific user session.
     *
     * @param mixed $id
     * @return void
     */
    public function revokeSession($id): void
    {
        try {
            $id = RequestValidator::parseId($id);

            $revoke = AuthService::revokeSession($id);

            if ($revoke) {
                Response::success([], "Session revoked");
                return;
            }

            Response::error(500, "Could not revoke session");
        } catch (\Throwable $e) {
            Response::error(500, "Revoke error: " . $e->getMessage());
        }
    }

    /**
     * Clear all sessions for a specific user.
     *
     * @param mixed $userid
     * @return void
     */
    public function clearAllUserSession($userid): void
    {
        try {
            $userid = RequestValidator::parseId($userid);

            $cleared = AuthService::clearUserSessions($userid);

            if ($cleared) {
                Response::success([], "All sessions cleared");
                return;
            }

            Response::error(500, "Could not clear sessions");
        } catch (\Throwable $e) {
            Response::error(500, "Clear sessions error: " . $e->getMessage());
        }
    }
}
