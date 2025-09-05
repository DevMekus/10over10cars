<?php

namespace App\Services;

use App\Utils\Utility;
use configs\Database;


class Activity
{

    public static function activity($data)
    {
        $table = Utility::$loginactivity;
        $device = Utility::getUserDevice();
        $ip = Utility::getUserIP();
        try {
            $activity = [
                'logid' => Utility::generate_uniqueId(10),
                'userid' => $data['userid'],
                'type' => $data['type'],
                'title' => $data['title'],
                'status' => $data['status'] ?? 'success',
                'ip' => $ip ?? 'not available',
                'device' => $device  ?? '',
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
