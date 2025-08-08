<?php

namespace APP\Models;

use configs\DBConnection;
use App\Utils\Utility;

class Support
{
    private static $support = 'support_tickets';
    private static $replies = 'ticket_replies';
    private static $profile = 'users_tbl';
    private static $account = 'accounts_tbl';

    public static function findSupportById($id)
    {
        try {
            $db = DBConnection::getConnection();
            $support = self::$support;
            $replies = self::$replies;
            $profile = self::$profile;
            $account = self::$account;

            $stmt = $db->prepare(
                "SELECT supports.*,
                user.fullname,
                account.role_id,                
                user.email_address,                
                reply.userid AS replier,
                reply.reply_text AS replyText,
                reply.reply_at AS replyAt,
                reply.reply_id AS replyId,
                replier.fullname AS replierName                 
                 
            FROM  {$support} AS supports
            LEFT JOIN {$replies} AS reply ON supports.ticket_id = reply.ticket_id
            LEFT JOIN {$profile} AS user ON user.userid = supports.userid
            LEFT JOIN {$profile} AS replier 
            ON reply.userid = replier.userid 
            LEFT JOIN {$account} AS account ON replier.userid = account.userid   
            WHERE supports.userid = :sender
                OR supports.ticket_id = :ticket_id                
                ORDER BY supports.created_at DESC, reply.reply_at DESC 
            "
            );

            $stmt->execute(
                [
                    'ticket_id' => $id,
                    'sender' => $id,
                ]
            );
            $row = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return self::processSupport($row);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Support::findSupportById', ['host' => 'localhost'], $e);
        }
    }

    public static function fetchSupportMessages()
    {
        try {
            $db = DBConnection::getConnection();
            $support = self::$support;
            $replies = self::$replies;
            $profile = self::$profile;
            $account = self::$account;

            $stmt = $db->prepare(
                "SELECT supports.*,
                user.fullname,
                account.role_id,                
                user.email_address,                
                reply.userid AS replier,
                reply.reply_text AS replyText,
                reply.reply_at AS replyAt,
                reply.reply_id AS replyId,
                replier.fullname AS replierName                 
                 
            FROM  {$support} AS supports
            LEFT JOIN {$replies} AS reply ON supports.ticket_id = reply.ticket_id
            LEFT JOIN {$profile} AS user ON user.userid = supports.userid
            LEFT JOIN {$profile} AS replier 
            ON reply.userid = replier.userid 
            LEFT JOIN {$account} AS account ON replier.userid = account.userid 
                ORDER BY supports.created_at DESC, reply.reply_at DESC 
            "
            );

            $stmt->execute();
            $row = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return self::processSupport($row);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Support::fetchSupportMessages', ['host' => 'localhost'], $e);
        }
    }

    private static function processSupport($supportMessage)
    {
        $supportData = [];

        foreach ($supportMessage as $row) {
            $ticketId = $row['ticket_id'];

            // Ensure a unique entry per ticket
            if (!isset($supportData[$ticketId])) {
                $supportData[$ticketId] = [
                    "ticket_id" => $ticketId,
                    "fullname" => $row['fullname'],
                    'email_address' => $row['email_address'],
                    "userid" => $row['userid'],
                    "subject" => $row['subjects'],
                    "category" => $row['category'],
                    "description" => $row['descriptions'],
                    "statuses" => $row['statuses'],
                    "priority" => $row['priority'],
                    "created_at" => $row['created_at'],
                    "replyMessage" => [],
                ];
            }

            // Add replies if they exist
            if ($row['replyId']) {
                $supportData[$ticketId]['replyMessage'][] = [
                    "replyText" => $row['replyText'],
                    "replyAt" => $row['replyAt'],
                    "userRole" => $row['role_id'],
                    "replyId" => $row['replyId'],
                    "ticketReplier" => $row['replier'],
                    "replierName" => $row['fullname']
                ];
            }
        }

        return array_values($supportData); // Convert associative array to indexed array
    }


    public static function  create($data)
    {
        try {
            $db = DBConnection::getConnection();
            $support = self::$support;
            $stmt = $db->prepare(
                "INSERT INTO {$support} (ticket_id, userid, subjects, descriptions, priority, category) 
                    VALUES (:ticket_id, :userid, :subjects, :descriptions, :priority, :category)"
            );
            return $stmt->execute(
                [
                    'ticket_id' => $data['ticket_id'],
                    'userid' => $data['userid'],
                    'subjects' => $data['subjects'],
                    'descriptions' => $data['descriptions'],
                    'priority' => $data['priority'],
                    'category' => $data['category'],
                ]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Support::create', ['host' => 'localhost'], $e);
        }
    }

    public static function conversation($data)
    {
        try {
            $db = DBConnection::getConnection();
            $replies = self::$replies;

            $stmt = $db->prepare(
                "INSERT INTO {$replies} (ticket_id, userid, reply_text) 
                    VALUES (:ticket_id, :userid, :reply_text)"
            );
            return $stmt->execute(
                [
                    'ticket_id' => $data['ticket_id'],
                    'userid' => $data['userid'],
                    'reply_text' => $data['reply_text'],
                ]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Support::conversation', ['host' => 'localhost'], $e);
        }
    }

    public static function updateSupport($prev, $data)
    {
        try {
            $db = DBConnection::getConnection();
            $support = self::$support;

            $stmt = $db->prepare(
                "UPDATE {$support}
                SET statuses = :statuses 
                WHERE ticket_id = :ticket_id"
            );
            return $stmt->execute(
                [
                    'ticket_id' => $data['ticket_id'],
                    'statuses' => $data['statuses'] ?? $prev['statuses']
                ]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Support::findSupportById', ['host' => 'localhost'], $e);
        }
    }

    public static function delete($id)
    {
        $db = DBConnection::getConnection();
        if (
            self::deleteSupport($id, $db)
            && self::deleteConversations($id, $db)
        ) {
            return true;
        }
        return false;
    }

    private static function deleteSupport($id, $db)
    {
        try {

            $support = self::$support;

            $stmt = $db->prepare(
                "DELETE FROM {$support} WHERE ticket_id = :id"
            );
            return $stmt->execute(
                ['id' => $id]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Support::deleteSupport', ['host' => 'localhost'], $e);
        }
    }

    private static function deleteConversations($id, $db)
    {
        try {

            $replies = self::$replies;

            $stmt = $db->prepare(
                "DELETE FROM {$replies} WHERE ticket_id = :id"
            );
            return $stmt->execute(
                ['id' => $id]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Support::deleteConversations', ['host' => 'localhost'], $e);
        }
    }
}
