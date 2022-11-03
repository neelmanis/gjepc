<?php 
session_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php');exit; }

$table = $display = "";	
$fn = "Common-documents-report";

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>Company Name</td>
<td>Document Name</td>
<td>Status </td>
<td>Remarks</td>
<td>Action By</td>
</tr>';

$stmt = $conn ->query("select a.status,a.vendor_id,a.document_name,a.remarks,a.action_by from vendor_document_uploads a join vendor_area_registration b on a.vendor_id=b.vendor_id");
while($rec = $stmt->fetch_assoc())
{
  $table .= '<tr>
<td>'.getVendorCompanyName($rec['vendor_id'],$conn).'</td>
<td>'.$rec['document_name'].'</td>
<td>'.$rec['status'].'</td>
<td>'.$rec['remarks'].'</td>
<td>'.$rec['action_by'].'</td>
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