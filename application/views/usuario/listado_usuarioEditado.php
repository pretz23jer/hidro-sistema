<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$mensaje = isset($mensaje) ? $mensaje : "";

if (count($arr) < 1) {
  $mensaje = "<script>
    Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'No hay ninguna persona registrado en el sistema!',
  }) 
  </script>";
}

$htmltrow = "<tr>
        <td>%s</td>
        <td>%s</td> 
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>  
        <td>%s</td>
        <td>%s</td>
       </tr>\n";
$htmltrows = "";

foreach ($arr as $a) {
$htmltrows .= sprintf($htmltrow, 
    $a['id_usuario'], $a['nombre'], $a['cui'], $a['direccion'], $a['telefono'], $a['usuario'], $a['rol']);
}
?><!DOCTYPE html>
<html lang="es">
<head>
  <?php $this->load->view('layout/header'); ?>
  <title>Usuarios</title>
</head>
<body>
  <?php $this->load->view('layout/menu'); ?>
  <br>
<div class="container">
<header class="espacio">
  <h3 class="azul"><i class="fa-solid fa-rotate"></i> <i class="fa-solid fa-user"></i> Usuario actualizado</h3>
</header>
<br>
<section>
  <div class="table-responsive-sm">
    <table class="table table-striped table-bordered">
    <thead> 
      <tr id="letra_info">
        <th>Código</th>
        <th>Nombres y Apellidos</th>
        <th>Teléfono</th>
        <th class="oculalimprimir">Nombre de Usuario</th>
        <th class="oculalimprimir">Rol en el sistema</th>
      </tr>
    </thead>
    <tbody>
       <?php
          foreach ($arr as $a){
         ?>
          <tr>
            <td><?php echo $a['id_usuario'] ;?></td>
            <td><?php echo $a['nombre'] ;?></td>
            <td><?php echo $a['telefono'] ;?></td>
            <td class="oculalimprimir"><strong><?php echo $a['usuario'] ;?></td>
            <td class="oculalimprimir"><?php echo $a['rol'] ;?></td>
          </tr>
         <?php
            }
          ?>
    </tbody>
    </table>
    <br>
    <div class="text-center">
      <a class='btn btn-primary btn-md botones' href="<?=$base_url?>/Usuario/listar">Listo</a>
      <a class='btn btn-success botones' href="<?=$base_url?>/Usuario/editaruser/<?php echo $a['id_usuario'] ;?>">Editar</a>
    </div>
    <div class="label label-danger label-md" onclick="$(this).hide(1000)"><?=$mensaje?></div>
  </div>
</section>

</div>
<br><br>
<footer class="oculalimprimir"><?php $this->load->view('layout/footer') ?></footer>
</body>
</html>

