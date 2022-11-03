<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
 
if($_REQUEST['Reset']=="Reset")
{
  $action="";
  $_SESSION['agent_id']="";
  $_SESSION['member_type']="";
  $_SESSION['status']="";
  $_SESSION['app_type']="";
  $_SESSION['from_date']="";
  $_SESSION['to_date']="";
 
  header("Location: search_application.php?action=view");
}else if($_REQUEST['action']=="search")
{ 
  $action=$_REQUEST['action'];
  $_SESSION['agent_id']=$_REQUEST['agent_id'];
  $_SESSION['member_type']=$_REQUEST['member_type'];
  $_SESSION['status']=$_REQUEST['status'];
  $_SESSION['app_type']=$_REQUEST['app_type'];
  $_SESSION['from_date']=$_REQUEST['from_date'];
  $_SESSION['to_date']=$_REQUEST['to_date'];
 
  if($action=='search')
  {
  	if($_SESSION['agent_id']=="")
	{
	$_SESSION['error_msg']="Please select Agent Name";
	}
	
	if($_SESSION['member_type']=="")
	{
	$_SESSION['error_msg1']="Please select Member Type";
	}
	
  }
}
?>  


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload Application || KP ||</title>

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
</head>

<body>


<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="search_application.php">Home</a> > Upload Application</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><div class="content_head_button">Upload Application</div></div>
    	
      
<div class="content_details1">
<form action="" method="post" enctype="multipart/form-data" name="search" > 
<input type="hidden" name="action" value="search" />        	
<?php 
if($_SESSION['error_msg']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
$_SESSION['error_msg']="";
}
if($_SESSION['error_msg1']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg1']."</span>";
$_SESSION['error_msg1']="";
}

?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11" >Search Options</td>
</tr>
      
<tr >
    <td width="19%" ><strong>Type</strong></td>
    <td width="81%"><select name="location_id" id="location_id" class="input_txt">
      <option value="">Please Select Type</option>
      <option value="Transaction Main">Transaction Main</option>
      <option value="Speaker Order Detail">Speaker Order Detail</option>
      <option value="Agent Master">Agent Master</option>
      <option value="Address Detail">Address Detail</option>
      <option value="Update Approve Application">Update Approve Application</option>
     </select></td>
</tr>
<tr >
  <td><strong>Browse File</strong></td>
  <td><label>
    <input type="file" name="fileField" id="fileField" />
  </label></td>
</tr>
<tr >
    <td>&nbsp;</td>
    <td><input type="submit" name="Upload" value="Upload"  class="input_submit" /> <input type="submit" name="Close" value="Close"  class="input_submit" /></td>
</tr>	
</table>
</form>      
</div>
<?php if($_SESSION['agent_id']!="" && $_SESSION['member_type'] !=""){?>

<div class="content_details1">
<form name="form1" action="" method="post" > 
<input type="hidden" name="action" value="UPDATE_STATUS" /> 

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td>Type</td>
    <td>Agent Names</td>
    <td>Application Date</td>
    <td>Member Name</td>
    <td>Payment Type</td>
    <td>Payment Status</td>
    <td>Amount</td>
    <td>Status</td>
    <td>Location</td>
    <td>Select</td>
  </tr>
  <?php
  
	$page=1;//Default page
	$limit=20;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	}
	$start=($page-1)*$limit;
  
  
  	
	$sql="SELECT * FROM `kp_export_application_master` WHERE 1 ";
	
	if($_SESSION['agent_id']!="")
	{
	$sql.=" and `AGENT_ID`='".$_SESSION['agent_id']."'";
	}
	
	if($_SESSION['member_type']!="")
	{
	$sql.=" and MEMBER_TYPE_ID = '".$_SESSION['member_type']."' ";
	}
	
	if($_SESSION['app_type']!="")
	{
	$sql.=" and FORM_TYPE = '".$_SESSION['app_type']."' ";
	}
	
	/*if($_SESSION['status']!="")
	{
	$sql.=" and STATUS='".$_SESSION['status']."' ";
	}*/

	if($_SESSION['from_date']!=""  && $_SESSION['to_date']!="" && $_SESSION['from_date']!="Form" && $_SESSION['to_date']!="To")
	{
	$sql.=" and EXP_APP_DATE between '".date("Y-m-d",strtotime($_SESSION['from_date']))."' and '".date("Y-m-d",strtotime($_SESSION['to_date']))."'";
	}

 	$result=mysql_query($sql);
	$rCount=mysql_num_rows($result);	

	$sql1=$sql." limit $start, $limit"; 
	$result1=mysql_query($sql1);
		
  if($rCount>0)
  {	
  while($rows=mysql_fetch_array($result1))
  {
  ?>
  <tr	>
    <td>
	<?php 
	if($rows['FORM_TYPE']=='I')
	{
	echo "Import";
	}else
	{
	echo "Export";
	}
	?></td>
    <td><?php echo getAgentName($rows['AGENT_ID']);?></td>
    <td><?php if($rows['EXP_APP_DATE']!=""){echo date("d-m-Y",strtotime($rows['EXP_APP_DATE']));}?></td>
    <td>
   <?php 
	if($_SESSION['member_type']=="18")
	{
	echo getMemberName($rows['MEMBER_ID']);
	}else if($_SESSION['member_type']=="19")
	{
	echo getNonMemberName($rows['NON_MEMBER_ID']);
	}
	?>
   
	</td>
    <td><?php echo $rows['PAYMENT_MODE'];?></td>
    <td valign="middle">
	<?php 
	if($rows['PAYMENT_SENT']=="")
	{
	echo "PENDING";
	}else if($rows['PAYMENT_SENT']=="Y")
	{
	echo "ACCEPT";
	} 
	?>
    </td>
    <td><?php echo $rows['FEES_AMOUNT'];?></td>
    <td valign="middle">
	<?php 
	if($rows['ORDER_STATUS']=="")
	{
	echo "Pending";
	}
	?>
    </td>
    <td>
   <select name="LOC_PICKUP_ID">
   <?php 
   ?>
    <option value="1" <?php if($rows['LOC_PICKUP_ID']==1){ echo "selected=selected";}?>>Mumbai - GJEPC</option>
    <option value="15" <?php if($rows['LOC_PICKUP_ID']==15){ echo "selected=selected";}?>>Surat - G</option>
    <option value="91" <?php if($rows['LOC_PICKUP_ID']==91){ echo "selected=selected";}?>>Mumbai - Seepz</option>
    <option value="93" <?php if($rows['LOC_PICKUP_ID']==93){ echo "selected=selected";}?>>Surat - Seepz</option>
    <option value="92" <?php if($rows['LOC_PICKUP_ID']==92){ echo "selected=selected";}?>>Vishakapatnam</option>
    </select>
    
    </td>
    <td><input name="" type="checkbox" value="" /></td>

  </tr>
  
  <?php
   $i++;
   }
   ?>
   <tr>
    <td colspan="10"><input type="submit" name="Change Location" value="Change Location"  class="input_submit" /></td>
    </tr>
   <?php 

}
   else
   {
   ?>
   <tr>
     <td colspan="8">Records Not Found</td>
   </tr>
   <tr>
     <td colspan="5">&nbsp;</td>
     <td colspan="3"></td>
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
<div class="pages_1">Total number of Memberships: <?php echo $rCount;?><?php echo pagination($limit,$page,'search_application.php?action=view&page=',$rCount); //call function to show pagination?></div>        

<?php } ?>      
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
