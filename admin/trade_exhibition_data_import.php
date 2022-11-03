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

$category = 'TRADE PERMISSION';
$report_name = 'DOWNLOAD ALL APPLICATION';
$logs = reportLogs($category,$report_name,$conn);
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
  $filename = "TradeExhibition_" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv;");

  $out = fopen("php://output", 'w');

$flag = false;
$x="(select Exhibition_Name from trade_exhibition_master where Exhibition_Id=b.exhibition_id) as `Exhibition Name`";
$y="(select From_Date from trade_exhibition_master where Exhibition_Id=b.exhibition_id) as `From_Date`";
$z="(select To_Date from trade_exhibition_master where Exhibition_Id=b.exhibition_id) as `To_Date`";
$m="(select Organizer_Address from trade_exhibition_master where Exhibition_Id=b.exhibition_id) as `Organizer_Address`";
$n="(select Venue_Address  from trade_exhibition_master where Exhibition_Id=b.exhibition_id) as `Venue_Address`";
$c="(select Country from trade_exhibition_master where Exhibition_Id=b.exhibition_id) as `Country`";


 /*$sql="select a.membership_id,a.member_name as `Company Name`,a.commemail,permission_type,a.region_code,a.application_status,a.application_date,a.app_report_status,
c.indian_pavilion,a.bank_name,a.actual_invoice_amt,a.unsold_amt,a.sold_amt,$x,$y,$z,$m,$n from 
trade_general_info a left join trade_exhibition_info b on a.app_id=b.app_id left join trade_documents c on a.app_id=c.app_id where a.registration_id =c.registration_id  and a.app_id=c.app_id";*/

$sql="select a.*,
c.indian_pavilion,a.bank_name,a.actual_invoice_amt,a.unsold_amt,a.sold_amt,$x,$y,$z,$m,$n,$c from 
trade_general_info a left join trade_exhibition_info b on a.app_id=b.app_id left join trade_documents c on a.app_id=c.app_id where a.registration_id =c.registration_id  and a.app_id=c.app_id and a.`application_status`='Y'";

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

