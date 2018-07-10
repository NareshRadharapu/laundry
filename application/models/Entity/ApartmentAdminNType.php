<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/**
 *@ORM\Table
 * @Entity
 * @Table(name="apartment_an_types")
 */
class ApartmentAdminNType
{
	 /**
     * @var integer $id
	 *@Column(name="aant_id", type="integer", nullable=false) @Id @GeneratedValue
     */
    private $id;
    
	/**	@Column(name="name", type="string", nullable="true") */
    private $name;
	
	
	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	 @var \DateTime @Column(name="created_at", type="datetime") */
    private $created_at;
	
	
	/** @ManyToOne(targetEntity="Apartment", inversedBy="adminNotificationTypes")
	*	@JoinColumn(name="apt_id", referencedColumnName="apt_id", nullable=FALSE) */
	private $apt_id;
	
	
	/** @ManyToOne(targetEntity="Faculty", inversedBy="adminNotificationTypes")
	*	@JoinColumn(name="faculty_id", referencedColumnName="faculty_id", nullable=TRUE) 	*/
	private $faculty_id;


	
   	public function __construct(){
	
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
	/**    Set faculty_id    * @param Visitor $faculty_id     */
    public function setFacultyId(Faculty $faculty_id=null) {
        $this->faculty_id = $faculty_id;
		return $this;
	}
	/**   Get faculty_id  * @return Faculty $faculty_id     */
    public function getFacultyId(){
        return $this->faculty_id;
    }
	
	
	/** Get id     * @return integer $id     */
    public function getId(){
        return $this->id;
    }
	
	/** Set name    * @param string $name   */
    public function setName($name)  {
        $this->name = $name;
    }

    /** Get name  * @return string $name */
    public function getName() {
        return $this->name;
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