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
		<div class="panel-title">Editar contrato</div>
	</div>  
					 			
	<div class="panel-body">
<?php 
include("function.php");
$id = $_GET['idcontrato'];
select_id('contratos','idcontrato',$id);
?>
<form action="" method="post">

			  <div class="form-group row panel-body">
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>Nombres y Apellidos o Razón social del contratante:</label>					    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">													
			    	<input type="text" class="form-control UpperCase" name="contratante" value="<?php echo $row->contratante;?>" required><br>
			    </div>			      
			
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>NIT/CC:</label>			    						    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
			    	<input type="text" class="form-control" name="nitcontratante" value="<?php echo $row->nitcontratante;?>" pattern="[0-9]{7,10}" oninvalid="setCustomValidity('Este campo solo acepta números entre 7 y 10 dígitos')" onchange="try{setCustomValidity('')}catch(e){}" required><br>	
			    </div>			      
			
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>Objeto del contrato:</label>					    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
			    	<select class="form-control" name="objetocontrato" value="" style="background-color: white; height:auto" required>
			    		<option selected><?php echo $row->objetocontrato;?></option>
			    		<option>TRANSPORTE PARA UN GRUPO ESPECÍFICO DE USUARIOS - TRANSPORTE DE PARTICULARES ASIGNADOS Y/O AUTORIZADOS POR EL CONTRATANTE.</option>
			    		<option>TRANSPORTE EMPRESARIAL - TRANSPORTE DE FUNCIONARIOS, SOCIOS, EMPLEADOS, CONTRATISTAS, AFILIADOS, CLIENTES, BENEFICIARIOS, VISITANTES, ACOMPAÑANTES ASIGNADOS Y/O AUTORIZADOS POR EL CONTRATANTE.</option>
			    	</select><br>
			    </div>			      
			
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>Responsable del contratante:</label>					    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
			    	<input type="text" class="form-control UpperCase" name="respcont" value="<?php echo $row->respcont;?>" required><br>
			    </div>			      
			
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>Documento del responsable:</label>			    						    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
			    	<input type="text" pattern="[0-9]{6,10}" class="form-control" name="docuresp" value="<?php echo $row->docuresp;?>" oninvalid="setCustomValidity('Este campo solo acepta números entre 6 y 10 dígitos')" onchange="try{setCustomValidity('')}catch(e){}" required /><br>	
			    </div>			      
			
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>Teléfono del responsable:</label>			    						    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
			    	<input type="text" pattern="[0-9]{7,10}" class="form-control" name="teleresp"  value="<?php echo $row->teleresp;?>" oninvalid="setCustomValidity('Este campo solo acepta números entre 7 y 10 dígitos')" onchange="try{setCustomValidity('')}catch(e){}" required /><br>	
			    </div>			      
			
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>Dirección del responsable:</label>					    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
			    	<input type="text" class="form-control UpperCase" name="direresp" value="<?php echo $row->direresp;?>" required><br>
			    </div>			      
			</div>

		<div class="form-group" align="center">                                      
			<div>
				<button name="submit" type="submit" class="btn btn-success">Guardar cambios</button>
			</div>
		</div>

</form>

<?php
	
	if(isset($_POST['submit'])){
		$field = array("contratante"=>$_POST['contratante'], "nitcontratante"=>$_POST['nitcontratante'], "objetocontrato"=>$_POST['objetocontrato'], "respcont"=>$_POST['respcont'], "docuresp"=>$_POST['docuresp'], "teleresp"=>$_POST['teleresp'], "direresp"=>$_POST['direresp']);
		$tbl = "contratos";
		edit($tbl,$field,'idcontrato',$id);
		header("location:boedcont.php");
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