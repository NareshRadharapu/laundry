<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 *@ORM\Table
 * @Entity
 * @Table(name="blocks")
 */
class Block
{
	/**
     * @var integer $id
	 *@Column(name="block_id", type="integer", nullable=false) @Id @GeneratedValue
    s */
    private $id;
	/**	@Column(name="name", type="string") */
    private $name;
	/**	@Column(name="status", type="boolean") */
    private $status;
	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	@Column(name="created_at", type="datetime") */
    private $created_at;
	
	/**	
     * @ManyToOne(targetEntity="Apartment", inversedBy="blocks")
     * @JoinColumn(name="apt_id", referencedColumnName="apt_id", nullable=FALSE)
     */
	private $apt_id;	
	
	/** @OneToMany(targetEntity="Flat",mappedBy="block_id",cascade={"all"}) */
	private $flats;
		
	public function __construct(){
		$this->flats = new ArrayCollection();
	  	$this->created_at = new \DateTime();
	  	$this->updated_at = new \DateTime();
    }
	
	
	/**  Set flat @return Flat $flat     */
   	public function setFlat(Flat $flat) {
        if (!$this->flats->contains($flat)) {
            $this->flats->add($flat);
            $flat->setBlockId($this);
		}
        return $this;
    }	
	/**  Get flats @return Flat $flats     */
	public function getFlats(){
	   return $this->flats;
   	}
	/**   Set apt_id  * @param Apartment $apt_id     */
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
	/** Set name    * @param string $name   */
    public function setName($name)  {
        $this->name = $name;
    }

    /** Get name  * @return string $name */
    public function getName() {
        return $this->name;
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