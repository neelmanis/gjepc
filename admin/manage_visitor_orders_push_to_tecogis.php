<?php
session_start(); 
include('../db.inc.php');
include('../functions.php'); 
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php'); exit; }
$registration_id = intval(filter($_REQUEST['regid']));
$orderId = filter($_REQUEST['orderId']);
?>

<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['orderId']="";
  $_SESSION['visitor_id']="";
  $_SESSION['visitor_name']="";
  $_SESSION['company_name']="";
  header("Location: manage_visitor_orders_push_to_tecogis.php?action=view");
} else
{
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{
		$_SESSION['orderId']= trim($_REQUEST['orderId']);
		$_SESSION['visitor_id']= trim($_REQUEST['visitor_id']);
		$_SESSION['visitor_name']= trim($_REQUEST['visitor_name']);
		$_SESSION['company_name']= trim($_REQUEST['company_name']);	
	}
}

if(($_REQUEST['action']=='resetDownloadStatus') && ($_REQUEST['action']!=''))
{
	$visitor_id	=	intval(filter($_REQUEST['visitor_id']));
	$registration_id	=	intval(filter($_REQUEST['registration_id']));
	
	$sql="update visitor_order_history set downlaod_status='N' where visitor_id='$visitor_id' and registration_id='$registration_id'";
	$result = $conn ->query($sql);   
    if (!$result) die ($conn->error);
	echo"<meta http-equiv=refresh content=\"0;url=manage_visitor_orders_push_to_tecogis.php?action=view\">";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Visitor Orders || GJEPC ||</title>
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
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Visitor Order</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">
		
		<?php if($_REQUEST['action']=='view') { ?>
        Visitor List IIJS 2019 
		<?php } elseif($_REQUEST['action']=='orderHistory') { ?><div class="content_head_button" style="float:right; padding-right:10px; font-size:12px;">
        <a href="manage_visitor_orders_push_to_tecogis.php?action=view">Back</a></div> <?php } ?>
		</div>

<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
?>

<?php if($_REQUEST['action']=='view') { ?>
<div class="content_details1">
<form name="search" action="" method="post" > 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11">Search Options</td>
</tr>
<tr>
    <td width="19%"><strong>Order Id</strong></td>
    <td width="81%"><input type="text" name="orderId" id="orderId" class="input_txt" value="<?php echo $_SESSION['orderId'];?>" /></td>
</tr>   
<tr>
    <td width="19%"><strong>Registration No.</strong></td>
    <td width="81%"><input type="text" name="visitor_id" id="visitor_id" class="input_txt" value="<?php echo $_SESSION['visitor_id'];?>" /></td>
</tr>  
<tr>
    <td width="19%"><strong>Visitor Name</strong></td>
    <td width="81%"><input type="text" name="visitor_name" id="visitor_name" class="input_txt" value="<?php echo $_SESSION['visitor_name'];?>" /></td>
</tr>
<tr>
    <td width="19%"><strong>Company Name</strong></td>
    <td width="81%"><input type="text" name="company_name" id="company_name" class="input_txt" value="<?php echo $_SESSION['company_name'];?>" /></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Search" class="input_submit" /> 
	<input type="submit" name="Reset" value="Reset" class="input_submit" /></td>
</tr>	
</table>
</form> 
</div>
<div class="content_details1">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
            <tr class="orange1">
                <td>Registration no.</td>
				<td>Visitor Name</td>
				<td>Company Name</td>
				<td>Order Id</td>
				<td>Amount</td>
				<td>Paynent For</td>    
				<td>Downlaod Status</td>  
				<td>Reset For Downlaod</td> 
            </tr>
		<?php
		$page=1;//Default page
		$limit=50;//Records per page
		$start=0;//starts displaying records from 0
		if(isset($_GET['page']) && $_GET['page']!=''){
		$page=$_GET['page'];	
		}
		$start=($page-1)*$limit;
		
		$order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'a.id';
		$asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
		$attach = " order by ".$order_by." ".$asc_desc." ";
		
		$i=1;
		$sql = "SELECT a.*,b.name,c.company_name FROM `visitor_order_history` a,visitor_directory b,registration_master c WHERE a.payment_status = 'Y' and a.visitor_id=b.visitor_id and a.registration_id=c.id";		
		
		if($_SESSION['orderId']!="")
		{
			$sql.=" and a.orderId like '%".$_SESSION['orderId']."%'";
		}	
		if($_SESSION['visitor_id']!="")
		{
			$sql.=" and a.visitor_id like '%".$_SESSION['visitor_id']."%'";
		}
		if($_SESSION['visitor_name']!="")
		{
			$sql.=" and b.name like '%".$_SESSION['visitor_name']."%'";
		}
		if($_SESSION['company_name']!="")
		{
			$sql.=" and c.company_name like '%".$_SESSION['company_name']."%'";
		}
		$sql.= "  ".$attach." ";
		//echo $sql;
		$result1= $conn ->query($sql);
		$rCount= $result1->num_rows;

		
		$sql1= $sql." limit $start, $limit ";
		$result= $conn ->query($sql1);
		
		if($rCount>0)
		{	
		while($row = $result->fetch_assoc())
		{
		?>
		<?php 
		$checkMember = CheckMembership($row['registration_id'],$conn);
		if($checkMember=="M")
		{
		 $memberBP = getBPNO($row['registration_id'],$conn);
		} else {
		 $memberBP = getCompanyNonMemBPNO($row['registration_id'],$conn);
		}
		?>
            <tr>
                <td><?php echo $row['visitor_id']; ?></td>
				<td><?php echo VisitorName($row['visitor_id'],$conn); ?></td>
				<td><?php echo strtoupper(getNameCompany($row['registration_id'],$conn)); ?></td>  
				<td><?php echo $row['orderId']; ?></td>      
				<td><?php echo $row['amount']; ?></td>  
				<td><?php echo $row['payment_made_for']; ?></td>      
				<td align="left"><?php echo $row['downlaod_status']; ?></td>
				<?php if($row['downlaod_status']=="Y"){?>
				<td align="left"><a href="manage_visitor_orders_push_to_tecogis.php?action=resetDownloadStatus&visitor_id=<?php echo $row['visitor_id'];?>&registration_id=<?php echo $row['registration_id'];?>" onClick="return(window.confirm('Are you sure you want to download again.'));">RESET</a></td>  
				<?php }?>  
            </tr>
		<?php } }?>
		</table>
</div>
<?php } ?> 
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

if ($page < $counter - 1){
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
<div class="pages_1">Total number of Order: <?php echo $rCount;?> 
<?php echo pagination($limit,$page,'manage_visitor_orders_push_to_tecogis.php?action=view&page=',$rCount); //call function to show pagination?>
</div>
    </div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>