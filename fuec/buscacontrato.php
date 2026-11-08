<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

include 'conexion.php';

$return_arr = [];

if (isset($_GET['term']) && $_GET['term'] !== '') {
    $term = '%' . $_GET['term'] . '%';

    try {
        $stmt = $pdo->prepare("SELECT * FROM contratos WHERE contratante LIKE ? LIMIT 5");
        $stmt->execute([$term]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $return_arr[] = [
                'value'           => $row['contratante'] ?? '',
                'buscacontrato'   => $row['contratante'] ?? '',
                'idcontrato'      => $row['idcontrato'] ?? '',
                'contratante'     => $row['contratante'] ?? '',
                'nitcontratante'  => $row['nitcontratante'] ?? '',
                'objetocontrato'  => $row['objetocontrato'] ?? '',
                'respcont'        => $row['respcont'] ?? '',
                'docuresp'        => $row['docuresp'] ?? '',
                'teleresp'        => $row['teleresp'] ?? '',
                'direresp'        => $row['direresp'] ?? '',
            ];
        }
    } catch (PDOException $e) {
        error_log("Error en buscacontrato: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Error al consultar contratos']);
        exit;
    }
}

echo json_encode($return_arr);
