<?php
declare(strict_types=1);

function db_query(PDO $pdo, string $sql, array $params = []): ?PDOStatement
{
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        error_log("Error en consulta SQL: " . $e->getMessage());
        return null;
    }
}

function db_insert(PDO $pdo, string $table, array $data): ?int
{
    $fields = implode(', ', array_keys($data));
    $placeholders = implode(', ', array_fill(0, count($data), '?'));
    $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array_values($data));
        return (int) $pdo->lastInsertId();
    } catch (PDOException $e) {
        error_log("Error en inserción: " . $e->getMessage());
        return null;
    }
}

function db_delete(PDO $pdo, string $table, string $idColumn, int $id): bool
{
    $sql = "DELETE FROM {$table} WHERE {$idColumn} = ?";

    try {
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$id]);
    } catch (PDOException $e) {
        error_log("Error en borrado: " . $e->getMessage());
        return false;
    }
}

function db_edit(PDO $pdo, string $table, array $data, string $idColumn, int $id): bool
{
    $set = implode(', ', array_map(fn($col) => "{$col} = ?", array_keys($data)));
    $sql = "UPDATE {$table} SET {$set} WHERE {$idColumn} = ?";
    $params = array_merge(array_values($data), [$id]);

    try {
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($params);
    } catch (PDOException $e) {
        error_log("Error en actualización: " . $e->getMessage());
        return false;
    }
}

function db_select_id(PDO $pdo, string $table, string $fieldName, $fieldValue): ?array
{
    $sql = "SELECT * FROM {$table} WHERE {$fieldName} = ?";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$fieldValue]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error en consulta por ID: " . $e->getMessage());
        return null;
    }
}
