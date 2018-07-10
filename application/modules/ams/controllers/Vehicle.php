<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehicle  extends CI_Controller {

    function __construct()
    {
  		 parent::__construct();
		 
 	}
	
	public function index(){
	
	}
	public function lists(){
		
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		
			$vehicles = $qb->select('v','Entity\Apartment','Entity\Block','Entity\Flat')->from('Entity\Vehicle','v')->innerJoin('v.apt_id','Entity\Apartment')->innerJoin('v.block_id','Entity\Block')->innerJoin('v.flat_id','Entity\Flat')->addOrderBy('v.id','desc')->getQuery()->getArrayResult();
		
		echo json_encode($vehicles);
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

	public function store(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		
		$vehicleId  =0;
		if(property_exists($data,'id'))
		$vehicleId = $data->id;
		$aptId 	    = $data->apartment;
		$blockId	= $data->block;
		$flatId	 	= $data->flat;
		$customerId	= $data->customerId;
		
		
		$vtype	 	= $data->vtype;
		$brand	 	= $data->brand;
		$regno	 	= $data->regno;
		$rfid	 	= $data->rfid;
		
		
		$this->_em = $this->doctrine->em;
		
		
		$apartment = $this->_em->getRepository('Entity\Apartment')->find($aptId);
		$block = $this->_em->find('Entity\Block',$blockId);
		$flat = $this->_em->find('Entity\Flat',$flatId);
		$customer = $this->_em->find('Entity\Customer',$customerId);
		
		if($vehicleId){
			$vehicle = $this->_em->find('Entity\Vehicle',$vehicleId);
		}else{
			$vehicle = new Entity\Vehicle();
		}
		
		$vehicle->setVtype($vtype);
		$vehicle->setRegNumber($regno);
		$vehicle->setMake($brand);
		$vehicle->setRfid($vtype);
		
		
		$vehicle->setApartmentId($apartment);
		$vehicle->setBlockId($block);
		$vehicle->setFlatId($flat);
		$vehicle->setCustomerId($customer);
		
		$this->_em->persist($vehicle);
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
		$vehicle = $qb->select('v','Entity\Apartment','Entity\Block','Entity\Flat','Entity\Customer')->from('Entity\Vehicle','v')->innerJoin('v.apt_id','Entity\Apartment')->innerJoin('v.block_id','Entity\Block')->innerJoin('v.flat_id','Entity\Flat')->innerJoin('v.cust_id','Entity\Customer')->where('v.id=:id')->setParameter('id',$id)->getQuery()->getArrayResult();
		if(sizeof($vehicle))		echo json_encode($vehicle[0]);		die();	
		
	}
	public function status(){
	
	    $input = file_get_contents("php://input");
		$data = json_decode($input);
		$blockId = $data;
		$this->_em = $this->doctrine->em;
	
		if((int)$blockId){
			$block = $this->_em->find('Entity\Vehicle',(int)$blockId);
			$block->setStatus(!$block->getStatus());
			$this->_em->persist($block);
			$this->_em->flush(); 
			die();
		}
		
		die();	
	}
	
}