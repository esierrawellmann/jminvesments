<?php
	require_once './../../models/DetalleVenta.php';	
	require_once './../../models/Producto.php';	 
	$request_body = file_get_contents('php://input');
	$request = json_decode($request_body);
	$data = get_object_vars($request);
	switch ($data['action']) {

	    case "insert":
	    	if(isset($data['detalleVenta'])){
	    		$dventa = new DetalleVenta();
		     	$objVenta = $dventa -> newDetalleVenta($data['detalleVenta'],$data['venta']);
		     	$result = $objVenta[0];
		     	echo json_encode($result);

		     }
	        break;
	    case "query":
	    		$ventaData = get_object_vars($data['venta']);
		        $detalleVenta = new DetalleVenta();
		        $objVenta = $detalleVenta -> getDetalleVentas($ventaData['id_venta']);
		       	$producto = new Producto();
		        $objProducto= $producto ->getProductos();

		        echo '{"detalleVentas":'.json_encode($objVenta).',"productos":'.json_encode($objProducto).',"venta":'.json_encode($ventaData).'}';
	    	break;
	    case "update":
	    	echo var_dump($data);
	        if(isset($data['detalleVenta'])){
	        	$ventaData = new DetalleVenta();
				$updatedGasto = get_object_vars($data['detalleVenta']);
	        	echo var_dump($updatedGasto);
	        	$objUser = $ventaData -> updateDetalleVenta($updatedGasto);
	        	echo json_encode($objUser);
	        }
	        break;
	    case "delete":
		    $gasto = new Gasto();
		    if(isset($data['gasto'])){
		    	$deleteSpend = get_object_vars($data['gasto']);
	        	$objGasto = $gasto -> deleteSpend($deleteSpend['id_gasto']);
	        	echo json_encode($objRol);
		    }
		        break;
	}
?>