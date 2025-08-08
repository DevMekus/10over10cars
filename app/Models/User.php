<?php

namespace APP\Models;

use configs\DBConnection;
use App\Utils\Utility;


class User
{
    private static $account = 'accounts_tbl';
    private static $profile = 'users_tbl';


    public static function findByEmail($email)
    {
        try {
            $db = DBConnection::getConnection();
            $account = self::$account;
            $profile = self::$profile;

            $sql = "SELECT user.*,
                        account.role_id,
                        account.account_status,
                        account.create_date
                        FROM {$profile} AS user
                        INNER JOIN {$account} AS account ON user.userid = account.userid
                        WHERE user.email_address = :email LIMIT 1";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'User::findByEmail', ['host' => 'localhost'], $e);
        }
    }

    public static function create(array $data)
    {
        $db = DBConnection::getConnection();

        if (
            self::newAccount($db, $data)
            && self::newProfile($db, $data)
        ) {
            return true;
        }
        return false;
    }

    private static function newAccount($db, $data)
    {
        $account = self::$account;

        try {
            $stmt = $db->prepare(
                "INSERT INTO {$account} (userid, account_status, role_id) 
                    VALUES (:userid, :account_status, :role_id)"
            );
            return $stmt->execute(
                [
                    'userid' => $data['userid'],
                    'role_id' => $data['role_id'],
                    'account_status' => $data['account_status']
                ]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'User::newAccount', ['host' => 'localhost'], $e);
        }
    }
    private static function newProfile($db, $data)
    {
        $profile = self::$profile;
        try {
            $stmt = $db->prepare(
                "INSERT INTO {$profile} (userid, fullname, home_address, home_state, home_city, country, email_address, phone_number, user_password) 
                    VALUES (:userid, :fullname, :home_address, :home_state, :home_city, :country, :email_address, :phone_number, :user_password)"
            );
            return $stmt->execute(
                [
                    'userid' => $data['userid'],
                    'fullname' => $data['fullname'],
                    'home_address' => $data['home_address'],
                    'home_state' => $data['home_state'],
                    'home_city' => $data['home_city'],
                    'country' => $data['country'],
                    'email_address' => $data['email_address'],
                    'phone_number' => $data['phone_number'],
                    'user_password' => $data['hash_password'],
                ]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'User::newProfile', ['host' => 'localhost'], $e);
        }
    }

    public static function userData($id)
    {
        try {
            $db = DBConnection::getConnection();
            $account = self::$account;
            $profile = self::$profile;

            $sql = "SELECT user.*,
                account.role_id,
                account.account_status,
                account.reset_token,
                account.reset_token_expiration,
                account.create_date
                FROM {$profile} user 
                INNER JOIN {$account} account ON user.userid = account.userid 
                WHERE user.email_address = :email OR user.userid = :userid
            ";
            $stmt = $db->prepare($sql);
            $stmt->execute(
                [
                    'email' => $id,
                    'userid' => $id
                ]
            );
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'User::userData', ['host' => 'localhost'], $e);
        }
    }

    public static function usersData()
    {
        try {
            $db = DBConnection::getConnection();
            $account = self::$account;
            $profile = self::$profile;

            $sql = "SELECT user.*,
                account.role_id,
                account.account_status,
                account.reset_token_expiration,
                account.reset_token,
                account.create_date
                FROM {$profile} user 
                INNER JOIN {$account} account 
                ON user.userid = account.userid 
                ORDER BY account.id DESC
        ";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'User::usersData', ['host' => 'localhost'], $e);
        }
    }

    public static function updateUserAccount($prev, $data)
    {


        try {
            $db = DBConnection::getConnection();
            $account = self::$account;

            $stmt = $db->prepare(
                "UPDATE {$account}
            SET role_id = :role_id,
            account_status = :account_status,
            reset_token = :reset_token,
            reset_token_expiration = :reset_token_expiration
            WHERE userid = :id"
            );

            return $stmt->execute(
                [
                    'id' => $data['userid'] ?? $prev['userid'],
                    'role_id' => $data['role_id'] ?? $prev['role_id'],
                    'account_status' => $data['account_status'] ?? $prev['account_status'],
                    'reset_token' => $data['reset_token'] ?? $prev['reset_token'],
                    'reset_token_expiration' => $data['reset_token_expiration'] ?? $prev['reset_token_expiration'],
                ]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'User::updateUserAccount', ['host' => 'localhost'], $e);
        }
    }
    public static function updateUserProfile($prev, $data)
    {
        try {
            $db = DBConnection::getConnection();
            $profile = self::$profile;

            $stmt = $db->prepare(
                "UPDATE {$profile}
                    SET fullname = :fullname,
                    home_address = :home_address,
                    home_state = :home_state,
                    home_city = :home_city,
                    country = :country,
                    phone_number = :phone_number,
                    avatar = :avatar,
                    user_password = :user_password WHERE userid = :userid"
            );
            return $stmt->execute(
                [
                    'fullname' => $data['fullname'] ?? $prev['fullname'],
                    'home_address' => $data['home_address'] ?? $prev['home_address'],
                    'home_state' => $data['home_state'] ?? $prev['home_state'],
                    'home_city' => $data['home_city'] ?? $prev['home_city'],
                    'country' => $data['country'] ?? $prev['country'],
                    'phone_number' => $data['phone_number'] ?? $prev['phone_number'],
                    'user_password' => $data['user_password'] ?? $prev['user_password'],
                    'avatar' => $data['avatar'] ?? $prev['avatar'],
                    'userid' => $data['userid'] ?? $prev['userid'],
                ]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'User::updateUserProfile', ['host' => 'localhost'], $e);
        }
    }

    public static function validateResetToken($token)
    {
        try {
            $db = DBConnection::getConnection();
            $account = self::$account;

            $stmt = $db->prepare(
                "SELECT * FROM {$account} 
            WHERE reset_token = :token AND reset_token_expiration > Now()"
            );
            $stmt->execute(["token" => $token]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'User::validateResetToken', ['host' => 'localhost'], $e);
        }
    }

    public static function delete($id)
    {
        $db = DBConnection::getConnection();
        if (
            self::deleteAccount($id, $db)
            && self::deleteProfile($id, $db)
        ) {
            return true;
        }
        return false;
    }

    private static function deleteAccount($id, $db)
    {
        try {
            $account = self::$account;
            $stmt = $db->prepare("DELETE FROM {$account} WHERE userid = :id");
            return $stmt->execute(['id' => $id]);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'User::deleteAccount', ['host' => 'localhost'], $e);
        }
    }
    private static function deleteProfile($id, $db)
    {
        try {
            $profile = self::$profile;
            $stmt = $db->prepare("DELETE FROM {$profile} WHERE userid = :id");
            return $stmt->execute(['id' => $id]);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'User::deleteProfile', ['host' => 'localhost'], $e);
        }
    }
}
