<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 *@ORM\Table
 * @Entity
 * @Table(name="storeclosingreport")
 */
class storeclosingreport
{
	/** @var integer $id
	 *@Column(name="sc_id", type="integer", nullable=false) @Id @GeneratedValue
    */
    private $id;
	/** @Column(name="store_id", type="integer", nullable=false) */
    private $store_id;
    /** @Column(name="business", type="string") */
    private $business;
    /** @Column(name="cash", type="string") */
    private $cash;
    /** @Column(name="card", type="string") */
    private $card;
    /** @Column(name="paytm", type="string") */
    private $paytm;
    /** @Column(name="online", type="string") */
    private $online;
    /** @Column(name="cheque", type="string") */
    private $cheque;
    /** @Column(name="ironDone", type="string") */
    private $ironDone;
    /** @Column(name="ironPending", type="string") */
    private $ironPending;
    /** @Column(name="deliveries", type="string") */
    private $deliveries;
    /** @Column(name="expDeliveries", type="string") */
    private $expDeliveries;
    /** @Column(name="pickups", type="string") */
    private $pickups;
    /** @Column(name="stcu", type="string") */
    private $stcu;
    /** @Column(name="pstcu", type="string") */
    private $pstcu;
    /** @Column(name="cupa", type="string") */
    private $cupa;
    /** @Column(name="penDel", type="string") */
    private $penDel;
    /** @Column(name="actPickups", type="string") */
    private $actPickups;
    /** @Column(name="zone", type="string") */
    private $zone;

	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	@Column(name="created_at", type="datetime") */
    private $created_at;
	
		
	public function __construct(){
	  	$this->created_at = new \DateTime();
	  	$this->updated_at = new \DateTime();
    }
	
    /**  Get id     * @return integer $id     */
    public function getId(){
        return $this->id;
    }
    public function setStoreId($store_id)  {
        $this->store_id = $store_id;
    }
    /**   Get store_id  * @return Area $area_id     */
    public function getStoreId() {
        return $this->store_id;
    }

    public function setBusiness($business)  {
        $this->business = $business;
    }
    public function getBusiness() {
        return $this->business;
    }

    public function setCash($cash)  {
        $this->cash = $cash;
    }
    public function getCash() {
        return $this->cash;
    }

    /** Set name  * @param integer $card   */
    public function setCard($card)  {
        $this->card = $card;
    }
    /** Get name * @return integer $card */
    public function getCard() {
        return $this->card;
    }
    
    /** Set name  * @param integer $paytm   */
    public function setPaytm($paytm)  {
        $this->paytm = $paytm;
    }
    /** Get name * @return integer $paytm */
    public function getPaytm() {
        return $this->paytm;
    }

    /** Set name  * @param integer $online   */
    public function setOnline($online)  {
        $this->online = $online;
    }
    /** Get name * @return integer $online */
    public function getOnline() {
        return $this->online;
    }

    /** Set name  * @param integer $cheque   */
    public function setCheque($cheque)  {
        $this->cheque = $cheque;
    }
    /** Get name * @return integer $cheque */
    public function getCheque() {
        return $this->cheque;
    }

    /** Set name  * @param integer $ironDone   */
    public function setIronDone($ironDone)  {
        $this->ironDone = $ironDone;
    }
    /** Get name * @return integer $ironDone */
    public function getIronDone() {
        return $this->ironDone;
    }

    /** Set name  * @param integer $ironPending   */
    public function setIronPending($ironPending)  {
        $this->ironPending = $ironPending;
    }
    /** Get name * @return integer $ironPending */
    public function getIronPending() {
        return $this->ironPending;
    }

    /** Set name  * @param integer $deliveries   */
    public function setDeliveries($deliveries)  {
        $this->deliveries = $deliveries;
    }
    /** Get name * @return integer $deliveries */
    public function getDeliveries() {
        return $this->deliveries;
    }

    /** Set name  * @param integer $expDeliveries   */
    public function setexpDeliveries($expDeliveries)  {
        $this->expDeliveries = $expDeliveries;
    }
    /** Get name * @return integer $expDeliveries */
    public function getexpDeliveries() {
        return $this->expDeliveries;
    }

    /** Set name  * @param integer $pickups   */
    public function setPickups($pickups)  {
        $this->pickups = $pickups;
    }
    /** Get name * @return integer $pickups */
    public function getPickups() {
        return $this->pickups;
    }

    /** Set name  * @param integer $stcu   */
    public function setStcu($stcu)  {
        $this->stcu = $stcu;
    }
    /** Get name * @return integer $stcu */
    public function getStcu() {
        return $this->stcu;
    }

    /** Set name  * @param integer $pstcu   */
    public function setPstcu($pstcu)  {
        $this->pstcu = $pstcu;
    }
    /** Get name * @return integer $pstcu */
    public function getPstcu() {
        return $this->pstcu;
    }

    /** Set name  * @param integer $cupa   */
    public function setCupa($cupa)  {
        $this->cupa = $cupa;
    }
    /** Get name * @return integer $cupa */
    public function getCupa() {
        return $this->cupa;
    }

    /** Set name  * @param integer $penDel   */
    public function setPenDel($penDel)  {
        $this->penDel = $penDel;
    }
    /** Get name * @return integer $penDel */
    public function getPenDel() {
        return $this->penDel;
    }

    /** Set name  * @param integer $actPickups   */
    public function setActPickups($actPickups)  {
        $this->actPickups = $actPickups;
    }
    /** Get name * @return integer $actPickups */
    public function getActPickups() {
        return $this->actPickups;
    }

    /** Set name  * @param integer $zone   */
    public function setZone($zone)  {
        $this->zone = $zone;
    }
    /** Get name * @return integer $zone */
    public function getZone() {
        return $this->zone;
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