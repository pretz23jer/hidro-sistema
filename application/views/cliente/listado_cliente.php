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
  <title>Clientes</title>
</head>
<body>
  <?php $this->load->view('layout/menu'); ?>
<header>
    <br>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-sm-7"><center><h3 style="color: #03064A"><i class="fa fa-users" style=" font-weight: bold;"></i> Listado de Clientes</h3></center></div>
      <div class="col-6 col-sm-2 ">
        <div class="row">
            <div class="col" style="text-align: right;"><a type="submit" href="<?=$base_url?>/cliente/descargarLista" ><i class="fa-solid fa-file-pdf h4 red"></i></a></div>
            <div class="col" style="text-align: left;"><a type="submit" href="<?=$base_url?>/cliente/descargarlistaxls" ><i class="fa-solid fa-file-excel h4 green"></i></a></div>    
        </div>
        </div>
      <div class="col-6 col-sm-2"><a href="<?=$base_url?>/cliente" type="submit" class="btn btn-sm"><i class="fa-solid fa-user-plus edit"></i><strong> Registrar cliente</strong></a></div>
    </div>  
    </div>
  </div>
</header>
<section>
<div class="container-fluid">
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover" width="100%" id="tablax" >
    <thead> 
      <tr id="letra_info">
        <th>No.</th>
        <th>Nombre</th>
        <th>CUI</th>
        <th>NIT</th>
        <th>Dirección</th>
        <th>Municipio</th>
        <th>Departamento</th>
        <th>Teléfono</th>
        <th>Detalle</th>
        <th>Editar</th>
        <th><i class="fa-solid fa-download down"></i></th>
        <th><i class="fa-solid fa-trash-can trash"></i></th>
      </tr>
    </thead>
    <tbody >
       <?php
          foreach ($arr as $a){
         ?>
         <tr>
          <td class='text-center'><?php echo $a['id_cliente'];?></td>
          <td><?php echo $a['nombre'] ;?></td>
          <td class='text-center'><?php echo $a['cui'] ;?></td>
          <td class='text-center'><?php echo $a['nit'] ;?></td>
          <td><?php echo $a['direccion'] ;?></td>
          <td><?php echo $a['depto'] ;?></td>
          <td><?php echo $a['muni'] ;?></td>
          <td class='text-center' id="telefono_data" ><?php echo $a['numero1'] ;?></td> 
          <td class='text-center'><a class="btn btn-sm" href="<?=$base_url?>/cliente/det/<?php echo $a['id_cliente']; ?>"><i class="fa-solid fa-circle-info deta"></i></a></td>
          <td class='text-center'><a class='btn btn-sm' href="<?=$base_url?>/cliente/editar/<?php echo $a['id_cliente']; ?>"><i class="fa-solid fa-user-pen edit"></i></a></td>
          <td class='text-center'><a class='btn btn-sm' href="<?=$base_url?>/cliente/descargarcliente/<?php echo $a['id_cliente']; ?>"><i class="fa-solid fa-download down"></i></a></td>
          <td class='text-center'><a class='btn btn-sm' data-bs-toggle="modal" data-bs-target="#eliminar" 
              onclick="obdatosId('<?php echo $a['id_cliente'] ;?>')"><i class="fa-solid fa-trash-can trash"></i></a></td>
         </tr>
      <?php } ?>
    </tbody>
    </table>
    <div class="label label-danger label-md" onclick="$(this).hide(1000)"><?=$mensaje?></div>
  </div>
</div>
</section>

</div>
<section class="container">
  <a href="<?=$base_url?>/cliente" class="badge badge-pill badge-primary botones"><i class="icon-user fa-md" style=" font-weight: bold;"></i> Registrar un nuevo Cliente</a>
</section>
<br>
<footer><?php $this->load->view('layout/footer') ?></footer>
<!-- Modal eliminar-->
<div class="modal fade" id="eliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background-color: red; color: #fff;">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa-solid fa-trash-can"></i> DAR DE BAJA AL CLIENTE</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <center><p style="color: #0901A4; font-weight: bold;"><i class="fa-solid fa-ellipsis"></i> Detalles Generales</p></center>
        <div class="row">
            <div class="col-sm-8 col-8">
                <label for="fecha">Nombre del Cliente</label>
                <input type="text" class="form-control" name="cliente" id="cliente" readonly>
            </div>
            <div class="col-sm-4 col-4">
                <label for="cantidad">CUI</label>
                <input type="text" class="form-control" name="cuic" id="cuic" readonly>
            </div>
            <div class="col-sm-12 col-12">
                <label for="categoria">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" readonly>
            </div>
            <input type="hidden" id="venta">
            <center></center>
            <div class="col-sm-12 col-12">
                <label for="usuario">Usuario quién elimina el registro:</label>
                <p><strong><?php echo $this->session->NOMBRE ?></strong></p>
            </div>
        </div>
        <div>
          <br>
        <center><h3 style="color: red;">¿Está seguro de eliminar el registro?</h3></center>
        </div>
        <br>
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><i class="fa-solid fa-right-from-bracket"></i> No eliminar</button>
            <form method="POST" id="eliminarRegi" name="eliminarRegi">
                <input type="hidden" name="action" value="eliminarRegi">
                <input type="hidden" id="id_c" name="id_c" value="">
                <button type="submit" class="btn btn-danger" id="enviarDato" readonly><i class="fa-solid fa-trash-can"></i> Si</button>
            </form>           
      </div>
    </div>
  </div>
</div>
<script>
   //datatables//
       $(document).ready(function () {
            $('#tablax').DataTable({
                order: [ 0, "desc" ],
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
                scrollCollapse: true,
                lengthMenu: [ [15, 30, 50, -1], [15, 30, 50, "All"] ],
            });
        });
</script>
<script>
   function obdatosId(id_cliente) {
        datos = {
            "id_cliente": id_cliente
        }

        $.ajax({
            data: datos,
            url: '<?=$base_url?>/cliente/buscarRegistro',
            type: 'POST',
            beforeSend: function(){},
            success: function(response) {
                data = $.parseJSON(response);
                if(data.length > 0){
                    $('#id_c').val(data[0]['codigo']);
                    $('#cliente').val(data[0]['cliente']);
                    $('#cuic').val(data[0]['cui']);
                    $('#direccion').val(data[0]['direccion']);
                }
            } 
        });
    };

     //darbaja
    $('#enviarDato').click(function(){
        $.ajax({
            url: '<?=$base_url?>/cliente/darBajaCli',
            type: "POST",
            async: true,
            data: $('#eliminarRegi').serialize(),

            success: function(response){
                data = $.parseJSON(response);
                    if(data.length > 0){
                    console.log(response);
                }
            }
        });
    });

</script>
</body>
</html>


