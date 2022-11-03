<?php
session_start();
include('db.inc.php');
//if(!isset($_GET["token"]) && !isset($_GET["email_id"]) && !isset($_GET["action"])) { header('location:https://gjepc.org/forgotpassword.php'); }

if(isset($_GET["token"]) && isset($_GET["email_id"]) && isset($_GET["action"]) && ($_GET["action"]=="reset") && !isset($_POST["action"]))
{
	$token = filter($_GET["token"]);
    $email_id = filter($_GET["email_id"]);
	
    $sqly = "select * from registration_master where `token`='".$token."' and `email_id`='".$email_id."' and `status`='1' limit 1";
	$query = $conn -> prepare($sqly);
	$query->execute();			
	$result = $query->get_result();
	$count  = $result->num_rows;
	if($count=="")
	{
		$linkError="<h2>Invalid Link</h2>
	<p>The link is invalid/expired. Either you did not copy the correct link
	from the email, or you have already used the key in which case it is 
	deactivated.</p><p><a href='https://gjepc.org/forgotpassword.php'>Click here</a> to reset password.</p>";
	}
} /*else { header("Location: https://gjepc.org/forgotpassword.php"); } */
?>

<?php
if(isset($_POST["email_id"]) && isset($_POST["action"]) && ($_POST["action"]=="update"))
{ //print_r($_POST); exit;
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
		
	$password		=	filter($_REQUEST['newpassword']);
	$cnfrmpassword	= 	filter($_REQUEST['cnfrmpassword']);
	$email_id = $_POST["email_id"];
	
	if(empty($email_id))
	{ $signup_error="Something went wrong. The link is expired."; }
	else if(empty($password))
	{ $signup_error="Please Enter New Password"; }
	else if(strlen($password) < 8)
	{ $signup_error="Password must be at least 8 characters"; }
	else if(empty($cnfrmpassword))
	{ $signup_error="Please Enter Confirm Password"; }
	else if( $password!= $cnfrmpassword )
	{ $signup_error="Oops! Password did not match! Try again."; }
	else {
	$pass = md5($password);
	if(!empty($email_id)){
    $sqly = "update registration_master set old_pass='".$password."',company_secret='".$pass."' where `email_id`='".$email_id."' AND `status`='1' limit 1";
	$query = $conn -> prepare($sqly);
	if($query->execute()) {
	$_SESSION['succ_msg']="Your password has been changed";
	$password='';
	$cnfrmpassword='';
	header('Refresh: 3; URL=https://gjepc.org/forgotpassword.php');
	} else { die ($conn->error); }
	}}
	} else {
	 $_SESSION['error_msg']="Invalid Token Error";
	}
}
?>

<?php include 'include-new/header.php'; ?>
<section class="py-5">
	
    <div class="container-fluid inner_container">
    
    	<div class="row justify-content-center grey_title_bg">      
        	
            	<div class="innerpg_title_center d-flex mb-3">
                	<img src="assets/images/gold_star.png" class="icon-title mr-4" /><h1 class="title d-inline-block form_title align-items-center"> Reset Password </h1><img src="assets/images/gold_star.png" class="icon-title ml-4" />
                </div>          
        </div>   
       
        <div class="container p-0">        
        	<div class="row justify-content-center">
					<?php 
                            
                if(isset($linkError)!=""){
				echo "<span style='color: red;'><strong>".$linkError."</strong></span>";
				$linkError="";
				}
				if($_SESSION['error_msg']!=""){
                echo "<span style='color: red;'>".$_SESSION['error_msg']."</span>";
                $_SESSION['error_msg']="";
                }
				
                ?>
                    <form method="POST" name="reset_password" id="reset_password" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" autocomplete="off" class="col-lg-5 box-shadow">
                       
                    <?php
					if(isset($signup_error)){ echo "<div class='alert alert-danger' role='alert'>".$signup_error.'</div>';} 
					
                    if($_SESSION['succ_msg']!=""){
                    echo "<div class='alert alert-success' role='alert'>".$_SESSION['succ_msg']."</div>";
                    $_SESSION['succ_msg']="";
                    }
                    ?>
                        <div class="row">
                        <input type="hidden" name="email_id" value="<?php echo $email_id;?>"/>
						<input type="hidden" name="action" value="update" />	
                        <?php token(); ?>
                        
                        <div class="col-md-12  form-block  col-sm-12 col-xs-12 loginform">
                                                         
                            <div class="form-group minibuffer">
                                <input type="text" class="form-control" id="newpassword" name="newpassword" autocomplete="off" placeholder="New Password" autocomplete="off" maxlength="20">
                            </div>
                            
                            <div class="form-group minibuffer">
                                <input type="text" class="form-control" id="cnfrmpassword" name="cnfrmpassword" autocomplete="off" placeholder="Confirm Password" autocomplete="off" maxlength="20">
                            </div>
                                                        
                            <div class="form-group">
                                <button type="submit" name="Submit" class="cta w-100 fade_anim" value="Submit">Submit</button>   
                            </div>
                                
                        </div>
                        
                        <div class="col-12  form_links">
                    	<p class="text-center"><a href="forgotpassword.php">Forgot Password ?</a></p>
                    	<p class="text-center"><strong> New User ? </strong> <a href="registraiton-landing.php"> Register Now </a></p>
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

<script type="text/javascript">
jQuery().ready(function() {
	$("#reset_password").validate({
		rules: { 
			newpassword: {
				required: true,
			}, 
			cnfrmpassword: {
				required: true,
				equalTo: "#newpassword"
			},
		},
		messages: {
			newpassword: {
				required: "Please Enter New Password",
			},
			cnfrmpassword: {
				required: "Please Enter Confrim Password",
				equalTo: "Oops! Password did not match! Try again."
			}
	 }
	});
});
</script>