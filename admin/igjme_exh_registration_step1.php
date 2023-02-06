<?php 
session_start();
ob_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
?>
<?php
include('../db.inc.php');
include('../functions.php');
$action=$_REQUEST['action'];
$show = "IGJME";
if($action=='UPDATE')
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
		
	$id=intval(filter($_REQUEST['id']));
	$registration_id=intval(filter($_REQUEST['registration_id']));
	$company_name =  str_replace(array('&amp;','&AMP;'), '&',strtoupper($_REQUEST['company_name']));
	$kyc=filter($_POST["kyc"]);
	$membership_id=filter($_POST["membership_id"]);
	$membership_date=filter($_POST["membership_date"]);
	$address1=filter($_POST["address1"]);	
	$address2=filter($_POST["address2"]);
	$address3=filter($_POST["address3"]);
	$pan_no	=	str_replace(' ','',strtoupper(filter($_POST['pan_no'])));
	$tan_no=filter($_POST["tan_no"]);
	$city=filter($_POST["city"]);
	$pincode	=	str_replace(' ','',strtoupper(filter($_POST['pincode'])));
	$country=filter($_POST["country"]);
	$telephone_no=filter($_POST["telephone_no"]);
	$mobile=filter($_POST["mobile"]);
	$fax_no=filter($_POST["fax_no"]);
	$email=filter($_POST["email"]);
	$website = filter($_POST["website"]);
	$contact_person = filter($_POST["contact_person"]);
	$contact_person_desg = filter($_POST["contact_person_desg"]);
	$contact_person_desg_show =filter($_POST['contact_person_desg_show']);
	$contact_person_co =filter($_POST['contact_person_co']);
	$contacts =filter($_POST['contacts']);
	$event_for=filter($_POST["event_for"]);
	$participant_type=filter($_POST["participant_type"]);
	$region=filter($_POST["region"]);
	
	$billing_address_id = filter($_REQUEST['billing_address_id']); if($billing_address_id=="") $billing_address_id=0;
	$billing_gstin = filter($_REQUEST['billing_gstin']);
	$billing_address1=filter($_REQUEST['baddress1']);
	$billing_address2=filter($_REQUEST['baddress2']);
	$billing_address3=filter($_REQUEST['baddress3']);		
	$bcity=filter($_REQUEST['bcity']);
	$bpincode=filter($_REQUEST['bpincode']);
	$btelephone_no=filter($_REQUEST['btelephone_no']);
	//echo $bp_number = getBPNO($registration_id);
	/*$personal_info_approval=filter($_POST['personal_info_approval']);	
	if($personal_info_approval=='Y')
	{
	$personal_info_reason="";
	}else
	{
	$personal_info_reason=filter($_POST['personal_info_reason']);	
	}*/
	if(!empty($registration_id) && !empty($id)){
		if($company_name == "" || $region == "" ) {
		$_SESSION['error_msg']="Company Name or Region missing";
		} else {
	$updatesql="update exh_reg_general_info set company_name='".$company_name."', address1='".$address1."',address2='".$address2."',address3='".$address3."',billing_address_id='".$billing_address_id."',billing_gstin='".$billing_gstin."',billing_address1='".$billing_address1."',billing_address2='".$billing_address2."',billing_address3='".$billing_address3."',bcity='".$bcity."',bpincode='".$bpincode."',btelephone_no='".$btelephone_no."',pan_no='".$pan_no."',tan_no='".$tan_no."',city='".$city."',pincode='".$pincode."',country='".$country."',region='".$region."',telephone_no='".$telephone_no."',mobile='".$mobile."',fax_no='".$fax_no."',email='".$email."',kyc='$kyc',website='".$website."',contact_person='".$contact_person."',contact_person_desg='".$contact_person_desg."',contact_person_desg_show='".$contact_person_desg_show."',contact_person_co='".$contact_person_co."',contacts='".$contacts."' where id='$id' and uid='$registration_id' and event_for='$show'";	
	if(!$conn->query($updatesql))
	{
		die('Error: ' . mysqli_error($conn));
	}
	$_SESSION['succ_msg']="General Info updated successfully";
	header("Location: igjme_exh_registration_step2.php?gid=$id&registration_id=$registration_id");
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
$sql="select  * from exh_reg_general_info where id='$id' and uid='$registration_id' and event_for='$show'";
$result=$conn->query($sql);
$rows=$result->fetch_assoc();

$company_name	=	filter($rows['company_name']);
$membership_id	=	filter($rows['membership_id']);
$kyc	=	filter($rows['kyc']);
$membership_date=$rows['membership_date'];
$address1	=	filter($rows['address1']);
$address2	=	filter($rows['address2']);
$address3	=	filter($rows['address3']);
$pan_no		=	filter($rows['pan_no']);
$tan_no		=	filter($rows['tan_no']);
$city		=	filter($rows['city']);
$pincode	=	filter($rows['pincode']);
$country	=	filter($rows['country']);
$telephone_no=$rows['telephone_no'];
$mobile		=	filter($rows['mobile']);
$fax_no		=	filter($rows['fax_no']);
$email		=	filter($rows['email']);
$website 	= 	filter($rows["website"]);
$contact_person = 	filter($rows["contact_person"]);
$contact_person_desg = filter($rows["contact_person_desg"]);
$contact_person_co	 = filter($rows['contact_person_co']);
$contact_person_desg_show	=	filter($rows['contact_person_desg_show']);
$contacts	=	filter($rows['contacts']);
$event_for	=	filter($rows['event_for']);
$participant_type=$rows['participant_type'];
$region	=	filter($rows['region']);
$billing_address_id	=	filter($rows['billing_address_id']);
$billing_gstin		=	filter($rows['billing_gstin']);
$billing_address1=filter($rows['billing_address1']);
$billing_address2=filter($rows['billing_address2']);
$billing_address3=filter($rows['billing_address3']);		
$bcity=filter($rows['bcity']);
$bpincode=filter($rows['bpincode']);
$bcountry=filter($rows['bcountry']);
$btelephone_no=filter($rows['btelephone_no']);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IGJME &gt; Exhibitor Registration &gt; Step-1</title>
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
	
	<script type="text/javascript" src="js/jqueryNew.js"></script>
	<script type="text/javascript" src="js/jquery.fancybox-1.2.1.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("div.fancyDemo a").fancybox();
		});
	</script>
<!-- lightbox Thum -->

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
$(document).ready(function(){
		//alert('hello');
		$('#billing_address_id').change(function(){
				//alert($( this ).val());
				var option = $(this).val();
				var registration_id =$('#registration_id').val();
			
			  $.ajax({ type: 'POST',
					url: 'ajax_get_child_address.php',
					data: "actiontype=optionValue&&option="+option+"&&registration_id="+registration_id,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
						//alert(data);
						 if($.trim(data)!=""){
							 //$('#selected_area').html(data);
							 data=data.split("#");
							   $("#baddress1").val(data[0]);
							   $("#baddress2").val(data[1]);
							   $("#baddress3").val(data[2]);
							   $("#bcity").val(data[3]);
							   $("#bpincode").val(data[4]);
							   $("#btelephone_no").val(data[5]);							 
						 }
					}
		});
	});
});
</script>
<script type="text/javascript">
/*function validation()
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
}*/

</script>

</head>

<body>

<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Exhibitor Registration</div>
</div>

<div id="main">
	<div class="content">
    
    	<div class="content_head">IGJME &gt; Exhibitor Registration
        <div style="float:right; padding-right:10px; font-size:12px;"><a href="igjme_exhibitor_rgistration.php">Back to Search</a></div>
        </div>
<div class="content_details1">
<?php 
if($_SESSION['error_msg']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
$_SESSION['error_msg']="";
}
?>
<form name="form1" action="" method="POST" onsubmit="return validation()"> 
<?php token(); ?>

<ul id="tabs" class="tab_1">
    <li id=""><a href="#" class="active"><strong>Step 1 GENERAL INFORMATION</strong></a></li>
    <li id=""><a href="#"><strong>Step 2 Company Details</strong></a></li>  
    <li id=""><a href="#"><strong>Step 3 Participation Stall Details</strong></a></li>
    <li id=""><a href="#" class="lastBg"><strong>Step 4 Payment Details</strong></a></li>  
    <div class="clear"></div>
</ul>

<div id="formCon">
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11" >General Information</td>
</tr>
<tr>
    <td width="25%"><strong>Company Name : </strong></td>
    <td width="75%"><input name="company_name" id="company_name" type="text" class="input_txt" value="<?php echo $company_name;?>"/></td>
</tr>
<tr>
    <td width="25%"><strong>KYC No. </strong></td>
    <td width="75%"><input name="kyc" id="kyc" type="text" class="textField" value="<?php echo $kyc;?>" readonly="readonly"/></td>
</tr>
<tr >
    <td ><strong>Membership ID : </strong></td>
    <td><input name="membership_id" type="text" id="membership_id"  class="input_txt" value="<?php echo $membership_id;?>" readonly/></td>
</tr>	 
<tr >
    <td><strong>Membership Date : <sup>*</sup></strong></td>
    <td><input name="membership_date" id="membership_date" type="text"  class="input_txt" value="<?php echo $membership_date;?>" readonly/></td>
</tr>
<tr >
  <td><strong>Address 1</strong></td>
  <td><input name="address1" id="address1" type="text"  class="input_txt" value="<?php echo $address1;?>"/></td>
</tr>

<tr >
  <td><strong>Address 2</strong></td>
  <td><input name="address2" id="address2" type="text"  class="input_txt" value="<?php echo $address2;?>"/></td>
</tr>

<tr >
  <td><strong>Address 3</strong></td>
  <td><input name="address3" id="address3" type="text"  class="input_txt" value="<?php echo $address3;?>"/></td>
</tr>

<!--<tr >
  <td><strong>PAN No </strong></td>
  <td> <input name="pan_no" type="text"  class="input_txt" id="pan_no" value="<?php echo $pan_no;?>"/></td>
</tr>

<tr >
  <td><strong>TAN No </strong></td>
  <td> <input name="tan_no" type="text"  class="input_txt" id="tan_no" value="<?php echo $tan_no;?>"/></td>
</tr>-->

<tr >
  <td><strong>City </strong></td>
  <td> <input name="city" type="text"  class="input_txt" id="city" value="<?php echo $city;?>"/></td>
</tr>

<tr >
  <td><strong>Pin Code </strong></td>
  <td> <input name="pincode" type="text"  class="input_txt" id="pincode" value="<?php echo $pincode;?>"/></td>
</tr>

<tr >
  <td><strong>Country </strong></td>
  <td>
		<select name="country" class="input_txt"> 
        <option value="">---------- Select ----------</option>
        <?php 		
        $query=$conn->query("SELECT * FROM country_master");
        while($result=$query->fetch_assoc()){  ?>
        <option value="<?php echo $result['country_code'];?>" <?php if($result['country_code']==$country){?> selected="selected" <?php } else if($result['country_code']=="IN"){?> selected="selected"<?php }?>><?php echo $result['country_name'];?></option>
        <?php }?>
      </select></td>
</tr>

<tr >
  <td><strong>Tel. No.</strong></td>
  <td>
    <input name="telephone_no" id="telephone_no" type="text"  class="input_txt" value="<?php echo $telephone_no;?>" />
  </td>
</tr>
<tr >
  <td><strong>Fax. No.</strong></td>
  <td>
           
  <input name="fax_no" type="text" id="fax_no" class="input_txt" value="<?php echo $fax_no;?>" />
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
  <td><strong>Contact Person</strong></td>
  <td><input name="contact_person" type="text"  class="input_txt" id="contact_person" value="<?php echo $contact_person;?>"/></td>
</tr>    
    
<tr >
  <td><strong>Contact Person Designation </strong></td>
  <td><input name="contact_person_desg" type="text" id="contact_person_desg" class="input_txt" value="<?php echo $contact_person_desg;?>"/></td>
</tr>
<tr >
  <td><strong>Mobile No.</strong></td>
  <td>   <input name="mobile" id="mobile" type="text"  class="input_txt" value="<?php echo $mobile;?>" /> </td>
</tr>

<tr>
<td><strong>Contact Person For Show Co Ordination: </strong></td>
<td><input type="text" class="input_txt" id="contact_person_co" name="contact_person_co" value="<?php echo $contact_person_co;?>" /></td>
</tr>
<tr>
<td><strong>Designation: </strong></td>
<td><input type="text" class="input_txt" id="contact_person_desg_show" name="contact_person_desg_show" value="<?php echo $contact_person_desg_show;?>"/></td>
</tr>		
<tr>
<td><strong>Contact No. : </strong></td>
<td><input type="text" class="input_txt" id="contacts" name="contacts" value="<?php echo $contacts;?>" />
</td>
</tr>
		
<tr>
<td><strong>Select Region : </strong></td>
<td>
<select class="bgcolor" name="region" id="region">
<option value="" >--- Select ---</option>
<?php
$sql3="SELECT * FROM `region_master` WHERE 1 and `status`=1";  
$result3=$conn->query($sql3);
while($rows3=$result3->fetch_assoc())
{
?>
<option value="<?php echo $rows3['region_name'];?>" <?php if($rows3['region_name']==$region){?> selected="selected" <?php }?> ><?php echo $rows3['region_full_name'];?></option>
<?php }?>
</select>
</td>
</tr>
<tr>
<td><strong>Choose Billing Address : </strong></td>
<td>
<select name="billing_address_id" id="billing_address_id" class="bgcolor">
            <option value="">--- Choose Billing Address ---</option>
            <?php
			$commAddress2 = "SELECT * FROM `communication_address_master` WHERE `registration_id` = '$registration_id' AND address_identity='CTC' AND c_bp_number!=''";
			$result2 = $conn->query($commAddress2);
			while($addChild = $result2->fetch_assoc()){ ?>
			<option value="<?php echo $addChild['id'];?>" <?php if($billing_address_id == $addChild['id']) echo 'selected="selected"';?>>
			<?php echo $addChild['address1'].'-'.$addChild['city'];?></option>			
            <?php } ?>
        </select>	  
</td>
</tr>
<tr>
<td><strong>Billing GSTIN : </strong></td>
<td><input type="text" class="textField" id="billing_gstin" name="billing_gstin" value="<?php echo $billing_gstin;?>" maxlength="15" minlength="15" autocomplete="off"/></td>
</tr>
<tr>
<td><strong>Address 1 : </strong></td>
<td><input type="text" class="textField" id="baddress1" name="baddress1" value="<?php echo $billing_address1;?>" readonly/></td>
</tr>
<tr>
<td><strong>Address 2 : </strong></td>
<td><input type="text" class="textField" id="baddress2" name="baddress2" value="<?php echo $billing_address2;?>" readonly/></td>
</tr>
<tr>
<td><strong>Address 3 : </strong></td>
<td><input type="text" class="textField" id="baddress3" name="baddress3" value="<?php echo $billing_address3;?>" readonly/></td>
</tr>
<tr>
<td><strong>City : </strong></td>
<td><input type="text" class="textField" id="bcity" name="bcity" value="<?php echo $bcity;?>" autocomplete="off" readonly/></td>
</tr>
<tr>
<td><strong>Pincode : </strong></td>
<td><input type="number" class="textField" id="bpincode" name="bpincode" value="<?php echo $bpincode;?>" autocomplete="off" onKeyPress="if(this.value.length==9) return false;" readonly/></td>
</tr>
<tr>
<td><strong>Tel : </strong></td>
<td><input type="text" class="textField" id="btelephone_no" name="btelephone_no" value="<?php echo $btelephone_no;?>" readonly/></td>
</tr>
<?php /*?><tr >
  <td valign="top"><strong>Information Approval Status</strong></td>
  <td><input type="radio" name="personal_info_approval" id="personal_info_approval" value="Y" onchange="check_disable1()" <?php if($personal_info_approval=="Y"){?> checked="checked" <?php }?> />Approval
  <input type="radio" name="personal_info_approval" id="personal_info_approval" value="N" onchange="check_disable1()"  <?php if($personal_info_approval=="N"){?> checked="checked" <?php }?> />Disapprove
  <br />
  	<p id="personal_info_reason_text" <?php if($personal_info_approval=="Y"){?> style="display:none;" <?php }?>>
	<textarea name="personal_info_reason" cols="40" rows="6" id="personal_info_reason"  ><?php echo $personal_info_reason;?></textarea></p>
  </td>
</tr><?php */?>

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
