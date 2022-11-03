<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
 
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['category_type']="";
  $_SESSION['keyword']="";
  $_SESSION['from_date']="";
  $_SESSION['to_date']="";
  $_SESSION['payment_mode']="";
  $_SESSION['payment_status']="";
  $_SESSION['status']="";
  
  header("Location: iijs_pvr.php");
  
}else
{ 
  	$search_type=$_REQUEST['search_type'];
  	if($search_type=="SEARCH")
	{ 
	  $_SESSION['category_type']=$_REQUEST['category_type'];
	  $_SESSION['keyword']=$_REQUEST['keyword'];
	  $_SESSION['from_date']=$_REQUEST['from_date'];
	  $_SESSION['to_date']=$_REQUEST['to_date'];
	  $_SESSION['payment_mode']=$_REQUEST['payment_mode'];
	  $_SESSION['payment_status']=$_REQUEST['payment_status'];
	  $_SESSION['status']=$_REQUEST['status'];
	}
if($search_type=='SEARCH')
{
if($_SESSION['category_type']=="" && $_SESSION['keyword']=="" && $_SESSION['from_date']=="Form" && $_SESSION['to_date']=="To" && $_SESSION['payment_mode']=="" && $_SESSION['status']=="")
{
$_SESSION['error_msg']="Please select atleast one field to search";
}else if($_SESSION['category_type']=="" && $_SESSION['keyword']!="")
{
$_SESSION['error_msg']="Please select category for the keyword entered below";
}else if($_SESSION['category_type']!="" && $_SESSION['keyword']=="")
{
$_SESSION['error_msg']="Please enter keyword for above category";
}else if($_SESSION['from_date']=="Form" && $_SESSION['to_date'] !="To")
{
$_SESSION['error_msg']="Please enter form date";
}else if($_SESSION['from_date']!="Form" && $_SESSION['to_date']=="To")
{
$_SESSION['error_msg']="Please enter to date";
}

}
}
?>  

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IIJS 2015 Privilege Visitor Registration</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />





<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>      
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	$('#popupDatepicker').datepick();
	$('#inlineDatepicker').datepick({onSelect: showDate});
	$('#popupDatepicker1').datepick();
	$('#inlineDatepicker1').datepick({onSelect: showDate});
});
function showDate(date) {
	alert('The date chosen is ' + date);}
</script>

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
<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen" />
	
	<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="js/jquery.fancybox-1.2.1.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("div.fancyDemo a").fancybox();
		});
	</script>
<!-- lightbox Thum -->

<style type="text/css">
<!--
.style1 {color: #FF0000}
.style2 {
	font-size: 16px;
	font-weight: bold;
}

-->
</style>
</head>

<body>


<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > IIJS PVR</div>
</div>

<div id="main">
	<div class="content">
    
    	<div class="content_head">IIJS 2016 Privilege Visitor Registration<div style="float:right; padding-right:10px; font-size:12px;"><a href="iijs_export_approve_pvr.php">&nbsp;Download Approved Data</a></div><div style="float:right; padding-right:10px; font-size:12px;"><a href="iijs_export_disapprove_pvr.php">&nbsp;Download DisApproved Data</a></div><div style="float:right; padding-right:10px; font-size:12px;"><a href="iijs_export_pvr.php">&nbsp;Download All Data</a></div></div>
    	
<div class="content_details1">
<?php 
	$sql5="SELECT * FROM  `pvr_registration_details` WHERE 1 AND  `participate_for_show` = 'IIJS' and participation_year='2016' and (application_status='1' || payment_mode=3)";
	$result5=mysql_query($sql5);
	$total_application=mysql_num_rows($result5);
	
	$total_approve=0;
	$total_pending=0;
	$total_disapprove=0;
	while($rows5=mysql_fetch_array($result5))
	{
		if($rows5['information_approve']=='Y' && $rows5['payment_approve']=='Y' && $rows5['photo_approval']=='Y')
		{
			$total_approve=$total_approve+1;
		}else if($rows5['information_approve']=='P' && $rows5['payment_approve']=='P' && $rows5['photo_approval']=='P')
		{
			$total_pending=$total_pending+1;
		}else if($rows5['information_approve']=='N' || $rows5['payment_approve']=='N' || $rows5['photo_approval']=='N')
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
<div class="clear"></div>
<div class="content_details1">
<form name="search" action="" method="post" > 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />        	
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
  <tr class="orange1">
    <td colspan="11" >Search Options</td>
  </tr>
  <tr>
    <td width="19%"><strong>Select Category</strong></td>
    <td width="81%"><select name="category_type" id="category_type" class="input_txt">
      <option value="">Please Select Category</option>
      <option value="company_name" <?php if($_SESSION['category_type']=="company_name"){echo "selected='selected'";}?>>Company Name</option>
      <option value="email" <?php if($_SESSION['category_type']=="email"){echo "selected='selected'";}?>>Email ID</option>
      <option value="first_name" <?php if($_SESSION['category_type']=="first_name"){echo "selected='selected'";}?>>Name</option>
      <option value="privilege_code" <?php if($_SESSION['category_type']=="privilege_code"){echo "selected='selected'";}?>>Privilege Code</option>
    </select></td>
  </tr>
  <tr >
    <td ><strong>Enter Keywords</strong></td>
    <td><input type="text" name="keyword" id="keyword" class="input_txt" value="<?php echo $_SESSION['keyword'];?>" /></td>
  </tr>
  <tr >
    <td><strong>Payment Mode</strong></td>
    <td><select name="payment_mode" id="payment_mode" class="input_txt">
      	<option value="">Please Select Payment Mode</option>
      	<option value="Cheque or DD" <?php if($_SESSION['payment_mode']=='Cheque or DD'){echo "selected='selected'";}?>>Cheque or DD</option>
		<!--<option value="Debit or Credit Card" <?php if($_SESSION['payment_mode']=='Debit or Credit Card'){echo "selected='selected'";}?>>Debit or Credit Card</option>-->
		<option value="1" <?php if($_SESSION['payment_mode']=='1'){echo "selected='selected'";}?>>Debit or Credit Card</option>
		<option value="3" <?php if($_SESSION['payment_mode']=='3'){echo "selected='selected'";}?>>Net Banking Transaction</option>
        <option value="Cash" <?php if($_SESSION['payment_mode']=='Cash'){echo "selected='selected'";}?>>Cash</option>      
    	</select>
	</td>
  </tr>
  <tr >
    <td><strong>Date</strong></td>
    <td><input type="text" name="from_date" id="popupDatepicker" value="<?php if($_SESSION['from_date']==""){echo "Form";}else{echo $_SESSION['from_date'];}?>"  class="input_date"/>
      <input type="text" name="to_date" id="popupDatepicker1" value="<?php if($_SESSION['to_date']==""){echo "To";}else{echo $_SESSION['to_date'];}?>" class="input_date"/></td>
  </tr>
  <tr >
    <td><strong>Status</strong></td>
    <td><select name="status" class="input_txt-select" >
      <option value="">Select Status</option>
      <option value="Application_Approved" <?php if($_SESSION['status']=='Application_Approved'){echo "selected='selected'";}?>>Application Approved</option>
      <option value="Application_Disapproved" <?php if($_SESSION['status']=='Application_Disapproved'){echo "selected='selected'";}?>>Application Disapproved</option>
      <option value="Application_Pending" <?php if($_SESSION['status']=='Application_Pending'){echo "selected='selected'";}?>>Application Pending</option>
    </select></td>
  </tr>
  <tr>
    <td><strong>Payment Status</strong></td>
    <td><select name="payment_status" class="input_txt-select" >
      <option value="">Select Status</option>
	  <option value="Y" <?php if($_SESSION['payment_status']=='Y'){echo "selected='selected'";}?>>Payment Approved</option>
	  <option value="P" <?php if($_SESSION['payment_status']=='P'){echo "selected='selected'";}?>>Payment Pending</option>      
    </select></td>
  </tr>
  <tr >
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Search"  class="input_submit" />
      <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
  </tr>
</table>
</form>      
</div>

<div class="content_details1">
<form name="form1" action="" method="post" > 
<input type="hidden" name="action_update" value="UPDATE_STATUS" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td height="30">Company Name</td>
    <td>Privilege Code</td>
    <td>Contact Name</td>
    <td>Email ID</td>
    <td>Registration Date</td>
    <td>Payment Mode</td>
    <td>Transaction ID</td>
    <td>Transaction Status</td>
	<td>Order No</td>
    <td align="center">Status</td>
    <td>Action</td>
  </tr>
  <?php
  
	$page=1;//Default page
	$limit=25;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	
	}
	$start=($page-1)*$limit;
  
  $sql="SELECT * FROM `pvr_registration_details` WHERE `participate_for_show`='IIJS' and `participation_year`='2016'  and (application_status='1' || payment_mode=3)";
  
  if($_SESSION['category_type']!="" && $_SESSION['keyword']!="")
  {
  $sql.=" and ".$_SESSION['category_type']." like '%".$_SESSION['keyword']."%' ";
  }
  
  if($_SESSION['from_date']!=""  && $_SESSION['to_date']!="" && $_SESSION['from_date']!="Form" && $_SESSION['to_date']!="To")
  {
    $sql.=" and created_dt between '".date("Y-m-d",strtotime($_SESSION['from_date']))."' and '".date("Y-m-d",strtotime($_REQUEST['to_date']))."'";
  }
  
  if($_SESSION['payment_mode']!="")
  {
  $sql.=" and payment_mode='".$_SESSION['payment_mode']."'";
  }
  
 
  if($_SESSION['status']!="")
  { 
  	if($_SESSION['status']=='Application_Approved')
	{
  	$sql.=" and information_approve='Y' and payment_approve='Y' and photo_approval='Y' and identy_proof_approval='Y' ";
	}else if($_SESSION['status']=='Application_Disapproved')
	{
	$sql.=" and (information_approve='N' or payment_approve='N' or photo_approval='N' or identy_proof_approval='N') ";
	}else if($_SESSION['status']=='Application_Pending')
	{
	$sql.=" and (information_approve='P' or payment_approve='P' or photo_approval='P' or identy_proof_approval='P' )";
	}
  }	
  
	if($_SESSION['payment_status']!="")
	{
	$sql.=" and payment_approve='".$_SESSION['payment_status']."'";
	}
  
 	$sql.=" group by uid order by created_dt desc"; 
	
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
  <tr >
    <td><?php echo strtoupper($rows['company_name']);?></td>
    <td><?php echo $rows['privilege_code'];?></td>
    <td><?php echo strtoupper($rows['contact_person']);?></td>
    <td><?php echo strtolower($rows['email']);?></td>
    
    <td><?php echo date("d-m-Y",strtotime($rows['created_dt']));?></td>
    <td>
	<?php $payment_mode=$rows['payment_mode'];
	if($payment_mode=='Cheque or DD') echo 'Cheque or DD';
	if($payment_mode=='Cash') echo 'Cash';
	if($payment_mode=='1') echo 'Debit or Credit Card';
	if($payment_mode=='3') echo 'Net Banking';
	?>
	
	</td>
    <td><?php echo $rows['transaction_id']?></td>
    <td><?php echo $rows['transaction_details']?></td>
	<td><?php echo $rows['order_no']?></td>
    
    <td align="center"><?php 
	if($rows['information_approve']=='Y' && $rows['payment_approve']=='Y' && $rows['photo_approval']=='Y' && $rows['identy_proof_approval']=='Y')
	{
		echo "<img src='images/yes.gif' border='0' />    <a href='http://iijs.org/print_acknowledge/pvr_ack_admin.php?uid=$rows[uid]' target='_blank'>Print</a>";	
	}else if($rows['information_approve']=='N' || $rows['payment_approve']=='N' ||  $rows['photo_approval']=='N' ||  $rows['identy_proof_approval']=='N')
	{
		echo "<img src='images/no.gif' border='0' />";
	}else 
	{
		echo "<img src='images/notification-exclamation.gif' border='0' />";	
	}
	?></td>
    <td align="left" valign="middle"><a href="iijs_information_pvr.php?id=<?php echo $rows['id'];?>&amp;registration_id=<?php echo $rows['uid'];?>"><img src="images/edit1.png" border="0" /></a></td>
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
</form>
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
<div class="pages_1">Total number of Memberships: <?php echo $rCount;?>
<?php echo pagination($limit,$page,'iijs_pvr.php?action=view&page=',$rCount); //call function to show pagination?>
</div>        
      
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
