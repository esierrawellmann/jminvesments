<?php
        require_once '../../models/TipoProducto.php';	 
	$request_body = file_get_contents('php://input');
	$request = json_decode($request_body);
	$data = get_object_vars($request);
        $tipoProducto = new Permiso();
	switch ($data['action']) {
	    case "insert":
	    	if(isset($data['tipoProducto'])){
		    	$objtipoProducto = $tipoProducto ->newTipoProducto($data['tipoProducto']);
		        echo json_encode($objtipoProducto);
	        }
	        break;
	    case "query":
		$objtipoProducto = $tipoProducto ->getTiposProducto();
		        echo json_encode($objtipoProducto);
	    case "update":
	        if(isset($data['permiso'])){
	        	$updatedtipoProducto = $data['tipoProducto'];
	        	$modifiedtipoProducto = get_object_vars($updatedtipoProducto);
	        	$objtipoProducto = $tipoProducto ->updateTipoProducto($modifiedtipoProducto['id_tipo_producto'],$modifiedtipoProducto['nombre']);
	        	echo json_encode($objtipoProducto);
	        }
	        break;
	    case "delete":
		    if(isset($data['permiso'])){
		    	$deletetipoProducto = $data['tipoProducto'];
	        	$deletedtipoProducto = get_object_vars($deletetipoProducto);
	        	$objtipoProducto = $tipoProducto ->deleteTipoProducto($deletedtipoProducto['id_tipo_producto']);
	        	echo json_encode($objtipoProducto);
		    }
		        break;
	}
?>

