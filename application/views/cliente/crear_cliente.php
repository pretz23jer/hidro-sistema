<?php defined('BASEPATH') OR exit('No direct script access allowed');
$mensaje = isset($mensaje) ? $mensaje : "";
$mensaje_res = isset($mensaje_res) ? $mensaje_res : "";
$mensaje_err = isset($mensaje_err) ? $mensaje_err : "";
?>
<div class="fondo_venta">
	<div class="row">
		<form method="POST" name="crear_cliente_nuevos" id="crear_cliente_nuevos">
			<input type="hidden" name="action" value="crear_cliente_lugar" >
	      <div class="row">
	        <div class="col-md-4">
	          <label class="separa"><i class="fa-solid fa-id-card"></i> CUI</label>
	          <input type="text" class="form-control" id="cui" minlength="1" name="cui" value="0" required>
	        </div>
	        <div class="col-md-4">
	          <label class="separa"><i class="fa-solid fa-user-pen"></i> Nombres</label>
	          <input type="text" class="form-control" name="nombre" id="nombre" value="" maxlength="35" required>
	        </div>
	        <div class="col-md-4">
	          <label class="separa"><i class="fa-solid fa-user-pen"></i> Apellidos</label>
	          <input type="text" class="form-control" name="apellido" id="apellido" value="" maxlength="35" required>
	        </div>
	      </div>
	      <div class="row">
	        <div class="col-md-4">
	          <label class="separa"><i class="fa-solid fa-id-card-clip"></i> NIT</label>
	          <input type="text" class="form-control" name="nit" id="nit" value="c/f" maxlength="15" required>
	        </div>
	        <div class="col-md-4">
	          <label class="separa"><i class="fa-solid fa-mobile"></i> Teléfono</label>
	          <input type="text" class="form-control" id="tel1" name="numero1" onkeypress="return numeros(event)" value="" required>
	        </div>
	        <div class="col-md-4">
	          <label class="separa"><i class="fa-solid fa-mobile-button"></i> Teléfono 2</label>
	          <input type="text" class="form-control" id="tel2" name="numero2" onkeypress="return numeros(event)" value="0" minlength="1" required>
	        </div>
	      </div>
	      <div class="row">
	        <div class="col-md-6">
	          <label class="separa"><i class="fa-solid fa-location-dot"></i> Dirección</label>
	          <input type="text" class="form-control" name="direccion" id="direccion" value="" maxlength="50" required>
	        </div>
	        <div class="col-md-3">
	          <label class="separa"><i class="fa-solid fa-flag"></i> Departamento</label>
	          <select class="custom-select negro form-control" id="departamento" required></select>
	        </div>
	        <div class="col-md-3">
	          <label class="separa"><i class="fa-brands fa-font-awesome"></i> Municipio</label>
	          <select class="custom-select negro form-control" name="muni" id="muni" required>
	            <option value="" disabled selected>Seleccionar</option>
	          </select>
	        </div>
	      </div>
	      <br>
	      <center><button type="submit" id="guarda_nuevo_cli" class="btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk"></i> Guardar</button> <button type="button" id="cerrar_div" class="btn btn-info btn-sm"><i class="fa-solid fa-xmark"></i> Cerrar</button></center>
	    </form>
	</div>
</div>
<?=$mensaje?><?=$mensaje_res?><?=$mensaje_err?>
<script type="text/javascript">
$('#cerrar_div').click(function(){
	$('#seccion_cliente').slideUp();
});

$(document).ready(function() {
     	$("#cui").mask("0000 00000 0000");
	});

	$(document).ready(function() {
   	$("#tel1").mask("0000 0000");
	});

	$(document).ready(function() {
	    $("#tel2").mask("0000 0000 0000 0000");
	});

	function numeros(e){
    key=e.keyCode || e.which;
    teclado = String.fromCharCode(key);
    numero="0123456789";
    especial="8-38-38-46";
    tecla_especial=false;
    for(var i in especial){
      if(key==especial[i]){
        tecla_especial=true;
      }
    }
    if (numero.indexOf(teclado)==-1 && !tecla_especial) {
      return false;
    }
  };
  $(function(){
    $.post('<?=$base_url?>/cliente/departamento').done(function(respuesta){
    $('#departamento').html(respuesta);
  });

  $('#departamento').change(function(){
    var id_depto = $(this).val();

    $.post('<?=$base_url?>/cliente/municipio',{departamento: id_depto}).done(function(respuesta){
        $('#muni').html(respuesta);
      });
    });
  });

$('#crear_cliente_nuevos').submit(function(e){
    e.preventDefault();
    $.ajax({
      url: '<?=$base_url?>/cliente/registrar_cliente_d_p',
        type: "POST",
        async: true,
        data: $('#crear_cliente_nuevos').serialize(),
        success: function(response){
          let estado = document.querySelector('#estado_registro');
          let sum_est = document.querySelector('#estado_registro_s');
          estado.innerHTML = '';
          sum_est.innerHTML = '';
          if (response != 'error') {
          	$('#cliente_veder_solar').val(response);
          	$('#idclientesum').val(response);
            $('#cui').attr('disabled','disabled');
            $('#nombre').attr('disabled','disabled');
            $('#apellido').attr('disabled','disabled');
            $('#nit').attr('disabled','disabled');
            $('#tel1').attr('disabled','disabled');
            $('#tel2').attr('disabled','disabled');
            $('#direccion').attr('disabled','disabled');
            $('#departamento').attr('disabled','disabled');
            $('#muni').attr('disabled','disabled');
            $('#guarda_nuevo_cli').slideUp();
            $('#guarda_nuevo_cli').attr('disabled','disabled');
            $('#seccion_cliente').slideUp();
            estado.innerHTML = `<h6><i class="fa-solid fa-check"></i> Cliente registrado</h6>`;
            sum_est.innerHTML = `<h6><i class="fa-solid fa-check"></i> Cliente registrado</h6>`;
            Swal.fire(
						  'Excelente!',
						  'Se ha registrado correctamente al cliente!',
						  'success'
						)
          } else {
            Swal.fire({
						  icon: 'error',
						  title: 'Oops...',
						  text: 'Ubo un error!'
						})  
          } 
        }
    });
  });
</script>