<?php
require_once "Conexion.php";

class Mobiliario extends database {

  function getMobiliario()
  {
    $this->conectar();
    $query = $this->consulta("select m.id_mobiliario,m.nombre,m.id_usuario,u.nombre as 'usuario_name',m.cantidad from mobiliario m inner join usuario u on m.id_usuario = u.id_usuario ");
    $this->disconnect();
    if($this->numero_de_filas($query) > 0){
      while ( $tsArray = $this->fetch_assoc($query) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }
  
    function getMobiliarioByid($id)
  {
    $this->conectar();
    $query = $this->consulta("select m.id_mobiliario,m.nombre,m.id_usuario,u.nombre as 'usuario_name',m.cantidad from mobiliario m inner join usuario u on m.id_usuario = u.id_usuario where m.id_usuario=".$id);
    $this->disconnect();
    if($this->numero_de_filas($query) > 0){
      while ( $tsArray = $this->fetch_assoc($query) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }
  
  function newMobiliario($vale){
    $valeVars = get_object_vars($vale);
    
    $q = "insert into mobiliario(id_usuario,nombre,cantidad) values (".
            $valeVars['id_usuario'].",'".$valeVars['nombre']."',".
            $valeVars['cantidad'].");";
    
    $this -> conectar();
    $query = $this->consulta($q);
    $queryObject = $this->consulta("select m.id_mobiliario,m.nombre,m.id_usuario,u.nombre as 'usuario_name',m.cantidad from mobiliario m inner join usuario u on m.id_usuario = u.id_usuario order by m.id_mobiliario DESC LIMIT 1; ");
    $this->disconnect();
    if($this->numero_de_filas($queryObject) > 0){
      while ( $tsArray = $this->fetch_assoc($queryObject) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }

  function updateMobiliario($vale){
		$this -> conectar();
		$query = $this -> consulta("update mobiliario set id_usuario=".$vale['id_usuario'].",nombre='".$vale['nombre']."',cantidad=".$vale['cantidad']." where id_mobiliario=".$vale['id_mobiliario'].";");
                $this ->disconnect();
		if($this->numero_de_filas($queryObject) > 0){
			while ( $tsArray = $this->fetch_assoc($queryObject) )
				$data[] = $tsArray;
			return $data;
		}else{
			return '{ }';
		}
	}

function deleteMobiliario($id){
    $this -> conectar();
    $query = $this -> consulta("delete from mobiliario where id_mobiliario = ".$id);
    $this ->disconnect();

    return '{"success":true}';
  }

}

?>






