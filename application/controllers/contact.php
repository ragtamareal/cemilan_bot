<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Contact extends CI_Controller {

	function __construct()
  	{
	    parent::__construct();
		
		$session_data = $this -> session -> userdata('l0g_i5m');
		if ($session_data) {
			$this->data = array(
	            'firstname' => $session_data['firstname'],
				'lastname' => $session_data['lastname'],
				'act_uti' => $session_data['act_uti'],
				'service' => $session_data['service'],
	            'sess_act' => true
			);
		}else{
			$this->data = array(
	           	'username' => '',
	            'password' => '',
	            'act_uti' => '',
	            'warn' => '',
	            'sess_act' => false
	        );
		};
		
		
	}
	
	public function index()
	{
		$data = $this->data;
		
		$this->load->library('form_validation');
		$this->form_validation->set_message('required, %s tidak boleh kosong');

		$this->form_validation->set_rules('nama', 'Nama', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
		$this->form_validation->set_rules('pesan', 'Pesan', 'trim|required|xss_clean');
	
		if ($this->form_validation->run() == TRUE) {
			$nama = $this->input->post('nama');
			$email = $this->input->post('email'); 
			$pesan = $this->input->post('pesan');
			
			$this -> root -> insert_pesan($nama, $email, $pesan);
			
			$data['warn'] = 'Terima kasih atas pertanyaan Anda';
		}
		
		$data['title'] = 'Contact Us';
		$data['content'] = 'contactusview';
		$this->load->view('template_index', $data);
	}
}