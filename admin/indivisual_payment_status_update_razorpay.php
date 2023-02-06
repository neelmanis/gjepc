<?php
require('../razorpay/membership_config.php');
require('../razorpay/razorpay-php/Razorpay.php');
use Razorpay\Api\Api;
$api = new Api( $keyId,  $keySecret);

$registration_id=$_REQUEST['registration_id'];
//echo "select * from challan_master where challan_financial_year='2022' and registration_id='$registration_id' and (Response_Code is null || Response_Code!='captured')"; exit;
$querys =  $conn ->query("select * from challan_master where challan_financial_year='2022' and registration_id='$registration_id' and (Response_Code is null || Response_Code!='captured') AND Response_Code!='E000'");
while($result = $querys->fetch_assoc())
{


	//echo "<pre>"; print_r($result); 
	$post_date = date('Y-m-d');
	$razorpay_order_id = $result['razorpay_order_id'];
	$registration_id = intval($result['registration_id']);


	$payment = $api->order->fetch($razorpay_order_id)->payments();
	//echo "<pre>"; print_r($payment);exit;
	$payment_items = $payment['items'];

	$payment_status =  $payment_items[0]['status'];
	$order_id =  $payment_items[0]['order_id'];
	$razorpay_payment_id =  $payment_items[0]['id'];
	$method =  $payment_items[0]['method'];
	$currency =  $payment_items[0]['currency'];
	$card_id =  $payment_items[0]['card_id']; 
	$bank =  $payment_items[0]['bank']; 
	$error_description =   $payment_items[0]['error_description'];
	$payment_date = date('Y-m-d',$payment_items[0]['captured_at']);


	$post_date=date('Y-m-d');

	
	// $result = file_get_contents('https://eazypay.icicibank.com/EazyPGVerify?ezpaytranid=&amount=&paymentmode=&merchantid=221392&trandate=&pgreferenceno='.$ReferenceNo);
	
	// $string1=explode('&',$result);
	
	// $status=explode('=',$string1[0]);
	// $Unique_Ref_Number_temp=explode('=',$string1[1]);
	// $Transaction_Date_temp=explode('=',$string1[3]);
	
	// $Unique_Ref_Number=$Unique_Ref_Number_temp[1];
	// $Transaction_Date=$Transaction_Date_temp[1];
	
	if($payment_status =="captured"){
	
		$result1 = $conn ->query("update challan_master set Response_Code='captured',Unique_Ref_Number='$razorpay_order_id',Transaction_Date='$Transaction_Date',`razorpay_payment_id`='$razorpay_payment_id' where registration_id='$registration_id' and challan_financial_year='2022' and razorpay_order_id='$razorpay_order_id'");
		$result2 = $conn ->query("update approval_master set payment_approve='Y',apply_membership_renewal='Y',membership_type='R',renewal_download_status='N',membership_expiry_status='N',membership_renewal_dt='$post_date',post_date='$post_date' where registration_id='$registration_id'");
	
	}
	$rz_pay_log = $conn ->query("UPDATE  challan_payment_log SET Response_Code='$payment_status' ,`razorpay_payment_id`='$razorpay_payment_id' WHERE registration_id='$registration_id' AND razorpay_order_id='$razorpay_order_id'");
}
?>