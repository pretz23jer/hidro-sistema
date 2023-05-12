<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$mensaje = isset($mensaje) ? $mensaje : "";
$id_cliente = "";

foreach ($arr as $key) {
  $nombre = $key['nombre1'];
  $apellido = $key['apellido'];
  $cui = $key['cui'];
  $direccion = $key['direccion'];
  $nit = $key['nit'];
  $numero1 = $key['numero1'];
  $numero2 = $key['numero2'];
  $depto = $key['depto'];
  $muni = $key['muni'];
  $id_cliente = $key['id_cliente'];
}

?><!DOCTYPE html>
<html lang="es">
<head>
  <?php $this->load->view('layout/header'); ?>
  <title>Editar Proveedor</title>
</head>
<body>
<header>
  <?php $this->load->view('layout/menu'); ?>
</header>
<br>
 <div class="text-center">
  <h4><i class="fa-solid fa-user-pen"></i> Editar cliente</h4>
</div>
</header>
<br>
<section>
<div class="container forma">
  <form class="needs-validation" novalidate id="editar" name="editar" method="POST">
    <div class="row">
    <div class="col-sm-2">
      <label class="separa" for="validationCustom02">Código</label>
      <input type="text" class="form-control integer" id="validationCustom02" name="codigo" required placeholder="0000" maxlength="4" value="<?=$id_cliente?>" readonly>
      <div class="valid-feedback">
      </div>
    </div>
    <div class="col-sm-5">
      <label class="separa" for="validationCustom01">Nombres</label>
      <input type="text" class="form-control" id="validationCustom01" name="nombre" required value="<?=$nombre?>">
      <div class="valid-feedback">
      </div>
    </div>
    <div class="col-sm-5">
      <label class="separa" for="validationCustom01">Apellidos</label>
      <input type="text" class="form-control" id="validationCustom01" name="apellido" required value="<?=$apellido?>">
      <div class="valid-feedback">
      </div>
    </div>
    <div class="col-sm-4">
      <label class="separa" for="validationCustom02">CUI</label>
      <input type="text" class="form-control" name="cui" id="cui" required maxlength="13" value="<?=$cui?>">
      <div class="valid-feedback">
      </div>
    </div>
    <div class="col-sm-2">
      <label class="separa" for="validationCustom02">NIT</label>
      <input type="text" class="form-control integer" id="validationCustom02" name="nit" required maxlength="13" value="<?=$nit?>">
      <div class="valid-feedback">
      </div>
    </div>
        <div class="col-md-3 mb-3">
      <label class="separa" for="validationCustom04">1er. número de Teléfono</label>
      <input type="text" class="form-control" name="numero1" id="tel1" required placeholder="Teléfono / Celular" required placeholder="00000000" maxlength="8"  min="7" value="<?=$numero1?>">
      <div class="valid-feedback">
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <label class="separa" for="validationCustom04">2do. número de Teléfono</label>
      <input type="text" class="form-control" name="numero2" id="tel2" maxlength="14"  required placeholder="Teléfono / Celular" value="<?=$numero2?>">
  </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <label class="separa" for="validationCustom02">Dirección</label>
      <input type="text" class="form-control" id="validationCustom02" name="direccion" required placeholder="Dirección" required value="<?=$direccion?>">
      <div class="valid-feedback">
      </div>
    </div>
    <div class="col-md-3">
          <label class="separa"><i class="fa-solid fa-flag"></i> Departamento asignado:</label>
          <h6 style="color: #6F0000" class="text-center"><?=$depto?></h6>
          <select class="custom-select negro form-control" id="departamento" name="departamento" required>
          </select>
        </div>
        <div class="col-md-3">
          <label class="separa"><i class="fa-brands fa-font-awesome"></i> Municipio asignado</label>
           <h6 style="color: #6F0000" class="text-center"><?=$muni?></h6>
          <select class="custom-select negro form-control" name="muni" id="muni" required>
            <option value="" disabled selected>Seleccionar</option>
          </select>
        </div>
      </div>
  <br>
  <center>
    <td colspan="2">
      <center>
        <input  type="hidden"  name="id_clientito" value="<?=$id_cliente?>">
        <button type="submit" class="btn btn-primary btn-sm" id="actualizar" name="actualizar" value="Actualizar"><i class="fa-solid fa-arrows-rotate"></i><strong> Actualizar</strong></button>
      </center>
    </td>
  </center>
</form>
<div class="label label-danger label-md" onclick="$(this).hide(1000)"><?=$mensaje?></div>
</div>
</section>
<br><br>
  <footer><?php $this->load->view('layout/footer') ?></footer>
</body>
<script type="text/javascript">
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

    $(document).ready(function() {
     $("#cui").mask("0000 00000 0000");
  });

  $(document).ready(function() {
     $("#tel1").mask("0000 0000");
  });

  $(document).ready(function() {
     $("#tel2").mask("0000 0000 0000 0000");
  });
$('#actualizar').submit(function(e){
    e.preventDefault();
    $.ajax({
      url: '<?=$base_url?>/cliente/editar',
        type: "POST",
        async: true,
        data: $('#editar').serialize(),
        success: function(response){
        }
    });
  });
</script>
</html>
