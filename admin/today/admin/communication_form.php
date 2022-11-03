<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php 
$registration_id=$_REQUEST['registration_id'];
$info_status=mysql_query("select member_type_id,type_of_firm,status from information_master where registration_id='$registration_id' and status=1");
$info_num=mysql_num_rows($info_status);
$info_row=mysql_fetch_array($info_status);
$member_type_id=$info_row['member_type_id'];
$type_of_firm=$info_row['type_of_firm'];
if($info_num==0){
$_SESSION['form_chk_msg']="Please first fill Information form";
header('location:information_form.php?registration_id='.$registration_id);
exit;
}
?>
<?php
$action=$_REQUEST['action'];
if($action=="update")
{
$registration_id=$_REQUEST['registration_id'];
$panel_name=$_REQUEST['panel_name'];
$refer_membership_id=$_REQUEST['refer_membership_id'];
$refer_firm_name=$_REQUEST['refer_firm_name'];
$list_of_document=$_REQUEST['list_of_document'];
foreach($list_of_document as $val)
{
$list_of_document_new.=$val.",";
}

$authority_firm_name=$_REQUEST['authority_firm_name'];
$authority_firm_registration_no=$_REQUEST['authority_firm_registration_no'];
$authority_registration_date=$_REQUEST['authority_registration_date'];
$authority_registration_valid_upto=$_REQUEST['authority_registration_valid_upto'];
$export_product_name=$_REQUEST['export_product_name'];

foreach($export_product_name as $val)
{
$export_product_name_new.=$val.",";
}

$sql1="update communication_details_master set panel_name='$panel_name',refer_membership_id='$refer_membership_id',refer_firm_name='$refer_firm_name',list_of_document='$list_of_document_new',authority_firm_name='$authority_firm_name',authority_firm_registration_no='$authority_firm_registration_no',authority_registration_date='$authority_registration_date',authority_registration_valid_upto='$authority_registration_valid_upto',export_product_name='$export_product_name_new',status=1 where registration_id='$registration_id'";
if(!mysql_query($sql1))
{
	die('Error: ' . mysql_error());
}

$_SESSION['succ_msg']="Communication Form updated successfully";
header("Location: challan_form.php?registration_id=$_REQUEST[registration_id]");
}


$id=$_REQUEST['id'];
$registration_id=$_REQUEST['registration_id'];
$sql="SELECT * FROM `communication_details_master` WHERE 1 and registration_id=$registration_id";
$result=mysql_query($sql);
$rows=mysql_fetch_array($result);

$panel_name=$rows['panel_name'];
$refer_membership_id=$rows['refer_membership_id'];
$refer_firm_name=$rows['refer_firm_name'];
$list_of_document=$rows['list_of_document'];
$authority_firm_name=$rows['authority_firm_name'];
$authority_firm_registration_no=$rows['authority_firm_registration_no'];
$authority_registration_date=$rows['authority_registration_date'];
$authority_registration_valid_upto=$rows['authority_registration_valid_upto'];
$export_product_name=$rows['export_product_name'];
$status=$rows['status'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Communication Form || GJEPC ||</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />

<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>      
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

<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	$('#authority_registration_date').datepick();
	$('#authority_registration_valid_upto').datepick();
	
});
</script>

<script>
$(document).ready(function(){
 $("#type_of_address").change(function () {
	var type_of_address=$(this).val();
	//alert(type_of_address);
	arr = type_of_address.split('-');
	//alert(arr[0]);
	if((arr[0]==1) || (arr[0]==5) || (arr[0]==7))
	{	
		$("#basedontype").show();
	}
	
	if((arr[0]=="") || (arr[0]!=1) && (arr[0]!=5) && (arr[0]!=7))
	{	
		$("#basedontype").hide();	
	}
 });
 
$("#country").change(function(){
	country=$("#country").val();
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=getCity&country="+country,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							     //alert(data);
							     $("#stateDiv").html(data);  
							}
		});
 });

});
</script>


<script>
$('.deleteAdd').live('click',function(){
	clasvar = $(this).attr('class');
	x = clasvar.split(' ');
	id = x[1];
	registration_id = x[2];	
	var confrm=window.confirm('Are you sure you want to Delete.');
	if(confrm==true){
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=deleteAdd&id="+id+"&registration_id="+registration_id,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							 $("#CommunicationDetails").html(data);  
							}
		});
		}else
		{
			return false;
		}
});
</script>
<script>
$('.editAdd').live('click',function(){
	clasvar = $(this).attr('class');
	x = clasvar.split(' ');
	id = x[1];
	registration_id = x[2];
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=editAdd&id="+id+"&registration_id="+registration_id,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
					console.log(data);
					//alert(data);  
							$('#update_comm').html(data);
							 //$("#CommunicationDetails").html(data);  
							}
		});
});
</script>
<script type="text/javascript">
$(document).ready(function(){
  $("#add_more").click(function(){
  if($("#type_of_address").val()=="")
   {
   		alert("Please select type of communication address.");
		$("#type_of_address").focus();
		return false;
   }
   /*if($("#name").val()=="")
   {
   		alert("Please enter your Proprietor name.");
		$("#name").focus();
		return false;
   }*/
   if($("#address1").val()=="")
   {
   		alert("Please enter address 1.");
		$("#address1").focus();
		return false;
   }
   if($("#city").val()=="")
   {
   		alert("Please enter city.");
		$("#city").focus();
		return false;
   }
   if($("#country").val()=="")
   {
   		alert("Please select country.");
		$("#country").focus();
		return false;
   }
   if($("#state").val()=="")
   {
   		alert("Please enter state.");
		$("#state").focus();
		return false;
   }
   if($("#other_state").val()=="")
   {
   		alert("Please enter state.");
		$("#other_state").focus();
		return false;
   }
   
 /*  if($("#pincode").val()=="")
   {
   		alert("Please enter pincode.");
		$("#pincode").focus();
		return false;
   }*/
   var pincode=$("#pincode").val();
   if(pincode=="" || isNaN(pincode))
   {
   		alert("Please enter a valid pincode.");
		$("#pincode").focus();
		return false;
   }
   
   var landline_no1=$("#landline_no1").val();
   if(landline_no1=="" || isNaN(landline_no1))
   {
   		alert("Please enter a valid landline number.");
		$("#landline_no1").focus();
		return false;
   }
   
   var mobile_no=$("#mobile_no").val();
   if(mobile_no=="" || isNaN(mobile_no))
   {
   		alert("Please enter a valid mobile number.");
		$("#mobile_no").focus();
		return false;
   }
   
   var mobile_length=mobile_no.length
   if(mobile_length<10)
   {
   	    alert("Please enter at least 10 digit mobile number.");
		$("#mobile_no").focus();
		return false;
   }
   
    email=$("#email_id").val();
	var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	if(!emailPattern.test(email))
	{
		alert("Enter Valid Email Id!");
		$("#email_id").focus();
		return false;
	}
	comaddressData=$("#comaddress").serialize();
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=comaddress&comaddress="+comaddressData,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){ alert(data);
							    $("#comaddress")[ 0 ].reset();
							    $("#CommunicationDetails").html(data); 
							}
		});
  });
});
</script>

<script type="text/javascript">
function validate()
{
  	if (!$("input[name='panel_name']:checked").length > 0){
		$('#panel_msg').html('Please choose a panel');
		return false;
	}
	 if (!$("input[id='list_of_document']:checked").length > 0){
        $('#doc_msg').html('Please select one of the document');
		return false;
		}
	 if (!$("input[id='export_product_name']:checked").length > 0){
	    $('#exp_msg').html('Please select name of export products');
		return false;
	 }
}
</script>
<script>
 function x()
 {
 	alert("hieeee");return false;
 }
</script>
</head>

<body>

<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Membership > Communication Form</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">Communication Form
        <div style="float:right; padding-right:10px; font-size:12px;"><a href="membership.php">Back to Search Membership</a></div>
        </div>

<div class="content_details1">
  <?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}

if($_SESSION['error_msg1']!="" || $_SESSION['error_msg2']!="" || $_SESSION['error_msg3']!=""){
echo "<span class='notification n-attention'>";

if($_SESSION['error_msg1']!="")
{
echo $_SESSION['error_msg1']."<br>";
}

if($_SESSION['error_msg2']!="")
{
echo $_SESSION['error_msg2']."<br>";
}

if($_SESSION['error_msg3']!="")
{
echo $_SESSION['error_msg3'];
}

echo "</span>";

$_SESSION['error_msg1']="";
$_SESSION['error_msg2']="";
$_SESSION['error_msg3']="";
}
if($_SESSION['form_chk_msg']!=""){
echo "<span class='notification n-attention'>".$_SESSION['form_chk_msg']."</span>";
$_SESSION['form_chk_msg']="";
}
?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td colspan="13" >Communication Details</td>
    </tr>
      
 	<tr >
    <td width="20%" bgcolor="#CCCCCC"><span class="style1"><span class="text6"><strong>TYPE</strong></span></span></td>
    <td width="40%" bgcolor="#CCCCCC"><span class="style1"><span class="text6"><strong>ADDRESS</strong></span></span></td>
    <td width="20%" bgcolor="#CCCCCC"><span class="style1"><span class="text6"><strong>CONTACT NAME</strong></span></span>	</td> 
    <td width="20%" bgcolor="#CCCCCC" colspan="2"><span class="style1"><span class="text6"><strong>ACTION LINKS</strong></span></span></td>
   </tr>
       
       <tbody id="CommunicationDetails">
       <?php 
	   	$query=mysql_query("select * from communication_address_master where registration_id='".$_REQUEST['registration_id']."'");
		while($result=mysql_fetch_array($query)){
	   ?>
       	<tr>
           <td><span class="text6"><?php echo getaddresstype($result['type_of_address']);?></span></td>
           <td><span class="text6"><?php echo $result['address1'];?><?php if($result['address2']!=""){echo ",".$result['address2'];}?><?php if($result['address3']!=""){echo ",".$result['address3'];}?><?php if($result['city']!=""){echo ",".$result['city'];}?><?php if($result['state']!=""){echo ",".getState($result['state']);}?><?php if($result['pincode']!=""){echo ",".$result['pincode'];}?>
</span></td>
           <td><span class="text6"><?php echo $result['name'];?></span></td> 
           <td class="editAdd <?php echo $result['id'];?> <?php echo $_REQUEST['registration_id'];?>">EDIT</td>
           <td class="deleteAdd <?php echo $result['id'];?> <?php echo $_REQUEST['registration_id'];?>">DELETE</td>
        </tr>
       <?php } ?>
 	  </tbody>
     <tr>
    <td colspan="13" >&nbsp;</td>
    </tr>
  </table>
  <br />

<div id="update_comm">
<?php
if($type_of_firm==14){$addflag=1;}  /* For SAP */
else if($type_of_firm==11){$addflag=2;}
else if($type_of_firm==13){$addflag=3;}
else if($type_of_firm==12){$addflag=4;}
else if($type_of_firm==15){$addflag=5;}
else if($type_of_firm==18){$addflag=6;}
else if($type_of_firm==17){$addflag=7;}
else if($type_of_firm==16){$addflag=8;}
else if($type_of_firm==19){$addflag=9;}
/*
if($type_of_firm=="Proprietory"){$addflag=1;}
else if($type_of_firm=="Partnership"){$addflag=2;}
else if($type_of_firm=="Private Ltd"){$addflag=3;}
else if($type_of_firm=="Public Ltd"){$addflag=4;}
else if($type_of_firm=="Proprietory HUF"){$addflag=5;}
else if($type_of_firm=="Individual"){$addflag=6;}
else if($type_of_firm=="Trustees"){$addflag=7;}
else if($type_of_firm=="Co-Op Society"){$addflag=8;}
else if($type_of_firm=="Others"){$addflag=9;}
*/
?>

<form id="comaddress" name="comaddress">
<input type="hidden" name="hidden" id="hidden" value=""/>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
<tr>
 <td bgcolor="#CCCCCC" colspan="3"><strong>Address Details </strong></td>
 </tr> 
  <tr >
    <td colspan="2"><span class="text6 ">Type of Communication Address:</span> <span class="star"> * </span></td>
    <td>
    	<select class="input_txt1" id="type_of_address" name="type_of_address">
		<option value="">---- Select ----</option>
        <?php
		$sql=getCommunicationAddress($addflag);
		$result=mysql_query($sql);
		while($rows=mysql_fetch_array($result))
		{
		echo "<option value='$rows[id]-$rows[address_identity]'>$rows[type_of_comaddress_name]</option>";
		}
		?>
		</select>
		</td>
  </tr>
  <tbody style="display:none;" id="basedontype">
	<tr>
    <td colspan="2" ><span class="text6 ">Name:</span> <span class="star">* </span></td>
    <td><input type="text"  id="name" name="name"  class="input_txt_new" /></td>
    </tr>
    
    <tr >
    <td colspan="2"><span class="text6 ">Father's Name:</span></td>
    <td><input type="text" class="input_txt_new" id="father_name" name="father_name" maxlength="30"/></td>
  </tr>
  </tbody>

	<tr >
    <td colspan="2" ><span class="text6 ">Address Line 1:</span> <span class="star">* </span></td>
    <td><input type="text" class="input_txt_new" id="address1"  name="address1" maxlength="30"/></td>
    </tr>	
    
    
    <tr >
    <td colspan="2"><span class="text6 ">Address Line 2:</span></td>
    <td><input type="text" class="input_txt_new" id="address2" name="address2" maxlength="30" /></td>
  </tr>

	<tr  >
    <td colspan="2"><span class="text6 ">Address Line 3:</span></td>
    <td>
    	<input type="text" class="input_txt_new" id="address3" name="address3" maxlength="30" /> </td>
  </tr>
	<tr >
	  <td colspan="2"><span class="text6 ">City:</span> <span class="star">* </span></td>
	  <td>
      <input type="text" class="input_txt_new" id="city" name="city"/>
      </td>
	  </tr>
	<tr>
	  <td colspan="2"><span class="text6 ">Country:</span> <span class="star"> * </span></td>
	  <td>
      <select name="country" id="country" class="input_txt_new">
		<!--<option value="">---------- Select ----------</option>-->
        <?php 
		$query=mysql_query("SELECT * FROM country_master where country_code='IN'");
		while($result=mysql_fetch_array($query)){
		?>
        <option value="<?php echo $result['country_code'];?>" <?php if($result['country_code']=="IND"){?> selected="selected" <?php } ?>><?php echo $result['country_name'];?></option>
        <?php } ?>
	 </select>
      </td>
	</tr>
    <tr id="stateDiv">
	  <td colspan="2"><span class="text6 ">State:</span> <span class="star"> * </span></td>
	  <td>
	  <select name="state" id="state" class="input_txt_new">
		<option value="">-- Select State --</option>
		<?php 
		$query=mysql_query("SELECT * from state_master WHERE country_code = 'IN'");
		while($result=mysql_fetch_array($query)){?>
		<option value="<?php echo $result['state_code'];?>"  <?php if($result['state_code']==$state){?> selected="selected" <?php }?>><?php echo $result['state_name'];?></option>
		<?php }?>
	   </select>
	  </td>
	</tr>     
			
	<tr>
	  <td colspan="2"><span class="text6 ">Pin Code:</span>  <span class="star"> * </span></td>
	  <td><input type="text" class="input_txt_new" id="pincode" name="pincode" maxlength="6" /></td>
	  </tr>
	<tr >
	  <td colspan="2"><span class="text6 ">Landline No.:<span class="star"> * </span></span></td>
	  <td><input type="text" class="input_txt_new" id="landline_no1" name="landline_no1"/></td>
	  </tr>
	<tr >
	  <td colspan="2"><span class="text6 ">Mobile No.:</span> <span class="star"> * </span></td>
	  <td><input type="text" class="input_txt_new" id="mobile_no" name="mobile_no"  maxlength="10"/></td>
	  </tr>
	<!--<tr >
	  <td colspan="2"><span class="text6 ">Fax No.1:</span></td>
	  <td><input type="text" class="input_txt_new" id="fax_no1" name="fax_no1" /></td>
	  </tr>
	<tr >
	  <td colspan="2"><span class="text6 ">Fax No.2:</span></td>
	  <td><input type="text" class="input_txt_new" id="fax_no2" name="fax_no2" /></td>
	</tr>-->
	<tr >
	  <td colspan="2"><span class="text6 ">Email:</span> <span class="star"> * </span></strong></td>
	  <td><input type="text" class="input_txt1" id="email_id" name="email_id"/></td>
	</tr>
	
	<?php
	if($type_of_firm==13 || $type_of_firm==12){
	?>
	<tr>
	<td colspan="2"><span class="text6 ">DIN No.:</td>
	<td><input type="text" class="input_txt1" id="din_no" name="din_no" /></td>
	</tr><?php }?>

	<tr>
	<td colspan="2"><span class="text6 ">PAN:</td>
	<td><input type="text" class="input_txt1" id="pan_no" name="pan_no" maxlength="10"/></td>
	</tr>
	
	<tr>
	<td colspan="2"><span class="text6 ">GSTIN:</td>
	<td><input type="text" class="input_txt1" id="gst_no" name="gst_no" maxlength="15"/></td>
	</tr>
	
	<tr>
    <td colspan="13" class="text6" >
    <span class="style6">Note- : Fill up name of all present partners and directores as the case may be.</span><br/>
    </td>
    <input type="hidden" id="registration_id" name="registration_id" value="<?php echo $_REQUEST['registration_id'];?>"/>   
    </tr>
  
  </table>
  <input type="button" name="add_more" id="add_more" value="Add More" class="input_submit" />
</form>
  </div>
 </div>
<form action="" method="post" id="communicationForm" name="communicationForm" onsubmit="return validate()">   
<div class="content_details1">
        	
 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td colspan="14" >Panel</td>
    </tr>
   
    <tr >
    <td colspan="8"><strong class="text6">Panel Details: <span class="star">*</span><span id="panel_msg" class="star"></span></strong></td>
    </tr> 
 
    <tr >
    <td colspan="2" align="center"> <div align="left">
      <input type="radio" name="panel_name" id="panel_name" value="Coloured Gemstones" <?php if($panel_name=='Coloured Gemstones'){echo "checked='checked'";}?>/>
    </div></td>
    <td width="46%"><span class="text6 ">Coloured Gemstones</span></td>
    <td colspan="2" align="center"> <div align="left">
      <input type="radio" name="panel_name" id="panel_name" value="Pearls" <?php if($panel_name=='Pearls'){echo "checked='checked'";}?>/>
    </div></td>
    <td width="46%"><span class="text6 ">Pearls</span></td>
    </tr>
    
     <tr bgcolor="#CCCCCC">
    <td colspan="2" align="center"> <div align="left">
      <input type="radio" name="panel_name" id="panel_name" value="Costume/Fashion Jewellery" <?php if($panel_name=='Costume/Fashion Jewellery'){echo "checked='checked'";}?>/>
    </div></td>
    <td width="46%"><span class="text6 ">Costume/Fashion Jewellery</span></td>
    <td colspan="2" align="center"> <div align="left">
      <input type="radio" name="panel_name" id="panel_name" value="Sales To Foreign Tourists" <?php if($panel_name=='Sales To Foreign Tourists'){echo "checked='checked'";}?>/>
    </div></td>
    <td width="46%"><span class="text6 ">Sales To Foreign Tourists</span></td>
    </tr>
    
    <tr >
    <td colspan="2" align="center"> <div align="left">
      <input type="radio" name="panel_name" id="panel_name" value="Diamonds" <?php if($panel_name=='Diamonds'){echo "checked='checked'";}?>/>
    </div></td>
    <td width="46%"><span class="text6 ">Diamonds</span></td>
    <td colspan="2" align="center"> <div align="left">
      <input type="radio" name="panel_name" id="panel_name" value="Synthetic Stones" <?php if($panel_name=='Synthetic Stones'){echo "checked='checked'";}?> />
    </div></td>
    <td width="46%"><span class="text6 ">Synthetic Stones</span></td>
    </tr>
    
     <tr bgcolor="#CCCCCC">
    <td colspan="2" align="center"> <div align="left">
      <input type="radio" name="panel_name" id="panel_name" value="Gold Jewellery" <?php if($panel_name=='Gold Jewellery'){echo "checked='checked'";}?>/>
    </div></td>
    <td width="46%"><span class="text6 ">Gold Jewellery</span></td>
     <td colspan="2" align="center"> <div align="left">
      <input type="radio" name="panel_name" id="panel_name" value="Not Indicated" <?php if($panel_name=='Not Indicated'){echo "checked='checked'";}?>/>
    </div></td>
    <td width="46%"><span class="text6 ">Not Indicated</span></td>
    </tr>
    
    <tr >
   
    <td colspan="2" align="center"> <div align="left">
      <input type="radio" name="panel_name" id="panel_name" value="Other Precious Metal Jewellery" <?php if($panel_name=='Other Precious Metal Jewellery'){echo "checked='checked'";}?>/>
    </div></td>
    <td width="46%"><span class="text6 ">Other Precious Metal Jewellery</span></td>
    
    <td colspan="2" align="center"> <div align="left">
      <input type="radio" name="panel_name" id="panel_name" value="Silver" <?php if($panel_name=='Silver'){echo "checked='checked'";}?>/>
    </div></td>
    <td width="46%"><span class="text6 ">Silver Jewellery</span></td>
    </tr>
  </table>
      </div>
      
<div class="content_details1">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
	<tr class="orange1">
    <td colspan="14" >Referral Of GJEPC</td>
    </tr>
    <tr >
	<td colspan="3"><strong>Membership ID (Eg. GXXXXX):</strong></td>
	<td width="65%" colspan="2"><input type="text" class="input_txt1" name="refer_membership_id" id="refer_membership_id" value="<?php echo $refer_membership_id; ?>"/></td>
	</tr>
	<tr >
	<td colspan="3"><strong>Name of the Firm:</strong></td>
	<td colspan="2"><input type="text" class="input_txt1" name="refer_firm_name" id="refer_firm_name" value="<?php echo $refer_firm_name; ?>" /></td>
	</tr>
</table>
</div>
					<?php 
					if($member_type_id==5 && $type_of_firm=14){$flag=1;}
					if($member_type_id==5 && $type_of_firm==11){$flag=2;}
					if($member_type_id==6 && $type_of_firm==14){$flag=3;}
					if($member_type_id==6 && $type_of_firm==13){$flag=4;}
					?>
<div class="content_details1">
        	
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
	<tr class="orange1">
    <td colspan="13" >List of documents to be submitted</td>
    </tr>
    <tr>
    <td colspan="4" ><strong class="text6">List of documents: <span class="star">*</span><span id="doc_msg" class="star"></span></strong></td>
    </tr>    
    <tr>
    <td align="center"> <div align="left">
      <input type="checkbox" name="list_of_document[]" id="list_of_document" value="Memorandum and Articles of Association" <?php if(preg_match('/Memorandum and Articles of Association/',$list_of_document)){ echo ' checked="checked"'; } ?> <?php if($flag==1 || $flag==2 || $flag==3){?> disabled="disabled" <?php }?>>
    </div></td>
    <td width="46%"><span class="text6 ">Memorandum and Articles of Association</span></td>
    <td align="center"> <div align="left">
      <input type="checkbox" name="list_of_document[]" id="list_of_document" value="IEC Certificate" <?php if(preg_match('/IEC Certificate/',$list_of_document)){ echo ' checked="checked"'; } ?>>
    </div></td>
    <td width="46%"><span class="text6 ">IEC Certificate</span></td>
    </tr>
    
     <tr bgcolor="#CCCCCC">
    <td align="center"> <div align="left">
     <input type="checkbox" name="list_of_document[]" id="list_of_document" value="Small Scale Industries certificate (SSI)" <?php if(preg_match('/Small Scale Industries certificate (SSI)/',$list_of_document)){ echo ' checked="checked"'; } ?> <?php if($flag==1 || $flag==2){?> disabled="disabled" <?php }?>>
    </div></td>
    <td width="46%"><span class="text6 ">Small Scale Industries certificate (SSI)</span></td>
    <td align="center"> <div align="left">
      <input type="checkbox" name="list_of_document[]" id="list_of_document" value="IEM certificate" <?php if(preg_match('/IEM certificate/',$list_of_document)){ echo ' checked="checked"'; } ?> <?php if($flag==1 || $flag==2|| $flag==3){?> disabled="disabled" <?php }?>>
    </div></td>
    <td width="46%"><span class="text6 ">IEM certificate</span></td>
    </tr>
    <tr>
    <td align="center"> <div align="left">
      <input type="checkbox" name="list_of_document[]" id="list_of_document" value="Partnership deed" <?php if(preg_match('/Partnership deed/',$list_of_document)){ echo ' checked="checked"'; } ?> <?php if($flag==1 || $flag==3){ ?> disabled="disabled" <?php }?>>
    </div></td>
    <td width="46%"><span class="text6 ">Partnership deed</span></td>
    </tr>
    
  </table>
      </div>

<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
	<tr class="orange1">
    <td colspan="14" >Other Authority Details</td>
    </tr>      
 
    <tr >
	  <td colspan="3"><strong>Name of any other authority with whom the firm is registered:</strong></td>
	  <td width="56%" colspan="2"><input type="text" class="input_txt1" name="authority_firm_name" id="authority_firm_name" value="<?php echo $authority_firm_name; ?>" /></td>
	  </tr>
	<tr >
	  <td colspan="3"><strong>Registration No:</strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="authority_firm_registration_no" id="authority_firm_registration_no" value="<?php echo $authority_firm_registration_no;?>" /></td>
	</tr>    
	<tr >
	  <td colspan="3"><strong>Registration Date:</strong></td>
	  <td width="56%" colspan="2"><input type="text" class="input_txt1" name="authority_registration_date" id="authority_registration_date" value="<?php echo $authority_registration_date;?>" /></td>
	  </tr>
	<tr >
	  <td colspan="3"><strong>Valid upto:</strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="authority_registration_valid_upto" id="authority_registration_valid_upto" value="<?php echo $authority_registration_valid_upto;?>" /></td>
	  </tr>
  </table>
      </div> 
      
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td colspan="13" >Name of export products under which registration is required</td>
    </tr>

    <tr >
    <td colspan="4" ><strong class="text6">Export products:<span class="star">*</span><span id="exp_msg" class="star"></span></strong></td>
    </tr>
    
    <tr >
    <td align="center"> <div align="left">
      <input type="checkbox" name="export_product_name[]" id="export_product_name" value="Polished & Processed Pearls" <?php if(preg_match('/Polished & Processed Pearls/',$export_product_name)){ echo ' checked="checked"'; } ?>>
    </div></td>
    <td width="46%"><span class="text6 ">Polished & Processed Pearls</span></td>
    <td align="center"> <div align="left">
      <input type="checkbox" name="export_product_name[]" id="export_product_name" value="Cut & Polished Synthetic stone" <?php if(preg_match('/Cut & Polished Synthetic stone/',$export_product_name)){ echo ' checked="checked"'; } ?>>
    </div></td>
    <td width="46%"><span class="text6 ">Cut & Polished Synthetic stone</span></td>
    </tr>
    
     <tr bgcolor="#CCCCCC">
    <td align="center"> <div align="left">
     <input type="checkbox" name="export_product_name[]" id="export_product_name" value="Cut & Polished Diamonds" <?php if(preg_match('/Cut & Polished Diamonds/',$export_product_name)){ echo ' checked="checked"'; } ?>>
    </div></td>
    <td width="46%"><span class="text6 ">Cut & Polished Diamonds</span></td>
    <td align="center"> <div align="left">
      <input type="checkbox" name="export_product_name[]" id="export_product_name" value="Costume Fashion Jewellery" <?php if(preg_match('/Costume Fashion Jewellery/',$export_product_name)){ echo ' checked="checked"'; } ?>>
    </div></td>
    <td width="46%"><span class="text6 ">Costume / Fashion Jewellery</span></td>
    </tr>
    
    <tr >
    <td align="center"> <div align="left">
      <input type="checkbox" name="export_product_name[]" id="export_product_name" value="Cut & Polished Coloured Gemstones" <?php if(preg_match('/Cut & Polished Coloured Gemstones/',$export_product_name)){ echo ' checked="checked"'; } ?>>
    </div></td>
    <td width="46%"><span class="text6 ">Cut & Polished Coloured Gemstones</span></td>
    <td align="center"> <div align="left">
      <input type="checkbox" name="export_product_name[]" id="export_product_name" value="Silver Jewellery & Silver Filligree" <?php if(preg_match('/Silver Jewellery & Silver Filligree/',$export_product_name)){ echo ' checked="checked"'; } ?>>
    </div></td>
    <td width="46%"><span class="text6 ">Silver Jewellery & Silver Filligree</span></td>
    </tr>
    
     <tr bgcolor="#CCCCCC">
    <td align="center"> <div align="left">
     <input type="checkbox" name="export_product_name[]" id="export_product_name" value="Jewellery containing gold" <?php if(preg_match('/Jewellery containing gold/',$export_product_name)){ echo ' checked="checked"'; } ?>>
    </div></td>
    <td width="46%"><span class="text6 ">Jewellery containing gold</span></td>
    <td align="center"> <div align="left">
      <input type="checkbox" name="export_product_name[]" id="export_product_name" value="Rough Diamonds" <?php if(preg_match('/Rough Diamonds/',$export_product_name)){ echo ' checked="checked"'; } ?>>
    </div></td>
    <td width="46%"><span class="text6 ">Rough Diamonds</span></td>
    </tr>
    
  </table>
      </div>     
        
		<div style="padding-left:10px; margin-top:5px;">
        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="registration_id" id="registration_id" value="<?php echo $registration_id;?>" />
    	<input type="submit" name="update" value="Update" class="input_submit"  />
        <a href="information_form.php?registration_id=<?php echo $_REQUEST['registration_id'];?>"><div class="button">Previous</div></a>
        <a href="challan_form.php?registration_id=<?php echo $_REQUEST['registration_id'];?>"><div class="button">Next</div></a>
		</div>	
       </form> 
   </div>
  </div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>