<?php
session_start(); 
ob_start();
include('../db.inc.php');
$date=date("d_m_Y");

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
$report_name = 'DOWNLOAD APPROVED DATA';
$logs = reportLogs($category,$report_name,$conn);
?>
<?php
$filename = "INTL_APPROVED_DATA_" . date('Ymd') . ".csv";  
// query to get data from database
$result =$conn ->query("SELECT a.`uid`,a.`title`,a.`first_name`,a.`last_name`,a.`designation`,a.`passport_no`,a.`company_name`,a.`office_add`,b.`country_name`,a.`state`,a.`city`,a.`postal_code`,a.`tel_no`,a.`fax_no`,a.`mob_no`,a.`photograph_fid`,a.`email`,a.`hotel_name`,a.`hotel_address`,a.`stay_from`,a.`stay_to`,a.`name_of_person`,a.`family_address`,a.`family_contact`,a.`family_relation`,a.`family_stay_from`,a.`family_stay_to`,a.`application_approved`,CONCAT(a.`personal_info_reason`,a.`photo_reason`,a.`valid_passport_copy_reason`,a.`visiting_card_reason`,a.`nri_photo_reason`) as 'Pending Reason' FROM `ivr_registration_details` a left join country_master b on a.country=b.country_code WHERE 1 AND a.`application_approved`='Y' order by a.time_stamp desc");

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
fputcsv($output, array('UID', 'Title','FIRST NAME','LAST NAME', 'DESIGNATION','PASSPORT NO','Company Name', 'OFFICE ADD','COUNTRY NAME','STATE','CITY','POSTAL CODE','TEL NO','FAX NO','MOBILE NO','PHOTO ID','EMAIL','HOTEL NAME','HOTEL ADD','STAY FROM','STAY TO','PERSON NAME','FAMILY ADD','FAMILY CONTACT','FAMILY RELATION','FAMILY STAY FROM','FAMILY STAY TO','APPLICATION STATUS','PENDING REASON'));
 
if (count($users) > 0) {
    foreach ($users as $row) {
        fputcsv($output, $row);
    }
}
?>
