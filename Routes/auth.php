<?php

use App\Controllers\AuthController;
use App\Routes\Router;


$auth = new AuthController();

Router::add('POST',  '/auth/login', [$auth, 'login']);
Router::add('POST',  '/auth/register', [$auth, 'register']);
Router::add('POST',  '/auth/logout', [$auth, 'logout']);
Router::add('POST',  '/auth/recover', [$auth, 'recover']);
Router::add('POST',  '/auth/reset', [$auth, 'reset']);
