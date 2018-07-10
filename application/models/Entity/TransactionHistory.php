<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 *@ORM\Table
 * @Entity
 * @Table(name="transactions_history")
 */
class TransactionHistory
{
	/**
     * @var integer $id
	 * @Column(name="th_id", type="integer", nullable=false) @Id @GeneratedValue   */
    private $id;
	/** @Column(name="order_id",type="string", length="25", nullable="true") **/
	private $order_id;

	/** @Column(name="storeId",type="integer", nullable="true") **/
	private $storeId;
	
	/** @Column(name="paidAmount",type="string",  nullable="true") **/
	private $paidAmount;
	/** @Column(name="usedAmount",type="string",  nullable="true") **/
	private $usedAmount;

	/** @Column(name="paymentType",type="string",  nullable="true") **/
	private $paymentType;

	/** @Column(name="transactionNumber",type="string",  nullable="true") **/
	private $transactionNumber;

	/** @Column(name="paymentFeedback",type="text",  nullable="true") **/
	private $paymentFeedback;

	/**	@ManyToOne(targetEntity="Customer", inversedBy="transactionHistory")
     * @JoinColumn(name="customer_id", referencedColumnName="cust_id", nullable=true)     */
	private $customer_id;
	
	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	
	/**	@Column(name="created_at", type="datetime") */
    private $created_at;

    /** @Column(name="cboyId",type="integer", nullable="true") **/
	private $cboyId;

	/** @Column(name="empId",type="integer", nullable="true") **/
	private $empId;

	/** @Column(name="cbDate",type="datetime", nullable="true") **/
	private $cbDate;

	/** @Column(name="acId",type="integer", nullable="true") **/
	private $acId;

	/** @Column(name="acDate",type="datetime", nullable="true") **/
	private $acDate;

	/** @Column(name="account",type="string", nullable="true") **/
	private $account;

	/** @Column(name="depositDate",type="datetime", nullable="true") **/
	private $depositDate;

	
	public function __construct(){
	  $this->created_at = new \DateTime();
	  $this->updated_at = new \DateTime();
	}
	
	public function setOrderId($order_id){
		$this->order_id = $order_id;
	}
	public function getOrderId(){
		return $this->order_id;
	}
	public function setCboyId($cboyId){
		$this->cboyId = $cboyId;
	}
	public function getCboyId(){
		return $this->cboyId;
	}
	public function setEmpId($empId){
		$this->empId = $empId;
	}
	public function getEmpId(){
		return $this->empId;
	}
	public function setCbDate($cbDate){
		$this->cbDate = new \DateTime($cbDate);
	}
	public function setCboyDate($cbDate){
		$this->cbDate = $cbDate;
	}
	public function getCbDate(){
		return $this->cbDate;
	}
	public function setAcId($acId){
		$this->acId = $acId;
	}
	public function getAcId(){
		return $this->acId;
	}
	public function setAcDate($acDate){
		$this->acDate = new \DateTime($acDate);
	}
	public function setAccDate($acDate){
		$this->acDate = $acDate;
	}
	public function getAcDate(){
		return $this->acDate;
	}

	public function setAccount($account){
		$this->account = $account;
	}
	public function getAccount(){
		return $this->account;
	}
	public function setDepositDate($depositDate){
		$this->depositDate = new \DateTime($depositDate);
	}
	public function setDepositedDate($depositDate){
		$this->depositDate = $depositDate;
	}
	public function getDepositDate(){
		return $this->depositDate;
	}



	public function setStoreId($storeId){
		$this->storeId = $storeId;
	}
	public function getStoreId(){
		return $this->storeId;
	}

	public function setPaidAmount($paidAmount){
		$this->paidAmount = $paidAmount;
	}
	public function getPaidAmount(){
		return $this->paidAmount;
	}

	public function setUsedAmount($usedAmount){
		$this->usedAmount = $usedAmount;
	}
	public function getUsedAmount(){
		return $this->usedAmount;
	}

	public function setPaymentType($paymentType){
		$this->paymentType = $paymentType;
	}

	public function getPaymentType(){
		return $this->paymentType;
	}

	public function setTransactionNumber($transactionNumber){
		$this->transactionNumber = $transactionNumber;
	}

	public function getTransactionNumber(){
		return $this->transactionNumber;
	}

	public function setPaymentFeedback($paymentFeedback){
		$this->paymentFeedback = $paymentFeedback;
	}

	public function getPaymentFeedback(){
		return $this->paymentFeedback;
	}
	
	public function setCustomerId(Customer $customer_id){
		$this->customer_id = $customer_id;
	}
	public function getCustomerId(){
		return $this->customer_id;
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