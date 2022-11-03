<?php 
include('header_include.php');
$membertype=$_REQUEST['membertype'];
$action=$_REQUEST['action'];
if($action=="send")
{   
	$_SESSION['membertype']  =	$_REQUEST['membertype'];
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
		
	$membertype	=	filter($_REQUEST['membertype']);
	$username	=	filter($_REQUEST['username']);
	$email_id	=	filter($_REQUEST['email_id']);
	$iec_no		=	filter($_REQUEST['iec_no']);
	
	if(empty($membertype))
	{ $signup_error="Please Select Member Type"; }
	else if($username=='' && $email_id=='' && $iec_no=='' )
	{ $signup_error="Please enter atleast one field"; }
	else {
	if($membertype=="Agent"){
    $query=mysqli_query($conn,"select USER_NAME,PASSWORD,EMAIL from kp_agent_master where USER_NAME='$username' or IEC_NO='$iec_no' or EMAIL='$email_id'");
	}else if($membertype=="Member"){
	$query=mysqli_query($conn,"select USER_NAME,PASSWORD from  kp_member_master where MEMBER_CO_EMAIL='$email_id'");
	}
	else if($membertype=="NonMember"){
	$query=mysqli_query($conn,"select USER_NAME,PASSWORD,EMAIL from kp_non_member_master where USER_NAME='$username' or EMAIL='$email_id' or IEC_NO='$iec_no'");
	}
	$result=mysqli_fetch_assoc($query);	
	
	$USER_NAME=$result['USER_NAME'];
	$PASSWORD=$result['PASSWORD'];
	
	$num=mysqli_num_rows($query);
	if($num>0){
	/*.......................................Send mail to users mail id...............................................*/
    $message ='<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:"Lucida Sans"; font-size:14px; color:#333333; text-align:justify; ">
  <tr>
    <td colspan="2"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
         <td width="150" align="left"><img src="https://gjepc.org/assets/images/logo.png" width="150" height="91" /></td>
        </tr>
      </table>
	 </td>
  </tr>
  
  <tr>
    <td height="10" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; color:#990000; border-bottom: solid thin #666666;">&nbsp;</td>
  </tr>
  
  <tr>
    <td height="30" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Dear </td>
  </tr>
  
	<tr>
		<td>&nbsp; </td>
	</tr>
	
  <tr>
  <td align="left"  style="text-align:justify;">You may now log in to https://gjepc.org/kp/login.php using the following<br/>  </td>
  </tr>
  
  <tr>
    <td align="left"  style="text-align:justify;"><strong>User Name :</strong> '. $USER_NAME .' </td>
  </tr>
  
  <tr>
    <td align="left"  style="text-align:justify;"><strong>Password :</strong> '. $PASSWORD .'</td>
  </tr>
  
  <tr>
    <td>&nbsp; </td>
  </tr>
  
  <tr>
    <td>&nbsp; </td>
  </tr>
  
  <tr>
    <td height="22" align="left"  style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Kind Regards,</td>
  </tr>
  <tr>
    <td align="left"><strong>KP Web Team,</strong></td>
  </tr>
 </table>';
	
	 $to=$result['EMAIL'];
	 $subject = "Forgot Password Of KP ".$membertype; 
	 $headers  = 'MIME-Version: 1.0'."\n\r"; 
	 $headers .= 'Content-type: text/html; charset=iso-8859-1'."\n\r"; 
	 $headers .= 'From: admin@gjepc.org';			
     @mail($to, $subject, $message, $headers);
		 
	    $_SESSION['succ_msg']="Your password has been sent to your email id";
	 }
	 
	 else
	 {
	    $_SESSION['err_msg']=" There is a problem in sending mail please contact to Admin";
	 }
	}
	 } else {
	 $_SESSION['err_msg']="Invalid Token Error";
	}
}
?>

<?php include('include-new/header.php');?>

<section class="py-5">
		
	<div class="container-fluid">
    
    <div class="bold_font text-center"> <div class="d-block"><img src="assets/images/gold_star.png"></div>Forgot Password </div>
		
		<!--<div class="row justify-content-center grey_title_bg">
        
        
			
				<div class="innerpg_title_center d-flex mb-3">
                	<img src="assets/images/black_star.png" class="icon-title mr-4"><h1 class="title d-inline-block form_title align-items-center"> FORGOT PASSWORD</h1><img src="assets/images/black_star.png" class="icon-title ml-4">
                </div>
		</div>-->
        
		<div class="container">
			<div class="row justify-content-center">
				<form action="" method="post" name="changepassword" id="changepassword" autocomplete="off" class="col-lg-6 box-shadow mb-5">
					<?php token(); ?>
					<?php					
					if($_SESSION['succ_msg']!=""){
					echo "<div class='alert alert-success' role='alert'>".$_SESSION['succ_msg']."</div>";
					$_SESSION['succ_msg']="";
					}
					if($_SESSION['err_msg']!=""){
					echo "<div class='alert alert-danger' role='alert'>".$_SESSION['err_msg']."</div>";
					$_SESSION['err_msg']="";
					}

					if(isset($signup_error)!=""){
					echo "<div class='alert alert-danger' role='alert'>".$signup_error."</div>";

					$signup_error="";
					}
					?>
					<div class="row">										
						<div class="col-md-12  form-block  col-sm-12 col-xs-12 loginform">
							<div class="form-group">		
								<!--<label>Select Member</label>-->
								 <select name="membertype" class="login_text_bgtext form-control" id="membertype" onchange="MM_jumpMenu('parent',this,0)">
							      <option value="">--- Select Member---</option>
							      <option value="Agent" <?php if($_SESSION['membertype']=='Agent'){echo "selected";}?>>--- Agent ---</option>
							      <option value="Member" <?php if($_SESSION['membertype']=='Member'){echo "selected";}?>>--- Member ---</option>
							      <option value="NonMember" <?php if($_SESSION['membertype']=='NonMember'){echo "selected";}?>>--- NonMember ---</option>
    							</select>
							</div>
							<div class="form-group">
<!--								<label>Username</label>
-->                                <input type="text" class="form-control" value="" id="username" name="username" placeholder="Username" autocomplete="off"/>
							</div>
							<div class="form-group text-center blue"> OR</div>
							<div class="form-group">
<!--								<label>Email-Id</label>
-->
								<input type="text" class="form-control" value="" id="email_id" name="email_id" placeholder="Email - id" autocomplete="off"/>
							</div>
                            
							<div class="form-group text-center blue"> OR</div>

							<div class="form-group">
								<!--<label class="IEC Number"></label>-->
                            <input type="text" class="form-control" value="" id="iec_no" name="iec_no" placeholder="IEC Number" autocomplete="off"/>
								
							</div>
							<div class="form-group">
								<input type="hidden" name="action" value="send" />
                                <input type="submit"  name="submit" value="submit" class="cta" />
							</div>

							<p class="blue">If you do not receive your new password within a few minutes please contact us at:</p>
                            
                            <div class="row">
                            	
                                <div class="col-sm-6 mb-4 mb-sm-0">
                                	<p class="blue">(KP Import / Export Authority) </p>
					
									<p> Office No. BW 1010, Tower B, G Block, Bharat Diamond Bourse, Next to ICICI Bank, Bandra-Kurla Complex, Bandra - East,Mumbai - 400 051, India</p>
                                </div>
                                
                                <div class="col-sm-6">
                                              
                               		<p><strong>Tel:</strong> +91 22 26544713/14/15 </p>
									<p><strong>Email:</strong> <a href="mailto:kp@gjepcindia.com">kp@gjepcindia.com</a> </p>
									<p><strong>Website:</strong> <a href="https://gjepc.org/"> www.gjepc.org </a> </p>
				
                                </div>
                                
                                
                            </div>
                            
				
				
						</div>
					</div>		
					

				</form>


		</div>
	</div>

</div>



<?php include('include-new/footer.php');?>

</body>
</html>