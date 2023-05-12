<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$mensaje = isset($mensaje) ? $mensaje : "";

foreach ($arr as $key) {
  $nombre = $key['nombre'];
  $direccion = $key['direccion'];
  $telefono = $key['telefono'];
  $tipo = $key['tipo'];
  $id_proveedor = $key['id_proveedor'];
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
<div class="container">
  <br>
  <div class="azul h4"><i class="fa-solid fa-file-pen"></i> Editar Proveedor</div>
  <br>
  <div class="espacio sombra">
    <form class="needs-validation" novalidate  action="<?=$base_url?>/Proveedor/editar" method="POST">
      <div class="row">
        <div class="col-md-6">
          <label><i class="fa-solid fa-building-user"></i> Nombre del Proveedor</label>
          <input type="text" class="form-control" name="nombre" minlength="3" autocomplete="off" value="<?=$nombre?>"  required>
        </div>
        <div class="col-md-6">
          <label><i class="fa-solid fa-map-location-dot"></i> Dirección</label>
          <input type="text" class="form-control" name="direccion" minlength="3" autocomplete="off" value="<?=$direccion?>" required>
        </div>
        <div class="col-md-6">
          <label><i class="fa-solid fa-phone"></i> Teléfono</label>
          <input type="text" class="form-control" name="telefono" id="telefono" minlength="3" autocomplete="off" value="<?=$telefono?>" required>
        </div>
        <div class="col-md-6">
          <label><i class="fa-brands fa-unity"></i> Tipo de Producto</label>
          <select class="custom-select form-control" required  name="tipo" >
            <option selected><?=$tipo?></option>
            <option>Calentadores</option>
            <option>Bombas</option>
            <option>Suministros</option>
            <option>Plomería</option>
            <option>Fontanería</option>
            <option>Químicos</option>
            <option>Tableros</option>
            <option>Herramientas</option>
            <option>Motores</option>
            <option>Otros</option>
          </select>
        </div>
        <div>
          <br>
          <center>
              <input  type="hidden"  name="id_prove" value="<?=$id_proveedor?>">
              <input class="btn btn-primary btn-md" type="submit" role="button" name="actualizar" value="Actualizar">
            </center>
        </div>
      </div>
    </form>
    <?php $mensaje ?>
    <div class="label label-danger label-md" onclick="$(this).hide(1000)"><?=$mensaje?></div>
  </div>
</div>
<br>
<footer><?php $this->load->view('layout/footer') ?></footer>
<script type="text/javascript">
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

   $(document).ready(function() {
     $("#telefono").mask("0000 0000 0000 0000");
  });

</script>
</body>
</html>
