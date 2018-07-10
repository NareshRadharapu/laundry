<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
\Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/**
 *@ORM\Table
 * @Entity
 * @Table(name="addons")
 */
class Addon
{
	/**
     * @var integer $id
	 *@Column(name="addon_id", type="integer", nullable=false) @Id @GeneratedValue
     */
    private $id;
	/**	@Column(name="name", type="string", unique="true") */
    private $name;
    /** @Column(name="code", type="string", unique="true") */
    private $code;
	/**	@Column(name="image", type="string", nullable="true") */
    private $image;
	/**	@Column(name="price", type="string") */
    private $price;
	/**	@Column(name="description", type="string", nullable="true" ) */
    private $description;
	
	/**	@Column(name="status", type="boolean",options={"default"=1}) */
    private $status;
	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	@Column(name="created_at", type="datetime") */
    private $created_at;
	
	/** @ManyToMany(targetEntity="Addon", mappedBy="serviceAddons") */
    private $addonServices;

	/** @ManyToMany(targetEntity="ProcessOrder", mappedBy="processOrderAddons") */
    private $addonProcessOrder;
    
    /** @OneToMany(targetEntity="PlaceOrderAddon", mappedBy="addon_id", cascade={"remove"}) */
    private $placeOrderAddons;


    /** @OneToMany(targetEntity="TempOrderAddon", mappedBy="addon_id") */
    private $tempOrderAddons;
	
	public function __construct(){
		$this->status = 1;
		$this->addonServices 	= new ArrayCollection();
        $this->addonProcessOrder    = new ArrayCollection();
        $this->tempOrderAddons  = new ArrayCollection();
	  	$this->created_at       = new \DateTime();
	  	$this->updated_at       = new \DateTime();
    }
	
	/**  Add addonService @return Service $addonService     */
   	public function addService(Service $addonService) {
        if (!$this->addonServices->contains($addonService)) {
            $this->addonServices->add($addonService);
		}
        return $this;
    }	
	/**  Get addonServices @return Service $addonServices     */
	public function getServices(){
	   return $this->addonServices;
   	}
	

    /**  Get id     * @return integer $id     */
    public function getId(){
        return $this->id;
    }
	
	/** Set name    * @param string $name   */
    public function setName($name)  {
        $this->name = $name;
    }
    /** Get name     * @return string $name */
    public function getName() {
        return $this->name;
    }

    /** Set code    * @param string $code   */
    public function setCode($code)  {
        $this->code = $code;
    }
    /** Get code     * @return string $code */
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
	/** Set price    * @param string $price   */
    public function setPrice($price)  {
        $this->price = $price;
    }
    /** Get price     * @return string $price */
    public function getPrice() {
        return $this->price;
    }
	
	/** Set description    * @param string $description   */
    public function setDescription($description)  {
        $this->description = $description;
    }
    /** Get description     * @return string $description */
    public function getDescription() {
        return $this->description;
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