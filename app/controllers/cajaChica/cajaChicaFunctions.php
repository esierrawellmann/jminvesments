<?php
	require_once './../../models/CajaChica.php';	 
	$request_body = file_get_contents('php://input');
	$request = json_decode($request_body);
	$data = get_object_vars($request);
        $caja = new CajaChica();
	switch ($data['action']) {
	    case "query":
		$objCaja = $caja ->getCajaChica();
		        echo json_encode($objCaja);
	    case "update":
	        if(isset($data['caja'])){
	        	$updatedCaja = $data['caja'];
	        	$modifiedCaja = get_object_vars($updatedCaja);
	        	$objPermiso = $caja ->updateCompra($modifiedCaja['id_caja'],$modifiedCaja['cantidad']);
	        	echo json_encode($objPermiso);
	        }
	        break;
	}
?>