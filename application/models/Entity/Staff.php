<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/**
 *@ORM\Table
 * @Entity
 * @Table(name="staff")
 */
class Staff
{
	/**
     * @var integer $id
	 *@Column(name="staff_id", type="integer", nullable=false) @Id @GeneratedValue
    */
    private $id;
    /**	@Column(name="name", type="string") */
    private $name;
    /** @Column(name="designation", type="string", nullable="true") */
    private $designation;
	/**	@Column(name="email", type="string", nullable="true") */
	private $email;
	/**	@Column(name="mobile", type="string",nullable="true") */
    private $mobile;
    /** @Column(name="image", type="text",nullable="true") */
    private $image;
    /** @Column(name="address", type="text", nullable="true") */
    private $address;
     /** @Column(name="idProofType", type="string", nullable="true") */
    private $idProofType;
     /** @Column(name="idProof", type="text", nullable="true") */
    private $idProof;

	/**	@Column(name="status", type="boolean") */
    private $status;
	/** @var \DateTime	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	 @var \DateTime @Column(name="created_at", type="datetime") */
    private $created_at;
	
    /** @ManyToOne(targetEntity="Apartment", inversedBy="vendors")
     * @JoinColumn(name="apt_id", referencedColumnName="apt_id", nullable=TRUE)     */
    private $apt_id;

   	public function __construct(){
        $this->status       =1;
      	$this->created_at 	= new \DateTime();
	  	$this->updated_at 	= new \DateTime();
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

    /** Set designation  @param string $designation */
    public function setDesignation($designation) {
        $this->designation = $designation;
    }
    
    /**  Get designation @return string $designation */
    public function getDesignation() {
        return $this->designation;
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

    /** Set image  * @param string $image   */
    public function setImage($image)  {
        $this->image = $image;
    }

    /** Get image * @return string $image */
    public function getImage() {
        return $this->image;
    }
    /** Set address @param string $address     */
    public function setAddress($address){
        $this->address = $address;
    }
    /** Get address @return string $address     */
    public function getAddress(){
        return $this->address;
    }

    /** Set idProofType @param string $idProofType     */
    public function setIdProofType($idProofType){
        $this->idProofType = $idProofType;
    }
    /** Get idProofType @return string $idProofType     */
    public function getIdProofType(){
        return $this->idProofType;
    }
    /** Set idProof @param string $idProof     */
    public function setIdProof($idProof){
        $this->idProof = $idProof;
    }
    /** Get idProof @return string $idProof     */
    public function getIdProof(){
        return $this->idProof;
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