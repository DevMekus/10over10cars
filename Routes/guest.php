<?php

use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Routes\Router;
use App\Middleware\GuestOnlyMiddleware;

$auth = new AuthController();
$user = new UserController();


Router::group('v1', function () use ($auth, $user) {
    #Authentication
    Router::add('POST', '/auth/login', [$auth, 'login']);
    Router::add('POST', '/auth/register', [$auth, 'register']);
    Router::add('POST', '/auth/logout', [$auth, 'logout']);
    Router::add('POST', '/auth/recover', [$auth, 'recoverAccount']);
    Router::add('POST', '/auth/reset', [$auth, 'resetAccountPassword']);

    #Application
    Router::add('GET', '/application/guest', [$user, 'guestApplicationData']);
}, [GuestOnlyMiddleware::class]);
