<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Api extends REST_Controller
{
	private $link = 'https://api.telegram.org/bot';
	private $token = '280570152:AAHaYiv4CmI8f8sBHylHVym6XGEFxiE7XjM';
	
	function test_get()
	{
		$this->response(array('status' => true), 404);
	}


	function curl_get($url,$post)
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

	function curl_sms($post)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$this->url_sms);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$post);  //Post Fields
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$headers = array();
		$headers[] = "Content-Type: application/x-www-form-urlencoded";
		$headers[] = "Accept: application/json";
		$headers[] = "Authorization: Bearer f5a5afe0dc07914f5b7efd5205738fbc";

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$server_output = curl_exec ($ch);

		curl_close ($ch);	    
		return $server_output;
	}
	
	function curl_push($post)
	{
		//$username = 'admin';  
		//$password = '1234';
		$url = 'https://android.googleapis.com/gcm/send';
		$header = array(
			'Authorization: key='.$this->google_API,
			'Content-Type: application/json',
		);
		
	    $options = array(
		    CURLOPT_URL             => $url,
		    CURLOPT_RETURNTRANSFER  => true,
		    CURLOPT_POST            => true,
	        CURLOPT_POSTFIELDS      => json_encode($post),
	        //CURLOPT_HTTPAUTH		=> CURLAUTH_DIGEST,
   			//CURLOPT_USERPWD 		=> $username.':'.$password,
        	CURLOPT_HTTPHEADER	=> $header,
        	//CURLOPT_HEADER		=> 0
			CURLOPT_SSL_VERIFYHOST  => 0,
        	CURLOPT_SSL_VERIFYPEER  => false,
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
		//echo 'eksekusi ke : '.$jum;
		
		return $try;
		
		/*if($try == 0 && $jum <= 6){
			$jum++;
			sleep(10);
			return $this->send_api($link, $svar, $jum);
		}else{
			return $try;
		}*/
	}
	
	function registrasi_post()
	{
		$nd_reg = $this->post('nama_depan');
		$nb_reg = $this->post('nama_belakang');
		$indihome_reg = $this->post('id_indihome');
		$meter_reg = $this->post('no_meter');
		$mac_reg = $this->post('mac_address');
		$alamat_reg = $this->post('address');
		$email_reg = $this->post('email');
		$hp_reg = $this->post('no_telp');
		
		if(!$nd_reg || !$indihome_reg || !$meter_reg || !$mac_reg || !$alamat_reg || !$email_reg || !$hp_reg){
			$this->response(array('status' => false), 404);
		}else{
			$met_type = 2;
			$pel_type = 1;
			$pu_type = 1;
			$lat_pel = 0;
			$long_pel = 0;
			$provider = 1;

				$data['stats'] = '<div class="alert alert-success">Registrasi Berhasil</div>';
				
				$length1 = 8;
				$key_chars = 'abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ0123456789';
				$rand_max = strlen($key_chars) - 1;

				for ($i = 0; $i < $length1; $i++) {
					$rand_pos = rand(0, $rand_max);
					$rand_key[] = $key_chars{$rand_pos};

					$rand_pwd = rand(0, $rand_max);
					$rand_pwd2[] = $key_chars{$rand_pwd};
				}

				$pwd = implode('', $rand_pwd2);
				
				//insert_db
				$idn = $this->root->insert_meter($indihome_reg, $meter_reg, $mac_reg, $nd_reg, $nb_reg, $alamat_reg, $email_reg, $lat_pel, $long_pel, $hp_reg, $met_type, $pel_type, 1, $provider, $pwd);
				
				$this->response(array('status' => true), 404);
			// }else{
			// 	$this->response(array('status' => false), 404);
			// }
		}
	}	

	function login_post()
    {
    	$user = $this->post('username');
    	$pwd = $this->post('password');
		$reg = $this->post('reg_id');

	   	if(!$user || !$pwd || !$reg)
        {
        	$this->response(array('status' => false), 404);
        }else{	
		   	$result = $this->root->login_andro($user, $pwd, $reg);
				
			if($result){
				foreach($result as $pp){
					$pp->status = true;
				}
				$this->response($result, 200); // 200 being the HTTP response code
			}else{
				$this->response(array('status' => false), 404);
			}
		}
	}

	function list_meter_post()
	{
		$uid = $this->post('uid');
		
		if(!$uid)
        {
        	$this->response(array('status' => false), 404);
        }else{	
			$result = $this->user_m->all_meter($uid);

			foreach($result as $pp){
				if($pp->main == 1){
					$pp->status = 'main';
				}else{
					$pp->status = 'secondary';
				}
				unset($pp->main);

				$lst = $this->user_m->last_meter_data($pp->no_meter);

				if($lst){
					$pp->last_balance = $lst['0']['BALANCE_KWH'];
				}else{
					$pp->last_balance = '000000.00';
				}
			}

			$this->response($result, 200); // 200 being the HTTP response code
		}
	}

	function info_pelanggan_post()
	{
		$uid = $this->post('uid');
		
		if(!$uid)
        {
        	$this->response(array('status' => false), 404);
        }else{	
			$result = $this->user_m->info_pelanggan($uid);

			$this->response($result, 200); // 200 being the HTTP response code
		}
	}

	function summary_info_post()
	{
		$mid = $this->post('meter_id');
		
		if(!$mid)
        {
        	$this->response(array('status' => false), 404);
        }else{	
			$lst = $this->user_m->last_meter_data($mid);

			$result = array();

			if($lst){
				$idpel = $this->user_m->get_idpel($mid);
				foreach($lst as $pp){
					$result['meter_id'] = $mid;
					$result['id_pelanggan'] = $idpel['0']['id_pelanggan'];
					$result['balance_kwh'] = $lst['0']['BALANCE_KWH'];
					$result['total_usage'] = $lst['0']['TOTAL_USAGE'];
					$result['voltage_r'] = $lst['0']['VOLTAGE_R'];
					$result['voltage_s'] = $lst['0']['VOLTAGE_S'];
					$result['voltage_t'] = $lst['0']['VOLTAGE_T'];
					$result['arus_r'] = $lst['0']['ARUS_R'];
					$result['arus_s'] = $lst['0']['ARUS_S'];
					$result['arus_t'] = $lst['0']['ARUS_T'];
					$result['time'] = date("j M Y H:i:s", strtotime($lst['0']['TIME_STAMP']));
				}

				$this->response($result, 200); // 200 being the HTTP response code
			}else{
				$this->response(array('status' => false), 200);
			}
		}
	}
	
	function meter_reading_post()
	{
		$uid = $this->post('uid');
		$mid = $this->post('meter_id');
		
		if(!$uid || !$mid)
        	{
        	$this->response(array('status' => false), 404);
        }else{
        	
					$lst = $this->user_m->last_meter_data($mid);

					$result = array();

					foreach($lst as $pp){
						$result['meter_id'] = $mid;
						$result['balance_kwh'] = $lst['0']['BALANCE_KWH'];
						$result['total_usage'] = $lst['0']['TOTAL_USAGE'];
						$result['voltage_r'] = $lst['0']['VOLTAGE_R'];
						$result['voltage_s'] = $lst['0']['VOLTAGE_S'];
						$result['voltage_t'] = $lst['0']['VOLTAGE_T'];
						$result['arus_r'] = $lst['0']['ARUS_R'];
						$result['arus_s'] = $lst['0']['ARUS_S'];
						$result['arus_t'] = $lst['0']['ARUS_T'];
						$result['power_factor'] = $lst['0']['POWER_FACTOR'];
						$result['daya_instan'] = $lst['0']['DAYA_INSTANT'];
						$result['sudut_r'] = $lst['0']['SUDUTIV_R'];
						$result['sudut_s'] = $lst['0']['SUDUTIV_S'];
						$result['sudut_t'] = $lst['0']['SUDUTIV_T'];
						$result['time'] = date("j M Y H:i:s", strtotime($lst['0']['TIME_STAMP']));
					}

					$this->response($result, 200); // 200 being the HTTP response code
				}
	}

	function usage_history_post()
	{
		$mid = $this->post('meter_id');
		$start_date = $this->post('start_date');
		$end_date = $this->post('end_date');
		$limit = $this->post('limit');
		$offset = $this->post('offset');
		
		if(!$mid)
        {
        	$this->response(array('status' => false), 404);
        }else{
        	$tpp = $this->user_m->meter_data($mid, $start_date, $end_date, $limit, $offset);
			
			$result = array();

			if($tpp){
				$j=0;
				foreach($tpp as $pp){
					$result[$j]['meter_id'] = $mid;
					$result[$j]['time'] = date("j M Y H:i:s", strtotime($pp->TIME_STAMP));
					$result[$j]['balance_kwh'] = $pp->BALANCE_KWH;
					$result[$j]['total_usage'] = $pp->TOTAL_USAGE;
					$result[$j]['voltage_r'] = $pp->VOLTAGE_R;
					$result[$j]['voltage_s'] = $pp->VOLTAGE_S;
					$result[$j]['voltage_t'] = $pp->VOLTAGE_T;
					$result[$j]['arus_r'] = $pp->ARUS_R;
					$result[$j]['arus_s'] = $pp->ARUS_S;
					$result[$j]['arus_t'] = $pp->ARUS_T;
					$j++;
				}

				$this->response($result, 200); // 200 being the HTTP response code
			}else{
				$this->response(array('status' => "No data"), 200);
			}
		}
	}
	
	function topup_post()
    {
		$uid = $this->post('uid');
		$id_met = $this->post('meter_id');
		$token = $this->post('token');
		$trx_type = $this->post('trx_type');
		
		if(!$uid || !$id_met || !$token || !$trx_type){
		   	$this->response('0', 404);
		}else{
			if(strlen($id_met) == 11 && strlen($token) == 20){
				$msg = array();
				$avail = $this->user_m->select_typemeter($id_met);
				if($avail){
					//send to MD & get status topup
					$post = 'no_token='.$token.'&meter_id='.$id_met.'&tipe_meter='.$avail[0]['TIPE_METER'].'&tipe_pu=1'.'&user_id='.$uid;
					
					$send = $this->send_api($this->ul.'request-token', $post, 1);
					//$send = $this->send_api($link,1);
					$now =  date("Y-m-d H:i:s",time()-400);

					if($send > 90000 && $send != ''){
						//$exe = $this->check_db($id_transaksi, 1);
						$id_transaksi = $send;
						
						$stats = 'Success'; 
									
						$msg['response'] = '00';
						$msg['trx_id_ism'] = $id_transaksi;
						$msg['trx_type'] = $trx_type;
						$msg['desc'] = $stats;
						/*if($exe){
							if($exe[0]['STATUS'] == 0){
								$hasil = $this->user_m->select_topup($send, $id_met, $now);
								if($hasil[0]['STATUS'] == 1){
									$stats = 'Success'; 
									
									$msg['response'] = '00';
									$msg['trx_id_ism'] = $id_transaksi;
									$msg['trx_type'] = $trx_type;
									$msg['desc'] = $stats;
								}elseif($hasil[0]['STATUS'] == 2){
									$stats = 'Token Terpakai'; 
									
									$msg['response'] = '88';
									$msg['trx_id_ism'] = $id_transaksi;
									$msg['trx_type'] = $trx_type;
									$msg['desc'] = $stats;
								}elseif($hasil[0]['STATUS'] == 3){
									$stats = 'Token Salah'; 
									
									$msg['response'] = '78';
									$msg['trx_id_ism'] = $id_transaksi;
									$msg['trx_type'] = $trx_type;
									$msg['desc'] = $stats;
								}elseif($hasil[0]['STATUS'] == 4){
									$stats = 'Maaf, Token Anda sudah tidak dapat digunakan lagi';
									
									$msg['response'] = '-';
									$msg['trx_id_ism'] = $id_transaksi;
									$msg['trx_type'] = $trx_type;
									$msg['desc'] = $stats;
								}elseif($hasil[0]['STATUS'] == 5){
									$stats = 'Maaf, Komunikasi proses topup error';
									
									$msg['response'] = '00';
									$msg['trx_id_ism'] = '-';
									$msg['trx_type'] = $trx_type;
									$msg['desc'] = $msg;
								}
							}elseif($exe[0]['STATUS'] == 27){
								$stats = 'Failed Transaction';
								
								$msg['response'] = '27';
								$msg['trx_id_ism'] = $id_transaksi;
								$msg['trx_type'] = $trx_type;
								$msg['desc'] = $stats;
							}
						}else{
							$stats = 'Network Error';
							
							$msg['response'] = '34';
							$msg['trx_id_ism'] = $id_transaksi;
							$msg['trx_type'] = $trx_type;
							$msg['desc'] = $stats;
						}*/
					}else{
						$msg['response'] = '0';
					}
				}else{
					$stats = $id_met . ' Not Smart Meter';
					
					$msg['response'] = '14';
					$msg['trx_id_ism'] = '-';
					$msg['trx_type'] = $trx_type;
					$msg['desc'] = $stats;
				}
				
				$this->response($msg, 200);
			}else{
				$this->response(array('response' => 0, 'desc' => 'failed'), 404);
			}
		}
	}
	
	function topup2_post()
    {
		$un = $this->post('username');
		$pw = $this->post('password');
		$id_met = $this->post('meter_id');
		$token = $this->post('token');
		$trx_id = $this->post('trx_id');
		$email = $this->post('email');
		$trx_type = $this->post('trx_type');

		if(!$un || !$pw || !$id_met || !$token || !$trx_id || !$email || !$trx_type){
		   $this->response(array('status' => 'failed'), 200);
		}else{
			if($un == 'andro' && $pw == 'i5m4andr0' && strlen($id_met) == 11 && strlen($token) == 20){
				//$user = $this->post('username');
				//$pwd = $this->post('password');
				//$this->response($pwd, 200);
				$html = '';
				$avail = $this->user_m->select_typemeter($id_met);
				if($avail){
					//insert_db
					$getid = $this->user_m->get_id($un, $pw);
					//$this->response($getid[0]['id_user'], 200);
					$id_transaksi = $this->user_m->insert_transaksi('topup', $id_met, $token, '', '', $getid[0]['id_user'],'','');
					//$id_transaksi = '1111111111';
					//select type meter
					$met_type = $this->user_m->select_typemeter($id_met);
					
					//send to MD & get status topup
					$post = 'tx_id='.$id_transaksi.'&no_token='.$token.'&meter_id='.$id_met.'&tipe_meter='.$met_type[0]['meter_type'].'&tipe_pu=1';
					//$link = $this->ul.'?';
					
					//$this->response($email, 200);
					//$send = $this->send_api($this->ul.'request-token', $post, 1);
					//$send = $this->send_api($link,1);
					

					if($send == 1){
						//$exe = $this->check_db($id_transaksi, 1);

						if($exe[0]['status'] == 1){
							$stats = 'Success'; 
							$msg = '00|trx_id='.$trx_id.'|trx_id_ism='.$id_transaksi.'|trx_type='.$trx_type.'|desc='.$stats;
							$html = 'DO NOT REPLY TO THIS EMAIL!<br/>
	***************************<br/>
	<br/>
	Pengisian pulsa listrik untuk meter '.$id_met.' Berhasil dilakukan<br/>
	Id Transaksi Delima='.$trx_id.'<br/>
	Id Transaksi ISM='.$id_transaksi.'<br/>
	<br/><br/>
	Balance kwh saat ini : '.$exe[0]['balance_kwh'].'<br/>
	<br/>
	Terima kasih
	<br/>
	Admin Integrated Smart Metering<br/>
	-Telkom RDC, Bandung-';
						}elseif($exe[0]['status'] == 2){
							$stats = 'Token Terpakai'; 
							$status = 88;
						}elseif($exe[0]['status'] == 3){
							$stats = 'Token Salah'; 
							$status = 78;
						}elseif($exe[0]['status'] == 4){
							$status = 'Maaf, Token Anda sudah tidak dapat digunakan lagi';
							$stats = 'Token Usang'; 
						}elseif($exe[0]['status'] == 5){
							$status = 'Maaf, Komunikasi proses topup error';
							$stats = 'Komunikasi Error';
							
						}elseif($exe[0]['status'] == 0){
							$stats = 'Network Error';
							$status = 34;
							$html = 'DO NOT REPLY TO THIS EMAIL!<br/>
	***************************<br/>
	<br/>
	Mohon Maaf Pengisian pulsa listrik untuk meter '.$id_met.' Gagal dilakukan karena Network Error<br/>
	Id Transaksi Delima='.$trx_id.'<br/>
	Id Transaksi ISM='.$id_transaksi.'<br/>
	<br/>
	Terima kasih
	<br/>
	Admin Integrated Smart Metering<br/>
	-Telkom RDC, Bandung-';
						}
						
						$msg = array(
							"status" => $status,
							"trx_id" => $trx_id,
							"trx_id_ism" => $id_transaksi,
							"trx_type" => $trx_type,
							"desc" => $stats
						);
					}else{
						$this->response(array('status' => '0'), 404);
					}
				}else{
					$stats = 'Not Smart Meter';
					$msg = array(
						"status" => '14',
						"trx_id" => $trx_id,
						"trx_id_ism" => '-',
						"trx_type" => $trx_type,
						"desc" => $stats
					);
				}
				
				/*if($html){
					$this->load->library('email');
							
					$this->email->from('rdc.noreply@gmail.com','Integrated Smart Metering');
					$this->email->to($email);
					$this->email->subject('Topup Confirmation');
					$this->email->message($html);
					$this->email->send();
				}*/
				$this->response($msg, 200);
				
				
				//$cek = $this->email->print_debugger();
			}else{
				$this->response(array('status' => 'failed'), 404);
			}
			
		}
	}
	
	function topup_history_post()
	{
		$mid = $this->post('meter_id');
		$start_date = $this->post('start_date');
		$end_date = $this->post('end_date');
		$limit = $this->post('limit');
		$offset = $this->post('offset');
		
		if(!$mid)
        {
        	$this->response(array('status' => false), 404);
        }else{
        	$tpp = $this->user_m->topup_history($mid, $start_date, $end_date, $limit, $offset);
			
			$result = array();

			if($tpp){
				$j=0;
				foreach($tpp as $pp){
					$result[$j]['meter_id'] = $mid;
					$result[$j]['token_number'] = $pp->TOKEN;
					$result[$j]['request_time'] = date("j M Y H:i:s", strtotime($pp->REQUEST_TIME));
					$result[$j]['response_time'] = date("j M Y H:i:s", strtotime($pp->RESPONSE_TIME));
					if($pp->STATUS == 1){
						$result[$j]['status_topup'] = 'Dalam Proses';
					}elseif($pp->STATUS == 2){
						$result[$j]['status_topup'] = 'Topup Sukses';
					}elseif($pp->STATUS == 3){
						$result[$j]['status_topup'] = 'Topup Gagal';
					}
					$j++;
				}

				$this->response($result, 200); // 200 being the HTTP response code
			}else{
				$this->response(array('status' => "No data"), 200);
			}
		}
	}

	function report_status_post()
	{
		$mid = $this->post('meter_id');
		$limit = $this->post('limit');
		$offset = $this->post('offset');
		
		if(!$mid)
        {
        	$this->response(array('status' => false), 404);
        }else{
        	$rpt = $this->user_m->all_alert($mid, 1, $limit, $offset);
			
			$result = array();

			if($rpt){
				$j=0;
				foreach($rpt as $pp){
					$result[$j]['meter_id'] = $mid;
					if($pp->ALERT_LIM_BALANCE == 0){
						$result[$j]['limit_kwh'] = 'Ok';
					}else{
						$result[$j]['limit_kwh'] = 'Critical';
					}
					$result[$j]['time'] = date("j M Y H:i:s", strtotime($pp->TIME_STAMP));
					$j++;
				}

				$this->response($result, 200); // 200 being the HTTP response code
			}else{
				$this->response(array('status' => "No data"), 200);
			}
		}

	}

	function report_topup_post()
	{
		$mid = $this->post('meter_id');
		$limit = $this->post('limit');
		$offset = $this->post('offset');
		
		if(!$mid)
        {
        	$this->response(array('status' => false), 404);
        }else{
        	$rpt = $this->user_m->all_alert($mid, 0, $limit, $offset);
			
			$result = array();

			if($rpt){
				$j=0;
				foreach($rpt as $pp){
					$result[$j]['meter_id'] = $mid;
					if($pp->NO_TOKEN == '00000000000000000000'){
						$result[$j]['status_topup'] = 'Token Salah';
					}else{
						$result[$j]['status_topup'] = 'Token Benar';
					}
					$result[$j]['no_token'] = $pp->NO_TOKEN;
					$result[$j]['nilai_token'] = $pp->NILAI_TOKEN;
					$result[$j]['balance_kwh'] = $pp->BALANCE_KWH;
					$result[$j]['time'] = date("j M Y H:i:s", strtotime($pp->TIME_STAMP));
					$j++;
				}

				$this->response($result, 200); // 200 being the HTTP response code
			}else{
				$this->response(array('status' => "No data"), 200);
			}
		}
	}

	function report_tamper_post()
	{
		$mid = $this->post('meter_id');
		$limit = $this->post('limit');
		$offset = $this->post('offset');
		
		if(!$mid)
        {
        	$this->response(array('status' => false), 404);
        }else{
        	$rpt = $this->user_m->all_alert($mid, 5, $limit, $offset);
			
			$result = array();

			if($rpt){
				$j=0;
				foreach($rpt as $pp){
					$result[$j]['meter_id'] = $mid;
					if($pp->POWER_STATUS == 0){
						$result[$j]['status_power'] = 'Mati';
					}else{
						$result[$j]['status_power'] = 'Hidup';
					}
					$result[$j]['time'] = date("j M Y H:i:s", strtotime($pp->TIME_STAMP));
					$j++;
				}

				$this->response($result, 200); // 200 being the HTTP response code
			}else{
				$this->response(array('status' => "No data"), 200);
			}
		}
	}

	function edit_limit_post()
	{
		$uid = $this->post('uid');
		$mid = $this->post('meter_id');
		$limit = $this->post('limit');
		
		if(!$uid || !$mid || $limit)
        {
        	$this->response(array('status' => false), 404);
        }else{
        	$post = 'meter_id='.$mid.'&tipe_pu=1&set_alarm=1&lim_kredit='.$limit.'&user_id='.$uid;

        	$send = $this->send_api($this->ul.'request-limkredit', $post, 1);
			$now =  date("Y-m-d H:i:s",time()-400);
			
        	if($send > 90000 && $send != ''){
        		$exe = $this->check_db($send, $mid, $now, 1);
				//echo $id_met.' - '.$token;
				if($exe){
					if($exe[0]['STATUS'] == 0){
						$this->response(array('status' => true), 200);
					}
				}else{
					$this->response(array('status' => false), 200);
				}
			}else{
				$this->response(array('status' => false), 200);
			}
		}
	}
	
	function edit_interval_post()
	{
		$uid = $this->post('uid');
		$mid = $this->post('meter_id');
		$interval = $this->post('interval');
		
		if(!$uid || !$mid || $interval)
        {
        	$this->response(array('status' => false), 404);
        }else{
        	$post = 'meter_id='.$mid.'&tipe_meter=1&tipe_pu=1&alert_interval='.$interval.'&user_id='.$uid;

        	$send = $this->send_api($this->ul.'request-newinterval', $post, 1);
			$now =  date("Y-m-d H:i:s",time()-400);
			
        	if($send > 90000 && $send != ''){
        		$exe = $this->check_db($send, $mid, $now, 1);
				//echo $id_met.' - '.$token;
				if($exe == 1){
					$this->response(array('status' => true), 200);
				}else{
					$this->response(array('status' => false), 200);
				}
			}else{
				$this->response(array('status' => false), 200);
			}
		}
	}
	
	function edit_profile_post()
	{
		$uid = $this->post('uid');
		$username = $this->post('username');
		$firstname = $this->post('firstname');
		$lastname = $this->post('lastname');
		$email = $this->post('email');
		$alamat = $this->post('alamat');
		$no_hp = $this->post('no_hp');
		$old_pwd = $this->post('old_pwd');
		$new_pwd = $this->post('new_pwd');
		
		
		if(!$uid)
        {
        	$this->response(array('status' => false), 404);
        }else{	
			$result = $this->user_m->info_pelanggan($uid);

			if ($uid && ($old_pwd && $new_pwd)){
				$cekpwd = $this->user_m->get_pwd($uid);

				if(SHA1($old_pwd) == $cekpwd['0']['password']){
					$this->user_m->update_profile($username, $firstname, $lastname, $email, $alamat, $no_hp, $old_pwd, $new_pwd, $uid);
				
					$this->response(array('status' => true), 200);
				}else{
					$this->response(array('status' => false), 200);
				}
				
			}elseif($uid && ($username || $firstname || $lastname || $email || $alamat || $no_hp)){
				$this->user_m->update_profile($username, $firstname, $lastname, $email, $alamat, $no_hp, $old_pwd, $new_pwd, $uid);
				
				$this->response(array('status' => true), 200);
			}else{
				$this->response(array('status' => false), 200);
			}

		}
	}

	function prediksi_listrik_post()
	{
		$mid = $this->post('meter_id');
		
		if(!$mid)
        {
        	$this->response(array('status' => false), 404);
        }else{	
			$lst = $this->user_m->last_meter_data($mid);

			$result = array();

			if($lst){
				$idpel = $this->user_m->get_idpel($mid);
				$bulan = date("n");
				$tahun = date("Y");
				$usg = $this->user_m->total_usagebulan($mid, $bulan, $tahun);
				foreach($lst as $pp){
					$lastbal = ltrim($lst[0]["BALANCE_KWH"],'0');
					$result['meter_id'] = $mid;
					$ratahari = $usg[0]['ratahari'];
					if($ratahari) $totaljam = $lastbal/$ratahari * 24; else $totaljam = 0;
					$hari = floor($totaljam / 24);
					$jam = $totaljam % 24;
					$result['prediksi_hari'] = $hari;
					$result['prediksi_jam'] = $jam;
				}

				$this->response($result, 200); // 200 being the HTTP response code
			}else{
				$this->response(array('status' => false), 200);
			}
		}
	}

	function add_meter_post()
	{
		$uid = $this->post('uid');
		$mid = $this->post('meter_id');

		if(!$uid || !$mid)
        {
        	$this->response(array('status' => false), 404);
        }else{	
			$result = array();
			
			$ava = $this->user_m->check_meter($mid);
			if($ava){
				$ex = $this->user_m->check_meter_ex($uid, $mid);
				if(!$ex){
					$this->user_m->insert_mapping($uid, $mid);
					$result['status'] = 'ID Meter berhasil dimasukkan';
				}else{
					$result['status'] = 'ID Meter sudah dipilih';
				}
			}else{
				$result['status'] = 'ID Meter tidak terdaftar';
			}

			$this->response($result, 200); // 200 being the HTTP response code
		}
	}

	function delete_meter_post()
	{
		$uid = $this->post('uid');
		$mid = $this->post('meter_id');

		if(!$uid || !$mid)
        {
        	$this->response(array('status' => false), 404);
        }else{	
			$ava = $this->user_m->check_meter($mid);
			if($ava){
				$ex = $this->user_m->check_meter_ex($uid, $mid);
				if(!$ex){
					$this->response(array('status' => false), 200);
				}else{
					$this->user_m->delete_meter($uid, $mid);

					$this->response(array('status' => true), 200);
				}
			}else{
				$this->response(array('status' => false), 200);
			}
		}
	}

	function list_daya_post()
	{
		$result = $this->user_m->list_daya();

		foreach($result as $rr){
			$rr->daya_id = $rr->DAYA_ID;
			$rr->besar_daya = $rr->BESAR_DAYA;
			unset($rr->DAYA_ID);
			unset($rr->BESAR_DAYA);
			unset($rr->TARIF);
			unset($rr->UPDATE_TARIF);
		}
		$this->response($result, 200); // 200 being the HTTP response code
	}

	function monthly_report_post()
	{
		$mid = $this->post('meter_id');
		$bulan = $this->post('bulan');
		$tahun = $this->post('tahun');

		if(!$mid || !$bulan || !$tahun)
        {
        	$this->response(array('status' => false), 404);
        }else{	
			$result = array();

			$daya = $this->user_m->select_dayameter($mid);
			$bulanan = $this->user_m->total_usagebulan($mid, $bulan, $tahun);

			$result['meter_id'] = $mid;
			$result['bulan'] = $bulan;
			$result['tahun'] = $tahun;
			if($bulanan[0]["kwhbulan"]) $result['total_penggunaan_listrik'] = $bulanan[0]["kwhbulan"].' kWh' ;else $result['total_penggunaan_listrik'] = '-';
			if($bulanan[0]["ratahari"]) $result['rata_perhari'] = $bulanan[0]["ratahari"].' kWh' ;else $result['rata_perhari'] = '-';
			if($bulanan[0]["ratavoltage"]) $result['rata_voltage'] = $bulanan[0]["ratavoltage"].' V';else $result['rata_voltage'] =  '-';
			if($bulanan[0]["rataarus"]) $result['rata_arus'] = $bulanan[0]["rataarus"].' A';else $result['rata_arus'] = '-';
			if($bulanan) $result['pengeluaran_listrik'] = 'Rp '.number_format($bulanan[0]["kwhbulan"]*$daya[0]['TARIF'],0, ",",".");else $result['pengeluaran_listrik'] = '-';
			
			$this->response($result, 200);
		}
	}

	function get_faq_post()
	{
		$msg=array();
		$msg['content'] =
		'<h4>Tanya Jawab Umum</h4>
		<div>
			<h3>Apakah yang dimaksud dengan Integrated Smart Metering (ISM)?</h3>
			<div>
				<p>
					Integrated Smart Metering (ISM) adalah layanan yang dikembangkan untuk memonitor dan mengontrol fasilitas meter publik utility (PLN, PGN, PDAM,  dll) secara terintegrasi yang dilakukan secara remote dari mana saja dan kapan saja dengan mempergunakan media/perangkat komunikasi agar proses monitoring dan controling tersebut berjalan secara efektif dan efisien.
				</p>
			</div>
			<h3>Fitur-fitur apa sajakah yang terdapat dalam layanan ISM?</h3>
			<div>
				<p>
					Fitur-fitur yang tertanam pada aplikasi Integrated Smart Metering (ISM) dikategorikan sebagi berikut :
				</p>
				<ol type="a">
					<li>
						Informing
						<ul>
							<li>
								Informasi pembacaan KWH meter.
							</li>
							<li>
								Informasi status dan notifikasi pengisian token.
							</li>
							<li>
								Informasi status tamper (bagi PLN).
							</li>
						</ul>
					</li>
					<li>
						Monitoring
						<ul>
							<li>
								Monitoring status konsumsi listrik.
							</li>
							<li>
								View usage characteristic.
							</li>
							<li>
								Monitoring distribusi token dan KWH Meter.
							</li>
						</ul>
					</li>
					<li>
						Controlling
						<ul>
							<li>
								Pengaturan threshold (batas bawah) kuota pemakaian listrik.
							</li>
							<li>
								Pengisian token secara online
							</li>
						</ul>
					</li>
				</ol>
				<p>
					Kesemua fitur diatas dapat ditemukan pada aplikasi berbasis Web yang dapat diakses  oleh beberapa browser yang umum dipergunakan oleh pengguna seperti : Internet Explorer, Mozilla Firefox, Avant Browser dan lain-lain.
				</p>
				<img src="http://180.250.80.173/new_ism/assets/img/static/faq1.png" width="500px" style="margin:\'auto auto\'; display:\'block\'; ">
			</div>
			<h3>Apa manfaat yang didapat dengan mengimplementasikan ISM?</h3>
			<div>
				Melalui inovasi teknologi dan bisnis aplikasi ISM, manfaat yang akan didapat sebagai berikut :
				<ol type="a">
					<li>
						Revenue Assurance Management
						<ul>
							<li>
								mengendalikan pendapatan
							</li>
							<li>
								menambah pendapatan melalui  implementasi dynamic pricing
							</li>
							<li>
								mengurangi potensi fraud
							</li>
						</ul>
					</li>
					<li>
						Loss Monitoring
						<ul>
							<li>
								menghitung loss energy
							</li>
							<li>
								mendeteksi loss karena fraud
							</li>
							<li>
								Penggunaan abnormal
							</li>
						</ul>
					</li>
					<li>
						Asset Management System
					</li>
					<ul>
						<li>
							Management Meter
						</li>
						<li>
							Management Gardu
						</li>
						<li>
							Management Pelanggan
						</li>
					</ul>
					<li>
						Geographical Information System
					</li>
					<ul>
						<li>
							Mapping perangkat
						</li>
						<li>
							Mapping pelanggan
						</li>
						<li>
							Konfigurasi network
						</li>
					</ul>
					<li>
						Customer Relationship Management
					</li>
					<ul>
						<li>
							Profiling pelanggan
						</li>
						<li>
							Meningkatkan kemudahan dan kenyamanan pelanggan.
						</li>
						<li>
							Membantu fokus ke pelayanan
						</li>
					</ul>
					<li>
						Command Center
					</li>
					<ul>
						<li>
							Membantu penanganan gangguan
						</li>
						<li>
							Administrasi pasang baru
						</li>
						<li>
							Tindakan koreksi dan pencegahan
						</li>
					</ul>
					<li>
						Menyediakan integrasi layanan smart metering untuk keperluan monitoring dan controlling perangkat meter pelanggan melalui media komunikasi dalam single platform & multi device.
					</li>
					<li>
						Menciptakan fleksibilitas dalam pengelolaan infrastruktur public utility dan menciptakan operasional yang mudah dan hemat biaya bagi siapa saja, di mana saja, dengan menggunakan perangkat dimana saja, kapan saja.
					</li>
				</ol>
			</div>
			<h3>Ada kelas layanan?</h3>
			<div>
				<p>
					Jenis kelas layanan ISM adalah seperti dibawah ini:
				</p>
				
				<style>
					td, th {
						text-align: center;
					}
					.alignleft {
						text-align: left;
					}
				</style>
				<h4>Basic</h4>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Feature</th>
							<th>450 Watt</th>
							<th>900 Watt</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>AMR</td>
							<td>&#10003;</td>
							<td>&#10003;</td>
						</tr>
						<tr>
							<td>Top Up</td>
							<td>&#10003;</td>
							<td>&#10003;</td>
						</tr>
						<tr>
							<td>Limit Kredit</td>
							<td></td>
							<td>&#10003;</td>
						</tr>
						<tr>
							<td>Alert</td>
							<td></td>
							<td>&#10003;</td>
						</tr>
						<tr>
							<td>Token History</td>
							<td></td>
							<td>&#10003;</td>
						</tr>
						<tr>
							<td>Billing History</td>
							<td></td>
							<td>&#10003;</td>
						</tr>
					</tbody>
				</table>

				<h4>Premium</h4>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Feature</th>
							<th>450 Watt</th>
							<th>900 Watt</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>AMR</td>
							<td>&#10003;</td>
							<td>&#10003;</td>
						</tr>
						<tr>
							<td>Top Up</td>
							<td>&#10003;</td>
							<td>&#10003;</td>
						</tr>
						<tr>
							<td>Limit Kredit</td>
							<td>&#10003;</td>
							<td>&#10003;</td>
						</tr>
						<tr>
							<td>Alert</td>
							<td>&#10003;</td>
							<td>&#10003;</td>
						</tr>
						<tr>
							<td>Token History</td>
							<td>&#10003;</td>
							<td>&#10003;</td>
						</tr>
						<tr>
							<td>Billing History</td>
							<td>&#10003;</td>
							<td>&#10003;</td>
						</tr>
						<tr>
							<td>SMS</td>
							<td>&#10003;</td>
							<td>&#10003;</td>
						</tr>
						<tr>
							<td>Email</td>
							<td></td>
							<td>&#10003;</td>
						</tr>
						<tr>
							<td>GIS</td>
							<td></td>
							<td>&#10003;</td>
						</tr>
					</tbody>
				</table>
			</div>
			<h3>Bagaimana Skema Bisnisnya?</h3>
			<div>
				<p>
					Ada skema bisnis ISM, yaitu:
				</p>
				<ol>
					<li>
						<h4>Basic</h4>
					</li>
					<p>
						Layanan ISM dengan Skema Basic diperuntukkan bagi pelanggan PLN berbasis 450 Watt dan 900 Watt dengan mekanisme pembayaran secara prepaid. Untuk pembayaran prepaid dilakukan dengan via SMS atau melalui PPOB. Kelas layanan Basic yang dijual berlaku bagi semua kelas pelanggan PLN.
					</p>
					<li>
						<h4>Premium</h4>
					</li>
					<p>
						Layanan ISM dengan Skema Premium diperuntukkan bagi pelanggan PLN berbasis 1300 Watt dan 2200 Watt dengan mekanisme pembayaran secara prepaid. Untuk pembayaran prepaid dilakukan dengan via SMS atau melalui PPOB. Kelas layanan Premium yang dijual berlaku bagi semua kelas pelanggan PLN 450 Watt dan 900 Watt.
					</p>
					<li>
						<h4>Bundling Solution</h4>
					</li>
					<p>
						Layanan ISM dengan skema Bundling Solution diperuntukkan bagi Building Management yang menyediakan layanan solusi layanan metering dengan menggunakan ISM. Pada Bundling Solution, Kelas ISM yang dijual adalah kelas Basic dan Premium.
					</p>
			</div>
			<h3>Berapa harganya dan bagaimana sistem pembayarannya?</h3>
			<div>
				<p>
					Kerjasama layanan aplikasi ISM dengan detail sebagai berikut :
				</p>
				<ol>
					<li>
						Jenis paketisasi layanan yang disepakati para pihak adalah 2 paket utama yang dapat berkembang menyesuaikan kebutuhan pasar.
					</li>
					<li>
						Diferensiasi antar paket berdasarkan fitur dan kategori pelanggan PLN.
					</li>
					<li>
						Harga aplikasi kerjasama aplikasi ISM adalah sbb :
					</li>
					<table  class="table table-bordered table-hover">
						<thead>
							<th>No.</th>
							<th>Paket</th>
							<th>Tarif per User</th>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td class="alignleft">Basic</td>
								<td class="alignleft"></td>
							</tr>
							<tr>
								<td></td>
								<td class="alignleft">- Pelanggan 450 Watt</td>
								<td class="alignleft"></td>
							</tr>
							<tr>
								<td></td>
								<td class="alignleft">- Pelanggan 900 Watt</td>
								<td class="alignleft"></td>
							</tr>
							<tr>
								<td>2</td>
								<td class="alignleft">Premium</td>
								<td class="alignleft"></td>
							</tr>
							<tr>
								<td></td>
								<td class="alignleft">- Pelanggan 450 Watt</td>
								<td class="alignleft"></td>
							</tr>
							<tr>
								<td></td>
								<td class="alignleft">- Pelanggan 450 Watt</td>
								<td class="alignleft"></td>
							</tr>
						</tbody>
					</table>
			</div>
			<h3>Keunggulan dibandingkan dengan layanan sejenis?</h3>
			<div>
				<p>
					Keunggulan layanan ISM dibandingkan dengan layanan sejenis :
				</p>
				<ol type="a">
					<li>
						Segment Enterprise
						<ul>
							<li>
								SCADA hanya untuk membaca meter saja (AMR)
							</li>
						</ul>
					</li>
					<li>
						Segment Consumer
						<ul>
							<li>
								belum tersedia
							</li>
						</ul>
					</li>
				</ol>
			</div>
	
			<h3>Proses Fullfillment?</h3>
			<div>
				<ol type="a">
					<li>
						Cara Berlangganan
						<p>
							Calon pelanggan  menghubungi call center 123 PLN atau 147 TELKOM atau AM terkait untuk melakukan permintaan berlangganan atau registrasi.
						</p>
					</li>
					<li>
						Cara Trial
						<p>
							Untuk mendapatkan trial layanan, calon pelanggan dapat mengakses website <a href="http://180.250.80.173">180.250.80.173</a> serta melakukan loggin dengan user name : ID Meter (default) dan Password yang diemal atau di SMS ke calon pengguna.
						</p>
					</li>
					<li>
						Contact Center
						<p>
							Dapat menghubungi Contact Center 147 atau email ke <a href="mailto:c4@telkom.co.id">c4@telkom.co.id</a>
						</p>
					</li>
					<li>
						Menghentikan Layanan
						<p>
							Dapat menghubungi call center 123 PLN atau 147 TELKOM atau AM terkait untuk melakukan permintaan penghentian berlangganan.
						</p>
					</li>
				</ol>
			</div>
		</div>
		<br>
		<h4>Tanya Jawab mengenai Sistem</h4>
		<div>
			<h3>Sistem seperti apa yang saya butuhkan untuk menjalankan ISM?</h3>
			<div>
				<ul>
					<li>
						OS : Windows 98, Windows ME, Windows 2000 atau Windows XP
					</li>
					<li>
						CPU : Pentium 4 2.0+ GHz
					</li>
					<li>
						RAM : 512 MB
					</li>
					<li>
						Hard disk : 20 MB
					</li>
					<li>
						Internet : 128 kbps
					</li>
					<li>
						Web browser : Internet Explorer, Mozilla Firefox, Avant Browser serta browser smartphone
					</li>
				</ul>
			</div>

			<h3>Perangkat seperti apa yang mampu dikoneksikan ISM?</h3>
			<div>
				<p>
					KWH Meter yang dilengkapi SIM Card GSM, yang terhubung dengan USSD Gateway Telkomsel.
					Note : SIM Card GSM yang terpasang di KWH Meter harus dipairing terlebih dahulu dengan KWH Meter dan SIM Card GSM harus dalam kondisi aktif agar layanan ISM tetap berjalan.
				</p>
			</div>

			<h3>Bagaimana jika saya mengganti SIM yang telah dipairing dengan SIM card yang lain?</h3>
			<div>
				<p>
					KWH Meter tidak bisa terhubung dengan ISM, SIM card harus dipairing dulu dengan KWH meter, agar layanan dapat berfungsi.
				</p>
			</div>

			<h3>Apakah akan ada masalah dengan layanan ISM jika mempergunakan SIM card selain dari Telkomsel?</h3>
			<div>
				KWH Meter tidak bisa terhubung dengan ISM, KWH Meter didisain khusus untuk SIM card keluaran Telkomsel, untuk itu SIM card dengan operator lain tidak dapat berfungsi.
			</div>

			<h3>Mengapa ISM tidak dapat diaktifkan?</h3>
			<div>
				<p>
					Masuk ke task manager dan pastikan hanya satu proses ISM yang berjalan.
					Jika tidak, segera tutup semua proses ISM yang berjalan lalu restart (aktifkan
					kembali) ISM Anda.
				</p>
			</div>
		</div>
		<br>
		<h4>Tanya Jawab mengenai <em>User Account</em></h4>
		<div>
			<h3>Bagaimana jika saya lupa kata sandi saya?</h3>
			<div>
				<p>
					Klik link "Forgot Password" lalu masukkan alamat email Anda dan verification code, setelah kata sandi yang baru akan dikirimkan ke email Anda. Atau, kirimkan pesan melalui menu "Hubungi Kami".
				</p>
			</div>

			<h3>Bagaimana jika saya tidak dapat melakukan login?</h3>
			<div>
				<p>
					Cek kembali user ID dan kata sandi Anda. Kata sandi menggunakan case sensitive. Jika keduanya sudah benar dan masih belum dapat login, silahkan kirimkan pesan pada kami melalui menu "Hubungi Kami".
				</p>
			</div>

			<h3>Apakan saya dapat melakukan login dengan ISM ID berbeda di PC yang sama?</h3>
			<div>
				<p>
					Ya, selama ISM ID yang Anda gunakan telah terdaftar.
				</p>
			</div>
		</div>';

		$this->response($msg, 200);
	}
	
	function respond_alarm_post()
    {
    	$id_transaksi = $this->post('tx_id');
		$msisdn = $this->post('msisdn');
		$meter_id = $this->post('meter_id');
		$status_tamper = $this->post('status_tamper');
		$alb = $this->post('alb');
		$ait = $this->post('ait');
		$no_token = $this->post('no_token');
		$nilai_token = $this->post('nilai_token');
		$balance_kwh = $this->post('balance_kwh');
		$tipe_alert = $this->post('tipe_alert');
		$power_status = $this->post('power_status');
		
		//update transaksi
		$this->user_m->update_trans_alarm($id_transaksi, $meter_id, $status_tamper, $alb, $ait, $no_token, $nilai_token, $balance_kwh, $tipe_alert, $power_status);
		
		$hp = $this->user_m->get_nohp($meter_id);
		
		if($tipe_alert == 0){
			$alert = 'ALERT TOKEN';
			if($ait == 0) $pesan = 'Terima kasih anda telah melakukan pengisian token KWH Meter No. ID : '.$meter_id.' , pada tanggal : '.date("j F y").', jam : '.date("H:i").', status : Sukses, KWH anda saat ini : '.$balance_kwh.'.  ';
			else $pesan = 'Mohon maaf untuk pengisian token KWH Meter No. ID : '.$meter_id.' , pada tanggal : '.date("j F y").', jam : '.date("H:i").', status : Gagal';
		}elseif($tipe_alert == 1){
			$alert = 'ALERT TAMPER';
			if($status_tamper == 0) $pesan = 'Tidak Tamper';
			else $pesan = 'KWH Meter No. ID : '.$meter_id.' mengalami gangguan, silahkan melakukan pemeriksaan meter.';
		}elseif($tipe_alert == 2){
			$alert = 'ALERT LIMIT KWH';
			if($alb == 0) $pesan = 'OK';
			else $pesan = 'KWH Meter Anda No. ID : '.$meter_id.' sudah mencapai batas limit KWH, silahkan melakukan pengisian token kembali.';
		}elseif($tipe_alert == 5){
			$alert = 'ALERT POWER STATUS';
			if($power_status == 0) $pesan = 'Mohon maaf KWH Meter Anda No. ID : '.$meter_id.' sedang dilakukan pemadaman, mohon maaf atas ketidak nyamanan ini.';
			else $pesan = 'KWH Meter Anda No. ID : '.$meter_id.' , saat ini sudah hidup kembali, silahkan gunakan listrik seperlunya.';
		}		
		$xml_str = '<?xml version="1.0" ?>
<TlkmTsel>
<type>SMSNotification</type>
<channel>SMS</channel>
<param>
<TrxID>'.$id_transaksi.'</TrxID>
<UtilityCode>1</UtilityCode>
<Sender>TelkomTsel</Sender>
<CustomerNumber>'.$hp[0]["no_hp"].'</CustomerNumber>
<MeterID>'.$alert.'</MeterID>
<Msg>'.$pesan.'</Msg>
</param>
</TlkmTsel>
<?xml version="1.0" ?>';
		$this->curl_get($this->ul.'send-sms', $xml_str);
		
		$this->response(1, 200); // 200 being the HTTP response code
	}
	
	function smc_topup_get()
    {
		$this->response('0', 404); 
	}
	
	function smc_topup_post()
    {
		$un = $this->post('username');
		$pw = $this->post('password');
		$id_met = $this->post('meter_id');
		$token = $this->post('token');
		$trx_id = $this->post('trx_id');
		$email = $this->post('email');
		$trx_type = $this->post('trx_type');
		
		if(!$un || !$pw || !$id_met || !$token || !$trx_id || !$email || !$trx_type){
		   	$this->response('0', 404);
		}else{
			if($un == '5mc' && $pw == '5mct3lk0m' && strlen($id_met) == 11 && strlen($token) == 20){
				//$user = $this->post('username');
				//$pwd = $this->post('password');
				//$this->response($pwd, 200);
				$html = '';
				$msg = array();
				$avail = $this->user_m->select_typemeter($id_met);
				if($avail){
					//insert_db
					//$getid = '1';
					$getid = $this->user_m->get_id($un, $pw);
					//$this->response($getid[0]['id_user'], 200);
					//$id_transaksi = $this->user_m->insert_transaksi('topup', $id_met, $token, '', '', $getid[0]['id_user'],'','');
					//$id_transaksi = '1111111111';
					//select type meter
					$met_type = $this->user_m->select_typemeter($id_met);
					
					//send to MD & get status topup
					//$post = 'tx_id='.$id_transaksi.'&no_token='.$token.'&meter_id='.$id_met.'&tipe_meter='.$met_type[0]['meter_type'].'&tipe_pu=1';
					$post = 'no_token='.$token.'&meter_id='.$id_met.'&tipe_meter='.$met_type[0]['TIPE_METER'].'&tipe_pu=1'.'&user_id='.$getid[0]['id_user'];
					//$link = $this->ul.'?';
					//$this->response($email, 200);
					$send = $this->send_api($this->ul.'request-token', $post, 1);
					//$send = $this->send_api($link,1);
					$now =  date("Y-m-d H:i:s",time()-400);
					//if($send != 27){
					if($send > 99900 && $send != ''){
						//$exe = $this->check_db($id_transaksi, 1);
						
						$exe = $this->check_db($send, $id_met, $now, 1);
						$id_transaksi = $send;
						
						if($exe){
							if($exe[0]['STATUS'] == 0){
								$hasil = $this->user_m->select_topup($send, $id_met, $now);
								if($hasil[0]['STATUS'] == 1){
									$stats = 'Success'; 
									//$msg = '00|trx_id='.$trx_id.'|trx_id_ism='.$id_transaksi.'|trx_type='.$trx_type.'|desc='.$stats;
									$msg['response'] = '00';
									$msg['trx_id'] = $trx_id;
									$msg['trx_id_ism'] = $id_transaksi;
									$msg['trx_type'] = $trx_type;
									$msg['desc'] = $stats;
									
									$html = 'DO NOT REPLY TO THIS EMAIL!<br/>
			***************************<br/>
			<br/>
			Pengisian pulsa listrik untuk meter '.$id_met.' Berhasil dilakukan<br/>
			Id Transaksi Delima='.$trx_id.'<br/>
			Id Transaksi ISM='.$id_transaksi.'<br/>
			<br/><br/>
			Balance kwh saat ini : '.$hasil[0]['BALANCE'].'<br/>
			<br/>
			Terima kasih
			<br/>
			Admin Integrated Smart Metering<br/>
			-Telkom RDC, Bandung-';
								}elseif($hasil[0]['STATUS'] == 2){
									$stats = 'Token Terpakai'; 
									//$msg = '88|trx_id='.$trx_id.'|trx_id_ism='.$id_transaksi.'|trx_type='.$trx_type.'|desc='.$stats;
									$msg['response'] = '88';
									$msg['trx_id'] = $trx_id;
									$msg['trx_id_ism'] = $id_transaksi;
									$msg['trx_type'] = $trx_type;
									$msg['desc'] = $stats;
								}elseif($hasil[0]['STATUS'] == 3){
									$stats = 'Token Salah'; 
									//$msg = '78|trx_id='.$trx_id.'|trx_id_ism='.$id_transaksi.'|trx_type='.$trx_type.'|desc='.$stats;
									$msg['response'] = '78';
									$msg['trx_id'] = $trx_id;
									$msg['trx_id_ism'] = $id_transaksi;
									$msg['trx_type'] = $trx_type;
									$msg['desc'] = $stats;
								}elseif($hasil[0]['STATUS'] == 4){
									//$msg = 'Maaf, Token Anda sudah tidak dapat digunakan lagi';
									//$stats = 'Token Usang'; 
									$stats = 'Maaf, Token Anda sudah tidak dapat digunakan lagi';
									$msg['response'] = '-';
									$msg['trx_id'] = $trx_id;
									$msg['trx_id_ism'] = $id_transaksi;
									$msg['trx_type'] = $trx_type;
									$msg['desc'] = $stats;
								}elseif($hasil[0]['STATUS'] == 5){
									//$msg = 'Maaf, Komunikasi proses topup error';
									//$stats = 'Komunikasi Error';
									$stats = 'Maaf, Komunikasi proses topup error';
									$msg['response'] = '00';
									$msg['trx_id'] = $trx_id;
									$msg['trx_id_ism'] = '-';
									$msg['trx_type'] = $trx_type;
									$msg['desc'] = $msg;
								}
							}elseif($exe[0]['STATUS'] == 27){
								$stats = 'Failed Transaction';
								//$msg = '34|trx_id='.$trx_id.'|trx_id_ism='.$id_transaksi.'|trx_type='.$trx_type.'|desc='.$stats;
								$msg['response'] = '27';
								$msg['trx_id'] = $trx_id;
								$msg['trx_id_ism'] = $id_transaksi;
								$msg['trx_type'] = $trx_type;
								$msg['desc'] = $stats;
							}
						}else{
							$stats = 'Network Error';
							//$msg = '34|trx_id='.$trx_id.'|trx_id_ism='.$id_transaksi.'|trx_type='.$trx_type.'|desc='.$stats;
							$msg['response'] = '34';
							$msg['trx_id'] = $trx_id;
							$msg['trx_id_ism'] = $id_transaksi;
							$msg['trx_type'] = $trx_type;
							$msg['desc'] = $stats;
							
							$html = 'DO NOT REPLY TO THIS EMAIL!<br/>
		***************************<br/>
		<br/>
		Mohon Maaf Pengisian pulsa listrik untuk meter '.$id_met.' Gagal dilakukan karena Network Error<br/>
		Id Transaksi Delima='.$trx_id.'<br/>
		Id Transaksi ISM='.$id_transaksi.'<br/>
		<br/>
		Terima kasih
		<br/>
		Admin Integrated Smart Metering<br/>
		-Telkom RDC, Bandung-';
						}
					}else{
						$msg = '0';
					}
				}else{
					$stats = $id_met . ' Not Smart Meter';
					
					$msg['response'] = '14';
					$msg['trx_id'] = $trx_id;
					$msg['trx_id_ism'] = '-';
					$msg['trx_type'] = $trx_type;
					$msg['desc'] = $stats;
					//testing parsing
					//$stats = 'Success'; 
					//$msg = '00|trx_id='.$trx_id.'|trx_id_ism=00112|trx_type='.$trx_type.'|desc='.$stats;
				}
				
				if($html){
					$this->load->library('email');
							
					$this->email->from('rdc.noreply@gmail.com','Integrated Smart Metering');
					$this->email->to($email);
					$this->email->subject('Topup Confirmation');
					$this->email->message($html);
					$this->email->send();
				}
				$this->response($msg, 200);
				
				
				//$cek = $this->email->print_debugger();
			}else{
				$this->response('login failed', 404);
			}
			
		}
	}
	
	function tm_get(){
		
		$now =  date("Y-m-d H:i:s",time()-400);
		
		$this->response($now, 200);
	}
	
	function push_alert_post(){
		$meter_id = $this->post('meter_id');
		$balance_now = $this->post('balance_now');
		$tipe_push = $this->post('type_push');
		
		$bal = ltrim($balance_now, '0');
		$limbal = $this->user_m->select_detmet($meter_id);

		if($bal <= $limbal[0]['ALARM']){
			$tm = $this->user_m->select_lastalert($meter_id, $tipe_push);
//			$res = time() - strtotime($tm[0]['TIME_STAMP']);
//$this->response(var_dump($tm),200);
			//send every one hour
			if(!$tm || ($tm && time() - strtotime($tm[0]['TIME_STAMP']) >= 900)){
				$mm = $this->user_m->getmainmeter($meter_id);

				$getreg = $this->user_m->getregid($mm[0]['id_user']);
	
				$this->user_m->insert_alert($meter_id, $tipe_push, $balance_now);

				$reg_id = $getreg[0]["registration_gcm"];
				$message = 'Sisa Pulsa Listrik Anda '.$balance_now.' kWh. Silahkan lakukan pengisian ulang di tempat terderkat';
			
				$post = array(
					'registration_ids' => array($reg_id),
					'data' => array("m" => $message),
				);
			
				$result = $this->curl_push($post);
				
				$this->response($result, 200);

			}else{
				$this->response('not sent',200);	
			}
		}else{
			$this->response('not sent',200);	
		}

	}
	
	
	function push_alert_get(){
		$result = 'ok';
		
		$this->response($result, 200);
	}

function push_sms_post(){
		$message = 'Sisa Pulsa Listrik Anda 200 kWh';
		$vars = array(
					'msisdn' => '085669723933',
					'content' => '12'
				);
		$server_output = $this->curl_sms($vars);


$this->response($server_output , 200);

	}

	private function check_db($id_transaksi, $mid, $time, $jum2)
	{
		$jum_check = 30;
		$jeda = 5;
		for($i=0; $i<$jum_check;$i++){
			$try = $this->user_m->select_transaksi($id_transaksi, $mid, $time, $jum2);
			//echo 'eksekusi_db ke : '.$jum2.' hasil => '.$try[0]['status'].'<br/>';
			if($try) break;
			sleep($jeda);
		}
		
		return $try;
	}
}
