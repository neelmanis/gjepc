<?php
include('../db.inc.php'); 
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
?>
<?php  
function divisionName($registration_id)
{
	$hostname="localhost";
	$uname="appadmin";
	$pwd="#21SAq109@65%n";
	$database="manual_signature";

	$conn1 = new mysqli($hostname, $uname, $pwd, $database);
	if ($conn1->connect_error) {
	die("Connection failed: " . $conn1->connect_error);
	} else {
	}
	$query_visitor = "SELECT Exhibitor_DivisionNo FROM manual_signature.iijs_exhibitor where Exhibitor_Registration_ID='$registration_id'";
	$result = $conn1->query($query_visitor);
	$row = $result->fetch_assoc(); 		
		return $row['Exhibitor_DivisionNo'];
}
?>


<?php
$table = $display = "";	
$fn = "Exhibitor_vaccination_report_". date('Ymd');

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>Sr. No.</td>
<td>Date</td>
<td>Company Name</td>
<td>Division</td>
<td>Visitor Name</td>
<td>Mobile</td>
<td>Dose 1 Status</td>
<td>Dose 2 Status</td>
<td>Approval Status</td>
<td>Remark</td>
<td>Badge Download Status</td>
</tr>';

$sql="SELECT a.*,b.fname,b.company,b.isVerified FROM gjepclivedatabase.visitor_lab_info a,gjepclivedatabase.globalExhibition b where b.participant_Type='EXH' AND a.category_for='EXH' AND a.visitor_id=b.visitor_id";
$result = $conn ->query($sql);
$i=1;
while($row = $result->fetch_assoc())
{	
	$registration_id=$row['registration_id'];
	$visitor_id = $row['visitor_id'];
	$date = date("d-m-Y", strtotime($row['create_date']));
	$name = $row['fname'];
	$company_name = $row['company'];
	$division = divisionName($registration_id);
	$mobile=$row['mobile_no'];
	$pan_no=$row['pan_no'];
	$dose1_status = $row['dose1_status'];
	$dose2_status = $row['dose2_status'];
	$approval_status = $row['approval_status'];
	$remark  =$row['remark'];
	$isVerified = $row['isVerified'];
	
	$table .= '<tr>
	<td>'.$i.'</td>
	<td>'.$date.'</td>
	<td>'.$company_name.'</td>
	<td>'.$division.'</td>
	<td>'.$name.'</td>
	<td>'.$mobile.'</td>
	<td>'.$dose1_status.'</td>
	<td>'.$dose2_status.'</td>
	<td>'.$approval_status.'</td>
	<td>'.$remark.'</td>
	<td>'.$isVerified.'</td>
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