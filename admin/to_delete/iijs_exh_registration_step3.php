<?php session_start();
ob_start();
?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
$gid=mysql_real_escape_string($_REQUEST['gid']);
$registration_id=mysql_real_escape_string($_REQUEST['registration_id']);
$sql="select  * from exh_reg_general_info where  uid='$registration_id' and event_for='IIJS 2017'";
$result=mysql_query($sql);
$rows=mysql_fetch_array($result);

$company_name=$rows['company_name'];
$membership_id=$rows['membership_id'];
$country=$rows['country'];
if($country=='INDIA' ||$country=='IND')
{
	$currency='INR';	
}else{
	$currency='USD';	
}
/*....................................Combo Member/Nonmember Price calculate Start.........................................*/
$schk_membership="SELECT * FROM `approval_master`  WHERE 1 and `registration_id`='$registration_id' and (`membership_issued_certificate_dt` between '2017-03-31' and '2018-04-1' || membership_renewal_dt between '2017-03-31' and '2018-04-1')";
		 
		$qchk_membership=mysql_query($schk_membership);
		$nchk_membership=mysql_num_rows($qchk_membership);
		 
		$_SESSION['combo']=getUserCombo($registration_id);
		
		if($nchk_membership>0){$_SESSION['member_type']= 'MEMBER';}
			else{ $_SESSION['member_type']= 'NON_MEMBER';} 
/*....................................Combo Member/Nonmember Price calculate Start.........................................*/
?>
<?php
$action=$_REQUEST['action'];
if($action=='UPDATE')
{
	$exh_id=mysql_real_escape_string($_REQUEST['exh_id']);
	$gid=mysql_real_escape_string($_REQUEST['gid']);
	$uid=mysql_real_escape_string($_REQUEST['registration_id']);
	
	$option=mysql_real_escape_string($_REQUEST['option']);
	$section=mysql_real_escape_string($_REQUEST['section']);
	$selected_area=mysql_real_escape_string($_REQUEST['selected_area']);
	
	$category=mysql_real_escape_string($_REQUEST['category']);
	$selected_scheme_type=mysql_real_escape_string($_REQUEST['selected_scheme_type']);
	$selected_premium_type=mysql_real_escape_string($_REQUEST['selected_premium_type']);
	
	$woman_entrepreneurs=$_REQUEST['woman_entrepreneurs'];
	
	$tot_space_cost_rate=mysql_real_escape_string($_REQUEST['tot_space_cost_rate']);
	
	$selected_scheme_rate=mysql_real_escape_string($_REQUEST['selected_scheme_rate']);
	$selected_premium_rate=mysql_real_escape_string($_REQUEST['selected_premium_rate']);
	
	$sub_total_cost=mysql_real_escape_string($_REQUEST['sub_total_cost']);
	$mezzanine_space_charges=mysql_real_escape_string($_REQUEST['mezzanine_space_charges']);
	$security_deposit=mysql_real_escape_string($_REQUEST['security_deposit']);
	$country=mysql_real_escape_string($_REQUEST['country']);
	$govt_service_tax=$_REQUEST['govt_service_tax'];
	$grand_total=$_REQUEST['grand_total'];	
	$mcb_charges=$_REQUEST['mcb_charges'];
	$modified_date=date('Y-m-d');
	
	
	$updatesql="update exh_registration set options='$option',woman_entrepreneurs='$woman_entrepreneurs', section='$section',category='$category',selected_area='$selected_area',selected_scheme_type='$selected_scheme_type',selected_premium_type='$selected_premium_type',tot_space_cost_rate='$tot_space_cost_rate',mezzanine_space_charges='$mezzanine_space_charges',selected_scheme_rate='$selected_scheme_rate',selected_premium_rate='$selected_premium_rate',sub_total_cost ='$sub_total_cost',security_deposit='$security_deposit',govt_service_tax='$govt_service_tax',grand_total='$grand_total',mcb_charges='$mcb_charges',modified_date='$modified_date' where exh_id='$exh_id' and gid='$gid' and uid='$uid' and `show`='IIJS 2017'";
		
	
	if (!mysql_query($updatesql))
	{
		die('Error: ' . mysql_error());
	}

$_SESSION['succ_msg']="Stall updated successfully";
header("Location: iijs_exh_registration_step4.php?id=$gid&registration_id=$uid");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IIJS &gt; Exhibitor Registration &gt; Step1</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/formAdmin.css"/>

<!--navigation-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 

<script>
$(document).ready(function(){
  $("#calculate").click(function(){
  
  section=$("#section").val();
  selected_area=$("#selected_area").val();
  selected_scheme_type=$("#selected_scheme_type").val();
  category=$('#category').val();
  selected_premium_type=$("#selected_premium_type").val();
  country=$("#country").val();
 
  woman_entrepreneurs=$('[name=woman_entrepreneurs]:checked').val();
	$.ajax({ type: 'POST',
					url: 'iijs_ajax.php',
					data: "actiontype=calculatePayment&&section="+section+"&&selected_area="+selected_area+"&&selected_scheme_type="+selected_scheme_type+"&&selected_premium_type="+selected_premium_type+"&&woman_entrepreneurs="+woman_entrepreneurs+"&&category="+category+"&&country="+country,
					dataType:'html',
					beforeSend: function(){
					
							},
					success: function(data){
							    //alert(data);return false;
								var data=data.split("#");
								$('#tot_space_cost_rate').val(data[0]);
								$('#mezzanine_space_charges').val(data[1]);
								$('#selected_scheme_rate').val(data[2]);
								$('#selected_premium_rate').val(data[3]); 
								$('#sub_total_cost').val(data[4]);
								$('#security_deposit').val(data[5]);
								$('#govt_service_tax').val(data[6]);
								$('#grand_total').val(data[7]);
								$('#mcb_charges').val(data[8]);
								$("#selected_area").val(selected_area);
							}
		});
 });
});
</script>

<script>
  $("#option").live('change',function(){
	  option=$('input[name=option]:checked').val();
	  lastYearArea=$('#lastYearArea').val();
	$.ajax({ type: 'POST',
					url: 'ajax.php',
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
<script>
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
</script>
   
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
			section: {
			required: true,
			},  
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
			section: {
				required: "Please select section",
			},
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
<script>
  $("#section").live('change',function(){
	  $('#tot_space_cost_rate').val('');
	  $('#mezzanine_space_charges').val('');
	  $('#selected_scheme_rate').val('');
	  $('#selected_premium_rate').val('');
	  $('#sub_total_cost').val('');
	  $('#security_deposit').val('');
	  $('#govt_service_tax').val('');
	  $('#grand_total').val('');
	  $('#mcb_charges').val('');
 });
</script>
<script>
  $("#category").live('change',function(){
	  $('#tot_space_cost_rate').val('');
	  $('#mezzanine_space_charges').val('');
	  $('#selected_scheme_rate').val('');
	  $('#selected_premium_rate').val('');
	  $('#sub_total_cost').val('');
	  $('#security_deposit').val('');
	  $('#govt_service_tax').val('');
	  $('#grand_total').val('');
	  $('#mcb_charges').val('');
 });
</script>


<script>
  $("#selected_area").live('change',function(){
	  $('#tot_space_cost_rate').val('');
	  $('#mezzanine_space_charges').val('');
	  $('#selected_scheme_rate').val('');
	  $('#selected_premium_rate').val('');
	  $('#sub_total_cost').val('');
	  $('#security_deposit').val('');
	  $('#govt_service_tax').val('');
	  $('#grand_total').val('');
	  $('#mcb_charges').val('');
 });
</script>

<script>
  $("#selected_scheme_type").live('change',function(){
	  $('#tot_space_cost_rate').val('');
	  $('#mezzanine_space_charges').val('');
	  $('#selected_scheme_rate').val('');
	  $('#selected_premium_rate').val('');
	  $('#sub_total_cost').val('');
	  $('#security_deposit').val('');
	  $('#govt_service_tax').val('');
	  $('#grand_total').val('');
	  $('#mcb_charges').val('');
 });
</script>

<script>
  $("#selected_premium_type").live('change',function(){
	  $('#tot_space_cost_rate').val('');
	  $('#mezzanine_space_charges').val('');
	  $('#selected_scheme_rate').val('');
	  $('#selected_premium_rate').val('');
	  $('#sub_total_cost').val('');
	  $('#security_deposit').val('');
	  $('#govt_service_tax').val('');
	  $('#grand_total').val('');
	  $('#mcb_charges').val('');
 });
</script>
<script>
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
    
    	<div class="content_head">IIJS &gt; Exhibitor Registration
        <div style="float:right; padding-right:10px; font-size:12px;"><a href="iijs_exhibitor_rgistration.php">Back to Search</a></div>
        </div>
<div class="content_details1">
<form name="form1" action="" method="post" onsubmit="return validation()"> 
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
	$query1=mysql_query("select * from exh_registration where uid='$registration_id' and `show`='IIJS 2016' and last_yr_section_flag='1' order by exh_id desc limit 0,1");
	$result1=mysql_fetch_array($query1);
	$exh_id=$result1['exh_id'];
	$num1=mysql_num_rows($query1);
	
	$query=mysql_query("select * from exh_registration where uid='$registration_id' and gid='$gid' and `show`='IIJS 2017'");
	$result=mysql_fetch_array($query);
	$num=mysql_num_rows($query);
	if($num>0)
	{
		$exh_id=$result['exh_id'];
		$section=$result['section'];
		$category=$result['category'];
		$option=$result['options'];
		$selected_area=$result['selected_area'];
		$stall_options=$result['stall_options'];
		$selected_scheme_type=$result['selected_scheme_type'];
		$selected_premium_type=$result['selected_premium_type'];
		$tot_space_cost_rate=$result['tot_space_cost_rate'];
		$selected_scheme_rate=$result['selected_scheme_rate'];
		$selected_premium_rate=$result['selected_premium_rate'];
		$sub_total_cost=$result['sub_total_cost'];
		$security_deposit=$result['security_deposit'];
		$govt_service_tax=$result['govt_service_tax'];
		$grand_total=$result['grand_total'];
		$mezzanine_space_charges=$result['mezzanine_space_charges'];
		$mcb_charges=$result['mcb_charges'];
		$woman_entrepreneurs=$result['woman_entrepreneurs'];
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
   
<tr>
    <td width="25%"><strong>Last year participant : </strong></td>
    <td width="75%"><span class="chkbox" style="width:100px;">
              <?php if($num1>0){ echo $last_yr="Yes"; ?>
              
              <?php } else {echo $last_yr="No";}?>
              </span>
              <input type="hidden" name="last_yr_participant" id="last_yr_participant" value="<?php echo $last_yr;?>"/></td>
</tr>
<?php if($num==0) { ?>
<tr >
    <td ><strong>Last year details :</strong></td>
    <td><strong>Section :</strong><?php echo strtoupper($section);?><br />
            <strong>Area :</strong> <?php echo strtoupper($selected_area);?> <br />
            <strong>Scheme type :</strong> <?php echo $selected_scheme_type?> <br />
            <strong>Premium type :</strong> <?php echo strtoupper($selected_premium_type);?></td>
</tr>	
   <?php } ?> 
    
<tr >
    <td><strong>Please select any of the :<sup>*</sup></strong></td>
    <td><input type="hidden" name="exh_id" id="exh_id" value="<?php echo $exh_id?>"/>
        <?php if($num1==0){?>
        <input type="radio" id="option" class="bgcolor" name="option"  checked="checked" value="New participant" /> <label for="b_1">New participant</label><br />
        <?php } else {?>
        <input type="radio" id="option" class="bgcolor" name="option" value="Same stall" <?php if($option=="Same stall"){?> checked="checked" <?php } ?> /> <label for="b_2">Same stall position size as of previous year</label><br/>
       <input type="radio" id="option" class="bgcolor" name="option" value="Same area but different location as of previous year IIJS 2015" <?php if($option=="Same area but different location as of previous year IIJS 2015"){?> checked="checked" <?php } ?> /> <label for="b_2">Same area but different location as of previous year IIJS 2014</label><br/>     
       
        <input type="radio" id="option" class="bgcolor" name="option" value="More area than previous year IIJS" <?php if($option=="More area than previous year IIJS"){?> checked="checked" <?php } ?> /><label for="b_2"> More area than previous year IIJS 2015</label><br/>
       
        <input type="radio" id="option" class="bgcolor" name="option" value="Less area as previous year at diffrent location" <?php if($option=="Less area as previous year at diffrent location"){?> checked="checked" <?php } ?> /> <label for="b_2">Less area as previous year at diffrent location</label><br/>
         <input type="radio" id="option" class="bgcolor" name="option" value="Less area as previous year" <?php if($option=="Less area as previous year"){?> checked="checked" <?php } ?> /><label for="b_2"> Less area as previous year at same location</label>
        <?php }?></td>
</tr>

<tr >
  <td><strong>Select your section :</strong></td>
  <td><select name="section" id="section"  class="bgcolor">
          <option selected="selected" value="">-----Select Section----</option>
            <?php 
			$sql="SELECT * FROM iijs_section_master";
            $query=mysql_query($sql);
            while($result=mysql_fetch_array($query)){
            ?>
            <option value="<?php echo $result['section'];?>" <?php if($result['section']==$section){?> selected="selected" <?php }?> ><?php echo $result['section_desc'];?></option>
            <?php }?>
			<option value="International Jewellery" <?php if($section=="International Jewellery"){?> selected="selected" <?php }?>>International Jewellery</option>
            <option value="International Loose" <?php if($section=="International Loose"){?> selected="selected" <?php }?>>International Loose</option>
            <option value="machinery" <?php if($section=="machinery"){?> selected="selected" <?php }?>>Machinery</option>
            <option value="Allied" <?php if($section=="Allied"){?> selected="selected" <?php }?>>Allied</option>
          </select>          </td>
</tr>

<tr >
  <td><strong>Select your category :</strong></td>
  <td><select name="category" id="category"  class="bgcolor">
          <option selected="selected" value="">-----Select Category----</option>
            <?php 
				$sql="SELECT * FROM iijs_category_master";
            $query=mysql_query($sql);
            while($result=mysql_fetch_array($query)){
            ?>
            <option value="<?php echo $result['category'];?>" <?php if($result['category']==$category){?> selected="selected" <?php }?> ><?php echo $result['category_desc'];?></option>
            <?php }?>
          </select></tr>

<tr >
  <td><strong>Select your area : </strong></td>
  <td> <select name="selected_area" id="selected_area" class="bgcolor" >
            <option selected="selected" value="">-----Select Area----</option>
            <?php 
			/*
			if($selected_area==9){$sql="SELECT * FROM iijs_area_master where area=9 or area=18 or area=25";}
			else if($selected_area==18){$sql="SELECT * FROM iijs_area_master where area=18 or area=25 or area=27";}
			else if($selected_area==25){$sql="SELECT * FROM iijs_area_master where area=25 or area=25 or area=36";}
			else if($selected_area==27){$sql="SELECT * FROM iijs_area_master where area=27 or area=36 or area=45";}
			else if($selected_area==36){$sql="SELECT * FROM iijs_area_master where area=36 or area=45 or area=54";}
			else if($selected_area==45){$sql="SELECT * FROM iijs_area_master where area=45 or area=54 or area=72";}
			else if($selected_area==54){$sql="SELECT * FROM iijs_area_master where area=54 or area=72 or area=144" ;}
			else if($selected_area>54){$sql="SELECT * FROM iijs_area_master order by area_id desc limit 0,2" ;}
			*/
			
			$sql="SELECT * FROM iijs_area_master order by area_id asc" ;
				$query=mysql_query($sql);
				while($result=mysql_fetch_array($query)){
            ?>
            <option value="<?php echo $result['area'];?>" <?php if($result['area']==$selected_area){?> selected="selected" <?php }?>><?php echo $result['area'];?></option>
            <?php }?>
          </select>
         
          
          <input type="hidden" name="lastYearArea" id="lastYearArea" value="<?php echo $selected_area;?>"/></td>
</tr>
<?php if($section!='machinery'){?>
<tr>
  <td><strong>Select your scheme type :  </strong></td>
  <td> <select class="bgcolor" id="selected_scheme_type" name="selected_scheme_type">
        <option selected="selected" value="">-----Select Scheme Type----</option>
			<?php 
				if($category=="mezzanine")
				{
					$sql="SELECT * FROM iijs_scheme_master where scheme='MEM'";
				}
				else
				{
					$sql="SELECT * FROM iijs_scheme_master where scheme!='MEM'";
				}
				$query=mysql_query($sql);
				while($result=mysql_fetch_array($query)){
            ?>
            <option value="<?php echo $result['scheme'];?>" <?php if($result['scheme']==$selected_scheme_type ){ echo "selected='selected'";}?>><?php echo $result['scheme_desc'];?></option>
            <?php }?> 
         </select></td>
</tr>
<?php } else {?>
<input type="hidden" name="selected_scheme_type" id="selected_scheme_type" value="0"/>
<?php }?>

<tr>
  <td><strong>Select your premium type : </strong></td>
  <td> <select class="bgcolor" name="selected_premium_type" id="selected_premium_type" >
            <option value="">-----Select Premium Type----</option>
			<?php 
				$sql="SELECT * FROM iijs_premium_master order by premium_id asc";
				$query=mysql_query($sql);
				while($result=mysql_fetch_array($query)){
            ?>
            <option value="<?php echo $result['premium'];?>" <?php if($result['premium']==$selected_premium_type){?> selected="selected" <?php }?>><?php echo $result['premium_desc'];?></option>
            <?php }?> 
            </select>           </td>
</tr>

<tr >
  <td><strong>Woman Entrepreneurs : </strong></td>
  <td> <input type="radio" id="woman_entrepreneurs" name="woman_entrepreneurs" class="bgcolor" value="1" <?php if($woman_entrepreneurs==1){?> checked="checked"<?php }?> /> <label for="c_1">Yes</label> <input type="radio" id="woman_entrepreneurs" name="woman_entrepreneurs" class="bgcolor" value="0" <?php if($woman_entrepreneurs==0){?> checked="checked"<?php }?> /> <label for="c_2">No</label></td>
</tr>

<tr class="orange1">
    <td colspan="11" >Participation Stall Details</td>
</tr>

<tr >
  <td><strong>Click on calculate button to calculate the figures: </strong></td>
  <td><input type="button" name="calculate" id="calculate" value="Calculate" class="input_submit" /></td>
</tr>

<tr >
  <td><strong>Total space cost rate <?php echo $currency;?> :</strong></td>
  <td><input type="text" class="bgcolor" name="tot_space_cost_rate" id="tot_space_cost_rate"  value="<?php echo $tot_space_cost_rate;?>" readonly="readonly" /></td>
</tr>

<tr >
  <td><strong>Mezzanine Space Charges <?php echo $currency;?> :</strong></td>
  <td><input type="text" class="bgcolor" name="mezzanine_space_charges" id="mezzanine_space_charges"  value="<?php echo $mezzanine_space_charges;?>" readonly="readonly" /></td>
</tr>
<tr >
  <td><strong>Selected scheme rate <?php echo $currency;?>:</strong></td>
  <td><input type="text" class="bgcolor" name="selected_scheme_rate" id="selected_scheme_rate" readonly="readonly" value="<?php echo $selected_scheme_rate;?>" /></td>
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
    
<tr >
  <td><strong>Govt. Service Tax (14.5% on SubTotal Cost) <?php echo $currency;?> : </strong></td>
  <td><input type="text" class="bgcolor" id="govt_service_tax" name="govt_service_tax" readonly="readonly" value="<?php echo $govt_service_tax;?>" /></td>
</tr>

<tr >
  <td><strong>Grand Total </strong><?php echo $currency;?> :</strong></td>
  <td><input type="text" class="bgcolor" id="grand_total" name="grand_total" readonly="readonly" value="<?php echo $grand_total;?>" /></td>
</tr>

<tr >
  <td><strong>MCB Charges</strong><?php echo $currency;?> :</strong></td>
  <td><input type="text" class="bgcolor" id="mcb_charges" name="mcb_charges" readonly="readonly" value="<?php echo $mcb_charges;?>" /></td>
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
