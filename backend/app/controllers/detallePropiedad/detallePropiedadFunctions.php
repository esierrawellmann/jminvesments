<?php
	require_once './../../models/DetallePropiedad.php';	
	require_once './../../models/Propiedad.php';	 
	$request_body = file_get_contents('php://input');
	$request = json_decode($request_body);
	$data = get_object_vars($request);
	switch ($data['action']) {

	    case "insert":
	    	if(isset($data['detallePropiedad'])){
	    		$dcompra = new DetalleCompra();
		     	$objCompra = $dcompra ->newDetalleCompra($data['detalleCompra'],$data['compra']);
		     	$result = $objCompra[0];
		     	echo json_encode($result);

		     }
	        break;
	    case "query":
	    		$compraData = get_object_vars($data['detallePropiedad']);
		        $detalleCompra = new DetallePropiedad();
		        $objCompra = $detalleCompra ->getDetallePropiedades($compraData['id_propiedad']);

		        echo '{"detalleCompras":'.json_encode($objCompra).',"compra":'.json_encode($compraData).'}';
	    	break;
	    case "update":
	        if(isset($data['detalleCompra'])){
	        	$compraData = new DetalleCompra();
				$updatedDetalle = get_object_vars($data['detalleCompra']);
	        	$objUser = $compraData ->updateDetalleCompra($updatedDetalle);
	        	echo json_encode($objUser);
	        }
	        break;
	    case "delete":
		    
		    if(isset($data['detalleCompra'])){
		    	$detalle = new DetalleCompra();
		    	$deleteDetail = get_object_vars($data['detalleCompra']);

	        	$objCompra = $detalle ->deleteDetalleCompra($deleteDetail['id_detalle_compra']);
	        	echo json_encode($objCompra);
		    }
		        break;
	}
?>
