<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/**
 *@ORM\Table
 * @Entity
 * @Table(name="cu_employees")
 */
class CUEmployee
{
	 /**
     * @var integer $id
	 *@Column(name="cue_id", type="integer", nullable=false) @Id @GeneratedValue
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
	/**	@Column(name="password_salt", type="string",nullable="false") */
    private $password_salt;
	/**	@Column(name="status", type="boolean") */
    private $status;
	/** @var \DateTime	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	 @var \DateTime @Column(name="created_at", type="datetime") */
    private $created_at;
		
	/**	@ManyToOne(targetEntity="Role", inversedBy="CUEmployee")
     * @JoinColumn(name="role_id", referencedColumnName="role_id", nullable=FALSE)     */
    private $role_id;

    /** @ManyToOne(targetEntity="City", inversedBy="CUEmployee")
     * @JoinColumn(name="city_id", referencedColumnName="city_id", nullable=TRUE)     */
    private $city_id;

    /** @ManyToOne(targetEntity="CUnit", inversedBy="CUEmployees")
     * @JoinColumn(name="cu_id", referencedColumnName="cu_id", nullable=TRUE)     */
    private $cu_id;

   	public function __construct(){
      	$this->created_at 	= new \DateTime();
	  	$this->updated_at 	= new \DateTime();
        $this->password_salt = '';
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

    public function setCuId(CUnit $cu_id){
        $this->cu_id = $cu_id;
    }

    public function getCuId(){
        return $this->cu_id;
    }

    /** Set city_id  * @param City $city_id     */
    public function setCityId(Area $city_id=null) {
        $this->city_id = $city_id;
        return $this;
    }
    /**   Get city_id @return City $city_id     */
    public function getCityId(){
        return $this->city_id;
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