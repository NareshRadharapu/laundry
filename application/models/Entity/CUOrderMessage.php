<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 *@ORM\Table
 * @Entity
 * @Table(name="cu_order_messages")
 */
class CUOrderMessage
{
	/**
     * @var integer $id
	 * @Column(name="cuom_id", type="integer", nullable=false) @Id @GeneratedValue   */
    private $id;

    /** @Column(name="message",type="text",  nullable="true") **/
	private $message;
	
	/**	@ManyToOne(targetEntity="Employee", inversedBy="cuOrders")
     * @JoinColumn(name="emp_id", referencedColumnName="emp_id", nullable=TRUE)     */
	private $emp_id;

	/**	@ManyToOne(targetEntity="CUEmployee", inversedBy="cuOrders")
    * @JoinColumn(name="cue_id", referencedColumnName="cue_id", nullable=TRUE)     */
	private $cue_id;
	
	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	
	/**	@Column(name="created_at", type="datetime") */
    private $created_at;
	
	public function __construct(){
	  $this->created_at = new \DateTime();
	  $this->updated_at = new \DateTime();
	}
	
	public function setEmployeeId(Employee $emp_id){
    	$this->emp_id = $emp_id;
    }

    public function getEmployeeId(){
    	$this->emp_id;
    }

    public function setCUEmployeeId(CUEmployee $eue_id){
    	$this->eue_id = $eue_id;
    }

    public function getCUEmployeeId(){
    	$this->eue_id;
    }

    /**  Get id * @return integer $id  */
    public function getId(){
        return $this->id;
    }

	public function setMessage($message){
		$this->message = $message;
	}
	public function getMessage(){
		return $this->message;
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