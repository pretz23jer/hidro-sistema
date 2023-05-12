<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Producto_model extends CI_Model {

//Constructor
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
//busca el codigno si no viene repetido
	function selCodExistenteProd($codigo) {
		$sql = "SELECT 	codigo
				FROM 	producto
				WHERE 	codigo = ?
				LIMIT 1 ;";

		$dbres = $this->db->query($sql, array($codigo));
		$rows = $dbres->result_array();
		return $rows;
	}

	function crearProducto($codigo, $nombre, $descripcion, $id_catProducto, $precio_compra, $precio_venta, $existencia, $id_provProducto, $imagen){
		$sql = "INSERT INTO producto(codigo, nombreProducto, descripcion, id_catProducto, precio_compra, precio_venta, existencia, id_provProducto, imagen, estado)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

		$estado = "A";
		$valores = array($codigo, $nombre, $descripcion, $id_catProducto, $precio_compra, $precio_venta, $existencia, $id_provProducto, $imagen, $estado);
		$dbres = $this->db->query($sql, $valores);
		return $dbres;
	}

	
	function crearControl($id_producto, $fecha_registro, $id_usuario_registro, $fecha_modifica, $id_usuario_modifica){
		$sql = "INSERT INTO control(id_productoControl, fecha_registro, id_usuario_registro, fecha_modifica, id_usuario_modifica)
				VALUES (?, ?, ?, ?, ?)";
		$valores = array($id_producto, $fecha_registro, $id_usuario_registro, $fecha_modifica, $id_usuario_modifica);
		$dbres = $this->db->query($sql, $valores);
		return $dbres;
	}

	function selecIdProductoP($codigo){
		$sql = "SELECT 	id_producto
				FROM 	producto
				WHERE 	codigo = ?
				LIMIT 	1";

		$dbres = $this->db->query($sql, array($codigo));
		$rows = $dbres->result_array();
		return $rows[0]['id_producto'];
	}

	function seleccionarProveedorP() {
		$sql = "SELECT 	id_proveedor, nombre
				FROM 	proveedor
				WHERE	estado = 'Activo'
				LIMIT 	100";

		$dbres = $this->db->query($sql);
		$rows = $dbres->result_array();
		return $rows;
	}

	function seleccionarCategoriaP(){
		$sql = "SELECT 	id_categoria, nombre
				FROM 	categoria
				WHERE  	estado = 'A'
				LIMIT 	50";

		$dbres = $this->db->query($sql);
		$rows = $dbres->result_array();
		return $rows;
	}
//editar producto
	function seleccionarProductoEditar($id_producto){
		$sql = "SELECT p.id_producto as id_producto, p.codigo as codigo, p.nombreProducto as nombreProducto, p.descripcion as descripcion, q.nombre as categoria, p.precio_compra as precio_compra, p.precio_venta as precio_venta, p.existencia as existencia, r.nombre as proveedor, s.fecha_modifica as fecha_modifica, s.id_usuario_modifica as id_usuario_modifica, p.imagen as imagen
				FROM 	producto p
				JOIN	categoria q on p.id_catProducto = q.id_categoria
				JOIN	proveedor r on p.id_provProducto = r.id_proveedor
				JOIN	control s on p.id_producto = s.id_productoControl
				WHERE	p.id_producto = ?
				LIMIT 	1";

		$dbres = $this->db->query($sql, $id_producto);
		$rows = $dbres->result_array();
		return $rows;
	} 
//actualziar producto
	function actualizarProductoSeleccionado($codigo, $nombreProducto, $descripcion, $id_catProducto, $precio_compra, $precio_venta, $existencia, $id_provProducto, $imagen, $id_producto){

		$sql = "UPDATE producto
		SET codigo = '$codigo', nombreProducto = '$nombreProducto', descripcion = '$descripcion', id_catProducto = '$id_catProducto', precio_compra = '$precio_compra', precio_venta = '$precio_venta', existencia = '$existencia', id_provProducto = '$id_provProducto', imagen = '$imagen'
		WHERE id_producto = '$id_producto' "; 

		print_r($sql);
		$dbres = $this->db->query($sql);
		return $dbres;
	}

	function actualizarControl($id_producto, $fecha_modifica, $id_usuario_modifica){
		$sql = "UPDATE control
		SET fecha_modifica = '$fecha_modifica', id_usuario_modifica = '$id_usuario_modifica'
		WHERE id_productoControl = '$id_producto'";
		$dbres = $this->db->query($sql);
		return $dbres;
	}

//dar baja al producto cambiando el estado de A a B
	function darBajaP($id_producto) {
		$sql = "UPDATE 	producto
			SET 	estado = 'B'
			WHERE 	id_producto = '$id_producto'
			LIMIT 	1";

		$dbres = $this->db->query($sql);
		return $dbres;
	}

	//dar de baja a p´roducto en promoción
	function darBajaPromocion($id_producto) {
		$sql = "UPDATE 	producto_promocion
			SET 	estado = 'B'
			WHERE 	id_promocion = '$id_producto'
			LIMIT 	1";

		$dbres = $this->db->query($sql);
		return $dbres;
	}

	function categoriaProducto($categoria, $descripcion){
		$sql = "INSERT INTO categoria(nombre, descripcion)
				VALUES (?, ?)";

		$valores = array($categoria, $descripcion);
		$dbres = $this->db->query($sql, $valores);
		return $dbres;
	}

	function selecionarCategoria(){
		$sql = "SELECT 	categoria.id_categoria id_categoria, categoria.nombre categoria, categoria.descripcion descripcion
				FROM 	categoria
				WHERE  	estado = 'A'
				LIMIT 	100";

		$dbres = $this->db->query($sql);
		$rows = $dbres->result_array();
		return $rows;
	}

	function eliminarCategoriaP($id_categoria){
		$sql = "UPDATE categoria
				SET estado = 'B'
				WHERE id_categoria = '$id_categoria'";
		$dbres = $this->db->query($sql);
		return $dbres;
	}

//mostra datos del producto seleccionado
	function mostrarDatosProdIndividual($id_producto){
        $sql = "SELECT id_producto as codigo,  CONCAT(nombreProducto,', ',descripcion) as detalle,  precio_compra, precio_venta, existencia
                FROM    producto
                WHERE   id_producto = ?
                ";

        $dbres = $this->db->query($sql, array($id_producto));
        $rows = $dbres->result_array();
        return $rows;
	}

	//actualizar registro del producto
	function actualizarStockProducto($id_producto, $precio_compra, $precio_venta, $existencia){
		$sql = "UPDATE producto
				SET precio_compra = '$precio_compra', precio_venta = '$precio_venta', existencia = '$existencia'
				WHERE id_producto = '$id_producto'";
		$dbres = $this->db->query($sql);
		return $dbres;
	}


	function actualizarControlProducto($id_usuario_modifica, $fecha_modifica, $id_producto){
		$sql = "UPDATE control
				SET id_usuario_modifica = '$id_usuario_modifica', fecha_modifica = '$fecha_modifica'
				WHERE id_productoControl = '$id_producto'";
		$dbres = $this->db->query($sql);
		return $dbres;
	}

	///lisatar productos registrados en el sistema

	function seleccionarProductoRegistrado(){
		$sql = "SELECT p.id_producto id_producto, p.codigo codigo, CONCAT(p.nombreProducto,', ',p.descripcion) as descripcion, p.precio_venta precio, p.existencia existencia, q.nombre as categoria, p.imagen as imagen
			FROM 	producto p
			JOIN	categoria q on p.id_catProducto = q.id_categoria
			WHERE	p.estado = 'A'
			ORDER BY p.id_producto ASC, categoria ASC
			LIMIT 	500";

		$dbres = $this->db->query($sql);
		$rows = $dbres->result_array();
		return $rows;
	}

	function mostrar_cat_regis(){
		$sql = "SELECT id_categoria as id, nombre
			FROM 	categoria
			WHERE  	estado = 'A'
			ORDER BY id_categoria ASC
			LIMIT 	150";

		$dbres = $this->db->query($sql);
		$rows = $dbres->result_array();
		return $rows;
	}

	//seleccionar producto por categoria
	function seleccionarProductoCategoria($categoria) {
		$sql = "SELECT p.id_producto id_producto, p.codigo codigo, p.nombreProducto nombreP, CONCAT(p.nombreProducto,', ',p.descripcion) as descripcion, p.precio_venta precio, p.existencia existencia, q.nombre categoria, p.imagen as imagen, p.estado estado
			FROM 	producto p
			JOIN	categoria q on p.id_catProducto = q.id_categoria
			WHERE  	q.id_categoria = '$categoria' and p.estado = 'A' 
			ORDER BY id_producto ASC
			LIMIT 	150";

		$dbres = $this->db->query($sql, array($categoria));
		$rows = $dbres->result_array();
		return $rows;
	}


	///producto em promocion
	function regitrarProductoPromocion($prod_id_producto, $precio_compra, $precio_venta_sis, $precio_promocion, $descripcion, $usuario_modifica, $fecha_modificacion){
		$sql = "INSERT INTO producto_promocion(prod_id_producto, precio_compra, precio_venta_sis, precio_promocion, descripcion, usuario_modifica, fecha_modificacion)
			VALUES (?, ?, ?, ?, ?, ?, ?)";
		$valores = array($prod_id_producto, $precio_compra, $precio_venta_sis, $precio_promocion, $descripcion, $usuario_modifica, $fecha_modificacion);
		$dbres = $this->db->query($sql, $valores);
		return $dbres;
	}

		//seleccionar producto en promocion
	function seleccionarProductoEnPromocion() {
		$sql = "SELECT a.id_promocion, p.id_producto, p.codigo codigo, p.nombreProducto nombreP, CONCAT(p.nombreProducto,', ',p.descripcion) as descripcion, p.precio_venta precioVenta, p.existencia existencia, a.precio_promocion promocion, a.descripcion as motivo, p.imagen as imagen
			FROM 	producto_promocion a
			JOIN	producto p on p.id_producto = a.prod_id_producto
			WHERE  	a.estado = 'A' 
			ORDER BY a.id_promocion ASC
			LIMIT 	250";

		$dbres = $this->db->query($sql);
		$rows = $dbres->result_array();
		return $rows;
	}


}