<?php

namespace App\Services;

use App\Utils\Response;
use configs\Database;
use App\Services\Activity;
use App\Utils\Utility;

class VehicleService
{

    public static function fetchVehicleInformation($id)
    {
        $vehicles = Utility::$vehicles_tbl;
        $accident = Utility::$accident_tbl;
        $insurance = Utility::$insurance_tbl;
        $ownership = Utility::$ownership_tbl;
        $specs = Utility::$specifications_tbl;
        try {
            return Database::joinTables(
                "$vehicles info",
                [
                    [
                        "type" => "LEFT",
                        "table" => "$ownership owner",
                        "on" => "owner.vin = info.vin"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$specs specs",
                        "on" => "specs.vin = info.vin"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$accident accident",
                        "on" => "accident.vin = info.vin"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$insurance insurance",
                        "on" => "insurance.vin = info.vin"
                    ],
                ],
                ["info.*", "owner.ownership", "specs.specs", "accident.notes", "insurance.notes"],
                [
                    "OR" => [
                        "info.userid" => $id,
                        "info.vin" => $id,
                    ]
                ],
                ["order" => "info.id DESC"]
            );
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'VehicleService::fetchVehicleInformation', ['vin' => $id], $th);
            Response::error(500, "An error occurred while fetching vehicles details");
        }
    }

    public static function fetchAllVehicleInformation()
    {
        $vehicles = Utility::$vehicles_tbl;
        $accident = Utility::$accident_tbl;
        $insurance = Utility::$insurance_tbl;
        $ownership = Utility::$ownership_tbl;
        $specs = Utility::$specifications_tbl;
        try {
            return Database::joinTables(
                "$vehicles info",
                [
                    [
                        "type" => "LEFT",
                        "table" => "$ownership owner",
                        "on" => "owner.vin = info.vin"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$specs specs",
                        "on" => "specs.vin = info.vin"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$accident accident",
                        "on" => "accident.vin = info.vin"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$insurance insurance",
                        "on" => "insurance.vin = info.vin"
                    ],
                ],
                ["info.*", "owner.ownership", "specs.specs", "accident.notes", "insurance.notes"],
                [],
                ["order" => "info.id DESC"]
            );
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'VehicleService::fetchAllVehicleInformation', ['userid' => $_SESSION['userid']], $th);
            Response::error(500, "An error occurred while fetching all vehicles details");
        }
    }

    public static function sendVehicleInformation($id)
    {
        $data = self::fetchVehicleInformation($id);
        if (empty($data)) {
            Response::error(404, "Vehicle information not found");
        }
        Response::success($data[0], "Vehicle information found");
    }

    public static function sendAllVehicleInformation()
    {
        $data = self::fetchAllVehicleInformation();
        if (empty($data)) {
            Response::error(404, "Vehicles information not found");
        }
        Response::success($data, "Vehicles information found");
    }

    public function uploadNewVehicleData($data)
    {
        $vehicles = Utility::$vehicles_tbl;
        $accident = Utility::$accident_tbl;
        $insurance = Utility::$insurance_tbl;
        $ownership = Utility::$ownership_tbl;
        $specs = Utility::$specifications_tbl;

        $tableArray = [$accident, $insurance, $ownership, $specs];
        try {
            $vehicle = Database::find($vehicles, $data['vin'], 'vin');
            if ($vehicle) Response::error(409, "Vehicle already exist");

            $uploadData = [];
            foreach ($data as $key => $value) {
                if ($value !== "") $newData[$key] = $value;
            }

            //Upload Images
            if (
                isset($_FILES['vehicleImages']) &&
                !empty($_FILES['vehicleImages']['name'][0])
            ) {
                $target_dir = "public/UPLOADS/vehicles/";

                $vehicle_image = Utility::uploadDocuments('vehicleImages', $target_dir);

                if (!$vehicle_image || !$vehicle_image['success']) {
                    Response::error(500, "Image upload failed");
                }

                $uploadData['images'] = json_encode($vehicle_image['files']);
            }

            //Upload docs
            if (
                isset($_FILES['vehicleDocs']) &&
                !empty($_FILES['vehicleDocs']['name'][0])
            ) {
                $target_dir = "public/UPLOADS/documents/";
                $vehicle_docs = Utility::uploadDocuments('vehicleDocs', $target_dir);
                if (!$vehicle_docs || !$vehicle_docs['success']) {
                    Response::error(500, "File upload failed");
                }

                $uploadData['documents'] = json_encode($vehicle_docs['files']);
            }

            if (Database::insert($vehicle, $uploadData)) {

                foreach ($tableArray as $table) {
                    Database::insert($table, ['vin' => $uploadData['vin']]);
                }

                Activity::activity([
                    'userid' => $data['userid'] ?? $_SESSION['userid'],
                    'type' => 'vehicle',
                    'title' => 'vehicle upload successful',
                ]);
                Response::success(['vehicle' => $uploadData['vin']], 'vehicle upload successful');
            }
        } catch (\Throwable $th) {

            Utility::log($th->getMessage(), 'error', 'VehicleService::uploadNewVehicleData', ['vin' => $uploadData['vin']], $th);
            Response::error(500, "An error occurred while uploading new vehicle");
        }
    }

    public static function updateVehicleInformation($id, $data)
    {
        $vehicles = Utility::$vehicles_tbl;
        $accident = Utility::$accident_tbl;
        $insurance = Utility::$insurance_tbl;
        $ownership = Utility::$ownership_tbl;
        $specs = Utility::$specifications_tbl;

        $tableArray = [$vehicles, $accident, $insurance, $ownership, $specs];
        try {
            $vehicle = self::fetchVehicleInformation($id);
            if (empty($vehicle)) Response::error(404, "Vehicle not found");

            $currentVehicle = $vehicle[0];

            foreach ($tableArray as $table) {
                if ($table == $data['table']) {
                    if ($table == 'vehicles_tbl') {
                    }

                    if ($table == 'accident') {
                    }

                    if ($table == 'insurance') {
                    }

                    if ($table == 'ownership') {
                    }

                    if ($table == 'specifications') {
                    }
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function deleteVehicleData($id)
    {
        $vehicles = Utility::$vehicles_tbl;
        $accident = Utility::$accident_tbl;
        $insurance = Utility::$insurance_tbl;
        $ownership = Utility::$ownership_tbl;
        $specs = Utility::$specifications_tbl;

        try {
            $vehicle = self::fetchVehicleInformation($id);
            if (empty($vehicle)) Response::error(404, "Vehicle not found");

            $currentVehicle = $vehicle[0];
            $tableArray = [$vehicles, $accident, $insurance, $ownership, $specs];
            $start = false;

            foreach ($tableArray as $table) {
                $start = true;
                if ($table == 'vehicles_tbl') {
                    if (isset($currentVehicle['images'])) {
                        $target_dir = "public/UPLOADS/vehicles/";

                        foreach ($currentVehicle['images'] as $image) {
                            $filenameFromUrl = basename($image);
                            $file = "../" . $target_dir  . $filenameFromUrl;
                            if (file_exists($file))
                                unlink($file);
                        }
                    }

                    if (isset($currentVehicle['documents'])) {
                        $target_dir = "public/UPLOADS/documents/";

                        foreach ($currentVehicle['documents'] as $doc) {
                            $filenameFromUrl = basename($doc);
                            $file = "../" . $target_dir  . $filenameFromUrl;
                            if (file_exists($file))
                                unlink($file);
                        }
                    }
                }

                Database::delete($table, ["vin" => $currentVehicle['vin']]);
            }
            if ($start) {
                if (Activity::activity([
                    'userid' =>  $_SESSION['userid'],
                    'type' => 'delete',
                    'title' => 'vehicle delete successful',
                ]));
                Response::success([], "Vehicle data deleted");
            }
        } catch (\Throwable $th) {

            Utility::log($th->getMessage(), 'error', 'WorkShopService::deleteVehicleData', ['vin' => $id], $th);
            Response::error(500, "An error occurred while deleting vehicles details");
        }
    }
}
