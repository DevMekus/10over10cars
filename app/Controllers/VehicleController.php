<?php

namespace App\Controllers;

use App\Services\VehicleService;
use App\Utils\Response;
use App\Utils\RequestValidator;

class VehicleController
{


    public function index()
    {
        $vehicle = VehicleService::fetchAllVehicleInformation();
        if (empty($vehicle)) Response::error(404, "vehicles not found");
        Response::success($vehicle, "vehicles found");
    }


    public function fetchVehicle($id)
    {
        $id = RequestValidator::parseId($id);
        $vehicle = VehicleService::fetchVehicleInformation($id);
        if (empty($vehicle)) Response::error(404, "vehicle not found");
        Response::success($vehicle, "vehicle found");
    }

    public function uploadVehicle()
    {

        $data = RequestValidator::validate([
            'vin' => 'require|min:3',
        ], $_POST);

        $data = RequestValidator::sanitize($data);

        $upload = VehicleService::uploadNewVehicleData($data);


        if ($upload) Response::success(
            ['car' => $data['vin']],
            'vehicle upload successful'
        );
    }

    public function updateVehicle($id)
    {
        $id = RequestValidator::parseId($id);
        $vehicle = VehicleService::fetchVehicleInformation($id);

        if (empty($vehicle)) Response::error(404, "vehicle not found");

        $data = RequestValidator::validate([
            'vin' => 'require',
            'data' => 'require',
        ], $_POST);
        $data = RequestValidator::sanitize(json_decode($data['data'], true));

        $update = VehicleService::updateVehicleInformation($id, $data);

        if ($update) Response::success(
            [],
            'vehicle upload successful'
        );
    }

    public function deleteVehicle($id)
    {
        $id = RequestValidator::parseId($id);
        $vehicle = VehicleService::fetchVehicleInformation($id);

        if (empty($vehicle)) Response::error(404, "vehicle not found");
        $delete = VehicleService::deleteVehicleData($id);
        if ($delete) Response::success(
            [],
            'vehicle delete successful'
        );
    }
}
