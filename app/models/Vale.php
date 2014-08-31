<?php
require_once "Conexion.php";

class Vale extends database {

  function getVales()
  {
    $this->conectar();
    $query = $this->consulta("select v.id_vale,v.id_usuario,u.nombre as 'usuario_name',v.motivo,v.monto,v.estado,v.fecha from vale v inner join usuario u on v.id_usuario = u.id_usuario order by v.id_vale");
    $this->disconnect();
    if($this->numero_de_filas($query) > 0){
      while ( $tsArray = $this->fetch_assoc($query) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }
  function newVale($vale){
    $valeVars = get_object_vars($vale);
    
    $q = "insert into vale(id_usuario,motivo,monto,estado,fecha) values (".
            $valeVars['id_usuario'].",'".$valeVars['motivo']."',".
            $valeVars['monto'].",'".$valeVars['estado']."','".$valeVars['fecha']."');";
    
    $this -> conectar();
    $query = $this->consulta($q);
    $queryObject = $this->consulta("select v.id_vale,v.id_usuario,u.nombre as 'usuario_name',v.motivo,v.monto,v.estado,v.fecha from vale v inner join usuario u on v.id_usuario = u.id_usuario order by v.id_vale DESC LIMIT 1; ");
    $this->disconnect();
    if($this->numero_de_filas($queryObject) > 0){
      while ( $tsArray = $this->fetch_assoc($queryObject) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }

  function updateVale($vale){
		$this -> conectar();
		$query = $this -> consulta("update vale set id_usuario=".$vale['id_usuario'].",motivo='".$vale['motivo']."',monto=".$vale['monto'].",estado='".$vale['id_usuario']."',fecha='".$vale['id_usuario']."' where id_vale=".$vale['id_vale'].";");
                $this ->disconnect();
		if($this->numero_de_filas($queryObject) > 0){
			while ( $tsArray = $this->fetch_assoc($queryObject) )
				$data[] = $tsArray;
			return $data;
		}else{
			return '{ }';
		}
	}

function deleteVale($id){
    $this -> conectar();
    $query = $this -> consulta("delete from vale where id_vale = ".$id);
    $this ->disconnect();

    return '{"success":true}';
  }

}

?>




