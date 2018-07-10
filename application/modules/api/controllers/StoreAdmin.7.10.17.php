<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class StoreAdmin extends REST_Controller {
   /***
   LNO: 1195: returnGarment_post
   ***/
   function __construct()
   {
		parent::__construct();	
	
        $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
		$this->methods['apartment_get']['limit'] = '10';
		$this->methods['itemtype_get']['limit'] = '10';
		$this->_em = $this->doctrine->em;
		 		// $this->mylogin();
    }


    private function mylogin(){

    	
    }

    public function dayToDeliveryOrders_post(){
    	$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			if(property_exists($data,'storeId') && $data->storeId && 
				property_exists($data,'dDate') && $data->dDate){
				$dDate = $data->dDate;
				$storeId = $data->storeId;
				$dDate = date('Y-m-d',strtotime($dDate));
				try{
					$ddOrders = array();
					$this->load->database();
					  	$mq = 'select s.area_id as storeId, pi.order_id as orderId,
					  		c.firstname as firstname,
					  		c.lastname as lastname,
					  		c.mobile as mobile,
					  		DATE(pi.deliveryDate) as deliveryDate, 
					  		sum(po.icount) as totalItems, 
					  		sum(po.ricount) as totalRitems, 
					  		sum(po.hicount) as totalHitems, 
					  		GROUP_CONCAT(sc.name,"-",it.name,"-",po.icount,"-",po.ricount,"-",po.hicount) as stringItems,
					  		s.name as store 
					  		from place_order as po 
					  		inner join place_order_ids as pi 
					  		on po.order_id = pi.order_id 
					  		left join areas as s 
					  		on pi.store_id = s.area_id 
					  		left join customers as c
					  		on pi.customer_id = c.cust_id
					  		left join services as sc
					  		on po.service_id = sc.service_id
					  		left join items as it 
					  		on po.item_id = it.item_id
					  		where pi.store_id = "'.$storeId.'" 
					  		and pi.isDelete=0 
					  		and DATE(pi.deliveryDate) ="'.$dDate.'" 
					  		group by pi.order_id';
						$query = $this->db->query($mq);
						$ddOrders = $query->result();

					$this->set_response($ddOrders, REST_Controller::HTTP_OK);
				}catch(Exception $e){
					$message = ['message'=>$e->getMessage(),'status'=>500];
					$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
				}
			}else{
				$message = ['message'=>'something we wrongs s.'];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something we wrong.'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
    }
    public function storePendingBalance_post(){
    	$input = file_get_contents("php://input");
		$data = json_decode($input);
		if(is_object($data)){
			if(property_exists($data,'storeId') && $data->storeId)	{

				try{
					$storeId = $data->storeId;
					
					$this->load->database();
					
				 	$qpo = 'select c.firstname as firstname, c.lastname as lastname, c.mobile as mobile, c.wallet as walletAmount, pi.o_id as oid, pi.order_id as orderId, pi.orderDate as orderDate, pi.balanceAmount as balanceAmount, pi.poStatus as orderStatus from place_order_ids as pi inner join customers as c on pi.customer_id = c.cust_id WHERE pi.isDelete=0 and pi.isPackageOrder=0 and pi.balanceAmount>0 and pi.store_id="'.$storeId.'" order by c.firstname, c.wallet';
					
					$queryResult = $this->db->query($qpo);
					$ordersObj = $queryResult->result();

					$result = array();
						foreach ($ordersObj as $key => $orderObj) {
							$order = array();
							
							$order['oid'] = $orderObj->oid;
							$order['orderId'] = $orderObj->orderId;
							$order['orderDate'] = $orderObj->orderDate;
							$order['customerName'] = $orderObj->firstname.' '.$orderObj->lastname;
							$order['customerMobile'] = $orderObj->mobile;
							$order['orderStatus'] = $orderObj->orderStatus;
							$order['walletAmount'] = $orderObj->walletAmount;
							
							$order['balanceAmount'] = number_format(floatval($orderObj->balanceAmount),2);
								$result['orders'][] = $order;
						}	
						
						$this->set_response($result,REST_Controller::HTTP_OK);
					
				}catch(Exception $e){
					$message =[ 'message' =>$e->getMessage()];
					$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
				}
			}else{
				$message =[ 'message' =>' payload mistaken... '];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message =[ 'message' =>' payload mistaken... '];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
		}
    }
    public function storesTargets_get(){

    	try{
    		$stObj = $this->_em->getRepository('Entity\StoreTarget')->findAll();

    		$sts = array();
    		foreach ($stObj as $key => $obj) {
	    		$st = array();
	    		$st['id'] = $key+1;
	    		$st['stId'] = $obj->getId();
	    		$st['storeId'] = is_object($obj->getStoreId())?$obj->getStoreId()->getId():'';
	    		$st['storeName'] = is_object($obj->getStoreId())?$obj->getStoreId()->getName():'';
	    		$st['ordersTarget'] = $obj->getOrdersTarget();
	    		$st['revenueTarget'] = $obj->getRevenueTarget();
	    		$st['targetMonth'] = is_object($obj->getMonth())?$obj->getMonth()->format('M,Y'):'';
	    		$sts['storesTargets'][] = $st;

    		}

			$this->set_response($sts,REST_Controller::HTTP_OK);
    	}catch(Exception $e){
    		$message =[ 'message' =>$e->getMessage()];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
    	}
    }

    public function storeTargetStatus_post(){

    }

    public function addEditStoreTarget_post(){
    	$input = file_get_contents("php://input");
		$data = json_decode($input);
		if(is_object($data)){
			if(property_exists($data,'storeId') && $data->storeId && 
				property_exists($data,'targetMonth') && $data->targetMonth)	{
				try{
					$storeId = $data->storeId;
					$ordersTarget =0;
					$revenueTarget = 0;
					$targetMonth = date('d-m-Y');

					if(property_exists($data, 'ordersTarget')){
						$ordersTarget = $data->ordersTarget;
					}

					if(property_exists($data, 'revenueTarget')){
						$revenueTarget = $data->revenueTarget;
					}

					if(property_exists($data, 'targetMonth')){
						$targetMonth = $data->targetMonth;
					}

					$targetMonthObj = new \DateTime($targetMonth);
					$storeObj = $this->_em->find('Entity\Area',$storeId);
					if(is_object($storeObj)){

						if(property_exists($data,'stId') && $data->stId){
							$stObj = $this->_em->find('Entity\StoreTarget',$data->stId);
							if(!is_object($stObj)){
								$stObj = new \Entity\StoreTarget();
								$msg = ' successfully saved store target';
							}
							$msg = ' successfully updated store target';
						}else{
							$stObj = new \Entity\StoreTarget();
							$msg = ' successfully saved store target';
						}

						$stObj->setStoreId($storeObj);
						$stObj->setOrdersTarget($ordersTarget);
						$stObj->setRevenueTarget($revenueTarget);
						$stObj->setMonth($targetMonthObj);
						$this->_em->persist($stObj);
						$this->_em->flush($stObj);
						$message = ['message'=>$msg,'status'=>200];
						$this->set_response($message,REST_Controller::HTTP_OK);
					}else{
						$message =[ 'message' =>' payload mistaken... '];
						$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
					}

				}catch(Exception $e){
					$message =[ 'message' =>$e->getMessage()];
					$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
				}
			}else{
				$message =[ 'message' =>' payload mistaken... '];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
			}
		}
			else{
				$message =[ 'message' =>' payload mistaken... '];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
			}	
    }

    public function storeTarget_post(){
    	$input = file_get_contents("php://input");
		$data = json_decode($input);
		if(is_object($data)){
			if(property_exists($data,'stId') && $data->stId)	{
				try{
					$stId = $data->stId;
					
					$stObj = $this->_em->find('Entity\StoreTarget',$data->stId);
					if(is_object($stObj)){
						$st = array();
						$st['stId'] = $stObj->getId();
						$st['storeId'] = is_object($stObj->getStoreId())?$stObj->getStoreId()->getId():'';
						$st['ordersTarget'] = $stObj->getOrdersTarget();
						$st['revenueTarget'] = $stObj->getRevenueTarget();
						$st['targetMonth'] = is_object($stObj->getMonth())?$stObj->getMonth()->format('M,Y'):'';

						$this->set_response($st,REST_Controller::HTTP_OK);
					}else{
						$message =[ 'message' =>' payload mistaken... '];
						$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
					}

				}catch(Exception $e){
					$message =[ 'message' =>$e->getMessage()];
					$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
				}
			}else{
				$message =[ 'message' =>' payload mistaken... '];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
			}
		}
			else{
				$message =[ 'message' =>' payload mistaken... '];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
			}	
    }

    public function addCouponCode_post(){
    	$input = file_get_contents("php://input");
		$data = json_decode($input);
		if(is_object($data)){
			if(property_exists($data,'code') && $data->code && 
				property_exists($data,'cost') && $data->cost &&
				property_exists($data,'startDate') && $data->startDate &&
				property_exists($data,'expDate') && $data->expDate )	{
				try{

						$code = $data->code;
						$cost = $data->cost;
						$startDate = $data->startDate;
						$expDate = $data->expDate;

						if(property_exists($data, 'id') && $data->id){
							$id = $data->id;
							$couponObj = $this->_em->find('\Entity\Coupon',$id);
							$msg = 'successfully updated coupon code';
						}else{
							$couponObj = new \Entity\Coupon();
							$msg = 'successfully saved coupon code';
						}
							$couponObj->setCode($code);
							$couponObj->setCost($cost);
							$couponObj->setStartDate($startDate);
							$couponObj->setExpDate($expDate);

							$this->_em->persist($couponObj);
							$this->_em->flush();
					
					$message = ['message'=>$msg,'status'=>200];
					$this->set_response($message,REST_Controller::HTTP_OK);
				}catch(Exception $e){
					$message =[ 'message' =>$e->getMessage()];
					$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
				}
			}else{
				$message =[ 'message' =>' payload mistaken... '];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
			}
		}else{
			$message =[ 'message' =>' payload mistaken... '];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
		}	
    }

    public function getCoupon_post(){
    	$input = file_get_contents("php://input");
		$data = json_decode($input);
		if(is_object($data)){
			if(property_exists($data,'couponId') && $data->couponId)	{
				try{						
						$couponId = $data->couponId;
						$couponObj = $this->_em->find('\Entity\Coupon',$couponId);
						
						$coupon = array();
						$coupon['id'] = $couponObj->getId();
		    			$coupon['code'] = $couponObj->getCode();
		    			$coupon['cost'] = $couponObj->getCost();
		    			$coupon['startDate'] = $couponObj->getStartDate()->format('d-m-Y');
		    			$coupon['expDate'] = $couponObj->getExpDate()->format('d-m-Y');
		    			$coupon['status'] = $couponObj->getStatus();
					$this->set_response($coupon, REST_Controller::HTTP_OK);
				}catch(Exception $e){
					$message =[ 'message' =>$e->getMessage()];
					$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
				}
			}else{
				$message =[ 'message' =>' payload mistaken... '];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
			}
		}else{
			$message =[ 'message' =>' payload mistaken... '];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
		}
    }
    public function getCoupons_get(){

    	try{
    		$couponObj = $this->_em->getRepository('Entity\Coupon')->findAll();

    		$coupons = array();
    		foreach ($couponObj as $key => $obj) {
    			$coupon = array();
    			$coupon['id'] = $obj->getId();
    			$coupon['code'] = $obj->getCode();
    			$coupon['cost'] = $obj->getCost();
    			$coupon['startDate'] = $obj->getStartDate()->format('d-m-Y');
    			$coupon['expDate'] = $obj->getExpDate()->format('d-m-Y');
    			$coupons['coupons'][] = $coupon;
    		}

			$this->set_response($coupons, REST_Controller::HTTP_OK);
    	}catch(Exception $e){
    		$message =[ 'message' =>$e->getMessage()];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
    	}
    }
  
    /*public function dashBoard_post(){
    	$input = file_get_contents("php://input");
			$data = json_decode($input);
			if(is_object($data)){
				if(property_exists($data,'storeId') && $storeId = $data->storeId)	{
					$this->_em = $this->doctrine->em;
					$qb = $this->_em->createQueryBuilder();

				try{

					$ordersArray = array();
					$storeObj = $this->_em->find('Entity\Area',$storeId);

					if(is_object($storeObj)){
						$customersArrayObj = $storeObj->getCustomers();
						
						$ordersArrayObj   				= $storeObj->getPlaceOrderIds();
						$lastMonthOrdersArrayObj 	= $storeObj->getLastMonthPlaceOrderIds();
						$lastDayOrdersArrayObj 		= $storeObj->getLastDayPlaceOrderIds();
						
						$ordersArray['records'] 					= $ordersArrayObj;
						$ordersArray['LastMonthOrders'] 	= $lastMonthOrdersArrayObj;
						$ordersArray['LastDayOrders'] 		= $lastDayOrdersArrayObj;

						$pickupBoysArrayObj  	= $storeObj->getPickupBoys();
						$employeeArrayObj 		= $storeObj->getEmployees();
						$newCustomers 				= $storeObj->getNewCustomers()->count();
					}

					//$customerObj = $qb->select('c')->from('Entity\Customer','c')->where('c.area_id =:storeId')->setParameter('storeId',$storeId)->getQuery()->getResult();

					$result = array();

					$storeInStatus = array('SAA','PO','SAPI');
				  	$storeOutStatus = array('SAAD','SAPAD','ORD','OPRD','DOA','DOPA');

					$cuStatus = array('CPBA','CUAA','CUAPA','HOLD','CUPA','CUPPA','CUTS','CUPSTS','HG-CUD','HG-CUP','HG-CUF');
					
					$redFlagCustomers = 0;
					$greenFlagCustomers = 0;
					$avgProcessingTime = 0;
					$totalOrders = $ordersArrayObj->count();

					foreach ($customersArrayObj as $key => $obj) {
						if($obj->getIsProblematic()){
							$redFlagCustomers++;
						}else{
							$greenFlagCustomers++;
						}
					}
					$pt = array();
					foreach ($ordersArrayObj as $k => $oObj) {
						$pt[] = $oObj->getProcessDelayInDays();
					}

					$avgProcessingTime = ceil(array_sum($pt)/count($pt));
					foreach ($ordersArray as $orderKey => $orderObj) {
							$result[$orderKey] = array();
							$totalOrders = 0;
							$deliveryOrders = 0;
							$storePendingOrders = 0;
							$cuPendingOrders = 0;

							$pendingOrders = 0;
							$storeOutPendingOrders = 0;
							$storeInPendingOrders = 0;
							$balanceAmount = 0;
							$totalAmount = 0;
							$paidAmount = 0;
							$reFundAmount = 0;

							$orderIds = array();
						foreach ($orderObj as $ok => $ov) {
							
							$reFundAmount += $ov->getReFundAmount();
							$balanceAmount += $ov->getBalanceAmount();
							$totalAmount += $ov->getTotalAmount();
							$paidAmount += $ov->getPaidAmount();
					    
					    $orderIds[] = $ov->getOrderId();
							if($ov->getOrderStatus()=='OD'){
									$deliveryOrders++;
							}else if(in_array($ov->getOrderStatus(), $cuStatus)){
									$cuPendingOrders++;
							}else if(in_array($ov->getOrderStatus(), $storeOutStatus)){
								$storeOutPendingOrders++;
							} else{
								 $storeInPendingOrders++;
							}

						}

						$serviceWiseCost = array();
						$this->load->library('cbs',$this->_em);
						$serviceWiseCost = $this->cbs->getServiceWiseCostWithOrderIds($orderIds);

						$result[$orderKey]['totalOrders'] = $totalOrders = $orderObj->count();
						$result[$orderKey]['totalAmount'] = $totalAmount;
						if($totalOrders!=0){
							$result[$orderKey]['avgOrder'] = number_format(($totalAmount/$totalOrders),2,'.','');
						}else{
							$result[$orderKey]['avgOrder'] = 0.00;
						}
						
						$result[$orderKey]['paidAmount'] = $paidAmount;
						$result[$orderKey]['balanceAmount'] = $balanceAmount;
						$result[$orderKey]['reFundAmount'] = $reFundAmount;

						$result[$orderKey]['serviceRevenue']['totalAmount'] = $totalAmount;
						$result[$orderKey]['serviceRevenue'] = $serviceWiseCost;


						$storePendingOrders = $storeOutPendingOrders + $storeInPendingOrders;
						
						$result[$orderKey]['deliveryOrders'] = $deliveryOrders; 
						$result[$orderKey]['pendingOrders']['totalOrders'] = $pendingOrders;
						$result[$orderKey]['pendingOrders']['cuPendingOrders'] = $cuPendingOrders;
						$result[$orderKey]['pendingOrders']['storePendingOrders'] = $storePendingOrders;
						$result[$orderKey]['pendingOrders']['storeInPendingOrders'] = $storeInPendingOrders;
						$result[$orderKey]['pendingOrders']['storeOutPendingOrders'] = $storeOutPendingOrders;
				}


					$employees = array();
					foreach ($employeeArrayObj as $ek => $ev) {
						$emp = array();
						$emp['name'] = $ev->getName();
						$emp['mobile'] = $ev->getMobile();
						$employees[] = $emp;
					}
					$boys = array();
					foreach ($pickupBoysArrayObj as $pbk => $pbv) {
						$boy = array();
						$boy['name'] = $pbv->getName();
						$boy['mobile'] = $pbv->getMobile();
						$boys[] = $boy;
					}

					$totalCustomers = $greenFlagCustomers + $redFlagCustomers;
					$storePendingOrders = $storeOutPendingOrders + $storeInPendingOrders;
			
					$activeCustomers = 0;
					$totalRevenue = 0;
					$complaints = 0;
					

					$result['customer']['totalCustomers'] 		= $totalCustomers;
					$result['customer']['redFlagCustomers'] 	= $redFlagCustomers;
					$result['customer']['greenFlagCustomers'] 	= $greenFlagCustomers;
					$result['customer']['activeCustomers'] 		= $activeCustomers;
					$result['customer']['passiveCustomers'] 	= $totalCustomers - $activeCustomers;
					$result['customer']['newCustomers'] 		= $newCustomers;
					$result['customer']['avgProcessingTime'] 	= $avgProcessingTime;
					$result['complaints'] = $complaints;

					$result['store']['employee'] = $employees;
					$result['store']['pickupBoys'] = $boys;


			

				
					$this->set_response($result,REST_Controller::HTTP_OK);
				}catch(Exception $e){
					$message =[ 'message' =>$e->getMessage()];
					$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
				}
			}else{
				$message =[ 'message' =>' payload mistaken... '];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
			}
		}else{
			$message =[ 'message' =>' payload mistaken... '];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
		}	
    }*/

    public function dashBoard_post(){
    	$input = file_get_contents("php://input");
			$data = json_decode($input);
			if(is_object($data)){
				$fromDateObj = new \DateTime('- 30 days');
				if(property_exists($data,'fromDate') && $data->fromDate){
					$fromDate = $data->fromDate;
				}else{
					$fromDate = $fromDateObj->format('Y-m-d');	
				}

				$toDateObj = new \DateTime('today');
				if(property_exists($data,'toDate') && $data->toDate){
					$toDate = $data->toDate;
				}else{
					$toDate = $toDateObj->format('Y-m-d');	
				}
				
				if(property_exists($data,'storeId') && $storeId = $data->storeId)	{
					$this->_em = $this->doctrine->em;
					$qb = $this->_em->createQueryBuilder();

					try{

						$ordersArray = array();
						$storeTarget = array();
						$storeObj = $this->_em->find('Entity\Area',$storeId);
						$storeBalanceAmount = 0;
						if(is_object($storeObj)){
							$customersArrayObj = $storeObj->getCustomers();
							
							$ordersArrayObj   				= $storeObj->getNetPlaceOrderIds();

							$toDayOrdersArrayObj 		= $storeObj->getToDayPlaceOrderIds();
							$monthOrdersArrayObj 		= $storeObj->getMonthPlaceOrderIds();
							$lastMonthOrdersArrayObj 	= $storeObj->getLastMonthPlaceOrderIds();
							
							$ordersArray['toDayTarget'] 		= $toDayOrdersArrayObj;
							$ordersArray['monthTarget'] 		= $monthOrdersArrayObj;
							$ordersArray['lastMonthTarget'] 	= $lastMonthOrdersArrayObj;

							$storeTarget['toDayTarget'] 		= $storeObj->getMonthTarget();
							$storeTarget['monthTarget'] 		= $storeObj->getMonthTarget();
							$storeTarget['lastMonthTarget'] 	= $storeObj->getLastMonthTarget();

							$pickupBoysArrayObj  	= $storeObj->getPickupBoys();
							$employeeArrayObj 		= $storeObj->getEmployees();
							$newCustomers 			= $storeObj->getNewCustomers()->count();
							$storeBalanceAmount     = $storeObj->getStoreBalance();

							$customerRequestObj 	= $storeObj->getDashBoardReqests();
						}

						$customerRequestArray = array();
					
						foreach ($customerRequestObj as $key => $crObj) {
							$cust = array();
							foreach ($crObj as $k => $rObj) {
								$cust = array();
								$rCustObj = $rObj->getCustomerId();
								$cust['name'] = $rCustObj->getName();
								$cust['mobile'] = $rCustObj->getMobile();
								$cust['rdate'] = is_object($rObj->getDate())?$rObj->getDate()->format('M d, Y'):'';
								$cust['slot'] = $rObj->getSlot();
								//$customerRequestArray[$key]['address'] = $rObj->getAddress();
								$customerRequestArray[$key][] = $cust;
							}
							
						}
							//$customerObj = $qb->select('c')->from('Entity\Customer','c')->where('c.area_id =:storeId')->setParameter('storeId',$storeId)->getQuery()->getResult();

						$result = array();

						$storeInProcessing 	= array('SAA','SAPI','');
						//$storeOutProcessing = array('SAAD','SAPAD','DOA','DOPA');
						$storeOutProcessing = array('SADA','SADPA','SAAD','SAPAD');
					  $cuPending 			= array('PO');
					  $deliveryPending    = array('DOA','DOPA','ORD','OPRD');
					  $cuProcessing 		= array('CPBA','CUAA','CUAPA','HOLD','CUPA','CUPPA','HG-CUD','HG-CUP','HG-CUF');

						$cuDeliveryPending = array('CUTS','CUPSTS');
						
						$redFlagCustomers = 0;
						$greenFlagCustomers = 0;
						$avgProcessingTime = 0;
						$totalOrders = $ordersArrayObj->count();

						foreach ($customersArrayObj as $key => $obj) {
							if($obj->getIsProblematic()){
								$redFlagCustomers++;
							}else{
								$greenFlagCustomers++;
							}
						}
						
							// current required things 
						$pt = array();
						
						$newMobileOrders = 0;
						$storeInProcessOrders = 0;
						$storeOutProcessOrders = 0;
						$cuPendingOrders = 0;
						$deliveryPendingOrders = 0;

						$cuProcessingOrders = 0;
						$cuDeliveryPendingOrders = 0;



						foreach ($ordersArrayObj as $k => $oObj) {
							$pt[] = $oObj->getProcessDelayInDays();

								if($oObj->getOrderStatus()==''){
									$newMobileOrders++;
								}else if(in_array(trim($oObj->getOrderStatus()), $storeInProcessing)){
									$storeInProcessOrders++;
								}else if(in_array(trim($oObj->getOrderStatus()), $storeOutProcessing)){
									$storeOutProcessOrders++;
								}else if(in_array(trim($oObj->getOrderStatus()), array('PO'))){
									$cuPendingOrders++;
								}else if(in_array(trim($oObj->getOrderStatus()), $deliveryPending)){
									$deliveryPendingOrders++;
								}else if(in_array(trim($oObj->getOrderStatus()), $cuProcessing)){
									$cuProcessingOrders++;
								}else if(in_array(trim($oObj->getOrderStatus()), $cuDeliveryPending)){
									$cuDeliveryPendingOrders++;
								}else{
									
								}
						}


					$this->load->database();
					$today = date('Y-m-d');
				 $qTh = 'select sum(th.paidAmount) as paidAmount from transactions_history as th INNER JOIN place_order_ids as pi on th.order_id = pi.order_id WHERE pi.isDelete=0 and pi.isPackageOrder=0 and DATE(th.created_at) ="'.$today.'" and pi.store_id="'.$storeId.'" group by DATE(th.created_at)';
					
					$queryResult = $this->db->query($qTh);
					$orderObj = $queryResult->result();
					$storeCollections = 0;
					if(is_array($orderObj) && sizeof($orderObj))
					$storeCollections = $orderObj[0]->paidAmount;
					

						$result['store']['newMobileOrders'] = $newMobileOrders;
						$result['store']['storeInProcessOrders'] = $storeInProcessOrders;
						$result['store']['storeOutProcessOrders'] = $storeOutProcessOrders;
						$result['store']['cuPendingOrders'] 	  = $cuPendingOrders;
						$result['store']['deliveryPendingOrders'] = $deliveryPendingOrders;
						$result['store']['cuProcessingOrders'] 	  = $cuProcessingOrders;
						$result['store']['cuDeliveryPendingOrders'] = $cuDeliveryPendingOrders;
						$result['store']['storeBalanceAmount'] 	= $storeBalanceAmount;
						$result['store']['storeCollections'] 	= $storeCollections;

						if(count($pt))
						$avgProcessingTime = ceil(array_sum($pt)/count($pt));
						else
						$avgProcessingTime = 0;

						foreach ($ordersArray as $orderKey => $orderObj) {
							$result[$orderKey] = array();
							$totalAmount = 0;
							
							$targetObj = $storeTarget[$orderKey];
							
							foreach ($orderObj as $ok => $ov) {
								if(!$ov->getIsDelete()){
									$totalAmount += $ov->getClosingBalance();
								}
							}

							$result[$orderKey]['totalOrders'] = $totalOrders = $orderObj->count();
							
							if(is_object($targetObj)){
								$result[$orderKey]['ordersTarget'] = $targetObj->getOrdersTarget();
								$result[$orderKey]['revenueTarget'] = $targetObj->getRevenueTarget();
							}else{
								$result[$orderKey]['ordersTarget'] = 0;
								$result[$orderKey]['revenueTarget'] = 0;
							}



							$result[$orderKey]['totalAmount'] = $totalAmount;
							if($totalOrders!=0){
								$result[$orderKey]['avgOrder'] = number_format(($totalAmount/$totalOrders),2,'.','');
							}else{
								$result[$orderKey]['avgOrder'] = 0.00;
							}
						}

						$employees = array();
						foreach ($employeeArrayObj as $ek => $ev) {
							$emp = array();
							$emp['name'] = $ev->getName();
							$emp['mobile'] = $ev->getMobile();
							$employees[] = $emp;
						}
						$boys = array();
						foreach ($pickupBoysArrayObj as $pbk => $pbv) {
							$boy = array();
							$boy['name'] = $pbv->getName();
							$boy['mobile'] = $pbv->getMobile();
							$boys[] = $boy;
						}

						$totalCustomers = $greenFlagCustomers + $redFlagCustomers;
						
						$activeCustomers = 0;
						$totalRevenue = 0;
						$complaints = 0;
						

						$result['customer']['totalCustomers'] 		= $totalCustomers;
						$result['customer']['redFlagCustomers'] 	= $redFlagCustomers;
						$result['customer']['greenFlagCustomers'] 	= $greenFlagCustomers;
						$result['customer']['activeCustomers'] 		= $activeCustomers;
						$result['customer']['passiveCustomers'] 	= $totalCustomers - $activeCustomers;
						$result['customer']['newCustomers'] 		= $newCustomers;
						$result['customer']['avgProcessingTime'] 	= $avgProcessingTime;
						$result['complaints'] = $complaints;

						$result['store']['employee'] = $employees;
						$result['store']['pickupBoys'] = $boys;

						

						$result['customerRequests'] = $customerRequestArray;
						/*$result['customerRequest']['yesterDay'] = $boys;
						$result['customerRequest']['tomorrow'] = $boys;
						$result['customerRequest']['past'] = $boys;
						*/

						$this->set_response($result,REST_Controller::HTTP_OK);
					}catch(Exception $e){
						$message =[ 'message' =>$e->getMessage()];
						$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
					}
				}else{
					$message =[ 'message' =>' payload mistaken... '];
					$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
				}
		}else{
			$message =[ 'message' =>' payload mistaken... '];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
		}	
    }
    
    public function storeCollections_post(){

    	 $input = file_get_contents("php://input");
			 $data = json_decode($input);
			
			if(is_object($data)){
				$fromDate = true;
				if(property_exists($data,'fromDate') && $data->fromDate){
					$fromDate = date('Y-m-d',strtotime($data->fromDate));
				}else{
					$fromDate = false;
				}

				$toDateObj = new \DateTime('today');
				if(property_exists($data,'toDate') && $data->toDate){
					$toDate = date('Y-m-d',strtotime($data->toDate)); //$data->toDate;
				}else{
					$toDate = "";	
				}

				if(property_exists($data,'toDay') && $data->toDay){
					$fromDateObj = new \DateTime('today');
					$fromDate = $fromDateObj->format('Y-m-d');
					$toDate = $toDateObj->format('Y-m-d');
				}
				
				if(property_exists($data,'storeId') && $storeId = $data->storeId)	{
					$storeId = $data->storeId;
				try{

					$this->load->database();
					
				$paymentTypes = array('Cash','PayTM','CreditCard','DebitCard');	
					if($fromDate){
						$qTh = 'select sum(th.paidAmount) as paidAmount, th.paymentType as paymentType, DATE(th.created_at) as paidDate from transactions_history as th INNER JOIN place_order_ids as pi on th.order_id = pi.order_id WHERE pi.isDelete=0 and pi.isPackageOrder=0 and DATE(th.created_at) >="'.$fromDate.'" and DATE(th.created_at) <="'.$toDate.'" and pi.store_id="'.$storeId.'" group by DATE(th.created_at), th.paymentType order by th.paymentType, th.created_at desc';
					}else{
						$qTh = 'select sum(th.paidAmount) as paidAmount, th.paymentType as paymentType, DATE(th.created_at) as paidDate from transactions_history as th INNER JOIN place_order_ids as pi on th.order_id = pi.order_id WHERE pi.isDelete=0 and pi.isPackageOrder=0 and DATE(th.created_at) <="'.$toDate.'" and pi.store_id="'.$storeId.'" group by DATE(th.created_at), th.paymentType order by th.created_at desc,th.paymentType limit 3';	
					}
					
					
					$queryResult = $this->db->query($qTh);
					$orderObj = $queryResult->result();
					$collectionsArray = array();

					foreach ($orderObj as $objKey => $objValue) {
						if(array_key_exists($objValue->paidDate, $collectionsArray) && is_array($collectionsArray[$objValue->paidDate])){
							$collectionsArray[$objValue->paidDate][$objValue->paymentType]= $objValue->paidAmount;
						}else{
							$collectionsArray[$objValue->paidDate] = array($objValue->paymentType=>$objValue->paidAmount);
						}
					}
					foreach ($collectionsArray as $ckey => &$cv) {
						foreach ($paymentTypes as $pk => $pt) {
							if(!array_key_exists($pt,$cv)){
								$cv[$pt] = 0.00;
							}
						}
					}
					
					$this->set_response($collectionsArray,REST_Controller::HTTP_OK);
				}catch(Exception $e){
					$message =[ 'message' =>$e->getMessage()];
					$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
				}
			}else{
				$message =[ 'message' =>' payload mistaken s... '];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
			}
			}else{
				$message =[ 'message' =>' payload mistaken... '];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
			}
    }

    public function superAdmindashBoard_post(){
    	$input = file_get_contents("php://input");
			$data = json_decode($input);
			if(is_object($data)){
				$fromDateObj = new \DateTime('- 30 days');
				if(property_exists($data,'fromDate') && $data->fromDate){
					$fromDate = date('Y-m-d',strtotime($data->fromDate));
				}else{
					$fromDate = $fromDateObj->format('Y-m-d');	
				}

				$toDateObj = new \DateTime('today');
				if(property_exists($data,'toDate') && $data->toDate){
					$toDate = date('Y-m-d',strtotime($data->toDate)); //$data->toDate;
				}else{
					$toDate = $toDateObj->format('Y-m-d');	
				}
				
				

				$result = array();
				$this->load->database();
					
				 $q = 'select s.name as store, s.isServiceTax as isServiceTax, sr.code as service, sum(po.icount) as totalItems, sum(po.ricount) as rItems, sum(po.cost) as totalCost,sum(po.reFund) as reFund, pi.order_id as orderId from place_order as po INNER JOIN place_order_ids as pi on po.order_id = pi.order_id left join areas as s on pi.store_id = s.area_id left join services as sr on po.service_id = sr.service_id WHERE pi.isDelete=0 and pi.isPackageOrder=0 and DATE(pi.orderDate) >="'.$fromDate.'" and DATE(pi.orderDate) <="'.$toDate.'"group by pi.store_id, po.service_id order by pi.store_id, sr.name';
					
					 
					$query = $this->db->query($q);
					$ordersTable = array();
					$orderObj = $query->result();
					$sc = array();
					$stores = array();
					$dstores = array();
					
					foreach ($orderObj as $key => $obj) {
									
						$items 		= $obj->totalItems - $obj->rItems;
						$service 	= $obj->service;
						$orderId 	= $obj->orderId;
						$totalCost  = (int)($obj->totalCost - $obj->reFund);
						if($obj->isServiceTax){
							$settingsObj = $this->_em->find('Entity\Settings',1);

							$serviceTax = $settingsObj->getServiceTax();
							$cost 		= $totalCost + ($totalCost*$serviceTax)/100;
						}else{
							$cost 		= $totalCost;	
						}
						$store 		= $obj->store;

						$stores[$store][] = array($service=>$cost,$service.'Items'=>$items );
					}
					foreach ($stores as $skey => $svalue) {
						$flat = call_user_func_array('array_merge', $svalue);
						$sc[$skey] = $flat;
					}

				$discQ = 'select s.name as store , sum(pi.adminDiscountAmount) as discountAmount, sum(pi.qdAmount) as qdAmount from  place_order_ids as pi left join areas as s on pi.store_id = s.area_id WHERE pi.isDelete=0 and DATE(pi.orderDate) >="'.$fromDate.'" and DATE(pi.orderDate) <="'.$toDate.'" group by pi.store_id order by pi.store_id';
						 
					$discQuery = $this->db->query($discQ);
					$discTable = array();
					$discObj = $discQuery->result();
					$diStores = array();
					foreach ($discObj as $key => $obj) {
								
						$discountAmount = floatval($obj->discountAmount);
						$qdAmount 		= floatval($obj->qdAmount);
						$store 		= $obj->store;
						$diStores[$store] = array('discountAmount'=>$discountAmount,'qdAmount'=>$qdAmount);
						
					}

					foreach ($sc as $skey => $cvalue) {

						if(array_key_exists($skey, $diStores)){
							$flats = array_merge($cvalue,$diStores[$skey]);	
						}else{
							$flats = array_merge($cvalue,array('discountAmount'=>0,'qdAmount'=>0));
						}
						
						$sc[$skey] = $flats;
					}


				$transQ = 'select th.paymentType as paymentType, s.name as store , sum(th.paidAmount) as paidAmount from transactions_history as th INNER JOIN place_order_ids as pi on th.order_id = pi.order_id left join areas as s on pi.store_id = s.area_id WHERE pi.isDelete=0 and DATE(th.created_at) >="'.$fromDate.'" and DATE(th.created_at) <="'.$toDate.'" group by th.paymentType, pi.store_id order by pi.store_id';
						 
					$transQuery = $this->db->query($transQ);
					$collectionsTable = array();
					$transObj = $transQuery->result();
					$th = array();
					$thStores = array();
					$tempStore = '';
					$payArray = array();
					foreach ($transObj as $key => $obj) {
								
						
						$cost 		= (int)$obj->paidAmount;
						$store 		= $obj->store;
						$paymentType = $obj->paymentType;
						
						if($store!=$tempStore){
							$payArray = array();
							$payArray[$paymentType] = $cost;
							$tempStore = $store;
						}else{
							$payArray[$paymentType]=$cost;
						}
						$thStores[$store] = $payArray;
					}

					foreach ($thStores as $key => &$thv) {
						if(!array_key_exists('Cash', $thv)){
							$thv['Cash'] = 0;
						}
						if(!array_key_exists('PayTM', $thv)){
							$thv['PayTM'] = 0;
						}
						if(!array_key_exists('DebitCard', $thv)){
							$thv['DebitCard'] = 0;
						}
						if(!array_key_exists('CreditCard', $thv)){
							$thv['CreditCard'] = 0;
						}
					}

					//print_r($thStores); die();
					foreach ($sc as $skey => $cvalue) {

						if(array_key_exists($skey, $thStores)){
							$flats = array_merge($cvalue,$thStores[$skey]);	
						}else{
							$flats = array_merge($cvalue,array('Cash'=>0,'PayTM'=>0,'DebitCard'=>0,'CreditCard'=>0));
						}
						
						$sc[$skey] = $flats;
					}
						

				$result['ordersTable'] = $sc;


				$crQ = 'select s.name as store,  count(cr.cr_id) as totalItems, cr.status as status from customer_requests as cr INNER JOIN areas as s on cr.area_id = s.area_id WHERE  DATE(cr.crdate) >="'.$fromDate.'" and DATE(cr.crdate) <="'.$toDate.'"group by cr.area_id, cr.status order by cr.area_id, cr.status';
					 
					 	$crQuery = $this->db->query($crQ);
						 	$crTable = array();
							$crObj = $crQuery->result();
							$crStores = array();
							foreach ($crObj as $key => $obj) {

									$status 	= $obj->status;
									$totalItems = (int)$obj->totalItems;
									$store 		= $obj->store;
									$crStores[$store][] = array($status=>$totalItems);
									
							}
							$crr = array();
							foreach ($crStores as $skey => $crvalue) {
								$crflat = call_user_func_array('array_merge', $crvalue);
								$crr[$skey] = $crflat;
							}
						$result['crTable'] = $crr;


					$cuponQ = 'select s.name as store,  count(po.o_id) as totalItems, po.couponCode as couponCode , sum(c.cost) as totalCost from place_order_ids as po INNER JOIN areas as s on po.store_id = s.area_id left join coupons as c on c.code = po.couponCode WHERE po.isDelete=0 and po.couponCode !="" and po.isPackageOrder=0 and DATE(po.orderDate) >="'.$fromDate.'" and DATE(po.orderDate) <="'.$toDate.'" group by po.store_id, po.couponCode order by s.name, po.couponCode';
					 
					 	$cuponQuery = $this->db->query($cuponQ);
						 	
							$cuponObj = $cuponQuery->result();
							$cuponStores = array();
							foreach ($cuponObj as $key => $obj) {

									$couponCode = $obj->couponCode;
									$totalCost 	= $obj->totalCost;
									$totalItems = (int)$obj->totalItems;
									$store 		= $obj->store;
									$cuponStores[$store][] = array($couponCode=>$totalItems);
									
							}
							$cuponAr = array();
							foreach ($cuponStores as $skey => $crvalue) {
								$cupflat = call_user_func_array('array_merge', $crvalue);
								$cuponAr[$skey] = $cupflat;
							}
						$result['cuponsTable'] = $cuponAr;



					$this->set_response($result, REST_Controller::HTTP_OK);
				
		}else{
			$message =[ 'message' =>' payload mistaken... '];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
		}	
    }

    public function dashBoardDetails_post(){
    	$input = file_get_contents("php://input");
		$data = json_decode($input);
		if(is_object($data)){
			if(property_exists($data,'rtype') && 
				property_exists($data,'type') && 
				property_exists($data,'storeId') && 
				$data->storeId)	{
				$storeId = $data->storeId;
				$rtype 	= $data->rtype;
				$type 	= $data->type;


				$storeInProcessing 		= array('SAA','SAPI');
				$storeOutProcessOrders 	= array('SAAD','SAPAD','DOA','DOPA');
				$deliveryPendingOrders  	= array('ORD','OPRD');
				$cuPendingOrders 		= array('PO');
				$cuProcessingOrders 	= array('CPBA','CUAA','CUAPA','HOLD','CUPA','CUPPA','HG-CUD','HG-CUP','HG-CUF');
				$cuDeliveryPendingOrders = array('CUTS','CUPSTS');
						


				$storeObj = $this->_em->find('Entity\Area',$storeId);

					if(is_object($storeObj)){
					
						$result = array();

							$ordersArrayObj   			= $storeObj->getNetPlaceOrderIds();
						foreach ($ordersArrayObj as $key => $orderObj) {
							$order = array();
							$orderStatus = trim($orderObj->getOrderStatus());
							
							$order['orderId'] = $oid = $orderObj->getOrderId();
							$order['orderDate'] = $orderObj->getOrderDate()->format('M d, Y');
							$order['customerName'] = $orderObj->getCustomerId()->getName();
							$order['customerMobile'] = $orderObj->getCustomerId()->getMobile();
							$order['orderStatus'] = $orderObj->getOrderStatus();
							$order['balanceAmount'] = number_format(floatval($orderObj->getBalanceAmount()),2);
							$order['rtype'] = $rtype;
							if($rtype == 'storeInProcessOrders' && in_array($orderStatus, $storeInProcessing)){
								$result['orders'][] = $order;
								
							}else
							if($rtype == 'storeOutProcessOrders' && in_array($orderStatus,$storeOutProcessOrders)){
								$result['orders'][] = $order;	
							}else
							if($rtype == 'cuPendingOrders' && (
								in_array($orderStatus, $cuPendingOrders))){
								$result['orders'][] = $order;	
							}
							else
							if($rtype == 'cuProcessingOrders' && in_array($orderStatus, $cuProcessingOrders)){
								$result['orders'][] = $order;	
								
							}else
							if($rtype=='cuDeliveryPendingOrders' && in_array($orderStatus, $cuDeliveryPendingOrders)){
								$result['orders'][] = $order;
								 
							}else if($rtype=='deliveryPendingOrders' && in_array($orderStatus, $deliveryPendingOrders)){
								$result['orders'][] = $order;
								
							}
							
						}	
						
						$this->set_response($result,REST_Controller::HTTP_OK);
					}
			}
		}else{
			$message =[ 'message' =>' something went wrong... '];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
		}
    }
    public function customerPackageOrders_post(){
    	$input = file_get_contents("php://input");
		$data = json_decode($input);
		if(is_object($data)){
			if(property_exists($data,'storeId') && $storeId = $data->storeId)	{
				$this->_em = $this->doctrine->em;
				$qb = $this->_em->createQueryBuilder();

				try{
					$packageObj = $qb->select('c')->from('Entity\Customer','c')->where('c.package !=:package and c.packageStatus=false')->setParameter('package','')->getQuery()->getResult();

					$orders = array();
					foreach ($packageObj as $key => $obj) {
						$order = array();
						$order['id'] 	= $obj->getId();
						$order['customerName'] 	= $obj->getFirstName().' '.$obj->getLastName();
						$order['mobile'] 		= $obj->getMobile();
						$order['package'] 		= $obj->getPackage();
						$order['packageStatus'] = $obj->getPackageStatus();
						$order['agent']			= $obj->getAgentId()->getName();
						$orders['orders'][] = $order;
					}
					$this->set_response($orders,REST_Controller::HTTP_OK);
				}catch(Exception $e){
					$message =[ 'message' =>$e->getMessage()];
					$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
				}
			}else{
				$message =[ 'message' =>' payload mistaken... '];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
			}
		}else{
			$message =[ 'message' =>' payload mistaken... '];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
		}	
    }

    public function addCustomerPackage_post(){

    	$input = file_get_contents("php://input");
		$data = json_decode($input);
		try{
			$customerId = 0; $packageId = 0 ;
			if(property_exists($data,'customerId') && property_exists($data, 'packageId')){
				
				$customerId = $data->customerId;
				$packageId = $data->packageId;
				$customerObj = $this->_em->find('Entity\Customer',$customerId);
				$packageObj = $this->_em->find('Entity\Package',$packageId);
				if(is_object($customerObj) && is_object($packageObj)){
					
					$customerObj->setPackageUsedDetails('');
					
					$customerObj->setPackageId($packageObj);
					$customerObj->setPackageDetails($packageObj->getPackageDetails());
					
					$this->_em->persist($customerObj);
					$this->_em->flush();		
					$message = ['message'=>'successfully updated resource'];
					$this->set_response($message, REST_Controller::HTTP_OK); 
				}else{

				}
				
			}else{
				$message =[ 'message' =>' payload mistaken... '];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
			}
		}catch(Exception $e){
			$message =[ 'message' =>$e->getMessage()];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
		}
    }
    public function resourceAddEdit_post(){

    	$input = file_get_contents("php://input");
		$data = json_decode($input);
		try{
		
			if(property_exists($data,'resource') && property_exists($data, 'type') && property_exists($data, 'rlabel'))	{
				$id = 0;
				if(property_exists($data, 'id')){
					$id = $data->id;
					$resourceObj = $this->_em->find('Entity\Permission',$id);
					if(!is_object($resourceObj)){
						$resourceObj = new Entity\Permission();
					}
				}else{
					$resourceObj = new Entity\Permission();
				}
				$resource 	= $data->resource;
				//$roles 		= $data->roles;
				$type 		= $data->type;
				$rlabel 		= $data->rlabel;

				$resourceObj->setResource($resource);
				//$resourceObj->setRoles($roles);
				$resourceObj->setLabel($rlabel);
				$resourceObj->setPtype($type);
				$this->_em->persist($resourceObj);

				$this->_em->flush();
				if($id){
					$message = ['message'=>'successfully updated resource'];
					$this->set_response($message, REST_Controller::HTTP_OK); 
				}else{
					$message = ['message'=>'successfully created resource'];	
					$this->set_response($message, REST_Controller::HTTP_CREATED); 
				}
			}else{
				$message =[ 'message' =>' payload mistaken... '];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
			}
		}catch(Exception $e){
			$message =[ 'message' =>$e->getMessage()];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
		}
    }

    public function updatePermissions_post(){

    	$input = file_get_contents("php://input");
		$data = json_decode($input);
		if(is_array($data)){

			try{
				if(is_array($data))	{
					
					foreach ($data as $key => $obj) {
						$id = $obj->rid;
						$resourceObj = $this->_em->find('Entity\Permission',$id);
						if(is_object($resourceObj)){
							$proles 	= $obj->proles;
							$roles  = array();
							foreach ($proles as $key => $v) {
								if($v->selected){
									$roles[] = $v->name;
								}
							}
							$resourceObj->setRoles(implode(',',$roles));

							$this->_em->persist($resourceObj);
						}
					}				
				
					$this->_em->flush();
					$message = ['message'=>'successfully updated resource'];
					$this->set_response($message, REST_Controller::HTTP_OK); 
				
				}else{
					$message =[ 'message' =>' payload mistaken... res '];
					$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
				}
			}catch(Exception $e){
				$message =[ 'message' =>$e->getMessage()];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
			}
		}else{
			$message =[ 'message' =>' payload mistaken... dat'];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
		}
    }

	public function resourceList_get(){
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$resourceObj = $qb->select('r')->from('Entity\Permission','r')->getQuery()->getResult();
		$resources = array();
		foreach ($resourceObj as $key => $obj) {
			$resource = array();
			$resource['id'] 	= $obj->getId();
			$resource['resource'] 	= $obj->getResource();
			$resource['label'] 	= $obj->getLabel();
			//$resource['roles'] 	= $obj->getRoles();
			$resource['status'] 	= $obj->getStatus();
			$resources['resources'][] = $resource;
		}

		$this->response($resources, REST_Controller::HTTP_OK); 
	}

	public function resourceStatus_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		if(is_object($data)){
			try{
				if(property_exists($data,'rid'))	{
				
					$rid = $data->rid;
					$resourceObj = $this->_em->find('Entity\Permission',$rid);
					
					$resourceObj->setStatus(!$resourceObj->getStatus());
				
					$this->_em->persist($resourceObj);

					$this->_em->flush();
				
					$message = ['message'=>$resourceObj->getLabel().' status successfully updated'];
					$this->set_response($message, REST_Controller::HTTP_OK); 
				}else{
					$message =[ 'message' =>' payload mistaken... '];
					$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
				}
			}catch(Exception $e){
				$message =[ 'message' =>$e->getMessage()];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
			}
		}else{
				$message =[ 'message' =>' payload mistaken... '];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
		}
	}

	public function singleResource_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		if(is_object($data)){
			try{
				if(property_exists($data,'rid'))	{
					$rid = $data->rid;
					$resourceObj = $this->_em->find('Entity\Permission',$rid);
					$resource = array();
					$resource['rid'] 		= $resourceObj->getId();
					$resource['resource'] 	= $resourceObj->getResource();
					$resource['rlabel']		= $resourceObj->getLabel();
					$resource['type']		= $resourceObj->getPtype();
				
					$this->set_response($resource, REST_Controller::HTTP_OK); 
				}else{
					$message =[ 'message' =>' payload mistaken... '];
					$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
				}
			}catch(Exception $e){
				$message =[ 'message' =>$e->getMessage()];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
			}
		}else{
				$message =[ 'message' =>' payload mistaken... '];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
		}
	}

	public function permissionsList_get(){
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$resourceObj = $qb->select('r')->from('Entity\Permission','r')->where('r.status=true')->getQuery()->getResult();
		$resources = array();

		$adminRoles = array('STORE_ADMIN','CALL_CENTER','CU_ADMIN');

		foreach ($resourceObj as $key => $obj) {
			$resource = array();
			$resource['rid'] 	= $obj->getId();
			$resource['label'] 	= $obj->getLabel();
			$roles = array();
			foreach($adminRoles as $ro){
				$r = array();
				$r['name'] = $ro;
				if(strpos($obj->getRoles(),$ro)===false){
					$flag = false;
				}else{
					$flag = true;
				}
				$r['selected'] =$flag; //==0?false:true;
				$roles[] = $r;
			}
			$resource['proles'] 	= $roles;
			$resources['resources'][] = $resource;
		}
		$this->response($resources, REST_Controller::HTTP_OK); 
	}

  //   public function resourceList_get(){

  //   $input = file_get_contents("php://input");
		// $data = json_decode($input);
		// try{
			
		// 		$resourceObj = $this->_em->getRepository('Entity\Permission')->findAll();

		// 		$resources =  array();
		// 		foreach ($resourceObj as $key => $obj) {
		// 				$resource = array();
		// 				$resource['resource'] = $obj->getResource();
		// 				$resource['resource'] = $obj->getResource();
		// 				$resource['resource'] = $obj->getResource();
		// 				$resources['resources'][] = $resource;
		// 			}	
				
		// 		$this->set_response($resources, REST_Controller::HTTP_OK); 
				
				
		// 	}else{
		// 		$message =[ 'message' =>' payload mistaken... '];
		// 		$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
		// 	}
		// }catch(Exception $e){
		// 	$message =[ 'message' =>$e->getMessage()];
		// 	$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
		// }
  //   }

 /*   public function permissionUpdate_post(){

    	$input = file_get_contents("php://input");
		$data = json_decode($input);
		try{
			
		
			if(property_exists($data,'resourceId') && property_exists($data, 'proles'))	{
				

				$resourceId 	= $data->resourceId;
				$resourceObj 	= $this->_em->find('Entity\Permission',$resourceId);
				
				$proles 			= $data->proles;
				$roles  = array();
				foreach ($proles as $key => $v) {
					if($v->selected){
						$roles[] = $v->name;
					}
				}
				$resourceObj->setRoles(implode(',',$roles));
				$this->_em->persist($resourceObj);

				$this->_em->flush();
				
				$message = ['message'=>'successfully updated resource'];
				$this->set_response($message, REST_Controller::HTTP_OK); 
				
				
			}else{
				$message =[ 'message' =>' payload mistaken... r '];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
			}
		}catch(Exception $e){
			$message =[ 'message' =>$e->getMessage()];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
		}
    }*/



	public function aanotifications_post(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		try{
			if(!is_object($data))
			$data = new stdClass();
			$facultyId =0;
			if(property_exists($data,'facultyId'))	{
				$this->_em = $this->doctrine->em;
				$facultyId = $data->facultyId;
				$faculty = $this->_em->find('Entity\Faculty',$facultyId);
				if(is_object($faculty)){
					$apartmentId = $faculty->getApartmentId()->getId();
					
					$qb = $this->_em->createQueryBuilder();
					$notifObj  = $qb->select('an')->from('Entity\ApartmentAdminNotification','an')->where('an.apt_id = :aptId and an.ntype !=:ntype')->setParameter('aptId',$apartmentId)->setParameter('ntype','bulk')->getQuery()->getResult();
					
					
					$notifications = array();
					foreach($notifObj as $nt){
						
						$nta = array();
						$nta['id'] = $nt->getId();
						$flats = array();
						foreach($nt->getFlatIds() as $f){
							$flat = array();
						//	$flat['flat_id'] = $f->getId();
							//$flat['flat']    = $f->getBlockId()->getName().'-'.$f->getName();
							$flats[] = $f->getBlockId()->getName().'-'.$f->getName();
						}
						$nta['to'] 			= implode(',',$flats);
						$nta['subject'] 	= $nt->getSubject();
						$nta['message'] 	= $nt->getMessage();
						$nta['priority'] 	= $nt->getPriority();
						$nta['ndate'] 		= is_object($nt->getNdate())?$nt->getNdate()->format('d-m-y'):'';
						$nta['nfile'] 		= $nt->getNfile();
						
						$notifications[] = $nta;
					}
					$this->set_response($notifications, REST_Controller::HTTP_OK); 
				}else{
					$message =[ 'message' =>' something went wrong... '];
					$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
				}
			}else{
				$message =[ 'message' =>' payload mistaken... '];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
			}
		}catch(Exception $e){
			$message =[ 'message' =>$e->getMessage()];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
		}
	}

    public function globalSearch_post(){
    	$input = file_get_contents('php://input');
		$data  = json_decode($input);
		if(is_object($data)){

			try{
				if(property_exists($data, 'searchInput')){
					$searchInput = $data->searchInput;	
					$areaId = 0;
					if(property_exists($data, 'areaId') && $data->areaId){
						$areaId = $data->areaId;
					}

					$results = array();

					$cqb = $this->_em->createQueryBuilder('cqb');
					if($areaId){
						$customerObj = $cqb->select('c')->from('Entity\Customer','c')->where('c.mobile=:mobile and c.area_id=:areaId')->setParameter('mobile',$searchInput)->setParameter('areaId',$areaId)->getQuery()->getResult();
					
					
					$customers = array();
					foreach ($customerObj as $key => $cobj) {
						$c = array();
						$c['customerId'] = $cobj->getId();
						$c['name'] = $cobj->getFirstName().' '.$cobj->getLastName();
						$c['mobile'] = $cobj->getMobile();
						$customers[] = $c;
					}

					$results['result']['customers'] =  $customers;

					$oqb = $this->_em->createQueryBuilder('oqb');
					$orderObj = $oqb->select('o')->from('Entity\PlaceOrderId','o')->where('(o.id =:receiptNo or o.order_id =:orderId) and o.store_id=:storeId')->setParameter('receiptNo',$searchInput)->setParameter('orderId',$searchInput)->setParameter('storeId',$areaId)->getQuery()->getResult();

					$orders = array();
					foreach ($orderObj as $key => $obj) {
						$o = array();
						$o['orderId'] 		= $obj->getOrderId();
						$o['oid'] 			= $obj->getId();
						$customerObj 		= $obj->getCustomerId();
						if(is_object($customerObj)){
						$o['customerId'] 	= $customerObj->getId();
						$o['customerName'] 	= $customerObj->getFirstName().' '.$customerObj->getLastName();
						$o['balanceAmount'] = $obj->getBalanceAmount();
						}
						$orders[] = $o;
					}

					$results['result']['orders'] =  $orders;
					$qb = $this->_em->createQueryBuilder();

					$orderItemsObj = $qb->select('po')->from('Entity\ProcessOrder','po')->where('(po.name like :itemName or po.barCodeLabel =:barCodeLabel or po.inBarCode =:inBarCode) and po.store_id=:storeId')->setParameter('itemName','%'.$searchInput.'%')->setParameter('inBarCode',$searchInput)->setParameter('barCodeLabel',$searchInput)->setParameter('storeId', $areaId)->getQuery()->getResult();
					$orderItems = array();
					foreach ($orderItemsObj as $key => $poObj) {
						$po = array();
						
						$po['name'] = $poObj->getName();
						$po['orderId'] = $poObj->getOrderId();

						$orderItems[] = $po;
					}

					$results['result']['orderItems'] =  $orderItems;

					}else{
					$customerObj = $cqb->select('c')->from('Entity\Customer','c')->where('c.mobile=:mobile')->setParameter('mobile',$searchInput)->getQuery()->getResult();
					
					$customers = array();
					foreach ($customerObj as $key => $cobj) {
						$c = array();
						$c['customerId'] = $cobj->getId();
						$c['name'] = $cobj->getFirstName().' '.$cobj->getLastName();
						$c['mobile'] = $cobj->getMobile();
						$customers[] = $c;
					}

					$results['result']['customers'] =  $customers;

					$oqb = $this->_em->createQueryBuilder('oqb');
					$orderObj = $oqb->select('o')->from('Entity\PlaceOrderId','o')->where('o.id =:receiptNo or o.order_id =:orderId')->setParameter('receiptNo',$searchInput)->setParameter('orderId',$searchInput)->getQuery()->getResult();

					$orders = array();
					foreach ($orderObj as $key => $obj) {
						$o = array();
						$o['orderId'] 		= $obj->getOrderId();
						$o['oid'] 			= $obj->getId();
						$customerObj 		= $obj->getCustomerId();
						if(is_object($customerObj)){
						$o['customerId'] 	= $customerObj->getId();
						$o['customerName'] 	= $customerObj->getFirstName().' '.$customerObj->getLastName();
						$o['balanceAmount'] = $obj->getBalanceAmount();
						$o['wallet'] = $customerObj->getWallet();
						}
						$orders[] = $o;
					}

					$results['result']['orders'] =  $orders;
					$qb = $this->_em->createQueryBuilder();

					$orderItemsObj = $qb->select('po')->from('Entity\ProcessOrder','po')->where('po.name like :itemName or po.barCodeLabel =:barCodeLabel or po.inBarCode =:inBarCode')->setParameter('itemName','%'.$searchInput.'%')->setParameter('inBarCode',$searchInput)->setParameter('barCodeLabel',$searchInput)->getQuery()->getResult();
					$orderItems = array();
					foreach ($orderItemsObj as $key => $poObj) {
						$po = array();
						
						$po['name'] = $poObj->getName();
						$po['orderId'] = $poObj->getOrderId();

						$orderItems[] = $po;
					}

					$results['result']['orderItems'] =  $orderItems;

					}
					$this->set_response($results,REST_Controller::HTTP_OK);	
				}else{
					$message = ['message'=>'payload mistke.'];
					$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);	
				}
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage()];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'payload mistake'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
    }
	
	public function authentication_post(){
		
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$mobile 		= $data->mobile;
		$password 	= md5(trim($data->password));
	    //$employees = $qb->select('e')->from('Entity\Employee','e')->where('e.mobile =:mobile and e.password =:pwd and e.status =:status')->setParameter('mobile',$mobile)->setParameter('pwd',$password)->setParameter('status',1)->getQuery()->getResult();
		
		$employee = $this->_em->getRepository('Entity\Employee')->findOneBy(array('mobile' =>$mobile,'password'=>$password,'status'=>1));
		$employeeArray = array();
		$myResource = array();
		
		if(is_object($employee)){
			$employeeArray['id'] 	= $employee->getId();
			$employeeArray['name'] 	= $employee->getName();
			$employeeArray['role'] 	= $role = $employee->getRoleId()->getName();
			$employeeArray['email'] = $employee->getEmail();
			$employeeArray['store'] = is_object($employee->getAreaId())?$employee->getAreaId()->getName():'CBS Admin';
			$employeeArray['areaId'] = is_object($employee->getAreaId())?$employee->getAreaId()->getId():0;

			
			$resourceObj = $qb->select('p')->from('Entity\Permission','p')->where('p.roles like :role and p.status=true')->setParameter('role','%'.$role.'%')->getQuery()->getResult();

				foreach ($resourceObj as $key => $obj) {
					$myResource[] = $obj->getResource();
				}

			$message =['message'=>'Authentication successfull' ,'employee'=>$employeeArray,'resource'=>$myResource];
			$this->response($message, REST_Controller::HTTP_ACCEPTED); 	
		}else{
			$message =[ 'message' => 'Authentication failed try again later'];
			$this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 
		}
	}

	public function preprocessorder_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		$placeOrderId =  $data->placeOrderId;
		$status=0;
		if(property_exists($data,'status'))
			$status =  $data->status;

		try{
			if($placeOrderId){
				$placeOrder = $this->_em->find('Entity\PlaceOrder',$placeOrderId);

				$processOrder = array();
				if(is_object($placeOrder)){

					$processOrder['poId'] 			= $placeOrder->getId();
					$processOrder['orderId'] 		= $orderId = $placeOrder->getOrderId();
					$itemObj 		= $placeOrder->getItemId();
					$itemName 		= str_replace(' ','-',strtolower($itemObj->getName()));

					$itemTypeCode 	= $itemObj->getItemTypeId()->getCode();

					$processOrder['itemId'] 		= $itemObj->getId();
					$serviceObj 	= $placeOrder->getServiceId();
					$serviceName	= $serviceObj->getName();
					$serviceCode 	= $serviceObj->getCode();
					$processOrder['serviceId'] 	= $serviceObj->getId();

					$customerObj   	= $placeOrder->getCustomerId();
					$customerId 	= $customerObj->getId();
					$customerName 	= $customerObj->getFirstName().' '.$customerObj->getLastName();

					$storeName 		= 'cbs';
					$storeCode 		= 'cbs';

					$deliveryDate   = 'd-m-Y';
					$placeOrderId = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('order_id'=>$orderId));
					$orderPk = $placeOrderId->getId();		
					

					$totalItems = $placeOrderId->getTotalItems();
					if(is_object($placeOrderId)){
						if(is_object($placeOrderId->getDeliveryDate())){
							$deliveryDate = $placeOrderId->getDeliveryDate()->format('d-m-Y');
						}						
					}

					if(is_object($storeObj = $customerObj->getApartmentId())){
						$storeName 		= $storeObj->getName();
						$storeCode 		= $storeObj->getCode();
					}elseif(is_object($storeObj = $customerObj->getAreaId())){
						$storeName 		= $storeObj->getName();
						$storeCode 		= $storeObj->getCode();							
					}else{
						 	
					}



					$processOrder['customerId'] 	= $customerObj->getId();
					$processOrder['icount'] 		= $placeOrder->getIcount();
					$processOrder['orderStatus']   	= $placeOrderId->getOrderStatus();
					$processOrder['deliveryDate']   	= $placeOrderId->getDeliveryDate()->format('d-m-Y');
					$processItems 	= array();
					$pac = array();
				
					if($status){

						foreach ($placeOrder->getProcessOrders() as $key => $value) {

							$processItem = array();
							$processItem['itemName'] 	= $value->getName();
							$processItem['brand'] 		= $value->getBrand();
							$processItem['color'] 		= $value->getColor();
							$processItem['barCodeLabel'] = $value->getBarCodeLabel();
							$processItem['inBarCode'] 	= $value->getInBarCode();
							$processItem['outBarCode'] 	= $value->getOutBarCode();
							
							$paddons = array();
							$raddons = array();
							foreach ($value->getAddons() as $k => $v) {
								$raddons[] = $v->getId();
								
							}
							foreach ($placeOrder->getPlaceOrderAddons() as $key => $value) {
								$addon = array();
								$addon['addonId'] 		= $addonId = $value->getAddonId()->getId();
								$addon['name']	= $aname = $value->getAddonId()->getName();
								$addon['code']	= $acode = $value->getAddonId()->getCode();

								if(in_array($addonId, $raddons)){
									$addon['selected'] = true;									
								}
								
								$ac['key'] = $aname;
								$ac['value'] = $value->getCount();
								if(!in_array($ac, $pac)){
									$pac[]	= $ac;	
								}
								
								$paddons[] = $addon;
							}
							
							$processItem['addons'] = $paddons;
							$processItems[] = $processItem;
						}
						$processOrder['processItems'] = $processItems;

					}else{
							for($i=1;$i<= $n =$placeOrder->getIcount(); $i++){
							$processItem = array();
							$processItem['itemName'] = $orderId.'-'.$serviceCode.'-'.$itemTypeCode.'-'.$itemName.'-'.$i.' of '.$n;

							
							$processItem['inBarCode'] = date('dmyhis').rand(101,999);
							
							$paddons = array();
							$addOns = array();
							foreach ($placeOrder->getPlaceOrderAddons() as $key => $value) {
								$addon = array();
								$addon['addonId'] 		= $value->getAddonId()->getId();
								$addon['name']	= $aname = $value->getAddonId()->getName();
								$addon['code']	= $acode = $value->getAddonId()->getCode();
								$akey = '';
								$ac = array();	
									
								$ac['key'] = $aname;
								$ac['value'] = $value->getCount();
								if(!in_array($ac, $pac)){
									$pac[]	= $ac;	
								}
								
								$paddons[] = $addon;
							}
							

							$processItem['barCodeLabel'] = $storeCode.', '.$customerName.', '.$orderPk.', '.$serviceCode.','.$itemTypeCode.', '.$itemName.', '.$i.' of '.$n.', '.$totalItems.','.$deliveryDate;
							

							$processItem['addons'] = $paddons;

							$processItem['totalItems'] = $totalItems;
							$processItems[] = $processItem;
						}
					}

					
					$processOrder['pacount'] = $pac;
					$processOrder['processItems'] = $processItems;

				
					$this->_em->persist($placeOrder);
					$this->_em->flush();

					$this->set_response($processOrder,REST_Controller::HTTP_OK);

				}else{
					$message = ['message'=>'payload mistaken...'];
					$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
				}

			}else{
				$message = ['message'=>'something went wrong please try again...'];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}catch(Exception $e){
			$message = ['message'=>$e->getMessage(),'status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function processorder_post(){
		$input = file_get_contents('php://input'); 
		$result = json_decode($input);
		
		try{
			if(is_object($result)){

				$itemId 	= $result->itemId;
				$serviceId 	= $result->serviceId;
				$customerId = $result->customerId;
				$orderId 	= $result->orderId;
				$placeOrderIdObj = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('order_id'=>$orderId));
				$placeOrderIdObj->setStatus(1);

				$status = 'PO';
				$this->load->library('cbs',$this->_em);
				$amessage = $this->cbs->_amessage;
				$smessage = $amessage[$status];


				$placeOrderIdObj->setOrderStatus($status);
				$placeOrderIdObj->setOrderStatusMessage($smessage);

				$this->_em->persist($placeOrderIdObj);

				$poId 		= $result->poId;

				$item 		= $this->_em->find('Entity\Item',$itemId);
				$service 	= $this->_em->find('Entity\Service',$serviceId);
				$cust 		= $this->_em->find('Entity\Customer',$customerId);
				$placeOrder = $this->_em->find('Entity\PlaceOrder',$poId);

				$placeOrder->setStatus(1);

				foreach($result->processItems as $data){
					$itemName 	= $data->itemName;

					$processOrder = $this->_em->getRepository('Entity\ProcessOrder')->findOneBy(array('name' => $itemName));
					if(!is_object($processOrder))
					$processOrder = new \Entity\ProcessOrder();
						

						$processOrder->setItemId($item);
						$processOrder->setServiceId($service);
						if(is_object($cust)){
							$processOrder->setCustomerId($cust);

							if(is_object($cust->getApartmentId())){}
							$processOrder->setStoreId($cust->getAreaId());
						}
						
						$processOrder->setOrderId($orderId);
						$processOrder->setPlaceOrderId($placeOrder);
						$processOrder->setItemStatus($status);
						$processOrder->setItemStatusMessage($smessage);

						$itemName 	= $data->itemName;
						$processOrder->setName($itemName);
						if(property_exists($data,'brand')){
							$brand 		= $data->brand; 
							$processOrder->setBrand($brand);
						}
						if(property_exists($data, 'color')){
							$color 		= $data->color; 
							$processOrder->setColor($color);
						}
						if(property_exists($data, 'barCodeLabel')){
							$barCodeLabel	= $data->barCodeLabel;
							$processOrder->setBarCodeLabel($barCodeLabel);
						}
						if(property_exists($data, 'inBarCode')){
							$inBarCode	= $data->inBarCode;
							$processOrder->setInBarCode($inBarCode);
						}
						if(property_exists($data, 'outBarCode')){
							$outBarCode	= $data->outBarCode;
							$processOrder->setOutBarCode($outBarCode);
			 			}
						foreach($data->addons as $ad){
							$addon = $this->_em->find('Entity\Addon',$ad->addonId);
							if(property_exists($ad,'selected') && $ad->selected){
								$processOrder->addAddon($addon);
							}elseif(property_exists($ad,'selected') && !$ad->selected){
								$processOrder->removeAddon($addon);
							}
							else{
							}
						 }
			
					$this->_em->persist($processOrder);
					$this->_em->flush();

					$message = ['message'=>'successfully processed your order.'];
					$this->set_response($message,REST_Controller::HTTP_OK);

				}		
			}else{
				$message = ['message'=>'something went wrong please try again...'];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}catch(Exception $e){
			$message = ['message'=>$e->getMessage(),'status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function processOrderDetails_post(){
		$input = file_get_contents('php://input');
		$data  = json_decode($input);
		try{
			if(property_exists($data, 'orderId')){
				$orderId = $data->orderId;	
				$placeOrderObj = $this->_em->getRepository('Entity\PlaceOrder')->findBy(array('order_id'=>$orderId));

				$processOrders = array();

				foreach ($placeOrderObj as $key => $value) {
					$processOrder = array();
					
						$service = array();
						$serviceObj 				= $value->getServiceId();
						$service['id'] 				= $serviceObj->getId();
						$service['name'] 			= $name = $serviceObj->getName();
						$processOrder['service']	= $service;

						$item = array();
						$itemObj = $value->getItemId();
						$item['id'] = $itemObj->getId();
						$item['name'] = $itemObj->getName();
						$processOrder['item'] = $item;


					$processItems  = array();
					foreach ($value->getProcessOrders() as $k => $v) {
						$processItem = array();
						$processItem['id'] 			= $v->getId();
						$processItem['service']		= $name;
						$processItem['name'] 		= $v->getName();
						$processItem['brand'] 		= $v->getBrand();
						$processItem['color'] 		= $v->getColor();
						$processItem['itemStatus'] 	= $v->getItemStatus();
						$processItem['itemStatusMessage'] 	= $v->getItemStatusMessage();
						$processItem['barCodeLabel'] 	= $v->getBarCodeLabel();
						$processItem['inBarCode'] 	= $v->getInBarCode();
						$processItem['outBarCode'] 	= $v->getOutBarCode();
						$addons = array();
						foreach ($v->getAddons() as $ak => $av) {
							$ad = array();
							$ad['id'] 	= $av->getId();
							$ad['name'] = $av->getName();
							$addons['addon'][] = $ad;
						}

						$processItem['addons'] 	= $addons;

						$processItems['items'][] = $processItem;
					}
					$processOrder['proceItems'] = $processItems;
					$processOrders[] = $processOrder;

				}

				$this->set_response($processOrders,REST_Controller::HTTP_OK);	
			}else{
				$message = ['message'=>'payload mistke.'];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);	
			}
		}catch(Exception $e){
			$message = ['message'=>$e->getMessage()];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function orderReceipt_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);

		if(property_exists($data, 'orderId')){
			$orderId = $data->orderId;

			if($orderId){
				try{
					$placeOrderObj = $this->_em->getRepository('Entity\PlaceOrder')->findBy(array('order_id'=>$orderId),array('service_id','asc'));
					$receipts = array();
					$services = array();
					$mainObj = '';
					foreach ($placeOrderObj as $key => $value) {
					
						$service = $value->getServiceId()->getName();


						$item = array();
						$item['name'] = $value->getItemId()->getName();
						$item['itemType'] = $value->getItemId()->getItemTypeId()->getName();
						$item['icount'] = $value->getIcount();
						$addons = array();
						$acost = 0;
						$atcost = 0;
						$c =0;
						foreach ($value->getPlaceOrderAddons() as $k => $v) {
							$addon = array();
							$addon['name']		= $v->getAddonId()->getName();
							$addon['acount'] 	= $c = $v->getCount();
							$acost = floatval($c*$v->getAddonId()->getPrice());
							$atcost +=$acost;
							$addon['cost']   	= number_format($acost,2);
							$addons[] = $addon;
						};

						$item['addons'] = $addons;
						$item['cost'] = number_format(floatval($value->getCost() - $atcost),2);

						$receipts['orderItems'][$service]['items'][] = $item;
			
					}

					$receipts['receipt']['orderId'] = $orderId;
					$mainOrderObj = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('order_id'=>$orderId));


					$receipts['receipt']['orderDate'] = is_object($mainOrderObj->getOrderDate())?$mainOrderObj->getOrderDate()->format('d-m-Y H:i a'):'';
					$receipts['receipt']['totalItems'] = $mainOrderObj->getTotalItems();
					
					$receipts['receipt']['deliveryDate'] = is_object($mainOrderObj->getDeliveryDate())?$mainOrderObj->getDeliveryDate()->format('d-m-Y'):'';

						$customerObj = $mainOrderObj->getCustomerId();
						$name = $customerObj->getFirstName().' '.$customerObj->getLastName();
						$mobile = $customerObj->getMobile();
						if(is_object($storeObj = $customerObj->getApartmentId())){
							$receipts['store']['address'] 	= $storeObj->getAddress();
							$receipts['store']['landmark'] 	= $storeObj->getLandmark();
							$receipts['store']['pincode'] 	= $storeObj->getPincode();
							$receipts['store']['mobile'] 	= $storeObj->getMobile();
							$receipts['store']['name'] 		= $storeObj->getName();
						}elseif(is_object($storeObj = $customerObj->getAreaId())){

							$receipts['store']['address'] 	= $storeObj->getAddress();
							$receipts['store']['landmark'] 	= $storeObj->getLandmark();
							$receipts['store']['pincode'] 	= $storeObj->getPincode();
							$receipts['store']['mobile'] 	= $storeObj->getMobile();
							$receipts['store']['name'] 		= $storeObj->getName();
						}else{
							 	
						}


						$receipts['receipt']['customerName'] = $name;
						$receipts['receipt']['mobile'] = $mobile;
						$addressObj = $mainOrderObj->getAddressId();
							$address = '';
							$landmark 	= '';
							$pincode 	= '';
						if(is_object($addressObj)){
							$address 	= $addressObj->getAddress();
							$landmark 	= $addressObj->getLandmark();
							$pincode 	= $addressObj->getPincode();
						}
					
					$receipts['receipt']['address'] 	= $address;
					$receipts['receipt']['landmark'] 	= $landmark;
					$receipts['receipt']['pincode'] 	= $pincode;

					$receipts['receipt']['receptId'] 	= $mainOrderObj->getId();
					$receipts['receipt']['subTotal'] 		= $mainOrderObj->getSubTotal();
					$receipts['receipt']['paidAmount'] 		= $mainOrderObj->getPaidAmount();
					$receipts['receipt']['balanceAmount'] 	= $mainOrderObj->getBalanceAmount();
					$receipts['receipt']['serviceCharge'] 	= $mainOrderObj->getServiceTax();

					$receipts['receipt']['adminDiscount'] 	= $mainOrderObj->getAdminDiscount();

					$receipts['receipt']['adminDiscountAmount'] = $mainOrderObj->getAdminDiscountAmount();
					$receipts['receipt']['qdAmount'] = $mainOrderObj->getQdAmount();
					$receipts['receipt']['totalAmount'] = $mainOrderObj->getTotalAmount();

					$receipts['receipt']['totalItems'] = $mainOrderObj->getTotalItems();


					$this->set_response($receipts, REST_Controller::HTTP_OK);
				}catch(Exception $e){
					$message = ['message'=>$e->getMessage()];
					$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
				}
			}else{
				$message = ['message'=>'something went wrong '];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}	
		}else{
			$message = ['message'=>'something went wrong '];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	
	public function trashTempOrders_post(){

		$input = file_get_contents('php://input');
		$data = json_decode($input);

		try{
			if(property_exists($data, 'customerId') && $data->customerId){
				$customerId = $data->customerId;
				$this->_em = $this->doctrine->em;
				$qb = $this->_em->createQueryBuilder();

				$tempOrders = $qb->select('t')->from('Entity\TempOrder','t')->where('t.cust_id=:customerId')->setParameter('customerId',$customerId)->getQuery()->getResult();

				foreach ($tempOrders as $key => $to) {
					foreach ($to->getTempOrderAddons() as $key => $value) {
						$this->_em->remove($value);
					}
					$this->_em->remove($to);
				}
				$this->_em->flush();
				$message = ['customerId'=>$customerId];
				$this->set_response($message,REST_Controller::HTTP_OK);
			}else{
				$message = ['message'=>'payload mistke'];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}catch(Exception $e){
			$this->set_response($e->getMessage(),REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function readyForDeliver_post(){
		$input = file_get_contents('php://input');
		$data  = json_decode($input);

		if(property_exists($data,'processId') && $data->processId && property_exists($data,'outBarCode') && $data->outBarCode){
			$processId = $data->processId;
			$outBarCode = $data->outBarCode;

			$processObj = $this->_em->find('Entity\ProcessOrder',$processId);
			$processObj->setOutBarCode($outBarCode);
			
			$orderId = $processObj->getOrderId();
			$this->load->library('cbs',$this->_em);
			$this->cbs->changeDeliveryStatus($orderId,'ORD');

			if($processObj->getInBarCode()==$outBarCode){
				$this->_em->persist($processObj);
				$this->_em->flush();

				$message = ['message'=>'out bar code successfully matched with in bar code, Item is ready to deliver.'];
				$this->set_response($message,REST_Controller::HTTP_OK);

			}else{
				$message = ['message'=>'out bar code does not matched with in bar code, Please try again right.'];
				$this->set_response($message,REST_Controller::HTTP_NOT_ACCEPTABLE);
			}
		}else{
			$message = ['message'=>'payloads mistake '];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}

	}

	public function changeOrderStatus_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);

		if(is_object($data) && property_exists($data, 'orderId')){
			$orderId = $data->orderId;

			if($orderId){
				try{
					
					$status = ''; 
					if(property_exists($data,'status')){
						$status = $data->status;

						$this->load->library('cbs',$this->_em);
						$this->cbs->changeOrderStatus($orderId,$status);
						
						$message = ['message'=>'successfully updated status'];
						$this->set_response($message, REST_Controller::HTTP_OK);

					}
					
				}catch(Exception $e){
					$message = ['message'=>$e->getMessage()];
					$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
				}
			}else{
				$message = ['message'=>'something went wrong '];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}	
		}else{
			$message = ['message'=>'something went wrong '];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function holdGarment_post(){

		$input = file_get_contents('php://input');
		$data  = json_decode($input);

		$qb = $this->_em->createQueryBuilder();

		if(is_object($data) && property_exists($data,'inBarCode') && $data->inBarCode){
			$inBarCode = $data->inBarCode;
			
			try{
				$processObj = $this->_em->getRepository('Entity\ProcessOrder')->findOneBy(array('inBarCode'=>$inBarCode));
				if(is_object($processObj)){
				
					$status = '';$secondStatus='';$message=''; $secondMessage='';
					
					if(property_exists($data, 'status'))
						$status = $data->status;
					
					if(property_exists($data, 'secondStatus')){
						$secondStatus = $data->secondStatus;
						
					}

					if(property_exists($data, 'message')){
						$message = $data->message;
					}
					if(property_exists($data, 'secondMessage')){
						$secondMessage = $data->secondMessage;
					}



				$processObj->setItemStatus($status);
				$processObj->setItemStatusMessage($rmessage);

				


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

	public function holdGarments_post(){
		$input = file_get_contents('php://input');
		$data  = json_decode($input);

		if(is_object($data) && property_exists($data,'storeId') && $data->storeId){
			$storeId = $data->storeId;
			$storeObj = $this->_em->find('Entity\Area',$storeId);
			$storeCode = 'xxxx';
			if(is_object($storeObj)){
				$storeCode = $storeObj->getCode();
			}
				log_message('error',$storeCode);
				
			try{

				$qb = $this->_em->createQueryBuilder();

				$processObj = $qb->select('po')->from('Entity\ProcessOrder','po')->where('po.	store_id =:storeId and  po.itemStatus =:itemStatus and (po.returnGarmentStatus=\'HG-SA\' or po.returnGarmentStatus=\'HG-CUD\' or po.returnGarmentStatus=\'HG-CUO\' or po.returnGarmentStatus=\'HG-CUP\' or po.returnGarmentStatus=\'HG-CUF\' or po.returnGarmentStatus=\'HG-SPA\' or po.returnGarmentStatus=\'HG-D\' )')->setParameter('storeId',$storeId)->setParameter('itemStatus','hold')->orderBy('po.itemStatus','asc')->getQuery()->getResult();

				$results['garments'] = array();
				foreach ($processObj as $key => $obj) {

					$orderId = $obj->getOrderId();
					$placeOrderId = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('order_id'=>$orderId));
					$receiptNo = $placeOrderId->getId();

					$item = array();
					$item['id'] 		= $key+1;
					$item['receiptNo'] 	= $receiptNo;
					$item['name'] 		= $obj->getName();
					$item['inBarCode'] 	= $obj->getInBarCode();
					$item['service'] 	= $obj->getServiceId()->getName();
					$item['brand'] 		= $obj->getBrand();
					$item['color'] 		= $obj->getColor();
					$item['message'] 	= $obj->getItemStatusMessage();

					$item['secondStatus'] 	= $obj->getReturnGarmentStatus();
					$item['secondMessage'] 	= $obj->getReturnGarmentStatusMessage();

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
				$message = ['message'=>'pay load mistaken..'];
				$this->set_response($message,REST_Controller::HTTP_NOT_ACCEPTABLE);
			}
	}

	public function returnGarment_post(){

		$input = file_get_contents('php://input');
		$data  = json_decode($input);

		$qb = $this->_em->createQueryBuilder();

		if(is_object($data) && property_exists($data,'inBarCode') && $data->inBarCode &&  property_exists($data,'message')){
			$inBarCode = $data->inBarCode;
			$status = $data->status;
			$message = $data->message;
			$secondStatus = '';

			try{
				$processObj = $this->_em->getRepository('Entity\ProcessOrder')->findOneBy(array('inBarCode'=>$inBarCode));
				if(is_object($processObj)){
				
				if(property_exists($data, 'secondStatus')){
					$secondStatus = $data->secondStatus;
					$processObj->setReturnGarmentStatus($secondStatus);
				}

				$orderId 		= $processObj->getPlaceOrderId()->getOrderId();

				
				
				$this->load->library('cbs',$this->_em);
				
				$customerObj = $processObj->getCustomerId();
				/* if(is_object($customerObj->getAreaId())){
					$areaObj = $customerObj->getAreaId();
					if(is_object($areaObj)){
						$catalogObj = $areaObj->getCatalogId();
						if(is_object($catalogObj)){
							$catalogId = $catalogObj->getId();		
						}else{
							$catalogId = 1;
						}
					}else{
						$catalogId = 1;
					}
				}else{
					$catalogId = 1;
				}

				 
				$itemId 		= $processObj->getItemId()->getId();
				$serviceId 		= $processObj->getServiceId()->getId();

				$itemCost 		= $this->cbs->getItemNetCost($catalogId, $serviceId, $itemId);

				$addons 		= $processObj->getAddons();
				$addonsCost 	= $this->cbs->getAddonsCost($addons);
				$totalCost 		= $itemCost + $addonsCost; // item total cost
				
				$totalCost		= number_format((float) $totalCost,2,',','');
				$reFundAmt 		=  $this->cbs->getReFundAmount($totalCost,$orderId); // total cost, order_id 
				log_message('error',$reFundAmt);*/
				$placeOrderObj = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('order_id'=>$orderId));

				if($status=='returned' && $processObj->getItemStatus()!='returned' ){

					$reFundAmt = $this->cbs->lostPlaceOrderItemIn($inBarCode,$status);

					$processObj->setItemStatus($status);
					$processObj->setItemStatusMessage($message);
					
					if(is_object($placeOrderObj)){
						
						$placeOrderObj->addReFundAmount($reFundAmt);
						
						$closingBalance = $placeOrderObj->getClosingBalance();
						$closingBalance = $closingBalance - $reFundAmt; 
						//$placeOrderObj->getReFundAmount();
						$placeOrderObj->setClosingBalance($closingBalance);

						$balanceAmount  = $placeOrderObj->getBalanceAmount();
						$presentAmount = $balanceAmount - $reFundAmt;
						
						if($presentAmount>=0){
							$placeOrderObj->setBalanceAmount($presentAmount);
						}else{
							$placeOrderObj->setBalanceAmount(0);
							$customerObj->addWallet(-($presentAmount));
						}
					
					}
					//$ts->setCustomerId($customerObj);
					//$this->_em->persist($ts);
				}
								
					$this->_em->persist($placeOrderObj);


					$item = $processObj->getBarCodeLabel();
				    
					$this->_em->persist($processObj);
					$this->_em->flush();

					$this->load->library('Sms', $this->_em);
					$this->sms->returnGarmentSms($processObj);
					$message = ['message'=>'you successfully returned '.$item.' for '.$message];
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

	public function returnGarmentDelete_post(){

		$input = file_get_contents('php://input');
		$data  = json_decode($input);

		$qb = $this->_em->createQueryBuilder();

		if(is_object($data) && property_exists($data,'inBarCode') && $data->inBarCode){
			$inBarCode = $data->inBarCode;
			

			try{
				$processObj = $this->_em->getRepository('Entity\ProcessOrder')->findOneBy(array('inBarCode'=>$inBarCode));
				
				if(is_object($processObj)){
					
				
				$orderId 		= $processObj->getPlaceOrderId()->getOrderId();

				$placeOrderObj = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('order_id'=>$orderId));

				$orderStatus =  $placeOrderObj->getOrderStatus();
				if($orderStatus == 'delivered'){
					$message = ['message'=>'order already delivered ,now you can\'t delete it.'];
					$this->set_response($message,REST_Controller::HTTP_NOT_ACCEPTABLE);
				}


				$processObj->setReturnGarmentStatus($orderStatus);


				$catalogId = 1; 
				
				$this->load->library('cbs',$this->_em);
				$customerObj = $processObj->getCustomerId();
					
				//$itemId 		= $processObj->getItemId()->getId();
				//$serviceId 		= $processObj->getServiceId()->getId();

				//$itemCost 		= $this->cbs->getItemNetCost($catalogId, $serviceId, $itemId);
				//log_message('error',$itemCost);
				//$addons 		= $processObj->getAddons();
				//$addonsCost 	= $this->cbs->getAddonsCost($addons);
				//log_message('error',$addonsCost);
				//$totalCost 		= $itemCost + $addonsCost; // item total cost
			//	log_message('error',$addonsCost);
			//	$totalCost		= number_format((float) $totalCost,2,',','');
			//	log_message('error',$totalCost);
			//	$reFundAmt 		=  $this->cbs->getReFundAmount($totalCost,$orderId); // total cost, order_id 
			//	log_message('error',$reFundAmt);
				


					if($processObj->getItemStatus()=='returned'){
						$reFundAmt = $this->cbs->findPlaceOrderItemIn($inBarCode,'returned');
					
						$processObj->setItemStatus($orderStatus);
						$processObj->setItemStatusMessage($orderStatus);

						if(is_object($placeOrderObj)){

							$placeOrderObj->addReFundAmount(-$reFundAmt);
							$wallet = $customerObj->getWallet();
							log_message('error','wallet:'.$wallet);
							
							$balanceAmount = $placeOrderObj->getBalanceAmount(); 
							$closingBalance = $placeOrderObj->getClosingBalance();

							log_message('error','balanceAmount:'.$balanceAmount);
							$placeOrderObj->setClosingBalance($closingBalance+$reFundAmt);

							$closingBalance = $placeOrderObj->getClosingBalance();

							log_message('error','closingBalance:'.$closingBalance);

							if($balanceAmount==0){
								$netWallet = $wallet - $reFundAmt; 
								if($netWallet<=0){
									$placeOrderObj->setBalanceAmount(-$netWallet);
							//		$placeOrderObj->setPaidAmount($placeOrderObj->getPaidAmount()+$wallet);
									$customerObj->setWallet(0);
								}else{

									//$placeOrderObj->setPaidAmount($placeOrderObj->getPaidAmount()+$reFundAmt);

									$paidAmount = $placeOrderObj->getPaidAmount();
									log_message('error','paidAmount:'.$paidAmount);

									$usedAmount = ($paidAmount + $reFundAmt) - $closingBalance ;
									log_message('error','usedAmount:'.$usedAmount);

									$wallet = $wallet - $usedAmount;
									log_message('error','wallet:'.$wallet);

									$reFundAmt = $reFundAmt - $usedAmount;
									log_message('error','paidAmount:'.$paidAmount);
									log_message('error','reFundAmt:'.$reFundAmt);

									$paidAmount = $paidAmount + $reFundAmt;
									log_message('error',$paidAmount);

									$placeOrderObj->setBalanceAmount(0);
									$placeOrderObj->setPaidAmount($paidAmount);
									$customerObj->setWallet($netWallet);
								
								}
							}else if($balanceAmount>0){
								$placeOrderObj->setBalanceAmount($placeOrderObj->getBalanceAmount()+$reFundAmt);
							}
						}

					}

					$this->_em->persist($placeOrderObj);
					$item = $processObj->getBarCodeLabel();
				    
					$this->_em->persist($processObj);
					$this->_em->flush();

					$message = ['message'=>'you successfully returned '.$item.'deleted'];
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

	public function returnGarments_post(){
		$input = file_get_contents('php://input');
		$data  = json_decode($input);

		if(is_object($data) && property_exists($data,'storeId') && $data->storeId){
			$storeId = $data->storeId;
			$storeObj = $this->_em->find('Entity\Area',$storeId);
			$storeCode = 'xxxx';
			if(is_object($storeObj)){
				$storeCode = $storeObj->getCode();
			}

			try{

				$qb = $this->_em->createQueryBuilder();

				$processObj = $qb->select('po')->from('Entity\ProcessOrder','po')->where('po.name like :storeCode and ( po.itemStatus =:itemStatus or po.returnGarmentStatus =:itemStatus or po.itemStatus =:nitemStatus or po.returnGarmentStatus =:nitemStatus)')->setParameter('storeCode','%'.$storeCode.'%')->setParameter('itemStatus','returned')->setParameter('nitemStatus','return')->orderBy('po.itemStatus','asc')->getQuery()->getResult();

				$results = array();
				foreach ($processObj as $key => $obj) {

					$orderId = $obj->getOrderId();
					$placeOrderId = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('order_id'=>$orderId));
					$receiptNo = $placeOrderId->getId();

					$item = array();
					$item['id'] = $key+1;
					$item['receiptNo'] 		= $receiptNo;
					$item['name'] 			= $obj->getName();
				$item['date']		= (int)strtotime($obj->getUpdatedAt()->format('Y-m-d H:i:s'))*1000;
					$item['inBarCode'] 		= $obj->getInBarCode();
					$item['itemStatus'] 	= $obj->getItemStatus();
					$item['message'] 		= $obj->getItemStatusMessage();
					$item['secondStatus'] 	= $obj->getReturnGarmentStatus();
					$item['secondStatusMessage'] = $obj->getReturnGarmentStatusMessage();
	
					$customerObj 			= $obj->getCustomerId();
					$item['customerName'] 	= $customerObj->getFirstName().' '.$customerObj->getLastName();
					$item['customerMobile'] = $customerObj->getMobile();
					$results['garments'][] 	= $item;

					
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

	public function deliveryOrderStatus_post(){
		$input 	= file_get_contents('php://input');
		$data 	= json_decode($input);
		if(is_object($data) && property_exists($data, 'orderId') && property_exists($data, 'status')){

			$orderId = $data->orderId;  
			$status = $data->status;

			try{
				$cudObj = $this->_em->find('Entity\CUDOrder',$orderId);
				if(is_object($cudObj)){
					$cudObj->setStatus($status);
					$this->_em->persist($cudObj);
					$this->_em->flush();
					$message = ['message'=>'order status successfully changed to .'.$status];
					$this->set_response($message,REST_Controller::HTTP_OK);
				}else{
					$message = ['message'=>'inputs are not accepted .'];
					$this->set_response($message,REST_Controller::HTTP_NOT_ACCEPTABLE);
				}
			}catch(Exception $e){
					$message = ['message'=>$e->getMessage()];
					$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
			 
		}else{
			$message = ['message'=>'something went wrong.'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
			
	}

	public function deliverySingleOrderStatus_post(){
		$input 	= file_get_contents('php://input');
		$data 	= json_decode($input);
		if(is_object($data) && property_exists($data, 'orderId')){

			$orderId = $data->orderId;  $status = $data->status;
			try{

				$this->load->library('cbs',$this->_em);
				$this->cbs->changeOrderStatus($orderId, $status);	
				$message = ['message'=>'Order status successfully changed to.'.$status];
				$this->set_response($message,REST_Controller::HTTP_OK);

			}catch(Exception $e){
					$message = ['message'=>$e->getMessage()];
					$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
			 
		}else{
			$message = ['message'=>'something went wrong.'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
			
	}

	// this for order details function 
	public function orderReturnGarments_post(){
		$input = file_get_contents('php://input');
		$data  = json_decode($input);

		if(is_object($data) && property_exists($data,'orderId') && $data->orderId){
			$orderId = $data->orderId;
			

			try{

				$qb = $this->_em->createQueryBuilder();

				$processObj = $qb->select('po')->from('Entity\ProcessOrder','po')->where('po.order_id =:orderId and po.itemStatus =:itemStatus')->setParameter('orderId',$orderId)->setParameter('itemStatus','returned')->getQuery()->getResult();
				$results = array();
				foreach ($processObj as $key => $obj) {
					$item = array();
					$item['id'] = $key+1;
					$item['name'] = $obj->getName();
									
					$item['message'] = $obj->getItemStatusMessage();
					$customerObj = $obj->getCustomerId();
					
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

	public function customerOrders_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			$customerId =0;
			if(property_exists($data, 'customerId')){
				$customerId = $data->customerId;
			}
			try{
				if($customerId){
					$customer = $this->_em->find('Entity\Customer',$customerId);
					if(is_object($customer)){
						$placeOrders = $customer->getPlaceOrderIds();
						$orders = array();
						$count = count($placeOrders);
						$totalAmount = 0;
						$paidAmount = 0;
						$balanceAmount = 0;
						$adminDiscountAmount = 0;
						foreach ($placeOrders as $key => $obj) {
							if(!$obj->getIsDelete()){
								$order = array();
								$order['id']  					= $obj->getId();
								$order['orderId'] 				= $obj->getOrderId();
								$order['totalAmount'] 			= $obj->getTotalAmount();
								$totalAmount = $totalAmount + $obj->getTotalAmount() + $obj->getAdminDiscountAmount();
								$order['paidAmount'] 			= $obj->getPaidAmount();
								$paidAmount = $paidAmount + $obj->getPaidAmount();
								$order['balanceAmount'] 		= $obj->getBalanceAmount();
								$balanceAmount = $balanceAmount + $obj->getBalanceAmount();
								$order['adminDiscount'] 		= $obj->getAdminDiscount();
								$order['adminDiscountAmount'] 	= $obj->getAdminDiscountAmount();
								$adminDiscountAmount = $adminDiscountAmount + $obj->getAdminDiscountAmount();

								$order['orderDate'] 	= strtotime($obj->getOrderDate()->format('y-m-d H:i:s'))*1000;
								$orders['orders'][] = $order;
							}
						}

						$orders['details']['name'] 				= $customer->getFirstName().' '.$customer->getLastName();
						$orders['details']['email'] 			= $customer->getEmail();
						$orders['details']['mobile'] 			= $customer->getPhoneNo();
						$orders['details']['wallet'] 			= $customer->getWallet();
						
						$orders['details']['totalOrders'] 			= $count;
						$orders['details']['totalAmount'] 			= $totalAmount;
						$orders['details']['paidAmount'] 			= $paidAmount;
						$orders['details']['balanceAmount'] 		= $balanceAmount;
						$orders['details']['adminDiscountAmount'] 	= $adminDiscountAmount;

						$this->set_response($orders,REST_Controller::HTTP_OK);	
					}else{
						$message = ['message'=>'something we wrong.'];
						$this->set_response($message,REST_Controller::HTTP_UNAUTHORIZED);	
					}
				}else{
					$message = ['message'=>'something we wrong.'];
					$this->set_response($message,REST_Controller::HTTP_UNAUTHORIZED);
				}

			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something we wrong.'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function customerAddRequest_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			try{
				$cr = new Entity\CustomerRequest();
				$mobile = 0;
				if(property_exists($data, 'mobile')){
					$mobile = $data->mobile;
				}
				$customerObj = $this->_em->getRepository('Entity\Customer')->findOneBy(array('mobile'=>$mobile));

				if(is_object($customerObj)){
					$cr->setCustomerId($customerObj);
					$os_player_id = $customerObj->getOsPlayerId();
					$this->load->library('cbs','');
					$this->load->library('Sms',$this->_em);

					$heading = 'Order Request';
					$name = $customerObj->getFirstName().' '.$customerObj->getLastName();
					$message = 'Dear '.$name.', Your Order request has been successfully placed, our pickup boy will reach you soon. Thank you';
					$this->cbs->sendNotification($os_player_id,$heading,$message);

				}
					

				$areaId = 0;
				if(property_exists($data, 'areaId')){
					$areaId = $data->areaId;
					$areaId = $this->_em->find('Entity\Area',$areaId);
					$cr->setAreaId($areaId);
				}
				if(property_exists($data, 'area')){
					$areaId = $data->area;
					$areaId = $this->_em->find('Entity\Area',$areaId);
					$cr->setAreaId($areaId);
				}

				if(property_exists($data, 'slot')){
					$slot = trim($data->slot); 
					$cr->setSlot($slot);
				}

				$cr->setStatus('CRR');

				if(property_exists($data, 'requestDateTime')){
					$requestDateTime = trim($data->requestDateTime); 
					if($requestDateTime!='')
						$cr->setDate(date('Y-m-d', strtotime($requestDateTime)));
					else
						$cr->setDate(date('Y-m-d'));	
				}else{
					$cr->setDate(date('Y-m-d'));
				}
				
				$cr->setMobile($mobile);
				
			//	if(is_object($areaId))
					
				$this->_em->persist($cr);
				$this->_em->flush();
				
				$this->sms->customerRequestSMS($cr);

				$message = ['message'=>'successfully created customer request'];
				$this->set_response($message,REST_Controller::HTTP_OK);

			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something we wrong.'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}	
	}

	public function customerRequestAssign_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			try{
				if(property_exists($data,'pickupBoyId') && property_exists($data, 'crId')){
					$crId = $data->crId;
					$crObj = $this->_em->find('Entity\CustomerRequest',$crId);
					if(is_object($crObj)){
						$pickupBoyId = $data->pickupBoyId;
						$pickupBoy = $this->_em->find('Entity\pickupBoy',$pickupBoyId);
						if(is_object($pickupBoy)){
							$crObj->setPickupBoyId($pickupBoy);
							$name = $pickupBoy->getName();
							$crObj->setStatus('CRAPB');
							$this->_em->persist($crObj);
							$this->_em->flush();

							$this->load->library('Sms', $this->_em);
							$this->sms->customerRequestPickupBoyAssign($crObj);
							$message = ['message'=>'successfully assigned to '.$name];
							$this->set_response($message,REST_Controller::HTTP_OK);	
						}else{

						}

					}else{
						$message = ['message'=>'we not recognized your request'];
						$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);	
					}

				}else{
					$message = ['message'=>'something went wrong.'];
					$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
				}
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something went wrong.'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function customerRequestAssignStore_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			try{
				if(property_exists($data,'storeId') && property_exists($data, 'requests')){
					$storeId = $data->storeId;
					
					$requests = $data->requests; 
					$storeObj = $this->_em->find('Entity\Area',$storeId);
					$storeName = '';
					foreach ($requests as $key => $crId) {
						log_message('error',$crId);
						$crObj = $this->_em->find('Entity\CustomerRequest',$crId);
						if(is_object($crObj)){
							log_message('error','request obj');
							if(is_object($storeObj)){
								log_message('error','store obj');
								$storeName = $storeObj->getName();
								$crObj->setStoreId($storeObj);
								$crObj->setStatus('CRSS');
								$this->_em->persist($crObj);
								$this->_em->flush();
							}
						}
					}

					$message = ['message'=>'successfully assigned to '.$storeName];
					$this->set_response($message,REST_Controller::HTTP_OK);	
					
				}else{
					$message = ['message'=>'something went wrong.'];
					$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
				}
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something went wrong.'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function customerRequests_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			try{
				$qb = $this->_em->createQueryBuilder();
				if(property_exists($data,'areaId') && !empty($data->areaId)){
					$areaId = $data->areaId;
					$crObj = $qb->select('cr')->from('Entity\CustomerRequest','cr')->where('cr.area_id=:areaId')->setParameter('areaId',$areaId)->orderBy('cr.created_at','desc')->getQuery()->getResult();
				}
				else{
					// $message = ['message'=>'something went wrong.'];
					// $this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
					$crObj = $qb->select('cr')->from('Entity\CustomerRequest','cr')->orderBy('cr.created_at','desc')->getQuery()->getResult();
					
				}
				$crs = array();

				foreach ($crObj as $key => $obj) {
					$cr = array();
					$cr['crId'] 	= $obj->getId();
					$cr['mobile'] 	= $obj->getMobile();
					$cr['slot'] 	= $obj->getSlot();
					$cr['requestDateTime'] 	= is_object($obj->getDate())?strtotime($obj->getDate()->format('Y-m-d H:i'))*1000:'';

					$customer 		= $obj->getCustomerId();
					if(is_object($customer)){
						$name = $customer->getFirstName().' '.$customer->getLastName();
						$caddress = $customer->getLastAddress();
						$cr['name']  = $name;
						$cr['areaCode']  = $customer->getAreaId()->getCode(); 
						if(is_object($caddress)){  
							$cr['address']  = $caddress->getAddress();
							$cr['landmark']  = $caddress->getLandmark();
						}else{
							$cr['address']  = '';
							$cr['landmark']  = '';
						}
						
					}else{
						$cr['name']	 		= '';
						$cr['address']  	= '';
						$cr['landmark']  	= '';
					}

					$pbObj 		= $obj->getPickupBoyId();
					if(is_object($pbObj)){
						$pbName = $pbObj->getName();
						$cr['pbName']  = $pbName;
					}else{
						$cr['pbName']	 = '';
					}

					$cr['status']  = $obj->getStatus();

					$crs['customers'][] = $cr;
				}
				$this->set_response($crs,REST_Controller::HTTP_OK);
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something went wrong.'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function storePickupBoys_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			try{
				if(property_exists($data,'areaId')){
					$areaId = $data->areaId;
					$qb = $this->_em->createQueryBuilder();
					$pbObj = $qb->select('p')->from('Entity\PickupBoy','p')->where('p.area_id=:areaId')->setParameter('areaId',$areaId)->getQuery()->getResult();
					$pbs = array();
					foreach ($pbObj as $key => $obj) {
						$pb = array();
						$pb['pbId'] 	= $obj->getId();
						$pb['name'] 	= $obj->getName();
						 
						$pbs['pickupBoys'][] = $pb;
					}
					$this->set_response($pbs,REST_Controller::HTTP_OK);
				}else{
					$message = ['message'=>'something we wrong.'];
					$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
				}
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something we wrong.'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function pickupBoyOrderRequest_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			try{
				$this->load->library('Sms', $this->_em);
				if((property_exists($data,'deliveryBoyId') || property_exists($data,'pickupBoyId')) && property_exists($data, 'orderId')){
					$orderId = $data->orderId;
					$orderObj = $this->_em->find('Entity\PlaceOrderId',$orderId);
					if(is_object($orderObj)){
						$flag = '';
						if(property_exists($data,'deliveryBoyId') && $data->deliveryBoyId){
							$flag = 'd';
							$pickupBoyId = $data->deliveryBoyId;
							
						}else if(property_exists($data,'pickupBoyId') && $data->pickupBoyId){
							$flag = 'p';
							$pickupBoyId = $data->pickupBoyId;
							
						}
							
						
						$pickupBoy = $this->_em->find('Entity\PickupBoy',$pickupBoyId);
						
						if(is_object($pickupBoy)){
							if($flag=='p'){
								$orderObj->setPickupBoyId($pickupBoy);
								$orderObj->setPickupBoyStatus('assigned');	
							}else if($flag=='d'){
								$this->load->library('cbs',$this->_em);
								$orderId = $orderObj->getOrderId();
								$this->cbs->changeOrderStatus($orderId,'DOA');
								$orderObj->setDeliveryBoyId($pickupBoy);
								$orderObj->setPickupBoyStatus('assigned');	
							}			
							

							$name = $pickupBoy->getName();
							$this->_em->persist($orderObj);
							$this->_em->flush();
							if($flag=='p'){
								$this->sms->placeOrderPickupBoyAssign($orderObj);
							}else{
								//$this->sms->placeOrderDeliveryBoyAssign($orderObj);	
							}
							$message = ['message'=>'successfully assigned to '.$name];
							$this->set_response($message,REST_Controller::HTTP_OK);	
						}else{
							$message = ['message'=>'we not recognized your request1'];
							$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);	
						}

					}else{
						$message = ['message'=>'we not recognized your request2'];
						$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);	
					}
				}else{
					$message = ['message'=>'something went wrong.'];
					$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
				}
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something went wrong.'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function pickupboyAssignCustomerPackage_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			try{

				//print_r($data);

				$customerId = $data->customerId;
				$agentId = $data->agentId;
				$customerObj = $this->_em->find('Entity\Customer',$customerId);
				$agentObj = $this->_em->find('Entity\PickupBoy',$agentId);

				$customerObj->setAgentId($agentObj);

				$this->_em->persist($customerObj);
				$this->_em->flush();
			}catch(Exception $e){

			}
		}
	}
	public function walletZero_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			try{
				if(property_exists($data,'customerId')){
					$customerId = $data->customerId;
					$customerId = $this->_em->find('Entity\Customer',$customerId);
					if(is_object($customerId)){
						$name = $customerId->getFirstName().' '.$customerId->getLastName();
						
						$th = new Entity\TransactionHistory();
						$th->setPaidAmount(-$customerId->getWallet());
						$th->setUsedAmount('wallet amount converted to Zero');
						$customerId->addTransaction($th);
						if($customerId->getWallet()>0){
							$customerId->setWallet(0);
							$this->_em->persist($customerId);
							$this->_em->flush();
							$message = ['message'=>$name.' wallet amount successfully converted to zero'];
							$this->set_response($message,REST_Controller::HTTP_OK);		
						}else{
							
							$message = ['message'=>$name.' wallet is in nagitive balance'];
							$this->set_response($message,REST_Controller::HTTP_OK);	
						}
						
					}else{
						$message = ['message'=>'we not recognized your request'];
						$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);	
					}

				}else{
					$message = ['message'=>'something went wrong.'];
					$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
				}
			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something went wrong.'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
}