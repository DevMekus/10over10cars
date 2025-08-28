<?php

use App\Controllers\UserController;
use App\Routes\Router;
use App\Middleware\UserOnlyMiddleware;
use App\Controllers\DealerController;


$user = new UserController();
$dealer = new DealerController();


//General Routes for the User and Admin

Router::group('/v1', function () use ($dealer) {
    Router::add('GET',  '/dealer/{id}', [$dealer, 'findADealer']);
    Router::add('POST',  '/dealer', [$dealer, 'dealerRegistration']);
}, [UserOnlyMiddleware::class]);
