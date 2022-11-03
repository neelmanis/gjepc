<?php

include 'include-new/header.php';
$_SESSION['login_for']="DGFT";

if(!isset($_SESSION['USERID'])){ header('location:login.php'); exit; }
include 'db.inc.php';
include 'functions.php';
$application_id = base64_decode($_REQUEST['application_id']);

$registration_id = intval(filter($_SESSION['USERID']));
// current challan yr calculation
    $cur_year = (int)date('y');
	 $curyear  = (int)date('Y');
    $cur_month = (int)date('m');
    if ($cur_month < 4) {
     $cur_fin_yr = $curyear-1;
	 $cur_fin_yr1= $cur_year-1;
	 $cur_finyr  = $cur_fin_yr1 . '-' . ($cur_fin_yr1+1);
	 $last_finyr= ($cur_fin_yr1-1) . '-' . $cur_fin_yr1;
    }  else {
     $cur_fin_yr = $curyear;
 	 $cur_fin_yr1= $cur_year;
	 $cur_finyr  = $cur_fin_yr1 . '-' . ($cur_fin_yr1+1);
	 $last_finyr = ($cur_fin_yr1-1) . '-' . $cur_fin_yr1;
    }

 ?>
<?php
$action=$_REQUEST['action'];
if($action=="save")
{
	//validate Token
	//if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']){

$company_name	=	strtoupper(filter($_REQUEST['company_name']));
$member_type_id =   filter($_REQUEST['member_type_id']);
$type_of_firm	=	filter($_REQUEST['type_of_firm']);
$cin_no	= str_replace(' ','',$_REQUEST['cin_no']);
$pan_no	= str_replace(' ','',strtoupper(filter($_REQUEST['pan_no'])));
$tan_no	= str_replace(' ','',$_REQUEST['tan_no']);
$iec_no	= str_replace(' ','',$_REQUEST['iec_no']);
$iec_issue_date=date('d-m-Y',strtotime($_REQUEST['iec_issue_date']));

$dgft_ra_office = filter($_REQUEST['dgft_ra_office']);
$annual_turnover = filter($_REQUEST['annual_turnover']);
$financial_year1_export = filter($_REQUEST['financial_year1_export']);
$financial_year2_export = filter($_REQUEST['financial_year2_export']);
$financial_year3_export = filter($_REQUEST['financial_year3_export']);
$export_sub_total = filter($_REQUEST['export_sub_total']);
$deemed_export_total = filter($_REQUEST['deemed_export_total']);
$exports_total = filter($_REQUEST['exports_total']);
$exports_of_service = filter($_REQUEST['exports_of_service']);
$all_total_exports = filter($_REQUEST['all_total_exports']);

$status_holder=$_REQUEST['status_holder'];
$status_holder_eh=$_REQUEST['status_holder_eh'];
$im_registration_no	 =	filter($_REQUEST['im_registration_no']);
$im_pin_code		 =	filter($_REQUEST['im_pin_code']);
$issuing_industrial_liecence=$_REQUEST['issuing_industrial_liecence'];
$authority=$_REQUEST['authority'];
$eh_th_certification_no=$_REQUEST['eh_th_certification_no'];
$eh_th_issue_date=$_REQUEST['eh_th_issue_date'];
$eh_th_valid_date=$_REQUEST['eh_th_valid_date'];


$rcmc_no=filter($_REQUEST['rcmc_no']);
$rcmc_issue_date=date('Y-m-d',strtotime($_REQUEST['rcmc_issue_date']));
$rcmc_issue_authority=filter($_REQUEST['rcmc_issue_authority']);
$rcmc_product_of_which=filter($_REQUEST['rcmc_product_of_which']);
$rcmc_expiry=date('Y-m-d',strtotime($_REQUEST['rcmc_expiry'])); 
$rcmc_status=filter($_REQUEST['rcmc_status']);
$rcmc_validity= date('Y-m-d',strtotime($_REQUEST['rcmc_validity']));  
$status_from_epc=filter($_REQUEST['status_from_epc']);



$ssi_registration_no =  filter($_REQUEST['ssi_registration_no']);
$ssi_issue_date	     =	filter($_REQUEST['ssi_issue_date']);
$ssi_pin_code		 =	filter($_REQUEST['ssi_pin_code']);

$export_sales_to_foreign_tourists=$_REQUEST['export_sales_to_foreign_tourists'];
$export_synthetic_stones=$_REQUEST['export_synthetic_stones'];
$export_other_items=$_REQUEST['export_other_items'];
$export_costume_jewellery=$_REQUEST['export_costume_jewellery'];
$export_other_precious_metal_jewellery=$_REQUEST['export_other_precious_metal_jewellery'];
$export_pearls=$_REQUEST['export_pearls'];
$export_coloured_gemstones=$_REQUEST['export_coloured_gemstones'];
$export_gold_jewellery=$_REQUEST['export_gold_jewellery'];
$export_studded_gold_jewellery=$_REQUEST['export_studded_gold_jewellery'];
$export_silver_jewellery=$_REQUEST['export_silver_jewellery'];
$export_studded_silver_jewellery=$_REQUEST['export_studded_silver_jewellery'];
$export_rough_diamonds=$_REQUEST['export_rough_diamonds'];
$export_cut_polished_diamonds=$_REQUEST['export_cut_polished_diamonds'];
$export_rough_lgd=$_REQUEST['export_rough_lgd'];
$export_cut_polished_lgd=$_REQUEST['export_cut_polished_lgd'];
$export_total=$_REQUEST['export_total'];
$import_findings_mountings=$_REQUEST['import_findings_mountings'];
$import_false_pearls=$_REQUEST['import_false_pearls'];
$import_rough_imitation_stones=$_REQUEST['import_rough_imitation_stones'];
$import_silver=$_REQUEST['import_silver'];
$import_raw_pearls=$_REQUEST['import_raw_pearls'];
$import_cut_polished_gemstones=$_REQUEST['import_cut_polished_gemstones'];
$import_rough_gemstones=$_REQUEST['import_rough_gemstones'];
$import_gold=$_REQUEST['import_gold'];
$import_cut_polished_diamonds=$_REQUEST['import_cut_polished_diamonds'];
$import_rough_diamonds=$_REQUEST['import_rough_diamonds'];
$import_synthetic_stones=$_REQUEST['import_synthetic_stones'];
$import_gold_jewellery=$_REQUEST['import_gold_jewellery'];
$import_silver_jewellery=$_REQUEST['import_silver_jewellery'];
$import_rough_lgd=$_REQUEST['import_rough_lgd'];
$import_cut_polished_lgd=$_REQUEST['import_cut_polished_lgd'];
$import_other_items=$_REQUEST['import_other_items'];
$import_total=$_REQUEST['import_total'];
$export_fob_value=$_REQUEST['export_fob_value'];
$import_cif_value=$_REQUEST['import_cif_value'];


// $year_of_starting_bussiness=filter($_REQUEST['year_of_starting_bussiness']);
// $name	=	filter($_REQUEST['name']);
// $designation	=	$_REQUEST['designation'];
// $email_id		=	filter($_REQUEST['email_id']);
// $address1		=	filter($_REQUEST['address1']);
// $address2		=	filter($_REQUEST['address2']);
// $address3		=	filter($_REQUEST['address3']);
// $pin_code		=	filter($_REQUEST['pin_code']);
// $city			=	filter($_REQUEST['city']);
// $country		=	filter($_REQUEST['country']);
// $land_line_no	=	filter($_REQUEST['land_line_no']);
// $mobile_no		=	filter($_REQUEST['mobile_no']);
// $joining_date	=	filter($_REQUEST['joining_date']);
// $retirement_date=	filter($_REQUEST['retirement_date']);
// $post_date=date('Y-m-d');
// $ip_address=$_SERVER['REMOTE_ADDR'];


// $msme_ssi_regis_no=$_REQUEST['msme_ssi_regis_no'];
// $uin=filter($_REQUEST['uin']);
// $uin_issue_date=$_REQUEST['uin_issue_date'];
// $vat_tin=$_REQUEST['vat_tin'];
// $co_profile	=	filter($_REQUEST['co_profile']);
// $sight_holder=$_REQUEST['sight_holder'];
// $sez_member=$_REQUEST['sez_member'];
// $epc_fieo_status=$_REQUEST['epc_fieo_status'];
// $org_name	=	filter($_REQUEST['org_name']);

$financial_year1 = "2019";
$financial_year2 = "2020";
$financial_year3 = "2021";

$query_firm = $conn ->query("select * from communication_address_master where registration_id='".$_SESSION['USERID']."' and type_of_address='2'");


/* Validation Start */
	if(empty($company_name)){
	$signup_error = array("label"=>"company_name","message"=>"Please Enter Company Name");
	} else if(empty($member_type_id)){
	$signup_error = array("label"=>"member_type_id","message"=>"Please Select Member Type");
	} else if(empty($type_of_firm)){
	$signup_error = array("label"=>"type_of_firm","message"=>"Please Select Firm Type");
	} else if(empty($pan_no)){
	$signup_error = array("label"=>"pan_no","message"=>"Please Enter Pan No");

	}else if(empty($iec_no)){
	$signup_error = array("label"=>"iec_no","message"=>"Please Enter IEC No");

	} else if(strlen($iec_no)>10 || strlen($iec_no)<10){
	$signup_error = array("label"=>"iec_no","message"=>"IEC Number should be 10 digits.");
	}else if($member_type_id==6 && $msme_ssi_status=="Yes" && (empty($ssi_registration_no) && empty($ssi_pin_code) && empty($im_registration_no))){
			$signup_error = array("label"=>"ssi","message"=>"SSI Registration No or SSI Pin Code or IM Registration No is compulsory");
	}elseif(empty($tan_no)){
	$signup_error = array("label"=>"tan_no","message"=>"Please Enter Tan no.");
	}elseif(empty($iec_issue_date)){
	$signup_error = array("label"=>"iec_issue_date","message"=>"IEC Issue Date is required");
	}elseif(empty($dgft_ra_office)){
	$signup_error = array("label"=>"dgft_ra_office","message"=>"DGFT Office is required");
	}elseif(empty($annual_turnover)){
	$signup_error = array("label"=>"annual_turnover","message"=>"Annual turnover is required");
	}elseif(empty($financial_year1_export)){
	$signup_error = array("label"=>"financial_year1_export","message"=>"Enter export amount");
	}elseif(empty($financial_year2_export)){
	$signup_error = array("label"=>"financial_year2_export","message"=>"Enter export amount");
	}elseif(empty($financial_year3_export)){
	$signup_error = array("label"=>"financial_year3_export","message"=>"Enter export amount");
	}elseif(empty($export_sub_total)){
	$signup_error = array("label"=>"export_sub_total","message"=>"This field is required");
	}elseif(empty($deemed_export_total)){
	$signup_error = array("label"=>"deemed_export_total","message"=>"This field is required");
	}elseif(empty($exports_total)){
	$signup_error = array("label"=>"exports_total","message"=>"This field is required");
	}elseif(empty($exports_of_service)){
	$signup_error = array("label"=>"exports_of_service","message"=>"This field is required");
	}elseif(empty($all_total_exports)){
	$signup_error = array("label"=>"all_total_exports","message"=>"This field is required");
	}elseif(empty($status_holder)){
	$signup_error = array("label"=>"status_holder","message"=>"Please Select status holder");
	}elseif(empty($status_holder_eh)){
	$signup_error = array("label"=>"status_holder_eh","message"=>"Please Select category");
	}elseif(empty($eh_th_certification_no)){
	$signup_error = array("label"=>"eh_th_certification_no","message"=>"Please Select certificate");
	}elseif(empty($eh_th_valid_date)){
	$signup_error = array("label"=>"eh_th_valid_date","message"=>"Date is required");
	}elseif(empty($im_registration_no)){
	$signup_error = array("label"=>"im_registration_no","message"=>"Registration Number is required");
	}elseif(empty($im_pin_code)){
	$signup_error = array("label"=>"im_pin_code","message"=>"IM Pincode is required");
	}elseif(empty($issuing_industrial_liecence)){
	$signup_error = array("label"=>"issuing_industrial_liecence","message"=>"Industrial Licences is required");
	}elseif(empty($authority)){
	$signup_error = array("label"=>"authority","message"=>"Authority is required");
	}elseif(empty($eh_th_issue_date)){
	$signup_error = array("label"=>"eh_th_issue_date","message"=>"Issue date is required");
	}elseif($query_firm->num_rows ==0){
	$signup_error = array("label"=>"firm_error","message"=>"Please add firm details and proceed");
	}elseif(empty($rcmc_no)){
	$signup_error = array("label"=>"rcmc_no","message"=>"Please Enter RCMC No.");
	}elseif(empty($rcmc_issue_date)){
	$signup_error = array("label"=>"rcmc_issue_date","message"=>"Please Enter RCMC Issue Date.");
	}elseif(empty($rcmc_issue_authority)){
	$signup_error = array("label"=>"rcmc_issue_authority","message"=>"Please Enter RCMC Issue Authority");
	}elseif(empty($rcmc_product_of_which)){
	$signup_error = array("label"=>"rcmc_product_of_which","message"=>"Please Enter RCMC Product of which");
	}elseif(empty($rcmc_expiry)){
	$signup_error = array("label"=>"rcmc_expiry","message"=>"Please Enter RCMC Expiry");
	}elseif(empty($rcmc_status)){
	$signup_error = array("label"=>"rcmc_status","message"=>"Please Enter RCMC Status");
	}elseif(empty($rcmc_validity)){
	$signup_error = array("label"=>"rcmc_validity","message"=>"Please Enter RCMC Validity");
	}elseif(empty($status_from_epc)){
	$signup_error = array("label"=>"status_from_epc","message"=>"Please Enter RCMC status");
	}else {

$query=$conn->query("select * from membership_dgft where registration_id='$registration_id' and financial_year='$cur_fin_yr'");
$num = $query->num_rows;


$created_date = date('Y-m-d H:i:s');		
if($num>0)
{
	   $sql1="update membership_dgft set pan_no='$pan_no',dgft_ra_office='$dgft_ra_office',annual_turnover='$annual_turnover',financial_year1='$financial_year1',financial_year2='$financial_year2',financial_year3='$financial_year3',financial_year1_export='$financial_year1_export',financial_year2_export='$financial_year2_export',financial_year3_export='$financial_year3_export',export_sub_total='$export_sub_total',deemed_export_total='$deemed_export_total',exports_total='$exports_total',exports_of_service='$exports_of_service',all_total_exports='$all_total_exports',rcmc_no='$rcmc_no',rcmc_issue_date='$rcmc_issue_date',rcmc_issue_authority='$rcmc_issue_authority',rcmc_product_of_which='$rcmc_product_of_which',rcmc_expiry='$rcmc_expiry',rcmc_status='$rcmc_status',rcmc_validity='$rcmc_validity',status_from_epc='$status_from_epc',export_sales_to_foreign_tourists='$export_sales_to_foreign_tourists',export_synthetic_stones='$export_synthetic_stones',export_costume_jewellery='$export_costume_jewellery',export_other_precious_metal_jewellery='$export_other_precious_metal_jewellery',export_pearls='$export_pearls',export_coloured_gemstones='$export_coloured_gemstones',export_gold_jewellery='$export_gold_jewellery',export_studded_gold_jewellery='$export_studded_gold_jewellery',export_silver_jewellery='$export_silver_jewellery',export_studded_silver_jewellery='$export_studded_silver_jewellery',export_rough_diamonds='$export_rough_diamonds',export_cut_polished_diamonds='$export_cut_polished_diamonds',export_rough_lgd='$export_rough_lgd',export_cut_polished_lgd='$export_cut_polished_lgd',export_other_items='$export_other_items',export_total='$export_total',import_findings_mountings='$import_findings_mountings',import_false_pearls='$import_false_pearls',import_rough_imitation_stones='$import_rough_imitation_stones',import_silver='$import_silver',import_raw_pearls='$import_raw_pearls',import_cut_polished_gemstones='$import_cut_polished_gemstones',import_rough_gemstones='$import_rough_gemstones',import_gold='$import_gold',import_cut_polished_diamonds='$import_cut_polished_diamonds',import_rough_diamonds='$import_rough_diamonds',import_synthetic_stones='$import_synthetic_stones',import_gold_jewellery='$import_gold_jewellery',import_silver_jewellery='$import_silver_jewellery',import_rough_lgd='$import_rough_lgd',import_cut_polished_lgd='$import_cut_polished_lgd',import_other_items='$import_other_items',import_total='$import_total',export_fob_value='$export_fob_value',import_cif_value='$import_cif_value',created_date='$created_date',isDraft='1',status='P' where  registration_id='$registration_id' and financial_year='$cur_fin_yr'" ;
$saveResult = $conn ->query($sql1);

if(!$saveResult) die ($conn->error);
$_SESSION['succ_msg']="Information captured successfully. Please confirm and submit.";
header('location:dgft-form-summary.php?id='.base64_encode($application_id)); exit;

} else {
   $sql1="insert into membership_dgft set registration_id='$registration_id',financial_year='$cur_fin_yr',pan_no='$pan_no',dgft_ra_office='$dgft_ra_office',annual_turnover='$annual_turnover',financial_year1='$financial_year1',financial_year2='$financial_year2',financial_year3='$financial_year3',financial_year1_export='$financial_year1_export',financial_year2_export='$financial_year2_export',financial_year3_export='$financial_year3_export',export_sub_total='$export_sub_total',deemed_export_total='$deemed_export_total',exports_total='$exports_total',exports_of_service='$exports_of_service',all_total_exports='$all_total_exports',rcmc_no='$rcmc_no',rcmc_issue_date='$rcmc_issue_date',rcmc_issue_authority='$rcmc_issue_authority',rcmc_product_of_which='$rcmc_product_of_which',rcmc_expiry='$rcmc_expiry',rcmc_status='$rcmc_status',rcmc_validity='$rcmc_validity',status_from_epc='$status_from_epc',export_sales_to_foreign_tourists='$export_sales_to_foreign_tourists',export_synthetic_stones='$export_synthetic_stones',export_costume_jewellery='$export_costume_jewellery',export_other_precious_metal_jewellery='$export_other_precious_metal_jewellery',export_pearls='$export_pearls',export_coloured_gemstones='$export_coloured_gemstones',export_gold_jewellery='$export_gold_jewellery',export_studded_gold_jewellery='$export_studded_gold_jewellery',export_silver_jewellery='$export_silver_jewellery',export_studded_silver_jewellery='$export_studded_silver_jewellery',export_rough_diamonds='$export_rough_diamonds',export_cut_polished_diamonds='$export_cut_polished_diamonds',export_rough_lgd='$export_rough_lgd',export_cut_polished_lgd='$export_cut_polished_lgd',export_other_items='$export_other_items',export_total='$export_total',import_findings_mountings='$import_findings_mountings',import_false_pearls='$import_false_pearls',import_rough_imitation_stones='$import_rough_imitation_stones',import_silver='$import_silver',import_raw_pearls='$import_raw_pearls',import_cut_polished_gemstones='$import_cut_polished_gemstones',import_rough_gemstones='$import_rough_gemstones',import_gold='$import_gold',import_cut_polished_diamonds='$import_cut_polished_diamonds',import_rough_diamonds='$import_rough_diamonds',import_synthetic_stones='$import_synthetic_stones',import_gold_jewellery='$import_gold_jewellery',import_silver_jewellery='$import_silver_jewellery',import_rough_lgd='$import_rough_lgd',import_cut_polished_lgd='$import_cut_polished_lgd',import_other_items='$import_other_items',import_total='$import_total',export_fob_value='$export_fob_value',import_cif_value='$import_cif_value',created_date='$created_date',isDraft='1',status='P'" ;
$saveResult = $conn ->query($sql1);
$insert_id = $conn->insert_id;
if(!$saveResult) die ($conn->error);
$_SESSION['succ_msg']="Information captured successfully. Please confirm and submit.";
header('location:dgft-form-summary.php?id='.base64_encode($insert_id)); exit;


}
	} 

	/* Validation End */
	// } else {
	//  $_SESSION['error_msg']="Invalid Token Error";
	// }
}

$sqlm = "SELECT * FROM `information_master` WHERE 1 and registration_id=$registration_id";
$ssx = $conn ->query($sqlm);
$rows = $ssx->fetch_assoc();

if($rows['company_name']=="")
{
	$sql="SELECT * FROM `registration_master` WHERE 1 and id='$registration_id'";
	$result = $conn ->query($sql);
	$rows1 = $result->fetch_assoc();
	
	$company_name	= strtoupper(filter($rows1['company_name']));
	$country	=	$rows1['country'];
	$land_line_no=$rows1['land_line_no'];
	$city= filter($rows1['city']);
	$mobile_no= filter($rows1['mobile_no']);
} else {
$company_name = strtoupper(filter($rows['company_name']));
$member_type_id = filter($rows['member_type_id']);
$type_of_firm = filter($rows['type_of_firm']);
$cin_no = filter($rows['cin_no']);

$pan_no = filter($rows['pan_no']);
$tan_no = filter($rows['tan_no']);
$iec_no = filter($rows['iec_no']);
$iec_issue_date=$rows['iec_issue_date'];
$im_registration_no=filter($rows['im_registration_no']);
$im_pin_code=filter($rows['im_pin_code']);
$ssi_registration_no=$rows['ssi_registration_no'];
$ssi_issue_date=$rows['ssi_issue_date'];
$ssi_pin_code=filter($rows['ssi_pin_code']);
$issuing_industrial_liecence=$rows['issuing_industrial_liecence'];
$authority=filter($rows['authority']);
$eh_th_certification_no=$rows['eh_th_certification_no'];
$eh_th_issue_date=$rows['eh_th_issue_date'];
$eh_th_valid_date=$rows['eh_th_valid_date'];
$region_id=strtoupper(filter($rows['region_id']));
$year_of_starting_bussiness=filter($rows['year_of_starting_bussiness']);
$name=strtoupper(filter($rows['name']));
$designation=$rows['designation'];
$email_id=filter($rows['email_id']);
$aadhar_no=$rows['aadhar_no'];
$passport_no=$rows['passport_no'];
$address1=strtoupper(filter($rows['address1']));
$address2=strtoupper(filter($rows['address2']));
$address3=strtoupper(filter($rows['address3']));
$pin_code=filter($rows['pin_code']);
$city=strtoupper(filter($rows['city']));
$country=$rows['country'];
$land_line_no=$rows['land_line_no'];
$mobile_no=$rows['mobile_no'];
$joining_date=$rows['joining_date'];
$retirement_date=$rows['retirement_date'];
$admin_aprove=$rows['admin_aprove'];
$status=$rows['status'];
$status_holder=$rows['status_holder'];
$status_holder_eh=$rows['status_holder_eh'];
$msme_ssi_status=$rows['msme_ssi_status'];
$vat_tin=$rows['vat_tin_reg_no'];
$uin=$rows['uin'];
$uin_issue_date=$rows['uin_issue_date'];
$co_profile=filter($rows['co_profile']);
$sight_holder=$rows['sight_holder'];
$sez_member=$rows['sez_member'];
$epc_fieo_status=$rows['epc_fieo_status'];
$org_name=strtoupper(filter($rows['org_name']));
}



if(!empty($application_id) && $application_id !=="" ){
 $sqld = "SELECT * FROM `membership_dgft` WHERE 1 and registration_id=$registration_id and id=$application_id";
$queryd = $conn ->query($sqld);
$rowsd = $queryd->fetch_assoc();
$financial_year = filter($rowsd['financial_year']);
$dgft_ra_office = filter($rowsd['dgft_ra_office']);
$annual_turnover = filter($rowsd['annual_turnover']);
$financial_year1 = filter($rowsd['financial_year1']);
$financial_year2 = filter($rowsd['financial_year2']);
$financial_year3 = filter($rowsd['financial_year3']);
$financial_year1_export = filter($rowsd['financial_year1_export']);
$financial_year2_export = filter($rowsd['financial_year2_export']);
$financial_year3_export = filter($rowsd['financial_year3_export']);
$export_sub_total = filter($rowsd['export_sub_total']);
$deemed_export_total = filter($rowsd['deemed_export_total']);
$exports_total = filter($rowsd['exports_total']);
$exports_of_service = filter($rowsd['exports_of_service']);
$all_total_exports = filter($rowsd['all_total_exports']);
$rcmc_no = filter($rowsd['rcmc_no']);
$rcmc_issue_date = filter($rowsd['rcmc_issue_date']);
$rcmc_issue_authority = filter($rowsd['rcmc_issue_authority']);
$rcmc_product_of_which = filter($rowsd['rcmc_product_of_which']);
$rcmc_expiry = filter($rowsd['rcmc_expiry']);
$rcmc_status = filter($rowsd['rcmc_status']);
$rcmc_validity = filter($rowsd['rcmc_validity']);
$status_from_epc = filter($rowsd['status_from_epc']);
$export_sales_to_foreign_tourists = filter($rowsd['export_sales_to_foreign_tourists']);
$export_synthetic_stones = filter($rowsd['export_synthetic_stones']);
$export_costume_jewellery = filter($rowsd['export_costume_jewellery']);
$import_cif_value = filter($rowsd['import_cif_value']);
$export_other_precious_metal_jewellery = filter($rowsd['export_other_precious_metal_jewellery']);
$export_pearls = filter($rowsd['export_pearls']);
$export_coloured_gemstones = filter($rowsd['export_coloured_gemstones']);
$export_gold_jewellery = filter($rowsd['export_gold_jewellery']);
$export_studded_gold_jewellery = filter($rowsd['export_studded_gold_jewellery']);
$export_silver_jewellery = filter($rowsd['export_silver_jewellery']);
$export_studded_silver_jewellery = filter($rowsd['export_studded_silver_jewellery']);
$export_rough_diamonds = filter($rowsd['export_rough_diamonds']);
$export_cut_polished_diamonds = filter($rowsd['export_cut_polished_diamonds']);
$export_rough_lgd = filter($rowsd['export_rough_lgd']);
$export_cut_polished_lgd = filter($rowsd['export_cut_polished_lgd']);
$export_other_items = filter($rowsd['export_other_items']);
$export_total = filter($rowsd['export_total']);
$import_findings_mountings = filter($rowsd['import_findings_mountings']);
$import_false_pearls = filter($rowsd['import_false_pearls']);
$import_rough_imitation_stones = filter($rowsd['import_rough_imitation_stones']);
$import_silver = filter($rowsd['import_silver']);
$import_raw_pearls = filter($rowsd['import_raw_pearls']);
$import_cut_polished_gemstones = filter($rowsd['import_cut_polished_gemstones']);
$import_rough_gemstones = filter($rowsd['import_rough_gemstones']);
$import_gold = filter($rowsd['import_gold']);
$import_cut_polished_diamonds = filter($rowsd['import_cut_polished_diamonds']);
$import_rough_diamonds = filter($rowsd['import_rough_diamonds']);
$import_synthetic_stones = filter($rowsd['import_synthetic_stones']);
$import_gold_jewellery = filter($rowsd['import_gold_jewellery']);
$import_silver_jewellery = filter($rowsd['import_silver_jewellery']);
$import_rough_lgd = filter($rowsd['import_rough_lgd']);
$import_cut_polished_lgd = filter($rowsd['import_cut_polished_lgd']);
$import_other_items = filter($rowsd['import_other_items']);
$import_total = filter($rowsd['import_total']);
$export_fob_value = filter($rowsd['export_fob_value']);

}

?>
<?php 

?>

<section class="py-5">
	<div class="container inner_container">
    	
        <h1 class="bold_font text-center mb-5"><img src="assets/images/gold_star.png" class="title_star d-block mx-auto"> Membership DGFT Form</h1>
       
		<div class="row">        	
           
            
            <div class="col-lg-auto order-lg-12 col-md-12 " data-sticky_parent>
				<?php include 'include/regMenu.php'; ?>
			</div>
    
    		<div class="col-lg col-md-12 ">
						
				<?php 
                if($_SESSION['succ_msg']!=""){
                echo "<div class='alert alert-success' role='alert'>".$_SESSION['succ_msg']."</div>";
                $_SESSION['succ_msg']="";
                }
                
                ?>

			 
				
			<?php

		 $allRecords = $conn->query("SELECT * FROM membership_dgft WHERE registration_id='$registration_id' order by updated_date desc "); 

		if($allRecords->num_rows > 0 ){ ?>
		<table class="responsive_table portal_table">
			<thead>
				<tr>
					<th class="text-lg-center">No.</th>
					<th class="text-lg-center">Date</th>
					<th class="text-lg-center">DGFT RA Office</th>
					
					<!-- <th class="text-lg-center">Financial Year</th> -->
		
			
					<th class="text-lg-center">Action</th>
				</tr>
			</thead>
			<tbody id="CommunicationDetails">
			<?php			
			$i=1;
			while($ans = $allRecords->fetch_assoc()){ ?>
					<tr>
					<td class="text-lg-center" data-column="No."><?php echo $i;?></td>
					<td class="text-lg-center" data-column="Date"><?php echo date("d-m-Y",strtotime($ans['created_date']));?></td>
					<td class="text-lg-center" data-column="Financial Year"><?php echo $ans['dgft_ra_office'];?></td>
					

		
					
				
					<?php if($ans['isDraft']=="1" ){ ?>
					<td class="text-lg-center" data-column="Status"><a href="dgft-form.php?application_id=<?php echo base64_encode($ans['id']); ?>" ><span style="text-decoration: underline;">Edit</span> &nbsp;&nbsp; <i>(Draft)</i></a></td>
					<?php } else { ?>
					<td class="text-lg-center"><a href="dgft-form-summary.php?id=<?php echo base64_encode($ans['id']); ?>" ><i data-id='<?php echo $ans["id"]?>' class="userinfo fa fas fa-eye"></i></a></td>
					<?php } ?>
					<?php $i++; ?>				
				</tr>
			<?php }  ?>
			</tbody>
		</table>
           
		 <?php }
       //  echo $cur_fin_yr;
         $queryCheck = $conn->query("SELECT * FROM membership_dgft WHERE registration_id='$registration_id' and financial_year='$cur_fin_yr' "); 
         if($queryCheck->num_rows == 0 || !empty($application_id)  ){ ?>
         	<p class="gold_clr mb-4 pb-2" style="border-bottom:1px dashed #a89c5d;"><strong> Account Information </strong> </p>		
				<form class="cmxform row" method="POST" name="infoForm" id="infoForm">
					
					<?php // token(); ?>
					<div class="col-12 form-group">
						<a href="https://gjepc.org/information_form.php" class="cta " target="_blank">Click here to update Information</a>
					</div>
                    <div class="form-group col-sm-6">
					<label class="form-label" for="company_name">Company Name :</label>
					<input type="text" class="form-control" value="<?php echo $company_name;?>" name="company_name" id="company_name" placeholder="Company Name" autocomplete="off" maxlength="40" readonly/>
					<label  for="company_name" ><?php if(isset($signup_error['tan_no'])){ echo $signup_error['message'];  }?></label>
					</div>
                    
					<div class="form-group col-sm-6">
						<label class="form-label" for="member_type_id">Member Type :</label>
                        <select  class="form-control" name="member_type_id" id="member_type_id" readonly>
                                <option value="">--- Select Member Type ---</option>
                                  <?php
                                  $sql1="SELECT * FROM `member_type_master` WHERE 1 and `status`=1";
                                  $result1 = $conn->query($sql1);
                                  while($rows1 = $result1->fetch_assoc())
                                  {
                                  if($rows1['sap_value']==$member_type_id)
                                  {
                                  echo "<option selected='selected' value='$rows1[sap_value]'>$rows1[member_type_name]</option>";
                                  } else {
                                  echo "<option value='$rows1[sap_value]'>$rows1[member_type_name]</option>";
                                  }
                                  }
                                  ?>
                        </select>
                        <label  for="member_type_id" ><?php if($signup_error['label'] =="member_type_id"){ echo $signup_error['message'];  }?></label>
					</div>
					
                    <div class="form-group col-sm-6">
						<label class="form-label" for="type_of_firm">NATURE OF CONCERN / FIRM :</label>
                        <select class="form-control" name="type_of_firm" id="type_of_firm" readonly>
                                <option value="">--- Select Type of Firm ---</option>
                                      <?php
                                      $sql2="SELECT * FROM `type_of_firm_master` WHERE 1 and `status`=1";
                                      $result2 = $conn->query($sql2);
									  while($rows2 = $result2->fetch_assoc())
                                      {
                                      if($rows2['sap_value']==$type_of_firm)
                                      {
                                      echo "<option selected='selected' value='$rows2[sap_value]'>$rows2[type_of_firm_name]</option>";
                                      } else  {
                                      echo "<option value='$rows2[sap_value]'>$rows2[type_of_firm_name]</option>";
                                      }
                                      }
                                      ?>
                        </select>
                        <label  for="type_of_firm" ><?php if($signup_error['label'] =="type_of_firm"){ echo $signup_error['message'];  }?></label>
					</div>
                    <div class="form-group col-sm-6">
						<label class="form-label" for="iec_no">IEC No. (10 digit) :</label>
						<input type="text" class="form-control" value="<?php echo $iec_no;?>" name="iec_no" id="iec_no" placeholder="IEC No." maxlength="10" autocomplete="off" readonly>
						 <label  for="iec_no" ><?php if(isset($signup_error['iec_no'])){ echo $signup_error['message'];  }?></label>
					</div>
					<div class="form-group col-sm-6">
						<label class="form-label" for="pan_no">PAN No. :</label>
						<input type="text" class="form-control <?php if($signup_error['label'] =="pan_no"){ echo "is-invalid" ; } ?>" readonly  name="pan_no" id="pan_no" placeholder="Pan No." maxlength="10" autocomplete="off" value="<?php echo getCompanyPan($registration_id,$conn);?>">
					<label  for="pan_no" ><?php if($signup_error['label'] =="pan_no"){ echo $signup_error['message'];  }?></label>	
					</div>
					<div class="form-group col-sm-6" id="cinNoDisplay" <?php if($type_of_firm!=13 && $type_of_firm!=12){?> style="display:none;" <?php }?>>
						<label class="form-label" for="cin_no">CIN No. :</label>
						<input type="text" class="form-control <?php if($signup_error['label'] =="cin_no"){ echo "is-invalid" ; } ?>" value="<?php echo $cin_no;?>" name="cin_no" id="cin_no" placeholder="CIN No.">
						
						<label  for="cin_no" ><?php if($signup_error['label'] =="cin_no"){ echo $signup_error['message'];  }?></label>
					</div>
					
					<div class="form-group col-sm-6">
						<label class="form-label" for="tan_no">TAN No. :</label>
						<input type="text" class="form-control <?php if($signup_error['label'] =="tan_no"){ echo "is-invalid" ; } ?>" value="<?php echo $tan_no;?>" name="tan_no" id="tan_no" readonly placeholder="TAN No." maxlength="10" autocomplete="off">
						<label  for="tan_no" ><?php if($signup_error['label'] =="tan_no"){ echo $signup_error['message'];  }?></label>
					</div>
                    
					
					
                    <div class="form-group col-sm-6">
						<label class="form-label" for="iec_issue_date">IEC Issue Date</label>
						<input type="text" class="form-control <?php if($signup_error['label'] =="iec_issue_date"){ echo "is-invalid" ; } ?>" value="<?php echo $iec_issue_date;?>" name="iec_issue_date" id="iec_issue_date" placeholder="IEC Issue Date" autocomplete="off" readonly>
						<label  for="iec_issue_date" ><?php if($signup_error['label'] =="iec_issue_date"){ echo $signup_error['message'];  }?></label>
					</div>
					<div class="form-group col-sm-6"></div>
					<div class="form-group col-sm-6">
						<label class="form-label" >DGFT RA Office :</label>
						<input type="text" class="form-control <?php if($signup_error['label'] =="dgft_ra_office"){ echo "is-invalid" ; } ?>"  name="dgft_ra_office" id="dgft_ra_office" value="<?php echo $dgft_ra_office; ?>" >
						<label  for="dgft_ra_office" ><?php if($signup_error['label'] =="dgft_ra_office"){ echo $signup_error['message'];  }?></label>
					</div>
					<div class="form-group col-sm-6">
						<label class="form-label" for="annual_turnover">Annual Turnover Of The Firm (Last FY Year)</label>
						<input type="number" value="<?php echo $annual_turnover; ?>"  class="form-control <?php if($signup_error['label'] =="annual_turnover"){ echo "is-invalid" ; } ?>"  name="annual_turnover" id="annual_turnover" placeholder=""  autocomplete="off">
					<label  for="annual_turnover" ><?php if($signup_error['label'] =="annual_turnover"){ echo $signup_error['message'];  }?></label>
					</div>
					
					<div class="col-12">
							<p>Export Performance In Last 3 Years</p>
							<div class="row">
							
							<div class="form-group col-sm-4">
								<label class="form-label" >2018-19:</label>
								<input type="number" class="form-control <?php if($signup_error['label'] =="financial_year1_export"){ echo "is-invalid" ; } ?>" value="<?php echo $financial_year1_export; ?>"  name="financial_year1_export" id="financial_year1_export"  autocomplete="off">
								<label  for="financial_year1_export" ><?php if($signup_error['label'] =="financial_year1_export"){ echo $signup_error['message'];  }?></label>
							</div>
							<div class="form-group col-sm-4">
								<label class="form-label" for="financial_year2_export">2019-20:</label>
								<input type="number" class="form-control" value="<?php echo $financial_year2_export; ?>"  name="financial_year2_export" id="financial_year2_export"  <?php if($signup_error['label'] =="financial_year2_export"){ echo "is-invalid" ; } ?> autocomplete="off">
								<label class="" for="financial_year2_export" ><?php if($signup_error['label'] =="financial_year2_export"){ echo $signup_error['message'];  }?></label>
							</div>
							<div class="form-group col-sm-4">
								<label class="form-label" for="financial_year3_export">2020-21:</label>
								<input type="number" class="form-control  <?php if($signup_error['label'] =="financial_year3_export"){ echo "is-invalid" ; } ?>" value="<?php echo $financial_year3_export; ?>"  name="financial_year3_export" id="financial_year3_export" >
								<label  for="financial_year3_export" ><?php if($signup_error['label'] =="financial_year3_export"){ echo $signup_error['message'];  }?></label> 
							</div>
						</div>
					</div>
					<div class="form-group col-sm-6">
						<label class="form-label" for="export_sub_total">Sub-Total (Direct Exports + Third Party Exports )</label>
						<input type="text" class="form-control  <?php if($signup_error['label'] =="export_sub_total"){ echo "is-invalid" ; } ?>"  name="export_sub_total" value="<?php echo $export_sub_total; ?>"  id="export_sub_total" placeholder=""  autocomplete="off">
						<label  for="export_sub_total" ><?php if($signup_error['label'] =="export_sub_total"){ echo $signup_error['message'];  }?></label>

					</div>
					<div class="form-group col-sm-6">
						<label class="form-label" for="deemed_export_total">Total Deemed Exports (Supplies to EOU/EHTP/BTP/STPI + Other Deemed Exports + Supplies to SEZ)</label>
						<input type="number" class="form-control <?php if($signup_error['label'] =="deemed_export_total"){ echo "is-invalid" ; } ?>" value="<?php echo $deemed_export_total; ?>"  name="deemed_export_total" id="deemed_export_total" placeholder=""  autocomplete="off">
						<label  for="deemed_export_total" ><?php if($signup_error['label'] =="deemed_export_total"){ echo $signup_error['message'];  }?></label>
					</div>
					<div class="form-group col-sm-6">
						<label class="form-label" for="exports_total">Total Exports (Sub-Total + Total Deemed Exports)</label>
						<input type="number" class="form-control <?php if($signup_error['label'] =="exports_total"){ echo "is-invalid" ; } ?>" value="<?php echo $exports_total; ?>"  name="exports_total" id="exports_total" placeholder=""  autocomplete="off">
						<label  for="exports_total" ><?php if($signup_error['label'] =="exports_total"){ echo $signup_error['message'];  }?></label>
					</div>
					<div class="form-group col-sm-6">
						<label class="form-label" for="exports_of_service">Export of Service</label>
						<input type="text" class="form-control <?php if($signup_error['label'] =="exports_of_service"){ echo "is-invalid" ; } ?>" value="<?php echo $exports_total; ?>" value="<?php echo $exports_of_service; ?>"   name="exports_of_service" id="exports_of_service" placeholder=""  autocomplete="off">
						<label  for="exports_of_service" ><?php if($signup_error['label'] =="exports_of_service"){ echo $signup_error['message'];  }?></label>
					</div>
					<div class="form-group col-sm-6">
						<label class="form-label" for="all_total_exports">Total</label>
						<input type="number" class="form-control <?php if($signup_error['label'] =="all_total_exports"){ echo "is-invalid" ; } ?>" value="<?php echo $all_total_exports; ?>"  name="all_total_exports" id="all_total_exports" placeholder=""  autocomplete="off">
						<label  for="all_total_exports" ><?php if($signup_error['label'] =="all_total_exports"){ echo $signup_error['message'];  }?></label>
					</div>
					<div class="form-group col-sm-6"></div>
                    <div class="form-group col-sm-6">
						<label class="form-label" for="Status_Holder">Status Holder</label>
						<div class="d-flex mt-2">
                        
                        	<div class="mr-3">
								<label for="Yes">
								<input type="radio" id="chkYes" value="Yes" name="status_holder" <?php if($status_holder=='Yes'){ echo 'checked="checked"'; } ?>/> Yes</label>						
                        	</div>
                        	
                            <div class="mr-3">
                        		<label for="No">
								<input type="radio" id="chkNo" value="No" name="status_holder" <?php if($status_holder=='No'){ echo 'checked="checked"'; } ?> /> No</label>					
                            </div>
                            
						</div>
						<label  for="status_holder" ><?php if($signup_error['label'] =="status_holder"){ echo $signup_error['message'];  }?></label>
					</div>
				
					<div class="col-md-6 col-sm-3 col-xs-12">
					<div class="row" id="holder_star" <?php if ($status_holder!='Yes'){?> style="display: none" <?php }?>>
					<div class="col-sm-6" >                    
                    	<label>Select Category </label>
                        <select class="form_text_text form-control  <?php if($signup_error['label'] =="status_holder_eh"){ echo "is-invalid" ; } ?>" name="status_holder_eh" id="status_holder_eh">
                            <option value="0">--- Select ---</option>
                            <option value="one_star" <?php if($status_holder_eh=="one_star") echo 'selected="selected"'; ?>>One Star</option>
                            <option value="two_star" <?php if($status_holder_eh=="two_star") echo 'selected="selected"'; ?>>Two Star</option>
                            <option value="three_star" <?php if($status_holder_eh=="three_star") echo 'selected="selected"'; ?>>Three Star</option>
                            <option value="four_star" <?php if($status_holder_eh=="four_star") echo 'selected="selected"'; ?>>Four Star</option>
                            <option value="five_star" <?php if($status_holder_eh=="five_star") echo 'selected="selected"'; ?>>Five Star</option>
                        </select>
                        <label  for="status_holder_eh" ><?php if($signup_error['label'] =="status_holder_eh"){ echo $signup_error['message'];  }?></label>
   
					</div>
					<div class="form-group col-sm-6">
							<label for="eh_th_certification_no" class="form-label"/>EH/TH/STH Certificate</label>
							<select class="form_text_text form-control <?php if($signup_error['label'] =="eh_th_certification_no"){ echo "is-invalid" ; } ?>" name="eh_th_certification_no" id="eh_th_certification_no" >
							<option value="0">--- Select ---</option>
							<option value="EH" <?php if($eh_th_certification_no=="EH") echo 'selected="selected"'; ?>>EH</option>
							<option value="TH" <?php if($eh_th_certification_no=="TH") echo 'selected="selected"'; ?>>TH</option>
							<option value="STH" <?php if($eh_th_certification_no=="STH") echo 'selected="selected"'; ?>>STH</option>
							<option value="SSTH" <?php if($eh_th_certification_no=="SSTH") echo 'selected="selected"'; ?>>SSTH</option>
							</select>
							<label  for="eh_th_certification_no" ><?php if($signup_error['label'] =="eh_th_certification_no"){ echo $signup_error['message'];  }?></label>
					</div>
					</div>											
					</div>

					<div class="col-12" style="display:none;" id="memberttypedisplay">						
                        <div class="row">                        
                    
						
						<div class="form-group col-sm-6">
							<label for="eh_th_valid_date" class="form-label">Valid Upto :</label>
                            <input type="text" class="form-control <?php if($signup_error['label'] =="eh_th_valid_date"){ echo "is-invalid" ; } ?>" value="<?php echo $eh_th_valid_date;?>" name="eh_th_valid_date" id="eh_th_valid_date" placeholder="Valid Upto" autocomplete="off" readonly/>
                            <label  for="eh_th_valid_date" ><?php if($signup_error['label'] =="eh_th_valid_date"){ echo $signup_error['message'];  }?></label>					
						</div>
					                    
                        <div class="form-group col-sm-6">
                            <label for="im_registration_no" class="form-label">IM Registration No. :</label>
                            <input type="text" class="form-control <?php if($signup_error['label'] =="im_registration_no"){ echo "is-invalid" ; } ?>" name="im_registration_no" value="<?php echo $im_registration_no;?>" id="im_registration_no" placeholder="IM Registration No." />
                            <label  for="im_registration_no" ><?php if($signup_error['label'] =="im_registration_no"){ echo $signup_error['message'];  }?></label>
                        
                        </div>
                    
                        <div class="form-group col-sm-6">
                            <label for="im_pin_code" class="form-label">IM Pin Code :</label>
                            <input type="text" class="form-control <?php if($signup_error['label'] =="im_pin_code"){ echo "is-invalid" ; } ?>" name="im_pin_code" value="<?php echo $im_pin_code;?>" id="im_pin_code" placeholder="IM Pin Code" />
                            <label  for="im_pin_code" ><?php if($signup_error['label'] =="im_pin_code"){ echo $signup_error['message'];  }?></label>
                        </div>
                    
                        <div class="form-group col-sm-6">
                            <label class="form-label">ISSUING INDUSTRIAL LINCENCES/IEM :</label>
                            <input type="text" class="form-control <?php if($signup_error['label'] =="issuing_industrial_liecence"){ echo "is-invalid" ; } ?>" value="<?php echo $issuing_industrial_liecence; ?>" name="issuing_industrial_liecence" id="issuing_industrial_liecence" placeholder="Issuing Industrial Licences/IEM" />
                             <label  for="issuing_industrial_liecence" ><?php if($signup_error['label'] =="issuing_industrial_liecence"){ echo $signup_error['message'];  }?></label>
                        </div>
				
                        <div class="form-group col-sm-6">
                            <label  class="form-label" >authority :</label>
                            <input type="text" class="form-control <?php if($signup_error['label'] =="authority"){ echo "is-invalid" ; } ?>" name="authority" id="authority" value="<?php echo $authority;?>" placeholder="authority" />
                            <label  for="authority" ><?php if($signup_error['label'] =="authority"){ echo $signup_error['message'];  }?></label>
                        </div>
						<div class="form-group col-sm-6">
							<label for="eh_th_issue_date" class="form-label">Date of Issue :</label>
							<input type="text" class="form-control  <?php if($signup_error['label'] =="eh_th_issue_date"){ echo "is-invalid" ; } ?>" value="<?php echo $eh_th_issue_date;?>" name="eh_th_issue_date" id="eh_th_issue_date" placeholder="Date of Issue" autocomplete="off" readonly/>	
							<label  for="eh_th_issue_date" ><?php if($signup_error['label'] =="eh_th_issue_date"){ echo $signup_error['message'];  }?></label>				
						</div>
                        
                        </div>
                    
                    </div>
					<div class="col-12">
							<p class="gold_clr mb-3 pb-2" style="border-bottom:1px dashed #a89c5d;"><strong>Firm Address Details</strong> </p>	
					</div>
					<div class="form-group col-12">
						
			<a href="https://gjepc.org/communication_form.php" class="cta " target="_blank">Click here to add/update address</a>
			<label  for="firm_error" ><?php if($signup_error['label'] =="firm_error"){ echo $signup_error['message'];  }?></label>		
		<?php 
	   	$query = $conn ->query("select * from communication_address_master where registration_id='".$_SESSION['USERID']."' and type_of_address='2'");
	   	if(	$query ->num_rows > 0){
	   		while($result= $query->fetch_assoc()){ ?>
	   					<div class="row mt-2">

	   						<div class="form-group col-sm-6">
                            <label for="gstin" class="form-label" >Address Type :</label>
                            <input type="text" class="form-control" value="<?php echo getaddresstype($result['type_of_address'],$conn);?>" readonly  />
                       	</div>
	   					
                       	<div class="form-group col-sm-6">
                            <label for="address_line_1" class="form-label" >Address Line 1 :</label>
                            <input type="text" class="form-control" name="address_line_1." value="<?php echo  $result['address1'];?>" readonly id="address_line_1"  placeholder="" />
                       	</div>
                       	<div class="form-group col-sm-6">
                            <label for="address_line_2" class="form-label" >Address Line 2 :</label>
                            <input type="text" class="form-control" name="address_line_2." id="address_line_2" value="<?php echo  $result['address2'];?>" readonly   placeholder="" />
                       	</div>
                       	<div class="form-group col-sm-6">
                            <label for="city" class="form-label" >City :</label>
                            <input type="text" class="form-control" name="city." id="city" value="<?php echo  $result['city'];?>" readonly  placeholder="" />
                       	</div>
                       
                       	<div class="form-group col-sm-6">
                            <label for="state" class="form-label" >State :</label>
                            <input type="text" class="form-control" name="state." id="state" value="<?php echo  getState($result['state'],$conn);?>" readonly   placeholder="" />
                       	</div>
                       	<div class="form-group col-sm-6">
                            <label for="pincode" class="form-label" >Pincode :</label>
                            <input type="text" class="form-control" name="pincode." id="pincode" value="<?php echo  $result['pincode'];?>" readonly   placeholder="" />
                       	</div>
	   					</div>
		
			
		
		<?php }
	}else{ ?>
<a href="https://gjepc.org/communication_form.php" class="cta " target="_blank">Click here to add/update address</a>
	<?php }
		 ?>		
		

					</div>

					<div class="col-12">
							<p class="gold_clr mb-3 pb-2" style="border-bottom:1px dashed #a89c5d;"><strong>RCMC Details</strong> </p>	
					</div>
  					
                       <div class="form-group col-sm-6">
                            <label for="rcmc_no" class="form-label" >RCMC No. :</label>
                            <input type="text" class="form-control  <?php if($signup_error['label'] =="rcmc_no"){ echo "is-invalid" ; } ?> " name="rcmc_no" id="rcmc_no" value="<?php echo $rcmc_no; ?>"  placeholder="" />
                            <label  for="rcmc_no" ><?php if($signup_error['label'] =="rcmc_no"){ echo $signup_error['message'];  }?></label>
                       </div>
                        <div class="form-group col-sm-6">
                            <label for="rcmc_issue_date" class="form-label" >Issue Date :</label>
                            <input type="text" class="form-control <?php if($signup_error['label'] =="rcmc_issue_date"){ echo "is-invalid" ; } ?>" name="rcmc_issue_date" id="rcmc_issue_date" value="<?php echo $rcmc_issue_date; ?>" placeholder="" />
                            <label  for="rcmc_issue_date" ><?php if($signup_error['label'] =="rcmc_issue_date"){ echo $signup_error['message'];  }?></label>
                       </div>
                        <div class="form-group col-sm-6">
                            <label for="rcmc_issue_authority" class="form-label" >Issue Authority :</label>
                            <input type="text" class="form-control <?php if($signup_error['label'] =="rcmc_issue_authority"){ echo "is-invalid" ; } ?>" value="<?php echo $rcmc_issue_authority; ?>"  name="rcmc_issue_authority" id="rcmc_issue_authority"  placeholder="" />
                             <label  for="rcmc_issue_authority" ><?php if($signup_error['label'] =="rcmc_issue_authority"){ echo $signup_error['message'];  }?></label>
                       </div>
                       <div class="form-group col-sm-6">
                            <label for="rcmc_product_of_which" class="form-label" >Product Of Which Registered  :</label>
                            <input type="text" class="form-control <?php if($signup_error['label'] =="rcmc_product_of_which"){ echo "is-invalid" ; } ?>" name="rcmc_product_of_which" value="<?php echo $rcmc_product_of_which; ?>" id="rcmc_product_of_which"  placeholder="" />
                             <label  for="rcmc_product_of_which" ><?php if($signup_error['label'] =="rcmc_product_of_which"){ echo $signup_error['message'];  }?></label>
                       </div>
                       <div class="form-group col-sm-6">
                            <label for="rcmc_expiry" class="form-label" >Expiry Date  :</label>
                            <input type="text" class="form-control <?php if($signup_error['label'] =="rcmc_expiry"){ echo "is-invalid" ; } ?>"  value="<?php echo $rcmc_expiry; ?>" name="rcmc_expiry" id="rcmc_expiry"  placeholder="" />
                            <label  for="rcmc_expiry" ><?php if($signup_error['label'] =="rcmc_expiry"){ echo $signup_error['message'];  }?></label>
                       </div>
                       <div class="form-group col-sm-6">
                            <label for="rcmc_status" class="form-label" >RCMC Status  :</label>
                            <input type="text" class="form-control <?php if($signup_error['label'] =="rcmc_status"){ echo "is-invalid" ; } ?>" value="<?php echo $rcmc_status; ?>" name="rcmc_status" id="rcmc_status"  placeholder="" />
                            <label  for="rcmc_status" ><?php if($signup_error['label'] =="rcmc_status"){ echo $signup_error['message'];  }?></label>
                       </div>
                       <div class="form-group col-sm-6">
                            <label for="rcmc_validity" class="form-label" >Validity Period   :</label>
                            <input type="text" class="form-control <?php if($signup_error['label'] =="rcmc_validity"){ echo "is-invalid" ; } ?>" value="<?php echo $rcmc_validity; ?>" name="rcmc_validity" id="rcmc_validity"  placeholder="" />
                             <label  for="rcmc_validity" ><?php if($signup_error['label'] =="rcmc_validity"){ echo $signup_error['message'];  }?></label>
                       </div>
                        <div class="form-group col-sm-6">
                            <label for="status_from_epc" class="form-label" >Status From EPC  :</label>
                            <input type="text" value="<?php echo $status_from_epc; ?>" class="form-control <?php if($signup_error['label'] =="status_from_epc"){ echo "is-invalid" ; } ?>" name="status_from_epc" id="status_from_epc"  placeholder="" />
                            <label  for="status_from_epc" ><?php if($signup_error['label'] =="status_from_epc"){ echo $signup_error['message'];  }?></label>
                       	</div>
                       	<div class="col-12">
							<p class="gold_clr mb-3 pb-2" style="border-bottom:1px dashed #a89c5d;"><strong>Branch Details</strong> </p>	
						</div>
						<?php 
							$query_branch_office = $conn ->query("select * from communication_address_master where registration_id='".$_SESSION['USERID']."' and type_of_address='3'");
							
							if($query_branch_office->num_rows  > 0){ 

                             $result_branch_office = $query_branch_office ->fetch_assoc();
							
							}else{ ?>
								<a href="https://gjepc.org/communication_form.php" class="cta " target="_blank">Click here to add/update address</a>
									<label  for="branch_error" ><?php if($signup_error['label'] =="branch_error"){ echo $signup_error['message'];  }?></label>
							<?php }
							?>
						<div class="form-group col-sm-6">
                            <label for="is_sez" class="form-label" >Is SEZ  :</label>
                            <input type="text" class="form-control" name="is_sez" id="is_sez"  placeholder="" />
                       	</div>
                       	<div class="form-group col-sm-6">
                            <label for="is_EOU" class="form-label" >Is EOU  :</label>
                            <input type="text" class="form-control" name="is_eou" id="is_eou"  placeholder="" />
                       	</div>
						<!-- <div class="form-group col-sm-6">
                            <label for="branch_code" class="form-label" >Branch Code  :</label>
                            <input type="text" class="form-control" name="branch_code" id="branch_code" value="<?php echo  $result_branch_office['gcode'];?>" readonly placeholder=""  />
                       	</div> -->

                       
                       	<div class="form-group col-sm-6">
                            <label for="gstin" class="form-label" >GSTIN :</label>
                            <input type="text" class="form-control" value="<?php echo  $result_branch_office['gst_no'];?>" readonly name="gstin" id="gstin"  placeholder="" />
                       	</div>
                       	<div class="form-group col-sm-6">
                            <label for="address_line_1" class="form-label" >Address Line 1 :</label>
                            <input type="text" class="form-control" name="address_line_1" value="<?php echo  $result_branch_office['address1'];?>" readonly id="address_line_1"  placeholder="" />
                       	</div>
                       	<div class="form-group col-sm-6">
                            <label for="address_line_2" class="form-label" >Address Line 2 :</label>
                            <input type="text" class="form-control" name="address_line_2" id="address_line_2" value="<?php echo  $result_branch_office['address2'];?>" readonly   placeholder="" />
                       	</div>
                       	<div class="form-group col-sm-6">
                            <label for="city" class="form-label" >City :</label>
                            <input type="text" class="form-control" name="city" id="city" value="<?php echo  $result_branch_office['city'];?>" readonly  placeholder="" />
                       	</div>
                       
                       	<div class="form-group col-sm-6">
                            <label for="state" class="form-label" >State :</label>
                            <input type="text" class="form-control" name="state" id="state" value="<?php echo  getState($result_branch_office['state'],$conn);?>" readonly   placeholder="" />
                       	</div>
                       	<div class="form-group col-sm-6">
                            <label for="pincode" class="form-label" >Pincode :</label>
                            <input type="text" class="form-control" name="pincode" id="pincode" value="<?php echo  $result_branch_office['pincode'];?>" readonly   placeholder="" />
                       	</div>
                       	<div class="col-12">
							<p class="gold_clr mb-3 pb-2" style="border-bottom:1px dashed #a89c5d;"><strong>Industrial Registration Details</strong> </p>	
						</div>
						                    
                        <div class="form-group col-sm-12">
							<label class="form-label" for="company_name">MSME/SSI</label>
							<div class="d-flex">
                            	<div class="mr-3"><label for="Yes"><input type="radio" id="msmeYes" value="Yes" name="msme_ssi_status" <?php echo ($msme_ssi_status=='Yes')? 'checked':'' ?> readonly /> Yes</label></div>
                                <div class="mr-3"><label for="No"><input type="radio" id="msmeNo" value="No" name="msme_ssi_status" <?php echo ($msme_ssi_status=='No')? 'checked':'' ?> readonly/>  No</label></div>
							</div>
							<label  for="msme_ssi_status" ><?php if($signup_error['label'] =="msme_ssi_status"){ echo $signup_error['message'];  }?></label>
						</div>
                        
						<div class="form-group col-md-12" id="msme_main" <?php if($msme_ssi_status!='Yes'){?> style="display: none" <?php }?>>
						<div class="row">
						<div class="form-group col-md-6">
						<label for="ssi_registration_no" class="form-label">UAM/MSME/UDHYAM REGISTRATION No</label>
						<input type="text" class="form-control" name="ssi_registration_no" id="ssi_registration_no" value="<?php echo $ssi_registration_no;?>" placeholder="SSI Registration No" readonly/>
						<label  for="ssi_registration_no" ><?php if($signup_error['label'] =="ssi_registration_no"){ echo $signup_error['message'];  }?></label>
						</div>
                        	
						                        
						<div class="form-group col-md-6">
                            <label for="ssi_issue_date" class="form-label" >DATE OF ISSUE OF UAM/MSME/UDYAM :</label>
                            <input type="text" class="form-control" name="ssi_issue_date" value="<?php echo $ssi_issue_date;?>" id="ssi_issue_date" placeholder="Date of SSI Registration" autocomplete="off" readonly/>
                            <label  for="ssi_issue_date" ><?php if($signup_error['label'] =="ssi_issue_date"){ echo $signup_error['message'];  }?></label>
                        </div>
						
						<div class="form-group col-md-6">
                            <label for="ssi_pin_code" class="form-label d-block mb-2">UAM/MSME/UDHYAM Pin Code : </label>	
                            <input type="text" class="form-control" name="ssi_pin_code" value="<?php echo $ssi_pin_code;?>" readonly id="ssi_pin_code" placeholder="SSI Pin Code" />
                             <label  for="ssi_pin_code" ><?php if($signup_error['label'] =="ssi_pin_code"){ echo $signup_error['message'];  }?></label>
                        </div>
                          <div class="form-group col-sm-6">
                            <label  class="form-label" >Authority :</label>
                            <input type="text" class="form-control" name="ssi_authority" id="ssi_authority" readonly value="<?php echo $ssi_authority;?>" placeholder="Authority" />
                            <label  for="ssi_authority" ><?php if($signup_error['label'] =="ssi_authority"){ echo $signup_error['message'];  }?></label>
                            
                        </div>
                        </div>
                        </div>
						
						
              
                    
                     
				
                      
						<div class="col-12">
							<p class="gold_clr mb-3 pb-2" style="border-bottom:1px dashed #a89c5d;"><strong>Details of Proprietor/Partner/Director/Karta/Managing Trustee
</strong> </p>	
						</div>		
                        
                      
                    <?php 
	   	$query_proprietor = $conn ->query("select * from communication_address_master where registration_id='".$_SESSION['USERID']."' and (type_of_address='1' OR type_of_address='5' OR type_of_address='7'   )");
	   	if(	$query_proprietor ->num_rows > 0){
	   		while($result_proprietor= $query_proprietor->fetch_assoc()){ ?>
	   			<div class="col-12">
	   				<div class="row">
	   					<input type="hidden" name="proprietor_check[<?php echo $result_proprietor['id']; ?>]">
	   				
	   					<div class="form-group col-sm-6">
                            <label for="gstin" class="form-label" >Address Type :</label>
                            <input type="text" class="form-control" value="<?php echo getaddresstype($result_proprietor['type_of_address'],$conn);?>" readonly  />
                       	</div>
	   					
                       	
                       	<div class="form-group col-sm-6">
                            <label for="address_line_1" class="form-label" >Name :</label>
                            <input type="text" class="form-control" value="<?php echo  $result_proprietor['name'];?>" readonly  placeholder="" />
                       	</div>
                       	<div class="form-group col-sm-6">
                            <label for="address_line_1" class="form-label" >DIN No. :</label>
                            <input type="text" class="form-control"  value="<?php echo  $result_proprietor['din'];?>"   />
                       	</div>
                       	<div class="form-group col-sm-6">
                            <label  >Is the Director a Foreign National? :</label>
                           <div class="mr-3 form-check"><label for="isForeignNational1_<?php echo $result_proprietor['id']; ?>" class="form-check-label"> <input type="radio" class="form-check-input" name="isForeignNational" id="isForeignNational1_<?php echo $result_proprietor['id']; ?>" value="Yes"   />Yes</label></div>
                          <div class="mr-3 form-check"> <label class="form-check-label" for="isForeignNational2_<?php echo $result_proprietor['id']; ?>"> <input type="radio" class="form-check-input" name="isForeignNational" id="isForeignNational2_<?php echo $result_proprietor['id']; ?>" value="No"   />No</label></div>

                   	</div>
						<div class="form-group col-sm-6">
                            <label for="address_line_1" class="form-label" >Address Line 1 :</label>
                            <input type="text" class="form-control" value="<?php echo  $result_proprietor['address1'];?>" readonly  placeholder="" />
                       	</div>
                       	<div class="form-group col-sm-6">
                            <label for="address_line_2" class="form-label" >Address Line 2 :</label>
                            <input type="text" class="form-control"   value="<?php echo  $result_proprietor['address2'];?>" readonly   placeholder="" />
                       	</div>
                       	<div class="form-group col-sm-6">
                            <label for="city" class="form-label" >City :</label>
                            <input type="text" class="form-control"  value="<?php echo  $result_proprietor['city'];?>" readonly  />
                       	</div>
                       
                       	<div class="form-group col-sm-6">
                            <label for="state" class="form-label" >State :</label>
                            <input type="text" class="form-control"  value="<?php echo  getState($result_proprietor['state'],$conn);?>" readonly   />
                       	</div>
                       	<div class="form-group col-sm-6">
                            <label for="pincode" class="form-label" >Pincode :</label>
                            <input type="text" class="form-control"  value="<?php echo  $result_proprietor['pincode'];?>" readonly    />
                       	</div>
	   				</div>
	   			</div>
   						
	   				
		
			
		
		<?php }
	}else{ ?>
<a href="https://gjepc.org/communication_form.php" class="cta " target="_blank">Click here to add/update address</a>
	<?php }
		 ?>
		 	<div class="col-12">
							<p class="gold_clr mb-3 pb-2" style="border-bottom:1px dashed #a89c5d;"><strong>Other Details (Preferred sectors of operations)</strong> </p>	
						</div>	
						<div class="col-12 mb-2">
							<strong>Exports List</strong>
						</div>	
			
			<div class="form-group col-sm-6">
				<label class="form-label" for="export_coloured_gemstones">Coloured Gemstones <span>*</span></label>
				<input type="number" class="form-control" name="export_coloured_gemstones" id="export_coloured_gemstones" value="<?php echo $export_coloured_gemstones;?>" />
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="export_costume_jewellery">Costume/Fashion Jewellery <span>*</span></label>
				<input type="number" class="form-control"name="export_costume_jewellery" id="export_costume_jewellery" value="<?php echo $export_costume_jewellery;?>" />
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="export_cut_polished_diamonds">Cut & Polished Diamonds <span>*</span></label>
				<input type="number" class="form-control" name="export_cut_polished_diamonds" id="export_cut_polished_diamonds" value="<?php echo $export_cut_polished_diamonds;?>" />
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="export_gold_jewellery">Plain Gold Jewellery : <span>*</span></label>
				<input type="number" class="form-control" name="export_gold_jewellery" id="export_gold_jewellery" value="<?php echo $export_gold_jewellery;?>" />
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="export_studded_gold_jewellery">Studded Gold Jewellery : <span>*</span></label>
				<input type="number" class="form-control" name="export_studded_gold_jewellery" id="export_studded_gold_jewellery" value="<?php echo $export_studded_gold_jewellery;?>" />
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="export_silver_jewellery">Plain Silver Jewellery : <span>*</span></label>
				<input type="number" class="form-control" name="export_silver_jewellery" id="export_silver_jewellery" value="<?php echo $export_silver_jewellery;?>" />
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="export_studded_silver_jewellery">Studded Silver Jewellery : <span>*</span></label>
				<input type="number" class="form-control"name="export_studded_silver_jewellery" id="export_studded_silver_jewellery" value="<?php echo $export_studded_silver_jewellery;?>" />
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="export_other_precious_metal_jewellery">Other Precious Metal Jewellery : <span>*</span></label>
				<input type="number" class="form-control" name="export_other_precious_metal_jewellery" id="export_other_precious_metal_jewellery" value="<?php echo $export_other_precious_metal_jewellery;?>"  />
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="export_pearls">Pearls : <span>*</span></label>
				<input type="number" class="form-control" name="export_pearls" id="export_pearls" value="<?php echo $export_pearls; ?>" />
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="export_rough_diamonds">Rough Diamonds : <span>*</span></label>
				<input type="number" class="form-control" name="export_rough_diamonds" id="export_rough_diamonds" value="<?php echo $export_rough_diamonds;?>" />
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="export_sales_to_foreign_tourists">Sales to Foreign Tourists : <span>*</span></label>
				<input type="number" class="form-control" name="export_sales_to_foreign_tourists" id="export_sales_to_foreign_tourists" value="<?php echo $export_sales_to_foreign_tourists;?>" /></div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="export_synthetic_stones">Synthetic Stones : <span>*</span></label>
				<input type="number" class="form-control" name="export_synthetic_stones" id="export_synthetic_stones" value="<?php echo $export_synthetic_stones;?>" />
			</div>
            
			<div class="form-group col-sm-6">
				<label class="form-label" for="export_rough_lgd">Rough Lab Grown Diamond : <span>*</span></label>
				<input type="number" class="form-control" name="export_rough_lgd" id="export_rough_lgd" value="<?php echo $export_rough_lgd;?>" />
			</div>
			
			<div class="form-group col-sm-6">
				<label class="form-label" for="export_cut_polished_lgd">Cut & Polished Lab Grown Diamond : <span>*</span></label>
				<input type="number" class="form-control" name="export_cut_polished_lgd" id="export_cut_polished_lgd" value="<?php echo $export_cut_polished_lgd;?>" />
			</div>
			
            <div class="form-group col-sm-6">
				<label class="form-label" for="export_other_items">Other Items : <span>*</span></label>
				<input type="number" class="form-control" name="export_other_items" id="export_other_items" value="<?php echo $export_other_items; ?>" />
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="export_total">Total : <span>*</span></label>
				<input type="number" class="form-control" name="export_total" id="export_total" value="<?php echo $export_total;?>" />
			</div>
			 <div class="form-group col-12"><strong>Import Performance Details, CIF in INR</strong></div>
            <div class="col-12 form-group">
						<a href="https://gjepc.org/challan_form.php" class="cta " target="_blank">Click here to update Exports list</a>
					</div>
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_cut_polished_diamonds">Cut & Polished Diamonds : <span>*</span></label>
				<input type="number" class="form-control" name="import_cut_polished_diamonds" id="import_cut_polished_diamonds" value="<?php echo $import_cut_polished_diamonds;?>" >
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_cut_polished_gemstones">Cut & Polished Gemstones : <span>*</span></label>
				<input type="number" class="form-control" name="import_cut_polished_gemstones" id="import_cut_polished_gemstones" value="<?php echo $import_cut_polished_gemstones; ?>" >
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_false_pearls">Processed & Finished Pearls : <span>*</span></label>
				<input type="number" class="form-control" name="import_false_pearls" id="import_false_pearls" value="<?php echo $import_false_pearls; ?>" ></div>
			
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_findings_mountings">Findings & Mountings : <span>*</span></label>
				<input type="number" class="form-control" name="import_findings_mountings" id="import_findings_mountings" value="<?php echo $import_findings_mountings;?>" >
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_gold">Gold Bar : <span>*</span></label>
				<input type="number" class="form-control" name="import_gold" id="import_gold" value="<?php echo $import_gold;?>" >
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_raw_pearls">Raw Pearls : <span>*</span></label>
				<input type="number" class="form-control" name="import_raw_pearls" id="import_raw_pearls" value="<?php echo $import_raw_pearls;?>" >
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_rough_diamonds">Rough Diamond: : <span>*</span></label>
				<input type="number" class="form-control" name="import_rough_diamonds" id="import_rough_diamonds" value="<?php echo $import_rough_diamonds;?>" >
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_rough_gemstones">Rough Gemstones : <span>*</span></label>
				<input type="number" class="form-control" name="import_rough_gemstones" id="import_rough_gemstones" value="<?php echo $import_rough_gemstones;?>" >
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_rough_imitation_stones">Rough Imitation Stones, Glass Beads/ Glass Chattons : <span>*</span></label>
				<input type="number" class="form-control" name="import_rough_imitation_stones" id="import_rough_imitation_stones" value="<?php echo $import_rough_imitation_stones; ?>" >
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_silver">Silver, Platinum, Palladium : <span>*</span></label>
				<input type="number" class="form-control" name="import_silver" id="import_silver" value="<?php echo $import_silver; ?>" >
			</div>
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_synthetic_stones">Synthetic stones : <span>*</span></label>
				<input type="number" class="form-control" name="import_synthetic_stones" id="import_synthetic_stones" value="<?php echo $import_synthetic_stones; ?>" >
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_gold_jewellery">Gold Jewellery : <span>*</span></label>
				<input type="number" class="form-control" name="import_gold_jewellery" id="import_gold_jewellery" value="<?php echo $import_gold_jewellery; ?>" >
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_silver_jewellery">Silver Jewellery : <span>*</span></label>
				<input type="number" class="form-control" name="import_silver_jewellery" id="import_silver_jewellery" value="<?php echo $import_silver_jewellery; ?>" >
			</div>
			
			<div class="form-group col-sm-6">
				<label class="form-label" for="import_rough_lgd">Rough Lab Grown Diamond : <span>*</span></label>
				<input type="number" class="form-control" name="import_rough_lgd" id="import_rough_lgd" value="<?php echo $import_rough_lgd; ?>" >
			</div>
			
			<div class="form-group col-sm-6">
				<label class="form-label" for="import_cut_polished_lgd">Cut & Polished Lab Grown Diamond : <span>*</span></label>
				<input type="number" class="form-control" name="import_cut_polished_lgd" id="import_cut_polished_lgd" value="<?php echo $import_cut_polished_lgd; ?>" >
			</div>
			
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_other_items">Other Items : <span>*</span></label>
				<input type="number" class="form-control"  name="import_other_items" id="import_other_items" value="<?php echo $import_other_items; ?>" >
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_total">Total : <span>*</span></label>
				<input type="number" class="form-control" name="import_total" id="import_total" value="<?php echo $import_total;?>"  />
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="export_fob_value">F.O.B value of exports : <span>*</span></label>
				<input type="number" class="form-control" name="export_fob_value" id="export_fob_value" value="<?php echo $export_fob_value;?>"  />
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_cif_value">C.I.F value of imports : <span>*</span></label>
				<input type="number" class="form-control" name="import_cif_value" id="import_cif_value" value="<?php echo $import_cif_value;?>" />
			</div>  		
						
 
					<div class="form-group col-sm-12">
						<input type="hidden" name="action" value="save" class="cta fade_anim"/>
						<?php if($chk_info_aprv!='Y'){?><input class="input_bg cta fade_anim" type="submit" value="Proceed"/><?php } ?>
					</div>
                    
			</form>
         <?php }?>
				
		
			<div id="add_data_Modal" class="modal fade">  
      			<div class="modal-dialog">  
          			<div class="modal-content">  
               			<div class="modal-header">  
                     		<h2 class="title mb-0">Other Contact Information</h2>  
                		</div>  
                <div class="modal-body">  
                    <form method="post" id="insert_form">  
                          <label>Choose Department</label>  
                            <select name="dept" id="dept" class="form-control">				
								<option value="Finance">Accounts & Finance</option>
								<option value="IT">IT</option>
								<option value="Legal">Legal</option>
								<option value="Marketing">Events & Marketing </option>                        
							</select> 
                          <br />  
                          <label>Name</label>  
                         <input type="text" class="form-control" name="other_name" id="other_name" placeholder="Name" autocomplete="off">  
                          <br />  
                          <label>Email</label>  
                          <input type="text" class="form-control" name="other_email" id="other_email" placeholder="Email" autocomplete="off"> 
                          <br />  
                          <label>Phone</label>  
                          <input type="text" class="form-control" name="other_phone" id="other_phone" placeholder="Phone" autocomplete="off">
                          <br />                            
                          <input type="hidden" name="id" id="id"/>  
                          <input type="button" name="insert" id="insert" value="Save" class="cta" />  
                    </form>  
                </div>  
                <div class="modal-footer">  
                     <button type="button" data-dismiss="modal" style="border-bottom:1px solid #a89c5d; color:#a89c5d;"> <strong>Close </strong></button>  
                </div>  
           </div>  
      </div>  
 </div>
			
            </div>            
        </div> 	
    </div>    
</section>
<?php include 'include-new/footer-card.php'; ?>

<script src="assets/js/jquery.validate.js" type="text/javascript"></script> 
<script>
$(document).ready(function(){
	var member_id=$("#member_type_id").val();

	if(member_id==5 || member_id=="")
	{
		$("#memberttypedisplay").hide();
		$("#memberttypedisplay2").hide();
		$("#im_registration_no").attr("disabled", "disabled"); 
		$("#im_pin_code").attr("disabled", "disabled"); 
		$("#ssi_registration_no").attr("disabled", "disabled"); 
		$("#ssi_issue_date").attr("disabled", "disabled"); 
		$("#ssi_pin_code").attr("disabled", "disabled"); 
		$("#issuing_industrial_liecence").attr("disabled", "disabled"); 
		$("#authority").attr("disabled", "disabled"); 
	}
	if(member_id==6)
	{
		$("#memberttypedisplay").show();
		$("#memberttypedisplay2").show();
		$("#im_registration_no").removeAttr("disabled"); 
		$("#im_pin_code").removeAttr("disabled"); 
		$("#ssi_registration_no").removeAttr("disabled"); 
		$("#ssi_issue_date").removeAttr("disabled"); 
		$("#ssi_pin_code").removeAttr("disabled"); 
		$("#issuing_industrial_liecence").removeAttr("disabled"); 
		$("#authority").removeAttr("disabled"); 
	}

  $("#member_type_id").change(function () {
	var member_id=$(this).val();
	if(member_id==5 || member_id=="")
	{
		$("#memberttypedisplay").hide();
		$("#memberttypedisplay2").hide();
		$("#im_registration_no").attr("disabled", "disabled"); 
		$("#im_pin_code").attr("disabled", "disabled"); 
		$("#ssi_registration_no").attr("disabled", "disabled"); 
		$("#ssi_issue_date").attr("disabled", "disabled"); 
		$("#ssi_pin_code").attr("disabled", "disabled"); 
		$("#issuing_industrial_liecence").attr("disabled", "disabled"); 
		$("#authority").attr("disabled", "disabled"); 
	}
	if(member_id==6)
	{
		$("#memberttypedisplay").show();
		$("#memberttypedisplay2").show();
		$("#im_registration_no").removeAttr("disabled"); 
		$("#im_pin_code").removeAttr("disabled"); 
		$("#ssi_registration_no").removeAttr("disabled"); 
		$("#ssi_issue_date").removeAttr("disabled"); 
		$("#ssi_pin_code").removeAttr("disabled"); 
		$("#issuing_industrial_liecence").removeAttr("disabled"); 
		$("#authority").removeAttr("disabled"); 
	}
 });
});
</script>
<script type="text/javascript">
$().ready(function() {
	$("#infoForm").validate({
			//var member_id=$("#member_type_id").val();
		rules: {  
			company_name: {
				required: true,
			},  
			member_type_id: {
				required: true,
			}, 
			type_of_firm:{
				required: true,
			},  
			iec_no: {
				required: true,
				minlength: 10,
				maxlength: 10
			},
			pan_no: {
				required: true,
				minlength: 10,
				maxlength: 10
			},

			tan_no: {
				required: true,
				minlength: 10,
				maxlength: 10
			},
			iec_issue_date: {
				required: true,
			},
			dgft_ra_office:{
				required: true,
			},
			annual_turnover:{
				required: true,
			},
			financial_year1_export:{
				required: true,
			},
			financial_year2_export:{
				required: true,
			},
			financial_year3_export:{
				required: true,
			},
			export_sub_total:{
				required: true,
			},
			deemed_export_total:{
				required: true,
			},
			exports_total:{
				required: true,
			},
			all_total_exports:{
				required: true,
			},
			exports_of_service:{
				required: true,
			}, status_holder_eh:{
				required: true,
			},eh_th_certification_no:{
				required: true,
			},eh_th_valid_date:{
				required: true,
			},
			ssi_registration_no: {
				required: true,
			}, 
			ssi_issue_date: {
				required: true,
			}, 
			im_registration_no:{
			required: true,	
			},
			ssi_pin_code: {
				required: true,
			},
			issuing_industrial_liecence: {
				required: true,
			}, 
			authority: {
				required: true,
			},
			rcmc_no:{
				required:true,
			},
			rcmc_issue_date:{
				required:true,
			},
			rcmc_issue_authority:{
				required:true,
			},
			rcmc_product_of_which:{
				required:true,
			},
			rcmc_expiry:{
				required:true,
			},
			rcmc_status:{
				required:true,
			},
			rcmc_validity:{
				required:true,
			},
			status_from_epc:{
				required:true,
			},
			export_sales_to_foreign_tourists: {required: true,number :true},
			export_synthetic_stones: {required: true,number :true},
			export_costume_jewellery: {required: true,number :true},
			export_other_precious_metal_jewellery: {required: true,number :true},
			export_pearls: {required: true,number :true},
			export_coloured_gemstones:{required: true,number :true},
			export_gold_jewellery: {required: true,number :true},
			export_studded_gold_jewellery: {required: true,number :true},
			export_silver_jewellery: {required: true,number :true},
			export_studded_silver_jewellery: {required: true,number :true},
			export_rough_diamonds: {required: true,number :true},
			export_cut_polished_diamonds: {required: true,number :true},
			export_rough_lgd: {required: true,number :true},
			export_cut_polished_lgd: {required: true,number :true},
			export_total: "required",
			import_findings_mountings: "required",
			import_false_pearls: "required",
			import_rough_imitation_stones: "required",
			import_silver: "required",
			import_raw_pearls: "required",
			import_cut_polished_gemstones: "required", 
			import_rough_gemstones: "required",
			import_gold: "required",
			import_cut_polished_diamonds: "required",
			import_rough_diamonds: "required",
			import_synthetic_stones: "required",
			import_gold_jewellery: "required",
			import_silver_jewellery: "required",
			import_rough_lgd: "required",
			import_cut_polished_lgd: "required",
			import_total: "required",
			export_fob_value: "required",
			import_cif_value: "required",		
		},
		messages: {
			company_name: {
				required: "Please Enter Company Name",
			},  
			member_type_id: {
				required: "Please Select Member Type",
			},  
			type_of_firm: {
				required: "Please Select Firm Type",
			},
			pan_no: {
				required: "Please Enter your PAN NO.",
				minlength: "Your PAN no must consist of at least 10 characters",
				maxlength: "Your PAN no must be less than 10 characters"
			},   
			iec_no: {
				required: "Please Enter your Pan No",
				minlength: "Your iec no must consist of at least 10 characters",
				maxlength: "Your iec no must be less than 10 characters"
			}, 
			pan_no: {
				required: "Please Enter your Pan No",
				minlength: "Your Pan no must consist of at least 10 characters",
				maxlength: "Your Pan no must be less than 10 characters"
			},
			tan_no: {
				required: "Please Enter your Tan No",
				minlength: "Your Tan no must consist of at least 10 characters",
				maxlength: "Your Tan no must be less than 10 characters"
			},  
			iec_issue_date: {
				required: "Please Enter valid date of issue",
			},
			dgft_ra_office: {
				required: "Please Enter DGFT RA office",
			},   
			annual_turnover:{
				required: "Please Annual turnover",
			},
			financial_year1_export:{
				required: " financial export is required",
			},
			financial_year2_export:{
				required: " financial export is required",
			},
			financial_year3_export:{
				required: " financial export is required",
			},
			export_sub_total:{
				required: " Sub total is required",
			},
			deemed_export_total:{
				required: " Total deemed export is required",
			},
			exports_total:{
				required: "Total export is required",
			},
			all_total_exports:{
				required: "Total export is required",
			},
			exports_of_service:{
				required: "Required",
			}, status_holder_eh:{
				required: "Status holder is required",
			},eh_th_certification_no:{
				required: "select certificate",
			},eh_th_valid_date:{
				required: "select date",
			},  
			ssi_registration_no:
			{
				required: "Please Enter SSI Registration No",
			},
			ssi_issue_date:
			{
				required: "Please Enter SSI issue date",
			},
			im_registration_no:
			{
				required: "Please Enter IM Registration No",
			},
			ssi_pin_code:
			{
				required: "Please Enter SSI Pin code",
			},
			issuing_industrial_liecence: {
				required: "Please Enter industrial liecence number",
			},
			authority: {
				required: "Please Enter authority number",
			},
			
			rcmc_no:{
				required:"RCMC no is required",
			},
			rcmc_issue_date:{
				required:" Issue date is equired",
			},
			rcmc_issue_authority:{
				required:"Issue authority is required",
			},
			rcmc_product_of_which:{
				required:"Enter product of which ",
			},
			rcmc_expiry:{
				required:"Select RCMC expiry",
			},
			rcmc_status:{
				required:"RCMC status is required",
			},
			rcmc_validity:{
				required:"RCMC validity is required",
			},
			status_from_epc:{
				required:"Select RCMC status from EPC",
			},
			export_sales_to_foreign_tourists: 
			{
			required:"Please enter sales to foreign tourists",
			number:"Please enter number only"
			},    
			export_synthetic_stones: 
			{
			required:"Please enter synthetic stones",
			number:"Please enter number only"
			},
			export_costume_jewellery: 
			{
			required:"Please enter costume/fashion jewellery",
			number:"Please enter number only"
			},
			export_other_precious_metal_jewellery: 
			{
			required:"Please enter other precious metal jewellery",
			number:"Please enter number only"
			},
			export_pearls: 
			{
			required:"Please enter pearls",
			number:"Please enter number only"
			},
			export_coloured_gemstones: 
			{
			required:"Please enter coloured gemstones",
			number:"Please enter number only"
			},
			export_gold_jewellery: 
			{
			required:"Please enter gold jewellery",
			number:"Please enter number only"
			},
			export_studded_gold_jewellery: 
			{
			required:"Please enter Studded gold jewellery",
			number:"Please enter number only"
			},
			export_silver_jewellery: 
			{
			required:"Please enter siiver jewellery",
			number:"Please enter number only"
			},
			export_studded_silver_jewellery: 
			{
			required:"Please enter Studded Silver jewellery",
			number:"Please enter number only"
			},
			export_rough_diamonds: 
			{
			required:"Please rough diamonds",
			number:"Please enter number only"
			},
			export_cut_polished_diamonds: 
			{
			required:"Please enter Cut & Polished Diamonds",
			number:"Please enter number only"
			},
			export_rough_lgd: 
			{
			required:"Please enter Rough Lab Grown Diamond",
			number:"Please enter number only"
			},
			export_cut_polished_lgd: 
			{
			required:"Please enter Cut & Polished Lab Grown Diamond",
			number:"Please enter number only"
			},
			export_total: "Please enter total amount",
			import_findings_mountings: "Please enter Findings & Mountings",
			import_false_pearls: "Please enter false pearls",
			import_rough_imitation_stones: "Please enter rough imitation stones, glass bead chattons",
			import_silver: "Please enter silver, platinum, palladium",
			import_raw_pearls: "Please enter raw pearls",
			import_cut_polished_gemstones: "Please enter cut & polished gemstones",
			import_rough_gemstones: "Please enter rough gemstones",
			import_gold: "Please enter gold",
			import_cut_polished_diamonds: "Please enter cut & polished diamonds",
			import_rough_diamonds: "Please enter rough diamonds",
			import_synthetic_stones: "Please enter synthetic stones",
			import_gold_jewellery: "Please enter Gold Jewellery",
			import_silver_jewellery: "Please enter Silver Jewellery",
			import_rough_lgd: "Please enter Rough Lab Grown Diamond",
			import_cut_polished_lgd: "Please enter Cut & Polished Lab Grown Diamond",
			import_total: "Please enter total",
			export_fob_value: "Please enter F.O.B value of exports",
			import_cif_value: "Please enter C.I.F value of imports",		
		}
	});
});
</script>

<script type="text/javascript">
    $(function () {
        $("input[name='status_holder']").click(function () {
            if ($("#chkYes").is(":checked")) {
                $("#holder_star").show();
            } else {
                $("#holder_star").hide();
            }
        });
    });
</script>
<script type="text/javascript">
    $(function () {
        $("input[name='msme_ssi_status']").click(function () {
            if ($("#msmeYes").is(":checked")) {
                $("#msme_main").show();
            } else {
                $("#msme_main").hide();
            }
        });
    });
</script>
<script type="text/javascript">
    $(function () {
        $("input[name='epc_fieo_status']").click(function () {
            if ($("#epcYes").is(":checked")) {
                $("#epc_main").show();
            } else {
                $("#epc_main").hide();
            }
        });
    });
</script>
<script>
$(document).ready(function(){
	var typeFirm=$("#type_of_firm").val();
	$("#type_of_firm").change(function () {
	var typeFirm=$(this).val();
	if(typeFirm==13 || typeFirm==12)
	{
		$("#cinNoDisplay").show();
		$("#cin_no").removeAttr("disabled");
	}else
	{
		$("#cinNoDisplay").hide();
		$("#cin_no").attr("disabled", "disabled"); 
	}
 }); 
});
</script>

<script>  
 $(document).ready(function(){  
      $('#add').click(function(){  
           $('#insert').val("Save");  
           $('#insert_form')[0].reset();  
      });  
      $(document).on('click', '.edit_data', function(){  
           var id = $(this).attr("id");  
           $.ajax({  
                url:"fetch.php",  
                method:"POST",  
                data:{id:id},  
                dataType:"json",  
                success:function(data){
                     $('#dept').val(data.dept);  
                     $('#other_name').val(data.other_name);  
                     $('#other_email').val(data.other_email);  
                     $('#designation').val(data.designation);  
                     $('#other_phone').val(data.other_phone);  
                     $('#id').val(data.id);  
                     $('#insert').val("Update");  
                     $('#add_data_Modal').modal('show');  
                }  
           });  
      });  
      $('#insert').on("click", function(event){ 
           event.preventDefault();  
           if($('#dept').val() == "")  
           {  
                alert("Choose Department required");  
           }  
           else if($('#other_name').val() == '')  
           {  
                alert("Name is required");  
           }  
           else if($('#other_email').val() == '')  
           {  
                alert("Email is required");  
           }  
           else if($('#other_phone').val() == '')  
           {  
                alert("Phone is required");  
           }  
           else  
           {  
                $.ajax({  
                     url:"ajax_other_contact.php",  
                     method:"POST",  
                     data:$('#insert_form').serialize(),  
                     beforeSend:function(){  
                          $('#insert').val("Inserting");  
                     },  
                     success:function(data){
						 if(data == '0'){
							 alert('Already Selected!! Try Another Department');
							 $('#add_data_Modal').modal('hide');
						 }else{
                          $('#insert_form')[0].reset();  
                          $('#add_data_Modal').modal('hide');  
                          $('#employee_table').html(data);  
						 }
                     }  
                });  
           }  
      });  
       
 });  
 </script>

<!-- Datepicker Start -->
<script>
$(document).ready(function () { 
				$("#iec_issue_date").datepicker({             
                format: "dd-mm-yyyy"
                });
				$("#eh_th_issue_date").datepicker({             
                format: "dd/mm/yyyy"
                });
				$("#eh_th_valid_date").datepicker({               
                format: "dd-mm-yyyy"
                });
                $("#eh_th_valid_date").datepicker({               
                format: "dd-mm-yyyy"
                });
				$("#uin_issue_date").datepicker({            
                format: "dd/mm/yyyy"
                });
				$("#rcmc_issue_date").datepicker({             
                format: "dd-mm-yyyy"
                });
                $("#rcmc_expiry").datepicker({             
                format: "dd-mm-yyyy"
                });
                $("#year_of_starting_bussiness").datepicker({              
                format: "dd-mm-yyyy"
                });
				$("#retirement_date").datepicker({              
                format: "dd/mm/yyyy"
                });			
				$('#datetimepicker2').datepicker({
				format: 'DD-MM-YYYY'
				});
				$('#rcmc_validity').datepicker({
				 format: "dd-mm-yyyy"
				});
								
            });    
</script>
<!-- Datepicker End -->