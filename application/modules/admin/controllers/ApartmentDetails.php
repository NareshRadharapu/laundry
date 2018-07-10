<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class ApartmentDetails extends CI_Controller {



    function __construct()

    {

  		 parent::__construct();

		 

 	}

	

	public function index(){

		$this->_em = $this->doctrine->em;

		$data['apartments'] = $this->_em->getRepository('Entity\Apartments')->findAll();

		$data['body'] = 'apartments';

		$this->load->view('admin',$data);

	}

	public function lists(){

		

		$this->_em = $this->doctrine->em;

		$qb = $this->_em->createQueryBuilder();

		$apartments = $qb->select('b','Entity\Area')->from('Entity\Apartment','b')->innerJoin('b.area_id','Entity\Area')->getQuery()->getArrayResult();

		echo json_encode($apartments);

		die();

	}

	public function listsz(){

		

		$this->_em = $this->doctrine->em;

		$qb = $this->_em->createQueryBuilder();

		$apartments = $qb->select('b','Entity\Area')->from('Entity\Apartment','b')->innerJoin('b.area_id','Entity\Area')->where('b.status=:status')->setParameter('status',1)->getQuery()->getArrayResult();

		echo json_encode($apartments);

		die();

	}

	

	public function arealistsz(){

		

		$this->_em = $this->doctrine->em;

		$qb = $this->_em->createQueryBuilder();

		$apartments = $qb->select('b','Entity\Area')->from('Entity\Apartment','b')->innerJoin('b.area_id','Entity\Area')->where('b.status=:status')->setParameter('status',1)->getQuery()->getArrayResult();

		echo json_encode($apartments);

		die();

	}

	

	public function add(){

		

	}

	public function store(){

		



	}

	public function update($id){

	

			

	}

	public function edit(){

	$input = file_get_contents("php://input");

		$data = json_decode($input);

		$id = $data;

		$this->_em = $this->doctrine->em;

		$qb = $this->_em->createQueryBuilder();

		$apartment = $qb->select('a','Entity\Area','Entity\Catalog')->from('Entity\Apartment','a')->innerJoin('a.area_id','Entity\Area')->innerJoin('a.catalog_id','Entity\Catalog')->where('a.id=:id')->setParameter('id',$id)->getQuery()->getArrayResult();

		

		

		if(sizeof($apartment))

		echo json_encode($apartment[0]);

		die();	

		

	}

	

	public function view(){

		

		$input = file_get_contents("php://input");

		$data = json_decode($input);

		$id = $data;

		$this->_em = $this->doctrine->em;

		$qb = $this->_em->createQueryBuilder();

		$apartments = $qb->select('a','Entity\Block')->from('Entity\Apartment','a')->innerJoin('a.blocks','Entity\Block')->where('a.id=:id')->setParameter('id',$id)->getQuery()->getArrayResult();

		

		

		if(sizeof($apartments))

		echo json_encode($apartments[0]);

		die();	



		//$apartment = $qb->select('a','Entity\Area','Entity\Catalog')->from('Entity\Apartment','a')->innerJoin('a.area_id','Entity\Area')->innerJoin('a.catalog_id','Entity\Catalog')->where('a.id=:id')->setParameter('id',$id)->getQuery()->getArrayResult();

		

		

	}

	public function status(){

		

		

		die();

	}

	

}