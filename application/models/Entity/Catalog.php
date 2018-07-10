<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 *@ORM\Table
 * @Entity
 * @Table(name="catalogs")
 */
class Catalog
{
	/**
     * @var integer $id
	 *@Column(name="catalog_id", type="integer", nullable=false) @Id @GeneratedValue
     */
    private $id;
	/**	@Column(name="name", type="string") */
    private $name;
	/**	@Column(name="description", type="string",nullable="true") */
    private $description;
	/**	@Column(name="status", type="boolean") */
    private $status;
	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	@Column(name="created_at", type="datetime") */
    private $created_at;
	/** @OneToMany(targetEntity="CatalogPrice", mappedBy="catalog_id", cascade={"all"}) */
    private $catalogPrices;
	
	
	public function __construct(){
		$this->catalogPrices 			= new ArrayCollection();
	  	$this->created_at = new \DateTime();
	  	$this->updated_at = new \DateTime();
		$this->status = 1;
    }
	
	/**  Set catalogPrice @return CatalogPrice $catalogPrice     */
   	public function setCatalogPrice(CatalogPrice $catalogPrice) {
        if (!$this->catalogPrices->contains($catalogPrice)) {
            $this->catalogPrices->add($catalogPrice);
            $catalogPrice->setCatalogId($this);
		}
        return $this;
    }	
	/**  Get catalogPrices @return CatalogPrice $catalogPrices     */
	public function getCatalogPrices(){
	   return $this->catalogPrices;
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
	/** Set description  * @param string $description   */
    public function setDescription($description)  {
        $this->description = $description;
    }

    /** Get description * @return string $description */
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