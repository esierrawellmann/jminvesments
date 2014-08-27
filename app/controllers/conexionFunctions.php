<?php
require_once '../models/Conexion.php';
session_start();
global $user,$pass;
$conexion = new database();
try{
        $conectar = $conexion->CrearConexion($_POST["user"], $_POST["pass"]);
        if($conectar==="true"){
            $_SESSION["user"]=$_POST["user"];
            $_SESSION["pass"]=$_POST["pass"];
            header( 'Location: /app/views/main.php' ) ;
        }else{
            header('Location: index.php');
        }
}
 catch (Exception $er){
     header('Location: index.php');
 }


