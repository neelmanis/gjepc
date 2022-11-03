<?php
session_start(); 
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$adminID=$_SESSION['curruser_login_id'];

if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['hscode_type']="";  
  $_SESSION['quarter_year']="";  
  header("Location: import_export_data.php");
} else
{ 
  	$search_type=$_REQUEST['search_type'];
  	if($search_type=="SEARCH")
	{ 
	  $_SESSION['hscode_type']=$_REQUEST['hscode_type'];
	  $_SESSION['quarter_year']=$_REQUEST['quarter_year'];
	}
	
	if($search_type=='SEARCH')
	{
		if($_SESSION['hscode_type']=="")
		{
		$_SESSION['error_msg']="Please select HS CODE";
		}

	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Import/Export Form ||GJEPC||</title>

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
<div class="clear"></div>
<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Import/Export</div>
</div>

<div id="main">
	<div class="content">
    	
<div class="clear"></div>
<div class="content_details1">
<div class="content_head">
<a href="import_export_commodity_data.php"><div class="content_head_button">Download Commodity Wise Application </div></a>
<a href="import_export_regionwise_data.php"><div class="content_head_button">Download Region Wise Application </div></a>
<a href="import_export_country_data.php"><div class="content_head_button">Download Country Data</div></a>
<a href="import_export_remarks.php"><div class="content_head_button">Download Remarks</div></a>
<a href="import_export_pending_members.php"><div class="content_head_button">Download Pending Members List </div></a>
<a href="import_export_pending_exports_members.php"><div class="content_head_button">Download Pending Exporters Members List </div></a>
<a href="import_export_applied_members.php"><div class="content_head_button">Download Applied Members List </div></a>
<a href="import_export_applied_exports_members.php"><div class="content_head_button">Download Applied Not Null Members List</div></a>
</div>  
</div>  
</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>