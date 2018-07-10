<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Apartments extends CI_Controller {
    function __construct()
    {
  		 parent::__construct();
		 
 	}
	
	public function index(){
		$this->_em = $this->doctrine->em;
		$data['apartments'] = $this->_em->getRepository('Entity\Apartments')->findAll();
		$data['body'] = 'apartments';
		$this->load->view('admin',$data);
	}
	public function lists(){
		
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$apartments = $qb->select('b','Entity\Area')->from('Entity\Apartment','b')->addOrderBy('b.id','desc')->innerJoin('b.area_id','Entity\Area')->getQuery()->getArrayResult();
		echo json_encode($apartments);
		die();
	}
	public function listsz(){
		
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$apartments = $qb->select('b','Entity\Area')->from('Entity\Apartment','b')->innerJoin('b.area_id','Entity\Area')->where('b.status=:status')->setParameter('status',1)->getQuery()->getArrayResult();
		echo json_encode($apartments);
		die();
	}
	
	public function arealistsz(){
		
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$apartments = $qb->select('b','Entity\Area')->from('Entity\Apartment','b')->innerJoin('b.area_id','Entity\Area')->where('b.status=:status')->setParameter('status',1)->getQuery()->getArrayResult();
		echo json_encode($apartments);
		die();
	}
	
	public function add(){
		
	}
	public function store(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$aptId 	 	  = $data->id;
		$areaId 	  = $data->area;
		$name 	    = $data->name;
		$address	  = $data->address;
		$landmark	  = $data->landmark;
		$mobile	 		= $data->mobile;
		$code	 		  = $data->code;
		$pincode	  = $data->pincode;
		$catalogId	= $data->catalog;
		
		$this->_em = $this->doctrine->em;
		$area = $this->_em->getRepository('Entity\Area')->find($areaId);
		
		if($catalogId){
			$catalog = $this->_em->getRepository('Entity\Catalog')->find($catalogId);
		}
		
		if($aptId){
			$apartment = $this->_em->find('Entity\Apartment',$aptId);
		}else{
			$apartment = new Entity\Apartment();
		}
		
	//	$apartment = new Entity\Apartment();
		$apartment->setName($name);
		$apartment->setAddress($address);
		$apartment->setLandmark($landmark);
		$apartment->setMobile($mobile);
		$apartment->setCode($code);
		$apartment->setPincode($pincode);
		$apartment->setAreaId($area);
		$apartment->setCatalogId($catalog);
		$this->_em->persist($apartment);
		$this->_em->flush();die();
	}
	public function update($id){
	
			
	}
	public function edit(){
	$input = file_get_contents("php://input");
		$data = json_decode($input);
		$id = $data;
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$apartment = $qb->select('a','Entity\Area','Entity\Catalog')->from('Entity\Apartment','a')->innerJoin('a.area_id','Entity\Area')->innerJoin('a.catalog_id','Entity\Catalog')->where('a.id=:id')->setParameter('id',$id)->getQuery()->getArrayResult();
		if(sizeof($apartment))
		echo json_encode($apartment[0]);
		die();	
		
	}
	public function status(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$areaId = $data;
		$this->_em = $this->doctrine->em;
	
		if((int)$areaId){
			$area = $this->_em->find('Entity\Apartment',(int)$areaId);
			$area->setStatus(!$area->getStatus());
			$this->_em->persist($area);
			$this->_em->flush(); die();
		}
		
		die();
	}
	
}