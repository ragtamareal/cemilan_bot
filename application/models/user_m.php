<?php
class User_m extends CI_Model {

	function __construct() {
		parent::__construct();
		//$this->load->database();
	}

	function last_meter_data($id) {
		$this -> db -> where('METER_ID', $id);
		$this -> db -> order_by('DM_ID', 'desc');
		$this -> db -> limit(1);
		
		return $this -> db -> get('DM_TBL')->result_array();
	}
	
	function all_meter_data($id) {
		$this -> db -> where('METER_ID', $id);
		$this -> db -> order_by('TIME_STAMP', 'desc');
				
		return $this -> db -> get('DM_TBL')->result_array();
	}

	function all_meter($id) {
		$this -> db -> select('m.id_user as uid, m.no_meter, m.main, p.firstname, p.lastname');
		$this -> db -> from('MAP_USERPLN_TBL m');
		$this -> db -> join('PLN_CUSTOMER_TBL p', 'm.no_meter = p.METER_ID');
		$this -> db -> where('m.id_user', $id);
		$this -> db -> order_by('m.main', 'desc');
		
		return $this -> db -> get()->result();
	}
	
	function info_pelanggan($id) {
		$this -> db -> select('m.id_user as uid, p.ID_PELANGGAN as id_pelanggan, p.firstname, p.lastname, p.address, p.email, p.no_hp as phone_number');
		$this -> db -> from('MAP_USERPLN_TBL m');
		$this -> db -> join('PLN_CUSTOMER_TBL p', 'm.no_meter = p.METER_ID');
		$this -> db -> where('m.id_user', $id);
		$this -> db -> where('m.main', 1);
		
		return $this -> db -> get()->result();
	}	

	function get_idpel($mid) {
		$this -> db -> select('ID_PELANGGAN as id_pelanggan');
		$this -> db -> where('METER_ID', $mid);
					
		return $this -> db -> get('PLN_CUSTOMER_TBL')->result_array();
	}
	
	function all_alert($id, $type, $limit, $offset) {
		$this -> db -> where('m.TIPE_ALERT', $type);
		$this -> db -> where('m.METER_ID', $id);
		if($limit != '' && $offset != ''){
			$this -> db -> limit($limit, $offset);
		}
		$this -> db -> order_by('m.TIME_STAMP', 'desc');
		
		return $this -> db -> get('ALERT_TBL m')->result();
	}
	
	function get_nohp($id) {
		$this -> db -> where('no_meter', $id);
					
		return $this -> db -> get('PLN_CUSTOMER_TBL')->result_array();
	}
	
	function check_meter($id) {
		$this -> db -> where('METER_ID', $id);
					
		return $this -> db -> get('PLN_CUSTOMER_TBL')->num_rows();
	}
	
	function check_meter_ex($id_user, $id_met) {
		$this -> db -> where('id_user', $id_user);
		$this -> db -> where('no_meter', $id_met);
					
		return $this -> db -> get('MAP_USERPLN_TBL')->num_rows();
	}
	
	function select_typemeter($id_met) {
		$this -> db -> select('TIPE_METER');
		$this -> db -> from('METER_TBL');
		$this -> db -> where("METER_ID", $id_met);
		
		return $this -> db -> get() -> result_array();

	}
	
	function get_id($user, $pwd) {
		$this -> db -> select('id_user');
		$this -> db -> from('TOKEN_TBL');
		$this -> db -> where("u_API", $user);
		$this -> db -> where("p_API", sha1($pwd));
		
		return $this -> db -> get() -> result_array();

	}
	
	function get_pwd($uid) {
		$this -> db -> select('password');
		$this -> db -> where("id_user", $uid);
		
		return $this -> db -> get('USER_TBL') -> result_array();

	}

	function insert_mapping($id_user, $id_meter) {
		$query = "INSERT INTO MAP_USERPLN_TBL SET id_user=?, no_meter=?, main=0, map_date=NOW(), insert_by=?";
		$this -> db -> query($query, array($id_user, $id_meter, $id_user));
	}
	
	function insert_meter($id_pelanggan, $id_meter, $msisdn, $type_meter, $type_pelanggan, $insert, $provider) {
		$query = "INSERT INTO PLN_CUSTOMER_TBL SET id_pelanggan=?, no_meter=?, msisdn=?, meter_type=?, pelanggan_type=?, insertby=?, insert_date=NOW(), id_provider=?";
		$this -> db -> query($query, array($id_pelanggan, $id_meter, $msisdn, $type_meter, $type_pelanggan, $insert, $provider));
	}
	
	function insert_transaksi($jenis, $id_meter, $token, $sdate, $edate, $id_user, $job, $limit) {
		if($jenis == 'topup' || $jenis == 'reading'){
			//$del2 = "DELETE FROM transaksi_tbl WHERE id_transaksi='11111'";
			//$this -> db -> query($del2);
			
			$query = "INSERT INTO transaksi_tbl SET no_token=?, reqtime=NOW(), status=0, no_meter=?, id_user=?, tipe_transaksi=?";
			$this -> db -> query($query, array($token, $id_meter, $id_user, $jenis));
		}elseif($jenis == 'met_his'){
			//$del2 = "DELETE FROM transaksi_tbl WHERE id_transaksi='11111'";
			//$this -> db -> query($del2);
			
			$query = "INSERT INTO transaksi_tbl SET reqtime=NOW(), status=0, no_meter=?, id_user=?, tipe_transaksi=?, start_date=?, end_date=?";
			$this -> db -> query($query, array($id_meter, $id_user, $jenis, $sdate, $edate));
		}elseif($jenis == 'set_interval'){
			$query = "INSERT INTO transaksi_tbl SET reqtime=NOW(), status=0, no_meter=?, id_user=?, tipe_transaksi=?";
			$this -> db -> query($query, array($id_meter, $id_user, $jenis));
			
			$query = "UPDATE PLN_CUSTOMER_TBL SET job_interval=? WHERE no_meter=?";
			$this -> db -> query($query, array($job, $id_meter));
		}elseif($jenis == 'set_alarm' || $jenis == 'instanta'){
			$query = "INSERT INTO transaksi_tbl SET reqtime=NOW(), status=0, no_meter=?, id_user=?, tipe_transaksi=?";
			$this -> db -> query($query, array($id_meter, $id_user, $jenis));
			
			//$query = "UPDATE PLN_CUSTOMER_TBL SET alarm=? WHERE no_meter=?";
			//$this -> db -> query($query, array($limit, $id_meter));
		}
		
		$idbaru = $this -> db -> insert_id();
		
		$query3 = "INSERT INTO network_status_tbl SET id_transaksi=?, input_date=NOW()";
		$this -> db -> query($query3, $idbaru);
		
		return $idbaru;
	}
	
	function delete_meter($id_org, $meter) {
		$del2 = "DELETE FROM MAP_USERPLN_TBL WHERE id_user = ? and no_meter=? and insert_by=? and main != 1";
		$this -> db -> query($del2, array($id_org, $meter, $id_org));
	}
	
	function last_topup_history($id) {
		$this -> db -> join('STATUS_TOKEN_TBL s', 's.status = t.STATUS');
		$this -> db -> where('t.METER_ID', $id);
		$this -> db -> order_by('t.RESPONSE_TIME', 'desc');
		$this -> db -> limit(5);
		
		return $this -> db -> get('TOKEN_TBL t')->result();
	}
	
	function topup_history($mid, $start_date, $end_date, $limit, $offset) {
		$this -> db -> join('STATUS_TOKEN_TBL s', 's.status = t.STATUS');
		$this -> db -> where('t.METER_ID', $mid);
		if($start_date != '' && $end_date != ''){
			$this -> db -> where('t.REQUEST_TIME BETWEEN\''.$start_date.'\' AND \''.$end_date.'\'');
		}

		if($limit != '' && $offset != ''){
			$this -> db -> limit($limit, $offset);
		}
		$this -> db -> order_by('t.RESPONSE_TIME', 'desc');
		
		return $this -> db -> get('TOKEN_TBL t')->result();
	}
	
	function topup_history_pg($id, $jum, $banyak) {
		$this -> db -> join('DETAIL_TOKEN_TBL d', 't.id_user = d.id_user');
		$this -> db -> where('t.no_meter', $id);
		$this -> db -> where('t.tipe_transaksi', 'topup');
		$this -> db -> order_by('t.reqtime', 'desc');
		$this -> db -> limit($banyak, $jum);
		
		return $this -> db -> get('transaksi_tbl t')->result();
	}
	
	function meter_data($mid, $start_date, $end_date, $limit, $offset) {
		$this -> db -> where('t.METER_ID', $mid);
		if($start_date != '' && $end_date != ''){
			$this -> db -> where('t.TIME_STAMP BETWEEN\''.$start_date.'\' AND \''.$end_date.'\'');
		}

		if($limit != '' && $offset != ''){
			$this -> db -> limit($limit, $offset);
		}
		$this -> db -> order_by('t.TIME_STAMP', 'desc');
		
		return $this -> db -> get('DM_TBL t')->result();
	}

	function total_usage($id) {
		$this -> db -> select('sum(BALANCE_KWH) as jum_usage');
		$this -> db -> from('DM_TBL m');
		$this -> db -> where('m.METER_ID', $id);
		$this -> db -> order_by('m.TIME_STAMP', 'desc');
		
		return $this -> db -> get('')->result_array();
	}
		
	function select_transaksi($id, $id_meter) {
		$this -> db -> where('TX_ID', $id);
		$this -> db -> where('METER_ID', $id_meter);
		$this -> db -> where('STATUS', 0);
		
		return $this -> db -> get('TRANSACTION_TBL')->num_rows();
	}
	
	function select_meterdata($meter, $sdate, $edate) {
		$this -> db -> select('m.*');
		$this -> db -> from('meter_data_tbl m');
		$this -> db -> where('m.input_date between \''.$sdate.'\' AND \''.$edate.'\'');
		$this -> db -> order_by('m.input_date', 'desc');
		
		return $this -> db -> get()->result();
	}
	
	function select_detmet($meter) {
		$this -> db -> select('ALARM, JOB_INTERVAL');
		$this -> db -> from('METER_TBL');
		$this -> db -> where('METER_ID', $meter);
		
		return $this -> db -> get()->result_array();
	}

	function insert_premium($met, $id_pel, $no_hp, $id_user) {
		$query = "INSERT INTO premium_tbl SET no_meter=?, id_pelanggan=?, no_hp=?, input_date=NOW(), id_user=?";
		$this -> db -> query($query, array($met, $id_pel, $no_hp, $id_user));
	}
	
	function update_profile($username, $firstname, $lastname, $email, $alamat, $no_hp, $old_pwd, $new_pwd, $id) {
		if($id != '' && ($old_pwd != '' && $new_pwd != '')){
			$upd1 = "UPDATE USER_TBL SET password=sha1(?) WHERE id_user = ?";
			$this -> db -> query($upd1, array($new_pwd, $id));
		}

		if($id != '' && $username != ''){
			$upd2 = "UPDATE USER_TBL SET username=? WHERE id_user = ?";
			$this -> db -> query($upd2, array($username, $id));
		}

		if($id != '' && $firstname != ''){
			$upd2 = "UPDATE DETAIL_USER_TBL SET firstname=? WHERE id_user = ?";
			$this -> db -> query($upd2, array($firstname, $id));
		}

		if($id != '' && $lastname != ''){
			$upd2 = "UPDATE DETAIL_USER_TBL SET lastname=? WHERE id_user = ?";
			$this -> db -> query($upd2, array($lastname, $id));
		}

		if($id != '' && $email != ''){
			$upd2 = "UPDATE DETAIL_USER_TBL SET email=? WHERE id_user = ?";
			$this -> db -> query($upd2, array($email, $id));
		}

		if($id != '' && $alamat != ''){
			$upd2 = "UPDATE DETAIL_USER_TBL SET address=? WHERE id_user = ?";
			$this -> db -> query($upd2, array($alamat, $id));
		}

		if($id != '' && $no_hp != ''){
			$upd2 = "UPDATE DETAIL_USER_TBL SET no_telp=? WHERE id_user = ?";
			$this -> db -> query($upd2, array($no_hp, $id));
		}
	}
	
	function update_password($old, $new, $id) {
		$upd = "UPDATE TOKEN_TBL SET password=sha1(?), update_date=NOW() WHERE id_user = ? and password=sha1(?)";
		$this -> db -> query($upd, array($new, $id, $old));
	}
	
	function select_reading($id) {
		$this -> db -> where('id_transaksi', $id);
		
		return $this -> db -> get('meter_data_tbl')->result_array();
	}
	
	function update_trans_topup($id_transaksi, $status, $jenis_token, $balance, $payment_mode) {
		$upd = "UPDATE transaksi_tbl SET status=?, jenis_token=?, balance_kwh=?, payment_mode=?, restime = NOW() WHERE id_transaksi = ?";
		$this -> db -> query($upd, array($status, $jenis_token, $balance, $payment_mode, $id_transaksi));
		
		if($status == 1){
			$ins = "INSERT INTO meter_data_tbl SET no_meter=(SELECT no_meter FROM transaksi_tbl WHERE id_transaksi=?), input_date=NOW(), id_transaksi=?, tipe_reading=4";
			$this -> db -> query($ins, array($id_transaksi, $id_transaksi));
		}
	}
		
	function update_trans_reading($id_transaksi, $meter_id, $balance, $total_usage, $voltage_r, $voltage_s, $voltage_t, $arus_r, $arus_s, $arus_t, $power_factor, $daya_instant, $tarif_index, $status_tamper, $total_off, $prediksi_kredit_habis, $pmmt, $sudut_i, $sudut_v, $sudut_r, $firmware, $date){
		$upd = "UPDATE transaksi_tbl SET status=1, restime = NOW() WHERE id_transaksi = ?";
		$this -> db -> query($upd, $id_transaksi);
		
		$ins = "INSERT INTO meter_data_tbl SET no_meter=?, balance_kwh=?, total_usage=?, voltage_r=?, voltage_s=?, voltage_t=?, arus_r=?, arus_s=?, arus_t=?, power_factor=?, daya_instan=?, tarif_index=?, status_tamper=?, total_off=?, prediksi_kredit_habis=?, payment_mode=?, meter_type=1, sudutIV_r=?, sudutIV_s=?, sudutIV_t=?, firmware=?, input_date=?, id_transaksi=?, tipe_reading=1";
		$this -> db -> query($ins, array($meter_id, $balance, $total_usage, $voltage_r, $voltage_s, $voltage_t, $arus_r, $arus_s, $arus_t, $power_factor, $daya_instant, $tarif_index, $status_tamper, $total_off, $prediksi_kredit_habis, $pmmt, $sudut_i, $sudut_v, $sudut_r, $firmware, $date, $id_transaksi));
	}
								
	function update_trans_alarm($id_transaksi, $meter_id, $status_tamper, $alb, $ait, $no_token, $nilai_token, $balance_kwh, $tipe_alert, $power_status){
		$ins = "INSERT INTO meter_data_tbl SET input_date=NOW(), id_transaksi=?, no_meter=?, status_tamper=?, alert_limit_balance=?, alert_isi_token=?, no_token=?, nilai_token=?, balance_kwh=?, tipe_alert=?, power_status=?";
		$this -> db -> query($ins, array($id_transaksi, $meter_id, $status_tamper, $alb, $ait, $no_token, $nilai_token, $balance_kwh, $tipe_alert, $power_status));
	}
	
	function update_trans_limkre($id_transaksi, $meter_id, $lim_kredit, $set_alarm){
		$upd = "UPDATE transaksi_tbl SET status=1, restime = NOW() WHERE id_transaksi = ?";
		$this -> db -> query($upd, $id_transaksi);
		
		$query = "UPDATE PLN_CUSTOMER_TBL SET alarm=? WHERE no_meter=?";
		$this -> db -> query($query, array($lim_kredit, $meter_id));
	}
	
	function update_trans_network($id_transaksi, $ns){
		$upd = "UPDATE network_status_tbl SET net_status=?, update_date = NOW() WHERE id_transaksi = ?";
		$this -> db -> query($upd, array($ns, $id_transaksi));
	}
	
	function update_trans_readingpp($id_transaksi, $meter_id, $hexa_msg, $date){
		$upd = "UPDATE transaksi_tbl SET status=1, restime = NOW() WHERE id_transaksi = ?";
		$this -> db -> query($upd, $id_transaksi);
		
		$ins = "INSERT INTO meter_data_tbl SET no_meter=?, hexa_msg=?, input_date=?, id_transaksi=?, tipe_reading=1";
		$this -> db -> query($ins, array($meter_id, $hexa_msg, $date, $id_transaksi));
	}

	function total_usagebulan($met, $bul, $th) {
		$this -> db -> select('SUM(TOTAL_USAGE) as kwhbulan, AVG(TOTAL_USAGE) as ratahari, AVG(AVG_VOLTAGE) as ratavoltage, AVG(AVG_ARUS) as rataarus');
		$this -> db -> from('SUMMARY_DM_TBL ');
		$this -> db -> where('METER_ID', $met);
		$this -> db -> where('MONTH(TIMESTAMP) = '.$bul.' AND YEAR(TIMESTAMP) = '.$th);
		
		return $this -> db -> get()->result_array();
	}

	function list_daya() {
		return $this -> db -> get('DAYA_METER_TBL')->result();
	}

	function select_dayameter($id_met) {
		$this -> db -> select('m.TIPE_DAYA, d.BESAR_DAYA, d.TARIF');
		$this -> db -> from('METER_TBL m');
		$this -> db -> join('DAYA_METER_TBL d', 'M.TIPE_DAYA = d.DAYA_ID',  'left');
		$this -> db -> where("m.METER_ID", $id_met);
		
		return $this -> db -> get() -> result_array();
	}
	function getregid($id) {
		$this -> db -> where("id_user", $id);
		
		return $this -> db -> get('USER_TBL')->result_array();
	}

	function select_lastalert($id_met, $tipe_alert) {
		$this -> db -> select('a.TIME_STAMP');
		$this -> db -> from('ALERT_TBL a');
		$this -> db -> where("a.TIPE_ALERT", $tipe_alert);
		$this -> db -> where("a.METER_ID", $id_met);
$this -> db -> order_by('a.TIME_STAMP', 'desc');
		$this -> db -> limit(1);
		
		return $this -> db -> get() -> result_array();
	}

	function insert_alert($meter_id, $tipe_push, $balance){
		$ins = "INSERT INTO ALERT_TBL SET BALANCE_KWH=?, TIME_STAMP=NOW(), ALERT_LIM_BALANCE=1, TIPE_ALERT=?, METER_ID=?";
		$this -> db -> query($ins, array($balance, $tipe_push, $meter_id));
	}
	function getmainmeter($id) {
		$this -> db -> where("m.no_meter", $id);
		$this -> db -> where("m.main", 1);
		
		return $this -> db -> get('MAP_USERPLN_TBL m')->result_array();
	}
}
?>