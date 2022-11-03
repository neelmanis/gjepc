<?php
include('../db.inc.php'); 
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
?>
<?php  
function getNameCompany($registration_id,$conn)
{
	$sql="SELECT company_name FROM registration_master where id='$registration_id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();			
	return strtoupper($row['company_name']);
}
function visitorName($id,$conn)
{
	$query_visitor = "SELECT name,lname FROM `visitor_directory` WHERE `visitor_id`='$id'";
	$result = $conn->query($query_visitor);
	$row = $result->fetch_assoc(); 		
		return $row['name']." ".$row['lname'];
}


$table = $display = "";	
$fn = "active_badge_report_". date('Ymd');

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>Badge Download Date</td>
<td>Badge ID</td>
<td>Participant Type</td>
<td>Vendor Module Category</td>
<td>Company Name</td>
<td>Name</td>
<td>Mobile</td>
<td>Status</td>

<td>Dose 2 Status</td>
<td>Face Status</td>
<td>Badge Download Status</td>
</tr>';

$sql="SELECT * FROM globalExhibition   order by participant_Type";
$result = $conn ->query($sql);
while($row = $result->fetch_assoc())
{	
	$uniqueIdentifier = $row['uniqueIdentifier'];
	$participant_Type = $row['participant_Type'];
	$agency_category = $row['agency_category'];
	$company_name = $row['company'];
	$name = $row['fname'];
	$mobile=$row['mobile'];
	$status = $row['status'];
	$dose1_status = $row['dose1_status'];
	$dose2_status = $row['dose2_status'];
	$face_status = $row['face_status'];
	$isGenerated = $row['isGenerated'];
	if($isGenerated =="0"){
		$isGenerated ="NO";
	}else{
		$isGenerated = "YES";
	}

	$date = $row['modified_date'];
	
	$table .= '<tr>
	<td>'.$date.'</td>
	<td>'.$uniqueIdentifier.'</td>
	<td>'.$participant_Type.'</td>
	<td>'.$agency_category.'</td>
	<td>'.$company_name.'</td>
	<td>'.$name.'</td>
	<td>'.$mobile.'</td>
	<td>'.$status.'</td>
	<td>'.$dose2_status.'</td>
	
	<td>'.$face_status.'</td>
	<td>'.$isGenerated.'</td>
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