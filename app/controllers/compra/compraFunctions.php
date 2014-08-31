<?php
	require_once '../../models/Compra.php';	
	require_once '../../models/Usuario.php';	 
	$request_body = file_get_contents('php://input');
	$request = json_decode($request_body);
	$data = get_object_vars($request);
	switch ($data['action']) {

	    case "insert":
	    	if(isset($data['compra'])){
	    		$compra = new Compra();
		     	$objcompra = $compra ->newCompra($data['compra']);
		     	$result = $objcompra[0];
		     	echo json_encode($result);

		     }
	        break;
	    case "query":
		        $compra = new Compra();
		        $objcompra = $compra->getCompras();

		       	$usuario = new Usuario();
		       	$objtipousuario = $usuario ->getUsers();

		        echo '{"compras":'.json_encode($objcompra).',"usuarios":'.json_encode($objtipousuario).'}';
	    	break;
	    case "update":
	        if(isset($data['compra'])){
	        	$compra = new Compra();
	        	$updatedcompra = get_object_vars($data['compra']);
	        	$objcompra = $compra->updateCompra($updatedcompra);
	        	echo json_encode($objcompra);
	        }
	        break;  
	    case "delete":
		    if(isset($data['compra'])){
                        $compra = new Compra();
		    	$deleteCompra = get_object_vars($data['compra']);
	        	$objCompra = $compra ->deleteCompra($deleteCompra['id_compra']);
	        	echo json_encode($objCompra);
		    }
		        break;
	}
?>
