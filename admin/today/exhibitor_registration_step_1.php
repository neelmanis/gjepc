<?php
include('header_include.php');
if(!isset($_SESSION['USERID'])){header("location:login.php");exit;}
$registration_id=$_SESSION['USERID'];
?>
				<?php		/* Check Member & KYC*/		/*
				if($_SESSION['member_type']=="MEMBER")
				{
				$gcode=getGcode($registration_id);
				$apiurl="http://api.mykycbank.com/Service.svc/44402aeb2e5c4eef8a7100f048b97d84/".$gcode;
				
				$getResponse = file_get_contents($apiurl);
				$getResult = json_decode($getResponse,true);
				$apiResponse = json_decode($getResult,true);
				$KycProfileId = $apiResponse['KycProfileId'];
				//echo '<pre>'; print_r($apiResponse); 
				$msg =$apiResponse['Message'];
				if($apiResponse['status']==1){
				} else { ?>
				<script>alert('<?php echo $msg;?>'); window.location = 'my_signature_iijs_dashboard.php';</script>     
				<?php }
				} else if($_SESSION['member_type']=="INTERNATIONAL")
				{ 
				$gcode=getGcode($registration_id);
				$apiurl="http://api.mykycbank.com/Service.svc/44402aeb2e5c4eef8a7100f048b97d84/".$gcode;
				
				$getResponse = file_get_contents($apiurl);
				$getResult = json_decode($getResponse,true);
				$apiResponse = json_decode($getResult,true);
				$KycProfileId = $apiResponse['KycProfileId'];
			    } else {
				echo "<script>alert('You are not a member'); window.location = 'my_signature_iijs_dashboard.php';</script>";		
				} */?>
				
				<?php		/* Check Member & KYC*/		
				if($_SESSION['member_type']=="MEMBER")
				{
				$gcode=getGcode($registration_id);
				$apiurl="http://api.mykycbank.com/Service.svc/44402aeb2e5c4eef8a7100f048b97d84/".$gcode;
				
				$getResponse = file_get_contents($apiurl);
				$getResult = json_decode($getResponse,true);
				$apiResponse = json_decode($getResult,true);
				$KycProfileId = $apiResponse['KycProfileId'];
				//echo '<pre>'; print_r($apiResponse); 
				$msg =$apiResponse['Message'];
				if($apiResponse['status']==1){
				} else { ?>
				<script>alert('<?php echo $msg;?>'); window.location = 'my_signature_iijs_dashboard.php';</script>     
				<?php }
				} else if($_SESSION['member_type']=="INTERNATIONAL")
				{ 
				$gcode=getGcode($registration_id);
				$apiurl="http://api.mykycbank.com/Service.svc/44402aeb2e5c4eef8a7100f048b97d84/".$gcode;
				
				$getResponse = file_get_contents($apiurl);
				$getResult = json_decode($getResponse,true);
				$apiResponse = json_decode($getResult,true);
				$KycProfileId = $apiResponse['KycProfileId'];
			    } else {
				echo "<script>alert('You are not a member'); window.location = 'my_signature_iijs_dashboard.php';</script>";		
				} ?>
				
				<?php 
				$bp_number = getBPNO($_SESSION['USERID']);
				if(empty($bp_number)) { echo "<script>alert('Membership Status Not Updated.Kindly Contact Membership Dept.'); window.location = 'my_signature_iijs_dashboard.php';</script>"; }
				?>
<?php
if($_SESSION['COUNTRY']=="INDIA" || $_SESSION['COUNTRY']=="IND" || $_SESSION['COUNTRY']=="IN")
{
	$country="IN";
}
else
{
	$country=strtoupper($_SESSION['COUNTRY']);
}

$event_for ="IIJS Signature 2019";
$Action=$_REQUEST['Action'];

$action=@$_REQUEST['action'];
if($action=="Save")
{	
$Action=@$_REQUEST['Action'];
	
		$address1=mysql_real_escape_string($_REQUEST['address1']);
		$address2=mysql_real_escape_string($_REQUEST['address2']);
		$address3=mysql_real_escape_string($_REQUEST['address3']);
		$city=mysql_real_escape_string($_REQUEST['city']);
		$pincode=mysql_real_escape_string($_REQUEST['pincode']);
		$country=mysql_real_escape_string($_REQUEST['country']);
		$telephone_no= mysql_real_escape_string($_REQUEST['telephone_no']);
		$fax_no = mysql_real_escape_string($_REQUEST['fax_no']);
		
		$billing_address_id = mysql_real_escape_string($_REQUEST['billing_address_id']);
		$billing_gstin = mysql_real_escape_string($_REQUEST['billing_gstin']);
		$billing_address1=mysql_real_escape_string($_REQUEST['baddress1']);
		$billing_address2=mysql_real_escape_string($_REQUEST['baddress2']);
		$billing_address3=mysql_real_escape_string($_REQUEST['baddress3']);		
		$bcity=mysql_real_escape_string($_REQUEST['bcity']);
		$bpincode=mysql_real_escape_string($_REQUEST['bpincode']);
		$btelephone_no=mysql_real_escape_string($_REQUEST['btelephone_no']);
	
	$company_name = $_REQUEST['company_name'];
	$membership_id = mysql_real_escape_string($_REQUEST['membership_id']);
	$bp_number = filter($_REQUEST['bp_number']);
	$membership_date = mysql_real_escape_string($_REQUEST['membership_date']);
	$gst = strtoupper($_REQUEST['gst']);
	$kyc = $_REQUEST['kyc'];
	$pan_no = mysql_real_escape_string(strtoupper($_REQUEST['pan_no']));
	$tan_no = $_REQUEST['tan_no'];	
	$mobile = $_REQUEST['mobile'];	
	$email = $_REQUEST['email'];	
	$website = mysql_real_escape_string($_REQUEST['website']);
	$contact_person = mysql_real_escape_string($_REQUEST['contact_person']);
	$contact_person_desg = mysql_real_escape_string($_REQUEST['contact_person_desg']);   
	$contact_person_desg_show = $_REQUEST['contact_person_desg_show'];
	$contact_person_co = $_REQUEST['contact_person_co'];
	$contacts = $_REQUEST['contacts'];
	$participant_type = $_REQUEST['participant_type'];
	$region = $_REQUEST['region'];
	$created_date = date('Y-m-d');
	
	/* Validation Start */
	$flag=1;
	if(empty($company_name)){
	$companyNameError = "Company Name should not be blank"; $flag=0;
	} else {
	$company_name = filter($company_name); // check name only contains letters and whitespace
	}
	
	if($_SESSION['COUNTRY']=="INDIA" || $_SESSION['COUNTRY']=="IND" || $_SESSION['COUNTRY']=="IN"){
		
	if(empty($membership_id)){	$membershipIDError = "Membership ID should not be blank"; $flag=0;}
	
	if(empty($gst)){
	$gstNameError = "Please Enter GST No"; $flag=0;
	} else {
	$gst = filter($gst); // check name only contains letters and whitespace
	/*if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-5])([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}([a-zA-Z0-9]){1}([a-zA-Z]){1}([0-9]){1}?$/", $gst)) {
    $gstNameError = "Please Enter Valid GSTIN No."; $flag=0;
	} */	}
		
	if(empty($tan_no)){
	$tanNameError = "Please Enter TAN No"; $flag=0;
	} else {
	$tan_no = filter($tan_no); // check name only contains letters and whitespace
	/*if(!preg_match("/^[0-9]{10}$/",$tan_no)) {
	$tanNameError = "TAN No. must be exactly 10 digit"; $flag=0;
	}*/ }
	
	if(empty($region)){	$regionError = "Choose Region"; $flag=0;}
	if(empty($billing_address_id)){	$billing_addressError = "Choose Billing Address"; $flag=0;}
	if(empty($billing_gstin)){	$billing_gstinError = "Enter GSTIN"; $flag=0;}
	
	}
	
	if(empty($email)){
	$emailError ="Please Enter Email"; $flag=0;
	}else {
	$email = filter($email);
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	$emailError = "Please Enter Valid Email"; $flag=0;
	} }	
	
	if(empty($contact_person_co)){
	$contactPersonError = "Contact Person should not be blank"; $flag=0;
	} else {
	$contact_person_co = filter($contact_person_co); // check name only contains letters and whitespace
	if(!preg_match("/^[a-zA-Z ]*$/",$contact_person_co)) {
	$contactPersonError = "Please Enter Contact Person Name"; $flag=0;
	} }
	
	if(empty($contact_person_desg_show)){
	$contactDesignationError = "Designation should not be blank"; $flag=0;
	} else {
	$contact_person_desg_show = filter($contact_person_desg_show); // check name only contains letters and whitespace
	if(!preg_match("/^[a-zA-Z ]*$/",$contact_person_desg_show)) {
	$contactDesignationError = "Please Enter Designation"; $flag=0;
	} }
	
	if(empty($mobile)){
	$mobileError = "Mobile No should not be blank"; $flag=0;
	} else {
	$mobile = filter($mobile); // check name only contains letters and whitespace
	if(!preg_match("/^[0-9]{10}$/",$mobile)) {
	$mobileError = "Mobile No must be exactly 10 digit"; $flag=0;
	} }
	
	if(empty($contacts)){
	$contactsError = "Mobile No should not be blank";  $flag=0;
	} else {
	$contacts = filter($contacts); // check name only contains letters and whitespace
	if(!preg_match("/^[0-9]{10}$/",$contacts)) {
	$contactsError = "Mobile No must be exactly 10 digit"; $flag=0;
	} }
	//echo '----'.$flag;
	//if($flag==1) { echo 'ok'; exit; } else { echo 'not ok'; exit; }
	
	/* Validation End */
	if($flag==1) {
	if(empty($companyNameError) && empty($emailError) && empty($contactPersonError) && empty($contactDesignationError) && empty($mobileError) && empty($contactsError))
	{
	$sql="select * from exh_reg_general_info where uid='$registration_id' and event_for='$event_for' order by id desc limit 0,1";
	$query=mysql_query($sql);
	$num=mysql_num_rows($query);
	$result=mysql_fetch_array($query);
	$id=$result['id'];
	
	if($Action=="ADD" || $num==0)
	{
		 $sql="insert into exh_reg_general_info set uid='$registration_id',company_name='$company_name',membership_id='$membership_id',membership_date='$membership_date',bp_number='$bp_number',address1='$address1',address2='$address2',address3='$address3',billing_address_id='$billing_address_id',billing_gstin='$billing_gstin',billing_address1='$billing_address1',billing_address2='$billing_address2',billing_address3='$billing_address3',bcity='$bcity',bpincode='$bpincode',bcountry='$bcountry',btelephone_no='$btelephone_no',bfax_no='$bfax_no',billing_address_same='$billing_address_same',pan_no='$pan_no',tan_no='$tan_no',city='$city',pincode='$pincode',country='$country',telephone_no='$telephone_no',mobile='$mobile',fax_no='$fax_no',email='$email',gst='$gst',kyc='$kyc',website='$website',contact_person='$contact_person',contact_person_desg='$contact_person_desg',contact_person_desg_show='$contact_person_desg_show',contact_person_co='$contact_person_co',contacts='$contacts',event_for='$event_for',participant_type='No',region='$region',created_date='$created_date'";
		 mysql_query($sql);
		$gid=mysql_insert_id();
	}	
	else
	{	
		 $sql="update exh_reg_general_info set company_name='$company_name',membership_id='$membership_id',membership_date='$membership_date',bp_number='$bp_number',address1='$address1',address2='$address2',address3='$address3',billing_address_id='$billing_address_id',billing_gstin='$billing_gstin',billing_address1='$billing_address1',billing_address2='$billing_address2',billing_address3='$billing_address3',bcity='$bcity',bpincode='$bpincode',bcountry='$bcountry',btelephone_no='$btelephone_no',bfax_no='$bfax_no',billing_address_same='$billing_address_same',pan_no='$pan_no',tan_no='$tan_no',city='$city',pincode='$pincode',country='$country',telephone_no='$telephone_no',mobile='$mobile',fax_no='$fax_no',email='$email',gst='$gst',kyc='$kyc',website='$website',contact_person='$contact_person',contact_person_desg='$contact_person_desg',contact_person_desg_show='$contact_person_desg_show',contact_person_co='$contact_person_co',contacts='$contacts',event_for='$event_for',region='$region',modified_date='$created_date' where id='$id' and uid='$registration_id'";
		mysql_query($sql);
		$gid=$id;
	}
	header('location:exhibitor_registration_step_2.php?gid='.$gid);
	} else { $signup_error = "Something wrong in Form Registration. Please register with correct values."; }
	} else { $signup_error = "Something wrong in Form Registration. Please register with correct values."; }

}
?>
<?php 
   /*.......................Basic Information From Registration ..................................*/
	$registration_id=intval($_SESSION['USERID']);
	$sql="select * from exh_reg_general_info where uid='$registration_id' and event_for='$event_for' order by id desc limit 0,1";
	$query=mysql_query($sql);
	$num=mysql_num_rows($query);
	$result=mysql_fetch_array($query);
	$id=$result['id'];
	if($num>0)
	{
		$email=$result['email'];
		$company_name=$result['company_name'];
		$address1=htmlentities(strip_tags($result['address1']));
		$address2=htmlentities(strip_tags($result['address2']));
		$address3=htmlentities(strip_tags($result['address3']));
		$billing_address_id=htmlentities(strip_tags($result['billing_address_id']));
		$billing_gstin=htmlentities(strip_tags($result['billing_gstin']));
		$billing_address1=htmlentities(strip_tags($result['billing_address1']));
		$billing_address2=htmlentities(strip_tags($result['billing_address2']));
		$billing_address3=htmlentities(strip_tags($result['billing_address3']));		
		$bcity=htmlentities(strip_tags($result['bcity']));
		$bpincode=htmlentities(strip_tags($result['bpincode']));
		$bcountry=htmlentities(strip_tags($result['bcountry']));
		$btelephone_no=htmlentities(strip_tags($result['btelephone_no']));
		$bfax_no=htmlentities(strip_tags($result['bfax_no']));
		$billing_address_same=htmlentities(strip_tags($result['billing_address_same']));
		$pan_no=htmlentities(strip_tags($result['pan_no']));
		$tan_no=$result['tan_no'];
		$city=$result['city'];
		$telephone_no=$result['telephone_no'];
		$mobile=$result['mobile'];
		$website=$result['website'];
		$fax_no=$result['fax_no'];
		$pincode=$result['pincode'];
		$gst=htmlentities(strip_tags($result['gst']));
		$tin=htmlentities(strip_tags($result['tin']));
		$kyc=htmlentities(strip_tags($result['kyc']));
		$website=$result['website'];
		$contact_person=$result['contact_person'];
		$contact_person_desg=$result['contact_person_desg'];
		$contact_person_desg_show=$result['contact_person_desg_show'];
		$contact_person_co=$result['contact_person_co'];
		$contacts=$result['contacts'];
		$region=$result['region'];		
	}	
	else
	{		
		/*..........................Get Company from registration...............................*/
		$cquery=mysql_query("select company_name from registration_master where id='$registration_id'");
		$cresult=mysql_fetch_array($cquery);
		$company_name=$cresult['company_name'];		

		$query1=mysql_query("select address1,address2,address3,pincode,city from communication_address_master where registration_id='$registration_id' and type_of_address='2'");
		$result1=mysql_fetch_array($query1);
		$address1=$result1['address1'];
		$address2=$result1['address2'];
		$address3=$result1['address3'];
		$pincode=str_replace(' ', '', $result1['pincode']);
		$city=$result1['city'];
		
		$sql="select * from information_master where registration_id='$registration_id'";
		$query=mysql_query($sql);
		$result=mysql_fetch_array($query);
		$email=$result['email_id'];
		
		$telephone_no=$result['land_line_no'];
		$mobile=$result['mobile_no'];
		$website=$result['website'];
		$fax_no=$result['fax_no'];		
		$country=$result['country'];
		$website=$result['website'];
		$contact_person = strtoupper($result['name']);
		$contact_person_desg=trim($result['designation']);
		
		if($contact_person_desg == "ZDIRCT"){ $contact_person_desg ="Director"; }
		if($contact_person_desg == "ZPARTN"){ $contact_person_desg ="Partner"; }
		if($contact_person_desg == "ZPROPT"){ $contact_person_desg ="Proprietor"; }
		if($contact_person_desg == "ZKARTA"){ $contact_person_desg ="Karta of HUF"; } 
		
		$region=$result['region_id'];
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Exhibitor Registration Step 1 </title>
<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
<!--navigation script-->
<script type="text/javascript" src="js/jquery_002.js"></script>
<!--<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>    -->  
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

<!--navigation script end-->
<!-- small slider -->
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>

<!-- SLIDER -->
	<script type="text/javascript">
	$(document).ready(function(){	
	$('#imgSlider').cycle({ 
			fx:    'scrollHorz', 
			timeout: 6000, 
			delay: -1000,
			prev:'.prev1',
			next:'.next1', 
		});
	});
	</script>
<!--  SLIDER Starts  -->

<link href="css/slider.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
$(function() {
	$("#scroller .item").css("width", 986);
	$("#scroller").scrollable({
			circular: true,
			speed: 1500
	}).autoscroll({ interval: 9000 }).navigator();
	api = $('#scroller').data("scrollable");
	$(window).resize(function() {
		if($('#scroller .items:animated').length == 0) {
			$("#scroller .item").css("width", $(document).width());
			nleft = $(document).width() * (api.getIndex() + 1);
			$("#scroller .items").css("left", "-"+nleft+"px");
		}
	});
});
</script>
<!--  SLIDER Ends  -->
<!-- place holder script for ie -->
<script type="text/javascript">
    $(function() {
        if (!$.support.placeholder) {
            var active = document.activeElement;
            
            $(':text').focus(function() {
                if ($(this).attr('placeholder') != '' && $(this).val() == $(this).attr('placeholder')) {
                    $(this).val('').removeClass('hasPlaceholder');
                }
            }).blur(function() {
                if ($(this).attr('placeholder') != '' && ($(this).val() == '' || $(this).val() == $(this).attr('placeholder'))) {
                    $(this).val($(this).attr('placeholder')).addClass('hasPlaceholder');
                }
            });
            $(':text').blur();
         
            $(active).focus();           
        }
    });
</script>    

<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<!--<link rel="stylesheet" type="text/css" media="screen" href="css/rcmc.validation.css" />-->

<script type="text/javascript">
$().ready(function() {
	$("#commentForm").validate()
	$("#form1").validate({
		rules: {
			gst: {
			required: true,
			minlength: 15,
			maxlength:15
			},
			tan_no: {
			required: true,
			minlength: 10,
			maxlength:10
			},
			address1: {
			required: true,
			},  
			city: {
				required: true,
			},  
			pincode: {
				required: true,
			}, 	 
			country: {
				required: true,
				},
			telephone_no:{
				required: true,
			},
			mobile: {
				required: true,
				number:true,
				minlength: 10,
				maxlength:10
			},
			email: {
				required: true,
				email:true
			},
			billing_address_id:{
				required:true,
			},
			billing_gstin:{
				required:true,
			},
			contact_person:{
				required:true,
			},
			contact_person_co:{
				required:true,
			},
			contact_person_desg:{
				required:true,
			},
			contact_person_desg_show:{
				required:true,
			},			
			contacts: {
				required: true,
				number:true,
				minlength: 10,
				maxlength:10
			},
		},
		messages: {			
			gst: {
				required: "Please Enter GST No",
				minlength:"Please Enter 15 digit.",
				maxlength:"Please Enter No more than 15 digit."
			},
			tan_no: {
				required: "Please Enter TAN No",
				minlength:"Please Enter 10 digit.",
				maxlength:"Please Enter No more than 10 digit."
			},			
			address1: {
				required: "Required",
			},  
			city: {
				required: "Required",
			},
			pincode:{
				required: "Required",
			} ,
			country: {
				required: "Required",
			},
		    telephone_no:{
		   		required: "Required",
			},
			mobile: {
				required:"Please Enter Mobile Number",
				number:"Please Enter Numbers only",
				minlength:"Please enter at least 10 digit.",
				maxlength:"Please enter no more than 0 digit."
			},   
		    email: {
				required: "Required",
				email:"Please enter valid email id"
			},
			billing_address_id: {
				required: "Please Choose Billing Address",
			},
			billing_gstin: {
				required: "Please Enter Billing GSTIN",
			},
			contact_person:{
				required: "Please Enter Contact Person",
			},
			contact_person_co:{
				required: "Please Enter Contact Person",
			},
			contact_person_desg:{
				required: "Please Enter Designation",
			},
			contact_person_desg_show:{
				required: "Please Enter Designation",
			},			
			contacts: {
				required:"Please Enter Mobile Number",
				number:"Please Enter Numbers only",
				minlength:"Please enter at least 10 digit.",
				maxlength:"Please enter no more than 0 digit."
			},
	 }
	});
});
</script>
<!--http://www.plus2net.com/javascript_tutorial/copy-data-demo.php-->
<!--<script type="text/javascript">
function data_copy()
{
if(document.getElementById("form1").address[0].checked){
document.getElementById("baddress1").value=document.getElementById("address1").value;
document.getElementById("baddress2").value=document.getElementById("address2").value;
document.getElementById("baddress3").value=document.getElementById("address3").value;

document.getElementById("bcity").value=document.getElementById("city").value;
document.getElementById("bpincode").value=document.getElementById("pincode").value;
document.getElementById("bcountry").value=document.getElementById("country").value;
document.getElementById("btelephone_no").value=document.getElementById("telephone_no").value;
document.getElementById("bfax_no").value=document.getElementById("fax_no").value;
}else{
document.getElementById("baddress1").value="";
document.getElementById("baddress2").value="";
document.getElementById("baddress3").value="";
document.getElementById("bcity").value="";
document.getElementById("bpincode").value="";
document.getElementById("bcountry").value="";
document.getElementById("btelephone_no").value="";
document.getElementById("bfax_no").value="";
}
}
</script>-->
<style>
.container_left1 {
    width: 900px;
    height: auto;
    float: left;
    text-align: justify;
}
#form1 label {
    min-width: 150px;
    display: block;
    float: left;
    /* font-weight: bold; */
    font-size: 12px;
    vertical-align: middle;
    padding-top: 5px;
    color: #751c54;
}
#form1 .field {
    background: #ffffff;
    padding: 3px 20px 3px 20px;
    margin-bottom: 1px;
    float: left;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
		//alert('hello');
		$('#billing_address_id').change(function(){
				//alert($( this ).val());
				var option = $(this).val();
			
			  $.ajax({ type: 'POST',
					url: 'ajax_get_child_address.php',
					data: "actiontype=optionValue&&option="+option,
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
</head>

<body>
<!-- header starts -->

<div class="header_wrap">
	<?php include ('header.php'); ?>
</div>

<!-- header ends -->
<div class="clear"></div>
<div class="clear"></div>

<!--container starts-->
<div class="container_wrap">
	<div class="container">
    	<div class="container_left1">
        	<span class="headtxt">Exhibitor Registration</span>
<div id="loginForm">

<div id="formContainer">      
<div class="clear bottomSpace"></div>
    <div class="title">
        <h4>Step 1 : GENERAL INFORMATION</h4><?php if(isset($signup_error) ){ echo '<span style="color: red;" />'.$signup_error.'</span>';} ?>
    </div>
	<div class="clear"></div>
	<div class="borderBottom"></div>
 <form class="cmxform" method="post" name="from1" id="form1">
 <div id="form">
      <div class="field">
         <label>Company Name : </label>
            <input type="text" class="textField" id="company_name" name="company_name" value="<?php echo stripcslashes(strtoupper($company_name));?>" readonly="readonly"/>
			<?php if(isset($companyNameError) ){ echo '<span style="color: red;" />'.$companyNameError.'</span>';} ?>
            <div class="clear"></div>            
      </div>
	  <?php if($_SESSION['COUNTRY']=="IND" || $_SESSION['COUNTRY']=="INDIA" || $_SESSION['COUNTRY']=="India" || $_SESSION['COUNTRY']=="IN"){ ?>
      <div class="field">
        	<label>Membership ID : </label>
        	<input type="text" class="textField" id="membership_id" name="membership_id" value="<?php echo getMembershipId($_SESSION['USERID']);?>" readonly="readonly"/>
            <div class="clear"></div><?php if(isset($membershipIDError) ){ echo '<span style="color: red;" />'.$membershipIDError.'</span>';} ?>
      </div>
      <div class="field">
        	<label>Membership Date : </label>
        	<input type="text" class="textField" id="membership_date" name="membership_date" value="<?php echo getMembership_Issued_Dt($_SESSION['USERID']);?>" readonly="readonly"/>
            <div class="clear"></div>
      </div>
	  <div class="field">
            <label>GSTIN No. <sup>*</sup></label>
            <input name="gst" id="gst" type="text" class="textField" value="<?php echo $gst;?>" maxlength="15" autocomplete="off"/>			
            <div class="clear"></div><?php if(isset($gstNameError) ){ echo '<span style="color: red;" />'.$gstNameError.'</span>';} ?>
      </div>
	  <div class="field">
            <label>TAN No. <sup>*</sup></label>
            <input name="tan_no" id="tan_no" type="text" class="textField" value="<?php echo $tan_no;?>" maxlength="10" autocomplete="off"/>			
            <div class="clear"></div><?php if(isset($tanNameError) ){ echo '<span style="color: red;" />'.$tanNameError.'</span>';} ?>
      </div>
	  <div class="field">
            <label>KYC No. </label>
            <input name="kyc" id="kyc" type="text" class="textField" value="<?php echo $KycProfileId;?>" readonly="readonly"/>
            <div class="clear"></div>
      </div>
	  <div class="field">
            <label>BP No. </label>
            <input name="bp_number" id="bp_number" type="text" class="textField" value="<?php echo getBPNO($_SESSION['USERID']);?>" readonly="readonly"/>
            <div class="clear"></div>
      </div>
	  <?php } ?>
	  <div class="clear"></div>
	  <div class="field fullclass"><b>Office Address</b>:
	  <div class="clear"></div>
	  </div>
	  <div class="clear"></div>		
        <div class="field">
        	<label>Address 1: <sup>*</sup></label>
        	<input type="text" class="textField" id="address1" name="address1" value="<?php echo $address1;?>" />
            <div class="clear"></div>
        </div>
        <div class="field">
        	<label>Address 2:  </label>
       		<input type="text" class="textField" id="address2" name="address2" value="<?php echo $address2;?>" />
            <div class="clear"></div>
        </div>
		<div class="clear"></div>
        <div class="field">
        	<label>Address 3: </label>
      		<input type="text" class="textField" id="address3" name="address3" value="<?php echo $address3;?>" />
            <div class="clear"></div>
        </div>
		<div class="field">
        	<label>City: <sup>*</sup> </label>
       		<input type="text" class="textField" id="city" name="city" value="<?php echo $city;?>" autocomplete="off"/>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <div class="field">
        	<label>Pincode: <sup>*</sup> </label>
       		<input type="number" class="textField" id="pincode" name="pincode" value="<?php echo $pincode;?>" autocomplete="off" onKeyPress="if(this.value.length==10) return false;"/>
            <div class="clear"></div>
        </div>
        
        <div class="field">
        <label>Country : <sup>*</sup></label>
        <select name="country" id="country" class="textField">
            <option value="">---------- Select ----------</option>
            <?php
			$sql="SELECT * FROM country_master";			
            $query=mysql_query($sql);
            while($result=mysql_fetch_array($query)){ ?>
            <!--<option value="<?php echo $result['country_name'];?>" <?php if($result['country_name']==$country){?> selected="selected" <?php }?> ><?php echo $result['country_name'];?></option>-->
			<option value="<?php echo $result['country_code'];?>" <?php if($result['country_code']==$country){?> selected="selected" <?php } else if($result['country_code']=="IN" || $result['country_code']=="IND"){?> selected="selected"<?php }?>><?php echo strtoupper($result['country_name']);?></option>
            <?php }?>
        </select>
				
	   <div class="clear"></div>
       </div>
	   <div class="clear"></div>
	   
        <div class="field">
        <label>Telephone No : <sup>*</sup></label>
        <input type="text" class="textField" id="telephone_no" name="telephone_no" value="<?php echo $telephone_no;?>" />
        <div class="clear"></div>
        </div>
        
        <div class="field">
            <label>Fax No :</label>
           		<input type="text" class="textField" id="fax_no" name="fax_no" value="<?php echo $fax_no;?>" />
            <div class="clear"></div>
        </div> 
		<div class="clear"></div>
		<div class="field">
            <label style="padding-top:0px;">Email : <sup>*</sup></label>
            <input type="email" class="textField" id="email" name="email" value="<?php echo $email;?>" autocomplete="off"/>
            <div class="clear"></div><?php if(isset($emailError) ){ echo '<span style="color: red;" />'.$emailError.'</span>';} ?>
        </div>
        
        <div class="field">
            <label style="padding-top:0px;">Website :</label>
            <input type="url" class="textField" id="website" name="website" value="<?php echo $website;?>" autocomplete="off"/>
            <div class="clear"></div>
        </div>
		<div class="field">
        	<label>Contact Person: <sup>*</sup></label>
        	<input type="text" class="textField" id="contact_person" name="contact_person" value="<?php echo $contact_person;?>" autocomplete="off"/>
        	<div class="clear"></div>
        </div>
		
        <div class="field">
        <label>Contact Person For Show Co Ordination <sup>*</sup> </label>
        <input type="text" class="textField" id="contact_person_co" name="contact_person_co" value="<?php echo $contact_person_co;?>" autocomplete="off"/>	
        <div class="clear"></div><?php if(isset($contactPersonError) ){ echo '<span style="color: red;" />'.$contactPersonError.'</span>';} ?>
        </div>
		
		<div class="field">
            <label style="padding-top:0px;">Designation <sup>*</sup></label>
            <input type="text" class="textField" id="contact_person_desg" name="contact_person_desg" value="<?php echo $contact_person_desg;?>" autocomplete="off"/>
            <div class="clear"></div>
        </div>
		<div class="field">
            <label style="padding-top:0px;">Designation <sup>*</sup></label>
            <input type="text" class="textField" id="contact_person_desg_show" name="contact_person_desg_show" value="<?php echo $contact_person_desg_show;?>" autocomplete="off"/>
            <div class="clear"></div><?php if(isset($contactDesignationError) ){ echo '<span style="color: red;" />'.$contactDesignationError.'</span>';} ?>
        </div>		
		
		<div class="field">
        	<label>Mobile No : <sup>*</sup></label>
        	<input type="text" class="textField" id="mobile" name="mobile" value="<?php echo $mobile;?>" maxlength="10" autocomplete="off"/>			
            <div class="clear"></div><?php if(isset($mobileError) ){ echo '<span style="color: red;" />'.$mobileError.'</span>';} ?>
        </div>			
		
		<div class="field">
        <label>Mobile No. : <sup>*</sup></label>
        <input type="text" class="textField" id="contacts" name="contacts" value="<?php echo $contacts;?>" maxlength="10" autocomplete="off"/>		
        <div class="clear"></div><?php if(isset($contactsError) ){ echo '<span style="color: red;" />'.$contactsError.'</span>';} ?>
        </div>
		<div class="field">
         <label>Select Region:</label>
         <select class="textField" name="region" id="region">
            <option value="" >--- Select ---</option>
          <?php
		  $sql3="SELECT * FROM `region_master` WHERE `status`='1'";  
		  $result3=mysql_query($sql3);
		  while($rows3=mysql_fetch_array($result3))
		  { ?>
            <option value="<?php echo $rows3['region_name'];?>" <?php if($rows3['region_name']==$region){?> selected="selected" <?php }?> ><?php echo $rows3['region_full_name'];?></option>
          <?php } ?>
          </select>
		  <!--<input type="hidden" name="region" id="region" value="<?php echo $region;?>"/>-->
		<!--<select class="textField" name="region" id="region" >			
			  <?php  if($_SESSION['COUNTRY']=="IND" || $_SESSION['COUNTRY']=="INDIA" || $_SESSION['COUNTRY']=="IN"){ ?>
			  <option value="">--- Select Region ---</option>	
			  <?php
			  $sql3="SELECT * FROM `region_master` WHERE 1 and `status`='1'";
			  $result3=mysql_query($sql3);
			  while($rows3=mysql_fetch_array($result3))
			  { //echo $rows3['sap_value'].'--'.$region.'--'.$rows3['region_name'].'---'.$region;?>
			  <option value="<?php echo $rows3['sap_value'];?>" <?php if($rows3['sap_value']==$region || $rows3['region_name']==$region){?> selected="selected" <?php }?>><?php echo $rows3['region_full_name'];?></option>
			<?php }	  } else { echo $region ==1010;	 ?>            
			<option value="1010" selected="selected">HEAD OFFICE - MUMBAI</option>        
			<?php } ?>
		</select> -->     
        <div class="clear"></div><?php if(isset($regionError) ){ echo '<span style="color: red;" />'.$regionError.'</span>';} ?>
        </div>  
		
		<!------------------------------------ Start Billing Address ------------------------------------------->
		<?php if($_SESSION['COUNTRY']=="IND" || $_SESSION['COUNTRY']=="INDIA" || $_SESSION['COUNTRY']=="India" || $_SESSION['COUNTRY']=="IN"){ ?>
		<div class="clear"></div>
		<div class="field fullclass"><b>Choose Your Billing Address</b>:
		<select name="billing_address_id" id="billing_address_id" class="textField">
            <option value="">--- Choose Billing Address ---</option>
            <?php
			$commAddress2 = "SELECT * FROM `communication_address_master` WHERE `registration_id` = '$registration_id' AND address_identity='CTC' AND c_bp_number!=''";
			$result2 = mysql_query($commAddress2);
			while($addChild = mysql_fetch_array($result2)){ ?>
			<option value="<?php echo $addChild['id'];?>" <?php if($billing_address_id == $addChild['id']) echo 'selected="selected"';?>>
			<?php echo $addChild['address1'].'-'.$addChild['city'];?></option>			
            <?php } ?>
        </select>
		<div class="clear"></div><?php if(isset($billing_addressError) ){ echo '<span style="color: red;" />'.$billing_addressError.'</span>';} ?>
		</div>
		<div class="clear"></div>
		<div class="field">
        <label>Billing GSTIN : <sup>*</sup></label>
        <input type="text" class="textField" id="billing_gstin" name="billing_gstin" value="<?php echo $billing_gstin;?>" maxlength="15" minlength="15" autocomplete="off"/>
        <div class="clear"></div><?php if(isset($billing_gstinError) ){ echo '<span style="color: red;" />'.$billing_gstinError.'</span>';} ?>
        </div>
		<div class="clear"></div>
		<div class="field">
        <label>Address 1: <sup>*</sup></label>
        <input type="text" class="textField" id="baddress1" name="baddress1" value="<?php echo $billing_address1;?>" readonly/>
        <div class="clear"></div>
        </div>
        <div class="field">
        <label>Address 2:  </label>
       	<input type="text" class="textField" id="baddress2" name="baddress2" value="<?php echo $billing_address2;?>" readonly/>
        <div class="clear"></div>
        </div>
		<div class="clear"></div>
        <div class="field">
        <label>Address 3: </label>
      	<input type="text" class="textField" id="baddress3" name="baddress3" value="<?php echo $billing_address3;?>" readonly/>
        <div class="clear"></div>
        </div>		
        <div class="field">
        <label>City: <sup>*</sup> </label>
       	<input type="text" class="textField" id="bcity" name="bcity" value="<?php echo $bcity;?>" autocomplete="off" readonly/>
        <div class="clear"></div>
        </div>        
        <div class="field">
        <label>Pincode: <sup>*</sup> </label>
       	<input type="number" class="textField" id="bpincode" name="bpincode" value="<?php echo $bpincode;?>" autocomplete="off" onKeyPress="if(this.value.length==9) return false;" readonly/>
        <div class="clear"></div>
        </div>
        	   
        <div class="field">
        <label>Telephone No : <sup>*</sup></label>
        <input type="text" class="textField" id="btelephone_no" name="btelephone_no" value="<?php echo $btelephone_no;?>" readonly/>
        <div class="clear"></div>
        </div>
		<div class="clear"></div>
		<?php } ?>
        <!------------------------------------ End Billing Address ------------------------------------------->  
        		                      
	<div class="clear"></div>
    <div class="maroonBtn">
        <input type="submit" class="newMaroonBtn" value="Proceed to Next Step"/>
        <input type="hidden" name="action" id="action" value="Save"/>
        <input type="hidden" name="Action" id="Action" value="<?php echo $Action?>"/>
    </div> 
	<div class="clear"></div>
</div>
</form>
		</div>
	</div>
</div> 
        <?php //include ('rightContent.php'); ?>
        <div class="clear"></div>
    </div>
    <div class="container_2">
    	<?php include ('container2.php'); ?>
    </div>
</div>
<!--container ends-->
<!--footer starts-->
<div class="footer_wrap"><?php include ('footer.php');?></div>
<!--footer ends-->
</body>
</html>