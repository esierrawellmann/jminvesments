<?php
require_once "Conexion.php";

class Usuario extends database {

  function getUsers()
  {
    $this->conectar();
    $query = $this->consulta("SELECT u.id_usuario,u.nombre,r.id_role,r.nombre as 'role_name' FROM usuario u INNER JOIN role r ON u.id_role = r.id_role");
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
      return '{ }';
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
			return '{ }';
		}
	}

function deleteRole($id){
    $this -> conectar();
    $query = $this -> consulta("delete from role where id_role = ".$id);
    $this ->disconnect();

    return '{ }';
  }

}

?>

