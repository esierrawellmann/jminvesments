<?php
	require_once './../../models/Propiedad.php';	
	$request_body = file_get_contents('php://input');
	$request = json_decode($request_body);
	$data = get_object_vars($request);
	switch ($data['action']) {
	    case "query":
		        $objPropiedad = new Propiedad();
		     	$qryResult = $objPropiedad -> searchForProperties($data['data']);
		     	echo json_encode($qryResult);
    	break;
	}
?>