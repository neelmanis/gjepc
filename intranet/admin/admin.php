<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
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

<!--navigation end-->
<style type="text/css">
<!--
.style1 {
	font-size: 36px;
	color: #FF9900;
}
-->
</style>


<script type="text/javascript" src="fg.menu.js"></script>
    


</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>


<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear">

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Admin</div>
</div>

<div id="main">
	<div class="content style1" style="height:550px">
	  <div align="center"><strong> Welcome to GJEPC Intranet Admin   </strong></div>
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
