<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->is_logged_in();
        
	}

	function is_logged_in(){
		$is_logged_in = $this->session->userdata('is_logged_in');

		// $session_name = $this->session->userdata('session_name');
		// $last_activity = $this->session->userdata('last_activity');

		// $header_data = array('is_logged_in' => $is_logged_in, 'session_name' => $session_name, 'last_activity' => $last_activity );
		// print_r($header_data);

		if(!isset($is_logged_in) || $is_logged_in != true){

			//replace this with a view vvvvv
			echo "You have been logged out. <br>";
			echo "<a href='";
			echo base_url();
			echo "login'> Login </a>";
			die();
			redirect(base_url()."login");
		}
	}

	function logout()
		{	
			date_default_timezone_set('America/Chicago');

			$time = date("Y-m-d H:i:s");
			$data = array('last_login' => $time);
			$name = $this->session->userdata('username');
			$this->db->where('username', $name);
			$this->db->update('membership', $data);


		    $this->session->sess_destroy();
		    redirect(base_url()."login");
		}


//home page
	public function index(){
		$this->load->view('home/header');

		$this->load->model('eds_model', 'updater');
		$updated = $this->updater->status_update();

		$data['prod_mags'] = $this->updater->get_prod_eds();
		$data['live_mags'] = $this->updater->get_live_eds();
		$this->load->view('home/home_info', $data);

		$this->load->view('home/footer');
	}


//shows all the magazines sorted by the short name - click on a short name to see editions
	public function magazines(){
		$this->load->view('home/header');

		$this->db->order_by("short_name", "asc");
		$data['mags'] = $this->db->get('magazines');
		// print_r($data); //for testing

		$this->load->view('magazines/all', $data);
		$this->load->view('magazines/mag_links');
		$this->load->view('home/footer');

	}

//shows all the notes for a user
	public function notes($mag){
		$this->load->view('home/header');

		$username = $this->session->userdata('username');
		$this->load->model('mag_model', 'notes');
		$data['user_notes'] = $this->notes->user_notes($mag, $username);
		// $data['all_notes'] = $this->notes->all_notes($mag);
		$data['mag'] = $mag;
		$data['username'] = $username;

		$this->load->view('magazines/user_notes', $data);
		
		$this->load->view('home/footer');
	}

//shows all the notes
	public function all_notes($mag){
		$this->load->view('home/header');

		$username = $this->session->userdata('username');
		$this->load->model('mag_model', 'notes');

		$data['all_notes'] = $this->notes->all_notes($mag);
		$data['mag'] = $mag;
		$data['username'] = $username;

		$this->load->model('user_model', 'users');
		$data['users'] = $this->users->get_all_users();

		$this->load->view('magazines/all_notes', $data);
		
		$this->load->view('home/footer');
	}

//inserts a new note
	public function insert_note($mag){
		$this->load->model('user_model', 'id_grabber');
		$associated_user_id = $this->id_grabber->get_id($this->input->post('associated_user'));
		$this->load->library("input");
		$data = array (
				'business' => $this->input->post('business'),
				'contact_name' => $this->input->post('contact_name'),
				'contact_phone' => $this->input->post('contact_phone'),
				'contact_email' => $this->input->post('contact_email'),
				'do_something_on' => $this->input->post('do_something_on'),
				'do_what' => $this->input->post('do_what'),
				'notes' => $this->input->post('notes'),
				'associated_user' => $this->input->post('associated_user'),
				'associated_user_id' => $associated_user_id,
				);
		$this->db->insert($mag.'_notes',$data);
		redirect(base_url()."home/notes/".$mag);
	}

//inserts a new note and returns to all_notes view
	public function insert_note_all_users($mag){
		$this->load->model('user_model', 'id_grabber');
		$associated_user_id = $this->id_grabber->get_id($this->input->post('associated_user'));
		$this->load->library("input");
		$data = array (
				'business' => $this->input->post('business'),
				'contact_name' => $this->input->post('contact_name'),
				'contact_phone' => $this->input->post('contact_phone'),
				'contact_email' => $this->input->post('contact_email'),
				'do_something_on' => $this->input->post('do_something_on'),
				'do_what' => $this->input->post('do_what'),
				'notes' => $this->input->post('notes'),
				'associated_user' => $this->input->post('associated_user'),
				'associated_user_id' => $associated_user_id,
				);
		$this->db->insert($mag.'_notes',$data);
		redirect(base_url()."home/all_notes/".$mag);
	}

//deletes a note
	public function delete_note($mag, $note_id){
		$this->db->where('id', $note_id);
		$this->db->delete($mag.'_notes');
		redirect(base_url()."home/notes/".$mag);
	}

//deletes a note and returns to the all_notes view
	public function delete_note_all_users($mag, $note_id){
		$this->db->where('id', $note_id);
		$this->db->delete($mag.'_notes');
		redirect(base_url()."home/all_notes/".$mag);
	}


//instert note changes into DB
	public function edit_notes($mag){
		echo '<br><br>';
		$data = $_POST;
		$length = count($data);
		$item_count = $length / 10;

		$data_chunk = array_chunk($data, 10, true);


		for ($i=0; $i < $item_count; $i++) { 

			$data = $data_chunk[$i];

			// print_r($data);
			// echo '<br><br>';

			$data = array_values($data);

			$id = $data[0];
			$this->load->model('user_model', 'id_grabber');
			$associated_user_id = $this->id_grabber->get_id($data[1]);

			$insert = array('associated_user' => $data[1],
							'associated_user_id' => $associated_user_id,
							'business' => $data[3],
							'contact_name' => $data[4],
							'contact_email' => $data[5],
							'contact_phone' => $data[6],
							'notes' => $data[7],
							'do_what' => $data[8],
							'do_something_on' => $data[9]);


			$this->db->where('id', $id);
			$this->db->update($mag."_notes", $insert);

		}


		redirect(base_url()."home/notes/".$mag);
	}

//instert note changes into DB and returns to all_notes view
	public function edit_notes_all_users($mag){
		echo '<br><br>';
		$data = $_POST;
		$length = count($data);
		$item_count = $length / 10;

		$data_chunk = array_chunk($data, 10, true);


		for ($i=0; $i < $item_count; $i++) { 

			$data = $data_chunk[$i];

			// print_r($data);
			// echo '<br><br>';

			$data = array_values($data);

			$id = $data[0];

			$this->load->model('user_model', 'id_grabber');
			$associated_user_id = $this->id_grabber->get_id($data[1]);

			$insert = array('associated_user' => $data[1],
							'associated_user_id' => $associated_user_id,
							'business' => $data[3],
							'contact_name' => $data[4],
							'contact_email' => $data[5],
							'contact_phone' => $data[6],
							'notes' => $data[7],
							'do_what' => $data[8],
							'do_something_on' => $data[9]);


			$this->db->where('id', $id);
			$this->db->update($mag."_notes", $insert);

		}


		redirect(base_url()."home/all_notes/".$mag);
	}


//form to enter a new magazine
	public function add_magazine(){
		$this->load->view('home/header');
		$this->load->view('magazines/add_magazine');
		$this->load->view('home/footer');
	}


//inserts the new magazine into the 'magazines' db
	public function do_add_mag(){
		$this->load->library("input");
		$this->load->view('home/header');

		$short_name = $this->input->post('short_name');
		//makes sure the short name has no spaces - the short name is the magazine db name
		$short_name = preg_replace('/\s+/', '', $short_name);


		$long_name = $this->input->post('long_name');
		$market = $this->input->post('market');
		$lifespan = $this->input->post('lifespan');
	
		$status = $this->input->post('status');

		$this->load->model("mag_model", "insert");

		$this->insert->add($long_name, $short_name, $market, $lifespan, $status);

		$this->load->dbforge();


		//creates a db for the new magazine
		$fields = array('id' => array(
										'type' => 'INT',
										'constraint' => 5,
										'unsigned' => TRUE,
										'auto_increment' => TRUE
										 ),

						'magazine' => array(
										'type' => 'VARCHAR',
										'constraint' => 100,
										),

						'edition_number' => array(
										'type' => 'INT',
										'constraint' => 5,
										),

						'edition_name' => array(
										'type' => 'VARCHAR',
										'constraint' => 100
										),
						'edition_first_month' => array(
										'type' => 'DATE'
										),

						'edition_final_month' => array(
										'type' => 'DATE'
										),

						'edition_status' => array(
										'type' => 'VARCHAR',
										'constraint' => 15, ),

						'page_total' => array(
										'type' => 'DECIMAL',
										'constraint' => '10,2', ),

						'sold_total' => array(
										'type' => 'DECIMAL',
										'constraint' => '10,2', ),
		);



		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table($short_name, TRUE);


		//creates a NOTES db for the new magazine
		$fields = array('id' => array(
										'type' => 'INT',
										'constraint' => 5,
										'unsigned' => TRUE,
										'auto_increment' => TRUE
										 ),

						'business' => array(
										'type' => 'VARCHAR',
										'constraint' => 100,
										),

						'contact_name' => array(
										'type' => 'VARCHAR',
										'constraint' => 100,
										),

						'contact_email' => array(
										'type' => 'VARCHAR',
										'constraint' => 50
										),
						'contact_phone' => array(
										'type' => 'VARCHAR',
										'constraint' => 25
										),

						'do_something_on' => array(
										'type' => 'DATE'
										),

						'do_what' => array(
										'type' => 'VARCHAR',
										'constraint' => 20, ),

						'notes' => array(
										'type' => 'VARCHAR',
										'constraint' => 10000, ),

						'associated_user' => array(
										'type' => 'VARCHAR',
										'constraint' => 25, ),

						'associated_user_id' => array(
										'type' => 'INT',
										'constraint' => 4, ),
		);



		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table($short_name."_notes", TRUE);

		// echo $short_name.' '.$long_name.' '.$market;
		redirect(site_url('home/magazines'));

		$this->load->view('home/footer');
	}



	public function edit_magazine(){
		$this->load->view('home/header');

		$this->db->order_by("short_name", "asc");
		$data['mags'] = $this->db->get('magazines');

		$this->load->view('magazines/edit_magazine',$data);
		$this->load->view('home/footer');
	}
 


	public function edit_this($mag){

		$this->load->model("mag_model", "change");

		$data = $this->change->get($mag);

		if($data){
			$this->load->view('home/header');
			$mag = array("data" => $data);
			$this->load->view('magazines/edit_this', $mag);
			$this->load->view('home/footer');
		}else{
			$this->load->view('home/header');
			$this->load->view('magazines/not_this');
			$this->load->view('home/footer');
		}
		
	}



	public function do_edit_mag(){
		$this->load->library("input");
		$this->load->view('home/header');

		$id = $this->input->post('id');
		$old_name = $this->input->post('old_name');
		$short_name = $this->input->post('short_name');
		$long_name = $this->input->post('long_name');
		$market = $this->input->post('market');
		$lifespan = $this->input->post('lifespan');
		$status = $this->input->post('status');

		$this->load->model("mag_model", "edit");

		$this->edit->edit($id, $old_name,$long_name, $short_name, $market, $lifespan, $status);

		// echo $short_name.' '.$long_name.' '.$market;
		redirect(site_url('home/magazines'));

		$this->load->view('home/footer');
	}




	public function delete_magazine(){
		$this->load->view('home/header');

		$this->db->order_by("short_name", "asc");
		$data['mags'] = $this->db->get('magazines');

		$this->load->view('magazines/delete_magazine', $data);
		$this->load->view('home/footer');
	}




	public function delete_this($mag){

		$this->load->model('mag_model', 'deleted');

		$data = $this->deleted->get($mag);

		if($data){
			$this->load->view('home/header');
			$mag = array("data" => $data);
			$this->load->view('magazines/delete_this', $mag);
			$this->load->view('home/footer');
		}else{
			$this->load->view('home/header');
			$this->load->view('magazines/not_this');
			$this->load->view('home/footer');
		}

	}



	public function do_delete_mag($mag){
		$this->load->model("mag_model", "deleted");

		$data = $this->deleted->delete($mag);

		if(!$data){
			redirect(site_url('home/magazines'));
		}else{
			$this->load->view('home/header');
			$this->load->view('magazines/not_this');
			$this->load->view('home/footer');
		}

	}


























}
?>