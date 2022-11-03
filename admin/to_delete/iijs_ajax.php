<?php session_start();
include ("../db.inc.php");
include('../functions.php');
?>


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
$country=$_POST['country'];
if(strtoupper($country)=="INDIA" || strtoupper($country)=="IND")
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
		$selected_scheme_type="0";
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
		$selected_scheme_type="0";
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

if(strtoupper($country)=="INDIA" || strtoupper($country)=="IND")
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

if($section=='machinery')
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

	if($selected_scheme_type=="19000")
	{
		$mcb_exact_charges=($selected_area/9)*1000;
		$mcb_service_charges=($mcb_exact_charges*15)/100;
		echo $mcb_charges=round($mcb_exact_charges+$mcb_service_charges);
	}
	else if($selected_scheme_type=="550")
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

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="optionValue"){
$option=$_POST['option'];
$section=$_POST['section'];
$lastYearArea=$_POST['lastYearArea'];
	
	if($section=="signature_club" && $option=="More area than previous year IIJS")
	{
		$sql="select * from iijs_area_master where area in ('12','24','36','48') and area>=$lastYearArea";	
	}
	else if($section=="signature_club" && $option=="Less area as previous year")
	{
		$sql="select * from iijs_area_master where area in ('12','24','36','48') and area<=$lastYearArea";	
	}
	else if($option=="Less area as previous year" && $section!="signature_club")
	{
		$sql="select * from iijs_area_master where area in ('9','18','27','36','45','54') and area<=$lastYearArea";
	}
	else if($option=="More area than previous year IIJS" && $section!="signature_club")
	{
		$sql="select * from iijs_area_master where area in ('9','18','27','36','45','54') and area>=$lastYearArea";
	}
	
	$query=mysql_query($sql);
	$num=mysql_num_rows($query);
	if($num>0){
	while($result=mysql_fetch_array($query)){
	?>
	<option value="<?php echo $result['area'];?>" <?php if($result['area']==$lastYearArea){?> selected="selected" <?php }?>><?php echo $result['area'];?></option>
<?php }}}?>
