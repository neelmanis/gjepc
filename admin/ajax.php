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
<?php } else { ?>
<div class="field_name">State / Province <span>*</span> :</div>
<div class="field_input">
<input type="text" class="bgcolor" id="state" name="state" />
</div>
<div class="clear"></div>
   <span id="error_first_name"></span>
<?php } ?>
<?php } ?>

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
$member_type=$_SESSION['member_type'];
$membership_certificate_type = trim($_SESSION['membership_certificate_type']);	
$msme_ssi_status = trim($_SESSION['msme_ssi_status']);

$selected_area=$_POST['selected_area'];
$section=$_POST['section'];
$category=$_POST['category'];
$selected_scheme_type=$_POST['selected_scheme_type'];
$selected_premium_type=$_POST['selected_premium_type'];
$last_yr_participant = trim($_POST['last_yr_participant']);
$woman_entrepreneurs=$_POST['woman_entrepreneurs'];
$country=$_POST['country'];

if(strtoupper($country)=="IN")
{
	if($section=="plain_gold")
	{
		$charge="22000";
	}
	else if($section=="loose_stones")
	{
		$charge="22000";
	}
	else if($section=="signature_club")
	{
		$charge="30500";
	}
	else if($section=="studded_jewellery")
	{
		$charge="22000";
	}
	else if($section=="lab_edu")
	{
		$charge="22000";
	}
	else if($section=="allied")
	{
		$charge="22000";
	}
	else if($section=="synthetics")
	{
		$charge="22000";
	}
	else if($section=="silver_jewellery_artifacts")
	{
		$charge="22000";
	}
} else {
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

// if(strtoupper($last_yr_participant)=="YES")
// {
// if($membership_certificate_type!=''){
// 	if($membership_certificate_type=='ZASSOC')
// 	{
// 		$space_rate_discount=($space_rate*0.05);
// 	}
// 	if($membership_certificate_type=='ZASSOC' && $_SESSION['msme_ssi_status']=="Yes")
// 	{
// 		$space_rate_discount=($space_rate*0.10);
// 	}
// 	if($membership_certificate_type=='ZORDIN')
// 	{
// 		$space_rate_discount=($space_rate*0.15);
// 	}
// }
// }

echo $tot_space_cost_discount=intval($space_rate_discount)."#";

$get_tot_space_cost = $space_rate-$space_rate_discount;  // Get the total difference of Space cost Rate - Discount space cost rate

echo $get_tot_space_cost_rate = intval($get_tot_space_cost)."#";

$category_rate=$get_tot_space_cost*$category;
echo $category_rate1=$category_rate."#";

if($selected_scheme_type=="BI1" || $selected_scheme_type==0){	$scheme_rate=0;	}
echo $scheme_rate1=$scheme_rate."#";
		
$premium_rate=floatval($get_tot_space_cost*$selected_premium_type);
echo $premium_rate1=$premium_rate."#";

$sub_total_cost=floatval($get_tot_space_cost+$category_rate+$premium_rate);
echo $sub_total_cost1=($get_tot_space_cost+$category_rate+$premium_rate)."#";

$security_deposit=floatval($sub_total_cost*10)/100;
echo $security_deposit1=$security_deposit."#";

$govt_service_tax=floatval($sub_total_cost*18)/100;
echo $govt_service_tax1=$govt_service_tax."#";

$grand_total=round($sub_total_cost+$security_deposit+$govt_service_tax);
echo $grand_total1=$grand_total."#";
}
?>
<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="calculatePaymentTritiya"){

	$member_type=$_SESSION['member_type'];
$membership_certificate_type = trim($_SESSION['membership_certificate_type']);	

$selected_area = $_POST['selected_area'];
$section = $_POST['section'];
$rate = 18000;
echo $rate = $rate."#"; 
echo $tot_space_cost_rate=$selected_area*$rate."#";
$security_deposit = round(floatval($tot_space_cost_rate*10)/100);
echo $security_deposit1 = floatval($security_deposit)."#";
echo $govt_service_tax=($tot_space_cost_rate*18/100)."#";
echo $grand_total=$security_deposit1+$tot_space_cost_rate+$govt_service_tax."#";
}
?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getPremiumType"){
	$selected_area=$_POST['selected_area'];
	
	if($selected_area=='9' || $selected_area=='18')
		echo $sql1="select * from signature_scheme_master where status='Y'";
	else
		echo $sql1="select * from signature_scheme_master where scheme='BI2'";
		
	$query1=mysql_query($sql1);
	$num1=mysql_num_rows($query1);
	if($num1>0){
	echo "<option selected='selected' value=''>-----Select Scheme Type----</option>";
	while($result1=mysql_fetch_array($query1)){
	?>
	<option value="<?php echo $result1['scheme'];?>"><?php echo $result1['scheme_desc'];?></option>
<?php }} echo "#";?>

<?php 
	if($selected_area>=36)
		$sql="select * from  signature_premium_master order by premium_id asc";
	else 
		$sql="select * from  signature_premium_master where status='Y' order by premium_id asc";
		
	$query=mysql_query($sql);
	$num=mysql_num_rows($query);
	if($num>0){
	echo "<option selected='selected' value=''>-----Select Premium Type----</option>";
	while($result=mysql_fetch_array($query)){
	?>
	<option value="<?php echo $result['premium'];?>"><?php echo $result['premium_desc'];?></option>
<?php }}} ?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="optionValue"){
//	echo '<pre>'; print_r($_POST);
$option=$_POST['option'];
$section=$_POST['section'];
$signature_selected_scheme_type=$_POST['signature_selected_scheme_type'];
$lastYearArea=$_POST['lastYearArea'];  

	if($option=="Same stall position size as of previous year")
	{
		$sql="select * from signature_area_master where 1";	
	}
	elseif($option=="Same area but different location as of previous year Signature")
	{
		$sql="select * from signature_area_master where 1";	
	}
	else if($section=="signature_club" && $option=="More area than previous year Signature")
	{
		$sql="select * from signature_area_master where area in ('12','24','36','48') and area>$lastYearArea";	
	}
	else if($section=="signature_club" && $option=="Less area as previous year")
	{
		$sql="select * from signature_area_master where area in ('12','24','36','48') and area<$lastYearArea";	
	}
	else if($option=="Less area as previous year" && $section!="signature_club")
	{
		$sql="select * from signature_area_master where area in ('9','18','27','36','45','54') and area<$lastYearArea";
	}
	else if($option=="More area than previous year Signature" && $section!="signature_club")
	{
		$sql="select * from signature_area_master where area in ('9','18','27','36','45','54') and area>$lastYearArea";
	}
	else if($option=="Less area as previous year")
	{
		$sql="select * from signature_area_master where area in ('9','18','27','36','45','54') and area<$lastYearArea";
	}
	//echo $sql;

	$query=$conn->query($sql);
	$num=$query->num_rows;
	if($num>0){
	echo "<option value=''>--Select Area--</option>";
	while($result=mysql_fetch_array($query)){
	?>
	<option value="<?php echo $result['area'];?>" <?php if($result['area']==$lastYearArea){?> selected="selected" <?php }?>><?php echo $result['area'];?></option>
<?php }}
	$sql1="SELECT * FROM  signature_scheme_master where status='Y'";	
	$query1=mysql_query($sql1);
	$scheme.="<option value=''>--Select Scheme--</option>";
	while($result1=mysql_fetch_array($query1))
	{
		if($result1['scheme']==$signature_selected_scheme_type)
			$scheme.="<option value=".$signature_selected_scheme_type." selected='selected'>".$result1['scheme_desc']."</option>";
		else
			$scheme.="<option value=".$result1['scheme'].">".$result1['scheme_desc']."</option>";
	}
	echo "#".$scheme."#";

}?>

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
if(isset($_POST['designation']) && $_POST['designation']!=""){$designation=$_POST['designation'];}else{$designation="";}
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

if(!empty($type_of_address)){
	if($type_of_address==2 || $address_identity=="CTP"){ $pan_no = filter(strtoupper($_POST['pan_no'])); }	else { $pan_no = ""; }
} else { echo "Type of Address missing"; }

$gst_no=filter(strtoupper($_POST['gst_no']));
$aadhar_no = filter(strtoupper($_POST['aadhar_no']));
$passport_no = filter(strtoupper($_POST['passport_no']));
if($joining_date=="")
	$joining_date = date('Y-m-d');
else
	$joining_date = $_POST['joining_date'];
	
if($retirement_date=="")
	$retirement_date = date('Y-m-d');	
else
	$retirement_date = $_POST['retirement_date'];
	
$dt = date('Y/m/d'); 

$qcheck = $conn ->query("select * from communication_address_master where id='$id' and registration_id='$registration_id'");
$rcheck = $qcheck->num_rows;
if($rcheck>0){
$sql=$conn ->query("update communication_address_master set type_of_address='$type_of_address',address_identity='$address_identity',type_of_address_sap='$type_of_address_sap',name='$name',father_name='$father_name',designation='$designation',,address1='$address1',address2='$address2',address3='$address3',city='$city',country='$country',state='$state',pincode='$pincode',landline_no1='$landline_no1',mobile_no='$mobile_no',fax_no1='$fax_no1',fax_no2='$fax_no2',email_id='$email_id',din_no='$din_no',pan_no='$pan_no',gst_no='$gst_no',aadhar_no='$aadhar_no',passport_no='$passport_no',joining_date='$joining_date',retirement_date='$retirement_date' where id='$id' and registration_id='$registration_id'");
if(!$sql) die ($conn->error);
}
else{
$sql=$conn ->query("insert into communication_address_master set registration_id='$registration_id',type_of_address='$type_of_address',address_identity='$address_identity',type_of_address_sap='$type_of_address_sap',name='$name',father_name='$father_name',designation='$designation',address1='$address1',address2='$address2',address3='$address3',city='$city',country='$country',state='$state',pincode='$pincode',landline_no1='$landline_no1',mobile_no='$mobile_no',fax_no1='$fax_no1',fax_no2='$fax_no2',email_id='$email_id',din_no='$din_no',pan_no='$pan_no',gst_no='$gst_no',aadhar_no='$aadhar_no',passport_no='$passport_no',joining_date='$joining_date',retirement_date='$retirement_date',status=1,post_date='$dt'");
if(!$sql) die ($conn->error);
}
$query = $conn ->query("select * from communication_address_master where registration_id='$registration_id'");
while($result = $query->fetch_assoc()){
?>
<tr>
<td ><span class="text6"><?php echo getaddresstype($result['type_of_address'],$conn);?></span></td>
<td><span class="text6"><?php echo $result['c_bp_number'];?></span></td>
<td><span class="text6"><?php echo $result['address_identity'];?></span></td>
<td width="19%"><span class="text6"><?php echo $result['address1'];?><?php if($result['address2']!=""){echo ",".$result['address2'];}?><?php if($result['address3']!=""){echo ",".$result['address3'];}?><?php if($result['city']!=""){echo ",".$result['city'];}?><?php if($result['state']!=""){echo ",".$result['state'];}?><?php if($result['pincode']!=""){echo ",".$result['pincode'];}?></span></td>
<td width="29%" ><?php echo $result['name'];?></td> 
<td width="35%" ><span class="editAdd <?php echo $result['id'];?> <?php echo $registration_id;?>">EDIT</span></td>
<td width="35%" ><span class="deleteAdd <?php echo $result['id'];?> <?php echo $registration_id;?>">DELETE</span></td>
</tr>
<?php }} ?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="deleteAdd"){
$id	=	intval(filter($_POST['id']));
$registration_id	=	intval(filter($_POST['registration_id']));

$info_status = $conn ->query("delete from communication_address_master where id='$id' and registration_id='$registration_id'");

$query = $conn ->query("select * from communication_address_master where registration_id='$registration_id'");
while($result= $query->fetch_assoc()){
?>
<tr>
<td><span class="text6"><?php echo getaddresstype($result['type_of_address'],$conn);?></span></td>
<td width="19%"><span class="text6"><?php echo $result['address1'];?><?php if($result['address2']!=""){echo ",".$result['address2'];}?><?php if($result['address3']!=""){echo ",".$result['address3'];}?><?php if($result['city']!=""){echo ",".$result['city'];}?><?php if($result['state']!=""){echo ",".$result['state'];}?><?php if($result['pincode']!=""){echo ",".$result['pincode'];}?></span></td>
<td width="29%"><?php echo $result['name'];?></td> 
<td width="35%"><span class="deleteAdd <?php echo $result['id'];?> <?php echo $registration_id;?>">DELETE</span></td>
<td width="35%"><span class="editAdd <?php echo $result['id'];?> <?php echo $registration_id;?>">EDIT</span></td>
</tr>
<?php } } ?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="editAdd"){
	
$id	=	intval(filter($_POST['id']));
$registration_id	=	intval(filter($_POST['registration_id']));

if($id!="" && $registration_id!=""){
	
$info_status = $conn ->query("select member_type_id,type_of_firm,status from information_master where registration_id='$registration_id' and status=1");
$info_row = $info_status->fetch_assoc();
$member_type_id=$info_row['member_type_id'];
$type_of_firm=$info_row['type_of_firm'];

$cquery  = $conn ->query("select * from communication_address_master where id='$id' and registration_id='$registration_id'");
$cresult = $cquery->fetch_assoc();
$type_of_addresss = $cresult['type_of_address'];
$tmp = explode("-", $type_of_addresss);

$type_of_address = $tmp[0];
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
?>
<form id="comaddress" name="comaddress" method="post" action="comm_update.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt">
<tr>
 <td bgcolor="#CCCCCC" colspan="3"><strong>Address Details</strong></td>
 </tr> 
  <tr>
    <td colspan="2"><span class="text6">Type of Communication Address:</span> <span class="star"> * </span></td>
    <td>
    	<input type="hidden" name="hidden" id="hidden" value=""/>
    	<select class="input_txt1" id="type_of_address" name="type_of_address">
		<option value="">----Select----</option>
        <?php
		$sql=getCommunicationAddress($addflag);
		$query = $conn -> prepare($sql);
		$query->execute();			
		$row = $query->get_result();
		while($rows = $row->fetch_assoc())
		{
		echo "<option value='$rows[id]-$rows[address_identity]'";
		if($rows[id]==$type_of_address){ echo "selected='selected'"; }
		echo ">$rows[type_of_comaddress_name]</option>";
		}
		?>
		</select>
	</td>
  </tr>
  <!--<tbody <?php if($cresult['name']==''){?> style="display:none;" <?php }?> id="basedontype">-->
  
  <tbody <?php if($address_identity=="CTP"){ ?>  <?php } else { ?>style="display:none;"<?php } ?> id="basedontype">  
	<tr>
    <td colspan="2"><span class="text6">Name:</span> <span class="star">* </span></td>
    <td><input type="text" id="name" name="name"  class=" input_txt_new" value="<?php echo $cresult['name'];?>" /></td>
    </tr>    
    <tr>
    <td colspan="2"><span class="text6 ">Father's Name:</span></td>
    <td><input type="text" class="input_txt_new" id="father_name" name="father_name" value="<?php echo $cresult['father_name'];?>"/></td>
	</tr>
    <tr>
    <td colspan="2"><span class="text6 ">Designation:</span></td>
    <td>
    <select name="designation" id="designation">
    <option value="">--Select--</option>
        <option value="Partner" <?php if($cresult['designation']=="Partner"){?> selected="selected"<?php }?>>Partner</option>
        <option value="Director" <?php if($cresult['designation']=="Director"){?> selected="selected"<?php }?>>Director</option>
        <option value="Proprietor" <?php if($cresult['designation']=="Proprietor"){?> selected="selected"<?php }?>>Proprietor</option>
    </select>    
    </td>
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
		$query =  $conn ->query("SELECT * FROM country_master where country_code='IN'");
		while($result = $query->fetch_assoc()){ ?>
        <option value="<?php echo $result['country_code'];?>" <?php if($result['country_code']==$cresult['country']){?> selected="selected" <?php }?>><?php echo $result['country_name'];?></option>
        <?php } ?>
	 </select>
      </td>
	</tr>
    <tr id="stateDiv">
      <td colspan="2"><span class="text6 ">State:</span> <span class="star"> * </span></td>
      <td>
        <select name="state" id="state" class="input_txt_new">
        <option value="">--Select State--</option>
        <?php 
        $query = $conn ->query("SELECT * from state_master WHERE country_code = 'IN'");
        while($result = $query->fetch_assoc()){ ?>
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
	<?php if($type_of_address==1 || $type_of_address==2 || $type_of_address==5 || $type_of_address==7 || $type_of_address==8 || $type_of_address==9 || $type_of_address==13){ ?>
	<tr>
	<td colspan="2"><span class="text6">PAN:</td>
	<td><input type="text" class="input_txt1" id="pan_no" name="pan_no" value="<?php echo $cresult['pan_no'];?>" maxlength="10"/></td>
	</tr>
	<?php } ?>
	
		<!--<tr <?php if($address_identity=="CTC"){ ?> style="display:none;" <?php } else { ?><?php }?> id="basedontype">
			<tr>
			<td colspan="2"><span class="text6">Aadhar Nos :</td>
			<td><input type="text" class="input_txt1" id="aadhar_no" name="aadhar_no" value="<?php echo $cresult['aadhar_no'];?>" maxlength="15" placeholder="Aadhar No" autocomplete="off"></td>
			</tr>
			<tr>
			<td colspan="2"><span class="text6">Passport No. :</td>
			<td><input type="text" class="input_txt1" id="passport_no" name="passport_no" value="<?php echo $cresult['passport_no'];?>" maxlength="10" placeholder="Passport No" autocomplete="off"></td>
			</tr>
			<tr>
			<td colspan="2"><span class="text6">Joining Date :</td>
			<td><input type="date" class="input_txt1" value="<?php echo $cresult['joining_date'];?>" id="joining_date" name="joining_date" placeholder="Joining Date" autocomplete="off"/></td>
			</tr>
			<tr>
			<td colspan="2"><span class="text6">Retirement Date :</td>
			<td><input type="date" class="input_txt1" value="<?php echo $cresult['retirement_date'];?>" id="retirement_date" name="retirement_date" placeholder="Retirement Date" autocomplete="off"/></td>
			</tr>
			<tr <?php if($address_identity=="CTP"){ ?> style="display:none;" <?php } else {?><?php }?> id="basedontype">
			<td colspan="2"><span class="text6">GSTIN :</td>
			<td><input type="text" class="input_txt1" id="gst_no" name="gst_no" value="<?php echo $cresult['gst_no'];?>" maxlength="15"/></td>
			</tr>
		</tr>-->
			<tr <?php if($address_identity=="CTC"){ ?> style="display:none;" <?php } else { ?><?php }?> id="basedonAdhar">	
			<td colspan="2"><span class="text6">Aadhar Nos :</td>
			<td><input type="text" class="input_txt1" id="aadhar_no" name="aadhar_no" value="<?php echo $cresult['aadhar_no'];?>" maxlength="15" placeholder="Aadhar No" autocomplete="off"></td>
			</tr>
			<tr <?php if($address_identity=="CTC"){ ?> style="display:none;" <?php } else { ?><?php }?> id="basedonpass">
			<td colspan="2"><span class="text6">Passport No. :</td>
			<td><input type="text" class="input_txt1" id="passport_no" name="passport_no" value="<?php echo $cresult['passport_no'];?>" maxlength="10" placeholder="Passport No" autocomplete="off"></td>
			</tr>
			<tr <?php if($address_identity=="CTC"){ ?> style="display:none;" <?php } else { ?><?php }?> id="basedonjdate">
			<td colspan="2"><span class="text6">Joining Date :</td>
			<td><input type="date" class="input_txt1" value="<?php echo $cresult['joining_date'];?>" id="joining_date" name="joining_date" placeholder="Joining Date" autocomplete="off"/></td>
			</tr>
			<tr <?php if($address_identity=="CTC"){ ?> style="display:none;" <?php } else { ?><?php }?> id="basedonrdate">
			<td colspan="2"><span class="text6">Retirement Date :</td>
			<td><input type="date" class="input_txt1" value="<?php echo $cresult['retirement_date'];?>" id="retirement_date" name="retirement_date" placeholder="Retirement Date" autocomplete="off"/></td>
			</tr>
			<tr <?php if($address_identity=="CTP"){ ?> style="display:none;" <?php } else {?><?php }?> id="basedontype">
			<td colspan="2"><span class="text6">GSTIN :</td>
			<td><input type="text" class="input_txt1" id="gst_no" name="gst_no" value="<?php echo $cresult['gst_no'];?>" maxlength="15"/></td>
			</tr>
			 	
	<tr>
    <td colspan="13" class="text6" ><span class="style6">Note- : Fill up name of all present partners and directores as the case may be.</span></td>
    <input type="hidden" id="registration_id" name="registration_id" value="<?php echo $_REQUEST['registration_id'];?>"/>  
    <input type="hidden" id="id" name="id" value="<?php echo $id;?>" /> 
    </tr>
  
  </table>
<input type="submit" name="update" id="update"  value="Update" class="input_submit" />
</form>
<?php } } ?>

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
$registration_id=$_POST['registration_id'];
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
	} else {
		
	$query1 = $conn ->query("SELECT eligible_for_renewal FROM `approval_master` WHERE 1 and registration_id='$registration_id' order by id desc limit 1");
	$result1= $query1->fetch_assoc();
	$eligible_for_renewal=$result1['eligible_for_renewal'];
	
	$qrenewded = $conn ->query("select deadline_date from renewal_deadline_master");
	$rrenewded = $qrenewded->fetch_assoc();
	$deadline_date = $rrenewded['deadline_date'];

    $queryt = $conn ->query("select * from export_amount_master where status=1 and financial_year='$cur_fin_yr'");
	while($result = $queryt->fetch_assoc())
	{
		if($tot_examount>=$result['export_start_amount'] && $tot_examount<=$result['export_end_amount'])
		{
			echo $membershipfees=$result['membership_fee']."#";
			$admissionfees=0;
			$ad_valorem=0;
		}		
	}
	
	if($deadline_date>=date("Y-m-d") && $eligible_for_renewal=="Y")
	{
		$admissionfees=0;
	}
	
	echo $admissionfeesfinal=$admissionfees."#";
	$total_amnt=intval($membershipfees)+intval($admissionfees);
	echo $total_amnt_final=intval($membershipfees)+intval($admissionfees)."#";
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
    } else {
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
    $querym = $conn ->query("select * from export_amount_master where status=1 and financial_year='$cur_fin_yr'");
	while($result =  $querym->fetch_assoc())
	{
		if($tot_examount>=$result['export_start_amount'] && $tot_examount<=$result['export_end_amount'])
		{
			echo $membershipfees=$result['membership_fee']."#";
			$admissionfees=0;
			$ad_valorem=0;
			
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
}

?>
<?php if(isset($_POST['actiontype']) && $_POST['actiontype']=="approval_status_update_action"){
	$payment_id  = $_REQUEST['payment_id'];
	$approval  = $_REQUEST['approval'];
	 $sql = "UPDATE promo_video_payment_history SET approval_status='$approval' WHERE id='$payment_id'";
	$result = $conn->query($sql);
	if($result){
		echo json_encode(array("status"=>"success"));exit;
	}else{
		echo json_encode(array("status"=>"fail"));exit;
	}


}?>
<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getSavedTemplatedOnType"){
	$category = $_POST["msg_type"];
    $query=$conn->query("SELECT * from whatsapp_templates_master WHERE category = '$category' and status='1'");

    $output = "";
    $output .='<option value=" ">Select Template</option>';
    while ($row = $query->fetch_assoc()) {
    	$output .='<option value="'.$row['id'].'">'.$row['template_name'].'</option>';
    }
	
	$count = $query->num_rows;
	if($count>0){
        echo json_encode(array("status"=>"success","data"=>$output));exit;
	}else{
		echo json_encode(array("status"=>"error","message"=>"templates not found for selected media type"));exit;
	}

}
?>
<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getTemplateData"){
	$template_id = $_POST["template_id"];
	if($template_id!=""){
		$query=$conn->query("SELECT * from whatsapp_templates_master WHERE id = '$template_id'");
	    $count = $query->num_rows;
		if($count>0){
			$row = $query->fetch_assoc();
			$title = $row['template_title'];
			$content = $row['content'];
	        echo json_encode(array("status"=>"success","title"=>$title,"content"=>$content));exit;
		}else{
			echo json_encode(array("status"=>"error","message"=>"templates not found in system"));exit;
		}
	}
    

}
if(isset($_POST['actiontype']) && $_POST['actiontype']=="updatePhoto"){
echo "<pre>";print_r($_POST);
print_r($_FILES);exit;
    

}

?>