<?php 
session_start(); 
ob_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }

extract($_REQUEST) ;
//print_r($_REQUEST); exit;
$modified_date = date('d-m-Y');
$registration_id=$_REQUEST['registration_id'];
$app_id=$_REQUEST['app_id'];
$adminID=$_SESSION['curruser_login_id'];
$permission_type = getPermissionType($app_id,$conn);

$app_reason=implode("<br/>",$app_reason);
if(nl2br($app_reason)=="other")
	$app_reason_other=$app_reason_other;
else
	$app_reason_other='';
	
$message1 = '';
if($iec_status == "Y"){ $iec_status1='Approved';}
else if($iec_status == "N"){$iec_status1='Disapproved';}
else{$iec_status1='Pending';}

if($member_status == "Y"){$member_status1 = 'Approved';}
else if($member_status == "N"){$member_status1 = 'Disapproved';}
else{$member_status1 = 'Pending';}

if($fair_status == "Y"){$fair_status1 = 'Approved';}
else if($fair_status == "N"){$fair_status1 = 'Disapproved';}
else{$fair_status1 = 'Pending' ;}

if($past_status == "Y"){$past_status1 = "Approved";}
else if($past_status == "N"){$past_status1 = "Disapproved";}
else{$past_status1 = "Pending";}

if($passport_status == "Y"){$passport_status1 = "Approved";}
else if($passport_status == "N"){$passport_status1 = "Disapproved";}
else{$passport_status1 = "" ;}

if($brand_status == "Y"){$brand_status1 = "Approved";}
else if($brand_status == "N"){$brand_status1 = "Disapproved";}
else{$brand_status1 = "Pending";}

if($proof_status == "Y"){$proof_status1 = "Approved";}
else if($proof_status == "N"){$proof_status1 = "Disapproved";}
else{$proof_status1 = "Pending" ;}

if($contract_status == "Y"){ $contract_status1 = "Approved";}
else if($contract_status == "N"){$contract_status1 = "Disapproved";}
else{$contract_status1 = "Pending" ;}

if($application_status==""){$application_status="P";}
if($application_status == "Y"){ $application_status1 = "Approved";$app_reason = "";}
else if($application_status == "P"){$application_status1 = "Pending" ;$app_reason = "" ;}
else if($application_status == "C"){$application_status1 = "Canceled" ;$app_reason = "" ;}
else{$application_status1 = "Disapproved";}

		$sql = "UPDATE `trade_documents` SET 
			        `iec_status`     = '$iec_status',
			        `member_status`     = '$member_status',
			        `fair_status`     = '$fair_status',
			        `past_status`     = '$past_status',
			        `passport_status`     = '$passport_status',
			        `brand_status`     = '$brand_status',
			        `proof_status`     = '$proof_status',
			        `contract_status`     = '$contract_status',
					`copyto`	='$copyto',
					`city`	='$city',
					`signature_authority`='$signature_authority',
					`other_sign`='$other_sign',
					`approved_by`='$approved_by',
					`adminId`='$adminID',
					`modified_date` = '$modified_date'";	
		$sql .= "WHERE `app_id` = '$app_id' LIMIT 1";					
		$query = $conn ->query($sql);

   $sql1 ="UPDATE `trade_general_info` SET `application_status`  = '$application_status',`app_reason` ='$app_reason',`app_reason_other`='$app_reason_other',`adminId`='$adminID',`modified_date` = '$modified_date' WHERE `app_id` = '$app_id' LIMIT 1" ; 
   $ok = $conn ->query($sql1);
   
if($permission_type=="exhibition") { 	
  
$sqlx="select exhibition_id from trade_exhibition_info where `app_id` =  '$app_id'";
$result1= $conn ->query($sqlx);
$rowx = $result1->fetch_assoc();
$exhibition_id=$rowx['exhibition_id'];

$sql	=	"select * from trade_exhibition_master where Exhibition_Id=$exhibition_id";
$result	=	$conn ->query($sql);
$row	=	 $result->fetch_assoc();
$exhibition_id=$row['exhibition_id'];
$from_date=$row['From_Date'];
$To_Date=$row['To_Date'];
$exh_name=$row['Exhibition_Name'];

$sqlx	 =	"select * from trade_general_info where `app_id`='$app_id'";
$resultx = 	$conn ->query($sqlx);
$row	=	 $resultx->fetch_assoc();
//$exhibition_id=$row['exhibition_id'];
$app_reason=$row['app_reason'];
$app_reason_other=$row['app_reason_other'];

$message ='<table border="1" cellpadding="5" cellspacing="5" width="100%">
<thead>
<tr>
    <td colspan="2"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
         <td width="150" align="left"><img src="https://www.gjepc.org/assets/images/logo.png" width="150" height="91" /></td>
          <td width="85%" align="right"></td>
        </tr>
      </table>
	 </td>
  </tr>
<tr>
<tr>
<td colspan="2">
<p>Your application for   '.$exh_name.' (From Date:'.$from_date.' To Date:'.$To_Date.') has been '.$application_status1.'</p>
<p>Reason : <strong>'.$app_reason.'</strong> </p>
<p><strong>'.$app_reason_other.'</strong> </p>
<p>
</td>
</tr>
<td align="center"><strong>Documents</strong></td><td align="center"><strong>Status</strong></td>
</tr>
</thead>
<tbody>
    <tr><td align="center">IEC Copy</td><td align="center">'.$iec_status1.'</td></tr>
    <tr><td align="center">Membership Certificate</td><td align="center">'.$member_status1.'</td></tr>
    <tr><td align="center">Letter Of fair organisation</td><td align="center">'.$fair_status1.'</td></tr>
    <tr><td align="center">Passport photocopy</td><td align="center">'.$passport_status1.'</td></tr>
</tbody>
</table>
</p>

<p>Regards</p>

<p>GJEPC</p>'; 
	
$to =getCommEmail($app_id,$conn);

$subject = "Document and Application Status report for trade application"; 
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: <admin@gjepc.org>' . "\r\n";
// mail($to, $subject, $message, $headers);
$cc = "";		
send_mail($to, $subject, $message, $cc);
} elseif($permission_type=="promotional_tour")  { 
	
$sqlx = "select * from trade_general_info where `app_id` = '$app_id'";
$resultx = 	$conn ->query($sqlx);
$rowx	=	 $resultx->fetch_assoc();
$country=$rowx['visiting_country1'];
$from_date=$rowx['from_date'];
$to_date=$rowx['to_date'];

 $message ='<table border="1" cellpadding="5" cellspacing="5" width="100%">
<thead>
<tr>
    <td colspan="2"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
         <td width="150" align="left"><img src="https://www.gjepc.org/assets/images/logo.png" width="150" height="91" /></td>
          <td width="85%" align="right"></td>
        </tr>
      </table>
	 </td>
  </tr>
<tr>
<tr>
<td colspan="2">
<p>Your application for Export Promotional Tour to  '.$country.' (From Date:'.$from_date.' To Date:'.$To_Date.') has been '.$application_status1.'</p>
<p>Reason : <strong>'.$app_reason.'</strong> </p>
<p><strong>'.$app_reason_other.'</strong> </p>
<p>
</td>
</tr>
<td align="center"><strong>Documents</strong></td><td align="center"><strong>Status</strong></td>
</tr>
</thead>
<tbody>
    <tr><td align="center">IEC Copy</td><td align="center">'.$iec_status1.'</td></tr>
    <tr><td align="center">Membership Certificate</td><td align="center">'.$member_status1.'</td></tr>
    <tr><td align="center">Letter Of fair organisation</td><td align="center">'.$fair_status1.'</td></tr>
    <tr><td align="center">Passport photocopy</td><td align="center">'.$passport_status1.'</td></tr>
</tbody>
</table>
</p>

<p>Regards</p>

<p>GJEPC</p>'; 

	 $to =getCommEmail($app_id,$conn); 
	$subject = "Trade Application"; 
	$headers  = 'MIME-Version: 1.0' . "\r\n"; 
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
	$headers .= 'From:admin@gjepc.org';			
	// mail($to, $subject, $message, $headers);
	$cc = "";		
	send_mail($to, $subject, $message, $cc);
	
}

header("location:manage_trade_permission.php?action=view");
?>