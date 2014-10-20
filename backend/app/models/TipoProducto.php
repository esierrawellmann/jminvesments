<?php

require_once "Conexion.php";

class TipoProducto extends database {
    
    function getTiposProducto(){
        $this->conectar();
    $query = $this->consulta("SELECT * FROM tipo_producto");
    $this->disconnect();
    if($this->numero_de_filas($query) > 0){
      while ( $tsArray = $this->fetch_assoc($query) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
    }
    
    function newTipoProducto($name){
        $this -> conectar();
    $query = $this->consulta("insert into tipo_producto(nombre) values ('".$name."');");
    $queryObject = $this->consulta("SELECT * from tipo_producto ORDER BY id_tipo_producto DESC LIMIT 1 ");
    $this->disconnect();
    if($this->numero_de_filas($queryObject) > 0){
      while ( $tsArray = $this->fetch_assoc($queryObject) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return '{ }';
    }
    }
    
    function updateTipoProducto($id,$name){
		$this -> conectar();
		$query = $this -> consulta("update tipo_producto set nombre ='".$name."' where id_tipo_producto = ".$id);

		$queryObject = $this -> consulta("select * from tipo_producto where id_tipo_producto = ".$id);
		$this ->disconnect();
		if($this->numero_de_filas($queryObject) > 0){
			while ( $tsArray = $this->fetch_assoc($queryObject) )
				$data[] = $tsArray;
			return $data;
		}else{
			return '{ }';
		}
	}
        
    function deleteTipoProducto($id){
    $this -> conectar();
    $query = $this -> consulta("delete from tipo_producto where id_tipo_producto = ".$id);
    $this ->disconnect();

    return '{ }';
  }
    
    
}

