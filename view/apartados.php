<?php 
include_once("cabecera.php");
require_once '../model/Pedido.php';
include_once("modal/verPedido.php");
$body='';
$estado='';
$filtro=$tipo=='C' ? "idpersona=$user" : null;
$respuesta=Pedido::listTodos($filtro);
foreach ($respuesta as $key => $value) {
  $estado=$value['estado']==0 ? $funcion->boton('Activo','estado',$value['estado'],'button','btn-info btn-sm','') : $funcion->boton('Inactivo','estado',$value['estado'],'button','btn-danger btn-sm','');
  $btn=$tipo=='C' ? '' : $funcion->boton_eliminar('eliminarApartado',$value['id'],'apartados');
    $body.='
         <tr>
            <td>'.$value['id'].'</td>
            <td>'.$value['fecha'].'</td>
            <td>'.$value['person'].'</td>
            <td>'.$estado.'</td>
            <td>
            '.$funcion->boton_modal('Ver Pedido', 'ver_pedido', '', $value['id'], 'btn btn-primary', 'verPedido').
              $btn.
            '
            </td>
        </tr>
        ';
}
echo $funcion->tabla([ ['Id','Fecha','Usuario','Estado','opcion'],$body,'','' ]);

include_once("pie.php")
?>

<script src="../js/apartados.js"></script>



