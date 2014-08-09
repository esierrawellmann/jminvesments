<?php
	require_once '../../models/Rol.php';	 
	$request_body = file_get_contents('php://input');
	$request = json_decode($request_body);
	$data = get_object_vars($request);
	switch ($data['action']) {
	    case "insert":
	    	$rol = new Rol();
	    	if(isset($data['rolName'])){
		    	$objRol = $rol -> newRole($data['rolName']);
		        echo json_encode($objRol);
	        }
	        break;
	    case "query":
		        $rol = new Rol();
		        $objRol = $rol -> getRoles();
		        echo json_encode($objRol);
	    	break;
	    case "update":
	        $rol = new Rol();
	        if(isset($data['rol'])){
	        	//$objRol = $rol -> updateRole($data['rolId'],$data['rolName']);
	        	echo json_encode($data['rol']);
	        }
	        break;
	}
?>