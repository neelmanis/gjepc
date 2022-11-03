<?php
session_start();ob_start();
include('../db.inc.php');
include('../functions.php');

if($_POST['registration_id']!=''){
if(isset($_POST['id']) && $_POST['id']!=""){ $id=$_POST['id']; } else { $id=""; }
$registration_id	=	intval(filter($_POST['registration_id']));
$type_of_addresss   =  $_POST['type_of_address'];
$tmp = explode("-", $type_of_addresss);

$type_of_address = $tmp[0];
$address_identity = $tmp[1];

//echo '<pre>'; print_r($tmp); exit;
if(!empty($type_of_address)){
	if($type_of_address==2){ $type_of_address_sap = "P"; }
	else { $type_of_address_sap = "C"; }
} else { echo "Type of Address missing"; }

//echo $address_identity .'  '.$type_of_address.' '.$type_of_address_sap; exit;

if(isset($_POST['name']) && $_POST['name']!=""){	$name = filter(strtoupper($_POST['name']));	} else {	$name=""; }
if(isset($_POST['designation']) && $_POST['designation']!=""){ $designation=$_POST['designation']; } else { $designation="";}

if(isset($_POST['father_name']) && $_POST['father_name']!=""){ $father_name = filter(strtoupper($_POST['father_name'])); } else { $father_name=""; }
if(isset($_POST['address1']) && $_POST['address1']!=""){	$address1 =filter(strtoupper($_POST['address1'])); }else{ $address1="";}
if(isset($_POST['address2']) && $_POST['address2']!=""){	$address2 =filter(strtoupper($_POST['address2'])); }else{ $address2="";}
if(isset($_POST['address3']) && $_POST['address3']!=""){	$address3 = filter(strtoupper($_POST['address3'])); } else { $address3="";}
$city    = filter($_POST['city']);
$country = filter($_POST['country']);
if($_POST['state']!=""){ $state=$_POST['state']; } else { $state=$_POST['other_state']; }
$pincode = filter($_POST['pincode']);
if(isset($_POST['landline_no1']) && $_POST['landline_no1']!=""){$landline_no1=$_POST['landline_no1'];}else{$landline_no1="";}
if(isset($_POST['mobile_no']) && $_POST['mobile_no']!=""){$mobile_no=$_POST['mobile_no'];}else{$mobile_no="";}
if(isset($_POST['fax_no1']) && $_POST['fax_no1']!=""){$fax_no1=$_POST['fax_no1'];}else{$fax_no1="";}
if(isset($_POST['fax_no2']) && $_POST['fax_no2']!=""){$fax_no2=$_POST['fax_no2'];}else{$fax_no2="";}
$email_id = filter($_POST['email_id']);
$din_no	  = filter($_POST['din_no']);
$pan_no   = filter(strtoupper($_POST['pan_no']));
$gst_no   = filter(strtoupper($_POST['gst_no']));
$aadhar_no = filter($_POST['aadhar_no']);
$passport_no = filter($_POST['passport_no']);
if($joining_date=="")
	$joining_date = date('Y-m-d');
else
	$joining_date = $_POST['joining_date'];
	
if($retirement_date=="")
	$retirement_date = date('Y-m-d');
else
	$retirement_date = $_POST['retirement_date'];

$dt = date('Y/m/d'); 

$qcheck="select * from communication_address_master where id=? and registration_id=?";
$stmt = $conn -> prepare($qcheck);
$stmt -> bind_param("ii", $id,$registration_id);
$stmt->execute();			
$query = $stmt->get_result();
$row2 = $query->fetch_assoc();
$c_bp_number	=	filter($row2['c_bp_number']);
$getCompany_name	=	getNameCompany($registration_id,$conn); 
$company_name	= str_replace(array('&amp;','&AMP;'),'&', $getCompany_name);

$rcheck=$query->num_rows;
if($rcheck>0){
$sqlx = $conn ->query("update communication_address_master set type_of_address='$type_of_address',address_identity='$address_identity',type_of_address_sap='$type_of_address_sap',name='$name',father_name='$father_name',designation='$designation',address1='$address1',address2='$address2',address3='$address3',city='$city',country='$country',state='$state',pincode='$pincode',landline_no1='$landline_no1',mobile_no='$mobile_no',fax_no1='$fax_no1',fax_no2='$fax_no2',email_id='$email_id',din_no='$din_no',pan_no='$pan_no',gst_no='$gst_no',aadhar_no='$aadhar_no',passport_no='$passport_no',joining_date='$joining_date',retirement_date='$retirement_date' where id='$id' and registration_id='$registration_id'");
if(!$sqlx) die ($conn->error);

/* KP Address Update */
$con_kp = mysqli_connect("localhost","appadmin","#21SAq109@65%n","gjepc_kp");
if(mysqli_connect_errno($con_kp)){ 	echo "Failed to connect to KP MySQL: " . mysqli_connect_error();  }

$sql_address_details="update kp_member_address_details set MEMBER_ADD_SR_NO='$type_of_address',MEMBER_BP_NO='$c_bp_number',ADDRESS_IDENTITY='$address_identity',TYPE_OF_ADDRESS_SAP='$type_of_address_sap',MEMBER_CO_NAME='$company_name',name='$name',designation='$designation',MEMBER_ADDRESS1='$address1',MEMBER_ADDRESS2='$address2',MEMBER_ADDRESS3='$address3',PINCODE='$pincode',CITY='$city',STATE='$state',COUNTRY='$country',MEMBER_CO_TEL1='$landline_no1',MEMBER_CO_TEL2='$mobile_no',MEMBER_CO_FAX1='$fax_no1',MEMBER_CO_FAX2='$fax_no2' where MEMBER_ID='$registration_id' and MEMBER_ADD_ID='$id'"; 
$result_address_details=mysqli_query($con_kp,$sql_address_details);			
if(!$result_address_details) echo mysqli_error();	
/* KP Address Update */

} else {
$sqlx = $conn ->query("insert into communication_address_master set registration_id='$registration_id',type_of_address='$type_of_address',address_identity='$address_identity',type_of_address_sap='$type_of_address_sap',name='$name',father_name='$father_name',designation='$designation',address1='$address1',address2='$address2',address3='$address3',city='$city',country='$country',state='$state',pincode='$pincode',landline_no1='$landline_no1',mobile_no='$mobile_no',fax_no1='$fax_no1',fax_no2='$fax_no2',email_id='$email_id',din_no='$din_no',pan_no='$pan_no',gst_no='$gst_no',aadhar_no='$aadhar_no',passport_no='$passport_no',joining_date='$joining_date',retirement_date='$retirement_date',status=1,post_date='$dt'");
if(!$sqlx) die ($conn->error);
}
header('location:communication_form.php?registration_id='.$registration_id);
} else {
header('location:communication_form.php?registration_id='.$registration_id);
}
?>