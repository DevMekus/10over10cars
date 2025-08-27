<?php

namespace configs;

use PDO;
use PDOException;
use App\Utils\Utility;

class Database
{
    private static $pdo;

    private static function initialize()
    {

        $dsn = "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};charset=utf8mb4";
        try {
            self::$pdo = new PDO($dsn, $_ENV['DB_USERNAME'],  $_ENV['DB_PASSWORD'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            Utility::log("DB Connection Failed: " . $e->getMessage(), 'error', 'DB::Constructor', ['host' => 'localhost'], $e);
        }
    }


    /** ---------------- CREATE ---------------- **/
    public static function insert($table, $data)
    {
        self::initialize();
        try {
            $fields = implode(", ", array_keys($data));
            $placeholders = ":" . implode(", :", array_keys($data));
            $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})";
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute($data);
            return self::$pdo->lastInsertId();
        } catch (PDOException $e) {
            Utility::log($e->getMessage(), 'error', 'DB::insert', ['host' => 'localhost'], $e);
        }
    }

    /** ---------------- READ ---------------- **/
    public static function find($table, $id, $idColumn = "id")
    {
        self::initialize();
        try {
            $sql = "SELECT * FROM {$table} WHERE {$idColumn} = :id LIMIT 1";
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            Utility::log($e->getMessage(), 'error', 'DB::find', ['host' => 'localhost'], $e);
        }
    }

    public static function all($table, $where = [], $options = [])
    {
        self::initialize();
        try {
            $sql = "SELECT * FROM {$table}";
            $params = [];

            if (!empty($where)) {
                $sql .= " WHERE " . self::buildWhere($where, $params);
            }

            if (!empty($options['order'])) {
                $sql .= " ORDER BY {$options['order']}";
            }

            if (!empty($options['limit'])) {
                $sql .= " LIMIT {$options['limit']}";
            }

            $stmt = self::$pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            Utility::log($e->getMessage(), 'error', 'DB::all', ['host' => 'localhost'], $e);
        }
    }

    /** ---------------- UPDATE ---------------- **/
    public static function update($table, $data, $where)
    {
        self::initialize();
        try {
            $set = implode(", ", array_map(fn($col) => "{$col} = :set_{$col}", array_keys($data)));
            $params = [];

            foreach ($data as $key => $value) {
                $params["set_" . $key] = $value;
            }
            $sql = "UPDATE {$table} SET {$set} WHERE " . self::buildWhere($where, $params);
            $stmt = self::$pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            Utility::log($e->getMessage(), 'error', 'DB::update', ['host' => 'localhost'], $e);
        }
    }


    /** ---------------- DELETE ---------------- **/
    public static function delete($table, $where)
    {
        self::initialize();
        try {
            $params = [];
            $sql = "DELETE FROM {$table} WHERE " . self::buildWhere($where, $params);
            $stmt = self::$pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            Utility::log($e->getMessage(), 'error', 'DB::delete', ['host' => 'localhost'], $e);
        }
    }

    /** ---------------- JOIN ---------------- **/
    public static function joinTables($baseTable, $joins = [], $columns = ["*"], $where = [], $options = [])
    {
        self::initialize();
        try {
            $cols = implode(", ", $columns);
            $sql = "SELECT {$cols} FROM {$baseTable}";
            $params = [];

            //Loop through the join definitions
            foreach ($joins as $join) {
                // Expected format: ["type" => "LEFT", "table" => "orders", "on" => "users.id = orders.user_id"]
                $type = strtoupper($join['type'] ?? 'INNER');
                $sql .= " {$type} JOIN {$join['table']} ON {$join['on']}";
            }

            if (!empty($where)) {
                $sql .= " WHERE " . self::buildWhere($where, $params);
            }

            if (!empty($options['order'])) {
                $sql .= " ORDER BY {$options['order']}";
            }

            if (!empty($options['limit'])) {
                $sql .= " LIMIT {$options['limit']}";
            }


            $stmt = self::$pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            Utility::log($e->getMessage(), 'error', 'DB::joinTables', ['host' => 'localhost'], $e);
        }
    }

    /** ---------------- PAGINATION ---------------- **/
    public static function pagination($table, $page = 1, $perPage = 10, $where = [])
    {
        self::initialize();
        try {
            $offset = ($page - 1) * $perPage;
            $sql = "SELECT * FROM {$table}";
            $params = [];
            if (!empty($where)) {
                $sql .= " WHERE " . self::buildWhere($where, $params);
            }

            $sql .= " LIMIT {$perPage} OFFSET {$offset}";
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            Utility::log($e->getMessage(), 'error', 'DB::pagination', ['host' => 'localhost'], $e);
        }
    }

    /** ---------------- TRANSACTIONS ---------------- **/
    public static function beginTransaction()
    {
        self::initialize();
        self::$pdo->beginTransaction();
    }

    public static function commit()
    {
        self::initialize();
        self::$pdo->commit();
    }

    public static function rollBack()
    {
        self::initialize();
        self::$pdo->rollBack();
    }

    /** ---------------- RAW QUERY ---------------- **/
    public static function query($sql, $params = [])
    {
        self::initialize();
        try {
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            Utility::log($e->getMessage(), 'error', 'DB::query', ['host' => 'localhost'], $e);
        }
    }

    /** ---------------- PRIVATE HELPERS ---------------- **/

    private static function buildWhere($where, &$params)
    {
        $clauses = [];

        foreach ($where as $key => $value) {
            if (strtoupper($key) === 'OR' && is_array($value)) {
                $orParts = [];
                foreach ($value as $col => $val) {
                    $paramKey = str_replace('.', '_', $col) . '_' . count($params);
                    $orParts[] = "{$col} = :w_{$paramKey}";
                    $params["w_" . $paramKey] = $val;
                }
                $clauses[] = '(' . implode(' OR ', $orParts) . ')';
            } else {
                $paramKey = str_replace('.', '_', $key);
                $clauses[] = "{$key} = :w_{$paramKey}";
                $params["w_" . $paramKey] = $value;
            }
        }

        return implode(' AND ', $clauses);
    }
}
