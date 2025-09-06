<?php

namespace App\Controllers;

use App\Services\VehicleService;
use App\Utils\Response;
use App\Utils\RequestValidator;
use Exception;

/**
 * Class VehicleController
 *
 * Handles all Vehicle-related API requests including CRUD operations.
 * This controller communicates with VehicleService for business logic
 * and uses Response utility for consistent API responses.
 *
 * @package App\Controllers
 */
class VehicleController
{
    /**
     * Retrieve all vehicles.
     *
     * @return void
     */
    public function index(): void
    {
        try {
            $vehicles = VehicleService::fetchAllVehicleInformation();

            if (empty($vehicles)) {
                Response::error(404, "Vehicles not found");
            }

            Response::success($vehicles, "Vehicles found");
        } catch (Exception $e) {
            Response::error(500, "An error occurred while fetching vehicles: " . $e->getMessage());
        }
    }

    /**
     * Fetch details of a single vehicle by ID.
     *
     * @param mixed $id Vehicle ID (string|int).
     * @return void
     */
    public function fetchVehicle($id): void
    {
        try {
            $id = RequestValidator::parseId($id);
            $vehicle = VehicleService::fetchVehicleInformation($id);

            if (empty($vehicle)) {
                Response::error(404, "Vehicle not found");
            }

            Response::success($vehicle, "Vehicle found");
        } catch (Exception $e) {
            Response::error(500, "An error occurred while fetching the vehicle: " . $e->getMessage());
        }
    }

    /**
     * Upload a new vehicle record.
     *
     * Expects `vin` in POST request.
     *
     * @return void
     */
    public function uploadVehicle(): void
    {
        try {
            $data = RequestValidator::validate([
                'vin' => 'require|min:3',
            ], $_POST);

            $data = RequestValidator::sanitize($data);

            $upload = VehicleService::uploadNewVehicleData($data);

            if ($upload) {
                Response::success(
                    ['car' => $data['vin']],
                    'Vehicle upload successful'
                );
            } else {
                Response::error(500, "Failed to upload vehicle");
            }
        } catch (Exception $e) {
            Response::error(500, "An error occurred while uploading the vehicle: " . $e->getMessage());
        }
    }

    /**
     * Update an existing vehicle record.
     *
     * Expects `vin` and `data` in POST request.
     *
     * @param mixed $id Vehicle ID.
     * @return void
     */
    public function updateVehicle($id): void
    {
        try {
            $id = RequestValidator::parseId($id);
            $vehicle = VehicleService::fetchVehicleInformation($id);

            if (empty($vehicle)) {
                Response::error(404, "Vehicle not found");
            }

            $data = RequestValidator::validate([
                'vin'  => 'require',
                'data' => 'require',
            ], $_POST);

            $data = RequestValidator::sanitize(json_decode($data['data'], true));

            $update = VehicleService::updateVehicleInformation($id, $data);

            if ($update) {
                Response::success([], 'Vehicle update successful');
            } else {
                Response::error(500, "Failed to update vehicle");
            }
        } catch (Exception $e) {
            Response::error(500, "An error occurred while updating the vehicle: " . $e->getMessage());
        }
    }

    /**
     * Delete a vehicle by ID.
     *
     * @param mixed $id Vehicle ID.
     * @return void
     */
    public function deleteVehicle($id): void
    {
        try {
            $id = RequestValidator::parseId($id);
            $vehicle = VehicleService::fetchVehicleInformation($id);

            if (empty($vehicle)) {
                Response::error(404, "Vehicle not found");
            }

            $delete = VehicleService::deleteVehicleData($id);

            if ($delete) {
                Response::success([], 'Vehicle delete successful');
            } else {
                Response::error(500, "Failed to delete vehicle");
            }
        } catch (Exception $e) {
            Response::error(500, "An error occurred while deleting the vehicle: " . $e->getMessage());
        }
    }
}
