<?php

use App\Controllers\AdminController;
use App\Routes\Router;
use App\Middleware\AdminOnlyMiddleware;

$admin = new AdminController();

//Admin Only Routes

Router::group('/admin', function () use ($admin) {}, [AdminOnlyMiddleware::class]);
