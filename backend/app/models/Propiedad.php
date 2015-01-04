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
  
  

function getZonas($negocio,$tipo)

  {

    $this->conectar();

    $query = $this->consulta("select zona from propiedad where negocio='".$negocio."' and tipo='".$tipo."' group by zona order by CAST(zona AS UNSIGNED) asc;");

    $this->disconnect();

    if($this->numero_de_filas($query) > 0){

      while ( $tsArray = $this->fetch_assoc($query) )

        $data[] = $tsArray;   

        return $data;

    }else{

      return array();

    }

  }
  
  function getPropiedadesManuales($negocio,$tipo,$zona)

  {

    $this->conectar();

    $query = $this->consulta("select *,(SELECT nombre FROM detalle_propiedad WHERE propiedad.id_propiedad = detalle_propiedad.id_propiedad LIMIT 1) AS 'imagen' from propiedad where negocio='".$negocio."' and tipo='".$tipo."'and zona='".$zona."';");

    $this->disconnect();

    if($this->numero_de_filas($query) > 0){

      while ( $tsArray = $this->fetch_assoc($query) )

        $data[] = $tsArray;   

        return $data;

    }else{

      return array();

    }

  }



function searchTopFor(){

    $query = "SELECT * ,(SELECT nombre FROM detalle_propiedad WHERE propiedad.id_propiedad = detalle_propiedad.id_propiedad LIMIT 1) AS 'imagen'  FROM propiedad WHERE id_propiedad IN (SELECT MAX(id_propiedad) FROM propiedad WHERE tipo IN('Apartamento','Bodega','Casa','Edificio') AND estado = 'Disponible' GROUP BY propiedad.tipo) ";

    $this->conectar();

    $query = $this->consulta($query);

    $this->disconnect();

    if($this->numero_de_filas($query) > 0){

      while ( $tsArray = $this->fetch_assoc($query) )

        $data[] = $tsArray;   

        return $data;

    }else{

      return array();

    }

}



  function getTopForImages(){

    $this->conectar();

    $query = $this->consulta("select propiedad.id_propiedad,detalle_propiedad.nombre as 'direccion' from detalle_propiedad inner join propiedad on propiedad.id_propiedad = detalle_propiedad.id_propiedad ");

    $this->disconnect();

    if($this->numero_de_filas($query) > 0){

      while ( $tsArray = $this->fetch_assoc($query) )

        $data[] = $tsArray;   

        return $data;

    }else{

      return array();

    }

  }

  function getTopForProperties(){

    $this->conectar();

    $query = $this->consulta("SELECT * FROM propiedad order by id_propiedad desc limit 4 ");

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

    



    $propiedad = get_object_vars($propiedad);

    $departamento = get_object_vars($propiedad['departamento']);

    $amueblada =  $propiedad['amueblado'] ? 'true':'false';

    $this -> conectar();

    $q = "insert into propiedad(tipo,negocio,zona,estado,nombre_proyecto,nombre_propietario,dormitorios,precio_renta,precio_venta,amueblado,directa_compartida,direccion,departamento,municipio,ambiente,area,parqueos,codigo_propiedad) values ('".$propiedad['tipo']."','" . $propiedad['negocio'] . "','" . $propiedad['zona'] . "','" . $propiedad['estado'] ."','".$propiedad['nombre_proyecto']."','" . $propiedad['nombre_propietario'] . "','" . $propiedad['dormitorios'] . "'," . $propiedad['precio_renta'].",".$propiedad['precio_venta'].",'" .$amueblada. "','" . $propiedad['directa_compartida'] . "','" . $propiedad['direccion'] . "','". $departamento['nombre']."','" . $propiedad['municipio'] . "','".$propiedad['ambiente']."','".$propiedad['area']."','".$propiedad['parqueos']."','".$propiedad['codigo_propiedad']."');";

    $query = $this->consulta($q);

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



        $propiedad = get_object_vars($propiedad);

        $departamento = get_object_vars($propiedad['departamento']);

        $amueblada =  $propiedad['amueblado'] ? 'true':'false';

        $q = "update propiedad set  parqueos='".$propiedad['parqueos']."', tipo='".$propiedad['tipo']."',negocio='".$propiedad['negocio']."',zona='".$propiedad['zona']."',estado='".$propiedad['estado']."',nombre_proyecto='".$propiedad['nombre_proyecto']."',nombre_propietario='".$propiedad['nombre_propietario']."',dormitorios='".$propiedad['dormitorios']."',precio_renta=".$propiedad['precio_renta'].", precio_venta=".$propiedad['precio_venta'].",amueblado='" . $amueblada . "',directa_compartida='".$propiedad['directa_compartida']."',direccion='".$propiedad['direccion']."', departamento='".$departamento['nombre']."',municipio='".$propiedad['municipio']."',ambiente='".$propiedad['ambiente']."',area='".$propiedad['area']."',codigo_propiedad='".$propiedad['codigo_propiedad']."' where id_propiedad=".$propiedad['id_propiedad'] .";";



	

        $this -> conectar();		

        $query = $this->consulta($q);

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



function searchForProperties($params){


    $params = get_object_vars($params);

    $query = "select *,(select nombre from detalle_propiedad where propiedad.id_propiedad = detalle_propiedad.id_propiedad LIMIT 1) as 'url' from propiedad where ";

    $query .= " estado = 'Disponible'";

     if(isset($params['precio_renta']) && count($params['precio_renta']) > 0 && $params['negocio'] ==="Renta" ){

          $operador = " and ";
          foreach ($params['precio_renta'] as $key => $value) {
            if($key > 0){
              $operador = " or ";
            }
        $query .= $operador;
            # code...
            switch($value){
            case "8" :
              $query .= "  precio_renta between 0 and 500 ";
            break;
            case "9" :
              $query .= "  precio_renta between 501 and 1000 ";
            break;
            case "10" :
              $query .= "  precio_renta between 1001 and 1500 ";
            break;
            case "11" :
             $query .= "  precio_renta between 1501 and 2000 ";
            break;
            case "12" :
             $query .= "  precio_renta between 2001 and 2500 ";
            break;
            case "13" :
             $query .= "  precio_renta between 2501 and 3000 ";
            break;
            case "14" :
             $query .= "  precio_renta between 3000 and 9223372036854775807 ";
            break;
          }
        }
     }

     if(isset($params['precio_venta']) && count($params['precio_venta']) > 0 && $params['negocio'] ==="Venta" ){
      $operador = " and ";
      foreach ($params['precio_venta'] as $key => $value) {
        # code...
        if($key > 0){
          $operador = " or ";
        }
        $query .= $operador;
        switch($value){
            case "1" :
              $query .= " precio_venta between 0 and 75000 ";
            break;
            case "2" :
              $query .= " precio_venta between 75001 and 100000 ";
            break;
            case "3" :
              $query .= " precio_venta between 100001 and 150000 ";
            break;
            case "4" :
             $query .= " precio_venta between 150001 and 200000 ";
            break;
            case "5" :
             $query .= " precio_venta between 200001 and 250000 ";
            break;
            case "6" :
             $query .= " precio_venta between 250001 and 300000 ";
            break;
            case "7" :
             $query .= " precio_venta between 300001 and 9223372036854775807 ";
            break;
          }
      }
      
     }

    if(isset($params['tipo']) && count($params['tipo']) > 0  ){

        $query .= " and tipo in('".implode("','",$params['tipo'])."')";

    }

    if(isset($params['negocio'])  && $params['negocio'] !==""){

        $query .= " and negocio in('".$params['negocio']."')";

    }

    if(isset($params['zona'])  && count($params['zona']) > 0 ){

         $query .= " and zona in('".implode("','",$params['zona'])."')";

    }

    if(isset($params['dormitorios'])  && $params['dormitorios'] !==""){

         $query .= " and dormitorios = '".$params['dormitorios']."' ";

    }    

    if(isset($params['amueblado'])  && $params['amueblado'] !==""){
        $varAmueblado = $params['amueblado'] ? 'true': 'false';
        $query .= "and amueblado = '".$varAmueblado."'";

    }
   
    $query .= ";";

    
    $this->conectar();

    $query = $this->consulta($query);

    $this->disconnect();

    if($this->numero_de_filas($query) > 0){

      while ( $tsArray = $this->fetch_assoc($query) )

        $data[] = $tsArray;   

        return $data;

    }else{

      return array();

    }
}



function searchForPropertiesFiltered($params){

    $params = get_object_vars($params);

    $query = "select *,(select nombre from detalle_propiedad where propiedad.id_propiedad = detalle_propiedad.id_propiedad LIMIT 1) as 'url' from propiedad where ";

    $query .= " precio_renta between ".$params['renta_desde']." and ".$params['renta_hasta']." ";

    $query .=" and  precio_renta between ".$params['venta_desde']." and ".$params['venta_hasta']." ";

    if(isset($params['tipo'])){

        $query .= " and tipo in('".implode("','",$params['tipo'])."')";

    }

    if(isset($params['nombre_proyecto'])){

       $query .=" and nombre_proyecto like '%".$params['nombre_proyecto']."%'"; 

    }

    if(isset($params['nombre_propietario'])){

        $query .=" and nombre_propietario like '%".$params['nombre_propietario']."%'";

    }

    if(isset($params['estado'])){

        $query .= " and estado = '".$params['estado']."'";

    }

    if(isset($params['negocio'])){

        $query .= " and negocio in('".implode("','",$params['negocio'])."')";

    }

    if(isset($params['zona'])){

         $query .= " and zona in('".implode("','",$params['zona'])."')";

    }

    if(isset($params['dormitorios'])){

         $query .= " and dormitorios = '".$params['dormitorios']."'";

    }    

    if(isset($params['directa_compartida'])){

        $query .= "and directa_compartida = '".$params['dormitorios']."'";

    }

    if(isset($params['amueblado'])){

        $query .= "and amueblado = '".$params['amueblado']."'";

    }



    $this->conectar();

    $query = $this->consulta($query);

    $this->disconnect();

    if($this->numero_de_filas($query) > 0){

      while ( $tsArray = $this->fetch_assoc($query) )

        $data[] = $tsArray;   

        return $data;

    }else{

      return array();

    }

}

function getPropertyImages($params){

    $this -> conectar();

    $query = $this -> consulta("select nombre as 'direccion' from detalle_propiedad where id_propiedad = ".$params);

    $this ->disconnect();



    if($this->numero_de_filas($query) > 0){

      while ( $tsArray = $this->fetch_assoc($query) )

        $data[] = $tsArray;   

        return $data;

    }else{

      return array();

    }



}



function getPropertyById($params){

    $this -> conectar();

    $query = $this -> consulta("select * from propiedad where id_propiedad = ".$params);

    $this ->disconnect();



    if($this->numero_de_filas($query) > 0){

      while ( $tsArray = $this->fetch_assoc($query) )

        $data[] = $tsArray;   

        return $data[0];

    }else{

      return array();

    }



}

function deletePropiedad($propiedad){

    $this -> conectar();

    $query = $this -> consulta("delete from propiedad where id_propiedad = ".$propiedad);

    $this ->disconnect();



    return array();

  }



}



?>





