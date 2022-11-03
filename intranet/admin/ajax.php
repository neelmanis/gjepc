<?php session_start(); ?>
<?php 
include('../db.inc.php');
include('../functions.php');
?>
<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getCity"){
$country=$_POST['country'];
$query=mysql_query("SELECT * from state_master WHERE country_code = '$country'");
if($country=="IND"){
?>

	  <td colspan="2"><span class="text6 ">State/Province:</span> <span class="star"> * </span></td>
	  <td>
      <select name="state" id="state" class="input_txt1">
      <option value="">--Select State--</option>
      <?php while($result=mysql_fetch_array($query)){?>
      <option value="<?php echo $result['state_code'];?>"><?php echo $result['state_name'];?></option>
      <?php }?>
      </select>
      </td>
<?php } else {?>
<td colspan="2"><span class="text6 ">State:</span>  <span class="star"> * </span></td>
<td><input type="text" class="input_txt1" id="other_state" name="other_state" /></td>
<?php }?>
<?php }?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="comaddress"){
if(isset($_POST['id']) && $_POST['id']!=""){$id=$_POST['id'];}else{$id="";}
$registration_id=$_POST['registration_id'];
$type_of_address=$_POST['type_of_address'];
if(isset($_POST['name']) && $_POST['father_name']!=""){$name=$_POST['name'];}else{$name="";}
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
$dt = date('Y/m/d'); 

$qcheck=mysql_query("select * from communication_address_master where id='$id' and registration_id='$registration_id'");
$rcheck=mysql_num_rows($qcheck);
if($rcheck>0){
mysql_query("update communication_address_master set type_of_address='$type_of_address',name='$name',father_name='$father_name',address1='$address1',address2='$address2',address3='$address3',city='$city',country='$country',state='$state',pincode='$pincode',landline_no1='$landline_no1',mobile_no='$mobile_no',fax_no1='$fax_no1',fax_no2='$fax_no2',email_id='$email_id' where id='$id' and registration_id='$registration_id'");
}
else{
$sql="insert into communication_address_master set registration_id='$registration_id',type_of_address='$type_of_address',name='$name',father_name='$father_name',address1='$address1',address2='$address2',address3='$address3',city='$city',country='$country',state='$state',pincode='$pincode',landline_no1='$landline_no1',mobile_no='$mobile_no',fax_no1='$fax_no1',fax_no2='$fax_no2',email_id='$email_id',status=1,post_date='$dt'";
mysql_query($sql);
}
$query=mysql_query("select * from communication_address_master where registration_id='$registration_id'");
while($result=mysql_fetch_array($query)){
?>
<tr>
<td ><span class="text6"><?php echo getaddresstype($result['type_of_address']);?></span></td>
<td width="19%"><span class="text6"><?php echo $result['address1'];?></span></td>
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
<td width="19%"><span class="text6"><?php echo $result['address1'];?></span></td>
<td width="29%" ><?php echo $result['name'];?></td> 
<td width="35%" ><span class="deleteAdd <?php echo $result['id'];?> <?php echo $registration_id;?>">DELETE</span></td>
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

if($type_of_firm=="Proprietory"){$addflag=1;}
else if($type_of_firm=="Partnership"){$addflag=2;}
else if($type_of_firm=="Private Ltd"){$addflag=3;}
else if($type_of_firm=="Public Ltd"){$addflag=4;}
else if($type_of_firm=="Proprietory HUF"){$addflag=5;}
else if($type_of_firm=="Individual"){$addflag=6;}
else if($type_of_firm=="Trustees"){$addflag=7;}
else if($type_of_firm=="Co-Op Society"){$addflag=8;}
else if($type_of_firm=="Others"){$addflag=9;}

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
		echo "<option value='$rows[id]'";
		if($rows[id]==$cresult[type_of_address]){echo "selected='selected'";}
		echo ">$rows[type_of_comaddress_name]</option>";
		}
		?>
         <?php if($member_type_id=="Manufacturer"){?><option value="12">SSI/IEM</option><?php }?>
		</select></td>
  </tr>
  <tbody <?php if($cresult['name']==''){?>style="display:none;" <?php }?>  id="basedontype">
  <tr >
    <td colspan="2" ><span class="text6 ">Name:</span> <span class="star">* </span></td>
    <td><input type="text"  id="name" name="name"  class=" input_txt" value="<?php echo $cresult['name'];?>" /></td>
    </tr>	
    
    
    <tr >
    <td colspan="2"><span class="text6 ">Father's Name:</span></td>
    <td><input type="text" class=" input_txt" id="father_name" name="father_name" value="<?php echo $cresult['father_name'];?>"/></td>
  </tr>
  </tbody>

	<tr >
    <td colspan="2" ><span class="text6 ">Address Line 1:</span> <span class="star">* </span></td>
    <td><input type="text" class=" input_txt" id="address1"  name="address1" value="<?php echo $cresult['address1'];?>"/></td>
    </tr>	
    
    
    <tr >
    <td colspan="2"><span class="text6 ">Address Line 2:</span></td>
    <td><input type="text" class=" input_txt" id="address2" name="address2" value="<?php echo $cresult['address2'];?>" /></td>
  </tr>

	<tr  >
    <td colspan="2"><span class="text6 ">Address Line 3:</span></td>
    <td>
    	<input type="text" class=" input_txt" id="address3" name="address3" value="<?php echo $cresult['address3'];?>" /> </td>
  </tr>
	<tr >
	  <td colspan="2"><span class="text6 ">City:</span> <span class="star">* </span></td>
	  <td>
      <input type="text" class=" input_txt" id="city" name="city" value="<?php echo $cresult['city'];?>"/>
      </td>
	  </tr>
	<tr >
	  <td colspan="2"><span class="text6 ">Country:</span> <span class="star"> * </span></td>
	  <td>
      <select name="country" id="country" class="input_txt">
		<option value="">---------- Select ----------</option>
       <?php 
		$query=mysql_query("SELECT * FROM country_master");
		while($result=mysql_fetch_array($query)){
		?>
        <option value="<?php echo $result['country_code'];?>" <?php if($result['country_code']==$cresult['country']){?> selected="selected" <?php }?>><?php echo $result['country_name'];?></option>
        <?php }?>
	 </select>
      </td>
	</tr>
      <tr id="stateDiv" >
      <td colspan="2"><span class="text6 ">Country:</span> <span class="star"> * </span></td>
      <td>
        <select name="state" id="state" class="input_txt">
        <option value="">--Select State--</option>
        <?php 
        $query=mysql_query("SELECT * from state_master WHERE country_code = 'IND'");
        while($result=mysql_fetch_array($query)){?>
        <option value="<?php echo $result['state_code'];?>" <?php if($result['state_code']==$cresult['state']){?> selected="selected" <?php }?>><?php echo $result['state_name'];?></option>
        <?php }?>
        </select>
        </td>
      </tr>
      
	<tr>
	  <td colspan="2"><span class="text6 ">Pin Code:</span>  <span class="star"> * </span></td>
	  <td><input type="text" class="input_txt" id="pincode" name="pincode" value="<?php echo $cresult['pincode'];?>" maxlength="6"/></td>
	  </tr>
	<tr >
	  <td colspan="2"><span class="text6 ">Landline No.:</span><span class="star"> * </span></td>
	  <td><input type="text" class="input_txt" id="landline_no1" name="landline_no1" value="<?php echo $cresult['landline_no1'];?>"/></td>
	  </tr>
	<tr >
	  <td colspan="2"><span class="text6 ">Mobile No.:</span> <span class="star"> * </span></td>
	  <td><input type="text" class="input_txt" id="mobile_no" name="mobile_no" value="<?php echo $cresult['mobile_no'];?>" maxlength="10" /></td>
	  </tr>
	<tr >
	  <td colspan="2"><span class="text6 ">Fax No.1:</span></td>
	  <td><input type="text" class="input_txt" id="fax_no1" name="fax_no1" value="<?php echo $cresult['fax_no1'];?>" /></td>
	  </tr>
	<tr >
	  <td colspan="2"><span class="text6 ">Fax No.2:</span></td>
	  <td><input type="text" class="input_txt" id="fax_no2" name="fax_no2" value="<?php echo $cresult['fax_no2'];?>" /></td>
	  </tr>
	<tr >
	  <td colspan="2"><span class="text6 ">Email:</span> <span class="star"> * </span></strong></td>
	  <td><input type="text" class="input_txt1" id="email_id" name="email_id" value="<?php echo $cresult['email_id'];?>"/></td>
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
	$service_tax=round(($total_amnt*12.36)/100);
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
	$service_tax=round(($total_amnt*12.36)/100);
	echo $service_tax_final=intval($service_tax)."#";
	echo $totpaybleamnt=intval($total_amnt)+intval($service_tax);
}
?>

