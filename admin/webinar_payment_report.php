<?php 
session_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$adminID = $_SESSION['curruser_login_id'];
?>
<?php

  $webinar_id = trim($_REQUEST['webinar_id']);
  $webinarResult = $conn->query("SELECT title FROM webinar_master WHERE id='$webinar_id'");
  $rowWebinar = $webinarResult->fetch_assoc();
  $title = $rowWebinar['title'];
  $table ="";	
$fn = "Webinar-payment-report";

$table .= '
<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr >
<td style="background:green;color:#fff">Sr. No.</td>
<td style="background:green;color:#fff">Member Type</td>
<td style="background:green;color:#fff">Company Name</td>
<td style="background:green;color:#fff"> Name</td>
<td style="background:green;color:#fff">Email Id </td>
<td style="background:green;color:#fff">Mobile No.</td>
<td style="background:green;color:#fff">Webinar</td>
<td style="background:green;color:#fff">Order id</td>
<td style="background:green;color:#fff">Payment status.</td>
<td style="background:green;color:#fff">Amount</td>
<td style="background:green;color:#fff">Created At</td>

</tr>';
// AND Response_Code='E000'
$sqlExport = "SELECT * FROM webinar_payment_history WHERE webinar_id='$webinar_id' AND webinar_id !='0' ORDER BY created_at DESC ";

$resultExport = $conn->query($sqlExport);
$countExport=$resultExport->num_rows;

if($countExport > 0){
	 $i=0;
	while($rowExport = $resultExport->fetch_assoc()){
       if($rowExport['Transaction_Amount'] > 0 ){
          if($rowExport['payment_status']=='authorized' || $rowExport['payment_status']=='captured' ){
		   	$response = 'Success';
		  } else{
			$response = $rowExport['payment_status'];
		  }
       }else{
           $response =  "success";
       }
		


    $table .= '<tr>
	<td>'.++$i.'</td>
	<td >'.$rowExport['member_type'].'</td>';

        if($rowExport['member_type']=="member"){
        	$mregId = $rowExport['registration_id'];
			$getMInfo =$conn->query("SELECT * FROM  communication_address_master  WHERE registration_id='$mregId' AND type_of_address='2'");
			$resultMInfo = $getMInfo->fetch_assoc();;
			$company_name = getCompanyName($mregId,$conn);
			$email_id = $resultMInfo['email_id'];
			$name = $resultMInfo['name'];
			$mobile_no = $resultMInfo['mobile_no'];
	    	$table .='<td>'.$company_name.'</td>';
	    	$table .='<td>'.$name.'</td>';
	    	$table .='<td>'.$email_id.'</td>';
	    	$table .='<td>'.$mobile_no.'</td>';
    }else{
    	    $nmregId = trim($rowExport['non_member_id']);
            $getNmInfo =$conn->query("SELECT * FROM  webinar_registration_details  WHERE id='$nmregId'"); 
		    $resultNmInfo = $getNmInfo->fetch_assoc();
		    $company_name = $resultNmInfo['company_name'];
		    $email_id = $resultNmInfo['email_id'];
		    $name = $resultNmInfo['name'];
		    $mobile_no = $resultNmInfo['mobile_no'];

    	$table .='<td>'.$company_name.'</td>';
    	$table .='<td>'.$name.'</td>';
    	$table .='<td>'.$email_id.'</td>';
    	$table .='<td>'.$mobile_no.'</td>';
    }

	$table .='<td>'.$title.'</td>
	<td>'.$rowExport['order_id'].'</td>
	
	<td>'.$response.'</td>
	<td>'.$rowExport['Transaction_Amount'].'</td>
	<td>'.$rowExport['created_at'].'</td>
	
	
	<td></tr>';
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