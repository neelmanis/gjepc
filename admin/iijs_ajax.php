<?php session_start();
include ("../db.inc.php");
include('../functions.php');
?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="calculatePayment"){
$member_type = $_SESSION['member_type'];
/*$membership_certificate_type = trim($_SESSION['membership_certificate_type']);
$msme_ssi_status = trim($_SESSION['msme_ssi_status']);
*/
$section=$_POST['section'];
$selected_area=$_POST['selected_area'];
$selected_scheme_type=$_POST['selected_scheme_type'];
$category=$_POST['category'];
$selected_premium_type=$_POST['selected_premium_type'];
$last_yr_participant = trim($_POST['last_yr_participant']);
$woman_entrepreneurs=$_POST['woman_entrepreneurs'];
$country=$_POST['country'];

$discount = $_POST['discount'];
$incentive = $_POST['incentive'];

if(strtoupper($country)=="IN")
{
	if($section=='machinery')
		$selected_scheme_type="22000";
	else {
		if($selected_scheme_type=="RW")
		{
			$selected_scheme_type="22000";
		}
		else if($selected_scheme_type=="BI1")
		{
			$selected_scheme_type="22000";
		}
		else if($selected_scheme_type=="0")
		{
			$selected_scheme_type=0;
		}
	}
} else {
	if($section=='machinery')
		$selected_scheme_type="75";
	else
	{
		if($selected_scheme_type=="RW")
		{
			$selected_scheme_type="500";
		}
		else if($selected_scheme_type=="BI1")
		{
			$selected_scheme_type="650";
		}
		else if($selected_scheme_type=="0")
		{
			$selected_scheme_type=0;
		}
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

if(strtoupper($country)=="IN")
{
	if($section=='machinery' || $section=='allied')
	{
		if($member_type=='MEMBER')
			$charge=14500;				
		elseif($member_type=='NON_MEMBER')
			$charge=15000;				
	} else
	{
	   $charge=22000;	
	}	
} else {
	if($section=='machinery')
	{
		$charge=300;			
	} else
	{
		$charge=350;
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

/*
if(strtoupper($last_yr_participant)=="YES")
{
if($membership_certificate_type!=''){
	if($membership_certificate_type=='ZASSOC')
	{
		$space_rate_discount=($space_rate*0.05);
	}
	if($membership_certificate_type=='ZASSOC' && $_SESSION['msme_ssi_status']=="Yes")
	{
		$space_rate_discount=($space_rate*0.10);
	}
	if($membership_certificate_type=='ZORDIN')
	{
		$space_rate_discount=($space_rate*0.15);
	}
}
}

echo $tot_space_cost_discount=intval($space_rate_discount)."#";
*/
/*
if($incentive!=''){
	$incentivePer = floatval($incentive);
	$incentiveData = $space_rate1-$incentivePer*$selected_area; 
	echo $incentiveRate = intval($incentiveData)."#";
} else { echo $incentiveRate = '0'."#"; }

if($discount!=''){
	echo $discountRate = intval($discount)."#"; 
} else { echo $discountRate = '0'."#"; }


$get_tot_space_cost = $incentiveRate-$discountRate;  // Get the total difference of Space cost Rate - Discount space cost rate

if($incentiveRate==0 && $discountRate==0) {
	echo $get_tot_space_cost_rate = intval($space_rate1)."#"; 
	} else { 
	echo $get_tot_space_cost_rate = intval($get_tot_space_cost)."#"; // Hide for discount rate }
}

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

$sub_total_cost=floatval($get_tot_space_cost_rate+$mezzanine_space_charge+$scheme_rate+$premium_rate);
echo $sub_total_cost1=($get_tot_space_cost_rate+$mezzanine_space_charge+$scheme_rate+$premium_rate)."#";
*/
$sub_total_cost = floatval($space_rate);
echo $sub_total_cost1 = $sub_total_cost."#";

$security_deposit = round(floatval($sub_total_cost*10)/100);
echo $security_deposit1=$security_deposit."#";

$govt_service_tax = round(floatval($sub_total_cost*18)/100);
echo $govt_service_tax1=$govt_service_tax."#";

$grand_total=round($sub_total_cost+$security_deposit+$govt_service_tax);
echo $grand_total1=$grand_total."#";

	if($selected_scheme_type=="22000")
	{
		$mcb_exact_charges=($selected_area/9)*1000;
		$mcb_service_charges=($mcb_exact_charges*18)/100;
		echo $mcb_charges=round($mcb_exact_charges+$mcb_service_charges);
	} else if($selected_scheme_type=="500")
	{
		$mcb_exact_charges=($selected_area/9)*16;
		$mcb_service_charges=($mcb_exact_charges*18)/100;
		echo $mcb_charges=round($mcb_exact_charges+$mcb_service_charges);
	} else
	{
		echo $mcb_charges=0;
	}
}
?>

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
	$query = $conn->query($sql);
	$num = $query->num_rows;
	if($num>0){
	while($result =$query->fetch_assoc()){
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
	
	$query = $conn->query($sql);
	$num = $query->num_rows;
	if($num>0){
	while($result =$query->fetch_assoc()){
	?>
	<option value="<?php echo $result['area'];?>" <?php if($result['area']==$lastYearArea){?> selected="selected" <?php }?>><?php echo $result['area'];?></option>
<?php }}}?>
