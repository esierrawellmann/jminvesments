<?php
	require_once '../../../backend/app/models/Propiedad.php';	
	$request_body = file_get_contents('php://input');
	$request = json_decode($request_body);
	$data = get_object_vars($request);
	switch ($data['action']) {
	    case "query":
		        $objPropiedad = new Propiedad();
		     	$qryResult = $objPropiedad -> searchForProperties($data['data']);
		     	echo var_dump($qryResult);
    	break;
	}
?>