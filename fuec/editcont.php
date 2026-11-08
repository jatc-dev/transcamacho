<?php
declare(strict_types=1);

include 'conexion.php';
include 'funciones.php';
include 'header.php';

ob_start();

$errors = [];
$id = isset($_GET['idcontrato']) ? (int) $_GET['idcontrato'] : 0;

if ($id <= 0) {
    header('Location: boedcont.php');
    exit;
}

////////////////////// OBTENER CONTRATO //////////////////////////////////////

$contrato = null;
try {
    $stmt = $pdo->prepare("SELECT * FROM contratos WHERE idcontrato = ? LIMIT 1");
    $stmt->execute([$id]);
    $contrato = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error al obtener contrato id=$id: " . $e->getMessage());
}

if ($contrato === false || $contrato === null) {
    header('Location: boedcont.php?error=noexiste');
    exit;
}

////////////////////// ACTUALIZAR CONTRATO //////////////////////////////////////

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $contratante = isset($_POST['contratante']) ? trim((string) $_POST['contratante']) : '';
    $nitcontratante = isset($_POST['nitcontratante']) ? trim((string) $_POST['nitcontratante']) : '';
    $objetocontrato = isset($_POST['objetocontrato']) ? trim((string) $_POST['objetocontrato']) : '';
    $respcont = isset($_POST['respcont']) ? trim((string) $_POST['respcont']) : '';
    $docuresp = isset($_POST['docuresp']) ? trim((string) $_POST['docuresp']) : '';
    $teleresp = isset($_POST['teleresp']) ? trim((string) $_POST['teleresp']) : '';
    $direresp = isset($_POST['direresp']) ? trim((string) $_POST['direresp']) : '';

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
                "UPDATE contratos SET contratante = ?, nitcontratante = ?, objetocontrato = ?, respcont = ?, docuresp = ?, teleresp = ?, direresp = ?
                 WHERE idcontrato = ?"
            );
            $stmt->execute([
                $contratante,
                $nitcontratante,
                $objetocontrato,
                $respcont,
                $docuresp,
                $teleresp,
                $direresp,
                $id,
            ]);
            header('Location: boedcont.php?actualizado=1');
            exit;
        } catch (PDOException $e) {
            error_log("Error al actualizar contrato id=$id: " . $e->getMessage());
            $errors[] = 'Error al guardar los cambios. Inténtelo de nuevo más tarde.';
        }
    }
}

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Editar contrato</title>

<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/locale/es.js"></script>

</head>

<body>
<div class="container-fluid" style="margin-top:60px">

<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">Editar contrato</div>
    </div>

    <div class="panel-body">

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
                           value="<?php echo htmlspecialchars($contrato['contratante'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required><br>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <label>NIT/CC:</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                    <input type="text" class="form-control" name="nitcontratante"
                           value="<?php echo htmlspecialchars($contrato['nitcontratante'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
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
                        <option selected><?php echo htmlspecialchars($contrato['objetocontrato'] ?? '', ENT_QUOTES, 'UTF-8'); ?></option>
                        <option>TRANSPORTE PARA UN GRUPO ESPECÍFICO DE USUARIOS - TRANSPORTE DE PARTICULARES ASIGNADOS Y/O AUTORIZADOS POR EL CONTRATANTE.</option>
                        <option>TRANSPORTE EMPRESARIAL - TRANSPORTE DE FUNCIONARIOS, SOCIOS, EMPLEADOS, CONTRATISTAS, AFILIADOS, CLIENTES, BENEFICIARIOS, VISITANTES, ACOMPAÑANTES ASIGNADOS Y/O AUTORIZADOS POR EL CONTRATANTE.</option>
                    </select><br>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <label>Responsable del contratante:</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                    <input type="text" class="form-control UpperCase" name="respcont"
                           value="<?php echo htmlspecialchars($contrato['respcont'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required><br>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <label>Documento del responsable:</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                    <input type="text" pattern="[0-9]{6,10}" class="form-control" name="docuresp"
                           value="<?php echo htmlspecialchars($contrato['docuresp'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                           oninvalid="setCustomValidity('Este campo solo acepta números entre 6 y 10 dígitos')"
                           onchange="try{setCustomValidity('')}catch(e){}" required /><br>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <label>Teléfono del responsable:</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                    <input type="text" pattern="[0-9]{7,10}" class="form-control" name="teleresp"
                           value="<?php echo htmlspecialchars($contrato['teleresp'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                           oninvalid="setCustomValidity('Este campo solo acepta números entre 7 y 10 dígitos')"
                           onchange="try{setCustomValidity('')}catch(e){}" required /><br>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <label>Dirección del responsable:</label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                    <input type="text" class="form-control UpperCase" name="direresp"
                           value="<?php echo htmlspecialchars($contrato['direresp'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required><br>
                </div>
            </div>

            <div class="form-group" align="center">
                <div>
                    <button name="submit" type="submit" class="btn btn-success">Guardar cambios</button>
                </div>
            </div>
        </form>

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
