<?php
require_once "Conexion.php";

class Propiedad extends database {

  function getPropiedades()
  {
    $this->conectar();
    $query = $this->consulta("SELECT * FROM propiedad");
    $this->disconnect();
    if($this->numero_de_filas($query) > 0){
      while ( $tsArray = $this->fetch_assoc($query) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }
  function newPropiedad($propiedad){
    $this -> conectar();
    
    $query = $this->consulta("insert into propiedad(tipo,negocio,zona,estado,nombre_proyecto,nombre_propietario,dormitorios,precio_renta,precio_venta,amueblado,directa_compartida,direccion,departamento,municipio) values (" .
            "'".$propiedad['tipo']."','" . $propiedad['negocio'] . "','" . $propiedad['zona'] . "','" . $propiedad['estado'] . "',"
            . "'".$propiedad['nombre_proyecto']."','" . $propiedad['nombre_propietario'] . "','" . $propiedad['dormitorios'] . "'," . $propiedad['precio_renta'] . ","
            . $propiedad['precio_venta'].",'" . $propiedad['amueblado'] . "','" . $propiedad['directa_compartida'] . "','" . $propiedad['direccion'] . "'," 
            . $propiedad['departamento'].",'" . $propiedad['municipio'] . "');");
    
    $queryObject = $this->consulta("SELECT * from propiedad ORDER BY id_propiedad DESC LIMIT 1 ");
    $this->disconnect();
    if($this->numero_de_filas($queryObject) > 0){
      while ( $tsArray = $this->fetch_assoc($queryObject) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }
  
  function updatePropiedad($propiedad){
		$this -> conectar();
		
                $query = $this->consulta("update propiedad set " .
                "tipo='".$propiedad['tipo']."',negocio='" . $propiedad['negocio'] . "',zona='" . $propiedad['zona'] . "',estado='" . $propiedad['estado'] . "',"
                . "nombre_proyecto='".$propiedad['nombre_proyecto']."',nombre_propietario='" . $propiedad['nombre_propietario'] . "',dormitorios='" . $propiedad['dormitorios'] . "',precio_renta=" . $propiedad['precio_renta'] . ","
                . "precio_venta=".$propiedad['precio_venta'].",amueblado='" . $propiedad['amueblado'] . "',directa_compartida='" . $propiedad['directa_compartida'] . "',direccion='" . $propiedad['direccion'] . "'," 
                . "departamento='". $propiedad['departamento']."',municipio='" . $propiedad['municipio'] . "' where id_propiedad=". $propiedad['id_propiedad'] .";");

		$queryObject = $this -> consulta("select * from propiedad where id_propiedad = ".$propiedad['id_propiedad']);
		$this ->disconnect();
		if($this->numero_de_filas($queryObject) > 0){
			while ( $tsArray = $this->fetch_assoc($queryObject) )
				$data[] = $tsArray;
			return $data;
		}else{
			return array();
		}
	}

function deletePropiedad($propiedad){
    $this -> conectar();
    $query = $this -> consulta("delete from propiedad where id_propiedad = ".$propiedad['id_propiedad']);
    $this ->disconnect();

    return array();
  }

}

?>


