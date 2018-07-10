<?php 
class Countriesstate_model extends CI_Model {

function __construct()

{

parent::__construct();

$this->load->database();

}


function getCountries(){
	$query=$this->db->get('table_counties');
	return $query->result();
}
function getStates(){
	$query=$this->db->get('table_states');
	return $query->result();
}


}