<?php 
session_start();
include('../db.inc.php');
include('../functions.php');

if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php'); exit; }

if($_SESSION['curruser_login_id']!=1){
if(isset($_SESSION['mob_no'])){  $getMobile_no = $_SESSION['mob_no']; } else { header('location:report-verification.php'); }
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
<!--<script type="text/javascript" src="fg.menu.js"></script>-->
<?php 
if($_SESSION['curruser_login_id']!=1){
?>
<script>							
	$(document).ready(function(){
	  setTimeout(function() {
		  alert('Timeout!! Kindly verify Again');
		<?php
		$timestamp =  $_SERVER["REQUEST_TIME"];     // record the current time stamp 
		if(($timestamp - $_SESSION['time']) > 3000)  // 100 refers to 100 seconds
		{
			unset($_SESSION['mob_no']);
			unset($_SESSION['time']);
			unset($_SESSION['getMobile_no']);
			header('location:report-verification.php');			
		}
		?>
	  window.location.href = 'https://gjepc.org/admin/all-reports.php'
	 }, 300000);
	});
</script>
<?php } ?>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>
<div id="nav_wrapper"><div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear">

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > REPORTS</div>
</div>

<div id="main">
		<?php if($_SESSION['curruser_login_id']==1 || $_SESSION['curruser_login_id']==78){ ?>
		<a href="get_reports_log.php" class="report-button" style="font-size:20px;">Download Reports Log</a>
		<?php } ?>
		<br/><br/>
		<?php
		$categId = explode(',',$_SESSION['reports_access']);
		$reports_category = explode(',',$_SESSION['reports_category']);
		
		$result = $conn->query("SELECT distinct(category) FROM report_master where status='1'");
		while($row=$result->fetch_assoc()){
			$category = $row['category'];
		if(in_array($row['category'], $reports_category)){
        ?>
        <fieldset class="scheduler-border">
        <legend class="scheduler-border"> &nbsp; <?php echo $row['category'];?> &nbsp; </legend>
        <?php 
		$result1=$conn->query("SELECT * FROM report_master where status='1' AND category='$category'");
		$i = 0;
		while($row1=$result1->fetch_assoc()){
		if ($i % 1 == 0)
        echo '<br/> &nbsp;'; ?>
        <?php if(in_array($row1['slug'], $categId)){ ?> &nbsp; <a href="<?php echo $row1['url'];?>" class="report-button"><?php echo strtoupper($row1['title']);?></a>&nbsp; <?php } ?>
        <?php $i++; } ?>
        </fieldset>
        <?php } } ?>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>
<style>
.report-button
{	
	display: inline-block;
    padding-bottom: 20px;
    border: 1px solid #000;
    padding: 5px;
    margin-bottom: 10px;
    text-decoration: none;
	background:#0c6290cc;
	color : #fff;
	display:inline-block;
}
</style>