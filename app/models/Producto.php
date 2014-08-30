<?php
require_once "Conexion.php";

class Producto extends database {

  function getProductos()
  {
    $this->conectar();
    $query = $this->consulta("select p.id_producto,p.nombre,t.nombre  as 'tipo_producto',t.id_tipo_producto,precio_compra,precio_venta,cantidad from producto p inner join tipo_producto t on p.id_tipo_producto = t.id_tipo_producto order by p.id_producto");
    $this->disconnect();
    if($this->numero_de_filas($query) > 0){
      while ( $tsArray = $this->fetch_assoc($query) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }
  function newProducto($producto){
    $productoVars = get_object_vars($producto);
    
    $q = "insert into producto(id_tipo_producto,nombre,precio_compra,precio_venta,cantidad) values "
            . "(".$productoVars['id_tipo_producto'].",'".$productoVars['nombre']."',".
            $productoVars['precio_compra'].",".
            $productoVars['precio_venta'].",".$productoVars['cantidad'].");";
    
    $this -> conectar();
    $query = $this->consulta($q);
    $queryObject = $this->consulta("select p.id_producto,p.nombre,t.nombre  as 'tipo_producto',t.id_tipo_producto,precio_compra,precio_venta,cantidad from producto p inner join tipo_producto t on p.id_tipo_producto = t.id_tipo_producto order by p.id_producto DESC LIMIT 1; ");
    $this->disconnect();
    if($this->numero_de_filas($queryObject) > 0){
      while ( $tsArray = $this->fetch_assoc($queryObject) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }

  function updateProducto($producto){
		$this -> conectar();
		$query = $this -> consulta("update producto set id_tipo_producto=".$producto['id_tipo_producto'].",nombre='".$producto['nombre']."',precio_compra=".$producto['precio_compra'].",precio_venta=".$producto['precio_venta'].",cantidad=".$producto['cantidad']." where id_producto=".$producto['id_producto'].";");
		$queryObject = $this -> consulta("SELECT u.id_usuario,u.nombre,r.id_role,r.nombre as 'role_name' FROM usuario u INNER JOIN role r ON u.id_role = r.id_role where u.id_usuario =".$user['id_usuario']." ORDER BY u.id_usuario DESC LIMIT 1; ");
		$this ->disconnect();
		if($this->numero_de_filas($queryObject) > 0){
			while ( $tsArray = $this->fetch_assoc($queryObject) )
				$data[] = $tsArray;
			return $data;
		}else{
			return '{ }';
		}
	}

function deleteProducto($id){
    $this -> conectar();
    $query = $this -> consulta("delete from producto where id_producto = ".$id);
    $this ->disconnect();

    return '{"success":true}';
  }

}

?>



