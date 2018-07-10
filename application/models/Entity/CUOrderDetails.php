<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 *@ORM\Table
 * @Entity
 * @Table(name="cu_order_details")
 */
class CUOrderDetails
{
	/**
     * @var integer $id
	 *@Column(name="cuod_id", type="integer", nullable=false) @Id @GeneratedValue
     */
    private $id;

    /** @Column(name="message",type="text",  nullable="true") **/
	private $message;
	
	/**	@Column(name="status", type="string",nullable="true") */
    private $status;


	/**	@Column(name="updated_at", type="datetime") */
	private $updated_at;
	/**	@Column(name="created_at", type="datetime") */
    private $created_at;
	
	/**	
     * @ManyToOne(targetEntity="CUDOrder", inversedBy="cuOrderDetails")
     * @JoinColumn(name="cudo_id", referencedColumnName="cudo_id", nullable=true)
     */
	private $cudo_id;

	/**	
     * @ManyToOne(targetEntity="CUSOrder", inversedBy="cuOrderDetails")
     * @JoinColumn(name="cuso_id", referencedColumnName="cuso_id", nullable=true)
     */
	private $cuso_id;
	
	/**	
     * @ManyToOne(targetEntity="PlaceOrderId", inversedBy="cuOrderDetails")
     * @JoinColumn(name="order_id", referencedColumnName="o_id", nullable=FALSE)
     */ 
	private $order_id;
	
	public function __construct(){
	  $this->created_at 		= new \DateTime();
	  $this->updated_at 		= new \DateTime();
	}
	
	/**    Set cudo_id    * @param CUDOrder $cudo_id     */
    public function setCudoId(CUDOrder $cudo_id=null) {
        $this->cudo_id = $cudo_id;
		return $this;
	}
	/**   Get cudo_id  * @return CUDOrder $cudo_id     */
    public function getCudoId(){
        return $this->cudo_id;
    }

    /**    Set cuso_id    * @param CUSOrder $cuso_id     */
    public function setCusoId(CUSOrder $cuso_id=null) {
        $this->cuso_id = $cuso_id;
		return $this;
	}
	/**   Get cuso_id  * @return CUSOrder $cuso_id     */
    public function getCusoId(){
        return $this->cuso_id;
    }


	
	public function setOrderId(PlaceOrderId $order_id){
		$this->order_id = $order_id;
	}
	public function getOrderId(){
		return $this->order_id;
	}
	
    /**  Get id     * @return integer $id     */
    public function getId(){
        return $this->id;
    }
	public function setMessage($message){
		$this->message = $message;
	}
	public function getMessage(){
		return $this->message;
	}
	
	/**	Set status * @param string $status     */
    public function setStatus($status){
        $this->status = $status;
    }

    /** Get status * @return string $status   */
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