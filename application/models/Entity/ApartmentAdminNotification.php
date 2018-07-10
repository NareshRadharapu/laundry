<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/**
 *@ORM\Table
 * @Entity
 * @Table(name="apartment_admin_notifications")
 */
class ApartmentAdminNotification
{
	 /**
     * @var integer $id
	 *@Column(name="aadn_id", type="integer", nullable=false) @Id @GeneratedValue
     */
    private $id;
	
    /**	@Column(name="subject", type="string", nullable="true") */
    private $subject;

    /**	@Column(name="message", type="text", nullable="true") */
    private $message;
	
	/**	@Column(name="ntype", type="string", nullable="true") */
    private $ntype;
	
	 /** @Column(name="priority", type="string", nullable="true") */
    private $priority;
	
	 /** @Column(name="nfile", type="text", nullable="true") */
    private $nfile;
	
	/**  @var \DateTime	@Column(name="ndate", type="datetime", nullable="true") */
    private $ndate;
	
	/**  @var \DateTime	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	 @var \DateTime @Column(name="created_at", type="datetime") */
    private $created_at;
	
	
	/** @ManyToOne(targetEntity="Apartment", inversedBy="adminNotifications")
	*	@JoinColumn(name="apt_id", referencedColumnName="apt_id", nullable=FALSE) */
	private $apt_id;
	
	/** @ManyToOne(targetEntity="Block", inversedBy="adminNotifications")
	*	@JoinColumn(name="block_id", referencedColumnName="block_id",  nullable=TRUE) */
	private $block_id;
	
	
	/**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ManyToMany(targetEntity="Flat", inversedBy="adminNotifications")
     * @JoinTable(name="aa_flat_notifications",
	 *	joinColumns={
     *     @JoinColumn(name="aadn_id", referencedColumnName="aadn_id")
     *  },
     *  inverseJoinColumns={
     *     @JoinColumn(name="flat_id", referencedColumnName="flat_id")
     *  })
     **/
	private $noficationFlats;
	
	
	
	/** @ManyToOne(targetEntity="Faculty", inversedBy="adminNotifications")
	*	@JoinColumn(name="faculty_id", referencedColumnName="faculty_id", nullable=TRUE) 	*/
	private $faculty_id;
	
	/** @ManyToOne(targetEntity="ApartmentAdminNType", inversedBy="adminNotifications")
	*	@JoinColumn(name="aant_id", referencedColumnName="aant_id", nullable=TRUE) 	*/
	private $aant_id;

	
   	public function __construct(){
		$this->noficationFlats			= new ArrayCollection();
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
		if(!$this->noficationFlats->contains($flat_id)){
			$this->noficationFlats->add($flat_id);
		}
        
		//return $this;
	}
	/**   Get flat_id  * @return Flat $flat_id     */
    public function getFlatIds(){
        return $this->noficationFlats;
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
	
	/**    Set aant_id    * @param ApartmentAdminNType $aant_id     */
    public function setNtypeId(ApartmentAdminNType $aant_id=null) {
        $this->aant_id = $aant_id;
		return $this;
	}
	/**   Get aant_id  * @return ApartmentAdminNType $aant_id     */
    public function getNtypeId(){
        return $this->aant_id;
    }
	
	
	/** Get id     * @return integer $id     */
    public function getId(){
        return $this->id;
    }
	
	/** Set subject    * @param string $subject   */
    public function setSubject($subject)  {
        $this->subject = $subject;
    }

    /** Get subject  * @return string $subject */
    public function getSubject() {
        return $this->subject;
    }

    /** Set message    * @param string $message   */
    public function setMessage($message)  {
        $this->message = $message;
    }

    /** Get message  * @return string $message */
    public function getMessage() {
        return $this->message;
    }
	
	/** Set ntype    * @param string $ntype   */
    public function setNtype($ntype)  {
        $this->ntype = $ntype;
    }

    /** Get ntype  * @return string $ntype */
    public function getNtype() {
        return $this->ntype;
    }
	
	/** Set priority    * @param string $priority   */
    public function setPriority($priority)  {
        $this->priority = $priority;
    }

    /** Get priority  * @return string $priority */
    public function getPriority() {
        return $this->priority;
    }
	/** Set nfile    * @param string $nfile   */
    public function setNfile($nfile)  {
        $this->nfile = $nfile;
    }

    /** Get nfile  * @return string $nfile */
    public function getNfile() {
        return $this->nfile;
    }
	
	/** set ndate @param datetime $ndate     */
	public function setNdate($ndate){
		
        $this->ndate =  new \DateTime($ndate);
	}
	/** Get ndate @return datetime $ndate     */
	public function getNdate(){
        return $this->ndate;
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