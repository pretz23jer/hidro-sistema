<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Proveedor extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('Proveedor_model');
	}

	private function restringirAcceso() {
		if (!isset($this->session->USUARIO)) {
			redirect("/inicio");
		}
	}

	public function index()	{
		$this->restringirAcceso();
		if ($this->session->ROL == 'Admin') {
		$data['base_url'] = $this->config->item('base_url');
	
		$data['boton'] = "";
		$data['nombre'] = "";
		$data['direccion'] = "";
		$data['telefono'] = "";
		$data['tipo'] = "";
		$data['id_usuario'] = $this->session->IDUSUARIO;
		$data['boton'] = "<input class=\"btn btn-outline-primary btn-md botones\" type=\"submit\" role=\"button\" name=\"guardar\" value=\"Guardar\">";

		if (isset($_POST['guardar'])) {
			$data['nombre'] = str_replace(["<",">"], "", $_POST['nombre']); 
			$data['direccion'] = str_replace(["<",">"], "", $_POST['direccion']);
			$data['telefono'] = preg_replace("/[[:space:]]/","",trim($_POST['telefono']));
			$data['tipo'] = str_replace(["<",">"], "", $_POST['tipo']);
			
			$this->Proveedor_model->crearProveedor($data['nombre'], $data['direccion'], $data['telefono'], $data['tipo'], $data['id_usuario']);

			$data['mensaje'] = "<script>Swal.fire(
			'Excelente!',
			'Se ha registrado correctamente al proveedor!',
			'success'
		);</script>";
		$data['boton'] = "<a class=\"btn btn-outline-success\" href=\"proveedor\" role=\"button\">Inscribir otro proveedor</a>";
	}
	$this->load->view('proveedor/proveedor', $data); 
		} else {
			redirect("/inicio");
		}
	}

	public function editar($id = 0) {
			$this->restringirAcceso();
			$data['base_url'] = $this->config->item('base_url');
			if ($this->session->ROL == 'Admin') {
			$data['arr'] = $this->Proveedor_model->seleccionarProveedorEditar($id);
			
			$data['nombre'] ="";
			$data['direccion'] = "";
			$data['telefono'] ="";
			$data['tipo'] ="";
			$id_proveedor = "";

			if (isset($_POST['actualizar'])) {
				$data['nombre'] = str_replace(["<",">"], "", $_POST['nombre']);
				$data['direccion'] = $_POST['direccion'];
				$data['telefono'] = preg_replace("/[[:space:]]/","",trim($_POST['telefono']));
				$data['tipo'] = $_POST['tipo'];
				$data['id_proveedor'] = $_POST['id_prove'];

			$this->Proveedor_model->actualizar_proveedor($data['id_proveedor'], $data['nombre'], $data['direccion'], $data['telefono'], $data['tipo']);//ingresa datos en la tabla 
			redirect("proveedor/listar");
			}
		$this->load->view('proveedor/editar_proveedor', $data);
		} else {
			redirect("/inicio");
		}
	}

	public function listar(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		if ($this->session->ROL == 'Admin') {
		$data['arr'] = $this->Proveedor_model->seleccionarProveedor();
		$this->load->view('proveedor/listado_proveedor', $data);
		} else {
			redirect("/inicio");
		}
	}

	function baja($id = 0) {
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		
		$this->Proveedor_model->darBaja($id);
		redirect("/proveedor/listar");
	}
}



