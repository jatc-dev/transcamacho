<?php
if (isset($_GET['term'])){
	# conectare la base de datos
 include('./dbcontroller.php');
$db_handle = new DBController();

$return_arr = array();

$sqlc = "SELECT DISTINCT contratante FROM fuec WHERE contratante like '%".$_GET['term']."%' LIMIT 5";

$faq = $db_handle->runQuery($sqlc);

foreach($faq as $k=>$v) {
/* Recuperar y almacenar en conjunto los resultados de la consulta.*/		
	$row_array['value'] = $faq[$k]['contratante'];
	$row_array['contratante']=$faq[$k]['contratante']; //para el campo de la busqueda
	
	
	array_push($return_arr,$row_array);
}
/* Codifica el resultado del array en JSON. */
echo json_encode($return_arr);
}
?>