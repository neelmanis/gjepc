<?php 
session_start(); 
include('../db.inc.php'); 
$msg='';
$today = date('Y-m-d');

$action=$_REQUEST['action'];
if($action=="login")
{	
//validate Token
if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
$username = filter($_POST['txtUsername']); 
$password = filter($_POST['txtPassword']); 
$username = str_replace(" ","",$username);
$password= md5(str_replace(" ","",$password));
if(empty($username))
{	$msg="Please Enter Username";	}
elseif(empty($password))
{	$msg="Please Enter Password";	}
elseif(empty($_SESSION['captcha_code'] ) ||  strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0)
{
	$msg= "The captcha code does not match!";
} else {
		$sql = "SELECT * from admin_master where email_id= ? AND secret_key=? AND status='1'";
		$query = $conn -> prepare($sql);
		$query -> bind_param("ss", $username, $password);
		$query->execute();			
		$result = $query->get_result();
		$db_data = $result->fetch_assoc();
		$count=$result->num_rows;
		$contact_name = filter($db_data['contact_name']);
		$email_id = filter($db_data['email_id']);
		$admin_id = filter($db_data['id']);
		$role = filter($db_data['role']);
		$admin_access = $db_data['admin_access'];
		$region_id = $db_data['region_id'];
		$region_access = $db_data['region_access'];
		$mobile_no = $db_data['mobile_no'];
		$reports_access = $db_data['reports_access'];
		$reports_category = $db_data['reports_category'];
		
		if($count > 0)
		{
			$_SESSION['curruser_contact_name']=$contact_name;
			$_SESSION['curruser_email_id']=$email_id;
			$_SESSION['curruser_login_id']=$admin_id;
			$_SESSION['curruser_region_id']=$region_id;
			$_SESSION['curruser_role']=$role;
			$_SESSION['curruser_admin_access']=$admin_access;
			$_SESSION['curruser_region_access']=$region_access;
			$_SESSION['mobile_no']=$mobile_no;
			$_SESSION['reports_access']=$reports_access;
			$_SESSION['reports_category']=$reports_category;
			
			$ip = $_SERVER['REMOTE_ADDR'];
			$upx = "update admin_master set last_login=Now(),ip='$ip' where id=".$admin_id;
			$upxx = $conn->query($upx);
			echo"<meta http-equiv=refresh content=\"0;url=admin.php\">";
		} else { 
			$msg='Invalid login details';
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
<title>Welcome To Admin Control Panel || GJEPC ||</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />
<script language="javascript">
function checkform()
{
	if(document.idpform.txtUsername.value=='')
	{
		alert("Please enter username")
		document.idpform.txtUsername.focus();
		return false;
	}
	if(document.idpform.txtPassword.value=='')
	{
		alert("Please enter password")
		document.idpform.txtPassword.focus();
		return false;
	}
	if(document.idpform.captcha_code.value=='')
	{
		alert("Please enter Security Code")
		document.idpform.captcha_code.focus();
		return false;
	}
}

</script>
<script language='JavaScript' type='text/javascript'>
function refreshCaptcha()
{
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>
</head>

<body>

<div id="header_wrapper">
	<div class="header">
     	<div class="logo"><img src="images/logo.png" /></div>
        <div class="punch_line">&nbsp; &nbsp; &nbsp; &nbsp; The Gem and Jewellery Export Promotion Council (GJEPC)</div>
	</div>	
</div>
<div id="nav_wrapper">
	
</div>

<div id="container">
		<div class="login_cont">
       	  <div class="head"><img src="images/lock.png" style="vertical-align:middle" /> Login</div>
            
			<form id="idpform" name="idpform" method="POST" onSubmit="return checkform()" autocomplete="off">
			<input type="hidden" name="action" value="login" />
			<?php token(); ?>
			
            <table width="540" class="login">
                <tr>
                    <td height="21">&nbsp;</td>
                    <td colspan="2" class="error_msg"> <?php if($msg!=''){ echo $msg; }  ?></td>
                </tr>            
                <tr>
                    <td>&nbsp;</td>
                    <td width="174" class="txt3">Username</td>
                    <td width="333"><input type="text" name="txtUsername" id="txtUsername" autocomplete="off" value="<?php echo $username;?>" class="input_txt1" /></td>
                </tr>            
                <tr>
                    <td>&nbsp;</td>
                    <td class="txt3">Password</td>
                    <td><input type="password" name="txtPassword" id="txtPassword" autocomplete="off" class="input_txt1"/></td>
                </tr>
            
                <tr valign="top">
                    <td>&nbsp;</td>
                    <td class="txt3" valign="middle">Security Code&nbsp;&nbsp;:</td>
                    <td class="txt3" style="font-weight:normal">
                    <p>
                    <img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg' ><br>
                    <input id="captcha_code" name="captcha_code" type="text" autocomplete="off" class="input_txt1"><br>
                    <small>Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh</small> 
					<br/><a href="reset-link.php"> <b>Reset Password</b></a>
					</p>				</td>
                </tr>
            
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><input type="submit" value="Submit" class="input_submit" /></td>
                </tr>
            
            </table>
            </form>
          </div>
</div>
<div id="footer_wrap">Developed by <a href="http://kwebmaker.com/" target="_blank">K Webmaker™</a></div>
</body>
</html>