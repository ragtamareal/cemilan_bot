<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Home extends CI_Controller {
	
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
		
		$this->db->_error_message();  
	}
	
	function index()
	{
		$data = $this->data;
		
		$data['title'] = 'Home';
		$data['content'] = 'index';
		$this->load->view('template_index', $data);
	}
	
	function forgot_password()
	{
		$data = $this->data;
		
		$data['title'] = 'Forgot Password';
		$data['content'] = 'password';
		$this->load->view('template_index', $data);
	}
	
	function faq()
	{
		$data = $this->data;
		
		$ttag = $this->root->detail_static(9);
		foreach($ttag as $tg){
			if ($tg->title_tag != ''){	
				$data['title'] = $tg->title_tag;
			}else{
				$data['title'] = 'F.A.Q';
			}
		}
		$data['content'] = 'faq';
		$this->load->view('template_index', $data);
	}
	
	function about()
	{
		$data = $this->data;
		
		$ttag = $this->root->detail_static(7);
		foreach($ttag as $tg){
			if ($tg->title_tag != ''){	
				$data['title'] = $tg->title_tag;
			}else{
				$data['title'] = 'About Us';
			}
		}
		$data['content'] = 'about';
		$this->load->view('template_index', $data);
	}
	
	function activate_account($user, $code) {
		$result = $this -> root -> activate($user, $code);
		if ($result) {
			$data['info'] = 1;
		} else {
			$data['info'] = 0;
		}
		$data['title'] = 'Activation';
		$data['warn'] = '';
		$data['username'] = '';
		$data['content'] = 'login';

		$this -> load -> view('template_index', $data);
	}
	
	function login()
	{
		$data = $this->data;
		//This method will have the credentials validation
		$this->load->library('form_validation');
		
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		$this->form_validation->set_message('min_length', '%s kurang dari %s karakter');
		
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|min_length[5]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length[6]');
		
		if($this->form_validation->run() == FALSE)
		{
			$data['username'] = $this->input->post('username');	
				
			$data['title'] = 'Login';
			$data['content'] = 'login';
			$this->load->view('template_index', $data);
		}
		else
		{
			$user = $this->input->post('username');
			$password = $this->input->post('password');
			
			$result = $this->root->login($user, $password);
			
			if ($result){
				$sess_array = array();

				foreach($result as $row)
				{
					$type = $row->type;
					$service = $row->service;

					$sess_array = array(
						'member_id' => $row->id_user,
						'uname' => $row->username,
						'firstname' => $row->firstname,
						'lastname' => $row->lastname,
						'email' => $row->email,
						'address' => $row->address,
						'no_telp' => $row->no_telp,
						'service' => $row->service
					);


					
					if($type == 1 && $service == 3){
						$this->session->set_userdata('l0g_i5m', $sess_array);
						redirect('utility', 'refresh');
					}elseif($type == 1 && $service == 1){
						$pln = $this->root->select_pln($row->id_user);
						
						$sess_array['main_meter'] = $pln[0]["main_meter"];
						$sess_array['met_type'] = $pln[0]["TIPE_METER"];
						$sess_array['pel_type'] = $pln[0]["TIPE_PLG"];
						$sess_array['id_pel'] = $pln[0]["ID_PELANGGAN"];
						$sess_array['act_uti'] = "pln";
						
						$this->session->set_userdata('l0g_i5m', $sess_array);
						redirect('user', 'refresh');
					}elseif($type == 1 && 	$service == 2){
						$pgn = $this->root->select_pgn($row->id_user);
						
						$sess_array['main_meter'] = $pgn[0]["main_meter"];
						$sess_array['met_type'] = $pln[0]["meter_type"];
						$sess_array['pel_type'] = $pln[0]["pelanggan_type"];
						$sess_array['id_pel'] = $pgn[0]["id_pelanggan"];
						$sess_array['act_uti'] = "pgn";
				
						$this->session->set_userdata('l0g_i5m', $sess_array);
						redirect('pgn', 'refresh');
					}
				}
			}else{
				$data['title'] = 'Login';
				$data['warn'] = '<div class="alert alert-danger">Username / Password Anda Salah !</div>';
				$data['username'] = $this->input->post('username');	
				
				$data['content'] = 'login';
				$this->load->view('template_index', $data);
			}
		}
	}

	function registrasi()
	{
		$data = $this->data;
		//This method will have the credentials validation
		$this->load->library('form_validation');
		
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		$this->form_validation->set_message('min_length', '%s kurang dari %s karakter');
		$this->form_validation->set_message('numeric', '%s hanya boleh angka');
		
		$this->form_validation->set_rules('nd_reg', 'Nama Depan', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nb_reg', 'Nama Belakang', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email_reg', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('pwd_reg', 'Password', 'trim|required|xss_clean|min_length[6]');
		$this->form_validation->set_rules('pwdcnf_reg', 'Konfirmasi Password', 'trim|required|xss_clean|min_length[6]|matches[pwd_reg]');
		
		if($this->form_validation->run() == FALSE)
		{
			$data['title'] = 'Registrasi';
			$data['content'] = 'registrasi';
			$this->load->view('template_index', $data);
		}
		else
		{
			$nd_reg = $this->input->post('nd_reg');
			$nb_reg = $this->input->post('nb_reg');
			$email_reg = $this->input->post('email_reg');
			$pwd_reg = $this->input->post('pwd_reg');
			
			$length1 = 9;
			$length2 = 32;
			$key_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
			$rand_max = strlen($key_chars) - 1;

			for ($i = 0; $i < $length1; $i++) {
				$rand_pos = rand(0, $rand_max);
				$rand_key[] = $key_chars{$rand_pos};
			}
			
			for ($i = 0; $i < $length2; $i++) {
				$rand_pos2 = rand(0, $rand_max);
				$rand2_key[] = $key_chars{$rand_pos2};
			}

			$user_code = implode('', $rand_key);
			$act_code = implode('', $rand2_key);
			
			$this -> load -> library('email');

			$this -> email -> from('noreply.checkout@gmail.com', 'Quran Centrum Store Account - Activation');
			$this -> email -> to($email_reg);
			$this -> email -> subject('Email Confirmation');
			$this -> email -> message('DO NOT REPLY TO THIS EMAIL! <br/>
*************************** <br/>
<br/>
Dear ' . $nd_reg .' '.$nb_reg .',
<br/><br/>
username : ' . $user_code . '<br/>
password :	' . $pwd_reg . '
<br/><br/>
klik link berikut untuk aktivasi akun Quran Centrum Store Anda<br/>
<a href="' . site_url() . '/home/activate_account/' . $user_code . '/' . $act_code . '">' . site_url() . '/home/activate_account/' . $user_code . '/' . $act_code . '</a><br/>
<br/>
-Admin Quran Centrum Store-');

			if ($this -> email -> send()) {
				$result = $this->root->insert_member($user_code, $nd_reg, $nb_reg, $email_reg, $pwd_reg, $act_code);
				if($result){
					$data['reg_stats'] = true;
				}
			}
			
			$data['title'] = 'Success';
			$data['content'] = $con;
			$this->load->view('template_index', $data);
			
		}
	}

	function logout() {
		$this -> session -> unset_userdata('l0g_i5m');
		session_destroy();
		redirect('home', 'refresh');
	}	
}
?>