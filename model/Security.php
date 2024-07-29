<?php

class Security { 
    public function __construct() {
       
    }
    public static function iniciar_sesion() {
    session_set_cookie_params(['secure' => true, 'httponly' => true]);
    session_start();

        if (!isset($_SESSION['usuario'])) {
            header('location: ../../login.php?mensaje=Acceso no autorizado');
            exit();
        }
    $_SESSION['USUARIO'] = unserialize($_SESSION['usuario']);
    }

    public static function cerrarSesion() {
         header('location: ../../login.php?mensaje=Finalizado');
        session_destroy();
    }  
        
}
$security=new Security();
