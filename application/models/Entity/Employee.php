<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/**
 *@ORM\Table
 * @Entity
 * @Table(name="employees")
 */
class Employee
{
	 /**
     * @var integer $id
	 *@Column(name="emp_id", type="integer", nullable=false) @Id @GeneratedValue
     */
    private $id;
    /**	@Column(name="name", type="string") */
    private $name;
	/**	@Column(name="email", type="string", nullable="true") */
	private $email;
	/**	@Column(name="mobile", type="string",unique="true") */
    private $mobile;
	/**	@Column(name="password", type="string") */
    private $password;
	/**	@Column(name="password_salt", type="string",nullable="true") */
    private $password_salt;
	/**	@Column(name="status", type="boolean") */
    private $status;
	/** @var \DateTime	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	 @var \DateTime @Column(name="created_at", type="datetime") */
    private $created_at;
		
	/**	@ManyToOne(targetEntity="Role", inversedBy="Employee")
     * @JoinColumn(name="role_id", referencedColumnName="role_id", nullable=FALSE)     */
    private $role_id;

    /** @ManyToOne(targetEntity="Area", inversedBy="employees")
     * @JoinColumn(name="area_id", referencedColumnName="area_id", nullable=TRUE)     */
    private $area_id;

    /** @ManyToOne(targetEntity="Apartment", inversedBy="visitors")
    *   @JoinColumn(name="apt_id", referencedColumnName="apt_id", nullable=TRUE) */
    private $apt_id;

    /** @Column(name="loginTime", type="string") */
    private $loginTime;

     /** @Column(name="logoutTime", type="string") */
    private $logoutTime;

     /** @Column(name="storeIp", type="string", nullable="true") */
    private $storeIp;

   	public function __construct(){
      	$this->created_at 	= new \DateTime();
	  	$this->updated_at 	= new \DateTime();
        $this->status       =1;
   	}
   
	
   	/** Set role_id  * @param Role $role_id     */
	public function setRoleId(Role $role_id=null) {
        $this->role_id = $role_id;
		return $this;
	}
	/**   Get role_id @return Role $role_id     */
    public function getRoleId(){
        return $this->role_id;
    }

    /** Set area_id  * @param Area $area_id     */
    public function setAreaId(Area $area_id=null) {
        $this->area_id = $area_id;
        return $this;
    }
    /**   Get area_id @return Area $area_id     */
    public function getAreaId(){
        return $this->area_id;
    }

	
    /**    Set apt_id    * @param Apartment $apt_id     */
    public function setApartmentId(Apartment $apt_id=null) {
        $this->apt_id = $apt_id;
        return $this;
    }
    /**   Get apt_id  * @return Apartment $apt_id     */
    public function getApartmentId(){
        return $this->apt_id;
    }


	/** Get id     * @return integer $id     */
    public function getId(){
        return $this->id;
    }

    /** Set name  @param string $name     */
    public function setName($name) {
        $this->name = $name;
    }
    /**  Get name @return string $name     */
    public function getName() {
        return $this->name;
    }

	/** Set email  @param string $email     */
    public function setEmail($email) {
        $this->email = $email;
    }
    /**  Get email @return string $email     */
    public function getEmail() {
        return $this->email;
    }
	
	/** Set mobile @param string $mobile     */
    public function setMobile($mobile){
        $this->mobile = $mobile;
    }
    /** Get mobile @return string $mobile     */
    public function getMobile(){
        return $this->mobile;
    }
	
	/** Set password @param string $password */
    public function setPassword($password){
        $this->password = md5($password);
    }
    /** Get password @return string $password */
    public function getPassword(){
        return $this->password;
    }
	
	/** Set status @param string $status     */
    public function setStatus($status){
        $this->status = $status;
    }
    /** Get status @return string $status     */
    public function getStatus(){
        return $this->status;
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