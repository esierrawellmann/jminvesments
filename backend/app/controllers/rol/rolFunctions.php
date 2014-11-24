<?php
	require_once './../../models/Rol.php';	 

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
	        	$updatedRol = $data['rol'];
	        	$modifiedRol = get_object_vars($updatedRol);
	        	$objRol = $rol -> updateRole($modifiedRol['id_role'],$modifiedRol['nombre']);
	        	echo json_encode($objRol);
	        }
	        break;
	    case "delete":
		    $rol = new Rol();
		    if(isset($data['rol'])){
		    	$deleteRol = $data['rol'];
	        	$deletedRol = get_object_vars($deleteRol);
	        	$objRol = $rol -> deleteRole($deletedRol['id_role']);
	        	echo json_encode($objRol);
		    }
		        break;
	}
?>