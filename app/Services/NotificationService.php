<?php

namespace App\Services;

use App\Utils\Response;
use configs\Database;
use App\Services\Activity;
use App\Utils\Utility;
use Throwable;

/**
 * Class NotificationService
 *
 * Provides methods for handling system notifications.
 * Includes creation, retrieval, listing, and deletion of notifications.
 *
 * @package App\Services
 */
class NotificationService
{
    /**
     * Fetch a single notification by its ID or alert ID.
     *
     * @param string|int $id Notification identifier.
     * @return array|null Notification data or null if not found.
     */
    public static function fetchNotification($id): ?array
    {
        $notificationTable = Utility::$notification;

        try {
            $query  = "SELECT * FROM {$notificationTable} WHERE id = :id OR alertid = :aid";
            $params = ['id' => $id, 'aid' => $id];

            return Database::query($query, $params);
        } catch (Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'NotificationService::fetchNotification',
                ['userid' => $_SESSION['userid'] ?? null],
                $th
            );
            Response::error(500, "An error occurred while fetching the notification");
        }

        return null;
    }

    /**
     * Fetch all notifications, ordered by ID (latest first).
     *
     * @return array|null List of notifications or null if query fails.
     */
    public static function fetchAllNotification(): ?array
    {
        $notificationTable = Utility::$notification;

        try {
            $query  = "SELECT * FROM {$notificationTable} ORDER BY id DESC";
            return Database::query($query, []);
        } catch (Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'NotificationService::fetchAllNotification',
                ['userid' => $_SESSION['userid'] ?? null],
                $th
            );
            Response::error(500, "An error occurred while fetching notifications");
        }

        return null;
    }

    /**
     * Send a single notification by ID.
     *
     * @param string|int $id Notification identifier.
     * @return void
     */
    public static function sendNotification($id): void
    {
        $data = self::fetchNotification($id);

        if (empty($data)) {
            Response::error(404, "Notification not found");
        }

        Response::success($data[0], "Notification found");
    }

    /**
     * Send all notifications.
     *
     * @return void
     */
    public static function sendAllNotification(): void
    {
        $data = self::fetchAllNotification();

        if (empty($data)) {
            Response::error(404, "No notifications found");
        }

        Response::success($data, "Notifications retrieved successfully");
    }

    /**
     * Create a new notification.
     *
     * @param array $data Notification data:
     *                     - alertid
     *                     - title
     *                     - message
     *                     - type
     *                     - priority
     *                     - source
     * @return void
     */
    public static function createNotification(array $data): void
    {
        $notificationTable = Utility::$notification;

        try {
            // Prevent duplicate notification by alertid
            $alert = self::fetchNotification($data['alertid']);
            if (!empty($alert)) {
                Response::error(409, "Notification already exists");
            }

            $notice = [
                'alertid'  => $data['alertid'],
                'title'    => $data['title'],
                'message'  => $data['message'],
                'type'     => $data['type'],
                'priority' => $data['priority'],
                'source'   => $data['source'],
            ];

            if (Database::insert($notificationTable, $notice)) {
                Activity::activity([
                    'userid' => $_SESSION['userid'] ?? 'system',
                    'type'   => 'Notification',
                    'title'  => 'New notification created',
                ]);
                Response::success([], "Notification created successfully");
            }
        } catch (Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'NotificationService::createNotification',
                ['userid' => $_SESSION['userid'] ?? null],
                $th
            );
            Response::error(500, "An error occurred while creating the notification");
        }
    }

    /**
     * Delete a notification by ID.
     *
     * @param string|int $id Notification identifier.
     * @return void
     */
    public static function deleteNotification($id): void
    {
        $notificationTable = Utility::$notification;

        try {
            $alert = self::fetchNotification($id);

            if (empty($alert)) {
                Response::error(404, "Notification not found");
            }

            if (Database::delete($notificationTable, ["id" => $id])) {
                Activity::activity([
                    'userid' => $_SESSION['userid'] ?? 'system',
                    'type'   => 'Notification',
                    'title'  => 'Notification deleted',
                ]);
                Response::success([], "Notification deleted successfully");
            }
        } catch (Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'NotificationService::deleteNotification',
                ['userid' => $_SESSION['userid'] ?? null],
                $th
            );
            Response::error(500, "An error occurred while deleting the notification");
        }
    }
}
