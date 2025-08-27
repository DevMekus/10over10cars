<?php

namespace App\Services;

use App\Utils\Utility;
use configs\Database;


class Activity
{

    public static function activity($data)
    {
        $table = Utility::$loginactivity;
        try {
            $activity = [
                'logid' => Utility::generate_uniqueId(10),
                'userid' => $data['userid'],
                'type' => $data['type'],
                'title' => $data['title'],
                'status' => $data['status'] ?? 'success',
                'ip' => $data['ip'] ?? 'not available',
                'device' => $data['device'] ?? 'device',
            ];
            if (Database::insert($table, $activity)) {
                return true;
            }
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Activity::newActivity', ['host' => 'localhost'], $e);
            return false;
        }
    }
}
