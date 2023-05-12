<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$mensaje = isset($mensaje) ? $mensaje : "";

$htmltrow = "<tr>
        <td>%s</td> 
        <td>%s</td>
        <td>%s</td>       
       </tr>\n";
$htmltrows = "";

foreach ($arr1 as $a) {
  $id_categoria = $a['id_categoria'];
  $htmltrows .= sprintf($htmltrow, $a['categoria'], htmlspecialchars($a['descripcion']), $a['id_categoria']);
}
?><!DOCTYPE html>
<html lang="es">
<head>
	<?php $this->load->view('layout/header'); ?>
	<title>Crear Producto</title>
</head>
<body>
<header>
	<?php $this->load->view('layout/menu'); ?> 
</header>
<div class="container-fluid">
  <br>
  <div class="row">
    <div class="col-md-6">
      <h4 class="azul text-center"><i class="fa-solid fa-truck-ramp-box"></i> Registrar Producto</h4>
    </div>
    <div class="col-md-2">
      <a href="<?=$base_url?>/producto/listar" class="btn btn-warning btn-sm"><i class="fa-solid fa-list-check"></i> Listado de Productos</a>
    </div>
    <div class="col-md-2">
      <a href="#" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa-solid fa-laptop"></i> Registrar Categoría</a>
    </div>
    <div class="col-md-2">
      <a href="#" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#ListarCategoria"><i class="fa-solid fa-list-check"></i> Listado Categoría</a>
    </div>
  </div>
  <br>
  <div class="espacio sombra">
    <form class="needs-validation text-center" enctype="multipart/form-data" action="<?=$base_url?>/producto" method="POST">
      <div class="row">
        <div class="form-group col-md-2">
          <label for="inputEmail4 separa">CÓDIGO</label>
          <input type="text" class="form-control" id="codigo" maxlength="15" required name="codigo" value="<?=$codigo?>" >
        </div>
        <div class="form-group col-md-6 ">
          <label for="inputPassword4 separa">NOMBRE DEL PRODUCTO</label>
          <input type="text" class="form-control levelc" id="validationCustom02" required name="nombre" value="<?=$nombre?>">
        </div>
        <div class="form-group col-md-4">
          <label for="inputPassword4 separa">CATEGORÍA</label>
          <select name="categoria" id="categoria" class="form-control selectpicker levelc" data-live-search="true" required></select>
        </div>
      </div>
      <div class="form-group">
        <label for="inputAddress separa">DESCRIPCIÓN</label>
        <input type="text" class="form-control levelc" id="validationCustom03" required maxlength="100" name="descripcion" value="<?=$descripcion?>">
      </div>
      <div class="row">
        <div class="form-group col-md-3">
          <label for="inputEmail4 separa">PRECIO COMPRA</label>
          <input type="num" class="form-control integer decimal-2-places levelc" id="precio_compra" required placeholder="00000" maxlength="10" name="precio_compra" value="<?=$precio_compra?>">
        </div>
        <div class="form-group col-md-3">
          <label for="inputPassword4 separa">PRECIO VENTA</label>
          <input type="num" class="form-control integer decimal-2-places levelc" id="precio_venta" required placeholder="0000" maxlength="10" name="precio_venta" value="<?=$precio_venta?>">
        </div>
        <div class="form-group col-md-2">
          <label for="inputPassword4 separa">EXISTENCIA</label>
          <input type="num" class="form-control positive"  id="validationCustom03" required placeholder="0" maxlength="4" name="existencia" value="<?=$existencia?>">
        </div>
        <div class="form-group col-md-4">
          <label for="inputPassword4 separa">PROVEEDOR</label>
          <select name="proveedor" id="proveedor" class="form-control selectpicker levelc" data-live-search="true" required></select>
        </div>
      </div>
      <br>
    <div class="row">
      <div class="photo">
        <label for="foto">Imágen del Producto</label>
              <div class="prevPhoto">
              <span class="delPhoto notBlock">X</span>
              <label for="foto"></label>
              </div>
              <div class="upimg">
              <input type="file" name="foto" id="foto" class="form-control" required>
              </div>
              <div id="form_alert"></div>
      </div>
    </div>
        <br>
     <center>
        <div class="col-sm-9 mb-3 mb-sm-0">
          <input onclick="mensaje()" type="submit" class="btn btn-primary btn-user btn-block botones" id="guardar" role="button" name="guardar" value="¡Registrar Producto!">
        </div>
      </center>
    </form>
  </div>
</div>
<section><!--MODAL CREARCATEGORIA-->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header colormodal">
        <center class="modal-title h5" id="staticBackdropLabel"><i class="icon-rocket fa-md categoria"></i> <i class="icon-bulb fa-md categoria"></i> <i class="icon-puzzle fa-md categoria"></i> Registro de Categoría de Productos</center>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?=$base_url?>/producto/registroCategoria" enctype="multipart/form-data" method="POST" class="needs-validation" novalidate>
      <div class="modal-body needs-validation">
          <div class="form-row">
            <div class="col-md-12">
              <label for="validationCustom01" class="esletra">Categoría</label>
              <input type="text" class="form-control" id="validationCustom01" name="categoria" minlength="3" autocomplete="off" required>
              <div class="valid-feedback">Muy bien!</div>
              <div class="invalid-feedback">Llenar campo</div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-12">
              <label for="validationCustom01" class="esletra">Descripción</label><br>
              <textarea class="form-control" id="validationCustom01" name="descripcion" minlength="3" autocomplete="off" required cols="30" rows="5"></textarea>
              <div class="valid-feedback">Muy bien!</div>
              <div class="invalid-feedback">Llenar campo</div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar</button>
        <input onclick="mensaje()" type="submit" class="btn btn-primary" id="guardarCategoria" role="button" name="guardarCategoria" value="Registrar">
      </div>
    </div>
  </form>
  </div>
</section>
<section><!--MODAL LISTAR CATEGORIA-->
<div class="modal fade" id="ListarCategoria" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header colormodal">
        <center class="modal-title h5" id="staticBackdropLabel"><i class="fa-solid fa-list"></i> Listado de Categorías</center>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body"><!--listar categorias registradas -->
        <div class="table-responsive-sm">
          <table class="table table-striped table-bordered">
            <thead>
                <th>Categoria</th>
                <th>Descripción</th>
            </thead>
            <tbody>
              <?php foreach ($arr1 as $a){ ?>
                  <tr>
                    <td><strong><?php echo $a['categoria'] ;?></td>
                    <td><?php echo $a['descripcion'] ;?></td>
                    <?php if($a['nivel'] == "S"){ ?>
                    <td><i class="fa-solid fa-screwdriver-wrench"></i></td>
                    <?php } else { ?>

                    <?php } ?>
                  </tr>
                <?php } ?>
            </tbody>
          </table>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar</button>
      </div>
    </div>
  </div>
</section>
</div>
<br>
<footer><?php $this->load->view('layout/footer') ?></footer>
<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    var forms = document.getElementsByClassName('needs-validation');
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();

//validar tamaños de archivo
function ValidarTamaño(obj){
  var uploadFile = obj.files[0];
  var sizeByte = obj.files[0].size;
  var siezekiloByte = parseInt(sizeByte / 2048);
  if(siezekiloByte > 100){
    Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'El tamaño excede el tamaño.!',
  }) 
      $(obj).val('');
      return;
  }
  img.src = URL.createObjectURL(uploadFile); 
}; 

  $(document).ready(function(){
    validarCualquierNumero()
  });

  function validarCualquierNumero(){
    $(".numeric").numeric();
    $(".integer").numeric(false, function() { alert("Integers only"); this.value = ""; this.focus(); });
    $(".positive").numeric({ negative: false }, function() { alert("No negative values"); this.value = ""; this.focus(); });
    $(".decimal-2-places").numeric({ decimalPlaces: 2 });
    $("#remove").click(
      function(e)
      {
        e.preventDefault();
        $(".numeric,.positive,.decimal-2-places").removeNumeric();
      }
      );
  };

$(function(){
  $.post('<?=$base_url?>/producto/proveedor').done(function(respuesta){
    $('#proveedor').html(respuesta);
  });
});

//Buscar categoria-->

$(function(){
  $.post('<?=$base_url?>/producto/categoria').done(function(respuesta){
    $('#categoria').html(respuesta);
  });
});
 //SELEC FOTO PRODUCTO ---------------------
$(document).ready(function(){
    $("#foto").on("change",function(){
      var uploadFoto = document.getElementById("foto").value;
        var foto       = document.getElementById("foto").files;
        var nav = window.URL || window.webkitURL;
        var contactAlert = document.getElementById('form_alert');
        
            if(uploadFoto !='')
            {
                var type = foto[0].type;
                var name = foto[0].name;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png')
                {
                    contactAlert.innerHTML =  Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Imágen no compatible.!',
                    });                       
                    $("#img").remove();
                    $(".delPhoto").addClass('notBlock');
                    $('#foto').val('');
                    return false;
                }else{  
                        contactAlert.innerHTML='';
                        $("#img").remove();
                        $(".delPhoto").removeClass('notBlock');
                        var objeto_url = nav.createObjectURL(this.files[0]);
                        $(".prevPhoto").append("<img id='img' src="+objeto_url+">");
                        $(".upimg label").remove();
                        
                    }
              }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'No seleccionó ninguna imágen.!',
                  });
                $("#img").remove();
              }              
    });

    $('.delPhoto').click(function(){
      $('#foto').val('');
      $(".delPhoto").addClass('notBlock');
      $("#img").remove();

    });

});

  $('#codigo').keyup(function(e){
    e.preventDefault();

    var cod = $(this).val();
    var action = 'buscarCodigo';

    $.ajax({
      url: '<?=$base_url?>/producto/valiData',
      type: "POST",
      async: true,
      data: {action:action,cod:cod},
      
      success: function(response){
        console.log(response);
        if(response != 'error'){
          var info = $.parseJSON(response); 
            //console.log(info);
          if(info.length > 0){

           //$('#codigo').val(''); 
            $('#guardar').slideUp();
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'El Código del producto ya existe, ingrese otra por favor.!',
            }) ;  
          }
          else{
          $('#guardar').slideDown();
          }
        }
      }
    });
  });


document.querySelectorAll('.printbutton').forEach(function(element) {
    element.addEventListener('click', function() {
        print();
    });
});
</script>
</body>
</html>
