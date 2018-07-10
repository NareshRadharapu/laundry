<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 *@ORM\Table
 * @Entity
 * @Table(name="cities")
 */
class City
{
	/** @var integer $id
	 *@Column(name="city_id", type="integer", nullable=false) @Id @GeneratedValue
    */
    private $id;
	/**	@Column(name="name", type="string") */
    private $name;
    /** @Column(name="code", type="string",unique="true") */
    private $code;
	/**	@Column(name="status", type="boolean") */
    private $status;
	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	@Column(name="created_at", type="datetime") */
    private $created_at;
	/** @OneToMany(targetEntity="Area", mappedBy="city_id", cascade={"all"}) */
    private $areas;

    /** @OneToOne(targetEntity="CUnit", mappedBy="city_id", cascade={"all"}) */
    private $centralUnit;
		
	public function __construct(){
		$this->areas 			= new ArrayCollection();
	  	$this->created_at = new \DateTime();
	  	$this->updated_at = new \DateTime();
		$this->status = 1;
    }
	
    public function getCuId(){
        return $this->centralUnit;
    }


	/**  Set area @return Area $area     */
   	public function setArea(Area $area) {
        if (!$this->areas->contains($area)) {
            $this->areas->add($area);
            $area->setCityId($this);
		}
        return $this;
    }	
	/**  Get areas @return Area $areas     */
	public function getAreas(){
	   return $this->areas;
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
    /** Set code  * @param string $code   */
    public function setCode($code)  {
        $this->code = $code;
    }

    /** Get code * @return string $code */
    public function getCode() {
        return $this->code;
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