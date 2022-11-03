<?php
require('rz_config.php');
require('razorpay-php/Razorpay.php');

use Razorpay\Api\Api;
$api = new Api( $keyId,  $keySecret);

$sqlAPI = "SELECT * FROM `utr_history` WHERE 1 AND registration_id='".$_REQUEST['registration_id']."' AND (`event_selected` = 'signature23') AND (payment_status='pending' || payment_status='' || payment_status='captured') AND (razorpay_order_id!='' || razorpay_order_id IS NULL) AND source!='admin'";
$querys =  $conn ->query($sqlAPI);
while($result = $querys->fetch_assoc())
{
	//echo "<pre>";print_r($result);exit;
	$post_date = date('Y-m-d');
	$razorpay_order_id = $result['razorpay_order_id'];
	$utr_number = $result['utr_number'];
	
	$api  = new Api($keyId, $keySecret);
	$payment = $api->order->fetch($razorpay_order_id)->payments();
	//echo '<pre>'; print_r($payment);  exit;
	//	print_r($payment['items']);
	$payment_items = $payment['items'];
	//echo '<pre>'; print_r($payment_items);
	$payment_status =  $payment_items[0]['status'];
	$order_id =  $payment_items[0]['order_id'];
	$razorpay_payment_id =  $payment_items[0]['id'];
	$method =  $payment_items[0]['method'];
	$currency =  $payment_items[0]['currency'];
	$card_id =  $payment_items[0]['card_id']; 
	$bank =  $payment_items[0]['bank']; 
	$error_description =   $payment_items[0]['error_description'];
	$payment_date = date('Y-m-d',$payment_items[0]['captured_at']);
	
	if($payment_status == 'captured'){
	if($_REQUEST['registration_id']!='' && $razorpay_order_id!=''){
	$updateUTR = "UPDATE `utr_history` SET `modified_date`=NOW(),`order_id`='$order_id',`razorpay_payment_id`='$razorpay_payment_id',`currency`='$currency',`method`='$method',`payment_status`='$payment_status',`card_id`='$card_id',`bank`='$bank',`error_description`='$error_description',`comment`='dashboard status apis',`payment_date`='$payment_date' WHERE razorpay_order_id='$razorpay_order_id' AND `registration_id`='$registration_id' AND `show`='IIJS SIGNATURE 2023' AND `event_selected`='signature23'"; 
	$resultUTR = $conn->query($updateUTR);
	
	$update_query = "update exh_reg_payment_details set payment_status='approved', document_status='approved',application_status='approved',application_comment='dashboard' where uid='$registration_id' and `show`='IIJS SIGNATURE 2023'";
	$result_update=$conn ->query($update_query);
	
	if(!$resultUTR) { die('Error: Update query failed' . $conn->error); }
	} else { echo 'Not set '; }
	}
		
/*
	if(sizeof($payment['items']) > 1 ){
		$updtx = "";
	$resultUpdate = $conn ->query();
	} else {

	} */
}
?>