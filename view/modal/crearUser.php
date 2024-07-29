<?php

$form=$funcion->formulario(
    $funcion->table_form(array(
        'Nombres'=>$funcion->input('nombres','','text','',1),
        'Apellidos'=>$funcion->input('apellidos','','text','',1),
        'Identificacion'=>$funcion->input('identificacion','','text','',1),
        'Telefono'=>$funcion->input('telefono','','phone','',1),
        'Correo'=>$funcion->input('correo','','text','',1),
        'Tipo'=>$funcion->select('tipo','',Persona::getTipoEnOptions(),0),
        'Clave'=>$funcion->input('clave','','password','',1),
    )).
 $funcion->boton('Guardar','','GuardarUser','submit','btn-primary btn-sm w-100 mt-2','')
);
echo $funcion->modal('Usuario', 'crearUsuario', $form, '');

?>