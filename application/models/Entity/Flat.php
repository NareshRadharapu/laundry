<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 *@ORM\Table
 * @Entity
 * @Table(name="flats")
 */
class Flat
{
	/**
     * @var integer $id
	 *@Column(name="flat_id", type="integer", nullable=false) @Id @GeneratedValue
     */
    private $id;
	
	/**	@Column(name="name", type="string") */
    private $name;
	
	/**	@Column(name="intercom", type="string",nullable="true") */
    private $intercom;
	
	/**	@Column(name="eusn", type="string", nullable="true") */
    private $eusn;
	
	/**	@Column(name="bhk", type="string", length="5", nullable="true") */
    private $bhk;
	
	/**	@Column(name="size", type="smallint", nullable="true") */
    private $size;
	
	/**	@Column(name="facing", type="string", nullable="true") */
    private $facing;
	
	/**	@Column(name="readyToSale", type="boolean") */
    private $readyToSale;
	
	/**	@Column(name="readyToOccupy", type="boolean") */
    private $readyToOccupy;
	
	/**	@Column(name="salePrice", type="integer", nullable="true") */
    private $salePrice;
	
	/**	@Column(name="rentPrice", type="integer", nullable="true") */
    private $rentPrice;
	
	/**	@Column(name="nofpplStay", type="smallint", nullable="true") */
    private $nofpplStay;
	
	/**	@Column(name="cntOneName", type="string", nullable="true") */
    private $cntOneName;
	/**	@Column(name="cntOneMobile", type="string", nullable="true") */
    private $cntOneMobile;
	
	/**	@Column(name="cntTwoName", type="string", nullable="true") */
    private $cntTwoName;
	/**	@Column(name="cntTwoMobile", type="string", nullable="true") */
    private $cntTwoMobile;
	
		
	/**	@Column(name="status", type="boolean") */
    private $status;
	
	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	
	/**	@Column(name="created_at", type="datetime") */
    private $created_at;
	
	/**	@ManyToOne(targetEntity="Block", inversedBy="flats")
     * @JoinColumn(name="block_id", referencedColumnName="block_id", nullable=FALSE)     */
    private $block_id;
	
	/** @OneToMany(targetEntity="Customer",mappedBy="flat_id", cascade={"all"}) */
	private $customer;
	
	
	/** @OneToMany(targetEntity="Vehicle",mappedBy="flat_id", cascade={"all"}) */
	private $vehicles;
	
	/** @ManyToMany(targetEntity="ApartmentAdminNotification", mappedBy="noficationFlats", cascade={"all"}) */
    private $adminNotifications;
	
	
	public function __construct(){
		$this->vehicles   = new ArrayCollection(); 
        $this->customer   = new ArrayCollection(); 
	  	$this->created_at = new \DateTime();
	  	$this->updated_at = new \DateTime();
		$this->status = 1;
		$this->readyToSale =0;
		$this->readyToOccupy =0;
    }

	/**  Set vachile @return Vehicle $vachile     */
   	public function setVehicle(Vehicle $vachile) {
        if (!$this->vehicles->contains($vachile)) {
            $this->vehicles->add($vachile);
            $vachile->setFlatId($this);
		}
        return $this;
    }	
	/**  Get vehicles @return Vehicle $vehicles     */
	public function getVehicles(){
	   return $this->vehicles;
   	}
	
	/**    Set block_id    * @param Block $block_id     */
    public function setBlockId(Block $block_id=null) {
        $this->block_id = $block_id;
		return $this;
	}
	/**   Get block_id  * @return Block $block_id     */
    public function getBlockId(){
        return $this->block_id;
    }

    public function getHeadOrOwner(){

        foreach ($this->customer as $key => $c) {
           if($c->getSubType()=='owner'){
                 return $c;
            }elseif($c->getSubType()=='family head'){
                if(is_object($c->getOwnerId())){
                    return $c->getOwnerId();
                }else{
                    return $c;
                }
            }else{
                return '';
            }            
        }
        return false;
    }
	
    /**  Get id     * @return integer $id     */
    public function getId(){
        return $this->id;
    }
	
	/** Set name  * @param string $name   */
    public function setName($name)  {
        $this->name = $name;
    }

    /** Get name * @return string $name */
    public function getName() {
        return $this->name;
    }
	
	/** Set bhk  * @param string $bhk   */
    public function setBhk($bhk)  {
        $this->bhk = $bhk;
    }

    /** Get bhk * @return string $bhk */
    public function getBhk() {
        return $this->bhk;
    }
	
	/** Set intercom  * @param string $intercom   */
    public function setIntercom($intercom)  {
        $this->intercom = $intercom;
    }

    /** Get intercom * @return string $intercom */
    public function getIntercom() {
        return $this->intercom;
    }
	
	/** Set eusn  * @param string $eusn   */
    public function setEusn($eusn)  {
        $this->eusn = $eusn;
    }

    /** Get esun * @return string $esun */
    public function getEusn() {
        return $this->eusn;
    }
	/** Set size  * @param string $size   */
    public function setSize($size)  {
        $this->size = $size;
    }

    /** Get size * @return string $size */
    public function getSize() {
        return $this->size;
    }
	/** Set facing  * @param string $facing   */
    public function setFacing($facing)  {
        $this->facing = $facing;
    }

    /** Get facing * @return string $facing */
    public function getFacing() {
        return $this->facing;
    }
	
	/** Set readyToSale  * @param string $readyToSale   */
    public function setSale($readyToSale)  {
        $this->readyToSale = $readyToSale;
    }

    /** Get readyToSale * @return string $readyToSale */
    public function getSale() {
        return $this->readyToSale;
    }
	
	
	/** Set salePrice  * @param string $salePrice   */
    public function setSalePrice($salePrice)  {
        $this->salePrice = $salePrice;
    }

    /** Get salePrice * @return string $salePrice */
    public function getSalePrice() {
        return $this->salePrice;
    }
	/** Set rentPrice  * @param string $rentPrice   */
    public function setRentPrice($rentPrice)  {
        $this->rentPrice = $rentPrice;
    }

    /** Get rentPrice * @return string $rentPrice */
    public function getRentPrice() {
        return $this->rentPrice;
    }
	
	/** Set nofpplStay  * @param string $nofpplStay   */
    public function setNofPplStay($nofpplStay)  {
        $this->nofpplStay = $nofpplStay;
    }

    /** Get nofpplStay * @return string $nofpplStay */
    public function getNofPplStay() {
        return $this->nofpplStay;
    }
	
	/** Set cntOneName  * @param string $cntOneName   */
    public function setCntOneName($cntOneName)  {
        $this->cntOneName = $cntOneName;
    }

    /** Get cntOneName * @return string $cntOneName */
    public function getCntOneName() {
        return $this->cntOneName;
    }
	
	/** Set cntOneMobile  * @param string $cntOneMobile   */
    public function setCntOneMobile($cntOneMobile)  {
        $this->cntOneMobile = $cntOneMobile;
    }

    /** Get cntOneMobile * @return string $cntOneMobile */
    public function getCntOneMobile() {
        return $this->cntOneMobile;
    }
	/** Set cntTwoName  * @param string $cntTwoName   */
    public function setCntTwoName($cntTwoName)  {
        $this->cntTwoName = $cntTwoName;
    }

    /** Get cntTwoName * @return string $cntTwoName */
    public function getCntTwoName() {
        return $this->cntTwoName;
    }
	/** Set cntTwoMobile  * @param string $cntTwoMobile   */
    public function setCntTwoMobile($cntTwoMobile)  {
        $this->cntTwoMobile = $cntTwoMobile;
    }

    /** Get cntTwoMobile * @return string $cntTwoMobile */
    public function getCntTwoMobile() {
        return $this->cntTwoMobile;
    }
	
	/** Set readyToOccupy  * @param string $readyToOccupy   */
    public function setRoccupy($readyToOccupy)  {
        $this->readyToOccupy = $readyToOccupy;
    }

    /** Get readyToOccupy * @return string $readyToOccupy */
    public function getRoccupy() {
        return $this->readyToOccupy;
    }
	
	/**	Set status      * @param boolean $status     */
    public function setStatus($status){
        $this->status = $status;
    }

    /** Get status     * @return boolean $status   */
    public function getStatus() {
        return $this->status;
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