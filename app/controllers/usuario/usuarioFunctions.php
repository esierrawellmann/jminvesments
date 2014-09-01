<?php
	require_once './../../models/Usuario.php';	
	require_once './../../models/Rol.php';	 
	$request_body = file_get_contents('php://input');
	$request = json_decode($request_body);
	$data = get_object_vars($request);
	switch ($data['action']) {

	    case "insert":
	    	if(isset($data['user'])){
	    		$usuario = new Usuario();
		     	$objUsuario = $usuario -> newUser($data['user']);
		     	$result = $objUsuario[0];
		     	$resultUser = array('id_usuario'=> $result['id_usuario'],'nombre'=>$result['nombre'], 'id_role'=>$result['id_role'],'role_name'=>$result['role_name']); 
		     	echo json_encode($resultUser);

		     }
	        break;
	    case "query":
		        $user = new Usuario();
		        $objUsuario = $user -> getUsers();

		       	$rol = new Rol();
		       	$objRol = $rol -> getRoles();

		        echo '{"usuarios":'.json_encode($objUsuario).',"roles":'.json_encode($objRol).'}';
	    	break;
	    case "update":
	        $usuario = new Usuario();
	        if(isset($data['usuario'])){
	        	$user = new Usuario();
	        	$updatedUser = get_object_vars($data['usuario']);
	        	$objUser = $user -> updateUser($updatedUser);
	        	echo json_encode($objUser);
	        }
	        break;
	    case "delete":
		    $usuario = new Usuario();
		    if(isset($data['usuario'])){
		    	$deleteUser = get_object_vars($data['usuario']);
	        	$objRol = $usuario -> deleteUser($deleteUser['id_usuario']);
	        	echo json_encode($objRol);
		    }
		        break;
	}
?>