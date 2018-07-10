<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/**
 *@ORM\Table
 * @Entity
 * @Table(name="visitors")
 */
class Visitor
{
	 /**
     * @var integer $id
	 *@Column(name="v_id", type="integer", nullable=false) @Id @GeneratedValue
     */
    private $id;
    
    /**	@Column(name="name", type="string") */
    private $name;
	
	/**	@Column(name="image", type="string", nullable="true") */
    private $image;
	
	/**	@Column(name="mobile", type="string") */
    private $mobile;

	/**	@Column(name="purpose", type="string", nullable="true") */
    private $purpose;

    /**	@Column(name="vtype", type="string", nullable="true") */
    private $vtype;
	
	/**	@Column(name="vehicle", type="string", nullable="true") */
    private $vehicle;
	
	/**	@Column(name="vcount", type="smallint", nullable="true") */
    private $vcount;
	
	/**	@Column(name="vdate", type="datetime", nullable="true") */
    private $vdate;
	
	/**	@Column(name="in_time", type="datetime", nullable="true") */
    private $in_time;
	
	/**	@Column(name="out_time", type="datetime", nullable="true") */
    private $out_time;
	
	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	 @var \DateTime @Column(name="created_at", type="datetime") */
    private $created_at;
	
	
	/** @ManyToOne(targetEntity="Apartment", inversedBy="visitors")
	*	@JoinColumn(name="apt_id", referencedColumnName="apt_id", nullable=TRUE) */
	private $apt_id;
	
	/** @ManyToOne(targetEntity="Block", inversedBy="visitors")
	*	@JoinColumn(name="block_id", referencedColumnName="block_id",  nullable=TRUE) */
	private $block_id;
	
	/** @ManyToOne(targetEntity="Flat", inversedBy="visitors")
	*	@JoinColumn(name="flat_id", referencedColumnName="flat_id", nullable=TRUE) 	*/
	private $flat_id;
	
	/** @ManyToOne(targetEntity="Customer", inversedBy="visitors")
	*	@JoinColumn(name="cust_id", referencedColumnName="cust_id", nullable=TRUE) 	*/
	private $cust_id;
	
	/** @ManyToOne(targetEntity="Faculty", inversedBy="visitors")
	*	@JoinColumn(name="faculty_id", referencedColumnName="faculty_id", nullable=TRUE) 	*/
	private $faculty_id;
	
	/**	@Column(name="facultyApprovalStatus", type="smallint") */
    private $facultyApprovalStatus;
	
	/**	@Column(name="flatApprovalStatus", type="smallint") */
    private $flatApprovalStatus;
	
	/** @ManyToOne(targetEntity="Faculty", inversedBy="visitors")
	*	@JoinColumn(name="facultyApproval", referencedColumnName="faculty_id", nullable=TRUE) 	*/
	private $facultyApproval;
	
	/** @ManyToOne(targetEntity="Customer", inversedBy="visitors")
	*	@JoinColumn(name="flatApproval", referencedColumnName="cust_id", nullable=TRUE) 	*/
	private $flatApproval;
	
   	public function __construct(){
		$this->flatApprovalStatus		= 0;
		$this->facultyApprovalStatus	= 0;
	  	$this->created_at 				= new \DateTime();
	  	$this->updated_at 				= new \DateTime();
   	}
	
	/**    Set facultyApproval    * @param Faculty $facultyApproval     */
    public function setFacultyApproval(Faculty $facultyApproval=null) {
        $this->facultyApproval = $facultyApproval;
		return $this;
	}
	/**   Get facultyApproval  * @return Faculty $facultyApproval     */
    public function getFacultyApproval(){
        return $this->facultyApproval;
    }
	
	
	/**    Set flatApproval    * @param Customer $flatApproval     */
    public function setCustomerApproval(Customer $flatApproval=null) {
        $this->flatApproval = $flatApproval;
		return $this;
	}
	/**   Get flatApproval  * @return Customer $flatApproval     */
    public function getCustomerApproval(){
        return $this->flatApproval;
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
	
	/**    Set cust_id    * @param Customer $cust_id     */
    public function setCustomerId(Customer $cust_id=null) {
        $this->cust_id = $cust_id;
		return $this;
	}
	/**   Get cust_id  * @return Customer $cust_id     */
    public function getCustomerId(){
        return $this->cust_id;
    }

	/**    Set faculty_id    * @param Faculty $faculty_id     */
    public function setFacultyId(Faculty $faculty_id=null) {
        $this->faculty_id = $faculty_id;
		return $this;
	}
	/**   Get faculty_id  * @return Faculty $faculty_id     */
    public function getFacultyId(){
        return $this->faculty_id;
    }
	
	public function setId($id){
        $this->id = $id;
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
    /** Set image  @param string $image     */
    public function setImage($image) {
        $this->image = $image;
    }
    /**  Get image @return string $image     */
    public function getImage() {
        return $this->image;
    }
	
	
	/** Set mobile @param string $mobile     */
    public function setMobile($mobile){
        $this->mobile = $mobile;
    }
	
    /** Get mobile @return string $mobile     */
    public function getMobile(){
        return $this->mobile;
    }
	
	/** Set vcount @param string $vcount     */
    public function setVcount($vcount){
        $this->vcount = $vcount;
    }
	
    /** Get vcount @return string $vcount     */
    public function getVcount(){
        return $this->vcount;
    }
	
	/** Set purpose @param string $purpose     */
    public function setPurpose($purpose){
        $this->purpose = $purpose;
    }
	
    /** Get purpose @return string $purpose     */
    public function getPurpose(){
        return $this->purpose;
    }
	
	/** Set vtype @param string $vtype     */
    public function setVtype($vtype){
        $this->vtype = $vtype;
    }
	
    /** Get vtype @return string $vtype     */
    public function getVtype(){
        return $this->vtype;
    }
	

	/** Set vehicle @param string $vehicle     */
    public function setVehicle($vehicle){
        $this->vehicle = $vehicle;
    }
	
    /** Get vehicle @return string $vehicle     */
    public function getVehicle(){
        return $this->vehicle;
    }
	
	
	/** Set flatApprovalStatus @param string $flatApprovalStatus     */
    public function setCustomerApprovalStatus($flatApprovalStatus){
        $this->flatApprovalStatus = $flatApprovalStatus;
    }
    /** Get flatApprovalStatus @return string $flatApprovalStatus     */
    public function getCustomerApprovalStatus(){
        return $this->flatApprovalStatus;
    }
	
	/** set vdate @param datetime $vdate     */
	public function setVdate($vdate){
        $this->vdate =  new \DateTime($vdate);
	}
	/** Get vdate @return string $vdate     */
	public function getVdate(){
        return $this->vdate;
    }
	/** set in_time @param string $in_time     */
	public function setInTime($in_time){
        $this->in_time =  new \DateTime($in_time);
	}
	/** Get in_time @return string $in_time     */
	public function getInTime(){
        return $this->in_time;
    }
	/** set out_time @param string $out_time     */
	public function setOutTime($out_time){
        $this->out_time =  new \DateTime("now");
	}
	/** Get out_time @return string $out_time     */
	public function getOutTime(){
        return $this->out_time;
    }
	
	/**	Set facultyApprovalStatus      * @param string $facultyApprovalStatus     */
    public function setFacultyApprovalStatus($facultyApprovalStatus){
        $this->facultyApprovalStatus = $facultyApprovalStatus;
    }
	/** Get facultyApprovalStatus     * @return string $facultyApprovalStatus   */
    public function getFacultyApprovalStatus() {
        return $this->facultyApprovalStatus;
    }
	
	
	/** set updated_at @param datetime $updated_at     */
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