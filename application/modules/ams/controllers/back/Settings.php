<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

    function __construct()
    {
  		 parent::__construct();
		 
		
		
 	}
	
	public function index(){
		$this->_em = $this->doctrine->em;
		$data['settings'] = $this->_em->getRepository('Entity\Settings')->findAll();
		$data['body'] = 'settings';
		$this->load->view('admin',$data);
	}
	
	public function lists(){

			$this->_em = $this->doctrine->em;
			$qb = $this->_em->createQueryBuilder();
			$settings = $qb->select('s')->from('Entity\Settings','s')->addOrderBy('s.id','desc')->getQuery()->getArrayResult();
			echo json_encode($settings);
			die();
	}
	public function listsz(){
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$settings = $qb->select('s')->from('Entity\Settings','s')->where('s.status=:status')->setParameter('status',1)->getQuery()->getArrayResult();
		echo json_encode($settings);
		die();
	}
	
	public function add(){
		
	}
	public function store(){
	if(1){	
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$cityId		= $data->id;
		$name 	    = $data->name;
		$status 	= 1;// $data->status;
		$this->_em = $this->doctrine->em;
	
		if((int)$cityId){
			$city = $this->_em->find('Entity\Settings',(int)$cityId);
		}else{
			$city = new Entity\Settings();
		}

		$city->setName($name);
//		$city->setStatus($status);
		$this->_em->persist($city);
		$this->_em->flush(); die();
	}else{
		die('403 : frobin');
	}
	
	}
	public function update($id){
	
			
	}
	public function edit(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$id = $data;
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$city = $qb->select('s')->from('Entity\Settings','s')->where('s.id=:id')->setParameter('id',$id)->getQuery()->getArrayResult();
		if(sizeof($city))
		echo json_encode($settings[0]);
		die();
		
	}
	public function status(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$sId = $data;
		$this->_em = $this->doctrine->em;

	
		if((int)$sId){
			$settings = $this->_em->find('Entity\Settings',(int)$sId);
			$settings->setStatus(!$settings->getStatus());
			$status = $settings->getStatus()?' disabled ':' enabled ';
			//$message = $city->getName().' status successfully '.$status;
			$this->_em->persist($settings);
			$this->_em->flush(); 
			die();
		}else{
			
		}
	}
	
	public function isuniquevalue(){
		return json_encode(array('isUnique'=>false));
	}
	
}