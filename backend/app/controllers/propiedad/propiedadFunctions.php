<?php
	require_once './../../models/Propiedad.php';		 
	$request_body = file_get_contents('php://input');
	$request = json_decode($request_body);
	$data = get_object_vars($request);
	switch ($data['action']) {

	    case "insert":
	    	if(isset($data['propiedad'])){
	    		$propiedad = new Propiedad();
		     	$objPropiedad = $propiedad ->newPropiedad($propiedad);
		     	$result = $objPropiedad[0];
		     	echo json_encode($result);
		     }
	        break;
	    case "query":
		    $propiedad = new Propiedad();  
                    $objGasto = $propiedad ->getPropiedades();
                    echo json_encode($objGasto);
	    	break;
	    case "update":
	        $propiedad = new Propiedad();
	        if(isset($data['propiedad'])){
	        	$updatedPropiedad = get_object_vars($data['propiedad']);
	        	$objUser = $propiedad ->updatePropiedad($updatedPropiedad);
	        	echo json_encode($objUser);
	        }
	        break;
	    case "delete":
		    $propiedad = new Propiedad();
		    if(isset($data['propiedad'])){
		    	$deletePropiedad = get_object_vars($data['propiedad']);
	        	$objGasto = $propiedad -> deleteCita($deletePropiedad['id_propiedad']);
	        	echo json_encode($objGasto);
		    }
		        break;
	}
?>
