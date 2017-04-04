<?php
class New_md extends CI_Model {

	function __construct() {
		parent::__construct();
		//$this->load->database();
	}

	function select_meter() {
		return $this -> db -> get('MAP_TBL')->result_array();
	}
}
?>