<?php
session_start();
ob_start();
include('db.inc.php');
include('functions.php');
$change_pass_status = $_SESSION['change_pass_status'];
 // if($_SESSION['password']!='123456')
 // {
	 // header('location:index.php');
 // }
 // else
 // {
	// header('location:change_password.php');
 // }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GJEPC :: Intranet</title>
<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
<script type="text/javascript" src="js/jquery.min.js"></script>

</head>
<?php
if(isset($_POST['action']) && $_POST['action']=='change_password')
{
	//$o_pass = $_POST['o_pass'];
	$n_pass_flag = checkPassword($_POST['n_pass']);
	$_SESSION['msg'] = $n_pass_flag;
	$username=$_SESSION['username'];
	$uid=$_SESSION['user_id'];
	
		if($_SESSION['msg']=='')
		{
			$n_pass = $_POST['n_pass'];
			 $query = "update employee_details set password='$n_pass',change_pass_status='1' where employee_name='$username' and id=$uid";
			
			$result = mysql_query($query);
			if($result)
			{
			header('location:index.php');
			exit ;
			}
		}
		
}

?>
<script>
	function validate()
	{
	//alert("hello");	
	// var o_pass = document.getElementById('o_pass').value;
		// if(o_pass=='')
		// {
			// alert("Please Enter Old Password");
			// document.getElementById('o_pass').focus();
			// return false;
		// }
		
	var n_pass = document.getElementById('n_pass').value;
		if(n_pass=='')
		{
			alert("Please Enter New Password");
			document.getElementById('n_pass').focus();
			return false;
		}
		// else if(n_pass==o_pass)
		// {
			// alert("Password must be Diffrent From Old Password");
			// document.getElementById('n_pass').focus();
			// return false;
		// }
		
		var c_pass = document.getElementById('c_pass').value;
		if(c_pass=='')
		{
			alert("Please Enter Confirm Password");
			document.getElementById('c_pass').focus();
			return false;
		}
		else if(n_pass!=c_pass)
		{
			alert("Confirm Password Does Not Match");
			document.getElementById('c_pass').focus();
			return false;
		}
	}

</script>

<body>
<form name="c_password" id="c_password" action="" method="post" onsubmit="return validate()">
<div class="login_box">
	<div class="login_content">
    	<div class="login_logo"><img src="images/logo.png" title="GJEPC" /></div>
        <?php
            if($_SESSION['msg']!='')
			{
		?>
			<span style='margin-left:80px; color:#F00'><?php echo $_SESSION['msg'];?></span>
			<?php 
			$_SESSION['msg']='';
			}
			
			?>
            
        	
            
            
        
        <!--<div class="login_textfield">
        	<span>Old Password :</span>
            <input type="password" class="field" name="o_pass" id="o_pass" />
        </div>-->
        
         <div class="login_textfield">
        	<span>New Password :</span>
            <input type="password" class="field" name="n_pass" id="n_pass" />
            
        </div>
        
         <div class="login_textfield">
        	<span>Confirm Password :</span>
            <input type="password" class="field" name="c_pass" id="c_pass" />
            
        </div>
        
         <div class="login_textfield">
        	<input type="submit" value="Change Password" class="submit" />
            <input type="hidden" id="action" name="action" value="change_password" class="field" />
        </div>
        
    </div>
</div>
</form>
</body>
</html>
