<?php 
session_start();
include('./db.inc.php');
include('./functions.php');

$querys =  $conn ->query("select * from webinar_payment_history where (Response_Code is null || Response_Code!='E000')");

while($results = $querys->fetch_assoc())
{
	$post_date=date('Y-m-d');
	$ReferenceNo = trim($results['ReferenceNo']);
	$web_id = intval($results['id']);
	$result = file_get_contents('https://eazypay.icicibank.com/EazyPGVerify?ezpaytranid=&amount=&paymentmode=&merchantid=296793&trandate=&pgreferenceno='.$ReferenceNo);
	
	$string1=explode('&',$result);
	
	$status=explode('=',$string1[0]);
	$Unique_Ref_Number_temp=explode('=',$string1[1]);
	$Transaction_Date_temp=explode('=',$string1[3]);
	
	$Unique_Ref_Number=$Unique_Ref_Number_temp[1];
	$Transaction_Date=$Transaction_Date_temp[1];
	
	if($status[1]=="RIP" || $status[1]=="SIP" || $status[1]=="Success"){
   // echo "update webinar_payment_history set Response_Code='E000',Unique_Ref_Number='$Unique_Ref_Number',ReferenceNo='$ReferenceNo',Transaction_Date='$Transaction_Date' where id='$web_id' and ReferenceNo='$ReferenceNo'";exit;

	$result1 = $conn ->query("update webinar_payment_history set Response_Code='E000',Unique_Ref_Number='$Unique_Ref_Number',ReferenceNo='$ReferenceNo',Transaction_Date='$Transaction_Date' where id='$web_id' and ReferenceNo='$ReferenceNo'");	
	if($result1){
		echo "<p>Payment has been updated successfully</p><br> ";
	}
	}else{
		echo "<p>Not updated</p><br>";
	}
}

?>