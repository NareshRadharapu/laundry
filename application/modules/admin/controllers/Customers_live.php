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
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		
		$storeId	= $data->storeId;
		$role = '';
		if(property_exists($data,'role')){
			$role = $data->role;
		}
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		if(!$storeId && $role = 'SUPER_ADMIN'){
			$customerObj = $qb->select('c')->from('Entity\Customer','c')->where('c.type=:type')->setParameter('type','user')->addOrderBy('c.id','desc')->getQuery()->getResult();
		}else{
			$customerObj = $qb->select('c')->from('Entity\Customer','c')->where('c.area_id =:areaId and c.type=:type')->setParameter('areaId',$storeId)->setParameter('type','user')->addOrderBy('c.id','desc')->getQuery()->getResult();	
		}
		
		$customers = array();
		foreach ($customerObj as $key => $obj) {
			$customer = array();
			$customer['id'] = $obj->getId();
			$customer['name'] = $obj->getFirstName().' '.$obj->getLastName();
			$customer['mobile'] = $obj->getMobile();
			$customer['createdAt'] = (int)strtotime($obj->getCreatedAt()->format('Y-m-d H:i:s'))*1000;
			$customer['status'] = $obj->getStatus();
			$customer['store'] = is_object($obj->getAreaId())?$obj->getAreaId()->getName():'';
			$customer['isAddress'] = is_object($obj->getCustomerAddress())?false:true;
			$customers[] =  $customer;
		}


		echo json_encode($customers);
		die();
	}
	
	public function aptlists(){
		
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$aptcustomers = $qb->select('a','Entity\Apartment','Entity\Block','Entity\Flat')->from('Entity\Customer','a')->where('a.type=:type')->setParameter('type','apartment')->addOrderBy('a.id','desc')->innerJoin('a.apt_id','Entity\Apartment')->innerJoin('a.block_id','Entity\Block')->innerJoin('a.flat_id','Entity\Flat')->getQuery()->getArrayResult();
		echo json_encode($aptcustomers);
		die();
	}
	
	
	
	public function add(){
		
	}
	public function customerstore(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$custId = 0;
		if(property_exists($data, 'id')){
			$custId	         = $data->id;
		}
		$firstname = '';
		if(property_exists($data, 'firstname')){
			$firstname 	     = $data->firstname;
		}
		$lastname = '';
		if(property_exists($data, 'lastname')){
			$lastname 	     = $data->lastname;
		}
		$email = '';
		if(property_exists($data, 'email')){
			$email 	         = $data->email;
		}
		//$password 	     = 'laundry';//$data->password;
		$password 	     = random_string('alnum', 8); //$this->getnewpwd(); //'abc';//$data->password;
		if(property_exists($data, 'mobile')){
			$mobile 	   	 = $data->mobile;
		}
		$type			 = 'user';//$data->type; 
		$areaId = '';
		if(property_exists($data, 'area')){
			$areaId			 = $data->area;
		}
		$address = '';
		if(property_exists($data, 'address')){
			$address 	     = $data->address;
		}
		$landmark ='';
		if(property_exists($data,'landmark'))
			$landmark 	     = $data->landmark;   
		$pincode ='';
		if(property_exists($data, 'pincode'))
			$pincode   	     = $data->pincode;
		$lattitude = '';
		if(property_exists($data, 'lattitude'))
			$lattitude   	    = $data->lattitude;
		$longitude = '';
		if(property_exists($data, 'longitude'))
			$longitude   	    = $data->longitude;
		$aniversaryDate = '';
		if(property_exists($data, 'aniversaryDate'))
			$aniversaryDate   	= $data->aniversaryDate;
		$isProblematic = '';
		if(property_exists($data, 'isProblematic'))
			$isProblematic   	= $data->isProblematic;
		$isStarch = '';
		if(property_exists($data, 'isStarch'))
			$isStarch   	 	= $data->isStarch;
		$isPerfume ='';
		if(property_exists($data, 'isPerfume'))
			$isPerfume   	 	= $data->isPerfume;
		$dob = '';
		if(property_exists($data, 'dob'))
			$dob   	 			= $data->dob;
			
		$status          	=1;// $data->status;
		
	try{
		$this->_em = $this->doctrine->em;
		//$apartment = $this->_em->getRepository('Entity\Apartment')->find($aptId);
		if($areaId)
		$area = $this->_em->getRepository('Entity\Area')->find($areaId);
		
		if($custId){
			$customer = $this->_em->find('Entity\Customer',$custId);
		}else{
			$customer = new Entity\Customer();
			$customer->setPassword($password);
		}
		
		$customer->setFirstName($firstname);
		$customer->setLastName($lastname);
		$customer->setEmail($email);
		$customer->setPassword($password);
		$customer->setPhoneNo($mobile);
		$customer->setUserType($type);
		$customer->setAreaId($area);

		$customer->setLattitude($lattitude);
		$customer->setLongitude($longitude);
		$customer->setIsProblematic($isProblematic);
		$customer->setIsStarch($isStarch);
		$customer->setIsPerfume($isPerfume);
		if($aniversaryDate)
		$customer->setAniversaryDate($aniversaryDate);
		if($dob)
		$customer->setDob($dob);
	
		$customer->setStatus($status);
		//$customer->setAddress($address);
		//$customer->setLandmark($landmark); 
		if(is_object($customer->getCustomerAddress())){
			$customeraddress = $customer->getCustomerAddress();
		}else{
			$customeraddress = new Entity\CustomerAddress();	
		}
		$customeraddress->setAddress($address);
		$customeraddress->setLandmark($landmark); 
		$customeraddress->setAreaId($area);
		$customeraddress->setPincode($pincode);

		$customer->setCustomerAddress($customeraddress);
		$this->_em->persist($customer);
		//$this->_em->persist($customeraddress);
		$this->_em->flush();
		
		if(!$custId){
			$this->load->library('Sms', $this->_em);
			$this->sms->thankYouNDetailsMessage($customer, $password);
		}
	}catch(Exception $e){
		die($e->getMessage());
	}	
		die(); 
		
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
		 //$data->type; 
		$type			 = 'apartment';
		//$areaId			 = $data->area;
		$aptId	 		 = $data->apartment;
		$blockId		 = $data->block;
		$flatId			 = $data->flat;
		
		//$address 	     = $data->address;   
		$whatsapp        = $data->whatsapp;
		
		$subType 	     = $data->subType;
	
		
		
		
		$showInTele      = $data->showintele;
		
		if(property_exists($data, 'ownerName'))
			$ownerName 		= $data->ownerName;
		$ownerMobile=0;
		if(property_exists($data, 'ownerMobile'))
			$ownerMobile 	= $data->ownerMobile;
		if (property_exists($data, 'ownerEmail')) {
			$ownerEmail 	= $data->ownerEmail;
		}
		
		if(property_exists($data, 'rpoints'))
			$rpoints 	     = $data->rpoints; 
		if (property_exists($data, 'refid')) {
			$refid   	     = $data->refid;
		}
		
		$status          =1;// $data->status;
		
		//print_r ($data); die();
		
		$this->_em = $this->doctrine->em;
		
		$apartment 	= $this->_em->getRepository('Entity\Apartment')->find($aptId);		
		$block 		= $this->_em->getRepository('Entity\Block')->find($blockId);
		$flat 		= $this->_em->getRepository('Entity\Flat')->find($flatId);
		//$area = $this->_em->getRepository('Entity\Area')->find($areaId);
		
		if($custId){
			$customer = $this->_em->find('Entity\Customer',$custId);
		}else{
			if($subType=='owner'){
				 $customer = $this->_em->getRepository('Entity\Customer')->findOneBy(array('mobile'=>$mobile));
				 if(!is_object($customer)){
				 	$customer = new Entity\Customer();
				 }
			}else{
				$customer = new Entity\Customer();
			}
		}
		
		if($ownerMobile){
			$owner = $this->_em->getRepository('Entity\Customer')->findOneBy(array('mobile'=>$ownerMobile));
			
			if(!is_object($owner)){
				$owner = new Entity\Customer();
				$on = explode(' ',$ownerName);
				$owner->setFirstName($on[0]);
				if(isset($on[1])){
					$owner->setLastName($on[1]);
				}
				$owner->setUserType('user');
				$owner->setSubType('owner');
				$owner->setApartmentId($apartment);
				$owner->setBlockId($block);
				$owner->setFlatId($flat);
				$owner->setPassword('abc');
				$owner->setPhoneNo($ownerMobile);
				$owner->setEmail($ownerEmail);
				$owner->setStatus(0);
				$this->_em->persist($owner);
				$this->_em->flush();
				
			}
			$customer->setOwnerId($owner);		
		}else{
			
		}
		$customer->setFirstName($firstname);
		$customer->setLastName($lastname);
		$customer->setEmail($email);
		$customer->setPassword($password); 
		$customer->setPhoneNo($mobile);
		$customer->setUserType($type);
		
		$customer->setSubType($subType);
		$customer->setWhatsapp($whatsapp);
		$customer->setShowintele($showInTele);
		
		$customer->setApartmentId($apartment);
		$customer->setAddress($apartment->getAddress()); 
		$customer->setBlockId($block);
		$customer->setFlatId($flat);
		
		//$customer->setRpoints($rpoints);
		//$customer->setRefId($refid);
		$customer->setStatus($status);
		$this->_em->persist($customer);
		$this->_em->flush();die();
	}
	
	public function update($id){
	
			
	}
	public function getaddress(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$id = (int)$data;
		$this->_em = $this->doctrine->em;
		
		/*$qb = $this->_em->createQueryBuilder();
		$addressresult = array();
		if($id){
		$address = $qb->select('a','Entity\Customer','Entity\Area')->from('\Entity\CustomerAddress','a')->join('a.cust_id','Entity\Customer')->join('a.area_id','Entity\Area')->where('Entity\Customer.id=:id')->setParameter('id',$id)->getQuery()->getArrayResult();
		foreach($address as $ad){
			$adds = array();
			$adds['address_id'] 	= $ad['id'];
			$adds['landmark'] 		= $ad['landmark'];
			$adds['address'] 		= $ad['address'];
			$adds['area'] 			= $ad['area_id']['name'];
			$adds['servicetax'] = $ad['area_id']['isServiceTax'];
			$adds['pincode'] 		= $ad['pincode'];
			$adds['customer_id'] 	= $ad['cust_id']['id'];
			$adds['customer_name'] 	= $ad['cust_id']['firstname'].' '.$ad['cust_id']['lastname'];
			$addressresult[] = $adds;
		}
		
		if(sizeof($addressresult))
		echo json_encode($addressresult);
		die();	
		}else{
			echo json_encode($addressresult);
		die();	
		}*/
		$customerObj = $this->_em->getRepository('Entity\Customer')->findOneById($id);
		$customer = array();
		if(is_object($customerObj)){
			$customer['customer_name'] 	= $customerObj->getFirstName().' '.$customerObj->getLastName();
			$customer['customer_id'] 	= $customerObj->getId();
			$customer['mobile'] 	= $customerObj->getMobile();
			$customer['email'] 		= $customerObj->getEmail();
			$customerAddressObj 	= $customerObj->getCustomerAddress();
			if(is_object($customerAddressObj)){
				
				$customer['address_id'] 	= $customerAddressObj->getId();
				$customer['address'] 	= $customerAddressObj->getAddress();
				$customer['landmark'] 	= $customerAddressObj->getLandmark();
				$customer['pincode'] 	= $customerAddressObj->getPincode();
				$customer['area'] 		= $customerObj->getAreaId()->getName();
				$customer['servicetax'] = $customerObj->getAreaId()->getIsServiceTax();
			}else{
				$customer['address'] 	= $customerObj->getAddress();
				$customer['landmark'] 	= '';
				$customer['pincode'] 	= '';
				if(is_object($customerObj->getAreaId())){
					$customer['area'] 	= $customerObj->getAreaId()->getName();	
					$customer['servicetax'] = $customerObj->getAreaId()->getIsServiceTax();
				}else{
					$customer['area'] = '';
					$customer['servicetax'] = false;
				}
			}
		}
		echo json_encode($customer);
		die();
	}
	public function getbymobile(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$id = $data;
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		
		//$customer = $qb->select('c','Entity\Area','Entity\CustomerAddress')->from('Entity\Customer','c')->leftJoin('c.area_id','Entity\Area')->leftJoin('c.customerAddress','Entity\CustomerAddress')->where('c.mobile=:mobile')->setParameter('mobile',$id)->getQuery()->getArrayResult();
		
		$customerObj = $qb->select('c')->from('Entity\Customer','c')->where('c.mobile=:mobile')->setParameter('mobile',$id)->getQuery()->getResult();
		
		$customer = array();
		if(is_array($customerObj)){
			foreach ($customerObj as $key => $obj) {
				$customer['firstname'] 	= $obj->getFirstName();
				$customer['lastname'] 	= $obj->getLastName();
				$customer['id'] 		= $obj->getId();
				$customer['mobile'] 	= $obj->getMobile();
				$customer['email'] 		= $obj->getEmail();
				$customer['dateofJoin'] 	= $obj->getCreatedAt();
				$customer['defaultStarch'] = $obj->getIsStarch();
				$customer['problematic'] 	= $obj->getIsProblematic();
				$customer['minOrderValue'] 	= $obj->getMinOrderValue();
				$customer['maxOrderValue'] 	= $obj->getMaxOrderValue();
				$customer['avgOrderValue'] 	= $obj->getAvgOrderValue();
				$customer['totalOrderValue']= $obj->getTotalOrderValue();
				$customer['totalOrders'] 	= $obj->getTotalOrders();
				$customer['discountOrderValue'] 	= $obj->getDiscountOrderValue();
				$customer['avarageProcessingDelay'] = $obj->getAvgProcessingDelay();
				$customer['serviceWiseRevenue'] 	= $obj->getSerivceWiseRevenue();
				$customer['serviceWiseItems'] = $obj->getSerivceWiseItems();
				$customer['orderFrequence'] = $obj->getOrderFrequence();
				
				$customer['perfumeSpray'] 	= $obj->getIsPerfume();
				$customer['dob'] 			= $obj->getIsPerfume();
				$customer['anniversary'] 	= $obj->getIsPerfume();
				$customer['wallet'] 		= $obj->getWallet();

				$customerAddressObj 	= $obj->getCustomerAddress();
				if(is_object($customerAddressObj)){
					$customer['address'] 	= $customerAddressObj->getAddress();
					$customer['landmark'] 	= $customerAddressObj->getLandmark();
					$customer['pincode'] 	= $customerAddressObj->getPincode();
					$customer['areaName'] 	= $customerAddressObj->getAreaId()->getName();
					$customer['area'] 		= $customerAddressObj->getAreaId()->getId();
				}else{
					$customer['address'] 	= '';	
					$customer['landmark'] 	= '';
					$customer['pincode'] 	= '';
					$customer['areaName'] 	= is_object($obj->getAreaId())?$obj->getAreaId()->getName():'';
					$customer['area'] 	= is_object($obj->getAreaId())?$obj->getAreaId()->getId():0;
				}
			}
		
		}
		echo json_encode($customer);
		die();
	}
	public function customeredit(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$id = $data;
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$customerObj = $this->_em->getRepository('Entity\Customer')->findOneById($id);
		$customer = array();
		if(is_object($customerObj)){
			$customer['firstname'] 	= $customerObj->getFirstName();
			$customer['lastname'] 	= $customerObj->getLastName();
			$customer['id'] 		= $customerObj->getId();
			$customer['mobile'] 	= $customerObj->getMobile();
			$customer['email'] 		= $customerObj->getEmail();
			
			$customer['dob']			= $customerObj->getDob();
			$customer['aniversaryDate']	= $customerObj->getaniversaryDate();
			$customer['lattitude'] 		= $customerObj->getLattitude();
			$customer['longitude'] 		= $customerObj->getLongitude();
			$customer['isProblematic'] 	= $customerObj->getIsProblematic();
			$customer['isStarch'] 		= $customerObj->getIsStarch();
			$customer['isPerfume'] 		= $customerObj->getIsPerfume();

			$customerAddressObj 	= $customerObj->getCustomerAddress();
			if(is_object($customerAddressObj)){
				$customer['address'] 	= $customerAddressObj->getAddress();
				$customer['landmark'] 	= $customerAddressObj->getLandmark();
				$customer['pincode'] 	= $customerAddressObj->getPincode();
				$customer['area_id'] 	= $customerObj->getAreaId()->getId();
			}else{
				$customer['address'] 	= $customerObj->getAddress();
				$customer['landmark'] 	= '';
				$customer['pincode'] 	= '';
				if(is_object($customerObj->getAreaId())){
					$customer['area_id'] 	= $customerObj->getAreaId()->getId();	
				}else{
					$customer['area_id'] = 0;
				}
			}
		}
		echo json_encode($customer);
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
		$input = file_get_contents("php://input");
		$order = json_decode($input);
		$orderId = $order->orderId;
		$name = $order->customerName;
		$orderDate = '';
		$ordersummary = array();
		
		$address = '';
		$this->_em = $this->doctrine->em;
		
		if($order->userType=='apartment'){
			$address 	= $order->apartmentAddress;
		}else{
			
		}
		$qb = $this->_em->createQueryBuilder();
		
		$po = $qb->select('o','Entity\Item','Entity\Service','Entity\PlaceOrderAddon','Entity\Addon')->from('Entity\PlaceOrder','o')->leftJoin('o.item_id','Entity\Item')->leftJoin('o.service_id','Entity\Service')->leftJoin('o.placeOrderAddons','Entity\PlaceOrderAddon')->leftJoin('Entity\PlaceOrderAddon.addon_id','Entity\Addon')->where('o.order_id=:order_id')->setParameter('order_id',$orderId)->addOrderBy('Entity\Service.id','asc')->getQuery()->getArrayResult();
		
		$qb2 = $this->_em->createQueryBuilder();
		
		//$ca = $qb2->select('ca')->from('Entity\CustomerAddress','ca')->innerJoin('')->getQuery()->getResult();
		
		//if(is_object($ca)){
			//$address = $ca->getLandmark();
		//}
		
		
		$serviceArray = array();
		$myservices = array();
		foreach($po as $k=>$v){
			
			$orderId = $v['order_id'];
			$orderDate = $v['created_at']->format('d-m-y h:i a');
			
			$its = array();
			$its['item'] = $v['item_id']['name'];
				$its['icount'] = $v['icount'];
				$its['cost'] = $v['cost'];
				if(array_key_exists('placeOrderAddons',$v)){
					foreach($v['placeOrderAddons'] as $addon){
						$a = array();
						$a['id'] = $addon['id'];
						$a['name'] = $addon['addon_id']['name'];
						$a['cost'] = $addon['addon_id']['price'];	
						$a['acount'] = $addon['poa_count'];		
						$its['addons'][] = $a; 
					}
				};
		$services = array();
			if(!in_array($v['service_id']['name'],$serviceArray)){
				$services['name'] = $v['service_id']['name'];
				$services['items'][]	= $its;
				$serviceArray[] = $v['service_id']['name'];
				$myservices[] = $services;
				
			}else{
				
				$services['items'][]	= $its;
				$myservices[] = $services;
			}
		}
		
		$ordersummary['orderId'] = $orderId;
		$ordersummary['orderDate'] = $orderDate;
		$ordersummary['customerName'] = $name;
		$ordersummary['address'] = $address;
		$ordersummary['services'] = $myservices;
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