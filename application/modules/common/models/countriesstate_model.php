<?php 
class Countriesstate_model extends CI_Model {

function __construct()

{

parent::__construct();

$this->load->database();

}


function getCountries(){
	$query=$this->db->get('zzz_countries');
	return $query->result();
}
function getStates(){
	$query=$this->db->get('table_states');
	return $query->result();
}
function getCountryStates($cid){
	$this->db->where('countryID',$cid);
	$this->db->order_by('stateName');
	$query=$this->db->get('zzz_states');
	return $query->result();
}


}