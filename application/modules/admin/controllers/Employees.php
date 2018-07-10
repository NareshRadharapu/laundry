<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employees extends CI_Controller {

    function __construct()
    {
  		 parent::__construct();
		 
		
 	}
	
	public function index(){
		$this->_em = $this->doctrine->em;
		$data['employees'] = $this->_em->getRepository('Entity\Employee')->findAll();
		$data['body'] = 'employees';
		$this->load->view('admin',$data);
	}
	
	public function add(){
		
	}
	public function store(){
		
		$input = file_get_contents("php://input";
		$data = json_decode($input);
		$roleId 	 = 1; //$data->roleId;
		$name 	     = 1; //$data->name;
		$email 	     = 1; //$data->email;
		$mobile	     = 1; //$data->mobile;
		$password    = 1; //$data->password;
		$status      = 1; //$data->status;
		
	//	$this->load->library('form_validation');
	//	$name = $_POST['name'];
		
		
		$this->_em = $this->doctrine->em;
		$role = $this->_em->getRepository('Entity\Role')->find($roleId);
		
		if($empId){
			$employee = $this->_em->find('Entity\Employee',$empId);
		}else{
			$employee = new Entity\Employee();
		}
				
		$employee = new Entity\Employee();
		$employee->setName($name);
		$employee->setEmail($email);
		$employee->setMobile($mobile);
		$employee->setPassword($password);
		$employee->setStatus($status);
		$employee->seRoleId($role);
		$this->_em->persist($employee);
		$this->_em->flush();die("error");
	//	return redirect('admin/areas');
	}
	public function update($id){
	
			
	}
	public function edit(){
		
		
	}
	public function status(){
		
	}
	
}