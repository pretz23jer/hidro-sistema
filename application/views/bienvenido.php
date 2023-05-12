<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$mensaje = isset($mensaje) ? $mensaje : "";

?><!DOCTYPE html>
<html lang="es">
<head>
	<?php $this->load->view('layout/header'); ?>
	<title>Bienvenido</title>
</head>
<body>
	<?php $this->load->view('layout/menu'); ?>
<div class="container">
		<br>
	<header>
		<center><h3 style="color: #3538A7"><img width="150" src="<?=$base_url?>/recursos/img/hidroa.png"/></h3></center>
	</header>
<br><br>
    <center><h2>Bienvenido al Sistema</h2>
  <br>
  <h3 style="color: #0DDF12"><?php echo $this->session->NOMBRE ?></h3></center>
  <br><br>
 <div class="progress">
  <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
</div>
<br>
<br><br><br>
</div>
<footer><?php $this->load->view('layout/footer') ?></footer>
<script>
  Swal.fire({
        icon: 'success',
        title: 'Bienvenido al Sistema',
        text: '<?php echo $this->session->NOMBRE ?>',
        showConfirmButton: false,
        timer: 1200
      })
</script>
</body>
</html>
