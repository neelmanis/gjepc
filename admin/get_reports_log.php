<?php
session_start(); 
ob_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$curruser_region_id=$_SESSION['curruser_region_id'];
?>

<?php
function reportLogs($category,$report_name,$conn)
{
	$adminID = intval($_SESSION['curruser_login_id']);
	$adminName = strtoupper($_SESSION['curruser_contact_name']);

	$ip = get_client_ip();
	$query = "INSERT INTO report_logs SET post_date=NOW(),admin_id='$adminID',admin_name='$adminName',category='$category',report_name='$report_name',ip='$ip'";
	$result = $conn->query($query);
	if($result)
	{
		return "TRUE";
	} else {
		return "FALSE";
	}
}

$category = 'REPORTS';
$report_name = 'DOWNLOAD REPORTS LOGS';
$logs = reportLogs($category,$report_name,$conn);
?>

<?php
$table = $display = "";	
$fn = "reports_log_". date('Ymd');
$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>DATE</td>
<td>Admin id</td>
<td>ADMIN NAME</td>
<td>CATEGORY</td>
<td>REPORTS</td>
<td>IP</td>
</tr>';

$sql="SELECT * FROM gjepclivedatabase.report_logs;";
$result = $conn ->query($sql);
while($row = $result->fetch_assoc())
{
	$post_date = $row['post_date'];
	$admin_id=$row['admin_id'];
	$admin_name = $row['admin_name'];
	$category = $row['category'];
	$report_name =$row['report_name'];
	$ip=$row['ip'];

$table .= '<tr>
<td>'.$post_date.'</td>
<td>'.$admin_id.'</td>
<td>'.$admin_name.'</td>
<td>'.$category.'</td>
<td>'.$report_name.'</td>
<td>'.$ip.'</td>
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
