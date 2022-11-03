<?php 
session_start(); 
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php'); exit; }
$adminID = intval($_SESSION['curruser_login_id']);
include('../db.inc.php');
include('../functions.php');
?>

<?php
if($_REQUEST['Reset']=="Reset")
{
	$_SESSION['iec_no'] =""; 		  	  		  	  
	header("Location: iec-search.php");
} else {
		$search_type = $_REQUEST['search_type'];		
		if(isset($search_type)=="SEARCH")
		{
		$iec_no = $_POST['iec_no'];
		
		$_SESSION['iec_no'] = $iec_no;

		if($iec_no=="")
		{  $signup_error = "Please Enter PAN/IEC."; 
		} else {		
		if(isset($iec_no) && $iec_no!='')
		{
			$sql ="SELECT * FROM gjepclivedatabase.information_master where iec_no='$iec_no';";
			$resultx = $conn ->query($sql);
			$rCount = $resultx->num_rows;
			$getValue="";
			if($rCount>0) { $getValue=1; } if($rCount==0) { $getValue='NO'; }
		}
		}
		}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Visitor ||GJEPC||</title>
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
<div class="breadcome_wrap"><div class="breadcome"><a href="admin.php">Home</a> > Search IEC</div></div>

<div id="main">
	<div class="content">
    	<div class="content_head">Search IEC &nbsp;&nbsp;
        <?php if($_REQUEST['action']=='view_details'){?>
        <div style="float:right; padding-right:10px; font-size:12px;"></div>
        <?php } ?>
        </div>
<div class="content_details1">
<?php 
if($_SESSION['error_msg']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
$_SESSION['error_msg']="";
}
?>
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
?>

<form name="search" action="" method="POST"> 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11">Search Options</td>
</tr>
<tr>
  <td><strong>Search BY IEC</strong></td>
  <td><input type="text" name="iec_no" id="iec_no" class="input_txt" value="<?php echo $_SESSION['iec_no'];?>" maxlength="10" autocomplete="off"/></td>
</tr> 

<td>
<input type="submit" name="Submit" value="Search" class="input_submit"/> 
<input type="submit" name="Reset" value="Reset"  class="input_submit" />
</td>
</tr>	
</table>
</form>      
</div>

<?php if(isset($signup_error)){ echo '<div class="alert alert-danger" role="alert">'.$signup_error.'</div>'; } ?>

<?php
if(!empty($getValue==1)) {
if(isset($rCount) && $rCount>0)
{ ?>  	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td width="5%">Registration ID</td>
        <td width="30%"><a href="#">Company</a></td>
		<td>IEC No.</td>	
    </tr>
    
    <?php 	
	$i=1;
	while($row = $resultx->fetch_assoc())							
	{
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
       <td><?php echo $row['registration_id'];?></td>
       <td><?php echo $row['company_name'];?></td>
		<td><?php echo $row['iec_no'];?></td> 	
 	</tr>

	<?php
	$i++;
	   }
	?>
</table>
</div>

<?php } } if(isset($rCount) && $rCount==0){ ?>  No Data Found <?php } ?>
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>
