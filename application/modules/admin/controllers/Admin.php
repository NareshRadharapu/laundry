<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends MX_Controller {

    function __construct()
    {  		 
		parent::__construct();	
 	}
	
	public function index(){
		$data['body'] = '<ui-view></ui-view>';
		$this->load->view('admin',$data);
	
	}
	
}