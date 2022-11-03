<?php
ob_start();
session_start();
include_once("db.inc.php");
$date=date("Y-m-d");
$email=$_POST['email'];
$check_query="select * from newsletter where email_id='$email'";
$result_query=mysql_query($check_query);
$chk_count=mysql_num_rows($result_query);
if($chk_count==0)
{
 $query = "insert into newsletter (email_id,post_date) values('$email',now())";
$result = mysql_query($query);
if($result)
{
	/*header('location:index.php');	
	echo "<script>alert('Thank You for Subscribing')</script>";*/
	echo "<script>
alert('Thank You for Subscription');
window.location.href='index.php';
</script>";
	
}
}else
{
	echo "<script>alert('Your email id has been registered earlier and is already on the list for receiving the Newsletter')</script>";

	echo "<script>window.location.href='index.php';</script>";
}
?>