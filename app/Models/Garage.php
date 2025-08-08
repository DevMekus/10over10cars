<?php

namespace App\Models;

use configs\DBConnection;
use App\Utils\Utility;

class Garage
{

    private static $vinDocs;
    private static $vinHistory;
    private static $vinImages;
    private static $vinInfo;
    private static $vinOwnership;
    private static $vinSpec;
    private static $vinValuation;
    private static $vinInspection;
    private static $db;
    private static $dealer;

    private static function init()
    {

        self::$vinDocs = Utility::$vinDocs_tbl;
        self::$vinHistory = Utility::$vinHistory_tbl;
        self::$vinImages = Utility::$vinImages_tbl;
        self::$vinInfo = Utility::$vinInfo_tbl;
        self::$vinOwnership = Utility::$vinOwnership_tbl;
        self::$vinSpec = Utility::$vinSpec_tbl;
        self::$vinValuation = Utility::$vinValuation_tbl;
        self::$vinInspection = Utility::$vinInspection_tbl;
        self::$dealer = Utility::$dealers_tbl;
        self::$db = DBConnection::getConnection();
    }

    public static function vehicle($id)
    {
        try {
            self::init();

            $vinDocs = self::$vinDocs;
            $vinHistory = self::$vinHistory;
            $vinImages = self::$vinImages;
            $vinInfo = self::$vinInfo;
            $vinOwnership = self::$vinOwnership;
            $vinSpec = self::$vinSpec;
            $vinValuation = self::$vinValuation;
            $vinInspection = self::$vinInspection;
            $dealer = self::$dealer;

            $sql = "SELECT vehicle.*,
                dealer.dealer_name,
                dealer.business_address,               
                dealer.city,
                dealer.state_,
                dealer.country,
                dealer.logo,
                docs.files_url, 
                history.history_data,
                images.image_url,
                owners.ownership_data,
                specs.specs_data,
                valuation.valuation_data,
                inspections.inspection_result
                
                FROM {$vinInfo} vehicle 
                LEFT JOIN {$dealer} dealer ON dealer.userid = vehicle.userid 
                LEFT JOIN {$vinDocs} docs ON docs.vin = vehicle.vin 
                LEFT JOIN {$vinHistory} history ON history.vin = vehicle.vin 
                LEFT JOIN {$vinImages} images ON images.vin = vehicle.vin               
                LEFT JOIN {$vinOwnership} owners ON owners.vin = vehicle.vin 
                LEFT JOIN {$vinSpec} specs ON specs.vin = vehicle.vin 
                LEFT JOIN {$vinValuation} valuation ON valuation.vin = vehicle.vin 
                LEFT JOIN {$vinInspection} inspections ON inspections.vin = vehicle.vin 
                WHERE vehicle.userid = :userid 
                    OR vehicle.vin = :vin
                ORDER BY vehicle.id DESC
            ";
            $stmt = self::$db->prepare($sql);
            $stmt->execute(
                [
                    'vin' => $id,
                    'userid' => $id,
                ]
            );
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Garage::vehicle', ['host' => 'localhost'], $e);
        }
    }

    public static function vehicles()
    {
        try {
            self::init();
            $vinDocs = self::$vinDocs;
            $vinHistory = self::$vinHistory;
            $vinImages = self::$vinImages;
            $vinInfo = self::$vinInfo;
            $vinOwnership = self::$vinOwnership;
            $vinSpec = self::$vinSpec;
            $vinValuation = self::$vinValuation;
            $vinInspection = self::$vinInspection;
            $dealer = self::$dealer;

            $sql = "SELECT vehicle.*,
                dealer.dealer_name,
                dealer.business_address,               
                dealer.city,
                dealer.state_,
                dealer.country,
                dealer.logo,
                docs.files_url, 
                history.history_data,
                images.image_url,               
                owners.ownership_data,
                specs.specs_data,
                valuation.valuation_data,
                inspections.inspection_result
                
                FROM {$vinInfo} vehicle 
                LEFT JOIN {$dealer} dealer ON dealer.userid = vehicle.userid 
                LEFT JOIN {$vinDocs} docs ON docs.vin = vehicle.vin 
                LEFT JOIN {$vinHistory} history ON history.vin = vehicle.vin 
                LEFT JOIN {$vinImages} images ON images.vin = vehicle.vin               
                LEFT JOIN {$vinOwnership} owners ON owners.vin = vehicle.vin 
                LEFT JOIN {$vinSpec} specs ON specs.vin = vehicle.vin 
                LEFT JOIN {$vinValuation} valuation ON valuation.vin = vehicle.vin 
                LEFT JOIN {$vinInspection} inspections ON inspections.vin = vehicle.vin                 
                ORDER BY vehicle.id DESC
            ";
            $stmt = self::$db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Garage::vehicles', ['host' => 'localhost'], $e);
        }
    }

    public static function uploadNewVehicle($data)
    {
        try {
            self::init();
            $vinInfo = self::$vinInfo;

            self::uploadHistory($data);
            self::uploadOwnerships($data);
            self::uploadSpecs($data);
            self::uploadValuations($data);
            self::uploadInspections($data);

            $stmt = self::$db->prepare("INSERT INTO {$vinInfo}(userid, vin, vehicle_data)VALUES(:userid, :vin, :vehicle_data)");
            return $stmt->execute(
                [
                    'userid' => $data['userid'],
                    'vin' => $data['vin'],
                    'vehicle_data' => json_encode($data)
                ]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Garage::uploadNewVehicle', ['host' => 'localhost'], $e);
        }
    }

    public static function uploadDocs($data)
    {
        try {

            $vinDocs = self::$vinDocs;

            $stmt = self::$db->prepare("INSERT INTO {$vinDocs}(vin, files_url)VALUES(:vin, :files_url)");
            return $stmt->execute(
                [
                    'vin' => $data['vin'],
                    'files_url' => json_encode($data['files_url']) ?? null
                ]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Garage::uploadDocs', ['host' => 'localhost'], $e);
        }
    }

    public static function uploadHistory($data)
    {
        try {

            $vinHistory = self::$vinHistory;

            $stmt = self::$db->prepare("INSERT INTO {$vinHistory}(vin, history_data)VALUES(:vin, :history_data)");
            return $stmt->execute(
                [
                    'vin' => $data['vin'],
                    'history_data' => json_encode($data['history_data']) ?? null
                ]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Garage::uploadHistory', ['host' => 'localhost'], $e);
        }
    }

    public static function uploadImages($data)
    {
        try {

            $vinImages = self::$vinImages;

            $stmt = self::$db->prepare("INSERT INTO {$vinImages}(vin, image_url)VALUES(:vin, :image_url)");
            return $stmt->execute(
                [
                    'vin' => $data['vin'],
                    'image_url' => json_encode($data['image_url']) ?? null
                ]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Garage::uploadImages', ['host' => 'localhost'], $e);
        }
    }

    public static function uploadOwnerships($data)
    {
        try {

            $vinOwnership = self::$vinOwnership;

            $stmt = self::$db->prepare("INSERT INTO {$vinOwnership}(vin, ownership_data)VALUES(:vin, :ownership_data)");
            return $stmt->execute(
                [
                    'vin' => $data['vin'],
                    'ownership_data' => json_encode($data['ownership_data']) ?? null
                ]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Garage::uploadOwnerships', ['host' => 'localhost'], $e);
        }
    }

    public static function uploadSpecs($data)
    {
        try {

            $vinSpec = self::$vinSpec;

            $stmt = self::$db->prepare("INSERT INTO {$vinSpec}(vin, specs_data)VALUES(:vin, :specs_data)");
            return $stmt->execute(
                [
                    'vin' => $data['vin'],
                    'specs_data' => json_encode($data['specs_data']) ?? null
                ]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Garage::uploadSpecs', ['host' => 'localhost'], $e);
        }
    }

    public static function uploadValuations($data)
    {
        try {

            $vinValuation = self::$vinValuation;

            $stmt = self::$db->prepare("INSERT INTO {$vinValuation}(vin, valuation_data)VALUES(:vin, :valuation_data)");
            return $stmt->execute(
                [
                    'vin' => $data['vin'],
                    'valuation_data' => json_encode($data['valuation_data']) ?? null
                ]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Garage::uploadValuations', ['host' => 'localhost'], $e);
        }
    }

    public static function uploadInspections($data)
    {
        try {

            $vinInspection = self::$vinInspection;

            $stmt = self::$db->prepare("INSERT INTO {$vinInspection}(vin, inspection_result)VALUES(:vin,  :inspection_result)");
            return $stmt->execute(
                [
                    'vin' => $data['vin'],
                    'inspection_result' => json_encode($data['inspection_result']) ?? null
                ]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Garage::uploadInspections', ['host' => 'localhost'], $e);
        }
    }



    #UPDATES
    public static function updateDocs($prev, $data)
    {
        try {

            self::init();
            $vinDocs = self::$vinDocs;

            $stmt = self::$db->prepare("UPDATE {$vinDocs} 
            SET files_url = :fileUrl 
            WHERE vin = :vin");

            return $stmt->execute(
                [
                    'fileUrl' => json_encode($data['newFiles']) ?? $prev['files_url'],
                    'vin' => $data['vin'] ?? $prev['vin'],
                ]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Garage::updateDocs', ['host' => 'localhost'], $e);
        }
    }

    public static function updateImages($prev, $data)
    {
        try {

            self::init();
            $vinImages = self::$vinImages;

            $stmt = self::$db->prepare("UPDATE {$vinImages} 
            SET image_url = :fileUrl 
            WHERE vin = :vin");

            return $stmt->execute(
                [
                    'fileUrl' => json_encode($data['newFiles']) ?? $prev['image_url'],
                    'vin' => $data['vin'] ?? $prev['vin'],
                ]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Garage::updateImages', ['host' => 'localhost'], $e);
        }
    }

    public static function updateVehicleInfo($prev, $data)
    {
        try {
            self::init();
            $vinInfo = self::$vinInfo;

            $stmt = self::$db->prepare("UPDATE {$vinInfo} 
            SET vehicle_data = :vehicle_data,
            status = :status 
            WHERE vin = :vin");
            return $stmt->execute(
                [
                    'vehicle_data' => json_encode($data['vehicle_data']) ?? $prev['vehicle_data'],
                    'status' => $data['status'] ?? $prev['status'],
                    'vin' => $data['vin'] ?? $prev['vin'],
                ]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Garage::updateStatus', ['host' => 'localhost'], $e);
        }
    }

    public static function updateVehicleOwnership($prev, $data)
    {
        try {
            self::init();
            $vinOwnership = self::$vinOwnership;

            $stmt = self::$db->prepare("UPDATE {$vinOwnership} 
            SET ownership_data = :ownership_data
            WHERE vin = :vin");
            return $stmt->execute(
                [
                    'ownership_data' => json_encode($data['ownership_data']) ?? $prev['ownership_data'],
                    'vin' => $data['vin'] ?? $prev['vin'],
                ]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Garage::updateStatus', ['host' => 'localhost'], $e);
        }
    }

    public static function updateVehicleSpecs($prev, $data)
    {
        try {
            self::init();
            $vinSpec = self::$vinSpec;

            $stmt = self::$db->prepare("UPDATE {$vinSpec} 
            SET specs_data = :specs_data
            WHERE vin = :vin");
            return $stmt->execute(
                [
                    'specs_data' => json_encode($data['specs_data']) ?? $prev['specs_data'],
                    'vin' => $data['vin'] ?? $prev['vin'],
                ]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Garage::updateStatus', ['host' => 'localhost'], $e);
        }
    }

    public static function updateVehicleInspection($prev, $data)
    {
        try {
            self::init();
            $vinInspection = self::$vinInspection;

            $stmt = self::$db->prepare("UPDATE {$vinInspection} 
            SET inspection_result = :inspection_result
            WHERE vin = :vin");
            return $stmt->execute(
                [
                    'inspection_result' => json_encode($data['inspection_result']) ?? $prev['inspection_result'],
                    'vin' => $data['vin'] ?? $prev['vin'],
                ]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Garage::updateStatus', ['host' => 'localhost'], $e);
        }
    }


    #DELETES

    public static function deleteList($id)
    {
        try {
            self::init();
            $vinInfo = self::$vinInfo;

            #Delete all the data
            self::deleteHistory($id);
            self::deleteDocs($id);
            self::deleteImages($id);
            self::deleteOwnerships($id);
            self::deleteSpecs($id);
            self::deleteValuations($id);
            self::deleteInspections($id);

            $stmt = self::$db->prepare("DELETE FROM {$vinInfo}
            WHERE vin = :vin");
            return $stmt->execute(['vin' => $id]);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Garage::deleteList', ['host' => 'localhost'], $e);
        }
    }

    private static function deleteHistory($id)
    {
        try {

            $vinHistory = self::$vinHistory;

            $stmt = self::$db->prepare("DELETE FROM {$vinHistory}
            WHERE vin = :vin");
            return $stmt->execute(['vin' => $id]);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Garage::deleteHistory', ['host' => 'localhost'], $e);
        }
    }

    private static function deleteImages($id)
    {
        try {

            $vinImages = self::$vinImages;

            $stmt = self::$db->prepare("DELETE FROM {$vinImages}
            WHERE vin = :vin");
            return $stmt->execute(['vin' => $id]);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Garage::deleteImages', ['host' => 'localhost'], $e);
        }
    }

    private static function deleteOwnerships($id)
    {
        try {

            $vinOwnership = self::$vinOwnership;

            $stmt = self::$db->prepare("DELETE FROM {$vinOwnership}
            WHERE vin = :vin");
            return $stmt->execute(['vin' => $id]);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Garage::deleteOwnerships', ['host' => 'localhost'], $e);
        }
    }

    private static function deleteSpecs($id)
    {
        try {

            $vinSpec = self::$vinSpec;
            $stmt = self::$db->prepare("DELETE FROM {$vinSpec}
            WHERE vin = :vin");
            return $stmt->execute(['vin' => $id]);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Garage::deleteSpecs', ['host' => 'localhost'], $e);
        }
    }

    private static function deleteValuations($id)
    {
        try {

            $vinValuation = self::$vinValuation;
            $stmt = self::$db->prepare("DELETE FROM {$vinValuation}
            WHERE vin = :vin");
            return $stmt->execute(['vin' => $id]);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Garage::deleteValuations', ['host' => 'localhost'], $e);
        }
    }

    private static function deleteInspections($id)
    {
        try {

            $vinInspection = self::$vinInspection;

            $stmt = self::$db->prepare("DELETE FROM {$vinInspection}
            WHERE vin = :vin");
            return $stmt->execute(['vin' => $id]);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Garage::deleteInspections', ['host' => 'localhost'], $e);
        }
    }

    private static function deleteDocs($id)
    {
        try {

            $vinDocs = self::$vinDocs;

            $stmt = self::$db->prepare("DELETE FROM {$vinDocs}
            WHERE vin = :vin");
            return $stmt->execute(['vin' => $id]);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Garage::deleteDocs', ['host' => 'localhost'], $e);
        }
    }
}
