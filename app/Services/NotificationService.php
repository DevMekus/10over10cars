<?php

namespace App\Services;

use App\Utils\Response;
use configs\Database;
use App\Services\Activity;
use App\Utils\Utility;

class NotificationService
{


    public static function fetchNotification($id)
    {
        $notification = Utility::$notification;
        try {
            $query = "SELECT * FROM $notification WHERE id = :id OR alertid = : aid";
            $params = ['id' => $id, 'aid' => $id];
            return Database::query($query, $params);
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'NotificationService::fetchNotification', ['userid' => $_SESSION['userid']], $th);
            Response::error(500, "An error occurred while fetching notice");
        }
    }

    public static function fetchAllNotification()
    {
        $notification = Utility::$notification;
        try {
            $query = "SELECT * FROM $notification ORDER BY id DESC";
            $params = [];
            return Database::query($query, $params);
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'NotificationService::fetchAllNotification', ['userid' => $_SESSION['userid']], $th);
            Response::error(500, "An error occurred while fetching notice");
        }
    }

    public static function sendNotification($id)
    {
        $data = self::fetchNotification($id);
        if (empty($data)) {
            Response::error(404, "Notification not found");
        }
        Response::success($data[0], "Notification found");
    }

    public static function sendAllNotification()
    {
        $data = self::fetchAllNotification();
        if (empty($data)) {
            Response::error(404, "Notifications not found");
        }
        Response::success($data, "Notifications found");
    }

    public static function createNotification($data)
    {
        $notification = Utility::$notification;
        try {
            $alert = self::fetchNotification($data['alertid']);
            if (!empty($alert)) {
                Response::error(409, "Notifications already exists");
            }
            $notice = [
                'alertid' => $data['alertid'],
                'title' => $data['title'],
                'message' => $data['message'],
                'type' => $data['type'],
                'priority' => $data['priority'],
                'source' => $data['source'],
            ];

            if (Database::insert($notification, $notice)) {
                Activity::activity([
                    'userid' => $_SESSION['userid'],
                    'type' => 'Notification',
                    'title' => 'New notification',
                ]);
                Response::success([], "New notification successful");
            }
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'NotificationService::createNotification', ['userid' => $_SESSION['userid']], $th);
            Response::error(500, "An error occurred while creating notice");
        }
    }

    public static function deleteNotification($id)
    {
        try {
            $notification = Utility::$notification;
            //code...
            $alert = self::fetchNotification($id);
            if (empty($alert)) {
                Response::error(409, "Notifications not found");
            }

            if (Database::delete($notification, ["id" => $id])) {
                Activity::activity([
                    'userid' => $_SESSION['userid'],
                    'type' => 'Notification',
                    'title' => 'notification Deleted',
                ]);
                Response::success([], "Notification Delete successful");
            }
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'NotificationService::deleteNotification', ['userid' => $_SESSION['userid']], $th);
            Response::error(500, "An error occurred while deleting notice");
        }
    }
}
