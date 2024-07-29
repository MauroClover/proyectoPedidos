<?php
require_once '../model/Persona.php';
require_once '../model/Conector.php';
require_once '../model/TipoPersona.php';
require_once '../model/Security.php';
require_once '../model/Components.php';

Security::iniciar_sesion();
if(isset($_SESSION['USUARIO'])) {
  $person=$_SESSION['USUARIO'];
        $nombreUsuario = $person['nombres']." ".$person['apellidos'];
        $user=$person['id'];
        date_default_timezone_set('America/Bogota');
        $fecha = new DateTime();
        $date=date("Y-m-d H:i:s");

} else {
    header('location: ../index.php?mensaje=Acceso no autorizado');
    exit();
}


?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css"> 
    <title>Sistema ventas</title>
    <script
    src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
    crossorigin="anonymous">
    </script>
  
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
    
    <script src="http://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>       
</head>

<body>
   
<div class="row">
  <div class="container"> 
      <nav class="navbar navbar-expand-md bg-dark ">
          <div class="container-fluid ">
            <a class="navbar-brand" href="#"><i class="bi bi-amd text-white"></i><label class="text-white"><?=$nombreUsuario?> </label></a>
            <button class="navbar-toggler  bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarToggler" style="justify-content: space-between;">
              <ul class="navbar-nav ms-auto my-1 text-white">
                <?= TipoPersona::getMenu($person['tipo']) ?>
                  <div class="container text-primary align-items-end centrar">
                  <a class="btn btn-danger" onclick="exit()" role="button">cerrar sesion</a> 
                </div>
               </ul>
            </div>
          </div>
        </nav>
  </div> 
</div><br>
 

 <?php if (isset($_GET['mensaje'])) {?>
<script>
Swal.fire({icon:"success", title:"<?php echo $_GET['mensaje'];?>"});
</script>

<?php }?>

<script>
function exit(){
    Swal.fire({
  title: 'Esta seguro de salir?',
  showCancelButton: true,
  confirmButtonText: 'si',
}).then((result) => {
  if (result.isConfirmed) {
    window.location="../index.php";
  } 
})
}
</script>
  
    <div class="container">
   
    
            
      
    
  