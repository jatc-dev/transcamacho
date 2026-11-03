<?php
if (isset($_GET['term'])){
	# conectare la base de datos
 include('./dbcontroller.php');
$db_handle = new DBController();

$return_arr = array();

$sqlc = "SELECT * FROM conductores WHERE nombcond like '%".$_GET['term']."%' LIMIT 5";

$faq = $db_handle->runQuery($sqlc);

foreach($faq as $k=>$v) {
/* Recuperar y almacenar en conjunto los resultados de la consulta.*/		
	$row_array['value'] = $faq[$k]['nombcond'];
	$row_array['buscaconductor3']=$faq[$k]['nombcond']; //para el campo de la busqueda
	
	$row_array['idcond3']=$faq[$k]['idcond'];
	$row_array['nombcond3']=$faq[$k]['nombcond'];
	$row_array['docucond3']=$faq[$k]['docucond'];
	$row_array['licecond3']=$faq[$k]['licecond'];
	$row_array['vigecond3']=$faq[$k]['vigecond'];
	
	array_push($return_arr,$row_array);
}
/* Codifica el resultado del array en JSON. */
echo json_encode($return_arr);
}
?>

