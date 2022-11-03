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
$report_name = 'DOWNLOAD IIJS PAYMENT INCLUDING NM DATA';
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
  $filename = "IIJS_Space_Registration_utr_" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv;");
  
  $out = fopen("php://output", 'w');

$flag = false;
$sql="SELECT a.id,a.company_name,a.NM_bp_number, u.`show`,u.utr_number as 'Order No',u.razorpay_order_id,u.razorpay_payment_id,u.merchant_order_id,u.order_id,u.method,u.payment_status,u.amountPaid,u.tdsAmount,u.utr_approved,u.utr_date,u.comment FROM registration_master a
LEFT JOIN utr_history u ON u.registration_id = a.id where u.show='IIJS PREMIERE 2022' order by a.company_name";
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