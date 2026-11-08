<?php
declare(strict_types=1);

namespace App;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    public static function connection(): PDO
    {
        if (self::$instance === null) {
            $config = require __DIR__ . '/../config/database.php';

            $dsn = '';
            $database = '';
            $username = $config['database']['username'] ?? '';
            $password = $config['database']['password'] ?? '';

            $databaseUrl = $config['database']['url'] ?? '';
            if ($databaseUrl !== '') {
                $dsn = str_replace('postgresql://', 'pgsql:', $databaseUrl);
                $dsn = str_replace('postgres://', 'pgsql:', $dsn);
                $parsed = parse_url($databaseUrl);
                $username = $parsed['user'] ?? $username;
                $password = $parsed['pass'] ?? $password;
            } else {
                $host = $config['database']['host'] ?? 'localhost';
                $port = $config['database']['port'] ?? '5432';
                $database = $config['database']['database'] ?? '';
                $dsn = "pgsql:host={$host};port={$port};dbname={$database}";
            }

            if ($dsn === '' || $database === '' || $username === '') {
                throw new PDOException('Configuración de base de datos incompleta.');
            }

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            self::$instance = new PDO($dsn, $username, $password, $options);
        }

        return self::$instance;
    }

    public static function disconnect(): void
    {
        self::$instance = null;
    }

    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}
}
