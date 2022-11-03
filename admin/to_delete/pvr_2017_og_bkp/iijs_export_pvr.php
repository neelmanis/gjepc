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
  $filename = "PVR_" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv;");

  $out = fopen("php://output", 'w');

  $flag = false;
  $result = mysql_query("SELECT `id`,`uid` ,`privilege_code`,`contact_person`,`designation`,`company_name`,`address1`,`address2`,`address3`,`city`,`pincode`,`state`,`telephone_no_office`,`telephone_no_resi`,`fax_no`,`mobile`,`email`,`photo_image`,`participate_for_show`,`participation_year`,`payment_made_for`,participation_fee,`payment_mode`,`drawn_on_bank`,`branch_of_bank`,`branch_city`,`branch_postal`,`cheque_dd_no`,`cheque_dd_dt`,`transaction_id`,`transaction_details`,`transaction_date`,`information_approve`,`information_reason`,`payment_approve`,`payment_reason`,`photo_approval`,`photo_reson`,`created_dt` FROM `pvr_registration_details` WHERE 1 and `participate_for_show`='IIJS' and `participation_year`=2016 and `application_status`=1 order by id desc") or die('Query failed!');
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

