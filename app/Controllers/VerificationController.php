<?php

namespace App\Controllers;

use App\Services\VerificationService;
use App\Utils\Response;
use App\Utils\RequestValidator;
use Exception;

/**
 * Class VerificationController
 *
 * Handles CRUD operations and request handling
 * for verification processes.
 *
 * @package App\Controllers
 */
class VerificationController
{
    /**
     * Retrieve all verification requests.
     *
     * @return void
     */
    public function index(): void
    {
        try {
            $verifications = VerificationService::fetchAllVerificationRequest();

            if (empty($verifications)) {
                Response::error(404, "Verifications not found");
            }

            Response::success($verifications, "Verifications found");
        } catch (Exception $e) {
            Response::error(500, "An error occurred while fetching verifications: " . $e->getMessage());
        }
    }

    /**
     * Fetch a single verification request by ID.
     *
     * @param mixed $id Verification ID (string|int).
     * @return void
     */
    public function fetchVerification($id): void
    {
        try {
            $id = RequestValidator::parseId($id);
            $verification = VerificationService::fetchVerificationRequest($id);

            if (empty($verification)) {
                Response::error(404, "Verification not found");
            }

            Response::success($verification, "Verification found");
        } catch (Exception $e) {
            Response::error(500, "An error occurred while fetching verification: " . $e->getMessage());
        }
    }

    /**
     * Post a new verification request.
     *
     * Expects reference, email_address, vin, and plan in POST request.
     *
     * @return void
     */
    public function postVerificationRequest(): void
    {
        try {
            $data = RequestValidator::validate([
                'reference'     => 'require|min:3',
                'email_address' => 'required|address',
                'vin'           => 'required|city',
                'plan'          => 'required|country',
            ], $_POST);

            $data = RequestValidator::sanitize($data);

            if (VerificationService::verifyAndSaveRequest($data)) {
                Response::success([], 'Payment successful.');
            } else {
                Response::error(500, "Failed to save verification request");
            }
        } catch (Exception $e) {
            Response::error(500, "An error occurred while posting verification: " . $e->getMessage());
        }
    }

    /**
     * Update an existing verification request by ID.
     *
     * Expects `status` in POST request.
     *
     * @param mixed $id Verification ID.
     * @return void
     */
    public function updateVerification($id): void
    {
        try {
            $id = RequestValidator::parseId($id);

            $data = RequestValidator::validate([
                'status' => 'require|min:3',
            ], $_POST);

            $data = RequestValidator::sanitize($data);

            if (VerificationService::updateVerificationRequest($id, $data)) {
                Response::success([], 'Update successful.');
            } else {
                Response::error(500, "Failed to update verification");
            }
        } catch (Exception $e) {
            Response::error(500, "An error occurred while updating verification: " . $e->getMessage());
        }
    }
}
