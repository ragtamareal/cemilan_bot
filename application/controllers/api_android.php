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
require APPPATH.'/libraries/REST_Controller_Andro.php';

class Api_android extends REST_Controller
{
	private $ul = 'http://192.168.0.11:8080/Integration/';
	
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
	
	private function send_api($link, $svar, $jum)
	{
		$try = $this->curl_get($link, $svar);
		//echo 'eksekusi ke : '.$jum;
		
		if($try == 0 && $jum <= 6){
			$jum++;
			sleep(10);
			return $this->send_api($link, $svar, $jum);
		}else{
			return $try;
		}
	}
	
	function login_post()
    {
	   	if(!$this->post('username') || !$this->post('password'))
        {
        	$this->response(array('status' => false), 404);
        }else{	
		   	$temp='';
			$result = $this->root->login_andro($this->post('username'), $this->post('password'));
				
			if($result){
				foreach($result as $pp){
					$pp->status = 'success';
				}
				$this->response($result, 200); // 200 being the HTTP response code
			}else{
				$this->response(array('status' => 'failed'), 200);
			}
		}
	}
	
	function topup_post()
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
	
	private function check_db($id_transaksi, $jum2)
	{
		$jum_check = 5;
		$jeda = 2;
		for($i=0; $i<$jum_check;$i++){
			$try = $this->user_m->select_transaksi($id_transaksi);
			//echo 'eksekusi_db ke : '.$jum2.' hasil => '.$try[0]['status'].'<br/>';
			if($try[0]['status'] != 0) break;
			sleep($jeda);
		}
		
		return $try;
	}
}
