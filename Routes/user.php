<?php

use App\Controllers\UserController;
use App\Routes\Router;
use App\Middleware\UserOnlyMiddleware;


$user = new UserController();

//General Routes for the User and Admin

Router::group('/user', function () use ($user) {
   
    
}, [UserOnlyMiddleware::class]);
