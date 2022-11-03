<?php
session_start(); 
ob_start();
include('../db.inc.php');
$date=date("d_m_Y");
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
  $filename = "IGJME_SpaceRegistration_utr_" . date('Ymd') . ".csv";
  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv;");
  $out = fopen("php://output", 'w');
  $flag = false;

$sql="SELECT a.id,a.company_name, u.utr_number,u.amountPaid,u.tdsAmount,u.utr_approved,u.utr_date FROM igjme_utr_history AS u inner JOIN registration_master AS a ON u.registration_id=a.id AND `show`='IGJME 2022'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc())
{
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