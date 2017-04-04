<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class User extends CI_Controller {
		
	private $ul = 'http://192.168.0.11:8080/Integration/';
	
	function __construct()
  	{
	    parent::__construct();
		$session_data = $this -> session -> userdata('l0g_i5m');
		if ($session_data) {
			if($session_data['service'] == 1 || $session_data['service'] == 3){
				$last_bal = $this->user_m->last_meter_data($session_data['main_meter']);
				if($last_bal) $split =  substr($last_bal[0]['BALANCE_KWH'], 0); else $split = '000000.00';


			
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
					'met_type' => $session_data['met_type'],
					'pel_type' => $session_data['pel_type'],
					'id_pel' => $session_data['id_pel'],
					'balance_now' => str_split($split),
					'sess_act' => true,
					'act_uti' => $session_data['act_uti'],
					'content' => 'user/sidebar'
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
			$data['topup_his_lim'] = $this->user_m->last_topup_history($data['main_meter']);
			$data['topup_his'] = $this->user_m->topup_history($data['main_meter']);
			$data['total_usage'] = $this->user_m->total_usage($data['main_meter']);
			
			$data['title'] = 'Profile';
			$data['sub_content'] = 'user/profile';
			//echo '<pre>';print_r($data);echo '</pre>';
			$this->load->view('template_index', $data);
		}else{
			redirect('home', 'refresh');
		}
	}
	
	function alert()
	{
		if ($this -> session -> userdata('l0g_i5m')) {
			$data = $this->data;
			
			$data['warn'] = '';	
			$data['alert_token'] = $this->user_m->all_alert($data['main_meter'], 0);
			$data['alert_limit'] = $this->user_m->all_alert($data['main_meter'], 1);
			$data['alert_power'] = $this->user_m->all_alert($data['main_meter'], 5);
			
			$data['title'] = 'Alert Notifications';
			$data['sub_content'] = 'user/alert';
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
			
			$this->form_validation->set_rules('id_meter', 'No Meter', 'trim|required|xss_clean|max_length[11]');
			
			if($this->form_validation->run() == FALSE)
			{
				$data['warn'] = '';	
				$data['all_meter'] = $this->user_m->all_meter($data['mem_id']);
				
				$data['title'] = 'Profile';
				$data['sub_content'] = 'user/meter_list';
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
				$data['sub_content'] = 'user/meter_list';
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
			$data['sub_content'] = 'user/topup';
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
			$id_transaksi = $this->user_m->insert_transaksi('topup', $id_met, $token, '', '', $data['mem_id'],'','');
			//$id_transaksi = '11111';
			//select type meter
			$met_type = $this->user_m->select_typemeter($id_met);
			
			//send to MD & get status topup
			$post = 'tx_id='.$id_transaksi.'&no_token='.$token.'&meter_id='.$id_met.'&tipe_meter='.$met_type[0]['meter_type'].'&tipe_pu=1';
			//$link = $this->ul.'?';
			$send = $this->send_api($this->ul.'request-token', $post, 1);
			//$send = $this->send_api($link,1);
			
			if($send != 27){
				$exe = $this->check_db($id_transaksi, 1);
				//echo 'hasil keluar = '.print_r($exe).$exe[0]['status'];
				//echo $id_met.' - '.$token;
				if($exe[0]['status'] == 1 || $exe[0]['status'] == 0){
					$info = '<div class="col-md-1">
								<img src="'.base_url() . 'assets/img/icon/ico-success.png">
							</div>';
					if($exe[0]['status'] == 1){$bal = '<tr>
								<td width="30%"><strong>Balance Sekarang</strong></td>
								<td >'.$exe[0]['balance_kwh'].'</td>
							</tr>';}
				}else{
					$info = '<div class="col-md-1">
							<img src="'.base_url() . 'assets/img/icon/ico-fail.png">
						</div>
						';
				}
				if($exe[0]['status'] == 1 || $exe[0]['status'] == 0){
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
				}/*elseif($exe[0]['status'] == 0){
					$msg = 'Maaf, Komunikasi proses topup error';
					$stats = 'Komunikasi Error'; 
				}*/
				
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
			//echo 'accessible';
			
			redirect('home', 'refresh');
		}
	}
	
	function topup_history()
	{
		if ($this -> session -> userdata('l0g_i5m')) {
			$data = $this->data;

			$data['all_meter'] = $this->user_m->all_meter($data['mem_id']);
			
			$meter = $this->input->get('id_meter');
			if($meter){
				$data['meter_act'] = $meter;
			}else{
				$data['meter_act'] = $data['main_meter'];
			}
				
			$data['topup_hist'] = $this -> user_m -> topup_history($data['meter_act']);
			//print_r($data['topup_hist']);
			$data['title'] = 'Top Up';
			$data['sub_content'] = 'user/topup_history';
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
								<td>'.$th->TOKEN.'</td>
								<td>'.$th->REQUEST_TIME.'</td>
								<td>'.$th->RESPONSE_TIME.'</td>
								<td>';
								
								if($th->STATUS == 1){
									$res .= 'Topup Sukses'; 
								}elseif($th->STATUS == 2){
									$res .= 'Token Terpakai'; 
								}elseif($th->STATUS == 3){
									$res .= 'Salah Token'; 
								}elseif($th->STATUS == 4){
									$res .= 'Token Usang'; 
								}elseif($th->STATUS == 5){
									$res .= 'Komunikasi Error'; 
								}elseif($th->STATUS == 0){
									$now = strtotime(Date('Y-m-d H:i:s')); 
									$req = strtotime($th->REQUEST_TIME);
									$diff = $now - $req;
									if($diff/3600 < 24) $res .= 'Pending'; else $res .= 'Topup Gagal';
								}
								$res .= '
							</td>
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
			$data['sub_content'] = 'user/meter_reading';
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
			$id_transaksi = $this->user_m->insert_transaksi('reading', $id_met, '', '', '', $data['mem_id'],'','');
			//$id_transaksi = '11111';
			//select type meter
			$met_type = $this->user_m->select_typemeter($id_met);
			
			//send to MD & get status topup
			$post = 'tx_id='.$id_transaksi.'&meter_id='.$id_met.'&tipe_meter='.$met_type[0]['meter_type'].'&tipe_pu=1';
			//$link = $this->ul.'?';
			$send = $this->send_api($this->ul.'request-meter', $post, 1);
			//$send = $this->send_api($link,1);
			
			if($send != 27){
				$exe = $this->check_db($id_transaksi, 1);
				//echo $id_met.' - '.$token;
				if($exe[0]['status'] == 1){
					$read = $this->user_m->select_reading($id_transaksi);
					$vR = floatval($read[0]['voltage_r']);
					$vS = floatval($read[0]['voltage_s']);
					$vT = floatval($read[0]['voltage_t']);
					
					$iR = floatval($read[0]['arus_r']);
					$iS = floatval($read[0]['arus_s']);
					$iT = floatval($read[0]['arus_t']);
					
					$phasor = "
					<script> 
					$(document).ready(function() {
					$('#phasor').highcharts({
	            
			chart: {
				polar: true
			},

			title: {
				text: 'Diagram Phasor'
			},
			pane: {
				startAngle: 90,
				endAngle: 450
			},
			xAxis: {
				min: 0,
				max: 360,
				lineWidth: 0,
				tickInterval: 120,
				labels: {enabled: true}
			}, 
			yAxis: {
				gridLineInterpolation: 'circle',
				lineWidth: 0,
				min: 0,
				max: 265,
				tickInterval: 265,
				labels: { enabled: true }
			},
			tooltip: {
				shared: true,
				pointFormat: '<span style=\"color:{series.color}\">{series.name}: <b>{point.y:,.0f}</b><br/>'
			},
			plotOptions: {
				series: {
				   grouping: true,
					groupPadding:0,
					pointPadding:0,
					borderColor: '#000',
					borderWidth: '0',
					stacking: 'normal',
					pointPlacement: 'on',
					showInLegend: true,

				},
				line:{
					marker: {
						enabled: false,
					}
				}
			},
			
			legend: {
				layout: 'horizontal'
			},
			
			series: [{
				name: 'VR',
				type: 'line',
				color: '#ff0000',
				lineWidth: 3,
				pointStart: -1,
				data: [0, ".$vR."]
			}, {
				name: 'IR',
				type: 'line',
				color: '#ff0000',
				lineWidth: 3,
				pointStart: 20,
				data: [0, ".($iR)."]
			}";
			if($vS != 0 || $iS != 0){
			$phasor .="
			,{
			   name: 'VS',
				type: 'line',
				color: '#3000ff',
				lineWidth: 3,
				pointStart: 119,
				data: [0, ".$vS."]
			},{
				name: 'IS',
				type: 'line',
				color: '#3000ff',
				lineWidth: 3,
				pointStart: 150,
				data: [0, ".($iS)."1]
			}";}
			if($vT != 0 || $iT != 0){
			$phasor .="
			, {
				name: 'VT',
				type: 'line',
				color: '#33b50b',
				lineWidth: 3,
				pointStart: 239,
				data: [0, ".$vT."]
			},{
				name: 'IT',
				type: 'line',
				color: '#33b50b',
				lineWidth: 3,
				pointStart: 265,
				data: [0, ".($iT)."]
			}";}
			$phasor .="
			]
		
		});
		});
		</script> ";
					$isi = '
				<div class="col-md-5">
					<div class="well info-usage">
						<p>Balance</p>
						<span class="balance-wrap">
						<strong>'.$read[0]['balance_kwh'].'</strong> kwh
						</span>
						
						<p>Meter ID for</p>
						<span class="meterid-wrap">
							<strong>'.$id_met.'</strong>
						</span>
						
						<table class="table tab-inside-well">
						  <tr>
							<td class="label" >Power Factor</td>
							<td>'.$read[0]['power_factor'].'</td>
						  </tr>
						  <tr>
							<td class="label">Daya instant</td>
							<td>'.$read[0]['daya_instan'].'</td>
						  </tr>
						  <tr>
							<td class="label">Tarif Index</td>
							<td>'.$read[0]['tarif_index'].'</td>
						  </tr>
						  <tr>
							<td class="label">Status Temper</td>
							<td>'.$read[0]['status_tamper'].'</td>
						  </tr>
						  <tr>
							<td class="label">Prediksi Kredit Habis</td>
							<td>'.$read[0]['prediksi_kredit_habis'].'</td>
						  </tr>
						  
						</table>
					</div>
											
			</div>
			<div class="col-md-7">';
			//if($vR != 0 && $vS != 0 && $vT !=0 && $iR != 0 && $iS != 0 && $iT !=0){
				$isi .= '<div id="phasor" style="width: 462px; height: 400px; margin: 10px 0 10px 0	"></div>';
			//}
			$isi .='		<table class="table table-striped tab-det-usage">
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
					  	<td>'.substr_replace($read[0]['sudutIV_r'], '.', 2, 0).'</td>
					  	<td>'.substr_replace($read[0]['sudutIV_s'], '.', 2, 0).'</td>
					  	<td>'.substr_replace($read[0]['sudutIV_t'], '.', 2, 0).'</td>
					  </tr>
					  <tr>
					  	<td>Cosphi</td>
					  	<td>'.round(cos(floatval(substr_replace($read[0]['sudutIV_r'], '.', 2, 0))),3).'</td>
					  	<td>'.round(cos(floatval(substr_replace($read[0]['sudutIV_s'], '.', 2, 0))),3).'</td>
					  	<td>'.round(cos(floatval(substr_replace($read[0]['sudutIV_t'], '.', 2, 0))),3).'</td>
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
				';
				//if($vR != 0 && $vS != 0 && $vT !=0 && $iR != 0 && $iS != 0 && $iT !=0){
				$html = $phasor.$isi;
				//}else{
				//$html = $isi;
				//}
				
				}else{
				$html = '
						<div class="col-md-1">
							<img src="'.base_url().'assets/img/icon/ico-fail.png">
						</div>
						<div class="col-md-8">
							<h4>Maaf, Realtime Meter Reading gagal dilakukan</h4>
							<p>Silahkan coba kembali, klik <a href="'.site_url("user/meter_reading").'">disini</a> untuk mencoba lagi</p>
							
						</div>
						<div class="clearfix"></div>
						';
				}
				
			}else{
				$html = '
						<div class="col-md-1">
							<img src="'.base_url().'assets/img/icon/ico-fail.png">
						</div>
						<div class="col-md-8">
							<h4>Maaf, Realtime Meter Reading gagal dilakukan</h4>
							<p>Silahkan coba kembali, klik <a href="'.site_url("user/meter_reading").'">disini</a> untuk mencoba lagi</p>
							
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
				$data['sub_content'] = 'user/meter_reading_history';
				$this->load->view('template_index', $data);
			}else{
				$data['met'] = $this->input->post('id_meter');
				//$sdate = date('Y-m-d',strtotime($this->input->post('sdate')));
				//$edate = date('Y-m-d',strtotime($this->input->post('edate')));
				//$sdate = $this->input->post('sdate');
				//$edate = $this->input->post('edate');
				$data['sdate'] = $this->input->post('sdate');
				$data['edate'] = $this->input->post('edate');
				//echo date('Y-m-d',strtotime($this->input->post('sdate') . "-1 days"));
				//$id_transaksi = $this->user_m->insert_transaksi('met_his', $data['met'], '', $data['sdate'], $data['edate'], $data['mem_id'],'','');
			
				//select type meter
				$met_type = $this->user_m->select_typemeter($data['met']);
				
				//post parameter
				$post = 'meter_id='.$data['met'].'&tipe_meter='.$met_type[0]['meter_type'].'&tipe_pu=1'.'&start_date='.$data['sdate'].'&end_date='.$data['edate'];
				//$link = $this->ul.'?';
				//echo $post;				
				$json = $this->curl_get($this->ul.'request-meterhistory', $post);
				//print_r(json_decode($send));
										
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
				
				//print_r($data['arr']);
				$cek = $data['arr'];
				//echo($cek[0][0]);
				foreach ($data['arr'] as $all) {
					//$xaxis[] = date("j M y H:i:s", (($all->timeStamp/1000)+54000));
					$xaxis[] = date("j M y H:i:s", strtotime($all->timeStamp));
					$bal[] = floatval($all->balanceKWH);
					$total[] = floatval($all->totalUsage);
					$vR[] = floatval($all->voltageR);
					$vS[] = floatval($all->voltageS);
					$vT[] = floatval($all->voltageT);
					$iR[] = floatval($all->arusR);
					$iS[] = floatval($all->arusS);
					$iT[] = floatval($all->arusT);
				}
				//print_r($bal);
				$data['categories'] = json_encode($xaxis);
				//print_r($data['categories']);
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
				$data['sub_content'] = 'user/meter_reading_history';
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
				$data['sub_content'] = 'user/premium';
				$this->load->view('template_index', $data);
			}else{
				$met = $this->input->post('id_meter');
				$id_pel = $this->input->post('id_pel');
				$no_hp = $this->input->post('no_hp');
				
				$id_premium = $this->user_m->insert_premium($met, $id_pel, $no_hp, $data['mem_id']);
				
				$data['met'] = '';
				$data['id_pel'] = '';
				$data['no_hp'] = '';
				
				$data['warn'] = '<div class="alert alert-success">Perubahan Berhasil</div>';
				
				$data['title'] = 'Premium Member';
				$data['sub_content'] = 'user/premium';
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
				$data['sub_content'] = 'user/edit_profile';
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
				$data['sub_content'] = 'user/set_interval';
				$this->load->view('template_index', $data);
			}else{
				//$data['met'] = $this->input->post('id_meter');
				$data['interval'] = $this->input->post('interval');
				$interval = 1000 * $data['interval'];
				
				//echo 'lewat';
				//if($data['met'] == $data['main_meter']){
					$id_transaksi = $this->user_m->insert_transaksi('set_interval', $data['main_meter'], '', '', '', $data['mem_id'], $interval, '');
					//$id_transaksi = '1111111111';
					//select type meter
					$met_type = $this->user_m->select_typemeter($data['main_meter']);
					
					//post parameter
					$post = 'tx_id='.$id_transaksi.'&meter_id='.$data['main_meter'].'&tipe_meter='.$met_type[0]['meter_type'].'&tipe_pu=1&alert_interval='.$interval;
					//$link = $this->ul.'?';
					$send = $this->send_api($this->ul.'request-newinterval', $post, 1);
					
					//echo $send;
					if($send != 27){
						//echo 'cek';
						//$exe = $this->check_db($id_transaksi, 1);
						//echo $id_met.' - '.$token;
						//if($exe[0]['status'] == 1){
							//$detmet = $this->user_m->select_detmet($data['main_meter']);
							//echo $interval;
							$data['interval'] = $interval;
							
							$data['warn'] = '<div class="alert alert-success">Perubahan Berhasil</div>';
						/*}else{
							$data['warn'] = '<div class="alert alert-danger">Perubahan Gagal</div>';
						}*/
					}else{
						$data['warn'] = '<div class="alert alert-danger">Perubahan Gagal</div>';
					}
					
					$data['title'] = 'Interval Setting';
					$data['sub_content'] = 'user/set_interval';
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
			
			//$this->form_validation->set_rules('id_meter', 'No Meter', 'trim|required|xss_clean|min_length[11]');
			$this->form_validation->set_rules('alarm', 'Balance Limit', 'trim|required|xss_clean');
			
			if($this->form_validation->run() == FALSE)
			{
				$data['warn'] = '';	
				
				//$data['met'] = $this->input->post('id_meter');
				$det = $this->user_m->select_detmet($data['main_meter']);
				$data['alarm'] = $det[0]['alarm'];
				
				$data['title'] = 'Alarm Setting';
				$data['sub_content'] = 'user/set_alarm';
				$this->load->view('template_index', $data);
			}else{
				$data['met'] = $this->input->post('id_meter');
				$alarm = $this->input->post('alarm');
				
				//if($data['met'] == $data['main_meter']){
					$id_transaksi = $this->user_m->insert_transaksi('set_alarm', $data['main_meter'], '', '', '', $data['mem_id'],'', $alarm);
					//$id_transaksi = '1111111111';
					//select type meter
					$met_type = $this->user_m->select_typemeter($data['main_meter']);
					
					//post parameter
					$post = 'tx_id='.$id_transaksi.'&meter_id='.$data['main_meter'].'&tipe_meter='.$met_type[0]['meter_type'].'&tipe_pu=1&set_alarm=1&lim_kredit='.$alarm;
					//$link = $this->ul.'?';
					$send = $this->send_api($this->ul.'request-limkredit', $post, 1);
					
					if($send != 27){
						$exe = $this->check_db($id_transaksi, 1);
						//echo $id_met.' - '.$token;
						if($exe[0]['status'] == 1){
							$detmet = $this->user_m->select_detmet($data['main_meter']);
							$data['alarm'] = $detmet[0]['alarm'];
							
							$data['warn'] = '<div class="alert alert-success">Perubahan Berhasil</div>';
						}else{
							$data['warn'] = '<div class="alert alert-danger">Perubahan Gagal</div>';
						}
					}else{
						$data['warn'] = '<div class="alert alert-danger">Perubahan Gagal</div>';
					}
					
					$data['title'] = 'Alarm Setting';
					$data['sub_content'] = 'user/set_alarm';
					$this->load->view('template_index', $data);
					
				//}else{
				//	redirect(404, 'refresh');
				//}
			}
		}else{
			redirect('home', 'refresh');
		}
	}
	
	//command for postpaid remote
	function instantaneous()
	{
		if ($this -> session -> userdata('l0g_i5m')) {
			$data = $this->data;

			$data['all_meter'] = $this->user_m->all_meter($data['mem_id']);
			
			$data['all_meter_data'] = $this->user_m->all_meter_data($data['main_meter']);
			
			$data['title'] = 'Instantaneous';
			$data['sub_content'] = 'user/instantaneous';
			$this->load->view('template_index', $data);
		}else{
			redirect('home', 'refresh');
		}
	}
	
	function instantaneous_exe()
	{
		if ($this -> session -> userdata('l0g_i5m')) {
			$data = $this->data;

			$id_met = $this->input->post('meter');
			
			//insert_db
			$id_transaksi = $this->user_m->insert_transaksi('instanta', $id_met, '', '', '', $data['mem_id'],'','');
			//select type meter
			$met_type = $this->user_m->select_typemeter($id_met);
			
			//send to MD & get status topup
			$post = 'tx_id='.$id_transaksi.'&meter_id='.$id_met.'&tipe_meter='.$met_type[0]['meter_type'].'&tipe_pu=1';
			//$link = $this->ul.'?';
			$send = $this->send_api($this->ul.'request-meter', $post, 1);
			//$send = $this->send_api($link,1);
			
			if($send != 27){
				$exe = $this->check_db($id_transaksi, 1);
				//echo $id_met.' - '.$token;
				if($exe[0]['status'] == 1){
					$read = $this->user_m->select_reading($id_transaksi);
					$hexa = $read[0]['hexa_msg'];
					
					$isi = '
				<div class="col-md-5">
					<div class="well info-usage">
						<p>Hexa Message</p>
						<p>'.$hexa.'</p>
					</div>
				</div>
			
				<div class="clearfix"></div>
				';
				$html = $isi;
				
				
				}else{
				$html = '
						<div class="col-md-1">
							<img src="'.base_url().'assets/img/icon/ico-fail.png">
						</div>
						<div class="col-md-8">
							<h4>Maaf, Instantaneous Reading gagal dilakukan</h4>
							<p>Silahkan coba kembali, klik <a href="'.site_url("user/instantaneous").'">disini</a> untuk mencoba lagi</p>
							
						</div>
						<div class="clearfix"></div>
						';
				}
				
			}else{
				$html = '
						<div class="col-md-1">
							<img src="'.base_url().'assets/img/icon/ico-fail.png">
						</div>
						<div class="col-md-8">
							<h4>Maaf, Instantaneous Reading gagal dilakukan</h4>
							<p>Silahkan coba kembali, klik <a href="'.site_url("user/instantaneous").'">disini</a> untuk mencoba lagi</p>
							
						</div>
						<div class="clearfix"></div>
						';
			}
			echo $html;
		}else{
			redirect('home', 'refresh');
		}
	}
	
	function load_profile()
	{
		if ($this -> session -> userdata('l0g_i5m')) {
			$data = $this->data;

			$data['all_meter'] = $this->user_m->all_meter($data['mem_id']);
			
			$data['all_meter_data'] = $this->user_m->all_meter_data($data['main_meter']);
			
			$data['title'] = 'Load Profile';
			$data['sub_content'] = 'user/load_profile';
			$this->load->view('template_index', $data);
		}else{
			redirect('home', 'refresh');
		}
	}
	
	function loadprof_exe()
	{
		if ($this -> session -> userdata('l0g_i5m')) {
			$data = $this->data;

			$id_met = $this->input->post('meter');
			
			//insert_db
			$id_transaksi = $this->user_m->insert_transaksi('instanta', $id_met, '', '', '', $data['mem_id'],'','');
			//select type meter
			$met_type = $this->user_m->select_typemeter($id_met);
			
			//send to MD & get status topup
			$post = 'tx_id='.$id_transaksi.'&meter_id='.$id_met.'&tipe_meter='.$met_type[0]['meter_type'].'&tipe_pu=1';
			//$link = $this->ul.'?';
			$send = $this->send_api($this->ul.'request-meter', $post, 1);
			//$send = $this->send_api($link,1);
			
			if($send != 27){
				$exe = $this->check_db($id_transaksi, 1);
				//echo $id_met.' - '.$token;
				if($exe[0]['status'] == 1){
					$read = $this->user_m->select_reading($id_transaksi);
					$hexa = $read[0]['hexa_msg'];
					
					$isi = '
				<div class="col-md-5">
					<div class="well info-usage">
						<p>Hexa Message</p>
						<p>'.$hexa.'</p>
					</div>
				</div>
			
				<div class="clearfix"></div>
				';
				$html = $isi;
				
				
				}else{
				$html = '
						<div class="col-md-1">
							<img src="'.base_url().'assets/img/icon/ico-fail.png">
						</div>
						<div class="col-md-8">
							<h4>Maaf, Instantaneous Reading gagal dilakukan</h4>
							<p>Silahkan coba kembali, klik <a href="'.site_url("user/instantaneous").'">disini</a> untuk mencoba lagi</p>
							
						</div>
						<div class="clearfix"></div>
						';
				}
				
			}else{
				$html = '
						<div class="col-md-1">
							<img src="'.base_url().'assets/img/icon/ico-fail.png">
						</div>
						<div class="col-md-8">
							<h4>Maaf, Instantaneous Reading gagal dilakukan</h4>
							<p>Silahkan coba kembali, klik <a href="'.site_url("user/instantaneous").'">disini</a> untuk mencoba lagi</p>
							
						</div>
						<div class="clearfix"></div>
						';
			}
			echo $html;
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
		
		return $try;
		
		/*if($try == 27 && $jum <= 3){
			$jum++;
			sleep(10); //cek tiap xx detik
			return $this->send_api($link, $svar, $jum);
		}else{
			return $try;
		}*/
	}
	
	private function check_db($id_transaksi, $jum2)
	{
		$jum_check = 5;
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
	function logout() {
		$this -> session -> unset_userdata('l0g_i5m');
		session_destroy();
		redirect('home', 'refresh');
	}	
}
?>