<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$mensaje = isset($mensaje) ? $mensaje : "";
if (count($arr) < 1) {
  $mensaje = "<script>
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: 'No hay datos registrados'
              })
            </script>";
}
?><!DOCTYPE html>
<html lang="es">
<head>
  <?php $this->load->view('layout/header'); ?>
  <title>Detalle Cliente</title>
</head>
<body>
  <?php $this->load->view('layout/menu'); ?>
<div class="container"><br>
  <header>
    <h3><i class="fa fa-user-cog"></i> Detalle del Cliente</h3>
  </header>
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <th>Código</th>
        <th>Nombre del Cliente</th>
        <th class='text-center'>CUI</th>
        <th>Dirección</th>
      </thead>
      <tbody>
        <?php
          foreach ($arr as $a){
         ?>
          <tr>
            <td class='text-center'><?php echo $a['id_cliente'] ;?></td>
            <td><?php echo $a['nombre'] ;?></td>
            <td class='text-center'><?php echo $a['cui'] ;?></td>
            <td><?php echo $a['direccion'] ;?></td>
          </tr>
         <?php } ?>
      </tbody>
    </table>
    <br>
    <table class="table table-bordered">
      <thead>
        <th class='text-center'>No. Tel 1</th>
        <th class='text-center'>No. Tel 2</th>
        <th class='text-center'>Estado</th>
        <th class='text-center'>Quién registró</th>
        <th class='text-center'>NIT</th>
      </thead>
      <tbody>
        <?php
          foreach ($arr as $a){
         ?>
          <tr>
            <td class='text-center'><?php echo $a['numero1'] ;?></td>
            <td class='text-center'><?php echo $a['numero2'] ;?></td>
            <td class='text-center'><?php echo $a['estado'] ;?></td>
            <td class='text-center'><?php echo $a['nombre1'] ;?></td>
            <td class='text-center'><?php echo $a['nit'] ;?></td>
          </tr>
         <?php } ?>
      </tbody>
    </table>
    <br>
    <br>
    <center>
      <a class="oculalimprimir" class='btn btn-lg' href="<?=$base_url?>/cliente/listar"><i class="fa-solid fa-circle-check edit"></i> Listo</a></center>
    <div class="label label-danger label-md" onclick="$(this).hide(1000)"><?=$mensaje?></div>
  </div><br><br>
</div>
  <footer class="oculalimprimir"><?php $this->load->view('layout/footer') ?></footer>
</body>
</html>
