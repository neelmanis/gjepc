<?php 
session_start();
include('../db.inc.php');
include('../functions.php');

	function getCompanyLogo($reg_id,$conn)
{
	$query_sel = "SELECT * FROM  registration_master  where id='$reg_id'";	
	$result1 = $conn->query($query_sel);
	$row1 = $result1->fetch_assoc(); 		
	$occasion =  $row1['company_logo'];
	

	return $occasion;

}

 $sql = "SELECT * FROM promo_video_payment_history ";

$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
	$reg_id=$row['registration_id'];
echo $copany_logo = getCompanyLogo($reg_id,$conn);

$sql_update = "UPDATE promo_video_payment_history SET company_logo = '$copany_logo' WHERE registration_id='$reg_id' ";
$conn->query($sql_update);
echo "success"."<br>";
}
?>