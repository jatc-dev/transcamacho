<?php
declare(strict_types=1);

namespace App;

use PDO;

abstract class Model
{
    protected string $table = '';
    protected string $primaryKey = 'id';

    protected function db(): PDO
    {
        return Database::connection();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db()->prepare(
            "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ? LIMIT 1"
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row === false ? null : $row;
    }

    public function all(int $limit = 100, int $offset = 0): array
    {
        $stmt = $this->db()->prepare(
            "SELECT * FROM {$this->table} ORDER BY {$this->primaryKey} DESC LIMIT ? OFFSET ?"
        );
        $stmt->execute([$limit, $offset]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): ?int
    {
        if (empty($data)) {
            return null;
        }
        $fields = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO {$this->table} ({$fields}) VALUES ({$placeholders})";
        $stmt = $this->db()->prepare($sql);
        $stmt->execute(array_values($data));
        return (int) $this->db()->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        if (empty($data)) {
            return false;
        }
        $set = implode(', ', array_map(fn($col) => "{$col} = ?", array_keys($data)));
        $sql = "UPDATE {$this->table} SET {$set} WHERE {$this->primaryKey} = ?";
        $params = array_merge(array_values($data), [$id]);
        $stmt = $this->db()->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db()->prepare(
            "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?"
        );
        return $stmt->execute([$id]);
    }

    public function query(string $sql, array $params = []): array
    {
        $stmt = $this->db()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function execute(string $sql, array $params = []): bool
    {
        $stmt = $this->db()->prepare($sql);
        return $stmt->execute($params);
    }
}
