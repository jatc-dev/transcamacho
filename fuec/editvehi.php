<?php
include 'header.php';
ob_start(); //linea para evitar problemas con los headers
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

</head>

<body>
<div class="container-fluid" style="margin-top:60px">

<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="panel-title">Editar vehículo</div>
	</div>  
					 			
	<div class="panel-body">
<?php 
include("function.php");
$id = $_GET['idvehi'];
select_id('vehiculos','idvehi',$id);
?>
<form action="" method="post">

  <div class="form-group row panel-body">
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>Placa:</label>					    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
			    	<input type="text" class="form-control UpperCase" name="placa" placeholder="Requerido" value="<?php echo $row->placa;?>" pattern="[A-Z0-9]{6}" oninvalid="setCustomValidity('Este campo solo acepta 6 caracteres sin espacio ni guion')" onchange="try{setCustomValidity('')}catch(e){}" required><br>
			    </div>			      
			
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>Año modelo:</label>			    						    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
			    	<input type="text" class="form-control" name="modelo" placeholder="Requerido" value="<?php echo $row->modelo;?>" pattern="[0-9]{4}" oninvalid="setCustomValidity('Ingrese el año del modelo del vehículo (4 números)')" onchange="try{setCustomValidity('')}catch(e){}" required><br>	
			    </div>			      
			
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>Marca:</label>					    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
			    	<input type="text" class="form-control UpperCase" name="marca" placeholder="Requerido" value="<?php echo $row->marca;?>" required><br>
			    </div>			      
			
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>Clase:</label>					    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
			    	<input type="text" class="form-control UpperCase" name="clase" placeholder="Requerido" value="<?php echo $row->clase;?>" required><br>
			    </div>			      
			
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>Número interno:</label>			    						    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
			    	<input type="text" class="form-control UpperCase" name="numinterno" placeholder="Requerido" value="<?php echo $row->numinterno;?>" required><br>	
			    </div>			      
			
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>Número tarjeta de operación:</label>			    						    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
			    	<input type="text" class="form-control" name="numtarjeta" placeholder="Requerido" value="<?php echo $row->numtarjeta;?>" pattern="[0-9]{}" oninvalid="setCustomValidity('Este campo solo acepta números')" onchange="try{setCustomValidity('')}catch(e){}" required><br>	
			    </div>			      
			
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
					<label>Fecha de vencimiento</label>
				</div>
				
				<div id="datetime" class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
					<div class='input-group date Calendario'>
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						<input type='text' name="vencetarjeta" id="vencetarjeta" class="form-control" value="<?php echo $row->vencetarjeta;?>" required />
					</div><br>
				</div>
										
		    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
		    	<label>Empresa de afiliación del Vehículo:</label>					    	
		    </div>
		    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
		    	<input type="text" class="form-control UpperCase" name="emprvehi" placeholder="" value="<?php echo $row->emprvehi;?>" ><br>
		    </div>			      
				<br><br>
		    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
		    	<label>NIT Empresa de afilicación:</label>					    	
		    </div>
		    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
		    	<input type="text" class="form-control" name="nitempresa" placeholder="" value="<?php echo $row->nitempresa;?>" ><br>
		    </div>			      
		</div>
				
			<div class="form-group" align="center">                                      
				<div class="">
					<button id="submit" name="submit" type="submit" class="btn btn-success">Guardar cambios</button>
				</div>
			</div>
    <hr>

</form>

<?php
	
	if(isset($_POST['submit'])){
		$field = array("placa"=>$_POST['placa'], "modelo"=>$_POST['modelo'], "marca"=>$_POST['marca'], "clase"=>$_POST['clase'], "numinterno"=>$_POST['numinterno'], "numtarjeta"=>$_POST['numtarjeta'], "vencetarjeta"=>$_POST['vencetarjeta'], "emprvehi"=>$_POST['emprvehi'], "nitempresa"=>$_POST['nitempresa']);
		$tbl = "vehiculos";
		edit($tbl,$field,'idvehi',$id);
		header("location:boedvehi.php");
	}
?>


</div>
</div>
</div>


<script type="text/javascript">
$('.Calendario').datetimepicker({
          format: 'YYYY-MM-DD',
          locale: 'es'
      });
    $('.Calendario').data("DateTimePicker");	
</script>

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