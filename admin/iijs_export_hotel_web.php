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
  $filename = "hotel_registration_report_" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv;");

  $out = fopen("php://output", 'w');

  $flag = false;
  $result = $conn ->query("SELECT a.`post_date`,a.`applicant_name`,a.`applicant_company_name`,a.`company_pan`,a.`applicant_email_id`,a.`applicant_mobile_no`,b.hotel_name,a.`guest_1`,a.`guest_1_name`,a.`Guest1_Email`,a.`Guest1_Mobile`,a.`guest_2`,a.`guest_2_name`,a.`Guest2_Email`,a.`Guest2_Mobile`,a.`check_in_date`,a.`arrival_date`,a.`arrival_flight_no`,a.`arrival_from`,a.`arrival_time`,a.`check_in_time`,a.`check_out_date`,a.`departure_date`,a.`departure_flight_no`,a.`departure_time`,a.`check_out_time`,a.`departure_from`,a.`credit_card_type`,a.`credit_card_no`,a.`exp_mm`,a.`exp_yyyy` FROM `iijs_hotel_registration_details` a inner join iijs_hotel_master b on a.hotel_id=b.hotel_id order by a.id desc") or die('Query failed!');
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