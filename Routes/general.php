<?php


use App\Controllers\UserController;
use App\Routes\Router;
use App\Middleware\GuestOnlyMiddleware;

$user = new UserController();

Router::group('', function () use ($user) {
    #Authentication
    Router::add('POST', '/register/user', [$user, 'newUser']);
    Router::add('POST', '/register/business', [$user, 'newBusiness']);
    Router::add('POST', '/login', [$user, 'login']);
    Router::add('POST', '/logout', [$user, 'logout']);
    Router::add('POST', '/recover-account', [$user, 'recover_account']);
    Router::add('POST', '/reset-password', [$user, 'reset_password']);
    Router::add('POST', '/profile/{id}', [$user, 'updateUserProfile']);
    Router::add('PATCH', '/password/{id}', [$user, 'updateUserPassword']);
}, [GuestOnlyMiddleware::class]);
