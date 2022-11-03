<?php 
include ("db.inc.php");
include ("functions.php");
session_start();

	
$actiontype = $_POST['actiontype'];
if($actiontype == 'send_otp'){
	$mobile_no = trim($_REQUEST['mobile_no']);
	//$mobile_no = "7498949490";
	$datetime = date("Y-m-d H:i:s");
	$otp = rand(1000,9999); // generate OTP	
	$message = "One Time Password is.".$otp;
	$otp_sendStatus = get_data($message,$mobile_no);
	if(true){
		$getMobile = "SELECT mobile_no FROM gdfilm_mobile_verfication WHERE mobile_no='$mobile_no'";
		$getMobileResult = mysql_query($getMobile);
		$countMobile = mysql_num_rows($getMobileResult);
		 if($countMobile>0){
		 $UpdateMobileOtp = mysql_query("UPDATE gdfilm_mobile_verfication SET otp='$otp',verified ='0',modifiedDate='$datetime' WHERE mobile_no='$mobile_no'");
		 }else{
		   $InsertMobileOtp = mysql_query("INSERT INTO gdfilm_mobile_verfication SET mobile_no='$mobile_no',otp='$otp',verified ='0',post_date='$datetime'");
		 }
		$data = array("status"=>'success',"mobile_no"=>"$mobile_no");
	}else{
		$data['status'] = 'error';
	}
	echo json_encode($data);
}
if($actiontype == 'verify_otp'){
	$mobile_no = trim($_REQUEST['mobile_no']);
	//$mobile_no = "7498949490";
	$otp_number = trim($_REQUEST['otp_number']);
	$post_date = date("Y-m-d H:i:s");
    $sql  = "SELECT * FROM gdfilm_mobile_verfication WHERE otp='$otp_number' AND mobile_no='$mobile_no'";
    $result = mysql_query($sql); 
    $count = mysql_num_rows($result);
    if($count==1){
    	$otpUpdate = "UPDATE gdfilm_mobile_verfication SET verified='1', modifiedDate='$post_date' WHERE otp='$otp_number' AND mobile_no='$mobile_no'";
    $otpUpdateResult = mysql_query($otpUpdate);
    $data = array("status"=>'success');
    }else{
    $data = array("status"=>'fail');
    }
    echo json_encode($data); 	
}

?>