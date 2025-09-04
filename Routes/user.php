<?php

use App\Controllers\UserController;
use App\Routes\Router;
use App\Middleware\UserOnlyMiddleware;
use App\Controllers\DealerController;
use App\Controllers\VehicleController;
use App\Controllers\TransactionController;
use App\Controllers\VerificationController;


$user = new UserController();
$dealer = new DealerController();
$car = new VehicleController();
$transaction = new TransactionController();
$verify = new VerificationController();


//General Routes for the User and Admin

Router::group('/v1', function () use ($dealer, $car, $user, $transaction, $verify) {

    Router::add('GET', '/application/user/{id}', [$user, 'userApplicationData']);

    #UserController routes
    Router::add('GET',  '/user/{id}', [$user, 'userProfile']);
    Router::add('PUT',  '/user/{id}', [$user, 'updateUserProfile']);


    Router::add('GET',  '/dealer/{id}', [$dealer, 'findADealer']);
    Router::add('POST',  '/dealer', [$dealer, 'dealerRegistration']);

    #verification routes
    Router::add('GET',  '/verification/{id}', [$verify, 'fetchVerification']);
    Router::add('POST',  '/car', [$car, 'uploadVehicle']);

    #Transaction routes
    Router::add('GET',  '/transaction/{id}', [$transaction, 'findTransaction']);
}, [UserOnlyMiddleware::class]);
