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
<div class="container" style="margin-top:60px">
  

<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="panel-title">Agregar/Editar conductor</div>
	</div>  
					 			
	<div class="panel-body">
<form action="" method="post">
  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    <input class="form-control UpperCase" name="nombcond" type="text" pattern="[A-Za-z]{4-50}" oninvalid="setCustomValidity('Este campo solo acepta letras')" onchange="try{setCustomValidity('')}catch(e){}" placeholder="Nombres y apellidos" required>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
    <input class="form-control" name="docucond" type="text" pattern="[0-9]{6,10}" oninvalid="setCustomValidity('Este campo solo acepta números entre 6 y 10 dígitos')" onchange="try{setCustomValidity('')}catch(e){}" placeholder="Cédula" required>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
    <input class="form-control" name="licecond" type="text" pattern="[0-9]{6,10}" oninvalid="setCustomValidity('Este campo solo acepta números entre 6 y 10 dígitos')" onchange="try{setCustomValidity('')}catch(e){}" placeholder="Licencia" required>
  </div>
					
	<div id="datetime" class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
		<div class='input-group date Calendario'>
			<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			<input type='text' name="vigecond" id="txtFecha" class="form-control" placeholder="Vigencia" value="<?php if(isset($vigecond)) echo ''.utf8_decode($vigecond); ?>" required />
		</div>
	</div>
				

    
	<input type="submit" name="submit" class="btn btn-success" value="Agregar conductor">
</form>


<hr>

<?php
	include("function.php");
	if(isset($_POST['submit'])){
		$field = array("nombcond"=>$_POST['nombcond'], "docucond"=>$_POST['docucond'], "licecond"=>$_POST['licecond'], "vigecond"=>$_POST['vigecond']);
		$tbl = "conductores";
		insert($tbl,$field);
		
	}
?>
<table class="table table-bordered" width="100%">
	<tr>
		<th style="text-align: center; background:#337ab7;" width="45%"><font color="#FFFFFF">Nombres y apellidos</th>
		<th style="text-align: center; background:#337ab7;" width="15%"><font color="#FFFFFF">Cédula</th>
		<th style="text-align: center; background:#337ab7;" width="15%"><font color="#FFFFFF">Licencia</th>
		<th style="text-align: center; background:#337ab7;" width="15%"><font color="#FFFFFF">Vigencia</th>
		<th style="text-align: center; background:#337ab7;" width="10%"><font color="#FFFFFF">Opción</th>
	</tr>
<?php 
	$sql = "select * from conductores";
	$result = db_query($sql);
	while($row = mysqli_fetch_object($result)){
	?>
	<tr>
		<td><?php echo $row->nombcond;?></td>
		<td><?php echo $row->docucond;?></td>
		<td><?php echo $row->licecond;?></td>
		<td><?php echo $row->vigecond;?></td>
		<td>

<a class="btn btn-success" href="editcond.php?idcond=<?php echo $row->idcond; ?>"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></a>
<a class="btn btn-danger" href="borrcond.php?idcond=<?php echo $row->idcond; ?>" onclick="return Confirmar()"><i class="fa fa-trash-o fa-lg" aria-hidden="true"></i></a>


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