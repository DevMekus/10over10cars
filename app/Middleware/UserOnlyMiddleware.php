<?php

namespace App\Middleware;

use App\Middleware\AuthMiddleware;
use App\Utils\Response;

class UserOnlyMiddleware
{
    public function handle()
    {
        $userData = AuthMiddleware::verifyToken();

        if (!isset($userData['role'])) {
            Response::error(403, 'Access denied: Authentication required');
        }

        return true;
    }
}
