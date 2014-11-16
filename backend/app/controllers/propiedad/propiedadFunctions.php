<?php
	require_once './../../models/Propiedad.php';		 
	$request_body = file_get_contents('php://input');
	$request = json_decode($request_body);
	$data = get_object_vars($request);
	switch ($data['action']) {

	    case "insert":
	    	if(isset($data['propiedad'])){
	    		$propiedad = new Propiedad();
		     	$objPropiedad = $propiedad ->newPropiedad($data['propiedad']);
		     	$result = $objPropiedad[0];
		     	echo json_encode($result);
		     }
	        break;
	    case "query":
		    $propiedad = new Propiedad();  
                    $objGasto = $propiedad ->getPropiedades();
                    echo '{"compras":'.json_encode($objGasto).'}';
	    	break;
	    case "update":
	        $propiedad = new Propiedad();
	        if(isset($data['propiedad'])){
	        	$objUser = $propiedad ->updatePropiedad($data['propiedad']);
	        	echo json_encode($objUser);
	        }
	        break;
        case "detail":
        $propiedad = new Propiedad();
        if(isset($data['propiedad'])){
        	$prop = get_object_vars($data['propiedad']); 
        	$objUser = $propiedad ->getPropertyById($prop['id_propiedad']);
        	echo json_encode($objUser);
        }
        break;
	    case "delete":
		    $propiedad = new Propiedad();
		    if(isset($data['propiedad'])){
		    	$prop = get_object_vars($data['propiedad']); 
	        	$objGasto = $propiedad->deletePropiedad($prop['id_propiedad']);
	        	echo json_encode($objGasto);
		    }
		        break;
	}
?>
