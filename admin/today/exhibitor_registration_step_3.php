<?php include('header_include.php');?>
<?php
if(!isset($_SESSION['USERID']))
{
	header("location:login.php");
	exit;
}
?>

<?php
$gcode=getGcode($_SESSION['USERID']);
$show="IIJS Signature 2019";
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
	
	$security_deposit=mysql_real_escape_string($_REQUEST['security_deposit']);
	$country=mysql_real_escape_string($_REQUEST['country']);
	$govt_service_tax=$_REQUEST['govt_service_tax'];
	$grand_total=$_REQUEST['grand_total'];	
	$created_date=date('Y-m-d');
	if(strtoupper($_SESSION['COUNTRY'])=="INDIA" || strtoupper($_SESSION['COUNTRY'])=="IND" || strtoupper($_SESSION['COUNTRY'])=="IN")
	{
	  $currency="";
	}
	else
	{
		$currency="USD";
	}
	
	$query=mysql_query("select * from exh_registration where uid='$registration_id' and gid='$gid' and `show`='$show'");
	$num=mysql_num_rows($query);

	if($num>0)
	{
		 $sql="update exh_registration set options='$option',roi='YES',woman_entrepreneurs='$woman_entrepreneurs', last_yr_participant='$last_yr_participant',section='$section',category='$category',selected_area='$selected_area',selected_scheme_type='$selected_scheme_type',selected_premium_type='$selected_premium_type',tot_space_cost_rate='$tot_space_cost_rate',selected_scheme_rate='$selected_scheme_rate',selected_premium_rate='$selected_premium_rate',sub_total_cost ='$sub_total_cost',security_deposit='$security_deposit',govt_service_tax='$govt_service_tax',grand_total='$grand_total',modified_date='$created_date' where gid='$gid' and uid='$registration_id' and `show`='$show'";
		mysql_query($sql);
		
	}
	else
	{
		$sql="insert into exh_registration set options='$option',roi='YES',uid='$registration_id',gid='$gid',woman_entrepreneurs='$woman_entrepreneurs',last_yr_participant='$last_yr_participant',section='$section',category='$category',selected_area='$selected_area',selected_scheme_type='$selected_scheme_type',selected_premium_type='$selected_premium_type',tot_space_cost_rate='$tot_space_cost_rate',selected_scheme_rate='$selected_scheme_rate',selected_premium_rate='$selected_premium_rate',sub_total_cost ='$sub_total_cost',security_deposit='$security_deposit',govt_service_tax='$govt_service_tax',grand_total='$grand_total',created_date='$created_date',`show`='$show'";
		mysql_query($sql);
	}
		
header('location:exhibitor_registration_step_4.php?gid='.$gid."&exh_id=".$exh_id);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to SIGNATURE</title>

<link rel="stylesheet" type="text/css" href="css/mystyle.css" />

<!--navigation script-->
<script type="text/javascript" src="js/jquery_002.js"></script>
<!--<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>    -->  

<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />

<script type="text/javascript" src="js/ddsmoothmenu.js">
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

<!--navigation script end-->
<!-- small slider -->
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>

<!-- SLIDER -->
	<script type="text/javascript">
	/*$(document).ready(function(){ 
	
	$('#imgSlider').cycle({ 
			fx:    'scrollHorz', 
			timeout: 6000, 
			delay: -1000,
			prev:'.prev1',
			next:'.next1', 
		});
	});*/
	</script>
<!--  SLIDER Starts  -->

<link href="css/slider.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
/*$(function() {
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
});*/
</script>

<!--  SLIDER Ends  -->
<?php 
$gid=intval($_REQUEST['gid']);
$query=mysql_query("select * from exh_reg_payment_details where gid='$gid'");
$final_enty_num=mysql_num_rows($query);
?>

<script>
$(document).ready(function(){
<?php if($final_enty_num==0){?>
/*$("#section").removeAttr("disabled"); 
$("#category").removeAttr("disabled");
$("#selected_area").removeAttr("disabled"); 
$("#selected_premium_type").removeAttr("disabled");*/
<?php }?>

  $("#calculate").click(function(){
  selected_area=$("#selected_area").val();
  section=$("#section").val();
  category=$('#category').val();
  selected_premium_type=$("#selected_premium_type").val();
  country=$("#country").val();
  woman_entrepreneurs=$('[name=woman_entrepreneurs]:checked').val();
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=calculatePayment&&selected_area="+selected_area+"&&section="+section+"&&selected_premium_type="+selected_premium_type+"&&woman_entrepreneurs="+woman_entrepreneurs+"&&category="+category,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							    //alert(data);return false;
								var data=data.split("#");
								$('#tot_space_cost_rate').val(data[0]);
								$('#selected_scheme_rate').val(data[1]);
								$('#selected_premium_rate').val(data[2]); 
								$('#sub_total_cost').val(data[3]);
								$('#security_deposit').val(data[4]);
								$('#govt_service_tax').val(data[5]);
								$('#grand_total').val(data[6]);
							}
		});
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
			category: {
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
			category:{
				required: "Please select category",
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
	  selected_area=$("#selected_area_hid").val();
	  option=$("input[name='option']:checked").val();
	  $('#tot_space_cost_rate').val('');
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

<script>
  $("#option").live('change',function(){
	  option=$('input[name=option]:checked').val();
	  section=$('#section_hid').val();
	
	  if(option=="Same stall position size as of previous year")
	  {
	  	$("#section").attr("disabled", "disabled");
		$("#selected_area").attr("disabled", "disabled");
		$("#category").attr("disabled", "disabled");
		$("#selected_premium_type").attr("disabled", "disabled");
		
		$("#section_hid").removeAttr("disabled");
		$("#selected_area_hid").removeAttr("disabled");
		$("#category_hid").removeAttr("disabled");
		$("#selected_premium_type_hid").removeAttr("disabled");

		$("#section").val($("#section_hid").val());
		$("#selected_area").val($("#selected_area_hid").val());
		$("#category").val($("#category_hid").val());
		$("#selected_premium_type").val($("#selected_premium_type_hid").val());
	  }
	  else if(option=="Same area but different location as of previous year Signature")
	  {
		$("#section").removeAttr("disabled");
		$("#category").removeAttr("disabled");
		$("#selected_premium_type").removeAttr("disabled");
		
		$("#selected_area").attr("disabled", "disabled"); 
		$("#section_hid").attr("disabled", "disabled");
		$("#category_hid").attr("disabled", "disabled");
		$("#selected_premium_type_hid").attr("disabled", "disabled");
	  }
	  else if(option=="More area than previous year Signature")
	  {
		$("#section").removeAttr("disabled");
		$("#selected_area").removeAttr("disabled");
		$("#category").removeAttr("disabled");
		$("#selected_premium_type").removeAttr("disabled"); 
		
		$("#selected_area_hid").attr("disabled", "disabled");
		$("#category_hid").attr("disabled", "disabled");
		$("#selected_premium_type_hid").attr("disabled", "disabled");
		$("#section_hid").attr("disabled", "disabled");
	 }
	  else if(option=="Less area as previous year")
	  {
		$("#section").removeAttr("disabled");
		$("#selected_area").removeAttr("disabled");
		$("#category").removeAttr("disabled");
		$("#selected_premium_type").removeAttr("disabled"); 
		
		
		$("#section_hid").attr("disabled", "disabled");
		$("#selected_area_hid").attr("disabled", "disabled");
		$("#category_hid").attr("disabled", "disabled");
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
<!-- header starts -->

<div class="header_wrap">
	<?php include ('header.php'); ?>
</div>

<!-- header ends -->

<div class="clear"></div>

<!--banner starts-->
<!--<div class="banner_inner_wrap">
	<div class="banner_inner">
    	<img src="images/highlight_banner.jpg" />
    </div>
</div>-->
<!--banner ends-->

<div class="clear"></div>
<!--container starts-->
<div class="container_wrap">
	<div class="container">
    	<div class="container_left">
        	<span class="headtxt">Exhibitor Registration</span>
<div id="loginForm">

<div id="formContainer">  <span style="color:red;font-weight:bold">Kindly Note No Changes will be accepted after Submitting the form</span>
<div class="clear bottomSpace"></div>
    <div class="title">
        <h4>Step 3 : PARTICIPATION STALL DETAILS</h4>
    </div>
	<div class="clear"></div>
	<div class="borderBottom"></div>
	 <table border="1" cellspacing="0" cellpadding="5" style="margin-bottom:10px;" width="100%">
			<thead>
				<th align="center">Type</th>
				<th align="center">Built-in Space Cost Per Sqmt. (Rs.)</th>
			</thead>
			<tbody>
				<tr>
				<td align="center">Loose Stones / Synthetics</td>
				<td align="center">Rs. 21450</td>
				</tr>
				<tr>
				<td align="center">Studded Jewellery / Gold Jewellery</td>
				<td align="center">Rs. 22650</td>
				</tr>
				<tr>
				<td align="center">Signature Club</td>
				<td align="center">Rs. 30500</td>
				</tr>
				<tr>
				<td align="center">International</td>
				<td align="center">US$ 450</td>
				</tr>
				<tr>
				<td align="center">Refundable Security Deposit</td>
				<td align="center">10%</td>
				</tr>
				<tr>
				<td align="center">GST</td>
				<td align="center">18%</td>
				</tr>
			</tbody>
		 </table>
 <form class="cmxform" method="post" name="from1" id="form1">
 <div id="form">
 <?php 

	/*...........................Last year participant  ..........................*/
	//echo "select * from exh_registration where uid='$registration_id' and `show`='IIJS Signature 2017' and last_yr_section_flag='1' and  curr_last_yr_check='N' order by exh_id desc limit 0,1";
	
	$query1=mysql_query("select * from exh_registration where uid='$registration_id' and `show`='IIJS Signature 2018' and last_yr_section_flag='1' and curr_last_yr_check='N' order by exh_id desc limit 0,1");
	$result1=mysql_fetch_array($query1);
	$exh_id=$result1['exh_id'];
	$num1=mysql_num_rows($query1);
	
	//echo "select * from exh_registration where uid='$registration_id' and gid='$gid' and `show`='$show'";
	$query=mysql_query("select * from exh_registration where uid='$registration_id' and gid='$gid' and `show`='$show'");
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
		$category=$result1['category'];
    }
	
	if($option=="Same stall position size as of previous year")
	{
		$option_value=1;
	}
	elseif($option=="Same area but different location as of previous year Signature")
	{
		$option_value=2;
	}
	elseif($option=="More area than previous year Signature")
	{
		$option_value=3;
	}
	elseif($option=="Less area as previous year")
	{
		$option_value=4;
	}	
	?>
	<div class="field">
		<span style="font-size:14px;"><!--ROI SUBMITTED :--> <?php /*if($result1['roi']=='YES')echo "YES";else echo 'NO'; */?><?php /*if($num1>0){ echo $roi="YES"; ?>  
			<?php } else {echo $roi="YES";}*/?>
			
			<br/>LAST YEAR PARTICIPANT :
			<?php if($result1['last_yr_participant']=='YES'){ echo $last_yr="YES"; ?>  
			<?php } else {echo $last_yr="NO";}?>
			<input type="hidden" name="last_yr_participant" id="last_yr_participant" value="<?php echo $last_yr;?>"/>
		 </span>
		<div class="clear"></div>
     </div>
	 <?php  if($num1>0){?>
        
        <div class="field_box">
            <div class="field_name">Last year details :</div>
            <div class="field_input" style="padding-top:5px; line-height:25px;">
            <strong>Section :</strong> <?php echo strtoupper($section);?><br />
            <strong>Area :</strong> <?php echo strtoupper($selected_area);?> <br />
            <strong>Category type :</strong> <?php echo $category?> <br />
            <strong>Premium type :</strong> <?php echo strtoupper($selected_premium_type);?>           
            </div>
            <div class="clear"></div>
        </div>
        <?php } ?>
		
        <div class="field">
         Please select any of the option <span>*</span> : <br/>
         <input type="hidden" name="exh_id" id="exh_id" value="<?php echo $exh_id?>"/>
        <?php if($num1==0){?>
        <input type="radio" id="option" class="bgcolor" name="option"  checked="checked" value="New participant" /> <label for="b_1">New participant</label><br />
        <?php } else { ?>
        <input type="radio" id="option" class="bgcolor" name="option" value="Same stall position size as of previous year" <?php if($option=="Same stall position size as of previous year"){?> checked="checked" <?php } ?> /> Same stall position size as of previous year<br/>
        
        <input type="radio" id="option" class="bgcolor" name="option" value="Same area but different location as of previous year Signature" <?php if($option=="Same area but different location as of previous year Signature"){?> checked="checked" <?php } ?>/> 
        Same area but different location as of previous year Signature 2018<br/>
		
        <input type="radio" id="option" class="bgcolor" name="option" value="More area than previous year Signature" <?php if($option=="More area than previous year Signature"){?> checked="checked" <?php } ?>  /> More area than previous year Signature<br/>
		<?php if($selected_area!=9){?>
        <input type="radio" id="option" class="bgcolor" name="option" value="Less area as previous year" <?php if($option=="Less area as previous year"){?> checked="checked" <?php } ?>  /> Less area as previous year <?php } ?>
		<?php } ?>
            <div class="clear"></div>
         </div>
		 
      <div class="field">
             <label>Select your Section <span>*</span> : </label>
            <select name="section" id="section"  class="textField" <?php if($section!=""){?> disabled="disabled"<?php }?>>
             <option selected="selected" value="">-----Select Section----</option>
            <?php 
			if(strtoupper($_SESSION['COUNTRY'])=="INDIA" || strtoupper($_SESSION['COUNTRY'])=="IND" || strtoupper($_SESSION['COUNTRY'])=="IN")
			{
			$sql="SELECT * FROM signature_section_master";
            $query=mysql_query($sql);
            while($result=mysql_fetch_array($query)){
            ?>
            <option value="<?php echo $result['section'];?>" <?php if($result['section']==$section){?> selected="selected" <?php }?> ><?php echo $result['section_desc'];?></option>
            <?php } } else { ?>
            <option value="International Jewellery" <?php if($section=="International Jewellery"){?> selected="selected" <?php }?>>International Jewellery</option>
            <option value="International Loose" <?php if($section=="International Loose"){?> selected="selected" <?php }?>>International Loose</option>
            <?php }?>
          </select>
          <?php if($section!=""){?><input type="hidden" name="section" id="section_hid" value="<?php echo $section;?>"/><?php }?>
            <div class="clear"></div>
            
         </div>
        <div class="field">
        	<label>Select your Category <span>*</span>: </label>
        	 <select name="category" id="category" class="textField" <?php if($option=="Same stall position size as of previous year"){?> disabled="disabled"<?php }/*if($category!=""){?> disabled="disabled"<?php }*/?>>
          <option selected="selected" value="">-----Select Category----</option>
            <?php 
			$sql="SELECT * FROM signature_category_master";
            $query=mysql_query($sql);
            while($result=mysql_fetch_array($query)){
            ?>
            <option value="<?php echo $result['category'];?>" <?php if($result['category']==$category){?> selected="selected" <?php }?> ><?php echo $result['category_desc'];?></option>
            <?php }?>
          </select>
          <?php if($category!=""){?><input type="hidden" name="category" id="category_hid" value="<?php echo $category;?>"/><?php }?>
            <div class="clear"></div>
        </div>
        <div class="field">
        	<label>Select your Area <span>*</span>: </label>
        	<select name="selected_area" id="selected_area" class="textField" <?php if($selected_area!=""){?> disabled="disabled"<?php }?>>
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
				$query=mysql_query($sql);
				while($result=mysql_fetch_array($query)){
            ?>
            <option value="<?php echo $result['area'];?>" <?php if($result['area']==$selected_area){?> selected="selected" <?php }?>><?php echo $result['area'];?></option>
            <?php }?>
          </select>
           <?php if($selected_area!=""){?><input type="hidden" name="selected_area" id="selected_area_hid" value="<?php echo $selected_area;?>"/><?php }?>
          
          <input type="hidden" name="lastYearArea" id="lastYearArea" value="<?php echo $selected_area;?>"/>
            <div class="clear"></div>
        </div>
        
        <!--........................Selected Scheme Type...........................-->
        <input type="hidden" id="selected_scheme_type" name="selected_scheme_type" value="BI"/>
        
        <div class="field">
        	<div class="leftTitle">Select your Premium Type <span>*</span></div>
       		<select class="textField" name="selected_premium_type" id="selected_premium_type" <?php if($option=="Same stall position size as of previous year"){?> disabled="disabled"<?php } /*if($selected_premium_type!=""){?> disabled="disabled"<?php }*/?>>
            <option selected="selected" value="">-----Select Premium Type----</option>
			<?php 
				$sql="SELECT * FROM signature_premium_master order by premium_id asc";
				$query=mysql_query($sql);
				while($result=mysql_fetch_array($query)){
            ?>
            <option value="<?php echo $result['premium'];?>" <?php if($result['premium']==$selected_premium_type){?> selected="selected" <?php }?>><?php echo $result['premium_desc'];?></option>
            <?php }?> 
            </select>
            <?php if($selected_premium_type!=""){?><input type="hidden" name="selected_premium_type" id="selected_premium_type_hid" value="<?php echo $selected_premium_type;?>"/><?php }?>
            <div class="clear"></div>
        </div>
        
        <!--.......................Woman Entrepreneurs............................-->
        <input type="hidden" name="woman_entrepreneurs" id="woman_entrepreneurs" value="0" />
       
        <div class="field">
        	<div class="leftTitle"><strong style="color:#000; font-size:14px;">Application Summary :</strong></div>
            <div class="clear"></div>
        </div>
        
        <div class="field">
        	<div class="leftTitle"><span style="display:inline-block; float:left; margin-right:10px; margin-top:10px;">Click on calculate button to calculate the figures</span></div>
       		<input type="button" name="calculate" id="calculate" value="Calculate" class="button" />
            <div class="clear"></div>
        </div>
        
        <div class="field">
        	<div class="leftTitle">Total space cost rate <?php echo $currency;?> </div>
       		<input type="text" class="textField" name="tot_space_cost_rate" id="tot_space_cost_rate" value="<?php echo $tot_space_cost_rate;?>" readonly="readonly" />
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <div class="field">
        <label>Selected category rate <?php echo $currency;?></label>
        <input type="text" class="textField" name="selected_scheme_rate" id="selected_scheme_rate" readonly="readonly" value="<?php echo $selected_scheme_rate;?>" />
        <div class="clear"></div>
        </div>
     
        <div class="field">
        	<label>Selected premium rate <?php echo $currency;?>:</label>
        	<input type="text" class="textField" name="selected_premium_rate" id="selected_premium_rate" readonly="readonly" value="<?php echo $selected_premium_rate;?>"/>
            <div class="clear"></div>
        </div>
        
        <div class="field">
            <label>Sub Total cost <?php echo $currency;?></label>
           		<input type="text" class="textField" name="sub_total_cost" id="sub_total_cost" readonly="readonly" value="<?php echo $sub_total_cost;?>" />
            <div class="clear"></div>
        </div> 
            
        <div class="field">
            <label style="padding-top:0px;">Security Deposit (10% on<br /> SubTotal Cost) <?php echo $currency;?></label>
            <input type="text" class="textField" name="security_deposit" id="security_deposit" readonly="readonly" value="<?php echo $security_deposit;?>" />
            <div class="clear"></div>
        </div>
            
        <div class="field">
            <label style="padding-top:0px;">GST (18% on SubTotal Cost) <?php echo $currency;?> :</label>
            <input type="text" class="textField" id="govt_service_tax" name="govt_service_tax" readonly="readonly" value="<?php echo $govt_service_tax;?>" />
            <div class="clear"></div>
        </div>
            
        <div class="field">
        	<label><strong>Grand Total </strong><?php echo $currency;?> </label>
        	<input type="text" class="textField" id="grand_total" name="grand_total" readonly="readonly" value="<?php echo $grand_total;?>" />
        	<div class="clear"></div>
        </div>                
	<div class="clear"></div>
</div>
	<div class="clear"></div>
    <div class="maroonBtn">
        <input type="hidden" name="action" value="Save" />
        <input type="submit" class="newMaroonBtn" value="Proceed to Next Step"/>
    </div> 
	<div class="clear"></div>
</form>
		</div>
	</div>
</div> 
        
	
		<div class="container_right">
	<table align="center" width="292px" cellpadding="5" border="1" bordercolor="#ddd" style="color:#333333; font-size:12px; border-radius:10px; border-collapse:collapse;">
  
  <tbody>
    <tr>
      <td colspan="3"><p><strong>Cost of Participation &amp; Premium Charges:</strong></p></td>
    </tr>
    <tr>
      <td><p><strong>Type</strong></p></td>
      <td><p><strong>Built-in Space Cost Per Sqmt. (Rs.)</strong></p></td>
    </tr>
    
    <tr>
      <td>
      <p>Premium On 2 Side Open Location</p>
      </td>
      <td>
      <p>5% Over &amp; Above to space cost </p>
      </td>
    </tr>
    <tr>
      <td>
      <p>Premium On 3 Side Open Location</p>
      </td>
      <td>
      <p>10% Over &amp; Above to space cost</p>
      </td>
    </tr>
    <tr>
      <td>
      <p>Premium On 4 Side Open Location (Island)</p>
      </td>
      <td>
      <p>15% Over &amp; Above to space cost</p>
      </td>
    </tr>
    <tr>
      <td>
      <p>Premium for Premium Location</p>
      </td>
      <td>
      <p>5% Over &amp; Above to space &amp; Premium cost</p>
      </td>
    </tr>
  </tbody>
</table>
          <div class="cont_link">
		  
            <div class="cont_head_inner">Note :</div>
                <div class="cont_detail">
				<ul> <li>All Member companies who are desirous of applying under Signature Club will have to submit a Power Point presentation in the below format for further consideration: (Allocation of space is subject to availability) </ul>
				<ul>
				<li> <b>A. </b> Page 1: Company name and other identification </li>
				<li><b>B. </b> Page 2, 3, 4 and 5: Maximum 4 pages of product images of 2 – 3 collections with the brief. With a maximum of not more than 6 images per page and not less than 4 images per page. </li>
				<li><b>C. </b> Page 6, 7, 8 and 9: Snapshots of Companies website along with URL </li>
				<li><b>D. </b> Advertising and communication skills:  Media presence,  Brands (if any),   Retail Story (if any),  Merchandising and Window display 2 pages  </li>
				<li><b>E. </b> Technology, Research & Development : (1-2 pages) </li>
				<li><b>F. </b> Patents and Awards : Design Awards & Booth Awards : (1-2 pages)</li>
				</ul>
                </div>
        	</div>        
        	<div class="cont_link_bottom"></div>            
		</div>
	  
        <div class="clear"></div>
    </div>
    <div class="container_2">
    	<?php include ('container2.php'); ?>
    </div>
</div>
<!--container ends-->
<!--footer starts-->
<div class="footer_wrap">
<?php include ('footer.php'); ?>
</div>
<!--footer ends-->
</body>
</html>
