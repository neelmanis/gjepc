<?php
session_start();
include('../db.inc.php');
include('../functions.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php');exit; }

$table = $display = "";	
$fn = "variable-documents-report";

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>Company Name</td>
<td>Area</td>
<td>Document Name</td>

<td>Status </td>
<td>Remarks</td>
<td>Action By</td>
</tr>';

/*$stmt=mysql_query('SELECT id, vendor_id, area_id,  document_name, remarks, action_by, status
FROM area_spec_doc_upload
UNION 
SELECT id, vendor_id,area_id, document_name, remarks, action_by, status
FROM vendor_document_uploads ORDER BY vendor_id DESC');*/
$stmt = $conn ->query("select a.vendor_id,a.area_id,a.document_name,a.status,a.remarks,a.action_by from area_spec_doc_upload a join vendor_area_registration b on a.vendor_id=b.vendor_id where a.area_id= b.area_id ");
while($rec =$stmt->fetch_assoc())
{
  $table .= '<tr>
<td>'.getVendorCompanyName($rec['vendor_id'],$conn).'</td>
<td>'.getVendorAreaName($rec['area_id'],$conn).'</td>
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