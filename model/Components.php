<?php

class Components {

    public function __construct() {
    
    }
    
    public static function input($name,$value,$tipo,$placeholder,$requerido){
    $required = $requerido == 1 ? "required" : "";
       $input='
          <div>
            <input class="form-control" type="'.$tipo.'" id="'.$name.'" name="'.$name.'" value="'.$value.'" placeholder="'.$placeholder.'"  '.$required.'>
          </div>
          
       ';
       return $input;
    }
    
    public static function select($name,$value,$opcion,$requerido){
        $required = $requerido == 1 ? "required" : "";
       $select='
          <div>
            <select class="form-select" id="'.$name.'" name="'.$name.'" value="'.$value.'" '.$required.'> '.$opcion.' </select>
          </div>
       ';
       return $select;
    }
    
    public static function img($name,$imagen,$ancho,$alto,$complemento){
        $img='';
        $img='
            <img name="'.$name.'" id="'.$name.'" src="imagenes/'.$imagen.'" width="'.$ancho.'" height="'.$alto.'" alt="imagen" '.$complemento.'/>
        ';
        return $img;
    }
    
    
    //---------------------------botones-------------------------------
    public static function boton($titulo,$name,$value,$tipo,$class,$evento){
        $event = isset($evento) && $evento !='' ? $event='onclick="'.$evento.'(\''.$value.'\')"' : $event='';
    
       $boton='
            <button type="'.$tipo.'" '.$event.' name="accion" value="'.$value.'" id="'.$name.'" class="btn '.$class.'" >'.$titulo.'</button>
          
       ';
       return $boton;
    }
    
    public static function boton_modal($titulo, $name, $pagina, $data, $clase, $evento) {
        $event = isset($evento) && $evento !='' ? $event='onclick="'.$evento.'(\''.$data.'\')"' : $event='';
        $boton = '
            <button type="button" '.$event.' class="btn '.$clase.'" data-bs-toggle="modal" data-bs-target="#'.$name.'" >'.$titulo.'</button>
        ';
    
        return $boton;
    }
    
    
    public static function boton_eliminar($accion,$id,$ruta){
        $boton='
            <button type="button" onclick="borrar(\''.$id.'\')" name="accion" value="" id="" class="btn btn-danger btn-sm" >Eliminar</button>
        ';
        $boton.='
            <script>
                function borrar(id){
                    Swal.fire({
                    title: "desea eliminar este registro?",
                    showCancelButton: true,
                    confirmButtonText: "si",
                    }).then((result) => {
                    if (result.isConfirmed) {
                        var url= "../controller/controlBack.php";
                        var formData = new FormData();
                        formData.append("accion", "'.$accion.'");
                        formData.append("id", id);
                        fetch(url,{
                            method: "POST",
                            body: formData   
                        }) .then(response => response.json()) 
                                .then(data => {
                                    window.location="./'.$ruta.'.php?mensaje="+data.mensaje;
                                }).catch(err => console.log(err));
    
                    } 
                    })                
                }
            </script>
        ';
        return $boton;
    }
    
    //-----------------formularios--------------------------------------------
    public static function formulario($body){
       $form='
          <form action="../controller/controlBack.php" method="post" enctype="multipart/form-data">
               '.$body.'
          </form>
          
       ';
       return $form;
    }
    
    public static function table_form($body){ 
        $mostrar='';
        foreach ($body as $key => $value) {
            $mostrar.='
                    <tr>
                       <th><label class="text-primary">'.$key.'</label></th><th>'.$value.'</th> 
                    </tr>
                  ';  
            }
          
       $table='
             <center>
                 <table>'.$mostrar.' </table>
             </center>
          
       ';
       return $table;
    }
    
    public static function tabla($array){
      $titulo='';
      $encabezado=$array[0];
      $body=$array[1];
      $class=isset($array[2]) ? $array[2] : '';
      $idClass=isset($array[3]) ? "id=".$array[3]." " : '';
      foreach ($encabezado as $key => $value) {
        $titulo.='<th>'.$value.'</th>';
      }

      $lista='
           <table class="table bordered  table-hover table-responsive '.$class.'" '.$idClass.'>
                <thead class="table-dark align-content-center">
                    <tr>
                    '.$titulo.'
                    </tr>
                </thead>
                <tbody class="bg-white text-left">
                    '.$body.'
                </tbody>
            </table>
      ';
      return $lista;
    }
    //----------------------------------------modales--------------------------------------------
    
    public static function modal($titulo, $name, $body, $footer) {
        $modal = '
            <div class="modal fade" id="' . $name . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="' . $name . 'Label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h5 class="text-white text-center" id="' . $name . 'Label">' . $titulo . '</h5>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                        <div class="modal-body">
                            '.$body.'
                        </div>
                        <div class="modal-footer">
                            '.$footer.'
                        </div>
                    </div>
                </div>
            </div>';
    
        return $modal;
    }
    
    public static function card($titulo,$body,$footer){
    
        $card='
            <div class="card text-center my-2 d-flex">
                <div class="card-header bg-info">
                    <h5 class="text-dark">'.$titulo.'</h5>
                </div>
                <div class="card-body">
                    '.$body.'              
                </div>
                <div class="card-footer">
                    '.$footer.'
                <div>
            </div>
    
        ';
        return $card;
    }
    

}
$funcion=new Components();




