<?php
include('../db.inc.php');
//if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }

$cdate=date("Y-m-d");
$pdate=date( 'Y-m-d', strtotime( $cdate . ' -1 day' ) );

$querys =  $conn ->query("select * from challan_master where challan_financial_year='2022' and (Response_Code is null || Response_Code!='E000' || Transaction_Date is null) AND post_date between '$pdate' and '$cdate'");
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
	$Transaction_Date=date('Y-m-d',strtotime($Transaction_Date_temp[1]));
	
	echo "RegID=".$registration_id." AND Status=".$status[1]." AND Ref No=".$ReferenceNo." AND Unique_Ref_Number=".$Unique_Ref_Number;echo "<br/>";
		
	if($status[1]=="RIP" || $status[1]=="SIP" || $status[1]=="Success")
	{
	$result1 = $conn ->query("update challan_master set Response_Code='E000',Unique_Ref_Number='$Unique_Ref_Number',ReferenceNo='$ReferenceNo',Transaction_Date='$Transaction_Date' where registration_id='$registration_id' and challan_financial_year='2022' and ReferenceNo='$ReferenceNo'");
	$result2 = $conn ->query("update approval_master set payment_approve='Y',apply_membership_renewal='Y',membership_type='R',renewal_download_status='N',membership_expiry_status='N',membership_renewal_dt='$post_date',post_date='$post_date' where registration_id='$registration_id'");
	}
}
?>