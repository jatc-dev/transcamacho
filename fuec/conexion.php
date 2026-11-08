<?php
declare(strict_types=1);

$host     = $_ENV['DB_HOST']     ?? getenv('DB_HOST')     ?? 'localhost';
$database = $_ENV['DB_NAME']     ?? getenv('DB_NAME')     ?? 'u910043597_fuec';
$username = $_ENV['DB_USER']     ?? getenv('DB_USER')     ?? '';
$password = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?? '';

$dsn = "mysql:host={$host};dbname={$database};charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    error_log("Conexión a BD fallida");
    http_response_code(500);
    exit('Error de conexión a la base de datos.');
}
