<?php
	require_once './../../models/DetallePropiedad.php';	
	require_once './../../models/Propiedad.php';	 
	$request_body = file_get_contents('php://input');
	$request = json_decode($request_body);
	$data = get_object_vars($request);
	switch ($data['action']) {

	    case "insert":
	    	if(isset($data['detallePropiedad'])){
	    		$dcompra = new DetallePropiedad();
		     	$objCompra = $dcompra ->newDetallePropiedad($data['detallePropiedad'],$data['propiedad']);
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
	    case "delete":
		    
		    if(isset($data['detallePropiedad'])){
		    	$detalle = new DetallePropiedad();
		    	$deleteDetail = get_object_vars($data['detallePropiedad']);

	        	$objCompra = $detalle ->deleteDetallePropiedad($deleteDetail['id_detalle_propiedad']);
                        $url = "C:/Users/Brian/Pictures/".$deleteDetail['id_propiedad']."/".$deleteDetail['nombre'];
                        
	        	echo unlink($url);
		    }
		        break;
	}
?>
