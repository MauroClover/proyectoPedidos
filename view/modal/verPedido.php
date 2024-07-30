<?php
$cuerpo='';
$body=' <template id="verApartado_c"> 
            <tr id="apartado_c">
                <td id="idPedido"></td>
                <td><img src="" style="border-radius: 20%" width="100" height="100" alt="imagen"></td>
                <td><input type="text" id="talla" value="" class="form-control"></td>
                <td>
                    <button type="button" id="boton1" value="" onclick="editarTalla(this)" class="btn btn-info btn-sm">editar</button>
                    <button type="button" id="boton2" value="" onclick="eliminarTalla(this)" class="btn btn-danger btn-sm">Borrar</button>
                </td> 
            </tr>
        </template>
';
$cuerpo=$funcion->input('newImagen','','file','',1).
       $funcion->input('newTalla','','text','',1).
       $funcion->boton('Guardar','guardarNuevo','','button','btn-primary btn-sm w-100 mt-2','guardarNew').
       $funcion->tabla([ ['id','producto','talla','Acciones'], $body,'','miTabla' ]) ;
    
echo $funcion->modal('Ver Pedido', 'ver_pedido', $cuerpo, '');



?>
