<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendario_model extends CI_Model {
	//Constructor
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

}