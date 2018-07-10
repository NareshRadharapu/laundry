<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blocks extends CI_Controller {

    function __construct()
    {
  		 parent::__construct();
		 
 	}
	
		public function index(){
		$this->_em = $this->doctrine->em;
		$data['bocks'] = $this->_em->getRepository('Entity\Block')->findAll();
		$data['body'] = 'blocks';
		$this->load->view('admin',$data);
	}
	public function lists(){
		
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		if($data){
			$blocks = $qb->select('b','Entity\Apartment')->from('Entity\Block','b')->addOrderBy('b.id','desc')->innerJoin('b.apt_id','Entity\Apartment')->where('b.apt_id=:apt_id')->setParameter('apt_id',$data)->getQuery()->getArrayResult();
		}else{
			$blocks = $qb->select('b','Entity\Apartment')->from('Entity\Block','b')->addOrderBy('b.id','desc')->innerJoin('b.apt_id','Entity\Apartment')->getQuery()->getArrayResult();
		}
		echo json_encode($blocks);
		die();
	}
	
	public function listsz(){
		
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		if($data){
			$blocks = $qb->select('b','Entity\Apartment')->from('Entity\Block','b')->innerJoin('b.apt_id','Entity\Apartment')->where('b.apt_id=:apt_id and b.status=:status')->setParameter('apt_id',$data)->setParameter('status',1)->getQuery()->getArrayResult();
		}else{
			$blocks = $qb->select('b','Entity\Apartment')->from('Entity\Block','b')->innerJoin('b.apt_id','Entity\Apartment')->where('b.status=:status')->setParameter('status',1)->getQuery()->getArrayResult();
		}
		echo json_encode($blocks);
		die();
	}	
	
	
	public function apartmentsblockswithflats(){
		
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		if($data){
			$blocks = $qb->select('b','Entity\Apartment','Entity\Flat')->from('Entity\Block','b')->innerJoin('b.apt_id','Entity\Apartment')->leftJoin('b.flats','Entity\Flat')->where('b.apt_id=:apt_id and b.status=:status')->setParameter('apt_id',$data)->setParameter('status',1)->getQuery()->getArrayResult();
		}else{
			$blocks = $qb->select('b','Entity\Apartment')->from('Entity\Block','b')->innerJoin('b.apt_id','Entity\Apartment')->where('b.status=:status')->setParameter('status',1)->getQuery()->getArrayResult();
		}
		echo json_encode($blocks);
		die();
	}	
	
	
	public function add(){
		
	}
	public function store(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$blockId=0;
		if(property_exists($data,'id'))
		$blockId	 = $data->id;
		
		$aptId 	     = $data->apartment;
		$name 	     = $data->name;
		$status      =1;// $data->status;

		$this->_em = $this->doctrine->em;
		$apartment = $this->_em->getRepository('Entity\Apartment')->find($aptId);
		
		if($blockId){
			$block = $this->_em->find('Entity\Block',$blockId);
		}else{
			$block = new Entity\Block();
		}
		
		$block->setName($name);
		$block->setStatus($status);
		$block->setApartmentId($apartment);
		$this->_em->persist($block);
		$this->_em->flush();die("error");
	}
	public function update($id){
	
			
	}
	public function edit(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);		
		$id = $data;		
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$block = $qb->select('a','Entity\Apartment')->from('Entity\Block','a')->innerJoin('a.apt_id','Entity\Apartment')->where('a.id=:id')->setParameter('id',$id)->getQuery()->getArrayResult();
		if(sizeof($block))		echo json_encode($block[0]);		die();	
		
	}
	public function status(){
	
	    $input = file_get_contents("php://input");
		$data = json_decode($input);
		$blockId = $data;
		$this->_em = $this->doctrine->em;
	
		if((int)$blockId){
			$block = $this->_em->find('Entity\Block',(int)$blockId);
			$block->setStatus(!$block->getStatus());
			$this->_em->persist($block);
			$this->_em->flush(); die();
		}
		
		die();	
	}
	
}