<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 *@ORM\Table
 * @Entity
 * @Table(name="catalogprice")
 */
class CatalogPrice
{
	/**
     * @var integer $id
	 *@Column(name="cp_id", type="integer", nullable=false) @Id @GeneratedValue
     */
    private $id;
	/**	@Column(name="cost", type="smallint") */
    private $cost;
	/**	@Column(name="discount", type="smallint") */
    private $discount;
	/**	@Column(name="rpoints", type="smallint") */
    private $rpoints;
	/**	@Column(name="status", type="boolean",options={"default"=1}) */
    private $status;
	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	@Column(name="created_at", type="datetime") */
    private $created_at;
	/**	@ManyToOne(targetEntity="Catalog", inversedBy="catalogPrices")
     * @JoinColumn(name="catalog_id", referencedColumnName="catalog_id", nullable=FALSE)     */
    private $catalog_id;
	
	/**	@ManyToOne(targetEntity="Item", inversedBy="catalogPrices")
     * @JoinColumn(name="item_id", referencedColumnName="item_id", nullable=FALSE)     */
    private $item_id;
	
	/**	@ManyToOne(targetEntity="ItemType", inversedBy="catalogPrices")
     * @JoinColumn(name="itype_id", referencedColumnName="itype_id", nullable=FALSE)     */
    private $itype_id;
	
	/**	@ManyToOne(targetEntity="Service", inversedBy="catalogPrices")
     * @JoinColumn(name="service_id", referencedColumnName="service_id", nullable=FALSE)     */
    private $service_id;
	
	
	
	
	public function __construct(){
	  	$this->created_at = new \DateTime();
	  	$this->updated_at = new \DateTime();
		$this->status =1;
    }
	
	public function setCatalogId(Catalog $catalog_id){
		$this->catalog_id = $catalog_id;
	}
	
	public function getCatalogId(){
		return $this->catalog_id;
	}
	
	/**    Set item_id    * @param Item $item_id     */
    public function setItemId(Item $item_id=null) {
        $this->item_id = $item_id;
		return $this;
	}
	/**   Get item_id  * @return Item $item_id     */
    public function getItemId(){
        return $this->item_id;
    }
	
	/**    Set itype_id    * @param ItemType $itype_id     */
    public function setItemTypeId(ItemType $itype_id=null) {
        $this->itype_id = $itype_id;
		return $this;
	}
	/**   Get itype_id  * @return ItemType $itype_id     */
    public function getItemTypeId(){
        return $this->itype_id;
    }
	
	/**    Set service_id    * @param Service $service_id     */
    public function setServiceId(Service $service_id=null) {
        $this->service_id = $service_id;
		return $this;
	}
	/**   Get service_id  * @return Service $service_id     */
    public function getServiceId(){
        return $this->service_id;
    }
    /**  Get id     * @return integer $id     */
    public function getId(){
        return $this->id;
    }
	/** Set cost  * @param smallint $cost   */
    public function setCost($cost)  {
        $this->cost = $cost;
    }

    /** Get cost * @return smallint $cost */
    public function getCost() {
        return $this->cost;
    }
	/**	Set discount      * @param smallint $discount     */
    public function setDiscount($discount){
        $this->discount = $discount;
    }

    /** Get discount     * @return smallint $discount   */
    public function getDiscount() {
        return $this->discount;
    }
	
	/**	Set rpoints      * @param smallint $rpoints     */
    public function setRpoints($rpoints){
        $this->rpoints = $rpoints;
    }

    /** Get rpoints     * @return smallint $rpoints   */
    public function getRpoints() {
        return $this->rpoints;
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