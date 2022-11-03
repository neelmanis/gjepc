<?php
$date=date("Y-m-d");
$querys =  $conn ->query("select * from kp_payment_master where APPLICANT_ID='$APPLICANT_ID' and (Response_Code is null || Response_Code!='E000') AND PAYMENT_TYPE='93' AND CHEQUE_DATE='$date'");
while($result = mysqli_fetch_array($querys))
{ //echo '<pre>'; print_r($result); exit;
	$ReferenceNo = trim($result['ReferenceNo']);
	$APPLICANT_ID = intval($result['APPLICANT_ID']);
	
	$result = file_get_contents('https://eazypay.icicibank.com/EazyPGVerify?ezpaytranid=&amount=&paymentmode=&merchantid=296793&trandate=&pgreferenceno='.$ReferenceNo);
	
	$string1 = explode('&',$result);
	//echo '<pre>'; print_r($string1); exit;
	$status=explode('=',$string1[0]);
	$Unique_Ref_Number_temp=explode('=',$string1[1]);
	$Transaction_Date_temp=explode('=',$string1[3]);
	
	$Unique_Ref_Number=$Unique_Ref_Number_temp[1];
	$Transaction_Date=$Transaction_Date_temp[1];
	
	if($status[1]=="RIP" || $status[1]=="SIP" || $status[1]=="Success"){
	if($APPLICANT_ID!=''){
	
	$result = $conn ->query("update kp_payment_master set STATUS='95',Response_Code='E000',Unique_Ref_Number='$Unique_Ref_Number',PAYMENT_DATE='$Transaction_Date',CHEQUE_DATE='$Transaction_Date' where ReferenceNo='$ReferenceNo' AND APPLICANT_ID='$APPLICANT_ID'");
	}
	}
}
?>