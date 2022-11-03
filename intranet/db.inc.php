<?php 
date_default_timezone_set('Asia/Calcutta');
error_reporting(0);


$hostname = "localhost";
$uname = "appadmin";
$pwd = "#21SAq109@65%n";
$database = "kweb_intranet";


$dbconn = @mysql_connect($hostname,$uname,$pwd);
@mysql_select_db($database);

function filter($data)
{
	$usestrip = get_magic_quotes_gpc();
  
   if ($usestrip)
   {
       $data = stripslashes($data);
   }
   $data = trim($data);
   $data = strip_tags($data);
   $data = htmlentities($data);
   $data = mysql_real_escape_string($data);
   
   return $data;
   

}

foreach ($_REQUEST as $key => $value) {
   $request[$key] = filter($value);
}

foreach ($_GET as $key => $value) {
   $get[$key] = filter($value);
}

foreach ($_POST as $key => $value) {
 $post[$key] = filter($value);
}


?>
