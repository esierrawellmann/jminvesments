<?php
	require_once '../../models/Venta.php';	
	require_once '../../models/Usuario.php';	 
	$request_body = file_get_contents('php://input');
	$request = json_decode($request_body);
	$data = get_object_vars($request);
	switch ($data['action']) {

	    case "insert":
	    	if(isset($data['gasto'])){
	    		$gasto = new Gasto();
		     	$objGasto = $gasto -> newGasto($data['gasto']);
		     	$result = $objGasto[0];
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
	        $gasto = new Gasto();
	        if(isset($data['gasto'])){
	        	$updatedGasto = get_object_vars($data['gasto']);
	        	$objUser = $gasto -> updateGasto($updatedGasto);
	        	echo json_encode($objUser);
	        }
	        break;
	    case "delete":
		    $gasto = new Gasto();
		    if(isset($data['gasto'])){
		    	$deleteSpend = get_object_vars($data['gasto']);
	        	$objGasto = $gasto -> deleteSpend($deleteSpend['id_gasto']);
	        	echo json_encode($objRol);
		    }
		        break;
	}
?>