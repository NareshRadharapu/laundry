<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/**
 *@ORM\Table
 * @Entity
 * @Table(name="customers")
 */
class Customer
{
     /**
     * @var integer $id
     *@Column(name="cust_id", type="integer", nullable=false) @Id @GeneratedValue
     */
     private $id;
     /**    @Column(name="firstname", type="string") */
     private $firstname;
     /**    @Column(name="lastname", type="string", nullable="true") */
     private $lastname;
     /**    @Column(name="gender", type="string", nullable="true") */
     private $gender;
     /**    @Column(name="email", type="string", nullable="true") */
     private $email;
     /**    @Column(name="mobile", type="bigint",length="12", unique="true") */
     private $mobile;
     /**    @Column(name="whatsapp", type="string", nullable="true") */
     private $whatsapp;
     /**    @Column(name="type", type="string", nullable="true") */
     private $type;
     /**    @Column(name="subType", type="string", nullable="true") */
     private $subType;
     /**    @Column(name="password", type="string") */
     private $password;
     /**    @Column(name="passwordSalt", type="string", options={"unsigned"=TRUE}) */
     private $passwordSalt;
     /**    @Column(name="address", type="string", nullable="true") */
     private $address;
     /**    @Column(name="ownerName", type="string", nullable="true") */
     private $ownerName;
     /**    @Column(name="ownerMobile", type="string", nullable="true") */
     private $ownerMobile;
     /**    @Column(name="ownerAddress", type="string", nullable="true") */
     private $ownerAddress;
     /**    @Column(name="ref_id", type="string", nullable="true") */
     private $ref_id;
     /**    @Column(name="facebook", type="string", nullable="true") */
     private $facebook;
     /** @Column(name="wallet", type="string", nullable="true") */
     private $wallet;
     /** @Column(name="refundAmount", type="string", nullable="true") */
     private $refundAmount;
     /**    @Column(name="oauth_id", type="string", nullable="true") */
     private $oauth_id;
     /** @Column(name="os_player_id", type="string", nullable="true") */
     private $os_player_id;
     /** @Column(name="os_push_token", type="text", nullable="true") */
     private $os_push_token;
     /**    @Column(name="rpoints", type="smallint", nullable="true") */
     private $rpoints;
     /**    @Column(name="firstOrder", type="smallint", nullable="true") */
     private $firstOrder;
     /**    @Column(name="resetPassword", type="boolean",options={"default"=0}) */
     private $resetPassword;
     /**    @Column(name="showInTele", type="boolean",options={"default"=1}) */
     private $showInTele;
     /**    @Column(name="isStaying", type="boolean", options={"default"=1}) */
     private $isStaying;
     /** @Column(name="isStarch", type="boolean", options={"default"=1}) */
     private $isStarch;
     /** @Column(name="isProblematic", type="boolean", options={"default"=1}) */
     private $isProblematic;
     /** @Column(name="isPerfume", type="boolean", options={"default"=1}) */
     private $isPerfume;
     /** @Column(name="minOrderValue", type="string", nullable="true", options={"default"=1}) */
     private $minOrderValue;
     /** @Column(name="maxOrderValue", type="string", nullable="true", options={"default"=1}) */
     private $maxOrderValue;
     /** @Column(name="avgOrderValue", type="string", nullable="true", options={"default"=1}) */
     private $avgOrderValue;
     /** @Column(name="totalOrderValue", type="string", nullable="true", options={"default"=1}) */
     private $totalOrderValue;
     /** @Column(name="discountOrderValue", type="string", nullable="true", options={"default"=1}) */
     private $discountOrderValue;
     /** @Column(name="totalOrders", type="integer", nullable="true", options={"default"=1}) */
     private $totalOrders;
     /** @Column(name="serviceWiseRevenue", type="text", nullable="true", options={"default"=1}) */
     private $serviceWiseRevenue;
     /** @Column(name="serviceWiseItems", type="text", nullable="true", options={"default"=1}) */
     private $serviceWiseItems;    
     /** @Column(name="lattitude", type="string", nullable="true", options={"default"=1}) */
     private $lattitude;
     /** @Column(name="longitude", type="string", nullable="true", options={"default"=1}) */
     private $longitude;
     /** @Column(name="damageAmountTill", type="string", nullable="true", options={"default"=1}) */
     private $damageAmountTill;
     /** @Column(name="referralAmountTill", type="string", nullable="true", options={"default"=1}) */
     private $referralAmountTill;
     /** @Column(name="avarageProcessingDelay", type="integer", nullable="true", options={"default"=1}) */
     private $avarageProcessingDelay;    
     /**    @Column(name="status", type="boolean",options={"default"=1}) */
     private $status;
     /**    @Column(name="dob", type="date", nullable="true") */
     private $dob;
     /** @Column(name="aniversaryDate", type="date", nullable="true") */
     private $aniversaryDate;
     /**    @Column(name="updated_at", type="datetime") */
     private $updated_at;
     /**     @var \DateTime @Column(name="created_at", type="datetime") */
     private $created_at;
    /** @ManyToOne(targetEntity="Apartment", inversedBy="customers")
    *   @JoinColumn(name="apt_id", referencedColumnName="apt_id", nullable=TRUE) */
    private $apt_id;
    /** @ManyToOne(targetEntity="Block", inversedBy="customers", cascade={"all"})
    *   @JoinColumn(name="block_id", referencedColumnName="block_id",  nullable=TRUE) */
    private $block_id;
    /** @ManyToOne(targetEntity="Flat", inversedBy="customers", cascade={"all"})
    *   @JoinColumn(name="flat_id", referencedColumnName="flat_id", nullable=TRUE)  */
    private $flat_id;
    /** @ManyToOne(targetEntity="Customer", inversedBy="customers", cascade={"all"})
    *   @JoinColumn(name="owner_id", referencedColumnName="cust_id", nullable=TRUE)     */
    private $owner_id;
    /** @ManyToOne(targetEntity="Area", inversedBy="customers")
     * @JoinColumn(name="area_id", referencedColumnName="area_id", nullable=TRUE)     */
    private $area_id;
    /** @OneToMany(targetEntity="PlaceOrder", mappedBy="cust_id", cascade={"all"}) */
    private $placeOrders;
    /** @OneToMany(targetEntity="TempOrder", mappedBy="cust_id") */
    private $tempOrders;
    /** @OneToMany(targetEntity="PlaceOrderId", mappedBy="customer_id", cascade={"all"}) */
    private $placeOrderIds;
    /** @OneToOne(targetEntity="CustomerAddress", mappedBy="cust_id", cascade={"all"}) */
    private $customerAddress;
    /** @OneToMany(targetEntity="TransactionHistory", mappedBy="customer_id", cascade={"all"})
    @OrderBy({"created_at" = "DESC"}) */
    private $transactionHistory;
    /** @ManyToOne(targetEntity="PickupBoy", inversedBy="customers")
     * @JoinColumn(name="agent_id", referencedColumnName="pb_id", nullable=TRUE)     */
    private $agent_id;
    /** @ManyToOne(targetEntity="Package", inversedBy="customers")
     * @JoinColumn(name="package_id", referencedColumnName="package_id", nullable=TRUE)     */
    private $package_id;
    /** @Column(name="package", type="string", nullable="true") */
    private $package;
    /** @Column(name="packageDetails", type="text", nullable="true") */
    private $packageDetails;
    /** @Column(name="packageUsedDetails", type="text", nullable="true") */
    private $packageUsedDetails;
    /** @Column(name="packageCode", type="string", nullable="true") */
    private $packageCode;
    /** @Column(name="packageStatus", type="boolean", nullable="true") */
    private $packageStatus;
    /** @Column(name="discountPercent", type="integer") */
    private $discountPercent;
    /** @Column(name="discountExpiry", type="date") */
    private $discountExpiry;
    /** @Column(name="vendorId", type="integer") */
    private $vendorId;
    public function __construct(){
      $this->placeOrders                = new ArrayCollection(); 
      $this->placeOrderIds          = new ArrayCollection(); 
        //$this->customerAddress          = new ArrayCollection();
      $this->transactionHistory       = new ArrayCollection();
      $this->passwordSalt           = "";
      $this->status                 = 0;
      $this->firstOrder             = 1;
      $this->resetPassword          = 0;
      $this->showInTele             = 1;
      $this->isStaying              = 1;
      $this->wallet                   = 0;
      $this->refundAmount             = 0;
      $this->created_at                 = new \DateTime();
      $this->updated_at                 = new \DateTime();
      $this->packageStatus            =0;
      $this->package                  ='';
      $this->isStarch = 0;
      $this->isProblematic = 0;
      $this->isPerfume = 0;
    }
    public function updateTrigger($obj){
      $orderValue = array();
      $pt = array();
      $dov = array();
      foreach($obj->getPlaceOrderIds() as $ok => $ov) {
        if(!$ov->getIsDelete()){
          $orderValue[]   = $ov->getClosingBalance();
          $dov[]          = $ov->getAdminDiscountAmount();
          if($ov->getOrderStatus()=='DO'){
            $pt[]           = $ov->getProcessDelayInDays();    
          }
        }   
      }
      $obj->minOrderValue           = min($orderValue);
      $obj->maxOrderValue           = max($orderValue);
      $obj->totalOrderValue         = number_format(array_sum($orderValue),2,'.','');
      $obj->totalOrders       = count($orderValue);
      $obj->avgOrderValue           = number_format((array_sum($orderValue)/count($orderValue)),2,',','');
      if(count($pt)){
        $obj->avarageProcessingDelay  = array_sum($pt)/count($pt);
      }else{
        $obj->avarageProcessingDelay  = 0;
      }
      $obj->discountOrderValue      = array_sum($dov);   
      $serviceWiseRevenue = array();
      $serviceWiseItems = array();
      foreach ($obj->getPlaceOrders() as $p => $pi) {
        $itemName = $pi->getItemId()->getName();
        $serviceName = $pi->getServiceId()->getName();
        $itemType = $pi->getItemId()->getItemTypeId()->getName();
        $item = $itemType.'-'.$itemName;
        $itemCost = $pi->getCost();
        $itemCount = $pi->getItemCount();
        if(array_key_exists($serviceName, $serviceWiseRevenue)){
          $serviceWiseRevenue[$serviceName] = $serviceWiseRevenue[$serviceName] + $itemCost;
        }else{
          $serviceWiseRevenue[$serviceName] = $itemCost;
        }
        if(array_key_exists($item, $serviceWiseItems)){
          $serviceWiseItems[$item] = $serviceWiseItems[$item] + $itemCount; 
        }else{
          $serviceWiseItems[$item] = $itemCount;
        }
      }
      $obj->serviceWiseRevenue = json_encode($serviceWiseRevenue);
      $obj->serviceWiseItems = json_encode($serviceWiseItems);
    }
    public function getOrderFrequence(){
     $today = new \DateTime('today');
     $start  = $this->created_at;
     $dDiff = $start->diff($today);
     $dDiff->format('%R');
     $days = $dDiff->days;
     $orders = $this->totalOrders;
     return $orders==0?0:ceil($days/$orders);
   }
   public function setLongitude($longitude){
    $this->longitude = $longitude;
  }
  public function getLongitude(){
    return   $this->longitude;
  }
  public function setLattitude($lattitude){
    $this->lattitude  = $lattitude;
  }
  public function getLattitude(){
    return $this->lattitude;
  }
  public function setDiscountPercent($discountPercent){
    $this->discountPercent = $discountPercent;
  }
  public function getDiscountPercent(){
    return $this->discountPercent;
  }
  public function setDiscountExpiry($discountExpiry){
    if($discountExpiry)
      $this->discountExpiry = new \DateTime($discountExpiry); 
  }
  public function getDiscountExpiry(){
    return $this->discountExpiry;
  }
  public function setVendorId($vendorId){
    $this->vendorId = $vendorId;
  }
  public function getVendorId(){
    return $this->vendorId;
  }
  public function setMinOrderValue($minOrderValue){
    $this->minOrderValue = $minOrderValue;
  }
  public function getMinOrderValue(){
    return $this->minOrderValue;
  }
  public function setMaxOrderValue($maxOrderValue){
    $this->maxOrderValue = $maxOrderValue;
  }
  public function getMaxOrderValue(){
    return $this->maxOrderValue;
  }
  public function getAvgOrderValue(){
    return $this->avgOrderValue;
  }
  public function getTotalOrderValue(){
    return $this->totalOrderValue;
  }
  public function getTotalOrders(){
    return $this->totalOrders;
  }
  public function getDiscountOrderValue(){
    return $this->discountOrderValue;
  }
  public function getAvgProcessingDelay(){
    return $this->avarageProcessingDelay;
  }
  public function getSerivceWiseRevenue(){
    return $this->serviceWiseRevenue;
  }
  public function getSerivceWiseItems(){
    return $this->serviceWiseItems;
  }
  public function setIsProblematic($isProblematic){
    $this->isProblematic = $isProblematic;
  }
  public function getIsProblematic(){
    return $this->isProblematic;
  }
  public function setIsStarch($isStarch){
    $this->isStarch = $isStarch;
  }
  public function getIsStarch(){
    return $this->isStarch;
  }
  public function setIsPerfume($isPerfume){
    $this->isPerfume = $isPerfume;
  }
  public function getIsPerfume(){
    return $this->isPerfume;
  }
  public function setAgentId(PickupBoy $agent_id){
    $this->agent_id = $agent_id;
  }
  public function getAgentId(){
    return $this->agent_id;
  }
  public function setPackageId(Package $package_id){
    $this->package_id = $package_id;
  }
  public function getPackageId(){
    return $this->package_id;
  }
  public function setPackageDetails($packageDetails){
    $this->packageDetails = $packageDetails;
  }
  public function getPackageDetails(){
    return $this->packageDetails;
  }
  public function setPackageUsedDetails($packageUsedDetails){
    $this->packageUsedDetails = $packageUsedDetails;
  }
  public function getPackageUsedDetails(){
    return $this->packageUsedDetails;
  }
  public function setPackage($package){
    $this->package = $package;
  }
  public function getPackage(){
    return $this->package;
  }
  public function setPackageCode($packageCode){
    $this->packageCode = $packageCode;
  }
  public function getPackageCode(){
    return $this->packageCode;
  }
  public function setPackageStatus($packageStatus){
    $this->packageStatus = $packageStatus;
  }
  public function getPackageStatus(){
    return $this->packageStatus;
  }
  public function setOsPlayerId($os_player_id){
    $this->os_player_id = $os_player_id;
  }
  public function getOsPlayerId(){
    return $this->os_player_id;
  }
  public function setOsPushToken($os_push_token){
    $this->os_push_token = $os_push_token;
  }
  public function getOsPushToken(){
    return $this->os_push_token;
  }
  /**    Set owner_id    * @param Customer $owner_id     */
  public function setOwnerId(Customer $owner_id=null) {
    $this->owner_id = $owner_id;
    return $this;
  }
  /**   Get owner_id  * @return Customer $owner_id     */
  public function getOwnerId(){
    return $this->owner_id;
  }
  /**    Set apt_id    * @param Apartment $apt_id     */
  public function setApartmentId(Apartment $apt_id=null) {
    $this->apt_id = $apt_id;
    return $this;
  }
  /**   Get apt_id  * @return Apartment $apt_id     */
  public function getApartmentId(){
    return $this->apt_id;
  }
  /**    Set block_id    * @param Block $block_id     */
  public function setBlockId(Block $block_id=null) {
    $this->block_id = $block_id;
    return $this;
  }
  /**   Get block_id  * @return Block $block_id     */
  public function getBlockId(){
    return $this->block_id;
  }
  /**    Set flat_id    * @param Flat $flat_id     */
  public function setFlatId(Flat $flat_id=null) {
    $this->flat_id = $flat_id;
    return $this;
  }
  /**   Get flat_id  * @return Flat $flat_id     */
  public function getFlatId(){
    return $this->flat_id;
  }
  /**    Set area_id    * @param Area $area_id     */
  public function setAreaId(Area $area_id=null) {
    $this->area_id = $area_id;
    return $this;
  }
  /**   Get area_id  * @return Area $area_id     */
  public function getAreaId(){
    return $this->area_id;
  }
  /**  Set customerAddres @return CustomerAddress $customerAddres     */
  public function setCustomerAddress(CustomerAddress $customerAddres) {
    $this->customerAddress = $customerAddres; 
    $customerAddres->setCustomerId($this);           
    return $this;
  }
  /**  Get customerAddress @return CustomerAddress $customerAddress     */
  public function getCustomerAddress(){
    return $this->customerAddress;
  }
  public function getLastAddress(){
    $address = $this->customerAddress;      
    return $address;
  }
  /**  Set PlaceOrder @return PlaceOrder $PlaceOrder     */
  public function setPlaceOrder(PlaceOrder $placeOrder) {
    if (!$this->placeOrders->contains($placeOrder)) {
      $this->placeOrders->add($placeOrder);
      $placeOrder->setCustomerId($this);
    }
    return $this;
  }   
  /**  Get placeOrders @return PlaceOrder $placeOrders     */
  public function getPlaceOrders(){
    return $this->placeOrders;
  }
  public function getPlaceOrderIds(){
    return $this->placeOrderIds;
  }
  public function addTransaction(TransactionHistory $th){
    if(!$this->transactionHistory->contains($th)){
      $this->transactionHistory->add($th);
      $th->setCustomerId($this);
    }
    return $this;
  }
  public function getTransactions(){
    return $this->transactionHistory;
  }
  /** Get id     * @return integer $id     */
  public function getId(){
    return $this->id;
  }
  /** Set firstname  @param string $firstname     */
  public function setFirstName($firstname) {
    $this->firstname = $firstname;
  }
  /**  Get firstname @return string $firstname     */
  public function getFirstName() {
    return $this->firstname;
  }
  /** Set lastname  @param string $lastname     */
  public function setLastName($lastname) {
    $this->lastname = $lastname;
  }
  /**  Get lastname @return string $lastname     */
  public function getLastName() {
    return $this->lastname;
  }
  public function getName(){
    return $this->firstname.' '.$this->lastname;
  }
  /** Set gender  @param string $gender     */
  public function setGender($gender) {
    $this->gender = $gender;
  }
  /**  Get gender @return string $gender     */
  public function getGender() {
    return $this->gender;
  }
  /** Set facebook  @param string $facebook     */
  public function setFacebook($facebook) {
    $this->facebook = $facebook;
  }
  /**  Get facebook @return string $facebook     */
  public function getFacebook() {
    return $this->facebook;
  }
  /** Set wallet  @param string $wallet     */
  public function setWallet($wallet) {
    $this->wallet = $wallet;
  }
  /** Set wallet  @param string $wallet     */
  public function addWallet($wallet) {
    $this->wallet = $this->wallet + $wallet;
  }
  /**  Get wallet @return string $wallet     */
  public function getWallet() {
    return $this->wallet;
  }
  public function getBalanceAmount(){
    $balanceAmount = 0;
    foreach ($this->placeOrderIds as $key => $obj) {
      $balanceAmount += $obj->getBalanceAmount();
    }
    return $balanceAmount;
  }
  public function setRefundAmount($refundAmount){
    $this->refundAmount = $refundAmount;
  }
  public function getRefundAmount(){
    return $this->refundAmount;
  }
  /** Set email  @param string $email     */
  public function setEmail($email) {
    $this->email = $email;
  }
  /**  Get email @return string $email     */
  public function getEmail() {
    return $this->email;
  }
  /** Set dob  @param string $dob     */
  public function setDob($dob) {
    if($dob)
      $this->dob = new \DateTime($dob); 
  }
  /**  Get dob @return string $dob     */
  public function getDob() {
    return $this->dob;
  }
  /** Set aniversaryDate  @param string $aniversaryDate     */
  public function setAniversaryDate($aniversaryDate) {
    if($aniversaryDate)
      $this->aniversaryDate = new \DateTime($aniversaryDate); 
  }
  /**  Get aniversaryDate @return string $aniversaryDate     */
  public function getAniversaryDate() {
    return $this->aniversaryDate;
  }
  /** Set whatsapp  @param string $whatsapp     */
  public function setWhatsapp($whatsapp) {
    $this->whatsapp = $whatsapp;
  }
  /**  Get whatsapp @return string $whatsapp     */
  public function getWhatsapp() {
    return $this->whatsapp;
  }
  /** Set ownerMobile  @param string $ownerMobile     */
  public function setOwnerMobile($ownerMobile) {
    $this->ownerMobile = $ownerMobile;
  }
  /**  Get ownerMobile @return string $ownerMobile     */
  public function getOwnerMobile() {
    return $this->ownerMobile;
  }
  /** Set ownerAddress  @param string $ownerAddress     */
  public function setOwnerAddress($ownerAddress) {
    $this->ownerAddress = $ownerAddress;
  }
  /**  Get ownerAddress @return string $ownerAddress     */
  public function getOwnerAddress() {
    return $this->ownerAddress;
  }
  /** Set showInTele  @param boolean $showInTele     */
  public function setShowInTele($showInTele) {
    $this->showInTele = $showInTele;
  }
  /**  Get showInTele @return boolean $showInTele     */
  public function getShowInTele() {
    return $this->showInTele;
  }
  /** Set isStaying  @param boolean $isStaying     */
  public function setStaying($isStaying) {
    $this->isStaying = $isStaying;
  }
  /**  Get isStaying @return boolean $isStaying     */
  public function getStaying() {
    return $this->isStaying;
  }
  /** Set subType  @param string $subType     */
  public function setSubType($subType) {
    $this->subType = $subType;
  }
  /**  Get subType @return string $subType     */
  public function getSubType() {
    return $this->subType;
  }
  /** Set type  @param string $type     */
  public function setUserType($type) {
    $this->type = $type;
  }
  /**  Get type @return string $type     */
  public function getUserType() {
    return $this->type;
  }
  /** Set address @param string $address     */
  public function setAddress($address){
    $this->address = $address;
  }
  /** Get address @return string $address     */
  public function getAddress(){
    return $this->address;
  }
  /** Set ref_id @param string $ref_id     */
  public function setRefId($ref_id){
    $this->ref_id = $ref_id;
  }
  /** Get ref_id @return string $ref_id     */
  public function getRefId(){
    return $this->ref_id;
  }
  /** Set oauth_id @param string $oauth_id     */
  public function setOauthId($oauth_id){
    $this->oauth_id = $oauth_id;
  }
  /** Get oauth_id @return string $oauth_id     */
  public function getOauthId(){
    return $this->oauth_id;
  }
  /** Set mobile @param string $mobile     */
  public function setPhoneNo($mobile){
    $this->mobile = $mobile;
  }
  /** Get mobile @return string $mobile     */
  public function getPhoneNo(){
    return $this->mobile;
  }
  public function getMobile(){
    return $this->mobile;
  }
  /** Set password @param string $password     */
  public function setPassword($password){
    $this->password = md5($password);
  }
  /** Get mobile @return string $mobile     */
  public function getPassword(){
    return $this->password;
  }
  /** Set rpoints      * @param smallint $rpoints     */
  public function setRpoints($rpoints){
    $this->rpoints = $rpoints;
  }
  /** Set rpoints      * @param smallint $rpoints     */
  public function addRpoints($rpoints){
    $this->rpoints = $this->rpoints + $rpoints;
  }
  /** Get rpoints     * @return smallint $rpoints   */
  public function getRpoints() {
    return $this->rpoints;
  }
  /** Set firstOrder      * @param smallint $firstOrder     */
  public function setFirstOrder($firstOrder){
    $this->firstOrder = $this->firstOrder;
  }
  /** Get firstOrder     * @return smallint $firstOrder   */
  public function getFirstOrder() {
    return $this->firstOrder;
  }
  /** Set resetPassword @param string $resetPassword     */
  public function setResetPassword($resetPassword){
    $this->resetPassword = $resetPassword;
  }
  /** Get resetPassword @return string $resetPassword     */
  public function getResetPassword(){
    return $this->resetPassword;
  }
  /** Set status @param string $status     */
  public function setStatus($status){
    $this->status = $status;
  }
  /** Get status @return string $status     */
  public function getStatus(){
    return $this->status;
  }
  /** set updated_at @param string $updated_at     */
  public function setUpdatedAt($updated_at){
    $this->updated_at =  new \DateTime("now");
  }
  /** Get updated_at @return string $updated_at     */
  public function getUpdatedAt(){
    return $this->updated_at;
  }
  /** set created_at  @param string $created_at     */
  public function setCreatedAt($created_at){
    $this->created_at = $created_at;
  }
  /**  Get created_at @return string $created_at     */
  public function getCreatedAt(){
    return $this->created_at;
  }
}