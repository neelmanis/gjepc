<?php 
session_start();
include('db.inc.php');
include('functions.php');
?>

<?php
if(isset($_POST['actionType']) && $_POST['actionType']=="captureBannerClick"){
$href=$_POST['href'];
$ip_address = $_SERVER['REMOTE_ADDR'];
$query=$conn->query("INSERT INTO advertise_banner_click_manager SET platform='web',ip_address='$ip_address',`link`='$href'");
echo json_encode(array("status"=>"success","href"=>$href));
} 

/* Neel Home page Banner Hits*/
if(isset($_POST['actionType']) && $_POST['actionType']=="captureBannerHits")
{
$banner_id = $_POST['id'];
$ip_address = $_SERVER['REMOTE_ADDR'];
$post_date=date('Y-m-d');
$browser = get_browser_name($_SERVER['HTTP_USER_AGENT']);
$user_query = "select * from banner_hits where IP_address='$ip_address' AND banner_id='$banner_id'";
$result_user= $conn->query($user_query);
$num = $result_user->num_rows;
if($num==0)
{
$query=$conn->query("INSERT INTO banner_hits SET `banner_id`='$banner_id',ip_address='$ip_address',website='GJEPC',post_date='$post_date',browser='$browser'");
echo json_encode(array("status"=>"success","banner_id"=>$banner_id));
} else {
	echo json_encode(array("status"=>"already","banner_id"=>$banner_id));
}	
} 
?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getCity"){
$country=$_POST['country'];
$query=mysql_query("SELECT * from state_master WHERE country_code = '$country'");
if($country=="IN"){ ?>
      <select name="state" id="state" class="form-control">
      <option value="">--Select State--</option>
      <?php while($result=mysql_fetch_array($query)){?>
      <option value="<?php echo $result['state_code'];?>"><?php echo $result['state_name'];?></option>
      <?php } ?>
      </select>

<?php } else { ?>

<input type="text" class="form-control" value="" id="state" name="state" />

<?php } ?>
<?php } ?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getTaxation"){
$country = filter($_POST['country']);
if($country!=''){
$row = $conn->query("SELECT * from taxation_master WHERE country_code = '$country'");
?>
      <select name="taxation_code" id="taxation_code" class="form-control">
      <option value="">--Select Taxaiton Detail--</option>
      <?php while($result=$row->fetch_assoc()){ ?>
      <option value="<?php echo $result['taxation_code'];?>"><?php echo $result['taxation_description'];?></option>
      <?php } ?>
      </select>
<?php } } ?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="comaddress"){
if(isset($_POST['id']) && $_POST['id']!=""){$id=$_POST['id'];}else{$id="";}
$registration_id = filter($_POST['registration_id']);
$type_of_addresss = $_POST['type_of_address'];
$tmp = explode("-", $type_of_addresss);

$type_of_address = $tmp[0];
$address_identity = $tmp[1];

if(!empty($type_of_address)){
	if($type_of_address==2){ $type_of_address_sap = "P"; }
	else { $type_of_address_sap = "C"; }
} else { echo "Type of Address missing"; }

if(isset($_POST['name']) && $_POST['name']!=""){ $name = strtoupper(filter($_POST['name'])); } else { $name=""; }
if(isset($_POST['designation']) && $_POST['designation']!=""){$designation=$_POST['designation'];}else{$designation="";}
if(isset($_POST['father_name']) && $_POST['father_name']!=""){$father_name=$_POST['father_name'];}else{$father_name="";}
if(isset($_POST['address1']) && $_POST['address1']!=""){ $address1	=	filter($_POST['address1']);	}	else	{	$address1="";}
if(isset($_POST['address2']) && $_POST['address2']!=""){ $address2	=	filter($_POST['address2']);	}	else	{	$address2="";}
if(isset($_POST['address3']) && $_POST['address3']!=""){ $address3	=	filter($_POST['address3']);	}	else	{	$address3="";}
$city	=	strtoupper(filter($_POST['city']));
$country =	filter($_POST['country']);
if($_POST['state']!=""){ $state = $_POST['state']; }
$pincode = filter($_POST['pincode']);
if(isset($_POST['landline_no1']) && $_POST['landline_no1']!=""){$landline_no1=$_POST['landline_no1'];}else{$landline_no1="";}
if(isset($_POST['mobile_no']) && $_POST['mobile_no']!=""){$mobile_no=$_POST['mobile_no'];}else{$mobile_no="";}
if(isset($_POST['fax_no1']) && $_POST['fax_no1']!=""){$fax_no1=$_POST['fax_no1'];}else{$fax_no1="";}
if(isset($_POST['fax_no2']) && $_POST['fax_no2']!=""){$fax_no2=$_POST['fax_no2'];}else{$fax_no2="";}
$email_id = filter($_POST['email_id']);
$din_no	  = filter($_POST['din_no']);

if(!empty($type_of_address)){
	if($type_of_address==2 || $address_identity=="CTP"){ $pan_no = strtoupper(filter($_POST['pan_no'])); }	else { $pan_no = ""; }
} else { echo "Type of Address missing"; }

$gst_no		  = strtoupper(filter($_POST['gst_no']));
$aadhar_no    = strtoupper(filter($_POST['aadhar_no']));
$passport_no  = strtoupper(filter($_POST['passport_no']));
$joining_date = filter($_POST['joining_date']);
$retirement_date = filter($_POST['retirement_date']);
if($joining_date==''){  $joining_date = date('Y/m/d'); }
if($retirement_date==''){  $retirement_date = date('Y/m/d'); }
$dt = date('Y/m/d'); 

$qcheck = $conn->query("select * from communication_address_master where id='$id' and registration_id='$registration_id'");
$rcheck = $qcheck->num_rows;
if($rcheck>0){
$upx = $conn->query("update communication_address_master set type_of_address='$type_of_address',address_identity='$address_identity',type_of_address_sap='$type_of_address_sap',name='$name',father_name='$father_name',designation='$designation',address1='$address1',address2='$address2',address3='$address3',city='$city',country='$country',state='$state',pincode='$pincode',landline_no1='$landline_no1',mobile_no='$mobile_no',fax_no1='$fax_no1',fax_no2='$fax_no2',email_id='$email_id',din_no='$din_no',pan_no='$pan_no',gst_no='$gst_no',aadhar_no='$aadhar_no',passport_no='$passport_no',joining_date='$joining_date',retirement_date='$retirement_date' where id='$id' and registration_id='$registration_id'");
}
else
{
$upx = $conn->query("insert into communication_address_master set registration_id='$registration_id',type_of_address='$type_of_address',address_identity='$address_identity',type_of_address_sap='$type_of_address_sap',name='$name',father_name='$father_name',designation='$designation',address1='$address1',address2='$address2',address3='$address3',city='$city',country='$country',state='$state',pincode='$pincode',landline_no1='$landline_no1',mobile_no='$mobile_no',fax_no1='$fax_no1',fax_no2='$fax_no2',email_id='$email_id',din_no='$din_no',pan_no='$pan_no',gst_no='$gst_no',aadhar_no='$aadhar_no',passport_no='$passport_no',joining_date='$joining_date',retirement_date='$retirement_date',status=1,post_date='$dt'");
}
$comx = $conn->query("select * from communication_address_master where registration_id='$registration_id'");
while($result = $comx->fetch_assoc()){
?>
<tr>
    <td style="padding:5px;"><?php echo getaddresstype($result['type_of_address'],$conn);?></td>
    <td style="padding:5px;text-transform:uppercase;"><?php echo strtoupper(filter($result['address1']));?>,<?php echo strtoupper(filter($result['address2']));?>,<?php echo strtoupper(filter($result['address3']));?>,<?php echo strtoupper(filter($result['city']));?>,<?php echo strtoupper(filter($result['state']));?>,<?php echo strtoupper(filter($result['pincode']));?></td>
    <td style="padding:5px;text-transform:uppercase;"><?php echo strtoupper(filter($result['name']));?></td>
    <td style="padding:5px;cursor:pointer;" class="editAdd <?php echo $result['id'];?> <?php echo $registration_id;?>">EDIT</td>
    <td style="padding:5px;cursor:pointer;" class="deleteAdd <?php echo $result['id'];?> <?php echo $registration_id;?>">DELETE</td>
</tr>
<?php }} ?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="deleteAdd"){
$id = filter($_POST['id']);
$registration_id = filter($_POST['registration_id']);
$delx = $conn ->query("delete from communication_address_master where id='$id' and registration_id='$registration_id'");

$svx = $conn ->query("select * from communication_address_master where registration_id='$registration_id'");
while($result = $svx->fetch_assoc()){
?>
<tr>
<td style="padding:5px;text-transform:uppercase;"><?php echo getaddresstype($result['type_of_address']);?></td>
<td style="padding:5px;text-transform:uppercase;"><?php echo $result['address1'];?><?php if($result['address2']!=""){echo ",".$result['address2'];}?><?php if($result['address3']!=""){echo ",".$result['address3'];}?><?php if($result['city']!=""){echo ",".$result['city'];}?><?php if($result['state']!=""){echo ",".$result['state'];}?><?php if($result['pincode']!=""){echo ",".$result['pincode'];}?></td>
<td style="padding:5px;text-transform:uppercase;"><?php echo $result['name'];?></td>
<td style="padding:5px;cursor:pointer;" class="editAdd <?php echo $result['id'];?> <?php echo $registration_id;?>">EDIT</td> 
<td style="padding:5px;cursor:pointer;" class="deleteAdd <?php echo $result['id'];?> <?php echo $registration_id;?>">DELETE</td>
</tr>
<?php }} ?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="rcmc_certificate_apply"){
$registration_id = intval($_POST['registration_id']);
$result = $conn ->query("update approval_master set rcmc_certificate_apply='Y' where registration_id='$registration_id'");
	
	$region = getRegion($registration_id,$conn);
	if($region=='HO-MUM (M)'){$to='mithun@gjepcindia.com,archana@gjepcindia.com,kuldip@gjepcindia.com';}
	if($region=='RO-CHE'){$to='bhanu.prasad@gjepcindia.com';}
	if($region=='RO-DEL'){$to='madaan@gjepcindia.com';}
	if($region=='RO-JAI'){$to='sasi@gjepcindia.com';}
	if($region=='RO-KOL'){$to='salim@gjepcindia.com';}
	if($region=='RO-SRT'){$to='Rachna.Shah@gjepcindia.com';}
	$userinfo = $conn ->query("select * from information_master where registration_id='$registration_id'");
	$user_result = $userinfo->fetch_assoc();
	$company_name=$user_result['company_name'];
	$iec_no=$user_result['iec_no'];
	$email_id=$user_result['email_id'];
    $name=$user_result['name'];
		
$message ='<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:"Lucida Sans"; font-size:14px; color:#333333; text-align:justify;">
  <tr>
    <td colspan="2"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="150" align="left"><img src="https://gjepc.org/assets/images/logo.png" width="150" height="91" /></td>
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
	 $headers  = 'MIME-Version: 1.0' . "\n"; 
	 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
	 $headers .= 'From:admin@gjepc.org';			
	 mail($to, $subject, $message, $headers);
 } ?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="editAdd"){
$id = intval(filter($_POST['id']));
$registration_id = intval(filter($_POST['registration_id']));

$info_status =  $conn ->query("select member_type_id,type_of_firm,status from information_master where registration_id='$registration_id' and status=1");
$info_row = $info_status->fetch_assoc();
$member_type_id=$info_row['member_type_id'];
$type_of_firm=$info_row['type_of_firm'];

$cquery =  $conn ->query("select * from communication_address_master where id='$id' and registration_id='$registration_id'");
$cresult = $cquery->fetch_assoc();
$type_of_address = filter($cresult['type_of_address']);
$address_identity = filter($cresult['address_identity']);
$designation = filter($cresult['designation']);

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
		<style>
		#type_of_address option[disabled] {
		  display: none;
		}
		</style>
<div class="form-block">
<form id="comaddress" name="comaddress" class="row">
<input type="hidden" name="hidden" id="hidden" value=""/>
			<div class="form-group col-sm-6">
				<label class="form-label" for="type_of_address">Type of Communication Address :</label>				
					<select class="form_text_text" id="type_of_address" name="type_of_address">
					<option value="none">---- Select ----</option>
					<?php
					$sql=getCommunicationAddress($addflag);
					$result = $conn ->query($sql);
					while($rows = $result->fetch_assoc())
					{
					echo "<option value='$rows[id]-$rows[address_identity]'";
					if($rows[id]==$type_of_address){ echo "selected='selected'"; } if($rows['id']==14){ echo "disabled='disabled'"; } echo ">$rows[type_of_comaddress_name]</option>";
					}
					?>
					</select>		
			</div>
			
			<div class="form-group col-sm-6" <?php if($cresult['name']==''){?>style="display:none;" <?php } ?> id="basedontype">
				<label class="form-label" for="name">Name :</label>
				<input type="text" class="form-control" value="<?php echo strtoupper(filter($cresult['name']));?>" id="name" name="name">
			</div>
			
			<div class="form-group col-sm-6" <?php if(($address_identity=="CTP" || $address_identity=="CTC") && $type_of_address!=13){ ?> style="display:none;" <?php } else { ?><?php }?> id="basedonauth">
				<label class="form-label" for="name">Designation :</label>				
				<select class="form-control" name="designation" id="designation">
					<option value="">---- Select Designation ----</option>
					<option value="Partner" <?php if($designation=="Partner") echo 'selected="selected"'; ?>>Partner</option>
					<option value="Director" <?php if($designation=="Director") echo 'selected="selected"'; ?>>Director</option>
					<option value="Proprietor" <?php if($designation=="Proprietor") echo 'selected="selected"'; ?>>Proprietor</option>
				</select>
			</div>
			
			<div class="form-group col-sm-6">
				<label class="form-label" for="address1">Address Line 1 :</label>
				<input type="text" class="form-control" value="<?php echo $cresult['address1'];?>" id="address1" name="address1" autocomplete="off" maxlength="50">
			</div>
			<div class="form-group col-sm-6">
				<label class="form-label" for="address2">Address Line 2 :</label>
				<input type="text" class="form-control" id="address2" name="address2" value="<?php echo $cresult['address2'];?>" autocomplete="off" maxlength="50">
			</div>
			<div class="form-group col-sm-6">
				<label class="form-label" for="address3">Address Line 3 :</label>
				<input type="text" class="form-control" id="address3" name="address3" value="<?php echo $cresult['address3'];?>" autocomplete="off" maxlength="50">
			</div>
			<div class="form-group col-sm-6">
				<label class="form-label" for="city">City :</label>
				<input type="text" class="form-control" id="city" name="city" value="<?php echo strtoupper(filter($cresult['city']));?>"maxlength="20">
			</div>
			<div class="form-group col-sm-6">
				<label class="form-label" for="country">Country :</label>
				<select class="form-control" name="country" id="country">
				<?php
				$getCountry = "SELECT * FROM country_master where country_code='IN'";
				$query = $conn -> prepare($getCountry);
				$query -> execute();			
				$row = $query->get_result();
				while($result = $row->fetch_assoc()){
				?>
				<option value="<?php echo $result['country_code'];?>" <?php if($result['country_code']==$cresult['country']){?> selected="selected" <?php }?>><?php echo strtoupper(filter($result['country_name']));?></option>
				<?php } ?>
				</select>
			</div>
			<div class="form-group col-sm-6" id="stateDiv">
				<label class="form-label" for="state">State</label>
					<select name="state" id="state" class="form-control">
					<option value="">--Select State--</option>
					<?php 
					$getState = "SELECT * from state_master WHERE country_code = 'IN'";
					$squery = $conn -> prepare($getState);
					$squery -> execute();			
					$srow = $squery->get_result();
					while($result = $srow->fetch_assoc()){  ?>
					<option value="<?php echo $result['state_code'];?>" <?php if($result['state_code']==$cresult['state']){?> selected="selected" <?php }?>><?php echo strtoupper(filter($result['state_name']));?></option>
					<?php }?>
					</select>
			</div>
			<div class="form-group col-sm-6">
				<label class="form-label" for="pincode">Pin Code :</label>
				<input type="text" class="form-control" id="pincode" name="pincode" value="<?php echo filter($cresult['pincode']);?>" maxlength="6" autocomplete="off">
			</div>
			<div class="form-group col-sm-6">
				<label class="form-label" for="landline_no1">Landline No :</label>
				<input type="text" class="form-control" id="landline_no1" name="landline_no1" value="<?php echo filter($cresult['landline_no1']);?>" maxlength="15" autocomplete="off">
			</div>
			<div class="form-group col-sm-6">
				<label class="form-label" for="mobile_no">Mobile No. :</label>
				<input type="text" class="form-control" id="mobile_no" name="mobile_no" value="<?php echo filter($cresult['mobile_no']);?>" maxlength="10" autocomplete="off">
			</div>
			<div class="form-group col-sm-6">
				<label class="form-label" for="mobile_no">Email :</label>
				<input type="text" class="form-control" id="email_id" name="email_id" value="<?php echo filter($cresult['email_id']);?>"/>
			</div>
			<?php if($type_of_firm==13 || $type_of_firm==12){ ?>
			<div class="form-group col-sm-6">
				<label class="form-label" for="pan_no">DIN No. :</label>
				<input type="text" class="form-control" id="din_no" name="din_no" value="<?php echo filter($cresult['din_no']);?>"/>
			</div>
			<?php } ?>
			
			<?php if($type_of_address==1 || $type_of_address==2 || $type_of_address==5 || $type_of_address==7 || $type_of_address==8 || $type_of_address==9 || $type_of_address==13){	?>
			<div class="form-group col-sm-6">
				<label class="form-label" for="pan_no">PAN No. :</label>
				<input type="text" class="form-control" id="pan_no" name="pan_no" value="<?php echo strtoupper(filter($cresult['pan_no']));?>" maxlength="10" minlength="10" autocomplete="off" />
			</div>
			<?php } ?>
			
			<div class="form-group col-sm-6" <?php if($address_identity=="CTC"){ ?> style="display:none;" <?php } else { ?><?php }?> id="basedontype">
				<label class="form-label" for="Aadhar">Aadhar No :</label>
				<input type="text" class="form-control" id="aadhar_no" name="aadhar_no" value="<?php echo $cresult['aadhar_no'];?>" maxlength="15" placeholder="Aadhar No" autocomplete="off">
			</div>
			<div class="form-group col-sm-6">
				<label class="form-label" for="Passport">Passport No. :</label>
				<input type="text" class="form-control" id="passport_no" name="passport_no" value="<?php echo $cresult['passport_no'];?>" maxlength="10" placeholder="Passport No" autocomplete="off">
			</div>
			<div class="form-group col-sm-6">
				<label class="form-label" for="joining_date">Joining Date :</label>
				<input type="date" class="form-control" value="<?php echo $cresult['joining_date'];?>" id="joining_date" name="joining_date" placeholder="Joining Date" autocomplete="off"/>
			</div>
			<div class="form-group col-sm-6">
				<label class="form-label" for="retirement_date">Retirement Date :</label>
				<input type="date" class="form-control" value="<?php echo $cresult['retirement_date'];?>" id="retirement_date" name="retirement_date" placeholder="Retirement Date" autocomplete="off"/>
			</div>
			
			<div class="form-group col-sm-6" <?php if($address_identity=="CTP"){ ?> style="display:none;" <?php } else {?><?php }?> id="basedontype">
				<label class="form-label" for="gst_no">GSTIN :</label>
				<input type="text" class="form-control" id="gst_no" name="gst_no" value="<?php echo strtoupper(filter($cresult['gst_no']));?>" placeholder="GSTIN" maxlength="15" autocomplete="off"/>
			</div>
			
			
			<div class="row"><div class="col-md-12"><label class="form-label"/>Note- : Fill up name of all present partners and directores as the case may be</label></div></div>
			
			<input type="hidden" id="registration_id" name="registration_id" value="<?php echo $registration_id;?>"/>
			<input type="hidden" id="id" name="id" value="<?php echo $id;?>"/>
			<div class="row">
			<div class="col-md-12">
			<input type="button" value="Update" name="add_more" id="add_more" class="cta"/>
			</div>
			</div>
</form>
</div>
<?php } ?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="paymentdetailsexport"){
$tot_examount=$_POST['paymentamnt'];
$gst_holder=$_POST['gst_holder'];

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
	if($gst_holder=="N"){
		echo $membershipfees="1000"."#";
		echo $admissionfeesfinal="0"."#";
		echo $total_amnt_final=intval(1000)."#";
		echo $service_tax_final=intval(180)."#";
		echo $totpaybleamnt=intval(1180);
	}else{
    $query = $conn ->query("select * from export_amount_master where status=1 and financial_year='$cur_fin_yr'");
	while($result= $query->fetch_assoc())
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
	
	if($_SESSION['sez_member']=="Y")
		$service_tax=0;
	else
		$service_tax=round(($total_amnt*18)/100);
	
	echo $service_tax_final=intval($service_tax)."#";
	echo $totpaybleamnt=intval($total_amnt)+intval($service_tax);
	}
}
?>
<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="paymentdetailsimport"){
$tot_examount=$_POST['export_amnt'];
$paymentamnt_import=$_POST['paymentamnt_import'];
$gst_holder=$_POST['gst_holder'];
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
	if($gst_holder=="N"){
		echo $membershipfees="1000"."#";
		echo $admissionfeesfinal="0"."#";
		echo $ad_valorem_final=round(0)."#";
		echo $total_amnt_final=intval(1000)."#";
		echo $service_tax_final=intval(180)."#";
	    echo $totpaybleamnt=intval(1180);
	}else{
    $query = $conn ->query("select * from export_amount_master where status=1 and financial_year='$cur_fin_yr'");
	while($result = $query->fetch_assoc())
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
	
	if($_SESSION['sez_member']=="Y")
		$service_tax=0;
	else
		$service_tax=round(($total_amnt*18)/100);
		
	echo $service_tax_final=intval($service_tax)."#";
	echo $totpaybleamnt=intval($total_amnt)+intval($service_tax);
 }
}
?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="paymentdetailsexport_renew"){
$tot_examount = $_POST['paymentamnt'];
$gst_holder = $_POST['gst_holder'];

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
	if($gst_holder=="N"){
		echo $membershipfees="1000"."#";
		echo $admissionfeesfinal="0"."#";
		echo $total_amnt_final=intval(1000)."#";
		echo $service_tax_final=intval(180)."#";
		echo $totpaybleamnt=intval(1180);
	} else {
	$qrenewded = $conn ->query("select deadline_date from renewal_deadline_master");
	$rrenewded = $qrenewded->fetch_assoc();
	$deadline_date=$rrenewded['deadline_date'];	
	
    $query = $conn ->query("select * from export_amount_master where status=1 and financial_year='$cur_fin_yr'");
	while($result = $query->fetch_assoc())
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
	
	if($_SESSION['sez_member']=="Y")
		$service_tax=0;
	else
	$service_tax=round(($total_amnt*18)/100);
	
	echo $service_tax_final=intval($service_tax)."#";
	echo $totpaybleamnt=intval($total_amnt)+intval($service_tax);
	}
}
?>
<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="paymentdetailsimport_renew"){
$tot_examount=$_POST['export_amnt'];
$paymentamnt_import=$_POST['paymentamnt_import'];
$gst_holder=$_POST['gst_holder'];
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
	if($gst_holder=="N"){
		echo $membershipfees="1000"."#";
		echo $admissionfeesfinal="0"."#";
		echo $ad_valorem_final=round(0)."#";
		echo $total_amnt_final=intval(1000)."#";
		echo $service_tax_final=intval(180)."#";
	    echo $totpaybleamnt=intval(1180);
	} else {
	$qrenewded = $conn ->query("select deadline_date from renewal_deadline_master");
	$rrenewded = $qrenewded->fetch_assoc();
	$deadline_date=$rrenewded['deadline_date'];
		
    $query = $conn ->query("select * from export_amount_master where status=1 and financial_year='$cur_fin_yr'");
	while($result = $query->fetch_assoc())
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
	
	if($_SESSION['sez_member']=="Y")
		$service_tax=0;
	else
	$service_tax=round(($total_amnt*18)/100);
	
	echo $service_tax_final=intval($service_tax)."#";
	echo $totpaybleamnt=intval($total_amnt)+intval($service_tax);
	}
}
?>
<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="chkregisuser"){
    $email_id = filter($_POST['email_id']);
	if($email_id!=''){
    $query = $conn->query("select email_id from registration_master where email_id='$email_id' limit 1");
    $num = $query->num_rows;
	if($num>0)
	{	
   		echo 0;
	} else
		echo 1;
	}
}
?>
<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="chkpan")
{
    $company_pan_no = trim(strtoupper($_POST['company_pan_no']));
	if($company_pan_no!=''){
    $query=$conn->query("select * from registration_master where company_pan_no='$company_pan_no'");
    $num=$query->num_rows;
	if($num>0)
	{	
   		echo 0;
	} else
		echo 1;
	}
}
?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="chkdata")
{
	$cat_id = $_POST['cat_id'];
    $search = trim(strtoupper($_POST['search']));
    	
	if($search!='' && strlen($search)>2){
	$query = $conn ->query("SELECT * FROM `circulars_master` WHERE status='1' and name like '%".$search."%'");
	$num=$query->num_rows;
	if($num>0){
	while($result = $query->fetch_assoc())
	{?>
		<div class="col-12">
		<a href="admin/Circulars/<?php echo $result['upload_circulars'];?>" target="_blank" class="new_pdf_wrp">
			<p class="blue"><?php echo $result['post_date'];?></p> 
			<div class="circular_text"><?php echo filter($result['name']);?></div>
		</a>
		</div>
	<?php }
	} else { ?>
		<div class="col-12">
		<a href="#" target="_blank" class="new_pdf_wrp">
			<p class="blue"></p> 
			<div class="circular_text">Not Found</div>
		</a>
		</div>
	<?php }	
	}else{
	
	$query = $conn ->query("SELECT * FROM `circulars_master` WHERE 1 and status='1' and cat_id='$cat_id' order by post_date desc");
	while($result = $query->fetch_assoc()){ ?>
		<div class="col-12">
		<a href="admin/Circulars/<?php echo $result['upload_circulars'];?>" target="_blank" class="new_pdf_wrp">
			<p class="blue"><?php echo $result['post_date'];?></p> 
			<div class="circular_text"><?php echo filter($result['name']);?></div>
		</a>
		</div>
	<?php }
	}
}
?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="chkgdata")
{
	$govt_id = $_POST['govt_id'];
    $gsearch = trim(strtoupper($_POST['gsearch']));
    	
	if($gsearch!=''){
		//echo "SELECT * FROM `circulars_to_member_master` WHERE status='1' and name like '%".$gsearch."%'";
	$query = $conn ->query("SELECT * FROM `circulars_to_member_master` WHERE status='1' and name like '%".$gsearch."%'");
	$num=$query->num_rows;
	if($num>0){
	while($result = $query->fetch_assoc())
	{?>
		<div class="col-12">
		<a href="admin/Circulars/<?php echo $result['upload_circulars'];?>" target="_blank" class="new_pdf_wrp">
			<p class="blue"><?php echo $result['post_date'];?></p> 
			<div class="circular_text"><?php echo filter($result['name']);?></div>
		</a>
		</div>
	<?php }
	} else { ?>
		<div class="col-12">
		<a href="#" target="_blank" class="new_pdf_wrp">
			<p class="blue"></p> 
			<div class="circular_text">Not Found</div>
		</a>
		</div>
	<?php }	
	} else {
	
	$query = $conn ->query("SELECT * FROM `circulars_to_member_master` WHERE 1 and status='1' and cat_id='$govt_id' order by post_date desc");
	while($result = $query->fetch_assoc()){ ?>
		<div class="col-12">
		<a href="admin/Circulars/<?php echo $result['upload_circulars'];?>" target="_blank" class="new_pdf_wrp">
			<p class="blue"><?php echo $result['post_date'];?></p> 
			<div class="circular_text"><?php echo filter($result['name']);?></div>
		</a>
		</div>
	<?php }
	}
}
?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="chkHeadeMob1"){
	$association_head_mobile_no1 = filter($_POST['association_head_mobile_no1']);
	if($association_head_mobile_no1!=''){
    $query = $conn->query("select association_head_mobile_no1 from parichay_card where association_head_mobile_no1='$association_head_mobile_no1'");
    $num = $query->num_rows;
	if($num>0)
	{	
   		echo 0;
	} else {
		echo 1;
	}
	}
}

if(isset($_POST['actiontype']) && $_POST['actiontype']=="chkAssocRegisNo"){
	$association_registration_no = filter($_POST['association_registration_no']);
	$parichay_card_id = filter($_POST['parichay_card_id']);
	if($association_registration_no!=''){
	if($parichay_card_id != 0){
    $query = $conn->query("select association_registration_no from parichay_card where association_registration_no='$association_registration_no' AND parichay_card_id !=$parichay_card_id");
	} else {
	$query = $conn->query("select association_registration_no from parichay_card where  association_registration_no='$association_registration_no'");	
	}
    $num = $query->num_rows;
	if($num>0)
	{	
   		echo 0;
	} else {
		echo 1;
	}
	}
}

if(isset($_POST['actiontype']) && $_POST['actiontype']=="chkAuthMobNo"){
	$authorised_mobile1 = filter($_POST['authorised_mobile1']);
	if($authorised_mobile1!=""){
    $query = $conn->query("select authorised_mobile1 from parichay_card where authorised_mobile1='$authorised_mobile1'");
    $num = $query->num_rows;
	if($num>0)
	{	
   		echo 0;
	} else {
		echo 1;
	}
	} else { echo 2; }
}

if(isset($_POST['actiontype']) && $_POST['actiontype']=="chkAuthEmail"){
	$authorised_email = filter($_POST['authorised_email']);
	$parichay_card_id = filter($_POST['parichay_card_id']);
	if($authorised_email!=""){
		if($parichay_card_id != 0){  
		$query = $conn->query("select authorised_email from parichay_card where authorised_email='$authorised_email' AND parichay_card_id !=$parichay_card_id");
		} else {
		$query = $conn->query("select authorised_email from parichay_card where authorised_email='$authorised_email'");
		}
		
		$num = $query->num_rows;
		if($num>0)
		{	
			echo 0;
		} else {
			echo 1;
		}
	}
}

/*...........................Send OTP..............................*/
if(isset($_POST['actionType']) && $_POST['actionType']=="sendOTP"){
   $mobile_no = trim($_POST['authorised_mobile1']);
   		do {
 		$otp = substr(uniqid (rand(), true),0,4);
		$result = $conn->query("select * from parichay_card_otp_check where mobile_no='$mobile_no' and otp='$otp'");
		} while($num=$result->num_rows>0);
		$message="One Time Password for Association Registration is.".$otp.", Regards GJEPC";
		$result1=$conn->query("select * from parichay_card_otp_check where mobile_no='$mobile_no'");
		$num1=$result1->num_rows;
		if($num1>0){
		$isSent = get_data($message,$mobile_no);
		if($isSent ==TRUE){
		$conn->query("update parichay_card_otp_check set otp='$otp',check_status='0' where mobile_no='$mobile_no'");
		}else { echo 'Not send'; }
		}
	else {
		$isSent = get_data($message,$mobile_no);
		if($isSent ==TRUE){
		$conn->query("insert into parichay_card_otp_check set mobile_no='$mobile_no',otp='$otp',check_status='0'");
		}
	}	
}

/*...........................Verify OTP..............................*/
if(isset($_POST['actionType']) && $_POST['actionType']=="verifyOTP"){
	$mobile_no = trim($_POST['mobile_no']);
	$otp = $_POST['otp'];
	$otp=str_replace(" ","",$otp);
	$otp=str_replace(";","",$otp);
	$otp=str_replace("-","",$otp);
	$otp=str_replace("|","",$otp);
	$otp=str_replace("'","",$otp);
	$otp=str_replace("\"","",$otp);
	
    $result=$conn->query("select * from parichay_card_otp_check where mobile_no='$mobile_no' and otp='$otp'");
	$row=$result->fetch_assoc();
    $num=$result->num_rows;
	if($row['check_status']=="0")
	{	
		$conn->query("update parichay_card_otp_check set check_status='1' where mobile_no='$mobile_no' and otp='$otp'");
		echo "verify";
	}
	elseif($row['check_status']=="1")
	{
		echo "verified";
	}
	else
	{
		echo "invalid";
	}
}

if(isset($_POST['actionType']) && $_POST['actionType']=="verify_membership"){
    $bpno = $_POST['bpno'];

    if($bpno!='') {
    $registration_id = getRegidBP($_POST['bpno'],$conn);
//	if($registration_id!='') {
		
	$ckAppliedForparichay = isApplied_for_parichay($registration_id,$conn);
	if($ckAppliedForparichay!=''){
	echo json_encode(array("status"=>"alreadyApplied")); exit;
	} else {
		$sqlx = "SELECT * FROM `approval_master` WHERE 1 and `registration_id`='$registration_id' and issue_membership_certificate_expire_status='Y'";	
		$resultx = $conn->query($sqlx);
		$row   = $resultx->fetch_assoc();
		$num   = $resultx->num_rows;
		if($num>0)
		{			
			$_SESSION['parichay_type'] ='M';
			$_SESSION['registration_id']= $registration_id;
			echo json_encode(array("status"=>"member")); exit;
		} else {
			echo json_encode(array("status"=>"nonMember")); exit;
		}
	}
	} else {
		echo json_encode(array("status"=>"bp_blank")); exit;
	} 
	
}


/* NonMember Check */
// if(isset($_POST['actiontype']) && $_POST['actiontype']=="checkDetails"){
// 	$email_id = filter($_REQUEST['email_id']);
// 	if($email_id!='') {
// 	$sqlx = "SELECT id,email_id,company_pan_no from registration_master where (email_id='$email_id' OR company_pan_no='$email_id') limit 1";	
// 	$resultx = $conn->query($sqlx);
// 	$row   = $resultx->fetch_assoc();
//     $num   = $resultx->num_rows;
//     if($num>0)
//     {
// 		$ckAppliedForparichay = isApplied_for_parichay($row['id'],$conn);
// 		if($ckAppliedForparichay!=''){ 
// 		echo json_encode(array("status"=>"alreadyApplied")); exit;
// 		} else {
// 		$sql="SELECT * FROM `approval_master` WHERE 1 and `registration_id`='".$row['id']."' AND issue_membership_certificate_expire_status='Y'";
// 		$result = $conn->query($sql);
// 		$num_rows = $result->num_rows;
// 		if($num_rows>0)
// 		{
// 			$_SESSION['parichay_type'] ='M';
// 		} else {
// 			$_SESSION['parichay_type'] ='NM';
// 		}
// 		$_SESSION['registration_id'] = $row['id'];
// 		echo json_encode(array("status"=>'exist','parichay_type'=>$_SESSION['parichay_type'])); exit;
// 		}
//     } else {
// 		unset($_SESSION['registration_id']);
// 		$_SESSION['parichay_type'] ='NM';
// 		echo json_encode(array("status"=>"notExist")); exit;
// 	}
// 	} else {
// 		unset($_SESSION['registration_id']);
// 		unset($_SESSION['parichay_type']);
// 		echo json_encode(array("status"=>"blank")); exit;
// 	}
// }

/* Parichay Member */
if(isset($_POST['actiontype']) && $_POST['actiontype']=="chkPersonMobNo"){
	$mobile1 = filter($_POST['mobile1']);
	if($mobile1!=''){
    $query = $conn->query("select mobile1 from parichay_person_details where mobile1='$mobile1'");
    $num = $query->num_rows;
	if($num>0)
	{	
   		echo 1;
	} else {
		echo 0;
	}
	} else { echo 2; }
}

/*...........................Send OTP..............................*/
if(isset($_POST['actionType']) && $_POST['actionType']=="sendPersonOTP"){
   $mobile_no = trim($_POST['mobile1']);
   		do {
 		$otp = substr(uniqid (rand(), true),0,4);
		$result = $conn->query("select mobile_no from parichay_person_otp_check where mobile_no='$mobile_no' and otp='$otp'");
		} while($num=$result->num_rows>0);
		$message="One Time Password for Association Registration is.".$otp.", Regards GJEPC";
		$result1=$conn->query("select mobile_no from parichay_person_otp_check where mobile_no='$mobile_no'");
		$num1=$result1->num_rows;
		if($num1>0){
		$isSent = get_data($message,$mobile_no);
		if($isSent ==TRUE){
		$conn->query("update parichay_person_otp_check set otp='$otp',check_status='0' where mobile_no='$mobile_no'");
		}
		}
	else {
		$isSent = get_data($message,$mobile_no);
		if($isSent ==TRUE){
		$conn->query("insert into parichay_person_otp_check set mobile_no='$mobile_no',otp='$otp',check_status='0'");
		}
	}	
}

/*...........................Verify OTP..............................*/
if(isset($_POST['actionType']) && $_POST['actionType']=="verifyPersonOTP"){
	$mobile_no = trim($_POST['mobile_no']);
	$otp = $_POST['otp'];
	$otp=str_replace(" ","",$otp);
	$otp=str_replace(";","",$otp);
	$otp=str_replace("-","",$otp);
	$otp=str_replace("|","",$otp);
	$otp=str_replace("'","",$otp);
	$otp=str_replace("\"","",$otp);
	
    $result=$conn->query("select * from parichay_person_otp_check where mobile_no='$mobile_no' and otp='$otp'");
	$row=$result->fetch_assoc();
    $num=$result->num_rows;
	if($row['check_status']=="0")
	{	
		$conn->query("update parichay_person_otp_check set check_status='1' where mobile_no='$mobile_no' and otp='$otp'");
		echo "verify";
	}
	elseif($row['check_status']=="1")
	{
		echo "verified";
	}
	else
	{
		echo "invalid";
	}
}

if(isset($_POST['actiontype']) && $_POST['actiontype']=="checkType_member")
{  
$type_member = trim($_POST['type_member']);
?>
<select class="form-control" name="registration_id" id="registration_id">
<option value="">-- Select Company --</option>
<?php
$sqlx = "SELECT id,company_name from registration_master WHERE website='parichay' AND parichay_type='$type_member' AND status='1'";
$com = $conn ->query($sqlx);
while($result = $com->fetch_assoc()){ ?>
<option value="<?php echo filter($result['id']);?>" <?php if($result['id']==$registration_id){?> selected="selected" <?php }?>><?php echo strtoupper(str_replace('&amp;', '&',$result['company_name']));?></option>
<?php } ?>
</select>
<?php
}

if(isset($_POST['valueType'])=="associationType")
{
?>
<select class="form-control" name="registration_id" id="registration_id">
<option value="">-- Select Association --</option>
<?php
$sqlx = "SELECT id,company_name from registration_master WHERE website='parichay' AND parichay_type='association' AND status='1'";
$com = $conn ->query($sqlx);
$countx = $com->num_rows;
if($countx > 0) {
while($result = $com->fetch_assoc()){ 
		$getStatus = getParichay_status($result['id'],$conn); 
		if($getStatus=="Y"){ ?>
<option value="<?php echo filter($result['id']);?>" <?php if($result['id']==$registration_id){?> selected="selected" <?php }?>><?php echo strtoupper(str_replace('&amp;', '&',$result['company_name']));?></option>
		<?php } } ?>
</select>
<?php } else { ?>
<option value="0">Not Found</option>
<?php }	?>

<?php } ?>

<?php
if(isset($_POST['actionType']) && $_POST['actionType']=="company_approval_status_update_action")
{
    $person_id = $_POST['person_id'];
    $registration_id = $_POST['registration_id'];
    $approval = $_POST['approval'];
    $company_remark = $_POST['company_remark'];
	
	if($approval=='Y')
	{
		$sql = "SELECT * from parichay_person_details where registration_id='$registration_id' AND person_id='$person_id' AND registration_id!=0";
		$result = $conn ->query($sql);
		$rCount = $result->num_rows;
		if($rCount>0)
		{
				$rowx = $result->fetch_assoc();
				$name = $rowx['fname'].' '. $rowx['mname'].' '. $rowx['surname'];
				$company = getNameCompany($registration_id,$conn);
				$address1 = $rowx['p_address1'];
				$address2 = $rowx['p_address2'];
				$city = $rowx['p_city'];
				$pin_code = $rowx['p_pin_code'];
				$state = getState($rowx['c_state'],$conn);
				$mobile = $rowx['mobile1'];
				$email = $rowx['email'];
				$person_series = $rowx['person_series'];
			//	$company_approval = $rowx['company_approval'];
				$getParichay_type = isApplied_for_parichay($registration_id,$conn);
				if($getParichay_type=="association"){ $type = "Association"; } else { $type = "Company"; }
				$post_date = date("d/m/Y", strtotime($rowx['post_date']));
				$company_approval_date = date("d/m/Y", strtotime($rowx['company_approval_date']));
				
				$getAddress ="SELECT company_pan_no,company_gstn,state FROM `registration_master` WHERE `id` = '$registration_id'";
				$getAddressResult = $conn ->query($getAddress);
				$getAddressRow = $getAddressResult->fetch_assoc();
				$companyState = $getAddressRow['state'];
				$company_pan_no = $getAddressRow['company_pan_no'];
				$company_gstn = $getAddressRow['company_gstn'];
				$region = getRegionNameFromState($companyState,$conn);
			
				$association_head_mobile_no = association_head_mobile_no1($registration_id,$conn);
				
	
		$response = array();
		$url = "http://products.tecogis.com/gjepcparichyapi/api/Webapi/savedata";
		
		$data = array(
				'TEC_REG_NO' => $person_series,
				'MEMBERSHIP_NO' => $registration_id,
				'FIRST_NAME' => $name,
				'COMPANY_NAME' => $company,
				'ADD_1' => $address1,
				'ADD_2' => $address2,
				'CITY' => $city,
				'PIN_CODE' => $pin_code,
				'STATE' => $state,
				'MOBILE' => $mobile,
				'EMAIL' => $email,
				'MEMBERSHIPTYPE' => $type,
				'ENTERED_ON' => $post_date,
				'APPROVED' => 'Y',
				'QC_BY' => 'Admin',
				'QC_On' => $company_approval_date,
				'REGION' => $region,
				'COMPANY_PAN' => $company_pan_no,
				'COMPANY_GST' => $company_gstn,
				'ASSOCIATION_HEAD_MOBILE' => $association_head_mobile_no
				);
		//	print_r($data);		exit;
			$options = array(
				'http' => array(
					'header'  => "Content-type: application/x-www-form-urlencoded",
					'method'  => 'POST',
					'content' => http_build_query($data)
				)
			);
			$context  = stream_context_create($options);
			$resp = file_get_contents($url, false, $context);
		//	var_dump($resp);
		}
	}
	

    if($person_id!='') {
    $sql = "UPDATE parichay_person_details SET company_approval ='$approval',company_remark='$company_remark',company_approval_date=NOW() WHERE person_id='$person_id'";
    $result = $conn->query($sql);
    if($result){
     	echo json_encode(array("status"=>"success","flag"=>$approval)); exit;
    } else {
     	echo json_encode(array("status"=>"fail")); exit;
    }
	} else {
		echo json_encode(array("status"=>"Person id is blank")); exit;
	}
	
	
}

if(isset($_POST['actionType']) && $_POST['actionType']=="agency_approval_status_update_action")
{
      $person_id = $_POST['person_id'];
      $approval = $_POST['approval'];
      $agency_remark = $_POST['agency_remark'];
	
    if($person_id!='') {
      $sql = "UPDATE parichay_person_details SET agency_approval ='$approval',agency_remark='$agency_remark' WHERE person_id='$person_id'";
     $result = $conn->query($sql);
     if($result){
     	echo json_encode(array("status"=>"success","flag"=>$approval)); exit;
     }else{
     	echo json_encode(array("status"=>"fail")); exit;
     }
	} else {
		echo json_encode(array("status"=>"Person id is blank")); exit;
	}
}

/* if(isset($_POST['actionType']) && $_POST['actionType']=="mobile")
{ 	
	$mobile = trim($_POST['mobile']); 

	$url ="https://media.smsgupshup.com/GatewayAPI/rest?method=SendMessage&format=json&userid=2000193706&password=dCtjkxnX&send_to=".$mobile."&v=1.1&auth_scheme=plain&msg_type=TEXT";
	$url.="&msg=Dear%20Sir%2C%20we%20have%20received%20your%20application%20for%20new%20membership%2C%20your%20application%20will%20be%20processed%20shortly%2C%20if%20any%20deficiency%20found%20during%20scrutiny%20of%20membership%20application%2C%20team%20will%20revert%20to%20you%20shortly.";
	//$url.="&isTemplate=true&buttonUrlParam=abcdxyz";

	//$headers = array("Content-Type: application/json");
				 
    $curl = curl_init();
    $timeout = 5;
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
	
    $response = curl_exec($curl);
	
	$err = curl_error($curl);
	curl_close($curl);
	
	if($err) {
	 echo "cURL Error #:" . $err;
	} else {
		header('Content-type: application/json');
		echo json_encode(json_decode($response)); exit;
		//return $response;
	// echo $response;
	}
} */
?>
<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getCommodity"){
$country = trim($_POST['country']);
$query   = $conn->query("SELECT hscode,product_desc from statistics_intl_tariff_structure WHERE country = '$country'");
?>
      <select name="commodity" id="commodity" class="form-control">
      <option value="">--Select Commodity--</option>
      <?php while($result = $query->fetch_assoc()){?>
      <option value="<?php echo $result['hscode'];?>"><?php echo $result['hscode'];?> (<?php echo $result['product_desc'];?>)</option>
      <?php } ?>
      </select>
<?php } ?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getintlDetails")
{ 
	$commodity = trim($_POST['commodity']);
	$country = trim($_POST['country']);
	
	if(isset($commodity) && $commodity!='' && $country!='')
	{
			$sql ="SELECT * from statistics_intl_tariff_structure where country='$country' AND hscode='$commodity'";
			$resultx = $conn ->query($sql);
			$rCount = $resultx->num_rows;
			$getValue="";
			if($rCount>0) { ?>
			<div class="row py-3" style="border-top: 1px solid #ccc">
                            <div class="col-12"><h2 class="title text-center mb-1"><span class="d-table mx-auto mb-3" style="width:35px;"><img src="assets/images/black_star.png" class="img-fluid d-block"></span>Import tariff structure in different countries for India</h2></div>
                            
                            <div class="col-12 mb-3">
                                <p class="text-center"><strong>Date</strong>: <?php echo date("d/m/Y");?></p>
                            </div>
                            
                            <div class="col-12">
                                <table class="table table-bordered tableInfo w-auto mx-auto">
                                   
                                    <tbody>
									<?php 
									$i=1;
									while($row = $resultx->fetch_assoc())
									{ //print_r($row); exit;
									?>
                                        <tr>
                                        	<td><strong>Country Name</strong></td>
                                        	<td><?php echo $row['country'];?></td>
                                        </tr>
                                        <tr>
                                        	<td><strong>HS Code</strong></td>
                                            <td><?php echo $row['hscode'];?></td>
                                        </tr>
										<tr>
                                        	<td><strong>Product Description</strong></td>
                                            <td><?php echo $row['product_desc'];?></td>
                                        </tr>
                                        <tr>
                                        	<td><strong>Whether there is/are  any Trade agreement(s) ?</strong></td>
                                            <td><?php echo $row['is_any_trade_agreement'];?></td>
                                        </tr>
                                        <tr>
                                        	<td><strong>Trade Agreement name(s) - 1 </strong></td>
                                            <td><?php echo $row['trade_agreement1'];?></td>
                                        </tr>
										<?php if(trim($row['trade_agreement2'])!='0'){?>
										<tr>
                                        	<td><strong>Trade Agreement name(s) - 2 </strong></td>
                                            <td><?php echo $row['trade_agreement2'];?></td>
                                        </tr>
										<?php } ?>
										<!--<tr>
                                        	<td><strong>Basic Duty </strong></td>
                                            <td><?php echo $row['basic_duty'];?></td>
                                       	</tr>-->										
										<tr>
                                        	<td><strong>Most Favoured Nation rate (MFN)</strong></td>
                                            <td><?php echo $row['mfn'];?></td>
                                       	</tr>
										<tr>
                                        	<td><strong>1 - Preferential tax rate</strong></td>
                                            <td><?php echo $row['prefered_tax_rate1'];?></td>
                                        </tr>
										<?php if(trim($row['prefered_tax_rate2'])!='0'){?>
										<tr>
                                        	<td><strong>2 - Preferential tax rate</strong></td>
                                            <td><?php echo $row['prefered_tax_rate2'];?></td>
                                        </tr>
										<?php } ?>
										<tr>
                                        	<td><strong>1 - Rules of Origin</strong> </td>
                                            <td><?php echo $row['rules_of_origin1'];?></td>
                                        </tr>
										<?php
										if(trim($row['rules_of_origin2'])!='0'){?>
										<tr>
                                        	<td><strong>2 - Rules of Origin</strong> </td>
                                            <td><?php echo $row['rules_of_origin2'];?></td>
                                        </tr>
										<?php } ?>
                                        <tr>
                                        	<td><strong>Other Taxes /Duties </strong></td>
                                            <td><?php //echo $row['other_taxes']; 
											echo $output = str_replace(',', '<br />', $row['other_taxes']);?></td>
                                        </tr>
                                     <?php 
										$i++; } ?>   
                                    </tbody>
                                </table>
                            </div>
							<div class="col-12">
                                <table class="table table-bordered tableInfo w-auto mx-auto">
									<th> Glossary </th>
                                        <tr>
                                        	<td><strong>* ROO - Rules of Origin</strong></td>
                                        </tr>
                                        <tr>
                                        	<td><strong>CC - Change in Chapter</strong></td>
                                        </tr>
										 <tr>
                                        	<td><strong>CTH - Change in Tariff Heading</strong></td>
                                        </tr>
                                        <tr>
                                        	<td><strong>CTSH - Change in Tariff Sub Heading</strong></td>
                                        </tr>
										<tr>
                                        	<td><strong>RVC - Regional Value Content</strong></td>
                                        </tr>
                                </table>								
                            </div>
                        </div>
				<?php  }
	}	
}
?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getKarigarDetails"){
$karigarid = trim($_POST['karigarid']);
$query   = $conn->query("SELECT * from parichay_person_details WHERE `person_id` = '$karigarid'");
$row = $query->fetch_assoc();
$parichay_type = isApplied_for_parichay($row['registration_id'],$conn);
$spouse_gender = $row['spouse_gender'];
$getspouse_dob = $row['spouse_dob'];
if($getspouse_dob=='1970-01-01') { $spouse_dob = ''; } else { $spouse_dob = $row['spouse_dob']; }

if($spouse_gender =="M"){ $spouseGender = "MALE"; }
if($spouse_gender =="F"){ $spouseGender = "FEMALE"; }

$child1_gender = $row['child1_gender'];
if($child1_gender =="M"){ $child1Gender = "MALE"; }
if($child1_gender =="F"){ $child1Gender = "FEMALE"; }
$getchild1_dob = $row['child1_dob'];
if($getchild1_dob=='1970-01-01') { $child1_dob = ''; } else { $child1_dob = $row['child1_dob']; }

$child2_gender = $row['child2_gender'];
if($child2_gender =="M"){ $child2Gender = "MALE"; }
if($child2_gender =="F"){ $child2Gender = "FEMALE"; }
$getchild2_dob = $row['child2_dob'];
if($getchild2_dob=='1970-01-01') { $child2_dob = ''; } else { $child2_dob = $row['child2_dob']; }
	
    $output .= '<table class="responsive_table">
		<tbody>
		    <tr>
				<td colspan="2"><strong>Personal Details</strong></td>				
			</tr>
			<tr>
				<td>Name:</td>
				<td>'.$row['fname']." ".$row['mname']." ".$row['surname'].'</td>
			</tr>
			<tr>
				<td>Photo</td>
				<td><img src="images/parichay_card/person/photo/'.$row['photo'].'"  class="img-fluid" style="max-height:200px;"></td>
			</tr>
			<tr>
				<td>Date Of Birth</td>
				<td>'.$row['date_of_birth'].'</td>
			</tr>
			<tr>
				<td>Gender</td>
				<td>'.$row['gender'].'</td>
			</tr>
			<tr>
				<td>Blood Group</td>
				<td>'.$row['blood_group'].'</td>
			</tr>
			<tr>
				<td>Education</td>
				<td>'.$row['education'].'</td>
			</tr>
			<tr>
				<td>Id Proof</td>
				<td><img src="images/parichay_card/person/id_proof/'.$row['id_proof'].'"  class="img-fluid" style="max-height:200px;"></td>
			</tr>
			<tr>
				<td colspan="2"><strong>Contact Details</strong></td>
			</tr>
			<tr>
				<td>Primary Mobile</td>
				<td>'.$row['mobile1'].'</td>
			</tr>
			<tr>
				<td>Secondary Mobile</td>
				<td>'.$row['mobile2'].'</td>
			</tr>
			<tr>
				<td>Email</td>
				<td>'.$row['email'].'</td>
			</tr>
			<tr>
				<td>Address </td>
				<td>'.$row['p_address1'].' '.$row['p_address2'].'</td>
			</tr>
			<tr>
				<td>State</td>
				<td>'.getState($row['p_state'],$conn).'</td>
			</tr>
			<tr>
				<td>City</td>
				<td>'.$row['p_city'].'</td>
			</tr>
			<tr>
				<td>Pincode</td>
				<td>'.$row['p_pin_code'].'</td>
			</tr>
			<tr>
				<td colspan="2"><strong>Bank Details Section</strong></td>
			</tr>
			<tr>
				<td>Bank</td>
				<td>'.$row['bank'].'</td>
			</tr>
			<tr>
				<td>Account No.</td>
				<td>'.$row['account_no'].'</td>
			</tr>
			<tr>
				<td>IFSC Code</td>
				<td>'.$row['ifsc'].'</td>
			</tr>
			<tr>
				<td>Bank Documents</td>
				<td><img src="images/parichay_card/person/upload_bank_documents/'.$row['upload_bank_documents'].'"  class="img-fluid" style="max-height:200px;"></td>
			</tr>
			<tr>
				<td colspan="2"><strong>Work Profile </strong></td>
			</tr>
			<tr>
				<td>Employment status</td>
				<td>'.$row['employment_status'].'</td>
			</tr>
			<tr>
				<td>Applicable Industry</td>
				<td>'.strtoupper($row['applicable_industry']).'</td>
			</tr>
			<tr>
				<td>Applicable Skills</td>
				<td>'.strtoupper($row['applicable_skills']).'</td>
			</tr>';
			if($parichay_type =="association"){
			$output .= '
			<tr>
				<td>Swasthya Kosh</td>
				<td>'.$row['swasthya_kosh_option'].'</td>
			</tr>
				<tr>
				<td>Selected Premium</td>';
			if( strtolower($row['isPremium']) =="self"){
				$output .= '<td>Self Only (Premium: Rs 1400)</td>';
			}else if( strtolower($row['isPremium']) =="family"){
				$output .= '<td>Self & Family (Premium: Rs. 2200)</td>';
			}else{
				$output .= '<td>Not Selected</td>';

			}
			
			
			$output .= '</tr>
			<table class="responsive_table category_table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>DOB</th>
                                            <th>Age</th>
                                        </tr>
                                    </thead>                           
                                    <tbody>
                                        <tr>
                                            <td data-column="Name">'.$row['spouse_name'].'</td>                                           
                                            <td data-column="Gender">'.$spouseGender.'</td>										
                                            <td data-column="DOB">'.$spouse_dob.'</td>										
                                            <td data-column="Age">'.$row['spouse_age'].'</td>
                                        </tr>
										<tr>
                                            <td data-column="child1">'.$row['child1'].'</td>                                           
                                            <td data-column="Gender">'.$child1Gender.'</td>										
                                            <td data-column="DOB">'.$child1_dob.'</td>										
                                            <td data-column="Age">'.$row['child1_age'].'</td>
                                        </tr>
										<tr>
                                            <td data-column="Name">'.$row['child2'].'</td>                                           
                                            <td data-column="Gender">'.$child2Gender.'</td>										
                                            <td data-column="DOB">'.$child2_dob.'</td>										
                                            <td data-column="Age">'.$row['child2_age'].'</td>
                                        </tr>                                         
                                    </tbody>                                        
                                </table>
			';
			}
			$output .= '<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
		</tbody>
	</table>';

    echo json_encode(array("status"=>"success","output"=>$output));exit;

} ?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="checkPanApi")
{
// 	error_reporting(E_ALL);
// ini_set('display_errors', 1);
   $company_pan_no = trim($_POST['company_pan_no']);
   $fieldsArr = '{
			"data": 
			{
			"customer_pan_number": "'.$company_pan_no.'",
			"consent": "Y",
			"consent_text": "Approve the values here"
			}
			}';
		
		$headers = array(
		    "auth: false",
            "app-id: 62a31a45791920001dd1a099",
			"api-key: TK761JV-5KFM7MF-PAFQHR7-ZFKF25K",
            "Content-Type: application/json"
        );
		
$curl = curl_init();
curl_setopt_array($curl, array(
//  CURLOPT_URL => 'https://test.zoop.one/api/v1/in/identity/pan/advance',
  CURLOPT_URL => 'https://live.zoop.one/api/v1/in/identity/pan/lite',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => $fieldsArr,
  CURLOPT_HTTPHEADER => $headers,
));

$response = curl_exec($curl);
curl_close($curl);
echo $response;

//echo '<pre>'; print_r($response); 
$obj = json_decode($response);
//echo '<pre>'; print_r($obj); 
$response_code = $obj->response_code;
$result = $obj->result;
$pan_type = $result->pan_type;
$name = $result->user_full_name;

$logs = "INSERT INTO zoop_logs SET post_date = NOW(),document = 'PAN',document_no='$company_pan_no',name='$name',zoop_verified='$response_code',pan_type='$pan_type',section='GJEPC',ip='".$_SERVER['REMOTE_ADDR']."'";
$result = $conn->query($logs);
 exit; 
}
?>