<?php defined('BASEPATH') OR exit('No direct script access allowed');
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
  ?>
  <!DOCTYPE html>
  <html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $this->load->view('layout/header'); ?>
    <title>Productos en Promoción</title>
  </head>
  <body>
    <?php $this->load->view('layout/menu'); ?>
    <div class="container">
      <h3 class="text-center">Productos en Promoción</h3>
      <a href="<?=$base_url?>/producto/listar" class="btn btn-primary btn-sm"><i class="fa-solid fa-box-open"></i> Listado de Productos</a>
      <hr>
      <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
          <thead>
            <tr>
              <th class="text-center" scope="col">CÓDIGO</th>
              <th scope="col">PRODUCTO</th>
              <th scope="col">VENTA-SIN-PROM</th>
              <th scope="col">PROMOCION</th>
              <th class="text-center" scope="col">STOCK</th>
              <th scope="col">DESCRIPCION</th>
              <th class="text-center" scope="col"><i class="fa-solid fa-image"></i></th>
              <th class="text-center" scope="col"><i class="fa-solid fa-trash-can"></i></th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($arr as $a){
              $direccion = $base_url.'/recursos/upload/';
              $imagen = $direccion.$a['imagen'];
              ?>
              <tr>
                <td class='text-center'><?php echo $a['codigo'] ;?></td>
                <td><?php echo $a['descripcion'] ;?></td>
                <td class='text-right'>Q. <?php echo number_format($a['precioVenta'],2) ;?></td> 
                <td class='text-center'>Q. <?php echo number_format($a['promocion'],2) ;?></td>
                <td class="text-center"><?php echo $a['existencia'] ;?></td>
                <td><?php echo $a['motivo'] ;?></td>
                <td class='text-center'><img src="<?php echo $imagen ;?>" alt="" height="100px"></td> 
                <td class='text-center'><a class='btn btn-danger' data-bs-toggle="modal" data-bs-target="#eliminar" onclick="idProducto('<?php echo $a['id_promocion'] ;?>')"><i class="fa fa-trash"></i></a></td> 
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="modal fade" id="eliminar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Eliminar Promoción Registrado</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <br>
            <form name="enviar" id="enviar">
              <div class="row">
                <div class="col-sm-12 col-12">
                  <input type="hidden" name="id" id="id" value="" required>
                  <h4 class="text-center">¿Está seguro de eliminar esta promoción?</h4>
                </div>
              </div>
              <br>
              <div class="text-center">
                <button type="submit" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa-solid fa-trash-can"></i> Si</button>
              </div>
              
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-right-from-bracket"></i> No</button>
          </div>
        </div>
      </div>
    </div>
    <?php echo $mensaje; ?>
    <script type="text/javascript">
         //obtener id dato selec
      function idProducto(id_producto) {
        var datos = { "id_producto": id_producto }
        $('#id').val(datos['id_producto']);
      };

      //dar baja a producto en promocion
      $('#enviar').submit(function(e){
        e.preventDefault();
        $.ajax({
          url: '<?=$base_url?>/producto/bajaPromocion',
          type: "POST",
          async: true,
          data: $('#enviar').serialize(),
          success: function(response){
            if (response == '1') {
              Swal.fire(
                'Exitoso!',
                '¡Se eliminado correctamente!',
                'success'
                );
              redlistar();   
            }
          }
        });
      });


      function redlistar(){
        window.location.href='<?=$base_url?>/producto/listarPromociones';
      };
    </script>
  </body>
  </html>