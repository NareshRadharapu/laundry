<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 *@ORM\Table
 * @Entity
 * @Table(name="item_types")
 */
class ItemType
{
	/**
     * @var integer $id
	 *@Column(name="itype_id", type="integer", nullable=false) @Id @GeneratedValue
     */
    private $id;
	/**	@Column(name="name", type="string") */
    private $name;
	/**	@Column(name="code", type="string") */
    private $code;
	/**	@Column(name="image", type="string", nullable="true") */
    private $image;
	/**	@Column(name="status", type="boolean") */
    private $status;
	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	@Column(name="created_at", type="datetime") */
    private $created_at;
	
	
	
	public function __construct(){
		$this->status = 0;
		$this->itemServices 	= new ArrayCollection();
	  	$this->created_at = new \DateTime();
	  	$this->updated_at = new \DateTime();
    }
	
	/**  Add itemService @return Service $itemService     */
   	public function addService(Service $itemService) {
        if (!$this->itemServices->contains($itemService)) {
            $this->itemServices->add($itemService);
		}
        return $this;
    }	
	/**  Get itemServices @return Service $itemServices     */
	public function getServices(){
	   return $this->itemServices;
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
	
	/** Set image    * @param string $image   */
    public function setImage($image)  {
        $this->image = $image;
    }
    /** Get image     * @return string $image */
    public function getImage() {
        return $this->image;
    }
	
	/**	Set status      * @param boolean $status     */
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