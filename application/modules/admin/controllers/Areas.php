<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Areas extends CI_Controller {
    function __construct()
    {
		//$this->output->cache(1); 
  		parent::__construct();
 	}
	
	public function index(){
		$this->_em = $this->doctrine->em;
		$data['areas'] = $this->_em->getRepository('Entity\Area')->findAll();
		$data['body'] = 'areas';
		$this->load->view('admin',$data);
	}
	public function lists(){
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$areas = $qb->select('a','Entity\City','Entity\Service','Entity\Catalog')->from('Entity\Area','a')->leftJoin('a.areaServices','Entity\Service')->addOrderBy('a.id','desc')->innerJoin('a.city_id','Entity\City')->leftJoin('a.catalog_id','Entity\Catalog')->getQuery()->getArrayResult();
		echo json_encode($areas);
		die();
	}
	public function listsz(){	
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$areas = $qb->select('a','Entity\City','Entity\Service','Entity\Catalog')->from('Entity\Area','a')->innerJoin('a.city_id','Entity\City')->leftJoin('a.areaServices','Entity\Service')->leftJoin('a.catalog_id','Entity\Catalog')->where('a.status=:status')->setParameter('status',1)->getQuery()->getArrayResult();
		echo json_encode($areas);
		die();
	}
	public function add(){
		
	}
	public function store(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		if(is_object($data)){
			try{
				$this->_em = $this->doctrine->em;
				if(property_exists($data, 'city')){
					$cityId 	= $data->city;
					$city = $this->_em->getRepository('Entity\City')->find($cityId);
				}
				if(property_exists($data, 'catalog')){
					$catId 	= $data->catalog;
					$catalog = $this->_em->getRepository('Entity\Catalog')->find($catId);
				}
				$areaId=0;
				if(property_exists($data, 'id')){
					$areaId		= $data->id;
				}
				if($areaId){
					$area = $this->_em->find('Entity\Area',$areaId);
				}else{
					$area = new Entity\Area();
				}
				$name 	    = $data->name;
				$code       = $data->code;
			//	$catalog    = $data->catalog;
				$address    = $data->address;
				$landmark   = $data->landmark;
				$pincode    = $data->pincode;
				$mobile     = $data->mobile;
				if(property_exists($data, 'isServiceTax')){

					$servicetax     = $data->isServiceTax;
				}else{
					
					$servicetax     = 0;
				}
				$area->removeService();
				if(property_exists($data, 'sservices')){
					$services = $data->sservices;
					foreach ($services as $key => $value) {
						$service = $this->_em->find('Entity\Service',$value);
						if(is_object($service))
						$area->addService($service);
					}
				}
				$status     = 1; //$data->status;
				
				$area->setName($name);
				$area->setCode($code);
				$area->setCatalogId($catalog);
				$area->setAddress($address);
				$area->setLandmark($landmark);
				$area->setPincode($pincode);
				$area->setMobile($mobile);
				$area->setisServiceTax($servicetax);
				$area->setStatus($status);
				$area->setCityId($city);
				$this->_em->persist($area);
				$this->_em->flush();die();
			}catch(Exception $e){
				
				die($e->getMessage());
			}
		}else{
			die('data transmission is wrong');
		}
		
	}
	public function update($id){	
	}
	public function edit(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$id = $data;
		$this->_em = $this->doctrine->em;
		try{
			$areaObj = $this->_em->find('Entity\Area',$id);
			$area = array();
			$area['id'] 	= $areaObj->getId();
			$area['name'] 	= $areaObj->getName();
			$area['code'] 	= $areaObj->getCode();
			$area['address'] 	= $areaObj->getAddress();
			$area['landmark'] = $areaObj->getLandmark();
			$area['pincode'] 	= $areaObj->getPincode();
			$area['mobile'] 	= $areaObj->getMobile();
			$area['catalog'] 	= $areaObj->getCatalogId()->getId();
			$area['status']	= $areaObj->getStatus();
			$area['isServiceTax']	= $areaObj->getisServiceTax();
			$area['city']   = $areaObj->getCityId()->getId();
			$s = array();
			foreach ($areaObj->getServices() as $key => $value) {
				$s[] = $value['id'];
			}
			$area['sservices']  = $s;
			echo json_encode($area);
			die();
		}catch(Exception $e){
			$this->output->set_status_header(500);
			die($e->getMessage());
		}
		//$qb = $this->_em->createQueryBuilder();
		//$area = $qb->select('a','Application_Entity_City')->from('Entity\Area','a')->innerJoin('a.city_id','Application_Entity_City')->where('a.id=:id')->setParameter('id',$id)->getQuery()->getArrayResult();
		
		die();
	}
	public function status(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$areaId = $data;
		$this->_em = $this->doctrine->em;
	
		if((int)$areaId){
			$area = $this->_em->find('Entity\Area',(int)$areaId);
			$area->setStatus(!$area->getStatus());
			$this->_em->persist($area);
			$this->_em->flush(); die();
		}
		
		die();
	}
	
}