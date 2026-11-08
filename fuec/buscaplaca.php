<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

include 'conexion.php';

$return_arr = [];

if (isset($_GET['term']) && $_GET['term'] !== '') {
    $term = '%' . $_GET['term'] . '%';

    try {
        $stmt = $pdo->prepare("SELECT * FROM vehiculos WHERE placa LIKE ? LIMIT 5");
        $stmt->execute([$term]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $return_arr[] = [
                'value'       => $row['placa'] ?? '',
                'buscaplaca'  => $row['placa'] ?? '',
                'idvehi'      => $row['idvehi'] ?? '',
                'placa'       => $row['placa'] ?? '',
                'modelo'      => $row['modelo'] ?? '',
                'marca'       => $row['marca'] ?? '',
                'clase'       => $row['clase'] ?? '',
                'numinterno'  => $row['numinterno'] ?? '',
                'numtarjeta'  => $row['numtarjeta'] ?? '',
                'emprvehi'    => $row['emprvehi'] ?? '',
            ];
        }
    } catch (PDOException $e) {
        error_log("Error en buscaplaca: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Error al consultar vehículos']);
        exit;
    }
}

echo json_encode($return_arr);
