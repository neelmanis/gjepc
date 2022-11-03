<?php 
session_start();
if(!isset($_SESSION['curruser_contact_name']))	header("location:index.php");
include('../db.inc.php');
include('../functions.php');
$adminID=$_SESSION['curruser_login_id'];
if(!isset($_SESSION['curruser_login_id'])){	header("location:index.php"); exit; }
?>

<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['company_name']="";
  $_SESSION['c_bp_number']="";
  $_SESSION['company_pan_no']="";
  
  header("Location: manage_outstanding.php?action=view");
}else
{
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{ 
		$_SESSION['company_name']=filter($_REQUEST['company_name']);
		$_SESSION['c_bp_number']=filter($_REQUEST['c_bp_number']);
		$_SESSION['company_pan_no']=filter($_REQUEST['company_pan_no']);
	}
}
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Outstanding Amount ||GJEPC||</title>
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
<div id="nav_wrapper"><div class="nav"><?php include("include/menu.php");?></div></div>
<div class="clear"></div>

<div class="breadcome_wrap">
  <div class="breadcome"><a href="#">Home</a> > Manage Outstanding </div></div>

<div id="main">
	<div class="content">
    	<div class="content_head">Manage Outstanding
        <?php if($_REQUEST['action']=='view_details'){?>
        <div style="float:right; padding-right:10px; font-size:12px;"><a href="manage_outstanding.php?action=view">Back to Outstanding</a></div>
        <?php }?>
         <a href="export_outstanding_list.php">Export Outstanding list</a>
        </div>
<div class="content_details1">
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
?>
<form name="search" action="" method="post" > 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1"><td colspan="11">Search Options</td></tr>
<tr>
    <td width="19%" ><strong>Company Name</strong></td>
    <td width="81%"><input type="text" name="company_name" id="company_name" class="input_txt" value="<?php echo $_SESSION['company_name'];?>" /></td>
</tr>     

<tr>
  <td><strong>BP Number</strong></td>
  <td><input type="text" name="c_bp_number" id="c_bp_number" class="input_txt" value="<?php echo $_SESSION['c_bp_number'];?>" /></td>
</tr>
<tr>
  <td><strong>Pan No.</strong></td>
  <td><input type="text" name="company_pan_no" id="company_pan_no" class="input_txt" value="<?php echo $_SESSION['company_pan_no'];?>" /></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Search"  class="input_submit" /> 
	<input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
</tr>	
</table>
</form>      
</div>

<?php if($_REQUEST['action']=='view') { ?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td width="2%"><a href="#">Sr. No.</a></td>
        <td width="5%">BP Number</td>
        <td width="15%">Company Name</td>
        <td width="10%">PAN No </td>
        <td width="2%">Defaulter Status</td>
        <td width="5%">Defaulter Outstanding</td>
        <td width="45%">Payment Defaulter Reason</td>
    </tr>
    
    <?php 
 	$page=1;//Default page
	$limit=50;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	
	}
	$start=($page-1)*$limit;
	
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'registration_master.post_date';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
    $sql="SELECT registration_master.id,registration_master.company_name,registration_master.company_pan_no,registration_master.payment_defaulter,registration_master.payment_defaulter_outstandingamount,registration_master.payment_defaulter_reason,communication_address_master.c_bp_number FROM registration_master INNER JOIN communication_address_master ON registration_master.id=communication_address_master.registration_id where 1 and communication_address_master.type_of_address='2' and communication_address_master.address_identity='CTC' and registration_master.payment_defaulter='Y'";
	
	if($_SESSION['company_name']!="")
	{
	$sql.=" and registration_master.company_name like '%".$_SESSION['company_name']."%'";
	}
	if($_SESSION['company_pan_no']!="")
	{
	$sql.=" and registration_master.company_pan_no ='".trim($_SESSION['company_pan_no'])."'";
	}
	if($_SESSION['c_bp_number']!=""){
		$sql.=" and communication_address_master.c_bp_number ='".trim($_SESSION['c_bp_number'])."'";
	}
	
	$sql.= "  ".$attach." ";

	$result1=$conn->query($sql);
	$rCount=$result1->num_rows;;
	
	$sql1= $sql." limit $start, $limit ";
	$result=$conn->query($sql1);
	
    if($rCount>0)
    {	
	while($row = $result->fetch_assoc())
	{
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        <td><?php echo $row['c_bp_number']; ?></td>
        <td><?php echo strtoupper(filter($row['company_name'])); ?></td>
        <td><?php echo strtoupper(filter($row['company_pan_no'])); ?></td>
  		<td><?php echo strtoupper(filter($row['payment_defaulter'])); ?></td>
        <td><?php echo strtoupper(filter($row['payment_defaulter_outstandingamount'])); ?></td>
        <td><?php echo strtoupper(filter($row['payment_defaulter_reason'])); ?></td>	
 	</tr>
	<?php
	$i++;
	   }
	 }
	 else
	 {
	 ?>
    <tr>
        <td colspan="10">Records Not Found</td>
    </tr>
    <?php  }  	?>
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
       
<div class="pages_1">Total number of Results: <?php echo $rCount;?> 
<?php echo pagination($limit,$page,'manage_outstanding.php?action=view&page=',$rCount); //call function to show pagination?>
</div>

</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>