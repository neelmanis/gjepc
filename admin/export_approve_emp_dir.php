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
  $filename = "APPROVED_EMP_DIR_" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv;");

  $out = fopen("php://output", 'w');

  $flag = false;
  $sql = "select vd.post_date, rm.company_name, vd.registration_id,vd.bp_number, vd.shows, vd.year, vd.name, vd.lname, vd.degn_type, vd.gender, vd.mobile, vd.email, vd.aadhar_no, vd.pan_no, vd.photo, vd.salary_slip_copy, vd.pan_copy, vd.partner, vd.visitor_approval, vd.disapprove_reason from visitor_directory vd inner join registration_master rm on vd.registration_id = rm.id where vd.visitor_approval='Y' and vd.status = '1'";
  $result = mysql_query($sql);
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

