<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$mensaje = isset($mensaje) ? $mensaje : "";


foreach ($arr as $key) {
	$nombre = $key['nombre'];
	$apellido = $key['apellido'];
	$telefono = $key['telefono'];
	$usuario = $key['usuario'];
	$rol = $key['rol'];
	$id_usuario = $key['id_usuario'];
}

?><!DOCTYPE html>
<html lang="en">
<head>
	<?php $this->load->view('layout/header'); ?>
	<title>Crear Usuario</title>
</head>
<body>
<header>
<?php $this->load->view('layout/menu'); ?>
</header>
<br>
<div class="text-center">
	<h3><i class="fa-solid fa-rotate"></i> Actualizar datos del usuario.</h3>
</div>
</header><br>
	<div id="body">
<section>
	<div class="container">
		<div class="card o-hidden border-0 shadow-lg">
			<div class="row">
				<div class="col-lg-12">
					<div class="p-5">
						<div class="text-center">
							<form class="needs-validation user" id="subir" action="<?=$base_url?>/usuario/editaruser/" method="POST">
								<div class="row">
								<div class="col-12 col-sm-6">
									<label><i class="fa-solid fa-user"></i> Nombres</label>
									<input type="text" class="form-control text-center azul" minlength="2" name="nombre" required placeholder="Nombres" value="<?=$nombre?>" autocomplete="off">
								</div>
								<div class="col-12 col-sm-6">
									<label><i class="fa-solid fa-user"></i> Apellidos</label>
									<input type="text" class="form-control text-center azul" minlength="2" name="apellido" required placeholder="Apellidos" value="<?=$apellido?>" autocomplete="off">
								</div>
							</div>
							<div class="row">
								<div class="col-12 col-sm-3">
									<label><i class="fa-solid fa-mobile-button"></i> Teléfono</label>
									<input type="text" class="form-control text-center" minlength="2" name="telefono" id="telefono" required value="<?=$telefono?>" autocomplete="off" placeholder="Teléfono" onkeypress="return numeros(event)" onpaste="return false">
								</div>
								<?php
								  if ($this->session->ROL == 'Admin') { 
								 ?>
								<div class="col-12 col-sm-3">
										<label><i class="fa-solid fa-user-gear"></i> Rol del Usuario</label>
									<select id="rol" class="custom-select form-control text-center" name="rol" value="<?=$rol?>" required>
										<option value="" selected disabled><?=$rol?></option>
										<option value="Plomero" >Plomero</option>
										<option value="Admin" >Administrador</option>
									</select>
									<h6>Rol aisgnado: <?=$rol?></h6>
								</div>
							<?php } else { ?>
								<input type="hidden"  name="rol" value="<?=$rol?>" required/>
							<?php } ?>
								<div class="col-sm-6 mb-3 mb-sm-0">
								<level><strong>Correo Electrónico<strong class="asterisco">*</strong></strong></level>
								<input type="text" class="form-control text-center form-control-user" placeholder="Usuario" name="usuario" required value="<?=$usuario?>" readonly > <div class="valid-feedback">Correcto!</div>
								</div>
							</div>
							<br>
							<div>
								<center>
									<td colspan="2">
									<input  type="hidden"  name="id_usuario" value="<?=$id_usuario?>">
									<input class="btn btn-primary btn-md botones" type="submit" role="button" name="actualizar" value="actualizar">
								</td>
								</center>
							</div>
							</form>
							<?php $mensaje ?>
							<div class="label label-danger label-md" onclick="$(this).hide(1000)"><?=$mensaje?></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<br>
	<footer><?php $this->load->view('layout/footer') ?></footer>

<script type="text/javascript">
///para validar
(function() {
  'use strict';
  window.addEventListener('subir', function() {
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

  $(document).ready(function() {
     $("#telefono").mask("0000 0000");
  });

$(function(){
		$.post('<?=$base_url?>/usuario/sala').done(function(respuesta){
			$('#sala').html(respuesta);
		});
	});
  
</script>
</body>
</html>
