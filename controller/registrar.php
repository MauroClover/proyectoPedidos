<?php
require_once '../model/Conector.php';
require_once '../model/Persona.php';
date_default_timezone_set('America/Bogota');
$fecha = new DateTime();
$date=$fecha->format('Y-m-d H:i:s');

$consulta=[];
if (isset($_POST['accion'])) {
    if ($_POST['accion'] == "registrarse") {
    	$name=$_POST['nombres'];
    	$apellidos=$_POST['apellidos'];
    	$identificacion=$_POST['identificacion'];
    	$telefono=$_POST['telefono'];
    	$correo=$_POST['correo'];
    	$clave=$_POST['clave'];
    	$tipo="C";  
        $limpiar=Persona::eliminar_caracteres([$name,$apellidos,$identificacion,$telefono]);
        $ident=$limpiar[2][0];
        $filtro="identificacion=$ident";
    	$consulta=Persona::listUno($filtro);
        if (!empty($consulta)) {
        	$mensaje="Usuario ya existe.!";
        }else{
        	$registrar=Persona::guardar([$limpiar[0][0],$limpiar[1][0],$limpiar[2][0],$limpiar[3][0],$correo,$tipo,$clave,$date]);
        	if ($registrar > 0) {
        	$mensaje="Felicitaciones usuario creado!.";
	        }else{
	        	$mensaje="Ups Hubo error en el envio!.";
	        }
        }
       
        header('location:../index.php?mensaje='.$mensaje);  

    }else{
        $mensaje="Accion incorrecta";
        header('location:../index.php?mensaje='.$mensaje);  
    }
	
}

