<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 *@ORM\Table
 * @Entity
 * @Table(name="coupons")
 */
class Coupon
{
    /** @var integer $id
     *@Column(name="coupon_id", type="integer", nullable=false) @Id @GeneratedValue
    */
    private $id;
    /** @Column(name="code", type="string",unique="true") */
    private $code;
    /** @Column(name="cost", type="string") */
    private $cost;
        /** @Column(name="count", type="string") */
    private $count;
          /** @Column(name="minorderval", type="string") */
    private $minorderval;
    /** @Column(name="start_date", type="date") */
    private $start_date;
    /** @Column(name="exp_date", type="date") */
    private $exp_date;
    /** @Column(name="status", type="boolean") */
    private $status;
    /** @Column(name="updated_at", type="datetime") */
    private $updated_at;
    /** @Column(name="created_at", type="datetime") */
    private $created_at;
        
    public function __construct(){
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
        $this->status = 1;
    }
    
    
    
    /**  Get id     * @return integer $id     */
    public function getId(){
        return $this->id;
    }
    
    /** Set code  * @param string $code   */
    public function setCode($code)  {
        $this->code = $code;
    }

    /** Get code * @return string $code */
    public function getCode() {
        return $this->code;
    }

    /** Set cost  * @param string $cost   */
    public function setCost($cost)  {
        $this->cost = $cost;
    }

    /** Get cost * @return string $cost */
    public function getCost() {
        return $this->cost;
    }

     /** Set count  * @param string $count   */
    public function setCount($count)  {
        $this->count = $count;
    }

    /** Get count * @return string $count */
    public function getCount() {
        return $this->count;
    }

         /** Set minorderval  * @param string $minorderval   */
    public function setMinOrdVal($minorderval)  {
        $this->minorderval = $minorderval;
    }

    /** Get minorderval * @return string $minorderval */
    public function getMinOrdVal() {
        return $this->minorderval;
    }

    public function setStartDate($start_date){
        $this->start_date = new \DateTime($start_date);
    }

    public function getStartDate(){
        return $this->start_date;
    }

    public function setExpDate($exp_date){
        $this->exp_date = new \DateTime($exp_date);
    }

    public function getExpDate(){
        return $this->exp_date;
    }

    /** Set status  * @param boolean $status     */
    public function setStatus($status){
        $this->status = $status;
    }

    /** Get status     * @return boolean $status   */
    public function getStatus() {
        return $this->status;
    }
    /** set created_at     * @param string $created_at   */
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