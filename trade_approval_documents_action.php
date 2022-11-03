<?php 
ob_start();
session_start(); 
include('db.inc.php');
include('functions.php');
//print_r($_POST);
$registration_id=$_SESSION['USERID'];
$app_id = $_SESSION['APP_ID'];
$Indian_pavilion = isset($_REQUEST['Indian_pavilion'])?Y:N;
$terms_and_cond =isset($_REQUEST['terms_and_cond'])?Y:N;
$shipment_city=$_REQUEST['shipment_city'];
$iec_no_copy = $_REQUEST['iec_no_copy'];
$member_cer = $_REQUEST['member_cer'];
$fair_org = $_REQUEST['fair_org'];
$past_org = $_REQUEST['past_org'];
$passport = $_REQUEST['passport'];
$brand_cer = $_REQUEST['brand_cer'];
$proof_authenticity = $_REQUEST['proof_authenticity'];
$contract_with = $_REQUEST['contract_with'];


$region_code=getRegion($registration_id,$conn);
$region_email= getRegionEmail($region_code,$conn);
$member_name=getMemberName($app_id,$conn);
$email=getMemberEmail($app_id,$conn);
$permission_type=getPermissionType($app_id,$conn);

if(isset($_FILES['upload1']) && $_FILES['upload1']['name']!="")
		{
			$file_name1=$_FILES['upload1']['name'];
			$file_temp1=$_FILES['upload1']['tmp_name'];
			$file_type1=$_FILES['upload1']['type'];
			$file_size1=$_FILES['upload1']['size'];
			$attach=rand();
			if($_FILES['upload1']['name']!="")
			{
			$iec_no_upload=uploadtradeImage($file_name1,$file_temp1,$file_type1,$file_size1,$attach,"ieccopy");
			}
		}else
		{
			$iec_no_upload='';
		}

		if(isset($_FILES['upload2']) && $_FILES['upload2']['name']!="")
		{
			 $file_name2=$_FILES['upload2']['name'];
			$file_temp2=$_FILES['upload2']['tmp_name'];
			$file_type2=$_FILES['upload2']['type'];
			$file_size2=$_FILES['upload2']['size'];
			$attach=rand();
			if($_FILES['upload2']['name']!="")
			{
				$member_cer_upload=uploadtradeImage($file_name2,$file_temp2,$file_type2,$file_size2,$attach,"member_cer_copy");
			}
		}else
		{
			$member_cer_upload='';
		}


	if(isset($_FILES['upload3']) && $_FILES['upload3']['name']!="")
		{
			 $file_name3=$_FILES['upload3']['name'];
			$file_temp3=$_FILES['upload3']['tmp_name'];
			$file_type3=$_FILES['upload3']['type'];
			$file_size3=$_FILES['upload3']['size'];
			$attach=rand();
			if($_FILES['upload3']['name']!="")
			{
				 $fair_org_upload=uploadtradeImage($file_name3,$file_temp3,$file_type3,$file_size3,$attach,"fair_org_copy");
			}
		}else
		{
			$fair_org_upload='';
		}

		if(isset($_FILES['upload4']) && $_FILES['upload4']['name']!="")
		{
			 $file_name4=$_FILES['upload4']['name'];
			$file_temp4=$_FILES['upload4']['tmp_name'];
			$file_type4=$_FILES['upload4']['type'];
			$file_size4=$_FILES['upload4']['size'];
			$attach=rand();
			if($_FILES['upload4']['name']!="")
			{
				$past_org_upload=uploadtradeImage($file_name4,$file_temp4,$file_type4,$file_size4,$attach,"past_org_copy");
			}
		}else
		{
			$past_org_upload='';
		}
		
		if(isset($_FILES['upload5']) && $_FILES['upload5']['name']!="")
		{
			 $file_name5=$_FILES['upload5']['name'];
			$file_temp5=$_FILES['upload5']['tmp_name'];
			$file_type5=$_FILES['upload5']['type'];
			$file_size5=$_FILES['upload5']['size'];
			$attach=rand();
			if($_FILES['upload5']['name']!="")
			{
				$passport_upload=uploadtradeImage($file_name5,$file_temp5,$file_type5,$file_size5,$attach,"passport_copy");
			}
		}else
		{
			$passport_upload='';
		}

		if(isset($_FILES['upload6']) && $_FILES['upload6']['name']!="")
		{
			 $file_name6=$_FILES['upload6']['name'];
			$file_temp6=$_FILES['upload6']['tmp_name'];
			$file_type6=$_FILES['upload6']['type'];
			$file_size6=$_FILES['upload6']['size'];
			$attach=rand();
			if($_FILES['upload6']['name']!="")
			{
				$brand_cer_upload=uploadtradeImage($file_name6,$file_temp6,$file_type6,$file_size6,$attach,"brand_cer_copy");
			}
		}else
		{
			$brand_cer_upload='';
		}
		
		if(isset($_FILES['upload7']) && $_FILES['upload7']['name']!="")
		{
			 $file_name7=$_FILES['upload7']['name'];
			$file_temp7=$_FILES['upload7']['tmp_name'];
			$file_type7=$_FILES['upload7']['type'];
			$file_size7=$_FILES['upload7']['size'];
			$attach=rand();
			if($_FILES['upload7']['name']!="")
			{
				$proof_authenticity_upload=uploadtradeImage($file_name7,$file_temp7,$file_type7,$file_size7,$attach,"proof_authenticity_copy");
			}
		}else
		{
			$proof_authenticity_upload='';
		}
		
		if(isset($_FILES['upload8']) && $_FILES['upload8']['name']!="")
		{
			$file_name8=$_FILES['upload8']['name'];
			$file_temp8=$_FILES['upload8']['tmp_name'];
			$file_type8=$_FILES['upload8']['type'];
			$file_size8=$_FILES['upload8']['size'];
			$attach=rand();
			if($_FILES['upload8']['name']!="")
			{
				$contract_with_upload=uploadtradeImage($file_name8,$file_temp8,$file_type8,$file_size8,$attach,"contract_with_copy");
			}
		}else
		{
			$contract_with_upload='';
		}
$created_date=date('Y-m-d');

$getDoc = $conn ->query("select * from trade_documents where app_id='$app_id'");
$num = $getDoc->num_rows;

if($num==0)
{
	$sql="insert into trade_documents(app_id,registration_id,indian_pavilion,terms_and_cond,shipment_city,iec_no_copy,iec_no_upload,member_cer,member_cer_upload,fair_org,fair_org_upload,past_org,past_org_upload,passport,passport_upload,brand_cer,brand_cer_upload,proof_authenticity,proof_authenticity_upload,contract_with,contract_with_upload,created_date,modified_date) values ('$app_id','$registration_id','$Indian_pavilion','$terms_and_cond','$shipment_city','$iec_no_copy','$iec_no_upload','$member_cer','$member_cer_upload','$fair_org','$fair_org_upload','$past_org','$past_org_upload','$passport','$passport_upload','$brand_cer','$brand_cer_upload','$proof_authenticity','$proof_authenticity_upload','$contract_with','$contract_with_upload','$created_date','$created_date')";
	$resultx = $conn ->query($sql);   
    if (!$resultx) die ($conn->error);
		
if($permission_type=="exhibition") { 	
$sqlx = $conn ->query("select exhibition_id from trade_exhibition_info where `app_id` = '$app_id'");
$rowx = $sqlx->fetch_assoc();
$exhibition_id=$rowx['exhibition_id'];

$sqly = $conn ->query("select * from trade_exhibition_master where Exhibition_Id=$exhibition_id");
$row = $sqly->fetch_assoc();
$exhibition_id=$row['exhibition_id'];
$from_date=$row['From_Date'];
$To_Date=$row['To_Date'];
$exh_name=$row['Exhibition_Name'];

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
		<p><strong>Kindly find the below details of  '.$exh_name.' (From Date:'.$from_date.' To Date:'.$To_Date.')</strong></p>
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
	 $subject = "Trade Application";
	 $headers  = 'MIME-Version: 1.0' . "\n"; 
	 $headers .= 'Content-type: text/html; charset=iso-8859-1'. "\n"; 
	 $headers .= 'From: GJEPC INDIA <admin@gjepc.org>';			
	 mail($to, $subject, $message, $headers);
} elseif($permission_type=="promotional_tour")  { 
	
$sqlx = $conn ->query("select * from trade_general_info where `app_id` = '$app_id'");
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
	<p><strong>Kindly find below details of  Export Promotional Tour to '.$country.'(From Date:'.$from_date.' To Date:'.$to_date.').</strong></p>
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
	 $subject = "Trade Application";
	 $headers  = 'MIME-Version: 1.0' . "\n"; 
	 $headers .= 'Content-type: text/html; charset=iso-8859-1'. "\n"; 
	 $headers .= 'From: GJEPC INDIA <admin@gjepc.org>';			
	 mail($to, $subject, $message, $headers);
	
}
	unset($_SESSION['APP_ID']);
	header('location:app.php');
}
else
{
	$sql="update trade_documents set indian_pavilion='$Indian_pavilion',terms_and_cond='$terms_and_cond',shipment_city='$shipment_city',iec_no_copy='$iec_no_copy',member_cer='$member_cer',fair_org='$fair_org',past_org='$past_org',passport='$passport',brand_cer='$brand_cer', proof_authenticity='$proof_authenticity',contract_with='$contract_with'";
	
	if($iec_no_upload!='')
		$sql.=" ,iec_no_upload='$iec_no_upload'";
	if($member_cer_upload!='')
		$sql.=" ,member_cer_upload='$member_cer_upload'";	
	if($fair_org_upload!='')
		$sql.=" ,fair_org_upload='$fair_org_upload'";
	if($past_org_upload!='')
		$sql.="  ,past_org_upload='$past_org_upload'";
	if($passport_upload!='')
		$sql.=" ,passport_upload='$passport_upload'";
	if($brand_cer_upload!='')
		$sql.="  ,brand_cer_upload='$brand_cer_upload'";
	if($proof_authenticity_upload!='')
		$sql.=" ,proof_authenticity_upload='$proof_authenticity_upload'";
	if($contract_with_upload!='')
		$sql.=" ,contract_with_upload='$contract_with_upload'";
	
	$sql.=" ,modified_date='$created_date' where app_id='$app_id' and registration_id='$registration_id'";
	$quert = $conn ->query($sql);
	
	if($permission_type=="exhibition") {
	
$sqlx = $conn ->query("select exhibition_id from trade_exhibition_info where `app_id` = '$app_id'");
$rowx = $sqlx->fetch_assoc();
$exhibition_id=$rowx['exhibition_id'];

$sqlm = $conn ->query("select * from trade_exhibition_master where `Exhibition_Id`= '$exhibition_id'");
$row = $sqlm->fetch_assoc();
$exhibition_id=$row['exhibition_id'];
$from_date=$row['From_Date'];
$To_Date=$row['To_Date'];
$exh_name=$row['Exhibition_Name'];

$message ='<table width="96%" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
		<tr>
		<td style="padding:30px;">
		<table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">		
		<tr>
		<td align="left"><img src="http://www.gjepc.org/images/indo_gjepc_logo.png" width="238" height="78" /></td>
		</tr>
		<tr><td></td><td align="right"></td></tr>
		<tr><td align="right" colspan="2" height="30px"><hr /></td></tr>
		<tr>
		<td colspan="2" style="font-size:13px; line-height:22px;">
		<p><strong>Kindly find revised application details of '.$exh_name.' (From Date:'.$from_date.' To Date:'.$To_Date.')</strong></p>
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
	$cc="";
	$subject = "Trade Application"; 
	$headers  = 'MIME-Version: 1.0' . "\r\n"; 
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
	$headers .= 'From:admin@gjepc.org';			
	mail($to, $subject, $message, $headers);
	
} elseif($permission_type=="promotional_tour") { 

$sqlx =  $conn ->query("select * from trade_general_info where `app_id` = '$app_id'");
$rowx = $result->fetch_assoc();
$country=$rowx['visiting_country1'];
$from_date=$rowx['from_date'];
$to_date=$rowx['to_date'];

$message ='<table width="96%" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
		<tr>
		<td style="padding:30px;">
		<table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">		
		<tr>
		<td align="left"><img src="http://www.gjepc.org/images/indo_gjepc_logo.png" width="238" height="78" /></td>
		</tr>
		<tr><td></td><td align="right"></td></tr>
		<tr><td align="right" colspan="2" height="30px"><hr /></td></tr>
		<tr>
		<td colspan="2" style="font-size:13px; line-height:22px;">
		<p><strong>Kindly find revised application details of Export Promotional Tour to '.$country.' (From Date:'.$from_date.' To Date:'.$to_date.')  . </strong></p>
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
	$subject = "Trade Application"; 
	$headers  = 'MIME-Version: 1.0' . "\r\n"; 
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
	$headers .= 'From:admin@gjepc.org';			
	mail($to, $subject, $message, $headers);
}
	unset($_SESSION['APP_ID']);
	header('location:app.php');
	exit;
}
?>