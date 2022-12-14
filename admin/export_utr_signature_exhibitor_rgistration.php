<?php
session_start(); 
ob_start();
include('../db.inc.php');
$date=date("d_m_Y");

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

$category = 'EXHIBITOR';
$report_name = 'DOWNLOAD SIGNATURE PAYMENT DATA';
$logs = reportLogs($category,$report_name,$conn);
?>
<?PHP
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
  $filename = "SignatureSpaceRegistration_utr_" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv;");
  
  $out = fopen("php://output", 'w');

  $flag = false;
/*$sql="select r.gcode,b.roi,a.id as 'gid', a.uid,a.gst,a.kyc, a.company_name,a.bp_number,a.contact_person, a.contact_person_desg,a.contact_person_co,a.contacts,a.email,a.address1,a.address2,a.address3,a.city,a.pincode,a.billing_address1,a.billing_address2,a.billing_address3,a.bcity,a.bpincode,a.bcountry,a.btelephone_no,a.bfax_no, a.tan_no,a.telephone_no, a.mobile, a.region,a.created_date,b.last_yr_participant,e.last_yr_turn_over, b.options, 
b.section,b.selected_area,b.selected_premium_type, b.category, c.payment_status,c.document_status,c.application_status,c.created_date,c.bank_acc_no,c.name_bank,c.name_bank_branch,c.ifsc_code,c.int_acc_type,c.document_dissapprove_reason as dissapprove_reason 
from exh_reg_general_info a inner join exh_registration b on a.id=b.gid inner join exh_reg_payment_details c on a.id=c.gid inner join registration_master r on a.uid=r.id inner join exh_reg_company_details e on a.id=e.gid left join roiapplication x on a.uid=x.uid
where a.event_for='IIJS Signature 2019'"; */
/*$sql="select r.gcode,b.roi,a.id as 'gid', a.uid,a.gst,a.kyc, a.company_name,a.bp_number,a.contact_person, a.contact_person_desg,a.contact_person_co,a.contacts,a.email,a.address1,a.address2,a.address3,a.city,a.pincode,a.billing_address1,a.billing_address2,a.billing_address3,a.bcity,a.bpincode,a.bcountry,a.btelephone_no,a.bfax_no, a.tan_no,a.telephone_no, a.mobile, a.region,a.created_date,b.last_yr_participant,
b.category, u.utr_number,u.amountPaid,u.tdsAmount
from exh_reg_general_info a inner join exh_registration b on a.id=b.gid right join utr_history u on a.uid=u.registration_id inner join registration_master r on a.uid=r.id 
where a.event_for='IIJS Signature 2019'"; */

$sql="SELECT a.id,a.company_name, u.show,u.utr_number,u.amountPaid,u.tdsAmount,u.utr_approved,u.utr_date,c.c_bp_number FROM utr_history u, registration_master a,communication_address_master c where u.registration_id=a.id and u.registration_id=c.registration_id and c.type_of_address=2 and u.show='IIJS SIGNATURE 2023'";
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