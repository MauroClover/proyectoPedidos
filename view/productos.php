<?php 
include_once("cabecera.php");
require_once '../model/ImgTemporal.php';

$body='';
$respuesta=ImgTemporal::listTodos("idpersona=$user");
foreach ($respuesta as $key => $value) {
    $body.='
         <tr>
            <td>'.$funcion->img('',$value['nombre'],'100','100','').'</td>
            <td>'.$value['talla'].'</td>
            <td>
            '.$funcion->boton_eliminar('eliminarImagen',$value['id'],'productos').'
            </td>
        </tr>
        ';
}

echo $funcion->card('Crear Pedido',
    $funcion->formulario(
        $funcion->input('imagen','','file','',1).
        $funcion->input('talla','','text','Talla del producto',1).
        $funcion->boton('Agregar','','AdicionarImagen','submit','btn-primary text-center w-100 mt-2','')
    ).
    $funcion->tabla([ ['Imagen','talla','opcion'],$body ]),
    $funcion->formulario($funcion->boton('Apartar Pedido','','ApartarPedido','submit','btn-success text-center w-100 mt-2','') ))
    ;

?>
<?php include("pie.php")?>

