<?php
	require_once './../../models/Gasto.php';	
	require_once './../../models/Usuario.php';	 
	$request_body = file_get_contents('php://input');
	$request = json_decode($request_body);
	$data = get_object_vars($request);
	switch ($data['action']) {

	    case "insert":
	    	if(isset($data['gasto'])){
	    		$gasto = new Gasto();
		     	$objGasto = $gasto -> newGasto($data['gasto']);
		     	$result = $objGasto[0];
		     	echo json_encode($result);

		     }
	        break;
	    case "query":
		        $gasto = new Gasto();
		        
		       	$usuario = new Usuario();
		       	
                        
                        $u = $_SESSION['usuario'];
                    $id_u = $u[0]['id_usuario'];
                    $cambiar_usuario="false";
                    $contador = count($_SESSION['permisos']);
                    $arreglo = $_SESSION['permisos'];
                      for($c=0;$c<$contador;$c++){
                            switch($arreglo[$c]['nombre']){
                                case "UsuarioGastos":
                                    $cambiar_usuario = "true";
                                    break;
                            }
                      }
                      
                      if($cambiar_usuario==="true"){
                        $objGasto = $gasto -> getGastos();
                        $objUsuario = $usuario -> getUsers();
                      }else{
                        
                        $objGasto = $gasto ->getGastosById($id_u);
                        $objUsuario = $usuario ->getUsersbyId($id_u);
                      }

		        echo '{"usuarios":'.json_encode($objUsuario).',"gastos":'.json_encode($objGasto).'}';
	    	break;
	    case "update":
	        $gasto = new Gasto();
	        if(isset($data['gasto'])){
	        	$updatedGasto = get_object_vars($data['gasto']);
	        	$objUser = $gasto -> updateGasto($updatedGasto);
	        	echo json_encode($objUser);
	        }
	        break;
	    case "delete":
		    $gasto = new Gasto();
		    if(isset($data['gasto'])){
		    	$deleteSpend = get_object_vars($data['gasto']);
	        	$objGasto = $gasto -> deleteSpend($deleteSpend['id_gasto']);
	        	echo json_encode($objGasto);
		    }
		        break;
	}
?>