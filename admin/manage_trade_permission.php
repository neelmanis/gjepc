<?php 
session_start(); ob_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$curruser_region_id = filter($_SESSION['curruser_region_id']);
?>

<?php 
if(($_REQUEST['action']=='active') && ($_REQUEST['app_id']!=''))
{
    $registration_id =  intval(filter($_REQUEST['registration_id']));
	$status			 =	intval($_REQUEST['status']);	
	$app_id			 =	intval(filter($_REQUEST['app_id']));
	if(isset($registration_id) && $registration_id!=""){
	$sql = $conn ->query("update trade_general_info set admin_allow_for_application='$status' where registration_id='$registration_id'");
	if(!$sql) die ($conn->error);
	header("location:manage_trade_permission.php?action=view") ;
	}
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
<!--<div class="content_head">
<a href="get_disapprove_app.php"><div class="content_head_button">Download Disapprove Application</div></a>
<a href="get_approve_app.php"><div class="content_head_button">Download Approved Application </div></a>
<a href="get_region_wise.php"><div class="content_head_button">Download Region Wise Application </div></a>
<?php if($_SESSION['curruser_role']=="Super Admin" || $_SESSION['curruser_login_id']=='68') { ?>
<a href="trade_exhibition_data_import.php"><div class="content_head_button">Download All Application with Exhibition </div></a>
<?php } ?>
</div>-->
 
<div class="content_details1">
<?php 
if($_SESSION['error_msg']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
$_SESSION['error_msg']="";
}
?>

<form name="search" action="" method="post"> 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />        	

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11" >Search Options</td>
</tr>
<tr>
    <td><strong>company name</strong></td>
    <td><input type="text" name="company_name" id="company_name" class="input_txt" autocomplete="off"/></td>
</tr>	
<tr>
    <td><strong>gcode</strong></td>
	<td><input type="text" name="membership_id" id="membership_id" class="input_txt" autocomplete="off"/></td>
</tr>	
<tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Search"  class="input_submit" /> 
	<input type="submit" name="Reset" value="Reset" class="input_submit" />
	</td>
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
	$page=1;//Default page
	$limit=50;//Records per page
	$start=0;//starts displaying records from 0
    if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	}
	$start=($page-1)*$limit;
	$j=1;
		
	$adminregion =trim($_SESSION['curruser_region_id']);
	$role=trim($_SESSION['curruser_role']);
		
	if($role=="Super Admin")
	{
	$query = "SELECT * FROM (SELECT registration_id,admin_allow_for_application,app_id FROM trade_general_info where 1";	
	if(isset($_REQUEST['company_name']) && $_REQUEST['company_name']!="" )
	{
		$company_name = trim($_REQUEST['company_name']);
		$query .= " and `member_name` LIKE '%".$company_name."%'";
	}
	
	if(isset($_REQUEST['membership_id']) && $_REQUEST['membership_id']!="" )
	{
		$membership_id = $_REQUEST['membership_id'] ;
		$query .= " and `membership_id` LIKE '%".$membership_id."%'";
	}
	}
	elseif($role=="Admin")
	{
	$query = "SELECT * FROM (SELECT registration_id,admin_allow_for_application,app_id FROM trade_general_info where region_code in ('$adminregion') AND registration_id !=''";
	
	if(isset($_REQUEST['company_name']) && $_REQUEST['company_name']!="" )
	{
		$company_name = trim($_REQUEST['company_name']);
		$query .= " and (`member_name` LIKE '%".$company_name."%')";
	}
	
	if(isset($_REQUEST['membership_id']) && $_REQUEST['membership_id']!="" )
	{
		$membership_id = $_REQUEST['membership_id'] ;
		$query .= " and (`membership_id` LIKE '%".$membership_id."%')";
	}
	}
	
	$query .= ' ORDER BY modified_date DESC) as temp GROUP BY registration_id ORDER BY app_id DESC';
	//echo $query; exit;
	$stmt = $conn -> prepare($query);
	$stmt->execute();
	$result = $stmt->get_result();
	$rCount=$result->num_rows;
	$mainquery= $query." limit $start, $limit ";
	$sql = fetch($mainquery);
	// echo "<pre>";print_r($sql);
	for($i=0;$i<count($sql);$i++)
	{
	$sql1 = fetch('select * from registration_master where id='.$sql[$i]['registration_id']);
	?>
	 	<tr <?php if($i%2==0){ echo "bgcolor='#CCCCCC'"; } ?>>
        <td><?php echo $j;?></td>
	    <td><?php echo $sql1[0]['company_name']; ?></td>
		<td><?php echo $sql1[0]['gcode']; ?></td>
        <td><?php echo getIec($sql[$i]['registration_id'],$conn);?></td>
		<td><a href="application.php?registration_id=<?php echo $sql1[0]['id']; ?>"  style="color:#000000">View</a></td>
        <td>
		<?php if($sql[$i]['admin_allow_for_application'] == 'N') {?> 
		<a style="text-decoration:none;" href="manage_trade_permission.php?app_id=<?php echo $sql[$i]['app_id']; ?>&status=Y&action=active&&registration_id=<?php echo $sql[$i]['registration_id']; ?>" onClick="return(window.confirm('Are you sure you want to Allow'));"><img src="images/inactive.png" border="0" title="Active"/></a>&nbsp;&nbsp;&nbsp;(Not Allowed)
		<?php } ?>
		<?php if($sql[$i]['admin_allow_for_application'] == 'Y'){?> 
			<a style="text-decoration:none;" href="manage_trade_permission.php?app_id=<?php echo $sql[$i]['app_id']; ?>&status=N&action=active&registration_id=<?php echo $sql[$i]['registration_id'] ; ?>" onClick="return(window.confirm('Are you sure you want to not allowed.'));"><img src="images/active.png" border="0" title="Aactive"/></a>Allowed
			<?php } ?>
			</td>
        </tr>
	<?php $j++; }	?>
</table>
<div class="pages_1">Total number of Memberships: <?php echo $rCount;?> 
<?php echo pagination($limit,$page,'manage_trade_permission.php?action=view&page=',$rCount); //call function to show pagination?>
</div>
<?php
function pagination($per_page = 10, $page = 1, $url = '', $total){ 
$adjacents = "2";

$page = ($page == 0 ? 1 : $page); 
$start = ($page - 1) * $per_page; 

$prev = $page - 1; 
$next = $page + 1;
$lastpage = ceil($total/$per_page);
$lpm1 = $lastpage - 1;

$pagination = "";
if($lastpage > 1)
{ 
$pagination .= "<ul class='pagination'>";
$pagination .= "<li class='details'>Page $page of $lastpage</li>";
if ($lastpage < 7 + ($adjacents * 2))
{ 
for ($counter = 1; $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
}
elseif($lastpage > 5 + ($adjacents * 2))
{
if($page < 1 + ($adjacents * 2)) 
{
for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
$pagination.= "<li class='dot'>...</li>";
$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>"; 
}
elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
{
$pagination.= "<li><a href='{$url}1'>1</a></li>";
$pagination.= "<li><a href='{$url}2'>2</a></li>";
$pagination.= "<li class='dot'>...</li>";
for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
$pagination.= "<li class='dot'>..</li>";
$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>"; 
}
else
{
$pagination.= "<li><a href='{$url}1'>1</a></li>";
$pagination.= "<li><a href='{$url}2'>2</a></li>";
$pagination.= "<li class='dot'>..</li>";
for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
}
}

if($page < $counter - 1){
$pagination.= "<li><a href='{$url}$next'>Next</a></li>";
// $pagination.= "<li><a href='{$url}$lastpage'>Last</a></li>";
}else{
//$pagination.= "<li><a class='current'>Next</a></li>";
// $pagination.= "<li><a class='current'>Last</a></li>";
}
$pagination.= "</ul>\n"; 
} 
return $pagination;
} 
?>             
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>