<?php 
session_start();
include ("db.inc.php");
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getCity"){
$country=$_POST['country'];
$query=mysql_query("SELECT * from state_master WHERE country_code = '$country'");
if($country=="IND"){
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
$member_type=$_SESSION['member_type'];
$pkg=$_SESSION['combo'];

$section=$_POST['section'];
$selected_area=$_POST['selected_area'];
$selected_scheme_type=$_POST['selected_scheme_type'];
$category=$_POST['category'];
$selected_premium_type=$_POST['selected_premium_type'];
$woman_entrepreneurs=$_POST['woman_entrepreneurs'];

if(strtoupper($_SESSION['COUNTRY'])=="INDIA" || strtoupper($_SESSION['COUNTRY'])=="IND")
{
	if($selected_scheme_type=="RW")
	{
		$selected_scheme_type="20900";
	}
	else if($selected_scheme_type=="BI1")
	{
		$selected_scheme_type="23800";
	}
	else if($selected_scheme_type=="BI2")
	{
		$selected_scheme_type="26900";
	}
	else if($selected_scheme_type=="0")
	{
		$selected_scheme_type=0;
	}
		
}else{

	if($selected_scheme_type=="RW")
	{
		$selected_scheme_type="500";
	}
	else if($selected_scheme_type=="BI1")
	{
		$selected_scheme_type="585";
	}
	else if($selected_scheme_type=="BI2")
	{
		$selected_scheme_type="620";
	}
	else if($selected_scheme_type=="0")
	{
		$selected_scheme_type=0;
	}
}
if($selected_premium_type=="normal")
{
	$selected_premium_type=0;
}
else if($selected_premium_type=="corner")
{
	$selected_premium_type=10;
}
else if($selected_premium_type=="island")
{
	$selected_premium_type=15;
}
else if($selected_premium_type=="premium")
{
	$selected_premium_type=25;
}
else if($selected_premium_type=="duplex")
{
	$selected_premium_type=50;
}

if(strtoupper($_SESSION['COUNTRY'])=="INDIA" || strtoupper($_SESSION['COUNTRY'])=="IND")
{
	if($section=='machinery')
	{
		if($member_type=='MEMBER' && $pkg =='Y')
			$charge=12000;	
		elseif($member_type=='MEMBER' && $pkg =='N')
			$charge=17000;	
		elseif($member_type=='NON_MEMBER' && $pkg =='Y')
			$charge=13500;	
		elseif($member_type=='NON_MEMBER' && $pkg =='N')
			 $charge=18500;	
	}
	else
	{
	   $charge=20900;	
	}
	
}
else
{
	if($section=='machinery')
	{
		$charge=300;			
	}
	else
	{
		$charge=500;
	}

}

if($category=="mezzanine" && $selected_area>=36)
{
	$space_rate=intval(9*$charge);
}
else if($section=='hall_of_innovation')
{
	$space_rate=125000;
}
else if($section=='special_clusters')
{
	$space_rate=140000;
}
else
{
	$space_rate=intval($selected_area*$charge);
}

if($woman_entrepreneurs==1)
{
	$space_rate=($space_rate-$space_rate*0.25);
}

echo $space_rate1=intval($space_rate)."#";

if($category=="mezzanine" && $selected_area>=36)
{
	$mezzanine_space_charge=intval(($selected_area-9)*9500);
	echo $mezzanine_space_charge."#";
}
else
{
	$mezzanine_space_charge=0;
	echo $mezzanine_space_charge."#";
}
if($selected_scheme_type==0)
	$scheme_rate=0;
else
	$scheme_rate=intval($selected_area*($selected_scheme_type-$charge));
	
echo $scheme_rate1=$scheme_rate."#";

$premium_rate=floatval($space_rate*$selected_premium_type)/100;
echo $premium_rate1=$premium_rate."#";

$sub_total_cost=floatval($space_rate+$mezzanine_space_charge+$scheme_rate+$premium_rate);
echo $sub_total_cost1=($space_rate+$mezzanine_space_charge+$scheme_rate+$premium_rate)."#";

$security_deposit=floatval($sub_total_cost*10)/100;
echo $security_deposit1=$security_deposit."#";

$govt_service_tax=floatval($sub_total_cost*15)/100;
echo $govt_service_tax1=$govt_service_tax."#";


$grand_total=round($sub_total_cost+$security_deposit+$govt_service_tax);
echo $grand_total1=$grand_total."#";

	if($selected_scheme_type=="20900")
	{
		$mcb_exact_charges=($selected_area/9)*1000;
		$mcb_service_charges=($mcb_exact_charges*15)/100;
		echo $mcb_charges=round($mcb_exact_charges+$mcb_service_charges);
	}
	else if($selected_scheme_type=="500")
	{
		$mcb_exact_charges=($selected_area/9)*16;
		$mcb_service_charges=($mcb_exact_charges*15)/100;
		echo $mcb_charges=round($mcb_exact_charges+$mcb_service_charges);
	}
	else
	{
		echo $mcb_charges=0;
	}
}
?>


<?php
/*if(isset($_POST['actiontype']) && $_POST['actiontype']=="optionValue"){
$option=trim($_POST['option']);
$lastYearArea=$_POST['lastYearArea'];
	if($option=="More area than previous year IIJS")
	{
		$sql="select * from iijs_area_master where area>$lastYearArea order by area asc limit 0,2";	
	}
	else if($option=="Less area as previous year" || $option=="Less area as previous year at diffrent location")
	{
		$sql="select * from iijs_area_master where area<$lastYearArea order by area asc";	
	}
	$query=mysql_query($sql);
	$num=mysql_num_rows($query);
	if($num>0){
	while($result=mysql_fetch_array($query)){*/
	?>
	
<?php //}}}?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getSchemeType"){
	$selected_area=$_POST['selected_area'];
	if($selected_area=='18')
	{
		$sql="select * from iijs_scheme_master where scheme='BI2'";
	}
	else
	{
		$sql="select * from iijs_scheme_master where scheme!='BI2'";
	}
	$query=mysql_query($sql);
	$num=mysql_num_rows($query);
	if($num>0){
	while($result=mysql_fetch_array($query)){
	?>
	<option value="<?php echo $result['scheme'];?>"><?php echo $result['scheme_desc'];?></option>
<?php }}}?>

<?php
$area=array(12,16,28,36,56);
if(isset($_POST['actiontype']) && $_POST['actiontype']=="optionValue"){
$option=$_POST['option'];
$section=$_POST['section'];

$lastYearArea=$_POST['lastYearArea'];

	if(($option=="Same area but different location as of previous year IIJS 2016" || $option=="More area than previous year IIJS" || $option=="Less area as previous year at diffrent location") && ($section=='couture' || $section=='mass_produced'))
	{
		if($section=='couture')
			$sql="SELECT * FROM iijs_section_master where section='couture' || section='plain_gold'";
		else if($section=='mass_produced')
			$sql="SELECT * FROM iijs_section_master where section='plain_gold' || section='mass_produced'";
	}
	else
	{
		$sql="SELECT * FROM iijs_section_master where 1";
	}	
	$query=mysql_query($sql);
	while($result=mysql_fetch_array($query))
	{
		if($result['section']==$section)
			$option1.="<option value=".$section." selected='selected'>".$result['section_desc']."</option>";
		else
			$option1.="<option value=".$result['section'].">".$result['section_desc']."</option>";
	}
	echo $option1;
	echo "#";
	
	echo "<option selected='selected' value=''>-----Select Area----</option>";
	if(($option=="Less area as previous year" || $option=="Less area as previous year at diffrent location") && $section=="allied")
	{
		$option="";
		foreach($area as $key=>$value)
		{
			if($value <= $lastYearArea)
			{
				$option.="<option value=".$value.">".$value."</option>";
			}
		}
		
		echo $option;
		return;
		
	}
	else if($option=="Less area as previous year" || $option=="Less area as previous year at diffrent location")
	{
		$sql="select * from iijs_area_master where area in ('9','18','27','36','45','54') and area<=$lastYearArea";
	}
	else if($option=="More area than previous year IIJS" && ($section=="plain_gold" || $section=="allied") && $lastYearArea=="9")
	{
		$sql="select * from iijs_area_master where area in (12,18,27,36)";
	}
	else if($option=="More area than previous year IIJS" && ($section=="plain_gold" || $section=="allied") && $lastYearArea=="12")
	{
		$sql="select * from iijs_area_master where area in (18,27,36)";
	}
	else if($option=="More area than previous year IIJS" && $lastYearArea=="9")
	{
		$sql="select * from iijs_area_master where area in (18,27,36)";
	}
	else if($option=="More area than previous year IIJS" && $lastYearArea=="18")
	{
		$sql="select * from iijs_area_master where area in (27,36)";
	}
	else if($option=="More area than previous year IIJS" && $lastYearArea=="27")
	{
		$sql="select * from iijs_area_master where area in (36)";
	}
	else if($option=="More area than previous year IIJS" && $lastYearArea=="36")
	{
		$sql="select * from iijs_area_master where area in (54)";
	}
	else if($option=="More area than previous year IIJS" && $lastYearArea=="54")
	{
		$sql="select * from iijs_area_master where area in (54)";
	}
	else
	{
		$sql="select * from iijs_area_master where area=$lastYearArea";
	}
	$query=mysql_query($sql);
	$num=mysql_num_rows($query);
	if($num>0){
	while($result=mysql_fetch_array($query)){
	?>
	<option value="<?php echo $result['area'];?>" <?php if($result['area']==$lastYearArea){?> selected="selected" <?php }?>><?php echo $result['area'];?></option>
<?php }}}?>
