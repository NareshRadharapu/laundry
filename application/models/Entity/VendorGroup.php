<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/**
 *@ORM\Table
 * @Entity
 * @Table(name="vendorsgroup")
 */
class VendorGroup
{
	 /**
     * @var integer $id
	 *@Column(name="vgroup_id", type="integer", nullable=false) @Id @GeneratedValue
     */
    private $id;
    /**	@Column(name="name", type="string") */
    private $name;
    /** @Column(name="code", type="string", nullable="true") */
    private $code;
    
	/**	@Column(name="status", type="boolean") */
    private $status;
	/** @var \DateTime	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	 @var \DateTime @Column(name="created_at", type="datetime") */
    private $created_at;
	
    
   	public function __construct(){
        $this->status       =1;
      	$this->created_at 	= new \DateTime();
	  	$this->updated_at 	= new \DateTime();
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

    public function setCode($code) {
        $this->code = $code;
    }
    public function getCode() {
        return $this->code;
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