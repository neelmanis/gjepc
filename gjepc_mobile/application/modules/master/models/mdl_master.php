<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Mdl_master extends CI_Model {

	function __construct() {
		parent::__construct();
	}

/********************************************************** Start Events Details ****************************************/
	 
	public function listEvent()
    {
            $this->db->select('*');
            $this->db->from('event_master');
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
		$this->db->insert("event_master",$data);
   }
   
   function getEventID($id)
   {
		$ans=$this->db->get_where("event_master",array("id"=>$id));
		if($ans->num_rows()>0)
		{
			return $ans->result();
		}
   }
	
   function eventUpdate($data,$id)
   {
		$this->db->where("id", $id);
		$ans=$this->db->update("event_master",$data);
	    return $ans; 
   }
	 
   function del_eventDetail($id)
   {
	    $this ->db-> where('id', $id);
        $result = $this ->db-> delete('event_master');
		return $result;
   }
/********************************************************** End Events Details ****************************************/

/********************************************************** Start Year Details ****************************************/
	 
	public function listYear()
    {
            $this->db->select('*');
            $this->db->from('year_master');
            $query = $this->db->get(); 
            if($query->num_rows() != 0)
            {
                return $query->result_array();
            }
            else
            {
                return false;
            }
     }
		   
   function addYearDetail($data)
   {
		$this->db->insert("year_master",$data);
   }
   
   function getYearID($id)
   {
		$ans=$this->db->get_where("year_master",array("id"=>$id));
		if($ans->num_rows()>0)
		{
			return $ans->result();
		}
   }
	
   function yearUpdate($data,$id)
   {
		$this->db->where("id", $id);
		$ans=$this->db->update("year_master",$data);
	    return $ans; 
   }
	 
   function del_yearDetail($id)
   {
	    $this ->db-> where('id', $id);
        $result = $this ->db-> delete('year_master');
		return $result;
   }
/********************************************************** End Year Details ****************************************/

		
}