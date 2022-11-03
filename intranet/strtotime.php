<?php
include('db.inc.php');
$query = "select * from employee_details";
$result = mysql_query($query);
while($row = mysql_fetch_array($result))
{
//$strtodate  = strtotime($row['dob']);
$id = $row['id'];
$dob = $row['dob'];
$ans = explode("-",$dob);
$month_date = $ans[0]." ".$ans[1];
$dob_str=strtotime($month_date);
//echo $row['dob'];
echo $query1 = "update employee_details set dob_str='$dob_str' where id=$id";
$result1 = mysql_query($query1);
if($result1)
	echo "successful";
else
	echo "failed";
}
?>