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
  <div class="row">
    <div class="col-sm-8">
      <h3 class="azul"><i class="fa fa-users"></i> Listado de usuarios del sistema</h3>
    </div>
    <div class="col-sm-4">
      <a href="<?=$base_url?>/usuario/crear" class="btn btn-primary btn-sm" ><i class="fa fa-plus"></i> Nuevo </a>
      <a href="<?=$base_url?>/usuario/excel_archivo" class="btn btn-success btn-sm" ><i class="fa-solid fa-file-excel"></i> Descargar </a>
    </div>
  </div>
<section>
  <div class="table-responsive-sm">
    <table class="table table-striped table-bordered table-hover">
    <thead> 
      <tr id="letra_info">
        <th>No.</th>
        <th>Nombres y Apellidos</th>
        <th>Teléfono</th>
        <th class="oculalimprimir">Nombre de Usuario</th>
        <th class="oculalimprimir">Estado</th>
        <th class="oculalimprimir">Rol en el sistema</th>
        <th class="oculalimprimir">Editar</th>
        <th class="oculalimprimir">Pass</th>
        <th class="oculalimprimir">Eliminar</th>
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
            <td class="oculalimprimir"><?php echo $a['estado'] ;?></td>
            <td class="oculalimprimir"><?php echo $a['rol'] ;?></td>
            <td class="oculalimprimir"><a class='btn  btn-success btn-sm' onchange="return llenar("href='<?=$base_url?>/usuario/editaruser/<?php echo $a['id_usuario']; ?>') id="id_usuario"><i class="fa fa-user-edit"></i></a></td>
            <td class="oculalimprimir"><a class='btn  btn-warning btn-sm' href="<?=$base_url?>/usuario/restaurar_datos/<?php echo $a['id_usuario'] ;?>"><i class="fa fa-key"></i></a></td>
            <th><button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#eliminar" onclick="obdatosIdUsuario('<?php echo $a['id_usuario'] ;?>')"><i class="fa-solid fa-trash"></i></button></th>
          </tr>
         <?php } ?>
    </tbody>
    </table>
    <div class="label label-danger label-md" onclick="$(this).hide(1000)"><?=$mensaje?></div>
  </div>
</section>
<br><br>
<br><br>
<section>
  <!-- Modal -->
<div class="modal fade" id="eliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content modal-dialog-centered">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Eliminar usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Desea realmente eliminar al Usuario?
         <input type="hidden" id="idresul">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><i class="fa-regular fa-circle-xmark"></i> No</button>
        <a class='btn btn-danger' id="nume"><i class="fa-solid fa-trash-can"></i> Si</a>
      </div>
    </div>
  </div>
</div>
</section>
</div>
<footer class="oculalimprimir"><?php $this->load->view('layout/footer') ?></footer>
<script type="text/javascript">
  function obdatosIdUsuario(id) {
    datos = id;
    $('#idresul').val(datos);
  };

  $('#nume').click(function(){
    var opcion =$('#idresul').val();   
    window.location.href = '<?=$base_url?>/usuario/baja/'+opcion+'';
  });

  function funcion(){
  $.post('<?=$base_url?>/inicio/estado').done(function(response){
      data = $.parseJSON(response);
      console.log(data);
      if (data == 0) {
        Swal.fire({
        icon: 'error',
        title: 'Oops!',
        text: 'Ya se han desactivardo los usuarios vendedores!',
        showConfirmButton: false,
        timer: 1500
      })
      }else{
        Swal.fire({
        icon: 'success',
        title: 'Excelente!',
        text: 'Se desactivaron los usuarios vendedores!',
        showConfirmButton: false,
        timer: 1500
      });
        location.reload();
      }
  });
}

function funcion_dos(){
  $.post('<?=$base_url?>/inicio/estado_update').done(function(response){
      data = $.parseJSON(response);
       console.log(data);
       if (data == 0) {
        Swal.fire({
        icon: 'error',
        title: 'Oops!',
        text: 'Ya están activado los usuarios vendedores!',
        showConfirmButton: false,
        timer: 1500
      })
      }else{
        Swal.fire({
        icon: 'success',
        title: 'Excelente!',
        text: 'Se activaron los usuarios vendedores!',
        showConfirmButton: false,
        timer: 1500
      });
        location.reload();
      }
  });
}

</script>
</body>
</html>

-