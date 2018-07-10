<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Catalog extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	}
	public function index(){
		$this->_em = $this->doctrine->em;
		$data['catalog'] = $this->_em->getRepository('Entity\Catalog')->findAll();
		$data['body'] = 'catalog';
		$this->load->view('admin',$data);
	}
	public function lists(){
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$catalogs = $qb->select('c')->from('Entity\Catalog','c')->addOrderBy('c.id','asc')->getQuery()->getArrayResult();
		echo json_encode($catalogs);
		die();
	}
	public function listsz(){
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$catalogs = $qb->select('c')->from('Entity\Catalog','c')->where('c.status=:status')->setParameter('status',1)->getQuery()->getArrayResult();
		echo json_encode($catalogs);
		die();
	}
	public function itemslist(){
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$catalogitems = $qb->select('cp','Entity\Catalog','Entity\Item','Entity\ItemType','Entity\Service')->addOrderBy('cp.id','desc')->from('Entity\CatalogPrice','cp')->innerJoin('cp.catalog_id','Entity\Catalog')->innerJoin('cp.item_id','Entity\Item')->innerJoin('cp.itype_id','Entity\ItemType')->innerJoin('cp.service_id','Entity\Service')->getQuery()->getArrayResult();
		echo json_encode($catalogitems);
		die();
	}
	public function itemslistz(){
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$catalogitems = $qb->select('cp','Entity\Catalog','Entity\Item','Entity\ItemType','Entity\Service')->from('Entity\CatalogPrice','cp')->innerJoin('cp.catalog_id','Entity\Catalog')->innerJoin('cp.item_id','Entity\Item')->innerJoin('cp.itype_id','Entity\ItemType')->innerJoin('cp.service_id','Entity\Service')->where('cp.status=:status')->setParameter('status',1)->getQuery()->getArrayResult();
		echo json_encode($catalogitems);
		die();
	}
	public function catalogservices(){
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$result = array();
		if($data){
			$catalogservices = $qb->select('c','Entity\Service')->from('Entity\CatalogPrice','c')->innerJoin('c.service_id','Entity\Service')->where('c.catalog_id=:catalog_id')->setParameter('catalog_id',$data)->getQuery()->getResult();
			$s  = array();
			foreach ($catalogservices as $key => $obj) {
				$r = array();
				$sid = $obj->getServiceId()->getId();
				$r['service_id'] 	= $sid;
				$r['service_name'] 	= $obj->getServiceId()->getName();
				$r['catalog_id'] 	= $obj->getCatalogId()->getId();
				if(!in_array($sid,$s)){
					$result[] = $r;
				}
				$s[] = (int)$sid;
			}
		}
		echo json_encode($result);
		die();
	}
	public function serviceitems(){
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$catalogId = $data->catalogid;
		$serviceId = $data->serviceid; 
	//	print_r($serviceId);
		if($data){
			$serviceitems = $qb->select('c','Entity\Service','Entity\Itemtype','Entity\Item')->from('Entity\CatalogPrice','c')->innerJoin('c.service_id','Entity\Service')->innerJoin('c.item_id','Entity\Item')->innerJoin('c.itype_id','Entity\Itemtype')->where('c.catalog_id=:catalog_id and c.service_id=:service_id')->setParameters(array('service_id'=>$serviceId,'catalog_id'=>$catalogId))->getQuery()->getArrayResult();
		}
		echo json_encode($serviceitems);
		die();
	}
	public function add(){
	}
	public function store(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$catId	     =  $data->id;
		$name 	     =  $data->name;
		$description 	     =  $data->description;
		$status      = 1; //$data->status;
		$this->_em = $this->doctrine->em;
		if($catId){
			$catalog = $this->_em->find('Entity\Catalog',$catId);
		}else{
			$catalog = new Entity\Catalog();
		}
		$catalog->setName($name);
		$catalog->setDescription($description);
//		$catalog->setStatus($status);
		$this->_em->persist($catalog);
		$this->_em->flush(); die();
	}
	public function storeitems(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$catItemId =0;
		if(property_exists($data,'id')){
			$catItemId	    =  $data->id;
		}
		$catId	     	=  $data->catalog;
		$serviceId 	    =  $data->service;
		$itemTypeId 	=  $data->itemtype;
		$itemId 		=  $data->item;
		$price 			=  number_format($data->price,2,'.','');
		//$data->price;
		$discount 		=  0;
		if(property_exists($data,'id')){
			$discount 		=  $data->discount;
		}
		$rpoints 		=  $data->rpoints;
		$this->_em = $this->doctrine->em;
		if($catId){
			$catalog = $this->_em->find('Entity\Catalog',$catId);
		}else{
			return;
		}
		if($serviceId){
			$service = $this->_em->find('Entity\Service',$serviceId);
		}else{
			return;
		}
		if($itemTypeId){
			$itemType = $this->_em->find('Entity\ItemType',$itemTypeId);
		}else{
			return;
		}
		if($itemId){
			$item = $this->_em->find('Entity\Item',$itemId);
		}else{
			return;
		}
		if($catItemId){
			$catPrice = $this->_em->find('Entity\CatalogPrice',$catItemId);
		}else{
			$catPrice = new Entity\CatalogPrice();
		}
		$catPrice->setCost($price);
		if($discount){
			$catPrice->setDiscount($discount);
		}else{
			$catPrice->setDiscount(0);
		}
		$catPrice->setCatalogId($catalog);
		$catPrice->setServiceId($service);
		$catPrice->setItemTypeId($itemType);
		$catPrice->setItemId($item);
		$catPrice->setRpoints($rpoints);
		$this->_em->persist($catPrice);
		$this->_em->flush(); die();
	}
	public function update($id){
	}
	public function edit(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$id = $data;
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$city = $qb->select('c')->from('Entity\Catalog','c')->where('c.id=:id')->setParameter('id',$id)->getQuery()->getArrayResult();
		if(sizeof($city))
			echo json_encode($city[0]);
		die();
	}
	public function edititem(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$id = $data;
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$catalogItem = $qb->select('cp','Entity\Catalog','Entity\Item','Entity\ItemType','Entity\Service')->from('Entity\CatalogPrice','cp')->innerJoin('cp.catalog_id','Entity\Catalog')->innerJoin('cp.item_id','Entity\Item')->innerJoin('cp.itype_id','Entity\ItemType')->innerJoin('cp.service_id','Entity\Service')->where('cp.id=:id')->setParameter('id',$id)->getQuery()->getArrayResult();
		if(sizeof($catalogItem))
			echo json_encode($catalogItem[0]);
		die();
	}
	public function status(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$catId = $data;
		$this->_em = $this->doctrine->em;
		if((int)$catId){
			$catalog = $this->_em->find('Entity\Catalog',(int)$catId);
			$catalog->setStatus(!$catalog->getStatus());
			$this->_em->persist($catalog);
			$this->_em->flush(); die();
		}
		die();
	}
	public function statusitem(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$catItemId = $data;
		$this->_em = $this->doctrine->em;
		if((int)$catItemId){
			$catalogItem = $this->_em->find('Entity\CatalogPrice',(int)$catItemId);
			$catalogItem->setStatus(!$catalogItem->getStatus());
			$this->_em->persist($catalogItem);
			$this->_em->flush(); die();
		}
		die();
	}
}