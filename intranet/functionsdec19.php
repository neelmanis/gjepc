<?php
 
include_once("db.inc.php");

function getoptionName($uid)
{
	 $sql_option="select option_name from polloption_master where id=$uid";
	$result_option=mysql_query($sql_option);
	$row_option=mysql_fetch_array($result_option);
	return $row_option['option_name'];
}

function getusername($uid)
{
	$sql="select employee_name from employee_details where id=$uid";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	return $row['employee_name'];
}

function getanswer($q_id)
{
	$sql="select * from poll_master where id=$q_id";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	if($row['c_answer']=='1')
	{
		$c_answer=$row['opt1'];
	}
	else if($row['c_answer']=='2')
	{
		$c_answer=$row['opt2'];
	}
	else if($row['c_answer']=='3')
	{
		$c_answer=$row['opt3'];
	}
	else if($row['c_answer']=='4')
	{
		$c_answer=$row['opt4'];
	}
	
	return $c_answer;
}



function cal($count,$total)
{
	$per = $count/$total*100;
		return $per;
}

function get_profile_pic($id)
{
	  $query="select profile_pic from employee_details where id='$id'";
	$result_query=mysql_query($query);
	$row_query=mysql_fetch_array($result_query);
	//print_r($row_query);
	return $row_query['profile_pic'];
}

function filter_input_string($data)
{
	$data = trim($data);
	$data = filter_var($data,FILTER_SANITIZE_STRING);
	
	return $data;
}

function filter_input_number($data)
{
	$data = trim($data);
	$data = filter_var($data,FILTER_SANITIZE_NUMBER_INT);
	
	return $data;
}

function filter_validate_email($email)
{
	$email = trim($email);
	$e_exp="/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i";
	
	if(preg_match($e_exp,$email))
		return true;
	else
		return false;
	
}
?>