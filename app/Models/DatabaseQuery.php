<?php

namespace App\Models;

use App\Utils\Response;
use App\Utils\Utility;
use configs\DBConnection;


class DatabaseQuery
{

    private static $db;

    private static function init()
    {
        self::$db = DBConnection::getConnection();
    }
    public static function updateRow($table, $id, $data)
    {

        $allowedTables = ['vehicle_specs', 'vehicle_inspections', 'vehicle_documents'];

        if (!in_array($table, $allowedTables)) {
            Utility::log("Invalid data to update", 'error', 'DatabaseQuery::updateRow');
            Response::error(500, "Invalid table name");
        }

        self::init();

        if (!is_array($data) || empty($data)) {
            Utility::log("Invalid data to update", 'error', 'DatabaseQuery::updateRow');
        }

        $columns = array_keys($data);
        $setPart = implode(", ", array_map(fn($col) => "`$col` = :$col", $columns));

        $sql = "UPDATE `$table` SET $setPart WHERE `id` = :id";
        $stmt = self::$db->prepare($sql);

        // Bind values
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindValue(":id", $id);

        return $stmt->execute();
    }

    //     public static function getRow($table, $id)
    //     {
    //         $sql = "SELECT * FROM `$table` WHERE `id` = :id LIMIT 1";
    //         $stmt = DB::prepare($sql);
    //         $stmt->bindValue(":id", $id);
    //         $stmt->execute();
    //         return $stmt->fetch(PDO::FETCH_ASSOC);
    //     }

    //     // GET all rows (optionally with WHERE clause)
    //     public static function getAll($table, $where = [], $limit = null)
    //     {
    //         $sql = "SELECT * FROM `$table`";
    //         if (!empty($where)) {
    //             $conditions = array_map(fn($col) => "`$col` = :$col", array_keys($where));
    //             $sql .= " WHERE " . implode(" AND ", $conditions);
    //         }
    //         if ($limit !== null) {
    //             $sql .= " LIMIT $limit";
    //         }
    //         $stmt = DB::prepare($sql);
    //         foreach ($where as $key => $value) {
    //             $stmt->bindValue(":$key", $value);
    //         }
    //         $stmt->execute();
    //         return $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     }

    //     // CREATE a new row
    //     public static function insertRow($table, $data)
    //     {
    //         $columns = array_keys($data);
    //         $placeholders = array_map(fn($col) => ":$col", $columns);

    //         $sql = "INSERT INTO `$table` (`" . implode("`, `", $columns) . "`) VALUES (" . implode(", ", $placeholders) . ")";
    //         $stmt = DB::prepare($sql);

    //         foreach ($data as $key => $value) {
    //             $stmt->bindValue(":$key", $value);
    //         }

    //         if ($stmt->execute()) {
    //             return DB::lastInsertId(); // Or return true
    //         }

    //         return false;
    //     }

    //     // DELETE row
    //     public static function deleteRow($table, $id)
    //     {
    //         $sql = "DELETE FROM `$table` WHERE `id` = :id";
    //         $stmt = DB::prepare($sql);
    //         $stmt->bindValue(":id", $id);
    //         return $stmt->execute();
    //     }

    //     public static function getWithJoins($baseTable, $joins = [], $where = [], $select = "*", $limit = null) {
    //     // SELECT clause
    //     $sql = "SELECT $select FROM `$baseTable`";

    //     // JOIN clauses
    //     foreach ($joins as $join) {
    //         // $join = ['type' => 'LEFT', 'table' => 'other_table', 'on' => 'baseTable.col = other_table.col']
    //         $type = strtoupper($join['type']);
    //         $table = $join['table'];
    //         $on = $join['on'];
    //         $sql .= " $type JOIN `$table` ON $on";
    //     }

    //     // WHERE clause
    //     if (!empty($where)) {
    //         $conditions = array_map(fn($col) => "`$col` = :$col", array_keys($where));
    //         $sql .= " WHERE " . implode(" AND ", $conditions);
    //     }

    //     // LIMIT
    //     if ($limit !== null) {
    //         $sql .= " LIMIT $limit";
    //     }

    //     $stmt = DB::prepare($sql);

    //     // Bind WHERE values
    //     foreach ($where as $key => $value) {
    //         $stmt->bindValue(":$key", $value);
    //     }

    //     $stmt->execute();
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

}
