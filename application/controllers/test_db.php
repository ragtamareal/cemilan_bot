<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Test_db extends CI_Controller {
	
	function __construct()
  	{
	    parent::__construct();
	}
	
	function index()
	{
		$pln = $this->new_md->select_meter();
		echo '<pre>'; print_r($pln); echo '</pre>';
		
	}
}
?>