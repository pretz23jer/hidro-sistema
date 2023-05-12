<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require FCPATH.'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Usuario extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('Usuario_model');
	}

	private function restringirAcceso() {
		if (!isset($this->session->USUARIO)) {
			redirect("usuario");
		}
	}

	function index() {
		$data['base_url'] = $this->config->item('base_url');
		if (isset($this->session->USUARIO)) {
			redirect('/inicio'); // /controller/method
		}

		if ($this->input->post('login') == 'Ingresar') {
			$usuario = $this->input->post('usuario');
			$clave = $this->input->post('clave');
			$id = $this->Usuario_model->autenticarUsuario($usuario, $clave);
			if ($id > 0) {
				//Establecer variables de sesion
				$this->session->USUARIO = $usuario;
				$this->session->IDUSUARIO = $id[0]['id_usuario'];
				$this->session->ROL = $id[0]['rol'];
				$this->session->NOMBRE = $id[0]['nombre'];
				$this->session->LUGAR = $id[0]['lugar_id_lugar'];
				redirect("/inicio/bienvenido");
			} else {
				$data["mensaje"] = "Usuario o clave incorrectos!";
			}
		}
		$this->load->view('usuario/login', $data);
	}

	public function logout() {
		$this->session->sess_destroy(); // Destruir todas las variables de sesión
		redirect("/inicio");
	}

	//crear usuario
	function crear() {
	$this->restringirAcceso();
	if ($this->session->ROL == 'Admin') {
		$data['base_url'] = $this->config->item('base_url');

		$data['nombre'] = "";
		$data['apellido'] = "";
		$data['telefono'] = "";
		$data['correo'] = "";
		$data['rol'] = "";
		$data['clave'] = "";
		$data['clave2'] = "";
		$data['mensaje'] = "";


		if (isset($_POST['guardar'])) {
			$data['nombre'] = str_replace(["<",">"], "", $_POST['nombre']);
			$data['apellido'] = str_replace(["<",">"], "", $_POST['apellido']);
			$data['telefono'] = preg_replace("/[[:space:]]/","",trim($_POST['telefono']));
			$data['correo'] = str_replace(["<",">"], "", $_POST['usuario']);
			$data['rol'] = str_replace(["<",">"], "", $_POST['rol']);
			$data['clave'] = $_POST['clave'];
			$data['clave2'] = $_POST['clave2'];

		if ($data['clave'] != $data['clave2']) {
				$data['mensaje'] = "Las contraseñas no coinciden.";
			} else if (strlen($data['clave']) < 8) {
				$data['mensaje'] = "La contraseña debe tener al menos 8 caracteres.";
			} else {
				//Todos los datos son correctos, guardar en la BD.
				$this->Usuario_model->crearUsuarioHidro($data['nombre'], $data['apellido'], $data['correo'], $data['telefono'], $data['clave'], $data['rol']);
				redirect("/usuario/listar");
			}
		}

		$this->load->view('usuario/regis_user', $data);
		} else {
			redirect("/inicio");
		}
	}

	function listar(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		if ($this->session->ROL == 'Admin') {
		$data['arr'] = $this->Usuario_model->seleccionarUsuarios();
		$this->load->view('usuario/listado_usuarios', $data);
		} else {
			redirect("/inicio");
		}
	}

	public function baja($id = 0) {
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		if ($this->session->ROL == 'Admin') {
		$this->Usuario_model->darBaja($id);
			redirect("/usuario/listar");
		} else {
			redirect("/inicio");
		}
	}

	public function editaruser($id = 0){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');

		$data['arr'] = $this->Usuario_model->seleccionarUsuarioEditar($id);

		$data['nombre'] = "";
		$data['apellido'] = "";
		$data['telefono'] = "";
		$data['usuario'] = "";
		$data['rol'] = "";
		$id_usuario = "";
		$data['id_usuario'] = "";

		if (isset($_POST['actualizar'])) {
			$data['nombre'] = str_replace(["<",">"], "", $_POST['nombre']);
			$data['apellido'] = str_replace(["<",">"], "", $_POST['apellido']);
			$data['telefono'] = preg_replace("/[[:space:]]/","",trim($_POST['telefono']));
			$data['usuario'] = str_replace(["<",">"], "", $_POST['usuario']);
			$data['rol'] = str_replace(["<",">"], "", $_POST['rol']);
			$id_usuario= $_POST['id_usuario'];

			$data['arr'] = $this->Usuario_model->seleccionarUserActuali($id_usuario, $data['nombre'], $data['apellido'], $data['telefono'], $data['usuario'], $data['rol']);

			redirect("/usuario/datos_actualizados/$id_usuario");
		}
		$this->load->view('usuario/editar_user', $data);
	}

	public function datos_actualizados($id_usuario){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');

		$data['arr'] = $this->Usuario_model->mostrar_actualizacion($id_usuario);
		$persona = $this->Usuario_model->mostrar_actualizacionPersona($id_usuario);
		$data['mensaje'] = "<script>Swal.fire(
							  'Datos Actulizados Exitosamente!',
							  '$persona',
							  'success'
							)</script>";

		$this->load->view('usuario/listado_usuarioEditado', $data);
	}

//generar excel
		function excel_archivo(){
			$this->restringirAcceso();
			$data['usuario'] = $this->Usuario_model->listarUsuarios();

			$excel = new Spreadsheet();
			$hojaActiva = $excel->getActiveSheet();
			$hojaActiva->setTitle("Usuarios");

			$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		    $drawing->setName('Paid');
		    $drawing->setDescription('Paid');
		    $drawing->setPath('./recursos/img/icon.png'); /* put your path and image here */
		    $drawing->setCoordinates('F1');
		    $drawing->setHeight(40);
		    $drawing->setOffsetX(80);
		    $drawing->setRotation(0);
		    $drawing->setWorksheet($excel->getActiveSheet());

			$styleArray = [
			    'font' => [
			        'bold' => true,
			    ],
			    'alignment' => [
			        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
			    ],
			];

			$styleArrayA = [
			    'font' => [
			        'bold' => true,
			    ],
			    'alignment' => [
			        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
			    ],
			    'borders' => [
			        'top' => [
			            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			        ],
			    ],
			];

			$styleArrayB = [
			    'borders' => [
			        'top' => [
			            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			        ],
			    ],
			    'alignment' => [
			        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
			    ],
			];

			$excel->getActiveSheet()->getStyle('A5')->applyFromArray($styleArrayA);
			$excel->getActiveSheet()->getStyle('B5')->applyFromArray($styleArrayA);
			$excel->getActiveSheet()->getStyle('C5')->applyFromArray($styleArrayA);
			$excel->getActiveSheet()->getStyle('D5')->applyFromArray($styleArrayA);
			$excel->getActiveSheet()->getStyle('E5')->applyFromArray($styleArrayA);
			$excel->getActiveSheet()->getStyle('F5')->applyFromArray($styleArrayA);
			$excel->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
			$excel->getActiveSheet()->getStyle('B2')->applyFromArray($styleArray);
			$excel->getActiveSheet()->getStyle('C3')->applyFromArray($styleArray);

			$hojaActiva->setCellValue('A5', 'NO.');
			$hojaActiva->getColumnDimension('B')->setWidth(25);
			$hojaActiva->setCellValue('B5', 'NOMBRE');
			$hojaActiva->getColumnDimension('C')->setWidth(25);
			$hojaActiva->setCellValue('C5', 'APELLIDO');
			$hojaActiva->getColumnDimension('D')->setWidth(18);
			$hojaActiva->setCellValue('D5', 'TELÉFONO');
			$hojaActiva->getColumnDimension('E')->setWidth(30);
			$hojaActiva->setCellValue('E5', 'CORREO');
			$hojaActiva->getColumnDimension('F')->setWidth(15);
			$hojaActiva->setCellValue('F5', 'ROL');

			$hojaActiva->setCellValue('A1', 'HIDROCOMPRAS');
			$hojaActiva->setCellValue('A2', 'En un solo click');
			$hojaActiva->setCellValue('C3', 'LISTADO DE USUARIOS DEL SISTEMA HIDROCOMPRAS');
			$fila = 6;

			foreach ($data['usuario'] as $rows) {
				$excel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('0000 0000');
				$excel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($styleArrayB);
				$excel->getActiveSheet()->getStyle('B'.$fila)->applyFromArray($styleArrayB);
				$excel->getActiveSheet()->getStyle('C'.$fila)->applyFromArray($styleArrayB);
				$excel->getActiveSheet()->getStyle('D'.$fila)->applyFromArray($styleArrayB);
				$excel->getActiveSheet()->getStyle('E'.$fila)->applyFromArray($styleArrayB);
				$excel->getActiveSheet()->getStyle('F'.$fila)->applyFromArray($styleArrayB);

				$hojaActiva->setCellValue('A'.$fila, $rows['id_usuario']);
				$hojaActiva->setCellValue('B'.$fila, $rows['nombre']);
				$hojaActiva->setCellValue('C'.$fila, $rows['apellido']);
				$hojaActiva->setCellValue('D'.$fila, $rows['numero']);
				$hojaActiva->setCellValue('E'.$fila, $rows['usuario']);
				$hojaActiva->setCellValue('F'.$fila, $rows['rol']);
				$fila++;
			}

			$excel->getDefaultStyle()
				->getFont()
				->setName('Arial')
				->setSize(11);

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="us_hidro.xlsx"');
			header('Cache-Control: max-age=0');

			$writer = new  Xlsx($excel);
			$writer->save('php://output');
		}
	//Funcion para cambiar contrseña
	function restaurar_datos($id = 0){ 
	$this->restringirAcceso();
	$data['base_url'] = $this->config->item('base_url');
	if ($this->session->ROL == 'Admin') {
	$data['arr'] = $this->Usuario_model->seleccionarUsuario($id);

		if (isset($_POST['Enviar'])) {
				$clave1 = $_POST['clave1'];
				$clave2 = $_POST['clave2'];
				$id = $_POST['id'];

				$this->Usuario_model->actualizarPassword($clave1, $id);
				redirect('/usuario/listar');
			}

		$this->load->view('usuario/recuperarDatos', $data);
			} else {
		redirect("/inicio");
		}
	}

}
