<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Guatemala');
?><!DOCTYPE html>
<html lang="es">
<head>
	<title>Inicio</title>
	<?php $this->load->view('layout/header'); ?>
</head>
<body style="background-color: #F4F4F4;">
<header>
<?php
	if (isset($this->session->USUARIO)) { ;?>	
		<?php $this->load->view('layout/menu'); ?>
<div >
	<div class="row container">
		<div class="col-12 col-md-4">
			<h4 class="container" style="color: #FF0000;"> <?php if (isset($this->session->USUARIO)) { ;?><i class="fa-solid fa-user-tie"></i>  <?php }; ?> <?php echo $this->session->ROL ?> <strong style="color: #000;"><?php echo $this->session->NOMBRE ?></strong></h4>
		</div>
	<?php }; ?>
		
	</div>
</div>
</header>
<div style="background-color:white;">
	<div class="container pt-5 mt-5 pb-5">
	<center>
		<h1 style="font-weight: bold; color: #003594;">Bienvenidos</h1>
		<img class="img-fluid mt-3 mb-3" src="<?=$base_url?>/recursos/img/hidroa.png" width="150">
	</center>

	<br><br>
		<?php
			if (isset($this->session->USUARIO)) { ;?>	
		<?php }else{ ; ?>
			<center>
			<a class="btn btn-lg botones" style="background-color: #0057B8; color: #FFFFFF;" href="<?=$base_url?>/usuario"><i class="fa-regular fa-user"></i> INGRESAR</a>
			</center>
		<?php	}; ?>
	<br>
	</div>
</div>
<?php $this->load->view('layout/footer'); ?>
<script type="text/javascript">

</script>
</body>
</html>
