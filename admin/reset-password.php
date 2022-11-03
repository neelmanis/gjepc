<?php
session_start();
include('../db.inc.php');

if(isset($_GET["token"]) && isset($_GET["email_id"]) && isset($_GET["action"]) && ($_GET["action"]=="reset") && !isset($_POST["action"]))
{
	$token = filter($_GET["token"]);
    $email_id = filter($_GET["email_id"]);
	
    $sqly = "select * from admin_master where `token`='".$token."' and `email_id`='".$email_id."' and `status`=1";
	$query = $conn -> prepare($sqly);
	$query->execute();			
	$result = $query->get_result();
	$count  = $result->num_rows;
	if($count>0)
	{
		
		
	} else {
		 $linkError="<h2>Invalid Link</h2>
<p>The link is invalid/expired. Either you did not copy the correct link
from the email, or you have already used the key in which case it is 
deactivated.</p><p><a href='https://gjepc.org/admin/reset-link.php'>Click here</a> to reset password.</p>";
	}
} /*else { header("Location: https://gjepc.org/admin/reset-link.php"); } */
?>

<?php
if(isset($_POST["email_id"]) && isset($_POST["action"]) && ($_POST["action"]=="update"))
{
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
	$password = md5($password);
    $sqly = "update admin_master set secret_key='".$password."' where `email_id`='".$email_id."' AND `status`=1";
	$query = $conn -> prepare($sqly);
	if($query->execute()) {
	$_SESSION['succ_msg']="Your password has been changed";
	$password='';
	$cnfrmpassword='';
	} else { die ($conn->error); }
	}
	} else {
	 $_SESSION['error_msg']="Invalid Token Error";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to GJEPC</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>   
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>
<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>

</head>

<body>
<div id="header_wrapper">
<div class="header">
    <div class="logo"><img src="images/logo.png" /></div>
    <div class="punch_line">Gem and Jewellery Export Promotion Council (GJEPC)</div>
    
</div>
</div>

<div class="clear"></div>
<div id="main">
	<div class="content">
 
<div class="content_details1">
				<?php 
                if($_SESSION['succ_msg']!=""){
                echo "<span style='color: green;'>".$_SESSION['succ_msg']."</span>";
                $_SESSION['succ_msg']="";
                }
            
                if(isset($linkError)!=""){
				echo "<span style='color: red;'><strong>".$linkError."</strong></span>";
				$linkError="";
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
<form method="POST" name="reset_password" id="reset_password" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" autocomplete="off" class="row">
<?php token(); ?>    
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  	<tr class="orange1">
    <td colspan="2">&nbsp; Change Password</td>
    </tr>
    
    <tr>
    <td class="content_txt">New Password <span class="star">*</span></td>
    <td><input type="text" class="form-control" id="newpassword" name="newpassword" autocomplete="off" placeholder="New Password" autocomplete="off" maxlength="20"></td>
    </tr>  
	<tr>
    <td class="content_txt">Confirm Password <span class="star">*</span></td>
    <td><input type="text" class="form-control" id="cnfrmpassword" name="cnfrmpassword" autocomplete="off" placeholder="Confirm Password" autocomplete="off" maxlength="20"></td>
    </tr>
   
    <tr>
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
	<input type="hidden" name="email_id" value="<?php echo $email_id;?>"/>
    <input type="hidden" name="action" value="update" />
	</td>
    </tr>
</table>
</form>

</div>            
    </div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>