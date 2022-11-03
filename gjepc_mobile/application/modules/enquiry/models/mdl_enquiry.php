<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Mdl_enquiry extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	
	function get_table() {
		$table = "cms_show_updates";
		return $table;
	}
	
/* Start ShowInfo Details */	
	public function getEnquiryList($dept)
	{		
			//$result="select e.id,e.post_date,e.email,e.mobile,e.enquiry,h.dept from enquiry e inner join helpdesk h on e.topic=h.id where dept='PVR'";
            //$this->db->select('*');
            //$this->db->from('cms_show_updates');
			// select e.id,e.post_date,e.email,e.mobile,e.enquiry,h.dept from enquiry e inner join helpdesk h on e.topic=h.id where dept='PVR'
			if($dept!='')
			{
			$this->db->select('e.id,e.post_date,e.gcode,e.email,e.mobile,e.enquiry,e.replied,h.dept');
			$this->db->from('enquiry e');
			$this->db->join('helpdesk h', 'e.topic = h.id'); 
			$this->db->where("dept", $dept);
			$this->db->order_by('e.id','DESC');
            }else {
			$this->db->select('e.id,e.post_date,e.gcode,e.email,e.mobile,e.enquiry,e.replied,h.dept');
			$this->db->from('enquiry e');
			$this->db->join('helpdesk h', 'e.topic = h.id order by e.id desc'); 
			//$this->db->where("dept", $dept);				
			}
			
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
	
	function getEnquiry($id)
	{
		$ans=$this->db->get_where("enquiry",array("id"=>$id));
		if($ans->num_rows()>0)
		{
			return $ans->result();
		}
    }
	
    function submitenquiry($data,$id)
	 {
		$this->db->where("id", $id);
		$ans=$this->db->update("enquiry",$data);
	//	$ans =$this->db->last_query();
		//echo $ans; exit;
	    return $ans; 
	 }
   
	function addDetail($data)
	{
		$this->db->insert("cms_show_updates",$data);
		//echo $ans=$this->db->last_query(); exit;
	}
   
   function getUser($id)
	{
		$ans=$this->db->get_where("cms_show_updates",array("id"=>$id));
		if($ans->num_rows()>0)
		{
			return $ans->result();
		}
    }
	
	function del_Detail($id)
	{
	    $this ->db-> where('id', $id);
        $result = $this ->db-> delete('cms_show_updates');
	//	$result =$this->db->last_query();
		//echo $result; exit;
		return $result;
	}
	
	function getEvents()
	{
			$this->db->select('*');
            $this->db->from('event_master');
			$this->db->where('status','1');
            $query = $this->db->get(); 
		//	$query = $this->db->last_query();
		 //  echo "<pre>" ;
		  // print_r($query); exit; 
            if($query->num_rows > 0)
            {
                return $query->result();
            }
            else
            {
                return false;
            }           
    }
	
	function getEventName($event)
	{ 
		$categoryView =$this->db->get_where("event_master",array('event' =>$event));
	//	echo $categoryView = $this->db->last_query();	
		
		if($categoryView->num_rows > 0)
		{
			$getCategory = $categoryView->result();
	//	echo '<pre>';	print_r($getCategory); 
		    $getCategory =  $getCategory[0]->event;			
		}
		else
		{
			$getCategory = "no";
		}	
		return $getCategory;
	}
	
	function getYear()
	{
			$this->db->select('*');
            $this->db->from('year_master');
			$this->db->where('status','1');
            $query = $this->db->get(); 
		//	$query = $this->db->last_query();
		 //  echo "<pre>" ;
		  // print_r($query); exit; 
            if($query->num_rows > 0)
            {
                return $query->result();
            }
            else
            {
                return false;
            }           
    }
	
	function getYearName($year)
	{ 
		$yearView =$this->db->get_where("year_master",array('year' =>$year));
	//	echo $categoryView = $this->db->last_query();	
		
		if($yearView->num_rows > 0)
		{
			$getYear = $yearView->result();
	//	echo '<pre>';	print_r($getYear); 
		    $getYear =  $getYear[0]->year;			
		}
		else
		{
			$getYear = "no";
		}	
		return $getYear;
	}
	
/********************************************************** End Show Details ***************************************************/


	function getsubmitchangepassword($password,$oldpassword,$regId)
	{
		$hashpassword=Modules::run('sitesecurity/makeHash',$password);
		$oldhashpassowrd=Modules::run('sitesecurity/makeHash',$oldpassword);
		$strResult=$this->get_where($regId);
		$strResult=$strResult->result();
			$Resultoldpassword=$strResult[0]->password;
			if($Resultoldpassword==$oldhashpassowrd)
			{
					$strQuery="update exhibitor set password='$hashpassword' where regId=$regId";
					$strResult=$this->_custom_query($strQuery);
						if($strResult) 
						{
							$strResult=1;

						}
						else 
						{
							$strResult="Some error occure.";
						}


			}
			else
			{
				$strResult="Old password is inccorect";

			}
			return $strResult;
		

	}

	 function userDeactive($id)
	 {
		$this->db->where('regId', $id);
        $ans=$this->db->update('exhibitor',array("isActive"=>"0"));
		return $ans;
	 }
	 
	function userActive($id)
	 {
		$this->db->where('regId', $id);
        $ans=$this->db->update('exhibitor',array("isActive"=>"1"));
	    return $ans;
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
    
	
	
	
	function get($order_by) {

		$table = $this->get_table();

		$this->db->order_by($order_by);

		$query=$this->db->get($table);

		return $query;

	}



	function get_with_limit($limit, $offset, $order_by) {

		$table = $this->get_table();

		$this->db->limit($limit, $offset);

		$this->db->order_by($order_by);

		$query=$this->db->get($table);

		return $query;

	}



	function get_where($regId) {

		$table = $this->get_table();

		$this->db->where('regId', $regId);

		$query=$this->db->get($table);

		return $query;

	}



	function get_where_custom($col, $value) {

		$table = $this->get_table();

		$this->db->where($col, $value);

		$query=$this->db->get($table);

		return $query;

	}



	function _insert($data,$tables) {

		$table = $tables;

		return $this->db->insert($table, $data);

	}



	function _update($regId, $data) {

		$table = $this->get_table();

		$this->db->where('regId', $regId);

		return $this->db->update($table, $data);

	}



	function _delete($regId) {

		$table = $this->get_table();

		$this->db->where('regId', $regId);

		return $this->db->delete($table);

	}



	function count_where($column, $value) {

		$table = $this->get_table();

		$this->db->where($column, $value);

		$query=$this->db->get($table);

		$num_rows = $query->num_rows();

		return $num_rows;

	}



	function count_all() {

		$table = $this->get_table();

		$query=$this->db->get($table);

		$num_rows = $query->num_rows();

		return $num_rows;

	}



	function get_max() {

		$table = $this->get_table();

		$this->db->select_max('regId');

		$query = $this->db->get($table);

		$row=$query->row();

		$regId=$row->regId;

		return $regId;

	}



	function _custom_query($mysql_query) {

		$query = $this->db->query($mysql_query);
		return $query;

	}
	
	function checkEmail($email){
  
			    $strQuery="select * FROM exhibitor where email='$email'";
				$strResult=$this->_custom_query($strQuery);
				
					if($strResult->num_rows > 0)
					{ 
						$strResult=$strResult->result();
								   $strResult=array("Result"=>$strResult,
									"Message"=>"Success",
									"status"=>"true");	
					}
					else
					{
						            $strResult=array("Result"=>"",
									"Message"=>"Mail address does not exists",
									"status"=>"false");	
					}
					return $strResult;
}


	
public function change_forgot_passowrd($uid,$new)
	{
	    $this->db->where("regId", $uid);
		$ans = $this->db->update("exhibitor",array("password"=>$new));
	    return $ans; 
	}
	
}