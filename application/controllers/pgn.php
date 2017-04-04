<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Pgn extends CI_Controller {
		
	private $ul = 'http://192.168.0.11:8080/Integration/';
	
	function __construct()
  	{
	    parent::__construct();
		$session_data = $this -> session -> userdata('l0g_i5m');
		if ($session_data) {
			if($session_data['service'] == 2 || $session_data['service'] == 3){
			$last_bal = $this->user_m->last_meter_data($session_data['main_meter']);
			if($last_bal)
				$split =  substr($last_bal[0]['balance_kwh'], 0);
			else
				$split = '000000.00';
			 
		$this->data = array(
	            'mem_id' => $session_data['member_id'],
	            'uname' => $session_data['uname'],
				'firstname' => $session_data['firstname'],
				'lastname' => $session_data['lastname'],
				'email' => $session_data['email'],
				'address' => $session_data['address'],
				'no_telp' => $session_data['no_telp'],
				'service' => $session_data['service'],
				'main_meter' => $session_data['main_meter'],
				'id_pel' => $session_data['id_pel'],
				'balance_now' => str_split($split),
				'sess_act' => true,
				'act_uti' => $session_data['act_uti'],
				'content' => 'pgn/sidebar'
	        );
			}else{
					redirect(404, 'refresh');
			}
		}else{
			redirect(404, 'refresh');
		}
	}
	
	function index()
	{
		if ($this -> session -> userdata('l0g_i5m')) {
			$data = $this->data;
			
			$data['meter_data'] = $this->user_m->last_meter_data($data['main_meter']);
			$data['topup_his_lim'] = $this->user_m->last_topup_history($data['mem_id']);
			$data['topup_his'] = $this->user_m->topup_history($data['main_meter']);
			$data['total_usage'] = $this->user_m->total_usage($data['main_meter']);
			
			$data['title'] = 'Profile';
			$data['sub_content'] = 'pgn/profile';
			$this->load->view('template_index', $data);
		}else{
			redirect('home', 'refresh');
		}
	}
	
	function meter_list()
	{
		if ($this -> session -> userdata('l0g_i5m')) {
			$data = $this->data;
			
			$this->load->library('form_validation');
		
			$this->form_validation->set_message('required', '%s tidak boleh kosong');
			$this->form_validation->set_message('min_length', '%s kurang dari %s karakter');
			
			$this->form_validation->set_rules('id_meter', 'No Meter', 'trim|required|xss_clean|min_length[11]');
			
			if($this->form_validation->run() == FALSE)
			{
				$data['warn'] = '';	
				$data['all_meter'] = $this->user_m->all_meter($data['mem_id']);
				
				$data['title'] = 'Profile';
				$data['sub_content'] = 'pgn/meter_list';
				$this->load->view('template_index', $data);
			}else{
				$no_meter  = $this->input->post('id_meter');
				
				$ava = $this->user_m->check_meter($no_meter);
				if($ava){
					$ex = $this->user_m->check_meter_ex($data['mem_id'], $no_meter);
					if(!$ex){
						$this->user_m->insert_mapping($data['mem_id'], $no_meter);
						$data['warn'] = '<div class="alert alert-success">ID Meter berhasil dimasukkan</div>';
					}else{
						$data['warn'] = '<div class="alert alert-danger">ID Meter sudah dipilih</div>';
					}
				}else{
					$data['warn'] = '<div class="alert alert-danger">ID Meter tidak terdaftar</div>';
				}
				
				$data['all_meter'] = $this->user_m->all_meter($data['mem_id']);
				
				$data['title'] = 'Profile';
				$data['sub_content'] = 'pgn/meter_list';
				$this->load->view('template_index', $data);
			}
		}else{
			redirect('home', 'refresh');
		}
	}

	function del_meter($id_org, $meter)
	{
		if ($this -> session -> userdata('l0g_i5m')) {
			$data = $this->data;

			if($data['mem_id'] == $id_org){
				$this->user_m->delete_meter($id_org, $meter);
				redirect('user/meter_list', 'refresh');
			}else {
				redirect(404, 'refresh');
			}
		}else{
			redirect('home', 'refresh');
		}
	}
	
	function topup()
	{
		if ($this -> session -> userdata('l0g_i5m')) {
			$data = $this->data;

			$data['all_meter'] = $this->user_m->all_meter($data['mem_id']);

			$data['title'] = 'Top Up';
			$data['sub_content'] = 'pgn/topup';
			$this->load->view('template_index', $data);
		}else{
			redirect('home', 'refresh');
		}
	}
	
	function topup_exe()
	{
		if ($this -> session -> userdata('l0g_i5m')) {
			$data = $this->data;

			$id_met = $this->input->post('meter');
			$token = $this->input->post('token');
			
			//insert_db
			$id_transaksi = $this->user_m->insert_transaksi('topup', $id_met, $token, '', '', $data['mem_id']);
			$id_transaksi = '1111111111';
			//select type meter
			$met_type = $this->user_m->select_typemeter($id_met);
			
			//send to MD & get status topup
			$post = 'tx_id='.$id_transaksi.'&no_token='.$token.'&meter_id='.$id_met.'&tipe_meter='.$met_type[0]['meter_type'].'&tipe_pu=1';
			//$link = $this->ul.'?';
			$send = $this->send_api($this->ul.'request-token', $post, 1);
			//$send = $this->send_api($link,1);
			
			if($send == 1){
				$exe = $this->check_db($id_transaksi, 1);
				//echo 'hasil keluar = '.print_r($exe).$exe[0]['status'];
				//echo $id_met.' - '.$token;
				if($exe[0]['status'] == 1){
					$info = '<div class="col-md-1">
								<img src="'.base_url() . 'assets/img/icon/ico-success.png">
							</div>';
					$bal = '<tr>
								<td width="30%"><strong>Balance Sekarang</strong></td>
								<td >'.$exe[0]['balance_kwh'].'</td>
							</tr>';
				}else{
					$info = '<div class="col-md-1">
							<img src="'.base_url() . 'assets/img/icon/ico-fail.png">
						</div>
						';
				}
				if($exe[0]['status'] == 1){
					$msg = 'Selamat, Top up pulsa listrik telah berhasil dilakukan';
					$stats = 'Success'; 
				}elseif($exe[0]['status'] == 2){
					$msg = 'Maaf, Token Anda sudah terpakai';
					$stats = 'Token Terpakai'; 
				}elseif($exe[0]['status'] == 3){
					$msg = 'Maaf, Token Anda salah';
					$stats = 'Salah Token'; 
				}elseif($exe[0]['status'] == 4){
					$msg = 'Maaf, Token Anda sudah tidak dapat digunakan lagi';
					$stats = 'Token Usang'; 
				}elseif($exe[0]['status'] == 5){
					$msg = 'Maaf, Komunikasi proses topup error';
					$stats = 'Komunikasi Error'; 
				}elseif($exe[0]['status'] == 0){
					$msg = 'Maaf, Komunikasi proses topup error';
					$stats = 'Komunikasi Error'; 
				}
				
				$det = '<div class="col-md-8">
							<h4>'.$msg.'</h4>
							<p>Detail informasi top up :</p>
							<br>
							<table class="table table-striped">';
				if($exe[0]['status'] == 1) $det .= $bal; 			
								
				$det .= 	'<tr>
									<td width="30%"><strong>Nomor Token</strong></td>
									<td >'.$token.'</td>
								</tr>
								<tr>
									<td width="30%"><strong>Nomor Meter</strong></td>
									<td>'.$id_met.'</td>
								</tr>
								<tr>
									<td width="30%"><strong>Tanggal Request</strong></td>
									<td>'.date("d F Y", strtotime($exe[0]['reqtime'])).'</td>
								</tr>
								<tr>
									<td width="30%"><strong>Status</strong></td>
									<td>'.$stats.'</td>
								</tr>
								<tr>
									<td width="30%"><strong>Top Up by</strong></td>
									<td>'.$data['firstname'].' '.$data['lastname'].'</td>
								</tr>
							</table>
						</div>
						<div class="clearfix"></div>';
				$html = $info.$det;
			}else{
				$html = '
						<div class="col-md-1">
							<img src="'.base_url().'assets/img/icon/ico-fail.png">
						</div>
						<div class="col-md-8">
							<h4>Maaf, Top up pulsa gagal dilakukan</h4>
							<p>Silahkan coba kembali, klik <a href="'.site_url("user/topup").'">disini</a> untuk mencoba lagi</p>
							
						</div>
						<div class="clearfix"></div>
						';
			}
			echo $html;
		}else{
			redirect('home', 'refresh');
		}
	}
	
	function topup_history()
	{
		if ($this -> session -> userdata('l0g_i5m')) {
			$data = $this->data;

			$data['all_meter'] = $this->user_m->all_meter($data['mem_id']);
			
			$per_page = 5;
			if ($this -> uri -> segment(3) != '') $meter_act = $this -> uri -> segment(3); else $meter_act = $data['main_meter']; 
				
			if ($this -> uri -> segment(4) != '') {
				$data['count'] = $this -> uri -> segment(4);
				$data['topup_hist'] = $this -> user_m -> topup_history_pg($meter_act, $data['count'], $per_page);
			} else {
				$data['topup_hist'] = $this -> user_m -> topup_history_pg($meter_act, 0, $per_page);
			}
			
			if ($data['topup_hist']) {
				$data['jumlah'] = $this -> user_m -> topup_history($data['main_meter']);
				$base = site_url() . '/user/topup_history/'.$meter_act;
				
				$data['link'] = $this->create_paging($per_page, $base, $data['jumlah'], 4);
			} else
				$data['jumlah'] = 0;
			
			$data['title'] = 'Top Up';
			$data['sub_content'] = 'pgn/topup_history';
			$this->load->view('template_index', $data);
		}else{
			redirect('home', 'refresh');
		}
	}

	function tophistory_exe()
	{
		if ($this -> session -> userdata('l0g_i5m')) {
			$data = $this->data;
			
			$no_meter = $this->input->post('meter');
			$per_page = 5;
				
			$topup_hist = $this -> user_m -> topup_history_pg($no_meter, 0, $per_page);
			
			$res = '';
			if ($topup_hist) {
				$jumlah = $this -> user_m -> topup_history($no_meter);
				$base = site_url() . '/user/topup_history/'.$no_meter;
				
				$link = $this->create_paging($per_page, $base, $jumlah, 4);
				
				foreach($topup_hist as $th){
					$res .= '<tr class="even_gradeA" id="5">
								<td>'.$th->no_token.'</td>
								<td>'.$th->reqtime.'</td>
								<td>'.$th->restime.'</td>
								<td>'.$th->status.'</td>
								<td>'.$th->firstname.'</td>
								<td>'.$th->tipe.'</td>
							</tr>';
							
				}
			} else {
				$jumlah = 0;
				$res = '<tr class="even_gradeA odd" id="5">
								<td colspan="5">Data Tidak Tersedia</td>
							</tr>';
				$link = '';
			}
				
				
			$out=array(
				"res"=>$res,
				"jum"=>$jumlah,
				"paging"=>$link
			);
			echo json_encode($out);
		}else{
			redirect('home', 'refresh');
		}
	}
	
	function meter_reading()
	{
		if ($this -> session -> userdata('l0g_i5m')) {
			$data = $this->data;

			$data['all_meter'] = $this->user_m->all_meter($data['mem_id']);
			
			$data['all_meter_data'] = $this->user_m->all_meter_data($data['main_meter']);
			
			$data['title'] = 'Meter Reading';
			$data['sub_content'] = 'pgn/meter_reading';
			$this->load->view('template_index', $data);
		}else{
			redirect('home', 'refresh');
		}
	}
	
	function reading_exe()
	{
		if ($this -> session -> userdata('l0g_i5m')) {
			$data = $this->data;

			$id_met = $this->input->post('meter');
			
			//insert_db
			$id_transaksi = $this->user_m->insert_transaksi('reading', $id_met, '', '', '', $data['mem_id']);
			
			//select type meter
			$met_type = $this->user_m->select_typemeter($id_met);
			
			//send to MD & get status topup
			$post = 'tx_id='.$id_transaksi.'&meter_id='.$id_met.'&tipe_meter='.$met_type[0]['meter_type'].'&tipe_pu=1';
			//$link = $this->ul.'?';
			$send = $this->send_api($this->ul.'request-meter', $post, 1);
			//$send = $this->send_api($link,1);
			
			if($send == 1){
				$exe = $this->check_db($id_transaksi, 1);
				//echo $id_met.' - '.$token;
				if($exe[0]['status'] == 1){
					$read = $this->user_m->select_reading($id_transaksi);
					$isi = '
				<div class="col-md-4">
				<div class="col-md-12">
					<table class="table table-striped tab-det-usage">
					  <tr>
					  	<td class="head-det-usage"><b>Balance (kWh)</b></td>
					  	
					  </tr>
					  <tr>
					  	<td><h1>'.$read[0]['balance_kwh'].'Kwh</h1></td>
					  </tr>
					</table>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="col-md-8">
				<div class="col-md-12">
					<table class="table table-striped tab-det-usage">
					  <tr>
					  	<td class="head-det-usage" colspan="4"><b>Meter Info</b></td>
					  	
					  </tr>
					  <tr>
					  	<td>&nbsp;</td>
					  	<td>R</td>
					  	<td>S</td>
					  	<td>T</td>
					  </tr>
					  <tr>
					  	<td>Arus (A)</td>
					  	<td>'.$read[0]['arus_r'].'</td>
					  	<td>'.$read[0]['arus_s'].'</td>
					  	<td>'.$read[0]['arus_t'].'</td>
					  </tr>
					  <tr>
					  	<td>Tegangan (V)</td>
					  	<td>'.$read[0]['voltage_r'].'</td>
					  	<td>'.$read[0]['voltage_s'].'</td>
					  	<td>'.$read[0]['voltage_t'].'</td>
					  </tr>
					  <tr>
					  	<td>Sudut Tegangan & Arus</td>
					  	<td>'.$read[0]['sudutIV_r'].'</td>
					  	<td>'.$read[0]['sudutIV_s'].'</td>
					  	<td>'.$read[0]['sudutIV_t'].'</td>
					  </tr>
					  <tr>
					  	<td>Cosphi</td>
					  	<td>'.cos($read[0]['sudutIV_r']).'</td>
					  	<td>'.cos($read[0]['sudutIV_s']).'</td>
					  	<td>'.cos($read[0]['sudutIV_t']).'</td>
					  </tr>
					  <tr>
					  	<td>Arah Energi (W)</td>
					  	<td>Importing</td>
					  	<td>Importing</td>
					  	<td>Importing</td>
					  </tr>
					  <tr>
					  	<td>Arah Energi (Var)</td>
					  	<td>Q1</td>
					  	<td>Q1</td>
					  	<td>Q1</td>
					  </tr>
					</table>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
				';
				$html = $isi;
				}
				
			}else{
				$html = '
						<div class="col-md-1">
							<img src="'.base_url().'assets/img/icon/ico-fail.png">
						</div>
						<div class="col-md-8">
							<h4>Maaf, Top up pulsa gagal dilakukan</h4>
							<p>Silahkan coba kembali, klik <a href="'.site_url("user/topup").'">disini</a> untuk mencoba lagi</p>
							
						</div>
						<div class="clearfix"></div>
						';
			}
			echo $html;
		}else{
			redirect('home', 'refresh');
		}
	}
	
	function meter_usage()
	{
		if ($this -> session -> userdata('l0g_i5m')) {
			$data = $this->data;

			$this->load->library('form_validation');
		
			$this->form_validation->set_message('required', '%s tidak boleh kosong');
			$this->form_validation->set_message('min_length', '%s kurang dari %s karakter');
			
			$this->form_validation->set_rules('id_meter', 'No Meter', 'trim|required|xss_clean');
			$this->form_validation->set_rules('sdate', 'Tanggal Awal', 'trim|required|xss_clean');
			$this->form_validation->set_rules('edate', 'Tanggal Akhir', 'trim|required|xss_clean');
			
			if($this->form_validation->run() == FALSE)
			{
				$data['met'] = $this->input->post('id_meter');
				$data['sdate'] = $this->input->post('sdate');
				$data['edate'] = $this->input->post('edate');
				
				$data['v_tab'] = false;
				$data['all_meter'] = $this->user_m->all_meter($data['mem_id']);
				
				$data['title'] = 'History Meter';
				$data['sub_content'] = 'pgn/meter_reading_history';
				$this->load->view('template_index', $data);
			}else{
				$data['met'] = $this->input->post('id_meter');
				$data['sdate'] = $this->input->post('sdate');
				$data['edate'] = $this->input->post('edate');
				
				$id_transaksi = $this->user_m->insert_transaksi('met_his', $data['met'], '', $data['sdate'], $data['edate'], $data['mem_id']);
			
				//select type meter
				$met_type = $this->user_m->select_typemeter($id_met);
				
				//post parameter
				$post = 'tx_id='.$id_transaksi.'&meter_id='.$data['met'].'&tipe_meter='.$met_type[0]['meter_type'].'&tipe_pu=1'.'&start_date='.$data['sdate'].'&end_date='.$data['edate'];
				//$link = $this->ul.'?';
				/*$send = $this->send_api($this->ul.'request-meterhistory', $post, 1);
				
				if($send == 1){
					$exe = $this->check_db($id_transaksi, 1);
					//echo $id_met.' - '.$token;
					$data['met_his'] = $this->user_m->select_meterdata($data['met'], $data['sdate'], $data['edate']);
				}*/
				$json = '[
						  {
						    "balanceKWH": "100",
						    "totalUsage": "200",
						    "voltageR": "220",
						    "voltageS": "220",
						    "voltageT": "220",
						    "arusR": "100",
						    "arusS": "200",
						    "arusT": "300",
						    "powerFactor": "1",
						    "dayaInstant": "100",
						    "tarifIndex": "5",
						    "statusTamper": "1",
						    "totalOff": "500",
						    "prediksiKreditHabis": "10",
						    "paymentModeMeterType": 1,
						    "sudutI": "20",
						    "sudutV": "30",
						    "sudutR": "40",
						    "firmware": "firm",
						    "timeStamp": "2013-03-11 22:11:00"
						  },
						  {
						    "balanceKWH": "100",
						    "totalUsage": "1200",
						    "voltageR": "218",
						    "voltageS": "220",
						    "voltageT": "220",
						    "arusR": "100",
						    "arusS": "200",
						    "arusT": "300",
						    "powerFactor": "1",
						    "dayaInstant": "100",
						    "tarifIndex": "5",
						    "statusTamper": "1",
						    "totalOff": "500",
						    "prediksiKreditHabis": "10",
						    "paymentModeMeterType": 1,
						    "sudutI": "20",
						    "sudutV": "30",
						    "sudutR": "40",
						    "firmware": "firm",
						    "timeStamp": "2013-03-11 22:11:00"
						  }
						]';
						
				$data['arr'] = json_decode($json);
				
				$xaxis = array();
				$bal = array();
				$total = array();
				$vR = array();
				$vS = array();
				$vT = array();
				$iR = array();
				$iS = array();
				$iT = array();
					
				foreach ($data['arr'] as $all) {
					$xaxis[] = $all->timeStamp;
					$bal[] = $all->balanceKWH;
					$total[] = $all->totalUsage;
					$vR[] = $all->voltageR;
					$vS[] = $all->voltageS;
					$vT[] = $all->voltageT;
					$iR[] = $all->arusR;
					$iS[] = $all->arusS;
					$iT[] = $all->arusT;
				}
				
				$data['categories'] = json_encode($xaxis);
				$data['bal'] = preg_replace( "/\"(\d+)\"/", '$1', json_encode($bal));
				$data['total'] = preg_replace( "/\"(\d+)\"/", '$1', json_encode($total));
				$data['voltage_r'] = preg_replace( "/\"(\d+)\"/", '$1', json_encode($vR));
				$data['voltage_s'] = preg_replace( "/\"(\d+)\"/", '$1', json_encode($vS));
				$data['voltage_t'] = preg_replace( "/\"(\d+)\"/", '$1', json_encode($vT));
				$data['arus_r'] = preg_replace( "/\"(\d+)\"/", '$1', json_encode($iR));
				$data['arus_s'] = preg_replace( "/\"(\d+)\"/", '$1', json_encode($iS));
				$data['arus_t'] = preg_replace( "/\"(\d+)\"/", '$1', json_encode($iT));
						
				$data['v_tab'] = true;	
				$data['all_meter'] = $this->user_m->all_meter($data['mem_id']);
				
				$data['title'] = 'History Meter';
				$data['sub_content'] = 'pgn/meter_reading_history';
				$this->load->view('template_index', $data);
			}
		}else{
			redirect('home', 'refresh');
		}
	}
	
	function premium()
	{
		if ($this -> session -> userdata('l0g_i5m')) {
			$data = $this->data;
			
			$this->load->library('form_validation');
		
			$this->form_validation->set_message('required', '%s tidak boleh kosong');
			$this->form_validation->set_message('min_length', '%s kurang dari %s karakter');
			$this->form_validation->set_message('msg', '%s harus disetujui');
			
			$this->form_validation->set_rules('id_meter', 'No Meter', 'trim|required|xss_clean|min_length[11]');
			$this->form_validation->set_rules('id_pel', 'ID Pelanggan', 'trim|required|xss_clean');
			$this->form_validation->set_rules('no_hp', 'No HP', 'trim|required|xss_clean');
			$this->form_validation->set_rules('term', 'Term', 'trim|required|msg|xss_clean');
			
			if($this->form_validation->run() == FALSE)
			{
				$data['warn'] = '';
				
				$data['met'] = $this->input->post('id_meter');
				$data['id_pel'] = $this->input->post('id_pel');
				$data['no_hp'] = $this->input->post('no_hp');
				
				$data['all_meter'] = $this->user_m->all_meter($data['mem_id']);
				
				$data['title'] = 'Premium Member';
				$data['sub_content'] = 'pgn/premium';
				$this->load->view('template_index', $data);
			}else{
				$uti = $this->input->post('utility');		
				$met = $this->input->post('id_meter');
				$id_pel = $this->input->post('id_pel');
				$no_hp = $this->input->post('no_hp');
				
				if($uti == 'PLN') $lity = 1; elseif ($uti == 'PGN') $lity = 2;
				$id_premium = $this->user_m->insert_premium($met, $id_pel, $no_hp, $data['mem_id']);
				
				$data['met'] = '';
				$data['id_pel'] = '';
				$data['no_hp'] = '';
				
				$data['warn'] = '<div class="alert alert-success">Permintaan Berhasil, Terima Kasih</div>';
				
				$data['title'] = 'Premium Member';
				$data['sub_content'] = 'pgn/premium';
				$this->load->view('template_index', $data);
			}
		}else{
			redirect('home', 'refresh');
		}
	}
	
	function edit_profile()
	{
		if ($this -> session -> userdata('l0g_i5m')) {
			$data = $this->data;
			
			$set_prof = $this->input->post('set_prof');
			$set_acc = $this->input->post('set_acc');
			
			$this->load->library('form_validation');
		
			$this->form_validation->set_message('required', '%s tidak boleh kosong');
			$this->form_validation->set_message('min_length', '%s kurang dari %s karakter');
			
			if($set_prof){
				$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|min_length[5]');
				$this->form_validation->set_rules('nama_dpn', 'Nama Depan', 'trim|required|xss_clean');
				$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
				$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required|xss_clean');
				
				$data['uname'] = $this->input->post('username');
				$data['firstname'] = $this->input->post('nama_dpn');
				$data['email'] = $this->input->post('email');
				$data['address'] = $this->input->post('alamat');
			}elseif($set_acc){
				$this->form_validation->set_rules('old_p', 'Old Password', 'trim|required|xss_clean|min_length[6]');
				$this->form_validation->set_rules('new_p', 'New Password', 'trim|required|xss_clean|min_length[6]');
				$this->form_validation->set_rules('rep_p', 'Repeat Password', 'trim|required|xss_clean');
			}
			
			if($this->form_validation->run() == FALSE)
			{
				
				$data['title'] = 'Edit Profile';
				$data['sub_content'] = 'pgn/edit_profile';
				$this->load->view('template_index', $data);
			}else{
				if($set_prof){
					$uname = $this->input->post('username');
					$firstname = $this->input->post('nama_dpn');
					$lastname = $this->input->post('nama_blk');
					$email = $this->input->post('email');
					$address = $this->input->post('alamat');
					
					$this->user_m->update_profile($uname, $firstname, $lastname, $email, $address, $data['mem_id']);
					
					$sess_array = array(
						'member_id' => $data['mem_id'],
						'uname' => $uname,
						'firstname' => $firstname,
						'lastname' => $lastname,
						'email' => $email,
						'address' => $address,
						'no_telp' => $data['no_telp'],
						'main_meter' => $data['main_meter'],
						'id_pel' => $data['id_pel']
					);
					
					$this->session->set_userdata('l0g_i5m', $sess_array);
					
					redirect('user/edit_profile', 'refresh');
				}elseif($set_acc){
					$old = $this->input->post('old_p');
					$new = $this->input->post('new_p');
					
					$this->user_m->update_password($old, $new, $data['mem_id']);
					
					redirect('user/edit_profile', 'refresh');
				}
			}
		}else{
			redirect('home', 'refresh');
		}
	}
	
	function set_interval()
	{
		if ($this -> session -> userdata('l0g_i5m')) {
			$data = $this->data;
			
			$this->load->library('form_validation');
		
			$this->form_validation->set_message('required', '%s tidak boleh kosong');
			$this->form_validation->set_message('min_length', '%s kurang dari %s karakter');
			
			//$this->form_validation->set_rules('id_meter', 'No Meter', 'trim|required|xss_clean|min_length[11]');
			$this->form_validation->set_rules('interval', 'Interval', 'trim|required|xss_clean');
			
			if($this->form_validation->run() == FALSE)
			{
				$data['warn'] = '';	
				
				$det = $this->user_m->select_detmet($data['main_meter']);
				$data['interval'] = $det[0]['job_interval'];
				//echo $data['met'].$data['interval'];
				$data['title'] = 'Interval Setting';
				$data['sub_content'] = 'pgn/set_interval';
				$this->load->view('template_index', $data);
			}else{
				//$data['met'] = $this->input->post('id_meter');
				$data['interval'] = $this->input->post('interval');
				$interval = 3600000 * $data['interval'];
				
				//echo 'lewat';
				//if($data['met'] == $data['main_meter']){
					$id_transaksi = $this->user_m->insert_transaksi('set_interval', $data['main_meter'], '', '', '', $data['mem_id']);
					
					//select type meter
					$met_type = $this->user_m->select_typemeter($data['main_meter']);
					
					//post parameter
					$post = 'tx_id='.$id_transaksi.'&meter_id='.$data['main_meter'].'&tipe_meter='.$met_type[0]['meter_type'].'&tipe_pu=1&alert_interval='.$interval;
					//$link = $this->ul.'?';
					$send = $this->send_api($this->ul.'request-newinterval', $post, 1);
					
					if($send == 1){
						//$exe = $this->check_db($id_transaksi, 1);
						//echo $id_met.' - '.$token;
						$interval = $this->user_m->select_detmet($data['main_meter']);
						$data['interval'] = $interval[0]['job_interval'];
						
						$data['warn'] = '<div class="alert alert-success">Perubahan Berhasil</div>';
					}else{
						$data['warn'] = '<div class="alert alert-danger">Perubahan Gagal</div>';
					}
					
					$data['title'] = 'Interval Setting';
					$data['sub_content'] = 'pgn/set_interval';
					$this->load->view('template_index', $data);
					
				//}else{
				//	redirect(404, 'refresh');
				//}
			}
		}else{
			redirect('home', 'refresh');
		}
	}
	
	function set_alarm()
	{
		if ($this -> session -> userdata('l0g_i5m')) {
			$data = $this->data;
			
			$this->load->library('form_validation');
		
			$this->form_validation->set_message('required', '%s tidak boleh kosong');
			$this->form_validation->set_message('min_length', '%s kurang dari %s karakter');
			
			$this->form_validation->set_rules('id_meter', 'No Meter', 'trim|required|xss_clean|min_length[11]');
			$this->form_validation->set_rules('alarm', 'Balance Limit', 'trim|required|xss_clean');
			
			if($this->form_validation->run() == FALSE)
			{
				$data['warn'] = '';	
				
				//$data['met'] = $this->input->post('id_meter');
				$det = $this->user_m->select_detmet($data['main_meter']);
				$data['alarm'] = $det[0]['alarm'];
				
				$data['title'] = 'Alarm Setting';
				$data['sub_content'] = 'pgn/set_alarm';
				$this->load->view('template_index', $data);
			}else{
				$data['met'] = $this->input->post('id_meter');
				$data['alarm'] = $this->input->post('alarm');
				
				//if($data['met'] == $data['main_meter']){
					$id_transaksi = $this->user_m->insert_transaksi('set_alarm', $data['main_meter'], '', '', '', $data['mem_id']);
					
					//select type meter
					$met_type = $this->user_m->select_typemeter($data['main_meter']);
					
					//post parameter
					$post = 'tx_id='.$id_transaksi.'&meter_id='.$data['main_meter'].'&tipe_meter='.$met_type[0]['meter_type'].'&tipe_pu=1&set_alarm=1&lim_kredit='.$data['alarm'];
					//$link = $this->ul.'?';
					$send = $this->send_api($this->ul.'request-limkredit', $post, 1);
					
					if($send == 1){
						$exe = $this->check_db($id_transaksi, 1);
						//echo $id_met.' - '.$token;
						$detmet = $this->user_m->select_detmet($data['main_meter']);
						$data['alarm'] = $detmet[0]['alarm'];
						
						$data['warn'] = '<div class="alert alert-success">Perubahan Berhasil</div>';
					}else{
						$data['warn'] = '<div class="alert alert-danger">Perubahan Gagal</div>';
					}
					
					$data['title'] = 'Alarm Setting';
					$data['sub_content'] = 'pgn/set_alarm';
					$this->load->view('template_index', $data);
					
				//}else{
				//	redirect(404, 'refresh');
				//}
			}
		}else{
			redirect('home', 'refresh');
		}
	}
	
	private function curl_get($url,$post)
	{
		//$username = 'admin';  
		//$password = '1234';
		//$header[] = "MARS-API-KEY: xxxxxxxxxxxxxxxxxxxxxxxxxxx";
		
	    $options = array(
		    CURLOPT_URL             => $url,
		    CURLOPT_RETURNTRANSFER  => true,
		    CURLOPT_POST            => true,
	        CURLOPT_POSTFIELDS      => $post
	        //CURLOPT_HTTPAUTH		=> CURLAUTH_DIGEST,
   			//CURLOPT_USERPWD 		=> $username.':'.$password,
        	//CURLOPT_HTTPHEADER	=> $header,
        	//CURLOPT_HEADER		=> 0
        	//CURLOPT_SSL_VERIFYPEER  => false,
        );
	
	    $ch      = curl_init();
	    curl_setopt_array($ch, $options);
	    $content = curl_exec($ch);
	    curl_close($ch);
	
	    return $content;
	}
	
	private function send_api($link, $svar, $jum)
	{
		$try = $this->curl_get($link, $svar);
		//echo 'eksekusi ke : '.$jum.'<br/>';
		
		if($try == 0 && $jum <= 6){
			$jum++;
			sleep(10); //cek tiap xx detik
			$this->send_api($link, $jum);
		}else{
			return $try;
		}
	}
	
	private function check_db($id_transaksi, $jum2)
	{
		$jum_check = 10;
		$jeda = 3;
		for($i=0; $i<$jum_check;$i++){
			$try = $this->user_m->select_transaksi($id_transaksi);
			//echo 'eksekusi_db ke : '.$jum2.' hasil => '.$try[0]['status'].'<br/>';
			if($try[0]['status'] != 0) break;
			sleep($jeda);
		}
		
		return $try;
		
		
		
		/*if($try[0]['status'] == 0 && $jum2 <= 20){
			$jum2++;
			sleep(3); //cek tiap xx detik
			return $this->check_db($id_transaksi, $jum2);
		}else{
			return $try;
		}*/
	}
	
	private function create_paging($per_page, $base, $jum, $seg){
		$this -> load -> library('pagination');
		
		$config['per_page'] = $per_page;
			
		$config['base_url'] = $base;
		$config['total_rows'] = $jum;

		$config['full_tag_open'] = '<div class="wrap_pagination"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></div>';
		$config['first_link'] = '&laquo;';
		$config['last_link'] = '&raquo;';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&larr;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&rarr;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li><a style="background:#ddd; font-weight:bold;" href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['uri_segment'] = $seg;

		$this -> pagination -> initialize($config);

		return $this -> pagination -> create_links();
	}
		
}
?>