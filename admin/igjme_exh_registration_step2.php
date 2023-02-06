<?php
session_start(); 
ob_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
include('../db.inc.php');
include('../functions.php');
$action=$_REQUEST['action'];
$show = "IGJME";

if($action=='UPDATE')
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
		
	$id	 =	intval($_REQUEST['id']);
	$gid =	intval($_REQUEST['id']);
	$uid =  intval($_REQUEST['registration_id']);
	
	$brand_name1 = $_POST["brand_name1"];	
	$brand_name2 = $_POST["brand_name2"];
	$brand_name3 = $_POST["brand_name3"];
	$brand_name4 = $_POST["brand_name4"];
	$brand_name5 = $_POST["brand_name5"];
	$brand_name6 = $_POST["brand_name6"];
	
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
	$last_yr_turn_over = floatval($_POST["last_yr_turn_over"]);
	$modified_date=date("Y-m-d");
	
	if(!empty($uid) && !empty($id)){
	$update_query = "update exh_reg_company_details set we_are_machinery='$wa_machinery', we_are='$we_are', we_are_machinery_any_other='$wa_machinery_other', we_are_any_other='$we_are_other', comp_desc='$comp_desc', last_yr_turn_over='$last_yr_turn_over', brand_name1='$brand_name1',brand_name2='$brand_name2',brand_name3='$brand_name3',brand_name4='$brand_name4',brand_name5='$brand_name5',brand_name6='$brand_name6',modified_date='$modified_date' where id='$id' and gid='$gid' and uid='$uid' and `show`='$show'";	
	$update_result = $conn->query($update_query);
	if(!$update_result){
		echo "Error: ".mysql_error($conn);	
	}
	$_SESSION['succ_msg']="Company Details updated successfully";
	header("Location: igjme_exh_registration_step3.php?gid=$gid&registration_id=$uid");
	} else { $_SESSION['error_msg']="Something Missing"; }
	} else { 
	$_SESSION['error_msg']="Invalid Token Error";
	}
}
?>

<?php
$gid =	filter($_REQUEST['gid']);
$registration_id	=	filter($_REQUEST['registration_id']);
$sql="select  * from exh_reg_company_details where gid='$gid' and uid='$registration_id' AND `show` = '$show'";
$result=$conn->query($sql);
$rows=$result->fetch_assoc();
$id = $rows["id"];
$wa_jewellery = $rows["we_are_jewellery"];
$wa_machinery = $rows["we_are_machinery"];
$we_are = $rows["we_are"];
$we_are_jewellery_any_other = $rows["we_are_jewellery_any_other"];
$we_are_machinery_any_other = $rows["we_are_machinery_any_other"];
$we_are_any_other = $rows["we_are_any_other"];

$brand_name1 = $rows["brand_name1"];
$brand_name2 = $rows["brand_name2"];
$brand_name3 = $rows["brand_name3"];
$brand_name4 = $rows["brand_name4"];
$brand_name5 = $rows["brand_name5"];
$brand_name6 = $rows["brand_name6"];
$product_on_display = $rows["product_on_display"];
$comp_desc = stripslashes($rows["comp_desc"]);
$last_yr_turn_over = $rows["last_yr_turn_over"];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IGJME &gt; Exhibitor Registration &gt; Step-2</title>
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
    <div class="content_head">IGJME > Exhibitor Registration
      <div style="float:right; padding-right:10px; font-size:12px;"><a href="igjme_exhibitor_rgistration.php">Back to Search</a></div>
    </div>
    	
<div class="clear"></div>
<div class="content_details1">
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
if($_SESSION['error_msg']!=""){
echo "<span class='notification n-attention'>".$_SESSION['error_msg']."</span>";
}
if($_SESSION['error_msg2']!=""){
echo "<span class='notification n-attention'>".$_SESSION['error_msg2']."</span>";
}
?>
<form name="form1" action="" method="POST"> 
<?php token(); ?>
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
<div class="leftTitle" style="padding-top:0px;">Machinery :</div>
<div class="rightContent">
    <ul class="matterText">
    
    <li>
	<input type="checkbox" name="wa_machinery[]" value="Machinery Importers" id="b_1" class="bgcolor" <?php if(preg_match('/Machinery Importers/',$wa_machinery)){ echo ' checked="checked"'; } ?> /> 
    <span>Machinery Importers</span>
    </li>
    
	<li>
    <input type="checkbox" name="wa_machinery[]" value="Machinery Exporters" id="b_2" class="bgcolor" <?php if(preg_match('/Machinery Exporters/',$wa_machinery)){ echo ' checked="checked"'; } ?> />
    <span> Machinery Exporters</span>
    </li>
                
    <li>
    <input type="checkbox" name="wa_machinery[]" value="Machinery Wholesalers" id="b_3" class="bgcolor" <?php if(preg_match('/achinery Wholesalers/',$wa_machinery)){ echo ' checked="checked"'; } ?> />
    <span>Machinery Wholesalers</span>
    </li>
                
    <li>
    <input type="checkbox" name="wa_machinery[]" value="Machinery Distributors" id="b_4" class="bgcolor" <?php if(preg_match('/Machinery Distributors/',$wa_machinery)){ echo ' checked="checked"'; } ?> />
    <span>Machinery Distributors</span>
    </li>
                
     <li>
     <input type="checkbox" name="wa_machinery[]" value="Machinery Agents" id="b_5" class="bgcolor" <?php if(preg_match('/Machinery Agents/',$wa_machinery)){ echo ' checked="checked"'; } ?> />
     <span>Machinery Agents</span>
     </li>
               
     <li>
     <input type="checkbox" name="wa_machinery[]" value="Machinery Students" id="b_6" class="bgcolor" <?php if(preg_match('/Machinery Students/',$wa_machinery)){ echo ' checked="checked"'; } ?> />
     <span> Machinery Students</span>
     </li>
	 
     <li>
     <input type="checkbox" name="wa_machinery[]" value="Machinery Chain Stores" id="b_7" class="bgcolor" <?php if(preg_match('/Machinery Chain Stores/',$wa_machinery)){ echo ' checked="checked"'; } ?> />
     <span>Machinery Chain Stores</span>
     </li>
	 
     <li>
     <input type="checkbox" name="wa_machinery[]" value="Machinery Foreign Representative" id="b_8" class="bgcolor" <?php if(preg_match('/Machinery Foreign Representative/',$wa_machinery)){ echo ' checked="checked"'; } ?> />
     <span>Machinery Foreign Representative</span>
     </li>
            
     <li>
     <input type="checkbox" name="wa_machinery[]" value="Machinery Retailers" id="b_9" class="bgcolor" <?php if(preg_match('/Machinery Retailers/',$wa_machinery)){ echo ' checked="checked"'; } ?> />
     <span>Machinery Retailers</span>
     </li>
            
     <li>
     <input type="checkbox" name="wa_machinery[]" value="Machinery Manufacturers" id="b_10" class="bgcolor" <?php if(preg_match('/Machinery Manufacturers/',$wa_machinery)){ echo ' checked="checked"'; } ?> />
     <span>Machinery Manufacturers</span>
     </li>
 
     <li>
	<input type="checkbox" name="wa_machinery[]" value="Machinery Any Other" id = "wa_machinery_other" class="bgcolor dropOther" <?php if(preg_match('/Machinery Any Other/',$wa_machinery)){ echo ' checked="checked"'; } ?> />
     <span>Any Other (Specify)</span>
     </li>
			
    </ul>            
       
</div>
<div class="clear" style="margin-bottom:8px;"></div>
 
<div id="wa-jewellery-other-id">
  <label style="min-width:179px;">Any Other , please specify :</label>
  <input name="we_are_machinery_any_other" type="text" class="textField" value="<?php echo $we_are_machinery_any_other; ?>" />
</div>
</div>
    
</td>
</tr>
<tr>
<td colspan="11" ><div class="field bottomSpace">
<div class="leftTitle" style="padding-top:0px;">We are :</div>
<div class="rightContent">
    <ul class="matterText">
   <li>
            <input name="we_are[]" type="checkbox" id="c_1" value="Ancillary Suppliers" class="bgcolor" <?php if(preg_match('/Ancillary Suppliers/',$we_are)){ echo ' checked="checked"'; } ?>/>
            <span>Ancillary Suppliers</span>
                </li>
                 <li>
            <input name="we_are[]" type="checkbox" id="c_2" value="Raw Material Suppliers" class="bgcolor" <?php if(preg_match('/Raw Material Suppliers/',$we_are)){ echo ' checked="checked"'; } ?>/>
            <span>Raw Material Suppliers</span>
                </li>
                 <li>
            <input name="we_are[]" type="checkbox" id="c_3" value="Publications" class="bgcolor" <?php if(preg_match('/Publications/',$we_are)){ echo ' checked="checked"'; } ?>/> 
            <span>Publications</span>
                </li>
                
                 <li>
            <input name="we_are[]" type="checkbox" id="c_4" value="Associations" class="bgcolor" <?php if(preg_match('/Associations/',$we_are)){ echo ' checked="checked"'; } ?>/>
            <span>Associations</span>
                </li>
                
                 <li>
            <input name="we_are[]" type="checkbox" id="c_5" value="Service Providers" class="bgcolor" <?php if(preg_match('/Service Providers/',$we_are)){ echo ' checked="checked"'; } ?>/>
            <span>Service Providers</span>
                </li>		
    </ul>
</div>
<div class="clear" style="margin-bottom:8px;"></div>

</div></td>
</tr>

<tr>
    <td width="25%"><strong>Product on Display</strong></td>
    <td width="75%">
	<select name="product_on_display" id="product_on_display" class="textField">
            <option value="">---------- Select ----------</option>
			
            <option value="1" <?php if($product_on_display==1){?> selected="selected" <?php }?>>Diamond Manufacturing Machines</option>
			<option value="2" <?php if($product_on_display==2){?> selected="selected" <?php }?>> Jewellery Manufacturing Machines</option>
			<option value="3" <?php if($product_on_display==3){?> selected="selected" <?php }?>>Tools & Equipment’s </option>
			<option value="4" <?php if($product_on_display==4){?> selected="selected" <?php }?>>Allied Packaging</option>
				  
       </select>
			<span id="product_on_display_error" style="color:red;font-size:11px;"></span> 
	</td>
</tr>

<tr>
    <td width="25%"><strong>Brand Name1:</strong></td>
    <td width="75%">
	<input type="text" class="textField" id="brand_name1" name="brand_name1"  value="<?php echo $brand_name1?>" />
	</td>
</tr>
<tr>
    <td width="25%"><strong>Brand Name2:</strong></td>
    <td width="75%">
	<input type="text" class="textField" id="brand_name2" name="brand_name2"  value="<?php echo $brand_name2?>" />
	</td>
</tr>
<tr>
    <td width="25%"><strong>Brand Name3:</strong></td>
    <td width="75%">
	<input type="text" class="textField" id="brand_name3" name="brand_name3"  value="<?php echo $brand_name3?>" />
	</td>
</tr>
<tr>
    <td width="25%"><strong>Brand Name4:</strong></td>
    <td width="75%">
	<input type="text" class="textField" id="brand_name4" name="brand_name4"  value="<?php echo $brand_name4?>" />
	</td>
</tr>
<tr>
    <td width="25%"><strong>Brand Name5:</strong></td>
    <td width="75%">
	<input type="text" class="textField" id="brand_name5" name="brand_name5"  value="<?php echo $brand_name5?>" />
	</td>
</tr>
<tr>
    <td width="25%"><strong>Brand Name6:</strong></td>
    <td width="75%">
	<input type="text" class="textField" id="brand_name6" name="brand_name6"  value="<?php echo $brand_name6?>" />
	</td>
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
<a href="igjme_exh_registration_step1.php?gid=<?php echo $gid;?>&registration_id=<?php echo $registration_id;?>">
<div class="button">Previous</div></a>
<a href="igjme_exh_registration_step3.php?gid=<?php echo $gid;?>&registration_id=<?php echo $registration_id;?>">
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
