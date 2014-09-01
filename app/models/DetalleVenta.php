<?php
require_once "Conexion.php";

class DetalleVenta extends database {

  function getDetalleVentas($id_venta)
  {
    $this->conectar();
    $q = "SELECT dv.id_detalle_venta,dv.id_venta,p.id_producto,p.nombre,dv.cantidad,dv.precio FROM detalle_venta dv INNER JOIN producto p ON dv.id_producto = p.id_producto WHERE dv.id_venta = ".$id_venta.";";
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
  function newVenta($venta){
    $ventaArray = get_object_vars($venta);
    $q = "INSERT INTO venta (id_usuario,nombre,nit,fecha) VALUES (".$ventaArray['id_usuario'].",'".$ventaArray['nombre']."','".$ventaArray['nit']."','".$ventaArray['fecha']."');";
    $this -> conectar();
    $query = $this->consulta($q);
    $queryObject = $this->consulta( "SELECT v.id_venta,v.nombre,v.nit,v.fecha,u.id_usuario,u.nombre AS 'user_name' FROM venta v INNER JOIN usuario u ON v.id_usuario = u.id_usuario  ORDER BY v.id_venta DESC LIMIT 1;");
    $this->disconnect();
    if($this->numero_de_filas($queryObject) > 0){
      while ( $tsArray = $this->fetch_assoc($queryObject) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }
	function updateGasto($gasto){
		$this -> conectar();
    $q = "update gasto  set  id_usuario=".$gasto['id_usuario']." ,asunto= '".$gasto['asunto']."',comentario = '".$gasto['comentario']."', fecha = '".$gasto['fecha']."', monto =".$gasto['monto']." where id_gasto = ".$gasto['id_gasto'].";"; 
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

function deleteSpend($id){
    $this -> conectar();
    $query = $this -> consulta("delete from gasto where id_gasto = ".$id);
    $this ->disconnect();

    return '{"success":true}';
  }

}

?>

