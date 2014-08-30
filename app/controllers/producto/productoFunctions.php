<?php
	require_once '../../models/Producto.php';	
	require_once '../../models/TipoProducto.php';	 
	$request_body = file_get_contents('php://input');
	$request = json_decode($request_body);
	$data = get_object_vars($request);
	switch ($data['action']) {

	    case "insert":
	    	if(isset($data['producto'])){
	    		$producto = new Producto();
		     	$objProducto = $producto ->newProducto($data['producto']);
		     	$result = $objProducto[0];
		     	$resultProducto = array('id_producto'=> $result['id_producto'],'nombre'=>$result['nombre'],'precio_compra'=>$result['precio_compra'],'precio_venta'=>$result['precio_venta'], 'id_tipo_producto'=>$result['id_tipo_producto'],'tipo_producto'=>$result['tipo_producto']); 
		     	echo json_encode($resultProducto);

		     }
	        break;
	    case "query":
		        $producto = new Producto();
		        $objProducto= $producto ->getProductos();

		       	$tipoProducto = new TipoProducto();
		       	$objtipoProducto = $tipoProducto ->getTiposProducto();

		        echo '{"productos":'.json_encode($objProducto).',"tipo_productos":'.json_encode($objtipoProducto).'}';
	    	break;
	    case "update":
	        $usuario = new Producto();
	        if(isset($data['producto'])){
	        	$producto = new Producto();
	        	$updatedProducto = get_object_vars($data['producto']);
	        	$objproducto = $producto -> updateUser($updatedProducto);
	        	echo json_encode($objproducto);
	        }
	        break;
	    case "delete":
		    $usuario = new Producto();
		    if(isset($data['producto'])){
		    	$deleteProducto = get_object_vars($data['usuario']);
	        	$objProducto = $usuario -> deleteUser($deleteProducto['id_producto']);
	        	echo json_encode($objProducto);
		    }
		        break;
	}
?>
