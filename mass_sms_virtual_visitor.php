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
} else {
	
}
function get_data($message,$number) {
	$message=str_replace(" ","%20",$message);
	//$url = 'http://products.tecogis.com/gjepcsmsengine/smsapi/sendsms.asmx/erpapi?action=send&Message='.$message.'&Phone='.$number;
	$url = 'http://products.tecogis.com/gjepcsmsengine/smsapi/sendsms.asmx/smsapi?action=send&Message='.$message.'&Phone='.$number.'&SenderID=GJEPCI';
	echo "Mobile no-".$number."&Delivered code -".file_get_contents($url)."<br/>";

}

$i=0;
$xxx = "SELECT name,mobile from visitor_directory where visitor_approval='Y' limit 37001,1000";
$query = $conn ->query($xxx);
while($result = $query->fetch_assoc())
{
	$name=$result['name'];
	$number=$result['mobile'];
	$message="Dear ".$name.", To register for IIJS Virtual Show 2020 – OCT 2020.  Kindly visit on https://registration.gjepc.org/single_visitor.php or you may also register via GJEPC App. Visitor Registration for IIJS Virtual show is complimentary.";
		//$number="8657470504";
		get_data($message,$number);
}
?>