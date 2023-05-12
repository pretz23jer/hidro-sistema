<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mensaje_model extends CI_Model {

//Constructor
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
}