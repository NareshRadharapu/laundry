<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customers extends CI_Controller {

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
	public function customerlists(){
		
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$customers = $qb->select('c')->from('Entity\Customer','c')->where('c.type=:type')->setParameter('type','user')->addOrderBy('c.id','desc')->getQuery()->getArrayResult();
		echo json_encode($customers);
		die();
	}
	
	public function aptlists(){
		
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$aptcustomers = $qb->select('a','Entity\Apartment','Entity\Block','Entity\Flat')->from('Entity\Customer','a')->where('a.type=:type')->setParameter('type','apartment')->addOrderBy('a.id','desc')->innerJoin('a.apt_id','Entity\Apartment')->innerJoin('a.block_id','Entity\Block')->innerJoin('a.flat_id','Entity\Flat')->getQuery()->getArrayResult();
				

		//$aptcustomers = $qb->select('c')->from('Entity\Customer','c')->where('c.type=:type')->setParameter('type','apartment')->addOrderBy('c.id','desc')->getQuery()->getArrayResult();
		//		$items = $qb->select('cp','Entity\Item','Entity\ItemType','Entity\Service')->from('Entity\CatalogPrice','cp')->innerJoin('cp.item_id','Entity\Item')->innerJoin('cp.itype_id','Entity\ItemType')->innerJoin('cp.service_id','Entity\Service')->where('cp.catalog_id = :catalogId and Entity\Item.status=:status')->setParameter('catalogId',$catalogId)->setParameter('status',1)->getQuery()->getArrayResult();
	//	print_r($aptcustomers);
		echo json_encode($aptcustomers);
		die();
	}
	
	
	
	public function add(){
		
	}
	public function customerstore(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$custId	         = $data->id;
		$firstname 	     = $data->firstname;
		$lastname 	     = $data->lastname;
		$email 	         = $data->email;
		$password 	     = $this->getnewpwd(); //'abc';//$data->password;
		$mobile 	     = $data->mobile;
		$type			 = 'user';//$data->type; 
		$areaId			 = $data->area;
		$address 	     = $data->address; 
		$landmark 	     = $data->landmark;   
	//	$rpoints 	     = $data->rpoints; 
		$refid   	     = $data->refid;
		$status          =1;// $data->status;
		
	//print_r ($data); die();
		
		$this->_em = $this->doctrine->em;
		//$apartment = $this->_em->getRepository('Entity\Apartment')->find($aptId);
		$area = $this->_em->getRepository('Entity\Area')->find($areaId);
		
		if($custId){
			$customer = $this->_em->find('Entity\Customer',$custId);
		}else{
			$customer = new Entity\Customer();
			$customeraddress = new Entity\CustomerAddress();
		}
		
		$customer->setFirstName($firstname);
		$customer->setLastName($lastname);
		$customer->setEmail($email);
		$customer->setPassword($password);
		$customer->setPhoneNo($mobile);
		$customer->setUserType($type);
		$customer->setAreaId($area);
	//	$customer->setRpoints($rpoints);
	
		$customer->setRefId($refid);
		$customer->setStatus($status);
		$this->_em->persist($customer);
		
	
		$customeraddress->setAddress($address);
		$customeraddress->setLandmark($landmark); 
		$this->_em->persist($customeraddress);
		$this->_em->flush();die(); 
		
	}
	
	public function aptstore(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$custId	         = $data->id;
		$firstname 	     = $data->firstname;
		$lastname 	     = $data->lastname;
		$email 	         = $data->email;
		$password 	     = $this->getnewpwd(); //'abc';//$data->password;
		$mobile 	     = $data->mobile;
		$type			 = 'apartment';//$data->type; 
		$areaId			 = $data->area;
		$aptId	 		 = $data->apartment;
		$blockId		 = $data->block;
		$flatId			 = $data->flat;
		$address 	     = $data->address;   
	//	$rpoints 	     = $data->rpoints; 
		$refid   	     = $data->refid;
		$status          =1;// $data->status;
		
	//print_r ($data); die();
		
		$this->_em = $this->doctrine->em;
		
		$apartment 	= $this->_em->getRepository('Entity\Apartment')->find($aptId);
		
		$block 		= $this->_em->getRepository('Entity\Block')->find($blockId);
		
		$flat 		= $this->_em->getRepository('Entity\Flat')->find($flatId);
		
		$area = $this->_em->getRepository('Entity\Area')->find($areaId);
		
		if($custId){
			$customer = $this->_em->find('Entity\Customer',$custId);
		}else{
			$customer = new Entity\Customer();
		}
		
		$customer->setFirstName($firstname);
		$customer->setLastName($lastname);
		$customer->setEmail($email);
		$customer->setPassword($password);
		$customer->setPhoneNo($mobile);
		$customer->setUserType($type);
		
		$customer->setApartmentId($apartment);
		$customer->setAddress($apartment->getAddress()); 
		$customer->setBlockId($block);
		$customer->setFlatId($flat);
		
		
	//	$customer->setRpoints($rpoints);
	
		$customer->setRefId($refid);
		$customer->setStatus($status);

		$this->_em->persist($customer);
		$this->_em->flush();die();
	}
	
	public function update($id){
	
			
	}
	public function getaddress(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$id = $data;
		$this->_em = $this->doctrine->em;
		
		$qb = $this->_em->createQueryBuilder();
		$addressresult = array();
		if($id){
		$address = $qb->select('a','Entity\Customer')->from('\Entity\CustomerAddress','a')->join('a.cust_id','Entity\Customer')->where('Entity\Customer.id=:id')->setParameter('id',$id)->getQuery()->getArrayResult();
		foreach($address as $ad){
			$adds = array();
			$adds['address_id'] = $ad['id'];
			$adds['landmark'] = $ad['landmark'];
			$adds['address'] = $ad['address'];
			$adds['customer_id'] = $ad['cust_id']['id'];
			$adds['customer_name'] = $ad['cust_id']['firstname'].' '.$ad['cust_id']['lastname'];
			$addressresult[] = $adds;
		}
		
		if(sizeof($addressresult))
		echo json_encode($addressresult);
		die();	
		}else{
			echo json_encode($addressresult);
		die();	
		}
	}
	public function getbymobile(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$id = $data;
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$customer = $qb->select('a','Entity\Area')->from('Entity\Customer','a')->leftJoin('a.area_id','Entity\Area')->where('a.mobile=:mobile')->setParameter('mobile',$id)->getQuery()->getArrayResult();
		if(sizeof($customer))
		echo json_encode($customer[0]);
		die();	
		
	}
	public function customeredit(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$id = $data;
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$customer = $qb->select('a','Entity\Area')->from('Entity\Customer','a')->innerJoin('a.area_id','Entity\Area')->where('a.id=:id')->setParameter('id',$id)->getQuery()->getArrayResult();
		if(sizeof($customer))
		echo json_encode($customer[0]);
		die();	
		
	}
		
	public function aptedit(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$id = $data;
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		
		$customer = $qb->select('c','Entity\Apartment','Entity\Block','Entity\Flat')->from('Entity\Customer','c')->leftJoin('c.apt_id','Entity\Apartment')->leftJoin('c.block_id','Entity\Block')->leftJoin('c.flat_id','Entity\Flat')->where('c.id=:id')->setParameter('id',$id)->getQuery()->getArrayResult();
		
		if(sizeof($customer))
		echo json_encode($customer[0]);
		die();	
		
	}
	
	public function flatcustlists(){
		
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder(); 
		$input = file_get_contents("php://input");
		$data = json_decode($input);

		$customers = $qb->select('c')->from('Entity\Customer','c')->where('c.flat_id=:flat_id')->setParameter('flat_id',$data)->getQuery()->getArrayResult();
		echo json_encode($customers);
		die();
	}
	
	public function custview(){

		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$id = $data;
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
	$customer = $qb->select('c')->from('Entity\Customer','c')->where('c.id=:id')->setParameter('id',$id)->getQuery()->getArrayResult();
		if(sizeof($customer))
		echo json_encode($customer[0]);
		die();
	}
	public function orderview(){

		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$id = $data;
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
	$orders = $qb->select('po')->from('Entity\PlaceOrder','po')->where('po.cust_id=:cust_id')->setParameter('cust_id',$id)->getQuery()->getArrayResult();
		echo json_encode($orders);
		die();
	}	
	public function orderdetails(){

		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$id = $data;
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
	$orderdetails = $qb->select('po')->from('Entity\PlaceOrder','po')->where('po.cust_id=:cust_id')->setParameter('cust_id',$id)->getQuery()->getArrayResult();
		echo json_encode($orderdetails);
		die();
	}
	
	public function ordersummary(){

		$id = file_get_contents("php://input");
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$ordersummary = array();
		$po = $qb->select('o','Entity\Item','Entity\Service','Entity\PlaceOrderAddon','Entity\Addon')->from('Entity\PlaceOrder','o')->leftJoin('o.item_id','Entity\Item')->leftJoin('o.service_id','Entity\Service')->leftJoin('o.placeOrderAddons','Entity\PlaceOrderAddon')->leftJoin('Entity\PlaceOrderAddon.addon_id','Entity\Addon')->where('o.order_id=:order_id')->setParameter('order_id',$id)->getQuery()->getArrayResult();
		

		foreach($po as $k=>$v){
			$service = $v['service_id']['name'];
			$so['item'] = $v['item_id']['name'];
			$so['icount'] = $v['icount'];
			$so['cost'] = $v['cost'];

				if(array_key_exists('placeOrderAddons',$v)){
					foreach($v['placeOrderAddons'] as $addon){
						$a = array();
						$a['name'] = $addon['addon_id']['name'];
						$a['cost'] = $addon['addon_id']['price'];	
						$a['acost'] = $addon['poa_count'];		
						$so[$k]['addons'][] = $a; 
						
					}
				};
				
			$ordersummary[$service][] = $so;
		}
				
		
		echo json_encode($ordersummary);
		die();
	}	
	
	public function status(){
	
	    $input = file_get_contents("php://input");
		$data = json_decode($input);
		$custId = $data;
		$this->_em = $this->doctrine->em;
	
		if((int)$custId){
			$customer = $this->_em->find('Entity\Customer',(int)$custId);
			$customer->setStatus(!$customer->getStatus());
			$this->_em->persist($customer);
			$this->_em->flush(); die();
		}
		
		die();	
	}
	private function getnewpwd() {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		return substr(str_shuffle($chars),0,8);
	}
	
}