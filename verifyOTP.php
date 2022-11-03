<?php include 'include/header.php'; ?>
<?php
include 'db.inc.php';

if(isset($_SESSION['mobile_no'])){  $getMobile_no = $_SESSION['mobile_no'];   } else { header('location:relief-aid-applications-form.php'); }
$success = "";
if(!empty($_POST["submit_otp"])) {
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {

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
	$sqlx = "SELECT * FROM `relief_aid` WHERE mobile_no='$getMobile_no' and otp='$otp' and otpVerified='0'";
	$result = $conn ->query($sqlx);
	$rowsData = $result->fetch_assoc();
	$getMobile_no = $rowsData['mobile_no'];
		
	$num = $result->num_rows;;
	if($num>0) {
		$updatex = "UPDATE `relief_aid` SET `otpVerified`='1' WHERE otp='$otp' AND mobile_no='$getMobile_no'";
		$resultx = $conn ->query($updatex);
		if($resultx){
		unset($_SESSION['mobile_no']); 
		$signup_success = "Thanks for the Verification..!! Your applicaiton has been submitted successfully"; 
		$success = 1; 
		header("Refresh: 3; url=https://gjepc.org/relief-aid-applications-form.php");
		}
	} else {
		$signup_error = "Invalid OTP!. Please Enter the Valid OTP";
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
<section>	
    <div class="container-fluid inner_container">
		<div class="row justify-content-center grey_title_bg">    
        	
            	<div class="innerpg_title_center">
                	<h1>GJEPC- Relief Aid Applications Form  </h1>
                </div>            
         </div>
                    
            <div class="container">				
                <div class="row">
				
                    <form class="cmxform col-12 box-shadow mb-5" method="post" name="otpForm" id="otpForm" autocomplete="off">
					<?php token(); ?>
					<?php if(isset($signup_error)){ echo '<div class="alert alert-danger" role="alert">'.$signup_error.'</div>';} ?>
					<?php if(isset($signup_success)){ echo '<div class="alert alert-success" role="alert">'.$signup_success.'</div>';} ?>	
					<?php if(!empty($success==1)) { } else {?>
					<p class="text-center mb-4"><strong>Verify OTP</strong></p>
                        <div class="row">                           
                            <div class="form-group col-sm-6">
                            <label for="otp">Enter OTP</label>
                            <input type="text" class="form-control numeric" placeholder="One Time Password" id="otp" name="otp" maxlength="5" autocomplete="off" >
                            </div>
						</div>		
                        
                        <ul class="form-group p-3 inner_under_listing" style="height:200px; overflow-y:scroll; border:1px solid #ddd;">
                        	<li>This form needs to be submitted by the Applicant who must be a daily wage worker of the gem and jewellery industry only.</li>

<li>The industry reference company name provided by the Applicant will be verified with the available records and confirmed with the owner / Head Karigar / Registered Association, as the case may be, by calling them, and in case of any mismatch or false information, the application form will be rejected.</li>

<li>The bank details provided by the applicant have been self-verified by the applicant before submitting the form.</li>

<li>All the identity details as submitted by the applicant will be verified with the available govt. records and in case of any mismatch or false information the application form will be rejected.</li>

<li>The applicant hereby declares and submits its Aadhar card details willingly to avail the benefits.</li>

<li>Parichay card holders are not required to submit Photo ID proofs.</li>

<li>Applicant must submit a photo or scanned copy of Bank Statement and other desired details on WhatsApp no. _______ or email us at ___________, once he/she has submitted the registration form online.</li>

<li>Applicant must please note that submission of this form does not give him / her any right to claim for the Aid, GJEPC reserve the absolute right to accept or reject the application, without giving any reason thereof.</li>

<li>The Applicant hereby declare and confirm that all the details and information submitted are true and correct, and in case of any incorrect information provided, the application form will be rejected.</li>
                        </ul>
                        
                        <div class="form-group">
                            <label for="I Agree" class="mr-3">
                            <input type="checkbox" name="agree" id="agree" value="1" class="mr-2">I Agree <label for="agree" generated="true" style="display: none;" class="error"></label></label>            
                        </div>
                        
                        			
              			<div class="form-group">
							<input type="submit" class="cta fade_anim" name="submit_otp" value="Submit" class="btnSubmit">
                        </div>	
					<?php } ?>
                    </form>                                   
                </div>                           
            </div>    
	</div>    
    </div>
</section> 
</div>
<?php include 'include/footer.php'; ?>

<style>
@media (max-width:600px) {
header, footer {display:none;}
}
.custom-file-label::after {height:38px; padding:0; line-height:38px; width:60px; text-align:center;}
</style>

<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<script type="text/javascript">
$().ready(function() {
	// validate signup form on keyup and submit
	$("#otpForm").validate({
		rules: {  
			otp: {
				required: true,
				number:true
			},
			agree:	{
				required: true,
			}
		},
		messages: {
			otp: {
				required:"Please Enter OTP",
				number:"Please Enter Valid OTP only"
			},
			agree:{
				required:"Please Enter OTP",
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