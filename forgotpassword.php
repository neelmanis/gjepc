<?php
include 'include-new/header.php';
include 'db.inc.php'; 
include 'functions.php'; 
$action=$_REQUEST['action'];
if($action=="send")
{   
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
		
	$email_id = filter($_REQUEST['email_id']);
	if(empty($email_id)){
	$msg = "Invalid email address please type a valid email address!";	
	} else {
    $query = $conn ->query("select * from registration_master where email_id='$email_id' and status='1' limit 1");
	$num = $query->num_rows;
	if($num>0){
	$token = md5(rand(0,1000));
		   
	$updx = "UPDATE registration_master SET token='".$token."' WHERE email_id='".$email_id."' AND status='1' limit 1";
	$resultx = $conn ->query($updx);
	// Send email to user with the token in a link they can click on
	if($resultx){
	/*.......................................Send mail to Admin users mail id...............................................*/
$message ='<table cellpadding="10" width="65%" style="margin:0px auto;font-family: Roboto; background-color:#eeee;padding:30px; border-collapse:collapse;">
<tr><td style="background-color:#744F9E;padding:3px;"></td></tr>
  <tr><td align="left"><img src="https://www.gjepc.org/assets/images/logo.png"> </td></tr>
  <tr>
    <td align="left" style="text-align:justify;">Please click this link to activate your account:<br/>
	<p><a href="https://gjepc.org/reset-pass.php?token='.$token.'&email_id='.$email_id.'&action=reset" target="_blank">https://gjepc.org/reset-pass.php?token='.$token.'&email_id='.$email_id.'&action=reset</a></p></td>
  </tr>
  <tr> 
  <td><p>Please be sure to copy the entire link into your browser.The link will expire after 1 day for security reason.</p><p>If you did not request this forgotten password email, no action is needed, your password will not be reset.</p></td>
  </tr>
   <tr>
   <td>       
      <p>Kind Regards,<br>
      <b>GJEPC Web Team,</b>
      </p>
    </td>
  </tr>
</table>';
  
	 $to = $email_id;
	 $subject = "Reset your Password";
	 $cc = "";
	 send_mail($to,$subject,$message,$cc);
	 
	/*
	 $headers  = 'MIME-Version: 1.0' . "\n"; 
	 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
	 $headers .= 'From: GJEPC ADMIN <admin@gjepc.org>';			
     @mail($to, $subject, $message, $headers);
	 */
     $_SESSION['succ_msg']="An email has been sent to you with instructions on how to reset your password";
	 } else {
	 $_SESSION['err_msg']="There is some technical problem";
	 }
	} else {
	   $_SESSION['err_msg']="No user is registered with this email address or Your Account is deactivated !";
	 }	
	}
	} else {
	 $_SESSION['error_msg']="Invalid Token Error";
	}
}
?>
<?php 

if($_SESSION['err_msg']!=""){
echo "<div class='text-center'><span style='color: red;'>".$_SESSION['err_msg']."</span></div>";
$_SESSION['err_msg']="";
}
if($_SESSION['succ_msg']!=""){
echo "<div class='text-center'><span style='color: green;'>".$_SESSION['succ_msg']."</span></div>";
$_SESSION['succ_msg']="";
}
?>

<div class="container py-5">


<div class="row justify-content-center grey_title_bg">      
<div class="bold_font text-center"> <div class="d-block"><img src="assets/images/gold_star.png"></div> Forgot password  </div>
</div>

<div class="row justify-content-center">
	

	<form id="forgetpassword" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" class="col-lg-5 box-shadow">
	<input type="hidden" name="action" value="send" />
	<?php token(); ?>
			<div class="col-md-12 col-sm-12 col-xs-12 loginform">
								
				<div class="form-group minibuffer">
				    <input type="text" class="form-control" id="email_id" name="email_id" placeholder="Email ID"/>
				</div>
                <div class="form-group">
				<button type="submit" class="cta fade_anim">Submit</button>
                </div>
                
				<p style="font-size:13px;">If you do not receive your new password within a few minutes please contact us at:</p>
				<p style="font-size:13px;">The Gem & Jewellery Export Promotion Council (Web Team)</h6>
				<p style="font-size:13px;"><a href="mailto:Email- membership@gjepcindia.com">Email- membership@gjepcindia.com</a></p>
                
                
                <div class="form-group mb-0">
                        	<div class="d-flex ab_none justify-content-between pt-3" style="border-top:1px solid #ddd;">
                                    <div><a href="login.php" class="ab_none d-block"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a></div>
                                    <div><a href="registration.php" class="ab_none d-block"> Register Now </a></div>
                                </div>
                    	
                </div>
			</div>
		</form>
</div>

</div>

<?php include 'include-new/footer.php'; ?>
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<script type="text/javascript">
$().ready(function() {
	$("#forgetpassword").validate({
		rules: {  
			email_id: {
				required: true,
				email:true
			}
		},
		messages: {
			email_id: {
				required: "Please Enter a valid Email id",
			}
	 }
	});
});
</script>
<!--<style>
.loginform {padding:20px; margin-top:20px; border-top:3px solid #77479b; background:#eee;}
.form-control {font-size:14px; height:40px; padding:8px;}
.btn-default {font-size:14px; cursor:pointer!important; background:#77479b; color:#fff; transition:all 0.3s ease-in-out; -webkit-transition:all 0.3s ease-in-out; -moz-transition:all 0.3s ease-in-out; -o-transition:all 0.3s ease-in-out;}
.btn-default:hover {background:#000; transition:all 0.3s ease-in-out; -webkit-transition:all 0.3s ease-in-out; -moz-transition:all 0.3s ease-in-out; -o-transition:all 0.3s ease-in-out;}
.container p {margin-bottom:0;}
.loginlinks {font-size:12px; text-decoration:underline; padding:5px 0;} 
.loginlinks a.btn-default {color:#fff; margin-top:10px;}
</style>-->
