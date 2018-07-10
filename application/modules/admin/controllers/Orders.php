<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Orders extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	}
	public function index(){
		$this->load->view('orders');
	}
	public function getserviceitems(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$customerId =0;
		if(property_exists($data, 'customerId')){
			$customerId 	= $data->customerId;	
		}
		if (property_exists($data,'serviceId')) {
			$serviceId      = $data->serviceId;
		}
		$itemTypeId = 0;
		if (property_exists($data,'itemTypeId')) {
			$itemTypeId = $data->itemTypeId;
		}
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		if($customerId){
			$cust = $this->_em->find('Entity\Customer',$customerId);
			if(is_object($cust)){
				if(is_object($cust->getApartmentId())){
					$aptId = $cust->getApartmentId()->getId();
					$userType = $cust->getUserType();
					if($aptId){
						$apart = $this->_em->find('Entity\Apartment',$aptId);
						if(is_object($catalogId =$apart->getCatalogId()))
							$catalogId = $apart->getCatalogId()->getId(); 
						else{
							$cat = $this->_em->getRepository('Entity\Catalog')->findOneByName('default');
							$catalogId = $cat->getId();
						};
					}else{
						$cat = $this->_em->getRepository('Entity\Catalog')->findOneByName('default');
						if(is_object($cat))
							$catalogId = $cat->getId();
					}
				}else if(is_object($cat = $cust->getAreaId()->getCatalogId())){
					$catalogId = $cat->getId();
				}else{
					$cat = $this->_em->getRepository('Entity\Catalog')->findOneByName('default');
					if(is_object($cat))
						$catalogId = $cat->getId();
				}
				$itemObj = $qb->select('cp','Entity\Item')->from('Entity\CatalogPrice','cp')->innerJoin('cp.item_id','Entity\Item')->where('cp.catalog_id = :catalogId and cp.itype_id =:itemTypeId and cp.service_id=:serviceId and cp.status=1 and Entity\Item.status=1')->setParameters(array('catalogId'=>$catalogId,'serviceId'=>$serviceId,'itemTypeId'=>$itemTypeId))->getQuery()->getArrayResult();
				$items = array();
				$items['items'] = array();
				foreach($itemObj as $it){
					if(array_key_exists('item_id',$it)){
						if($it['item_id']['status']){
							$item = array();
							$item['id'] = $it['item_id']['id'];
							$item['name'] = $it['item_id']['name'];
							$item['cost'] = $it['cost'];
							$items['items'][] = $item;
						}
					}
				}
				if($serviceId){
					$serviceObj = $this->_em->find('Entity\Service',$serviceId); 
					if(is_object($serviceObj)){
						$addons = $serviceObj->getStatusAddons();
					}
				}else{
					$addons = array();
				}
				if(is_array($addons)){
					$items['addons'] = $addons;
				}
				echo json_encode($items);
				die();
			}else{
				die('customer object not found');
			}
		}else{
			die('customer not found');
		}
		die();
	}
	public function savepreorder(){
		$input = file_get_contents("php://input");
		$result = json_decode($input);
		$id = 0;
		if(property_exists($result, 'id')){
			$id = $result->id;
		}
		$customerId = 2;
		if(property_exists($result,'customerId')){
			$customerId = $result->customerId;
		}
		$this->_em = $this->doctrine->em;
		if($customerId){
			$cust = $this->_em->find('Entity\Customer',$customerId);
			if(is_object($cust)){
				log_message('error', ' area obj ');
				if(is_object($cust->getApartmentId())){
					log_message('error', ' area obj ');
					$aptId = $cust->getApartmentId()->getId();
					if($aptId){
						$apart = $this->_em->find('Entity\Apartment',$aptId);
						if(is_object($catalogId =$apart->getCatalogId()))
							$catalogId = $apart->getCatalogId()->getId(); 
						else{
							$cat = $this->_em->getRepository('Entity\Catalog')->findOneByName('default');
							$catalogId = $cat->getId();
						};
					}else{
						$cat = $this->_em->getRepository('Entity\Catalog')->findOneByName('default');
						$catalogId = $cat->getId();
					}
				} else if (is_object($cust->getAreaId())) {
					log_message('error', ' area obj ');
					$catalogObj = $cust->getAreaId()->getCatalogId();
					log_message('error', ' catalogObj ');
					if(is_object($catalogObj)){
						log_message('error', ' yes catalogObj ');
						$catalogId = $catalogObj->getId();	
					}else{
						log_message('error', ' no catalogObj ');
						$cat = $this->_em->getRepository('Entity\Catalog')->findOneByName('default');
						$catalogId = $cat->getId();
					}
				}else{
					$cat = $this->_em->getRepository('Entity\Catalog')->findOneByName('default');
					$catalogId = $cat->getId();
				}
			}else{
				$catalogId =1;			log_message('error', ' customer id not coming ');
			}
			$itemId 	= $result->pitem;
			$serviceId 	= $result->service;
			$itemTypeId 	= $result->itemtype;
			$count 	= $result->icount;
			$qb = $this->_em->createQueryBuilder();
			$cps = $qb->select('cp.cost as cost, cp.rpoints as rpoints')->from('Entity\CatalogPrice','cp')->innerJoin('cp.item_id','Entity\Item')->where('cp.service_id = :serviceId and cp.item_id =:itemId and cp.catalog_id=:catalogId')->setParameters(array('itemId'=>$itemId,'serviceId'=>$serviceId,'catalogId'=>$catalogId))->getQuery()->getArrayResult();
			$subTotal = 0;
			if(sizeof($cps)){
				$itemCost	= $count*$cps[0]['cost'];
				$rpoints	=   $count*$cps[0]['rpoints'];
			}else{
				$ncost		= 0;
				$dcost		= 0;
				$itemCost 		= 0;
				$rpoints	= 0;
			}
			if($id){
				$placeOrder = $this->_em->find('Entity\TempOrder',$id);
				$placeOrder->getIcount();
				if(!is_object($placeOrder)){
					$placeOrder = new \Entity\TempOrder();
				}
			}else{
				$placeOrder = new \Entity\TempOrder();
			}			
			$item = $this->_em->find('Entity\Item',$itemId);
			$service = $this->_em->find('Entity\Service',$serviceId);
			$cust = $this->_em->find('Entity\Customer',$customerId);
			$placeOrder->setItemId($item);
			$placeOrder->setServiceId($service);
			$placeOrder->setCustomerId($cust);
			if(property_exists($result,'orderId') && $result->orderId){
				$placeOrder->setOrderId($result->orderId);
			}else{
				$placeOrder->setOrderId('tempid');
			}
			$placeOrder->setIcount($count);
			$placeOrder->setRpoints($rpoints);
			if(property_exists($result,'addons')){
				$addons 	= $result->addons; 
				$existingAddons =array();
				foreach ($placeOrder->getTempOrderAddons() as $key => $value) {
					$existingAddons[$value->getAddonId()->getId()] = $value;
				}
				foreach($addons as $k => $ac){
					if(property_exists($ac, 'selected') && $ac->selected){
						if(property_exists($ac,'poaId')){
							$poaId = $ac->poaId;
							$poa = $this->_em->find('Entity\TempOrderAddon',$poaId);
							if(!is_object($poa)){
								$poa = new \Entity\TempOrderAddon();	
							}
						}elseif(array_key_exists($ac->id, $existingAddons)){
							$poa = $existingAddons[$ac->id];
						}
						else{
							$poa = new \Entity\TempOrderAddon();	
						}
						$addonObj = $this->_em->find('Entity\Addon', $ac->id);						
						if(is_object($addonObj) && $ac->quantity){
				//					log_message('Error',$poaId.'addon added');
							$itemCost = $itemCost + $ac->totalCost;
							$poa->setAddonId($addonObj);	
							$poa->setCount($ac->quantity);
							$this->_em->persist($poa);
							$placeOrder->addTempOrderAddon($poa);
									//$this->_em->persist($placeOrder);
						}else{
									//die('addon');
						}
					}else{
						if(property_exists($ac,'poaId')){
							$poaId = $ac->poaId;
							$poa = $this->_em->find('Entity\TempOrderAddon',$poaId);
							if(is_object($poa))
								$this->_em->remove($poa);
							log_message('Error',$poaId.'addon removed');
						}elseif(array_key_exists($ac->id, $existingAddons)){
							$poa = $existingAddons[$ac->id];
							if(is_object($poa))
								$this->_em->remove($poa);
							log_message('Error',$poaId.'addon removed');
						}
					}
				}
			}
			$subTotal = $subTotal +$itemCost;
			$placeOrder->setCost($itemCost);
			$this->_em->persist($placeOrder);
			$this->_em->flush();	
			die();
		} }
		public function editorderitem(){
			$input = file_get_contents("php://input");
			$id = json_decode($input);
			if($id){
				$this->_em = $this->doctrine->em;
				$tempOrder = $this->_em->find('Entity\TempOrder',$id);
				$order = array();
				$order['id'] 			= $tempOrder->getId();
				$order['service'] 		= $tempOrder->getServiceId()->getId();
				$order['itemtype'] 		= $itype_id = $tempOrder->getItemId()->getItemTypeId()->getId();
				$order['pitem'] 		= $tempOrder->getItemId()->getId();
				$order['icount'] 		= $tempOrder->getIcount();
				$order['orderId'] 		= $tempOrder->getOrderId();
				$order['customerId'] 	= $tempOrder->getCustomerId()->getId();
				$items = $tempOrder->getServiceId()->getItemTypeItems($itype_id);
				$ritems = array();
				foreach ($items as $key => $value) {
					if($value['id']==$tempOrder->getItemId()->getId()){
						$value['selected'] = true;
					}
					$ritems[] = $value;
				}
				$order['items']	 = $ritems;
				$addons = $tempOrder->getServiceId()->getStatusAddons();
				$tas =  array(); 
				foreach($tempOrder->getTempOrderAddons() as $key => $value) {
					$tas[$value->getAddonId()->getId()] = $value;
				}
				$raddons = array();
				foreach ($addons as $key => $value) {
					$addon = array();
					$addonId 			= $addon['id'] 			= $value['id'];
					$addon['name'] 		= $value['name'];
					$cost 				= $addon['cost'] 		= $value['cost'];
					if(array_key_exists($addonId, $tas)){
						$addon['selected'] 	= true;
						$quantity 			= $addon['quantity'] 	= $tas[$addonId]->getCount();
						$addon['totalCost'] = $quantity*$cost;
						$addon['poaId'] = $tas[$addonId]->getId();
					}else{
						$addon['selected'] 	= false;
						$quantity 			= 0;
						$addon['totalCost'] = 0;
						$addon['poaId'] 	= 0;
					}
					$raddons[] = $addon;
				}
				$order['addons'] 	= $raddons;
				echo json_encode($order);
				die();
			}	
		}
		// GET PRE ORDER 
		public function getpreorder(){
			$input = file_get_contents("php://input");
			$data = json_decode($input);
			$customerId =0;
			if(property_exists($data, 'customerId'))
				$customerId = $data->customerId;
			$this->_em = $this->doctrine->em;
			$qb = $this->_em->createQueryBuilder();
			if(property_exists($data, 'orderId') && $data->orderId){
				$orderId = $data->orderId;
				$orderObj = $qb->select('po')->from('Entity\TempOrder','po')->where('po.order_id=:orderId and po.cust_id=:cust_id')->setParameter('orderId',$orderId)->setParameter('cust_id',$customerId)->getQuery()->getResult();
			}else{
				$orderObj = $qb->select('po')->from('Entity\TempOrder','po')->where('po.cust_id=:cust_id')->setParameter('cust_id',$customerId)->getQuery()->getResult();
			}
			$this->load->database();
			$date = date('Y-m-d');
			$mq = "select discountPercent from customers where DATE(discountExpiry) >= DATE('$date') and cust_id = '$customerId'";            
			$query = $this->db->query($mq);
			$empObj = $query->result();
			$orders =  array();
			foreach ($orderObj as $key => $value) {
				$order = array();
				$order['id'] 	= $value->getId();
				$s = array();
				$s['id'] 	= $value->getServiceId()->getId();
				$s['name'] 	= $value->getServiceId()->getName();
				$order['service_id'] = $s;
				$i = array();
				$i['id'] 	= $value->getItemId()->getId();
				$i['name']  = $value->getItemId()->getItemTypeId()->getName().'-'.$value->getItemId()->getName();
				$i['itype_id']  = $value->getItemId()->getItemTypeId()->getId();
				$order['item_id']= $i;
				$addons = array();
				foreach ($value->getTempOrderAddons() as $k => $v){
					$a = array();
					$a['poaId'] 	= $v->getId();
					$a['id'] 		= $v->getAddonId()->getId();
					$a['name'] 		= $v->getAddonId()->getName();
					$a['acount'] 	= $v->getCount();
					$addons[] 		= $a;
				}
				$order['addons'] 	= $addons;
				$order['icount']	= $value->getIcount();
				$order['cost'] 		= $value->getCost(); 
				$order['rpoints'] 	= $value->getRpoints(); 
			//$order['defaultDiscount'] = $empObj[0]->discountPercent;
				$orders[] = $order;
			}
			echo json_encode($orders);
			die();
		}
		public function trashtemporder(){
			$id = file_get_contents('php://input');
			if($id){
				$this->_em = $this->doctrine->em;
				$to = $this->_em->find('Entity\TempOrder',$id);
				foreach ($to->getTempOrderAddons() as $key => $value) {
					$this->_em->remove($value);
				}
				$this->_em->remove($to);
				$this->_em->flush();
				$c = array('customerId'=>$to->getCustomerId()->getId());
				echo json_encode($c);
				die();
			}
		}
	// order spliting 
		private function doOrder($result, $addressObj, $customerObj, $storeCode='cbs', $myObj, $so, $oldOrderId){	
			$this->_em = $this->doctrine->em;
			$n = rand(1001,9999);
			$orderId 	= $storeCode.'-'.$so.'-S-'.date('dmY').'-'.$n;
			$rrpoints = 0; $subTotal = 0; $totalAmount = 0;
			$isEditOrder = true;
			try{
				$placeOrderId = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('order_id'=>$oldOrderId));
				if(!is_object($placeOrderId)){
					$placeOrderId = new \Entity\PlaceOrderId();
					$placeOrderId->setOrderId($orderId);
					$placeOrderId->setOrderDate($myObj->orderDate);
					$placeOrderId->setAddressId($addressObj);
					$placeOrderId->setOrdSrc($myObj->ordSrc);
					$isEditOrder = false;
				}
				$totalItems = 0; 
				foreach($result as $data){ 
					log_message('error','loop started ');
					$itemCost 		=0;
					$itemId 			= $data->item_id->id;
					$serviceId 		= $data->service_id->id;						
						//$customerId = $data->custId;
					$icount 			= $data->icount;
						//$addons 		= $data->addons; 
					$cost					= $data->cost;
					$rpoints			= $data->rpoints;						
					$itemCost   	= $cost;
					$totalItems += $icount;
					$placeOrder = new \Entity\PlaceOrder();						
					$item = $this->_em->find('Entity\Item',$itemId);
					$service = $this->_em->find('Entity\Service',$serviceId);
					$placeOrder->setItemId($item);
					$placeOrder->setServiceId($service);
					$placeOrder->setCustomerId($customerObj);						
					$placeOrder->setOrderId($placeOrderId->getOrderId());			
					$placeOrder->setIcount($icount);
					$placeOrder->setRpoints($rpoints);
					if(property_exists($data,'addons')){
						$addons = $data->addons;
						foreach($addons as $ak => $av){
							$poa = new Entity\PlaceOrderAddon();								
							if($av->id){
								$addonObj = $this->_em->find('Entity\Addon', $av->id);						
								if(is_object($addonObj)){
									$poa->setAddonId($addonObj);	
									$poa->setCount($av->acount);
									$this->_em->persist($poa);	
									$placeOrder->addPlaceOrderAddon($poa);
								}
							}
						}
					}
					$rrpoints +=$rpoints;
					$subTotal += $itemCost;
						//log_message('Error',$subTotal);
					$placeOrder->setCost($itemCost);
					$this->_em->persist($placeOrder);
					$this->_em->flush();		
					try{
						$tempid = $data->id;
						if($tempid){
							$tempObj = $this->_em->find('Entity\TempOrder',$tempid);
							if($tempObj){
								foreach ($tempObj->getTempOrderAddons() as $key => $value) {
									$this->_em->remove($value);
								}
								$this->_em->remove($tempObj);
							}
						}else{
							die('id not found');
						}
					}catch(Exception $e){
						die($e->getMessage());
					}
					log_message('error','loop end ');
				}
				$ss = $this->_em->getRepository('Entity\Settings')->findOneById(1);
				$serviceTax 	= 0;
				$isServiceTax = $addressObj->getAreaId()->getIsServiceTax();
				if(is_object($ss) && $isServiceTax){
					$refPoints = $ss->getRefPoints();
					$serviceTax = $ss->getServiceCharge();
					$serviceCharge = $subTotal*$serviceTax/100;
				}else{
					$serviceCharge = 0; 	
				}
				$totalAmount = $subTotal + $serviceCharge;	
				$qdTotalAmount= 0;
				if(property_exists($myObj, 'qd') && $myObj->qd){
					$qdPercent 	= number_format(floatval($myObj->qdPercent),2);
					$qdTotalAmount 	= $totalAmount*($myObj->qdPercent/100);
					$totalAmount 		= $totalAmount + $qdTotalAmount; 					
					$placeOrderId->setQdAmount($qdTotalAmount);
					$placeOrderId->setQdPercent($qdPercent);
					$placeOrderId->setQd(1);
				}else{
					$placeOrderId->setQd(0);
					$placeOrderId->setQdAmount(0);
				}
				$adminDiscount = 0;
				$adminDiscountAmount = 0; 
				if($customerObj){
					$custId = $customerObj->getId();
					$this->load->database();						
					$date = date('Y-m-d');
					$mq = "select discountPercent from customers where DATE(discountExpiry) >= DATE('$date') and cust_id = '$custId'";            
					$query = $this->db->query($mq);
					$empObj = $query->result();
					$defaultDis = 0;
					if($empObj){
						$defaultDis = $empObj[0]->discountPercent;
					}
				}
				if($defaultDis>0){
					$discount = $defaultDis;								
					$defaultDiscountAmount = number_format(floatval(($discount*$totalAmount)/100),2,'.','');
					$defaultDiscount = number_format($discount,2,'.','');
					$totalAmount = $totalAmount - $defaultDiscountAmount;
					$adminDiscount 				= $defaultDiscount;
					$adminDiscountAmount 	= $defaultDiscountAmount;
				}else{
					$vendorDiscount = 0;		$vendorDiscountAmount = 0;
					$couponDiscount = 0;		$couponDiscountAmount = 0;
					/* Vendor Discount Start */
					if($customerObj){
						$custId = $customerObj->getId();
						$this->load->database();						
						$date = date('Y-m-d');
						$vq = "select vendorId from customers where cust_id = '$custId'";
						$query = $this->db->query($vq);
						$vdObj = $query->result();
						$vid = $vdObj[0]->vendorId;
						if($vid){
							$date = date('Y-m-d');
							$vid = $vdObj[0]->vendorId;
							$dq = "select discountPercent from vendors where DATE(discountExpiry) >= DATE('$date') and vendor_id = '$vid' and status = '1'";            
							$query = $this->db->query($dq);
							$disObj = $query->result();
							if($disObj){							
								$discount = $disObj[0]->discountPercent;
								$vendorDiscountAmount = number_format(floatval(($discount*$totalAmount)/100),2,'.','');
								$vendorDiscount = number_format($discount,2,'.','');
								$totalAmount = $totalAmount - $vendorDiscountAmount;
								$placeOrderId->setVendorId($vid);
							}
						}
					}
					/* Vendor Discount End */
					/* Coupon Discount Start */
					if($myObj->couponCode){	
						$couponCost = 0;	
						$couponCode = $myObj->couponCode;		
						$couponCodeObj = $this->_em->getRepository('Entity\Coupon')->findOneBy(array('code'=>$couponCode));
						if(is_object($couponCodeObj)){
							$today = new \DateTime('today');
							if(($couponCodeObj->getStartDate()<=$today && $couponCodeObj->getExpDate()>=$today)){
								$couponCost 			= $couponCodeObj->getCost();
								$couponCount 			= $couponCodeObj->getCount();
								$minOrderVal 			= $couponCodeObj->getMinOrdVal();
								$orderCouponcode 	= $placeOrderId->getCouponCode();
								$couponDiscountAmount = 0; $couponDiscount = 0;
								if(($couponCount>0) && ($totalAmount>=$minOrderVal)){
									$couponDiscountAmount = number_format(floatval(($couponCost*$totalAmount)/100),2,'.','');
									$couponDiscount = number_format($couponCost,2,'.','');
									$totalAmount = $totalAmount - $couponDiscountAmount;
									if ($couponCode == $orderCouponcode) {
									}else{
										$couponCnt = $couponCount - 1 ;
										$couponCodeObj->setCount($couponCnt);
										$placeOrderId->setCouponCode($couponCode);
									}
								}else{
									$totalAmount = $totalAmount ;
								}								
							}
						}
					}
						// else{
						// 	$couponDiscountAmount = 0; $couponDiscount = 0;
						// 	if($myObj->adminDiscountAmount){
						// 		$couponDiscountAmount 	= number_format($myObj->adminDiscountAmount,2,'.','');
						// 		$couponDiscount 		= number_format(floatval(($myObj->adminDiscountAmount/$totalAmount)*100),2,'.','');
						// 		$totalAmount = $totalAmount - $couponDiscountAmount;
						// 	}
						// }
					/* Coupon Discount End */	
						// else{
						// 	if($so!='SI'){
						// 		$adminDiscountAmount = number_format($myObj->adminDiscountAmount,2,'.','');
						// 		$adminDiscount = number_format(floatval(($myObj->adminDiscountAmount/$totalAmount)*100),2,'.','');
						// 		$totalAmount = $totalAmount - $myObj->adminDiscountAmount;
						// 	}
						// }
					if($serviceTax>0){
						$adminDiscount 			= 100 - (($totalAmount/($subTotal+$qdTotalAmount))*100)+$serviceTax;
					}else{
						$adminDiscount 			= 100 - (($totalAmount/($subTotal+$qdTotalAmount))*100);
					}
							
					//$adminDiscount 			= $vendorDiscount + $couponDiscount;
					$adminDiscountAmount 	= $vendorDiscountAmount + $couponDiscountAmount;	
				}		
				$paidAmount = (int)$placeOrderId->getPaidAmount();
				log_message('error', $paidAmount);
				$balanceAmount = $totalAmount - $paidAmount;	
				if(is_object($customerObj)){
					$totalAmount = number_format($totalAmount,2,'.','');
					$balanceAmount = number_format($balanceAmount,2,'.','');
					$subTotal = number_format($subTotal,2,'.','');
					$serviceCharge = number_format($serviceCharge,2,'.','');						
					$placeOrderId->setSubtotal($subTotal);
					$placeOrderId->setServiceTax($serviceCharge);
					$placeOrderId->setTotalAmount($totalAmount);
					$placeOrderId->setRPointsUsed(0.00);
					$placeOrderId->setTotalItems($totalItems);
					$placeOrderId->setBalanceAmount($balanceAmount);
					$placeOrderId->setClosingBalance($totalAmount);
					$placeOrderId->setReFundAmount(0.00);						
					$placeOrderId->setAdminDiscount($adminDiscount);					
					$placeOrderId->setAdminDiscountAmount($adminDiscountAmount);
					$placeOrderId->setRedeemAmount(0.00);
					$placeOrderId->setDeliveryDate($myObj->deliveryDate);
					$placeOrderId->setOrdSrc($myObj->ordSrc);
					$placeOrderId->setIsPackageOrder($myObj->isPackageOrder);
					$od = $placeOrderId->getOrderDate(); 
					$dd = $placeOrderId->getDeliveryDate();
					$pdn = date_diff($dd, $od);
					$placeOrderId->setProcessDelayInDays($pdn->format('%a'));
					$placeOrderId->setCustomerId($customerObj);
					$placeOrderId->getCustomerId()->updateTrigger($placeOrderId->getCustomerId());
					$this->_em->persist($placeOrderId);						
						//$this->_em->refresh($placeOrderId->getCustomerId());
					$this->_em->flush();
					if($myObj->sms){
						$this->load->library('Sms','');
						$this->sms->sendSMS($placeOrderId,'store');
					}							
					return $orderId;
					log_message('error',' order completed '.$so);
				}else{
					log_message('error',' cust obj missed '.$so);
				}
			}catch(Exception $e){
				log_message('error',$e->getMessage());
				//$this->set_response($e->getMessage(), REST_Controller::HTTP_BAD_REQUEST);
			}
			return 1;
		}
	// Helper for calculating working days
		private function calcWorkingDays($fromDate, $days) {
			$t = $fromDate->getTimestamp();
	   // add 1 day to timestamp
			$addDay = 86400;
	    // loop for X days
			for($i=0; $i<$days; $i++){	        
	        // get what day it is next day
				$nextDay = date('w', ($t+$addDay));
	        // if it's Sunday get $i-1
				if($nextDay == 0) {
					$i--;
				}
	        // modify timestamp, add 1 day
				$t = $t+$addDay;
			}
			$fromDate->setTimestamp($t);
			return $fromDate;
		}
	// save order 	
		public function saveorder(){
			$input = file_get_contents("php://input");
			$result = json_decode($input);
			$customerObj = 0;$customerId=0; $mobile=0; $couponCode ='';
			$this->_em = $this->doctrine->em;
			if(property_exists($result,'customerId')){
				$customerId = $result->customerId;
				$customerObj = $this->_em->find('Entity\Customer',$customerId);
				if(is_object($customerObj) && is_object($customerObj->getApartmentId())){
					$storeCode = $customerObj->getApartmentId()->getCode();
				}elseif(is_object($customerObj) && is_object($areaObj= $customerObj->getAreaId())){
					$storeCode = $areaObj->getCode();
				}else{
					$storeCode = 'cbs';
				} 
			}
			$n = rand(1001,9999);
			$loId = 'S-'.date('dmY').'-'.$n;
			$orderId =0;
			if(property_exists($result, 'orderId') && $result->orderId){
				$orderId = $result->orderId;
				$preMainOrder = $this->_em->getRepository('Entity\PlaceOrder')->findBy(array('order_id'=>$orderId));
				foreach ($preMainOrder as $key => $value) {
				//$value->removePlaceOrderAddons();
					$this->_em->remove($value);
				//$this->_em->flush();
				}
				$placeOrderId = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('order_id'=>$orderId));
				if(!is_object($placeOrderId)){
					$placeOrderId = new \Entity\PlaceOrderId();	
				}
			}else{
				$placeOrderId = new \Entity\PlaceOrderId();	
			}
			if(is_object($customerObj)){
				$customerObj->setUpdatedAt(date('y'));
				if(is_object($customerObj->getApartmentId())){
					if(is_object($catalogId =$aprtObj->getCatalogId())){
						$catalogId = $apart->getCatalogId()->getId(); 
					}else{
						$cat = $this->_em->getRepository('Entity\Catalog')->findOneByName('default');
						$catalogId = $cat->getId();
					}
				}else{
					$cat = $this->_em->getRepository('Entity\Catalog')->findOneByName('default');
					$catalogId = $cat->getId();
				}
				try{
					$myObj = new stdClass();
					$orderCouponCode 	= $placeOrderId->getCouponCode();
					if(property_exists($result, 'couponCode')){
						$myObj->couponCode = $result->couponCode;
					}else if($orderCouponCode){
						$myObj->couponCode 	= $placeOrderId->getCouponCode();
					}else{
						$myObj->couponCode = false;
					}
					if(property_exists($result, 'sms') && $result->sms){
						$myObj->sms = true;
					}else{
						$myObj->sms = false;
					}
					if(property_exists($result, 'ordSrc') && $result->ordSrc){
						$myObj->ordSrc = $result->ordSrc;
					}
					if(property_exists($result, 'orderDate') && $orderDate = $result->orderDate){
						$currentTime=date("H:i", time());
						$orderDate="".$orderDate." ".$currentTime;
						$myObj->orderDate = date('Y-m-d H:i',strtotime($orderDate));
					}else{
						$myObj->orderDate = date('Y-m-d H:i');
					}
					if(property_exists($result, 'deliveryDate') && $deliveryDate = $result->deliveryDate){
				// if(property_exists($result, 'deliveryDate') && $result->deliveryDate &&
				// 	property_exists($result, 'qd') && $result->qd){
       // 	$deliveryDate = $result->deliveryDate;
     				//$deliveryDate ="".$deliveryDate; 
						$d = date('d',strtotime($deliveryDate));
						$m = date('m',strtotime($deliveryDate));
						$y = date('Y',strtotime($deliveryDate));
						$mddate = mktime(18, 30, 00, $m, $d, $y); 
						$myObj->deliveryDate = date('Y-m-d h:m a', $mddate); 
					}else{
					//$myObj->deliveryDate = date('Y-m-d');
						$date_temp = $this->calcWorkingDays(new DateTime(), 4);
						$myObj->deliveryDate =  $date_temp->format('Y-m-d h:m a');
					}
					if(property_exists($result, 'adminDiscountAmount') && $result->adminDiscountAmount){
						$myObj->adminDiscountAmount = $result->adminDiscountAmount;
					}else{
						$myObj->adminDiscountAmount = 0;
					}
					if(property_exists($result, 'qd') && property_exists($result, 'qdPercent')){
						$qdp = $result->qdPercent;
						if($qdp != 0){
							$myObj->qd	= (int)$result->qd;
						}
					}
					if(property_exists($result, 'qdPercent')){
						$myObj->qdPercent	= $result->qdPercent;
					}else{
						$myObj->qdPercent	= 0;
					}
			   	//if(property_exists($result, 'addressId') && $addressId = $result->addressId){
					if(1){
						$addressObj =$customerObj->getCustomerAddress();
						if(is_object($addressObj)){
							$myObj->isServiceTax = $addressObj->getAreaId()->getIsServiceTax();
						}
					}
				// get package details 
					log_message('error','package start');
					if($customerObj->getPackageStatus()){
						log_message('error','package entered');
						$packageDetailsObj = $customerObj->getPackageDetails();
						$packageUDetailsObj = $customerObj->getPackageUsedDetails();
						$packageDetails = json_decode($packageDetailsObj,true);
						$packageUDetails = json_decode($packageUDetailsObj,true);
					//print_r($packageDetails); 
						$packageFlag = true;
						$usedPackageDetails = array('items'=>array(), 'addons'=>array());
					}else{
						$packageFlag = false;
					}
					$steamIronOrders = array(); $normalOrders = array();
					$addonsSource = array();
					foreach($result->temporders as $key=> $data){
						$serviceId 	= $data->service_id->id;
						log_message('error','pakcage flag t/f'.$packageFlag);
						if($packageFlag){
							// addons source counting
							foreach ($data->addons as $ak => $av) {
								if(array_key_exists($av->name,$addonsSource)){
									$addonsSource[$av->id] = $addonsSource[$av->id] + $av->acount;
								}else{
									$addonsSource[$av->id] = $av->acount;
								}
							}
							$itemId 	= $data->item_id->id;
							$itypeId 	= $data->item_id->itype_id;
							$icount 	= $data->icount;
							log_message('error','pakcage item'.$itypeId.'-'.$itemId.'-'.$icount);
							// items condition
							// check key is exist or not
							if(!array_key_exists($serviceId.'-'.$itypeId.'-'.$itemId, $packageDetails['items'])){
								// key not exist
								$packageFlag = false;
							} else {
								// package key exist
								// key exis in used details 
								if(array_key_exists($serviceId.'-'.$itypeId.'-'.$itemId, $packageUDetails['items'])){
									// package item - used item - item count>=0 
									if($packageDetails['items'][$serviceId.'-'.$itypeId.'-'.$itemId] - $packageUDetails['items'][$serviceId.'-'.$itypeId.'-'.$itemId] - $icount>=0){
										// re storing used details
										$packageUDetails['items'][$serviceId.'-'.$itypeId.'-'.$itemId] 
										= $packageUDetails['items'][$serviceId.'-'.$itypeId.'-'.$itemId] + $icount;
									}else{
										// condition fails
										$packageFlag = false;
									}
								}else{
									// used key not exist 
									// package item - item count >=0
									if($packageDetails['items'][$serviceId.'-'.$itypeId.'-'.$itemId] - $icount >=0){
										// storing used details
										$packageUDetails['items'][$serviceId.'-'.$itypeId.'-'.$itemId] = $packageDetails['items'][$serviceId.'-'.$itypeId.'-'.$itemId] - $icount;
									}else{
										// condition fails
										$packageFlag = false;
									}
									log_message('error','pakcage cost'.$packageUDetails['items'][$serviceId.'-'.$itypeId.'-'.$itemId]);
								}
							}
						}
						if($serviceId==1){
							$steamIronOrders[] = $data;
						}else{
							$normalOrders[] = $data;
							log_message('error','this is normal order ');
						}
					} // close temp orders for loop
					foreach ($addonsSource as $ak => $av) {
						if(array_key_exists($ak, $packageDetails['addons'])){
							if(array_key_exists($ak, $packageUDetails['addons'])){
								if($packageDetails['addons'][$ak] - $packageUDetails['addons'][$ak] - $av>=0){
									$packageUDetails['addons'][$ak] = $packageUDetails['addons'][$ak] + $av;
								}else{
									$packageFlag = false;
								}
							}else{
								if($packageDetails['addons'][$ak] - $av>=0){
								// storing used details
									$packageUDetails['addons'][$ak] = $packageDetails['addons'][$ak] - $av;
								}else{ // condition fails
									$packageFlag = false;
								}
							}
						}else{
							$packageFlag = false;
						}
					}
					if($packageFlag){
						$myObj->isPackageOrder = 1; 
						$pd = json_encode($packageUDetails);
						$customerObj->setPackageUsedDetails($pd);
						$pcObj = new Entity\CustomerPackageDetails();
						$this->_em->persist($customerObj);
						$this->_em->flush();
					}else{
						$myObj->isPackageOrder = 0; 
						echo " package false ";
						log_message('error','  package false');
					}
					$nOrderId = 0; $siOrderId = 0;
					if(sizeof($normalOrders)){
						$nOrderId =	$this->doOrder($normalOrders, $addressObj, $customerObj, $storeCode, $myObj, 'WD', $orderId);
						//echo "normarl";
						log_message('error','this is normal order ');
					}
					if(sizeof($steamIronOrders)){
						$siOrderId = $this->doOrder($steamIronOrders,$addressObj, $customerObj, $storeCode, $myObj,'SI',$orderId);
						//echo "steam ";
						log_message('error','this is iron order ');
					}
					$rarray = array();
					$rarray['customerId'] 	= $customerId;
				//$rarray['orderId'] 		= $orderId;
					echo json_encode($rarray);
					die();
				}catch(Exception $c){
					log_message('error',$c->getMessage());
				}
			}else{
				log_message('error', ' customer id not coming ');
			}
		}
		public function editMainOrder(){
			$input = file_get_contents('php://input'); 
		//$data = json_decode($input);
			$orderId = $input;
			$this->_em = $this->doctrine->em;
			try{
				$tempObj = $this->_em->getRepository('Entity\TempOrder')->findOneBy(array('order_id'=>$orderId));
				if(!is_object($tempObj)){
					$mainOrderItems = $this->_em->getRepository('Entity\PlaceOrder')->findBy(array('order_id'=>$orderId));
					$customerId=0;
					foreach ($mainOrderItems as $key => $value) {
						$tempOrder = new Entity\TempOrder();
						$tempOrder->setServiceId($value->getServiceId());
						$tempOrder->setItemId($value->getItemId());
						$tempOrder->setOrderId($value->getOrderId());
						$orderId = $value->getOrderId();
						$tempOrder->setIcount($value->getIcount());
						$tempOrder->setCost($value->getCost());
						$tempOrder->setRpoints($value->getRpoints());
						$tempOrder->setCustomerId($value->getCustomerId());
						$customerId = $value->getCustomerId()->getId();
						foreach ($value->getPlaceOrderAddons() as $k => $v){
							$ta = new Entity\TempOrderAddon();
							$ta->setCount($v->getCount());
							$ta->setAddonId($v->getAddonId());
							$this->_em->persist($ta);
							$tempOrder->addTempOrderAddon($ta);
						}
						$this->_em->persist($tempOrder);
						$this->_em->flush();
					}
				}else{
            	//die("you have mis match orders with same order id.");
				}
				$tempObj = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('order_id'=>$orderId));
				if(is_object($tempObj)){
					$this->_em->persist($tempObj);
					$this->_em->flush();
					$rarray = array();
					$rarray['customerId'] 			= $tempObj->getCustomerId()->getId();
					$rarray['orderId'] 				= $orderId;
					$rarray['addressId'] 			= is_object($tempObj->getAddressId())?$tempObj->getAddressId()->getId():'';
			//$rarray['orderDate']    = is_object($tempObj->getOrderDate())?$tempObj->getOrderDate()->format('d-m-Y'):'';
					$rarray['orderDate'] 			= is_object($tempObj->getOrderDate())?$tempObj->getOrderDate()->format('d-m-Y'):'';
					$rarray['deliveryDate'] 		= is_object($tempObj->getDeliveryDate())?$tempObj->getDeliveryDate()->format('d-m-Y'):'';
			//$rarray['adminDiscount']		= (int)$tempObj->getAdminDiscount();
					$rarray['adminDiscountAmount'] 		= (float)$tempObj->getAdminDiscountAmount();
					$rarray['subTotal'] 			= $tempObj->getSubtotal();
					$rarray['totalAmount'] 			= $tempObj->getTotalAmount();
					$rarray['couponCode'] 			= $tempObj->getCouponCode();
					$rarray['ordSrc'] 				= $tempObj->getOrdSrc();
					$rarray['qd']  =$tempObj->getQd();
					$rarray['qdAmount']  =number_format(floatval($tempObj->getQdAmount()),2);
					$rarray['qdPercent']  =number_format(floatval($tempObj->getQdPercent()),2);
					echo json_encode($rarray);
					die();
				}
			}catch(Exception $e){
				echo $e->getMessage();
			}
		}
		public function mainOrderItems(){
			$input = file_get_contents('php://input'); 
		//$data = json_decode($input);
			$orderId = $input;
			$this->_em = $this->doctrine->em;
			try{
				$mainOrderItems = $this->_em->getRepository('Entity\PlaceOrder')->findBy(array('order_id'=>$orderId));
				$customerId=0;
				foreach ($mainOrderItems as $key => $value) {
					$order = array();
					$order['id'] 	= $value->getId();
					$s = array();
					$s['id'] 	= $value->getServiceId()->getId();
					$s['name'] 	= $value->getServiceId()->getName();
					$order['service_id'] = $s;
					$i = array();
					$i['id'] 	= $value->getItemId()->getId();
					$i['name']  = $value->getItemId()->getItemTypeId()->getName().'-'.$value->getItemId()->getName();
					$order['item_id']= $i;
					$addons = array();
					foreach ($value->getPlaceOrderAddons() as $k => $v){
						$a = array();
						$a['poaId'] 	= $v->getId();
						$a['id'] 		= $v->getAddonId()->getId();
						$a['name'] 		= $v->getAddonId()->getName();
						$a['acount'] 	= $v->getCount();
						$addons[] 		= $a;
					}
					$order['addons'] 	= $addons;
					$order['icount']	= $value->getIcount();
					$order['cost'] 		= $value->getCost(); 
					$order['rpoints'] 	= $value->getRpoints(); 
					$order['status'] 	= $value->getStatus(); 
					$orders[] = $order;
				}
				echo json_encode($orders);
				die();
			}catch(Exception $e){
				echo $e->getMessage();
				die();
			}		
		}
		public function orderslist(){
			$input = file_get_contents("php://input");
			$result = json_decode($input);
			$areaId = ''; 
			$fromDate = date('Y-m-d');
			$day1 = strtotime("+1 day");
			$toDate =  date('Y-m-d',$day1);
			if(property_exists($result, 'storeId')){
				$areaId = $result->storeId;
			}
			if(property_exists($result, 'fromDate') && $result->fromDate){
				$fromDate =$result->fromDate;
				$fromDate = $fromDate/1000;
				$fromDate = date("Y-m-d",$fromDate);
			}else{
			}
			if(property_exists($result, 'toDate') && $result->toDate){
				$toDate = $result->toDate;
				$toDate = ($toDate/1000)+86400;
				$toDate = date("Y-m-d",$toDate);
			}else{
			}
		// echo $fromDate;
		// echo "\n";
		// echo $toDate;
		// // echo $time;
		// die();
			$this->_em = $this->doctrine->em;
			$qb = $this->_em->createQueryBuilder();
			if($areaId){
				$orderObj = $qb->select('oids')->from('\Entity\PlaceOrderId','oids')->innerJoin('oids.address_id','Entity\CustomerAddress')->where('Entity\CustomerAddress.area_id=:areaId and oids.isDelete=0 and oids.orderDate>=:fromDate and oids.orderDate<=:toDate')->setParameter('areaId',$areaId)->setParameter('fromDate',$fromDate)->setParameter('toDate',$toDate)->orderBy('oids.id','desc')->getQuery()->getResult();
			//$orderObj = $qb->select('oids')->from('\Entity\PlaceOrderId','oids')->innerJoin('oids.address_id','Entity\CustomerAddress')->where('Entity\CustomerAddress.area_id=:areaId and oids.isDelete=0 and oids.orderDate>=:fromDate and oids.orderDate<=:toDate and (oids.balanceAmount>0 or oids.poStatus!=:poStatus)')->setParameter('areaId',$areaId)->setParameter('fromDate',$fromDate)->setParameter('poStatus','OD')->setParameter('toDate',$toDate)->orderBy('oids.id','desc')->getQuery()->getResult();
			}else{
				$orderObj = $qb->select('oids','Entity\Customer')->from('\Entity\PlaceOrderId','oids')->innerJoin('oids.customer_id','Entity\Customer')->where('oids.isDelete=0 and oids.orderDate>=:fromDate and oids.orderDate<=:toDate')->setParameter('fromDate',$fromDate)->setParameter('toDate',$toDate)->orderBy('oids.id','desc')->getQuery()->getResult(); 
		//	$orderObj = $qb->select('oids','Entity\Customer')->from('\Entity\PlaceOrderId','oids')->innerJoin('oids.customer_id','Entity\Customer')->where('oids.isDelete=0 and oids.orderDate>=:fromDate and oids.orderDate<=:toDate  and (oids.balanceAmount>=0 or oids.poStatus!=:poStatus)')->setParameter('fromDate',$fromDate)->setParameter('poStatus','OD')->setParameter('toDate',$toDate)->orderBy('oids.id','desc')->getQuery()->getResult(); 
			}
			$orders = array();
			foreach ($orderObj as $key => $value) {
				$order = array();
				$order['id'] 			= $value->getId();
				$order['order_id'] 		= $value->getOrderId();
				$order['customerId'] 	= $value->getCustomerId()->getId();
				$order['customerName'] 	= $value->getCustomerId()->getFirstName().' '.$value->getCustomerId()->getLastName();
				$order['wallet'] 		= $value->getCustomerId()->getWallet();
				$order['dueAmount'] 	= $value->getCustomerId()->getBalanceAmount();
				$order['subTotal'] 		= $value->getSubtotal(); 
				$order['totalAmount'] 	= $value->getTotalAmount();
				$order['redeemAmount'] 	= $value->getRedeemAmount();
				$order['paidAmount'] 	= number_format($value->getPaidAmount(),2,'.','');
				$order['reFundAmount'] 	= number_format($value->getReFundAmount(),2,'.','');
				$order['balanceAmount'] = number_format($value->getBalanceAmount(),2,'.','');
				$order['closingAmount'] = $value->getClosingAmount();
				$order['orderStatus'] 	= $value->getOrderStatus();
				$order['orderMessage'] 	= $value->getOrderStatusMessage();
				$order['adminDiscount'] = $value->getAdminDiscount();
				$order['adminDiscountAmount'] 	= $value->getAdminDiscountAmount();
				$order['qd']				= $value->getQd();
				$order['qdAmount']			= $value->getQdAmount();
				$order['qdPercent']			= $value->getQdPercent();
				$order['totalItems'] 		= $value->getTotalItems();
				$order['src'] 				= $value->getOrdSrc();
				$pbObj = $value->getPickupBoyId();
				if(is_object($pbObj)){
					$order['pbName'] = $pbObj->getName();
				}else{
					$order['pbName'] = '';
				}
				$dbObj = $value->getDeliveryBoyId();
				if(is_object($dbObj)){
					$order['dbName'] = $dbObj->getName();
				}else{
					$order['dbName'] = '';
				}
				$order['status'] 		= (boolean)$value->getStatus();
				$order['cuStatus'] 		= (boolean)$value->getCuStatus();
				$order['orderDate']		= (int)strtotime($value->getOrderDate()->format('Y-m-d H:i:s'))*1000;
			// echo $order['orderDate'];
			// echo "\n";
				if(is_object($value->getDeliveryDate()))
					$order['deliveryDate']		= (int)strtotime($value->getDeliveryDate()->format('Y-m-d H:i:s'))*1000;
				else
					$order['deliveryDate']		= '';	
				$orders[] = $order;
			}
			echo json_encode($orders); die();
		}
		public function deletedorderslist(){
			$input = file_get_contents("php://input");
			$result = json_decode($input);
			$areaId = $result;
			$this->_em = $this->doctrine->em;
			$qb = $this->_em->createQueryBuilder();
			if($areaId){
				$orderObj = $qb->select('oids')->from('\Entity\PlaceOrderId','oids')->innerJoin('oids.address_id','Entity\CustomerAddress')->where('Entity\CustomerAddress.area_id=:areaId and oids.isDelete=1')->setParameter('areaId',$areaId)->getQuery()->getResult();
			}else{
				$orderObj = $qb->select('oids','Entity\Customer')->from('\Entity\PlaceOrderId','oids')->innerJoin('oids.customer_id','Entity\Customer')->where('oids.isDelete=1')->getQuery()->getResult(); 
			}
			$orders = array();
			foreach ($orderObj as $key => $value) {
				$order = array();
				$order['id'] 			= $value->getId();
				$order['order_id'] 		= $value->getOrderId();
				$order['customerId'] 	= $value->getCustomerId()->getId();
				$order['customerName'] 	= $value->getCustomerId()->getFirstName().' '.$value->getCustomerId()->getLastName();
				$order['wallet'] 		= number_format($value->getCustomerId()->getWallet(),2,'.','');
				$order['totalAmount'] 	= $value->getTotalAmount();
				$order['redeemAmount'] 	= $value->getRedeemAmount();
				$order['paidAmount'] 	= $value->getPaidAmount();
				$order['reFundAmount'] 	= $value->getReFundAmount();
				$order['balanceAmount'] = $value->getBalanceAmount();
				$order['closingAmount'] = $value->getClosingAmount();
				$order['orderStatus'] 	= $value->getOrderStatus();
				$order['orderMessage'] 	= $value->getOrderStatusMessage();
				$order['adminDiscount'] = $value->getAdminDiscount();
				$order['adminDiscountAmount'] 	= $value->getAdminDiscountAmount();
				$pbObj = $value->getPickupBoyId();
				if(is_object($pbObj)){
					$order['pbName'] = $pbObj->getName();
				}else{
					$order['pbName'] = '';
				}
				$order['status'] 		= (boolean)$value->getStatus();
				$order['cuStatus'] 		= (boolean)$value->getCuStatus();
				$order['orderDate']		= (int)strtotime($value->getOrderDate()->format('Y-m-d H:i:s'))*1000;
				if(is_object($value->getDeliveryDate()))
					$order['deliveryDate']		= (int)strtotime($value->getDeliveryDate()->format('Y-m-d H:i:s'))*1000;
				else
					$order['deliveryDate']		= '';	
				$orders[] = $order;
			}
			echo json_encode($orders); die();
		}
		public function deleteOrder(){
			$input = file_get_contents("php://input");
			$data = json_decode($input);
			$this->_em = $this->doctrine->em;
			if(is_object($data)){
				if(property_exists($data, 'orderId') && $orderId = $data->orderId){
					$orderObj = $this->_em->getRepository('\Entity\PlaceOrderId')->findOneBy(array('order_id'=>$orderId));
					$orderStatusObj = $this->_em->getRepository('Entity\orderstatusdetails')->findOneBy(array('order_id'=>$orderId));
					$customerObj = $orderObj->getCustomerId();
					if($orderObj->getPaidAmount()>0){
						$netAmount = $orderObj->getPaidAmount() - $orderObj->getReFundAmount();
						if($orderObj->getIsDelete()){
							$customerObj->addWallet(-$netAmount);
						}else{
							$customerObj->addWallet($netAmount);
						}	
					}
					$orderObj->setIsDelete(!$orderObj->getIsDelete());
					if(is_object($orderStatusObj)){
						$orderStatusObj->setIsDelete(!$orderStatusObj->getIsDelete());
						$this->_em->persist($orderStatusObj);	
					}
					$this->_em->persist($orderObj);
					$this->_em->flush(); 
					if($orderObj->getIsDelete()){
						echo "order successfully deleted";
					}else{
						echo "order successfully get back";
					}
					die();
				}
			}
			echo "something went wrong";
			die();
		}
		public function orderidstatus(){
			$input = file_get_contents("php://input");
			$data = json_decode($input);
			$orderId = $data;
			$this->_em = $this->doctrine->em;
			if((int)$orderId){
				$order = $this->_em->find('\Entity\PlaceOrderId',(int)$orderId);
				$order->setStatus(!$order->getStatus());
				$this->_em->persist($order);
				$this->_em->flush(); die();
			}
			die();
		}
		public function makepayment(){
			$input = file_get_contents("php://input");
			$data = json_decode($input);
		//$totalAmount = $data->totalAmount;
		//$paidAmount = $data->paidAmount;
			if(property_exists($data, 'payingAmount') && $data->payingAmount){
				$payingAmount 		= $data->payingAmount;
			}
			if(property_exists($data, 'paymentType') && $data->paymentType){
				$paymentType 		= $data->paymentType;
			}
			if(property_exists($data, 'transactionNumber') && $data->transactionNumber){
				$transactionNumber 		= $data->transactionNumber;
			}else {
				$transactionNumber 		= '';
			}
			if(property_exists($data, 'paymentFeedback') && $data->paymentFeedback){
				$paymentFeedback 		= $data->paymentFeedback;
			}else {
				$paymentFeedback        = '';
			}
			if(property_exists($data, 'oid') && $data->oid){
				$orderId 		= $data->oid;
			}
		//$orderId = $data->oid;
			$this->_em = $this->doctrine->em;
			try{
				if((int)$orderId){
					$order = $this->_em->find('\Entity\PlaceOrderId',(int)$orderId);
					$wallet = $order->getCustomerId()->getWallet();
					$paidAmount   	= $order->getPaidAmount();
					$closingAmount 	= $order->getClosingBalance();
					$balanceAmount 	= $order->getBalanceAmount();
					$storeId 		= $order->getStoreId()->getId();
					$tusingAmount = 0;
					if($wallet>=0){
						$usingAmount 	=  $balanceAmount - $payingAmount - $wallet;
						$paymentAmount 	= $wallet + $paidAmount + $payingAmount;
					}else{
						$usingAmount 	= $balanceAmount - $payingAmount;
						$paymentAmount 	= $paidAmount + $payingAmount;
					}
					if($paymentAmount > $order->getClosingBalance()){
						$order->setPaidAmount($order->getClosingBalance());
						$tusingAmount   = $order->getClosingBalance();
					}else{
						$order->setPaidAmount($paymentAmount);
						$tusingAmount   = $paymentAmount;
					}
			/*	if($balanceAmount<0){
					$usedAmount  = $totalAmount-$paidAmount;
				}else{
					$usedAmount  = $payingAmount + $wallet;
				}
				*/
				$order->setPaymentType($paymentType);
				$order->setTransactionNumber($transactionNumber);
				$order->setPaymentFeedback($paymentFeedback);
				if($usingAmount<0){
					if($wallet>$balanceAmount){
						$order->setBalanceAmount(0);
						$wa=-($usingAmount);
						$order->getCustomerId()->setWallet($wa);
					}
					else{
						$order->setBalanceAmount(0);
						$wa = -($usingAmount);
						log_message('error',$wa);
						$order->getCustomerId()->setWallet($wa);
					}
				}else{
					$order->setBalanceAmount($usingAmount);
					$wa= 0;
					$order->getCustomerId()->setWallet($wa);
				}
				if(is_object($order)){
					$th = new Entity\TransactionHistory();
					$th->setOrderId($order->getOrderId());
					$th->setStoreId($storeId);				
					$th->setCustomerId($order->getCustomerId());
					$th->setPaidAmount($payingAmount);
					$th->setUsedAmount($tusingAmount);
					$th->setPaymentType($paymentType);
					$th->setTransactionNumber($transactionNumber);
					$th->setPaymentFeedback($paymentFeedback);
					$this->_em->persist($th);
					$this->load->library('Sms', $this->_em);
					$this->sms->paymentInfoSms($th);	
				}
				$this->_em->persist($order);
				$this->_em->flush(); die();
				$message =[ 'message' => 'Payment Successfull'];
				$this->response($message, REST_Controller::HTTP_ACCEPTABLE); 
			}
		}catch(Exception $e){
			die($e->getMessage());
		}
		die('no');
	}
	// public function makepayment(){
	// 	$input = file_get_contents("php://input");
	// 	$data = json_decode($input);
	// 	//$totalAmount = $data->totalAmount;
	// 	//$paidAmount = $data->paidAmount;
	// 	$payingAmount 		= $data->payingAmount;
	// 	$paymentType 		= $data->paymentType;
	// 	$transactionNumber 	= $data->transactionNumber;
	// 	$paymentFeedback    = $data->paymentFeedback;
	// 	$orderId = $data->oid;
	// 	$this->_em = $this->doctrine->em;
	// 	try{
	// 		if((int)$orderId){
	// 			$order = $this->_em->find('\Entity\PlaceOrderId',(int)$orderId);
	// 			$wallet = $order->getCustomerId()->getWallet();
	// 			$paidAmount   	= $order->getPaidAmount();
	// 			$closingAmount 	= $order->getClosingBalance();
	// 			$balanceAmount 	= $order->getBalanceAmount();
	// 			$tusingAmount = 0;
	// 			if($wallet>=0){
	// 				$usingAmount 	=  $balanceAmount - $payingAmount - $wallet;
	// 				$paymentAmount 	= $wallet + $paidAmount + $payingAmount;
	// 			}else{
	// 				$usingAmount 	= $balanceAmount - $payingAmount;
	// 				$paymentAmount 	= $paidAmount + $payingAmount;
	// 			}
	// 			if($paymentAmount > $order->getClosingBalance()){
	// 				$order->setPaidAmount($order->getClosingBalance());
	// 				$tusingAmount   = $order->getClosingBalance();
	// 			}else{
	// 				$order->setPaidAmount($paymentAmount);
	// 				$tusingAmount   = $paymentAmount;
	// 			}
	// 			if($balanceAmount<0){
	// 				$usedAmount  = $totalAmount-$paidAmount;
	// 			}else{
	// 				$usedAmount  = $payingAmount + $wallet;
	// 			}
	// 			$order->setPaymentType($paymentType);
	// 			$order->setTransactionNumber($transactionNumber);
	// 			$order->setPaymentFeedback($paymentFeedback);
	// 			if($usingAmount<0){
	// 				if($wallet>$balanceAmount){
	// 					$order->setBalanceAmount(0);
	// 					$wa=-($usingAmount);
	// 					$order->getCustomerId()->setWallet($wa);
	// 				}
	// 				else{
	// 					$order->setBalanceAmount(0);
	// 					$wa = -($usingAmount);
	// 					log_message('error',$wa);
	// 					$order->getCustomerId()->setWallet($wa);
	// 				}
	// 			}else{
	// 				$order->setBalanceAmount($usingAmount);
	// 				$wa= 0;
	// 				$order->getCustomerId()->setWallet($wa);
	// 			}
	// 			if(is_object($order)){
	// 				$th = new Entity\TransactionHistory();
	// 				$th->setOrderId($order->getOrderId());
	// 				$th->setCustomerId($order->getCustomerId());
	// 				$th->setPaidAmount($payingAmount);
	// 				$th->setUsedAmount($tusingAmount);
	// 				$th->setPaymentType($paymentType);
	// 				$th->setTransactionNumber($transactionNumber);
	// 				$th->setPaymentFeedback($paymentFeedback);
	// 				$this->_em->persist($th);
	// 				$this->load->library('Sms', $this->_em);
	// 				$this->sms->paymentInfoSms($th);	
	// 			}
	// 			$this->_em->persist($order);
	// 			$this->_em->flush(); die();
	// 		}
	// 	}catch(Exception $e){
	// 		die($e->getMessage());
	// 	}
	// 	die('no');
	// }
	public function getorder(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$orderId = $data;
		if((int)$orderId){
			$this->_em = $this->doctrine->em;
			$orderObj = $this->_em->find('\Entity\PlaceOrderId',(int)$orderId);
			$order = array();
			$order['id'] 					= $orderObj->getId();
			$order['orderId'] 				= $orderObj->getOrderId();
			$order['adminDiscount'] 		= $orderObj->getAdminDiscount();
			$order['address'] 				= $orderObj->getAddressId()->getAddress();
			$order['addressId'] 			= $orderObj->getAddressId()->getId();
			$order['totalAmount'] 			= $orderObj->getTotalAmount();	
			echo json_encode($order);
			die();
		}else{
			//echo json_encode('hi');
		}
		die();
	}
	public function getordersummary(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$orderId = $data; 
		if($orderId){
			$this->_em = $this->doctrine->em;
			$orderObj = $this->_em->getRepository('Entity\PlaceOrder')->findBy(array('order_id'=>$orderId));
			$ordersummary = array();
			foreach($orderObj as $o){
				$order = array();
				$order['id'] 					= $o->getId();
				$order['serviceId'] 			= $o->getServiceId()->getId();
				$order['itemId'] 				= $o->getItemId()->getId();
				$order['itemTypeId'] 			= $o->getItemId()->getItemTypeId()->getId();
				$order['icount'] 				= $o->getIcount();
				$order['cost'] 				    = $o->getCost();
				$orderAddons = $o->getPlaceOrderAddons();
				$addons = array();
				foreach($orderAddons as $oa){
					$addon = array();
					$addon['addon_id'] = $oa->getAddonId()->getId();
				//$addon['addon_name'] = $oa->getAddonId()->getName();
				//$addon['addon_price'] = $oa->getAddonId()->getPrice();
					$addon['addon_count'] = $oa->getCount();
					$addons[] = $addon;
				}
				$order['addons'] 	= $addons;
				$ordersummary[] = $order;
			}
			echo json_encode($ordersummary);
			die();
		}else{
			echo json_encode('hi');
		}
		die();
	}
}