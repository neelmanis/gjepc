<?php 
session_start(); 
include('../db.inc.php'); 
include('../functions.php'); 
$msg='';

$action=$_REQUEST['action'];
if($action=="reset")
{
if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
$email = filter($_POST['email']); 

if(empty($email)){
	$msg = "Invalid email address please type a valid email address!";	
	} else {
		$sql = "SELECT * from admin_master where email_id=? AND status='1' limit 1";
		$query = $conn -> prepare($sql);
		$query->bind_param("s", $email);
		$query->execute();			
		$result = $query->get_result();
		$count  = $result->num_rows;
		
		if($count>0)
		{
		   $token = md5( rand(0,1000) );
		   
		   $updx = "UPDATE admin_master SET token='".$token."' WHERE email_id='".$email."' AND status='1'";
		   $resultx = $conn ->query($updx);
			// Send email to user with the token in a link they can click on
			if($resultx){
	/*.......................................Send mail to Admin users mail id...............................................*/
$message ='<table cellpadding="10" width="65%" style="margin:0px auto;font-family: Roboto; background-color:#eeee;padding:30px; border-collapse:collapse;">
<tr><td style="background-color:#744F9E;padding:3px;"></td></tr>
  <tr><td align="left"><img src="https://gjepc.org/assets/images/logo.png"> </td></tr>
  <tr><td><h4 style="margin:0;">Dear Admin user</h4></td></tr>
  <tr>
    <td align="left"  style="text-align:justify;">Please click this link to activate your account:<br/>
	<p><a href="https://gjepc.org/admin/reset-password.php?token='.$token.'&email_id='.$email.'&action=reset" target="_blank">
https://gjepc.org/admin/reset-password.php?token='.$token.'&email_id='.$email.'&action=reset</a></p></td>
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
  
	/* $to = $email;
	 $subject  = "Reset your Admin Password";
	 $cc = "";
	 send_mail($to,$subject,$message,$cc);
	 */
	 $to = $email;
	 $subject  = "Reset your Admin Password";
	 $headers  = 'MIME-Version: 1.0' . "\n"; 
	 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
	 $headers .= 'From: GJEPC ADMIN <admin@gjepc.org>';
	 mail($to, $subject, $message, $headers);
	 $_SESSION['succ_msg']="An email has been sent to you with instructions on how to reset your password";
	 } else {
	 $_SESSION['err_msg']="There is some technical problem";
	 }
	
		} else {
			$msg = "No Admin user is registered with this email address or Your Account is deactivated !";	
		}
	} 
} else {
	 $msg = "Invalid Token Error";
}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reset Password || GJEPC ||</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />
<script language="javascript">
function checkform()
{
	if(document.idpform.email.value=='')
	{
		alert("Please enter Email")
		document.idpform.email.focus();
		return false;
	}
}
</script>
</head>

<body>
<div id="header_wrapper">
	<div class="header">
     	<div class="logo"><img src="images/logo.png" /></div>
        <div class="punch_line">Gems and Jewellery Export Promotion Council (GJEPC)</div>
	</div>	
</div>

<div id="container">
		<div class="login_cont">
       	  <div class="head"><img src="images/lock.png" style="vertical-align:middle" /> Reset Your Password</div>
            
			<form id="idpform" name="idpform" method="POST" onSubmit="return checkform()" autocomplete="off">
			<input type="hidden" name="action" value="reset" />
			<?php token(); ?>
			
            <table width="540" class="login">
                <tr>
                    <td height="21">&nbsp;</td>
                    <td colspan="2" class="error_msg"> <?php if($msg!=''){ echo $msg; }  ?></td>
					<?php 
					if($_SESSION['err_msg']!=""){
					echo "<div class='text-center'><span style='color: red;'>".$_SESSION['err_msg']."</span></div>";
					$_SESSION['err_msg']="";
					}
					if($_SESSION['succ_msg']!=""){
					echo "<div class='text-center py-5'><span style='color: green;'>".$_SESSION['succ_msg']."</span></div>";
					$_SESSION['succ_msg']="";
					}?>
                </tr>            
                <tr>
                    <td>&nbsp;</td>
                    <td width="174" class="txt3">Email</td>
                    <td width="333"><input type="email" name="email" id="email" autocomplete="off" class="input_txt1" placeholder="username@gjepcindia.com"/></td>
                </tr>                
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td ><input type="submit" value="Reset Password" class="input_submit" /></td>
                </tr>
            
            </table>
            </form>
          </div>
</div>
<div id="footer_wrap">Developed by <a href="http://kwebmaker.com/" target="_blank">K Webmaker™</a></div>
</body>
</html>