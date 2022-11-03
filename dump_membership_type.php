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
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
/*
$q1=mysql_query("SELECT * from check_bp");
while($r1=mysql_fetch_array($q1)){
	
	$c_bp_number=$r1['bp_number'];
	$sql="select * from communication_address_master where 1 and c_bp_number='$c_bp_number'";
	$query=mysql_query($sql);
	$result=mysql_fetch_array($query);
	$registration_id=$result['registration_id'];
	echo "update approval_master set eligible_for_renewal='Y' where registration_id='$registration_id'";echo "<br/>";
	
	//mysql_query("update approval_master set eligible_for_renewal='Y' where registration_id='$registration_id'");

}
*/

?>