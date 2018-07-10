<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/**
 *@ORM\Table
 * @Entity
 * @Table(name="roles")
 */
class Role
{
	 /** @var integer $id @Column(name="role_id", type="integer", nullable=false) @Id @GeneratedValue     */
    private $id;
    /**	@var string @Column(name="role_name", type="string") */
    private $name;
	/**	@var string @Column(name="short_name", type="string") */
    private $shname;
	/**	@var Boolean @Column(name="role_status", type="boolean") */
    private $status;
	/**	@var \DateTime @Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	 @var \DateTime @Column(name="created_at", type="datetime") */
    private $created_at;
	/** @OneToMany(targetEntity="Employee", mappedBy="role_id", cascade={"all"}) */
	private $employees;

   	public function __construct(){
	  	$this->employees 	= new ArrayCollection();
      	$this->created_at 	= new \DateTime();
	  	$this->updated_at 	= new \DateTime();
   	}
   
	/**  Add employees @return Employee $employees     */
   	public function addEmployee(Employee $employees) {
        if (!$this->employees->contains($employees)) {
            $this->employees->add($employees);
            $area->setCaId($this);
		}
        return $this;
    }	
	/**  Get employees @return Employee $employees     */
	public function getEmployees(){
	   return $this->employees;
   	}
   
    /** Set id  @param integer $id     */
    public function setId($id) {
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
	 /** Set shname  @param string $shname     */
    public function setShortName($shname) {
        $this->shname = $shname;
    }
    /**  Get shname @return string $shname     */
    public function getShortName() {
        return $this->shname;
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