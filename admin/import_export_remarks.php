<?php 
session_start();
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php'); exit; }
$adminID = intval($_SESSION['curruser_login_id']);
include('../db.inc.php');
include('../functions.php');
?>

<?php
$table = $display = "";	

	$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
	
	<tr>
	<td>MEMBERHIP ID</td>
	<td>Firm Name</td>
	<td>Remarks</td>
	</tr>';

	$sqlx = "SELECT * FROM statistics where 1";
	$stmt = $conn ->query($sqlx);
	while($getRows = $stmt->fetch_assoc())
	{
		$getRegistration_id = $getRows['registration_id'];
		$membership_no = $getRows['membership_no'];
		$remark = $getRows['remark'];
		
		$table .= '<tr>
		<td>'.$membership_no.'</td>
		<td>'.getNameCompany($getRegistration_id,$conn).'</td>
		<td>'.$remark.'</td>
		</tr>';
	}
	$table .= $display;
	$table .= '</table>';

	header("Content-type: application/x-msdownload"); 
	# replace excelfile.xls with whatever you want the filename to default to
	header("Content-Disposition: attachment; filename=remarks.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	echo $table;
exit;	
?>