<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 *@ORM\Table
 * @Entity
 * @Table(name="package_details")
 */
class CustomerPackageDetails
{
	/**
     * @var integer $id
	 *@Column(name="pd_id", type="integer", nullable=false) @Id @GeneratedValue
     */
    private $id;

     /** @Column(name="packageDetails", type="text", nullable="true") */
    private $packageDetails;

	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	@Column(name="created_at", type="datetime") */
    private $created_at;

	/**	@ManyToOne(targetEntity="Package", inversedBy="packageDetails")
     * @JoinColumn(name="package_id", referencedColumnName="package_id", nullable=FALSE)     */
    private $package_id;
	
	/**	@ManyToOne(targetEntity="Customer", inversedBy="packageDetails")
     * @JoinColumn(name="customer_id", referencedColumnName="cust_id", nullable=FALSE)     */
    private $customer_id;
	
	
	
	
	public function __construct(){
	  	$this->created_at = new \DateTime();
	  	$this->updated_at = new \DateTime();
		$this->status =1;
    }

	public function setPackageId(Package $package_id){
		$this->package_id = $package_id;
	}
	
	public function getPackageId(){
		return $this->package_id;
	}
    /**    Set customer_id    * @param Customer $customer_id     */
    public function setCustomerId(Customer $customer_id=null) {
        $this->customer_id = $customer_id;
        return $this;
    }
    /**   Get customer_id  * @return Customer $customer_id     */
    public function getCustomerId(){
        return $this->customer_id;
    }


    public function setPackageDetails($packageDetails){
        $this->packageDetails = $packageDetails;
    }

    public function getPackageDetails(){
        return $this->packageDetails;
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