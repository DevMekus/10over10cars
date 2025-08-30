<?php

use App\Controllers\UserController;
use App\Routes\Router;
use App\Middleware\UserOnlyMiddleware;
use App\Controllers\DealerController;
use App\Controllers\VehicleController;


$user = new UserController();
$dealer = new DealerController();
$car = new VehicleController();


//General Routes for the User and Admin

Router::group('/v1', function () use ($dealer, $car) {
    Router::add('GET',  '/dealer/{id}', [$dealer, 'findADealer']);
    Router::add('POST',  '/dealer', [$dealer, 'dealerRegistration']);

    Router::add('POST',  '/car', [$car, 'uploadVehicle']);
}, [UserOnlyMiddleware::class]);
