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
  function getCitas()
  {
    $this->conectar();
    $query = $this->consulta("select a.id_agenda, u.id_usuario,u.nombre,a.comentario ,a.fecha_inicio,a.fecha_fin from agenda a inner join usuario u on a.id_usuario = u.id_usuario order by id_agenda,fecha_inicio desc");
    $this->disconnect();
    if($this->numero_de_filas($query) > 0){
      while ( $tsArray = $this->fetch_assoc($query) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }
  function getCitasxId($id)
  {
    $this->conectar();
    $query = $this->consulta("select a.id_agenda, u.id_usuario,u.nombre,a.comentario ,fecha_inicio,fecha_fin from agenda a inner join usuario u on a.id_usuario = u.id_usuario where u.id_usuario = ".$id." order by id_agenda desc");
    $this->disconnect();
    if($this->numero_de_filas($query) > 0){
      while ( $tsArray = $this->fetch_assoc($query) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }
  function newEvent($gastoObj){
    $gasto = get_object_vars($gastoObj);
    $q = "INSERT INTO agenda (id_usuario,comentario,fecha_inicio,fecha_fin) VALUES (".$gasto['id_usuario'].",'".$gasto['comentario']."','".$gasto['fecha_inicio']."','".$gasto['fecha_fin']."');";
    $this -> conectar();
    $query = $this->consulta($q);
    $queryObject = $this->consulta( "select a.id_agenda, u.id_usuario,u.nombre,a.comentario ,a.fecha_inicio,a.fecha_fin from agenda a inner join usuario u on a.id_usuario = u.id_usuario ORDER BY a.id_agenda DESC LIMIT 1;");
    $this->disconnect();
    if($this->numero_de_filas($queryObject) > 0){
      while ( $tsArray = $this->fetch_assoc($queryObject) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }
  function updateAgenda($gasto){
    $this -> conectar();
    $q = "update agenda  set  id_usuario=".$gasto['id_usuario']." ,comentario= '".$gasto['comentario']."', fecha_inicio = '".$gasto['fecha_inicio']."', fecha_fin = '".$gasto['fecha_fin']."' where id_agenda = ".$gasto['id_agenda'].";"; 
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

function deleteCita($id){
    $this -> conectar();
    $query = $this -> consulta("delete from agenda where id_agenda = ".$id);
    $this ->disconnect();

    return array();
  }

}

?>

