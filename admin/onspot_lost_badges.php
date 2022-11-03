<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');
$adminID=$_SESSION['curruser_login_id'];
$registration_id = $_REQUEST['regid'];
$orderId = $_REQUEST['orderId'];
$id = $_REQUEST['id'];

function getCompanyPANNO($id)
{
	$query_sel = "SELECT company_pan_no FROM registration_master where id='$id'";
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['company_pan_no'];
	}
}

?>
<!---- OFFLINE ----->
<?php
$regsql = "select * from registration_master where id = '$registration_id'";
$regquery = mysql_query($regsql);
while($regrow = mysql_fetch_array($regquery))
{
$companyname = $regrow['company_name'];
$email_id = $regrow['email_id'];
}
?>

<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['company_name']="";
  $_SESSION['pan_no']="";
  $_SESSION['mobile']="";
  $_SESSION['visitor_approval']="";
  
  header("Location: onspot_lost_badges.php?action=view");
} else
{
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{ 
	$_SESSION['company_name']=mysql_real_escape_string($_REQUEST['company_name']);
	$_SESSION['pan_no']=mysql_real_escape_string($_REQUEST['pan_no']);
	$_SESSION['mobile']=mysql_real_escape_string($_REQUEST['mobile']);
	$_SESSION['visitor_approval']=$_REQUEST['visitor_approval'];
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lost Badges </title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<!--navigation-->
<script type="text/javascript" src="fancybox/jquery-3.3.1.js"></script>      
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
<!-- lightbox Thum -->
<link rel="stylesheet" type="text/css" href="fancybox/fancybox_css.css" media="screen" />
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="fancybox/fancybox_js.js"></script>

<script type="text/javascript">
		$(document).ready(function() {
			$("div.fancyDemo a").fancybox();
		});
</script>
<!-- lightbox Thum -->

<?php
$sqlreg1 = "SELECT * FROM registration_master where id='$registration_id'";
$res = mysql_query($sqlreg1);
if($vals = mysql_fetch_array($res))
{
$reg_approved = $vals['approval_status'];
}
?>
<script>
var reg_approv = '<?php echo $reg_approved; ?>';
$(document).ready(function(){
 if(reg_approv == 'D')
 {
 $('#reg_disapprove').show();
 }
});
</script>

<style type="text/css">

.style1 {color: #FF0000}
.style2 {
	font-size: 16px;
	font-weight: bold;
}
<?php if($_REQUEST['action']=='view') { ?>
#search{display:block;}
#page_ids{display:block;}
<?php  } else { ?>
#search{display:none;}
#page_ids{display:none;}
<?php } ?>

.blah{
    width: 100px;
    height: 100px;
}
-->
.fancybox-button--zoom,.fancybox-button--play,.fancybox-button--thumbs,.fancybox-button--arrow_left,.fancybox-button--arrow_right,.fancybox-infobar{display:none!important;}
</style>
<style type="text/css">
	border: 1px solid #ccc;
    border-collapse: separate;
    margin: 0;
    padding: 0;
    background: white;
    width: 50%;
    table-layout: fixed;
}
.inner tr {
background: #f8f8f8;
border: 1px solid #ddd;
padding: .35em;
}
.inner th,
.inner td {padding: .625em;text-align: left;padding: 10px 20px;}
.inner th {font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54;}

</style>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a>
    <?php if($_REQUEST['actions']=='companyedit'){ ?> Company details
    <?php } else { ?> Employee Directory <?php } ?></div>
</div>

<div id="main">
	<div class="content">
    
    	<div class="content_head">
			
        <?php if($_REQUEST['action']=='orderDetails') { ?>
        Order Details <div class="content_head_button" style="float:right; padding-right:10px; font-size:12px;"><a href="onspot_lost_badges.php?action=view">Back</a></div>
		<?php } elseif($_REQUEST['action']=='orderHistory') { ?><div class="content_head_button" style="float:right; padding-right:10px; font-size:12px;">
        <a href="onspot_lost_badges.php?action=orderDetails&regid=<?php echo $registration_id; ?>">Back</a></div>
        Payment Details
        <?php } elseif($_REQUEST['action']=='viewReg'){ ?>Employee Directory 
        <div class="content_head_button" style="float:right; padding-right:10px; font-size:12px;"><a href="onspot_lost_badges.php?action=view">Employee Directory</a></div>
        <div class="content_head_button" style="float:right; padding-right:10px; font-size:12px;"><a href="onspot_lost_badges.php?action=view">Back</a></div> 
        <?php } elseif($_REQUEST['action']=='edit'){ ?>
        Employee Directory  <div class="content_head_button" style="float:right; padding-right:10px; font-size:12px;">
        <a href="onspot_lost_badges.php?action=viewReg&regid=<?php echo $registration_id; ?>">Back</a></div>
        <?php } elseif($_REQUEST['actions']=='companyedit'){ ?>
        Company Details  <div class="content_head_button" style="float:right; padding-right:10px; font-size:12px;">
        <a href="onspot_lost_badges.php?action=view">Back</a></div> 
        <?php } else { ?>	Onspot Lost Badges
        <div style="float:right; padding-right:10px; font-size:12px;">
	    <div style="float:right; padding-right:10px; font-size:12px;">
        <a href="export_onspot_lost_badges.php">Download Order History</a></div>
		</div>
		
        <?php } ?>
		<div class="clear"></div>
        </div>
		
<?php if($_REQUEST['action']=='view') { ?>
<div class="content_details1">
<?php 
	//$sql5="select * from visitor_directory where isApplied='Y' AND registration_id!='0' AND visitor_approval!='O'";
	$sql5="SELECT a.* , b.* FROM registration_master a INNER JOIN dump_lost_visitor_badge b ON a.company_pan_no = b.company_pan_no group by b.company_pan_no";
	$result5=mysql_query($sql5);
	$total_application=mysql_num_rows($result5);
	
	$total_approve=0;
	$total_pending=0;
	$total_disapprove=0;
	while($rows5=mysql_fetch_array($result5))
	{
		if($rows5['visitor_approval']=='Y')
		{
			$total_approve=$total_approve+1;
		}else if($rows5['visitor_approval']=='P')
		{
			$total_pending=$total_pending+1;
		}else if($rows5['visitor_approval']=='D')
		{
			$total_disapprove=$total_disapprove+1;
		}
	}	
?>
   	      <table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
   	        <tr class="orange1">
   	          <td colspan="11" >Report Summary</td>
            </tr>
   	        <tr>
   	          <td><strong>Total Application</strong></td>
   	          <td><strong>Approve Application</strong></td>
   	          <td><strong>Disapprove Application</strong></td>
   	          <td><strong>Pending Application</strong></td>
            </tr>
   	        <tr>
   	          <td><?php echo $total_application;?></td>
   	          <td><?php echo $total_approve;?></td>
   	          <td><?php echo $total_disapprove;?></td>
   	          <td><?php echo $total_pending;?></td>
            </tr>
        </table>
      </div>
<?php } ?>
<div class="content_details1" id="search">
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
?>
<form name="search" action="" method="post" > 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11" >Search Options</td>
</tr>
<tr>
    <td width="19%" ><strong>Company Name</strong></td>
    <td width="81%"><input type="text" name="company_name" id="company_name" class="input_txt" value="<?php echo $_SESSION['company_name'];?>" autocomplete="off"/></td>
</tr>     
<tr>
  <td><strong>Pan Number</strong></td>
  <td><input type="text" name="pan_no" id="pan_no" class="input_txt" value="<?php echo $_SESSION['pan_no'];?>" autocomplete="off"/></td>
</tr>
<tr>
  <td><strong>Mobile Number</strong></td>
  <td><input type="text" name="mobile" id="mobile" class="input_txt" value="<?php echo $_SESSION['mobile'];?>" autocomplete="off"/></td>
</tr>
<td><strong>Visitor Status</strong></td>        
    <td>
        <select name="visitor_approval" class="input_txt-select" >
        <option value="">Select Status</option>
        <option value="P" <?php if($_SESSION['visitor_approval']=='P'){echo "selected='selected'";;}?>>Pending</option>
        <option value="Y" <?php if($_SESSION['visitor_approval']=='Y'){echo "selected='selected'";;}?>>Approved</option>
        <option value="D" <?php if($_SESSION['visitor_approval']=='D'){echo "selected='selected'";;}?>>Disapproved</option>
        <option value="U" <?php if($_SESSION['visitor_approval']=='U'){echo "selected='selected'";;}?>>Updated</option>
        </select>
    </td>
</tr>
    <td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Search" class="input_submit"/> <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
</tr>	
</table>
</form>      
</div>

<!------------------------------- ORDER DIRECTORY ---------------------------------->

<?php if($_REQUEST['action']=='view') {?>  
<div class="content_details1">
<form name="form1" action="" method="post" > 
<input type="hidden" name="action_update" value="UPDATE_STATUS" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td>Company Name</td>
	<td>BP Number</td>
    <td>Pan Number</td>
    <td>GST Number</td>
    <td>Email</td>
    <td>Company</td>
	<td>Co Status</td>
    <td>View Details</td>
    <td>Create BP</td>
    <td>Directory Status</td>
  </tr>
	<?php  
	$page=1;//Default page
	$limit=25;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];	
	}
	$start=($page-1)*$limit;
  
 /* $sql="SELECT 
DISTINCT rm.id, rm.company_name, rm.company_pan_no, rm.mobile_no, rm.company_gstn, rm.email_id,rm.approval_status FROM registration_master rm
inner join visitor_directory vd on rm.id=vd.registration_id 
inner join visitor_order_detail vo on vo.regId=vd.registration_id
AND vd.isApplied='Y' AND vd.visitor_approval!='O' AND vo.payment_type='offline' AND vo.payment_status='Y'";
 	*/
	$sql="SELECT DISTINCT rm.id, rm.company_name, rm.company_pan_no, rm.mobile_no, rm.company_gstn, rm.email_id,vd.visitor_approval FROM registration_master rm
	inner join dump_lost_visitor_badge vd on rm.company_pan_no=vd.company_pan_no";

	if($_SESSION['company_name']!="")
	{
	$sql.=" and rm.company_name like '%".$_SESSION['company_name']."%'";
	}
	if($_SESSION['pan_no']!="")
	{
	$sql.=" and rm.company_pan_no like '%".$_SESSION['pan_no']."%'";
	}
	if($_SESSION['mobile']!="")
	{
	$sql.=" and rm.mobile_no like '%".$_SESSION['mobile']."%'";
	}
	
	//echo $sql;
	$result=mysql_query($sql);

	$rCount=mysql_num_rows($result);
	$sql1= $sql."  limit $start, $limit";
	$result1=mysql_query($sql1);
		
  if($rCount>0)
  {	
  while($rows=mysql_fetch_array($result1))
  {
  ?>
  <?php 
  $checkMember = CheckMembership($rows['id']);
  if($checkMember=="M")
  {
	 $memberBP = getBPNO($rows['id']);
  } else {
	  $memberBP = getCompanyNonMemBPNO($rows['id']);
  }
  ?>
  <tr>
    <td><?php echo strtoupper($rows['company_name']);?></td>
	<td><?php echo $memberBP;?></td>
    <td><?php echo $rows['company_pan_no'];?></td> 
    <td><?php echo $rows['company_gstn'];?></td>   
    <td><?php echo $rows['email_id'];?></td>
    <td align="center" valign="middle"><a href="onspot_lost_badges.php?actions=companyedit&regid=<?php echo $rows['id'];?>">
    <img class="icons" src="images/view.png" title="Company Details" border="0" /></a></td>
	<td>
	<?php
	if($rows['visitor_approval']=="") 
        		echo "<img src='images/notification-exclamation.gif' border='0' />";	
			elseif($rows['visitor_approval']=="Y")
				echo "<img src='images/yes.gif' border='0' />";	
			else
				echo "<img src='images/no.gif' border='0' />";
	?>
	</td>
    <td align="left" valign="middle"><a href="onspot_lost_badges.php?action=orderDetails&regid=<?php echo $rows['id'];?>">Order Details</a> /  
    <a href="onspot_lost_badges.php?action=viewReg&regid=<?php echo $rows['id'];?>">Employee Details</a></td>
    <!--..................... Create Company BP Start ------------>
	<?php //echo $rows['visitor_approval'];
	if($checkMember=="NM") {
	if($memberBP=="" || $memberBP==0) { ?>
	<td class="comp" data-url="<?php echo $rows['id'];?>"><img src="images/reply.png" title="PUSH" border="0" style=""/></td>
	<?php } else { ?>
	<td><a onclick="return(window.confirm('BP Already Created'));"><img src="images/active.png"/></a></td>
	<?php } } else { ?>
	<td><a onclick="return(window.confirm('BP Already Created'));"><img src="images/active.png"/></a></td>
	<?php } ?>
    <!--..................... Create Company BP Stop ------------>
    <td align="left" valign="middle"><?php echo checkApproval_status($rows['id']);?></td>
  </tr>
  <?php
   $i++;
   } 
}
   else
   {
   ?>
  <tr>
    <td colspan="8">Records Not Found</td>
  </tr>
  <?php  }  	?>
</table>
</form>
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
<div class="pages_1" id="page_ids">Total number of Employee Directory: <?php echo $rCount;?>
<?php echo pagination($limit,$page,'onspot_lost_badges.php?action=view&page=',$rCount); //call function to show pagination?>
</div>  

<!------------------------------- VIEW DREGISTRATION ---------------------------------->
      
<?php if($_REQUEST['action']=='viewReg') {?>  
<div class="content_details1">
<form name="form1" action="" method="post" > 
<input type="hidden" name="action_update" value="UPDATE_STATUS" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td>Name</td>
	<td>BP Number</td>
    <td>Designation Type</td>
    <td>Mobile Number</td>
    <td>Pan No.</td>
    <td>Aadhar Number</td>
	<td>Create BP</td>
    <td>Status</td>
    <td>View Details</td>
  </tr>
    <?php  
	$page=1;//Default page
	$limit=100;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	
	}
	$start=($page-1)*$limit;
    $company_pan_no = getCompanyPANNO($registration_id);
    $sql="SELECT * FROM dump_lost_visitor_badge where company_pan_no = '$company_pan_no' "; 	 
	$result=mysql_query($sql);
	$rCount=mysql_num_rows($result);
	$sql1= $sql."  limit $start, $limit";
	$result1=mysql_query($sql1);
	
  if($rCount>0)
  {	
  while($rows=mysql_fetch_array($result1))
  { 
	$visitor_approval = $rows['visitor_approval'];
	if($visitor_approval == "Y"){ $visitor_approval= "<span style='color:green'>Approved</span>";} 
	if($visitor_approval == "P"){ $visitor_approval= "<span style='color:blue'>Pending</span>";}
	if($visitor_approval == "D"){ $visitor_approval= "<span style='color:red'>Disapproved</span>";}
	if($visitor_approval == "U"){ $visitor_approval= "<span style='color:green'>Updated</span>";}
  ?>
  <tr>
    <td><?php echo strtoupper($rows['name']);?></td>
	<td><?php echo strtoupper($rows['person_bp_number']);?></td>
    <td><?php echo $rows['degn_type'];?></td> 
    <td><?php echo $rows['mobile'];?></td> 
    <td><?php echo $rows['pan_no'];?></td>  
    <td><?php echo $rows['aadhar_no'];?></td> 
    <!--..................... Create Person BP Start ------------>
	<?php //echo $rows['visitor_approval'];
	if($rows['visitor_approval'] == "Y"){
	/*	echo checkMobPan($rows['mobile']); For checking same mobile no have how many BP Created*/
	if($rows['person_bp_number']=="" || $rows['person_bp_number']==0) { ?>
	<td class="sap" data-url="<?php echo $rows['id'];?> <?php echo $_REQUEST['regid'];?>"><img src="images/reply.png" title="PUSH" border="0" style=""/></td>
	<?php } else { ?>
	<td><a onclick="return(window.confirm('BP Already Created'));"><img src="images/active.png"/></a></td>
	<?php } }?>
    <!--.....................Create BP API STOP ------------>
    <td><?php echo $visitor_approval;?></td>   
    <td align="left" valign="middle"><a href="onspot_lost_badges.php?action=edit&id=<?php echo $rows['id'];?>&regid=<?php echo $_REQUEST['regid'];?>">
    <img src="images/edit.gif" title="Edit" border="0" /></a></td>
  </tr>
  <?php
   $i++;
   }
   
}
   else
   {
   ?>
  <tr>
    <td colspan="8">Records Not Found</td>
  </tr>
  <?php  }  	?>
</table>
</form>
</div>
<?php } ?>  

<!------------------------------- ORDER DETAILS ---------------------------------->

<?php if($_REQUEST['action']=='orderDetails') {?>  
<div class="content_details1">
<form name="form1" action="" method="post" > 
<input type="hidden" name="action_update" value="UPDATE_STATUS" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td>Company Name</td>
    <td>Payment Type</td>
    <td>Transaction Msg</td>
    <td>Order Id</td>
	<td>View Order</td>
    <td>Sales Order</td>
	<td>Create SO</td>
  </tr>
	<?php  
	$page=1;//Default page
	$limit=100;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];	
	}
	$start=($page-1)*$limit;
  
   // $sql="SELECT * FROM visitor_order_detail where regId = '$registration_id' and payment_status = 'Y' AND payment_type='offline'";
    $company_pan_no = getCompanyPANNO($registration_id);
    $sql="SELECT * FROM dump_lost_visitor_badge where company_pan_no = '$company_pan_no' "; 	
	$result=mysql_query($sql);

	$rCount=mysql_num_rows($result);
	$sql1= $sql."  limit $start, $limit";
	$result1=mysql_query($sql1);	
	
  if($rCount>0)
  {	
  while($rows=mysql_fetch_array($result1))
  {
  ?>
  <?php 
 /* $checkMember = CheckMembership($_REQUEST['regid']);
  if($checkMember=="M")
  {
	 $memberBP = getBPNO($_REQUEST['regid']);
  } else {
	  $memberBP = getCompanyNonMemBPNO($_REQUEST['regid']);
  } */
  ?>
  <tr >
    <td><?php echo getNameCompany($_REQUEST['regid']);?></td>
    <td><?php echo $rows['payment_mode'];?></td> 
    <td><?php echo $rows['txn_msg'];?></td> 
    <td><?php echo $rows['orderId'];?></td> 
	<td align="left" valign="middle"><a href="onspot_lost_badges.php?action=orderHistory&orderId=<?php echo $rows['orderId'];?>&regid=<?php echo $_REQUEST['regid'];?>" style="color:#000000">VIEW</a></td>
	<td><?php echo $rows['sales_order_no'];?></td>
	<!--.....................Sales Order Create API------------>
    <?php if($rows['sap_sale_order_create_status'] == 0) { ?>
	<?php if($rows['company_bp_number']!=''){?>
	<td class="so" data-url="<?php echo $rows['company_bp_number'];?> <?php echo $_REQUEST['regid'];?> <?php echo $rows['orderId'];?>">CREATE SO</td>
	<?php } ?>
    <?php } else { ?>
    <td><a onclick="return(window.confirm('Sales Order Already Created'));"><img src="images/active.png"/></a></td>
    <?php } ?>
	<!--..................... End Sales Order Create API------------>
  </tr>
  <?php
   $i++;
   }  
}
   else
   {
   ?>
  <tr>
    <td colspan="8">Records Not Found</td>
  </tr>
  <?php  }  	?>
</table>
</form>
</div>
<?php } ?> 

<!----------------------------- ORDER HISTORY ---------------------------------->

<?php if($_REQUEST['action']=='orderHistory') {?>  
<div class="content_details1">
<form name="form1" action="" method="post" > 
<input type="hidden" name="action_update" value="UPDATE_STATUS" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td>Visitor Name</td>
    <td>Payment Made For</td>
    <td>Amount</td>
    <td>Shows</td>
    <td>Year</td>
    <td>Payment Status</td>
  </tr>
  <?php
  
	$page=1;//Default page
	$limit=100;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	
	}
	$start=($page-1)*$limit;
  
    //$sql="SELECT * FROM visitor_order_history where orderId = '$orderId' and registration_id = '$registration_id'";
	$company_pan_no = getCompanyPANNO($registration_id);
    $sql="SELECT * FROM dump_lost_visitor_badge where orderId = '$orderId' AND company_pan_no = '$company_pan_no' ";  	 
	$result=mysql_query($sql);

	$rCount=mysql_num_rows($result);
	$sql1= $sql."  limit $start, $limit";
	$result1=mysql_query($sql1);
	
	
  if($rCount>0)
  {	
  while($rows=mysql_fetch_array($result1))
  {?>
  <tr >
    <td><?php echo $rows['name'];?></td> 
    <td>LOST</td> 
    <td><?php echo $rows['amount'];?></td>   
    <td><?php echo $rows['shows'];?></td>
    <td><?php echo $rows['year'];?></td> 
    <td>Success</td> 
  </tr>
  <?php
   $i++;
   }  
}
   else
   {
   ?>
  <tr>
    <td colspan="8">Records Not Found</td>
  </tr>
  <?php  }  	?>
</table>
</form>
</div>
<?php } ?> 

<!------------------------ UPDATE FOR EMPLOYEE DIRECTORY ------------------------------->
  
<?php    
if(($_REQUEST['action']=='add') || ($_REQUEST['action']=='edit'))
{
  $action='save';
  if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
  {
		$action='update';
		$result2 = mysql_query("SELECT * FROM dump_lost_visitor_badge where id='$id'");
		if($row2 = mysql_fetch_array($result2))
		{			
			$post_date=stripslashes($row2['post_date']);
			$degn_type=stripslashes($row2['degn_type']);
			$gender=stripslashes($row2['gender']);
			$name=stripslashes($row2['name']);
			$lname=stripslashes($row2['lname']);
			$mobile=stripslashes($row2['mobile']);
			$email=stripslashes($row2['email']);
			$aadhar_no=stripslashes($row2['aadhar_no']);
			$designation=stripslashes($row2['designation']);
			$pan_no=stripslashes($row2['pan_no']);
			$photo=stripslashes($row2['photo']);
			$salary_slip_copy=stripslashes($row2['salary_slip_copy']);
			$pan_copy=stripslashes($row2['pan_copy']);
			$partner=stripslashes($row2['partner']);
			$approval=stripslashes($row2['visitor_approval']);
			$disapprove_reason=stripslashes($row2['disapprove_reason']);
			
		}
	}
?>   
<div class="content_details1">
<form name="details" action="" method="post" >        	
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
  <tr class="orange1">
     <td colspan="11" >Employee Directory</td>
  </tr>
  <tr>
    <td ><strong>Name</strong></td>
    <td><input type="text" name="name" id="name" class="input_txt" value="<?php echo $name; ?>" /></td>
  </tr>
  <tr>
    <td ><strong>Last Name</strong></td>
    <td><input type="text" name="lname" id="lname" class="input_txt" value="<?php echo $lname; ?>" /></td>
  </tr>
  <tr>
    <td ><strong>Gender</strong></td>
    <td><input type="text" name="gender" id="gender" class="input_txt" value="<?php echo $gender; ?>" readonly/></td>
  </tr>
  <tr >
    <td ><strong>Designation Type</strong></td>
    <td><input type="text" name="degn_type" id="degn_type" class="input_txt" value="<?php echo $degn_type; ?>" readonly/></td>
  </tr>
   <tr >
    <td ><strong>Designation</strong></td>
    <td><input type="text" name="designation" id="designation" class="input_txt" value="<?php echo getVisitorDesignation($row2['designation_id']); ?>" readonly/></td>
  </tr>
  <tr >
    <td ><strong>Mobile Number</strong></td>
    <td><input type="text" name="mobile" id="mobile" class="input_txt" value="<?php echo $mobile; ?>" /></td>
  </tr>
  <tr >
    <td ><strong>Email Id</strong></td>
    <td><input type="text" name="email" id="email" class="input_txt" value="<?php echo $email; ?>" /></td>
  </tr>
  <tr >
    <td ><strong>Aadhar Number</strong></td>
    <td><input type="text" name="aadhar_no" id="aadhar_no" class="input_txt" value="<?php echo $aadhar_no; ?>" /></td>
  </tr>
  <tr >
    <td ><strong>Pan Number</strong></td>
    <td><input type="text" name="pan_no" id="pan_no" class="input_txt" value="<?php echo $pan_no; ?>" /></td>
  </tr>
  <tr >
    <td ><strong>Photo</strong></td>
    <td>  
    <a data-fancybox="gallery" href="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/photo/<?php echo $photo; ?>"> 
    <img class="blah" src="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/photo/<?php echo $photo; ?>" alt="your image" /></a> 
    </td>
  </tr>
  <tr >
    <td ><strong>Pan Card Copy</strong></td>
    <td>
	<a data-fancybox="gallery" href="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/pan_copy/<?php echo $pan_copy; ?>">
    <img class="blah" src="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/pan_copy/<?php echo $pan_copy; ?>" alt="your image"/>
    </a> 
    </td>
  </tr>
  <?php if($degn_type == 'Employee') { ?>
  <tr >
    <td ><strong>Salary Slip / Bank Statment</strong></td>
    <td>
    <a data-fancybox="gallery" href="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/salary/<?php echo $salary_slip_copy; ?>">
    <img class="blah" src="https://registration.gjepc.org/employee_directory/<?php echo $registration_id; ?>/salary/<?php echo $salary_slip_copy; ?>" alt="your image"  /></a> 
    </td>
  </tr>
  <?php } else { ?>
  <tr >
    <td ><strong>Partnership Deed</strong></td>
    <td >
    <a data-fancybox="gallery" href="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/partner/<?php echo $partner; ?>">
    <img class="blah" src="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/partner/<?php echo $partner; ?>" alt="your image" />
    </a> 
    </td>
  </tr>
  <?php } ?>
  <tr >
    <td><strong>Application Approval Status</strong></td>
    <td>
    <input type='radio' name='approval' id='approve' value='Y' <?php if($approval=='Y'){ echo "checked='checked'"; }?>/>Approve
	<input type='radio' name='approval' id='disapprove' value='D' <?php if($approval=='D'){ echo "checked='checked'"; }?>/>Disapprove
    </td>
  </tr>
  <tr id="disapproval">
    <td><strong>Disapprove Reason</strong></td>
    <td>
    <textarea name="disapprove_reason" id="disapprove_reason" cols="25"><?php echo $disapprove_reason;?></textarea>
    </td>
  </tr>
  <tr >
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
    <input type="hidden" name="id" id="id"  value="<?php echo $_REQUEST['id'];?>" />
    </td>
  </tr>
</table>
</form> 
</div>
 <?php } ?>     

<!----------------------- Company Edits ---------------------------->

<?php 
  if($_REQUEST['actions']=='companyedit') {
  
  if(($_REQUEST['regid']!='') || ($_REQUEST['actions']=='companyedit'))
  {
  		$actions='compupdate';
		$result3 = mysql_query("SELECT * FROM registration_master where id='$registration_id'");
		if($row3 = mysql_fetch_array($result3))
		{			
			$company_names=stripslashes($row3['company_name']);
			$company_pan_no=stripslashes($row3['company_pan_no']);
			$comp_type=stripslashes($row3['company_type']);
			$company_gstn=stripslashes($row3['company_gstn']);
			$mobile_no=stripslashes($row3['mobile_no']);
			$emailid=stripslashes($row3['email_id']);
			$gst_copy=stripslashes($row3['gst_copy']);
			$pan_no_copy=stripslashes($row3['pan_no_copy']);
			$approval_status=$row3['approval_status'];
			$disapprove=stripslashes($row3['disapprove']);
		}
	}
?>   
<div class="content_details1">
<form name="company" action="" method="post" >        	
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
  <tr class="orange1">
     <td colspan="11" >Company Details</td>
  </tr>
  <tr>
    <td ><strong>Company Name</strong></td>
    <td><input type="text" name="comp_name" id="comp_name" class="input_txt" value="<?php echo $company_names; ?>" /></td>
  </tr>
  <tr>
    <td ><strong>Company Type</strong></td>
	<td><input type="radio" name="comp_type" id="comp_type" value="14" <?php if($comp_type=='propritory' || $comp_type==14){ echo "checked"; }?>>Proprietary
      <input type="radio" name="comp_type" id="comp_type" value="11" <?php if($comp_type=='partnership' || $comp_type==11){ echo "checked"; }?>>Partnership
      <input type="radio" name="comp_type" id="comp_type" value="13" <?php if($comp_type=='pvt' || $comp_type==13){ echo "checked"; }?>>Private Ltd.
      <input type="radio" name="comp_type" id="comp_type" value="12" <?php if($comp_type=='public' || $comp_type==12){ echo "checked"; }?>>Public Ltd.
      <input type="radio" name="comp_type" id="comp_type" value="19" <?php if($comp_type=='llp' || $comp_type==19){ echo "checked"; }?>>LLP
      <input type="radio" name="comp_type" id="comp_type" value="15" <?php if($comp_type=='huf' || $comp_type==15){ echo "checked"; }?>>HUF
      </td>
  </tr>
  <tr>
    <td ><strong>Company PAN No</strong></td>
    <td><input type="text" name="company_pan_no" id="company_pan_no" class="input_txt" value="<?php echo $company_pan_no; ?>" /></td>
  </tr>
  <tr >
    <td ><strong>Company GST</strong></td>
    <td><input type="text" name="company_gstn" id="company_gstn" class="input_txt" value="<?php echo $company_gstn; ?>" /></td>
  </tr>
   <tr >
    <td ><strong>Mobile No</strong></td>
    <td><input type="text" name="mobile_no" id="mobile_no" class="input_txt" value="<?php echo $mobile_no; ?>" /></td>
  </tr>
  <tr >
    <td ><strong>Email ID</strong></td>
    <td><input type="text" name="emailid" id="emailid" class="input_txt" value="<?php echo $emailid; ?>" /></td>
  </tr>
  <tr >
    <td ><strong>GST Photo</strong></td>
    <td>  
    <a data-fancybox="gallery" href="https://registration.gjepc.org/images/gst_copy/<?php echo $gst_copy; ?>"> 
    <img class="blah" src="https://registration.gjepc.org/images/gst_copy/<?php echo $gst_copy; ?>" alt="your image" /></a> 
    </td>
  </tr>
  <tr >
    <td ><strong>Pan Card Copy</strong></td>
    <td>
	<a data-fancybox="gallery" href="https://registration.gjepc.org/images/pan_no_copy/<?php echo $pan_no_copy; ?>">
    <img class="blah" src="https://registration.gjepc.org/images/pan_no_copy/<?php echo $pan_no_copy; ?>" alt="your image"/>
    </a> 
    </td>
  </tr>
  <tr>
    <td><strong>Application Approval Status</strong></td>
    <td>
    <input type='radio' name='approval_status' id='regapprove' value='Y' <?php if($approval_status=='Y'){ echo "checked='checked'"; }?>/>Approve
	<input type='radio' name='approval_status' id='regdisapprove' value='D' <?php if($approval_status=='D'){ echo "checked='checked'"; }?>/>Disapprove
    </td>
  </tr>
  <tr id="reg_disapprove">
    <td><strong>Disapprove Reason</strong></td>
    <td>
    <textarea name="disapprove" id="disapprove" cols="25"><?php echo $disapprove;?></textarea>
    </td>
  </tr>
  <tr >
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="actions" id="actions" value="<?php echo $actions;?>" />
    <input type="hidden" name="regid" id="regid"  value="<?php echo $_REQUEST['regid'];?>" />
    </td>
  </tr>
</table>
</form> 
</div> 
 <?php } ?>
 
</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
/* Company BP Creation */
/* $(".comp").click(function() { 
	
	var values = $(this).data('url');
	var registration_id=values;
		
	if (confirm("Are you sure you want to Create Company BP")) {
		$.ajax({
		url: "create_company_nm_visitor_bp_api.php",
		method:"POST",
		data:{registration_id:registration_id},
		type: "POST",
		beforeSend: function() {
        	$("#overlay").show();
    	},
		success:function(data)
		{
			console.log(data);
			if($.trim(data)==1){
				alert("BP successfully Created..");
				window.location.reload(true);
			}else{
				alert("Sorry There is some problem with SAP response");
				window.location.reload(true);		
			}
			console.log(data);
		},
		});
	}	  
}); */

/* Visitor BP Creation */
/*$(".sap").click(function() {
	
	var values = $(this).data('url').split(" ");
	var visitor_id=values[0];
	var registration_id=values[1];
	
	if (confirm("Are you sure you want to PUSH this record")) {
		$.ajax({
		url: "create_nm_visitor_bp_api.php",
		method:"POST",
		data:{visitor_id:visitor_id,registration_id:registration_id},
		type: "POST",
		beforeSend: function() {
        	$("#overlay").show();
    	},
		success:function(data)
		{ 
			console.log(data);
			if($.trim(data)=='Y'){
				alert("BP Already Created..");
				window.location.reload(true);
			}
			else if($.trim(data)==1){
				alert("BP successfully Created..");
				window.location.reload(true);
			}else{
				alert("Sorry There is some problem with SAP response");
				window.location.reload(true);		
			}
			console.log(data);
		},
		});
	}	  
});
*/
$(".so").click(function() {
	
	var values = $(this).data('url').split(" ");
	var bpno=values[0];
	var registration_id=values[1];
	var order_id=values[2];
	if (confirm("Are you sure you want to create sales order")) {
		$.ajax({
		url: "create_onspot_lost_badges_visitor_so.php",
		method:"POST",
		data:{bpno:bpno,registration_id:registration_id,order_id:order_id},
		type: "POST",
		beforeSend: function() {
        	$("#overlay").show();
    	},
		success:function(data)
		{
			//console.log(data); exit;
			if($.trim(data)=='N'){
				alert("Plz create Employee BP First");
				window.location.reload(true);
			}
			else if($.trim(data)==1){
				alert("Sales Order successfully Created..");
				window.location.reload(true);
			}else{
				alert("Sorry There is some problem with SAP response");
				window.location.reload(true);			
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

<style>
.modal {
    display: none; 
    position: fixed; 
    z-index: 1; 
    padding-top: 100px; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgb(0,0,0); 
    background-color: rgba(0,0,0,0.4);    
}
@keyframes modalFade {
  from {transform: translateY(-50%);opacity: 0;}
  to {transform: translateY(0);opacity: 1;}
}

.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
     animation-name: modalFade;
  animation-duration: .6s;
}
.modal_inner_content{margin: 20px 10px;}

.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
.form-horizontal{border: 1px solid #ccc;padding: 25px;margin-top: 10px;}
.form-control{width: 100%;margin-bottom: 15px;}
.form-control label{width: 150px;display: inline-block;}
.form-control input{width: auto;}
</style>
</body>
</html>