<?php
include('header_include.php');
$action=$_REQUEST['action'];
if($action=="ADD")
{	
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
		
	if(empty($_SESSION['captcha_code'] ) ||  strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0)
	{
		$_SESSION['err_msg']= "The captcha code does not match!";
	}
	else {
	$USER_NAME="NM".rand(0,999999);
	$NON_MEMBER_NAME=filter($_REQUEST['NON_MEMBER_NAME']);
	$company_type=filter($_REQUEST['company_type']);
	$company_pan_no	=	strtoupper(filter($_REQUEST['company_pan_no']));
	$company_gstn	=	strtoupper(filter($_REQUEST['company_gstn']));
	$ADDRESS1=filter($_REQUEST['ADDRESS1']);
	$ADDRESS2=filter($_REQUEST['ADDRESS2']);
	$ADDRESS3=filter($_REQUEST['ADDRESS3']);
	$ADDRESS4=filter($_REQUEST['ADDRESS4']);
	$COUNTRY_ID=filter($_REQUEST['COUNTRY_ID']);
	$COUNTRY=getOrginCountryName($COUNTRY_ID);
	$STATE_ID=filter($_REQUEST['STATE_ID']);
	$STATE=getOrginStateName($STATE_ID);
	$CITY=filter($_REQUEST['CITY']);
	$PINCODE=filter($_REQUEST['PINCODE']);
	$TELEPHONE1=filter($_REQUEST['TELEPHONE1']);
	$TELEPHONE2=filter($_REQUEST['TELEPHONE2']);
	$FAX=filter($_REQUEST['FAX']);
	$MOBILE=filter($_REQUEST['MOBILE']);
	$EMAIL=filter($_REQUEST['EMAIL']);
	$WEBSITE=filter($_REQUEST['WEBSITE']);
	$CONTACT_PERSON1=filter($_REQUEST['CONTACT_PERSON1']);
	$CONTACT_PERSON2=filter($_REQUEST['CONTACT_PERSON2']);
	$DESIGNATION1=getLookupName($_REQUEST['DESIGNATION1']);
	$DESIGNATION2=getLookupName($_REQUEST['DESIGNATION2']);
	$IEC_NO=filter($_REQUEST['IEC_NO']);
	$REMARKS=filter($_REQUEST['REMARKS']);
	$SEEPZ=filter($_REQUEST['SEEPZ']);
	$LOCATION=getRegionName($_REQUEST['LOCATION']);
	$FILE_UPLOAD=filter($_REQUEST['FILE_UPLOAD']);

	$query=mysql_query("select * from kp_non_member_master where EMAIL='$EMAIL' or company_pan_no='$company_pan_no' or MOBILE='$MOBILE'");
	$num=mysql_num_rows($query);
	if($num>0)
	{	
		$_SESSION['err_msg']="Already registered with this Email id or PAN no or Mobile No";
	} else
	{
	$sql="INSERT INTO `kp_non_member_master` (`NON_MEMBER_NO`, `NON_MEMBER_NAME`, `SHORT_NAME`, `company_type`,company_pan_no,company_gstn, `USER_NAME`, `PASSWORD`, `ADDRESS1`, `ADDRESS2`, `ADDRESS3`, `ADDRESS4`, `STATE_ID`, `STATE`, `CITY_ID`, `CITY`, `PINCODE`, `COUNTRY_ID`, `COUNTRY`, `TELEPHONE1`, `TELEPHONE2`, `FAX`, `MOBILE`, `EMAIL`, `WEBSITE`, `CONTACT_PERSON1`, `DESIGNATION1`, `CONTACT_PERSON2`, `DESIGNATION2`, `IEC_NO`, `REMARKS`, `STATUS`, `SPACE_SOFT_ID`, `SPACE_SOFT_NUMBER`, `SR_NO`, `LOCATION`, `ENTERED_BY`, `ENTERED_ON`, `MODIFIED_ON`, `MODIFIED_BY`, `REASON`) VALUES ('$USER_NAME', '$NON_MEMBER_NAME', NULL, '$company_type', '$company_pan_no','$company_gstn','$USER_NAME', '$USER_NAME', '$ADDRESS1', '$ADDRESS2', '$ADDRESS3', '$ADDRESS4', '$STATE_ID', '$STATE', '$CITY_ID', '$CITY', '$PINCODE', '$COUNTRY_ID', '$COUNTRY', '$TELEPHONE1', '$TELEPHONE2', '$FAX', '$MOBILE', '$EMAIL', '$WEBSITE', '$CONTACT_PERSON1','$DESIGNATION1', '$CONTACT_PERSON2', '$DESIGNATION2', '$IEC_NO', '$REMARKS', '1', '0', '0', '0', '$LOCATION',  'ADMIN', NOW(), NOW(), 'Admin', '$REASON')";
			
	if(!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	} else
	{
		  $message = "<font style='font-size: 13px; color: black; font-family: arial'>";		  
		  $message = $message .= "<strong>Thank You Registration with us. </strong><br>";
		  $message = $message .= "<strong>Registration Details : </strong><br>";
		  $message = $message .= "AGENT No : $USER_NAME<br>";  
		  $message = $message .= "NON MEMBER Name : $NON_MEMBER_NAME<br>"; 
		  $message = $message .= "Username : $USER_NAME<br>"; 
		  $message = $message .= "Password : $USER_NAME<br>";
		  $message = $message .= "City :$CITY<br></br>"; 
		  $message = $message .= "</font>";		  
		   
		  $subject = "NON MEMBER Registration For Kimberley Process"; 		
		 $headers  = 'MIME-Version: 1.0' . "\r\n"; 
		 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
		 $headers .= 'From:admin@gjepc.org';
		 $to=$EMAIL;
		 if($EMAIL!="")
		 {			
			mail($to, $subject, $message, $headers);
		 }
	$_SESSION['succ_msg']="You have successfully registered. Check your Email For username and password ";	 
	}
	}
	 
	}
	} else {
	 $_SESSION['err_msg']="Invalid Token Error";
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GJEPC | Non Member Registration</title>
<!-- Main css -->
<?php include ('maincss.php') ?>
<!-- Main css -->

<script src="jsvalidation/jquery.js" type="text/javascript"></script>
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<link rel="stylesheet" type="text/css" media="screen" href="css/cmxform.css" /> 
<script type="text/javascript">
$().ready(function() {
	jQuery.validator.addMethod("specialChrs", function (value, element) {
	if (/[^a-zA-Z 0-9\-]+$/i.test(value)) {
        return false;
    } else {
        return true;
   };
   },	"Special Characters Not Allowed");
   
	jQuery.validator.addMethod("panno", function (value, element) {
	var regExp = /[a-zA-z]{5}\d{4}[a-zA-Z]{1}/; 
		if (value.match(regExp) ) {
			return true;
		} else {
			return false;
		};
		},"Please Enter Valid PAN No.");
		
	$("input[type='radio']").on('change', function () {
         var gst_holder = $("input[name='gst_holder']:checked").val();
         if (gst_holder=='N')
               $("#company_gstn").val("NA");
		  else
		  	$("#company_gstn").val("Company GSTIN");
     });
	 
	 $("input[type='radio']").on('change', function () {
         var seepz_holder = $("input[name='SEEPZ']:checked").val();
         if (seepz_holder=='No')
               $("#LOCATION").val("NA");
		  else
		  	$("#LOCATION").val("Company GSTIN");
     });
	
	$.validator.addMethod("gstno", function(value, element) {
	if(value=='NA')
		return true;
	else {
	return this.optional(element) || /^([0][1-9]|[1-2][0-9]|[3][0-7])([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$/.test(value);
	} }, "Please Enter Valid GSTIN No.");

	$("#form1").validate({
		rules: {			
			NON_MEMBER_NAME: {
				required: true,
			},
			company_type: {
				required: true,
			},
			gst_holder:"required",
			company_pan_no: {
				required: true,
				panno: true,
				minlength: 10,
				maxlength:10
			},			
			company_gstn: {
				required: true,
				gstno:true
			},
			ADDRESS1: {
				required: true,
				specialChrs: true
			},
			ADDRESS2: {
				required: true,
				specialChrs: true
			},
			COUNTRY_ID: {
				required: true,
			},
			STATE_ID: {
				required: true,
			},
			CITY: {
				required: true,
				specialChrs: true
			},
			PINCODE: {
				required: true,
				number:true,
				minlength:6,
				maxlength:6
			},
			TELEPHONE1: {
				required: true,
				number:true
			},
			MOBILE: {
				required: true,
				number:true,
				minlength: 10,
				maxlength:10
			},
			EMAIL: {
				required: true,
				email:true
			},
			IEC_NO:	{
				required: true,
				minlength: 10,
				maxlength:10
			},
			SEEPZ:"required",
			LOCATION:"required",
			captcha_code:{
				required: true,
			},
		},
		messages: {			  
			NON_MEMBER_NAME: {
				required: "Please Enter Company Name",
			},
			company_type: {
				required: "Please Select Company type",
			},
			gst_holder: "Please select your eligibility for GST",
			company_gstn: {
				required: "Please Enter Company GSTIN",
			},
			company_pan_no: {
				required: "Please Enter Company PAN No",
				minlength:"Please enter at least {10} digit.",
				maxlength:"Please enter no more than {0} digit."
			},
			ADDRESS1: {
				required: "Please Enter Your Address",
			},
			ADDRESS2: {
				required: "Please Enter Your Address",
			},
			COUNTRY_ID: {
				required: "Please Choose Country",
			},
			STATE_ID: {
				required: "Please Choose state",
			}, 
			CITY: {
				required: "Please Enter City",
			},
			PINCODE: {
				required: "Please Enter your pin code",
				number:"Please Enter numbers only",
				minlength:"Please Enter not less than 6 characters",
				maxlength:"Please Enter not more than 6 characters"				
			},
			TELEPHONE1: {
				required: "Please Enter Telephone number",
				number:"Please Enter Numbers only"
			},
			MOBILE: {
				required:"Please Enter Mobile Number",
				number:"Please Enter Numbers only",
				minlength:"Please enter at least {10} digit.",
				maxlength:"Please enter no more than {0} digit."
			},
			EMAIL: {
				required: "Please Enter a valid Email id",
			},		
			IEC_NO: {
				required: "Please Enter a valid IEC No",
				minlength:"Please enter at least {10} digit.",
				maxlength:"Please enter no more than {0} digit."
			},
			SEEPZ: "Do You Belong To Seepz?",
			LOCATION: "Select location",
			captcha_code:{
				required: "Please Enter Captcha Code",
			}
	 }
	});
});
</script>
<script language='JavaScript' type='text/javascript'>
function refreshCaptcha()
{
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>
<script>
$(document).ready(function(){
	  
      $('.gstholder_status_no').click(function(){
		$("#gst_status").attr('disabled',true);
		$('#company_gstn').attr('placeholder','Not Applicable');
		$('#company_gstn').attr('disabled',true);
      });
	  $('.gstholder_status_yes').click(function(){
        $('#company_gstn').attr('placeholder','GST Number');
		$('#company_gstn').attr('disabled',false);
      });
	  
	  $('.seepzholder_status_no').click(function(){
		$("#gst_status").attr('disabled',true);
		$('#LOCATION').attr('placeholder','Not Applicable');
		$('#LOCATION').attr('disabled',true);
      });
	  $('.seepzholder_status_yes').click(function(){
        $('#LOCATION').attr('placeholder','GST Number');
		$('#LOCATION').attr('disabled',false);
      });
});
</script>
<SCRIPT type="text/javascript">
$(document).ready(function() {
$("#COUNTRY_ID").change(function(){
	var COUNTRY_ID=$("#COUNTRY_ID").val();
	//alert(COUNTRY_ID);
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=getState&COUNTRY_ID="+COUNTRY_ID,
					dataType:'html',
					beforeSend: function(){
							$('.loaderWrapper').show();
							},
					success: function(data){
							$('.loaderWrapper').hide();
							    // alert(data);
							     $("#stateDiv").html(data);  
							}
		});
 });
/*
$("#STATE_ID").live('change',function(){
	var STATE_ID=$("#STATE_ID").val();
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=getCity&STATE_ID="+STATE_ID,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							    // alert(data);
							     $("#cityDiv").html(data);  
							}
		});
 });
		*/				   
});
</SCRIPT>
<style>
.loaderWrapper {
    display: none;
}
</style>
</head>

<body>
<!-- main -->
<div class="main">
<!-- Top -->
<?php include ('top.php') ?>
<!-- Top -->
<div class="inner_mainwidth">
<div class="online_business_banner">

<!-- Midle Bg -->
<div class="midletable_img"><img src="images/inner_top_bg_new.png" /></div>
<?php
if($_SESSION['succ_msg']!=""){
echo "<span style='color: green;'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
if($_SESSION['err_msg']!=""){
echo "<span style='color: red;'>".$_SESSION['err_msg']."</span>";
$_SESSION['err_msg']="";
}
?>
<div class="inner_midle_bg">
<div class="text_heading">Non Member Registration</div>

<div class="text_bread1"><a href="kimberley_process_search_applications.php">Home</a> > Kimberley Process > Non Member Registration</div>
<div class="clear"></div>
<div class="loaderWrapper">
  <div class="formLoader"><img src="images/loading.gif" alt=""></div>
</div>
<div class="midletext">

<!-- Midle -->
<form class="cmxform" method="post" name="from1" id="form1" enctype="multipart/form-data" onSubmit="return validate()">
<input type="hidden" name="action" id="action" value="ADD" />
 <?php token(); ?>
<div class="righttable_css">

<div class="search_app_div">
<div class="search_app_text1">Company Name: <span>*</span></div>
<div class="search_app_bg"><input name="NON_MEMBER_NAME" id="NON_MEMBER_NAME" class="search_app_bg_text" type="text" /></div>
<div class="clear"> </div>
</div>
<div class="search_app_div">                  
  <div class="search_app_text1">Company Type <span>*</span></div>
    <div class="mt-2">                                
    <label for="Propritory" class="mr-3">
    <input type="radio" id="company_type" name="company_type" value="14" class="mr-2"> Propritory </label>
	<label for="Partnership" class="mr-3">
	<input type="radio" id="company_type" name="company_type" value="11" class="mr-2"> Partnership  </label>
    <label for="Private" class="mr-3">
    <input type="radio" id="company_type" name="company_type" value="13" class="mr-2"> Private Ltd.  </label>                          
    <label for="Public" class="mr-3">
    <input type="radio" id="company_type" name="company_type" value="12"  class="mr-2"> Public Ltd.  </label>
	<label for="company_type" generated="true" style="display: none;" class="error">Please Select Company type</label>							
	</div>
</div>

<div class="search_app_div">
<div class="search_app_text1">GSTIN Holder Status</div>
<div style=" margin-top:4px;">
<div class="chexbox11"><input name="gst_holder" id="gst_holder" value="Y" type="radio" class="gstholder_status_yes"/></div>
<div style="float:left;">Yes</div>
<div class="chexbox11"><input name="gst_holder" id="gst_holder" value="N" type="radio" class="gstholder_status_no"/></div>
<div style="float:left;">No</div>
</div><label for="gst_holder" generated="true" style="display: none;" class="error"> &nbsp; Please select your eligibility for GST</label>
<div class="clear"></div>
</div>

<div class="search_app_div">
<div class="search_app_text1">Company PAN No<span>*</span>:</div>
<div class="search_app_bg"><input id="company_pan_no" name="company_pan_no" autocomplete="off" maxlength="10" class="search_app_bg_text" type="text" /></div>
<div class="search_app_text1">Company GSTIN No<span>*</span>:</div>
<div class="search_app_bg" id="gst_status"><input id="company_gstn" name="company_gstn" autocomplete="off" maxlength="15" class="search_app_bg_text" type="text" /></div>
<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">Address1<span>*</span>:</div>
<div class="search_app_bg"><input name="ADDRESS1" id="ADDRESS1" class="search_app_bg_text" type="text" /></div>
<div class="search_app_text1">Address2<span>*</span>:</div>
<div class="search_app_bg"><input name="ADDRESS2" id="ADDRESS2" class="search_app_bg_text" type="text" /></div>
<div class="clear"> </div>
</div>
<div class="search_app_div">
<div class="search_app_text1">Address3:</div>
<div class="search_app_bg"><input name="ADDRESS3" id="ADDRESS3" class="search_app_bg_text" type="text" /></div>
<div class="search_app_text1">Address4:</div>
<div class="search_app_bg"><input name="ADDRESS4" id="ADDRESS4" class="search_app_bg_text" type="text" /></div>
<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">Country<span>*</span>:</div>
<div class="search_app_bg">
<select class="search_app_bg_text" name="COUNTRY_ID" id="COUNTRY_ID">
<option value="">--Select--</option>
<?php 
$sql1="SELECT * FROM  `kp_country_master` where status='1' ORDER BY `country_name`";
$result1=mysql_query($sql1);
while($rows1=mysql_fetch_array($result1)){
echo "<option value='$rows1[country_code]'>$rows1[country_name]</option>";	
}
?>
</select>
</div>

<div class="search_app_text1">State<span>*</span>:</div>
<div class="search_app_bg" id="stateDiv">
<select class="search_app_bg_text" name="STATE_ID" id="STATE_ID">
<option value="">--Select--</option>
</select>
</div>
<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">City<span>*</span>:</div>
<div class="search_app_bg"><input name="CITY" id="CITY" class="search_app_bg_text" type="text" maxlength="15" autocomplete="off"/></div>
<div class="search_app_text1">Pincode<span>*</span>:</div>
<div class="search_app_bg"><input name="PINCODE" id="PINCODE" class="search_app_bg_text" type="text" /></div>
<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">Telephone 1:</div>
<div class="search_app_bg"><input name="TELEPHONE1" id="TELEPHONE1" class="search_app_bg_text" type="text" /></div>

<div class="search_app_text1">Telephone 2:</div>
<div class="search_app_bg"><input name="TELEPHONE2" id="TELEPHONE2" class="search_app_bg_text" type="text" /></div>

<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">Fax:</div>
<div class="search_app_bg"><input name="FAX" id="FAX" class="search_app_bg_text" type="text" /></div>

<div class="search_app_text1">Mobile:</div>
<div class="search_app_bg"><input name="MOBILE" id="MOBILE" class="search_app_bg_text" type="text" /></div>
<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">Email:</div>
<div class="search_app_bg"><input name="EMAIL" id="EMAIL" class="search_app_bg_text" type="text" /></div>
<div class="search_app_text1">Website:</div>
<div class="search_app_bg"><input name="WEBSITE" id="WEBSITE" class="search_app_bg_text" type="text" /></div>
<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">Contact Person 1:</div>
<div class="search_app_bg"><input name="CONTACT_PERSON1" id="CONTACT_PERSON1" class="search_app_bg_text" type="text" /></div>
<div class="search_app_text1">Contact Person 2:</div>
<div class="search_app_bg"><input name="CONTACT_PERSON2" id="CONTACT_PERSON2" class="search_app_bg_text" type="text" /></div>
<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1"> Designation 1 :</div>
<div class="search_app_bg">
<select  class="search_app_bg_text" name="DESIGNATION1" id="DESIGNATION1">
<option selected="selected" value="--Select--">--Select--</option>
	<option value="16">Asst. Director</option>
	<option value="17">Executive</option>
	<option value="34">Manager</option>
	<option value="37">Student</option>
	<option value="61">Professor</option>
</select>
</div>

<div class="search_app_text1"> Designation 2 :</div>
<div class="search_app_bg">
<select  class="search_app_bg_text" name="DESIGNATION2" id="DESIGNATION2">
<option selected="selected" value="--Select--">--Select--</option>
	<option value="16">Asst. Director</option>
	<option value="17">Executive</option>
	<option value="34">Manager</option>
	<option value="37">Student</option>
	<option value="61">Professor</option>
</select>
</div>
<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">IEC No:</div>
<div class="search_app_bg"><input name="IEC_NO" id="IEC_NO" class="search_app_bg_text" type="text" maxlength="10"/></div>

<div class="search_app_text1">Remarks:</div>
<div class="search_app_bg"><input name="REMARKS" id="REMARKS" class="search_app_bg_text" type="text" /></div>

<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">Do You Belong To Seepz?</div>
<div style=" margin-top:4px;">
<div class="chexbox11"><input name="SEEPZ" id="SEEPZ" type="radio" value="Yes" class="seepzholder_status_yes"/></div>
<div style="float:left;">Yes</div>
<div class="chexbox11"><input name="SEEPZ" id="SEEPZ" type="radio" value="No" class="seepzholder_status_no"/></div>
<div style="float:left;">No</div>
</div>
<div class="clear"></div>
</div>

<div class="search_app_div">
<div class="search_app_text1"> Location:</div>
<div class="search_app_bg">
  <select class="search_app_bg_text" name="LOCATION" id="LOCATION">
    <option value="">--Select--</option>
    <option value="1">Mumbai - GJEPC</option>
    <option value="15">Surat - G</option>
    <option value="91">Mumbai - Seepz</option>
    <option value="93">Surat - Seepz</option>
    <option value="92">Vishakapatnam</option>
  </select>
</div>
<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">Captcha</div>			
<div class="search_app_bg"><input type="text" class="search_app_bg_text" autocomplete="off" id="captcha_code" name="captcha_code" placeholder="Enter Captcha Code"/>
</div>
</div>
<div class="form-group col-md-6">
	<div class="sub_head">&nbsp;</div>
	<img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg'/>
	Can't read the image? Click <a href='javascript: refreshCaptcha();'>Here</a> to Refresh
</div>

<div class="search_app_div">
<div class="search_app_text1"></div>
<div style="float:left; margin-bottom:4px;"><input class="input_bg" type="submit" value="Submit" /></div>
<div style="float:left;  margin-bottom:4px;"><input class="input_bg" type="submit" value="Close" /></div>
</div>
<div class="clear"></div>

</div>
</form>
</div> 

<div class="clear"></div>

<!-- Midle Bg -->
<div class="innerbg_bottom"></div>
<div class="clear"></div>
</div>

<div class="clear"></div>
</div>
<div class="midletable_img"><img src="images/inner_bottom_bg_new.png" /></div>
<!-- Fotter -->
<?php include ('fotter.php') ?>
<!-- Fotter -->
<div class="clear"></div>

</div>

</div>
</div>
<!-- main -->
</body>
</html>