<?php 
$registration_id=$_REQUEST['registration_id'];
$type_of_address=$_REQUEST['type_of_address'];
if(isset($_REQUEST['name'])){echo $name=$_REQUEST['name'];}else{echo $name="";}exit;
if(isset($_REQUEST['father_name'])){$father_name=$_REQUEST['father_name'];}else{$father_name="";}
$address1=$_REQUEST['address1'];
$address2=$_REQUEST['address2'];
$address3=$_REQUEST['address3'];
$city=$_REQUEST['city'];
$country=$_REQUEST['country'];
if(isset($_REQUEST['state'])){$state=$_REQUEST['state'];}else{$state="";}
if(isset($_REQUEST['other_state'])){$other_state=$_REQUEST['other_state'];)else{$other_state="";}
$pincode=$_REQUEST['pincode'];
$landline_no1=$_REQUEST['landline_no1'];
$mobile_no=$_REQUEST['mobile_no'];
$fax_no1=$_REQUEST['fax_no1'];
$fax_no2=$_REQUEST['fax_no2'];
$email_id=$_REQUEST['email_id'];
$dt = date('Y/m/d'); 
echo $sql="insert into communication_address_master set registration_id='$registration_id',type_of_address='$type_of_address',name='$name',father_name='$father_name',address1='$address1',address2='$address2',address3='$address3',city='$city',country='$country',state='$state',other_state='$other_state',pincode='$pincode',landline_no1='$landline_no1',mobile_no='$mobile_no',fax_no1='$fax_no1',fax_no2='$fax_no2',email_id='$email_id',status=1,post_date='$dt'";
//mysql_query($sql);
?>