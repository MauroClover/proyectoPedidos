<?php
session_start();
session_unset();
session_destroy();
$mensaje='';
if (isset($_REQUEST['mensaje'])) $mensaje=$_REQUEST['mensaje'];
?>
<html>
  <head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/estyle.css">
    <title>Apartados</title>
  </head>

  <body style=" background: rgb(2,0,36); background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(233,45,216,1) 41%, rgba(0,212,255,1) 100%);"><br> 

   <div class="container">
    <div class="row">
        

    <div class="col-sm-0 col-dm-0 col-lg-4 col-xl-4"></div>
        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
            <br><br><br>
            <div class="card border_10" >
                <div class="card-header bg-dark ">
                  <center>
                    <h3 class="text-white">Apartados </h3>
                     <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#registrar_cliente"> Registrar</button>
                  </center>
                  
                </div>
                <div class="card-body border-3">
                    <p style="background-color: yellow; border-radius: 15px; text-align: center;"><font color="red"><?=$mensaje?></font></p>
                    <form  method="POST" action="controller/validar.php">
                    <div class = "form-group">
                    <label class="text-primary">Usuario</label>
                    <input type="text" name="usuario" class="form-control"  placeholder="numero de identificacion">
                    
                    </div>
                    <div class="form-group">
                    <label class="text-primary">Clave</label>
                    <input type="password" name="clave" class="form-control" placeholder="Password">
                    </div>
                         <button type="submit" value="Ingresar" class="btn btn-primary btn-sm w-100 mt-2">Ingresar</button>
                    </form>
               </div>
            </div>
        </div>

    <!-- Modal -->
        <div class="modal fade" id="registrar_cliente" tabindex="-1" aria-labelledby="registrar_clienteLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header text-white bg-info">
                <h5 class="modal-title" id="registrar_clienteLabel">Registrar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form method="POST" action="controller/registrar.php">
                  <div class="modal-body">
                    <center>
                     <table>
                         <body>
                            <tr>
                                <td><label class="text-primary">Nombre</label></td><td><input type="text" name="nombres" class="form-control" required ></td>
                            </tr>
                            <tr>
                                <td><label class="text-primary">Apellidos</label></td><td><input type="text" name="apellidos" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td><label class="text-primary">Identificacion</label></td><td><input type="number" name="identificacion" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td><label class="text-primary">Telefono</label></td><td><input type="number" name="telefono" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td><label class="text-primary">Correo</label></td><td><input type="email" name="correo" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td><label class="text-primary">Clave</label></td><td><input type="password" name="clave" class="form-control" required></td>
                            </tr>
                         </body>
                     </table>
                    </center>
                  </div>
                  <div class="modal-footer">
                        <button type="submit" name="accion" value="registrarse" class="btn btn-primary btn-sm w-100 mt-2">Registrar</button>   
                  </div>
              </form>

            </div>
          </div>
        </div>
        
    </div>
   </div>
   <script src="./js/bootstrap.bundle.min.js"></script>
</body>

</html> 