<?php 
$pageTitle = "Gems & Jewellery Industry | Log In - GJEPC India";
?>

<?php
include 'include-new/header.php';
include 'db.inc.php'; 

$checkInFor = $_SESSION['checkInFor'];
$action=$_REQUEST['action'];
if($action=="login")
{
$email_id= filter(mysqli_real_escape_string($conn,$_POST['email_id'])); 
$password= filter(mysqli_real_escape_string($conn,$_POST['ur_password'])); 
$email_id= str_replace(" ","",$email_id);
$password= md5(str_replace(" ","",$password));

//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {

if(empty($email_id))
{$signup_error="Please Enter Username";}
elseif(empty($password))
{$signup_error="Please Enter Password";}
elseif(empty($_SESSION['captcha_code'] ) ||  strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0)
	{
		$_SESSION['succ_msg']= "The captcha code does not match!";
	} else {	
    $query  = $conn->query("select * from registration_master where email_id='$email_id' and company_secret='$password' and status='1'");
	$result = $query->fetch_assoc();
    $num = $query->num_rows;
	if($num == 1)
	{	
	  $_SESSION['USERID']= filter($result['id']);
	  $_SESSION['EMAILID']= filter($result['email_id']);
	  $_SESSION['COMPANYNAME']=strtoupper($result['company_name']);
	  $_SESSION['USER_GCODE']=$result['gcode'];
	  $_SESSION['mobile_no']=$result['mobile_no'];
	  $_SESSION['sez_member']=$result['sez_member'];
	  
	$sqlx = "update registration_master set lastlogin_website='gjepc.org',last_login=Now() where id=".$result['id'];
	$results = $conn->query($sqlx);
	if(isset($_SESSION['login_for'])){
		if($_SESSION['login_for'] =="DGFT"){
			header('location:dgft-form.php');	 
		}elseif($_SESSION['login_for'] =="Survey_Equitable"){
			header('location:survey-for-equitable-oppurtunity-clause.php');
		}else{
			header('location:membership_rcmc.php');	 
		}
	}else{
		header('location:membership_rcmc.php');	 
	}
	
	}
	else
	{
	 $_SESSION['succ_msg']="You have Entered wrong Username or Password";
	}
	}
	} else {
	 $_SESSION['succ_msg']="Invalid Token Error";
	}
}
?>

<section class="py-5">
	
    <div class="container-fluid inner_container">
    
    	<div class="row justify-content-center grey_title_bg">      
        	<div class="bold_font text-center"> <div class="d-block"><img src="assets/images/gold_star.png"></div>Log In </div>
        </div>   
       
        <div class="container">        
        	<div class="row justify-content-center">

                    <form method="POST" name="loginform" id="loginform" onsubmit="return checkdata()" autocomplete="off" class="col-lg-5 box-shadow">
                       
                    <?php
					if(isset($signup_error)){ echo "<div class='alert alert-danger' role='alert'>".$signup_error.'</div>';} 
                    if($_SESSION['succ_msg']!=""){
                    echo "<div class='alert alert-danger' role='alert'>".$_SESSION['succ_msg']."</div>";
                    $_SESSION['succ_msg']="";
                    }
                    ?>
                        <div class="row">
                        <input type="hidden" name="action" value="login" />
                        <?php token(); ?>
                        
                        <div class="col-md-12  form-block  col-sm-12 col-xs-12 loginform">
                                    
                            <div class="form-group">
                                <input type="email" class="form-control" autocomplete="off" oninvalid="window.navigator.vibrate(200);" id="email_id" name="email_id" placeholder="Email"/>
                            </div>
                            
                            <div class="form-group minibuffer">
                                <input type="password" class="form-control" autocomplete="off" id="input" name="ur_password" placeholder="Password"/>
                                <input type="password" hidden="" name="password" id="result" />
                            </div>
                            
                            <div class="form-group minibuffer">
                                <input type="text" class="form-control" autocomplete="off" id="captcha_code" name="captcha_code" placeholder="Captcha"/>
                            </div>
                            
                            <div class="form-group captcha_txt p-1" style="border:1px solid #ccc;">
                            	<div class="d-flex justify-content-center align-items-center">
                                    <div class="col-auto"><img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg'/></div>
                                    <div class="col-auto"><a href='javascript: refreshCaptcha();'> <i class="fa fa-refresh" aria-hidden="true"></i></a></div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" name="Submit" class="cta w-100 fade_anim" value="Submit">Submit</button>                                
                            </div>
                                
                     
                        
                        <div class="form-group mb-0">
                        	<div class="d-flex ab_none justify-content-between">
                                    <div><a href="forgotpassword.php"  class="ab_none d-block">Forgot Password?</a></div>
                                    <div ><a href="registration.php" class="ab_none d-block"> Register Now </a></div>
                            </div>                    	
						</div>
                        </div>
                    </form>
            </div>            
        </div>	
    </div>
</section>

<?php include 'include-new/footer.php'; ?>
<script src="assets/js/jquery.validate.js" type="text/javascript"></script>
<script src="js/demo.js"></script>
<script src="js/md5.js"></script>
<script language='JavaScript' type='text/javascript'>
function refreshCaptcha()
{
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>

<script type="text/javascript">
jQuery().ready(function() {
	$("#loginform").validate({
		rules: {  
			email_id: {
				required: true,
				email:true
			},  
			ur_password:{
				required: true,
			},
			captcha_code:{
				required: true,
			},
		},
		messages: {
			email_id: {
				required: "Please Enter a valid email id",
			},
			ur_password: {
				required: "Please Enter your password",
			},
			captcha_code:{
				required: "Please Enter captcha code",
			}
	 }
	});
});
</script>
<script type="text/javascript">
function checkdata()
{
var password1=$("#ur_password").val();
var md5 = function(password1) {
    return CryptoJS.MD5(password1).toString();
}
}
</script>