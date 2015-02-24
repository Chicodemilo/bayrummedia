<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Editions extends CI_Controller{

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


	//gets and shows all of the editions of a chosen magazine
	public function all($mag){
		// echo $mag;
		$this->load->model('eds_model', 'editions');

		$editions = $this->editions->get_all($mag);

		$data = array('editions'=>$editions);

		$current_mag = array('mag' => $mag);
		// print_r($data);

		if(count($data['editions']) < 1){
			$this->load->view('home/header');
			$this->load->view('editions/not_this');
			$this->load->view('editions/edition_links', $current_mag);
			$this->load->view('home/footer');

		}else{
			$this->load->view('home/header');
			$this->load->view('editions/all', $data);
			$this->load->view('editions/edition_links', $current_mag);
			$this->load->view('home/footer');
		}

		
	}



	//entry form to create a new edition
	public function add_edition($mag){
		$this->load->view('home/header');

		//gives the new edition  edition_number based on what the highest previous edition number is
		$this->load->model('eds_model', 'ed_suggestion');
		$ed_number = $this->ed_suggestion->get_ed_number($mag) + 1;


		//returns the suggested start date of the edition being added.  Finds the highest end date of the other editions and then adds a day
		$this->load->model('eds_model', 'ed_start_suggestions');
		$ed_start = $this->ed_start_suggestions->get_ed_start($mag);
		$ed_start = date('Y-m-d', strtotime($ed_start. ' + 1 day'));


		$current_mag = array('mag' => $mag, 'ed_suggestion' => $ed_number, 'ed_start_suggestion' => $ed_start);

		$this->load->view('editions/add_edition', $current_mag);
		$this->load->view('home/footer');
	}



	//creates values for all the magazine variables based on start date and inserts them into the db
	public function do_add_ed($mag){
		$current_mag = array('mag' => $mag);
		$edition_number = $this->input->post('edition_number');
		$copy_info = $this->input->post('copy_info');

		$this->load->model('eds_model', 'ed_check');
		$clear_edition_number = $this->ed_check->check($edition_number, $mag);

		if($clear_edition_number == 0){

			//finds the lifespan and weeks of life and in production weeks of the magazine.  
			//The values calculate the in production dates and end dates for the edition being created
			$this->load->model('mag_model', 'mag_details');
			$details = $this->mag_details->mag_details($mag);
			$lifespan = $details[0]['lifespan'];
			$weeks_of_life = $details[0]['weeks_of_life'];
			$in_production_weeks = $details[0]['in_production_weeks'];
			
			// print_r($lifespan.$weeks_of_life.$in_production_weeks); // for testing
			
			//passed to the links view so that it knows the current magazine being worked on
			$current_mag = array('mag' => $mag);
			
			$edition_number = $this->input->post('edition_number');
			$edition_first_month = $this->input->post('edition_first_month');

			//calculates the final date of the magazine based on the lifespan variable
			switch ($lifespan) {
			case 'Annual':
				$edition_final_month = date('Y-m-d', strtotime($edition_first_month. ' + 1 year'));
				break;

			case 'Semiannual':
				$edition_final_month = date('Y-m-d', strtotime($edition_first_month. ' + 6 month'));
				break;

			case 'Quarterly':
				$edition_final_month = date('Y-m-d', strtotime($edition_first_month. ' + 3 month'));
				break;

			case 'Monthly':
				$edition_final_month = date('Y-m-d', strtotime($edition_first_month. ' + 1 month'));
				break;

			case '4 Weeks':
				$edition_final_month = date('Y-m-d', strtotime($edition_first_month. ' + '.$weeks_of_life.' week'));
				break;

			case '2 Weeks':
				$edition_final_month = date('Y-m-d', strtotime($edition_first_month. ' + '.$weeks_of_life.' week'));
				break;

			case '1 Week':
				$edition_final_month = date('Y-m-d', strtotime($edition_first_month. ' + '.$weeks_of_life.' week'));
				break;
			
			default:
				$edition_final_month = $edition_final_month;
				break;
			}

			//takes a day off the final date
			$edition_final_month = date('Y-m-d', strtotime($edition_final_month. ' - 1 day'));

			//calculates the date the magazine is in production
			$edition_in_production = date('Y-m-d', strtotime($edition_first_month. ' - '.$in_production_weeks.' week'));

			//these variables are used to create the name of the edition
			$ed_first = date('F, d Y', strtotime($edition_first_month));
			$ed_last = date('F, d Y', strtotime($edition_final_month));

			//holds a string of the edition name - not an actual date anymore
			$edition_name = strval($ed_first." - ".$ed_last);

			//returns the status of the edition being created *********************** I THINK THERE IS AN ISSUE WITH THIS ONE - DOESN'T WORK ALL THE TIME
			$this->load->model('eds_model', 'initial_status');
			$edition_status = $this->initial_status->initial_status($edition_first_month, $edition_final_month, $edition_in_production);
			

			// echo $edition_status; // for testing

			//inserts the values in to the db
			$this->load->model('eds_model', 'insert');
			$test = $this->insert->add($mag, $edition_number, $edition_name, $edition_first_month, $edition_final_month, $edition_status);


			if(!$test){

				//creates a db for the new edition
				$this->load->model('eds_model', 'new_ed_id');
				$ed_id = $this->new_ed_id->get_ed_id($mag);
				$prev_ed_id = $this->new_ed_id->get_prev_ed_id($mag);
				$this->new_ed_id->make_ed_db($mag, $ed_id, $copy_info, $prev_ed_id);

				redirect(site_url('editions/all/'.$mag));

			}else{
				
				$this->load->view('home/header');
				echo "Could Not Insert In Database";
				$this->load->view('home/footer');
			}
		}else{
			$this->load->view('home/header');
			$this->load->view('editions/not_this_ed');
			$this->load->view('editions/edition_links', $current_mag);
			$this->load->view('home/footer');
			}

	}




	//makes a list of editions for user to choose which to delete
	public function delete_edition($mag){
		$this->load->view('home/header');
		$this->db->order_by("edition_first_month", "desc");
		$data['editions'] = $this->db->get($mag);
		$data['mag'] = $mag;
		// print_r($data); // for testing

		$this->load->view('editions/delete_edition', $data);


		$this->load->view('home/footer');
	}




	//asks the user to double check that they want to delete
	public function delete_this($ed_num, $mag){

		$this->load->model('eds_model', 'deleted');

		$data = $this->deleted->get($ed_num, $mag);

		if($data){
			$this->load->view('home/header');
			$mag = array("data" => $data);
			$this->load->view('editions/delete_this', $mag);
			$this->load->view('home/footer');
		}else{
			$this->load->view('home/header');
			$this->load->view('editions/not_this');
			$this->load->view('home/footer');
		}

	}



	//deletes the chosen edition from the chosen magazines db - does not delete the editions db - yet
	public function do_delete_ed($ed_num, $mag){
		$this->load->model('eds_model','deleted');

		$data = $this->deleted->delete($ed_num, $mag);

		if(!$data){
			redirect(site_url('editions/all/'.$mag));
		}else{
			$this->load->view('home/header');
			$this->load->view('editions/not_this');
			$this->load->view('editions/edition_links', $current_mag);
			$this->load->view('home/footer');
		}


	}



	//makes a list of editions for user to choose which to edit
	public function edit_edition($mag){
		$this->load->view('home/header');
		$this->db->order_by("edition_first_month", "desc");
		$data['editions'] = $this->db->get($mag);
		$data['mag'] = $mag;

		$this->load->view('editions/edit_edition', $data);


		$this->load->view('home/footer');
	}




	//generates a form for the user to make the edits to the specific edition
	public function edit_this($ed_num, $mag){
		$this->load->model('eds_model', 'edited');

		$data = $this->edited->get($ed_num, $mag);

		if($data){
			$this->load->view('home/header');
			$mag = array("data" => $data);
			$this->load->view('editions/edit_this', $mag);
			$this->load->view('home/footer');
		}else{
			$this->load->view('home/header');
			$this->load->view('editions/not_this');
			$this->load->view('home/footer');
		}

	}


	//inserts the edited values in the db
	public function do_edit_ed($ed_num, $mag){
		$this->load->library("input");
		$current_mag = array('mag' => $mag);
		$edition_number = $this->input->post('edition_number');
		$id = $this->input->post('id');


		//makes sure the edition number isn't being used
		$this->load->model('eds_model', 'ed_check');
		$clear_edition_number = $this->ed_check->check($edition_number, $mag);

		// $clear_edition_number = 0; // for testing


		//if the edtion number is clear procede 
		if($clear_edition_number == 0 || $ed_num == $edition_number){

			//gets the details of the magazine so that specific end date and in production date can be created for the edition
			$this->load->model('mag_model', 'mag_details');
			$details = $this->mag_details->mag_details($mag);
			$lifespan = $details[0]['lifespan'];
			$weeks_of_life = $details[0]['weeks_of_life'];
			$in_production_weeks = $details[0]['in_production_weeks'];
			
			// print_r($lifespan.$weeks_of_life.$in_production_weeks); // for testing
			
			//for the links view - so that the links will be for this magazine
			$current_mag = array('mag' => $mag);
			
			$edition_number = $this->input->post('edition_number');
			$edition_first_month = $this->input->post('edition_first_month');

			//calculates the final date of the magazine based on the lifespan variable
			switch ($lifespan) {
			case 'Annual':
				$edition_final_month = date('Y-m-d', strtotime($edition_first_month. ' + 1 year'));
				break;

			case 'Semiannual':
				$edition_final_month = date('Y-m-d', strtotime($edition_first_month. ' + 6 month'));
				break;

			case 'Quarterly':
				$edition_final_month = date('Y-m-d', strtotime($edition_first_month. ' + 3 month'));
				break;

			case 'Monthly':
				$edition_final_month = date('Y-m-d', strtotime($edition_first_month. ' + 1 month'));
				break;

			case '4 Weeks':
				$edition_final_month = date('Y-m-d', strtotime($edition_first_month. ' + '.$weeks_of_life.' week'));
				break;

			case '2 Weeks':
				$edition_final_month = date('Y-m-d', strtotime($edition_first_month. ' + '.$weeks_of_life.' week'));
				break;

			case '1 Week':
				$edition_final_month = date('Y-m-d', strtotime($edition_first_month. ' + '.$weeks_of_life.' week'));
				break;
			
			default:
				$edition_final_month = $edition_final_month;
				break;
			}		

			//takes a day off the final date
			$edition_final_month = date('Y-m-d', strtotime($edition_final_month. ' - 1 day'));
			//calculates the date the magazine is in production
			$edition_in_production = date('Y-m-d', strtotime($edition_first_month. ' - '.$in_production_weeks.' week'));

			//these variables are used to create the name of the edition
			$ed_first = date('F, d Y', strtotime($edition_first_month));
			$ed_last = date('F, d Y', strtotime($edition_final_month));

			//holds a string of the edition name - not an actual date anymore
			$edition_name = strval($ed_first." - ".$ed_last);

			//returns the status of the edition being created 
			$this->load->model('eds_model', 'initial_status');
			$edition_status = $this->initial_status->initial_status($edition_first_month, $edition_final_month, $edition_in_production);
			

			// echo $edition_status; // for testing

			//inserts the values in to the db
			$this->load->model('eds_model', 'updated');
			$test = $this->updated->update($mag, $id, $edition_number, $edition_name, $edition_first_month, $edition_final_month, $edition_status);
			// echo $mag." : ".$id." : ".$edition_number." : ".$edition_name." : ".$edition_first_month." : ".$edition_final_month." : ".$edition_status; // for testing

			if(!$test){
				redirect(site_url('editions/all/'.$mag));
			}else{
				$this->load->view('home/header');
				echo "Could Not Insert In Database";
				$this->load->view('home/footer');
			}
		}else{
			$this->load->view('home/header');
			$this->load->view('editions/not_this_ed');
			$this->load->view('editions/edition_links', $current_mag);
			$this->load->view('home/footer');
		}
		
	}
	
























}
?>