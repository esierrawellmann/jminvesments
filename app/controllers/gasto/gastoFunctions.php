<?php
	require_once '../../models/Gasto.php';	
	require_once '../../models/Usuario.php';	 
	$request_body = file_get_contents('php://input');
	$request = json_decode($request_body);
	$data = get_object_vars($request);
	switch ($data['action']) {

	    case "insert":
	    	if(isset($data['user'])){
	    		$gasto = new Gasto();
		     	$objGasto = $gasto -> newGasto($data['gasto']);
		     	$result = $objUsuario[0];
		     	$resultUser = array('id_usuario'=> $result['id_usuario'],'nombre'=>$result['nombre'], 'id_role'=>$result['id_role'],'role_name'=>$result['role_name']); 
		     	echo json_encode($resultUser);

		     }
	        break;
	    case "query":
		        $gasto = new Gasto();
		        $objGasto = $gasto -> getGastos();
		       	$usuario = new Usuario();
		       	$objUsuario = $usuario -> getUsers();

		        echo '{"usuarios":'.json_encode($objUsuario).',"gastos":'.json_encode($objGasto).'}';
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