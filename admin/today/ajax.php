<?php 
session_start();
include ("db.inc.php");
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getCity"){
$country=$_POST['country'];
$query=mysql_query("SELECT * from state_master WHERE country_code = '$country'");
if($country=="IND" || $country=="IN"){
?>
	  <label>State / Province : <sup>*</sup></label>
	  <select name="state" id="state" class="textField">
      <option value="">--Select State--</option>
      <?php while($result=mysql_fetch_array($query)){?>
      <option value="<?php echo $result['state_code'];?>"><?php echo $result['state_name'];?></option>
      <?php }?>
      </select>
	<br />
      <span id="error_first_name"></span>
<?php } else {?>
<label>State / Province : <sup>*</sup></label>
<input type="text" class="textField" id="state" name="state" />
<br />
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
    $query=mysql_query("select * from temp_privilege_visitor_reg where privilege_code='$visitor_code' GROUP BY privilege_code");
    $num=mysql_num_rows($query);
	$result=mysql_fetch_array($query);
	if($num>0)
	{	
?>
<form method="post" action="registration.php">
    <div class="field">
        <strong><?php echo $result['contact_person'];?></strong> (<?php echo $result['designation'];?>)<br />
        <?php echo $result['company_name'];?><br />
        <?php if($result['address1']!=""){echo $result['address1']."<br />";}?>
        <?php if($result['address2']!=""){echo $result['address2']."<br />";}?>
        <?php if($result['address3']!=""){echo $result['address3']." - ";}?>
		<?php if($result['pincode']!=""){echo $result['pincode']."<br />";}?>
        <?php if($result['city']!=""){echo $result['city'];} echo ' / '.$result['state']."<br />";?>       
        <?php if($result['telephone_no_office']!=""){echo $result['telephone_no_office']." / ";}?>
        <?php if($result['mobile']!=""){echo $result['mobile']."<br />";}?>
		<?php if($result['email']!=""){echo $result['email']."<br />";}?>
    </div>
    <div class="field">
        <label></label>
        <input name="visitor_code" id="visitor_code" type="hidden" value="<?php echo $visitor_code;?>"/>
		<div class="button"><a href="#">Registration Closed</a></div>
        <!--<input name="registration_submit" id="registration_submit" type="submit"  class="submitButton" value="Procced to Registration"/> -->      
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
<form method="post" action="registration.php">
    <div class="field">
        <?php echo $result['contact_person'];?> (<?php echo $result['designation'];?>)<br />
        <?php if($result['address1']!=""){echo $result['address1']."<br />";}?>
        <?php if($result['address2']!=""){echo $result['address2']."<br />";}?>
        <?php if($result['address3']!=""){echo $result['address3']."<br />";}?>
        <?php if($result['pincode']!=""){echo $result['pincode']."<br />";}?>
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
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getRoom"){
$hotel_id=$_POST['hotel_id'];
$query=mysql_query("SELECT * from hotel_details WHERE hotel_id = '$hotel_id'");
?>
	  
	  <select name="hotel_details_id" id="hotel_details_id" class="textField">
      <option value="">--Select Room Type--</option>
      <?php while($result=mysql_fetch_array($query)){?>
      <option value="<?php echo $result['hotel_details_id'];?>"><?php echo $result['room_name'];?></option>
      <?php }?>
      </select>
	
<?php }?>


<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getRate"){
$hotel_details_id=$_POST['hotel_details_id'];
$query=mysql_query("SELECT * from hotel_details WHERE hotel_details_id = '$hotel_details_id'");
$result=mysql_fetch_array($query);
echo "Rs. ".$result['rate']." /-";
}
?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getoutDate"){
$ck_in_dd=$_POST['ck_in_dd'];
$j=$ck_in_dd+1;
for($i=$j;$i<15;$i++){
	
	/*if($i==10 || $i==11 )
	{ */?>
	<option value="<?php echo $i;?>"><?php echo $i;?></option>
	<?php
	//} else {
	?>
	<!--<option value="0<?php echo $i;?>">0<?php echo $i;?></option>-->
<?php
//}
}}
?>
<?php /*
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getoutDate"){
$ck_in_dd=$_POST['ck_in_dd'];
$j=$ck_in_dd+1;
for($i=$j;$i<12;$i++){
?>
<option value="<?php echo $i;?>"><?php echo $i;?></option>
<?php
}} */
?>
<?php
/*if(isset($_POST['actiontype']) && $_POST['actiontype']=="calculatePayment"){
$ck_in_dd=$_POST['ck_in_dd'];
$ck_out_dd=$_POST['ck_out_dd'];
$hotel_details_id=$_POST['hotel_details_id'];
$no_of_room=$_POST['no_of_room'];
$caldate=$ck_out_dd-$ck_in_dd;
$query=mysql_query("SELECT * from hotel_details WHERE hotel_details_id = '$hotel_details_id'");
$result=mysql_fetch_array($query);
$rate=$result['rate'];
echo $total_price=($caldate*$rate*$no_of_room);
}*/
?>
<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getState"){
$country=$_POST['country'];
$query=mysql_query("SELECT * from state_master WHERE country_code = '$country'");
if($country=="IND"){
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
$section=$_POST['section'];
$category=$_POST['category'];
$selected_premium_type=$_POST['selected_premium_type'];
$woman_entrepreneurs=$_POST['woman_entrepreneurs'];

if(strtoupper($_SESSION['COUNTRY'])=="INDIA" || strtoupper($_SESSION['COUNTRY'])=="IND" || strtoupper($_SESSION['COUNTRY'])=="IN")
{
	if($section=="plain_gold")
	{
		$charge="22650";
	}
	else if($section=="loose_stones")
	{
		$charge="21450";
	}
	else if($section=="signature_club")
	{
		$charge="30500";
	}
	else if($section=="studded_jewellery")
	{
		$charge="22650";
	}
	else if($section=="lab_edu")
	{
		$charge="21450";
	}
	else if($section=="allied")
	{
		$charge="21450";
	}
	else if($section=="synthetics")
	{
		$charge="21450";
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
if(isset($_POST['actiontype']) && $_POST['actiontype']=="selectArea"){
$section=$_POST['section'];
$option=$_POST['option'];
$selected_area=$_POST['selected_area'];
if($option=="Same area but different location as of previous year Signature 2016")
{
	$sql="select * from signature_area_master where area='$selected_area'";	
}
else if($section=="signature_club" && $option=="More area than previous year Signature")
{
	$sql="select * from signature_area_master where area in ('12','24','36','48') and area>$selected_area";	
}
else if($section=="signature_club" && $option=="Less area as previous year")
{
	$sql="select * from signature_area_master where area in ('12','24','36','48') and area<$selected_area";	
}
else if($option=="Less area as previous year" && $section!="signature_club")
{
	$sql="select * from signature_area_master where area in ('9','18','27','36','45','54') and area<$selected_area";
}
else if($option=="More area than previous year Signature" && $section!="signature_club")
{
	$sql="select * from signature_area_master where area in ('9','18','27','36','45','54') and area>$selected_area";
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
if(isset($_POST['actiontype']) && $_POST['actiontype']=="optionValue"){
$option=$_POST['option'];
$section=$_POST['section'];
$lastYearArea=$_POST['lastYearArea'];

	if($option=="Same stall position size as of previous year")
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
	
	$query=mysql_query($sql);
	$num=mysql_num_rows($query);
	if($num>0){
	while($result=mysql_fetch_array($query)){
	?>
	<option value="<?php echo $result['area'];?>" <?php if($result['area']==$lastYearArea){?> selected="selected" <?php }?>><?php echo $result['area'];?></option>
<?php }}}?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="hotel_payment"){
$ck_in_dd=$_POST['ck_in_dd'];
$ck_out_dd=$_POST['ck_out_dd'];
$hotel_details_id=intval($_POST['hotel_details_id']);
$no_of_room=intval($_POST['no_of_room']);
$caldate=$ck_out_dd-$ck_in_dd;
$query=mysql_query("SELECT * from hotel_details WHERE hotel_details_id = '$hotel_details_id'");
$result=mysql_fetch_array($query);
$rate=$result['rate'];
echo $total_price=($caldate*$rate*$no_of_room);
}



?>
