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
?>

<?php
$table = $display = "";	
$fn = "domestic_vc_report_notApplied". date('Ymd');

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>ID</td>
<td>Registration No</td>
<td>Date</td>
<td>Company Name</td>
<td>Name</td>
<td>Mobile</td>
<td>PAN</td>
</tr>';

$sql="SELECT visitor_id,registration_id,create_date FROM visitor_order_history where 1 AND `show`='signature22' AND visitor_id NOT IN (SELECT visitor_id FROM visitor_lab_info WHERE 1 AND category_for='VIS')";
$result = $conn ->query($sql);
while($row = $result->fetch_assoc())
{	
$registration_id=$row['registration_id'];
$visitor_id = $row['visitor_id'];
$paymentDate = date("d-m-Y", strtotime($row['create_date']));
$company_name = getNameCompany($registration_id,$conn);

$name = visitorName($visitor_id,$conn);
$mobile = getVisitorMobile($visitor_id,$conn);
$pan_no = getVisitorPAN($visitor_id,$conn);
				
$table .= '<tr>
<td>'.$registration_id.'</td>
<td>'.$visitor_id.'</td>
<td>'.$paymentDate.'</td>
<td>'.$company_name.'</td>
<td>'.$name.'</td>
<td>'.$mobile.'</td>
<td>'.$pan_no.'</td>
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