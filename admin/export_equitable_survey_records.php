<?php
include('../db.inc.php');
include('../functions.php'); 
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
?>


<?php
$table = $display = "";	
$fn = "equitable_survey_report_". date('Ymd');

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td><strong>Company Name</strong></td>
<td><strong>BP number</strong></td>
<td><strong>Option 1</strong></td>
<td><strong>Option 2</strong></td>
<td><strong>Date</strong></td>
</tr>';

$sql="select * from  gjepclivedatabase.equitable_survey group by registration_id order by id ASC";
$result = $conn ->query($sql);
while($row = $result->fetch_assoc())
{	
	$registration_id=$row['registration_id'];
	$company_name = getCompanyNameFromregistration($row['registration_id'], $conn);
	$bp_number = getBPNO($registration_id,$conn);
	if($row['option1']==1)
		$option1="Yes";
	else
		$option1="No";
	
	if($row['option2']==1)
		$option2="Yes";
	else
		$option2="No";
	
	$date = $row['date'];
	
	$table .= '<tr>
	<td>'.$company_name.'</td>
	<td>'.$bp_number.'</td>
	<td>'.$option1.'</td>
	<td>'.$option2.'</td>
	<td>'.$date.'</td>
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