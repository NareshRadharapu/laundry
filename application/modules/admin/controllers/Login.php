<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct()
    {
		parent::__construct();
 	}
	
	public function index(){
		$data['body'] = 'login';
		$this->load->view('admin',$data);
	}
	
}