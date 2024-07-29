<?php

require_once '../model/Conector.php';
require_once '../model/Persona.php';

$usuario=$_REQUEST['usuario'];
$clave=$_REQUEST['clave'];
$persona= Persona::listarUno_validar($usuario, $clave);

if($persona==null){
   header('location:../index.php?mensaje=usuario incorrecto');
  
}else{
    session_start();
    $_SESSION['usuario']=serialize($persona);
    header('location:../view/productos.php');
}

