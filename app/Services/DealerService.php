<?php

namespace App\Services;

use App\Utils\Response;
use configs\DB;
use App\Services\Activity;
use App\Utils\Utility;


class DealerService
{
    protected $db;
    protected $dealer;
    protected $profile;
    protected $account;


    public function __construct()
    {
        $this->db = new DB();
        $this->dealer = Utility::$dealers_tbl;
        $this->profile = Utility::$profile_tbl;
        $this->account = Utility::$account_tbl;
    }

    public function findDealers()
    {
        try {
            return $this->db->joinTables(
                "$this->dealer d",
                [
                    [
                        "type" => "LEFT",
                        "table" => "$this->profile u",
                        "on" => "u.userid = d.userid"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$this->account a",
                        "on" => "u.userid = a.userid"
                    ]
                ],
                ["u.*", "d.*", "a.*"]

            );
        } catch (\Throwable $th) {
            Response::error(500, "An error occurred while updating user details");
            Utility::log($th->getMessage(), 'error', 'DealerService::findDealers', ['userid' => $_SESSION['userid']], $th);
        }
    }

    private function findDealer($id)
    {
        try {
            return $this->db->joinTables(
                "$this->dealer d",
                [
                    [
                        "type" => "LEFT",
                        "table" => "$this->profile u",
                        "on" => "u.userid = d.userid"
                    ],
                    [
                        "type" => "LEFT",
                        "table" => "$this->account a",
                        "on" => "u.userid = a.userid"
                    ]
                ],
                ["u.*", "d.*", "a.*"],
                ["d.userid" => $id]
            );
        } catch (\Throwable $th) {
            Response::error(500, "An error occurred while updating user details");
            Utility::log($th->getMessage(), 'error', 'DealerService::getDealerAccount', ['userid' => $id], $th);
        }
    }

    public function getDealerAccount($id)
    {
        $dealersData = $this->findDealer($id);
        if (empty($dealersData)) {
            Response::error(404, "Dealer account not found");
        }
        Response::success($dealersData[0], "Dealer found");
    }

    public function getDealersAccounts()
    {
        $dealersData = $this->findDealers();

        if (empty($dealersData)) {
            Response::error(404, "Dealer account not found");
        }
        Response::success($dealersData, "Dealers found");
    }

    public function createADealer($data)
    {


        try {
            $dealersData = $this->findDealers();

            if (!empty($dealersData)) {
                foreach ($dealersData as $dealer) {
                    if (
                        trim(strtolower($dealer['dealer_name'])) === strtolower($data['dealerName'])
                        || $dealer['userid'] === $data['userid']
                    ) {
                        Response::error(409, "Dealer already exists");
                    }
                }
            }

            $dealerInfo = [
                'userid' => $data['userid'],
                'dealer_name' => $data['dealerName'],
                'business_address' => $data['address'],
                'city' => $data['city'],
                'state_' => $data['state'],
                'country' => $data['country'],
            ];

            if (
                isset($_FILES['dealer-logo']) &&
                $_FILES['dealer-logo']['error'] === UPLOAD_ERR_OK &&
                is_uploaded_file($_FILES['dealer-logo']['tmp_name'])
            ) {
                $target_dir =   "public/UPLOADS/dealers/";
                $dealer_avatar = Utility::uploadDocuments('dealer-logo', $target_dir);
                if (!$dealer_avatar || !$dealer_avatar['success']) Response::error(500, "Image upload failed");

                $dealerInfo['logo'] = $dealer_avatar['files'][0];
            }

            if ($this->db->insert($this->dealer, $dealerInfo)) {
                Activity::newActivity([
                    'userid' => $data['userid'],
                    'actions' => "New dealer",
                ]);
                Response::success(
                    ['dealer' => $data['userid']],
                    'dealer registration successful'
                );
            }
            Response::error(500, "An error has occurred");
        } catch (\Throwable $th) {
            Response::error(500, "An error occurred while creating dealer account");
            Utility::log($th->getMessage(), 'error', 'DealerService::createADealer', ['userid' => $data['userid']], $th);
        }
    }

    public function updateDealerAccount($id, $data)
    {
        try {
            $dealersData = $this->findDealer($id);
            if (empty($dealersData)) Response::error(404, "Dealer account not found");

            $dealer = $dealersData[0];

            $dealerInfo = [
                'dealer_name' => $data['dealerName'] ?? $dealer['dealer_name'],
                'business_address' => $data['address'] ?? $dealer['business_address'],
                'state_' => $data['state'] ?? $dealer['state_'],
                'country' => $data['country'] ?? $dealer['country'],
                'status' => $data['status'] ?? $dealer['status'],
            ];

            if (
                isset($_FILES['dealer-logo']) &&
                $_FILES['dealer-logo']['error'] === UPLOAD_ERR_OK &&
                is_uploaded_file($_FILES['dealer-logo']['tmp_name'])
            ) {
                $target_dir =   "public/UPLOADS/dealers/";
                $dealer_avatar = Utility::uploadDocuments('dealer-logo', $target_dir);
                if (!$dealer_avatar || !$dealer_avatar['success']) Response::error(500, "Image upload failed");

                $dealerInfo['logo'] = $dealer_avatar['files'][0];

                if (isset($dealer['logo'])) {
                    $file = $dealer['logo'];
                    if (file_exists($file))
                        unlink($file);
                }
            }

            if (
                $this->db->update($this->dealer,  $dealerInfo, ["userid" => $id])
            ) {
                Activity::newActivity([
                    'userid' => $dealer['userid'],
                    'actions' => 'dealer account updated',
                ]);
                Response::success([], "Dealer Account update successful");
            }
            Response::error(500, "An error has occurred");
        } catch (\Throwable $th) {
            Response::error(500, "An error occurred while updating dealer details");
            Utility::log($th->getMessage(), 'error', 'DealerService::updateDealerAccount', ['userid' => $data['userid']], $th);
        }
    }

    public function deleteDealerAccount($id)
    {
        try {
            $dealersData = $this->findDealer($id);
            if (empty($dealersData)) Response::error(404, "Dealer account not found");

            $dealer = $dealersData[0];

            if (isset($dealer['logo'])) {
                $filenameFromUrl = basename($dealer['logo']);
                $target_dir = "../public/UPLOADS/dealers/" . $filenameFromUrl;

                if (file_exists($target_dir)) {
                    unlink($target_dir);
                }
            }

            if ($this->db->delete($this->dealer, ["userid" => $id])) {
                if (Activity::newActivity([
                    'userid' => $dealer['userid'] ?? $_SESSION['userid'],
                    'actions' => 'dealer account deleted',
                ]));
                Response::success([], "Dealer account deleted");
            }

            Response::error(500, "An error has occurred");
        } catch (\Throwable $th) {
            Response::error(500, "An error occurred while deleting dealer details");
            Utility::log($th->getMessage(), 'error', 'DealerService::deleteDealerAccount', ['userid' => $id], $th);
        }
    }
}
