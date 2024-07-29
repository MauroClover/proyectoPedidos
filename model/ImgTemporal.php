<?php
require_once 'Funciones.php';
class ImgTemporal {

    public function __construct() {
    
    }

    public static function guardar($array) {
        $campos="nombre,talla,idpersona,fecha";
        $retorna=Funciones::insert(['imgtemporal',$campos,$array]);
        return $retorna['id'];
        }

    public static function modificar($valores) {
        $campos="nombre,talla,idpersona,fecha";
        $retorna=Funciones::update(['imgtemporal',$campos,$valores]);
        return $retorna;
        }

    public static function eliminar($id) {
        $retorna=Funciones::delete(['imgtemporal',$id]);
        return $retorna;
        }
    
    public static function eliminarTodo($person) {
        $retorna=Funciones::delete(['imgtemporal',$person,'idpersona']);
        return $retorna;
        }
    
    public static function listUno($filtro) {
        $campos = 'id,nombre,talla,idpersona,fecha';
        $lista=array('imgtemporal',$campos,$filtro);
        $retorna=Funciones::ListarUno($lista);
        return $retorna;
    }
        
    public static function listTodos($filtro) {
        $campos = 'id,nombre,talla,idpersona,fecha';
        $lista=array('imgtemporal',$campos,$filtro);
        $retorna=Funciones::listarTodos($lista);
        return $retorna;
    }

    public static function getListaEnOptions(){
         $resultado=[];
         $lista="";
         $resultado= ImgTemporal::listTodos(null);
         foreach ($resultado as $key => $value) {
            $lista.= '<option  value="'.$value['id'].'">'.$value['nombre'] .' </option>';
         }
    return $lista;
    }
   
}




