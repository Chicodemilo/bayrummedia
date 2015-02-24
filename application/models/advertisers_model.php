<?php 
class Advertisers_model extends CI_Model{

	public function get_all($mag){
		$this->db->order_by('name', 'asc');

		$where = "(associated_mag_1 ='".$mag."' OR associated_mag_2 ='".$mag."' OR associated_mag_3 ='".$mag."') AND status ='active'";
		$this->db->where($where);

		return $this->db->get('advertisers')->result_array();
	}




	public function get_all_inc_suspended($mag){
		$this->db->order_by('name', 'asc');

		$where = "associated_mag_1 ='".$mag."' OR associated_mag_2 ='".$mag."' OR associated_mag_3 ='".$mag."'";
		$this->db->where($where);

		return $this->db->get('advertisers')->result_array();
	}

  


	public function get_users(){
		$this->db->order_by('id', 'asc');
		return $this->db->get('membership')->result_array();
	}





	public function double_check($condition){
		$this->db->where('name', $condition);
		$this->db->or_where('property_one_name', $condition);
		$this->db->or_where('property_one_street_address', $condition);
		$this->db->or_where('property_one_phone', $condition);
		$this->db->or_where('property_one_contact', $condition);
		$this->db->or_where('billing_contact_name', $condition);
		$this->db->or_where('billing_email', $condition);
		$this->db->or_where('property_one_contact', $condition);
		$this->db->or_where('billing_street_address', $condition);
		$this->db->or_where('property_two_street_address', $condition);
		$this->db->or_where('property_two_phone', $condition);
		$this->db->or_where('property_two_email', $condition);
		$this->db->or_where('property_two_contact', $condition);
		$this->db->or_where('property_three_name', $condition);
		$this->db->or_where('property_three_street_address', $condition);
		$this->db->or_where('property_three_phone', $condition);
		$this->db->or_where('property_three_email', $condition);
		$this->db->or_where('property_three_contact', $condition);
		$this->db->or_where('property_four_name', $condition);
		$this->db->or_where('property_four_street_address', $condition);
		$this->db->or_where('property_four_phone', $condition);
		$this->db->or_where('property_four_email', $condition);
		$this->db->or_where('property_four_contact', $condition);
		$this->db->or_where('property_five_name', $condition);
		$this->db->or_where('property_five_street_address', $condition);
		$this->db->or_where('property_five_phone', $condition);
		$this->db->or_where('property_five_email', $condition);
		$this->db->or_where('property_five_contact', $condition);
		$this->db->or_where('property_six_name', $condition);
		$this->db->or_where('property_six_street_address', $condition);
		$this->db->or_where('property_six_phone', $condition);
		$this->db->or_where('property_six_email', $condition);
		$this->db->or_where('property_six_contact', $condition);
	
		$result = $this->db->get('advertisers')->result_array();
		return $result;

	}




	public function get($id){
		$this->db->where('id', $id);
		$result = $this->db->get('advertisers')->result_array();

		if(count($result) == 1){
			return $result[0];
		}else{
			return false;
		}

	}


	//deletes a magazine - does not delete the associated db
	public function delete($id){
		$this->db->where("id", $id);
		$this->db->delete("advertisers");
		return true;
	}

	//returns search array
	public function ad_search($query){
		$this->db->like('name', $query);
		$result = $this->db->get('advertisers')->result_array();

		if(count($result) >= 1){
			return $result;
		}else{
			return "false";
		}

	}









}
 ?>