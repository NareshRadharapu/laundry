<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/**
 *@ORM\Table
 * @Entity
 * @Table(name="permissions")
 */
class Permission
{
	 /** @var integer $id @Column(name="permission_id", type="integer", nullable=false) @Id @GeneratedValue     */
    private $id;
    /**	@var string @Column(name="resource", type="string") */
    private $resource;
    /** @var string @Column(name="rlabel", type="string") */
    private $rlabel;
    
	/**	@var string @Column(name="roles", type="string",nullable="true") */
    private $roles;
	/**	@var Boolean @Column(name="status", type="boolean") */
    private $status;

    /** @var Boolean @Column(name="ptype", type="string") */
    private $ptype;

	/**	@var \DateTime @Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	 @var \DateTime @Column(name="created_at", type="datetime") */
    private $created_at;
	

   	public function __construct(){
      	$this->created_at 	= new \DateTime();
	  	$this->updated_at 	= new \DateTime();
        $this->status = 1;
   	}
   

    /** Set id  @param integer $id     */
    public function setId($id) {
        $this->id = $id;
    }
	/** Get id     * @return integer $id     */
    public function getId(){
        return $this->id;
    }

    /** Set resource  @param string $resource     */
    public function setResource($resource) {
        $this->resource = $resource;
    }
    /**  Get resource @return string $resource     */
    public function getResource() {
        return $this->resource;
    }


    /** Set rlabel  @param string $rlabel     */
    public function setLabel($rlabel) {
        $this->rlabel = $rlabel;
    }
    /**  Get rlabel @return string $rlabel     */
    public function getLabel() {
        return $this->rlabel;
    }

	/** Set roles  @param string $roles     */
    public function setRoles($roles) {
        $this->roles = $roles;
    }
    /**  Get roles @return string $roles     */
    public function getRoles() {
        return $this->roles;
    }

    public function setPtype($ptype){
        $this->ptype = $ptype;
    }

    public function getPtype(){
        return $this->ptype;
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