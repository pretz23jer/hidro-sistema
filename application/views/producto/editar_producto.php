<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$mensaje = isset($mensaje) ? $mensaje : "";
if (count($arr) < 1) {
  $mensaje = "<script>
    Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'No hay ningun producto registrado en el sistema!',
  }) 
  </script>";
}

$foto = '';
$classRemove = 'notBlock';

foreach ($arr as $a) {
  $idP = $a['id_producto'];
  $codigoP = $a['codigo'];
  $nombreP = $a['nombreProducto'];
  $descripcion = $a['descripcion'];
  $categoria = $a['categoria'];
  $precioc = $a['precio_compra'];
  $preciov = $a['precio_venta'];
  $existencia = $a['existencia'];
  $proveedor = $a['proveedor'];
  $imagen = $a['imagen'];

    if ($a['imagen'] != 'img_energy.jpg') {
    $classRemove = '';
    $foto = '<img id="img" src="'.$base_url.'/recursos/upload/'.$imagen.'" alt="Producto">';
  }
}
?><!DOCTYPE html>
<html lang="es">
<head>
  <?php $this->load->view('layout/header'); ?>
  <title>Editar Producto</title>
</head>
<body>
<header>
<?php $this->load->view('layout/menu'); ?> 
</header>
<div class="container-fluid">
  <br>
  <center>
    <div class="row">
      <div class="col-2 col-sm-4" style="text-align: right; font-weight: bold"><i class="fa fa-edit"></i></div>
      <div class="col-6 col-sm-4" style="text-align: left;"><h5>Editar Producto seleccionado</h5></div>
      <div class="col-2 col-sm-4"><a href="<?=$base_url?>/producto/listar" class="btn btn-warning"><i class="fa fa-list"></i> Listado</a></div>
    </div>
  </center>
  <div class="editProd">
    <form method="POST" class="needs-validation" name="updateRegistro" action="updateProducto" id="updateProducto" enctype="multipart/form-data">
    <input type="hidden" name="id_produ" value="<?php echo $idP; ?>">
    <div style="margin: 15px;">
      <div class="row">
        <div class="col-sm-4">
          <label for="codigo"><i class="fa fa-code-branch"></i> Código del Producto</label>
          <input type="text" class="form-control" name="codigoP" id="codigoP" required="" value="<?php echo $codigoP; ?>">
        </div>
        <div class="col-sm-8">
          <label for="nombreP"><i class="fa fa-pen-nib"></i> Nombre del Producto</label>
          <input type="text" class="form-control" name="nombreP" id="nombreP" required="" value="<?php echo $nombreP; ?>">
        </div>
      </div>
      <div class="row" style="padding-top: 15px;">
        <div class="col-sm-12">
          <label for="descripcion"><i class="fa fa-clipboard"></i> Descripción del Producto</label>
          <input type="text" class="form-control" name="descripcion" id="descripcion" required="" value="<?php echo $descripcion; ?>">
        </div>
      </div>
      <div class="row" style="padding-top: 15px;">
        <div class="col-sm-2">
          <label for="precioc"><i class="fa fa-money-bill-wave-alt"></i> Precio Compra Q.</label>
          <input type="text" class="form-control decimal-2-places positive" name="precioc" id="precioc" required="" value="<?php echo $precioc; ?>">
        </div>
        <div class="col-sm-2">
          <label for="preciov"><i class="fa fa-money-bill-wave-alt"></i> Precio Venta Q.</label>
          <input type="text" class="form-control decimal-2-places positive" name="preciov" id="preciov" required="" value="<?php echo $preciov; ?>">
        </div>
        <div class="col-sm-1">
          <label for="existencia"><i class="fa fa-hashtag"></i> Stock</label>
          <input type="text" class="form-control" name="existencia" id="existencia" required="" value="<?php echo $existencia; ?>">
        </div>
        <div class="col-sm-3">
          <label for="categoria"><i class="fa fa-cubes"></i> Categoría</label>
          <select name="categoria" id="categoria" class="form-control selectpicker levelc" data-live-search="true" required></select><strong>Categoría actual:</strong> <?php echo $categoria ?>
        </div>
        <div class="col-sm-4">
          <label for="proveedor"><i class="fa fa-building"></i> Proveedor</label>
          <select name="proveedor" id="proveedor" class="form-control selectpicker levelc" data-live-search="true" required></select><strong>Proveedor actual:</strong> <?php echo $proveedor; ?>
        </div>
      </div>
      <br>
      <center>
        <label for="imagen"><i class="fa fa-image"></i> Imágen del producto</label>
      <div style="padding-top: 20px;">
        <input type="hidden" name="id" id="foto_actual" value="<?php echo $idP; ?>">
        <input type="hidden" name="foto_actual" id="foto_actual" value="<?php echo $imagen; ?>">
        <input type="hidden" name="foto_remove" id="foto_remove" value="<?php echo $imagen; ?>">
        <div class="photo">
            <div class="prevPhoto">
              <span class="delPhoto <?php echo $classRemove; ?>"><i class="fa-solid fa-xmark"></i></span>
              <label for="foto"></label>
              <?php echo $foto; ?>
            </div>
            <div class="upimg">
                <input type="file" name="foto" id="foto">
            </div>
          <div id="form_alert"></div>
        </div>
      </div>
      <br>
        <button type="submit" class="btn btn-primary" name="updateRegistro" value="guardar"><i class="fa fa-save"></i> Actualizar</button>
      </center>
    </div>
  </form><!--fin form-->
  </div>
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
  }
</script>
<!-- Buscar al proveedor-->
<script>
$(function(){
  $.post('<?=$base_url?>/producto/proveedor').done(function(respuesta){
    $('#proveedor').html(respuesta);
  });
})
</script>
<!-- Buscar categoria-->
<script>
$(function(){
  $.post('<?=$base_url?>/producto/categoria').done(function(respuesta){
    $('#categoria').html(respuesta);
  });
});

 //SELEC FOTO PRODUCTO ---------------------
$(document).ready(function(){
    $("#foto").on("change",function(){
      var uploadFoto = document.getElementById("foto").value;
        var foto = document.getElementById("foto").files;
        var nav = window.URL || window.webkitURL;
        var contactAlert = document.getElementById('form_alert');
        
            if(uploadFoto !='') {
                var type = foto[0].type;
                var name = foto[0].name;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png') {
                    contactAlert.innerHTML = 
                    Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Imágen no compatible!',
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
                text: 'No seleccionó ninguna imágen!',
              }) 
                $("#img").remove();
            }              
    });

    $('.delPhoto').click(function(){
      $('#foto').val('');
      $(".delPhoto").addClass('notBlock');
      $("#img").remove();

      if($("#foto_actual") && $("#foto_remove")){
        $("#foto_remove").val('img_energy.jpg');
      }

    });

});

 $('#updateProducto').submit(function(e){
    e.preventDefault();
    $.ajax({
      data: new FormData(this),
        url: '<?=$base_url?>/producto/editarDatosProducto',
        type: "POST",
        async: true,
        contentType: false,
        cache: false,
        processData:false,
      success: function(response){

        if (response == true){
          redlistaraceptados();
        } else{
          redlistaraceptados(); 
        }
      }
    });
  });

  function redlistaraceptados(){
    window.location.href='<?=$base_url?>/producto/listar';
  };

</script>
</body>
</html>

