<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 *@ORM\Table
 * @Entity
 * @Table(name="temp_orders")
 */
class TempOrder
{
	/**
     * @var integer $id
	 *@Column(name="to_id", type="integer", nullable=false) @Id @GeneratedValue
     */
    private $id;
	/** @Column(name="order_id",type="string", length="25") **/
	private $order_id;
	/**	@Column(name="icount", type="smallint") */
    private $icount;
	
	/** @Column(name="cost",type="smallint") */
	private $cost;
	/** @Column(name="rpoints",type="smallint") */
	private $rpoints;
	/**	@Column(name="status", type="boolean") */
    private $status;
	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	@Column(name="created_at", type="datetime") */
    private $created_at;
	/**	
     * @ManyToOne(targetEntity="Item", inversedBy="tempOrders")
     * @JoinColumn(name="item_id", referencedColumnName="item_id", nullable=FALSE)
     */
	private $item_id;
	
	/**	
     * @ManyToOne(targetEntity="Service", inversedBy="tempOrders")
     * @JoinColumn(name="service_id", referencedColumnName="service_id", nullable=FALSE)
     */ 
	private $service_id;
	
	/**	
     * @ManyToOne(targetEntity="Customer", inversedBy="tempOrders")
     * @JoinColumn(name="cust_id", referencedColumnName="cust_id", nullable=FALSE)
     */
	private $cust_id;
	
	/** @OneToMany(targetEntity="TempOrderAddon", mappedBy="to_id") */
    private $tempOrderAddons;
	
	public function __construct(){
	  $this->created_at = new \DateTime();
	  $this->updated_at = new \DateTime();
	  $this->status = 0;
	  $this->tempOrderAddons = new ArrayCollection();
    }
	
	/**  Set tempOrderAddons @return TempOrderAddon $tempOrderAddons     */
   	public function addTempOrderAddon(TempOrderAddon $tempOrderAddon) {
        if (!$this->tempOrderAddons->contains($tempOrderAddon)) {
            $this->tempOrderAddons->add($tempOrderAddon);
            $tempOrderAddon->setPlaceOrderId($this);
		}
        return $this;
    }	
	/**  Get tempOrderAddons @return TempOrderAddon $tempOrderAddons     */
	public function getTempOrderAddons(){
	   return $this->tempOrderAddons;
   	}

	public function removeAddons(){
		foreach ($this->tempOrderAddons as $key => $value) {
			$this->tempOrderAddons->removeElement($value);
		}
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
	/**   Set icount  * @param smallint $icount     */
    public function setIcount($icount) {
        $this->icount = $icount;
		return $this;
	}
	
	/**   Get icount  * @return smallint $icount     */
    public function getIcount(){
        return $this->icount;
    }
	
	
	
	public function setCost($cost){
		$this->cost = $cost;
	}
	
	public function getCost(){
		return $this->cost;
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