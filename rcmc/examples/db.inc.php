<?php 
date_default_timezone_set('Asia/Calcutta');
error_reporting(0);

// for local
$hostname = "localhost";
$uname = "root";
$pwd = "";
$database = "db_gjepc";


$dbconn = @mysql_connect($hostname,$uname,$pwd);
@mysql_select_db($database);

?>