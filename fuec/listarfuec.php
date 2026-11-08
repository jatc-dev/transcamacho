<?php
declare(strict_types=1);

include 'conexion.php';
include 'funciones.php';
include 'header.php';

////////////////// VARIABLES DE CONSULTA////////////////////////////////////

$contratante = isset($_POST['contratante']) ? trim($_POST['contratante']) : '';
$numfuec     = isset($_POST['numfuec'])     ? trim($_POST['numfuec'])     : '';
$limit       = isset($_POST['registros'])   ? trim($_POST['registros'])   : '';

// Validar límite permitido para evitar inyección por el parámetro LIMIT
$allowedLimits = ['limit 10', 'limit 20', 'limit 100'];
$limitSql = in_array($limit, $allowedLimits, true) ? $limit : 'limit 100';

//////////////////// BOTON BUSCAR //////////////////////////////////////

$where = '';
$params = [];

if (isset($_POST['buscar'])) {
    if (!empty($contratante) && empty($numfuec)) {
        $where = 'WHERE contratante LIKE ?';
        $params[] = '%' . $contratante . '%';
    } elseif (empty($contratante) && !empty($numfuec)) {
        $where = 'WHERE numfuec = ?';
        $params[] = $numfuec;
    } elseif (!empty($contratante) && !empty($numfuec)) {
        $where = 'WHERE contratante LIKE ? AND numfuec = ?';
        $params[] = '%' . $contratante . '%';
        $params[] = $numfuec;
    }
}

/////////////////////// CONSULTA A LA BASE DE DATOS ////////////////////////

$mensaje = '';
$resConsulta = null;

$sqlCount = "SELECT * FROM fuec $where ORDER BY numfuec DESC $limitSql";

try {
    $stmt = $pdo->prepare($sqlCount);
    $stmt->execute($params);
    $resConsulta = $stmt;
} catch (PDOException $e) {
    error_log("Error en consulta FUEC: " . $e->getMessage());
    $resConsulta = null;
}

if ($resConsulta !== null && $resConsulta->rowCount() === 0) {
    $mensaje = "<h4>No hay registros que coincidan con su criterio de búsqueda.</h4>";
}

// Consulta para llenar el select de números FUEC (sin filtro)
$fuecOptions = [];
try {
    $stmtOptions = $pdo->query("SELECT DISTINCT numfuec FROM fuec ORDER BY numfuec DESC");
    if ($stmtOptions !== false) {
        $fuecOptions = $stmtOptions->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    error_log("Error al cargar opciones FUEC: " . $e->getMessage());
    $fuecOptions = [];
}

if (isset($_POST['numfuec'])) {
    echo htmlspecialchars($_POST['numfuec'], ENT_QUOTES, 'UTF-8');
    exit;
}

?>

<html>

<head>

    <!-- datetimepicker -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/locale/es.js"></script>

    <script src="https://kit.fontawesome.com/7a00a4bd48.js" crossorigin="anonymous"></script>

    <!-- JS y CSS del UI de autocompletar -->
    <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />

    <script type="text/javascript" src="js/scripts.js"></script>

</head>
<body>
<div class="container-fluid" style="margin-top:60px">

    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title">Listar FUEC</div>
        </div>

        <div class="panel-body">

            <form class="form-inline" role="form" method="post">
                <div style="display: flex; align-items:center; text-align: center;">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <label>Contratante</label><br>
                        <input autofocus class="form-control input-medium ui-autocomplete-input UpperCase"
                               value="<?php echo htmlspecialchars($contratante, ENT_QUOTES, 'UTF-8'); ?>"
                               autocomplete="off" id="contratante" name="contratante" type="text"
                               placeholder="Escribe al menos 3 letras">
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                        <label>Número de FUEC</label><br>
                        <select name="numfuec" class="form-control">
                            <option value="" disabled selected>Seleccione </option>
                            <?php
                            if (is_array($fuecOptions) && count($fuecOptions) > 0) {
                                foreach ($fuecOptions as $datos) {
                                    echo '<option value="' . htmlspecialchars($datos['numfuec'], ENT_QUOTES, 'UTF-8') . '">' .
                                        htmlspecialchars($datos['numfuec'], ENT_QUOTES, 'UTF-8') . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                        <label>No. de Registros</label><br>
                        <select name="registros" class="form-control">
                            <option value="limit 10" <?php echo $limit === 'limit 10' ? 'selected' : ''; ?>>10</option>
                            <option value="limit 20" <?php echo $limit === 'limit 20' ? 'selected' : ''; ?>>20</option>
                            <option value="limit 100" <?php echo $limit === 'limit 100' ? 'selected' : ''; ?>>100</option>
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                        <label></label><br>
                        <button name="buscar" type="submit" class="btn btn-success"><span style=""
                                                                                         class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;Buscar</button>
                    </div>
                </div>

            </form>
        </div>

        <hr>
        <div class="panel-body">
            <div style="overflow-x:auto;">
                <table class="table table-bordered table-xs" id="table" name="tabla" style="font-size: 70%;">
                    <thead>

                    <tr style="text-align: center">
                        <th style="text-align: center; background:#337ab7;" rowspan="2"><font
                                color="#FFFFFF">No FUEC</th>
                        <th style="text-align: center; background:#337ab7;" rowspan="2"><font
                                color="#FFFFFF">Fecha Generación</th>
                        <th style="text-align: center; background:#337ab7;" colspan="4"><font
                                color="#FFFFFF">Contratante</th>
                        <th style="text-align: center; background:#337ab7;" colspan="2"><font
                                color="#FFFFFF">Ruta</th>
                        <th style="text-align: center; background:#337ab7;" colspan="2"><font
                                color="#FFFFFF">Vigencia</th>
                        <th style="text-align: center; background:#337ab7;" colspan="4"><font
                                color="#FFFFFF">Vehículo</th>
                        <th style="text-align: center; background:#337ab7;" colspan="3"><font
                                color="#FFFFFF">Conductores</th>
                        <th style="text-align: center; background:#337ab7;" rowspan="2"><font
                                color="#FFFFFF">Usuario</th>

                    </tr>

                    <tr style="text-align: center">
                        <th style="text-align: center; background:#337ab7;"><font
                                color="#FFFFFF">Nombres o Razón social</th>
                        <th style="text-align: center; background:#337ab7;"><font
                                color="#FFFFFF">Documento</th>
                        <th style="text-align: center; background:#337ab7;"><font
                                color="#FFFFFF">No Contrato</th>
                        <th style="text-align: center; background:#337ab7;"><font
                                color="#FFFFFF">Responsable</th>

                        <th style="text-align: center; background:#337ab7;"><font
                                color="#FFFFFF">Origen</th>
                        <th style="text-align: center; background:#337ab7;"><font
                                color="#FFFFFF">Destino</th>

                        <th style="text-align: center; background:#337ab7;"><font
                                color="#FFFFFF">Fecha Inicio</th>
                        <th style="text-align: center; background:#337ab7;"><font
                                color="#FFFFFF">Fecha Fin</th>

                        <th style="text-align: center; background:#337ab7;"><font
                                color="#FFFFFF">Placas</th>
                        <th style="text-align: center; background:#337ab7;"><font
                                color="#FFFFFF">Modelo</th>
                        <th style="text-align: center; background:#337ab7;"><font
                                color="#FFFFFF">Marca</th>
                        <th style="text-align: center; background:#337ab7;"><font
                                color="#FFFFFF">Clase</th>

                        <th style="text-align: center; background:#337ab7;"><font
                                color="#FFFFFF">1</th>
                        <th style="text-align: center; background:#337ab7;"><font
                                color="#FFFFFF">2</th>
                        <th style="text-align: center; background:#337ab7;"><font
                                color="#FFFFFF">3</th>
                    </tr>

                    </thead>
                    <tbody>
                    <?php

                    if ($resConsulta !== null) {
                        while ($registroConsulta = $resConsulta->fetch(PDO::FETCH_ASSOC)) {
                            if ($registroConsulta === false) {
                                break;
                            }
                            echo '
                                <tr style="background:#fff;">
                                    <td>' . htmlspecialchars($registroConsulta['numfuec'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                    <td>' . htmlspecialchars($registroConsulta['timestamp'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                    <td>' . htmlspecialchars($registroConsulta['contratante'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                    <td>' . htmlspecialchars($registroConsulta['nitcontratante'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                    <td>' . htmlspecialchars($registroConsulta['idcontrato'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                    <td>' . htmlspecialchars($registroConsulta['respcont'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>

                                    <td>' . htmlspecialchars($registroConsulta['origen'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                    <td>' . htmlspecialchars($registroConsulta['destino'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>

                                    <td>' . htmlspecialchars($registroConsulta['fechainicial'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                    <td>' . htmlspecialchars($registroConsulta['fechafinal'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>

                                    <td>' . htmlspecialchars($registroConsulta['placa'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                    <td>' . htmlspecialchars($registroConsulta['modelo'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                    <td>' . htmlspecialchars($registroConsulta['marca'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                    <td>' . htmlspecialchars($registroConsulta['clase'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>

                                    <td>' . htmlspecialchars($registroConsulta['nombcond1'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                    <td>' . htmlspecialchars($registroConsulta['nombcond2'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                    <td>' . htmlspecialchars($registroConsulta['nombcond3'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>

                                    <td>' . htmlspecialchars($registroConsulta['usercrea'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
                                </tr>';
                        }
                    }

                    ?>

                    </tbody>
                </table>

                <?php
                if (!empty($mensaje)) {
                    echo $mensaje;
                }
                ?>


            </div>
            </div>
    </div>

</div>

</div>





<script type="text/javascript">
    $(document).ready(function () {
        $(".UpperCase").on("keypress", function () {
            var $input = $(this);
            setTimeout(function () {
                $input.val($input.val().toUpperCase());
            }, 50);
        })
    })
</script>

</body>
</html>
