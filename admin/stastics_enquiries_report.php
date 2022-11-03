<?php
session_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php');exit; }

$table = $display = "";	
$fn = "statistics-enquiries-report";

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>Name</td>
<td>Organisation name</td>
<td>Designation </td>
<td>Email </td>
<td>Country </td>
<td>Mobile </td>
<td>Member </td>
<td>Become a Member </td>
<td>Purpose </td>
<td>Notification</td>
<td>Visit Count</td>
<td>Timestamp </td>
</tr>';

$stmt = $conn ->query("SELECT * FROM statistics_visitors WHERE 1 order by created_date DESC");
while($rec =$stmt->fetch_assoc())
{
  $table .= '<tr>
<td>'.$rec['name'].'</td>
<td>'.$rec['org_name'].'</td>
<td>'.$rec['degn'].'</td>
<td>'.$rec['email'].'</td>
<td>'.getCountryName($rec['country'],$conn).'</td>
<td>'.$rec['mobile'].'</td>
<td>'.$rec['isMember'].'</td>
<td>'.$rec['wantMember'].'</td>
<td>'.$rec['purpose'].'</td>
<td>'.$rec['isNotification'].'</td>
<td>'.$rec['visitCount'].'</td>

<td>'.$rec['created_date'].'</td>

</tr>'; 
}
$table .= $display;
$table .= '</table>';

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$fn.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $table;
?>