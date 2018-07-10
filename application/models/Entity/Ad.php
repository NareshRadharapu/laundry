<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 *@ORM\Table
 * @Entity
 * @Table(name="ads")
 */
class Ad
{
	/** @var integer $id
	 *@Column(name="ad_id", type="integer", nullable=false) @Id @GeneratedValue
    */
    private $id;
	/**	@Column(name="name", type="string",nullable="true") */
    private $name;
    /**	@Column(name="adType", type="string",nullable="true") */
    private $adType;
    /**	@Column(name="adCategory", type="string",nullable="true") */
    private $adCategory;
    /**	@Column(name="adPlan", type="string",nullable="true") */
    private $adPlan;

    /**	@Column(name="description", type="text",nullable="true") */
    private $description;

	/**	@Column(name="image", type="text",nullable="true") */
    private $image;
    /**	@Column(name="link", type="text",nullable="true") */
    private $link;
    /**	@Column(name="views", type="integer",nullable="false") */
    private $views;
    /**	@Column(name="viewsLimit", type="integer",nullable="true") */
    private $viewsLimit;
    /**	@Column(name="clicks", type="integer",nullable="true") */
    private $clicks;
    /**	@Column(name="clicksLimit", type="integer",nullable="true") */
    private $clicksLimit;
    /**	@Column(name="toDate", type="datetime",nullable="true") */
    private $toDate;
    /**	@Column(name="fromDate", type="datetime",nullable="true") */
    private $fromDate;
	/**	@Column(name="status", type="boolean",nullable="true") */
    private $status;
    /**	@Column(name="adminStatus", type="boolean",nullable="true") */
    private $adminStatus;
	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	@Column(name="created_at", type="datetime") */
    private $created_at;
	
	/** @ManyToOne(targetEntity="Apartment", inversedBy="ads")
	*	@JoinColumn(name="apt_id", referencedColumnName="apt_id", nullable=TRUE) */
	private $apt_id;
	
	/** @ManyToOne(targetEntity="Faculty", inversedBy="ads")
	*	@JoinColumn(name="faculty_id", referencedColumnName="faculty_id", nullable=TRUE) 	*/
	private $faculty_id;

	public function __construct(){
	  	$this->created_at = new \DateTime();
	  	$this->updated_at = new \DateTime();
		$this->status = 1;
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

    /**    Set faculty_id    * @param Faculty $faculty_id     */
    public function setFacultyId(Faculty $faculty_id=null) {
        $this->faculty_id = $faculty_id;
		return $this;
	}

	/**   Get faculty_id  * @return Faculty $faculty_id     */
    public function getFacultyId(){
        return $this->faculty_id;
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
    /** Set adType  * @param string $adType   */
    public function setAdType($adType)  {
        $this->adType = $adType;
    }

    /** Get adType * @return string $adType */
    public function getAdType() {
        return $this->adType;
    }

     /** Set adPlan  * @param string $adPlan   */
    public function setAdPlan($adPlan)  {
        $this->adPlan = $adPlan;
    }

    /** Get adPlan * @return string $adPlan */
    public function getAdPlan() {
        return $this->adPlan;
    }

     /** Set adCategory  * @param string $adCategory   */
    public function setAdCategory($adCategory)  {
        $this->adCategory = $adCategory;
    }

    /** Get adCategory * @return string $adCategory */
    public function getAdCategory() {
        return $this->adCategory;
    }
     /** Set description  * @param string $description   */
    public function setAdDescription($description)  {
        $this->description = $description;
    }

    /** Get description * @return string $description */
    public function getAdDescription() {
        return $this->description;
    }

    /** Set image  * @param string $image   */
    public function setImage($image)  {
        $this->image = $image;
    }

    /** Get image * @return string $image */
    public function getImage() {
        return $this->image;
    }
    
    /** Set link  * @param string $link   */
    public function setLink($link)  {
        $this->link = $link;
    }

    /** Get link * @return string $link */
    public function getLink() {
        return $this->link;
    }
    /** Set views  * @param string $views   */
    public function setView()  {
        $this->views = $this->views +1; 
    }

    /** Get views * @return string $views */
    public function getViews() {
        return $this->views;
    }
    /** Set viewsLimit  * @param string $viewsLimit   */
    public function setViewsLimit($viewsLimit)  {
        $this->viewsLimit = $viewsLimit;
    }

    /** Get viewsLimit * @return string $viewsLimit */
    public function getViewsLimit() {
        return $this->viewsLimit;
    }
    
    /** Set clicks  * @param string $clicks   */
    public function setClick()  {
        $this->clicks =   $this->clicks+1; 
    }

    /** Get clicks * @return string $clicks */
    public function getClicks() {
        return $this->clicks;
    }

    /** Set clicksLimit  * @param string $clicksLimit   */
    public function setClicksLimit($clicksLimit)  {
        $this->clicksLimit = $clicksLimit;
    }

    /** Get clicksLimit * @return string $clicksLimit */
    public function getClicksLimit() {
        return $this->clicksLimit;
    }

 	/** Set fromDate  * @param string $fromDate   */
    public function setFromDate($fromDate)  {
        $this->fromDate = new \DateTime($fromDate); 
    }

    /** Get fromDate * @return string $fromDate */
    public function getFromDate() {
        return $this->fromDate;
    }

    /** Set toDate  * @param string $toDate   */
    public function setToDate($toDate)  {
        $this->toDate = new \DateTime($toDate); 
    }

    /** Get toDate * @return string $toDate */
    public function getToDate() {
        return $this->toDate;
    }

	/**	Set status  * @param boolean $status     */
    public function setStatus($status){
        $this->status = $status;
    }

    /** Get status     * @return boolean $status   */
    public function getStatus() {
        return $this->status;
    }

    /**	Set adminStatus  * @param boolean $adminStatus     */
    public function setAdminStatus($adminStatus){
        $this->adminStatus = $adminStatus;
    }

    /** Get adminStatus     * @return boolean $adminStatus   */
    public function getAdminStatus() {
        return $this->adminStatus;
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
	public function setUpdatedAt(){
        $this->updated_at = new \DateTime();
	}
	/** Get updated_at     * @return string $updated_at     */
	 public function getUpdatedAt(){
        return $this->updated_at;
    }
}