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
        $dealer = Utility::$dealers_tbl;
        try {
            return Database::joinTables(
                "$vehicles info",
                [
                    [
                        "type" => "LEFT",
                        "table" => "$dealer dealer",
                        "on" => "dealer.userid = info.userid"
                    ],
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
                ["info.*", "owner.ownership", "specs.specs", "accident.notes", "insurance.notes", "dealer.company"],
                [
                    "OR" => [
                        "info.userid" => $id,
                        "info.vin" => $id,
                        "info.id" => $id,
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
        $dealer = Utility::$dealers_tbl;
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
                        "table" => "$dealer dealer",
                        "on" => "dealer.userid = info.userid"
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
                ["info.*", "owner.ownership", "specs.specs", "accident.notes", "insurance.notes", "dealer.company"],
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

    public static function uploadNewVehicleData($data)
    {
        $vehicleTable = Utility::$vehicles_tbl;
        $accident = Utility::$accident_tbl;
        $insurance = Utility::$insurance_tbl;
        $ownership = Utility::$ownership_tbl;
        $specs = Utility::$specifications_tbl;
        $dealers_tbl = Utility::$dealers_tbl;

        $tableArray = [$accident, $insurance, $ownership, $specs];

        try {
            $vehicle = Database::find($vehicleTable, $data['vin'], 'vin');
            if ($vehicle) Response::error(409, "Vehicle already exist");

            $uploadData = [
                'userid' => $data['userid'] ?? $_SESSION['userid'],
                'title' => $data['title'],
                'price' => intval($data['price']) ?? 0,
                'mileage' => $data['mileage'],
                'vin' => $data['vin'],
                'images' => null,
                'documents' => null,
                'make' => $data['make'] !== "" ? $data['make'] : $data['cmake'],
                'model' => $data['model'] !== "" ? $data['model'] : $data['cmodel'],
                'trim' => $data['trim'],
                'body_type' => $data['body_type'],
                'fuel' => $data['fuel'],
                'drive_type' => $data['drive_type'],
                'engine_number' => $data['engine_number'],
                'transmission' => $data['transmission'],
                'exterior_color' => $data['exterior_color'] !== "" ? $data['exterior_color'] : $data['cexterior_color'],
                'interior_color' => $data['interior_color'] !== "" ? $data['interior_color'] : $data['cinterior_color'],
                'year' => $data['year'],
                'notes' => $data['notes'],
            ];


            //Upload Images
            if (
                isset($_FILES['vehicleImages']) &&
                !empty($_FILES['vehicleImages']['name'][0])
            ) {
                $target_dir = "public/UPLOADS/vehicles/images/";

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
                $target_dir = "public/UPLOADS/vehicles/docs/";
                $vehicle_docs = Utility::uploadDocuments('vehicleDocs', $target_dir);
                if (!$vehicle_docs || !$vehicle_docs['success']) {
                    Response::error(500, "File upload failed");
                }

                $uploadData['documents'] = json_encode($vehicle_docs['files']);
            }

            if (Database::insert($vehicleTable, $uploadData)) {

                foreach ($tableArray as $table) {
                    Database::insert($table, ['vin' => $uploadData['vin']]);
                }

                //Update Dealer Listing
                $getDealer = DealerService::fetchDealerInformation($uploadData['userid']);
                if (empty($getDealer)) {
                    //--Create a dealer account and increase listing
                } else {
                    $dealer = $getDealer[0];
                    $increase_listing = intval($dealer['listings']) + 1;
                    $updateListing = ['listings' => $increase_listing];
                    Database::update($dealers_tbl,  $updateListing, ["userid" => $uploadData['userid']]);
                }

                Activity::activity([
                    'userid' => $data['userid'] ?? $_SESSION['userid'],
                    'type' => 'vehicle',
                    'title' => 'vehicle upload successful',
                ]);
                return true;
            }
        } catch (\Throwable $th) {

            Utility::log($th->getMessage(), 'error', 'VehicleService::uploadNewVehicleData', ['vin' => $uploadData['vin']], $th);
            Response::error(500, "An error occurred while uploading new vehicle");
        }
    }

    public static function updateVehicleInformation($id, $data)
    {
        try {
            $vehicle = self::fetchVehicleInformation($id);

            if (empty($data['table'])) {
                Response::error(400, "No table specified for update");
            }

            $table = $data['table'];

            // map table name → handler function
            $handlers = [
                Utility::$vehicles_tbl       => 'updateVehicleCore',
                Utility::$accident_tbl       => 'updateAccident',
                Utility::$insurance_tbl      => 'updateInsurance',
                Utility::$ownership_tbl      => 'updateOwnership',
                Utility::$specifications_tbl => 'updateSpecifications',
            ];

            if (!array_key_exists($table, $handlers)) {
                Response::error(400, "Invalid table name supplied");
            }

            // dynamically call correct update method
            $method = $handlers[$table];

            if (self::$method($id, $data, $vehicle[0])) {
                Activity::activity([
                    'userid' => $vehicle[0]['userid'] ?? $_SESSION['userid'],
                    'type' => 'Car',
                    'title' => 'Car update successful',
                ]);
                return true;
            }
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'VehicleService::updateVehicleInformation', ['vin' => $id], $th);
            Response::error(500, $th->getMessage());
        }
    }

    private static function updateVehicleCore($id, $data, $vehicle)
    {
        $table = Utility::$vehicles_tbl;



        $update = [
            'userid' =>  $vehicle['userid'],
            'title' => isset($data['title']) ? $data['title'] : $vehicle['title'],
            'price' => isset($data['price']) ? intval($data['price']) : intval($vehicle['price']),
            'mileage' => isset($data['mileage']) ? $data['mileage'] : $vehicle['mileage'],
            'vin' =>  $vehicle['vin'],
            'status' => isset($data['status']) ? $data['status'] : $vehicle['status'],
            'make' => isset($data['make']) ? $data['make'] : $vehicle['make'],
            'model' => isset($data['model']) ? $data['model'] : $vehicle['model'],
            'trim' => isset($data['trim']) ? $data['trim'] : $vehicle['trim'],
            'body_type' => isset($data['body_type']) ? $data['body_type'] : $vehicle['body_type'],
            'fuel' => isset($data['fuel']) ? $data['fuel'] : $vehicle['fuel'],
            'drive_type' => isset($data['drive_type']) ? $data['drive_type'] : $vehicle['drive_type'],
            'engine_number' => isset($data['engine_number']) ? $data['engine_number'] : $vehicle['engine_number'],
            'transmission' => isset($data['transmission']) ? $data['transmission'] : $vehicle['transmission'],
            'exterior_color' => isset($data['exterior_color']) ? $data['exterior_color'] : $vehicle['exterior_color'],
            'interior_color' => isset($data['interior_color']) ? $data['interior_color'] : $vehicle['interior_color'],
            'year' => isset($data['year']) ? $data['year'] : $vehicle['year'],
            'notes' => isset($data['notes']) ? $data['notes'] : $vehicle['notes'],
        ];



        if (
            isset($_FILES['vehicleImages']) &&
            $_FILES['vehicleImages']['error'] === UPLOAD_ERR_OK &&
            is_uploaded_file($_FILES['vehicleImages']['tmp_name'])
        ) {
            $target_dir = "public/UPLOADS/vehicles/images/";

            $vehicle_image = Utility::uploadDocuments('vehicleImages', $target_dir);

            if (!$vehicle_image || !$vehicle_image['success']) {
                Response::error(500, "Image upload failed");
            }

            $previousImages = json_decode($vehicle['images'], true);
            $mergedImages = array_merge($vehicle_image['files'], $previousImages);

            $update['images'] = json_encode($mergedImages);
        }

        if (
            isset($_FILES['vehicleDocs']) &&
            !empty($_FILES['vehicleDocs']['name'][0])
        ) {
            $target_dir = "public/UPLOADS/vehicles/docs/";
            $vehicle_docs = Utility::uploadDocuments('vehicleDocs', $target_dir);
            if (!$vehicle_docs || !$vehicle_docs['success']) {
                Response::error(500, "File upload failed");
            }

            $previousDocs = json_decode($vehicle['documents'], true);
            $mergedDocs = array_merge($vehicle_docs['files'], $previousDocs);
            $update['documents'] = json_encode($mergedDocs);
        }


        return  Database::update($table, $update, ["id" => $id]);
    }

    private static function updateAccident($id, $data, $prev)
    {
        $table = Utility::$accident_tbl;
        $update = [
            'notes' => $data['notes']
        ];

        return Database::update($table, $update, ["vin" => $id]);
    }

    private static function updateInsurance($id, $data, $prev)
    {
        $table = Utility::$insurance_tbl;
        $update = [
            'notes' => $data['notes']
        ];

        return Database::update($table, $update, ["vin" => $id]);
    }

    private static function updateOwnership($id, $data, $prev)
    {
        $table = Utility::$ownership_tbl;
        $update = [
            'ownership' => $data['ownership']
        ];

        return Database::update($table, $update, ["vin" => $id]);
    }

    private static function updateSpecifications($id, $data, $prev)
    {
        $table = Utility::$specifications_tbl;
        $update = [
            'specs' => $data['specs']
        ];

        return Database::update($table, $update, ["vin" => $id]);
    }



    public static function deleteVehicleData($id)
    {
        $vehicles = Utility::$vehicles_tbl;
        $accident = Utility::$accident_tbl;
        $insurance = Utility::$insurance_tbl;
        $ownership = Utility::$ownership_tbl;
        $specs = Utility::$specifications_tbl;

        try {
            $vehicle = self::fetchVehicleInformation($id);

            $currentVehicle = $vehicle[0];

            if (isset($currentVehicle['images'])) {

                $target_dir = "public/UPLOADS/vehicles/images/";
                $images = json_decode($currentVehicle['images'], true);

                foreach ($images as $image) {
                    $filenameFromUrl = basename($image);
                    $file = "../" . $target_dir  . $filenameFromUrl;
                    if (file_exists($file))
                        unlink($file);
                }
            }

            if (isset($currentVehicle['documents'])) {
                $target_dir = "public/UPLOADS/vehicles/docs/";
                $documents = json_decode($currentVehicle['documents'], true);
                foreach ($documents as $doc) {
                    $filenameFromUrl = basename($doc);
                    $file = "../" . $target_dir  . $filenameFromUrl;
                    if (file_exists($file))
                        unlink($file);
                }
            }

            $tableArray = [$vehicles, $accident, $insurance, $ownership, $specs];
            $start = false;

            foreach ($tableArray as $table) {
                $start = true;
                Database::delete($table, ["vin" => $currentVehicle['vin']]);
            }
            if ($start) {
                if (Activity::activity([
                    'userid' =>  $currentVehicle['userid'] ?? $_SESSION['userid'],
                    'type' => 'Car',
                    'title' => 'vehicle delete successful',
                ]));

                return true;
            }
        } catch (\Throwable $th) {

            Utility::log($th->getMessage(), 'error', 'VehicleService::deleteVehicleData', ['vin' => $id], $th);
            Response::error(500, "An error occurred while deleting vehicles details");
        }
    }
}
