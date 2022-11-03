<?php session_start(); ?>
<?php 
include('db.inc.php');
include('functions.php');
?>
<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getCity"){
$country=$_POST['country'];
$query=mysql_query("SELECT * from state_master WHERE country_code = '$country'");
if($country=="IN"){
?>
      <select name="state" id="state" class="form-control">
      <option value="">--Select State--</option>
      <?php while($result=mysql_fetch_array($query)){?>
      <option value="<?php echo $result['state_code'];?>"><?php echo $result['state_name'];?></option>
      <?php }?>
      </select>

<?php } else { ?>

<input type="text" class="form-control" value="" id="state" name="state" />

<?php } ?>
<?php } ?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="comaddress"){
if(isset($_POST['id']) && $_POST['id']!=""){$id=$_POST['id'];}else{$id="";}
$registration_id=$_POST['registration_id'];
$type_of_addresss=$_POST['type_of_address'];
$tmp = explode("-", $type_of_addresss);

$type_of_address = $tmp[0];
$address_identity = $tmp[1];

if(!empty($type_of_address)){
	if($type_of_address==2){ $type_of_address_sap = "P"; }
	else { $type_of_address_sap = "C"; }
} else { echo "Type of Address missing"; }

if(isset($_POST['name']) && $_POST['name']!=""){$name=$_POST['name'];}else{$name="";}
if(isset($_POST['father_name']) && $_POST['father_name']!=""){$father_name=$_POST['father_name'];}else{$father_name="";}
if(isset($_POST['address1']) && $_POST['address1']!=""){$address1=$_POST['address1'];}else{$address1="";}
if(isset($_POST['address2']) && $_POST['address2']!=""){$address2=$_POST['address2'];}else{$address2="";}
if(isset($_POST['address3']) && $_POST['address3']!=""){$address3=$_POST['address3'];}else{$address3="";}
$city=strtoupper($_POST['city']);
$country=strtoupper($_POST['country']);
if($_POST['state']!=""){$state=$_POST['state'];}
$pincode=$_POST['pincode'];
if(isset($_POST['landline_no1']) && $_POST['landline_no1']!=""){$landline_no1=$_POST['landline_no1'];}else{$landline_no1="";}
if(isset($_POST['mobile_no']) && $_POST['mobile_no']!=""){$mobile_no=$_POST['mobile_no'];}else{$mobile_no="";}
if(isset($_POST['fax_no1']) && $_POST['fax_no1']!=""){$fax_no1=$_POST['fax_no1'];}else{$fax_no1="";}
if(isset($_POST['fax_no2']) && $_POST['fax_no2']!=""){$fax_no2=$_POST['fax_no2'];}else{$fax_no2="";}
$email_id=$_POST['email_id'];
$din_no=$_POST['din_no'];

if(!empty($type_of_address)){
	if($type_of_address==2 || $address_identity=="CTP"){ $pan_no = mysql_real_escape_string(strtoupper($_POST['pan_no'])); }	else { $pan_no = ""; }
} else { echo "Type of Address missing"; }


$gst_no=mysql_real_escape_string(strtoupper($_POST['gst_no']));
$aadhar_no = mysql_real_escape_string(strtoupper($_POST['aadhar_no']));
$passport_no = mysql_real_escape_string(strtoupper($_POST['passport_no']));
$joining_date = mysql_real_escape_string($_POST['joining_date']);
$retirement_date = mysql_real_escape_string($_POST['retirement_date']);
$dt = date('Y/m/d'); 

$qcheck=mysql_query("select * from communication_address_master where id='$id' and registration_id='$registration_id'");
$rcheck=mysql_num_rows($qcheck);
if($rcheck>0){
mysql_query("update communication_address_master set type_of_address='$type_of_address',address_identity='$address_identity',type_of_address_sap='$type_of_address_sap',name='$name',father_name='$father_name',address1='$address1',address2='$address2',address3='$address3',city='$city',country='$country',state='$state',pincode='$pincode',landline_no1='$landline_no1',mobile_no='$mobile_no',fax_no1='$fax_no1',fax_no2='$fax_no2',email_id='$email_id',din_no='$din_no',pan_no='$pan_no',gst_no='$gst_no',aadhar_no='$aadhar_no',passport_no='$passport_no',joining_date='$joining_date',retirement_date='$retirement_date' where id='$id' and registration_id='$registration_id'");
}
else
{
$sql="insert into communication_address_master set registration_id='$registration_id',type_of_address='$type_of_address',address_identity='$address_identity',type_of_address_sap='$type_of_address_sap',name='$name',father_name='$father_name',address1='$address1',address2='$address2',address3='$address3',city='$city',country='$country',state='$state',pincode='$pincode',landline_no1='$landline_no1',mobile_no='$mobile_no',fax_no1='$fax_no1',fax_no2='$fax_no2',email_id='$email_id',din_no='$din_no',pan_no='$pan_no',gst_no='$gst_no',aadhar_no='$aadhar_no',passport_no='$passport_no',joining_date='$joining_date',retirement_date='$retirement_date',status=1,post_date='$dt'";
mysql_query($sql);
}
$query=mysql_query("select * from communication_address_master where registration_id='$registration_id'");
while($result=mysql_fetch_array($query)){
?>
 <tr>
            <td style="padding:5px;"><?php echo getaddresstype($result['type_of_address']);?></td>
            <td style="padding:5px;text-transform:uppercase;"><?php echo $result['address1'];?>,<?php echo $result['address2'];?>,<?php echo $result['address3'];?>,<?php echo $result['city'];?>,<?php echo $result['state'];?>,<?php echo $result['pincode'];?></td>
            <td style="padding:5px;text-transform:uppercase;"><?php echo $result['name'];?></td>
            <td style="padding:5px;cursor:pointer;" class="editAdd <?php echo $result['id'];?> <?php echo $registration_id;?>">EDIT</td>
            <td style="padding:5px;cursor:pointer;" class="deleteAdd <?php echo $result['id'];?> <?php echo $registration_id;?>">DELETE</td>
  </tr>

<?php }}?>


<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="deleteAdd"){
$id=$_POST['id'];
$registration_id=$_POST['registration_id'];
mysql_query("delete from communication_address_master where id='$id' and registration_id='$registration_id'");

$query=mysql_query("select * from communication_address_master where registration_id='$registration_id'");
while($result=mysql_fetch_array($query)){
?>
<tr>
<td style="padding:5px;text-transform:uppercase;"><?php echo getaddresstype($result['type_of_address']);?></td>
<td style="padding:5px;text-transform:uppercase;"><?php echo $result['address1'];?><?php if($result['address2']!=""){echo ",".$result['address2'];}?><?php if($result['address3']!=""){echo ",".$result['address3'];}?><?php if($result['city']!=""){echo ",".$result['city'];}?><?php if($result['state']!=""){echo ",".$result['state'];}?><?php if($result['pincode']!=""){echo ",".$result['pincode'];}?></td>
<td style="padding:5px;text-transform:uppercase;"><?php echo $result['name'];?></td>
<td style="padding:5px;cursor:pointer;" class="editAdd <?php echo $result['id'];?> <?php echo $registration_id;?>">EDIT</td> 
<td style="padding:5px;cursor:pointer;" class="deleteAdd <?php echo $result['id'];?> <?php echo $registration_id;?>">DELETE</td>
</tr>
<?php }}?>


<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="rcmc_certificate_apply"){
$registration_id=$_POST['registration_id'];
mysql_query("update approval_master set rcmc_certificate_apply='Y' where registration_id='$registration_id'");
		
	$region=getRegion($registration_id);
	if($region=='HO-MUM (M)'){$to='mithun@gjepcindia.com,archana@gjepcindia.com,hari@gjepcindia.com';}
	if($region=='RO-CHE'){$to='venugopal@gjepcindia.com';}
	if($region=='RO-DEL'){$to='madaan@gjepcindia.com';}
	if($region=='RO-JAI'){$to='sasi@gjepcindia.com';}
	if($region=='RO-KOL'){$to='salim@gjepcindia.com';}
	if($region=='RO-SRT'){$to='salim@gjepcindia.com';}
	//if($region=='RO-SRT'){$to='dsinghmukesh@gmail.com';}	
	 $userinfo= mysql_query("select * from  information_master where registration_id='$registration_id'");
	 $user_result=mysql_fetch_array($userinfo);
	 $company_name=$user_result['company_name'];
	 $iec_no=$user_result['iec_no'];
	 $email_id=$user_result['email_id'];
     $name=$user_result['name'];
		
$message ='<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:"Lucida Sans"; font-size:14px; color:#333333; text-align:justify;">
  <tr>
    <td colspan="2"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="150" align="left"><img src="http://gjepc.kwebmakeruk.com/images/logo_gjepc.png" width="150" height="91" /></td>
          <td width="85%" align="right"><img src="http://gjepc.kwebmakeruk.com/images/logo_in.png" width="105" height="91" /></td>
        </tr>
      </table>    </td>
  </tr>
  <tr>
    <td height="10" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; color:#990000; border-bottom: solid thin #666666;">&nbsp;</td>
  </tr>
  <tr>
    <td height="30" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Dear admin,</td>
  </tr>
  <tr>
    <td align="left" style="text-align:justify;"> '.$name .' apply for rcmc certificate.</td>
  </tr>
   <tr>
    <td>&nbsp; </td>
    </tr>
  <tr>
    <td align="left"  style="text-align:justify;"> Kindly find the details of the user below:</td>
  </tr>
   <tr>
  <td>&nbsp; </td>
    </tr>
     <tr>
  <td height="22"style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Name of the company : </td>
    </tr>
  <tr>
    <td align="left"  style="text-align:justify;">'.$company_name.'<br />
	IEC number: '.$iec_no.'<br />
	E-mail: '.$email_id.'</td>
  </tr>
   <tr>
    <td>&nbsp; </td>
    </tr>
  <tr>
    <td align="left">Visit the admin panel  to take the necessary actions on the same.</td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td height="22" align="left"   style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Kind Regards,</td>
  </tr>
  <tr>
    <td align="left"><strong>GJEPC Web Team,</strong></td>
  </tr>
</table>';
		
	 $subject = "Apply RCMC Certificate"; 
	 $headers  = 'MIME-Version: 1.0' . "\r\n"; 
	 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
	 $headers .= 'From:admin@gjepc.org';			
	 mail($to, $subject, $message, $headers);

?>
<?php }?>

<?php if(isset($_POST['actiontype']) && $_POST['actiontype']=="editAdd"){
$id=$_POST['id'];
$registration_id=$_POST['registration_id'];

$info_status=mysql_query("select member_type_id,type_of_firm,status from information_master where registration_id='$registration_id' and status=1");
$info_row=mysql_fetch_array($info_status);
$member_type_id=$info_row['member_type_id'];
$type_of_firm=$info_row['type_of_firm'];

$cquery=mysql_query("select * from communication_address_master where id='$id' and registration_id='$registration_id'");
$cresult=mysql_fetch_array($cquery);
$type_of_address = trim($cresult['type_of_address']);
$address_identity = trim($cresult['address_identity']);

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
<div class="form-block">
<form id="comaddress" name="comaddress">
<input type="hidden" name="hidden" id="hidden" value=""/>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="type_of_address">Type of Communication Address :</label></div>
				<div class="col-md-6">
					<select class="form_text_text" id="type_of_address" name="type_of_address">
					<option value="none">---- Select ----</option>
					<?php
					$sql=getCommunicationAddress($addflag);
					$result=mysql_query($sql);
					while($rows=mysql_fetch_array($result))
					{
					echo "<option value='$rows[id]-$rows[address_identity]'";
					if($rows[id]==$type_of_address){echo "selected='selected'";}
					 echo ">$rows[type_of_comaddress_name]</option>";
					}
					?>
					</select>		
				</div>
			</div>
			
			<div <?php if($cresult['name']==''){?>style="display:none;" <?php }?> id="basedontype">
			<div class="form-group row" class="propname">
				<div class="col-md-6"><label class="form-label" for="name">Name :</label></div>
				<div class="col-md-6"> <input type="text" class="form-control" value="<?php echo $cresult['name'];?>" id="name" name="name"> </div>
			</div>
			<!--<div class="form-group row" class="propname">
				<div class="col-md-6"><label class="form-label" for="father_name">Father's Name :</label></div>
				<div class="col-md-6"> <input type="text" class="form-control" value="<?php echo $cresult['father_name'];?>" id="father_name" name="father_name"> </div>
			</div>-->
			</div>			
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="address1">Address Line 1 :</label></div>
				<div class="col-md-6"> <input type="text" class="form-control" value="<?php echo $cresult['address1'];?>" id="address1"  name="address1"> </div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="address2">Address Line 2 :</label></div>
				<div class="col-md-6"> <input type="text" class="form-control" id="address2" name="address2" value="<?php echo $cresult['address2'];?>"> </div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="address3">Address Line 3 :</label></div>
				<div class="col-md-6"> <input type="text" class="form-control" id="address3" name="address3" value="<?php echo $cresult['address3'];?>"> </div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="city">City :</label></div>
				<div class="col-md-6"> <input type="text" class="form-control" id="city" name="city" value="<?php echo $cresult['city'];?>"> </div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="country">Country :</label></div>
				<div class="col-md-6"> 
				<select class="form-control" name="country" id="country">
				<!--<option value="none">---------- Select Country----------</option>-->
				<?php 
				$query=mysql_query("SELECT * FROM country_master where country_code='IN'");
				while($result=mysql_fetch_array($query)){
				?>
				<option value="<?php echo $result['country_code'];?>" <?php if($result['country_code']==$cresult['country']){?> selected="selected" <?php }?>><?php echo $result['country_name'];?></option>
				<?php }?>
				</select>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="state">State</label></div>
				<div class="col-md-6" id="stateDiv">
					<select name="state" id="state" class="form-control">
					<option value="">--Select State--</option>
					<?php 
					$query=mysql_query("SELECT * from state_master WHERE country_code = 'IN'");
					while($result=mysql_fetch_array($query)){ ?>
					<option value="<?php echo $result['state_code'];?>" <?php if($result['state_code']==$cresult['state']){?> selected="selected" <?php }?>><?php echo $result['state_name'];?></option>
					<?php }?>
					</select>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="pincode">Pin Code :</label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="pincode" name="pincode" value="<?php echo $cresult['pincode'];?>" maxlength="6"></div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="landline_no1">Landline No :</label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="landline_no1" name="landline_no1" value="<?php echo $cresult['landline_no1'];?>"></div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="mobile_no">Mobile No. :</label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="mobile_no" name="mobile_no" value="<?php echo $cresult['mobile_no'];?>" maxlength="10"></div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="mobile_no">Email :</label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="email_id" name="email_id" value="<?php echo $cresult['email_id'];?>"/></div>
			</div>
			<?php
			if($type_of_firm==13 || $type_of_firm==12){
			?>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="pan_no">DIN No. :</label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="din_no" name="din_no" value="<?php echo $cresult['din_no'];?>"/></div>
			</div>
			<?php }?>
			
			<?php if($type_of_address==1 || $type_of_address==2 || $type_of_address==5 || $type_of_address==7 || $type_of_address==8 || $type_of_address==9 || $type_of_address==13){	?>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="pan_no">Pan No. :</label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="pan_no" name="pan_no" value="<?php echo $cresult['pan_no'];?>" /></div>
			</div>
			<?php } ?>
			
			<div <?php if($address_identity=="CTC"){ ?> style="display:none;" <?php } else {?><?php }?> id="basedontype">
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="Aadhar">Aadhar No :</label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="aadhar_no" name="aadhar_no" value="<?php echo $cresult['aadhar_no'];?>" maxlength="15" placeholder="Aadhar No" autocomplete="off"></div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="Passport">Passport No. :</label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="passport_no" name="passport_no" value="<?php echo $cresult['passport_no'];?>" maxlength="10" placeholder="Passport No" autocomplete="off"></div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="joining_date">Joining Date :</label></div>
				<div class="col-md-6"><input type="date" class="form-control" value="<?php echo $cresult['joining_date'];?>" id="joining_date" name="joining_date" placeholder="Joining Date" autocomplete="off"/></div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="retirement_date">Retirement Date :</label></div>
				<div class="col-md-6"><input type="date" class="form-control" value="<?php echo $cresult['retirement_date'];?>" id="retirement_date" name="retirement_date" placeholder="Retirement Date" autocomplete="off"/></div>
			</div>
			</div>
			<div <?php if($address_identity=="CTP"){ ?> style="display:none;" <?php } else {?><?php }?> id="basedontype">
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="gst_no">GSTIN :</label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="gst_no" name="gst_no" value="<?php echo $cresult['gst_no'];?>" placeholder="GSTIN" maxlength="15" autocomplete="off"/></div>
			</div>
			</div>
			<div class="row"><div class="col-md-12"><label class="form-label"/>Note- : Fill up name of all present partners and directores as the case may be</label></div></div>
			
			<input type="hidden" id="registration_id" name="registration_id" value="<?php echo $registration_id;?>"/>
			<input type="hidden" id="id" name="id" value="<?php echo $id;?>"/>
			<div class="row">
				<div class="col-md-12">
				<input type="button" value="Update" name="add_more" id="add_more" class="btn"/>
				</div>
			</div>
</form>
</div>
<?php }?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="paymentdetailsexport"){
$tot_examount=$_POST['paymentamnt'];

$membershipfees=0;
// current challan yr calculation
    $cur_year = (int)date('Y');
    $cur_month = (int)date('m');
    if ($cur_month < 4) {
     $cur_fin_yr = $cur_year-1;
	 $cur_finyr  = $cur_fin_yr . '-' . ($cur_fin_yr+1);
	 $last_finyr = ($cur_fin_yr-1) . '-' . $cur_fin_yr;
    }
    else {
     $cur_fin_yr = $cur_year;
 	 $cur_finyr  = $cur_fin_yr . '-' . ($cur_fin_yr+1);
	 $last_finyr = ($cur_fin_yr-1) . '-' . $cur_fin_yr;
    }
    $query=mysql_query("select * from export_amount_master where status=1 and financial_year='$cur_fin_yr'");
	while($result=mysql_fetch_array($query))
	{
		if($tot_examount>=$result['export_start_amount'] && $tot_examount<=$result['export_end_amount'])
		{
			echo $membershipfees=$result['membership_fee']."#";
			$admissionfees=$result['admission_fee'];
		}		
	}
	//$admissionfees="5000";
	echo $admissionfeesfinal=$admissionfees."#";
	$total_amnt=intval($membershipfees)+intval($admissionfees);
	echo $total_amnt_final=intval($membershipfees)+intval($admissionfees)."#";
	$service_tax=round(($total_amnt*18)/100);
	echo $service_tax_final=intval($service_tax)."#";
	echo $totpaybleamnt=intval($total_amnt)+intval($service_tax);
	
}
?>
<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="paymentdetailsimport"){
$tot_examount=$_POST['export_amnt'];
$paymentamnt_import=$_POST['paymentamnt_import'];
$membershipfees=0;
// current challan yr calculation
    $cur_year = (int)date('Y');
    $cur_month = (int)date('m');
    if ($cur_month < 4) {
     $cur_fin_yr = $cur_year-1;
	 $cur_finyr  = $cur_fin_yr . '-' . ($cur_fin_yr+1);
	 $last_finyr = ($cur_fin_yr-1) . '-' . $cur_fin_yr;
    }
    else {
     $cur_fin_yr = $cur_year;
 	 $cur_finyr  = $cur_fin_yr . '-' . ($cur_fin_yr+1);
	 $last_finyr = ($cur_fin_yr-1) . '-' . $cur_fin_yr;
    }
    $query=mysql_query("select * from export_amount_master where status=1 and financial_year='$cur_fin_yr'");
	while($result=mysql_fetch_array($query))
	{
		if($tot_examount>=$result['export_start_amount'] && $tot_examount<=$result['export_end_amount'])
		{
			echo $membershipfees=$result['membership_fee']."#";
			$admissionfees=$result['admission_fee'];
			$ad_valorem=$result['ad_valorem'];
			
		}		
	}
	//$admissionfees="5000";
	echo $admissionfeesfinal=$admissionfees."#";
	$total_amnt=intval($membershipfees)+intval($admissionfees);
	$ad_valorem=round((($paymentamnt_import*$ad_valorem)/100));
	echo $ad_valorem_final=round($ad_valorem)."#";
	echo $total_amnt_final=intval($membershipfees)+intval($admissionfees)+intval($ad_valorem)."#";
	$service_tax=round(($total_amnt*18)/100);
	echo $service_tax_final=intval($service_tax)."#";
	echo $totpaybleamnt=intval($total_amnt)+intval($service_tax);
}
?>


<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="paymentdetailsexport_renew"){
$tot_examount=$_POST['paymentamnt'];

$membershipfees=0;
// current challan yr calculation
    $cur_year = (int)date('Y');
    $cur_month = (int)date('m');
    if ($cur_month < 4) {
     $cur_fin_yr = $cur_year-1;
	 $cur_finyr  = $cur_fin_yr . '-' . ($cur_fin_yr+1);
	 $last_finyr = ($cur_fin_yr-1) . '-' . $cur_fin_yr;
    }
    else {
     $cur_fin_yr = $cur_year;
 	 $cur_finyr  = $cur_fin_yr . '-' . ($cur_fin_yr+1);
	 $last_finyr = ($cur_fin_yr-1) . '-' . $cur_fin_yr;
    }
	
	$qrenewded=mysql_query("select deadline_date from renewal_deadline_master");
	$rrenewded=mysql_fetch_array($qrenewded);
	$deadline_date=$rrenewded['deadline_date'];
	
	
    $query=mysql_query("select * from export_amount_master where status=1 and financial_year='$cur_fin_yr'");
	while($result=mysql_fetch_array($query))
	{
		if($tot_examount>=$result['export_start_amount'] && $tot_examount<=$result['export_end_amount'])
		{
			echo $membershipfees=$result['membership_fee']."#";
			
			if($deadline_date>=date("Y-m-d"))
			{
			$admissionfees='0';
			}else
			{
			$admissionfees=$result['admission_fee'];
			}
			
		}		
	}
	//$admissionfees="5000";
	echo $admissionfeesfinal=$admissionfees."#";
	$total_amnt=intval($membershipfees)+intval($admissionfees);
	echo $total_amnt_final=intval($membershipfees)+intval($admissionfees)."#";
	$service_tax=round(($total_amnt*18)/100);
	echo $service_tax_final=intval($service_tax)."#";
	echo $totpaybleamnt=intval($total_amnt)+intval($service_tax);
	
}
?>
<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="paymentdetailsimport_renew"){
$tot_examount=$_POST['export_amnt'];
$paymentamnt_import=$_POST['paymentamnt_import'];
$membershipfees=0;
// current challan yr calculation
    $cur_year = (int)date('Y');
    $cur_month = (int)date('m');
    if ($cur_month < 4) {
     $cur_fin_yr = $cur_year-1;
	 $cur_finyr  = $cur_fin_yr . '-' . ($cur_fin_yr+1);
	 $last_finyr = ($cur_fin_yr-1) . '-' . $cur_fin_yr;
    }
    else {
     $cur_fin_yr = $cur_year;
 	 $cur_finyr  = $cur_fin_yr . '-' . ($cur_fin_yr+1);
	 $last_finyr = ($cur_fin_yr-1) . '-' . $cur_fin_yr;
    }
	
	$qrenewded=mysql_query("select deadline_date from renewal_deadline_master");
	$rrenewded=mysql_fetch_array($qrenewded);
	$deadline_date=$rrenewded['deadline_date'];
	
	
    $query=mysql_query("select * from export_amount_master where status=1 and financial_year='$cur_fin_yr'");
	while($result=mysql_fetch_array($query))
	{
		if($tot_examount>=$result['export_start_amount'] && $tot_examount<=$result['export_end_amount'])
		{
			echo $membershipfees=$result['membership_fee']."#";
			
			if($deadline_date>=date("Y-m-d"))
			{
			$admissionfees='0';
			}else
			{
			$admissionfees=$result['admission_fee'];
			}
						
			$ad_valorem=$result['ad_valorem'];
			
		}		
	}
	//$admissionfees="5000";
	echo $admissionfeesfinal=$admissionfees."#";
	$total_amnt=intval($membershipfees)+intval($admissionfees);
	$ad_valorem=round((($paymentamnt_import*$ad_valorem)/100));
	echo $ad_valorem_final=round($ad_valorem)."#";
	echo $total_amnt_final=intval($membershipfees)+intval($admissionfees)+intval($ad_valorem)."#";
	$service_tax=round(($total_amnt*18)/100);
	echo $service_tax_final=intval($service_tax)."#";
	echo $totpaybleamnt=intval($total_amnt)+intval($service_tax);
}
?>
<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="chkregisuser"){
    $email_id=$_POST['email_id'];
    $query=mysql_query("select * from registration_master where email_id='$email_id' and status=1");
    $num=mysql_num_rows($query);
  if($num>0)
   {	
   		echo 0;
   }
   else
   	echo 1;
}
?>
<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="chkpan"){
    $company_pan_no=$_POST['company_pan_no'];
    $query=mysql_query("select * from registration_master where company_pan_no='$company_pan_no'");
    $num=mysql_num_rows($query);
  if($num>0)
   {	
   		echo 0;
   }
   else
   	echo 1;
}
?>



<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="chkregisuser"){
    $email_id=$_POST['email_id'];
    $query=mysql_query("select * from registration_master where email_id='$email_id' and status=1");
    $num=mysql_num_rows($query);
  if($num>0)
   {	
   		echo "Already registered with this email id";
   }
}
?>
<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="chkevent"){
	$registration_id=$_POST['registration_id'];
    $event_name=$_POST['event_name'];

    $query=mysql_query("SELECT * FROM `mia_application_form` WHERE event_name='$event_name' and registration_id='$registration_id'");
    $num=mysql_num_rows($query);
  if($num>0)
   {	
   		echo "Already Selected This Event";
   }
}
?>