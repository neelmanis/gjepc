<?php
session_start();
include('../db.inc.php');
if(!isset($_SESSION['curruser_login_id']))
{
header('Location: index.php');
}
$adminID=$_SESSION['curruser_login_id'];
$hotel_id = $_REQUEST['hotel_id'];
$status = $_REQUEST['status'];

if(!empty($hotel_id) && isset($status))
{
	$query_sel = "UPDATE `iijs_hotel_master` SET `status`='$status',admin_id='$adminID' WHERE hotel_id='$hotel_id' ";
	$result_sel = mysql_query($query_sel);
	if($result_sel){ echo 'Hotel Status Changed'; }else{echo "no";} 
}

  //https://gjepc.org/admin/api.manage-hotel.php?hotel_id=7&status=0
?>