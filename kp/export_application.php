<?php
include('header_include.php');
include('chk_login.php');
?>

<?php
$EXPORT_APP_ID = trim($_REQUEST['EXPORT_APP_ID']);
$sql="select * from kp_export_application_master where EXPORT_APP_ID='$EXPORT_APP_ID'";
$query=mysqli_query($conn,$sql);
$result=mysqli_fetch_array($query);
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
$M_COMPANY_NAME = trim($result['M_COMPANY_NAME']);
$M_ADDRESS = trim($result['M_ADDRESS']);
$M_COUNTRY_ID=$result['M_COUNTRY_ID'];
$M_CITY_ID=$result['M_CITY_ID'];
$M_CITY=$result['M_CITY'];
$M_STATE=$result['M_STATE'];
$M_PIN=$result['M_PIN'];
$M_COUNTRY=$result['M_COUNTRY'];
$C_COMPANY_NAME = trim($result['C_COMPANY_NAME']);
$C_ADDRESS1= trim($result['C_ADDRESS1']);
$C_ADDRESS2= trim($result['C_ADDRESS2']);
$C_ADDRESS3= trim($result['C_ADDRESS3']);
$C_COUNTRY=$result['C_COUNTRY'];
$C_CITY=$result['C_CITY'];
$C_PIN=$result['C_PIN'];
$C_TELEPHONE1 =$result['C_TELEPHONE1'];
$C_TELEPHONE2 =$result['C_TELEPHONE2'];
$PAYMENT_CHECK =$result['PAYMENT_CHECK '];
$PAYMENT_SENT =$result['PAYMENT_SENT'];
$PICKUP_TYPE  =$result['PICKUP_TYPE'];
$KP_CERT_NO = trim($result['KP_CERT_NO']);
$KP_HS_CODE1 =$result['KP_HS_CODE1'];
$USD_AMOUNT  = trim($result['USD_AMOUNT']);
$LOC_PICKUP_ID = trim($result['LOC_PICKUP_ID']);
$AGENT_MEM_LINK_ID  =$result['AGENT_MEM_LINK_ID'];
$LOC_PICKUP_ID =$result['LOC_PICKUP_ID'];
$LOC_PICKUP_ID =$result['LOC_PICKUP_ID'];
?>

<?php 
	$membertype=$_SESSION['MEMBERTYPE'];
	if($membertype=="Agent"){
		$APPLICANT_ID=$_SESSION['AGENT_ID'];
		$AGENT_ID=$_SESSION['AGENT_ID'];
	}
	else if($membertype=="Member"){
		$APPLICANT_ID=$_SESSION['MEMBER_ID'];
		$MEMBER_STATUS=getMembershipStatus($_SESSION['MEMBER_ID']);
		if($MEMBER_STATUS=="Y"){
			$APP_AMOUNT="500";
			$TOTAL_AMOUNT="590";
		}else{
			$APP_AMOUNT="1500";
			$TOTAL_AMOUNT="1779";
		}
	}
	else if($membertype=="NonMember"){
		$APPLICANT_ID=$_SESSION['NON_MEMBER_ID'];
		$APP_AMOUNT="1500";
		$TOTAL_AMOUNT="1779";
	}
?>

<?php 
/*.................Kp Export Link.......................*/
$query_link=mysqli_query($conn,"select * from kp_export_attachment_master where EXPORT_APP_ID='$EXPORT_APP_ID'");
$i=0;
while($result_link=mysqli_fetch_array($query_link)){
if($i==0){$CARATS1= trim($result_link['CARATS']);}
if($i==1){$CARATS2= trim($result_link['CARATS']);}
if($i==2){$CARATS3= trim($result_link['CARATS']);}
$i++;
}
if(isset($_SESSION['NON_MEMBER_ID'])){
$query=mysqli_query($conn,"SELECT * FROM `kp_non_member_master` where NON_MEMBER_ID='".$_SESSION['NON_MEMBER_ID']."' AND status='1'");
$result=mysqli_fetch_array($query);
$NON_MEMBER_NAME=$result['NON_MEMBER_NAME'];
$ADDRESS1 = trim($result['ADDRESS1']);
$CITY =$result['CITY'];
$STATE_ID=$result['STATE_ID'];
$COUNTRY_ID =$result['COUNTRY_ID'];
$PINCODE =$result['PINCODE'];
}
?>
<?php include('include-new/header.php');?>
<section class="py-5">
	
	<div class="container-fluid inner_container">
	<div class="container">
    <ul class="row justify-content-center  igja_nav   mb-4">
    	<li class="col-auto"><a href="import_application.php" class="d-block ">Import Application</a></li>
        <li class="col-auto"><a href="export_application.php" class="d-block active"> Export Application </a></li>
        <li class="col-auto"><a href="kimberley_process_search_applications.php" class="d-block ">Application History </a></li>
        <li class="col-auto"><a href="images/pdf/KP-User-Manual.pdf" target="_blank" class="d-block ">Online Manual</a></li>  
    </ul>
    </div>
		
<div class="container">
<div class="row justify-content-center no-gutters">

				<form action="export_application_inc.php" class="col-lg-12 box-shadow p-0" method="post" name="form1" id="form1" onSubmit="return validate()" enctype="multipart/form-data">
					<div class="col-md-12  form-block  col-sm-12 col-xs-12 loginform p-3"> 
					<div class="row">
                    <div class="col-12 form-group">
                   	<p class=" blue">Application for issuance of Kimberley process certificate for Export of rough diamonds from India
					</p>
                    </div>
						
						<p class="col-12">Please fill up the Export Application Form below and submit it after attaching the requirement attachments.</p>
						<?php if(isset($_SESSION['AGENT_ID'])){
						 //$sql="select MEMBER_ID,NON_MEMBER_ID from  kp_agent_member_link where AGENT_ID='".$_SESSION['AGENT_ID']."' order by MEMBER_ID desc";
						?>
						<div class="col-md-4">
							<div class="form-group">
								<label class="star">Select Member:</label>
								<select  class="form-control" name="Member" id="Member" >
									<option value="">--Select--</option>
									<?php
									$sql="select MEMBER_ID,NON_MEMBER_ID from  kp_agent_member_link where AGENT_ID='".$_SESSION['AGENT_ID']."' order by NON_MEMBER_ID,MEMBER_ID asc";
										$result=mysqli_query($conn,$sql);
										while($rows=mysqli_fetch_array($result))
										{
											if($rows['MEMBER_ID']!="")
											{
												$member_name=getMemberName($conn,"Member",$rows[MEMBER_ID]);
												if($member_name!=""){
									?>
									<option  value="member|<?php echo $rows['MEMBER_ID'];?>" <?php if($rows['MEMBER_ID']==$MEMBER_ID){echo "selected='selected'";}?>>
									<?php echo getMemberName($conn,"Member",$rows['MEMBER_ID']);?></option>
									<?php
											  }
										    }
											/*else if($rows['NON_MEMBER_ID']!="")
											{  
												$non_member_name=getMemberName($conn,"NonMember",$rows[NON_MEMBER_ID]);
									?>
									<option  value="nonmember|<?php echo $rows['NON_MEMBER_ID'];?>" <?php if($rows['NON_MEMBER_ID']==$NON_MEMBER_ID){echo "selected='selected'";}?>><?php echo getMemberName($conn,"NonMember",$rows['NON_MEMBER_ID']);?></option>
									<?php
										    }*/
										}
									?>
								</select>
								<input type="hidden" name="AGENT_ID" id="AGENT_ID" value="<?php echo $AGENT_ID;?>"/>
							</div>
						</div>
						<?php } ?>
						
						<input type="hidden" name="EXPORT_APP_ID" id="EXPORT_APP_ID" value="<?php echo $EXPORT_APP_ID;?>"/>
						<?php if(isset($_SESSION['AGENT_ID']) || isset($_SESSION['MEMBER_ID'])){?>
						<div class="col-md-4">
							<div class="form-group">
								<label class="star">Address:</label>
								<select class="form-control" name="M_ADD_SR_NO" id="M_ADD_SR_NO">
									<option value="">-- Select Address --</option>
									<?php
									$query=mysqli_query($conn,"SELECT * FROM `kp_member_address_details` where MEMBER_ID='".$MEMBER_ID."' and ADDRESS_IDENTITY='CTC' AND STATUS='1'");
									while($result=mysqli_fetch_array($query)){
									?>
									<option value="<?php echo $result['MEMBER_ADD_ID'];?>" <?php if($result['MEMBER_ADD_ID']==$M_ADD_SR_NO){?> selected="selected"<?php }?>><?php echo $result['MEMBER_CO_NAME']." ".$result['MEMBER_ADDRESS1']?></option>
									<?php }?>
								</select>
								<input type="hidden" name="Member1" id="Member1" value="<?php echo "member|".$_SESSION['MEMBER_ID'];?>"/>
							</div>
						</div>
						<?php }?>
						<div class="col-md-4">
							<div class="form-group">
								<label class="star">Date</label>
								<input onkeydown="return false" name="M_DATE" id="M_DATE" class="form-control" type="text" value="<?php echo date('Y-m-d');?>" readonly/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="star">Company:</label>
								<input name="M_COMPANY_NAME" id="M_COMPANY_NAME" class="form-control" type="text" readonly value="<?php if($M_COMPANY_NAME!=""){echo $M_COMPANY_NAME;} else { echo $NON_MEMBER_NAME; } ?>" />
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="star">Address:</label>
								<input name="M_ADDRESS" id="M_ADDRESS" class="form-control" type="text" value="<?php if($M_ADDRESS!=""){echo $M_ADDRESS;}else{echo $ADDRESS1;}?>" readonly />
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="star">State:</label>
								<select  class="form-control" name="M_STATE" id="M_STATE">
									<option selected="selected" value="">-- Select State --</option>
									<?php
									$sql="select * from  kp_state_master order by state_name asc";
									$result=mysqli_query($conn,$sql);
									while($rows=mysqli_fetch_array($result))
									{
									if($rows[state_code]==$STATE_ID || $rows[state_name]==$M_STATE)
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
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="star">City:</label>
								<input name="M_CITY" class="form-control " id="M_CITY" type="text" value="<?php if($M_CITY!=""){echo $M_CITY;}else {echo $CITY;}?>" autocomplete="off" />
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="star">Pincode:</label>
								<input name="M_PIN" id="M_PIN" class="form-control" type="text" readonly value="<?php if($M_PIN!=""){echo $M_PIN;}else {echo $PINCODE;}?>"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="star">Country:</label>
								<select  class="form-control" name="M_COUNTRY" id="M_COUNTRY">
									<option selected="selected" value="">-- Select Country --</option>
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
							</div>
						</div>
						<div class="col-12 form-group">
							<p class="blue">We are enclosing here with application for issuance of Kimberley process certificate for Export of rough diamonds from India as per details given below.</p>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label class="star">Country of Destination:</label>
								<select  class="form-control" name="COUNTRY_DEST_ID" id="COUNTRY_DEST_ID">
									<option selected="selected" value="">-- Select Destination --</option>
									<?php
										$sql="select * from  kp_country_master order by country_name asc";
										$result=mysqli_query($conn,$sql);
										while($rows=mysqli_fetch_array($result))
										{
												if($rows[country_code]==$COUNTRY_DEST_ID)
												{
													echo "<option  value='$rows[country_code]' selected='selected'>$rows[country_name]</option>";
												} else	{
													echo "<option  value='$rows[country_code]'>$rows[country_name]</option>";
												}
										}
									?>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="star">Select Importer Name:</label>
								<select name="Exporter_Name" class="form-control" id="Exporter_Name"  type="text" value="<?php echo $LONGNAME; ?>">
								</select>
								<input type="hidden" name="PARTY_ID" id="PARTY_ID" value="<?php echo $PARTY_ID; ?>" />
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="star">Importers Name:</label>
								<input name="IE_PARTY_NAME" id="IE_PARTY_NAME" class="form-control" type="text" readonly value="<?php echo $IE_PARTY_NAME;?>"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="star">Address 1:</label>
								<input name="IE_ADDRESS1" id="IE_ADDRESS1" class="form-control" type="text" readonly value="<?php echo $IE_ADDRESS1;?>"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="star">Address2</label>
								<input name="IE_ADDRESS2" id="IE_ADDRESS2" class="form-control" type="text" readonly value="<?php echo $IE_ADDRESS2;?>"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="star">Address 3</label>
								<input name="IE_ADDRESS3" id="IE_ADDRESS3" class="form-control" type="text" readonly value="<?php echo $IE_ADDRESS3;?>"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="star">Telephone Number</label>
								<input name="IE_TEL1" id="IE_TEL1" class="form-control" type="text" readonly value="<?php echo $IE_TEL1;?>"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="star">Fax</label>
								<input name="IE_FAX" id="IE_FAX" class="form-control" type="text" readonly value="<?php echo $IE_FAX;?>"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="star">City</label>
								<input name="IE_CITY" class="form-control" id="IE_CITY" type="text" value="<?php echo $IE_CITY;?>" autocomplete="off" />
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="star">Pincode</label>
								<input name="IE_PIN" id="IE_PIN" class="form-control" type="text" maxlength="6" readonly/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="star">Country</label>
								<select  class="form-control" name="IE_COUNTRY" id="IE_COUNTRY">
									<option selected="selected" value="">-- Select Country --</option>
									<?php
										$sql="select * from  kp_country_master order by country_name asc";
										$result=mysqli_query($conn,$sql);
										while($rows=mysqli_fetch_array($result))
										{
											if($rows[country_code]==$IE_COUNTRY_ID)
											{
												echo "<option  value='$rows[country_code]' selected='selected'>$rows[country_name]</option>";
											} else {
												echo "<option  value='$rows[country_code]'>$rows[country_name]</option>";
											}
										}
									?>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="star">Number Of Parcels</label>
								<input name="NUMBER_OF_PARCELS" id="NUMBER_OF_PARCELS" class="form-control numeric" type="text" value="<?php echo $NUMBER_OF_PARCELS;?>" maxlength="10"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="star">Invoice No</label>
								<input name="INVOICE_NO" id="INVOICE_NO" class="form-control" type="text" value="<?php echo $INVOICE_NO;?>" maxlength="30"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="star">Invoice Date</label>
								<input onkeydown="return false" name="INVOICE_DATE" id="popupDatepicker" class="form-control" type="text" value="<?php echo $INVOICE_DATE;?>" />
							</div>
						</div>					
						
						<?php if(!isset($_REQUEST['action'])){?>
						<div class="col-md-4">
							<div class="form-group">
								<label class="star">H S Code No:</label>
								<select  class="form-control" name="HS_CODE_ID" id="HS_CODE_ID">
									<option value="">-- Select H S Code --</option>
									<?php
										$sql="select * from  kp_hs_code_master";
										$result=mysqli_query($conn,$sql);
										while($rows=mysqli_fetch_array($result))
										{
											echo "<option value='$rows[LOOKUP_VALUE_ID]'>$rows[HS_CODE]</option>";
										}
									?>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="star">Carat Weight / Mass</label>
								<input name="WEIGHT" id="WEIGHT" class="form-control numeric" type="text" />
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="star">Country of Origin</label>
								<select  class="form-control" name="COUNTRY_ID" id="COUNTRY_ID">
									<option value="">-- Select Country --</option>
									<?php
										$sql="select * from  kp_country_master order by country_name asc";
										$result=mysqli_query($conn,$sql);
										while($rows=mysqli_fetch_array($result))
										{
										echo "<option  value='$rows[country_code]'>$rows[country_name]</option>";
										}
									?>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="star">Value in USD</label>
								<input name="AMOUNT" id="AMOUNT" class="form-control numeric" type="text" />
								<input type="hidden" name="APPLICANT_ID" id="APPLICANT_ID" value="<?php echo $APPLICANT_ID;?>"/>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<input class="cta" type="button" value="Add" id="imp_exp_trns_detail" name="imp_exp_trns_detail" />
							</div>
						</div>
							<div class="col-md-12" id='expimp_temp_tran_detail'>
								<table>
									<tr align="center" bgcolor="#EEEEEE">
										<td height="30"><strong>Select</strong></td>
										<td><strong>H S Code Number</strong></td>
										<td><strong>Card Weight / Mass</strong></td>
										<td><strong>Country of Origin</strong></td>
										<td><strong>Values In USD</strong></td>
									</tr>
									<?php
									$query=mysqli_query($conn,"select * from kp_expimp_temp_tran_detail where MEMBER_ID='$APPLICANT_ID'");
									$i=0;
									while($result=mysqli_fetch_array($query)){
									?>
									<tr>
										<td align="center"><label><input type="checkbox" name="HS_CODE_APP_ID[]" id="HS_CODE_APP_ID[]" value="<?php echo $result['HS_CODE_APP_ID'];?>" />
										<input type="hidden" name="HS_CODE_APP_ID_temp[]" id="HS_CODE_APP_ID_temp[]" value="<?php echo $result['HS_CODE_APP_ID'];?>"/></label></td>

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
									<?php } ?>
								</table>
							</div>
							<?php } ?>
							
							<div class="col-12">
								<div class="form-group">
									<input name="Declaration" class="d-inline-block" id="Declaration" type="checkbox" value="Y" checked="checked" /> <label class="star"><strong>Declaration</strong></label>
									<p class="d-inline-block">The diamonds herein invoiced have been purchased from legitimate sources not involved in funding conflict and in compliance with United Nations resolutions. The seller hereby guarantees that these diamond are conflict free, based on personal knowledge and / or written guarantees provided by the supplier of these diamonds.</p>
								</div>
							</div>
							
							<div class="col-12 form-group">
								<p class="blue">Attach (Please Upload File with proper format (JEPG/GIF/TIFF/PNG). The size of attachment should not exceed than 300 kb).</p>
							</div>
							
							<div class="col-md-6">
								<div class="form-group">
									<label class="star">1. Copy of Export Invoice</label>
									<input type="file" name="EXP_Attach1" class="form-control" id="fileField" /> 
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="star">Carat</label>
									<input name="EXP_Attach1_Carat" class="form-control numeric" type="text" value="<?php echo $CARATS1;?>" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="star">2. Copy of Duly Signed Import Invoice with Declaration </label>
									<input type="file" class="form-control" name="EXP_Attach2" id="fileField" /> 
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="star">Carat:</label>
									<input name="EXP_Attach2_Carat" class="form-control numeric" type="text" value="<?php echo $CARATS2;?>" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="star">3.Copy of Local Purchase Invoice</label>
									<input type="file" class="form-control" name="EXP_Attach3" id="fileField" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="star">Carat:</label>
									<input name="EXP_Attach3_Carat" class="form-control numeric" type="text" value="<?php echo $CARATS3;?>" />
								</div>
							</div>
							
							<div class="col-12 form-group">
								<p class="blue">If you wish to attach more than 1 KP Import invoices, then please attach copy of a letter on your company letter head containing list of Invoices. Example.</p>
							</div>							
							
							<div class="col-md-4">
								<div class="form-group">
									<label class="star">Processing Location</label>
									<select class="form-control" name="PROCES_CNTR" id="PROCES_CNTR">
									<option value="">-- Select Location --</option>
									<?php
									$sql="select * from kp_location_master order by LOCATION_NAME asc";
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
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="star">Select Courier Option</label>
									<div class="d-flex justify-content-between p-2">
										<label><input name="PAYMENT_MODE" id="PAYMENT_MODE" type="radio" value="Self" <?php if($PICKUP_TYPE=="Self"){?>checked="checked"<?php }?>/> Self</label>
										<label><input name="PAYMENT_MODE" id="PAYMENT_MODE" type="radio" value="Courier" <?php if($PICKUP_TYPE=="Courier"){?>checked="checked"<?php }?> /> Courier</label>
										<label><input name="PAYMENT_MODE_CHECK" id="PAYMENT_MODE_CHECK" type="checkbox" value="same" disabled="disabled" /> Address - Same as Above</label>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="star">Company Name</label>
									<input name="C_COMPANY_NAME" id="C_COMPANY_NAME" class="form-control" type="text" readonly value="<?php echo $C_ADDRESS1;?>" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="star">Address 1:</label>
									<input name="C_ADDRESS1" id="C_ADDRESS1" class="form-control" type="text" readonly value="<?php echo $C_ADDRESS1;?>" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="star">Address 2:</label>
									<input name="C_ADDRESS2" id="C_ADDRESS2" class="form-control" type="text" readonly value="<?php echo $C_ADDRESS2;?>" />
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<label class="star">Address 3:</label>
									<input name="C_ADDRESS3" id="C_ADDRESS3" class="form-control" type="text" readonly value="<?php echo $C_ADDRESS3;?>" />
								</div>
							</div>	
							<div class="col-md-4">
								<div class="form-group">
									<label class="star">Telephone 1:</label>
									<input name="C_TELEPHONE1" id="C_TELEPHONE1" class="form-control" type="text" readonlyvalue="<?php echo $C_TELEPHONE1;?>" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="star">Telephone 2:</label>
									<input name="C_TELEPHONE2" id="C_TELEPHONE2" class="form-control" type="text" readonly value="<?php echo $C_TELEPHONE2;?>"/>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="star">Fax:</label>
									<input name="C_FAX" id="C_FAX" class="form-control" type="text" readonly value="<?php echo $C_FAX;?>"/>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="star">City:</label>
									<input name="C_CITY" id="C_CITY" class="form-control" type="text" readonly value="" />
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<label class="star">Pincode:</label>
									<input name="C_PIN" id="C_PIN" class="form-control" type="text" readonly value="<?php echo $C_PIN;?>"/>
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<label class="star">Country:</label>
									<select  class="form-control" name="C_COUNTRY" id="C_COUNTRY">
										<option selected="selected" value="">-- Select Country --</option>
										<?php
										$sql="select * from  kp_country_master order by country_name asc";
										$result=mysqli_query($conn,$sql);
										while($rows=mysqli_fetch_array($result))
										{
										if($rows[country_code]==$C_COUNTRY)
										{
											echo "<option  value='$rows[country_code]' selected='selected'>$rows[country_name]</option>";
										} else	{
											echo "<option  value='$rows[country_code]'>$rows[country_name]</option>";
										}
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="star">App Fees</label>
									<input name="FEES_AMOUNT" id="FEES_AMOUNT" class="form-control" type="text" value="<?php if($FEES_AMOUNT!=""){echo $FEES_AMOUNT;}else{echo $APP_AMOUNT;}?>" readonly />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="star">Courier Charges:</label>
									<input name="COURIER_AMOUNT" id="COURIER_AMOUNT" class="form-control" type="text" readonly value="<?php echo $COURIER_AMOUNT;?>" onKeyUp="return calculate()"/>
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<label class="star">Total Amount:</label>
									<input name="TOTAL_AMOUNT" id="TOTAL_AMOUNT" class="form-control" type="text" value="<?php echo $TOTAL_AMOUNT;?>" readonly />
								</div>
							</div>
							<div class="col-12">
								<div class="form-group">
									<input class="cta mr-3 d-inline-block fade_anim" type="submit" value="Submit" />
									<input class="cta fade_anim" type="submit" value="Close" />
								</div>
							</div>
						
						</div>
					</div>
					</form>
		   </div>
	   <!-- Middle -->
	   </div>	
    </div>   

</section>
<?php include('include-new/footer.php');?>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function validate()
{
var membertype = "<?php echo $membertype;?>";
if(membertype=="Agent")
{
	if(document.getElementById('Member').value=="")
	{
		alert("Please select membe type!");
		document.getElementById('Member').focus();
		return false;
	}
}
if(document.getElementById('M_ADD_SR_NO').value=="")
{
	alert("Please select address!");
	document.getElementById('M_ADD_SR_NO').focus();
	return false;
}
if(document.getElementById('COUNTRY_DEST_ID').value=="")
{
	alert("Please select country of provinance!");
	document.getElementById('COUNTRY_DEST_ID').focus();
	return false;
}
if(document.getElementById('PARTY_ID').value=="")
{
	alert("Please select exporter name!");
	document.getElementById('PARTY_ID').focus();
	return false;
}
if(document.getElementById('NUMBER_OF_PARCELS').value=="")
{
	alert("Please enter number of parcels!");
	document.getElementById('NUMBER_OF_PARCELS').focus();
	return false;
}
if(document.getElementById('INVOICE_NO').value=="")
{
	alert("Please invoice no!");
	document.getElementById('INVOICE_NO').focus();
	return false;
}
if(document.getElementById('popupDatepicker').value=="")
{
	alert("Please Select invoice date!");
	document.getElementById('popupDatepicker').focus();
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

<script>
	$("#Member").on('change', function(){
	var Member_id=$("#Member").val();
	//alert(Member_id);return false;
		$.ajax({ type: 'POST',
						url: 'ajax.php',
						data: "actiontype=getAddress&Member_id="+Member_id,
						dataType:'html',
						beforeSend: function(){
						$("#status").show();
						$("#preloader").show();
						},
						success: function(data){
								$("#status").fadeOut();
								$("#preloader").delay(1000).fadeOut("slow");
								//alert(data);
								var data=data.split("|");
								var MEMBER_TYPE=$.trim(data[0]);
								var MEMBER_STATUS=$.trim(data[1]);
								var z=$.trim(data[2]);
									
								$("#M_ADD_SR_NO").html(z);
								$('#M_COMPANY_NAME').val("");
								$('#M_ADDRESS').val("");
								$('#M_CITY').val("");
								$('#M_STATE').val("");
								$('#M_PINCODE').val("");
								$('#M_COUNTRY').val("");
								$('#show_member_type').html(MEMBER_TYPE.toUpperCase());
								$('#loading').hide();
								if(MEMBER_TYPE=="member" && MEMBER_STATUS=="Y")
								{
									$("#FEES_AMOUNT").val("500")
									$("#TOTAL_AMOUNT").val("590");
								}
								else
								{
									$("#FEES_AMOUNT").val("1500");
									$("#TOTAL_AMOUNT").val("1770");
								}
							}
			});
	});
	</script>
	<script>
	$("#M_ADD_SR_NO").on('change', function(){
	var M_ADD_SR_NO=$("#M_ADD_SR_NO").val();
	var mem_x=$("#Member").val();
	//alert(mem_x);
	var mem_y=$("#Member1").val();
	if (!mem_x){Member_id=mem_y;}
	else{Member_id=mem_x;}
		$.ajax({ type: 'POST',
						url: 'ajax.php',
						data: "actiontype=getAddressDetail&Member_id="+Member_id+"&M_ADD_SR_NO="+M_ADD_SR_NO,
						dataType:'html',
						beforeSend: function(){
								$("#status").show();
								$("#preloader").show();
								},
						success: function(data){
							$("#status").fadeOut();
			    $("#preloader").delay(1000).fadeOut("slow");
									//alert(data);
								$('#loading1').hide();
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
<link href="assets/css/select2.min.css" rel="stylesheet" />
<script src="assets/js/select2.min.js"></script>
<script>
	$(document).ready(function(){
		$('#Exporter_Name').select2({
                selectOnClose: true
                });
     $("#COUNTRY_DEST_ID").on("change", function(){
        var COUNTRY_DEST_ID = $(this).val();
        var action = "getCountryRelatedExporterName"
        $.ajax({

        	
			type:'POST',
			data:{action:action,COUNTRY_DEST_ID:COUNTRY_DEST_ID},
			url:"ajax.php",
			dataType:'json',
			beforeSend: function(){
								$("#status").show();
								$("#preloader").show();
								},
			
			success:function(result){
				$("#status").fadeOut();
			    $("#preloader").delay(1000).fadeOut("slow");
				$("#Exporter_Name").html(result.output);
                
				
			}
		});
     });
         $("#Exporter_Name").on("change", function(){
        var PARTY_ID = $(this).val();
        var action = "getExportersDetails"
        $.ajax({
        	
			type:'POST',
			data:{action:action,PARTY_ID:PARTY_ID},
			url:"ajax.php",
			dataType:'json',
			beforeSend: function(){
								$("#status").show();
								$("#preloader").show("slow");
								},
			
			success:function(result){
				
				$("#status").fadeOut();
			    $("#preloader").delay(1000).fadeOut("slow");
				$("#PARTY_ID").val(PARTY_ID);
				$("#IE_PARTY_NAME").val(result.IE_PARTY_NAME);
				$("#IE_ADDRESS1").val(result.IE_ADDRESS1);
				$("#IE_ADDRESS2").val(result.IE_ADDRESS2);
				$("#IE_ADDRESS2").val(result.IE_ADDRESS2);
				$("#IE_TEL1").val(result.IE_TEL1);
				$("#IE_TEL2").val(result.IE_TEL2);
				$("#IE_FAX").val(result.IE_FAX);
				$("#IE_CITY").val(result.IE_CITY);
				$("#IE_PIN").val(result.IE_PIN);
				$("#IE_COUNTRY").val(result.IE_COUNTRY);
						
			}
		});
     });
	});
</script>
	
<script>
	$('#popupDatepicker').datepicker({
		uiLibrary: 'bootstrap4'
	});
	$('#popupDatepicker1').datepicker({
		uiLibrary: 'bootstrap4'
	});
</script>
<script>
$("input[name='PAYMENT_MODE']").on('change', function(){
var selectedVal = "";
var selected = $("input[type='radio'][name='PAYMENT_MODE']:checked");
if (selected.length > 0)
selectedValue = selected.val();
	if(selectedValue=="Courier")
	{
		$("#C_COMPANY_NAME").removeAttr("readonly");
		$("#C_ADDRESS1").removeAttr("readonly");
		$("#C_ADDRESS2").removeAttr("readonly");
		$("#C_ADDRESS3").removeAttr("readonly");
		
		$("#C_COUNTRY").removeAttr("readonly");
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
$("#PAYMENT_MODE_CHECK").on('change', function(){
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
$("#imp_exp_trns_detail").on('click', function(){
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
				$("#status").show();
							$("#preloader").show("slow");
							
			},
			success: function(data){
				$("#status").fadeOut();
						$("#preloader").delay(1000).fadeOut("slow");
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
$(document).on('click','#delete_hs_code', function(){

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
						$("#status").show();
							$("#preloader").show("slow");
							},
					success: function(data){

						$("#status").fadeOut();
						$("#preloader").delay(1000).fadeOut("slow");
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
	var tax_amnt=(z*18/100);
	tot_amnt=parseInt(tot)+parseInt(tax_amnt)+parseInt(courier_amount);
	
	$("#TOTAL_AMOUNT").val(tot_amnt);
}
</script>
<script language="javascript">
$(document).ready(function(){
		var selElem = document.getElementById('Member');
if(selElem !=null){
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

}


$('.numeric').keypress(function (event) {
var keycode = event.which;
if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) 
{
    event.preventDefault();
}
});

});
</script>
	<style type="text/css">
	.select2-container--default .select2-selection--single{border-radius: 0px}
	.select2-container .select2-selection--single{height: 35px}
</style>
</body>
</html>