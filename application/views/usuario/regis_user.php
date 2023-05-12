<?php defined('BASEPATH') OR exit('No direct script access allowed');
$mensaje = isset($mensaje) ? $mensaje : "";
$id = $this->session->IDUSUARIO;
?><!DOCTYPE html>
<html lang="es">
<head>
	<?php $this->load->view('layout/header'); ?>
	<title>Crear Usuario</title>
</head>
<body>
<header>
<?php $this->load->view('layout/menu'); ?>
</header>
<div class="container">
	<br>
	<div class="row">
		<div class="col-12 col-sm-12">
			<div class="h3 text-center azul"><i class="fa fa-user-plus"></i> Registrar nuevo usuario</div>
		</div>
	</div>
	<br>
<section>
		<div class="card o-hidden border-0 shadow-lg">
			<div class="row">
				<div class="col-lg-12">
					<div class="p-5">
						<div class="text-center">
							<form class="needs-validation user" id="subir" action="<?=$base_url?>/usuario/crear/" method="POST">
							<div class="row">
								<div class="col-12 col-sm-6">
									<label class="separa"><i class="fa-solid fa-user"></i> Nombres</label>
									<input type="text" class="form-control text-center azul" minlength="2" name="nombre" required placeholder="Nombres" value="<?=$nombre?>" autocomplete="off">
								</div>
								<div class="col-12 col-sm-6">
									<label class="separa"><i class="fa-solid fa-user"></i> Apellidos</label>
									<input type="text" class="form-control text-center azul" minlength="2" name="apellido" required placeholder="Apellidos" value="<?=$apellido?>" autocomplete="off">
								</div>
							</div>
							<!--
							<div class="row">
								<div class="col-12 col-sm-5">
									<label class="separa"><i class="fa-solid fa-address-card"></i> CUI</label>
									<input type="text" class="form-control text-center azul" minlength="2" maxlength="13" name="cui" id="cui" value="<?=$cui?>" required autocomplete="off" placeholder="CUI" onkeypress="return numeros(event)" onpaste="return false"> 
								</div>
								<div class="col-12 col-sm-7">
									<label class="separa"><i class="fa-solid fa-location-dot"></i> Dirección</label>
									<input type="text" class="form-control" minlength="2" name="direccion" required autocomplete="off" value="<?=$direccion?>" placeholder="Dirección"> 
								</div>
							</div>
						-->
							<div class="row">
								<div class="col-12 col-sm-3">
									<label class="separa"><i class="fa-solid fa-mobile-button"></i> Teléfono</label>
									<input type="text" class="form-control text-center" minlength="2" name="telefono" id="telefono" required value="<?=$telefono?>" autocomplete="off" placeholder="Teléfono" onkeypress="return numeros(event)" onpaste="return false">
								</div>
								<div class="col-12 col-sm-3">
										<label class="separa"><i class="fa-solid fa-user-gear"></i> Rol del Usuario</label>
									<select id="rol" class="custom-select form-control text-center" name="rol" value="<?=$rol?>" required>
										<option value="" selected disabled>Seleccionar</option>
										<option value="Plomero" >Plomero</option>
										<option value="Admin" >Administrador</option>
									</select>
								</div>
								<div class="col-12 col-sm-6">
									<label class="separa"><i class="fa-solid fa-user-tag"></i> Correo Eléctrónico</label>
									<input type="email" class="form-control text-center" minlength="2" name="usuario" id="" required value="<?=$usuario?>" autocomplete="off" placeholder="example@gmail.com">
								</div>
							</div>
							<div class="row">
								<div class="col-12 col-sm-4">
									<label class="separa"><i class="fa-solid fa-unlock-keyhole"></i> Contraseña</label>
									<input type="text" class="form-control text-center" minlength="2" name="clave" id="clave" required value="<?=$clave?>" autocomplete="off" placeholder="">
								</div>
								<div class="col-12 col-sm-4">
									<label class="separa"><i class="fa-solid fa-unlock-keyhole"></i> Repita Contraseña</label>
									<input type="text" class="form-control text-center" minlength="2" name="clave2" id="clave2" required value="<?=$clave2?>" autocomplete="off" placeholder="">
								</div>
							</div>
							<br>
							<div class="form-group row">
								<div class="col-sm-12">
									<input type="hidden" name="guardar" value="guardar">
									<button type="submit" class="btn btn-primary botones"><i class="fa fa-save"></i> Registrar Cuenta</button>
								</div>
							</div>
							</form>
						</div>
						<div class="alert" role="alert" class="alert-link" style="color: red" onclick="$(this).hide(1000)"><h5><?=$mensaje?></h5>
						</div>
					</div>
				</div>
			</div>
		</div>
</section>
</div>
<br>
<footer><?php $this->load->view('layout/footer') ?></footer>
<script type="text/javascript">
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
  };

   $(document).ready(function() {
     $("#telefono").mask("0000 0000");
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

</script>
</body>
</html>
