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
$htmltrow = "<tr>
        <td>%s</td>
        <td>%s</td>  
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
        <td>%s</td>
       </tr>";
$htmltrows = "";

$BuscarProductoR = "Todos";

if (isset($categoria)) {
$BuscarProductoR = $categoria; //es la var que seleccionaria el usaurio la categoria de producto a ver
}

foreach ($arr as $a) {
$htmltrows .= sprintf($htmltrow, $a['codigo'], $a['descripcion'], $a['precio'], $a['existencia'], $a['categoria'], $a['imagen'], $a['id_producto']);
}
?><!DOCTYPE html>
<html lang="es">
<head>
  <?php $this->load->view('layout/header'); ?>
  <title>Productos</title>
</head>
<body>
<?php $this->load->view('layout/menu'); ?>
  <header>
    <br>
  <div>
    <h5 style="color: #03064A" class="text-center">Listado de Productos</h5>
    <hr>
  </div>
  </header>
<section class="container-fluid">
  <?php $numero  = count($arr); ?>
  <div class="row">
    <div class="col-sm-5">
      <h6 style="text-align: left;">Total de productos registrados son: <strong><?php echo $numero; ?></strong></h6>
    </div>
    <div class="col-sm-7">
      <div>
      <a href="<?=$base_url?>/producto" class="btn btn-primary btn-sm"><i class="fa-solid fa-circle-plus"></i> Registro de Producto</a>
      <a href="<?=$base_url?>/producto/listarPromociones" class="btn btn-dark btn-sm"><i class="fa-solid fa-percent"></i> Productos en Promoción</a>
      </div>
      <br>
      <form action="<?=$base_url?>/producto/listar"  method="POST">
      <div class="row col-sm-12 col-md-8">
        <div class="form-group">
          <div class="input-group">
            <select name="selectCategoria" id="categoria_lista" class="form-control selectpicker levelc" data-live-search="true" required></select>
            <div class="input-group-append">
              <input type="submit" class="btn btn-primary btn-user" role="button" name="BtnCategoria" value="Ver listado">
            </div>
          </div>
        </div>
      </div>
      </form>
    </div>
  </div>
</section>
<section>
<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover" width="100%" id="productos">
                  <thead>
                    <tr>
                      <th class='text-center'>CÓDIGO</th>
                      <th>DESCRIPCIÓN</th>
                      <th>PRECIO VENTA</th>
                      <th class='text-center'>STOCK</th>
                      <th>CATEGORÍA</th>
                      <th>IMÁGEN</th>
                      <th>EDITAR STOCK</th>
                      <th>PROMO</th>
                      <th>EDITAR</th>
                      <th><i class="fa-solid fa-trash-can"></i></th>
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
                        <td class='text-right'>Q. <?php echo number_format($a['precio'],2) ;?></td> 
                        <td class='text-center'><?php echo $a['existencia'] ;?></td>
                        <td><?php echo $a['categoria'] ;?></td>
                        <td class='text-center'><img src="<?php echo $imagen ;?>" alt="" height="100px"></td> 
                        <td class='text-center'><a class='btn btn-success' style="color: #fff;" data-bs-toggle="modal" data-bs-target="#editar" onclick="obdatosIdProducto('<?php echo $a['id_producto'] ;?>')"><i class="fa-solid fa-cubes"></i> Cant</a></td>
                        <td class='text-center '><a class='btn btn-warning shadow-sm' style="color: #fff;" data-bs-toggle="modal" data-bs-target="#promocion" onclick="obdatosIdProductoPromocion('<?php echo $a['id_producto'] ;?>')"><i class="fa-solid fa-tags"></i> Pro</td> 
                        <td class='text-center'><a class='btn btn-primary' href="<?=$base_url?>/producto/editar/<?php echo $a['id_producto']; ?>"><i class="fa fa-edit"></i></a></td> 
                        <td class='text-center'><a class='btn btn-danger' data-bs-toggle="modal" data-bs-target="#eliminar" onclick="idProducto('<?php echo $a['id_producto'] ;?>')"><i class="fa fa-trash"></i></a></td> 
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
                <div class="label label-danger label-md" onclick="$(this).hide(1000)"><?=$mensaje?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
</section>
<footer><?php $this->load->view('layout/footer') ?></footer>
<div class="modal fade" id="editar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #00003D; color: #fff;">
        <h5 class="modal-title" id="exampleModalLabel">Editar existencia y Precio</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <center><p style="color: #0901A4; font-weight: bold;">Detalles Generales</p></center>
        <form method="POST" id="form_actualizar" name="form_actualizar">
          <input type="hidden" name="action" value="actualizaDato">
          <input type="hidden" id="id_prod" name="id_prod" value="">
        <div class="row text-center">
            <div class="col-sm-12 col-12">
                <h4 class="text-center" id="nombre"></h4>
            </div>
            <br>
            <div class="col-sm-6 col-6">
                <label for="cantidad">Precio Compra</label>
                <input type="text" class="form-control positive decimal-2-places text-center" name="compra" id="compra" required>
            </div>
            <div class="col-sm-6 col-6">
                <label for="categoria">Precio Venta</label>
                <input type="text" class="form-control positive decimal-2-places text-center" id="venta" name="venta" required>
            </div>
            <div class="col-sm-3 col-3"></div>
            <div class="col-sm-6 col-6">
                <label for="categoria">Existencia</label>
                <input type="text" class="form-control positive text-center" id="stock" name="stock" required>
            </div>
            <div class="col-sm-3 col-3"></div>
          </div>
          <br>
          <div class="row text-center">
            <div class="col-sm-12 col-12">
                <label for="usuario">Usuario quién edita el registro:</label>
                <p><strong><?php echo $this->session->NOMBRE ?></strong></p>
            </div>
        </div>
        <br>
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><i class="fa fa-sign-out-alt"></i> Salir</button>
              <button type="submit" class="btn btn-success botoncito" id="enviarDato" readonly><i class="fa fa-sync-alt"></i> Actualizar</button>
      </form>           
      </div>
    </div>
  </div>
</div>
<section>
<div class="modal fade" id="eliminar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Eliminar Producto Registrado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <br>
        <form name="enviar" id="enviar">
          <div class="row">
            <div class="col-sm-12 col-12">
              <input type="hidden" name="id" id="id" value="" required>
              <h4 class="text-center" id="name"></h4>
            </div>
          </div>
          <br>
          <button type="submit" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa-solid fa-trash-can"></i></button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-right-from-bracket"></i> Salir</button>
      </div>
    </div>
  </div>
</div>
</section>
<div class="modal fade" id="promocion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #00003D; color: #fff;">
        <h5 class="modal-title" id="exampleModalLabel">Producto en Promoción</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <center><p style="color: #0901A4; font-weight: bold;">Detalles Generales</p></center>
        <form method="POST" id="form_promo" name="form_promo">
          <input type="hidden" name="action" value="agregaPromo">
          <input type="hidden" id="proMid_prod" name="id_prod" value="">
        <div class="row text-center">
            <div class="col-sm-12 col-12">
                <h4 class="text-center" id="proMnombre"></h4>
            </div>
            <br>
            <div class="col-sm-6 col-6">
                <label for="cantidad">Precio Compra</label>
                <input type="text" class="form-control positive decimal-2-places text-center" name="compra" id="proMcompra" required>
            </div>
            <div class="col-sm-6 col-6">
                <label for="cantidad">Precio Venta</label>
                <input type="text" class="form-control positive decimal-2-places text-center" id="proMventa" name="venta" required>
            </div>
            <div class="col-sm-6 col-6 mt-2">
                <label for="categoria">Precio Promoción</label>
                <input type="text" class="form-control positive decimal-2-places text-center" id="precioProm" name="precioProm" required>
            </div>
            <div class="col-sm-4 col-4 mt-2">
                <label for="categoria">Existencia</label>
                <input type="text" class="form-control positive text-center" id="proMstock" name="stock" required>
            </div>
            <div class="col-sm-12 col-12 mt-2">
                <label for="categoria">Descripción de la Promoción</label>
                <input type="text" class="form-control text-center" id="descripcion" name="descripcion" required>
            </div>
          </div>
          <br>
          <div class="row text-center">
            <div class="col-sm-12 col-12">
                <label for="usuario">Usuario quién edita el registro:</label>
                <p><strong><?php echo $this->session->NOMBRE ?></strong></p>
            </div>
        </div>
        <br>
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><i class="fa fa-sign-out-alt"></i> Salir</button>
              <button type="submit" class="btn btn-success botoncito" id="enviarDato" readonly><i class="fa fa-sync-alt"></i> Agregar producto a promoción</button>
      </form>           
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function consultaCategoría(){
    document.getElementById("categoria").submit();
  };

$(function(){
  $.post('<?=$base_url?>/producto/traer_lista_cate').done(function(response){
    let result = JSON.parse(response);
    let res = document.querySelector('#categoria_lista');
    res.innerHTML = '';
    if (result.length > 0){
      res.innerHTML += `	<option value="Todos" <?php  if($BuscarProductoR=="Todos"){echo "selected";} ?> >Todos los Productos</option>\n `
      for (let item of result) {
        res.innerHTML += `	<option value="${item.id}" >${item.nombre}</option>\n `
      }
    }
  });
});

  $(document).ready(function () {
    $('#productos').DataTable({
      "aaSorting": [],
      "scrollX": true,
          language: {
            processing: "Tratamiento en curso...",
            search: "Buscar&nbsp;:",
            lengthMenu: "Agrupar por _MENU_ items",
            info: "Mostrando del item _START_ al _END_ de un total de _TOTAL_ items",
            infoEmpty: "No existen datos.",
            infoFiltered: "(filtrado de _MAX_ elementos en total)",
            infoPostFix: "",
            loadingRecords: "Cargando...",
            zeroRecords: "No se encontraron datos con tu busqueda",
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

  //obtener id dato selec
  function obdatosIdProducto(id_producto) {
        datos = {
            "id_producto": id_producto
        }
        $.ajax({
            data: datos,
            url: '<?=$base_url?>/producto/buscarRegistroProducto',
            type: 'POST',
            beforeSend: function(){},
            success: function(response) {
                data = $.parseJSON(response);
                if(data.length > 0){
                    $('#id_prod').val(data[0]['codigo']);
                    $('#nombre').html(data[0]['detalle']);
                    $('#compra').val(data[0]['precio_compra']);
                    $('#venta').val(data[0]['precio_venta']);
                    $('#stock').val(data[0]['existencia']);
                }
            } 
        });
    };

    //obtener id dato selec
  function idProducto(id_producto) {
        datos = { "id_producto": id_producto }
        $.ajax({
            data: datos,
            url: '<?=$base_url?>/producto/buscarRegistroProducto',
            type: 'POST',
            beforeSend: function(){},
            success: function(response) {
                data = $.parseJSON(response);
                if(data.length > 0){
                  $('#id').val(data[0]['codigo']);
                  $('#name').html(data[0]['detalle']);
                }
            } 
        });
    };

  $('#form_actualizar').submit(function(e){
    e.preventDefault();
    $.ajax({
      url: '<?=$base_url?>/producto/actualizarProductoStok',
        type: "POST",
        async: true,
        data: $('#form_actualizar').serialize(),
        success: function(response){
          if (response != 'error') {
            Swal.fire(
              'Exitoso!',
              '¡Se actualizado correctamente!',
              'success'
            )
          redlistar();   
          }
        }
    });
  });

function redlistar(){
  window.location.href='<?=$base_url?>/producto/listar';
};

$(document).ready(function(){
    validarCualquierNumero()
});

function validarCualquierNumero(){
  $(".positive").numeric({ negative: false }, function() { alert("No negative values"); this.value = ""; this.focus(); });
  $(".decimal-2-places").numeric({ decimalPlaces: 2 });
  $("#remove").click(
    function(e)
    {
      e.preventDefault();
      $(".numeric,.positive,.decimal-2-places").removeNumeric();
    }
  );
};

$('#enviar').submit(function(e){
  e.preventDefault();
  $.ajax({
    url: '<?=$base_url?>/producto/baja',
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

//obtener id dato selec para promicion
  function obdatosIdProductoPromocion(id_producto) {
        datos = {
            "id_producto": id_producto
        }
        $.ajax({
            data: datos,
            url: '<?=$base_url?>/producto/buscarRegistroProducto',
            type: 'POST',
            beforeSend: function(){},
            success: function(response) {
                data = $.parseJSON(response);
                if(data.length > 0){
                    $('#proMid_prod').val(data[0]['codigo']);
                    $('#proMnombre').html(data[0]['detalle']);
                    $('#proMcompra').val(data[0]['precio_compra']);
                    $('#proMventa').val(data[0]['precio_venta']);
                    $('#proMstock').val(data[0]['existencia']);
                }
            } 
        });
    };


//producto en promo

  $('#form_promo').submit(function(e){
    e.preventDefault();
    $.ajax({
      url: '<?=$base_url?>/producto/productosEnPromocion',
        type: "POST",
        async: true,
        data: $('#form_promo').serialize(),
        success: function(response){
          if (response != 'error') {
            Swal.fire(
              'Exitoso!',
              '¡Se actualizado correctamente!',
              'success'
            )
          redlistar();   
          }else{
            Swal.fire(
              'Upss!',
              '¡Se presentó un error, intente nuevamente!',
              'error'
            )
          }
        }
    });
  });
</script>
</body>
</html>