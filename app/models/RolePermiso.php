<?php
require_once "Conexion.php";

class RolePermiso extends database {

  function getRolePermiso($id_role)
  {
    $this->conectar();
    $q = "select rp.id_role_permiso,rp.id_role,rp.id_permiso,p.nombre as 'nombre_permiso' from role_permiso rp inner join permiso p on rp.id_permiso = p.id_permiso where rp.id_role= ".$id_role.";";
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
  function newRolePermiso($detalle,$rol){
    $rolArray = get_object_vars($rol);
    $detalleArray = get_object_vars($detalle);
    $q = "insert into role_permiso(id_role,id_permiso) values (".$rolArray['id_role'].",".$detalleArray['id_permiso'].");";
    $this -> conectar();
    $query = $this->consulta($q);
    $queryObject = $this->consulta("select rp.id_role_permiso,rp.id_role,rp.id_permiso,p.nombre as 'nombre_permiso' from role_permiso rp inner join permiso p on rp.id_permiso = p.id_permiso where id_role= ".$rolArray['id_role']." ORDER BY rp.id_role_permiso DESC LIMIT 1;" );
    $this->disconnect();
    if($this->numero_de_filas($queryObject) > 0){
      while ( $tsArray = $this->fetch_assoc($queryObject) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }


function updateRolePermiso($detalle){
		$this -> conectar();
    $q = "update role_permiso  set  id_permiso=".$detalle['id_permiso']." where id_role_permiso = ".$detalle['id_role_permiso'].";"; 
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

function deleteRolePermiso($id){
    $this -> conectar();
    $query = $this -> consulta("delete from role_permiso where id_role_permiso = ".$id);
    $this ->disconnect();

    return '{"success":true}';
  }

}

?>



