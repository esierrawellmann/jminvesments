<?php
	require_once '../../models/Permiso.php';	 
	$request_body = file_get_contents('php://input');
	$request = json_decode($request_body);
	$data = get_object_vars($request);
        $permiso = new Permiso();
	switch ($data['action']) {
	    case "insert":
	    	if(isset($data['permiso'])){
		    	$objPermiso = $permiso ->newPermiso($data['permiso']);
		        echo json_encode($objPermiso);
	        }
	        break;
	    case "query":
		$objPermiso = $permiso ->getPermisos();
		        echo json_encode($objPermiso);
	    case "update":
	        if(isset($data['permiso'])){
	        	$updatedPermiso = $data['permiso'];
	        	$modifiedPermiso = get_object_vars($updatedPermiso);
	        	$objPermiso = $permiso ->updatePermiso($modifiedPermiso['id_permiso'],$modifiedPermiso['nombre']);
	        	echo json_encode($objPermiso);
	        }
	        break;
	    case "delete":
		    if(isset($data['permiso'])){
		    	$deletePermiso = $data['permiso'];
	        	$deletedPermiso = get_object_vars($deletePermiso);
	        	$objPermiso = $permiso ->deletePermiso($deletedPermiso['id_permiso']);
	        	echo json_encode($objPermiso);
		    }
		        break;
	}
?>