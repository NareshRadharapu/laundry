<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/**
 *@ORM\Table
 * @Entity
 * @Table(name="store_targets")
 */
class StoreTarget
{
	 /**
     * @var integer $id
	 *@Column(name="pb_id", type="integer", nullable=false) @Id @GeneratedValue
     */
    private $id;
    /**	@Column(name="month", type="date") */
    private $month;
	/**	@Column(name="ordersTarget", type="integer") */
	private $ordersTarget;
    /** @Column(name="revenueTarget", type="integer", nullable="true") */
    private $revenueTarget;
	
	/**	@Column(name="status", type="boolean",options={"default"=1}) */
    private $status;
	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	 @var \DateTime @Column(name="created_at", type="datetime") */
    private $created_at;
	
	/** @ManyToOne(targetEntity="Area", inversedBy="pickupBoys")
	*	@JoinColumn(name="store_id", referencedColumnName="area_id", nullable=TRUE) */
	private $store_id;
    
    
   	public function __construct(){
		$this->status					= 1;
      	$this->created_at 				= new \DateTime();
	  	$this->updated_at 				= new \DateTime();
    }
	
    
	/**    Set store_id    * @param Area $store_id     */
    public function setStoreId(Area $store_id=null) {
        $this->store_id = $store_id;
		return $this;
	}
	/**   Get store_id  * @return Area $store_id     */
    public function getStoreId(){
        return $this->store_id;
    }
	
	/** Get id     * @return integer $id     */
    public function getId(){
        return $this->id;
    }

    /** Set month @param string $month     */
    public function setMonth($month){
        $this->month = $month;
    }
    /** Get month @return string $month     */
    public function getMonth(){
        //is_object($this->month)$this->month->format('mY'):null;
        return $this->month;
    }

    /** Set ordersTarget  @param string $ordersTarget     */
    public function setOrdersTarget($ordersTarget) {
        $this->ordersTarget = $ordersTarget;
    }
    /**  Get ordersTarget @return string $ordersTarget     */
    public function getOrdersTarget() {
        return $this->ordersTarget;
    }

	/** Set revenueTarget  @param string $revenueTarget     */
    public function setRevenueTarget($revenueTarget) {
        $this->revenueTarget = $revenueTarget;
    }
    /**  Get revenueTarget @return string $revenueTarget     */
    public function getRevenueTarget() {
        return $this->revenueTarget;
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
	
	/**	set created_at  @param string $created_at     */
	public function setCreatedAt($created_at){
        $this->created_at =  new \DateTime("now");
	}
	/**  Get created_at @return string $created_at     */
	public function getCreatedAt(){
        return $this->created_at;
    }
}