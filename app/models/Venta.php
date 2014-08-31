<?php
require_once "Conexion.php";

class Venta extends database {

  function getVentas()
  {
    $this->conectar();
    $query = $this->consulta("SELECT v.id_venta,v.nombre,v.nit,v.fecha,u.id_usuario,u.nombre AS 'user_name' FROM venta v INNER JOIN usuario u ON v.id_usuario = u.id_usuario ORDER BY v.id_venta;");
    $this->disconnect();
    if($this->numero_de_filas($query) > 0){
      while ( $tsArray = $this->fetch_assoc($query) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }
  function newGasto($gastoObj){
    $gasto = get_object_vars($gastoObj);
    $q = "INSERT INTO gasto (id_usuario,asunto,comentario,fecha,monto) VALUES (".$gasto['id_usuario'].",'".$gasto['asunto']."','".$gasto['comentario']."','".$gasto['fecha']."',".$gasto['monto'].");";
    $this -> conectar();
    $query = $this->consulta($q);
    $queryObject = $this->consulta( "SELECT g.id_gasto,g.asunto,g.comentario,g.fecha,u.id_usuario,u.nombre AS 'user_name',g.monto FROM gasto g INNER JOIN usuario u ON g.id_usuario = u.id_usuario ORDER BY g.id_gasto DESC LIMIT 1;");
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

