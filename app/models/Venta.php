<?php
require_once "Conexion.php";

class Venta extends database {

  function getVentas()
  {
    $this->conectar();
    $query = $this->consulta("SELECT v.id_venta,v.nombre,v.nit,v.fecha,v.tarjeta,v.efectivo,u.id_usuario,u.nombre AS 'user_name' FROM venta v INNER JOIN usuario u ON v.id_usuario = u.id_usuario ORDER BY fecha  desc, v.id_venta desc;");
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
    $q = "INSERT INTO venta (id_usuario,nombre,nit,fecha,tarjeta,efectivo) VALUES (".$ventaArray['id_usuario'].",'".$ventaArray['nombre']."','".$ventaArray['nit']."','".$ventaArray['fecha']."',".$ventaArray['tarjeta'].",".$ventaArray['efectivo'].");";
    $this -> conectar();
    $query = $this->consulta($q);
    $queryObject = $this->consulta( "SELECT v.id_venta,v.nombre,v.nit,v.fecha,v.tarjeta,v.efectivo,u.id_usuario,u.nombre AS 'user_name' FROM venta v INNER JOIN usuario u ON v.id_usuario = u.id_usuario  ORDER BY v.id_venta DESC LIMIT 1;");
    $this->disconnect();
    if($this->numero_de_filas($queryObject) > 0){
      while ( $tsArray = $this->fetch_assoc($queryObject) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }
	function updateVenta($venta){
    echo var_dump($venta);
		$this -> conectar();
    $q = "update venta  set  id_usuario=".$venta['id_usuario']." ,nombre= '".$venta['nombre']."',nit = '".$venta['nit']."', fecha = '".$venta['fecha']."' ,tarjeta='".$venta['tarjeta']."' , efectivo='".$venta['efectivo']."' where id_venta = ".$venta['id_venta'].";"; 
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

function deleteVenta($id){
    $this -> conectar();
    $query = $this -> consulta("delete from venta where id_venta = ".$id);
    $this ->disconnect();
    return '{"success":true}';
  }

}

?>

