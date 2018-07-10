<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Items extends CI_Controller {



    function __construct()
    {
  		 parent::__construct();
 	}

	

	public function index(){

		$this->_em = $this->doctrine->em;

		$data['items'] = $this->_em->getRepository('Entity\Item')->findAll();

		$data['body'] = 'items';

		$this->load->view('admin',$data);

	}

	

	public function lists(){

		

$this->_em = $this->doctrine->em;

		$qb = $this->_em->createQueryBuilder();

		$input = file_get_contents("php://input");

		$data = json_decode($input);

		if($data){

			$items = $qb->select('i')->from('Entity\Item','i')->where('i.itype_id=:itype_id')->setParameter('itype_id',$data)->addOrderBy('i.id','desc')->getQuery()->getArrayResult();

		}else{

			$items = $qb->select('i','Entity\ItemType','Entity\Service')->from('Entity\Item','i')->innerJoin('i.itype_id','Entity\ItemType')->leftJoin('i.itemServices','Entity\Service')->getQuery()->getArrayResult();

		}

		echo json_encode($items);

		die();
	}

	public function listsz(){

		

		$this->_em = $this->doctrine->em;

		$qb = $this->_em->createQueryBuilder();

		$input = file_get_contents("php://input");

		$data = json_decode($input);

		if($data){

			$items = $qb->select('i')->from('Entity\Item','i')->where('i.itype_id=:itype_id')->setParameter('itype_id',$data)->addOrderBy('i.id','desc')->getQuery()->getArrayResult();

		}else{

			$items = $qb->select('i')->from('Entity\Item','i')->innerJoin('i.itype_id','Entity\ItemType')->getQuery()->getArrayResult();

		}

		echo json_encode($items);

		die();

	}
	

	public function itypeslist(){

		$this->_em = $this->doctrine->em;

		$qb = $this->_em->createQueryBuilder();

		$itemTypes = $qb->select('i')->from('Entity\ItemType','i')->getQuery()->getArrayResult();

		echo json_encode($itemTypes);

		die();

	}

	public function serviceitemtypes(){

		$input = file_get_contents("php://input");

		$data = json_decode($input);

		

		$this->_em = $this->doctrine->em;

		$qb = $this->_em->createQueryBuilder();

		$itemTypes = array();

		$service = $this->_em->find('Entity\Service',$data);

		if(is_object($service))

		$itemTypes = $service->getItemTypes();

		

		echo json_encode($itemTypes);

		die();

	}

	

	

	

	public function add(){

		

	}

	public function store(){

		

		$input = file_get_contents("php://input");

		$data = json_decode($input);

		$itemId		 = $data->id;

		$name 	     = $data->name;

		//$image 	     = $data->image;

		$status      = 1; //$data->status;

		$itemTypeId    = $data->itemtype;
		$image 	     = $itemTypeId.'-'.$name.'.png';

		$sservices      = $data->sservices;
		$code          = $data->code;

	

		

		$this->_em = $this->doctrine->em;

		

		

		if($itemTypeId){

			$itemType = $this->_em->find('Entity\ItemType',$itemTypeId);

			}

		

		if($itemId){

			$item = $this->_em->find('Entity\Item',$itemId);

		}else{

			$item = new Entity\Item();

		}

		

		$item->removeService();

		

		foreach($sservices as $s){

				$service = $this->_em->find('Entity\Service',$s);

				$item->addService($service);

		 }

			

		$item->setName($name);

		$item->setImage($image);

		if(is_object($itemType))

		$item->setItemType($itemType);

		

		$item->setStatus($status);
		$item->setCode($code);

		$this->_em->persist($item);

		$this->_em->flush();die();

	}

	public function update($id){

	

			

	}

	public function edit(){

	    

		$input = file_get_contents("php://input");

		$data = json_decode($input);

		$id = $data;

		$this->_em = $this->doctrine->em;

		$qb = $this->_em->createQueryBuilder();

		//$item = $qb->select('i')->from('Entity\Item','i')->where('i.id=:id')->setParameter('id',$id)->getQuery()->getArrayResult();

		 $item = $qb->select('i','Entity\ItemType','Entity\Service')->from('Entity\Item','i')->innerJoin('i.itype_id','Entity\ItemType')->leftJoin('i.itemServices','Entity\Service')->where('i.id=:id')->setParameter('id',$id)->getQuery()->getArrayResult();

		if(sizeof($item))

		echo json_encode($item[0]);

		die();	

		

	}

	

	

	public function status(){

	    

		$input = file_get_contents("php://input");

		$data = json_decode($input);

		$itemId = $data;

		$this->_em = $this->doctrine->em;

	

		if((int)$itemId){

			$item = $this->_em->find('Entity\Item',(int)$itemId);

			$item->setStatus(!$item->getStatus());

			$this->_em->persist($item);

			$this->_em->flush(); die();

		}

		

		die();		

	}

	

	public function upload(){

		if ( !empty( $_FILES ) ) {

			$name = $_POST['name'];

			$tempPath = $_FILES['file']['tmp_name'];

			$filename = $_FILES['file']['name'];

			$uploadPath = 'uploads/items' . DIRECTORY_SEPARATOR . $_FILES['file']['name'];

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