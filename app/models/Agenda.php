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
    $query = $this->consulta("select a.id_agenda, u.id_usuario,u.nombre,a.comentario ,a.fecha_inicio,a.fecha_fin from agenda a inner join usuario u on a.id_usuario = u.id_usuario");
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
    $query = $this->consulta("select a.id_agenda, u.id_usuario,u.nombre,a.comentario ,fecha_inicio,fecha_fin from agenda a inner join usuario u on a.id_usuario = u.id_usuario where u.id_usuario = ".$id);
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
    $q = "INSERT INTO agenda (id_usuario,asunto,comentario,fecha,monto) VALUES (".$gasto['id_usuario'].",'".$gasto['asunto']."','".$gasto['comentario']."','".$gasto['fecha']."',".$gasto['monto'].");";
    $this -> conectar();
    $query = $this->consulta($q);
    $queryObject = $this->consulta( "SELECT g.id_gasto,g.asunto,g.comentario,g.fecha,u.id_usuario,u.nombre AS 'user_name',g.monto FROM gasto g INNER JOIN usuario u ON g.id_usuario = u.id_usuario ORDER BY g.id_gasto DESC LIMIT 1;");
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

