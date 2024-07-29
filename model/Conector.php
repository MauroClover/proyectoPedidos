<?php 

class ConectorBD {
    private $servidor;
    private $puerto;
    private $baseDatos;
    private $controlador;
    private $usuario;
    private $clave;
    private $conexion;

    public function __construct() {
        $ruta= dirname(__FILE__) . '/configuracion.ini';
        if(!file_exists($ruta)){
            echo 'Error: no existe el archivo de configuracion de la base de datos.Nombre del archivo:' . $ruta;
            //return false;
            die();//se detiene el procesamiento del codigo de este archivo            
        } else { // si hay certeza de que el archivo existe
            $parametros= parse_ini_file($ruta); //lee el archivo de configuracion y los datos los introduce a parametros como una matriz de tipo asociativo
            if(!$parametros) {echo 'Error: no se puede procesar el archivo de configuracion:Nombre del archivo:'.$ruta;
            //return false;
            } else {
                //print_r($parametros);
                $this->servidor=$parametros['servidor'];
                $this->puerto=$parametros['puerto'];
                $this->baseDatos=$parametros['baseDatos'];
                $this->controlador=$parametros['controlador'];
                $this->usuario=$parametros['usuario'];
                $this->clave=$parametros['clave'];
                //return true;
            }
        }
    }

    public function getConexion() {
        return $this->conexion;
    }

    public function conectar() {
        try {
            $dsn = "$this->controlador:host=$this->servidor;port=$this->puerto;dbname=$this->baseDatos";
            $this->conexion = new PDO($dsn, $this->usuario, $this->clave);
            // Configura PDO para lanzar excepciones en errores
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return true;
        } catch (Exception $exc) {
            echo 'No se pudo conectar a la base de datos: ' . $exc->getMessage();
            return false;
        }
    }

    public function desconectar() {
        $this->conexion = null;
    }

    public static function ejecutarQuery($cadenaSQL, $parametros = []) {
        $conectorBD = new ConectorBD();
        if ($conectorBD->conectar()) {
            try {
                $sentencia = $conectorBD->conexion->prepare($cadenaSQL);
                $sentencia->execute($parametros);
                $consulta = $sentencia->fetchAll();
                $sentencia->closeCursor();
            } catch (Exception $exc) {
                echo 'Error al ejecutar cadena SQL: ' . $exc->getMessage();
                $consulta = false;
            }
        } else {
            echo 'No se pudo conectar con la base de datos';
        }
        $conectorBD->desconectar();
        return $consulta;
    }

    public static function retornarTodos($cadenaSQL, $parametros = []) {
        $conectorBD = new ConectorBD();
        if ($conectorBD->conectar()) {
            try {
                $sentencia = $conectorBD->conexion->prepare($cadenaSQL);
                $sentencia->execute($parametros);
                $consulta = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                $sentencia->closeCursor();
            } catch (Exception $exc) {
                echo 'Error al ejecutar cadena SQL: ' . $exc->getMessage();
                $consulta = false;
            }
        } else {
            echo 'No se pudo conectar con la base de datos';
        }
        $conectorBD->desconectar();
        return $consulta;
    }

    public static function retornarUno($cadenaSQL, $parametros = []) {
        $conectorBD = new ConectorBD();
        if ($conectorBD->conectar()) {
            try {
                $sentencia = $conectorBD->conexion->prepare($cadenaSQL);
                $sentencia->execute($parametros);
                $consulta = $sentencia->fetch(PDO::FETCH_ASSOC);
                $sentencia->closeCursor();
            } catch (Exception $exc) {
                echo 'Error al ejecutar cadena SQL: ' . $exc->getMessage();
                $consulta = false;
            }
        } else {
            echo 'No se pudo conectar con la base de datos';
        }
        $conectorBD->desconectar();
        return $consulta;
    }

    public static function retornar_ultimo_Id($cadenaSQL, $parametros = []) {
    $conectorBD = new ConectorBD();
    $resultado = null;

    if ($conectorBD->conectar()) {
        try {
            $sentencia = $conectorBD->conexion->prepare($cadenaSQL);
            $sentencia->execute($parametros);

            if (strpos(strtoupper($cadenaSQL), 'INSERT') !== false) {
                $resultado = array('id' => $conectorBD->conexion->lastInsertId());
            } else {
                $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            }

            $sentencia->closeCursor();
        } catch (Exception $exc) {
            echo 'Error al ejecutar cadena SQL: ' . $exc->getMessage();
            $resultado = false;
        }
    } else {
        echo 'No se pudo conectar con la base de datos';
    }

    $conectorBD->desconectar();
    return $resultado;
}


}
?>
