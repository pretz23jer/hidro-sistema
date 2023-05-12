<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Venta_model extends CI_Model {

//Constructor
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function seleccionarProducto() {
		$sql = "SELECT 	*
				FROM 	producto
				WHERE 	estado = 'A'
		    	ORDER BY nombreProducto ASC
				LIMIT 	1000";

		$dbres = $this->db->query($sql);
		$rows = $dbres->result_array();
		return $rows;
	}
	function Selec_Producto(){
		$sql = "SELECT a.id_producto, a.codigo, a.nombreProducto as nombreP, a.descripcion, a.precio_venta as precio, a.existencia, a.imagen
				FROM 	producto a 
				JOIN	categoria b on a.id_catProducto = b.id_categoria
				WHERE 	a.estado = 'A' and a.existencia > '0' and b.nombre = 'Calentadores Solares' or b.nombre = 'Paneles Solares'
		    	ORDER BY a.nombreProducto ASC
				LIMIT 	1000";

		$dbres = $this->db->query($sql);
		$rows = $dbres->result_array();
		return $rows;
	}
	//buscar el numero de ventas
	function buscarNumeroV(){
		$sql = "SELECT MAX(id_ventas)+1 as id
				FROM 	venta
				";
		$dbres = $this->db->query($sql);
		$rows = $dbres->result_array();
		return $rows;
	}

	//buscar el numero de ventas
	function buscarNumeroVsum(){
		$sql = "SELECT MAX(id_comprobante)+1 as id
				FROM 	comprobante
				";
		$dbres = $this->db->query($sql);
		$rows = $dbres->result_array();
		return $rows;
	}

//traer propductos para ser vendidos
	function Selec_ProductoSuministro(){
		$sql = "SELECT a.id_producto, a.codigo, CONCAT(a.nombreProducto,', ',a.descripcion) as nombreP, b.nombre as categoria, a.precio_venta as precio, a.existencia, a.imagen
				FROM 	producto a 
				JOIN	categoria b on a.id_catProducto = b.id_categoria
				WHERE 	a.estado = 'A' and a.existencia > '0'
		    	ORDER BY a.precio_venta DESC
				LIMIT 	1000";

		$dbres = $this->db->query($sql);
		$rows = $dbres->result_array();
		return $rows;
	}

	function buscarProductoRegis($id_producto){
		$sql = "SELECT id_producto, codigo, nombreProducto as nombreP, descripcion, precio_venta as precio, existencia
				FROM 	producto
                WHERE   id_producto = ?
                ";

        $dbres = $this->db->query($sql, array($id_producto));
        $rows = $dbres->result_array();
        return $rows;
	}
}