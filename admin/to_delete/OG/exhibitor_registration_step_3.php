<?php include('header_include.php');
	if(!isset($_SESSION['USERID'])){
			header("location:login.php");
			exit;
	}
?>
<?php
$registration_id=$_SESSION['USERID'];
$gid = intval($_REQUEST['gid']);
$action=@$_REQUEST['action'];
if($action=="Save")
{
	$exh_id=$_REQUEST['exh_id'];
	$last_yr_participant=mysql_real_escape_string($_REQUEST['last_yr_participant']);
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
	$created_date=date('Y-m-d');
	$show="IIJS 2017";
	if(strtoupper($_SESSION['COUNTRY'])=="INDIA" || strtoupper($_SESSION['COUNTRY'])=="IND")
	  $currency="";
	else
		$currency="USD";
	
	$query=mysql_query("select * from exh_registration where uid='$registration_id' and gid='$gid' and `show`='$show'");
	$num=mysql_num_rows($query);

	if($num>0)
	{
		$sql="update exh_registration set options='$option',woman_entrepreneurs='$woman_entrepreneurs', last_yr_participant='$last_yr_participant',section='$section',category='$category',selected_area='$selected_area',selected_scheme_type='$selected_scheme_type',selected_premium_type='$selected_premium_type',tot_space_cost_rate='$tot_space_cost_rate',mezzanine_space_charges='$mezzanine_space_charges',selected_scheme_rate='$selected_scheme_rate',selected_premium_rate='$selected_premium_rate',sub_total_cost ='$sub_total_cost',security_deposit='$security_deposit',govt_service_tax='$govt_service_tax',grand_total='$grand_total',mcb_charges='$mcb_charges',modified_date='$created_date' where gid='$gid' and uid='$registration_id' and `show`='$show'";
		mysql_query($sql);
		
	}
	else
	{
		$sql="insert into exh_registration set options='$option',uid='$registration_id',gid='$gid',woman_entrepreneurs='$woman_entrepreneurs',last_yr_participant='$last_yr_participant',section='$section',category='$category',selected_area='$selected_area',selected_scheme_type='$selected_scheme_type',selected_premium_type='$selected_premium_type',tot_space_cost_rate='$tot_space_cost_rate',mezzanine_space_charges='$mezzanine_space_charges',selected_scheme_rate='$selected_scheme_rate',selected_premium_rate='$selected_premium_rate',sub_total_cost ='$sub_total_cost',security_deposit='$security_deposit',govt_service_tax='$govt_service_tax',grand_total='$grand_total',mcb_charges='$mcb_charges',created_date='$created_date',`show`='$show'";
		mysql_query($sql);
	}
		
header('location:exhibitor_registration_step_4.php?gid='.$gid."&exh_id=".$exh_id);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>IIJS - Exhibitor Registration - Participation Stall Details</title>

<link rel="shortcut icon" href="images/fav.png" />

<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Cabin'>

<link rel="stylesheet" type="text/css" href="css/general.css" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css" />

   
<link rel="stylesheet" type="text/css" href="css/responsive.css" />
<link rel="stylesheet" type="text/css" href="css/media_query.css" />
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>

<!--NAV-->
<link href="css/flexnav.css" media="screen, projection" rel="stylesheet" type="text/css">
<script src="js/jquery.flexnav.js" type="text/javascript"></script>
<script src="js/common.js"></script> 
<!--NAV-->



<!-- UItoTop plugin -->
<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css" />
<script src="js/easing.js" type="text/javascript"></script>
<script src="js/jquery.ui.totop.js" type="text/javascript"></script>    
<script type="text/javascript">
    $(document).ready(function() {        
        $().UItoTop({ easingType: 'easeOutQuart' });     
    });
</script>
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
					url: 'ajax.php',
					data: "actiontype=calculatePayment&&section="+section+"&&selected_area="+selected_area+"&&selected_scheme_type="+selected_scheme_type+"&&selected_premium_type="+selected_premium_type+"&&woman_entrepreneurs="+woman_entrepreneurs+"&&category="+category,
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
							}
		});
 });
 
 if($("input[name=woman_entrepreneurs]:checked").val()=="1")
	{
		$("#women_desc").css("display","block");
		//$("#chequeordd").css("display","none");
	}
	else
	{
		$("#women_desc").css("display","none");
		//$("#chequeordd").css("display","block");
	}
	
 $("input:radio[name=woman_entrepreneurs]").click(function(){
		var value = $(this).val();
		//alert(value);
		
		if(value == "1")
		{
			$("#women_desc").css("display","block");
			//$("#chequeordd").css("display","none");
		}
		else
		{
			$("#women_desc").css("display","none");
			//$("#chequeordd").css("display","block");
		}
	});
});
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
  /*$("#option").live('change',function(){
	  option=$('input[name=option]:checked').val();
	  //alert(option);
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
 });*/
</script>
<script>
/*$("#section").live('change',function(){
var section=$("#section").val();
if(section=="plain_gold")
{
	if($("#selected_area").is(":contains('12')"))
	{
		$("#selected_area option[value='24']").remove();
	}else
	{
			if($("#selected_area").is(":contains('9')"))
		{
			$("#selected_area").append("<option value='12'>12</option>");
		}
	}
}else if(section=="allied")
{
	if($("#selected_area").is(":contains('12')"))
	{
	$("#selected_area").append("<option value='24'>24</option>");
	}else
	{
		$("#selected_area").append("<option value='12'>12</option>");
	}
	
}else
{
	$("#selected_area option[value='12']").remove();
	$("#selected_area option[value='24']").remove();
}



});
*/</script>
<script>

  /*$("#section").live('change',function(){
	section=$('#section').val();
    $.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=getCategory&&section="+section,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
					//alert(data);
					$('#category').html(data);
					}
		});
 }); */
</script>
<script>
/*  $("#category").live('change',function(){
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
 });*/
 $("#selected_area").live('change',function(){
	selected_area=$('#selected_area').val();
    $.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=getSchemeType&&selected_area="+selected_area,
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
<script>
  $("#option").live('change',function(){
	  option=$('input[name=option]:checked').val();
	  if($('#section_hid').val()!='')
	  		var section=$('#section_hid').val();
	  else
	  		var section=$("#section").val();
				  
	  if(option=="Same stall")
	  {
	  	$("#section").attr("disabled", "disabled");
		$("#selected_area").attr("disabled", "disabled");
		$("#category").attr("disabled", "disabled");
		$("#selected_premium_type").attr("disabled", "disabled");
		$("#selected_scheme_type").removeAttr("disabled");
		
		$("#section_hid").removeAttr("disabled");
		$("#selected_area_hid").removeAttr("disabled");
		$("#category_hid").removeAttr("disabled");
		$("#selected_premium_type_hid").removeAttr("disabled");
		$("#selected_scheme_type_hid").attr("disabled", "disabled");
		var selected_area=$("#selected_area_hid").val();
		if(selected_area==9 || selected_area==12)
			$("#selected_scheme_type").html("<option value='RW'>Raw Space</option><option value='BI1'>Shell Scheme Ae</option>");	
		
	  }
	  else if(option=="Same area but different location as of previous year IIJS 2016")
	  {
	  	if($('#section_hid').val()=='couture' || $('#section_hid').val()=='mass_produced')
		{
	  		$("#section").removeAttr("disabled");
			$("#section_hid").attr("disabled", "disabled");
		}
	  	else
		{
	  		$("#section").attr("disabled", "disabled");
			$("#section_hid").removeAttr("disabled");
		}
		$("#category").attr("disabled", "disabled");
		$("#selected_premium_type").removeAttr("disabled"); 
		$("#selected_scheme_type").removeAttr("disabled");
		$("#selected_area").attr("disabled", "disabled");
		
		$("#selected_area_hid").removeAttr("disabled");
		$("#category_hid").removeAttr("disabled");
		
		$("#selected_scheme_type_hid").attr("disabled", "disabled");
		$("#selected_premium_type_hid").attr("disabled", "disabled");
		var selected_area=$("#selected_area_hid").val();
		if(selected_area==9 || selected_area==12)
			$("#selected_scheme_type").html("<option value='RW'>Raw Space</option><option value='BI1'>Shell Scheme Ae</option>");
	  }
	  else if(option=="More area than previous year IIJS")
	  {
	  	if($('#section_hid').val()=='couture' || $('#section_hid').val()=='mass_produced')
		{
	  		$("#section").removeAttr("disabled");
			$("#section_hid").attr("disabled", "disabled");
		}
	  	else
		{
	  		$("#section").attr("disabled", "disabled");
			$("#section_hid").removeAttr("disabled");
		}
		$("#category").attr("disabled", "disabled");
		$("#selected_area").removeAttr("disabled");
		$("#selected_scheme_type").removeAttr("disabled");
		$("#selected_premium_type").removeAttr("disabled");
		
		$("#category_hid").removeAttr("disabled");
		$("#selected_area_hid").attr("disabled", "disabled");
		$("#selected_scheme_type_hid").attr("disabled", "disabled");
		$("#selected_premium_type_hid").attr("disabled", "disabled");
	 }
	  else if(option=="Less area as previous year at diffrent location")
	  {
	  	if($('#section_hid').val()=='couture' || $('#section_hid').val()=='mass_produced')
		{
	  		$("#section").removeAttr("disabled");
			$("#section_hid").attr("disabled", "disabled");
		}
	  	else
		{
	  		$("#section").attr("disabled", "disabled");
			$("#section_hid").removeAttr("disabled");
		}
		$("#category").attr("disabled", "disabled");
		$("#selected_area").removeAttr("disabled");
		$("#selected_scheme_type").removeAttr("disabled");
		$("#selected_premium_type").removeAttr("disabled");
		
		$("#category_hid").removeAttr("disabled");
		$("#selected_area_hid").attr("disabled", "disabled");
		$("#selected_scheme_type_hid").attr("disabled", "disabled");
		$("#selected_premium_type_hid").attr("disabled", "disabled");
		var selected_area=$("#selected_area_hid").val();
		if(selected_area=='9')
			$("#selected_scheme_type").html("<option value='RW'>Raw Space</option><option value='BI1'>Shell Scheme Ae</option>");
	  }
	  else if(option=="Less area as previous year")
	  {
		$("#section").attr("disabled", "disabled");
		$("#category").attr("disabled", "disabled");
		$("#selected_area").removeAttr("disabled");
		$("#selected_scheme_type").removeAttr("disabled");
		$("#selected_premium_type").removeAttr("disabled");
		
		$("#section_hid").removeAttr("disabled");
		$("#category_hid").removeAttr("disabled");
		$("#selected_area_hid").attr("disabled", "disabled");
		$("#selected_scheme_type_hid").attr("disabled", "disabled");
		$("#selected_premium_type_hid").attr("disabled", "disabled");
	  }
	  
	  lastYearArea=$('#lastYearArea').val();
	  $("#im_registration_no").attr("disabled", "disabled");
	   
	  
	 
	 $.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=optionValue&&option="+option+"&&lastYearArea="+lastYearArea+"&&section="+section,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
						var res = data.split("#");
						if($.trim(res[0])!=""){
							$('#section').html(res[0]);
						}
						if($.trim(res[1])!=""){
							$('#selected_area').html(res[1]);
						}
					}
		});	
 });
</script>

</head>
<body>
<div class="wrapper">
<div class="header">
	<?php include('header1.php'); ?>
</div>

<div class="new_banner">
<img src="images/banners/banner.jpg" />
</div>

<div class="inner_container">

	<div class="breadcrum"><a href="index.php">Home</a> > Exhibitor Registration - Participation Stall Details</div>    
    <div class="clear"></div>
    
    <div class="content_area">
      <div class="pg_title">
        <div class="title_cont"> <span class="top">Exhibitor <img src="images/titles/joint.png" style="position:absolute; top:31px; right:0px;" /></span> <span class="below">Registration</span>
          <div class="clear"></div>
        </div>
      </div>
      <div class="clear"></div>
    <form action="" method="post" name="form1" id="form1">
    <div class="form_main">
    <div class="form_title" style="float:left;">Step 3 : PARTICIPATION STALL DETAILS</div><div style="float:right; font-size:13px; font-weight:bold; "><!--<a href="Shell Scheme Package.pdf" style="color:#8873bd;" target="_blank">--><a href="http://iijs.org/images/1.png" target="_blank" style="color:#8873bd;cursor:pointer" >Shell Scheme Description (Click here)</a></div>
    
    <div class="clear"></div>
    <?php 
	/*...........................Last year participant  ..........................*/
	$query1=mysql_query("select * from exh_registration where uid='$registration_id' and `show`='IIJS 2016' and last_yr_section_flag='1' and  curr_last_yr_check='N' order by exh_id desc limit 0,1");
	$result1=mysql_fetch_array($query1);
	$exh_id=$result1['exh_id'];
	 $retain_restrict=$result1['retain_restrict'];
	 $num1=mysql_num_rows($query1);
	//echo $_SESSION['COUNTRY'];
	$query=mysql_query("select * from exh_registration where uid='$registration_id' and gid='$gid' and `show`='IIJS 2017'");
	$result=mysql_fetch_array($query);
	$num=mysql_num_rows($query);
	if($num>0)
	{
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
        <div class="field_box">
            <div class="field_name">Last year participant :</div>
            <div class="field_input" style="padding-top:5px;">
            <div class="chkbox" style="width:100px;">
              <span class="chkbox" style="width:100px;">
              <?php if($num1>0){ echo $last_yr="Yes"; ?>
              
              <?php } else {echo $last_yr="No";}?>
              </span>
              <input type="hidden" name="last_yr_participant" id="last_yr_participant" value="<?php echo $last_yr;?>"/>
             </div>
            </div>
            <div class="clear"></div>
        </div>
        <?php  if($num1>0){?>
        
        <div class="field_box">
            <div class="field_name">Last year details :</div>
            <div class="field_input" style="padding-top:5px; line-height:25px;">
            <strong>Section :</strong><?php echo strtoupper($section);?><br />
            <strong>Area :</strong> <?php echo strtoupper($selected_area);?> <br />
            <strong>Scheme type :</strong> <?php echo $selected_scheme_type?> <br />
            <strong>Premium type :</strong> <?php echo strtoupper($selected_premium_type);?>           
            </div>
            <div class="clear"></div>
        </div>
        <?php } ?>
       <div class="field_box">
        <div class="field_name">Please select any of the <br />option <span>*</span> :</div>
        <div class="field_input" style="padding-top:5px; line-height:25px;">
        <input type="hidden" name="exh_id" id="exh_id" value="<?php echo $exh_id?>"/>
        <?php if($num1==0){?>
        <input type="radio" id="option" class="bgcolor" name="option"  checked="checked" value="New participant" /> <label for="b_1">New participant</label><br />
        <?php } else {?>
        <input type="radio" id="option" class="bgcolor" name="option" value="Same stall" <?php if($option=="Same stall"){?> checked="checked" <?php } ?> /> Same stall position size as of previous year<br/>
        <input type="radio" id="option" class="bgcolor" name="option" value="Same area but different location as of previous year IIJS 2016" <?php if($option=="Same area but different location as of previous year IIJS 2016"){?> checked="checked" <?php } ?> /> 
        Same area but different location as of previous year IIJS 2016<br/>   
         <?php if($selected_area<54 &&  $section!='machinery'){?>
        <input type="radio" id="option" class="bgcolor" name="option" value="More area than previous year IIJS" <?php if($option=="More area than previous year IIJS"){?> checked="checked" <?php } ?> /> 
        More area than previous year IIJS 2016<br/>
        <?php }?>
       <?php if($selected_area>9){?>
        <input type="radio" id="option" class="bgcolor" name="option" value="Less area as previous year at diffrent location" <?php if($option=="Less area as previous year at diffrent location"){?> checked="checked" <?php } ?> /> Less area as previous year at diffrent location<br/>
         <input type="radio" id="option" class="bgcolor" name="option" value="Less area as previous year" <?php if($option=="Less area as previous year"){?> checked="checked" <?php } ?> /> Less area as previous year at same location
         <?php }}?>
        </div>
        
        <div class="clear"></div>
        </div>
       <!-- <input type="radio" id="option" class="bgcolor" name="option" value="Same stall" checked="checked" /> <label for="b_2">Same stall position size as of previous year</label><br />-->
       
        

        <div class="field_box">
        <div class="field_name">Select your section <span>*</span>:</div>
        <div class="field_input">
          <select name="section" id="section"  class="bgcolor" <?php if($section!="" && ($_SESSION['COUNTRY']=="INDIA" || $_SESSION['COUNTRY']=="IND")){?> disabled="disabled" <?php }?>>
          <option selected="selected" value="">-----Select Section----</option>
            <?php 
			if($_SESSION['COUNTRY']=="INDIA" || $_SESSION['COUNTRY']=="IND")
			{
			if($last_yr=='Yes' && $_SESSION['member_type']=='MEMBER')
					$sql="SELECT * FROM iijs_section_master where last_yr='No'";
				else if($last_yr=='No' && $_SESSION['member_type'] !='NON_MEMBER')
					 $sql="SELECT * FROM iijs_section_master where 1 and status='Y'";
				else
					$sql="SELECT * FROM iijs_section_master where member_type ='NON_MEMBER' and status='Y'";
	
            $query=mysql_query($sql);
            while($result=mysql_fetch_array($query)){
            ?>
            <option value="<?php echo $result['section'];?>" <?php if($result['section']==$section){?> selected="selected" <?php }?> ><?php echo $result['section_desc'];?></option>
            <?php } } else {?>
            <option value="International Jewellery" <?php if($section=="International Jewellery"){?> selected="selected" <?php }?>>International Jewellery</option>
            <option value="International Loose" <?php if($section=="International Loose"){?> selected="selected" <?php }?>>International Loose</option>
            <option value="machinery" <?php if($section=="machinery"){?> selected="selected" <?php }?>>Machinery</option>
            <option value="Allied" <?php if($section=="Allied"){?> selected="selected" <?php }?>>Allied</option>
            
            <?php }?>
          </select>
          <?php if($section!="" && ($_SESSION['COUNTRY']=="INDIA" || $_SESSION['COUNTRY']=="IND")){?><input type="hidden" name="section" id="section_hid" value="<?php echo $section;?>"/><?php }?>
          
        </div>
        <div class="clear"></div>
        </div>
        
        <div class="field_box">
        <div class="field_name">Select your category <span>*</span>:</div>
        <div class="field_input">
          <select name="category" id="category"  class="bgcolor" <?php if($category!=""){?> disabled="disabled"<?php }?>>
          <option selected="selected" value="">-----Select Category----</option>
            <?php 
			$sql="SELECT * FROM iijs_category_master where category='normal'";
            $query=mysql_query($sql);
            while($result=mysql_fetch_array($query)){
            ?>
            <option value="<?php echo $result['category'];?>" <?php if($result['category']==$category){?> selected="selected" <?php }?> ><?php echo $result['category_desc'];?></option>
            <?php }?>
          </select>
          <?php if($category!=""){?><input type="hidden" name="category" id="category_hid" value="<?php echo $category;?>"/><?php }?>
        </div>
        <div class="clear"></div>
        </div>
        
        <div class="field_box">
        <div class="field_name">Select your area <span>*</span>:</div>
        <div class="field_input"> 
          <select name="selected_area" id="selected_area" class="bgcolor" <?php if($selected_area!=""){?> disabled="disabled"<?php }?>>
            <option selected="selected" value="">-----Select Area----</option>
            <?php 
			if($selected_area==9){$sql="SELECT * FROM iijs_area_master where area=9 or area=18 or area=25";}
			else if($selected_area==12){$sql="SELECT * FROM iijs_area_master where area=12";}
			else if($selected_area==16){$sql="SELECT * FROM iijs_area_master where area=16";}
			else if($selected_area==18){$sql="SELECT * FROM iijs_area_master where area=18 or area=25 or area=27";}
			else if($selected_area==25){$sql="SELECT * FROM iijs_area_master where area=25 or area=25 or area=36";}
			else if($selected_area==27){$sql="SELECT * FROM iijs_area_master where area=27 or area=36 or area=45";}
			else if($selected_area==28){$sql="SELECT * FROM iijs_area_master where area=28";}
			else if($selected_area==36){$sql="SELECT * FROM iijs_area_master where area=36 or area=45 or area=54";}
			else if($selected_area==45){$sql="SELECT * FROM iijs_area_master where area=45 or area=54 or area=72";}
			else if($selected_area==54){$sql="SELECT * FROM iijs_area_master where area=54 or area=72 or area=144" ;}
			else if($selected_area>54){$sql="SELECT * FROM iijs_area_master where area>54";}
			else {$sql="SELECT * FROM iijs_area_master order by area_id asc limit 0,1" ;}
				$query=mysql_query($sql);
				while($result=mysql_fetch_array($query)){
            ?>
            <option value="<?php echo $result['area'];?>" <?php if($result['area']==$selected_area){?> selected="selected" <?php }?>><?php echo $result['area'];?></option>
            <?php }?>
          </select>
           <?php if($selected_area!=""){?><input type="hidden" name="selected_area" id="selected_area_hid" value="<?php echo $selected_area;?>"/><?php }?>
          
          <input type="hidden" name="lastYearArea" id="lastYearArea" value="<?php echo $selected_area;?>"/>
        </div>
        <div class="clear"></div>
        </div>
        <?php if($section!='machinery'){?>
        <div class="field_box">
        <div class="field_name">Select your scheme type <span>*</span>:</div>
        <div class="field_input">
        <select class="bgcolor" id="selected_scheme_type" name="selected_scheme_type">
        <option selected="selected" value="">-----Select Scheme Type----</option>
			<?php 
			    $sql="SELECT * FROM iijs_scheme_master where status='Y'";
				$query=mysql_query($sql);
				while($result=mysql_fetch_array($query)){
            ?>
            <option value="<?php echo $result['scheme'];?>" <?php if($selected_scheme_type==$result['scheme']){ echo "selected=selected"; }?> ><?php echo $result['scheme_desc'];?></option>
            <?php }?> 
         </select>
         <?php if($selected_scheme_type!=""){?>
         <input type="hidden" name="selected_scheme_type" id="selected_scheme_type_hid" value="<?php echo $selected_scheme_type;?>" disabled="disabled"/>
		 <?php }?>
        </div>
        <div class="clear"></div>
        </div>
        <?php } else {?>
        <input type="hidden" name="selected_scheme_type" id="selected_scheme_type" value="0"/>
        <?php }?>
        <div class="field_box">
        <div class="field_name">Select your premium type <span>*</span>:</div>
        <div class="field_input">
            <select class="bgcolor" name="selected_premium_type" id="selected_premium_type" <?php if($selected_premium_type!=""){?> disabled="disabled"<?php }?>>
            <option selected="selected" value="">-----Select Premium Type----</option>
			<?php 
				$sql="SELECT * FROM iijs_premium_master order by premium_id asc";
				$query=mysql_query($sql);
				while($result=mysql_fetch_array($query)){
            ?>
            <option value="<?php echo $result['premium'];?>" <?php if($result['premium']==$selected_premium_type){?> selected="selected" <?php }?>><?php echo $result['premium_desc'];?></option>
            <?php }?> 
            </select>
            <?php if($selected_premium_type!=""){?><input type="hidden" name="selected_premium_type" id="selected_premium_type_hid" value="<?php echo $selected_premium_type;?>"/><?php }?>
        </div>
        <div class="clear"></div>
        </div>
         <?php if($_SESSION['member_type']=="MEMBER"){?>
        <div class="field_box">
        <div class="field_name">Woman Entrepreneurs :</div>
        <div class="field_input" style="padding-top:5px;">
        <div class="chkbox" style="width:100px;"><input type="radio" id="woman_entrepreneurs" name="woman_entrepreneurs" class="bgcolor" value="1" <?php if($woman_entrepreneurs==1){?> checked="checked"<?php }?> /> <label for="c_1">Yes</label></div>
        <div class="chkbox" style="width:100px;"><input type="radio" id="woman_entrepreneurs" name="woman_entrepreneurs" class="bgcolor" value="0" <?php if($woman_entrepreneurs==0){?> checked="checked"<?php }?> /> <label for="c_2">No</label></div>
                    
        </div>
        <div class="clear"></div>
        <div id="women_desc" style="margin-bottom:10px;font-size:12px;">
        <p><strong>As a special policy to promote and encourage Woman Entrepreneurs in the Industry, a special discount of 25% on the basic space rental (without the Construction cost for shell scheme) will be offered to any firm which is having the following characteristics:</strong> </p>
		   I. If the firm is a proprietorship / partnership concern (all women); and<br/>
		  II. Member of GJEPC for at least two years; and<br/>
		  III. Constitution of the firm in terms of partners / proprietors has not changed for those two years.<br/>
		  IV. The above scheme is open to participation by Indian firm only<br/>
		</div>
        </div>
        <?php } else {?>
        <input type="hidden" name="woman_entrepreneurs" id="woman_entrepreneurs" value="0"/>
        <?php }?>
        <div class="field_box">
        <div class="field_name"><strong style="color:#000; font-size:14px;">Application Summary :</strong><br />
        <span class="clear" style="height:1px; background:#ccc; display:block; margin-top:5px;"></span></div> 
        <div class="clear"></div>
        </div>
        
        <div class="field_box">
        <span style="display:inline-block; float:left; margin-right:10px; margin-top:10px;">Click on calculate button to calculate the figures</span>
        <input type="button" name="calculate" id="calculate" value="Calculate" class="button" />
        <!--<a href="#" class="button">Calculate</a>-->
        <div class="clear"></div>
        </div>
                
        <div class="clear"></div>
                
        
        <div class="field_box">
        <div class="field_name">Total space cost rate <?php echo $currency;?> :</div>
        <div class="field_input"><input type="text" class="bgcolor" name="tot_space_cost_rate" id="tot_space_cost_rate"  value="<?php echo $tot_space_cost_rate;?>" readonly="readonly" /></div>
        <div class="clear"></div>
        </div>
          
        <div class="field_box">
        <div class="field_name">Mezzanine Space Charges <?php echo $currency;?> :</div>
        <div class="field_input"><input type="text" class="bgcolor" name="mezzanine_space_charges" id="mezzanine_space_charges"  value="<?php echo $mezzanine_space_charges;?>" readonly="readonly" /></div>
        <div class="clear"></div>
        </div>    
        
        <div class="field_box">
        <div class="field_name">Selected scheme rate <?php echo $currency;?>:</div>
        <div class="field_input"><input type="text" class="bgcolor" name="selected_scheme_rate" id="selected_scheme_rate" readonly="readonly" value="<?php echo $selected_scheme_rate;?>" /></div>
        <div class="clear"></div>
        </div>
                
        
        <div class="field_box">
        <div class="field_name">Selected premium rate <?php echo $currency;?>:</div>
        <div class="field_input"><input type="text" class="bgcolor" name="selected_premium_rate" id="selected_premium_rate" readonly="readonly" value="<?php echo $selected_premium_rate;?>"/></div>
        <div class="clear"></div>
        </div>
                
        
        <div class="field_box">
        <div class="field_name">Sub Total cost <?php echo $currency;?>:</div>
        <div class="field_input"><input type="text" class="bgcolor" name="sub_total_cost" id="sub_total_cost" readonly="readonly" value="<?php echo $sub_total_cost;?>" /></div>
        <div class="clear"></div>
        </div>
                
        
        <div class="field_box">
        <div class="field_name">Security Deposit (10% on<br /> SubTotal Cost) <?php echo $currency;?> :</div>
        <div class="field_input"><input type="text" class="bgcolor" name="security_deposit" id="security_deposit" readonly="readonly" value="<?php echo $security_deposit;?>" /></div>
        <div class="clear"></div>
        </div>
                
        
        <div class="field_box">
        <div class="field_name">Govt. Service Tax (15% on SubTotal Cost) <?php echo $currency;?> :</div>
        <div class="field_input"><input type="text" class="bgcolor" id="govt_service_tax" name="govt_service_tax" readonly="readonly" value="<?php echo $govt_service_tax;?>" /></div>
        <div class="clear"></div>
        </div>
                
        
        <div class="field_box">
        <div class="field_name"><strong>Grand Total </strong><?php echo $currency;?> :</div>
        <div class="field_input"><input type="text" class="bgcolor" id="grand_total" name="grand_total" readonly="readonly" value="<?php echo $grand_total;?>" /></div>
        <div class="clear"></div>
        </div>
    
        
        <div class="field_box">
        <div class="field_name"><strong>MCB Charges</strong><?php echo $currency;?> :</div>
        <div class="field_input"><input type="text" class="bgcolor" id="mcb_charges" name="mcb_charges" readonly="readonly" value="<?php echo $mcb_charges;?>" /></div>
        <div class="clear"></div>
        </div>
    	<span style="color:#FF0000;font-size:16px">*&nbsp;Kindly issue different cheque towards MCB charges. </span>
        
        <div class="clear" style="height:10px;"></div>       
    
        <div class="field_box">
        <div class="field_name"></div>
        <div class="field_input">
        <input type="hidden" name="action" value="Save" />
        <input type="submit" class="button" value="Proceed to next step" />
        </div>
        <div class="clear"></div>
        </div>
	
	  
    <div class="clear"></div>
	</div>
	   </form>
    <div class="clear"></div>
	</div>

	<div class="right_area">
    
    <?php include('include_account_links.php'); ?>
    
    <div class="clear"></div>
    </div>
 

<div class="clear" style="height:10px;"></div>
</div>

<div class="footer">
	<?php include('footer.php'); ?>
<div class="clear"></div>
</div>

<div class="clear"></div>
</div>

</body>
</html>
