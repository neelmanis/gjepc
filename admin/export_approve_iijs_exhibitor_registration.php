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
$report_name = 'DOWNLOAD IIJS ALL DATA';
$logs = reportLogs($category,$report_name,$conn);
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
  $filename = "Space_Registration_IIJS_" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv;");

  $out = fopen("php://output", 'w');

  $flag = false;
 /* $sql="select a.gcode ,b.id as gid,b.uid,b.company_name,b.email,b.membership_id,b.membership_date,b.gst,b.tan_no,b.kyc,b.telephone_no,b.mobile,b.contact_person,b.contact_person_desg,b.contact_person_co as `Contact Person For Show Coordination`,b.contacts,b.country,b.city,b.address1,b.address2,b.address3,b.pincode,b.fax_no,b.website,b.region,c.woman_entrepreneurs,c.last_yr_participant,e.last_yr_turn_over,c.options,c.section,c.category,c.selected_area,c.selected_scheme_type,c.selected_premium_type,d.payment_status,d.document_status,d.application_status,d.created_date,d.document_dissapprove_reason as dissapprove_reason, d.bank_acc_no, d.name_bank, d.name_bank_branch, d.ifsc_code, d.int_acc_type,d.tds_holder,d.cheque_tds_gross_amount,d.cheque_tds_per,d.cheque_tds_amount,d.cheque_tds_Netamount,d.cheque_tds_deducted, e.comp_desc from registration_master a, exh_reg_general_info b,exh_registration c,exh_reg_payment_details d ,exh_reg_company_details e where b.id=c.gid and b.id=c.gid and b.id=d.gid and b.id=e.gid and a.id=b.uid and c.show='IIJS 2019'";  
  */
  $sql = "select a.id as 'gid', a.uid,a.gst,a.company_name,a.company_type,a.pan_no,a.dir_name as 'DIRECTOR/PROPRIETOR',a.din_number,a.cin_number,a.iec_number,a.cast,a.bp_number,x.c_bp_number as 'Billing BP No',a.contact_person, a.contact_person_desg_show,a.contact_person_co,a.contact_person_desg,a.contacts,a.email,a.address1,a.address2,a.address3,a.city,a.pincode,a.billing_gstin as 'Billing GSTIN',a.billing_address1,a.billing_address2,a.billing_address3,a.bcity,a.bpincode,a.bcountry,a.btelephone_no,a.bfax_no, a.tan_no,a.telephone_no, a.mobile, a.region,a.website,a.fax_no,a.created_date,b.last_yr_participant,e.last_yr_turn_over, b.options,b.woman_entrepreneurs, 
b.section,b.selected_area,b.selected_premium_type,b.tot_space_cost_rate,b.tot_space_cost_discount,b.get_tot_space_cost_rate,b.get_category_rate, b.selected_scheme_rate,b.selected_premium_rate,b.sub_total_cost,b.security_deposit,b.govt_service_tax,b.grand_total,b.category,b.selected_scheme_type, c.cheque_tds_amount,c.payment_status,c.document_status,c.application_status,c.created_date,c.bank_acc_no,c.name_bank,c.name_bank_branch,c.ifsc_code,c.int_acc_type,c.document_dissapprove_reason as dissapprove_reason ,c.sales_order_no
from exh_reg_general_info a inner join exh_registration b on a.id=b.gid inner join exh_reg_payment_details c on a.id=c.gid inner join registration_master r on a.uid=r.id inner join exh_reg_company_details e on a.id=e.gid left join communication_address_master x on a.billing_address_id=x.id
where a.event_for='IIJS PREMIERE 2022'";
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