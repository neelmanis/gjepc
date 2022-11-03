<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
 $trade_show="IIJS 2016";
if($_REQUEST['Reset']=="Reset")
{
	$_SESSION['first_name']="";
	$_SESSION['last_name']="";
	$_SESSION['company_name']="";
	$_SESSION['email']="";
	$_SESSION['from_date']="";
  	$_SESSION['to_date']="";
  	$_SESSION['country']="";
  	$_SESSION['status']="";
  
  header("Location: iijs_ivr.php");
  
}else
{ 
  	$search_type=$_REQUEST['search_type'];
  	if($search_type=="SEARCH")
	{ 
	  $_SESSION['first_name']=$_REQUEST['first_name'];
	  $_SESSION['last_name']=$_REQUEST['last_name'];
	  $_SESSION['company_name']=$_REQUEST['company_name'];
	  $_SESSION['email']=$_REQUEST['email'];
	  $_SESSION['from_date']=$_REQUEST['from_date'];
	  $_SESSION['to_date']=$_REQUEST['to_date'];
	  $_SESSION['country']=$_REQUEST['country'];
	  $_SESSION['status']=$_REQUEST['status'];
	}
if($search_type=='SEARCH')
{
if($_SESSION['first_name']=="" && $_SESSION['company_name']=="" && $_SESSION['from_date']=="Form" && $_SESSION['to_date']=="To" && $_SESSION['country']=="" && $_SESSION['status']=="")
{
$_SESSION['error_msg']="Please fill atleast one field to search";
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
<title>IIJS International Visitor Registration</title>

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
	<div class="breadcome"><a href="admin.php">Home</a> >IIJS IVR</div>
</div>

<div id="main">
	<div class="content">
    
    	<div class="content_head"><a href="iijs_ivr.php"><div class="content_head_button">Manage IIJS IVR</div></a>  <a href="iijs_ivr_old_registration.php"><div class="content_head_button">IIJS IVR Old Registration</div> </a><div style="float:right; padding-right:10px; font-size:12px;"><a href="export_approve_iijs_ivr.php">&nbsp;Download Approved Data</a></div><div style="float:right; padding-right:10px; font-size:12px;"><a href="export_disapprove_iijs_ivr.php">&nbsp;Download DisApproved Data</a></div><div style="float:right; padding-right:10px; font-size:12px;"><a href="export_iijs_ivr.php">&nbsp;Download All Data</a></div></div>
<div class="content_details1">
<?php 
	$sql5="SELECT * FROM  `ivr_registration_details` WHERE 1 AND  `trade_show` = '$trade_show'";
	$result5=mysql_query($sql5);
	$total_application=mysql_num_rows($result5);
	
	$total_approve=0;
	$total_pending=0;
	$total_disapprove=0;
	while($rows5=mysql_fetch_array($result5))
	{
		if($rows5['personal_info_approval']=='Y' && $rows5['photo_approval']=='Y' && $rows5['valid_passport_copy_approval']=='Y' && $rows5['visiting_card_approval']=='Y' && $rows5['nri_photo_approval']=='Y')
		{
			$total_approve=$total_approve+1;
		}else if($rows5['personal_info_approval']=='P' || $rows5['photo_approval']=='P' || $rows5['valid_passport_copy_approval']=='P' || $rows5['visiting_card_approval']=='P' || $rows5['nri_photo_approval']=='P')
		{
			$total_pending=$total_pending+1;
		}else if($rows5['personal_info_approval']=='N' || $rows5['photo_approval']=='N' || $rows5['valid_passport_copy_approval']=='N' || $rows5['visiting_card_approval']=='N' || $rows5['nri_photo_approval']=='N')
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
    <td width="19%"><strong>First Name</strong></td>
    <td width="81%"><input type="text" name="first_name" id="first_name" class="input_txt" value="<?php echo $_SESSION['first_name'];?>" /></td>
  </tr>
  <tr>
    <td><strong>Last Name</strong></td>
    <td><input type="text" name="last_name" id="last_name" class="input_txt" value="<?php echo $_SESSION['last_name'];?>" /></td>
  </tr>
  <tr>
    <td><strong>Company Name</strong></td>
    <td><input type="text" name="company_name" id="company_name" class="input_txt" value="<?php echo $_SESSION['company_name'];?>" /></td>
  </tr>
  <tr>
    <td><strong>Email ID</strong></td>
    <td><input type="text" name="email" id="email" class="input_txt" value="<?php echo $_SESSION['email'];?>" /></td>
  </tr>
  <tr >
    <td><strong>Country</strong></td>
    <td><select name="country" id="country" class="input_txt">
      <option value="">Please Select Country Name</option>
      <?php 
	$sql2="select * from country_master where status=1";
	$result2=mysql_query($sql2);
	while($rows2=mysql_fetch_array($result2))
	{
	if($_SESSION['country_code']==$rows2['country_code'])
	{
	echo "<option value='$rows2[country_code]' selected='selected'>$rows2[country_name]</option>";
	}else
	{
	echo "<option value='$rows2[country_code]'>$rows2[country_name]</option>";
	}
	}
	?>
      </select></td>
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
      <option value="Application_Updated" <?php if($_SESSION['status']=='Application_Updated'){echo "selected='selected'";}?>>Application Updated</option>
	  <option value="visa_recomend" <?php if($_SESSION['status']=='visa_recomend'){echo "selected='selected'";}?>>Application For Visa Recomendation</option>
      
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
    <td width="10%" height="30">Name</td>
    <td width="14%">Company Name</td>
    <td width="6%">Email ID</td>
    <td width="10%">Country</td>
    <td width="10%">Registration Date</td>
    <td width="8%">Show</td>
    <td width="7%" align="center">Status</td>
    <td width="7%">Action</td>
  </tr>
  <?php
  
	$page=1;//Default page
	$limit=20;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	
	}
	$start=($page-1)*$limit;
  
  $sql="SELECT * FROM  `ivr_registration_details` WHERE 1 AND  `trade_show` = '$trade_show'";
  
  if($_SESSION['first_name']!="")
  {
  $sql.=" and first_name like '%".$_SESSION['first_name']."%'";
  }
  
  if($_SESSION['last_name']!="")
  {
  $sql.=" and last_name like '%".$_SESSION['last_name']."%'";
  }
  
  if($_SESSION['company_name']!="")
  {
  $sql.=" and company_name like '%".$_SESSION['company_name']."%'";
  }
  
  if($_SESSION['email']!="")
  {
  $sql.=" and email like '%".$_SESSION['email']."%'";
  }
  
  if($_SESSION['from_date']!=""  && $_SESSION['to_date']!="" && $_SESSION['from_date']!="Form" && $_SESSION['to_date']!="To")
  {
    $sql.=" and time_stamp between '".date("Y-m-d",strtotime($_SESSION['from_date']))."' and '".date("Y-m-d",strtotime($_REQUEST['to_date']))."'";
  }
  
  if($_SESSION['country']!="")
  {
  $sql.=" and country='".$_SESSION['country']."'";
  }
  
 
  if($_SESSION['status']!="")
  { 
  	if($_SESSION['status']=='Application_Approved')
	{
  	$sql.=" and personal_info_approval='Y' and photo_approval='Y' and valid_passport_copy_approval='Y' and visiting_card_approval='Y' and nri_photo_approval='Y'";
	}else if($_SESSION['status']=='Application_Disapproved')
	{
	$sql.=" and (personal_info_approval='N' or photo_approval='N' or valid_passport_copy_approval='N' or visiting_card_approval='N' or nri_photo_approval='N') ";
	}else if($_SESSION['status']=='Application_Pending')
	{
	$sql.=" and (personal_info_approval='P' or photo_approval='P' or valid_passport_copy_approval='P' or visiting_card_approval='P' or nri_photo_approval='P') ";
	}else if($_SESSION['status']=='Application_Updated')
	{
	$sql.=" and (personal_info_updated='yes' or photo_updated='yes' or valid_passport_copy_updated='yes' or visiting_card_updated='yes' or nri_photo_updated='yes') and (personal_info_approval='P' or photo_approval='P' or valid_passport_copy_approval='P' or visiting_card_approval='P' or nri_photo_approval='P') ";
	}else if($_SESSION['status']=='visa_recomend')
	{
	$sql.=" and (apply_visa='1') ";
	}
  }	
  
 	$sql.=" order by time_stamp desc"; 
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
    <td><?php echo strtoupper($rows['first_name']) ." ".strtoupper($rows['last_name']);?></td>
    <td><?php echo strtoupper($rows['company_name']);?></td>
    <td><?php echo $rows['email'];?></td>
    <td><?php echo getCountryName($rows['country']);?></td>
    <td><?php echo date("d-m-Y",strtotime($rows['time_stamp']));?></td>
    <td><?php echo $rows['trade_show']?></td>
    <td align="center">
	<?php 
	if($rows['personal_info_approval']=='Y' && $rows['photo_approval']=='Y' && $rows['valid_passport_copy_approval']=='Y' && $rows['visiting_card_approval']=='Y' && $rows['nri_photo_approval']=='Y')
	{
		echo "<img src='images/yes.gif' border='0' />";	
	}else if($rows['personal_info_approval']=='P' || $rows['photo_approval']=='P' || $rows['valid_passport_copy_approval']=='P' || $rows['visiting_card_approval']=='P' || $rows['nri_photo_approval']=='P')
	{
		echo "<img src='images/notification-exclamation.gif' border='0' />";	
	}else
	{
		echo "<img src='images/no.gif' border='0' />";	
	}
	?>
    
    </td>
    <td align="left" valign="middle"><a href="iijs_personal_information_IVR.php?id=<?php echo $rows['eid'];?>&registration_id=<?php echo $rows['uid'];?>"><img src="images/edit1.png" border="0" /></a> </td>
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
  
   <?php  } ?>  
</table>

</form>
</div>  
<?php
function pagination($per_page, $page = 1, $url = '', $total){ 

$adjacents = "2";
$page = ($page == 0 ? 1 : $page); 
$start = ($page - 1) * $per_page; 

$prev = $page - 1; 
$next = $page + 1;
$per_page=10;
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
<div class="pages_1">Total number of Application: <?php echo $rCount;?>
<?php echo pagination(10,$page,'iijs_ivr.php?action=view&page=',$rCount); //call function to show pagination?>
</div>        
      
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
