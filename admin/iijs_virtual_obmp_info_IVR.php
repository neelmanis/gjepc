<?php 
session_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; } ?>

<?php
$action=$_REQUEST['action'];
if($action=='UPDATE')
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
		
	$id	=	intval(filter($_REQUEST['id']));
	$registration_id	=	intval(filter($_REQUEST['registration_id']));
		
	$pd_jewellery=implode(",",$_POST['pd_jewellery']);
	if(preg_match('/Any Other/',$pd_jewellery))
		$pd_jewellery_other=$_POST['pd_jewellery_other'];
	else
		$pd_jewellery_other="";
	
	$obj_of_visit=implode(",",$_POST['obj_of_visit']);
	if(preg_match('/Any Other/',$obj_of_visit))
		$oov_other=$_POST['oov_other'];
	else
		$oov_other="";
		
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
	
	if(!empty($id) && !empty($registration_id)){
	$updatequery="update ivr_registration_details set pd_jewellery='".$pd_jewellery."',pd_jewellery_other='".$pd_jewellery_other."',obj_of_visit='".$obj_of_visit."',oov_other='".$oov_other."',how_you_learn_abt_iijs='".$how_you_learn_abt_iijs."',how_you_learn_abt_iijs_other='".$how_you_learn_abt_iijs_other."',send_info_abt='".$send_info_abt."',send_info_abt_other='".$send_info_abt_other."',would_you_like='".$would_you_like."' where eid='$id' and uid='$registration_id'"; 
	$update_result = $conn ->query($updatequery);
	if(!$update_result){
	echo "Error: ".mysqli_error();	
	}
	$_SESSION['succ_msg']="OBMP info updated successfully";
	header("Location: photo_form_IVR_virtual.php?id=$id&registration_id=$registration_id");
	} else { $_SESSION['error_msg']="Something Missing"; }
	} else { 
	$_SESSION['error_msg']="Invalid Token Error";
	}
}
?>

<?php
	$id	=	intval(filter($_REQUEST['id']));
	$registration_id	=	intval(filter($_REQUEST['registration_id']));
	$sql="SELECT * FROM `ivr_registration_details` WHERE 1 and eid='$id' and uid='$registration_id'";
	$result=$conn ->query($sql);
	$rows=$result->fetch_assoc();
	
	$pd_jewellery=$rows['pd_jewellery'];
	$pd_jewellery_other=$rows['pd_jewellery_other'];
	
	$obj_of_visit=$rows['obj_of_visit'];
	$oov_other=$rows['oov_other'];
	
	$import_frm=$rows['import_frm'];
	$import_frm_other=$rows['import_frm_other'];
	
	$items_interested=$rows['items_interested'];
	$items_interested_other=$rows['items_interested_other'];
	
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
<title>IIJS VIRTUAL &gt; IVR &gt;&gt; OBMP Info</title>
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
    
    	<div class="content_head">IIJS VIRTUAL &gt; IVR >> OBMP Info
       	  <div style="float:right; padding-right:10px; font-size:12px;"><a href="iijs_virtual_ivr.php?action=view">Back to Search</a></div> 
        </div>
    	
<div class="clear"></div>
<div class="content_details1">
<?php 
if($_SESSION['error_msg']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
$_SESSION['error_msg']="";
}
?>

<form name="search" action="" method="POST"> 
<?php token(); ?>

<div id="formAdmin">
	<ul id="tabs" class="tab_1">
    <li id=""><a href="#"><strong>Step 1 Information</strong></a></li>
    <li id=""><a href="#" class="active"><strong>Step 2 OBMP Info</strong></a></li>  
    <li id=""><a href="#" class="lastBg"><strong>Step 3 Photo</strong></a></li>   
    <div class="clear"></div>
    </ul>

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
        <td><input name="pd_jewellery[]" type="checkbox" value="Diamond Jewellery" <?php if(preg_match('/Diamond Jewellery/',$pd_jewellery)){ echo 'checked="checked"'; } ?>/>
       Diamond Jewellery</td>
        <td><input name="pd_jewellery[]" type="checkbox" value="Fine Gold Jewellery" <?php if(preg_match('/Fine Gold Jewellery/',$pd_jewellery)){ echo 'checked="checked"'; } ?>/>
         Fine Gold Jewellery</td>
        <td><input name="pd_jewellery[]" type="checkbox" value="platinum jewellery" <?php if(preg_match('/platinum jewellery/',$pd_jewellery)){ echo ' checked="checked"'; } ?>/>
        platinum jewellery</td>
		<td><input name="pd_jewellery[]" type="checkbox" value="Precious Stone Jewellery" <?php if(preg_match('/Precious Stone Jewellery/',$pd_jewellery)){ echo 'checked="checked"'; } ?>/>
        Precious Stone Jewellery</td>
        <td><input name="pd_jewellery[]" type="checkbox" value="silver jewellery" <?php if(preg_match('/silver jewellery/',$pd_jewellery)){ echo 'checked="checked"'; } ?>/>
        silver jewellery</td>
		<td><input name="pd_jewellery[]" type="checkbox" value="loose diamonds" <?php if(preg_match('/loose diamonds/',$pd_jewellery)){ echo 'checked="checked"'; } ?>/>
        Loose Diamonds</td>
		<td><input name="pd_jewellery[]" type="checkbox" value="Loose Colourstones" <?php if(preg_match('/Loose Colourstones/',$pd_jewellery)){ echo 'checked="checked"'; } ?>/>
       Loose Colourstones</td> 
		<td><input name="pd_jewellery[]" type="checkbox" value="pearls" <?php if(preg_match('/pearls/',$pd_jewellery)){ echo ' checked="checked"'; } ?>/>
		Pearls</td>
    <td><input name="pd_jewellery[]" type="checkbox" value="Lab Grown Diamond" <?php if(preg_match('/Lab Grown Diamond/',$pd_jewellery)){ echo 'checked="checked"'; } ?>/>
    Lab Grown Diamond</td>
    <td><input name="pd_jewellery[]" type="checkbox" value="Coated Diamond" <?php if(preg_match('/Coated Diamond/',$pd_jewellery)){ echo 'checked="checked"'; } ?>/>
    Coated Diamond</td>
    <td><input name="pd_jewellery[]" type="checkbox" value="cvd" <?php if(preg_match('/cvd/',$pd_jewellery)){ echo 'checked="checked"'; } ?>/>
     CVD / HPHT</td>

      </tr>
      
      <tr>
         <td><input name="pd_jewellery[]" type="checkbox" id="other-pd-jewellery" value="Any Other" <?php if(preg_match('/Any Other/',$pd_jewellery)){ echo ' checked="checked"'; } ?>/>Any Other</td>
      </tr>
     
      <tr>
        <td class="pd-jewellery-other-id" style="display:none;"><div class="leftLabel"><strong>If others, please specify :</strong></div>
          <div class="clear"></div>
        </td>
        <td colspan="2" class="pd-jewellery-other-id" style="display:none;"><input type="text" class="textField" name="pd_jewellery_other" id="edit-pd-jewellery-other" value="<?php echo $pd_jewellery_other; ?>" /></td>
        <td>&nbsp;</td>
        </tr>
    
    </table></td>
    </tr>
<tr>
  <td><table border="0" cellspacing="0" cellpadding="0" class="bottomSpace">
    <tr>
      <td colspan="4" class="maroon"><strong>Objective of visiting :</strong></td>
      </tr>
    <tr>
      <td><input name="obj_of_visit[]" type="checkbox" value="place orders" <?php if(preg_match('/place orders/',$obj_of_visit)){ echo "checked"; }?>/>
           Place Orders</td>
      <td><input name="obj_of_visit[]" type="checkbox" value="Meet Regular Suppliers" <?php if(preg_match('/Meet Regular Suppliers/',$obj_of_visit)){ echo "checked"; }?> />
           Meet Regular Suppliers</td>
      <td><input name="obj_of_visit[]" type="checkbox" value="source suppliers" <?php if(preg_match('/source suppliers/',$obj_of_visit)){ echo "checked"; }?> />
            Source New Suppliers</td>
      <td><input name="obj_of_visit[]" type="checkbox" value="joint ventures" <?php if(preg_match('/joint ventures/',$obj_of_visit)){ echo "checked"; }?>/>
             Joint Venture</td>
		<td><input name="obj_of_visit[]" type="checkbox" value="market information" <?php if(preg_match('/market information/',$obj_of_visit)){ echo "checked"; }?>/>
            Market Information</td>
		
    
		<td><input name="obj_of_visit[]" type="checkbox" value="Technology" <?php if(preg_match('/Technology/',$obj_of_visit)){ echo "checked"; }?>/> Technology</td>
		<td><input name="obj_of_visit[]" type="checkbox" value="market information" <?php if(preg_match('/market information/',$obj_of_visit)){ echo "checked"; }?> />Market Information</td>
		<td><input name="obj_of_visit[]" type="checkbox" id="other-obj-of-visit" value="Any Other" <?php if(preg_match('/Any Other/',$obj_of_visit)){ echo "checked"; }?>/>Any Other</td>
    </tr>
   
    <tr>
      <td class="obj-of-visit-other-id" style="display:none;"><strong>If others, please specify :</strong></td>
      <td colspan="2" class="obj-of-visit-other-id" style="display:none;"><input type="text" class="textField" name="oov_other" id="obj-of-visit-other" value="<?php echo $oov_other;?>" /></td>
      <td>&nbsp;</td>
    </tr>
  </table></td>
</tr>
</table>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt bottomSpace">

<tr>
  <td>
  <table border="0" cellspacing="0" cellpadding="0" class="bottomSpace">
    <tr>
      <td colspan="4" class="maroon"><strong>How did you first learn about :</strong></td>
    </tr>
    <tr>
      <td><input name="how_you_learn_abt_iijs[]" type="checkbox" value="Last year visited" <?php if(preg_match('/Last year visited/',$how_you_learn_abt_iijs)){ echo "checked"; }?>/>Last year visited</td>
      <td><input name="how_you_learn_abt_iijs[]" type="checkbox" value="Trade Association" <?php if(preg_match('/Trade Association/',$how_you_learn_abt_iijs)){ echo "checked"; }?>/>Trade Association</td>
      <td><input name="how_you_learn_abt_iijs[]" type="checkbox" value="publications" <?php if(preg_match('/publications/',$how_you_learn_abt_iijs)){ echo "checked"; }?>/>
      Publication</td>
      <td><input name="how_you_learn_abt_iijs[]" type="checkbox" value="trade fairs" <?php if(preg_match('/trade fairs/',$how_you_learn_abt_iijs)){ echo "checked"; }?>/>
       Trade Fair</td>
      </tr>
    <tr>
      <td><input name="how_you_learn_abt_iijs[]" type="checkbox" value="Exhibitors" <?php if(preg_match('/Exhibitors/',$how_you_learn_abt_iijs)){ echo "checked"; }?>/>
            Exhibitors</td>
      <td><input name="how_you_learn_abt_iijs[]" type="checkbox" value="website" <?php if(preg_match('/website/',$how_you_learn_abt_iijs)){ echo "checked"; }?>/>
            Website</td>
		<td><input name="how_you_learn_abt_iijs[]" type="checkbox" value="Newsletter & Emailers" <?php if(preg_match('/Newsletter & Emailers/',$how_you_learn_abt_iijs)){ echo "checked"; }?>/> Newsletter & Emailers </td>
		<td><input name="how_you_learn_abt_iijs[]" type="checkbox" value="Road Shows" <?php if(preg_match('/Road Shows/',$how_you_learn_abt_iijs)){ echo "checked"; }?>/>
            Road Shows </td>
		<td><input name="how_you_learn_abt_iijs[]" type="checkbox" value="promotional brochures" <?php if(preg_match('/promotional brochures/',$how_you_learn_abt_iijs)){ echo "checked"; }?>/>
            Promotional Brochures </td>
		<td><input name="how_you_learn_abt_iijs[]" type="checkbox" value="sms" <?php if(preg_match('/sms/',$how_you_learn_abt_iijs)){ echo "checked"; }?>/>
            SMS </td>		
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
<a href="photo_form_IVR_virtual?id=<?php// echo $id;?>&registration_id=<?php// echo $registration_id;?>"><div class="button">Next</div></a>-->

</div>
</form>      
</div>

</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>

</body>
</html>
