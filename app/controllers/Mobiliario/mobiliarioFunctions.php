<?php
	require_once './../../models/Mobiliario.php';	
	require_once './../../models/Usuario.php';	 
	$request_body = file_get_contents('php://input');
	$request = json_decode($request_body);
	$data = get_object_vars($request);
	switch ($data['action']) {
	    case "insert":
	    	if(isset($data['mobiliario'])){
	    		$vale = new Mobiliario();
		     	$objVale = $vale ->newMobiliario($data['mobiliario']);
		     	$result = $objVale[0];
		     	echo json_encode($result);

		     }
	        break;
	    case "query":
		        $vale = new Mobiliario();
		        $objVale= $vale ->getMobiliario();

		       	$usuario = new Usuario();
		       	$objUsuario = $usuario ->getUsers();

		        echo '{"mobiliarios":'.json_encode($objVale).',"usuarios":'.json_encode($objUsuario).'}';
	    	break;
	    case "update":
	        if(isset($data['mobiliario'])){
	        	$vale = new Mobiliario();
	        	$updatedVale = get_object_vars($data['mobiliario']);
	        	$objvale = $vale ->updateMobiliario($updatedVale);
	        	echo json_encode($objvale);
	        }
	        break;
	    case "delete":
		    if(isset($data['mobiliario'])){
		    	$vale = new Mobiliario();
	        	$updatedVale = get_object_vars($data['mobiliario']);
	        	$objvale = $vale ->deleteMobiliario($updatedVale['id_mobiliario']);
	        	echo json_encode($objvale);
		    }
		        break;
	}
?>
