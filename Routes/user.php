<?php

use App\Controllers\UserController;
use App\Routes\Router;
use App\Middleware\UserOnlyMiddleware;


$user = new UserController();

//General Routes for the User and Admin

Router::group('/user', function () use ($user) {
    Router::add('GET',  '/profile/{id}', [$user, 'findUser']);
    Router::add('POST',  '/profile/{id}', [$user, 'updateProfile']);

    #logs
    Router::add('GET',  '/logs/{id}', [$user, 'activityLogs']);

    #dealer
    Router::add('GET',  '/profile/dealers/{id}', [$user, 'findADealer']);
    Router::add('PATCH',  '/profile/dealers/{id}', [$user, 'updateDealerInfo']);
    Router::add('POST',  '/profile/dealers', [$user, 'dealerRegistration']);

    #theft report
    Router::add('GET',  '/report/theft/{id}', [$user, 'theftReportings']);
    Router::add('POST',  '/report/theft', [$user, 'newTheftReport']);

    #vehicles
    Router::add('GET',  '/vehicles/{id}', [$user, 'vehicleInformation']);

    #Verifications
    Router::add('GET',  '/verification/{id}', [$user, 'verificationRequest']);
    Router::add('POST',  '/verification', [$user, 'newVerificationRequest']);
}, [UserOnlyMiddleware::class]);
