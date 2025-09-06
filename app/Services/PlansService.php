<?php

namespace App\Services;

use App\Utils\Response;
use configs\Database;
use App\Services\Activity;
use App\Utils\Utility;
use Throwable;

/**
 * Class PlansService
 *
 * Manages verification plans, including creation, update, deletion,
 * and retrieval of plans from the database.
 *
 * @package App\Services
 */
class PlansService
{
    /**
     * Fetch a single verification plan by ID or plan name.
     *
     * @param int|string $id Plan ID or plan name.
     * @return array|null
     */
    public static function fetchVerificationPlan($id): ?array
    {
        try {
            $plan   = Utility::$plans;
            $query  = "SELECT * FROM $plan WHERE id = :id OR plan = :plan";
            $params = ['id' => $id, 'plan' => $id];
            return Database::query($query, $params);
        } catch (Throwable $th) {
            Utility::log($th->getMessage(), 'error', __METHOD__, ['userid' => $_SESSION['userid'] ?? null], $th);
            Response::error(500, "An error occurred while fetching plan");
        }
        return null;
    }

    /**
     * Fetch all verification plans ordered by price (highest first).
     *
     * @return array|null
     */
    public static function fetchAllVerificationPlans(): ?array
    {
        try {
            $plan   = Utility::$plans;
            $query  = "SELECT * FROM $plan ORDER BY price DESC";
            return Database::query($query, []);
        } catch (Throwable $th) {
            Utility::log($th->getMessage(), 'error', __METHOD__, ['userid' => $_SESSION['userid'] ?? null], $th);
            Response::error(500, "An error occurred while fetching plans");
        }
        return null;
    }

    /**
     * Send a single verification plan response by ID or name.
     *
     * @param int|string $id
     * @return void
     */
    public static function sendVerificationPlan($id): void
    {
        $data = self::fetchVerificationPlan($id);
        if (empty($data)) {
            Response::error(404, "Plan not found");
        }
        Response::success($data[0], "Plan found");
    }

    /**
     * Send all verification plans as a response.
     *
     * @return void
     */
    public static function sendAllVerificationPlan(): void
    {
        $data = self::fetchAllVerificationPlans();
        if (empty($data)) {
            Response::error(404, "Plans not found");
        }
        Response::success($data, "Plans found");
    }

    /**
     * Create a new verification plan.
     *
     * @param array $data
     * @return void
     */
    public static function createANewPlan(array $data): void
    {
        try {
            $plan = Utility::$plans;

            // Check if plan already exists by plan name
            $existingPlan = self::fetchVerificationPlan($data['plan']);
            if (!empty($existingPlan)) {
                Response::error(409, "Plan already exists");
            }

            $planUpload = [
                'plan'  => $data['plan'],
                'price' => intval($data['price']),
                'perks' => json_encode($data['perks']),
                'docs'  => json_encode($data['docs']),
            ];

            if (Database::insert($plan, $planUpload)) {
                Activity::activity([
                    'userid' => $_SESSION['userid'] ?? null,
                    'type'   => 'Plan',
                    'title'  => 'New verification plan created',
                ]);
                Response::success([], "New verification plan added successfully");
            }
        } catch (Throwable $th) {
            Utility::log($th->getMessage(), 'error', __METHOD__, ['userid' => $_SESSION['userid'] ?? null], $th);
            Response::error(500, "An error occurred while creating plan");
        }
    }

    /**
     * Update an existing verification plan.
     *
     * @param int   $id
     * @param array $data
     * @return void
     */
    public static function updateVerificationPlan(int $id, array $data): void
    {
        try {
            $plan     = Utility::$plans;
            $findPlan = self::fetchVerificationPlan($id);

            if (empty($findPlan)) {
                Response::error(404, "Plan not found");
            }

            $formerPlan = $findPlan[0];

            $updatePlan = [
                'plan'  => $data['plan'] ?? $formerPlan['plan'],
                'price' => isset($data['price']) ? intval($data['price']) : intval($formerPlan['price']),
                'perks' => isset($data['perks']) ? json_encode($data['perks']) : $formerPlan['perks'],
                'docs'  => isset($data['docs']) ? json_encode($data['docs']) : $formerPlan['docs'],
            ];

            if (Database::update($plan, $updatePlan, ["id" => $id])) {
                Activity::activity([
                    'userid' => $_SESSION['userid'] ?? null,
                    'type'   => 'Plan',
                    'title'  => 'Verification plan updated',
                ]);
                Response::success([], "Verification plan update successful");
            }
        } catch (Throwable $th) {
            Utility::log($th->getMessage(), 'error', __METHOD__, ['userid' => $_SESSION['userid'] ?? null], $th);
            Response::error(500, "An error occurred while updating plan");
        }
    }

    /**
     * Delete a verification plan by ID.
     *
     * @param int $id
     * @return void
     */
    public static function deleteVerificationPlan(int $id): void
    {
        try {
            $plan     = Utility::$plans;
            $findPlan = self::fetchVerificationPlan($id);

            if (empty($findPlan)) {
                Response::error(404, "Plan not found");
            }

            if (Database::delete($plan, ["id" => $id])) {
                Activity::activity([
                    'userid' => $_SESSION['userid'] ?? null,
                    'type'   => 'Plan',
                    'title'  => 'Verification plan deleted',
                ]);
                Response::success([], "Verification plan delete successful");
            }
        } catch (Throwable $th) {
            Utility::log($th->getMessage(), 'error', __METHOD__, ['userid' => $_SESSION['userid'] ?? null], $th);
            Response::error(500, "An error occurred while deleting plan");
        }
    }
}
