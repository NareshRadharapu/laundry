<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class ApartmentAdmin extends REST_Controller {
   
   function __construct()
   {
    
		parent::__construct();	
	
        $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
		$this->methods['apartment_get']['limit'] = '10';
		$this->methods['itemtype_get']['limit'] = '10';
 		$this->_em = $this->doctrine->em;
    }


	public function displayAds_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		$apartmentId = 0;
		if(property_exists($data, 'apartmentId')){
			$apartmentId 		= $data->apartmentId;
		}
		try{
			$qb = $this->_em->createQueryBuilder();
			

			$adsObj = $qb->select('ad')->from('Entity\Ad','ad')->where('ad.apt_id=:apartmentId and (ad.views<=ad.viewsLimit or ad.viewsLimit =0) and (ad.clicks <= ad.clicksLimit or ad.clicksLimit=0 ) and ad.fromDate <=ad.updated_at and ad.toDate >= ad.updated_at and ad.status=:status and ad.adminStatus=:status')->setParameter('apartmentId',$apartmentId)->setParameter('status',1)->getQuery()->getResult();
			$ads = array();
			foreach ($adsObj as $key => $obj) {
				$ad =  array();
				$ad['name'] 		= $obj->getName();
				$ad['image'] 		= $obj->getImage();
				$ad['link'] 		= $obj->getLink();
				$ad['description'] 	= $obj->getAdDescription();

				$ads['ads'][] = $ad;
			}
			$this->set_response($ads,REST_Controller::HTTP_OK);

		}catch(Exception $e){
			$message = ['message'=>$e->getMessage(),'status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function apartmentAdminAds_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);

		$apartmentId = 0;
		if(property_exists($data, 'apartmentId')){
			$apartmentId 		= $data->apartmentId;
		}
		try{
			$qb = $this->_em->createQueryBuilder();

			$adsObj = $qb->select('ad')->from('Entity\Ad','ad')->where('ad.apt_id=:apartmentId')->setParameter('apartmentId',$apartmentId)->getQuery()->getResult();
			$ads = array();
			foreach ($adsObj as $key => $obj) {
				$ad =  array();
				$ad['name'] 		= $obj->getName();
				$ad['image'] 		= $obj->getImage();
				$ad['link'] 		= $obj->getLink();
				$ad['description'] 	= $obj->getAdDescription();
				$ad['views'] 		= $obj->getViews();
				$ad['viewsLimit'] 	= $obj->getViewsLimit();
				$ad['clicks'] 		= $obj->getClicks();
				$ad['clicksLimit'] 	= $obj->getClicksLimit();
				$ad['fromDate'] 	= strtotime($obj->getFromDate()->format('d-M-Y'))*1000;
				$ad['toDate'] 		= strtotime($obj->getToDate()->format('d-M-Y'))*1000;

				$ads['ads'][] = $ad;
			}
			$this->set_response($ads,REST_Controller::HTTP_OK);

		}catch(Exception $e){
			$message = ['message'=>$e->getMessage(),'status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function adminAds_get(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		
		try{
			$qb = $this->_em->createQueryBuilder();

			$adsObj = $qb->select('ad')->from('Entity\Ad','ad')->getQuery()->getResult();
			$ads = array();
			foreach ($adsObj as $key => $obj) {
				$ad =  array();
				$ad['name'] = $obj->getName();
				$ad['image'] = $obj->getImage();
				$ad['link'] = $obj->getLink();
				$ad['description'] 	= $obj->getAdDescription();
				$ad['views'] 		= $obj->getViews();
				$ad['viewsLimit'] 	= $obj->getViewsLimit();
				$ad['clicks'] 		= $obj->getClicks();
				$ad['clicksLimit'] 	= $obj->getClicksLimit();
				$ad['fromDate'] 	= strtotime($obj->getFromDate()->format('y-m-d'))*1000;
				$ad['toDate'] 		= strtotime($obj->getToDate()->format('y-m-d'))*1000;
				$ad['apartment']	= $obj->getApartmentId()->getName();
				$ad['adminName']	= $obj->getFacultyId()->getName();
				$ads['ads'][] = $ad;
			}
			$this->set_response($ads,REST_Controller::HTTP_OK);

		}catch(Exception $e){
			$message = ['message'=>$e->getMessage(),'status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function adCreate_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(!is_object($data))
		$data = new stdClass();
		$adId = 0;
		if(property_exists($data, 'adId')){
			$adId 		= $data->adId;
		}
		$name = '';
		if(property_exists($data, 'name')){
			$name 		= $data->name;
		}
		$adType = '';
		if(property_exists($data, 'adType')){
			$adType 	= $data->adType;
		}
		$adCategory = '';
		if(property_exists($data, 'adCategory')){
			$adCategory = $data->adCategory;
		}
		$adPlan = '';
		if(property_exists($data, 'adPlan')){
			$adPlan 	= $data->adPlan;
		}
		$description = '';
		if(property_exists($data, 'description')){
			$description= $data->description;
		}
		$image = '';
		if(property_exists($data, 'image')){
			$image 		= $data->image;
		}
		$link = '';
		if(property_exists($data, 'link')){
			$link 		= $data->link;
		}

		$viewsLimit = 0;
		if(property_exists($data, 'viewsLimit')){
			$viewsLimit = $data->viewsLimit;
		}
		$clicksLimit = 0;
		if(property_exists($data, 'clicksLimit')){
			$clicksLimit= $data->clicksLimit;
		}
		$fromDate = date('y-m-d');
		if(property_exists($data, 'fromDate')){
			$fromDate 	= $data->fromDate;
		}

		$toDate = date('y-m-d');
		if(property_exists($data, 'toDate')){
			$toDate 	= $data->toDate;
		}

		$apartmentId = 0;
		if(property_exists($data, 'apartmentId')){
			$apartment = $data->apartmentId;
			$ap = $this->_em->find('Entity\Apartment',$apartment);
			if(is_object($ap)){
				$apartmentId = $ap;
			}
		}
		
		$facultyId = 0;
		if(property_exists($data, 'facultyId')){
			$faculty 	= $data->facultyId;
			$fa = $this->_em->find('Entity\Faculty',$faculty);
			if(is_object($fa)){
				$facultyId = $fa;
			}
		}

		try{
			if($adId){
				$ad = $this->_em->find('Entity\Ad',$adId);
				if(!is_object($ad)){
					$ad = new Entity\Ad();
				}
			}else{
				$ad = new Entity\Ad();
			}

			$ad->setName($name);
			$ad->setAdType($adType);
			$ad->setAdCategory($adCategory);
			$ad->setAdPlan($adPlan);
			$ad->getAdCategory($description);
			$ad->setImage($image);
			$ad->setLink($link);
			$ad->setViewsLimit($viewsLimit);
			$ad->setClicksLimit($clicksLimit);
			$ad->setFromDate($fromDate);
			$ad->setToDate($toDate);
			$ad->setApartmentId($apartmentId);
			$ad->setFacultyId($facultyId);
			
			$this->_em->persist($ad);
			$this->_em->flush();

			$message = ['message'=>'successfully created Ad'];
			$this->set_response($message,REST_Controller::HTTP_CREATED);

		}catch(Exception $e){
			$message = ['message'=>$e->getMessage(),'status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function adAdminStatus_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(!is_object($data))
		$data = new stdClass();
		try{
			$status = '';
			if(property_exists($data, 'status')){
				$status = $data->status;
			}

			
			$adId = 0;
			if(property_exists($data, 'adId')){
				$ad 	= $data->adId;
				$adId = $this->_em->find('Entity\Ad',$ad);
			}
			if(is_object($adId)){
				$adId->setAdminStatus($status);
				$this->_em->persist($adId);
				$this->_em->flush();
				$message = ['message'=>'successfully status updated'];
				$this->set_response($message,REST_Controller::HTTP_OK);
			}else{
				$message = ['message'=>'something went wrong.'];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}

		}catch(Exception $e){
			$message = ['message'=>$e->getMessage(),'status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function adStatus_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(!is_object($data))
		$data = new stdClass();
		try{
			$status = '';
			if(property_exists($data, 'status')){
				$status = $data->status;
			}

			$facultyId = 0;
			if(property_exists($data, 'facultyId')){
				$faculty 	= $data->facultyId;
				$facultyId = $this->_em->find('Entity\Faculty',$faculty);
			}
			$adId = 0;
			if(property_exists($data, 'adId')){
				$ad 	= $data->adId;
				$adId = $this->_em->find('Entity\Ad',$ad);
			}
			if(is_object($adId) && is_object($facultyId)){
				$adId->setStatus($status);
				$this->_em->persist($adId);
				$this->_em->flush();
				$message = ['message'=>'successfully status updated'];
				$this->set_response($message,REST_Controller::HTTP_OK);
			}else{
				$message = ['message'=>'something went wrong.'];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}

		}catch(Exception $e){
			$message = ['message'=>$e->getMessage(),'status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function adClick_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(!is_object($data))
		$data = new stdClass();
		try{
			
			
			$adId = 0;
			if(property_exists($data, 'adId')){
				$ad 	= $data->adId;
				$adId = $this->_em->find('Entity\Ad',$ad);
			}
			if(is_object($adId)){
				$adId->setClick();
				$adId->setUpdatedAt();
				$this->_em->persist($adId);
				$this->_em->flush();
				$this->set_response(null,REST_Controller::HTTP_OK);
			}else{
				$message = ['message'=>'something went wrong.'];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}

		}catch(Exception $e){
			$message = ['message'=>$e->getMessage(),'status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	public function adView_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(!is_object($data))
		$data = new stdClass();
		try{

			$adId = 0;
			if(property_exists($data, 'adId')){
				$ad 	= $data->adId;
				$adId = $this->_em->find('Entity\Ad',$ad);
			}
			if(is_object($adId)){
				$adId->setView();
				$adId->setUpdatedAt();
				$this->_em->persist($adId);
				$this->_em->flush();
				$this->set_response(null,REST_Controller::HTTP_OK);
			}else{
				$message = ['message'=>'something went wrong.'];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}

		}catch(Exception $e){
			$message = ['message'=>$e->getMessage(),'status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}

/**************** complaints ******************/
	public function addComplaint_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){

			$cId = 0;
			if(property_exists($data, 'cId')){
				$cId 		= $data->cId;
			}
			$subject = '';
			if(property_exists($data, 'subject')){
				$subject 	= $data->subject;
			}
			$priority = '';
			if(property_exists($data, 'priority')){
				$priority 	= $data->priority;
			}
			$message = '';
			if(property_exists($data, 'message')){
				$message 	= $data->message;
			}
			$ctype = '';
			if(property_exists($data, 'ctype')){
				$ctype 	= $data->ctype;
			}
			
			$image = '';
			if(property_exists($data, 'image')){
				$image 		= $data->image;
			}
			

			$customerId = 0;
			$apartmentId = 0;
			$blockId = 0;
			$flatId = 0;
			if(property_exists($data, 'customerId')){
				$customerId = $data->customerId;
				$customer = $this->_em->find('Entity\Customer',$customerId);
				if(is_object($customer)){
					$customerId 	= $customer;
					$apartmentId 	= $customer->getApartmentId();
					$blockId 		= $customer->getBlockId();
					$flatId 		= $customer->getFlatId();
				}
			}
		
			try{
				if($cId){
					$complaint = $this->_em->find('Entity\Complaint',$cId);
					if(!is_object($complaint)){
						$complaint = new Entity\Complaint();
					}
				}else{
					$complaint = new Entity\Complaint();
				}

				$complaint->setSubject($subject);
				$complaint->setPriority($priority);
				$complaint->setMessage($message);
				$complaint->setImage($image);
				$complaint->setCtype($ctype);
				if($apartmentId)
					$complaint->setApartmentId($apartmentId);
				if($blockId)
					$complaint->setBlockId($blockId);
				if($flatId)
					$complaint->setFlatId($flatId);
				if($customerId)
					$complaint->setCustomerId($customerId);

				
				$this->_em->persist($complaint);
				$this->_em->flush();

				$message = ['message'=>'successfully created complaint'];
				$this->set_response($message,REST_Controller::HTTP_CREATED);

			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something went wrong','status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function complaintsList_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);

		$apartmentId = 0;
		if(property_exists($data, 'apartmentId')){
			$apartmentId 		= $data->apartmentId;
		}
		try{
			$qb = $this->_em->createQueryBuilder();

			$complaintsObj = $qb->select('c')->from('Entity\Complaint','c')->where('c.apt_id=:apartmentId and c.status=0')->setParameter('apartmentId',$apartmentId)->getQuery()->getResult();
			$complaints = array();
			foreach ($complaintsObj as $key => $obj) {
				$complaint =  array();
				$complaint['subject'] 	= $obj->getSubject();
				$complaint['ctype'] 	= $obj->getCtype();
				$complaint['priority'] 	= $obj->getPriority();
				$complaint['image'] 	= $obj->getImage();
				$complaint['message'] 	= $obj->getMessage();
				$complaint['flat'] 		= $obj->getFlatId()->getName();
				$complaint['block'] 	= $obj->getBlockId()->getName();
				$complaint['date'] 		= strtotime($obj->getCreatedAt()->format('d-M-Y'))*1000;
				
				$complaints['complaints'][] = $complaint;
			}
			$this->set_response($complaints,REST_Controller::HTTP_OK);

		}catch(Exception $e){
			$message = ['message'=>$e->getMessage(),'status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function complaintsHistory_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);

		$apartmentId = 0;
		if(property_exists($data, 'apartmentId')){
			$apartmentId 		= $data->apartmentId;
		}
		try{
			$qb = $this->_em->createQueryBuilder();

			$complaintsObj = $qb->select('c')->from('Entity\Complaint','c')->where('c.apt_id=:apartmentId and c.status=1')->setParameter('apartmentId',$apartmentId)->getQuery()->getResult();
			$complaints = array();
			foreach ($complaintsObj as $key => $obj) {
				$complaint =  array();
				$complaint['subject'] 	= $obj->getSubject();
				$complaint['ctype'] 	= $obj->getCtype();
				$complaint['priority'] 	= $obj->getPriority();
				$complaint['image'] 	= $obj->getImage();
				$complaint['message'] 	= $obj->getMessage();
				$complaint['flat'] 		= $obj->getFlatId()->getName();
				$complaint['block'] 	= $obj->getBlockId()->getName();
				$faculty = $obj->getFacultyId();
				if(is_object($faculty))
				$complaint['faculty'] 	= $faculty->getFirstName().' '.$faculty->getLastName();
				else
				$complaint['faculty'] 	= '';	

				$complaint['date'] 		= strtotime($obj->getCreatedAt()->format('d-M-Y'))*1000;
				

				$complaints['complaints'][] = $complaint;
			}
			$this->set_response($complaints,REST_Controller::HTTP_OK);

		}catch(Exception $e){
			$message = ['message'=>$e->getMessage(),'status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function complaintStatus_post(){
		$input = file_get_contents('php://input');
		$data = json_decode($input);
		if(is_object($data)){
			try{
				$status = '';
				if(property_exists($data, 'status')){
					$status = $data->status;
				}

				$facultyId = 0;
				if(property_exists($data, 'facultyId')){
					$faculty 	= $data->facultyId;
					$facultyId = $this->_em->find('Entity\Faculty',$faculty);
				}
				$cId = 0;
				if(property_exists($data, 'cId')){
					$c 	= $data->cId;
					$cId = $this->_em->find('Entity\Complaint',$c);
				}
				if(is_object($cId) && is_object($facultyId)){
					$cId->setStatus(!$cId->getStatus());
					$cId->setFacultyId($facultyId);
					$this->_em->persist($cId);
					$this->_em->flush();
					$message = ['message'=>'successfully status updated'];
					$this->set_response($message,REST_Controller::HTTP_OK);
				}else{
					$message = ['message'=>'something went wrong.'];
					$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
				}

			}catch(Exception $e){
				$message = ['message'=>$e->getMessage(),'status'=>500];
				$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$message = ['message'=>'something went wrong, please try again.','status'=>500];
			$this->set_response($message,REST_Controller::HTTP_BAD_REQUEST);
		}
	}


}