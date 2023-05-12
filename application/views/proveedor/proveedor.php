<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$mensaje = isset($mensaje) ? $mensaje : "";
?><!DOCTYPE html>
<html lang="es">
<head>
	<?php $this->load->view('layout/header'); ?>
	<title>Crear Proveedor</title>
</head>
<body>
<header>
	<?php $this->load->view('layout/menu'); ?>
</header>
<div class="container">
  <br>
  <h4 class="azul"><i class="fa-solid fa-people-carry-box"></i> Registrar Proveedor</h4>
  <br>
  <div class="sombra espacio">
  <div class="row">
    <div class="col-sm-8">
    </div>
    <div class="col-sm-4">
      <a href="<?=$base_url?>/proveedor/listar" class="btn btn-sm btn-warning"><i class="fa-solid fa-rectangle-list"></i> Listado de Proveedores</a>
    </div>
  </div>
  <br>
  <form action="<?=$base_url?>/proveedor" method="POST">
    <div class="row">
      <div class="col-12 col-sm-6">
        <label class="separa"><i class="fa-solid fa-building-user"></i> Nombre del Proveedor</label>
        <input type="text" class="form-control" name="nombre" value="<?=$nombre?>" required minlength="3" autocomplete="off">
      </div>
      <div class="col-12 col-sm-6">
        <label class="separa"><i class="fa-solid fa-map-location-dot"></i> Dirección</label>
        <input type="text" class="form-control" name="direccion" value="<?=$direccion?>" required minlength="3" autocomplete="off">
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <label class="separa"><i class="fa-solid fa-phone"></i> Teléfono</label>
        <input type="text" class="form-control" onkeypress="return numeros(event)" onpaste="return true" name="telefono" minlength="3" id="telefono" value="<?=$telefono?>" required autocomplete="off">
      </div>
      <div class="col-sm-6">
        <label class="separa"><i class="fa-brands fa-unity"></i> Tipo de Producto</label>
        <select class="custom-select form-control" required  name="tipo" value="<?=$tipo?>">
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
    </div>
    <br>
      <center>
        <div onclick="mensaje()"><?=$boton?></div>
      </center>
  </form>
  <?=$mensaje?>
  </div>
</div>
<br><br><br>
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

   $(document).ready(function() {
     $("#telefono").mask("0000 0000 0000 0000");
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
</script>
</body>
</html>
