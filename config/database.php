<?php
declare(strict_types=1);

return [
    'app' => [
        'name' => 'Transcamacho FUEC',
        'env' => $_ENV['APP_ENV'] ?? getenv('APP_ENV') ?? 'production',
        'debug' => filter_var($_ENV['APP_DEBUG'] ?? getenv('APP_DEBUG') ?? '0', FILTER_VALIDATE_BOOLEAN),
        'url' => $_ENV['APP_URL'] ?? getenv('APP_URL') ?? 'https://transcamacho.onrender.com',
        'timezone' => 'America/Bogota',
    ],
    'database' => [
        'driver' => 'pgsql',
        'host' => $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?? '',
        'port' => $_ENV['DB_PORT'] ?? getenv('DB_PORT') ?? '5432',
        'database' => $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?? '',
        'username' => $_ENV['DB_USER'] ?? getenv('DB_USER') ?? '',
        'password' => $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?? '',
        'url' => $_ENV['DATABASE_URL'] ?? getenv('DATABASE_URL') ?? '',
        'charset' => 'utf8',
    ],
    'session' => [
        'lifetime' => 3600,
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Lax',
    ],
];
