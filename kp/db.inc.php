<?php 
date_default_timezone_set('Asia/Calcutta');
error_reporting(0);

// for local
$hostname = "localhost";
$uname = "appadmin";
$pwd = "G@k593#sgtk";
$database = "gjepc_kp";

$conn = @mysqli_connect($hostname,$uname,$pwd,$database);
// Check connection
if(mysqli_connect_errno($conn))
{
//	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

function filter($data)
{
   $data = stripslashes($data);
   $data = trim($data);
   $data = strip_tags($data);
   $data = htmlentities($data);
   //$data = mysqli_real_escape_string($data);
   return $data;
}

	function token()
	{
	$token = substr(base_convert(sha1(uniqid(mt_rand())),16,36),0,32);
	$_SESSION['token'] = $token;
	//creating hidden field
	echo "<input type='hidden' name='token' value='$token'/>";
	return $token;
	}
?>
