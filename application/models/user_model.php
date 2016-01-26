<?php 

class User_model extends CI_Model{

	public function get_username($associated_user_id){
		$this->db->where('id', $associated_user_id);
		$all = $this->db->get('membership')->result_array();
		return $all[0]['username'];
	}

	public function get_id($associated_user){
		$this->db->where('username', $associated_user);
		$all = $this->db->get('membership')->result_array();
		return $all[0]['id'];
	}

	public function info_for_session($username){
		$this->db->where('username', $username);
		$data = $this->db->get('membership')->result_array();
		return $data;
	}

	public function get_all_users(){
		$data = $this->db->get('membership')->result_array();
		return $data;
	}


}




 ?>