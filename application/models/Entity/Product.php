<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/**
 *@ORM\Table
 * @Entity
 * @Table(name="products")
 */
class Product
{
	 /**
     * @var integer $id
	 *@Column(name="product_id", type="integer", nullable=false) @Id @GeneratedValue
     */
    private $id;
    /**	@Column(name="barcode", type="string",length="50") */
    private $barcode;
	
	/**	@Column(name="status", type="boolean", nullable="true") */
	private $status;
	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	 @var \DateTime @Column(name="created_at", type="datetime") */
    private $created_at;
	
	/**	
     * @ManyToOne(targetEntity="Service", inversedBy="products")
     * @JoinColumn(name="service_id", referencedColumnName="service_id", nullable=FALSE)
     */
	private $service_id;
	
	/**	
     * @ManyToOne(targetEntity="Item", inversedBy="products")
     * @JoinColumn(name="item_id", referencedColumnName="item_id", nullable=FALSE)
     */
	private $item_id;

   	public function __construct(){
	  	$this->created_at 	= new \DateTime();
	  	$this->updated_at 	= new \DateTime();
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
	/**    Set service_id    * @param Service $service_id     */
    public function setServiceId(Service $service_id=null) {
        $this->service_id = $service_id;
		return $this;
	}
	/**   Get service_id  * @return Service $service_id     */
    public function getServiceId(){
        return $this->service_id;
    }
   
	/** Get id     * @return integer $id     */
    public function getId(){
        return $this->id;
    }

    /** Set barcode  @param string $barcode     */
    public function setBarcode($barcode) {
        $this->barcode = $barcode;
    }
    /**  Get barcode @return string $barcode     */
    public function getBarcode() {
        return $this->barcode;
    }

	/** Set status @param boolean $status     */
    public function setStatus($status){
        $this->status = $status;
    }
    /** Get status @return boolean $status     */
    public function getStatus(){
        return $this->status;
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