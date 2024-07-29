<?php
require_once 'Funciones.php';
class Persona {

    public function __construct() {
    
    }

    public static function guardar($array) {
        $clave=md5("$array[6]");
        $campos="nombres,apellidos,identificacion,telefono,correo,tipo,clave,fecha";
        $valores=array($array[0],$array[1],$array[2],$array[3],$array[4],$array[5],$clave,$array[7] );  
        $retorna=Funciones::insert(['persona',$campos,$valores]);
        return $retorna['id'];
        }

    public static function modificar($valores) {
        if(isset($valores[8])){
           $campos="id,nombres,apellidos,identificacion,telefono,correo,tipo,clave,fecha";
        }else{
           $campos="id,nombres,apellidos,identificacion,telefono,correo,tipo,fecha";
        } 
        $retorna=Funciones::update(['persona',$campos,$valores]);
        return $retorna;
        }

    public static function eliminar($id) {
        $retorna=Funciones::delete(['persona',$id]);
        return $retorna;
        }
    
    public static function listUno($filtro) {
        $campos = 'id,identificacion,nombres,apellidos,telefono,correo,tipo';
        $lista=array('persona',$campos,$filtro);
        $retorna=Funciones::ListarUno($lista);
        return $retorna;
    }
        
    public static function listTodos($filtro) {
        $campos = 'id,identificacion,nombres,apellidos,telefono,correo,tipo';
        $lista=array('persona',$campos,$filtro);
        $retorna=Funciones::listarTodos($lista);
        return $retorna;
    }
        
    public static function listarUno_validar($usuario,$clave) {
        $filtro='';
        $parametros=array();
        $filtro="WHERE identificacion =:id AND clave=md5(:clave)";
        $parametros = array(':id' => $usuario,':clave' => $clave);
        $cadenaSQL="SELECT * FROM persona $filtro ";
        $retorna=ConectorBD::retornarUno($cadenaSQL,$parametros);
        return $retorna;
    }

    public static function getTipoEnOptions(){
        $lista="";
        $lista.= "<option value='C'>Cliente</option>";
        $lista.=  "<option value='P'>Propietario</option>";
        return $lista;
        }

  public static function getListaEnOptions(){
         $resultado=[];
         $lista="";
         $resultado= Persona::listTodos(null);
         foreach ($resultado as $key => $value) {
            $lista.= '<option  value="'.$value['id'].'">'.$value['nombres']. " ".$value['apellidos'] .' </option>';
         }
    return $lista;
    }

    public static function eliminar_caracteres($array){
        $limpiar=array();
        $caracteres='([^A-Za-z0-9 ])';
        foreach ($array as $key => $value) {
            $a=preg_replace($caracteres, '',$value);
            $limpiar[]=[ $a ];
        }
        return $limpiar;
    }
   

}
$persona=new Persona();




