<?php

use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Routes\Router;
use App\Middleware\GuestOnlyMiddleware;
use App\Controllers\VehicleController;
use App\Controllers\VerificationController;

$auth = new AuthController();
$user = new UserController();
$car = new VehicleController();
$verification = new VerificationController();


Router::group('v1', function () use ($auth, $user, $car, $verification) {
    #Authentication
    Router::add('POST', '/auth/login', [$auth, 'login']); //pass
    Router::add('POST', '/auth/register', [$auth, 'register']); //pass
    Router::add('POST', '/auth/logout', [$auth, 'logout']); //pass
    Router::add('POST', '/auth/recover', [$auth, 'recoverAccount']); //
    Router::add('POST', '/auth/reset', [$auth, 'resetAccountPassword']); //pass

    #Application
    Router::add('GET', '/application/guest', [$user, 'guestApplicationData']); //pass
    Router::add('GET',  '/car/{vin}', [$car, 'fetchVehicle']);
    Router::add('GET',  '/car', [$car, 'index']);

    #verification
    Router::add('POST',  '/payment/verify', [$verification, 'postVerificationRequest']);
}, [GuestOnlyMiddleware::class]);
