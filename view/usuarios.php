
<?php 
include_once("cabecera.php");
include_once("modal/editarUser.php");
include_once("modal/crearUser.php");
$resultado=[];
$cuerpo='';
$filtro=$tipo=='C' ? "id=$user" : null;
$resultado= Persona::listTodos($filtro);

if ($tipo=='P') {
foreach ($resultado as $key => $value) {
    $cuerpo.='
          <tr>
            <td>'.$value['id'].'</td>
            <td>'.$value['nombres'].'</td>
            <td>'.$value['apellidos'].'</td>
            <td>'.$value['identificacion'].'</td>
            <td>'.$value['telefono'].'</td>
            <td>'.$value['correo'].'</td>
            <td>'.$value['tipo'].'</td>
            <td>       
            '.$funcion->boton_modal('editar','editarUsuario','editarUser',$value['id'],'btn-primary btn-sm','miFuncion').'
            '.$funcion->boton_eliminar('EliminarUsuario',$value['id'],'usuarios').'
            </td>
        </tr>
    ';
}
echo $funcion->boton_modal('Crear Usuarios','crearUsuario','','','btn-success btn-sm','');
echo $funcion->tabla([ ['id','Nombre','Apellidos','Identificacion','Telefono','Correo','Tipo','Opcion'],$cuerpo ]);

}else{
echo '<center>'.
        $funcion->div(['text-center col-6','',
            $funcion->card('DATOS USUARIO',
                $funcion->formulario(
                    $funcion->input('idE',$resultado[0]['id'],'hidden','',1).
                    $funcion->input('nom',$resultado[0]['nombres'],'text','Nombres',1).
                    $funcion->input('ape',$resultado[0]['apellidos'],'text','Apellidos',1).
                    $funcion->input('ident',$resultado[0]['identificacion'],'text','Identificacion',1).
                    $funcion->input('tel',$resultado[0]['telefono'],'phone','Telefono',1).
                    $funcion->input('cor',$resultado[0]['correo'],'text','Correo',1).
                    $funcion->input('pass','','password','Clave',0).
                    $funcion->boton('Modificar','modificar','modificarUser','submit','btn-primary btn-sm w-100 mt-2','')
                )
            ,'')
        ]).
    '</center>';
    
}
?>

 <script>
  
    function miFuncion(id){
    let editarModal= document.querySelector('#editarUsuario');
    let idE=editarModal.querySelector('.modal-body #idE');
    let nombres=editarModal.querySelector('.modal-body #nom');
    let apellidos=editarModal.querySelector('.modal-body #ape');
    let identificacion=editarModal.querySelector('.modal-body #ident');
    let telefono=editarModal.querySelector('.modal-body #tel');
    let correo=editarModal.querySelector('.modal-body #cor');
    let tipo=editarModal.querySelector('.modal-body #tipo_e');
    let clave=editarModal.querySelector('.modal-body #pass');

        var url= "../controller/controlBack.php";
        var formData = new FormData();
        formData.append("accion", "verUsuario");
        formData.append("idUser", id);
        fetch(url,{
            method: "POST",
            body: formData   
        }) .then(response => response.json()) 
                .then(data => {
                    idE.value =data.id;
                    nombres.value = data.nombres;
                    apellidos.value = data.apellidos;
                    identificacion.value = data.identificacion;
                    telefono.value = data.telefono;
                    correo.value = data.correo;
                    tipo.value = data.tipo;
                }).catch(err => console.log(err));
    }  

</script>



<?php include_once("pie.php")?>



