<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 *@ORM\Table
 * @Entity
 * @Table(name="process_orders")
 */
class ProcessOrder
{
	/**
     * @var integer $id
	 *@Column(name="prco_id", type="integer", nullable=false) @Id @GeneratedValue
     */
    private $id;
	/** @Column(name="order_id",type="string", length="25") **/
	private $order_id;
	/**	@Column(name="name", type="string", nullable="true") */
    private $name;
    /**	@Column(name="color", type="string", nullable="true") */
    private $color;
    /**	@Column(name="brand", type="string", nullable="true") */
    private $brand;
    /** @Column(name="barCodeLabel", type="string", nullable="true") */
    private $barCodeLabel;
    /**	@Column(name="inBarCode", type="string", nullable="true") */
    private $inBarCode;
    /**	@Column(name="outBarCode", type="string", nullable="true") */
    private $outBarCode;

    /** @Column(name="itemStatus", type="string", nullable="true") */
    private $itemStatus;

    /** @Column(name="itemStatusMessage", type="string", nullable="true") */
    private $itemStatusMessage;

    /** @Column(name="returnGarmentStatus", type="string", nullable="true") */
    private $returnGarmentStatus;

    /** @Column(name="returnGarmentStatusMessage", type="string", nullable="true") */
    private $returnGarmentStatusMessage;


	/**	@Column(name="status", type="boolean") */
    private $status;

	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	@Column(name="created_at", type="datetime") */
    private $created_at;
	/**	
     * @ManyToOne(targetEntity="Item", inversedBy="processOrders")
     * @JoinColumn(name="item_id", referencedColumnName="item_id", nullable=FALSE)
     */
	private $item_id;
	
	/**	
     * @ManyToOne(targetEntity="Service", inversedBy="processOrders")
     * @JoinColumn(name="service_id", referencedColumnName="service_id", nullable=FALSE)
     */ 
	private $service_id;
	
	/**	
     * @ManyToOne(targetEntity="Customer", inversedBy="processOrders")
     * @JoinColumn(name="cust_id", referencedColumnName="cust_id", nullable=FALSE)
     */
	private $cust_id;
	
    /** 
     * @ManyToOne(targetEntity="Area", inversedBy="processOrders")
     * @JoinColumn(name="store_id", referencedColumnName="area_id", nullable=TRUE)
     */
    private $store_id;

    /** 
     * @ManyToOne(targetEntity="Apartment", inversedBy="processOrders")
     * @JoinColumn(name="apartment_store_id", referencedColumnName="apt_id", nullable=TRUE)
     */
    private $apartment_store_id;
	
	/**    
     * @ManyToOne(targetEntity="PlaceOrder", inversedBy="processOrders")
     * @JoinColumn(name="po_id", referencedColumnName="po_id", nullable=TRUE)
     */ 
    private $po_id;

	/**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ManyToMany(targetEntity="Addon", inversedBy="addonProcessOrder")
     * @JoinTable(name="process_order_addons",
	 *	joinColumns={
     *     @JoinColumn(name="prco_id", referencedColumnName="prco_id")
     *  },
     *  inverseJoinColumns={
     *     @JoinColumn(name="addon_id", referencedColumnName="addon_id")
     *  })
     **/
    private $processOrderAddons;

	public function __construct(){
	  $this->created_at = new \DateTime();
	  $this->updated_at = new \DateTime();
	  $this->status = 0;
	  $this->processOrderAddons = new ArrayCollection();
    }
	

    public function setStoreId(Area $store_id){
        $this->store_id = $store_id;
    }

    public function getStoreId(){
        return $this->store_id;
    }

    public function setApartmentStoreId(Apartment $apartment_store_id){
        $this->apartment_store_id = $apartment_store_id;
    }

    public function getApartmentStoreId(){
        return $this->apartment_store_id;
    }

	/**  Set Addon @return Addon $placeOrderAddon     */
   	public function addAddon(Addon $placeOrderAddon) {
        if (!$this->processOrderAddons->contains($placeOrderAddon)) {
            $this->processOrderAddons->add($placeOrderAddon);
		}
    }	
	/**  Get Addon @return Addon $processOrderAddons     */
	public function getAddons(){
	   return $this->processOrderAddons;
   	}

    public function removeAddon(Addon $placeOrderAddon){
         if ($this->processOrderAddons->contains($placeOrderAddon)) {
            $this->processOrderAddons->removeElement($placeOrderAddon);
        }
    }
	
	
	/**    Set po_id    * @param PlaceOrder $po_id     */
    public function setPlaceOrderId(PlaceOrder $po_id=null) {
        $this->po_id = $po_id;
		return $this;
	}
	/**   Get po_id  * @return PlaceOrder $po_id     */
    public function getPlaceOrderId(){
        return $this->po_id;
    }
	

    /**    Set item_id    * @param Item $item_id     */
    public function setItemId(Item $item_id=null) {
        $this->item_id = $item_id;
        return $this;
    }
    /**   Get item_id  * @return Item $item_id     */
    public function getItemId(){
        return $this->item_id;
    }
	
	/**    Set service_id    * @param Service $service_id     */
    public function setServiceId(Service $service_id=null) {
        $this->service_id = $service_id;
		return $this;
	}
	/**   Get service_id  * @return Service $service_id     */
    public function getServiceId(){
        return $this->service_id;
    }
	
	/**    Set cust_id    * @param Customer $cust_id     */
    public function setCustomerId(Customer $cust_id=null) {
        $this->cust_id = $cust_id;
		return $this;
	}
	/**   Get cust_id  * @return Customer $cust_id     */
    public function getCustomerId(){
        return $this->cust_id;
    }
	
	public function setOrderId($order_id){
		$this->order_id = $order_id;
	}
	public function getOrderId(){
		return $this->order_id;
	}
	
    /**  Get id     * @return integer $id     */
    public function getId(){
        return $this->id;
    }
	
	/**   Set name  * @param string $name     */
    public function setName($name) {
        $this->name = $name;
		return $this;
	}
	
	/**   Get name  * @return string $name     */
    public function getName(){
        return $this->name;
    }

    /**   Set brand  * @param string $brand     */
    public function setBrand($brand) {
        $this->brand = $brand;
        return $this;
    }
    
    /**   Get brand  * @return string $brand     */
    public function getBrand(){
        return $this->brand;
    }



    /**   Set color  * @param string $color     */
    public function setColor($color) {
        $this->color = $color;
		return $this;
	}
	
	/**   Get color  * @return string $color     */
    public function getColor(){
        return $this->color;
    }

    public function setBarCodeLabel($barCodeLabel){
        $this->barCodeLabel  = $barCodeLabel;
    }

    public function getBarCodeLabel(){
        return $this->barCodeLabel;
    }

    /**   Set inBarCode  * @param string $inBarCode     */
    public function setInBarCode($inBarCode) {
        $this->inBarCode = $inBarCode;
		return $this;
	}
	
	/**   Get inBarCode  * @return string $inBarCode     */
    public function getInBarCode(){
        return $this->inBarCode;
    }

    /**   Set outBarCode  * @param string $outBarCode     */
    public function setOutBarCode($outBarCode) {
        $this->outBarCode = $outBarCode;
		return $this;
	}
	
	/**   Get outBarCode  * @return string $outBarCode     */
    public function getOutBarCode(){
        return $this->outBarCode;
    }
	
	/**	Set rpoints      * @param smallint $rpoints     */
    public function setRpoints($rpoints){
        $this->rpoints = $rpoints;
    }
	
    /** Get rpoints     * @return smallint $rpoints   */
    public function getRpoints() {
        return $this->rpoints;
    }
	/**	Set status      * @param boolean $status     */
    public function setStatus($status){
        $this->status = $status;
    }

    /** Get status     * @return boolean $status   */
    public function getStatus() {
        return $this->status;
    }

    public function setItemStatus($itemStatus){
        $this->itemStatus = $itemStatus;
    }

    public function getItemStatus(){
        return $this->itemStatus;
    }

    public function setItemStatusMessage($itemStatusMessage){
        $this->itemStatusMessage = $itemStatusMessage;
    }

    public function getItemStatusMessage(){
        return $this->itemStatusMessage;
    }


    public function setReturnGarmentStatus($returnGarmentStatus){
        $this->returnGarmentStatus = $returnGarmentStatus;
    }

    public function getReturnGarmentStatus(){
        return $this->returnGarmentStatus;
    }

    public function setReturnGarmentStatusMessage($returnGarmentStatusMessage){
        $this->returnGarmentStatusMessage = $returnGarmentStatusMessage;
    }

    public function getReturnGarmentStatusMessage(){
        return $this->returnGarmentStatusMessage;
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