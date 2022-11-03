<?php session_start(); ob_start(); ?>
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
		$wa_jewellery_other=$_POST['wa_jewellery_other'];
	else
		$wa_jewellery_other="";
	
	$pd_jewellery=implode(",",$_POST['pd_jewellery']);
	if(preg_match('/Any Other/',$pd_jewellery))
		$pd_jewellery_other=$_POST['pd_jewellery_other'];
	else
		$pd_jewellery_other="";
	
	$no_of_years=$_POST['no_of_years'];
	$emp_strength=$_POST['emp_strength'];
	$no_of_branches=$_POST['no_of_branches'];
	$turnover=$_POST['turnover'];
	
	$obj_of_visit=implode(",",$_POST['obj_of_visit']);
	if(preg_match('/Any Other/',$obj_of_visit))
		$oov_other=$_POST['oov_other'];
	else
		$oov_other="";
	
	
	$import_frm=implode(",",$_POST['import_frm']);
	if(preg_match('/Any Other/',$import_frm))
		$import_frm_other=$_POST['import_frm_other'];
	else
		$import_frm_other="";
	
	
	$items_interested=implode(",",$_POST['items_interested']);
	if(preg_match('/Any Other/',$items_interested))
		$items_interested_other=$_POST['items_interested_other'];
	else
		$items_interested_other="";
		
	$caratage_pref=$_POST['caratage_pref'];
	
	if(preg_match('/colorstones and gemstones/',$items_interested))
	{
		$cgr_name_stone=$_POST['cgr_name_stone'];
		$cgr_size_frm=$_POST['cgr_size_frm'];
		$cgr_size_to=$_POST['cgr_size_to'];
		$cgr_shape=$_POST['cgr_shape'];
		$cgr_colour_shade=$_POST['cgr_colour_shade'];
		
		$cgr_from=$_POST['cgr_from'];
		$cgr_to=$_POST['cgr_to'];
	}
	else
	{
		$cgr_name_stone="";
		$cgr_size_frm="";
		$cgr_size_to="";
		$cgr_shape="";
		$cgr_colour_shade="";
		$cgr_from="";
		$cgr_to="";
	}
	
	if(preg_match('/loose diamonds/',$items_interested))
	{
		$dr_size_frm=implode(",",$_POST['dr_size_frm']);
		$dr_clarity=implode(",", $_POST['dr_clarity']);
		$dr_colour_shade=implode(",",$_POST['dr_colour_shade']);
		$dr_from=$_POST['dr_from'];
		$dr_to=$_POST['dr_to'];
	}
	else
	{
		
		$dr_size_frm="";
		$dr_clarity="";
		$dr_colour_shade="";
		$dr_from="";
		$dr_to="";
	}
	
	
	$how_you_learn_abt_iijs=implode(",",$_POST['how_you_learn_abt_iijs']);
	if(preg_match('/Any Other/',$how_you_learn_abt_iijs))
		$how_you_learn_abt_iijs_other=$_POST['how_you_learn_abt_iijs_other'];
	else
		$how_you_learn_abt_iijs_other="";
	
	$send_info_abt=implode(",",$_POST['send_info_abt']);
	if(preg_match('/Tours/',$send_info_abt))
		$send_info_abt_other=$_POST['send_info_abt_other'];
	else
		$send_info_abt_other="";
	
	$would_you_like=$_POST['would_you_like'];


	$updatequery="update ivr_registration_details set wa_jewellery='".$wa_jewellery."',wa_jewellery_other='".$wa_jewellery_other."',pd_jewellery='".$pd_jewellery."',pd_jewellery_other='".$pd_jewellery_other."',no_of_years='".$no_of_years."',emp_strength='".$emp_strength."',no_of_branches='".$no_of_branches."',turnover='".$turnover."',obj_of_visit='".$obj_of_visit."',oov_other='".$oov_other."',import_frm='".$import_frm."',import_frm_other='".$import_frm_other."',items_interested='".$items_interested."',items_interested_other='".$items_interested_other."',caratage_pref='".$caratage_pref."',dr_size_frm='".$dr_size_frm."',dr_clarity='".$dr_clarity."',dr_colour_shade='".$dr_colour_shade."',dr_from='".$dr_from."',dr_to='".$dr_to."',cgr_name_stone='".$cgr_name_stone."',cgr_size_frm='".$cgr_size_frm."',cgr_size_to='".$cgr_size_to."',cgr_shape='".$cgr_shape."',cgr_colour_shade='".$cgr_colour_shade."',cgr_from='".$cgr_from."',cgr_to='".$cgr_to."',how_you_learn_abt_iijs='".$how_you_learn_abt_iijs."',how_you_learn_abt_iijs_other='".$how_you_learn_abt_iijs_other."',send_info_abt='".$send_info_abt."',send_info_abt_other='".$send_info_abt_other."',would_you_like='".$would_you_like."' where eid='$id' and uid='$registration_id'"; 

	$update_result = mysql_query($updatequery);

	if(!$update_result){
	echo "Error: ".mysql_error();	
	}

$_SESSION['succ_msg']="OBMP info updated successfully";
header("Location: iijs_photo_form_IVR.php?id=$id&registration_id=$registration_id");

}


?>

<?php
	$id=mysql_real_escape_string($_REQUEST['id']);
	$registration_id=mysql_real_escape_string($_REQUEST['registration_id']);
	$sql="SELECT * FROM `ivr_registration_details` WHERE 1 and eid='$id' and uid='$registration_id'";
	$result=mysql_query($sql);
	$rows=mysql_fetch_array($result);

	$wa_jewellery=$rows['wa_jewellery'];
	$wa_jewellery_other=$rows['wa_jewellery_other'];
	
	$pd_jewellery=$rows['pd_jewellery'];
	$pd_jewellery_other=$rows['pd_jewellery_other'];
	$no_of_years=$rows['no_of_years'];
	$emp_strength=$rows['emp_strength'];
	$no_of_branches=$rows['no_of_branches'];
	$turnover=$rows['turnover'];
	
	$obj_of_visit=$rows['obj_of_visit'];
	$oov_other=$rows['oov_other'];
	
	$import_frm=$rows['import_frm'];
	$import_frm_other=$rows['import_frm_other'];
	
	$items_interested=$rows['items_interested'];
	$items_interested_other=$rows['items_interested_other'];
	$caratage_pref=$rows['caratage_pref'];
	
	$dr_size_frm=$rows['dr_size_frm'];
	$dr_clarity=$rows['dr_clarity'];
	$dr_colour_shade=$rows['dr_colour_shade'];
	$dr_from=$rows['dr_from'];
	$dr_to=$rows['dr_to'];
	
	$cgr_name_stone=$rows['cgr_name_stone'];
	$cgr_size_frm=$rows['cgr_size_frm'];
	$cgr_size_to=$rows['cgr_size_to'];
	$cgr_shape=$rows['cgr_shape'];
	$cgr_colour_shade=$rows['cgr_colour_shade'];
	$cgr_from=$rows['cgr_from'];
	$cgr_to=$rows['cgr_to'];
	
	$how_you_learn_abt_iijs=$rows['how_you_learn_abt_iijs'];
	$how_you_learn_abt_iijs_other=$rows['how_you_learn_abt_iijs_other'];
	
	$send_info_abt=$rows['send_info_abt'];
	$send_info_abt_other=$rows['send_info_abt_other'];
	$would_you_like=$rows['would_you_like'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IIJS &gt; IVR &gt;&gt; OBMP Info</title>
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
<script type="text/javascript" src="member_directory.js"></script>
</head>

<body>


<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > IVR > OBMP Info</div>
</div>

<div id="main">
	<div class="content">
    
    	<div class="content_head">IIJS &gt; IVR >> OBMP Info
       	  <div style="float:right; padding-right:10px; font-size:12px;"><a href="iijs_ivr.php">Back to Search</a></div> 
        </div>
    	
<div class="clear"></div>
<div class="content_details1">
<form name="search" action="" method="post" > 
<?php 
if($_SESSION['error_msg']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
$_SESSION['error_msg']="";
}
?>

<div id="formAdmin">
	<ul id="tabs" class="tab_1">
    <li id=""><a href="#"><strong>Step 1 Information</strong></a></li>
    <li id=""><a href="#" class="active"><strong>Step 2 OBMP Info</strong></a></li>  
    <li id=""><a href="#" class="lastBg"><strong>Step 3 Photo</strong></a></li>   
    <div class="clear"></div>
    </ul>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="10" >We are <sup class="white">*</sup></td>
</tr>
<tr>
  <td class="maroon"><strong>Jewellery</strong></td>
  </tr>
<tr>
    <td><table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><input name="wa_jewellery[]" type="checkbox" value="importers" <?php if(preg_match('/importers/',$wa_jewellery)){ echo ' checked="checked"'; } ?>/>Importers</td>
        <td> <input name="wa_jewellery[]" type="checkbox" value="retailers" <?php if(preg_match('/retailers/',$wa_jewellery)){ echo ' checked="checked"'; } ?> />Retailers</td>
        <td> <input name="wa_jewellery[]" type="checkbox" value="exporters" <?php if(preg_match('/exporters/',$wa_jewellery)){ echo ' checked="checked"'; } ?> />Exporters</td>
        <td><input name="wa_jewellery[]" type="checkbox" value="wholesalers" <?php if(preg_match('/wholesalers/',$wa_jewellery)){ echo ' checked="checked"'; } ?> />Wholesalers</td>
        <td> <input name="wa_jewellery[]" type="checkbox" value="manufacturers" <?php if(preg_match('/manufacturers/',$wa_jewellery)){ echo ' checked="checked"'; } ?> />Manufacturers</td>
        <td> <input name="wa_jewellery[]" type="checkbox" id="" value="chain stores" <?php if(preg_match('/chain stores/',$wa_jewellery)){ echo ' checked="checked"'; } ?> />Chain Stores</td>
        <td> <input name="wa_jewellery[]" type="checkbox" id="other-wa-jewellery" value="Any Other" <?php if(preg_match('/Any Other/',$wa_jewellery)){ echo ' checked="checked"'; } ?> />Any Other</td>
      </tr>
      
      <tr>
        <td colspan="8" class="wa-jewellery-other-id" style="display:none;"><div class="leftLabel"><strong>If others, please specify :</strong></td>
       <td class="wa-jewellery-other-id" style="display:none;"><input type="text" class="textField" name="wa_jewellery_other" id="edit-wa-jewellery-other" value="<?php echo $wa_jewellery_other; ?>" />
        </td>
        </tr>
    </table></td>
    </tr>	
</table>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="10" >Products Dealing in <sup class="white">*</sup></td>
</tr>
<tr>
  <td class="maroon"><strong>Jewellery</strong></td>
  </tr>
<tr>
    <td><table border="0" cellspacing="0" cellpadding="0" class="bottomSpace">
      <tr>
        <td><input name="pd_jewellery[]" type="checkbox" value="plain gold jewellery" <?php if(preg_match('/plain gold jewellery/',$pd_jewellery)){ echo ' checked="checked"'; } ?>/>Plain Gold Jewellery</td>
        <td><input name="pd_jewellery[]" type="checkbox" value="studded gold jewellery" <?php if(preg_match('/studded gold jewellery/',$pd_jewellery)){ echo ' checked="checked"'; } ?>/>Studded Gold Jewellery</td>
        <td><input name="pd_jewellery[]" type="checkbox" value="loose diamonds" <?php if(preg_match('/loose diamonds/',$pd_jewellery)){ echo ' checked="checked"'; } ?>/>Loose Diamonds</td>
        <td> <input name="pd_jewellery[]" type="checkbox" value="coloured gemstones" <?php if(preg_match('/coloured gemstones/',$pd_jewellery)){ echo ' checked="checked"'; } ?>/>Coloured Gemstones</td>
        <td><input name="pd_jewellery[]" type="checkbox" value="pearls" <?php if(preg_match('/pearls/',$pd_jewellery)){ echo ' checked="checked"'; } ?>/>Pearls</td>
        <td><input name="pd_jewellery[]" type="checkbox" value="costume jewellery" <?php if(preg_match('/costume jewellery/',$pd_jewellery)){ echo ' checked="checked"'; } ?>/>Costume Jewellery</td>
      </tr>
      
      <tr>
        <td><input name="pd_jewellery[]" type="checkbox" value="plain jewellery" <?php if(preg_match('/plain jewellery/',$pd_jewellery)){ echo ' checked="checked"'; } ?>/>Platinum Jewellery</td>
        <td> <input name="pd_jewellery[]" type="checkbox" value="silver jewellery" <?php if(preg_match('/silver jewellery/',$pd_jewellery)){ echo ' checked="checked"'; } ?>/><span>Silver Jewellery</td>
         <td><input name="pd_jewellery[]" type="checkbox" id="other-pd-jewellery" value="Any Other" <?php if(preg_match('/Any Other/',$pd_jewellery)){ echo ' checked="checked"'; } ?>/>Any Other</td>
      </tr>
     
      <tr>
        <td class="pd-jewellery-other-id" style="display:none;"><div class="leftLabel"><strong>If others, please specify :</strong></div>
          <div class="clear"></div>
        </td>
        <td colspan="2" class="pd-jewellery-other-id" style="display:none;"><input type="text" class="textField" name="pd_jewellery_other" id="edit-pd-jewellery-other" value="<?php echo $pd_jewellery_other; ?>" /></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td><div class="leftLabel"><strong>No. of years in Business :</strong></div></td>
        <td colspan="2" valign="top">
         <select name="no_of_years" class="input_txt">
              <option value="">-- Please Select -- </option>
              <option value="Less than 5 years" <?php if(preg_match('/Less than 5 years/',$no_of_years)){ echo "selected"; }?>> Less than 5 years</option>
              <option value="5-15 years" <?php if(preg_match('/5-15 years/',$no_of_years)){ echo "selected"; }?>>5-15 years </option>
              <option value="More than 15 years" <?php if(preg_match('/More than 15 years/',$no_of_years)){ echo "selected"; }?>>More than 15 years </option>
         </select></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div class="leftLabel"><strong>Employee Strength :</strong></div></td>
        <td colspan="2">
        <select name="emp_strength" class="input_txt">
              <option value="" >-- Please Select -- </option>	
              <option value="Less than 25" <?php if(preg_match('/Less than 25/',$emp_strength)){ echo "selected"; }?>> Less than 25 </option>
              <option value="25-50" <?php if(preg_match('/25-50/',$emp_strength)){ echo "selected"; }?>> 25-50</option>
              <option value="50-100" <?php if(preg_match('/50-100/',$emp_strength)){ echo "selected"; }?>> 50-100 </option>
              <option value="100+" <?php if(preg_match('/100+/',$emp_strength)){ echo "selected"; }?>> 100+ </option>
        </select>
        </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div class="leftLabel"><strong>No. of Branches :</strong></div></td>
        <td colspan="2">
        <select name="no_of_branches" class="input_txt">
             <option value="">-- Please Select -- </option>	
              <option value="Less than 5" <?php if(preg_match('/Less than 5/',$no_of_branches)){ echo "selected"; }?>> Less than 5 </option>
              <option value="5-10" <?php if(preg_match('/5-10/',$no_of_branches)){ echo "selected"; }?>> 5-10</option>
              <option value="More than 10" <?php if(preg_match('/More than 10/',$no_of_branches)){ echo "selected"; }?>> More than 10 </option>
              <option value="None" <?php if(preg_match('/None/',$no_of_branches)){ echo "selected"; }?>> None </option>
        </select>
        </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div class="leftLabel"><strong>Company Turnover (US $) :</strong></div></td>
        <td colspan="2" valign="top">
        <select name="turnover" class="input_txt">
             <option value="">-- Please Select -- </option>	
              <option value="Less than 5 mn$" <?php if(preg_match('/Less than 5 mn\$/',$turnover)){ echo "selected"; }?>> Less than 5 mn$ </option>
              <option value="5-15 mn$" <?php if(preg_match('/5-15 mn\$/',$turnover)){ echo "selected"; }?>> 5-15 mn$</option>
              <option value="15-25 mn$" <?php if(preg_match('/15-25 mn\$/',$turnover)){ echo "selected"; }?>> 15-25 mn$</option>
              <option value="25 mn$+" <?php if(preg_match('/25 mn\$+/',$turnover)){ echo "selected"; }?>> 25 mn$+</option>
        </select>
        </td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    </tr>
<tr>
  <td><table border="0" cellspacing="0" cellpadding="0" class="bottomSpace">
    <tr>
      <td colspan="4" class="maroon"><strong>Objective of visiting IIJS 2016 :</strong></td>
      </tr>
    <tr>
      <td><input name="obj_of_visit[]" type="checkbox" value="buying" <?php if(preg_match('/buying/',$obj_of_visit)){ echo "checked"; }?>/>
      Buying</td>
      <td> <input name="obj_of_visit[]" type="checkbox" value="source suppliers" <?php if(preg_match('/source suppliers/',$obj_of_visit)){ echo "checked"; }?> />
      Source Suppliers</td>
      <td><input name="obj_of_visit[]" type="checkbox" value="joint ventures" <?php if(preg_match('/joint ventures/',$obj_of_visit)){ echo "checked"; }?>/>
      Joint Ventures</td>
      <td><input name="obj_of_visit[]" type="checkbox" value="importing" <?php if(preg_match('/importing/',$obj_of_visit)){ echo "checked"; }?>/>
      Importing</td>
    </tr>
    <tr>
      <td><input name="obj_of_visit[]" type="checkbox" value="appointing agents" <?php if(preg_match('/appointing agents/',$obj_of_visit)){ echo "checked"; }?>/>
      Appointing Agents</td>
      <td><input name="obj_of_visit[]" type="checkbox" value="seek representatives" <?php if(preg_match('/seek representatives/',$obj_of_visit)){ echo "checked"; }?>/>
      Seek Representatives</td>
      <td> <input name="obj_of_visit[]" type="checkbox" value="place orders" <?php if(preg_match('/place orders/',$obj_of_visit)){ echo "checked"; }?>/>
      Place Orders</td>
      <td><input name="obj_of_visit[]" type="checkbox" value="market information" <?php if(preg_match('/market information/',$obj_of_visit)){ echo "checked"; }?>/>
      Market Information</td>
    </tr>
    <tr>
      <td><input name="obj_of_visit[]" type="checkbox" value="evaluate for future participation" <?php if(preg_match('/evaluate for future participation/',$obj_of_visit)){ echo "checked"; }?>/>
      Evaluate For Future Participation</td>
      
      <td><input name="obj_of_visit[]" type="checkbox" id="other-obj-of-visit" value="Any Other" <?php if(preg_match('/Any Other/',$obj_of_visit)){ echo "checked"; }?>/>
      <span> Any Other</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="obj-of-visit-other-id" style="display:none;"><strong>If others, please specify :</strong></td>
      <td colspan="2" class="obj-of-visit-other-id" style="display:none;"><input type="text" class="textField" name="oov_other" id="obj-of-visit-other" value="<?php echo $oov_other;?>" /></td>
      <td>&nbsp;</td>
    </tr>
  </table></td>
</tr>
<tr>
  <td><table border="0" cellspacing="0" cellpadding="0" class="bottomSpace">
    <tr>
      <td colspan="4" class="maroon"><strong>Presently Importing From :</strong></td>
      </tr>
    <tr>
      <td><input name="import_frm[]" type="checkbox" value="asia" <?php if(preg_match('/asia/',$import_frm)){ echo "checked"; }?>/>
             Asia</td>
      <td><input name="import_frm[]" type="checkbox" value="india" <?php if(preg_match('/india/',$import_frm)){ echo "checked"; }?>/>
            India</td>
      <td><input name="import_frm[]" type="checkbox" value="australia" <?php if(preg_match('/australia/',$import_frm)){ echo "checked"; }?>/>
            Australia</td>
      <td> <input name="import_frm[]" type="checkbox" value="new zealand" <?php if(preg_match('/new zealand/',$import_frm)){ echo "checked"; }?>/>
            New Zealand</td>
    </tr>
    <tr>
      <td> <input name="import_frm[]" type="checkbox" value="canada" <?php if(preg_match('/canada/',$import_frm)){ echo "checked"; }?>/>
            Canada</td>
      <td><input name="import_frm[]" type="checkbox" value="europe" <?php if(preg_match('/europe/',$import_frm)){ echo "checked"; }?>/>
            Europe</td>
      <td><input name="import_frm[]" type="checkbox" value="usa" <?php if(preg_match('/usa/',$import_frm)){ echo "checked"; }?>/>
            USA</td>
      <td><input name="import_frm[]" type="checkbox" value="middle east" <?php if(preg_match('/middle east/',$import_frm)){ echo "checked"; }?>/>
            Middle East</td>
    </tr>
    <tr>
      <td><input name="import_frm[]" type="checkbox" value="africa" <?php if(preg_match('/africa/',$import_frm)){ echo "checked"; }?>/>
            Africa</td>
      <td><input name="import_frm[]" type="checkbox" value="far east" <?php if(preg_match('/far east/',$import_frm)){ echo "checked"; }?>/>
           Far East</td>
      <td><input name="import_frm[]" type="checkbox" id="other-import-frm" value="Any Other" <?php if(preg_match('/Any Other/',$import_frm)){ echo "checked"; }?>/>
            <span> Any Other</span> </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="import-frm-other-id" style="display:none;"><strong>If others, please specify :</strong></td>
      <td colspan="2" class="import-frm-other-id" style="display:none;"><input type="text" class="textField" name="import_frm_other" id="import_frm_other" value="<?php echo $import_frm_other; ?>" /></td>
      <td>&nbsp;</td>
    </tr>
  </table></td>
</tr>
<tr>
  <td><table border="0" cellspacing="0" cellpadding="0" class="bottomSpace">
    <tr>
      <td colspan="4" class="maroon"><strong>Items Interested in :</strong></td>
    </tr>
    <tr>
      <td><input name="items_interested[]" type="checkbox" value="rings" <?php if(preg_match('/rings/',$items_interested)){ echo "checked"; }?>/>
             Rings</td>
      <td><input name="items_interested[]" type="checkbox" value="pendants" <?php if(preg_match('/pendants/',$items_interested)){ echo "checked"; }?>/>
            Pendants</td>
      <td><input name="items_interested[]" type="checkbox" value="colorstones and gemstones" id="color_gems" <?php if(preg_match('/colorstones and gemstones/',$items_interested)){ echo "checked"; }?>/>
            Colorstones and gemstones</td>
      <td><input name="items_interested[]" type="checkbox" value="necklaces" <?php if(preg_match('/necklaces/',$items_interested)){ echo "checked"; }?>/>
            Necklaces</td>
    </tr>
    <tr>
      <td><input name="items_interested[]" type="checkbox" value="bangles" <?php if(preg_match('/bangles/',$items_interested)){ echo "checked"; }?>/>
            Bangles</td>
      <td><input name="items_interested[]" type="checkbox" value="chains" <?php if(preg_match('/chains/',$items_interested)){ echo "checked"; }?>/>
            Chains</td>
      <td> <input name="items_interested[]" type="checkbox" value="bracelets" <?php if(preg_match('/bracelets/',$items_interested)){ echo "checked"; }?>/>
            Bracelets</td>
      <td><input name="items_interested[]" type="checkbox" value="loose diamonds" id="loose_diamonds" <?php if(preg_match('/loose diamonds/',$items_interested)){ echo "checked"; }?>/>
            Loose Diamonds</td>
    </tr>
    <tr>
      <td><input name="items_interested[]" type="checkbox" value="Any Other" id="items_interested_other" <?php if(preg_match('/Any Other/',$items_interested)){ echo "checked"; }?>/>
            <span> Any Other</span></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Caratage Preference :</strong></td>
      <td colspan="2"><input name="caratage_pref" type="text" class="textField" value="<?php echo $caratage_pref; ?>" /></td>
      <td>&nbsp;</td>
    </tr>
    
    <tr>
      <td class="items_interested_other_id" style="display:none;"><strong>If others, please specify :</strong></td>
      <td colspan="2" class="items_interested_other_id" style="display:none;"><input type="text" class="textField" name="items_interested_other" value="<?php echo $items_interested_other; ?>" /></td>
      <td>&nbsp;</td>
    </tr>

    
  </table></td>
</tr>


</table>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt bottomSpace" >
<tr class="orange1">
    <td colspan="10" class="loose_diamonds_view" style="display:none;">Diamond Requirement</td>
</tr>
<tr>
  <td class="maroon" class="loose_diamonds_view" style="display:none;"><strong>Size From / Cts</strong></td>
  </tr>

<tr>
    <td class="loose_diamonds_view" style="display:none;"><table border="0" cellspacing="0" cellpadding="0" class="bottomSpace">
      <tr>
        <td><input name="dr_size_frm[]" type="checkbox" value="0.004 - 0.008" <?php if(preg_match('/0.004 - 0.008/',$dr_size_frm)){ echo "checked"; }?>/>
            0.004 - 0.008</td>
        <td><input name="dr_size_frm[]" type="checkbox" value="1.00-2.00" <?php if(preg_match('/1.00-2.00/',$dr_size_frm)){ echo "checked"; }?>/>
            1.00-2.00</td>
        <td> <input name="dr_size_frm[]" type="checkbox" value="0.46 - 0.69" <?php if(preg_match('/0.46 - 0.69/',$dr_size_frm)){ echo "checked"; }?>/>
            0.46 - 0.69</td>
        <td><input name="dr_size_frm[]" type="checkbox" value="0.23 - 0.29" <?php if(preg_match('/0.23 - 0.29/',$dr_size_frm)){ echo "checked"; }?>/>
            0.23 - 0.29</td>
        <td><input name="dr_size_frm[]" type="checkbox" value="0.08 - 0.13" <?php if(preg_match('/0.08 - 0.13/',$dr_size_frm)){ echo "checked"; }?>/>
            0.08 - 0.13</td>
      </tr>
      <tr>
        <td><input name="dr_size_frm[]" type="checkbox" value="0.14 - 0.17" <?php if(preg_match('/0.14 - 0.17/',$dr_size_frm)){ echo "checked"; }?>/>
            0.14 - 0.17</td>
        <td><input name="dr_size_frm[]" type="checkbox" value="0.09 - 0.02" <?php if(preg_match('/0.09 - 0.02/',$dr_size_frm)){ echo "checked"; }?>/>
            0.09 - 0.02</td>
        <td><input name="dr_size_frm[]" type="checkbox" value="2.00-3.00" <?php if(preg_match('/2.00-3.00/',$dr_size_frm)){ echo "checked"; }?>/>
            2.00-3.00</td>
        <td><input name="dr_size_frm[]" type="checkbox" value="0.70 - 0.89" <?php if(preg_match('/0.70 - 0.89/',$dr_size_frm)){ echo "checked"; }?>/>
            0.70 - 0.89</td>
        <td><input name="dr_size_frm[]" type="checkbox" value="0.30 - 0.37" <?php if(preg_match('/0.30 - 0.37/',$dr_size_frm)){ echo "checked"; }?>/>
            0.30 - 0.37</td>
      </tr>
      <tr>
        <td><input name="dr_size_frm[]" type="checkbox" value="0.38 - 0.45" <?php if(preg_match('/0.38 - 0.45/',$dr_size_frm)){ echo "checked"; }?>/>
            0.38 - 0.45</td>
        <td><input name="dr_size_frm[]" type="checkbox" value="0.18 - 0.22" <?php if(preg_match('/0.18 - 0.22/',$dr_size_frm)){ echo "checked"; }?>/>
            0.18 - 0.22</td>
        <td><input name="dr_size_frm[]" type="checkbox" value="0.025 - 0.07" <?php if(preg_match('/0.025 - 0.07/',$dr_size_frm)){ echo "checked"; }?>/>
            0.025 - 0.07</td>
        <td><input name="dr_size_frm[]" type="checkbox" value="3.00 plus" <?php if(preg_match('/3.00 plus/',$dr_size_frm)){ echo "checked"; }?>/>
            3.00 plus</td>
        <td><input name="dr_size_frm[]" type="checkbox" value="0.90 - 1.00" <?php if(preg_match('/0.90 - 1.00/',$dr_size_frm)){ echo "checked"; }?>/>
            0.90 - 1.00</td>
      </tr>
    </table></td>
    </tr>
<tr>
  <td class="loose_diamonds_view" style="display:none;"><table border="0" cellspacing="0" cellpadding="0" class="bottomSpace">
    <tr>
      <td colspan="4" class="maroon"><strong>Clarity / Quality From :</strong></td>
      </tr>
    <tr>
      <td> <input name="dr_clarity[]" type="checkbox" value="IF" <?php if(preg_match('/IF/',$dr_clarity)){ echo "checked"; }?>/>
            IF</td>
      <td><input name="dr_clarity[]" type="checkbox" value="VVS1 - VVS2" <?php if(preg_match('/VVS1 - VVS2/',$dr_clarity)){ echo "checked"; }?>/>
            VVS1 - VVS2</td>

      <td><input name="dr_clarity[]" type="checkbox" value="VS1 - VS2" <?php if(preg_match('/VS1 - VS2/',$dr_clarity)){ echo "checked"; }?>/>
            VS1 - VS2</td>
      <td><input name="dr_clarity[]" type="checkbox" value="SI1 - SI2" <?php if(preg_match('/SI1 - SI2/',$dr_clarity)){ echo "checked"; }?>/>
            SI1 - SI2</td>
    </tr>
  </table></td>
</tr>
<tr>
  <td class="loose_diamonds_view" style="display:none;">
    <table border="0" cellspacing="0" cellpadding="0" class="bottomSpace">
    <tr>
      <td colspan="5" class="maroon"><strong>Colour / Shade :</strong></td>
    </tr>
    <tr>
      <td><input name="dr_colour_shade[]" type="checkbox" value="D/ E" <?php if(preg_match('/D\/ E/',$dr_colour_shade)){ echo "checked"; }?>/>
            D/ E</td>
      <td><input name="dr_colour_shade[]" type="checkbox" value="J/ K" <?php if(preg_match('/J\/ K/',$dr_colour_shade)){ echo "checked"; }?>/>
            J/ K</td>
      <td><input name="dr_colour_shade[]" type="checkbox" value="TLC" <?php if(preg_match('/TLC/',$dr_colour_shade)){ echo "checked"; }?>/>
            TLC</td>
      <td><input name="dr_colour_shade[]" type="checkbox" value="TTLB" <?php if(preg_match('/TTLB/',$dr_colour_shade)){ echo "checked"; }?>/>
            TTLB</td>
      <td><input name="dr_colour_shade[]" type="checkbox" value="LB" <?php if(preg_match('/LB/',$dr_colour_shade)){ echo "checked"; }?>/>
            LB</td>
    </tr>
    <tr>
      <td> <input name="dr_colour_shade[]" type="checkbox" value="F/ G" <?php if(preg_match('/F\/ G/',$dr_colour_shade)){ echo "checked"; }?>/>
            F/ G</td>
      <td> <input name="dr_colour_shade[]" type="checkbox" value="TTLC" <?php if(preg_match('/TTLC/',$dr_colour_shade)){ echo "checked"; }?>/>
            TTLC</td>
      <td><input name="dr_colour_shade[]" type="checkbox" value="LC" <?php if(preg_match('/LC/',$dr_colour_shade)){ echo "checked"; }?>/>
            LC</td>
      <td><input name="dr_colour_shade[]" type="checkbox" value="TLB" <?php if(preg_match('/TLB/',$dr_colour_shade)){ echo "checked"; }?>/>
            TLB</td>
      <td><input name="dr_colour_shade[]" type="checkbox" value="M" <?php if(preg_match('/M/',$dr_colour_shade)){ echo "checked"; }?>/>
            M</td>
    </tr>
    <tr>
      <td><input name="dr_colour_shade[]" type="checkbox" value="H/ I" <?php if(preg_match('/H\/ I/',$dr_colour_shade)){ echo "checked"; }?>/>
            H/ I</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5"><strong>Price Point (USD) :</strong></td>
      </tr>
    <tr>
      <td><strong>From :</strong></td>
      <td colspan="4"><input name="dr_from" type="text"  class="textField" id="datepicker" value="<?php echo $dr_from;?>"/></td>
      </tr>
    <tr>
      <td><strong>To :</strong></td>
      <td colspan="4"><input name="dr_to" type="text"  class="textField" id="datepicker" value="<?php echo $dr_to;?>"/></td>
      </tr>
  </table>
  </td>

</tr>

<tr>
  <td id="color_gems_view" style="display:none;"><table border="0" cellspacing="0" cellpadding="0" class="bottomSpace" >
    <tr>
      <td colspan="2" class="maroon"><strong>Coloured Gem Stone Requirement</strong></td>
    </tr>

    <tr>
      <td><strong>Name of stone :</strong></td>
      <td><input name="cgr_name_stone" type="text"  class="textField" id="datepicker" value="<?php echo $cgr_name_stone;?>"/></td>
      </tr>
    <tr>
      <td><strong>Size From / Cts :</strong></td>
      <td><input name="cgr_size_frm" type="text"  class="textField" id="datepicker" value="<?php echo $cgr_size_frm;?>"/></td>
      </tr>
    <tr>
      <td><strong>To :</strong></td>
      <td><input name="cgr_size_to" type="text"  class="textField" id="datepicker" value="<?php echo $cgr_size_to;?>"/></td>
    </tr>
    <tr>
      <td><strong>Shape :</strong></td>
      <td><input name="cgr_shape" type="text"  class="textField" id="datepicker" value="<?php echo $cgr_shape;?>"/></td>
    </tr>
    <tr>
      <td><strong>Colour / Shade :</strong></td>
      <td><input name="cgr_colour_shade" type="text"  class="textField" id="datepicker" value="<?php echo $cgr_colour_shade;?>"/></td>
    </tr>
    <tr>
      <td colspan="2"><strong>Price Point (USD) :</strong></td>
      </tr>
    <tr>
      <td><strong>From :</strong></td>
      <td> <input name="cgr_from" type="text"  class="textField" id="datepicker" value="<?php echo $cgr_from;?>"/></td>
      </tr>
    <tr>
      <td><strong>To :</strong></td>
      <td><input name="cgr_to" type="text"  class="textField" id="datepicker" value="<?php echo $cgr_to;?>"/></td>
    </tr>
  </table>
  </td>

</tr>

<tr>
  <td>
  <table border="0" cellspacing="0" cellpadding="0" class="bottomSpace">
    <tr>
      <td colspan="4" class="maroon"><strong>How did you first learn about IIJS 2016 :</strong></td>
    </tr>
    <tr>
      <td><input name="how_you_learn_abt_iijs[]" type="checkbox" value="official agents" <?php if(preg_match('/official agents/',$how_you_learn_abt_iijs)){ echo "checked"; }?>/>
            Official Agents</td>
      <td><input name="how_you_learn_abt_iijs[]" type="checkbox" value="publications" <?php if(preg_match('/publications/',$how_you_learn_abt_iijs)){ echo "checked"; }?>/>
            Publications</td>
      <td> <input name="how_you_learn_abt_iijs[]" type="checkbox" value="trade fairs" <?php if(preg_match('/trade fairs/',$how_you_learn_abt_iijs)){ echo "checked"; }?>/>
            Trade Fairs</td>
      <td><input name="how_you_learn_abt_iijs[]" type="checkbox" value="office of embassies" <?php if(preg_match('/office of embassies/',$how_you_learn_abt_iijs)){ echo "checked"; }?>/>
            Office Of Embassies</td>
      </tr>
    <tr>
      <td><input name="how_you_learn_abt_iijs[]" type="checkbox" value="website" <?php if(preg_match('/website/',$how_you_learn_abt_iijs)){ echo "checked"; }?>/>
            Website</td>
      <td><input name="how_you_learn_abt_iijs[]" type="checkbox" value="promotional brochures" <?php if(preg_match('/promotional brochures/',$how_you_learn_abt_iijs)){ echo "checked"; }?>/>
            Promotional Brochures</td>
      <td><input name="how_you_learn_abt_iijs[]" type="checkbox" value="Any Other" id="how_you_learn_abt_iijs_other" <?php if(preg_match('/Any Other/',$how_you_learn_abt_iijs)){ echo "checked"; }?>/>
            <span> Any Other</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td colspan="4" class="how_you_learn_abt_iijs_other_id" style="display:none;"><strong>If others, please specify :</strong></td>
      </tr>
    <tr>
      <td colspan="4" class="how_you_learn_abt_iijs_other_id" style="display:none;"><input type="text" class="textField" name="how_you_learn_abt_iijs_other" value="<?php echo $how_you_learn_abt_iijs_other; ?>" /></td>
      </tr>
    <tr>
      <td colspan="4"><strong>Please send me information about :</strong></td>
    </tr>
    <tr>
      <td> <input name="send_info_abt[]" type="checkbox" value="Hotel Packages" <?php if(preg_match('/Hotel Packages/',$send_info_abt)){ echo "checked"; }?>/>
            Hotel Packages</td>
      <td> <input name="send_info_abt[]" type="checkbox" value="Advertising & Sponsorship Opportunities" <?php if(preg_match('/Advertising & Sponsorship Opportunities/',$send_info_abt)){ echo "checked"; }?>/>
            Advertising & Sponsorship Opportunities</td>
      <td><input name="send_info_abt[]" type="checkbox" value="Tours" id="tours" <?php if(preg_match('/Tours/',$send_info_abt)){ echo "checked"; }?>/>
            Tours</td>
      <td> 
        <input name="send_info_abt[]" type="checkbox" value="Domestic Travel Discounts" <?php if(preg_match('/Domestic Travel Discounts/',$send_info_abt)){ echo "checked"; }?> />
            Domestic Travel Discounts</td>
      </tr>
    <tr>
      <td colspan="4" class="send_info_abt_other_id" style="display:none;"><strong>if &quot;tours&quot;, please specify Indian destinations :</strong></td>
      </tr>
    <tr>
     <td class="send_info_abt_other_id" style="display:none;"> <input type="text" class="textField" name="send_info_abt_other" value="<?php echo $send_info_abt_other; ?>" /></td>
      </tr>
      
  </table>
  </td>
</tr>


</table>
</div>
<div style="padding-left:250px; margin-top:5px;">
<input type="hidden" name="action" id="action" value="UPDATE" />
<input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
<input type="hidden" name="registration_id" id="registration_id" value="<?php echo $registration_id;?>" />    	
<input type="submit" value="Update" class="input_submit"/>
<!--<a href="personal_information_IVR.php?id=<?php// echo $id;?>&registration_id=<?php// echo $registration_id;?>"><div class="button">Previous</div></a>
<a href="photo_form_IVR.php?id=<?php// echo $id;?>&registration_id=<?php// echo $registration_id;?>"><div class="button">Next</div></a>-->

</div>
</form>      
</div>

</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>

</body>
</html>
