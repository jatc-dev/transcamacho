<?php	
	session_start(); //Iniciar una nueva sesión o reanudar la existente

	require 'conexion.php';
	include 'funciones.php';
	
	if(isset($_SESSION["id_usuario"])){ //En caso de existir la sesión redireccionamos
		header("Location: crearfuec.php");
	}
	
	$errors = array();
	
	if(!empty($_POST))
	{
		$usuario = $mysqli->real_escape_string($_POST['usuario']);
		$password = $mysqli->real_escape_string($_POST['password']);
		
		if(isNullLogin($usuario, $password))
		{
			$errors[] = "Debe llenar todos los campos";
		}
		
		$errors[] = login($usuario, $password);	
	}	
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <title>Trans Camacho Tours</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


<!-- Favicons -->
  <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
  <link rel="manifest" href="img/favicon/site.webmanifest">
  <link rel="mask-icon" href="img/favicon/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">
	

	<link rel="stylesheet" type="text/css" href="css/estilos.css">


  </head>
  <body>
	<header style="justify-content: center; align-items:center; height: auto;" >	
		<div id="logo"><img src="img/logo.png" style="height: 100px;"></div>
  	<div id="textlogo" style="margin-left: 0px;"><i><h3>Trans Camacho Tours S.A.S.</h3><h4>Sistema para la gestión de extractos de contrato</h4></i></div>
	</header>



	<div class="container">    
		<div id="loginbox" style="margin-top:180px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
			<div class="panel panel-primary" >
				<div class="panel-heading">
					<div class="panel-title">Iniciar Sesi&oacute;n</div>
					
			<!--	<div class="panel-title" style="float:right; font-size: 80%; position: relative; top:-10px"><a href="recupera.php">¿Se te olvid&oacute; tu contraseña?</a></div>-->  
				</div>   
			
			<div style="padding-top:30px" class="panel-body" >
				
				<div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
				
				<form id="loginform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
					
					<div style="margin-bottom: 25px" class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input id="usuario" type="text" class="form-control" name="usuario" value="" placeholder="usuario" required>
					</div>
					
					<div style="margin-bottom: 25px" class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input id="password" type="password" class="form-control" name="password" placeholder="contrase&ntilde;a" required>
					</div>
					
					<div style="margin-top:10px" class="form-group" align="center">
						<div class="col-sm-12 controls">
							<button id="btn-login" type="submit" class="btn btn-primary">Ingresar</a>
						</div>
					</div>
				
					<div class="form-group">
						<div class="col-md-12 control">
					<!--		<div class="panel-title" style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
								No tienes una cuenta! <a href="registro.php"><b style="color: #007336">Reg&iacute;strate aquí</b></a>
							</div> -->
						</div>
					</div>    
				</form>
				<?php echo resultBlock($errors); ?>
			</div>                     
			</div>  
		</div>
	</div>

</body>

</html>