<?php
require_once "Conexion.php";

class Agenda extends database {

  function getEvents()
  {
    $this->conectar();
    $query = $this->consulta("SELECT id_agenda AS 'id',CONCAT(u.nombre,' @ ',DATE_FORMAT(a.fecha_inicio,'%H:%i'),' - ',DATE_FORMAT(a.fecha_fin,'%H:%i'),': ',comentario) AS 'title', 'javascript:void(0)' AS 'url' , 'event-important' AS class,UNIX_TIMESTAMP(a.fecha_inicio)*1000 AS 'start' , UNIX_TIMESTAMP(a.fecha_fin)*1000 AS 'end' FROM agenda a INNER JOIN usuario u ON a.id_usuario = u.id_usuario");
    $this->disconnect();
    if($this->numero_de_filas($query) > 0){
      while ( $tsArray = $this->fetch_assoc($query) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }
  function newRole($rolName){
    $this -> conectar();
    $query = $this->consulta("insert into role(nombre) values ('".$rolName."');");
    $queryObject = $this->consulta("SELECT * from role ORDER BY id_role DESC LIMIT 1 ");
    $this->disconnect();
    if($this->numero_de_filas($queryObject) > 0){
      while ( $tsArray = $this->fetch_assoc($queryObject) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }
  function updateRole($id,$name){
    $this -> conectar();
    $query = $this -> consulta("update role set nombre ='".$name."' where id_role = ".$id);

    $queryObject = $this -> consulta("select * from role where id_role = ".$id);
    $this ->disconnect();
    if($this->numero_de_filas($queryObject) > 0){
      while ( $tsArray = $this->fetch_assoc($queryObject) )
        $data[] = $tsArray;
      return $data;
    }else{
      return array();
    }
  }

function deleteRole($id){
    $this -> conectar();
    $query = $this -> consulta("delete from role where id_role = ".$id);
    $this ->disconnect();

    return array();
  }

}

?>

