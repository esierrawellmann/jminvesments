<?php
	require_once './../../models/Rol.php';	
	require_once './../../models/Permiso.php';	
        require_once './../../models/RolePermiso.php';
	$request_body = file_get_contents('php://input');
	$request = json_decode($request_body);
	$data = get_object_vars($request);
	switch ($data['action']) {

	    case "insert":
	    	if(isset($data['rolePermiso'])){
	    		$dcompra = new RolePermiso();
		     	$objCompra = $dcompra ->newRolePermiso($data['rolePermiso'],$data['role']);
		     	$result = $objCompra[0];
		     	echo json_encode($result);

		     }
	        break;
	    case "query":
	    		$compraData = get_object_vars($data['role']);
		        $detalleCompra = new RolePermiso();
		        $objCompra = $detalleCompra ->getRolePermiso($compraData['id_role']);
                        
                        $permiso = new Permiso();
		        $objProducto= $permiso ->getPermisos();

                        $h = '{"rolePermisos":'.json_encode($objCompra).',"permisos":'.json_encode($objProducto).',"role":'.json_encode($compraData).'}';
                        echo $h;
	    	break;
	    case "update":
	        if(isset($data['rolePermiso'])){
	        	$compraData = new RolePermiso();
			$updatedDetalle = get_object_vars($data['rolePermiso']);
	        	$objUser = $compraData ->updateRolePermiso($updatedDetalle);
	        	echo json_encode($objUser);
	        }
	        break;
	    case "delete":
		    
		    if(isset($data['rolePermiso'])){
		    	$detalle = new RolePermiso();
		    	$deleteDetail = get_object_vars($data['rolePermiso']);

	        	$objCompra = $detalle ->deleteRolePermiso($deleteDetail['id_role_permiso']);
	        	echo json_encode($objCompra);
		    }
		        break;
	}
?>
