<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/**
 *@ORM\Table
 * @Entity
 * @Table(name="faculties")
 */
class Faculty
{
	 /**
     * @var integer $id
	 *@Column(name="faculty_id", type="integer", nullable=false) @Id @GeneratedValue
     */
    private $id;
    /**	@Column(name="firstname", type="string") */
    private $firstname;
	/**	@Column(name="lastname", type="string") */
    private $lastname;
	/**	@Column(name="email", type="string") */
	private $email;
	/**	@Column(name="mobile", type="string", unique="true") */
    private $mobile;
	/**	@Column(name="designation", type="string", nullable="true") */
    private $designation;
	/**	@Column(name="password", type="string") */
    private $password;
	/**	@Column(name="passwordSalt", type="string", options={"unsigned"=TRUE}) */
    private $passwordSalt;
	
	/**	@Column(name="oauth_id", type="string", nullable="true") */
    private $oauth_id;
	
	/**	@Column(name="resetPassword", type="boolean",options={"default"=0}) */
    private $resetPassword;
	/**	@Column(name="status", type="boolean",options={"default"=1}) */
    private $status;
	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	 @var \DateTime @Column(name="created_at", type="datetime") */
    private $created_at;
	
	/** @ManyToOne(targetEntity="Apartment", inversedBy="customers")
	*	@JoinColumn(name="apt_id", referencedColumnName="apt_id", nullable=TRUE) */
	private $apt_id;
	
   	public function __construct(){
		$this->passwordSalt 			= "";
		$this->status					= 1;
		$this->resetPassword			= 0;
      	$this->created_at 				= new \DateTime();
	  	$this->updated_at 				= new \DateTime();
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

    /** Set firstname  @param string $firstname     */
    public function setFirstName($firstname) {
        $this->firstname = $firstname;
    }
    /**  Get firstname @return string $firstname     */
    public function getFirstName() {
        return $this->firstname;
    }
	
	/** Set lastname  @param string $lastname     */
    public function setLastName($lastname) {
        $this->lastname = $lastname;
    }
    /**  Get lastname @return string $lastname     */
    public function getLastName() {
        return $this->lastname;
    }

	/** Set email  @param string $email     */
    public function setEmail($email) {
        $this->email = $email;
    }
    /**  Get email @return string $email     */
    public function getEmail() {
        return $this->email;
    }
	/** Set designation  @param string $designation     */
    public function setDesignation($designation) {
        $this->designation = $designation;
    }
    /**  Get designation @return string $designation     */
    public function getDesignation() {
        return $this->designation;
    }
	
	/** Set address @param string $address     */
    public function setAddress($address){
        $this->address = $address;
    }
    /** Get address @return string $address     */
    public function getAddress(){
        return $this->address;
    }
	
	
	/** Set oauth_id @param string $oauth_id     */
    public function setOauthId($oauth_id){
        $this->oauth_id = $oauth_id;
    }
    
	/** Get oauth_id @return string $oauth_id     */
    public function getOauthId(){
        return $this->oauth_id;
    }
	
	/** Set mobile @param string $mobile     */
    public function setMobile($mobile){
        $this->mobile = $mobile;
    }
    /** Get mobile @return string $mobile     */
    public function getMobile(){
        return $this->mobile;
    }
	/** Set password @param string $password     */
    public function setPassword($password){
        $this->password = md5($password);
    }
    /** Get mobile @return string $mobile     */
    public function getPassword(){
        return $this->password;
    }
	
	
	/** Set resetPassword @param string $resetPassword     */
    public function setResetPassword($resetPassword){
        $this->resetPassword = $resetPassword;
    }
    /** Get resetPassword @return string $resetPassword     */
    public function getResetPassword(){
        return $this->resetPassword;
    }
	
	/** Set status @param string $status     */
    public function setStatus($status){
        $this->status = $status;
    }
    /** Get status @return string $status     */
    public function getStatus(){
        return $this->status;
    }
	/** set updated_at @param string $updated_at     */
	public function setUpdatedAt($updated_at){
        $this->updated_at =  new \DateTime("now");
	}
	/** Get updated_at @return string $updated_at     */
	public function getUpdatedAt(){
        return $this->updated_at;
    }
	
	/**	set created_at  @param string $created_at     */
	public function setCreatedAt($created_at){
        $this->created_at = $created_at;
	}
	/**  Get created_at @return string $created_at     */
	public function getCreatedAt(){
        return $this->created_at;
    }
}