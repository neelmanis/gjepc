<?php
include('db.inc.php');
$date = date("Y-m-d");

//$querys =  $conn ->query("SELECT * from challan_master where challan_financial_year='2021' AND (Response_Code is null || Response_Code!='E000') AND post_date='2021-05-12'"); /* Specific Date */

$querys =  $conn ->query("SELECT * from challan_master where challan_financial_year='2021' AND (Response_Code is null || Response_Code!='E000') AND post_date='$date'"); /* Same Date */
if(!$querys) die ($conn->error);

//$querys =  $conn ->query("select * from challan_master where challan_financial_year='2021' and (Response_Code is null || Response_Code!='E000') and registration_id='$registration_id'");

while($result = $querys->fetch_assoc())
{
	$post_date=date('Y-m-d');
	$ReferenceNo = trim($result['ReferenceNo']);
	$registration_id = intval($result['registration_id']);
	$result = file_get_contents('https://eazypay.icicibank.com/EazyPGVerify?ezpaytranid=&amount=&paymentmode=&merchantid=221392&trandate=&pgreferenceno='.$ReferenceNo);
	
	$string1=explode('&',$result);
	
	$status=explode('=',$string1[0]);
	$Unique_Ref_Number_temp=explode('=',$string1[1]);
	$Transaction_Date_temp=explode('=',$string1[3]);
	
	$Unique_Ref_Number=$Unique_Ref_Number_temp[1];
	$Transaction_Date=$Transaction_Date_temp[1];
	
	if($status[1]=="RIP" || $status[1]=="SIP" || $status[1]=="Success"){
		echo "update challan_master set Response_Code='E000',Unique_Ref_Number='$Unique_Ref_Number',ReferenceNo='$ReferenceNo',Transaction_Date='$Transaction_Date' where registration_id='$registration_id' and challan_financial_year='2021' and ReferenceNo='$ReferenceNo'"; echo "<br/>";
		echo "update approval_master set payment_approve='Y',apply_membership_renewal='Y',membership_type='R',renewal_download_status='N',membership_expiry_status='N',membership_renewal_dt='$post_date',post_date='$post_date' where registration_id='$registration_id'"; echo "<br/>";
		
		
	$result1 = $conn ->query("update challan_master set Response_Code='E000',Unique_Ref_Number='$Unique_Ref_Number',ReferenceNo='$ReferenceNo',Transaction_Date='$Transaction_Date' where registration_id='$registration_id' and challan_financial_year='2021' and ReferenceNo='$ReferenceNo'");
	$result2 = $conn ->query("update approval_master set payment_approve='Y',apply_membership_renewal='Y',membership_type='R',renewal_download_status='N',membership_expiry_status='N',membership_renewal_dt='$post_date',post_date='$post_date' where registration_id='$registration_id'");
	}

}
?>