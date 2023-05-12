<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_model extends CI_Model {

//Constructor
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function seleccionarDepartamento() {
		$sql = "SELECT id_departamento, nombre_depto
				FROM 	departamento
				order by id_departamento ASC
				LIMIT 	500";

		$dbres = $this->db->query($sql);
		$rows = $dbres->result_array();
		return $rows;
	}

	function seleccionarMunicipio($id) {
		if (isset($id)) {
			$sql = "SELECT id_municipio, nombre_mun
					FROM 	municipio
					where depto_id_depto = ?
					order by id_municipio DESC
					LIMIT 	500";

			$dbres = $this->db->query($sql, $id);
		}else {
			$sql = "SELECT id_municipio, nombre_mun
					FROM 	municipio
					where id_municipio = 2
					LIMIT 	500";

			$dbres = $this->db->query($sql);
		}

		$rows = $dbres->result_array();
		return $rows;
	}

	function crearCliente($nombre, $apellido, $cui, $direccion, $id_usuario, $nit, $muni_id_muni){
		$sql = "INSERT INTO cliente(nombre, apellido, cui, direccion, estado, id_usuario, nit, muni_id_muni)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		$estado = "A";
		$valores = array($nombre, $apellido, $cui, $direccion, $estado, $id_usuario, $nit, $muni_id_muni);
		$dbres = $this->db->query($sql, $valores);
		
		$sql = "SELECT 	id_cliente as numero
		FROM 	cliente
		WHERE cui = '$cui' ";

		$dbres = $this->db->query($sql);
		$rows = $dbres->result_array();
		return $rows[0]['numero'];
	}

	function telefono($id_cliente, $numero1, $numero2){
		$sql = "INSERT INTO telefono(id_cliente_tel, numero1, numero2)
			VALUES (?, ?, ?)";
		$valores = array($id_cliente, $numero1, $numero2);
		$dbres = $this->db->query($sql, $valores);
		return $dbres;
	}

	function seleccionarCliente(){
		$sql = "SELECT 	f.id_cliente id_cliente, CONCAT(f.nombre,' ',f.apellido) as nombre, f.cui, f.nit, f.direccion direccion, e.id_telefono id_tel, e.numero1 numero1, e.numero2 numero2,a.nombre_mun as muni, b.nombre_depto as depto
				FROM 	cliente f
				JOIN	telefono e on e.id_cliente_tel = f.id_cliente
				JOIN    municipio a on f.muni_id_muni = a.id_municipio
				JOIN    departamento b on a.depto_id_depto = b.id_departamento
				WHERE 	estado = 'A'
				ORDER BY id_cliente DESC
				LIMIT 	5500";
		$dbres = $this->db->query($sql);
		$rows = $dbres->result_array();
		return $rows;
	}
	function seleccionarClientexcel(){
		$sql = "SELECT 	f.id_cliente as id_cliente, CONCAT(f.nombre,' ',f.apellido) as nombre, f.cui, f.direccion direccion, e.numero1 numero1, a.nombre_mun as muni, b.nombre_depto as depto
				FROM 	cliente f
				JOIN	telefono e on e.id_cliente_tel = f.id_cliente 
				JOIN    municipio a on f.muni_id_muni = a.id_municipio
				JOIN    departamento b on a.depto_id_depto = b.id_departamento
				WHERE 	estado = 'A'
				ORDER BY id_cliente DESC
				LIMIT 	500";
		$dbres = $this->db->query($sql);
		$rows = $dbres->result_array();
		return $rows;
	}
///////////////////// para ver a detalle los datos del cliente seleccionado
	function seleccionarClientes($id){
		$sql = "SELECT 	w.id_cliente, CONCAT(w.nombre,' ',w.apellido) as nombre, w.nombre as nombre1, w.apellido as apellido, w.cui, w.direccion, w.estado, x.id_usuario id_usuario, x.nombre nombreu, y.id_telefono id_tel, y.id_cliente_tel id_cliente_tel, y.numero1 numero1, y.numero2 numero2, w.nit as nit, a.nombre_mun as muni, b.nombre_depto as depto
				FROM 	cliente w
				JOIN	usuario x on w.id_usuario = x.id_usuario
				JOIN	telefono y on y.id_cliente_tel = w.id_cliente
				JOIN    municipio a on w.muni_id_muni = a.id_municipio
				JOIN    departamento b on a.depto_id_depto = b.id_departamento
				where  	id_cliente = ?
				LIMIT 	1";
		$dbres = $this->db->query($sql, $id);
		$rows = $dbres->result_array();
		return $rows;
	}

	 function buscarClienteNitRegistrado($nit){
        $sql = "SELECT f.id_cliente, f.codigo, f.nombre, f.cui, e.numero1, e.numero2, f.direccion
                FROM    cliente f
                JOIN    telefono e on e.id_cliente_tel = f.id_cliente 
                WHERE f.nit LIKE '$nit'
        ";

        $dbres = $this->db->query($sql, $nit);
        $rows = $dbres->result_array();
        return $rows;
    }
//actualizar datos del cliente
	function actualizarCliente($id, $nombre, $apellido, $cui, $direccion, $nit, $muni) {
		$sql = "UPDATE cliente
			SET nombre = '$nombre', apellido = '$apellido', cui = '$cui', direccion = '$direccion', nit = '$nit', muni_id_muni = '$muni'
			WHERE id_cliente = '$id' "; 

		$dbres = $this->db->query($sql);
		return $dbres;
	}

	function actualizarTelefono($id, $numero1, $numero2) {
		$sql = "UPDATE telefono
			SET numero1 = '$numero1', numero2 = '$numero2'
			WHERE	id_cliente_tel = '$id'";
		$dbres = $this->db->query($sql, $valores);
		return $dbres;
	}

	//validar cui del cliente
	function numeroCliente(){
		$sql = "SELECT 	MAX(id_cliente) as cui
		FROM 	cliente";

		$dbres = $this->db->query($sql);
		$rows = $dbres->result_array();
		return $rows[0]['cui'];
	}

	function validarCuiCliente($cui){
		$sql ="SELECT cui as numero
			FROM cliente 
			WHERE cui = '$cui'
			LIMIT 1 ";

		$dbres = $this->db->query($sql);
		$rows = $dbres->result_array();
		return $rows;
	}

	function seleccionarCliente1($codigo) {
		$sql = "SELECT 	codigo
				FROM 	cliente
				WHERE 	codigo = ?
				LIMIT 1 ;";

		$dbres = $this->db->query($sql, array($codigo));
		$rows = $dbres->result_array();

		if (count($rows) == 0){
			return 0;
		}else{
			return 1;
		}
	}
//Para validar cliente
	function seleccionarIdCliente($codigo){
		$sql = "SELECT 	id_cliente
				FROM 	cliente
				WHERE 	codigo = ?
				";

		$dbres = $this->db->query($sql, array($codigo));
		$rows = $dbres->result_array();
		return $rows[0]['id_cliente'];
	}

	//seleccionar cliente al momento de generar la factura
	function seleccionarClienteVender() {
		$sql = "SELECT 	id_cliente, nombre, estado
				FROM 	cliente
				WHERE	estado = 'A'
				ORDER BY id_cliente DESC
				LIMIT 	15;";

		$dbres = $this->db->query($sql);
		$rows = $dbres->result_array();
		return $rows;
	}

	function darBaja($id) {
		return $this->db->delete("cliente", array("id_cliente" => $id));
		$dbres = $this->db->query($sql, $valores);
		return $dbres;
	}

	//darbajacliente
	function buscarClienteRegis($id_cliente){
		$sql = "SELECT id_cliente as codigo, CONCAT(nombre,' ',apellido) as cliente, cui, direccion
			FROM 	cliente
                WHERE   id_cliente = ?
                ";

        $dbres = $this->db->query($sql, array($id_cliente));
        $rows = $dbres->result_array();
        return $rows;
	}

	function darBajaCliente($id_cliente){
		is_numeric($id_cliente) or exit("Número esperado!");

		$sql = "UPDATE 	cliente
				SET 	estado = ?
				WHERE 	id_cliente = ?
				LIMIT 	1;";

		$valores = array('B', $id_cliente);
		$dbres = $this->db->query($sql, $valores);
		return $dbres;
	}
	///////////SECCION PARA BUSCAR DATOS DEL CLIENTE REGISTRADO EN EL SISTEMA
	function buscar_data_cliente($cui){
		$sql = "
		SELECT id_cliente, nombre, apellido, cui
		FROM cliente 
		WHERE estado = 'A' AND cui LIKE '%".$cui."%' OR nombre LIKE '%".$cui."%' OR apellido LIKE '%".$cui."%'
		";

		$dbres = $this->db->query($sql, array($cui));
	        $rows = $dbres->result_array();
	        return $rows;
	}
	//traer datos del cliente seleccionado
	function data_cliente_id($id_cliente){
		$sql = "
		SELECT id_cliente, CONCAT(nombre,' ', apellido) as nombre
		FROM cliente 
		WHERE id_cliente = '$id_cliente'
		LIMIT 1
		";

		$dbres = $this->db->query($sql, array($id_cliente));
	        $rows = $dbres->result_array();
	        return $rows;
	}
}