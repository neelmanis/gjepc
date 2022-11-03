<?php
include('../db.inc.php'); 
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
?>
<?php 
function bannerName($id,$conn)
{
	$query_visitor = "SELECT banner_name FROM home_banner_master WHERE 1 and type='web' AND `id`='$id'";
	$result = $conn->query($query_visitor);
	$row = $result->fetch_assoc(); 		
	return $row['banner_name'];
}
?>

<?php
$table = $display = "";	
$fn = "website_banner_report_". date('Ymd');

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>BANNER ID</td>
<td>BANNER NAME</td>
<td>WEBSITE</td>
<td>DATE</td>
<td>IP ADDRESS</td>
<td>BROWSER</td>
</tr>';

$sql="SELECT * FROM banner_hits WHERE 1 ";
$result = $conn ->query($sql);
while($row = $result->fetch_assoc())
{	
$banner_id = $row['banner_id'];
$website = $row['website'];
$post_date = date("d-m-Y", strtotime($row['post_date']));
$banner_name = bannerName($banner_id,$conn);
$ip_address  =$row['ip_address'];
$browser  =$row['browser'];
	
$table .= '<tr>
<td>'.$banner_id.'</td>
<td>'.$banner_name.'</td>
<td>'.$website.'</td>
<td>'.$post_date.'</td>
<td>'.$ip_address.'</td>
<td>'.$browser.'</td>
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