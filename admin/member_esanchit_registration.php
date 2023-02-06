<?php
session_start(); 
ob_start();
include('../db.inc.php');
include('../functions.php');
$date=date("d_m_Y");
?>

<?php
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

$category = 'MEMBERSHIP';
$report_name = 'E-Sanchit Registered List';
$logs = reportLogs($category,$report_name,$conn);
?>


<?php
$filename = "member_esanchit_list_" . date('Ymd') . ".csv";  
// query to get data from database

$result =$conn ->query("SELECT a.company_name,a.region_id,a.iec_no,a.e_sanchit_status,b.c_bp_number,
c.panel_name from information_master a,communication_address_master b,communication_details_master c where 
a.registration_id=b.registration_id and a.registration_id=c.registration_id and b.type_of_address='2' and a.e_sanchit_status='Yes'");

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
fputcsv($output, array('Company Name','Region Id','IEC No', 'E Sanchit Status','BP Number','Panel Name',''));
 
if (count($users) > 0) {
    foreach ($users as $row) {
        fputcsv($output, $row);
    }
}
?>
