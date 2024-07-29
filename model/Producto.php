<?php
require_once 'Funciones.php';
class Producto {

    public function __construct() {
    
    }

    public static function guardar($array) {
        $campos="nombre,talla,idpersona,fecha,idapartado";
        $retorna=Funciones::insert(['producto',$campos,$array]);
        return $retorna['id'];
        }

    public static function modificar($valores) {
        $campos="nombre,talla,idpersona,fecha,idapartado";
        $retorna=Funciones::update(['producto',$campos,$valores]);
        return $retorna;
        }

    public static function eliminar($id) {
        $retorna=Funciones::delete(['producto',$id]);
        return $retorna;
        }
    
    public static function listUno($filtro) {
        $campos = 'id,nombre,talla,idpersona,fecha,idapartado';
        $lista=array('producto',$campos,$filtro);
        $retorna=Funciones::ListarUno($lista);
        return $retorna;
    }
        
    public static function listTodos($filtro) {
        $campos = 'id,nombre,talla,idpersona,fecha,idapartado';
        $lista=array('producto',$campos,$filtro);
        $retorna=Funciones::listarTodos($lista);
        return $retorna;
    }

    public static function getListaEnOptions(){
         $resultado=[];
         $lista="";
         $resultado= Producto::listTodos(null);
         foreach ($resultado as $key => $value) {
            $lista.= '<option  value="'.$value['id'].'">'.$value['nombre'] .' </option>';
         }
    return $lista;
    }
   
}




