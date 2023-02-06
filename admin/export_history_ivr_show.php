<?php
session_start(); 
ob_start();
include('../db.inc.php');
$date = date("d_m_Y");

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

$category = 'INTERNATIONAL';
$report_name = 'DOWNLOAD DISAPPROVED DATA';
$logs = reportLogs($category,$report_name,$conn);
?>
<?php
$filename = "INTL_REGISTRATION_ORDERS" . date('Ymd') . ".csv";  
// query to get data from database
$result =$conn ->query("SELECT a.`uid`,a.`eid`,a.`title`,a.`first_name`,a.`last_name`,a.`designation`,a.`passport_no`,a.`company_name`,a.`office_add`,c.`country_name`,a.`state`,a.`city`,a.`postal_code`,a.`tel_no`,a.`fax_no`,a.`mob_no`,a.`photograph_fid`,a.`passport_fid`,a.`visit_card_fid`,a.`nri_fid`,a.`email`,b.`create_date`,b.`show` FROM `ivr_registration_details` a left join ivr_registration_history b on a.eid=b.visitor_id left join country_master c on a.country=c.country_code WHERE 1 AND b.`show` = 'signature23' and b.`payment_status`='Y'");

$users = array();
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) { 
        $users[] = $row;
    }
}
 
header('Content-Type: text/csv; charset=utf-8');
header("Content-Disposition: attachment; filename=\"$filename\"");
$output = fopen('php://output', 'w');
//fputcsv($output, array($users), ',', '"');
//print_r($users); exit;
fputcsv($output, array('COMPANY ID','UID', 'Title','FIRST NAME','LAST NAME', 'DESIGNATION','PASSPORT NO','Company Name', 'OFFICE ADD','Country','STATE','CITY','POSTAL CODE','TEL NO','FAX NO','MOBILE NO','PHOTO ID','PASSPORT PHOTO','VISITING CARD','NRI PROOF','EMAIL','DATE','SHOW'));
 
if (count($users) > 0) {
    foreach ($users as $row) {
        fputcsv($output, $row);
    }
}
?>