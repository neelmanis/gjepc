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

$querys = $conn ->query("SELECT id FROM registration_master where (state='' OR state IS NULL ) AND approval_status='Y'");
while($result = $querys->fetch_assoc())
{
	$registration_id = $result['id'];
	echo $query1 = "SELECT * FROM `n_m_billing_address` WHERE `registration_id`='$registration_id' AND (type_of_address='2' OR type_of_address='3' OR type_of_address='4' OR type_of_address='6' OR type_of_address='10')"; 
	$result1 =  $conn ->query($query1);
	$resultx = $result1->fetch_assoc();
	$address1 = ucwords($resultx['address1']);
	$address2 = ucwords($resultx['address2']);
	$state = $resultx['state'];
	$city = ucwords($resultx['city']);
	$pin_code = $resultx['pin_code'];
	
	$num = $result1->num_rows;
	if($num>0){
	//echo $email_id."====".$pan_no;echo "<br/>";
	//echo "update registration_master set address_line1='$address1',address_line2='$address2',state='$state',city='$city',pin_code='$pin_code' where id='$registration_id' AND (state='' OR state IS NULL ) AND approval_status='Y'"; echo "<br/>";
	echo $sql1 = "update registration_master set address_line1='$address1',address_line2='$address2',state='$state',city='$city',pin_code='$pin_code' where id='$registration_id' AND (state='' OR state IS NULL ) AND approval_status='Y'"; 
	//$xresult = $conn ->query($sql1);
	if (!$xresult) die ($conn->error);
	//mysql_query("update registration_master set NM_bp_number='$company_bp_number' where id='$registration_id'");
	} else {
	echo "Not Found"; echo "<br/>";
	}
	
}
?>