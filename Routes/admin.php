<?php

use App\Controllers\AdminController;
use App\Routes\Router;
use App\Middleware\AdminOnlyMiddleware;
use App\Controllers\DealerController;

$admin = new AdminController();
$dealer = new DealerController();

//Admin Only Routes

Router::group('v1/admin', function () use ($admin, $dealer) {
    Router::add('GET', '/application/admin', [$admin, 'adminApplicationData']);

    Router::add('GET',  '/dealer', [$dealer, 'index']);
    Router::add('PATCH',  '/dealer/{id}', [$dealer, 'updateDealerInfo']);
}, [AdminOnlyMiddleware::class]);
