<?php
session_start();
include ("../db.inc.php");

$registration_id=$_SESSION['USERID'];
if(isset($_REQUEST['actiontype']) && $_REQUEST['actiontype']=='optionValue')
{
	$registration_id = $_REQUEST['registration_id'];
	$option = $_REQUEST['option'];
	$sql="select * from communication_address_master where registration_id='$registration_id' AND id='$option' AND c_bp_number!=''";
	$query = $conn->query($sql);
	$ans = $query->fetch_assoc();
	$billing_bp_number = trim($ans['c_bp_number']);
	$address1 = trim($ans['address1']);
	$address2 = trim($ans['address2']);
	$address3 = trim($ans['address3']);
	$city = trim($ans['city']);
	$pincode = trim($ans['pincode']);
	$btelephone_no = trim($ans['landline_no1']);
	$bgst_no = trim($ans['gst_no']);
 echo $address1."#".$address2."#".$address3."#".$city."#".$pincode."#".$btelephone_no."#".$billing_bp_number."#".$bgst_no;
}
?>
