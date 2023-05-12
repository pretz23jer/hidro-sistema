<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require FCPATH.'vendor/autoload.php';
use Dompdf\Dompdf;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Producto extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('Producto_model');
	}

	private function restringirAcceso() {
		if (!isset($this->session->USUARIO)) {
			redirect("inicio");
		}
	}

	public function index(){
		$this->restringirAcceso();
		if ($this->session->ROL == 'Admin') {
			$data['base_url'] = $this->config->item('base_url');

			$data['codigo'] = "";
			$data['nombre'] = "";
			$data['descripcion'] = "";
			$data['id_catProducto'] = "";
			$data['precio_compra'] = "";
			$data['precio_venta'] = "";
			$data['existencia'] = "";
			$data['id_provProducto'] = "";
			$data['fecha_registro'] = date("Y-m-d H:i:s");
			$data['id_usuario_registro'] = $this->session->IDUSUARIO;
			$data['fecha_modifica'] = '';
			$data['id_usuario_modifica'] = "1";
			$data['imagen'] = "";
			$data['id_control'] = "";
			$data['mensaje'] = "";

			if (isset($_POST['guardar'])) {

				$dataimg =$_FILES['foto'];
				$nombreFoto = $dataimg['name'];
				$type = $dataimg['type'];
				$url_temp = $dataimg['tmp_name'];

				$imgProducto = 'img_hidro.jpg';

				if ($nombreFoto != '') {
					
					$destino = 'recursos/upload/';
					$img_nombre = 'img_'.date('d-m-Y_H_m_s');
					$imgProducto = $img_nombre.'.jpg';
					$src = $destino.$imgProducto;
					move_uploaded_file($url_temp, $src);
				}

				$data['codigo'] = $_POST['codigo'];
				$data['nombre'] = str_replace(["<",">"], "", $_POST['nombre']);
				$data['descripcion']= str_replace(["<",">"], "", $_POST['descripcion']); 
				$data['id_catProducto'] = $_POST['categoria'];
				$data['precio_compra'] = $_POST['precio_compra'];
				$data['precio_venta'] = $_POST['precio_venta'];
				$data['existencia'] = $_POST['existencia'];
				$data['id_provProducto'] = $_POST['proveedor'];
				$data['imagen'] = $imgProducto;

				//Todos los datos son correctos, guardar en la BD.
				$this->Producto_model->crearProducto($data['codigo'], $data['nombre'], $data['descripcion'], $data['id_catProducto'], $data['precio_compra'], $data['precio_venta'], $data['existencia'], $data['id_provProducto'], $data['imagen']);

				$id_producto = $this->Producto_model->selecIdProductoP($data['codigo']);
				$this->Producto_model->crearControl($id_producto, $data['fecha_registro'], $data['id_usuario_registro'], $data['fecha_modifica'], $data['id_usuario_modifica']);
				redirect("/producto/listar");
			}
			$data['arr1'] = $this->Producto_model->selecionarCategoria();
			$this->load->view('producto/regis_producto', $data);
		} else {
			redirect("/inicio");
		}
	}

	function valiData(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');

		if($_POST['action'] == 'buscarCodigo'){
			$data['codigo'] = $_POST['cod'];
			$arr = $this->Producto_model->selCodExistenteProd($data['codigo']);
			$result = $arr;
			$data = '';
			if($result > 0){
				$data = $arr;
			}else{
				$data = 0;
			}
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
		}
	}

	//funcion para buscar al proveedor en la base de datos
	function proveedor(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		$data['proveedor'] =  $this->Producto_model->seleccionarProveedorP();
		echo '<option selected disabled value="">Buscar</option>';
		foreach ($data['proveedor'] as $key) {
			echo '<option value="'.$key['id_proveedor'].'">'.$key['nombre'].'</option>'."\n";
		}
	}


	function traer_lista_cate(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		$resultado = $this->Producto_model->mostrar_cat_regis();
		echo  json_encode($resultado, JSON_UNESCAPED_UNICODE);
	}

	//funcion para buscar la categoria en la base de datos
	function categoria(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		$data['categoria'] =  $this->Producto_model->seleccionarCategoriaP();
		echo '<option selected disabled value="">Buscar</option>';
		foreach ($data['categoria'] as $key) {
			echo '<option value="'.$key['id_categoria'].'" selected>'.$key['nombre'].'</option>'."\n";
		}
	}

		///listar el producto
	function listar(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');

		if ($this->session->ROL == 'Admin') {
			$data['arr'] = $this->Producto_model->seleccionarProductoRegistrado();

			$data['categoria'] = "";

			if (isset($_POST['BtnCategoria'])) {
				$data['categoria'] = $_POST['selectCategoria'];
				if ($data['categoria'] == "Todos") {
					$data['arr'] = $this->Producto_model->seleccionarProductoRegistrado();
				}else {
					$data['arr'] = $this->Producto_model->seleccionarProductoCategoria($data['categoria']);
				}
			}

			$this->load->view('producto/listar_producto', $data);
		} else {
			redirect("/inicio");
		}
	}
//registrar categoria
	public function registroCategoria(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');

		$data['categoria'] = "";
		$data['descripcion'] = "";
		$data['mensaje'] = "";
		if (isset($_POST['guardarCategoria'])) {

			$data['categoria'] = str_replace(["<",">"], "", $_POST['categoria']);
			$data['descripcion'] = str_replace(["<",">"], "", $_POST['descripcion']);
		//Todos los datos son correctos, guardar en la BD.
			$this->Producto_model->categoriaProducto($data['categoria'], $data['descripcion']);

			$data['mensaje'] = "<div class=\"alert alert-success espacio shadow-lg p-3 mb-5 bg-white\" role=\"alert\">Datos guardados exitosamente</div>";
			redirect("/producto");
		}
	}

//buscar registro del producto en un arreglo
	function buscarRegistroProducto(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');

		if(!empty($_POST['id_producto'])){
			$data['id_producto'] = $_POST['id_producto'];
			$arr = $this->Producto_model->mostrarDatosProdIndividual($data['id_producto']);

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


///para actualziar la existencia del producto asi tambien un control de reigstro de modificacion
/// 
	function actualizarProductoStok(){
		$this->restringirAcceso();

		if(($_POST['action'] == 'actualizaDato') & (empty($_POST['id_prod'])) ){
			echo "error";
		}else {

			$data['id_producto'] = $_POST['id_prod'];
			$data['precio_compra'] = $_POST['compra'];
			$data['precio_venta'] = $_POST['venta'];
			$data['existencia'] = $_POST['stock'];

			$data['id_usuario_modifica'] = $this->session->IDUSUARIO;
			$data['fecha_modifica'] = date("Y-m-d H:i:s");

			$this->Producto_model->actualizarStockProducto($data['id_producto'], $data['precio_compra'], $data['precio_venta'], $data['existencia']);
			$this->Producto_model->actualizarControlProducto($data['id_usuario_modifica'], $data['fecha_modifica'], $data['id_producto']);

			$result = '1';
			$data1 = '1';
			if($result > 0){
				$data1 = $arr;
			}else{
				$data1 = 0;
			}
			echo json_encode($data1, JSON_UNESCAPED_UNICODE);
		} 
	}

//editar datos generales del producto
	function editar($id_producto = 0){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		if ($this->session->ROL == 'Admin') {

			$data['arr'] = $this->Producto_model->seleccionarProductoEditar($id_producto);
			$this->load->view('producto/editar_producto', $data);
		} else {
			redirect("/inicio");
		}
	}

	function editarDatosProducto(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		$dataimg = "";
		$imgProducto = "";

		$dataimg = $_FILES['foto'];
		$nombreFoto = $dataimg['name'];
		$type = $dataimg['type'];
		$url_temp = $dataimg['tmp_name'];

		if ($nombreFoto != '') {
			$destino = 'recursos/upload/';
			$img_nombre = 'img_'.date('d-m-Y_H_m_s');
			$imgProducto = $img_nombre.'.jpg';
			$src = $destino.$imgProducto;
			move_uploaded_file($url_temp, $src);
			$data['imagen'] = $imgProducto;
			unlink('recursos/upload/'.$_POST['foto_actual']);
		} else {
			$data['imagen'] = $_POST['foto_actual'];
		}

		$data['id_producto'] = $_POST['id_produ'];
		$data['codigo'] = $_POST['codigoP'];
		$data['nombreProducto'] = $_POST['nombreP'];
		$data['descripcion'] = $_POST['descripcion'];
		$data['precio_compra'] = $_POST['precioc'];
		$data['precio_venta'] = $_POST['preciov'];
		$data['existencia'] = $_POST['existencia'];
		$data['id_catProducto'] = $_POST['categoria'];
		$data['id_provProducto'] = $_POST['proveedor'];
		$data['id'] = $_POST['id'];
		$data['id_usuario_modifica'] = $this->session->IDUSUARIO;
		$data['fecha_modifica'] = date("Y-m-d H:i:s");

		$regis = $this->Producto_model->actualizarProductoSeleccionado($data['codigo'], $data['nombreProducto'], $data['descripcion'], $data['id_catProducto'], $data['precio_compra'], $data['precio_venta'], $data['existencia'], $data['id_provProducto'], $data['imagen'], $data['id_producto']);
		$this->Producto_model->actualizarControl($data['id_producto'], $data['fecha_modifica'], $data['id_usuario_modifica']);
		$result = $regis;
		echo json_encode($regis, JSON_UNESCAPED_UNICODE);
	}

//dar de baja a un  producto

	public function baja() {
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		if ($this->session->ROL == 'Admin') {
			$id_producto = $_POST['id'];
			$result = $this->Producto_model->darBajaP($id_producto);
			echo $result;
		} else {
			redirect("/inicio");
		}
	}

	///funcion para productos en promocion
	
	function productosEnPromocion(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		if ($this->session->ROL == 'Admin') {
			print_r($_POST);

			if(($_POST['action'] == 'agregaPromo') & (empty($_POST['id_prod'])) ){
				echo "error";
			}else {
				$data['prod_id_producto'] = $_POST['id_prod'];
				$data['precio_compra'] = $_POST['compra'];
				$data['precio_venta_sis'] = $_POST['venta'];
				$data['precio_promocion'] = $_POST['precioProm'];
				$data['stock'] = $_POST['stock'];
				$data['descripcion'] = $_POST['descripcion'];
				$data['usuario_modifica'] = $this->session->IDUSUARIO;
				$data['fecha_modificacion'] = date("Y-m-d H:i:s");

				$regis = $this->Producto_model->regitrarProductoPromocion($data['prod_id_producto'], $data['precio_compra'], $data['precio_venta_sis'], $data['precio_promocion'], $data['descripcion'], $data['usuario_modifica'], $data['fecha_modificacion']);
				echo json_encode($regis, JSON_UNESCAPED_UNICODE);
			}
		} else {
			redirect("/inicio");
		}
	}
	//listados de productos en promociones
	function listarPromociones(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		$data['arr'] = $this->Producto_model->seleccionarProductoEnPromocion();
		$this->load->view('producto/producto_promocion', $data);

	}
///dar de baja a producto en promoción
	function bajaPromocion(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		if ($this->session->ROL == 'Admin') {
			$id_producto = $_POST['id'];
			$result = $this->Producto_model->darBajaPromocion($id_producto);
			echo $result;
		} else {
			redirect("/inicio");
		}
	}
}

