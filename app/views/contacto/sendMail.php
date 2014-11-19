<?php 
	mail('info@jminversiones.com',$_POST["name"].'   Telefono:'.$_POST["phone"] , $_POST["message"].'  <br>  '.$_POST["id"]);
	header("Location: http://jminversiones.com/");
?>