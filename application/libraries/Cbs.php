<?php
class Cbs{
  public $doctrine;
  private $_serviceTax=0.145;
  public $_amessage = array(
    'SAA'=> 'Store Admin Approved',
    'SAPI'=> 'Store Admin Problem Identified',   
    'PO' => 'Process Order',
    'STCU'=> 'Send to Central Unit',
    'CPBA'  => 'Central Pickup Boy Approved',
    'CUAA'  => 'Central Unit Admin Approved',
    'CUAPA' => 'Central Unit Admin Partially Approved',
    'CUPA'  => 'Central Unit Pickup Boy Approved',
    'CUPPA' => 'Central Unit Pickup Boy Partially Approved',
    'HOLD'  => 'Order Placed On Hold',
    'SADA'  => 'Store Admin Delivery Approved',
    'SADPA' => 'Store Admin Delivery Partially Approved',
    'CUTS'  => 'Central Unit to Store',
    'CUPSTS'=> 'Central Unit Partially Sent to Store',
    'SAAD'  => 'Store Admin Assign to Delivery Boy',
    'SAPAD' => 'Store Admin Partially Assign to Delivery Boy',
    'ORD'   => 'Order Ready To Deliver',
    'OPRD'  => 'Order Partially Ready To Deliver',
    'DOA'   => 'Delivery Order Approved',
    'DOPA'  => 'Delivery Order Partially Approved',
    'OD'    => 'Order Delivered',
    'HG-CUF'=> 'Hold Garment - Central Unit Found',
    'HG-CUP'=> 'Hold Garment - Central Unit Processed',
    'HG-CUD'=> 'Hold Garment - Central Unit Delivered',
    'HG-SA '=>' Hold Garment - Store Approved',
    'HG-D ' => 'Hold Garment - Delivered');
  public function __construct($em)
  {
   if(is_object($em)){ 
    $this->_em = $em;
    $this->_qb = $em->createQueryBuilder(); 
  } 
}
public function getServiceWiseCostWithOrderIds($orderIds){
  $serviceWiseCost = array();
  if(is_array($orderIds) && sizeof($orderIds)){
    foreach ($orderIds as $key => $orderId) {
      $poObj = $this->_em->getRepository('Entity\PlaceOrder')->findBy(array('order_id'=>$orderId));
      if(is_array($poObj)){
          foreach ($poObj as $pkey => $pobj) {
                 $serviceName = $pobj->getServiceId()->getName();
                 $cost = $pobj->getCost();
                 if(array_key_exists($serviceName, $serviceWiseCost)){
                    $serviceWiseCost[$serviceName] = $serviceWiseCost[$serviceName] + $cost;
                 }else{
                    $serviceWiseCost[$serviceName] = $cost;
                 }
          }
      }
    }
  } 
  return $serviceWiseCost;
}
public function getServiceWiseItems($orderIds){
 if(is_array($orderIds) && sizeof($orderIds)){
    foreach ($orderIds as $key => $orderId) {
      $poObj = $this->_em->getRepository('Entity\PlaceOrder')->findBy(array('order_id'=>$orderId));
      if(is_array($poObj)){
      //  $serviceWiseRevenue = array();
        $serviceWiseItems = array();
        foreach ($poObj as $p => $pi) {
            //$itemName = $pi->getItemId()->getName();
             $serviceName = $pi->getServiceId()->getName();
            //$itemType = $pi->getItemId()->getItemTypeId()->getName();
           // $item = $itemType.'-'.$itemName;
           // $itemCost = $pi->getCost();
             $itemCount = $pi->getItemCount();
            if(array_key_exists($serviceName, $serviceWiseItems)){
                $serviceWiseItems[$serviceName] = (int)$serviceWiseItems[$serviceName] + $itemCount;
            }else{
                $serviceWiseItems[$serviceName] = (int)$itemCount;
            }
        }
        return $serviceWiseItems;
      }
    }
  }
}
public function getCatalogId($customerObj){
  $catalogId =1;
  if(is_object($apartmentObj = $customerObj->getApartmentId())){
    if(is_object($catalogObj = $apartmentObj->getCatalogId())){
      $catalogId = $catalogObj->getId();
    }
  }elseif(is_object($areaObj = $customerObj->getAreaId())){
    if(is_object($catalogObj = $areaObj->getCatalogId())){
      $catalogId = $catalogObj->getId();
    }
  }else{
    $catalogObj = $this->_em->getRepository('Entity\Catalog')->findOneByName('default');
    if(is_object($catalogObj))
      $catalogId = $catalogObj->getId();
  }
  return $catalogId;
}
public function getItemCost($catalogId,$serviceId, $itemId){
  $catalogPriceObj  = $this->_qb->select('cp')->from('Entity\CatalogPrice','cp')->where('cp.catalog_id=:catalogId and cp.item_id=:itemId and cp.service_id =:serviceId')->setParameter('catalogId',$catalogId)->setParameter('itemId',$itemId)->setParameter('serviceId',$serviceId)->getQuery()->getSingleResult();
  $itemCost = 0;
  if(is_object($catalogPriceObj)){
    $itemCost = $catalogPriceObj->getCost(); // + $catalogPriceObj->getDiscount();
    }
  return $itemCost;
}
    
      public function findPlaceOrderItemIn($inBarCode, $status){
        $reFundAmt = 0;
        $processObj = $this->_em->getRepository('Entity\ProcessOrder')->findOneBy(array('inBarCode'=>$inBarCode));
          if(is_object($processObj)){
            $orderId = $processObj->getOrderId();
            log_message('error','discount:'.$orderId);
            $orderObj = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('order_id'=>$orderId));
            $discount = 100;
            if(is_object($orderObj)){
              $discount = $orderObj->getAdminDiscount();
            }
            log_message('error','discount:'.$discount);
            $placeOrderItemObj = $processObj->getPlaceOrderId();
            $reFundAmt = 0;
            if(is_object($addons = $processObj->getAddons())){
              foreach ($addons as $ak => $av) {
                  $reFundAmt +=$av->getPrice();    
              }
            }
            $placost = 0;
            if(is_object($placeOrderItemObj)){
            $plAddons = $placeOrderItemObj->getPlaceOrderAddons();
            if(is_object($plAddons)){
                foreach ($plAddons as $pak => $pav) {
                     $c = $pav->getCount();
                     $cc = $pav->getAddonId()->getPrice();
                   $placost += floatval($c*$cc);
                }  
            }
          }
            if(is_object($placeOrderItemObj) && ($processObj->getItemStatus()=='return' || $processObj->getItemStatus()=='returned' || $processObj->getItemStatus()=='hold')){
                $icount = $placeOrderItemObj->getICount();
                $cost = $placeOrderItemObj->getCost();
                log_message('error','cost'.$cost);
                $ncost = $cost - $placost;
                log_message('error','ncost'.$ncost);
                if($icount!=0){  
                  $reFundAmt += $ncost/$icount; 
                }
                if($status=='returned' || $status=='return')
                  $placeOrderItemObj->subsRIcount();
                else if($status=='hold' || $status=='HG-CUF')
                  $placeOrderItemObj->subsHIcount();
            }
            if($discount!=100){
                $reFundAmt -= $reFundAmt*($discount/100);
            }
            if($processObj->getStoreId()->getIsServiceTax()){
              $reFundAmt +=$reFundAmt*$this->_serviceTax;  
            }
            $placeOrderItemObj->addReFund(-$reFundAmt);
            $this->_em->persist($placeOrderItemObj); 
        }
        return $reFundAmt;
      }
      public function lostPlaceOrderItemIn($inBarCode, $status){
        $reFundAmt = 0;
        $processObj = $this->_em->getRepository('Entity\ProcessOrder')->findOneBy(array('inBarCode'=>$inBarCode));
        if(is_object($processObj)){
          $orderId = $processObj->getOrderId();
            $orderObj = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('order_id'=>$orderId));
            $discount = 100;
            if(is_object($orderObj)){
              $discount = $orderObj->getAdminDiscount();
            }
          $reFundAmt =0;
          $prAddons = $processObj->getAddons();
          if(is_object($prAddons)){
              foreach ($prAddons as $ak => $av) {
                   $reFundAmt +=floatval($av->getPrice());    
              }
          }
          $placeOrderItemObj = $processObj->getPlaceOrderId();
          $placost = 0;
          if(is_object($placeOrderItemObj)){
            $plAddons = $placeOrderItemObj->getPlaceOrderAddons();
            if(is_object($plAddons)){
                foreach ($plAddons as $pak => $pav) {
                     $c = $pav->getCount();
                     $cc = $pav->getAddonId()->getPrice();
                   $placost += floatval($c*$cc);
                }  
            }
          }
        //  if(is_object($placeOrderItemObj) && ($processObj->getItemStatus()!='return' && $processObj->getItemStatus()!='returned' && $processObj->getItemStatus()!='hold'))
          if(is_object($placeOrderItemObj) && ($processObj->getItemStatus()!='returned' && $processObj->getItemStatus()!='hold')){
            $icount = $placeOrderItemObj->getICount();
            $cost = floatval($placeOrderItemObj->getCost()) - $placost;
            $itemCost = 0; 
            if($icount!=0){
              $itemCost = $cost/$icount;
            }
            $reFundAmt +=floatval($itemCost);
            if($status=='returned' || $status=='return')
              $placeOrderItemObj->addRIcount();
            else if($status=='hold' || $status=='HG-CUF')
              $placeOrderItemObj->addHIcount();
          }
          if($discount!=100){
                $reFundAmt -= $reFundAmt*($discount/100);
            }
          if($processObj->getStoreId()->getIsServiceTax()){
              $reFundAmt +=$reFundAmt*$this->_serviceTax;  
          }
          $placeOrderItemObj->addReFund($reFundAmt); 
          $this->_em->persist($placeOrderItemObj);
        }
        return  $reFundAmt;
      }
      public function getItemNetCost($catalogId,$serviceId, $itemId){
        $catalogPriceObj  = $this->_qb->select('cp')->from('Entity\CatalogPrice','cp')->where('cp.catalog_id=:catalogId and cp.item_id=:itemId and cp.service_id =:serviceId')->setParameter('catalogId',$catalogId)->setParameter('itemId',$itemId)->setParameter('serviceId',$serviceId)->getQuery()->getSingleResult();
        $itemCost = 0;
        if(is_object($catalogPriceObj)){
          $itemCost = $catalogPriceObj->getCost() - $catalogPriceObj->getDiscount();
        }
        return $itemCost;
      }
      public function getAddonsCost($array){
        $totalCost = 0;
        foreach ($array as $key => $obj) {
          $totalCost += $obj->getPrice();
        }
        return $totalCost;
      }
      public function getReFundAmount($totalCost, $orderId){
        $serviceTax = $this->_getSettings()->getServiceCharge();
        $serviceTaxAmount = ($totalCost*$serviceTax)/100;
        $orderObj = $this->_getOrderObj($orderId);
        $discount = $orderObj->getAdminDiscount();
        $discountAmount = ($totalCost*$discount)/100;
        if($orderObj->getAddressId()->getAreaId()->getIsServiceTax())
          return $totalCost + $serviceTaxAmount - $discountAmount;
        else
         return $totalCost - $discountAmount;
     }
     private function _getSettings(){
      $ssObj = $this->_em->find('Entity\Settings',1);
      return is_object($ssObj)?$ssObj:null;
    }
    private function _getOrderObj($orderId){
      $orderObj = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('order_id'=>$orderId));
      return is_object($orderObj)?$orderObj:null;
    }
    public function changeOrderStatus($orderId,$status){

      $placeOrderObj = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('order_id'=>$orderId));    
      if(is_object($placeOrderObj)){
        $amessage = $this->_amessage;
        $message = $amessage[$status];        
        $orderDate = $placeOrderObj->getOrderDate();
        $receiptNo = $placeOrderObj->getId();
        $poStatus  = $placeOrderObj->getOrderStatus();
        if($status == 'OD'){
          if($poStatus == 'PO' || $poStatus == 'ORD' || $poStatus == 'DOA'){
            $placeOrderObj->setOrderStatus($status);
            $placeOrderObj->setOrderStatusMessage($message);
          }else{

          }
        }else{
          $placeOrderObj->setOrderStatus($status);      
          $placeOrderObj->setOrderStatusMessage($message);
        }

       $orderStatusObj = $this->_em->getRepository('Entity\orderstatusdetails')->findOneBy(array('order_id'=>$orderId));
       if(!is_object($orderStatusObj)){
          $orderStatusObj = new \Entity\orderstatusdetails();
        }
        $orderStatusObj->setOrderId($orderId);
        $orderStatusObj->setOrderDate($orderDate);
        $orderStatusObj->setReceiptNo($receiptNo);
        $date   = new \DateTime();
        if($status == 'SAA'){
          $orderStatusObj->setSAA($date);
        }else if($status == 'SAPI'){
          $orderStatusObj->setSAPI($date);
        }else if($status == 'OD'){
          if($poStatus == 'PO' || $poStatus == 'ORD' || $poStatus == 'DOA'){
            $orderStatusObj->setOD($date);
          }
        }else if($status == 'STCU'){
          $orderStatusObj->setSTCU($date);
        }else if($status == 'CUAA'){
          $orderStatusObj->setCUAA($date);
          $orderStatusObj->setCUTS(NULL);
        }else if($status == 'SADA'){
          $orderStatusObj->setSADA($date);
        }else if($status == 'DOA'){
          $orderStatusObj->setDOA($date);
        }
        
           
        $poObj = $this->_em->getRepository('Entity\PlaceOrder')->findBy(array('order_id'=>$orderId));

        $sc = 0;
        foreach ($poObj as $key => $obj) {
          foreach ($obj->getProcessOrders() as $key => $pi) {
            if($pi->getItemStatus()=='hold') $sc =+1; 
            if($pi->getItemStatus()=='hold' || $pi->getItemStatus()=='returned' || $pi->getItemStatus()=='return'){
              continue;
            }
            else{
              $pi->setItemStatus($status);
              $pi->setItemStatusMessage($message); 
            }
          }
        }
        
        if($sc>0){
          switch ($status) {
            case 'CUTS':
            $status = 'CUPSTS';
            break;
            case 'DOA':
            $status = 'DOPA';
            break;
            default:
            $status = $status;
            break;
          }
        }else{
                    //$status = '';
        }
        $amessage = $this->_amessage;
        $message = array_key_exists($status, $amessage)?$amessage[$status]:'';
        if($status == 'OD'){
          if($poStatus == 'PO' || $poStatus == 'ORD' || $poStatus == 'DOA'){
            $placeOrderObj->setOrderStatus($status);
            $placeOrderObj->setOrderStatusMessage($message);
          }else {
            
          }
        }else{
          $placeOrderObj->setOrderStatus($status);
          $placeOrderObj->setOrderStatusMessage($message);
        }
        if($status == 'CUTS'){
          $orderStatusObj->setCUTS($date);
        }
        if($status == 'CUPA'){
          //$this->cu2Store($placeOrderObj);
          $orderStatusObj->setCUPA($date);
        }
       // $orderStatusObj->setSADA($date);
        $this->_em->persist($orderStatusObj);
        $this->_em->persist($placeOrderObj);
        $this->_em->flush();    
        return 'your order successfully updated as '.$status;
      }else{
        return 'order id not exist';
      }
    }
    public function changeDeliveryStatus($orderId,$status){

         
      $placeOrderObj = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('order_id'=>$orderId));
      if(is_object($placeOrderObj)){
        $placeOrderObj->setOrderStatus($status);
        $amessage = $this->_amessage;
        $message = $amessage[$status];
        $placeOrderObj->setOrderStatusMessage($message);
        $orderDate = $placeOrderObj->getOrderDate();
        $receiptNo = $placeOrderObj->getId();

        $orderStatusObj = $this->_em->getRepository('Entity\orderstatusdetails')->findOneBy(array('order_id'=>$orderId));
        $date   = new \DateTime();
        if(!is_object($orderStatusObj)){
          $orderStatusObj = new \Entity\orderstatusdetails();
        }
        $orderStatusObj->setOrderId($orderId);
        $orderStatusObj->setOrderDate($orderDate);
        $orderStatusObj->setReceiptNo($receiptNo);
       if($status == 'ORD'){
          $orderStatusObj->setORD($date);
        }else if($status == 'OPRD'){
          $orderStatusObj->setOPRD($date);
        }

        $poObj = $this->_em->getRepository('Entity\PlaceOrder')->findBy(array('order_id'=>$orderId));
        $sc = 0;
        foreach ($poObj as $key => $obj) {
          foreach ($obj->getProcessOrders() as $key => $pi) {
            // if($pi->getOutBarCode()=='' && !( $pi->getItemStatus()=='returned' || $pi->getItemStatus()=='return')) $sc =+1; 
            if(($pi->getOutBarCode()=='') || ($pi->getItemStatus()=='return') || ($pi->getItemStatus()=='returned')) {
              $sc +=1;
            }else{
              $pi->setItemStatus($status);
              $pi->setItemStatusMessage($message); 
            }
          }
        }
        if($sc>0){
          switch ($status) {
            case 'CUTS':
            $status = 'CUPSTS';
            break;
            case 'ORD':
            $status = 'OPRD';
            break;
            case 'DOA':
            $status = 'DOPA';
            break;
            default:
            $status = $status;
            break;
          }
        }else{
                    //$status = '';
        }
        $amessage = $this->_amessage;
        $message = array_key_exists($status, $amessage)?$amessage[$status]:'';
        if($status=='ORD'){
          //$this->ready2Deliver($placeOrderObj);
        }
        $placeOrderObj->setOrderStatus($status);
        $placeOrderObj->setOrderStatusMessage($message);
        $this->_em->persist($orderStatusObj);
        $this->_em->persist($placeOrderObj);
        $this->_em->flush();    
        return 'your order successfully updated as '.$status;
      }else{
        return 'order id not exist';
      }
    }
    public function changeItemStatus($inBarCode,$status,$message,$secondStatus='',$secondMessage=''){
      $processOrderObj = $this->_em->getRepository('Entity\ProcessOrder')->findOneBy(array('inBarCode'=>$inBarCode));
      if($status!=''){
        $processOrderObj->setItemStatus($status);
      }               
      if($message)    
        $processOrderObj->setItemStatusMessage($message);
      if($secondStatus){
        $processOrderObj->setReturnGarmentStatus($secondStatus);
      }
      if($secondMessage){
        $processOrderObj->setReturnGarmentStatusMessage($secondMessage);
      }
      $orderId = $processOrderObj->getOrderId();
      $placeOrderObj = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('order_id'=>$orderId));
      $poObj = $this->_em->getRepository('Entity\PlaceOrder')->findBy(array('order_id'=>$orderId));
      $sc = 0;
      foreach ($poObj as $key => $obj) {
        foreach ($obj->getProcessOrders() as $key => $pi) {
          if($pi->getItemStatus()=='hold'){
            $sc +=1;
          }                       
        }
      }
          //  if($placeOrderObj->getOrderStatus()=='delivered'){
      if($sc>1){
        $status = 'partially ';
      }else{
        $status = '';
      }
      $placeOrderObj->setOrderStatus($status.' '.$placeOrderObj->getOrderStatus());
      $placeOrderObj->setOrderStatusMessage($message);
      $this->_em->persist($placeOrderObj);    
            //}
      $this->_em->persist($processOrderObj);
      $this->_em->flush();
      return true;
            
    }
          private function _storeSMS($orderObj){
            if(is_object($orderObj)){
              $customerObj    = $orderObj->getCustomerId();
              $orderId        = $orderObj->getId();
              $totalAmount    = $orderObj->getTotalAmount();
              $name   = $customerObj->getFirstName().' '.$customerObj->getLastName();
              $mobile = $customerObj->getMobile();
              $totalItems= $orderObj->getTotalItems();
              $os_push_token = $customerObj->getOsPushToken();
              $os_player_id = $customerObj->getOsPlayerId();
              $storeObj = $orderObj->getAddressId()->getAreaId();
              if(is_object($storeObj)){
                $storeName      = $storeObj->getName();
                $storeMobile    = $storeObj->getMobile();
              }
              $message ='';
            //            $message .='Dear '.$name.' '.$mobile.',Your Order: '.$orderId.' worth '.$totalAmount.', is successfully placed.                 Thanks,CBS-'.$storeName.''.$storeMobile;
              $message .='Dear '.$name;
              $message .=' ' .$mobile;
              $message .=' Your Order: '.$orderId.' with '.$totalItems.' garments, worth '.$totalAmount.', is successfully placed.';
              $message .=' Thanks,';
              $message .=' ' .$storeName;
              $message .=' ' .$storeMobile;
              $this->sendNotification($os_player_id,'Dear '.$name,$message);
              $this->_coreSMS($mobile,$message);   
            }
          }
          private function _mobileSMS($orderObj){
            if(is_object($orderObj)){
              $customerObj    = $orderObj->getCustomerId();
              $orderId        = $orderObj->getId();
              $totalAmount    = $orderObj->getTotalAmount();
              $name   = $customerObj->getFirstName().' '.$customerObj->getLastName();
              $mobile = $customerObj->getMobile();
              $os_push_token = $customerObj->getOsPushToken();
              $os_player_id = $customerObj->getOsPlayerId();
              $storeObj = $orderObj->getAddressId()->getAreaId();
              if(is_object($storeObj)){
                $storeName      = $storeObj->getName();
                $storeMobile    = $storeObj->getMobile();
              }
              $message ='';
              $customerMessage =' Dear '.$name.', Your Order: '.$orderId.' worth '.$totalAmount.', is successfully placed. Our Pickup Boy will reach you soon. Thanks, CBS-'.$storeName.' '.$storeMobile;
              $storeMessage =' CBS-'.$storeName.', '.$name.' '.$mobile.', has placed an Order: '.$orderId.' worth Rs. '.$totalAmount;
              $this->sendNotification($os_player_id,'Dear '.$name, $customerMessage);
              //$this->_coreSMS($mobile,$storeMessage); 
              $messagesArray = array();
              $messagesArray[$mobile] = $customerMessage;
              $messagesArray[$storeMobile] = $storeMessage;
              log_message('error',' message start');  
                $this->_coreMultiSMS($messagesArray); 
              log_message('error',' message end');  
            }
          }
          public function cu2Store($orderObj){
            if(is_object($orderObj)){
              $customerObj    = $orderObj->getCustomerId();
              $orderId        = $orderObj->getId();
              $totalAmount    = $orderObj->getTotalAmount();
              $name   = $customerObj->getFirstName().' '.$customerObj->getLastName();
              $mobile = $customerObj->getMobile();
              $os_push_token = $customerObj->getOsPushToken();
              $os_player_id = $customerObj->getOsPlayerId();
              $storeObj = $orderObj->getAddressId()->getAreaId();
              if(is_object($storeObj)){
                $storeName      = $storeObj->getName();
                $storeMobile    = $storeObj->getMobile();
              }
              $message ='';
              $customerMessage =' Dear '.$name.', Your Order:'.$orderId.' worth:'.$totalAmount.' is ready. In case of any urgency you can collect your garments at store after 6PM. Thanks, CBS';
              $this->_coreSMS($mobile,$customerMessage); 
            }
          }
          public function ready2Deliver($orderObj){
            if(is_object($orderObj)){
              $customerObj    = $orderObj->getCustomerId();
              $orderId        = $orderObj->getOrderId();
              $totalAmount    = $orderObj->getTotalAmount();
              $name   = $customerObj->getFirstName().' '.$customerObj->getLastName();
              $mobile = $customerObj->getMobile();
              $os_push_token = $customerObj->getOsPushToken();
              $os_player_id = $customerObj->getOsPlayerId();
              $storeObj = $orderObj->getAddressId()->getAreaId();
              if(is_object($storeObj)){
                $storeName      = $storeObj->getName();
                $storeMobile    = $storeObj->getMobile();
              }
              $message ='';
             // $customerMessage =' Dear '.$name.' '.$mobile.', Your Order: '.$orderId.' worth '.$totalAmount.', is successfully placed. Our Pickup Boy will reach you soon. Thanks, CBS-'.$storeName.' '.$storeMobile;
              $customerMessage =' Dear '.$name.' '.$mobile.', Your Order: '.$orderId.' worth '.$totalAmount.', is ready to deliver, please collect your garments at Our Store or Our Delivery Boy will reach you soon. Thanks, CBS-'.$storeName.' '.$storeMobile;
              $this->_coreSMS($mobile,$customerMessage); 
            }
          }
          public function regSMS($customerObj,$password){
            if(is_object($customerObj)){
              $name = $customerObj->getFirstName().' '.$customerObj->getLastName();
              $mobile = $customerObj->getMobile();
              $os_push_token = $customerObj->getOsPushToken();
              $os_player_id = $customerObj->getOsPlayerId();
              $message ='';
          //  $message .=' Dear '.$name.' '.$mobile.' Your password for CBS Mobile Application is '.$password.' Thanks';
              $message .=' Dear '.$name.' ('.$mobile.'), Your password for CBS Mobile Application is '.$password.' Thanks';
              $this->sendNotification($os_player_id,'Dear '.$name,$message);
              $this->_coreSMS($mobile,$message);    
            }
          }
          public function sendSMS($orderObj,$type){
            if($type=='mobile'){
             $this->_mobileSMS($orderObj);
           }else if($type=='store'){
             $this->_storeSMS($orderObj);
           }else{
           }
         }
         public function sendNotification($player_id, $heading='Dear Customer',$message='Welcome to CBS.'){
          $fields = array(
            "app_id"=>"3d6b5d21-d209-41bd-9e87-e2cae772baec",
            "include_player_ids"=>is_array($player_id)?$player_id:array($player_id),
            "data"=>array("targetUrl"=> "app.orderHistory"),
            "contents"=> array("en"=> $message,"hi"=>$message),
            "headings"=>array("en"=>$heading,"hi"=>$heading),
            "android_sound"=>"raw/notification"
            );
          $fields = json_encode($fields);
       // print("\nJSON sent:\n");
        //print($fields);
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
          curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
           'Authorization: Basic ZTY4ZWQ4OTUtODBhZC00NDdiLWFlN2UtNjgwM2EyYTNiMmY3'));
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
          curl_setopt($ch, CURLOPT_HEADER, FALSE);
          curl_setopt($ch, CURLOPT_POST, TRUE);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
          $response = curl_exec($ch);
          curl_close($ch);
          return $response;
        }
        private function _coreSMS($mobile,$message){
         $url ="http://mobicomm.dove-sms.com/mobicomm/submitsms.jsp";
         $xml_data ='<?xml version="1.0"?>
         <parent>
          <child>
            <user>Citybus</user>
            <key>296323137bXX</key>
            <mobile>+91'.$mobile.'</mobile>
            <message>'.$message.'</message>
            <accusage>1</accusage>
            <senderid>LWAVES</senderid>
          </child>
        </parent>';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
        return 1;
      }
      private function _coreMultiSMS($messages){
         $url ="http://mobicomm.dove-sms.com/mobicomm/submitsms.jsp";
         $xml_data ='<?xml version="1.0"?><parent>';
         foreach ($messages as $k => $v) {
           $xml_data .='<child>
                          <user>Citybus</user>
                          <key>296323137bXX</key>
                          <mobile>+91'.$k.'</mobile>
                          <message>'.$v.'</message>
                          <accusage>1</accusage>
                          <senderid>LWAVES</senderid>
                        </child>';
         }
         $xml_data .='</parent>';
          log_message('error',' message texted');  
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
        return 1;
      }
    }
