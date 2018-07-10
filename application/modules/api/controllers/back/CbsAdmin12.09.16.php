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

	public function CUEmployee_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			$empId = 0;
			if(property_exists($data,'cueId')){
				$cueId 		= $data->cueId;
			}

			try{
				if($cueId){
					$emp = $this->_em->find('Entity\Employee',$cueId);
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
			
				if(property_exists($data, 'cityId')){
					$cityId = $data->cityId;
					$cityId = $this->_em->find('Entity\City',$cityId);
					if(is_object($cityId))
					$emp->setCityId($cityId);

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
				$employee['city'] 	= is_object($obj->getCityId())?$obj->getCityId()->getName():'';
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
							$this->cbs->changeOrderStatus($pOrderId,'STCU','order send to CU');
							//$placeOrderId->setOrderStatus('RSCU');
							//$placeOrderId->setOrderStatusMessage('ready to send CU');
							//$this->_em->persist($placeOrderId);
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
				if(is_object($cueId))
					$cudOrder->setCUEmployeeId($cueId);
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
				if($obj->getStatus()==0)
					$cu['status'] = 'prepaired';
				elseif($obj->getStatus()==1)
					$cu['status'] = 'pickup boy approved';
				else if($obj->getStatus()==2)
					$cu['status'] = 'CU approved';
				else if($obj->getStatus()==-1)
					$cu['status'] = 'CU rejected';


				$cu['cuEmployee'] = is_object($obj->getCUEmployeeId())?$obj->getCUEmployeeId()->getName():'';

				$cu['orderDate']  		= strtotime($obj->getCreatedAt()->format('Y-m-d h:i:s a'))*1000;
				
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
				if($obj->getStatus()==0)
					$cu['status'] = 'prepaired';
				elseif($obj->getStatus()==1)
					$cu['status'] = 'pickup boy approved';
				else if($obj->getStatus()==2)
					$cu['status'] = 'CU approved';
				else if($obj->getStatus()==-1)
					$cu['status'] = 'CU rejected';

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
				if($obj->getStatus()==0)
					$cu['status'] = 'prepaired';
				elseif($obj->getStatus()==1)
					$cu['status'] = 'pickup boy approved';
				else if($obj->getStatus()==2)
					$cu['status'] = 'CU approved';
				else if($obj->getStatus()==-1)
					$cu['status'] = 'CU rejected';

				$cu['cuEmployee'] = is_object($obj->getCUEmployeeId())?$obj->getCUEmployeeId()->getName():'';

				$cu['orderDate']  		= strtotime($obj->getCreatedAt()->format('Y-m-d'))*1000;
				
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
				if($obj->getStatus()==0)
					$cu['status'] = 'prepaired';
				elseif($obj->getStatus()==1)
					$cu['status'] = 'pickup boy approved';
				else if($obj->getStatus()==2)
					$cu['status'] = 'CU approved';
				else if($obj->getStatus()==-1)
					$cu['status'] = 'CU rejected';

				$cu['cuEmployee'] = is_object($obj->getCUEmployeeId())?$obj->getCUEmployeeId()->getName():'';

				$cu['orderDate']  		= strtotime($obj->getCreatedAt()->format('Y-m-d'))*1000;
				
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
							$cuOrderObj->setStatus(1);
							foreach ($cuOrderObj->getCUOrders() as $key => $obj) {
								$obj->setStatus(1);
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
					$cueId = $this->_em->find('Entity\CUEmployee', $cueId);

					$cuOrderObj = $this->_em->find('Entity\CUDOrder',$orderId);
					if(is_object($cuOrderObj)){
						if (is_object($cueId)) {
							$cuOrderObj->setCUEmployeeId($cueId);
							$cuOrderObj->setStatus(1);
							foreach ($cuOrderObj->getCUOrders() as $key => $obj) {
								$obj->setStatus(1);
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
						$cd = '';
						if(is_object($placeOrderId))
							$cd = $placeOrderId->getCUOrderDetails();

						if(is_object($placeOrderId) && is_object($cd)){
							$placeOrderId->setCuStatus(0);
							$this->_em->persist($placeOrderId);	
							$this->_em->remove($cd);
						}
						$this->_em->flush();
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
					
					$this->load->library('cbs',$this->_em);
					$this->cbs->changeOrderStatus($pOrderId,'STCU','order send to CU');	
					
					$message = ['message'=>'successfully updated status'];
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

	public function cuOrderItemStatus_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			$empId=0; $storeCode='cbs';
			try{
				if(property_exists($data, 'inBarCode') && $inBarCode = $data->inBarCode){
					$status = $data->status;
					$message = $data->message;
					$this->load->library('cbs',$this->_em);
					$this->cbs->changeItemStatus($inBarCode,$status,$message);	
					
					$message = ['message'=>'successfully updated status'];
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
										$itemCount 		= $pv->getIcount();
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
						$itemDetails = array();
						foreach ($cuoObj->getCUOrders() as $key => $cudObj) {
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

								$status = $placeOrderIdObj->getOrderStatus();
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
										$itemCount 		= $pv->getIcount();
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
										$itemCount 		= $pv->getIcount();
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
					$cdsObj = $qb->select('cd')->from('Entity\CUOrderDetails','cd')->innerJoin('cd.cuso_id','Entity\CUSOrder')->innerJoin('Entity\CUSOrder.cu_id','Entity\CUnit')->where('Entity\CUnit.city_id=:cityId ')->setParameter('cityId',$cityId)->getQuery()->getResult();
					$processOrders = array(); $itemDetails = array();
					foreach ($cdsObj as $key => $obj) {
						$processOrder = array();
								$status = 'prepaired';
								if($obj->getStatus()==0)
									$status = 'prepaired';
								elseif($obj->getStatus()==1)
									$status = 'pickup boy approved';
								else if($obj->getStatus()==2)
									$status = 'CU approved';
								else if($obj->getStatus()==-2)
									$status = 'CU rejected';
								else if($obj->getStatus()== 3)
									$status = 'CU Delivered';
								else if($obj->getStatus()== -3)
									$status = 'CU hold';


								$placeOrderIdObj 	= $obj->getOrderId();
								$oid  				= $placeOrderIdObj->getOrderId();
								if($placeOrderIdObj->getOrderStatus()=='CUTS')
									continue;
								$orderDate 			= strtotime($placeOrderIdObj->getOrderDate()->format('Y-m-d H:i:s'))*1000;
								//$orderDate 			= is_object($placeOrderIdObj->getOrderDate())?strtotime($placeOrderIdObj->getOrderDate()->format('Y-m-d H:is'))*1000:0;
								$pobj = $this->_em->getRepository('Entity\PlaceOrder')->findBy(array('order_id'=>$oid));
								
								if(count($pobj)){
									$details = array();
									$details['status'] 		= $status;
									$details['orderId'] 	= $oid; 
									$details['orderDate'] 	= $orderDate; 
								
									$processOrder['details'] = $details;
							
							
									$orders = array();
									foreach ($pobj as $key => $pv) {
										$order = array();
										$itemName 		= $pv->getItemId()->getItemTypeId()->getName().' - '.$pv->getItemId()->getName();
										$serviceName 	= $pv->getServiceId()->getName();
										$itemCount 		= $pv->getIcount();
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

				$processObj = $qb->select('po')->from('Entity\ProcessOrder','po')->where('po.returnGarmentStatus =:returnGarmentStatus')->setParameter('returnGarmentStatus','returned')->getQuery()->getResult();
				$results = array();
				foreach ($processObj as $key => $obj) {
					$item = array();
					$item['id'] = $key+1;
					$item['name'] = $obj->getName();
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
				$message = ['message'=>'out bar code does not matched with in bar code, Please try again right.'];
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

				$processObj = $qb->select('po')->from('Entity\ProcessOrder','po')->where('po.itemStatus =:itemStatus')->setParameter('itemStatus','hold')->getQuery()->getResult();
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


					$item['message'] = $obj->getItemStatusMessage();
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
			$rmessage = $data->message;
			try{
				$processObj = $this->_em->getRepository('Entity\ProcessOrder')->findOneBy(array('inBarCode'=>$inBarCode));
				if(is_object($processObj)){
					$processObj->setItemStatus('returned');
					
					$processObj->setReturnGarmentStatus('returned');
					$processObj->setReturnGarmentStatusMessage($rmessage);

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
	}


	public function holdGarment_post(){
		$input = file_get_contents('php://input');
		$data  = json_decode($input);

		$qb = $this->_em->createQueryBuilder();

		if(is_object($data) && property_exists($data,'inBarCode') && $data->inBarCode &&  property_exists($data,'message')){
			$inBarCode = $data->inBarCode;
			$hmessage = $data->message;
			try{
				$processObj = $this->_em->getRepository('Entity\ProcessOrder')->findOneBy(array('inBarCode'=>$inBarCode));
				if(is_object($processObj)){
					$processObj->setItemStatus('hold');
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
	}
}