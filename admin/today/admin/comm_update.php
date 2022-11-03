<?php session_start();ob_start();?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php 
if(isset($_POST['id']) && $_POST['id']!=""){$id=$_POST['id'];}else{$id="";}
$registration_id=$_POST['registration_id'];
$type_of_addresss=$_POST['type_of_address'];
$tmp = explode("-", $type_of_addresss);

$type_of_address = $tmp[0];
$address_identity = $tmp[1];

//echo '<pre>'; print_r($tmp); exit;
if(!empty($type_of_address)){
	if($type_of_address==2){ $type_of_address_sap = "P"; }
	else { $type_of_address_sap = "C"; }
} else { echo "Type of Address missing"; }

//echo $address_identity .'  '.$type_of_address.' '.$type_of_address_sap; exit;

if(isset($_POST['name']) && $_POST['name']!=""){$name=$_POST['name'];}else{$name="";}
if(isset($_POST['father_name']) && $_POST['father_name']!=""){$father_name=$_POST['father_name'];}else{$father_name="";}
if(isset($_POST['address1']) && $_POST['address1']!=""){$address1=$_POST['address1'];}else{$address1="";}
if(isset($_POST['address2']) && $_POST['address2']!=""){$address2=$_POST['address2'];}else{$address2="";}
if(isset($_POST['address3']) && $_POST['address3']!=""){$address3=$_POST['address3'];}else{$address3="";}
$city=$_POST['city'];
$country=$_POST['country'];
if($_POST['state']!=""){$state=$_POST['state'];}else{$state=$_POST['other_state'];}
$pincode=$_POST['pincode'];
if(isset($_POST['landline_no1']) && $_POST['landline_no1']!=""){$landline_no1=$_POST['landline_no1'];}else{$landline_no1="";}
if(isset($_POST['mobile_no']) && $_POST['mobile_no']!=""){$mobile_no=$_POST['mobile_no'];}else{$mobile_no="";}
if(isset($_POST['fax_no1']) && $_POST['fax_no1']!=""){$fax_no1=$_POST['fax_no1'];}else{$fax_no1="";}
if(isset($_POST['fax_no2']) && $_POST['fax_no2']!=""){$fax_no2=$_POST['fax_no2'];}else{$fax_no2="";}
$email_id=$_POST['email_id'];
$din_no=$_POST['din_no'];
$pan_no=$_POST['pan_no'];
$gst_no=$_POST['gst_no'];
$dt = date('Y/m/d'); 

$qcheck=mysql_query("select * from communication_address_master where id='$id' and registration_id='$registration_id'");
$rcheck=mysql_num_rows($qcheck);
if($rcheck>0){
mysql_query("update communication_address_master set type_of_address='$type_of_address',address_identity='$address_identity',type_of_address_sap='$type_of_address_sap',name='$name',father_name='$father_name',address1='$address1',address2='$address2',address3='$address3',city='$city',country='$country',state='$state',pincode='$pincode',landline_no1='$landline_no1',mobile_no='$mobile_no',fax_no1='$fax_no1',fax_no2='$fax_no2',email_id='$email_id',din_no='$din_no',pan_no='$pan_no',gst_no='$gst_no' where id='$id' and registration_id='$registration_id'");
}
else{
$sql="insert into communication_address_master set registration_id='$registration_id',type_of_address='$type_of_address',address_identity='$address_identity',type_of_address_sap='$type_of_address_sap',name='$name',father_name='$father_name',address1='$address1',address2='$address2',address3='$address3',city='$city',country='$country',state='$state',pincode='$pincode',landline_no1='$landline_no1',mobile_no='$mobile_no',fax_no1='$fax_no1',fax_no2='$fax_no2',email_id='$email_id',din_no='$din_no',pan_no='$pan_no',gst_no='$gst_no',status=1,post_date='$dt'";
mysql_query($sql);
}
header('location:communication_form.php?registration_id='.$registration_id);
?>