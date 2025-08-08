<?php

namespace App\Models;

use configs\DBConnection;
use App\Utils\Utility;

class Report
{
    private static $theft;
    private static $profile;
    private static $verification;
    private static $vinDocs;
    private static $vinHistory;
    private static $vinImages;
    private static $vinInfo;
    private static $vinOwnership;
    private static $vinSpec;
    private static $vinValuation;
    private static $vinInspection;
    private static $db;

    private static function init()
    {
        self::$theft = Utility::$theft_tbl;
        self::$profile = Utility::$profile_tbl;
        self::$verification = Utility::$verification_tbl;
        self::$vinDocs = Utility::$vinDocs_tbl;
        self::$vinHistory = Utility::$vinHistory_tbl;
        self::$vinImages = Utility::$vinImages_tbl;
        self::$vinInfo = Utility::$vinInfo_tbl;
        self::$vinOwnership = Utility::$vinOwnership_tbl;
        self::$vinSpec = Utility::$vinSpec_tbl;
        self::$vinValuation = Utility::$vinValuation_tbl;
        self::$vinInspection = Utility::$vinInspection_tbl;
        self::$db = DBConnection::getConnection();
    }

    public static function theftReport($id)
    {
        try {
            $db = DBConnection::getConnection();

            $profile = self::$profile;
            $theft = self::$theft;

            $sql = "SELECT report.*,
                user.fullname,               
                user.home_address AS userAddress,               
                user.home_state AS userState,               
                user.home_city AS userCity,               
                user.country AS userCountry,               
                user.email_address AS userEmail,               
                user.phone_number AS userPhone,               
                user.avatar
                FROM {$theft} report 
                LEFT JOIN {$profile} user ON user.userid = report.userid 
                WHERE report.userid = :userid OR report.theft_id = :id
                ORDER BY report.id DESC
            ";
            $stmt = $db->prepare($sql);
            $stmt->execute(
                [
                    'id' => $id,
                    'userid' => $id
                ]
            );
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'User::userData', ['host' => 'localhost'], $e);
        }
    }

    public static function theftReports()
    {
        try {
            self::init();
            $profile = self::$profile;
            $theft = self::$theft;

            $sql = "SELECT report.*,
                user.fullname,               
                user.home_address AS userAddress,               
                user.home_state AS userState,               
                user.home_city AS userCity,               
                user.country AS userCountry,               
                user.email_address AS userEmail,               
                user.phone_number AS userPhone,               
                user.avatar
                FROM {$theft} report 
                LEFT JOIN {$profile} user ON user.userid = report.userid                
                 ORDER BY report.id DESC
            ";
            $stmt = self::$db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'User::userData', ['host' => 'localhost'], $e);
        }
    }

    public static function create($data)
    {
        try {
            self::init();
            $theft = self::$theft;
            $stmt = self::$db->prepare("INSERT INTO {$theft}(theft_id, userid, vin, report_data)VALUES(:theft_id, :userid, :vin, :report_data)");
            return $stmt->execute(
                [
                    'theft_id' => $data['theftId'],
                    'userid' => $data['userid'],
                    'vin' => $data['vin'],
                    'report_data' => json_encode($data)
                ]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Report::create', ['host' => 'localhost'], $e);
        }
    }
    public static function update($prev, $data)
    {
        try {
            self::init();
            $theft = self::$theft;

            $sql = "UPDATE {$theft}
                    SET report_status = :report_status                 
                WHERE theft_id = :id                
            ";
            $stmt = self::$db->prepare($sql);
            return $stmt->execute(
                [
                    'id' => $data['theftId'] ?? $prev['theft_id'],
                    'report_status' => $data['report_status'] ?? $prev['report_status'],
                ]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Report::update', ['host' => 'localhost'], $e);
        }
    }

    public static function delete($id)
    {
        try {
            self::init();
            $theft = self::$theft;

            $sql = "DELETE FROM {$theft} WHERE theft_id = :id";
            $stmt = self::$db->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Report::update', ['host' => 'localhost'], $e);
        }
    }

    # Verification Models
    public static function verificationReport($id)
    {
        try {
            self::init();
            $profile = self::$profile;
            $vinDocs = self::$vinDocs;
            $vinHistory = self::$vinHistory;
            $vinImages = self::$vinImages;
            $vinInfo = self::$vinInfo;
            $vinOwnership = self::$vinOwnership;
            $vinSpec = self::$vinSpec;
            $vinValuation = self::$vinValuation;
            $vinInspection = self::$vinInspection;
            $verification = self::$verification;

            $sql = "SELECT verification.*,
                user.fullname,
                user.country,
                user.home_state,
                user.home_city,
                docs.files_url, 
                history.history_data,
                images.image_url,
                info.vehicle_data,
                info.car_status,
                info.created_at AS carUploadDate,
                owners.ownership_data,
                specs.specs_data,
                valuation.valuation_data,
                inspections.inspection_result
                
                FROM {$verification} verification 
                LEFT JOIN {$profile} user ON user.userid = verification.userid 
                LEFT JOIN {$vinDocs} docs ON docs.vin = verification.vin 
                LEFT JOIN {$vinHistory} history ON history.vin = verification.vin 
                LEFT JOIN {$vinImages} images ON images.vin = verification.vin 
                LEFT JOIN {$vinInfo} info ON info.vin = verification.vin 
                LEFT JOIN {$vinOwnership} owners ON owners.vin = verification.vin 
                LEFT JOIN {$vinSpec} specs ON specs.vin = verification.vin 
                LEFT JOIN {$vinValuation} valuation ON valuation.vin = verification.vin 
                LEFT JOIN {$vinInspection} inspections ON inspections.vin = verification.vin 
                WHERE verification.userid = :userid 
                    OR verification.vin = :vin
                    OR transaction_id.vin = :id
                ORDER BY verification.id DESC
            ";
            $stmt = self::$db->prepare($sql);
            $stmt->execute(
                [
                    'vin' => $id,
                    'userid' => $id,
                    'id' => $id,
                ]
            );
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Report::verificationReport', ['host' => 'localhost'], $e);
        }
    }

    public static function verificationReports()
    {
        try {
            self::init();
            $profile = self::$profile;
            $vinDocs = self::$vinDocs;
            $vinHistory = self::$vinHistory;
            $vinImages = self::$vinImages;
            $vinInfo = self::$vinInfo;
            $vinOwnership = self::$vinOwnership;
            $vinSpec = self::$vinSpec;
            $vinValuation = self::$vinValuation;
            $vinInspection = self::$vinInspection;
            $verification = self::$verification;

            $sql = "SELECT request.*,
                user.fullname,
                user.country,
                user.home_state,
                user.home_city,
                history.history_data,
                images.image_url,
                info.vehicle_data,
                info.car_status,
                info.created_at AS carUploadDate,
                owners.ownership_data,
                specs.specs_data,
                valuation.valuation_data,
                inspections.inspection_result,
                docs.files_url
               

                FROM {$verification} request 
                LEFT JOIN {$profile} user ON user.userid = request.userid
                LEFT JOIN {$vinDocs} docs ON docs.vin = request.vin
                LEFT JOIN {$vinHistory} history ON history.vin = request.vin 
                LEFT JOIN {$vinImages} images ON images.vin = request.vin 
                 LEFT JOIN {$vinInfo} info ON info.vin = request.vin 
                 LEFT JOIN {$vinOwnership} owners ON owners.vin = request.vin
                 LEFT JOIN {$vinSpec} specs ON specs.vin = request.vin  
                 LEFT JOIN {$vinValuation} valuation ON valuation.vin = request.vin
                 LEFT JOIN {$vinInspection} inspections ON inspections.vin = request.vin   
              
                ORDER BY request.id DESC";
            $stmt = self::$db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Report::verificationReport', ['host' => 'localhost'], $e);
        }
    }

    public static function verificationRequest($data)
    {
        try {
            self::init();
            $verification = self::$verification;
            $stmt = self::$db->prepare("INSERT INTO {$verification}(transaction_id, userid, vin)VALUES(:transaction_id, :userid, :vin)");
            return $stmt->execute(
                [
                    'transaction_id' => $data['transaction_id'],
                    'userid' => $data['userid'],
                    'vin' => $data['vin'],
                ]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Report::verificationRequest', ['host' => 'localhost'], $e);
        }
    }
}
