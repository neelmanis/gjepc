<?php
include('../db.inc.php'); 
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
?>
<?php  
function getNameCompany($registration_id,$conn)
{
	$sql="SELECT company_name FROM registration_master where id='$registration_id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();			
	return strtoupper($row['company_name']);
}
function visitorName($id,$conn)
{
	$query_visitor = "SELECT name,lname FROM `visitor_directory` WHERE `visitor_id`='$id'";
	$result = $conn->query($query_visitor);
	$row = $result->fetch_assoc(); 		
		return $row['name']." ".$row['lname'];
}
/*
function downloadStatus($id,$conn)
{
	$query_visitor = "SELECT isVerified FROM `globalExhibition` WHERE `visitor_id`='$id' and participant_Type='VIS'";
	$result = $conn->query($query_visitor);
	$row = $result->fetch_assoc(); 		
		return $row['isVerified'];
} */
?>

<?php
$table = $display = "";	
$fn = "pending_disapproved_domestic_vc_report_". date('Ymd');

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>ID</td>
<td>Registration No</td>
<td>Date</td>
<td>Update Date</td>
<td>Company Name</td>
<td>Name</td>
<td>Mobile</td>
<td>PAN</td>
<td>Dose Selected</td>
<td>Dose 1 Status</td>
<td>Dose 1 Certificate</td>
<td>Dose 2 Status</td>
<td>Dose 2 Certificate</td>
<td>Approval Status</td>
<td>Remark</td>
</tr>';

$sql="SELECT * FROM visitor_lab_info WHERE 1 AND category_for='VIS' AND visitor_id IN (SELECT o.visitor_id FROM visitor_order_history o, visitor_lab_info l where o.visitor_id=l.visitor_id AND (o.`show`='iijs22' || o.`show`='signature23' || o.`show`='iijstritiya23' || o.`show`='combo23')) AND approval_status!='Y'";
$result = $conn ->query($sql);
while($row = $result->fetch_assoc())
{	
$registration_id=$row['registration_id'];
$visitor_id = $row['visitor_id'];
$date = date("d-m-Y", strtotime($row['create_date']));
$modifydate = date("d-m-Y", strtotime($row['modified_at']));
$company_name = getNameCompany($registration_id,$conn);

$name = visitorName($visitor_id,$conn);
$mobile=$row['mobile_no'];
$pan_no=$row['pan_no'];
$certificate = $row['certificate'];
$dose1_status = $row['dose1_status'];
$dose2_status = $row['dose2_status'];
$dose1 = $row['dose1'];
$dose2 = $row['dose2'];
$approval_status = $row['approval_status'];
 if($approval_status =="Y"){ $VCSTATUS = "APPROVED"; } 
 else if($approval_status =="P"){ $VCSTATUS = "PENDING"; } 
 else if($approval_status =="N"){ $VCSTATUS = "DISAPPROVED"; }
 else if($approval_status =="U"){ $VCSTATUS = "UPDATED"; }
	 
$remark  =$row['remark'];
//$download = downloadStatus($visitor_id,$conn);

$dose1_certificate = "https://registration.gjepc.org/images/covid/vis/".$registration_id."/vaccine_certificate/".$dose1."";
$dose2_certificate = "https://registration.gjepc.org/images/covid/vis/".$registration_id."/vaccine_certificate/".$dose2."";
					
$table .= '<tr>
<td>'.$registration_id.'</td>
<td>'.$visitor_id.'</td>
<td>'.$date.'</td>
<td>'.$modifydate.'</td>
<td>'.$company_name.'</td>
<td>'.$name.'</td>
<td>'.$mobile.'</td>
<td>'.$pan_no.'</td>
<td>'.$certificate.'</td>
<td>'.$dose1_status.'</td>
<td>'.$dose1_certificate.'</td>
<td>'.$dose2_status.'</td>
<td>'.$dose2_certificate.'</td>
<td>'.$VCSTATUS.'</td>
<td>'.$remark.'</td>
</tr>';
	
}
 $table .= $display;
$table .= '</table>';

		header("Content-type: application/x-msdownload"); 
		# replace excelfile.xls with whatever you want the filename to default to
		header("Content-Disposition: attachment; filename=$fn.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $table;
exit;	
?>