<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php 
$msg='';
$today = date('Y-m-d');
if (($_REQUEST['txtUsername']!='') && ($_REQUEST['txtPassword']!=''))
{
   
		 $query = "select * from admin_master where email_id  = '$_POST[txtUsername]' and password='$_POST[txtPassword]'";
		$result = @mysql_query($query);
		 $count = @mysql_num_rows($result);
		$db_data = @mysql_fetch_array($result);
		$contact_name = $db_data['contact_name'];
		$email_id = $db_data['email_id'];
		$admin_id = $db_data['id'];
		$role = $db_data['role'];
		$admin_access = $db_data['admin_access'];
		$region_id = $db_data['region_id'];
		
		if($count > 0)
		{
			$_SESSION['curruser_contact_name']=$contact_name;
			$_SESSION['curruser_email_id']=$email_id;
			$_SESSION['curruser_login_id']=$admin_id;
			$_SESSION['curruser_region_id']=$region_id;
			$_SESSION['curruser_role']=$role;
			$_SESSION['curruser_admin_access']=$admin_access;
			echo"<meta http-equiv=refresh content=\"0;url=admin.php\">";
		}
		else 
		{ 
			$msg='Invalid login details';
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
        <div class="punch_line">Gem and Jewellery Export Promotion Council (GJEPC)</div>
	</div>	
</div>


<div id="nav_wrapper">
	
</div>

<div id="container">
		<div class="login_cont">
       	  <div class="head"><img src="images/lock.png" style="vertical-align:middle" /> Login</div>
            <form id="idpform" name="idpform" method="post" action="" onSubmit="return checkform()">
            <table width="540"   class="login">
                <tr>
                    <td height="21">&nbsp;</td>
                    <td colspan="2" class="error_msg"> <?php if($msg!=''){ echo $msg; }  ?></td>
                </tr>
            
                <tr>
                    <td>&nbsp;</td>
                    <td width="174" class="txt3">Username</td>
                    <td width="333"><input type="text" name="txtUsername" id="txtUsername" class="input_txt" /></td>
                </tr>
            
                <tr>
                    <td>&nbsp;</td>
                    <td class="txt3">Password</td>
                    <td><input type="password" name="txtPassword" id="txtPassword" class="input_txt"/></td>
                </tr>
            
                
            
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td ><input type="submit" value="Submit"  class="input_submit" /></td>
                </tr>
            
            </table>
            </form>
          </div>
	
</div>

<div id="footer_wrap">
	Developed by <a href="http://kwebmaker.com/" target="_blank">K Webmaker™</a>
</div>

</body>
</html>
