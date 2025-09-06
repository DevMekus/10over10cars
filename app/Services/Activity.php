<?php

namespace App\Services;

use App\Utils\Utility;
use configs\Database;
use Throwable;

/**
 * Class Activity
 *
 * Handles logging of user activities (e.g., login attempts, actions)
 * and stores them in the database.
 *
 * @package App\Services
 */
class Activity
{
    /**
     * Log a user activity into the database.
     *
     * @param array $data {
     *     @type string $userid   The ID of the user performing the action.
     *     @type string $type     The type of activity (e.g., "login", "logout").
     *     @type string $title    A descriptive title of the activity.
     *     @type string $status   (Optional) The status of the activity, default is "success".
     * }
     *
     * @return bool True on success, False on failure.
     */
    public static function activity(array $data): bool
    {
        $table  = Utility::$loginactivity;
        $device = Utility::getUserDevice();
        $ip     = Utility::getUserIP();

        try {
            $activity = [
                'logid'  => Utility::generate_uniqueId(10),
                'userid' => $data['userid'],
                'type'   => $data['type'],
                'title'  => $data['title'],
                'status' => $data['status'] ?? 'success',
                'ip'     => $ip ?? '',
                'device' => $device ?? '',
            ];

            if (Database::insert($table, $activity)) {
                return true;
            }

            // Log failed insert attempt
            Utility::log(
                'Database insert failed for activity log.',
                'error',
                'Activity::activity',
                ['activity' => $activity]
            );

            return false;
        } catch (Throwable $e) {
            Utility::log(
                $e->getMessage(),
                'error',
                'Activity::activity',
                ['host' => 'localhost', 'activity' => $data],
                $e
            );
            return false;
        }
    }
}
