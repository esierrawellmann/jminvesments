<?php
require_once "Conexion.php";

class CajaChica extends database {

  function getCajaChica()
  {
    $this->conectar();
    $query = $this->consulta("select * from caja_chica;");
    $this->disconnect();
    if($this->numero_de_filas($query) > 0){
      while ( $tsArray = $this->fetch_assoc($query) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }

  function updateCompra($id_caja,$cantidad){
		$this -> conectar();
		$query = $this -> consulta("update caja_chica set cantidad=".$cantidad." where id_caja=".$id_caja.";");
                $this ->disconnect();
		if($this->numero_de_filas($queryObject) > 0){
			while ( $tsArray = $this->fetch_assoc($queryObject) )
				$data[] = $tsArray;
			return $data;
		}else{
			return '{ }';
		}
	}


}

?>



