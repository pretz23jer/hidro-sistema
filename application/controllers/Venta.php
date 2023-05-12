<?php defined('BASEPATH') OR exit('No direct script access allowed');
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Venta extends CI_Controller {
function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('Cliente_model');
		$this->load->model('Venta_model');
		$this->load->model('Producto_model');
	}

	private function restringirAcceso() {
		if (!isset($this->session->USUARIO)) {
			redirect("usuario");
		}
	}
	
	public function index($id = null){
		$this->restringirAcceso();
		 if ($id == null) {
    	redirect("/venta/crear_venta");
    }
	}
//nueva actualizacion
	function crear_venta(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		$this->load->view('venta/venta', $data);
	}

	function tarer_producto_suministro(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		$base_url = $this->config->item('base_url');
		$data['sumin'] = $this->Venta_model->Selec_ProductoSuministro();
		$tabla = '';
		$tabla.="
		<div class='table-responsive-sm'>
      <table class='table table-striped table-bordered table-hover' width='100%' id='suministrosv'>
        <thead>
            <th class='text-center'>Op.</th>
            <th class='text-center'>COD</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th class='text-center'>Precio Venta</th>
            <th class='text-center'>Stock</th>
            <th class='text-center'><i class='fa-solid fa-image'></i></th>
        </thead>
        <tbody>";
          foreach ($data['sumin'] as $s){
            $direccion = $base_url.'/recursos/upload/';
            $imagens = $direccion.$s['imagen'];
        $tabla.="
          <tr>
            <td class='text-center' style='padding-top: 25px;'><a class='btn  btn-warning iconos' style='font-weight: bold; border-radius: 25px;' onclick='obdatosIdSum(".$s['id_producto'].")' data-bs-dismiss='modal'><i class='fa-solid fa-puzzle-piece'></i></a></td>
            <td class='text-center'>".$s['codigo']."</td>
            <td>".$s['nombreP']."</td>
            <td>".$s['categoria']."</td>
            <td class='text-center'>Q. ".number_format($s['precio'])."</td>
            <td class='text-center'>".$s['existencia']."</td>
            <td class='text-center'><img height='75px' src='".$imagens."'></td>
          </tr>
          </tr>";
            }
    	$tabla.="</tbody>
        </table>
      </div>";
  	echo $tabla;
	}

	function buscarProductoRe(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		if(!empty($_POST['id_producto'])){
        $data['id_producto'] = $_POST['id_producto'];
        $arr = $this->Venta_model->buscarProductoRegis($data['id_producto']);
          $result = $arr;
          $data = '';
          if($result > 0){
            $data = $arr;
          }else{
            $data = 0;
          }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
      	}
    	exit;
	}

	function crear_venta_nuevo(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		if(empty($_POST['cliente_veder_solar'])){
			echo "error";
		}else {
			$data['id_clienteVenta'] = $_POST['cliente_veder_solar'];
			$data['id_producto'] = $_POST['id_prod'];
			$data['existencia'] = $_POST['stok_prod'];
			$data['cantidad'] = $_POST['cant_v'];
			$data['precio_venta'] = $_POST['precio_v'];
			$data['descuento'] = $_POST['desc_v'];
			$data['anticipo'] = $_POST['anti_v'];
			$data['poranticipo'] = $_POST['poranticipo'];
			$data['pendiente'] = $_POST['pend_v'];
			$data['porpendiente'] = $_POST['porpendiente'];
			$data['subtotal'] = $_POST['sub_v'];
			$data['total'] = $_POST['total_v'];
			$data['id_usuarioVenta'] = $this->session->IDUSUARIO;
			$data['fecha_registro'] = date("Y-m-d H:i:s");
			$data['modifica_id_usuario'] = '1';
			$data['usuario_fecha_modifica'] = '';
			$data['lugar_id_lugar'] = $this->session->LUGAR;

			
			$data['descripcion'] = $_POST['desIns'];
			$data['lugar'] = $_POST['lugIns'];
			$data['diaIns'] = $_POST['diaIns'];
			$data['horaIns'] = $_POST['horIns'];
			
			if($_POST['resAgenVen1'] == ''){
				$data['us_id_us'] = '1';
			}else{
				$data['us_id_us'] = $_POST['resAgenVen1'];
			}
			
			if($_POST['resAgenVen2'] == ''){
				$data['us_id_us_dos'] = '1';
			}else{
				$data['us_id_us_dos'] = $_POST['resAgenVen2'];
			}

			if (empty($_POST['observacion'])) {
				$data['observacion'] = ".";
			}else{
				$data['observacion'] = $_POST['observacion'];
			}

			$data['titulo'] = "Intalación de Calentador Solar";
			$data['color_fondo'] = "#0835a3";
			$data['color_text'] = "#fff";
			$data['comienzo'] = $data['diaIns'] ." ". $data['horaIns'];
			$data['fin'] = $data['diaIns'] ." ". "18:00:00";
			$dat['us_id_us_tres'] = "1";


			$id_ventas = $this->Venta_model->crearVenta($data['id_clienteVenta'], $data['id_usuarioVenta'], $data['fecha_registro'], $data['modifica_id_usuario'], $data['usuario_fecha_modifica'], $data['lugar_id_lugar'], $data['observacion']);
			
			$this->Venta_model->agregarDetalleVenta($id_ventas, $data['precio_venta'], $data['cantidad'], $data['descuento'], $data['anticipo'], $data['poranticipo'], $data['pendiente'], $data['porpendiente'], $data['id_producto'], $data['subtotal'], $data['total']);

			$this->Venta_model->crearVentaCliente($data['id_clienteVenta']);
			$this->actualizarInventarioP($data['cantidad'], $data['id_producto'], $data['existencia']);

			if (!empty($_POST['diaIns']) ) {
				$this->Venta_model->agendarInstalacion($data['titulo'], $data['descripcion'], $data['lugar'], $data['color_fondo'], $data['color_text'], $data['comienzo'], $data['fin'], $data['us_id_us'], $data['us_id_us_dos'], $dat['us_id_us_tres']);
			}

    	$data = $id_ventas;
    	
    	echo $data;
		} 	
	}

	function descargar($id = 0){
    $this->restringirAcceso();
    $data['base_url'] = $this->config->item('base_url');
    	$data['arr'] = $this->Venta_model->seleccionarVentaCliente($id);
		$this->load->view('venta/imprimirVenta', $data);
	}

	function crear_venta_a(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		$data['base_url'] = $this->config->item('base_url');
		$data['codVenta'] = $this->Venta_model->buscarNumeroV();
		$data['codVentaSum'] = $this->Venta_model->buscarNumeroVsum();
		$data['codCliente'] = $this->Venta_model->buscarNumeroCliente();
		$data['solar'] = $this->Venta_model->Selec_ProductoSolar();
		$data['sumin'] = $this->Venta_model->Selec_ProductoSuministro();
		$this->load->view('venta/crear_venta', $data);
	}

	//crear cliente
	function crearCliente(){
    $this->restringirAcceso();
    $data['base_url'] = $this->config->item('base_url'); 
    //print_r($mensaje);
    if($_POST['action'] == 'agregarCliente'){
      $data['codigo'] = $_POST['cod_cliente'];
      $data['cui'] = $_POST['cui_cliente'];
      $data['nombre'] = $_POST['nom_cliente'];
      $data['numero1'] = $_POST['tel_cliente'];
      $data['numero2'] = $_POST['tel1_cliente'];
      $data['nit'] = $_POST['nit_cliente'];
      $data['direccion'] = $_POST['dir_cliente'];
      $data['muni_id_muni'] = $_POST['muni'];
      $data['id_usuario'] = ($this->session->IDUSUARIO);

     	$id_cliente_tel = $this->Venta_model->registroNuevoCliente($data['codigo'], $data['nombre'], $data['cui'], $data['direccion'], $data['id_usuario'], $data['nit'], $data['muni_id_muni']);
      $this->Venta_model->agregarTeldelClien($id_cliente_tel, $data['numero1'], $data['numero2']);
      $data = $id_cliente_tel;
      	echo json_encode($data, JSON_UNESCAPED_UNICODE);
      	}
    }

	function actualizarInventarioP($cantidad, $id_producto, $existencia){
		$existencia -= $cantidad;
		$this->Venta_model->actualizarInventarioPro($existencia, $id_producto);
	}

	function editar($id = 0){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		$data['arr'] = $this->Venta_model->seleccionarVentaEditar($id);

			$data['cliente'] ='';
			$data['producto'] ='';
			$data['codigo'] ='';
			$data['nombreProducto'] ='';
			$data['descripcion'] ='';
			$data['cantidad'] ='';
			$data['precio_venta'] ='';
			$data['descuento'] ='';
			$data['anticipo'] ='';
			$data['pendiente'] ='';
			$data['vendedor'] ='';
			$data['mensaje'] = "";

			if (isset($_POST['ACTUALIZAR'])){
			$data['id_venta'] = $_POST['id_ventacito'];
			$anti_ante = str_replace(["<",">"], "", $_POST['anticipo_ante']);
			$anti_despues = str_replace(["<",">"], "", $_POST['anticipo']);
			$anti_final = $anti_ante + $anti_despues;
			$data['anticipo'] = $anti_final;
			$data['pendiente'] = str_replace(["<",">"], "", $_POST['pendiente']);
			$data['id_usuario_modifica'] = $this->session->IDUSUARIO;
			$data['fecha_modifica'] = date("Y-m-d H:i:s");

			$this->Venta_model->actualizarVenta($data['id_venta'], $data['id_usuario_modifica'], $data['fecha_modifica']);//ngresa datos en la tabla 
			$this->Venta_model->actualizarDetalleVenta($data['id_venta'], $data['anticipo'], $data['pendiente']);

			$data['mensaje'] = "<script>Swal.fire({
                icon: 'success',
                title: 'Exitoso',
                text: 'Se a actualizado correctamente!',
                showConfirmButton: false,
                timer: 1500
            }) </script>";
			
			if ($this->session->ROL == 'Admin') { 
				redirect("venta/listar_venta/");
				} 
				redirect("venta/listarVentaUsuario");
			}
		$this->load->view('venta/editar_crear_venta', $data);
	}
	
//funcion para buscar al cliente en la base de datos
	function cliente(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		
		$data['cliente'] =  $this->Cliente_model->seleccionarClienteVender();
		echo '<option selected disabled value="">Buscar</option>';
		foreach ($data['cliente'] as $key) {
		echo '<option value="'.$key['id_cliente'].'">'.$key['nombre'].'</option>'."\n";
		}
	}

  function listar_venta(){
  	$this->restringirAcceso();
  	$data['base_url'] = $this->config->item('base_url');
  	if ($this->session->ROL == 'Admin') { 
	  	$data['arr'] = $this->Venta_model->seleccionarVentaListar();
			$this->load->view('venta/list_venta_s', $data);
		}else{
			$data['arr'] = $this->Venta_model->seleccionarVentaListarVende($this->session->IDUSUARIO);
			$this->load->view('venta/list_venta_s', $data);
		}
	}

	function list_venta_h(){
		$this->restringirAcceso();
  	$data['base_url'] = $this->config->item('base_url');
  	$base_url = $this->config->item('base_url');
  	if ($this->session->ROL == 'Admin') { 
  	$data['arr'] = $this->Venta_model->seleccionarVentaListar();
  }else{
  	$data['arr'] = $this->Venta_model->seleccionarVentaListarVende($this->session->IDUSUARIO);
  }
  	$tabla = '';
  	$arrayData = array();
  	if (count($data['arr']) < 1) {
	  	$tabla = '0';
		}else{
		$tabla.="
		<div class='table-responsive-sm'>
      <table class='table table-bordered table-striped table-hover' id='tabla_ventas' width='100%'>
        <thead>
            <th scope='col' class='text-center'>#</th>
            <th scope='col' class='text-center'>Vendedor</th>
            <th class='text-center'>Fecha Venta</th>
            <th scope='col' class='text-center'>Cliente</th>
            <th scope='col' class='text-center'>Producto</th>
            <th scope='col' class='text-center'><i class='fa-solid fa-layer-group'></i></th>
            <th scope='col' class='text-center'>Precio Venta</th>
            <th scope='col' class='text-center'>Desc</th>
            <th scope='col' class='text-center'>Anticipo</th>
            <th scope='col' class='text-center'>Pendiente</th>
            <th class='text-center'>Fecha Mod.</th>
            <th scope='col' class='text-center'>Usuario Mod.</th>
            <th scope='col' class='text-center'><i class='fa-solid fa-eye'></i></th>
            <th scope='col' class='text-center'><i class='fa-solid fa-pen-to-square'></i></th>
            ";
				if ($this->session->ROL == 'Admin'){
        $tabla.= "<th class='text-center'><i class='fas fa-trash-alt'></i></th>";
        }
        $tabla.= "
        </thead>
        <tbody>";
        foreach ($data['arr'] as $a){
        $tabla.="
          <tr>
            <td class='text-center'>".$a['id_venta']."</td>
              <td>".$a['usuario']."</td>
              <td>".$a['fecha']."</td>
              <td>".$a['cliente']."</td>
              <td>".$a['producto']."</td>
              <td class='text-center'>".$a['cantidad']."</td>
              <td>Q. ".number_format($a['precio']).".00</td>
              <td class='text-center'>Q. ".number_format($a['descuento'])."</td>
              <td>Q. ".number_format($a['anticipo'])."</td>
              <td class='text-center'>";
        if($a['pendiente'] == 0){
        $tabla.="
              <center><i class='fa-regular fa-circle-check fa-2x text-success fw-bold pt-2'></i></center>";      
        } else{
        $tabla.="<p style='color: red; font-weight: bold'>Q. ".number_format($a['pendiente'])."</p> ";
        }
        $tabla.="
              </td>
              <td>".$a['fecha_modifica']."</td>
              <td>".$a['usuarioModifica']."</td>
              <td><center>
                  <a class='btn btn-primary btn-sm' href='".$base_url."/venta/imprimir/".$a['id_venta']."'><i class='fa-solid fa-eye'></i></a>
              </center></td>
                <td><center> ";
        if($a['pendiente'] == 0){
        $tabla.="<p style='color: #130691; font-weight: bold;'><i class='fa-solid fa-circle-check h4'></i></p>";
        } else{
        $tabla.="<a class='btn btn-success btn-sm'  href='".$base_url."/venta/editar/".$a['id_venta']."'><i class='fa-solid fa-pencil'></i></a>
                 ";
        }
        if ($this->session->ROL == 'Admin'){
	        $tabla.="
	                 </center></td>
	                <td><center><a class='btn btn-danger btn-sm' style='color: #fff;' data-bs-toggle='modal' data-bs-target='#eliminar' 
	                onclick='obdatosId(".$a['id_venta'].")'><i class='fa-solid fa-trash-can'></i></a></center>
	                </td>
	              </td>
	          </tr>";
	      }
	    }
    	$tabla.="</tbody>
        </table>
        </div>
      </div>";
    }
    echo $tabla;
	}
//listar venta segun id usuario logeado
		function listarVentaUsuario(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		$data['arr'] = $this->Venta_model->selVentaListarUsuario($this->session->IDUSUARIO);
		$this->load->view('venta/listado_venta', $data);
	}

	function descargarm($id = 0){
		$this->restringirAcceso();
		$data['arr'] = $this->Venta_model->seleccionarVentaCliente($id);
		$hoy = date("d-m-Y");
		$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'Letter']);
		$html=$this->load->view('imprimirVentaPdf', $data, true);
		$pdfFilePath = "ENERGY".'_Contrato_'.$hoy.".pdf";

		$mpdf->SetWatermarkImage('/energy/resources/imgenergy.jpg');
		$mpdf->showWatermarkImage = true;
		$mpdf->WriteHTML($html);
		$mpdf->Output($pdfFilePath, 'D');
	}

	//listar ventas anuladas
	function lista_v_anula(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		if ($this->session->ROL == 'Admin') {
	    $data['arr'] = $this->Venta_model->lisVentaAnulada();
			$this->load->view('venta/lista_venta_anulada', $data);
		}else{
			redirect('inicio');
		}
	}

	function listarVentasAnuladasU(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
    $data['arr'] = $this->Venta_model->lisVentaAnuladaU($this->session->IDUSUARIO);
		$this->load->view('venta/lista_venta_anulada', $data);
	}

	//listar ventas de suministros
	function listarventasum(){
  	$this->restringirAcceso();
  	$data['base_url'] = $this->config->item('base_url');
  	if ($this->session->ROL == 'Admin') {
  	$data['arr'] = $this->Venta_model->listarVentasSuministros();
  	$this->load->view('venta/list_venta_s', $data);
  	}else{
  		$data['arr'] = $this->Venta_model->listarVentasSuministrosVendedor($this->session->IDUSUARIO);
  		$this->load->view('venta/list_venta_s', $data);
  	}
	}

	function listarventasumusuario(){
	 		$this->restringirAcceso();
	  	$data['base_url'] = $this->config->item('base_url');
	  	$data['arr'] = $this->Venta_model->listarVentasSuministrosU($this->session->IDUSUARIO);
	  	$this->load->view('listado_ventaSumiUsuario', $data);
	}

	function mostrarvensum($id = 0){
	 	$this->restringirAcceso();
	  	$data['base_url'] = $this->config->item('base_url');
	  	$data['arr'] = $this->Venta_model->seleccionarVentaSuministros($id);
		$this->load->view('venta/imp_venta_sum', $data);
	}

	function darbaja($no_venta = 0) {
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		$this->Venta_model->darBaja($no_venta);
		redirect("/venta/listar_venta");
	}

	//dar baja a la venta seleccionada, para ver a delle la venta efectuada antes de eliminar
	function buscarRegistroVenta(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');

		if(!empty($_POST['id_venta'])){
        $data['id_ventas'] = $_POST['id_venta'];
        $arr = $this->Venta_model->buscarVentaRegis($data['id_ventas']);

            $result = $arr;
            $data = '';
            if($result > 0){
              $data = $arr;
            }else{
              $data = 0;
            }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
      }
    	exit;
	}

	//cambiar estado de la venta de suministros
	function canbio_estado_venta(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');

		if($_POST['action'] == 'eliminarRegi'){
	 		if(!empty($_POST['id_v'])){
	        $data['no_venta'] = $_POST['id_v'];
	        $data['id_cliente'] = $_POST['id_cli'];
	        $arr = $this->Venta_model->darBajaClienteVentaCalentador($data['id_cliente']);
	        $arr = $this->Venta_model->anularVenta($data['no_venta']);
	    
			    $resultado = $arr;
			    if($resultado > 0){
			      $data = $arr;
			      echo json_encode($data, JSON_UNESCAPED_UNICODE);
			    }
	   		}
	   	}
	}

	//buscar comprobante registrado antes de eliminar
	function buscarRegistroVentaSum(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');

		if(!empty($_POST['id_comprobante'])){
        $data['id_comprobante'] = $_POST['id_comprobante'];
        $arr = $this->Venta_model->buscarVentaRegisSuminis($data['id_comprobante']);

            $result = $arr;
            $data = '';
            if($result > 0){
              $data = $arr;
            }else{
              $data = 0;
            }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
      }
    	exit;
	}
//cambiar estado de la venta de suministros
	function cambioEstadoVenSum(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');

		if($_POST['action'] == 'eliminarRegi'){
	 		if(!empty($_POST['id_vsum'])){
	        $data['noComprob'] = $_POST['id_vsum'];
	        $data['id_cliente'] = $_POST['id_cli'];
	        $arr = $this->Venta_model->darBajaClienteVentaS($data['id_cliente']);
	        $arr = $this->Venta_model->anularComprobSelVs($data['noComprob']);
	    
			    $resultado = $arr;
			    if($resultado > 0){
			      $data = $arr;
			      echo json_encode($data, JSON_UNESCAPED_UNICODE);
			    }
	   		}
	   	}
	}

//Detalle temportal del Producto al momento de elegir el producto___________________________________
  function agregarAlDetalleProd(){
    $this->restringirAcceso();
    
     if($_POST['action'] == 'addProductoDetalle'){
     	 //print_r($_POST);
        $data['codigo'] = $_POST['producto'];
        $data['cantidad'] = $_POST['cantidad'];
        $data['descuento'] = $_POST['descuento'];
        $data['enganche'] = $_POST['enganche'];
        $data['token_user'] = ($this->session->IDUSUARIO);

        $arr = $this->Venta_model->AgregarServicioD($data['codigo'], $data['cantidad'], $data['descuento'], $data['enganche'], $data['token_user']);
        $result = $arr;

        $detalleTabla = '';
        $sub_total    = 0;
        $iva          = 0;
        $total        = 0;
        $arrayData    = array();

        if ($result > 0) {
          foreach ($arr as $b) {
          $precioTotal = round(($b['cantidad'] * $b['precio_venta'])-$b['descuento'], 2);
          $sub_total = round($sub_total + $precioTotal, 2);
          $total = round($total + $precioTotal, 2);
          
          $detalleTabla .=  "<tr>
              <td>".$b['codigo']."</td>
              <td class='text-center'>".$b['cantidad']."</td>
              <td>".$b['nombreProducto'].", ".$b['descripcion']."</td>
              <td class='text-end'>".$b['precio_venta']."</td>
              <td class='text-end'>".$b['descuento']."</td>
              
              <td class='text-end'>".number_format($precioTotal,2)."</td>
              <td>
              <center><a class='link_delete btn btn-danger btn-sm' href='#' onclick='event.preventDefault(); del_product_detalle(".$b['correlativo'].")'><i class='fa-solid fa-trash-can' style='font-weight: bold;'></i></a></center>
              </td>
          </tr>";
          }
        }

        $impuesto = round($sub_total * ($iva / 100), 2);
        $tl_sniva = round($sub_total - $impuesto, 2);
        $total    = round($tl_sniva + $impuesto, 2);
       
        $detalleTotales = '
        <tr>
          <td colspan="6" class="text-end">SUBTOTAL Q.</td> 
          <td class="text-fin">'.number_format($tl_sniva,2).'</td>   
        </tr>
        <tr>
          <td colspan="6" class="text-end">TOTAL Q.</td> 
          <td class="text-fin">'.number_format($total,2).'</td>   
        </tr>
        ';

        $arrayData['detalle'] = $detalleTabla;
        $arrayData['totales'] = $detalleTotales;
        echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
    	}
   }
 //extrae datos del detalle temp sobre los productos que se han agregado a la tabla temporal
  function mostrarDatos(){
  $this->restringirAcceso();
  if($_POST['action'] == 'searchForDetalle'){
      if(empty($_POST['user'])){
        echo "error";
      }else{
        $data['token_user'] = ($this->session->IDUSUARIO);

        $arr = $this->Venta_model->traerServicioC($this->session->IDUSUARIO);
        $result = $arr;

        $detalleTabla = '';
        $sub_total    = 0;
        $iva          = 0;
        $total        = 0;
        $arrayData    = array();

        if ($result > 0) {
          foreach ($arr as $b) {
          $precioTotal = round(($b['cantidad'] * $b['precio_venta'])-$b['descuento'], 2);
          $sub_total = round($sub_total + $precioTotal, 2);
          $total = round($total + $precioTotal, 2);
          
          $detalleTabla .=  "<tr>
              <td>".$b['codigo']."</td>
              <td class='text-center'>".$b['cantidad']."</td>
              <td>".$b['nombreProducto'].", ".$b['descripcion']."</td>
              <td class='text-end'>".$b['precio_venta']."</td>
              <td class='text-end'>".$b['descuento']."</td>
         
              <td class='text-end'>".number_format($precioTotal,2)."</td>
              <td>
              <center><a class='link_delete btn btn-danger btn-sm' href='#' onclick='event.preventDefault(); del_product_detalle(".$b['correlativo'].")'><i class='fa-solid fa-trash-can' style='font-weight: bold;'></i></a></center>
              </td>
          </tr>";
          }
        }

        $impuesto = round($sub_total * ($iva / 100), 2);
        $tl_sniva = round($sub_total - $impuesto, 2);
        $total    = round($tl_sniva + $impuesto, 2);
       
        $detalleTotales = '
        <tr>
          <td colspan="6" class="text-fin">SUBTOTAL Q.</td> 
          <td class="text-end">'.number_format($tl_sniva,2).'</td>   
        </tr>
        <tr>
          <td colspan="6" class="text-fin">TOTAL Q.</td> 
          <td class="text-end">'.number_format($total,2).'</td>   
        </tr>
        ';

        $arrayData['detalle'] = $detalleTabla;
        $arrayData['totales'] = $detalleTotales;
        echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
      }
    }
  }

//elimiar producto en el detalle_temp
  function elimiarDetalle(){
    $this->restringirAcceso();
    if($_POST['action'] == 'del_product_detalle'){
      if(empty($_POST['id_detalle'])){
        echo "error";
      }else{
        $data['id_detalle'] = $_POST['id_detalle'];
        $data['token'] = ($this->session->IDUSUARIO);

        $arr = $this->Venta_model->ElimiarServicioD($data['id_detalle'], $data['token']);
        $result = $arr;

        $detalleTabla = '';
        $sub_total    = 0;
        $iva          = 0;
        $total        = 0;
        $arrayData    = array();

        if ($result > 0) {
          foreach ($arr as $b) {
          $precioTotal = round(($b['cantidad'] * $b['precio_venta'])-$b['descuento'], 2);
          $sub_total = round($sub_total + $precioTotal, 2);
          $total = round($total + $precioTotal, 2);
          
          $detalleTabla .=  "<tr>
              <td>".$b['codigo']."</td>
              <td class='text-center'>".$b['cantidad']."</td>
              <td>".$b['nombreProducto'].", ".$b['descripcion']."</td>
              <td class='text-end'>".$b['precio_venta']."</td>
              <td class='text-end'>".$b['descuento']."</td>

              <td class='text-end'>".number_format($precioTotal,2)."</td>
              <td>
              <center><a class='link_delete btn btn-danger btn-sm' href='#' onclick='event.preventDefault(); del_product_detalle(".$b['correlativo'].")'><i class='fa-solid fa-trash-can' style='font-weight: bold;'></i></a></center>
              </td>
          </tr>";
          }
        }

        $impuesto = round($sub_total * ($iva / 100), 2);
        $tl_sniva = round($sub_total - $impuesto, 2);
        $total    = round($tl_sniva + $impuesto, 2);
       
        $detalleTotales = '
        <tr>
          <td colspan="6" class="text-fin">SUBTOTAL Q.</td> 
          <td class="text-end">'.number_format($tl_sniva,2).'</td>   
        </tr>
        <tr>
          <td colspan="6" class="text-fin">TOTAL Q.</td> 
          <td class="text-end">'.number_format($total,2).'</td>   
        </tr>
        ';

        $arrayData['detalle'] = $detalleTabla;
        $arrayData['totales'] = $detalleTotales;
        echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
      }
    }
  }

  function eliminarDetalle(){
    $this->restringirAcceso();
    if($_POST['action'] == 'anularVenta'){

      $data['token'] = ($this->session->IDUSUARIO);

      $eliminar = $this->Venta_model->ElimiarDet($data['token']);
     
      if($eliminar){
        echo "Ok";
      }else{
        echo "error";
      }
    }
  }
//para guardar los datos del detalle y el usuario responsable
  function guardarVentaRealizada(){
    $this->restringirAcceso();
   
    if(($_POST['action'] == 'procesarComprobante') & (empty($_POST['idClient'])) ){
			echo "error";
		}else {
      $data['id_cliente'] = $_POST['idClient'];
	    $data['token'] = ($this->session->IDUSUARIO);
	    $data['id_usuario'] = ($this->session->IDUSUARIO);
	    $data['tipo'] = 'vs';
	    $this->Venta_model->crearVentaSCliente($data['id_cliente']); 
	    $resultado = $this->Venta_model->traerComprobanteV($this->session->IDUSUARIO);
      
      	if($resultado > 0){
        	$procesarVenta = $this->Venta_model->procesarComprobanteV($data['id_usuario'], $data['id_cliente'], $data['token'],$data['tipo']);

        	$respuesta = $procesarVenta;
        	if($respuesta > 0){
          		$data = $procesarVenta;
          		echo json_encode($data, JSON_UNESCAPED_UNICODE);
        	}else{
          	echo "error";
        	}
      	}else{
        echo "error";
      }
    }
   
  }

  //imprimir la venta efectuada
  function imprimir($id = 0){
    $this->restringirAcceso();
    if ($id == null) {
    	redirect("/venta/listar_venta");
    }else{
	    $data['base_url'] = $this->config->item('base_url');
	    $data['arr'] = $this->Venta_model->seleccionarVentaCliente($id);
			$this->load->view('venta/imprimir', $data);
		}
	}
}