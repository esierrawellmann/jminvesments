<?php

require_once "Conexion.php";

class Permiso extends database {
    
    function getPermisos(){
        $this->conectar();
    $query = $this->consulta("SELECT * FROM permiso");
    $this->disconnect();
    if($this->numero_de_filas($query) > 0){
      while ( $tsArray = $this->fetch_assoc($query) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
    }
    
    function newPermiso($name){
        $this -> conectar();
    $query = $this->consulta("insert into permiso(nombre) values ('".$name."');");
    $queryObject = $this->consulta("SELECT * from permiso ORDER BY id_permiso DESC LIMIT 1 ");
    $this->disconnect();
    if($this->numero_de_filas($queryObject) > 0){
      while ( $tsArray = $this->fetch_assoc($queryObject) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return '{ }';
    }
    }
    
    function updatePermiso($id,$name){
		$this -> conectar();
		$query = $this -> consulta("update permiso set nombre ='".$name."' where id_permiso = ".$id);

		$queryObject = $this -> consulta("select * from permiso where id_permiso = ".$id);
		$this ->disconnect();
		if($this->numero_de_filas($queryObject) > 0){
			while ( $tsArray = $this->fetch_assoc($queryObject) )
				$data[] = $tsArray;
			return $data;
		}else{
			return '{ }';
		}
	}
        
    function deletePermiso($id){
    $this -> conectar();
    $query = $this -> consulta("delete from permiso where id_permiso = ".$id);
    $this ->disconnect();

    return '{ }';
  }
    
    
}

