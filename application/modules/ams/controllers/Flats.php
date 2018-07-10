<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flats extends CI_Controller {

    function __construct()
    {
  		 parent::__construct();
		 
		
 	}
	public function index(){
		$this->_em = $this->doctrine->em;
		$data['flats'] = $this->_em->getRepository('Entity\Flat')->findAll();
		$data['body'] = 'flats';
		$this->load->view('admin',$data);
	}
	public function lists(){	
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		if($data){
			$flats = $qb->select('f','Entity\Block','Entity\Apartment')->from('Entity\Flat','f')->addOrderBy('f.id','desc')->innerJoin('f.block_id','Entity\Block')->innerJoin('Entity\Block.apt_id','Entity\Apartment')->where('f.block_id=:block_id')->setParameter('block_id',$data)->getQuery()->getArrayResult();
		}else{
			$flats = $qb->select('f','Entity\Block','Entity\Apartment')->from('Entity\Flat','f')->addOrderBy('f.id','desc')->innerJoin('f.block_id','Entity\Block')->innerJoin('Entity\Block.apt_id','Entity\Apartment')->getQuery()->getArrayResult();
		}
		echo json_encode($flats);
		die();
	}
	
	public function listsz(){	
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$flats = $qb->select('f','Entity\Block','Entity\Apartment')->from('Entity\Flat','f')->innerJoin('f.block_id','Entity\Block')->innerJoin('Entity\Block.apt_id','Entity\Apartment')->where('f.status=:status')->setParameter('status',1)->getQuery()->getArrayResult();
		echo json_encode($flats);
		die();
	}
	
	public function add(){
		
	}
	public function store(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$flatId      = $data->id;
		$aptId 	     = $data->apartment;
	    $blockId 	 = $data->block;
		$name 	     = $data->name;
		$status      = 1; //$data->status;
		
		$this->_em = $this->doctrine->em;
		$apartment = $this->_em->getRepository('Entity\Apartment')->find($aptId);
		
		if($blockId)
		$block = $this->_em->getRepository('Entity\Block')->find($blockId);
		
		
		
		if($flatId){
			$flat = $this->_em->find('Entity\Flat',$flatId);
			$flat->setName($name);
			$flat->setBlockId($block);
			$this->_em->persist($flat);
			$this->_em->flush();
		}else{
			$pos = strpos($name,',');
			if($pos!==false){
				foreach(explode(',',$name) as $n){
				$flat = new Entity\Flat();
				$flat->setName(trim($n));
				$flat->setBlockId($block);
				$this->_em->persist($flat);
				$this->_em->flush();
				}
			}else{
				$flat = new Entity\Flat();
				$flat->setName($name);
				$flat->setBlockId($block);
				$this->_em->persist($flat);
				$this->_em->flush();
			}
		
			
		}
				
		die();
	}
	public function update($id){
	
			
	}
	public function edit(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$id = $data;
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$flat = $qb->select('f','Entity\Block','Entity\Apartment')->from('Entity\Flat','f')->innerJoin('f.block_id','Entity\Block')->innerJoin('Entity\Block.apt_id','Entity\Apartment')->where('f.id=:id')->setParameter('id',$id)->getQuery()->getArrayResult();
		
		if(sizeof($flat))
		echo json_encode($flat[0]);
		die();	
		
	}
	public function status(){
		
	    $input = file_get_contents("php://input");
		$data = json_decode($input);
		$flatId = $data;
		$this->_em = $this->doctrine->em;
	
		if((int)$flatId){
			$flat = $this->_em->find('Entity\Flat',(int)$flatId);
			$flat->setStatus(!$flat->getStatus());
			$this->_em->persist($flat);
			$this->_em->flush(); die();
		}
		
		die();	
		
	}
}