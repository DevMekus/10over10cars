<?php

namespace APP\Models;

use configs\DBConnection;
use App\Utils\Utility;

class Dealers
{
    private static $dealers = 'dealers_tbl';
    private static $profile = 'users_tbl';

    public static function findDealerById($id) //pass
    {
        try {
            $db = DBConnection::getConnection();
            $dealers = self::$dealers;
            $profile = self::$profile;

            $sql = "SELECT dealer.*,
                        user.fullname,
                        user.email_address,
                        user.phone_number,
                        user.avatar
                        FROM {$dealers} AS dealer
                        LEFT JOIN {$profile} AS user ON user.userid = dealer.userid
                        WHERE dealer.userid = :userid
                            OR dealer.id =:id LIMIT 1";
            $stmt = $db->prepare($sql);

            $stmt->bindParam(':userid', $id);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'User::findDealerById', ['host' => 'localhost'], $e);
        }
    }

    public static function findDealers() //pass
    {
        try {
            $db = DBConnection::getConnection();
            $dealers = self::$dealers;
            $profile = self::$profile;

            $sql = "SELECT dealer.*,
                        user.fullname,
                        user.email_address,
                        user.phone_number,
                        user.avatar
                        FROM {$dealers} AS dealer
                        LEFT JOIN {$profile} AS user ON user.userid = dealer.userid
                        ORDER BY dealer.id DESC";
            $stmt = $db->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'User::findDealerById', ['host' => 'localhost'], $e);
        }
    }

    public static function create($data) //pass
    {
        $db = DBConnection::getConnection();
        $dealers = self::$dealers;

        try {
            $stmt = $db->prepare(
                "INSERT INTO {$dealers} (userid, dealer_name, business_address, city, state_, country, logo) 
                    VALUES (:userid, :dealer_name, :business_address, :city, :state_, :country, :logo)"
            );
            return $stmt->execute(
                [
                    'userid' => $data['userid'],
                    'dealer_name' => $data['dealerName'],
                    'business_address' => $data['address'],
                    'city' => $data['city'],
                    'state_' => $data['state'],
                    'country' => $data['country'],
                    'logo' => $data['logo'],
                ]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Dealer::create', ['host' => 'localhost'], $e);
        }
    }

    public static function update($prev, $data) //pass
    {
        try {
            $db = DBConnection::getConnection();
            $dealers = self::$dealers;
            $stmt = $db->prepare(
                "UPDATE {$dealers}
                    SET dealer_name = :dealer_name,
                    business_address = :business_address,
                    state_ = :state_,
                    country = :country,
                    logo = :logo,
                    status = :status
                WHERE userid = :userid OR id = :id"
            );

            return $stmt->execute(
                [
                    'id' => $data['id'] ?? $prev['id'],
                    'userid' => $data['userid'] ?? $prev['userid'],
                    'dealer_name' => $data['dealerName'] ?? $prev['dealer_name'],
                    'business_address' => $data['address'] ?? $prev['business_address'],
                    'state_' => $data['state'] ?? $prev['state_'],
                    'country' => $data['country'] ?? $prev['country'],
                    'logo' => $data['logo'] ?? $prev['logo'],
                    'status' => $data['status'] ?? $prev['status'],
                ]
            );
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Dealers::update', ['host' => 'localhost'], $e);
        }
    }

    public static function delete($id) //pass
    {
        try {
            $db = DBConnection::getConnection();
            $dealers = self::$dealers;

            $stmt = $db->prepare("DELETE FROM {$dealers} 
                WHERE userid = :userid OR id = :id");
            return $stmt->execute(['id' => $id, 'userid' => $id]);
        } catch (\Throwable $e) {
            Utility::log($e->getMessage(), 'error', 'Dealers::delete', ['host' => 'localhost'], $e);
        }
    }
}
