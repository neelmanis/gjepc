<?php
session_start(); 
ob_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$curruser_region_id=$_SESSION['curruser_region_id'];
?>

<?php
function reportLogs($category,$report_name,$conn)
{
	$adminID = intval($_SESSION['curruser_login_id']);
	$adminName = strtoupper($_SESSION['curruser_contact_name']);
	$ip = $_SERVER['REMOTE_ADDR'];
	$query = "INSERT INTO report_logs SET post_date=NOW(),admin_id='$adminID',admin_name='$adminName',category='$category',report_name='$report_name',ip='$ip'";
	$result = $conn->query($query);
	if($result)
	{
		return "TRUE";
	} else {
		return "FALSE";
	}
}

$category = 'MEMBERSHIP';
$report_name = 'Membership Approval Logs';
$logs = reportLogs($category,$report_name,$conn);
?>

<?php
$table = $display = "";	
$fn = "membership_approval_log_". date('Ymd');
$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>Registration No</td>
<td>BP No</td>
<td>Company Name</td>
<td>Type of Firm</td>
<td>Information Approval</td>
<td>Document Approval</td>
<td>Payment Approval</td>
<td>RCMC Approval</td>
<td>Membership Type</td>
<td>Date of Establishment</td>
<td>By Admin</td>
<td>Membership Apply Date</td>
<td>Membership Payment Date</td>
<td>Membership Issue Date</td>
<td>Admin Issue Date</td>
</tr>';

$sql="SELECT d.registration_id, t.`type_of_firm_name` as 'Type of Firm',c.`company_name`, a.`Response_Code`,a.`ReferenceNo`,a.`Unique_Ref_Number`,a.`post_date`,a.`Transaction_Date`,a.total_payable,b.`c_bp_number`,b.`landline_no1`,b.`mobile_no`,a.`sales_order_no`,c.region_id,c.year_of_starting_bussiness,d.information_approve,d.document_approve,d.payment_approve,d.rcmc_certificate_approve,d.rcmc_certificate_disapprove_reason,d.adminId,d.`issue_membership_certificate_expire_status` as 'Issued Membership Certificate',d.membership_certificate_type,d.invoice_date,if(c.member_type_id = '5', 'Merchant','Manufacturer') as 'Member Type',admin_issue_date  FROM `challan_master` a,`communication_address_master` b , `information_master` c ,`approval_master` d,type_of_firm_master t WHERE a.`registration_id`=b.`registration_id` and a.`registration_id`=c.`registration_id` and a.`registration_id`=d.`registration_id` and c.type_of_firm=t.sap_value and a.`challan_financial_year`='2022' and b.type_of_address='2' and a.`Response_Code`='E000'";
if($_SESSION['curruser_role']=="Admin")
{
  $sql.=" and c.region_id='".$_SESSION['curruser_region_id']."' ";
}

$result = $conn ->query($sql);
while($row = $result->fetch_assoc())
{
	$registration_id=$row['registration_id'];
	$c_bp_number=$row['c_bp_number'];
	$company_name=$row['company_name'];
	$type_of_firm=$row['Type of Firm'];
	$information_approve=$row['information_approve'];
	$document_approve=$row['document_approve'];
	$payment_approve=$row['payment_approve'];
	$rcmc_certificate_approve=$row['rcmc_certificate_approve'];
	$membership_certificate_type=$row['membership_certificate_type'];
	$adminId=$row['adminId'];
	$membershipApplyDate=$row['post_date'];
	$Transaction_Date=$row['Transaction_Date'];
	$invoice_date=$row['invoice_date'];
	$admin_issue_date=$row['admin_issue_date'];
	$year_of_starting_bussiness=$row['year_of_starting_bussiness'];

$table .= '<tr>
<td>'.$registration_id.'</td>
<td>'.$c_bp_number.'</td>
<td>'.$company_name.'</td>
<td>'.$type_of_firm.'</td>
<td>'.$information_approve.'</td>
<td>'.$document_approve.'</td>
<td>'.$payment_approve.'</td>
<td>'.$rcmc_certificate_approve.'</td>
<td>'.$membership_certificate_type.'</td>
<td>'.$year_of_starting_bussiness.'</td>
<td>'.getAdminName($adminId,$conn).'</td>
<td>'.$membershipApplyDate.'</td>
<td>'.$Transaction_Date.'</td>
<td>'.$invoice_date.'</td>
<td>'.$admin_issue_date.'</td>
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
