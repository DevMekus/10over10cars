<?php

namespace App\Services;

use App\Utils\Response;
use App\Middleware\AuthMiddleware;
use App\Services\Activity;
use App\Utils\Utility;
use App\Utils\MailClient;
use configs\Database;
use Throwable;

/**
 * Class AuthService
 *
 * Handles authentication, session management, account recovery,
 * and user-related operations (login, logout, registration, password reset).
 *
 * @package App\Services
 */
class AuthService
{
    /**
     * Attempt to log in a user with provided credentials.
     *
     * @param array $data {
     *     @type string $email_address User email.
     *     @type string $user_password User password.
     * }
     *
     * @return void
     */
    public static function attemptLogin(array $data): void
    {
        $profile  = Utility::$profile_tbl;
        $accounts = Utility::$accounts_tbl;

        try {
            $user = Database::joinTables(
                $profile,
                [
                    [
                        "type"  => "LEFT",
                        "table" => $accounts,
                        "on"    => "$profile.userid = $accounts.userid"
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
                'email'  => $user['email_address'],
                'role'   => $user['role'],
                'exp'    => time() + 3600,
            ]);

            // Save session
            $sessions_tbl = Utility::$sessions_tbl;
            $device       = Utility::getUserDevice();
            $ip           = Utility::getUserIP();

            $session = [
                'userid'        => $user['userid'],
                'session_token' => $token,
                'device'        => $device,
                'ip_address'    => $ip,
            ];

            Database::insert($sessions_tbl, $session);

            if (Activity::activity([
                'userid' => $user['userid'],
                'type'   => 'login',
                'title'  => 'login successful',
            ])) {
                Response::success(['token' => $token], "Login successful");
            }
        } catch (Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'AuthService::attemptLogin', ['host' => 'localhost'], $e);
            Response::error(500, "An error has occurred during login");
        }
    }

    /**
     * Check if a user account is active.
     *
     * @param array|null $user
     * @return bool
     */
    private static function checkUserStatus(?array $user): bool
    {
        if (isset($user['account_status']) && $user['account_status'] !== 'active') {
            Response::error(401, "Account is not active");
        }

        return true;
    }

    /**
     * Create a new user account.
     *
     * @param array $data {
     *     @type string $fullname
     *     @type string $email_address
     *     @type string $user_password
     *     @type string $role
     * }
     *
     * @return bool|null
     */
    public static function createAccount(array $data): ?bool
    {
        $profile  = Utility::$profile_tbl;
        $accounts = Utility::$accounts_tbl;

        try {
            $existingUser = Database::find($profile, $data['email_address'], 'email_address');
            if ($existingUser) {
                Response::error(409, "User already exists");
            }

            $userid = Utility::generate_uniqueId(10);

            $userProfile = [
                'userid'       => $userid,
                'fullname'     => $data['fullname'],
                'email_address' => $data['email_address'],
                'user_password' => password_hash($data['user_password'], PASSWORD_BCRYPT),
                'phone'        => '',
                'location'     => '',
                'city_state'   => '',
                'country'      => '',
                'avatar'       => '',
            ];

            $userAccount = [
                'userid'      => $userid,
                'status'      => $data['role'] !== 'dealer' ? 'active' : 'pending',
                'role'        => $data['role'] ?? 'user',
                'memberSince' => date('y-m-d', time()),
            ];

            if (Database::insert($profile, $userProfile) && Database::insert($accounts, $userAccount)) {
                unset($data['user_password']);

                Activity::activity([
                    'userid' => $userid,
                    'type'   => 'registration',
                    'title'  => 'registration successful',
                ]);

                // Optionally send registration email
                // self::registrationEmail($data['fullname'], $data['email_address']);

                return true;
            }
        } catch (Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'AuthService::createAccount', ['host' => 'localhost'], $e);
            Response::error(500, "An error has occurred during registration");
        }

        return null;
    }

    /**
     * Send registration email to new users.
     *
     * @param string $username
     * @param string $email
     * @return void
     */
    private static function registrationEmail(string $username, string $email): void
    {
        $templateData = [
            '{{logo_url}}'         => BASE_URL . 'assets/images/dark-logo.jpg',
            '{{banner_image_url}}' => BASE_URL . 'assets/images/emails/registration_banner.jpeg',
            '{{user_name}}'        => $username,
            '{{platform_name}}'    => BRAND_NAME,
            '{{login_url}}'        => BASE_URL . 'auth/login',
            '{{support_url}}'      => BASE_URL . 'contact-us',
            '{{current_year}}'     => date('Y'),
        ];

        MailClient::sendMail(
            $email,
            'Welcome to ' . BRAND_NAME,
            ROOT_PATH . '/app/templates/registration.html',
            $templateData,
            $username
        );
    }

    /**
     * Log out a user and revoke their session.
     *
     * @param array $data
     * @return bool|null
     */
    public static function logoutUser(array $data): ?bool
    {
        try {
            self::revokeSession($data['userid']);

            header('Authorization: Bearer null');

            Activity::activity([
                'userid' => $data['userid'] ?? $_SESSION['userid'],
                'type'   => 'logout',
                'title'  => 'logout successful',
            ]);

            return true;
        } catch (Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'AuthService::logoutUser', ['host' => 'localhost'], $e);
            Response::error(500, "An error has occurred during logout");
        }

        return null;
    }

    /**
     * Start account recovery process by sending a reset link.
     *
     * @param array $data
     * @return bool|null
     */
    public static function recoverAccount(array $data): ?bool
    {
        $profile  = Utility::$profile_tbl;
        $accounts = Utility::$accounts_tbl;

        try {
            $existingUser = Database::find($profile, $data['email_address'], 'email_address');
            if (!$existingUser) {
                Response::error(404, "User not found");
            }

            $token  = bin2hex(random_bytes(32));
            $expiry = (new \DateTime('+2 hour'))->format('Y-m-d H:i:s');

            $updateData = [
                'reset_token'            => $token,
                'reset_token_expiration' => $expiry,
            ];

            if (Database::update($accounts, $updateData, ["userid" => $existingUser['userid']])) {
                $resetLink = BASE_URL . "auth/reset-password?token=$token";

                $templateData = [
                    '{{logo_url}}'     => BASE_URL . 'assets/images/dark-logo.jpg',
                    '{{user_name}}'    => $existingUser['fullname'],
                    '{{platform_name}}' => BRAND_NAME,
                    '{{reset_link}}'   => $resetLink,
                    '{{support_url}}'  => BASE_URL . 'contact-us',
                    '{{current_year}}' => date('Y'),
                    '{{user_email}}'   => $existingUser['email_address'],
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
        } catch (Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'AuthService::recoverAccount', ['host' => 'localhost'], $e);
            Response::error(500, "An error has occurred during account recovery");
        }

        return null;
    }

    /**
     * Reset user password using a valid token.
     *
     * @param array $data
     * @return bool|null
     */
    public static function resetPassword(array $data): ?bool
    {
        $profile  = Utility::$profile_tbl;
        $accounts = Utility::$accounts_tbl;

        try {
            $validateToken = Database::find($accounts, $data['token'], 'reset_token');
            if (!$validateToken) {
                Response::error(401, "Invalid or expired token");
            }

            $userProfile = [
                'user_password' => password_hash($data['new_password'], PASSWORD_BCRYPT),
            ];

            $userAccount = [
                'reset_token'            => null,
                'reset_token_expiration' => null,
            ];

            if (
                Database::update($profile, $userProfile, ["userid" => $validateToken['userid']])
                && Database::update($accounts, $userAccount, ["userid" => $validateToken['userid']])
            ) {
                Activity::activity([
                    'userid' => $validateToken['userid'],
                    'type'   => 'update',
                    'title'  => 'password reset successful',
                ]);

                return true;
            }
        } catch (Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'AuthService::resetPassword', ['host' => 'localhost'], $e);
            Response::error(500, "An error has occurred while resetting password");
        }

        return null;
    }

    /**
     * Get user sessions by ID or email.
     *
     * @param mixed $id
     * @return array|null
     */
    public static function userSessions($id): ?array
    {
        try {
            $session_tbl = Utility::$sessions_tbl;
            $profile     = Utility::$profile_tbl;

            return Database::joinTables(
                "$session_tbl s",
                [
                    [
                        "type"  => "LEFT",
                        "table" => "$profile p",
                        "on"    => "s.userid = p.userid"
                    ],
                ],
                ["s.*", "p.fullname", "p.email_address"],
                [
                    "OR" => [
                        "s.id"           => $id,
                        "s.userid"       => $id,
                        "p.email_address" => $id,
                        "p.userid"       => $id,
                    ]
                ],
                ["s.userid" => $id]
            );
        } catch (Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'AuthService::userSessions', ['host' => 'localhost'], $e);
            Response::error(500, "An error has occurred while fetching user sessions");
        }

        return null;
    }

    /**
     * Get all active sessions.
     *
     * @return array|null
     */
    public static function activeSessions(): ?array
    {
        try {
            $session_tbl = Utility::$sessions_tbl;
            $profile     = Utility::$profile_tbl;

            return Database::joinTables(
                "$session_tbl s",
                [
                    [
                        "type"  => "LEFT",
                        "table" => "$profile p",
                        "on"    => "s.userid = p.userid"
                    ],
                ],
                ["s.*", "p.fullname", "p.email_address"],
            );
        } catch (Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'AuthService::activeSessions', ['host' => 'localhost'], $e);
            Response::error(500, "An error has occurred while fetching active sessions");
        }

        return null;
    }

    /**
     * Revoke (delete) a user session by session ID.
     *
     * @param mixed $sessionId
     * @return bool|null
     */
    public static function revokeSession($sessionId): ?bool
    {
        try {
            $session_tbl = Utility::$sessions_tbl;
            return Database::delete($session_tbl, ['userid' => $sessionId]);
        } catch (Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'AuthService::revokeSession', ['host' => 'localhost'], $e);
            Response::error(500, "An error has occurred while revoking session");
        }

        return null;
    }

    /**
     * Clear all sessions for a given user.
     *
     * @param mixed $userid
     * @return void
     */
    public static function clearUserSessions($userid): void
    {
        // TODO: Implement clearing of all user sessions if needed.
    }
}
