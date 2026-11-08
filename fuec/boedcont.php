<?php
declare(strict_types=1);

include 'conexion.php';
include 'funciones.php';
include 'header.php';

$errors = [];
$contratante = '';
$nitcontratante = '';
$objetocontrato = '';
$respcont = '';
$docuresp = '';
$teleresp = '';
$direresp = '';

// Sanitización de entrada POST
function postString(string $key, string $default = ''): string
{
    return isset($_POST[$key]) ? trim((string) $_POST[$key]) : $default;
}

////////////////////// CREAR CONTRATO //////////////////////////////////////

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $contratante = postString('contratante');
    $nitcontratante = postString('nitcontratante');
    $objetocontrato = postString('objetocontrato');
    $respcont = postString('respcont');
    $docuresp = postString('docuresp');
    $teleresp = postString('teleresp');
    $direresp = postString('direresp');

    // Validaciones básicas
    if ($contratante === '') {
        $errors[] = 'El contratante es obligatorio';
    }
    if ($nitcontratante === '' || !preg_match('/^[0-9]{7,10}$/', $nitcontratante)) {
        $errors[] = 'El NIT/CC debe contener entre 7 y 10 dígitos';
    }
    if ($objetocontrato === '') {
        $errors[] = 'El objeto del contrato es obligatorio';
    }
    if ($respcont === '') {
        $errors[] = 'El responsable es obligatorio';
    }
    if ($docuresp === '' || !preg_match('/^[0-9]{6,10}$/', $docuresp)) {
        $errors[] = 'El documento del responsable debe contener entre 6 y 10 dígitos';
    }
    if ($teleresp === '' || !preg_match('/^[0-9]{7,10}$/', $teleresp)) {
        $errors[] = 'El teléfono debe contener entre 7 y 10 dígitos';
    }
    if ($direresp === '') {
        $errors[] = 'La dirección es obligatoria';
    }

    if (count($errors) === 0) {
        try {
            $stmt = $pdo->prepare(
                "INSERT INTO contratos (contratante, nitcontratante, objetocontrato, respcont, docuresp, teleresp, direresp)
                 VALUES (?, ?, ?, ?, ?, ?, ?)"
            );
            $stmt->execute([
                $contratante,
                $nitcontratante,
                $objetocontrato,
                $respcont,
                $docuresp,
                $teleresp,
                $direresp,
            ]);
            header('Location: boedcont.php?creado=1');
            exit;
        } catch (PDOException $e) {
            error_log("Error al insertar contrato: " . $e->getMessage());
            $errors[] = 'Error al guardar el contrato. Inténtelo de nuevo más tarde.';
        }
    }
}

////////////////////// LISTAR CONTRATOS //////////////////////////////////////

$contratos = [];
try {
    $stmt = $pdo->query("SELECT * FROM contratos ORDER BY idcontrato DESC");
    if ($stmt !== false) {
        $contratos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    error_log("Error al listar contratos: " . $e->getMessage());
    $contratos = [];
}

$creado = isset($_GET['creado']) && $_GET['creado'] === '1';

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Gestión de Contratos</title>

<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/locale/es.js"></script>

<script type="text/javascript">
function Confirmar() {
    return confirm("Estas seguro que quieres eliminar el registro?");
}
</script>

</head>

<body>
<div class="container-fluid" style="margin-top:60px">

<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">Agregar/Editar contrato</div>
    </div>

    <div class="panel-body">

        <?php if ($creado): ?>
            <div class="alert alert-success">Contrato creado correctamente.</div>
        <?php endif; ?>

        <?php if (count($errors) > 0): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="form-group row panel-body">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <label>Nombres y Apellidos o Razón social del contratante:</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                    <input type="text" class="form-control UpperCase" name="contratante"
                           placeholder="- - -" value="<?php echo htmlspecialchars($contratante, ENT_QUOTES, 'UTF-8'); ?>" required><br>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <label>NIT/CC:</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                    <input type="text" class="form-control" name="nitcontratante"
                           placeholder="Nit sin digito de verificación"
                           value="<?php echo htmlspecialchars($nitcontratante, ENT_QUOTES, 'UTF-8'); ?>"
                           pattern="[0-9]{7,10}"
                           oninvalid="setCustomValidity('Este campo solo acepta números entre 7 y 10 dígitos')"
                           onchange="try{setCustomValidity('')}catch(e){}" required><br>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <label>Objeto del contrato:</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                    <select class="form-control" name="objetocontrato"
                            style="background-color: white; height:auto" required>
                        <option disabled selected>Selecciona</option>
                        <option><?php echo htmlspecialchars($objetocontrato, ENT_QUOTES, 'UTF-8'); ?></option>
                        <option>TRANSPORTE PARA UN GRUPO ESPECÍFICO DE USUARIOS - TRANSPORTE DE PARTICULARES ASIGNADOS Y/O AUTORIZADOS POR EL CONTRATANTE.</option>
                        <option>TRANSPORTE EMPRESARIAL - TRANSPORTE DE FUNCIONARIOS, SOCIOS, EMPLEADOS, CONTRATISTAS, AFILIADOS, CLIENTES, BENEFICIARIOS, VISITANTES, ACOMPAÑANTES ASIGNADOS Y/O AUTORIZADOS POR EL CONTRATANTE.</option>
                    </select><br>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <label>Responsable del contratante:</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                    <input type="text" class="form-control UpperCase" name="respcont"
                           placeholder="Requerido"
                           value="<?php echo htmlspecialchars($respcont, ENT_QUOTES, 'UTF-8'); ?>" required><br>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <label>Documento del responsable:</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                    <input type="text" pattern="[0-9]{6,10}" class="form-control" name="docuresp"
                           placeholder="Requerido"
                           value="<?php echo htmlspecialchars($docuresp, ENT_QUOTES, 'UTF-8'); ?>"
                           oninvalid="setCustomValidity('Este campo solo acepta números entre 6 y 10 dígitos')"
                           onchange="try{setCustomValidity('')}catch(e){}" required /><br>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <label>Teléfono del responsable:</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                    <input type="text" pattern="[0-9]{7,10}" class="form-control" name="teleresp"
                           placeholder="Requerido"
                           value="<?php echo htmlspecialchars($teleresp, ENT_QUOTES, 'UTF-8'); ?>"
                           oninvalid="setCustomValidity('Este campo solo acepta números entre 7 y 10 dígitos')"
                           onchange="try{setCustomValidity('')}catch(e){}" required /><br>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <label>Dirección del responsable:</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                    <input type="text" class="form-control UpperCase" name="direresp"
                           placeholder="Requerido"
                           value="<?php echo htmlspecialchars($direresp, ENT_QUOTES, 'UTF-8'); ?>" required><br>
                </div>
            </div>

            <div class="form-group" align="center">
                <div class="">
                    <button id="submit" name="submit" type="submit" class="btn btn-success">Crear contrato</button>
                </div>
            </div>
            <hr>
        </form>

        <table class="table table-bordered" width="100%">
            <tr>
                <th style="text-align: center; background:#337ab7;" width="10%"><font color="#FFFFFF">Contratante</th>
                <th style="text-align: center; background:#337ab7;" width="10%"><font color="#FFFFFF">NIT/CC</th>
                <th style="text-align: center; background:#337ab7;" width="30%"><font color="#FFFFFF">Objeto Contrato</th>
                <th style="text-align: center; background:#337ab7;" width="10%"><font color="#FFFFFF">Responsable</th>
                <th style="text-align: center; background:#337ab7;" width="10%"><font color="#FFFFFF">Documento</th>
                <th style="text-align: center; background:#337ab7;" width="10%"><font color="#FFFFFF">Teléfono</th>
                <th style="text-align: center; background:#337ab7;" width="10%"><font color="#FFFFFF">Dirección</th>
                <th style="text-align: center; background:#337ab7;" width="10%"><font color="#FFFFFF">Opcion</th>
            </tr>
            <?php foreach ($contratos as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['contratante'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['nitcontratante'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['objetocontrato'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['respcont'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['docuresp'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['teleresp'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['direresp'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                <td>
                    <a class="btn btn-success"
                       href="editcont.php?idcontrato=<?php echo (int) ($row['idcontrato'] ?? 0); ?>">
                        <i class="fa fa-pencil fa-lg" aria-hidden="true"></i>
                    </a>
                    <a class="btn btn-danger"
                       href="borrcont.php?idcontrato=<?php echo (int) ($row['idcontrato'] ?? 0); ?>"
                       onclick="return Confirmar()">
                        <i class="fa fa-trash-o fa-lg" aria-hidden="true"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

</div>

<script type="text/javascript">
$('.Calendario').datetimepicker({
    format: 'YYYY-MM-DD',
    locale: 'es'
});
$('.Calendario').data("DateTimePicker");

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
