<?php

namespace App\Services;

use App\Utils\Response;
use configs\Database;
use App\Services\Activity;
use App\Utils\Utility;

/**
 * DealerService
 *
 * Provides services for managing dealer accounts including:
 * - Fetching dealer information
 * - Creating dealer records
 * - Updating dealer records
 * - Deleting dealer records
 *
 * Includes strict error handling and structured logging.
 */
class DealerService
{
    /**
     * Fetch all dealer accounts with joined profile and account information.
     *
     * @return array|null
     */
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
                        "type"  => "LEFT",
                        "table" => "$profile u",
                        "on"    => "u.userid = d.userid"
                    ],
                    [
                        "type"  => "LEFT",
                        "table" => "$account a",
                        "on"    => "u.userid = a.userid"
                    ]
                ],
                ["u.fullname", "d.*", "a.role"]
            );
        } catch (\Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'DealerService::fetchAllDealersInfo',
                ['userid' => $_SESSION['userid'] ?? null],
                $th
            );
            Response::error(500, "An error occurred while fetching dealers");
        }
    }

    /**
     * Fetch a single dealer's information by dealer ID or user ID.
     *
     * @param string|int $id
     * @return array|null
     */
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
                        "type"  => "LEFT",
                        "table" => "$profile u",
                        "on"    => "u.userid = d.userid"
                    ],
                    [
                        "type"  => "LEFT",
                        "table" => "$account a",
                        "on"    => "u.userid = a.userid"
                    ]
                ],
                ["u.fullname", "d.*", "a.role"],
                [
                    "OR" => [
                        "d.id"     => $id,
                        "d.userid" => $id,
                    ]
                ],
                ["d.userid" => $id]
            );
        } catch (\Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'DealerService::fetchDealerInformation',
                ['userid' => $id],
                $th
            );
            Response::error(500, "An error occurred while fetching dealer");
        }
    }

    /**
     * Save a new dealer account into the database.
     *
     * @param array $data
     * @return bool
     */
    public static function saveNewDealerInformation($data)
    {
        $dealerTable = Utility::$dealers_tbl;

        try {
            $dealersData = self::fetchAllDealersInfo();

            // Prevent duplicate company name or userid
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
                'userid'    => $data['userid'],
                'company'   => $data['company'],
                'contact'   => $data['contact'],
                'status'    => 'pending',
                'phone'     => $data['phone'],
                'state'     => $data['state'],
                'listings'  => 0,
                'rating'    => 0,
                'banner'    => null,
                'avatar'    => null,
                'about'     => $data['about'] ?? '',
                'documents' => null,
                'rc_number' => $data['rc_number'] ?? null,
                'revenue'   => 0,
            ];

            // Handle file uploads (banner, documents, avatar)
            if (
                isset($_FILES['banner']) &&
                $_FILES['banner']['error'] === UPLOAD_ERR_OK &&
                is_uploaded_file($_FILES['banner']['tmp_name'])
            ) {
                $targetDir = "public/UPLOADS/dealers/";
                $dealerBanner = Utility::uploadDocuments('banner', $targetDir);
                if (!$dealerBanner || !$dealerBanner['success']) {
                    Response::error(500, "Banner upload failed");
                }
                $dealerInfo['banner'] = $dealerBanner['files'][0];
            }

            if (
                isset($_FILES['docInput']) &&
                $_FILES['docInput']['error'] === UPLOAD_ERR_OK &&
                is_uploaded_file($_FILES['docInput']['tmp_name'])
            ) {
                $targetDir = "public/UPLOADS/dealers/docs/";
                $dealerDocs = Utility::uploadDocuments('docInput', $targetDir);
                if (!$dealerDocs || !$dealerDocs['success']) {
                    Response::error(500, "Document upload failed");
                }
                $dealerInfo['documents'] = json_encode($dealerDocs['files']);
            }

            if (
                isset($_FILES['avatar']) &&
                $_FILES['avatar']['error'] === UPLOAD_ERR_OK &&
                is_uploaded_file($_FILES['avatar']['tmp_name'])
            ) {
                $targetDir = "public/UPLOADS/avatar/";
                $dealerAvatar = Utility::uploadDocuments('avatar', $targetDir);
                if (!$dealerAvatar || !$dealerAvatar['success']) {
                    Response::error(500, "Avatar upload failed");
                }
                $dealerInfo['avatar'] = $dealerAvatar['files'][0];
            }

            if (Database::insert($dealerTable, $dealerInfo)) {
                Activity::activity([
                    'userid' => $data['userid'],
                    'type'   => 'register',
                    'title'  => 'Dealer registration successful',
                ]);
                return true;
            }
        } catch (\Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'DealerService::saveNewDealerInformation',
                ['userid' => $data['userid']],
                $th
            );
            Response::error(500, "An error occurred while creating dealer account");
        }
    }

    /**
     * Update dealer account details.
     *
     * @param string|int $id
     * @param array $data
     * @return bool
     */
    public static function updateDealerAccount($id, $data)
    {
        $dealerTable = Utility::$dealers_tbl;

        try {
            $dealersData = self::fetchDealerInformation($id);
            if (empty($dealersData)) {
                Response::error(404, "Dealer account not found");
            }

            $dealer = $dealersData[0];

            $dealerInfo = [
                'company' => $data['company'] ?? $dealer['company'],
                'contact' => $data['contact'] ?? $dealer['contact'],
                'status'  => $data['status'] ?? $dealer['status'],
                'phone'   => $data['phone'] ?? $dealer['phone'],
                'state'   => $data['state'] ?? $dealer['state'],
                'listings'=> isset($data['listings']) ? intval($data['listings']) : intval($dealer['listings']),
                'rating'  => isset($data['rating']) ? intval($data['rating']) : intval($dealer['rating']),
                'about'   => $data['about'] ?? $dealer['about'],
                'revenue' => isset($data['revenue']) ? intval($data['revenue']) : intval($dealer['revenue']),
                'active'  => isset($data['active']) ? intval($data['active']) : intval($dealer['active']),
            ];

            // Handle updated files (banner, avatar)
            if (
                isset($_FILES['banner']) &&
                $_FILES['banner']['error'] === UPLOAD_ERR_OK &&
                is_uploaded_file($_FILES['banner']['tmp_name'])
            ) {
                $targetDir = "public/UPLOADS/dealers/";
                $dealerBanner = Utility::uploadDocuments('banner', $targetDir);
                if (!$dealerBanner || !$dealerBanner['success']) {
                    Response::error(500, "Banner upload failed");
                }
                $dealerInfo['banner'] = $dealerBanner['files'][0];

                if (!empty($dealer['banner'])) {
                    $oldFile = "../$targetDir" . basename($dealer['banner']);
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
            }

            if (
                isset($_FILES['avatar']) &&
                $_FILES['avatar']['error'] === UPLOAD_ERR_OK &&
                is_uploaded_file($_FILES['avatar']['tmp_name'])
            ) {
                $targetDir = "public/UPLOADS/avatar/";
                $dealerAvatar = Utility::uploadDocuments('avatar', $targetDir);
                if (!$dealerAvatar || !$dealerAvatar['success']) {
                    Response::error(500, "Avatar upload failed");
                }
                $dealerInfo['avatar'] = $dealerAvatar['files'][0];

                if (!empty($dealer['avatar'])) {
                    $oldFile = "../$targetDir" . basename($dealer['avatar']);
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
            }

            if (Database::update($dealerTable, $dealerInfo, ["id" => $id])) {
                Activity::activity([
                    'userid' => $dealer['userid'],
                    'type'   => 'update',
                    'title'  => 'Dealer update successful',
                ]);
                return true;
            }
        } catch (\Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'DealerService::updateDealerAccount',
                ['userid' => $data['userid'] ?? null],
                $th
            );
            Response::error(500, "An error occurred while updating dealer details");
        }
    }

    /**
     * Delete a dealer account and associated uploaded files.
     *
     * @param string|int $id
     * @return bool
     */
    public static function deleteDealerAccount($id)
    {
        $dealerTable = Utility::$dealers_tbl;

        try {
            $dealersData = self::fetchDealerInformation($id);
            if (empty($dealersData)) {
                Response::error(404, "Dealer account not found");
            }

            $dealer = $dealersData[0];

            // Remove files (avatar, banner, documents)
            if (!empty($dealer['avatar'])) {
                $file = "../public/UPLOADS/avatar/" . basename($dealer['avatar']);
                if (file_exists($file)) unlink($file);
            }

            if (!empty($dealer['banner'])) {
                $file = "../public/UPLOADS/dealers/" . basename($dealer['banner']);
                if (file_exists($file)) unlink($file);
            }

            if (!empty($dealer['documents'])) {
                $documents = json_decode($dealer['documents'], true);
                foreach ($documents as $document) {
                    $file = "../public/UPLOADS/dealers/docs/" . basename($document);
                    if (file_exists($file)) unlink($file);
                }
            }

            if (Database::delete($dealerTable, ["id" => $id])) {
                Activity::activity([
                    'userid' => $dealer['userid'],
                    'type'   => 'dealer',
                    'title'  => 'Dealer delete successful',
                ]);
                return true;
            }
        } catch (\Throwable $th) {
            Utility::log(
                $th->getMessage(),
                'error',
                'DealerService::deleteDealerAccount',
                ['userid' => $id],
                $th
            );
            Response::error(500, "An error occurred while deleting dealer account");
        }
    }
}
