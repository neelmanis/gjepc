<?php
session_start(); 
ob_start();
include('../db.inc.php');
include('../functions.php');
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
	

$category = 'WHATSAAPP';
$report_name = 'WHATSAPP_HISTORY';
$logs = reportLogs($category,$report_name,$conn);
?>
<?php

$filename = "WHATSAPP_HISTORY" . date('Ymd') . ".csv";  
// query to get data from database
$result =$conn ->query("SELECT w.template_id,d.department_name,w.category,w.media_type,w.attatchment,a.contact_name,w.count,w.created_at FROM whatsapp_messages_history w left join whatsapp_sender_department_master d on w.department=d.id left join admin_master a ON w.adminId =a.id order by created_at DESC");

$users = array();
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) { 
        $users[] = $row;
    }
}
 
header('Content-Type: text/csv; charset=utf-8');
header("Content-Disposition: attachment; filename=\"$filename\"");
$output = fopen('php://output', 'w');

// print_r($users); exit;
fputcsv($output, array('TEMPLATE','DEPARTMENT','CATEGORY','MEDIA TYPE', 'ATTATCHMENT','CONTACT NAME','COUNT',"TIMESTAMP"));
 
if (count($users) > 0) {
    foreach ($users as $row) {
        fputcsv($output, $row);
    }
}
?>