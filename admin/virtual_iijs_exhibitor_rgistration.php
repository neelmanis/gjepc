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
  $_SESSION['company_name']="";
  $_SESSION['email_id']="";
  $_SESSION['company_pan_no']="";
  $_SESSION['utr_number']="";
  $_SESSION['payment_status']="";
  $_SESSION['application_status']="";
  $_SESSION['sales_order_status']="";
  $_SESSION['part_salesorder_status']="";
  
  header("Location: virtual_iijs_exhibitor_rgistration.php?action=view");
}else
{
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{ 
		$_SESSION['company_name']=filter($_REQUEST['company_name']);
		$_SESSION['contact_person_name']=filter($_REQUEST['contact_person_name']);
		$_SESSION['event']=filter($_REQUEST['event']);
		$_SESSION['utr_number']=$_REQUEST['utr_number'];	
		$_SESSION['application_status']  =	$_REQUEST['application_status'];
		$_SESSION['payment_status']=$_REQUEST['payment_status'];
		$_SESSION['sales_order_status']=$_REQUEST["sales_order_status"];
	    $_SESSION['part_salesorder_status']=$_REQUEST["part_salesorder_status"];
				
	}
}
?>	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Virtual Exhibitor Registration ||GJEPC||</title>
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

<div class="breadcome_wrap"><div class="breadcome"><a href="#">Home</a> > Manage Virtual Exhibitor Registration</div></div>

<div id="main">
	<div class="content">
    	<div class="content_head">Manage Virtual Exhibitor Registration
        <?php if($_REQUEST['action']=='view_details'){?>
        <div style="float:right; padding-right:10px; font-size:12px;"><a href="virtual_iijs_exhibitor_rgistration.php?action=view">Back to List</a></div>
        <?php }?>
        <a href="export_virtual_iijs_data.php">Export Exhibitor List</a> / 
        <a href="export_virtual_iijs__utr_data.php">Export UTR Exhibitor List</a>
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
    <td><strong>UTR</strong></td>
    <td><input type="text" name="utr_number" id="utr_number" class="input_txt" value="<?php echo $_SESSION['utr_number'];?>" autocomplete="off"/></td>
  </tr>
<tr >
  <td><strong>Contact Person Name</strong></td>
  <td><input type="text" name="contact_person_name" id="contact_person_name" class="input_txt" value="<?php echo $_SESSION['contact_person_name'];?>" /></td>
</tr>
<tr>
  <td><strong>Packege</strong></td>
  <td>
	<select name="event" id="event">
		<option value="">--Select Packege--</option>
		<option value="standard" <?php if($_SESSION['event']=="standard"){?> selected="selected" <?php }?>>STANDARD PACKAGE</option>
		<option value="premium" <?php if($_SESSION['event']=="premium"){?> selected="selected" <?php }?>>PREMIUM PACKAGE</option>
		<option value="spremium" <?php if($_SESSION['event']=="spremium"){?> selected="selected" <?php }?>>SUPER-PREMIUM PACKAGE</option>
	</select>
  </td>
</tr>
<tr class="orange1">
  	<td colspan="11">Approval Details</td>
</tr>
<tr>
    <td><strong>Application Status</strong></td>        
    <td><select name="application_status" class="input_txt-select" >
      <option value="">Select Status</option>
      <option value="approved" <?php if($_SESSION['application_status']=='approved'){echo "selected";}?>>Application Approved</option>
      <option value="rejected" <?php if($_SESSION['application_status']=='rejected'){echo "selected";}?>>Application Disapproved</option>
      <option value="pending" <?php if($_SESSION['application_status']=='pending'){echo "selected";}?>>Application Pending</option>
      </select></td>
	</tr>   
    <tr>
    <td><strong>Payment Status</strong></td>
    <td>
    <select name="payment_status" class="input_txt-select" >
      <option value="">Select Status</option>
      <option value="approved" <?php if($_SESSION['payment_status']=='approved'){echo "selected='selected'";}?>>Payment Approved</option>
      <option value="rejected" <?php if($_SESSION['payment_status']=='rejected'){echo "selected='selected'";}?>>Payment Disapproved</option>
      <option value="pending" <?php if($_SESSION['payment_status']=='pending'){echo "selected='selected'";}?>>Payment Pending</option>
    </select></td>
    </tr>
	<tr>
	<td><strong>Check Sales order Status</strong></td><td>
    <select name="sales_order_status" class="input_txt-select">
      <option value="">Select Status</option>
      <option value="Y" <?php if($_SESSION['sales_order_status']=='Y'){echo "selected='selected'";}?>>Sales Order Created</option>
      <option value="N" <?php if($_SESSION['sales_order_status']=='N'){echo "selected='selected'";}?>>Sales Order NOT Created</option>
    </select>
	</td>
	</tr>
	<tr>
	<td><strong>Check Partial Status</strong></td><td>
    <select name="part_salesorder_status" class="input_txt-select">
      <option value="">Select Status</option>
      <option value="0" <?php if($_SESSION['part_salesorder_status']=='0'){echo "selected='selected'";}?>>Sales Order NOT Created</option>
    </select>
	</td>
	</tr>
<tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Search" class="input_submit" /> 
	<input type="submit" name="Reset" value="Reset" class="input_submit" /></td>
</tr>	
</table>
</form>      
</div>

<?php if($_REQUEST['action']=='view') { ?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td width="5%"><a href="#">Sr. No.</a></td>
        <td width="5%">BP No</td>
        <td width="25%">Company Name</td>
        <td width="25%">Contact Person Name</td>
        <td width="25%">Contact Person Email</td>
        <td width="10%">Packege</td>
        <td width="10%">Additional Image</td>
        <td width="10%">Meeting Room</td>
        <td>Action</td>
		<td>Create SO</td>
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
	
    
    //$sql="SELECT * FROM virtual_event_registration where 1";
    //$sql="SELECT a.registration_id,a.company_name,a.contact_person_name,a.contact_person_email,a.event,a.additional_image,a.meeting_room,a.application_status,u.utr_number,u.show,u.utr_approved FROM virtual_event_registration a left join utr_history u on a.registration_id=u.registration_id AND a.event_selected=u.event_selected where a.event_selected='vbsm2'";
    $sql="SELECT a.registration_id,a.company_name,a.contact_person_name,a.contact_person_email,a.event,a.additional_image,a.meeting_room,a.application_status,a.sales_order_no,a.sap_sale_order_create_status,a.payment_status,u.utr_number,u.show,u.utr_approved,u.part_salesorder_status FROM virtual_event_registration a left join utr_history u on a.registration_id=u.registration_id AND a.event_selected=u.event_selected where a.event_version='VIRL2'";
	
	if($_SESSION['company_name']!="")
	{
		$sql.=" and company_name like '%".$_SESSION['company_name']."%'";
	}
	if($_SESSION['contact_person_name']!="")
	{
		$sql.=" and contact_person_name like '%".$_SESSION['contact_person_name']."%'";
	}
	if($_SESSION['event']!="")
	{
		$sql.=" and event ='".$_SESSION['event']."'";
	}
	if($_SESSION['utr_number']!="")
	{
	  $sql.=" and utr_number like '%".$_SESSION['utr_number']."%'";
	}
	
	if($_SESSION['application_status']!="")
	{ 
  	if($_SESSION['application_status']=='approved')
	{
  	$sql.=" and application_status='approved' ";
	}else if($_SESSION['application_status']=='pending')
	{
		$sql.=" and application_status='' ";
	}else{
		$sql.=" and application_status='rejected' ";
	}
	}
	
	if($_SESSION['payment_status']!="")
	{ 
  	if($_SESSION['payment_status']=='approved')
	{
  	$sql.=" and payment_status='approved' ";
	}else if($_SESSION['payment_status']=='pending')
	{
		$sql.=" and payment_status IS NULL ";
	}else{
		$sql.=" and payment_status='rejected' ";
	}
	}
	
	if($_SESSION["sales_order_status"]!="")
	{	
		if($_SESSION["sales_order_status"]=='Y')
			$sql.=" and a.sales_order_no!=''";
		else
		$sql.=" and a.sales_order_no IS NULL";		
	}
	
	if($_SESSION["part_salesorder_status"]!="")
	{	
		if($_SESSION["part_salesorder_status"]=='0')
			$sql.=" and u.IsDone='0' and (u.sap_so_status='0' || u.sap_so_status IS NULL)";		
	}
  
	$sql.= "  ".$attach." ";

	$result1 = $conn ->query($sql);
	$rCount  = $result1->num_rows;
	
	$sql1= $sql." limit $start, $limit ";
	$result = $conn ->query($sql1);
	
    if($rCount>0)
    {	
	while($rows = $result->fetch_assoc())
	{ //echo '<pre>'; print_r($rows);
		$bpno = getBPNO($rows['registration_id'],$conn);
		$nonmemberBP = getCompanyNonMemBPNO($rows['registration_id'],$conn);
    ?>  
 	<tr <?php if($i%2==0){ echo "bgcolor='#CCCCCC'"; } ?>>
        <td><?php echo $i;?></td>
        <td><?php if($bpno!='') { echo $bpno; } else { echo $nonmemberBP; }?></td>
        <td><?php echo strtoupper($rows['company_name']);?></td>
        <td><?php echo strtoupper($rows['contact_person_name']);?></td>
        <td><?php echo strtoupper($rows['contact_person_email']);?></td>
        <td><?php echo strtoupper($rows['event']);?></td>
        <td><?php echo strtoupper($rows['additional_image']);?></td>
        <td><?php echo strtoupper($rows['meeting_room']);?></td>
       	<td><a href="virtual_approval.php?registration_id=<?php echo $rows['registration_id'];?>">A/D </a></td>
		
		<?php /* if($rows['application_status']=="approved" && $rows['registration_id']!=''){ ?>
		<td class="so" data-url="<?php echo $bpno; ?> <?php echo $rows['registration_id'];?>">CREATE SO</td>
		<?php } */?>
		
		<?php if($rows['application_status']=="approved" && $rows['utr_approved']=="Y"){ ?>
		<?php if($rows['sap_sale_order_create_status'] == 0) { ?>
		<?php if($bpno!='' || $nonmemberBP!=''){ ?>
		<td class="so" data-url="<?php if($bpno!=''){ echo $bpno; } else { echo $nonmemberBP; } ?> <?php echo $rows['registration_id'];?>">CREATE SO</td><?php } ?>
		<?php } else { ?>
		<td><a onclick="return(window.confirm('Sales Order Already Created'));"><img src="images/active.png"/></a></td>
		<?php } } ?>
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
       
<div class="pages_1">Total Count: <?php echo $rCount;?> 
<?php echo pagination($limit,$page,'virtual_iijs_exhibitor_rgistration.php?action=view&page=',$rCount); //call function to show pagination?>
</div>
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(".so").click(function() {
	var values = $(this).data('url').split(" ");
	var bpno=values[0];
	var registration_id=values[1];
	//alert(bpno);
	
	if (confirm("Are you sure you want to create sales order")) {
		$.ajax({
		url: "virtual_so_api.php",
		method:"POST",
		data:{bpno:bpno,registration_id:registration_id},
		type: "POST",
		beforeSend: function() {
        	$("#overlay").show();
    	},
		success:function(data)
		{ 	//console.log(data); exit;
			if($.trim(data)==1){
				alert("Sales Order successfully Created..");
				window.location.href = "virtual_iijs_exhibitor_rgistration.php?action=view";
			}else{
				alert("Sorry There is some problem with SAP response"); 
				window.location.href = "virtual_iijs_exhibitor_rgistration.php?action=view";			
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