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
			echo "You do not have permission to be here. <br>";
			echo "<a href='";
			echo base_url();
			echo "login'> Login </a>";
			die();
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
		    // $this->index();
		    redirect(base_url()."login");
		}


//home page
	public function index(){
		$this->load->view('home/header');

		$this->load->model('eds_model', 'updater');
		$updated = $this->updater->status_update();
		$this->load->view('home/home_cal');

		// if($updated == TRUE){
		// 	echo "Status Updated";
		// }else{
		// 	echo "Updated Failed";
		// }

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