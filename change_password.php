<?php 
include 'include-new/header.php'; 
if(!isset($_SESSION['USERID'])){ header('location:login.php'); exit; }
include 'db.inc.php';
include 'functions.php';
?>
<?php
$action=$_REQUEST['action'];
if($action=="changepassword")
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	$id = $_SESSION['USERID'];
	$password		=	filter($_REQUEST['newpassword']);
	$cnfrmpassword	= 	filter($_REQUEST['cnfrmpassword']);
	if(empty($password))
	{ $signup_error="Please Enter New Password"; }
	else if(strlen($password) < 8)
	{ $signup_error="Password must be at least 8 characters"; }
	else if(empty($cnfrmpassword))
	{ $signup_error="Please Enter Confirm Password"; }
	else if( $password!= $cnfrmpassword )
	{ $signup_error="Oops! Password did not match! Try again."; }
	else {
	$pass = md5($password);
    $sqly = "update registration_master set old_pass=?,company_secret=? where id=?";
	$query = $conn -> prepare($sqly);
	$query -> bind_param("ssi", $password,$pass,$id);
	if($query->execute()) {
	$_SESSION['succ_msg']="Your password has been changed";
	$password='';
	$cnfrmpassword='';
	}
	}
	} else {
	  $_SESSION['error_msg']="Invalid Token Error";
	}
}
?>

<section class="py-5">
	<div class="container inner_container">
    
        <h1 class="bold_font text-center mb-5"> <img src="assets/images/gold_star.png" class="title_star d-block mx-auto">My Account - Change Password</h1>

		<div class="row">
        	
            
            <div class="col-lg-auto order-lg-12 col-md-12 " data-sticky_parent>
				<?php include 'include/regMenu.php'; ?>
			</div>
	
            <div class="col-lg col-md-12">
            
				<?php 
                if($_SESSION['succ_msg']!=""){
                echo "<div class='alert alert-success' role='alert'>".$_SESSION['succ_msg']."</div>";
                $_SESSION['succ_msg']="";
                }
            
                if($_SESSION['error_msg']!=""){
                echo "<span style='color: red;'>".$_SESSION['error_msg']."</span>";
                $_SESSION['error_msg']="";
                }
				
				if(isset($signup_error)!=""){
				echo "<span style='color: red;'><strong>".$signup_error."</strong></span>";
				$signup_error="";
				}
                ?>
                
                <form method="POST" name="change_password" id="change_password" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" class="row">
                	<input type="hidden" name="action" value="changepassword"/>
                	<?php token(); ?>                        				
                    <div class="form-group col-sm-6">
                       	<input type="password" class="form-control" id="newpassword" name="newpassword" autocomplete="off" placeholder="New Password" maxlength="20">
                    </div>
                    <div class="form-group col-sm-6">
                       	<input type="password" class="form-control" id="cnfrmpassword" name="cnfrmpassword" autocomplete="off" placeholder="Confirm Password" maxlength="20">
                    </div>
                    <div class="form-group col-12"><button type="submit" class="cta fade_anim">Submit</button></div>			
                </form>
        </div>            
        </div>        
    </div>    
</section>
	
<?php include 'include-new/footer.php'; ?>

<script src="assets/js/jquery.validate.js" type="text/javascript"></script> 
<script type="text/javascript">
$().ready(function() {
	jQuery.validator.addMethod("specialChrs", function (value, element) {
	if (/[^a-zA-Z 0-9\-]+$/i.test(value)) {
        return false;
    } else {
        return true;
	};
	},	"Special Characters Not Allowed");
	
	$("#change_password").validate({
		rules: {  
			newpassword: {
				required: true,
				minlength: 6,
				specialChrs: true
			},  
			cnfrmpassword:{
			 required: true,
			 equalTo: "#newpassword"
			}
		},
		messages: {
			newpassword: {
				required: "Please Enter your New Password",
				minlength: "Password should not less than 6 characters"
			},
			cnfrmpassword: {
				required: "Please Enter your Confirm Password",
				equalTo: "Please Enter the same Password as above"
			} 
	 }
	});
});
</script>