<?php

namespace App\Services;

use App\Utils\Response;
use configs\Database;
use App\Services\Activity;
use App\Utils\Utility;

/**
 * Service class for managing vehicle-related operations.
 *
 * Handles vehicle CRUD, document uploads, and relational data updates
 * such as accident reports, insurance details, ownership, and specifications.
 */
class VehicleService
{
    /**
     * Fetch detailed vehicle information by VIN, user ID, or vehicle ID.
     *
     * @param string|int $id Vehicle identifier (VIN, user ID, or database ID).
     * @return array|null Vehicle details or null on failure.
     */
    public static function fetchVehicleInformation($id)
    {
        $vehicles   = Utility::$vehicles_tbl;
        $accident   = Utility::$accident_tbl;
        $insurance  = Utility::$insurance_tbl;
        $ownership  = Utility::$ownership_tbl;
        $specs      = Utility::$specifications_tbl;
        $dealer     = Utility::$dealers_tbl;

        try {
            return Database::joinTables(
                "$vehicles info",
                [
                    ["type" => "LEFT", "table" => "$dealer dealer", "on" => "dealer.userid = info.userid"],
                    ["type" => "LEFT", "table" => "$ownership owner", "on" => "owner.vin = info.vin"],
                    ["type" => "LEFT", "table" => "$specs specs", "on" => "specs.vin = info.vin"],
                    ["type" => "LEFT", "table" => "$accident accident", "on" => "accident.vin = info.vin"],
                    ["type" => "LEFT", "table" => "$insurance insurance", "on" => "insurance.vin = info.vin"],
                ],
                ["info.*", "owner.ownership", "specs.specs", "accident.notes", "insurance.notes", "dealer.company"],
                [
                    "OR" => [
                        "info.userid" => $id,
                        "info.vin"    => $id,
                        "info.id"     => $id,
                    ]
                ],
                ["order" => "info.id DESC"]
            );
        } catch (\Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'VehicleService::fetchVehicleInformation',
                ['vin' => $id],
                $th
            );
            Response::error(500, "An error occurred while fetching vehicles details");
        }
    }

    /**
     * Fetch all vehicles and their details.
     *
     * @return array|null List of vehicles or null on failure.
     */
    public static function fetchAllVehicleInformation()
    {
        $vehicles   = Utility::$vehicles_tbl;
        $accident   = Utility::$accident_tbl;
        $insurance  = Utility::$insurance_tbl;
        $ownership  = Utility::$ownership_tbl;
        $specs      = Utility::$specifications_tbl;
        $dealer     = Utility::$dealers_tbl;

        try {
            return Database::joinTables(
                "$vehicles info",
                [
                    ["type" => "LEFT", "table" => "$ownership owner", "on" => "owner.vin = info.vin"],
                    ["type" => "LEFT", "table" => "$dealer dealer", "on" => "dealer.userid = info.userid"],
                    ["type" => "LEFT", "table" => "$specs specs", "on" => "specs.vin = info.vin"],
                    ["type" => "LEFT", "table" => "$accident accident", "on" => "accident.vin = info.vin"],
                    ["type" => "LEFT", "table" => "$insurance insurance", "on" => "insurance.vin = info.vin"],
                ],
                ["info.*", "owner.ownership", "specs.specs", "accident.notes", "insurance.notes", "dealer.company"],
                [],
                ["order" => "info.id DESC"]
            );
        } catch (\Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'VehicleService::fetchAllVehicleInformation',
                ['userid' => $_SESSION['userid']],
                $th
            );
            Response::error(500, "An error occurred while fetching all vehicles details");
        }
    }

    /**
     * Upload a new vehicle and associated relational records.
     *
     * @param array $data Vehicle data.
     * @return bool True if successful.
     */
    public static function uploadNewVehicleData($data)
    {
        $vehicleTable = Utility::$vehicles_tbl;
        $accident     = Utility::$accident_tbl;
        $insurance    = Utility::$insurance_tbl;
        $ownership    = Utility::$ownership_tbl;
        $specs        = Utility::$specifications_tbl;
        $dealers_tbl  = Utility::$dealers_tbl;

        $tableArray = [$accident, $insurance, $ownership, $specs];

        try {
            // Prevent duplicate VIN
            $vehicle = Database::find($vehicleTable, $data['vin'], 'vin');
            if ($vehicle) {
                Response::error(409, "Vehicle already exist");
            }

            $uploadData = [
                'userid'         => $data['userid'] ?? $_SESSION['userid'],
                'title'          => $data['title'],
                'price'          => intval($data['price']) ?? 0,
                'mileage'        => $data['mileage'],
                'vin'            => $data['vin'],
                'images'         => null,
                'documents'      => null,
                'make'           => $data['make'] !== "" ? $data['make'] : $data['cmake'],
                'model'          => $data['model'] !== "" ? $data['model'] : $data['cmodel'],
                'trim'           => $data['trim'],
                'body_type'      => $data['body_type'],
                'fuel'           => $data['fuel'],
                'drive_type'     => $data['drive_type'],
                'engine_number'  => $data['engine_number'],
                'transmission'   => $data['transmission'],
                'exterior_color' => $data['exterior_color'] !== "" ? $data['exterior_color'] : $data['cexterior_color'],
                'interior_color' => $data['interior_color'] !== "" ? $data['interior_color'] : $data['cinterior_color'],
                'year'           => $data['year'],
                'notes'          => $data['notes'],
            ];

            // Handle image upload
            if (!empty($_FILES['vehicleImages']['name'][0])) {
                $target_dir   = "public/UPLOADS/vehicles/images/";
                $vehicle_image = Utility::uploadDocuments('vehicleImages', $target_dir);

                if (!$vehicle_image || !$vehicle_image['success']) {
                    Response::error(500, "Image upload failed");
                }
                $uploadData['images'] = json_encode($vehicle_image['files']);
            }

            // Handle docs upload
            if (!empty($_FILES['vehicleDocs']['name'][0])) {
                $target_dir   = "public/UPLOADS/vehicles/docs/";
                $vehicle_docs = Utility::uploadDocuments('vehicleDocs', $target_dir);

                if (!$vehicle_docs || !$vehicle_docs['success']) {
                    Response::error(500, "File upload failed");
                }
                $uploadData['documents'] = json_encode($vehicle_docs['files']);
            }

            // Insert core vehicle record
            if (Database::insert($vehicleTable, $uploadData)) {
                // Insert placeholders in related tables
                foreach ($tableArray as $table) {
                    Database::insert($table, ['vin' => $uploadData['vin']]);
                }

                // Update dealer listing count
                $getDealer = DealerService::fetchDealerInformation($uploadData['userid']);
                if (!empty($getDealer)) {
                    $dealer            = $getDealer[0];
                    $increase_listing  = intval($dealer['listings']) + 1;
                    $updateListing     = ['listings' => $increase_listing];
                    Database::update($dealers_tbl, $updateListing, ["userid" => $uploadData['userid']]);
                }

                // Record activity
                Activity::activity([
                    'userid' => $data['userid'] ?? $_SESSION['userid'],
                    'type'   => 'vehicle',
                    'title'  => 'vehicle upload successful',
                ]);

                return true;
            }
        } catch (\Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'VehicleService::uploadNewVehicleData',
                ['vin' => $data['vin'] ?? null],
                $th
            );
            Response::error(500, "An error occurred while uploading new vehicle");
        }
    }

    /**
     * Update vehicle information based on the specified table handler.
     *
     * @param int|string $id   Vehicle ID or VIN.
     * @param array      $data Input data including 'table' key to identify which table to update.
     *
     * @return bool True if update was successful.
     */
    public static function updateVehicleInformation($id, $data)
    {
        try {
            $vehicle = self::fetchVehicleInformation($id);

            if (empty($data['table'])) {
                Response::error(400, "No table specified for update");
            }

            $table = $data['table'];

            // Map table name → handler method
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

            $method = $handlers[$table];

            // Dynamically call the correct update method
            if (self::$method($id, $data, $vehicle[0])) {
                Activity::activity([
                    'userid' => $vehicle[0]['userid'] ?? $_SESSION['userid'],
                    'type'   => 'Car',
                    'title'  => 'Car update successful',
                ]);
                return true;
            }
        } catch (\Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'VehicleService::updateVehicleInformation',
                ['vin' => $id],
                $th
            );
            Response::error(500, "An error occurred while updating vehicle information");
        }
    }

    /**
     * Update core vehicle details (title, price, VIN, images, documents, etc.).
     */
    private static function updateVehicleCore($id, $data, $vehicle)
    {
        $table = Utility::$vehicles_tbl;

        // Merge updated fields with existing record
        $update = [
            'userid'         => $vehicle['userid'],
            'title'          => $data['title']          ?? $vehicle['title'],
            'price'          => isset($data['price']) ? intval($data['price']) : intval($vehicle['price']),
            'mileage'        => $data['mileage']        ?? $vehicle['mileage'],
            'vin'            => $vehicle['vin'],
            'status'         => $data['status']         ?? $vehicle['status'],
            'make'           => $data['make']           ?? $vehicle['make'],
            'model'          => $data['model']          ?? $vehicle['model'],
            'trim'           => $data['trim']           ?? $vehicle['trim'],
            'body_type'      => $data['body_type']      ?? $vehicle['body_type'],
            'fuel'           => $data['fuel']           ?? $vehicle['fuel'],
            'drive_type'     => $data['drive_type']     ?? $vehicle['drive_type'],
            'engine_number'  => $data['engine_number']  ?? $vehicle['engine_number'],
            'transmission'   => $data['transmission']   ?? $vehicle['transmission'],
            'exterior_color' => $data['exterior_color'] ?? $vehicle['exterior_color'],
            'interior_color' => $data['interior_color'] ?? $vehicle['interior_color'],
            'year'           => $data['year']           ?? $vehicle['year'],
            'notes'          => $data['notes']          ?? $vehicle['notes'],
        ];

        // Handle image upload (append to existing)
        if (
            isset($_FILES['vehicleImages']) &&
            $_FILES['vehicleImages']['error'] === UPLOAD_ERR_OK &&
            is_uploaded_file($_FILES['vehicleImages']['tmp_name'])
        ) {
            $target_dir    = "public/UPLOADS/vehicles/images/";
            $vehicle_image = Utility::uploadDocuments('vehicleImages', $target_dir);

            if (!$vehicle_image || !$vehicle_image['success']) {
                Response::error(500, "Image upload failed");
            }

            $previousImages = json_decode($vehicle['images'], true) ?: [];
            $mergedImages   = array_merge($vehicle_image['files'], $previousImages);

            $update['images'] = json_encode($mergedImages);
        }

        // Handle docs upload (append to existing)
        if (
            isset($_FILES['vehicleDocs']) &&
            !empty($_FILES['vehicleDocs']['name'][0])
        ) {
            $target_dir   = "public/UPLOADS/vehicles/docs/";
            $vehicle_docs = Utility::uploadDocuments('vehicleDocs', $target_dir);

            if (!$vehicle_docs || !$vehicle_docs['success']) {
                Response::error(500, "File upload failed");
            }

            $previousDocs = json_decode($vehicle['documents'], true) ?: [];
            $mergedDocs   = array_merge($vehicle_docs['files'], $previousDocs);

            $update['documents'] = json_encode($mergedDocs);
        }

        return Database::update($table, $update, ["id" => $id]);
    }

    /** Update accident record. */
    private static function updateAccident($id, $data, $prev)
    {
        $table = Utility::$accident_tbl;
        $update = ['notes' => $data['notes'] ?? $prev['notes']];
        return Database::update($table, $update, ["vin" => $id]);
    }

    /** Update insurance record. */
    private static function updateInsurance($id, $data, $prev)
    {
        $table = Utility::$insurance_tbl;
        $update = ['notes' => $data['notes'] ?? $prev['notes']];
        return Database::update($table, $update, ["vin" => $id]);
    }

    /** Update ownership record. */
    private static function updateOwnership($id, $data, $prev)
    {
        $table = Utility::$ownership_tbl;
        $update = ['ownership' => $data['ownership'] ?? $prev['ownership']];
        return Database::update($table, $update, ["vin" => $id]);
    }

    /** Update specifications record. */
    private static function updateSpecifications($id, $data, $prev)
    {
        $table = Utility::$specifications_tbl;
        $update = ['specs' => $data['specs'] ?? $prev['specs']];
        return Database::update($table, $update, ["vin" => $id]);
    }

    /**
     * Delete a vehicle record and all related data/files.
     *
     * @param int|string $id Vehicle ID or VIN.
     *
     * @return bool True if deletion was successful.
     */
    public static function deleteVehicleData($id)
    {
        $vehicles   = Utility::$vehicles_tbl;
        $accident   = Utility::$accident_tbl;
        $insurance  = Utility::$insurance_tbl;
        $ownership  = Utility::$ownership_tbl;
        $specs      = Utility::$specifications_tbl;

        try {
            $vehicle = self::fetchVehicleInformation($id);

            if (!$vehicle || empty($vehicle[0])) {
                Response::error(404, "Vehicle not found");
            }

            $currentVehicle = $vehicle[0];

            // Delete uploaded images
            if (!empty($currentVehicle['images'])) {
                $target_dir = "public/UPLOADS/vehicles/images/";
                $images     = json_decode($currentVehicle['images'], true) ?: [];
                foreach ($images as $image) {
                    $filename = basename($image);
                    $file     = "../" . $target_dir . $filename;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
            }

            // Delete uploaded documents
            if (!empty($currentVehicle['documents'])) {
                $target_dir = "public/UPLOADS/vehicles/docs/";
                $documents  = json_decode($currentVehicle['documents'], true) ?: [];
                foreach ($documents as $doc) {
                    $filename = basename($doc);
                    $file     = "../" . $target_dir . $filename;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
            }

            // Cascade delete from all related tables
            $tableArray = [$vehicles, $accident, $insurance, $ownership, $specs];
            foreach ($tableArray as $table) {
                Database::delete($table, ["vin" => $currentVehicle['vin']]);
            }

            Activity::activity([
                'userid' => $currentVehicle['userid'] ?? $_SESSION['userid'],
                'type'   => 'Car',
                'title'  => 'Vehicle delete successful',
            ]);

            return true;
        } catch (\Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'VehicleService::deleteVehicleData',
                ['vin' => $id],
                $th
            );
            Response::error(500, "An error occurred while deleting vehicle details");
        }
    }
}
