<?php
	require_once './../../models/Compra.php';	
	require_once './../../models/Usuario.php';	 
	$request_body = file_get_contents('php://input');
	$request = json_decode($request_body);
	$data = get_object_vars($request);
	switch ($data['action']) {

	    case "insert":
	    	if(isset($data['compra'])){
	    		$compra = new Compra();
		     	$objcompra = $compra ->newCompra($data['compra']);
		     	$result = $objcompra[0];
		     	echo json_encode($result);

		     }
	        break;
	    case "query":
		        $compra = new Compra();

		       	$usuario = new Usuario();
                        
                        $u = $_SESSION['usuario'];
                    $id_u = $u[0]['id_usuario'];
                    $cambiar_usuario="false";
                    $contador = count($_SESSION['permisos']);
                    $arreglo = $_SESSION['permisos'];
                      for($c=0;$c<$contador;$c++){
                            switch($arreglo[$c]['nombre']){
                                case "UsuarioCompras":
                                    $cambiar_usuario = "true";
                                    break;
                            }
                      }
                      
                      if($cambiar_usuario==="true"){
                        $objcompra = $compra->getCompras();
                        $objtipousuario = $usuario ->getUsers();
                      }else{
                          $objcompra = $compra->getComprasbyId($id_u);
                        $objtipousuario = $usuario ->getUsersbyId($id_u);
                      }

		        echo '{"compras":'.json_encode($objcompra).',"usuarios":'.json_encode($objtipousuario).'}';
	    	break;
	    case "update":
	        if(isset($data['compra'])){
	        	$compra = new Compra();
	        	$updatedcompra = get_object_vars($data['compra']);
	        	$objcompra = $compra->updateCompra($updatedcompra);
	        	echo json_encode($objcompra);
	        }
	        break;  
	    case "delete":
		    if(isset($data['compra'])){
                        $compra = new Compra();
		    	$deleteCompra = get_object_vars($data['compra']);
	        	$objCompra = $compra ->deleteCompra($deleteCompra['id_compra']);
	        	echo json_encode($objCompra);
		    }
		        break;
	}
?>
