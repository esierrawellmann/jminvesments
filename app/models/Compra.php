<?php
require_once "Conexion.php";

class Compra extends database {

  function getCompras()
  {
    $this->conectar();
    $query = $this->consulta("select c.id_compra,c.id_usuario,u.nombre,c.fecha from compra c inner join usuario u  on c.id_usuario = u.id_usuario order by c.id_compra");
    $this->disconnect();
    if($this->numero_de_filas($query) > 0){
      while ( $tsArray = $this->fetch_assoc($query) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }
  
    function getComprasbyId($id)
  {
    $this->conectar();
    $query = $this->consulta("select c.id_compra,c.id_usuario,u.nombre,c.fecha from compra c inner join usuario u  on c.id_usuario = u.id_usuario where c.id_usuario=".$id." order by c.id_compra");
    $this->disconnect();
    if($this->numero_de_filas($query) > 0){
      while ( $tsArray = $this->fetch_assoc($query) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }
  
  function newCompra($compra){
    $compraVars = get_object_vars($compra);
    
    $q = "insert into compra(id_usuario,fecha) values (".
            $compraVars['id_usuario'].",'".$compraVars['fecha']."');";
    
    $this -> conectar();
    $query = $this->consulta($q);
    $queryObject = $this->consulta("select c.id_compra,c.id_usuario,u.nombre,c.fecha from compra c inner join usuario u  on c.id_usuario = u.id_usuario order by c.id_compra DESC LIMIT 1; ");
    $this->disconnect();
    if($this->numero_de_filas($queryObject) > 0){
      while ( $tsArray = $this->fetch_assoc($queryObject) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }

  function updateCompra($compra){
		$this -> conectar();
		$query = $this -> consulta("update compra set id_usuario=".$compra['id_usuario'].",fecha='".$compra['fecha']."' where id_compra=".$compra['id_compra'].";");
                $this ->disconnect();
		if($this->numero_de_filas($queryObject) > 0){
			while ( $tsArray = $this->fetch_assoc($queryObject) )
				$data[] = $tsArray;
			return $data;
		}else{
			return '{ }';
		}
	}

function deleteCompra($id){
    $this -> conectar();
    $query = $this -> consulta("delete from compra where id_compra = ".$id);
    $this ->disconnect();

    return '{"success":true}';
  }

}

?>



