<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/**
 *@ORM\Table
 * @Entity
 * @Table(name="complaints")
 */
class Complaint
{
	 /**
     * @var integer $id
	 *@Column(name="v_id", type="integer", nullable=false) @Id @GeneratedValue
     */
    private $id;
    
    /**	@Column(name="subject", type="string", nullable="true") */
    private $subject;
	
	/**	@Column(name="image", type="string", nullable="true") */
    private $image;
	
	/**	@Column(name="priority", type="string", nullable="true") */
    private $priority;

    /**	@Column(name="ctype", type="string", nullable="true") */
    private $ctype;
	
	/**	@Column(name="message", type="string", nullable="true") */
    private $message;

	/**	@Column(name="status", type="boolean") */
    private $status;
	
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
	
	public function __construct(){
	
	  	$this->created_at 				= new \DateTime();
	  	$this->updated_at 				= new \DateTime();
	  	$this->status 					= 0;
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

  
    /** Set subject  @param string $subject     */
    public function setSubject($subject) {
        $this->subject = $subject;
    }
    /**  Get subject @return string $subject     */
    public function getSubject() {
        return $this->subject;
    }
    /** Set image  @param string $image     */
    public function setImage($image) {
        $this->image = $image;
    }
    /**  Get image @return string $image     */
    public function getImage() {
        return $this->image;
    }

	/** Set priority @param string $priority     */
    public function setPriority($priority){
        $this->priority = $priority;
    }
	
    /** Get priority @return string $priority     */
    public function getPriority(){
        return $this->priority;
    }
	
	/** Set ctype @param string $ctype     */
    public function setCtype($ctype){
        $this->ctype = $ctype;
    }
	
    /** Get ctype @return string $ctype     */
    public function getCtype(){
        return $this->ctype;
    }
	

	/** Set message @param string $message     */
    public function setMessage($message){
        $this->message = $message;
    }
	
    /** Get message @return string $message     */
    public function getMessage(){
        return $this->message;
    }

    /**	Set status  * @param boolean $status     */
    public function setStatus($status){
        $this->status = $status;
    }

    /** Get status     * @return boolean $status   */
    public function getStatus() {
        return $this->status;
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