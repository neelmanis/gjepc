<?php
include 'include-new/header.php';
include 'db.inc.php';
include 'functions.php';
header("Location: https://gjepc.org/");
//echo '-----'.$_SESSION['getMobile_no'];
$success = "";
$signup_error = "";
if(!empty($_POST["submit_mobile"])) {
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	unset($_SESSION['getMobile_no']); 	
	$getMobile_no = filter($_POST['mobile_no']);
	if(empty($getMobile_no))
	{ $signup_error = "Please Enter Mobile No";}
	elseif(is_numeric($getMobile_no) == false)
	{ $signup_error = "Please Enter Valid Mobile No";}
	elseif(strlen($getMobile_no)>10 || strlen($getMobile_no)<10)
	{ $signup_error = "Mobile Number should be 10 digits.";}
	elseif(!preg_match("/^[6-9]\d{9}$/",$getMobile_no))
	{ $signup_error = "Please Enter Valid Mobile No"; }
	else {

		$sqlx = "SELECT * FROM `relief_aid` WHERE mobile_no='$getMobile_no' limit 1";
		$result = $conn ->query($sqlx);
		$count = $result->num_rows;
		$getRowx = $result->fetch_assoc();
		if($count>0) {
			
			if($getRowx['application_status']=='Y'){ $error_msg1 = "Application Approved"; }
			elseif($getRowx['application_status']=='C'){ $error_msg2 = "Application Rejected"; }
			else {
			
			$otp = rand(100000,999999); // generate OTP	
			$message = 'One Time Password for mobile verification is '.$otp;
			$otp_sendStatus = get_data($message,$getMobile_no); // Send OTP
			if($otp_sendStatus) {
				$ins = "UPDATE `relief_aid` SET otp='$otp',`otpVerified`='0' WHERE mobile_no='$getMobile_no' limit 1";
				$results = $conn ->query($ins);				
				if(!empty($results)) {
					$_SESSION['getMobile_no']= $getMobile_no;
					$success=1;
				}
			} else {
			$signup_error = "OTP Not sent!";
			}
			}
		} else {
			$signup_error = "You have not registered user for this application !";
		}
	}
	} else {
	 $_SESSION['err_msg']="Invalid Token Error";
	}
}

if(!empty($_POST["submit_otp"])) {
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	$getMobile_no = filter($_SESSION['getMobile_no']);
	$otp = $_POST["otp"];
	$otp=str_replace(" ","",$otp);
	$otp=str_replace(";","",$otp);
	$otp=str_replace("-","",$otp);
	$otp=str_replace("|","",$otp);
	$otp=str_replace("'","",$otp);
	$otp=str_replace("\"","",$otp);
	
	if(empty($otp))
	{ $signup_error = "Please Enter OTP"; }
	else {
	$sqlx = "SELECT * FROM `relief_aid` WHERE mobile_no='$getMobile_no' AND otp='$otp' AND otpVerified='0' limit 1";
	$result = $conn ->query($sqlx);	
	$num = $result->num_rows;;
	if($num>0) {
		$updatex = "UPDATE `relief_aid` SET `otpVerified`='1' WHERE otp='$otp' AND mobile_no='$getMobile_no' limit 1";
		$resultx = $conn ->query($updatex);
		if($resultx){
	//	unset($_SESSION['mobile_no']); 
		$signup_success = "Thanks for the Verification..!! Your applicaiton has been submitted successfully"; 
		header("Location: https://gjepc.org/relief-aid-application-update.php"); exit;
		}
	} else {
		$signup_error = "Invalid OTP!. Please Enter the Valid OTP";
		$success=1;
	}
	}
	
	} else {
	 $_SESSION['err_msg']="Invalid Token Error";
	}
}
?>

<?php
if($_SESSION['err_msg']!=""){
echo "<div class='text-center'><span style='color: red;'>".$_SESSION['err_msg']."</span></div>";
$_SESSION['err_msg']="";
}
?>
<section class="py-5">	
    <div class="container-fluid inner_container">
		<div class="row justify-content-center grey_title_bg">            	
            	 
                
                <div class="innerpg_title_center d-flex mb-3">
                	<img src="assets/images/gold_star.png" class="icon-title mr-4"><h1 class="title d-inline-block form_title align-items-center"> Update- Relief Aid Applications Form </h1><img src="assets/images/gold_star.png" class="icon-title ml-4">
                </div>        
         </div>
                    
            <div class="container">				
                <div class="row justify-content-center">
				
                    <form class="cmxform col-lg-5 box-shadow mb-5" method="POST" name="mobForm" id="mobForm" autocomplete="off">
					<?php token(); ?>
					<?php if(isset($signup_error) && !empty($signup_error)){ echo '<div class="alert alert-danger" role="alert">'.$signup_error.'</div>';} ?>
					<?php if(isset($error_msg1) && !empty($error_msg1)){ echo '<div class="alert alert-success" role="alert">'.$error_msg1.'</div>';} ?>
					<?php if(isset($error_msg2) && !empty($error_msg2)){ echo '<div class="alert alert-danger" role="alert">'.$error_msg2.'</div>';} ?>
					<?php if(isset($signup_success)){ echo '<div class="alert alert-success" role="alert">'.$signup_success.'</div>';} ?>	
					<?php if(!empty($success==1)) { ?>
					<div class="row">                           
                    <div class="form-group col-12">
                    <label for="otp">Enter OTP</label>
                    <input type="text" class="form-control" placeholder="One Time Password" id="otp" name="otp" maxlength="6" autocomplete="off" >
                    </div>
					
					<div class="form-group col-12">
					<label for="subit"></label>
					<input type="submit" class="cta fade_anim" name="submit_otp" value="Submit" class="btnSubmit">
					</div>
					</div>
					
					<?php } else { ?>
                        <div class="row justify-content-center">                           
                            <div class="form-group col-12">
                            <label for="otp">Enter Mobile No for Update Application</label>
							<input type="text" class="form-control numeric" placeholder="Enter Mobile No" name="mobile_no" id="mobile_no" autocomplete="off" maxlength="10"/>
                            </div>
							<div class="col-12">
							<label for="subit"></label>
							<input type="submit" class="cta fade_anim" name="submit_mobile" value="Submit" class="btnSubmit">
							</div>	
						</div>
					<?php } ?>
                    </form>   
					
                </div>                           
            </div>    
	</div>    
    </div>
</section> 
</div>
<?php include 'include-new/footer.php'; ?>

<style>
@media (max-width:600px) {
header, footer {display:none;}
}
.custom-file-label::after {height:38px; padding:0; line-height:38px; width:60px; text-align:center;}
</style>

<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<script type="text/javascript">
$().ready(function() {
	$("#mobForm").validate({
		rules: {  
			mobile_no: {
				required: true,
				number:true,
				minlength: 10,
				maxlength:10
			}
		},
		messages: {
			mobile_no: {
				required:"Please Enter Mobile Number",
				number:"Please Enter Numbers only",
				minlength:"Please enter at least {10} digit.",
				maxlength:"Please enter no more than {0} digit."
			}
		}			
	});
	
$('.numeric').keypress(function (event) {
  var keycode = event.which;
  if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) 
  {
    event.preventDefault();
  }
});

});
</script>