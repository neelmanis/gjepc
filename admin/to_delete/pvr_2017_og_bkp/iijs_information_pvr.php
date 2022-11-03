<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
$action=$_REQUEST['action'];
if($action=='UPDATE')
{
	$id=mysql_real_escape_string($_REQUEST['id']);
	$registration_id=mysql_real_escape_string($_REQUEST['registration_id']);
	$contact_person = mysql_real_escape_string($_POST["first_name"])." ".mysql_real_escape_string($_POST["last_name"]);
	$designation = mysql_real_escape_string($_POST["designation"]);  
	$company_name = mysql_real_escape_string($_POST["company_name"]); 
	$address1 = mysql_real_escape_string($_POST["address1"]);
	$address2 = mysql_real_escape_string($_POST["address2"]);
	$address3 = mysql_real_escape_string($_POST["address3"]);
	$city = mysql_real_escape_string($_POST["city"]);
	$pincode = mysql_real_escape_string($_POST["pincode"]);
	$state = mysql_real_escape_string($_POST["state"]);
	$telephone_no_office = mysql_real_escape_string($_POST["telephone_no_office"]);
	$telephone_no_resi = mysql_real_escape_string($_POST["telephone_no_resi"]);
	$fax_no = mysql_real_escape_string($_POST["fax_no"]);
	$mobile = mysql_real_escape_string($_POST["mobile"]);
	$email = mysql_real_escape_string($_POST["email"]);
	$website = mysql_real_escape_string($_POST["website"]);
		
	$membership_id = mysql_real_escape_string($_POST["membership_id"]);
	
	if($membership_id==1)
		$membership_id=mysql_real_escape_string($_POST["member_id"]);
	else
		$membership_id=0;
		
	$member_of_gjf = mysql_real_escape_string($_POST["member_of_gjf"]);
	$member_of_any_other_local_assoc = mysql_real_escape_string($_POST["member_of_any_other_local_assoc"]);
	
	if($member_of_any_other_local_assoc==1)
		$member_of_any_other_local_assoc_specify = mysql_real_escape_string($_POST["member_of_any_other_local_assoc_specify"]);
	else
		$member_of_any_other_local_assoc_specify = "";

	$do_you_sell_brand_jewellery = mysql_real_escape_string($_POST["do_you_sell_brand_jewellery"]);
	$is_your_shop = mysql_real_escape_string($_POST["is_your_shop"]);
	$did_you_ever_visit_iijs = mysql_real_escape_string($_POST["did_you_ever_visit_iijs"]);
	$did_you_ever_visit_signature = mysql_real_escape_string($_POST["did_you_ever_visit_signature"]);
	
	$how_do_you_learn_about_show=implode(",", $_POST['how_do_you_learn_about_show']);
	
	if(preg_match('/Any Other/',$how_do_you_learn_about_show))
		$how_do_you_learn_about_show_other = mysql_real_escape_string($_POST["how_do_you_learn_about_show_other"]);
	else
		$how_do_you_learn_about_show_other = "";
	
	$information_approve=mysql_real_escape_string($_REQUEST['information_approve']);
	if($information_approve=='Y')
	{
	$information_reason="";
	}else
	{
	$information_reason=mysql_real_escape_string($_REQUEST['information_reason']);	
	}
	$updatesql="update pvr_registration_details set contact_person='".$contact_person."',designation='".$designation."',company_name='".$company_name."',address1='".$address1."',address2='".$address2."',address3='".$address3."',city='".$city."',pincode='".$pincode."',state='".$state."',telephone_no_office='".$telephone_no_office."',telephone_no_resi='".$telephone_no_resi."',fax_no='".$fax_no."',mobile='".$mobile."',email='".$email."',website='".$website."',membership_id='".$membership_id."',member_of_gjf='".$member_of_gjf."',member_of_any_other_local_assoc='".$member_of_any_other_local_assoc."',member_of_any_other_local_assoc_specify='".$member_of_any_other_local_assoc_specify."',do_you_sell_brand_jewellery='".$do_you_sell_brand_jewellery."',is_your_shop='".$is_your_shop."',did_you_ever_visit_iijs='".$did_you_ever_visit_iijs."',did_you_ever_visit_signature='".$did_you_ever_visit_signature."',how_do_you_learn_about_show='".$how_do_you_learn_about_show."',how_do_you_learn_about_show_other='".$how_do_you_learn_about_show_other."',information_approve='".$information_approve."',information_reason='".$information_reason."',modified_dt=NOW() where id='$id' and uid='$registration_id'";
	
	if (!mysql_query($updatesql))
	{
		die('Error: ' . mysql_error());
	}

$_SESSION['succ_msg']="Information updated successfully";
header("Location: iijs_obmp_profile_pvr.php?id=$id&registration_id=$registration_id");

}


?>

<?php
$id=mysql_real_escape_string($_REQUEST['id']);
$registration_id=mysql_real_escape_string($_REQUEST['registration_id']);
$sql="SELECT * FROM `pvr_registration_details` WHERE 1 and id='$id' and uid='$registration_id'";
$result=mysql_query($sql);
$rows=mysql_fetch_array($result);

$contact_person = explode(" ",$rows['contact_person']);
$first_name=$contact_person[0];
$last_name=$contact_person[1];
$designation = $rows["designation"];  
$company_name = $rows["company_name"]; 
$address1 = $rows["address1"];
$address2 = $rows["address2"];
$address3 = $rows["address3"];
$city = $rows["city"];
$pincode = $rows["pincode"];
$state = $rows["state"];
$telephone_no_office = $rows["telephone_no_office"];
$telephone_no_resi = $rows["telephone_no_resi"];
$fax_no = $rows["fax_no"];
$mobile = $rows["mobile"];
$email = $rows["email"];
$website = $rows["website"];
$membership_id = $rows["membership_id"];
$member_of_gjf = $rows["member_of_gjf"];
$member_of_any_other_local_assoc = $rows["member_of_any_other_local_assoc"];
$member_of_any_other_local_assoc_specify = $rows["member_of_any_other_local_assoc_specify"];
$do_you_sell_brand_jewellery = $rows["do_you_sell_brand_jewellery"];
$is_your_shop = $rows["is_your_shop"];
$did_you_ever_visit_iijs = $rows["did_you_ever_visit_iijs"];
$did_you_ever_visit_signature = $rows["did_you_ever_visit_signature"];
$how_do_you_learn_about_show=$rows['how_do_you_learn_about_show'];
$how_do_you_learn_about_show_other = $rows["how_do_you_learn_about_show_other"];
$information_approve=$rows['information_approve'];
$information_reason=$rows['information_reason'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IIJS &gt; PVR &gt;&gt; Personal Information</title>

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
<script> 
 function check_disable(){
    if ($('input[name=\'information_approve\']:checked').val() == "N"){
        $("#information_reason_text").show();
    }
    else{
        $("#information_reason_text").hide();
    }	
}
</script>
</head>

<body>


<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> PVR > Personal Information</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">IIJS >> PVR >> Personal Information
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

<div id="form">
    <ul id="tabs" class="tab_1">
    <li id=""><a href="#" class="active"><strong>Step 1 Information</strong></a></li>
    <li id=""><a href="#"><strong>Step 2 OBMP Info</strong></a></li>  
    <li id=""><a href="#"><strong>Step 3 Payment</strong></a></li>
    <li id=""><a href="#" class="lastBg"><strong>Step 4 Photo</strong></a></li>   
    <div class="clear"></div>
    </ul>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt pvr" >
<tr class="orange1">
    <td colspan="11" >Personal Information</td>
</tr>
<tr>
    <td colspan="11" >
<div id="form">

<div class="field">
<label>First Name : </label>
<input name="first_name" id="first_name" type="text"  class="textField" value="<?php echo $first_name; ?>"/>
</div>

<div class="field">
<label>Last Name : </label>
<input name="last_name" type="text" id="last_name" value="<?php echo $last_name; ?>"  class="textField"/>
</div>

<div class="field">
<label>Designation : </label>
<input name="designation" id="designation" type="text"  class="textField" value="<?php echo $designation; ?>"/>
</div>

<div class="field">
<label>Company Name : </label>
<input name="company_name" id="company_name" type="text"  class="textField" value="<?php echo $company_name; ?>" />
</div>

<div class="field">
<div class="leftTitle">Address1  : <sup>*</sup> </div>
<textarea name="address1" id="address1" cols="" rows="" class="textField"><?php echo $address1; ?></textarea>
</div>

<div class="field">
<div class="leftTitle">Address2  : <sup>*</sup> </div>
<textarea name="address2" id="address2" cols="" rows="" class="textField"><?php echo $address2; ?></textarea>
</div>

<div class="field">
<div class="leftTitle">Address3  : <sup>*</sup> </div>
<textarea name="address3" id="address3" cols="" rows="" class="textField"><?php echo $address3; ?></textarea>
</div>

<div class="field">
<label>State / Province : <sup>*</sup></label>
<?php 
        $query=mysql_query("SELECT * from state_master WHERE country_code = 'IND'");
	   ?>
        <select name="state" id="state" class="textField">
        <option value="">--Select State--</option>
        <?php while($result=mysql_fetch_array($query)){?>
        <option value="<?php echo $result['state_name'];?>" <?php if($result['state_name']==$state)echo "selected"; ?> ><?php echo $result['state_name']; ?></option>
       <?php }?>
        </select>
</div>

<div class="field">
<label>City : <sup>*</sup></label>
<input name="city" id="city" type="text"  class="textField" value="<?php echo $city; ?>"/>
</div>

<div class="field">
<label>Pincode : <sup>*</sup></label>
<input name="pincode" id="pincode" type="text"  class="textField" value="<?php echo $pincode; ?>" />
</div>


<div class="field">
<label style="padding-top:0px;">Landline1 (with country & city code)<br />
(e.g. 114422345654) : <sup>*</sup></label>
 <input name="telephone_no_office" id="telephone_no_office" type="text"  class="textField" value="<?php echo $telephone_no_office; ?>"/>
<div class="clear"></div>

</div>

<div class="field">
<label style="padding-top:0px;">Landline2 (with country & city code)<br />
(e.g. 114422345654) :</label>
<input name="telephone_no_resi" id="telephone_no_resi" type="text"  class="textField" value="<?php echo $telephone_no_resi; ?>" />
<div class="clear"></div>
</div>


<div class="field">
<label>Mobile Number (e.g. 114422345654): <sup>*</sup></label>
<input name="mobile" id="mobile" type="text"  class="textField" value="<?php echo $mobile; ?>"/>
<div class="clear"></div>
</div>


<div class="field">
<label style="padding-top:0px;">Fax (with country & city code) <br />
  (e.g. 114422345654) :</label>
<input name="fax_no" id="fax_no" type="text"  class="textField" value="<?php echo $fax_no; ?>"/>
<div class="clear"></div>
</div>


<div class="field">
<label>Website :</label>
<input name="website" id="website" type="text"  class="textField" value="<?php echo $website; ?>"/>
<div class="clear"></div>
</div>

<div class="field">
<label>Email : <sup>*</sup></label>
<input name="email" id="email" type="text"  class="textField" value="<?php echo $email; ?>" />
<div class="clear"></div>
</div>


<div class="field">
<div class="leftTitle" style="padding-top:0px;">Gjepc Membership : <sup>*</sup></div>
<div class="rightContent">

<span>Yes</span><input name="membership_id" id="membership_id_y" type="radio" value="1"  class="radio radioBtn"  <?php if($membership_id) echo "checked";?>/> 
<span>No</span><input name="membership_id" id="membership_id_n" type="radio" value="0" class="radio radioBtn" <?php if(!$membership_id) echo "checked";?>/>

</div>
<div class="clear"></div>
</div>


<div class="field" id="gjepc_member_id">
<label>Gjepc Membership ID : <sup>*</sup> </label>
<input name="" type="text"  class="textField"/>
</div>


<div class="field">
<div class="leftTitle" style="padding-top:0px;">Member of GJF : <sup>*</sup></div>
<div class="rightContent">
<span>Yes</span>
<input name="member_of_gjf" id="member_of_gjf" type="radio" value="1"  class="radio radioBtn" <?php if($member_of_gjf) echo "checked";?>/> 
<span>No</span>
<input name="member_of_gjf" id="member_of_gjf" type="radio" value="0" class="radio radioBtn" <?php if(!$member_of_gjf) echo "checked";?> />
</div>
<div class="clear"></div>

</div>

<div class="field">
<div class="leftTitle" style="padding-top:0px;">Member of any other Local <br />
  Association : <sup>*</sup></div>
<div class="rightContent">
<span>Yes</span>
<input name="member_of_any_other_local_assoc" id="member_of_any_other_local_assoc_y" type="radio" value="1"  class="radio radioBtn" <?php if($member_of_any_other_local_assoc) echo "checked";?> /> 
<span>No</span>
<input name="member_of_any_other_local_assoc" id="member_of_any_other_local_assoc_n" type="radio" value="0" class="radio radioBtn" <?php if(!$member_of_any_other_local_assoc) echo "checked";?> /> 
</div>

<div class="clear" style="margin-bottom:8px;"></div>


<div id="member_of_assoc_specify">
<label> Please Specify :</label> <input name="member_of_any_other_local_assoc_specify" id="member_of_any_other_local_assoc_specify" type="text" class="textField" value="<?php echo $member_of_any_other_local_assoc_specify; ?>" />
</div>

</div>


<div class="field">
<div class="leftTitle" style="padding-top:0px;">Do you sell Branded Jewellery : <sup>*</sup></div>

<div class="rightContent">
<span>Yes</span>
<input name="do_you_sell_brand_jewellery" id="do_you_sell_brand_jewellery" type="radio" value="1"  class="radio radioBtn" <?php if($do_you_sell_brand_jewellery) echo "checked";?>/> 
<span>No</span>
<input name="do_you_sell_brand_jewellery" id="do_you_sell_brand_jewellery" type="radio" value="0" class="radio radioBtn" <?php if(!$do_you_sell_brand_jewellery) echo "checked";?>/>
</div>
<div class="clear"></div>

</div>



<div class="field">

<div class="leftTitle" style="padding-top:0px;">Is your shop : <sup>*</sup></div>

<div class="rightContent">
<span>Owned</span>
<input name="is_your_shop" id="is_your_shop" type="radio" value="1"  class="radio radioBtn" <?php if($is_your_shop) echo "checked";?>/> 
<span>Rented</span>
<input name="is_your_shop" id="is_your_shop" type="radio" value="0" class="radio radioBtn" <?php if(!$is_your_shop) echo "checked";?>/>
</div>

<div class="clear"></div>

</div>

<div class="field">

<div class="leftTitle" style="padding-top:0px;">Did you ever visit IIJS : <sup>*</sup></div>

<div class="rightContent">
<span>Yes</span>
<input name="did_you_ever_visit_iijs" id="did_you_ever_visit_iijs" type="radio" value="1"  class="radio radioBtn" <?php if($did_you_ever_visit_iijs) echo "checked";?>/> 
<span>No</span>
<input name="did_you_ever_visit_iijs" id="did_you_ever_visit_iijs" type="radio" value="0" class="radio radioBtn" <?php if(!$did_you_ever_visit_iijs) echo "checked";?>/>
</div>
<div class="clear"></div>

</div>


<div class="field">

<div class="leftTitle" style="padding-top:0px;">Did you ever visit Signature : <sup>*</sup></div>

<div class="rightContent">
<span>Yes</span>
<input name="did_you_ever_visit_signature" id="did_you_ever_visit_signature" type="radio" value="yes"  class="radio radioBtn" <?php if($did_you_ever_visit_signature) echo "checked";?>/> 
<span>No</span>
<input name="did_you_ever_visit_signature" id="did_you_ever_visit_signature" type="radio" value="no" class="radio radioBtn" <?php if(!$did_you_ever_visit_signature) echo "checked";?>/>
</div>
<div class="clear"></div>

</div>  


<div class="field bottomSpace">

<div class="leftTitle" style="padding-top:0px;">How did you learn about the show :  <sup>*</sup></div>

<div class="rightContent">
   
<ul class="matterText">
           <li>
            <input name="how_do_you_learn_about_show[]" id="how_do_you_learn_about_show" type="checkbox" value="Trade Associations" <?php if(preg_match('/Trade Associations/',$how_do_you_learn_about_show)){echo 'checked="checked"'; } ?> />
            <span>Trade Associations</span>
          </li>
            
         <li>
            <input name="how_do_you_learn_about_show[]" id="how_do_you_learn_about_show" type="checkbox" value="Website" <?php if(preg_match('/Website/',$how_do_you_learn_about_show)){echo 'checked="checked"'; } ?> />
            <span> Website</span>
          </li>
            
         <li>
            <input name="how_do_you_learn_about_show[]" id="how_do_you_learn_about_show" type="checkbox" value="Promotional Brochures" <?php if(preg_match('/Promotional Brochures/',$how_do_you_learn_about_show)){echo 'checked="checked"'; } ?> />
            <span>Promotional Brochures</span>
         </li>
            
        <li>
            <input name="how_do_you_learn_about_show[]" id="how_do_you_learn_about_show" type="checkbox" value="Publications" <?php if(preg_match('/Publications/',$how_do_you_learn_about_show)){echo 'checked="checked"'; } ?> />
            <span> Publications</span>
        </li>
        
        <li>
            <input name="how_do_you_learn_about_show[]" id="how_do_you_learn_about_show" type="checkbox" value="Newsletter" <?php if(preg_match('/Newsletter/',$how_do_you_learn_about_show)){echo 'checked="checked"'; } ?> />
            <span> Newsletter</span>
        </li>
            
    <li>
        <input name="how_do_you_learn_about_show[]" id="how_do_you_learn_about_show" type="checkbox" value="Exhibitors" <?php if(preg_match('/Exhibitors/',$how_do_you_learn_about_show)){echo 'checked="checked"'; } ?> />
        <span> Exhibitors</span>
    </li>
            
            
    <li>
        <input name="how_do_you_learn_about_show[]" id="how_do_you_learn_about_show" type="checkbox" value="Trade Fairs" <?php if(preg_match('/Trade Fairs/',$how_do_you_learn_about_show)){echo 'checked="checked"'; } ?> />
        <span>Trade Fairs</span>
    </li>
            
    <li>
        <input name="how_do_you_learn_about_show[]" id="how_do_you_learn_about_show" type="checkbox" value="Road Shows" <?php if(preg_match('/Road Shows/',$how_do_you_learn_about_show)){echo 'checked="checked"'; } ?> />
        <span> Road Shows</span>
    </li>
            
    <li>
        <input name="how_do_you_learn_about_show[]" id="how_do_you_learn_about_show_other" type="checkbox" value="Any Other" <?php if(preg_match('/Any Other/',$how_do_you_learn_about_show)){echo 'checked="checked"'; } ?> />
        <span>Any Other</span>
    </li>
</ul>
</div>
<div class="clear" style="margin-bottom:8px;"></div>


<div id="how_do_you_learn_about_show_specify">

<label style="min-width:179px;"> Please Specify :</label><input name="how_do_you_learn_about_show_other"  type="text" class="textField" value="<?php echo $how_do_you_learn_about_show_other; ?>" />

</div>

</div>     
<div class="field">

<div class="leftTitle" style="padding-top:0px;">Information Approval Status : <sup>*</sup></div>

<div class="rightContent">
<input type="radio" name="information_approve" id="information_approve" value="Y" onchange="check_disable()" <?php if($information_approve=="Y"){?> checked="checked" <?php }?> /> Approve 
<input type="radio" name="information_approve" id="information_approve" value="N" onchange="check_disable()"  <?php if($information_approve=="N"){?> checked="checked" <?php }?> /> Disapprove
<p id="information_reason_text" <?php if($information_approve=="Y"){?> style="display:none;" <?php }?>>
<textarea name="information_reason" cols="40" rows="6" id="information_reason"  ><?php echo $information_reason;?></textarea>
</p>
</div>
<div class="clear"></div>

</div>

</div>
</td>
</tr>
            
</table>   
            
<div style="padding-left:250px; margin-top:5px;">
<input type="hidden" name="action" id="action" value="UPDATE" />
<input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
<input type="hidden" name="registration_id" id="registration_id" value="<?php echo $registration_id;?>" />    	
<input type="submit" value="Update" class="input_submit"/>
<a href="iijs_obmp_profile_pvr.php?id=<?php echo $id;?>&registration_id=<?php echo $registration_id;?>"><div class="button">Next</div></a>
</div>
</div>


</form>      
</div>

</div>        
</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
