<?php
// echo "nmbnbf";exit;
require('razorpay/membership_config.php');
require('razorpay/razorpay-php/Razorpay.php');


if(!isset($_SESSION['USERID'])){ header("location:login.php"); exit; }
// Create the Razorpay Order

use Razorpay\Api\Api;

$api = new Api($keyId, $keySecret);
$amountPay = $total_payable;
// $amountPay = 1;  
if(!is_numeric($amountPay)){
    echo 'Please check amount'; exit;
}

$orderId = $ReferenceNo;
$_SESSION['orderId'] = $orderId;
     
$orderData = [
    'receipt'         => $orderId,
    'amount'          => $amountPay * 100,
    'currency'        => 'INR',
    'payment_capture' => 1 // auto capture
];


$razorpayOrder = $api->order->create($orderData);

$razorpayOrderId = $razorpayOrder['id'];

$_SESSION['razorpay_order_id'] = $razorpayOrderId;

$displayAmount = $amount = $orderData['amount'];

if ($displayCurrency !== 'INR')
{
    $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
    $exchange = json_decode(file_get_contents($url), true);

    $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
}

/*$checkout = 'automatic';

if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true))
{
    $checkout = $_GET['checkout'];
} */

$data = [
    "key"               => $keyId,
    "amount"            => $amount,
    "name"              => "GJEPC",
    "description"       => "Membership Application Payment",
    "image"             => "https://gjepc.org/assets/images/logo.png",
    "prefill"           => [
        "name"          => "GJEPC",
        "email"         => $email_id,
        "contact"       => "",
    ],
    "notes"                 => [
        'company_name'              => strtoupper(str_replace(array('&amp;','&AMP;'), '&', $company_name)),
        'registration_id'   => trim($_SESSION['USERID']),
        'amountPaid'        => $amountPay,
        'merchant_order_id' => $orderData['receipt'],
        'email_id' => $email_id,
        'comoany_pan_no' => $comoany_pan_no,
        'company_bp_no' => $company_bp_no,
        'region'=> $region_id
    ],
    "theme"             => [
    "color"             => "#F37254"
    ],
    "order_id"          => $razorpayOrderId,
];

if ($displayCurrency !== 'INR')
{
    $data['display_currency']  = $displayCurrency;
    $data['display_amount']    = $displayAmount;
}

$json = json_encode($data);

$registration_id =  $_SESSION['USERID'];
$merchant_order_id = $orderData['receipt'];
$payment_date = date('Y-m-d');


/*
* Update Order ID in challan master
*/
  $sql_update_challan="update challan_master  set Unique_Ref_Number='$razorpayOrderId', razorpay_order_id='$razorpayOrderId',merchant_order_id='$merchant_order_id' where registration_id='$registration_id' and challan_financial_year='$cur_fin_yr'";
$result_update_challan = $conn->query($sql_update_challan);
if(!$result_update_challan) { die('Error: Update challan Failed - ' . $conn->error); }
/*===============================================================================================================*/
/*
* Update Order ID in payment log
*/

$rz_pay_log = $conn->query("UPDATE  challan_payment_log SET `merchant_order_id`='$merchant_order_id',`razorpay_order_id`='$razorpayOrderId' WHERE `registration_id`='$registration_id' AND `ReferenceNo`='$merchant_order_id'");

$result_pay_log = $conn->query($rz_pay_log);


?>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<form name='razorpayform' action="membership_verify.php" method="POST">
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
    <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
</form>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script>
// Checkout details as a json
var options = <?php echo $json?>;

/**
 * The entire list of Checkout fields is available at
 * https://docs.razorpay.com/docs/checkout-form#checkout-fields
 */
options.handler = function (response){
    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
    document.getElementById('razorpay_signature').value = response.razorpay_signature;
    document.razorpayform.submit();
};

// Boolean whether to show image inside a white frame. (default: true)
options.theme.image_padding = false;

options.modal = {
    ondismiss: function() {
        console.log("This code runs when the popup is closed");
        window.location.reload();
    },
    // Boolean indicating whether pressing escape key 
    // should close the checkout form. (default: true)
    escape: true,
    // Boolean indicating whether clicking translucent blank
    // space outside checkout form should close the form. (default: false)
    backdropclose: false
};

var rzp = new Razorpay(options);

$(document).ready(function(){
    rzp.open();
//    e.preventDefault();   
});
</script>