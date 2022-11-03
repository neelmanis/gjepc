<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
$action=$_REQUEST['action'];
if($action=='UPDATE')
{
	$id=mysql_real_escape_string($_REQUEST['id']);
	$registration_id=mysql_real_escape_string($_REQUEST['registration_id']);
	$wa_jewellery=implode(",",$_POST['wa_jewellery']);
	if(preg_match('/Any Other/',$wa_jewellery))
		$wa_other=$_POST['wa_other'];
	else
		$wa_other="";
		
	$pd_jewellery=implode(",",$_POST['pd_jewellery']);
	if(preg_match('/Any Other/',$pd_jewellery))
		$pd_other=$_POST['pd_other'];
	else
		$pd_other="";

	$item_interest=implode(",",$_POST['item_interest']);
	if(preg_match('/Any Other/',$item_interest))
		$item_interest_other=$_POST['item_interest_other'];
	else
		$item_interest_other="";

	if(preg_match('/Loose Diamonds/',$item_interest))
	{
		$d_size=implode(",",$_POST['d_size']);
		$d_clarity=implode(",",$_POST['d_clarity']);
		$d_color_shade=implode(",",$_POST['d_color_shade']);
		$d_pp_from=$_POST['d_pp_from'];
		$d_pp_to=$_POST['d_pp_to'];
	}
	else
	{
		$d_size="";
		$d_clarity="";
		$d_color_shade="";
		$d_pp_from="";
		$d_pp_to="";
	}
	
	if(preg_match('/Coloured Gemstones/',$item_interest))
	{
		$cgs_stone=mysql_real_escape_string($_POST['cgs_stone']);
		$cgs_shade=mysql_real_escape_string($_POST['cgs_shade']);
		$cgs_size_from=mysql_real_escape_string($_POST['cgs_size_from']);
		$cgs_size_to=mysql_real_escape_string($_POST['cgs_size_to']);
		$cgs_shape=mysql_real_escape_string($_POST['cgs_shape']);
		$cgs_quantity=mysql_real_escape_string($_POST['cgs_quantity']);
		$cgs_pp_from=mysql_real_escape_string($_POST['cgs_pp_from']);
		$cgs_pp_to=mysql_real_escape_string($_POST['cgs_pp_to']);
	}
	else
	{
		$cgs_stone="";
		$cgs_shade="";
		$cgs_size_from="";
		$cgs_size_to="";
		$cgs_shape="";
		$cgs_quantity="";
		$cgs_pp_from="";
		$cgs_pp_to="";
	}
	
	$objective=implode(",",$_POST['objective']);
	if(preg_match('/Any Other/',$objective))
		$objective_other=$_POST['objective_other'];
	else
		$objective_other="";
	
	$updatequery="update pvr_registration_details set wa_jewellery='".$wa_jewellery."',wa_other='".$wa_other."',pd_jewellery='".$pd_jewellery."',pd_other='".$pd_other."',item_interest='".$item_interest."',item_interest_other='".$item_interest_other."',d_size='".$d_size."',d_clarity='".$d_clarity."',d_color_shade='".$d_color_shade."',d_pp_from='".$d_pp_from."',d_pp_to='".$d_pp_to."',cgs_stone='".$cgs_stone."',cgs_shade='".$cgs_shade."',cgs_size_from='".$cgs_size_from."',cgs_size_to='".$cgs_size_to."',cgs_shape='".$cgs_shape."',cgs_quantity='".$cgs_quantity."',cgs_pp_from='".$cgs_pp_from."',cgs_pp_to='".$cgs_pp_to."',objective='".$objective."',objective_other='".$objective_other."',modified_dt=NOW() where id='$id' and uid='$registration_id'"; 

	$update_result = mysql_query($updatequery);

	if(!$update_result){
		echo "Error: ".mysql_error();	
	}

$_SESSION['succ_msg']="OBMP Profile updated successfully";
header("Location:iijs_participation_&_payment_details_pvr.php?id=$id&registration_id=$registration_id");

}


?>

<?php
$id=mysql_real_escape_string($_REQUEST['id']);
$registration_id=mysql_real_escape_string($_REQUEST['registration_id']);
	$sql="SELECT * FROM `pvr_registration_details` WHERE 1 and id='$id' and uid='$registration_id'";
	$result=mysql_query($sql);
	$rows=mysql_fetch_array($result);
	
	$wa_jewellery=$rows['wa_jewellery'];
	$wa_other=$rows['wa_other'];
	$pd_jewellery=$rows['pd_jewellery'];
	$pd_other=$rows['pd_other'];
	$item_interest=$rows['item_interest'];
	$item_interest_other=$rows['item_interest_other'];
	$d_size=$rows['d_size'];
	$d_clarity=$rows['d_clarity'];
	$d_color_shade=$rows['d_color_shade'];
	$d_pp_from=$rows['d_pp_from'];
	$d_pp_to=$rows['d_pp_to'];
	$cgs_stone=$rows['cgs_stone'];
	$cgs_shade=$rows['cgs_shade'];
	$cgs_size_from=$rows['cgs_size_from'];
	$cgs_size_to=$rows['cgs_size_to'];
	$cgs_shape=$rows['cgs_shape'];
	$cgs_quantity=$rows['cgs_quantity'];
	$cgs_pp_from=$rows['cgs_pp_from'];
	$cgs_pp_to=$rows['cgs_pp_to'];
	$objective=$rows['objective'];
	$objective_other=$rows['objective_other'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IIJS &gt; PVR &gt;&gt; OBMP Profile</title>

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
	<div class="breadcome"><a href="admin.php">Home</a> > PVR > OBMP Profile</div>
</div>

<div id="main">
	<div class="content">
    
    <div class="content_head">IIJS &gt; PVR >&gt; OBMP Profile
      <div style="float:right; padding-right:10px; font-size:12px;"><a href="iijs_pvr.php">Back to Search</a></div>
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
    <li id=""><a href="#" class="active"><strong>Step 2 OBMP Info</strong></a></li>  
    <li id=""><a href="#"><strong>Step 3 Payment</strong></a></li>
    <li id=""><a href="#" class="lastBg"><strong>Step 4 Photo</strong></a></li>   
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
<div class="leftTitle" style="padding-top:0px;">Jewellery :</div>
<div class="rightContent">
    <ul class="matterText">
    
    <li>
    <input name="wa_jewellery[]" type="checkbox" value="Importers" <?php if(preg_match('/Importers/',$wa_jewellery)){echo 'checked="checked"'; } ?>/>
    <span>Importers</span>
    </li>
    
     <li>
    <input name="wa_jewellery[]" type="checkbox" value="Retailers" <?php if(preg_match('/Retailers/',$wa_jewellery)){echo 'checked="checked"'; } ?>/>
    <span> Retailers</span>
    </li>
    
     <li>
    <input name="wa_jewellery[]" type="checkbox" value="Exporters" <?php if(preg_match('/Exporters/',$wa_jewellery)){echo 'checked="checked"'; } ?> />
    <span>Exporters</span>
    </li>
    
     <li>
    <input name="wa_jewellery[]" type="checkbox" value="Wholesalers" <?php if(preg_match('/Wholesalers/',$wa_jewellery)){echo 'checked="checked"'; } ?> />
    <span> Wholesalers</span>
    </li>
    
     <li>
    <input name="wa_jewellery[]" type="checkbox" value="Manufacturers" <?php if(preg_match('/Manufacturers/',$wa_jewellery)){echo 'checked="checked"'; } ?> />
    <span>Manufacturers</span>
    </li>
    
    <li>
    <input name="wa_jewellery[]" type="checkbox" value="Chain Stores" <?php if(preg_match('/Chain Stores/',$wa_jewellery)){echo 'checked="checked"'; } ?> />
    <span>Chain Stores </span>
    </li>
    
    <li>
    <input name="wa_jewellery[]" type="checkbox" value="Any Other" id="other-wa-jewellery" <?php if(preg_match('/Any Other/',$wa_jewellery)){echo 'checked="checked"'; } ?> />
    <span> Any Other</span>
    </li>

    </ul>            
       
</div>
<div class="clear" style="margin-bottom:8px;"></div>
 
<div id="wa-jewellery-other-id">
  <label style="min-width:179px;">Any Other , please specify :</label>
  <input name="wa_other" type="text" class="textField" value="<?php echo $wa_other; ?>" />
</div>
</div>
    
</td>
</tr>
</table>
      
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt pvr bottomSpace" >
<tr class="orange1">
<td colspan="11">Products Dealing in</td>
</tr>

<tr>
<td colspan="11" ><div class="field bottomSpace">
<div class="leftTitle" style="padding-top:0px;">Jewellery :</div>
<div class="rightContent">
    <ul class="matterText">
    
    <li>
    <input name="pd_jewellery[]" type="checkbox" value="Plain Gold Jewellery" <?php if(preg_match('/Plain Gold Jewellery/',$pd_jewellery)){echo 'checked="checked"'; } ?> />
    <span>Plain Gold Jewellery</span>
    </li>
    
    <li>
    <input name="pd_jewellery[]" type="checkbox" value="Coloured Gemstones" <?php if(preg_match('/Coloured Gemstones/',$pd_jewellery)){echo 'checked="checked"'; } ?> />
    <span>Coloured Gemstones</span>
    </li>
    
    <li>
    <input name="pd_jewellery[]" type="checkbox" value="Costume Jewellery" <?php if(preg_match('/Costume Jewellery/',$pd_jewellery)){echo 'checked="checked"'; } ?> />
    <span> Costume Jewellery</span>
    </li>
    
    <li>
    <input name="pd_jewellery[]" type="checkbox" value="Studded Gold Jewellery" <?php if(preg_match('/Studded Gold Jewellery/',$pd_jewellery)){echo 'checked="checked"'; } ?> />
    <span>  Studded Gold Jewellery</span>
    </li>
    
    <li>
    <input name="pd_jewellery[]" type="checkbox" value="Pearls" <?php if(preg_match('/Pearls/',$pd_jewellery)){echo 'checked="checked"'; } ?> />
    <span>Pearls</span>
    </li>

    <li>
    <input name="pd_jewellery[]" type="checkbox" value="Loose Diamonds" <?php if(preg_match('/Loose Diamonds/',$pd_jewellery)){echo 'checked="checked"'; } ?> />
    <span>Loose Diamonds</span>
    </li>
    
    <li>
    <input name="pd_jewellery[]" type="checkbox" value="Any Other" id="other-pd-jewellery" <?php if(preg_match('/Any Other/',$pd_jewellery)){echo 'checked="checked"'; } ?> />
    <span> Any Other</span>
    </li>
    
    </ul>
</div>
<div class="clear" style="margin-bottom:8px;"></div>
<div id="pd-jewellery-other-id">
  <label style="min-width:179px;">Any Other , please specify :</label>
  <input name="pd_other" type="text" class="textField" value="<?php echo $pd_other; ?>" />
</div>
</div></td>
</tr>
</table>
         
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt pvr bottomSpace" >

<tr class="orange1">
<td colspan="11">Objective of visiting trade shows</td>
</tr>

<tr>
<td colspan="11" >

<div class="field bottomSpace">
            
<div class="leftTitle" style="padding-top:0px;">Please select area of your interest :</div>
            
<div class="rightContent">
    <ul class="matterText">
    
    <li>
    <input name="objective[]" type="checkbox" value="Source Suppliers" <?php if(preg_match('/Source Suppliers/',$objective)){echo 'checked="checked"'; } ?>/>
    <span>Source Suppliers</span>
    </li>
    
    <li>
    <input name="objective[]" type="checkbox" value="Market Information" <?php if(preg_match('/Market Information/',$objective)){echo 'checked="checked"'; } ?> />
    <span>Market Information</span>
    </li>
    
    <li>
    <input name="objective[]" type="checkbox" value="Joint Ventures" <?php if(preg_match('/Joint Ventures/',$objective)){echo 'checked="checked"'; } ?> />
    <span>  Joint Ventures</span>
    </li>
    
    <li>
    <input name="objective[]" type="checkbox" value="Place Orders" <?php if(preg_match('/Place Orders/',$objective)){echo 'checked="checked"'; } ?> />
    <span> Place Orders</span>
    </li>
    
    <li>
    <input name="objective[]" type="checkbox" value="Meet Regular Suppliers" <?php if(preg_match('/Meet Regular Suppliers/',$objective)){echo 'checked="checked"'; } ?> />
    <span>Meet Regular Suppliers	</span>
    </li>
    
    <li>
    <input name="objective[]" type="checkbox" value="Any Other" id="other-obj-of-visit" <?php if(preg_match('/Any Other/',$objective)){echo 'checked="checked"'; } ?> />
    <span> Any Other</span>
    </li>

    </ul>
</div>
<div class="clear" style="margin-bottom:8px;"></div>
<div id="obj-of-visit-other-id">
<label style="min-width:179px;">Any Other , please specify :</label>
<input name="objective_other" type="text" class="textField" value="<?php echo $objective_other; ?>" />
</div>
</div>
</td>
</tr>
</table>
 
 
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt pvr bottomSpace" >

<tr class="orange1">
<td colspan="11">Items Interested in</td>
</tr>

<tr>
<td colspan="11" >

<div class="field bottomSpace">
            
<div class="leftTitle" style="padding-top:0px;">Jewellery :</div>
            
<div class="rightContent">
    <ul class="matterText">
    
    <li>
    <input name="item_interest[]" type="checkbox" value="Plain Gold Jewellery" <?php if(preg_match('/Plain Gold Jewellery/',$item_interest)){echo 'checked="checked"'; } ?> />
    <span>Plain Gold Jewellery</span>
    </li>
    
    <li>
    <input name="item_interest[]" type="checkbox" value="Coloured Gemstones" id="color_gems" <?php if(preg_match('/Coloured Gemstones/',$item_interest)){echo 'checked="checked"'; } ?> />
    <span>Coloured Gemstones</span>
    </li>
    
    <li>
    <input name="item_interest[]" type="checkbox" value="Costume Jewellery" <?php if(preg_match('/Costume Jewellery/',$item_interest)){echo 'checked="checked"'; } ?> />
    <span> Costume Jewellery</span>
    </li>
    
    <li>
    <input name="item_interest[]" type="checkbox" value="Studded Gold Jewellery" <?php if(preg_match('/Studded Gold Jewellery/',$item_interest)){echo 'checked="checked"'; } ?> />
    <span>  Studded Gold Jewellery</span>
    </li>
    
    <li>
    <input name="item_interest[]" type="checkbox" value="Pearls" <?php if(preg_match('/Pearls/',$item_interest)){echo 'checked="checked"'; } ?> />
    <span>Pearls</span>
    </li>
    
    <li>
    <input name="item_interest[]" type="checkbox" value="Loose Diamonds" id="loose_diamonds" <?php if(preg_match('/Loose Diamonds/',$item_interest)){echo 'checked="checked"'; } ?> />
    <span>Loose Diamonds</span>
    </li>
    
    <li>
    <input name="item_interest[]" type="checkbox" value="Any Other" id="items_interested_other" <?php if(preg_match('/Any Other/',$item_interest)){echo 'checked="checked"'; } ?> />
    <span>Any Other</span>
    </li>
    
    
    </ul>
</div>
	<div class="clear" style="margin-bottom:8px;"></div>
    
    <div id="items_interested_other_id">
        <label style="min-width:179px;">Any Other , please specify :</label>
        <input name="item_interest_other" type="text" class="textField" value="<?php echo $item_interest_other; ?>"/>
    </div>
    
    </div>
    <div class="field bottomSpace" id="loose_diamonds_view" style="display:none;">
        <p><label style="min-width:550px; font-weight:bold; font-size:14px;">Diamond Requirement</label></p>
    <div class="clear"></div>

	<p>Size From / Cts :</p>
	<ul class="matterText">
    	<li>
            <input name="d_size[]" type="checkbox" value="0.004 - 0.008" <?php if(preg_match('/0.004 - 0.008/',$d_size)){echo 'checked="checked"'; } ?>/>0.004 - 0.008
        </li>
        <li>
            <input name="d_size[]" type="checkbox" value="1.00-2.00" <?php if(preg_match('/1.00-2.00/',$d_size)){echo 'checked="checked"'; } ?> />1.00-2.00
        </li>
        <li>
            <input name="d_size[]" type="checkbox" value="0.46 - 0.69" <?php if(preg_match('/0.46 - 0.69/',$d_size)){echo 'checked="checked"'; } ?> />0.46 - 0.69
        </li>
        <li>
            <input name="d_size[]" type="checkbox" value="0.23 - 0.29" <?php if(preg_match('/0.23 - 0.29/',$d_size)){echo 'checked="checked"'; } ?> />0.23 - 0.29
        </li>
        <li>
            <input name="d_size[]" type="checkbox" value="0.08 - 0.13" <?php if(preg_match('/0.08 - 0.13/',$d_size)){echo 'checked="checked"'; } ?> />0.08 - 0.13
        </li>
        <li>
            <input name="d_size[]" type="checkbox" value="0.14 - 0.17" <?php if(preg_match('/0.14 - 0.17/',$d_size)){echo 'checked="checked"'; } ?> />0.14 - 0.17
        </li>
        <li>
            <input name="d_size[]" type="checkbox" value="0.09 - 0.02" <?php if(preg_match('/0.09 - 0.02/',$d_size)){echo 'checked="checked"'; } ?> />0.09 - 0.02
        </li>
        <li>
            <input name="d_size[]" type="checkbox" value="2.00-3.00" <?php if(preg_match('/2.00-3.00/',$d_size)){echo 'checked="checked"'; } ?> />2.00-3.00
        </li>
        <li>
            <input name="d_size[]" type="checkbox" value="0.70 - 0.89" <?php if(preg_match('/0.70 - 0.89/',$d_size)){echo 'checked="checked"'; } ?> />0.70 - 0.89
        </li>
        <li>
            <input name="d_size[]" type="checkbox" value="0.30 - 0.37" <?php if(preg_match('/0.30 - 0.37/',$d_size)){echo 'checked="checked"'; } ?> />0.30 - 0.37
        </li>
        <li>
            <input name="d_size[]" type="checkbox" value="0.38 - 0.45" <?php if(preg_match('/0.38 - 0.45/',$d_size)){echo 'checked="checked"'; } ?> />0.38 - 0.45
        </li>
        <li>
            <input name="d_size[]" type="checkbox" value="0.18 - 0.22" <?php if(preg_match('/0.18 - 0.22/',$d_size)){echo 'checked="checked"'; } ?> />0.18 - 0.22
        </li>
        <li>
            <input name="d_size[]" type="checkbox" value="0.025 - 0.07" <?php if(preg_match('/0.025 - 0.07/',$d_size)){echo 'checked="checked"'; } ?> />0.025 - 0.07
        </li>
        <li>
            <input name="d_size[]" type="checkbox" value="3.00 plus" <?php if(preg_match('/3.00 plus/',$d_size)){echo 'checked="checked"'; } ?> />3.00 plus
        </li>
        <li>
            <input name="d_size[]" type="checkbox" value="0.90 - 1.00" <?php if(preg_match('/0.90 - 1.00/',$d_size)){echo 'checked="checked"'; } ?> />0.90 - 1.00
        </li>
	</ul>

    <div class="clear"></div>
    <p>&nbsp;</p>
    <p>Clarity/Quality From :</p>
	<ul class="matterText">
		<li>
            <input name="d_clarity[]" type="checkbox" value="IF" <?php if(preg_match('/IF/',$d_clarity)){echo 'checked="checked"'; } ?> />IF
        </li>
        <li>
            <input name="d_clarity[]" type="checkbox" value="VVS1 - VVS2" <?php if(preg_match('/VVS1 - VVS2/',$d_clarity)){echo 'checked="checked"'; } ?> />VVS1 - VVS2
        </li>
        <li>
            <input name="d_clarity[]" type="checkbox" value="VS1 - VS2" <?php if(preg_match('/VS1 - VS2/',$d_clarity)){echo 'checked="checked"'; } ?> />VS1 - VS2
        </li>
        <li>
            <input name="d_clarity[]" type="checkbox" value="SI1 - SI2" <?php if(preg_match('/SI1 - SI2/',$d_clarity)){echo 'checked="checked"'; } ?> />SI1 - SI2
        </li>
    </ul>
	<div class="clear"></div>
                <p>&nbsp;</p>
                
                <p>Colour / Shade :</p>
            
               
               <ul class="matterText">
               
               <li>
            <input name="d_color_shade[]" type="checkbox" value="D/ E" <?php if(preg_match("/D\/ E/",$d_color_shade)){echo 'checked="checked"'; } ?> />
            D/ E</li>
            
            
            <li>
            <input name="d_color_shade[]" type="checkbox" value="J/ K" <?php if(preg_match("/J\/ K/",$d_color_shade)){echo 'checked="checked"'; } ?> />
            J/ K</li>
            
                
                 <li>
            <input name="d_color_shade[]" type="checkbox" value="TLC" <?php if(preg_match("/TLC/",$d_color_shade)){echo 'checked="checked"'; } ?>/>
            TLC</li>
                
                 <li>
            <input name="d_color_shade[]" type="checkbox" value="TTLB" <?php if(preg_match('/TTLB/',$d_color_shade)){echo 'checked="checked"'; } ?>/>
            TTLB</li>
            
            <li>
            <input name="d_color_shade[]" type="checkbox" value="LB" <?php if(preg_match('/LB/',$d_color_shade)){echo 'checked="checked"'; } ?>/>
            LB</li>
            
            
            <li>
            <input name="d_color_shade[]" type="checkbox" value="F/ G" <?php if(preg_match("/F\/ G/",$d_color_shade)){echo 'checked="checked"'; } ?>/>
            F/ G</li>
            
                
                 <li>
            <input name="d_color_shade[]" type="checkbox" value="TTLC" <?php if(preg_match('/TTLC/',$d_color_shade)){echo 'checked="checked"'; } ?>/>
            TTLC</li>
                
                 <li>
            <input name="d_color_shade[]" type="checkbox" value="LC" <?php if(preg_match('/LC/',$d_color_shade)){echo 'checked="checked"'; } ?>/>
            LC</li>
            
            <li>
            <input name="d_color_shade[]" type="checkbox" value="TLB" <?php if(preg_match('/TLB/',$d_color_shade)){echo 'checked="checked"'; } ?>/>
            TLB</li>
            
            
            <li>
            <input name="d_color_shade[]" type="checkbox" value="M" <?php if(preg_match('/M/',$d_color_shade)){echo 'checked="checked"'; } ?>/>
            M</li>
            
                
                 <li>
            <input name="d_color_shade[]" type="checkbox" value="H/ I" <?php if(preg_match("/H\/ I/",$d_color_shade)){echo 'checked="checked"'; } ?>/>
            H/ I</li>
       </ul>
       <div class="clear"></div>
                <p>&nbsp;</p>
                
                <p>Price Point(USD):</p>
            
               
            <div class="field">
            <label>From : </label>
            
            <input name="d_pp_from" type="text"  class="textField" id="datepicker" value="<?php echo $d_pp_from; ?>"/>
            </div>
            <div class="field">
            <label>To : </label>
            
            <input name="d_pp_to" type="text"  class="textField" id="datepicker" value="<?php echo $d_pp_to; ?>" />
            </div>
       </div>
       
<div class="field bottomSpace" id="color_gems_view" style="display:none;">
            	
<p><label style="min-width:550px; font-weight:bold; font-size:14px;">Coloured Gem Stone Requirement</label></p>
<div class="clear"></div>
               
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>Name of stone :</td>
    <td><input name="cgs_stone" type="text"  class="textField" id="datepicker" value="<?php echo $cgs_stone; ?>"/></td>
    <td>Shape : </td>
    <td><input name="cgs_shape" type="text"  class="textField" id="datepicker" value="<?php echo $cgs_shape; ?>"/></td>
    
  </tr>
  
   <tr>
   <td>Size From / Cts :</td>
    <td> <input name="cgs_size_from" type="text"  class="textField" id="datepicker" value="<?php echo $cgs_size_from; ?>"/></td>
    <td>To : </td>
    <td><input name="cgs_size_to" type="text"  class="textField" id="datepicker" value="<?php echo $cgs_size_to; ?>"/></td>
	
  </tr>
  
  <tr>
    <td>Colour/Shade : </td>
    <td><input name="cgs_shade" type="text"  class="textField" id="datepicker" value="<?php echo $cgs_shade; ?>"/></td>
     <td>Quantity :</td>
    <td><input name="cgs_quantity" type="text"  class="textField" id="datepicker" value="<?php echo $cgs_quantity; ?>"/></td>
  </tr>
   <tr>
   <td colspan="2"><p>Price Point(USD):</p></td>
   </tr>
  <tr>
    <td>From : </td>
    <td><input name="cgs_pp_from" type="text"  class="textField" id="datepicker" value="<?php echo $cgs_pp_from; ?>"/></td>
    <td>To : </td>
    <td><input name="cgs_pp_to" type="text"  class="textField" id="datepicker" value="<?php echo $cgs_pp_to; ?>"/></td>
  </tr>
  
  
 
</table>
           
    

</td>
</tr>
</table>     
</div>
</div>
<div style="padding-left:250px; margin-top:5px;">
<input type="hidden" name="action" id="action" value="UPDATE" />
<input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
<input type="hidden" name="registration_id" id="registration_id" value="<?php echo $registration_id;?>" />    	
<input type="submit" value="Update" class="input_submit"/>
<a href="iijs_information_pvr.php?id=<?php echo $id;?>&registration_id=<?php echo $registration_id;?>">
<div class="button">Previous</div></a>
<a href="iijs_participation_&_payment_details_pvr.php?id=<?php echo $id;?>&registration_id=<?php echo $registration_id;?>">
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
