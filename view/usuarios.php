
<?php 
include_once("cabecera.php");
include_once("modal/editarUser.php");
include_once("modal/crearUser.php");
echo $funcion->boton_modal('Crear Usuarios','crearUsuario','','','btn-success btn-sm','');

?>
<div class="row">
<div class="col-sm-6 col-md-12 col-lg-12">
        <table  class="table table-hover table-responsive-sm " id="tabla_id">
            <thead class="table-dark " id="tabla_editar">
                <tr>
                <th>Id</th><th>nombre</th><th>apellidos</th><th>identificacion</th><th>telefono</th><th>correo</th><th>tipo</th><th>opcion</th>
                </tr>
            </thead>
            <tbody id="tableUsuario" class="bg-white">
                <?php 
                $resultado=[];
                $resultado= Persona::listTodos(null);
                foreach ($resultado as $key => $value) {
                   $id=$value['id'];
                   $nombres=$value['nombres'];
                   $apellidos=$value['apellidos'];
                   $identificacion=$value['identificacion'];
                   $telefono=$value['telefono'];
                   $correo=$value['correo'];
                   $tipo=$value['tipo'];     
                ?>
                
                <tr>
                    <td><?= $id ?></td>
                    <td><?= $nombres ?></td>
                    <td><?= $apellidos?></td>
                    <td><?= $identificacion?></td>
                    <td><?= $telefono?></td>
                    <td><?= $correo?></td>
                    <td><?= $tipo?></td>
                    <td>       
                    <?= $funcion->boton_modal('editar','editarUsuario','editarUser',$id,'btn-primary btn-sm','miFuncion'); ?>
                    <?= $funcion->boton_eliminar('EliminarUsuario',$id,'usuarios')?>
                    </td>
                </tr>
                
                <?php  }?>
            </tbody>
        </table>
    </div>
    </div>

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



