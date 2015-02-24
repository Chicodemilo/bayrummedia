<?php 
class Membership_model extends CI_Model{

	function validate(){
		$this->db->where('username', $this->input->post('username'));
		$this->db->where('password', md5($this->input->post('password')));
		$query = $this->db->get('membership');

		

		if($query->num_rows == 1){
			$this->db->where('username', $this->input->post('username'));
			$this->db->where('password', md5($this->input->post('password')));
			$verified = $this->db->get('membership')->result_array();
			$valid = $verified[0]['verified'];

			if($valid == 'Y'){
				return true;
			}else{
				return false;
			}
			
		}else{
			return false;
		}
	}


	function create_member(){
		$this->db->where('username', $this->input->post('username'));
		$this->db->or_where('email', $this->input->post('email'));

		$used_username = $this->db->get('membership');

		if($used_username->num_rows < 1){

			$new_member_insert_data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'email' => $this->input->post('email'),
				'username' => $this->input->post('username'),
				'password' => md5($this->input->post('password')),
				'role' => 'user',
				'verified' => 'N');

			$insert = $this->db->insert('membership', $new_member_insert_data);
			return $insert;

		}else{
			return false;
		}

	}
}
 ?>