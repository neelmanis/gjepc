<?php 
include('header_include.php');


$total_payable = 10;
$key="2900042967901118";
$payment_mode="9";
$company_pan_no ="AOMPG8472M";
$email_id = "mukesh@kwebmaker.com";
$company_name ="kwebmaker";
$company_bp_no ="6000000";
$event_name = "webinar";
$return_url = "https://gjepc.org/webinar_payment_success.php";
//$_SESSION['ReferenceNo']=$ReferenceNo=rand(100,9999999).time();
$_SESSION['ReferenceNo']=$ReferenceNo="456538";
$submerchantid ="45";

$mandate_str=aes128Encrypt($ReferenceNo."|".$submerchantid."|".$total_payable."|".$email_id."|".$company_name."|".$event_name,$key);
$optional_str=aes128Encrypt("10|10104|Member|Others|Others 2|0",$key);
$return_url_str=aes128Encrypt($return_url,$key);
$reference_str=aes128Encrypt($ReferenceNo,$key);
$submerchant_str=aes128Encrypt($submerchantid,$key);
$amount_str=aes128Encrypt($total_payable,$key);
$payment_mode_str=aes128Encrypt($payment_mode,$key);

$encypted_text="https://eazypay.icicibank.com/EazyPG?merchantid=296793&mandatory fields=".$mandate_str."&optional fields=".$optional_str."&returnurl=".$return_url_str."&Reference No=".$reference_str."&submerchantid=".$submerchant_str."&transaction amount=".$amount_str."&paymode=".$payment_mode_str;

// echo  $encypted_text="https://eazypay.icicibank.com/EazyPG?merchantid=3300224705&mandatory fields=".$ReferenceNo."|1|".$total_payable."|".$email_id."|".$company_name."|".$company_pan_no."&optional fields=".$company_bp_no."&returnurl=".$return_url."&Reference No=".$ReferenceNo."&submerchantid=".'1'."&transaction amount=".'10'."&paymode=".'2';exit;

header('location:'.$encypted_text);exit;
?>