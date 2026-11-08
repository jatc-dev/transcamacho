<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Database;

// Iniciar sesión segura
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Lax');
if (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'production') {
    ini_set('session.cookie_secure', '1');
}
session_start();

$config = require __DIR__ . '/../config/database.php';
date_default_timezone_set($config['app']['timezone'] ?? 'America/Bogota');

// Probar conexión a la base de datos
try {
    Database::connection();
} catch (\PDOException $e) {
    http_response_code(500);
    echo 'Error de conexión a la base de datos.';
    exit;
}

// Definir rutas básicas
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$routes = [
    'GET'  => [
        '/' => 'welcome',
        '/panel' => 'panel',
        '/contratos' => 'contratos_list',
        '/contratos/crear' => 'contratos_crear',
        '/fuec' => 'fuec_list',
        '/fuec/crear' => 'fuec_crear',
        '/login' => 'login',
        '/logout' => 'logout',
    ],
    'POST' => [
        '/login' => 'login_post',
        '/contratos' => 'contratos_store',
        '/fuec' => 'fuec_store',
    ],
];

$handler = $routes[$method][$uri] ?? null;

if ($handler === null) {
    http_response_code(404);
    echo 'Ruta no encontrada.';
    exit;
}

switch ($handler) {
    case 'welcome':
        echo '<h1>Transcamacho FUEC</h1><p>Sistema moderno de gestión de extractos de contrato.</p>';
        echo '<a href="/panel">Ir al panel</a>';
        break;

    case 'panel':
        if (empty($_SESSION['id_usuario'])) {
            header('Location: /login');
            exit;
        }
        echo '<h1>Panel de Control</h1>';
        echo '<p>Bienvenido, ' . htmlspecialchars($_SESSION['nombre_usuario'] ?? 'usuario') . '</p>';
        echo '<a href="/contratos">Contratos</a> | <a href="/fuec">FUEC</a> | <a href="/logout">Salir</a>';
        break;

    case 'contratos_list':
        if (empty($_SESSION['id_usuario'])) {
            header('Location: /login');
            exit;
        }
        $contratos = Database::connection()->query("SELECT * FROM contratos ORDER BY idcontrato DESC LIMIT 50")->fetchAll(PDO::FETCH_ASSOC);
        echo '<h1>Contratos</h1><table border="1"><tr><th>ID</th><th>Contratante</th><th>NIT</th><th>Acciones</th></tr>';
        foreach ($contratos as $c) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($c['idcontrato'] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($c['contratante'] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($c['nitcontratante'] ?? '') . '</td>';
            echo '<td><a href="/contratos/' . htmlspecialchars($c['idcontrato'] ?? '') . '/editar">Editar</a></td>';
            echo '</tr>';
        }
        echo '</table><p><a href="/contratos/crear">Nuevo contrato</a></p>';
        break;

    case 'contratos_crear':
        if (empty($_SESSION['id_usuario'])) {
            header('Location: /login');
            exit;
        }
        echo '<h1>Nuevo Contrato</h1>';
        echo '<form method="POST" action="/contratos">';
        echo '<input type="hidden" name="csrf_token" value="' . htmlspecialchars((new App\Controller())->csrfToken()) . '">';
        echo 'Contratante: <input name="contratante"><br>';
        echo 'NIT: <input name="nitcontratante"><br>';
        echo 'Objeto: <input name="objetocontrato"><br>';
        echo 'Responsable: <input name="respcont"><br>';
        echo 'Documento: <input name="docuresp"><br>';
        echo 'Teléfono: <input name="teleresp"><br>';
        echo 'Dirección: <input name="direresp"><br>';
        echo '<button type="submit">Guardar</button>';
        echo '</form>';
        break;

    case 'contratos_store':
        if (empty($_SESSION['id_usuario'])) {
            http_response_code(403);
            echo 'Acceso denegado.';
            exit;
        }
        $csrf = $_POST['csrf_token'] ?? '';
        if (!(new App\Controller())->validateCsrf($csrf)) {
            http_response_code(400);
            echo 'Token CSRF inválido.';
            exit;
        }
        $data = [
            'contratante' => $_POST['contratante'] ?? '',
            'nitcontratante' => $_POST['nitcontratante'] ?? '',
            'objetocontrato' => $_POST['objetocontrato'] ?? '',
            'respcont' => $_POST['respcont'] ?? '',
            'docuresp' => $_POST['docuresp'] ?? '',
            'teleresp' => $_POST['teleresp'] ?? '',
            'direresp' => $_POST['direresp'] ?? '',
        ];
        $id = Database::connection()->prepare(
            "INSERT INTO contratos (contratante, nitcontratante, objetocontrato, respcont, docuresp, teleresp, direresp)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $id->execute(array_values($data));
        header('Location: /contratos');
        exit;

    case 'login':
        echo '<h1>Iniciar Sesión</h1>';
        echo '<form method="POST" action="/login">';
        echo 'Usuario: <input name="usuario"><br>';
        echo 'Contraseña: <input type="password" name="password"><br>';
        echo '<button type="submit">Ingresar</button>';
        echo '</form>';
        break;

    case 'login_post':
        $usuario = $_POST['usuario'] ?? '';
        $password = $_POST['password'] ?? '';
        $stmt = Database::connection()->prepare(
            "SELECT id, nombre, tipo_usuario, password, activacion FROM usuarios WHERE usuario = ? LIMIT 1"
        );
        $stmt->execute([$usuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password']) && (int) $user['activacion'] === 1) {
            $_SESSION['id_usuario'] = (int) $user['id'];
            $_SESSION['nombre_usuario'] = $user['nombre'];
            $_SESSION['tipo_usuario'] = $user['tipo_usuario'];
            $_SESSION['tiempo'] = time();
            header('Location: /panel');
            exit;
        } else {
            echo 'Credenciales inválidas o usuario inactivo. <a href="/login">Reintentar</a>';
        }
        break;

    case 'logout':
        session_unset();
        session_destroy();
        header('Location: /login');
        exit;

    case 'fuec_list':
        if (empty($_SESSION['id_usuario'])) {
            header('Location: /login');
            exit;
        }
        echo '<h1>FUEC</h1><p>Listado de FUEC (en migración a nueva arquitectura).</p>';
        echo '<a href="/panel">Volver al panel</a>';
        break;

    case 'fuec_crear':
        if (empty($_SESSION['id_usuario'])) {
            header('Location: /login');
            exit;
        }
        echo '<h1>Crear FUEC</h1><p>Formulario en migración.</p>';
        echo '<a href="/panel">Volver al panel</a>';
        break;

    case 'fuec_store':
        http_response_code(501);
        echo 'Endpoint en migración.';
        break;
}
