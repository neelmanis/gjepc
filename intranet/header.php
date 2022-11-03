
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<div id="header" class="fixed">

<div class="logo"> 
   <a href="index.php"><img src="images/logo.png" id="logo" /></a>
</div>


<div class="leftNav">
<nav id="navigation-menu" class="clearfix fixed">

<!--<img src="images/sponsers.png" width="152" height="52" alt=""> -->
<a href="#" id="pull">Menu</a>
		<ul>
		  <li class="menuList"><a href="index.php#section-1">Home</a></li>
		  <li class="menuList"><a href="index.php#section-2">theme</a></li>
		  <li class="menuList"><a href="index.php#section-3">participation</a></li>
		  <li class="menuList"><a href="index.php#section-4">jury</a></li>
		  <li class="menuList"><a href="index.php#section-5">awards</a></li>
          <li class="menuList"><a href="index.php#section-6">FAQ's</a></li>
		  <li class="menuList"><a href="index.php#section-7">Contact</a></li>
		</ul>
</nav>

</div>



<div id="sideLogos"><img src="images/sponcers.jpg" alt=""></div>

<div class="clear"></div>



<?php
if(isset($_SESSION['email']) && $_SESSION['email']!="")
{
?>
<div class="logout">
<div class="personName"><a href="dashboard.php">Welcome <?php if($_SESSION['participation_type']=="I") { echo $_SESSION['first_name']." ".$_SESSION['last_name']; }else{ echo $_SESSION['company_name']; }?></a></div>
<div class="loginBtn">
<a href="logout.php">Logout</a></div>
</div>
<?php }else{?>

<div class="logout">
<div class="loginBtn">
<a href="form.php" class="various2">Sign In / Register</a></div>
</div>



<?php } ?>


<div class="clear"></div>

    
</div>

</body>
</html>