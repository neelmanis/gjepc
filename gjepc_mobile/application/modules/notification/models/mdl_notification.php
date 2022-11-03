<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Mdl_notification extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	function customQuery($mysql_query){
		$query = $this->db->query($mysql_query);
		if($query->num_rows() > 0){
      return $query->result(); 
    }else{
      return "No Data";
    } 
	}
	// 	function listusersAll()
	// {

	// 	$sql = "SELECT * FROM push_notification ORDER BY id DESC";
	// 	$query = $this->db->query($sql);

	// 	// $this->db->select("*");
	// 	// $this->db->from("push_notification");
	// 	// $this->db->order_by("id","DESC");
	// 	// $ans=$this->db->get();
	// 	if($query->num_rows > 0)
	// 	{
	// 		$getUser = $ans->result();
	// 	}
	// 	else
	// 	{
	// 		$getUser = "no";
	// 	}	
	// 	return $getUser;
	// }

	function listusers()
	{
		$this->db->select("*");
		$this->db->from("push_notification");
		// $this->db->where("deviceId","cY4zv2lCTwk:APA91bGjyTf4C-BqvYiAhCxjKaTLzIgXtRtL9ZoH2CpRlha5C-YSCdDzi0CTyBQRIIOBZcL5aryv0YsxHN97lKBiFxUA4zYYWkhbAhkV6j9VrPtu_328xX0oVA_9SGwPoW6IyirhbHd8");
		// $this->db->limit("1");
	    $this->db->where("deviceType","I");
		$this->db->order_by("id","DESC");
		$ans=$this->db->get();
		if($ans->num_rows > 0)
		{
			$getUser = $ans->result();
		}
		else
		{
			$getUser = "no";
		}	
		return $getUser;
	}

	function listusersAndroid()
	{
		$this->db->select("*");
		$this->db->where("deviceType","A");
	 //    $this->db->where("deviceId","fqnRqOdO2_o:APA91bEntR1G0agf3p1YDg5Keu4w-SIpw3_eZ5AluE7HvgtN4iQlvkpEvFN9iSCCHDMIAtS8IfmNppJzxj-W2H-jVWem78GAZquUoJnJ3Lq2vQp-dBKydjY4XD2jtkJIJGnh6zvXch5p");
		// $this->db->limit("1");
	    $this->db->from("push_notification");
		$this->db->order_by("id","DESC");
		$ans=$this->db->get();
		if($ans->num_rows > 0)
		{
			$getUser = $ans->result();
		}
		else
		{
			$getUser = "no";
		}	
		return $getUser;
	}
	function getBadgeCount($deviceId)
	{
		$this->db->select("badgeCount");
		$this->db->from("push_notification");
		$this->db->where("deviceId",$deviceId);
		
		$ans=$this->db->get();
		if($ans->num_rows > 0)
		{
			$getUser = $ans->result();
		}
		else
		{
			$getUser = "no";
		}	
		return $getUser;
	}


	function user_delete($id)
	{
		$this->db->where('id',$id);		
		$this->db->delete("push_notification");
		return 1;
	}
	
	function addDetail($data)
	{
		$this->db->insert("notification_msg",$data);
		//echo $ans=$this->db->last_query(); exit;
	}
 
	function updateBadge($table, $col, $val, $data){
		$this->db->where($col, $val);
		return $this->db->update($table, $data);
	}

}