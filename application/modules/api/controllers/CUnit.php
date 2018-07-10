<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class CUnit extends REST_Controller {

   

   function __construct(){

		parent::__construct();	

	

        $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key

        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key

        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key

		$this->methods['apartment_get']['limit'] = '10';

		$this->methods['itemtype_get']['limit'] = '10';

 		$this->_em = $this->doctrine->em;

    }



	public function authentication_post(){

		

		$this->_em = $this->doctrine->em;

		$qb = $this->_em->createQueryBuilder();

		$input = file_get_contents("php://input");

		$data = json_decode($input);

		$mobile =0;

		$password=0;

		try{

			if(property_exists($data,'mobile'))	

			$mobile 		= $data->mobile;

			

			if(property_exists($data,'password'))	

			$password 	= md5(trim($data->password));

		 

			$employee = $this->_em->getRepository('Entity\CUEmployee')->findOneBy(array('mobile'=>$mobile));

			

			if(is_object($employee)){

				$employee1 = $this->_em->getRepository('Entity\CUEmployee')->findOneBy(array('mobile'=>$mobile,'password'=>$password));				

					if(is_object($employee1)){

						$employee = array();

						$employee['id'] 	= $employee1->getId();

						$employee['name'] 	= $employee1->getName();

						$employee['role'] 	= $role = $employee1->getRoleId()->getName();

						$employee['cityId'] = $employee1->getCityId()->getId();
			$empId = 1;
			$storeIp = $_SERVER['REMOTE_ADDR'];
        	$date = date('Y-m-d H:i:s'); 
        	$this->load->database();
			if ($empId) {
              $mq   = "select eh_id from employeehistory where emp_id='$empId' and DATE(loginTime) = DATE('$date')";
              } 
              $query = $this->db->query($mq);
              $empObj = $query->result();
               if($empObj){
                $empid = $empObj[0]->eh_id;
                $empHistoryObj = $this->_em->find('\Entity\EmployeeHistory',$empid);
               // $empHistoryObj->setLoginTime($date);
              }else{
                $empHistoryObj = new \Entity\EmployeeHistory();
                $empHistoryObj->setEmpId($empId);
                $empHistoryObj->setLoginTime($date);
                $empHistoryObj->setStoreIp($storeIp);              
                
              
              $this->_em->persist($empHistoryObj);
              $this->_em->flush();
            }




						$resourceObj = $qb->select('p')->from('Entity\Permission','p')->where('p.roles like :role and p.status=true')->setParameter('role','%'.$role.'%')->getQuery()->getResult();

						$myResource = array();

						foreach ($resourceObj as $key => $obj) {

							$myResource[] = $obj->getResource();

						}



						$message =[ 'message' => 'Authentication successfull','employee'=>$employee, 'resource'=>$myResource];



						$this->response($message, REST_Controller::HTTP_ACCEPTED); 

					}else{

						$message =[ 'message' => 'in correct login details , please try again '];

						$this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 	

					}

			}else{

				$message =[ 'message' => 'you have no account, please register '];

				$this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 

			}

					 

		}catch(Exception $e){

			$message =[ 'message' => 'Something wrong , pelase contact administrator '];

			$this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 

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

					$order['orderDate'] 	= $value['day'];

					$orders[] = $order;

				}



			$this->set_response($orders,REST_Controller::HTTP_OK);



		

		}catch(Exception $e){

				$message = ['message'=>$e->getMessage(),'status'=>500];

				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);

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



	public function cuPlaceOrders_get(){

		try{

			

			$cuOrderObj = $this->_em->getRepository('Entity\CUOrder')->findAll();

			$cuOrders = array();

			foreach ($cuOrderObj as $key => $obj) {



				$cu = array();

				$cu['store'] = $obj->getEmployeeId()->getAreaId()->getName();

				$cu['order'] = $obj->getOrderId();

				

				if($obj->getStatus()==0)

					$cu['status'] = 'prepaired';

				elseif($obj->getStatus()==1)

					$cu['status'] = 'pickup boy approved';

				else if($obj->getStatus()==2)

					$cu['status'] = 'CU approved';

				else if($obj->getStatus()==-2)

					$cu['status'] = 'CU partial approved';

				else if($obj->getStatus()==3)

					$cu['status'] = 'CU delivered';

				else if($obj->getStatus()==-3)

					$cu['status'] = 'CU partial delivered';



				$cu['message'] = $obj->getMessage();

				$cu['cuEmployee'] = $obj->getCUEmployeeId()->getName();

				$cu['date']  = strtotime($obj->getCreatedAt()->format('Y-m-d'))*1000;

				$cuOrders['orders'][] = $cu;

			}

			$this->set_response($cuOrders,REST_Controller::HTTP_OK);



		}catch(Exception $e){

			$message = ['message'=>$e->getMessage(),'status'=>500];

			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);

		}

	}

	public function cuPlaceOrders_post(){

		$input = file_get_contents('php://input');

		$data = json_decode($input);

		if(property_exists($data, 'areaId'))

			$areaId = $data->areaId;

		else

			$areaId = 0;

		try{

			$cuOrderObj = $this->_em->getRepository('Entity\CUOrder')->findAll();

			$cuOrders = array();





			foreach ($cuOrderObj as $key => $obj) {



				$cu = array();



				$areaObj = $obj->getEmployeeId()->getAreaId();;

				$orderAreaId = $areaObj->getId();



				$cu['cuId'] =  $obj->getId();

				$cu['store'] =  $areaObj->getName();

				$cu['orderId'] = $obj->getOrderId();

				

				if($obj->getStatus()==0)

					$cu['status'] = 'prepaired';

				elseif($obj->getStatus()==1)

					$cu['status'] = 'pickup boy approved';

				else if($obj->getStatus()==2)

					$cu['status'] = 'CU approved';

				else if($obj->getStatus()==-2)

					$cu['status'] = 'CU partial approved';

				else if($obj->getStatus()==3)

					$cu['status'] = 'CU delivered';

				else if($obj->getStatus()==-3)

					$cu['status'] = 'CU partial delivered';

				

				$cu['cuEmployee'] 	= $obj->getCUEmployeeId()->getName();

				$cu['orderDate']  		= strtotime($obj->getCreatedAt()->format('Y-m-d'))*1000;

				

				if($areaId){

					if($areaId==$orderAreaId){

						$cuOrders['orders'][] = $cu;

					}else{

						$cuOrders['orders'] = array();

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

			

			try{

				if(property_exists($data, 'orderId') & property_exists($data, 'status')){

					$orderId = $data->orderId;

					$status  = $data->status;

					$orderObj = $this->_em->find('Entity\CUOrder',$orderId);

					if(is_object($orderObj)){

						$orderObj->setStatus($status);

						$this->_em->persist($orderObj);

						$this->_em->flush();

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

	public function cuPlaceOrderDetails_post(){

		$input = file_get_contents('php://input');

		$data = json_decode($input);

		if(is_object($data)){

			try{

				if(property_exists($data, "orderId") && $orderId = $data->orderId){

					$qb = $this->_em->createQueryBuilder();



					$cuoObj = $this->_em->find('Entity\CUOrder',$orderId);

					if(is_object($cuoObj)){

						$orderDetails = array();

						

						$orderDetails['orderId'] = $cuoObj->getOrderId();

						$orderDetails['pickupBoy'] = is_object($cuoObj->getCUEmployeeId())?$cuoObj->getCUEmployeeId()->getName():'';



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

								$order['item'] 		= $pv->getItemId()->getName();

								$order['service']	= $pv->getServiceId()->getName();

								$order['icount']	= $pv->getIcount();

								$orders[] = $order;

							}

							$orderDetail['orders'] = $orders;

							$orderDetails['orders'][] = $orderDetail;

							}





						}

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



	public function cuOrderDetailStatus_post(){



		$input = file_get_contents('php://input');

		$data = json_decode($input);

		if(is_object($data)){

			try{

				if(property_exists($data, 'orderId') & property_exists($data, 'status')){

					$orderId = $data->orderId;

					$status  = $data->status;

					$orderObj = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('order_id' => $orderId));

					if(is_object($orderObj)){

						$cud = $orderObj->getCUOrderDetails();

						$cud->setStatus($status);

						

						$this->_em->persist($orderObj);

						$this->_em->flush();

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

}