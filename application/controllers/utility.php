<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Utility extends CI_Controller {
	
	function __construct()
  	{
	    parent::__construct();
	}
	
	function index()
	{
		if ($this -> session -> userdata('l0g_i5m')) {
			
			$session_data = $this -> session -> userdata('l0g_i5m');
			//print_r($session_data);
			$member_id = $session_data['member_id'];
			$data['firstname'] = $session_data['firstname'];
			$data['lastname'] = $session_data['lastname'];
			$data['act_uti'] = $session_data['act_uti'];
			$data['service'] = $session_data['service'];
			$data['sess_act'] = true;
			
			if($data['service'] == 3){
				
				$akses = $this->input->get('access');
				//echo $akses;
				if($akses == ''){
					$data['title'] = 'Choose Utility';
					$data['content'] = 'utility';
					$this->load->view('template_index', $data);
				}elseif($akses == 'pln'){
					$pln = $this->root->select_pln($member_id);
							
					$session_data['main_meter'] = $pln[0]["main_meter"];
					$sess_array['met_type'] = $pln[0]["meter_type"];
					$sess_array['pel_type'] = $pln[0]["pelanggan_type"];
					$session_data['id_pel'] = $pln[0]["ID_PELANGGAN"];
					$session_data['act_uti'] = "pln";
					//print_r($session_data);
					$this->session->set_userdata('l0g_i5m', $session_data);
					redirect('user', 'refresh');
				}elseif($akses == 'pgn'){
					$pgn = $this->root->select_pgn($member_id);
							
					$session_data['main_meter'] = $pgn[0]["main_meter"];
					$sess_array['met_type'] = $pln[0]["meter_type"];
					$sess_array['pel_type'] = $pln[0]["pelanggan_type"];
					$session_data['id_pel'] = $pgn[0]["id_pelanggan"];
					$session_data['act_uti'] = "pgn";
					
					$this->session->set_userdata('l0g_i5m', $session_data);
					redirect('pgn', 'refresh');
				}else{
					redirect(404, 'refresh');
				}
			}else{
				redirect(404, 'refresh');
			}
		}
	}
}
?>