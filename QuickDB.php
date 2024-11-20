<?php

/**
 * QuickDB - Database Framework.
 *
 * The Lightweight PHP Database Framework to Accelerate Development.
 *
 * @version 1.0
 * @author Hassan ABBAS
 * @package QuickDB
 * @copyright Copyright 2024 QuickDB Project, Hassan ABBAS.
 * @license https://opensource.org/licenses/MIT
 */



class Database {
    private mysqli $connection;

    public function __construct(string $host, string $username, string $password, string $database) {
        $this->connection = new mysqli($host, $username, $password, $database);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function get(string $table, string $where): array {
        $query = "SELECT * FROM $table WHERE $where";
        $result = $this->connection->query($query);
        return $result->fetch_assoc() ?: [];
    }

    public function select(string $table, string $where = ""): array {
        $query = "SELECT * FROM $table WHERE $where";
        $result = $this->connection->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function update(string $table, array $data, string $where): bool {
        $set = "";
        $params = [];
        foreach ($data as $column => $value) {
            $set .= "$column = ?, ";
            $params[] = $value;
        }
        $set = rtrim($set, ", ");
        $query = "UPDATE $table SET $set WHERE $where";
        $stmt = $this->connection->prepare($query);
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $affected_rows = $stmt->affected_rows;
        $stmt->close();
        return $affected_rows > 0;
    }

    public function has(string $table, string $where): bool {
        $query = "SELECT 1 FROM $table WHERE $where LIMIT 1";
        $result = $this->connection->query($query);
        return $result->num_rows > 0;
    }

    public function insert(string $table, array $data): int {
        $columns = implode(", ", array_keys($data));
        $values = implode(", ", array_fill(0, count($data), "?"));
        $query = "INSERT INTO $table ($columns) VALUES ($values)";
        $stmt = $this->connection->prepare($query);
        $types = str_repeat('s', count($data));
        $dataValues = array_values($data);
        $stmt->bind_param($types, ...$dataValues);
        $stmt->execute();
        $insert_id = $stmt->insert_id;
        $stmt->close();
        return $insert_id;
    }

    public function delete(string $table, string $where): bool {
        $query = "DELETE FROM $table WHERE $where";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $affected_rows = $stmt->affected_rows;
        $stmt->close();
        return $affected_rows > 0;
    }

    public function query(string $sql): array|bool {
        $result = $this->connection->query($sql);
        if ($result === TRUE) {
            return true;
        } elseif ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    public function __destruct() {
        $this->connection->close();
    }
}
?>
