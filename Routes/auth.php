<?php

use App\Controllers\UserController;
use App\Routes\Router;


$user = new UserController;

Router::add('POST',  '/login', [$user, 'login']);
Router::add('POST',  'register', [$user, 'register']);
Router::add('POST',  '/logout', [$user, 'logout']);
Router::add('POST',  '/auth/recover', [$user, 'recover']);
Router::add('POST',  '/auth/reset', [$user, 'reset']);
