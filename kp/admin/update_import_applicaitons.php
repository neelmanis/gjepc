<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php 
if(isset($_POST['Submit'])){
	$EXPORT_APP_ID=$_POST['EXPORT_APP_ID'];
	$PROCES_CNTR=$_POST['PROCES_CNTR'];
	
	$COUNTRY_DEST_ID=$_POST['COUNTRY_DEST_ID'];
	$IE_PARTY_ID=$_POST['IE_PARTY_ID'];
	$IE_PARTY_NAME=$_POST['IE_PARTY_NAME'];
	$IE_ADDRESS1=$_POST['IE_ADDRESS1'];
	$IE_ADDRESS2=$_POST['IE_ADDRESS2'];
	$IE_ADDRESS3=$_POST['IE_ADDRESS3'];
	$IE_CITY=$_POST['IE_CITY'];
	$IE_PIN=$_POST['IE_PIN'];
	$IE_COUNTRY=$_POST['IE_COUNTRY'];
	
	$M_ADD_SR_NO=$_POST['M_ADD_SR_NO'];
	$M_ADDRESS=$_POST['M_ADDRESS'];
	$M_COUNTRY=$_POST['M_COUNTRY'];
	$M_CITY=$_POST['M_CITY'];
	$M_STATE=$_POST['M_STATE'];
	$M_PIN=$_POST['M_PIN'];
	$M_COUNTRY=$_POST['M_COUNTRY'];
	
	$INVOICE_DATE=date('Y-m-d',strtotime($_POST['INVOICE_DATE']));
	$INVOICE_NO=$_POST['INVOICE_NO']; 
	$KP_CERT_ISSUE_DATE=date('Y-m-d',strtotime($_POST['KP_CERT_ISSUE_DATE']));
	$KP_CERT_EXPIRY_DATE=date('Y-m-d',strtotime($_POST['KP_CERT_EXPIRY_DATE'])); 
	$KP_CERT_NO = str_replace(' ','',$_POST['KP_CERT_NO']); 
	$KP_BATCH_NO = str_replace(' ','',$_POST['KP_BATCH_NO']); 
	$NUMBER_OF_PARCELS=$_POST['NUMBER_OF_PARCELS']; 
	$APPLICATION_STATUS=$_POST['APPLICATION_STATUS'];
	if($APPLICATION_STATUS=="N") 
		$APPLICATION_REASON=$_POST['APPLICATION_REASON']; 
	else
	    $APPLICATION_REASON=""; 

	mysqli_query($conn,"update kp_export_application_master set PROCES_CNTR='$PROCES_CNTR',COUNTRY_DEST_ID='$COUNTRY_DEST_ID',IE_PARTY_NAME='$IE_PARTY_NAME',IE_PARTY_ID='$IE_PARTY_ID',IE_ADDRESS1='$IE_ADDRESS1',IE_ADDRESS2='$IE_ADDRESS2',IE_COUNTRY='$IE_COUNTRY',IE_CITY='$IE_CITY',IE_PIN='$IE_PIN',M_ADD_SR_NO='$M_ADD_SR_NO',M_ADDRESS='$M_ADDRESS',M_CITY='$M_CITY',M_STATE='$M_STATE',M_PIN='$M_PIN',M_COUNTRY='$M_COUNTRY',INVOICE_DATE='$INVOICE_DATE',INVOICE_NO='$INVOICE_NO',KP_CERT_NO='$KP_CERT_NO',KP_BATCH_NO='$KP_BATCH_NO',KP_CERT_ISSUE_DATE='$KP_CERT_ISSUE_DATE',KP_CERT_EXPIRY_DATE='$KP_CERT_EXPIRY_DATE',NUMBER_OF_PARCELS='$NUMBER_OF_PARCELS',APPLICATION_STATUS='$APPLICATION_STATUS',APPLICATION_REASON='$APPLICATION_REASON' where EXPORT_APP_ID='$EXPORT_APP_ID'");
}
?>


<?php $EXPORT_APP_ID=$_REQUEST['EXPORT_APP_ID'];?>
<!--.......Update Action.........  -->
<?php 
$sql="select * from kp_export_application_master where EXPORT_APP_ID='$EXPORT_APP_ID'";
$query=mysqli_query($conn,$sql);
$result=mysqli_fetch_array($query);

$PROCES_CNTR=$result['PROCES_CNTR'];
$MEMBER_TYPE_ID=$result['MEMBER_TYPE_ID'];
$MEMBER_ID=$result['MEMBER_ID'];
$NON_MEMBER_ID=$result['NON_MEMBER_ID'];
$AGENT_ID=$result['AGENT_ID'];

$COUNTRY_DEST_ID=$result['COUNTRY_DEST_ID'];
$NUMBER_OF_PARCELS=$result['NUMBER_OF_PARCELS'];

$KP_CERT_ISSUE_DATE=$result['KP_CERT_ISSUE_DATE'];
$KP_CERT_EXPIRY_DATE=$result['KP_CERT_EXPIRY_DATE'];

$INVOICE_NO=$result['INVOICE_NO'];
$INVOICE_DATE=date('Y-m-d',strtotime($result['INVOICE_DATE']));


$TOTAL_WGHT=$result['TOTAL_WGHT'];
$FEES_AMOUNT=intval($result['FEES_AMOUNT']);
$COURIER_AMOUNT =intval($result['COURIER_AMOUNT']);
$TOTAL_AMOUNT=intval($result['TOTAL_AMOUNT']);

$IE_PARTY_NAME=$result['IE_PARTY_NAME'];
$IE_PARTY_ID=$result['IE_PARTY_ID'];
$IE_ADDRESS1=$result['IE_ADDRESS1'];
$IE_ADDRESS2=$result['IE_ADDRESS2'];
$IE_COUNTRY=$result['IE_COUNTRY'];
$IE_CITY=$result['IE_CITY'];
$IE_STATE=$result['IE_STATE'];
$IE_PIN=$result['IE_PIN'];
$IE_STATE=$result['IE_STATE'];
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

$PAYMENT_CHECK =$result['PAYMENT_CHECK'];
$PAYMENT_SENT =$result['PAYMENT_SENT'];
$PICKUP_TYPE  =$result['PICKUP_TYPE'];
$KP_CERT_NO = str_replace(' ','',$result['KP_CERT_NO']);
$KP_BATCH_NO = str_replace(' ','',$result['KP_BATCH_NO']);
$APPLICATION_STATUS=$result['APPLICATION_STATUS'];
$APPLICATION_REASON=$result['APPLICATION_REASON'];

$query_link=mysqli_query($conn,"select * from kp_export_attachment_master where EXPORT_APP_ID='$EXPORT_APP_ID'");
$i=0;
while($result_link=mysqli_fetch_array($query_link)){ 
if($i==0){ $CARATS1=$result_link['CARATS']; $ATTACHMENT_PATH1=$result_link['ATTACHMENT_PATH'];}
if($i==1){ $CARATS2=$result_link['CARATS']; $ATTACHMENT_PATH2=$result_link['ATTACHMENT_PATH'];}
if($i==2){ $CARATS3=$result_link['CARATS']; $ATTACHMENT_PATH3=$result_link['ATTACHMENT_PATH'];}
$i++;
}
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
$("#M_ADD_SR_NO").live('change', function(){
var M_ADD_SR_NO=$("#M_ADD_SR_NO").val();
var MEMBER_ID=$("#MEMBER_ID").val();

$.ajax({ 
	type: 'POST',
	url: 'ajax.php',
	data: "actiontype=getAddressDetail&MEMBER_ID="+MEMBER_ID+"&M_ADD_SR_NO="+M_ADD_SR_NO,
	dataType:'html',
	beforeSend: function(){
},
	success: function(data){
		///alert(data);
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

<script>
$("#COUNTRY_DEST_ID").live('change', function(){
var COUNTRY_DEST_ID=$("#COUNTRY_DEST_ID").val();

$.ajax({ type: 'POST',
	url: 'ajax.php',
	data: "actiontype=getForeignParty&COUNTRY_DEST_ID="+COUNTRY_DEST_ID,
	dataType:'html',
	beforeSend: function(){
},
	success: function(data){
		//alert(data);
		$("#IE_PARTY_ID").html(data);
     }
   });
});
</script>
<script>
$("#IE_PARTY_ID").live('change', function(){
var PARTY_ID=$("#IE_PARTY_ID").val();

$.ajax({ type: 'POST',
	url: 'ajax.php',
	data: "actiontype=getForeignPartyAddress&PARTY_ID="+PARTY_ID,
	dataType:'html',
	beforeSend: function(){
},
	success: function(data){
		///alert(data);
		var data=data.split("#");
		$('#IE_PARTY_NAME').val(data[0]);
		$('#IE_ADDRESS1').val(data[1]);
		$('#IE_ADDRESS2').val(data[2]);
		$('#IE_CITY').val(data[3]);
		$('#IE_PIN').val(data[4]);
		$('#IE_COUNTRY').val(data[5]);
     }
   });
});
</script>

<script>
$("#imp_exp_trns_detail").live('click', function(){
var HS_CODE_ID=$('#HS_CODE_ID').val();
var WEIGHT=$('#WEIGHT').val();
var COUNTRY_ID=$('#COUNTRY_ID').val();
var AMOUNT=$('#AMOUNT').val();
var EXPORT_APP_ID=$('#EXPORT_APP_ID').val();


if(HS_CODE_ID==""){alert("Please select HS Code");return false;}
if(WEIGHT==""){alert("Please enter weigth");return false;}
if(COUNTRY_ID==""){alert("Please select origin country name");return false;}
if(AMOUNT==""){alert("Please enter amount");return false;}

$.ajax({ type: 'POST',
		url: 'ajax.php',
		data: "actiontype=addIEDetail&HS_CODE_ID="+HS_CODE_ID+"&WEIGHT="+WEIGHT+"&COUNTRY_ID="+COUNTRY_ID+"&AMOUNT="+AMOUNT+"&EXPORT_APP_ID="+EXPORT_APP_ID,
		dataType:'html',
		beforeSend: function(){
		},
		success: function(data){
					//alert(data);
					$('#HS_CODE_ID').val("");
					$('#WEIGHT').val("");
					$('#COUNTRY_ID').val("");
					$('#AMOUNT').val("");
					$("#expimp_tran_detail").html(data);
				}
	});
});
</script>


<script>
$("#delete_hs_code").live('click', function(){
var EXPORT_APP_ID=$('#EXPORT_APP_ID').val();

var chks = document.getElementsByName('HS_CODE_APP_ID[]');
	var hasChecked = false;
	for (var i = 0; i < chks.length; i++){
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
   
 $.ajax({ type: 'POST',
		url: 'ajax.php',
		data: "actiontype=deleteHscode&HS_CODE_APP_ID="+allVals+"&EXPORT_APP_ID="+EXPORT_APP_ID,
		dataType:'html',
		beforeSend: function(){
				},
		success: function(data){
			//alert(data);
			$("#expimp_tran_detail").html(data);
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
	<div class="breadcome"><a href="admin.php">Home</a></div>
</div>

<div id="main">
	<div class="content">
<div class="content_details1">
<form action="#" method="post" name="form1" id="form1" onSubmit="return validate()" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0" >

<input type="hidden" name="EXPORT_APP_ID" id="EXPORT_APP_ID" value="<?php echo $EXPORT_APP_ID;?>"/>

<?php if(isset($MEMBER_ID) && $MEMBER_ID!=""){?>
<input type="hidden" name="MEMBER_ID" id="MEMBER_ID" value="<?php echo $MEMBER_ID;?>"/>
<tr>
<td class="content_txt">Address.</td>
<td colspan="4">
<select  class="input_txt" name="M_ADD_SR_NO" id="M_ADD_SR_NO">
<option value="">--select--</option>
<?php
	$query=mysqli_query($conn,"SELECT * FROM `kp_member_address_details` where MEMBER_ID='".$MEMBER_ID."' and ADDRESS_IDENTITY='CTC'");
	while($result=mysqli_fetch_array($query)){
?>
<option value="<?php echo $result['MEMBER_ADD_ID'];?>" <?php if($result['MEMBER_ADD_ID']==$M_ADD_SR_NO){?> selected="selected"<?php }?>><?php echo $result['MEMBER_CO_NAME']." ".$result['MEMBER_ADDRESS1']?></option>
<?php }?>
</select>
</td>
</tr>
<?php }?>

<?php 
if(isset($NON_MEMBER_ID) && $NON_MEMBER_ID!=""){
	$query=mysqli_query($conn,"SELECT * FROM `kp_non_member_master` where NON_MEMBER_ID='".$NON_MEMBER_ID."'");
	$result=mysqli_fetch_array($query);
	$NON_MEMBER_NAME=$result['NON_MEMBER_NAME'];
	$ADDRESS1=$result['ADDRESS1'];
	$CITY_ID =$result['CITY_ID'];
	$STATE_ID=$result['STATE_ID'];
	$COUNTRY_ID =$result['COUNTRY_ID'];
	$PINCODE =$result['PINCODE'];
}
?>
<tr>
<td bgcolor="#EAEAEA">Date:</td>
<td><input name="M_DATE" id="M_DATE" class="input_txt"  type="text" value="<?php echo date('Y-m-d');?>" readonly/></td>
<td bgcolor="#EAEAEA">Company:</td>
<td><input name="M_COMPANY_NAME" id="M_COMPANY_NAME" class="input_txt" type="text" readonly value="<?php if($M_COMPANY_NAME!=""){echo $M_COMPANY_NAME;}else {echo $NON_MEMBER_NAME;}?>" /></td>
</tr>

<tr>
<td bgcolor="#EAEAEA">Address:</td>
<td>
<textarea name="M_ADDRESS" id="M_ADDRESS" rows="2" cols="40"><?php if($M_ADDRESS!=""){echo $M_ADDRESS;}else{echo $ADDRESS1;}?></textarea>
<td bgcolor="#EAEAEA">State:</td>
<td>
<select class="input_txt" name="M_STATE" id="M_STATE">
<option selected="selected" value="">--Select--</option>
<?php 
$sql="select * from  kp_state_master order by state_name asc";
$result=mysqli_query($conn,$sql);
while($rows=mysqli_fetch_array($result))
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
</td>
</tr>
<tr>
<td bgcolor="#EAEAEA">City:</td>
<td><input name="M_CITY" class="input_txt" id="M_CITY" type="text" value="<?php echo $M_CITY;?>" autocomplete="off" /></td>
<td bgcolor="#EAEAEA">Pincode:</td>
<td><input name="M_PIN" id="M_PIN" class="input_txt" type="text" readonly value="<?php if($M_PIN!=""){echo $M_PIN;}else {echo $PINCODE;}?>"/></td>
</tr>

<tr>
	<td bgcolor="#EAEAEA">Country:</td>
<td>
<select  class="input_txt" name="M_COUNTRY" id="M_COUNTRY">
<option selected="selected" value="">--Select--</option>
<?php 
$sql="select * from  kp_country_master order by country_name asc";
$result=mysqli_query($conn,$sql);
while($rows=mysqli_fetch_array($result))
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
</td>
<td bgcolor="#EAEAEA">&nbsp;</td>
<td>&nbsp;</td>
</tr>

<tr>
<td bgcolor="#EAEAEA">Number Of Parcels:</td>
<td><input name="NUMBER_OF_PARCELS" id="NUMBER_OF_PARCELS" class="input_txt" type="text" value="<?php echo $NUMBER_OF_PARCELS;?>" /></td>
<td bgcolor="#EAEAEA">KP Certificate No:</td>
<td><input name="KP_CERT_NO" id="KP_CERT_NO" class="input_txt" type="text" value="<?php echo $KP_CERT_NO;?>" /></td>
</tr>

<tr>
<td bgcolor="#EAEAEA">KP Batch No:</td>
<td><input name="KP_BATCH_NO" id="KP_BATCH_NO" class="input_txt" type="text" value="<?php echo $KP_BATCH_NO;?>" /></td>
<td bgcolor="#EAEAEA">Certificate Issue Date:</td>
<td><input name="KP_CERT_ISSUE_DATE" id="KP_CERT_ISSUE_DATE" class="input_txt" type="date" value="<?php echo $KP_CERT_ISSUE_DATE;?>" />
</tr>

<tr>
<td bgcolor="#EAEAEA">Certificate Expiry Date:</td>
<td><input name="KP_CERT_EXPIRY_DATE" id="KP_CERT_EXPIRY_DATE" class="input_txt" type="date" value="<?php echo $KP_CERT_EXPIRY_DATE;?>" /></td>
<td bgcolor="#EAEAEA">Invoice No:</td>
<td><input name="INVOICE_NO" id="INVOICE_NO" class="input_txt" type="text" value="<?php echo $INVOICE_NO;?>" /></td>
</tr>
<tr>
<td bgcolor="#EAEAEA">Invoice Date:</td>
<td><input name="INVOICE_DATE" id="INVOICE_DATE" class="input_txt" type="date" value="<?php echo $INVOICE_DATE;?>" /></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>

<tr>
    <td bgcolor="#EAEAEA" colspan="4" align="center">Importer Detail</td>
</tr>

<tr>
    <td bgcolor="#EAEAEA">Country Of Provinance:</td>
    <td>
    <select  class="input_txt" name="COUNTRY_DEST_ID" id="COUNTRY_DEST_ID">
    <option value="">--Select--</option>
		<?php
			$sql="select * from  kp_country_master order by country_name asc";
			$result=mysqli_query($conn,$sql);
			while($rows=mysqli_fetch_array($result))
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
    </td>
    <td bgcolor="#EAEAEA">Select Exporter Name:</td>
    <td>
    <select  class="input_txt" name="IE_PARTY_ID" id="IE_PARTY_ID">
    <option value="">--Select--</option>
		<?php 
        $sql="select * from  kp_foreign_imp_master where COUNTRYID='$COUNTRY_DEST_ID'";
        $result=mysqli_query($conn,$sql);
        while($rows=mysqli_fetch_array($result))
        {
			if($rows[PARTY_ID]==$IE_PARTY_ID)
				{
					echo "<option  value='$rows[PARTY_ID]' selected='selected'>$rows[LONGNAME]</option>";
				}
				else
				{
					echo "<option  value='$rows[PARTY_ID]'>$rows[LONGNAME]</option>";
				}
        }
        ?>
    </select>
    </td>
</tr>
<tr>
    <td bgcolor="#EAEAEA">Importers Name:</td>
    <td><input name="IE_PARTY_NAME" id="IE_PARTY_NAME" class="input_txt" type="text" value="<?php echo $IE_PARTY_NAME; ?>" /></td>
    <td bgcolor="#EAEAEA">Address1:</td>
    <td><input name="IE_ADDRESS1" id="IE_ADDRESS1" class="input_txt" type="text" value="<?php echo $IE_ADDRESS1; ?>" /></td>
</tr>
<tr>
	<td bgcolor="#EAEAEA">Address 2:</td>
    <td><input name="IE_ADDRESS2" id="IE_ADDRESS2" class="input_txt" type="text" value="<?php echo $IE_ADDRESS2; ?>" /></td>
    <td bgcolor="#EAEAEA">Address 3:</td>
    <td><input name="IE_ADDRESS3" id="IE_ADDRESS3" class="input_txt" type="text" value="<?php echo $IE_ADDRESS3; ?>" /></td>
</tr>
<tr>
	<td bgcolor="#EAEAEA">Telephone No 1:</td>
    <td><input name="IE_TEL1" id="IE_TEL1" class="input_txt" type="text" value="<?php echo $IE_TEL1; ?>" /></td>
    <td bgcolor="#EAEAEA">Telephone No 2:</td>
    <td><input name="IE_TEL2" id="IE_TEL2" class="input_txt" type="text" value="<?php echo $IE_TEL2; ?>" /></td>
</tr>
<tr>
	<td bgcolor="#EAEAEA">Fax:</td>
    <td><input name="IE_FAX" id="IE_FAX" class="input_txt" type="text" value="<?php echo $IE_FAX; ?>" /></td>
    <td bgcolor="#EAEAEA">City:</td>
    <td><input name="IE_CITY" id="IE_CITY" class="input_txt" type="text" value="<?php echo $IE_CITY; ?>" /></td>
</tr>
<tr>
	<td bgcolor="#EAEAEA">Pincode:</td>
    <td><input name="IE_PIN" id="IE_PIN" class="input_txt" type="text" value="<?php echo $IE_PIN; ?>" /></td>
    <td bgcolor="#EAEAEA">Country:</td>
    <td>
	<select  class="input_txt" name="IE_COUNTRY" id="IE_COUNTRY">
    <option value="">--Select--</option>
		<?php
			$sql="select * from  kp_country_master order by country_name asc";
			$result=mysqli_query($conn,$sql);
			while($rows=mysqli_fetch_array($result))
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
	</td>
</tr>
<tr>
    <td bgcolor="#EAEAEA" colspan="4" height="12Px"></td>
</tr>
<tr>
    <td bgcolor="#EAEAEA">H S Code No:</td>
    <td>
    <select  class="input_txt" name="HS_CODE_ID" id="HS_CODE_ID">
    <option value="">--Select--</option>
		<?php 
        $sql="select * from  kp_hs_code_master";
        $result=mysqli_query($conn,$sql);
        while($rows=mysqli_fetch_array($result))
        {
            echo "<option  value='$rows[LOOKUP_VALUE_ID]'>$rows[HS_CODE]</option>";
        }
        ?>
    </select>
    </td>
    <td bgcolor="#EAEAEA">Carat Weight / Mass:</td>
    <td><input name="WEIGHT" id="WEIGHT" class="input_txt" type="text" /></td>
</tr>
<tr>
	
    <td bgcolor="#EAEAEA">Country of Origin</td>
    <td>
    <select  class="input_txt" name="COUNTRY_ID" id="COUNTRY_ID">
    <option value="">--Select--</option>
    <?php 
        $sql="select * from  kp_country_master order by country_name asc";
        $result=mysqli_query($conn,$sql);
        while($rows=mysqli_fetch_array($result))
        {
        echo "<option  value='$rows[country_code]'>$rows[country_name]</option>";
        }
	?>
	</select>
   </td>
    <td class="content_txt">Value in USD:</td>
    <td><input name="AMOUNT" id="AMOUNT" class="input_txt" type="text" /></td>
</tr>
 
<tr>
	<td colspan="4" align="center"><input class="input_submit" type="button" value="Add Carat Value" id="imp_exp_trns_detail" name="imp_exp_trns_detail" /></td>
</tr>
</table>
<span id="expimp_tran_detail">
<table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse: collapse; font-size:12px; margin:20px 0 20px 0; border-color:#ccc; " >
  <tr align="center" bgcolor="#EEEEEE">
    <td height="30"><strong>Select</strong></td>
    <td><strong>H S Code Number</strong></td>
    <td><strong>Card Weight / Mass</strong></td>
    <td><strong>Country of Origin</strong></td>
    <td><strong>Values In USD</strong></td>
  </tr>
<?php 
$query=mysqli_query($conn,"select * from kp_expimp_tran_detail where EXPORT_APP_ID='$EXPORT_APP_ID'");
$i=0;	
while($result=mysqli_fetch_array($query)){
?>

<tr>
    <td align="center"><label><input type="checkbox" name="HS_CODE_APP_ID[]" id="HS_CODE_APP_ID[]" value="<?php echo $result['HS_CODE_APP_ID'];?>" />
    <input type="hidden" name="HS_CODE_APP_ID[]" id="HS_CODE_APP_ID[]" value="<?php echo $result['HS_CODE_APP_ID'];?>"/>
    </label>
    
    </td>
    <td align="center"><?php echo getHSCode($conn,$result['HS_CODE_ID']);?></td>
    <td align="center"><?php echo $result['WEIGHT'];?></td>
    <td align="center"><?php echo getOrginCountryName($conn,$result['COUNTRY_ID']);?></td>
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

<table width="100%" border="0" cellspacing="0" cellpadding="0" >
<th> Attach (Please Upload File with proper format (JEPG/GIF/TIFF/PNG). The size of attachment should not exceed than 300 kb).</th>
<tr>
<td bgcolor="#EAEAEA">1. Copy of Export Invoice :</td>
<td><a class="input_submit" href="../import_attachment/<?php echo $ATTACHMENT_PATH1;?>" target="_blank">VIEW</a></td>
<td bgcolor="#EAEAEA">Carat:</td>
<td><input name="EXP_Attach1_Carat" class="form-control numeric" type="text" value="<?php echo $CARATS1;?>" /></td>
</tr>
<tr>
<td bgcolor="#EAEAEA">2. Copy of Duly Signed Invoice of Import under KP :</td>
<td><a class="input_submit" href="../import_attachment/<?php echo $ATTACHMENT_PATH2;?>" target="_blank">VIEW</a></td>
<td bgcolor="#EAEAEA">Carat:</td>
<td><input name="EXP_Attach2_Carat" class="form-control numeric" type="text" value="<?php echo $CARATS2;?>" /></td>
</tr>
<tr>
<td bgcolor="#EAEAEA">3. Copy of Airway Bill :</td>
<td><a class="input_submit" href="../import_attachment/<?php echo $ATTACHMENT_PATH3;?>" target="_blank">VIEW</a></td>
<td bgcolor="#EAEAEA">Carat:</td>
<td><input name="EXP_Attach3_Carat" class="form-control numeric" type="text" value="<?php echo $CARATS3;?>" /></td>
</tr>
</table>
<br/>

<table width="100%" border="0" cellspacing="0" cellpadding="0" >
<tr>
<td bgcolor="#EAEAEA">Processing Location:</td>
<td>
<select  class="input_txt" name="PROCES_CNTR" id="PROCES_CNTR">
<option value="">--Select--</option>
<?php 
$sql="select * from  kp_location_master order by LOCATION_NAME asc";
$result=mysqli_query($conn,$sql);
while($rows=mysqli_fetch_array($result))
{
	if($rows[LOCATION_ID]==$PROCES_CNTR)
	{
		echo "<option  value='$rows[LOCATION_ID]' selected='selected'>$rows[LOCATION_NAME]</option>";
	}
	else
	{
		echo "<option  value='$rows[LOCATION_ID]'>$rows[LOCATION_NAME]</option>";
	}
}
?>
</select>
</td>
<td bgcolor="#EAEAEA">App Fees:</td>
<td><input name="FEES_AMOUNT" id="FEES_AMOUNT" class="input_txt" type="text" value="<?php if($FEES_AMOUNT!=""){echo $FEES_AMOUNT;}else{echo $APP_AMOUNT;}?>"  readonly="readonly" />
</td>
</tr>
<tr>
<td bgcolor="#EAEAEA">Courier Charge:</td>
<td><input name="COURIER_AMOUNT" id="COURIER_AMOUNT" class="input_txt" type="text" readonly value="<?php echo $COURIER_AMOUNT;?>" /></td>
<td bgcolor="#EAEAEA">Total Amount:</td>
<td><input name="TOTAL_AMOUNT" id="TOTAL_AMOUNT" class="input_txt" type="text" value="<?php echo $TOTAL_AMOUNT;?>" readonly /></td>
</tr>
<tr>
    <td bgcolor="#EAEAEA">Application Status:</td>
    <td>
    	<select id="APPLICATION_STATUS" name="APPLICATION_STATUS">
        	<option>--Select Application Status</option>
            <option value="P" <?php if($APPLICATION_STATUS=="P"){?> selected="selected"<?php }?>>Pending</option>
            <option value="Y" <?php if($APPLICATION_STATUS=="Y"){?> selected="selected"<?php }?>>Approve</option>
            <option value="N" <?php if($APPLICATION_STATUS=="N"){?> selected="selected"<?php }?>>Rejected</option>
        </select>
    </td>
    <td bgcolor="#EAEAEA">Rejection Reason</td>
    <td><textarea name="APPLICATION_REASON" id="APPLICATION_REASON"><?php echo $APPLICATION_REASON;?></textarea></td>
</tr>
<tr>
<td class="content_txt">&nbsp;</td>
<td align="center">
<a href="search_application.php?action=view">
    <input type="submit" name="Back" value="Back"  class="input_submit" />
</a>
<input class="input_submit" type="submit" name="Submit" value="Submit" /></td>
<td colspan="2"></td>
</tr>
</table>
</form>
        </div>
    </div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
