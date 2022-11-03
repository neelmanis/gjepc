<?php include('header_include.php');?>
<?php include('chk_login.php');?>
<?php
if($_REQUEST['Reset']=="Reset")
{
  $action="";
  $_SESSION['member_type']="";
  $_SESSION['delivery_status']="";
  $_SESSION['app_type']="";
  $_SESSION['from_date']="";
  $_SESSION['to_date']="";
  header("Location: kimberley_process_search_applications.php");
}else if($_REQUEST['action']=="search")
{ 
  $action=$_REQUEST['action'];
  
  $_SESSION['member_type']=$_REQUEST['member_type'];
  $_SESSION['app_type']=$_REQUEST['app_type'];
  $_SESSION['from_date']=$_REQUEST['from_date'];
  $_SESSION['to_date']=$_REQUEST['to_date'];
  $_SESSION['delivery_status']=$_REQUEST['delivery_status'];
  
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
<title>About GJEPC | Kimberly Process | Search Applications </title>

<!-- Main css -->
<?php include ('maincss.php') ?>

<!-- Member lightbox Thum -->
<script type="text/javascript">
		$(document).ready(function() {
			$("#example1-1").imgbox();

			$("#example1-2").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			$("#example1-4").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			$("#example1-5").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			$("#example1-6").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			$("#example1-7").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			$("#example1-8").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			$("#example1-9").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			$("#example1-10").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			})
			;$("#example1-11").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			;$("#example1-12").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			;$("#example1-13").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			;$("#example1-14").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});

			//$("#example1-3").imgbox({
//				'speedIn'		: 0,
//				'speedOut'		: 0
//			});
//
//			$("#example2-1, #example2-2").imgbox({
//				'speedIn'		: 0,
//				'speedOut'		: 0,
//				'alignment'		: 'center',
//				'overlayShow'	: true,
//				'allowMultiple'	: false
//			});
		});
	</script>
<script type="text/javascript" src="imgbox/jquery.min.js"></script>
<script type="text/javascript" src="imgbox/jquery.imgbox.pack.js"></script>
<link rel="stylesheet" href="imgbox/imgbox.css" /> 
<!-- Member lightbox Thum -->

<!-- Main css -->
<script src="jsvalidation/jquery.js" type="text/javascript"></script>
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<link rel="stylesheet" type="text/css" media="screen" href="css/cmxform.css" /> 
<script type="text/javascript">
$().ready(function() {
	// validate the comment form when it is submitted
	$("#commentForm").validate();
	// validate signup form on keyup and submit
	$("#form1").validate({
		rules: {  
			newpassword: {
				required: true,
				minlength: 6
			},  
			cnfrmpassword:{
			 required: true,
			 equalTo: "#newpassword"
			}
		},
		messages: {
			newpassword: {
				required: "Please enter your new password",
				minlength: "password should not less than 6 characters"
			},
			cnfrmpassword: {
				required: "Please enter your confirm password",
				equalTo: "Please enter the same password as above"
			} 
	 }
	});
});
</script>
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

</head>

<body>
<!-- main -->
<div class="main">

<!-- Top -->
<?php include ('top.php') ?>
<!-- Top -->

<div class="inner_mainwidth">
<div class="online_business_banner">

<!-- Midle Bg -->
<div class="midletable_img"><img src="images/inner_top_bg_new.png" /></div>
<div class="inner_midle_bg">
<div class="text_heading">Search Applications</div>

<div class="text_bread1"><a href="kimberley_process_search_applications.php">Home</a> > Kimberley Process > Search Applications</div>

<div class="clear"></div>

<!-- Midle -->
<div class="midletext">

<!-- Left Table -->
<div class="righttable_css">

<div class="clear"></div>

<!-- div -->
<form name="search" action="" method="post"> 
<input type="hidden" name="action" value="search" />
<div class="search_app_div">
<div class="search_app_text1">Type:</div>
<div class="search_app_bg">
<select  class="search_app_bg_text" name="member_type" id="member_type">
<option selected="selected" value="">--Select--</option>
<?php 
	   $sql="select * from  kp_lookup_details where LOOKUP_ID='7'";
	   $result=mysql_query($sql);
	   while($rows=mysql_fetch_array($result))
	   {
	   if($rows['LOOKUP_VALUE_ID']==$_SESSION['member_type'])
	   {
	   echo "<option selected='selected' value='$rows[LOOKUP_VALUE_ID]'>$rows[LOOKUP_VALUE_NAME]</option>";
	   }else
	   {
	   echo "<option value='$rows[LOOKUP_VALUE_ID]'>$rows[LOOKUP_VALUE_NAME]</option>";
	   }
	   }
?>	

</select>
</div>
<div class="search_app_text1">(Member / Non-Member)</div>
<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">App Type:</div>
<div class="search_app_bg">
<select  class="search_app_bg_text" name="app_type" id="app_type">
<option selected="selected" value="">--Select--</option>
<?php 
	   $sql="select * from  kp_lookup_details where LOOKUP_ID='9'";
	   $result=mysql_query($sql);
	   while($rows=mysql_fetch_array($result))
	   {
	   if($rows['LOOKUP_VALUE_CODE']==$_SESSION['app_type'])
	   {
	   echo "<option selected='selected' value='$rows[LOOKUP_VALUE_CODE]'>$rows[LOOKUP_VALUE_NAME]</option>";
	   }else
	   {
	   echo "<option value='$rows[LOOKUP_VALUE_CODE]'>$rows[LOOKUP_VALUE_NAME]</option>";
	   }
	   }
	   ?>	

</select>
</div>
<div class="search_app_text1">(Importer / Exporter)</div>
<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">From Date:</div>
<div class="search_app_bg"><input type="text" name="from_date" id="popupDatepicker" value="<?php if($_SESSION['from_date']==""){echo "Form";}else{echo $_SESSION['from_date'];}?>"  class="search_app_bg_text"/></div>
<div class="search_app_bg"><input type="text" name="to_date" id="popupDatepicker1" value="<?php if($_SESSION['to_date']==""){echo "To";}else{echo $_SESSION['to_date'];}?>" class="search_app_bg_text"/></div>
<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">Delivery Status:</div>
<div class="search_app_bg">
<select  class="search_app_bg_text" name="delivery_status" id="delivery_status">
<option selected="selected" value="">--Select--</option>
<option value="Courier" <?php if($_SESSION['delivery_status']=="Courier"){?> selected="selected" <?php }?>>Couriered</option>
<option value="Self" <?php if($_SESSION['delivery_status']=="Self"){?> selected="selected" <?php }?>>Self</option>
<option value="Pending" <?php if($_SESSION['delivery_status']=="Pending"){?> selected="selected" <?php }?>>Pending</option>

</select>
</div>

<div class="clear"> </div>
</div>

<div class="clear"></div>

<div class="search_app_div">
<div class="search_app_text1"></div>
<div style="float:left; margin-bottom:4px;"><input class="input_bg" type="submit" value="Submit" /></div>
<div style="float:left; margin-bottom:4px;"><input class="input_bg" type="submit" value="Reset" name="Reset" id="Reset" /></div>
<?php if($_SESSION['MEMBERTYPE']=="Agent" || $_SESSION['MEMBERTYPE']=="NonMember"){?>
<div style="float:left;  margin-bottom:4px;"><a href="change_password.php"><img src="images/change_password.jpg" /></a></div>
<?php }?>


</div>
<div class="clear"></div>

<div style="height:27px;"></div>

<div class="search_app_div"><a href="addmember.php"><b>Click here</b></a> to create your client list by adding Member / NonMember</div>
<?php 
if(isset($_SESSION['AGENT_ID'])){
$sql_import_pending="select count(EXPORT_APP_ID) as count from kp_export_application_master where AGENT_ID='".$_SESSION['AGENT_ID']."' and FORM_TYPE='I' and payment_made_status='N'";
}
else if(isset($_SESSION['MEMBER_ID'])){
$sql_import_pending="select count(EXPORT_APP_ID) as count from kp_export_application_master where MEMBER_ID='".$_SESSION['MEMBER_ID']."' and FORM_TYPE='I' and payment_made_status='N'";
}
else if($_SESSION['NON_MEMBER_ID']){
$sql_import_pending="select count(EXPORT_APP_ID) as count from kp_export_application_master where NON_MEMBER_ID='".$_SESSION['NON_MEMBER_ID']."' and FORM_TYPE='I' and payment_made_status='N'";
}

$query_import_pending=mysql_query($sql_import_pending);
$result_import_pending=mysql_fetch_array($query_import_pending);
$import_count=$result_import_pending['count'];
?>
<div class="search_app_div">You have <strong><?php echo $import_count;?></strong> Import Apllication Pending Payment 
<?php if($import_count>0){?>
	<a href="payment_cart_i.php">Click Here</a>
<?php }?>
</div>
<?php 
if(isset($_SESSION['AGENT_ID'])){
$sql_export_pending="select count(EXPORT_APP_ID) as count from kp_export_application_master where AGENT_ID='".$_SESSION['AGENT_ID']."' and FORM_TYPE='E' and payment_made_status='N'";
}
else if(isset($_SESSION['MEMBER_ID'])){
$sql_export_pending="select count(EXPORT_APP_ID) as count from kp_export_application_master where MEMBER_ID='".$_SESSION['MEMBER_ID']."' and FORM_TYPE='E' and payment_made_status='N'";
}
else if($_SESSION['NON_MEMBER_ID']){
$sql_export_pending="select count(EXPORT_APP_ID) as count from kp_export_application_master where NON_MEMBER_ID='".$_SESSION['NON_MEMBER_ID']."' and FORM_TYPE='E' and payment_made_status='N'";
}

$query_export_pending=mysql_query($sql_export_pending);
$result_export_pending=mysql_fetch_array($query_export_pending);
$export_count=$result_export_pending['count'];

?>
<div class="search_app_div">You have <strong><?php echo $export_count;?></strong> Export Apllication Pending Payment 
<?php ;if($export_count>0){?>
<a href="payment_cart_e.php">Click Here</a>
<?php }?>
</div>


<!-- div -->
<div class="clear"></div>
</form>
</div>
<!-- Left Table -->
<!-- Right Table -->
<div class="left_table_gjepc">
<img src="images/advertise_here_1.png" />

</div>
<!-- Right Table -->
<div class="clear"></div>

<?php if($_SESSION['member_type'] !=""){?>

<div class="content_details1">
<form name="form1" action="" method="post" > 
<input type="hidden" name="action" value="UPDATE_STATUS" /> 

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="detail_txt">
  <tr class="orange1"  >
  
    <td width="4%" style="padding:3px;"><strong>Name</strong></td>
    <td width="11%" style="padding:3px;"><strong>Country Of Destination</strong></td>
    <td width="7%" style="padding:3px;"><strong>Invoice Date</strong></td>
    <td width="9%" style="padding:3px;"><strong>Number of Parcels</strong></td>
    <td width="7%" style="padding:3px;"><strong>Carat Weight</strong></td>
    <td width="7%" style="padding:3px;"><strong>Value in USD</strong></td>
    <td width="9%" style="padding:3px;"><strong>Application Date</strong></td>
    <td width="10%" style="padding:3px;"><strong>Application Charge</strong></td>
    <td width="8%" style="padding:3px;"><strong>Payment Type</strong></td>
    <td width="8%" style="padding:3px;"><strong>Pickup Type</strong></td>
    <td width="12%" style="padding:3px;"><strong>Kp Certificate No</strong></td>
    <td width="8%" style="padding:3px;"><strong>Application Status</strong></td>
   
  </tr>
  <?php
  
	$page=1;//Default page
	$limit=20;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	}
	$start=($page-1)*$limit;
  
  
  	
	$sql="SELECT * FROM `kp_export_application_master` WHERE 1 and  `AGENT_ID`='".$_SESSION['AGENT_ID']."'";
	
	if($_SESSION['member_type']!="")
	{
	$sql.=" and MEMBER_TYPE_ID = '".$_SESSION['member_type']."' ";
	}
	
	if($_SESSION['app_type']!="")
	{
	$sql.=" and FORM_TYPE = '".$_SESSION['app_type']."' ";
	}
	
	if($_SESSION['delivery_status']!="")
	{
	$sql.=" and PICKUP_TYPE='".$_SESSION['delivery_status']."' ";
	}

	if($_SESSION['from_date']!=""  && $_SESSION['to_date']!="" && $_SESSION['from_date']!="Form" && $_SESSION['to_date']!="To")
	{
	$sql.=" and EXP_APP_DATE between '".date("Y-m-d",strtotime($_SESSION['from_date']))." 00:00:00' and '".date("Y-m-d",strtotime($_SESSION['to_date']))." 00:00:00'";
	}
	
 	$result=mysql_query($sql);
	$rCount=mysql_num_rows($result);	

	$sql1=$sql." limit $start, $limit"; 
	
	//echo $sql1;
	
	$result1=mysql_query($sql1);
		
  if($rCount>0)
  {	
  while($rows=mysql_fetch_array($result1))
  {
  ?>
  <tr bgcolor="#ededed">
    
    <td  style="padding:3px;" class="kim">
    <a href="search_application_detail.php?ID=<?php echo $rows['EXPORT_APP_ID'];?>">
	<?php 
	if($_SESSION['member_type']=="18")
	{
	echo getMemberName('Member',$rows['MEMBER_ID']);
	}else if($_SESSION['member_type']=="19")
	{
	echo getNonMemberName('NonMember',$rows['NON_MEMBER_ID']);
	}
	?>	
   	</a>
    </td>
    <td  style="padding:3px;"><?php echo getOrginCountryName($rows['COUNTRY_DEST_ID']);?></td>
    <td  style="padding:3px;"><?php if($rows['INVOICE_DATE']!=""){echo date("d-m-Y",strtotime($rows['INVOICE_DATE']));}?></td>
    <td align="left"  style="padding:3px;"><?php echo $rows['NUMBER_OF_PARCELS'];?></td>
    <td  style="padding:3px;"><?php echo $rows['TOTAL_WGHT'];?></td>
    <td valign="middle"  style="padding:3px;"><?php echo $rows['USD_AMOUNT'];?></td>
    <td  style="padding:3px;"><?php if($rows['EXP_APP_DATE']!=""){echo date("d-m-Y",strtotime($rows['EXP_APP_DATE']));}?></td>
    <td  style="padding:3px;"><?php echo $rows['FEES_AMOUNT'];?></td>
    <td  style="padding:3px;"><?php echo $rows['PAYMENT_MODE'];?></td>
    <td  style="padding:3px;"><?php echo $rows['PICKUP_TYPE'];?></td>
    <td  style="padding:3px;"><?php echo $rows['KP_CERT_NO'];?></td>
      
    <td valign="middle"  style="padding:3px;">
	<?php 
	if($rows['ORDER_STATUS']=="")
	{
	echo "Pending";
	}else
	{
	echo $rows['ORDER_STATUS'];
	}
	?>    </td>
   
  </tr>
  
  <?php
   $i++;
   }
   ?>
   <!--<tr>
    <td colspan="11"><input type="submit" name="Change Location" value="Change Location"  class="input_submit" /></td>
   </tr>-->
   <?php 

}
   else
   {
   ?>
   <tr>
     <td colspan="9">Records Not Found</td>
   </tr>
   <tr>
     <td colspan="6">&nbsp;</td>
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
<div class="pages_1">Total number of Application: <?php echo $rCount;?><?php echo pagination($limit,$page,'kimberley_process_search_applications.php?action=view&page=',$rCount); //call function to show pagination?></div>        

<?php } ?> 




<div class="clear"></div>
</div>
<!-- Midle -->

<div class="clear"></div>

</div>
<div class="midletable_img"><img src="images/inner_bottom_bg_new.png" /></div>
<!-- Midle Bg -->
<div class="innerbg_bottom"></div>
<div class="clear"></div>
</div>

<div class="clear"></div>




<!-- Fotter -->
<?php include ('fotter.php') ?>
<!-- Fotter -->
<div class="clear"></div>

</div>

</div>
<!-- main -->

</body>
</html>
