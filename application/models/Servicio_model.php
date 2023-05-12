<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Servicio_model extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
}