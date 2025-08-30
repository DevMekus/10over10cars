<?php

namespace App\Controllers;

use App\Services\DealerService;
use App\Utils\Response;
use App\Utils\RequestValidator;

class DealerController
{


    public function index()
    {
        $dealers = DealerService::fetchAllDealersInfo();
        if (empty($dealers)) Response::error(404, "Dealers not found");
        Response::success($dealers, "Dealers found");
    }
    public function findADealer($id)
    {
        $id = RequestValidator::parseId($id);
        $dealer = DealerService::fetchDealerInformation($id);
        if (empty($dealer)) Response::error(404, "Dealer not found");
        Response::success($dealer, "Dealer found");
    }

    public function dealerRegistration()
    {
        $data = RequestValidator::validate([
            'company' => 'require|min:3',
            'userid' => 'required|address',
            'contact' => 'required|city',
            'phone' => 'required|country',
            'state' => 'required|state',
            'about' => 'required|state'
        ], $_POST);

        $data = RequestValidator::sanitize($data);

        $upload = DealerService::saveNewDealerInformation($data);

        if ($upload) Response::success(
            ['dealer' => $data['userid']],
            'dealer registration successful'
        );
    }

    public function updateDealerInfo($id)
    {
        $id = RequestValidator::parseId($id);
        $data = RequestValidator::validate([
            'status' => 'require',
        ]);

        $data = RequestValidator::sanitize($data);
        $update = DealerService::updateDealerAccount($id, $data);
        if ($update) Response::success([], "Dealer Account update successful");
    }

    public function deleteDealerInfo($id)
    {
        $id = RequestValidator::parseId($id);
        $delete = DealerService::deleteDealerAccount($id);
        if ($delete) Response::success([], "Dealer Account delete successful");
    }
}
