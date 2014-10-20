<?php
	require_once './../../models/Vale.php';	
	require_once './../../models/Usuario.php';	 
	$request_body = file_get_contents('php://input');
	$request = json_decode($request_body);
	$data = get_object_vars($request);
	switch ($data['action']) {

	    case "insert":
	    	if(isset($data['vale'])){
	    		$vale = new Vale();
		     	$objVale = $vale ->newVale($data['vale']);
		     	$result = $objVale[0];
		     	echo json_encode($result);

		     }
	        break;
	    case "query":
		        $vale = new Vale();
		       	$usuario = new Usuario();
		       	
                        
                    $u = $_SESSION['usuario'];
                    $id_u = $u[0]['id_usuario'];
                    $cambiar_usuario="false";
                    $contador = count($_SESSION['permisos']);
                    $arreglo = $_SESSION['permisos'];
                      for($c=0;$c<$contador;$c++){
                            switch($arreglo[$c]['nombre']){
                                case "UsuarioVales":
                                    $cambiar_usuario = "true";
                                    break;
                            }
                      }
                      
                      if($cambiar_usuario==="true"){
                        $objVale= $vale ->getVales();
                        $objUsuario = $usuario ->getUsers();
                      }else{
                          $objVale= $vale ->getValesbyId($id_u);
                          $objUsuario = $usuario ->getUsersbyId($id_u);
                      }
                        

		        echo '{"vales":'.json_encode($objVale).',"usuarios":'.json_encode($objUsuario).'}';
	    	break;
	    case "update":
	        if(isset($data['vale'])){
	        	$vale = new Vale();
	        	$updatedVale = get_object_vars($data['vale']);
	        	$objvale = $vale ->updateVale($updatedVale);
	        	echo json_encode($objvale);
	        }
	        break;
	    case "delete":
		    if(isset($data['vale'])){
		    	$vale = new Vale();
	        	$updatedVale = get_object_vars($data['vale']);
	        	$objvale = $vale ->deleteVale($updatedVale['id_vale']);
	        	echo json_encode($objvale);
		    }
		        break;
	}
?>
