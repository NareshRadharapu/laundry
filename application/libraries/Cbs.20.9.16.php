<?php

class Cbs{
    public $doctrine;

    public function __construct($em)
    {
       if(is_object($em)){
            $this->_em = $em;
            $this->_qb = $em->createQueryBuilder(); 
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
                $itemCost = $catalogPriceObj->getCost() + $catalogPriceObj->getDiscount();
            }
        return $itemCost;
    }

    public function lostPlaceOrderItem($orderId, $itemId, $serviceId){

        $qb = $this->_em->createQueryBuilder();
        $placeOrderItemObj  = $qb->select('p')->from('Entity\PlaceOrder','p')->where('p.order_id=:orderId and p.item_id=:itemId and p.service_id =:serviceId')->setParameter('orderId',$orderId)->setParameter('itemId',$itemId)->setParameter('serviceId',$serviceId)->getQuery()->getSingleResult();
            
            if(is_object($placeOrderItemObj)){
                $placeOrderItemObj->addRIcount();
            }
        return $this->_em->persist($placeOrderItemObj);
    }

    public function findPlaceOrderItem($orderId, $itemId, $serviceId){

        $qb = $this->_em->createQueryBuilder();
        $placeOrderItemObj  = $qb->select('p')->from('Entity\PlaceOrder','p')->where('p.order_id=:orderId and p.item_id=:itemId and p.service_id =:serviceId')->setParameter('orderId',$orderId)->setParameter('itemId',$itemId)->setParameter('serviceId',$serviceId)->getQuery()->getSingleResult();
            
            if(is_object($placeOrderItemObj)){
                $placeOrderItemObj->subsRIcount();
            }
        return $this->_em->persist($placeOrderItemObj);
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
        $discount = $orderObj = $this->_getOrderObj($orderId)->getAdminDiscount();
        $discountAmount = ($totalCost*$discount)/100;
        return $totalCost + $serviceTaxAmount - $discountAmount;
    }
    private function _getSettings(){
        $ssObj = $this->_em->find('Entity\Settings',1);
        return is_object($ssObj)?$ssObj:null;
    }

    private function _getOrderObj($orderId){
        $orderObj = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('order_id'=>$orderId));
        return is_object($orderObj)?$orderObj:null;
    }

    public function changeOrderStatus($orderId,$status,$message){
            

            $placeOrderObj = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('order_id'=>$orderId));
            
                $placeOrderObj->setOrderStatus($status);
                $placeOrderObj->setOrderStatusMessage($message);
              
                $poObj = $this->_em->getRepository('Entity\PlaceOrder')->findBy(array('order_id'=>$orderId));

                foreach ($poObj as $key => $obj) {
                    foreach ($obj->getProcessOrders() as $key => $pi) {
                        if($pi->getItemStatus()!='returned'){
                            $pi->setItemStatus($status);
                            $pi->setItemStatusMessage($message);    
                        }
                    }
                }

            if($status){
                $this->_em->persist($placeOrderObj);
                $this->_em->flush();    
                return true;
            }
            return false; 
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
            
            if($sc>0){
                $status = 'partially delivered';
            }else{
                $status = 'delivered';
            }
            $placeOrderObj->setOrderStatus($status);
            $placeOrderObj->setOrderStatusMessage($message);
            
            $this->_em->persist($placeOrderObj);
            $this->_em->persist($processOrderObj);
            $this->_em->flush();
            return true;
    }

    private function _storeSMS($orderObj){
        if(is_object($orderObj)){

            $customerObj    = $orderObj->getCustomerId();
            $orderId        = $orderObj->getOrderId();
            $totalAmount    = $orderObj->getTotalAmount();
            $name   = $customerObj->getFirstName().' '.$customerObj->getLastName();
            $mobile = $customerObj->getMobile();
            $storeObj = $orderObj->getAddressId()->getAreaId();
            
            if(is_object($storeObj)){
                $storeName      = $storeObj->getName();
                $storeMobile    = $storeObj->getMobile();
            }
            
            $message ='';
            

            //            $message .='Dear '.$name.' '.$mobile.',Your Order: '.$orderId.' worth '.$totalAmount.', is successfully placed.                 Thanks,LaundryWaves-'.$storeName.''.$storeMobile;

                $message .='Dear '.$name;
                $message .= $mobile;
                $message .='Your Order: '.$orderId.' worth '.$totalAmount.', is successfully placed.';
                $message .='Thanks,';
                $message .=$storeName;
                $message .=$storeMobile;

                 $this->_coreSMS($mobile,$message);   
        }
    }

    private function _mobileSMS($orderObj){

        if(is_object($orderObj)){

            $customerObj    = $orderObj->getCustomerId();
            $orderId        = $orderObj->getOrderId();
            $totalAmount    = $orderObj->getTotalAmount();
            $name   = $customerObj->getFirstName().' '.$customerObj->getLastName();
            $mobile = $customerObj->getMobile();

            $storeObj = $orderObj->getAddressId()->getAreaId();
            
            if(is_object($storeObj)){
                $storeName      = $storeObj->getName();
                $storeMobile    = $storeObj->getMobile();
            }
            
            $message ='';
            $message .=' Dear '.$name.' '.$mobile.',
                Your Order: '.$orderId.' worth '.$totalAmount.', is successfully placed. Our Pickup Boy will reach you soon.  
                Thanks,
                LaundryWaves-'.$storeName.'
                '.$storeMobile;

                 $this->_coreSMS($mobile,$message);   
        }

    }

    public function regSMS($customerObj,$password){
        if(is_object($customerObj)){
            $name = $customerObj->getFirstName().' '.$customerObj->getLastName();
            $mobile = $customerObj->getMobile();

            $message ='';
            $message .=' Dear '.$name.' '.$mobile.' Your password for Laundry Waves Mobile Application is '.$password.' 
                Thanks';

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


}