<?php

namespace App\Models;

use configs\DBConnection;
use App\Utils\Utility;

class ActivityLog
{

    protected static $log = 'user_activity_logs';
    private static $profile = 'users_tbl';
    private static $account = 'accounts_tbl';

    public static function fetchLogsById($id)
    {
        try {
            $db = DBConnection::getConnection();
            $log = self::$log;
            $profile = self::$profile;
            $account = self::$account;

            $stmt = $db->prepare(
                "SELECT logs.*,
                   user.fullname,
                   account.role_id,
                   user.email_address
                FROM {$log} logs
                LEFT JOIN {$profile} user 
                ON user.userid = logs.userid
                LEFT JOIN {$account} account
                ON account.userid = user.userid
                WHERE logs.userid = :userid 
                OR logs.activity_id = :id 
                OR logs.entity_id = :entity
                ORDER BY logs.activity_id DESC"
            );
            $stmt->execute(
                [
                    'userid' => $id,
                    'id' => $id,
                    'entity' => $id,
                ]
            );
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'ActivityLog::fetchLogsById', ['host' => 'localhost'], $e);
        }
    }

    public static function fetchLogs()
    {
        try {
            $db = DBConnection::getConnection();
            $log = self::$log;
            $profile = self::$profile;
            $account = self::$account;

            $stmt = $db->prepare(
                "SELECT logs.*,
                   user.fullname,
                   account.role_id,
                   user.email_address
                FROM {$log} logs
                LEFT JOIN {$profile} user 
                ON user.userid = logs.userid
                LEFT JOIN {$account} account
                ON account.userid = user.userid              
                ORDER BY logs.activity_id DESC"
            );
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'ActivityLog::fetchLogs', ['host' => 'localhost'], $e);
        }
    }
    public static function create($data)
    {
        try {
            $db = DBConnection::getConnection();
            $log = self::$log;

            $stmt = $db->prepare(
                "INSERT INTO {$log} (userid, actions, entity_id)
            VALUES(:user_id, :actions, :entity_id)"
            );
            return $stmt->execute(
                [
                    'user_id' => $data['userid'],
                    'actions' => $data['actions'],
                    'entity_id' => $data['entity_id']
                ]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'ActivityLog::create', ['host' => 'localhost'], $e);
        }
    }
}
