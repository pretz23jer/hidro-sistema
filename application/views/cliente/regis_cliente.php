<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$mensaje = isset($mensaje) ? $mensaje : "";
$mensaje_res = isset($mensaje_res) ? $mensaje_res : "";
$mensaje_err = isset($mensaje_err) ? $mensaje_err : "";

?><!DOCTYPE html>
<html lang="es">
<head>
	<?php $this->load->view('layout/header'); ?>
	<title>Crear Cliente</title>
</head>
<body>
<header>
  <?php $this->load->view('layout/menu'); ?>	
</header>
<br>
  	<h4 class="text-center azul"><i class="fa-solid fa-user-plus"></i> Ingresar cliente</h4>
</header>
<br>
<div class="container">
  <div class="forma">
    <form method="POST" action="<?=$base_url?>/cliente">
      <div class="row">
        <div class="col-md-4">
          <label class="separa"><i class="fa-solid fa-id-card"></i> CUI</label>
          <input type="text" class="form-control" id="cui" name="cui" value="0" required>
        </div>
        <div class="col-md-4">
          <label class="separa"><i class="fa-solid fa-user-pen"></i> Nombres</label>
          <input type="text" class="form-control" name="nombre" value="<?=$nombre?>" maxlength="35" required>
        </div>
        <div class="col-md-4">
          <label class="separa"><i class="fa-solid fa-user-pen"></i> Apellidos</label>
          <input type="text" class="form-control" name="apellido" value="<?=$apellido?>" maxlength="35" required>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <label class="separa"><i class="fa-solid fa-id-card-clip"></i> NIT</label>
          <input type="text" class="form-control" name="nit" value="<?=$nit?>" maxlength="15" required>
        </div>
        <div class="col-md-4">
          <label class="separa"><i class="fa-solid fa-mobile"></i> Teléfono</label>
          <input type="text" class="form-control" id="tel1" name="numero1" onkeypress="return numeros(event)" value="<?=$numero1?>" required>
        </div>
        <div class="col-md-4">
          <label class="separa"><i class="fa-solid fa-mobile-button"></i> Teléfono 2</label>
          <input type="text" class="form-control" id="tel2" name="numero2" onkeypress="return numeros(event)" value="<?=$numero2?>" minlength="1" required>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <label class="separa"><i class="fa-solid fa-location-dot"></i> Dirección</label>
          <input type="text" class="form-control" name="direccion" value="<?=$direccion?>" maxlength="50" required>
        </div>
        <div class="col-md-3">
          <label class="separa"><i class="fa-solid fa-flag"></i> Departamento</label>
          <select class="custom-select negro form-control" id="departamento" name="departamento" required></select>
        </div>
        <div class="col-md-3">
          <label class="separa"><i class="fa-brands fa-font-awesome"></i> Municipio</label>
          <select class="custom-select negro form-control" name="muni" id="muni" required>
            <option value="" disabled selected>Seleccionar</option>
          </select>
        </div>
      </div>
      <br>
      <center><div><?=$boton?></div></center>
    </form>
  </div>
</div>
<br>
<?=$mensaje?><?=$mensaje_res?><?=$mensaje_err?>
<div class="container">
  <div class="forma">
    <a href="<?=$base_url?>/cliente/listar" class="btn btn-light btnlista  btn-sm"><i class="fa-solid fa-list-ul"></i> Listado de Cliente</a>
    <a href="<?=$base_url?>/venta/crear_venta" class="btn btn-sm btn-light btnventa"><i class="fa-solid fa-cart-shopping"></i> Crear Venta</a>
  </div>
</div>
<br><br><br>
  <footer><?php $this->load->view('layout/footer') ?></footer>
</div>
</body>
<script>
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

  $(document).ready(function() {
     $("#cui").mask("0000 00000 0000");
  });

  $(document).ready(function() {
     $("#tel1").mask("0000 0000");
  });

  $(document).ready(function() {
     $("#tel2").mask("0000 0000 0000 0000");
  });

  function numeros(e){
    key=e.keyCode || e.which;
    teclado = String.fromCharCode(key);
    numero="0123456789";
    especial="8-38-38-46";
    tecla_especial=false;
    for(var i in especial){
      if(key==especial[i]){
        tecla_especial=true;
      }
    }
    if (numero.indexOf(teclado)==-1 && !tecla_especial) {
      return false;
    }
  };

  //funcion Ajax para buscar en base de datos
  $(function(){
    $.post('<?=$base_url?>/cliente/departamento').done(function(respuesta){
    $('#departamento').html(respuesta);
  });

  //lista de municipios
  $('#departamento').change(function(){
    var id_depto = $(this).val();

    $.post('<?=$base_url?>/cliente/municipio',{departamento: id_depto}).done(function(respuesta){
        $('#muni').html(respuesta);
      });
    });
  });

</script>
</html>