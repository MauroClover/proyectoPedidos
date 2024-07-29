<?php

class TipoPersona {
    
    public function __construct() {
      
    }
    
     public static function getNombre($codigo){
        
        switch ($codigo) {
            case 'P': $nombre='Propietario'; break;
            case 'C': $nombre='Cliente'; break;
            default: $nombre='Desconocido'; break;
     }
        return $nombre;
    }

    public static function getMenu($codigo) {
        $menu='';
        
         
         switch ($codigo){
            case 'P':
                $menu.="<li class='nav-item mt-2'>
                        <a class='nav-link text-white' href='apartados.php'>Apartados</a>
                        </li>";
                $menu.="<li class='nav-item mt-2'>
                        <a class='nav-link text-white' href='productos.php'>pedido</a>
                        </li>";
                $menu.="<li class='nav-item mt-2'>
                        <a class='nav-link text-white' href='usuarios.php'>Usuarios</a>
                        </li>";
            break;
        
            case 'C':
                $menu.="<li class='nav-item mt-2'>
                        <a class='nav-link text-white' href='./apartadosCliente.php'>Apartados</a>
                        </li>";
                $menu.="<li class='nav-item mt-2'>
                        <a class='nav-link text-white' href='./nuevoApartadoC.php'>Pedido</a>
                        </li>";
                $menu.="<li class='nav-item mt-2'>
                        <a class='nav-link text-white' href='./catalogoCliente.php'>Catalogo</a>
                        </li>"; 
                
                
                break;
 
        }
        return $menu;
    }
    
 

}




