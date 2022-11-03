<?php include('header_include.php');?>
<?php include('chk_login.php');?>
<?php
$App_ID = $_REQUEST['ID'];
$sql="SELECT * FROM `kp_export_application_master` WHERE `EXPORT_APP_ID`='$App_ID'";
$query=mysqli_query($conn,$sql);
$rows=mysqli_fetch_array($query);
?>

<?php include('include-new/header.php'); ?>
<section class="py-5">
	<div class="container-fluid inner_container">
	<div class="container">
    <ul class="row no-gutters justify-content-center  page_subtabs mb-4" style="background: #9e9457">
    	<li class="col-auto"><a href="import_application.php" class="d-block active">Import Application</a></li>
        <li class="col-auto"><a href="export_application.php" class="d-block"> Export Application </a></li>
        <li class="col-auto"><a href="kimberley_process_search_applications.php" class="d-block ">Application History </a></li>
        <li class="col-auto"><a href="images/pdf/KP-User-Manual.pdf" target="_blank" class="d-block ">Online Manual</a></li>  
    </ul>
    </div>

<div class="container ">
<div class="row justify-content-center no-gutters">

<div class="col-md-12  form-block  col-sm-12 col-xs-12 loginform p-3"> 
			
			<div class="row">
			<div class="form-group col-12 mb-4">
			<p class="blue">Application for endorsment of Kimberley process certificate for IMPORT of rough diamonds into India</p> 
			<p>Please fill up the Import Application Form below and submit it after attaching the requirement attachments.</p>
            </div>	
			
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
   
  <tr>
    <td>
    <table border="1" cellpadding="0" cellspacing="0" width="100%"  id="table_td" style="border-collapse:collapse;">
      <tr>
        <td bgcolor="#EFEFEF"><strong>Member</strong></td>
        <td height="20" colspan="3"><?php echo $rows['M_COMPANY_NAME'];?></td>
      </tr>
   
      <tr>
        <td width="165" bgcolor="#EFEFEF"><strong> Date</strong></td>
        <td height="20" colspan="3"><?php echo date("d/m/Y",strtotime($rows['M_DATE']));?></td>
        </tr>
      <tr>
        <td width="165" bgcolor="#EFEFEF"><strong>Company</strong></td>
        <td height="20" colspan="3"><?php echo $rows['M_COMPANY_NAME'];?></td>
        </tr>
      <tr>
        <td width="165" bgcolor="#EFEFEF"><strong> Address</strong></td>
        <td height="20" colspan="3"><?php echo $rows['M_ADDRESS'];?></td>
        </tr>
      <tr>
        <td width="165" bgcolor="#EFEFEF"><strong> City</strong></td>
        <td height="20" colspan="3"><?php echo $rows['M_CITY'];?></td>
        </tr>
      <tr>
        <td width="165" bgcolor="#EFEFEF"><strong> State</strong></td>
        <td height="20" colspan="3"><?php echo $rows['M_STATE'];?></td>
        </tr>
      <tr>
        <td width="165" bgcolor="#EFEFEF"><strong> Pincode</strong></td>
        <td height="20" colspan="3"><?php echo $rows['M_PIN'];?></td>
        </tr>
      <tr>
        <td width="165" bgcolor="#EFEFEF"><strong> Country</strong></td>
        <td height="20" colspan="3" class=""><?php echo $rows['M_COUNTRY'];?></td>
        </tr>
      <tr>
        <td height="20" colspan="4"><span style="border-collapse: collapse; margin:20px 0 20px 0; border-color:#ccc;"><strong>We are enclosing herewith application for issuance of Kimberley process certificate for import of rough diamonds from India as per details given below. </strong></span></td>
        </tr>
      <tr>
        <td width="165" height="20" bgcolor="#EFEFEF"><strong> Country of Provinance</strong></td>
        <td width="307" height="20" ><?php echo $rows['M_COUNTRY'];?></td>
        <td width="189" height="20" bgcolor="#EFEFEF"><strong> Exporter Name</strong></td>
        <td height="20" width="274"><?php echo $rows['IE_PARTY_NAME'];?></td>
      </tr>
      <tr>
        <td width="165" height="20" bgcolor="#EFEFEF"><strong> Address 1</strong></td>
        <td height="20" ><?php echo $rows['IE_ADDRESS1'];?></td>
        <td height="20" bgcolor="#EFEFEF" class="pay_dd_sidebrdr"><strong> Telephone 1</strong></td>
        <td height="20" width="274"><?php echo $rows['IE_TEL1'];?></td>
      </tr>
      <tr>
        <td width="165" height="20" bgcolor="#EFEFEF"><strong> Address 2</strong></td>
        <td height="20" ><?php echo $rows['IE_ADDRESS2'];?></td>
        <td height="20" bgcolor="#EFEFEF" class="pay_dd_sidebrdr"><strong> Telephone 2</strong></td>
        <td height="20" width="274"><?php echo $rows['IE_TEL2'];?></td>
      </tr>
      <tr>
        <td width="165" height="20" bgcolor="#EFEFEF"><strong> Address 3</strong></td>
        <td height="20" class="pay_dd_sidebrdr"><?php echo $rows['IE_ADDRESS3'];?></td>
        <td height="20" bgcolor="#EFEFEF" class="pay_dd_sidebrdr"><strong> Fax</strong></td>
        <td height="20" width="274"><?php echo $rows['IE_FAX'];?></td>
      </tr>
      <tr>
        <td width="165" height="20" bgcolor="#EFEFEF"><strong> City</strong></td>
        <td height="20" class="pay_dd_sidebrdr"><?php echo $rows['IE_CITY'];?></td>
        <td height="20" bgcolor="#EFEFEF" class="pay_dd_sidebrdr"><strong> Pincode</strong></td>
        <td height="20" width="274"><?php echo $rows['IE_PIN'];?></td>
      </tr>
      <tr>
        <td width="165" height="20" bgcolor="#EFEFEF"><strong> Country</strong></td>
        <td height="20" ><?php echo $rows['IE_COUNTRY'];?></td>
        <td height="20" bgcolor="#EFEFEF" class="pay_dd_sidebrdr">&nbsp;</td>
        <td height="20" >&nbsp;</td>
      </tr>
      <tr >
        <td width="165" height="20" bgcolor="#EFEFEF"><strong>Number Of Parcels</strong></td>
        <td height="20" ><?php echo $rows['NUMBER_OF_PARCELS'];?></td>
        <td height="20" bgcolor="#EFEFEF" ><strong> KP Certificate No*</strong></td>
        <td height="20" width="274"><?php echo $rows['KP_CERT_NO'];?></td>
      </tr>
      <tr >
        <td  width="165" height="20" bgcolor="#EFEFEF"><strong>Invoice No</strong></td>
        <td height="20"  ><?php echo $rows['INVOICE_NO'];?></td>
        <td height="20" bgcolor="#EFEFEF"  ><strong> Invoice Date</strong></td>
        <td class="" height="20"  width="274"><?php echo date("d/m/Y",strtotime($rows['INVOICE_DATE']));?></td>
      </tr>
    </table>
    </td>
  </tr>
  
   <tr>
  <td height="10"></td>
  </tr>
  
  <tr>
    <td align="center">
      <table width="95%" border="1" align="center" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC"  id="table_td" style="border-collapse:collapse;" >
      <tr  bgcolor="#927916" style="border-collapse: collapse; margin:20px 0 20px 0; border-color:#ccc; background-color:#ccc; "  >
        <td height="20" align="center"><strong>Select</strong></td>
        <td align="center"><strong>H S Code Number</strong></td>
        <td align="center"><strong>Carat Weight / Mass</strong></td>
        <td align="center"><strong>Country Of Origin</strong></td>
        <td align="center"><strong>Value In USD</strong></td>
      </tr>
      
      <?php 
	  $sql1="SELECT * FROM `kp_expimp_tran_detail` WHERE `EXPORT_APP_ID`='$App_ID'";
	  $query=mysqli_query($conn,$sql1);
	  while($rows1 = mysqli_fetch_array($query))
	  {
	  ?>
	  <tr align="center" style="width:280px;">
        <td><input id="1" type="checkbox" name="1" />        </td>
        <td><?php echo getHSCode($conn,$rows1['HS_CODE_ID']);?></td>
        <td><?php echo $rows1['WEIGHT'];?></td>
        <td><?php echo getOrginCountryName($conn,$rows1['COUNTRY_ID']);?></td>
        <td><?php echo $rows1['AMOUNT'];?></td>
      </tr>
      <?php 
	  }
	  
	  ?>
    </table>
    </td>
  </tr>
   <tr>
  <td height="10"></td>
  </tr>
  
  <tr>
    <td>
    <table border="1" cellpadding="0" cellspacing="0" width="100%"  id="table_td" style="border-collapse:collapse;">
      <tr>
        <td height="20">Declaration</td>
        <td height="20" colspan="3"><input id="Declaration" type="checkbox" name="Declaration" <?php if($rows['Declaration']=="Y"){ echo "checked='checked'";}?> />
                 The diamonds herein invoiced have been purchased from legitimate sources not involved
                in funding conflict and in compliance with United Nations resolutions. The seller
                hereby guarantees that these diamond are conflict free, based on personal knowledge
                and / or written guarantees provided by the supplier of these diamonds.</td>
        </tr>
      <tr>
        <td height="20" colspan="4" bgcolor="#EFEFEF"><span style="border-collapse: collapse; margin:20px 0 20px 0; border-color:#ccc; background-color:#EFEFEF; "><strong>Attach</strong></span></td>
        </tr>
      <tr>
        <td height="20" bgcolor="#EFEFEF"><strong> Processing Location</strong></td>
        <td width="304" height="20" ><?php echo getRegionName($conn,$rows['PROCES_CNTR']);?></td>
        <td height="20" bgcolor="#EFEFEF" >&nbsp;</td>
        <td height="20"  width="276">&nbsp;</td>
      </tr>
      <tr >
        <td width="164"  height="20" bgcolor="#EFEFEF"><strong> Type of Pickup</strong></td>
        <td height="20"><label for="ctl00_ContentPlaceHolder2_radSelf"><?php echo $rows['PICKUP_TYPE'];?></label></td>
        <td width="191" height="20" bgcolor="#EFEFEF">&nbsp;</td>
        <td height="20" width="276">&nbsp;</td>
      </tr>
      <tr >
        <td width="164" height="20" bgcolor="#EFEFEF"><strong>Company Name</strong></td>
        <td height="20"><?php echo $rows['C_COMPANY_NAME'];?></td>
        <td width="191" height="20" bgcolor="#EFEFEF"><strong> Pincode</strong></td>
        <td height="20" width="276"><?php echo $rows['C_PIN'];?></td>
      </tr>
      <tr >
        <td width="164" height="20" bgcolor="#EFEFEF"><strong> Address 1</strong></td>
        <td height="20" ><?php echo $rows['C_ADDRESS1'];?></td>
        <td width="191" height="20" bgcolor="#EFEFEF"><strong> Telephone 1</strong></td>
        <td height="20" width="276"><?php echo $rows['C_TELEPHONE1'];?></td>
      </tr>
      <tr >
        <td width="164" height="20" bgcolor="#EFEFEF"><strong> Address 2</strong></td>
        <td height="20" ><?php echo $rows['C_ADDRESS2'];?></td>
        <td width="191" height="20" bgcolor="#EFEFEF"><strong> Telephone 2</strong></td>
        <td height="20" width="276"><?php echo $rows['C_TELEPHONE2'];?></td>
      </tr>
      <tr >
        <td width="164" height="20" bgcolor="#EFEFEF"><strong> Address 3</strong></td>
        <td height="20" ><?php echo $rows['C_ADDRESS3'];?></td>
        <td width="191" height="20" bgcolor="#EFEFEF"><strong> Address 4</strong></td>
        <td height="20" width="276"><?php echo $rows['C_ADDRESS4'];?></td>
      </tr>
      <tr >
        <td width="164" height="20" bgcolor="#EFEFEF"><strong> Country</strong></td>
        <td height="20" ><?php echo $rows['C_COUNTRY'];?></td>
        <td width="191" height="20" bgcolor="#EFEFEF"><strong> Fax</strong></td>
        <td height="20" width="276"><?php echo $rows['C_FAX'];?></td>
      </tr>
      <tr >
        <td width="164"  height="20" bgcolor="#EFEFEF"><strong> City</strong></td>
        <td height="20" ><?php echo $rows['C_CITY'];?></td>
        <td height="20" bgcolor="#EFEFEF" >&nbsp;</td>
        <td height="20"  width="276">&nbsp;</td>
      </tr>
      <tr >
        <td width="164" height="20" bgcolor="#EFEFEF"><strong> App Fees</strong></td>
        <td height="20"  ><?php echo $rows['FEES_AMOUNT'];?></td>
        <td width="191" height="20" bgcolor="#EFEFEF"><strong> Courier Charges</strong></td>
        <td height="20"  width="276"><?php echo $rows['COURIER_AMOUNT'];?></td>
      </tr>
      <tr >
        <td width="164"  height="20" bgcolor="#EFEFEF"><strong> Total Amount</strong></td>
        <td height="20" ><?php echo $rows['TOTAL_AMOUNT'];?></td>
        <td height="20" bgcolor="#EFEFEF" >&nbsp;</td>
        <td height="20" width="276">&nbsp;</td>
      </tr>
      <tr >
        <td width="164" height="20" bgcolor="#EFEFEF"><strong> Kp Certificate No</strong></td>
        <td height="20"><?php echo $rows['KP_CERT_NO'];?></td>
        <td width="191" height="20" bgcolor="#EFEFEF"><strong> Valid Days</strong></td>
        <td height="20"  width="276"><?php echo $rows['KP_VALID_DAYS'];?></td>
      </tr>
      <tr >
        <td width="164" height="20" bgcolor="#EFEFEF"><strong> Issue Date</strong></td>
        <td height="20" ><?php echo date("d/m/Y",strtotime($rows['KP_ISSUE_DATE']));?></td>
        <td width="191" height="20" bgcolor="#EFEFEF"><strong> Expiry date</strong></td>
        <td height="20" width="276"><?php echo $rows['KP_EXP_DATE'];?></td>
      </tr>
      <tr >
        <td width="164" height="20" bgcolor="#EFEFEF"><strong> Advance Notify Date</strong></td>
        <td height="20" ><?php echo $rows['KP_ADV_NOTIFY_DATE'];?></td>
        <td width="191" height="20" bgcolor="#EFEFEF"><strong> Tech Date</strong></td>
        <td height="20" width="276"><?php echo $rows['KP_TECH_DATE'];?></td>
      </tr>
      <tr >
        <td width="164"  height="20" bgcolor="#EFEFEF"><strong> Cancel Date</strong></td>
        <td height="20" ><?php echo $rows['KP_CANCEL_DATE'];?></td>
        <td height="20" bgcolor="#EFEFEF" >&nbsp;</td>
        <td height="20" width="276">&nbsp;</td>
      </tr>
      <tr >
        <td width="164"  height="20" bgcolor="#EFEFEF"><strong>Remarks</strong></td>
        <td height="20"  ><?php echo $rows['KP_REMARKS'];?></td>
        <td width="191" height="20" bgcolor="#EFEFEF">&nbsp;</td>
        <td height="20" width="276">&nbsp;</td>
      </tr>
      <tr >
        <td width="164" height="20" bgcolor="#EFEFEF" class="pay_dd_rghtbrdr"><strong>Speaking Order Remarks</strong></td>
        <td height="20"  ><?php //echo $rows['PROCES_CNTR'];?></td>
        <td  width="191" height="20" bgcolor="#EFEFEF">&nbsp;</td>
        <td height="20" width="276">&nbsp;</td>
      </tr>
      <tr >
        <td height="20" class="pay_dd_rghtbrdr">&nbsp;</td>
        <td height="20" colspan="3"  ><a href="kimberley_process_search_applications.php">
          <input type="submit" name="Back" value="Back"  class="cta" />
        </a></td>
        </tr>
    </table>
    </td>
  </tr>
  
  <tr>
    <td align="left">
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td width="163"></td>
        <td align="center" height="23" valign="middle" width="787">&nbsp;</td>
        </tr>
    </table>
    </td>
  </tr>
  
</table>

</div>

</div>
</div>   
</section>
<?php include('include-new/footer.php'); ?>