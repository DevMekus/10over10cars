<?php

namespace App\Services;

use App\Utils\Response;
use configs\Database;
use App\Services\Activity;
use App\Utils\Utility;

class PlansService
{


    public static function fetchVerificationPlan($id)
    {
        try {
            $plan = Utility::$plans;
            $query = "SELECT * FROM $plan WHERE id = :id OR plan = : plan";
            $params = ['id' => $id, 'plan' => $id];
            return Database::query($query, $params);
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'PlansService::fetchVerificationPlan', ['userid' => $_SESSION['userid']], $th);
            Response::error(500, "An error occurred while fetching plan");
        }
    }

    public static function fetchAllVerificationPlans()
    {
        try {
            $plan = Utility::$plans;
            $query = "SELECT * FROM $plan ORDER BY price DESC";
            $params = [];
            return Database::query($query, $params);
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'PlansService::fetchAllVerificationPlans', ['userid' => $_SESSION['userid']], $th);
            Response::error(500, "An error occurred while fetching plans");
        }
    }

    public static function sendVerificationPlan($id)
    {
        $data = self::fetchVerificationPlan($id);
        if (empty($data)) {
            Response::error(404, "plan not found");
        }
        Response::success($data[0], "plan found");
    }

    public static function sendAllVerificationPlan()
    {
        $data = self::fetchAllVerificationPlans();
        if (empty($data)) {
            Response::error(404, "plan not found");
        }
        Response::success($data, "plan found");
    }

    public static function createANewPlan($data)
    {
        try {
            $plan = Utility::$plans;
            $findPlan = self::fetchAllVerificationPlans($data['plan']);
            if (!empty($findPlan)) {
                Response::error(409, "Plan already exists");
            }

            $planUpload = [
                'plan' => $data['plan'],
                'price' => intval($data['price']),
                'perks' => json_encode($data['perks']),
                'docs' => json_encode($data['docs']),
            ];

            if (Database::insert($plan, $planUpload)) {
                Activity::activity([
                    'userid' => $_SESSION['userid'],
                    'type' => 'Plan',
                    'title' => 'New verification plan',
                ]);
                Response::success([], "New verification added");
            }
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'PlansService::createANewPlan', ['userid' => $_SESSION['userid']], $th);
            Response::error(500, "An error occurred while creating plans");
        }
    }

    public static function updateVerificationPlan($id, $data)
    {
        try {
            $plan = Utility::$plans;
            $findPlan = self::fetchAllVerificationPlans($id);
            if (empty($findPlan)) {
                Response::error(404, "Plan not found");
            }

            $formerPlan = $findPlan[0];

            $updatePlan = [
                'plan' => $data['plan'] ?? $formerPlan['plan'],
                'price' => intval($data['price']) ?? intval($formerPlan['price']),
                'perks' => json_encode($data['perks']) ?? $formerPlan['perks'],
                'docs' => json_encode($data['docs']) ?? $formerPlan['docs'],
            ];

            if (
                Database::update($plan,  $updatePlan, ["id" => $id])
            ) {
                Activity::activity([
                    'userid' => $_SESSION['userid'],
                    'type' => 'plan',
                    'title' => 'Verification plan update successful',
                ]);
                Response::success([], "Verification plan update successful");
            }
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'PlansService::updateVerificationPlan', ['userid' => $_SESSION['userid']], $th);
            Response::error(500, "An error occurred while updating a plans");
        }
    }

    public static function deleteVerificationPlan($id)
    {
        try {
            $plan = Utility::$plans;
            $findPlan = self::fetchAllVerificationPlans($id);
            if (empty($findPlan)) {
                Response::error(404, "Plan not found");
            }

            if (Database::delete($plan, ["id" => $id])) {
                Activity::activity([
                    'userid' => $_SESSION['userid'],
                    'type' => 'Plan',
                    'title' => 'Verification plan Deleted',
                ]);
                Response::success([], "Verification plan Delete successful");
            }
        } catch (\Throwable $th) {
            Utility::log($th->getMessage(), 'error', 'PlansService::deleteVerificationPlan', ['userid' => $_SESSION['userid']], $th);
            Response::error(500, "An error occurred while deleting a plans");
        }
    }
}
