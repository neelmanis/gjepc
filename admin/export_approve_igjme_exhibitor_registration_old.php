<?php
session_start(); 
ob_start();
include('../db.inc.php');

if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$date=date("d_m_Y");
?>
<?php
  function cleanData(&$str)
  {
    if($str == 't') $str = 'TRUE';
    if($str == 'f') $str = 'FALSE';
    if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
      $str = "'$str";
    }
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }

  // filename for download
  $filename = "IGJME_Space_report_" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv;");
  
  $out = fopen("php://output", 'w');

$flag = false;
$sql = "SELECT a.event_for,r.gcode,a.id as 'gid', a.uid,a.gst,a.company_name,a.bp_number,x.c_bp_number as 'Billing BP No',a.contact_person, a.contact_person_desg_show,a.mobile,a.contact_person_co,a.contact_person_desg,a.contacts,a.email,a.billing_address_id,a.billing_gstin as 'Billing GST',a.address1,a.address2,a.address3,a.city,a.pincode,a.country,a.website,a.billing_address1,a.billing_address2,a.billing_address3,a.bcity,a.bpincode,a.bcountry,a.btelephone_no,a.bfax_no, a.tan_no,a.telephone_no,a.region,a.created_date,b.last_yr_participant,e.last_yr_turn_over, b.options, 
b.section,b.selected_area,b.selected_premium_type, b.category, b.selected_scheme_type,c.payment_status,c.document_status,c.application_status,c.created_date,c.bank_acc_no,c.name_bank,c.name_bank_branch,c.ifsc_code,c.int_acc_type,c.document_dissapprove_reason as dissapprove_reason ,c.sales_order_no,
b.tot_space_cost_rate,b.selected_premium_rate,b.sub_total_cost,b.security_deposit,b.govt_service_tax,b.grand_total
from igjme_exh_reg_general_info a inner join igjme_exh_registration b on a.id=b.gid inner join igjme_exh_reg_payment_details c on a.id=c.gid inner join registration_master r on a.uid=r.id inner join igjme_exh_reg_company_details e on a.id=e.gid left join communication_address_master x on a.billing_address_id=x.id
where a.event_for='IGJME'";
$result = $conn ->query($sql);
while($row = $result->fetch_assoc()) {
    if(!$flag) {
      // display field/column names as first row
      fputcsv($out, array_keys($row), ',', '"');
      $flag = true;
    }
    array_walk($row, 'cleanData');
    fputcsv($out, array_values($row), ',', '"');
  }

  fclose($out);
  exit;
?>

<?php
/*
function getCompanyNonMemBPNO($registration_id,$conn)
{
	$sql="SELECT NM_bp_number FROM registration_master where id='$registration_id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc(); 
	return $row['NM_bp_number'];
}

function getBPNO($registration_id,$conn)
{
	$sql = "SELECT c_bp_number FROM communication_address_master where registration_id='$registration_id' and type_of_address='2'";	
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();  		
	return $row['c_bp_number'];
}

function getBillingBPNO($id,$conn)
{
	$sql = "SELECT c_bp_number FROM `communication_address_master` WHERE `id`='$id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();  		
	return $row['c_bp_number'];
}

$table = $display = "";	
$fn = "IGJME_report";

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>Gcode</td>
<td>GID</td>
<td>UID</td>
<td>Company BP</td>
<td>Billing BP</td>
<td>Company Name</td>
<td>Email</td>
<td>GST</td>
<td>Billing GST</td>
<td>KYC</td>
<td>Tel</td>
<td>Mobile</td>
<td>Contact Person</td>
<td>Designation</td>
<td>Contact Person CO</td>
<td>Contacts</td>
<td>Country</td>
<td>City</td>
<td>Address1</td>
<td>Address2</td>
<td>Address3</td>
<td>Pincode</td>
<td>Fax</td>
<td>Website</td>
<td>Region</td>
<td>Comp Description</td>
<td>Last Year Participant</td>
<td>Last Year Turn Over</td>
<td>Options</td>
<td>Section</td>
<td>Category</td>
<td>Area</td>
<td>Scheme</td>
<td>Premium</td>
<td>Payment Status</td>
<td>Document Status</td>
<td>Application Status</td>
<td>Date</td>
<td>Disapprove Reason</td>
<td>Bank Account</td>
<td>Bank</td>
<td>Branch</td>
<td>IFSC CODE</td>
<td>Account Type</td>
<td>Sales Order</td>
</tr>';

$sql="select a.gcode ,b.id as gid,b.uid,b.company_name,b.billing_address_id,b.email,b.gst,b.kyc,b.telephone_no,b.mobile,b.contact_person,b.contact_person_desg,b.contact_person_co,b.contacts,b.country,b.city,b.address1,b.address2,b.address3,b.pincode,b.fax_no,b.website,b.region,b.billing_gstin,e.comp_desc,c.woman_entrepreneurs,c.last_yr_participant,e.last_yr_turn_over,c.options,c.section,c.category,c.selected_area,c.selected_scheme_type,c.selected_premium_type,d.payment_status,d.document_status,d.application_status,d.created_date,d.document_dissapprove_reason as dissapprove_reason, d.bank_acc_no, d.name_bank, d.name_bank_branch, d.ifsc_code, d.int_acc_type,d.int_bank_acc_no as `international bank account` ,d.int_name_bank as `international bank name`,d.int_name_bank_branch as `int branch name`,d.int_bank_address as `int bank address`,d.int_beneficiary_name as `int beneficiary name`,d.int_swift_code as `int swift code` ,d.int_iban_no as `int iban no`,d.sales_order_no from registration_master a, igjme_exh_reg_general_info b,igjme_exh_registration c,igjme_exh_reg_payment_details d ,igjme_exh_reg_company_details e where b.id=c.gid and b.id=c.gid and b.id=d.gid and b.id=e.gid and a.id=b.uid and c.show='IGJME 2022'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc())
{	
	$registration_id=$row['uid'];
	$schk_membership="SELECT * FROM `approval_master`  WHERE 1 and `registration_id`=".$row['uid'] ." and issue_membership_certificate_expire_status='Y'";
	$qchk_membership=$conn->query($schk_membership);
	$nchk_membership=$qchk_membership->num_rows;;
	$billingBP = getBillingBPNO($row['billing_address_id'],$conn);
	if($nchk_membership>0) { $memberBP = getBPNO($row['uid'],$conn); } else { $memberBP = getCompanyNonMemBPNO($registration_id,$conn); }
			
$table .= '<tr>
<td>'.$row['gcode'].'</td>
<td>'.$row['gid'].'</td>
<td>'.$row['uid'].'</td>
<td>'.$memberBP.'</td>
<td>'.$billingBP.'</td>
<td>'.$row['company_name'].'</td>
<td>'.strtolower($row['email']).'</td>
<td>'.$row['gst'].'</td>
<td>'.$row['billing_gstin'].'</td>
<td>'.$row['kyc'].'</td>
<td>'.$row['telephone_no'].'</td>
<td>'.$row['mobile'].'</td>
<td>'.strtoupper($row['contact_person']).'</td>
<td>'.strtoupper($row['contact_person_desg']).'</td>
<td>'.strtoupper($row['contact_person_co']).'</td>
<td>'.$row['contacts'].'</td>
<td>'.$row['country'].'</td>
<td>'.strtoupper($row['city']).'</td>
<td>'.$row['address1'].'</td>
<td>'.$row['address2'].'</td>
<td>'.$row['address3'].'</td>
<td>'.$row['pincode'].'</td>
<td>'.$row['fax_no'].'</td>
<td>'.$row['website'].'</td>
<td>'.$row['region'].'</td>
<td>'.$row['comp_desc'].'</td>
<td>'.strtoupper($row['last_yr_participant']).'</td>
<td>'.$row['last_yr_turn_over'].'</td>
<td>'.$row['options'].'</td>
<td>'.$row['section'].'</td>
<td>'.$row['category'].'</td>
<td>'.$row['selected_area'].'</td>
<td>'.$row['selected_scheme_type'].'</td>
<td>'.$row['selected_premium_type'].'</td>
<td>'.$row['payment_status'].'</td>
<td>'.$row['document_status'].'</td>
<td>'.$row['application_status'].'</td>
<td>'.$row['created_date'].'</td>
<td>'.$row['document_dissapprove_reason'].'</td>
<td>'.$row['bank_acc_no'].'</td>
<td>'.$row['name_bank'].'</td>
<td>'.$row['name_bank_branch'].'</td>
<td>'.$row['ifsc_code'].'</td>
<td>'.$row['int_acc_type'].'</td>
<td>'.$row['sales_order_no'].'</td>

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
*/
?>