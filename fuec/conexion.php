<?php
	
	$mysqli=new mysqli("localhost","u910043597_fuec","Fuec2021","u910043597_fuec"); //servidor, usuario de base de datos, contraseña del usuario, nombre de base de datos
	
	if(mysqli_connect_errno()){
		echo 'Conexion Fallida : ', mysqli_connect_error();
		exit();
	}
	
?>