<?php

use App\Controllers\UserController;
use App\Routes\Router;
use App\Middleware\UserOnlyMiddleware;
use App\Controllers\DealerController;
use App\Controllers\VehicleController;
use App\Controllers\TransactionController;
use App\Controllers\VerificationController;
use App\Controllers\AuthController;


$user = new UserController();
$dealer = new DealerController();
$car = new VehicleController();
$transaction = new TransactionController();
$verify = new VerificationController();
$auth = new AuthController();


//General Routes for the User and Admin

Router::group('/v1', function () use ($auth, $dealer, $car, $user, $transaction, $verify) {

    Router::add('GET', '/application/user/{id}', [$user, 'userApplicationData']);

    #UserController routes
    Router::add('GET',  '/user/{id}', [$user, 'userProfile']);
    Router::add('GET',  '/user/session/{id}', [$auth, 'getUserSessions']);
    Router::add('POST',  '/user/{id}', [$user, 'updateUserProfile']);
    Router::add('POST',  '/user/password/{id}', [$user, 'updateUserPassword']);
    Router::add('DELETE',  '/user/session/{id}', [$auth, 'revokeSession']);


    Router::add('GET',  '/dealer/{id}', [$dealer, 'findADealer']);
    Router::add('POST',  '/dealer', [$dealer, 'dealerRegistration']);

    #verification routes
    Router::add('GET',  '/verification/{id}', [$verify, 'fetchVerification']);
    Router::add('POST',  '/car', [$car, 'uploadVehicle']);

    #Transaction routes
    Router::add('GET',  '/transaction/{id}', [$transaction, 'findTransaction']);
}, [UserOnlyMiddleware::class]);
