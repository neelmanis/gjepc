<?php include('header_include.php');?>
<?php 
$query=mysql_query("select privilege_code,mobile from temp_privilege_visitor_reg");
while($row=mysql_fetch_array($query))
{
	$mobile=$row['mobile'];
	$privilege_code=$row['privilege_code'];
	
	$query1=mysql_query("select * from registration_master where mobile_no='$mobile'");
	$result1=mysql_fetch_array($query1);
	$id=$result1['id'];
	
	$query3=mysql_query("select * from registration_master where id='$id' and pvrcode=''");
	$num3=mysql_num_rows($query3);
	if($num3>0){
		echo "update  registration_master set pvrcode='$privilege_code' where id='$id'";echo "<br/>";
		mysql_query("update  registration_master set pvrcode='$privilege_code' where id='$id'");
	}
}
?>