<?php

namespace App\Controllers;


use App\Services\VerificationService;
use App\Utils\Response;
use App\Utils\RequestValidator;

class VerificationController
{

    public function index()
    {
        $verifications = VerificationService::fetchAllVerificationRequest();
        if (empty($verifications)) Response::error(404, "verifications not found");
        Response::success($verifications, "verifications found");
    }

    public function fetchVerification($id)
    {
        $id = RequestValidator::parseId($id);
        $verification = VerificationService::fetchVerificationRequest($id);
        if (empty($verification)) Response::error(404, "verification not found");
        Response::success($verification, "verifications found");
    }

    public function postVerificationRequest()
    {
        $data = RequestValidator::validate([
            'reference' => 'require|min:3',
            'email_address' => 'required|address',
            'vin' => 'required|city',
            'plan' => 'required|country',
        ]);

        $data = RequestValidator::sanitize($data);

        if (VerificationService::verifyAndSaveRequest($data))
            Response::success([], 'payment successful.');
    }

    public function updateVerification($id)
    {
        $id = RequestValidator::parseId($id);
        $data = RequestValidator::validate([
            'status' => 'require|min:3',
        ]);
        $data = RequestValidator::sanitize($data);

        if (VerificationService::updateVerificationRequest($id, $data))
            Response::success([], 'Update successful.');
    }
}
