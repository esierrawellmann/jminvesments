<?php
require_once "Conexion.php";

class DetalleCompra extends database {

  function getDetalleCompras($id_compra)
  {
    $this->conectar();
    $q = "select dc.id_detalle_compra,dc.id_compra,p.nombre,dc.id_producto,dc.cantidad,dc.precio from detalle_compra dc inner join producto p on dc.id_producto = p.id_producto where dc.id_compra = ".$id_compra.";";
    $query = $this->consulta($q);
    $this->disconnect();
    if($this->numero_de_filas($query) > 0){
      while ( $tsArray = $this->fetch_assoc($query) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }
  function newDetalleCompra($detalle,$compra){
    $compraArray = get_object_vars($compra);
    $detalleCompraArray = get_object_vars($detalle);
    $q = "insert into detalle_compra(id_compra,id_producto,cantidad,precio) values (".$compraArray['id_compra'].",".$detalleCompraArray['id_producto'].",".$detalleCompraArray['cantidad'].",".$detalleCompraArray['precio'].");";
    $this -> conectar();
    $query = $this->consulta($q);
    $queryObject = $this->consulta("select dc.id_detalle_compra,dc.id_compra,p.nombre,dc.id_producto,dc.cantidad,dc.precio from detalle_compra dc inner join producto p on dc.id_producto = p.id_producto where dc.id_compra = ".$compraArray['id_compra']." ORDER BY dc.id_detalle_compra DESC LIMIT 1;" );
    $this->disconnect();
    if($this->numero_de_filas($queryObject) > 0){
      while ( $tsArray = $this->fetch_assoc($queryObject) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }
	function updateDetalleCompra($detalleCompra){
		$this -> conectar();
    $q = "update detalle_venta  set  id_producto=".$detalleCompra['id_producto']." ,precio= ".$detalleCompra['precio'].",cantidad = ".$detalleCompra['cantidad']."  where id_detalle_compra = ".$detalleCompra['id_detalle_compra'].";"; 
    $query = $this -> consulta($q);
		$this ->disconnect();
		if($this->numero_de_filas($queryObject) > 0){
			while ( $tsArray = $this->fetch_assoc($queryObject) )
				$data[] = $tsArray;
			return $data;
		}else{
			return '{ }';
		}
	}

function deleteDetalleCompra($id){
    $this -> conectar();
    $query = $this -> consulta("delete from detalle_compra where id_detalle_compra = ".$id);
    $this ->disconnect();

    return '{"success":true}';
  }

}

?>

