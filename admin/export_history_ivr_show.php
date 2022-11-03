<?php
session_start(); 
ob_start();
include('../db.inc.php');
$date=date("d_m_Y");
?>
<?php
$filename = "IVR_REGISTRATION_history" . date('Ymd') . ".csv";  
// query to get data from database
$result =$conn ->query("SELECT a.`uid`,a.`eid`,a.`title`,a.`first_name`,a.`last_name`,a.`designation`,a.`passport_no`,a.`company_name`,a.`office_add`,c.`country_name`,a.`state`,a.`city`,a.`postal_code`,a.`tel_no`,a.`fax_no`,a.`mob_no`,a.`photograph_fid`,a.`passport_fid`,a.`visit_card_fid`,a.`nri_fid`,a.`email`,b.`create_date` FROM `ivr_registration_details` a left join ivr_registration_history b on a.eid=b.visitor_id left join country_master c on a.country=c.country_code WHERE 1 AND b.`show` = 'iijs22' and b.`payment_status`='Y'");

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
fputcsv($output, array('COMPANY ID','UID', 'Title','FIRST NAME','LAST NAME', 'DESIGNATION','PASSPORT NO','Company Name', 'OFFICE ADD','Country','STATE','CITY','POSTAL CODE','TEL NO','FAX NO','MOBILE NO','PHOTO ID','PASSPORT PHOTO','VISITING CARD','NRI PROOF','EMAIL','DATE'));
 
if (count($users) > 0) {
    foreach ($users as $row) {
        fputcsv($output, $row);
    }
}
?>