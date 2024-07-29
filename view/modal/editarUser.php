<?php

$form=$funcion->formulario(
    $funcion->table_form(array(
        ''=>$funcion->input('idE','','hidden','',0),
        'Nombres'=>$funcion->input('nom','','text','',1),
        'Apellidos'=>$funcion->input('ape','','text','',1),
        'Identificacion'=>$funcion->input('ident','','text','',1),
        'Telefono'=>$funcion->input('tel','','phone','',1),
        'Correo'=>$funcion->input('cor','','text','',1),
        'Tipo'=>$funcion->select('tipo_e','',Persona::getTipoEnOptions(),0),
        'Clave'=>$funcion->input('pass','','password','',0),
    )).
 $funcion->boton('Modificar','','modificarUser','submit','btn-primary btn-sm w-100 mt-2','')
);
echo $funcion->modal('Usuario', 'EditarUsuario', $form, '');

?>