<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 *@ORM\Table
 * @Entity
 * @Table(name="central_units")
 */
class CUnit
{
	/**
     * @var integer $id
	 * @Column(name="cu_id", type="integer", nullable=false) @Id @GeneratedValue   */
    private $id;

	/** @Column(name="name",type="string", length="25") **/
	private $name;

    /** @Column(name="code", type="string",nullable="true") */
    private $code;

	/** @Column(name="address",type="text",  nullable="true") **/
	private $address;
	
	/**	@Column(name="status", type="smallint",nullable="true") */
    private $status;

	/** @OneToMany(targetEntity="CUSOrder", mappedBy="cu_id", cascade={"all"}) **/
	private $cusOrders;

	/** @OneToMany(targetEntity="CUDOrder", mappedBy="cu_id", cascade={"all"}) **/
	private $cudOrders;

    /** @OneToMany(targetEntity="CUEmployee", mappedBy="cu_id", cascade={"all"}) **/
    private $CUEmployees;

	/** @OneToMany(targetEntity="CUOrderDetails", mappedBy="cu_id", cascade={"all"}) **/
	private $cuOrderDetails;

	/**	@OneToOne(targetEntity="City", inversedBy="centralUnit")
     * @JoinColumn(name="city_id", referencedColumnName="city_id", nullable="false")     */
	private $city_id;
	
	/**	@Column(name="updated_at", type="datetime", nullable="true") */
    private $updated_at;
	
	/**	@Column(name="created_at", type="datetime", nullable="true") */
    private $created_at;
	
	
	
	public function __construct(){
		$this->cuOrderDetails 	= new ArrayCollection();
        $this->CUEmployees      = new ArrayCollection();
		$this->cudOrders 		= new ArrayCollection();
		$this->cusOrders 		= new ArrayCollection();
	  	$this->created_at       = new \DateTime();
	  	$this->updated_at       = new \DateTime();
	  	$this->status = 0;
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

	/**  Set cudOrder @return CUDOrder $cudOrder     */
   	public function setCUDOrder(CUDOrder $cudOrder) {
        if (!$this->cudOrders->contains($cudOrder)) {
            $this->cudOrders->add($cudOrder);
            $cudOrder->setCuId($this);
		}
        return $this;
    }

	/**  Get cudOrders @return CUDOrders $cudOrders     */
	public function getCUDOrders(){
	   return $this->cudOrders;
   	}

   	/**  Set cusOrder @return CUROrder $cusOrder     */
   	public function setCUSOrder(CUSOrder $cusOrder) {
        if (!$this->cusOrders->contains($cusOrder)) {
            $this->cusOrders->add($cusOrder);
            $cusOrder->setCuId($this);
		}
        return $this;
    }

	/**  Get cusOrders @return CUSOrders $cusOrders     */
	public function getCUSOrders(){
	   return $this->cusOrders;
   	}


    /**  Set cuOrderDetail @return CUOrderDetails $cuOrderDetail     */
   	public function setCUOrderDetails(CUOrderDetails $cuOrderDetail) {
        if (!$this->cuOrderDetails->contains($cuOrderDetail)) {
            $this->cuOrderDetails->add($cuOrderDetail);
            $cuOrderDetail->setCuId($this);
		}
        return $this;
    }

	/**  Get cuOrderDetails @return CUOrderDetails $cuOrderDetails     */
	public function getCUOrderDetails(){
	   return $this->cuOrderDetails;
   	}

    public function setEmployeeId(Employee $emp_id){
    	$this->emp_id = $emp_id;
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
	
	/** Set address @param string $address     */
    public function setAddress($address){
        $this->address = $address;
    }
    /** Get address @return string $address     */
    public function getAddress(){
        return $this->address;
    }
	
	/**	Set status * @param boolean $status     */
    public function setStatus($status){
        $this->status = $status;
    }

    /** Get status * @return boolean $status   */
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