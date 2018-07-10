<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/**
 *@ORM\Table
 * @Entity
 * @Table(name="vendors")
 */
class Vendor
{
	 /**
     * @var integer $id
	 *@Column(name="vendor_id", type="integer", nullable=false) @Id @GeneratedValue
     */
    private $id;
    /**	@Column(name="name", type="string") */
    private $name;
    /** @Column(name="code", type="string", nullable="true") */
    private $code;
    /** @Column(name="vendorGroup", type="integer", nullable="true") */
    private $vendorGroup;
	/**	@Column(name="email", type="string", nullable="true") */   
	private $email;
	/**	@Column(name="mobile", type="string",nullable="true") */
    private $mobile;
    /**   @Column(name="vtype", type="string", nullable="true") */
    private $vtype;
     /**   @Column(name="company", type="string", nullable="true") */
    private $company;

     /** @Column(name="address", type="text", nullable="true") */
    private $address;

	/**	@Column(name="status", type="boolean") */
    private $status;
	/** @var \DateTime	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	 @var \DateTime @Column(name="created_at", type="datetime") */
    private $created_at;
	
    /** @ManyToOne(targetEntity="Apartment", inversedBy="vendors")
     * @JoinColumn(name="apt_id", referencedColumnName="apt_id", nullable=TRUE)     */
    private $apt_id;

    /** @ManyToOne(targetEntity="Area", inversedBy="customers")
     * @JoinColumn(name="area_id", referencedColumnName="area_id", nullable=TRUE)     */
    private $area_id;
    /** @Column(name="discountPercent", type="integer") */
    private $discountPercent;
    /** @Column(name="discountExpiry", type="date") */
    private $discountExpiry;
    /** @Column(name="commissionPercent", type="integer") */
    private $commissionPercent;
    /** @Column(name="commissionExpiry", type="date") */
    private $commissionExpiry;

   	public function __construct(){
        $this->status       =1;
      	$this->created_at 	= new \DateTime();
	  	$this->updated_at 	= new \DateTime();
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
    
    /**    Set area_id    * @param Area $area_id     */
    public function setAreaId(Area $area_id=null) {
        $this->area_id = $area_id;
        return $this;
    }
    /**   Get area_id  * @return Area $area_id     */
    public function getAreaId(){
        return $this->area_id;
    }

	/** Get id     * @return integer $id     */
    public function getId(){
        return $this->id;
    }

    /** Set name  @param string $name     */
    public function setName($name) {
        $this->name = $name;
    }
    /**  Get name @return string $name     */
    public function getName() {
        return $this->name;
    }

    public function setCode($code) {
        $this->code = $code;
    }
    public function getCode() {
        return $this->code;
    }

    public function setVendorGroup($vendorGroup) {
        $this->vendorGroup = $vendorGroup;
    }
    public function getVendorGroup() {
        return $this->vendorGroup;
    }

	/** Set email  @param string $email     */
    public function setEmail($email) {
        $this->email = $email;
    }
    /**  Get email @return string $email     */
    public function getEmail() {
        return $this->email;
    }
	
	/** Set mobile @param string $mobile     */
    public function setMobile($mobile){
        $this->mobile = $mobile;
    }
    /** Get mobile @return string $mobile     */
    public function getMobile(){
        return $this->mobile;
    }
	
    /** Set vtype @param string $vtype     */
    public function setVtype($vtype){
        $this->vtype = $vtype;
    }
    
    /** Get vtype @return string $vtype     */
    public function getVtype(){
        return $this->vtype;
    }

    /** Set company @param string $company     */
    public function setCompany($company){
        $this->company = $company;
    }
    
    /** Get company @return string $company     */
    public function getCompany(){
        return $this->company;
    }

    /** Set address @param string $address     */
    public function setAddress($address){
        $this->address = $address;
    }
    /** Get address @return string $address     */
    public function getAddress(){
        return $this->address;
    }

	/** Set status @param string $status     */
    public function setStatus($status){
        $this->status = $status;
    }
    /** Get status @return string $status     */
    public function getStatus(){
        return $this->status;
    }

    public function setDiscountPercent($discountPercent){
        $this->discountPercent = $discountPercent;
    }
    public function getDiscountPercent(){
        return $this->discountPercent;
    }

    public function setDiscountExpiry($discountExpiry){
        if($discountExpiry)
        $this->discountExpiry = new \DateTime($discountExpiry);
    }
    public function getDiscountExpiry(){
        return $this->discountExpiry;
    }

    public function setCommissionPercent($commissionPercent){
        $this->commissionPercent = $commissionPercent;
    }
    public function getCommissionPercent(){
        return $this->commissionPercent;
    }

    public function setCommissionExpiry($commissionExpiry){
        if($commissionExpiry)
        $this->commissionExpiry = new \DateTime($commissionExpiry);
    }
    public function getCommissionExpiry(){
        return $this->commissionExpiry;
    }
	
	/** set updated_at @param DateTime  $updated_at     */
	public function setUpdatedAt( $updated_at){
        $this->updated_at->modify("now");
	}
	/** Get updated_at @return string $updated_at     */
	public function getUpdatedAt(){
        return $this->updated_at;
    }
	
	/**	set created_at  @param DateTime  $created_at     */
	public function setCreatedAt($created_at){
        $this->created_at = $created_at;
	}
	/**  Get created_at @return string $created_at     */
	public function getCreatedAt(){
        return $this->created_at;
    }
}