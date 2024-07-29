<?php
require_once 'Funciones.php';
class Pedido {

    public function __construct() {
    
    }

    public static function guardar($array) {
        $campos="fecha,estado,idpersona";
        $retorna=Funciones::insert(['pedido',$campos,$array]);
        return $retorna['id'];
        }

    public static function modificar($valores) {
        $campos="fecha,estado,idpersona";
        $retorna=Funciones::update(['pedido',$campos,$valores]);
        return $retorna;
        }

    public static function eliminar($id) {
        $retorna=Funciones::delete(['pedido',$id]);
        return $retorna;
        }
    
    public static function listUno($filtro) {
        $campos = 'id,fecha,estado,idpersona';
        $lista=array('pedido',$campos,$filtro);
        $retorna=Funciones::ListarUno($lista);
        return $retorna;
    }
        
    public static function listTodos($filtro) {
        $campos = 'id,fecha,estado,idpersona,(SELECT CONCAT(nombres, " ",apellidos) FROM persona WHERE pedido.idpersona=persona.id) as person';
        $lista=array('pedido',$campos,$filtro);
        $retorna=Funciones::listarTodos($lista);
        return $retorna;
    }
   
}




