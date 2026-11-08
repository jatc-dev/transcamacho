<?php
declare(strict_types=1);

require 'funciones.php';
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idcontrato = isset($_POST['idcontrato']) ? trim((string) $_POST['idcontrato']) : '';
    $contratante = isset($_POST['contratante']) ? trim((string) $_POST['contratante']) : '';
    $nitcontratante = isset($_POST['nitcontratante']) ? trim((string) $_POST['nitcontratante']) : '';
    $objetocontrato = isset($_POST['objetocontrato']) ? trim((string) $_POST['objetocontrato']) : '';
    $origen = isset($_POST['origen']) ? trim((string) $_POST['origen']) : '';
    $destino = isset($_POST['destino']) ? trim((string) $_POST['destino']) : '';
    $emprvehi = isset($_POST['emprvehi']) ? trim((string) $_POST['emprvehi']) : '';
    $fechainicial = isset($_POST['fechainicial']) ? trim((string) $_POST['fechainicial']) : '';
    $fechafinal = isset($_POST['fechafinal']) ? trim((string) $_POST['fechafinal']) : '';
    $placa = isset($_POST['placa']) ? trim((string) $_POST['placa']) : '';
    $modelo = isset($_POST['modelo']) ? trim((string) $_POST['modelo']) : '';
    $marca = isset($_POST['marca']) ? trim((string) $_POST['marca']) : '';
    $clase = isset($_POST['clase']) ? trim((string) $_POST['clase']) : '';
    $numinterno = isset($_POST['numinterno']) ? trim((string) $_POST['numinterno']) : '';
    $numtarjeta = isset($_POST['numtarjeta']) ? trim((string) $_POST['numtarjeta']) : '';
    $nombcond1 = isset($_POST['nombcond1']) ? trim((string) $_POST['nombcond1']) : '';
    $docucond1 = isset($_POST['docucond1']) ? trim((string) $_POST['docucond1']) : '';
    $licecond1 = isset($_POST['licecond1']) ? trim((string) $_POST['licecond1']) : '';
    $vigecond1 = isset($_POST['vigecond1']) ? trim((string) $_POST['vigecond1']) : '';
    $nombcond2 = isset($_POST['nombcond2']) ? trim((string) $_POST['nombcond2']) : '';
    $docucond2 = isset($_POST['docucond2']) ? trim((string) $_POST['docucond2']) : '';
    $licecond2 = isset($_POST['licecond2']) ? trim((string) $_POST['licecond2']) : '';
    $vigecond2 = isset($_POST['vigecond2']) ? trim((string) $_POST['vigecond2']) : '';
    $nombcond3 = isset($_POST['nombcond3']) ? trim((string) $_POST['nombcond3']) : '';
    $docucond3 = isset($_POST['docucond3']) ? trim((string) $_POST['docucond3']) : '';
    $licecond3 = isset($_POST['licecond3']) ? trim((string) $_POST['licecond3']) : '';
    $vigecond3 = isset($_POST['vigecond3']) ? trim((string) $_POST['vigecond3']) : '';
    $respcont = isset($_POST['respcont']) ? trim((string) $_POST['respcont']) : '';
    $docuresp = isset($_POST['docuresp']) ? trim((string) $_POST['docuresp']) : '';
    $teleresp = isset($_POST['teleresp']) ? trim((string) $_POST['teleresp']) : '';
    $direresp = isset($_POST['direresp']) ? trim((string) $_POST['direresp']) : '';
    $usercrea = isset($_POST['usercrea']) ? trim((string) $_POST['usercrea']) : $nombreUsuario;

    $errors = [];

    if (isnullFuec($idcontrato, $contratante, $nitcontratante, $objetocontrato, $origen, $destino, $fechainicial, $fechafinal, $placa, $modelo, $marca, $clase, $numinterno, $numtarjeta, $nombcond1, $docucond1, $licecond1, $vigecond1, $respcont, $docuresp, $teleresp, $direresp)) {
        $errors[] = 'Debe llenar todos los campos';
    }

    if (count($errors) === 0) {
        try {
            $registro = registraFuec(
                $pdo,
                $idcontrato, $contratante, $nitcontratante, $objetocontrato, $origen, $destino, $emprvehi,
                $fechainicial, $fechafinal, $placa, $modelo, $marca, $clase, $numinterno, $numtarjeta,
                $nombcond1, $docucond1, $licecond1, $vigecond1, $nombcond2, $docucond2, $licecond2, $vigecond2,
                $nombcond3, $docucond3, $licecond3, $vigecond3, $respcont, $docuresp, $teleresp, $direresp, $usercrea
            );

            if ($registro > 0) {
                header('Location: confirma.php');
                exit;
            } else {
                $errors[] = 'Error al guardar';
            }
        } catch (PDOException $e) {
            error_log("Error al registrar FUEC: " . $e->getMessage());
            $errors[] = 'Error al generar el FUEC. Inténtelo de nuevo más tarde.';
        }
    }
}

?>

<html>
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/locale/es.js"></script>
    <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
    <script type="text/javascript" src="js/scripts.js"></script>
</head>
<body>
<div class="container-fluid" style="margin-top:60px">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title">Crear FUEC</div>
        </div>
        <div class="panel-body">
            <div align="center">
                <div><img src="img/min.png" style="height: 90px" alt=""/><img src="img/logo.png" style="height: 100px" alt="Logo"/></div>
            </div>
            <h4 align="center">FORMATO ÚNICO DE EXTRACTO DEL CONTRATO<br>DEL SERVICIO PÚBLICO DE TRANSPORTE TERRESTRE AUTOMOTOR ESPECIAL</h4>

            <?php if (count($errors) > 0): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="panel-body row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><label>RAZÓN SOCIAL DE LA EMPRESA DE TRANSPORTE ESPECIAL:</label></div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">TRANS CAMACHO TOURS S.A.S.</div>
            </div>
            <div class="panel-body row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><label>NIT:</label></div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">901.363.632-0</div>
            </div>

            <form id="form" name="form" class="form-horizontal" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" method="POST" autocomplete="off" onsubmit="return pregunta()">
                <div class="panel-body form-group">
                    <div class="panel-body form-group row">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><label>Buscar contratante:</label></div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <input autofocus class="form-control input-medium ui-autocomplete-input UpperCase" value="" autocomplete="off" id="buscacontrato" name="buscacontrato" type="text" placeholder="Escribe al menos 3 letras">
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                            <div align="right">
                                <small>* Si el contratante no aparece listado puede agregarlo en el vínculo:</small><br>
                                <a href="boedcont.php"><span style="font-size: 150%" class="fas fa-plus-circle"></span>&nbsp;&nbsp;&nbsp;Agregar contratante</a><br><br><br>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><label>CONTRATO No:</label></div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9"><input class="form-control" type="text" name="idcontrato" id="idcontrato" value="" readonly="readonly"><br></div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 hidden"><label>CONTRATANTE:</label></div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 hidden"><input class="form-control" type="text" name="contratante" id="contratante" value="<?php echo htmlspecialchars($contratante, ENT_QUOTES, 'UTF-8'); ?>" readonly="readonly"><br></div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><label>NIT/CC:</label></div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9"><input class="form-control" type="text" name="nitcontratante" id="nitcontratante" value="<?php echo htmlspecialchars($nitcontratante, ENT_QUOTES, 'UTF-8'); ?>" readonly="readonly"><br></div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><label>OBJETO CONTRATO:</label></div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9"><textarea rows="3" class="form-control" name="objetocontrato" id="objetocontrato" readonly="readonly"><?php echo htmlspecialchars($objetocontrato, ENT_QUOTES, 'UTF-8'); ?></textarea><br></div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><label>ORIGEN - DESTINO</label></div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><input autofocus class="form-control input-medium ui-autocomplete-input UpperCase" value="<?php echo htmlspecialchars($origen, ENT_QUOTES, 'UTF-8'); ?>" autocomplete="off" id="origen" name="origen" type="text" placeholder="Escribe al menos 3 letras"></div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><input autofocus class="form-control input-medium ui-autocomplete-input UpperCase" value="<?php echo htmlspecialchars($destino, ENT_QUOTES, 'UTF-8'); ?>" autocomplete="off" id="destino" name="destino" type="text" placeholder="Escribe al menos 3 letras"></div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><input class="form-control" type="text" name="origen1" id="origen1" value="" readonly="readonly"><br></div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><label>CONVENIO DE COLABORACIÓN:</label></div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9"><input class="form-control" type="text" name="emprvehi" id="emprvehi" value="<?php echo htmlspecialchars($emprvehi, ENT_QUOTES, 'UTF-8'); ?>" readonly="readonly"><br></div>
                </div>

                <div style="text-align: center;" class="panel-body"><hr><label>VIGENCIA DEL CONTRATO</label></div>
                <div class="panel-body form-group">
                    <?php
                    date_default_timezone_set('America/Bogota');
                    $fechainicial = date("Y-m-d");
                    $fechafinal = date("Y-m-d", strtotime($fechainicial . "+ 1 month"));
                    ?>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <label>FECHA INICIAL</label><br>
                        <div id="datetime">
                            <div class='input-group date Calendario'>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                <input type='text' name="fechainicial" id="fechainicial" class="form-control" value="<?php echo htmlspecialchars($fechainicial, ENT_QUOTES, 'UTF-8'); ?>" required />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <label>FECHA VENCIMIENTO</label><br>
                        <div id="datetimerev1">
                            <div class='input-group date Calendario'>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                <input type='text' name="fechafinal" id="final" class="form-control" value="<?php echo htmlspecialchars($fechafinal, ENT_QUOTES, 'UTF-8'); ?>" required />
                            </div>
                        </div>
                    </div>
                </div>

                <div style="text-align: center;" class="panel-body"><hr><label>CARACTERÍSTICAS DEL VEHÍCULO</label></div>
                <div class="panel-body form-group row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><div><label>Buscar vehículo</label></div></div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><div><input autofocus class="form-control input-medium ui-autocomplete-input UpperCase" value="" autocomplete="off" id="buscaplaca" name="buscaplaca" type="text" placeholder="Digita al menos 3 caracteres de la placa"></div></div>
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5"><div align="right"><small>* Si el vehículo no aparece listado puede agregarlo en el vínculo:</small><br><a href="boedvehi.php"><span style="font-size: 150%" class="fas fa-plus-circle"></span>&nbsp;&nbsp;&nbsp;Agregar vehículo</a><br><br><br></div></div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><label>PLACA</label><br><input class="form-control" type="text" name="placa" id="placa" value="<?php echo htmlspecialchars($placa, ENT_QUOTES, 'UTF-8'); ?>" readonly="readonly"></div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><label>MODELO</label><br><input class="form-control" type="text" name="modelo" id="modelo" value="<?php echo htmlspecialchars($modelo, ENT_QUOTES, 'UTF-8'); ?>" readonly="readonly"></div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><label>MARCA</label><br><input class="form-control" type="text" name="marca" id="marca" value="<?php echo htmlspecialchars($marca, ENT_QUOTES, 'UTF-8'); ?>" readonly="readonly"></div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><label>CLASE</label><br><input class="form-control" type="text" name="clase" id="clase" value="<?php echo htmlspecialchars($clase, ENT_QUOTES, 'UTF-8'); ?>" readonly="readonly"><br></div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><label>NÚMERO INTERNO</label><br><input class="form-control" type="text" name="numinterno" id="numinterno" value="<?php echo htmlspecialchars($numinterno, ENT_QUOTES, 'UTF-8'); ?>" readonly="readonly"></div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><label>NÚMERO DE TARJETA DE OPERACIÓN</label><br><input class="form-control" type="text" name="numtarjeta" id="numtarjeta" value="<?php echo htmlspecialchars($numtarjeta, ENT_QUOTES, 'UTF-8'); ?>" readonly="readonly"></div>
                </div>

                <div class="panel-body"><hr></div>
                <div class="panel-body form-group">
                    <div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div align="right"><small>* Si el conductor no aparece listado puede agregarlo en el vínculo:</small><br><a href="boedcond.php"><span style="font-size: 150%" class="fas fa-plus-circle"></span>&nbsp;&nbsp;&nbsp;Agregar conductor</a><br><br><br></div></div></div>

                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><label>DATOS DEL CONDUCTOR 1</label></div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><input autofocus class="form-control input-medium ui-autocomplete-input UpperCase" value="" autocomplete="off" id="buscaconductor1" name="buscaconductor1" type="text" placeholder="Escribe al menos 3 letras" oninvalid="setCustomValidity('Este campo es obligatorio')" onchange="try{setCustomValidity('')}catch(e){}" required ></div>
                        <div class="col-lg-0 col-md-0 col-sm-0 col-xs-0"><input class="form-control" type="hidden" name="nombcond1" id="nombcond1" value="<?php echo htmlspecialchars($nombcond1, ENT_QUOTES, 'UTF-8'); ?>" readonly="readonly"></div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><input class="form-control" type="text" name="docucond1" id="docucond1" value="<?php echo htmlspecialchars($docucond1, ENT_QUOTES, 'UTF-8'); ?>" readonly="readonly"></div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><input class="form-control" type="text" name="licecond1" id="licecond1" value="<?php echo htmlspecialchars($licecond1, ENT_QUOTES, 'UTF-8'); ?>" readonly="readonly"></div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><input class="form-control" type="text" name="vigecond1" id="vigecond1" value="<?php echo htmlspecialchars($vigecond1, ENT_QUOTES, 'UTF-8'); ?>" readonly="readonly"></div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><label>DATOS DEL CONDUCTOR 2</label></div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><input autofocus class="form-control input-medium ui-autocomplete-input UpperCase" value="" autocomplete="off" id="buscaconductor2" name="buscaconductor2" type="text" placeholder="Escribe al menos 3 letras"></div>
                        <div class="col-lg-0 col-md-0 col-sm-0 col-xs-0"><input class="form-control" type="hidden" name="nombcond2" id="nombcond2" value="<?php echo htmlspecialchars($nombcond2, ENT_QUOTES, 'UTF-8'); ?>" readonly="readonly"></div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><input class="form-control" type="text" name="docucond2" id="docucond2" value="<?php echo htmlspecialchars($docucond2, ENT_QUOTES, 'UTF-8'); ?>" readonly="readonly"></div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><input class="form-control" type="text" name="licecond2" id="licecond2" value="<?php echo htmlspecialchars($licecond2, ENT_QUOTES, 'UTF-8'); ?>" readonly="readonly"></div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><input class="form-control" type="text" name="vigecond2" id="vigecond2" value="<?php echo htmlspecialchars($vigecond2, ENT_QUOTES, 'UTF-8'); ?>" readonly="readonly"></div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><label>DATOS DEL CONDUCTOR 3</label></div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><input autofocus class="form-control input-medium ui-autocomplete-input UpperCase" value="" autocomplete="off" id="buscaconductor3" name="buscaconductor3" type="text" placeholder="Escribe al menos 3 letras"></div>
                        <div class="col-lg-0 col-md-0 col-sm-0 col-xs-0"><input class="form-control" type="hidden" name="nombcond3" id="nombcond3" value="<?php echo htmlspecialchars($nombcond3, ENT_QUOTES, 'UTF-8'); ?>" readonly="readonly"></div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><input class="form-control" type="text" name="docucond3" id="docucond3" value="<?php echo htmlspecialchars($docucond3, ENT_QUOTES, 'UTF-8'); ?>" readonly="readonly"></div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><input class="form-control" type="text" name="licecond3" id="licecond3" value="<?php echo htmlspecialchars($licecond3, ENT_QUOTES, 'UTF-8'); ?>" readonly="readonly"></div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><input class="form-control" type="text" name="vigecond3" id="vigecond3" value="<?php echo htmlspecialchars($vigecond3, ENT_QUOTES, 'UTF-8'); ?>" readonly="readonly"></div>
                    </div>
                </div>

                <div class="panel-body form-group">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><label>RESPONSABLE DEL CONTRATANTE</label></div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><input class="form-control" type="text" name="respcont" id="respcont" value="<?php echo htmlspecialchars($respcont, ENT_QUOTES, 'UTF-8'); ?>" readonly="readonly"></div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><input class="form-control" type="text" name="docuresp" id="docuresp" value="<?php echo htmlspecialchars($docuresp, ENT_QUOTES, 'UTF-8'); ?>" readonly="readonly"></div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><input class="form-control" type="text" name="teleresp" id="teleresp" value="<?php echo htmlspecialchars($teleresp, ENT_QUOTES, 'UTF-8'); ?>" readonly="readonly"></div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><input class="form-control" type="text" name="direresp" id="direresp" value="<?php echo htmlspecialchars($direresp, ENT_QUOTES, 'UTF-8'); ?>" readonly="readonly"></div>
                    </div>
                    <div class="hidden">
                        <label>Usuario crea</label>
                        <input class="form-control" type="text" name="usercrea" id="usercrea" value="<?php echo htmlspecialchars($usercrea, ENT_QUOTES, 'UTF-8'); ?>" readonly="readonly">
                    </div>
                </div>

                <div class="panel-body form-group row" align="center"><br><br>
                    <button id="btn-signup" name="btn-signup" type="submit" class="btn btn-success">Generar FUEC</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
function pregunta() {
    return confirm('¿Está seguro que desea generar el FUEC? Recuerde que no podrá cambiarlo posteriormente');
}
</script>
<script type="text/javascript">
$('.Calendario').datetimepicker({ format: 'YYYY-MM-DD', locale: 'es' });
$('.Calendario').data("DateTimePicker");
</script>
<script type="text/javascript">
$(document).ready(function () {
    $(".UpperCase").on("keypress", function () {
        var $input = $(this);
        setTimeout(function () {
            $input.val($input.val().toUpperCase());
        }, 50);
    });
});
</script>
</body>
</html>
