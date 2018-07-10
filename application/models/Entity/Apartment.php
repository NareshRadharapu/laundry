<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
\Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/**
 *@ORM\Table
 * @Entity
 * @Table(name="apartments")
 */
class Apartment
{
	/**
     * @var integer $id
	 *@Column(name="apt_id", type="integer", nullable=false) @Id @GeneratedValue
     */
    private $id;
	/**	@Column(name="name", type="string" ) */
    private $name;
    /** @Column(name="code", type="string",unique="true") */
    private $code;

	/**	@Column(name="address", type="string", nullable="true" ) */
    private $address;
	/**	@Column(name="pincode", type="integer",nullable="true") */
    private $pincode;
    /** @var string @Column(name="landmark", type="string", nullable="true") */
    private $landmark;
	
	/** @Column(name="mobile", type="string", nullable="true") */
    private $mobile;
	/**	@Column(name="status", type="boolean") */
    private $status;
	
	/**	@ManyToOne(targetEntity="Area", inversedBy="apartmetns")
     * @JoinColumn(name="area_id", referencedColumnName="area_id", nullable=FALSE)*/
	private $area_id;
	
	/**	@ManyToOne(targetEntity="Catalog", inversedBy="apartmetns")
     * @JoinColumn(name="catalog_id", referencedColumnName="catalog_id", nullable=true)*/
	private $catalog_id;
	
	/** @OneToMany(targetEntity="Customer",mappedBy="apt_id") */
	private $customers;
	/** @OneToMany(targetEntity="Block",mappedBy="apt_id") */
	private $blocks;
	
	/** @OneToMany(targetEntity="Vehicle",mappedBy="apt_id", cascade={"all"}) */
	private $vachiles;
	
	public function __construct(){
		$this->status			= 1;
		$this->blocks = new ArrayCollection();
		$this->customers = new ArrayCollection();
		$this->vachiles   = new ArrayCollection(); 
	  	$this->created_at = new \DateTime();
	  	$this->updated_at = new \DateTime();
    }
	
	/**  Set vachile @return Vehicle $vachile     */
   	public function setVehicle(Vehicle $vachile) {
        if (!$this->vachiles->contains($vachile)) {
            $this->vachiles->add($vachile);
            $vachile->setFlatId($this);
		}
        return $this;
    }	
	
	/**  Get vachiles @return Vehicle $vachiles     */
	public function getVehicles(){
	   return $this->vachiles;
   	}
	
	/**  Set block @return Block $block     */
   	public function setBlock(Block $block) {
        if (!$this->blocks->contains($block)) {
            $this->blocks->add($block);
            $block->setApartmentId($this);
		}
        return $this;
    }	
	/**  Get blocks @return Block $blocks     */
	public function getBlocks(){
	   return $this->blocks;
   	}
	
	/**  Get customers @return Customer $customers     */
	public function getCustomers(){
	   return $this->customers;
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
	
	public function setCatalogId(Catalog $catalog_id){
		$this->catalog_id = $catalog_id;
	}
	
	public function getCatalogId(){
		return $this->catalog_id;
	}
	
    /**  Get id     * @return integer $id     */
    public function getId(){
        return $this->id;
    }
	/** Set name     * @param string $name   */
    public function setName($name)  {
        $this->name = $name;
    }

    /** Get name     * @return string $name */
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

	/** Set address    * @param string $address   */
    public function setAddress($address)  {
        $this->address = $address;
    }

    /** Get address     * @return string $address */
    public function getAddress() {
        return $this->address;
    }
	
	/**	Set Pincode  * @param integer $pincode     */
    public function setPincode($pincode){
        $this->pincode = $pincode;
    }

    /** Get Pincode  * @return integer $pincode  */
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

    /** Set landmark  @param string landmark     */
    public function setLandmark($landmark) {
        $this->landmark = $landmark;
    }
    /**  Get landmark @return string landmark     */
    public function getLandmark() {
        return $this->landmark;
    }

	/**	Set status  * @param boolean $status     */
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