<?php
include('../db.inc.php'); 
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
?>
<?php  
function category_name($visitor_id,$conn)
{
	$sql="SELECT category FROM visitor_agency_registration where id='$visitor_id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();			
	if($row['category']=="CM")
		return "Committee";
	else if($row['category']=="C")
		return "Chairman";
	else if($row['category']=="VC")
		return "Vice-Chairman";
	else if($row['category']=="CO")
		return "Convener";
	else if($row['category']=="CC")
		return "Co-Convener";
	else if($row['category']=="CM")
		return "Committee Member";
	else if($row['category']=="COA")
		return "Committee Member";
	else if($row['category']=="O")
		return "Organizer";
	else if($row['category']=="OA")
		return "Official Agency";
	else if($row['category']=="G")
		return "Guest";
	else if($row['category']=="VV")
		return "VVIP";
	else if($row['category']=="VIP")
		return "VIP";
	else if($row['category']=="P")
		return "Press";
	else strtoupper($row['category']);
}
function visitorName($id,$conn)
{
	$query_visitor = "SELECT person_name FROM `visitor_agency_registration` WHERE `id`='$id'";
	$result = $conn->query($query_visitor);
	$row = $result->fetch_assoc(); 		
		return $row['person_name'];
}
?>

<?php
$table = $display = "";	
$fn = "Agency_vaccination_report_". date('Ymd');

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>Sr. No.</td>
<td>Date</td>
<td>Category Name</td>
<td>Name</td>
<td>Mobile</td>
<td>Dose 1 Status</td>
<td>Dose 2 Status</td>
<td>Approval Status</td>
<td>Remark</td>
</tr>';

$sql="SELECT * FROM gjepclivedatabase.visitor_lab_info where category_for='CONTR'";
$result = $conn ->query($sql);
$i=1;
while($row = $result->fetch_assoc())
{	
$registration_id=$row['registration_id'];
$visitor_id = $row['visitor_id'];
$date = date("d-m-Y", strtotime($row['create_date']));
$category_name=category_name($visitor_id,$conn);
$name = visitorName($visitor_id,$conn);
$mobile=$row['mobile_no'];
$pan_no=$row['pan_no'];
$dose1_status = $row['dose1_status'];
$dose2_status = $row['dose2_status'];
$approval_status = $row['approval_status'];
$remark  =$row['remark'];
	
$table .= '<tr>
<td>'.$i.'</td>
<td>'.$date.'</td>
<td>'.$category_name.'</td>
<td>'.$name.'</td>
<td>'.$mobile.'</td>
<td>'.$dose1_status.'</td>
<td>'.$dose2_status.'</td>
<td>'.$approval_status.'</td>
<td>'.$remark.'</td>
</tr>';
$i++;	
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