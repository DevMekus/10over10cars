<?php

namespace App\Services;

use APP\Models\User;
use App\Utils\Response;
use App\Utils\Utility;



class CronJob
{
    public static function backupDatabase($id, $data)
    {


        try {
            $user = User::userData($id);

            if (!$user || $user['role_id'] !== '1' || !password_verify($data['password'], $user['user_password'])) {
                Response::error(401, "Unauthorized");
            }

            echo json_encode($data);
            exit;

            $dbHost = $_ENV['DB_HOST'];
            $dbUser = $_ENV['DB_USERNAME'];
            $dbPass =  $_ENV['DB_PASSWORD'];
            $dbName = $_ENV['DB_NAME'];


            $backupFile = $dbName . '_' . date("Y-m-d_H-i-s") . '.sql';
            $backupPath = __DIR__ . '/backups/' . $backupFile;

            // Command to dump the DB
            $command = "mysqldump -h {$dbHost} -u {$dbUser} -p{$dbPass} {$dbName} > {$backupPath}";

            // Run the command
            $output = null;
            $returnVar = null;
            exec($command, $output, $returnVar);

            if ($returnVar === 0) {
                header('Content-Type: application/sql');
                header('Content-Disposition: attachment; filename="' . basename($backupPath) . '"');
                readfile($backupPath);
                Response::success(['file' => $backupFile], "Backup successful: $backupFile");
            } else {
                Response::error(500, "Backup failed. Error code: $returnVar");
            }
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'CronJob::backupDatabase', ['host' => 'localhost'], $e);
        }
    }
}
