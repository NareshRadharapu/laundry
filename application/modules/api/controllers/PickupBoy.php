<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class PickupBoy extends REST_Controller {
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
      public function paymentOrders_post(){
        $input = file_get_contents("php://input");
        $data = json_decode($input);
        if(is_object($data)){
          try{
            if(property_exists($data,'mobile')){
              $mobile = $data->mobile;
              if($mobile){
                $this->_em = $this->doctrine->em;
                $qb = $this->_em->createQueryBuilder();
                $orderObj = $qb->select('poi')->from('Entity\PlaceOrderId','poi')->innerJoin('poi.customer_id','Entity\Customer')->where('Entity\Customer.mobile = :mobile and poi.balanceAmount>0')->setParameter('mobile',$mobile)->addOrderBy('poi.id','asc')->getQuery()->getResult();
                $orders = array();
                foreach ($orderObj as $key => $value) {
                  $order = array();
                  $order['id']      = $value->getId();
                  $order['order_id']    = $value->getOrderId();
                  $order['customerName']  = $value->getCustomerId()->getFirstName().' '.$value->getCustomerId()->getLastName();
                  $order['mobile']    = $value->getCustomerId()->getPhoneNo();
                  $caddress = $value->getAddressId();
                  if(is_object($caddress)){  
                    $order['address']  = $caddress->getAddress();
                    $order['landmark']  = $caddress->getLandmark();
                  }else{
                    $order['address']  = '';
                    $order['landmark']  = '';
                  }
                  $order['wallet']    = $value->getCustomerId()->getWallet();
                  $order['totalAmount']   = $value->getTotalAmount();
                  $order['redeemAmount']  = $value->getRedeemAmount();
                  $order['paidAmount']  = $value->getPaidAmount();
                  $order['balanceAmount'] = $value->getBalanceAmount();
                  $order['adminDiscount'] = $value->getAdminDiscount();
                  $order['adminDiscountAmount']   = $value->getAdminDiscountAmount();
                  $order['orderDate']   = (int)strtotime($value->getOrderDate()->format('Y-m-d H:i:s'))*1000;
                  $orders['orders'][] = $order;
                }
                $this->response($orders, REST_Controller::HTTP_OK);     
              }else{
                $message = ['message'=>'your not authorized '];
                $this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE);      
              }
            }else{
              $message = ['message'=>'your not authorized '];
              $this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE);      
            }
          }catch(Exception $e){
            $this->set_response($e->getMessage(), REST_Controller::HTTP_BAD_REQUEST);
          }
        }else{
          $message = ['message'=>'Something went wrong.'];
          $this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE);      
        }
      }
      /****************************************************/
      /************* get catelog items  *******************/
      /****************************************************/  
      public function catalogitems_post(){
        $input = file_get_contents("php://input");
        $data = json_decode($input);
        if(is_object($data)){
          $this->_em = $this->doctrine->em;
          $qb = $this->_em->createQueryBuilder();
          $catalogId = 0;
          if(property_exists($data, 'catalogId')){
            $catalogId    = $data->catalogId; 
          }
          if($catalogId){
            $items = $qb->select('cp','Entity\Item','Entity\ItemType','Entity\Service')->from('Entity\CatalogPrice','cp')->innerJoin('cp.item_id','Entity\Item')->innerJoin('cp.itype_id','Entity\ItemType')->innerJoin('cp.service_id','Entity\Service')->where('cp.catalog_id = :catalogId and Entity\Item.status=:status')->setParameter('catalogId',$catalogId)->setParameter('status',1)->addOrderBy('Entity\Item.id','asc')->getQuery()->getArrayResult();
            $catalogItems = array();
            foreach($items as $it){
              if(array_key_exists('item_id',$it)){
                if($it['item_id']['status']){
                  $catalogItem = array();
                  $catalogItem['item_id'] = $it['item_id']['id'];
                  $catalogItem['item_name'] = $it['item_id']['name'];
                  $catalogItem['item_image'] = $it['item_id']['image'];
                  $catalogItem['item_cost'] = $it['cost'];
                  $catalogItem['item_discount'] = $it['discount'];
                  $catalogItem['item_rpoints'] = $it['rpoints'];
                  $catalogItem['item_itype_id'] = $it['itype_id']['id'];
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
      /***********  PLACE ORDER IDS **********************/
      /***************************************************/
      public function placeorderids_post(){
        $input = file_get_contents("php://input");
        $data = json_decode($input);
        if(is_object($data)){
          try{
            if(property_exists($data,'pickupBoyId')){
              $pickupBoyId = $data->pickupBoyId;
              if($pickupBoyId){
                $this->_em = $this->doctrine->em;
                $qb = $this->_em->createQueryBuilder();
               // $orderObj = $qb->select('poi')->from('Entity\PlaceOrderId','poi')->where('poi.pb_id =:pickupBoyId and poi.pickupBoyStatus=:pstatus')->setParameter('pickupBoyId',$pickupBoyId)->setParameter('pstatus','assigned')->getQuery()->getResult();
                $orderObj = $qb->select('poi')->from('Entity\PlaceOrderId','poi')->where('poi.pb_id =:pickupBoyId and poi.pickupBoyStatus=:pstatus and poi.poStatus =:ordStatus')->setParameter('pickupBoyId',$pickupBoyId)->setParameter('pstatus','assigned')->setParameter('ordStatus',' ')->getQuery()->getResult();
                $orders = array();
                foreach ($orderObj as $key => $value) {
                  $order = array();
                  $order['id']      = $value->getId();
                  $order['order_id']    = $value->getOrderId();
                  $order['customerName']  = $value->getCustomerId()->getFirstName().' '.$value->getCustomerId()->getLastName();
                  $order['mobile']    = $value->getCustomerId()->getPhoneNo();
                  $caddress = $value->getAddressId();
                  if(is_object($caddress)){  
                    $order['address']  = $caddress->getAddress();
                    $order['landmark']  = $caddress->getLandmark();
                    $order['pincode']  = $caddress->getPincode();
                  }else{
                    $order['address']  = '';
                    $order['landmark']  = '';
                    $order['pincode']  = '';
                  }
                  $order['wallet']    = $value->getCustomerId()->getWallet();
                  $order['totalAmount']   = $value->getTotalAmount();
                  $order['redeemAmount']  = $value->getRedeemAmount();
                  $order['paidAmount']  = $value->getPaidAmount();
                  $order['balanceAmount'] = $value->getBalanceAmount();
                  $order['adminDiscount'] = $value->getAdminDiscount();
                  $order['adminDiscountAmount']   = $value->getAdminDiscountAmount();
                  $order['status']    = (boolean)$value->getStatus();
                  $order['pickupBoyStatus']   = $value->getPickupBoyStatus();
                  $order['orderDate']   = (int)strtotime($value->getOrderDate()->format('Y-m-d H:i:s'))*1000;
                  $orders['orders'][] = $order;
                }
                $this->response($orders, REST_Controller::HTTP_OK);     
              }else{
                $message = ['message'=>'your not authorized '];
                $this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE);      
              }
            }else{
              $message = ['message'=>'your not authorized '];
              $this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE);      
            }
          }catch(Exception $e){
            $this->set_response($e->getMessage(), REST_Controller::HTTP_BAD_REQUEST);
          }
        }else{
          $message = ['message'=>'Something went wrong.'];
          $this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE);      
        }
      }
      /***************************************************/
      /***********  PLACE ORDER HISTORY  *****************/ 
      /***************************************************/
      public function placeorderhistory_post(){
        $input = file_get_contents("php://input");
        $data = json_decode($input);
        if(is_object($data)){
          if(property_exists($data,'orderId')){
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
                $po['item_name']  = $v['item_id']['name'];
                $po['item_type']  = $v['item_id']['itype_id']['name'];;
                $po['item_service'] = $v['service_id']['name'];;
                $po['item_count']   = $v['icount'];
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
                $po['item_cost']  = $netCost;
                $po['item_addons'] = $ads;
                $po['item_rpoints'] = $v['rpoints'];  
                $poa['items'][] = $po;
              }
              if(sizeof($orderHistory)){
                $poa['subTotal'] = $orderHistory[0]['subtotal'];
                $poa['serviceTax'] = $orderHistory[0]['serviceTax'];
                $poa['totalAmount'] = $orderHistory[0]['totalAmount'];
                $poa['rPointsUsed'] = $orderHistory[0]['rPointsUsed'];
                $poa['redeemAmount'] = $orderHistory[0]['redeemAmount'];
                $poa['balanceAmount'] = $orderHistory[0]['balanceAmount'];
                $poa['reFundAmount'] = $orderHistory[0]['reFundAmount'];
                $poa['closingBalance'] = $orderHistory[0]['closingBalance'];
              }
              $this->response($poa, REST_Controller::HTTP_OK);        
            }else{
              $message = ['message'=>'your not authorized '];
              $this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE);          
            }
          }
        }
      }
    private function doOrder($result, $addressObj, $customerObj, $storeCode='cbs', $pbObj, $couponCode=false, $so){
      $this->_em = $this->doctrine->em;
      $n = rand(1001,9999);
      $orderId  = $storeCode.'-'.$so.'-S-'.date('dmY').'-'.$n;
      $rrpoints = 0; $subTotal = 0; $totalAmount = 0;
      try{
        $placeOrderId = new \Entity\PlaceOrderId(); 
        $placeOrderId->setAddressId($addressObj);
        $placeOrderId->setOrderDate(date('Y-m-d H:i:s'));
        $totalItems = 0;
        foreach($result as $data){
          log_message('error','loop started ');
          $itemCost =0;
          $itemId   = $data->itemId;
          $serviceId  = $data->serviceId;
            //$customerId = $data->custId;
          $icount   = $data->icount;
          $addons   = $data->addons; 
          $cost   = $data->cost;
          $rpoints  = $data->rpoints;
          $itemCost   = $cost*$icount;
          $totalItems += $icount;
          $placeOrder = new \Entity\PlaceOrder();
          $item = $this->_em->find('Entity\Item',$itemId);
          $service = $this->_em->find('Entity\Service',$serviceId);
            //$cust = $this->_em->find('Entity\Customer',$customerId);
          $placeOrder->setItemId($item);
          $placeOrder->setServiceId($service);
          $placeOrder->setCustomerId($customerObj);
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
          $rrpoints +=$rpoints;
          $subTotal += $itemCost;
          $placeOrder->setCost($itemCost);
          $this->_em->persist($placeOrder);
          $this->_em->flush();    
          log_message('error','loop end ');
        }
        $ss = $this->_em->getRepository('Entity\Settings')->findOneById(1);
        $serviceTax = 0;
        $isServiceTax = $addressObj->getAreaId()->getIsServiceTax();
        if(is_object($ss) && $isServiceTax){
          $refPoints = $ss->getRefPoints();
          $serviceTax = $ss->getServiceCharge();
          $serviceCharge = $subTotal*$serviceTax/100;
        }else{
          $refPoints = 0; $vat = 0; $serviceCharge = 0;   
        }
        $subTotal = $subTotal + $serviceCharge;
        $customerObj->addRpoints($rrpoints);
            $totalAmount = $subTotal;
            $reWardCost = 0; $redeemAmount = 0;  $reWardPoints = 0;
            $adminDiscount = 0;         $adminDiscountAmount = 0;
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
                $adminDiscount              = $defaultDiscount;
                $adminDiscountAmount    = $defaultDiscountAmount;
            }else{      
                
                $vendorDiscount = 0;        $vendorDiscountAmount = 0;
                $couponDiscount = 0;        $couponDiscountAmount = 0;
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
                if($couponCode){                
                    $couponCodeObj = $this->_em->getRepository('Entity\Coupon')->findOneBy(array('code'=>$couponCode));
                    if(is_object($couponCodeObj)){
                        $today = new \DateTime('today');
                        if(($couponCodeObj->getStartDate()<=$today && $couponCodeObj->getExpDate()>=$today)){
                            $couponCost             = $couponCodeObj->getCost();
                            $couponCount            = $couponCodeObj->getCount();
                            $minOrderVal            = $couponCodeObj->getMinOrdVal();
                            $orderCouponcode    = $placeOrderId->getCouponCode();
                            $couponDiscountAmount = 0; $couponDiscount = 0;
                            if(($couponCount>0) && ($totalAmount>=$minOrderVal)){
                                $couponDiscountAmount = number_format(floatval(($couponCost*$totalAmount)/100),2,'.','');
                                $couponDiscount = number_format($couponCost,2,'.','');
                                $totalAmount = $totalAmount - $couponDiscountAmount;
                                if ($couponCode == $orderCouponcode) {
                                }else{
                                    $couponCnt = $couponCount - 1 ;
                                    $couponCodeObj->setCount($couponCnt);
                                }
                            }else{
                                $totalAmount = $totalAmount ;
                            }                           
                            $placeOrderId->setCouponCode($couponCode);
                        }
                    }
                }
                /* Coupon Discount End */           
                $adminDiscount              = $vendorDiscount + $couponDiscount;
                $adminDiscountAmount    = $vendorDiscountAmount + $couponDiscountAmount;
            }           
        if(is_object($customerObj)){
          $placeOrderId->setOrderId($orderId);
          $placeOrderId->setSubtotal($subTotal);
          $placeOrderId->setServiceTax($serviceCharge);
          $placeOrderId->setTotalAmount($totalAmount);
          $placeOrderId->setRPointsUsed($redeemAmount*1000);
          $placeOrderId->setTotalItems($totalItems);
          $placeOrderId->setPaidAmount(0);
          $placeOrderId->setBalanceAmount($totalAmount);
          $placeOrderId->setClosingBalance($totalAmount);
          $placeOrderId->setReFundAmount(0);
          $placeOrderId->setAdminDiscount($adminDiscount);
          $placeOrderId->setAdminDiscountAmount($adminDiscountAmount);
          $placeOrderId->setRedeemAmount($redeemAmount);
          $placeOrderId->setPickupBoyId($pbObj);
          $placeOrderId->setPickupBoyStatus('recieved');
          $placeOrderId->setCustomerId($customerObj);
          $this->_em->persist($placeOrderId);
          $this->load->library('cbs','');
            //$this->cbs->sendSMS($placeOrderId,'mobile');
          $name = $customerObj->getFirstName().' '.$customerObj->getLastName();
          $heading = 'order placed';
          $message = 'Dear '.$name.', your order successfully placed';
          $this->cbs->sendNotification($customerObj->getOsPlayerId(),$heading,$message);
          $this->_em->flush();    
          //return $orderId;
                $ord = array();
                $ord['orderId'] = $orderId;
                $ord['adminDiscountAmount'] = $adminDiscountAmount;
                return $ord;
          log_message('error',' order completed ');
        }else{
          log_message('error',' cust obj missed ');
        }
      }catch(Exception $e){
        log_message('error',$e->getMessage());
        $this->set_response($e->getMessage(), REST_Controller::HTTP_BAD_REQUEST);
      }
      return 0;
    }
      /***************************************************/
      /*************  PLACE ORDER POST *******************/
      /***************************************************/
      public function placeorder_post(){
        $this->_em = $this->doctrine->em;
        $input = file_get_contents("php://input");
        $result = json_decode($input);
        if(is_object($result)){
          $address = 0; $addressObj = new stdClass;
          $storeCode = 'cbs';
          if(property_exists($result,'addressId')){
            $address = (int)$result->addressId;
            $addressObj = $this->_em->getRepository('Entity\CustomerAddress')->findOneById($address);
            if(is_object($addressObj)){
              $storeCode = $addressObj->getAreaId()->getCode();
            }else{
              $storeCode = 'cbs';
            }
          }
          if(property_exists($result, 'mobile')){
            $mobile = $result->mobile;
            $customerObj = $this->_em->getRepository('Entity\Customer')->findOneBy(array('mobile'=>$mobile));
          }
          if(property_exists($result, 'couponCode')){
            $couponCode = $result->couponCode;
          }else{
            $couponCode = '';
          }
          $pbObj = '';
          if(property_exists($result, 'pickupBoyId')){
            $pickupBoyId = $result->pickupBoyId;
            $pbObj = $this->_em->find('Entity\PickupBoy',$pickupBoyId);
          }
          try{
            if(is_object($customerObj) && is_object($pbObj)){
              $steamIronOrders = array(); $normalOrders = array();
              foreach($result->data as $data){
                $serviceId  = $data->serviceId;
                if($serviceId==1){
                  $steamIronOrders[] = $data;
                }else{
                  $normalOrders[] = $data;
                }
              }
              //$nOrderId = 0; $siOrderId = 0; 
              $orderId = '';
              $nOrderId = array("orderId"=>"0","adminDiscountAmount"=>"0");
              $siOrderId = array("orderId"=>"0","adminDiscountAmount"=>"0");
              if(sizeof($normalOrders)){
                $nOrderId   = $this->doOrder($normalOrders, $addressObj, $customerObj, $storeCode, $pbObj,$couponCode,'WD');
              }
              if(sizeof($steamIronOrders)){
                $siOrderId  = $this->doOrder($steamIronOrders, $addressObj, $customerObj, $storeCode, $pbObj,$couponCode,'SI');
              }
              $message =[ 'message' => 'Order Successfully Placed....','normalOrderId'=>$nOrderId,'siOrderId'=>$siOrderId];
              $this->set_response($message, REST_Controller::HTTP_CREATED);
            }else{
              $message =[ 'message' => 'something went wrong , please try again.'];
              $this->response($message, REST_Controller::HTTP_BAD_REQUEST); 
            }
          }catch(Exception $e){
            $this->set_response($e->getMessage(), REST_Controller::HTTP_BAD_REQUEST);
          } 
        }else{
          $message =[ 'message' => 'something went wrong , please try again.'];
          $this->response($message, REST_Controller::HTTP_BAD_REQUEST); 
        }
      }
      public function authentication_post(){
        $this->_em = $this->doctrine->em;
        $qb = $this->_em->createQueryBuilder();
        $input = file_get_contents("php://input");
        $data = json_decode($input);
        if(is_object($data)){
          $mobile =0;
          $password=0;  
          try{
            if(property_exists($data,'mobile')) 
              $mobile     = $data->mobile;
            if(property_exists($data,'password')) 
              $password   = md5(trim($data->password));
            if($mobile && $password){    
              $pbObj = $this->_em->getRepository('Entity\PickupBoy')->findOneBy(array('mobile'=>$mobile,'password'=>$password));
              if(is_object($pbObj)){
                $pk = array();
                $pbObj->setToken(random_string('alnum',25));
                $pk['pbId']   = $pbObj->getId();
                $pk['name']   = $pbObj->getName();
                $pk['token']  = $pbObj->getToken();
                $pk['catalogId'] = 1;
                $pk['areaId'] = $pbObj->getAreaId()->getId();
                $pk['areaName'] = $pbObj->getAreaId()->getName();
                $this->_em->persist($pbObj);
                $this->_em->flush();
                $message =[ 'message' => 'Authentication successfull' ,'id'=>$pk];
                $this->response($message, REST_Controller::HTTP_ACCEPTED); 
              }else{
                $message =[ 'message' => 'please enter right credentials.'];
                $this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE);    
              }
            }else{
              $message =[ 'message' => 'please enter credentials.'];
              $this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 
            }
          }catch(Exception $e){
            $message =[ 'message' => 'Something wrong , pelase contact administrator '];
            $this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 
          }
        }else{
          $message =[ 'message' => 'Something went wrong, pleae try again.'];
          $this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 
        }
      } 
      public function addEdit_post(){
        $input = file_get_contents("php://input");
        $data = json_decode($input);
        if(is_object($data)){
          try{
            $pbId = 0;
            if(property_exists($data, 'pbId')){
              $pbId = $data->pbId;
            }
            if($pbId){
              $pbObj = $this->_em->find('Entity\PickupBoy',$pbId);
              if(!is_object($pbObj)){
                $pbObj = new \Entity\PickupBoy();
              }
            }else{
              $pbObj = new \Entity\PickupBoy();
            }
            if(property_exists($data, 'name')){
              $pbObj->setName($data->name);
            }
            if(property_exists($data, 'email')){
              $pbObj->setEmail($data->email);
            }
            if(property_exists($data, 'mobile')){
              $pbObj->setMobile($data->mobile);
            }
            // if(property_exists($data, 'image')){
            //  $pbObj->setImage($data->image);
            // }
            $pbObj->setImage($data->mobile.'.png');
            if(property_exists($data, 'password')){
              $pbObj->setPassword($data->password);
            }
            if(property_exists($data, 'areaId')){
              $area = $this->_em->find('Entity\Area',$data->areaId);
              if(is_object($area))
                $pbObj->setAreaId($area);
            }
            $this->_em->persist($pbObj);
            $this->_em->flush();
            $message =[ 'message' => 'successfully registered pickup boy.'];
            $this->response($message, REST_Controller::HTTP_OK); 
          }catch(Exception $e){
            $this->set_response($e->getMessage(), REST_Controller::HTTP_BAD_REQUEST);
          }
        }else{
          $message =[ 'message' => 'something went wrong.'];
          $this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 
        }
      }
      public function pickupBoyStatus_post(){
        $input = file_get_contents('php://input');
        $data = json_decode($input);
        if(is_object($data)){
          try{
            $pbObj = 0;
            if(property_exists($data,'pbId')){
              $pbId   = $data->pbId;
              $pbObj = $this->_em->find('Entity\PickupBoy',$pbId);
            }
            if(is_object($pbObj)){
              $pbObj->setStatus(!$pbObj->getStatus());
              $this->_em->persist($pbObj);
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
        }else{
          $message =[ 'message' => 'something went wrong.'];
          $this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 
        }
      }
      public function customerRequests_post(){
        $input = file_get_contents('php://input');
        $data = json_decode($input);
        if(is_object($data)){
          try{
            if(property_exists($data,'pickupBoyId')){
              $pickupBoyId = $data->pickupBoyId;
              $qb = $this->_em->createQueryBuilder();
              $crObj = $qb->select('cr')->from('Entity\CustomerRequest','cr')->where('cr.pb_id=:pickupBoyId and cr.status=:status')->setParameter('pickupBoyId',$pickupBoyId)->setParameter('status','CRAPB')->getQuery()->getResult();
              $crs = array();
              foreach ($crObj as $key => $obj) {
                $cr = array();
                $cr['crId']   = $obj->getId();
                $cr['mobile']   = $obj->getMobile();
                $cr['slot']   = $obj->getSlot();
                $cr['requestDateTime']  = is_object($obj->getDate())?strtotime($obj->getDate()->format('Y-m-d'))*1000:'';
                $customer     = $obj->getCustomerId();
                if(is_object($customer)){
                  $name = $customer->getFirstName().' '.$customer->getLastName();
                  $caddress = $customer->getLastAddress();
                  $cr['customerId']  = $customer->getId();
                  $cr['name']  = $name;
                  if(is_object($caddress)){  
                    $cr['address']  = $caddress->getAddress();
                    $cr['landmark']  = $caddress->getLandmark();
                    $cr['pincode']  = $caddress->getPincode();
                  }else{
                    $cr['address']  = '';
                    $cr['landmark']  = '';
                    $cr['pincode']  = '';
                  }
                }else{
                  $cr['customerId']   = '';
                  $cr['name']     = '';
                  $cr['address']    = '';
                  $cr['landmark']   = '';
                  $cr['pincode']    = '';
                }
                $pbObj    = $obj->getPickupBoyId();
                if(is_object($pbObj)){
                  $pbName = $pbObj->getName();
                  $cr['pbName']  = $pbName;
                }else{
                  $cr['pbName']  = '';
                }
                $cr['status']  = $obj->getStatus(); 
                $crs['customers'][] = $cr;
              }
              $this->set_response($crs,REST_Controller::HTTP_OK);
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
      public function customerSearch_post(){
        $input = file_get_contents('php://input');
        $data = json_decode($input);
        if(is_object($data)){
          try{
            if(property_exists($data,'mobile')){
              $mobile   = $data->mobile;
              $customerObj = $this->_em->getRepository('Entity\Customer')->findOneBy(array('mobile'=>$mobile));
              $customers = array();
              if(is_object($customerObj)){
                $customers = array();
                $customers['customerId']  = $customerObj->getId();
                $customers['name']      = $customerObj->getFirstName().' '.$customerObj->getLastName();
                $customers['wallet']    = $customerObj->getWallet();
                $customers['mobile']    = $customerObj->getPhoneNo();
                $address = $customerObj->getCustomerAddress();
                if(sizeof($address) && is_object($address)){
                  $customers['address']    = $address->getAddress();
                  $customers['landmark']   = $address->getLandmark();
                  $customers['pincode']    = $address->getPinCode();
                }else{
                  $customers['address']    = '';
                  $customers['landmark']   = '';
                  $customers['pincode']    = '';
                }
                $customers['message'] = '';
                $customers['area']    = is_object($customerObj->getAreaId())?$customerObj->getAreaId()->getName():'';
                $customers['areaId']    = is_object($customerObj->getAreaId())?$customerObj->getAreaId()->getId():'';
              }else{
                $customers = ['message'=>'customer no exist'];
              }
              $this->set_response($customers,REST_Controller::HTTP_OK);
            }else{
              $message =[ 'message' => 'something went wrong.'];
              $this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 
            }
          }catch(Exception $e){
            $message = ['message'=>$e->getMessage(),'status'=>500];
            $this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
          }
        }else{
          $message =[ 'message' => 'something went wrong.'];
          $this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 
        }
      }
      public function pickupboys_get(){
        try{
          $empObj = $this->_em->getRepository('Entity\PickupBoy')->findAll();
          $pickupboys = array();
          foreach ($empObj as $key => $obj) {
            $pickupboy = array();
            $pickupboy['pbId']  = $obj->getId();
            $pickupboy['name']  = $obj->getName();
            $pickupboy['email']   = $obj->getEmail();
            $pickupboy['mobile'] = $obj->getMobile();
        //$employee['role']   = is_object($obj->getRoleId())?$obj->getRoleId()->getName():'';
            $pickupboy['store']   = is_object($obj->getAreaId())?$obj->getAreaId()->getName():'';
            $pickupboy['status'] = $obj->getStatus();
            $pickupboys['pickupboys'][] = $pickupboy;
          }
          $this->set_response($pickupboys,REST_Controller::HTTP_OK);
        }catch(Exception $e){
          $message = ['message'=>$e->getMessage(),'status'=>500];
          $this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
        }
      }
      public function editPickupboy_post(){
        $input = file_get_contents('php://input');
        $data = json_decode($input);
        if(is_object($data)){
          try{
            $aqb = $this->_em->createQueryBuilder();
            $areas = $aqb->select('a')->from('Entity\Area','a')->getQuery()->getArrayResult();
            $pbId = 0;
            if(property_exists($data,'pbId')){
              $pbId     = $data->pbId;
              $empObj = $this->_em->find('Entity\PickupBoy',$pbId);
              $pickupboy = array();
              $pickupboy['pbId']  = $empObj->getId();
              $pickupboy['name']  = $empObj->getName();
              $pickupboy['email']   = $empObj->getEmail();
              $pickupboy['mobile']  = $empObj->getMobile();
              //$pickupboy['roleId'] = $empObj->getRoleId()->getId();
              //  $pickupboy['roles'] = $roles;
              $pickupboy['areaId']  = $empObj->getAreaId()->getId();  
              $pickupboy['areas']   = $areas;
              $this->set_response($pickupboy,REST_Controller::HTTP_OK);
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
      public function orderStatus_post(){
        $input = file_get_contents('php://input');
        $data = json_decode($input);
        if(is_object($data)){
          try{
            $orderId = 0;
            if(property_exists($data,'orderId')){
              $orderId  = $data->orderId;
              $orderId = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('order_id'=>trim($orderId)));
            }
            if(is_object($orderId)){
              $status = $data->status;
              $orderId->setOrderStatus($status);
              $this->_em->persist($orderId);
              $this->_em->flush();
              $message = ['message'=>'successfully status updated'];
              $this->set_response($message,REST_Controller::HTTP_OK);
            }else{
              $message = ['message'=>'we didn\'t find any order .'];
              $this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
            }
          }catch(Exception $e){
            $message = ['message'=>$e->getMessage(),'status'=>500];
            $this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
          }
        }else{
          $message =[ 'message' => 'something went wrong.'];
          $this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 
        }
      }
      public function PickupOrderStatus_post(){
        $input = file_get_contents('php://input');
        $data = json_decode($input);
        if(is_object($data)){
          try{
            $orderId = 0;
            if(property_exists($data,'orderId')){
              $orderId  = $data->orderId;
              $orderId = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('order_id'=>trim($orderId)));
            }
            if(is_object($orderId)){
              $status = $data->status;
              $orderId->setPickupBoyStatus('recieved');
          //$orderId->setOrderStatus($status);
              $this->_em->persist($orderId);
              $this->_em->flush();
              $message = ['message'=>'successfully status updated'];
              $this->set_response($message,REST_Controller::HTTP_OK);
            }else{
              $message = ['message'=>'we didn\'t find any order .'];
              $this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
            }
          }catch(Exception $e){
            $message = ['message'=>$e->getMessage(),'status'=>500];
            $this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
          }
        }else{
          $message =[ 'message' => 'something went wrong.'];
          $this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 
        }
      }
      public function crStatus_post(){
        $input = file_get_contents('php://input');
        $data = json_decode($input);
        if(is_object($data)){
          try{
            $orderId = 0;
            if(property_exists($data,'crId')){
              $crId   = $data->crId;
              $crId = $this->_em->getRepository('Entity\CustomerRequest')->findOneBy(array('id'=>$crId));
              $status = $data->status;
              $crId->setStatus($status);
              $this->_em->persist($crId);
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
        }else{
          $message =[ 'message' => 'something went wrong.'];
          $this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 
        }
      }
      public function pickupBoySearch_put(){
        $input  = file_get_contents('php://input');
        $data   = json_decode($input);
        if(is_object($data)){
          try{
            $mobile = $data->mobile;
            $pbObj = $this->_em->getRepository('Entity\PickupBoy')->findOneBy(array('mobile'=>$mobile,'status'=>1));
            if(is_object($pbObj)){
              $pb = array();
              $pb['name']   = $pbObj->getName();
              $pb['mobile']   = $pbObj->getMobile();
              $this->set_response($pb,REST_Controller::HTTP_OK);
            }else{
              $message =[ 'message' => 'something went wrong.'];
              $this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 
            }
          }catch(Exception $e){
            $message = ['message'=>$e->getMessage(),'status'=>500];
            $this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
          }
        }else{
          $message =[ 'message' => 'something went wrong.'];
          $this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 
        }
      }
      public function pickupBoySearch_post(){
        $input  = file_get_contents('php://input');
        $data   = json_decode($input);
        if(is_object($data)){
          try{
            $mobile = $data->mobile;
            $pbObj = $this->_em->getRepository('Entity\PickupBoy')->findOneBy(array('mobile'=>$mobile,'status'=>1));
            if(is_object($pbObj)){
              $pb = array();
              $pb['name']   = $pbObj->getName();
              $pb['mobile']   = $pbObj->getMobile();
              $pb['image']  = $pbObj->getImage();
              $pb['empid']  = $pbObj->getId();
              $pb['store']  = $pbObj->getAreaId()->getName();
              $this->set_response($pb,REST_Controller::HTTP_OK);
            }else{
              $message =[ 'message' => 'something went wrong.'];
              $this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 
            }
          }catch(Exception $e){
            $message = ['message'=>$e->getMessage(),'status'=>500];
            $this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
          }
        }else{
          $message =[ 'message' => 'something went wrong.'];
          $this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 
        }
      }
      public function orderPaymentDisplay_post(){
        $input  = file_get_contents('php://input');
        $data   = json_decode($input);
        if(is_object($data) && property_exists($data, 'receiptNo')){
          try{
            $receiptNo = $data->receiptNo;
            $orderObj = $this->_em->getRepository('Entity\PlaceOrderId',$receiptNo);
            if(is_object($orderObj)){
              $order = array();
              $order['orderId']       = $orderObj->getOrderId();
              $order['balanceAmount']   = $orderObj->getBalanceAmount();
              $order['paidAmount']    = $orderObj->getPaidAmount();
              $order['closingBalance']  = $orderObj->getClosingBalance();
              $this->set_response($order,REST_Controller::HTTP_OK);
            }else{
              $message =[ 'message' => 'something went wrong.'];
              $this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 
            }
          }catch(Exception $e){
            $message = ['message'=>$e->getMessage(),'status'=>500];
            $this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
          }
        }else{
          $message =[ 'message' => 'something went wrong.'];
          $this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 
        }
      }
      public function orderPayment_post(){
        $input  = file_get_contents('php://input');
        $data   = json_decode($input);
        if(is_object($data) && 
          property_exists($data, 'amount') && 
          property_exists($data, 'paymentType') &&
          property_exists($data, 'receiptNo')){
          try{
            $receiptNo = $data->receiptNo;  
            $orderObj = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('id'=>$receiptNo));
            if(!is_object($orderObj)){
              $orderObj = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('order_id'=>$receiptNo)); 
            }
            $payingAmount = $data->amount;
            $paymentType = $data->paymentType;
            if(property_exists($data, 'transactionNumber')){
                $transactionNumber  = $data->transactionNumber;
              }else{
                  $transactionNumber = '';
              }
              if(property_exists($data, 'feedback')){
                $feedback       = $data->feedback;  
              }else{
                  $feedback = '';
              }
            //$transactionNumber = $data->transactionNumber;
            if(is_object($orderObj)){
              $balanceAmount    = $orderObj->getBalanceAmount();
              $th = new Entity\TransactionHistory();
              $th->setOrderId($orderObj->getOrderId());
              $th->setCustomerId($orderObj->getCustomerId());
              if($balanceAmount>$payingAmount){
                $remainAmount = $balanceAmount - $payingAmount;
                $orderObj->setPaidAmount($orderObj->getPaidAmount()+$payingAmount);
                $orderObj->setBalanceAmount($remainAmount);
                $th->setPaidAmount($payingAmount);
                $th->setUsedAmount($payingAmount);
                $th->setPaymentType($paymentType);  
                $th->setTransactionNumber($transactionNumber);
                $th->setPaymentFeedback($feedback);
              }else{
                $orderObj->setPaidAmount($orderObj->getPaidAmount()+$balanceAmount);
                $orderObj->setBalanceAmount(0);
                $remainAmount = $payingAmount - $balanceAmount;
                $th->setPaidAmount($payingAmount);
                $th->setUsedAmount($balanceAmount);
                $th->setPaymentType($paymentType);  
                $th->setTransactionNumber($transactionNumber);
                $th->setPaymentFeedback($feedback);
                $orderObj->getCustomerId()->addWallet($remainAmount);
              }
              $orderObj->setPaymentType($paymentType);
              $orderObj->setTransactionNumber($transactionNumber);
              $orderObj->setPaymentFeedback($feedback);
              $this->_em->persist($th);
              $this->_em->persist($orderObj);
              $this->_em->flush();
              $message = ['message'=>'successfully paid'];
              $this->set_response($message,REST_Controller::HTTP_OK);
            }else{
              $message =[ 'message' => 'something went wrong, we didn\'t find respective id'];
              $this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 
            }
          }catch(Exception $e){
            $message = ['message'=>$e->getMessage(),'status'=>500];
            $this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
          }
        }else{
          $message =[ 'message' => 'something went wrong.'];
          $this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 
        }
      }
      public function pickupBoyDeliveryOrders_post(){
        $input  = file_get_contents('php://input');
        $data   = json_decode($input);
        if(is_object($data) && property_exists($data, 'deliveryBoyId') && $data->deliveryBoyId){
          try{
            $deliveryBoyId = $data->deliveryBoyId;
            $qb = $this->_em->createQueryBuilder();
            //$orderObj = $qb->select('p')->from('Entity\PlaceOrderId','p')->where('p.db_id =:deliveryBoyId')->setParameter('deliveryBoyId',$deliveryBoyId)->addOrderBy('p.deliveryDate','asc')->getQuery()->getResult();
            $orderObj = $qb->select('p')->from('Entity\PlaceOrderId','p')->where('p.db_id =:deliveryBoyId and p.poStatus =:oStatus')->setParameter('deliveryBoyId',$deliveryBoyId)->setParameter('oStatus','DOA')->addOrderBy('p.deliveryDate','asc')->getQuery()->getResult();
            $orders = array();  
            foreach ($orderObj as $key => $obj) {
              $order = array();
              $order['receiptNo']   = $obj->getId();
              $order['orderId']   = $obj->getOrderId();
              $order['orderStatus']   = $obj->getOrderStatus();
              $order['orderDate'] = $obj->getOrderDate()->format('d-M-Y');
              $order['deliveryDate'] = $obj->getDeliveryDate()->format('d-M-Y');
              $customerObj = $obj->getCustomerId();
              $order['customerName']  = $customerObj->getFirstName().' '.$customerObj->getLastName();
              $order['customerMobile']  = $customerObj->getMobile();
              $address = $customerObj->getCustomerAddress()->getAddress().', '.$customerObj->getCustomerAddress()->getLandmark().', '.$customerObj->getCustomerAddress()->getAreaId()->getName().' - '.$customerObj->getCustomerAddress()->getPincode();
              $order['customerAddress']   = $address;
              $orders['orders'][] = $order;
            }
            $this->set_response($orders,REST_Controller::HTTP_OK);
          }catch(Exception $e){
            $message = ['message'=>$e->getMessage(),'status'=>500];
            $this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
          }
        }else{
          $message =[ 'message' => 'something went wrong.'];
          $this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 
        }
      }
      public function packageOrders_post(){
        $input = file_get_contents('php://input');
        $data = json_decode($input);
        if(is_object($data) && property_exists($data, 'pbId') && $pbId = $data->pbId){
          try{
            $pbObj = $this->_em->find('Entity\PickupBoy',$pbId);
            if(is_object($pbObj)){
              $ordersObj  =  $pbObj->getPackageCustomers();
              $orders = array();
              foreach ($ordersObj as $key => $obj) {
                $order = array();
                $order['id']  = $obj->getId();
                $order['customerName']  = $obj->getFirstName().' '.$obj->getLastName();
                $order['mobile']    = $obj->getMobile();
                $order['package']     = $obj->getPackage();
                $order['packageStatus'] = $obj->getPackageStatus();
                $orders['orders'][] = $order;
              }
              $this->set_response($orders,REST_Controller::HTTP_OK);  
            }else{
              $message =[ 'message' =>'un known user'];
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
      public function packagePayment_post(){
        $input = file_get_contents('php://input');
        $data = json_decode($input);
        if(is_object($data) && property_exists($data, 'pbId') 
          && $pbId = $data->pbId 
          && property_exists($data,'code') 
          && property_exists($data,'customerId') 
          && $customerId = $data->customerId
        ){
          $code = $data->code;
        $pbId = $data->pbId ;
        try{
          $pbObj = $this->_em->find('Entity\PickupBoy',$pbId);
          $customerObj = $this->_em->find('Entity\Customer',$customerId);
          if(is_object($pbObj) && is_object($customerObj) && (trim($customerObj->getPackageCode()) == trim($code))){
            $customerObj->setPackageStatus(1);
            $this->_em->persist($customerObj);
            $this->_em->flush();
            $message = ['message'=>'package successfully approved'];
            $this->set_response($message,REST_Controller::HTTP_OK); 
          }else{
            $message =[ 'message' =>'un known user s '];
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
  } 