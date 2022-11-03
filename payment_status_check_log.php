<?php
include 'db.inc.php';
include 'functions.php';

$querys =  $conn ->query("select * from challan_master where challan_financial_year='2020' and (Response_Code is null || Response_Code!='E000')");
while($result = $querys->fetch_assoc())
{
	$post_date=date('Y-m-d');
	$registration_id=$result['registration_id'];
	
	$query1 = $conn ->query("select * from challan_payment_log where registration_id='$registration_id'");
	while($result1=  $query1->fetch_assoc()){
		
	$ReferenceNo=$result1['ReferenceNo'];
	$result = file_get_contents('https://eazypay.icicibank.com/EazyPGVerify?ezpaytranid=&amount=&paymentmode=&merchantid=221392&trandate=&pgreferenceno='.$ReferenceNo);
	
	echo $registration_id."==".$ReferenceNo."==".$result."<br/><br/>";
	
	$string1=explode('&',$result);
	
	$status=explode('=',$string1[0]);
	$Unique_Ref_Number_temp=explode('=',$string1[1]);
	$Transaction_Date_temp=explode('=',$string1[3]);
	
	$Unique_Ref_Number=$Unique_Ref_Number_temp[1];
	$Transaction_Date=$Transaction_Date_temp[1];
	
	if($status[1]=="RIP" || $status[1]=="SIP" || $status[1]=="Success"){
	/*$result1 = $conn ->query("update challan_master set Response_Code='E000',Unique_Ref_Number='$Unique_Ref_Number',ReferenceNo='$ReferenceNo',Transaction_Date='$Transaction_Date' where registration_id='$registration_id' and challan_financial_year='2020'");
	
	$result2 = $conn ->query("update approval_master set payment_approve='Y',apply_membership_renewal='Y',membership_type='R',renewal_download_status='N',membership_expiry_status='N',membership_renewal_dt='$post_date',post_date='$post_date' where registration_id='$registration_id'");
	*/
	}
  }
}
?>