<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$mensaje = isset($mensaje) ? $mensaje : "";
foreach ($arr as $a) {
  $id = $a['id_usuario'];
}
?><!DOCTYPE html>
<html lang="es">
<head>
	<?php $this->load->view('layout/header'); ?>

	<title>Autenticación</title>
</head>
<body>
	<?php $this->load->view('layout/menu'); ?>
<div class="container mt-3">
	<h5 class="text-center"><i class="fa-solid fa-arrows-rotate"></i> Generar otra contraseña</h5>
	<div class="abs-center">
		<div class="container p-lg-5" id="container-fluid bg">
			<form class="form-container" action="<?=$base_url?>/usuario/restaurar_datos/" method="POST">
			<div class="row">
					<div class="col-12 col-lg-6">
						<div class="form-group">
							<center><label><i class="fa-solid fa-key"></i>Nueva Contraseña</label></center>
							<div class="input-group">
								<input id="clave1" type="password" Class="form-control text-center" minlength="8" placeholder="Contraseña" name="clave1" autocomplete="off" required>
								<div class="input-group-append">
									<button id="ver1" class="btn btn-primary" type="button" onclick="verificar()"> <span class="fa fa-eye-slash icon"></span> </button>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-6">
						<div class="form-group">
							<center><label><i class="fa-solid fa-key"></i>Repetir Contraseña</label></center>
							<div class="input-group">
								<input id="clave2" type="password" Class="form-control text-center" placeholder="Contraseña" name="clave2" autocomplete="off" required onkeyup="ValidarPass()">
								<div class="input-group-append">
									<button id="show_password" class="btn btn-primary" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
								</div>
							</div>
						</div>
					</div>
					<input type="hidden" name="id" value="<?php echo $id; ?>"> 
					<div class="mt-3">
						<td colspan="2">
							<center><button type="submit" id="enviar" disabled = "false" class="btn btn-success btn-md" role="button" name="Enviar" value="Enviar"><i class="fa fa-sync-alt"></i> Actualizar</button></center>
						</td></div>
						<center><div id="mensaje"></div></center>
						<center><div><?php echo $mensaje; ?></div></center>
				</form>
			</div>
		</div>
	</div>
</div>
</body>
<script type="text/javascript">
var ValidarPass = function() {
var valor1 = $("#clave1").val();
var valor2 = $("#clave2").val();
var botonEnviar = document.getElementById('enviar');


if (valor1 != valor2) {
	$("#mensaje").text("Contraseñas no coinciden");
	$("#mensaje").addClass("alert alert-danger");
	botonEnviar.disabled = true;//desactiva el boton
}else {
	botonEnviar.disabled = false;//activa el boton
	$("#mensaje").removeClass("alert alert-danger");
	$("#mensaje").text("");
}
};
function mostrarPassword(){
		var cambio = document.getElementById("clave2");
		if(cambio.type == "password"){
			cambio.type = "text";
			$('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		}else{
			cambio.type = "password";
			$('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		}
	};

	function verificar(){
		var cambio = document.getElementById("clave1");
		if(cambio.type == "password"){
			cambio.type = "text";
			$('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		}else{
			cambio.type = "password";
			$('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		}
	};
</script>
</html>
