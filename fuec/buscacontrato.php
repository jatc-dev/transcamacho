<?php
if (isset($_GET['term'])){
	# conectare la base de datos
 include('./dbcontroller.php');
$db_handle = new DBController();

$return_arr = array();

$sqlc = "SELECT * FROM contratos WHERE contratante like '%".$_GET['term']."%' LIMIT 5";

$faq = $db_handle->runQuery($sqlc);

foreach($faq as $k=>$v) {
/* Recuperar y almacenar en conjunto los resultados de la consulta.*/		
	$row_array['value'] = $faq[$k]['contratante'];
	$row_array['buscacontrato']=$faq[$k]['contratante']; //para el campo de la busqueda
	
	$row_array['idcontrato']=$faq[$k]['idcontrato'];
	$row_array['contratante']=$faq[$k]['contratante'];
	$row_array['nitcontratante']=$faq[$k]['nitcontratante'];
	$row_array['objetocontrato']=$faq[$k]['objetocontrato'];
	$row_array['respcont']=$faq[$k]['respcont'];
	$row_array['docuresp']=$faq[$k]['docuresp'];
	$row_array['teleresp']=$faq[$k]['teleresp'];
	$row_array['direresp']=$faq[$k]['direresp'];
	
	array_push($return_arr,$row_array);
}
/* Codifica el resultado del array en JSON. */
echo json_encode($return_arr);
}
?>

