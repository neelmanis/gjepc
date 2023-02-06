<?php 
session_start();
include('../db.inc.php');
include('../functions.php');

if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }

$registration_id = intval($_REQUEST['registration_id']);
if($registration_id!=''){
$info_status = $conn ->query("select member_type_id,type_of_firm,status from information_master where registration_id='$registration_id' and status=1");
$info_num =  $info_status->num_rows;
$info_row = $info_status->fetch_assoc();
$member_type_id	=	filter($info_row['member_type_id']);
$type_of_firm	=	filter($info_row['type_of_firm']);
if($info_num==0){
$_SESSION['form_chk_msg']="Please first fill Information form";
header('location:information_form.php?registration_id='.$registration_id);
exit;
} }
?>
<?php
$action=$_REQUEST['action'];
if($action=="update")
{
$registration_id	=	intval($_REQUEST['registration_id']);
$panel_name=$_REQUEST['panel_name'];
if($panel_name=="Lab Grown Diamond"){ $lgd_disclaimer="YES"; } else { $lgd_disclaimer=""; }
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
if(isset($registration_id) && $registration_id!=""){
$sql1 = $conn ->query("update communication_details_master set panel_name='$panel_name',refer_membership_id='$refer_membership_id',refer_firm_name='$refer_firm_name',list_of_document='$list_of_document_new',authority_firm_name='$authority_firm_name',authority_firm_registration_no='$authority_firm_registration_no',authority_registration_date='$authority_registration_date',authority_registration_valid_upto='$authority_registration_valid_upto',export_product_name='$export_product_name_new',status=1 where registration_id='$registration_id'");
if(!$sql1) die ($conn->error);

$_SESSION['succ_msg']="Communication Form updated successfully";
header("Location: challan_form.php?registration_id=$_REQUEST[registration_id]");
}
}

$id	=	intval($_REQUEST['id']);
$registration_id	=	intval($_REQUEST['registration_id']);
$sql = $conn ->query("SELECT * FROM `communication_details_master` WHERE 1 and registration_id=$registration_id");
$rows = $sql->fetch_assoc();

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
		arr = type_of_address.split('-');
		//alert(arr[0]);
		//alert(arr[1]);
		if((arr[1]=="CTC"))
		{ 
			$("#basedonAdhar").hide();
			$("#basedonpass").hide();
			$("#basedonjdate").hide();
			$("#basedonrdate").hide();
			$("#basedontypes").hide();
			$("#basedontype").hide();
			$("#basedonpan").hide();
			$("#basedontype2").show();
			$("#aadhar_no").attr("disabled", "disabled"); 
			$("#passport_no").attr("disabled", "disabled"); 
			$("#joining_date").attr("disabled", "disabled"); 
			$("#retirement_date").attr("disabled", "disabled");
			$("#gst_no").attr("disabled", "disabled"); 
		} else {
			$("#basedonAdhar").show();
			$("#basedonpass").show();
			$("#basedonjdate").show();
			$("#basedonrdate").show();
			$("#basedontypes").show();
			$("#basedontype").show();
			$("#basedontype2").hide();
			$("#basedonpan").show();
			$("#aadhar_no").removeAttr("disabled"); 
			$("#passport_no").removeAttr("disabled", "disabled"); 
			$("#joining_date").removeAttr("disabled", "disabled"); 
			$("#retirement_date").removeAttr("disabled", "disabled");
			$("#gst_no").removeAttr("disabled", "disabled"); 
		}
		if((arr[0]==2)) 
		{
			$("#basedonpan").show(); 
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
<!--<script>
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
</script>-->

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
							$('#preloader').show();
							$('#status').show();
							},
					success: function(data){
							$('#preloader').hide();
							$('#status').hide();
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
							$('#preloader').show();
							$('#status').show();
					},
					success: function(data){
							$('#preloader').hide();
							$('#status').hide();
						console.log(data);
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
	//alert(comaddressData);
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=comaddress&comaddress="+comaddressData,
					dataType:'html',
					beforeSend: function(){
							$('#preloader').show();
							$('#status').show();
							},
					success: function(data){ 
							$('#preloader').hide();
							$('#status').hide();
								//console.log(data);
								//alert(data);
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
<style>
#preloader {
    position: fixed;
    background-color: #fff;
    z-index: 99999;
    width: 100%;
    height: 100%;
    overflow: hidden;
	display:none;
	
}
#status {
    width: 150px;
    height: 150px;
	position:absolute;
	top:50%;
	left:50%;
	transform: translate(-50%,-50%);
	display:none;
}
</style>
</head>

<body>
<div id="preloader">
	<div class="d-flex justify-content-center h-100">
    <div id="status" class="align-self-center"><img src="../assets/images/loader.gif"></div>
    </div>
</div>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Membership > Communication Form</div>
</div>
<!-- HIDDEN / POP-UP DIV SAP Help Note -->
<script>
$(function() {
  var moveLeft = 20;
  var moveDown = 10;

  $('a#trigger').hover(function(e) {
    $('div#pop-up').show();
      //.css('top', e.pageY + moveDown)
      //.css('left', e.pageX + moveLeft)
      //.appendTo('body');
  }, function() {
    $('div#pop-up').hide();
  });

  $('a#trigger').mousemove(function(e) {
    $("div#pop-up").css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);
  });

});
</script>
<style>
a {
  color: #EB067B;
}

/* HOVER STYLES */
div#pop-up {
  display: none;
  position: absolute;
  width: 200px;
  padding: 10px;
  background: #eeeeee;
  color: #000000;
  border: 1px solid #1a1a1a;
  font-size: 90%;
}
</style>
    <div id="pop-up">
      <h3>SAP Help Note</h3>
	  <table border='1'>
	  <tr> <td> HEAD OFFICE</td><td> CTC</td></tr>
	  <tr> <td> BRANCH OFFICE</td><td> CTC</td></tr>
	  <tr> <td> FACTORY</td><td> CTC</td></tr>
	  <tr> <td> REGISTERED OFFICE</td><td> CTC</td></tr>
	  <tr> <td> CO-OP SOCIETY</td><td> CTC</td></tr>
	  <tr> <td> PROPRIETOR</td><td> CTP</td></tr>
	  <tr> <td> PARTNER</td><td> CTP</td></tr>
	  <tr> <td> DIRECTOR</td><td> CTP</td></tr>
	  <tr> <td> INDIVIDUAL</td><td> CTP</td></tr>
	  <tr> <td> TRUSTEE</td><td> CTP</td></tr>
	  <tr> <td> AUTHORISED PERSON</td><td> CTP</td></tr>
	  </table>
    </div>
<!-- HIDDEN / POP-UP DIV SAP Help Note -->
<div id="main">
	<div class="content">
    	<div class="content_head">Communication Form <a href="#" id="trigger">SAP Help Note</a>
        
        <div style="float:right; padding-right:10px; font-size:12px;"><a href="membership.php">Back to Search Membership</a></div>
        </div>

<div class="content_details1">
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}

if($_SESSION['error_msg1']!="" || $_SESSION['error_msg2']!="" || $_SESSION['error_msg3']!="" || $_SESSION['error_msgs']!=""){
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

if($_SESSION['error_msgs']!="")
{
echo $_SESSION['error_msgs'];
}

echo "</span>";

$_SESSION['error_msg1']="";
$_SESSION['error_msg2']="";
$_SESSION['error_msg3']="";
$_SESSION['error_msgs']="";
}
if($_SESSION['form_chk_msg']!=""){
echo "<span class='notification n-attention'>".$_SESSION['form_chk_msg']."</span>";
$_SESSION['form_chk_msg']="";
}
?>
	<div style="overflow-x: scroll;"> 
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt">
	<tr class="orange1">
    <td colspan="13">Communication Details</td>
    </tr>
      
 	<tr>
    <td width="10%" bgcolor="#CCCCCC"><span class="style1"><span class="text6"><strong>TYPE</strong></span></span></td>
    <td width="10%" bgcolor="#CCCCCC"><span class="style1"><span class="text6"><strong>BP No.</strong></span></span></td>
    <td width="10%" bgcolor="#CCCCCC"><span class="style1"><span class="text6"><strong>Type</strong></span></span></td>
    <td width="10%" bgcolor="#CCCCCC"><span class="style1"><span class="text6"><strong>ADDRESS</strong></span></span></td>
    <td width="10%" bgcolor="#CCCCCC"><span class="style1"><span class="text6"><strong>CONTACT NAME</strong></span></span>	</td> 
    <td width="10%" bgcolor="#CCCCCC"><span class="style1"><span class="text6"><strong>PAN NO</strong></span></span></td>
    <td width="10%" bgcolor="#CCCCCC"><span class="style1"><span class="text6"><strong>GST NO</strong></span></span></td>
    <td width="10%" bgcolor="#CCCCCC" colspan="2"><span class="style1"><span class="text6"><strong>ACTION LINKS</strong></span></span></td>
	<td width="10%" bgcolor="#CCCCCC" colspan="3"><span class="style1"><span class="text6"><strong>CBP/Delta/KYC</strong></span></span>	</td>
	<td width="10%" bgcolor="#CCCCCC"><span class="style1"><span class="text6"><strong>Status</strong></span></span>	</td>
    </tr>
       
       <tbody id="CommunicationDetails">
       <?php 
	   	$query = $conn ->query("select * from communication_address_master where registration_id='".$_REQUEST['registration_id']."'");
		while($result= $query->fetch_assoc()){ ?>
       	<tr>
           <td><span class="text6"><?php echo getaddresstype($result['type_of_address'],$conn);?></span></td>
           <td><span class="text6"><?php echo $result['c_bp_number'];?></span></td>
           <td><span class="text6"><?php echo $result['address_identity'];?></span></td>
           <td><span class="text6"><?php echo $result['address1'];?><?php if($result['address2']!=""){echo ",".$result['address2'];}?><?php if($result['address3']!=""){echo ",".$result['address3'];}?><?php if($result['city']!=""){echo ",".$result['city'];}?><?php if($result['state']!=""){echo ",".getState($result['state'],$conn);}?><?php if($result['pincode']!=""){echo ",".$result['pincode'];}?>
			</span></td>
           <td><span class="text6"><?php echo $result['name'];?></span></td>
           <td><span class="text6"><?php echo $result['pan_no'];?></span></td> 
           <td><span class="text6"><?php echo $result['gst_no'];?></span></td>           
           <td class="editAdd <?php echo $result['id'];?> <?php echo $_REQUEST['registration_id'];?>">EDIT</td>
           <td class="deleteAdd <?php echo $result['id'];?> <?php echo $_REQUEST['registration_id'];?>">DELETE</td>
		   
           <?php $total_payable = getTotal_Value($_REQUEST['registration_id'],$conn); 
		   if($total_payable==1180){ $gmember = "MICRO"; } else { $gmember = "NORMAL"; } ?>
		   
		   <?php if($result['c_bp_number']=="") { ?>
		   <td class="sap <?php echo $result['id'];?> <?php echo $_REQUEST['registration_id'];?> <?php echo $gmember;?>"><img src="images/reply.png" title="Create BP" border="0" style=""/></td>
		   <?php } else { ?>
		   <td><a onclick="return(window.confirm('BP Already Created'));"><img src="images/active.png" title="BP Created"/></a></td>
		   <?php } ?>
           
           <?php if($result['c_bp_number']!=""){?>
           <!--	<td class="delta" data-url="<?php echo $registration_id." ".$result['id'];?>"><img src="images/reply.png" title="PUSH" border="0" style=""/></td>-->
           	<td class="delta <?php echo $registration_id." ".$result['id'];?>"><img src="images/reply.png" title="Push to DELTA" border="0" style=""/></td>
            <?php } ?>
           
           <?php 
		   if($result['type_of_address']==2){
		   if($result['push_to_kyc']==0) { ?>
		   <td class="kyc <?php echo $result['id'];?> <?php echo $_REQUEST['registration_id'];?>"><img src="images/reply.png" title="PUSH to KYC" border="0" style=""/></td>
		   <?php } else {?>
		   <td><a onclick="return(window.confirm('Already Pushed to KYC'));"><img src="images/active.png" title="KYC Pushed"/></a></td>
		   <?php }} else { ?>
           <td>&nbsp;</td>
           <?php } ?>
		   
		   <?php /* Address Cancellation */
		   if($result['status']!="")
		   { 
		    if($result['status']==1){ ?>
		    <td class="cancellation <?php echo $result['id'];?> <?php echo $_REQUEST['registration_id'];?>"><img src="images/active.png" title="Cancel Address" border="0" style=""/></td>
		    <?php } else { ?>
		   <td><a onclick="return(window.confirm('Address Cancelled'));"><img src="images/no.gif" title="Address Cancelled"/></a></td>
		   <?php } 
		   } ?>
        </tr>
       <?php } ?>
 	  </tbody>
     <tr>
    <td colspan="13" >&nbsp;</td>
    </tr>
  </table>
  </div>
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
		$sql = getCommunicationAddress($addflag,$conn);
		$result= $conn ->query($sql);
		while($rows = $result->fetch_assoc())
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
    
    <tr>
    <td colspan="2"><span class="text6 ">Father's Name:</span></td>
    <td><input type="text" class="input_txt_new" id="father_name" name="father_name" maxlength="30"/></td>
    </tr>
    <tr>
    <td colspan="2"><span class="text6 ">Designation:</span></td>
    <td>
    <select name="designation" id="designation">
    <option value="">--Select--</option>
        <option value="Partner">Partner</option>
        <option value="Director">Director</option>
        <option value="Proprietor">Proprietor</option>
    </select>    
    </td>
    </tr>
  </tbody>

	<tr>
    <td colspan="2" ><span class="text6 ">Address Line 1:</span> <span class="star">* </span></td>
    <td><input type="text" class="input_txt_new" id="address1"  name="address1" maxlength="30"/></td>
    </tr>
    
    <tr>
    <td colspan="2"><span class="text6 ">Address Line 2:</span></td>
    <td><input type="text" class="input_txt_new" id="address2" name="address2" maxlength="30" /></td>
	</tr>
	<tr>
    <td colspan="2"><span class="text6 ">Address Line 3:</span></td>
    <td><input type="text" class="input_txt_new" id="address3" name="address3" maxlength="30" /> </td>
    </tr>
	<tr>
	<td colspan="2"><span class="text6 ">City:</span> <span class="star">* </span></td>
	<td><input type="text" class="input_txt_new" id="city" name="city"/></td>
	</tr>
	<tr>
	  <td colspan="2"><span class="text6 ">Country:</span> <span class="star"> * </span></td>
	  <td>
      <select name="country" id="country" class="input_txt_new">
        <?php 
		$query = $conn ->query("SELECT * FROM country_master where country_code='IN'");
		while($result= $query->fetch_assoc()){
		?>
        <option value="<?php echo $result['country_code'];?>" <?php if($result['country_code']=="IN"){?> selected="selected" <?php } ?>><?php echo $result['country_name'];?></option>
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
		$query = $conn ->query("SELECT * from state_master WHERE country_code = 'IN'");
		while($result= $query->fetch_assoc()){ ?>
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
	  <td><input type="text" class="input_txt_new" id="landline_no1" name="landline_no1" maxlength="10"/></td>
	  </tr>
	<tr >
	  <td colspan="2"><span class="text6 ">Mobile No.:</span> <span class="star"> * </span></td>
	  <td><input type="text" class="input_txt_new" id="mobile_no" name="mobile_no"  maxlength="10"/></td>
	</tr>
	<tr>
	  <td colspan="2"><span class="text6 ">Email:</span> <span class="star"> * </span></strong></td>
	  <td><input type="text" class="input_txt1" id="email_id" name="email_id"/></td>
	</tr>
	
	<?php
	if($type_of_firm==13 || $type_of_firm==12){
	?>
	<tr>
	<td colspan="2"><span class="text6 ">DIN No.:</td>
	<td><input type="text" class="input_txt1" id="din_no" name="din_no" /></td>
	</tr><?php } ?>
	
	<tr style="display:none;" id="basedonpan">
	<td colspan="2"><span class="text6 ">PAN:</td>
	<td><input type="text" class="input_txt1" id="pan_no" name="pan_no" maxlength="10"/></td>
	</tr>
	
	<tr style="display:none;" id="basedontype5">
			<tr><td colspan="2"><span class="text6 ">Aadhar No :</td>
			<td><input type="text" class="input_txt1" id="aadhar_no" name="aadhar_no" value="<?php echo $aadhar_no;?>" maxlength="15" placeholder="Aadhar No" autocomplete="off"></td></tr>
			<tr>
			<td colspan="2"><span class="text6 ">Passport No. :</td>
			<td><input type="text" class="input_txt1" id="passport_no" name="passport_no" value="<?php echo $passport_no;?>" maxlength="10" placeholder="Passport No" autocomplete="off"></td></tr>
			<tr>
			<td colspan="2"><span class="text6 ">Joining Date :</td>
			<td><input type="date" class="input_txt1" value="<?php echo $joining_date;?>" id="joining_date" name="joining_date" placeholder="Joining Date" autocomplete="off"/></td>
			</tr><tr><td colspan="2"><span class="text6 ">Retirement Date :</td>
			<td><input type="date" class="input_txt1" value="<?php echo $retirement_date;?>" id="retirement_date" name="retirement_date" placeholder="Retirement Date" autocomplete="off"/></td></tr>
	</tr>
	<div style="display:none;" id="basedontype2">
	<tr>
	<td colspan="2"><span class="text6 ">GSTIN:</td>
	<td><input type="text" class="input_txt1" id="gst_no" name="gst_no" maxlength="15"/></td>
	</tr>
	</div>
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
    <tr>
    <td colspan="8"><strong class="text6">Panel Details: <span class="star">*</span><span id="panel_msg" class="star"></span></strong></td>
    </tr> 
    <tr>
    <td colspan="2" align="center"> 
	<div align="left">
    <input type="radio" name="panel_name" id="panel_name" value="Coloured Gemstones" <?php if($panel_name=='Coloured Gemstones'){echo "checked='checked'";}?>/>
    </div>
	</td>
    <td width="46%"><span class="text6 ">Coloured Gemstones</span></td>
    <td colspan="2" align="center"> 
	<div align="left">
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
    
    <tr>
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
    
    <tr>
    <td colspan="2" align="center"> <div align="left">
    <input type="radio" name="panel_name" id="panel_name" value="Other Precious Metal Jewellery" <?php if($panel_name=='Other Precious Metal Jewellery'){echo "checked='checked'";}?>/>
    </div></td>
    <td width="46%"><span class="text6 ">Other Precious Metal Jewellery</span></td>
    
    <td colspan="2" align="center"> <div align="left">
      <input type="radio" name="panel_name" id="panel_name" value="Silver Jewellery" <?php if($panel_name=='Silver Jewellery'){echo "checked='checked'";}?>/>
    </div></td>
    <td width="46%"><span class="text6 ">Silver Jewellery</span></td>
    </tr>
	
	<tr>
    <td colspan="2" align="center"> <div align="left">
    <input type="radio" name="panel_name" id="panel_name" value="SEZ" <?php if($panel_name=='SEZ'){echo "checked='checked'";}?>/>
    </div></td>
    <td width="46%"><span class="text6 ">SEZ</span></td>
    
    <td colspan="2" align="center"> <div align="left">
      <input type="radio" name="panel_name" id="panel_name" value="Studded Jewellery" <?php if($panel_name=='Studded Jewellery'){echo "checked='checked'";}?>/>
    </div></td>
    <td width="46%"><span class="text6 ">Studded Jewellery</span></td>
    </tr>
	
	<tr>
    <td colspan="2" align="center">
	<div align="left">
    <input type="radio" name="panel_name" id="panel_name" value="Lab Grown Diamond" <?php if($panel_name=='Lab Grown Diamond'){ echo "checked='checked'";}?>/>
    </div>
	</td>
    <td width="46%"><span class="text6">Lab Grown Diamond</span></td>
    </tr>
	<?php if($panel_name=='Lab Grown Diamond'){ ?>
	<tr>
    <td colspan="13" class="text6" >
    <span class="style6">I/We <b><?php echo strtoupper(str_replace('&amp;', '&', getNameCompany($registration_id,$conn))); ?> </b>do hereby confirm my/our business interests and trading in Lab-grown diamonds and based on such business done by us do hereby affirm my/our membership registration in the Lab-Grown Diamond Panel of the Council.I/We am/are fully aware of the demarcation and the independent functioning of the new Lab-grown Diamond Panel as compared to the existing Diamond Panel of the Council. Further, it is stated that I/we shall avoid any scenario of possible conflict of interest with the functioning of the existing Diamond Panel of the Council.</span><br/>
    </td>
    </tr>
	<?php } ?>
	
  </table>
      </div>
      
<!--<div class="content_details1">
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
</div>-->
					<?php 
					 //echo $member_type_id;
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
      <input type="checkbox" name="list_of_document[]" id="list_of_document" value="Partnership deed" <?php if(preg_match('/Partnership deed/',$list_of_document)){ echo ' checked="checked"'; } ?> <?php if($flag==3){ ?> disabled="disabled" <?php }?>>
    </div></td>
    <td width="46%"><span class="text6 ">Partnership deed</span></td>
	<td align="center"> <div align="left">
      <input type="checkbox" name="list_of_document[]" id="list_of_document" value="aadhar" <?php if(preg_match('/aadhar/',$list_of_document)){ echo ' checked="checked"'; } ?> <?php /*if($flag==1 || $flag==2|| $flag==3){ ?> disabled="disabled" <?php }*/?>>
    </div></td>
    <td width="46%"><span class="text6 ">Aadhar of Proprietors/ Partners / Directors</span></td>
    </tr>
	<tr>
    <td align="center"> <div align="left">
      <input type="checkbox" name="list_of_document[]" id="list_of_document" value="passport" <?php if(preg_match('/passport/',$list_of_document)){ echo ' checked="checked"'; } ?> <?php /*if($flag==1 || $flag==2|| $flag==3){ ?> disabled="disabled" <?php }*/?>>
    </div></td>
    <td width="46%"><span class="text6 ">Passport of Proprietors/ Partners / Directors</span></td>
    </tr>
    
    <tr>
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
	
	<tr bgcolor="#CCCCCC">
    <td align="center"> <div align="left">
     <input type="checkbox" name="export_product_name[]" id="export_product_name" value="Lab Grown Diamond" <?php if(preg_match('/Lab Grown Diamond/',$export_product_name)){ echo 'checked="checked"'; } ?>>
    </div></td>
    <td width="46%"><span class="text6 ">Lab Grown Diamond</span></td>
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

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
<script type="text/javascript">
/* Delta Single BP Creation */
$(".sap").click(function() {
	values = $(this).attr('class');
	x = values.split(' ');
	single_id = x[1];
	registration_id = x[2];
	member = x[3]; 
	
	if (confirm("Are you sure you want to Create BP")) {
		$.ajax({
		url: "create_delta_bp_api.php",
		method:"POST",
		data:{single_id:single_id,registration_id:registration_id,member:member},
		type: "POST",
		beforeSend: function() {
        	$("#overlay").show();
    	},
		success:function(data)
		{ 
			//console.log(data); exit;
			if($.trim(data)==1){
				alert("BP successfully Created..");
				window.location.reload(true);
			}else{
				alert("Sorry There is some problem with SAP response");
				window.location.reload(true);		
			}
			console.log(data);
		},
		});
	}	  
});

/*.......................Address Update..............................*/
$(".delta").click(function() {
/*	var values = $(this).data('url').split(" ");
	var registration_id=values[0];
	var address_id=values[1];*/
	//alert(registration_id);return false;
	values = $(this).attr('class');
	x = values.split(' ');	
	var registration_id=x[1];// alert(registration_id);
	var address_id=x[2];
	
	
/*	values = $(this).attr('class'); 
	x = values.split(' ');	
	var registration_id=x[0];
	var address_id=x[1]; */
	
	if (confirm("Are you sure you want to update this address with Delta API")) {
		$.ajax({
		url: "address_delta_api.php",
		method:"POST",
		data:{registration_id:registration_id,address_id:address_id},
		type: "POST",
		beforeSend: function() {
        	$("#overlay").show();
    	},
		success:function(data)
		{
			//console.log(data); exit;
			if($.trim(data)==1){
				alert("Address Updated successfully..");; 
				window.location.href = "communication_form.php?registration_id="+registration_id;
			}else{
				alert("Sorry There is some problem with SAP response"); 
				window.location.href = "communication_form.php?registration_id="+registration_id;
			
			}
		},
		});
	}	  
});

/* KYC PUSH TO SAP */
$(".kyc").click(function() {
	values = $(this).attr('class');
	x = values.split(' ');
	id = x[1];
	registration_id = x[2];
	if (confirm("Are you sure you want to Push to Kyc")) {
		$.ajax({
		url: "push_to_kyc.php",
		method:"POST",
		data:{id:id,registration_id:registration_id},
		type: "POST",
		beforeSend: function() {
        	$("#overlay").show();
    	},
		success:function(data)
		{ 
			//console.log(data); exit;
			if($.trim(data)==1){
				alert("BP successfully Pushed To Kyc..");
				window.location.reload(true);
			}else{
				alert("Sorry There is some problem with SAP response");
				window.location.reload(true);		
			}
			console.log(data);
		},
		});
	}	  
});

/*.......................Address Cancellation ..............................*/
$(".cancellation").click(function() {
	values = $(this).attr('class');
	x = values.split(' ');	
	var registration_id=x[1]; alert(registration_id);
	var address_id=x[2]; alert(address_id);
	
	if (confirm("Are you sure you want to cancel this address with Delta API")) {
		$.ajax({
	//	url: "address_delta_api.php",
		method:"POST",
		data:{registration_id:registration_id,address_id:address_id},
		type: "POST",
		beforeSend: function() {
        	$("#overlay").show();
    	},
		success:function(data)
		{
			console.log(data); exit;
			if($.trim(data)==1){
				alert("Address Cancelled successfully..");; 
				window.location.href = "communication_form.php?registration_id="+registration_id;
			}else{
				alert("Sorry There is some problem with SAP response"); 
				window.location.href = "communication_form.php?registration_id="+registration_id;
			
			}
		},
		});
	}	  
});
</script>
<div id="overlay"></div>
<style>
#overlay {
    position: fixed;
    display: none; 
    width: 100%; 
    height: 100%; 
    top: 0; 
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,0.8);
z-index:999;}  	
</style>

<style>
.modal {
    display: none; 
    position: fixed; 
    z-index: 1; 
    padding-top: 100px; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgb(0,0,0); 
    background-color: rgba(0,0,0,0.4);    
}
@keyframes modalFade {
  from {transform: translateY(-50%);opacity: 0;}
  to {transform: translateY(0);opacity: 1;}
}

.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
     animation-name: modalFade;
  animation-duration: .6s;
}
.modal_inner_content{margin: 20px 10px;}

.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
.form-horizontal{border: 1px solid #ccc;padding: 25px;margin-top: 10px;}
.form-control{width: 100%;margin-bottom: 15px;}
.form-control label{width: 150px;display: inline-block;}
.form-control input{width: auto;}
</style>
</body>
</html>