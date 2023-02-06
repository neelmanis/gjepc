<?php
session_start(); 
ob_start();
include('../db.inc.php');

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

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

$category = 'VISITOR';
$report_name = 'VISITOR Approved Data 1May';
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
  $filename = "APPROVED_EMP_DIR_" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv;");

  $out = fopen("php://output", 'w');

  $flag = false;
 
  $sql = "SELECT vd.mod_date AS 'Date', rm.id AS 'Company Registration ID',rm.company_name AS 'Company Name',rm.company_pan_no AS 'Company PAN',rm.company_gstn AS 'Company GSTIN', rm.email_id,rm.address_line1,rm.address_line2,rm.city,sm.state_name,sm.region,rm.pin_code,rm.land_line_no,rm.mobile_no, vd.name, vd.lname, vd.degn_type,vd.designation, vd.gender, vd.mobile, vd.email, vd.pan_no,vd.visitor_approval,
if(vd.visitor_approval='Y','APPROVED', if(vd.visitor_approval='D','DISAPPROVED','UPDATED')) AS Status,
vd.adminId,am.contact_name, vd.disapprove_reason from visitor_directory vd inner join registration_master rm on vd.registration_id = rm.id 
 left join state_master sm on sm.state_code = rm.state 
 left join admin_master am on am.id = vd.adminId
 where vd.status = '1' AND vd.mod_date between '2022-05-01' AND CURDATE() order by vd.mod_date";
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
  
  
  /* overAll Approved Data
  select rm.id,rm.company_name,rm.company_pan_no,rm.company_gstn,rm.email_id,rm.address_line1,rm.address_line2,rm.city,rm.state,sm.state_name,sm.region,rm.pin_code,rm.land_line_no,rm.mobile_no, vd.registration_id,vd.bp_number, vd.shows, vd.year, vd.name, vd.lname, vd.degn_type,vd.designation, vd.gender, vd.mobile, vd.email, vd.aadhar_no, vd.pan_no, vd.photo, vd.salary_slip_copy, vd.pan_copy, vd.partner, vd.visitor_approval, vd.disapprove_reason 
from visitor_directory vd inner join registration_master rm on vd.registration_id = rm.id 
	inner join state_master sm on sm.state_code = rm.state 
where vd.visitor_approval='Y' and vd.status = '1' 
  */
  
?>