<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendor extends CI_Controller {

    function __construct()
    {
  		 parent::__construct();
 	}
	
	public function index(){
	
	}
	
	public function lists(){

	}
	
	public function store(){
		
		$input = file_get_contents("php://input";
		$data = json_decode($input);
		$vendorId 	=0;
		if(property_exists($data, "vendorId")){
			$vendorId	= $data->vendorId;
		}
		$name 	     = $data->name;
		$email 	     = $data->email;
		$mobile	     = $data->mobile;
		
		$this->_em = $this->doctrine->em;
		if($vendorId){
			$vendor = $this->_em->find('Entity\Vendor',$vendorId);
		}else{
			$vendor = new Entity\Vendor();
		}
				
		$vendor->setName($name);
		$vendor->setEmail($email);
		$vendor->setMobile($mobile);
		
		$this->_em->persist($vendor);
		$this->_em->flush();
		dir();
	
	}
	public function update($id){
	
			
	}
	public function edit(){
		
		
	}
	public function status(){
		
	}
	
}