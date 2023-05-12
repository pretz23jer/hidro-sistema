<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$mensaje = isset($mensaje) ? $mensaje : "";
?><!DOCTYPE html>
<html lang="es">
<head>
	<?php $this->load->view('layout/header'); ?>
	<title>Autenticación</title>
</head>
<body class="fondo">
	<script type="text/javascript">document.oncontextmenu = function(){return false;}</script>
	<div class="container-fluid">
		<br>
		<center> <img src="<?=$base_url?>/recursos/img/hidroa.png" width="90"></center>
		<br>
		<section>
			<div class="row">
				<div class="col-sm-1 col-md-2 col-lg-4"></div>
				<div class="col-12 col-sm-10 col-md-8 col-lg-4">
					<form class="form-container needs-validation blanco" novalidate action="<?=$base_url?>/usuario" method="POST">
						<center><i class="fa-solid fa-users-gear mb-4 fs-1"></i></center>
						<h3 class="h4 mb-3 fw-normal text-center">Iniciar Sesión</h3>
						<div class="form-floating">
							<input type="email" class="form-control text-center" placeholder="Correo Electrónico" name="usuario" autocomplete="off" minlength="8" required>
							<div class="invalid-feedback">
								Por favor ingrese su correo electrónico
							</div>
							<label for="usuario" class="text-center">Correo Electrónico</label>
						</div>
						<div class="form-floating">
							<div class="input-group">
								<input id="password_clave" type="Password" Class="form-control text-center p-2" placeholder="Contraseña" name="clave" autocomplete="off" required>
								<div class="input-group-append">
									<button id="show_password" class="btn btn-primary p-2" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
								</div>
								<div class="invalid-feedback">
									Por favor ingrese su contraseña
								</div>
							</div>
						</div>
						<button class="w-100 btn btn-lg btn-primary mt-3" type="submit" role="button" id="btnAL_1" name="login" value="Ingresar">Ingresar</button>
					</form>
					<div role="alert" class="alert-link" style="color: #FFF" onclick="$(this).hide(1000)"><center><h4><?=$mensaje?></h4></center>
					</div>
					<div class="col-sm-1 col-md-2 col-lg-4"></div>
				</div>
			</div>
	</section>
	<br>
	</div>
	<script type="text/javascript" >
	(function () {
	'use strict'

	  var forms = document.querySelectorAll('.needs-validation')

	  Array.prototype.slice.call(forms)
	    .forEach(function (form) {
	      form.addEventListener('submit', function (event) {
	        if (!form.checkValidity()) {
	          event.preventDefault()
	          event.stopPropagation()
	        }

	        form.classList.add('was-validated')
	      }, false)
	    })
	})();

  	function mostrarPassword(){
		var cambio = document.getElementById("password_clave");
		if(cambio.type == "password"){
			cambio.type = "text";
			$('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		}else{
			cambio.type = "password";
			$('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		}
	};
	</script>
</body>
</html>