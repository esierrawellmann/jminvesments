<?php
require_once "Conexion.php";

class Gasto extends database {

  function getGastos()
  {
    $this->conectar();
    $query = $this->consulta("SELECT g.id_gasto,g.asunto,g.comentario,g.fecha,u.id_usuario,u.nombre AS 'user_name',g.monto FROM gasto g INNER JOIN usuario u ON g.id_usuario = u.id_usuario ORDER BY g.id_gasto;");
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
    echo var_dump($gasto);
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
	function updateUser($user){
		$this -> conectar();
		$query = $this -> consulta("update usuario set nombre ='".$user['nombre']."', id_role = ".$user['id_role']." where id_usuario = ".$user['id_usuario'].";");
		$this ->disconnect();
		if($this->numero_de_filas($queryObject) > 0){
			while ( $tsArray = $this->fetch_assoc($queryObject) )
				$data[] = $tsArray;
			return $data;
		}else{
			return '{ }';
		}
	}

function deleteUser($id){
    $this -> conectar();
    $query = $this -> consulta("delete from usuario where id_usuario = ".$id);
    $this ->disconnect();

    return '{"success":true}';
  }

}

?>

