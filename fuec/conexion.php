<?php
declare(strict_types=1);

function env(string $key, string $default = ''): string
{
    $val = $_ENV[$key] ?? getenv($key) ?? $default;
    return is_string($val) ? $val : $default;
}

$host     = env('DB_HOST', 'localhost');
$database = env('DB_NAME', 'u910043597_fuec');
$username = env('DB_USER', '');
$password = env('DB_PASSWORD', '');

if ($host === '' || $database === '' || $username === '') {
    error_log("Variables de entorno de BD incompletas: host=" . var_export($host, true) . " database=" . var_export($database, true) . " user=" . var_export($username, true));
    http_response_code(500);
    exit('Error de configuración del servidor.');
}

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
