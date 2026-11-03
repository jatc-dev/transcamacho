<?php
include("function.php");
$id = $_GET['idvehi'];
delete('vehiculos','idvehi',$id);
header("location:boedvehi.php");
?>