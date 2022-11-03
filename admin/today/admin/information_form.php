<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
$action=$_REQUEST['action'];
if($action=="update")
{
$registration_id=$_REQUEST['registration_id'];
$company_name=$_REQUEST['company_name'];
$company_name = substr($_REQUEST['company_name'], 0, 50);
$company_name2 = substr($_REQUEST['company_name'],50);
$member_type_id=$_REQUEST['member_type_id'];
$type_of_firm=$_REQUEST['type_of_firm'];
$cin_no=$_REQUEST['cin_no'];
$pan_no=$_REQUEST['pan_no'];
$tan_no=$_REQUEST['tan_no'];
$iec_no=$_REQUEST['iec_no'];
$status_holder=$_REQUEST['status_holder'];
$status_holder_eh=$_REQUEST['status_holder_eh'];
$msme_ssi_status=$_REQUEST['msme_ssi_status'];

$uin=$_REQUEST['uin'];
$uin_issue_date=$_REQUEST['uin_issue_date'];

$iec_issue_date=date('d-m-Y',strtotime($_REQUEST['iec_issue_date']));

if(isset($_REQUEST['im_registration_no']) && $_REQUEST['im_registration_no']!="")
{
	if(isset($_REQUEST['im_pin_code']) && $_REQUEST['im_pin_code']=="")
	{
		$_SESSION['error_msg']="Please enter IM Registrattion pin code";
		header('location:information_form.php?registration_id='.$registration_id);exit;
	}
	
}
if(isset($_REQUEST['im_pin_code']) && $_REQUEST['im_pin_code']!="")
{
	if(isset($_REQUEST['im_registration_no']) && $_REQUEST['im_registration_no']=="")
	{
		$_SESSION['error_msg']="Please enter IM registration number";
		header('location:information_form.php?registration_id='.$registration_id);exit;
	}
	
}
if(isset($_REQUEST['im_registration_no']) && ($_REQUEST['im_registration_no']=="") && isset($_REQUEST['im_pin_code']) && $_REQUEST['im_pin_code']=="")
{
	
	if($_REQUEST['ssi_registration_no']=="" || $_REQUEST['ssi_issue_date']=="" || $_REQUEST['ssi_pin_code']=="")
	{
		$_SESSION['error_msg']="Please enter SSI Registration data";
		header('location:information_form.php?registration_id='.$registration_id);exit;
	}
	
}

$im_registration_no=$_REQUEST['im_registration_no'];
$im_pin_code=$_REQUEST['im_pin_code'];
$ssi_registration_no=$_REQUEST['ssi_registration_no'];
$ssi_issue_date=$_REQUEST['ssi_issue_date'];
$ssi_pin_code=$_REQUEST['ssi_pin_code'];
$issuing_industrial_liecence=$_REQUEST['issuing_industrial_liecence'];
$authority=$_REQUEST['authority'];
$vat_tin=$_REQUEST['vat_tin'];
$co_profile=mysql_real_escape_string(strip_tags($_REQUEST['co_profile']));
$sight_holder=$_REQUEST['sight_holder'];
$sez_member=$_REQUEST['sez_member'];
$epc_fieo_status=$_REQUEST['epc_fieo_status'];
$org_name=$_REQUEST['org_name'];
$eh_th_certification_no=$_REQUEST['eh_th_certification_no'];
$eh_th_issue_date=$_REQUEST['eh_th_issue_date'];
$eh_th_valid_date=$_REQUEST['eh_th_valid_date'];
$region_id=$_REQUEST['region_id'];
$year_of_starting_bussiness=$_REQUEST['year_of_starting_bussiness'];
$name=htmlentities(strip_tags($_REQUEST['name']));
$designation=htmlentities(strip_tags($_REQUEST['designation']));
$email_id=$_REQUEST['email_id'];
$aadhar_no=mysql_real_escape_string($_REQUEST['aadhar_no']);
$passport_no=mysql_real_escape_string($_REQUEST['passport_no']);
$address1=htmlentities(strip_tags($_REQUEST['address1']));
$address2=htmlentities(strip_tags($_REQUEST['address2']));
$address3=htmlentities(strip_tags($_REQUEST['address3']));
$pin_code=$_REQUEST['pin_code'];
$city=$_REQUEST['city'];
$country=$_REQUEST['country'];
$land_line_no=$_REQUEST['land_line_no'];
$mobile_no=$_REQUEST['mobile_no'];
$joining_date=$_REQUEST['joining_date'];
$retirement_date=$_REQUEST['retirement_date'];

$sql1="update information_master set company_name='$company_name',company_name2='$company_name2',member_type_id='$member_type_id',type_of_firm='$type_of_firm',cin_no='$cin_no',pan_no='$pan_no',tan_no='$tan_no',iec_no='$iec_no',iec_issue_date='$iec_issue_date',im_registration_no='$im_registration_no',im_pin_code='$im_pin_code',ssi_registration_no='$ssi_registration_no',ssi_issue_date='$ssi_issue_date',ssi_pin_code='$ssi_pin_code',issuing_industrial_liecence='$issuing_industrial_liecence',authority='$authority',eh_th_certification_no='$eh_th_certification_no',eh_th_issue_date='$eh_th_issue_date',eh_th_valid_date='$eh_th_valid_date',region_id='$region_id',year_of_starting_bussiness='$year_of_starting_bussiness',name='$name',designation='$designation',email_id='$email_id',aadhar_no='$aadhar_no',passport_no='$passport_no',address1='$address1',address2='$address2',address3='$address3',pin_code='$pin_code',city='$city',country='$country',land_line_no='$land_line_no',mobile_no='$mobile_no',joining_date='$joining_date',retirement_date='$retirement_date',status=1,status_holder='$status_holder',status_holder_eh='$status_holder_eh',msme_ssi_status='$msme_ssi_status',vat_tin_reg_no='$vat_tin',uin='$uin',uin_issue_date='$uin_issue_date',co_profile='$co_profile',sight_holder='$sight_holder',sez_member='$sez_member',epc_fieo_status='$epc_fieo_status',org_name='$org_name' where registration_id='$registration_id'";

	if (!mysql_query($sql1))
	{
		die('Error: ' . mysql_error());
	}

$_SESSION['succ_msg']="Information updated successfully";
header("Location: communication_form.php?registration_id=$registration_id");
}

$id=$_REQUEST['id'];
$registration_id=$_REQUEST['registration_id'];
$sql="SELECT * FROM `information_master` WHERE 1 and registration_id=$registration_id";
$result=mysql_query($sql);
$rows=mysql_fetch_array($result);

$company_name=$rows['company_name'];
$company_name2=$row['company_name2'];
$company_name=$company_name.$company_name2;
$member_type_id=$rows['member_type_id'];
$type_of_firm=$rows['type_of_firm'];
$cin_no=$rows['cin_no'];
$pan_no=$rows['pan_no'];
$tan_no=$rows['tan_no'];
$iec_no=$rows['iec_no'];
$iec_issue_date=$rows['iec_issue_date'];
$status_holder=$rows['status_holder'];
$status_holder_eh=$rows['status_holder_eh'];
$msme_ssi_status=$rows['msme_ssi_status'];
$vat_tin=$rows['vat_tin_reg_no'];
$uin=$rows['uin'];
$uin_issue_date=$rows['uin_issue_date'];
$co_profile=$rows['co_profile'];
$sight_holder=$rows['sight_holder'];
$sez_member=$rows['sez_member'];
$epc_fieo_status=$rows['epc_fieo_status'];
$org_name=$rows['org_name'];
$im_registration_no=$rows['im_registration_no'];
$im_pin_code=$rows['im_pin_code'];
$ssi_registration_no=$rows['ssi_registration_no'];
$ssi_issue_date=$rows['ssi_issue_date'];
$ssi_pin_code=$rows['ssi_pin_code'];
$issuing_industrial_liecence=$rows['issuing_industrial_liecence'];
$authority=$rows['authority'];
$eh_th_certification_no=$rows['eh_th_certification_no'];
$eh_th_issue_date=$rows['eh_th_issue_date'];
$eh_th_valid_date=$rows['eh_th_valid_date'];
$region_id=$rows['region_id'];
$year_of_starting_bussiness=$rows['year_of_starting_bussiness'];
$name=$rows['name'];
$designation=$rows['designation'];
$email_id=$rows['email_id'];
$aadhar_no=trim($rows['aadhar_no']);
$passport_no=trim($rows['passport_no']);
$address1=$rows['address1'];
$address2=$rows['address2'];
$address3=$rows['address3'];
$pin_code=$rows['pin_code'];
$city=$rows['city'];
$country=$rows['country'];
$land_line_no=$rows['land_line_no'];
$mobile_no=$rows['mobile_no'];
$joining_date=$rows['joining_date'];
$retirement_date=$rows['retirement_date'];
$admin_aprove=$rows['admin_aprove'];
$status=$rows['status'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Information Form ||GJEPC||</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />

<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script> 
 <!--validation-->
<!--<script src="jsvalidation/jquery.js" type="text/javascript"></script>-->
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<link rel="stylesheet" type="text/css" media="screen" href="css/cmxform.css" />   

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
.style1 {color: #FF0000}
.style2 {
	font-size: 16px;
	font-weight: bold;
}
-->
</style>
<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	$('#iec_issue_date').datepick();
	$('#ssi_issue_date').datepick();
	$('#eh_th_issue_date').datepick();
	$('#eh_th_valid_date').datepick();
	$('#joining_date').datepick();
	$('#retirement_date').datepick();
	$('#uin_issue_date').datepick();
	
});
</script>
<script>
$(document).ready(function(){
    var member_id=$("#member_type_id").val();
	if(member_id==5 || member_id=="")
	{
		$("#memberttypedisplay").hide();
		$("#im_registration_no").attr("disabled", "disabled"); 
		$("#im_pin_code").attr("disabled", "disabled"); 
		$("#ssi_registration_no").attr("disabled", "disabled"); 
		$("#ssi_issue_date").attr("disabled", "disabled"); 
		$("#ssi_pin_code").attr("disabled", "disabled"); 
		$("#issuing_industrial_liecence").attr("disabled", "disabled"); 
		$("#authority").attr("disabled", "disabled"); 
	}
	if(member_id==6)
	{
		$("#memberttypedisplay").show();
		$("#im_registration_no").removeAttr("disabled"); 
		$("#im_pin_code").removeAttr("disabled"); 
		$("#ssi_registration_no").removeAttr("disabled"); 
		$("#ssi_issue_date").removeAttr("disabled"); 
		$("#ssi_pin_code").removeAttr("disabled"); 
		$("#issuing_industrial_liecence").removeAttr("disabled"); 
		$("#authority").removeAttr("disabled"); 
	}

 $("#member_type_id").change(function () {
	var member_id=$(this).val();
	if(member_id==5 || member_id=="")
	{ 
		$("#memberttypedisplay").hide();
		$("#im_registration_no").attr("disabled", "disabled"); 
		$("#im_pin_code").attr("disabled", "disabled"); 
		$("#ssi_registration_no").attr("disabled", "disabled"); 
		$("#ssi_issue_date").attr("disabled", "disabled"); 
		$("#ssi_pin_code").attr("disabled", "disabled"); 
		$("#issuing_industrial_liecence").attr("disabled", "disabled"); 
		$("#authority").attr("disabled", "disabled"); 
	}
	if(member_id==6)
	{    
		$("#memberttypedisplay").show();
		$("#im_registration_no").removeAttr("disabled"); 
		$("#im_pin_code").removeAttr("disabled"); 
		$("#ssi_registration_no").removeAttr("disabled"); 
		$("#ssi_issue_date").removeAttr("disabled"); 
		$("#ssi_pin_code").removeAttr("disabled"); 
		$("#issuing_industrial_liecence").removeAttr("disabled"); 
		$("#authority").removeAttr("disabled"); 
	}
 });
});
</script>
<script type="text/javascript">
$().ready(function() {
	// validate the comment form when it is submitted
	$("#commentForm").validate();
	// validate signup form on keyup and submit
	$("#form1").validate({
			//var member_id=$("#member_type_id").val();
		rules: {  
			company_name: {
				required: true,
			},  
			member_type_id: {
				required: true,
			}, 
			type_of_firm:{
			required: true,
			},  
			pan_no: {
				required: true,
				minlength: 10,
				maxlength: 10
			},  
			iec_no: {
				required: true,
			},
			iec_issue_date: {
				required: true,
			}, 
			ssi_registration_no: {
				required: true,
			}, 
			ssi_issue_date: {
				required: true,
			},  
			ssi_pin_code: {
				required: true,
			}, 
			issuing_industrial_liecence: {
				required: true,
				}, 
			authority: {
				required: true,
				},
				
			region_id: {
				required: true,
				},  
			year_of_starting_bussiness:{
			required:true,
			},
			name: {
				required: true,
				},  
			designation: {
				required: true,
				},
			email_id: {
				required: true,
				email: true
			},
			address1: {
				required: true,
			},  
			pin_code: {
				required: true,
				number:true,
				minlength:6,
				maxlength:6
			},
			topic: {
				required: "#newsletter:checked",
				minlength: 2
			}, 
			city: {
				required: true,
			},  
			country: {
				required: true,
			},
			land_line_no:{
			required: true,
			},
			mobile_no: {
				required: true,
				number:true,
				minlength: 10,
				maxlength: 10
			},
			
			agree: "required"
		},
		messages: {
			company_name: {
				required: "Please enter a comany name",
			},  
			member_type_id: {
				required: "Please select a member type",
			},  
			type_of_firm: {
				required: "Please select a firm type",
			},
			pan_no: {
				required: "Please enter your pan no",
				minlength: "Your pan no must consist of at least 10 characters",
				maxlength: "Your pan no must be less than 10 characters"
			},   
			iec_no: {
				required: "Please enter your iec no",
			},  
			iec_issue_date: {
				required: "Please enter valid date of issue",
			}, 
			ssi_registration_no:
			{
				required: "Please enter ssi registration no",
			},
			ssi_issue_date:
			{
				required: "Please enter ssi issue date",
			},
			ssi_pin_code:
			{
				required: "Please enter ssi pin code",
			},  
			issuing_industrial_liecence: {
				required: "Please enter industrial liecence number",
			},
			authority: {
				required: "Please enter authority number",
			},   
			region_id: {
				required: "Please select a region",
			},    
			year_of_starting_bussiness:{
			required: "Please enter year of starting business",
			}, 
			designation: {
				required: "Please enter your designation",
			},
			name: {
				required: "Please enter your name",
			},
			email_id: "Please enter a valid email",  
			address1: {
				required: "Please enter your address",
			},
			pin_code: {
				required: "Please enter your pin code",
				number:"please enter numbers only",
				minlength:"please enter not less than 6 characters",
				maxlength:"please enter not more than 6 characters"
				
			},  
			city: {
				required: "Please enter your city",
			},  
			country: {
				required: "Please select a country",
			},  
			land_line_no:{
			required: "Please enter your landline number",
			},
			mobile_no: {
				required: "Please enter your mobile number",
				number:"please enter numbers only",
				minlength: "Your mobile no must consist of at least 10 characters",
				maxlength: "Your mobile no must be less than 10 characters"
			},
			
			agree: "Please accept our policy"
		}
	});
});
</script>

<script type="text/javascript">
    $(function () {
        $("input[name='status_holder']").click(function () {
            if ($("#chkYes").is(":checked")) {
                $("#holder_star").show();
            } else {
                $("#holder_star").hide();
            }
        });
    });
</script>
<script type="text/javascript">
    $(function () {
        $("input[name='msme_ssi_status']").click(function () {
            if ($("#msmeYes").is(":checked")) {
                $("#msme_main").show();
            } else {
                $("#msme_main").hide();
            }
        });
    });
</script>
<script type="text/javascript">
    $(function () {
        $("input[name='epc_fieo_status']").click(function () {
            if ($("#epcYes").is(":checked")) {
                $("#epc_main").show();
            } else {
                $("#epc_main").hide();
            }
        });
    });
</script>

<script>
$(document).ready(function(){
	var typeFirm=$("#type_of_firm").val();
	$("#type_of_firm").change(function () {
	var typeFirm=$(this).val();
	if(typeFirm=="Private Ltd" || typeFirm=="Public Ltd")
	{
		$("#cinNoDisplay").show();
		$("#cin_no").removeAttr("disabled");
	}else
	{
		$("#cinNoDisplay").hide();
		$("#cin_no").attr("disabled", "disabled"); 
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
	<div class="breadcome"><a href="admin.php">Home</a> > Membership  > Information Form</div>
</div>

<div id="main"> 
	<div class="content">
    	<div class="content_head">Information Form
        <div style="float:right; padding-right:10px; font-size:12px;"><a href="membership.php">Back to Search Membership</a></div>
    </div>
    	
<!--<form class="cmxform" method="post" name="from1" id="form1">-->
<form action="#" method="post">        

<div class="content_details1">
  <?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}

if($_SESSION['form_chk_msg']!=""){
echo "<span class='notification n-attention'>".$_SESSION['form_chk_msg']."</span>";
$_SESSION['form_chk_msg']="";
}

if($_SESSION['error_msg']!=""){
echo "<span class='notification n-attention'>";
echo $_SESSION['error_msg']."<br>";
echo "</span>";
}
?>
  <!--<span class="notification n-information">Information notification.</span>
<span class="notification n-attention">Attention notification.</span>
<span class="notification n-error">Error notification.</span>-->

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
    <tr class="orange1">
    <td colspan="11" >Company Details</td>
    </tr>
      
 	<tr>
    <td width="27%"><strong>Company Name <span class="star"> * </span></strong></td>
    <td width="73%"><input type="text" name="company_name" id="company_name" class="input_txt_new" value="<?php echo $company_name;?>" autocomplete="off"></td>
    </tr>

	<tr>
    <td><strong>Member Type <span class="star"> * </span></strong></td>
    <td>
    <select name="member_type_id" id="member_type_id" class="input_txt_new">
      <option value="">--- Select ---</option>
      <?php
	  $sql1="SELECT * FROM `member_type_master` WHERE 1 and `status`=1";
	  $result1=mysql_query($sql1);
	  while($rows1=mysql_fetch_array($result1))
	  {
	  if($rows1['sap_value']==$member_type_id)
	  {
	  echo "<option selected='selected' value='$rows1[sap_value]'>$rows1[member_type_name]</option>";
	  } else  {
	  echo "<option value='$rows1[sap_value]'>$rows1[member_type_name]</option>";
	  }
	  }
	  ?>
    </select>
    </td>
	</tr>    
    
    <tr>
    <td><strong>Type of Firm <span class="star"> * </span></strong></td>
    <td>
    <select name="type_of_firm" id="type_of_firm" class="input_txt_new">
      <option value="">--- Select ---</option>
      <?php
	  $sql2="SELECT * FROM `type_of_firm_master` WHERE 1 and `status`='1'";
	  $result2=mysql_query($sql2);
	  while($rows2=mysql_fetch_array($result2))
	  {
	  if($rows2['sap_value']==$type_of_firm)
	  {
	  echo "<option selected='selected' value='$rows2[sap_value]'>$rows2[type_of_firm_name]</option>";
	  }else
	  {
	  echo "<option value='$rows2[sap_value]'>$rows2[type_of_firm_name]</option>";
	  }
	  }
	  ?>
    </select>
    </td>
	</tr>
  
	<tr id="cinNoDisplay" <?php if($type_of_firm!=13 && $type_of_firm!=12){?> style="display:none;" <?php } ?>>
	<td><strong>CIN No.<span class="star"></span></strong></td>
	<td><input type="text" class="input_txt_new" value="<?php echo $cin_no;?>" name="cin_no" id="cin_no" /></td>
	</tr>

	<tr>
    <td><strong>PAN No. <span class="star"> * </span></strong></td>
    <td><input type="text" name="pan_no" id="pan_no" class="input_txt_new" value="<?php echo $pan_no;?>" /> </td>
    </tr>
	
    <tr>
	  <td><strong>TAN No.</strong></td>
	  <td><input type="text" name="tan_no" id="tan_no" class="input_txt_new" value="<?php echo $tan_no;?>" /></td>
	</tr>
	
    <tr>
	  <td><strong>IEC No. (10 digit) <span class="star"> * </span></strong></td>
	  <td><input type="text" name="iec_no" id="iec_no" class="input_txt_new" value="<?php echo $iec_no;?>" /></td>
	</tr>
	
    <tr>
	  <td><strong>Date of Issue <span class="star"> * </span></strong></td>
	  <td><input type="text" name="iec_issue_date" id="iec_issue_date" class="input_txt_new" value="<?php echo $iec_issue_date;?>" />
      </td>
	</tr>
	
<tr>
<td><strong>Status Holder<span class="star"> * </span></strong></td>
<td><input type="radio" id="chkYes" value="Yes" name="status_holder" <?php if($status_holder=='Yes'){ echo 'checked="checked"'; } ?>/> Yes
<input type="radio" id="chkNo" value="No" name="status_holder" <?php if($status_holder=='No'){ echo 'checked="checked"'; } ?> />  No</td>
</tr>


<tr id="holder_star" <?php if ($status_holder!='Yes'){?> style="display: none;" <?php }?>>
<td></td>
<td>
<select class="form_text_text" name="status_holder_eh" id="status_holder_eh" >
<option value="0">--- Select ---</option>
<option value="one_star" <?php if($status_holder_eh=="one_star") echo 'selected="selected"'; ?>>One Star</option>
<option value="two_star" <?php if($status_holder_eh=="two_star") echo 'selected="selected"'; ?>>Two Star</option>
<option value="three_star" <?php if($status_holder_eh=="three_star") echo 'selected="selected"'; ?>>Three Star</option>
<option value="four_star" <?php if($status_holder_eh=="four_star") echo 'selected="selected"'; ?>>Four Star</option>
<option value="five_star" <?php if($status_holder_eh=="five_star") echo 'selected="selected"'; ?>>Five Star</option>
</select>
</td></tr>


   <!--.........................Display on the basis of member type............................--> 
   <tbody style="display:none;" id="memberttypedisplay">
    <tr>
	<td><strong>IM Registration No.</strong></td>
	<td><input type="text" name="im_registration_no" id="im_registration_no" class="input_txt_new" value="<?php echo $im_registration_no;?>"/></td>
	</tr>    
    <tr>
	<td><strong>IM Pin Code </strong></td>
	<td><input type="text" name="im_pin_code" id="im_pin_code" class="input_txt_new" value="<?php echo $im_pin_code;?>" /></td>
	</tr>	
	<tr>
	<td><strong>UAN Registration No</strong></td>
    <td><input type="text" class="input_txt_new" value="<?php echo $uin;?>" name="uin" id="uin"/></td>
    </tr>
	<tr>
	<td><strong>Date Of Issue</strong></td>
    <td><input type="text" class="input_txt_new" value="<?php echo $uin_issue_date;?>" name="uin_issue_date" id="uin_issue_date"/></td>
	</tr>		
	<tr> 
	<td><strong>MSME/SSI</strong></td>
    <td><input type="radio" id="msmeYes" value="Yes" name="msme_ssi_status" <?php echo ($msme_ssi_status=='Yes')? 'checked':'' ?>/> Yes
	<input type="radio" id="msmeNo" value="No" name="msme_ssi_status" <?php echo ($msme_ssi_status=='No')? 'checked':'' ?>/>  No</td>
    </tr>	
	<tr id="msme_main" <?php if($msme_ssi_status!='Yes'){?> style="display: none" <?php }?>>
	<td><strong>SSI Registration No.<span class="star"> * </span> </strong></td>
	<td><input type="text" name="ssi_registration_no" id="ssi_registration_no" class="input_txt_new" value="<?php echo $ssi_registration_no; ?>" /></td>
	</tr>
	<tr>
	<td><strong>Date of SSI Registration<span class="star"> * </span> </strong></td>
	<td><input type="text" name="ssi_issue_date" id="ssi_issue_date" class="input_txt_new" value="<?php echo $ssi_issue_date;?>" /></td>
	</tr>
	<tr>
	<td><strong>SSI Pin Code<span class="star"> * </span></strong></td>
	<td><input type="text" name="ssi_pin_code" id="ssi_pin_code" class="input_txt_new" value="<?php echo $ssi_pin_code;?>" /></td>
	</tr>
    <tr>
	<td><strong>Issuing Industrial Licences/IEM <span class="star"> * </span></strong></td>
	<td><input type="text" name="issuing_industrial_liecence" id="issuing_industrial_liecence" class="input_txt_new" value="<?php echo $issuing_industrial_liecence; ?>"/></td>
	</tr>
	<tr>
	<td><strong>Authority <span class="star"> * </span></strong></td>
	<td><input type="text" name="authority" id="authority" class="input_txt_new" value="<?php echo $authority;?>" /></td>
	</tr>
	<tr>
	<td><strong>VAT/TIN/CST Registration No.<span class="star"></span></strong></td>
	<td><input type="text" class="input_txt_new" value="<?php echo $vat_tin;?>" name="vat_tin" id="vat_tin"/></td>
	</tr>

    </tbody>
    
    <tr>
	  <td><strong>EH/TH/STH/SSTH Certificate No </strong></td>
	  <td><input type="text" name="eh_th_certification_no" id="eh_th_certification_no" class="input_txt_new" value="<?php echo $eh_th_certification_no;?>" /></td>
	</tr>
	
    <tr >
	  <td><strong>Date of Issue </strong></td>
	  <td><input type="text" name="eh_th_issue_date" id="eh_th_issue_date" class="input_txt_new" value="<?php echo $eh_th_issue_date;?>" /></td>
	</tr>
	
    <tr >
	  <td><strong>Valid upto </strong></td>
	  <td><input type="text" name="eh_th_valid_date" id="eh_th_valid_date" class="input_txt_new" value="<?php echo $eh_th_valid_date;?>" /></td>
	</tr>
	
    <tr >
	  <td><strong>Select Region <span class="star"> * </span></strong></td>
	  <td>
      <!--<select name="region_id" id="region_id" class="input_txt_new">
		<option value="">--- Select ---</option>	
          <?php
		  $sql3="SELECT * FROM `region_master` WHERE 1 and `status`=1";
		  $result3=mysql_query($sql3);
		  while($rows3=mysql_fetch_array($result3))
		  {
		  if($rows3['sap_value']==$region_id)
		  {
		  echo "<option selected='selected' value='$rows3[sap_value]'>$rows3[region_full_name]</option>";
		  }else
		  {
		  echo "<option value='$rows3[sap_value]'>$rows3[region_full_name]</option>";
		  }
		  }
		  ?>
	  </select> --> 
	  <select name="region_id" id="region_id" class="input_txt_new">
		<option value="">--- Select ---</option>	
          <?php
		  $sql3="SELECT * FROM `region_master` WHERE 1 and `status`=1";
		  $result3=mysql_query($sql3);
		  while($rows3=mysql_fetch_array($result3))
		  {
		  if($rows3['region_name']==$region_id)
		  {
		  echo "<option selected='selected' value='$rows3[region_name]'>$rows3[region_full_name]</option>";
		  }else
		  {
		  echo "<option value='$rows3[region_name]'>$rows3[region_full_name]</option>";
		  }
		  }
		  ?>
	  </select> 
      </td>
	</tr>
	
	<tr>
	<td><strong>Company Profile</strong></td>
	<td><textarea name="co_profile"  rows="5" cols="40"><?php echo $co_profile;?></textarea></td>
	</tr>

	<tr>
	<td><strong>DTC Sight Holder</strong></td>
	<td>
	Yes <input type="radio" name="sight_holder" value="Yes" <?php if($sight_holder=='Yes'){ echo 'checked="checked"'; } ?> />
	No <input type="radio" name="sight_holder" value="No" <?php if($sight_holder=='No'){ echo 'checked="checked"';} ?>/>
	</td></tr>

	<tr>
	<td><strong>SEZ Member</strong></td>
	<td>
	Yes <input type="radio" name="sez_member" value="Yes"<?php if($sez_member=='Yes'){ echo 'checked="checked"';}?> />
	No <input type="radio" name="sez_member" value="No" <?php if($sez_member=='No'){ echo 'checked="checked"';}?> />
	</td>
	</tr>

	<tr>
	<td><strong>Whether registered with any other EPC/FIEO </strong></td>
    <td>
	Yes <input type="radio" id="epcYes" value="Yes" name="epc_fieo_status" <?php if($epc_fieo_status=='Yes') { echo 'checked="checked"';} ?>/>
	No <input type="radio" id="epcNo" value="No" name="epc_fieo_status" <?php if($epc_fieo_status=='No') { echo 'checked="checked"';} ?>/>
    </td>
    </tr>	
	<tr id="epc_main" <?php if($epc_fieo_status!='Yes'){?> style="display: none" <?php }?>>
	<td><strong>Name of the Organization </strong></td>
	<td><input type="text" class="input_txt_new" name="org_name" id="org_name" value="<?php echo $org_name;?>" placeholder="Name of Organization" /></td>
	</tr>	
    <tr>
	<td><strong>Date of Establishment <span class="star"> * </span></strong></td>
	<td><input type="text" name="year_of_starting_bussiness" id="year_of_starting_bussiness" class="input_txt_new" value="<?php echo $year_of_starting_bussiness;?>" maxlength="4"/></td>
	</tr>
	
</table>

</div>

<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
    <tr>
<td><strong>Other Contact Information</strong></td>
<td><table class="table">
    <thead>
        <tr>
            <th width="10%">Dept</th>
            <th width="10%">Name</th>
            <th width="10%">Email</th>
            <th width="10%">Phone</th>
            <!--<th>EDIT</th>-->
        </tr>
    </thead>
    <tbody id="CommunicationDetails">
            <?php
            $get_dir="SELECT * FROM `other_contact_detail` where `registration_id`='$registration_id'";
            $dir_result=mysql_query($get_dir);
            while($getValue=mysql_fetch_array($dir_result)){
            ?>
        <tr>
            <td><?php echo $getValue['dept'];?></td>
            <td><?php echo $getValue['other_name'];?></td>
            <td><?php echo $getValue['other_email'];?></td>
            <td><?php echo $getValue['other_phone'];?></td>
        <!--<td><input type="button" name="edit" value="Edit" id="<?php echo $getValue['id']; ?>" class="btn btn-info btn-xs edit_data" /></td>-->  					
        </tr>
            <?php } ?>
    </tbody>
</table></td>
</tr>
  </table>
      </div>       
        
<div style="padding-left:10px; margin-top:5px;">
<input type="hidden" name="action" value="update" />
<input type="hidden" name="registration_id" id="registration_id" value="<?php echo $registration_id;?>" />
<input type="submit" value="Update" class="input_submit"/>
<a href="communication_form.php?registration_id=<?php echo $registration_id;?>"><div class="button">Next</div></a>
</div>	
</form>

</div>

<div id="footer_wrap"><?php include("include/footer.php"); $_SESSION['error_msg']="";?></div>


</body>
</html>
