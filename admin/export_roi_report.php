<?php
include('../db.inc.php');
include('../functions.php');
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }

function getNameRegion($registration_id,$conn)
{
	$sql="SELECT state FROM registration_master where id='$registration_id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();			
	return $row['state'];
}
?>

<?php
$table = $display = "";	
$fn = "roi_report_". date('Ymd');

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>Event Name</td>
<td>Company Name</td>
<td>SO NO</td>
<td>HO BP NO</td>
<td>Billing BP NO</td>
<td>Region</td>
<td>Contact Person Name</td>
<td>Contact Person Designation</td>
<td>Contact Person Email</td>
<td>Contact Person Mobile_no</td>
<td>Section</td>
<td>Selected Area</td>
<td>Tot Space cost</td>
<td>Govt Service Tax</td>
<td>Grand Total</td>
<td>Application Status</td>
</tr>';

$sql="SELECT * FROM roi_space_registration WHERE  1 and event_name='iijstritiya22' order by post_date desc";
$result = $conn ->query($sql);
while($row = $result->fetch_assoc())
{	
	if($row['member_type']=="MEMBER")
		$bpno=getBPNO($row['registration_id'],$conn);
	else
		$bpno = getCompanyNonMemBPNO($row['registration_id'],$conn);
		$billingBP = getBillingBPNO($row['billing_address_id'],$conn);
		
	$registration_id=$row['registration_id'];
	$event_name=$row['event_name'];
	$company_name = getNameCompany($registration_id,$conn);
	//$region = getRegion($registration_id,$conn);
	$getState = getNameRegion($registration_id,$conn);
	$region = gotStateRegionName($getState,$conn); 
	$contact_person_name=$row['contact_person_name'];
	$contact_person_designation=$row['contact_person_designation'];
	$contact_person_email = $row['contact_person_email'];
	$contact_person_mobile_no = $row['contact_person_mobile_no'];
	$section = $row['section'];
	$selected_area  =$row['selected_area'];
	$tot_space_cost_rate  =$row['tot_space_cost_rate'];
	$govt_service_tax  =$row['govt_service_tax'];	
	$grand_total  =$row['grand_total'];
	$application_status  =$row['application_status'];
	$sales_order_no  =$row['sales_order_no'];
	
	$table .= '<tr>
	<td>'.$event_name.'</td>
	<td>'.$company_name.'</td>
	<td>'.$sales_order_no.'</td>
	<td>'.$bpno.'</td>
	<td>'.$billingBP.'</td>
	<td>'.$region.'</td>
	<td>'.$contact_person_name.'</td>
	<td>'.$contact_person_designation.'</td>
	<td>'.$contact_person_email.'</td>
	<td>'.$contact_person_mobile_no.'</td>
	<td>'.$section.'</td>
	<td>'.$selected_area.'</td>
	<td>'.$tot_space_cost_rate.'</td>
	<td>'.$govt_service_tax.'</td>
	<td>'.$grand_total.'</td>
	<td>'.$application_status.'</td>
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