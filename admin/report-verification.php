<?php 
session_start();
include('../db.inc.php');
include('../functions.php');

if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php'); exit; } 
$adminID = intval($_SESSION['curruser_login_id']);
$get_Mobile_no = intval($_SESSION['mobile_no']);
if($get_Mobile_no==''){
echo "<script langauge=\"javascript\">alert(\"Update Mobile No\");location.href='report-verification.php';</script>"; exit;
}
?>

<?php
$success = "";
$signup_error = "";
if($_REQUEST['action']=='save')
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token'])
	{
		//print_r($_POST); exit;
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

		$sqlx = "SELECT mobile_no FROM `admin_master` WHERE mobile_no='$getMobile_no' AND status='1' limit 1";
		$result = $conn ->query($sqlx);
		$count = $result->num_rows;
		if($count>0){
			
			$otp = rand(1000,9999); // generate OTP	
			$message = "One Time Password for Reports is ".$otp." , Regards GJEPC";
			$otp_sendStatus = send_sms($message,$getMobile_no); // Send OTP
			if($otp_sendStatus){
				$getMobile = "SELECT mobile_no FROM report_otp_verification WHERE mobile_no='$getMobile_no'";
				$getMobileResult = $conn->query($getMobile);
				$countMobile = $getMobileResult->num_rows;
				if($countMobile>0){
				$UpdateMobileOtp = "UPDATE report_otp_verification SET otp='$otp',verified ='0' WHERE mobile_no='$getMobile_no'";
				$result = $conn ->query($UpdateMobileOtp);   
				} else {
				$ins = "INSERT INTO `report_otp_verification`(`post_date`,`mobile_no`, `otp`, `verified`) VALUES (NOW(),'$getMobile_no','$otp','0')"; 
				$result = $conn ->query($ins);
				}
				$_SESSION['getMobile_no']= $getMobile_no;
				$success=1;
			} else {
			$signup_error = "OTP Not sent!";
			}
			
		} else {
			$signup_error = "You have not updated Mobile No !";
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
	$sqlx = "SELECT * FROM `report_otp_verification` WHERE mobile_no='$getMobile_no' AND otp='$otp' AND verified='0' limit 1";
	$result = $conn ->query($sqlx);	
	$num = $result->num_rows;
	
	$rowsData = $result->fetch_assoc();	
	$mob_no = $rowsData['mobile_no'];
	
	if($num>0) {
		$updatex = "UPDATE `report_otp_verification` SET `verified`='1' WHERE otp='$otp' AND mobile_no='$getMobile_no' limit 1";
		$resultx = $conn ->query($updatex);
		if($resultx){
	//	unset($_SESSION['mobile_no']);
		$_SESSION['mob_no'] = $mob_no;
		$timestamp =  $_SERVER["REQUEST_TIME"];  // generate the timestamp when otp is forwarded to user email/mobile.
        $_SESSION['time'] = $timestamp;          // save the timestamp in session varibale for further use.
		$signup_success = "Thanks for the Verification..!! Your applicaiton has been submitted successfully"; 
		header("Location: https://gjepc.org/admin/all-reports.php"); exit;
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
<script type="text/javascript" src="fg.menu.js"></script>
<style>
.error {color:red;}
</style>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>
<div id="nav_wrapper"><div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear">

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Reports</div>
</div>

<div id="main">
	<?php if(isset($signup_error) && !empty($signup_error)){ echo '<div class="error">'.$signup_error.'</div>';} ?>
	<?php if(isset($signup_success)){ echo '<div class="alert alert-success" role="alert">'.$signup_success.'</div>';} ?>
					
	<div class="content_details1 ">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="mobForm" id="mobForm">
<?php token(); ?>

<?php if(!empty($success==1)){ ?>
									
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr class="orange1"><td colspan="2"> &nbsp; Enter OTP</td></tr>				   
					<tr>
					<td class="content_txt">OTP</td>
					<td><input type="text" class="input_txt numeric" placeholder="One Time Password" id="otp" name="otp" maxlength="4" autocomplete="off"/></td>
					</tr>

					<tr>
					<td>&nbsp;</td>
					<td>
					<input type="submit" name="submit_otp" value="Submit" class="input_submit"/>
					</td>
					</tr>
	</table>
<?php } else { ?>
					
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Enter Mobile No</td>
    </tr>
   
    <tr>
    <td class="content_txt">Mobile No.</td>
    <td><?php echo str_repeat('*', strlen($get_Mobile_no) - 4) . substr($get_Mobile_no, -4);?>
	
	<input type="hidden" name="mobile_no" id="mobile_no" autocomplete="off" maxlength="10" placeholder="Enter Mobile No" class="input_txt numeric" readonly value="<?php echo $get_Mobile_no;?>"/></td>
    </tr>

    <tr>
    <td>&nbsp;</td>
    <td>
	<input type="submit" value="SEND OTP" class="input_submit"/>
    <input type="hidden" name="action" id="action" value="save" />
	</td>
    </tr>
</table>
<?php } ?>
</form>
</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>
<script src="../jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<script type="text/javascript">
$().ready(function() {
	$("#mobForm").validate({
		rules: {  
			mobile_no: {
				required: true,
				number:true,
				minlength: 10,
				maxlength:10
			},
			otp: {
				required: true,
				number:true
			}
		},
		messages: {
			mobile_no: {
				required:"Please Enter Mobile Number",
				number:"Please Enter Numbers only",
				minlength:"Please enter at least {10} digit.",
				maxlength:"Please enter no more than {0} digit."
			},
			otp: {
				required:"Please Enter OTP",
				number:"Please Enter Valid OTP only"
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