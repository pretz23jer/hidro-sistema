<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$mensaje = isset($mensaje) ? $mensaje : "";
if (count($arr) < 1) {
  $mensaje = "<script>
    Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'No hay ningun producto registrado en el sistema!',
  }) 
  </script>";
}

$htmltrow = "<tr>
        <td>%s</td>
        <td>%s</td>
        <td>Q. %s</td>  
        <td class='text-center'>%s</td>
        <td>%s</td>
        <td>%s</td> 
       </tr>\n";
$htmltrows = "";

foreach ($arr as $a) {
  $id_producto = $a['id_producto'];
  $htmltrows .= sprintf($htmltrow, 
  htmlspecialchars($a['codigo']), htmlspecialchars($a['descripcion']), number_format($a['precio']), htmlspecialchars($a['existencia']), $a['categoria'], base64_encode($a['imagen']));
}
?><!DOCTYPE html>
<html lang="es">
<head>
  <?php $this->load->view('header'); ?>
  <title>Producto</title>
</head>
<body>
  <?php $this->load->view('menu'); ?>
<div class="container-fluid">
<header class="espacio">
  <h3 style="color: #03064A" class="container"><i class="icon-basket-loaded fa-md" style=" font-weight: bold;"></i> Listado de Productos</h3>
  <hr>
</header>
<section class="container">
  <a href="<?=$base_url?>/Listar/descargar" class="btn btn-success btn-sm botones"><i class="icon-cloud-download fa-md" style="font-weight: bold;"></i> Descargar</a>
</section>
<section>
  <div class="table-responsive-sm">
    <table class="table table-striped table-bordered" id="tablax">
    <thead> 
      <tr id="letra_info" class="iconost">
        <th>CÓDIGO</th>
        <th>DETALLE</th>
        <th>PRECIO VENTA</th>
        <th>EXISTENCIA</th>
        <th>CATEGORÍA</th>
        <th>IMÁGEN</th>
      </tr>
    </thead>
    <tbody>
      <?php
          foreach ($arr as $a){
              $direccion ='/energy/resources/upload/';
              $imagen = $direccion.$a['imagen'];
         ?>
          <tr>
            <td><?php echo $a['codigo'] ;?></td>
            <td><strong><?php echo $a['descripcion'] ;?></td>
            <td>Q <?php echo $a['precio'] ;?>.00</td>
            <td><?php echo $a['existencia'] ;?></td>
            <td><?php echo $a['categoria'] ;?></td>
            <td><img src="<?php echo $imagen ;?>" alt="" height="100px"></td>
          </tr>
         <?php
            }
          ?>
    </tbody>
    </table>
    <div class="label label-danger label-md" onclick="$(this).hide(1000)"><?=$mensaje?></div>
  </div>
</section>
</div>
<br>
<footer><?php $this->load->view('footer') ?></footer>
<script>
   //datatables//
       $(document).ready(function () {
            $('#tablax').DataTable({
                language: {
                    processing: "Proceso en curso...",
                    search: "Buscar&nbsp;:",
                    lengthMenu: "Agrupar por _MENU_ items",
                    info: "Mostrando del item _START_ al _END_ de un total de _TOTAL_ items",
                    infoEmpty: "No existen datos.",
                    infoFiltered: "(filtrado de _MAX_ elementos en total)",
                    infoPostFix: "",
                    loadingRecords: "Cargando...",
                    zeroRecords: "No se encontraron datos con tu búsqueda",
                    emptyTable: "No hay datos disponibles en la tabla.",
                    paginate: {
                        first: "Primero",
                        previous: "Anterior",
                        next: "Siguiente",
                        last: "Ultimo"
                    },
                    aria: {
                        sortAscending: ": active para ordenar la columna en orden ascendente",
                        sortDescending: ": active para ordenar la columna en orden descendente"
                    }
                },
                scrollY: 1000,
                scrollCollapse: true,
                lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
            });
        });
</script>
</body>
</html>



