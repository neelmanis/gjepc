<?php 
session_start(); ob_start();
include('../db.inc.php');
include('../functions.php');
$curruser_region_id = $_SESSION['curruser_region_id'];
?>
<?php 
if(($_REQUEST['action']=='active') && ($_REQUEST['app_id']!=''))
{
    $registration_id = intval($_REQUEST['registration_id']);
	$status	=	filter($_REQUEST['status']);	
	$app_id	=	filter($_REQUEST['app_id']);
	$sqlu="update trade_general_info set admin_allow_for_application='$status' where registration_id='$registration_id'";
	$result = $conn ->query($sqlu);   
    if(!$result) die ($conn->error);
	header("location:manage_trade_permission.php?action=view") ;
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

<!--navigation end-->
<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	$('#popupDatepicker').datepick({dateFormat:'yyyy-mm-dd'});
	$('#inlineDatepicker').datepick({onSelect: showDate});
	$('#popupDatepicker1').datepick({dateFormat:'yyyy-mm-dd'});
	$('#inlineDatepicker1').datepick({onSelect: showDate});
});
function showDate(date) {
	alert('The date chosen is ' + date);}
</script>
 
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Trade permission</div>
</div>

<div id="main">

	<div class="content">
	<div class="content_details1">
<?php 
if($_SESSION['error_msg']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
$_SESSION['error_msg']="";
}
?>
	
<form name="search" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"> 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />        	

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11" >Search Options</td>
</tr>
<tr>
    <td><strong>company name</strong></td>
    <td><input type="text" name="company_name" id="company_name" class="input_txt"   /></td>
</tr>	
<tr>
    <td><strong>gcode</strong></td>
    <td><input type="text" name="membership_id" id="membership_id" class="input_txt"   /></td>
</tr>	
<tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Search"  class="input_submit" /> <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
</tr>	
</table>
</form> 
     
</div> 
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
      
       	<td>Company Name</td>
       	<td>Gcode</td>
        <td>IEC No</td>
        <td>View Application</td>
        <td>Admin Allow For Application</td>	
    </tr>
    <?php 
    $j=1;
	$adminRegion = $_SESSION['curruser_region_id'];
	$role = $_SESSION['curruser_role'];

    if($role=="Super Admin")
	{
	$query = "SELECT * FROM (SELECT  registration_id,admin_allow_for_application,app_id FROM trade_general_info";	
	if(isset($_REQUEST['company_name']) && $_REQUEST['company_name']!="" )
	{
		$company_name = $_REQUEST['company_name'] ;
		$query .= " where `member_name` LIKE '%".$company_name."%'";
	}
	
	if(isset($_REQUEST['membership_id']) && $_REQUEST['membership_id']!="" )
	{
		$membership_id = $_REQUEST['membership_id'] ;
		$query .= " where `membership_id` LIKE '%".$membership_id."%'";
	}
	
	}else{
	$query = "SELECT * FROM (SELECT  registration_id,admin_allow_for_application,app_id FROM trade_general_info where region_code='$adminRegion'";		
 
 	if(isset($_REQUEST['company_name']) && $_REQUEST['company_name']!="" )
	{
		$company_name = $_REQUEST['company_name'] ;
		$query .= " and (`member_name` LIKE '%".$company_name."%')";
	}
	
	if(isset($_REQUEST['membership_id']) && $_REQUEST['membership_id']!="" )
	{
		$membership_id = $_REQUEST['membership_id'] ;
		$query .= " and(`membership_id` LIKE '%".$membership_id."%')";
	}
	}
	$query .= ' ORDER BY created_date	DESC) as temp GROUP BY registration_id ORDER BY app_id DESC';
	//echo $query ;
	$sql = fetch($query);

	
for($i=0;$i<count($sql);$i++)
{
	$sql1 = fetch('select * from registration_master where id='.$sql[$i]['registration_id']);
	?>
	 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $j;?></td>
	    <td><?php echo $sql1[0]['company_name']; ?></td>
		<td><?php echo $sql1[0]['gcode']; ?></td>
        <td><?php echo getIec($sql[$i]['registration_id'],$conn);?></td>		
		<td>
        <a href="signature_application.php?registration_id=<?php echo $sql[$i]['registration_id']; ?>&&app_id=<?php echo $sql[$i]['app_id'];?>"  style="color:#000000">View</a>
      	</td>
        <td>
		<?php if($sql[$i]['admin_allow_for_application'] == 'N') {?> 
		<a style="text-decoration:none;" href="manage_trade_permission.php?app_id=<?php echo $sql[$i]['app_id']; ?>&status=Y&action=active&&registration_id=<?php echo $sql[$i]['registration_id']; ?>" onClick="return(window.confirm('Are you sure you want to Allow'));"><img src="images/inactive.png" border="0" title="Active"/></a>&nbsp;&nbsp;&nbsp;(Not Allowed)
		<?php } ?>
		<?php if($sql[$i]['admin_allow_for_application'] == 'Y'){?> 
			<a style="text-decoration:none;" href="manage_trade_permission.php?app_id=<?php echo $sql[$i]['app_id']; ?>&status=N&action=active&registration_id=<?php echo $sql[$i]['registration_id'] ; ?>" onClick="return(window.confirm('Are you sure you want to not allowed.'));"><img src="images/active.png" border="0" title="Aactive"/></a>Allowed
			<?php } ?>
			</td>
        </tr>
<?php  	$j++; }	
	 ?>
</table>
</div>
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>