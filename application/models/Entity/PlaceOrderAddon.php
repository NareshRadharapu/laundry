<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 *@ORM\Table
 * @Entity
 * @Table(name="place_order_addons")
 */
class PlaceOrderAddon
{
	/**
     * @var integer $id
	 *@Column(name="poa_id", type="integer", nullable=false) @Id @GeneratedValue
     */
    private $id;
	/**	@Column(name="poa_count", type="smallint") */
    private $poa_count;
	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	@Column(name="created_at", type="datetime") */
    private $created_at;
	/**	
     * @ManyToOne(targetEntity="PlaceOrder", inversedBy="placeOrderAddons")
     * @JoinColumn(name="po_id", referencedColumnName="po_id", nullable=TRUE)
     */
	private $po_id; 
	
	/**	
     * @ManyToOne(targetEntity="Addon", inversedBy="placeOrderAddons")
     * @JoinColumn(name="addon_id", referencedColumnName="addon_id", nullable=TRUE)
     */
	private $addon_id; 
	
	
	public function __construct(){
	
	  	$this->created_at = new \DateTime();
	  	$this->updated_at = new \DateTime();
    }
	
	/**    Set po_id    * @param PlaceOrder $po_id     */
    public function setPlaceOrderId(PlaceOrder $po_id=null) {
        $this->po_id = $po_id;
		return $this;
	}
	/**   Get po_id  * @return PlaceOrder $po_id     */
    public function getPlaceOrderId(){
        return $this->po_id;
    }
	
	/**    Set addon_id    * @param Addon $addon_id     */
    public function setAddonId(Addon $addon_id=null) {
        $this->addon_id = $addon_id;
		return $this;
	}
	/**   Get addon_id  * @return Addon $addon_id     */
    public function getAddonId(){
        return $this->addon_id;
    }
	
    /**  Get id     * @return integer $id     */
    public function getId(){
        return $this->id;
    }
	/** Set poa_count  * @param string $poa_count   */
    public function setCount($poa_count)  {
        $this->poa_count = $poa_count;
    }

    /** Get poa_count * @return string $poa_count */
    public function getCount() {
        return $this->poa_count;
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