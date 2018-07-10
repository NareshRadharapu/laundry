<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Areas extends CI_Controller {

    function __construct()

    {

		

  		parent::__construct();

 	}

	

	public function index(){

		$this->_em = $this->doctrine->em;

		$data['areas'] = $this->_em->getRepository('Entity\Area')->findAll();

		$data['body'] = 'areas';

		$this->load->view('admin',$data);

	}

	public function lists(){

		$this->_em = $this->doctrine->em;

		$qb = $this->_em->createQueryBuilder();

		$areas = $qb->select('a','Entity\City')->from('Entity\Area','a')->addOrderBy('a.id','desc')->innerJoin('a.city_id','Entity\City')->getQuery()->getArrayResult();

		echo json_encode($areas);

		die();

	}

	public function listsz(){	

		$this->_em = $this->doctrine->em;

		$qb = $this->_em->createQueryBuilder();

		$areas = $qb->select('a','Entity\City')->from('Entity\Area','a')->innerJoin('a.city_id','Entity\City')->where('a.status=:status')->setParameter('status',1)->getQuery()->getArrayResult();

		echo json_encode($areas);

		die();

	}



	public function add(){

		

	}

	public function store(){

		

		$input = file_get_contents("php://input");

		$data = json_decode($input);

		$areaId		= $data->id;

		$cityId 	 = $data->city;

		$name 	     = $data->name;

		$status      = 1; //$data->status;

		

		$this->_em = $this->doctrine->em;

		$city = $this->_em->getRepository('Entity\City')->find($cityId);

		

		if($areaId){

			$area = $this->_em->find('Entity\Area',$areaId);

		}else{

			$area = new Entity\Area();

		}

		$area->setName($name);

		$area->setStatus($status);

		$area->setCityId($city);

		$this->_em->persist($area);

		$this->_em->flush();die();

		

	//	return redirect('admin/areas');

	}

	public function update($id){

	

			

	}

	public function edit(){

		

		$input = file_get_contents("php://input");

		$data = json_decode($input);

		$id = $data;

		$this->_em = $this->doctrine->em;

		$qb = $this->_em->createQueryBuilder();

		$area = $qb->select('a','Application_Entity_City')->from('Entity\Area','a')->innerJoin('a.city_id','Application_Entity_City')->where('a.id=:id')->setParameter('id',$id)->getQuery()->getArrayResult();

		if(sizeof($area))

		echo json_encode($area[0]);

		die();

	}

	public function status(){

		$input = file_get_contents("php://input");

		$data = json_decode($input);

		$areaId = $data;

		$this->_em = $this->doctrine->em;

	

		if((int)$areaId){

			$area = $this->_em->find('Entity\Area',(int)$areaId);

			$area->setStatus(!$area->getStatus());

			$this->_em->persist($area);

			$this->_em->flush(); die();

		}

		

		die();

	}

	

}