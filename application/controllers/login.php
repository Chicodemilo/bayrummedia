<?php 


class Login extends CI_Controller
{
	
	function index()
	{
		$data['main_content'] = "login_form";
		$this->load->view('includes/template', $data);
	}


	function validate_credentials()
	{
		$this->load->model('membership_model');
		$query = $this->membership_model->validate();
		// $query = false;

		if($query){
			$this->load->model('user_model');
			$more_userdata = $this->user_model->info_for_session($this->input->post('username'));

			$data = array(
				'username' => $this->input->post('username'),
				'is_logged_in' => true,
				'first_name' => $more_userdata[0]['first_name'],
				'last_login' => $more_userdata[0]['last_login']);

			$this->session->set_userdata($data);
			redirect('home/index');
		}else{
			// echo "No Way!!!";
			$this->index();
		}
	}

	function signup(){
		$data['main_content'] = 'signup_form';
		$this->load->view('includes/template', $data);
	}

	function create_member(){
		$this->load->library('form_validation');

		//field name, error message, validation rules
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[32]');
		$this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');

		if($this->form_validation->run() == FALSE){
			$this->signup();
		}else{
			$this->load->model('membership_model');
			if($query = $this->membership_model->create_member()){
				$data['main_content'] = 'signup_successful';
				$this->load->view('includes/template', $data);
			}else{
				$data['main_content'] = 'in_use';

				$this->load->view('includes/template', $data);
			}
		}

	}
}

 ?>