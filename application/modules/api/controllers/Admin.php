<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Admin extends REST_Controller {
   
   function __construct()
   {
    
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

			$q = "select count(p) as totalOrders, sum(p.totalAmount) as totalAmount, sum(p.paidAmount) as paidAmount, sum(p.balanceAmount) as balanceAmount, sum(p.adminDiscountAmount) as adminDiscountAmount,Entity\CustomerAddress from Entity\PlaceOrderId p join Entity\CustomerAddress with p.address_id group by  totalAmount";
			$qb = $this->_em->createQuery($q);

			//$orderObj = $qb->select('count(p) as totalOrders','sum(p.totalAmount) as totalAmount','sum(p.paidAmount) as paidAmount','sum(p.balanceAmount) as balanceAmount','sum(p.adminDiscountAmount) as adminDiscountAmount')->from('Entity\PlaceOrderId','p')->innerJoin('p.address_id','Entity\CustomerAddress')->where('p.orderDate=:orderDate and Entity\CustomerAddress.area_id=:areaId')->setParameter('orderDate',$orderDate)->setParameter('areaId',$areaId)->getQuery()->getResult();
			$orderObj = $qb->getResult();
				$order = array();
				print_r($orderObj);
				foreach ($orderObj as $key => $value) {
					
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


}