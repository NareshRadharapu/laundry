<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Addon extends CI_Controller {

    function __construct()
    {
  		 parent::__construct();
		 
 	}
	
	public function index(){
		
	}
	public function lists(){
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$addons = $qb->select('a')->from('Entity\Addon','a')->addOrderBy('a.id','desc')->getQuery()->getArrayResult();
		echo json_encode($addons);
		die();
	}
	
	public function listsz(){
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$addons = $qb->select('a')->from('Entity\Addon','a')->where('a.status=:status')->setParameter('status',1)->getQuery()->getArrayResult();
		echo json_encode($addons);
		die();
	}
	public function itemslist(){
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$addonitems = $qb->select('a','Entity\Addon','Entity\Item','Entity\ItemType','Entity\Service')->from('Entity\CatalogPrice','cp')->innerJoin('cp.catalog_id','Entity\Catalog')->innerJoin('cp.item_id','Entity\Item')->innerJoin('cp.itype_id','Entity\ItemType')->innerJoin('cp.service_id','Entity\Service')->getQuery()->getArrayResult();
		echo json_encode($addonitems);
		die();
	}
	
	public function add(){
		
	}
	public function store(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$addonId	    =  $data->id;
		$name 	     	=  $data->name;
		$price 	     	=  $data->price;
		$description 	=  $data->description;
		$image 	     	=  $data->image;
		$status         = 1; //$data->status;
		
		$this->_em = $this->doctrine->em;
		
		if($addonId){
			$addon = $this->_em->find('Entity\Addon',$addonId);
		}else{
			$addon = new Entity\Addon();
		}

		$addon->setName($name);
		$addon->setDescription($description);
		$addon->setPrice($price);
		$addon->setImage($image);
//		$addon->setStatus($status);
		$this->_em->persist($addon);
		$this->_em->flush(); die();
	
	}
	

	public function edit(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$id = $data;
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$addon = $qb->select('a')->from('Entity\Addon','a')->where('a.id=:id')->setParameter('id',$id)->getQuery()->getArrayResult();
		if(sizeof($addon))
		echo json_encode($addon[0]);
		die();
	}
	
	
	public function status(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$addonId = $data;
		$this->_em = $this->doctrine->em;
	
		if((int)$addonId){
			$addon = $this->_em->find('Entity\Addon',(int)$addonId);
			$addon->setStatus(!$addon->getStatus());
			$this->_em->persist($addon);
			$this->_em->flush(); die();
		}
		
		die();
		
	}
	
	
	public function upload(){
		if ( !empty( $_FILES ) ) {
			$name = $_POST['name'];
			$tempPath = $_FILES['file']['tmp_name'];
			$filename = $_FILES['file']['name'];
			$uploadPath = 'uploads/addons' . DIRECTORY_SEPARATOR . $_FILES['file']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
// 		    $uploadPath = 'uploads' . DIRECTORY_SEPARATOR . $_GET['name'].'.jpg';
			move_uploaded_file( $tempPath, $uploadPath );
			$answer = array( 'answer' => 'File transfer completed' );
			$json = json_encode( $answer );
			echo $json;
		
		} else {
		
			echo 'No files';
		
		}

	}
	
}