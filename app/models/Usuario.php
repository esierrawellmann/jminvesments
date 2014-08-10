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
  function newUser($user){
    $userName = $user['nombre'];
    $userRole = $user['rol'];

    $this -> conectar();
    $query = $this->consulta("insert into usuario(id_role,nombre) values (".$userRole['id_role'].",'".$userName."');");
    $queryObject = $this->consulta("SELECT u.id_usuario,u.nombre,r.id_role,r.nombre as 'role_name' FROM usuario u INNER JOIN role r ON u.id_role = r.id_role ORDER BY u.id_usuario DESC LIMIT 1 ");
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

