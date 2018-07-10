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
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		if($data){
			$flats = $qb->select('f','Entity\Block','Entity\Apartment')->from('Entity\Flat','f')->innerJoin('f.block_id','Entity\Block')->innerJoin('Entity\Block.apt_id','Entity\Apartment')->where('f.block_id=:block_id and f.status=:status')->setParameter('block_id',$data)->setParameter('status',1)->getQuery()->getArrayResult();
			}else{
		$flats = $qb->select('f','Entity\Block','Entity\Apartment')->from('Entity\Flat','f')->innerJoin('f.block_id','Entity\Block')->innerJoin('Entity\Block.apt_id','Entity\Apartment')->where('f.status=:status')->setParameter('status',1)->getQuery()->getArrayResult();
				}
		echo json_encode($flats);
		die();
	}
	
	public function add(){
		
	}
	public function store(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$flatId =0;
		if(property_exists($data,'id'))
		$flatId      = $data->id;
		$aptId 	     = $data->apartment;
	    $blockId 	 = $data->block;
		$name 	     = $data->name;
		
		$unitType='';		$area=''; $facing='';$intercom=''; $eusn=''; $sale=''; $roccupy='';
		if(property_exists($data,'unitType'))
		$unitType 	 = $data->unitType;
		if(property_exists($data,'area'))
		$area 	     = $data->area;
		if(property_exists($data,'facing'))
		$facing 	 = $data->facing;
		if(property_exists($data,'intercom'))
		$intercom 	 = $data->intercom;
		if(property_exists($data,'eusn'))
		$eusn 	     = $data->eusn;
		if(property_exists($data,'sale'))
		$sale 	     = $data->sale;
		if(property_exists($data,'salePrice'))
		$salePrice 	     = $data->salePrice;
		if(property_exists($data,'rentPrice'))
		$rentPrice 	     = $data->rentPrice;
		if(property_exists($data,'nofpplStay'))
		$nofpplStay 	     = $data->nofpplStay;
		if(property_exists($data,'cntOneName'))
		$cntOneName 	     = $data->cntOneName;
		if(property_exists($data,'cntOneMobile'))
		$cntOneMobile 	     = $data->cntOneMobile;
		if(property_exists($data,'cntTwoName'))
		$cntTwoName 	     = $data->cntTwoName;
		if(property_exists($data,'cntTwoMobile'))
		$cntTwoMobile 	     = $data->cntTwoMobile;
		
		
		if(property_exists($data,'roccupy'))
		$roccupy 	 = $data->roccupy;
		
		$status      = 1; //$data->status;
		
		$this->_em = $this->doctrine->em;
		$apartment = $this->_em->getRepository('Entity\Apartment')->find($aptId);
		
		if($blockId)
		$block = $this->_em->getRepository('Entity\Block')->find($blockId);
		
		
		
		if($flatId){
			$flat = $this->_em->find('Entity\Flat',$flatId);
			$flat->setName($name);
			$flat->setBhk($unitType);
			$flat->setEusn($eusn);
			$flat->setIntercom($intercom);
			$flat->setSize($area);
			$flat->setFacing($facing);
			$flat->setSalePrice($salePrice);
			$flat->setRentPrice($rentPrice);
			$flat->setNofPplStay($nofpplStay);
			$flat->setCntOneName($cntOneName);
			$flat->setCntOneMobile($cntOneMobile);
			$flat->setCntTwoName($cntTwoName) ;
			$flat->setCntTwoMobile($cntTwoMobile);
			
			$flat->setRoccupy($roccupy);
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
	
	public function customers(){
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$customers = array();
			if($data){
			
			$cust = $qb->select('c.id as customerId','c.firstname as firstname','c.lastname as lastname')->from('Entity\Customer','c')->innerJoin('c.flat_id','Entity\Flat')->where('c.flat_id=:flatId and c.status=:status')->setParameter('flatId',$data)->setParameter('status',1)->getQuery()->getArrayResult();
			
				foreach($cust as $co){
					$c = array();
					$c['customerId'] = $co['customerId'];
					$c['name'] = $co['firstname'].' '.$co['lastname'];
					$customers[] = $c;
				}
			}else{
				$cust = $qb->select('c.id as customerId','c.firstname as firstname','c.lastname as lastname')->from('Entity\Customer','c')->innerJoin('c.flat_id','Entity\Flat')->where('c.status=:status')->setParameter('status',1)->getQuery()->getArrayResult();
			
				foreach($cust as $co){
					$c = array();
					$c['customerId'] = $co['customerId'];
					$c['name'] = $co['firstname'].' '.$co['lastname'];
					$customers[] = $c;
				}
				$customers = array();
			}
		echo json_encode($customers);
		die();
	}
}