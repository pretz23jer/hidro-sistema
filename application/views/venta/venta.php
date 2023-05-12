<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="es">
<head>
	<?php $this->load->view('layout/header'); ?>
	<title>Venta</title>
</head>
<body>
  <header><?php $this->load->view('layout/menu'); ?></header>
  <main class="container espacioMain">
    <section><!--encabezado-->
      <h4 class="text-center separa"><i class="fa-solid fa-cart-shopping"></i> Nueva venta</h4>
      <button type="button" class="btn btn-primary btn-sm" id="create_c"><i class="fa-solid fa-user-plus"></i> Cliente</button>
      <button type="button" class="btn btn-primary btn-sm" id="buscar_c_r"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
      <a type="button" class="btn btn-primary btn-sm" href="<?=$base_url?>/venta/listar_venta"><i class="fa-solid fa-list"></i> Lista</a>
    </section>
    <section class="espacioSeccion"><!--sección cliente-->
      <div id="seccion_cliente" style="display: none;"><?php $this->load->view('cliente/crear_cliente'); ?></div>
      <div id="seccion_buscar" style="display: none;"><?php $this->load->view('cliente/buscar_cliente'); ?></div>
    </section>
    <section class="fondo_venta"><!--sección datos del vendedor y fecha-->
      <div class="row">
        <div class="col-sm-6 col-lg-9"><strong>Vendedor <i class="fa fa-user"></i></strong> : <?php echo $this->session->NOMBRE ?></div>
        <div class="col-sm-6 col-lg-3"><strong>Fecha <i class="fa fa-calendar-day"></i></strong> : <?php echo date("d-m-Y"); ?></div>
      </div>
    </section>
    <section>
      <!--sección venta de calentadores-->
      <div class="fondo_venta data" id="solar" style="display: none;">
        <div class="text-center">
          <a type="button" href="#solarespc" id="buscar_prod_cal" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal">Seleccionar</a>
        </div>
        <div id="tarjetasRecibidas"></div>
      </div>
      <div class="fondo_venta">
        <form name="form_new_venta" id="form_new_venta" method="post">
          <input type="hidden" name="action" value="crear_venta_nueva">
          <input type="hidden" id="id_prod" name="id_prod" required>
          <div class="row">
            <div class="col-12 col-md-3 separa"><strong><i class="fa-solid fa-user"></i> Cliente a vender:</strong>
             <input type="hidden" class="form-control" name="cliente_veder_solar" id="cliente_veder_solar" required>
            </div>
          </div>
          <!--seccion condicionar venta-->
          <div>
            <div class="row data" id="ven1" style="display: none;">
              <div class="col-sm-5">
                <label class="separa" for="prod1"><i class="fa fa-signature"></i> Nombre del producto</label>
                <textarea  type="text" class="form-control" id="nom_prodcp" required readonly style="display: none;"></textarea>
              </div>
              <div class="col-sm-5">
                <label class="separa" for="prod2"><i class="fa fa-info-circle"></i> Detalle del Producto</label>
                <textarea type="text" class="form-control" id="det_pacp" required readonly style="display: none;"></textarea>
              </div>
              <div class="col-sm-2"><label class="separa" for="prod3"><i class="fa fa-cubes"></i> Exis</label>
                <input type="text" class="form-control text-center fw-bold" name="stok_prod" id="stok_prod" required readonly style="display: none;" />
              </div>
            </div>
            <div class="row data" id="ven2" style="display: none;">
              <div class="col-sm-1">
                <label class="separa" for="deta">Cantidad</label>
                <input type="text" class="form-control positive text-center fw-bold" name="cant_v" id="cant_v" value="1" maxlength="6" required style="display: none;" />
              </div>
              <div class="col-sm-2">
                <label class="separa"l for="deta1"><i class="fa fa-money-bill-wave"></i> Precio Venta</label>
                <input type="text" class="form-control text-center" name="precio_v" id="precio_v" required readonly style="display: none;" />
              </div>
              <div class="col-sm-2">
                <label class="separa" for="deta2"><i class="fa fa-money-bill-wave-alt"></i> Descuento en Q.</label>
                <input type="text" class="form-control positive text-center" name="desc_v" id="desc_v" maxlength="8" required style="display: none;" />
              </div>
              <div class="col-sm-2">
                <label class="separa" for="deta3"><i class="fa fa-money-bill-wave"></i> Anticipo</label>
                <input type="text" class="form-control positive text-center" name="anti_v" id="anti_v" maxlength="8" required style="display: none;" />
                <input type="text" name="poranticipo" id="poranticipo" style="display: none" />
              </div>
              <div class="col-sm-2">
                <label class="separa" for="deta4"><i class="fa fa-money-bill-wave"></i> Pendiente</label>
                <input type="text" class="form-control text-center" name="pend_v" id="pend_v" required readonly style="display: none;" />
                <input type="text" name="porpendiente" id="porpendiente" style="display: none" /> 
              </div>
              <div class="col-sm-1">
                <label class="separa" for="deta5">Sub Total</label>
                <input type="text" class="form-control text-center" name="sub_v" id="sub_v" required readonly style="display: none;" />
              </div>
              <div class="col-sm-2">
                <label class="separa" for="deta6"><i class="fa fa-money-bill-wave"></i> TOTAL</label>
                <input type="text" class="form-control text-center" name="total_v" id="total_v" required readonly style="display: none;" />
              </div>
            </div>
            <div class="text-center pt-3">
              <button type="submit" class="btn btn-primary btn-sm" style="font-weight: bold; display: none;" id="guardar_v" name="guardar_v"><i class="fa fa-save"></i> Guardar Venta</button>
            </div>
          </div>
        </form>
      </div>
      <!--sección agregar productos varios---------------------->
      <div class="fondo_venta data" id="suministroVenta" style="display: block;">
        <div class="text-center">
          <a type="button" data-bs-toggle="modal" href="#suministros" class="btn btn-sm btn-outline-primary" id="btnAgregarArt"><i class="fa fa-lightbulb"></i> <i class="fa fa-plug"></i> <i class="fa fa-bolt"></i> <i class="fa fa-car-battery"></i> Selecionar Artículos</a>
        </div>
        <!--agregar productos-->
        <form action="agregarProd" method="post">
          <div class="row" id="div1" style="display: none;">
            <div class="col-sm-2">
              <label for="codigo"><i class="fa fa-hashtag"></i> Cód</label>
              <input type="hidden" id="id_prods" name="id_prods" required />
              <input type="text" class="form-control" id="cod_prods" name="cod_prods" style="display: none;" readonly required />
            </div>
            <div class="col-sm-4">
              <label for="nombre"><i class="fa fa-info-circle"></i> Nombre</label>
              <textarea type="text" class="form-control" id="nombre_su" name="nombre_su" rows="2" value="" style="display: none;" readonly required></textarea>
            </div>
            <div class="col-sm-4">
              <label for="detalle"><i class="fa fa-info-circle"></i> Detalle</label>
              <textarea type="text" class="form-control" id="descrip_s" name="descrip_s" rows="2" value="" style="display: none;" readonly required></textarea>
            </div>
            <div class="col-sm-2">
              <label for="stock"><i class="fa fa-cubes"></i> Existencia</label>
              <input type="text" class="form-control text-center fw-bold" id="stok_prods" name="stok_prods" style="display: none;" readonly="" required />
            </div>
          </div>
          <div class="row" id="div2" style="display: none;">  
            <div class="col-sm-2">
              <label for="cantidad"><i class="fa fa-hashtag"></i> Cantidad</label>
              <input type="text" class="form-control text-center fw-bold" id="cant_s" name="cant_s" maxlength="6" value="" required style="display: none;" />
            </div>
            <div class="col-sm-3">
              <label for="accion"><i class="fa fa-puzzle-piece"></i> Acción para Agregar</label><center>
                <button type="submit" class="btn btn-primary btn-sm text-center" id="add_product_sum" name="add_product_sum" style="font-weight: bold; display: none;"><i class="fa fa-plus"></i> Agregar</button></center>
            </div>
            <div class="col-sm-2">
              <label for="preciou"><i class="fa fa-money-bill-wave-alt"></i> Precio Unitario</label>
              <input type="text" class="form-control text-center" id="precio_vs" name="precio_vs" style="display: none;" readonly="" required />
            </div>
            <div class="col-sm-2">
              <label for="descuento"><i class="fa fa-money-bill-wave"></i> Descuento en Q.</label>
              <input type="text" class="form-control text-center" id="desc_s" name="desc_s" maxlength="8" value="0" required style="display: none;" />
            </div>
            <input type="hidden" id="engan_s" name="engan_s" value="0" required>
            <div class="col-sm-3">
              <label for="total"><i class="fa fa-cash-register"></i> Total</label>
              <input type="text" class="form-control text-center" id="total_s" name="total_s" maxlength="8" required readonly="" style="display: none;" />
            </div>
          </div>
        </form>
        <!--seccion tabla de productos-->
        <table class="table table-bordered table-hover table-striped">
          <thead class="thead-dark">
            <tr>
              <th class="text-center" width="75px">CÓD</th>
              <th class="text-center">CANT</th>
              <th>DESCRIPCION</th>
              <th class="text-center">PRECIOVENTA</th>
              <th class="text-center">DESCUENTO</th>
              <th class="text-center">SUBTOTAL</th>
              <th class="text-center">ACCIÓN</th>
            </tr>
          </thead>
          <tbody id="detalle_venta"></tbody>
          <tfoot id="detalle_totales"></tfoot>
        </table>
        <div class="text-center">
          <input type="hidden" name="idclientesum" id="idclientesum" value="" required />
          <h5 id="estado_registro_s" style="display:none;"></h5>
          <button type="submit" class="btn btn-danger btn-sm BotonGuardar" style="font-weight: bold;" id="btn_anular_venta"><i class="fa fa-times"></i> Anular Venta</button>
          <button type="submit" class="btn btn-success btn-sm BotonGuardar" style="font-weight: bold; display: none;" id="btn_facturar_venta_sum"><i class="fa fa-save"></i> Guardar</button>
        </div>
          
      </div>
    </section>
  </main>
  <section><!--todos los modals-->
    <!--modal venta de productos varios-->
    <div class="modal fade" id="suministros" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
          <div class="modal-header colormodal">
            <h5 class="modal-title">Seleccionar Productos</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div id="producto_suministros">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar</button>
          </div>
        </div>
      </div>
    </div>
  </section>

<script type="text/javascript">
  $('#buscar_c_r').click(function(){
    $('#seccion_buscar').slideDown();
  });

  $('#create_c').click(function(){
   $('#seccion_cliente').slideDown();
 });

  $(document).ready(function(){
    $("#categoria").on('change', function(){
      $(".data").hide();
      $("#" + $(this).val()).slideDown();
      let elegido = $("#categoria").val();
      if (elegido == 'suministroVenta') {
        $('#guardar_v').attr('disabled','disabled');
        $('#guardar_v').slideUp();
      }else{
        $('#guardar_v').attr("display","none");
        $('#guardar_v').removeAttr('disabled');
        $('#desc_v').val('');
        $('#anti_v').val('');
      }
    }).change();
  });

  $(document).on('click', '#btnAgregarArt', function(){
    $.ajax({
      url: '<?=$base_url?>/venta/tarer_producto_suministro',
      type: 'POST',
      dataType: 'html',
    })
    .done(function(respuesta){$("#producto_suministros").html(respuesta); estilotabla(); })
  });

  function estilotabla(){
    $('#suministrosv').DataTable({
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
      lengthMenu: [ [5, 10, 20, 30, 50, -1], [5, 10, 20, 30, 50, "All"] ],
    });
  };

  function obDatosIdSolar(id_producto) {
    $.ajax({
      data: {id_producto: id_producto},
      url: '<?=$base_url?>/venta/buscarProductoRe',
      type: 'POST',
      beforeSend: function(){},
      success: function(response) {
        data = $.parseJSON(response);
        if(data.length > 0){
          $('#id_prod').val(data[0]['id_producto']);
          $('#cod_venta').val(data[0]['codigo']);
          $('#nom_prodcp').val(data[0]['nombreP']);
          $('#det_pacp').val(data[0]['descripcion']);
          $('#precio_v').val(data[0]['precio']);
          $('#stok_prod').val(data[0]['existencia']);

          $('#ven1').slideDown();
          $('#ven2').slideDown();
          $('#cod_v').slideDown();
          $('#nom_prodcp').slideDown();
          $('#det_pacp').slideDown();
          $('#precio_v').slideDown();
          $('#cant_v').slideDown();
          $('#stok_prod').slideDown();
          $('#desc_v').slideDown();
          $('#anti_v').slideDown();
          $('#pend_v').slideDown();
          $('#sub_v').slideDown();
          $('#total_v').slideDown();
        }
      } 
    });
  };

    //multiplicar
  $('#cant_v,#precio_v,#desc_v,#anti_v').keyup(function(e){
    e.preventDefault();

    var cantidades =$('#cant_v').val(); 
    var precios =$('#precio_v').val();
    var descuentos =$('#desc_v').val();
    var anticipos =$('#anti_v').val(); 

    var producto = cantidades * precios;
    var desQ = producto - descuentos;
    var totalt = desQ;
    var pendiente = desQ - anticipos;

    $('#sub_v').val(producto);
    $('#total_v').val(totalt);
    $('#pend_v').val(pendiente);
  }); 

  //optener el porcentaje del productocancelado
  $('#anti_v,#total_v').keyup(function()
  { 
    var antititi =$('#anti_v').val(); 
    var totalconcan =$('#total_v').val(); 

    var xant = ((100*antititi)/totalconcan);
    var ypen = 100 - xant;

    $('#poranticipo').val(xant);
    $('#porpendiente').val(ypen);
  }); 

//validar cantidad de producto al ingresar 
  $('#cant_v').keyup(function(e){
    e.preventDefault();
    var existencia = parseInt($('#stok_prod').val());

    if( ($(this).val() < 1 || isNaN($(this).val())) || ($(this).val() > existencia) ){
      $('#guardar_v').slideUp();
      Swal.fire({
       icon: 'error',
       title: 'Oops...',
       text: 'Se está excediendo de la existencia!',
       showConfirmButton: false,
       timer: 1500
     })
    }else{
      $('#guardar_v').slideDown();
    }
  });

//validar descuento que no se exceda 
  $('#desc_v').keyup(function(e){
    e.preventDefault();
    var precioVenta = parseInt($('#precio_v').val());

    if( ( $(this).val() > precioVenta) ){
      $('#guardar_v').slideUp();
      Swal.fire({
       icon: 'error',
       title: 'Oops...',
       text: 'Se está excediendo del descuento permitido!',
       showConfirmButton: false,
       timer: 1500
     })
    }else{
      $('#guardar_v').slideDown();
    }
  });

//validar cantidad de producto al ingresar 
  $('#anti_v').keyup(function(e){
    e.preventDefault();
    var existencia = parseInt($('#total_v').val());

    if( ($(this).val() < 0 ) || ($(this).val() > existencia) ){
      $('#guardar_v').slideUp();
      Swal.fire({
       icon: 'error',
       title: 'Oops...',
       text: 'Verifique la cantidad!',
       showConfirmButton: false,
       timer: 1500
     })
    }else{
      $('#guardar_v').slideDown();
    }
  });

  //validar descuentos de producto al ingresar 
  $('#valor2').keyup(function(e){
    e.preventDefault();
    var desc = parseInt($('#valor3').val());

    if( ($(this).val() < 1 || isNaN($(this).val())) || ($(this).val() > desc) ){
      Swal.fire({
       icon: 'error',
       title: 'Oops...',
       text: 'Tenga cuidado!',
       showConfirmButton: false,
       timer: 1500
     })
    }else{
     Swal.fire({
       icon: 'error',
       title: 'Oops...',
       text: 'Tenga cuidado!',
       showConfirmButton: false,
       timer: 1500
     })
   }
 });

  function bloque(id_cliente) {
   $("#seccion_buscar").slideUp();
   $('#cui_b').attr('disabled','disabled');
   $.ajax({
    data: {id_cliente: id_cliente},
    url: '<?=$base_url?>/cliente/traercliente_seleccionado',
    type: 'POST',
    beforeSend: function(){},
    success: function(response) {
     var data = $.parseJSON(response);
     if(data.length > 0){
      $('#cliente_veder_solar').val(data[0]['id_cliente']);
      $('#cliente_a_vender').html(data[0]['nombre']);
      $('#idclientesum').val(data[0]['id_cliente']);
      $('#cliente_a_vender_sum').html(data[0]['nombre']);
    }
  } 
});
 };

  //guardarventa
 $('#form_new_venta').submit(function(e){
  e.preventDefault();
  $.ajax({
    url: '<?=$base_url?>/venta/crear_venta_nuevo',
    type: "POST",
    async: true,
    data: $('#form_new_venta').serialize(),
    success: function(response){
      if (response != 'error') {
            //bloquear campos al retornar los datos
        $('#nom_cliente').attr('disabled','disabled');
        $('#tel_cliente').attr('disabled','disabled');
        $('#tel1_cliente').attr('disabled','disabled');
        $('#dir_cliente').attr('disabled','disabled');

        $('#cod_v').attr('readonly','readonly');
        $('#nom_prodcp').attr('readonly','readonly');
        $('#det_pacp').attr('readonly','readonly');
        $('#precio_v').attr('readonly','readonly');;
        $('#cant_v').attr('readonly','readonly');
        $('#stok_prod').attr('readonly','readonly');
        $('#desc_v').attr('readonly','readonly');
        $('#anti_v').attr('readonly','readonly');
        $('#pend_v').attr('readonly','readonly');
        $('#sub_v').attr('readonly','readonly');
        $('#total_v').attr('readonly','readonly');
        $('#btnAgregarArt').slideUp();
        $('.guardar_cli').slideUp();
        $('#create_c').slideUp();
        $('#buscar_c_r').slideUp();
        $('#buscar_prod_cal').slideUp();
        $('#guardar_v').slideUp();
        Swal.fire(
          'Excelente!',
          'Se ha registrado correctamente la venta!',
          'success'
          )
        redlistar(response);
      } else {
       Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Debe de registrar o buscar al cliente, para generar la venta.!',
        showConfirmButton: false,
        timer: 1500
      })  
     } 
   }
 });
});

 function redlistar(id){
  window.location.href="<?=$base_url?>/venta/imprimir/"+id;
}

function redirect(){
  window.location.href='<?=$base_url?>/venta/crear_venta';
}

function obdatosIdSum(id_producto) {
  datos = { "id_producto": id_producto }
  $.ajax({
    data: datos,
    url: '<?=$base_url?>/venta/buscarProductoRe',
    type: 'POST',
    beforeSend: function(){},
    success: function(response) {
      data = $.parseJSON(response);
      if(data.length > 0){
        $('#id_prods').val(data[0]['id_producto']);
        $('#cod_prods').val(data[0]['codigo']);
        $('#nombre_su').val(data[0]['nombreP']);
        $('#descrip_s').val(data[0]['descripcion']);
        $('#precio_vs').val(data[0]['precio']);
        $('#stok_prods').val(data[0]['existencia']);

        $('#cod_prods').slideDown();
        $('#nombre_su').slideDown();
        $('#descrip_s').slideDown();
        $('#precio_vs').slideDown();
        $('#stok_prods').slideDown();
        $('#cant_s').slideDown();
        $('#desc_s').slideDown();
        $('#pend_vs').slideDown();
        $('#total_s').slideDown();

        $('#div1').slideDown();
        $('#div2').slideDown();
      }
    } 
  });
};

   //validar cantidad de producto al ingresar 
$('#cant_s').keyup(function(e){
  e.preventDefault();
  var existenciasum = parseInt($('#stok_prods').val());

  if( ($(this).val() < 1 || isNaN($(this).val())) || ($(this).val() > existenciasum) ){
    $('#add_product_sum').slideUp();
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Se está excediendo la cantidad con la existencia!',
      showConfirmButton: false,
      timer: 1500
    })  
  }else{
    $('#add_product_sum').slideDown();
  }
});
//descuento
$('#desc_s').keyup(function(e){
  e.preventDefault();
  var preciouni = parseInt($('#precio_vs').val());

  if( ($(this).val() > preciouni) ){
    $('#add_product_sum').slideUp();
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Se está excediendo el descuento permitido!',
      showConfirmButton: false,
      timer: 1500
    })  
  }else{
    $('#add_product_sum').slideDown();
  }
});
  //boton para ctivar o desactivar
function habiltar(){
  if($('#detalle_venta tr').length > 0){
    $('#valor2').attr('disabled','disabled');
  }else{
    $('#btn_facturar_venta_sum').hide();
  }
};

$('#cant_s').keyup(function(e){
  e.preventDefault();
  var cantidad_compra = parseInt($('#cant_s').val());
  var precio_unitario = parseInt($('#precio_vs').val());
  var descuento_realizar = $('#desc_s').val();
  var operando = ((cantidad_compra * precio_unitario) - descuento_realizar);
  $('#total_s').val(operando);
});

$('#desc_s').keyup(function(e){
  e.preventDefault();
  var cantidad_compra = parseInt($('#cant_s').val());
  var precio_unitario = parseInt($('#precio_vs').val());
  var descuento_realizar = $('#desc_s').val();
  var operando = ((cantidad_compra * precio_unitario) - descuento_realizar);
  $('#total_s').val(operando);
});

//productos micelaneos   //agregar producto a detalle
$('#add_product_sum').click(function(e){
  e.preventDefault();
  if($('#cant_s').val() > 0 ){
    var codproducto = $('#id_prods').val();
    var cantidad = $('#cant_s').val();
    var descuento = $('#desc_s').val();
    var enganche = $('#engan_s').val();
    var action = 'addProductoDetalle';

    $.ajax({
      url: '<?=$base_url?>/venta/agregarAlDetalleProd',
      type: "POST",
      async: true,
      data: {action:action,producto:codproducto,cantidad:cantidad,descuento:descuento,enganche:enganche},

      success: function(response){
        if (response != 'error') {
          var informacion = JSON.parse(response);
          $('#detalle_venta').html(informacion.detalle);
          $('#detalle_totales').html(informacion.totales);
            //limpiar datos
          $('#cod_prods').val('');
          $('#nombre_su').val('');
          $('#descrip_s').val('');
          $('#stok_prods').val('');
          $('#precio_vs').val('');
          $('#desc_s').val('0');
          $('#total_s').val('');
          $('#cant_s').val('');

            //ocultar div
          $('#div1').slideUp();
          $('#div2').slideUp();
            //bloquear cantidad
          $('#add_product_sum').slideUp();

        }else{
          console.log('No hay datos');
        } 
        viewProcesar();        
      }, 
      error: function(error){
      }
    });
  }
});

function viewProcesar(){
  if($('#detalle_venta tr').length > 0){
    $('#btn_facturar_venta_sum').show();
  }else{
    $('#btn_facturar_venta_sum').hide();
  }
}

function del_product_detalle(correlativo){
  var action = 'del_product_detalle';
  var id_detalle = correlativo;

  $.ajax({
    url: '<?=$base_url?>/venta/elimiarDetalle',
    type: "POST",
    async: true,
    data: {action:action,id_detalle:id_detalle},
    success: function(response){
      if (response != 'error') {
        var informacion = JSON.parse(response);
        $('#detalle_venta').html(informacion.detalle);
        $('#detalle_totales').html(informacion.totales)

        $('#codigoProducto').html('');
        $('#nombre').html('');
        $('#valor1').val('0');
        $('#valor2').val('0');
        $('#valor3').val('0.00');
        $('#valor4').val('0.00');
        $('#valor50').val('0.00');
        $('#valor51').val('0.00');

        //bloquear cantidad
        $('#valor2').attr('disabled','disabled');
        //bloquear cantidad
        $('#add_product_venta').slideUp();

      }else{
        $('#detalle_venta').html('');
        $('#detalle_totales').html('');
      } 
      viewProcesar();        
    }, 
    error: function(error){
    }
  });
};

function searchForDetalle(id){
  var action = 'searchForDetalle';
  var user = id;
  $.ajax({
    url: '<?=$base_url?>/venta/mostrarDatos',
    type: "POST",
    async: true,
    data: {action:action,user:user},

    success: function(response){
      if (response != 'error') {
        var informacion = JSON.parse(response);
        $('#detalle_venta').html(informacion.detalle);
        $('#detalle_totales').html(informacion.totales);

      }else{
        console.log('No hay Datos')
      } 
      viewProcesar();        
    }, 
    error: function(error){
    }
  });
};

//boton para ctivar o desactivar
function habiltar(){
  if($('#detalle_venta tr').length > 0){
    $('#valor2').attr('disabled','disabled');
  }else{
    $('#btn_facturar_venta_sum').hide();
  }
};
//sesion user
$(document).ready(function(){
  var usuarioid = '<?php echo $this->session->IDUSUARIO ?>';
  searchForDetalle(usuarioid);
});

//anular venta en detalle temp
$('#btn_anular_venta').click(function(e){
  e.preventDefault();

  var rows = $('#detalle_venta tr').length;
  if(rows > 0){
    var action = 'anularVenta';

    $.ajax({
      url: '<?=$base_url?>/venta/eliminarDetalle',
      type: "POST",
      async: true,
      data: {action:action},
      success: function(response){
        redirect();
      },
      error: function(error){
      }
    });
  }
});

//Guardar venta de los productos
$('#btn_facturar_venta_sum').click(function(e){
  e.preventDefault();

  var rows = $('#detalle_venta tr').length;
  if(rows > 0){
    var action = 'procesarComprobante';
    var idClient = $('#idclientesum').val();

    $.ajax({
      url: '<?=$base_url?>/venta/guardarVentaRealizada',
      type: "POST",
      async: true,
      data: {action:action,idClient:idClient},

      success: function(response){
        if(response != 'error'){
          Swal.fire({
            icon: 'success',
            title: 'Se ha registrado con éxito',
            showConfirmButton: false,
            timer: 2500
          })
          var info = JSON.parse(response);
          r_suministro_list(info);
        }else{
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Debe de registrar o buscar al cliente, para generar la venta.!',
            showConfirmButton: false,
            timer: 2500
          })
        }
      },
      error: function(error){
      }
    });
  }
});

function r_suministro_list(id){
  window.location.href='<?=$base_url?>/venta/mostrarvensum/'+id;
}

$(document).ready(function(){
  $(".numeric").numeric();
  $(".integer").numeric(false, function() { alert("Integers only"); this.value = ""; this.focus(); });
  $(".positive").numeric({ negative: false }, function() { alert("No negative values"); this.value = ""; this.focus(); });
  $(".decimal-2-places").numeric({ decimalPlaces: 2 });
  $("#remove").click(
    function(e)
    {
      e.preventDefault();
      $(".numeric,.positive,.decimal-2-places").removeNumeric();
    }
    );
});


/*seccion responsable*/
  $(function(){
    $.post('<?=$base_url?>/servicio/responsableServicio').done(function(respuesta){
      $('#resAgenVen1').html(respuesta);
      $('#resAgenVen2').html(respuesta);
    });
  });

function habilitarAgendar(){
  $('#agendarCliente').slideDown();
  $('#desIns').val('');
  $('#lugIns').val('');
  $('#diaIns').val('');
  $('#horIns').val('');
}

function habilitarObservacion(){
  $('#observacionCliente').slideDown();
  $('#observacion').val('');
  $('#observacion').prop("required", true);
}

</script>
</body>
</html>