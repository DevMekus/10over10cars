<?php

namespace configs;

use configs\Database;
use App\Utils\Utility;

class DBConnection
{
    public static function getConnection()
    {
        try {
            $database =  new Database(
                $_ENV['DB_HOST'],
                $_ENV['DB_NAME'],
                $_ENV['DB_USERNAME'],
                $_ENV['DB_PASSWORD']
            );
            return $database->getConnection();
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'DB Connection', ['host' => 'localhost'], $e);
        }
    }
}
