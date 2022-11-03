<?php 
session_start();
include ("../db.inc.php");
include('../functions.php');
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getCity"){
$country=$_POST['country'];
$query=mysql_query("SELECT * from state_master WHERE country_code = '$country'");
if($country=="IN"){
?>
	  <div class="field_name">State / Province <span>*</span> :</div>
        <div class="field_input">
          <select name="state" id="state" class="bgcolor">
              <option value="">----------Select State ----------</option>
              <?php while($result=mysql_fetch_array($query)){?>
              <option value="<?php echo $result['state_code'];?>"><?php echo $result['state_name'];?></option>
              <?php }?>
          </select>
	</div>
    <div class="clear"></div>
      <span id="error_first_name"></span>
<?php } else {?>
<div class="field_name">State / Province <span>*</span> :</div>
<div class="field_input">
<input type="text" class="bgcolor" id="state" name="state" />
</div>
<div class="clear"></div>
   <span id="error_first_name"></span>
<?php }?>
<?php }?>

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
if(isset($_POST['actiontype']) && $_POST['actiontype']=="privilege_visitor"){
    $visitor_code=$_POST['visitor_code'];
	//echo $pvrcode = $_SESSION['PVRCODE'];

    $query=mysql_query("select * from temp_privilege_visitor_reg where privilege_code='$visitor_code' GROUP BY privilege_code");
    $num=mysql_num_rows($query);
	$result=mysql_fetch_array($query);
	if($num>0)
	{
	$query1 = "update registration_master set pvrcode='$visitor_code' where email_id='$result[email]'";
	$ans = mysql_query($query1);
	
?>
<form method="post" action="registration.php?page=pvr">
    <div class="field">
        <?php echo "<b>".$result['contact_person'];?> (<?php echo $result['designation']."</b>";?>)<br />
        <?php echo $result['company_name'];?><br />
        <?php if($result['address1']!=""){echo $result['address1']."<br />";}?>
        <?php if($result['address2']!=""){echo $result['address2']."<br />";}?>
        <?php if($result['address3']!=""){echo $result['address3']."<br />";}?>
        <?php if($result['city']!=""){echo $result['city']."<br />";}?>
        <?php if($result['pincode']!=""){echo $result['pincode']."<br />";}?>
        <?php if($result['telephone_no_office']!=""){echo $result['telephone_no_office']."<br />";}?>
        <?php if($result['mobile']!=""){echo $result['mobile']."<br />";}?>
		<?php if($result['email']!=""){echo $result['email']."<br />";}?>
    </div>
    <div class="field">
        <label></label>
        <input name="visitor_code" id="visitor_code" type="hidden" value="<?php echo $visitor_code;?>"/>
        <input name="registration_submit" id="registration_submit" type="submit"  class="submitButton" value="Procced to Registration"/>       
    </div>
</form>
<?php } 
	else
	{
		echo "<span style='color:#FF0000'>Invalid Privilege Visitor Registration Code </span>";
	}
}
?>
<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="international_visitor"){
    $erp_code=$_POST['reference_number'];
    $query=mysql_query("select * from temp_visitor_registration_table where erp_code='$erp_code'");
    $num=mysql_num_rows($query);
	$result=mysql_fetch_array($query);
	if($num>0)
	{	
?>
    <form method="post" action="registration.php?page=ivr">
        <div class="field">
            <?php echo "<b>".$result['first_name']." ".$result['last_name'];?> (<?php echo $result['designation']."</b>";?>)<br />
            <?php if($result['office_add']!=""){echo $result['office_add']."<br />";}?>
            <?php if($result['city']!=""){echo $result['city']."<br />";}?>
            <?php if($result['country']!=""){echo $result['country']."<br />";}?>
            <?php if($result['postal_code']!=""){echo $result['postal_code']."<br />";}?>
            <?php if($result['email']!=""){echo $result['email']."<br />";}?>
        </div>
        <div class="field">
            <label></label>
            <input name="reference_number" id="reference_number" type="hidden" value="<?php echo $erp_code;?>"/>
            <input name="registration_submit" id="registration_submit" type="submit"  class="submitButton" value="Procced to Registration"/>       
        </div>
    </form>
<?php } 
	else
	{
		echo "<span style='color:#FF0000'>Invalid Reference Number</span>";
	}
}
?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getState"){
$country=$_POST['country'];
$query=mysql_query("SELECT * from state_master WHERE country_code = '$country'");
if($country=="IN"){
?>
	  <select name="applicant_state" id="applicant_state" class="textField">
      <option value="">--Select State--</option>
      <?php while($result=mysql_fetch_array($query)){?>
      <option value="<?php echo $result['state_code'];?>"><?php echo $result['state_name'];?></option>
      <?php }?>
      </select>
<?php } else {?>
<input type="text" class="textField" id="applicant_state" name="applicant_state" />
<?php }?>
<?php }?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="calculatePayment"){
$selected_area=$_POST['selected_area'];
$selected_scheme_type=$_POST['selected_scheme_type'];
$category=$_POST['category'];
$selected_premium_type=$_POST['selected_premium_type'];
$woman_entrepreneurs=$_POST['woman_entrepreneurs'];
$country=$_POST['country'];
$section=$_POST['section'];

if(strtoupper($country)=="INDIA" || strtoupper($country)=="IND" || strtoupper($country)=="IN")
{
	if($section=="plain_gold")
	{
		$charge="22400";
	}
	else if($section=="loose_stones")
	{
		$charge="21200";
	}
	else if($section=="signature_club")
	{
		$charge="30250";
	}
	else if($section=="studded_jewellery")
	{
		$charge="22400";
	}
	else if($section=="lab_edu")
	{
		$charge="21200";
	}
	else if($section=="allied")
	{
		$charge="21200";
	}

}else{

	if($section=="International Jewellery")
		{
			$charge="450";
		}
		else if($section=="International Loose")
		{
			$charge="450";
		}
}

if($category=="normal")
{
	$category=0;
}
else if($category=="corner_2side")
{
	$category=0.05;
}
else if($category=="corner_3side")
{
	$category=0.1;
}
else if($category=="island_4side")
{
	$category=0.15;
}

if($selected_premium_type=="normal")
{
	$selected_premium_type=0;
}
else if($selected_premium_type=="premium")
{
	$selected_premium_type=0.05;
}
$space_rate=intval($selected_area*$charge);

if($woman_entrepreneurs==1)
{
	$space_rate=($space_rate-$space_rate*0.25);
}

echo $space_rate1=intval($space_rate)."#";

$category_rate=$space_rate*$category;

echo $category_rate1=$category_rate."#";

$premium_rate=floatval($space_rate*$selected_premium_type);
echo $premium_rate1=$premium_rate."#";

$sub_total_cost=floatval($space_rate+$category_rate+$premium_rate);
echo $sub_total_cost1=($space_rate+$category_rate+$premium_rate)."#";

$security_deposit=floatval($sub_total_cost*10)/100;
echo $security_deposit1=$security_deposit."#";

$govt_service_tax=floatval($sub_total_cost*18)/100;
echo $govt_service_tax1=$govt_service_tax."#";

$grand_total=round($sub_total_cost+$security_deposit+$govt_service_tax);
echo $grand_total1=$grand_total."#";
}
?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="optionValue"){
$option=$_POST['option'];
$lastYearArea=$_POST['lastYearArea'];
	if($option=="More than previous")
	{
		$sql="select * from iijs_area_master where area>=$lastYearArea";	
	}
	else if($option=="less area as previous")
	{
		$sql="select * from iijs_area_master where area<=$lastYearArea";	
	}
	$query=mysql_query($sql);
	$num=mysql_num_rows($query);
	if($num>0){
	while($result=mysql_fetch_array($query)){
	?>
	<option value="<?php echo $result['area'];?>" <?php if($result['area']==$lastYearArea){?> selected="selected" <?php }?>><?php echo $result['area'];?></option>
<?php }}}?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getSchemeType"){
	$category=$_POST['category'];
	if($category=="mezzanine")
	{
		$sql="select * from iijs_scheme_master where scheme='MEM'";
	}
	else
	{
		$sql="select * from iijs_scheme_master where scheme!='MEM'";
	}	
	$query=mysql_query($sql);
	$num=mysql_num_rows($query);
	if($num>0){
	while($result=mysql_fetch_array($query)){
	?>
	<option value="<?php echo $result['scheme'];?>"><?php echo $result['scheme_desc'];?></option>
<?php }}}?>

<?php /*?>Membership<?php */?>

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
$city=$_POST['city'];
$country=$_POST['country'];
if($_POST['state']!=""){$state=$_POST['state'];}else{$state=$_POST['other_state'];}
$pincode=$_POST['pincode'];
if(isset($_POST['landline_no1']) && $_POST['landline_no1']!=""){$landline_no1=$_POST['landline_no1'];}else{$landline_no1="";}
if(isset($_POST['mobile_no']) && $_POST['mobile_no']!=""){$mobile_no=$_POST['mobile_no'];}else{$mobile_no="";}
if(isset($_POST['fax_no1']) && $_POST['fax_no1']!=""){$fax_no1=$_POST['fax_no1'];}else{$fax_no1="";}
if(isset($_POST['fax_no2']) && $_POST['fax_no2']!=""){$fax_no2=$_POST['fax_no2'];}else{$fax_no2="";}
$email_id=$_POST['email_id'];
$din_no=$_POST['din_no'];
$pan_no=$_POST['pan_no'];
$gst_no=$_POST['gst_no'];
$dt = date('Y/m/d'); 

$qcheck=mysql_query("select * from communication_address_master where id='$id' and registration_id='$registration_id'");
$rcheck=mysql_num_rows($qcheck);
if($rcheck>0){
mysql_query("update communication_address_master set type_of_address='$type_of_address',address_identity='$address_identity',type_of_address_sap='$type_of_address_sap',name='$name',father_name='$father_name',address1='$address1',address2='$address2',address3='$address3',city='$city',country='$country',state='$state',pincode='$pincode',landline_no1='$landline_no1',mobile_no='$mobile_no',fax_no1='$fax_no1',fax_no2='$fax_no2',email_id='$email_id',din_no='$din_no',pan_no='$pan_no',gst_no='$gst_no' where id='$id' and registration_id='$registration_id'");
}
else{
$sql="insert into communication_address_master set registration_id='$registration_id',type_of_address='$type_of_address',address_identity='$address_identity',type_of_address_sap='$type_of_address_sap',name='$name',father_name='$father_name',address1='$address1',address2='$address2',address3='$address3',city='$city',country='$country',state='$state',pincode='$pincode',landline_no1='$landline_no1',mobile_no='$mobile_no',fax_no1='$fax_no1',fax_no2='$fax_no2',email_id='$email_id',din_no='$din_no',pan_no='$pan_no',gst_no='$gst_no',status=1,post_date='$dt'";
mysql_query($sql);
}
$query=mysql_query("select * from communication_address_master where registration_id='$registration_id'");
while($result=mysql_fetch_array($query)){
?>
<tr>
<td ><span class="text6"><?php echo getaddresstype($result['type_of_address']);?></span></td>
<td width="19%"><span class="text6"><?php echo $result['address1'];?><?php if($result['address2']!=""){echo ",".$result['address2'];}?><?php if($result['address3']!=""){echo ",".$result['address3'];}?><?php if($result['city']!=""){echo ",".$result['city'];}?><?php if($result['state']!=""){echo ",".$result['state'];}?><?php if($result['pincode']!=""){echo ",".$result['pincode'];}?></span></td>
<td width="29%" ><?php echo $result['name'];?></td> 
<td width="35%" ><span class="editAdd <?php echo $result['id'];?> <?php echo $registration_id;?>">EDIT</span></td>
<td width="35%" ><span class="deleteAdd <?php echo $result['id'];?> <?php echo $registration_id;?>">DELETE</span></td>
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
<td ><span class="text6"><?php echo getaddresstype($result['type_of_address']);?></span></td>
<td width="19%"><span class="text6"><?php echo $result['address1'];?><?php if($result['address2']!=""){echo ",".$result['address2'];}?><?php if($result['address3']!=""){echo ",".$result['address3'];}?><?php if($result['city']!=""){echo ",".$result['city'];}?><?php if($result['state']!=""){echo ",".$result['state'];}?><?php if($result['pincode']!=""){echo ",".$result['pincode'];}?></span></td>
<td width="29%" ><?php echo $result['name'];?></td> 
<td width="35%" ><span class="deleteAdd <?php echo $result['id'];?> <?php echo $registration_id;?>">DELETE</span></td>
<td width="35%" ><span class="editAdd <?php echo $result['id'];?> <?php echo $registration_id;?>">EDIT</span></td>
</tr>
<?php }}?>

<?php if(isset($_POST['actiontype']) && $_POST['actiontype']=="editAdd"){
$id=$_POST['id'];
$registration_id=$_POST['registration_id'];

$info_status=mysql_query("select member_type_id,type_of_firm,status from information_master where registration_id='$registration_id' and status=1");
$info_row=mysql_fetch_array($info_status);
$member_type_id=$info_row['member_type_id'];
$type_of_firm=$info_row['type_of_firm'];

$cquery=mysql_query("select * from communication_address_master where id='$id' and registration_id='$registration_id'");
$cresult=mysql_fetch_array($cquery);
$type_of_addresss = $cresult['type_of_address'];
$tmp = explode("-", $type_of_addresss);

$type_of_address = $tmp[0];

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
<form id="comaddress" name="comaddress" method="post" action="comm_update.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
<tr>
 <td bgcolor="#CCCCCC" colspan="3"><strong>Address Details</strong></td>
 </tr> 
  <tr>
    <td colspan="2"><span class="text6 ">Type of Communication Address:</span> <span class="star"> * </span></td>
    <td>
    	<input type="hidden" name="hidden" id="hidden" value=""/>
    	<select class="input_txt1" id="type_of_address" name="type_of_address">
		<option value="">----Select----</option>
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
	</td>
  </tr>
  <tbody <?php if($cresult['name']==''){?> style="display:none;" <?php }?> id="basedontype">
	<tr>
    <td colspan="2" ><span class="text6">Name:</span> <span class="star">* </span></td>
    <td><input type="text" id="name" name="name"  class=" input_txt_new" value="<?php echo $cresult['name'];?>" /></td>
    </tr>    
    <tr>
    <td colspan="2"><span class="text6 ">Father's Name:</span></td>
    <td><input type="text" class="input_txt_new" id="father_name" name="father_name" value="<?php echo $cresult['father_name'];?>"/></td>
	</tr>
  </tbody>

	<tr>
    <td colspan="2" ><span class="text6 ">Address Line 1:</span> <span class="star">* </span></td>
    <td><input type="text" class=" input_txt_new" id="address1"  name="address1" value="<?php echo $cresult['address1'];?>" maxlength="30"/></td>
    </tr>	
    
    <tr>
    <td colspan="2"><span class="text6 ">Address Line 2:</span></td>
    <td><input type="text" class=" input_txt_new" id="address2" name="address2" value="<?php echo $cresult['address2'];?>" maxlength="30" /></td>
    </tr>

	<tr>
    <td colspan="2"><span class="text6 ">Address Line 3:</span></td>
    <td>
    <input type="text" class=" input_txt_new" id="address3" name="address3" value="<?php echo $cresult['address3'];?>" maxlength="30" /> </td>
	</tr>
	<tr>
	<td colspan="2"><span class="text6 ">City:</span> <span class="star">* </span></td>
	<td>
    <input type="text" class=" input_txt_new" id="city" name="city" value="<?php echo $cresult['city'];?>"/>
    </td>
	</tr>
	<tr>
	  <td colspan="2"><span class="text6 ">Country:</span> <span class="star"> * </span></td>
	  <td>
      <select name="country" id="country" class="input_txt_new">
       <?php 
		$query=mysql_query("SELECT * FROM country_master where country_code='IN'");
		while($result=mysql_fetch_array($query)){
		?>
        <option value="<?php echo $result['country_code'];?>" <?php if($result['country_code']==$cresult['country']){?> selected="selected" <?php }?>><?php echo $result['country_name'];?></option>
        <?php }?>
	 </select>
      </td>
	</tr>
      <tr id="stateDiv">
      <td colspan="2"><span class="text6 ">State:</span> <span class="star"> * </span></td>
      <td>
        <select name="state" id="state" class="input_txt_new">
        <option value="">--Select State--</option>
        <?php 
        $query=mysql_query("SELECT * from state_master WHERE country_code = 'IN'");
        while($result=mysql_fetch_array($query)){?>
        <option value="<?php echo $result['state_code'];?>" <?php if($result['state_code']==$cresult['state']){?> selected="selected" <?php }?>><?php echo $result['state_name'];?></option>
        <?php }?>
        </select>
        </td>
      </tr>
      
	<tr>
	  <td colspan="2"><span class="text6 ">Pin Code:</span>  <span class="star"> * </span></td>
	  <td><input type="text" class="input_txt_new" id="pincode" name="pincode" value="<?php echo $cresult['pincode'];?>" maxlength="6"/></td>
	  </tr>
	<tr >
	  <td colspan="2"><span class="text6 ">Landline No.:</span><span class="star"> * </span></td>
	  <td><input type="text" class="input_txt_new" id="landline_no1" name="landline_no1" value="<?php echo $cresult['landline_no1'];?>"/></td>
	  </tr>
	<tr >
	  <td colspan="2"><span class="text6 ">Mobile No.:</span> <span class="star"> * </span></td>
	  <td><input type="text" class="input_txt_new" id="mobile_no" name="mobile_no" value="<?php echo $cresult['mobile_no'];?>" maxlength="10" /></td>
	  </tr>
	<!--<tr >
	  <td colspan="2"><span class="text6 ">Fax No.1:</span></td>
	  <td><input type="text" class="input_txt_new" id="fax_no1" name="fax_no1" value="<?php echo $cresult['fax_no1'];?>" /></td>
	  </tr>
	<tr>
	  <td colspan="2"><span class="text6 ">Fax No.2:</span></td>
	  <td><input type="text" class="input_txt_new" id="fax_no2" name="fax_no2" value="<?php echo $cresult['fax_no2'];?>" /></td>
	</tr>-->
	<tr>
	  <td colspan="2"><span class="text6 ">Email:</span> <span class="star"> * </span></strong></td>
	  <td><input type="text" class="input_txt1" id="email_id" name="email_id" value="<?php echo $cresult['email_id'];?>"/></td>
	</tr>
	<?php if($type_of_firm==13 || $type_of_firm==12){ ?>
	<tr>
	<td colspan="2"><span class="text6 ">DIN No.:</td>
	<td><input type="text" class="input_txt1" id="din_no" name="din_no" value="<?php echo $cresult['din_no'];?>" /></td>
	</tr>
	<?php } ?>
	<tr>
	<td colspan="2"><span class="text6">PAN:</td>
	<td><input type="text" class="input_txt1" id="pan_no" name="pan_no" value="<?php echo $cresult['pan_no'];?>" maxlength="10"/></td>
	</tr> 
	
	<tr>
	<td colspan="2"><span class="text6">GSTIN:</td>
	<td><input type="text" class="input_txt1" id="gst_no" name="gst_no" value="<?php echo $cresult['gst_no'];?>" maxlength="15"/></td>
	</tr> 
	
	<tr >
    <td colspan="13" class="text6" ><span class="style6">Note- : Fill up name of all present partners and directores as the case may be.</span></td>
    <input type="hidden" id="registration_id" name="registration_id" value="<?php echo $_REQUEST['registration_id'];?>"/>  
    <input type="hidden" id="id" name="id" value="<?php echo $id;?>" /> 
    </tr>
  
  </table>
<input type="submit" name="update" id="update"  value="Update" class="input_submit" />
</form>
<?php }?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="selectArea"){
$section=$_POST['section'];
//echo $section;
if($section=="signature_club")
{
	$sql="select * from signature_area_master where area in ('24','36','54')";	
}
else
{
	$sql="select * from signature_area_master where area in ('9','18','27','36','45','54')";
}
$query=mysql_query($sql);
$num=mysql_num_rows($query);
if($num>0){
while($result=mysql_fetch_array($query)){
?>
<option value="<?php echo $result['area'];?>"><?php echo $result['area'];?></option>
<?php }}}?>


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
	
	$query1=mysql_query("SELECT membership_type FROM `approval_master` WHERE 1 and registration_id='$registration_id' order by id desc limit 1");
	$result1=mysql_fetch_array($query1);

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