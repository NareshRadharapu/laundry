<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct()
    {
  		 parent::__construct();
		 
		 if(!$this->session->userdata('logged_ichapps'))
	     {
			redirect('login', 'refresh');
		 }
 	}
	
	public function index(){
		
		$this->load->view('common/header');
		$this->load->view('dashboard_view');
		$this->load->view('common/footer-model');
		$this->load->view('common/js-files');
		$this->load->view('js-dashboard');
	}
	
}