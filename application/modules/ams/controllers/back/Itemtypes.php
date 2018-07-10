<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Itemtypes extends CI_Controller {



    function __construct()

    {

  		 parent::__construct();

		 

		

 	}

	

	public function index(){

		$this->_em = $this->doctrine->em;

		$data['items'] = $this->_em->getRepository('Entity\ItemType')->findAll();

		$data['body'] = 'itemtypes';

		$this->load->view('admin',$data);

	}

	

	public function lists(){

		

		$this->_em = $this->doctrine->em;

		$qb = $this->_em->createQueryBuilder();

		$input = file_get_contents("php://input");

		$data = json_decode($input);

		if($data){

			$itemtypes = $qb->select('i')->from('Entity\ItemType','i')->addOrderBy('i.id','desc')->where('i.itype_id=:itype_id')->setParameter('itype_id',$data)->getQuery()->getArrayResult();

		}else{

			$itemtypes = $qb->select('i')->from('Entity\ItemType','i')->addOrderBy('i.id','desc')->getQuery()->getArrayResult();

		}

		echo json_encode($itemtypes);

		die();

	}



	public function listsz(){

			

			$this->_em = $this->doctrine->em;

			$qb = $this->_em->createQueryBuilder();

			$input = file_get_contents("php://input");

			$data = json_decode($input);

			if($data){

				$itemtypes = $qb->select('i')->from('Entity\ItemType','i')->where('i.itype_id=:itype_id')->setParameter('itype_id',$data)->getQuery()->getArrayResult();

			}else{

				$itemtypes = $qb->select('i')->from('Entity\ItemType','i')->where('i.status=:status')->setParameter('status',1)->getQuery()->getArrayResult();

			}

			echo json_encode($itemtypes);

			die();

		}	

	public function add(){

		

	}

	public function store(){

		

		$input = file_get_contents("php://input");

		$data = json_decode($input);

		$itemtypeId		= $data->id;

		$name 	     = $data->name;
		$code		= $data->code;

		$status      = 1; //$data->status;

//print_r($data); die();		

		$this->_em = $this->doctrine->em;

		

		if($itemtypeId){

			$itemtype = $this->_em->find('Entity\ItemType',$itemtypeId);

		}else{

			$itemtype = new Entity\ItemType();

		}

			

		$itemtype->setName($name);
		
		$itemtype->setCode($code);

		$itemtype->setStatus($status);

		$this->_em->persist($itemtype);

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

		$itemtype = $qb->select('i')->from('Entity\ItemType','i')->where('i.id=:id')->setParameter('id',$id)->getQuery()->getArrayResult();

		if(sizeof($itemtype))

		echo json_encode($itemtype[0]);

		die();	

		

	}

	

	

	public function status(){

	    

		$input = file_get_contents("php://input");

		$data = json_decode($input);

		$itemtypeId = $data;

		$this->_em = $this->doctrine->em;

	

		if((int)$itemtypeId){

			$itemtype = $this->_em->find('Entity\ItemType',(int)$itemtypeId);

			$itemtype->setStatus(!$itemtype->getStatus());

			$this->_em->persist($itemtype);

			$this->_em->flush(); die();

		}

		

		die();		

	}

	

}