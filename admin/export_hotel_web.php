<?php
session_start(); 
ob_start();
include('../db.inc.php');
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
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
  $filename = "hotel_registration_web_" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv;");

  $out = fopen("php://output", 'w');

  $flag = false;
  $result = $conn ->query("SELECT a.`id`,a.`applicant_name`,a.`applicant_company_name`,a.`applicant_email_id`,a.`applicant_mobile_no`,a.`applicant_country`,a.`applicant_state`,a.`guest_name`,a.`guest_company_name`,a.`guest_email_id`,a.`guest_mobile_no`,a.`guest_country`,a.`guest_city`,b.hotel_name,c.room_name,a.`no_of_room`,a.`sharer_name`,a.`check_in_date`,a.`arrival_date`,a.`arrival_flight_no`,a.`arrival_from`,a.`arrival_time`,a.`check_in_time`,a.`check_out_date`,a.`departure_date`,a.`departure_flight_no`,a.`departure_from`,a.`departure_time`,a.`check_out_time`,a.`total_payable`,a.`credit_card_type`,a.`credit_card_no`,a.`exp_mm`,a.`exp_yyyy` FROM `hotel_registration_details` a inner join iijs_hotel_master b on a.hotel_id=b.hotel_id inner join iijs_hotel_details c on a.hotel_details_id=c.hotel_details_id order by a.id asc") or die('Query failed!');
  
 
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
