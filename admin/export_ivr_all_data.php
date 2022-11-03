<?php
session_start(); 
ob_start();
include('../db.inc.php');
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
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
  $filename = "IVR_old_registration" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv;");

  $out = fopen("php://output", 'w');

  $flag = false;
 /* $result = mysql_query("SELECT a.`uid`,a.`title`,a.`first_name`,a.`last_name`,a.`designation`,a.`company_name`,a.`office_add`,b.`country_name`,a.`state`,a.`city`,a.`postal_code`,a.`tel_no`,a.`fax_no`,a.`mob_no`,a.`photograph_fid`,a.`email`,a.`application_approved`,CONCAT(a.`personal_info_reason`,a.`photo_reason`,a.`valid_passport_copy_reason`,a.`visiting_card_reason`,a.`nri_photo_reason`) as 'Pending Reason' FROM `ivr_registration_details` a left join country_master b on a.country=b.country_code
WHERE a.`trade_show`='Signature 2015' and a.`application_approved`='Y' order by a.time_stamp desc") or die('Query failed!');*/
 /*$result = mysql_query("SELECT a.`uid`,a.`title`,a.`first_name`,a.`last_name`,a.`designation`,a.`company_name`,a.`office_add`,b.`country_name`,a.`state`,a.`city`,a.`postal_code`,a.`tel_no`,a.`fax_no`,a.`mob_no`,a.`photograph_fid`,a.`email`,a.`application_approved`,CONCAT(a.`personal_info_reason`,a.`photo_reason`,a.`valid_passport_copy_reason`,a.`visiting_card_reason`,a.`nri_photo_reason`) as 'Pending Reason' FROM `ivr_registration_details` a left join country_master b on a.country=b.country_code
WHERE a.`trade_show`='Signature 2015' and a.`application_approved`='N' order by a.time_stamp desc") or die('Query failed!');*/
 $result = mysql_query("SELECT * FROM  `registration_master` WHERE 1 and country !=  'IN' order by post_date desc") or die('Query failed!');
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