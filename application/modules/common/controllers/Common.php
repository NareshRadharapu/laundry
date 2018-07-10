<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common extends CI_Controller {
	
	function __construct()
    {
  		 parent::__construct();
		  $this->load->model('countriesstate_model');
		  
 	}
	
	function getStates(){
		$cid = $this->input->post('cid');
		
		$sdata = $this->countriesstate_model->getCountryStates($cid);
		
		$soptions = '<option value="">--- Select State ---</option>';
		foreach($sdata as $sdata_view){
			
			$soptions .= '<option value="'.$sdata_view->stateID.'">'.$sdata_view->stateName.'</option>';
		}
		echo $soptions;
	}
	
	
}