<?php
	  require 'funciones.php';
	  include 'header.php';
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title></title>

<!-- datetimepicker -->
		<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet"/>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/locale/es.js"></script>

		<script type="text/javascript">
		function Confirmar() {
			if(confirm("Estas seguro que quieres eliminar el registro?"))
			{
				return true;
			}
			return false;
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
<form action="" method="post">
  <div class="form-group row panel-body">
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>Nombres y Apellidos o Razón social del contratante:</label>					    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
			    	<input type="text" class="form-control UpperCase" name="contratante" placeholder="- - -" value="<?php if(isset($contratante)) echo $contratante; ?>" required><br>
			    </div>			      
			
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>NIT/CC:</label>			    						    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
			    	<input type="text" class="form-control" name="nitcontratante" placeholder="Nit sin digito de verificación" value="<?php if(isset($nitcontratante)) echo $nitcontratante; ?>" pattern="[0-9]{7,10}" oninvalid="setCustomValidity('Este campo solo acepta números entre 7 y 10 dígitos')" onchange="try{setCustomValidity('')}catch(e){}" required><br>	
			    </div>			      
			
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>Objeto del contrato:</label>					    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
			    	<select class="form-control" name="objetocontrato" value="<?php if(isset($objetocontrato)) echo $objetocontrato;?>" style="background-color: white; height:auto" required>
			    		<option disabled selected>Selecciona</option>
			    		<option>TRANSPORTE PARA UN GRUPO ESPECÍFICO DE USUARIOS - TRANSPORTE DE PARTICULARES ASIGNADOS Y/O AUTORIZADOS POR EL CONTRATANTE.</option>
			    		<option>TRANSPORTE EMPRESARIAL - TRANSPORTE DE FUNCIONARIOS, SOCIOS, EMPLEADOS, CONTRATISTAS, AFILIADOS, CLIENTES, BENEFICIARIOS, VISITANTES, ACOMPAÑANTES ASIGNADOS Y/O AUTORIZADOS POR EL CONTRATANTE.</option>
			    	</select><br>
			    </div>			      
			
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>Responsable del contratante:</label>					    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
			    	<input type="text" class="form-control UpperCase" name="respcont" placeholder="Requerido" value="<?php if(isset($respcont)) echo $respcont; ?>" required><br>
			    </div>			      
			
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>Documento del responsable:</label>			    						    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
			    	<input type="text" pattern="[0-9]{6,10}" class="form-control" name="docuresp" placeholder="Requerido" value="<?php if(isset($docuresp)) echo $docuresp; ?>" oninvalid="setCustomValidity('Este campo solo acepta números entre 6 y 10 dígitos')" onchange="try{setCustomValidity('')}catch(e){}" required /><br>	
			    </div>			      
			
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>Teléfono del responsable:</label>			    						    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
			    	<input type="text" pattern="[0-9]{7,10}" class="form-control" name="teleresp" placeholder="Requerido" value="<?php if(isset($teleresp)) echo $teleresp; ?>" oninvalid="setCustomValidity('Este campo solo acepta números entre 7 y 10 dígitos')" onchange="try{setCustomValidity('')}catch(e){}" required /><br>	
			    </div>			      
			
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>Dirección del responsable:</label>					    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
			    	<input type="text" class="form-control UpperCase" name="direresp" placeholder="Requerido" value="<?php if(isset($direresp)) echo $direresp; ?>" required><br>
			    </div>			      
			</div>
				
			<div class="form-group" align="center">                                      
				<div class="">
					<button id="submit" name="submit" type="submit" class="btn btn-success">Crear contrato</button>
				</div>
			</div>
    <hr>
</form>


<?php
	include("function.php");
	if(isset($_POST['submit'])){
		$field = array("contratante"=>$_POST['contratante'], "nitcontratante"=>$_POST['nitcontratante'], "objetocontrato"=>$_POST['objetocontrato'], "respcont"=>$_POST['respcont'], "docuresp"=>$_POST['docuresp'], "teleresp"=>$_POST['teleresp'], "direresp"=>$_POST['direresp']);
		$tbl = "contratos";
		insert($tbl,$field);
		
	}
?>
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
<?php 
	$sql = "select * from contratos";
	$result = db_query($sql);
	while($row = mysqli_fetch_object($result)){
	?>
	<tr>
		<td><?php echo $row->contratante;?></td>
		<td><?php echo $row->nitcontratante;?></td>
		<td><?php echo $row->objetocontrato;?></td>
		<td><?php echo $row->respcont;?></td>
		<td><?php echo $row->docuresp;?></td>
		<td><?php echo $row->teleresp;?></td>
		<td><?php echo $row->direresp;?></td>

		<td>

<a class="btn btn-success" href="editcont.php?idcontrato=<?php echo $row->idcontrato; ?>"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></a>
<a class="btn btn-danger" href="borrcont.php?idcontrato=<?php echo $row->idcontrato; ?>" onclick="return Confirmar()"><i class="fa fa-trash-o fa-lg" aria-hidden="true"></i></a>


</td>
	</tr>
	<?php } ?>
</table>
</div>


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