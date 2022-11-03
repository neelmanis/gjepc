<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Mdl_gjepcintevents extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
/************************************* GJEPC EVENTS List ************************************/	 
			public function eventList()
			{
				$this->db->select('*');
				$this->db->from('appintvents');
				$query = $this->db->get(); 
			//	$query = $this->db->last_query();
			 //   echo $query; exit; 
				if($query->num_rows() != 0)
				{
					return $query->result_array();
				}
				else
				{
					return false;
				}
			}
		
			function addEventDetail($data)
			{
			$this->db->insert("appintvents",$data);
			//	echo $ans=$this->db->last_query(); exit;
			}
		   
		    function getEvent($id)
			{
				$ans=$this->db->get_where("appintvents",array("id"=>$id));
				//$ans =$this->db->last_query();
				//echo $ans; exit;
				if($ans->num_rows()>0)
				{
					return $ans->result();
				} else {
					echo 'No';
				}
			}
			
			function eventUpdate($data,$id)
			{
				$this->db->where("id", $id);
				$ans=$this->db->update("appintvents",$data);
			//	$ans =$this->db->last_query();
				//echo $ans; exit;
				return $ans; 
			}	
	
			function del_eventDetail($id)
			{
				$this ->db-> where('id', $id);
				$result = $this ->db-> delete('appintvents');
			//	$result =$this->db->last_query();
				//echo $result; exit;
				return $result;
			}
	
}