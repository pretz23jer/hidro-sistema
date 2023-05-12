<div class="fondo_venta">
	<div class="row">
        <div class="col-md-4">
          <center><label class="separa"><i class="fa-solid fa-id-card"></i> CUI | Nombre | Apellido</label></center>
          <input type="text" class="form-control text-center" id="cui_b" minlength="2" maxlength="20" name="cui_b" placeholder="Buscar..." value="" required>
        </div>
        <div class="col-md-8 separa">
        	<div id="resultado_cliente" class="table-responsive">
        	</div>
        </div>
    </div>
</div>
<script type="text/javascript">
function obtener_data(cliente){
  	$.ajax({
  		url: '<?=$base_url?>/cliente/buscar_d',
  		type: 'POST',
  		dataType: 'html',
  		data: {cliente: cliente},
  	})
  	.done(function(respuesta){
  		$("#resultado_cliente").html(respuesta);
  	})
 };

 $(document).on('keyup', '#cui_b', function(){
	 	var valorBus =$ (this).val();
	 	if(valorBus != ""){
	 		$("#resultado_cliente").slideDown();
	 		obtener_data(valorBus);
	 	}else{
	 		$("#resultado_cliente").slideUp();
	 	}
 });

$('#create_c').click(function(){
	$('#seccion_buscar').slideUp();
});

$('#buscar_c_r').click(function(){
	$('#seccion_cliente').slideUp();
});
</script>