<?php session_start(); ob_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
$action=$_REQUEST['action'];
if($action=='UPDATE')
{
	$id=mysql_real_escape_string($_REQUEST['id']);
	$registration_id=mysql_real_escape_string($_REQUEST['registration_id']);
	$indian_passport = mysql_real_escape_string($_POST["indian_passport"]);
	$title = mysql_real_escape_string($_POST["title"]);  
	$first_name = mysql_real_escape_string($_POST["first_name"]); 
	$last_name = mysql_real_escape_string($_POST["last_name"]);
	$designation = mysql_real_escape_string($_POST["designation"]);
	$passport_no = mysql_real_escape_string($_POST["passport_no"]);
	$valid_upto = mysql_real_escape_string($_POST["valid_upto"]);
	$issue_place = mysql_real_escape_string($_POST["issue_place"]);
	$origin = mysql_real_escape_string($_POST["origin"]);
	$company_name = mysql_real_escape_string($_POST["company_name"]);
	$office_add = mysql_real_escape_string($_POST["office_add"]);
	$city = mysql_real_escape_string($_POST["city"]);
	$state = mysql_real_escape_string($_POST["state"]);
	$country = mysql_real_escape_string($_POST["country"]);
	$postal_code = mysql_real_escape_string($_POST["postal_code"]);
	$tel_no = mysql_real_escape_string($_POST["tel_no"]);
	$mob_no = mysql_real_escape_string($_POST["mob_no"]);
	$fax_no = mysql_real_escape_string($_POST["fax_no"]);
	$email = mysql_real_escape_string($_POST["email"]);
	$website = mysql_real_escape_string($_POST["website"]);
	$company_profile = mysql_real_escape_string($_POST["company_profile"]);	
	
	$apply_visa=$_POST["apply_visa"];
		
	if($apply_visa=="yes")
	{
		$apply_visa=1;
		$apply_visa_to=mysql_real_escape_string($_POST["apply_visa_to"]);
		$apply_visa_city=mysql_real_escape_string($_POST["apply_visa_city"]);
	}else{
		$apply_visa=0;
		$apply_visa_to="";
		$apply_visa_city="";
	}
	
	$personal_info_approval=mysql_real_escape_string($_POST['personal_info_approval']);	
	if($personal_info_approval=='Y')
	{
	$personal_info_reason="";
	}else
	{
	$personal_info_reason=mysql_real_escape_string($_POST['personal_info_reason']);	
	}
	
	$updatesql="update ivr_registration_details set indian_passport='".$indian_passport."',title='".$title."',first_name='".$first_name."',last_name='".$last_name."',designation='".$designation."',passport_no='".$passport_no."',valid_upto='".$valid_upto."',issue_place='".$issue_place."',origin='".$origin."',company_name='".$company_name."',office_add='".$office_add."',city='".$city."',state='".$state."',country='".$country."',postal_code='".$postal_code."',tel_no='".$tel_no."',mob_no='".$mob_no."',fax_no='".$fax_no."',email='".$email."',website='".$website."',company_profile='".$company_profile."',apply_visa='".$apply_visa."', apply_visa_to='".$apply_visa_to."', apply_visa_city='".$apply_visa_city."',personal_info_approval='".$personal_info_approval."',personal_info_reason='".$personal_info_reason."' where eid='$id' and uid='$registration_id'";
	
	if (!mysql_query($updatesql))
	{
		die('Error: ' . mysql_error());
	}

$_SESSION['succ_msg']="Information updated successfully";
header("Location: iijs_obmp_info_IVR.php?id=$id&registration_id=$registration_id");

}


?>

<?php
$id=mysql_real_escape_string($_REQUEST['id']);
$registration_id=mysql_real_escape_string($_REQUEST['registration_id']);
$sql="SELECT * FROM `ivr_registration_details` WHERE 1 and eid='$id' and uid='$registration_id'";
$result=mysql_query($sql);
$rows=mysql_fetch_array($result);

$indian_passport=$rows['indian_passport'];
$title=$rows['title'];
$first_name=$rows['first_name'];
$last_name=$rows['last_name'];
$designation=$rows['designation'];
$passport_no=$rows['passport_no'];
$valid_upto=$rows['valid_upto'];
$issue_place=$rows['issue_place'];
$origin=$rows['origin'];
$company_name=$rows['company_name'];
$office_add=$rows['office_add'];
$city=$rows['city'];
$state=$rows['state'];
$country=$rows['country'];
$postal_code=$rows['postal_code'];
$tel_no = $rows["tel_no"];
$mob_no = $rows["mob_no"];
$fax_no = $rows["fax_no"];
$email=$rows['email'];
$website=$rows['website'];
$company_profile=$rows['company_profile'];

$apply_visa=$rows["apply_visa"];
$apply_visa_to=$rows["apply_visa_to"];
$apply_visa_city=$rows["apply_visa_city"];


$personal_info_approval=$rows['personal_info_approval'];	
$personal_info_reason=$rows['personal_info_reason'];
if($personal_info_reason=="")
{
$personal_info_reason="Kindly upload all mandatory Personal Information";	
}
$passport_fid=$rows['passport_fid'];
$visit_card_fid=$rows['visit_card_fid'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IIJS &gt; IVR &gt;&gt; Personal Information</title>

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
	$('#valid_upto').datepick();
	
});
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
<!-- calendar starts-->
<link rel="stylesheet" href="calendar/css/jquery-ui.css" />
  <script src="calendar/js/jquery-1.9.1.js"></script>
  <script src="calendar/js/jquery-ui.js"></script>
  <!--<link rel="stylesheet" href="/resources/demos/style.css" />-->
  <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>
<!-- calendar ends-->

<style type="text/css">
<!--
.style1 {color: #FF0000}
.style2 {
	font-size: 16px;
	font-weight: bold;
}

-->
</style>
<script>
function check_disable1(){
    if ($('input[name=\'personal_info_approval\']:checked').val() == "N"){
        $("#personal_info_reason_text").show();
    }
    else{
        $("#personal_info_reason_text").hide();
    }	
}
</script>
<script type="text/javascript">
function validation()
{
	
	if($('input[name="personal_info_approval"]:checked').length == 0)
		{
			alert("Please Select One option.");
			document.getElementById('personal_info_approval').focus();
			return false;
		}
		
	
	if($('input[name=\'personal_info_approval\']:checked').val() == "N")
	{
		if(document.getElementById('personal_info_reason').value=="")
		{
			alert("Please Enter Reason");
			document.getElementById('personal_info_reason').focus();
			return false;
		}
		
	}
}

</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('input[name="\apply_visa\"]').click(function(){
		if($(this).attr("value")=="yes"){
		$('#div_apply_visa').show();           
       }else {
            $('#div_apply_visa').hide();   
       }
           
        });
    });
</script>

</head>

<body>


<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > IVR > Personal Information</div>
</div>

<div id="main">
	<div class="content">
    
    	<div class="content_head">IIJS &gt; IVR >> Personal Information
       	  <div style="float:right; padding-right:10px; font-size:12px;"><a href="iijs_ivr.php">Back to Search</a></div> 
        </div>
    	
      <div class="clear"></div>
<div class="content_details1">
<form name="form1" action="" method="post" onsubmit="return validation()"> 
<?php 
if($_SESSION['error_msg']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
$_SESSION['error_msg']="";
}
?>

<ul id="tabs" class="tab_1">
    <li id=""><a href="#" class="active"><strong>Step 1 Information</strong></a></li>
    <li id=""><a href="#"><strong>Step 2 OBMP Info</strong></a></li>  
    <li id=""><a href="#" class="lastBg"><strong>Step 3 Photo</strong></a></li>   
    <div class="clear"></div>
</ul>

<div id="formCon">
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11" >Search Options</td>
</tr>
<tr>
  <td><strong>Title </strong></td>
  <td><select name="title" class="input_txt">
      <option value="Mr" <?php if($title=="Mr") echo "selected"; ?>> Mr </option>
      <option value="Ms" <?php if($title=="Ms") echo "selected"; ?>> Ms </option>
      <option value="Mrs" <?php if($title=="Mrs") echo "selected"; ?>> Mrs </option>
      <option value="Dr" <?php if($title=="Dr") echo "selected"; ?>> Dr </option>
    </select></td>
</tr>
<tr>
    <td width="25%"><strong>First Name </strong></td>
    <td width="75%"> <input name="first_name" id="first_name" type="text"  class="input_txt" value="<?php echo $first_name;?>"/></td>
</tr>

<tr >
    <td ><strong>Last Name </strong></td>
    <td><input name="last_name" type="text" id="last_name"  class="input_txt" value="<?php echo $last_name;?>"/></td>
</tr>	
    
    
<tr >
    <td><strong>Designation <sup>*</sup></strong></td>
    <td><input name="designation" id="designation" type="text"  class="input_txt" value="<?php echo $designation;?>" /></td>
</tr>

<tr  >
    <td><strong>Do you have an Indian Passport ? </strong></td>
    <td>
    	<input name="indian_passport" type="radio" value="yes" <?php if($indian_passport=="yes")echo "checked"; ?>/> Yes
       <input name="indian_passport" type="radio" value="no" <?php if($indian_passport=="no")echo "checked"; ?>/> No

     </td>
</tr>

<tr >
  <td><strong>Passport No. </strong></td>
  <td><input name="passport_no" id="passport_no" type="text"  class="input_txt" value="<?php echo $passport_no;?>"/>
  &nbsp;&nbsp;<?php if($passport_fid!=""){?><a href="http://iijs.org/images/ivr_image/passport/<?php echo $passport_fid;?>" target="_blank">View Passport</a><?php }?></td>
 </tr>

<tr >
  <td><strong>Valid Upto</strong></td>
  <td><input name="valid_upto" type="text"  class="input_txt" id="valid_upto" value="<?php echo $valid_upto;?>"/></td>
</tr>    
    
<tr >
  <td><strong>Place of issue </strong></td>
  <td><input name="issue_place" type="text" id="issue_place" class="input_txt" value="<?php echo $issue_place;?>"/></td>
</tr>
<tr >
  <td><strong>Origin </strong></td>
  <td><select name="origin" class="input_txt">
      <option value="NRI" <?php if($origin=="NRI") echo "selected"; ?>> NRI </option>
      <option value="Indian National Settled Abroad" <?php if($origin=="Indian National Settled Abroad") echo "selected"; ?>> Indian National Settled Abroad</option>
      <option value="Foreign National" <?php if($origin=="Foreign National") echo "selected"; ?>> Foreign National </option>
      </select></td>
</tr>
<tr >
  <td><strong>Apply for Visa Recommendation Letter</strong></td>
  <td><input name="apply_visa" id="apply_visa" type="radio" value="yes"  class="radio radioBtn" <?php if($apply_visa==1)echo "checked"; ?>/> Yes
    
    <input name="apply_visa" id="apply_visa" type="radio" value="no" class="radio radioBtn" <?php if($apply_visa==0)echo "checked"; ?>/>No</td>
</tr>
<tbody <?php if($apply_visa!=1){?>style="display:none;"<?php }?> id="div_apply_visa"> 
<tr >
  <td>Applying to </td>
  <td>
    <input name="apply_visa_to" id="apply_visa_to" type="radio" value="Embassy of India"  class="radio radioBtn" <?php if($apply_visa_to=='Embassy of India')echo "checked"; ?>/>Embassy of India
    
    <input name="apply_visa_to" id="apply_visa_to" type="radio" value="Consulate of India" class="radio radioBtn" <?php if($apply_visa_to=='Consulate of India')echo "checked"; ?>/>Consulate of India</td>
</tr>
<tr >
  <td>City Name</td>
  <td><input name="apply_visa_city" type="text"  class="input_txt" id="apply_visa_city" value="<?php echo $apply_visa_city;?>"/></td>
</tr>
</tbody>
<tr >
  <td><strong>Company Name </strong></td>
  <td><input name="company_name" type="text"  class="input_txt" id="company_name" value="<?php echo $company_name;?>"/>&nbsp;&nbsp;<?php if($visit_card_fid!=""){?><a href="http://iijs.org/images/ivr_image/visiting_card/<?php echo $visit_card_fid;?>" target="_blank">View Visiting Card</a><?php }?></td>
</tr>
<tr >
  <td><strong>Office Address </strong></td>
  <td> <textarea name="office_add" cols="" rows="" id="office_add" class="input_txt"><?php echo $office_add;?></textarea></td>
</tr>
<tr >
  <td><strong>City </strong></td>
  <td> <input name="city" type="text"  class="input_txt" id="city" value="<?php echo $city;?>"/></td>
</tr>
<tr >
  <td><strong>State </strong></td>
  <td> <input name="state" type="text"  class="input_txt" id="state" value="<?php echo $state;?>"/></td>
</tr>
<tr >
  <td><strong>Country </strong></td>
  <td><select name="country" class="input_txt">
        <option value="">---------- Select ----------</option>
        <?php 
        echo $query=mysql_query("SELECT * FROM country_master");
        while($result=mysql_fetch_array($query)){
        ?>
        <option value="<?php echo $result['country_code'];?>" <?php if($result['country_code']==$country )echo "selected";?> ><?php echo $result['country_name'];?></option>
        <?php }?>
      </select></td>
</tr>
<tr >
  <td><strong>Postal Code </strong></td>
  <td> <input name="postal_code" type="text"  class="input_txt" id="postal_code" value="<?php echo $postal_code;?>"/></td>
</tr>
<tr >
  <td><strong>Tel. No. (with country &amp; city code)</strong></td>
  <td>
    <input name="tel_no" id="tel_no" type="text"  class="input_txt1" value="<?php echo $tel_no;?>" />
  </td>
</tr>
<tr >
  <td><strong>Mobile No.</strong></td>
  <td>
    <input name="mob_no" id="mob_no" type="text"  class="input_txt1" value="<?php echo $mob_no;?>" />
  </td>
</tr>
<tr >
  <td><strong>Fax. No. (with country &amp; city code) </strong></td>
  <td>
           
  <input name="fax_no" type="text" id="fax_no" class="input_txt1" value="<?php echo $fax_no;?>" />
  </td>
</tr>
<tr >
  <td><strong>Email</strong></td>
  <td> <input name="email" type="text" id="email" class="input_txt" value="<?php echo $email;?>"/></td>
</tr>
<tr >
  <td><strong>Website</strong></td>
  <td> <input name="website" type="text" id="website" class="input_txt" value="<?php echo $website;?>"/></td>
</tr>
<tr >
  <td><strong>Company Profile</strong></td>
  <td><textarea name="company_profile" cols="10" rows="3" class="input_txt" id="company_profile"><?php echo $company_profile;?></textarea></td>
  </tr>
<tr >
  <td valign="top"><strong>Information Approval Status</strong></td>
  <td><input type="radio" name="personal_info_approval" id="personal_info_approval" value="Y" onchange="check_disable1()" <?php if($personal_info_approval=="Y"){?> checked="checked" <?php }?> />Approval
  <input type="radio" name="personal_info_approval" id="personal_info_approval" value="N" onchange="check_disable1()"  <?php if($personal_info_approval=="N"){?> checked="checked" <?php }?> />Disapprove
  <br />
  	<p id="personal_info_reason_text" <?php if($personal_info_approval=="Y"){?> style="display:none;" <?php }?>>
	<textarea name="personal_info_reason" cols="40" rows="6" id="personal_info_reason"  ><?php echo $personal_info_reason;?></textarea></p>
  </td>
</tr>

</table>
</div>
<div style="padding-left:250px; margin-top:5px;">
<input type="hidden" name="action" id="action" value="UPDATE" />
<input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
<input type="hidden" name="registration_id" id="registration_id" value="<?php echo $registration_id;?>" />    	
<input type="submit" value="Update" class="input_submit"/>
<!--<a href="obmp_info_IVR.php?id=<?php// echo $id;?>&registration_id=<?php// echo $registration_id;?>"><div class="button">Next</div></a>-->
</div>
</form>      
</div>

 
</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
