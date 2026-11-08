<?php
declare(strict_types=1);

require 'conexion.php';

$id = isset($_GET['idcontrato']) ? filter_input(INPUT_GET, 'idcontrato', FILTER_VALIDATE_INT) : false;

if ($id === false || $id === null || $id <= 0) {
    error_log("borrcont id invalido: " . var_export($_GET['idcontrato'] ?? 'no-provisto', true));
    header('Location: boedcont.php?error=id_invalido');
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM contratos WHERE idcontrato = ?");
    $resultado = $stmt->execute([$id]);

    if ($resultado) {
        header('Location: boedcont.php?eliminado=1');
    } else {
        header('Location: boedcont.php?error=no_eliminado');
    }
    exit;
} catch (PDOException $e) {
    error_log("borrcont error id=$id: " . $e->getMessage());
    header('Location: boedcont.php?error=bd_error');
    exit;
}
