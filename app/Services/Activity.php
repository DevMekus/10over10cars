<?php

namespace App\Services;

use App\Utils\Utility;
use App\Models\ActivityLog;


class Activity
{

    public static function newActivity($data)
    {
        try {
            $data['entity_id'] = Utility::generate_uniqueId(10);
            return ActivityLog::create($data);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Activity::newActivity', ['host' => 'localhost'], $e);
        }
    }
}
