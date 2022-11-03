<?php 
date_default_timezone_set('Asia/Calcutta');
error_reporting(0);

$hostname = "localhost";
$uname = "gjepcliveuserdb";
$pwd = "KGj&6(pcvmLk5";
$database = "gjepclivedatabase";

// Create connection
$conn = new mysqli($hostname, $uname, $pwd, $database);
// Check connection
if($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/*
$sqlx = $conn ->query("SELECT * from renewal_bp_dump");
while($row = $sqlx->fetch_assoc())
{
	$c_bp_number = $row['bp_no'];
	
	$sql   = "select * from communication_address_master where 1 AND c_bp_number='$c_bp_number' AND type_of_address='2'";
	$query = $conn ->query($sql);
	$result= $query->fetch_assoc();
	$registration_id = $result['registration_id'];
	//echo  "update approval_master set eligible_for_renewal='Y' where registration_id='$registration_id'"; echo "<br/>";
	
	//$ss = $conn ->query("update approval_master set eligible_for_renewal='Y' where registration_id='$registration_id'");
} */

$sqlx = $conn ->query("SELECT distinct(bp_no) FROM gjepclivedatabase.renewal_outstanding_bp_dump");
while($row = $sqlx->fetch_assoc())
{
	$c_bp_number = $row['bp_no'];
	
	$sql   = "select * from communication_address_master where 1 AND c_bp_number='$c_bp_number'";
	$query = $conn ->query($sql);
	$result= $query->fetch_assoc();
	$registration_id = $result['registration_id'];
	if($registration_id!=''){
	echo $c_bp_number. " update registration_master set payment_defaulter='Y',payment_defaulter_reason='outstanding' where id='$registration_id'"; echo "<br/>";
		
//	$ss = $conn ->query("update registration_master set payment_defaulter='Y',payment_defaulter_reason='outstanding' where id='$registration_id'");
	} else { 
	 echo $c_bp_number.' Notfound'.'<br/>';
	
	}
}
?>