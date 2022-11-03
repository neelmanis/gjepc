<?php
session_start();
include('db.inc.php');

if(isset($_POST['actiontype']) && $_POST['actiontype']=="chkEmail"){
    $email_id= trim($_POST['email_id']);
    $survey_id= trim($_POST['survey_id']);    	 
   
	if(filter_var($email_id, FILTER_VALIDATE_EMAIL)){
	
	$user_query="SELECT * FROM survey_registration WHERE email_id='$email_id' and survey_id='$survey_id'";
    $result_user=mysql_query($user_query);
	$cnt=mysql_num_rows($result_user);
     
    if($cnt==0)
    {		
		$sql = "INSERT INTO survey_registration SET email_id='$email_id',survey_id='$survey_id',status='1'";
		$query=mysql_query($sql);
		if($query){		
			echo json_encode(array("status"=>"success"));
			$_SESSION['email_id']= $email_id;
		} else{
			echo json_encode(array("status"=>"fail"));
		} 
	} else {
	echo json_encode(array("status"=>"exist"));
	}
		  
} else {
		echo json_encode(array("status"=>"invalidEmail"));
}
}
?>