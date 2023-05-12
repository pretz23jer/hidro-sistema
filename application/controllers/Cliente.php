<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require FCPATH.'vendor/autoload.php';
use Dompdf\Dompdf;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Cliente extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('Cliente_model');
	}

	private function restringirAcceso() {
		if (!isset($this->session->USUARIO)) {
			redirect("/Inicio");
		}
	}

	public function index(){
	$this->restringirAcceso();
	$data['base_url'] = $this->config->item('base_url');
	
		$data['boton'] = "";
		$data['cui'] = "";
		$data['nombre'] = "";
		$data['apellido'] = "";
		$data['nit'] = "c/f";
		$data['numero1'] = "";
		$data['numero2'] = "0";
		$data['direccion'] = "";
		$data['departamento'] = "";
		$data['muni'] = "";
		$data['id_usuario'] = $this->session->IDUSUARIO;
		$data['boton'] = "<button type='submit' class='btn btn-sm btn-light btnventa' name='guardar'><i class='fa fa-save'></i> Guardar</button>";
		$data['mensaje'] = "";
		$data['mensaje_res'] = "";
		$data['mensaje_err'] = "";
		$verifivar_cui = "";
		$regis = "";

		if (isset($_POST['guardar'])) {
			$cui = $this->Cliente_model->numeroCliente();
			$year = date("Y");
			$secuen = $year.$cui;

			if ($_POST['cui'] == 0) {
				$data['cui'] = $secuen;
			} else  if(strlen($_POST['cui']) < 6){
				$data['cui'] = $secuen;
			} else {
				$data['cui'] = preg_replace("/[[:space:]]/","",trim($_POST['cui']));
			}

			$data['nombre'] = str_replace(["<",">"], "", $_POST['nombre']);
			$data['apellido'] = str_replace(["<",">"], "", $_POST['apellido']);
			$data['nit'] = str_replace(["<",">"], "", $_POST['nit']);
			$data['numero1'] = preg_replace("/[[:space:]]/","",trim($_POST['numero1']));
			$data['numero2'] = preg_replace("/[[:space:]]/","",trim($_POST['numero2']));
			$data['direccion'] = str_replace(["<",">"], "", $_POST['direccion']);
			$data['muni'] = str_replace(["<",">"], "", $_POST['muni']);
			
			$data['verifivar_cui'] = $this->Cliente_model->validarCuiCliente($data['cui']);
			foreach ($data['verifivar_cui'] as $key) {
				$verifivar_cui = $key['numero'];
			}

			if ($verifivar_cui == $data['cui']) {
				$data['mensaje'] = "<script>
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					html: 'El CUI <strong>'+'${data['cui']}'+'</strong> que está registrando ya existe,<br> ingrese otro CUI'
					})
					</script>";
				}else{
					$cui_reg = $this->Cliente_model->crearCliente($data['nombre'], $data['apellido'], $data['cui'], $data['direccion'], $data['id_usuario'], $data['nit'], $data['muni']);
					$regis = $this->Cliente_model->telefono($cui_reg, $data['numero1'], $data['numero2']);
				}
				if ($regis == true) {
					$data['mensaje_res']  = "<script>
					Swal.fire({
						icon: 'success',
						title: 'Se a registrado con éxito a:',
						html: '<strong> ${data['nombre']}'+' '+'${data['apellido']} </strong>'
						})
						</script>";
						$data['boton'] = "<a class=\"btn btn-success\" href=\"cliente\" role=\"button\">Registrar a otro cliente</a>";
					} else{
						$data['mensaje_err'] = "<script>
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							html: 'El CUI <strong>'+'${data['cui']}'+'</strong> que está registrando ya existe,<br>ingrese otro CUI'
							})
							</script>";
						}
			}
		$this->load->view('cliente/regis_cliente', $data); 
	}

	public function departamento($id = 0) {
		//$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');

		$data['departamento'] =  $this->Cliente_model->seleccionarDepartamento(); //Selelcciona el departemanto
		echo '<option selected disabled value="">Seleccionar depto</option>';
		foreach ($data['departamento'] as $key) {
		if ($id == $key['id_departamento']) {
			echo '<option selected value="'.$key['id_departamento'].'">'.$key['nombre_depto'].'</option>'."\n";
			}else {
				echo '<option value="'.$key['id_departamento'].'">'.$key['nombre_depto'].'</option>'."\n";
			}
		}
	}

	public function municipio($id = 0) {
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');

		$id_depto = $_POST['departamento'];
		$data['municipio'] =  $this->Cliente_model->seleccionarMunicipio($id_depto); //Selelcciona el municipio
		echo '<option selected disabled value="">Seleccionar municipio</option>';
		foreach ($data['municipio'] as $key) {
			echo '<option selected value="'.$key['id_municipio'].'">'.$key['nombre_mun'].'</option>'."\n";
		}
	}

	function editar($id = 0) {
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		if ($id == 0) {
		redirect("/cliente/listar");	
		}else{
		$data['arr'] = $this->Cliente_model->seleccionarClientes($id);
		
		$data['codigo'] = "";
		$data['nombre'] = "";
		$data['apellido'] = "";
		$data['cui'] = "";
		$data['direccion'] = "";
		$data['nit'] = "";
		$data['numero1'] = "";
		$data['numero2'] = "";
		$id_cliente = "";

		if (isset($_POST['actualizar'])) {
			$data['codigo'] = $_POST['codigo'];
			$data['nombre'] = str_replace(["<",">"], "", $_POST['nombre']); 
			$data['apellido'] = str_replace(["<",">"], "", $_POST['apellido']); 
			$data['cui'] = preg_replace("/[[:space:]]/","",trim($_POST['cui']));
			$data['direccion'] = str_replace(["<",">"], "", $_POST['direccion']);
			$data['muni'] = str_replace(["<",">"], "", $_POST['muni']);
			$data['nit'] = str_replace(["<",">"], "", $_POST['nit']);
			$data['numero1'] = preg_replace("/[[:space:]]/","",trim($_POST['numero1']));
			$data['numero2'] = preg_replace("/[[:space:]]/","",trim($_POST['numero2']));
			$data['id_cliente'] = $_POST['id_clientito'];

			$this->Cliente_model->actualizarCliente($data['id_cliente'], $data['nombre'], $data['apellido'], $data['cui'], $data['direccion'], $data['nit'], $data['muni']);
			$res = $this->Cliente_model->actualizarTelefono($data['id_cliente'], $data['numero1'], $data['numero2']);

			redirect("/cliente/listar");
		}
		$this->load->view('cliente/editar_cliente', $data);
		}
	}

	function listar(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		$data['arr'] = $this->Cliente_model->seleccionarCliente();
		$this->load->view('cliente/listado_cliente', $data);

	}

	function det($id = 0){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		$data['arr'] = $this->Cliente_model->seleccionarClientes($id);
		$this->load->view('cliente/detalle_cli', $data);
	}
	//descargar información del cliente
	function edescargarCliente($id = 0){
		$this->restringirAcceso();
		$data['arr'] = $this->Cliente_model->seleccionarClientes($id);
		$this->load->view('descarDetalle_cli', $data);
	}

	function descargarcliente($id = 0){
		$this->restringirAcceso();
		$data['arr'] = $this->Cliente_model->seleccionarClientes($id);
		
		$excel = new Spreadsheet();
			$hojaActiva = $excel->getActiveSheet();
			$hojaActiva->setTitle("Cliente");

			$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		    $drawing->setName('Paid');
		    $drawing->setDescription('Paid');
		    $drawing->setPath('./recursos/img/hidro.png'); /* put your path and image here */
		    $drawing->setCoordinates('F1');
		    $drawing->setHeight(80);
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
			$excel->getActiveSheet()->getStyle('G5')->applyFromArray($styleArrayA);
			$excel->getActiveSheet()->getStyle('H5')->applyFromArray($styleArrayA);
			$excel->getActiveSheet()->getStyle('I5')->applyFromArray($styleArrayA);
			$excel->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
			$excel->getActiveSheet()->getStyle('B2')->applyFromArray($styleArray);
			$excel->getActiveSheet()->getStyle('C3')->applyFromArray($styleArray);

			$hojaActiva->setCellValue('A5', 'NO.');
			$hojaActiva->getColumnDimension('B')->setWidth(15);
			$hojaActiva->setCellValue('B5', 'NOMBRE');
			$hojaActiva->getColumnDimension('C')->setWidth(15);
			$hojaActiva->setCellValue('C5', 'APELLIDO');
			$hojaActiva->getColumnDimension('D')->setWidth(18);
			$hojaActiva->setCellValue('D5', 'CUI');
			$hojaActiva->getColumnDimension('E')->setWidth(30);
			$hojaActiva->setCellValue('E5', 'DIRECCIÓN');
			$hojaActiva->getColumnDimension('F')->setWidth(10);
			$hojaActiva->setCellValue('F5', 'TELÉFONO');
			$hojaActiva->getColumnDimension('G')->setWidth(10);
			$hojaActiva->setCellValue('G5', 'TELÉFONO 2');
			$hojaActiva->getColumnDimension('H')->setWidth(15);
			$hojaActiva->setCellValue('H5', 'MUNICIPIO');
			$hojaActiva->getColumnDimension('I')->setWidth(20);
			$hojaActiva->setCellValue('I5', 'DEPARTAMENTO');

			$hojaActiva->setCellValue('A1', 'HIDROCOMPRAS');
			$hojaActiva->setCellValue('A2', 'A un solo click de distancia');
			$hojaActiva->setCellValue('C3', 'DATOS DETALLADOS DEL CLIENTE');
			$fila = 6;

			foreach ($data['arr'] as $rows) {
				$excel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('0000 00000 0000');
				$excel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('0000 0000');
				$excel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('0000 0000');
				$excel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($styleArrayB);
				$excel->getActiveSheet()->getStyle('B'.$fila)->applyFromArray($styleArrayB);
				$excel->getActiveSheet()->getStyle('C'.$fila)->applyFromArray($styleArrayB);
				$excel->getActiveSheet()->getStyle('D'.$fila)->applyFromArray($styleArrayB);
				$excel->getActiveSheet()->getStyle('E'.$fila)->applyFromArray($styleArrayB);
				$excel->getActiveSheet()->getStyle('F'.$fila)->applyFromArray($styleArrayB);
				$excel->getActiveSheet()->getStyle('G'.$fila)->applyFromArray($styleArrayB);
				$excel->getActiveSheet()->getStyle('H'.$fila)->applyFromArray($styleArrayB);
				$excel->getActiveSheet()->getStyle('I'.$fila)->applyFromArray($styleArrayB);

				$hojaActiva->setCellValue('A'.$fila, $rows['id_cliente']);
				$hojaActiva->setCellValue('B'.$fila, $rows['nombre1']);
				$hojaActiva->setCellValue('C'.$fila, $rows['apellido']);
				$hojaActiva->setCellValue('D'.$fila, $rows['cui']);
				$hojaActiva->setCellValue('E'.$fila, $rows['direccion']);
				$hojaActiva->setCellValue('F'.$fila, $rows['numero1']);
				$hojaActiva->setCellValue('G'.$fila, $rows['numero2']);
				$hojaActiva->setCellValue('H'.$fila, $rows['muni']);
				$hojaActiva->setCellValue('I'.$fila, $rows['depto']);
				$fila++;
				$apellido = $rows['apellido'];
			}

			$excel->getDefaultStyle()
				->getFont()
				->setName('Arial')
				->setSize(11);

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="Cliente '.$apellido.'.xlsx"');
			header('Cache-Control: max-age=0');

			$writer = new  Xlsx($excel);
			$writer->save('php://output');
	}

//descargar listado de clientes
	function DescargarLista(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		$data['arr'] = $this->Cliente_model->seleccionarCliente();

		$hoy = date("dmy");
		$dompdf = new Dompdf();
		$html = $this->load->view('cliente/listado_clienteDescargar', $data, true);
		$dompdf->loadHtml($html);
		$dompdf->setPaper('letter', 'portrait');
		$dompdf->render();
		$dompdf->stream("Hidro"."_clientes_".$hoy.".pdf", array("Attachment" => 0));

	}
	function descargarlistaxls(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		$data['arr'] = $this->Cliente_model->seleccionarClientexcel();
		$excel = new Spreadsheet();
			$hojaActiva = $excel->getActiveSheet();
			$hojaActiva->setTitle("Clientes");

			$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		    $drawing->setName('Paid');
		    $drawing->setDescription('Paid');
		    $drawing->setPath('./recursos/img/hidro.png'); /* put your path and image here */
		    $drawing->setCoordinates('F1');
		    $drawing->setHeight(80);
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
			$excel->getActiveSheet()->getStyle('G5')->applyFromArray($styleArrayA);

			$hojaActiva->setCellValue('A5', 'NO.');
			$hojaActiva->getColumnDimension('B')->setWidth(40);
			$hojaActiva->setCellValue('B5', 'NOMBRE');
			$hojaActiva->getColumnDimension('C')->setWidth(15);
			$hojaActiva->setCellValue('C5', 'CUI');
			$hojaActiva->getColumnDimension('D')->setWidth(40);
			$hojaActiva->setCellValue('D5', 'DIRECCIÓN');
			$hojaActiva->getColumnDimension('E')->setWidth(25);
			$hojaActiva->setCellValue('E5', 'MUNICIPIO');
			$hojaActiva->getColumnDimension('F')->setWidth(15);
			$hojaActiva->setCellValue('F5', 'DEPARTAMENTO');
			$hojaActiva->getColumnDimension('G')->setWidth(15);
			$hojaActiva->setCellValue('G5', 'TELÉFONO');

			$hojaActiva->setCellValue('A1', 'HIDROCOMPRAS');
			$hojaActiva->setCellValue('A2', 'Tu mejor opción');
			$hojaActiva->setCellValue('C3', 'LISTADO DE CLIENTES');
			$fila = 6;

			foreach ($data['arr'] as $rows) {
				$excel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('0000 00000 0000');
				$excel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('0000 0000');
				$excel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($styleArrayB);
				$excel->getActiveSheet()->getStyle('B'.$fila)->applyFromArray($styleArrayB);
				$excel->getActiveSheet()->getStyle('C'.$fila)->applyFromArray($styleArrayB);
				$excel->getActiveSheet()->getStyle('D'.$fila)->applyFromArray($styleArrayB);
				$excel->getActiveSheet()->getStyle('E'.$fila)->applyFromArray($styleArrayB);
				$excel->getActiveSheet()->getStyle('F'.$fila)->applyFromArray($styleArrayB);
				$excel->getActiveSheet()->getStyle('G'.$fila)->applyFromArray($styleArrayB);

				$hojaActiva->setCellValue('A'.$fila, $rows['id_cliente']);
				$hojaActiva->setCellValue('B'.$fila, $rows['nombre']);
				$hojaActiva->setCellValue('C'.$fila, $rows['cui']);
				$hojaActiva->setCellValue('D'.$fila, $rows['direccion']);
				$hojaActiva->setCellValue('E'.$fila, $rows['muni']);
				$hojaActiva->setCellValue('F'.$fila, $rows['depto']);
				$hojaActiva->setCellValue('G'.$fila, $rows['numero1']);
				$fila++;
			}

			$excel->getDefaultStyle()
				->getFont()
				->setName('Arial')
				->setSize(11);

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="listado de clientes.xlsx"');
			header('Cache-Control: max-age=0');

			$writer = new  Xlsx($excel);
			$writer->save('php://output');
	}

	//dar baja al cliente, mas no eliminar
	public function baja($id = 0) {
		$this->restringirAcceso();
		
		$data['base_url'] = $this->config->item('base_url');

		$this->Cliente_model->darBaja($id);

		redirect("/Cliente/listar");
	}

	//buscar y dar baja al cliente
	function buscarRegistro(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');

		if(!empty($_POST['id_cliente'])){
        $data['id_cliente'] = $_POST['id_cliente'];
        $arr = $this->Cliente_model->buscarClienteRegis($data['id_cliente']);

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

	function darBajaCli(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');

		if($_POST['action'] == 'eliminarRegi'){
	 		if(!empty($_POST['id_c'])){
	        $data['id_cliente'] = $_POST['id_c'];
	        $arr = $this->Cliente_model->darBajaCliente($data['id_cliente']);
	   		}
	   	}
	}
////////////seccion de ventas de productos
	function buscar_d(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		$data['cui'] = "";
		$data['cui'] = $_POST['cliente'];
		$data['arr'] = $this->Cliente_model->buscar_data_cliente($data['cui']);
		$tabla = '';
		if (count($data['arr']) < 1) {
		  $tabla = "No se ha encontrado ninguna conciencia en la búsqueda.";
		}else{
		$tabla.=
		"<table class='table'>
			<tr class='bg-primary' style='color:#fff;'>
				<td class='text-center'><i class='fa-solid fa-circle-check'></i></td>
				<td class='text-center'>Nombre</td>
				<td class='text-center'>Apellido</td>
				<td class='text-center'>CUI</td>
			</tr>";
		foreach ($data['arr'] as $a) {
			$tabla.="
			<tr>
				<td class='text-center'><button type='button' class='btn btn-success btn-sm' id='cliente_encontrado' onclick='bloque(".$a['id_cliente'].");' value='".$a['id_cliente']."'><i class='fa-solid fa-user-plus'></i></button></td>
				<td class='text-center'>".$a['nombre']."</td>
				<td class='text-center'>".$a['apellido']."</td>
				<td class='text-center'>".$a['cui']."</td>
			</tr>
			";
		}
		$tabla.="</table>";
	}
		echo $tabla;
	}

	function traercliente_seleccionado(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');
		$data['id_cliente'] = $_POST['id_cliente'];
		$data = $this->Cliente_model->data_cliente_id($data['id_cliente']);
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
	}

	function registrar_cliente_d_p(){
		$this->restringirAcceso();
		$data['base_url'] = $this->config->item('base_url');

		$data['id_usuario'] = $this->session->IDUSUARIO;
		$data['mensaje'] = "";
		$data['mensaje_res'] = "";
		$data['mensaje_err'] = "";
		$verifivar_cui = "";
		$cui_reg = "";
		$regis = "";

		if(($_POST['action'] == 'crear_cliente_lugar')){
			$cui = $this->Cliente_model->numeroCliente();
			$year = date("Y");
			$secuen = $year.$cui;

			if ($_POST['cui'] == 0) {
				$data['cui'] = $secuen;
			} else  if(strlen($_POST['cui']) < 6){
				$data['cui'] = $secuen;
			} else {
				$data['cui'] = preg_replace("/[[:space:]]/","",trim($_POST['cui']));
			}

			$data['nombre'] = str_replace(["<",">"], "", $_POST['nombre']);
			$data['apellido'] = str_replace(["<",">"], "", $_POST['apellido']);
			$data['nit'] = str_replace(["<",">"], "", $_POST['nit']);
			$data['numero1'] = preg_replace("/[[:space:]]/","",trim($_POST['numero1']));
			$data['numero2'] = preg_replace("/[[:space:]]/","",trim($_POST['numero2']));
			$data['direccion'] = str_replace(["<",">"], "", $_POST['direccion']);
			$data['muni'] = str_replace(["<",">"], "", $_POST['muni']);
			
			$data['verifivar_cui'] = $this->Cliente_model->validarCuiCliente($data['cui']);
			foreach ($data['verifivar_cui'] as $key) {
				$verifivar_cui = $key['numero'];
			}

			if ($verifivar_cui == $data['cui']) {
				$data['mensaje'] = "<script>
								  Swal.fire({
								    icon: 'error',
								    title: 'Oops...',
								    html: 'El CUI <strong>'+'${data['cui']}'+'</strong> que está registrando ya existe,<br> ingrese otro CUI'
								  })
								</script>";
			}else{
				$cui_reg = $this->Cliente_model->crearCliente($data['nombre'], $data['apellido'], $data['cui'], $data['direccion'], $data['id_usuario'], $data['nit'], $data['muni']);
				$regis = $this->Cliente_model->telefono($cui_reg, $data['numero1'], $data['numero2']);
				echo $cui_reg;
			}
		} else {
			echo "error";
		}
	}

}



