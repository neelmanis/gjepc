<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php 
	  $membertype=$_SESSION['MEMBERTYPE'];
	  if($membertype=="Agent"){
		$APPLICANT_ID=$_SESSION['AGENT_ID'];
		$AGENT_ID=$_SESSION['AGENT_ID'];
	  }
	  else if($membertype=="Member"){
		$APPLICANT_ID=$_SESSION['MEMBER_ID'];
		$APP_AMOUNT="500";
		$TOTAL_AMOUNT="590";
	  }
	  else if($membertype=="NonMember"){
		$APPLICANT_ID=$_SESSION['NON_MEMBER_ID']; 
		$APP_AMOUNT="1500";
		$TOTAL_AMOUNT="1770";
	  }

?>

<?php 
if (($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$contact_name=addslashes($_REQUEST['contact_name']);
	$address=addslashes($_REQUEST['address']);
	$mobile_no=addslashes($_REQUEST['mobile_no']);
	$email_id=addslashes($_REQUEST['email_id']);
	$password=addslashes($_REQUEST['password']);
	$role=addslashes($_REQUEST['role']);
	$region_id=addslashes($_REQUEST['region_id']);
	$id=$_REQUEST['id'];	

	echo"<meta http-equiv=refresh content=\"0;url=manage_admin.php?action=view\">";
}
?>
<!--.......Update Action.........  -->
<?php 
$EXPORT_APP_ID=$_REQUEST['EXPORT_APP_ID'];
$sql="select * from kp_export_application_master where EXPORT_APP_ID='$EXPORT_APP_ID'";
$query=mysql_query($sql);
$result=mysql_fetch_array($query);
$EXPORT_APP_ID=$result['EXPORT_APP_ID'];
$PROCES_CNTR=$result['PROCES_CNTR'];
if(isset($_SESSION['MEMBER_ID'])){$MEMBER_ID=$_SESSION['MEMBER_ID'];}else{$MEMBER_ID=$result['MEMBER_ID'];}

$COUNTRY_DEST_ID=$result['COUNTRY_DEST_ID'];
$INVOICE_NO=$result['INVOICE_NO'];
$INVOICE_DATE=$result['INVOICE_DATE'];
$NUMBER_OF_PARCELS=$result['NUMBER_OF_PARCELS'];
$TOTAL_WGHT=$result['TOTAL_WGHT'];
$FEES_AMOUNT=intval($result['FEES_AMOUNT']);
$COURIER_AMOUNT =intval($result['COURIER_AMOUNT']);
$TOTAL_AMOUNT=intval($result['TOTAL_AMOUNT']);
$IE_PARTY_NAME =$result['IE_PARTY_NAME'];
$IE_PARTY_ID =$result['IE_PARTY_ID '];
$IE_ADDRESS1=$result['IE_ADDRESS1'];
$IE_ADDRESS2=$result['IE_ADDRESS2'];
 
$IE_COUNTRY_ID=$result['IE_COUNTRY_ID'];
$IE_COUNTRY=$result['IE_COUNTRY'];
$IE_CITY=$result['IE_CITY'];
$IE_PIN=$result['IE_PIN'];
$IE_TEL1=$result['IE_TEL1'];
$IE_TEL2=$result['IE_TEL2'];
$IE_FAX=$result['IE_FAX'];
$M_ADD_SR_NO=$result['M_ADD_SR_NO'];
$M_COMPANY_NAME=$result['M_COMPANY_NAME'];
$M_ADDRESS=$result['M_ADDRESS'];

$M_COUNTRY_ID=$result['M_COUNTRY_ID'];
$M_CITY_ID=$result['M_CITY_ID'];
$M_CITY=$result['M_CITY'];
$M_STATE=$result['M_STATE'];
$M_PIN=$result['M_PIN'];
$M_COUNTRY=$result['M_COUNTRY'];
$C_COMPANY_NAME =$result['C_COMPANY_NAME'];
$C_ADDRESS1=$result['C_ADDRESS1'];
$C_ADDRESS2=$result['C_ADDRESS2'];
$C_ADDRESS3=$result['C_ADDRESS3'];
$C_COUNTRY=$result['C_COUNTRY'];
$C_CITY=$result['C_CITY'];
$C_FAX=$result['C_FAX'];
$C_PIN=$result['C_PIN'];
$C_TELEPHONE1 =$result['C_TELEPHONE1'];
$C_TELEPHONE2 =$result['C_TELEPHONE2'];
$PAYMENT_CHECK =$result['PAYMENT_CHECK '];
$PAYMENT_SENT =$result['PAYMENT_SENT'];
$PICKUP_TYPE  =$result['PICKUP_TYPE'];
$KP_CERT_NO =$result['KP_CERT_NO'];
$KP_HS_CODE1 =$result['KP_HS_CODE1'];
$USD_AMOUNT  =$result['USD_AMOUNT'];
$LOC_PICKUP_ID =$result['LOC_PICKUP_ID'];
$AGENT_MEM_LINK_ID  =$result['AGENT_MEM_LINK_ID'];
$LOC_PICKUP_ID =$result['LOC_PICKUP_ID'];
$LOC_PICKUP_ID =$result['LOC_PICKUP_ID'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to GJEPC</title>

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
$("#Member").live('change', function(){
var Member_id=$("#Member").val();
//alert(Member_id);return false;
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=getAddress&Member_id="+Member_id,
					dataType:'html',
					beforeSend: function(){
								$('#loading').show();
							},
					success: function(data){
								//alert(data);
								var data=data.split("|");
								var x=$.trim(data[0]);
								var y=$.trim(data[1]);
								
							    $("#M_ADD_SR_NO").html(y);  
							    $('#M_COMPANY_NAME').val("");
								$('#M_ADDRESS').val("");
								$('#M_CITY').val(""); 
								$('#M_STATE').val("");
								$('#M_PINCODE').val("");
								$('#M_COUNTRY').val("");
								$('#show_member_type').html(x.toUpperCase());
								$('#loading').hide();
								if(x=="member")
								{
									$("#FEES_AMOUNT").val("500")
									$("#TOTAL_AMOUNT").val("590");
								} 
								else if(x=="nonmember")
								{
									$("#FEES_AMOUNT").val("1500");
									 $("#TOTAL_AMOUNT").val("1770");
								}
							}
		});
 });
</script>

<script>
$("#M_ADD_SR_NO").live('change', function(){
var M_ADD_SR_NO=$("#M_ADD_SR_NO").val();
var mem_x=$("#Member").val();
var mem_y=$("#Member1").val();
if (!mem_x){Member_id=mem_y;}
else{Member_id=mem_x;}
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=getAddressDetail&Member_id="+Member_id+"&M_ADD_SR_NO="+M_ADD_SR_NO,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
								//alert(data);
							   var data=data.split("#");
								$('#M_COMPANY_NAME').val(data[0]);
								$('#M_ADDRESS').val(data[1]);
								$('#M_CITY').val(data[2]); 
								$('#M_STATE').val(data[3]);
								$('#M_PIN').val(data[4]);
								$('#M_COUNTRY').val(data[5]);
							}
		});
 });
</script>
<script type='text/javascript' src='js/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="css/jquery.autocomplete.css" />
<script type="text/javascript">
$().ready(function() {
	$("#Exporter_Name").autocomplete("get_exporter_list.php", { 
		width: 260,
		matchContains: true,
		mustMatch: true,
		extraParams: {
                    c_id: function() {return $('#COUNTRY_DEST_ID').val()}
                    
                },
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
	$("#Exporter_Name").result(function(event, data, formatted) {
		$("#PARTY_ID").val(data[1]);
		$("#IE_PARTY_NAME").val(data[2]);
		$("#IE_ADDRESS1").val(data[3]);
		$("#IE_ADDRESS2").val(data[4]);
		$("#IE_TEL1").val(data[5]);
		$("#IE_TEL2").val(data[6]);
		$("#IE_FAX").val(data[7]);
		$("#IE_CITY").val(data[8]);
		$("#IE_PIN").val(data[9]);
		$("#IE_COUNTRY").val(data[10]);
	});
	
	$("#new_c").click(function(){
		//alert(11);
		if($('input[name="new_c"]:checked').val()=='1')
		{
			//alert(11);
			$("#IE_PARTY_NAME").removeAttr('readonly');
			$("#IE_ADDRESS1").removeAttr('readonly');
			$("#IE_ADDRESS2").removeAttr('readonly');
			$("#IE_ADDRESS3").removeAttr('readonly');
			$("#IE_TEL1").removeAttr('readonly');
			$("#IE_TEL2").removeAttr('readonly');
			$("#IE_FAX").removeAttr('readonly');
			$("#IE_CITY").removeAttr('readonly');
			$("#IE_PIN").removeAttr('readonly');
			$("#IE_COUNTRY").removeAttr('readonly');
			$("#Exporter_Name").attr('readonly','true');
		
			
		}else
		{
			$("#IE_PARTY_NAME").attr('readonly','true');
			$("#IE_ADDRESS1").attr('readonly','true');
			$("#IE_ADDRESS2").attr('readonly','true');
			$("#IE_ADDRESS3").attr('readonly','true');
			$("#IE_TEL1").attr('readonly','true');
			$("#IE_TEL2").attr('readonly','true');
			$("#IE_FAX").attr('readonly','true');
			$("#IE_CITY").attr('readonly','true');
			$("#IE_PIN").attr('readonly','true');
			$("#IE_COUNTRY").attr('readonly','true');
			$("#Exporter_Name").removeAttr('readonly');
		}

	});
});
</script>

<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	$('#INVOICE_DATE').datepick();
	$('#inlineDatepicker').datepick({onSelect: showDate});
	$('#popupDatepicker').datepick();
	$('#popupDatepicker1').datepick();
	$('#popupDatepicker2').datepick();
	$('#inlineDatepicker1').datepick({onSelect: showDate});
});
function showDate(date) {
	alert('The date chosen is ' + date);}
</script>

<script>
$("#PAYMENT_MODE").live('change', function(){
var selectedVal = "";
var selected = $("input[type='radio'][name='PAYMENT_MODE']:checked");
if (selected.length > 0)
    selectedValue = selected.val();
	if(selectedValue=="Courier")
	{
		$("#C_COMPANY_NAME").removeAttr("readonly");
		$("#C_ADDRESS1").removeAttr("readonly");
		$("#C_ADDRESS2").removeAttr("readonly");
		$("#C_COUNTRY").removeAttr("readonly");
		$("#C_ADDRESS3").removeAttr("readonly");
		$("#C_CITY").removeAttr("readonly");
		$("#C_PIN").removeAttr("readonly");
		$("#C_TELEPHONE1").removeAttr("readonly");
		$("#C_TELEPHONE2").removeAttr("readonly");
		$("#C_FAX").removeAttr("readonly");
		$("#COURIER_AMOUNT").removeAttr("readonly");
		
		$("#PAYMENT_MODE_CHECK").removeAttr("disabled"); 
		
		 $("#COURIER_AMOUNT").val("310");
		 var tot=$("#FEES_AMOUNT").val();
		 
		 tot_amnt=parseInt(tot)+parseInt(310);
		 var tax_amnt=(tot_amnt*18/100);
		 tot_amnt=Math.round(tot_amnt+tax_amnt);
		 $("#TOTAL_AMOUNT").val(tot_amnt);
	}
	if(selectedValue=="Self")
	{
		$("#C_COMPANY_NAME").val("");
		$("#C_ADDRESS1").val("");
		$("#C_ADDRESS2").val("");
		$("#C_COUNTRY").val("");
		$("#C_CITY").val("");
		$("#C_PIN").val("");
		$("#C_TELEPHONE1").val("");
		$("#C_TELEPHONE2").val("");
		$("#C_FAX").val("");
		
		$('#C_COMPANY_NAME').attr('readonly', true);
		$('#C_ADDRESS1').attr('readonly', true);
		$('#C_ADDRESS2').attr('readonly', true);
		$('#C_COUNTRY').attr('readonly', true);
		$('#C_CITY').attr('readonly', true);
		$("#C_STATE").attr('readonly',true);
		$('#C_TELEPHONE1').attr('readonly', true);
		$('#C_TELEPHONE2').attr('readonly', true);
		$('#C_FAX').attr('readonly', true);
		$('#PAYMENT_MODE_CHECK').attr('checked', false);
		$("#PAYMENT_MODE_CHECK").attr("disabled", "disabled"); 
		$("#COURIER_AMOUNT").val("");
		
		 var tot=$("#FEES_AMOUNT").val();
		 z=tot*18/100;
		 var tot_amnt=parseInt(tot)+parseInt(z);
		 $("#TOTAL_AMOUNT").val(tot_amnt);
	}
});
</script>

<script>
$("#PAYMENT_MODE_CHECK").live('change', function(){
var selectedVal = "";
var selected = $("input[name='PAYMENT_MODE_CHECK']:checked");
    selectedValue = selected.val();
	if(selectedValue=="same")
	{   
		$('#C_COMPANY_NAME').val($('#M_COMPANY_NAME').val());
		$('#C_ADDRESS1').val($('#M_ADDRESS').val());
		$('#C_COUNTRY').val($('#M_COUNTRY').val()); 
		$('#C_CITY').val($('#M_CITY').val());
		$("#C_STATE").val($('#M_STATE').val());
	    $("#C_STATE").val($('#M_STATE').val()); 
		$("#C_PIN").val($('#M_PIN').val());
	}
});
</script>

<script>
$("#imp_exp_trns_detail").live('click', function(){
var HS_CODE_ID=$('#HS_CODE_ID').val();
var WEIGHT=$('#WEIGHT').val();
var COUNTRY_ID=$('#COUNTRY_ID').val();
var AMOUNT=$('#AMOUNT').val();
var APPLICANT_ID=$('#APPLICANT_ID').val();

if(HS_CODE_ID==""){alert("Please select HS Code");return false;}
if(WEIGHT==""){alert("Please enter weigth");return false;}
if(COUNTRY_ID==""){alert("Please select origin country name");return false;}
if(AMOUNT==""){alert("Please enter amount");return false;}

	$.ajax({ type: 'POST',
			url: 'ajax.php',
			data: "actiontype=addIEDetail&HS_CODE_ID="+HS_CODE_ID+"&WEIGHT="+WEIGHT+"&COUNTRY_ID="+COUNTRY_ID+"&AMOUNT="+AMOUNT+"&APPLICANT_ID="+APPLICANT_ID,
			dataType:'html',
			beforeSend: function(){
			},
			success: function(data){
						//alert(data);
						$('#HS_CODE_ID').val("");
						$('#WEIGHT').val("");
						$('#COUNTRY_ID').val("");
						$('#AMOUNT').val("");
					    $("#expimp_temp_tran_detail").html(data);
					}
		});
});
</script>


<script>
$("#delete_hs_code").live('click', function(){
var chks = document.getElementsByName('HS_CODE_APP_ID[]');
	var hasChecked = false;
	for (var i = 0; i < chks.length; i++)
	{
		if (chks[i].checked)
	{
	hasChecked = true;
	break;
	}
	}
	
	if (hasChecked == false)
	{
	alert("Please select at least one.");
	return false;
	}

   var allVals = [];
   $("input[name='HS_CODE_APP_ID[]']:checked").each( function () {
       allVals.push($(this).val());
   });
   var APPLICANT_ID=$('#APPLICANT_ID').val();
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=deleteHscode&HS_CODE_APP_ID="+allVals+"&APPLICANT_ID="+APPLICANT_ID,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
						//alert(data);
						$("#expimp_temp_tran_detail").html(data);
						}
		});
 });
</script>
<script>
function calculate()
{
	 var courier_amount=$("#COURIER_AMOUNT").val();
	 if(isNaN(courier_amount))
	 {
	 	alert("please enter number only");
		$("#COURIER_AMOUNT").focus();
	 }
	 var tot=$("#FEES_AMOUNT").val();
	 z=parseInt(tot)+parseInt(courier_amount);
	 var tax_amnt=(z*12.36/100);
	 tot_amnt=parseInt(tot)+parseInt(tax_amnt)+parseInt(courier_amount);
	 
	 $("#TOTAL_AMOUNT").val(tot_amnt);
}


</script>

<script language="javascript">


$(document).ready(function(){
		var selElem = document.getElementById('Member');
        var tmpAry = new Array();
        for (var i=0;i<selElem.options.length;i++) {
            tmpAry[i] = new Array();
            tmpAry[i][0] = selElem.options[i].text;
            tmpAry[i][1] = selElem.options[i].value;
        }
        tmpAry.sort();
		//alert(selElem.options.length);
        while (selElem.options.length > 0) {
			//alert(selElem.options[0]);
			//break;
            selElem.options[0] = null;
        }
        for (var i=0;i<tmpAry.length;i++) {
            var op = new Option(tmpAry[i][0], tmpAry[i][1]);
            selElem.options[i] = op;
        }

});
</script>
<script type="text/javascript">
function validate()
{
 var membertype = "<?php echo $membertype;?>";
  if(membertype=="Agent")
  {
  	if(document.getElementById('Member').value=="")
	  {
		  alert("Please select member type!");
		  document.getElementById('Member').focus();
		  return false;
	  }
	if(document.getElementById('M_ADD_SR_NO').value=="")
	{
	  alert("Please select address!");
	  document.getElementById('M_ADD_SR_NO').focus();
	  return false;
	}
   }
  	if(document.getElementById('COUNTRY_DEST_ID').value=="")
  	{
	  alert("Please select country of provinance!");
	  document.getElementById('COUNTRY_DEST_ID').focus();
	  return false;
  	}
  if(document.getElementById('NUMBER_OF_PARCELS').value=="")
  {
	  alert("Please enter number of parcels!");
	  document.getElementById('NUMBER_OF_PARCELS').focus();
	  return false;
  }
  
  if(document.getElementById('KP_CERT_NO').value=="")
  {
	  alert("Please enter certifciate no.!");
	  document.getElementById('KP_CERT_NO').focus();
	  return false;
  }
  if(document.getElementById('popupDatepicker').value=="")
  {
	  alert("Please select certificate issue date!");
	  document.getElementById('popupDatepicker').focus();
	  return false;
  }
  if(document.getElementById('popupDatepicker1').value=="")
  {
	  alert("Please select certificate expiry date!");
	  document.getElementById('popupDatepicker1').focus();
	  return false;
  }
  if(document.getElementById('INVOICE_NO').value=="")
  {
	  alert("Please invoice no!");
	  document.getElementById('INVOICE_NO').focus();
	  return false;
  }
  if(document.getElementById('popupDatepicker2').value=="")
  {
	  alert("Please invoice date!");
	  document.getElementById('popupDatepicker2').focus();
	  return false;
  }
  if(document.getElementById('PROCES_CNTR').value=="")
  {
	  alert("Please select proccessing location");
	  document.getElementById('PROCES_CNTR').focus();
	  return false;
  }
  
	var HS_CODE_APP_ID = document.getElementsByName('HS_CODE_APP_ID[]');
	if(HS_CODE_APP_ID.length=="0"){
		alert("Please add at-least a Carat value");
		document.getElementById('HS_CODE_ID').focus();
		return false;
	}
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
	<div class="breadcome"><a href="admin.php">Home</a></div>
</div>

<div id="main">
	<div class="content">
<?php 
if(($_REQUEST['action']=='add') || ($_REQUEST['action']=='edit'))
{
  $action='save';
  if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
  {
		$action='update';
		$result2 = mysql_query("SELECT *  FROM kp_admin_master  where id='$_REQUEST[id]'");
		if($row2 = mysql_fetch_array($result2))
		{
			
			$contact_name=stripslashes($row2['contact_name']);
			$address=stripslashes($row2['address']);
			$mobile_no=stripslashes($row2['mobile_no']);
			$email_id=stripslashes($row2['email_id']);
			$password=stripslashes($row2['password']);
			$role=stripslashes($row2['role']);
			$admin_access=$row2['admin_access'];
			$region_id=stripslashes($row2['region_id']);
		}
  }
?>
 
<div class="content_details1 ">
<form action="import_application_inc.php" method="post" name="form1" id="form1" onSubmit="return validate()" enctype="multipart/form-data">
<!-- Right Table --> 
<div class="righttable_css">

<div class="clear"></div>

<!-- div -->

<div class="search_app_div">
<strong>Application for endorsment of Kimberley process certificate for IMPORT of rough diamonds into India</strong>
<div class="clear"> </div>
</div>
<?php if(isset($_SESSION['AGENT_ID'])){
$sql="select MEMBER_ID,NON_MEMBER_ID from  kp_agent_member_link where AGENT_ID='".$_SESSION['AGENT_ID']."' order by MEMBER_ID asc";
?>
<div class="search_app_div">
<div class="search_app_text1">Member:</div><span id="show_member_type"></span><span id="loading" style="display:none"><img src="images/loading.gif" /></span>
<div class="search_app_bg_new11">
<select  class="search_app_bg_new11_text" name="Member" id="Member">
<option selected="selected" value="">--Select--</option>
<?php 
	   $sql="select MEMBER_ID,NON_MEMBER_ID from  kp_agent_member_link where AGENT_ID='".$_SESSION['AGENT_ID']."' order by MEMBER_ID,NON_MEMBER_ID asc";
	   $result=mysql_query($sql);
	   while($rows=mysql_fetch_array($result))
	   {
	   		if($rows['MEMBER_ID']!="")
			{	
				$member_name=getMemberName("Member",$rows[MEMBER_ID]);
				if($member_name!=""){
?>
<option  value="member|<?php echo $rows['MEMBER_ID'];?>" <?php if($rows['MEMBER_ID']==$MEMBER_ID){echo "selected='selected'";}?>><?php echo getMemberName("Member",$rows['MEMBER_ID']);?></option>
<?php 
				}
			}
			else if($rows['NON_MEMBER_ID']!="")
			{
				$non_member_name=getNonMemberName("NonMember",$rows[MEMBER_ID]);
?>
<option  value="nonmember|<?php echo $rows['NON_MEMBER_ID'];?>" <?php if($rows['MEMBER_ID']==$MEMBER_ID){echo "selected='selected'";}?>><?php echo getNonMemberName("NonMember",$rows['NON_MEMBER_ID']);?></option>
<?php
		}
	 }
?>
</select>
<input type="hidden" name="AGENT_ID" id="AGENT_ID" value="<?php echo $AGENT_ID;?>"/>
</div>
<div class="clear"> </div>
</div>
<?php }?>
<div class="search_app_div">
Please fill up the Import Application Form below and submit it after attaching the requirement attachments.
</div>
<input type="hidden" name="EXPORT_APP_ID" id="EXPORT_APP_ID" value="<?php echo $EXPORT_APP_ID;?>"/>
<?php if(isset($_SESSION['AGENT_ID']) || isset($_SESSION['MEMBER_ID'])){?>
<input type="hidden" name="Member1" id="Member1" value="<?php echo "member|".$_SESSION['MEMBER_ID'];?>"/>
<div class="search_app_div">
<div class="search_app_text1">Address:</div>
<div class="search_app_bg_new11">
<select  class="search_app_bg_new11_text" name="M_ADD_SR_NO" id="M_ADD_SR_NO">
<option value="">--select--</option>
<?php
	$query=mysql_query("SELECT * FROM `kp_member_address_details` where MEMBER_ID='".$MEMBER_ID."'");
	while($result=mysql_fetch_array($query)){
?>
<option value="<?php echo $result['MEMBER_ADD_SR_NO'];?>" <?php if($result['MEMBER_ADD_SR_NO']==$M_ADD_SR_NO){?> selected="selected"<?php }?>><?php echo $result['MEMBER_CO_NAME']." ".$result['MEMBER_ADDRESS1']?></option>
<?php }?>
</select>
</div>
<div class="clear"> </div>
</div>
<?php }?>



<?php if(isset($_SESSION['NON_MEMBER_ID'])){
$query=mysql_query("SELECT * FROM `kp_non_member_master` where NON_MEMBER_ID='".$_SESSION['NON_MEMBER_ID']."'");
$result=mysql_fetch_array($query);
$NON_MEMBER_NAME=$result['NON_MEMBER_NAME'];
$ADDRESS1=$result['ADDRESS1'];
$CITY_ID =$result['CITY_ID'];
$STATE_ID=$result['STATE_ID'];
$COUNTRY_ID =$result['COUNTRY_ID'];
$PINCODE =$result['PINCODE'];
}
?>


<div class="search_app_div">
<div class="search_app_text1">Date:</div>
<div class="search_app_bg_new11"><input name="M_DATE" id="M_DATE" class="search_app_bg_new11_text_colo" type="text" value="<?php echo date('Y-m-d');?>" readonly/></div>

<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">Company:</div>
<div class="search_app_bg_new11"><input name="M_COMPANY_NAME" id="M_COMPANY_NAME" class="search_app_bg_new11_text_colo" type="text" readonly value="<?php if($M_COMPANY_NAME!=""){echo $M_COMPANY_NAME;}else {echo $NON_MEMBER_NAME;}?>" /></div>

<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">Address:</div>
<div class="search_app_bg_new11"><input name="M_ADDRESS" id="M_ADDRESS" class="search_app_bg_new11_text_colo" type="text" value="<?php if($M_ADDRESS!=""){echo $M_ADDRESS;}else{echo $ADDRESS1;}?>" readonly /></div>

<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">State:</div>
<div class="search_app_bg_new11">
<select  class="search_app_bg_new11_text" name="M_STATE" id="M_STATE">
<option selected="selected" value="">--Select--</option>
<?php 
$sql="select * from  kp_state_master order by state_name asc";
$result=mysql_query($sql);
while($rows=mysql_fetch_array($result))
{
  if($rows[state_code]==$M_STATE)
	{
		echo "<option  value='$rows[state_code]' selected='selected'>$rows[state_name]</option>";
	}
	else
	{
		echo "<option  value='$rows[state_code]'>$rows[state_name]</option>";
	}
}
?>	
</select>
</div>

<div class="clear"> </div>
</div>

<div class="search_app_div">
    <div class="search_app_text1">City:</div>
    <div class="search_app_bg_new11">
    <input name="M_CITY" class="search_app_bg_new11_text ac_input" id="M_CITY" type="text" value="<?php echo $M_CITY;?>" autocomplete="off" />
    </div>
    <div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">Pincode:</div>
<div class="search_app_bg_new11"><input name="M_PIN" id="M_PIN" class="search_app_bg_new11_text_colo" type="text" readonly value="<?php if($M_PIN!=""){echo $M_PIN;}else {echo $PINCODE;}?>"/></div>

<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">Country:</div>
<div class="search_app_bg_new11">
<select  class="search_app_bg_new11_text" name="M_COUNTRY" id="M_COUNTRY">
<option selected="selected" value="">--Select--</option>
<?php 
$sql="select * from  kp_country_master order by country_name asc";
$result=mysql_query($sql);
while($rows=mysql_fetch_array($result))
{
	if($rows[country_code]==$COUNTRY_ID ||$rows[country_code]==$M_COUNTRY)
	{
		echo "<option  value='$rows[country_code]' selected='selected'>$rows[country_name]</option>";
	}
	else
	{
		echo "<option  value='$rows[country_code]'>$rows[country_name]</option>";
	}
}
?>	
</select>
</div>

<div class="clear"> </div>
</div>

<div class="search_app_div">
<strong>We are enclosing herewith application for endorsment of Kimberley process certificate for Import of rough diamonds into India as per details given below.</strong>
<div class="clear"></div>
</div>

<div class="search_app_div">
<div class="search_app_text1">Country Of Provinance:</div>
<div class="search_app_bg_new11">
<select  class="search_app_bg_new11_text" name="COUNTRY_DEST_ID" id="COUNTRY_DEST_ID">
<option selected="selected" value="">--Select--</option>
<?php 
	   $sql="select * from  kp_country_master order by country_name asc";
	   $result=mysql_query($sql);
	   while($rows=mysql_fetch_array($result))
	   {
	   		if($rows[country_code]==$COUNTRY_DEST_ID)
			{
				echo "<option  value='$rows[country_code]' selected='selected'>$rows[country_name]</option>";
			}
			else
			{
				echo "<option  value='$rows[country_code]'>$rows[country_name]</option>";
			}
	   }
?>	
</select>
</div>

<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">Exporter Name 
(First 3 Letters):</div>
<div class="search_app_bg_new11">
<input name="Exporter_Name" id="Exporter_Name"  class="search_app_bg_new11_text" type="text" value="<?php echo $LONGNAME; ?>" />
<input type="hidden" name="PARTY_ID" id="PARTY_ID" value="<?php echo $PARTY_ID; ?>" />
</div>
<!--<div style="float:left;"><input class="input_find_bt" type="submit" value="Find" /></div>-->

<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">Create New:</div>
<div style="float:left;"><div class="chexbox"><input name="new_c" id="new_c" type="checkbox" value="1" /></div></div>

<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">Importers Name<span>*</span>:</div>
<div class="search_app_bg"><input name="IE_PARTY_NAME" id="IE_PARTY_NAME" class="search_app_bg_text" type="text" readonly value="<?php echo $IE_PARTY_NAME;?>"/></div>

<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">Address1<span>*</span>:</div>
<div class="search_app_bg"><input name="IE_ADDRESS1" id="IE_ADDRESS1" class="search_app_bg_text" type="text" readonly value="<?php echo $IE_ADDRESS1;?>"/></div>
<div class="search_app_text1">Telephone No.<span>*</span>:</div>
<div class="search_app_bg"><input name="IE_TEL1" id="IE_TEL1" class="search_app_bg_text" type="text" readonly value="<?php echo $IE_TEL1;?>" /></div>
<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">Address2:</div>
<div class="search_app_bg"><input name="IE_ADDRESS2" id="IE_ADDRESS2" class="search_app_bg_text" type="text" readonly value="<?php echo $IE_ADDRESS2;?>"/></div>
<div class="search_app_text1">Telephone 2:</div>
<div class="search_app_bg"><input name="IE_TEL2" id="IE_TEL2" class="search_app_bg_text" type="text" readonly value="<?php echo $IE_TEL2;?>" /></div>
<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">Address3:</div>
<div class="search_app_bg"><input name="IE_ADDRESS3" id="IE_ADDRESS3" class="search_app_bg_text" type="text" readonly value="<?php echo $IE_ADDRESS3;?>"/></div>
<div class="search_app_text1">Fax:</div>
<div class="search_app_bg"><input name="IE_FAX" id="IE_FAX" class="search_app_bg_text" type="text" readonly value="<?php echo $IE_FAX;?>"/></div>
<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">City<span>*</span>:</div>
<div class="search_app_bg">
<input name="IE_CITY" class="search_app_bg_new11_text ac_input" id="IE_CITY" type="text" value="" autocomplete="off" />
</div>
<div class="search_app_text1">Pincode:</div>
<div class="search_app_bg"><input name="IE_PIN" id="IE_PIN" class="search_app_bg_text" type="text" readonly/></div>
<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">Country:</div>
<div class="search_app_bg">
<select  class="search_app_bg_text" name="IE_COUNTRY" id="IE_COUNTRY">
<option selected="selected" value="">--Select--</option>
<?php 
	$sql="select * from  kp_country_master order by country_name asc";
	$result=mysql_query($sql);
	while($rows=mysql_fetch_array($result))
	{
		if($rows[country_code]==$IE_COUNTRY)
		{
			echo "<option  value='$rows[country_code]' selected='selected'>$rows[country_name]</option>";
		}
		else
		{
			echo "<option  value='$rows[country_code]'>$rows[country_name]</option>";
		}
	}
?>	
</select>
</div>

<div class="clear"> </div>
</div>


<div class="search_app_div">
<div class="search_app_text1">Number Of Parcels<span>*</span>:</div>
<div class="search_app_bg"><input name="NUMBER_OF_PARCELS" id="NUMBER_OF_PARCELS" class="search_app_bg_text" type="text" value="<?php echo $NUMBER_OF_PARCELS;?>" /></div>
<div class="search_app_text1">KP Certificate No:</div>
<div class="search_app_bg"><input name="KP_CERT_NO" id="KP_CERT_NO" class="search_app_bg_text" type="text" value="<?php echo $KP_CERT_NO;?>" /></div>
<div class="clear"> </div>
</div>

<div class="search_app_div">
    <div class="search_app_text1">Certificate Issue Date<span>*</span>:</div>
    <div class="search_app_bg"><input name="KP_CERT_ISSUE_DATE" id="popupDatepicker" class="search_app_bg_text" type="text" value="<?php echo $DATE_OF_ISSUE;?>" /></div>
    <div class="search_app_text1">Certificate Expiry Date<span>*</span>:</div>
    <div class="search_app_bg"><input name="KP_CERT_EXPIRY_DATE" id="popupDatepicker1" class="search_app_bg_text" type="text" value="<?php echo $DATE_OF_EXPIRY;?>" /></div>
    <div class="clear"> </div>
</div>

<div class="search_app_div">
    <div class="search_app_text1">Invoice No<span>*</span>:</div>
    <div class="search_app_bg"><input name="INVOICE_NO" id="INVOICE_NO" class="search_app_bg_text" type="text" value="<?php echo $INVOICE_NO;?>" /></div>
    <div class="search_app_text1">Invoice Date<span>*</span>:</div>
    <div class="search_app_bg"><input name="INVOICE_DATE" id="popupDatepicker2" class="search_app_bg_text" type="text" value="<?php echo $INVOICE_DATE;?>" /></div>
    <div class="clear"> </div>
</div>

<?php if(!isset($_REQUEST['action'])){?>

<div class="search_app_div">
<div class="search_app_text1">H S Code No<span>*</span>:</div>
<div class="search_app_bg">
<select  class="search_app_bg_text" name="HS_CODE_ID" id="HS_CODE_ID">
<option value="">--Select--</option>
<?php 
	$sql="select * from  kp_hs_code_master";
	$result=mysql_query($sql);
	while($rows=mysql_fetch_array($result))
	{
		echo "<option  value='$rows[LOOKUP_VALUE_ID]'>$rows[HS_CODE]</option>";
	}
?>
</select>
</div>
<div class="search_app_text1">Carat Weight / Mass<span>*</span>:</div>
<div class="search_app_bg"><input name="WEIGHT" id="WEIGHT" class="search_app_bg_text" type="text" /></div>

<div class="clear"> </div>
</div>

<div class="search_app_div">
    <div class="search_app_text1">Country of Origin<span>*</span>:</div>
    <div class="search_app_bg"><select  class="search_app_bg_text" name="COUNTRY_ID" id="COUNTRY_ID">
<option value="">--Select--</option>
<?php 
	$sql="select * from  kp_country_master order by country_name asc";
	$result=mysql_query($sql);
	while($rows=mysql_fetch_array($result))
	{
	echo "<option  value='$rows[country_code]'>$rows[country_name]</option>";
	}
?>
</select></div>
    <div class="search_app_text1">Value in USD<span>*</span>:</div>
    <div class="search_app_bg"><input name="AMOUNT" id="AMOUNT" class="search_app_bg_text" type="text" />
<input type="hidden" name="APPLICANT_ID" id="APPLICANT_ID" value="<?php echo $APPLICANT_ID;?>"/></div>
    <div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1"></div>
<div style="float:left; margin-bottom:4px;"><input class="input_bg" type="button" value="Add" id="imp_exp_trns_detail" name="imp_exp_trns_detail" /></div>
</div>
<div class="clear"></div>


<div class="search_app_div"><div class="clear"> </div>
</div>

<div>
<span id="expimp_temp_tran_detail">
<table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse: collapse; font-size:12px; margin:20px 0 20px 0; border-color:#ccc; " >
  <tr align="center" bgcolor="#EEEEEE">
    <td height="30"><strong>Select</strong></td>
    <td><strong>H S Code Number</strong></td>
    <td><strong>Card Weight / Mass</strong></td>
    <td><strong>Country of Origin</strong></td>
    <td><strong>Values In USD</strong></td>
  </tr>
<?php 
$query=mysql_query("select * from kp_expimp_temp_tran_detail where MEMBER_ID='$APPLICANT_ID'");
$i=0;	
while($result=mysql_fetch_array($query)){
?>

<tr>
    <td align="center"><label><input type="checkbox" name="HS_CODE_APP_ID[]" id="HS_CODE_APP_ID[]" value="<?php echo $result['HS_CODE_APP_ID'];?>" />
    <input type="hidden" name="HS_CODE_APP_ID_temp[]" id="HS_CODE_APP_ID_temp[]" value="<?php echo $result['HS_CODE_APP_ID'];?>"/>
    </label>
    
    </td>
    <td align="center"><?php echo getHSCode($result['HS_CODE_ID']);?></td>
    <td align="center"><?php echo $result['WEIGHT'];?></td>
    <td align="center"><?php echo getOrginCountryName($result['COUNTRY_ID']);?></td>
    <td align="center"><?php echo $result['AMOUNT'];?></td>
    
  </tr>
  <?php $i++;}?>
  <?php if($i>=1){?>
  <tr>
    <td height="30" align="center"><img src="images/delete.png" id="delete_hs_code" style="cursor:pointer;" onClick="return(window.confirm('Are you sure you want to delete?'));";/></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <?php }?>
</table>
</span>

</div>
<?php }?>

<div class="search_app_div">
<div class="search_app_text1">Declaration<span>*</span>:</div>
<div style="float:left; width:25px;"><div class="chexbox"><input name="Declaration" id="Declaration" type="checkbox" value="Y" checked="checked" /></div></div>
<div class="description_text">The diamonds herein invoiced have been purchased from legitimate sources not involved in funding conflict and in compliance with United Nations resolutions. The seller hereby guarantees that these diamond are conflict free, based on personal knowledge and / or written guarantees provided by the supplier of these diamonds.</div>
<div class="clear"> </div>
</div>



<div class="search_app_div">

Please Submit physical copies of the following documents along with the application confirmation to the processing location <br />
1.Copy of KP Certificate <br />
2.Copy of Airway Bill <br />
3.Copy of Duly Signed Invoice of Import under kp 

<div class="clear"> </div>
</div>


<div class="search_app_div">
<div class="search_app_text1">Processing Location<span>*</span>:</div>
<div class="search_app_bg">
<select  class="search_app_bg_text" name="PROCES_CNTR" id="PROCES_CNTR">
<option value="">--Select--</option>
<?php 
$sql="select * from  kp_location_master order by LOCATION_NAME asc";
$result=mysql_query($sql);
while($rows=mysql_fetch_array($result))
{
	if($rows[LOCATION_ID]==$PROCES_CNTR)
	{
		echo "<option  value='$rows[LOCATION_ID]' selected='selected'>$rows[LOCATION_NAME]</option>";
	}
	else
	{
		echo "<option  value='$rows[LOCATION_ID]'>$rows[LOCATION_NAME]</option>";
	}
	//echo "<option  value='$rows[LOCATION_ID]'>$rows[LOCATION_NAME]</option>";
}
?>
</select>
</div>

<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">Create New</div>

<div style=" margin-top:4px;">
<div class="chexbox11"><input name="PAYMENT_MODE" id="PAYMENT_MODE" type="radio" value="Self" <?php if($PICKUP_TYPE=="Self"){?>checked="checked"<?php }?> /></div>
<div style="float:left;">Self</div>
<div class="chexbox11"><input name="PAYMENT_MODE" id="PAYMENT_MODE" type="radio" value="Courier" <?php if($PICKUP_TYPE=="Courier"){?>checked="checked"<?php }?> /></div>
<div style="float:left;">Courier</div>
<div class="chexbox11"><input name="PAYMENT_MODE_CHECK" id="PAYMENT_MODE_CHECK" type="checkbox" value="same" disabled="disabled" /></div>
<div style="float:left;">Same as Above</div>
</div>
<div class="clear"></div>
</div>


<div class="search_app_div">
<div class="search_app_text1">Company Name<span>*</span>:</div>
<div class="search_app_bg"><input name="C_COMPANY_NAME" id="C_COMPANY_NAME" class="search_app_bg_text" type="text" readonly value="<?php echo $C_ADDRESS1;?>" /></div>

<div class="clear"> </div>
</div>


<div class="search_app_div">
<div class="search_app_text1">Address1<span>*</span>:</div>
<div class="search_app_bg"><input name="C_ADDRESS1" id="C_ADDRESS1" class="search_app_bg_text" type="text" readonly value="<?php echo $C_ADDRESS1;?>" /></div>
<div class="search_app_text1">Telephone No.<span>*</span>:</div>
<div class="search_app_bg"><input name="C_TELEPHONE1" id="C_TELEPHONE1" class="search_app_bg_text" type="text" readonlyvalue="<?php echo $C_TELEPHONE1;?>" /></div>
<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">Address2:</div>
<div class="search_app_bg"><input name="C_ADDRESS2" id="C_ADDRESS2" class="search_app_bg_text" type="text" readonly value="<?php echo $C_ADDRESS2;?>" /></div>
<div class="search_app_text1">Telephone 2:</div>
<div class="search_app_bg"><input name="C_TELEPHONE2" id="C_TELEPHONE2" class="search_app_bg_text" type="text" readonly value="<?php echo $C_TELEPHONE2;?>"/></div>
<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">Address3:</div>
<div class="search_app_bg"><input name="C_ADDRESS3" id="C_ADDRESS3" class="search_app_bg_text" type="text" readonly value="<?php echo $C_ADDRESS3;?>" /></div>
<div class="search_app_text1">Fax:</div>
<div class="search_app_bg"><input name="C_FAX" id="C_FAX" class="search_app_bg_text" type="text" readonly value="<?php echo $C_FAX;?>" /></div>
<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">City:</div>
<div class="search_app_bg"><input name="C_CITY" id="C_CITY" class="search_app_bg_text" type="text" readonly value="<?php echo $C_CITY;?>" /></div>
<div class="search_app_text1">Pincode:</div>
<div class="search_app_bg"><input name="C_PIN" id="C_PIN" class="search_app_bg_text" type="text" readonly value="<?php echo $C_PIN;?>"/></div>
<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">Country:</div>
<div class="search_app_bg">
<select  class="search_app_bg_text" name="C_COUNTRY" id="C_COUNTRY">
<option selected="selected" value="">--Select--</option>
		<?php 
	$sql="select * from  kp_country_master order by country_name asc";
	$result=mysql_query($sql);
	while($rows=mysql_fetch_array($result))
	{
	if($rows[country_code]==$C_COUNTRY)
		{
			echo "<option  value='$rows[country_code]' selected='selected'>$rows[country_name]</option>";
		}
		else
		{
			echo "<option  value='$rows[country_code]'>$rows[country_name]</option>";
		}
	}
?>

</select>
</div>

<div class="clear"> </div>
</div>


<div class="search_app_div">
<div class="search_app_text1">App Fees:</div>
<div class="search_app_bg"><input name="FEES_AMOUNT" id="FEES_AMOUNT" class="search_app_bg_text" type="text" value="<?php if($FEES_AMOUNT!=""){echo $FEES_AMOUNT;}else{echo $APP_AMOUNT;}?>"  readonly="readonly" /></div>
<div class="search_app_text1">Courier Charges</div>
<div class="search_app_bg"><input name="COURIER_AMOUNT" id="COURIER_AMOUNT" class="search_app_bg_text" type="text" readonly value="<?php echo $COURIER_AMOUNT;?>" onKeyUp="return calculate()" /></div>
<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">Total Amount:</div>
<div class="search_app_bg"><input name="TOTAL_AMOUNT" id="TOTAL_AMOUNT" class="search_app_bg_text" type="text" value="<?php echo $TOTAL_AMOUNT;?>" readonly /></div>
<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="clear"> </div>
</div>


<div class="search_app_div">
<div class="search_app_text1"></div>
<div style="float:left; margin-bottom:4px;"><input class="input_bg" type="submit" value="Submit" /></div>
<div style="float:left;  margin-bottom:4px;"><input class="input_bg" type="submit" value="Close" /></div>
</div>
<div class="clear"></div>




<!-- div -->
<div class="clear"></div>
</div>
</form>
        </div>
        
 <?php } ?>    
    
    </div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
