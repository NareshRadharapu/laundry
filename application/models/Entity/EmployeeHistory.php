<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/**
 *@ORM\Table
 * @Entity
 * @Table(name="employeehistory")
 */
class EmployeeHistory
{
	/**
    * @var integer $id
	*@Column(name="eh_id", type="integer", nullable=false) @Id @GeneratedValue
    */
    private $id;
    /** @Column(name="emp_id",type="integer", nullable="true") **/
    private $emp_id;
		
    /** @Column(name="loginTime", type="string") */
    private $loginTime;

     /** @Column(name="logoutTime", type="string", nullable="true") */
    private $logoutTime;

     /** @Column(name="storeIp", type="string", nullable="true") */
    private $storeIp;
    /** @var \DateTime  @Column(name="updated_at", type="datetime") */
    private $updated_at;
    /**  @var \DateTime @Column(name="created_at", type="datetime") */
    private $created_at;

   	public function __construct(){
      	$this->created_at 	= new \DateTime();
	  	$this->updated_at 	= new \DateTime();
        $this->status       =1;
   	}

	/** Get id     * @return integer $id     */
    public function getId(){
        return $this->id;
    }
	public function setEmpId($emp_id){
        $this->emp_id = $emp_id;
    }
    public function getEmpId(){
        return $this->emp_id;
    }
    /** Set loginTime  @param string $loginTime     */
    public function setLoginTime($loginTime) {
        $this->loginTime = $loginTime;
    }
    /**  Get loginTime @return string $loginTime     */
    public function getLoginTime() {
        return $this->loginTime;
    }
    /** Set logoutTime  @param string $logoutTime     */
    public function setLogoutTime($logoutTime) {
        $this->logoutTime = $logoutTime;
    }
    /**  Get logoutTime @return string $logoutTime     */
    public function getLogoutTime() {
        return $this->logoutTime;
    }
    /** Set storeIp  @param string $storeIp     */
    public function setStoreIp($storeIp) {
        $this->storeIp = $storeIp;
    }
    /**  Get storeIp @return string $storeIp     */
    public function getStoreIp() {
        return $this->storeIp;
    }
	/** set updated_at @param DateTime  $updated_at     */
	public function setUpdatedAt( $updated_at){
        $this->updated_at->modify("now");
	}
	/** Get updated_at @return string $updated_at     */
	public function getUpdatedAt(){
        return $this->updated_at;
    }
	
	/**	set created_at  @param DateTime  $created_at     */
	public function setCreatedAt($created_at){
        $this->created_at = $created_at;
	}
	/**  Get created_at @return string $created_at     */
	public function getCreatedAt(){
        return $this->created_at;
    }
}