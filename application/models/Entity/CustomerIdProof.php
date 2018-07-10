<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 *@ORM\Table
 * @Entity
 * @Table(name="customer_idproof")
 */
class CustomerIdProof
{
	/**
     * @var integer $id
	 *@Column(name="cip_id", type="integer", nullable=false) @Id @GeneratedValue
     */
    private $id;
	
	/** @Column(name="enroll",type="string", length="22") **/
	private $enroll;
	
	/** @Column(name="type",type="string", length="18", nullable="true") **/
	private $type;
	
	/** @Column(name="image",type="string", nullable="true") **/
	private $image;
	
	
	/**	@Column(name="status", type="boolean") */
    private $status;
	
	/**	@ManyToOne(targetEntity="Customer", inversedBy="idproofs")
     * @JoinColumn(name="customer_id", referencedColumnName="cust_id", nullable=true)     */
	private $customer_id;
	
	
	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	
	/**	@Column(name="created_at", type="datetime") */
    private $created_at;
	
	
	
	public function __construct(){
	  $this->created_at = new \DateTime();
	  $this->updated_at = new \DateTime();
	  $this->status = 0;
	
    }
	
	public function setEnroll($enroll){
		$this->enroll = $enroll;
	}
	public function getEnroll(){
		return $this->enroll;
	}
	
	public function setType($type){
		$this->type = $type;
	}
	public function getType(){
		return $this->type;
	}
	
	/** Set image  * @param string $image   */
    public function setImage($image)  {
        $this->image = $image;
    }

    /** Get image * @return string $image */
    public function getImage() {
        return $this->image;
    }
	
	
	public function setCustomerId(Customer $customer_id){
		$this->customer_id = $customer_id;
	}
	public function getCustomerId(){
		return $this->customer_id;
	}
	
    /**  Get id     * @return integer $id     */
    public function getId(){
        return $this->id;
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