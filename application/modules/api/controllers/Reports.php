<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Reports extends REST_Controller {
	function __construct(){
		parent::__construct();
        $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->methods['apartment_get']['limit'] = '10';
        $this->methods['itemtype_get']['limit'] = '10';
        $this->_em = $this->doctrine->em;
      }
      private $_month = array("1"=>"JAN","2"=>"FEB","3"=>"MAR","4"=>"APRL","5"=>"MAY","6"=>"JUN","7"=>"JUL","8"=>"AUG","9"=>"SEPT","10"=>"OCT","11"=>"NOV","12"=>"DEC");
      public function storeReport_post(){
      	$input = file_get_contents('php://input');
      	$data = json_decode($input);
      	if(is_object($data)){
      		if(property_exists($data,'storeId') && $data->storeId){
      			$storeId =  $data->storeId;
      			$activeCount = 10;
      			$this->load->database();
      			if($storeId){
      				$orderQ = 'select count(pi.o_id) as totalOrders,
      				sum(pi.closingBalance) as totalSales,
      				DATE_FORMAT(pi.orderDate,"%Y-%m") as month
      				from place_order_ids as pi
      				where pi.store_id = "'.$storeId.'"
      				and pi.isDelete=0
      				group by DATE_FORMAT(pi.orderDate,"%Y-%m") order by pi.orderDate asc';
      				$oquery = $this->db->query($orderQ);
      				$resultOrders = $oquery->result();
      				$cQ = 'select count(DISTINCT c.cust_id) as newCustomers,
      				DATE_FORMAT(c.created_at,"%Y-%m") as month
      				from customers as c
      				left join place_order_ids as pi
      				on c.cust_id = pi.customer_id and pi.isDelete=0
      				where c.area_id = "'.$storeId.'"
      				group by DATE_FORMAT(c.created_at,"%Y-%m")
      				order by c.created_at asc';
      				$cquery = $this->db->query($cQ);
      				$resultCustomers = $cquery->result();
      				$apcQ = 'select count(DISTINCT c.cust_id) as activeCustomers,
      				DATE_FORMAT(pi.orderDate,"%Y-%m") as month
      				from customers as c
      				inner join place_order_ids as pi
      				on c.cust_id = pi.customer_id  and pi.isDelete=0
      				where c.area_id = "'.$storeId.'" and DATE_FORMAT(c.created_at,"%Y-%m")!=DATE_FORMAT(CURDATE(),"%Y-%m")
      				group by DATE_FORMAT(pi.orderDate,"%Y-%m")
      				order by pi.orderDate asc';
      				$acquery = $this->db->query($apcQ);
      				$resultActiveCustomers = $acquery->result();
      				$result = array();
      				foreach ($resultOrders as $rok => $rov) {
      					$result[$rov->month]['totalOrders'] = (int)$rov->totalOrders;
      					$result[$rov->month]['totalSales'] = (int)$rov->totalSales;
      				}
      				$tc = 0;
      				$ac = 0;
      				foreach ($resultCustomers as $rck => $rcv) {
      					$result[$rcv->month]['newCustomers'] = (int)$rcv->newCustomers;
      					$tc = $tc + (int)$rcv->newCustomers;
      					$result[$rcv->month]['totalCustomers'] = $tc;
      				}
      				foreach ($resultActiveCustomers as $rack => $racv) {
      					$result[$racv->month]['activeCustomers'] = (int)$racv->activeCustomers;
      				}
      				ksort($result);
      				$today = date('Y-m');
      				$arraymonths = array();
      				foreach ($result as $rk => &$rv) {
      					if(!array_key_exists('totalOrders', $rv)){
      						$rv['totalOrders']=0;
      					}
      					if(!array_key_exists('totalSales', $rv)){
      						$rv['totalSales']=0;
      					}
      					if(!array_key_exists('newCustomers', $rv)){
      						$rv['newCustomers']=0;
      					}
      					if(!array_key_exists('totalCustomers', $rv)){
      						$prv = prev($result);
      						$prv = prev($result);
      						$rv['totalCustomers']=$prv['totalCustomers'];
      					}
      					if(!array_key_exists('activeCustomers', $rv)){
      						$rv['activeCustomers']=0;
      					}
      				}
      				$this->set_response($result, REST_Controller::HTTP_OK);
      			}
      		}
      	}else{
      	}
      }
      public function storeWiseOrders_post(){
      	$input = file_get_contents("php://input");
      	$data = json_decode($input);
      	if(is_object($data) && property_exists($data,'rtype')){
      		try{
      			$qb = $this->_em->createQueryBuilder('p');
      			$fromDate = date('Y-m-d');
      			$toDate = date('Y-m-d');
      			$type = $data->rtype;
      			if(property_exists($data, 'fromDate') && $data->fromDate){
      				$fdate = $data->fromDate;
      				$fromDate = date('Y-m-d',strtotime($fdate));
      			}
      			if(property_exists($data, 'toDate') && $data->toDate){
      				$tdate = $data->toDate;
      				$toDate = date('Y-m-d',strtotime($tdate));
      			}
      			$this->load->database();
      			$orders = array();
      			switch ($type) {
      				case 'monthly':
      				$mq = 'select count(*) as totalOrders, s.name as store, MONTH(p.orderDate) as month from place_order_ids as p left join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by p.store_id, MONTH(p.orderDate)';
      				$query = $this->db->query($mq);
      				$orders = array();
      				$orderObj = $query->result();
      				$orders = array();
      				foreach ($orderObj as $key => $obj) {
      					$order = array();
      					$order['type'] = $this->_month[$obj->month];
      					$order['store']		 = $obj->store;
      					$order['totalOrders'] = $obj->totalOrders;
      					$orders['reports'][] = $order;
      				}
      				break;
      				case 'yearly':
      				$query = $this->db->query('select count(*) as totalOrders, s.name as store, YEAR(p.orderDate) as year from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by p.store_id, YEAR(p.orderDate)');
      				$orderObj = $query->result();
      				$orders = array();
      				foreach ($orderObj as $key => $obj) {
      					$order = array();
      					$order['type'] = $obj->year;
      					$order['store']		 = $obj->store;
      					$order['totalOrders'] = $obj->totalOrders;
      					$orders['reports'][] = $order;
      				}
      				break;
      				case 'daily':
      				$query = $this->db->query('select count(*) as totalOrders, s.name as store, DATE(p.orderDate) as day from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by p.store_id, DATE(p.orderDate)');
      				$orderObj = $query->result();
      				$orders = array();
      				foreach ($orderObj as $key => $obj) {
      					$order = array();
      					$order['type'] = $obj->day;
      					$order['store']		 = $obj->store;
      					$order['totalOrders'] = $obj->totalOrders;
      					$orders['reports'][] = $order;
      				}
      				break;
      				case 'weekly':
      				$query = $this->db->query('select count(*) as totalOrders, s.name as store, WEEK(p.orderDate) as week from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by p.store_id, WEEK(p.orderDate)');
      				$orderObj = $query->result();
      				$orders = array();
      				foreach ($orderObj as $key => $obj) {
      					$order = array();
      					$order['type'] 		= "week-".$obj->week;
      					$order['store']		= $obj->store;
      					$order['totalOrders'] = $obj->totalOrders;
      					$orders['reports'][] = $order;
      				}
      				break;
      				default:
						$query = $this->db->query('select count(*) as totalOrders, s.name as store, s.area_id as storeId, MONTH(p.orderDate) as month from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by p.store_id'); //MONTH(p.orderDate)
						$orderObj = $query->result();
						$orders = array();
						foreach ($orderObj as $key => $obj) {
							$order = array();
									$order['type'] =   '';//      $this->_month[$obj->month];
									$order['store']		 	= $obj->store;
									$order['storeId']		= $obj->store;
									$order['totalOrders'] 	= $obj->totalOrders;
									$orders['reports'][] 	= $order;
								}
								break;
							}
							$this->set_response($orders,REST_Controller::HTTP_OK);
						}catch(Exception $e){
							$message = ['message'=>$e->getMessage(),'status'=>500];
							$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
						}
					}else{
						$message = ['message'=>'someting went wrong'];
						$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
					}
			}
			public function storeWiseRevenue_post(){
					$input = file_get_contents("php://input");
					$data = json_decode($input);
					if(is_object($data) && property_exists($data,'rtype')){
						try{
							$qb = $this->_em->createQueryBuilder('p');
							$fromDate = date('Y-m-d');
							$toDate = date('Y-m-d');
							$type = $data->rtype;
							if(property_exists($data, 'fromDate') && $data->fromDate){
								$fdate = $data->fromDate;
								$fromDate = date('Y-m-d',strtotime($fdate));
							}
							if(property_exists($data, 'toDate') && $data->toDate){
								$tdate = $data->toDate;
								$toDate = date('Y-m-d',strtotime($tdate));
							}
							$this->load->database();
							$orders = array();
							switch ($type) {
								case 'monthly':
								$mq = 'select SUM(closingBalance) as revenue, s.name as store, MONTH(p.orderDate) as month from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by MONTH(p.orderDate),p.store_id';
								$query = $this->db->query($mq);
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] = $this->_month[$obj->month];
									$order['store']		 = $obj->store;
									$order['revenue'] =  number_format($obj->revenue,2,'.','');
									$orders['reports'][] = $order;
								}
								break;
								case 'yearly':
								$query = $this->db->query('select SUM(closingBalance) as revenue, s.name as store, YEAR(p.orderDate) as year from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by p.store_id, YEAR(p.orderDate)');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] = $obj->year;
									$order['store']		 = $obj->store;
									$order['revenue'] = number_format($obj->revenue,2,'.','');
									$orders['reports'][] = $order;
								}
								break;
								case 'daily':
								$query = $this->db->query('select SUM(closingBalance) as revenue, s.name as store, DATE(p.orderDate) as day from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by p.store_id, DATE(p.orderDate)');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] = $obj->day;
									$order['store']		 = $obj->store;
									$order['revenue'] = number_format($obj->revenue,2,'.','');
									$orders['reports'][] = $order;
								}
								break;
								case 'weekly':
								$query = $this->db->query('select SUM(closingBalance) as revenue, s.name as store, WEEK(p.orderDate) as week from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by p.store_id, WEEK(p.orderDate)');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] 		= "week-".$obj->week;
									$order['store']		= $obj->store;
									$order['revenue'] = number_format($obj->revenue,2,'.','');
									$orders['reports'][] = $order;
								}
								break;
								default:
						$query = $this->db->query('select SUM(closingBalance) as revenue, s.name as store, s.area_id as storeId, MONTH(p.orderDate) as month from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by p.store_id'); //, MONTH(p.orderDate)
						$orderObj = $query->result();
						foreach ($orderObj as $key => $obj) {
							$order = array();
									$order['type'] =  '';//$this->_month[$obj->month];
									$order['store']		 = $obj->store;
									$order['revenue'] = number_format($obj->revenue,2,'.','');
									$orders['reports'][] = $order;
								}
								break;
							}
							$this->set_response($orders,REST_Controller::HTTP_OK);
						}catch(Exception $e){
							$message = ['message'=>$e->getMessage(),'status'=>500];
							$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
						}
					}else{
						$message = ['message'=>'someting went wrong'];
						$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
					}
			}
			public function storeWiseGarments_post(){
					$input = file_get_contents("php://input");
					$data = json_decode($input);
					if(is_object($data) && property_exists($data,'rtype')){
						try{
							$qb = $this->_em->createQueryBuilder('p');
							$fromDate = date('Y-m-d');
							$toDate = date('Y-m-d');
							//$gtype = 'service_id';
              $gtype = 'item_id';
							$type = $data->rtype;
							if(property_exists($data, 'fromDate') && $data->fromDate){
								$fdate = $data->fromDate;
								$fromDate = date('Y-m-d',strtotime($fdate));
							}
							if(property_exists($data, 'toDate') && $data->toDate){
								$tdate = $data->toDate;
								$toDate = date('Y-m-d',strtotime($tdate));
							}
							if(property_exists($data, 'gtype')){
								$gtype = $data->gtype;
							}
							$qgtype = 'pi.'.$gtype;
							$this->load->database();
							$orders = array();
							switch ($type) {
								case 'monthly':
								$query = $this->db->query('select SUM(icount) as gcount, s.name as store, MONTH(p.orderDate) as month, it.name as item, itt.name as itype, sr.name as service from place_order as pi inner join place_order_ids as p on pi.order_id = p.order_id inner join areas as s on p.store_id = s.area_id left join items as it on pi.item_id = it.item_id left join services as sr on pi.service_id = sr.service_id left join item_types as itt on it.itype_id = itt.itype_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by '.$qgtype.',itt.itype_id,  p.store_id, MONTH(p.orderDate)');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] = $this->_month[$obj->month];
									if($gtype=='service_id'){
										$order['rtype'] = $obj->service;
									}else{
										$order['rtype'] = $obj->item;
									}
									$order['store']		 = $obj->store;
									$order['item']		 = $obj->item;
									$order['itype']		 = $obj->itype;
									$order['gcount']   = $obj->gcount;
									$orders['reports'][] = $order;
								}
								break;
								case 'yearly':
								$query = $this->db->query('select SUM(icount) as gcount, s.name as store, YEAR(p.orderDate) as year, it.name as item, itt.name as itype, sr.name as service from place_order as pi inner join place_order_ids as p on pi.order_id = p.order_id inner join areas as s on p.store_id = s.area_id left join items as it on pi.item_id = it.item_id left join services as sr on pi.service_id = sr.service_id left join item_types as itt on it.itype_id = itt.itype_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by '.$qgtype.', itt.itype_id,  p.store_id, YEAR(p.orderDate)');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] = $obj->year;
									if($gtype=='service_id'){
										$order['rtype'] = $obj->service;
									}else{
										$order['rtype'] = $obj->item;
									}
									$order['store']		 = $obj->store;
									$order['item']		 = $obj->item;
									$order['itype']		 = $obj->itype;
									$order['gcount'] = $obj->gcount;
									$orders['reports'][] = $order;
								}
								break;
								case 'daily':
								$query = $this->db->query('select SUM(icount) as gcount, s.name as store, DATE(p.orderDate) as day, it.name as item, itt.name as itype, sr.name as service from place_order as pi inner join place_order_ids as p on pi.order_id = p.order_id inner join areas as s on p.store_id = s.area_id left join items as it on pi.item_id = it.item_id left join services as sr on pi.service_id = sr.service_id left join item_types as itt on it.itype_id = itt.itype_id  where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by '.$qgtype.', itt.itype_id, p.store_id, DATE(p.orderDate)');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] = $obj->day;
									if($gtype=='service_id'){
										$order['rtype'] = $obj->service;
									}else{
										$order['rtype'] = $obj->item;
									}
									$order['store']		 = $obj->store;
									$order['item']		 = $obj->item;
									$order['itype']		 = $obj->itype;
									$order['gcount'] = $obj->gcount;
									$orders['reports'][] = $order;
								}
								break;
								case 'weekly':
								$query = $this->db->query('select SUM(icount) as gcount, s.name as store, WEEK(p.orderDate) as week, it.name as item, itt.name as itype, sr.name as service from place_order as pi inner join place_order_ids as p on pi.order_id = p.order_id inner join areas as s on p.store_id = s.area_id left join items as it on pi.item_id = it.item_id left join services as sr on pi.service_id = sr.service_id  left join item_types as itt on it.itype_id = itt.itype_id  where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by '.$qgtype.',itt.itype_id,  p.store_id, WEEK(p.orderDate)');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] 		= "week-".$obj->week;
									if($gtype=='service_id'){
										$order['rtype'] = $obj->service;
									}else{
										$order['rtype'] = $obj->item;
									}
									$order['store']		= $obj->store;
									$order['item']		 = $obj->item;
									$order['itype']		 = $obj->itype;
									$order['gcount'] = $obj->gcount;
									$orders['reports'][] = $order;
								}
								break;
								default:
						$query = $this->db->query('select SUM(icount) as gcount, s.name as store, s.area_id as storeId, MONTH(p.orderDate) as month, it.name as item, itt.name as itype, sr.name as service from place_order as pi inner join place_order_ids as p on pi.order_id = p.order_id inner join areas as s on p.store_id = s.area_id left join items as it on pi.item_id = it.item_id left join services as sr on pi.service_id = sr.service_id  left join item_types as itt on it.itype_id = itt.itype_id  where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by p.store_id, pi.service_id, '.$qgtype.',itt.itype_id');
						$orderObj = $query->result();
						foreach ($orderObj as $key => $obj) {
							$order = array();
									$order['type'] = ''; //$this->_month[$obj->month];
									if($gtype=='service_id'){
										$order['rtype'] = $obj->service;
									}else{
										$order['rtype'] = $obj->item;
									}
                  $order['service'] = $obj->service;
									$order['store']		 = $obj->store;
									$order['item']		 = $obj->item;
									$order['itype']		 = $obj->itype;
									$order['gcount'] = $obj->gcount;
									$orders['reports'][] = $order;
								}
								break;
							}
							$this->set_response($orders,REST_Controller::HTTP_OK);
						}catch(Exception $e){
							$message = ['message'=>$e->getMessage(),'status'=>500];
							$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
						}
					}else{
						$message = ['message'=>'someting went wrong'];
						$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
					}
			}
			public function storeWiseBalance_post(){
					$input = file_get_contents("php://input");
					$data = json_decode($input);
					if(is_object($data) && property_exists($data,'rtype')){
						try{
							$qb = $this->_em->createQueryBuilder('p');
							$fromDate = date('Y-m-d');
							$toDate = date('Y-m-d');
							$type = $data->rtype;
							if(property_exists($data, 'fromDate') && $data->fromDate){
								$fdate = $data->fromDate;
								$fromDate = date('Y-m-d',strtotime($fdate));
							}
							if(property_exists($data, 'toDate') && $data->toDate){
								$tdate = $data->toDate;
								$toDate = date('Y-m-d',strtotime($tdate));
							}
							$this->load->database();
							$orders = array();
							switch ($type) {
								case 'monthly':
								$mq = 'select SUM(balanceAmount) as balanceAmount, s.name as store, MONTH(p.orderDate) as month from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by MONTH(p.orderDate),p.store_id';
								$query = $this->db->query($mq);
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] = $this->_month[$obj->month];
									$order['store']		 = $obj->store;
									$order['balanceAmount'] = number_format($obj->balanceAmount,2,'.','');
									$orders['reports'][] = $order;
								}
								break;
								case 'yearly':
								$query = $this->db->query('select SUM(balanceAmount) as balanceAmount, s.name as store, YEAR(p.orderDate) as year from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by p.store_id, YEAR(p.orderDate)');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] = $obj->year;
									$order['store']		 = $obj->store;
									$order['balanceAmount'] = number_format($obj->balanceAmount,2,'.','');
									$orders['reports'][] = $order;
								}
								break;
								case 'daily':
								$query = $this->db->query('select SUM(balanceAmount) as balanceAmount, s.name as store, DATE(p.orderDate) as day from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by p.store_id, DATE(p.orderDate)');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] = $obj->day;
									$order['store']		 = $obj->store;
									$order['balanceAmount'] =number_format($obj->balanceAmount,2,'.','');
									$orders['reports'][] = $order;
								}
								break;
								case 'weekly':
								$query = $this->db->query('select SUM(balanceAmount) as balanceAmount, s.name as store, WEEK(p.orderDate) as week from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by p.store_id, WEEK(p.orderDate)');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] 		= "week-".$obj->week;
									$order['store']		= $obj->store;
									$order['balanceAmount'] =number_format($obj->balanceAmount,2,'.','');
									$orders['reports'][] = $order;
								}
								break;
								default:
						$query = $this->db->query('select SUM(balanceAmount) as balanceAmount, s.name as store, MONTH(p.orderDate) as month from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by p.store_id'); //, MONTH(p.orderDate)
						$orderObj = $query->result();
						foreach ($orderObj as $key => $obj) {
							$order = array();
									$order['type'] = '';//$this->_month[$obj->month];
									$order['store']		 = $obj->store;
									$order['balanceAmount'] = number_format($obj->balanceAmount,2,'.','');
									$orders['reports'][] = $order;
								}
								break;
							}
							$this->set_response($orders,REST_Controller::HTTP_OK);
						}catch(Exception $e){
							$message = ['message'=>$e->getMessage(),'status'=>500];
							$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
						}
					}else{
						$message = ['message'=>'someting went wrong'];
						$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
					}
			}
			public function storeWiseReturnGarmentAmount_post(){
					$input = file_get_contents("php://input");
					$data = json_decode($input);
					if(is_object($data) && property_exists($data,'rtype')){
						try{
							$qb = $this->_em->createQueryBuilder('p');
							$fromDate = date('Y-m-d');
							$toDate = date('Y-m-d');
							$type = $data->rtype;
							if(property_exists($data, 'fromDate') && $data->fromDate){
								$fdate = $data->fromDate;
								$fromDate = date('Y-m-d',strtotime($fdate));
							}
							if(property_exists($data, 'toDate') && $data->toDate){
								$tdate = $data->toDate;
								$toDate = date('Y-m-d',strtotime($tdate));
							}
							$this->load->database();
							$orders = array();
							switch ($type) {
								case 'monthly':
								$mq = 'select SUM(reFundAmount) as reFundAmount, s.name as store, MONTH(p.orderDate) as month from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by MONTH(p.orderDate),p.store_id';
								$query = $this->db->query($mq);
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] = $this->_month[$obj->month];
									$order['store']		 = $obj->store;
									$order['reFundAmount'] = $obj->reFundAmount;
									$orders['reports'][] = $order;
								}
								break;
								case 'yearly':
								$query = $this->db->query('select SUM(reFundAmount) as reFundAmount, s.name as store, YEAR(p.orderDate) as year from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by p.store_id, YEAR(p.orderDate)');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] = $obj->year;
									$order['store']		 = $obj->store;
									$order['reFundAmount'] = $obj->reFundAmount;
									$orders['reports'][] = $order;
								}
								break;
								case 'daily':
								$query = $this->db->query('select SUM(reFundAmount) as reFundAmount, s.name as store, DATE(p.orderDate) as day from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by p.store_id, DATE(p.orderDate)');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] = $obj->day;
									$order['store']		 = $obj->store;
									$order['reFundAmount'] = $obj->reFundAmount;
									$orders['reports'][] = $order;
								}
								break;
								case 'weekly':
								$query = $this->db->query('select SUM(reFundAmount) as reFundAmount, s.name as store, WEEK(p.orderDate) as week from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by p.store_id, WEEK(p.orderDate)');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] 		= "week-".$obj->week;
									$order['store']		= $obj->store;
									$order['reFundAmount'] = $obj->reFundAmount;
									$orders['reports'][] = $order;
								}
								break;
								default:
								$query = $this->db->query('select SUM(reFundAmount) as reFundAmount, s.name as store, MONTH(p.orderDate) as month from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by p.store_id');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] ='';// $this->_month[$obj->month];
									$order['store']	= $obj->store;
									$order['reFundAmount'] = $obj->reFundAmount;
									$orders['reports'][] = $order;
								}
								break;
							}
							$this->set_response($orders,REST_Controller::HTTP_OK);
						}catch(Exception $e){
							$message = ['message'=>$e->getMessage(),'status'=>500];
							$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
						}
					}else{
						$message = ['message'=>'someting went wrong'];
						$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
					}
			}
			public function storeWiseReturnGarments_post(){
					$input = file_get_contents("php://input");
					$data = json_decode($input);
					if(is_object($data) && property_exists($data,'rtype')){
						try{
							$qb = $this->_em->createQueryBuilder('p');
							$fromDate = date('Y-m-d');
							$toDate = date('Y-m-d');
							$type = $data->rtype;
							if(property_exists($data, 'fromDate') && $data->fromDate){
								$fdate = $data->fromDate;
								$fromDate = date('Y-m-d',strtotime($fdate));
							}
							if(property_exists($data, 'toDate') && $data->toDate){
								$tdate = $data->toDate;
								$toDate = date('Y-m-d',strtotime($tdate));
							}
							$this->load->database();
							$orders = array();
							switch ($type) {
								case 'monthly':
								$mq = 'select SUM(p.ricount) as garments, s.name as store, MONTH(pi.orderDate) as month from place_order_ids as pi inner join place_order as p on pi.order_id = p.order_id inner join areas as s on pi.store_id = s.area_id where pi.isDelete=0 and DATE(pi.orderDate) >="'.$fromDate.'" and DATE(pi.orderDate) <="'.$toDate.'" group by MONTH(pi.orderDate), pi.store_id having SUM(p.ricount)>0';
								$query = $this->db->query($mq);
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] 			= $this->_month[$obj->month];
									$order['store']		 	= $obj->store;
									$order['garments'] 		= (int)$obj->garments;
									$orders['reports'][] 	= $order;
								}
								break;
								case 'yearly':
								$query = $this->db->query('select SUM(p.ricount) as garments, s.name as store, YEAR(pi.orderDate) as year from place_order_ids as pi inner join place_order as p on pi.order_id = p.order_id inner join areas as s on pi.store_id = s.area_id where pi.isDelete=0 and DATE(pi.orderDate) >="'.$fromDate.'" and DATE(pi.orderDate) <="'.$toDate.'" group by YEAR(pi.orderDate), pi.store_id  having SUM(p.ricount)>0') ;
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] 			= $obj->year;
									$order['store']		 	= $obj->store;
									$order['garments'] 		= (int)$obj->garments;
									$orders['reports'][] 	= $order;
								}
								break;
								case 'daily':
								$query = $this->db->query('select SUM(p.ricount) as garments, s.name as store, DATE(pi.orderDate) as day from place_order_ids as pi inner join place_order as p on pi.order_id = p.order_id inner join areas as s on pi.store_id = s.area_id where pi.isDelete=0 and DATE(pi.orderDate) >="'.$fromDate.'" and DATE(pi.orderDate) <="'.$toDate.'" group by DATE(pi.orderDate), pi.store_id  having SUM(p.ricount)>0');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] 			= $obj->day;
									$order['store']			= $obj->store;
									$order['garments'] 		= (int)$obj->garments;
									$orders['reports'][] 	= $order;
								}
								break;
								case 'weekly':
								$query = $this->db->query('select SUM(p.ricount) as garments, s.name as store, WEEK(pi.orderDate) as week from place_order_ids as pi inner join place_order as p on pi.order_id = p.order_id inner join areas as s on pi.store_id = s.area_id where pi.isDelete=0 and DATE(pi.orderDate) >="'.$fromDate.'" and DATE(pi.orderDate) <="'.$toDate.'" group by WEEK(pi.orderDate), pi.store_id  having SUM(p.ricount)>0');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] 		= "week-".$obj->week;
									$order['store']		= $obj->store;
									$order['garments'] 	= (int)$obj->garments;
									$orders['reports'][] = $order;
								}
								break;
								default:
								$query = $this->db->query('select SUM(p.ricount) as garments, s.name as store, MONTH(pi.orderDate) as month from place_order_ids as pi inner join place_order as p on pi.order_id = p.order_id inner join areas as s on pi.store_id = s.area_id where pi.isDelete=0 and DATE(pi.orderDate) >="'.$fromDate.'" and DATE(pi.orderDate) <="'.$toDate.'" group by  pi.store_id  having SUM(p.ricount)>0');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] = '';//$this->_month[$obj->month];
									$order['store']	= $obj->store;
									$order['garments'] = (int)$obj->garments;
									$orders['reports'][] = $order;
								}
								break;
							}
							$this->set_response($orders,REST_Controller::HTTP_OK);
						}catch(Exception $e){
							$message = ['message'=>$e->getMessage(),'status'=>500];
							$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
						}
					}else{
						$message = ['message'=>'someting went wrong'];
						$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
					}
			}
			public function storeWisePaidAmount_post(){
					$input = file_get_contents("php://input");
					$data = json_decode($input);
					if(is_object($data) && property_exists($data,'rtype')){
						try{
							$qb = $this->_em->createQueryBuilder('p');
							$fromDate = date('Y-m-d');
							$toDate = date('Y-m-d');
							$type = $data->rtype;
							if(property_exists($data, 'fromDate') && $data->fromDate){
								$fdate = $data->fromDate;
								$fromDate = date('Y-m-d',strtotime($fdate));
							}
							if(property_exists($data, 'toDate') && $data->toDate){
								$tdate = $data->toDate;
								$toDate = date('Y-m-d',strtotime($tdate));
							}
							$this->load->database();
							$orders = array();
							switch ($type) {
								case 'monthly':
								$mq = 'select SUM(p.paidAmount) as paidAmount, s.name as store, MONTH(p.orderDate) as month from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by MONTH(p.orderDate), p.store_id  having SUM(p.paidAmount)>0';
								$query = $this->db->query($mq);
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] = $this->_month[$obj->month];
									$order['store']		 = $obj->store;
									$order['paidAmount'] = number_format($obj->paidAmount,2,'.','');
									$orders['reports'][] = $order;
								}
								break;
								case 'yearly':
								$query = $this->db->query('select SUM(p.paidAmount) as paidAmount, s.name as store, YEAR(p.orderDate) as year from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by YEAR(p.orderDate), p.store_id  having SUM(p.paidAmount)>0');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] = $obj->year;
									$order['store']		 = $obj->store;
									$order['paidAmount'] = number_format($obj->paidAmount,2,'.','');
									$orders['reports'][] = $order;
								}
								break;
								case 'daily':
								$query = $this->db->query('select SUM(p.paidAmount) as paidAmount, s.name as store, DATE(p.orderDate) as day from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by DATE(p.orderDate),p.store_id  having SUM(p.paidAmount)>0');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] = $obj->day;
									$order['store']		 = $obj->store;
									$order['paidAmount'] = number_format($obj->paidAmount,2,'.','');
									$orders['reports'][] = $order;
								}
								break;
								case 'weekly':
								$query = $this->db->query('select SUM(p.paidAmount) as paidAmount, s.name as store, WEEK(p.orderDate) as week from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by p.store_id, WEEK(p.orderDate) having SUM(p.paidAmount)>0');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] 		= "week-".$obj->week;
									$order['store']		= $obj->store;
									$order['paidAmount'] = number_format($obj->paidAmount,2,'.','');
									$orders['reports'][] = $order;
								}
								break;
								default:
								$query = $this->db->query('select SUM(p.paidAmount) as paidAmount, s.name as store, MONTH(p.orderDate) as month from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by p.store_id  having SUM(p.paidAmount)>0');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] = '';//$this->_month[$obj->month];
									$order['store']		 = $obj->store;
									$order['paidAmount'] = number_format($obj->paidAmount,2,'.','');
									$orders['reports'][] = $order;
								}
								break;
							}
							$this->set_response($orders,REST_Controller::HTTP_OK);
						}catch(Exception $e){
							$message = ['message'=>$e->getMessage(),'status'=>500];
							$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
						}
					}else{
						$message = ['message'=>'someting went wrong'];
						$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
					}
			}
			public function storeWiseDiscountAmount_post(){
					$input = file_get_contents("php://input");
					$data = json_decode($input);
					if(is_object($data) && property_exists($data,'rtype')){
						try{
							$qb = $this->_em->createQueryBuilder('p');
							$fromDate = date('Y-m-d');
							$toDate = date('Y-m-d');
							$type = $data->rtype;
							if(property_exists($data, 'fromDate') && $data->fromDate){
								$fdate = $data->fromDate;
								$fromDate = date('Y-m-d',strtotime($fdate));
							}
							if(property_exists($data, 'toDate') && $data->toDate){
								$tdate = $data->toDate;
								$toDate = date('Y-m-d',strtotime($tdate));
							}
							$this->load->database();
							$orders = array();
							switch ($type) {
								case 'monthly':
								$mq = 'select SUM(p.adminDiscountAmount) as adminDiscountAmount, s.name as store, MONTH(p.orderDate) as month from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by MONTH(p.orderDate),p.store_id  having SUM(p.adminDiscountAmount)>0';
								$query = $this->db->query($mq);
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] = $this->_month[$obj->month];
									$order['store']		 = $obj->store;
									$order['adminDiscountAmount'] = $obj->adminDiscountAmount;
									$orders['reports'][] = $order;
								}
								break;
								case 'yearly':
								$query = $this->db->query('select SUM(p.adminDiscountAmount) as adminDiscountAmount, s.name as store, YEAR(p.orderDate) as year from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by p.store_id, YEAR(p.orderDate)  having SUM(p.adminDiscountAmount)>0');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] = $obj->year;
									$order['store']		 = $obj->store;
									$order['adminDiscountAmount'] = $obj->adminDiscountAmount;
									$orders['reports'][] = $order;
								}
								break;
								case 'daily':
								$query = $this->db->query('select SUM(p.adminDiscountAmount) as adminDiscountAmount, s.name as store, DATE(p.orderDate) as day from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by p.store_id, DATE(p.orderDate)  having SUM(p.adminDiscountAmount)>0');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] = $obj->day;
									$order['store']		 = $obj->store;
									$order['adminDiscountAmount'] = $obj->adminDiscountAmount;
									$orders['reports'][] = $order;
								}
								break;
								case 'weekly':
								$query = $this->db->query('select SUM(p.adminDiscountAmount) as adminDiscountAmount, s.name as store, WEEK(p.orderDate) as week from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by p.store_id, WEEK(p.orderDate)  having SUM(p.adminDiscountAmount)>0');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] 		= "week-".$obj->week;
									$order['store']		= $obj->store;
									$order['adminDiscountAmount'] = $obj->adminDiscountAmount;
									$orders['reports'][] = $order;
								}
								break;
								default:
								$query = $this->db->query('select SUM(p.adminDiscountAmount) as adminDiscountAmount, s.name as store, MONTH(p.orderDate) as month from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by p.store_id  having SUM(p.adminDiscountAmount)>0');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] = '';//$this->_month[$obj->month];
									$order['store']		 = $obj->store;
									$order['adminDiscountAmount'] = $obj->adminDiscountAmount;
									$orders['reports'][] = $order;
								}
								break;
							}
							$this->set_response($orders,REST_Controller::HTTP_OK);
						}catch(Exception $e){
							$message = ['message'=>$e->getMessage(),'status'=>500];
							$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
						}
					}else{
						$message = ['message'=>'someting went wrong'];
						$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
					}
			}
			public function ordersByStatus_post(){
					$input = file_get_contents("php://input");
					$data = json_decode($input);
					if(is_object($data) && property_exists($data,'rtype')){
						try{
							$qb = $this->_em->createQueryBuilder('p');
							$fromDate = date('Y-m-d');
							$toDate = date('Y-m-d');
							$type = $data->rtype;
							if(property_exists($data, 'fromDate') && $data->fromDate){
								$fdate = $data->fromDate;
								$fromDate = date('Y-m-d',strtotime($fdate));
							}
							if(property_exists($data, 'toDate') && $data->toDate){
								$tdate = $data->toDate;
								$toDate = date('Y-m-d',strtotime($tdate));
							}
							$this->load->database();
							$orders = array();
							switch ($type) {
								case 'monthly':
								$mq = 'select count(*) as totalOrders, s.name as store, p.poStatus as status, MONTH(p.orderDate) as month from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by MONTH(p.orderDate), p.store_id, p.poStatus';
								$query = $this->db->query($mq);
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] 	= $this->_month[$obj->month];
									$order['store']	= $obj->store;
									$order['status']	= $obj->status;
									$order['totalOrders'] = $obj->totalOrders;
									$orders['reports'][] 	= $order;
								}
								break;
								case 'yearly':
								$query = $this->db->query('select count(*) as totalOrders,  s.name as store, p.poStatus as status, YEAR(p.orderDate) as year from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by  YEAR(p.orderDate), p.store_id, p.poStatus');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] 		= $obj->year;
									$order['status']	= $obj->status;
									$order['store']	= $obj->store;
									$order['totalOrders'] = $obj->totalOrders;
									$orders['reports'][] = $order;
								}
								break;
								case 'daily':
								$query = $this->db->query('select count(*) as totalOrders,  s.name as store, p.poStatus as status, DATE(p.orderDate) as day from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate)>="'.$fromDate.'" and DATE(p.orderDate)<="'.$toDate.'" group by  DATE(p.orderDate), p.store_id, p.poStatus');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] 		= $obj->day;
									$order['status']	= $obj->status;
									$order['store']	= $obj->store;
									$order['totalOrders'] = $obj->totalOrders;
									$orders['reports'][] = $order;
								}
								break;
								case 'weekly':
								$query = $this->db->query('select count(*) as totalOrders, p.poStatus as status,  s.name as store, WEEK(p.orderDate) as week from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by  WEEK(p.orderDate), p.store_id, p.poStatus');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] 			= "week-".$obj->week;
									$order['status']		= $obj->status;
									$order['store']	= $obj->store;
									$order['totalOrders'] 	= $obj->totalOrders;
									$orders['reports'][] = $order;
								}
								break;
								default:
								$query = $this->db->query('select count(*) as totalOrders, s.name as store, p.poStatus as status, MONTH(p.orderDate) as month from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by  p.store_id, p.poStatus');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] 		= '';//$this->_month[$obj->month];
									$order['status']		= $obj->status;
									$order['store']	= $obj->store;
									$order['totalOrders'] 	= $obj->totalOrders;
									$orders['reports'][] = $order;
								}
								break;
							}
							$this->set_response($orders,REST_Controller::HTTP_OK);
						}catch(Exception $e){
							$message = ['message'=>$e->getMessage(),'status'=>500];
							$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
						}
					}else{
						$message = ['message'=>'someting went wrong'];
						$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
					}
			}
			public function customersByDate_post(){
					$input = file_get_contents("php://input");
					$data = json_decode($input);
					if(is_object($data) && property_exists($data,'rtype')){
						try{
							$qb = $this->_em->createQueryBuilder('p');
							$fromDate = date('Y-m-d');
							$toDate = date('Y-m-d');
							$type = $data->rtype;
							if(property_exists($data, 'fromDate') && $data->fromDate){
								$fdate = $data->fromDate;
								$fromDate = date('Y-m-d',strtotime($fdate));
							}
							if(property_exists($data, 'toDate') && $data->toDate){
								$tdate = $data->toDate;
								$toDate = date('Y-m-d',strtotime($tdate));
							}
							$this->load->database();
							$orders = array();
							switch ($type) {
								case 'monthly':
								$mq = 'select count(*) as totalCustomers, MONTH(c.created_at) as month from customers as c  where DATE(c.created_at) >="'.$fromDate.'" and DATE(c.created_at) <="'.$toDate.'" group by MONTH(c.created_at)';
								$query = $this->db->query($mq);
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] 	= $this->_month[$obj->month];
									$order['totalCustomers'] = $obj->totalCustomers;
									$orders['reports'][] 	= $order;
								}
								break;
								case 'yearly':
								$query = $this->db->query('select count(*) as totalCustomers, YEAR(c.created_at) as year from customers as c where  DATE(c.created_at) >="'.$fromDate.'" and DATE(c.created_at) <="'.$toDate.'" group by  YEAR(c.created_at)');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] 		= $obj->year;
									$order['totalCustomers'] = $obj->totalCustomers;
									$orders['reports'][] = $order;
								}
								break;
								case 'daily':
								$query = $this->db->query('select count(*) as totalCustomers, DATE(c.created_at) as day from customers as c where DATE(c.created_at) >="'.$fromDate.'" and DATE(c.created_at) <="'.$toDate.'" group by  DATE(c.created_at)');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] 		= $obj->day;
									$order['totalCustomers'] = $obj->totalCustomers;
									$orders['reports'][] = $order;
								}
								break;
								case 'weekly':
								$query = $this->db->query('select count(*) as totalCustomers,  WEEK(c.created_at) as week from customers as c where DATE(c.created_at) >="'.$fromDate.'" and DATE(c.created_at) <="'.$toDate.'" group by  WEEK(c.created_at)');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] 			= "week-".$obj->week;
									$order['totalCustomers'] 	= $obj->totalCustomers;
									$orders['reports'][] = $order;
								}
								break;
								default:
								$query = $this->db->query('select count(*) as totalCustomers, s.name as store, s.area_id as storeId, MONTH(c.created_at) as month from customers as c inner join areas as s on s.area_id = c.area_id  where DATE(c.created_at) >="'.$fromDate.'" and DATE(c.created_at) <="'.$toDate.'" group by c.area_id');
								$orderObj = $query->result();
								foreach ($orderObj as $key => $obj) {
									$order = array();
									$order['type'] 		= '';//$this->_month[$obj->month];
									$order['store']	= $obj->store;
									$order['totalCustomers'] 	= $obj->totalCustomers;
									$orders['reports'][] = $order;
								}
								break;
							}
							$this->set_response($orders,REST_Controller::HTTP_OK);
						}catch(Exception $e){
							$message = ['message'=>$e->getMessage(),'status'=>500];
							$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
						}
					}else{
						$message = ['message'=>'someting went wrong'];
						$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
					}
			}
			public function storewiseCollection_post(){
				$input = file_get_contents("php://input");
				$data = json_decode($input);
					if(is_object($data)){
						$fromDateObj = new \DateTime('today');
						if(property_exists($data,'fromDate') && $data->fromDate){
							  $fromDate = date('Y-m-d',strtotime($data->fromDate));
  						}else{
  							$fromDate = $fromDateObj->format('Y-m-d');
  						}
						  $toDateObj = new \DateTime('today');
						if(property_exists($data,'toDate') && $data->toDate){
                $toDate = date('Y-m-d',strtotime($data->toDate));
              }else{
              	$toDate = $toDateObj->format('Y-m-d');
              }
              $result = array();
              $this->load->database();
              $transQ = "select sum(th.paidAmount) as paidAmount, th.paymentType as paymentType, a.name as store from transactions_history as th inner join place_order_ids as pi on th.order_id = pi.order_id inner join areas as a on a.area_id = pi.store_id where DATE(th.created_at) >='$fromDate' and DATE(th.created_at) <='$toDate' group by pi.store_id, th.paymentType having SUM(th.paidAmount)>=0";
              $ordersTable = array();
              $sc = array();
              $stores = array();
              $dstores = array();
              $transQuery = $this->db->query($transQ);
              $collectionsTable = array();
              $transObj = $transQuery->result();
              foreach ($transObj as $key => $obj) {
              	$service  = $obj->paymentType;
              	$cost 	= $obj->paidAmount;
              	$store    = $obj->store;
                // $stores[$store][] = array($service=>$cost,$service.'Items'=>$items );
              	$stores[$store][] = array($service=>$cost);
              }
              foreach ($stores as $skey => $svalue) {
              	$flat = call_user_func_array('array_merge', $svalue);
              	$sc[$skey] = $flat;
              }
              $th = array();
              $thStores = array();
              $tempStore = '';
              $payArray = array();
              foreach ($transObj as $key => $obj) {
              	$cost     = (int)$obj->paidAmount;
              	$store    = $obj->store;
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
              	if(!array_key_exists('OnlineTransfer', $thv)){
              		$thv['OnlineTransfer'] = 0;
              	}
              	if(!array_key_exists('Cheque', $thv)){
              		$thv['Cheque'] = 0;
              	}
              }
              foreach ($sc as $skey => $cvalue) {
              	if(array_key_exists($skey, $thStores)){
              		$flats = array_merge($cvalue,$thStores[$skey]);
              	}else{
              		$flats = array_merge($cvalue,array('Cash'=>0,'PayTM'=>0,'DebitCard'=>0,'CreditCard'=>0,'OnlineTransfer'=>0,'Cheque'=>0));
              	}
              	$sc[$skey] = $flats;
              }
              $result['ordersTable'] = $sc;
              $this->set_response($result, REST_Controller::HTTP_OK);
            }else{
            	$message =[ 'message' =>' payload mistaken... '];
            	$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
            }
	  }

	  // 10 jul 2018 onwords

	  public function storeWiseDiscountReport_post(){
				$input = file_get_contents("php://input");
				$data = json_decode($input);
				if(is_object($data) && property_exists($data,'rtype')){
					try{
						$qb = $this->_em->createQueryBuilder('p');
						$fromDate = date('Y-m-d');
						$toDate = date('Y-m-d');
						$type = $data->rtype;
						if(property_exists($data, 'fromDate') && $data->fromDate){
							$fdate = $data->fromDate;
							$fromDate = date('Y-m-d',strtotime($fdate));
						}
						if(property_exists($data, 'toDate') && $data->toDate){
							$tdate = $data->toDate;
							$toDate = date('Y-m-d',strtotime($tdate));
						}
						$this->load->database();
						$orders = array();
						switch ($type) {
							case 'monthly':
							$mq = 'select SUM(p.adminDiscountAmount) as adminDiscountAmount, SUM(p.closingBalance) as excludingDiscount, s.name as store, MONTH(p.orderDate) as month from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by MONTH(p.orderDate),p.store_id  having SUM(p.adminDiscountAmount)>0';
							$query = $this->db->query($mq);
							$orderObj = $query->result();
							foreach ($orderObj as $key => $obj) {
								$order = array();
								$order['type'] = $this->_month[$obj->month];
								$order['store']		 = $obj->store;
								$order['adminDiscountAmount'] = $obj->adminDiscountAmount;
								$order['excludingDiscount'] = $obj->excludingDiscount;
								$order['includingDiscount'] = $obj->excludingDiscount + $obj->adminDiscountAmount;
								$orders['reports'][] = $order;
							}
							break;
							case 'yearly':
							$query = $this->db->query('select SUM(p.adminDiscountAmount) as adminDiscountAmount, s.name as store, YEAR(p.orderDate) as year from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by p.store_id, YEAR(p.orderDate)  having SUM(p.adminDiscountAmount)>0');
							$orderObj = $query->result();
							foreach ($orderObj as $key => $obj) {
								$order = array();
								$order['type'] = $obj->year;
								$order['store']		 = $obj->store;
								$order['adminDiscountAmount'] = $obj->adminDiscountAmount;
								$orders['reports'][] = $order;
							}
							break;
							case 'daily':
							$query = $this->db->query('select SUM(p.adminDiscountAmount) as adminDiscountAmount, s.name as store, DATE(p.orderDate) as day from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by p.store_id, DATE(p.orderDate)  having SUM(p.adminDiscountAmount)>0');
							$orderObj = $query->result();
							foreach ($orderObj as $key => $obj) {
								$order = array();
								$order['type'] = $obj->day;
								$order['store']		 = $obj->store;
								$order['adminDiscountAmount'] = $obj->adminDiscountAmount;
								$orders['reports'][] = $order;
							}
							break;
							case 'weekly':
							$query = $this->db->query('select SUM(p.adminDiscountAmount) as adminDiscountAmount, s.name as store, WEEK(p.orderDate) as week from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by p.store_id, WEEK(p.orderDate)  having SUM(p.adminDiscountAmount)>0');
							$orderObj = $query->result();
							foreach ($orderObj as $key => $obj) {
								$order = array();
								$order['type'] 		= "week-".$obj->week;
								$order['store']		= $obj->store;
								$order['adminDiscountAmount'] = $obj->adminDiscountAmount;
								$orders['reports'][] = $order;
							}
							break;
							default:
							$query = $this->db->query('select SUM(p.adminDiscountAmount) as adminDiscountAmount,  SUM(p.closingBalance) as excludingDiscount, s.name as store, MONTH(p.orderDate) as month from place_order_ids as p inner join areas as s on p.store_id = s.area_id where p.isDelete=0 and DATE(p.orderDate) >="'.$fromDate.'" and DATE(p.orderDate) <="'.$toDate.'" group by p.store_id  having SUM(p.adminDiscountAmount)>0');
							$orderObj = $query->result();
							foreach ($orderObj as $key => $obj) {
								$order = array();
								$order['type'] = '';//$this->_month[$obj->month];
								$order['store']		 = $obj->store;
								$order['adminDiscountAmount'] = $obj->adminDiscountAmount;
								$order['excludingDiscount'] = $obj->excludingDiscount;
								$order['includingDiscount'] = $obj->excludingDiscount + $obj->adminDiscountAmount;
								$orders['reports'][] = $order;
							}
							break;
						}
						$this->set_response($orders,REST_Controller::HTTP_OK);
					}catch(Exception $e){
						$message = ['message'=>$e->getMessage(),'status'=>500];
						$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
					}
					}else{
						$message = ['message'=>'someting went wrong'];
						$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
					}
			}
    }