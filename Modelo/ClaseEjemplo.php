<?php
require_once "db.class.php";

class universitario extends database {

 function universitarios()
 {
  //conexion a la base de datos
  $this->conectar();
  $query = $this->consulta("SELECT * FROM universitario WHERE carrera='$carrera' ORDER BY rand() LIMIT $limit;");
      $this->disconnect();
  if($this->numero_de_filas($query) > 0) // existe -> datos correctos
  {
    //se llenan los datos en un array
    while ( $tsArray = $this->fetch_assoc($query) )
     $data[] = $tsArray;   

    return $data;
  }else
  {
   return '';
  }
 }

}

?>


