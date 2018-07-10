<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/** 
 *@ORM\Table
 * @Entity
 * @Table(name="areas")
 */
class Area
{
	/**
     * @var integer $id
	 *@Column(name="area_id", type="integer", nullable=false) @Id @GeneratedValue
     */
    private $id;
	/**	@Column(name="name", type="string") */
    private $name;
    /** @Column(name="code", type="string",unique="true") */
    private $code;

    /** @var string @Column(name="address", type="string", nullable="true") */
    private $address;
    /** @var string @Column(name="landmark", type="string", nullable="true") */
    private $landmark;
    /** @var string @Column(name="pincode", type="integer", nullable="true") */
    private $pincode;
    /** @Column(name="mobile", type="string", nullable="true") */
    private $mobile;

	/**	@Column(name="status", type="boolean") */
    private $status;
    /** @Column(name="isServiceTax", type="boolean", nullable="true") */
    private $isServiceTax;

    /** @Column(name="avarageProcessingDelay", type="integer", nullable="true", options={"default"=1}) */
    private $avarageProcessingDelay; 

	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	@Column(name="created_at", type="datetime") */
    private $created_at;
	/** @OneToMany(targetEntity="Apartment", mappedBy="area_id", cascade={"all"}) */
    private $apartments;

    /** @OneToMany(targetEntity="Customer", mappedBy="area_id", cascade={"all"}) */
    private $customers;

    /** @OneToMany(targetEntity="PickupBoy", mappedBy="area_id", cascade={"all"}) */
    private $pickupBoys;

    /** @OneToMany(targetEntity="PlaceOrderId", mappedBy="store_id", cascade={"all"}) */
    private $placeOrderIds;

    /** @OneToMany(targetEntity="Employee", mappedBy="area_id", cascade={"all"}) */
    private $employees;

    /** @OneToMany(targetEntity="StoreTarget", mappedBy="store_id", cascade={"all"}) */
    private $storeTargets;


    /** @OneToMany(targetEntity="CustomerRequest", mappedBy="area_id", cascade={"all"}) */
    private $customerRequests;

    /** @ManyToOne(targetEntity="Catalog", inversedBy="apartmetns")
     * @JoinColumn(name="catalog_id", referencedColumnName="catalog_id", nullable=true)*/
    private $catalog_id;
	
	/**	@ManyToOne(targetEntity="City", inversedBy="areas")
     * @JoinColumn(name="city_id", referencedColumnName="city_id")     */
	private $city_id;


    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ManyToMany(targetEntity="Service", inversedBy="serviceAreas")
     * @JoinTable(name="store_services",
     *  joinColumns={
     *     @JoinColumn(name="area_id", referencedColumnName="area_id")
     *  },
     *  inverseJoinColumns={
     *     @JoinColumn(name="service_id", referencedColumnName="service_id")
     *  })
     **/
    private $areaServices;
	
	
	public function __construct(){

		$this->apartments 		= new ArrayCollection();
        $this->employees        = new ArrayCollection();
        $this->customers        = new ArrayCollection();
        $this->storeTargets     = new ArrayCollection();
        $this->pickupBoys       = new ArrayCollection();
        $this->placeOrderIds    = new ArrayCollection(); 
        $this->areaServices     = new ArrayCollection();
        $this->customerRequests = new ArrayCollection();

		$this->status			= 1;
        $this->isServiceTax     = 0;
	  	$this->created_at       = new \DateTime();
	  	$this->updated_at       = new \DateTime();

    }

 

    public function getDashBoardReqests(){
        $r = array();
        $tdr = array(); $td =  new \DateTime('today');
        $tmr = array(); $tm =  new \DateTime('tomorrow');
        $ydr = array(); $yd =  new \DateTime('last day');

        foreach($this->customerRequests as $key => $obj) {
            
            if($obj->getStatus()){
                if($obj->getDate()->format('dmy')==$td->format('dmy')){
                    $tdr[] = $obj;
                }else if($obj->getDate()->format('dmy')==$tm->format('dmy')){
                    $tmr[] = $obj;
                }else if($obj->getDate()->format('dmy')==$yd->format('dmy')){
                    $ydr[] = $obj;
                }
            }
        }
        $r['today'] = $tdr;
        $r['tomorrow'] = $tmr; 
        $r['yesterday'] = $ydr;
        return $r;  
    }
   
    public function getMonthTarget(){
        $month = new \DateTime('today');
        
        foreach ($this->storeTargets as $key => $obj) {
            if($obj->getMonth()->format('my')==$month->format('my')){
                return $obj;
            }
        }
    }
    public function getLastMonthTarget(){
        $lm = new \DateTime('last month');
        foreach ($this->storeTargets as $key => $obj) {
            if($obj->getMonth()->format('my')==$lm->format('my')){
                return $obj;
            }
        }
        
    }
	
    public function getAvgProcessingDelay(){
        return $this->avarageProcessingDelay;
    }
    
    public function getEmployees(){
        return $this->employees;
    }
    public function getPlaceOrderIds(){
        return $this->placeOrderIds;
    }

    public function getNetPlaceOrderIds(){
        
        return $this->placeOrderIds->filter(function($entry){
            return !$entry->getIsDelete();
        });
    }

    public function getStoreBalance(){
        $balance = 0;
        foreach ($this->placeOrderIds as $key => $obj) {
            if(!$obj->getIsDelete()){
                $balance +=$obj->getBalanceAmount();    
            }
        }
        return $balance;
    }
    public function getStoreCollection(){
        $collection = 0;
        foreach ($this->placeOrderIds as $key => $obj) {
            if(!$obj->getIsDelete()){
                $collection +=$obj->getPaidAmount();    
            }
        }
        return $collection;
    }
    public function getStoreTotalAmount(){
        $totalamount = 0;
        foreach ($this->placeOrderIds as $key => $obj) {
            if(!$obj->getIsDelete()){
                $totalamount +=$obj->getClosingBalance();    
            }
        }
        return $totalamount;
    }

    public function getToDayPlaceOrderIds(){
        $orderDate = new \DateTime('today');
        return $this->placeOrderIds->filter(function($entry) use($orderDate){
            return $entry->getOrderDate()->format('ymd')==$orderDate->format('ymd')?true:false;
        });
    }
    public function getStoreWalletAmount(){
        $wallatamount = 0;
        foreach ($this->customers as $key => $obj) {
            $wallatamount +=$obj->getWallet();    
        }
        return $wallatamount;
    }
    public function getMonthPlaceOrderIds(){
        $orderDate = new \DateTime('today');
        return $this->placeOrderIds->filter(function($entry) use($orderDate){
            return $entry->getOrderDate()->format('ym')==$orderDate->format('ym')?true:false;
        });
    }

    public function getLastMonthPlaceOrderIds(){
        $orderDate = new \DateTime('last month');
        return $this->placeOrderIds->filter(function($entry) use($orderDate){
            return $entry->getOrderDate()->format('ym')==$orderDate->format('ym')?true:false;
        });
    }

    public function getPickupBoys(){
        return $this->pickupBoys;
    }
    public function getCustomers(){
        return $this->customers;
    }

    public function getNewCustomers(){
        $lastMonth = new \DateTime('-30 days');
        return $this->customers->filter(function($entry) use($lastMonth){
            return $entry->getCreatedAt()->format('ymd')>=$lastMonth->format('ymd')?true:false;
        });;
    }
    public function setIsServiceTax($isServiceTax=0){
        $this->isServiceTax = $isServiceTax;
    }

    public function getIsServiceTax(){
        return $this->isServiceTax;
    }
    
    public function setCatalogId(Catalog $catalog_id){
        $this->catalog_id = $catalog_id;
    }
    
    public function getCatalogId(){
        return $this->catalog_id;
    }

    /**  Add service @return Addon $service     */
    public function addService(Service $service) {
        if (!$this->areaServices->contains($service)) {
            $this->areaServices->add($service);
        }
      
    }   
    
    public function removeService(){
       foreach($this->areaServices as $k){
            $this->areaServices->removeElement($k);
        }
    }
    public function getServices(){
        $services = array();
        foreach ($this->areaServices as $key => $value) {
            $service = array();
            $service['id'] = $value->getId();
            $service['name'] = $value->getName();
            $service['code'] = $value->getCode();
            $service['image'] = $value->getImage();
          
            $services[] = $service;
        }
        return $services;
    }

	/**  Set apartment @return Apartment $apartment     */
   	public function setApartment(Apartment $apartment) {
        if (!$this->apartments->contains($apartment)) {
            $this->apartments->add($apartment);
            $apartment->setCourseId($this);
		}
        return $this;
    }	
	/**  Get apartments @return Apartment $apartments     */
	public function getApartments(){
	   return $this->apartments;
   	}
	
	/**    Set city_id    * @param City $city_id     */
    public function setCityId(City $city_id=null) {
        $this->city_id = $city_id;
		return $this;
	}
	/**   Get city_id  * @return City $city_id     */
    public function getCityId(){
        return $this->city_id;
    }

	
    /**  Get id     * @return integer $id     */
    public function getId(){
        return $this->id;
    }
	
    /** Set name  * @param string $name   */
    public function setName($name)  {
        $this->name = $name;
    }

    /** Get name * @return string $name */
    public function getName() {
        return $this->name;
    }

    /** Set code  * @param string $code   */
    public function setCode($code)  {
        $this->code = $code;
    }

    /** Get code * @return string $code */
    public function getCode() {
        return $this->code;
    }

    /** Set address  @param string address     */
    public function setAddress($address) {
        $this->address = $address;
    }
    /**  Get address @return string address     */
    public function getAddress() {
        return $this->address;
    }
    
    /** Set landmark  @param string landmark     */
    public function setLandmark($landmark) {
        $this->landmark = $landmark;
    }
    /**  Get landmark @return string landmark     */
    public function getLandmark() {
        return $this->landmark;
    }
    
    /** Set pincode  @param string pincode     */
    public function setPincode($pincode) {
        $this->pincode = $pincode;
    }
    /**  Get pincode @return string pincode     */
    public function getPincode() {
        return $this->pincode;
    }

    /** Set mobile @param string $mobile     */
    public function setMobile($mobile){
        $this->mobile = $mobile;
    }
    /** Get mobile @return string $mobile     */
    public function getMobile(){
        return $this->mobile;
    }

	/**	Set status      * @param boolean $status     */
    public function setStatus($status){
        $this->status = $status;
    }

    /** Get status     * @return boolean $status   */
    public function getStatus() {
        return $this->status;
    }
	/**	set created_at     * @param string $created_at   */
	public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
	}
	/** Get created_at     * @return string $created_at     */
	 public function getCreatedAt() {
        return $this->created_at;
    }
	/** set updated_at     * @param string $updated_at     */
	public function setUpdatedAt($updated_at){
        $this->updated_at = $updated_at;
	}
	/** Get updated_at     * @return string $updated_at     */
	 public function getUpdatedAt(){
        return $this->updated_at;
    }
}