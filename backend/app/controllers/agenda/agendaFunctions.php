<?php
	require_once './../../models/Agenda.php';	
	require_once './../../models/Usuario.php';	 
	$request_body = file_get_contents('php://input');
	$request = json_decode($request_body);
	$data = get_object_vars($request);
	switch ($data['action']) {

	    case "insert":
	    	if(isset($data['agenda'])){
	    		$gasto = new Agenda();
		     	$objGasto = $gasto -> newEvent($data['agenda']);
		     	$result = $objGasto[0];
		     	echo json_encode($result);
		     }
	        break;
	    case "query":
		        $gasto = new Agenda();
		       	$usuario = new Usuario();   
                    $objGasto = $gasto -> getCitas();
                    $objUsuario = $usuario -> getUsers();

		        echo '{"usuarios":'.json_encode($objUsuario).',"citas":'.json_encode($objGasto).'}';
	    	break;
	    case "update":
	        $gasto = new Agenda();
	        if(isset($data['agenda'])){
	        	$updatedGasto = get_object_vars($data['agenda']);
	        	$objUser = $gasto -> updateAgenda($updatedGasto);
	        	echo json_encode($objUser);
	        }
	        break;
	    case "delete":
		    $gasto = new Agenda();
		    if(isset($data['gasto'])){
		    	$deleteSpend = get_object_vars($data['agenda']);
	        	$objGasto = $gasto -> deleteCita($deleteSpend['id_agenda']);
	        	echo json_encode($objGasto);
		    }
		        break;
	}
?>