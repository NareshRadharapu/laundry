<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/**
 *@ORM\Table
 * @Entity
 * @Table(name="place_order_ids")
 */
class PlaceOrderId
{
	/**
     * @var integer $id
	 * @Column(name="o_id", type="integer", nullable=false) @Id @GeneratedValue   */
    private $id;
	/** @Column(name="order_id",type="string", length="25") **/
	private $order_id;
	/** @Column(name="subtotal",type="string", length="18", nullable="true") **/
	private $subtotal;
	/** @Column(name="qd",type="boolean", nullable="true") **/
	private $qd;
	/** @Column(name="qdPercent",type="integer", nullable="true") **/
	private $qdPercent;
	/** @Column(name="qdAmount",type="string", nullable="true") **/
	private $qdAmount;
	/** @Column(name="serviceTax",type="string", length="8", nullable="true") **/
	private $serviceTax;
	/** @Column(name="totalAmount",type="string", length="18", nullable="true") **/
	private $totalAmount;
	/** @Column(name="redeemAmount",type="string", length="18", nullable="true") **/
	private $redeemAmount;
	/** @Column(name="rPointsUsed",type="string", length="18", nullable="true") **/
	private $rPointsUsed;
	/** @Column(name="balanceAmount",type="string",  nullable="true") **/
	private $balanceAmount;
	/** @Column(name="paidAmount",type="string",  nullable="true") **/
	private $paidAmount;
	/** @Column(name="paymentType",type="string",  nullable="true") **/
	private $paymentType;
	/** @Column(name="transactionNumber",type="string",  nullable="true") **/
	private $transactionNumber;
	/** @Column(name="paymentFeedback",type="text",  nullable="true") **/
	private $paymentFeedback;
	/** @Column(name="reFundAmount",type="string",  nullable="true") **/
	private $reFundAmount;
	/** @Column(name="closingBalance",type="string",  nullable="true") **/
	private $closingBalance;
	/** @Column(name="adminDiscount",type="string",  nullable="true") **/
	private $adminDiscount;
	/** @Column(name="totalItems",type="integer",  nullable="true") **/
	private $totalItems;
	/** @Column(name="adminDiscountAmount",type="string",  nullable="true") **/
	private $adminDiscountAmount;
	/** @Column(name="couponCode",type="string",  nullable="true") **/
	private $couponCode;
	/**	@Column(name="orderDate", type="datetime", nullable="true") **/
    private $orderDate;
    /**	@Column(name="ordSrc", type="string", nullable="true") **/
    private $ordSrc;
    /**	@Column(name="deliveryDate", type="datetime", nullable="true") **/
    private $deliveryDate;
    /**	@Column(name="processDelayInDays", type="integer", nullable="true") **/
    private $processDelayInDays;
	/** @Column(name="firstPaidAmount",type="integer",  nullable="true") **/
	private $firstPaidAmount;
	/** @Column(name="secondPaidAmount",type="integer",  nullable="true") **/
	private $secondPaidAmount;
	/** @Column(name="thirdPaidAmount",type="integer",  nullable="true") **/
	private $thirdPaidAmount;
	/**	@Column(name="status", type="boolean") */
    private $status;
    /**	@Column(name="isDelete", type="boolean") */
    private $isDelete;
    /**	@Column(name="isPackageOrder", type="boolean") */
    private $isPackageOrder;
	/**	@Column(name="poStatus", type="string", nullable="true") */
    private $poStatus;
    /**	@Column(name="poStatusMessage", type="string", nullable="true") */
    private $poStatusMessage;
	/**	@Column(name="pickupBoyStatus", type="string", nullable="true") */
    private $pickupBoyStatus;
    /**	@Column(name="cuStatus", type="string",length="4",nullable="true") */
    private $cuStatus;
	/**	@ManyToOne(targetEntity="Customer", inversedBy="placeOrderIds")
     * @JoinColumn(name="customer_id", referencedColumnName="cust_id", nullable=true)     */
	private $customer_id;
	/**	@ManyToOne(targetEntity="PickupBoy", inversedBy="placeOrderIds")
     * @JoinColumn(name="pb_id", referencedColumnName="pb_id", nullable=TRUE)     */
	private $pb_id;
	/**	@ManyToOne(targetEntity="PickupBoy", inversedBy="placeOrderIds")
     * @JoinColumn(name="db_id", referencedColumnName="pb_id", nullable=TRUE)     */
	private $db_id;
	/**	@ManyToOne(targetEntity="CustomerAddress", inversedBy="placeOrderIds")
     * @JoinColumn(name="address_id", referencedColumnName="ca_id", nullable=true)     */
	private $address_id;
	/**	@ManyToOne(targetEntity="Area", inversedBy="placeOrderIds")
     * @JoinColumn(name="store_id", referencedColumnName="area_id", nullable=true) */
	private $store_id;
	/**	
     * @OneToMany(targetEntity="CUOrderDetails", mappedBy="order_id", cascade={"all"})
     */ 
	private $cuOrderDetails;
	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	@Column(name="created_at", type="datetime") */
    private $created_at;
    /** @Column(name="vendorId", type="integer") */
    private $vendorId;
    
	public function __construct(){
	  	$this->created_at 		= new \DateTime();
	  	$this->updated_at 		= new \DateTime();
	  	$this->status 			= 0;
	  	$this->isDelete 		= 0;
	  	$this->cuStatus 		= 0;
	  	$this->poStatus 		= '';
	  	$this->qd = 0;
	  	$this->pickupBoyStatus 	= 0;
	  	$this->isPackageOrder = 0;
	  	$this->cuOrderDetails 	= new ArrayCollection();
    }
	public function setCouponCode($couponCode){
		$this->couponCode = $couponCode;
	}
	public function getCouponCode(){
		return $this->couponCode;
	}
    public function setProcessDelayInDays($processDelayInDays){
    	$this->processDelayInDays = $processDelayInDays;
    }
    public function getProcessDelayInDays(){
    	return $this->processDelayInDays;
    }
    public function setVendorId($vendorId){
	    $this->vendorId = $vendorId;
	}
	public function getVendorId(){
	    return $this->vendorId;
	}
    public function setQd($qd){
    	$this->qd = $qd;
    }
    public function getQd(){
    	return $this->qd;
    }
	public function setQdPercent($qdPercent){
    	$this->qdPercent = $qdPercent;
    }
    public function getQdPercent(){
    	return $this->qdPercent; 
    }
    public function setQdAmount($qdAmount){
    	$this->qdAmount = $qdAmount;
    }
    public function getQdAmount(){
    	return $this->qdAmount; 
    }
    public function setIsDelete($isDelete){
    	$this->isDelete = $isDelete;
    }
    public function getIsDelete(){
    	return $this->isDelete;
    }
    public function setIsPackageOrder($isPackageOrder){
    	$this->isPackageOrder = $isPackageOrder;
    }
    public function getIsPackageOrder($isPackageOrder){
    	return $this->isPackageOrder;
    }
	public function setStoreId(Area $store_id){
		$this->store_id = $store_id;
	}
	public function getStoreId(){
		return $this->store_id;
	}
    public function setTotalItems($totalItems){
    	$this->totalItems = $totalItems;
    }
    public function getTotalItems(){
    	return $this->totalItems;
    }
	public function setOrderId($order_id){
		$this->order_id = $order_id;
	}
	public function getOrderId(){
		return $this->order_id;
	}
	public function getCUOrderDetails(){
		return $this->cuOrderDetails;
	}
	public function setSubtotal($subtotal){
		$this->subtotal = $subtotal;
	}
	public function getSubtotal(){
		return $this->subtotal;
	}
	public function setServiceTax($serviceTax){
		$this->serviceTax = $serviceTax;
	}
	public function getServiceTax(){
		return $this->serviceTax;
	}
	public function setTotalAmount($totalAmount){
		$this->totalAmount = $totalAmount;
	}
	public function getTotalAmount(){
		return $this->totalAmount;
	}
	public function setReFundAmount($reFundAmount){
		$this->reFundAmount = $reFundAmount;
	}
	public function addReFundAmount($reFundAmount){
		$this->reFundAmount = $this->reFundAmount+ $reFundAmount;
	}
	public function getReFundAmount(){
		return $this->reFundAmount;
	}
	public function setClosingBalance($closingBalance){
		$this->closingBalance = $closingBalance;
	}
	public function getClosingBalance(){
		return $this->closingBalance;
	}
	public function getClosingAmount(){
		return $this->closingBalance;
	}
	public function setRedeemAmount($redeemAmount){
		$this->redeemAmount = $redeemAmount;
	}
	public function addRedeemAmount($redeemAmount){
		$this->redeemAmount = $this->redeemAmount + $redeemAmount;
	}
	public function getRedeemAmount(){
		return $this->redeemAmount;
	}
	public function setRPointsUsed($rPointsUsed){
		$this->rPointsUsed = $rPointsUsed;
	}
	public function getRPointsUsed(){
		return $this->rPointsUsed;
	}
	public function setAdminDiscount($adminDiscount){
		$this->adminDiscount = $adminDiscount;
	}
	public function getAdminDiscount(){
		return $this->adminDiscount;
	}
	public function setAdminDiscountAmount($adminDiscountAmount){
		$this->adminDiscountAmount = $adminDiscountAmount;
	}
	public function getAdminDiscountAmount(){
		return $this->adminDiscountAmount;
	}
	public function setOrderDate($orderDate){
		//$date = date('d-m-Y H:i a',strtotime($orderDate));
		$this->orderDate = new \DateTime($orderDate); 
	}
	public function getOrderDate(){
		return $this->orderDate;
	}
	public function setOrdSrc($ordSrc){
		$this->ordSrc = $ordSrc;
	}
	public function getOrdSrc(){
		return $this->ordSrc;
	}
	public function setDeliveryDate($deliveryDate){
		$this->deliveryDate = new \DateTime($deliveryDate); 
	}
	public function getDeliveryDate(){
		return $this->deliveryDate;
	}
	public function setPaidAmount($paidAmount){
		$this->paidAmount = $paidAmount;
	}
	public function getPaidAmount(){
		return $this->paidAmount;
	}
	public function setPaymentType($paymentType){
		$this->paymentType = $paymentType;
	}
	public function getPaymentType(){
		return $this->paymentType;
	}
	public function setTransactionNumber($transactionNumber){
		$this->transactionNumber = $transactionNumber;
	}
	public function getTransactionNumber(){
		return $this->transactionNumber;
	}
	public function setPaymentFeedback($paymentFeedback){
		$this->paymentFeedback = $paymentFeedback;
	}
	public function getPaymentFeedback(){
		return $this->paymentFeedback;
	}
	public function setBalanceAmount($balanceAmount){
		$this->balanceAmount = $balanceAmount;
	}
	public function getBalanceAmount(){
		return $this->balanceAmount;
	}
	public function setFirstPaidAmount($firstPaidAmount){
		$this->firstPaidAmount = $firstPaidAmount;
	}
	public function getFirstPaidAmount(){
		return $this->firstPaidAmount;
	}
	public function setSecondPaidAmount($secondPaidAmount){
		$this->secondPaidAmount = $secondPaidAmount;
	}
	public function getSecondPaidAmount(){
		return $this->secondPaidAmount;
	}
	public function setThirdPaidAmount($thirdPaidAmount){
		$this->thirdPaidAmount = $thirdPaidAmount;
	}
	public function getThirdPaidAmount(){
		return $this->thirdPaidAmount;
	}
	public function setCustomerId(Customer $customer_id){
		$this->customer_id = $customer_id;
	}
	public function getCustomerId(){
		return $this->customer_id;
	}
	public function setPickupBoyId(PickupBoy $pb_id){
		$this->pb_id = $pb_id;
	}
	public function getPickupBoyId(){
		return $this->pb_id;
	}
	public function setDeliveryBoyId(PickupBoy $db_id){
		$this->db_id = $db_id;
	}
	public function getDeliveryBoyId(){
		return $this->db_id;
	}
	public function setAddressId($address_id){
		if(is_object($address_id)){
			$this->address_id = $address_id;
			$this->store_id = $address_id->getAreaId();	
		}else{
		}
	}
	public function getAddressId(){
		return $this->address_id;
	}
    /**  Get id     * @return integer $id     */
    public function getId(){
        return $this->id;
    }
	/**	Set status      * @param boolean $status     */
    public function setStatus($status){
        $this->status = $status;
    }
    /** Get status     * @return boolean $status   */
    public function getStatus() {
        return $this->status;
    }
    public function setOrderStatus($poStatus){
    	$this->poStatus = $poStatus;
    }
    public function getOrderStatus(){
    	return $this->poStatus;
    }
    public function setOrderStatusMessage($poStatusMessage){
    	$this->poStatusMessage = $poStatusMessage;
    }
    public function getOrderStatusMessage(){
    	return $this->poStatusMessage;
    }
    public function setPickupBoyStatus($pstatus){
    	$this->pickupBoyStatus = $pstatus;
    }
    public function getPickupBoyStatus(){
    	return $this->pickupBoyStatus;
    }
    public function setCuStatus($status){
    	$this->cuStatus = $status;
    }
    public function getCuStatus(){
    	return $this->cuStatus;
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