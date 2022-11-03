<?php
session_start();
ob_start();
include('../db.inc.php');
include('../functions.php');

$gid=filter($_REQUEST['gid']);
$registration_id=filter($_REQUEST['registration_id']);
$show = "IIJS Tritiya 2023";
$sql="select * from exh_reg_general_info where uid='$registration_id' and event_for='$show'";
$result=$conn->query($sql);
$rows=$result->fetch_assoc();

$company_name=$rows['company_name'];
$membership_id=$rows['membership_id'];
$country=$rows['country'];
if($country=='INDIA' || $country=='IND' || $country=='IN')
{
$currency='INR';	
}else{
$currency='USD';	
}
?>
<?php
/*..................Combo Member/Nonmember Price calculate Start................*/
$schk_membership="SELECT * FROM `approval_master`  WHERE 1 and `registration_id`='$registration_id' and issue_membership_certificate_expire_status='Y'";
$qchk_membership=$conn->query($schk_membership);
$get_membership=$qchk_membership->fetch_assoc();	
$nchk_membership=$qchk_membership->num_rows;
if($nchk_membership>0){	
		$_SESSION['member_type']= 'MEMBER'; 
		$_SESSION['membership_certificate_type']= $get_membership['membership_certificate_type'];
		$_SESSION['msme_ssi_status']= chk_msme($registration_id,$conn);
		} else { $_SESSION['member_type']= 'NON_MEMBER';} 
?>
<?php
$action=$_REQUEST['action'];
if($action=='UPDATE')
{
	$exh_id=filter($_REQUEST['exh_id']);
	$gid=filter($_REQUEST['gid']);
	
	$uid=filter($_REQUEST['registration_id']);
	
	$option=filter($_REQUEST['option']);
    $section=filter($_REQUEST['section']);
	$selected_area=filter($_REQUEST['selected_area']);
	$category=filter($_REQUEST['category']);
	$selected_scheme_type=filter($_REQUEST['selected_scheme_type']);
	$selected_premium_type=filter($_REQUEST['selected_premium_type']);	
	$woman_entrepreneurs=$_REQUEST['woman_entrepreneurs'];
	
	$tot_space_cost_rate=filter($_REQUEST['tot_space_cost_rate']);	
	if($tot_space_cost_rate=='') $tot_space_cost_rate=0;
	
	$tot_space_cost_discount=filter($_REQUEST['tot_space_cost_discount']);	
	if($tot_space_cost_discount=='') $tot_space_cost_discount=0;
	
	$tot_space_cost_discount=filter($_REQUEST['tot_space_cost_discount']);	
	if($tot_space_cost_discount=='') $tot_space_cost_discount=0;
	
	 $get_category_rate=filter($_REQUEST['get_category_rate']);
	if($get_category_rate=='') $get_category_rate=0;
	

	$get_tot_space_cost_rate=filter($_REQUEST['get_tot_space_cost_rate']);	
	if($get_tot_space_cost_rate=='') $get_tot_space_cost_rate=0;
	
	$selected_scheme_rate=filter($_REQUEST['selected_scheme_rate']);	
	if($selected_scheme_rate=='') $selected_scheme_rate=0;
		
	$selected_premium_rate=filter($_REQUEST['selected_premium_rate']);	
	if($selected_premium_rate=='') 	$selected_premium_rate=0;
		
	$sub_total_cost=filter($_REQUEST['sub_total_cost']);	
	if($sub_total_cost=='') $sub_total_cost=0;
	
	$mezzanine_space_charges=filter($_REQUEST['mezzanine_space_charges']);
	if($mezzanine_space_charges=='')	$mezzanine_space_charges=0;
		
	$security_deposit=filter($_REQUEST['security_deposit']);
	if($security_deposit=='')	$security_deposit=0;
	
	$mcb_charges=$_REQUEST['mcb_charges'];
	if($mcb_charges=='') $mcb_charges=0;
	
	$country=filter($_REQUEST['country']);
	$govt_service_tax=$_REQUEST['govt_service_tax'];
	$grand_total=$_REQUEST['grand_total'];	
	
	$modified_date=date('Y-m-d');	
	
	$updatesql="update exh_registration set options='$option',woman_entrepreneurs='$woman_entrepreneurs', section='$section',category='$category',selected_area='$selected_area',selected_scheme_type='$selected_scheme_type',selected_premium_type='$selected_premium_type',tot_space_cost_rate='$tot_space_cost_rate',tot_space_cost_discount='$tot_space_cost_discount',get_tot_space_cost_rate='$get_tot_space_cost_rate',mezzanine_space_charges='$mezzanine_space_charges',selected_scheme_rate='$selected_scheme_rate',selected_premium_rate='$selected_premium_rate',sub_total_cost ='$sub_total_cost',security_deposit='$security_deposit',govt_service_tax='$govt_service_tax',grand_total='$grand_total',mcb_charges='$mcb_charges',modified_date='$modified_date',`get_category_rate`='$get_category_rate' where exh_id='$exh_id' and gid='$gid' and uid='$uid' and `show`='$show'";
	
	if(!$conn->query($updatesql)){	die('Error: ' . $conn->connect_error());	}
	else
	{
	$_SESSION['succ_msg']="Stall updated successfully";
	header("Location: tritiya_exh_registration_step4.php?id=$gid&registration_id=$uid");
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IIJS-tritiya &gt; Exhibitor Registration &gt; Step-3</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/formAdmin.css"/>
<!--navigation-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
<script>
$(document).ready(function(){
  $("#calculate").click(function(){
  section=$("#section").val();
  selected_area=$("#selected_area").val();
  category=$('#category').val();
  selected_premium_type=$("#selected_premium_type").val();
  selected_scheme_type=$("#selected_scheme_type").val();
  last_yr_participant=$("#last_yr_participant").val();
  country=$("#country").val();
  woman_entrepreneurs=$('[name=woman_entrepreneurs]:checked').val();

	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=calculatePaymentTritiya&&selected_area="+selected_area+"&&section="+section+"&&selected_premium_type="+selected_premium_type+"&&woman_entrepreneurs="+woman_entrepreneurs+"&&category="+category+"&&country="+country+"&&last_yr_participant="+last_yr_participant,
					dataType:'html',
					beforeSend: function(){
					
							},
					success: function(data){
							  //  alert(data);return false;
								var data=data.split("#");
								// $('#tot_space_cost_rate').val(data[0]);
								// $('#tot_space_cost_discount').val(data[1]);
								// $('#get_tot_space_cost_rate').val(data[2]);
								// $('#get_category_rate').val(data[3]);
								// $('#selected_scheme_rate').val(data[4]);
								// $('#selected_premium_rate').val(data[5]); 
								// $('#sub_total_cost').val(data[6]);
								// $('#security_deposit').val(data[7]);
								// $('#govt_service_tax').val(data[8]);
								// $('#grand_total').val(data[9]);
								 $('#tot_space_cost_rate').val(data[0]);
								 $('#sub_total_cost').val(data[1]);
	 							 $('#security_deposit').val(data[2]);
	 							 $('#govt_service_tax').val(data[3]);
								 $('#grand_total').val(data[4]);

							}
		});
 });
});
</script>

<!--<script>
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
    }
    else{
        $("#personal_info_reason_text").hide();
    }	
}
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
      section=$("#section").val();
	  //alert(section);
	  selected_area=$("#selected_area").val()
	  option=$("input[name='option']:checked").val();
	  $('#tot_space_cost_rate').val('');
	  $('#tot_space_cost_discount').val('');
	  $('#get_tot_space_cost_rate').val('');
	  $('#selected_scheme_rate').val('');
	  $('#selected_premium_rate').val('');
	  $('#sub_total_cost').val('');
	  $('#security_deposit').val('');
	  $('#govt_service_tax').val('');
	  $('#grand_total').val('');
	  
	   $.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=selectArea&&section="+section+"&&option="+option+"&&selected_area="+selected_area,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							    //alert(data);
								$("#selected_area").html(data);
							}
		});
 });
</script>
<script>
	$("#category").live('change',function(){
	  $('#tot_space_cost_rate').val('');
	  $('#tot_space_cost_discount').val('');
	  $('#get_tot_space_cost_rate').val('');
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
	  $('#tot_space_cost_discount').val('');
	  $('#get_tot_space_cost_rate').val('');
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
	   $('#tot_space_cost_discount').val('');
	  $('#get_tot_space_cost_rate').val('');
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
	   $('#tot_space_cost_discount').val('');
	  $('#get_tot_space_cost_rate').val('');
	  $('#selected_scheme_rate').val('');
	  $('#selected_premium_rate').val('');
	  $('#sub_total_cost').val('');
	  $('#security_deposit').val('');
	  $('#govt_service_tax').val('');
	  $('#grand_total').val('');
 });
</script>

<script>
  $("#option").live('change',function(){
	option=$('input[name=option]:checked').val();
	lastYearArea=$('#lastYearArea').val();
	section=$("#section").val();
	$.ajax({ 
					type: 'POST',
					url: 'ajax.php',
					data: "actiontype=optionValue&&option="+option+"&&lastYearArea="+lastYearArea+"&&section="+section,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
					//alert(data);
						/*if($.trim(data)!=""){
							$('#selected_area').html(data);
						} */
						var res = data.split("#");
						if($.trim(res[0])!=""){
							$('#selected_area').html(res[0]);
						}
						if($.trim(res[1])!=""){
							$('#selected_scheme_type').html(res[1]);
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
    
    	<div class="content_head">IIJS-Tritiya &gt; Exhibitor Registration
        <div style="float:right; padding-right:10px; font-size:12px;"><a href="tritiya_exhibitor_rgistration.php">Back to Search</a></div>
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
//echo "select * from exh_registration where uid='$registration_id' and `show`='IIJS Signature 2018' and last_yr_section_flag='1' order by exh_id desc limit 0,1";
	//$query1=mysql_query("select * from exh_registration where uid='$registration_id' and `show`='IIJS Signature 2018' and last_yr_section_flag='1' order by exh_id desc limit 0,1");

	$query1=$conn->query("select * from exh_registration where uid='$registration_id' and `show`='IIJS Tritiya 2023' order by exh_id desc limit 0,1");
	$result1=$query1->fetch_assoc();
	$exh_id=$result1['exh_id'];
	$num1=$query1->num_rows;
	
	$query=$conn->query("select * from exh_registration where uid='$registration_id' and gid='$gid' and `show`='$show'");
	$result=$query->fetch_assoc();
	$num = $query->num_rows;
	if($num>0)
	{	
		$roi=$result['roi'];
		$exh_id=$result['exh_id'];
		$section=$result['section'];
		$category=$result['category'];
		$option=$result['options'];
		$selected_area=$result['selected_area'];
		$stall_options=$result['stall_options'];
		$selected_scheme_type=$result['selected_scheme_type'];
		$selected_premium_type=$result['selected_premium_type'];
		$tot_space_cost_rate=$result['tot_space_cost_rate'];
		$tot_space_cost_discount=$result['tot_space_cost_discount'];
		$get_tot_space_cost_rate=$result['get_tot_space_cost_rate'];
		$get_category_rate=$result['get_category_rate'];
		
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
		$roi=$result1['roi'];
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
              <?php /*if($num1>0){ echo $last_yr="Yes"; ?>
              
              <?php } else {echo $last_yr="No";} */
			  /*if($result1['last_yr_participant']=='YES'){ echo $last_yr="YES"; } else { echo $last_yr="NO";} today*/
			  if($result1['last_yr_participant']=='YES'){ echo $last_yr="YES"; } else { echo $last_yr="NO";}?>			  
            </span>
            <input type="hidden" name="last_yr_participant" id="last_yr_participant" value="<?php echo $last_yr;?>"/></td>
</tr>
<?php 
$query_roi=$conn->query("select * from roi_dump_data where uid='$registration_id'");
$result_roi=$query_roi->fetch_assoc();
$num_roi=$query_roi->num_rows;
?>
<!--<tr>
    <td width="25%"><strong>ROI Submitted : </strong></td>
    <td width="75%">
    <span class="chkbox" style="width:100px;">
	  <?php /*if($num_roi>0){ echo $result_roi['roi']; ?> <?php } else {echo "No";} */?>
	  <?php if($roi!='')echo $roi;else echo 'NO';?>
    </span>
  </td>
</tr>-->

<tr>
    <td><strong>Last year details :</strong></td>
    <td>
	<strong>Section :</strong> <?php echo strtoupper($section);?><br />
    <strong>Area :</strong> <?php echo strtoupper($selected_area);?> <br />
	<strong>Category type :</strong> <?php echo $category?> <br />
    <strong>Scheme type :</strong> <?php echo $selected_scheme_type?> <br />
    </td>
</tr>	
   
<tr >
    <td><strong>Please select any of the :<sup>*</sup></strong></td>
    <td><input type="hidden" name="exh_id" id="exh_id" value="<?php echo $exh_id?>"/>
        <?php /*if($num1==0){ */?>
        <input type="radio" id="option" class="bgcolor" name="option"  checked="checked" value="New participant" /> <label for="b_1">New participant</label><br />
        <?php /*} else { */?>
        <input type="radio" id="option" class="bgcolor" name="option" value="Same stall position size as of previous year" <?php if($option=="Same stall position size as of previous year"){?> checked="checked" <?php } ?> />  Same stall position as offered by GJEPC refer Annexure 1.<br/>
        <input type="radio" id="option" class="bgcolor" name="option" value="Same area but different location as of previous year Signature" <?php if($option=="Same area but different location as of previous year Signature"){?> checked="checked" <?php } ?> /> 
         Same area but different location as offered by GJEPC refer Annexure 1.<br/>
        <input type="radio" id="option" class="bgcolor" name="option" value="More area than previous year Signature" <?php if($option=="More area than previous year Signature"){?> checked="checked" <?php } ?> />  More area than previous year<br/>
        <input type="radio" id="option" class="bgcolor" name="option" value="Less area as previous year" <?php if($option=="Less area as previous year"){?> checked="checked" <?php } ?> /> Less area as previous year 
        <?php /*}*/ ?>
        </td>
</tr>

<tr>
  <td><strong>Select your section :</strong></td>
  <td>
	<select name="section" id="section"  class="bgcolor">
          <option selected="selected" value="">-----Select Section----</option>
            <?php			
			$sql="SELECT * FROM signature_section_master ORDER BY section_desc";
            $query=$conn->query($sql);			
            while($result=$query->fetch_assoc()){
            ?>
            <option value="<?php echo $result['section'];?>" <?php if($result['section']==$section){?> selected="selected" <?php }?> ><?php echo $result['section_desc'];?></option>
            <?php } ?>
            <option value="International Jewellery" <?php if($section=="International Jewellery"){?> selected="selected" <?php }?>>International Jewellery</option>
            <option value="International Loose" <?php if($section=="International Loose"){?> selected="selected" <?php }?>>International Loose</option>
    </select>
    </td>
</tr>

<tr>
		  <td><strong>Select your category :</strong></td>
		  <td><select name="category" id="category"  class="bgcolor">
          <option selected="selected" value="">-----Select Category----</option>
            <?php 
			$sql="SELECT * FROM signature_category_master";
            $query=$conn->query($sql);
            while($result=$query->fetch_assoc()){
            ?>
            <option value="<?php echo $result['category'];?>" <?php if($result['category']==$category){?> selected="selected" <?php }?> ><?php echo $result['category_desc'];?></option>
            <?php }?>
          </select>
          </td>
</tr>

<tr >
	  <td><strong>Select your area : </strong></td>
	  <td> <select name="selected_area" id="selected_area" class="bgcolor" >
            <option selected="selected" value="">-----Select Area----</option>
            <?php 
			/*if($selected_area==9){$sql="SELECT * FROM iijs_area_master where area=9 or area=18 or area=25";}
			else if($selected_area==18){$sql="SELECT * FROM iijs_area_master where area=18 or area=25 or area=27";}
			else if($selected_area==25){$sql="SELECT * FROM iijs_area_master where area=25 or area=25 or area=36";}
			else if($selected_area==27){$sql="SELECT * FROM iijs_area_master where area=27 or area=36 or area=45";}
			else if($selected_area==36){$sql="SELECT * FROM iijs_area_master where area=36 or area=45 or area=54";}
			else if($selected_area==45){$sql="SELECT * FROM iijs_area_master where area=45 or area=54 or area=72";}
			else if($selected_area==54){$sql="SELECT * FROM iijs_area_master where area=54 or area=72 or area=144" ;}
			else if($selected_area>54){$sql="SELECT * FROM iijs_area_master order by area_id desc limit 0,2" ;}*/
			$sql="SELECT * FROM signature_area_master order by area_id asc";
			$query=$conn->query($sql);
			while($result=$query->fetch_assoc()){
            ?>
            <option value="<?php echo $result['area'];?>" <?php if($result['area']==$selected_area){?> selected="selected" <?php }?>><?php echo $result['area'];?></option>
            <?php }?>
          </select>                  
          <input type="hidden" name="lastYearArea" id="lastYearArea" value="<?php echo $selected_area;?>"/></td>
</tr>

	<tr>
	  <td><strong>Select your scheme type :  </strong></td>
	  <td> <select class="bgcolor" id="selected_scheme_type" name="selected_scheme_type">
				<?php 
				$sql="SELECT * FROM signature_scheme_master where status='Y'";
				$query=$conn->query($sql);
				while($result=$query->fetch_assoc()){
				?>
				<option value="<?php echo $result['scheme'];?>" <?php if($result["scheme"]==$selected_scheme_type){echo "selected";} ?> ><?php echo $result['scheme_desc'];?></option>
				<?php }?> 
			 </select>
			 </td>
	</tr>

	<tr>
	  <td><strong>Select your premium type : </strong></td>
	  <td> <select class="bgcolor" name="selected_premium_type" id="selected_premium_type">
            <option value="">-----Select Premium Type----</option>
			<?php 
			$sql="SELECT * FROM signature_premium_master order by premium_id asc";
			$query=$conn->query($sql);
			while($result=$query->fetch_assoc()){
            ?>
            <option value="<?php echo $result['premium'];?>" <?php if($result['premium']==$selected_premium_type){?> selected="selected" <?php }?>><?php echo $result['premium_desc'];?></option>
            <?php }?> 
            </select>
           </td>
	</tr>

	<input type="hidden" name="woman_entrepreneurs" value="0"/>

<tr class="orange1">
    <td colspan="11" >Participation Stall Details</td>
</tr>
<tr>
  <td><strong>Click on calculate button to calculate the figures: </strong></td>
  <td> <input type="button" name="calculate" id="calculate" value="Calculate" class="input_submit" /></td>
</tr>
<tr>
  <td><strong>Space cost rate <?php echo $currency;?> :</strong></td>
  <td><input type="text" class="bgcolor" name="tot_space_cost_rate" id="tot_space_cost_rate" value="<?php echo $tot_space_cost_rate;?>" readonly="readonly" /></td>
</tr>
<tr>
  <td><strong>Discount space cost rate <?php echo $currency;?> :</strong></td>
  <td><input type="text" class="bgcolor" name="tot_space_cost_discount" id="tot_space_cost_discount" value="<?php echo $tot_space_cost_discount;?>" readonly="readonly" /></td>
</tr>
<tr>
  <td><strong>After Discount space cost <?php echo $currency;?> :</strong></td>
  <td><input type="text" class="bgcolor" name="get_tot_space_cost_rate" id="get_tot_space_cost_rate" value="<?php echo $get_tot_space_cost_rate;?>" readonly="readonly" /></td>
</tr>
<tr>
  <td><strong>Category cost <?php echo $currency;?> :</strong></td>
  <td><input type="text" class="bgcolor" name="get_category_rate" id="get_category_rate" value="<?php echo $get_category_rate;?>" readonly="readonly" /></td>
</tr>


<tr>
  <td><strong>Selected Scheme rate <?php echo $currency;?>:</strong></td>
  <td><input type="text" class="bgcolor" name="selected_scheme_rate" id="selected_scheme_rate" readonly="readonly" value="<?php echo $selected_scheme_rate;?>" /></td>
</tr>
<tr>
  <td><strong>Selected premium rate <?php echo $currency;?>:</strong></td>
  <td><input type="text" class="bgcolor" name="selected_premium_rate" id="selected_premium_rate" readonly="readonly" value="<?php echo $selected_premium_rate;?>"/></td>
</tr>
<tr>
  <td><strong>Sub Total cost <?php echo $currency;?>:</strong></td>
  <td><input type="text" class="bgcolor" name="sub_total_cost" id="sub_total_cost" readonly="readonly" value="<?php echo $sub_total_cost;?>" /></td>
</tr>
<tr>
  <td><strong>Security Deposit (10% on<br /> SubTotal Cost) <?php echo $currency;?> :</strong></td>
  <td><input type="text" class="bgcolor" name="security_deposit" id="security_deposit" readonly="readonly" value="<?php echo $security_deposit;?>" /></td>
</tr>  
<tr >
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