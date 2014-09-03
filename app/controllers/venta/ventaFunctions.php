<?php
	require_once './../../models/Venta.php';	
	require_once './../../models/Usuario.php';	 
	$request_body = file_get_contents('php://input');
	$request = json_decode($request_body);
	$data = get_object_vars($request);
	switch ($data['action']) {

	    case "insert":
	    	if(isset($data['venta'])){
	    		$venta = new Venta();
		     	$objVenta = $venta -> newVenta($data['venta']);
		     	$result = $objVenta[0];
		     	echo json_encode($result);

		     }
	        break;
	    case "query":
		        $venta = new Venta();
		        $objVenta = $venta -> getVentas();
		       	$usuario = new Usuario();
		       	$objUsuario = $usuario -> getUsers();

		        echo '{"usuarios":'.json_encode($objUsuario).',"ventas":'.json_encode($objVenta).'}';
	    	break;
	    case "update":
	        if(isset($data['venta'])){
	        	$venta = new Venta();
	        	$updatedVenta = get_object_vars($data['venta']);
	        	$objUser = $venta -> updateVenta($updatedVenta);
	        	echo json_encode($objUser);
	        }
	        break;
	    case "delete":
		    if(isset($data['venta'])){
		    	$venta = new Venta();
		    	$deleteVenta = get_object_vars($data['venta']);
	        	$objVenta = $venta -> deleteVenta($deleteVenta['id_venta']);
	        	echo json_encode($objVenta);
		    }
		        break;
	}
?>