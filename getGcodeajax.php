<?php
include('db.inc.php'); 
include('functions.php');
if(isset($_POST['actiontype']) && $_POST['actiontype']=="chkGcode"){
    $registration_id= getRegidBP($_POST['gcode']);
    //$sqlx= "select * from registration_master where gcode='$gcode' and gcode!='' and status='1'";	
	if($registration_id!='') {
	$sqlx= "select * from approval_master where registration_id='$registration_id' and  (`membership_issued_certificate_dt` between '2019-04-01' and '2020-03-31' || (`membership_renewal_dt` between '2019-04-01' and '2020-03-31'))";
	$query=mysql_query($sqlx);
    $num=mysql_num_rows($query);
    if($num>0)
    {		
		echo "Verified";
    } else {
		echo "Not a Member";
	}
	} else {
	echo 'Please Enter Valid Gcode';
}
}
?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="chkregisuser"){
    $email_id=$_POST['email_id'];
    $query=mysql_query("select * from igjs_summit_registration where email='$email_id'");
    $num=mysql_num_rows($query);
  if($num>0)
   {	
   		echo 0;
   }
   else
   	echo 1;
}
?>