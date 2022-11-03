<?php 
session_start();
include('../db.inc.php');
include('../functions.php');
// if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
// $adminID = $_SESSION['curruser_login_id'];
?>
<?php
function getOccasionName($occasion_id,$conn)
{
	$query_sel = "SELECT * FROM  promo_video_demo_master  where id='$occasion_id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
	$occasion =  $row['occasion'];
	$language_id =  $row['language_id'];
	
	$query_sel2 = "SELECT * FROM  promo_video_language_master  where id='$language_id'";
	$result2 = $conn->query($query_sel2);
	$row2 = $result2->fetch_assoc(); 		
	$language =  $row2['language'];

	return $occasion.'-'.$language;

}
  function getCity($reg_id,$conn)
{
	$query_sel = "SELECT * FROM  registration_master  where id='$reg_id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
	return $row['city'];
	
	

}
  $webinar_id = trim($_REQUEST['webinar_id']);
  $webinarResult = $conn->query("SELECT title FROM webinar_master WHERE id='$webinar_id'");
  $rowWebinar = $webinarResult->fetch_assoc();
  $title = $rowWebinar['title'];
  $table ="";	
$fn = "Promo-video-payment-report";

$table .= '
<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr >
<td style="background:green;color:#fff">Sr. No.</td>

<td style="background:green;color:#fff">Company Name</td>
<td style="background:green;color:#fff">Order Id</td>
<td style="background:green;color:#fff"> Name</td>
<td style="background:green;color:#fff">Email Id </td>
<td style="background:green;color:#fff">Mobile No.</td>
<td style="background:green;color:#fff">City</td>
<td style="background:green;color:#fff">Address</td>
<td style="background:green;color:#fff">Occasions</td>
<td style="background:green;color:#fff">Order id</td>
<td style="background:green;color:#fff">Ref No.</td>
<td style="background:green;color:#fff">Response Code.</td>
<td style="background:green;color:#fff">Response.</td>
<td style="background:green;color:#fff">Amount</td>
<td style="background:green;color:#fff">Created At</td>

</tr>';
// AND Response_Code='E000'
$sqlExport = "SELECT * FROM promo_video_payment_history  ORDER BY created_at DESC ";

$resultExport = $conn->query($sqlExport);
$countExport=$resultExport->num_rows;

if($countExport > 0){
	 $i=0;
	while($rowExport = $resultExport->fetch_assoc()){
       if($rowExport['Transaction_Amount'] > 0 ){
          if($rowExport['Response_Code']=='E00335'){
		 $response = 'Cancelled by User';
		}elseif($rowExport['Response_Code']=='E000'){ 
			$response ="success";
		}elseif($rowExport['Response_Code']=='E00314'){
		 $response="Failed";
		}else if($rowExport['Response_Code']=='E00329'){
			$response = 'NEFT';
		}elseif($rowExport['Response_Code']==''){
			$response='Aborted';
		}
       }else{
       	$response ="Failed";
       }
       $registration_id = $rowExport['registration_id'];

      $ChkMember = $conn->query("SELECT * FROM approval_master WHERE registration_id='$registration_id' AND issue_membership_certificate_expire_status='Y'");
      $memberCount = $ChkMember->num_rows; 
      if($memberCount>0){
      	$type = "Member";
      }else{
      	$type = "Non-member";
      }

      $city = getCity($registration_id,$conn);
		


    $table .= '<tr>
	<td>'.++$i.'</td>';


	$table .='<td>'.getCompanyNameFromregistration($registration_id,$conn).'</td>
	<td>'.$rowExport['order_id'].'</td>
	<td>'.$rowExport['name'].'</td>
	<td>'.$rowExport['email_id'].'</td>
	<td>'.$rowExport['mobile_no'].'</td>
	<td>'.$city.'</td>
	<td>'.$rowExport['address'].'</td>';
	$table .='<td>';
     foreach(explode(",",$rowExport['occasion']) as $val){
	    	$table .=getOccasionName($val,$conn).'<br>';
	    } 
	$table .='</td>';
	$table .='
	<td>'.$rowExport['order_id'].'</td>
	<td>'.$rowExport['ReferenceNo'].'</td>
	<td>'.$rowExport['Response_Code'].'</td>
	<td>'.$response.'</td>
	<td>'.$rowExport['Transaction_Amount'].'</td>
	<td>'.$rowExport['created_at'].'</td>
	
	
	</tr>';
	}

}else{
	$table .= '
	<tr>
	<td colspan="8">  Payments Not Found</td>
	</tr>';
}
	
	$table .= '</table>';

		header("Content-type: application/x-msdownload"); 
		# replace excelfile.xls with whatever you want the filename to default to
		header("Content-Disposition: attachment; filename=$fn.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $table;
		exit;
	
?>