<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/**
 *@ORM\Table
 * @Entity
 * @Table(name="packages")
 */
class Package
{
	/**
     * @var integer $id
	 *@Column(name="package_id", type="integer", nullable=false) @Id @GeneratedValue
    */
    private $id;
    /**	@Column(name="name", type="string", length="50", unique="true") */
    private $name;
    /** @Column(name="code", type="string", length="50", nullable="true") */
    private $code;
    /** @Column(name="cost", type="integer") */
    private $cost;
    /** @Column(name="durationInDays", type="integer") */
    private $durationInDays;
    /** @Column(name="packageDetails", type="text", nullable="true") */
    private $packageDetails;

	/**	@Column(name="status", type="boolean", nullable="true") */
	private $status;
	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	 @var \DateTime @Column(name="created_at", type="datetime") */
    private $created_at;
	
   	public function __construct(){
	  	$this->created_at 	= new \DateTime();
	  	$this->updated_at 	= new \DateTime();
        $this->status = 0;
   	}
   
   
	/** Get id     * @return integer $id     */
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

   /** Set cost  * @param smallint $cost   */
    public function setCost($cost)  {
        $this->cost = $cost;
    }

    /** Get cost * @return smallint $cost */
    public function getCost() {
        return $this->cost;
    }

    public function setDurationInDays($durationInDays){
        $this->durationInDays = $durationInDays;
    }

    public function getDurationInDays(){
        return $this->durationInDays;
    }

	/** Set status @param boolean $status     */
    public function setStatus($status){
        $this->status = $status;
    }
    /** Get status @return boolean $status     */
    public function getStatus(){
        return $this->status;
    }
	
    public function setPackageDetails($packageDetails){
        $this->packageDetails = $packageDetails;
    }

    public function getPackageDetails(){
        return $this->packageDetails;
    }
	/** set updated_at     * @param string $updated_at     */
	public function setUpdatedAt($updated_at){
        $this->updated_at =  new \DateTime("now");
	}
	/** Get updated_at     * @return string $updated_at     */
	public function getUpdatedAt(){
        return $this->updated_at;
    }
	
	/**	set created_at     * @param string $created_at     */
	public function setCreatedAt($created_at){
        $this->created_at = $created_at;
	}
	/**  Get created_at     * @return string $created_at     */
	public function getCreatedAt(){
        return $this->created_at;
    }
}