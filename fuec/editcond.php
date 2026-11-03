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
		<div class="panel-title">Editar conductor</div>
	</div>  
					 			
	<div class="panel-body">
<?php 
include("function.php");
$id = $_GET['idcond'];
select_id('conductores','idcond',$id);
?>
<form action="" method="post">

			<div class="form-group row panel-body">
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>Nombres y apellidos:</label>					    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
			    	<input type="text" pattern="[A-Z]{}" class="form-control UpperCase" name="nombcond" placeholder="Requerido" value="<?php echo $row->nombcond;?>" required><br>
			    </div>			      
			
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>Numero de documento de identidad:</label>			    						    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
			    	<input type="text" pattern="[0-9]{6,10}" class="form-control" name="docucond" placeholder="Requerido" value="<?php echo $row->docucond;?>" oninvalid="setCustomValidity('Este campo solo acepta números entre 6 y 10 dígitos')" onchange="try{setCustomValidity('')}catch(e){}" required /><br>	
			    </div>			      
			
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			    	<label>Licencia de conducción:</label>			    						    	
			    </div>
			    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">	
			    	<input type="text" pattern="[0-9]{6,10}" class="form-control" name="licecond" placeholder="Requerido" value="<?php echo $row->licecond;?>" oninvalid="setCustomValidity('Este campo solo acepta números entre 6 y 10 dígitos')" onchange="try{setCustomValidity('')}catch(e){}" required /><br>	
			    </div>			      
			
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
					<label>Fecha de vencimiento de la licencia</label>
				</div>

				<div>
					<div id="datetime" class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
						<div class='input-group date Calendario'>
							<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							<input type='text' name="vigecond" id="txtFecha" class="form-control" placeholder="Requerido" value="<?php echo $row->vigecond;?>" required />
						</div>
					</div>
				</div>				
			</div>

		<div class="form-group" align="center">                                      
				<button name="submit" type="submit" class="btn btn-success">Guardar cambios</button>			
		</div>

</form>

<?php
	
	if(isset($_POST['submit'])){
		$field = array("nombcond"=>$_POST['nombcond'], "docucond"=>$_POST['docucond'], "licecond"=>$_POST['licecond'], "vigecond"=>$_POST['vigecond']);
		$tbl = "conductores";
		edit($tbl,$field,'idcond',$id);
		header("location:boedcond.php");
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