<?php
include('../db.inc.php'); 
//include('../functions.php'); 
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
function getVisitorMobile($id,$conn)
{
	$query_sel = "SELECT mobile FROM visitor_directory where visitor_id='$id' ";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['mobile'];
}
function getVisitorPAN($id,$conn)
{
	$query_sel = "SELECT pan_no FROM visitor_directory where visitor_id='$id' ";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['pan_no'];
}
function getRegion($registration_id,$conn)
{
	$query_sel = "SELECT region_id FROM  information_master  where registration_id='$registration_id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();			
	return $row['region_id'];
}
function CheckMembership($registration_id,$conn)
{
	$sql="SELECT * FROM `approval_master` WHERE 1 and `registration_id`='".$registration_id."' AND issue_membership_certificate_expire_status='Y'";
	$result = $conn->query($sql);
	$num_rows=  $result->num_rows;
	if($num_rows>0)
	{
		return 'M';
	} else {
		return 'NM';
	}
}
function getRegionName($id,$conn)
{
	$query_sel = "SELECT region FROM state_master where state_code='$id'";
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
		return $row['region'];
	
}
?>

<?php
$table = $display = "";	
$fn = "pending_domestic_vaccination_report_". date('Ymd');

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>ID</td>
<td>Registration No</td>
<td>Date</td>
<td>Company Name</td>
<td>Name</td>
<td>Mobile</td>
<td>Pan</td>
<td>Amount</td>
<td>Region</td>

</tr>';

 $sql="SELECT *
FROM visitor_order_history
WHERE visitor_id NOT IN
    (SELECT visitor_id 
     FROM visitor_lab_info WHERE category_for='VIS' OR category_for='IGJME') AND `show`='iijs21' and `year`='2021'";


$result = $conn ->query($sql);
while($row = $result->fetch_assoc())
{	
$registration_id=$row['registration_id'];
$visitor_id = $row['visitor_id'];

	$getAddress ="SELECT * FROM `registration_master` WHERE `id` = '$registration_id'";
		$getAddressResult = $conn ->query($getAddress);
$getAddressRow = $getAddressResult->fetch_assoc();

$date = date("d-m-Y", strtotime($row['create_date']));
 $company_name = getNameCompany($registration_id,$conn);
 $name = visitorName($visitor_id,$conn);

 $mobile = getVisitorMobile($visitor_id,$conn);
$pan_no=getVisitorPAN($visitor_id,$conn);

 
$membership = CheckMembership($registration_id,$conn);

$region=strtoupper(getRegionName($getAddressRow['state'],$conn));
$table .= '<tr>
<td>'.$registration_id.'</td>
<td>'.$visitor_id.'</td>
<td>'.$date.'</td>
<td>'.$company_name.'</td>
<td>'.$name.'</td>
<td>'.$mobile.'</td>
<td>'.$pan_no.'</td>
<td>'.$row['amount'].'</td>
<td>'.$region.'</td>
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