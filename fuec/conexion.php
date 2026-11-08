<?php
declare(strict_types=1);

function env(string $key, string $default = ''): string
{
    $val = $_ENV[$key] ?? getenv($key) ?? $default;
    return is_string($val) ? $val : $default;
}

// Soporte moderno: DATABASE_URL (formato postgres://user:pass@host:port/dbname)
// Si no existe, se construye desde componentes individuales.
$databaseUrl = env('DATABASE_URL');

if ($databaseUrl !== '') {
    // PDO con pdo_pgsql requiere el prefijo 'pgsql:' (no 'postgresql://')
    $dsn = str_replace('postgresql://', 'pgsql:', $databaseUrl, $count);
    if ($count === 0) {
        $dsn = str_replace('postgres://', 'pgsql:', $databaseUrl);
    }
    // Extraer usuario y contraseña de la URL si están presentes
    $parsed = parse_url($databaseUrl);
    $username = $parsed['user'] ?? '';
    $password = $parsed['pass'] ?? '';
} else {
    $host     = env('DB_HOST', 'localhost');
    $database = env('DB_NAME', 'u910043597_fuec');
    $username = env('DB_USER', '');
    $password = env('DB_PASSWORD', '');

    if ($host === '' || $database === '' || $username === '') {
        error_log("Variables de entorno de BD incompletas: host=" . var_export($host, true) . " database=" . var_export($database, true) . " user=" . var_export($username, true));
        http_response_code(500);
        exit('Error de configuración del servidor.');
    }

    $dsn = "pgsql:host={$host};dbname={$database}";
}

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    error_log("Conexión a BD fallida");
    http_response_code(500);
    exit('Error de conexión a la base de datos.');
}
