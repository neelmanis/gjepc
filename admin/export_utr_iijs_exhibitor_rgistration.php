<?php
session_start(); 
ob_start();
include('../db.inc.php');
$date=date("d_m_Y");

function reportLogs($category,$report_name,$conn)
{
	$adminID = intval($_SESSION['curruser_login_id']);
	$adminName = strtoupper($_SESSION['curruser_contact_name']);
	$ip = get_client_ip();
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
$report_name = 'DOWNLOAD IIJS PAYMENT DATA';
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
  $filename = "IIJS_Space_Registration_Payment_" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv;");
  
  $out = fopen("php://output", 'w');

$flag = false;
//$sql="SELECT a.id,a.company_name,c.c_bp_number, u.`show`,u.utr_number as 'Order No',u.razorpay_order_id,u.payment_date,u.razorpay_payment_id,u.merchant_order_id,u.order_id,u.method,u.payment_status,u.amountPaid,u.tdsAmount,u.utr_approved,u.utr_date,u.comment FROM utr_history u, registration_master a,communication_address_master c where u.registration_id=a.id and u.registration_id=c.registration_id and c.type_of_address=2 and u.show='IIJS PREMIERE 2022'";
$sql="SELECT a.id,a.company_name,c.c_bp_number, u.`show`,u.utr_number as 'Order No',u.razorpay_order_id,u.payment_date,u.razorpay_payment_id,u.merchant_order_id,u.order_id,u.method,u.payment_status,u.amountPaid,u.tdsAmount,u.utr_approved,u.utr_date,u.comment 
FROM utr_history u left join registration_master a 
ON u.registration_id=a.id
LEFT join communication_address_master c
ON u.registration_id=c.registration_id where c.type_of_address=2 and u.show='IIJS PREMIERE 2022' AND u.payment_status='captured' group by u.utr_number";
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