<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
 /**
 *@ORM\Table
 * @Entity
 * @Table(name="customer_address")
 */
class CustomerAddress
{
	 /** @var integer $id @Column(name="ca_id", type="integer", nullable=false) @Id @GeneratedValue     */
    private $id;
	/**	@var string @Column(name="address", type="string", nullable="true") */
    private $address;
	/**	@var string @Column(name="landmark", type="string", nullable="true") */
    private $landmark;
	
	/**	@var string @Column(name="pincode", type="integer", nullable="true") */
    private $pincode;
	
	/**	@var Boolean @Column(name="status", type="boolean") */
    private $status;
	/**	@var \DateTime @Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	 @var \DateTime @Column(name="created_at", type="datetime") */
    private $created_at;
	
	/**	@ManyToOne(targetEntity="Area", inversedBy="customerAddress")
     * @JoinColumn(name="area_id", referencedColumnName="area_id")     */
	private $area_id;
	
	
	/**	@OneToOne(targetEntity="Customer", inversedBy="customerAddress")
     * @JoinColumn(name="cust_id", referencedColumnName="cust_id")     */
	private $cust_id;
	
	/** @OneToMany(targetEntity="PlaceOrderId", mappedBy="ca_id") **/
	private $placeOrderIds;

   	public function __construct(){
		$this->placeOrderIds 			= new ArrayCollection(); 
      	$this->created_at 	= new \DateTime();
	  	$this->updated_at 	= new \DateTime();
		$this->status = 1;
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
	
	/**    Set area_id    * @param Area $area_id     */
    public function setAreaId(Area $area_id=null) {
        $this->area_id = $area_id;
		return $this;
	}
	/**   Get area_id  * @return Area $area_id     */
    public function getAreaId(){
        return $this->area_id;
    }

    /**   Get area_id  * @return Area $area_id     */
    public function getStoreId(){
        return $this->area_id;
    }
   
	/** Get id     * @return integer $id     */
    public function getId(){
        return $this->id;
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
        $this->created_at = $created_at;
	}
	/**  Get created_at @return string $created_at     */
	public function getCreatedAt(){
        return $this->created_at;
    }
}