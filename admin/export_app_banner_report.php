<?php
include('../db.inc.php'); 
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
?>

<?php
$table = $display = "";	
$fn = "app_banner_report_". date('Ymd');

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>BANNER Link</td>
<td>VIA</td>
<td>DATE</td>
</tr>';

$sql="SELECT * FROM advertise_banner_click_manager WHERE 1 AND platform!='web' AND platform!=''";
$result = $conn ->query($sql);
while($row = $result->fetch_assoc())
{	
$link = $row['link'];
$platform = $row['platform'];
$post_date = date("d-m-Y", strtotime($row['created_at']));
$ip_address  =$row['ip_address'];
$browser  =$row['browser'];
	
$table .= '<tr>
<td>'.$link.'</td>
<td>'.$platform.'</td>
<td>'.$post_date.'</td>
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