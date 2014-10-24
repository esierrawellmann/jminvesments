<?php
        require_once './../../models/TipoProducto.php';	 
	$request_body = file_get_contents('php://input');
	$request = json_decode($request_body);
	$data = get_object_vars($request);
        $tipoProducto = new TipoProducto();
	switch ($data['action']) {
	    case "insert":
	    	if(isset($data['tipoProductoName'])){
		    	$objtipoProducto = $tipoProducto ->newTipoProducto($data['tipoProductoName']);
		        echo json_encode($objtipoProducto);
	        }
	        break;
	    case "query":
		$objtipoProducto = $tipoProducto ->getTiposProducto();
		        echo json_encode($objtipoProducto);
	    case "update":
	        if(isset($data['tipoProducto'])){
	        	$updatedtipoProducto = $data['tipoProducto'];
	        	$modifiedtipoProducto = get_object_vars($updatedtipoProducto);
	        	$objtipoProducto = $tipoProducto ->updateTipoProducto($modifiedtipoProducto['id_tipo_producto'],$modifiedtipoProducto['nombre']);
	        	echo json_encode($objtipoProducto);
	        }
	        break;
	    case "delete":
		    if(isset($data['tipoProducto'])){
		    	$deletetipoProducto = $data['tipoProducto'];
	        	$deletedtipoProducto = get_object_vars($deletetipoProducto);
	        	$objtipoProducto = $tipoProducto ->deleteTipoProducto($deletedtipoProducto['id_tipo_producto']);
	        	echo json_encode($objtipoProducto);
		    }
		        break;
	}
?>

