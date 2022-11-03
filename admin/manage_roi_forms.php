<?php 
session_start();
if(!isset($_SESSION['curruser_contact_name'])){ header('Location: index.php'); exit; } 
if(!isset($_SESSION['curruser_login_id'])){	header("location:index.php"); exit; }
include('../db.inc.php');
include('../functions.php');
$adminID = intval(filter($_SESSION['curruser_login_id']));
?>

<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['name']="";
  $_SESSION['section']="";
  $_SESSION['selected_area']="";
  $_SESSION['application_status']="";
  $_SESSION['payment_status']="";
  header("Location: manage_roi_forms.php?action=view");
} else
{
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{ 
		$_SESSION['name']=filter($_REQUEST['name']);
		$_SESSION['section']=filter($_REQUEST['section']);
		$_SESSION['selected_area']=filter($_REQUEST['selected_area']);
		$_SESSION['application_status']=filter($_REQUEST['application_status']);
		$_SESSION['payment_status']=filter($_REQUEST['payment_status']);
	}
}

if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from roi_space_registration where id='$_REQUEST[id]'";	
	if(!$result = $conn ->query($sql))
	{
		die('Error: ' . mysqli_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=manage_roi_forms.php?action=view\">";
}
?>	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage ROI FORMS || GJEPC ||</title>
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

<div class="breadcome_wrap"><div class="breadcome"><a href="#">Home</a> > Manage ROI FORMS</div></div>

<div id="main">
	<div class="content">
    	<div class="content_head">Manage ROI FORMS
		<a href="export_roi_report.php">Download ROI FORM report</a> &nbsp;&nbsp; <a href="export_utr_roi_form.php">Download ROI Payment Data</a>
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
  <td><strong>Company Name</strong></td>
  <td><input type="text" name="name" id="name" class="input_txt" value="<?php echo $_SESSION['name'];?>" /></td>
</tr>

<tr>
  <td><strong>Section</strong></td>
  <td><input type="text" name="section" id="section" class="input_txt" value="<?php echo $_SESSION['section'];?>" /></td>
</tr>

<tr>
  <td><strong>Selected Area</strong></td>
  <td><input type="text" name="selected_area" id="selected_area" class="input_txt" value="<?php echo $_SESSION['selected_area'];?>" /></td>
</tr>

<tr>
  <td><strong>Application Status</strong></td>
  <td>
	<select name='application_status' id='application_status' class="input_txt">
	<option value=''>--Select Status--</option>
		<option value='Y'>Application approve</option>
		<option value='N'>Application disapprove</option>
		<option value='P'>Application pending</option>
	</select>
  </td>
</tr>
<tr>
  <td><strong>Payment Status</strong></td>
  <td>
	<select name='payment_status' id='payment_status' class="input_txt">
		<option value=''>--Select Status--</option>
		<option value='Y'>Payment approve</option>
		<option value='N'>Payment disapprove</option>
		<option value='P'>Payment pending</option>
	</select>
  </td>
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
        <td width="5%"><a href="#">Sr. No.</a></td>
        <td>Company Name</td>
		<td>Region</td>
        <td>Event Name</td>
        <td>Contact Person Name</td>
        <td>SO Number</td>
		<td>HO BP NO</td>
		<td>Billing BP NO</td>
		<td>Date</td>
		<td>Application Status</td>
		<td>Payment Status</td>
		<td colspan="2" align="center">Action</td>
		<td>Create SO</td>
		<!--<td>Create BP</td>-->
    </tr>
    
    <?php 
 	$page=1;//Default page
	$limit=50;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	
	}
	$start=($page-1)*$limit;
	
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'a.post_date';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	
    $sql="SELECT a.*, b.company_name,b.state from roi_space_registration a, registration_master b where 1";
	if($_SESSION['name']!="")
	{
		$sql.=" and b.company_name like '%".$_SESSION['name']."%'";
	}
	if($_SESSION['section']!="")
	{
		$sql.=" and a.section like '%".$_SESSION['section']."%'";
	}
	if($_SESSION['selected_area']!="")
	{
		$sql.=" and a.selected_area like '%".$_SESSION['selected_area']."%'";
	}
	if($_SESSION['application_status']!="")
	{
		$sql.=" and a.application_status like '%".$_SESSION['application_status']."%'";
	}
	if($_SESSION['payment_status']!="")
	{
		$sql.=" and a.payment_status like '%".$_SESSION['payment_status']."%'";
	}

	$sql.= " and a.registration_id=b.id ".$attach." ";

	//echo $sql;
	$result1 = $conn ->query($sql);
	$rCount  = $result1->num_rows;
	
	$sql1= $sql." limit $start, $limit ";
	$result = $conn ->query($sql1);
	
    if($rCount>0)
    {	
	while($row = $result->fetch_assoc())
	{
		if($row['member_type']=="MEMBER")
			$bpno=getBPNO($row['registration_id'],$conn);
		else
			$bpno = getCompanyNonMemBPNO($row['registration_id'],$conn);
		$billingBP = getBillingBPNO($row['billing_address_id'],$conn);
    ?>  
		<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        <td><?php echo getNameCompany($row['registration_id'],$conn); ?></td>
		<!--<td><?php echo getRegion($row['registration_id'],$conn); ?></td>-->
		<td><?php echo gotStateRegionName($row['state'],$conn); ?></td>
        <td><?php echo strtoupper(filter($row['event_name']));?></td> 
        <td><?php echo strtoupper(filter($row['contact_person_name'])); ?></td>
        <td align="left"><?php echo $row['sales_order_no']; ?></td>
		<td align="left"><?php echo $bpno;?> </td>
		<td align="left"><?php echo $bpno;?> </td>
		<td align="left"><?php echo $row['post_date']; ?></td>
		<td align="left"><?php echo $row['application_status']; ?></td>
		<td align="left"><?php echo $row['payment_status']; ?></td>
		<td align="left"><a href="roi_form_detail.php?action=view_details&bp_number=<?php echo $bpno;?>&id=<?php echo $row['id']?>&registration_id=<?php echo $row['registration_id']?>&event_name=<?php echo $row['event_name']?>"><img src="images/view.png" title="View" border="0" /></a></td>
		<td>
		<?php if($_SESSION['curruser_role']=="Super Admin"){?>
		<a href="manage_roi_forms.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" />
		<?php }?>
		</td>
		<?php if($row['sap_sale_order_create_status'] == 0) { ?>
			<td class="so" data-url="<?php echo $bpno;?> <?php echo $bpno;?> <?php echo $row['registration_id']; ?> <?php echo $row['event_name']; ?>">CREATE SO</td>
		<?php } else { ?>
			<td><a onclick="return(window.confirm('Sales Order Already Created'));"><img src="images/active.png"/></a></td>
		<?php } ?>
		<!--<td class="comp" data-url="<?php echo $rows['uid'];?>"><img src="images/reply.png" title="PUSH" border="0" style=""/></td>-->
 	</tr>
	<?php $i++; } } else {?>
    <tr>
        <td colspan="10">Records Not Found</td>
    </tr>
    <?php  } ?>
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
       
	<div class="pages_1">Total number of records: <?php echo $rCount;?> 
	<?php echo pagination($limit,$page,'manage_roi_forms.php?action=view&page=',$rCount); //call function to show pagination?>
	</div>
   </div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
$(".so").click(function() {
	var values = $(this).data('url').split(" ");
	var bpno=values[0];
	var billingBP=values[1];
	var registration_id=values[2];
	var event_name=values[3];
	
	if (confirm("Are you sure you want to create sales order")) {
		$.ajax({
		url: "so_roi_space_registration.php",
		method:"POST",
		data:{bpno:bpno,billingBP:billingBP,registration_id:registration_id,event_name:event_name},
		type: "POST",
		beforeSend: function() {
        	$("#overlay").show();
    	},
		success:function(data)
		{ 	//console.log(data); return false;
			if($.trim(data)==1){
				alert("Sales Order successfully Created..");
				window.location.href = "manage_roi_forms.php?action=view";
			} else {
				alert("Sorry There is some problem with SAP response");
				window.location.href = "manage_roi_forms.php?action=view";		
			}
			console.log(data);
		},
		});
	}	  
});
</script>
<div id="overlay"></div>
<style>
#overlay {
    position: fixed;
    display: none; 
    width: 100%; 
    height: 100%; 
    top: 0; 
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,0.8);
z-index:999;}  	
</style>
</body>
</html>