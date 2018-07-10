<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/**
 *@ORM\Table
 * @Entity
 * @Table(name="pickup_boys")
 */
class PickupBoy
{
	 /**
     * @var integer $id
	 *@Column(name="pb_id", type="integer", nullable=false) @Id @GeneratedValue
     */
    private $id;
    /**	@Column(name="name", type="string") */
    private $name;
	/**	@Column(name="email", type="string") */
	private $email;
    /** @Column(name="image", type="string", nullable="true") */
    private $image;
	/**	@Column(name="mobile", type="string", unique="true") */
    private $mobile;
	/**	@Column(name="password", type="string") */
    private $password;
	/**	@Column(name="passwordSalt", type="string", options={"unsigned"=TRUE}) */
    private $passwordSalt;
	/**	@Column(name="token", type="string", nullable="true") */
    private $token;
	
	/**	@Column(name="status", type="boolean",options={"default"=1}) */
    private $status;
	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	 @var \DateTime @Column(name="created_at", type="datetime") */
    private $created_at;
	
	/** @ManyToOne(targetEntity="Area", inversedBy="pickupBoys")
	*	@JoinColumn(name="area_id", referencedColumnName="area_id", nullable=TRUE) */
	private $area_id;
    
    /** @OneToMany(targetEntity="Customer", mappedBy="agent_id", cascade={"all"}) */
    private $customers;

   	public function __construct(){
		$this->passwordSalt 			= "";
		$this->status					= 1;
      	$this->created_at 				= new \DateTime();
	  	$this->updated_at 				= new \DateTime();
        $this->customers = new ArrayCollection();
   	}
	
    public function getPackageCustomers()
    {
        return $this->customers;
    }

	/**    Set area_id    * @param Area $area_id     */
    public function setAreaId(Area $area_id=null) {
        $this->area_id = $area_id;
		return $this;
	}
	/**   Get area_id  * @return Area $area_id     */
    public function getAreaId(){
        return $this->area_id;
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

    /** Set image    * @param string $image   */
    public function setImage($image)  {
        $this->image = $image;
    }
    /** Get image     * @return string $image */
    public function getImage() {
        return $this->image;
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
	
    /** Set token @param string $token     */
    public function setToken($token){
        $this->token = $token;
    }
    
    /** Get token @return string $token     */
    public function getToken(){
        return $this->token;
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
        $this->created_at =  new \DateTime("now");
	}
	/**  Get created_at @return string $created_at     */
	public function getCreatedAt(){
        return $this->created_at;
    }
}