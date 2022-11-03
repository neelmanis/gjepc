<?php
include('../db.inc.php'); 
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
?>
<?php  
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
$fn = "domestic_vaccination_report_". date('Ymd');

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>Category</td>
<td>ID</td>
<td>Registration No</td>
<td>Date</td>
<td>Mobile</td>
<td>PAN</td>
<td>Dose 1 Status</td>
<td>Dose 2 Status</td>
<td>Approval Status</td>
<td>Admin</td>
</tr>';

$sql="SELECT * FROM visitor_lab_info WHERE 1 AND (category_for='VIS' || category_for='IGJME')";
$result = $conn ->query($sql);
while($row = $result->fetch_assoc())
{	
$registration_id=$row['registration_id'];
$visitor_id = $row['visitor_id'];
$uploadAdminId = $row['uploadAdminId'];
$category_for = $row['category_for'];
$date = date("d-m-Y", strtotime($row['create_date']));
$admin_name = getAdminName($uploadAdminId,$conn);

$mobile=$row['mobile_no'];
$pan_no=$row['pan_no'];
$dose1_status = $row['dose1_status'];
$dose2_status = $row['dose2_status'];
$approval_status = $row['approval_status'];
$remark  =$row['remark'];

	
$table .= '<tr>
<td>'.$category_for.'</td>
<td>'.$registration_id.'</td>
<td>'.$visitor_id.'</td>
<td>'.$date.'</td>
<td>'.$mobile.'</td>
<td>'.$pan_no.'</td>
<td>'.$dose1_status.'</td>
<td>'.$dose2_status.'</td>
<td>'.$approval_status.'</td>
<td>'.$admin_name.'</td>
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