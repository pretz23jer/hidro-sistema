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
<div class="espacio">
  <section>
    <div class="row container">
      <div class="col-md-6">
        <h1 style="text-align: right;" class="icon-handbag"></h1>
      </div>
      <div class="col-md-6">
        <h4 style="text-align: left; margin-top: 1%">Registrar Producto</h4>
      </div>
    </div>
  </section>
  <section class="container">
  <a href="<?=$base_url?>/Listar/listar" class="btn btn-warning botones">Listado de Productos</a>
  <a href="" class="btn btn-dark botones" data-toggle="modal" data-target="#staticBackdrop">Registrar Categoría</a>
  <a href="" class="btn btn-info botones" data-toggle="modal" data-target="#ListarCategoria">Listado Categoría</a>
</section>
<hr>
<div class="container fondoF1">
<section>
  <form class="needs-validation text-center" enctype="multipart/form-data" action="<?=$base_url?>/Producto" method="POST">
    <div class="form-row">
      <div class="form-group col-md-2">
        <label for="inputEmail4">CÓDIGO</label>
        <input type="text" class="form-control" id="codigo" maxlength="15" required name="codigo" value="<?=$codigo?>" >
      </div>
      <div class="form-group col-md-6 ">
        <label for="inputPassword4">NOMBRE DEL PRODUCTO</label>
        <input type="text" class="form-control levelc" id="validationCustom02" required name="nombre" value="<?=$nombre?>">
      </div>
      <div class="form-group col-md-4">
        <label for="inputPassword4">CATEGORÍA</label>
        <select name="categoria" id="categoria" class="form-control selectpicker levelc" data-live-search="true" required></select>
      </div>
    </div>
    <div class="form-group">
      <label for="inputAddress">DESCRIPCIÓN</label>
      <input type="text" class="form-control levelc" id="validationCustom03" required maxlength="100" name="descripcion" value="<?=$descripcion?>">
    </div>
    <div class="form-row">
      <div class="form-group col-md-3">
        <label for="inputEmail4">PRECIO COMPRA</label>
        <input type="num" class="form-control integer decimal-2-places levelc" id="validationCustom01 " required placeholder="00000" maxlength="5" name="precio_compra" value="<?=$precio_compra?>">
      </div>
      <div class="form-group col-md-3">
        <label for="inputPassword4">PRECIO VENTA</label>
        <input type="num" class="form-control integer decimal-2-places levelc"  id="validationCustom02" required placeholder="0000" maxlength="5" name="precio_venta" value="<?=$precio_venta?>">
      </div>
      <div class="form-group col-md-2">
        <label for="inputPassword4">EXISTENCIA</label>
        <input type="num" class="form-control integer levelc"  id="validationCustom03" required placeholder="0" maxlength="4" name="existencia" value="<?=$existencia?>">
      </div>
      <div class="form-group col-md-4">
        <label for="inputPassword4">PROVEEDOR</label>
        <select name="proveedor" id="proveedor" class="form-control selectpicker levelc" data-live-search="true" required></select>
      </div>
    </div>
    <div class="form-row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
          <div class="photo">
          <label for="foto"><i class="fa fa-image"></i> Imágen del Producto</label>
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
      <div class="col-md-4"></div>
    </div>
        <br>
     <center>
        <div class="col-sm-9 mb-3 mb-sm-0">
          <input onclick="mensaje()" type="submit" class="btn btn-primary btn-user btn-block botones" id="guardar" role="button" name="guardar" value="¡Registrar Producto!">
        </div>
      </center>
  </form>
</section>
<section><!--MODAL CREARCATEGORIA-->
<div class="modal fade" id="staticBackdrop" data-backdrop="dinamic" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header colormodal">
        <center class="modal-title h5" id="staticBackdropLabel"><i class="icon-rocket fa-md categoria"></i> <i class="icon-bulb fa-md categoria"></i> <i class="icon-puzzle fa-md categoria"></i> Registro de Categoría de Productos</center>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?=$base_url?>/Producto/registroCategoria" enctype="multipart/form-data" method="POST" class="needs-validation" novalidate>
      <div class="modal-body needs-validation">
        
          <div class="form-row">
            <div class="col-md-12">
              <label for="validationCustom01" class="esletra">Categoría</label>
              <input type="text" class="form-control" id="validationCustom01" name="categoria" required>
              <div class="valid-feedback">Muy bien!</div>
              <div class="invalid-feedback">Llenar campo</div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-12">
              <label for="validationCustom01" class="esletra">Descripción</label>
              <input type="text" class="form-control" id="validationCustom01" name="descripcion" required>
              <div class="valid-feedback">Muy bien!</div>
              <div class="invalid-feedback">Llenar campo</div>
            </div>
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger botones" data-dismiss="modal">Cerrar</button>
        <input onclick="mensaje()" type="submit" class="btn btn-primary botones" id="guardarCategoria" role="button" name="guardarCategoria" value="Registrar">
      </div>
    </div>
  </form>
  </div>
</section>
<section><!--MODAL LISTAR CATEGORIA-->
<div class="modal fade" id="ListarCategoria" data-backdrop="dinamic" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header colormodal">
        <center class="modal-title h5" id="staticBackdropLabel"><i class="icon-list fa-md categoria"></i> Listado de Categorías</center>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"><!--listar categorias registradas -->
        <div class="table-responsive-sm">
            <table class="table table-striped table-bordered">
              <thead>
                  <th>Categoria</th>
                  <th>Descripción</th>
                  <th>Elim</th>
              </thead>
              <tbody>
                 <?php
                    foreach ($arr1 as $a){
                   ?>
                    <tr>
                      <td><strong><?php echo $a['categoria'] ;?></td>
                      <td><?php echo $a['descripcion'] ;?></td>
                      <td><a class='btn  btn-danger icon-trash iconos' onchange="return llenar("href='<?=$base_url?>/Producto/eliminarCategoria/<?php echo $a['id_categoria']; ?>') id="id_categoria"></a></td>
                    </tr>
                   <?php
                      }
                    ?>
              </tbody>
            </table>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger botones" data-dismiss="modal">Cerrar</button>
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
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
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
      alertify.set('notifier','position', 'top-right');alertify.error('El archivo exede el tamaño permitido');
      $(obj).val('');
      return;
  }
  img.src = URL.createObjectURL(uploadFile); 
}; 

</script>
<script type="text/javascript" src="<?=$base_url?>/resources/jqueryNumeric/jquery.numeric.js"></script>
<script>

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
  $.post('<?=$base_url?>/Producto/proveedor').done(function(respuesta){
    $('#proveedor').html(respuesta);
  });
});

//Buscar categoria-->

$(function(){
  $.post('<?=$base_url?>/Producto/categoria').done(function(respuesta){
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
                    contactAlert.innerHTML = alertify.set('notifier','position', 'top-right');alertify.error('Imágen no compatible');                       
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
                alertify.set('notifier','position', 'top-right');alertify.error('No seleccionó una imágen');
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
      url: 'Producto/valiData',
      type: "POST",
      async: true,
      data: {action:action,cod:cod},
      
      success: function(response){
        if(response != 'error'){
          var info = $.parseJSON(response); 
            //console.log(info);
          if(info.length > 0){

           //$('#codigo').val(''); 
            $('#guardar').slideUp();
            alertify.set('notifier','position', 'top-right');alertify.error('El Código que está ingresando ya existe! Ingrese otra.');  
          }
          else{
           $('#guardar').slideDown();
          }
        }
      }
    });
  });

</script>
</body>
</html>
