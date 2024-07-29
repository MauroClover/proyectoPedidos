<?php

class Funciones { 
    public function __construct() {
       
    }

    public static function insert($array) {
        if (!isset($array[0]) || !isset($array[1]) || !isset($array[2])) {
            throw new InvalidArgumentException('El formato del array de entrada es incorrecto.');
        }
    
        $tabla = $array[0];
        $columnas = $array[1];
        $valoresArray = $array[2];
    
        $post = explode(',', $columnas);
        $valores = [];
        foreach ($post as $valor) {
            $valores[] = ":$valor";
        }
        $valoresPlaceholder = implode(', ', $valores);
    
        $cadenaSQL = "INSERT INTO $tabla ($columnas) VALUES ($valoresPlaceholder)";
        $parametros = [];
        foreach ($post as $index => $columna) {
            if (isset($valoresArray[$index])) {
                $parametros[":$columna"] = $valoresArray[$index];
            }
        }
    
        $ultimoId = ConectorBD::retornar_ultimo_Id($cadenaSQL, $parametros);
        return $ultimoId;
    }
    
    public static function update($array) {
        $parametros=array();
        if (!isset($array[0]) || !isset($array[1]) || !isset($array[2])) {
            return "error no se puede modificar";
        }
        $tabla=$array[0];
        $campos=$array[1];
        $valores=$array[2];
        $post = explode(',', $campos);
        $campos1 = [];
        foreach ($post as $valor) {
            $campos1[] = "$valor=:$valor";
        }
        $cadena = implode(', ', $campos1);
        $cadenaSQL="UPDATE $tabla SET $cadena WHERE id=:id ";
        foreach ($post as $index => $campo) {
            if (isset($valores[$index])) {
                $parametros[":$campo"] = $valores[$index];
            }
        }
        ConectorBD::ejecutarQuery($cadenaSQL,$parametros);
    }

    public static function delete($array) {
        $parametros=array();
        if (!isset($array[0]) || !isset($array[1]) ) {
            return "error no se puede eliminar";
        }
        $tabla=$array[0];
        $id=$array[1];
        if (isset($array[2])) {
            $new=$array[2];
            $filtro="$new =:$new";
            $parametros = array(":$new" => $id);
        }else{
            $filtro='id=:id';
            $parametros = array(':id' => $id);
        }
        $cadenaSQL="DELETE FROM $tabla WHERE $filtro";
        
         ConectorBD::ejecutarQuery($cadenaSQL,$parametros);
        }

    public static function ListarUno($array) {
        $parametros=array();
        $tabla=$array[0];
        $campos=$array[1];
        $filtro=$array[2];
        if($filtro==null || $filtro==''){ $filtro=''; }
            else {
                $a=explode('=', $filtro);
                $filtro="WHERE $a[0] =:$a[0]";
                $parametros = array(":$a[0]" => $a[1]);

            }
       $cadenaSQL="SELECT $campos FROM $tabla $filtro ORDER BY id DESC";
       return ConectorBD::retornarUno($cadenaSQL,$parametros);
   }

    public static function listarTodos($array) {
        $parametros=array();
        $tabla=$array[0];
        $campos=$array[1];
        $filtro=$array[2];
        if($filtro==null || $filtro==''){ $filtro=''; }
            else {
                $a=explode('=', $filtro);
                $filtro="WHERE $a[0] =:$a[0]";
                $parametros = array(":$a[0]" => $a[1]);

            }
       $cadenaSQL="SELECT $campos FROM $tabla $filtro ORDER BY id DESC";
       $consulta=ConectorBD::retornarTodos($cadenaSQL,$parametros);
        return $consulta;
        }

    public static function validar_imagen($imagen_file){
        $allowedExtensions = array("jpg","jpeg","png","gif","bmp","webp","svg");
        $fileExtension = pathinfo($imagen_file["name"], PATHINFO_EXTENSION);
    
        $mensaje = ""; 
        if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
            $mensaje = "Archivo no permitido";
            $imagen=0;
        } else {
            $maxFileSize = 5 * 1024 * 1024;
    
            if ($imagen_file["size"] > $maxFileSize) {
                $mensaje = "El archivo es demasiado grande";
                $imagen=0;
            } else {
                $newFileName = uniqid() . '.' . $fileExtension;
                $uploadPath = "../view/imagenes/" . $newFileName;
    
                if (move_uploaded_file($imagen_file["tmp_name"], $uploadPath)) {
                    $mensaje = "Archivo cargado con éxito";
                    $imagen = $newFileName;
                } else {
                    $mensaje = "Error al cargar el archivo";
                    $imagen = 0;
                }
            }
        }
        $resultados = [$imagen, $mensaje];
        return $resultados;
    }
        
}
