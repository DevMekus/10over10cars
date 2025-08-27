<?php

use App\Controllers\AdminController;
use App\Routes\Router;
use App\Middleware\AdminOnlyMiddleware;

$admin = new AdminController();

//Admin Only Routes

Router::group('/admin', function () use ($admin) {
    // Router::add('GET',  '/overview', [$admin, 'overview']);
    // Router::add('GET',  '/profile', [$admin, 'findUsers']);
    // Router::add('DELETE',  '/profile/{id}', [$admin, 'deleteUser']);

    // #logs
    // Router::add('GET',  '/logs', [$admin, 'activityLogs']);

    // #Dealers
    // Router::add('GET',  '/profile/dealers/overview', [$admin, 'dealerOverview']);
    // Router::add('GET',  '/profile/dealers', [$admin, 'findAllDealers']);
    // Router::add('DELETE',  '/profile/dealers/{id}', [$admin, 'deleteDealer']);

    // #Theft-Reports
    // Router::add('GET',  '/report/theft', [$admin, 'theftReportings']);
    // Router::add('PATCH',  '/report/theft/{id}', [$admin, 'updateTheftReport']);
    // Router::add('DELETE',  '/report/theft/{id}', [$admin, 'deleteTheftReport']);

    // #vehicles
    // Router::add('GET',  '/vehicles/overview', [$admin, 'vehicleOverview']);
    // Router::add('GET',  '/vehicles', [$admin, 'vehiclesInformation']);
    // Router::add('PUT',  '/vehicles/{id}', [$admin, 'updateVehicleData']);
    // Router::add('DELETE',  '/vehicles/uploads/{id}', [$admin, 'deleteVehicleUploads']);
    // Router::add('POST',  '/vehicles/uploads/{id}', [$admin, 'vehicleDataUpload']);

    // #Verifications
    // Router::add('GET',  '/verification', [$admin, 'allVerificationRequests']);
    // Router::add('PATCH',  '/verification/{id}', [$admin, 'updateVerificationRequest']);
    // Router::add('DELETE',  '/verification/{id}', [$admin, 'deleteVerificationRequest']);
}, [AdminOnlyMiddleware::class]);
