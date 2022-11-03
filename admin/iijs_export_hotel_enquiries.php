<?php
session_start(); 
ob_start();
include('../db.inc.php');
$date=date("d_m_Y");
?>

<?php
$table = $display = "";	
$fn = "IIJS_HOTEL_ENQUIRIES". date('Ymd');

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>Category</td>
<td>Name</td>
<td>Mobile </td>
<td>Company name </td>
<td>City</td>
<td>State</td>
<td>Hotel</td>
<td>Hotel Link</td>
<td>Create Date</td>


</tr>';

$sql="SELECT * FROM `iijs_hotels_enquiry` where 1 order by create_date desc";
$result = $conn ->query($sql);
while($row = $result->fetch_assoc())
{
	
	
	$table .= '<tr>	
<td>'.$row['category'].'</td>
<td>'.$row['name']." ".$row['lname'].'</td>
<td>'.$row['mobile'].'</td>
<td>'.$row['company_name'].'</td>
<td>'.$row['city'].'</td>
<td>'.$row['state'].'</td>
<td>'.$row['hotel'].'</td>
<td>'.$row['hotel_link'].'</td>
<td>'.$row['create_date'].'</td>


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

