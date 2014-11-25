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





function searchTopFor(){

    $query = "select *,(select nombre from detalle_propiedad where propiedad.id_propiedad = detalle_propiedad.id_propiedad LIMIT 1) as 'imagen' from propiedad order by id_propiedad desc limit 4 ";

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

    $q = "insert into propiedad(tipo,negocio,zona,estado,nombre_proyecto,nombre_propietario,dormitorios,precio_renta,precio_venta,amueblado,directa_compartida,direccion,departamento,municipio,ambiente,area,parqueos) values ('".$propiedad['tipo']."','" . $propiedad['negocio'] . "','" . $propiedad['zona'] . "','" . $propiedad['estado'] ."','".$propiedad['nombre_proyecto']."','" . $propiedad['nombre_propietario'] . "','" . $propiedad['dormitorios'] . "'," . $propiedad['precio_renta'].",".$propiedad['precio_venta'].",'" .$amueblada. "','" . $propiedad['directa_compartida'] . "','" . $propiedad['direccion'] . "','". $departamento['nombre']."','" . $propiedad['municipio'] . "','".$propiedad['ambiente']."','".$propiedad['area']."','".$propiedad['parqueos']."');";

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

        $q = "update propiedad set  parqueos='".$propiedad['parqueos']."', tipo='".$propiedad['tipo']."',negocio='".$propiedad['negocio']."',zona='".$propiedad['zona']."',estado='".$propiedad['estado']."',nombre_proyecto='".$propiedad['nombre_proyecto']."',nombre_propietario='".$propiedad['nombre_propietario']."',dormitorios='".$propiedad['dormitorios']."',precio_renta=".$propiedad['precio_renta'].", precio_venta=".$propiedad['precio_venta'].",amueblado='" . $amueblada . "',directa_compartida='".$propiedad['directa_compartida']."',direccion='".$propiedad['direccion']."', departamento='".$departamento['nombre']."',municipio='".$propiedad['municipio']."',ambiente='".$propiedad['ambiente']."',area='".$propiedad['area']."' where id_propiedad=".$propiedad['id_propiedad'] .";";



	

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

    $query .= " precio_renta between ".$params['renta_desde']." and ".$params['renta_hasta']." ";

    $query .=" and  precio_renta between ".$params['venta_desde']." and ".$params['venta_hasta']." ";

    if(isset($params['tipo'])){

        $query .= " and tipo in('".implode("','",$params['tipo'])."')";

    }

   $query .= " and estado = 'Disponible'";

    if(isset($params['negocio'])){

        $query .= " and negocio in('".implode("','",$params['negocio'])."')";

    }

    if(isset($params['zona'])){

         $query .= " and zona in('".implode("','",$params['zona'])."')";

    }

    if(isset($params['dormitorios'])){

         $query .= " and dormitorios = '".$params['dormitorios']."'";

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





