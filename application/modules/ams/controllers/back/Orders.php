<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Orders extends CI_Controller {



    function __construct()
    {
  		 parent::__construct();
 	}

	public function index(){
		$this->load->view('orders');

	}

	public function saveorder(){
		
		$input = file_get_contents("php://input");
		$result = json_decode($input);
		log_message('error', ' save order started ');
		$customerId = $result->customerId;
		$addressId = $result->addressId;
      	$chars = 'ABCDEFGHOJKLMNOPQRSTUVWXYZ';
 		$n = rand(0,25);
		$char = $chars[$n];
		$orderId 	= date('Ymdhi').$char;
		
		$this->_em = $this->doctrine->em;
		
		$placeOrderId = new \Entity\PlaceOrderId();
			log_message('error', ' save order 1 ');
		
		if($customerId){
						log_message('error', ' save order 2 ');
		 	$cust = $this->_em->find('Entity\Customer',$customerId);
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
				}else{
					$cat = $this->_em->getRepository('Entity\Catalog')->findOneByName('default');
					$catalogId = $cat->getId();
				}
		}else{
						log_message('error', ' customer id not coming ');
		}
		
//		echo $catalogId;
		
       $subTotal = 0;
	   $totalRpoints = 0;		
		foreach($result->service as $key=>$data){
						log_message('error', ' loop started ');
			$itemCost = 0;
			$items 	= $result->pitem;
			$itemId 	= $items[$key];
			
			$services 	= $result->service;
			$serviceId 	= $services[$key];
			
			$itemtypes 	= $result->itemtype;
			$itemTypeId 	= $itemtypes[$key];
			
			$quantity 	= $result->quantity;
			$count 	= $quantity[$key];
			
			$customerId = $customerId;
			
			$qb = $this->_em->createQueryBuilder();
			
			$cps = $qb->select('cp')->from('Entity\CatalogPrice','cp')->innerJoin('cp.item_id','Entity\Item')->where('cp.service_id = :serviceId and cp.item_id =:itemId and cp.itype_id=:itypeId and cp.catalog_id=:catalogId')->setParameters(array('itemId'=>$itemId,'serviceId'=>$serviceId,'itypeId'=>$itemTypeId,'catalogId'=>$catalogId))->getQuery()->getArrayResult();

			if(sizeof($cps)){
				$ncost		= $count*$cps[0]['cost'];
				$dcost		= $count*$cps[0]['discount'];
				$cost 		= $ncost - $dcost;
				$rpoints	= $count*$cps[0]['rpoints'];
			}else{
				$ncost		= 0;
				$dcost		= 0;
				$cost 		= 0;
				$rpoints	= 0;
			}


			$placeOrder = new \Entity\PlaceOrder();
						
			$item = $this->_em->find('Entity\Item',$itemId);
			$service = $this->_em->find('Entity\Service',$serviceId);
			$cust = $this->_em->find('Entity\Customer',$customerId);
			
			$placeOrder->setItemId($item);
			$placeOrder->setServiceId($service);
			$placeOrder->setCustomerId($cust);
			$placeOrder->setOrderId($orderId);
			$placeOrder->setIcount($count);
			
			$placeOrder->setRpoints($rpoints);
			
			
			if(property_exists($result,'addons')){
				$addonsArray 	= $result->addons; 
				$addons = $addonsArray[$key];
			 		 
					if(property_exists($addons,'addon')){
						$addon = $addons->addon;
						$acount = $addons->acount;
						$acost = $addons->acost;
						foreach($addon as $ackey => $ac){
						
							$poa = new Entity\PlaceOrderAddon();						
							if($addon->$ackey){
								$addonObj = $this->_em->find('Entity\Addon', $ac);						
								if(is_object($addonObj))
								$cost = $cost + $acost->$ackey;
									$poa->setAddonId($addonObj);	
									$poa->setCount($acount->$ackey);
									$placeOrder->addPlaceOrderAddon($poa);
								}
						}
					}
			 	
			}
			$subTotal = $subTotal +$cost;
			$totalRpoints = $totalRpoints + $rpoints;
			$placeOrder->setCost($cost);
			$this->_em->persist($placeOrder);
			$this->_em->flush();	
						log_message('error', ' save order loop end ');	
		}
		$config = $this->_em->find('Entity\Settings',1);	
	    if(is_object($config)){
			$sericeCharge = $config->getServiceCharge();
			$refPoints = $config->getRefPoints();
		}else{
			$sericeCharge = 5;
			$refPoints = 0;	
			$totalRpoints  = $totalRpoints + 0;
		}
		
	
		 $serviceCost = ($subTotal*$sericeCharge)/100;
		 $totalAmount = $subTotal + $serviceCost;
		
		$totalAmountPaid = '';
		
		$placeOrderId->setOrderId($orderId);
		$placeOrderId->setSubtotal($subTotal);
		$placeOrderId->setVat($serviceCost);
		$placeOrderId->setTotalAmount($totalAmount);
	
		$placeOrderId->setTotalAmountPaid($totalAmount);
		
		if($addressId)
		$placeOrderId->setAddressId($addressId);
		
		if($cust){
		$placeOrderId->setCustomerId($cust);	
		$this->_em->persist($placeOrderId);
		$this->_em->flush();
			$cust->addRpoints($totalRpoints);
			
			$refId = $cust->getRefId();
		if($refId ){
			$cust2 = $this->_em->getRepository('Entity\Customer')->findOneByEmail($refId);
			if(is_object($cust2) && $cust->getFirstOrder()){
				$cust2->addRpoints($refPoints);
				$this->_em->persist($cust2);
				$this->_em->flush();
			}
		}
			$cust->setFirstOrder(0);
			$this->_em->persist($cust);
				$this->_em->flush();
		}
		
	}
	
	public function orderslist(){
		
		$input = file_get_contents("php://input");
		$result = json_decode($input);
		$customerId = $result;
		
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		if($customerId)
		$orders = $qb->select('oids')->from('\Entity\PlaceOrderId','oids')->where('oids.customer_id=:customerId')->setParameter('customerId',$customerId)->getQuery()->getArrayResult();
		else
		$orders = $qb->select('oids','Entity\Customer')->from('\Entity\PlaceOrderId','oids')->innerJoin('oids.customer_id','Entity\Customer')->getQuery()->getArrayResult(); 
	
		echo json_encode($orders); die();
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
		$totalAmount = $data->totalAmount;
		$balanceAmount = $data->balanceAmount;
		$payingAmount = $data->payingAmount;
		$orderId = $data->oid;
		$this->_em = $this->doctrine->em;
		$paymentAmount = $balanceAmount-$payingAmount;
		if((int)$orderId){
			$order = $this->_em->find('\Entity\PlaceOrderId',(int)$orderId);
			$order->setBalanceAmount($paymentAmount);
			$this->_em->persist($order);

			$this->_em->flush(); die();

		}
		die();

		
	}

}