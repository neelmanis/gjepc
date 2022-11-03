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

?>

<?php
$table = $display = "";	
$fn = "domestic_vaccination_report_". date('Ymd');

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>ID</td>
<td>Registration No</td>
<td>Date</td>
<td>Company Name</td>
<td>Name</td>
<td>Mobile</td>
<td>PAN</td>
<td>Dose 1 Status</td>
<td>Dose 2 Status</td>
<td>Approval Status</td>
<td>Remark</td>
<!--<td>Badge Download Status</td>-->
</tr>';

$sql="SELECT * FROM visitor_lab_info WHERE 1 AND lab_name='exh'";
$result = $conn ->query($sql);
while($row = $result->fetch_assoc())
{	
$registration_id=$row['registration_id'];
$visitor_id = $row['visitor_id'];
$date = date("d-m-Y", strtotime($row['create_date']));
$company_name = getNameCompany($registration_id,$conn);

$name = visitorName($visitor_id,$conn);
$mobile=$row['mobile_no'];
$pan_no=$row['pan_no'];
$dose1_status = $row['dose1_status'];
$dose2_status = $row['dose2_status'];
$approval_status = $row['approval_status'];
$remark  =$row['remark'];
//$download = downloadStatus($visitor_id,$conn);
	
$table .= '<tr>
<td>'.$registration_id.'</td>
<td>'.$visitor_id.'</td>
<td>'.$date.'</td>
<td>'.$company_name.'</td>
<td>'.$name.'</td>
<td>'.$mobile.'</td>
<td>'.$pan_no.'</td>
<td>'.$dose1_status.'</td>
<td>'.$dose2_status.'</td>
<td>'.$approval_status.'</td>
<td>'.$remark.'</td>
<!--<td>'.$download.'</td>-->
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