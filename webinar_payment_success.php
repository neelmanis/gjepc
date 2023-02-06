<?php 

include('header_include.php');
require('razorpay/webinar_config.php');
require('razorpay/razorpay-php/Razorpay.php');
use Razorpay\Api\Api;
$payment_id= $_REQUEST['payment_id'];
$isFree = $_REQUEST['isFree'];
if($isFree =="no"){
   $api = new Api($keyId, $keySecret);
   $payment = $api->payment->fetch($payment_id);
   $notes = $payment->notes;
   $event_name = $notes->event_name;
   $order_id = $payment->order_id; 
}else{
     
     $webinar_id = $_REQUEST['webinar'];
     $sql_webinar = "SELECT * FROM webinar_master WHERE id = '$webinar_id' ";
     $result_webinar = $conn->query($sql_webinar);
     $row_webinar = $result_webinar->fetch_assoc();
     $event_name = $row_webinar['title'];
     $order_id = $payment_id; 

}


?>

<?php include 'include-new/header.php'; ?>
<section>
    <div class="container inner_container">
        <div class="row justify-content-center mb-0 mt-3">
            <div class="col-12 text-center">
                <h1 class="bold_font"><div class="d-block"><img src="assets/images/gold_star.png"></div>
                <?php echo strtoupper($event_name); ?></h1>

            </div>
        </div>

        <div class="row">
       <div class="col-12">
            <div class="jumbotron" style="box-shadow: 2px 2px 4px #000000;">

                <center><div class="btn-group" >
                <img src="./assets/images/pay-success-icon.png" class="img-fluid">
            </div></center>
            <h3 class="bold_font text-center mb-2">YOUR ORDER HAS BEEN RECEIVED</h3>
          <h3 class="text-center">Thank you for your payment, it’s processing</h3>
          
          <p class="text-center">Your order # is: <b><?php echo $order_id; ?></b></p>
          <p class="text-center">You will receive an order confirmation email with details .</p>
            
        </div>
       </div>
    </div>
    </div>
</section>
<?php include 'include-new/footer.php'; ?>




?>