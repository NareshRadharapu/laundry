<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/**
 *@ORM\Table
 * @Entity
 * @Table(name="vehicles")
 */
class Vehicle
{
	 /**
     * @var integer $id
	 *@Column(name="v_id", type="integer", nullable=false) @Id @GeneratedValue
     */
    private $id;
    /**	@Column(name="regNumber", type="string") */
    private $regNumber;
	/**	@Column(name="make", type="string", nullable="true") */
    private $make;
	/**	@Column(name="model", type="string", nullable="true") */
    private $model;
	/**	@Column(name="vtype", type="string", nullable="true") */
    private $vtype;
	/**	@Column(name="rfid", type="string", nullable="true") */
    private $rfid;
	/**	@Column(name="status", type="boolean",options={"default"=1}) */
    private $status;
	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	 @var \DateTime @Column(name="created_at", type="datetime") */
    private $created_at;
	
	/** @ManyToOne(targetEntity="Apartment", inversedBy="vachiles")
	*	@JoinColumn(name="apt_id", referencedColumnName="apt_id", nullable=TRUE) */
	private $apt_id;
	
	/** @ManyToOne(targetEntity="Block", inversedBy="vachiles", cascade={"all"})
	*	@JoinColumn(name="block_id", referencedColumnName="block_id",  nullable=TRUE) */
	private $block_id;
	
	/** @ManyToOne(targetEntity="Flat", inversedBy="vachiles", cascade={"all"})
	*	@JoinColumn(name="flat_id", referencedColumnName="flat_id", nullable=TRUE) 	*/
	private $flat_id;
	
	/** @ManyToOne(targetEntity="Customer", inversedBy="vachiles", cascade={"all"})
	*	@JoinColumn(name="cust_id", referencedColumnName="cust_id", nullable=TRUE) 	*/
	private $cust_id;
	
	
   	public function __construct(){
		$this->passwordSalt 			= "";
		$this->status					= 0;
	  	$this->created_at 				= new \DateTime();
	  	$this->updated_at 				= new \DateTime();
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
	
	/**    Set cust_id    * @param Flat $cust_id     */
    public function setCustomerId(Customer $cust_id=null) {
        $this->cust_id = $cust_id;
		return $this;
	}
	/**   Get cust_id  * @return Customer $cust_id     */
    public function getCustomerId(){
        return $this->cust_id;
    }
	
	
	/** Get id     * @return integer $id     */
    public function getId(){
        return $this->id;
    }

    /** Set regNumber  @param string $regNumber     */
    public function setRegNumber($regNumber) {
        $this->regNumber = $regNumber;
    }
    /**  Get regNumber @return string $regNumber     */
    public function getRegNumber() {
        return $this->regNumber;
    }
	
	/** Set make  @param string $make     */
    public function setMake($make) {
        $this->make = $make;
    }
    /**  Get make @return string $make     */
    public function getMake() {
        return $this->make;
    }

	/** Set model  @param string $model     */
    public function setModel($model) {
        $this->model = $model;
    }
    /**  Get model @return string $model     */
    public function getModel() {
        return $this->model;
    }
	
	/** Set vtype  @param string $vtype     */
    public function setVtype($vtype) {
        $this->vtype = $vtype;
    }
    /**  Get vtype @return string $vtype     */
    public function getVtype() {
        return $this->vtype;
    }
	
	/** Set rfid  @param string $rfid     */
    public function setRfid($rfid) {
        $this->rfid = $rfid;
    }
    /**  Get rfid @return string $rfid     */
    public function getRfid() {
        return $this->rfid;
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