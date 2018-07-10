<?php
/****
  @Author : Rk
  @Date : Dec 10
  @Description : sms gate way integration of both transactional and promotional. written all core functions 
  @functions 
  - sendStoreCustomerSms - custom sms
  - balanceAmountSendingSMS - pending balance inform to the customers
  - customerRequestPickupBoyAssign - after customer order request 
  -
***/
class Sms{ 
  public $doctrine;  
  private $_adminMobile = '8886561413';
  public $em;
  public function __construct($em)
  {
    if(is_object($em)){
      $this->_em = $em;
      $this->_qb = $em->createQueryBuilder(); 
    } 
  }
  /***
  @Author : Rk
  @Date: Dec 10, 16
  @Desc: Payment information sms
    - after order payment we are sending this sms
  @Params 
    - $tranction history - object -tranction history object 
  ***/
  public function paymentInfoSms($transactionHistoryObj){
      if(is_object($transactionHistoryObj)){
          $customerObj = $transactionHistoryObj->getCustomerId();
          $name = $customerObj->getFirstName().' '.$customerObj->getLastName();
          $mobile = $customerObj->getMobile();     
          $usedAmount = $transactionHistoryObj->getUsedAmount();
          $paidAmount = $transactionHistoryObj->getPaidAmount();
          $orderId    = $transactionHistoryObj->getOrderId();      
          $dateObj    = $transactionHistoryObj->getCreatedAt();          
          $date       = is_object($dateObj)?$dateObj->format('d M Y'):date('d M Y');
          $placeOrderId = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('order_id'=>$orderId));
          $receiptNo = $placeOrderId->getId();
         // $balanceAmount = $placeOrderId->getBlanceAmount();
          $message = '';
          $message .=' Dear '.$name.', Payment received for';  
          $message .=' Paid Amt Rs. '.$paidAmount.' Used Amt Rs. '.$usedAmount.' on '.$date.', for order: '.$receiptNo. '. Payments will be updated in 3hrs';
          $message .=', Regards CBS';
          $this->_coreSMS($mobile, $message, false);
      }else{
        $msg = 'Dear admin, customer sms went somthing wrong ';
        $this->_coreSMS($_adminMobile,$msg, false);
      }
  }
  /***
  @Author : Rk
  @Date: Dec 10, 16
  @Desc: Send Store Customer Sms
    - when store admin has to inform some custom message to all his customers
  @Params 
    - $customerRequestObj - object - customer Request object 
  ***/
  public function sendStoreCustomerSms($smsArray){
     $this->_coreMultiSMS($smsArray);
  }
  /***
  @Author : Narresh radharapu
  @Date: Sept 11, 17
  @Desc: Send Custom Sms
    - when store admin has to inform some custom message to all his customers
  @Params 
    - $customerRequestObj - object - customer Request object 
  ***/
  public function sendCustomSms($smsArray){
     $this->_coreMultiSMS($smsArray);
  }
  /***
  @Author : Rk
  @Date: Dec 10, 16
  @Desc: Balance Amount Sending SMS
    - when we store admin has to inform all respective store customers with their balance amount then this sms will help you, is as 
    "Dear XXXXXXX, thank you for associating with Laundy Waves. Your current pending balance is : XXXX"
  @Params 
    - $messages - array - this is array of array with customer mobile number with message
  ***/
  public function balanceAmountSendingSMS($messages){
      $smsArray = array();
      foreach($messages as $k=>$v){
        $smsArray[$v['mobile']] = $v['message'];
      }
      $this->_coreMultiSMS($smsArray);
  }
  /***
  @Author : Rk
  @Date: Dec 10, 16
  @Desc: customer request sms 
    --  Dear Customer, our pickup agent Name(XXXX), Phone no(XXXX) will reach you between xxxxx(Time Slot). Thank you CBS Store Name(XXXXX).
    - after pickup boy assigning to customer request then we are informing to customer through sms as 
    ""
  @Params 
    - $customerRequestObj - object - customer Request object 
  ***/
  public function customerRequestPickupBoyAssign($customerRequestObj){
      if(is_object($customerRequestObj)){
          $customerObj = $customerRequestObj->getCustomerId();
          $name = $customerObj->getFirstName().' '.$customerObj->getLastName();
          $mobile = $customerObj->getMobile();
          $slot = $customerRequestObj->getSlot();
          $store = $customerRequestObj->getAreaId()->getName();
          $pbname = $customerRequestObj->getPickupBoyId()->getName();
          $pbmobile = $customerRequestObj->getPickupBoyId()->getMobile();
          $dateObj = $customerRequestObj->getDate();              
          $crdate       = is_object($dateObj)?$dateObj->format('d M Y'):date('d M Y');
          $message = '';
          $message .=' Dear '.$name.', our pickup agent '.$pbname. ',' .$pbmobile.' will reach you on '.$crdate.' between '.$slot.'(Time Slot)';  
          $message .=', Thank you CBS, '.$store;
      $this->_coreSMS($mobile, $message, false);
      }else{
        $msg = 'Dear admin, customer sms went somthing wrong ';
        $this->_coreSMS($_adminMobile,$msg, false);
      }
  }
  /***
  @Author : Rk
  @Date: Dec 10, 16
  @Desc: customer request sms 
    - after pickup boy assigning to customer order then we are informing to customer through sms as 
    ""
  @Params 
    - $orderObj - object - place order id object 
    -- Dear Customer, our pickup agent Name(XXXX), Phone no(XXXX) will reach you soon to collect garments. Thank you CBS - Store Name(XXXXX).
  ***/
  public function placeOrderPickupBoyAssign($orderObj){
    if(is_object($orderObj)){
          $customerObj = $orderObj->getCustomerId();
          $name = $customerObj->getFirstName().' '.$customerObj->getLastName();
          $store = $customerObj->getAreaId()->getName();
          $mobile = $customerObj->getMobile();
          $pickupboyObj = $orderObj->getPickupBoyId();
          if(is_object($pickupboyObj)){
            $pbname  = $pickupboyObj->getName();
            $pbmobile = $pickupboyObj->getMobile();
          }else{
            $pbname  = '';
            $pbmobile = '';
          }
          $dateObj = $orderObj->getUpdatedAt();              
          $date       = is_object($dateObj)?$dateObj->format('d M Y'):date('d M Y');
          $message = '';
          $message .=' Dear '.$name.', our pickup agent '.$pbname.', '.$pbmobile.' will reach you on  '.$date.' to collect garments.';  
         $message .=' Thank you CBS, '.$store;
     log_message('error',$date);
      $this->_coreSMS($mobile, $message, false);
      }else{
          log_message('error',$this->_adminMobile);
        $msg = 'Dear admin, customer sms went somthing wrong ';
        $this->_coreSMS($this->_adminMobile, $msg, false);
      }
  }
  public function placeOrderDeliveryBoyAssign($orderObj){
    if(is_object($orderObj)){
          $customerObj = $orderObj->getCustomerId();
          $name = $customerObj->getFirstName().' '.$customerObj->getLastName();
          $store = $customerObj->getAreaId()->getName();
          $mobile = $customerObj->getMobile();
          $pickupboyObj = $orderObj->getDeliveryBoyId();
          if(is_object($pickupboyObj)){
            $pbname  = $pickupboyObj->getName();
            $pbmobile = $pickupboyObj->getMobile();
          }else{
            $pbname  = '';
            $pbmobile = '';
          }
          $dateObj = $orderObj->getUpdatedAt();              
          $date       = is_object($dateObj)?$dateObj->format('d M Y'):date('d M Y');
          $message = '';
          $message .=' Dear '.$name.', our delivery agent '.$pbname.', '.$pbmobile.' will reach you on  '.$date.' to delivery garments.';  
         $message .=' Thank you CBS, '.$store;
     log_message('error',$date);
      $this->_coreSMS($mobile, $message, false);
      }else{
          log_message('error',$this->_adminMobile);
        $msg = 'Dear admin, customer sms went somthing wrong ';
        $this->_coreSMS($this->_adminMobile, $msg, false);
      }
  }
  /***
  @Author : Rk
  @Date: Dec 10, 16
  @Desc: customer request sms 
    - send message with 
    -- user details 
    -- garment details
    -- Dear Customer, we have received your order request, our pickup agent will reach you between xxxxx(Time Slot). Thank you CBS Store Name(XXXXX).
  @Params 
    - $customerRequestObj - object - customerRequest object 
  ***/
  public function customerRequestSMS($customerRequestObj){
      if(is_object($customerRequestObj)){
          $customerObj = $customerRequestObj->getCustomerId();
          $name = $customerObj->getFirstName().' '.$customerObj->getLastName();
          $mobile = $customerObj->getMobile();
          $slot = $customerRequestObj->getSlot();
          $store = $customerObj->getAreaId()->getName();
          $dateObj = $customerRequestObj->getDate();              
          $crdate       = is_object($dateObj)?$dateObj->format('d M Y'):date('d M Y');
          $message = '';
          $message .=' Dear '.$name.', we have received your order request, our pickup agent will reach you on '.$crdate.' between '.$slot.'(Time Slot)';  
          $message .=', Thank you CBS, '.$store;
      $this->_coreSMS($mobile, $message, false);
      }else{
        $msg = 'Dear admin, customer sms went somthing wrong ';
        $this->_coreSMS($this->_adminMobile,$msg, false);
      }
  }
  /***
  @Author : Rk
  @Date: Dec 10, 16
  @Desc: return garments sms function 
    - send message with 
    -- user details 
    -- garment details
  @Params 
    - $$processObj - object - process order object 
  ***/
  public function returnGarmentSms($processObj){
      if(is_object($processObj)){
          $customerObj = $processObj->getCustomerId();
          $name = $customerObj->getFirstName().' '.$customerObj->getLastName();
          $mobile = $customerObj->getMobile();
          $service = $processObj->getServiceId()->getName();
          $item = $processObj->getItemId()->getName();
          $itemType = $processObj->getItemId()->getItemTypeId()->getName();
          $orderId = $processObj->getOrderId();
          $receiptNo = '';
          $placeOrderId = $this->_em->getRepository('Entity\PlaceOrderId')->findOneBy(array('order_id'=>$orderId));
          if(is_object($placeOrderId)){
            $closingBlanace = $placeOrderId->getClosingBalance();  
            $receiptNo = $placeOrderId->getId();  
          }else{
            $closingBlanace = $orderId;
          }
          $message = '';
          $message .=' Dear '.$name.', ';  
          $message .=' there is a return garment in your order with receipt no '.$receiptNo.' in';
          $message .=' service: '.htmlspecialchars($service).'';
          $message .=' item type: '.$itemType;
          $message .=' item: '.$item;
          $message .=' your garment will be delivered soon.';
          $message .=' Your revised order Amount: "'.$closingBlanace.'"';
         $this->_coreSMS($mobile, $message, false);
      }else{
        $msg = 'Dear admin, customer sms went somthing wrong ';
        $this->_coreSMS($this->_adminMobile,$msg, false);
      }
  }
  /***
  @Author : Rk
  @Date: Dec 10, 16
  @Desc: this is thank you sms function After user Registration
    - send message with 
    -- user details 
    -- password
  @Params 
    - $customerObj - object - customer object 
  ***/
  public function thankYouNDetailsMessage($customerObjOrId, $password=''){
      $customerObj = null;
      if(is_object($customerObjOrId)){
        $customerObj = $customerObjOrId;
      }else{
        $customerObj = $this->_em->find('Entity\Customer',$customerObjOrId);
      }
      if(is_object($customerObj)){
          $name = $customerObj->getFirstName().' '.$customerObj->getLastName();
          $mobile = $customerObj->getMobile();
          $message = '';
          $message .='Dear '.$name.', ';  
          $message .='Welcome to CBS. ';
          $message .='Login Details: '; 
          $message .='Mobile : '.$mobile;
          $message .='password :'.$password;
          $message .='Mobile App https://goo.gl/Ai7rI3';
         $this->_coreSMS($mobile, $message, false);
      }else{
        $msg = 'Dear admin, customer sms went somthing wrong ';
        $this->_coreSMS($this->_adminMobile,$msg, false);
      }
  }
  /***
  @Author : Rk
  @Date: Dec 10, 16
  @Desc: this is private function you can't call it,  only store sms function 
  @Params 
    - $orderObj - object - order object 
  ***/
  private function _storeSMS($orderObj){
    if(is_object($orderObj)){
              $customerObj    = $orderObj->getCustomerId();
              $orderId        = $orderObj->getOrderId();
              $receiptNo      = $orderObj->getId();
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
              $message .='Dear '.$name;
              $message .=' ' .$mobile;
              $message .=' Your Order: '.$receiptNo.' with '.$totalItems.' garments, worth '.$totalAmount.', is successfully placed.';
              $message .=' Thanks,';
              $message .=' ' .$storeName;
              $message .=' ' .$storeMobile;
              $this->sendNotification($os_player_id,'Dear '.$name,$message);
              $this->_coreSMS($mobile,$message);   
            }
  }
  /***
  @Author : Rk
  @Date: Dec 10, 16
  @Desc: this is only mobile function  
  @Params 
    - $orderObj - object - order object 
  ***/
  private function _mobileSMS($orderObj){
    if(is_object($orderObj)){
      $customerObj    = $orderObj->getCustomerId();
      $orderId        = $orderObj->getOrderId();
      $receiptNo      = $orderObj->getId();
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
      $customerMessage =' Dear '.$name.' '.$mobile.', Your Order: '.$receiptNo.' worth '.$totalAmount.', is successfully placed. Our Pickup Boy will reach you soon. Thanks, CBS-'.$storeName.' '.$storeMobile;
      $storeMessage =' Dear '.$storeName.', '.$name.' '.$mobile.', has placed an Order: '.$receiptNo.' worth Rs. '.$totalAmount;
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
  /***
  @Author : Rk
  @Date: Dec 10, 16
  @Desc: 
  @Params 
    - $orderObj - object - order object 
  ***/
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
      $customerMessage =' Dear '.$name.' '.$mobile.', Your Order: '.$orderId.' worth '.$totalAmount.', is ready to deliver, please collect your garments at Our Store or Our Delivery Boy will reach you soon. Thanks, CBS-'.$storeName.' '.$storeMobile;
      $this->_coreSMS($mobile,$customerMessage); 
    }
  }
  /***
  @Author : Rk
  @Date: Dec 10, 16
  @Desc: 
  @Params 
    - $customerObj - object - customer object 
    - $password - string password;
  ***/  
  public function regSMS($customerObj,$password){
    if(is_object($customerObj)){
      $name = $customerObj->getFirstName().' '.$customerObj->getLastName();
      $mobile = $customerObj->getMobile();
      $os_push_token = $customerObj->getOsPushToken();
      $os_player_id = $customerObj->getOsPlayerId();
      $message .=' Dear '.$name.' ('.$mobile.'), Your password for CBS Mobile Application is '.$password.' Thanks';
      $this->_coreSMS($mobile,$message,'tansc');    
    }
  }
  /***
  @Author : Rk
  @Date: Dec 10, 16
  @Desc: 
  @Params 
    - $orderObj - object - order object 
    - $type - string mobile or store
  ***/
  public function sendSMS($orderObj, $type){
    if($type=='mobile'){
      $this->_mobileSMS($orderObj);
    }else if($type=='store'){
      $this->_storeSMS($orderObj);
    }
  }
  /***
  @Author : Rk
  @Date: Dec 10, 16
  @Desc: sending sms to single mobile no
  @Params 
    - $mobile - mobile number
    - $message - string - message
    - $t - string trans or promo
  ***/
  private function _coreSMS($mobile, $message, $t=false){
    $tv = $t=='trans'?1:2;
    $url ="http://mobicomm.dove-sms.com/mobicomm/submitsms.jsp";
      $xml_data ='<?xml version="1.0"?>
        <parent>
          <child>
            <user>Citybus</user>
            <key>296323137bXX</key>
            <mobile>+91'.$mobile.'</mobile>
            <message>'.$message.'</message>
            <accusage>'.$tv.'</accusage>
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
  /***
  @Author : Rk
  @Date: Dec 10, 16
  @Desc: sending multiple sms to multiple customers 
  @Params 
    - $messages - array (mobileno, message)
    - $t - string trans or promo
  ***/
  private function _coreMultiSMS($messages, $t=false){
        $tv = $t=='trans'?1:2;
         $url ="http://mobicomm.dove-sms.com/mobicomm/submitsms.jsp";
         $xml_data ='<?xml version="1.0"?><parent>';
         foreach ($messages as $k => $v) {
           $xml_data .='<child>
                          <user>Citybus</user>
                          <key>296323137bXX</key>
                          <mobile>+91'.$k.'</mobile>
                          <message>'.$v.'</message>
                          <accusage>'.$tv.'</accusage>
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
}
