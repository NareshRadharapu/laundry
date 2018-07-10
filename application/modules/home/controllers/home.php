<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MX_Controller {

	public function index()
	{	$this->_em = $this->doctrine->em;
		$qb = $this->_em->createQueryBuilder();
	
		$email 		='rkreddy.php@gmail.com'; //$data->email;
		$password 	= md5('test'); //md5($data->password);
		
		 echo md5('test');
		 
	 	//$cust = $qb->select('c')->from('Entity\Customer','c')->where('c.email =:email and c.password =:pwd')->setParameter('email',$email)->setParameter('pwd',$password)->setMaxResults(1)->getQuery()->getResult();
		
		$cust = $this->_em->getRepository('Entity\Customer')->findOneBy(array('email'=>$email,'password'=>$password));
	 
	// print_r($cust);
	 
		$this->load->view('common/header');
		$this->load->view('home_view');
		$this->load->view('common/footer');
	}
}
