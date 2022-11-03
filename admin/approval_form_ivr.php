<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>

<?php
$action=$_REQUEST['action'];
if($action=='UPDATE')
{
	
	$id=mysql_real_escape_string($_REQUEST['id']);
	$registration_id=mysql_real_escape_string($_REQUEST['registration_id']);
	$personal_info_approval=mysql_real_escape_string($_REQUEST['personal_info_approval']);	
	$personal_info_reason=mysql_real_escape_string($_REQUEST['personal_info_reason']);
	$photo_approval=mysql_real_escape_string($_REQUEST['photo_approval']);
	$photo_reason=mysql_real_escape_string($_REQUEST['photo_reason']);
	$valid_passport_copy_approval=mysql_real_escape_string($_REQUEST['valid_passport_copy_approval']);
	$valid_passport_copy_reason=mysql_real_escape_string($_REQUEST['valid_passport_copy_reason']);
	$visiting_card_approval=mysql_real_escape_string($_REQUEST['visiting_card_approval']);
	$visiting_card_reason=mysql_real_escape_string($_REQUEST['visiting_card_reason']);
	$nri_photo_approval=mysql_real_escape_string($_REQUEST['nri_photo_approval']);
	$nri_photo_reason=mysql_real_escape_string($_REQUEST['nri_photo_reason']);
	
	$updatequery="update ivr_registration_details set personal_info_approval='".$personal_info_approval."',personal_info_reason='".$personal_info_reason."',photo_approval='".$photo_approval."',photo_reason='".$photo_reason."',valid_passport_copy_approval='".$valid_passport_copy_approval."',valid_passport_copy_reason='".$valid_passport_copy_reason."',visiting_card_approval='".$visiting_card_approval."',visiting_card_reason='".$visiting_card_reason."',nri_photo_approval='".$nri_photo_approval."',nri_photo_reason='".$nri_photo_reason."' where eid='$id' and uid='$registration_id'"; 
    
	$update_result = mysql_query($updatequery);
	if(!$update_result){
		echo "Error: ".mysql_error();	
	}

$_SESSION['succ_msg']="Application updated successfully";
header("Location:ivr.php");

}

?>

<?php
$id=mysql_real_escape_string($_REQUEST['id']);
$registration_id=mysql_real_escape_string($_REQUEST['registration_id']);
	$sql="SELECT * FROM `ivr_registration_details` WHERE 1 and eid='$id' and uid='$registration_id'";
	$result=mysql_query($sql);
	$rows=mysql_fetch_array($result);

	$personal_info_approval=$rows['personal_info_approval'];	
	$personal_info_reason=$rows['personal_info_reason'];
	$photo_approval=$rows['photo_approval'];
	$photo_reason=$rows['photo_reason'];
	$valid_passport_copy_approval=$rows['valid_passport_copy_approval'];
	$valid_passport_copy_reason=$rows['valid_passport_copy_reason'];
	$visiting_card_approval=$rows['visiting_card_approval'];
	$visiting_card_reason=$rows['visiting_card_reason'];
	$nri_photo_approval=$rows['nri_photo_approval'];
	$nri_photo_reason=$rows['nri_photo_reason'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IVR > Approval Form</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />

<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>      
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

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

<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-size: 20px;
}
.style2 {color: #FF6600}
-->
</style>
<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<script> 
function check_disable1(){
    if ($('input[name=\'personal_info_approval\']:checked').val() == "N"){
        $("#personal_info_reason_text").show();
    }
    else{
        $("#personal_info_reason_text").hide();
    }	
}

function check_disable2(){
    if ($('input[name=\'photo_approval\']:checked').val() == "N"){
        $("#photo_reason_text").show();
    }
    else{
        $("#photo_reason_text").hide();
    }	
}

function check_disable3(){
    if ($('input[name=\'valid_passport_copy_approval\']:checked').val() == "N"){
        $("#valid_passport_copy_reason_text").show();
    }
    else{
        $("#valid_passport_copy_reason_text").hide();
    }	
}

function check_disable4(){
    if ($('input[name=\'visiting_card_approval\']:checked').val() == "N"){
        $("#visiting_card_reason_text").show();
    }
    else{
        $("#visiting_card_reason_text").hide();
    }	
}

function check_disable5(){
    if ($('input[name=\'nri_photo_approval\']:checked').val() == "N"){
        $("#nri_photo_reason_text").show();
    }
    else{
        $("#nri_photo_reason_text").hide();
    }	
}
</script>


</head>

<body>

<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>


<div class="clear">

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > IVR > Approval Form</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">IVR > Approval Form
        <div style="float:right; padding-right:10px; font-size:12px;"><a href="pvr.php">Back to Search</a></div>

    	</div>	
<form action="" method="post">  
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
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
<!---------------------------------------------------------------------------------->

<tr class="orange1">
	<td colspan="12" >Information Approval</td>
</tr>
<tr>
    <td width="47%"><input type="radio" name="personal_info_approval" id="personal_info_approval" value="Y" onchange="check_disable1()" <?php if($personal_info_approval=="Y"){?> checked="checked" <?php }?> /><span class="text6">Approve</span></td>
    <td width="47%"><input type="radio" name="personal_info_approval" id="personal_info_approval" value="N" onchange="check_disable1()"  <?php if($personal_info_approval=="N"){?> checked="checked" <?php }?> /><span class="text6">Disapprove</span></td>	  
</tr>
      
<tr id="personal_info_reason_text" <?php if($personal_info_approval=="Y"){?> style="display:none;" <?php }?>>
	<td bgcolor="#FFFFFF" colspan="4" ><textarea name="personal_info_reason" cols="80" rows="8" id="personal_info_reason"  ><?php echo $personal_info_reason;?></textarea></td>
</tr>
</table>
<br />
<!---------------------------------------------------------------------------------->  
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
<tr class="orange1">
	<td colspan="12" >Photo Approval</td>
</tr>
<tr>
    <td width="47%"><input type="radio" name="photo_approval" id="photo_approval" value="Y" onchange="check_disable2()" <?php if($photo_approval=="Y"){?> checked="checked" <?php }?> /><span class="text6">Approve</span></td>
    <td width="47%"><input type="radio" name="photo_approval" id="photo_approval" value="N" onchange="check_disable2()"  <?php if($photo_approval=="N"){?> checked="checked" <?php }?> /><span class="text6">Disapprove</span></td>	  
</tr>
      
<tr id="photo_reason_text" <?php if($photo_approval=="Y"){?> style="display:none;" <?php }?>>
	<td bgcolor="#FFFFFF" colspan="4" ><textarea name="photo_reason" cols="80" rows="8" id="photo_reason"  ><?php echo $photo_reason;?></textarea></td>
</tr>
</table>
<br />
<!---------------------------------------------------------------------------------->  
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
<tr class="orange1">
	<td colspan="12" >Passport Approval</td>
</tr>
      
<tr >
    <td width="47%"><input type="radio" name="valid_passport_copy_approval" id="valid_passport_copy_approval" value="Y" onchange="check_disable3()" <?php if($valid_passport_copy_approval=="Y"){?> checked="checked" <?php }?> /><span class="text6">Approve</span></td>
    <td width="47%"><input type="radio" name="valid_passport_copy_approval" id="valid_passport_copy_approval" value="N" onchange="check_disable3()"  <?php if($valid_passport_copy_approval=="N"){?> checked="checked" <?php }?> /><span class="text6">Disapprove</span></td>	  
</tr>
      
<tr id="valid_passport_copy_reason_text" <?php if($valid_passport_copy_approval=="Y"){?> style="display:none;" <?php }?>>
	<td bgcolor="#FFFFFF" colspan="4" ><textarea name="valid_passport_copy_reason" cols="80" rows="8" id="valid_passport_copy_reason"  ><?php echo $valid_passport_copy_reason;?></textarea></td>
</tr>
</table>
<br />

<!---------------------------------------------------------------------------------->  
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
<tr class="orange1">
	<td colspan="12" >Visiting Card Approval</td>
</tr> 
      
<tr>
    <td width="47%"><input type="radio" name="visiting_card_approval" id="visiting_card_approval" value="Y" onchange="check_disable4()" <?php if($visiting_card_approval=="Y"){?> checked="checked" <?php }?> /><span class="text6">Approve</span></td>
    <td width="47%"><input type="radio" name="visiting_card_approval" id="visiting_card_approval" value="N" onchange="check_disable4()"  <?php if($visiting_card_approval=="N"){?> checked="checked" <?php }?> /><span class="text6">Disapprove</span></td>	  
</tr>
      
<tr id="visiting_card_reason_text" <?php if($visiting_card_approval=="Y"){?> style="display:none;" <?php }?>>
	<td bgcolor="#FFFFFF" colspan="4" ><textarea name="visiting_card_reason" cols="80" rows="8" id="visiting_card_reason"  ><?php echo $visiting_card_reason;?></textarea></td>
</tr>
</table>
<br />

<!---------------------------------------------------------------------------------->  
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
<tr class="orange1">
	<td colspan="12" >NRI Photo Approval</td>
</tr> 
<tr>
	<td width="47%"><input type="radio" name="nri_photo_approval" id="nri_photo_approval" value="Y" onchange="check_disable5()" <?php if($nri_photo_approval=="Y"){?> checked="checked" <?php }?>/><span class="text6">Approve</span></td>
	<td width="47%"><input type="radio" name="nri_photo_approval" id="nri_photo_approval" value="N" onchange="check_disable5()"<?php if($nri_photo_approval=="N"){?> checked="checked" <?php }?>/><span class="text6">Disapprove</span></td>	  
</tr>
     
<tr id="nri_photo_reason_text" <?php if($nri_photo_approval=="Y"){?> style="display:none;" <?php }?>>
	<td bgcolor="#FFFFFF" colspan="3" ><textarea name="nri_photo_reason" cols="80" rows="8" id="nri_photo_reason" ><?php echo $nri_photo_reason;?></textarea>
	</td>
</tr>
    
</table>
</div>
<div style="padding-left:10px; margin-top:5px;">
<input type="hidden" name="action" id="action" value="UPDATE" />
<input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
<input type="hidden" name="registration_id" id="registration_id" value="<?php echo $registration_id;?>" />    	
<input type="submit" value="Submit" class="input_submit"/>
<a href="photo_form_IVR.php?id=<?php echo $id;?>&registration_id=<?php echo $registration_id;?>">
<div class="button">Previous</div></a>

</div>
</form>
</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
