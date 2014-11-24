<?php
require_once "Conexion.php";

class Rol extends database {

  function getRoles()
  {
    $this->conectar();
    $query = $this->consulta("SELECT * FROM role");
    $this->disconnect();
    if($this->numero_de_filas($query) > 0){
      while ( $tsArray = $this->fetch_assoc($query) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }
  function newRole($rolName){
    $this -> conectar();
    $query = $this->consulta("insert into role(nombre) values ('".$rolName."');");
    $queryObject = $this->consulta("SELECT * from role ORDER BY id_role DESC LIMIT 1 ");
    $this->disconnect();
    if($this->numero_de_filas($queryObject) > 0){
      while ( $tsArray = $this->fetch_assoc($queryObject) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }
	function updateRole($id,$name){
		$this -> conectar();
		$query = $this -> consulta("update role set nombre ='".$name."' where id_role = ".$id);

		$queryObject = $this -> consulta("select * from role where id_role = ".$id);
		$this ->disconnect();
		if($this->numero_de_filas($queryObject) > 0){
			while ( $tsArray = $this->fetch_assoc($queryObject) )
				$data[] = $tsArray;
			return $data;
		}else{
			return array();
		}
	}

function deleteRole($id){
    $this -> conectar();
    $query = $this -> consulta("delete from role where id_role = ".$id);
    $this ->disconnect();

    return array();
  }

}

?>

