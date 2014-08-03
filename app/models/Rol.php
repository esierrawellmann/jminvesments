<?php
require_once "Conexion.php";

class Rol extends database {

 function getRoles()
 {

  //conexion a la base de datos

  $this->conectar();
  $query = $this->consulta("SELECT * FROM role");
      $this->disconnect();
  if($this->numero_de_filas($query) > 0) // existe -> datos correctos
  {
    //se llenan los datos en un array
    while ( $tsArray = $this->fetch_assoc($query) )
     $data[] = $tsArray;   

    return json_encode ($data);
  }else
  {
   return '{ }';
  }
 }

}

?>

