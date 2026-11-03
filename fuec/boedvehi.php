<?php
include 'header.php';
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
		<div class="panel-title">Agregar/Editar vehículo</div>
	</div>  
					 			
	<div class="panel-body">
<form action="" method="post">
  <div class="form-group row panel-body">
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>Placa:</label>					    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
			    	<input type="text" class="form-control UpperCase" name="placa" placeholder="Requerido" value="<?php if(isset($placa)) echo $placa; ?>" pattern="[A-Z0-9]{6}" oninvalid="setCustomValidity('Este campo solo acepta 6 caracteres sin espacio ni guion')" onchange="try{setCustomValidity('')}catch(e){}" required><br>
			    </div>			      
			
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>Año modelo:</label>			    						    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
			    	<input type="text" class="form-control" name="modelo" placeholder="Requerido" value="<?php if(isset($modelo)) echo $modelo; ?>" pattern="[0-9]{4}" oninvalid="setCustomValidity('Ingrese el año del modelo del vehículo (4 números)')" onchange="try{setCustomValidity('')}catch(e){}" required><br>	
			    </div>			      
			
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>Marca:</label>					    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
			    	<input type="text" class="form-control UpperCase" name="marca" placeholder="Requerido" value="<?php if(isset($marca)) echo $marca; ?>" required><br>
			    </div>			      
			
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>Clase:</label>					    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
			    	<input type="text" class="form-control UpperCase" name="clase" placeholder="Requerido" value="<?php if(isset($clase)) echo $clase; ?>" required><br>
			    </div>			      
			
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>Número interno:</label>			    						    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
			    	<input type="text" class="form-control UpperCase" name="numinterno" placeholder="Requerido" value="<?php if(isset($numinterno)) echo $numinterno; ?>" required><br>	
			    </div>			      
			
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>Número tarjeta de operación:</label>			    						    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
			    	<input type="text" class="form-control" name="numtarjeta" placeholder="Requerido" value="<?php if(isset($numtarjeta)) echo $numtarjeta; ?>" pattern="[0-9]{}" oninvalid="setCustomValidity('Este campo solo acepta números')" onchange="try{setCustomValidity('')}catch(e){}" required><br>	
			    </div>			      
			
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
					<label>Fecha de vencimiento</label>
				</div>
				
				<div id="datetime" class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
					<div class='input-group date Calendario'>
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						<input type='text' name="vencetarjeta" id="vencetarjeta" class="form-control" value="<?php if(isset($vencetarjeta)) echo ''.utf8_decode($vencetarjeta); ?>" required />
					</div><br>
				</div>
										
		    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
		    	<label>Empresa de afiliación del Vehículo:</label>					    	
		    </div>
		    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
		    	<input type="text" class="form-control UpperCase" name="emprvehi" placeholder="" value="<?php if(isset($emprvehi)) echo $emprvehi; ?>" ><br>
		    </div>			      
				<br><br>
		    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
		    	<label>NIT Empresa de afilicación:</label>					    	
		    </div>
		    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
		    	<input type="text" class="form-control" name="nitempresa" placeholder="" value="<?php if(isset($nitempresa)) echo $nitempresa; ?>" ><br>
		    </div>			      
		</div>
				
			<div class="form-group" align="center">                                      
				<div class="">
					<button id="submit" name="submit" type="submit" class="btn btn-success">Crear vehículo</button>
				</div>
			</div>
    <hr>

</form>


<hr>

<?php
	include("function.php");
	if(isset($_POST['submit'])){
		$field = array("placa"=>$_POST['placa'], "modelo"=>$_POST['modelo'], "marca"=>$_POST['marca'], "clase"=>$_POST['clase'], "numinterno"=>$_POST['numinterno'], "numtarjeta"=>$_POST['numtarjeta'], "vencetarjeta"=>$_POST['vencetarjeta'], "emprvehi"=>$_POST['emprvehi'], "nitempresa"=>$_POST['nitempresa']);
		$tbl = "vehiculos";
		insert($tbl,$field);
		
	}
?>
<table class="table table-bordered" width="100%">
	<tr>
		<th style="text-align: center; background:#337ab7;" width="10%"><font color="#FFFFFF">Placa</th>
		<th style="text-align: center; background:#337ab7;" width="5%"><font color="#FFFFFF">Modelo</th>
		<th style="text-align: center; background:#337ab7;" width="10%"><font color="#FFFFFF">Marca</th>
		<th style="text-align: center; background:#337ab7;" width="10%"><font color="#FFFFFF">Clase</th>
		<th style="text-align: center; background:#337ab7;" width="10%"><font color="#FFFFFF">Número Interno</th>
		<th style="text-align: center; background:#337ab7;" width="10%"><font color="#FFFFFF">Tarjeta de Operación</th>
		<th style="text-align: center; background:#337ab7;" width="10%"><font color="#FFFFFF">Vigencia Tarjeta</th>
		<th style="text-align: center; background:#337ab7;" width="10%"><font color="#FFFFFF">Empresa del Vehículo</th>
		<th style="text-align: center; background:#337ab7;" width="10%"><font color="#FFFFFF">NIT Empresa</th>
		<th style="text-align: center; background:#337ab7;" width="10%"><font color="#FFFFFF">Opción</th>

	</tr>
<?php 
	$sql = "select * from vehiculos";
	$result = db_query($sql);
	while($row = mysqli_fetch_object($result)){
	?>
	<tr>
		<td><?php echo $row->placa;?></td>
		<td><?php echo $row->modelo;?></td>
		<td><?php echo $row->marca;?></td>
		<td><?php echo $row->clase;?></td>
		<td><?php echo $row->numinterno;?></td>
		<td><?php echo $row->numtarjeta;?></td>
		<td><?php echo $row->vencetarjeta;?></td>
		<td><?php echo $row->emprvehi;?></td>
		<td><?php echo $row->nitempresa;?></td>


		<td>

<a class="btn btn-success" href="editvehi.php?idvehi=<?php echo $row->idvehi; ?>"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></a>
<a class="btn btn-danger" href="borrvehi.php?idvehi=<?php echo $row->idvehi; ?>" onclick="return Confirmar()"><i class="fa fa-trash-o fa-lg" aria-hidden="true"></i></a>


</td>
	</tr>
	<?php } ?>
</table>
</div>


</div>
</div>
</div>


<script type="text/javascript">
		function Confirmar() {
			if(confirm("Estas seguro que quieres eliminar el registro?"))
			{
				return true;
			}
			return false;
		}
</script>

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