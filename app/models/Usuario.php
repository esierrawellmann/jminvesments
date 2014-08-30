<?php
require_once "Conexion.php";

class Usuario extends database {

  function getUsers()
  {
    $this->conectar();
    $query = $this->consulta("SELECT u.id_usuario,u.nombre,r.id_role,r.nombre as 'role_name' FROM usuario u INNER JOIN role r ON u.id_role = r.id_role order by u.id_usuario");
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
    $userVars = get_object_vars($user);
    $userName = $userVars['nombre'];
    $userRole = get_object_vars($userVars['rol']);

    $q = "insert into usuario(id_role,nombre) values (".$userRole['id_role'].",'".$userName."');";
    $this -> conectar();
    $query = $this->consulta($q);
    $queryObject = $this->consulta("SELECT u.id_usuario,u.nombre,r.id_role,r.nombre as 'role_name' FROM usuario u INNER JOIN role r ON u.id_role = r.id_role ORDER BY u.id_usuario DESC LIMIT 1; ");
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
		$queryObject = $this -> consulta("SELECT u.id_usuario,u.nombre,r.id_role,r.nombre as 'role_name' FROM usuario u INNER JOIN role r ON u.id_role = r.id_role where u.id_usuario =".$user['id_usuario']." ORDER BY u.id_usuario DESC LIMIT 1; ");
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

