<?php

namespace App\Middleware;

use App\Utils\Response;
use App\Middleware\AuthMiddleware;

class AdminOnlyMiddleware
{
    public function handle()
    {
        $userData = AuthMiddleware::verifyToken();

        if (!isset($userData['role']) || (string)$userData['role'] !== '1') {
            Response::error(403, 'Access denied: Admin role required');
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['userid'] = $userData['id'];

        return true;
    }
}
