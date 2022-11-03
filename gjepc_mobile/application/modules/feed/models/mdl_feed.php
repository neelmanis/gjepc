<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Mdl_feed extends CI_Model {

	function __construct() {
		parent::__construct();
	}

    
function getRegistereduser(){
    $ans = $this->db->get_where("feed_registration",array("isActive"=>"1"));	   
	     if($ans->num_rows > 0)
		 {
		   return $ans->result();
		 }
		 else
		 {
		    echo "no";
		 }
	
	}
	
	function getFeedInfo($id){
    $ans = $this->db->get_where("feed_userfeed",array("isActive"=>"1","feedId"=>$id));	   
	     if($ans->num_rows > 0)
		 {
		   return $ans->result();
		 }
		 else
		 {
		    echo "no";
		 }
	
	}
	
	public function getFeedlist($isActive)
        {
            $this->db->select('*');
            $this->db->from('feed_userfeed');
			$this->db->where('isActive',$isActive); 
            $query = $this->db->get(); 
			//$query = $this->db->last_query();
		   // echo $query; exit; 
            if($query->num_rows() != 0)
            {
                return $query->result_array();
            }
            else
            {
                return false;
            }
        }
		
   function _delete($feedId) {
		$this->db->where('feedId', $feedId);
		return $this->db->delete('feed_userfeed');

	}
	
function getFeeds($id)
	{
	  $ans = $this->db->get_where("feed_userfeed",array("regId"=>$id,"isActive"=>"1"));	
	  if($ans->num_rows()>0)
	  {
		 return $ans->result();
	  }
	  else
	  {
	    return "No";	  
	  }
	}
		
	public function getFeedCat($cat,$id)
        {
            $this->db->where('fu.catId', $cat);
			$this->db->where('fu.feedId', $id);
            $this->db->from('feed_category fc'); 
            $this->db->join('feed_userfeed fu', 'fc.catId = fu.catId', 'inner');
            $query = $this->db->get(); 
			//$query = $this->db->last_query();
		    //echo $query; exit; 
            if($query->num_rows() != 0)
            {
                return $query->result_array();
            }
            else
            {
                return false;
            }
        }
		
	public function getContacts($feed)
	{
	   $ans = $this->db->get_where("feed_userfeedcontactname",array("isActive"=>"1","feedId"=>$feed));	
	   if($ans->num_rows() != 0)
            {
                return $ans->result_array();
            }
            else
            {
                return false;
            }  
	}	
	
	public function getImages($feed){
	
	   $ans = $this->db->get_where("feed_userfeedimages",array("isActive"=>"1","feedId"=>$feed));	
	   if($ans->num_rows() != 0)
            {
                return $ans->result_array();
            }
            else
            {
                return false;
            }  
	}
	
	public function getCategory()
	{
	  $ans = $this->db->get_where("feed_category",array("isActive"=>"1"));	   
	     if($ans->num_rows > 0)
		 {
		   return $ans->result();
		 }
		 else
		 {
		    echo "no";
		 }
	}
	
	public function getParent($cat_id)
	{
	  $this->db->select("catName");
	  $this->db->from("feed_category");
	  $this->db->where("isActive","1");
	  $this->db->where("catId",$cat_id);
	  $ans = $this->db->get();
	  //$ans = $this->db->last_query();
	  //echo $ans;
	  //exit;  
	     if($ans->num_rows > 0)
		 {
		   return $ans->result();
		 }
		 else
		 {
		    echo "no";
		 }
	}

	
	
	public function getRegUsers($id){
	  $ans = $this->db->get_where("feed_registration",array('regId'=>$id) );
		if($ans->num_rows > 0)
		{
		 return $ans->result();
		}
	}
 	
	
}