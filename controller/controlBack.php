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
$type=$_SESSION['USUARIO']['tipo'];
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
            $_POST['tipo_e'] = $type=='C' ? 'C' : $_POST['tipo_e'];
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
                $id=$_POST['id'];
                $resultado=ImgTemporal::listUno("id=$id" );
                $name=$resultado['nombre'];
                if(file_exists("../view/imagenes/".$name)){
                    unlink("../view/imagenes/".$name);
                    ImgTemporal::eliminar($_POST['id']);
                    $mensaje='Registro eliminado!';
                }else{
                    $mensaje='No existe la imagen'; 
                }                
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
        
            case 'mostrarApartado':
                    if (isset($_POST['idapartado']) && $_POST['idapartado'] !='') {
                    $id=$_POST['idapartado'];
                    $filtro="idapartado=$id";
                    $consulta=Producto::listTodos($filtro);
                    $data = array('respuesta' => $consulta);
                    } else{
                        $mensaje='error no llegaron los datos!';
                        $data=['repuesta'=>0,'mensaje'=>$mensaje];
                    }
                echo json_encode($data, JSON_FORCE_OBJECT);
                break;
            
            case 'agregarImagen':
                if (isset($_POST['apartado']) && $_POST['apartado'] !='') {
                    $retorna=Funciones::validar_imagen($_FILES["imagen"]);
                    if ($retorna[0] == 0) {
                        $mensaje=$retorna[1];
                    }else{
                        $producto= Producto::guardar(array($retorna[0],$_POST['talla'],$user,$date,$_POST['apartado']) ); 
                        if($producto > 0){
                            $mensaje="Registro Agregado";
                        }else{
                            $mensaje="Hubo error en el envio";
                        }
                    } 
                    $data=['repuesta'=>$_POST['apartado'],'mensaje'=>$mensaje];
                }else{
                    $data=['repuesta'=>$_POST['apartado'],'mensaje'=>'hubo error con el envio!']; 
                }
                
                echo json_encode($data);
                break;
            
            case 'eliminarPedido':
                if (isset($_POST['idproducto']) && $_POST['idproducto'] != "") {
                    $id=$_POST['idproducto'];
                    $resultado=Producto::listUno("id=$id" );
                    $name=$resultado['nombre'];
                    if(file_exists("../view/imagenes/".$name)){
                        unlink("../view/imagenes/".$name);
                        Producto::eliminar($id);
                        $mensaje='Registro eliminado!';
                    }else{
                        $mensaje='No existe la imagen'; 
                    }
                    
                  } else{
                    $mensaje='ups hubo error de envio!';
                  }
                  $consulta=['id'=>$id,'mensaje'=>$mensaje];
                  echo json_encode($consulta);
                break;

            case 'editarPedido':
                if (isset($_POST['idproducto']) && $_POST['idproducto'] != "") {
                    $id=$_POST['idproducto'];
                    $resultado=Producto::listUno("id=$id" );
                    Producto::modificar([$id,$resultado['nombre'],$_POST['talla'],$resultado['idpersona'],$date,$resultado['idapartado']]);
                    $mensaje='Editado';
                  } else{
                    $mensaje='ups hubo error de envio!';
                  }
                  $consulta=['id'=>$id,'mensaje'=>$mensaje];
                  echo json_encode($consulta);
                break;

            case 'eliminarApartado':
                if (isset($_POST['id']) && $_POST['id'] != "") {
                    $id=$_POST['id'];
                    $resultado=Producto::listTodos("idapartado=$id");
                    foreach ($resultado as $key => $value) {
                        $nombre=$value['nombre'];
                        if(file_exists("../view/imagenes/".$nombre)){
                            unlink("../view/imagenes/".$nombre);
                        }
                        Producto::eliminar($value['id']);
                    }
                    Pedido::eliminar($id);
                    $mensaje='Registro Eliminado';

                }else{
                    $mensaje='ups hubo error de envio!';
                }
                $retorna=['id'=>$id,'mensaje'=>$mensaje];
                echo json_encode($retorna);
                break;
    
       

        default:
        $enviar=['resultado'=>0,'mensaje'=>'no existe datos!'];
        $json=json_encode($enviar, JSON_FORCE_OBJECT);
        echo $json;
        break;
    }
}

            
             



?>