<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Ams extends REST_Controller {
   
   function __construct()
   { 
    
		parent::__construct();	
	
        $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->methods['user_options']['limit'] = 50;
		$this->methods['apartment_get']['limit'] = '10';
		$this->methods['itemtype_get']['limit'] = '10';
 	
		
    }

	
	public function blocks_put(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$apartmentId 		= $data->apartmentId;	
		if($apartmentId){
			$blocks = $qb->select('b')->from('Entity\Block','b')->innerJoin('b.apt_id','Entity\Apartment')->where('b.apt_id=:aptId')->setParameter('aptId',$apartmentId)->getQuery()->getArrayResult();
			$this->response($blocks, REST_Controller::HTTP_OK); 
		}else{
			$blocks = $qb->select('b')->from('Entity\Block','b')->getQuery()->getArrayResult();
			$this->response($blocks, REST_Controller::HTTP_OK); 
			
		}
		
	}

	public function flats_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$blockId 		= $data->blockId;
	      
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		if($blockId){
			$flats = $qb->select('f')->from('Entity\Flat','f')->innerJoin('f.block_id','Entity\Block')->where('f.block_id=:blockId')->setParameter('blockId',$blockId)->getQuery()->getArrayResult();
			$this->response($flats, REST_Controller::HTTP_OK); 
		}else{
			$flats = $qb->select('f')->from('Entity\Flat','f')->getQuery()->getArrayResult();
			$this->response($flats, REST_Controller::HTTP_OK); 
			
		}
		
	}

	public function authentication_post(){
		
		$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$mobile 		= $data->mobile;
		$password 	= md5(trim($data->password));
		
	 	//$cust = $this->_em->getRepository('Entity\Customer')->findOneBy(array('email'=>$email,'password'=>$password));
	 
	    $facultys = $qb->select('f')->from('Entity\Faculty','f')->where('f.mobile =:mobile and f.password =:pwd and f.status =:status')->setParameter('mobile',$mobile)->setParameter('pwd',$password)->setParameter('status',1)->getQuery()->getResult();
	
	
		if(count($facultys) && $faculty = $facultys[0]){
			$facultyId = $faculty->getId();
			$apartmentId = $faculty->getApartmentId()->getId();
			$apartment = $faculty->getApartmentId()->getName();
			$message =['message'=>'Authentication successfull' ,'id'=>$facultyId,'apartmentId'=>$apartmentId,'apartment'=>$apartment];
			$this->response($message, REST_Controller::HTTP_ACCEPTED); 
			
		}else{
			$message =[ 'message' => 'Authentication failed try again later'];
			$this->response($message, REST_Controller::HTTP_NOT_ACCEPTABLE); 
		}
	}
	
	public function fmregistration_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		
		if(!is_object($data))
		$data = new stdClass();
		
		if(property_exists($data,'familyHead'))	
		$familyHead 		= $data->familyHead;
		else
		$familyHead = 0;
		if(property_exists($data,'firstName'))	
		$fname 		= $data->firstName;
		if(property_exists($data,'lastName'))	
		$lname 		= $data->lastName;
		if(property_exists($data,'email'))	
		$email 		= $data->email;
		if(property_exists($data,'mobile'))	
		$mobile 	= $data->mobile;
		$password 	= 'abc';//$data->password;
		$userType 	= 'apartment';
		$subType 	= 'family member';
		
		$this->_em = $this->doctrine->em;
		
		
		if($familyHead){
		$fhObj = $this->_em->find('Entity\Customer',$familyHead);
		try{
			if(is_object($fhObj)){
				$cust = new Entity\Customer();
				$cust->setFirstName($fname);
				$cust->setLastName($lname);
				$cust->setEmail($email);
				$cust->setPhoneNo($mobile);
				$cust->setPassword($password);
				$cust->setUserType($userType);
				$cust->setSubType($subType);
				$cust->setApartmentId($fhObj->getApartmentId());
				$cust->setBlockId($fhObj->getBlockId());
				$cust->setFlatId($fhObj->getFlatId());
				
				$this->_em->persist($cust);
				$this->_em->flush();	
				$message =[ 'message' => 'your family member is created, will you please say to login.' ];
				$this->set_response($message, REST_Controller::HTTP_CREATED);
			
			}else{
				$message =[ 'message' =>' somthing mistaken, please try again........ '];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
			}
		}catch(Exception $e){
			
			$message =[ 'message' =>$e->getMessage()];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
		}
		}else{
			$message =[ 'message' =>' payload format mistaken..'];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
		}
	
	}
	
	public function familymembers_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		
		if(!is_object($data))
		$data = new stdClass();
		
		if(property_exists($data,'ownerId'))
			$onwerId = $data->ownerId;
		if(property_exists($data,'tenantId'))
			$tenantId = $data->tenantId;
		if(property_exists($data,'flatId'))
			$flatId = $data->flatId;
		 
		 
		 
		$this->_em  = $this->doctrine->em; 
		$qb = $this->_em->createQueryBuilder();
	
		if(isset($flatId)){
			
			
		$membersObj = $qb->select('m')->from('Entity\Customer','m')->innerJoin('m.flat_id','Entity\Flat')->where('Entity\Flat.id=:flatId')->setParameters(array('flatId'=>$flatId))->getQuery()->getResult();
		
		$members = array();
		
		foreach($membersObj as $m){
			$member = array();
			$member['customerId'] 	= $m->getId();
			$member['firstname'] 	= $m->getFirstName();
			$member['lastname'] 	= $m->getLastName();
			$member['email'] 		= $m->getEmail();
			$member['mobile'] 		= $m->getPhoneNo();
			$member['status'] 		= $m->getStatus();
			$member['subType'] 		= $m->getsubType();			
			$members['members'][] = $member; 
		}
		$this->set_response($members,REST_Controller::HTTP_OK);
		}else{
			$message = ['message'=>'something went wrong, please try again later '];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	
	public function fmstatus_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		
		if(!is_object($data))
		$data = new stdClass();
		
		$reject = false;
		if(property_exists($data,'familyMember')){
			$familyMember = $data->familyMember;
		}
		if(property_exists($data,'reject')){
			$reject = $data->reject;
		}
		
		if(isset($familyMember)){
			$this->_em = $this->doctrine->em;
			if($familyMember)
			$fmObj = $this->_em->find('Entity\Customer',$familyMember);
			
			if(is_object($fmObj)){
				
				$name = $fmObj->getFirstName().' '.$fmObj->getLastName();
				if($reject){	
					$message = $name.' is sucessfully rejected from your family...';
					$fmObj->setApartmentId(NULL);
					$fmObj->setBlockId(NULL);
					$fmObj->setFlatId(NULL);
					$fmObj->setUserType(NULL);
					$fmObj->setSubType(NULL);
					
					}else{
						$fmObj->setStatus(!$fmObj->getStatus());
						if($fmObj->getStatus())
						$message = $name.' status is successfully disabled...';
						else
						 $message = $name.' status is successfully enabled...';	
					}
				$this->_em->persist($fmObj);
				$this->_em->flush();	
					
			
			
			$message = ['message'=>$message];
			$this->set_response($message,REST_Controller::HTTP_OK);
			
			}else{
				
				$message = ['message'=>' family members not exists'];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'payload mistaken, please try again later '];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
		
	}
	
	public function vehicles_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		
		$this->_em = $this->doctrine->em;
		
		if(!is_object($data))
		$data = new stdClass();
		$flatId = 0;
		if(property_exists($data,'flatId')){
			$flatId = $data->flatId;
		}
		
		if($flatId){
			$flat = $this->_em->find('Entity\Flat',$flatId);
			if(is_object($flat)){
				$vehicles = $flat->getVehicles();
				$vs = array();
				foreach($vehicles as $vv){
					$v = array();
					$v['regno'] = $vv->getRegNumber();
					$v['brand'] = $vv->getMake();
					$v['vtype'] = $vv->getVtype();
					$v['rfid'] = $vv->getRfid();
					$vs[] = $v;
				}
				
			$this->set_response($vs,REST_Controller::HTTP_OK);
			}else{
				$message = ['message'=>'payload mistaken, please try again later '];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
		
			$message = ['message'=>'payloads mistaken, please try again later '];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	
	//  VISITOR MANAGEMENT START FROM HERE 
	
	/*********************************************************/
	/*******************  VISITOR SEARCH  ********************/
	/*********************************************************/
	
	public function visitorsearch_post(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		try{
			if(!is_object($data))
			$data = new stdClass();
			$facultyId =0;
			if(property_exists($data,'facultyId') && property_exists($data,'mobile'))	{
				$this->_em = $this->doctrine->em;
				$facultyId 	= $data->facultyId;
				$mobile 	= $data->mobile;
				$faculty = $this->_em->find('Entity\Faculty',$facultyId);
				if(is_object($faculty)){
					$apartmentId = $faculty->getApartmentId()->getId();
					
					$qb = $this->_em->createQueryBuilder();

				$visitorObj = $qb->select('v','Entity\Faculty','Entity\Customer','Entity\Block','Entity\Flat')->from('Entity\Visitor','v')->innerJoin('v.block_id','Entity\Block')->innerJoin('v.flat_id','Entity\Flat')->leftJoin('v.facultyApproval','Entity\Faculty')->leftJoin('v.flatApproval','Entity\Customer')->where('v.apt_id = :apartmentId and v.mobile =:mobile and v.facultyApprovalStatus =:fstatus')->setParameter('fstatus','')->setParameter('apartmentId',$apartmentId)->setParameter('mobile',$mobile)->addOrderBy('v.vtype','asc')->getQuery()->getArrayResult();
				$visitors = array();
			
				$flats =  array();
				foreach($visitorObj as $v){
					
					//print_r($v); die();
					$visitor = array();
					$visitor['visitor_id'] 	= $v['id'];
					$visitor['name'] 		= $v['name'];
					$visitor['mobile'] 		= $v['mobile'];
					$visitor['purpose'] 	= $v['purpose'];
					$visitor['vtype'] 		= $v['vtype'];
					$visitor['vcount'] 		= $v['vcount'];
					$visitor['vehicle'] 	= explode(',', $v['vehicle']);
					
					if($v['vdate']){
						 $vd = $v['vdate']->format('y-m-d H:i:s');
						 $vdate	= (int)strtotime($vd)*1000;
					}else{
						$vdate	= '';
					}

					if($v['in_time']){
						$vt =  $v['in_time']->format('y-m-d H:i:s');
						$in_time	= (int)strtotime($vt)*1000;
					}else{
						$in_time	= '';
					}


					$visitor['date'] 		= $vdate;
					$visitor['in_time'] 	= $in_time;
					$visitor['flat'] 		= $v['block_id']['name'].'-'.$v['flat_id']['name'];
					
					if($v['vtype']=='frequent'){
						$visitor['flatApprovalStatus'] = '';
						$visitor['facultyApprovalStatus'] = '';
					}else{
						$visitor['flatApprovalStatus'] = $v['flatApprovalStatus'];	
						$visitor['facultyApprovalStatus'] = $v['facultyApprovalStatus'];
					}
					

					if(array_key_exists('flatApproval',$v)){
						$visitor['flatApproval']= $v['flatApproval']['firstname'].' '.$v['flatApproval']['lastname'];
					}else{
						$visitor['flatApproval']= '';
					}
					
					
					if(array_key_exists('facultyApproval',$v)){
						$visitor['facultyApproval'] = $v['facultyApproval']['firstname'].' '.$v['facultyApproval']['lastname'];
					}else{
						$visitor['facultyApproval'] = ''; 
					}
					$visitors['visitors'][] = $visitor;
				}

				$this->set_response($visitors, REST_Controller::HTTP_OK);			
			}else{
				$message =[ 'message' =>'payload mistaken'];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
			}
			}else{
				$message =[ 'message' =>'payload mistaken'];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
			}
		}catch(Exception $e){
				$message =[ 'message' =>$e->getMessage()];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
		}
	}
	    
	/*********************************************************/
	/*************** FLAT VISITOR REG  ********************/
	/*********************************************************/
	
	public function customervisitorregistration_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		try{
			if(!is_object($data))
			$data = new stdClass();
			$this->_em = $this->doctrine->em;
			
			if(property_exists($data, 'visitorId')){
				$visitorId = $data->visitorId;
				$visitor = $this->_em->find('Entity\Visitor',$visitorId);
				if(!is_object($visitor))
					$visitor = new Entity\Visitor();
			}else{
				$visitor = new Entity\Visitor();	
			}
			
			if(property_exists($data,'mobile'))	{
				$mobile 		= $data->mobile;
				$visitor->setMobile($mobile);
			
				$visitor->setVtype('normal');

				if(property_exists($data,'name')){
					$name 		= $data->name;
					$visitor->setName($name);
				}
				
				if(property_exists($data,'vehicle')){
					$vehicle 		= $data->vehicle;
					$visitor->setVehicle($vehicle);
				}
				
				if(property_exists($data,'image')){	
					$image 	= $data->image;
					$visitor->setImage($image);
				}
				if(property_exists($data,'vdate')){	
					$vdate 	= $data->vdate;
					$visitor->setVdate($vdate);
				}
				if(property_exists($data,'intime'))	{
					$intime 	= $data->intime;
					
				}
				if(property_exists($data,'vcount')){
					$vcount 	= $data->vcount;
					$visitor->setVcount($vcount);
				}
				if(property_exists($data,'purpose')){
					$purpose 	= $data->purpose;
					$visitor->setPurpose($purpose);
				}	
				
				$customerId =0; $fvs =0;
				if(property_exists($data,'customerId'))	{
					$customerId 	= $data->customerId;


					if($customerId)
					$customerObj = $this->_em->find('Entity\Customer',$customerId);
					if(is_object($customerObj)){
						$visitor->setCustomerId($customerObj);
						$visitor->setApartmentId($customerObj->getApartmentId());
						$visitor->setBlockId($customerObj->getBlockId());
						$visitor->setFlatId($customerObj->getFlatId());
						
						$visitor->setCustomerApprovalStatus(1);
						$visitor->setCustomerApproval($customerObj);
						$vqb = $this->_em->createQueryBuilder();
						
						if(is_object($customerObj->getFlatId())){
							$flatId = $customerObj->getFlatId()->getId();
								$fvs = $vqb->select('count(fv.id) as c')->from('Entity\Visitor','fv')->where('fv.flat_id=:flatId and fv.vtype=:vtype and fv.mobile=:mobile')->setParameters(array('flatId' =>$flatId ,'vtype'=>'frequent','mobile'=>$mobile))->getQuery()->getSingleScalarResult();
							if(!$fvs){
								$name = $visitor->getName();
								$this->_em->persist($visitor);					
								$this->_em->flush();	

								$message =[ 'message' => $name.' visitor is added successfully.' ];
								$this->set_response($message, REST_Controller::HTTP_CREATED);
							}else{
								$message =[ 'message' => $name.' is in your frequent visitors list. If you want to convert him, first remove from frequent visitors list.' ];
								$this->set_response($message, REST_Controller::HTTP_NOT_ACCEPTABLE);		
							}
						}else{
							$message =[ 'message' => ' your not staying anyone of our associate appartment.'];
							$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
						}
						
					}else{
						$message =[ 'message' => ' your not autorized person.'];
						$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
					}		
				}else{
					$message =[ 'message' => ' session out, please login again.'];
					$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
				}
			
			}else{
				$message =[ 'message' => ' core properties are missing...'];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
			}
				
		}catch(Exception $e){
			
			$message =[ 'message' =>$e->getMessage()];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
		}
		
	}
	
	/*********************************************************/
	/*************** FACULTY VISITOR REG  ********************/
	/*********************************************************/
	
	public function facultyvisitorregistration_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		try{
			if(!is_object($data))
			$data = new stdClass();
			$this->_em = $this->doctrine->em;
			
			if(property_exists($data,'mobile'))	{
				$mobile 		= $data->mobile;
				$visitor = new Entity\Visitor();
				$visitor->setMobile($mobile);
				$visitor->setVtype('normal');
				if(property_exists($data,'name')){
					$name 		= $data->name;
					$visitor->setName($name);
				}
				
				if(property_exists($data,'vehicles')){
					$vehicle = '';
					if(is_array($data->vehicles)){
						foreach ($data->vehicles as $key => $value) {
							$vehicle 	.= $value->vehicle.', ';
						}
					}else{
						$vehicle 		= $data->vehicles;	
					}
					$visitor->setVehicle($vehicle);
				}
			
				if(property_exists($data,'vcount')){
					$vcount 	= $data->vcount;
					$visitor->setVcount($vcount);
				}
				if(property_exists($data,'purpose')){
					$purpose 	= $data->purpose;
					$visitor->setPurpose($purpose);
				}	
				
			
			if(property_exists($data,'blockId')){	
				$blockId 	= $data->blockId;
				if($blockId){
					$blockObj = $this->_em->find('Entity\Block',$blockId);
					if(is_object($blockObj))
					$visitor->setBlockId($blockObj);	
				}
			}
			if(property_exists($data,'flatId')){	
				$flatId 	= $data->flatId;
				if($flatId){
					$flatObj = $this->_em->find('Entity\Flat',$flatId);
					if(is_object($flatObj))
					$visitor->setFlatId($flatObj);	
				}
			}
			
			if(property_exists($data,'facultyId')){
					$facultyId 	= $data->facultyId;
					if($facultyId)
					$facultyObj = $this->_em->find('Entity\Faculty',$facultyId);
					if(is_object($facultyObj)){
						
						$visitor->setInTime('');
						$visitor->setVdate('');
						$visitor->setFacultyId($facultyObj);
						$visitor->setFacultyApproval($facultyObj);
						$visitor->setApartmentId($facultyObj->getApartmentId());
						$visitor->setFacultyApprovalStatus(1);
					
						$this->_em->persist($visitor);
						$this->_em->flush();	
						$message =[ 'message' => 'visitor is added and approved by you.' ];
						$this->set_response($message, REST_Controller::HTTP_CREATED);
					
					}else{
						$message =[ 'message' => 'you miss used core properties are missing...' ];
						$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
						return false;
					}
				}
				
			}else{
				$message =[ 'message' => 'core properties are missing...' ];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
			}
				
		}catch(Exception $e){
			
			$message =[ 'message' =>$e->getMessage()];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
		}
	}
	
	/*********************************************************/
	/*************** FACULTY VISITOR STATUS  *****************/
	/*********************************************************/
	
	public function facultyvisitorstatus_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		try{
			if(!is_object($data))
			$data = new stdClass();
			$this->_em = $this->doctrine->em;
			$visitorId =0;
			$status = false;
			if(property_exists($data,'visitorId'))	{
				$visitorId = $data->visitorId;
			}
			if(property_exists($data, 'status')){
				$status = $data->status;
			}
			$vehicle = '';
			if(property_exists($data, 'vehicle')){
					$vehicle = $data->vehicle;
			}

			if(property_exists($data,'facultyId'))	{
				
				$facultyId = $data->facultyId;
				$faculty = $this->_em->find('Entity\Faculty',$facultyId);
				if(is_object($faculty)){
					$apartmentId = $faculty->getApartmentId()->getId();
					if($visitorId){
						$visitor = $this->_em->find('Entity\Visitor',$visitorId);
						if(is_object($visitor)){
							
							if($visitor->getVtype()=='frequent'){
								$fvisitor = new Entity\VisitorHistory();

								$fvisitor->setApartmentId($visitor->getApartmentId());
								$fvisitor->setBlockId($visitor->getBlockId());
								$fvisitor->setFlatId($visitor->getFlatId());

								$fvisitor->setCustomerId($visitor->getCustomerId());

								$fvisitor->setPurpose($visitor->getPurpose());
								$fvisitor->setVtype($visitor->getVtype());
								$fvisitor->setVcount($visitor->getVcount());
								$fvisitor->setName($visitor->getName());
								$fvisitor->setMobile($visitor->getMobile());
								//$fvisitor->setVdate($visitor->getVdate()->format('d-m-Y H:i:s'));
								$fvisitor->setCustomerApproval($visitor->getCustomerApproval());
								$fvisitor->setCustomerApprovalStatus($visitor->getCustomerApprovalStatus());
								


								$fvisitor->setInTime(date('y-m-d h:i:s'));
								if($vehicle){
									$visitor->setVehicle($vehicle);
									$fvisitor->setVehicle($vehicle);
								}
								
								$fvisitor->setFacultyApprovalStatus(1);
								$fvisitor->setFacultyApproval($faculty);


								$name = $visitor->getName();
								$msg =  $name.' successfully approved by you.';
								$this->_em->persist($visitor);
								$this->_em->persist($fvisitor);
								$this->_em->flush();	
								$message =[ 'message' => $msg];
								$this->set_response($message, REST_Controller::HTTP_OK);
		
							}else{
								$visitor->setInTime(date('y-m-d h:i:s'));
								$visitor->setFacultyApprovalStatus($status);
								$name = $visitor->getName();
								if($status==1){
									$msg =  $name.' successfully approved by you.';
								}else{
									$msg =  $name.' successfully rejected by you.';
								}
								$visitor->setFacultyApproval($faculty);
							
							
							$this->_em->persist($visitor);
							$this->_em->flush();	
							$message =[ 'message' => $msg];
							$this->set_response($message, REST_Controller::HTTP_OK);
							}
							
						}else{
							$message =[ 'message' =>'something went wrong, please try again..'];
							$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
						}
					}else{
						$message =[ 'message' =>'something went wrong, please try again..'];
						$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
					}
					
				}else{
					$message =[ 'message' =>'payload mistaken..'];
					$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
				}
				
			}else{
				$message =[ 'message' =>'your not autorized person..'];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
			}
			
		}catch(Exception $e){
			$message =[ 'message' =>$e->getMessage()];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
		}
		
	}
	
	/*********************************************************/
	/*************** FLAT VISITOR STATUS  ********************/
	/*********************************************************/

	public function flatvisitorstatus_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		try{
			if(!is_object($data))
			$data = new stdClass();
			
			$this->_em = $this->doctrine->em;
			$status = false;
			$visitorId =0;
			if(property_exists($data,'visitorId'))	{
				$visitorId = $data->visitorId;
			}
			if (property_exists($data, 'status')) {
				$status = $data->status;
			}
			if(property_exists($data,'customerId'))	{
				
				$customerId = $data->customerId;
				$customer = $this->_em->find('Entity\Customer',$customerId);
				if(is_object($customer)){
					if($visitorId){
						$visitor = $this->_em->find('Entity\Visitor',(int)$visitorId);
						if(is_object($visitor)){
							$name = $visitor->getName();

							$visitor->setCustomerApprovalStatus($status);
							if($status==1){
								$msg = $name.' visitor approved successfully.';
							}else{
								$msg = $name.' visitor rejected successfully.';
							}
							$visitor->setCustomerApproval($customer);
							
							$this->_em->persist($visitor);
							$this->_em->flush();	
							$message =[ 'message' => $msg ];
							$this->set_response($message, REST_Controller::HTTP_OK);
						}else{
							$message =[ 'message' =>' visitor doesn\'t exists in out records.. '];
							$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
						}
					}else{
						$message =[ 'message' =>'visitor not selected properly please try again.'];
						$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
					}
					
				}else{
					$message =[ 'message' =>' your not autorized person.'];
					$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
				}
			}else{
				$message =[ 'message' =>' session out, please login again.'];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
			}
			
		}catch(Exception $e){
			$message =[ 'message' =>$e->getMessage()];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
		}
	}
	
	/*********************************************************/
	/******* FREQUENT VISITORS REG  ************/
	/*********************************************************/
	
	public function frequentvisitorregistration_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		try{
			if(!is_object($data))
			$data = new stdClass();
			
			$this->_em = $this->doctrine->em;
			
			$qb = $this->_em->createQueryBuilder();
			$visitorId=0;
			if(property_exists($data, 'visitorId')){
				$visitorId = $data->visitorId;
				$visitor = $this->_em->find('Entity\Visitor',$visitorId);
				if(!is_object($visitor))
					$visitor = new Entity\Visitor();
			}else{
				$visitor = new Entity\Visitor();	
			}
			if(property_exists($data,'mobile'))	{
				$mobile 		= $data->mobile;						
				$visitor->setMobile($mobile);
				$visitor->setVtype('frequent');
					
				if(property_exists($data,'name')){
					$name 		= $data->name;
					$visitor->setName($name);
				}
					
				if(property_exists($data,'image')){	
					$image 	= $data->image;
					$visitor->setImage($image);
				}

				if(property_exists($data,'vehicle')){	
					$vehicle 	= $data->vehicle;
					$visitor->setVehicle($vehicle);
				}		
					
				if(property_exists($data,'customerId'))	{
					$visitor->setVtype('frequent');
					$customerId 	= $data->customerId;
					if($customerId)
					$customerObj = $this->_em->find('Entity\Customer',$customerId);
					if(is_object($customerObj)){

						$fvc=0;
						$flatId = is_object($customerObj->getFlatId())?$customerObj->getFlatId()->getId():0; 
						if ($flatId) {
							$fvc = $qb->select('count(vf) as c')->from('Entity\Visitor','vf')->where('vf.flat_id=:flatId and vf.mobile=:mobile and vf.vtype=:vtype')->setParameters(array('flatId' =>$flatId ,'mobile'=>$mobile,'vtype'=>'frequent'))->getQuery()->getSingleScalarResult();

							if(!$fvc || $visitorId){
								$visitor->setCustomerId($customerObj);
								$visitor->setApartmentId($customerObj->getApartmentId());
								$visitor->setBlockId($customerObj->getBlockId());
								$visitor->setFlatId($customerObj->getFlatId());
								$visitor->setCustomerApproval($customerObj);
								$visitor->setCustomerApprovalStatus(1);

								$this->_em->persist($visitor);
								$this->_em->flush();
								if($visitorId){
									$message =[ 'message' => 'frequent visitor updated successfully.' ];
									$this->set_response($message, REST_Controller::HTTP_OK);
								}
								else{
									$message =[ 'message' => 'frequent visitor added successfully.' ];
									$this->set_response($message, REST_Controller::HTTP_CREATED);
								}	
							}else{
								$message =[ 'message' => 'your frequent visitor already exists.' ];
								$this->set_response($message, REST_Controller::HTTP_CREATED);
							}
						}else{
							$message =[ 'message' => 'your not staying anyone of our associate apartments .' ];
							$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
						}
						
					}else{
							$message =[ 'message' => 'your known user. please register in our application.' ];
							$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
					}
					
				}else{
					$msg =" core propety missing.";
					$message =[ 'message' => $msg ];
					$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
				}
			}else{
				$message =[ 'message' => 'payload mistaken....'];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
			}
				
		}catch(Exception $e){
			
			$message =[ 'message' =>$e->getMessage()];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
		}
	}
	
	/*********************************************************/
	/**************** VISITOR VS FREQUENT ********************/
	/*********************************************************/
	
	
	public function visitorvsfrequent_post(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		try{
			if(!is_object($data))
			$data = new stdClass();
			$this->_em = $this->doctrine->em;
			
			if(property_exists($data,'visitorId'))	{
				$visitorId 		= $data->visitorId;
				if($visitorId){
					$visitor = $this->_em->find('Entity\Visitor',$visitorId);
					if(!is_object($visitor)){
						$message =[ 'message' => 'payload mistaken....'];
						$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
					}
				}else{
					$message =[ 'message' => 'payload mistaken....'];
					$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
				}
				
			
			if(property_exists($data,'customerId'))	{
				$customerId 	= $data->customerId;
				if($customerId)
				$customerObj = $this->_em->find('Entity\Customer',$customerId);
				if(is_object($customerObj)){
					$flat = $customerObj->getFlatId();
					$flat->addFreqVisitor($visitor);
				}
			}
			
				$this->_em->persist($visitor);
					
				$this->_em->flush();	
				$message =[ 'message' => 'visitor is added as frequent....  ' ];
				$this->set_response($message, REST_Controller::HTTP_OK);
				
			}else{
				$message =[ 'message' => 'payload mistaken....'];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
			}
				
		}catch(Exception $e){
			
			$message =[ 'message' =>$e->getMessage()];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
		}
	}
	
	/*********************************************************/
	/******* APARTMENT FREQUENT VISITORS HISTORY  ************/
	/*********************************************************/

	public function apartmentfrequentvisitorlist_post(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		try{
			if(!is_object($data))
			$data = new stdClass();
			$facultyId =0;
			$this->_em = $this->doctrine->em;
			if(property_exists($data,'facultyId'))	{
				$facultyId 	= $data->facultyId;
				$faculty = $this->_em->find('Entity\Faculty',$facultyId);
				if(is_object($faculty)){
					$apartmentId = $faculty->getApartmentId()->getId();
					
					$qb = $this->_em->createQueryBuilder();
				$visitors = array();
				$fvs = $qb->select('fv','Entity\Flat','Entity\Block')->from('Entity\Visitor','fv')->innerJoin('fv.flat_id','Entity\Flat')->innerJoin('fv.block_id','Entity\Block')->where('fv.apt_id = :apartmentId and fv.vtype=:vtype')->setParameter('apartmentId',$apartmentId)->setParameter('vtype','frequent')->getQuery()->getArrayResult();
					
					foreach($fvs as $v){
		
					$visitor = array();
					$visitor['visitor_id'] 	= $v['id'];
					$visitor['name'] 		= $v['name'];
					$visitor['mobile'] 		= $v['mobile'];
					$visitor['flat'] 		= $v['flat_id']['name'].'-'.$v['block_id']['name'];
					$visitors['visitors'][] = $visitor;
				}

				$this->set_response($visitors, REST_Controller::HTTP_OK);			
			}else{
				$message =[ 'message' =>'payload mistaken'];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
			}
			}else{
				$message =[ 'message' =>'payload mistaken'];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
			}
		}catch(Exception $e){
				$message =[ 'message' =>$e->getMessage()];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
		}	
	}

	/*********************************************************/
	/*************** FLAT FREQUENT VISITORS ******************/
	/*********************************************************/

	public function flatfrequentvisitorlist_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		try{
			if(!is_object($data))
			$data = new stdClass();
			$flatId =0;
			if(property_exists($data,'flatId'))	{
				$flatId = $data->flatId;

					$this->_em = $this->doctrine->em;
					$qb = $this->_em->createQueryBuilder();
				$visitors = array();
				$fvs = $qb->select('fv','Entity\Flat','Entity\Block')->from('Entity\Visitor','fv')->innerJoin('fv.flat_id','Entity\Flat')->innerJoin('fv.block_id','Entity\Block')->where('fv.flat_id = :flatId and fv.vtype=:vtype')->setParameter('flatId',$flatId)->setParameter('vtype','frequent')->getQuery()->getArrayResult();
					
					foreach($fvs as $v){
		
					$visitor = array();
					$visitor['visitor_id'] 	= $v['id'];
					$visitor['name'] 		= $v['name'];
					$visitor['mobile'] 		= $v['mobile'];
					$visitor['vehicle'] 	= explode(',', $v['vehicle']);
					$visitor['setVtype'] 	= $v['vtype'];	
					$visitor['flat'] 		= $v['flat_id']['name'].'-'.$v['block_id']['name'];
					$visitors['visitors'][] = $visitor;
				}

				$this->set_response($visitors, REST_Controller::HTTP_OK);			
			}else{
				$message =[ 'message' =>'payload mistaken'];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
			}
		}catch(Exception $e){
				$message =[ 'message' =>$e->getMessage()];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
		}
	}
	
	/*********************************************************/
	/******************* FLAT VISITORS ***********************/
	/*********************************************************/

	public function flatvisitors_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		try{
			if(!is_object($data))
			$data = new stdClass();
			$flatId =0;
			if(property_exists($data,'flatId'))	{
				$flatId = $data->flatId;

					$this->_em = $this->doctrine->em;
					$qb = $this->_em->createQueryBuilder();
					$fqb = $this->_em->createQueryBuilder('f');

				$visitorObj = $qb->select('v','Entity\Faculty','Entity\Customer','Entity\Flat','Entity\Block')->from('Entity\Visitor','v')->innerJoin('v.flat_id','Entity\Flat')->innerJoin('v.block_id','Entity\Block')->leftJoin('v.facultyApproval','Entity\Faculty')->leftJoin('v.flatApproval','Entity\Customer')->where('v.flat_id = :flatId and v.facultyApprovalStatus =:fstatus and v.vtype=:vtype')->setParameter('fstatus',0)->setParameter('vtype','normal')->setParameter('flatId',$flatId)->getQuery()->getArrayResult();
				$visitors = array();
				foreach($visitorObj as $v){
					
				//	print_r($v);
					$visitor = array();
					$visitor['visitor_id'] 	= $v['id'];
					$visitor['name'] 		= $v['name'];
					$visitor['mobile'] 		= $v['mobile'];
					$visitor['purpose'] 	= $v['purpose'];
					$visitor['vcount'] 		= $v['vcount'];
					$visitor['vehicle'] 	= explode(',', $v['vehicle']);
					$visitor['setVtype'] 	= $v['vtype'];
					$visitor['date'] 		= $v['vdate'];
					$visitor['in_time'] 	= $v['in_time'];
					$visitor['flat'] 		= $v['flat_id']['name'].'-'.$v['block_id']['name'];
					
					$visitor['flatApprovalStatus'] = $v['flatApprovalStatus'];
					if(array_key_exists('flatApproval',$v)){
					$visitor['flatApproval'] = $v['flatApproval']['firstname'].' '.$v['flatApproval']['lastname'];
					}else{
					$visitor['flatApproval'] = '';
					}
									
					$visitor['facultyApprovalStatus'] = $v['facultyApprovalStatus'];
					if(array_key_exists('facultyApproval',$v)){
					$visitor['facultyApproval'] = $v['facultyApproval']['firstname'].' '.$v['facultyApproval']['lastname'];
					}else{
					$visitor['facultyApproval'] = ''; 
					}
					
					$visitors['visitors'][] = $visitor;
				}

				$fvisitorObj = $fqb->select('v','Entity\Faculty','Entity\Customer','Entity\Flat','Entity\Block')->from('Entity\VisitorHistory','v')->innerJoin('v.flat_id','Entity\Flat')->innerJoin('v.block_id','Entity\Block')->leftJoin('v.facultyApproval','Entity\Faculty')->leftJoin('v.flatApproval','Entity\Customer')->where('v.flat_id = :flatId and v.facultyApprovalStatus =:fstatus and v.vtype=:vtype')->setParameter('fstatus',0)->setParameter('vtype','frequent')->setParameter('flatId',$flatId)->getQuery()->getArrayResult();
				foreach($fvisitorObj as $v){
					
				//	print_r($v);
					$visitor = array();
					$visitor['fvisitor_id'] 	= $v['id'];
					$visitor['name'] 		= $v['name'];
					$visitor['mobile'] 		= $v['mobile'];
					$visitor['purpose'] 	= $v['purpose'];
					$visitor['vcount'] 		= $v['vcount'];
					$visitor['vehicle'] 	= explode(',', $v['vehicle']);
					$visitor['setVtype'] 	= $v['vtype'];
					$visitor['date'] 		= $v['vdate'];
					$visitor['in_time'] 	= $v['in_time'];
					$visitor['flat'] 		= $v['flat_id']['name'].'-'.$v['block_id']['name'];
					
					$visitor['flatApprovalStatus'] = $v['flatApprovalStatus'];
					if(array_key_exists('flatApproval',$v)){
					$visitor['flatApproval'] = $v['flatApproval']['firstname'].' '.$v['flatApproval']['lastname'];
					}else{
					$visitor['flatApproval'] = '';
					}
									
					$visitor['facultyApprovalStatus'] = $v['facultyApprovalStatus'];
					if(array_key_exists('facultyApproval',$v)){
					$visitor['facultyApproval'] = $v['facultyApproval']['firstname'].' '.$v['facultyApproval']['lastname'];
					}else{
					$visitor['facultyApproval'] = ''; 
					}
					
					$visitors['visitors'][] = $visitor;
				}

				$this->set_response($visitors, REST_Controller::HTTP_OK);			
			}else{
				$message =[ 'message' =>'payload mistaken'];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
			}
		}catch(Exception $e){
				$message =[ 'message' =>$e->getMessage()];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
		}
	}

	/*********************************************************/
	/**************** FLAT UNKNOWN VISITORS ******************/
	/*********************************************************/

	public function flatunknownvisitors_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		try{
			if(!is_object($data))
			$data = new stdClass();
			$flatId =0;
			if(property_exists($data,'flatId'))	{
				$flatId = $data->flatId;

				$this->_em = $this->doctrine->em;
				$qb = $this->_em->createQueryBuilder();

				$visitorObj = $qb->select('v','Entity\Faculty','Entity\Customer','Entity\Flat','Entity\Block')->from('Entity\Visitor','v')->innerJoin('v.flat_id','Entity\Flat')->innerJoin('v.block_id','Entity\Block')->leftJoin('v.facultyApproval','Entity\Faculty')->leftJoin('v.flatApproval','Entity\Customer')->where('v.flat_id = :flatId and v.facultyApprovalStatus =:fstatus and v.flatApprovalStatus =:flatStatus and v.vtype="vtype')->setParameter('vtype','normal')->setParameter('fstatus',1)->setParameter('flatStatus','')->setParameter('flatId',$flatId)->getQuery()->getArrayResult();
				$visitors = array();
				foreach($visitorObj as $v){
					
				//	print_r($v);
					$visitor = array();
					$visitor['visitor_id'] 	= $v['id'];
					$visitor['name'] 		= $v['name'];
					$visitor['mobile'] 		= $v['v_id']['mobile'];
					$visitor['purpose'] 	= $v['purpose'];
					$visitor['vcount'] 		= $v['vcount'];
					$visitor['vehicle'] 	= explode(',', $v['vehicle']);
					$visitor['date'] 		= $v['vdate'];
					$visitor['in_time'] 	= $v['in_time'];
					$visitor['flat'] 		= $v['flat_id']['name'].'-'.$v['block_id']['name'];
					$visitor['flatApprovalStatus'] = $v['flatApprovalStatus'];
					if(array_key_exists('flatApproval',$v)){
						$visitor['flatApproval'] = $v['flatApproval']['firstname'].' '.$v['flatApproval']['lastname'];
					}else{
						$visitor['flatApproval'] = '';
					}
					
					$visitor['facultyApprovalStatus'] = $v['facultyApprovalStatus'];
					if(array_key_exists('facultyApproval',$v)){
						$visitor['facultyApproval'] = $v['facultyApproval']['firstname'].' '.$v['facultyApproval']['lastname'];
					}else{
						$visitor['facultyApproval'] = ''; 
					}
					
					$visitors['visitors'][] = $visitor;
				}

				$this->set_response($visitors, REST_Controller::HTTP_OK);			
			}else{
				$message =[ 'message' =>'payload mistaken'];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
			}
		}catch(Exception $e){
				$message =[ 'message' =>$e->getMessage()];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
		}
	}

	/*********************************************************/
	/*************** FLAT VISITORS HISTORY  ******************/
	/*********************************************************/
	
	public function flatvisitorhistory_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		try{
			if(!is_object($data))
			$data = new stdClass();
			$flatId =0;
			if(property_exists($data,'flatId'))	{
				$flatId = $data->flatId;

					$this->_em = $this->doctrine->em;
					$qb = $this->_em->createQueryBuilder('n');
					$fqb = $this->_em->createQueryBuilder('f');

				$visitorObj = $qb->select('v','Entity\Faculty','Entity\Customer')->from('Entity\Visitor','v')->leftJoin('v.facultyApproval','Entity\Faculty')->leftJoin('v.flatApproval','Entity\Customer')->where('v.flat_id = :flatId and v.facultyApprovalStatus !=0 and v.vtype=:vtype')->setParameter('vtype','normal')->setParameter('flatId',$flatId)->getQuery()->getArrayResult();
				$visitors = array();
				foreach($visitorObj as $v){
					
					$visitor = array();
					$visitor['visitor_id'] 	= $v['id'];
					$visitor['name']		= $v['name'];
					$visitor['mobile'] 		= $v['mobile'];
					$visitor['purpose'] 	= $v['purpose'];
					$visitor['vcount'] 		= $v['vcount'];
					$visitor['vehicle'] 	= explode(',', $v['vehicle']);

					$visitor['date'] 		= $v['vdate'];
					
					$visitor['in_time'] 	= strtotime($v['in_time']->format('d-m-Y H:i:s'))*1000;
					$visitor['flatApprovalStatus'] = $v['flatApprovalStatus'];
					if(array_key_exists('flatApproval',$v)){
						$visitor['flatApproval'] = $v['flatApproval']['firstname'].' '.$v['flatApproval']['lastname'];
					}else{
						$visitor['flatApproval'] = '';
					}
					
					$visitor['facultyApprovalStatus'] = $v['facultyApprovalStatus'];
					if(array_key_exists('facultyApproval',$v)){
						$visitor['facultyApproval'] = $v['facultyApproval']['firstname'].' '.$v['facultyApproval']['lastname'];
					}else{
						$visitor['facultyApproval'] = ''; 
					}
					
					$visitors['visitors'][] = $visitor;
				}

				$fvisitorObj = $fqb->select('v','Entity\Faculty','Entity\Customer','Entity\Flat','Entity\Block')->from('Entity\VisitorHistory','v')->innerJoin('v.flat_id','Entity\Flat')->innerJoin('v.block_id','Entity\Block')->leftJoin('v.facultyApproval','Entity\Faculty')->leftJoin('v.flatApproval','Entity\Customer')->where('v.flat_id = :flatId and v.facultyApprovalStatus =:fstatus and v.vtype=:vtype')->setParameter('fstatus',1)->setParameter('vtype','frequent')->setParameter('flatId',$flatId)->getQuery()->getArrayResult();
				foreach($fvisitorObj as $v){
					
				//	print_r($v);
					$visitor = array();
					$visitor['fvisitor_id'] 	= $v['id'];
					$visitor['name'] 		= $v['name'];
					$visitor['mobile'] 		= $v['mobile'];
					$visitor['purpose'] 	= $v['purpose'];
					$visitor['vcount'] 		= $v['vcount'];
					$visitor['vehicle'] 	= explode(',', $v['vehicle']);
					$visitor['setVtype'] 	= $v['vtype'];
					$visitor['date'] 		= $v['vdate'];
					$visitor['in_time'] 	= strtotime($v['in_time']->format('d-m-Y H:i:s'))*1000;
					$visitor['flat'] 		= $v['flat_id']['name'].'-'.$v['block_id']['name'];
					
					$visitor['flatApprovalStatus'] = $v['flatApprovalStatus'];
					if(array_key_exists('flatApproval',$v)){
					$visitor['flatApproval'] = $v['flatApproval']['firstname'].' '.$v['flatApproval']['lastname'];
					}else{
					$visitor['flatApproval'] = '';
					}
									
					$visitor['facultyApprovalStatus'] = $v['facultyApprovalStatus'];
					if(array_key_exists('facultyApproval',$v)){
					$visitor['facultyApproval'] = $v['facultyApproval']['firstname'].' '.$v['facultyApproval']['lastname'];
					}else{
					$visitor['facultyApproval'] = ''; 
					}
					
					$visitors['visitors'][] = $visitor;
				}

				$this->set_response($visitors, REST_Controller::HTTP_OK);			
			}else{
				$message =[ 'message' =>'payload mistaken'];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
			}
		}catch(Exception $e){
				$message =[ 'message' =>$e->getMessage()];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
		}
	}

	/*********************************************************/
	/****************** APARTMENT VISITORS *******************/
	/*********************************************************/

	
	public function apartmentvisitors_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		try{
			if(!is_object($data))
			$data = new stdClass();
			$facultyId =0;
			if(property_exists($data,'facultyId'))	{
				$this->_em = $this->doctrine->em;
				$facultyId = $data->facultyId;
				$faculty = $this->_em->find('Entity\Faculty',$facultyId);
				if(is_object($faculty)){
					$apartmentId = $faculty->getApartmentId()->getId();

					$qb = $this->_em->createQueryBuilder();

				$visitorObj = $qb->select('v','Entity\Faculty','Entity\Customer','Entity\Block','Entity\Flat')->from('Entity\Visitor','v')->innerJoin('v.block_id','Entity\Block')->innerJoin('v.flat_id','Entity\Flat')->leftJoin('v.facultyApproval','Entity\Faculty')->leftJoin('v.flatApproval','Entity\Customer')->where('v.apt_id = :apartmentId and v.facultyApprovalStatus !=0 and v.vtype=:vtype')->setParameter('vtype','normal')->setParameter('apartmentId',$apartmentId)->getQuery()->getArrayResult();
				$visitors = array();
				foreach($visitorObj as $v){
					
				//	print_r($v);
					$visitor = array();
					$visitor['visitor_id'] 	= $v['id'];
					$visitor['name'] 		= $v['name'];
					$visitor['mobile'] 		= $v['mobile'];
					$visitor['purpose'] 	= $v['purpose'];
					$visitor['vcount'] 		= $v['vcount'];
					$visitor['vehicle'] 	= explode(',', $v['vehicle']);
					$visitor['date'] 		= $v['vdate'];
					$visitor['in_time'] 	= $v['in_time'];
					$visitor['flat'] 		= $v['block_id']['name'].'-'.$v['flat_id']['name'];
					
					$visitor['flatApprovalStatus'] = $v['flatApprovalStatus'];
					if(array_key_exists('flatApproval',$v)){
						$visitor['flatApproval'] = $v['flatApproval']['firstname'].' '.$v['flatApproval']['lastname'];
					}else{
						$visitor['flatApproval'] = '';
					}
					
					$visitor['facultyApprovalStatus'] = $v['facultyApprovalStatus'];
					
					if(array_key_exists('facultyApproval',$v)){
						$visitor['facultyApproval'] = $v['facultyApproval']['firstname'].' '.$v['facultyApproval']['lastname'];
					}else{
						$visitor['facultyApproval'] = ''; 
					}
					
					$visitors['visitors'][] = $visitor;
				}

				$this->set_response($visitors, REST_Controller::HTTP_OK);			
			}else{
				$message =[ 'message' =>'payload mistaken'];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
			}
			}else{
				$message =[ 'message' =>'payload mistaken'];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
			}
		}catch(Exception $e){
				$message =[ 'message' =>$e->getMessage()];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
		}
	}
	/*********************************************************/
	/*********** APARTMENT VISITORS HISTORY ******************/
	/*********************************************************/
	
	public function apartmentvisitorshistory_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		try{
			if(!is_object($data))
			$data = new stdClass();
			$facultyId =0;
			if(property_exists($data,'facultyId'))	{
				$this->_em = $this->doctrine->em;
				$facultyId = $data->facultyId;
				$faculty = $this->_em->find('Entity\Faculty',$facultyId);
				if(is_object($faculty)){
					$apartmentId = $faculty->getApartmentId()->getId();

					
					$qb = $this->_em->createQueryBuilder('n');
					$fqb = $this->_em->createQueryBuilder('f');

				$visitorObj = $qb->select('av','Entity\Faculty','Entity\Customer','Entity\Block','Entity\Flat')->from('Entity\Visitor','av')->innerJoin('av.block_id','Entity\Block')->innerJoin('av.flat_id','Entity\Flat')->leftJoin('av.facultyApproval','Entity\Faculty')->leftJoin('av.flatApproval','Entity\Customer')->where('av.apt_id = :apartmentId and av.facultyApprovalStatus =:fstatus and av.vtype=:vtype')->setParameter('vtype','normal')->setParameter('fstatus',1)->setParameter('apartmentId',$apartmentId)->getQuery()->getArrayResult();
				$visitors = array();
				foreach($visitorObj as $v){
					$visitor = array();
					$visitor['visitor_id'] 	= $v['id'];
					$visitor['name'] 		= $v['name'];
					$visitor['mobile'] 		= $v['mobile'];
					$visitor['purpose'] 	= $v['purpose'];
					$visitor['vcount'] 		= $v['vcount'];
					$visitor['vehicle'] 	= explode(',', $v['vehicle']);
					$visitor['date'] 		= $v['vdate'];
					$visitor['in_time'] 	= strtotime($v['in_time']->format('d-m-Y H:i:s'))*1000;
					$visitor['flat'] 		= $v['block_id']['name'].'-'.$v['flat_id']['name'];
					
					$visitor['flatApprovalStatus'] = $v['flatApprovalStatus'];
					if(array_key_exists('flatApproval',$v)){
						$visitor['flatApproval'] = $v['flatApproval']['firstname'].' '.$v['flatApproval']['lastname'];
					}else{
						$visitor['flatApproval'] = '';
					}
					
					$visitor['facultyApprovalStatus'] = $v['facultyApprovalStatus'];
					if(array_key_exists('facultyApproval',$v)){
						$visitor['facultyApproval'] = $v['facultyApproval']['firstname'].' '.$v['facultyApproval']['lastname'];
					}else{
						$visitor['facultyApproval'] = ''; 
					}
					
					$visitors['visitors'][] = $visitor;
				}

				$fvisitorObj = $fqb->select('av','Entity\Faculty','Entity\Customer','Entity\Block','Entity\Flat')->from('Entity\VisitorHistory','av')->innerJoin('av.block_id','Entity\Block')->innerJoin('av.flat_id','Entity\Flat')->leftJoin('av.facultyApproval','Entity\Faculty')->leftJoin('av.flatApproval','Entity\Customer')->where('av.apt_id = :apartmentId and av.facultyApprovalStatus =:fstatus and av.vtype=:vtype')->setParameter('vtype','frequent')->setParameter('fstatus',1)->setParameter('apartmentId',$apartmentId)->getQuery()->getArrayResult();
				foreach($fvisitorObj as $v){
					$visitor = array();
					$visitor['visitor_id'] 	= $v['id'];
					$visitor['name'] 		= $v['name'];
					$visitor['mobile'] 		= $v['mobile'];
					$visitor['purpose'] 	= $v['purpose'];
					$visitor['vcount'] 		= $v['vcount'];
					$visitor['vehicle'] 	= explode(',', $v['vehicle']);
					$visitor['date'] 		= $v['vdate'];
					$visitor['in_time'] 	= strtotime($v['in_time']->format('d-m-Y H:i:s'))*1000;
					$visitor['flat'] 		= $v['block_id']['name'].'-'.$v['flat_id']['name'];
					
					$visitor['flatApprovalStatus'] = $v['flatApprovalStatus'];
					if(array_key_exists('flatApproval',$v)){
						$visitor['flatApproval'] = $v['flatApproval']['firstname'].' '.$v['flatApproval']['lastname'];
					}else{
						$visitor['flatApproval'] = '';
					}
					
					$visitor['facultyApprovalStatus'] = $v['facultyApprovalStatus'];
					if(array_key_exists('facultyApproval',$v)){
						$visitor['facultyApproval'] = $v['facultyApproval']['firstname'].' '.$v['facultyApproval']['lastname'];
					}else{
						$visitor['facultyApproval'] = ''; 
					}
					
					$visitors['visitors'][] = $visitor;
				}

				$this->set_response($visitors, REST_Controller::HTTP_OK);			
			}else{
				$message =[ 'message' =>'payload mistaken'];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
			}
			}else{
				$message =[ 'message' =>'payload mistaken'];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
			}
		}catch(Exception $e){
				$message =[ 'message' =>$e->getMessage()];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
		}
	}

	

	/*********************************************************/
	/*********** TELEPHONE DIRECTORY ***********/
	/*********************************************************/
	public function telephonedirectory_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		try{
			if(!is_object($data))
			$data = new stdClass();
			
			$this->_em = $this->doctrine->em;
			$qb = $this->_em->createQueryBuilder();
				
			$apartmentId = 0;
			$customerId =0;
			if(property_exists($data,'customerId'))	{
				$customerId = $data->customerId;
			}
			
			$facultyId =0;
			if(property_exists($data,'facultyId')){
				$facultyId = $data->facultyId;
				$faculty = $this->_em->find('Entity\Faculty',$facultyId);
				$apartmentId = $faculty->getApartmentId()->getId();
			}
			 
			if(property_exists($data,'customerId'))	{				
				$customer = $this->_em->find('Entity\Customer',$customerId);
				$apartmentId = $customer->getApartmentId()->getId();
			}

			if($apartmentId){

				$customerObj  = $qb->select('c')->from('Entity\Customer','c')->where('c.apt_id = :aptId')->setParameters(array('aptId'=>$apartmentId))->getQuery()->getResult();
					
				$customers = array();
					
				foreach($customerObj as $c){
					$cust = array();
					$cust['firstname'] = $c->getFirstName();
					$cust['lastname'] = $c->getLastName();
					$cust['email'] = $c->getEmail();
					
					if($c->getShowInTele()){
						$cust['mobile'] = $c->getPhoneNo();
						$cust['whatsapp'] = $c->getWhatsapp();
						$cust['dob'] = is_object($c->getDob())?$c->getDob()->format('d-m-Y'):'';
					}else{
						$cust['mobile'] = '';
						$cust['dob'] = '';
						$cust['whatsapp'] = '';
					}
					$cust['facebook'] = $c->getFacebook();
					$cust['apartment'] = $c->getApartmentId()->getName();
					$cust['block'] = $c->getBlockId()->getName();
					$cust['flat'] = $c->getFlatId()->getName();
					
					$customers['customers'][] = $cust;	
				}
					$this->set_response($customers, REST_Controller::HTTP_OK);			
			}else{
					$message =[ 'message' =>' paylod mistaken '];
					$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
			}
		
		}catch(Exception $e){
			$message =[ 'message' =>$e->getMessage()];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
		}			
	}
	
	public function trashvisitor_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		try{
			if(!is_object($data))
			$data = new stdClass();
			$facultyId =0;
			if(property_exists($data,'customerId') && property_exists($data,'visitorId'))	{
				$this->_em = $this->doctrine->em;
				$customerId = $data->customerId;
				$visitorId = $data->visitorId;
				
				$qb = $this->_em->createQueryBuilder();

				$visitorObj = $qb->select('v')->from('Entity\Visitor','v')->where('v.id = :visitorId and v.cust_id =:customerId and v.facultyApprovalStatus=0')->setParameter('visitorId',$visitorId)->setParameter('customerId',$customerId)->getQuery()->getResult();
				$visitors = array();
				if(sizeof($visitorObj)){
					foreach($visitorObj as $v){

						$this->_em->remove($v);
						
					}
					$this->_em->flush();
					$message = [ 'message' =>' successfully deleted '];
					$this->set_response($message, REST_Controller::HTTP_OK); 
					
				}else{
					$message =[ 'message' =>'we didn\'t find respective visitor.'];
					$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
				}
			}else{
				$message =[ 'message' =>' paylod mistaken '];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
			}
		}catch(Exception $e){
			$message =[ 'message' =>$e->getMessage()];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
		}
	}
	
	
	/*************************************************************/
	/***************** ADMIN NOTIFICATIONS ***********************/
	/*************************************************************/
	
	public function aanotificationtypes_post(){
		
		

		$input = file_get_contents("php://input");
		$data = json_decode($input);
		try{
			if(!is_object($data))
			$data = new stdClass();
			$facultyId =0;
			if(property_exists($data,'facultyId'))	{
				$this->_em = $this->doctrine->em;
				$facultyId = $data->facultyId;
				$faculty = $this->_em->find('Entity\Faculty',$facultyId);
				if(is_object($faculty)){
					$apartmentId = $faculty->getApartmentId()->getId();
					
					$qb = $this->_em->createQueryBuilder();
					$ntObj  = $qb->select('nt')->from('Entity\ApartmentAdminNType','nt')->where('nt.apt_id = :aptId')->setParameter('aptId',$apartmentId)->getQuery()->getResult();
					$ntypes = array();
					foreach($ntObj as $nt){
						$nta = array();
						$nta['id'] = $nt->getId();
						$nta['name'] = $nt->getName();
						$ntypes['ntypes'][] = $nta;
					}
					$this->set_response($ntypes, REST_Controller::HTTP_OK); 
				}else{
					$message =[ 'message' =>' something went wrong... '];
					$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
				}
			}else{
				$message =[ 'message' =>' payload mistaken... '];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
			}
		}catch(Exception $e){
			$message =[ 'message' =>$e->getMessage()];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
		}
	}
	
	public function aabulknotifications_post(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		try{
			if(!is_object($data))
			$data = new stdClass();
			$facultyId =0;
			if(property_exists($data,'facultyId'))	{
				$this->_em = $this->doctrine->em;
				$facultyId = $data->facultyId;
				$faculty = $this->_em->find('Entity\Faculty',$facultyId);
				if(is_object($faculty)){
					$apartmentId = $faculty->getApartmentId()->getId();
					
					$qb = $this->_em->createQueryBuilder();
					$notifObj  = $qb->select('an')->from('Entity\ApartmentAdminNotification','an')->where('an.apt_id = :aptId and an.ntype=:ntype')->setParameter('aptId',$apartmentId)->setParameter('ntype','bulk')->getQuery()->getResult();
					$notifications = array();
					foreach($notifObj as $nt){
						$nta = array();
						$nta['id'] = $nt->getId();
						$nta['subject'] 	= $nt->getSubject();
						$nta['message'] 	= $nt->getMessage();
						$nta['priority'] 	= $nt->getPriority();
						$nta['ndate'] 		= is_object($nt->getNdate())?$nt->getNdate()->format('d-m-y'):'';
						$nta['nfile'] 		= $nt->getNfile();
						
						$notifications['notifications'][] = $nta;
					}
					$this->set_response($notifications, REST_Controller::HTTP_OK); 
				}else{
					$message =[ 'message' =>' something went wrong... '];
					$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
				}
			}else{
				$message =[ 'message' =>' payload mistaken... '];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
			}
		}catch(Exception $e){
			$message =[ 'message' =>$e->getMessage()];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
		}
	}
	
	public function aanotifications_post(){
		
		$this->set_response('hello', REST_Controller::HTTP_OK);
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		try{
			if(!is_object($data))
			$data = new stdClass();
			$facultyId =0;
			if(property_exists($data,'facultyId'))	{
				$this->_em = $this->doctrine->em;
				$facultyId = $data->facultyId;
				$faculty = $this->_em->find('Entity\Faculty',$facultyId);
				if(is_object($faculty)){
					$apartmentId = $faculty->getApartmentId()->getId();
					
					$qb = $this->_em->createQueryBuilder();
					$notifObj  = $qb->select('an')->from('Entity\ApartmentAdminNotification','an')->where('an.apt_id = :aptId and an.ntype !=:ntype')->setParameter('aptId',$apartmentId)->setParameter('ntype','bulk')->getQuery()->getResult();
					
					
					$notifications = array();
					foreach($notifObj as $nt){
						
						$nta = array();
						$nta['id'] = $nt->getId();
						$flats = array();
						foreach($nt->getFlatIds() as $f){
							$flat = array();
						//	$flat['flat_id'] = $f->getId();
							//$flat['flat']    = $f->getBlockId()->getName().'-'.$f->getName();
							$flats[] = $f->getBlockId()->getName().'-'.$f->getName();
						}
						$nta['to'] 			= implode(',',$flats);
						$nta['subject'] 	= $nt->getSubject();
						$nta['message'] 	= $nt->getMessage();
						$nta['priority'] 	= $nt->getPriority();
						$nta['ndate'] 		= is_object($nt->getNdate())?$nt->getNdate()->format('d-m-y'):'';
						$nta['nfile'] 		= $nt->getNfile();
						
						$notifications[] = $nta;
					}
					$this->set_response($notifications, REST_Controller::HTTP_OK); 
				}else{
					$message =[ 'message' =>' something went wrong... '];
					$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
				}
			}else{
				$message =[ 'message' =>' payload mistaken... '];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
			}
		}catch(Exception $e){
			$message =[ 'message' =>$e->getMessage()];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
		}
	}
	
	
	public function aabulknotifsend_post(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		try{
			if(!is_object($data))
			$data = new stdClass();
			
			
			$facultyId =0;
			if(property_exists($data,'facultyId'))	{
				$this->_em = $this->doctrine->em;
				$facultyId = $data->facultyId;
				
				$faculty = $this->_em->find('Entity\Faculty',$facultyId);
				if(is_object($faculty)){
					$apartmentObj = $faculty->getApartmentId();
					$aanObj = new Entity\ApartmentAdminNotification();
					$aanObj->setNtype('bulk');

					if(property_exists($data,'subject')){	
						$subject 	= $data->subject;
						$aanObj->setSubject($subject);
					}
					if(property_exists($data,'message')){	
						$message 	= $data->message;
						$aanObj->setMessage($message);
					}else{
						
						}
					if(property_exists($data,'priority')){	
						$priority 	= $data->priority;
						$aanObj->setPriority($priority);
					}else{
					
						}
					if(property_exists($data,'nfile'))	{
						$nfile 	= $data->nfile;
						$aanObj->setNfile($nfile);
					}else{
						
						}
					if(property_exists($data,'ndate')){
						$ndate 	= $data->ndate;
						$aanObj->setNdate($ndate);
					}else{
					
						}
					
					if(property_exists($data,'aant_id')){
						$aant_id 	= $data->aant_id;
						$ntObj = $this->_em->find('Entity\ApartmentAdminNType',$aant_id);
						if(is_object($ntObj)){
							$aanObj->setNtypeId($ntObj);
						}else{
							
						}
					}else{
						
					}
					$aanObj->setApartmentId($apartmentObj);
					$aanObj->setFacultyId($faculty);
					$this->_em->persist($aanObj);	
					$this->_em->flush();
					
					$message =[ 'message' =>' successfully sent bulk notification.. '];
					$this->set_response($message, REST_Controller::HTTP_OK); 
				}else{
					$message =[ 'message' =>' something went wrong... '];
					$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
				}
			}else{
				$message =[ 'message' =>' payload mistaken... '];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
			}
		}catch(Exception $e){
			$message =[ 'message' =>$e->getMessage()];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
		}
	}
	
	public function aanotificationsend_post(){
		
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		try{
			if(!is_object($data))
			$data = new stdClass();
			
			
			$facultyId =0;
			if(property_exists($data,'facultyId'))	{
				$this->_em = $this->doctrine->em;
				$facultyId = $data->facultyId;
				
				$faculty = $this->_em->find('Entity\Faculty',$facultyId);
				if(is_object($faculty)){
					$apartmentObj = $faculty->getApartmentId();
					$aanObj = new \Entity\ApartmentAdminNotification();
					$aanObj->setNtype('');
					if(property_exists($data,'subject')){	
						$subject 	= $data->subject;
						$aanObj->setSubject($subject);
					}
					if(property_exists($data,'message')){	
						$message 	= $data->message;
						$aanObj->setMessage($message);
					}
					if(property_exists($data,'priority')){	
						$priority 	= $data->priority;
						$aanObj->setPriority($priority);
					}
					if(property_exists($data,'nfile'))	{
						$nfile 	= $data->nfile;
						$aanObj->setNfile($nfile);
					}
					if(property_exists($data,'ndate')){
						$ndate 	= $data->ndate;
						$aanObj->setNdate($ndate);
					}
					
					if(property_exists($data,'aant_id')){
						$aant_id 	= $data->aant_id;
						$ntObj = $this->_em->find('Entity\ApartmentAdminNType',$aant_id);
						if(is_object($ntObj)){
							$aanObj->setNtypeId($ntObj);
						}
					}
					
					if(property_exists($data,'flats')){
						foreach($data->flats as $f){
							$flat = $f->flatId;
							$flatObj = $this->_em->find('Entity\Flat',$flat);
							if(is_object($flatObj)){
								$aanObj->setFlatId($flatObj);
							}
						}
					}
					
					$aanObj->setApartmentId($apartmentObj);
					$aanObj->setFacultyId($faculty);
						
					$this->_em->persist($aanObj);	
					$this->_em->flush();
					
					$message =[ 'message' =>' successfully sent notification.. '];
					
					$this->set_response($message, REST_Controller::HTTP_OK); 
				}else{
					$message =[ 'message' =>' something went wrong... '];
					$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
				}
			}else{
				$message =[ 'message' =>' payload mistaken... '];
				$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);	
			}
		}catch(Exception $e){
			$message =[ 'message' =>$e->getMessage()];
			$this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);		
		}
	}
	
	/************************************************************************/
	/************************** VENDOR API'S ********************************/
	/************************************************************************/

	public function vendorSave_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$this->_em = $this->doctrine->em;
		try{
			if(!is_object($data))
			$data = new stdClass();
			$facultyId =0;
			$vendorId = 0;
			if(property_exists($data, 'vendorId')){
				$vendorId = $data->vendorId;
			}
			
			$name = '';
			if(property_exists($data, 'name')){
				$name = $data->name;
			}
			$email = '';
			if(property_exists($data, 'email')){
				$email = $data->email;
			}
			$mobile = '';
			if(property_exists($data, 'mobile')){
				$mobile = $data->mobile;
			}
			$vtype = '';
			if(property_exists($data, 'vtype')){
				$vtype = $data->vtype;
			}

			$company = '';
			if(property_exists($data, 'company')){
				$company = $data->company;
			}

			$address = '';
			if(property_exists($data, 'address')){
				$address = $data->address;
			}
			$areaId = '';
			if(property_exists($data, 'areaId')){
				$area = $data->areaId;
				$areaId = $this->_em->find('Entity\Area',$area);
			}

			if(property_exists($data,'facultyId'))	{
				$facultyId = $data->facultyId;
				$faculty = $this->_em->find('Entity\Faculty',$facultyId);
				$apartmentId = $faculty->getApartmentId();
			}
			
			if($apartmentId){
				if($vendorId){
					$vendorObj = $this->_em->find('Entity\Vendor',$vendorId);
					if(!is_object($vendorObj)){
						$vendorObj = new Entity\Vendor();		
					}
				}else{
					$vendorObj = new Entity\Vendor();	
				}
				
				$vendorObj->setName($name);
				$vendorObj->setEmail($email);
				$vendorObj->setMobile($mobile);
				$vendorObj->setVtype($vtype);
				$vendorObj->setCompany($company);
				$vendorObj->setAddress($address);
				if(is_object($areaId))
					$vendorObj->setAreaId($areaId);
				$vendorObj->setApartmentId($apartmentId);

				$this->_em->persist($vendorObj);
				$this->_em->flush();
				
				if($vendorId){
					$message = ['message'=>'vendor is updated successfully.'];
					$this->set_response($message,REST_Controller::HTTP_OK);
				}else{
					$message = ['message'=>'vendor is created successfully.'];
					$this->set_response($message,REST_Controller::HTTP_CREATED);	
				}
				
			}else{
				$message = ['message'=>'your not authorized...'];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
			
		}catch(Exception $e){
			$message = ['message'=>'your not authorized'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function vendors_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$this->_em = $this->doctrine->em;
		$qb =  $this->_em->createQueryBuilder();
		try{
			if(!is_object($data))
			$data = new stdClass();
			$facultyId =0;
			$apartmentId =0;
			if(property_exists($data,'facultyId'))	{
				$facultyId = $data->facultyId;
				$faculty = $this->_em->find('Entity\Faculty',$facultyId);
				$apartmentId = $faculty->getApartmentId()->getId();
			}
			
			if($apartmentId){
				
				$vendorObj = $qb->select('v')->from('Entity\Vendor','v')->where('v.apt_id=:apartmentId')->setParameter('apartmentId',$apartmentId)->getQuery()->getResult();
				
				$vendors = array();
				foreach ($vendorObj as $key => $value) {
					$vendor = array();
					$vendor['staff_id'] 	= $value->getId();
					$vendor['name'] 		= $value->getName();
					$vendor['email'] 		= $value->getEmail();
					$vendor['mobile'] 		= $value->getMobile();
					$vendor['vtype'] 		= $value->getVtype();
					$vendor['company'] 		= $value->getCompany();
					$vendor['address'] 		= $value->getAddress();
					$vendor['area'] 		= is_object($value->getAreaId())?$value->getAreaId()->getName():'';
					$vendors['vendors'][] = $vendor;
				}
				$this->set_response($vendors,REST_Controller::HTTP_OK);
			}else{
				$message = ['message'=>'your not authorized...'];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
			
		}catch(Exception $e){
			$message = ['message'=>'your not authorized'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function vendorStatus_post(){
		$input = file_get_contents('php://input');
		$data	= json_decode($input);
		$this->_em = $this->doctrine->em;
		try{
			if(!is_object($data))
			$data = new stdClass();
			$facultyId =0;
			$vendorId = 0;
			if(property_exists($data, 'vendorId')){
				$vendorId = $data->vendorId;
			}
			
			if(property_exists($data,'facultyId'))	{
				$facultyId = $data->facultyId;
				$faculty = $this->_em->find('Entity\Faculty',$facultyId);
				$apartmentId = $faculty->getApartmentId();
			}
			
			if($vendorId){
				
				$vendorObj = $this->_em->find('Entity\Vendor',$vendorId);
				$vendorObj->setStatus(!$vendorObj->getStatus());

				$this->_em->persist($vendorObj);
				$this->_em->flush();
				
				$message = ['message'=>'vendor status successfully updated.'];
				$this->set_response($message,REST_Controller::HTTP_OK);
			}else{
				$message = ['message'=>'your not authorized...'];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
			
		}catch(Exception $e){
			$message = ['message'=>'your not authorized'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	/************************************************************************/
	/*************************** STAFF API'S ********************************/
	/************************************************************************/

	public function staffSave_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$this->_em = $this->doctrine->em;
		try{
			if(!is_object($data))
			$data = new stdClass();
			$facultyId =0;
			
			$staffId = 0;
			if(property_exists($data, 'staffId')){
				$staffId = $data->staffId;
			}
			$name = '';
			if(property_exists($data, 'name')){
				$name = $data->name;
			}
			$email = '';
			if(property_exists($data, 'email')){
				$email = $data->email;
			}
			$mobile = '';
			if(property_exists($data, 'mobile')){
				$mobile = $data->mobile;
			}
			$designation = '';
			if(property_exists($data, 'designation')){
				$designation = $data->designation;
			}

			$image = '';
			if(property_exists($data, 'image')){
				$image = $data->image;
			}
			$address = '';
			if(property_exists($data, 'address')){
				$address = $data->address;
			}
			$idProofType = '';
			if(property_exists($data, 'idProofType')){
				$idProofType = $data->idProofType;
			}
			$idProof = '';
			if(property_exists($data, 'idProof')){
				$idProof = $data->idProof;
			}

			$apartmentId =0;
			if(property_exists($data,'facultyId'))	{
				$facultyId = $data->facultyId;
				$faculty = $this->_em->find('Entity\Faculty',$facultyId);
				$apartmentId = $faculty->getApartmentId();
			}
			
			if(is_object($apartmentId)){
				if($staffId){
					$staffObj = $this->_em->find('Entity\Staff',$staffId);
					if(!is_object($staffObj)){
						$staffObj = new Entity\Staff();		
					}
				}else{
					$staffObj = new Entity\Staff();	
				}
				
				$staffObj->setName($name);
				$staffObj->setEmail($email);
				$staffObj->setMobile($mobile);
				$staffObj->setDesignation($designation);
				$staffObj->setApartmentId($apartmentId);
				$staffObj->setImage($image);
				$staffObj->setAddress($address);
				$staffObj->setIdProofType($idProofType);
				$staffObj->setIdProof($idProof);
				$this->_em->persist($staffObj);
				$this->_em->flush();

				if($staffId){
					$message = ['message'=>'staff is updated successfully.'];
					$this->set_response($message,REST_Controller::HTTP_OK);
				}else{
					$message = ['message'=>'staff is created successfully.'];
					$this->set_response($message,REST_Controller::HTTP_CREATED);
				}
				
			}else{
				$message = ['message'=>'your not authorized...'];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
			
		}catch(Exception $e){
			$message = ['message'=>'your not authorized'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function staffStatus_post(){
		$input = file_get_contents('php://input');
		$data	= json_decode($input);
		$this->_em = $this->doctrine->em;
		try{
			if(!is_object($data))
			$data = new stdClass();
			$facultyId =0;
			$staffId = 0;
			if(property_exists($data, 'staffId')){
				$staffId = $data->staffId;
			}
			
			if(property_exists($data,'facultyId'))	{
				$facultyId = $data->facultyId;
				$faculty = $this->_em->find('Entity\Faculty',$facultyId);
				$apartmentId = $faculty->getApartmentId();
			}
			
			if($staffId){
				
				$staffObj = $this->_em->find('Entity\Staff',$staffId);
				$staffObj->setStatus(!$staffObj->getStatus());

				$this->_em->persist($staffObj);
				$this->_em->flush();
				
				$message = ['message'=>'staff status successfully updated.'];
				$this->set_response($message,REST_Controller::HTTP_OK);
			}else{
				$message = ['message'=>'your not authorized...'];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
			
		}catch(Exception $e){
			$message = ['message'=>'your not authorized'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function staff_post(){
		$input = file_get_contents("php://input");
		$data = json_decode($input);
		$this->_em = $this->doctrine->em;
		$qb =  $this->_em->createQueryBuilder();
		try{
			if(!is_object($data))
			$data = new stdClass();
			$facultyId =0;
			if(property_exists($data,'facultyId'))	{
				$facultyId = $data->facultyId;
				$faculty = $this->_em->find('Entity\Faculty',$facultyId);
				if(is_object($faculty) && is_object($faculty->getApartmentId())){
					$apartmentId = $faculty->getApartmentId()->getId();
				}else{
					$apartmentId = 0;
				}
				
			}
			$customerId =0;
			if(property_exists($data,'customerId'))	{
				$customerId = $data->customerId;
				$customer = $this->_em->find('Entity\Customer',$customerId);
				$apartmentId = $customer->getApartmentId()->getId();
			}
			if($apartmentId){
				
				$staffObj = $qb->select('s')->from('Entity\Staff','s')->where('s.apt_id=:apartmentId')->setParameter('apartmentId',$apartmentId)->getQuery()->getResult();
				
				$staff = array();
				foreach ($staffObj as $key => $value) {
					$staf = array();
					$staf['staff_id'] 	= $value->getId();
					$staf['name'] 		= $value->getName();
					$staf['designation']= $value->getDesignation();
					$staf['email'] 		= $value->getEmail();
					$staf['mobile'] 	= $value->getMobile();
					$staf['image'] 		= $value->getImage();
					$staf['address'] 	= $value->getAddress();
					$staf['idProofType']= $value->getIdProofType();
					$staf['idProof'] 	= $value->getIdProof();

					$staff['staff'][] 	= $staf;
				}
				$this->set_response($staff,REST_Controller::HTTP_OK);
			}else{
				$message = ['message'=>'your not authorized...'];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
			
		}catch(Exception $e){
			$message = ['message'=>'your not authorized'];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	/************************************************************************/
	/************************** RENTAL API'S ********************************/
	/************************************************************************/
	public function flatsSale_get(){
		$this->_em = $this->doctrine->em;
		$flatsObj = $this->_em->getRepository('Entity\Flat')->findBy(array('readyToSale'=>1,'status'=>1));
		$flats = array();
		foreach ($flatsObj as $key => $obj) {
			# code...
			$flat = array();
			$flat['name'] 		= $obj->getName();
			$flat['block']		= $obj->getBlockId()->getName();
			$flat['apartment'] 	= $obj->getBlockId()->getApartmentId()->getName();
			$flat['salePrice'] 	= $obj->getSalePrice();
			$flat['size'] 		= $obj->getSize();
			$flat['bhk'] 		= $obj->getBhk();

			$ownerObj = $obj->getHeadOrOwner();
			if(is_object($ownerObj)){
				$flat['ownerName'] 		= $ownerObj->getFirstName().' '.$ownerObj->getLastName();
				$flat['ownerMobie'] 	= $ownerObj->getPhoneNo();
				$flat['ownerEmail'] 	= $ownerObj->getEmail();
				$flats['flats'][] = $flat;
			}
			
		}
		$this->set_response($flats,REST_Controller::HTTP_OK);
	}

	public function flatsRent_get(){
		$this->_em = $this->doctrine->em;
		$flatsObj = $this->_em->getRepository('Entity\Flat')->findBy(array('readyToOccupy'=>1,'status'=>1));
		$flats = array();
		foreach ($flatsObj as $key => $obj) {
			# code...
			$flat = array();
			$flat['name'] 		= $obj->getName();
			$flat['block']		= $obj->getBlockId()->getName();
			$flat['apartment'] 	= $obj->getBlockId()->getApartmentId()->getName();
			$flat['rentPrice'] 	= $obj->getRentPrice();
			$flat['size'] 		= $obj->getSize();
			$flat['bhk'] 		= $obj->getBhk();

			$ownerObj = $obj->getHeadOrOwner();
			if(is_object($ownerObj)){
				$flat['ownerName'] 		= $ownerObj->getFirstName().' '.$ownerObj->getLastName();
				$flat['ownerMobie'] 	= $ownerObj->getPhoneNo();
				$flat['ownerEmail'] 	= $ownerObj->getEmail();
				$flats['flats'][] = $flat;
			}
			
		}
		$this->set_response($flats,REST_Controller::HTTP_OK);
	}

}