<?php
session_start();
ob_start();
include('db.inc.php');
include('functions.php');

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
if(isset($_POST['action']) && $_POST['action']=='save')
{
	$username = filter_input_string($_POST['username']);
	$password = $_POST['password'];
 	 $query = "select * from employee_details where employee_name='$username' and password='$password'";
	
	$result = mysql_query($query);
	$count = mysql_num_rows($result);
	$row = mysql_fetch_array($result);
	if($count>0)
	{
		$_SESSION['username'] = $row['employee_name'];
		$_SESSION['user_id'] = $row['id'];
		$_SESSION['password']=$row['password'];
		$_SESSION['department'] = $row['department'];
		/*if($row['password']=='123456')
		{
			header('location:change_password.php');
		}else
		{
			header('location:index.php');
		}*/
		header('location:index.php');
		
	}
	else
	{
	$_SESSION['msg']='Invalid Username & Password';	
	}
}

?>
<script>
	function validate()
	{
	//alert("hello");	
	var username = document.getElementById('username').value;
		if(username=='')
		{
			alert("Please Enter Username");
			document.getElementById('username').focus();
			return false;
		}
		
	var password = document.getElementById('password').value;
		if(password=='')
		{
			alert("Please Enter Password");
			document.getElementById('password').focus();
			return false;
		}
	}

</script>

<body>
<form name="login" id="login" action="" method="post" onsubmit="return validate()">
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
        <div class="login_textfield">
        	<span>Username :</span>
            <input type="text" class="field" name="username" id="username" />
        </div>
        
         <div class="login_textfield">
        	<span>Password :</span>
            <input type="password" class="field" name="password" id="password" />
            
        </div>
        
         <div class="login_textfield">
        	<input type="submit" value="Login" class="submit" />
            <input type="hidden" id="action" name="action" value="save" class="field" />
        </div>
        
    </div>
</div>
</form>
</body>
</html>
