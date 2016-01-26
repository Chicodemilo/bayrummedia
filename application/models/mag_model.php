<?php 
class Mag_model extends CI_Model{

	public function get_all(){
		$this->db->order_by("short_name", "asc");
		return $this->db->get('magazines')->result_array();
	}

	//inserts a new magazine into the 'magazines' db
	public function add($long_name, $short_name, $market, $lifespan, $status){
		//desides the $weeks_of_life and $in_production_weeks based on the lifespan of the magazine
		switch ($lifespan) {
			case 'Annual':
				$weeks_of_life = 52;
				$in_production_weeks = 13;
				break;

			case 'Semiannual':
					$weeks_of_life = 26;
					$in_production_weeks = 8;
					break;

			case 'Quarterly':
					$weeks_of_life = 13;
					$in_production_weeks = 8;
					break;

			case 'Monthly':
					$weeks_of_life = 4;
					$in_production_weeks = 4;
					break;

			case '4 Weeks':
				$weeks_of_life = 4;
				$in_production_weeks = 4;
				break;

			case '2 Weeks':
				$weeks_of_life = 2;
				$in_production_weeks = 2;
				break;

			case '1 Week':
				$weeks_of_life = 1;
				$in_production_weeks = 1;
				break;
			
			default:
				$weeks_of_life = 0;
				$in_production_weeks = 0;
				break;
		}


		$data = array(
				"name"=>$long_name,
				"short_name" => $short_name,
				"market" => $market,
				"lifespan" => $lifespan,
				"weeks_of_life" => $weeks_of_life,
				"in_production_weeks" => $in_production_weeks,
				"status" => $status,
			);
		$this->db->insert("magazines", $data);
	}



	//returns a magazine asked for by the $mag variable
	public function get($mag){
		$this->db->where("short_name", $mag);

		$result = $this->db->get('magazines')->result_array();

		if(count($result) == 1){
			return $result[0];
		}else{
			return false;
		}
	}


	//inserts new values for a magazine based on the $short_name - so short_names can't be changed
	public function edit($id, $old_name, $long_name, $short_name, $market, $lifespan, $status){

		//decideds on a new $weeks_of_life and $in_production_weeks based on the lifespan of the magazine
		switch ($lifespan) {
			case 'Annual':
				$weeks_of_life = 52;
				$in_production_weeks = 13;
				break;

			case 'Semiannual':
					$weeks_of_life = 26;
					$in_production_weeks = 8;
					break;

			case 'Quarterly':
					$weeks_of_life = 13;
					$in_production_weeks = 8;
					break;

			case 'Monthly':
					$weeks_of_life = 4;
					$in_production_weeks = 4;
					break;

			case '4 Weeks':
				$weeks_of_life = 4;
				$in_production_weeks = 4;
				break;

			case '2 Weeks':
				$weeks_of_life = 2;
				$in_production_weeks = 2;
				break;

			case '1 Week':
				$weeks_of_life = 1;
				$in_production_weeks = 1;
				break;
			
			default:
				$weeks_of_life = 0;
				$in_production_weeks = 0;
				break;
		}
		

		$data = array(
				"name"=>$long_name,
				"short_name" => $short_name,
				"market" => $market,
				"lifespan" => $lifespan,
				"weeks_of_life" => $weeks_of_life,
				"in_production_weeks" => $in_production_weeks,
				"status" => $status,
			);

		$this->db->where('id', $id);
        $this->db->update('magazines', $data);

        $this->load->dbforge();
        $this->dbforge->rename_table($old_name, $short_name);
	}

	//deletes a magazine - does not delete the associated db
	public function delete($mag){
		$this->db->where("short_name", $mag);
		$this->db->delete("magazines");
	}


	//returns the details of a magazine based on the $mag variable.  Used in the editions controller
	public function mag_details($mag){
		$this->db->where("short_name", $mag);
		$result = $this->db->get('magazines')->result_array();
		return $result;
	}

	//gets the notes for a specific user
	public function user_notes($mag, $username){
		$this->db->order_by("do_something_on", "asc");
		$this->db->where("associated_user", $username);
		$result = $this->db->get($mag."_notes")->result_array();
		// echo "<pre>";
		// print_r($result);
		// echo "</pre>";
		return $result;
	}

	//gets notes for all users
	public function all_notes($mag){
		$this->db->order_by("associated_user", "asc");
		$result = $this->db->get($mag."_notes")->result_array();
		// echo "<pre>";
		// print_r($result);
		// echo "</pre>";
		return $result;
	}



}

?>