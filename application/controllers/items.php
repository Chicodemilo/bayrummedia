<?php 
class Items extends CI_Controller{

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

	// VIEWS ALL OF THE ITEMS IN AN EDITION AND GIVES A FORM TO EDIT THE ITEMS
	public function all($mag, $ed_id, $view_size = "expanded"){
		$this->load->view('home/header');

		$this->load->model('items_model', 'all');
		$items = $this->all->get_all($mag, $ed_id);
		// print_r($items);

		$this->load->model('items_model');
		$ed_data = $this->items_model->get_ed_data($mag, $ed_id);

		$this->load->model('advertisers_model');
		$advertisers_data = $this->advertisers_model->get_all($mag);
		

		if(count($items) < 1){
			$this->load->model('eds_model');
			$data = array('ed_data' => $ed_data, 'advertisers_data' => $advertisers_data);
			$this->load->view('items/not_this');
			$this->load->view('items/add_form', $data);
		}else{
			if($view_size == "expanded"){
				$this->load->model('items_model');
				$totals = $this->items_model->get_ed_totals($mag, $ed_id);
				// print_r($totals);
				$data = array('items' => $items, 'ed_data' => $ed_data, 'advertisers_data' => $advertisers_data, 'totals' => $totals);
				$this->load->view('items/all', $data);
			}else{
				$this->load->model('items_model');
				$totals = $this->items_model->get_ed_totals($mag, $ed_id);
				// print_r($totals);
				$data = array('items' => $items, 'ed_data' => $ed_data, 'advertisers_data' => $advertisers_data, 'totals' => $totals);
				$this->load->view('items/all_small', $data);
			}

		}

		$this->load->view('home/footer');
	}

	// VIEWS ALL OF THE ITEMS IN AN EDITION IN A CONDENSED FORMAT AND GIVES A FORM TO EDIT THE ITEMS
	public function all_small($mag, $ed_id, $view_size = "condensed"){
		$this->load->view('home/header');

		$this->load->model('items_model', 'all');
		$items = $this->all->get_all($mag, $ed_id);
		// print_r($items);

		$this->load->model('items_model');
		$ed_data = $this->items_model->get_ed_data($mag, $ed_id);

		$this->load->model('advertisers_model');
		$advertisers_data = $this->advertisers_model->get_all($mag);
		

		if(count($items) < 1){
			$this->load->model('eds_model');
			$data = array('ed_data' => $ed_data, 'advertisers_data' => $advertisers_data);


			$this->load->view('items/not_this');
			$this->load->view('items/add_form', $data);
		}else{
			$this->load->model('items_model');
			$totals = $this->items_model->get_ed_totals($mag, $ed_id);
			// print_r($totals);
			$data = array('items' => $items, 'ed_data' => $ed_data, 'advertisers_data' => $advertisers_data, 'totals' => $totals);
			$this->load->view('items/all_small', $data);

		}

		$this->load->view('home/footer');
	}

	//A BASIC TABLE OF ITEMS WITH PAGE NUMBER INFORMATION = USED FOR PRINTING OFF A CLEAN SHEET OF PAGE NUMBERS FOR A DESIGNER
	public function layout_table($mag, $ed_id){

		$this->load->view('home/header');

		$this->load->model('items_model', 'all');
		$items = $this->all->get_all($mag, $ed_id);
		// print_r($items);

		$this->load->model('items_model');
		$ed_data = $this->items_model->get_ed_data($mag, $ed_id);

		$this->load->model('advertisers_model');
		$advertisers_data = $this->advertisers_model->get_all($mag);
		

		if(count($items) < 1){
			$this->load->model('eds_model');
			$data = array('ed_data' => $ed_data, 'advertisers_data' => $advertisers_data);


			$this->load->view('items/not_this');
			$this->load->view('items/add_form', $data);
		}else{
			$this->load->model('items_model');
			$totals = $this->items_model->get_ed_totals($mag, $ed_id);
			// print_r($totals);
			$data = array('items' => $items, 'ed_data' => $ed_data, 'advertisers_data' => $advertisers_data, 'totals' => $totals);
			$this->load->view('items/layout_table', $data);

		}

		$this->load->view('home/footer');
	}

	//A BASIC TABLE OF ITEMS AND PRICES - USED AS A STOP-GAP TILL BILLING IS MADE - CAN BE IMPORTED EASILY INTO MY BILLING SPREADSHEET
	//CAN BE DELETED WITH BILLING IS DONE
	public function billing_table($mag, $ed_id){

		$this->load->view('home/header');

		$this->load->model('items_model', 'all');
		$items = $this->all->get_all($mag, $ed_id);
		// print_r($items);

		$this->load->model('items_model');
		$ed_data = $this->items_model->get_ed_data($mag, $ed_id);

		$this->load->model('advertisers_model');
		$advertisers_data = $this->advertisers_model->get_all($mag);
		

		if(count($items) < 1){
			$this->load->model('eds_model');
			$data = array('ed_data' => $ed_data, 'advertisers_data' => $advertisers_data);


			$this->load->view('items/not_this');
			$this->load->view('items/add_form', $data);
		}else{
			$this->load->model('items_model');
			$totals = $this->items_model->get_ed_totals($mag, $ed_id);
			// print_r($totals);
			$data = array('items' => $items, 'ed_data' => $ed_data, 'advertisers_data' => $advertisers_data, 'totals' => $totals);
			$this->load->view('items/billing_table', $data);

		}

		$this->load->view('home/footer');
	}

	//IMPORTS ITEM DATA INTO THE DB FOR THE EDITION
	public function ad_this($mag, $ed_id)
	{
		$emh = $this->input->post('emh');
		$status = $this->input->post('status');
		$advertiser_id = $this->input->post('advertiser');
		$sold = $this->input->post('sold');
		$paid_item = $this->input->post('paid_item');
		$item_size = $this->input->post('item_size');
		$page_number = $this->input->post('page_number');
		$number_of_eds = $this->input->post('number_of_eds');
		$current_number_of_eds = $this->input->post('current_number_of_eds');
		$price = $this->input->post('price');
		$need_changes = $this->input->post('need_changes');
		$need_pics = $this->input->post('need_pics');
		$pics_taken = $this->input->post('pics_taken');
		$draft_made = $this->input->post('draft_made');
		$comments = $this->input->post('comments');
		$number_of_payments = $this->input->post('number_of_payments');

		if($paid_item == "N"){$price = 0;}


		if($advertiser_id == "House"){
			$advertiser = "House";
			$associated_user = $mag;
			$associated_user_id = $mag;
			$paid_item = "N";
			$price = 0;

		}else{
			$this->load->model('advertisers_model');
			$advertiser_data = $this->advertisers_model->get($advertiser_id);

			$advertiser = $advertiser_data['name'];
			$advertiser_id = $advertiser_data['id'];
			$associated_user = $advertiser_data['associated_user'];
			$associated_user_id = $advertiser_data['associated_user_id'];
		}


		$data = array(	
						'mag' => $mag,
						'ed_id' => $ed_id,
						'emh' => $emh, 
						'status' => $status,
						'advertiser_id' => $advertiser_id,
						'sold' => $sold,
						'paid_item' => $paid_item,
						'item_size' => $item_size,
						'page_number' => $page_number,
						'number_of_eds' => $number_of_eds,
						'current_number_of_eds' => $current_number_of_eds,
						'price' => $price,
						'need_changes' => $need_changes,
						'need_pics' => $need_pics,
						'pics_taken' => $pics_taken,
						'draft_made' => $draft_made,
						'comments' => $comments,
						'advertiser' => $advertiser,
						'advertiser_id' => $advertiser_id,
						'associated_user' => $associated_user,
						'associated_user_id' => $associated_user_id,
						'number_of_payments' => $number_of_payments,
						);

			$this->db->insert($mag."_edition_".$ed_id, $data);

			$this->load->model('items_model');
			$totals = $this->items_model->get_totals($mag, $ed_id);
			redirect(base_url()."items/all/".$mag."/".$ed_id);

	}


	public function delete($mag, $ed_id, $item_id)
	{
		$this->db->where('id', $item_id);
		$this->db->delete($mag."_edition_".$ed_id);

		$this->load->model('items_model');
		$totals = $this->items_model->get_totals($mag, $ed_id);

		redirect(base_url()."items/all/".$mag."/".$ed_id);
	}



	//INSTERTS THE VALUES OF THE EDITED ITEM INTO THE DB
	public function edit_this($mag, $ed_id, $view_size = "expanded"){
		// $this->output->enable_profiler(TRUE); 
		// echo "Hello Cleveland ".$mag." ".$ed_id."<br>";
		// var_dump($_POST);

		$data = $_POST;
		$length = count($data);
		$item_count = $length / 14;

		// echo $length." ".$item_count."<br>";
		$data_chunk = array_chunk($data, 14, true);

		// print_r($data_chunk[0]);

		for ($i=0; $i < $item_count; $i++) { 

			$data = $data_chunk[$i];
			// print_r($data);
			// echo "<br><br>";

			$data = array_values($data);

			$id = $data[0];

			$insert = array('status' => $data[1],
							'sold' => $data[2],
							'paid_item' => $data[3],
							'item_size' => $data[4],
							'page_number' => $data[5],
							'current_number_of_eds' => $data[6],
							'number_of_eds' => $data[7],
							'price' => $data[8],
							'need_changes' => $data[9],
							'emh' => $data[10],
							'need_pics' => $data[11],
							'draft_made' => $data[12],
							'comments' => $data[13]);


			$this->db->where('id', $id);
			$this->db->update($mag."_edition_".$ed_id, $insert);

		}

		$this->load->model('items_model');
		$totals = $this->items_model->get_totals($mag, $ed_id);

		redirect(base_url()."items/all/".$mag."/".$ed_id."/".$view_size);


	}

}



























 ?>