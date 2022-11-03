<?php
session_start();
ob_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
include('../db.inc.php');
include('../functions.php');
?>
<?php
$gid	=	intval(filter($_REQUEST['gid']));
$registration_id	=	intval(filter($_REQUEST['registration_id']));

$sql="select * from igjme_exh_reg_general_info where  uid='$registration_id' and event_for='IGJME 2022'";
$result=$conn->query($sql);
$rows=$result->fetch_assoc();

$company_name	=	filter($rows['company_name']);
$membership_id	=	filter($rows['membership_id']);
$country		=	filter($rows['country']);
if($country=='IN'){
	$currency ='INR';	
} else {
	$currency = 'USD';	
}
?>
<?php 
if($country=='IN')
{
	$schk_membership="SELECT * FROM `approval_master`  WHERE `registration_id`='".$rows['uid']."' and issue_membership_certificate_expire_status='Y'";	
	$qchk_membership=$conn->query($schk_membership);
	$nchk_membership=$qchk_membership->num_rows;
	if($nchk_membership>0){
		$member_type= 'MEMBER';
	} else {
		$member_type= 'NON_MEMBER';} 
} else {
		$member_type= 'INTERNATIONAL';
}			
?>
<?php
$action=$_REQUEST['action'];
if($action=='UPDATE')
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	
	$exh_id	=	intval(filter($_REQUEST['exh_id']));
	$gid	=	intval(filter($_REQUEST['gid']));
	$uid	=	intval(filter($_REQUEST['registration_id']));
	
	$option=filter($_REQUEST['option']);
	$selected_area=filter($_REQUEST['selected_area']);
	$category=filter($_REQUEST['category']);
	$selected_scheme_type=filter($_REQUEST['selected_scheme_type']);
	$selected_premium_type=filter($_REQUEST['selected_premium_type']);
	$tot_space_cost_rate=filter($_REQUEST['tot_space_cost_rate']);
	$selected_scheme_rate=filter($_REQUEST['selected_scheme_rate']);	
	if($selected_scheme_rate=='')	$selected_scheme_rate=0;
	$selected_premium_rate=filter($_REQUEST['selected_premium_rate']);
	$sub_total_cost=filter($_REQUEST['sub_total_cost']);
	$security_deposit=filter($_REQUEST['security_deposit']);
	$country=filter($_REQUEST['country']);
	$govt_service_tax=$_REQUEST['govt_service_tax'];
	$grand_total=$_REQUEST['grand_total'];	
	$mcb_charges=$_REQUEST['mcb_charges'];
	$modified_date=date('Y-m-d');	
	
	if(!empty($uid) && !empty($gid)){
	$updatesql="update igjme_exh_registration set options='$option',category='$category',selected_area='$selected_area',selected_scheme_type='$selected_scheme_type',selected_premium_type='$selected_premium_type',tot_space_cost_rate='$tot_space_cost_rate',selected_scheme_rate='$selected_scheme_rate',selected_premium_rate='$selected_premium_rate',sub_total_cost ='$sub_total_cost',security_deposit='$security_deposit',govt_service_tax='$govt_service_tax',grand_total='$grand_total',modified_date='$modified_date' where exh_id='$exh_id' and gid='$gid' and uid='$uid' and `show`='IGJME 2022'";	
	if(!$conn->query($updatesql)){	die('Error: ' . mysql_error($conn));	}
	$_SESSION['succ_msg']="Stall updated successfully";
	header("Location: igjme_exh_registration_step4.php?id=$gid&registration_id=$uid");
	} else { $_SESSION['error_msg']="Something Missing"; }
	} else { 
	$_SESSION['error_msg']="Invalid Token Error";
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IGJME &gt; Exhibitor Registration &gt; Step-3</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/formAdmin.css"/>
<!--navigation-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 

<script>
$(document).ready(function(){
  $("#calculate").click(function(){
  category=$('#category').val();
  selected_area=$("#selected_area").val();
  member_type=$("#member_type").val(); 
  selected_scheme_type=$("#selected_scheme_type").val();

  selected_premium_type=$("#selected_premium_type").val();
  country=$("#country").val();
 
 // woman_entrepreneurs=$('[name=woman_entrepreneurs]:checked').val();
	$.ajax({ type: 'POST',
					url: 'igjme_ajax.php',
					data: "actiontype=calculatePayment&&selected_area="+selected_area+"&&selected_scheme_type="+selected_scheme_type+"&&selected_premium_type="+selected_premium_type+"&&country="+country+"&&member_type="+member_type+"&&category="+category,
					dataType:'html',
					beforeSend: function(){
					
							},
					success: function(data){
							  //alert(data);return false;
								var data=data.split("#");
								$('#tot_space_cost_rate').val(data[0]);
								//$('#mezzanine_space_charges').val(data[1]);
								
								$('#selected_premium_rate').val(data[1]); 
								$('#sub_total_cost').val(data[2]);
								$('#security_deposit').val(data[3]);
								$('#govt_service_tax').val(data[4]);
								$('#grand_total').val(data[5]);
							}
		});
 });
});
</script>

<!--<script>
  $("#category").live('change',function(){
	category=$('#category').val();
    $.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=getSchemeType&&category="+category,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
					//alert(data);
					$('#selected_scheme_type').html(data);
					}
		});
 });
</script>-->
   
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
    }
    else{
        $("#personal_info_reason_text").hide();
    }	
}
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

<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<link rel="stylesheet" type="text/css" media="screen" href="css/rcmc.validation.css" /> 

<script type="text/javascript">
$().ready(function() {
	$("#commentForm").validate();
	$("#form1").validate({
		rules: {			
			selected_area: {
				required: true,
			},  
			selected_scheme_type: {
				required: true,
			},
			selected_premium_type: {
				required: true,
			},
			option: {
				required: true,
			},
			tot_space_cost_rate:{
				required: true,
			},
		},
		messages: {			
			selected_area: {
				required: "Please select area",
			},  
			selected_scheme_type: {
				required: "Please select scheme type",
			},
			selected_premium_type: {
				required: "Please enter premium type",
			},
			option:{
				required: "Please select a option",
			},
			tot_space_cost_rate:{
				required: "Please calculate before final submission",
			},
		}
	});
});
</script>

<!--
<script>
  $("#selected_area").live('change',function(){
	var area = $("#selected_area").val();
	
	 $.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=areaValue&&area="+area,
					dataType:'html',
					
					success: function(data){
						//alert(data);
							if($.trim(data)!=""){
							$('#selected_stall_preference').html(data);
							}
						}
					
		});

 });
 
 $("#selected_stall_preference").live('change',function(){
	var selected_stall_preference = $("#selected_stall_preference").val();
	var area = $("#selected_area").val();
	//alert(area);
	 $.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=preferenceValue&&selected_stall_preference="+selected_stall_preference+"&&area="+area,
					dataType:'html',
					
					success: function(data){
						//alert(data);
							if($.trim(data)!=""){
							$('#selected_premium_type').val(data);
							}
						}
					
		});

 });
 
</script>-->

<script>
  $("#category").live('change',function(){
	  $('#tot_space_cost_rate').val('');
	  $('#selected_scheme_rate').val('');
	  $('#selected_premium_rate').val('');
	  $('#sub_total_cost').val('');
	  $('#security_deposit').val('');
	  $('#govt_service_tax').val('');
	  $('#grand_total').val('');
 });
</script>

<script>
  $("#selected_area").live('change',function(){
	  $('#tot_space_cost_rate').val('');
	  $('#selected_scheme_rate').val('');
	  $('#selected_premium_rate').val('');
	  $('#sub_total_cost').val('');
	  $('#security_deposit').val('');
	  $('#govt_service_tax').val('');
	  $('#grand_total').val('');
 });
</script>

<script>
  $("#selected_scheme_type").live('change',function(){
	  $('#tot_space_cost_rate').val('');
	  $('#selected_scheme_rate').val('');
	  $('#selected_premium_rate').val('');
	  $('#sub_total_cost').val('');
	  $('#security_deposit').val('');
	  $('#govt_service_tax').val('');
	  $('#grand_total').val('');
 });
</script>

<script>
  $("#selected_premium_type").live('change',function(){
	  $('#tot_space_cost_rate').val('');
	  $('#selected_scheme_rate').val('');
	  $('#selected_premium_rate').val('');
	  $('#sub_total_cost').val('');
	  $('#security_deposit').val('');
	  $('#govt_service_tax').val('');
	  $('#grand_total').val('');
 });
</script>
<!--<script>
$("#section").live('change',function(){

var section=$("#section").val();
if(section=="plain_gold")
{
	if($("#selected_area").is(":contains('12')"))
	{
		$("#selected_area option[value='24']").remove();
	}else
	{
		$("#selected_area").append("<option value='12'>12</option>");
	}
}else if(section=="allied")
{
	if($("#selected_area").is(":contains('12')"))
	{
	$("#selected_area").append("<option value='24'>24</option>");
	}else
	{
		$("#selected_area").append("<option value='12'>12</option><option value='24'>24</option>");
	}
	
}else
{
	$("#selected_area option[value='12']").remove();
	$("#selected_area option[value='24']").remove();
}
});
</script>-->

<script>
  $("#option").live('change',function(){
	  option=$('input[name=option]:checked').val();
	  
	  if(option=="Same stall position size as of previous year")
	  {
		$("#category").attr("disabled", "disabled");
		$("#selected_area").attr("disabled", "disabled");
		$("#selected_scheme_type").attr("disabled", "disabled");
		$("#selected_premium_type").attr("disabled", "disabled");
	  }
	  else if(option=="Same area but different location as of previous year IGJME 2016")
	  {
		$("#category").removeAttr("disabled");
		$("#selected_scheme_type").removeAttr("disabled");
		$("#selected_premium_type" ).removeAttr("disabled");
		$("#selected_area").attr("disabled", "disabled"); 
		
		$("#selected_scheme_type_hid").attr("disabled", "disabled");
		$("#selected_premium_type_hid").attr("disabled", "disabled");
	  }
	  else if(option=="More area than previous year IGJME")
	  {
		$("#category").removeAttr("disabled");
	  	$("#selected_area").removeAttr("disabled");
		$("#selected_scheme_type").removeAttr("disabled");
		$("#selected_premium_type").removeAttr("disabled");
		
		$("#selected_area_hid").attr("disabled", "disabled");
		$("#selected_scheme_type_hid").attr("disabled", "disabled");
		$("#selected_premium_type_hid").attr("disabled", "disabled");
	 }
	  else if(option=="Less area as previous year")
	  {
		$("#category").removeAttr("disabled");
		$("#selected_area").removeAttr("disabled");
		$("#selected_scheme_type").removeAttr("disabled");
		$("#selected_premium_type").removeAttr("disabled");
		
		$("#selected_area_hid").attr("disabled", "disabled");
		$("#selected_scheme_type_hid").attr("disabled", "disabled");
		$("#selected_premium_type_hid").attr("disabled", "disabled");
	  }
	  lastYearArea=$('#lastYearArea').val();
	
	  $.ajax({ type: 'POST',
					url: 'igjme_ajax.php',
					data: "actiontype=optionValue&&option="+option+"&&lastYearArea="+lastYearArea,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
						//alert(data);
						if($.trim(data)!=""){
							$('#selected_area').html(data);
						}
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
	<div class="breadcome"><a href="admin.php">Home</a> > Exhibitor Registration</div>
</div>

<div id="main">
	<div class="content">
    
    	<div class="content_head">IGJME &gt; Exhibitor Registration
        <div style="float:right; padding-right:10px; font-size:12px;"><a href="igjme_exhibitor_rgistration.php">Back to Search</a></div>
        </div>
<div class="content_details1">
<form name="form1" action="" method="post" onsubmit="return validation()"> 
<?php token(); ?>
<?php 
if($_SESSION['error_msg']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
$_SESSION['error_msg']="";
}
?>

<ul id="tabs" class="tab_1">
    <li id=""><a href="#"><strong>Step 1 GENERAL INFORMATION</strong></a></li>
    <li id=""><a href="#"><strong>Step 2 Company Details</strong></a></li>  
    <li id=""><a href="#" class="active"><strong>Step 3 Participation Stall Details</strong></a></li>
    <li id=""><a href="#" class="lastBg"><strong>Step 4 Payment Details</strong></a></li>  
    <div class="clear"></div>
</ul>

<div id="formCon">
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11" >Participation Stall Details</td>
</tr>
 <?php 
	/*...........................Last year participant  ..........................*/
	//$query1=mysql_query("select * from igjme_exh_registration where uid='$registration_id' and `show`='IGJME 2017' and last_yr_section_flag='1' and  curr_last_yr_check='N' order by exh_id desc limit 0,1");	
	$query1=$conn->query("select * from igjme_exh_registration where uid='$registration_id' and `show`='IGJME 2021' order by exh_id desc limit 0,1");	
	$result1=$query1->fetch_assoc();
	$exh_id=$result1['exh_id'];
	$num1=$query1->num_rows;
	
	$query=$conn->query("select * from igjme_exh_registration where uid='$registration_id' and gid='$gid' and `show`='IGJME 2022'");
	$result=$query->fetch_assoc();
	$num=$query->num_rows;
	if($num>0)
	{
		$exh_id=$result['exh_id'];
		//$section=$result['section'];
		$category=$result['category'];
		$option=$result['options'];
		$selected_area=$result['selected_area'];
		
		$selected_scheme_type=$result['selected_scheme_type'];
		$selected_premium_type=$result['selected_premium_type'];
		$tot_space_cost_rate=$result['tot_space_cost_rate'];
		$selected_scheme_rate=$result['selected_scheme_rate'];
		$selected_premium_rate=$result['selected_premium_rate'];
		$sub_total_cost=$result['sub_total_cost'];
		$security_deposit=$result['security_deposit'];
		$govt_service_tax=$result['govt_service_tax'];
		$swachh_bharat_cess=$result['swachh_bharat_cess'];
		$grand_total=$result['grand_total'];
		$mezzanine_space_charges=$result['mezzanine_space_charges'];
		$mcb_charges=$result['mcb_charges'];
		//$woman_entrepreneurs=$result['woman_entrepreneurs'];
	}
	else
	{		
		$option=$result1['options'];
		$category=$result1['category'];
		$selected_area=$result1['selected_area'];
		$section=$result1['section'];
		$selected_scheme_type=$result1['selected_scheme_type'];
		$selected_premium_type=$result1['selected_premium_type'];		
    }
	?>
   
<?php if($num1>0) { ?>
<tr>
    <td><strong>Last year details :</strong></td>
    <td>	
    		<strong>Last year Participant :</strong><?php if($num1>0){ echo $last_yr="Yes"; } else {echo $last_yr="No";}?><br />
    		
    		<strong>Category :</strong> <?php echo strtoupper($category);?> <br />
            <strong>Area :</strong> <?php echo strtoupper($selected_area);?> <br />
            <strong>Scheme type :</strong> <?php echo $selected_scheme_type?> <br />
            <strong>Premium type :</strong> <?php echo strtoupper($selected_premium_type);?></td>
</tr>	
   <?php } else { ?> 
    
<tr>
    <td>
    <strong>Last year Participant :</strong><?php echo strtoupper(No);?><br />
    <strong>Please select any of the :<sup>*</sup></strong></td>
    <td>
        <input type="radio" id="option" class="bgcolor" name="option"  checked="checked" value="New participant" /> <label for="b_1">New participant</label><br />
    </td>
</tr>
   <?php } ?>
  <input type="hidden" name="exh_id" id="exh_id" value="<?php echo $exh_id?>"/>
<input type="hidden" name="member_type" id="member_type" value="<?php echo $member_type;?>"/>

<tr>
         <td><strong>Please select any of the option <span>*</span> : </strong></td>
        <td> <input type="hidden" name="exh_id" id="exh_id" value="<?php echo $exh_id?>"/>
        <?php if($num1==0){?>
        <input type="radio" id="option" class="bgcolor" name="option"  checked="checked" value="New participant" /> <label for="b_1">New participant</label><br />
        <?php } else {?>
        <input type="radio" id="option" class="bgcolor" name="option" value="Same stall position size as of previous year" <?php if($option=="Same stall position size as of previous year" || $last_yr="Yes"){?> checked="checked" <?php } ?> /> Same stall position size as of previous year<br/>
        
        <input type="radio" id="option" class="bgcolor" name="option" value="Same area but different location as of previous year IGJME" <?php if($option=="Same area but different location as of previous year IGJME"){?> checked="checked" <?php } ?>/> 
        Same area but different location as of previous year IGJME<br/>
        
        <input type="radio" id="option" class="bgcolor" name="option" value="More area than previous year IGJME" <?php if($option=="More area than previous year IGJME"){?> checked="checked" <?php } ?>  /> More area than previous year IGJME<br/>
        
        <input type="radio" id="option" class="bgcolor" name="option" value="Less area as previous year" <?php if($option=="Less area as previous year"){?> checked="checked" <?php } ?>  /> Less area as previous year
        <?php }?></td>
</tr>
<input type="hidden" id="category" name="category" value="<?php echo $category;?>"/>
<!--
<tr>
  <td><strong>Select your Category : </strong></td>
  <td> 
		<select class="textField" id="category" name="category">
            <option value="">-----Select Category----</option>
			<option value="IGJME" <?php if($category=='IGJME'){?> selected="selected" <?php }?> >IGJME</option>
			<option value="COMBO" <?php if($category=='COMBO'){?> selected="selected" <?php }?> >IGJME & IIJS Combo</option>
         </select>
</td>
</tr>-->

<tr>
  <td><strong>Select your area : </strong></td>
  <td> <select name="selected_area" id="selected_area" class="bgcolor" >
            <option selected="selected" value="">-----Select Area----</option>
            <?php 			
			$sql="SELECT * FROM igjme_area_master order by area asc" ;
			$query=$conn->query($sql);
			while($result=$query->fetch_assoc()){
            ?>
            <option value="<?php echo $result['area'];?>" <?php if($result['area']==$selected_area){?> selected="selected" <?php }?>><?php echo $result['area'];?></option>
            <?php }?>
          </select>
         
          <input type="hidden" name="lastYearArea" id="lastYearArea" value="<?php echo $selected_area;?>"/>
		   <?php /*?><?php if($selected_area!=""){?>
		   <input type="hidden" name="selected_area" id="selected_area_hid" value="<?php echo $selected_area;?>"/>
		   <?php } ?><?php */?>
		  </td>
</tr>

<tr>
	<td><strong>Select your scheme type :  </strong></td>
	<td>
		<select class="bgcolor" id="selected_scheme_type" name="selected_scheme_type">
        <option selected="selected" value="">-----Select Scheme Type----</option>
        <option value="BI1" <?php if($selected_scheme_type=='BI1'){?> selected="selected" <?php }?> >Shell Scheme</option>
        </select>
	</td>
</tr>

<tr>
	<td><strong>Select your premium type : </strong></td>
	<td>
		<select class="bgcolor" name="selected_premium_type" id="selected_premium_type" >
           <option value="">-----Select Premium Type----</option>
			<?php 
			$sql="SELECT * FROM igjme_premium_master order by premium_id asc";
			$query=$conn->query($sql);
			while($result=$query->fetch_assoc()){
            ?>
            <option value="<?php echo $result['premium'];?>" <?php if($result['premium']==$selected_premium_type){?> selected="selected" <?php }?>><?php echo $result['premium_desc'];?></option>
            <?php }?> 
        </select>
    </td>
</tr>

<tr class="orange1">
    <td colspan="11" >Participation Stall Details</td>
</tr>

<tr>
  <td><strong>Click on calculate button to calculate the figures: </strong></td>
  <td> <input type="button" name="calculate" id="calculate" value="Calculate" class="input_submit" /></td>
</tr>

<tr>
  <td><strong>Total space cost rate <?php echo $currency;?> :</strong></td>
  <td><input type="text" class="bgcolor" name="tot_space_cost_rate" id="tot_space_cost_rate"  value="<?php echo $tot_space_cost_rate;?>" readonly="readonly" /></td>
</tr>
<tr >
  <td><strong>Selected premium rate <?php echo $currency;?>:</strong></td>
  <td><input type="text" class="bgcolor" name="selected_premium_rate" id="selected_premium_rate" readonly="readonly" value="<?php echo $selected_premium_rate;?>"/></td>
</tr>
<tr >
  <td><strong>Sub Total cost <?php echo $currency;?>:</strong></td>
  <td><input type="text" class="bgcolor" name="sub_total_cost" id="sub_total_cost" readonly="readonly" value="<?php echo $sub_total_cost;?>" /></td>
</tr>

<tr >
  <td><strong>Security Deposit (10% on<br /> SubTotal Cost) <?php echo $currency;?> :</strong></td>
  <td><input type="text" class="bgcolor" name="security_deposit" id="security_deposit" readonly="readonly" value="<?php echo $security_deposit;?>" /></td>
</tr>    
    
<tr>
  <td><strong>GST (18% on SubTotal Cost) <?php echo $currency;?> : </strong></td>
  <td><input type="text" class="bgcolor" id="govt_service_tax" name="govt_service_tax" readonly="readonly" value="<?php echo $govt_service_tax;?>" /></td>
</tr>
<tr>
  <td><strong>Grand Total </strong><?php echo $currency;?> :</strong></td>
  <td><input type="text" class="bgcolor" id="grand_total" name="grand_total" readonly="readonly" value="<?php echo $grand_total;?>" /></td>
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
<input type="hidden" name="country" id="country" value="<?php echo $country;?>" />
<input type="hidden" name="action" id="action" value="UPDATE" />
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