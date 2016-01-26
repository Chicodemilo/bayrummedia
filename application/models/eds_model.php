<?php 

class Eds_model extends CI_Model{

	public function get_all($mag){
		$this->db->order_by("edition_first_month", "desc");
		return $this->db->get($mag)->result_array();
	}





	public function add($mag, $edition_number, $edition_name, $edition_first_month, $edition_final_month, $edition_status){
		$data = array(	'magazine' => $mag, 
						'edition_number' => $edition_number,
						'edition_name' => $edition_name,
						'edition_first_month' => $edition_first_month,
						'edition_final_month' => $edition_final_month,
						'edition_status' => $edition_status,
			);
		if($data['edition_status'] == null){
			$data['edition_status'] = 'Updating Soon';
		}

		$this->db->insert($mag, $data);
	}



	public function get_ed_number($mag){
		$this->db->order_by('edition_number', 'desc');

		$all = $this->db->get($mag)->result_array();

		if(count($all) < 1){
			return 0;
		}else{
			return $all[0]['edition_number'];
		}
	}
 



	public function get_ed_id($mag){
		$this->db->order_by('id', 'desc');

		$all = $this->db->get($mag)->result_array();

		if(count($all) < 1){
			return 0;
		}else{
			return $all[0]['id'];
		}
	}



	public function get_prev_ed_id($mag){
		$this->db->order_by('id', 'desc');

		$all = $this->db->get($mag)->result_array();

		if(count($all) > 1){
			return $all[1]['id'];
		}else{
			return 0;
		}
	}




	public function get_ed_start($mag){
		$this->db->order_by('edition_final_month', 'desc');

		$start = $this->db->get($mag)->result_array();

		if($start == null){
			return date('Y-m-d');
		}else{
			return $start[0]['edition_final_month'];
		}

		
	}
   



	public function status_update(){
		$mags = $this->db->get('magazines')->result_array();

		foreach ($mags as $mag) {
			$this_mag = $mag['short_name'];
			$in_production_weeks = $mag['in_production_weeks'];

			$editions = $this->db->get($this_mag)->result_array();

			foreach ($editions as $edition) {
				$start_date = $edition['edition_first_month'];
				$end_date = $edition['edition_final_month'];

				$date = date('Y-m-d');

				$edition_name = $edition['edition_name'];
				$id = $edition['id'];
				$mag = $edition['magazine'];

				$in_production_date = date('Y-m-d', strtotime($start_date. ' - '.$in_production_weeks.' week'));

				$status = "Updating Soon";

				if($date > $end_date){
					$status = 'Dead';
				}elseif($date >= $in_production_date && $date < $start_date){
					$status = 'In Production';
				}elseif ($date >= $start_date && $date <= $end_date) {
					$status = 'Live';
				}elseif ($date < $in_production_date) {
					$status = 'Future';
				}

				$data = array("edition_status" => $status);

				$this->db->where('id', $id);
				$this->db->update($mag, $data);

			}

		}




		// $all = $this->db->get('ABSG')->result_array();

		// foreach ($all as $editions) {
		// 	$start_date = $editions['edition_first_month'];
		// 	$last_date = $editions['edition_final_month'];
		// 	echo $start_date." : ".$last_date."<br>";

		// 	if($start_date > $last_date){
		// 		echo "Yahoo <br>";
		// 	}else{
		// 		echo "Booooo<br>";
		// 	}

		// 	$year = 1;

		// 	$future_year = $last_date + $year;

		// 	echo $future_year.'<br>';

		// 	$Date = $start_date;
		// 	echo "Start Date Minus 2 Months: <br>";
			// echo date('Y-m-d', strtotime($Date. ' - 2 month'));
		// 	echo "<br>Start Date Plus 2 Days: <br>";
		// 	echo date('Y-m-d', strtotime($Date. ' + 2 days'));
		// 	echo "<br>";
		// }


	}
 



	public function initial_status($edition_first_month, $edition_final_month, $edition_in_production){

					$date = date('Y-m-d');

					if($date > $edition_final_month){
						$status = 'Dead';
					}elseif($date >= $edition_in_production && $date < $edition_first_month){
						$status = 'In Production';
					}elseif ($date >= $edition_first_month && $date <= $edition_final_month) {
						$status = 'Live';
					}elseif ($date < $edition_in_production) {
						$status = 'Future';
					}

					return $status;
	}




	public function check($edition_number, $mag){
		$this->db->where("edition_number", $edition_number);
		$count = count($this->db->get($mag)->result_array());

		if($count > 0){
			return 1;
		}else{
			return 0;
		}
	}




	public function get($ed_num, $mag){
		$this->db->where('edition_number', $ed_num);
		$result = $this->db->get($mag)->result_array();

		if(count($result) == 1){
			return $result[0];
		}else{
			return false;
		}

	}



	public function get_prod_eds(){
		$this->db->where('status', 'active');
		$active_mags = $this->db->get('magazines')->result_array();
		$i = 0;
		foreach ($active_mags as $mag) {
			$query_one = $this->db;
			$query_one->where('edition_status', 'In Production');
			$edition = $this->db->get($active_mags[$i]['short_name'])->result_array();
			if( empty($edition)){
				$i++;
			}else{
				$data[$active_mags[$i]['short_name']] = $edition;
				$i++;
			}
		};

		return $data;
	}



	public function get_live_eds(){
		$this->db->where('status', 'active');
		$active_mags = $this->db->get('magazines')->result_array();
		$i = 0;
		$x = 0;
		foreach ($active_mags as $mag) {
			$query_one = $this->db;
			$query_one->where('edition_status', 'Live');
			$edition = $this->db->get($active_mags[$i]['short_name'])->result_array();
			
			
			if(empty($edition)){
				$i++;
			}else{
				$ed_data['id'] = $edition[0]['id'];
				$ed_data['mag'] = $edition[0]['magazine'];
				$ed_data['edition_number'] = $edition[0]['edition_number'];
				$ed_data['edition_name'] = $edition[0]['edition_name'];
				$ed_data['edition_first_month'] = $edition[0]['edition_first_month'];
				$ed_data['edition_final_month'] = $edition[0]['edition_final_month'];
				$ed_data['edition_status'] = $edition[0]['edition_status'];
				$ed_data['page_total'] = $edition[0]['page_total'];
				$ed_data['sold_total'] = $edition[0]['sold_total'];
				$data[$x] = $ed_data;
				$i++;
				$x++;
			}
		};

		function val_sort($array,$key){
			foreach($array as $k=>$v){
				$b[] = strtolower($v[$key]);
			}

			asort($b);

			echo "<br>";

			foreach($b as $k=>$v){
				$c[] = $array[$k];
			}

			return $c;
		}

		$sorted = val_sort($data, 'edition_final_month');

		// echo "<pre>";
		// print_r($sorted);
		// echo "</pre>";
		return $sorted;
	}



	public function delete($ed_num, $mag){
		$this->db->where('edition_number', $ed_num);
		$result = $this->db->get($mag)->result_array();

		$id = $result[0]['id'];

		$this->db->where('edition_number', $ed_num);
		$this->db->delete($mag);
		$this->load->dbforge();
		$this->dbforge->drop_table($mag.'_edition_'.$id, TRUE);
	}





	public function update($mag, $id, $edition_number, $edition_name, $edition_first_month, $edition_final_month, $edition_status){
		$data = array(	'magazine' => $mag, 
						'edition_number' => $edition_number,
						'edition_name' => $edition_name,
						'edition_first_month' => $edition_first_month,
						'edition_final_month' => $edition_final_month,
						'edition_status' => $edition_status,
			);


		$this->db->where('id', $id);
		$this->db->update($mag, $data);

	}




	public function make_ed_db($mag, $ed_id, $copy_info, $prev_ed_id){

			$this->load->dbforge();

			$fields = array('id' => array(
											'type' => 'INT',
											'constraint' => 5,
											'unsigned' => TRUE,
											'auto_increment' => TRUE
											 ),
							'mag' => array(
											'type' => 'VARCHAR',
											'constraint' => 5,
											),

							'ed_id' => array(
											'type' => 'INT',
											'constraint' => 5,
											),

							'paid_item' => array(
											'type' => 'VARCHAR',
											'constraint' => 1,
											),

							'advertiser' => array(
											'type' => 'VARCHAR',
											'constraint' => 50,
											),

							'advertiser_id' => array(
											'type' => 'INT',
											'constraint' => 5,
											),

							'associated_user' => array(
											'type' => 'VARCHAR',
											'constraint' => 50,
											),

							'associated_user_id' => array(
											'type' => 'INT',
											'constraint' => 5,
											),

							'sold' => array(
											'type' => 'VARCHAR',
											'constraint' => 2,
											),

							'item_size' => array(
										    'type' => 'DECIMAL',
										    'constraint' => '10,2',
										    'unsigned' => FALSE,
											),

							'number_of_eds' => array(
										    'type' => 'INT',
										    'constraint' => '3',
											),


							'current_number_of_eds' => array(
										    'type' => 'INT',
										    'constraint' => '3',
											),

							'price' => array(
											'type' => 'DECIMAL',
										    'constraint' => '10,2',
										    'unsigned' => FALSE, ),

							'page_number' => array(
											'type' => 'INT',
											'constraint' => 5,),

							'emh' => array(
											'type' => 'VARCHAR',
											'constraint' => 5,
											),

							'status' => array(
											'type' => 'VARCHAR',
											'constraint' => 5,
											),

							'last_year_price' => array(
											'type' => 'DECIMAL',
										    'constraint' => '10,2',
										    'unsigned' => FALSE, ),

							'need_changes' => array(
											'type' => 'VARCHAR',
											'constraint' => 1,
											),
							
							'need_pics' => array(
											'type' => 'VARCHAR',
											'constraint' => 1,
											),

							'pics_taken' => array(
											'type' => 'VARCHAR',
											'constraint' => 1,
											),

							'draft_made' => array(
											'type' => 'VARCHAR',
											'constraint' => 1,
											),

							'comments' => array(
											'type' => 'VARCHAR',
											'constraint' => 5000,
											),

							'last_ed_comments' => array(
											'type' => 'VARCHAR',
											'constraint' => 5000,
											),
							
							'contact' => array(
											'type' => 'VARCHAR',
											'constraint' => 2000,
											),

							'other_advertiser_names' => array(
											'type' => 'VARCHAR',
											'constraint' => 1500,
											),

							'tot_amount_paid' => array(
											'type' => 'VARCHAR',
											'constraint' => 25,
											),

							'due_date'	=> array(
											'type' => 'DATE',
											),

							'number_of_payments' => array(
											'type' => 'INT',
											'constraint' => 3,
											),

							'payment_counter' => array(
											'type' => 'INT',
											'constraint' => 3,
											),

							'payment_1' => array(
											'type' => 'DECIMAL',
										    'constraint' => '10,2',
										    'unsigned' => FALSE, ),

							'payment_1_check_number' => array(
											'type' => 'VARCHAR',
											'constraint' => 30,
											),

							'payment_1_rec_date' => array(
											'type' => 'DATE',
											),

							'payment_1_notes' => array(
											'type' => 'VARCHAR',
											'constraint' => 250,
											),

							'paid_due_pastdue' => array(
									'type' => 'VARCHAR',
									'constraint' => 25,
									),

				);

			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->create_table($mag.'_edition_'.$ed_id, TRUE);

			if($copy_info == 'Yes' && $prev_ed_id != 0){
				$this->load->model('items_model', 'all');
				$items = $this->all->get_all($mag, $prev_ed_id);

				foreach ($items as $one_item) {
					$this->db->insert($mag.'_edition_'.$ed_id, $one_item);
					$data = array('ed_id' => $ed_id);
					$this->db->where('ed_id', $prev_ed_id);
					$this->db->update($mag.'_edition_'.$ed_id, $data);
				}

				$new_items = $this->all->get_all($mag, $ed_id);

				foreach ($new_items as $this_item) {
					$id = $this_item['id'];
					
					$number_of_eds = $this_item['number_of_eds'];
					$advertiser = $this_item['advertiser'];


					if($this_item['comments'] != ''){
						$comments = '&#13;&#10;LAST ED COMMENTS: '.$this_item['comments'];
					}else{
						$comments = '';
					}

					$need_changes = 'Y';
					$need_pics = 'N';
					$draft_made = 'N';
					$emh = 'MED';

					if($advertiser == 'House'){
						$sold = 'Y';
						$status = 'WORK';
						$last_year_price = $this_item['price'];
						$price = 0;
						$current_number_of_eds = $this_item['current_number_of_eds'];

					}else{


						if ($number_of_eds > 1) {
							$current_number_of_eds = $this_item['current_number_of_eds'] + 1;

							$ed_count = $number_of_eds - $current_number_of_eds;

							if ($ed_count == 0) {
								$comments = '*FINAL EDITION*'.$comments;
							}elseif ($ed_count < 0) {
								$comments = '*NEED TO RESIGN*'.$comments;
								$last_year_price = $this_item['price'];
								$price = 0;
								$sold = 'NY';
								$status = 'WAIT';
							}

							$last_year_price = $this_item['price'];
							$price = $this_item['price'];
							$sold = $this_item['sold'];
							$status = 'WAIT';
							
						}else{
							$current_number_of_eds = $this_item['current_number_of_eds'];
							$last_year_price = $this_item['price'];
							$price = 0;
							$sold = 'NY';
							$status = 'WAIT';
						}

					}

					




					$data = array(
							'current_number_of_eds' => $current_number_of_eds,
							'draft_made' => $draft_made,
							'need_changes' => $need_changes,
							'need_pics' => $need_pics,
							'emh' => $emh,
							'comments' => $comments,
							'status' => $status,
							'sold' => $sold,
							'last_year_price' => $last_year_price,
							'price' => $price
						);

					$this->db->where('id', $id);
					$this->db->update($mag.'_edition_'.$ed_id, $data);

				}






				$this->load->model('items_model');
				$totals = $this->items_model->get_totals($mag, $ed_id);
			}
	}




}
?>