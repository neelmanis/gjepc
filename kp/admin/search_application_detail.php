<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
$App_ID=mysqli_real_escape_string($conn,$_REQUEST['ID']);
$sql="SELECT * FROM `kp_export_application_master` WHERE `EXPORT_APP_ID`='$App_ID'";
$result=mysqli_query($conn,$sql);
$rows=mysqli_fetch_array($result);

$MEMBER_ID=$rows['MEMBER_ID'];
$M_ADD_SR_NO=$rows['M_ADD_SR_NO'];
$NON_MEMBER_ID=$rows['NON_MEMBER_ID'];

/*.........................Selected address Bp Number............................*/
	if($rows['MEMBER_TYPE_ID']=="18")
		$selected_add_bp=trim(getPartnerBp($conn,'Member',$MEMBER_ID,$M_ADD_SR_NO));
	elseif($rows['MEMBER_TYPE_ID']=="19")
		$selected_add_bp=trim(getPartnerBp($conn,'NonMember',$NON_MEMBER_ID,$M_ADD_SR_NO));
		
$query_link=mysqli_query($conn,"select * from kp_export_attachment_master where EXPORT_APP_ID='$App_ID'");
$i=0;
while($result_link=mysqli_fetch_array($query_link)){ 
if($i==0){ $CARATS1=$result_link['CARATS']; $ATTACHMENT_PATH1=$result_link['ATTACHMENT_PATH'];}
if($i==1){ $CARATS2=$result_link['CARATS']; $ATTACHMENT_PATH2=$result_link['ATTACHMENT_PATH'];}
if($i==2){ $CARATS3=$result_link['CARATS']; $ATTACHMENT_PATH3=$result_link['ATTACHMENT_PATH'];}
$i++;
}
?>
<?php if($rows['FORM_TYPE']=='I') { $type = "import_attachment"; } else { $type = "export_attachment"; } ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search Application || KP ||</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />
<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>      
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	$('#popupDatepicker').datepick();
	$('#inlineDatepicker').datepick({onSelect: showDate});
	$('#popupDatepicker1').datepick();
	$('#inlineDatepicker1').datepick({onSelect: showDate});
});
function showDate(date) {
	alert('The date chosen is ' + date);}
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
<script type="text/javascript">     
        function PrintDiv() {    
           var divToPrint = document.getElementById('divToPrint');
           var popupWin = window.open('', '_blank', 'width=600,height=600');
           popupWin.document.open();
           popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
            popupWin.document.close();
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
	<div class="breadcome"><a href="search_application.php">Home</a> > Search Application</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><div class="content_head_button">Search Application</div></div>
 
<div id="divToPrint">
<div class="content_details22">
<table width="100%" border="1" cellspacing="0" cellpadding="0"  style="border-color:#FFFFFF; margin:0px;" >
  
  
  
  <tr>
    <td>
    <table border="1" cellpadding="0" cellspacing="0" width="100%"  id="table_td" style="border-collapse:collapse;">
      <tr>
        <td height="20" colspan="6" bgcolor="#927916" style=" color:#FFFFFF"><strong>Application for issue of Kimberley process certificate for IMPORT of rough diamonds from India</strong></td>
        </tr>
      <tr>
        <td bgcolor="#EAEAEA">Member</td>
        <td height="20" colspan="5"><?php echo $rows['M_COMPANY_NAME'];?></td>
      </tr>
      <tr>
        <td height="20" colspan="4"><strong>Please fill up the <?php if($rows['FORM_TYPE']=='I') {?>Import<?php }else { ?>Export<?php } ?> Application Form below and submit it after attaching the requirement attachments.</strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
        <tr>
            <td bgcolor="#EAEAEA"> Date</td>
            <td><?php echo date("d/m/Y",strtotime($rows['M_DATE']));?></td>
            <td bgcolor="#EAEAEA">Company</td>
            <td><?php echo $rows['M_COMPANY_NAME'];?></td>
            <td bgcolor="#EAEAEA"> Address</td>
            <td><?php echo $rows['M_ADDRESS'];?></td>
        </tr>
        <tr>
            <td bgcolor="#EAEAEA"> City</td>
            <td><?php echo $rows['M_CITY'];?></td>
            <td bgcolor="#EAEAEA"> State</td>
            <td><?php echo getOrginStateName($conn,$rows['M_STATE']);?></td>
            <td bgcolor="#EAEAEA"> Pincode</td>
            <td><?php echo $rows['M_PIN'];?></td>
        </tr>
        <tr>
            <td width="153" bgcolor="#EAEAEA"> Country</td>
            <td><?php echo getOrginCountryName($conn,$rows['M_COUNTRY']);?></td>
			<td bgcolor="#EAEAEA"> Selected Address BP</td>
            <td><?php echo $selected_add_bp;?></td>
        </tr>
      <tr>
        <td height="20" colspan="4"><strong>We are enclosing herewith application for issuance of Kimberley process certificate for a <?php if($rows['FORM_TYPE']=='I') {?>Import<?php }else { ?>Export<?php } ?> of rough diamonds from India as per details given below. </strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
      <?php if($rows['FORM_TYPE']=='I'){ ?>
        <td bgcolor="#EAEAEA">Country of Provinance</td>
        <?php } else { ?>
		<td bgcolor="#EAEAEA">Country of Destination</td>
		<?php }?>
        <td><?php echo getOrginCountryName($conn,$rows['COUNTRY_PROV_ID']);?></td>
        <td bgcolor="#EAEAEA"> <?php if($rows['FORM_TYPE']=='I') {?>Exporter Name<?php }else { ?>Importer Name<?php } ?></td>
        <td><?php echo $rows['IE_PARTY_NAME'];?></td>
        <td bgcolor="#EAEAEA"> Address 1</td>
        <td><?php echo $rows['IE_ADDRESS1'];?></td>
      </tr>
      <tr>
        <td bgcolor="#EAEAEA"> Address 2</td>
        <td><?php echo $rows['IE_ADDRESS2'];?></td>
        <td width="153" height="20" bgcolor="#EAEAEA"> Address 3</td>
        <td height="20" class="pay_dd_sidebrdr"><?php echo $rows['IE_ADDRESS3'];?></td>
        <td width="153" height="20" bgcolor="#EAEAEA"> City</td>
        <td height="20" class="pay_dd_sidebrdr"><?php echo $rows['IE_CITY'];?></td>
      </tr>
      <tr>
      	<td height="20" bgcolor="#EAEAEA" class="pay_dd_sidebrdr"> Pincode</td>
        <td height="20" width="235"><?php echo $rows['IE_PIN'];?></td>
        <td width="153" height="20" bgcolor="#EAEAEA"> Country</td>
        <td height="20" ><?php echo getOrginCountryName($conn,$rows['IE_COUNTRY']);?></td>
      	<td bgcolor="#EAEAEA" class="pay_dd_sidebrdr"> Telephone 1</td>
        <td><?php echo $rows['IE_TEL1'];?></td>
      </tr>
      <tr>
        <td bgcolor="#EAEAEA" class="pay_dd_sidebrdr"> Telephone 2</td>
        <td><?php echo $rows['IE_TEL2'];?></td>
        <td height="20" bgcolor="#EAEAEA" class="pay_dd_sidebrdr"> Fax</td>
        <td height="20" width="235"><?php echo $rows['IE_FAX'];?></td>
        <td height="20" bgcolor="#EAEAEA" class="pay_dd_sidebrdr">&nbsp;</td>
        <td height="20" >&nbsp;</td>
      </tr>
      <tr >
        <td width="153" height="20" bgcolor="#EAEAEA">Number Of Parcels</td>
        <td height="20" ><?php echo $rows['NUMBER_OF_PARCELS'];?></td>
        <td height="20" bgcolor="#EAEAEA" > KP Certificate No*</td>
        <td height="20" width="235"><?php echo $rows['KP_CERT_NO'];?></td>
        <td width="153" height="20" bgcolor="#EAEAEA">Invoice No</td>
        <td height="20"  ><?php echo $rows['INVOICE_NO'];?></td>
      </tr>
      <tr>
        <td height="20" bgcolor="#EAEAEA"  > Invoice Date</td>
        <td class="" height="20"  width="235"><?php echo date("d/m/Y",strtotime($rows['INVOICE_DATE']));?></td>
      </tr>
    </table>
    </td>
  </tr>
    <tr>
    	<td height="8"></td>
    </tr>
  <tr>
    <td align="center">
      <table width="95%" border="1" align="center" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC"  id="table_td" style="border-collapse:collapse;" >
      <tr  bgcolor="#927916" style=" color:#FFFFFF" >
        <td height="20" align="center">Select</td>
        <td align="center">H S Code Number</td>
        <td align="center">Carat Weight / Mass</td>
        <td align="center">Country Of Origin</td>
        <td align="center">Value In USD</td>
      </tr>
      
      <?php 
	  $sql1="SELECT * FROM `kp_expimp_tran_detail` WHERE `EXPORT_APP_ID`='$App_ID'";
	  $result1=mysqli_query($conn,$sql1);
	  while($rows1=mysqli_fetch_array($result1))
	  {
	  ?>
	  <tr align="center" style="width:280px;">
        <td><input id="1" type="checkbox" name="1" />        </td>
        <td><?php echo getHSCode($conn,$rows1['HS_CODE_ID']);?></td>
        <td><?php echo $rows1['WEIGHT'];?></td>
        <td><?php echo getOrginCountryName($conn,$rows1['COUNTRY_ID']);?></td>
        <td><?php echo $rows1['AMOUNT'];?></td>
      </tr>
      <?php } ?>
    </table>
    </td>
  </tr>
  <tr>
  	<td height="8"></td>
  </tr>
	
	<tr>
	<td>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" >
<th> Attach (Please Upload File with proper format (JEPG/GIF/TIFF/PNG). The size of attachment should not exceed than 300 kb).</th>
<tr>
<td bgcolor="#EAEAEA"><?php if($rows['FORM_TYPE']=='I') {?>1. Copy of Export Invoice<?php } else { ?>1. Copy of Export Invoice :<?php } ?></td>
<td><a class="input_submit" href="../<?php echo $type; ?>/<?php echo $ATTACHMENT_PATH1;?>" target="_blank">VIEW</a></td>
<td bgcolor="#EAEAEA">Carat:</td>
<td><input name="EXP_Attach1_Carat" class="form-control numeric" type="text" value="<?php echo $CARATS1;?>" /></td>
</tr>
<tr>
<td bgcolor="#EAEAEA"><?php if($rows['FORM_TYPE']=='I') {?>2. Copy of Duly Signed Invoice of Import under KP<?php }else { ?>2. Copy of Duly Signed Import Invoice with Declaration :<?php } ?></td>
<td><a class="input_submit" href="../<?php echo $type; ?>/<?php echo $ATTACHMENT_PATH2;?>" target="_blank">VIEW</a></td>
<td bgcolor="#EAEAEA">Carat:</td>
<td><input name="EXP_Attach2_Carat" class="form-control numeric" type="text" value="<?php echo $CARATS2;?>" /></td>
</tr>
<tr>
<td bgcolor="#EAEAEA"><?php if($rows['FORM_TYPE']=='I') {?>3. Copy of Airway Bill<?php }else { ?>3. Copy of Local Purchase Invoice :<?php } ?></td>
<td><a class="input_submit" href="../<?php echo $type; ?>/<?php echo $ATTACHMENT_PATH3;?>" target="_blank">VIEW</a></td>
<td bgcolor="#EAEAEA">Carat:</td>
<td><input name="EXP_Attach3_Carat" class="form-control numeric" type="text" value="<?php echo $CARATS3;?>" /></td>
</tr>
</table>
<br/>
	</td>
	</tr>
	
  <tr>
    <td>
    <table border="1" cellpadding="0" cellspacing="0" width="100%"  id="table_td" style="border-collapse:collapse;">
      <tr>
        <td bgcolor="#EAEAEA"> Processing Location <?php echo $rows['PROCES_CNTR'];?></td>
        <td><?php echo getRegionName($conn,$rows['PROCES_CNTR']);?></td>
        <td bgcolor="#EAEAEA"> Type of Pickup</td>
        <td><?php echo $rows['PICKUP_TYPE'];?></td>
        <td bgcolor="#EAEAEA">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#EAEAEA">Company Name</td>
        <td><?php echo $rows['C_COMPANY_NAME'];?></td>
        <td bgcolor="#EAEAEA"> Pincode</td>
        <td><?php echo $rows['C_PIN'];?></td>
        <td bgcolor="#EAEAEA"> Address 1</td>
        <td><?php echo $rows['C_ADDRESS1'];?></td>
      </tr>
      <tr>
        <td bgcolor="#EAEAEA"> Address 2</td>
        <td><?php echo $rows['C_ADDRESS2'];?></td>
        <td bgcolor="#EAEAEA"> Address 3</td>
        <td><?php echo $rows['C_ADDRESS3'];?></td>
        <td bgcolor="#EAEAEA">City</td>
        <td><?php echo $rows['C_CITY'];?></td>
      </tr>
      <tr>
        <td bgcolor="#EAEAEA"> Country</td>
        <td><?php echo getOrginCountryName($conn,$rows['C_COUNTRY']);?></td>
        <td bgcolor="#EAEAEA"> Telephone 1</td>
        <td><?php echo $rows['C_TELEPHONE1'];?></td>
        <td bgcolor="#EAEAEA"> Telephone 2</td>
        <td><?php echo $rows['C_TELEPHONE2'];?></td>
      </tr>
      <tr>
        <td bgcolor="#EAEAEA"> Fax</td>
        <td><?php echo $rows['C_FAX'];?></td>
        <td bgcolor="#EAEAEA">&nbsp;</td>
        <td>&nbsp;</td>
        <td bgcolor="#EAEAEA">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
      	<td bgcolor="#EAEAEA"> App Fees</td>
        <td><?php echo $rows['FEES_AMOUNT'];?></td>
        <td width="165" height="20" bgcolor="#EAEAEA"> Courier Charges</td>
        <td height="20"  width="227"><?php echo $rows['COURIER_AMOUNT'];?></td>
        <td width="157"  height="20" bgcolor="#EAEAEA"> Total Amount</td>
        <td height="20" ><?php echo $rows['TOTAL_AMOUNT'];?></td>
      </tr>
      <tr>
      	<td width="157" height="20" bgcolor="#EAEAEA"> Kp Certificate No</td>
        <td height="20"><?php echo $rows['KP_CERT_NO'];?></td>
        <td width="157" height="20" bgcolor="#EAEAEA"> Issue Date</td>
        <td height="20" ><?php echo $rows['KP_CERT_ISSUE_DATE'];?></td>
        <td width="165" height="20" bgcolor="#EAEAEA"> Expiry date</td>
        <td height="20" width="227"><?php echo $rows['KP_CERT_EXPIRY_DATE'];?></td>
      </tr>
      <!--<tr>
        <td width="157"  height="20" bgcolor="#EAEAEA">Remarks</td>
        <td height="20"  ><?php echo $rows['KP_REMARKS'];?></td>
        <td width="157" height="20" bgcolor="#EAEAEA" class="pay_dd_rghtbrdr ">Speaking Order Remarks</td>
        <td height="20"  ><?php //echo $rows['PROCES_CNTR'];?></td>
      </tr>-->
    <tr>
    <td class="pay_dd_rghtbrdr " height="20">&nbsp;</td>
    <td height="20" colspan="6"  ><a href="search_application.php?action=view">
    <input type="submit" name="Back" value="Back"  class="input_submit" /></a>
    <input type="submit" name="Print" value="Print"  class="input_submit" onclick="PrintDiv();" /></td>
    </tr>
    </table>
    </td>
  </tr>
  
  <tr>
    <td align="left">
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td width="109"></td>
        <td align="center" height="23" valign="middle" width="686"></td>
        </tr>
    </table>
    </td>
  </tr>
  
</table>

</div>
</div>  
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
