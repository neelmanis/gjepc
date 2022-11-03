<?php
ob_start();
session_start();
include('db.inc.php');
include('functions.php');
if(!isset($_SESSION['USERID'])){ header('location:login.php'); exit; }

extract($_REQUEST);
if(isset($_POST['sub'])){
$registration_id	=	filter($_SESSION['USERID']);
$app_id				=	filter($_REQUEST['app_id']);
 
$region_code	=	filter(getRegion($registration_id,$conn));
$region_email	= 	filter(getRegionEmail($region_code,$conn));
$member_name	=	filter(getMemberName($app_id,$conn));
$email			=	filter(getMemberEmail($app_id,$conn));
$permission_type=   filter(getPermissionType($app_id,$conn));

	if(isset($_FILES['trade_report']))
	{	
		$app_id	=	filter($_POST['app_id']);
		$registration_id = $_SESSION['USERID'];
		//$fob_value=$_POST['fob_value'];
		$sold_amt	=	trim($_POST['sold_amt']);
		$unsold_amt	=	trim($_POST['unsold_amt']);
		$actual_invoice_amt	=	trim($_POST['actual_invoice_amt']);
		$good_description	=	trim($_POST['good_description']);
		
		//$export_region=implode(",",$export_region);
		$specify_country = filter($_POST['specify_country']);
		$latest_trend    = filter($_POST['latest_trend']);
		$future_prospect = filter($_POST['future_prospect']);
		$prob_face		 = filter($_POST['prob_face']);
		$comments		 = filter($_POST['comments']);
		$terms_and_cond  = $_POST['terms_and_cond'];		
		
		$file_name7=$_FILES['trade_report']['name'];
		$file_temp7=$_FILES['trade_report']['tmp_name'];
		$file_type7=$_FILES['trade_report']['type'];
		$file_size7=$_FILES['trade_report']['size'];
		$attach=rand();
			
		if($_FILES['trade_report']['name']!="")
		{
			$report=uploadreportImage($file_name7,$file_temp7,$file_type7,$file_size7,$attach,"report");
		}
		if($report!='')
		{
			
$created_date=date('Y-m-d');	
$sql="update trade_general_info set sold_amt='$sold_amt',unsold_amt='$unsold_amt',actual_invoice_amt='$actual_invoice_amt',good_description='$good_description',specify_country='$specify_country',latest_trend='$latest_trend',future_prospect='$future_prospect',prob_face='$prob_face',comments='$comments',terms_and_cond='$terms_and_cond',app_report_name='$report',app_report_status='P',modified_date='$created_date' where registration_id=$registration_id and app_id=$app_id";
$result = $conn ->query($sql);  
			
if($permission_type=="exhibition") { 
$sqlx = $conn ->query("select exhibition_id from trade_exhibition_info where `app_id` = '$app_id'");
$rowx = $sqlx->fetch_assoc();
$exhibition_id=$rowx['exhibition_id'];

$sql = $conn ->query("select * from trade_exhibition_master where Exhibition_Id=$exhibition_id");
$row = $sql->fetch_assoc();
$exhibition_id=$row['exhibition_id'];
$from_date=$row['From_Date'];
$To_Date=$row['To_Date'];
$exh_name=$row['Exhibition_Name'];
$country=$row['Country'];
			
$message ='<table width="96%" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
		<tr>
		<td style="padding:30px;">
		<table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">		
		<tr>
		<td align="left"><img src="https://gjepc.org/images/gjepc_logon.png" width="238" height="78" /></td>
		</tr>
		<tr><td></td><td align="right"></td></tr>
		<tr><td align="right" colspan="2" height="30px"><hr /></td></tr>
		<tr>
		<td colspan="2" style="font-size:13px; line-height:22px;">
		<p><strong>Report has been submitted  for  '.$exh_name.' (From Date:'.$from_date.' To Date:'.$To_Date.') for below Applicant.</strong></p>
            <p><strong>Applicant Detail</strong> </p>
            <p>Company Name: <strong>'.$member_name.'</strong> </p>
			<p>Email: <strong>'.$email.'</strong> </p>
			<p>Permission Type: <strong>'.$permission_type.'</strong> </p>
		</td>		
		</tr>
		</table>
		</td>		
		</tr>
</table>';
	$to =$region_email;
	$subject = "Trade Application Report For Exhibiton"; 
	$headers  = 'MIME-Version: 1.0' . "\r\n"; 
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
	$headers .= 'From: GJEPC INDIA <admin@gjepc.org>';		
	mail($to, $subject, $message, $headers);

} elseif($permission_type=="promotional_tour") { 
	
$sqlx = $conn ->query("select * from  trade_general_info where `app_id` = '$app_id'");
$rowx = $sqlx->fetch_assoc();
$country=$rowx['visiting_country1'];
$from_date=$rowx['from_date'];
$to_date=$rowx['to_date'];

$message ='<table width="96%" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
		<tr>
		<td style="padding:30px;">
		<table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">		
		<tr>
		<td align="left"><img src="https://gjepc.org/images/gjepc_logon.png" width="238" height="78" /></td>
		</tr>
		<tr><td></td><td align="right"></td></tr>
		<tr><td align="right" colspan="2" height="30px"><hr /></td></tr>
		<tr>
		<td colspan="2" style="font-size:13px; line-height:22px;">
	<p><strong>Report has been submitted  for  Export Promotional Tour to '.$country.'(From Date:'.$from_date.' To Date:'.$to_date.') for below Applicant.</strong></p>
            <p><strong>Applicant Detail</strong> </p>
            <p>Company Name: <strong>'.$member_name.'</strong> </p>
			<p>Email: <strong>'.$email.'</strong> </p>
			<p>Permission Type: <strong>'.$permission_type.'</strong> </p>
		</td>		
		
		</tr>
		</table>
		</td>		
		</tr>
</table>';
	$to =$region_email;
	$subject = "Trade Application Report for Promotional Tour"; 
	$headers  = 'MIME-Version: 1.0' . "\r\n"; 
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
	$headers .= 'From: GJEPC INDIA <admin@gjepc.org>';			
	mail($to, $subject, $message, $headers);	
}
		$_SESSION['form_chk_msg']="Report Submitted Successfully";
			unset($_SESSION['APP_ID']);
			header('location:app.php'); exit;
		}
		else
		{
			$_SESSION['form_chk_msg']="Upload valid report File";
			header('location:app.php');
			exit;
		}
}
}
?>