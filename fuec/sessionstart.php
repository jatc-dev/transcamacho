<?php
declare(strict_types=1);

include 'conexion.php';

// Configuración segura de cookies de sesión
$sessionOptions = [
    'cookie_lifetime' => 0,               // Sesión expira al cerrar el navegador
    'cookie_path'     => '/',
    'cookie_domain'   => '',
    'cookie_secure'   => true,            // Solo sobre HTTPS
    'cookie_httponly' => true,            // No accesible desde JavaScript
    'cookie_samesite' => 'Lax',
    'use_strict_mode' => true,            // Rechazar IDs de sesión no inicializados por el servidor
];
session_start($sessionOptions);

// Regenerar ID de sesión periódicamente para fijación de sesión
if (!isset($_SESSION['regenerated'])) {
    $_SESSION['regenerated'] = true;
    session_regenerate_id(true);
}

// Validar que exista sesión de usuario activa
if (!isset($_SESSION['id_usuario'])) {
    header('Location: index.php');
    exit;
}

$idUsuario = (int) $_SESSION['id_usuario'];

// Consultar datos del usuario con sentencia preparada
$row = null;
try {
    $stmt = $pdo->prepare("SELECT id, nombre, tipo_usuario FROM usuarios WHERE id = ? LIMIT 1");
    $stmt->execute([$idUsuario]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error al cargar usuario de sesión id=$idUsuario: " . $e->getMessage());
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit;
}

if ($row === false || $row === null) {
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit;
}

$idUsuario = (int) $row['id'];
$nombreUsuario = htmlspecialchars($row['nombre'] ?? '', ENT_QUOTES, 'UTF-8');
$tipoUsuario = htmlspecialchars($row['tipo_usuario'] ?? '', ENT_QUOTES, 'UTF-8');

// Control de inactividad (3000 segundos = 50 minutos)
$inactivo = 3000;
if (isset($_SESSION['tiempo'])) {
    $vidaSession = time() - (int) $_SESSION['tiempo'];
    if ($vidaSession > $inactivo) {
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
$_SESSION['tiempo'] = time();

$errors = [];
