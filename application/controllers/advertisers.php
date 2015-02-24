<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Advertisers extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->is_logged_in();
	}

	function is_logged_in(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		// $name = $this->sessnio->userdata('name');

		if(!isset($is_logged_in) || $is_logged_in != true){
			//replace this with a view vvvvv
			echo "You do not have permission to be here. <br>";
			echo "<a href='";
			echo base_url();
			echo "login'> Login </a>";
			die();
		}
	}

	//shows all the magazines - askes the user to pick a magazine to see the advertisers for that mag
	public function all(){
		$this->load->view('home/header');

		$this->db->order_by("short_name", "asc");
		$data['mags'] = $this->db->get('magazines');

		$counter = $data['mags']->result_array();

		//this pulls the number of active advertisers and past due advertisers and puts them in the $data array to be used in the all view
		foreach ($counter as $value) {
			// print_r($value['short_name']);
			$name = $value['short_name'];
			// $query = $this->db->get_where('advertisers', array('associated_mag_1' => $name))->result_array();

			$where = "(associated_mag_1 ='".$name."' OR associated_mag_2 ='".$name."' OR associated_mag_3 ='".$name."') AND status ='active'";
			$this->db->where($where);
			$query = $this->db->get('advertisers')->result_array();


			$advertiser_count = count($query);
			$data['advertisers'][$name] = $advertiser_count;

			$where = "(associated_mag_1 ='".$name."' OR associated_mag_2 ='".$name."' OR associated_mag_3 ='".$name."') AND is_past_due ='Y'";
			$this->db->where($where);
			$query = $this->db->get('advertisers')->result_array();

			$past_due_count = count($query);
			$data['past_due'][$name] = $past_due_count;


		}
		$this->load->view('advertisers/all', $data);
		$this->load->view('advertisers/advertisers_links_all');

		$this->load->view('home/footer');
	}

	//finds and displays all of the associated advertisers for a magazine
	public function mag($mag){
		$this->load->model('advertisers_model', 'advertisers');
		$advertisers = $this->advertisers->get_all($mag);

		$current_mag = array('mag' => $mag);

		$data['advertisers'] = $advertisers;
		$data['mag'] = $mag;
		$data['count'] = count($data['advertisers']);



		if(count($data['advertisers']) < 1){

			$this->load->view('home/header');
			$this->load->view('advertisers/not_this');
			$this->load->view('advertisers/advertiser_links', $current_mag);
			$this->load->view('home/footer');

		}else{
			// print_r($data);
			$this->load->view('home/header');
			$this->load->view('advertisers/per_mag', $data);
			$this->load->view('advertisers/advertiser_links', $current_mag);
			$this->load->view('home/footer');
		}
	}


	//finds and displays all advertisers - even ones that are marked as suspended 
	public function mag_susp($mag){
		$this->load->model('advertisers_model', 'advertisers');
		$advertisers = $this->advertisers->get_all_inc_suspended($mag);

		$current_mag = array('mag' => $mag);

		$data['advertisers'] = $advertisers;
		$data['mag'] = $mag;
		$data['count'] = count($data['advertisers']);



		if(count($data['advertisers']) < 1){

			$this->load->view('home/header');
			$this->load->view('advertisers/not_this');
			$this->load->view('advertisers/advertiser_links', $current_mag);
			$this->load->view('home/footer');

		}else{
			// print_r($data);
			$this->load->view('home/header');
			$this->load->view('advertisers/per_mag_susp', $data);
			$this->load->view('advertisers/advertiser_links', $current_mag);
			$this->load->view('home/footer');
		}

	}

	//results page for searching advertisers
	public function find_ad(){
		$query = $this->input->post('ad_search');
		// print_r($query);

		$this->load->model('advertisers_model', 'search');
		$results = $this->search->ad_search($query);

		// print_r($results);
		$data['advertisers'] = $results;
		$data['query'] = $query;
		$data['count'] = count($data['advertisers']);


		if($results == "false"){

			$this->load->view('home/header');
			$this->load->view('advertisers/not_this');
			$this->load->view('advertisers/advertisers_links_all');
			// $this->load->view('advertisers/advertiser_links_all');
			$this->load->view('home/footer');

		}else{
			// print_r($data);
			$this->load->view('home/header');
			$this->load->view('advertisers/search_results', $data);
			// $this->load->view('advertisers/advertiser_links_all');
			$this->load->view('home/footer');
		}


	}



	//A form to enter the new advertiser data
	public function add_advertiser($mag){
			$this->load->view('home/header');
			$this->load->model('advertisers_model', 'users');
			$users = $this->users->get_users();
			$data = array('users'=>$users);

			$this->load->model('mag_model', 'mags');
			$mags = $this->mags->get_all();

			$data['mags'] = $mags;

			$data['this_mag'] = $mag;

			$this->load->view('advertisers/add_advertiser', $data);

			$this->load->view('home/footer');
	}



	//checks the user entered advertiser data and inserts it into the DB if good
	public function do_add_ad($mag){
		$this->load->library("input");
		$this->load->view('home/header');

		$name = $this->input->post('name');
		$status = $this->input->post('status');

		$associated_user_id = $this->input->post('associated_user_id');

		//A model to get user name
		$this->load->model('user_model', 'user');
		$username = $this->user->get_username($associated_user_id);
		$associated_user = $username;

		//Get This Later When Billing DB Set Up
		// $is_past_due = $this->input->post('is_past_due');


		$bill_to_property = $this->input->post('bill_to_property');

		$property_one_name = $this->input->post('property_one_name');
		$property_one_street_address = $this->input->post('property_one_street_address');
		$property_one_city = $this->input->post('property_one_city');
		$property_one_state = $this->input->post('property_one_state');
		$property_one_zip = $this->input->post('property_one_zip');
		$property_one_phone = $this->input->post('property_one_phone');
		$property_one_contact = $this->input->post('property_one_contact');
		$property_one_email = $this->input->post('property_one_email');


		//if billing directly to the property the billing address is the street address
		if($bill_to_property == 'Y'){
			$billing_contact_name = $property_one_contact;
			$billing_phone = $property_one_phone;
			$billing_email = $property_one_email;
			$billing_street_address = $property_one_street_address;
			$billing_city = $property_one_city;
			$billing_state = $property_one_state;
			$billing_zip = $property_one_zip;
		}else{
			$billing_contact_name = $this->input->post('billing_contact_name');
			$billing_phone = $this->input->post('billing_phone');
			$billing_email = $this->input->post('billing_email');
			$billing_street_address = $this->input->post('billing_street_address');
			$billing_city = $this->input->post('billing_city');
			$billing_state = $this->input->post('billing_state');
			$billing_zip = $this->input->post('billing_zip');
		}


		$associated_mag_1 = $this->input->post('associated_mag_1');
		$associated_mag_2 = $this->input->post('associated_mag_2');
		$associated_mag_3 = $this->input->post('associated_mag_3');
		$multiple_properties = $this->input->post('multiple_properties');
		$number_of_properties = $this->input->post('number_of_properties');

		//this may need to be part of the billing DB
		// $split_payment_evenly = $this->input->post('split_payment_evenly');

		
	
		$property_two_name = $this->input->post('property_two_name');
		$property_two_street_address = $this->input->post('property_two_street_address');
		$property_two_city = $this->input->post('property_two_city');
		$property_two_state = $this->input->post('property_two_state');
		$property_two_zip = $this->input->post('property_two_zip');
		$property_two_phone = $this->input->post('property_two_phone');
		$property_two_contact = $this->input->post('property_two_contact');
		$property_two_email = $this->input->post('property_two_email');
	
		$property_three_name = $this->input->post('property_three_name');
		$property_three_street_address = $this->input->post('property_three_street_address');
		$property_three_city = $this->input->post('property_three_city');
		$property_three_state = $this->input->post('property_three_state');
		$property_three_zip = $this->input->post('property_three_zip');
		$property_three_phone = $this->input->post('property_three_phone');
		$property_three_contact = $this->input->post('property_three_contact');
		$property_three_email = $this->input->post('property_three_email');
	
		$property_four_name = $this->input->post('property_four_name');
		$property_four_street_address = $this->input->post('property_four_street_address');
		$property_four_city = $this->input->post('property_four_city');
		$property_four_state = $this->input->post('property_four_state');
		$property_four_zip = $this->input->post('property_four_zip');
		$property_four_phone = $this->input->post('property_four_phone');
		$property_four_contact = $this->input->post('property_four_contact');
		$property_four_email = $this->input->post('property_four_email');
	
		$property_five_name = $this->input->post('property_five_name');
		$property_five_street_address = $this->input->post('property_five_street_address');
		$property_five_city = $this->input->post('property_five_city');
		$property_five_state = $this->input->post('property_five_state');
		$property_five_zip = $this->input->post('property_five_zip');
		$property_five_phone = $this->input->post('property_five_phone');
		$property_five_contact = $this->input->post('property_five_contact');
		$property_five_email = $this->input->post('property_five_email');
	
		$property_six_name = $this->input->post('property_six_name');
		$property_six_street_address = $this->input->post('property_six_street_address');
		$property_six_city = $this->input->post('property_six_city');
		$property_six_state = $this->input->post('property_six_state');
		$property_six_zip = $this->input->post('property_six_zip');
		$property_six_phone = $this->input->post('property_six_phone');
		$property_six_contact = $this->input->post('property_six_contact');
		$property_six_email = $this->input->post('property_six_email');

		$entered_data = array(
				'name' =>	$name,
				'status' => $status,
				'associated_user' => $associated_user,
				'associated_user_id' => $associated_user_id,
				'bill_to_property' => $bill_to_property,

				'property_one_name' => $property_one_name,
				'property_one_street_address' => $property_one_street_address,
				'property_one_city' => $property_one_city,
				'property_one_state' => $property_one_state,
				'property_one_zip' => $property_one_zip,
				'property_one_phone' => $property_one_phone,
				'property_one_contact' => $property_one_contact,
				'property_one_email' => $property_one_email,

				'billing_contact_name' => $billing_contact_name,
				'billing_phone' => $billing_phone,
				'billing_email' => $billing_email,
				'billing_street_address' => $billing_street_address,
				'billing_city' => $billing_city,
				'billing_state' => $billing_state,
				'billing_zip' => $billing_zip,

				'associated_mag_1' => $associated_mag_1,
				'associated_mag_2' => $associated_mag_2,
				'associated_mag_3' => $associated_mag_3,
				'multiple_properties' => $multiple_properties,
				'number_of_properties' => $number_of_properties,
		
				'property_two_name' => $property_two_name,
				'property_two_street_address' => $property_two_street_address,
				'property_two_city' => $property_two_city,
				'property_two_state' => $property_two_state,
				'property_two_zip' => $property_two_zip,
				'property_two_phone' => $property_two_phone,
				'property_two_contact' => $property_two_contact,
				'property_two_email' => $property_two_email,
		
				'property_three_name' => $property_three_name,
				'property_three_street_address' => $property_three_street_address,
				'property_three_city' => $property_three_city,
				'property_three_state' => $property_three_state,
				'property_three_zip' => $property_three_zip,
				'property_three_phone' => $property_three_phone,
				'property_three_contact' => $property_three_contact,
				'property_three_email' => $property_three_email,
		
				'property_four_name' => $property_four_name,
				'property_four_street_address' => $property_four_street_address,
				'property_four_city' => $property_four_city,
				'property_four_state' => $property_four_state,
				'property_four_zip' => $property_four_zip,
				'property_four_phone' => $property_four_phone,
				'property_four_contact' => $property_four_contact,
				'property_four_email' => $property_four_email,
		
				'property_five_name' => $property_five_name,
				'property_five_street_address' => $property_five_street_address,
				'property_five_city' => $property_five_city,
				'property_five_state' => $property_five_state,
				'property_five_zip' => $property_five_zip,
				'property_five_phone' => $property_five_phone,
				'property_five_contact' => $property_five_contact,
				'property_five_email' => $property_five_email,
		
				'property_six_name' => $property_six_name,
				'property_six_street_address' => $property_six_street_address,
				'property_six_city' => $property_six_city,
				'property_six_state' => $property_six_state,
				'property_six_zip' => $property_six_zip,
				'property_six_phone' => $property_six_phone,
				'property_six_contact' => $property_six_contact,
				'property_six_email' => $property_six_email,);

		
		//Check to see that the information isn't in the DB already
		$check_data = array($name, $property_one_name, $property_one_street_address, $property_one_phone, $property_one_contact, 
							$billing_contact_name, $billing_phone, $billing_email, $billing_street_address, 
							$property_two_name, $property_two_street_address, $property_two_phone, $property_two_email, $property_two_contact,
							$property_three_name, $property_three_street_address, $property_three_phone, $property_three_email, $property_three_contact,
							$property_four_name, $property_four_street_address, $property_four_phone, $property_four_email, $property_four_contact,
							$property_five_name, $property_five_street_address, $property_five_phone, $property_five_email, $property_five_contact,
							$property_six_name, $property_six_street_address, $property_six_phone, $property_six_email, $property_six_contact,);


		$i = 0; 
		$conflicts = array();

		foreach($check_data AS $condition){

			if($condition != ""){
				$this->load->model('advertisers_model', 'checker');
				$test = $this->checker->double_check($condition);

				$count = count($test);

				if($count > 0){
					// print_r($test);
					// echo 'Duplicate Found '.$condition.'</br>';
					
					// break;
					$conflicts[$i] = $test[0];
					$conflicts[$i]['condition'] = $condition;
					$i++;
				}
			}
				

		}

		if(count($conflicts) > 0){
			// print_r($conflicts);
			$data['conflicts'] = $conflicts;
			$data['count'] = count($conflicts);
			$data['entered_data'] = $entered_data;
			$data['mag'] = $mag;
			$this->load->view('advertisers/conflicts', $data);
			


		}else{
			
				// print_r($data);

				$this->db->insert('advertisers', $entered_data);

				redirect(site_url('advertisers/mag/'.$mag));
		}
		

	}


	public function add_anyway($mag){

		$name = $this->input->post('name');
		$status = $this->input->post('status');

		$associated_user = $this->input->post('associated_user');
		$associated_user_id = $this->input->post('associated_user_id');

		$bill_to_property = $this->input->post('bill_to_property');

		$property_one_name = $this->input->post('property_one_name');
		$property_one_street_address = $this->input->post('property_one_street_address');
		$property_one_city = $this->input->post('property_one_city');
		$property_one_state = $this->input->post('property_one_state');
		$property_one_zip = $this->input->post('property_one_zip');
		$property_one_phone = $this->input->post('property_one_phone');
		$property_one_contact = $this->input->post('property_one_contact');
		$property_one_email = $this->input->post('property_one_email');


		$billing_contact_name = $this->input->post('billing_contact_name');
		$billing_phone = $this->input->post('billing_phone');
		$billing_email = $this->input->post('billing_email');
		$billing_street_address = $this->input->post('billing_street_address');
		$billing_city = $this->input->post('billing_city');
		$billing_state = $this->input->post('billing_state');
		$billing_zip = $this->input->post('billing_zip');
	


		$associated_mag_1 = $this->input->post('associated_mag_1');
		$associated_mag_2 = $this->input->post('associated_mag_2');
		$associated_mag_3 = $this->input->post('associated_mag_3');
		$multiple_properties = $this->input->post('multiple_properties');
		$number_of_properties = $this->input->post('number_of_properties');

		//this may need to be part of the billing DB
		// $split_payment_evenly = $this->input->post('split_payment_evenly');

		
	
		$property_two_name = $this->input->post('property_two_name');
		$property_two_street_address = $this->input->post('property_two_street_address');
		$property_two_city = $this->input->post('property_two_city');
		$property_two_state = $this->input->post('property_two_state');
		$property_two_zip = $this->input->post('property_two_zip');
		$property_two_phone = $this->input->post('property_two_phone');
		$property_two_contact = $this->input->post('property_two_contact');
		$property_two_email = $this->input->post('property_two_email');
	
		$property_three_name = $this->input->post('property_three_name');
		$property_three_street_address = $this->input->post('property_three_street_address');
		$property_three_city = $this->input->post('property_three_city');
		$property_three_state = $this->input->post('property_three_state');
		$property_three_zip = $this->input->post('property_three_zip');
		$property_three_phone = $this->input->post('property_three_phone');
		$property_three_contact = $this->input->post('property_three_contact');
		$property_three_email = $this->input->post('property_three_email');
	
		$property_four_name = $this->input->post('property_four_name');
		$property_four_street_address = $this->input->post('property_four_street_address');
		$property_four_city = $this->input->post('property_four_city');
		$property_four_state = $this->input->post('property_four_state');
		$property_four_zip = $this->input->post('property_four_zip');
		$property_four_phone = $this->input->post('property_four_phone');
		$property_four_contact = $this->input->post('property_four_contact');
		$property_four_email = $this->input->post('property_four_email');
	
		$property_five_name = $this->input->post('property_five_name');
		$property_five_street_address = $this->input->post('property_five_street_address');
		$property_five_city = $this->input->post('property_five_city');
		$property_five_state = $this->input->post('property_five_state');
		$property_five_zip = $this->input->post('property_five_zip');
		$property_five_phone = $this->input->post('property_five_phone');
		$property_five_contact = $this->input->post('property_five_contact');
		$property_five_email = $this->input->post('property_five_email');
	
		$property_six_name = $this->input->post('property_six_name');
		$property_six_street_address = $this->input->post('property_six_street_address');
		$property_six_city = $this->input->post('property_six_city');
		$property_six_state = $this->input->post('property_six_state');
		$property_six_zip = $this->input->post('property_six_zip');
		$property_six_phone = $this->input->post('property_six_phone');
		$property_six_contact = $this->input->post('property_six_contact');
		$property_six_email = $this->input->post('property_six_email');

		$entered_data = array(
				'name' =>	$name,
				'status' => $status,
				'associated_user' => $associated_user,
				'associated_user_id' => $associated_user_id,
				'bill_to_property' => $bill_to_property,

				'property_one_name' => $property_one_name,
				'property_one_street_address' => $property_one_street_address,
				'property_one_city' => $property_one_city,
				'property_one_state' => $property_one_state,
				'property_one_zip' => $property_one_zip,
				'property_one_phone' => $property_one_phone,
				'property_one_contact' => $property_one_contact,
				'property_one_email' => $property_one_email,

				'billing_contact_name' => $billing_contact_name,
				'billing_phone' => $billing_phone,
				'billing_email' => $billing_email,
				'billing_street_address' => $billing_street_address,
				'billing_city' => $billing_city,
				'billing_state' => $billing_state,
				'billing_zip' => $billing_zip,

				'associated_mag_1' => $associated_mag_1,
				'associated_mag_2' => $associated_mag_2,
				'associated_mag_3' => $associated_mag_3,
				'multiple_properties' => $multiple_properties,
				'number_of_properties' => $number_of_properties,
		
				'property_two_name' => $property_two_name,
				'property_two_street_address' => $property_two_street_address,
				'property_two_city' => $property_two_city,
				'property_two_state' => $property_two_state,
				'property_two_zip' => $property_two_zip,
				'property_two_phone' => $property_two_phone,
				'property_two_contact' => $property_two_contact,
				'property_two_email' => $property_two_email,
		
				'property_three_name' => $property_three_name,
				'property_three_street_address' => $property_three_street_address,
				'property_three_city' => $property_three_city,
				'property_three_state' => $property_three_state,
				'property_three_zip' => $property_three_zip,
				'property_three_phone' => $property_three_phone,
				'property_three_contact' => $property_three_contact,
				'property_three_email' => $property_three_email,
		
				'property_four_name' => $property_four_name,
				'property_four_street_address' => $property_four_street_address,
				'property_four_city' => $property_four_city,
				'property_four_state' => $property_four_state,
				'property_four_zip' => $property_four_zip,
				'property_four_phone' => $property_four_phone,
				'property_four_contact' => $property_four_contact,
				'property_four_email' => $property_four_email,
		
				'property_five_name' => $property_five_name,
				'property_five_street_address' => $property_five_street_address,
				'property_five_city' => $property_five_city,
				'property_five_state' => $property_five_state,
				'property_five_zip' => $property_five_zip,
				'property_five_phone' => $property_five_phone,
				'property_five_contact' => $property_five_contact,
				'property_five_email' => $property_five_email,
		
				'property_six_name' => $property_six_name,
				'property_six_street_address' => $property_six_street_address,
				'property_six_city' => $property_six_city,
				'property_six_state' => $property_six_state,
				'property_six_zip' => $property_six_zip,
				'property_six_phone' => $property_six_phone,
				'property_six_contact' => $property_six_contact,
				'property_six_email' => $property_six_email,);


		$this->db->insert('advertisers', $entered_data);

		redirect(site_url('advertisers/mag/'.$mag));

	}



	//asks the user if they are sure they want to delete an advertiser
	public function delete_this($mag, $id){
		$this->load->model('advertisers_model', 'delete_this');
		$delete_this = $this->delete_this->get($id);
		// print_r($mag);

		$data = array('delete_this' => $delete_this, 'mag' => $mag );
		// print_r($data);


		if($delete_this){
			$this->load->view('home/header');
			$this->load->view('advertisers/delete_this', $data);
			// print_r($delete_this);
			$this->load->view('home/footer');
		}else{
			$this->load->view('home/header');
			$this->load->view('advertisers/not_this');
			$this->load->view('home/footer');
		}
	}


	//deletes the advertiser
	public function do_delete_ad($mag, $id){

		$this->load->model('advertisers_model', 'deleted');
		$gone = $this->deleted->delete($id);

		if($gone){
			redirect(site_url('advertisers/mag/'.$mag));
		}else{
			$this->load->view('home/header');
			$this->load->view('advertisers/not_this');
			$this->load->view('home/footer');
		}
	}

	//generates a form to edit the data on a chosen advertiser
	public function edit_this($mag, $id){
		$this->load->model('advertisers_model', 'edit_this');
		$edit_this = $this->edit_this->get($id);
		$data = array('edit_this' => $edit_this, 'mag' => $mag);

		$this->load->model('advertisers_model', 'users');
		$users = $this->users->get_users();
		$data['users'] = $users;

		$this->load->model('mag_model', 'mags');
		$mags = $this->mags->get_all();
		$data['mags'] = $mags;



		if($edit_this){
			$this->load->view('home/header');
			$this->load->view('advertisers/edit_this', $data);
			// print_r($delete_this);
			$this->load->view('home/footer');
		}else{
			$this->load->view('home/header');
			$this->load->view('advertisers/not_this');
			$this->load->view('home/footer');
		}

	}


	public function do_edit_ad($mag,$id){
		$this->load->library("input");
		$name = $this->input->post('name');
		$status = $this->input->post('status');

		$associated_user_id = $this->input->post('associated_user');

		//A model to get user name
		$this->load->model('user_model', 'user');
		$username = $this->user->get_username($associated_user_id);
		$associated_user = $username;

		//Get This Later When Billing DB Set Up
		// $is_past_due = $this->input->post('is_past_due');

		$notes = $this->input->post('notes');
		$bill_to_property = $this->input->post('bill_to_property');

		$property_one_name = $this->input->post('property_one_name');
		$property_one_street_address = $this->input->post('property_one_street_address');
		$property_one_city = $this->input->post('property_one_city');
		$property_one_state = $this->input->post('property_one_state');
		$property_one_zip = $this->input->post('property_one_zip');
		$property_one_phone = $this->input->post('property_one_phone');
		$property_one_contact = $this->input->post('property_one_contact');
		$property_one_email = $this->input->post('property_one_email');


		//if billing directly to the property the billing address is the street address
		if($bill_to_property == 'Y'){
			$billing_contact_name = $property_one_contact;
			$billing_phone = $property_one_phone;
			$billing_email = $property_one_email;
			$billing_street_address = $property_one_street_address;
			$billing_city = $property_one_city;
			$billing_state = $property_one_state;
			$billing_zip = $property_one_zip;
		}else{
			$billing_contact_name = $this->input->post('billing_contact_name');
			$billing_phone = $this->input->post('billing_phone');
			$billing_email = $this->input->post('billing_email');
			$billing_street_address = $this->input->post('billing_street_address');
			$billing_city = $this->input->post('billing_city');
			$billing_state = $this->input->post('billing_state');
			$billing_zip = $this->input->post('billing_zip');
		}

		$is_past_due = $this->input->post('is_past_due');
		$split_payment_evenly = $this->input->post('split_payment_evenly');
		$associated_mag_1 = $this->input->post('associated_mag_1');
		$associated_mag_2 = $this->input->post('associated_mag_2');
		$associated_mag_3 = $this->input->post('associated_mag_3');
		$multiple_properties = $this->input->post('multiple_properties');
		$number_of_properties = $this->input->post('number_of_properties');

		//this may need to be part of the billing DB
		// $split_payment_evenly = $this->input->post('split_payment_evenly');

		
	
		$property_two_name = $this->input->post('property_two_name');
		$property_two_street_address = $this->input->post('property_two_street_address');
		$property_two_city = $this->input->post('property_two_city');
		$property_two_state = $this->input->post('property_two_state');
		$property_two_zip = $this->input->post('property_two_zip');
		$property_two_phone = $this->input->post('property_two_phone');
		$property_two_contact = $this->input->post('property_two_contact');
		$property_two_email = $this->input->post('property_two_email');
	
		$property_three_name = $this->input->post('property_three_name');
		$property_three_street_address = $this->input->post('property_three_street_address');
		$property_three_city = $this->input->post('property_three_city');
		$property_three_state = $this->input->post('property_three_state');
		$property_three_zip = $this->input->post('property_three_zip');
		$property_three_phone = $this->input->post('property_three_phone');
		$property_three_contact = $this->input->post('property_three_contact');
		$property_three_email = $this->input->post('property_three_email');
	
		$property_four_name = $this->input->post('property_four_name');
		$property_four_street_address = $this->input->post('property_four_street_address');
		$property_four_city = $this->input->post('property_four_city');
		$property_four_state = $this->input->post('property_four_state');
		$property_four_zip = $this->input->post('property_four_zip');
		$property_four_phone = $this->input->post('property_four_phone');
		$property_four_contact = $this->input->post('property_four_contact');
		$property_four_email = $this->input->post('property_four_email');
	
		$property_five_name = $this->input->post('property_five_name');
		$property_five_street_address = $this->input->post('property_five_street_address');
		$property_five_city = $this->input->post('property_five_city');
		$property_five_state = $this->input->post('property_five_state');
		$property_five_zip = $this->input->post('property_five_zip');
		$property_five_phone = $this->input->post('property_five_phone');
		$property_five_contact = $this->input->post('property_five_contact');
		$property_five_email = $this->input->post('property_five_email');
	
		$property_six_name = $this->input->post('property_six_name');
		$property_six_street_address = $this->input->post('property_six_street_address');
		$property_six_city = $this->input->post('property_six_city');
		$property_six_state = $this->input->post('property_six_state');
		$property_six_zip = $this->input->post('property_six_zip');
		$property_six_phone = $this->input->post('property_six_phone');
		$property_six_contact = $this->input->post('property_six_contact');
		$property_six_email = $this->input->post('property_six_email');

		$entered_data = array(
				'name' =>	$name,
				'status' => $status,
				'associated_user' => $associated_user,
				'associated_user_id' => $associated_user_id,
				'bill_to_property' => $bill_to_property,
				'notes' => $notes,
				'is_past_due' => $is_past_due,
		 		'split_payment_evenly' => $split_payment_evenly,

				'property_one_name' => $property_one_name,
				'property_one_street_address' => $property_one_street_address,
				'property_one_city' => $property_one_city,
				'property_one_state' => $property_one_state,
				'property_one_zip' => $property_one_zip,
				'property_one_phone' => $property_one_phone,
				'property_one_contact' => $property_one_contact,
				'property_one_email' => $property_one_email,

				'billing_contact_name' => $billing_contact_name,
				'billing_phone' => $billing_phone,
				'billing_email' => $billing_email,
				'billing_street_address' => $billing_street_address,
				'billing_city' => $billing_city,
				'billing_state' => $billing_state,
				'billing_zip' => $billing_zip,

				'associated_mag_1' => $associated_mag_1,
				'associated_mag_2' => $associated_mag_2,
				'associated_mag_3' => $associated_mag_3,
				'multiple_properties' => $multiple_properties,
				'number_of_properties' => $number_of_properties,
		
				'property_two_name' => $property_two_name,
				'property_two_street_address' => $property_two_street_address,
				'property_two_city' => $property_two_city,
				'property_two_state' => $property_two_state,
				'property_two_zip' => $property_two_zip,
				'property_two_phone' => $property_two_phone,
				'property_two_contact' => $property_two_contact,
				'property_two_email' => $property_two_email,
		
				'property_three_name' => $property_three_name,
				'property_three_street_address' => $property_three_street_address,
				'property_three_city' => $property_three_city,
				'property_three_state' => $property_three_state,
				'property_three_zip' => $property_three_zip,
				'property_three_phone' => $property_three_phone,
				'property_three_contact' => $property_three_contact,
				'property_three_email' => $property_three_email,
		
				'property_four_name' => $property_four_name,
				'property_four_street_address' => $property_four_street_address,
				'property_four_city' => $property_four_city,
				'property_four_state' => $property_four_state,
				'property_four_zip' => $property_four_zip,
				'property_four_phone' => $property_four_phone,
				'property_four_contact' => $property_four_contact,
				'property_four_email' => $property_four_email,
		
				'property_five_name' => $property_five_name,
				'property_five_street_address' => $property_five_street_address,
				'property_five_city' => $property_five_city,
				'property_five_state' => $property_five_state,
				'property_five_zip' => $property_five_zip,
				'property_five_phone' => $property_five_phone,
				'property_five_contact' => $property_five_contact,
				'property_five_email' => $property_five_email,
		
				'property_six_name' => $property_six_name,
				'property_six_street_address' => $property_six_street_address,
				'property_six_city' => $property_six_city,
				'property_six_state' => $property_six_state,
				'property_six_zip' => $property_six_zip,
				'property_six_phone' => $property_six_phone,
				'property_six_contact' => $property_six_contact,
				'property_six_email' => $property_six_email,);

				// print_r($data);

				$this->db->where('id', $id);

				$this->db->update('advertisers', $entered_data);

				redirect(site_url('advertisers/mag/'.$mag));


	}



	public function see_all_advertisers(){
			$this->load->view('home/header');

			$this->db->order_by("name", "asc");
			$data['advertisers'] = $this->db->get('advertisers')->result_array();
			$data['count'] = count($data['advertisers']);

			$this->load->view('advertisers/see_all_advertisers', $data);

			// $this->load->view('advertisers/advertiser_links');
			$this->load->view('home/footer');

	}



}

 ?>