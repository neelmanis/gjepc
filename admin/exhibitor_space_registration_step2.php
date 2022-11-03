<?php session_start(); 
ob_start();?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
$action=$_REQUEST['action'];
$shortcode = $_REQUEST['shortcode'];
if($shortcode =="signature22"){
	$show_value = "IIJS SIGNATURE 2022";

}else if($shortcode =="iijs21"){
	$show_value = "IIJS 2021";
}else{
	$show_value = $shortcode;
}
$showInfo = $conn->query("SELECT * FROM visitor_event_master WHERE `shortcode`='$shortcode'");
$showInfoResult = $showInfo->fetch_assoc();
$show_name = $showInfoResult['event_name'];
if($action=='UPDATE')
{
	$id=filter($_REQUEST['id']);
	$gid=filter($_REQUEST['gid']);
	$uid=filter($_REQUEST['registration_id']);
	
	$wa_jewellery=implode(",",$_POST['wa_jewellery']);
	if(preg_match('/Any Other/',$wa_jewellery))
		$wa_jewellery_other=$_POST['wa_jewellery_other_text'];
	else
		$wa_jewellery_other="";
	
	$wa_machinery=implode(",",$_POST['wa_machinery']);
	if(preg_match('/Any Other/',$wa_machinery))
		$wa_machinery_other=$_POST['wa_machinery_other_text'];
	else
		$wa_machinery_other="";
	
	$we_are=implode(",",$_POST['we_are']);
	if(preg_match('/Any Other/',$we_are))
		$we_are_other=$_POST['we_are_other_text'];
	else
		$we_are_other="";
		
	$comp_desc = filter($_POST["comp_desc"]);
	$comp_descs = addslashes($comp_desc);
	$last_yr_turn_over = floatval($_POST["last_yr_turn_over"]);
	$modified_date=date("Y-m-d");
	
	$update_query = "update exh_reg_company_details set we_are_jewellery='$wa_jewellery', we_are_machinery='$wa_machinery', we_are='$we_are', we_are_jewellery_any_other='$wa_jewellery_other', we_are_machinery_any_other='$wa_machinery_other', we_are_any_other='$we_are_other', comp_desc='$comp_descs', last_yr_turn_over='$last_yr_turn_over', modified_date='$modified_date' where id='$id' and gid='$gid' and uid='$uid' and `show`='$show_value'";
	$update_result = $conn->query($update_query);
	if(!$update_result){
		echo "Error: ".$conn->connect_error();	
	}

$_SESSION['succ_msg']="Company Details updated successfully";
header("Location: exhibitor_space_registration_step3.php?gid=$gid&registration_id=$uid&shortcode=$shortcode");

}
?>

<?php
$gid=filter($_REQUEST['gid']);
$registration_id=filter($_REQUEST['registration_id']);
$sql="select  * from exh_reg_company_details where gid='$gid' and uid='$registration_id' AND  `show` =  '$show_value'";
$result=$conn->query($sql);
$rows=$result->fetch_assoc();
$id = $rows["id"];
$wa_jewellery = $rows["we_are_jewellery"];
$wa_machinery = $rows["we_are_machinery"];
$we_are = $rows["we_are"];
$we_are_jewellery_any_other = $rows["we_are_jewellery_any_other"];
$we_are_machinery_any_other = $rows["we_are_machinery_any_other"];
$we_are_any_other = $rows["we_are_any_other"];
$comp_desc = stripslashes($rows["comp_desc"]);
$last_yr_turn_over = $rows["last_yr_turn_over"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $show_name; ?>  &gt; Exhibitor Registration &gt; Step2</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/formAdmin.css"/>
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
<script type="text/javascript" src="../js/member_directory_pvr.js"></script>
</head>

<body>


<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> Exhibitor Registration</div>
</div>

<div id="main">
	<div class="content">
    
    <div class="content_head"><?php echo $show_name; ?>  > Exhibitor Registration
      <div style="float:right; padding-right:10px; font-size:12px;"><a href="exhibitor_space_rgistration.php?shortcode=<?php echo $shortcode; ?>">Back to Search</a></div>
    </div>
    	
<div class="clear"></div>
<div class="content_details1">
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
if($_SESSION['error_msg1']!=""){
echo "<span class='notification n-attention'>".$_SESSION['error_msg1']."</span>";
}
if($_SESSION['error_msg2']!=""){
echo "<span class='notification n-attention'>".$_SESSION['error_msg2']."</span>";
}
?>
<form name="form1" action="" method="post" > 
<div id="formAdmin">
<div id="formContainer">

<div id="form">
    <ul id="tabs" class="tab_1">
    <li id=""><a href="#"><strong>Step 1 Information</strong></a></li>
    <li id=""><a href="#" class="active"><strong>Step 2 Company Details</strong></a></li>  
    <li id=""><a href="#"><strong>Step 3 Participation Stall Details</strong></a></li>
    <li id=""><a href="#" class="lastBg"><strong>Step 4 Payment Details</strong></a></li>   
    <div class="clear"></div>  
	</ul>

<div class="clear bottomSpace"></div>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt pvr bottomSpace" >
<tr class="orange1">
    <td colspan="11">We Are</td>
</tr>

<tr>
    <td colspan="11" >
    
<div class="field bottomSpace">
<div class="leftTitle" style="padding-top:0px;">Product Dealing In :</div>
<div class="rightContent">
    <ul class="matterText">
    
    <li><input name="wa_jewellery[]" type="checkbox" value="Diamond Jewellery" id="a_1" class="bgcolor" <?php if(preg_match('/Diamond Jewellery/',$wa_jewellery)){ echo ' checked="checked"'; } ?> /><span>Diamond Jewellery</span></li>
    
    <li><input name="wa_jewellery[]" type="checkbox" value="Fine Gold Jewellery" id="a_2" class="bgcolor" <?php if(preg_match('/Fine Gold Jewellery/',$wa_jewellery)){ echo ' checked="checked"'; } ?>/><span> Fine Gold Jewellery</span></li>    
     <li><input name="wa_jewellery[]" type="checkbox" value="Platinum Jewellery" id="a_3" class="bgcolor" <?php if(preg_match('/Platinum Jewellery/',$wa_jewellery)){ echo ' checked="checked"'; } ?>/><span>Platinum Jewellery</span></li>    
     <li><input name="wa_jewellery[]" type="checkbox" value="Precious Stone Jewellery" id="a_4" class="bgcolor" <?php if(preg_match('/Precious Stone Jewellery/',$wa_jewellery)){ echo ' checked="checked"'; } ?> /><span> Precious Stone Jewellery</span></li>  
     <li><input name="wa_jewellery[]" type="checkbox" value="Silver Jewellery" id="a_5" class="bgcolor" <?php if(preg_match('/Silver Jewellery/',$wa_jewellery)){ echo ' checked="checked"'; } ?>/><span>Silver Jewellery</span></li>    
    <li><input name="wa_jewellery[]" type="checkbox" value="Loose Diamonds" id="a_6" class="bgcolor" <?php if(preg_match('/Loose Diamonds/',$wa_jewellery)){ echo ' checked="checked"'; } ?> /><span>Loose Diamonds</span></li>    
    <li><input name="wa_jewellery[]" type="checkbox" value="Loose Colour stones" id="a_7" class="bgcolor" <?php if(preg_match('/Loose Colour stones/',$wa_jewellery)){ echo ' checked="checked"'; } ?> /><span>Loose Colour stones</span></li>
	<li><input name="wa_jewellery[]" type="checkbox" value="Pearls" id="a_8" class="bgcolor" <?php if(preg_match('/Pearls/',$wa_jewellery)){ echo ' checked="checked"'; } ?> /><span>Pearls</span></li>
	<li><input name="wa_jewellery[]" type="checkbox" value="Lab Grown Diamond" id="a_9" class="bgcolor" <?php if(preg_match('/Lab Grown Diamond/',$wa_jewellery)){ echo ' checked="checked"'; } ?> /><span>Lab Grown Diamond</span></li>
	<li><input name="wa_jewellery[]" type="checkbox" value="Coated Diamond" id="a_10" class="bgcolor" <?php if(preg_match('/Coated Diamond/',$wa_jewellery)){ echo ' checked="checked"'; } ?> /><span>Coated Diamond</span></li>
	<li><input name="wa_jewellery[]" type="checkbox" value="CVD" id="a_11" class="bgcolor" <?php if(preg_match('/CVD/',$wa_jewellery)){ echo 'checked="checked"'; } ?> /><span>CVD</span></li>
	<li><input name="wa_jewellery[]" type="checkbox" value="Any Other" id = "wa_jewellery_other" class="bgcolor dropOther" <?php if(preg_match('/Any Other/',$wa_jewellery)){ echo ' checked="checked"'; } ?> /><span>Any Other</span></li>
    </ul>            
       
</div>
<div class="clear" style="margin-bottom:8px;"></div>
 
<div id="wa-jewellery-other-id">
  <label style="min-width:179px;">Any Other, please specify :</label>
  <input name="we_are_jewellery_any_other" type="text" class="textField" value="<?php echo $we_are_jewellery_any_other; ?>" />
</div>
</div>
    
</td>
</tr>
<tr>
<td colspan="11" ><div class="field bottomSpace">
<div class="leftTitle" style="padding-top:0px;">Business Nature :</div>
<div class="rightContent">
    <ul class="matterText">
   <li><input type="checkbox" name="wa_machinery[]" value="Retailer" id="b_1" class="bgcolor" <?php if(preg_match('/Retailer/',$wa_machinery)){ echo 'checked="checked"'; } ?> /> <span>Retailer</span>
	</li>          
	<li><input type="checkbox" name="wa_machinery[]" value="Wholesaler-Retailer" id="b_2" class="bgcolor" <?php if(preg_match('/Wholesaler-Retailer/',$wa_machinery)){ echo ' checked="checked"'; } ?> />
	<span>Wholesaler-Retailer</span>
	</li>
	<li><input type="checkbox" name="wa_machinery[]" value="Importer-Exporter" id="b_2" class="bgcolor" <?php if(preg_match('/Importer-Exporter/',$wa_machinery)){ echo ' checked="checked"'; } ?> />
	<span>Importer-Exporter</span>
	</li>
	<li><input type="checkbox" name="wa_machinery[]" value="Manufacturer" id="b_2" class="bgcolor" <?php if(preg_match('/Manufacturer/',$wa_machinery)){ echo ' checked="checked"'; } ?> />
	<span>Manufacturer</span>
	</li>
	<li>
	<input type="checkbox" name="wa_machinery[]" value="Loose Stones Any Other" id = "wa_machinery_other" class="bgcolor dropOther" <?php if(preg_match('/Loose Stones Any Other/',$wa_machinery)){ echo ' checked="checked"'; } ?> />
	<span>Any Other (Specify)</span>
	</li>          
    </ul>
</div>
<div class="clear" style="margin-bottom:8px;"></div>
<div id="pd-jewellery-other-id">
  <label style="min-width:179px;">Any Other , please specify :</label>
  <input name="we_are_machinery_any_other" type="text" class="textField" value="<?php echo $we_are_machinery_any_other; ?>" />
</div>
</div></td>
</tr>

<tr>
    <td width="25%"><strong>Company's Description </strong></td>
    <td width="75%"><textarea name="comp_desc" id="comp_desc" cols="70" rows="5"><?php echo $comp_desc; ?></textarea></td>
</tr>

<tr >
    <td ><strong>Last year’s turn over in <?php echo $currency;?> <br />(e.g. 10000000) </strong></td>
    <td><input type="text" id="last_yr_turn_over" name = "last_yr_turn_over" class="bgcolor" value="<?php echo $last_yr_turn_over; ?>" /></td>
</tr>	
</table>
</div>
</div>
<div style="padding-left:250px; margin-top:5px;">
<input type="hidden" name="action" id="action" value="UPDATE" />
<input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
<input type="hidden" name="gid" id="gid" value="<?php echo $gid;?>" />
<input type="hidden" name="registration_id" id="registration_id" value="<?php echo $registration_id;?>" />    	
<input type="submit" value="Update" class="input_submit"/>
<a href="exhibitor_space_registration_step1.php?gid=<?php echo $gid;?>&registration_id=<?php echo $registration_id;?>&shortcode=<?php echo $shortcode; ?>">
<div class="button">Previous</div></a>
<a href="exhibitor_space_registration_step3.php?gid=<?php echo $gid;?>&registration_id=<?php echo $registration_id;?>&shortcode=<?php echo $shortcode; ?>">
<div class="button">Next</div></a>

</div>
</div>

</form>      
</div>
   
</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
