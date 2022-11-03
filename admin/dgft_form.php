<?php 
session_start();
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php');exit;}
include('../db.inc.php');
include('../functions.php');
?>
<?php 
$registration_id = intval(filter($_REQUEST['registration_id']));

$info_status =  $conn ->query("select status,region_id from information_master where registration_id='$registration_id' and status=1");
$info_result = $info_status->fetch_assoc();
$info_num  = $info_status->num_rows;
$region_id = $info_result['region_id'];

$comm_status = $conn ->query("select status from communication_details_master where registration_id='$registration_id' and status=1");
$comm_num	 = $comm_status->num_rows;

if($info_num==0 && $comm_num==0)
{ 
	$_SESSION['form_chk_msg']="Please first fill Information form";
	$_SESSION['form_chk_msg1']="Please first fill Communication form";
	header('location:information_form.php');exit;
}
if($comm_num==0)
{ 
	$_SESSION['form_chk_msg1']="Please first fill Communication form";
	header('location:communication_form.php');exit;
}
?>
<?php
$type_of_firm = getTypeofFirm($registration_id,$conn);

//if($type_of_firm=='Proprietory' || $type_of_firm=='Proprietory HUF')
if($type_of_firm==14 || $type_of_firm==15)
{
	$sql1 = "select * from communication_address_master where type_of_address=2 and registration_id=$registration_id";
	$result1   = $conn ->query($sql1);
	$num_rows1 = $result1->num_rows;
	if($num_rows1==0)
	{
	$_SESSION['error_msg1'] = "&bull;&nbsp; Atleast one Head Office address is compulsory";
	}
	
	$sql2 = "select * from  communication_address_master where type_of_address=1 and registration_id=$registration_id";
	$result2 = $conn ->query($sql2);
	$num_rows2 = $result2->num_rows;
	if($num_rows2==0)
	{
	$_SESSION['error_msg2']="&bull;&nbsp; Proprietory address is compulsory";
	}
	
	$sqla = "select * from  communication_address_master where type_of_address=13 and registration_id=$registration_id";
	$resulta = $conn ->query($sqla);
	$num_rowsa = $resulta->num_rows;
	if($num_rowsa==0)
	{
	$_SESSION['error_msgs']="&bull;&nbsp; Authorised Person is compulsory";
	}
	
	if($_SESSION['error_msg1']!="" || $_SESSION['error_msg2']!="" || $_SESSION['error_msgs']!=""){
    header("Location: communication_form.php");
	}
}

if($type_of_firm==11)
{
	$sql1="select * from  communication_address_master where type_of_address='2' and registration_id='$registration_id'";
	$result1   = $conn ->query($sql1);
	$num_rows1 = $result1->num_rows;
	if($num_rows1==0)
	{
	$_SESSION['error_msg1']="&bull;&nbsp; Atleast one Head Office address is compulsory";
	}
	
	$sql2="select * from  communication_address_master where type_of_address='5' and registration_id='$registration_id'";
	$result2 = $conn ->query($sql2);
	$num_rows2 = $result2->num_rows;
	if($num_rows2==0)
	{
	$_SESSION['error_msg2']="&bull;&nbsp; Partner address is compulsory";
	}
	
	$sqla="select * from  communication_address_master where type_of_address=13 and registration_id=$registration_id";
	$resulta = $conn ->query($sqla);
	$num_rowsa = $resulta->num_rows;
	if($num_rowsa==0)
	{
	$_SESSION['error_msgs']="&bull;&nbsp; Authorised Person is compulsory";
	}
	
	if($_SESSION['error_msg1']!="" || $_SESSION['error_msg2']!="" || $_SESSION['error_msgs']!=""){
    header("Location: communication_form.php");
	}
}

if($type_of_firm==13 || $type_of_firm==12)
{
	$sql1="select * from  communication_address_master where type_of_address='2' and registration_id='$registration_id'";
	$result1   = $conn ->query($sql1);
	$num_rows1 = $result1->num_rows;
	if($num_rows1==0)
	{
	echo $_SESSION['error_msg1']="&bull;&nbsp; Atleast one Head Office address is compulsory";
	}	
	
	$sql2="select * from  communication_address_master where type_of_address='6' and registration_id='$registration_id'";
	$result2 = $conn ->query($sql2);
	$num_rows2 = $result2->num_rows;
	if($num_rows2==0)
	{
	 $_SESSION['error_msg2']="&bull;&nbsp; Registered Office address is compulsory";
	}
	
	$sql3="select * from  communication_address_master where type_of_address='7' and registration_id='$registration_id'";
	$result3 = $conn ->query($sql3);
	$num_rows3 = $result3->num_rows;
	if($num_rows3==0)
	{
	 $_SESSION['error_msg3']="&bull;&nbsp; Director address is compulsory";
	}
	
	$sqla="select * from  communication_address_master where type_of_address='13' and registration_id=$registration_id";
	$resulta = $conn ->query($sqla);
	$num_rowsa = $resulta->num_rows;
	if($num_rowsa==0)
	{
	$_SESSION['error_msgs']="&bull;&nbsp; Authorised Person is compulsory";
	}
	
	/*if($member_type_id==6){
	$sql4="select * from  communication_address_master where type_of_address='4' and registration_id='$registration_id'";
	$result4 = $conn ->query($sql4);
	$num_rows4 = $result4->num_rows;
	if($num_rows4==0)
	{
	$_SESSION['error_msg4']="&bull;&nbsp; Factory address is compulsory";
	}
	} */
	if($_SESSION['error_msg1']!="" || $_SESSION['error_msg2']!="" || $_SESSION['error_msg3']!="" || $_SESSION['error_msgs']!=""){
     header("Location: communication_form.php");
	}	
}

if($type_of_firm==18)
{
	$sql1="select * from  communication_address_master where type_of_address=2 and registration_id=$registration_id";
	$result1   = $conn ->query($sql1);
	$num_rows1 = $result1->num_rows;
	if($num_rows1==0)
	{
	$_SESSION['error_msg1']="&bull;&nbsp; Atleast one Head Office address is compulsory";
	}
		
	$sql2="select * from  communication_address_master where type_of_address=8 and registration_id=$registration_id";
	$result2 = $conn ->query($sql2);
	$num_rows2 = $result2->num_rows;
	if($num_rows2==0)
	{
	$_SESSION['error_msg2']="&bull;&nbsp; Individual address is compulsory";
	}
	
	$sqla="select * from  communication_address_master where type_of_address=13 and registration_id=$registration_id";
	$resulta = $conn ->query($sqla);
	$num_rowsa = $resulta->num_rows;
	if($num_rowsa==0)
	{
	$_SESSION['error_msgs']="&bull;&nbsp; Authorised Person is compulsory";
	}
	
	if($_SESSION['error_msg1']!="" || $_SESSION['error_msg2']!="" || $_SESSION['error_msgs']!=""){
    header("Location: communication_form.php");
	}
}

if($type_of_firm==17)
{
	$sql1 = "select * from communication_address_master where type_of_address=2 and registration_id=$registration_id";
	$result1   = $conn ->query($sql1);
	$num_rows1 = $result1->num_rows;
	if($num_rows1==0)
	{
	$_SESSION['error_msg1']="&bull;&nbsp; Atleast one Head Office address is compulsory";
	}
		
	$sql2="select * from  communication_address_master where type_of_address=9 and registration_id=$registration_id";
	$result2 = $conn ->query($sql2);
	$num_rows2 = $result2->num_rows;
	if($num_rows2==0)
	{
	$_SESSION['error_msg2']="&bull;&nbsp; Trustee address is compulsory";
	}
	
	$sqla="select * from  communication_address_master where type_of_address=13 and registration_id=$registration_id";
	$resulta = $conn ->query($sqla);
	$num_rowsa = $resulta->num_rows;
	if($num_rowsa==0)
	{
	$_SESSION['error_msgs']="&bull;&nbsp; Authorised Person is compulsory";
	}
	
	if($_SESSION['error_msg1']!="" || $_SESSION['error_msg2']!="" || $_SESSION['error_msgs']!=""){
    header("Location: communication_form.php");
	}
}

if($type_of_firm==16)
{
	$sql1="select * from  communication_address_master where type_of_address=2 and registration_id=$registration_id";
	$result1   = $conn ->query($sql1);
	$num_rows1 = $result1->num_rows;
	if($num_rows1==0)
	{
	$_SESSION['error_msg1']="&bull;&nbsp; Atleast one Head Office address is compulsory";
	}
	
	$sql2="select * from  communication_address_master where type_of_address=10 and registration_id=$registration_id";
	$result2 = $conn ->query($sql2);
	$num_rows2 = $result2->num_rows;
	if($num_rows2==0)
	{
	$_SESSION['error_msg2']="&bull;&nbsp; CO-OP Society member address is compulsory";
	}
	
	$sqla="select * from  communication_address_master where type_of_address=13 and registration_id=$registration_id";
	$resulta = $conn ->query($sqla);
	$num_rowsa = $resulta->num_rows;
	if($num_rowsa==0)
	{
	$_SESSION['error_msgs']="&bull;&nbsp; Authorised Person is compulsory";
	}
	
	if($_SESSION['error_msg1']!="" || $_SESSION['error_msg2']!="" || $_SESSION['error_msgs']!=""){
    header("Location: communication_form.php");
	}
}

if($type_of_firm==19)
{
	$sql1="select * from  communication_address_master where type_of_address=2 and registration_id=$registration_id";
	$result1   = $conn ->query($sql1);
	$num_rows1 = $result1->num_rows;
	if($num_rows1==0)
	{
	$_SESSION['error_msg1']="&bull;&nbsp; Atleast one Head Office address is compulsory";
	}
	
	$sqla="select * from  communication_address_master where type_of_address=13 and registration_id=$registration_id";
	$resulta = $conn ->query($sqla);
	$num_rowsa = $resulta->num_rows;
	if($num_rowsa==0)
	{
	$_SESSION['error_msgs']="&bull;&nbsp; Authorised Person is compulsory";
	}
	
/*	$sql2="select * from  communication_address_master where type_of_address=11 and registration_id=$registration_id";
	$result2=mysql_query($sql2);
	$num_rows2=mysql_num_rows($result2);
	if($num_rows2==0)
	{
	$_SESSION['error_msg2']="&bull;&nbsp; Other address is compulsory";
	} */
	
	if($_SESSION['error_msg1']!=""  || $_SESSION['error_msgs']!=""){
    header("Location: communication_form.php");
	}
}
?>

<?php
$action=$_REQUEST['action'];
if($action=="update")
{


$registration_id=$_REQUEST['registration_id'];
$gst_holder=$_REQUEST['gst_holder'];
$region_id=$_REQUEST['region_id'];

$dgft_ra_office = filter($_REQUEST['dgft_ra_office']);
$annual_turnover = filter($_REQUEST['annual_turnover']);
$financial_year1 = filter($_REQUEST['financial_year1']);
$financial_year2 = filter($_REQUEST['financial_year2']);
$financial_year3 = filter($_REQUEST['financial_year3']);
$financial_year1_export = filter($_REQUEST['financial_year1_export']);
$financial_year2_export = filter($_REQUEST['financial_year2_export']);
$financial_year3_export = filter($_REQUEST['financial_year3_export']);
$export_sub_total = filter($_REQUEST['export_sub_total']);
$deemed_export_total = filter($_REQUEST['deemed_export_total']);
$exports_total = filter($_REQUEST['exports_total']);
$exports_of_service = filter($_REQUEST['exports_of_service']);
$all_total_exports = filter($_REQUEST['all_total_exports']);

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


$rcmc_no=filter($_REQUEST['rcmc_no']);
$rcmc_issue_date=date('Y-m-d',strtotime($_REQUEST['rcmc_issue_date']));
$rcmc_issue_authority=filter($_REQUEST['rcmc_issue_authority']);
$rcmc_product_of_which=filter($_REQUEST['rcmc_product_of_which']);
$rcmc_expiry=date('Y-m-d',strtotime($_REQUEST['rcmc_expiry'])); 
$rcmc_status=filter($_REQUEST['rcmc_status']);
$rcmc_validity= date('Y-m-d',strtotime($_REQUEST['rcmc_validity']));  
$status_from_epc=filter($_REQUEST['status_from_epc']);


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

   // current challan yr calculation
    $cur_year1 = (int)date('y');
    $cur_month1 = (int)date('m');
    if ($cur_month1 < 4) {
     $cur_fin_yr1 = $cur_year1-1;
	 $cur_finyr1  = $cur_fin_yr1 . '-' . ($cur_fin_yr1+1);
	 $last_finyr1 = ($cur_fin_yr1-1) . '-' . $cur_fin_yr1;
    }
    else {
     $cur_fin_yr1 = $cur_year1;
 	 $cur_finyr1  = $cur_fin_yr1 . '-' . ($cur_fin_yr1+1);
	 $last_finyr1 = ($cur_fin_yr1-1) . '-' . $cur_fin_yr1;
    }

/*.............................Payment data.............................*/



$sql1=$conn ->query("update membership_dgft set dgft_ra_office='$dgft_ra_office',annual_turnover='$annual_turnover',financial_year1='$financial_year1',financial_year2='$financial_year2',financial_year3='$financial_year3',financial_year1_export='$financial_year1_export',financial_year2_export='$financial_year2_export',financial_year3_export='$financial_year3_export',export_sub_total='$export_sub_total',deemed_export_total='$deemed_export_total',exports_total='$exports_total',exports_of_service='$exports_of_service',all_total_exports='$all_total_exports',rcmc_no='$rcmc_no',rcmc_issue_date='$rcmc_issue_date',rcmc_issue_authority='$rcmc_issue_authority',rcmc_product_of_which='$rcmc_product_of_which',rcmc_expiry='$rcmc_expiry',rcmc_status='$rcmc_status', rcmc_validity='$rcmc_validity', status_from_epc='$status_from_epc', export_sales_to_foreign_tourists='$export_sales_to_foreign_tourists',export_synthetic_stones='$export_synthetic_stones',export_costume_jewellery='$export_costume_jewellery',export_other_precious_metal_jewellery='$export_other_precious_metal_jewellery',export_pearls='$export_pearls',export_coloured_gemstones='$export_coloured_gemstones',export_gold_jewellery='$export_gold_jewellery',export_studded_gold_jewellery='$export_studded_gold_jewellery',export_silver_jewellery='$export_silver_jewellery',export_studded_silver_jewellery='$export_studded_silver_jewellery',export_rough_diamonds='$export_rough_diamonds',export_cut_polished_diamonds='$export_cut_polished_diamonds',export_rough_lgd='$export_rough_lgd',export_cut_polished_lgd='$export_cut_polished_lgd',export_other_items='$export_other_items',export_total='$export_total',import_findings_mountings='$import_findings_mountings',import_false_pearls='$import_false_pearls',import_rough_imitation_stones='$import_rough_imitation_stones',import_silver='$import_silver',import_raw_pearls='$import_raw_pearls',import_cut_polished_gemstones='$import_cut_polished_gemstones',import_rough_gemstones='$import_rough_gemstones',import_gold='$import_gold',import_cut_polished_diamonds='$import_cut_polished_diamonds',import_rough_diamonds='$import_rough_diamonds',import_synthetic_stones='$import_synthetic_stones',import_gold_jewellery='$import_gold_jewellery',import_silver_jewellery='$import_silver_jewellery',import_rough_lgd='$import_rough_lgd',import_cut_polished_lgd='$import_cut_polished_lgd',import_other_items='$import_other_items',import_total='$import_total',export_fob_value='$export_fob_value',import_cif_value='$import_cif_value',status='1' where registration_id='$registration_id' and financial_year='$cur_fin_yr'");

if(!$sql1) die ($conn->error);


$_SESSION['succ_msg']="DGFT information updated successfully";

}

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

$sql = "SELECT * FROM `membership_dgft` WHERE 1 and registration_id=$registration_id and financial_year='$cur_fin_yr'";
$result = $conn ->query($sql);
$rows = $result->fetch_assoc();

$rcmc_no  = $rows['rcmc_no'];
$rcmc_issue_date  = $rows['rcmc_issue_date'];
$rcmc_issue_authority  = $rows['rcmc_issue_authority'];
$rcmc_product_of_which  = $rows['rcmc_product_of_which'];
$rcmc_expiry  = $rows['rcmc_expiry'];
$rcmc_status  = $rows['rcmc_status'];
$rcmc_validity  = $rows['rcmc_validity'];
$status_from_epc  = $rows['status_from_epc'];


$dgft_ra_office = filter($rows['dgft_ra_office']);
$annual_turnover = filter($rows['annual_turnover']);
$financial_year1 = filter($rows['financial_year1']);
$financial_year2 = filter($rows['financial_year2']);
$financial_year3 = filter($rows['financial_year3']);
$financial_year1_export = filter($rows['financial_year1_export']);
$financial_year2_export = filter($rows['financial_year2_export']);
$financial_year3_export = filter($rows['financial_year3_export']);
$export_sub_total = filter($rows['export_sub_total']);
$deemed_export_total = filter($rows['deemed_export_total']);
$exports_total = filter($rows['exports_total']);
$exports_of_service = filter($rows['exports_of_service']);
$all_total_exports = filter($rows['all_total_exports']);

$export_sales_to_foreign_tourists=$rows['export_sales_to_foreign_tourists'];
$export_synthetic_stones=$rows['export_synthetic_stones'];
$export_costume_jewellery=$rows['export_costume_jewellery'];
$export_other_precious_metal_jewellery=$rows['export_other_precious_metal_jewellery'];
$export_pearls=$rows['export_pearls'];
$export_coloured_gemstones=$rows['export_coloured_gemstones'];
$export_gold_jewellery=$rows['export_gold_jewellery'];
$export_studded_gold_jewellery=$rows['export_studded_gold_jewellery'];
$export_silver_jewellery=$rows['export_silver_jewellery'];
$export_studded_silver_jewellery=$rows['export_studded_silver_jewellery'];
$export_rough_diamonds=$rows['export_rough_diamonds'];
$export_cut_polished_diamonds=$rows['export_cut_polished_diamonds'];
$export_rough_lgd=$rows['export_rough_lgd'];
$export_cut_polished_lgd=$rows['export_cut_polished_lgd'];
$export_other_items=$rows['export_other_items'];
$export_total=$rows['export_total'];
$import_findings_mountings=$rows['import_findings_mountings'];
$import_false_pearls=$rows['import_false_pearls'];
$import_rough_imitation_stones=$rows['import_rough_imitation_stones'];
$import_silver=$rows['import_silver'];
$import_raw_pearls=$rows['import_raw_pearls'];
$import_cut_polished_gemstones=$rows['import_cut_polished_gemstones'];
$import_rough_gemstones=$rows['import_rough_gemstones'];
$import_gold=$rows['import_gold'];
$import_cut_polished_diamonds=$rows['import_cut_polished_diamonds'];
$import_rough_diamonds=$rows['import_rough_diamonds'];
$import_synthetic_stones=$rows['import_synthetic_stones'];
$import_gold_jewellery=$rows['import_gold_jewellery'];
$import_silver_jewellery=$rows['import_silver_jewellery'];
$import_rough_lgd=$rows['import_rough_lgd'];
$import_cut_polished_lgd=$rows['import_cut_polished_lgd'];
$import_other_items=$rows['import_other_items'];
$import_total=$rows['import_total'];
$export_fob_value=$rows['export_fob_value'];
$import_cif_value=$rows['import_cif_value'];


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DGFT IMPORT / EXPORT Form ||GJEPC||</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />
<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>      
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<!--validation-->
<script src="jsvalidation/jquery.js" type="text/javascript"></script>
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<link rel="stylesheet" type="text/css" media="screen" href="css/cmxform.css" />   
<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>
<!--navigation end-->

<script type="text/javascript">
$().ready(function() {
	$("#commentForm").validate();
	$("#challanForm").validate({
		rules: {   
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
			required:"Please enter silver jewellery",
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
<!--.....................Get And Set value for export.....................-->

<script>
function getexportdata()
{
	var gst_holder = $("input[name='gst_holder']:checked").val();
	var export_sales_to_foreign_tourists=document.getElementById("export_sales_to_foreign_tourists").value;
	if(export_sales_to_foreign_tourists==""){export_sales_to_foreign_tourists=0;}
	var export_synthetic_stones=document.getElementById("export_synthetic_stones").value;
	if(export_synthetic_stones==""){export_synthetic_stones=0;}
	var export_costume_jewellery=document.getElementById("export_costume_jewellery").value;
	if(export_costume_jewellery==""){export_costume_jewellery=0;}
	var export_other_precious_metal_jewellery=document.getElementById("export_other_precious_metal_jewellery").value;
	if(export_other_precious_metal_jewellery==""){export_other_precious_metal_jewellery=0;}
	var export_pearls=document.getElementById("export_pearls").value;
	if(export_pearls==""){export_pearls=0;}
	var export_coloured_gemstones=document.getElementById("export_coloured_gemstones").value;
	if(export_coloured_gemstones==""){export_coloured_gemstones=0;}
	var export_gold_jewellery=document.getElementById("export_gold_jewellery").value;
	if(export_gold_jewellery==""){export_gold_jewellery=0;}
	var export_studded_gold_jewellery=document.getElementById("export_studded_gold_jewellery").value;
	if(export_studded_gold_jewellery==""){export_studded_gold_jewellery=0;}
	var export_silver_jewellery=document.getElementById("export_silver_jewellery").value;
	if(export_silver_jewellery==""){export_silver_jewellery=0;}
	var export_studded_silver_jewellery=document.getElementById("export_studded_silver_jewellery").value;
	if(export_studded_silver_jewellery==""){export_studded_silver_jewellery=0;}
	
	var export_rough_diamonds=document.getElementById("export_rough_diamonds").value;
	if(export_rough_diamonds==""){export_rough_diamonds=0;}
	var export_cut_polished_diamonds=document.getElementById("export_cut_polished_diamonds").value;
	if(export_cut_polished_diamonds==""){export_cut_polished_diamonds=0;}
	var export_rough_lgd=document.getElementById("export_rough_lgd").value;
	if(export_rough_lgd==""){export_rough_lgd=0;}
	var export_cut_polished_lgd=document.getElementById("export_cut_polished_lgd").value;
	if(export_cut_polished_lgd==""){export_cut_polished_lgd=0;}	
	var export_other_items=document.getElementById("export_other_items").value;
	if(export_other_items==""){export_other_items=0;}
		
	var tot_examount=parseInt(export_sales_to_foreign_tourists)+parseInt(export_synthetic_stones)+parseInt(export_costume_jewellery)+parseInt(export_other_precious_metal_jewellery)+parseInt(export_pearls)+parseInt(export_coloured_gemstones)+parseInt(export_gold_jewellery)+parseInt(export_studded_gold_jewellery)+parseInt(export_silver_jewellery)+parseInt(export_studded_silver_jewellery)+parseInt(export_rough_diamonds)+parseInt(export_cut_polished_diamonds)+parseInt(export_rough_lgd)+parseInt(export_cut_polished_lgd)+parseInt(export_other_items);
	
	document.getElementById("export_total").value = tot_examount;
	document.getElementById("export_fob_value").value = tot_examount;
	var registration_id=document.getElementById("registration_id").value;
	
	if(gst_holder=="N" && tot_examount>4000000){
		alert("GST is required as Total export amount is exceeding 40,00,000");
		$("#gst_no").val('');
		$('#gst_holderY').attr('checked',true);
		return false;
	}
	$.ajax({
			   type: "POST",
			   url: "ajax.php",
			   data: "actiontype=paymentdetailsexport&paymentamnt="+tot_examount+"&registration_id="+registration_id+"&gst_holder="+gst_holder,
			   beforeSend: function(){
							$('#preloader').show();
							$('#status').show();
							},
			   success: function(data){ 
			   			//alert(data);return false;
						$('#preloader').hide();
						$('#status').hide();
						var data=data.split("#");
						$('#membership_fees').val(data[0]);
						$('#admission_fees').val(data[1]);
						$('#total').val(data[2]); 
						$('#service_tax').val(data[3]);
						$('#total_payable').val(data[4]);
						}
	   });
	
}
</script>
<!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>-->
<script type="text/javascript">
$(function () {
$('.input_txt1').keydown(function (e) {
if (e.shiftKey || e.ctrlKey || e.altKey) {
e.preventDefault();
} else {
var key = e.keyCode;
if (!((key == 8) || (key == 46) || (key >= 35 && key <= 40) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105))) {
e.preventDefault();
}
}
});
});
</script>

<!--.....................Get And Set value for import.....................-->
<script>
function getimportdata()
{
	var gst_holder = $("input[name='gst_holder']:checked").val();
	var import_findings_mountings=document.getElementById("import_findings_mountings").value;
	if(import_findings_mountings==""){import_findings_mountings=0;}
	
	var import_false_pearls=document.getElementById("import_false_pearls").value;
	if(import_false_pearls==""){import_false_pearls=0;}
	
	var import_rough_imitation_stones=document.getElementById("import_rough_imitation_stones").value;
	if(import_rough_imitation_stones==""){import_rough_imitation_stones=0;}	
	
	var import_silver=document.getElementById("import_silver").value;
	if(import_silver==""){import_silver=0;}	
	
	var import_raw_pearls=document.getElementById("import_raw_pearls").value;
	if(import_raw_pearls==""){import_raw_pearls=0;}	
	
	var import_cut_polished_gemstones=document.getElementById("import_cut_polished_gemstones").value;
	if(import_cut_polished_gemstones==""){import_cut_polished_gemstones=0;}	
	
	var import_rough_gemstones=document.getElementById("import_rough_gemstones").value;
	if(import_rough_gemstones==""){import_rough_gemstones=0;}	
	
	var import_gold=document.getElementById("import_gold").value;
	if(import_gold==""){import_gold=0;}
	var import_cut_polished_diamonds=document.getElementById("import_cut_polished_diamonds").value;
	if(import_cut_polished_diamonds==""){import_cut_polished_diamonds=0;}
	var import_rough_diamonds=document.getElementById("import_rough_diamonds").value;
	if(import_rough_diamonds==""){import_rough_diamonds=0;}
	var import_synthetic_stones=document.getElementById("import_synthetic_stones").value;
	if(import_synthetic_stones==""){import_synthetic_stones=0;}
	var import_gold_jewellery=document.getElementById("import_gold_jewellery").value;
	if(import_gold_jewellery==""){import_gold_jewellery=0;}
	var import_silver_jewellery=document.getElementById("import_silver_jewellery").value;
	if(import_silver_jewellery==""){import_silver_jewellery=0;}	
	var import_rough_lgd=document.getElementById("import_rough_lgd").value;
	if(import_rough_lgd==""){import_rough_lgd=0;}	
	var import_cut_polished_lgd=document.getElementById("import_cut_polished_lgd").value;
	if(import_cut_polished_lgd==""){import_cut_polished_lgd=0;}	
	var import_other_items=document.getElementById("import_other_items").value;
	if(import_other_items==""){import_other_items=0;}
	
	var tot_imamount=parseInt(import_findings_mountings)+parseInt(import_false_pearls)+parseInt(import_rough_imitation_stones)+parseInt(import_silver)+parseInt(import_raw_pearls)+parseInt(import_cut_polished_gemstones)+parseInt(import_rough_gemstones)+parseInt(import_gold)+parseInt(import_cut_polished_diamonds)+parseInt(import_rough_diamonds)+parseInt(import_synthetic_stones)+parseInt(import_gold_jewellery)+parseInt(import_silver_jewellery)+parseInt(import_rough_lgd)+parseInt(import_cut_polished_lgd)+parseInt(import_other_items);
	
	document.getElementById("import_total").value = tot_imamount;
	document.getElementById("import_cif_value").value = tot_imamount;
	
	export_amnt=document.getElementById("export_fob_value").value;
	
	if(gst_holder=="N" && export_amnt>4000000){
		alert("GST is required as Total export amount is exceeding 40,00,000");
		$("#gst_no").val('');
		$('#gst_holderY').attr('checked',true); 
		return false;
	}
	
		$.ajax({
			   type: "POST",
			   url: "ajax.php",
			   data: "actiontype=paymentdetailsimport&paymentamnt_import="+tot_imamount+"&export_amnt="+export_amnt+"&gst_holder="+gst_holder,
			   beforeSend: function(){
							$('#preloader').show();
							$('#status').show();
							},
			   success: function(data){ //alert(data);
						$('#preloader').hide();
						$('#status').hide();
						var data=data.split("#");
						$('#membership_fees').val(data[0]);
						$('#admission_fees').val(data[1]);
						$('#ad_valorem').val(data[2]);
						$('#total').val(data[3]); 
						$('#service_tax').val(data[4]);
						$('#total_payable').val(data[5]);
						}
	   });	
}
</script>

<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	$('#cheque_date').datepick();
	$('#sap_push_date').datepick();
	
	$('#rcmc_issue_date').datepick();
	$('#rcmc_expiry').datepick();
	$('#rcmc_validity').datepick();

});
</script>
<style>
#preloader {
    position: fixed;
    background-color: #fff;
    z-index: 99999;
    width: 100%;
    height: 100%;
    overflow: hidden;
	display:none;
	
}
#status {
    width: 150px;
    height: 150px;
	position:absolute;
	top:50%;
	left:50%;
	transform: translate(-50%,-50%);
	display:none;
}
</style>
</head>

<body>
<div id="preloader">
	<div class="d-flex justify-content-center h-100">
    <div id="status" class="align-self-center"><img src="../assets/images/loader.gif"></div>
    </div>
</div>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Membership > Challan Form</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">DGFT  FORM
        <div style="float:right; padding-right:10px; font-size:12px;"><a href="membership.php">Back to Search Membership</a></div>
    	</div>
    	
<form action="" method="post" id="challanForm" name="challanForm">
<div class="content_details1">
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";

if($_SESSION['form_chk_msg']!=""){
echo "<span class='notification n-attention'>".$_SESSION['form_chk_msg']."</span>";
$_SESSION['form_chk_msg']="";
}
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt">
    <tr class="orange1">
    <td colspan="5" >RCMC Details </td>
    </tr>
    <tr>
	  <td colspan="3"><strong>DGFT RA office: <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="" name="dgft_ra_office" id="dgft_ra_office" value="<?php echo $dgft_ra_office;?>"  /></td>
	</tr>
	 <tr>
	  <td colspan="3"><strong>Annual Turnover : <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="annual_turnover" id="annual_turnover" value="<?php echo $annual_turnover;?>"  /></td>
	</tr>
	 <tr>
	  <td colspan="3"><strong>Financial Year 1 - <?php echo $financial_year1;?>: <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="financial_year1_export" id="financial_year1_export" value="<?php echo $financial_year1_export;?>"  /></td>
	</tr>
	<tr>
	  <td colspan="3"><strong>Financial Year 2 - <?php echo $financial_year2;?> : <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="financial_year2_export" id="financial_year2_export" value="<?php echo $financial_year2_export;?>"  /></td>
	</tr>
	<tr>
	  <td colspan="3"><strong>Financial Year 3 - <?php echo $financial_year3;?> : <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="financial_year3_export" id="financial_year3_export" value="<?php echo $financial_year3_export;?>"  /></td>
	</tr>
	 <tr>
	  <td colspan="3"><strong>Export sub total : <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="export_sub_total" id="export_sub_total" value="<?php echo $export_sub_total;?>"  /></td>
	</tr>
	 <tr>
	  <td colspan="3"><strong>Deemed export total : <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="deemed_export_total" id="deemed_export_total" value="<?php echo $deemed_export_total;?>"  /></td>
	</tr>
	<tr>
	  <td colspan="3"><strong>Exports total : <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="exports_total" id="exports_total" value="<?php echo $exports_total;?>"  /></td>
	</tr>

	<tr>
	  <td colspan="3"><strong>Exports of service : <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="exports_of_service" id="exports_of_service" value="<?php echo $exports_of_service;?>"  /></td>
	</tr>
	<tr>
	  <td colspan="3"><strong>All total exports : <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="all_total_exports" id="all_total_exports" value="<?php echo $all_total_exports;?>"  /></td>
	</tr>
	
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt">
    <tr class="orange1">
    <td colspan="5" >RCMC Details </td>
    </tr>
    <tr>
	  <td colspan="3"><strong>RCMC No: <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt" name="rcmc_no" id="rcmc_no" value="<?php echo $rcmc_no;?>"  /></td>
	</tr>
	 <tr>
	  <td colspan="3"><strong>Issue Date : <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="rcmc_issue_date" id="rcmc_issue_date" value="<?php echo $rcmc_issue_date;?>"  /></td>
	</tr>
	 <tr>
	  <td colspan="3"><strong>Issue Authority : <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="rcmc_issue_authority" id="rcmc_issue_authority" value="<?php echo $rcmc_issue_authority;?>"  /></td>
	</tr>
	 <tr>
	  <td colspan="3"><strong>Product Of Which Registered : <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="rcmc_product_of_which" id="rcmc_product_of_which" value="<?php echo $rcmc_product_of_which;?>"  /></td>
	</tr>
	 <tr>
	  <td colspan="3"><strong>Expiry Date : <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="rcmc_expiry" id="rcmc_expiry" value="<?php echo $rcmc_expiry;?>"  /></td>
	</tr>
	<tr>
	  <td colspan="3"><strong>RCMC Status : <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="rcmc_status" id="rcmc_status" value="<?php echo $rcmc_status;?>"  /></td>
	</tr>
	<tr>
	  <td colspan="3"><strong>Validity Period : <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="rcmc_validity" id="rcmc_validity" value="<?php echo $rcmc_validity;?>"  /></td>
	</tr>
	<tr>
	  <td colspan="3"><strong>Status From EPC : <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="status_from_epc" id="status_from_epc" value="<?php echo $status_from_epc;?>"  /></td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt">
    <tr class="orange1">
    	<td colspan="14" >Export Performance Details</td>
    </tr>
    
    <tr>
	  <td colspan="3"><strong>Coloured Gemstones: <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="export_coloured_gemstones" id="export_coloured_gemstones" value="<?php echo $export_coloured_gemstones;?>" onkeyup="getexportdata()" onfocus="if(this.value=='0')value='';" onblur="if(this.value=='')value='0';"/></td>
	</tr>
    <tr>
	  <td colspan="3"><strong>Costume/Fashion Jewellery: <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="export_costume_jewellery" id="export_costume_jewellery" value="<?php echo $export_costume_jewellery;?>" onkeyup="getexportdata()" onfocus="if(this.value=='0')value='';" onblur="if(this.value=='')value='0';"/></td>
	</tr>    
    <tr>
	<td colspan="3"><strong>Cut & Polished Diamonds:<span class="star">*</span></strong></td>
	<td colspan="2"><input type="text" class="input_txt1" name="export_cut_polished_diamonds" id="export_cut_polished_diamonds" value="<?php echo $export_cut_polished_diamonds;?>" onkeyup="getexportdata()" onfocus="if(this.value=='0')value='';" onblur="if(this.value=='')value='0';"/></td>
	</tr>    
    <tr>
	<td colspan="3"><strong>Plain Gold Jewellery:  <span class="star">*</span></strong></td>
	<td colspan="2"><input type="text" class="input_txt1" name="export_gold_jewellery" id="export_gold_jewellery" value="<?php echo $export_gold_jewellery;?>" onkeyup="getexportdata()" onfocus="if(this.value=='0')value='';" onblur="if(this.value=='')value='0';"/></td>
	</tr>
	<tr >
	<td colspan="3"><strong>Studded Gold Jewellery: <span class="star">*</span></strong></td>
	<td colspan="2"><input type="text" class="input_txt1" name="export_studded_gold_jewellery" id="export_studded_gold_jewellery" value="<?php echo $export_studded_gold_jewellery;?>" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onblur="if(this.value=='')value='0';"/></td>
	</tr>
    <tr>
	<td colspan="3"><strong>Plain Silver Jewellery:  <span class="star">*</span></strong></td>
	<td colspan="2"><input type="text" class="input_txt1" name="export_silver_jewellery" id="export_silver_jewellery" value="<?php echo $export_silver_jewellery;?>" onkeyup="getexportdata()" onfocus="if(this.value=='0')value='';" onblur="if(this.value=='')value='0';"/></td>
	</tr>    
	<tr>
	<td colspan="3"><strong>Studded Silver Jewellery: <span class="star">*</span></td>
	<td colspan="2"><input type="text" class="input_txt1" name="export_studded_silver_jewellery" id="export_studded_silver_jewellery" value="<?php echo $export_studded_silver_jewellery;?>" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/></td>
	</tr>
    <tr>
	<td colspan="3"><strong>Other Precious Metal Jewellery: <span class="star">*</span></strong></td>
	<td colspan="2"><input type="text" class="input_txt1" name="export_other_precious_metal_jewellery" id="export_other_precious_metal_jewellery" value="<?php echo $export_other_precious_metal_jewellery;?>" onkeyup="getexportdata()" onfocus="if(this.value=='0')value='';" onblur="if(this.value=='')value='0';" /></td>
	</tr>    
    <tr>
	<td colspan="3"><strong>Pearls: <span class="star">*</span></strong></td>
	<td colspan="2"><input type="text" class="input_txt1" name="export_pearls" id="export_pearls" value="<?php echo $export_pearls; ?>" onkeyup="getexportdata()" onfocus="if(this.value=='0')value='';" onblur="if(this.value=='')value='0';"/></td>
	</tr>    
    <tr>
	<td colspan="3"><strong>Rough Diamonds: <span class="star">*</span></strong></td>
	<td colspan="2"><input type="text" class="input_txt1" name="export_rough_diamonds" id="export_rough_diamonds" value="<?php echo $export_rough_diamonds;?>" onkeyup="getexportdata()" onfocus="if(this.value=='0')value='';" onblur="if(this.value=='')value='0';"/></td>
	</tr>    
    <tr>
	<td colspan="3"><strong>Sales to Foreign Tourists: <span class="star">*</span></strong></td>
	<td width="65%" colspan="2">
    <input type="text" class="input_txt1" name="export_sales_to_foreign_tourists" id="export_sales_to_foreign_tourists" value="<?php echo $export_sales_to_foreign_tourists;?>" onkeyup="getexportdata()" onfocus="if(this.value=='0')value='';" onblur="if(this.value=='')value='0';" /></td>
	</tr>
	
	<tr>
	<td colspan="3"><strong>Synthetic Stones: <span class="star">*</span></strong></td>
	<td colspan="2"><input type="text" class="input_txt1" name="export_synthetic_stones" id="export_synthetic_stones" value="<?php echo $export_synthetic_stones;?>" onkeyup="getexportdata()" onfocus="if(this.value=='0')value='';" onblur="if(this.value=='')value='0';"/></td>
	</tr>
	
	<tr>
	<td colspan="3"><strong>Rough Lab Grown Diamond: <span class="star">*</span></strong></td>
	<td colspan="2"><input type="text" class="input_txt1" name="export_rough_lgd" id="export_rough_lgd" value="<?php echo $export_rough_lgd;?>" onkeyup="getexportdata()" onfocus="if(this.value=='0')value='';" onblur="if(this.value=='')value='0';"/></td>
	</tr>
	
	<tr>
	<td colspan="3"><strong>Cut & Polished Lab Grown Diamond: <span class="star">*</span></strong></td>
	<td colspan="2"><input type="text" class="input_txt1" name="export_cut_polished_lgd" id="export_cut_polished_lgd" value="<?php echo $export_cut_polished_lgd;?>" onkeyup="getexportdata()" onfocus="if(this.value=='0')value='';" onblur="if(this.value=='')value='0';"/></td>
	</tr>
	
	<tr>
	<td colspan="3"><strong>Other Items : <span class="star">*</span></strong></td>
	<td colspan="2"><input type="text" class="input_txt1" name="export_other_items" id="export_other_items" value="<?php echo $export_other_items; ?>" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/></td>
	</tr>    
    
   	<tr>
	  <td colspan="3"><strong>Total: <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="export_total" id="export_total" value="<?php echo $export_total;?>" /></td>
	</tr>
    
  </table>
    </div>
	<div class="content_details1">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
	<tr class="orange1">
    <td colspan="14" >Import Performance Details</td>
    </tr>    
    <tr>
	  <td colspan="3"><strong>Cut & Polished Diamonds:<span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="import_cut_polished_diamonds" id="import_cut_polished_diamonds" value="<?php echo $import_cut_polished_diamonds;?>" onkeyup="getimportdata()" onfocus="if(this.value=='0')value='';" onblur="if(this.value=='')value='0';"/></td>
	</tr>
    
    <tr>
	  <td colspan="3"><strong>Cut & Polished Gemstones: <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="import_cut_polished_gemstones" id="import_cut_polished_gemstones" value="<?php echo $import_cut_polished_gemstones; ?>" onkeyup="getimportdata()" onfocus="if(this.value=='0')value='';" onblur="if(this.value=='')value='0';"/></td>
	</tr>	
	<tr>
	  <td colspan="3"><strong>Processed & Finished Pearls: <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="import_false_pearls" id="import_false_pearls" value="<?php echo $import_false_pearls; ?>" onkeyup="getimportdata()" onfocus="if(this.value=='0')value='';" onblur="if(this.value=='')value='0';"/></td>
	</tr>    
    <tr>
	  <td colspan="3"><strong>Findings & Mountings: <span class="star">*</span></strong></td>
	  <td width="65%" colspan="2"><input type="text" class="input_txt1" name="import_findings_mountings" id="import_findings_mountings" value="<?php echo $import_findings_mountings;?>" onkeyup="getimportdata()" onfocus="if(this.value=='0')value='';" onblur="if(this.value=='')value='0';" /></td>
	</tr>	
    <tr>
	  <td colspan="3"><strong>Gold Bar: <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="import_gold" id="import_gold" value="<?php echo $import_gold;?>" onkeyup="getimportdata()" onfocus="if(this.value=='0')value='';" onblur="if(this.value=='')value='0';"/></td>
	</tr>    
    <tr>
	  <td colspan="3"><strong>Raw Pearls: <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="import_raw_pearls" id="import_raw_pearls" value="<?php echo $import_raw_pearls;?>" onkeyup="getimportdata()" onfocus="if(this.value=='0')value='';" onblur="if(this.value=='')value='0';"/></td>
	</tr>
    <tr>
	  <td colspan="3"><strong>Rough Diamonds:<span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="import_rough_diamonds" id="import_rough_diamonds" value="<?php echo $import_rough_diamonds;?>" onkeyup="getimportdata()" onfocus="if(this.value=='0')value='';" onblur="if(this.value=='')value='0';"/></td>
	</tr>    
    <tr>
	  <td colspan="3"><strong>Rough Gemstones: <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="import_rough_gemstones" id="import_rough_gemstones" value="<?php echo $import_rough_gemstones;?>" onkeyup="getimportdata()" onfocus="if(this.value=='0')value='';" onblur="if(this.value=='')value='0';"/></td>
	</tr>    
    <tr>
	  <td colspan="3"><strong>Rough Imitation Stones, Glass Beads/ Glass Chattons: <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="import_rough_imitation_stones" id="import_rough_imitation_stones" value="<?php echo $import_rough_imitation_stones; ?>" onkeyup="getimportdata()" onfocus="if(this.value=='0')value='';" onblur="if(this.value=='')value='0';"/></td>
	</tr>
    <tr>
	  <td colspan="3"><strong>Silver, Platinum, Palladium: <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="import_silver" id="import_silver" value="<?php echo $import_silver; ?>" onkeyup="getimportdata()" onfocus="if(this.value=='0')value='';" onblur="if(this.value=='')value='0';"/></td>
	</tr>
    <tr>
	  <td colspan="3"><strong>Synthetic stones:  <span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="import_synthetic_stones" id="import_synthetic_stones" value="<?php echo $import_synthetic_stones; ?>" onkeyup="getimportdata()" onfocus="if(this.value=='0')value='';" onblur="if(this.value=='')value='0';"/></td>
	</tr>
    
	<tr>
	<td colspan="3"><strong>Gold Jewellery: <span class="star">*</span></strong></td>
	<td colspan="2"><input type="text" class="input_txt1" name="import_gold_jewellery" id="import_gold_jewellery" value="<?php echo $import_gold_jewellery; ?>" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/></td>
	</tr>

	<tr>
	<td colspan="3"><strong>Silver Jewellery: <span class="star">*</span></strong></td>
	<td colspan="2"><input type="text" class="input_txt1" name="import_silver_jewellery" id="import_silver_jewellery" value="<?php echo $import_silver_jewellery; ?>" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/></td>
	</tr>
	
	<tr>
	<td colspan="3"><strong>Rough Lab Grown Diamond: <span class="star">*</span></strong></td>
	<td colspan="2"><input type="text" class="input_txt1" name="import_rough_lgd" id="import_rough_lgd" value="<?php echo $import_rough_lgd; ?>" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/></td>
	</tr>
	
	<tr>
	<td colspan="3"><strong>Cut & Polished Lab Grown Diamond: <span class="star">*</span></strong></td>
	<td colspan="2"><input type="text" class="input_txt1" name="import_cut_polished_lgd" id="import_cut_polished_lgd" value="<?php echo $import_cut_polished_lgd; ?>" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/></td>
	</tr>
	
	<tr>
	<td colspan="3"><strong>Other Items : <span class="star">*</span></strong></td>
	<td colspan="2"><input type="text" class="input_txt1" name="import_other_items" id="import_other_items" value="<?php echo $import_other_items; ?>" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/></td>
	</tr>
    <tr>
	  <td colspan="3"><strong>Total:<span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="import_total" id="import_total" value="<?php echo $import_total;?>" readonly="readonly"/></td>
	</tr>    
    <tr>
	  <td colspan="3"><strong>F.O.B value of exports:<span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="export_fob_value" id="export_fob_value" value="<?php echo $export_fob_value;?>" readonly="readonly"/></td>
	</tr>    
   	<tr>
	  <td colspan="3"><strong>C.I.F value of imports:<span class="star">*</span></strong></td>
	  <td colspan="2"><input type="text" class="input_txt1" name="import_cif_value" id="import_cif_value" value="<?php echo $import_cif_value;?>" readonly="readonly"/></td>
	</tr>   
    
  </table>
      </div>
      
    
 

	<div style="padding-left:10px; margin-top:5px;">
    <input type="hidden" name="action" value="update" />
   
    <input type="hidden" name="registration_id" id="registration_id" value="<?php echo $registration_id;?>" />
    <input type="hidden" name="region_id" id="region_id" value="<?php echo $region_id;?>" />
    	<input type="submit" value="Update" class="input_submit"/>
        <a href="approval_form.php?registration_id=<?php echo $_REQUEST['registration_id'];?>"><div class="button">Previous</div></a>
     <!--    <a href="approval_form.php?registration_id=<?php echo $_REQUEST['registration_id'];?>"><div class="button">Next</div></a> -->
     </div>	
    </form>
    </div>
  </div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>
