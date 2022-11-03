<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Mdl_showinfo extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	
	function get_table() {
		$table = "cms_show_details";
		return $table;
	}
	
/* Start ShowInfo Details */	
	public function listShowDetails()
	{
            $this->db->select('*');
            $this->db->from('cms_show_details');
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

     function userUpdate($data,$id)
	 {
		$this->db->where("id", $id);
		$ans=$this->db->update("cms_show_details",$data);
	//	$ans =$this->db->last_query();
		//echo $ans; exit;
	    return $ans; 
	 }
   
	function addDetail($data)
	{
		$this->db->insert("cms_show_details",$data);
		//echo $ans=$this->db->last_query(); exit;
	}
   
   function getUser($id)
	{
		$ans=$this->db->get_where("cms_show_details",array("id"=>$id));
		if($ans->num_rows()>0)
		{
			return $ans->result();
		}
    }
	
	function del_Detail($id)
	{
	    $this ->db-> where('id', $id);
        $result = $this ->db-> delete('cms_show_details');
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
	
	function getEventName($id)
	{ 
		$categoryView =$this->db->get_where("event_master",array('id' =>$id));
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
	
	function getYearName($id)
	{ 
		$yearView =$this->db->get_where("year_master",array('id' =>$id));
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

/********************************************************** Start Registration Details ****************************************/
	 
	public function listRegistration()
    {
            $this->db->select('*');
            $this->db->from('cms_registration');
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
		
	function registrationUpdate($data,$id)
	 {
		$this->db->where("id", $id);
		$ans=$this->db->update("cms_registration",$data);
	//	$ans =$this->db->last_query();
		//echo $ans; exit;
	    return $ans; 
	 }
   
	function addRegisDetail($data)
	{
		$this->db->insert("cms_registration",$data);
	//	echo $ans=$this->db->last_query(); exit;
	}
   
   function getRegistration($id)
	{
		$ans=$this->db->get_where("cms_registration",array("id"=>$id));
		if($ans->num_rows()>0)
		{
			return $ans->result();
		}
    }
	
	function del_regDetail($id)
	{
	    $this ->db-> where('id', $id);
        $result = $this ->db-> delete('cms_registration');
		return $result;
	}
	
/********************************************************** End Registration Details ****************************************/	

/********************************************************** Start FAQ Details ****************************************/
	 
	public function listFaqs()
    {
            $this->db->select('*');
            $this->db->from('cms_faq');
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
		
	function faqUpdate($data,$id)
	 {
		$this->db->where("id", $id);
		$ans=$this->db->update("cms_faq",$data);
	//	$ans =$this->db->last_query();
		//echo $ans; exit;
	    return $ans; 
	 }
   
	function addFaqDetail($data)
	{
		$this->db->insert("cms_faq",$data);
	//	echo $ans=$this->db->last_query(); exit;
	}
   
   function getFaq($id)
	{
		$ans=$this->db->get_where("cms_faq",array("id"=>$id));
		//$ans =$this->db->last_query();
		//echo $ans; exit;
		if($ans->num_rows()>0)
		{
			return $ans->result();
		}
    }
	
	function del_faqDetail($id)
	{
	    $this ->db-> where('id', $id);
        $result = $this ->db-> delete('cms_faq');
		return $result;
	}
/********************************************************** End FAQ Details ****************************************/	

/********************************************************** Start HOW TO REACH Details ****************************************/
	 
	public function listReach()
    {
            $this->db->select('*');
            $this->db->from('cms_how_to_reach');
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
		
	function reachUpdate($data,$id)
	 {
		$this->db->where("id", $id);
		$ans=$this->db->update("cms_how_to_reach",$data);
	//	$ans =$this->db->last_query();
		//echo $ans; exit;
	    return $ans; 
	 }
   
	function addReachDetail($data)
	{
		$this->db->insert("cms_how_to_reach",$data);
	//	echo $ans=$this->db->last_query(); exit;
	}
   
   function getReach($id)
	{
		$ans=$this->db->get_where("cms_how_to_reach",array("id"=>$id));
		//$ans =$this->db->last_query();
		//echo $ans; exit;
		if($ans->num_rows()>0)
		{
			return $ans->result();
		}
    }
	
	function del_reachDetail($id)
	{
	    $this ->db-> where('id', $id);
        $result = $this ->db-> delete('cms_how_to_reach');
		return $result;
	}
/********************************************************** End HOW TO REACH Details ****************************************/
 
/********************************************************** Start About GJEPC Details **************************************/
	 
	public function listAbout()
    {
            $this->db->select('*');
            $this->db->from('cms_about_gjepc');
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
		
	function aboutUpdate($data,$id)
	 {
		$this->db->where("id", $id);
		$ans=$this->db->update("cms_about_gjepc",$data);
	//	$ans =$this->db->last_query();
		//echo $ans; exit;
	    return $ans; 
	 }
   
	function addAboutDetail($data)
	{
		$this->db->insert("cms_about_gjepc",$data);
	//	echo $ans=$this->db->last_query(); exit;
	}
   
   function getAbout($id)
	{
		$ans=$this->db->get_where("cms_about_gjepc",array("id"=>$id));
		//$ans =$this->db->last_query();
		//echo $ans; exit;
		if($ans->num_rows()>0)
		{
			return $ans->result();
		}
    }
	
	function del_aboutDetail($id)
	{
	    $this ->db-> where('id', $id);
        $result = $this ->db-> delete('cms_about_gjepc');
		return $result;
	}
/********************************************************** End About GJEPC Details ****************************************/

/********************************************************** Start Contact Details **************************************/
	 
	public function listContact()
    {
            $this->db->select('*');
            $this->db->from('cms_contact');
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
		
	function contactUpdate($data,$id)
	 {
		$this->db->where("id", $id);
		$ans=$this->db->update("cms_contact",$data);
	//	$ans =$this->db->last_query();
		//echo $ans; exit;
	    return $ans; 
	 }
   
	function addContactDetail($data)
	{
		$this->db->insert("cms_contact",$data);
	//	echo $ans=$this->db->last_query(); exit;
	}
   
   function getContact($id)
	{
		$ans=$this->db->get_where("cms_contact",array("id"=>$id));
		//$ans =$this->db->last_query();
		//echo $ans; exit;
		if($ans->num_rows()>0)
		{
			return $ans->result();
		}
    }
	
	function delete_contact($id)
	{
	    $this ->db-> where('id', $id);
        $result = $this ->db-> delete('cms_contact');
	//	$result =$this->db->last_query();
		//echo $result; exit;
		return $result;
	}
	  
/********************************************************** End Contact Details ****************************************/
 
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