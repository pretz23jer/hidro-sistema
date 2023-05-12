<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario_model extends CI_Model {

//Constructor
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

function crearUsuarioHidro($nombre, $apellido, $correo, $telefono, $clave, $rol) {
		$sql = "INSERT INTO usuario(nombre, apellido, correo, telefono, hash_clave, salt, estado, rol)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

		$salt = rand(0,999999); //calcular un número aleatorio
		$hash_clave = hash('sha256', $clave.$salt); //calcular el hash de clave + salt
		$estado = "A";

		$valores = array($nombre, $apellido, $correo, $telefono, $hash_clave, $salt, $estado, $rol);
		$dbres = $this->db->query($sql, $valores);
		return $dbres;
	}

function autenticarUsuario($txtusuario, $txtClave) {
		$sql = "SELECT 	id_usuario, nombre, correo, hash_clave, salt, rol
				FROM 	usuario
				WHERE 	correo = ? AND estado = 'A'
				LIMIT 	1;";

		$dbres = $this->db->query($sql, array($txtusuario));
		$rows = $dbres->result_array();

		if (count($rows) < 1) // El usuario no existe o no está activo
			return 0;

		$id = $rows[0]['id_usuario'];
		$salt = $rows[0]['salt'];
		$hashClave = hash('sha256', $txtClave.$salt); // Calcular sha512 de clave + salt

		$sql = "SELECT 	id_usuario, nombre, correo, rol
		FROM 	usuario
		WHERE 	id_usuario = ? AND hash_clave = ?
		LIMIT 	1;";

		$dbres = $this->db->query($sql, array($id, $hashClave));
		$rows = $dbres->result_array();

		if (count($rows) > 0) {
			return $rows; // El usuario existe y cumple con la clave
		}

		return 0; // El usuario existe pero no cumple la clave
	}
//listar usuario registrados en el sistema
	function seleccionarUsuarios() {
		$sql = "SELECT 	id_usuario, CONCAT(nombre,' ',apellido) as nombre, correo as usuario,telefono, estado, rol
				FROM 	usuario 
				WHERE 	id_usuario > 1 AND estado = 'A'
				ORDER BY id_usuario ASC
				LIMIT 	100";

		$dbres = $this->db->query($sql);
		$rows = $dbres->result_array();
		return $rows;
	}

	function seleccionarUsuarioNombre($nombre) {
		$sql = "SELECT 	id_usuario, nombre, cui, direccion, telefono, usuario, hash_clave, salt, estado
				FROM 	usuario
				WHERE 	nombre = ?
				LIMIT 	1";

		$dbres = $this->db->query($sql, array($nombre));
		$rows = $dbres->result_array();
		return $rows;
	}

	function darBaja($id_usuario) {
		$sql = "UPDATE 	usuario
				SET 	estado = 'B'
				WHERE 	id_usuario = '$id_usuario'	";

		$dbres = $this->db->query($sql);
		return $dbres;
	}

	function seleccionarUsuarioEditar($id){
		$sql = "SELECT a.id_usuario, a.nombre, a.apellido, a.telefono, a.correo as usuario, a.estado, a.rol
				FROM 	usuario a
				where a.id_usuario = '$id'
				LIMIT 	1";
		$dbres = $this->db->query($sql,array($id));
		$rows = $dbres->result_array();
		return $rows;
	}

	function seleccionarUserActuali($id_usuario, $nombre, $apellido, $telefono, $usuario, $rol){
		$sql = "UPDATE usuario
				SET nombre = '$nombre', apellido = '$apellido', telefono='$telefono', correo = '$usuario', rol = '$rol'
				WHERE id_usuario = '$id_usuario' ";

		$dbres = $this->db->query($sql);
		return $dbres;
	}

	function mostrar_actualizacion($id_usuario){
		$sql = "SELECT id_usuario, CONCAT(nombre, ' ', apellido) as nombre,  telefono, correo as usuario, rol
				FROM 	usuario
				WHERE id_usuario = '$id_usuario'
				LIMIT 	1";

			$dbres = $this->db->query($sql, array($id_usuario));
			$rows = $dbres->result_array();
			return $rows;
	}

	function mostrar_actualizacionPersona($id_usuario){
		$sql = "SELECT CONCAT(nombre,' ',apellido) as nombre
				FROM 	usuario
				WHERE id_usuario = $id_usuario
				LIMIT 	1";

			$dbres = $this->db->query($sql, array($id_usuario));
			$rows = $dbres->result_array();
			return $rows[0]['nombre'];
	}

	function listarUsuarios(){
		$sql = "SELECT 	id_usuario, nombre, apellido,  telefono as numero, correo as usuario, rol
				FROM 	usuario 
				WHERE 	id_usuario > 2 AND estado = 'A'
				ORDER BY id_usuario ASC
				LIMIT 	100";

		$dbres = $this->db->query($sql);
		$rows = $dbres->result_array();
		return $rows;
	}

	//cambiar la contraseña
	function seleccionarUsuario($id){
		$sql = "SELECT id_usuario
						FROM usuario
						WHERE id_usuario = ?
						LIMIT 	1";

			$dbres = $this->db->query($sql, array($id));
			$rows = $dbres->result_array();
			return $rows;
	}

	function actualizarPassword($clave, $id){
		$salt = rand(0,999999); //calcular un número aleatorio
		$hash_clave = hash('sha256', $clave.$salt); //calcular el hash de clave + salt
		
		$sql = "UPDATE usuario
				SET hash_clave = '$hash_clave', salt = '$salt'
				WHERE id_usuario = '$id' ";

		$dbres = $this->db->query($sql);
		return $dbres;
	}

	//mostrar los lugar de las salas de ventas
	function seleccionarLugar(){
		$sql = "SELECT id_lugar, nombre, direccion
				FROM 	lugar
				order by id_lugar ASC
				LIMIT 	50";

		$dbres = $this->db->query($sql);
		$rows = $dbres->result_array();
		return $rows;
	}

	function seleccionarSucursales(){
		$sql = "SELECT l.id_lugar, l.nombre, l.direccion, a.nombre_mun as muni, b.nombre_depto as depto, l.telefono as tel, l.telefono_2 as tel2, l.imagen
				FROM 	lugar l
				JOIN    municipio a on l.muni_id_muni = a.id_municipio
				JOIN    departamento b on a.depto_id_depto = b.id_departamento
				WHERE 	l.estado = 'A'
				order by id_lugar ASC
				LIMIT 	50";

		$dbres = $this->db->query($sql);
		$rows = $dbres->result_array();
		return $rows;
	}

	function traerSucursal($id_lugar){
		$sql = "SELECT l.id_lugar, l.nombre, l.direccion, l.muni_id_muni, a.nombre_mun as muni, b.nombre_depto as depto, l.telefono as tel, l.telefono_2 as tel2, l.imagen
				FROM 	lugar l
				JOIN    municipio a on l.muni_id_muni = a.id_municipio
				JOIN    departamento b on a.depto_id_depto = b.id_departamento
				WHERE id_lugar = '$id_lugar' ";

		$dbres = $this->db->query($sql);
		$rows = $dbres->result_array();
		return $rows;
	}

	function traerSucursalEstado($id_lugar){
		$sql = "UPDATE lugar
				SET estado = 'B'
				WHERE id_lugar = '$id_lugar' ";
		$dbres = $this->db->query($sql);
		return $dbres;
	}

	function updateLugares($id_lugar, $nombre, $direccion, $muni_id_muni, $telefono, $telefono_2, $imagen){
		$sql = "UPDATE lugar
				SET nombre = '$nombre', direccion = '$direccion', muni_id_muni = '$muni_id_muni', telefono='$telefono', telefono_2 = '$telefono_2', imagen = '$imagen'
				WHERE id_lugar = '$id_lugar' ";

		$dbres = $this->db->query($sql);
		return $dbres;
	}

	function newLugares($nombre, $direccion, $muni_id_muni, $telefono, $telefono_2, $imagen){
		$sql = "INSERT INTO lugar(nombre, direccion, muni_id_muni, telefono, telefono_2, imagen, estado)
				VALUES (?, ?, ?, ?, ?, ?, ?)";
		
		$estado = "A";
		$valores = array($nombre, $direccion, $muni_id_muni, $telefono, $telefono_2, $imagen, $estado);
		$dbres = $this->db->query($sql, $valores);
		return $dbres;
	}
}