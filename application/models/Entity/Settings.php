<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
 /**
 *@ORM\Table
 * @Entity
 * @Table(name="settings")
 */
class Settings
{
	 /** @var integer $id @Column(name="s_id", type="integer", nullable=false) @Id @GeneratedValue     */
    private $id;
	/**	@var string @Column(name="refPoints", type="integer", nullable="true") */
    private $refPoints;
	/**	@var string @Column(name="regPoints", type="integer", nullable="true") */
    private $regPoints;
	/**	@var string @Column(name="minPoints", type="integer", nullable="true") */
    private $minPoints;
	/**	@var string @Column(name="rpointsCost", type="integer", nullable="true") */
    private $rpointsCost;
	
	/**	@var string @Column(name="serviceCharge", type="string", nullable="true") */
    private $serviceCharge;
	
	/**	@var Boolean @Column(name="status", type="boolean") */
    private $status;
	/**	@var \DateTime @Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	 @var \DateTime @Column(name="created_at", type="datetime") */
    private $created_at;

   	public function __construct(){
      	$this->created_at 	= new \DateTime();
	  	$this->updated_at 	= new \DateTime();
		$this->status = 0;
   	}
   
	/** Get id     * @return integer $id     */
    public function getId(){
        return $this->id;
    }

    /** Set refPoints  @param string $refPoints     */
    public function setRefPoints($refPoints) {
        $this->refPoints = $refPoints;
    }
    /**  Get refPoints @return string $refPoints     */
    public function getRefPoints() {
        return $this->refPoints;
    }
	
	/** Set refPoints  @param string $regPoints     */
    public function setRegPoints($regPoints) {
        $this->regPoints = $regPoints;
    }
    /**  Get regPoints @return string $regPoints     */
    public function getRegPoints() {
        return $this->regPoints;
    }
	/** Set minPoints  @param string $minPoints     */
    public function setMinPoints($minPoints) {
        $this->minPoints = $minPoints;
    }
    /**  Get minPoints @return string $minPoints     */
    public function getMinPoints() {
        return $this->minPoints;
    }
	
	/** Set rpointsCost  @param string $rpointsCost     */
    public function setPointsCost($rpointsCost) {
        $this->rpointsCost = $rpointsCost;
    }
    /**  Get rpointsCost @return string $rpointsCost     */
    public function getPointsCost() {
        return $this->rpointsCost;
    }
	
	/** Set serviceCharge  @param string $serviceCharge     */
    public function setServiceCharge($serviceCharge) {
        $this->serviceCharge = $serviceCharge;
    }
    /**  Get serviceCharge @return string $serviceCharge     */
    public function getServiceCharge() {
        return $this->serviceCharge;
    }

    public function getServiceTax() {
        return $this->serviceCharge;
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