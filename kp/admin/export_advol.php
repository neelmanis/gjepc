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
  $filename = "ADVOL_PAYMENT_REPORT_" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv;");

  $out = fopen("php://output", 'w');

  $flag = false;
  
$sql = "SELECT b.EXPORT_APP_ID,b.PAYMENT_MST_ID,c.KP_CERT_NO,a.MEMBERTYPE,a.APPLICANT_ID,a.APPLICANT_NAME,a.advol_transaction_date as 'Transaction Date',a.advol_exchange_rate as 'Advol Exchange Rate',a.advol_amount as 'Advol Amount',a.tds_tax as 'TDS Tax %',a.tds_amount as 'TDS Amount',a.advol_net_payable_amount as 'Net Payable Amount',a.advol_ReferenceNo FROM  `kp_payment_master` a,kp_payment_details b, kp_export_application_master c where a.PAYMENT_MST_ID=b.PAYMENT_MST_ID and b.EXPORT_APP_ID=c.EXPORT_APP_ID and a.advol_exchange_rate!='' order by b.EXPORT_APP_ID";
$result = $conn ->query($sql) or die('Query failed!');
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
