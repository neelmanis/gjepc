<?php
session_start(); 
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
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
$report_name = 'DOWNLOAD SIGNATURE COMBO DATA';
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
  $filename = "ComboSpaceRegistration_" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv;");
  
  $out = fopen("php://output", 'w');
  $flag = false;
  /*$sql="select r.gcode,b.roi,a.id as 'gid', a.uid,a.gst,a.kyc, a.company_name,a.bp_number,a.contact_person, a.contact_person_desg,a.contact_person_co,a.contacts,a.email,a.address1,a.address2,a.address3,a.city,a.pincode,a.billing_address1,a.billing_address2,a.billing_address3,a.bcity,a.bpincode,a.bcountry,a.btelephone_no,a.bfax_no, a.tan_no,a.telephone_no, a.mobile, a.region,a.created_date,b.last_yr_participant,e.last_yr_turn_over, b.options, 
  b.section,b.selected_area,b.selected_premium_type, b.category, c.payment_status,c.document_status,c.application_status,c.created_date,c.bank_acc_no,c.name_bank,c.name_bank_branch,c.ifsc_code,c.int_acc_type,c.document_dissapprove_reason as dissapprove_reason ,c.sales_order_no
  from exh_reg_general_info a inner join exh_registration b on a.id=b.gid inner join exh_reg_payment_details c on a.id=c.gid inner join registration_master r on a.uid=r.id inner join exh_reg_company_details e on a.id=e.gid left join roiapplication x on a.uid=x.uid
  where a.event_for='IIJS Signature 2019'"; */
  //$sql = "SELECT r.gcode,a.id as 'gid', a.uid,a.gst,a.company_name,a.bp_number,x.c_bp_number as 'Billing BP No',a.contact_person, a.contact_person_desg,a.contact_person_co,a.contacts,a.email,a.billing_address_id,a.address1,a.address2,a.address3,a.city,a.pincode,a.billing_address1,a.billing_address2,a.billing_address3,a.bcity,a.bpincode,a.bcountry,a.btelephone_no,a.bfax_no, a.tan_no,a.telephone_no, a.mobile, a.region,a.created_date,b.last_yr_participant,e.last_yr_turn_over, b.options,b.selected_scheme_type,b.section,b.selected_area,b.selected_premium_type, b.category, c.payment_status,c.document_status,c.application_status,c.created_date,c.bank_acc_no,c.name_bank,c.name_bank_branch,c.ifsc_code,c.int_acc_type,c.document_dissapprove_reason as dissapprove_reason ,c.sales_order_no,c.show,c.event_selected,c.isCombo
  //from exh_reg_general_info a inner join exh_registration b on a.id=b.gid inner join exh_reg_payment_details c on a.id=c.gid inner join registration_master r on a.uid=r.id inner join exh_reg_company_details e on a.id=e.gid left join communication_address_master x on a.billing_address_id=x.id
  //where a.year='2019' order by c.event_selected";
  // $sql = "select a.id,a.company_name,a.contact_person,a.region,a.created_date,b.last_yr_participant,a.event_for,a.event_selected,
  //         b.section,b.selected_area,b.selected_premium_type,c.payment_status,c.document_status,c.application_status 
  //         from exh_reg_general_info a inner join exh_registration b on a.id=b.gid inner join exh_reg_payment_details c on a.id=c.gid
  //         where a.event_for='IIJS Signature 2023' OR a.event_for='IIJS TRITIYA 2023'";
  // $sql = "SELECT er.uid,a.company_name,a.contact_person,a.region,c.payment_status,c.document_status,c.application_status,er.`show`,er.created_date 
  //         FROM exh_registration as er 
  //         join exh_reg_general_info as a on er.gid = a.id
  //         join exh_reg_payment_details as c on a.id = c.gid
  //         where  ( er.`show`='IIJS SIGNATURE 2023' OR er.`show`='IIJS TRITIYA 2023' ) and er.isCombo='Y' order by er.created_date";
  $sql = "SELECT a.event_for,r.gcode,a.id as 'gid', a.uid,a.gst,a.company_name,a.bp_number,x.c_bp_number as 'Billing BP No',a.contact_person, a.contact_person_desg_show,a.mobile,a.contact_person_co,a.contact_person_desg,a.contacts,a.email,a.billing_address_id,a.billing_gstin as 'Billing GST',a.address1,a.address2,a.address3,a.city,a.pincode,a.country,a.website,a.billing_address1,a.billing_address2,a.billing_address3,a.bcity,a.bpincode,a.bcountry,a.btelephone_no,a.bfax_no, a.tan_no,a.telephone_no,a.region,a.created_date,b.last_yr_participant,e.last_yr_turn_over, b.options, 
          b.section,b.selected_area,b.selected_premium_type, b.category, b.selected_scheme_type,c.payment_status,c.document_status,c.application_status,c.created_date,c.bank_acc_no,c.name_bank,c.name_bank_branch,c.ifsc_code,c.int_acc_type,c.document_dissapprove_reason as dissapprove_reason ,c.sales_order_no,c.isCombo,
          b.tot_space_cost_rate,b.tot_space_cost_discount,b.get_tot_space_cost_rate,b.get_category_rate,b.selected_premium_rate,b.sub_total_cost,b.security_deposit,b.govt_service_tax,b.grand_total,a.dir_name,a.din_number,a.cin_number,a.iec_number,a.company_type,a.cast
          from exh_reg_general_info a inner join exh_registration b on a.id=b.gid inner join exh_reg_payment_details c on a.id=c.gid inner join registration_master r on a.uid=r.id inner join exh_reg_company_details e on a.id=e.gid left join communication_address_master x on a.billing_address_id=x.id
          where a.event_for='IIJS SIGNATURE 2023' or a.event_for='IIJS TRITIYA 2023'";
  //$result = mysql_query($sql) or die('Query failed!');
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

