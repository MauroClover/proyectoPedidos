<?php
require_once '../model/Conector.php';
require_once '../model/Persona.php';
require_once '../model/Security.php';
require_once '../model/Funciones.php';
require_once '../model/ImgTemporal.php';
require_once '../model/Pedido.php';
require_once '../model/Producto.php';

Security::iniciar_sesion();

$accion='';
date_default_timezone_set('America/Bogota');
$fecha = new DateTime();
$consulta=[];
$respuesta=[];
$resultado=[];
$mensaje = "";
$user=$_SESSION['USUARIO']['id'];
$date=$fecha->format('Y-m-d H:i:s');

if (isset($_POST['accion'])){ 
    $accion=$_POST['accion'];
    switch ($accion){    
        case 'GuardarUser':  
            $arr=array($_POST['nombres'],$_POST['apellidos'],$_POST['identificacion'],$_POST['telefono'],$_POST['correo'],$_POST['tipo'],$_POST['clave'],$fecha->format('Y-m-d H:i:s')); 
            $retorna=Persona::guardar($arr); 
            $mensaje=$retorna>0 ? 'Registro Agregado' : 'hubo novedad con el registro';            
            echo "<script>window.location='../view/usuarios.php?mensaje=$mensaje'</script>";     
        break;
        case 'modificarUser':
            $clave=isset($_POST['pass']) && $_POST['pass'] !='' ? md5($_POST['pass'])  : '';  
            if ($clave == '') {
                $arr=array($_POST['idE'],$_POST['nom'],$_POST['ape'],$_POST['ident'],$_POST['tel'],$_POST['cor'],$_POST['tipo_e'],$fecha->format('Y-m-d H:i:s')); 
            }else{
                $arr=array($_POST['idE'],$_POST['nom'],$_POST['ape'],$_POST['ident'],$_POST['tel'],$_POST['cor'],$_POST['tipo_e'],$clave,$fecha->format('Y-m-d H:i:s')); 
            }
            $retorna=Persona::modificar($arr);  
            $mensaje=$retorna=='' ? 'editado' : $retorna;
            echo "<script>window.location='../view/usuarios.php?mensaje=$mensaje'</script>";
            break;
        case 'verUsuario':
            if (isset($_POST['idUser'])) {
                $id = isset($_POST['idUser']) ? intval($_POST['idUser']) : 0;
                if ($id > 0) {
                    $consulta = Persona::listUno("id=$id");
                    echo json_encode($consulta); 
                } else {
                    echo json_encode(array("error" => "ID no válido"));
                }
            }
            break;
        case 'EliminarUsuario':
            if (isset($_POST['id']) && $_POST['id'] != "") {
              Persona::eliminar($_POST['id']);
              $mensaje='Registro eliminado!';
            } else{
              $mensaje='ups hubo error de envio!';
            }
            $consulta=['id'=>0,'mensaje'=>$mensaje];
            echo json_encode($consulta,JSON_FORCE_OBJECT); 
            break;

        case 'AdicionarImagen':
            $retorna=Funciones::validar_imagen($_FILES["imagen"]);
            if ($retorna[0] == 0) {
                $mensaje=$retorna[1];
            }else{
                $arr=array($retorna[0],$_POST['talla'],$user,$fecha->format('Y-m-d H:i:s')); 
                $ret=ImgTemporal::guardar($arr);
                if($ret > 0){
                    $mensaje="Registro Agregado";
                }else{
                    $mensaje="Hubo error en el envio";
                }
            }  
            echo "<script>window.location='../view/productos.php?mensaje=$mensaje'</script>"; 
            break;

        case 'eliminarImagen':
            if (isset($_POST['id']) && $_POST['id'] != "") {
                ImgTemporal::eliminar($_POST['id']);
                $mensaje='Registro eliminado!';
              } else{
                $mensaje='ups hubo error de envio!';
              }
              $consulta=['id'=>0,'mensaje'=>$mensaje];
              echo json_encode($consulta,JSON_FORCE_OBJECT);
            break;
            
        case 'ApartarPedido':
            $apartado= Pedido::guardar(array($date,0,$user ));
            if ($apartado > 0) {
                $filtro="idpersona=$user";
                $resultado= ImgTemporal::listTodos($filtro);
                foreach ($resultado as $key => $value) {
                    $nombre=$value['nombre'];
                    $talla=$value['talla'];
                $producto= Producto::guardar(array($nombre,$talla,$user,$date,$apartado) );
                }
                if ($producto > 0) {
                    ImgTemporal::eliminarTodo($user);
                }
                $mensaje="Registro Agregado";
            }else{
                $mensaje="Hubo Novedad Con El Envio";
            }
            echo "<script>window.location='../view/productos.php?mensaje=$mensaje'</script>"; 
            break;
    
       

        default:
        $enviar=['resultado'=>0,'mensaje'=>'no existe datos!'];
        $json=json_encode($enviar, JSON_FORCE_OBJECT);
        echo $json;
        break;
    }
}

            
             



?>