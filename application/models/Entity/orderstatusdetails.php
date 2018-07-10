<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 *@ORM\Table
 * @Entity
 * @Table(name="orderstatusdetails")
 */
class orderstatusdetails
{
	/**
     * @var integer $id
	 *@Column(name="os_id", type="integer", nullable=false) @Id @GeneratedValue
     */
    private $id;

    /** @Column(name="receiptNo", type="integer", nullable=true) **/
    private $receiptNo;

    /** @Column(name="order_id",type="string", length="25") **/
	private $order_id;

	/**	@Column(name="orderDate", type="datetime", nullable="true") **/
    private $orderDate;

    /** @Column(name="SAA",type="datetime",  nullable="true") **/
	private $SAA;
	
	/**	@Column(name="SAPI", type="datetime",nullable="true") */
    private $SAPI;

    /** @Column(name="PO",type="datetime",  nullable="true") **/
	private $PO;
	
	/**	@Column(name="STCU", type="datetime",nullable="true") */
    private $STCU;

    /**	@Column(name="CPBA", type="datetime",nullable="true") */
    private $CPBA;

    /**	@Column(name="CUAA", type="datetime",nullable="true") */
    private $CUAA;

    /**	@Column(name="CUTS", type="datetime",nullable="true") */
    private $CUTS;

    /**	@Column(name="CUPA", type="datetime",nullable="true") */
    private $CUPA;

    /**	@Column(name="SADA", type="datetime",nullable="true") */
    private $SADA;

    /**	@Column(name="ORD", type="datetime",nullable="true") */
    private $ORD;

    /**	@Column(name="OPDA", type="datetime",nullable="true") */
    private $OPDA;

    /**	@Column(name="DOA", type="datetime",nullable="true") */
    private $DOA;

    /**	@Column(name="OD", type="datetime",nullable="true") */
    private $OD;

	/**	@Column(name="updated_at", type="datetime") */
	private $updated_at;

	/**	@Column(name="created_at", type="datetime") */
    private $created_at;

	/**	@Column(name="isDelete", type="boolean") */
    private $isDelete;
	
	
	public function __construct(){
	  $this->created_at 		= new \DateTime();
	  $this->updated_at 		= new \DateTime();
	  $this->isDelete 		= 0;
	}
	
	public function setReceiptNo($receiptNo){
		$this->receiptNo = $receiptNo;
	}
	public function getReceiptNo(){
		return $this->receiptNo;
	}

	public function setOrderId($order_id){
		$this->order_id = $order_id;
	}
	public function getOrderId(){
		return $this->order_id;
	}
	
	public function setOrderDate($orderDate){
		$this->orderDate = $orderDate;
	}
	public function getOrderDate(){
		return $this->orderDate;
	}

    /**  Get id     * @return integer $id     */
    public function getId(){
        return $this->id;
    }
	public function setSAA($SAA){
		$this->SAA = $SAA;
	}
	public function getSAA(){
		return $this->SAA;
	}

	public function setSAPI($SAPI){
		$this->SAPI = $SAPI;
	}
	public function getSAPI(){
		return $this->SAPI;
	}
	public function setOD($OD){
		$this->OD = $OD;
	}
	public function getOD(){
		return $this->OD;
	}
	public function setPO($PO){
		$this->PO = $PO;
	}
	public function getPO(){
		return $this->PO;
	}
	public function setSTCU($STCU){
		$this->STCU = $STCU;
	}
	public function getSTCU(){
		return $this->STCU;
	}
	public function setCPBA($CPBA){
		$this->CPBA = $CPBA;
	}
	public function getCPBA(){
		return $this->CPBA;
	}
	public function setCUAA($CUAA){
		$this->CUAA = $CUAA;
	}
	public function getCUAA(){
		return $this->CUAA;
	}
	public function setCUTS($CUTS){
		$this->CUTS = $CUTS;
	}
	public function getCUTS(){
		return $this->CUTS;
	}
	public function setCUPA($CUPA){
		$this->CUPA = $CUPA;
	}
	public function getCUPA(){
		return $this->CUPA;
	}
	public function setSADA($SADA){
		$this->SADA = $SADA;
	}
	public function getSADA(){
		return $this->SADA;
	}
	public function setOPRD($OPRD){
		$this->OPRD = $OPRD;
	}
	public function getOPRD(){
		return $this->OPRD;
	}
	public function setORD($ORD){
		$this->ORD = $ORD;
	}
	public function getORD(){
		return $this->ORD;
	}
	public function setDOA($DOA){
		$this->DOA = $DOA;
	}
	public function getDOA(){
		return $this->DOA;
	}
	
	public function setIsDelete($isDelete){
    	$this->isDelete = $isDelete;
    }

    public function getIsDelete(){
    	return $this->isDelete;
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