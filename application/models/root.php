<?php
class Root extends CI_Model {

	function __construct() {
		parent::__construct();
		//$this->load->database();
	}
	
	function login($user, $password) {
		$this -> db -> select('a.username, a.type, a.service, d.*');
		$this -> db -> from('USER_TBL a');
		$this -> db -> join('DETAIL_USER_TBL d','a.id_user = d.id_user');
		$this -> db -> where('a.username = ' . "'" . $user . "'");
		$this -> db -> where('a.password = ' . "'" . sha1($password) . "'");
		$this -> db -> where('a.type = ' . "1");
		$this -> db -> where('a.status = ' . "1");
		$this -> db -> limit(1);

		$query = $this -> db -> get();

		if ($query -> num_rows() == 1) {
			return $query -> result();
		} else {
			return false;
		}
	}
	
	function login_andro($user, $password, $reg) {
		$this -> db -> select('a.id_user as uid, a.username, d.firstname, d.lastname, d.email, d.address, d.no_telp, p.prov_name as province, c.city_name as city');
		$this -> db -> from('USER_TBL a');
		$this -> db -> join('DETAIL_USER_TBL d','a.id_user = d.id_user');
		$this -> db -> join('PROVINCE_TBL p','p.province_id = d.province');
		$this -> db -> join('CITY_TBL c','c.city_id = d.city');
		$this -> db -> where('a.username = ' . "'" . $user . "'");
		$this -> db -> where('a.password = ' . "'" . sha1($password) . "'");
		$this -> db -> where('a.type = ' . "1");
		$this -> db -> where('a.status = ' . "1");
		$this -> db -> limit(1);

		$query = $this -> db -> get();

		if ($query -> num_rows() == 1) {
			$upd = "UPDATE USER_TBL SET registration_gcm=? WHERE username = ? AND password = sha1(?)";
			$this -> db -> query($upd, array($reg, $user, $password));
			
			return $query -> result();
		} else {
			return false;
		}
	}
	
	function select_pln($id) {
		$this -> db -> select('m.no_meter as main_meter, p.ID_PELANGGAN, mt.TIPE_METER, mt.TIPE_PLG');
		$this -> db -> from('MAP_USERPLN_TBL m');
		$this -> db -> join('METER_TBL mt','m.no_meter = mt.METER_ID');
		$this -> db -> join('PLN_CUSTOMER_TBL p','m.no_meter = p.METER_ID');
		$this -> db -> where('m.id_user', $id);
		$this -> db -> where('m.main = ' . "1");
		
		return $this -> db -> get()->result_array();
	}
	
	function select_pgn($id) {
		$this -> db -> select('m.no_meter as main_meter, p.ID_PELANGGAN, p.meter_type, p.pelanggan_type');
		$this -> db -> from('map_userpgn_tbl m');
		$this -> db -> join('pgn_customer_tbl p','m.no_meter = p.no_meter');
		$this -> db -> where('m.id_user', $id);
		
		return $this -> db -> get()->result_array();
	}
	
	function activate($user, $key) {
		$upd = "UPDATE admin SET status=1 WHERE username = ? AND activation_code = ?";
		$this -> db -> query($upd, array($user, $key));

		$cek = $this -> db -> affected_rows();
		if ($cek) {
			return true;
		} else {
			return false;
		}
	}
	
	function detail_static($id) {
		$this -> db -> where('static_id', $id);
		
		return $this -> db -> get("static") -> result();
	}

	function insert_meter($id_pelanggan, $id_meter, $msisdn, $nama_pel, $namab_pel, $address_pel, $email_pel, $lat_pel, $long_pel, $number_pel, $type_meter, $type_pelanggan, $insert, $provider, $pwd) {
		$query = "INSERT INTO PLN_CUSTOMER_TBL SET ID_PELANGGAN=?, METER_ID=?, firstname=?, lastname=?, address=?, email=?, no_hp=?, province_id=0, city_id=0, area_layanan=0, insertby=?, insert_date=NOW()";
		$this -> db -> query($query, array($id_pelanggan, $id_meter, $nama_pel, $namab_pel, $address_pel, $email_pel, $number_pel, $insert));
		
		$query2 = "INSERT INTO USER_TBL SET username=?, password=?, reg_date=NOW(), type='1', status=1, service=1";
		$this -> db -> query($query2, array($email_pel, sha1($pwd)));
		$idbaru = $this->db->insert_id();
		
		$query3 = "INSERT INTO DETAIL_USER_TBL SET firstname=?, lastname=?, email=?, address=?, no_telp=?, id_user=?, province=8, city=189";
		$this -> db -> query($query3, array($nama_pel, $namab_pel, $email_pel, $address_pel, $number_pel, $idbaru));
		
		$query4 = "INSERT INTO MAP_USERPLN_TBL SET id_user=?, no_meter=?, main='1', map_date=NOW(), insert_by=?";
		$this -> db -> query($query4, array($idbaru, $id_meter, $insert));

		$query4 = "INSERT INTO METER_TBL SET METER_ID=?, MSISDN=?, TIPE_METER=?, TIPE_PLG=?, TIPE_PU=1, TIPE_DAYA=3, JOB_INTERVAL='86400000', ALARM='10.00', LAT=?, LONGIT=?, MD_ID=14, PROVIDER_ID=1, INDIHOME_ID=?";
		$this -> db -> query($query4, array($id_meter, $msisdn, $type_meter, $type_pelanggan, $lat_pel, $long_pel, $id_pelanggan));
		
		return $idbaru;
	}
}
?>