<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 *@ORM\Table
 * @Entity
 * @Table(name="cc_camera")
 */
class CC
{
	/** @var integer $id
	 *@Column(name="cc_id", type="integer", nullable=false) @Id @GeneratedValue
    */
    private $id;
	/**	@Column(name="name", type="string", nullable="true") */
    private $name;
    /**	@Column(name="location", type="string", nullable="true") */
    private $location;
    /**	@Column(name="ccscript", type="string", nullable="true") */
    private $ccscript;
    /**	@Column(name="accessPrivileges", type="string", nullable="true") */
    private $accessPrivileges;
	/**	@Column(name="status", type="boolean", nullable="true") */
    private $status;
   
	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	@Column(name="created_at", type="datetime") */
    private $created_at;
	
	/** @ManyToOne(targetEntity="Apartment", inversedBy="ads")
	*	@JoinColumn(name="apt_id", referencedColumnName="apt_id", nullable=TRUE) */
	private $apt_id;
	
	
	public function __construct(){
	  	$this->created_at = new \DateTime();
	  	$this->updated_at = new \DateTime();
		$this->status = 1;
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
    /** Set location  * @param string $location   */
    public function setLocation($location)  {
        $this->location = $location;
    }

    /** Get location * @return string $location */
    public function getLocation() {
        return $this->location;
    }

     /** Set accessPrivileges  * @param string $accessPrivileges   */
    public function setAccessPrivileges($accessPrivileges)  {
        $this->accessPrivileges = $accessPrivileges;
    }

    /** Get accessPrivileges * @return string $accessPrivileges */
    public function getAccessPrivileges() {
        return $this->accessPrivileges;
    }

     /** Set ccscript  * @param string $ccscript   */
    public function setCCscript($ccscript)  {
        $this->ccscript = $ccscript;
    }

    /** Get ccscript * @return string $ccscript */
    public function getCCscript() {
        return $this->ccscript;
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
	public function setUpdatedAt(){
        $this->updated_at = new \DateTime();
	}
	/** Get updated_at     * @return string $updated_at     */
	 public function getUpdatedAt(){
        return $this->updated_at;
    }
}