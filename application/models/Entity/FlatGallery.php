<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM,
Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 *@ORM\Table
 * @Entity
 * @Table(name="flat_gallery")
 */
class FlatGallery
{
	/**
     * @var integer $id
	 *@Column(name="fg_id", type="integer", nullable=false) @Id @GeneratedValue
     */
    private $id;
	/**	@Column(name="title", type="string", nullable="true") */
    private $title;
	/**	@Column(name="image", type="string", nullable="true") */
    private $image;
	
	/**	@Column(name="status", type="boolean") */
    private $status;
	/**	@Column(name="updated_at", type="datetime") */
    private $updated_at;
	/**	@Column(name="created_at", type="datetime") */
    private $created_at;
	
	/**	@ManyToOne(targetEntity="Flat", inversedBy="galleries")
     * @JoinColumn(name="flat_id", referencedColumnName="flat_id", nullable=FALSE)     */
    private $flat_id;
	
	public function __construct(){
	  	$this->created_at = new \DateTime();
	  	$this->updated_at = new \DateTime();
		$this->status = 1;
    }
	
	/**    Set flat_id    * @param Flat $flat_id     */
    public function setFlatId(Flat $flat_id=null) {
        $this->flat_id = $flat_id;
		return $this;
	}
	
	/**   Get flat_id  * @return Flat $flat_id     */
    public function getFlatId(){
        return $this->flat_id;
    }

	
    /**  Get id     * @return integer $id     */
    public function getId(){
        return $this->id;
    }
	/** Set title  * @param string $title   */
    public function setTitle($title)  {
        $this->title = $title;
    }

    /** Get title * @return string $title */
    public function getTitle() {
        return $this->title;
    }
	
	/** Set image  * @param string $image   */
    public function setImage($image)  {
        $this->image = $image;
    }

    /** Get image * @return string $image */
    public function getImage() {
        return $this->image;
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