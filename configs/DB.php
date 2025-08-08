<?php

namespace configs;

use PDO;
use PDOException;
use App\Utils\Utility;

class DB
{
    private $pdo;

    public function __construct()
    {

        $dsn = "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};charset=utf8mb4";
        try {
            $this->pdo = new PDO($dsn, $_ENV['DB_USERNAME'],  $_ENV['DB_PASSWORD'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            Utility::log("DB Connection Failed: " . $e->getMessage(), 'error', 'DB::Constructor', ['host' => 'localhost'], $e);
        }
    }


    /** ---------------- CREATE ---------------- **/
    public function insert($table, $data)
    {
        try {
            $fields = implode(", ", array_keys($data));
            $placeholders = ":" . implode(", :", array_keys($data));
            $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($data);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            Utility::log($e->getMessage(), 'error', 'DB::insert', ['host' => 'localhost'], $e);
        }
    }

    /** ---------------- READ ---------------- **/
    public function find($table, $id, $idColumn = "id")
    {
        try {
            $sql = "SELECT * FROM {$table} WHERE {$idColumn} = :id LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            Utility::log($e->getMessage(), 'error', 'DB::find', ['host' => 'localhost'], $e);
        }
    }

    public function all($table, $where = [], $options = [])
    {
        try {
            $sql = "SELECT * FROM {$table}";
            $params = [];

            if (!empty($where)) {
                $sql .= " WHERE " . $this->buildWhere($where, $params);
            }

            if (!empty($options['order'])) {
                $sql .= " ORDER BY {$options['order']}";
            }

            if (!empty($options['limit'])) {
                $sql .= " LIMIT {$options['limit']}";
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            Utility::log($e->getMessage(), 'error', 'DB::all', ['host' => 'localhost'], $e);
        }
    }

    /** ---------------- UPDATE ---------------- **/
    public function update($table, $data, $where)
    {
        try {
            $set = implode(", ", array_map(fn($col) => "{$col} = :set_{$col}", array_keys($data)));
            $params = [];

            foreach ($data as $key => $value) {
                $params["set_" . $key] = $value;
            }
            $sql = "UPDATE {$table} SET {$set} WHERE " . $this->buildWhere($where, $params);
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            Utility::log($e->getMessage(), 'error', 'DB::update', ['host' => 'localhost'], $e);
        }
    }


    /** ---------------- DELETE ---------------- **/
    public function delete($table, $where)
    {
        try {
            $params = [];
            $sql = "DELETE FROM {$table} WHERE " . $this->buildWhere($where, $params);
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            Utility::log($e->getMessage(), 'error', 'DB::delete', ['host' => 'localhost'], $e);
        }
    }

    /** ---------------- JOIN ---------------- **/
    public function joinTables($baseTable, $joins = [], $columns = ["*"], $where = [], $options = [])
    {
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
                $sql .= " WHERE " . $this->buildWhere($where, $params);
            }

            if (!empty($options['order'])) {
                $sql .= " ORDER BY {$options['order']}";
            }

            if (!empty($options['limit'])) {
                $sql .= " LIMIT {$options['limit']}";
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            Utility::log($e->getMessage(), 'error', 'DB::joinTables', ['host' => 'localhost'], $e);
        }
    }

    /** ---------------- PAGINATION ---------------- **/
    public function pagination($table, $page = 1, $perPage = 10, $where = [])
    {
        try {
            $offset = ($page - 1) * $perPage;
            $sql = "SELECT * FROM {$table}";
            $params = [];
            if (!empty($where)) {
                $sql .= " WHERE " . $this->buildWhere($where, $params);
            }

            $sql .= " LIMIT {$perPage} OFFSET {$offset}";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            Utility::log($e->getMessage(), 'error', 'DB::pagination', ['host' => 'localhost'], $e);
        }
    }

    /** ---------------- TRANSACTIONS ---------------- **/
    public function beginTransaction()
    {
        $this->pdo->beginTransaction();
    }

    public function commit()
    {
        $this->pdo->commit();
    }

    public function rollBack()
    {
        $this->pdo->rollBack();
    }

    /** ---------------- RAW QUERY ---------------- **/
    public function query($sql, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            Utility::log($e->getMessage(), 'error', 'DB::query', ['host' => 'localhost'], $e);
        }
    }

    /** ---------------- PRIVATE HELPERS ---------------- **/


    private function buildWhere($where, &$params)
    {
        try {
            $clauses = [];

            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    // For IN queries
                    $placeholders = implode(", ", array_fill(0, count($value), "?"));
                    $clauses[] = "{$key} IN ({$placeholders})";
                    $params = array_merge($params, $value);
                } else {
                    $clauses[] = "{$key} = :w_{$key}";
                    $params["w_" . $key] = $value;
                }
            }
            return implode(" AND ", $clauses);
        } catch (PDOException $e) {
            Utility::log($e->getMessage(), 'error', 'DB::buildWhere', ['host' => 'localhost'], $e);
        }
    }

    /** ---------------- USAGE ---------------- **/

    private function libraryUsage()
    {

        /**
         *  Connect
         * $db = new DB();
         * 
         *  Create
         *   $userId = $db->insert("users", [
                "name" => "John Doe",
                "email" => "john@example.com"
                ]);
         * 
         *  Find by ID
            $user = $db->find("users", $userId);
         * 
         *  Get all with filter & limit
         *   $users = $db->all("users", ["status" => "active"], 
         *   ["limit" => 5, "order" => "id    DESC"]);

         *Update
         * $db->update("users", ["email" => "new@example.com"], ["id" => $userId]);

         * Delete
         * $db->delete("users", ["id" => $userId]);

         * Join
         * Example: Join 3 tables
         * $results = $db->joinTables(
         *    "users",
            [
                ["type" => "INNER", "table" => "orders", "on" => "users.id = orders.user_id"],
                ["type" => "LEFT",  "table" => "payments", "on" => "orders.id = payments.order_id"]
            ],
            ["users.name", "orders.total", "payments.amount"],
            ["users.status" => "active"],
            ["order" => "orders.id DESC", "limit" => 10]
        );




        Pagination
        $page1 = $db->paginate("users", 1, 10);

        Transactions
        try {
            $db->beginTransaction();
            $db->update("accounts", ["balance" => 500], ["id" => 1]);
            $db->update("accounts", ["balance" => 300], ["id" => 2]);
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            echo "Transaction failed: " . $e->getMessage();
        }

        Raw query
        $results = $db->query("SELECT COUNT(*) AS total FROM users WHERE status = ?", ["active"]);
         * 
         */
    }
}
