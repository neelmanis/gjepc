<?php
session_start(); 
ob_start();
include('../db.inc.php');
$date=date("d_m_Y");
?>
<?php
$filename = "IVR_REGISTRATION_" . date('Ymd') . ".csv";  
// query to get data from database
$result =$conn ->query("SELECT a.`uid`,a.`title`,a.`first_name`,a.`last_name`,a.`designation`,a.`company_name`,a.`office_add`,b.`country_name`,a.`state`,a.`city`,a.`postal_code`,a.`tel_no`,a.`fax_no`,a.`mob_no`,a.`photograph_fid`,a.`email`,a.`hotel_name`,a.`hotel_address`,a.`stay_from`,a.`stay_to`,a.`name_of_person`,a.`family_address`,a.`family_contact`,a.`family_relation`,a.`family_stay_from`,a.`family_stay_to`,a.`application_approved`,CONCAT(a.`personal_info_reason`,a.`photo_reason`,a.`valid_passport_copy_reason`,a.`visiting_card_reason`,a.`nri_photo_reason`) as 'Pending Reason' FROM `ivr_registration_details` a left join country_master b on a.country=b.country_code WHERE 1 AND a.`trade_show` = 'IIJS SIGNATURE 2022' and a.`application_approved`='N' order by a.time_stamp desc");

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
fputcsv($output, array('UID', 'Title','FIRST NAME','LAST NAME', 'DESIGNATION','Company Name', 'OFFICE ADD','COUNTRY NAME','STATE','CITY','POSTAL CODE','TEL NO','FAX NO','MOBILE NO','PHOTO ID','EMAIL','HOTEL NAME','HOTEL ADD','STAY FROM','STAY TO','PERSON NAME','FAMILY ADD','FAMILY CONTACT','FAMILY RELATION','FAMILY STAY FROM','FAMILY STAY TO','APPLICATION STATUS','PENDING REASON'));
 
if (count($users) > 0) {
    foreach ($users as $row) {
        fputcsv($output, $row);
    }
}
?>
