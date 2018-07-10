<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class CbsAdmin extends REST_Controller {
   function __construct(){
		parent::__construct();	
        $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
		$this->methods['apartment_get']['limit'] = '10';
		$this->methods['itemtype_get']['limit'] = '10';
 		$this->_em = $this->doctrine->em;
    }
    public function cuDayToDeliveryOrders_post(){
    	$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			if(property_exists($data, 'dDate') && $data->dDate){
				$dDate = $data->dDate;
				$dDate = date('Y-m-d',strtotime($dDate));
				try{
					$ddOrders = array();
					$this->load->database();
					  	$mq = 'select count(*) as totalOrders, s.area_id as storeId, sum(p.totalItems) as totalItems, s.name as store, GROUP_CONCAT(p.o_id) as ordersString, GROUP_CONCAT(p.totalItems) as itmesString from place_order_ids as p inner join cu_order_details as cud on cud.order_id = p.o_id left join areas as s on p.store_id = s.area_id where p.isDelete=0 and cud.cuso_id!="" and DATE(p.deliveryDate) ="'.$dDate.'" group by p.store_id';
						$query = $this->db->query($mq);
						$ddOrders = $query->result();
					$this->set_response($ddOrders, REST_Controller::HTTP_OK);
				}catch(Exception $e){
					$message = ['message'=>$e->getMessage(),'status'=>500];
					$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
				}
			}else{
				$message = ['message'=>'something we wrongs.'];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something we wrong.'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
    }
    public function ordersDeliveryPrint_post(){
    	$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			if(property_exists($data, 'dDate') && $data->dDate && property_exists($data, 'storeIds')){
				$dDate = $data->dDate;
				$dDate = date('Y-m-d',strtotime($dDate));
				$storeIds = $data->storeIds;
				try{
				$this->load->database();
				$result = array();
					if(sizeof($storeIds)){
				    foreach ($storeIds as $key => $sid) {
				    	$mq = 'select s.area_id as storeId, s.name as store, s.mobile as storeContact, p.o_id as orderId, it.name as item, sc.name as service, po.icount as itemCount, po.ricount as rItemCount from place_order_ids as p left join place_order as po on po.order_id = p.order_id left join areas as s on p.store_id = s.area_id left join items as it on po.item_id = it.item_id left join services as sc on po.service_id = sc.service_id where p.store_id = "'.$sid.'" and p.isDelete=0 and DATE(p.deliveryDate) ="'.$dDate.'" order by p.o_id, p.store_id';
						$query = $this->db->query($mq);
						$resultData = $query->result();
						$storeOrders = array();
						$totalItems = 0;
						$storeName = '';
						$storeContact = '';
						foreach ($resultData as $k => $obj) {
							$storeOrder = array();
							$storeOrder['orderId'] = $obj->orderId;
							$storeOrder['store'] = $storeName =  $obj->store;
							$storeOrder['storeContact'] = $storeContact = $obj->storeContact;
							$ncount  = $obj->itemCount - $obj->rItemCount;
							$storeOrder['item'] = $obj->service.'-'.$obj->item.'-'.$ncount;
							$storeOrders[$obj->orderId][] = $storeOrder;
							$totalItems += $ncount;
						}
						$storeObj = array(
							'storeName'=>$storeName,
							'storeContact' => $storeContact,
							'totalItems'  => $totalItems,
							'totalOrders' => sizeof($storeOrders),
							'deliveryDate' =>$dDate
							);
						$result[$storeName] = array('storeObj'=>$storeObj,'storeOrders'=>$storeOrders);
				    }
					$this->set_response($result, REST_Controller::HTTP_OK);
				}else{
					$message = ['message'=>'plz select at least one store','status'=>500];
					$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
				}
				}catch(Exception $e){
					$message = ['message'=>$e->getMessage(),'status'=>500];
					$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
				}
			}else{
				$message = ['message'=>$e->getMessage(),'status'=>500];
					$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>$e->getMessage(),'status'=>500];
					$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
    }
    public function storeCustomerSms_post(){
    	$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			$storeId = 0;
			if(property_exists($data, 'storeId') && property_exists($data, 'message')){
				$storeId = $data->storeId;
				$msg = $data->message;
				try{
					$smsArray = array();
					$qb = $this->_em->createQueryBuilder();
    				$customerObj = $qb->select('c')->from('Entity\Customer','c')->where('c.area_id=:storeId')->setParameter('storeId',$storeId)->getQuery()->getResult();
					foreach($customerObj as $obj){
						$smsArray[$obj->getMobile()] = $msg;
					}
					$this->load->library('Sms',$this->_em);
					$this->sms->sendStoreCustomerSms($smsArray);
					$message = ['message'=>'successfully sent sms'];
					$this->set_response($message,REST_Controller::HTTP_OK);
				}catch(Exception $e){
					$message = ['message'=>$e->getMessage(),'status'=>500];
					$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
				}
			}else{
				$message = ['message'=>'something we wrong.'];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something we wrong.'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
    }
    public function customersBalanceList_post(){
    	$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			 $storeId = 0;
			if(property_exists($data, 'storeId')){
				$storeId = $data->storeId;
			}
			try{
				$this->load->database();
				if($storeId){
					$mq = 'select SUM(p.balanceAmount) as balanceAmount, c.cust_id as id, c.firstname as firstname, c.lastname as lastname, c.mobile as mobile, p.poStatus as status from customers as c inner join place_order_ids as p on p.customer_id = c.cust_id where p.isDelete !=1 and c.area_id ='.$storeId.' group by c.cust_id order by c.firstname ';
				}else{
					$mq = 'select SUM(p.balanceAmount) as balanceAmount, c.cust_id as id, c.firstname as firstname, c.lastname as lastname, c.mobile as mobile, p.poStatus as status from customers as c inner join place_order_ids as p on p.customer_id = c.cust_id where p.isDelete !=1  group by c.cust_id order by c.firstname ';
				}
			  	
					$query = $this->db->query($mq);
					$resultObj = $query->result();
					$customers = array();
					foreach($resultObj as $obj){
						$customer = array();
						$customer['balanceAmount'] = (int)$obj->balanceAmount;
						$customer['firstname'] = $obj->firstname;
						$customer['lastname'] = $obj->lastname;
						$customer['mobile'] = $obj->mobile;
						$customer['id'] = $obj->id;
						$customer['status'] = $obj->status;
						if((int)$obj->balanceAmount)
						$customers[] = $customer;
					}
					$this->set_response($customers, REST_Controller::HTTP_OK);	
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something we wrong.'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
    }
    public function customSms_post(){
    	$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			$storeId = 0;
			if(property_exists($data, 'mobile') && property_exists($data, 'message')){
				$mobile = $data->mobile;
				$msg = $data->message;
				try{
					$smsArray = array();
					//$qb = $this->_em->createQueryBuilder();
    				//$customerObj = $qb->select('c')->from('Entity\Customer','c')->where('c.area_id=:storeId')->setParameter('storeId',$storeId)->getQuery()->getResult();
					// foreach($customerObj as $obj){
					// 	$smsArray[$obj->getMobile()] = $msg;
					// }
					$smsArray[$mobile] = $msg;
					$this->load->library('Sms',$this->_em);
					$this->sms->sendCustomSms($smsArray);
					$message = ['message'=>'successfully sent sms'];
					$this->set_response($message,REST_Controller::HTTP_OK);
				}catch(Exception $e){
					$message = ['message'=>$e->getMessage(),'status'=>500];
					$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
				}
			}else{
				$message = ['message'=>'something we wrong.'];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something we wrong.'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
    }
    public function customerBalanceSms_post(){
    	$input = file_get_contents('php://input');
		$data = json_decode($input);
		$messages = array();
		 foreach($data as $obj){
		 	if($obj){
			 	$message = array();
			 	$message['mobile'] = $obj->mobile;
			 	$msg = 'Dear '.$obj->firstname.' '.$obj->lastname.', Your Laundry Due Amount is Rs. '.$obj->balanceAmount. ' Please pay at the earliest';
			 	$msg .=', Ignore If Already Done, Thanks LaundryWaves';
			 	$message['message'] = $msg;
			 	$messages[] = $message;	
		 	}
		 }
		 $this->load->library('Sms',$this->_em);
		 $this->sms->balanceAmountSendingSMS($messages);
		 $message = ['message'=>'successfully sent sms ','status'=>200];
		 $this->set_response($message,REST_Controller::HTTP_OK);
    }
    public function catalogPirceItems_post(){
    	$catalogId = 1;
    	try{
    		$qb = $this->_em->createQueryBuilder();
    		$cps = $qb->select('cp')->from('Entity\CatalogPrice','cp')->where('cp.catalog_id =:catalogId')->setParameters(array('catalogId'=>$catalogId))->getQuery()->getResult();
	    	$catlogItems = array();
	    	foreach ($cps as $key => $obj){
	    		$item = array();
	    		$item['ikey'] = $obj->getServiceId()->getId().'-'.$obj->getItemTypeId()->getId().'-'.$obj->getItemId()->getId();
	    		$item['ival'] = $obj->getServiceId()->getName().'-'.$obj->getItemTypeId()->getName().'-'.$obj->getItemId()->getName();
	    		$catlogItems[] = $item;
	    	}
	    	$this->set_response($catlogItems,REST_Controller::HTTP_OK);
    	}catch(Exception $e){
    		$message = ['message'=>$e->getMessage(),'status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
    	}
    }
    public function addonItems_post(){
    	try{
    		$addObj = $this->_em->getRepository('Entity\Addon')->findAll();
    		$addons = array();
    		foreach ($addObj as $key => $obj) {
    			$addon = array();
    			$addon['id'] 	= (string)$obj->getId();
    			$addon['name'] 	= $obj->getName();
    			$addons[] = $addon;
    		}
    		$this->set_response($addons, REST_Controller::HTTP_OK);
    	}catch(Exception $e){
    		$message = ['message'=>$e->getMessage(),'status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);	
    	}
    }
    public function addEditPackage_post(){
    	$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			try{
				$pid = 0;
				if(property_exists($data, 'pid')){
					$pid = $data->pid;
				}
				$name = '';
				if(property_exists($data, 'name')){
					$name = $data->name;
				}
				$cost =0;	
				if(property_exists($data, 'cost')){
					$cost = $data->cost;
				}
				$duration = 0;
				if(property_exists($data, 'duration')){
					$duration = $data->duration;
				}
				$packageDetails = array();
				$items = array();
				if(property_exists($data, 'item_ids')){
					$items = $data->item_ids;
				}
				$pic = array();
				if(property_exists($data, 'pic')){
					$pic = $data->pic;
				}
				$itemCount = array();
				foreach ($items as $ik => $iobj) {
					$itemCount[$iobj] = $pic[$ik];
				}
				$packageDetails['items'] = $itemCount; 
				$pa  = array();
				if(property_exists($data, 'pa')){
					$pa = $data->pa;
				}
				$pac = array();
				if(property_exists($data, 'pac')){
					$pac = $data->pac;
				}
				$addonCount = array();
				foreach ($pa as $pak => $pav) {
					$addonCount[$pav] = $pac[$pak];
				}
				$packageDetails['addons'] = $addonCount; 
				if($pid){
					$packageObj = $this->_em->find('Entity\Package',$pid);
				}else{
					$packageObj = new Entity\Package();	
				}
				$packageObj->setName($name);
				//$packageObj->setCode($code);
				$packageObj->setCost($cost);
				$packageObj->setDurationInDays($duration);
				$packageObj->setPackageDetails(json_encode($packageDetails));
				$this->_em->persist($packageObj);
				$this->_em->flush();
				$message = ['message'=>'successfully saved packaged'];
				$this->set_response($message, REST_Controller::HTTP_OK);
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);	
			}
		}else{
			$message = ['message'=>'something went wrong.'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);	
		}
    }
    public function currentPackages_post(){
    	try{
    		$packages = array();
			$packageObj = $this->_em->getRepository('Entity\Package')->findBy(array('status'=>1));
				foreach ($packageObj as $key => $obj) {
					$package = array();
					$package['pid'] 	= $obj->getId(); 
					$package['name'] 	= $obj->getName();
					$packages['packages'][] = $package; 
				}
			$this->set_response($packages,REST_Controller::HTTP_OK);
		}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
    }
	public function ordersRecord_get(){
		try{
			$qb = $this->_em->createQueryBuilder('p');
			$orderObj = $qb->select('count(p) as totalOrders','sum(p.totalAmount) as totalAmount','sum(p.paidAmount) as paidAmount','sum(p.balanceAmount) as balanceAmount','sum(p.adminDiscountAmount) as adminDiscountAmount')->from('Entity\PlaceOrderId','p')->getQuery()->getResult();
				foreach ($orderObj as $key => $value) {
					$order = array();
					$order['totalOrders'] 	= $value['totalOrders']; 
					$order['totalAmount'] 	= $value['totalAmount'] + $value['adminDiscountAmount']; 
					$order['paidAmount']	= $value['paidAmount'];
					$order['redeemedAmount']	= 0;
					$order['balanceAmount'] = $value['balanceAmount'];
					$order['adminDiscountAmount'] = $value['adminDiscountAmount'];
				}
			$this->set_response($order,REST_Controller::HTTP_OK);
		}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function ordersRecordSearch_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		$orderDate = $data->orderDate;
		$areaId    = $data->areaId;
		try{
			 $this->load->database();
			$query = $this->db->query('select count(*) as totalOrders, sum(p.totalAmount) as totalAmount, sum(p.paidAmount) as paidAmount, sum(p.balanceAmount) as balanceAmount, sum(p.adminDiscountAmount) as adminDiscountAmount from place_order_ids as p inner join customer_address as cs on p.address_id = cs.ca_id where cs.area_id = '.$areaId.' and DATE(p.orderDate)  ="'.$orderDate.'" group by DATE(p.orderDate) ');
			$orderObj = $query->row();
			print_r($orderObj);
			die();
			$orderObj = $qb->getResult();
				$orders = array();
				foreach ($orderObj as $key => $value) {
					$order['totalOrders'] 	= $value[0]->getId(); 
					$order['orderDate'] 	= $value['day']; //->getOrderDate()->format('y-m-d'); 
					/*$order['totalOrders'] 	= $value['totalOrders']; 
					$order['totalAmount'] 	= $value['totalAmount'] + $value['adminDiscountAmount']; 
					$order['paidAmount']	= $value['paidAmount'];
					$order['redeemedAmount']	= 0;
					$order['balanceAmount'] = $value['balanceAmount'];
					$order['adminDiscountAmount'] = $value['adminDiscountAmount'];*/
					$orders[] = $order;
				}
			$this->set_response($orders,REST_Controller::HTTP_OK);
		}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function createCam_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
				$ccId = 0;
			if(property_exists($data,'ccId')){
			$ccId 		= $data->ccId;
			}
			$name = '';
			if(property_exists($data, 'name')){
			$name 		= $data->name;
			}
			$location = '';
			if(property_exists($data, 'location')){
			$location 	= $data->location;
			}
			$ccscript = '';
			if(property_exists($data, 'ccscript')){
			$ccscript = stripcslashes($data->ccscript);
			}
			$accessPrivileges = '';
			if(property_exists($data, 'accessPrivileges')){
			$accessPrivileges = $data->accessPrivileges;
			}
			$apartmentId = 0;
			if(property_exists($data, 'apartmentId')){
			$apartment = $data->apartmentId;
			$ap = $this->_em->find('Entity\Apartment',$apartment);
			if(is_object($ap)){
			$apartmentId = $ap;
			}
			}
			try{
			if($ccId){
			$cc = $this->_em->find('Entity\CC',$ccId);
			if(!is_object($cc)){
				$cc = new Entity\CC();
			}
			}else{
			$cc = new Entity\CC();
			}
			$cc->setName($name);
			$cc->setLocation($location);
			$cc->setCCscript($ccscript);
			$cc->setAccessPrivileges($accessPrivileges);
			if($apartmentId)
			$cc->setApartmentId($apartmentId);
			$this->_em->persist($cc);
			$this->_em->flush();
			$message = ['message'=>'successfully created cc cam.'];
			$this->set_response($message,REST_Controller::HTTP_CREATED);
			}catch(Exception $e){
			$message = ['message'=>$e->getMessage(),'status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'payload mistake','status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function camsLists_get(){
		$data = new stdClass();
		try{
			$qb = $this->_em->createQueryBuilder();
			$camsObj = $qb->select('cc')->from('Entity\CC','cc')->getQuery()->getResult();
			$cams = array();
			foreach ($camsObj as $key => $obj) {
				$cam =  array();
				$cam['name'] 			= $obj->getName();
				$cam['location'] 		= $obj->getLocation();
				$cam['ccscript'] 		= $obj->getCCscript();
				$cam['accessPrivileges']= $obj->getAccessPrivileges();
				$cam['apartment']		= $obj->getApartmentId()->getName();
				$cams['cams'][] = $cam;
			}
			$this->set_response($cams,REST_Controller::HTTP_OK);
		}catch(Exception $e){
			$message = ['message'=>$e->getMessage(),'status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function apartmentCamsLists_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(!is_object($data))
		$data = new stdClass();
		$apartmentId = 0;
		if(property_exists($data, 'apartmentId')){
			$apartmentId = $data->apartmentId;
		}
		$accessPrivileges = '';
		if(property_exists($data, 'accessPrivileges')){
			$accessPrivileges = $data->accessPrivileges;
		}
		try{
			$qb = $this->_em->createQueryBuilder();
			$camsObj = $qb->select('cc')->from('Entity\CC','cc')->where('cc.apt_id=:apartmentId and cc.accessPrivileges=:accessPrivileges')->setParameter('apartmentId',$apartmentId)->setParameter('accessPrivileges',$accessPrivileges)->getQuery()->getResult();
			$cams = array();
			foreach ($camsObj as $key => $obj) {
				$cam =  array();
				$cam['name'] 			= $obj->getName();
				$cam['location'] 		= $obj->getLocation();
				$cam['ccscript'] 		= $obj->getCCscript();
				$cams['cams'][] 		= $cam;
			}
			$this->set_response($cams,REST_Controller::HTTP_OK);
		}catch(Exception $e){
			$message = ['message'=>$e->getMessage(),'status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function camStatus_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(!is_object($data))
		$data = new stdClass();
		try{
			$status = '';
			if(property_exists($data, 'status')){
				$status = $data->status;
			}
			$ccId = 0;
			if(property_exists($data, 'ccId')){
				$cc 	= $data->ccId;
				$ccId = $this->_em->find('Entity\CC',$cc);
			}
			if(is_object($ccId)){
				$ccId->setStatus($status);
				$this->_em->persist($ccId);
				$this->_em->flush();
				$message = ['message'=>'successfully status updated'];
				$this->set_response($message,REST_Controller::HTTP_OK);
			}else{
				$message = ['message'=>'something went wrong.'];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}catch(Exception $e){
			$message = ['message'=>$e->getMessage(),'status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function camView_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(!is_object($data))
		$data = new stdClass();
		$ccId = 0;
		if(property_exists($data, 'ccId')){
			$ccId = $data->ccId;
		}
		try{
			$qb = $this->_em->createQueryBuilder();
			$ccObj = $this->_em->getRepository('Entity\CC')->findOneById($ccId);
				$cam =  array();
				$cam['cam']['name'] 		= $ccObj->getName();
				$cam['cam']['location'] 	= $ccObj->getLocation();
				$cam['cam']['ccscript'] 	= $ccObj->getCCscript();
				$cam['cam']['apartment']	= $ccObj->getApartmentId()->getName();
			$this->set_response($cam,REST_Controller::HTTP_OK);
		}catch(Exception $e){
			$message = ['message'=>$e->getMessage(),'status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function customerTransactionHistory_post(){
		$input 		= file_get_contents('php://input');
		$data 		= json_decode($input);
		$customerId = $data->customerId;
		if($customerId){
			try{
				$customerObj = $this->_em->find('Entity\Customer',$customerId);
				$transactionObj = $customerObj->getTransactions();
				$transactions = array();
				foreach ($transactionObj as $k => $v) {
					$transaction = array();
					$transaction['customerName'] 	= $v->getCustomerId()->getFirstName().' '.$v->getCustomerId()->getLastName();
					$transaction['orderId'] 	 	= $v->getOrderId();
					$transaction['paidAmount']		= $v->getPaidAmount();
					$transaction['usedAmount']		= $v->getUsedAmount();
					$transaction['paymentType']		= $v->getPaymentType();
					$transaction['transactionNumber']		= $v->getTransactionNumber();
					$transaction['paymentFeedback']		= $v->getPaymentFeedback();
					$transaction['date']			= strtotime($v->getCreatedAt()->format('y-m-d H:i:s'))*1000;
					$transactions['transactions'][] = $transaction;
				}
				$this->set_response($transactions,REST_Controller::HTTP_OK);
			}catch(Exception $e){
				$this->set_response($e->getMessage(),REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'payload mistake.'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function customerTransactionHistory_get(){
		try{
			$transactionObj = $this->_em->getRepository('Entity\TransactionHistory')->findAll();
			$transactions = array();
			foreach ($transactionObj as $k => $v) {
				$transaction = array();
				$transaction['customerName'] 	= $v->getCustomerId()->getFirstName().' '.$v->getCustomerId()->getLastName();
				$transaction['orderId'] 	 	= $v->getOrderId();
				$transaction['paidAmount']		= $v->getPaidAmount();
				$transaction['date']			= strtotime($v->getCreatedAt()->format('y-m-d H:i:s'))*1000;
				$transactions['transactions'][] = $transaction;
			}
			$this->set_response($transactions,REST_Controller::HTTP_OK);
		}catch(Exception $e){
				$this->set_response($e->getMessage(),REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function employee_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			$empId = 0;
			if(property_exists($data,'empId')){
				$empId 		= $data->empId;
			}
			$name = '';
			if(property_exists($data, 'name')){
				$name 		= $data->name;
			}
			$email = '';
			if(property_exists($data, 'email')){
				$email 	= $data->email;
			}
			$mobile = '';
			if(property_exists($data, 'mobile')){
				$mobile = stripcslashes($data->mobile);
			}
			$password = '';
			if(property_exists($data, 'password')){
				$password = stripcslashes($data->password);
			}
			$loginTime = '';
			if(property_exists($data, 'loginTime')){
				$loginTime = $data->loginTime;
			}
			$logoutTime = '';
			if(property_exists($data, 'logoutTime')){
				$logoutTime = $data->logoutTime;
			}
			$storeIp = '';
			if(property_exists($data, 'storeIp')){
				$storeIp = stripcslashes($data->storeIp);
			}
			$roleId = '';
			if(property_exists($data, 'roleId')){
				$roleId = $data->roleId;
				$roleId = $this->_em->find('Entity\Role',$roleId);
			}
			$areaId = '';
			if(property_exists($data, 'areaId')){
				$areaId = $data->areaId;
				$areaId = $this->_em->find('Entity\Area',$areaId);
			}
			try{
				if($empId){
					$emp = $this->_em->find('Entity\Employee',$empId);
					if(!is_object($emp)){
						$emp = new Entity\Employee();
					}
				}else{
					$emp = new Entity\Employee();
				}
			$emp->setName($name);
			$emp->setEmail($email);
			$emp->setMobile($mobile);
			if($password)
			$emp->setPassword($password);
			if(is_object($roleId))
				$emp->setRoleId($roleId);
			if(is_object($areaId))
				$emp->setAreaId($areaId);
			$emp->setLoginTime($loginTime);
			$emp->setLogoutTime($logoutTime);
			$emp->setStoreIp($storeIp);
			$this->_em->persist($emp);
			$this->_em->flush();
			$message = ['message'=>'successfully registerd an employee.'];
			$this->set_response($message,REST_Controller::HTTP_CREATED);
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'payload mistake','status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function employees_get(){
		try{
			$empObj = $this->_em->getRepository('Entity\Employee')->findAll();
			$employees = array();
			foreach ($empObj as $key => $obj) {
				$employee = array();
				$employee['empId'] 	= $obj->getId();
				$employee['name'] 	= $obj->getName();
				$employee['email'] 	= $obj->getEmail();
				$employee['mobile'] = $obj->getMobile();
				$employee['role'] 	= is_object($obj->getRoleId())?$obj->getRoleId()->getName():'';
				$employee['store'] 	= is_object($obj->getAreaId())?$obj->getAreaId()->getName():'';
				$employee['status'] = $obj->getStatus();
				 $employee['loginTime'] = $obj->getLoginTime();
				 $employee['logoutTime'] = $obj->getLogoutTime();
				// $employee['storeIp'] = (string)$obj->getStoreIp();
				$employees['employees'][] = $employee;
			}
			$this->set_response($employees,REST_Controller::HTTP_OK);
		}catch(Exception $e){
			$message = ['message'=>$e->getMessage(),'status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function editEmployee_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			try{
				$rqb = $this->_em->createQueryBuilder();
					$roleObj = $rqb->select('r')->from('Entity\Role','r')->getQuery()->getResult();
					$roles = array();
					foreach ($roleObj as $key => $obj) {
						$role = array();
						$role['id'] 	= $obj->getId();
						$role['name']	= $obj->getName();
						$roles['roles'][] = $role;
					}
				$aqb = $this->_em->createQueryBuilder();
				$areas = $aqb->select('a')->from('Entity\Area','a')->getQuery()->getArrayResult();
			$empId = 0;
			if(property_exists($data,'empId')){
				$empId 		= $data->empId;
				$empObj = $this->_em->find('Entity\Employee',$empId);
				$employee = array();
				$employee['empId'] 	= $empObj->getId();
				$employee['name'] 	= $empObj->getName();
				$employee['email'] 	= $empObj->getEmail();
				$employee['mobile'] 	= $empObj->getMobile();
				$employee['loginTime'] = $empObj->getLoginTime();
				$employee['logoutTime'] = $empObj->getLogoutTime();
				$employee['storeIp'] = $empObj->getStoreIp();
				$employee['roleId'] = $empObj->getRoleId()->getId();
				$employee['roles']	= $roles;
				$employee['areaId'] 	= $empObj->getAreaId()->getId();	
				$employee['areas'] 	= $areas;
				$this->set_response($employee,REST_Controller::HTTP_OK);
			}else{
				$message = ['message'=>'payload mistake','status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'payload mistake','status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	// public function employee_post(){
	// 	$input = file_get_contents('php://input');
	// 	$data = json_decode($input);
	// 	if(is_object($data)){
	// 		$empId = 0;
	// 		if(property_exists($data,'empId')){
	// 			$empId 		= $data->empId;
	// 		}
	// 		$name = '';
	// 		if(property_exists($data, 'name')){
	// 			$name 		= $data->name;
	// 		}
	// 		$email = '';
	// 		if(property_exists($data, 'email')){
	// 			$email 	= $data->email;
	// 		}
	// 		$mobile = '';
	// 		if(property_exists($data, 'mobile')){
	// 			$mobile = stripcslashes($data->mobile);
	// 		}
	// 		$password = '';
	// 		if(property_exists($data, 'password')){
	// 			$password = stripcslashes($data->password);
	// 		}
	// 		$roleId = '';
	// 		if(property_exists($data, 'roleId')){
	// 			$roleId = $data->roleId;
	// 			$roleId = $this->_em->find('Entity\Role',$roleId);
	// 		}
	// 		$areaId = '';
	// 		if(property_exists($data, 'areaId')){
	// 			$areaId = $data->areaId;
	// 			$areaId = $this->_em->find('Entity\Area',$areaId);
	// 		}
	// 		try{
	// 			if($empId){
	// 				$emp = $this->_em->find('Entity\Employee',$empId);
	// 				if(!is_object($emp)){
	// 					$emp = new Entity\Employee();
	// 				}
	// 			}else{
	// 				$emp = new Entity\Employee();
	// 			}
	// 		$emp->setName($name);
	// 		$emp->setEmail($email);
	// 		$emp->setMobile($mobile);
	// 		if($password)
	// 		$emp->setPassword($password);
	// 		if(is_object($roleId))
	// 			$emp->setRoleId($roleId);
	// 		if(is_object($areaId))
	// 			$emp->setAreaId($areaId);
	// 		$this->_em->persist($emp);
	// 		$this->_em->flush();
	// 		$message = ['message'=>'successfully registerd an employee.'];
	// 		$this->set_response($message,REST_Controller::HTTP_CREATED);
	// 		}catch(Exception $e){
	// 			$message = ['message'=>$e->getMessage(),'status'=>500];
	// 			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
	// 		}
	// 	}else{
	// 		$message = ['message'=>'payload mistake','status'=>500];
	// 		$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
	// 	}
	// }
	// public function employees_get(){
	// 	try{
	// 		$empObj = $this->_em->getRepository('Entity\Employee')->findAll();
	// 		$employees = array();
	// 		foreach ($empObj as $key => $obj) {
	// 			$employee = array();
	// 			$employee['empId'] 	= $obj->getId();
	// 			$employee['name'] 	= $obj->getName();
	// 			$employee['email'] 	= $obj->getEmail();
	// 			$employee['mobile'] = $obj->getMobile();
	// 			$employee['role'] 	= is_object($obj->getRoleId())?$obj->getRoleId()->getName():'';
	// 			$employee['store'] 	= is_object($obj->getAreaId())?$obj->getAreaId()->getName():'';
	// 			$employee['status'] = $obj->getStatus();
	// 			$employees['employees'][] = $employee;
	// 		}
	// 		$this->set_response($employees,REST_Controller::HTTP_OK);
	// 	}catch(Exception $e){
	// 		$message = ['message'=>$e->getMessage(),'status'=>500];
	// 		$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
	// 	}
	// }
	// public function editEmployee_post(){
	// 	$input = file_get_contents('php://input');
	// 	$data = json_decode($input);
	// 	if(is_object($data)){
	// 		try{
	// 			$rqb = $this->_em->createQueryBuilder();
	// 				$roleObj = $rqb->select('r')->from('Entity\Role','r')->getQuery()->getResult();
	// 				$roles = array();
	// 				foreach ($roleObj as $key => $obj) {
	// 					$role = array();
	// 					$role['id'] 	= $obj->getId();
	// 					$role['name']	= $obj->getName();
	// 					$roles['roles'][] = $role;
	// 				}
	// 			$aqb = $this->_em->createQueryBuilder();
	// 			$areas = $aqb->select('a')->from('Entity\Area','a')->getQuery()->getArrayResult();
	// 		$empId = 0;
	// 		if(property_exists($data,'empId')){
	// 			$empId 		= $data->empId;
	// 			$empObj = $this->_em->find('Entity\Employee',$empId);
	// 			$employee = array();
	// 			$employee['empId'] 	= $empObj->getId();
	// 			$employee['name'] 	= $empObj->getName();
	// 			$employee['email'] 	= $empObj->getEmail();
	// 			$employee['mobile'] 	= $empObj->getMobile();
	// 			$employee['roleId'] = $empObj->getRoleId()->getId();
	// 			$employee['roles']	= $roles;
	// 			$employee['areaId'] 	= $empObj->getAreaId()->getId();	
	// 			$employee['areas'] 	= $areas;
	// 			$this->set_response($employee,REST_Controller::HTTP_OK);
	// 		}else{
	// 			$message = ['message'=>'payload mistake','status'=>500];
	// 			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
	// 		}
	// 		}catch(Exception $e){
	// 			$message = ['message'=>$e->getMessage(),'status'=>500];
	// 			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
	// 		}
	// 	}else{
	// 		$message = ['message'=>'payload mistake','status'=>500];
	// 		$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
	// 	}
	// }
	public function CUEmployee_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			$cueId = 0;
			if(property_exists($data,'cueId')){
				$cueId 		= $data->cueId;
			}
			try{
				if($cueId){
					$emp = $this->_em->find('Entity\CUEmployee',$cueId);
					if(!is_object($emp)){
						$emp = new Entity\CUEmployee();
					}
				}else{
					$emp = new Entity\CUEmployee();
				}
				if(property_exists($data, 'name')){
					$name 		= $data->name;
					$emp->setName($name);
				}
				if(property_exists($data, 'email')){
					$email 	= $data->email;
					$emp->setEmail($email);
				}
				if(property_exists($data, 'mobile')){
					$mobile = stripcslashes($data->mobile);
					$emp->setMobile($mobile);
				}
				if(property_exists($data, 'password')){
					$password = stripcslashes(trim($data->password));
					$emp->setPassword($password);
				}
				if(property_exists($data, 'roleId')){
					$roleId = $data->roleId;
					$roleId = $this->_em->find('Entity\Role',$roleId);
					if(is_object($roleId))
						$emp->setRoleId($roleId);
				}
				if(property_exists($data, 'cuId')){
					$cuId = $data->cuId;
					$cuId = $this->_em->find('Entity\CUnit',$cuId);
					if(is_object($cuId))
					$emp->setCuId($cuId);
				}
			$this->_em->persist($emp);
			$this->_em->flush();
			$message = ['message'=>'successfully registerd an employee.'];
			$this->set_response($message,REST_Controller::HTTP_CREATED);
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'payload mistake','status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function CUEditEmployee_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			try{
				$rqb = $this->_em->createQueryBuilder();
					$roleObj = $rqb->select('r')->from('Entity\Role','r')->getQuery()->getResult();
					$roles = array();
					foreach ($roleObj as $key => $obj) {
						$role = array();
						$role['id'] 	= $obj->getId();
						$role['name']	= $obj->getName();
						$roles['roles'][] = $role;
					}
				$aqb = $this->_em->createQueryBuilder();
				$areas = $aqb->select('a')->from('Entity\CUnit','a')->getQuery()->getArrayResult();
			$cueId = 0;
			if(property_exists($data,'cueId')){
				$cueId 		= $data->cueId;
				$empObj = $this->_em->find('Entity\CUEmployee',$cueId);
				$employee = array();
				$employee['cueId'] 	= $empObj->getId();
				$employee['name'] 	= $empObj->getName();
				$employee['email'] 	= $empObj->getEmail();
				$employee['mobile'] 	= $empObj->getMobile();
				$employee['roleId'] = $empObj->getRoleId()->getId();
				$employee['roles']	= $roles;
				$employee['cuId'] 	= is_object($empObj->getCuId())?$empObj->getCuId()->getId():0;	
				$employee['stores'] = $areas;
				$this->set_response($employee,REST_Controller::HTTP_OK);
			}else{
				$message = ['message'=>'payload mistake','status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'payload mistake','status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function CUEmployees_get(){
		try{
			$empObj = $this->_em->getRepository('Entity\CUEmployee')->findAll();
			$employees = array();
			foreach ($empObj as $key => $obj) {
				$employee = array();
				$employee['cueId'] 	= $obj->getId();
				$employee['name'] 	= $obj->getName();
				$employee['email'] 	= $obj->getEmail();
				$employee['mobile'] = $obj->getMobile();
				$employee['role'] 	= is_object($obj->getRoleId())?$obj->getRoleId()->getName():'';
				$employee['city'] 	= is_object($obj->getCuId())?$obj->getCuId()->getName():'';
				$employee['status'] = $obj->getStatus();
				$employees['employees'][] = $employee;
			}
			$this->set_response($employees,REST_Controller::HTTP_OK);
		}catch(Exception $e){
			$message = ['message'=>$e->getMessage(),'status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function CUEmployees_post(){
		//
	}
	public function cuPlaceOrder_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			$empId=0; $storeCode='cbs'; $cityCode='HY';	 $cuId=0;
			try{
				if(property_exists($data, 'empId')){
					$empId = $data->empId;
					$empId = $this->_em->find('Entity\Employee',$empId);
					if(is_object($empId)){
						if(is_object($areaId = $empId->getAreaId())){
							$cuId = $areaId->getCityId()->getCuId();
							$cityCode = $areaId->getCityId()->getCode();
							$storeCode = $empId->getAreaId()->getCode();
						}elseif(is_object($aptObj = $empId->getApartmentId())){
							$storeCode = $aptObj->getCode();
							$cityCode = $aptObj->getCityId()->getCode();
						}else{
							$storeCode = 'cbs';
						}
					}
				}
				$cueId=0;$areaId=0;
				if(property_exists($data, 'cueId')){
					$cueId = $data->cueId;
					$cueId = $this->_em->find('Entity\CUEmployee',$cueId);
				}
				$n = rand(1001,9999);
				$orderId = date('dmY').'-'.$cityCode.'-CUS-'.$storeCode.'-'.$n;
				$cusOrder = new Entity\CUSOrder();
				$cusOrder->setOrderId($orderId);
				if(is_object($empId))
					$cusOrder->setEmployeeId($empId);
				if(is_object($areaId)){
					$cusOrder->setStoreId($areaId);
				}
				if(is_object($cuId))
					$cusOrder->setCuId($cuId);
					$orders = $data->orders;
					foreach ($orders as $key => $obj) {
						$cud = new Entity\CUOrderDetails();
						$placeOrderId = $this->_em->find('Entity\PlaceOrderId',$obj);
						if(is_object($placeOrderId)){
							$placeOrderId->setCuStatus(1);
							$pOrderId = $placeOrderId->getOrderId();
							$this->load->library('cbs',$this->_em);
							$this->cbs->changeOrderStatus($pOrderId,'STCU');
							$cud->setOrderId($placeOrderId);
							$cud->setStatus(0);
							$cusOrder->setCUOrder($cud);
						}
					}
				$this->_em->persist($cusOrder);
				$this->_em->flush();
				$message = ['message'=>'successfully sent to CU'];
				$this->set_response($message,REST_Controller::HTTP_OK);
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something went wrong.'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function doDeliveryOrder_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
		 $storeCode='cbs'; $cityCode='HY';	$storeId=0; $storeName = ' store'; $storeId=0; $aprtStoreId=0;
			try{
				if(property_exists($data, 'storeId') && $storeId = $data->storeId){
					$storeId = $data->storeId;
					$storeId = $this->_em->find('Entity\Area',$storeId);
					if(is_object($storeId)){
						$storeName = $storeId->getName().' store ';
						if(is_object($cityId = $storeId->getCityId())){
							$cityCode = $cityId->getCode();
							$storeCode = $storeId->getCode();
						}else{
							$storeCode = 'cbs';
						}
					}
				}
				else if(property_exists($data, 'aprtStoreId') && $aprtStoreId = $data->aprtStoreId){
					$aprtStoreId = $data->aprtStoreId;
					$aprtStoreId = $this->_em->find('Entity\Apartment',$aprtStoreId);
					if(is_object($aprtStoreId)){
						if(is_object($cityId = $aprtStoreId->getCityId())){
							$cityCode = $cityId->getCode();
							$storeCode = $aprtStoreId->getCode();
						}else{
							$storeCode = 'cbs';
						}
					}
				}
				$cueId=0; $cuId = 0;
				if(property_exists($data, 'cueId') && $cueId = $data->cueId){
					$cueId = $this->_em->find('Entity\CUEmployee',$cueId);
					if(is_object($cueId))
					 $cuId = $cueId->getCuId();
				}
				$n = rand(1001,9999);
				$orderId = date('dmY').'-'.$cityCode.'-CUD-'.$storeCode.'-'.$n;
				$cudOrder = new Entity\CUDOrder();
				$cudOrder->setOrderId($orderId);
				//if(is_object($cueId))
					//$cudOrder->setCUEmployeeId($cueId);
				if(is_object($aprtStoreId)){
					$cudOrder->setApartmentStoreId($aprtStoreId);
				}
				if(is_object($storeId)){
					$cudOrder->setStoreId($storeId);
				}
				if(is_object($cuId))
					$cudOrder->setCuId($cuId);
					$orders = $data->orders;
					foreach ($orders as $key => $obj) {
						$cud = new Entity\CUOrderDetails();
						$placeOrderId = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('order_id'=>$obj));
						if(is_object($placeOrderId)){
							$this->load->library('cbs',$this->_em);
							$this->cbs->changeOrderStatus($obj,'CUTS','order delivered to store');
							//$placeOrderId->setOrderStatus('CUTS');
							//$placeOrderId->setOrderStatusMessage('order delivered to store');
							//$placeOrderId->setCuStatus(1);
							//$this->_em->persist($placeOrderId);
							$cud->setMessage('Delivered');
							$cud->setOrderId($placeOrderId);
							$cud->setStatus(0);
							$cudOrder->setCUOrder($cud);
						}
					}
				$this->_em->persist($cudOrder);
				$this->_em->flush();
				$message = ['message'=>'successfully sent to '.$storeName];
				$this->set_response($message,REST_Controller::HTTP_OK);
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something went wrong.'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function cuSendOrders_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(property_exists($data, 'cityId'))
			$cityId = $data->cityId;
		else
			$cityId = 0;
		try{
			$qb = $this->_em->createQueryBuilder();
			$cuOrderObj = $qb->select('cs')->from('Entity\CUSOrder','cs')->orderBy('cs.created_at','desc')->getQuery()->getResult();
			$cuOrders = array();
			foreach ($cuOrderObj as $key => $obj) {
				$cu = array();
				$cuCityId = 0;
				$cuCityId = is_object($obj->getCuId())?$obj->getCuId()->getCityId()->getId():0;		
				$cu['cuId'] =  $obj->getId();
				$cu['store'] =  is_object($obj->getStoreId())?$obj->getStoreId()->getName():'';
				$cu['orderId'] = $obj->getOrderId();
				$cu['status'] =  $obj->getStatus()?$obj->getStatus():'order prepaired';
				$cu['cuEmployee'] = is_object($obj->getCUEmployeeId())?$obj->getCUEmployeeId()->getName():'';
				$cu['orderDate']  		= strtotime($obj->getCreatedAt()->format('Y-m-d H:i:s'))*1000;
				if($cityId){
					if($cityId==$cuCityId){
						$cuOrders['orders'][] = $cu;
					}else{
					}
				}else{
					$cuOrders['orders'][] = $cu;
				}
			}
			$this->set_response($cuOrders,REST_Controller::HTTP_OK);
		}catch(Exception $e){
			$message = ['message'=>$e->getMessage(),'status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function cuAdminSendOrderStatus_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			try{
				if(property_exists($data, 'orderId') && $data->orderId && property_exists($data, 'status') && $data->status){
					$orderId 	= $data->orderId;
					$status 	= $data->status;
					$cuOrderObj = $this->_em->find('Entity\CUSOrder',$orderId);
					if(is_object($cuOrderObj)){
						$cuOrderObj->setStatus($status);
						foreach ($cuOrderObj->getCUOrders() as $key => $obj) {
							$obj->setStatus($status);
						}
						$this->_em->persist($cuOrderObj);
						$this->_em->flush();
						$message = ['message'=>'successfully updated status.'];
						$this->set_response($message,REST_Controller::HTTP_OK);	
			 		}else{
						$message = ['message'=>'something went wrong'];
						$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);	
					}
				}else{
					$message = ['message'=>'something went wrong'];
					$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
				}
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something went wrong'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function storeCUSendOrders_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(property_exists($data, 'areaId'))
			$areaId = $data->areaId;
		else
			$areaId = 0;
		try{
			$qb = $this->_em->createQueryBuilder();
			$cuOrderObj = $qb->select('cs')->from('Entity\CUSOrder','cs')->orderBy('cs.created_at','DESC')->getQuery()->getResult();
			$cuOrders = array();
			foreach ($cuOrderObj as $key => $obj) {
				$cu = array();
				$orderAreaId = 0;
				if(is_object($empObj = $obj->getEmployeeId())){
					if(is_object($areaObj = $empObj->getAreaId())){
						$orderAreaId = $areaObj->getId();		
					}
				}
				$cu['cuId'] =  $obj->getId();
				$cu['store'] =  is_object($obj->getStoreId())?$obj->getStoreId()->getName():'';
				$cu['orderId'] = $obj->getOrderId();
				$cu['status']  = $obj->getStatus();
				/*if($obj->getStatus()==0)
					$cu['status'] = 'prepaired';
				elseif($obj->getStatus()==1)
					$cu['status'] = 'pickup boy approved';
				else if($obj->getStatus()==2)
					$cu['status'] = 'CU approved';
				else if($obj->getStatus()==-1)
					$cu['status'] = 'CU rejected';
					*/
				$cu['cuEmployee'] = is_object($obj->getCUEmployeeId())?$obj->getCUEmployeeId()->getName():'';
				$cu['orderDate']  		= strtotime($obj->getCreatedAt()->format('Y-m-d h:i:s a'))*1000;
				if($areaId){
					if($areaId==$orderAreaId){
						$cuOrders['orders'][] = $cu;
					}
				}else{
					$cuOrders['orders'][] = $cu;
				}
			}
			$this->set_response($cuOrders,REST_Controller::HTTP_OK);
		}catch(Exception $e){
			$message = ['message'=>$e->getMessage(),'status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function cuDeliveryOrders_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(property_exists($data, 'cityId'))
			$cityId = $data->cityId;
		else
			$cityId = 0;
		try{
			$cuOrderObj = $this->_em->getRepository('Entity\CUDOrder')->findAll();
			$cuOrders = array();
			foreach ($cuOrderObj as $key => $obj) {
				$cu = array();
				$cuCityId = is_object($obj->getCuId())?$obj->getCuId()->getCityId()->getId():'';
				$cu['cuId'] =  $obj->getId();
				$cu['store'] =  is_object($obj->getStoreId())?$obj->getStoreId()->getName():'';
				$cu['orderId'] = $obj->getOrderId();
				$cu['status'] = $obj->getStatus(); 
				$cu['cuEmployee'] = is_object($obj->getCUEmployeeId())?$obj->getCUEmployeeId()->getName():'';
				$cu['orderDate']  		= strtotime($obj->getCreatedAt()->format('Y-m-d h:i:s'))*1000;
				if($cityId){
					if($cityId==$cuCityId){
						$cuOrders['orders'][] = $cu;
					}else{
					}
				}else{
					$cuOrders['orders'][] = $cu;
				}
			}
			$this->set_response($cuOrders,REST_Controller::HTTP_OK);
		}catch(Exception $e){
			$message = ['message'=>$e->getMessage(),'status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function storeCUDeliveryOrders_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(property_exists($data, 'areaId'))
			$areaId = $data->areaId;
		else
			$areaId = 0;
		try{
			$cuOrderObj = $this->_em->getRepository('Entity\CUDOrder')->findAll();
			$cuOrders = array();
			foreach ($cuOrderObj as $key => $obj) {
				$cu = array();
				$orderAreaId = is_object($obj->getStoreId())?$obj->getStoreId()->getId():'';
				$cu['cuId'] =  $obj->getId();
				$cu['store'] =  is_object($obj->getStoreId())?$obj->getStoreId()->getName():'';
				$cu['orderId'] = $obj->getOrderId();
					$cu['status'] = $obj->getStatus();
				$cu['cuEmployee'] = is_object($obj->getCUEmployeeId())?$obj->getCUEmployeeId()->getName():'';
				$cu['orderDate']  		= strtotime($obj->getCreatedAt()->format('Y-m-d h:i:s'))*1000;
				if($areaId){
					if($areaId==$orderAreaId){
						$cuOrders['orders'][] = $cu;
					}else{
					}
				}else{
					$cuOrders['orders'][] = $cu;
				}
			}
			$this->set_response($cuOrders,REST_Controller::HTTP_OK);
		}catch(Exception $e){
			$message = ['message'=>$e->getMessage(),'status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function cuSendOrderAssign_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			try{
				if(property_exists($data, 'orderId') && property_exists($data,'cueId')){
					$orderId 	= $data->orderId;
					$cueId 		= $data->cueId;
					$cueId = $this->_em->find('Entity\CUEmployee', $cueId);
					$cuOrderObj = $this->_em->find('Entity\CUSOrder',$orderId);
					if(is_object($cuOrderObj)){
						if (is_object($cueId)) {
							$cuOrderObj->setCUEmployeeId($cueId);
							$status = 'CPBA';
							$this->load->library('cbs','');
							$amessage = $this->cbs->_amessage;
							$smessage = $amessage[$status];
							$cuOrderObj->setStatus($status);
							foreach ($cuOrderObj->getCUOrders() as $key => $obj) {
								$obj->setStatus($status);
								$obj->getOrderId()->setOrderStatus($status);
								$obj->getOrderId()->setOrderStatusMessage($smessage);
			/* orderstatusdetails start */
								$order_id = $obj->getOrderId()->getOrderId();
								$orderStatusObj = $this->_em->getRepository('Entity\orderstatusdetails')->findOneBy(array('order_id'=>$order_id));
								if(is_object($orderStatusObj)){
									$date   = new \DateTime();
									$orderStatusObj->setCPBA($date);
								}
			/* orderstatusdetails start */								
							}
						}else{
							$message = ['message'=>'something went wrong'];
							$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);	
						}
						$this->_em->persist($cuOrderObj);
						$this->_em->flush();
						$message = ['message'=>'successfully assing cu pickup boy.'];
						$this->set_response($message,REST_Controller::HTTP_OK);	
					}else{
						$message = ['message'=>'something went wrong'];
						$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);	
					}
				}else{
					$message = ['message'=>'something went wrong'];
					$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
				}
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something went wrong'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function cuDeliveryOrderAssign_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			try{
				if(property_exists($data, 'orderId') && property_exists($data,'cueId')){
					$orderId 	= $data->orderId;
					$cueId 		= $data->cueId;
					$status = '';
					if(property_exists($data, 'status')){
						$status = 'CUPA';
					}
					$cueId = $this->_em->find('Entity\CUEmployee', $cueId);
					$cuOrderObj = $this->_em->find('Entity\CUDOrder',$orderId);
					$this->load->library('cbs',$this->_em);
					if(is_object($cuOrderObj)){
						if (is_object($cueId)) {
							$cuOrderObj->setCUEmployeeId($cueId);
							$cuOrderObj->setStatus($status);
							foreach ($cuOrderObj->getCUOrders() as $key => $obj) {
								$this->cbs->changeOrderStatus($obj->getOrderId()->getOrderId(), $status,'order approved by cu pickup boy');	
							}
						}else{
							$message = ['message'=>'something went wrong'];
							$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);	
						}
						$this->_em->persist($cuOrderObj);
						$this->_em->flush();
						$message = ['message'=>'successfully assing cu pickup boy.'];
						$this->set_response($message,REST_Controller::HTTP_OK);	
					}else{
						$message = ['message'=>'something went wrong'];
						$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);	
					}
				}else{
					$message = ['message'=>'something went wrong'];
					$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
				}
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something went wrong'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function cuOrderDetailsTrash_post(){
		$input = file_get_contents('php://input'); 
		$data = json_decode($input);
		if(is_object($data)){
			try{
				if(property_exists($data, 'orderId')){
					$orderId = $data->orderId;
					if($orderId){
						$placeOrderId = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('order_id'=>$orderId));
						$cds = '';
						if(is_object($placeOrderId))
							$cds = $placeOrderId->getCUOrderDetails();
						if(is_object($placeOrderId) && is_object($cds)){
							$placeOrderId->setCuStatus(0); // let u check
							$placeOrderId->setOrderStatus('PO');
							$placeOrderId->setOrderStatusMessage('order prepaired');
							$this->_em->persist($placeOrderId);	
							foreach($cds as $k=>$v){
								if(is_object($v->getCusoId())){
									$this->_em->remove($v);
								}
							}
						}
						$this->_em->flush();
						$message = ['message'=>'successfully deleted send order','status'=>200];
						$this->set_response($message,REST_Controller::HTTP_OK);
					}else{
						$message = ['message'=>$e->getMessage(),'status'=>500];
						$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
					}
				}
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something went wrong'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function cuDeleteDeliveryOrder_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			try{
				if(property_exists($data, 'orderId')){
					$orderId = $data->orderId;
					if($orderId){
						$placeOrderId = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('order_id'=>$orderId));
						$cds = '';
						if(is_object($placeOrderId))
							$cds = $placeOrderId->getCUOrderDetails();
							foreach ($cds as $key => $cd) {
								$cd->setCudoId(null);
								$this->_em->persist($cd);
							}
						if(is_object($placeOrderId) && is_object($cd)){
							$this->load->library('cbs',$this->_em);
							$this->cbs->changeOrderStatus($orderId,'CUAA');
							$this->_em->flush();
							$rmessage = ['message'=>'order successfully deleted '];
							$this->set_response($rmessage,REST_Controller::HTTP_OK);
						}
					}else{
						$message = ['message'=>$e->getMessage(),'status'=>500];
						$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
					}
				}
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something went wrong'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function cuOrderStatus_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			$empId=0; $storeCode='cbs';
			try{
				if(property_exists($data, 'orderId') && $orderId = $data->orderId){
					$status = '';
					if(property_exists($data, 'status')){
						$status = $data->status;
					}
					$this->load->library('cbs',$this->_em);
					$amessage = $this->cbs->_amessage;
					$smessage = $amessage[$status];
					$rmessage = $this->cbs->changeOrderStatus($orderId,$status,$smessage);	
					$rmessage = ['message'=>$rmessage];
					$this->set_response($rmessage,REST_Controller::HTTP_OK);
				}else{
					$rmessage = ['message'=>'something went wrong'];
					$this->set_response($rmessage,REST_Controller::HTTP_BAD_REQUEST);
				}
			}catch(Exception $e){
				$rmessage = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($rmessage,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something went wrong'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function cuOrderItemStatus_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			$empId=0; $storeCode='cbs';
			try{
				if(property_exists($data, 'inBarCode') && $inBarCode = $data->inBarCode){
					$status = '';$secondStatus='';$message=''; $secondMessage='';
					if(property_exists($data, 'status'))
						$status = $data->status;
					if(property_exists($data, 'secondStatus')){
						$secondStatus = $data->secondStatus;
						if($secondStatus=='HG-D'){
							$status = 'SA-D';
						}
					}else{
						$secondStatus = $status;
					}
					if(property_exists($data, 'message')){
						$message = $data->message;
					}
					if(property_exists($data, 'secondMessage')){
						$secondMessage = $data->secondMessage;
					}
					$this->load->library('cbs',$this->_em);
					$this->cbs->lostPlaceOrderItemIn($inBarCode, $status);
					$this->cbs->changeItemStatus($inBarCode,$status,$message,$secondStatus, $secondMessage);
					$message = ['message'=>'"'.$inBarCode.'" garment status updated successfully'];
					$this->set_response($message,REST_Controller::HTTP_OK);
				}else{
					$message = ['message'=>'something went wrong'];
					$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
				}
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something went wrong'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function cuOrderDetails_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			try{
				if(property_exists($data, "orderId") && $orderId = $data->orderId){
					$qb = $this->_em->createQueryBuilder();
					$cudObj = '';
					if(is_object($cudObj)){
						$orderDetails = array();
						$orderDetails['orderId'] = $cuoObj->getOrderId();
						//$orderDetails['pickupBoy'] = is_object($cuoObj->getCUEmployeeId())?$cuoObj->getCUEmployeeId()->getName():'';
						$itemCount = 0;
						$itemDetails = array();
						foreach ($cudObj as $key => $cudObj) {
							$orderDetail = array();
								$status = 'prepaired';
								if($cudObj->getStatus()==0)
									$status = 'prepaired';
								elseif($cudObj->getStatus()==1)
									$status = 'pickup boy approved';
								else if($cudObj->getStatus()==2)
									$status = 'CU approved';
								else if($cudObj->getStatus()==-2)
									$status = 'CU rejected';
								else if($cudObj->getStatus()== 3)
									$status = 'CU Delivered';
								else if($cudObj->getStatus()== -3)
									$status = 'CU hold';
								$placeOrderIdObj = $cudObj->getOrderId();
								$oid  = $placeOrderIdObj->getOrderId();
								$pobj = $this->_em->getRepository('Entity\PlaceOrder')->findBy(array('order_id'=>$oid));
								if(count($pobj)){
									$details = array();
									$details['status'] = $status;
									$details['orderId'] = $oid; 
									$orderDetail['details'] = $details;
									$orders = array();
									foreach ($pobj as $key => $pv) {
										$order = array();
										$itemName 		= $pv->getItemId()->getItemTypeId()->getName().' - '.$pv->getItemId()->getName();
										$serviceName 	= $pv->getServiceId()->getName();
										$itemCount 		= $pv->getItemCount();
										$serviceItem 	= $serviceName.' - '.$itemName;
										if(array_key_exists($serviceItem, $itemDetails) && $tc = $itemDetails[$serviceItem])
											$itemDetails[$serviceItem] = $tc + $itemCount;
										else
											$itemDetails[$serviceItem] = $itemCount;
										$order['item'] 		= $itemName;
										$order['service']	= $serviceName;
										$order['icount']	= $itemCount;
										if($itemCount)
										$orders[] = $order;
									}
									$orderDetail['orders'] = $orders;
									$orderDetails['orders'][] = $orderDetail;
								}
							}
							$orderDetails['itemDetails'] = $itemDetails;
						$this->set_response($orderDetails,REST_Controller::HTTP_OK);	
					}
				}else{
					$message = ['message'=>'something went wrong'];
					$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
				}
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something went wrong'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}	
	}
	// public function cusOrderDetails_post(){
	// 	$input = file_get_contents('php://input');
	// 	$data = json_decode($input);
	// 	if(is_object($data)){
	// 		try{
	// 			if(property_exists($data, "orderId") && $orderId = $data->orderId){
	// 				$qb = $this->_em->createQueryBuilder();
	// 				$cuoObj = $this->_em->find('Entity\CUSOrder',$orderId);
	// 				if(is_object($cuoObj)){
	// 					$orderDetails = array();
	// 					$orderDetails['orderId'] = $cuoObj->getOrderId();
	// 					$orderDetails['pickupBoy'] = is_object($cuoObj->getCUEmployeeId())?$cuoObj->getCUEmployeeId()->getName():'';
	// 					$itemCount = 0;
	// 					$totalItemsCount = 0;
	// 					$itemDetails = array();
	// 					foreach ($cuoObj->getCUOrders() as $key => $cudObj) {
	// 						$orderDetail = array();
	// 							$status = $cudObj->getStatus();
	// 							$placeOrderIdObj = $cudObj->getOrderId();
	// 							$status = $placeOrderIdObj->getOrderStatus();
	// 							$oid  = $placeOrderIdObj->getOrderId();
	// 							$id  = $placeOrderIdObj->getId();
	// 							$qd  = $placeOrderIdObj->getQd();
	// 							$ddd= 	is_object($placeOrderIdObj->getDeliveryDate())?$placeOrderIdObj->getDeliveryDate()->format('Y-m-d h:i:s'):'';
	// 							$orderDetails['storeName']  = $placeOrderIdObj->getStoreId()->getName();
	// 							$deliveryDate =	strtotime($ddd)*1000;
	// 							$pobj = $this->_em->getRepository('Entity\PlaceOrder')->findBy(array('order_id'=>$oid));
	// 							if(count($pobj)){
	// 								$details = array();
	// 								$details['status'] = $status; 
	// 								$details['orderId'] = $oid; 
	// 								$details['receiptId'] = $id; 
	// 								$details['qd'] = $qd; 
	// 								$details['deliveryDate'] = $deliveryDate; 
	// 								$orderDetail['details'] = $details;
	// 								$orders = array();
	// 								foreach ($pobj as $key => $pv) {
	// 									$order = array();
	// 									//$itemName 		= $pv->getItemId()->getItemTypeId()->getName().' - '.$pv->getItemId()->getName();
	// 									$itemName 		= $pv->getItemId()->getItemTypeId()->getCode().' - '.$pv->getItemId()->getName();
	// 									$serviceName 	= $pv->getServiceId()->getCode();
										
	// 									//$serviceCode 	= $pv->getServiceId()->getCode();
	// 									$itemCount 		= $pv->getItemCount();
	// 									$totalItemsCount+=$itemCount;
	// 									$serviceItem 	= $serviceName.' - '.$itemName;
	// 									if(array_key_exists($serviceItem, $itemDetails) && $tc = $itemDetails[$serviceItem])
	// 										$itemDetails[$serviceItem] = $tc + $itemCount;
	// 									else if($itemCount)
	// 										$itemDetails[$serviceItem] = $itemCount;
	// 									$order['item'] 		= $itemName;
	// 									$order['service']	= $serviceName;
	// 									$order['icount']	= $itemCount;
	// 									if((int)$itemCount)
	// 									$orders[] = $order;
	// 								}
	// 								$orderDetail['orders'] = $orders;
	// 								$orderDetails['orders'][] = $orderDetail;
	// 							}
	// 						}
	// 						$orderDetails['itemDetails'] = $itemDetails;
	// 						$orderDetails['totalItemsCount'] = $totalItemsCount;
	// 					$this->set_response($orderDetails,REST_Controller::HTTP_OK);	
	// 				}
	// 			}else{
	// 				$message = ['message'=>'something went wrong'];
	// 				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
	// 			}
	// 		}catch(Exception $e){
	// 			$message = ['message'=>$e->getMessage(),'status'=>500];
	// 			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
	// 		}
	// 	}else{
	// 		$message = ['message'=>'something went wrong'];
	// 		$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
	// 	}	
	// }
	public function cusOrderDetails_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			try{
				if(property_exists($data, "orderId") && $orderId = $data->orderId){
					$qb = $this->_em->createQueryBuilder();
					$cuoObj = $this->_em->find('Entity\CUSOrder',$orderId);
					if(is_object($cuoObj)){
						$orderDetails = array();
						$orderDetails['orderId'] = $cuoObj->getOrderId();
						$orderDetails['pickupBoy'] = is_object($cuoObj->getCUEmployeeId())?$cuoObj->getCUEmployeeId()->getName():'';
						$itemCount = 0;
						$totalItemsCount = 0;
						$itemDetails = array();
						foreach ($cuoObj->getCUOrders() as $key => $cudObj) {
							$orderDetail = array();
								$status = $cudObj->getStatus();
								$placeOrderIdObj = $cudObj->getOrderId();
								$status = $placeOrderIdObj->getOrderStatus();
								$oid  = $placeOrderIdObj->getOrderId();
								$id  = $placeOrderIdObj->getId();
								
								$qd  = $placeOrderIdObj->getQd();
								$ddd= 	is_object($placeOrderIdObj->getDeliveryDate())?$placeOrderIdObj->getDeliveryDate()->format('Y-m-d h:i:s'):'';
								$orderDetails['storeName']  = $placeOrderIdObj->getStoreId()->getName();
								$deliveryDate =	strtotime($ddd)*1000;
								$pobj = $this->_em->getRepository('Entity\PlaceOrder')->findBy(array('order_id'=>$oid));
								if(count($pobj)){
									$details = array();
									$details['status'] = $status; 
									$details['orderId'] = $oid;								
									$details['receiptId'] = $id; 
									$details['qd'] = $qd; 
									$details['deliveryDate'] = $deliveryDate; 
									$orderDetail['details'] = $details;
									$orders = array();
									foreach ($pobj as $key => $pv) {
										$order = array();
										$pac = array();
										//$itemName 		= $pv->getItemId()->getItemTypeId()->getName().' - '.$pv->getItemId()->getName();
										$itemName 		= $pv->getItemId()->getItemTypeId()->getCode().' - '.$pv->getItemId()->getName();
										$serviceName 	= $pv->getServiceId()->getCode();
										foreach ($pv->getPlaceOrderAddons() as $key => $value) {
												$addon = array();
												$addon['addonId'] 		= $addonId = $value->getAddonId()->getId();
												$addon['name']	= $aname = $value->getAddonId()->getName();
												$addon['code']	= $acode = $value->getAddonId()->getCode();
												$addon['acount'] 	= $acount = $value->getCount();
													$akey = '';
													$ac = array();									
													$ac['key'] = $acode;
													$ac['value'] = $value->getCount();
													if(!in_array($ac, $pac)){
														$pac[]	= $ac;	
													}			
												$paddons[] = $addon;
											}
										//$serviceCode 	= $pv->getServiceId()->getCode();
										$itemCount 		= $pv->getItemCount();
										$totalItemsCount+=$itemCount;
										$serviceItem 	= $serviceName.' - '.$itemName;
										if(array_key_exists($serviceItem, $itemDetails) && $tc = $itemDetails[$serviceItem])
											$itemDetails[$serviceItem] = $tc + $itemCount;
										else if($itemCount)
											$itemDetails[$serviceItem] = $itemCount;
										$order['item'] 		= $itemName;
										$order['service']	= $serviceName;
										$order['icount']	= $itemCount;
										//$order['addons']	= $paddons;
										$order['addons'] = $pac;
										if((int)$itemCount)
										$orders[] = $order;									
									}				
									$orderDetail['orders'] = $orders;
									$orderDetails['orders'][] = $orderDetail;
								}
							}
							//$orderDetails['addons'] 		= $paddons;
							$orderDetails['itemDetails'] = $itemDetails;
							$orderDetails['totalItemsCount'] = $totalItemsCount;
						$this->set_response($orderDetails,REST_Controller::HTTP_OK);	
					}
				}else{
					$message = ['message'=>'something went wrong'];
					$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
				}
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something went wrong'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}	
	}
	/**************************************
		this is for delivery order details for both
	***************************************/
	public function cudOrderDetails_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			try{
				if(property_exists($data, "orderId") && $orderId = $data->orderId){
					$qb = $this->_em->createQueryBuilder();
					$cuoObj = $this->_em->find('Entity\CUDOrder',$orderId);
					if(is_object($cuoObj)){
						$orderDetails = array();
						$orderDetails['orderId'] = $cuoObj->getOrderId();
						$orderDetails['pickupBoy'] = is_object($cuoObj->getCUEmployeeId())?$cuoObj->getCUEmployeeId()->getName():'';
						$itemCount = 0;
						$itemDetails = array();
						foreach ($cuoObj->getCUOrders() as $key => $cudObj) {
							$orderDetail = array();
								$placeOrderIdObj 	= $cudObj->getOrderId();
								$status 			= $placeOrderIdObj->getOrderStatus();
								$oid  				= $placeOrderIdObj->getOrderId();
								$receiptNo 			= $placeOrderIdObj->getId();
								$orderDetails['storeName']  = $placeOrderIdObj->getStoreId()->getName();
								$pobj = $this->_em->getRepository('Entity\PlaceOrder')->findBy(array('order_id'=>$oid));
								if(count($pobj)){
									$details = array();
									$details['status'] = $status;
									$details['orderId'] = $oid; 
									$details['receiptNo'] = $receiptNo;
									$orderDetail['details'] = $details;
									$orders = array();
									foreach ($pobj as $key => $pv) {
										$order = array();
										$itemName 		= $pv->getItemId()->getItemTypeId()->getName().' - '.$pv->getItemId()->getName();
										$serviceName 	= $pv->getServiceId()->getName();
										$itemCount 		= $pv->getItemCount();
										$ricount		= $pv->getRIcount();
										$hicount		= $pv->getHIcount();
										$serviceItem 	= $serviceName.' - '.$itemName;
										if(array_key_exists($serviceItem, $itemDetails) && $tc = $itemDetails[$serviceItem])
											$itemDetails[$serviceItem] = $tc + $itemCount;
										elseif($itemCount)
											$itemDetails[$serviceItem] = $itemCount;
										$order['item'] 		= $itemName;
										$order['service']	= $serviceName;
										$order['icount']	= $itemCount;
										$order['ricount']	= $ricount;
										$order['hicount']	= $hicount;
										if($itemCount)
											$orders[] = $order;
									}
									$orderDetail['orders'] = $orders;
									$orderDetails['orders'][] = $orderDetail;
								}
							}
							$orderDetails['itemDetails'] = $itemDetails;
						$this->set_response($orderDetails,REST_Controller::HTTP_OK);	
					}
				}else{
					$message = ['message'=>'something went wrong'];
					$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
				}
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something went wrong'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}	
	} 
	public function cuProcessOrders_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			try{
				if(property_exists($data, "cityId") && $cityId = $data->cityId){
					$qb = $this->_em->createQueryBuilder();
					
					$storeId = 0;
					if(property_exists($data, "storeId") && $data->storeId){
						$storeId = $data->storeId;
					}
					$fromDate = '';
					$toDate = '';
					if($storeId){
						$cdsObj = $qb->select('pi')->from('Entity\PlaceOrderId','pi')->innerJoin('pi.cuOrderDetails','CUOrderDetails')->innerJoin('CUOrderDetails.cuso_id','Entity\CUSOrder')->innerJoin('Entity\CUSOrder.cu_id','Entity\CUnit')->where('Entity\CUnit.city_id=:cityId and pi.store_id=:storeId and (pi.poStatus=\'CUAA\' or pi.poStatus=\'CUAPA\')')->setParameter('storeId',$storeId)->setParameter('cityId',$cityId)->orderBy('CUOrderDetails.created_at','desc')->getQuery()->getResult();
					}else{
						$cdsObj = $qb->select('pi')->from('Entity\PlaceOrderId','pi')->innerJoin('pi.cuOrderDetails','CUOrderDetails')->innerJoin('CUOrderDetails.cuso_id','Entity\CUSOrder')->innerJoin('Entity\CUSOrder.cu_id','Entity\CUnit')->where('Entity\CUnit.city_id=:cityId and (pi.poStatus=\'CUAA\' or pi.poStatus=\'CUAPA\')')->setParameter('cityId',$cityId)->orderBy('CUOrderDetails.created_at','desc')->getQuery()->getResult();
					}
					
					$processOrders = array(); 
					$itemDetails = array();
					foreach ($cdsObj as $key => $placeOrderIdObj) {
						$processOrder = array();
							//$placeOrderIdObj 	= $obj->getOrderId();
							$oid  				= $placeOrderIdObj->getOrderId();
							$receiptNo  		= $placeOrderIdObj->getId();
							$status 			= $placeOrderIdObj->getOrderStatus();
								
								$deliveryDate 			= strtotime($placeOrderIdObj->getDeliveryDate()->format('Y-m-d h:i:s'))*1000;
								
								$pobj = $this->_em->getRepository('Entity\PlaceOrder')->findBy(array('order_id'=>$oid));
								if(count($pobj)){
									$details = array();
									$details['receiptNo'] = $receiptNo;
									$details['status'] 		= $status;
									$details['orderId'] 	= $oid; 
									$details['deliveryDate'] 	= $deliveryDate; 
									$details['storeId'] 	= $placeOrderIdObj->getStoreId()->getId(); 
									$processOrder['details'] = $details;
									$orders = array();
									foreach ($pobj as $key => $pv) {
										$order = array();
										$itemName 		= $pv->getItemId()->getItemTypeId()->getName().' - '.$pv->getItemId()->getName();
										$serviceName 	= $pv->getServiceId()->getName();
										$itemCount 		= $pv->getItemCount();
										$serviceItem 	= $serviceName.' - '.$itemName;
										if(array_key_exists($serviceItem, $itemDetails) && $tc = $itemDetails[$serviceItem])
											$itemDetails[$serviceItem] = $tc + $itemCount;
										else
											$itemDetails[$serviceItem] = $itemCount;
										$order['item'] 		= $itemName;
										$order['service']	= $serviceName;
										$order['icount']	= $itemCount;
										$orders[] = $order;
									}
									$processOrder['items'] = $orders;
									$processOrders['orders'][] = $processOrder;
								}
								
					}
					$this->set_response($processOrders,REST_Controller::HTTP_OK);
				}
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something went wrong'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function cuStores_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			try{
				if(property_exists($data,'cityId')){
					$cityId = $data->cityId;
					$qb = $this->_em->createQueryBuilder();
					$areaObj = $qb->select('a')->from('Entity\Area','a')->where('a.city_id=:cityId and a.status=1')->setParameter('cityId',$cityId)->orderBy('a.name','asc')->getQuery()->getResult();
					$areas = array();
					 foreach ($areaObj as $key => $obj) {
					 	$area = array();
					 	$area['storeId'] 	= $obj->getId();
					 	$area['name']		= $obj->getName();
					 	$areas['stores'][] 	= $area;
					 }
					 $this->set_response($areas,REST_Controller::HTTP_OK);
				}
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something went wrong'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function cuStoresList_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			try{
					$qb = $this->_em->createQueryBuilder();
					$areaObj = $qb->select('c')->from('Entity\CUnit','c')->where('c.status=1')->orderBy('c.name','asc')->getQuery()->getResult();
					$areas = array();
					foreach ($areaObj as $key => $obj) {
					 	$area = array();
					 	$area['cuId'] 	= $obj->getId();
					 	$area['name']		= $obj->getName();
					 	$areas['stores'][] 	= $area;
					}
					$this->set_response($areas,REST_Controller::HTTP_OK);
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something went wrong'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function cuAprtmentStores_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			try{
				if(property_exists($data,'cityId')){
					$cityId = $data->cityId;
					$qb = $this->_em->createQueryBuilder();
					$areaObj = $qb->select('a')->from('Entity\Apartment','a')->innerJoin('a.area_id','Entity\Area')->innerJoin('Entity\Area.city_id','Entity\City')->where('Entity\Area.city_id=:cityId and a.status=1')->setParameter('cityId',$cityId)->orderBy('a.name','asc')->getQuery()->getResult();
					$areas = array();
					 foreach ($areaObj as $key => $obj) {
					 	$area = array();
					 	$area['storeId'] 	= $obj->getId();
					 	$area['name']		= $obj->getName();
					 	$areas['stores'][] 	= $area;
					 }
					 $this->set_response($areas,REST_Controller::HTTP_OK);
				}
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something went wrong'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function returnGarments_post(){
		$input = file_get_contents('php://input');
		$data  = json_decode($input);
		if(is_object($data) && property_exists($data,'cueId') && $data->cueId){
			$cueId = $data->cueId;
			$cueObj = $this->_em->find('Entity\CUEmployee',$cueId);
			$cuId = 'xxxx';
			if(is_object($cueObj)){
				$cuId = $cueObj->getCuId();
			}
			try{
				$qb = $this->_em->createQueryBuilder();
				$processObj = $qb->select('po')->from('Entity\ProcessOrder','po')->where('po.returnGarmentStatus =:returnGarmentStatus')->setParameter('returnGarmentStatus','return')->getQuery()->getResult();
				$results = array();
				foreach ($processObj as $key => $obj) {
					$orderId = $obj->getOrderId();
					$placeOrderId = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('order_id'=>$orderId));
					$receiptNo = $placeOrderId->getId();
					$item = array();
					$item['id'] = $key+1;
					$item['receiptNo'] = $receiptNo;
					$item['name'] = $obj->getName();
					$item['inBarCode'] = $obj->getInBarCode();
					$item['message'] = $obj->getItemStatusMessage();
					$item['returnGarmentStatusMessage'] = $obj->getReturnGarmentStatusMessage();
					$customerObj = $obj->getCustomerId();
					$item['customerName'] = $customerObj->getFirstName().' '.$customerObj->getLastName();
					$item['customerMobile'] = $customerObj->getMobile();
					$results['garments'][] = $item;
				}
				$this->set_response($results,REST_Controller::HTTP_OK);
				}catch(Exception $e){	
					$message = ['message'=>$e->getMessage()];
					$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
				}	
			}else{
				$message = ['message'=>'item miss matched, Please try again right.'];
				$this->set_response($message,REST_Controller::HTTP_NOT_ACCEPTABLE);
			}
	}
	public function holdGarments_post(){
		$input = file_get_contents('php://input');
		$data  = json_decode($input);
		if(is_object($data) && property_exists($data,'cueId') && $data->cueId){
			$cueId = $data->cueId;
			$cueObj = $this->_em->find('Entity\CUEmployee',$cueId);
			$storeCode = 'xxxx';
			if(is_object($cueObj)){
				$storeCode = $cueObj->getCuId()->getCode();
			}
			try{
				$qb = $this->_em->createQueryBuilder();
				$processObj = $qb->select('po')->from('Entity\ProcessOrder','po')->where('po.itemStatus =:itemStatus and ( po.returnGarmentStatus!=\'HG-SPA\' and po.returnGarmentStatus!=\'HG-D\' ) ')->setParameter('itemStatus','hold')->getQuery()->getResult();
				$results = array();
				foreach ($processObj as $key => $obj) {
					$item = array();
					$item['id'] = $key+1;
					$item['name'] = $obj->getName();
					$item['service'] = $obj->getServiceId()->getName();
					$item['brand'] = $obj->getBrand();
					$item['color'] = $obj->getColor();
					$item['itemStatus'] = $obj->getItemStatus();
					$item['itemStatusMessage'] = $obj->getItemStatusMessage();
					$item['inBarCode'] = $obj->getInBarCode();
					$item['rgStatus'] = $obj->getReturnGarmentStatus();
					$item['rgMessage'] = $obj->getReturnGarmentStatusMessage();
					$customerObj = $obj->getCustomerId();
					$item['customerName'] = $customerObj->getFirstName().' '.$customerObj->getLastName();
					$item['customerMobile'] = $customerObj->getMobile();
					$results['garments'][] = $item;
				}
				$this->set_response($results,REST_Controller::HTTP_OK);
			}catch(Exception $e){	
				$message = ['message'=>$e->getMessage()];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}	
		}else{
			$message = ['message'=>'out bar code does not matched with in bar code, Please try again right.'];
			$this->set_response($message,REST_Controller::HTTP_NOT_ACCEPTABLE);
		}
	}
	public function returnGarment_post(){
		$input = file_get_contents('php://input');
		$data  = json_decode($input);
		$qb = $this->_em->createQueryBuilder();
		if(is_object($data) && property_exists($data,'inBarCode') && $data->inBarCode &&  property_exists($data,'message')){
			$inBarCode = $data->inBarCode;
			try{
				$processObj = $this->_em->getRepository('Entity\ProcessOrder')->findOneBy(array('inBarCode'=>$inBarCode));
				if(is_object($processObj)){
					$status = '';$secondStatus='';$message=''; $secondMessage='';
					if(property_exists($data, 'status')){
						$status = $data->status;
						$processObj->setItemStatus($status);
					}
					if(property_exists($data, 'secondStatus')){
						$secondStatus = $data->secondStatus;
						$processObj->setReturnGarmentStatus($secondStatus);	
					}
					if(property_exists($data, 'message')){
						$message = $data->message;
						$processObj->setItemStatusMessage($message);
					}
					if(property_exists($data, 'secondMessage')){
						$secondMessage = $data->secondMessage;
						$processObj->setReturnGarmentStatusMessage($secondMessage);
					}
					$item = $processObj->getBarCodeLabel();
					$this->_em->persist($processObj);
					$this->_em->flush();
					$message = ['message'=>'you successfully returned '.$item.' for '.$secondMessage];
					$this->set_response($message,REST_Controller::HTTP_OK);
				}else{
					$message = ['message'=>'item not exist in our database.'];
					$this->set_response($message,REST_Controller::HTTP_NOT_ACCEPTABLE);
				}
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage()];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'payloads mistake '];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}		
	}
	public function cbsPackages_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			try{
				$qb = $this->_em->createQueryBuilder();
				$packageObj = $qb->select('p')->from('Entity\Package','p')->orderBy('p.name','asc')->getQuery()->getResult();
				$packages = array();
					foreach ($packageObj as $key => $obj) {
					 	$package = array();
					 	$package['pid'] 			= $obj->getId();
					 	$package['name']			= $obj->getName();
					 	$package['cost']			= $obj->getCost();
					 	$package['duration']		= $obj->getDurationInDays();
					 	$package['details']			= $obj->getPackageDetails();
					 	$package['status']			= $obj->getStatus();
					 	$package['updatedAt']	= is_object($obj->getUpdatedAt())?strtotime($obj->getUpdatedAt()->format('d-m-Y H:i:s'))*1000:'';
					 	$package['createdAt']		= is_object($obj->getCreatedAt())?strtotime($obj->getCreatedAt()->format('d-m-Y'))*1000:'';
					 	$packages['packages'][] 	= $package;
					}
				$this->set_response($packages,REST_Controller::HTTP_OK);
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something went wrong'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	// NOT USING 
	/*public function holdGarment_post(){
		$input = file_get_contents('php://input');
		$data  = json_decode($input);
		$qb = $this->_em->createQueryBuilder();
		if(is_object($data) && property_exists($data,'inBarCode') && $data->inBarCode &&  property_exists($data,'message')){
			$inBarCode 	= $data->inBarCode;
			$hmessage 	= $data->message;
			$status   	= $data->status;
			try{
				$processObj = $this->_em->getRepository('Entity\ProcessOrder')->findOneBy(array('inBarCode'=>$inBarCode));
				if(is_object($processObj)){
					$processObj->setItemStatus($status);
					$processObj->setItemStatusMessage($hmessage);
					$item = $processObj->getBarCodeLabel();
					$this->_em->persist($processObj);
					$this->_em->flush();
					$message = ['message'=>'you successfully returned '.$item.' for '.$rmessage];
					$this->set_response($message,REST_Controller::HTTP_OK);
				}else{
					$message = ['message'=>'item not exist in our database.'];
					$this->set_response($message,REST_Controller::HTTP_NOT_ACCEPTABLE);
				}
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage()];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'payloads mistake '];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}		
	}*/
}