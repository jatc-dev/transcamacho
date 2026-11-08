<?php
declare(strict_types=1);

include 'header.php';

?>

<html>
<head>
    <title>Descargar FUEC</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/locale/es.js"></script>
    <script src="https://kit.fontawesome.com/7a00a4bd48.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
</head>
<body>
<div class="container" style="margin-top:60px">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title">Descargar FUEC</div>
        </div>
        <div class="panel-body">
            <form id="signupform" class="form-horizontal" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" method="POST" autocomplete="off">
                <div class="form-group row">
                    <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">FUEC No:</label>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <input class="form-control" name="numfuec" id="numfuec" type="text" pattern="[0-9]{4}" oninvalid="setCustomValidity('Este campo solo acepta números de 4 dígitos')" onchange="try{setCustomValidity('')}catch(e){}" placeholder="4 últimos dígitos" required>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <input type="submit" value="Buscar" class="btn btn-success" name="buscafuec">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require 'conexion.php';

if (isset($_POST['buscafuec'])) {
    $numfuec = isset($_POST['numfuec']) ? trim((string) $_POST['numfuec']) : '';

    if ($numfuec === '') {
        echo "<div class='contenido'><div class='alert alert-warning' style='margin:20px'>Ingrese el número del FUEC (4 dígitos)</div></div>";
    } elseif (!preg_match('/^[0-9]{4}$/', $numfuec)) {
        echo "<div class='contenido'><div class='alert alert-danger' style='margin:20px'>El formato del FUEC es inválido (4 dígitos)</div></div>";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM fuec WHERE numfuec = ? LIMIT 1");
            $stmt->execute([$numfuec]);
            $fuec = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($fuec === false || $fuec === null) {
                echo "<div class='contenido'><div class='alert alert-danger' style='margin:20px'>El FUEC solicitado no se encuentra en la base de datos</div></div>";
            } else {
                $esc = function($val) { return htmlspecialchars($val ?? '', ENT_QUOTES, 'UTF-8'); };
                ?>
                <div class='container'>
                    <div class='panel panel-primary' style='margin-top: 20px;'>
                        <div class='panel-body canvas_div_pdf'>
                            <form name='reporte' action='' method='post'>
                                <input type='hidden' name='numfuec' value="<?php echo $esc($fuec['numfuec']); ?>">
                                <input type='hidden' name='idcontrato' value="<?php echo $esc($fuec['idcontrato']); ?>">
                                <input type='hidden' name='anoexped' value="<?php echo $esc($fuec['anoexped'] ?? ''); ?>">
                                <textarea name='contratante' style='display:none;'><?php echo $esc($fuec['contratante']); ?></textarea>
                                <input type='hidden' name='nitcontratante' value="<?php echo $esc($fuec['nitcontratante']); ?>">
                                <textarea name='objetocontrato' style='display:none;'><?php echo $esc($fuec['objetocontrato']); ?></textarea>
                                <textarea name='origen' style='display:none;'><?php echo $esc($fuec['origen']); ?></textarea>
                                <textarea name='destino' style='display:none;'><?php echo $esc($fuec['destino']); ?></textarea>
                                <textarea name='emprvehi' style='display:none;'><?php echo $esc($fuec['emprvehi']); ?></textarea>
                                <input type='hidden' name='fechainicial' value="<?php echo $esc($fuec['fechainicial']); ?>">
                                <input type='hidden' name='fechafinal' value="<?php echo $esc($fuec['fechafinal']); ?>">
                                <textarea name='placa' style='display:none;'><?php echo $esc($fuec['placa']); ?></textarea>
                                <textarea name='modelo' style='display:none;'><?php echo $esc($fuec['modelo']); ?></textarea>
                                <textarea name='marca' style='display:none;'><?php echo $esc($fuec['marca']); ?></textarea>
                                <textarea name='clase' style='display:none;'><?php echo $esc($fuec['clase']); ?></textarea>
                                <textarea name='numinterno' style='display:none;'><?php echo $esc($fuec['numinterno']); ?></textarea>
                                <textarea name='numtarjeta' style='display:none;'><?php echo $esc($fuec['numtarjeta']); ?></textarea>
                                <textarea name='nombcond1' style='display:none;'><?php echo $esc($fuec['nombcond1']); ?></textarea>
                                <textarea name='docucond1' style='display:none;'><?php echo $esc($fuec['docucond1']); ?></textarea>
                                <textarea name='licecond1' style='display:none;'><?php echo $esc($fuec['licecond1']); ?></textarea>
                                <textarea name='vigecond1' style='display:none;'><?php echo $esc($fuec['vigecond1']); ?></textarea>
                                <textarea name='nombcond2' style='display:none;'><?php echo $esc($fuec['nombcond2']); ?></textarea>
                                <textarea name='docucond2' style='display:none;'><?php echo $esc($fuec['docucond2']); ?></textarea>
                                <textarea name='licecond2' style='display:none;'><?php echo $esc($fuec['licecond2']); ?></textarea>
                                <textarea name='vigecond2' style='display:none;'><?php echo $esc($fuec['vigecond2']); ?></textarea>
                                <textarea name='nombcond3' style='display:none;'><?php echo $esc($fuec['nombcond3']); ?></textarea>
                                <textarea name='docucond3' style='display:none;'><?php echo $esc($fuec['docucond3']); ?></textarea>
                                <textarea name='licecond3' style='display:none;'><?php echo $esc($fuec['licecond3']); ?></textarea>
                                <textarea name='vigecond3' style='display:none;'><?php echo $esc($fuec['vigecond3']); ?></textarea>
                                <textarea name='respcont' style='display:none;'><?php echo $esc($fuec['respcont']); ?></textarea>
                                <textarea name='docuresp' style='display:none;'><?php echo $esc($fuec['docuresp']); ?></textarea>
                                <textarea name='teleresp' style='display:none;'><?php echo $esc($fuec['teleresp']); ?></textarea>
                                <textarea name='direresp' style='display:none;'><?php echo $esc($fuec['direresp']); ?></textarea>
                                <textarea name='timestamp' style='display:none;'><?php echo $esc($fuec['timestamp']); ?></textarea>

                                <table class='table table-bordered'>
                                    <tr><td>
                                        <div align='center'><div><img src='img/head.jpg' style='height: 110px'/></div></div>
                                        <h4 align='center'>FORMATO ÚNICO DE EXTRACTO DEL CONTRATO<br>DEL SERVICIO PÚBLICO DE TRANSPORTE TERRESTRE AUTOMOTOR ESPECIAL</h4>
                                        <h4 align='center'>No. 208204520<?php echo $esc($fuec['anoexped'] ?? ''); echo $esc($fuec['idcontrato']); echo $esc($fuec['numfuec']); ?></h4>

                                        <div class='panel-body form-group'>
                                            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'><label>RAZÓN SOCIAL DE LA EMPRESA DE TRANSPORTE ESPECIAL:</label></div>
                                            <div class='col-lg-9 col-md-9 col-sm-9 col-xs-9'>TRANS CAMACHO TOURS S.A.S.</div><br><br></div>
                                            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'><label>NIT:</label></div>
                                            <div class='col-lg-9 col-md-9 col-sm-9 col-xs-9'>901.363.632-0<br><br></div>
                                            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'><label>CONTRATO No:</label></div>
                                            <div class='col-lg-9 col-md-9 col-sm-9 col-xs-9'><?php echo $esc($fuec['idcontrato']); ?><br><br></div>
                                            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'><label>CONTRATANTE: </label></div>
                                            <div class='col-lg-9 col-md-9 col-sm-9 col-xs-9'><?php echo $esc($fuec['contratante']); ?><br><br></div>
                                            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'><label>NIT/CC:</label></div>
                                            <div class='col-lg-9 col-md-9 col-sm-9 col-xs-9'><?php echo $esc($fuec['nitcontratante']); ?><br><br></div>
                                            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'><label>OBJETO CONTRATO:</label></div>
                                            <div class='col-lg-9 col-md-9 col-sm-9 col-xs-9'><?php echo $esc($fuec['objetocontrato']); ?><br><br></div>
                                            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'><label>ORIGEN - DESTINO</label></div>
                                            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'><?php echo $esc($fuec['origen']); ?></div>
                                            <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'><?php echo $esc($fuec['destino']); ?></div>
                                            <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'><?php echo $esc($fuec['origen']); ?><br><br></div>
                                            <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'><label>CONVENIO DE COLABORACIÓN:</label></div>
                                            <div class='col-lg-9 col-md-9 col-sm-9 col-xs-9'><?php echo $esc($fuec['emprvehi']); ?><br><br></div>
                                        </div>

                                        <table class='table table-bordered'>
                                            <thead><tr><th colspan=2 class='text-center'>VIGENCIA DEL CONTRATO</th></tr></thead>
                                            <tbody class='text-center'>
                                                <tr><th>FECHA INICIAL</th><td><?php echo $esc($fuec['fechainicial']); ?></td></tr>
                                                <tr><th>FECHA VENCIMIENTO</th><td><?php echo $esc($fuec['fechafinal']); ?></td></tr>
                                            </tbody>
                                        </table>

                                        <table class='table table-bordered'>
                                            <thead><tr><th colspan=4 class='text-center'>CARACTERÍSTICAS DEL VEHÍCULO</th></tr></thead>
                                            <tbody class='text-center'>
                                                <tr><th class='text-center'>PLACA</th><th class='text-center'>MODELO</th><th class='text-center'>MARCA</th><th class='text-center'>CLASE</th></tr>
                                                <tr><td><?php echo $esc($fuec['placa']); ?></td><td><?php echo $esc($fuec['modelo']); ?></td><td><?php echo $esc($fuec['marca']); ?></td><td><?php echo $esc($fuec['clase']); ?></td></tr>
                                                <tr><th colspan=2 class='text-center'>NÚMERO INTERNO</th><th colspan=2 class='text-center'>NÚMERO DE TARJETA DE OPERACIÓN</th></tr>
                                                <tr><td colspan=2><?php echo $esc($fuec['numinterno']); ?></td><td colspan=2><?php echo $esc($fuec['numtarjeta']); ?></td></tr>
                                            </tbody>
                                        </table>

                                        <table class='table table-bordered'>
                                            <thead>
                                                <tr><th></th><th class='text-center'>NOMBRES Y APELLIDOS</th><th class='text-center'>CÉDULA</th><th class='text-center'>LICENCIA</th><th class='text-center'>VIGENCIA</th></tr>
                                            </thead>
                                            <tbody>
                                                <tr><th class='text-center'>DATOS DEL CONDUCTOR 1</th><td class='text-center'><?php echo $esc($fuec['nombcond1']); ?></td><td class='text-center'><?php echo $esc($fuec['docucond1']); ?></td><td class='text-center'><?php echo $esc($fuec['licecond1']); ?></td><td class='text-center'><?php echo $esc($fuec['vigecond1']); ?></td></tr>
                                                <tr><th class='text-center'>DATOS DEL CONDUCTOR 2</th><td class='text-center'><?php echo $esc($fuec['nombcond2']); ?></td><td class='text-center'><?php echo $esc($fuec['docucond2']); ?></td><td class='text-center'><?php echo $esc($fuec['licecond2']); ?></td><td class='text-center'><?php echo $esc($fuec['vigecond2']); ?></td></tr>
                                                <tr><th class='text-center'>DATOS DEL CONDUCTOR 3</th><td class='text-center'><?php echo $esc($fuec['nombcond3']); ?></td><td class='text-center'><?php echo $esc($fuec['docucond3']); ?></td><td class='text-center'><?php echo $esc($fuec['licecond3']); ?></td><td class='text-center'><?php echo $esc($fuec['vigecond3']); ?></td></tr>
                                            </tbody>
                                        </table>

                                        <table class='table table-bordered'>
                                            <thead>
                                                <tr><th></th><th class='text-center'>NOMBRES Y APELLIDOS</th><th class='text-center'>CÉDULA</th><th class='text-center'>TELÉFONO</th><th class='text-center'>DIRECCIÓN</th></tr>
                                            </thead>
                                            <tbody>
                                                <tr><th class='text-center'>RESPONSABLE DEL CONTRATANTE</th><td class='text-center'><?php echo $esc($fuec['respcont']); ?></td><td class='text-center'><?php echo $esc($fuec['docuresp']); ?></td><td class='text-center'><?php echo $esc($fuec['teleresp']); ?></td><td class='text-center'><?php echo $esc($fuec['direresp']); ?></td></tr>
                                            </tbody>
                                        </table>

                                        <table class='table table-bordered'>
                                            <tr>
                                                <td class='text-center'><b>TRANS CAMACHO TOURS S.A.S</b><br>RESOLUCIÓN MINTRANSPORTE 20203040012045<br>NIT 901363632-0<br>Teléfono: 3125780760<br>Carrera 79F No 51A-12 Sur BQ 1 IN 3 Apto.203<br>Bogotá D.C.– Colombia<br>transcamachotours@outlook.com<br><a href='www.transcamacho.com'><b>www.transcamacho.com</b></a></td>
                                                <td class='text-center'><div><img src='img/qr.jpg' style='height: 180px'/></div></td>
                                                <td class='text-center'><div id='sign'></div><br><b>Representante Legal TRANS CAMACHO TOURS S.A.S.</b><br>Firmado digitalmente - Fecha: <?php echo $esc($fuec['timestamp']); ?><br><small>Firma digital según resolución 6652 de 2019 Art. 8.<br>Ley 527 de 1999 – Decreto 1074 de 2015.</small></td>
                                            </tr>
                                        </table>
                                    </td></tr>
                                </table>
                            </div>

                            <div class='form-group panel-body' align='center'>
                                <button id='pdf' type='submit' class='btn btn-danger' onclick="this.form.action='genpdf.php'">Descargar PDF <i class='far fa-file-pdf' style='font-size:150%'></i></button><br><br>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
            }
        } catch (PDOException $e) {
            error_log("Error al buscar FUEC numfuec=$numfuec: " . $e->getMessage());
            echo "<div class='contenido'><div class='alert alert-danger' style='margin:20px'>Error al consultar la base de datos. Inténtelo de nuevo más tarde.</div></div>";
        }
    }
}
?>
</body>
</html>
