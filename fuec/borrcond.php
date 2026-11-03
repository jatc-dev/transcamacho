<?php
include("function.php");
$idcond = $_GET['idcond'];
delete('conductores','idcond',$idcond);
header("location:boedcond.php");
?>