<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Database;
use App\Controllers\AuthController;
use App\Controllers\ContratoController;
use App\Controllers\VehiculoController;
use App\Controllers\ConductorController;
use App\Controllers\UsuarioController;
use App\Controllers\FuecController;
use App\Controllers\FuecDownloadController;
use App\Controllers\PanelController;

// Iniciar sesión segura
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Lax');
if ((getenv('APP_ENV') ?? $_ENV['APP_ENV'] ?? '') === 'production') {
    ini_set('session.cookie_secure', '1');
}
session_start();

$config = require __DIR__ . '/../config/database.php';
date_default_timezone_set($config['app']['timezone'] ?? 'America/Bogota');

// Verificar conexión a la base de datos
try {
    Database::connection();
} catch (\PDOException $e) {
    http_response_code(500);
    echo 'Error de conexión a la base de datos.';
    exit;
}

// Enrutador simple
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// Quitar trailing slash excepto en raíz
if ($uri !== '/' && substr($uri, -1) === '/') {
    $uri = rtrim($uri, '/');
}

$routes = [
    'GET' => [
        '/' => [PanelController::class, 'index'],
        '/panel' => [PanelController::class, 'index'],
        '/login' => [AuthController::class, 'login'],
        '/logout' => [AuthController::class, 'logout'],

        // Contratos
        '/contratos' => [ContratoController::class, 'list'],
        '/contratos/crear' => [ContratoController::class, 'create'],

        // Vehículos
        '/vehiculos' => [VehiculoController::class, 'list'],
        '/vehiculos/crear' => [VehiculoController::class, 'create'],
        '/vehiculos/buscar' => [VehiculoController::class, 'search'],

        // Conductores
        '/conductores' => [ConductorController::class, 'list'],
        '/conductores/crear' => [ConductorController::class, 'create'],
        '/conductores/buscar' => [ConductorController::class, 'search'],

        // Usuarios (solo administradores)
        '/usuarios' => [UsuarioController::class, 'list'],
        '/usuarios/crear' => [UsuarioController::class, 'create'],

        // FUEC
        '/fuec' => [FuecController::class, 'list'],
        '/fuec/crear' => [FuecController::class, 'create'],
        '/fuec/buscar' => [FuecDownloadController::class, 'search'],
    ],
    'POST' => [
        '/login' => [AuthController::class, 'authenticate'],
        '/contratos' => [ContratoController::class, 'store'],
        '/vehiculos' => [VehiculoController::class, 'store'],
        '/conductores' => [ConductorController::class, 'store'],
        '/usuarios' => [UsuarioController::class, 'store'],
        '/fuec' => [FuecController::class, 'store'],
    ],
];

// Manejar rutas con parámetros (ID en la URL)
$handler = null;
$routeParams = [];

if (isset($routes[$method][$uri])) {
    $handler = $routes[$method][$uri];
} elseif (preg_match('#^/contratos/(\d+)/editar$#', $uri, $m) && $method === 'GET') {
    $handler = [ContratoController::class, 'edit'];
    $routeParams['id'] = (int) $m[1];
} elseif (preg_match('#^/contratos/(\d+)/actualizar$#', $uri, $m) && $method === 'POST') {
    $handler = [ContratoController::class, 'update'];
    $routeParams['id'] = (int) $m[1];
} elseif (preg_match('#^/contratos/(\d+)/eliminar$#', $uri, $m) && $method === 'POST') {
    $handler = [ContratoController::class, 'delete'];
    $routeParams['id'] = (int) $m[1];
} elseif (preg_match('#^/vehiculos/(\d+)/editar$#', $uri, $m) && $method === 'GET') {
    $handler = [VehiculoController::class, 'edit'];
    $routeParams['id'] = (int) $m[1];
} elseif (preg_match('#^/vehiculos/(\d+)/actualizar$#', $uri, $m) && $method === 'POST') {
    $handler = [VehiculoController::class, 'update'];
    $routeParams['id'] = (int) $m[1];
} elseif (preg_match('#^/vehiculos/(\d+)/eliminar$#', $uri, $m) && $method === 'POST') {
    $handler = [VehiculoController::class, 'delete'];
    $routeParams['id'] = (int) $m[1];
} elseif (preg_match('#^/conductores/(\d+)/editar$#', $uri, $m) && $method === 'GET') {
    $handler = [ConductorController::class, 'edit'];
    $routeParams['id'] = (int) $m[1];
} elseif (preg_match('#^/conductores/(\d+)/actualizar$#', $uri, $m) && $method === 'POST') {
    $handler = [ConductorController::class, 'update'];
    $routeParams['id'] = (int) $m[1];
} elseif (preg_match('#^/conductores/(\d+)/eliminar$#', $uri, $m) && $method === 'POST') {
    $handler = [ConductorController::class, 'delete'];
    $routeParams['id'] = (int) $m[1];
} elseif (preg_match('#^/usuarios/(\d+)/editar$#', $uri, $m) && $method === 'GET') {
    $handler = [UsuarioController::class, 'edit'];
    $routeParams['id'] = (int) $m[1];
} elseif (preg_match('#^/usuarios/(\d+)/actualizar$#', $uri, $m) && $method === 'POST') {
    $handler = [UsuarioController::class, 'update'];
    $routeParams['id'] = (int) $m[1];
} elseif (preg_match('#^/usuarios/(\d+)/eliminar$#', $uri, $m) && $method === 'POST') {
    $handler = [UsuarioController::class, 'delete'];
    $routeParams['id'] = (int) $m[1];
} elseif (preg_match('#^/fuec/([0-9]{4})$#', $uri, $m) && $method === 'GET') {
    $handler = [FuecDownloadController::class, 'view'];
    $routeParams['numfuec'] = $m[1];
}

if ($handler === null) {
    http_response_code(404);
    echo '<h1>404 - Ruta no encontrada</h1><p><a href="/">Volver al inicio</a></p>';
    exit;
}

// Instanciar controlador y ejecutar acción
$controllerClass = $handler[0];
$action = $handler[1];
$controller = new $controllerClass();

if (!method_exists($controller, $action)) {
    http_response_code(500);
    echo 'Acción no encontrada en el controlador.';
    exit;
}

if (!empty($routeParams)) {
    $controller->$action(...array_values($routeParams));
} else {
    $controller->$action();
}
