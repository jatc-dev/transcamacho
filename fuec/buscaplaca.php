<?php
if (isset($_GET['term'])){
	# conectare la base de datos
 include('./dbcontroller.php');
$db_handle = new DBController();

$return_arr = array();

$sqlc = "SELECT * FROM vehiculos WHERE placa like '%".$_GET['term']."%' LIMIT 5";

$faq = $db_handle->runQuery($sqlc);

foreach($faq as $k=>$v) {
/* Recuperar y almacenar en conjunto los resultados de la consulta.*/		
	$row_array['value'] = $faq[$k]['placa'];
	$row_array['buscaplaca']=$faq[$k]['placa']; //para el campo de la busqueda
	
	$row_array['idvehi']=$faq[$k]['idvehi'];
	$row_array['placa']=$faq[$k]['placa'];
	$row_array['modelo']=$faq[$k]['modelo'];
	$row_array['marca']=$faq[$k]['marca'];
	$row_array['clase']=$faq[$k]['clase'];
	$row_array['numinterno']=$faq[$k]['numinterno'];
	$row_array['numtarjeta']=$faq[$k]['numtarjeta'];
	$row_array['emprvehi']=$faq[$k]['emprvehi'];
	
	array_push($return_arr,$row_array);
}
/* Codifica el resultado del array en JSON. */
echo json_encode($return_arr);
}
?>