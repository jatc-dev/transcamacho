<?php
session_start(); //Iniciar una nueva sesión o reanudar la existente

  if(!isset($_SESSION["id_usuario"])){ //Si no ha iniciado sesión redirecciona a index.php
    header("Location: crearusuario.php");
  }
  
  $idUsuario = $_SESSION['id_usuario'];
  
  $sql = "SELECT id, nombre, tipo_usuario FROM usuarios WHERE id = '$idUsuario'";
  $result = $mysqli->query($sql);
  
  $row = $result->fetch_assoc();
	
  $errors = array();

  if(isset($_SESSION['tiempo']) ) {

        //Tiempo en segundos para dar vida a la sesión.
        $inactivo = 3000;

        //Calculamos tiempo de vida inactivo.
        $vida_session = time() - $_SESSION['tiempo'];

            //Compraración para redirigir página, si la vida de sesión sea mayor a el tiempo insertado en inactivo.
            if($vida_session > $inactivo)
            {
                //Removemos sesión.
                session_unset();
                //Destruimos sesión.
                session_destroy();              
                //Redirigimos pagina.
                header("location: index.php");

                exit();
            }

    }
    $_SESSION['tiempo'] = time();

?>