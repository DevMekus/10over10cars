<?php

use App\Controllers\AdminController;
use App\Routes\Router;
use App\Middleware\AdminOnlyMiddleware;
use App\Controllers\DealerController;
use App\Controllers\VehicleController;
use App\Controllers\VerificationController;
use App\Controllers\TransactionController;

$admin = new AdminController();
$dealer = new DealerController();
$car = new VehicleController();
$verification = new VerificationController();
$transact = new TransactionController();

//Admin Only Routes

Router::group('v1/admin', function () use ($admin, $dealer, $car, $verification, $transact) {
    Router::add('GET', '/application/admin/{id}', [$admin, 'adminApplicationData']);

    #dealer
    Router::add('GET',  '/dealer', [$dealer, 'index']);
    Router::add('PATCH',  '/dealer/{id}', [$dealer, 'updateDealerInfo']);
    Router::add('DELETE',  '/dealer/{id}', [$dealer, 'deleteDealerInfo']);

    #car
    Router::add('POST',  '/car/{id}', [$car, 'updateVehicle']);
    Router::add('DELETE',  '/car/{id}', [$car, 'deleteVehicle']);

    #verification
    Router::add('GET',  '/verification', [$verification, 'index']);
    Router::add('PATCH',  '/verification/{id}', [$verification, 'updateVerification']);

    #transaction
    Router::add('DELETE',  '/transaction/{id}', [$transact, 'deleteTransaction']);
}, [AdminOnlyMiddleware::class]);
