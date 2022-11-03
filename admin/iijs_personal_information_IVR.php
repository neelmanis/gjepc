<?php 
session_start();
ob_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
?>
<?php
include('../db.inc.php');
include('../functions.php');
$action=$_REQUEST['action'];



if($action=='UPDATE')
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
		
	$id=intval(filter($_REQUEST['id']));
	$registration_id = intval(filter($_REQUEST['registration_id']));
	$indian_passport = filter($_POST["indian_passport"]);
	$title = filter($_POST["title"]);  
	$first_name = filter($_POST["first_name"]); 
	$last_name = filter($_POST["last_name"]);
	$designation = filter($_POST["designation"]);
	$passport_no = filter($_POST["passport_no"]);
	$valid_upto = filter($_POST["valid_upto"]);
	$issue_place = filter($_POST["issue_place"]);
	$origin = filter($_POST["origin"]);
	$company_name = filter($_POST["company_name"]);
	$office_add = filter($_POST["office_add"]);
	$city = filter($_POST["city"]);
	$state = filter($_POST["state"]);
	$country = filter($_POST["country"]);
	$postal_code = filter($_POST["postal_code"]);
	$tel_no = filter($_POST["tel_no"]);
	$mob_no = filter($_POST["mob_no"]);
	$fax_no = filter($_POST["fax_no"]);
	$email = filter($_POST["email"]);
	$website = filter($_POST["website"]);
	$company_profile = filter($_POST["company_profile"]);	
	
	$india_stay = filter($_POST["india_stay"]);
	if($india_stay=='hotel'){
		$hotel_name = filter($_POST["hotel_name"]);
		$hotel_address = filter($_POST["hotel_address"]);
		$stay_from = filter($_POST["stay_from"]);
		$stay_to = filter($_POST["stay_to"]);
		$name_of_person = "";
		$family_address = "";
		$family_contact = "";
		$family_relation = "";
		$family_stay_from = "";
		$family_stay_to = "";
	}else if($india_stay=='family'){
		$name_of_person = filter($_POST["name_of_person"]);
		$family_address = filter($_POST["family_address"]);
		$family_contact = filter($_POST["family_contact"]); 
		$family_relation = filter($_POST["family_relation"]);
		$family_stay_from = filter($_POST["family_stay_from"]);
		$family_stay_to = filter($_POST["family_stay_to"]);
		$hotel_name = "";
		$hotel_address = "";
		$stay_from = "";
		$stay_to = "";
	}else{
		$hotel_name = "";
		$hotel_address = "";
		$stay_from = "";
		$stay_to = "";
		$name_of_person = "";
		$family_address = "";
		$family_contact = "";
		$family_relation = "";
		$family_stay_from = "";
		$family_stay_to = "";
	}	
	
	$apply_visa=$_POST["apply_visa"];
		
	if($apply_visa=="yes")
	{
		$apply_visa=1;
		$apply_visa_to=filter($_POST["apply_visa_to"]);
		$apply_visa_city=filter($_POST["apply_visa_city"]);
	}else{
		$apply_visa=0;
		$apply_visa_to="";
		$apply_visa_city="";
	}
	
	$personal_info_approval=filter($_POST['personal_info_approval']);	
	if($personal_info_approval=='Y')
	{
	$personal_info_reason="";
	}else
	{
	$personal_info_reason=filter($_POST['personal_info_reason']);	
	}
	
	if(!empty($registration_id) && !empty($id)){
		if($first_name == "") {
		$_SESSION['error_msg']=" Name missing";
		} else {
	$updatesql="update ivr_registration_details set indian_passport='".$indian_passport."',title='".$title."',first_name='".$first_name."',last_name='".$last_name."',designation='".$designation."',passport_no='".$passport_no."',valid_upto='".$valid_upto."',issue_place='".$issue_place."',origin='".$origin."',company_name='".$company_name."',office_add='".$office_add."',city='".$city."',state='".$state."',country='".$country."',postal_code='".$postal_code."',tel_no='".$tel_no."',mob_no='".$mob_no."',fax_no='".$fax_no."',email='".$email."',website='".$website."',india_stay='".$india_stay."',hotel_name='".$hotel_name."',hotel_address='".$hotel_address."',stay_from='".$stay_from."',stay_to='".$stay_to."',name_of_person='".$name_of_person."',family_address='".$family_address."',family_contact='".$family_contact."',family_relation='".$family_relation."',family_stay_from='".$family_stay_from."',family_stay_to='".$family_stay_to."',company_profile='".$company_profile."',apply_visa='".$apply_visa."', apply_visa_to='".$apply_visa_to."', apply_visa_city='".$apply_visa_city."',personal_info_approval='".$personal_info_approval."',personal_info_reason='".$personal_info_reason."' where eid='$id' and uid='$registration_id'";	
	$conn ->query($updatesql);
	$_SESSION['succ_msg']="Information updated successfully";
	header("Location: iijs_obmp_info_IVR.php?id=$id&registration_id=$registration_id");
	}
	} else { $_SESSION['error_msg']="Something Missing"; }
	} else {
	$_SESSION['error_msg']="Invalid Token Error";
	}
}
?>

<?php
$id=intval(filter($_REQUEST['id']));
$registration_id=intval(filter($_REQUEST['registration_id']));
$sql="SELECT * FROM `ivr_registration_details` WHERE 1 and eid='$id' and uid='$registration_id'";
$result=$conn ->query($sql);
$rows=$result->fetch_assoc();
$appId = $id;
$indian_passport	= filter($rows['indian_passport']);
$title	=	filter($rows['title']);
$first_name	=	filter($rows['first_name']);
$last_name	=	filter($rows['last_name']);
$designation=	filter($rows['designation']);
$passport_no=	filter($rows['passport_no']);
$valid_upto=$rows['valid_upto'];
$issue_place=$rows['issue_place'];
$origin	=	filter($rows['origin']);
$company_name	=	filter($rows['company_name']);
$office_add		=	filter($rows['office_add']);
$city		=	filter($rows['city']);
$state		=	filter($rows['state']);
$country=$rows['country'];
$postal_code	=	filter($rows['postal_code']);
$tel_no = filter($rows["tel_no"]);
$mob_no = filter($rows["mob_no"]);
$fax_no = filter($rows["fax_no"]);
$email	= filter($rows['email']);
$website= filter($rows['website']);

	$india_stay = $rows["india_stay"];	
	$hotel_name = $rows["hotel_name"];
	$hotel_address = $rows["hotel_address"];
	$stay_from = $rows["stay_from"];
	$stay_to = $rows["stay_to"];
	
	$name_of_person = filter($rows["name_of_person"]);
	$family_address = filter($rows["family_address"]);
	$family_contact = filter($rows["family_contact"]);
	$family_relation = $rows["family_relation"];
	$family_stay_from = $rows["family_stay_from"];
	$family_stay_to = $rows["family_stay_to"];
	
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
<script>
function check_disable1(){
    if ($('input[name=\'personal_info_approval\']:checked').val() == "N"){
        $("#personal_info_reason_text").show();
    } else {
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
	
	var india_stay = $("input[name='india_stay']:checked").val();
		if(india_stay=='hotel'){
			if($('#hotel_name').val()==""){
				alert("Enter Hotel Name");
				$('#hotel_name').focus();
				return false;
			}
			if($('#hotel_address').val()==""){
				alert("Enter Hotel Address");
				$('#hotel_address').focus();
				return false;
			}
			if($('#stay_from').val()==""){
				alert("Enter stay date from");
				$('#stay_from').focus();
				return false;
			}
			if($('#stay_to').val()==""){
				alert("Enter stay to");
				$('#stay_from').focus();
				return false;
			}
		}
		if(india_stay=='family'){
			if($('#name_of_person').val()==""){
				alert("Enter Person Name");
				$('#name_of_person').focus();
				return false;
			}
			if($('#family_address').val()==""){
				alert("Enter Family Address");
				$('#family_address').focus();
				return false;
			}
			if($('#family_stay_from').val()==""){
				alert("Enter stay date from");
				$('#family_stay_from').focus();
				return false;
			}
			if($('#family_stay_to').val()==""){
				alert("Enter stay to");
				$('#family_stay_to').focus();
				return false;
			}
			if($('#family_contact').val()==""){
				alert("Enter Family contact no");
				$('#family_contact').focus();
				return false;
			}
		}
}

$().ready(function() {
	
var radioValue = $("input[name='india_stay']:checked").val();

	if(radioValue=='hotel'){
		$('#hotel_detail').show();
		$('#family_detail').hide();
	}
	else if(radioValue=='family'){
		$('#hotel_detail').hide();
		$('#family_detail').show();
	}
	else{
		$('#hotel_detail').hide();
		$('#family_detail').hide();
	}

$('input[type="radio"]').live('click', function(){
    val=$(this).val();
	
	if(val=='hotel'){
		$('#hotel_detail').show();
		$('#family_detail').hide();
	}
	else if(val=='family'){
		$('#hotel_detail').hide();
		$('#family_detail').show();
	}
	else{
		$('#hotel_detail').hide();
		$('#family_detail').hide();
	}
	
});	
});
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('input[name="\apply_visa\"]').click(function(){
		if($(this).attr("value")=="yes"){
		$('#div_apply_visa').show();           
       } else {
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
       	  <div style="float:right; padding-right:10px; font-size:12px;"><a href="iijs_ivr.php?action=view">Back to Search</a></div> 
        </div>
    	
      <div class="clear"></div>
<div class="content_details1">
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

<form name="form1" action="" method="post" onsubmit="return validation()">
<?php token(); ?>

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

<tr>
    <td ><strong>Last Name </strong></td>
    <td><input name="last_name" type="text" id="last_name" class="input_txt" value="<?php echo $last_name;?>"/></td>
</tr>	
    
<tr>
    <td><strong>Designation <sup>*</sup></strong></td>
    <td><input name="designation" id="designation" type="text" class="input_txt" value="<?php echo $designation;?>" /></td>
</tr>

<tr>
    <td><strong>Do you have an Indian Passport ? </strong></td>
    <td>
    <input name="indian_passport" type="radio" value="yes" <?php if($indian_passport=="yes")echo "checked"; ?>/> Yes
    <input name="indian_passport" type="radio" value="no" <?php if($indian_passport=="no")echo "checked"; ?>/> No</td>
</tr>

<tr >
  <td><strong>Passport No. </strong></td>
  <td><input name="passport_no" id="passport_no" type="text"  class="input_txt" value="<?php echo $passport_no;?>"/>
  &nbsp;&nbsp;<?php if($passport_fid!=""){?><a href="https://registration.gjepc.org/images/ivr_image/passport/<?php echo $passport_fid;?>" target="_blank">View Passport</a><?php }?></td>
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
  <td><input name="company_name" type="text"  class="input_txt" id="company_name" value="<?php echo $company_name;?>"/>&nbsp;&nbsp;<?php if($visit_card_fid!=""){?><a href="https://registration.gjepc.org/images/ivr_image/visiting_card/<?php echo $visit_card_fid;?>" target="_blank">View Visiting Card</a><?php }?></td>
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
        $query=$conn ->query("SELECT * FROM country_master where country_code!='IN'");
        while($result=$query->fetch_assoc()){
        ?>
        <option value="<?php echo $result['country_code'];?>" <?php if($result['country_code']==$country) echo "selected";?>><?php echo $result['country_name'];?></option>
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
<tr>
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
<tr>
     <td>Please confirm your India stay during Signature IIJS SIGNATURE 2022 : <sup>*</sup></td>        	
     <td>
		<span>Hotel</span>
      	<input name="india_stay" type="radio" value="hotel" <?php if($india_stay=="hotel")echo "checked";?>/> 
       	<span>Friend/Family</span>
       	<input name="india_stay" type="radio" value="family" <?php if($india_stay=="family")echo "checked"; ?>/>
        <span>Not yet confirmed</span>
       	<input name="india_stay" type="radio" value="nyc" <?php if($india_stay=="nyc")echo "checked"; ?>/>       
	 </td>
</tr>
 

<tr id="hotel_detail" <?php if($india_stay=='hotel'){ ?> <?php } else {?> style="display:none;"<?php } ?>>
   <td> </td>
            <td>
                <label>Hotel Name :<sup>*</sup></label>
                <input type="text" name="hotel_name" id="hotel_name" class="input_txt" value="<?php echo $hotel_name;?>" />
				<div class="clear"></div>
                <label>Address :<sup>*</sup></label>
                <input type="text" name="hotel_address" id="hotel_address" class="input_txt" value="<?php echo $hotel_address;?>" />
            <div class="clear"></div>
                <label>Stay Duration :<sup>*</sup></label>                
                    <span>From</span>
                    <input name="stay_from" type="date" value="<?php echo $stay_from;?>" />  
                    <span>To</span>
                    <input name="stay_to" type="date"  value="<?php echo $stay_to;?>" />               
            </td>
</tr>
<tr id="family_detail" <?php if($india_stay=='family'){ ?> <?php } else {?> style="display:none;"<?php } ?>>
            
			<td> </td>
			<td>
                <label>Name of person:<sup>*</sup></label>
                <input type="text" name="name_of_person" id="name_of_person" class="input_txt" value="<?php echo $name_of_person;?>" />
                <div class="clear"></div>
                <label>Address :<sup>*</sup></label>
                <input type="text" name="family_address" id="family_address" class="input_txt" value="<?php echo $family_address;?>" />
                <div class="clear"></div>
                <label>Contact :<sup>*</sup></label>
                <input type="text" name="family_contact" id="family_contact" class="input_txt" value="<?php echo $family_contact;?>" />
                <div class="clear"></div>
                <label>Relation with visitor :<sup>*</sup></label>
                <input type="text" name="family_relation" id="family_relation" class="textField" value="<?php echo $family_relation;?>" />
                <div class="clear"></div>                
                
                <div class="leftTitle" style="padding-top:0px;"><label>Stay Duration :<sup>*</sup></label></div>
                <div class="rightContent">
                    <span>From</span>
                    <input name="family_stay_from" type="date" value="<?php echo $family_stay_from;?>" />  
                    <span>To</span>
                    <input name="family_stay_to" type="date"  value="<?php echo $family_stay_to;?>" />
               </div>            
            </td>
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