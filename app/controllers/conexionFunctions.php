<?php
require_once '../models/Conexion.php';
session_start();
global $user,$pass;
$conexion = new database();

$conectar = $conexion->CrearConexion($_POST["user"], $_POST["pass"]);

if($conectar==="true"){
    $_SESSION["user"]=$_POST["user"];
    $_SESSION["pass"]=$_POST["pass"];
    header( 'Location: /app/views/main.php' ) ;
}


