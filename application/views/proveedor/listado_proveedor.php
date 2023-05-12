<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$mensaje = isset($mensaje) ? $mensaje : "";

if (count($arr) < 1) {
  $mensaje = "<script>
    Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'No hay ningun proveedor registrado en el sistema!',
  }) 
  </script>";
}
$htmltrow = "<tr>
        <td>%s</td> 
        <td>%s</td>
        <td>%s</td>  
        <td>%s</td>
        <td class='text-center' style='color: #003594'><i class='fa-solid fa-circle-check'></i></td>
        <td class='text-center'><a href=\"${base_url}/Proveedor/baja/%s\" class='btn btn-danger btn-sm'><i class='fa-solid fa-trash-can'></i></a></td>
        <td class='text-center'><a class='btn btn-success btn-sm' href=\"${base_url}/proveedor/editar/%s\"><i class='fa-solid fa-pen-to-square'></i></a></td>
       </tr>\n";
$htmltrows = "";

foreach ($arr as $a) {
  $id_proveedor = $a['id_proveedor'];
  $htmltrows .= sprintf($htmltrow, 
    $a['nombre'], $a['direccion'], $a['telefono'], $a['tipo'], $a['id_proveedor'], $a['id_proveedor']);
}
?><!DOCTYPE html>
<html lang="es">
<head>
  <?php $this->load->view('layout/header'); ?>
  <title>Proveedores</title>
</head>
<body>
  <?php $this->load->view('layout/menu'); ?>
  <div class="container">
    <br>
    <div class="row azul">
      <div class="col-md-8">
        <h3><i class="fa-solid fa-boxes-stacked"></i> Listado de Proveedores</h3>
      </div>
      <div class="col-md-2">
        <a href="<?=$base_url?>/proveedor" class="btn btn-primary btn-sm"><i class="fa-solid fa-file-pen"></i> Registrar Proveedor</a>
      </div>
    </div>
    <hr>
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover">
        <thead> 
          <tr>
            <th>Institución</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Producto</th>
            <th>Estado</th>
            <th>Acción</th>
            <th>Editar</th>
          </tr>
        </thead>
        <tbody>
          <?=$htmltrows?>
        </tbody>
      </table>
      <div class="label label-danger label-md" onclick="$(this).hide(1000)"><?=$mensaje?></div>
    </div>
  </div>
<footer><?php $this->load->view('layout/footer') ?></footer>
</body>
</html>
