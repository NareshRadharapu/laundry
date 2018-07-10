<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
 /**
 *@ORM\Table
 * @Entity
 * @Table(name="customer_requests")
 */
class CustomerRequest
{
	 /** @var integer $id @Column(name="cr_id", type="integer", nullable=false) @Id @GeneratedValue     */
    private $id;
	
	/**	@var string @Column(name="mobile", type="string",length="10") */
    private $mobile;

    /** @var string @Column(name="slot", type="string",length="40") */
    private $slot;
	
    /** @var \DateTime @Column(name="crdate", type="datetime",nullable="true") */
    private $crdate;

	/**	@var Boolean @Column(name="status", type="string", nullable="true") */
    private $status;

	/**	@var \DateTime @Column(name="updated_at", type="datetime") */
    private $updated_at;

	/**	 @var \DateTime @Column(name="created_at", type="datetime") */
    private $created_at;
	
	/**	@ManyToOne(targetEntity="Area", inversedBy="customerRequests")
     * @JoinColumn(name="area_id", referencedColumnName="area_id", nullable="true")  */
	private $area_id;
	
	/**	@ManyToOne(targetEntity="Customer", inversedBy="customerRequests")
     * @JoinColumn(name="customer_id", referencedColumnName="cust_id", nullable="true") */
	private $customer_id;
	
    /** @ManyToOne(targetEntity="PickupBoy", inversedBy="customerRequests")
     * @JoinColumn(name="pb_id", referencedColumnName="pb_id", nullable=TRUE) */
    private $pb_id;

   	public function __construct(){
	
      	$this->created_at 	= new \DateTime();
	  	$this->updated_at 	= new \DateTime();
		//$this->status = '';
   	}
   
    /**    Set customer_id    * @param Customer $customer_id     */
    public function setCustomerId(Customer $customer_id=null) {
        $this->customer_id = $customer_id;
		return $this;
	}
	
    /**   Get customer_id  * @return Customer $customer_id     */
    public function getCustomerId(){
        return $this->customer_id;
    }
	
    

	/**    Set area_id    * @param Area $area_id     */
    public function setAreaId(Area $area_id=null) {
        $this->area_id = $area_id;
		return $this;
	}

    /**    Set area_id    * @param Area $area_id     */
    public function setStoreId(Area $area_id=null) {
        $this->area_id = $area_id;
        return $this;
    }



	
    /**   Get area_id  * @return Area $area_id     */
    public function getAreaId(){
        return $this->area_id;
    }
   
    public function setPickupBoyId(PickupBoy $pb_id){
        $this->pb_id = $pb_id;
    }

    public function getPickupBoyId(){
        return $this->pb_id;
    }


	/** Get id     * @return integer $id     */
    public function getId(){
        return $this->id;
    }

    /** Set mobile  @param string mobile     */
    public function setMobile($mobile) {
        $this->mobile = $mobile;
    }
    /**  Get mobile @return string mobile     */
    public function getMobile() {
        return $this->mobile;
    }

    public function setSlot($slot){
        $this->slot = $slot;
    }

    public function getSlot(){
        return $this->slot;
    }

	/** Set status @param string $status     */
    public function setStatus($status){
        $this->status = $status;
    }
    /** Get status @return string $status     */
    public function getStatus(){
        return $this->status;
    }

    /** set crdate @param string $crdate     */
    public function setDate($crdate){
        $this->crdate =  new \DateTime($crdate);
    }
    /** Get crdate @return string $crdate     */
    public function getDate(){
        return $this->crdate;
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
        $this->created_at = $created_at;
	}
	/**  Get created_at @return string $created_at     */
	public function getCreatedAt(){
        return $this->created_at;
    }
}