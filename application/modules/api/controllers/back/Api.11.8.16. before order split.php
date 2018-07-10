<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Api extends REST_Controller {
   
   function __construct()
   {
    
		parent::__construct();	
	
        $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
		$this->methods['apartment_get']['limit'] = '10';
		$this->methods['itemtype_get']['limit'] = '10';
				
    }

/****************************************************/
/********* get apartments list **********************/
/****************************************************/

	public function apartments_get(){
				
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$apartments = $qb->select('a')->from('Entity\Apartment','a')->getQuery()->getArrayResult();
		$this->response($apartments, REST_Controller::HTTP_OK); 
	}
	
/****************************************************/
/************* get blocks list **********************/
/****************************************************/

	public function blocks_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$apartmentId = 0;
		if(property_exists($data,'apartmentId')){
			$apartmentId 		= $data->apartmentId;
		}
		
		if($apartmentId){
			$blocks = $qb->select('b')->from('Entity\Block','b')->innerJoin('b.apt_id','Entity\Apartment')->where('b.apt_id=:aptId')->setParameter('aptId',$apartmentId)->getQuery()->getArrayResult();
			$this->response($blocks, REST_Controller::HTTP_OK); 
		}else{
			$this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); 
		}
		
	}

/****************************************************/
/************* get blocks list **********************/
/****************************************************/
	
	public function blocks_put(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		if(!is_object($data))
			$data = new stdClass();
			
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		if(property_exists($data,'apartmentId'))	{
			$apartmentId 		= $data->apartmentId;	
		
		if($apartmentId){
			$blocks = $qb->select('b')->from('Entity\Block','b')->innerJoin('b.apt_id','Entity\Apartment')->where('b.apt_id=:aptId')->setParameter('aptId',$apartmentId)->getQuery()->getArrayResult();
			$this->response($blocks, REST_Controller::HTTP_OK); 
		}else{
			$blocks = $qb->select('b')->from('Entity\Block','b')->getQuery()->getArrayResult();
			$this->response($blocks, REST_Controller::HTTP_OK); 
			
		}
		}else{
			$this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); 
			
		}
		
	}

/****************************************************/
/**************** get flats list ********************/
/****************************************************/

	public function flats_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$blockId =0;
		if(property_exists($data,'blockId')){
			$blockId 		= $data->blockId;
		}
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		if($blockId){
			$flats = $qb->select('f.id as flat_id','f.name as name')->from('Entity\Flat','f')->innerJoin('f.block_id','Entity\Block')->where('f.block_id=:blockId')->setParameter('blockId',$blockId)->getQuery()->getArrayResult();
			$this->response($flats, REST_Controller::HTTP_OK); 
		}else{
			$this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); 
		}
		
	}


/****************************************************/
/************* get owner flats list *****************/
/****************************************************/

	public function ownerflats_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$customerId =0;
		if(property_exists($data,'customerId')){
			$customerId 		= $data->customerId;
		}
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		if($customerId){
			
			$ownerObj = $qb->select('c')->from('Entity\Customer','c')->innerJoin('c.flat_id','Entity\Flat')->where('c.owner_id =:ownerId')->setParameter('ownerId',$customerId)->getQuery()->getResult();
			
			$flats = array();
			foreach($ownerObj as $ow){
				$flat = array();
				$flat['flat_id'] = $ow->getFlatId()->getId();
				$flat['flat'] = $ow->getFlatId()->getName();
				$flat['block'] = $ow->getBlockId()->getName();
				$flat['apartment'] = $ow->getApartmentId()->getName();
				
				$flats['flats'] = $flat;
			}
			
			$this->response($flats, REST_Controller::HTTP_OK); 
		}else{
			$this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); 
		}
		
	}
	
/****************************************************/
/************* get flat profile  ********************/
/****************************************************/
	public function flat_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$flatId =0;
		if(property_exists($data,'flatId'))
		$flatId 		= $data->flatId;
	      
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		if($flatId){
			//$flats = $qb->select('f')->from('Entity\Flat','f')->innerJoin('f.block_id','Entity\Block')->where('f.id=:flatId')->setParameter('flatId',$flatId)->getQuery()->getArrayResult();
			
			$flats = $qb->select('f','Entity\Block','Entity\Apartment','Entity\Customer')->from('Entity\Flat','f')->innerJoin('f.block_id','Entity\Block')->innerJoin('Entity\Block.apt_id','Entity\Apartment')->leftJoin('f.customer','Entity\Customer')->where('f.id=:flatId')->setParameter('flatId',$flatId)->getQuery()->getArrayResult();
			if(sizeof($flats)){
				$flatObj = $flats[0];
				
				//print_r($flatObj); die();
				$flat['flat_id'] = $flatObj['id'];
				$flat['flat'] = $flatObj['name'];
				$flat['intercom'] = $flatObj['intercom'];
				$flat['eusn'] = $flatObj['eusn'];
				$flat['bhk'] = $flatObj['bhk'];
				$flat['size'] = $flatObj['size'];
				$flat['facing'] = $flatObj['facing'];
				$flat['readyToSale'] = $flatObj['readyToSale'];
				$flat['readyToOccupy'] = $flatObj['readyToOccupy'];
				$flat['salePrice'] = $flatObj['salePrice'];
				$flat['rentPrice'] = $flatObj['rentPrice'];
				$flat['nofpplStay'] = $flatObj['nofpplStay'];
				$flat['cntOneName'] = $flatObj['cntOneName'];
				$flat['cntOneMobile'] = $flatObj['cntOneMobile'];
				$flat['cntTwoName'] = $flatObj['cntTwoName'];
				$flat['cntTwoMobile'] = $flatObj['cntTwoMobile'];
				
				$flat['block'] = $flatObj['block_id']['name'];
				$flat['apartment'] = $flatObj['block_id']['apt_id']['name'];
				
				$familyHead='';
				
				foreach($flatObj['customer'] as $c){
					if($c['subType']=='tenant'){
							$familyHead = $c['firstname'].' '.$c['lastname'];
					}elseif($c['subType']=='owner'){
						$familyHead = $c['firstname'].' '.$c['lastname'];
					}else{
						//$familyHead = $c['firstname'].' '.$c['lastname'];
					}
					
				}
				
				$flat['familyHead'] = $familyHead;
				
				
				$this->response($flat, REST_Controller::HTTP_OK); 
			}else{
				$this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
			}	
		}else{
			$this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); 
		}
	}
	
/****************************************************/
/************* update flat profle *******************/
/****************************************************/
	public function flatupdate_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$flatId =0;
		$sale ='';
		$rent ='';
		if(property_exists($data,'flatId'))
			$flatId 		= $data->flatId;
	    if(property_exists($data,'sale'))
			$sale 		= $data->sale;
	    if(property_exists($data,'rent'))
			$rent 		= $data->rent;
	      
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		if($flatId){
			$flatObj = $this->_em->getRepository('Entity\Flat')->findOneById($flatId);
			
			if(is_object($flatObj)){
				
				$flatObj->setSale($sale);
				$flatObj->setRoccupy($rent);
				$this->_em->persist($flatObj);
				$this->_em->flush();
				
			}else{
				$message =[ 'message' => 'sorry your flat doesn\'t exits our database'];
				$this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 

			}
			
			
			$message =[ 'message' => 'Your Flat updated sucessfully'];
			$this->response($message, REST_Controller::HTTP_OK); 
			
		}else{
			$message =[ 'message' => 'Your un-authorized user.'];
			$this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); 
		}
	}

/****************************************************/
/************* get itme types  **********************/
/****************************************************/

	public function itemtypes_get(){
				
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$itemtype = $qb->select('a')->from('Entity\ItemType','a')->getQuery()->getArrayResult();
		$this->response($itemtype, REST_Controller::HTTP_OK); 
	}	
	
/****************************************************/
/************* get catelog items  *******************/
/****************************************************/	
	
	public function catalogitems_post(){
	
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		
	
		//		$custId 		= 8;
		//		$serviceId 		= 1;
		//		$itemTypeId 	= 1;
		
		$custId 		= $data->customerId; 
		//		$serviceId 		= $data->serviceId;
		//		$itypeId  		= $data->itemTypeId;
				
		//		$custId 		= $this->post('customerId'); //$data->customerId;
		//		$serviceId 		= (int)$this->post('serviceId'); // $data->serviceId;
		//		$itypeId  = (int)$this->post('itemTypeId'); //$data->itemTypeId;
		
		
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		
		if($custId){
		 $cust = $this->_em->find('Entity\Customer',$custId);
		 if(is_object($cust)){
			 if(is_object($cust->getApartmentId())){
				 $aptId = $cust->getApartmentId()->getId();
				 $userType = $cust->getUserType();
					if($aptId && $userType=='apartment')
						$apart = $this->_em->find('Entity\Apartment',$aptId);
						if(is_object($catalogId =$apart->getCatalogId()))
							$catalogId = $apart->getCatalogId()->getId(); 
						else{
							$cat = $this->_em->getRepository('Entity\Catalog')->findOneByName('default');
							//$cat = $this->_em->getRepository('Entity\Catalog');
							$catalogId = $cat->getId();
						};
					 }else{
						$cat = $this->_em->getRepository('Entity\Catalog')->findOneByName('default');
						$catalogId = $cat->getId();
				 	}
		
	//	$items = $qb->select('cp','Entity\Item','Entity\ItemType','Entity\Service')->from('Entity\CatalogPrice','cp')->leftJoin('cp.item_id','Entity\Item')->innerJoin('Entity\Item.itype_id','Entity\ItemType')->innerJoin('Entity\Item.service_id','Entity\Service')->where('cp.catalog_id = :catalogId')->setParameter('catalogId',$catalogId)->getQuery()->getArrayResult();
		
		$items = $qb->select('cp','Entity\Item','Entity\ItemType','Entity\Service')->from('Entity\CatalogPrice','cp')->innerJoin('cp.item_id','Entity\Item')->innerJoin('cp.itype_id','Entity\ItemType')->innerJoin('cp.service_id','Entity\Service')->where('cp.catalog_id = :catalogId and Entity\Item.status=:status')->setParameter('catalogId',$catalogId)->setParameter('status',1)->addOrderBy('Entity\Item.id','asc')->getQuery()->getArrayResult();

		//$items = $qb->select('Entity\Item','cp')->from('Entity\CatalogPrice','cp')->innerJoin('cp.item_id','Entity\Item')->where('cp.service_id = :serviceId and cp.itype_id=:itypeId and cp.catalog_id=:catalogId')->setParameters(array('serviceId'=>$serviceId,'itypeId'=>$itemTypeId,'catalogId'=>$catalogId))->getQuery()->getArrayResult();
		
		
		
								
		$catalogItems = array();
		foreach($items as $it){
		//	print_r($it);
			if(array_key_exists('item_id',$it)){
				if($it['item_id']['status']){
					$catalogItem = array();
					$catalogItem['item_id'] 		= $it['item_id']['id'];
					$catalogItem['item_name'] 		= $it['item_id']['name'];
					$catalogItem['item_image'] 		= $it['item_id']['image'];
					$catalogItem['item_cost'] 		= $it['cost'];
					$catalogItem['item_discount'] 	= $it['discount'];
					$catalogItem['item_rpoints'] 	= $it['rpoints'];
					$catalogItem['item_itype_id'] 	= $it['itype_id']['id'];
					$serviceId = $catalogItem['item_service_id'] = $it['service_id']['id'];
					if($serviceId){
						$serviceObj = $this->_em->find('Entity\Service',$serviceId); 
						if(is_object($serviceObj)){
							$addons = $serviceObj->getAddons();
						}
					}
					
					if(is_array($addons)){
						$catalogItem['item_addons'] = $addons;
					}
					$catalogItems[] = $catalogItem;
				}
			}
		}
		$this->response($catalogItems, REST_Controller::HTTP_OK); 
		 }else{
			 $message =[ 'message' => 'Your un-authorized user.'];
			 $this->response($message, REST_Controller::HTTP_UNAUTHORIZED); 
			}
		}else{
			$message =[ 'message' => 'Your un-authorized user.'];
			$this->response($message, REST_Controller::HTTP_UNAUTHORIZED); 
		}
	}
	
	/***************************************************/
	/***********  SERVICE ITEMS POST *******************/
	/***************************************************/
	
	public function serviceitems_post(){
	
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		
		if(!is_object($data))
		$data = new stdClass();
		
	
		//		$custId 		= 8;
		//		$serviceId 		= 1;
		//		$itemTypeId 	= 1;
		
		if(property_exists($data,'customerId'))	
		$custId 		= $data->customerId; 
		if(property_exists($data,'serviceId'))	
		$serviceId 		= $data->serviceId;
		//		$itypeId  		= $data->itemTypeId;
				
		//		$custId 		= $this->post('customerId'); //$data->customerId;
		//		$serviceId 		= (int)$this->post('serviceId'); // $data->serviceId;
		//		$itypeId  = (int)$this->post('itemTypeId'); //$data->itemTypeId;
				
		
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		
		if(isset($custId)){
		 $cust = $this->_em->find('Entity\Customer',$custId);
		 if(is_object($cust)){
			 if(is_object($cust->getApartmentId())){
				 $aptId = $cust->getApartmentId()->getId();
					if($aptId)
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
		
		
		$items = $qb->select('cp','Entity\Item','Entity\ItemType','Entity\Service')->from('Entity\CatalogPrice','cp')->innerJoin('cp.item_id','Entity\Item')->innerJoin('cp.itype_id','Entity\ItemType')->innerJoin('cp.service_id','Entity\Service')->where('cp.catalog_id = :catalogId and cp.service_id =:serviceId and Entity\Item.status=:status')->setParameter('catalogId',$catalogId)->setParameter('serviceId',$serviceId)->setParameter('status',1)->getQuery()->getArrayResult();
								
		$catalogItems = array();
		foreach($items as $it){
		//	print_r($it);
			if(array_key_exists('item_id',$it)){
				if($it['item_id']['status']){
					$catalogItem = array();
					$catalogItem['item_id'] 		= $it['item_id']['id'];
					$catalogItem['item_name'] 		= $it['item_id']['name'];
					$catalogItem['item_image'] 		= $it['item_id']['image'];
					$catalogItem['item_cost'] 		= $it['cost'];
					$catalogItem['item_discount'] 	= $it['discount'];
					$catalogItem['item_rpoints'] 	= $it['rpoints'];
					$catalogItem['item_itype_id'] 	= $it['itype_id']['id'];
					$serviceId = $catalogItem['item_service_id'] = $it['service_id']['id'];
					if($serviceId){
						$serviceObj = $this->_em->find('Entity\Service',$serviceId); 
						if(is_object($serviceObj)){
							$addons = $serviceObj->getAddons();
						}
					}
					
					if(is_array($addons)){
						$catalogItem['item_addons'] = $addons;
					}
					$catalogItems[] = $catalogItem;
				}
			}
		}
		$this->response($catalogItems, REST_Controller::HTTP_OK); 
		 }else{
			 $message =[ 'message' => 'Your un-authorized user.'];
			$this->response($message, REST_Controller::HTTP_UNAUTHORIZED); 
			}
		}else{
			$message =[ 'message' => 'Your un-authorized user.'];
			$this->response($message, REST_Controller::HTTP_UNAUTHORIZED); 
		}
	}
	
	public function catalog_put(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$custId 		= 8; //$data->custId;
		$aptId 			= 1; //$data->aptId;
		//$itemId 		= $data->itemId;
		$serviceId 		= $data->serviceId;
		$itemTypeId 	= $data->itemTypeId;
		
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$aprt = $this->_em->getRepository('Entity\Apartment')->findOneBy(array('id'=>$aptId));
		$catalogId = $aprt->getCatalogId()->getId();
		
		//		$cps = $qb->select('cp')->from('Entity\CatalogPrice','cp')->where('cp.catalog_id =:catalogId and cp.item_id =:itemId and cp.service_id =:serviceId and cp.itype_id=:itypeId')->setParameters(array('catalogId'=>$catalogId,'itemId'=>$itemId,'serviceId'=>$serviceId,'itypeId'=>$itemTypeId))->getQuery()->getResult();
		
		$cps = $qb->select('cp')->from('Entity\CatalogPrice','cp')->where('cp.catalog_id =:catalogId and cp.service_id =:serviceId and cp.itype_id=:itypeId')->setParameters(array('catalogId'=>$catalogId,'serviceId'=>$serviceId,'itypeId'=>$itemTypeId))->getQuery()->getResult();

		
		$data = ['cost'=>$cps[0]->getCost(),'discount'=>$cps[0]->getDiscount()];
		
		$this->response($data, REST_Controller::HTTP_OK); 
	}
	
	/***************************************************/
	/***********  PLACE ORDER IDS **********************/
	/***************************************************/
	
	public function placeorderids_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		if(!is_object($data))
		$data = new stdClass();

		if(property_exists($data,'customerId')){
				$customerId = $data->customerId;
				if($customerId){
					$this->_em = $this->doctrine->em;
					$qb = $this->_em->createQueryBuilder();
			
					$placeOrderIds = $qb->select('poi')->from('Entity\PlaceOrderId','poi')->where('poi.customer_id =:customerId')->setParameter('customerId',$customerId)->getQuery()->getArrayResult();

					$this->response($placeOrderIds, REST_Controller::HTTP_OK); 		
				}else{
			log_message('error',' must use customerId');	
					$message = ['message'=>'your not authorized '];
					$this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 			
				}

		}else{
			log_message('error','your customerId is your payload');
			$message = ['message'=>'your not authorized '];
			$this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 			
			
		}
			
	}
	
	/***************************************************/
	/***********  PLACE ORDER HISTORY  *****************/
	/***************************************************/
	public function placeorderhistory_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		if(!is_object($data))
		$data = new stdClass();
		
		if(property_exists($data,'orderId'))	
		$orderId = $data->orderId;
		if(isset($orderId)){
			$this->_em = $this->doctrine->em;
			$qb = $this->_em->createQueryBuilder();
			$qb2 = $this->_em->createQueryBuilder();
			
			
			$placeOrders = $qb->select('po','Entity\Item','Entity\ItemType','Entity\Service','Entity\PlaceOrderAddon','Entity\Addon')->from('Entity\PlaceOrder','po')->leftJoin('po.item_id','Entity\Item')->leftJoin('Entity\Item.itype_id','Entity\ItemType')->leftJoin('po.service_id','Entity\Service')->leftJoin('po.placeOrderAddons','Entity\PlaceOrderAddon')->leftJoin('Entity\PlaceOrderAddon.addon_id','Entity\Addon')->where('po.order_id =:orderId')->setParameter('orderId',$orderId)->getQuery()->getArrayResult();
			
			$orderHistory = $qb2->select('o')->from('Entity\PlaceOrderId','o')->where('o.order_id =:orderId')->setParameter('orderId',$orderId)->getQuery()->getArrayResult();
			
			
			$poa = array();
			foreach($placeOrders as $k => $v){
				$po =  array();
				
				$po['item_name'] 	= $v['item_id']['name'];
				$po['item_type'] 	= $v['item_id']['itype_id']['name'];;
				$po['item_service'] = $v['service_id']['name'];;
				$po['item_count'] 	= $v['icount'];
				
				
				$netCost = $itemCost = $v['cost'];
				$ads = array();
				foreach($v['placeOrderAddons'] as $ak => $av){
					$ad = array();
					$ad['addon_name'] = $av['addon_id']['name'];
					$ad['addon_cost'] = $av['addon_id']['price'];
					$ad['addon_count'] = $av['poa_count'];
					$ads[]  = $ad;
					$netCost = $netCost - $av['poa_count']*$av['addon_id']['price'];
				}

				$netCost = $netCost/$v['icount'];

				$po['item_cost'] 	= $netCost;
				
				$po['item_addons'] = $ads;
				$po['item_rpoints'] = $v['rpoints'];	
				$poa['items'][] = $po;
			}
			
			if(sizeof($orderHistory)){
				$poa['subTotal'] = $orderHistory[0]['subtotal'];
				$poa['serviceTax'] = $orderHistory[0]['serviceTax'];
				$poa['totalAmount'] = $orderHistory[0]['totalAmount'];
				$poa['rPointsUsed'] = $orderHistory[0]['rPointsUsed'];
				
			}
			
			$this->response($poa, REST_Controller::HTTP_OK); 				
			
		}else{
			$message = ['message'=>'your not authorized '];
			$this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 					
		}
	}
	
	/***************************************************/
	/*************  PLACE ORDER POST *******************/
	/***************************************************/
	public function placeorder_post(){
		$this->_em = $this->doctrine->em;
		$input = file_get_contents("php://input");
		$result = json_decode($input);
		
		if(!is_object($result))
		$result = new stdClass();
		
      	
 		$n = rand(101,999);
		$orderId 	= date('Ymdhi').$n;
		if(property_exists($result,'rrpoints'))	
		$rrpoints = $result->rrpoints;
		if(property_exists($result,'subtotal'))	
		$subtotal = $result->subtotal;
		if(property_exists($result,'vat'))	
		$vat = $result->vat;
		if(property_exists($result,'totalAmount'))	
		$totalAmount = $result->totalAmount;
		if(property_exists($result,'rPointsUsed'))	
		$rPointsUsed = $result->rPointsUsed;
		if(property_exists($result,'totalAmountPaid'))	
		$totalAmountPaid = $result->totalAmountPaid;
		$balanceAmount = $totalAmount - $totalAmountPaid;
		$address = 0;
		if(property_exists($result,'addressId'))	
		$address = (int)$result->addressId;
		
		try{

			$placeOrderId = new \Entity\PlaceOrderId();
			if($address){
				$addressId = $this->_em->getRepository('Entity\CustomerAddress')->findOneById($address);
				if(is_object($addressId))
					$placeOrderId->setAddressId($addressId);
			}
		 	else
			 	$addressId='';
					
			$placeOrderId->setOrderDate(date('Y-m-d H:i'));
				foreach($result->data as $data){
					$itemCost =0;
					$itemId 	= $data->itemId;
					$serviceId 	= $data->serviceId;
					$customerId = $data->custId;
					$icount 	= $data->icount;
					$addons 	= $data->addons; 
					$cost		= $data->cost;
					$rpoints	= $data->rpoints;
					
					$itemCost   = $cost*$icount;
					
					$placeOrder = new \Entity\PlaceOrder();
					
					$item = $this->_em->find('Entity\Item',$itemId);
					$service = $this->_em->find('Entity\Service',$serviceId);
					$cust = $this->_em->find('Entity\Customer',$customerId);
					
					$placeOrder->setItemId($item);
					$placeOrder->setServiceId($service);
					$placeOrder->setCustomerId($cust);
					$placeOrder->setOrderId($orderId);
					$placeOrder->setIcount($icount);
					$placeOrder->setRpoints($rpoints);
					 
					 foreach($addons as $ad){
						if($ad->acount){
							$poa = new Entity\PlaceOrderAddon();
							$addon = $this->_em->find('Entity\Addon',$ad->addon);
							$poa->setAddonId($addon);
							$poa->setCount($ad->acount);
							$itemCost = $itemCost + $ad->acount*$addon->getPrice(); 
							
							$placeOrder->addPlaceOrderAddon($poa);	
						}
						
					 }
					
					$placeOrder->setCost($itemCost);
					
					$this->_em->persist($placeOrder);
					$this->_em->flush();		
				}

		
				$ss = $this->_em->getRepository('Entity\Settings')->findOneById(1);
				if(is_object($ss)){
					$refPoints = $ss->getRefPoints();
				}else{
					$refPoints = 0;	
				}
		
		
				$cust = $this->_em->find('Entity\Customer',(int)$customerId);
				if($cust){
					$placeOrderId->setOrderId($orderId);
					$placeOrderId->setSubtotal($subtotal);
					$placeOrderId->setServiceTax($vat);
					$placeOrderId->setTotalAmount($totalAmount);
					$placeOrderId->setRPointsUsed($rPointsUsed);
					$placeOrderId->setPaidAmount($totalAmountPaid);
					$placeOrderId->setBalanceAmount($totalAmount);
					
					$placeOrderId->setAdminDiscount(0);
					$placeOrderId->setAdminDiscountAmount(0);

					$placeOrderId->setCustomerId($cust);
					$this->_em->persist($placeOrderId);

					$cust->setRpoints($rrpoints);
					$refId = $cust->getRefId();
					if($refId){
						$cust2 = $this->_em->getRepository('Entity\Customer')->findOneByEmail($refId);
						if(is_object($cust2) && $cust->getFirstOrder()){
							$cust2->addRpoints($refPoints);
							$this->_em->persist($cust2);
							$this->_em->flush();
						}				
					}else{
						log_message('error',' refrence id missed ');	
					}
					$cust->setFirstOrder(0);
					$this->_em->persist($cust);
					$this->_em->flush();

					$message =[ 'message' => 'Order Successfully Placed, Our Pickup boy reach you soon. Order Id :'.$orderId ];
					$this->set_response($message, REST_Controller::HTTP_CREATED);

				}
		
		}catch(Exception $e){
			
			$this->set_response($e->getMessage(), REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	
	public function placeorder_get(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		
		if(!is_object($data))
		$data = new stdClass();
		
		if(property_exists($data,'custId'))	
		$custId 	= $data->custId;
		$this->_em = $this->doctrine->em;
		
		
		
		//$this->_em->persist($cust);
		$this->_em->flush();	
		$message =[ 'message' => 'Order Successfully Placed, Our Pickup boy reach you soon' ];
		$this->set_response($message, REST_Controller::HTTP_CREATED);
	}
		
	public function services_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			try{
				$this->_em = $this->doctrine->em;
				$qb = $this->_em->createQueryBuilder();
				if(property_exists($data, 'areaId')){
					$areaId = $data->areaId;
					$areaId = $this->_em->find('Entity\Area',$areaId);
					if(is_object($areaId)){
						$services = $areaId->getServices();
					}else{
						$services = $qb->select('s')->from('Entity\Service','s')->where('s.status=:status')->setParameter('status',1)->getQuery()->getArrayResult();
					}
				}else{
					$services = $qb->select('s')->from('Entity\Service','s')->where('s.status=:status')->setParameter('status',1)->getQuery()->getArrayResult();	
				}
				
				$this->response($services, REST_Controller::HTTP_OK); 
			}catch(Exception $e){
				$this->set_response($e->getMessage(),REST_Controller::HTTP_BAD_REQUEST);	
			}
			
		}else{
			$message = ['message'=>'Something went wrong'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
		
	}
	
	public function areas_get(){
		
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$areas = $qb->select('a')->from('Entity\Area','a')->getQuery()->getArrayResult();
		$this->response($areas, REST_Controller::HTTP_OK); 
	}
	
	public function roles_get(){
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$roleObj = $qb->select('r')->from('Entity\Role','r')->getQuery()->getResult();
		$roles = array();
		foreach ($roleObj as $key => $obj) {
			$role = array();
			$role['id'] 	= $obj->getId();
			$role['name']	= $obj->getName();
			$roles['roles'][] = $role;
		}

		$this->response($roles, REST_Controller::HTTP_OK); 
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
		 
			$cust = $this->_em->getRepository('Entity\Customer')->findOneBy(array('mobile'=>$mobile));
			
			if(is_object($cust)){
				$cust1 = $this->_em->getRepository('Entity\Customer')->findOneBy(array('mobile'=>$mobile,'password'=>$password));
				
					if(is_object($cust1)){
						$cust2 = $this->_em->getRepository('Entity\Customer')->findOneBy(array('mobile'=>$mobile,'password'=>$password,'status'=>1));
						if(is_object($cust2)){
								$customerId = $cust2->getId();
				
								$oauth_id = $cust2->getOauthId();
								
								$custObj = $this->_em->find('Entity\Customer',$customerId);
								if(is_object($custObj)){
									$key = md5($this->getnewpwd());
									$custObj->setOauthId($key);
									$this->_em->persist($custObj);
									$this->_em->flush();
									$message =[ 'message' => 'Authentication successfull' ,'id'=>$customerId,'oauth_id'=>$key];
									$this->response($message, REST_Controller::HTTP_ACCEPTED); 
								}
						}else{
							$message =[ 'message' => ' please wait for your family head approval '];
							$this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 		
						}
					}else{
						$message =[ 'message' => 'in correct login details , please try again '];
						$this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 	
					}
			}else{
				$message =[ 'message' => 'you have no account, please register '];
				$this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 
			}
					 
		 
			//$cust = $qb->select('c.id as customerId, c.oauth_id as oauth_id')->from('Entity\Customer','c')->where('c.mobile =:mobile and c.password =:pwd and c.status =:status')->setParameter('mobile',$mobile)->setParameter('pwd',$password)->setParameter('status',1)->getQuery()->getArrayResult();
		
		
			if(count($cust)){
				//$customerId = sizeof($cust)?$cust[0]['customerId']:'';
				
				//$oauth_id = sizeof($cust)?$cust[0]['oauth_id']:'';
				
				$custObj = $this->_em->find('Entity\Customer',$customerId);
				if(is_object($custObj)){
					$key = md5($this->getnewpwd());
					$custObj->setOauthId($key);
					$areaId = is_object($custObj->getAreaId())?$custObj->getAreaId()->getId():0;
					$this->_em->persist($custObj);
					$this->_em->flush();
					$message =[ 'message' => 'Authentication successfull' ,'id'=>$customerId,'areaId'=>$areaId,'oauth_id'=>$key];
					$this->response($message, REST_Controller::HTTP_ACCEPTED); 
				}
				
			}else{
				$message =[ 'message' => 'Authentication failed try again later'];
				$this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 
			}
		}catch(Exception $e){
			$message =[ 'message' => 'Something wrong , pelase contact administrator '];
			$this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 
		}
				
		
	}
	
	/***************************************************/
	/***********  CUSTOMER REGISTRATION ****************/
	/***************************************************/
	
	public function registration_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
	
		if(!is_object($data))
		$data = new stdClass();
		
		$mobile ='';
		$userType 	= '';
		$cust = new Entity\Customer();
		$fname=''; $lname=''; $mobile='';
		if(property_exists($data,'firstName'))	
			$fname 		= $data->firstName;
			
		if(property_exists($data,'lastName'))	
			$lname 		= $data->lastName;
			if(property_exists($data,'email'))	
			$email 		= $data->email;
			if(property_exists($data,'mobile'))	
			$mobile 	= trim($data->mobile);
			if(property_exists($data,'password'))	
			$password 	= trim($data->password);
			
			if(property_exists($data,'apartment'))	
			$aprt		= $data->apartment;
			if(property_exists($data,'block'))	
			$block		= $data->block;
			if(property_exists($data,'flat'))	
			$flat		= $data->flat;
			if(property_exists($data,'refId'))	
			$refId		= $data->refId;
		
		
		$this->_em = $this->doctrine->em;
		
		
		
		
		$ss = $this->_em->getRepository('Entity\Settings')->findOneById(1);
		if(is_object($ss)){
		//	$refPoints = $ss->getRefPoints();
			$regPoints = $ss->getRegPoints();
		}else{
			//$refPoints = 0;
			$regPoints = 0;
		}
		if(isset($mobile)){
			$cust2 = $this->_em->getRepository('Entity\Customer')->findOneByMobile($mobile);
			if(is_object($cust2)){
			$message =[ 'message' =>'you already have account, please login.' ];
			$this->set_response($message, REST_Controller::HTTP_OK);
			return false;
		}}
		
		
		
		/*$cust2 = $this->_em->getRepository('Entity\Customer')->findOneByEmail($refId);
		if(is_object($cust2)){
			$cust2->addRpoints($refPoints);
			$this->_em->persist($cust2);
			$this->_em->flush();
		}*/
		
		$cust = new Entity\Customer();
		$cust->setFirstName($fname);
		$cust->setLastName($lname);
		$cust->setEmail($email);
		$cust->setPhoneNo($mobile);
		$cust->setRpoints($regPoints);
		$cust->setPassword($password);
		
	
		$cust->setRefId($refId);
		
		
		if(isset($aprt)){
			$apartment = $this->_em->find('Entity\Apartment',$aprt);
			if(is_object($apartment)){
				$cust->setApartmentId($apartment);
				$userType 	= 'apartment';
				$subType 	= 'family member';
				$cust->setUserType($userType);
				$cust->setSubType($subType);
				$cust->setStatus(0);	
			}else{
				$userType 	= 'user';
				$subType 	= '';
				$cust->setUserType($userType);
				$cust->setSubType($subType);
				$cust->setStatus(1);	
			}
		}else{
				$userType 	= 'user';
				$subType 	= '';
				$cust->setUserType($userType);
				$cust->setSubType($subType);
				$cust->setStatus(1);	
		}
		
		if(isset($block)){
			$blockId = $this->_em->find('Entity\Block',$block);
			if(is_object($blockId)){
				$cust->setBlockId($blockId);
			}
		}
		
		if(isset($flat)){
			$flatId = $this->_em->find('Entity\Flat',$flat);
			if(is_object($flatId)){
				$cust->setFlatId($flatId);
			}
		}
		
		$this->_em->persist($cust);
		$this->_em->flush();
		
		if($userType=='apartment'){
			$message =[ 'message' => 'You successfully registered, please wait for ' ];			
		}else{
			$message =[ 'message' => 'You successfully registered.' ];

		}
		$this->set_response($message, REST_Controller::HTTP_CREATED);
	}
	
	function settings_get(){
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$settings = $qb->select('s')->from('Entity\Settings','s')->getQuery()->getArrayResult();
		$this->response($settings[0], REST_Controller::HTTP_OK); 
	}
	
	function getrpoints_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		if(!is_object($data))
		$data = new stdClass();
		
		$id=0;
		if(property_exists($data,'id'))	
		$id 		= $data->id;
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$cust = $qb->select('c.rpoints')->from('Entity\Customer','c')->where('c.id=:id')->setParameter('id',$id)->getQuery()->getArrayResult();
		$this->response($cust[0], REST_Controller::HTTP_OK);
	}

	/********************************************************/
	/************* CUSTOMER GET PROFILE ********************/
	/********************************************************/
	
	function getprofile_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		if(!is_object($data))
		$data = new stdClass();
		
		$id=0;
		if(property_exists($data,'id'))	
		$id 		= $data->id;
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		
		$cust = $qb->select('c.id','c.firstname','c.lastname','c.gender','c.email','c.whatsapp','c.dob','c.showInTele','c.facebook','c.isStaying','c.type','c.mobile','c.address','c.status','c.rpoints','c.ref_id','Entity\Apartment.id as apt_id','Entity\Block.id as block_id','Entity\Block.name as block','Entity\Flat.id as flat_id','Entity\Flat.name as flat')->from('Entity\Customer','c')->leftJoin('c.apt_id','Entity\Apartment')->leftJoin('c.block_id','Entity\Block')->leftJoin('c.flat_id','Entity\Flat')->where('c.id=:id')->setParameter('id',$id)->getQuery()->getArrayResult();
		
		if(isset($cust))
		$this->response($cust[0], REST_Controller::HTTP_OK);
		else
		$this->response(NULL, REST_Controller::HTTP_OK);
	}
	
	
	/********************************************************/
	/************* CUSTOMER UPDATE PROFILE ********************/
	/********************************************************/
	
	function updateprofile_post(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$id =0;
		if(property_exists($data,'id'))
		$id 		= $data->id;
		
		if((int)$id){
		
		$this->_em = $this->doctrine->em;
		$cust = $this->_em->getRepository('Entity\Customer')->findOneById($id);
		
		
		if(property_exists($data,'email')){
			$email 		= $data->email;
			$cust->setEmail($email);
		}
		if(property_exists($data,'gender')){
			$gender 		= $data->gender;
			$cust->setGender($gender);
		}
		if(property_exists($data,'isStaying')){
			$isStaying 		= $data->isStaying;
			$cust->setStaying($isStaying);
		}
		if(property_exists($data,'facebook')){
			$facebook 		= $data->facebook;
			$cust->setFacebook($facebook);
		}
		$nm = '';
		if(property_exists($data,'mobile')){
			$mobile 	= $data->mobile;
			
			$mobileObj = $this->_em->getRepository('Entity\Mobile')->findOneByMobile($mobile);
			if(is_object($mobileObj)){
				$nm = ' but mobile no already exists. it\'s not updated';
			}else{
				$nm = '';
			$cust->setPhoneNo($mobile);	
			}
			
		}
		if(property_exists($data,'rpoints')){
			$rpoints 	= $data->rpoints;
			$cust->setRpoints($rpoints);
		}
		if(property_exists($data,'userType')){
			$userType 	= $data->userType;
			$cust->setUserType($userType);
		}
		if(property_exists($data,'apartment')){
			$aprt		= $data->apartment;
			$aprtObj = $this->_em->getRepository('Entity\Apartment')->findOneById($aprt);
			//$cust->setApartmentId($aprtObj);
		}
		if(property_exists($data,'block')){
			$block		= $data->block;
			$blockObj = $this->_em->getRepository('Entity\Block')->findOneById($block);
			//$cust->setBlockId($blockObj);
		}
		
		if(property_exists($data,'flat')){
			$flat		= $data->flat;
			$flatObj = $this->_em->getRepository('Entity\Flat')->findOneById($flat);
			//$cust->setFlatId($flatObj);
		}
		
		
			if(property_exists($data,'firstName')){
				$fname 		= $data->firstName;	
				$cust->setFirstName($fname);
			}
			if(property_exists($data,'lastName')){
				$lname 		= $data->lastName;		
				$cust->setLastName($lname);
			}
			
			if(property_exists($data,'whatsapp')){
				$whatsapp 		= $data->whatsapp;
				$cust->setWhatsapp($whatsapp);
			}
			
			if(property_exists($data,'dob')){
				$dob 		= $data->dob;
				$cust->setDob($dob);
			}
			if(property_exists($data,'showInTele')){
				$showInTele 		= $data->showInTele;
				$cust->setShowInTele($showInTele);
			}
			
			$this->_em->persist($cust);
			$this->_em->flush();	
			$message =[ 'message' => 'resource updated '.$nm ];
			$this->set_response($message, REST_Controller::HTTP_OK);
		}else{
			$message =[ 'message' => ' your unauthorized person to update the data' ];
			$this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
		}
		
		
	}
	

	
	public function getaddress_post(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		if(!is_object($data))
		$data = new stdClass();
		
		$id=0;
		if(property_exists($data,'customerId'))	
		$id 		= $data->customerId;
		
		if((int)$id){
		
			$this->_em = $this->doctrine->em;
			$qb = $this->_em->createQueryBuilder();
			$custs = $qb->select('ca','Entity\Customer','Entity\Area')->from('Entity\CustomerAddress','ca')->leftJoin('ca.cust_id','Entity\Customer')->leftJoin('ca.area_id','Entity\Area')->where('ca.cust_id=:id')->setParameter('id',$id)->getQuery()->getArrayResult();
			$address = array();
			foreach($custs as $k=>$v){
				$ad =  array();
				$ad['address_id'] = $v['id'];
				$ad['address'] = $v['address'];
				$ad['landmark'] = $v['landmark'];
				$ad['pincode'] = $v['pincode'];
				$ad['area_id'] = $v['area_id']['id'];
				$ad['area'] = $v['area_id']['name'];
				$address[] = $ad;
			}
			if(empty($custs)){
				$msg = [];
				$this->response($msg, REST_Controller::HTTP_OK);					
			}
			$this->response($address, REST_Controller::HTTP_OK);
		}
	
		$msg = [];
		$this->response($msg, REST_Controller::HTTP_OK);			
	}
	
	public function postaddress_post(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		
		$id 		= '';
		$address 		= '';
		$landmark 		= '';
		$pincode 		= '';
		$areaId			= 0;
		
		if(property_exists($data,'customerId')){
			$id 		= $data->customerId;
		}
		if(property_exists($data,'address')){
			$address 		= $data->address;
		}
		if(property_exists($data,'landmark')){
			$landmark 		= $data->landmark;
		}
		if(property_exists($data,'pincode')){
			$pincode 		= $data->pincode;
		}
		if(property_exists($data,'areaId')){
			$areaId			= $data->areaId;
		}
		
		if((int)$id){
		
			$this->_em = $this->doctrine->em;
			
		    $customerId = $this->_em->find('Entity\Customer',$id);
			if(!is_object($customerId)){
				$msg = ['message'=>'Your not recognized to save your address'];
				$this->response($msg, REST_Controller::HTTP_OK);						
			}
			
			$areaObj = $this->_em->find('Entity\Area',$areaId);
			if(!is_object($areaObj)){
				$msg = ['message'=>'Your have not selected area'];
				$this->response($msg, REST_Controller::HTTP_OK);						
			}
			
			$ca = new Entity\CustomerAddress();
			$ca->setAddress($address);
			$ca->setLandmark($landmark);
			$ca->setPincode($pincode);
			$ca->setCustomerId($customerId);
			$ca->setAreaId($areaObj);
			$this->_em->persist($ca);
			$this->_em->flush();
		
			$msg = ['message'=>'Your address saved successfully Mr./Ms: '.$customerId->getFirstname()];
			$this->response($msg, REST_Controller::HTTP_OK);
		}
	
		$msg = ['message'=>'Your not recognized to save your address'];
		$this->response($msg, REST_Controller::HTTP_OK);			
	}
	
	
	public function updateaddress_post(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		if(!is_object($data))
		$data = new stdClass();
		
		$addressId 		= 0;
		$address 		= '';
		$landmark 		= '';
		$pincode 		= '';
		$areaId			= 0;
		
		if(property_exists($data,'addressId')){
			$addressId 		= $data->addressId;
		}
		if(property_exists($data,'address')){
			$address 		= $data->address;
		}
		if(property_exists($data,'landmark')){
			$landmark 		= $data->landmark;
		}
		if(property_exists($data,'pincode')){
			$pincode 		= $data->pincode;
		}
		if(property_exists($data,'areaId')){
			$areaId			= $data->areaId;
		}
		
		
		
		
		
		if((int)$addressId){
			$this->_em = $this->doctrine->em;
		    $ca = $this->_em->find('Entity\CustomerAddress',$addressId);
			if(!is_object($ca)){
				$msg = ['message'=>'Your not recognized to save your address'];
				$this->response($msg, REST_Controller::HTTP_NOT_ACCEPTABLE);						
			}
			
			$areaObj = $this->_em->find('Entity\Area',$areaId);
			if(!is_object($areaObj)){
				$msg = ['message'=>'Your have not selected area'];
				$this->response($msg, REST_Controller::HTTP_OK);						
			}
			
			$ca->setAddress($address);
			$ca->setLandmark($landmark);
			$ca->setPincode($pincode);
			$ca->setAreaId($areaObj);
			$this->_em->persist($ca);
			$this->_em->flush();
		
			$msg = ['message'=>'Your address suceessfully updated'];
			$this->response($msg, REST_Controller::HTTP_OK);
		}
	
		$msg = ['message'=>'Your not recognized to save your address'];
		$this->response($msg, REST_Controller::HTTP_NOT_ACCEPTABLE);			
	}

	public function trashAddress_post(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		if(!is_object($data))
		$data = new stdClass();
		
		if(property_exists($data,'addressId')){
			$addressId 		= $data->addressId;

			$this->_em = $this->doctrine->em;

			 $ca = $this->_em->find('Entity\CustomerAddress',$addressId);
			if(is_object($ca)){
				$ca->setStatus(0);
				$this->_em->persist($ca);
				$this->_em->flush();
			
				$msg = ['message'=>'Your address suceessfully updated'];
				$this->response($msg, REST_Controller::HTTP_OK);
			}else{
				$msg = ['message'=>'Your address not recognized '];
				$this->response($msg, REST_Controller::HTTP_NOT_ACCEPTABLE);
			}
		}else{
			$msg = ['message'=>'Your not recognized to save your address'];
			$this->response($msg, REST_Controller::HTTP_NOT_ACCEPTABLE);		
		}
	}
	
	public function forgotpwd_put(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$email 		= $data->email;

		$this->_em = $this->doctrine->em;

		if($email){
		$cust = $this->_em->getRepository('Entity\Customer')->findOneByEmail($email);
		
		$password = $this->getnewpwd();
		$cust->setPassword($password);
		$cust->setResetPassword(1);
		$this->_em->persist($cust);
		$this->_em->flush();
		
		$this->load->library('email');		

		$this->email->from('admin@laundrywaves.com', 'Laundry Waves');
		$this->email->to($email,$name); 
		$this->email->bcc('sandypublic@gmail.com'); 
		$this->email->subject('Laundry Waves: Find your new password from Laundry Waves');
		$body = '<br>
		            Dear '.$name.'
				<br/>
				Your password is : '.$password;
		
		$this->email->message($body);	
		$this->email->send();

		$name = $cust->getFirstName($fname).' '.$cust->getLastName($lname);
		$email = $cust->getEmail($email);
		$mobile = $cust->getPhoneNo($mobile);
				
		$message =[ 'message' => 'Your password is successfully updated' ];
		$this->set_response($message, REST_Controller::HTTP_OK);
		
		}else{

		$message =[ 'message' =>'your not authorised person, please contact administrator.'];
		$this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
			
		}
		
	}
	
	public function changepwd_post(){
		$input 	= file_get_contents("php://input");
		$data 	= json_decode($input);
			$email = 0;
			$password =0;
		if(property_exists($data,'customerId')){	
		$email 		= $data->customerId;
		}
		if(property_exists($data,'password')){	
			$password	= $data->password;
		}

		$this->_em = $this->doctrine->em;

		if($email){
			$cust = $this->_em->getRepository('Entity\Customer')->findOneById((int)$email);
			if(is_object($cust)){
			$cust->setPassword($password);
			$cust->setResetPassword(0);
			$this->_em->persist($cust);
			$this->_em->flush();
			$message =[ 'message' => 'Your password is successfully updated and sent back to respective email id.' ];
			$this->set_response($message, REST_Controller::HTTP_OK);
			}else{
				$message =[ 'message' =>'lol, please logout. your not authorised your.'];
				$this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);						
			}
		}else{

			$message =[ 'message' =>'your not authorised person, please contact administrator.'];
			$this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);		
		}
		
	}
	
	
	public function vehicle_post(){
		
	}
	
	public function itemImageUpload_post(){

		try{

			$root = $this->config->item('base_url');
			$config = array(
				'upload_path' => APPPATH."../uploads/items",
				'absolute_path' => $root."uploads/items",
				'allowed_types' => "gif|jpg|png|jpeg|pdf",
				'overwrite' => TRUE,
				'max_size' => "2048000"
				//'max_height' => "768",
				//'max_width' => "1024"
			);
			$this->load->library('upload', $config);
			if($this->upload->do_upload('image')){
				if($this->upload->display_errors()!=''){
					$error = $this->upload->display_errors(); 
					$this->set_response($error, REST_Controller::HTTP_BAD_REQUEST);	
				}else{
					$image =  $this->upload->data();
					$message = ['image'=>$image];
					$this->set_response($message, REST_Controller::HTTP_OK);	
				}
			}else{
				$error = $this->upload->display_errors(); 
				$this->set_response($error, REST_Controller::HTTP_BAD_REQUEST);	
			}

		}catch(Exception $e){
			$this->set_response($e->getMessage(), REST_Controller::HTTP_BAD_REQUEST);	
		}
	}

	public function serviceImageUpload_post(){

		try{

			$root = $this->config->item('base_url');
			$path = APPPATH."../uploads/services";
			if(!is_dir($path)){
				mkdir($path);
			}
			$config = array(
				'upload_path' =>$path,
				'absolute_path' => $root."uploads/services",
				'allowed_types' => "gif|jpg|png|jpeg|pdf",
				'overwrite' => TRUE,
				'max_size' => "2048000"
				//'max_height' => "768",
				//'max_width' => "1024"
			);
			$this->load->library('upload', $config);
			if($this->upload->do_upload('image')){
				if($this->upload->display_errors()!=''){
					$error = $this->upload->display_errors(); 
					$this->set_response($error, REST_Controller::HTTP_BAD_REQUEST);	
				}else{
					$image =  $this->upload->data();
					$message = ['image'=>$image];
					$this->set_response($message, REST_Controller::HTTP_OK);	
				}
			}else{
				$error = $this->upload->display_errors(); 
				$this->set_response($error, REST_Controller::HTTP_BAD_REQUEST);	
			}

		}catch(Exception $e){
			$this->set_response($e->getMessage(), REST_Controller::HTTP_BAD_REQUEST);	
		}
	}
	public function visitorImageUpload_post(){

		try{

			$root = $this->config->item('base_url');
			$path = APPPATH."../uploads/visitor";
			if(!is_dir($path)){
				mkdir($path);
			}
			$config = array(
				'upload_path' =>$path ,
				'absolute_path' => $root."uploads/visitor",
				'allowed_types' => "gif|jpg|png|jpeg|pdf",
				'overwrite' => TRUE,
				'max_size' => "2048000"
				//'max_height' => "768",
				//'max_width' => "1024"
			);
			$this->load->library('upload', $config);
			if($this->upload->do_upload('image')){
				if($this->upload->display_errors()!=''){
					$error = $this->upload->display_errors(); 
					$this->set_response($error, REST_Controller::HTTP_BAD_REQUEST);	
				}else{
					$image =  $this->upload->data();
					$message = ['image'=>$image];
					$this->set_response($message, REST_Controller::HTTP_OK);	
				}
			}else{
				$error = $this->upload->display_errors(); 
				$this->set_response($error, REST_Controller::HTTP_BAD_REQUEST);	
			}

		}catch(Exception $e){
			$this->set_response($e->getMessage(), REST_Controller::HTTP_BAD_REQUEST);	
		}
	}

	public function adImageUpload_post(){

		try{

			$root = $this->config->item('base_url');
			$path = APPPATH."../uploads/ads";
			if(!is_dir($path)){
				mkdir($path);
			}
			$config = array(
				'upload_path' => $path,
				'absolute_path' => $root."uploads/ads",
				'allowed_types' => "gif|jpg|png|jpeg|pdf",
				'overwrite' => TRUE,
				'max_size' => "2048000"
				//'max_height' => "768",
				//'max_width' => "1024"
			);
			$this->load->library('upload', $config);
			if($this->upload->do_upload('image')){
				if($this->upload->display_errors()!=''){
					$error = $this->upload->display_errors(); 
					$this->set_response($error, REST_Controller::HTTP_BAD_REQUEST);	
				}else{
					$image =  $this->upload->data();
					$message = ['image'=>$image];
					$this->set_response($message, REST_Controller::HTTP_OK);	
				}
			}else{
				$error = $this->upload->display_errors(); 
				$this->set_response($error, REST_Controller::HTTP_BAD_REQUEST);	
			}

		}catch(Exception $e){
			$this->set_response($e->getMessage(), REST_Controller::HTTP_BAD_REQUEST);	
		}
	}
    
    public function notificationFileUpload_post(){

		try{

			$root = $this->config->item('base_url');
			$filePath = APPPATH."../uploads/notifications";
			if(!is_dir($filePath)){
				mkdir($filePath,TRUE);
			}
			$config = array(
				'upload_path' => APPPATH."../uploads/notifications",
				'absolute_path' => $root."uploads/notifications",
				'allowed_types' => "doc|docx|xls|xlsx|ppt|gif|jpg|png|jpeg|pdf",
				'overwrite' => TRUE,
				'max_size' => "2048000"
				//'max_height' => "768",
				//'max_width' => "1024"
			);
			$this->load->library('upload', $config);
			if($this->upload->do_upload('noti_file')){
				if($this->upload->display_errors()!=''){
					$error = $this->upload->display_errors(); 
					$this->set_response($error, REST_Controller::HTTP_BAD_REQUEST);	
				}else{
					$image =  $this->upload->data();
					$message = ['image'=>$image];
					$this->set_response($message, REST_Controller::HTTP_OK);	
				}
			}else{
				$error = $this->upload->display_errors(); 
				$this->set_response($error, REST_Controller::HTTP_BAD_REQUEST);	
			}

		}catch(Exception $e){
			$this->set_response($e->getMessage(), REST_Controller::HTTP_BAD_REQUEST);	
		}
	}
	
	private function getnewpwd() {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		return substr(str_shuffle($chars),0,8);
	}

}