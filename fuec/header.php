<?php
declare(strict_types=1);

require 'conexion.php';
include 'sessionstart.php';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>TransCamachoTours</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/7a00a4bd48.js" crossorigin="anonymous"></script>

    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
    <link rel="manifest" href="img/favicon/site.webmanifest">
    <link rel="mask-icon" href="img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>

<body style="background:#E1F5FE;">

<div class="wrapper">
    <nav id="sidebar">
        <div class="sidebar-header">
            <img src="img/logo.png" style="width:200px;" alt="Logo Transcamacho">
        </div>

        <ul class="list-unstyled components" style="margin-top: -20px;">
            <li class="active">
                <a href="welcome.php"><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;&nbsp;
                    <?php echo $nombreUsuario; ?>
                </a>
            </li>

            <li>
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;&nbsp;FUEC</a>
                <ul class="collapse list-unstyled" id="homeSubmenu">
                    <li><a href="crearfuec.php"><span class="glyphicon glyphicon-list-alt" style='font-size:150%'></span>&nbsp;&nbsp;&nbsp;Crear</a></li>
                    <li><a href="listarfuec.php"><span class="glyphicon glyphicon-list" style='font-size:150%'></span>&nbsp;&nbsp;&nbsp;Ver listado</a></li>
                    <li><a href="descfuecpdfqr.php"><span class='far fa-file-pdf' style='font-size:150%'></span>&nbsp;&nbsp;&nbsp;Descargar PDF</a></li>
                </ul>
            </li>

            <?php if ($tipoUsuario === 'Administrador'): ?>
                <li><a href="crearusuario.php"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;&nbsp;Crear Usuarios</a></li>
            <?php endif; ?>

            <li>
                <a href="boedcont.php"><span class="glyphicon glyphicon-ok-circle"></span>&nbsp;&nbsp;&nbsp;Contratos</a>
                <a href="boedvehi.php"><span class="fas fa-car"></span>&nbsp;&nbsp;&nbsp;Vehículos</a>
                <a href="boedcond.php"><span class="fas fa-user-tie"></span>&nbsp;&nbsp;&nbsp;Conductores</a>
                <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;&nbsp;&nbsp;Cerrar sesión</a>
            </li>
        </ul>
    </nav>

    <div id="content">
        <div class="encabezado">
            <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                <i class="glyphicon glyphicon glyphicon-list"></i>
                <span>&nbsp;&nbsp;&nbsp;Menú</span>
            </button>
            <h4>&nbsp;&nbsp;&nbsp;Sistema para la gestión de extractos de contrato</h4>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                $("#sidebarCollapse").on("click", function() {
                    $("#sidebar").toggleClass("active");
                    $(this).toggleClass("active");
                });
            });
        </script>
    </div>
</div>
