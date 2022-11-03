<?php
session_start();
include('../db.inc.php'); 
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php'); exit; } 
$adminID = intval($_SESSION['curruser_login_id']);
?>

<?php
if($_REQUEST['action']=='save')
{
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
	$password = md5($password);
    $sqly = "update kp_admin_master set password=?,secret_key=? where id=?";
	$query = $conn -> prepare($sqly);
	$query -> bind_param("ssi", $cnfrmpassword,$password,$adminID);
	if($query->execute()) {
	$_SESSION['succ_msg']="Your password has been changed";
	$password='';
	$cnfrmpassword='';
	} else { die ($conn->error);}
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
<div id="header_wrapper"><?php include("include/header.php");?></div>
<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear">

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Change Password</div>
</div>

<div id="main">
	<div class="content">
   	
<div class="content_details1">
				<?php 
                if($_SESSION['succ_msg']!=""){
                echo "<span style='color: green;'>".$_SESSION['succ_msg']."</span>";
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
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Change Password</td>
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
    <input type="submit" value="Change Password" class="input_submit"/>
	<input type="hidden" name="action" id="action" value="save" />
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