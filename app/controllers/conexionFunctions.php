<?php
require_once '../models/Conexion.php';
require_once '../models/Usuario.php';
session_start();
global $user,$pass;
$conexion = new database();
try{
        $conectar = $conexion->CrearConexion($_POST["user"], $_POST["pass"]);
        if($conectar==="true"){
            $_SESSION["user"]=$_POST["user"];
            $_SESSION["pass"]=$_POST["pass"];
            
            $usuario = new Usuario();
            $user = $usuario->getUsersbyName($_SESSION["user"]);
            
            $permisos = $usuario->getPermisos($user[0]['id_role']); 
            $_SESSION['usuario']=$user;
            $_SESSION['permisos']=$permisos;
            
            header( 'Location: /app/views/main.php' ) ;
        }else{
            header('Location: /index.php?error');
        }
}
 catch (Exception $er){
     header('Location: index.php');
 }


