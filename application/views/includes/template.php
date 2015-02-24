<?php 

$this->load->view('includes/header');

if($main_content == 'in_use'){
	$this->load->view('signup_form');
	$this->load->view('includes/in_use');
}else{
	$this->load->view($main_content);
}


$this->load->view('includes/footer');

?>