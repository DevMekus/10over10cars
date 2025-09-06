<?php

namespace App\Controllers;

use App\Services\DealerService;
use App\Utils\Response;
use App\Utils\RequestValidator;

/**
 * Class DealerController
 *
 * Handles dealer-related operations such as registration,
 * retrieval, update, and deletion of dealer accounts.
 */
class DealerController
{
    /**
     * Retrieve all dealers from the system.
     *
     * @return void
     */
    public function index(): void
    {
        try {
            $dealers = DealerService::fetchAllDealersInfo();

            if (empty($dealers)) {
                Response::error(404, "Dealers not found");
                return;
            }

            Response::success($dealers, "Dealers found");
        } catch (\Throwable $e) {
            Response::error(500, "Error fetching dealers: " . $e->getMessage());
        }
    }

    /**
     * Retrieve information about a specific dealer by ID.
     *
     * @param mixed $id
     * @return void
     */
    public function findADealer($id): void
    {
        try {
            $id = RequestValidator::parseId($id);

            $dealer = DealerService::fetchDealerInformation($id);

            if (empty($dealer)) {
                Response::error(404, "Dealer not found");
                return;
            }

            Response::success($dealer, "Dealer found");
        } catch (\Throwable $e) {
            Response::error(500, "Error fetching dealer: " . $e->getMessage());
        }
    }

    /**
     * Register a new dealer with the provided data.
     *
     * @return void
     */
    public function dealerRegistration(): void
    {
        try {
            $data = RequestValidator::validate([
                'company' => 'required|min:3',
                'userid'  => 'required|numeric',
                'contact' => 'required|string',
                'phone'   => 'required|string',
                'state'   => 'required|string',
                'about'   => 'required|string',
            ], $_POST);

            $data = RequestValidator::sanitize($data);

            $upload = DealerService::saveNewDealerInformation($data);

            if ($upload) {
                Response::success(
                    ['dealer' => $data['userid']],
                    "Dealer registration successful"
                );
                return;
            }

            Response::error(500, "Dealer registration failed");
        } catch (\Throwable $e) {
            Response::error(500, "Error during dealer registration: " . $e->getMessage());
        }
    }

    /**
     * Update dealer account information.
     *
     * @param mixed $id
     * @return void
     */
    public function updateDealerInfo($id): void
    {
        try {
            $id = RequestValidator::parseId($id);

            $data = RequestValidator::validate([
                'status' => 'required|string',
            ]);

            $data = RequestValidator::sanitize($data);

            $update = DealerService::updateDealerAccount($id, $data);

            if ($update) {
                Response::success([], "Dealer account update successful");
                return;
            }

            Response::error(500, "Dealer account update failed");
        } catch (\Throwable $e) {
            Response::error(500, "Error updating dealer: " . $e->getMessage());
        }
    }

    /**
     * Delete a dealer account by ID.
     *
     * @param mixed $id
     * @return void
     */
    public function deleteDealerInfo($id): void
    {
        try {
            $id = RequestValidator::parseId($id);

            $delete = DealerService::deleteDealerAccount($id);

            if ($delete) {
                Response::success([], "Dealer account deletion successful");
                return;
            }

            Response::error(500, "Dealer account deletion failed");
        } catch (\Throwable $e) {
            Response::error(500, "Error deleting dealer: " . $e->getMessage());
        }
    }
}
