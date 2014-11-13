<?php
require_once "Conexion.php";

class DetallePropiedad extends database {

  function getDetallePropiedades($id_propiedad)
  {
    $this->conectar();
    $q = "Select * from detalle_propiedad where id_propiedad=".$id_propiedad.";";
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
  function newDetallePropiedad($detalle,$compra){
    $compraArray = get_object_vars($compra);
    $detalleCompraArray = get_object_vars($detalle);
    $q = "insert into detalle_propiedad(id_propiedad,direccion,nombre) values (".$compraArray['id_propiedad'].",'".$detalleCompraArray['direccion']."','".$detalleCompraArray['nombre']."');";
    $this -> conectar();
    $query = $this->consulta($q);
    $queryObject = $this->consulta("Select * from detalle_propiedad where id_propiedad= ".$compraArray['id_propiedad']." ORDER BY id_detalle_propiedad DESC LIMIT 1;" );
    $this->disconnect();
    if($this->numero_de_filas($queryObject) > 0){
      while ( $tsArray = $this->fetch_assoc($queryObject) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }
  
  function insertarDetalle($idPropiedad,$direccion,$nombre){
    $q = "insert into detalle_propiedad(id_propiedad,direccion,nombre) values (".$idPropiedad.",'".$direccion."','".$nombre."');";
    $this -> conectar();
    $query = $this->consulta($q);
    $this->disconnect(); 
  }
            function updateDetallePropiedad($detalleCompra){
		$this -> conectar();
    $q = "update detalle_propiedad set direccion=".$detalleCompra['direccion']." ,nombre= ".$detalleCompra['nombre']." where id_detalle_propiedad = ".$detalleCompra['id_detalle_propiedad'].";"; 
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

function deleteDetallePropiedad($id){
    $this -> conectar();
    $query = $this -> consulta("delete from detalle_propiedad where id_detalle_propiedad = ".$id);
    $this ->disconnect();

    return '{"success":true}';
  }

}

?>

