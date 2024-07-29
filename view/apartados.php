<?php 
include_once("cabecera.php");
require_once '../model/Pedido.php';

$body='';
$respuesta=Pedido::listTodos(null);
foreach ($respuesta as $key => $value) {
    $body.='
         <tr>
            <td>'.$value['fecha'].'</td>
            <td>'.$value['person'].'</td>
            <td>'.$value['estado'].'</td>
            <td>
            '.$funcion->boton_eliminar('eliminarApartado',$value['id'],'productos').'
            </td>
        </tr>
        ';
}

echo $funcion->tabla([ ['Fecha','Usuario','Estado','opcion'],$body,'','tabla_id' ]);

include("pie.php")
?>


