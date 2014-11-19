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
  
  function getCajaxUser($id,$fecha,$fecha_final){
      $this->conectar();
      $consulta = "select v.id_venta, v.nombre as 'cliente' ,v.fecha as'fecha',u.nombre as 'vendedor',v.tarjeta,v.efectivo, (select sum(cantidad*precio) from detalle_venta where detalle_venta.id_venta = v.id_venta) as 'suma' from venta v inner join usuario u on v.id_usuario=u.id_usuario where v.id_usuario=".$id." and v.fecha between '".$fecha."' and '".$fecha_final."' order by v.id_usuario ";
  
      $query = $this->consulta($consulta);
      $this->disconnect();
      if($this->numero_de_filas($query) > 0){
      while ( $tsArray = $this->fetch_assoc($query) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }
  function getCajaxUserxFecha($id,$fecha,$fecha_final){
      $this->conectar();
      $consulta = " SELECT v.fecha AS 'fecha', SUM(dv.cantidad * dv.precio) AS 'cantidad' FROM venta v INNER JOIN usuario u ON v.id_usuario = u.id_usuario INNER JOIN detalle_venta dv ON dv.id_venta = v.id_venta WHERE u.id_usuario =".$id." and v.fecha between '".$fecha."' and '".$fecha_final."'  GROUP BY fecha ORDER BY fecha ";
  
      $query = $this->consulta($consulta);
      $this->disconnect();
      if($this->numero_de_filas($query) > 0){
      while ( $tsArray = $this->fetch_assoc($query) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }
  
    function getCaja($fecha,$fecha_final){
      $this->conectar();
      $consulta = "select v.id_venta, v.nombre as 'cliente' ,v.fecha as 'fecha',u.nombre as 'vendedor',v.tarjeta,v.efectivo, (select sum(cantidad*precio) from detalle_venta where detalle_venta.id_venta = v.id_venta) as 'suma' from venta v inner join usuario u on v.id_usuario=u.id_usuario where v.fecha between '".$fecha."' and '".$fecha_final."' order by v.id_usuario ";
  
      $query = $this->consulta($consulta);
      $this->disconnect();
      if($this->numero_de_filas($query) > 0){
      while ( $tsArray = $this->fetch_assoc($query) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }
  
  function getPermisos($id){
      $this->conectar();
      
    $query = $this->consulta("select Distinct(permiso.nombre) from role_permiso inner join permiso on role_permiso.id_permiso = permiso.id_permiso where role_permiso.id_role=".$id);
    $this->disconnect();
    if($this->numero_de_filas($query) > 0){
      while ( $tsArray = $this->fetch_assoc($query) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }        
  }
          
  function getUsersbyName($name)
  {
    $this->conectar();
    $query = $this->consulta("SELECT u.id_usuario,u.nombre,r.id_role,r.nombre as 'role_name' FROM usuario u INNER JOIN role r ON u.id_role = r.id_role where u.nombre='".$name."' order by u.id_usuario");
    $this->disconnect();
    if($this->numero_de_filas($query) > 0){
      while ( $tsArray = $this->fetch_assoc($query) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }
  
   function getUsersbyId($id)
  {
    $this->conectar();
    $query = $this->consulta("SELECT u.id_usuario,u.nombre,r.id_role,r.nombre as 'role_name' FROM usuario u INNER JOIN role r ON u.id_role = r.id_role where u.id_usuario=".$id." order by u.id_usuario");
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

    $q = "insert into usuario(id_role,nombre) values (".$userVars['id_role'].",'".$userName."');";
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
                $id = $this ->consulta("select nombre from usuario where id_usuario=".$user['id_usuario'].";");
                while ( $tsArray = $this->fetch_assoc($id) )
				$data2[] = $tsArray;
                
                $usuario_anterior = $data2[0]['nombre'];
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

function deleteUser($id,$userName){
    $this -> conectar();
    $query = $this -> consulta("delete from usuario where id_usuario = ".$id);
    $this ->disconnect();

    return '{"success":true}';
  }

}

?>

