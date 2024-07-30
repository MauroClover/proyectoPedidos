const template = document.getElementById('verApartado_c').content;
const fragment = document.createDocumentFragment();
let url= "../controller/controlBack.php";

function verPedido(id){
    var btn = document.querySelector("#ver_pedido #guardarNuevo").value=id;
    let formData = new FormData();
    formData.append("accion", "mostrarApartado");
    formData.append("idapartado", id);
    fetch(url,{
        method: "POST",
        body: formData   
    }) .then(response => response.json()) 
            .then(data => {
              pintarApartado(data);
            }).catch(err => console.log(err));
  }

const pintarApartado = data => {
  const imagen = './imagenes/';
  let modal= document.getElementById('ver_pedido');
  var tabla = modal.querySelector("#miTabla").getElementsByTagName('tbody')[0];
  tabla.innerHTML = '';    
  const dataArray = Object.values(data.respuesta); 
  dataArray.forEach(item => {
    const clone = template.cloneNode(true);
    clone.querySelector('img').src = imagen + item.nombre;
    clone.querySelector('#idPedido').textContent  = item.id;
    clone.querySelector('#boton1').value = item.id;
    clone.querySelector('#boton2').value = item.id;
    clone.querySelector('#talla').value = item.talla;
    fragment.appendChild(clone);
});
tabla.appendChild(fragment);
};

function guardarNew(){
  var btn = document.querySelector("#ver_pedido #guardarNuevo").value;
  var img = document.querySelector("#ver_pedido #newImagen").files[0];
  var talla = document.querySelector("#ver_pedido #newTalla").value;
  if (!talla || !img) {
    mensaje('favor Llenar los campos');
  }else{
    let formData = new FormData();
    formData.append("accion", "agregarImagen");
    formData.append("imagen", img);
    formData.append("talla", talla);
    formData.append("apartado", btn);
    fetch(url,{
        method: "POST",
        body: formData   
    }) .then(response => response.json()) 
            .then(data => {
              verPedido(btn);
              mensaje(data.mensaje);
              document.querySelector("#ver_pedido #newImagen").value='';
              document.querySelector("#ver_pedido #newTalla").value='';
            }).catch(err => console.log(err));
  }
}
  
function eliminarTalla(buttonElement){
  var card = buttonElement.closest('#apartado_c');
  var apartado = document.querySelector("#ver_pedido #guardarNuevo").value;
  var btn = card.querySelector("#boton2").value;
  let formData = new FormData();
    formData.append("accion", "eliminarPedido");
    formData.append("idproducto", btn);
    fetch(url,{
        method: "POST",
        body: formData   
    }) .then(response => response.json()) 
            .then(data => {
              verPedido(apartado);
              mensaje(data.mensaje);
            }).catch(err => console.log(err));
}

function editarTalla(buttonElement){
  var card = buttonElement.closest('#apartado_c');
  var apartado = document.querySelector("#ver_pedido #guardarNuevo").value;
  var btn = card.querySelector("#boton1").value;
  var talla = card.querySelector("#talla").value;
  let formData = new FormData();
    formData.append("accion", "editarPedido");
    formData.append("idproducto", btn);
    formData.append("talla", talla);
    fetch(url,{
        method: "POST",
        body: formData   
    }) .then(response => response.json()) 
            .then(data => {
              verPedido(apartado);
              mensaje(data.mensaje);
            }).catch(err => console.log(err));
}

function mensaje(msg){
    Swal.fire({icon:"success", title:msg});
    }