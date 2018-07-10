<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		
		$email 		= 'rkreddy.php@gmail.com'; //$data->email;
		$password 	= md5('test'); //md5($data->password);
	 $cust = $qb->select('c')->from('Entity\Customer','c')->where('c.email =:email and c.password =:pwd')->setParameter('email',$email)->setParameter('pwd',$password)->getQuery()->getResult();
	 
		$data['body'] = 'admin';
		$this->load->view('home',$data);
	}
}
