<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Dealers;
use App\Models\Report;
use App\Utils\Response;
use App\Services\Activity;
use App\Utils\Utility;
use App\Utils\MailClient;
use App\Models\Support;
use DateTime;

class UserService
{


    public static function userManagerOverview() //pass
    {
        $users = User::usersData();
        //get total new users for the week
        $usersThisWeek = self::totalUsersThisWeek($users);

        //suspended accounts
        $suspendedUser = array_filter($users, function ($user) {
            return strtolower($user['account_status']) === 'suspended';
        });

        //admins
        $admins = array_filter($users, function ($user) {
            return strtolower($user['role_id']) === '1';
        });
        $overview = [
            'total users' => count($users),
            'new this week' => $usersThisWeek,
            'suspended' => count($suspendedUser),
            'admins' => count($admins),
        ];

        $overviewArray = [];
        foreach ($overview as $key => $value) {
            $overviewArray[] = [
                'label' => $key,
                'value' => $value
            ];
        }

        return  [
            'overview' => $overviewArray,
            'users' => $users
        ];
    }

    private static function totalUsersThisWeek($users) //pass
    {
        $now = new DateTime();
        $startOfWeek = clone $now;
        $startOfWeek->modify('monday this week')->setTime(0, 0, 0);

        $endOfWeek = clone $startOfWeek;
        $endOfWeek->modify('sunday this week')->setTime(23, 59, 59);

        $userCount = 0;

        foreach ($users as $user) {
            $userDate = new DateTime($user['create_date']);
            if ($userDate >= $startOfWeek && $userDate <= $endOfWeek) {
                $userCount++;
            }
        }

        return $userCount;
    }

    public static function dealersManagerOverview() //pass
    {
        $dealers = Dealers::findDealers();

        $activeDealers = array_filter($dealers, function ($dealer) {
            return strtolower($dealer['status']) === 'active';
        });

        $pendingDealers = array_filter($dealers, function ($dealer) {
            return strtolower($dealer['status']) === 'pending';
        });

        $overview = [
            'total dealers' => count($dealers),
            'active dealers' => count($activeDealers),
            'pending approval' => count($pendingDealers),
            'top rated' => '',
        ];

        $overviewArray = [];
        foreach ($overview as $key => $value) {
            $overviewArray[] = [
                'label' => $key,
                'value' => $value
            ];
        }

        return  [
            'overview' => $overviewArray,
            'dealers' => $dealers
        ];
    }

    public static function updateUserAccount($id, $data) //pass
    {
        try {
            $user = User::userData($id);
            if (!$user) Response::error(404, "User not found");

            /**Process Profile Image update */
            if (
                isset($_FILES['dp-upload']) &&
                $_FILES['dp-upload']['error'] === UPLOAD_ERR_OK &&
                is_uploaded_file($_FILES['dp-upload']['tmp_name'])
            ) {
                $target_dir =   "public/UPLOADS/avatars/";
                $user_avatar = Utility::uploadDocuments('dp-upload', $target_dir);
                if (!$user_avatar || !$user_avatar['success']) Response::error(500, "Image upload failed");


                $data['avatar'] = $user_avatar['files'][0];

                if (isset($user['avatar'])) {
                    $file = $user['avatar'];
                    if (file_exists($file))
                        unlink($file);
                }
            }

            if (

                User::updateUserAccount($user, $data)
                && User::updateUserProfile($user, $data)
            ) {
                if (Activity::newActivity([
                    'userid' => $id,
                    'actions' => 'account updated',
                ])) Response::success([], "account updated");
            }
            Response::error(500, "An error has occurred");
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'UserService::updateUserAccount', ['host' => 'localhost'], $e);
        }
    }

    public static function deleteUser($id) //pass
    {
        try {
            $user = User::userData($id);

            if (!$user) Response::error(404, "User not found");

            if (User::delete($id)) {
                $dealer = Dealers::findDealerById($id);
                if ($dealer) Dealers::delete($id);
                if (Activity::newActivity([
                    'userid' => $id,
                    'actions' => 'account deleted',
                ])) Response::success([], "account deleted");
            }
            Response::error(500, "An error has occurred");
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'UserService::deleteUser', ['host' => 'localhost'], $e);
        }
    }

    public static function deleteDealer($id) //pass
    {
        try {
            $dealer = Dealers::findDealerById($id);

            if (!$dealer) Response::error(404, "dealer not found");

            if (Dealers::delete($id)) {
                if (Activity::newActivity([
                    'userid' => $dealer['userid'],
                    'actions' => 'dealer account deleted',
                ])) Response::success([], "Dealer deleted");
            }
            Response::error(500, "An error has occurred");
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'UserService::deleteDealer', ['host' => 'localhost'], $e);
        }
    }

    public static function createADealer($data) //pass
    {

        try {
            $dealer = Dealers::findDealerById($data['userid']);
            if ($dealer) Response::error(409, "Dealer already exists");
            $dealers = Dealers::findDealers();
            foreach ($dealers as $dealer) {
                if (trim(strtolower($dealer['dealer_name'])) === strtolower($data['dealerName'])) {
                    Response::error(409, "Dealer already exists");
                }
            }
            /**Process logo */
            if (
                isset($_FILES['dealer-logo']) &&
                $_FILES['dealer-logo']['error'] === UPLOAD_ERR_OK &&
                is_uploaded_file($_FILES['dealer-logo']['tmp_name'])
            ) {
                $target_dir =   "public/UPLOADS/dealers/";
                $dealer_avatar = Utility::uploadDocuments('dealer-logo', $target_dir);
                if (!$dealer_avatar || !$dealer_avatar['success']) Response::error(500, "Image upload failed");

                $data['logo'] = $dealer_avatar['files'][0];
            }

            if (Dealers::create($data)) {
                if (Activity::newActivity([
                    'userid' => $data['userid'],
                    'actions' => 'new dealer',
                ])) Response::success([], "Dealer account created");
            }
            Response::error(500, "An error has occurred");
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'UserService::createADealer', ['host' => 'localhost'], $e);
        }
    }

    public static function updateDealerInfo($id, $data) //pass
    {
        try {
            $dealer = Dealers::findDealerById($id);
            if (!$dealer) Response::error(404, "Dealer not found");

            /**Process logo */
            if (
                isset($_FILES['dealer-logo']) &&
                $_FILES['dealer-logo']['error'] === UPLOAD_ERR_OK &&
                is_uploaded_file($_FILES['dealer-logo']['tmp_name'])
            ) {
                $target_dir =   "public/UPLOADS/dealers/";
                $dealer_avatar = Utility::uploadDocuments('dealer-logo', $target_dir);
                if (!$dealer_avatar || !$dealer_avatar['success']) Response::error(500, "Image upload failed");

                $data['logo'] = $dealer_avatar['files'][0];

                if (isset($dealer['logo'])) {
                    $file = $dealer['logo'];
                    if (file_exists($file))
                        unlink($file);
                }
            }


            if (Dealers::update($dealer, $data)) {

                if (Activity::newActivity([
                    'userid' => $id,
                    'actions' => 'dealer updated',
                ])) Response::success([], "Dealer account updated");
            }
            Response::error(500, "An error has occurred");
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'UserService::updateDealerInfo', ['host' => 'localhost'], $e);
        }
    }

    public static function updateAccountPassword($id, $data)
    {
        try {
            $user = User::userData($id);
            if (!$user) Response::error(404, "User not found");

            if ($user && !password_verify($data['old_password'], $user['user_password'])) {
                Response::error(401, "Invalid password");
            }
            $data['user_password'] = password_hash($data['new_password'], PASSWORD_BCRYPT);
            $data['userid'] = $id;
            if (User::updateUserProfile($user, $data)) {
                if (Activity::newActivity([
                    'userid' => $id,
                    'actions' => 'password updated',
                ])) {
                    $user = User::userData($id);
                    Response::success($user, "Account password updated");
                }
            }
            Response::error(500, "An error has occurred");
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'UserService::updateAccountPassword', ['host' => 'localhost'], $e);
        }
    }

    public static function securityManagerOverview()
    {
        try {
            $logs = ActivityLog::fetchLogs();
            $users = User::usersData();

            $admins = array_filter($users, function ($user) {
                return strtolower($user['role_id']) === '1';
            });

            return  [
                'logs' => $logs,
                'admins' => array_values($admins)
            ];
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'UserService::securityManagerOverview', ['host' => 'localhost'], $e);
        }
    }

    public static function userSecurityManagement($id)
    {
        try {
            $logs = ActivityLog::fetchLogsById($id);

            return  [
                'logs' => $logs,
            ];
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'UserService::userSecurityManagement', ['host' => 'localhost'], $e);
        }
    }

   

    
}
