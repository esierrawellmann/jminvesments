<?php
	require_once './../../models/Mobiliario.php';	
	require_once './../../models/Usuario.php';	 
	$request_body = file_get_contents('php://input');
	$request = json_decode($request_body);
	$data = get_object_vars($request);
	switch ($data['action']) {
	    case "insert":
	    	if(isset($data['mobiliario'])){
	    		$vale = new Mobiliario();
		     	$objVale = $vale ->newMobiliario($data['mobiliario']);
		     	$result = $objVale[0];
		     	echo json_encode($result);

		     }
	        break;
	    case "query":
		    
                    $vale = new Mobiliario();
		    $usuario = new Usuario();
                    
                    $u = $_SESSION['usuario'];
                    $id_u = $u[0]['id_usuario'];
                    $cambiar_usuario="false";
                    $contador = count($_SESSION['permisos']);
                    $arreglo = $_SESSION['permisos'];
                      for($c=0;$c<$contador;$c++){
                            switch($arreglo[$c]['nombre']){
                                case "UsuarioMobiliario":
                                    $cambiar_usuario = "true";
                                    break;
                            }
                      }

                      if($cambiar_usuario==="true"){
                        $objVale= $vale ->getMobiliario();
                        $objUsuario = $usuario ->getUsers();
                      }else{
                          $objVale= $vale ->getMobiliarioByid($id_u);
                          $objUsuario = $usuario ->getUsersbyId($id_u);
                      }
		       	

		        echo '{"mobiliarios":'.json_encode($objVale).',"usuarios":'.json_encode($objUsuario).'}';
	    	break;
	    case "update":
	        if(isset($data['mobiliario'])){
	        	$vale = new Mobiliario();
	        	$updatedVale = get_object_vars($data['mobiliario']);
	        	$objvale = $vale ->updateMobiliario($updatedVale);
	        	echo json_encode($objvale);
	        }
	        break;
	    case "delete":
		    if(isset($data['mobiliario'])){
		    	$vale = new Mobiliario();
	        	$updatedVale = get_object_vars($data['mobiliario']);
	        	$objvale = $vale ->deleteMobiliario($updatedVale['id_mobiliario']);
	        	echo json_encode($objvale);
		    }
		        break;
	}
?>
