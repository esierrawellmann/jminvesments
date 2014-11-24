<?php
require_once '../models/Conexion.php';
require_once '../models/Usuario.php';
ob_start();
session_start();
global $user,$pass;
$conexion = new database();
$usuario = new Usuario();
try{
        $conectar = $conexion->CrearConexion($_POST["user"], $_POST["pass"]);
        $conec = $usuario->getConexion($_POST["user"], $_POST["pass"]);
        if( (count($conec)) > 0 ){
            $_SESSION["user"]=$_POST["user"];
            $_SESSION["pass"]=$_POST["pass"];
            
            $usuario = new Usuario();
            $user = $usuario->getUsersbyName($_SESSION["user"]);
            
            $_SESSION["role"]=$user[0]['role_name'];
                                    
            header( 'Location: /backend/app/views/main.php' ) ;
        }else{
            header('Location: /backend/index.php?error');
        }
}
 catch (Exception $er){
     header('Location: index.php');
 }

?>
