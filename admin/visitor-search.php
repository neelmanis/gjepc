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
	$_SESSION['pan_no'] =""; 		  	  
	$_SESSION['mobile'] =""; 		  	  
	$_SESSION['email'] =""; 		  	  
	header("Location: visitor-search.php");
} else {
		$search_type = $_REQUEST['search_type'];		
		if(isset($search_type)=="SEARCH")
		{
		$pan_no = $_POST['pan_no'];
		$mobile = $_POST['mobile'];
		$email = $_POST['email'];
		
		$_SESSION['pan_no'] = $pan_no;
		$_SESSION['mobile'] = $mobile;
		$_SESSION['email'] = $email;

		if($pan_no=="" && $mobile=="" && $email=="")
		{  $signup_error = "Please Enter PAN/Mobile."; 
		} else {		
		if(isset($pan_no) && $pan_no!='')
		{
			$sql ="SELECT * FROM gjepclivedatabase.visitor_directory where pan_no='$pan_no' limit 5";
			$resultx = $conn ->query($sql);
			$rCount = $resultx->num_rows;
			$getValue="";
			if($rCount>0) { $getValue=1; } if($rCount==0) { $getValue='NO'; }
		}
		if(isset($mobile) && $mobile!='')
		{
			$sql ="SELECT * FROM gjepclivedatabase.visitor_directory where mobile='$mobile' limit 5";
			$resultx = $conn ->query($sql);
			$rCount = $resultx->num_rows;
			$getValue="";
			if($rCount>0) { $getValue=1; } if($rCount==0) { $getValue='NO'; }
		}
		
		if(isset($email) && $email!='')
		{
			$sql ="SELECT * FROM gjepclivedatabase.visitor_directory where email='$email' limit 50";
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
<div class="breadcome_wrap"><div class="breadcome"><a href="admin.php">Home</a> > Manage Visitor</div></div>

<div id="main">
	<div class="content">
    	<div class="content_head">Manage Visitor &nbsp;&nbsp;
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
    <td colspan="11" >Search Options</td>
</tr>
<tr>
  <td><strong>Search BY PAN</strong></td>
  <td><input type="text" name="pan_no" id="pan_no" class="input_txt" value="<?php echo $_SESSION['pan_no'];?>" maxlength="10" autocomplete="off"/></td>
</tr>
<tr>
  <td><strong>Search BY Mobile</strong></td>
  <td><input type="text" name="mobile" id="mobile" class="input_txt" value="<?php echo $_SESSION['mobile'];?>" maxlength="10" autocomplete="off"/></td>
</tr>
<tr>
  <td><strong>Search BY Email</strong></td>
  <td><input type="text" name="email" id="email" class="input_txt" value="<?php echo $_SESSION['email'];?>" autocomplete="off"/></td>
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
        <td width="5%">Visitor ID</td>
        <td width="30%"><a href="#">Company</a></td>
		<td>Photo</td>
		<td>Name</td>
		<td>Designation Type</td>
		<td>Mobile Number</td>
		<td>Pan No.</td>	
		<td>Status</td>	
    </tr>
    
    <?php 	
	$i=1;
	while($row = $resultx->fetch_assoc())							
	{	
		$visitor_approval = $row['visitor_approval'];
	if($visitor_approval == "Y"){ $visitor_approval= "<span style='color:green'>Approved</span>";} 
	if($visitor_approval == "P"){ $visitor_approval= "<span style='color:blue'>Pending</span>";}
	if($visitor_approval == "D"){ $visitor_approval= "<span style='color:red'>Disapproved</span>";}
	if($visitor_approval == "U"){ $visitor_approval= "<span style='color:green'>Updated</span>";}
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
       <td><?php echo $row['registration_id'];?></td>
       <td><?php echo $row['visitor_id'];?></td>
	   <td><a href="https://gjepc.org/admin/iijs_employee_directory.php?action=viewReg&regid=<?php echo $row['registration_id'];?>"><?php echo getNameCompany($row['registration_id'],$conn);?></a></td>
        <td>
    <img src="https://registration.gjepc.org/images/employee_directory/<?php echo $row['registration_id']; ?>/photo/<?php echo $row['photo']; ?>" width="100px;"/></td>
		<td><?php echo strtoupper($row['name'].' '.$row['lname']);?></td>
		<td><?php echo $row['degn_type'];?></td> 
		<td><?php echo $row['mobile'];?></td> 
		<td><?php echo $row['pan_no'];?></td> 
		<td><?php echo $visitor_approval;?></td>   	
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
