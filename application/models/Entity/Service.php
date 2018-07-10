<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
\Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/**
 *@ORM\Table
 * @Entity
 * @Table(name="services")
 */
class Service
{
	/**
     * @var integer $id
	 *@Column(name="service_id", type="integer", nullable=false) @Id @GeneratedValue
     */
    private $id;

	/**	@Column(name="name", type="string", unique="true") */
    private $name;
	
	/**	@Column(name="code", type="string") */
    private $code;
	
	/**	@Column(name="image", type="string", nullable="true") */
    private $image;
	
	/**	@Column(name="description", type="text", nullable="true") */
    private $description;
	/**	@Column(name="cost", type="smallint", nullable="true") */
    private $cost;
	/**	@Column(name="discount", type="smallint", nullable="true") */
    private $discount;
	
	
	/**	@Column(name="status", type="boolean",options={"default"=1}) */
    private $status;
	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	@Column(name="created_at", type="datetime") */
    private $created_at;
	
	
	/**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ManyToMany(targetEntity="Addon", inversedBy="addonServices")
     * @JoinTable(name="service_addons",
	 *	joinColumns={
     *     @JoinColumn(name="service_id", referencedColumnName="service_id")
     *  },
     *  inverseJoinColumns={
     *     @JoinColumn(name="addon_id", referencedColumnName="addon_id")
     *  })
     **/
    private $serviceAddons;
	
	/** @ManyToMany(targetEntity="Item", mappedBy="itemServices", cascade={"all"}) */
    private $serviceItems;
    
    /** @OneToMany(targetEntity="CatalogPrice", mappedBy="service_id", cascade={"all"}) */
    private $catalogPrices;
			
	public function __construct(){
		$this->status = 1;
		$this->serviceAddons 	= new ArrayCollection();	
        $this->catalogPrices     = new ArrayCollection();    
	  	$this->created_at 		= new \DateTime();
	  	$this->updated_at 		= new \DateTime();
    }


	/**  Add serviceAddon @return Addon $serviceAddon     */
   	public function addAddon(Addon $serviceAddon) {
        if (!$this->serviceAddons->contains($serviceAddon)) {
            $this->serviceAddons->add($serviceAddon);
		}
        return $this;
    }	
	
	
	public function removeAddon(){
	   foreach($this->serviceAddons as $k){
			$this->serviceAddons->removeElement($k);
		}
   }
   
   
	/**  Get serviceAddons @return Addon $serviceAddons     */
	public function getAddons(){
	   $addons = array();
	    foreach($this->serviceAddons as $k){
			  $it['id'] = $k->getId();
			  $it['name'] = $k->getName();
			  $it['cost'] = $k->getPrice();
              $it['status'] = $k->getStatus();
			  $addons[] = $it;
			}
	   return $addons;

   	}

    public function getStatusAddons(){
       $addons = array();
        foreach($this->serviceAddons as $k){
                $it['id']   = $k->getId();
                $it['name'] = $k->getName();
                $it['cost'] = $k->getPrice();
                if($k->getStatus()){
                    $addons[] = $it;
                }
            }
       return $addons;

    }
	
	
	/**  Add serviceItem @return ItemType $serviceItem     */
   	public function addItem(Item $serviceItem) {
        if (!$this->serviceItems->contains($serviceItem)) {
            $this->serviceItems->add($serviceItem);
		}
        return $this;
    }	
	
	/**  Get serviceItems @return ItemType $serviceItems     */
	public function getItem(){
		$itemtyps = array();
		 foreach($this->serviceItems as $k){
			  $it['id'] = $k->getId();
			  $it['name'] = $k->getName();
			  $itemtyps[] = $it;
			}
	   return $itemtyps;// $this->serviceItems;
   	}

    public function getItemTypeItems($itid){
        $itemtyps = array();
        foreach($this->serviceItems as $k){
            if($k->getItemTypeId()->getId()==$itid){
                $it =  array();
              $it['id']     = $k->getId();
              $it['name']   = $k->getName();
              $itemtyps[]   = $it;
            }
        }
       return $itemtyps; 
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
	
	/** Set description    * @param string $description   */
    public function setDescription($description)  {
        $this->description = $description;
    }
    /** Get description     * @return string $description */
    public function getDescription() {
        return $this->description;
    }
	
	/** Set cost    * @param smallint $cost   */
    public function setCost($cost)  {
        $this->cost = $cost;
    }
    /** Get cost     * @return smallint $cost */
    public function getCost() {
        return $this->cost;
    }
	/** Set discount    * @param smallint $discount   */
    public function setDiscount($discount)  {
        $this->discount = $discount;
    }
    /** Get discount     * @return smallint $discount */
    public function getDiscount() {
        return $this->discount;
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