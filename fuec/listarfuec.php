<?php

include 'funciones.php';
include 'header.php';

////////////////// VARIABLES DE CONSULTA////////////////////////////////////

$where="";

$contratante = isset($_POST['contratante']) ? $_POST['contratante'] : '';
$numfuec = isset($_POST['numfuec']) ? $_POST['numfuec'] : '';
$limit = isset($_POST['registros']) ? $_POST['registros'] : '';

/*$nombre=$_POST['nombre'];
$unidad=$_POST['unidad'];
$limit=$_POST['registros'];*/

////////////////////// BOTON BUSCAR //////////////////////////////////////

if (isset($_POST['buscar'])) {
   
    if (empty($_POST['numfuec'])) {
        $where="where contratante like '%".$contratante."%'";
    }

    else if (empty($_POST['contratante'])) {
        $where="where numfuec like'".$numfuec."'";
    }

    else {
        $where="where contratante like '%".$contratante."%' and numfuec='".$numfuec."'";
    }
}
/////////////////////// CONSULTA A LA BASE DE DATOS ////////////////////////

$consulta="SELECT * FROM fuec $where $limit ORDER BY numfuec DESC";
$resConsulta=$mysqli->query($consulta);

if(mysqli_num_rows($resConsulta)==0)
{
    $mensaje="<h4>No hay registros que coincidan con su criterio de búsqueda.</h4>
       ";
}

$query=mysqli_query($mysqli,"SELECT DISTINCT numfuec FROM fuec ORDER BY numfuec DESC");
    
    if(isset($_POST['numfuec']))
    {
        $numfuec=$_POST['numfuec'];
        echo $numfuec;
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
                        <input autofocus class="form-control input-medium ui-autocomplete-input UpperCase" value="" autocomplete="off" id="contratante" name="contratante" type="text" placeholder="Escribe al menos 3 letras">
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                        <label>Número de FUEC</label><br>
                        <select name="numfuec" class="form-control">
                            <option value="" disabled selected>Seleccione </option>
                            <?php
                                while ($datos = mysqli_fetch_array($query))
                                {
                                    echo '<option value="'.$datos['numfuec'].'">'.$datos['numfuec'].'</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                        <label>No. de Registros</label><br>
                        <select name="registros" class="form-control">
                            <option value="limit 10">10</option>
                            <option value="limit 20">20</option>
                            <option value="limit 100">100</option>
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                        <label></label><br>
                        <button name="buscar" type="submit" class="btn btn-success"><span style="" class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;Buscar</button>
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
                            <th style="text-align: center; background:#337ab7;" rowspan="2"><font color="#FFFFFF">No FUEC</th>
                            <th style="text-align: center; background:#337ab7;" rowspan="2"><font color="#FFFFFF">Fecha Generación</th>
                            <th style="text-align: center; background:#337ab7;" colspan="4"><font color="#FFFFFF">Contratante</th>
                            <th style="text-align: center; background:#337ab7;" colspan="2"><font color="#FFFFFF">Ruta</th>
                            <th style="text-align: center; background:#337ab7;" colspan="2"><font color="#FFFFFF">Vigencia</th>
                            <th style="text-align: center; background:#337ab7;" colspan="4"><font color="#FFFFFF">Vehículo</th>
                            <th style="text-align: center; background:#337ab7;" colspan="3"><font color="#FFFFFF">Conductores</th>
                            <th style="text-align: center; background:#337ab7;" rowspan="2"><font color="#FFFFFF">Usuario</th>
                                               
                        </tr>

                         <tr style="text-align: center">
                            <th style="text-align: center; background:#337ab7;"><font color="#FFFFFF">Nombres o Razón social</th>
                            <th style="text-align: center; background:#337ab7;"><font color="#FFFFFF">Documento</th>
                            <th style="text-align: center; background:#337ab7;"><font color="#FFFFFF">No Contrato</th>
                            <th style="text-align: center; background:#337ab7;"><font color="#FFFFFF">Responsable</th>

                            <th style="text-align: center; background:#337ab7;"><font color="#FFFFFF">Origen</th>
                            <th style="text-align: center; background:#337ab7;"><font color="#FFFFFF">Destino</th>

                            <th style="text-align: center; background:#337ab7;"><font color="#FFFFFF">Fecha Inicio</th>
                            <th style="text-align: center; background:#337ab7;"><font color="#FFFFFF">Fecha Fin</th>

                            <th style="text-align: center; background:#337ab7;"><font color="#FFFFFF">Placas</th>
                            <th style="text-align: center; background:#337ab7;"><font color="#FFFFFF">Modelo</th>
                            <th style="text-align: center; background:#337ab7;"><font color="#FFFFFF">Marca</th>
                            <th style="text-align: center; background:#337ab7;"><font color="#FFFFFF">Clase</th>

                            <th style="text-align: center; background:#337ab7;"><font color="#FFFFFF">1</th>
                            <th style="text-align: center; background:#337ab7;"><font color="#FFFFFF">2</th>
                            <th style="text-align: center; background:#337ab7;"><font color="#FFFFFF">3</th>
                        </tr>
            
                    </thead>
                    <tbody>
                        <?php

                        while ($registroConsulta = $resConsulta->fetch_array(MYSQLI_BOTH))
                        {
                            echo'
                                <tr style="background:#fff;">
                                    <td>'.$registroConsulta['numfuec'].'</td>
                                    <td>'.$registroConsulta['timestamp'].'</td>
                                    <td>'.$registroConsulta['contratante'].'</td>
                                    <td>'.$registroConsulta['nitcontratante'].'</td>                                          
                                    <td>'.$registroConsulta['idcontrato'].'</td>
                                    <td>'.$registroConsulta['respcont'].'</td>                           
                                    
                                    <td>'.$registroConsulta['origen'].'</td>
                                    <td>'.$registroConsulta['destino'].'</td>

                                    <td>'.$registroConsulta['fechainicial'].'</td>        
                                    <td>'.$registroConsulta['fechafinal'].'</td>        

                                    <td>'.$registroConsulta['placa'].'</td>
                                    <td>'.$registroConsulta['modelo'].'</td>
                                    <td>'.$registroConsulta['marca'].'</td>
                                    <td>'.$registroConsulta['clase'].'</td>        

                                    <td>'.$registroConsulta['nombcond1'].'</td>                          
                                    <td>'.$registroConsulta['nombcond2'].'</td>                        
                                    <td>'.$registroConsulta['nombcond3'].'</td>
                                                      
                                    <td>'.$registroConsulta['usercrea'].'</td>
                                </tr>';                    
                        }
                        ?>

                    </tbody>    
                </table>

            <?
                echo $mensaje;
            ?>

       

            </div>
            </div>
</div>

</div>

    
  

<script type="text/javascript">
    $(document).ready( function () {
 $(".UpperCase").on("keypress", function () {
  $input=$(this);
  setTimeout(function () {
   $input.val($input.val().toUpperCase());
  },50);
 })
})
</script>

</body>
</html>