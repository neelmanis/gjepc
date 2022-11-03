<?php
session_start(); 
ob_start();
include('../db.inc.php');
$date=date("d_m_Y");
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
  $filename = "SpaceRegistration_" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv;");

  $out = fopen("php://output", 'w');

  $flag = false;
  $sql="select a.gcode ,b.id as gid,b.uid,b.company_name,b.email,b.telephone_no,b.mobile,b.contact_person,b.contact_person_desg,b.contact_person_co as `Contact Person For Show Coordination`,b.contacts,b.country,b.city,b.address1,b.address2,b.address3,b.pincode,b.fax_no,b.website,b.region,c.woman_entrepreneurs,c.last_yr_participant,e.last_yr_turn_over,c.options,c.section,c.category,c.selected_area,c.selected_scheme_type,c.selected_premium_type,d.payment_status,d.document_status,d.application_status,d.created_date,d.document_dissapprove_reason as dissapprove_reason, d.bank_acc_no, d.name_bank, d.name_bank_branch, d.ifsc_code, d.int_acc_type, e.comp_desc from registration_master a, exh_reg_general_info b,exh_registration c,exh_reg_payment_details d ,exh_reg_company_details e where b.id=c.gid and b.id=c.gid and b.id=d.gid and b.id=e.gid and a.id=b.uid and c.show='IIJS 2017'";
  
  
  $result = mysql_query($sql) or die('Query failed!');
  while(false !== ($row = mysql_fetch_assoc($result))) {
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

