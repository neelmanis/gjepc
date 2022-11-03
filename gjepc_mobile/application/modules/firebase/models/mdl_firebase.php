<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Mdl_firebase extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	function get_table() {
		$table = "app_firebase";
		return $table;
	}
	
/********************************************************** firebase List **************************************/	 
	public function msgList()
    {
            $this->db->select('*');
            $this->db->from('app_firebase');
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
	
	function addFirebaseDetail($data)
	{
		$this->db->insert("app_firebase",$data);
	//	echo $ans=$this->db->last_query(); exit;
	}
		
	function firebaseMsgUpdate($data,$id)
	{
		$this->db->where("id", $id);
		$ans=$this->db->update("app_firebase",$data);
	//	$ans =$this->db->last_query();
		//echo $ans; exit;
	    return $ans; 
	}
      
    function getFirebaseMsg($id)
	{
		$ans=$this->db->get_where("app_firebase",array("id"=>$id));
		//$ans =$this->db->last_query();
		//echo $ans; exit;
		if($ans->num_rows()>0)
		{
			return $ans->result();
		}
    }
	
	function del_firebaseDetail($id)
	{
	    $this ->db-> where('id', $id);
        $result = $this ->db-> delete('app_firebase');
	//	$result =$this->db->last_query();
		//echo $result; exit;
		return $result;
	}
	
}