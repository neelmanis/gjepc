<?php
 include('header_include.php');
// print_r($_SESSION['USERID']);exit;
if(!isset($_SESSION['USERID'])){ header("location:login.php"); exit; }

require('razorpay/membership_config.php');
require('razorpay/razorpay-php/Razorpay.php');

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$success = true;
 $error = "Payment Failed";
$registration_id = intval(filter($_SESSION['USERID'])); 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $event_name; ?> Payment </title>
<link rel="shortcut icon" href="images/fav.png" />
	<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
	<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
	<link rel="stylesheet" type="text/css" href="css/general.css" />
	<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css" />	 
	<link rel="stylesheet" type="text/css" href="css/responsive.css" />
	<link rel="stylesheet" type="text/css" href="css/media_query.css" />
	<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>

	<!--NAV-->
	<link href="css/flexnav.css" media="screen, projection" rel="stylesheet" type="text/css">
	<script src="js/jquery.flexnav.js" type="text/javascript"></script>
	<script src="js/common.js"></script> 
	<!--NAV-->

	<!-- UItoTop plugin -->
	<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css" />
	<script src="js/easing.js" type="text/javascript"></script>
	<script src="js/jquery.ui.totop.js" type="text/javascript"></script>    
	<script type="text/javascript">
		$(document).ready(function() {        
			$().UItoTop({ easingType: 'easeOutQuart' });        
		});
	</script>
</head>

<body>
<div class="wrapper">

<div class="header"><?php include('include-new/header.php'); ?></div>
<div class="inner_container">
<div class="container">
<div class="container_leftn">

<?php
 $razorpay_payment_id =  $_POST['razorpay_payment_id'];

if (empty($_POST['razorpay_payment_id']) === false)
{ 
    $api = new Api($keyId, $keySecret);

    try
    {
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but
        // could be database or something else)
        $attributes = array(
            'razorpay_order_id' => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );

        $api->utility->verifyPaymentSignature($attributes);
    }
    catch(SignatureVerificationError $e)
    {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}
$api = new Api($keyId, $keySecret);
		
		$payment = $api->payment->fetch($_POST['razorpay_payment_id']);
		
	
	$razorpay_payment_id =  $_POST['razorpay_payment_id'];
    $razorpay_signature = $_POST['razorpay_signature'];
    $razorpay_order_id = $_SESSION['razorpay_order_id'];
    $error_description =  $payment->error_description;
	$card_id =  $payment->card_id;
	$bank =  $payment->bank;
	$payment_status =  $payment->status;
	$method =  $payment->method;
	$currency =  $payment->currency;
	$order_id =  $payment->order_id;
	$payment_date = date('Y-m-d',$payment->created_at);
	$notes_response = $payment->notes;
	$merchant_order_id = $notes_response->merchant_order_id;
	$amountPaid = $notes_response->amountPaid;
	$merchant_order_id =  $_SESSION['ReferenceNo'];
	$post_date=date('Y-m-d');
	if($merchant_order_id!='' && $razorpay_order_id!='' && !empty($registration_id)){
	/*
	* Update Order ID in challan master
	*/
	 $sql_update_challan="update challan_master  set razorpay_payment_id =  '$razorpay_payment_id',`razorpay_signature`='$razorpay_signature',`Transaction_Date`='$payment_date',`Response_Code`='$payment_status' , `method`='$method',`bank`='$bank',card_id='$card_id' where `registration_id`='$registration_id' AND `razorpay_order_id`='$razorpay_order_id' AND `merchant_order_id`='$merchant_order_id' ";
	
	$result_update_challan = $conn->query($sql_update_challan);
	if(!$result_update_challan) { die('Error: Update challan Failed - ' . $conn->error); }
	/*====================================================================================================*/
	
	/*
	* Update Order ID in payment log
	*/
	//echo $payment_status;
    if($payment_status =="captured"){
    	//echo "update approval_master set payment_approve='Y',apply_membership_renewal='Y',membership_type='R',renewal_download_status='N',membership_expiry_status='N',membership_renewal_dt='$post_date',post_date='$post_date' where registration_id='$registration_id'";exit;

		$result2 = $conn ->query("update approval_master set payment_approve='Y',apply_membership_renewal='Y',membership_type='R',renewal_download_status='N',membership_expiry_status='N',membership_renewal_dt='$post_date',post_date='$post_date' where registration_id='$registration_id'");

	$html_email = "";
    $html_email .='<table cellpadding="10" width="100%" style="margin: 0px auto; font-family: Roboto; background-color: #fff; padding: 15px; border-collapse: collapse; border: 1px solid #000;">
				<tr>
		        	<td colspan="2" style="background-color: #a89c5d; padding: 3px;"></td>
		      	</tr>
				<tr>
	            	<td colspan="2" align="left"><img id="ri" src="https://registration.gjepc.org/images/logo.png"></td>                        
		      	</tr>
		      
			  	<tr>
		  			<td colspan="2">
		  			    <p>Dear  <strong>Member</strong>, </p>
		  			    <p>Thank you so much  for  renewing your  GJEPC membership for the year 2022-23 , you are requested to please fill and update your form by clicking link <a href="https://gjepc.org/dgft-form.php">https://gjepc.org/dgft-form.php</a> and apply for RCMC on DGFT portal <a href="https://www.dgft.gov.in">https://www.dgft.gov.in</a>  and  fill-up  all the details.</p>
		  			</td>			  
			  	</tr>  	  									
			</table>';
	$message = $html_email;
	
	$to_email_id = getUserEmail($registration_id,$conn);
	//$to_email_id = "santosh@kwebmaker.com";
    $cc = "";
	$subject = "Apply for RCMC on DGFT"; 
	$mail_sent = send_mail($to_email_id, $subject, $message,$cc);

    $mobile =  getAuthPersonMobile($registration_id,$conn);
    
	$fy = "2022-23";
	$link = "https%3A%2F%2Fwww.dgft.gov.in";
	$dgft = "Your membership for $fy renewed%2C apply for RCMC on DGFT portal $link in fill-up details as per PDF.";
	send_sms($dgft,$mobile);
    }

	 // echo "UPDATE  challan_payment_log SET Response_Code='$payment_status' ,`merchant_order_id`='$merchant_order_id',`razorpay_order_id`='$razorpay_order_id' WHERE registration_id='$registration_id' AND ReferenceNo='$merchant_order_id'";exit;


	$rz_pay_log = $conn ->query("UPDATE  challan_payment_log SET Response_Code='$payment_status' ,`merchant_order_id`='$merchant_order_id',`razorpay_order_id`='$razorpay_order_id' WHERE registration_id='$registration_id' AND ReferenceNo='$merchant_order_id'");
	$result_pay_log = $conn->query($rz_pay_log);

	if($success === true)
	{
	    $html = "<p>Your payment was successful</p>
	             <p>Payment ID: {$_POST['razorpay_payment_id']}</p>";
	}
	else
	{
	    $html = "<p>Your payment failed</p>
	             <p>{$error}</p>";
	}


	}

?>
<div class="container_wrap">
	<div class="container" id="manualFormContainer">
	<h1 style="color:green;">PAYMENT </h1>
	<div id="formWrapper">
	<p><?php echo $html;?></p>
	</div>
	<div class="clear"></div>
	</div>
</div>

</div>
  </div>
  </div>


<?php include ('include-new/footer.php'); ?>

</div>
<!--footer ends-->
</body>
</html>