<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faculty extends CI_Controller {

    function __construct()
    {
  		 parent::__construct();
		 
 	}
	
		public function index(){ 
		$this->_em = $this->doctrine->em;
		$data['customers'] = $this->_em->getRepository('Entity\Customer')->findAll();
		$data['body'] = 'customers';
		$this->load->view('admin',$data);
	}
	public function lists(){
		
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$faculties = $qb->select('f','Entity\Apartment')->from('Entity\Faculty','f')->innerJoin('f.apt_id','Entity\Apartment')->addOrderBy('f.id','desc')->getQuery()->getArrayResult();
		echo json_encode($faculties);
		die();
	}
	
	public function listsz(){
		
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$aptcustomers = $qb->select('a','Entity\Apartment','Entity\Block','Entity\Flat')->from('Entity\Customer','a')->where('a.type=:type')->setParameter('type','apartment')->addOrderBy('a.id','desc')->innerJoin('a.apt_id','Entity\Apartment')->innerJoin('a.block_id','Entity\Block')->innerJoin('a.flat_id','Entity\Flat')->getQuery()->getArrayResult();
				
		echo json_encode($aptcustomers);
		die();
	}
		
	public function store(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$custId	         = $data->id;
		$firstname 	     = $data->firstname;
		$lastname 	     = $data->lastname;
		$email 	         = $data->email;
		$password 	     = $this->getnewpwd(); //'abc';//$data->password;
		$mobile 	     = $data->mobile;
		$role			 = $data->role;
		
		$aptId	 		 = $data->apartment;
		$blockId		 = $data->block;
		$flatId			 = $data->flat;
	//	$address 	     = $data->address;   
		$status          =1;// $data->status;
		
	//print_r ($data); die();
		
		$this->_em = $this->doctrine->em;
		
		
		if($mobile){
			$faculty = $this->_em->getRepository('Entity\Faculty')->findOneBy(array('mobile'=>$mobile));
			if(!is_object($faculty)){
				$faculty = new Entity\Faculty();	
			}
		}else{
			$faculty = new Entity\Faculty();
		}
		
		$apartment 	= $this->_em->getRepository('Entity\Apartment')->find($aptId);
		
		
		$faculty->setFirstName($firstname);
		$faculty->setLastName($lastname);
		$faculty->setEmail($email);
		$faculty->setPassword($password);
		$faculty->setMobile($mobile);
		$faculty->setDesignation($role);
		
		$faculty->setApartmentId($apartment);
		//$faculty->setAddress($apartment->getAddress()); 
		$faculty->setStatus($status);

		$this->_em->persist($faculty);
		$this->_em->flush();die();
		
	}
	
	public function edit(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$id = $data;
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$faculty = $qb->select('f','Entity\Apartment')->from('Entity\Faculty','f')->innerJoin('f.apt_id','Entity\Apartment')->where('f.id=:id')->setParameter('id',$id)->getQuery()->getArrayResult();
		if(sizeof($faculty))
		echo json_encode($faculty[0]);
		die();	
		
	}
		
	
	
	public function status(){
	
	    $input = file_get_contents("php://input");
		$data = json_decode($input);
		$custId = $data;
		$this->_em = $this->doctrine->em;
	
		if((int)$custId){
			$faculty = $this->_em->find('Entity\Faculty',(int)$custId);
			$faculty->setStatus(!$faculty->getStatus());
			$this->_em->persist($faculty);
			$this->_em->flush(); die();
		}
		
		die();	
	}
	private function getnewpwd() {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		return substr(str_shuffle($chars),0,8);
	}
	
}