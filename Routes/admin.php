<?php

use App\Controllers\AdminController;
use App\Routes\Router;
use App\Middleware\AdminOnlyMiddleware;
use App\Controllers\DealerController;
use App\Controllers\VehicleController;

$admin = new AdminController();
$dealer = new DealerController();
$car = new VehicleController();

//Admin Only Routes

Router::group('v1/admin', function () use ($admin, $dealer, $car) {
    Router::add('GET', '/application/admin/{id}', [$admin, 'adminApplicationData']);

    Router::add('GET',  '/dealer', [$dealer, 'index']);
    Router::add('PATCH',  '/dealer/{id}', [$dealer, 'updateDealerInfo']);
    Router::add('DELETE',  '/dealer/{id}', [$dealer, 'deleteDealerInfo']);

    Router::add('POST',  '/car/{id}', [$car, 'updateVehicle']);
    Router::add('DELETE',  '/car/{id}', [$car, 'deleteVehicle']);
}, [AdminOnlyMiddleware::class]);
