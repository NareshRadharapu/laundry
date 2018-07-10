<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 *@ORM\Table
 * @Entity
 * @Table(name="cu_deliver_orders")
 */
class CUDOrder
{
	/**
     * @var integer $id
	 * @Column(name="cudo_id", type="integer", nullable=false) @Id @GeneratedValue   */
    private $id;
	/** @Column(name="order_id",type="string", length="25") **/
	private $order_id;

	/** @Column(name="message",type="text",  nullable="true") **/
	private $message;
	
	/**	@Column(name="status", type="string", nullable="true") */
    private $status;
	
	/**	@ManyToOne(targetEntity="Employee", inversedBy="cudOrders")
     * @JoinColumn(name="emp_id", referencedColumnName="emp_id", nullable=TRUE)     */
	private $emp_id;

	/**	@ManyToOne(targetEntity="CUEmployee", inversedBy="cudOrders")
    * @JoinColumn(name="cue_id", referencedColumnName="cue_id", nullable=TRUE)     */
	private $cue_id;

	/**	@ManyToOne(targetEntity="CUnit", inversedBy="cudOrders")
    * @JoinColumn(name="cu_id", referencedColumnName="cu_id", nullable=TRUE)     */
	private $cu_id;


	/**	@ManyToOne(targetEntity="Area", inversedBy="cudOrders")
     * @JoinColumn(name="store_id", referencedColumnName="area_id", nullable=TRUE)     */
	private $store_id;

	/**	@ManyToOne(targetEntity="Apartment", inversedBy="cudOrders")
     * @JoinColumn(name="apartment_store_id", referencedColumnName="apt_id", nullable=TRUE)     */
	private $apartment_store_id;


	/** @OneToMany(targetEntity="CUOrderDetails", mappedBy="cudo_id", cascade={"all"}) **/
	private $cuOrderDetails;
	
	/**	@Column(name="updated_at", type="datetime", nullable="true") */
    private $updated_at;
	
	/**	@Column(name="created_at", type="datetime", nullable="true") */
    private $created_at;
	
	
	
	public function __construct(){
		$this->cuOrderDetails = new ArrayCollection();
	  	$this->created_at = new \DateTime();
	  	$this->updated_at = new \DateTime();
	  	$this->status = '';
    }

    public function setCuId(CUnit $cuId){
    	$this->cu_id = $cuId;
    }

    public function getCuId(){
    	return $this->cu_id;
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

    /**  Set cuOrderDetail @return CUOrderDetails $cuOrderDetail     */
   	public function setCUOrder(CUOrderDetails $cuOrderDetail) {
        if (!$this->cuOrderDetails->contains($cuOrderDetail)) {
            $this->cuOrderDetails->add($cuOrderDetail);
            $cuOrderDetail->setCudoId($this);
		}
        return $this;
    }

	/**  Get cuOrderDetails @return CUOrderDetails $cuOrderDetails     */
	public function getCUOrders(){
	   return $this->cuOrderDetails;
   	}

    public function setEmployeeId(Employee $emp_id){
    	$this->emp_id = $emp_id;
    }

    public function getEmployeeId(){
    	return $this->emp_id;
    }

    public function setCUEmployeeId(CUEmployee $cue_id){
    	$this->cue_id = $cue_id;
    }

    public function getCUEmployeeId(){
    	return $this->cue_id;
    }
	
 	/**  Get id     * @return integer $id     */
    public function getId(){
        return $this->id;
    }

	public function setOrderId($order_id){
		$this->order_id = $order_id;
	}
	public function getOrderId(){
		return $this->order_id;
	}
	
	public function setMessage($message){
		$this->message = $message;
	}
	public function getMessage(){
		return $this->message;
	}
	
	/**	Set status * @param string $status     */
    public function setStatus($status){
        $this->status = $status;
    }

    /** Get status * @return string $status   */
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