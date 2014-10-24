<?php
	require_once './../../models/Producto.php';	
	require_once './../../models/TipoProducto.php';	 
	$request_body = file_get_contents('php://input');
	$request = json_decode($request_body);
	$data = get_object_vars($request);
	switch ($data['action']) {

	    case "insert":
	    	if(isset($data['producto'])){
	    		$producto = new Producto();
		     	$objProducto = $producto ->newProducto($data['producto']);
		     	$result = $objProducto[0];
		     	echo json_encode($result);

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
	        if(isset($data['producto'])){
	        	$producto = new Producto();
	        	$updatedProducto = get_object_vars($data['producto']);
	        	$objproducto = $producto ->updateProducto($updatedProducto);
	        	echo json_encode($objproducto);
	        }
	        break;  
	    case "delete":
		    $producto = new Producto();
		    if(isset($data['producto'])){
		    	$deleteProducto = get_object_vars($data['producto']);
	        	$objProducto = $producto ->deleteProducto($deleteProducto['id_producto']);
	        	echo json_encode($objProducto);
		    }
		        break;
	}
?>
