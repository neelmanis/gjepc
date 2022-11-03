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
	$query_visitor = "SELECT first_name,last_name FROM `ivr_registration_details` WHERE `eid`='$id'";
	$result = $conn->query($query_visitor);
	$row = $result->fetch_assoc(); 		
		return $row['first_name']." ".$row['last_name'];
}

function getAdminName($id,$conn)
{
	$query_sel = "SELECT `contact_name` FROM `admin_master` WHERE id='$id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
	return $row['contact_name'];
}
?>

<?php
$table = $display = "";	
$fn = "intl_vaccination_report_". date('Ymd');

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>ID</td>
<td>Registration No</td>
<td>Date</td>
<td>Update Date</td>
<td>Company Name</td>
<td>Name</td>
<td>Email</td>
<td>Dose Selected</td>
<td>Dose 1 Status</td>
<td>Dose 2 Status</td>
<td>Approval Status</td>
<td>Remark</td>
<td>Admin</td>
</tr>';

$sql="SELECT * FROM visitor_lab_info WHERE 1 AND category_for='INTL'";
$result = $conn ->query($sql);
while($row = $result->fetch_assoc())
{	
$registration_id=$row['registration_id'];
$visitor_id = $row['visitor_id'];
$date = date("d-m-Y", strtotime($row['create_date']));
$modifydate = date("d-m-Y", strtotime($row['modified_at']));
$company_name = getNameCompany($registration_id,$conn);

$name = visitorName($visitor_id,$conn);
$email=$row['email'];
$certificate = $row['certificate'];
$dose1_status = $row['dose1_status'];
$dose2_status = $row['dose2_status'];
$approval_status = $row['approval_status'];
 if($approval_status =="Y"){ $VCSTATUS = "APPROVED"; } 
 else if($approval_status =="P"){ $VCSTATUS = "PENDING"; } 
 else if($approval_status =="N"){ $VCSTATUS = "DISAPPROVED"; }
 else if($approval_status =="U"){ $VCSTATUS = "UPDATED"; }
$remark  =$row['remark'];
$admin  = getAdminName($row['adminId'],$conn);
	
$table .= '<tr>
<td>'.$registration_id.'</td>
<td>'.$visitor_id.'</td>
<td>'.$date.'</td>
<td>'.$modifydate.'</td>
<td>'.$company_name.'</td>
<td>'.$name.'</td>
<td>'.$email.'</td>
<td>'.$certificate.'</td>
<td>'.$dose1_status.'</td>
<td>'.$dose2_status.'</td>
<td>'.$VCSTATUS.'</td>
<td>'.$remark.'</td>
<td>'.$admin.'</td>
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