<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proveedor_model extends CI_Model {

//Constructor
	function __construct(){
		parent::__construct();
		$this->load->database();
	}


	function crearProveedor($nombre, $direccion, $telefono, $tipo, $id_usuario){
		$sql = "INSERT INTO proveedor(nombre, direccion, telefono, tipo, estado, id_usuario)
				VALUES (?, ?, ?, ?, ?, ?)";
		$estado = "Activo";

		$valores = array($nombre, $direccion, $telefono, $tipo, $estado, $id_usuario);

		$dbres = $this->db->query($sql, $valores);

		return $dbres;
	}

	function seleccionarProveedor() {
		$sql = "SELECT 	id_proveedor, nombre, direccion, telefono, tipo
				FROM 	proveedor 
				WHERE 	estado = 'Activo'
				ORDER BY id_proveedor ASC
				LIMIT 	100";

		$dbres = $this->db->query($sql);
		$rows = $dbres->result_array();
		return $rows;
	}

	function seleccionarCodExistente($CUI) {
		$sql = "SELECT 	cui
						FROM 	empleado
						WHERE 	cui = ?
						LIMIT 1 ;";

		$dbres = $this->db->query($sql, array($CUI));

		$rows = $dbres->result_array();
		return $rows;
	}

	function validarcodigo($Usuario, $cui) {
	$sql = "SELECT usuario, CUI
			FROM 	empleado
			WHERE 	usuario = ? or CUI = ?
			LIMIT 	1;";

	$dbres = $this->db->query($sql, array($Usuario, $cui));
	$rows = $dbres->result_array();

	return $rows;
	}

	function darBaja($id_proveedor) {
		is_numeric($id_proveedor) or exit("Número esperado!");

		$sql = "UPDATE 	proveedor
				SET 	estado = ?
				WHERE 	id_proveedor = ?
				LIMIT 	1;";

		$valores = array('Baja', $id_proveedor);

		$dbres = $this->db->query($sql, $valores);

		return $dbres;
	}

	function seleccionarProveedorEditar($id){
		$sql = "SELECT id_proveedor, nombre, direccion, telefono, tipo
				FROM proveedor
				where id_proveedor = ?
				LIMIT 	1";
		
		$dbres = $this->db->query($sql,array($id));

		$rows = $dbres->result_array();
		return $rows;
	}

	function actualizar_proveedor($id, $nombre, $direccion, $telefono, $tipo) {
		$sql = "UPDATE proveedor
				SET Nombre = '$nombre', Direccion = '$direccion', Telefono = '$telefono', Tipo = '$tipo'
				WHERE id_proveedor = '$id' "; 

		$dbres = $this->db->query($sql);
		return $dbres;
	}
}