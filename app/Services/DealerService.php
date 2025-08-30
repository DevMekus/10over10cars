<?php

namespace App\Services;

use App\Utils\Response;
use configs\Database;
use App\Services\Activity;
use App\Utils\Utility;


class DealerService
{
    public static function fetchAllDealersInfo()
    {
        $dealer = Utility::$dealers_tbl;
        $profile = Utility::$profile_tbl;
        $account = Utility::$accounts_tbl;
        try {
            return Database::joinTables(
                "$dealer d",
                [
                    [
                        "type" => "LEFT",
                        "table" => "$profile u",
                        "on" => "u.userid = d.userid"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$account a",
                        "on" => "u.userid = a.userid"
                    ]
                ],
                ["u.fullname", "d.*", "a.role"]

            );
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'DealerService::findDealers', ['userid' => $_SESSION['userid']], $th);
            Response::error(500, "An error occurred while fetching dealers");
        }
    }

    public static function fetchDealerInformation($id)
    {
        $dealer = Utility::$dealers_tbl;
        $profile = Utility::$profile_tbl;
        $account = Utility::$accounts_tbl;
        try {
            return Database::joinTables(
                "$dealer d",
                [
                    [
                        "type" => "LEFT",
                        "table" => "$profile u",
                        "on" => "u.userid = d.userid"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$account a",
                        "on" => "u.userid = a.userid"
                    ]
                ],
                ["u.fullname", "d.*", "a.role"],
                [
                    "OR" => [
                        "d.id" => $id,
                        "d.userid" => $id,
                    ]
                ],
                ["d.userid" => $id]
            );
        } catch (\Throwable $th) {

            Utility::log($th->getMessage(), 'error', 'DealerService::getDealerAccount', ['userid' => $id], $th);
            Response::error(500, "An error occurred while fetching dealer");
        }
    }

    public static function sendDealerInformation($id) //remove
    {
        $dealersData = self::fetchDealerInformation($id);
        if (empty($dealersData)) {
            Response::error(404, "Dealer account not found");
        }
        Response::success($dealersData[0], "Dealer found");
    }

    public static function sendAllDealerInformation() //remove
    {
        $dealersData = self::fetchAllDealersInfo();

        if (empty($dealersData)) {
            Response::error(404, "Dealer account not found");
        }
        Response::success($dealersData, "Dealers found");
    }

    public static function saveNewDealerInformation($data)
    {

        $dealerTable = Utility::$dealers_tbl;
        try {
            $dealersData = self::fetchAllDealersInfo();

            if (!empty($dealersData)) {
                foreach ($dealersData as $dealer) {
                    if (
                        trim(strtolower($dealer['company'])) === strtolower($data['company'])
                        || $dealer['userid'] === $data['userid']
                    ) {
                        Response::error(409, "Dealer already exists");
                    }
                }
            }

            $dealerInfo = [
                'userid' => $data['userid'],
                'company' => $data['company'],
                'contact' => $data['contact'],
                'status' => 'pending',
                'phone' => $data['phone'],
                'state' => $data['state'],
                'listings' => 0,
                'rating' => 0,
                'banner' => null,
                'avatar' => null,
                'about' => $data['about'] ?? '',
                'documents' => null,
                'rc_number' => isset($data['rc_number']) ? $data['rc_number'] : null,
                'revenue' => 0,
            ];

            if (
                isset($_FILES['banner']) &&
                $_FILES['banner']['error'] === UPLOAD_ERR_OK &&
                is_uploaded_file($_FILES['banner']['tmp_name'])
            ) {
                $target_dir =   "public/UPLOADS/dealers/";
                $dealer_banner = Utility::uploadDocuments('banner', $target_dir);
                if (!$dealer_banner || !$dealer_banner['success']) Response::error(500, "Image upload failed");

                $dealerInfo['banner'] = $dealer_banner['files'][0];
            }

            if (
                isset($_FILES['docInput']) &&
                $_FILES['docInput']['error'] === UPLOAD_ERR_OK &&
                is_uploaded_file($_FILES['docInput']['tmp_name'])
            ) {
                $target_dir =   "public/UPLOADS/dealers/docs/";
                $dealer_docInput = Utility::uploadDocuments('docInput', $target_dir);
                if (!$dealer_docInput || !$dealer_docInput['success']) Response::error(500, "Image upload failed");

                $dealerInfo['documents'] = json_encode($dealer_banner['files']);
            }

            if (
                isset($_FILES['avatar']) &&
                $_FILES['avatar']['error'] === UPLOAD_ERR_OK &&
                is_uploaded_file($_FILES['avatar']['tmp_name'])
            ) {
                $target_dir =   "public/UPLOADS/avatar/";
                $dealer_avatar = Utility::uploadDocuments('avatar', $target_dir);
                if (!$dealer_avatar || !$dealer_avatar['success']) Response::error(500, "Image upload failed");

                $dealerInfo['avatar'] = $dealer_avatar['files'][0];
            }

            if (Database::insert($dealerTable, $dealerInfo)) {
                Activity::activity([
                    'userid' => $data['userid'],
                    'type' => 'register',
                    'title' => 'dealer register successful',
                ]);
                return true;
            }
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'DealerService::createADealer', ['userid' => $data['userid']], $th);
            Response::error(500, "An error occurred while creating dealer account");
        }
    }

    public static function updateDealerAccount($id, $data)
    {
        $dealerTable = Utility::$dealers_tbl;
        try {
            $dealersData = self::fetchDealerInformation($id);
            if (empty($dealersData)) Response::error(404, "Dealer account not found");

            $dealer = $dealersData[0];

            $dealerInfo = [
                'company' => $data['company'] ?? $dealer['company'],
                'contact' => $data['contact'] ?? $dealer['contact'],
                'status' => $data['status'] ?? $dealer['status'],
                'phone' => $data['phone'] ?? $dealer['phone'],
                'state' => $data['state'] ?? $dealer['state'],
                'listings' => isset($data['listings']) ? intval($data['listings']) : intval($dealer['listings']),
                'rating' => isset($data['rating']) ? intval($data['rating']) : intval($dealer['rating']),
                'about' => $data['about'] ?? $dealer['about'],
                'revenue' => isset($data['revenue']) ? intval($data['revenue']) : intval($dealer['revenue']),
                'active' => isset($data['active']) ? intval($data['active']) : intval($dealer['active']),
            ];


            if (
                isset($_FILES['banner']) &&
                $_FILES['banner']['error'] === UPLOAD_ERR_OK &&
                is_uploaded_file($_FILES['banner']['tmp_name'])
            ) {
                $target_dir =   "public/UPLOADS/dealers/";

                $dealer_banner = Utility::uploadDocuments('banner', $target_dir);
                if (!$dealer_banner || !$dealer_banner['success']) Response::error(500, "Image upload failed");

                $dealerInfo['banner'] = $dealer_banner['files'][0];

                if (isset($dealer['banner'])) {
                    $filenameFromUrl = basename($dealer['banner']);
                    $file = "../" . $target_dir  . $filenameFromUrl;
                    if (file_exists($file))
                        unlink($file);
                }
            }


            if (
                isset($_FILES['avatar']) &&
                $_FILES['avatar']['error'] === UPLOAD_ERR_OK &&
                is_uploaded_file($_FILES['avatar']['tmp_name'])
            ) {
                $target_dir =   "public/UPLOADS/avatar/";

                $dealer_avatar = Utility::uploadDocuments('avatar', $target_dir);
                if (!$dealer_avatar || !$dealer_avatar['success']) Response::error(500, "Image upload failed");

                $dealerInfo['avatar'] = $dealer_avatar['files'][0];

                if (isset($dealer['avatar'])) {
                    $filenameFromUrl = basename($dealer['avatar']);
                    $file = "../" . $target_dir  . $filenameFromUrl;
                    if (file_exists($file))
                        unlink($file);
                }
            }

            if (
                Database::update($dealerTable,  $dealerInfo, ["id" => $id])
            ) {
                Activity::activity([
                    'userid' => $dealer['userid'],
                    'type' => 'update',
                    'title' => 'dealer updates successful',
                ]);

                return true;
            }
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'DealerService::updateDealerAccount', ['userid' => $data['userid']], $th);
            Response::error(500, "An error occurred while updating dealer details");
        }
    }

    public static function deleteDealerAccount($id)
    {
        $dealerTable = Utility::$dealers_tbl;
        try {
            $dealersData = self::fetchDealerInformation($id);
            if (empty($dealersData)) Response::error(404, "Dealer account not found");

            $dealer = $dealersData[0];

            if (isset($dealer['avatar'])) {
                $filenameFromUrl = basename($dealer['avatar']);
                $target_dir = "../public/UPLOADS/avatar/" . $filenameFromUrl;

                if (file_exists($target_dir)) {
                    unlink($target_dir);
                }
            }

            if (isset($dealer['banner'])) {
                $filenameFromUrl = basename($dealer['banner']);
                $target_dir = "../public/UPLOADS/dealers/" . $filenameFromUrl;

                if (file_exists($target_dir)) {
                    unlink($target_dir);
                }
            }


            if (isset($dealer['documents'])) {
                $documents = json_decode($dealer['documents'], true);
                foreach ($documents as $document) {
                    $filenameFromUrl = basename($document);
                    $target_dir = "../public/UPLOADS/dealers/docs/" . $filenameFromUrl;

                    if (file_exists($target_dir)) {
                        unlink($target_dir);
                    }
                }
            }

            if (Database::delete($dealerTable, ["id" => $id])) {
                Activity::activity([
                    'userid' =>  $dealer['userid'],
                    'type' => 'dealer',
                    'title' => 'dealer delete successful',
                ]);
                return true;
            }
        } catch (\Throwable $th) {

            Utility::log($th->getMessage(), 'error', 'DealerService::deleteDealerAccount', ['userid' => $id], $th);
            Response::error(500, "An error occurred while deleting dealer account");
        }
    }
}
