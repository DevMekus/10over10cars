<?php

namespace App\Services;

use App\Utils\Response;
use configs\DB;
use App\Services\Activity;
use App\Utils\Utility;


class WorkShopService
{
    protected $db;
    protected $vehicleInfo;
    protected $vehicleDocs;
    protected $vehicleHistory;
    protected $vehicleImages;
    protected $vehicleOwnership;
    protected $vehicleSpecifications;
    protected $vehicleValuation;
    protected $vehicleInspection;
    protected $tables = [];


    public function __construct()
    {
        $this->db = new DB();

        $this->vehicleInfo = Utility::$vinInfo_tbl;
        $this->vehicleDocs = Utility::$vinDocs_tbl;
        $this->vehicleHistory = Utility::$vinHistory_tbl;
        $this->vehicleImages = Utility::$vinImages_tbl;
        $this->vehicleOwnership = Utility::$vinOwnership_tbl;
        $this->vehicleSpecifications = Utility::$vinSpec_tbl;
        $this->vehicleValuation = Utility::$vinValuation_tbl;
        $this->vehicleInspection = Utility::$vinInspection_tbl;

        $this->tables = [$this->vehicleInfo, $this->vehicleDocs, $this->vehicleHistory, $this->vehicleImages, $this->vehicleOwnership, $this->vehicleSpecifications, $this->vehicleInspection, $this->vehicleInspection];
    }

    private function vehicleInfoData($id)
    {
        try {
            return $this->db->joinTables(
                "$this->vehicleInfo info",
                [
                    [
                        "type" => "LEFT",
                        "table" => "$this->vehicleDocs doc",
                        "on" => "doc.vin = info.vin"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$this->vehicleHistory history",
                        "on" => "history.vin = info.vin"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$this->vehicleImages images",
                        "on" => "images.vin = info.vin"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$this->vehicleOwnership owner",
                        "on" => "owner.vin = info.vin"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$this->vehicleSpecifications specs",
                        "on" => "specs.vin = info.vin"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$this->vehicleValuation value",
                        "on" => "value.vin = info.vin"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$this->vehicleInspection inspections",
                        "on" => "inspections.vin = info.vin"
                    ],
                ],
                ["info.*", "doc.files_url", "history.history_data", "images.image_url", "owner.ownership_data", "specs.specs_data", "value.valuation_data", "inspections.inspection_result"],
                ["info.vin" => $id]
            );
        } catch (\Throwable $th) {
            Response::error(500, "An error occurred while fetching vehicles details");
            Utility::log($th->getMessage(), 'error', 'WorkShopService::vehicleInfoData', ['vin' => $id], $th);
        }
    }

    public function vehicleInformation($id)
    {
        $vehicle = $this->vehicleInfoData($id);

        if (empty($vehicle)) Response::error(404, "Vehicle not found");
        Response::success($vehicle[0], "vehicle information seen");
    }

    public function fetchVehiclesInformation()
    {
        try {
            return $this->db->joinTables(
                "$this->vehicleInfo info",
                [
                    [
                        "type" => "LEFT",
                        "table" => "$this->vehicleDocs doc",
                        "on" => "doc.vin = info.vin"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$this->vehicleHistory history",
                        "on" => "history.vin = info.vin"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$this->vehicleImages images",
                        "on" => "images.vin = info.vin"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$this->vehicleOwnership owner",
                        "on" => "owner.vin = info.vin"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$this->vehicleSpecifications specs",
                        "on" => "specs.vin = info.vin"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$this->vehicleValuation value",
                        "on" => "value.vin = info.vin"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$this->vehicleInspection inspections",
                        "on" => "inspections.vin = info.vin"
                    ],
                ],
                ["info.*", "doc.files_url", "history.history_data", "images.image_url", "owner.ownership_data", "specs.specs_data", "value.valuation_data", "inspections.inspection_result"]
            );
        } catch (\Throwable $th) {
            Response::error(500, "An error occurred while fetching vehicles details");
            Utility::log($th->getMessage(), 'error', 'WorkShopService::vehicleInformation', ['userid' => $_SESSION['userid']], $th);
        }
    }
    public function vehiclesInformation()
    {
        $vehicles = $this->fetchVehiclesInformation();
        if (empty($vehicles)) Response::error(404, "Vehicles not found");
        Response::success($vehicles, "vehicle information seen");
    }

    public function uploadNewVehicleData($data)
    {
        try {
            $vehicle = $this->db->find($this->vehicleInfo, $data['vin'], 'vin');
            if ($vehicle) Response::error(409, "Vehicle already exist");

            $newData = [];
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

                $imageData = [];
                $imageData['image_url'] = $vehicle_image['files'];
                $imageData['vin'] = $newData['vin'];
                $this->db->insert($this->vehicleImages, $imageData);
            }

            //Upload docs
            if (
                isset($_FILES['vehicleDocs']) &&
                !empty($_FILES['vehicleDocs']['name'][0])
            ) {
                $target_dir = "public/UPLOADS/reports/";
                $vehicle_docs = Utility::uploadDocuments('vehicleDocs', $target_dir);
                if (!$vehicle_docs || !$vehicle_docs['success']) {
                    Response::error(500, "File upload failed");
                }

                $docData = [];
                $docData['files_url'] = $vehicle_docs['files'];
                $docData['vin'] = $newData['vin'];
                $this->db->insert($this->vehicleDocs, $docData);
            }
            $vehicleData = [
                "vehicle_data" => $newData,
                "vin" => $newData['vin'],
            ];
            if ($this->db->insert($this->vehicleInfo, $vehicleData)) {
                Activity::newActivity([
                    'userid' => $data['userid'] ?? $_SESSION['userid'],
                    'actions' => "New vehicle uploaded",
                ]);
                Response::success(['vehicle' => $newData['vin']], 'vehicle upload successful');
            }
            Response::error(500, "An error has occurred");
        } catch (\Throwable $th) {
            Response::error(500, "An error occurred while uploading new vehicle");
            Utility::log($th->getMessage(), 'error', 'WorkShopService::uploadNewVehicleData', ['vin' => $newData['vin']], $th);
        }
    }

    public function updateVehicleInformation($id, $data)
    {
        try {
            $vehicle = $this->vehicleInfoData($id);
            if (empty($vehicle)) Response::error(404, "Vehicle not found");
            $vehicle = $vehicle[0];

            $update = null;

            switch ($data['table']) {
                case 'vehicle_information':
                    $update = [
                        'status' => $data['status'] ?? $vehicle['status'],
                    ];
                    break;

                default:
                    Response::error(500, "An error has occurred");
            }

            if ($this->db->update($data['table'], $update, ["vin" => $id])) {
                Activity::newActivity([
                    'userid' => $_SESSION['userid'],
                    'actions' => 'Vehicle updated',
                ]);
                Response::success([], "Vehicle update successful");
            }
            Response::error(500, "An error has occurred");
        } catch (\Throwable $th) {
            Response::error(500, "An error occurred while updating vehicles details");
            Utility::log($th->getMessage(), 'error', 'WorkShopService::updateVehicleInformation', ['vin' => $id], $th);
        }
    }

    public function deleteVehicleData($id, $data = null)
    {
        try {
            $vehicle = $this->vehicleInfoData($id);
            if (empty($vehicle)) Response::error(404, "Vehicle not found");

            $currentVehicle = $vehicle[0];
            if (isset($data)) {
                if ($data['upload'] == 'images') {
                    $this->deleteImage($currentVehicle, $data);
                }

                if ($data['upload'] == 'document') {
                    $this->deleteDocument($currentVehicle, $data);
                }
            } else {
                foreach ($this->tables as $table) {
                    if ($this->db->delete($table, ["vin" => $id])) {
                        Activity::newActivity([
                            'userid' => $_SESSION['userid'],
                            'actions' => 'Vehicle deleted',
                        ]);
                        Response::success([], "Vehicle delete successful");
                    }
                }
            }
            Response::error(500, "An error has occurred");
        } catch (\Throwable $th) {
            Response::error(500, "An error occurred while fetching vehicles details");
            Utility::log($th->getMessage(), 'error', 'WorkShopService::deleteVehicleData', ['vin' => $id], $th);
        }
    }


    private  function deleteDocument($vehicle, $data)
    {
        try {
            if (isset($vehicle['files_url'])) {

                $files = json_decode($vehicle['files_url']);
                $url =  $data['url'];
                $uploaded = [];

                foreach ($files as $file) {

                    if ($file ==  $url) {
                        $filenameFromUrl = basename($file);
                        $target_dir = "../public/UPLOADS/reports/" . $filenameFromUrl;
                        if (file_exists($target_dir)) {
                            unlink($target_dir);
                        }
                    } else {
                        $uploaded[] = $file;
                    }
                }

                $update = [
                    'files_url' => json_encode($uploaded),
                    'vin' => $vehicle['vin']
                ];



                if ($this->db->update($this->vehicleDocs, $update, ["vin" => $vehicle['vin']])) {
                    Activity::newActivity([
                        'userid' => $_SESSION['userid'],
                        'actions' => 'vehicle document deleted',
                    ]);
                    Response::success([], "Vehicle document deleted successful");
                }

                Response::error(500, "An error has occurred");
            }
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'GarageService::deleteDocument', ['host' => 'localhost'], $e);
        }
    }

    private  function deleteImage($vehicle, $data)
    {
        try {
            if (isset($vehicle['image_url'])) {

                $files = json_decode($vehicle['image_url']);
                $url =  $data['url'];
                $uploaded = [];

                foreach ($files as $file) {

                    if ($file ==  $url) {
                        $filenameFromUrl = basename($file);
                        $target_dir = "../public/UPLOADS/vehicles/" . $filenameFromUrl;

                        if (file_exists($target_dir)) {
                            unlink($target_dir);
                        }
                    } else {
                        $uploaded[] = $file;
                    }
                }

                $update = [
                    'image_url' => json_encode($uploaded),
                    'vin' => $vehicle['vin']
                ];

                if ($this->db->update($this->vehicleImages, $update, ["vin" => $vehicle['vin']])) {
                    Activity::newActivity([
                        'userid' => $_SESSION['userid'],
                        'actions' => 'vehicle image deleted',
                    ]);
                    Response::success([], "Vehicle image deleted successful");
                }
                Response::error(500, "An error has occurred");
            }
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'WorkShopService::deleteImage', ['host' => 'localhost'], $e);
        }
    }

    public  function uploadVehicleData($id, $data)
    {
        $vehicle = $this->vehicleInfoData($id);
        if (empty($vehicle)) Response::error(404, "Vehicle not found");
        $vehicle = $vehicle[0];



        $data['fileType'] == "document" ? $this->uploadMoreDocs($vehicle, $data) : $this->uploadMoreImages($vehicle, $data);
    }

    private  function uploadMoreDocs($prev, $newData)
    {
        try {

            if (
                isset($_FILES['vehicleDocs']) &&
                !empty($_FILES['vehicleDocs']['name'][0])
            ) {
                $target_dir = "public/UPLOADS/reports/";
                $vehicle_docs = Utility::uploadDocuments('vehicleDocs', $target_dir);

                if (!$vehicle_docs || !$vehicle_docs['success']) {
                    Response::error(500, "File upload failed");
                }

                $prevFileArray = json_decode($prev['files_url'], true) ?? [];

                $update = [
                    'files_url' => json_encode(array_merge($prevFileArray, $vehicle_docs['files'])),
                    'vin' => $newData['vin']
                ];

                if ($this->db->update($this->vehicleDocs, $update, ["vin" => $newData['vin']])) {
                    if (Activity::newActivity([
                        'userid' => $_SESSION['userid'],
                        'actions' => 'vehicle doc added',
                    ])) {

                        Response::success([], "Vehicle document added successful");
                    }
                }
                Response::error(500, "An error has occurred");
            }
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'GarageService::uploadMoreDocs', ['host' => 'localhost'], $e);
        }
    }

    private  function uploadMoreImages($prev, $newData)
    {
        try {

            if (
                isset($_FILES['vehicleImages']) &&
                !empty($_FILES['vehicleImages']['name'][0])
            ) {
                $target_dir = "public/UPLOADS/vehicles/";

                $vehicle_image = Utility::uploadDocuments('vehicleImages', $target_dir);
                $prevFileArray = json_decode($prev['image_url'], true) ?? [];

                $update = [
                    'image_url' => json_encode(array_merge($prevFileArray, $vehicle_image['files'])),
                    'vin' => $newData['vin']
                ];

                if ($this->db->update($this->vehicleImages, $update, ["vin" => $newData['vin']])) {
                    if (Activity::newActivity([
                        'userid' => $_SESSION['userid'],
                        'actions' => 'vehicle doc added',
                    ])) {

                        Response::success([], "Vehicle document added successful");
                    }
                }
                Response::error(500, "An error has occurred");
            }
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'GarageService::uploadMoreImages', ['host' => 'localhost'], $e);
        }
    }
}
