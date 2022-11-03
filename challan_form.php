<?php
include 'include-new/header.php';
if(!isset($_SESSION['USERID'])){ header('location:login.php'); exit; }
include 'db.inc.php';
include 'functions.php';
?>
<?php 
$registration_id = intval(filter($_SESSION['USERID']));

$eligible_for_renewal = eligible_for_renewal($_SESSION['USERID'],$conn);
if($eligible_for_renewal=="Y"){
	echo "<script type='text/javascript'> alert('You are a Renewal Member');
		window.location.href='challan_form_renew.php';
		</script>";
		return;	exit;
}
/*.....................Update the payment status................*/
include 'indivisual_payment_status_update.php';

$info_status = $conn ->query("select a.company_pan_no as `pan_no`,a.company_gstn as gst_no,b.status,region_id,b.member_type_id from registration_master
 a, information_master b where a.id='$registration_id'  and b.registration_id='$registration_id' and b.status=1");
$info_num = $info_status->num_rows;
$info_result = $info_status->fetch_assoc();

$pan_no	= str_replace(' ','',strtoupper(filter($info_result['pan_no'])));
$gst_no	= str_replace(' ','',strtoupper(filter($info_result['gst_no'])));
$region_id		=	$info_result['region_id'];
$member_type_id	=  $info_result['member_type_id'];

if(empty($gst_no) || $gst_no=="NULL"){
$comm_gststatus = $conn ->query("SELECT gst_no FROM communication_address_master WHERE registration_id = '$registration_id' AND type_of_address='2' limit 1");
$comm_GSTresult = $comm_gststatus->fetch_assoc();
$gst_no	= str_replace(' ','',strtoupper(filter($comm_GSTresult['gst_no'])));	
}

$comm_status = $conn ->query("select status from communication_details_master where registration_id='$registration_id' and status=1");
$comm_num = $comm_status->num_rows;
/*..................................Check Required contact information..............................*/
	$con_sql="SELECT * FROM gjepclivedatabase.other_contact_detail where registration_id='".$registration_id."' and (dept='Marketing' || dept='Finance')";
	$con_result = $conn ->query($con_sql);
	$con_count  = $con_result->num_rows;

if($info_num==0 && $comm_num==0){ 
	$_SESSION['form_chk_msg']="Please first fill Information form";
	$_SESSION['form_chk_msg1']="Please first fill Communication form";
	header('location:information_form.php'); exit;
}
if($comm_num==0){ 
	$_SESSION['form_chk_msg1']="Please first fill Communication form";
	header('location:communication_form.php'); exit;
}
if($con_count==0){
	$_SESSION['form_chk_msg']="Marketing & Finance contact information is compulsory";
	header('location:information_form.php'); exit;
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
	$num_rows2 = $result1->num_rows;
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

//if($type_of_firm=='Partnership')
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
	$num_rows2 = $result1->num_rows;
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

//if($type_of_firm=='Private Ltd' || $type_of_firm=='Public Ltd')
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
	
	$sqla="select * from  communication_address_master where type_of_address=13 and registration_id=$registration_id";
	$resulta = $conn ->query($sqla);
	$num_rowsa = $resulta->num_rows;
	if($num_rowsa==0)
	{
	$_SESSION['error_msgs']="&bull;&nbsp; Authorised Person is compulsory";
	}
	
	if($member_type_id==6){
	$sql4="select * from  communication_address_master where type_of_address='4' and registration_id='$registration_id'";
	$result4 = $conn ->query($sql4);
	$num_rows4 = $result4->num_rows;
	if($num_rows4==0)
	{
	$_SESSION['error_msg4']="&bull;&nbsp; Factory address is compulsory";
	}
	}
	if($_SESSION['error_msg1']!="" || $_SESSION['error_msg2']!="" || $_SESSION['error_msg3']!="" || $_SESSION['error_msg4']!="" || $_SESSION['error_msgs']!=""){
     header("Location: communication_form.php");
	}	
}

//if($type_of_firm=='Individual')
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

//if($type_of_firm=='Trustees')
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

//if($type_of_firm=='Co-Op Society')
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

//if($type_of_firm=='Others')
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
	
	if($_SESSION['error_msg1']!="" || $_SESSION['error_msg2']!="" || $_SESSION['error_msgs']!=""){
    header("Location: communication_form.php");
	}
}
?>

<?php
// current challan yr calculation
    $cur_year = (int)date('y');
	$curyear  = (int)date('Y');
    $cur_month = (int)date('m');
    if ($cur_month < 4) {
     $cur_fin_yr = $curyear-1;
	 $cur_fin_yr1= $cur_year-1;
	 $cur_finyr  = $cur_fin_yr1 . '-' . ($cur_fin_yr1+1);
	 $last_finyr= ($cur_fin_yr1-1) . '-' . $cur_fin_yr1;
    }
    else {
     $cur_fin_yr = $curyear;
 	 $cur_fin_yr1= $cur_year;
	 $cur_finyr  = $cur_fin_yr1 . '-' . ($cur_fin_yr1+1);
	 $last_finyr = ($cur_fin_yr1-1) . '-' . $cur_fin_yr1;
    }

$action=$_REQUEST['action'];
if($action=="update")
{
$registration_id = intval($_REQUEST['registration_id']);
$region_id	=	filter($_REQUEST['region_id']);
$gst_holder_status=$_REQUEST['gst_holder'];
$e_sanchit_status=$_REQUEST['e_sanchit_status'];
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
$export_imitation_jewellery=$_REQUEST['export_imitation_jewellery'];
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
$import_imitation_jewellery=$_REQUEST['import_imitation_jewellery'];
$import_other_items=$_REQUEST['import_other_items'];
$import_total=$_REQUEST['import_total'];
$export_fob_value=$_REQUEST['export_fob_value'];
$import_cif_value=$_REQUEST['import_cif_value'];
$ip_address=$_SERVER['REMOTE_ADDR'];

/*............................. SAVE PAN & GST NO START .............................*/
$gst_no = filter(strtoupper($_REQUEST['gst_no']));
$pan_no = filter(strtoupper($_REQUEST['pan_no']));

$getsqlx = $conn ->query("select gst_no,pan_no from information_master where pan_no='$pan_no' AND gst_no='$gst_no' AND registration_id='$registration_id' and status='1'");
$countx = $getsqlx->num_rows;
if($countx>0)
{
	$commUpdatex = "UPDATE `communication_address_master` SET gst_no='$gst_no' where registration_id='$registration_id' AND type_of_address='2' limit 1";
	$comResultx =  $conn ->query($commUpdatex);
	
	$gstUpdatex = "UPDATE `information_master` SET pan_no='$pan_no', gst_no='$gst_no',e_sanchit_status='$e_sanchit_status' where registration_id='$registration_id'";
	$gstResultx =  $conn ->query($gstUpdatex);
} else {
	$commUpdatex = "UPDATE `communication_address_master` SET gst_no='$gst_no' where registration_id='$registration_id' AND type_of_address='2' limit 1";
	$comResultx =  $conn ->query($commUpdatex);
	
	$gstUpdatex = "UPDATE `information_master` SET pan_no='$pan_no', gst_no='$gst_no',e_sanchit_status='$e_sanchit_status' where registration_id='$registration_id'"; 
	$gstResultx =  $conn ->query($gstUpdatex);
}
/*............................. SAVE PAN & GST NO END   .............................*/ 

/*............................. Update Pan in registraiton Table Start .............................*/
$getsqlx1 = "SELECT * FROM  `registration_master` WHERE  `company_pan_no` = '$pan_no' limit 1";
$gstx1 =  $conn ->query($getsqlx1);
$countx1 = $gstx1->num_rows;
if($countx1==0)
$uregistration1 =  $conn ->query("UPDATE `registration_master` SET company_pan_no='$pan_no' where id='$registration_id'");

/*............................. Update Pan in registraiton Table End .............................*/

/*.............................Payment data.............................*/
$gjepc_account_no	=	filter($_REQUEST['gjepc_account_no']);
$payment_mode		=	$_REQUEST['payment_mode'];
$membership_fees	=	$_REQUEST['membership_fees'];
$admission_fees		=	$_REQUEST['admission_fees'];
$ad_valorem=0;

if($admission_fees==0 && $gst_holder_status=="Y"){
echo "<script type='text/javascript'> alert('Something issue in Admission fee');
		window.location.href='challan_form.php';
		</script>";
		return;	exit;
}

/* Membership Fee Calculation Check Start */
if($gst_holder_status=="Y"){
$query = $conn ->query("select export_start_amount,export_end_amount,membership_fee from export_amount_master where status=1 and financial_year='$cur_fin_yr'");
if(!$query) die ($conn->error);
	while($result = $query->fetch_assoc())
	{ 	
		if($export_fob_value>=$result['export_start_amount'] && $export_fob_value<=$result['export_end_amount'])
		{
			$membershipfeesData = $result['membership_fee'];	
			if($membershipfeesData!=$membership_fees){
			echo "<script type='text/javascript'> alert('Issue In Membership Fee.Kindly Contact Admin');
			window.location.href='challan_form.php';
			</script>";
			return;	exit;
			}
		}
	}
}
/* Membership Fee Calculation Check Stop*/

if($export_fob_value=="0")
{	
	$qfees = $conn ->query("select membership_fee,admission_fee from export_amount_master where financial_year='$cur_fin_yr' and export_start_amount=0 and status=1");
	$rfees = $qfees->fetch_assoc();
	$membership_fees = $rfees['membership_fee'];
	$admission_fees  = $rfees['admission_fee'];
}

$total			=	trim($_REQUEST['total']);
$service_tax	=	trim($_REQUEST['service_tax']);
$total_payable	=	trim($_REQUEST['total_payable']);
$bank_name	=	filter(strtoupper($_REQUEST['bank_name']));
$branch_name= 	filter(strtoupper($_REQUEST['branch_name']));
$branch_city=	filter(strtoupper($_REQUEST['branch_city']));
$branch_postal_code= filter($_REQUEST['branch_postal_code']);
$cheque_no=	filter($_REQUEST['cheque_no']);
$cheque_date=$_REQUEST['cheque_date'];
$payment_id=$_REQUEST['payment_id'];
$declaration=$_REQUEST['declaration'];
$post_date=date('Y-m-d');

/* Upload Upload Cheque/DD scan copy Start */
		if(isset($_FILES['cheque_dd_scan_copy']) && $_FILES['cheque_dd_scan_copy']['name']!="")
		{
			$file_name=$_FILES['cheque_dd_scan_copy']['name'];
			$file_temp=$_FILES['cheque_dd_scan_copy']['tmp_name'];
			$file_type=$_FILES['cheque_dd_scan_copy']['type'];
			$file_size=$_FILES['cheque_dd_scan_copy']['size'];
			$attach=rand();
			if($_FILES['cheque_dd_scan_copy']['name']!="")
			{
				$cheque_dd_scan_copy=upload_cheque_dd_scan($file_name,$file_temp,$file_type,$file_size,$attach,"cheque_dd_scan_copy");
			}
		}
		/* Upload Upload Cheque/DD scan copy Stop */

$queryc = $conn ->query("select * from challan_master where registration_id='$registration_id' and challan_financial_year='$cur_fin_yr' order by id desc limit 0,1");
$num = $queryc->num_rows;
if($num>0)
{
$_SESSION['ReferenceNo']=$ReferenceNo=rand(100,9999999).time();
$clog = $conn ->query("insert into challan_payment_log set registration_id='$registration_id',ReferenceNo='$ReferenceNo',post_date='$post_date'");

$sql1="update challan_master set gst_holder_status='$gst_holder_status',export_sales_to_foreign_tourists='$export_sales_to_foreign_tourists',export_synthetic_stones='$export_synthetic_stones',export_costume_jewellery='$export_costume_jewellery',export_other_precious_metal_jewellery='$export_other_precious_metal_jewellery',export_pearls='$export_pearls',export_coloured_gemstones='$export_coloured_gemstones',export_gold_jewellery='$export_gold_jewellery',export_studded_gold_jewellery='$export_studded_gold_jewellery',export_silver_jewellery='$export_silver_jewellery',export_studded_silver_jewellery='$export_studded_silver_jewellery',export_rough_diamonds='$export_rough_diamonds',export_cut_polished_diamonds='$export_cut_polished_diamonds',export_rough_lgd='$export_rough_lgd',export_cut_polished_lgd='$export_cut_polished_lgd',export_imitation_jewellery='$export_imitation_jewellery',export_other_items='$export_other_items',export_total='$export_total',import_findings_mountings='$import_findings_mountings',import_false_pearls='$import_false_pearls',import_rough_imitation_stones='$import_rough_imitation_stones',import_silver='$import_silver',import_raw_pearls='$import_raw_pearls',import_cut_polished_gemstones='$import_cut_polished_gemstones',import_rough_gemstones='$import_rough_gemstones',import_gold='$import_gold',import_cut_polished_diamonds='$import_cut_polished_diamonds',import_rough_diamonds='$import_rough_diamonds',import_synthetic_stones='$import_synthetic_stones',import_gold_jewellery='$import_gold_jewellery',import_silver_jewellery='$import_silver_jewellery',import_rough_lgd='$import_rough_lgd',import_cut_polished_lgd='$import_cut_polished_lgd',import_imitation_jewellery='$import_imitation_jewellery',import_other_items='$import_other_items',import_total='$import_total',export_fob_value='$export_fob_value',import_cif_value='$import_cif_value',gjepc_account_no='$gjepc_account_no',payment_mode='$payment_mode',membership_fees='$membership_fees',admission_fees='$admission_fees',ad_valorem='$ad_valorem',total='$total',service_tax='$service_tax',total_payable='$total_payable',bank_name='$bank_name',branch_name='$branch_name',branch_city='$branch_city',branch_postal_code='$branch_postal_code',cheque_no='$cheque_no',cheque_date='$cheque_date',cheque_dd_scan_copy='$cheque_dd_scan_copy',ReferenceNo='$ReferenceNo',declaration='$declaration',status='1',post_date='$post_date',ip_address='$ip_address' where registration_id='$registration_id' and challan_financial_year='$cur_fin_yr'";
$xresult = $conn ->query($sql1);
if (!$xresult) die ($conn->error);
}
else
{
	/*...........................Fetch challan no. .......................................*/
	$_SESSION['ReferenceNo']=$ReferenceNo=rand(100,9999999).time();
	$log2 = $conn ->query("insert into challan_payment_log set registration_id='$registration_id',ReferenceNo='$ReferenceNo',post_date='$post_date'");
	
	$getRegion = $conn ->query("SELECT challan_region_no FROM challan_master WHERE  challan_region_name = '$region_id' AND challan_financial_year = '$cur_fin_yr' ORDER BY id desc limit 1");
	$last_challan_no =  $getRegion->fetch_assoc();
	
    $region_code 	= $region_id;
   	$last_challan_no= $last_challan_no['challan_region_no'];
    
	$sequence = substr($last_challan_no, 10);
	$next_sequence = sprintf('%04d', $sequence + 1);
	$challan_no = substr($region_code, 3,3) . '/' .$cur_finyr. '/' . $next_sequence;
	
	$sql="insert into challan_master set gcode='N',registration_id='$registration_id',gst_holder_status='$gst_holder_status',export_sales_to_foreign_tourists='$export_sales_to_foreign_tourists',export_synthetic_stones='$export_synthetic_stones',export_costume_jewellery='$export_costume_jewellery',export_other_precious_metal_jewellery='$export_other_precious_metal_jewellery',export_pearls='$export_pearls',export_coloured_gemstones='$export_coloured_gemstones',export_gold_jewellery='$export_gold_jewellery',export_studded_gold_jewellery='$export_studded_gold_jewellery',export_silver_jewellery='$export_silver_jewellery',export_studded_silver_jewellery='$export_studded_silver_jewellery',export_cut_polished_diamonds='$export_cut_polished_diamonds',export_rough_diamonds='$export_rough_diamonds',export_rough_lgd='$export_rough_lgd',export_cut_polished_lgd='$export_cut_polished_lgd',export_imitation_jewellery='$export_imitation_jewellery',export_other_items='$export_other_items',export_total='$export_total',import_findings_mountings='$import_findings_mountings',import_false_pearls='$import_false_pearls',import_rough_imitation_stones='$import_rough_imitation_stones',import_silver='$import_silver',import_raw_pearls='$import_raw_pearls',import_cut_polished_gemstones='$import_cut_polished_gemstones',import_rough_gemstones='$import_rough_gemstones',import_gold='$import_gold',import_cut_polished_diamonds='$import_cut_polished_diamonds',import_rough_diamonds='$import_rough_diamonds',import_synthetic_stones='$import_synthetic_stones',import_gold_jewellery='$import_gold_jewellery',import_silver_jewellery='$import_silver_jewellery',import_rough_lgd='$import_rough_lgd',import_cut_polished_lgd='$import_cut_polished_lgd',import_imitation_jewellery='$import_imitation_jewellery',import_other_items='$import_other_items',import_total='$import_total',export_fob_value='$export_fob_value',import_cif_value='$import_cif_value',	challan_financial_year='$cur_fin_yr',challan_region_name='$region_code',challan_region_no='$challan_no',gjepc_account_no='$gjepc_account_no',payment_mode='$payment_mode',membership_fees='$membership_fees',admission_fees='$admission_fees',ad_valorem='$ad_valorem',total='$total',service_tax='$service_tax',total_payable='$total_payable',bank_name='$bank_name',branch_name='$branch_name',branch_city='$branch_city',branch_postal_code='$branch_postal_code',cheque_no='$cheque_no',cheque_date='$cheque_date',cheque_dd_scan_copy='$cheque_dd_scan_copy',ReferenceNo='$ReferenceNo',declaration='$declaration',status='1',post_date='$post_date',ip_address='$ip_address'";
	$getResult = $conn ->query($sql);
	if(!$getResult) die ($conn->error);
 } 
 	
	$email_id=getUserEmail($registration_id,$conn);
	$company_name=getNameCompany($registration_id,$conn);
	$comoany_pan_no=getCompanyPan($registration_id,$conn);
	$company_bp_no=getBPNO($registration_id,$conn);
	
	$key="2200043013901118";
	
	$mandate_str=aes128Encrypt($ReferenceNo."|1|".$total_payable."|".$email_id."|".$company_name."|".$comoany_pan_no,$key);
	$optional_str=aes128Encrypt($company_bp_no,$key);
	
	$return_url_str=aes128Encrypt("https://gjepc.org/payment_success.php",$key);
	$reference_str=aes128Encrypt($ReferenceNo,$key);
	$submerchant_str=aes128Encrypt("1",$key);
	$amount_str=aes128Encrypt($total_payable,$key);
	$payment_mode_str=aes128Encrypt($payment_mode,$key);
	
	$encypted_text="https://eazypay.icicibank.com/EazyPG?merchantid=221392&mandatory fields=".$mandate_str."&optional fields=".$optional_str."&returnurl=".$return_url_str."&Reference No=".$reference_str."&submerchantid=".$submerchant_str."&transaction amount=".$amount_str."&paymode=".$payment_mode_str;
	
	/*................................Get payment Status........................................*/
	if($payment_mode=="1"){
		$_SESSION['succ_msg']="Challan Successfully Saved";
		header('location:apply_rcms_certificate.php');exit;
	}
	else if($result['Response_Code']=="E000"){
		$_SESSION['succ_msg']="You have already made the payment";
		header('location:apply_rcms_certificate.php');exit;
	}else{
		header('location:'.$encypted_text);exit;
	}
}

$sql = "SELECT * FROM `challan_master` WHERE 1 and registration_id='$registration_id' and challan_financial_year='$cur_fin_yr' order by id desc limit 1";
$result = $conn ->query($sql);
$num = $result->num_rows;
$rows = $result->fetch_assoc();

$id = $rows['id'];
$Response_Code=$rows['Response_Code'];
$gst_holder_status=$rows['gst_holder_status'];
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
$export_imitation_jewellery=$rows['export_imitation_jewellery'];
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
$import_imitation_jewellery=$rows['import_imitation_jewellery'];
$import_other_items=$rows['import_other_items'];
$import_total=$rows['import_total'];
$export_fob_value=$rows['export_fob_value'];
$import_cif_value=$rows['import_cif_value'];

/*............................Approval Default entry.....................................*/
  // current challan yr calculation
    $cur_year = (int)date('y');
	$curyear  = (int)date('Y');
    $cur_month = (int)date('m');
    if ($cur_month < 4) {
     $cur_fin_yr = $curyear-1;
	 $cur_fin_yr1= $cur_year-1;
	 $cur_finyr  = $cur_fin_yr1 . '-' . ($cur_fin_yr1+1);
	 $last_finyr= ($cur_fin_yr1-1) . '-' . $cur_fin_yr1;
    }
    else {
     $cur_fin_yr = $curyear;
 	 $cur_fin_yr1= $cur_year;
	 $cur_finyr  = $cur_fin_yr1 . '-' . ($cur_fin_yr1+1);
	 $last_finyr = ($cur_fin_yr1-1) . '-' . $cur_fin_yr1;
    }	

$gjepc_account_no=getRegionAccNo($region_id,$conn);
$payment_mode=$rows['payment_mode'];

	$membership_fees=$rows['membership_fees'];
	$admission_fees=$rows['admission_fees'];
	$ad_valorem=$rows['ad_valorem'];
	$total=$rows['total'];
	$service_tax=$rows['service_tax'];
	$total_payable=$rows['total_payable'];

$qrenewded = $conn ->query("select deadline_date from renewal_deadline_master");
$rrenewded = $qrenewded->fetch_assoc();
$deadline_date = $rrenewded['deadline_date'];

/*.......................Check member Type New Or Renewal.................................*/

//$query1=mysql_query("SELECT membership_type FROM `approval_master` WHERE 1 and registration_id='$registration_id' order by id desc limit 1");

//2021-2022 $sql1="SELECT * FROM `approval_master`  WHERE  (`membership_issued_certificate_dt` between '2021-03-31' and '2022-04-1' || membership_renewal_dt between '2021-03-31' and '2022-04-1') and registration_id='$registration_id'";
$sql1="SELECT * FROM `approval_master`  WHERE  (`membership_issued_certificate_dt` between '2022-03-31' and '2023-04-1' || membership_renewal_dt between '2022-03-31' and '2023-04-1') and registration_id='$registration_id'";
$query1 = $conn ->query($sql1);
$result1 = $query1->fetch_assoc();
$num1 = $query1->num_rows;

if($num1==0)
{
	$qfees = $conn ->query("select membership_fee,admission_fee,ad_valorem from export_amount_master where financial_year='$cur_fin_yr' and export_start_amount=0 and status=1");
	$rfees = $qfees->fetch_assoc();
	$membership_fees=$rfees['membership_fee'];
	$admission_fees=$rfees['admission_fee'];
	$ad_valorem=$rfees['ad_valorem'];
	$total=$membership_fees+$admission_fees+$ad_valorem;
	
	if($_SESSION['sez_member']=="Y")
		$service_tax=0;
	else
		$service_tax=round(($total*18)/100);
	
	$total_payable=$total+$service_tax;
}

if($gst_holder_status=="N"){
	$membership_fees="1000";
	$admission_fees="0";
	$ad_valorem="0";
	$total="1000";
	$service_tax="180";
	$total_payable="1180";
}
$bank_name= filter($rows['bank_name']);
$branch_name= filter($rows['branch_name']);
$branch_city= filter($rows['branch_city']);
$branch_postal_code= filter($rows['branch_postal_code']);
$cheque_no=$rows['cheque_no'];
$cheque_date=$rows['cheque_date'];
$cheque_dd_scan_copy=$rows['cheque_dd_scan_copy'];
$payment_id=$rows['payment_id'];
$transaction_id=$rows['transaction_id'];
$payment_status=$rows['payment_status'];
$declaration=$rows['declaration'];
?>
<?php 
	/*............................Check if Approved.................................*/
	$qchln_aprv = $conn ->query("SELECT membership_type,final_submission FROM approval_master WHERE 1 and registration_id=$registration_id");
	$rchln_aprv = $qchln_aprv->fetch_assoc();
	$chk_chln_aprv=$rchln_aprv['final_submission'];
	$membership_type=$rchln_aprv['membership_type'];
	$eligible_for_renewal=$rchln_aprv['eligible_for_renewal'];
?>

<section class="py-5">
	<div class="container inner_container">
    
       <h1 class="bold_font text-center mb-5"><img src="assets/images/gold_star.png" class="title_star d-block mx-auto">My Account - Challan Form</h1>
	<div class="row">
		
		<div class="col-lg-auto order-lg-12 col-md-12 " data-sticky_parent>
				<?php include 'include/regMenu.php'; ?>
		</div>

	<div class="col-lg col-md-12 ">
		<p class="blue">Export Performance Details, FOB in INR</p>
        <div id="preloader" style="display:none;">
        	<div id="status"> <img src="images/loader.gif"></div>
        </div>
<?php 
if($_SESSION['succ_msg']!=""){
echo "<div class='alert alert-success' role='alert'>".$_SESSION['succ_msg']."</div>";
$_SESSION['succ_msg']="";
}

if($_SESSION['form_chk_msg']!="" || $_SESSION['form_chk_msg1']!="" || $_SESSION['form_chk_msg2']!=""){
echo "<div class='notification n-attention'>";
if($_SESSION['form_chk_msg']!=""){
echo $_SESSION['form_chk_msg']."<br>";
}
if($_SESSION['form_chk_msg1']!=""){
echo $_SESSION['form_chk_msg1']."<br>";
}
if($_SESSION['form_chk_msg2']!=""){
echo $_SESSION['form_chk_msg2'];
}
echo "</div>";
$_SESSION['form_chk_msg']="";
$_SESSION['form_chk_msg1']="";
$_SESSION['form_chk_msg2']="";
}
?>
        <form action="" method="post" class="row" name="challanForm" id="challanForm" enctype="multipart/form-data" >
        <div class="form-group col-sm-4">
			<label class="form-label" for="pan_no">PAN No.: <span>*</span></label>
			<input type="text" class="form-control" id="pan_no" name="pan_no" 
		    <?php if(!empty($pan_no)){?> value="<?php echo strtoupper($pan_no);?>" readonly <?php } ?>/>
		</div>
        <div class="form-group col-sm-4">
                <label class="form-label" for="company_name">GSTIN Holder Status: <span>*</span></label>
                <div class="radio inline-form mt-3">
                    <label for="Yes"><input type="radio" name="gst_holder" id="gst_holder" value="Y" 
					<?php if($gst_holder_status=="Y"){?> checked="checked" <?php }?> onChange="getexportdata()" /> Yes</label>			
                    <label for="No"><input type="radio" name="gst_holder" id="gst_holder" value="N" <?php if($gst_holder_status=="N"){?> checked="checked" <?php }?> onChange="getexportdata()"/> No</label>                   
                </div>
        </div>
		<div class="form-group col-sm-4">
                <label class="form-label" for="company_name">E-Sanchit Registered: <span>*</span></label>
                <div class="radio inline-form mt-3">
                    <label for="Yes"><input type="radio" name="e_sanchit_status" id="e_sanchit_status" value="Yes" 
					<?php if($e_sanchit_status=="Yes"){?> checked="checked" <?php }?> /> Yes</label>			
                    <label for="No"><input type="radio" name="e_sanchit_status" id="e_sanchit_status" value="No" <?php if($e_sanchit_status=="No"){?> checked="checked" <?php }?>/>  No</label>                   
                </div>
        </div>
			<div class="form-group col-sm-6">
				<label class="form-label" >GSTIN No.: <span>*</span></label>
				<div class="inputcontainer">
				<input type="text" class="form-control" id="gst_no" name="gst_no" maxlength="15" 
				<?php if($gst_holder_status=="N"){ ?> value="NA" <?php } else if(empty($gst_no)){ ?> value="" <?php } else { ?>
                 value="<?php echo $gst_no;?>" <?php } ?>>  
                  <div class="icon-container">
	                 <i class="loader_input" id="gst_check_loader"></i>
                 </div>
                 </div>
                 <label for="gst_no" generated="true" class="error"></label>
                <input type="hidden" id="gst_no_hid" value="<?php echo $gst_no;?>"/>                
			</div>
        
			<div class="form-group col-sm-6">
				<label class="form-label" for="export_coloured_gemstones">Coloured Gemstones <span>*</span></label>
				<input type="text" class="form-control" name="export_coloured_gemstones" id="export_coloured_gemstones" value="<?php echo $export_coloured_gemstones;?>" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="export_costume_jewellery">Costume/Fashion Jewellery <span>*</span></label>
				<input type="text" class="form-control"name="export_costume_jewellery" id="export_costume_jewellery" value="<?php echo $export_costume_jewellery;?>" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="export_cut_polished_diamonds">Cut & Polished Diamonds <span>*</span></label>
				<input type="text" class="form-control" name="export_cut_polished_diamonds" id="export_cut_polished_diamonds" value="<?php echo $export_cut_polished_diamonds;?>" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="export_gold_jewellery">Plain Gold Jewellery : <span>*</span></label>
				<input type="text" class="form-control" name="export_gold_jewellery" id="export_gold_jewellery" value="<?php echo $export_gold_jewellery;?>" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="export_studded_gold_jewellery">Studded Gold Jewellery : <span>*</span></label>
				<input type="text" class="form-control" name="export_studded_gold_jewellery" id="export_studded_gold_jewellery" value="<?php echo $export_studded_gold_jewellery;?>" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="export_silver_jewellery">Plain Silver Jewellery : <span>*</span></label>
				<input type="text" class="form-control" name="export_silver_jewellery" id="export_silver_jewellery" value="<?php echo $export_silver_jewellery;?>" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="export_studded_silver_jewellery">Studded Silver Jewellery : <span>*</span></label>
				<input type="text" class="form-control"name="export_studded_silver_jewellery" id="export_studded_silver_jewellery" value="<?php echo $export_studded_silver_jewellery;?>" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="export_other_precious_metal_jewellery">Other Precious Metal Jewellery : <span>*</span></label>
				<input type="text" class="form-control" name="export_other_precious_metal_jewellery" id="export_other_precious_metal_jewellery" value="<?php echo $export_other_precious_metal_jewellery;?>" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';" />
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="export_pearls">Pearls : <span>*</span></label>
				<input type="text" class="form-control" name="export_pearls" id="export_pearls" value="<?php echo $export_pearls; ?>" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="export_rough_diamonds">Rough Diamonds : <span>*</span></label>
				<input type="text" class="form-control" name="export_rough_diamonds" id="export_rough_diamonds" value="<?php echo $export_rough_diamonds;?>" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="export_sales_to_foreign_tourists">Sales to Foreign Tourists : <span>*</span></label>
				<input type="text" class="form-control" name="export_sales_to_foreign_tourists" id="export_sales_to_foreign_tourists" value="<?php echo $export_sales_to_foreign_tourists;?>" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/></div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="export_synthetic_stones">Synthetic Stones : <span>*</span></label>
				<input type="text" class="form-control" name="export_synthetic_stones" id="export_synthetic_stones" value="<?php echo $export_synthetic_stones;?>" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
            
			<div class="form-group col-sm-6">
				<label class="form-label" for="export_rough_lgd">Rough Lab Grown Diamond : <span>*</span></label>
				<input type="text" class="form-control" name="export_rough_lgd" id="export_rough_lgd" value="<?php echo $export_rough_lgd;?>" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
			
			<div class="form-group col-sm-6">
				<label class="form-label" for="export_cut_polished_lgd">Cut & Polished Lab Grown Diamond : <span>*</span></label>
				<input type="text" class="form-control" name="export_cut_polished_lgd" id="export_cut_polished_lgd" value="<?php echo $export_cut_polished_lgd;?>" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
			
			<div class="form-group col-sm-6">
				<label class="form-label" for="import_cut_polished_lgd">Imitation Jewellery : <span>*</span></label>
				<input type="text" class="form-control" name="export_imitation_jewellery" id="export_imitation_jewellery" value="0" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
			
            <div class="form-group col-sm-6">
				<label class="form-label" for="export_other_items">Other Items : <span>*</span></label>
				<input type="text" class="form-control" name="export_other_items" id="export_other_items" value="<?php echo $export_other_items; ?>" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="export_total">Total : <span>*</span></label>
				<input type="text" class="form-control" name="export_total" id="export_total" value="<?php echo $export_total;?>" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
                        
            
            <div class="form-group col-12"><p class="blue">Import Performance Details, CIF in INR</p></div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_cut_polished_diamonds">Cut & Polished Diamonds : <span>*</span></label>
				<input type="text" class="form-control" name="import_cut_polished_diamonds" id="import_cut_polished_diamonds" value="<?php echo $import_cut_polished_diamonds;?>" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_cut_polished_gemstones">Cut & Polished Gemstones : <span>*</span></label>
				<input type="text" class="form-control" name="import_cut_polished_gemstones" id="import_cut_polished_gemstones" value="<?php echo $import_cut_polished_gemstones; ?>" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_false_pearls">Processed & Finished Pearls : <span>*</span></label>
				<input type="text" class="form-control" name="import_false_pearls" id="import_false_pearls" value="<?php echo $import_false_pearls; ?>" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/></div>
			
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_findings_mountings">Findings & Mountings : <span>*</span></label>
				<input type="text" class="form-control" name="import_findings_mountings" id="import_findings_mountings" value="<?php echo $import_findings_mountings;?>" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_gold">Gold Bar : <span>*</span></label>
				<input type="text" class="form-control" name="import_gold" id="import_gold" value="<?php echo $import_gold;?>" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_raw_pearls">Raw Pearls : <span>*</span></label>
				<input type="text" class="form-control" name="import_raw_pearls" id="import_raw_pearls" value="<?php echo $import_raw_pearls;?>" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_rough_diamonds">Rough Diamond: : <span>*</span></label>
				<input type="text" class="form-control" name="import_rough_diamonds" id="import_rough_diamonds" value="<?php echo $import_rough_diamonds;?>" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_rough_gemstones">Rough Gemstones : <span>*</span></label>
				<input type="text" class="form-control" name="import_rough_gemstones" id="import_rough_gemstones" value="<?php echo $import_rough_gemstones;?>" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_rough_imitation_stones">Rough Imitation Stones, Glass Beads/ Glass Chattons : <span>*</span></label>
				<input type="text" class="form-control" name="import_rough_imitation_stones" id="import_rough_imitation_stones" value="<?php echo $import_rough_imitation_stones; ?>" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_silver">Silver, Platinum, Palladium : <span>*</span></label>
				<input type="text" class="form-control" name="import_silver" id="import_silver" value="<?php echo $import_silver; ?>" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_synthetic_stones">Synthetic stones : <span>*</span></label>
				<input type="text" class="form-control" name="import_synthetic_stones" id="import_synthetic_stones" value="<?php echo $import_synthetic_stones; ?>" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_gold_jewellery">Gold Jewellery : <span>*</span></label>
				<input type="text" class="form-control" name="import_gold_jewellery" id="import_gold_jewellery" value="<?php echo $import_gold_jewellery; ?>" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_silver_jewellery">Silver Jewellery : <span>*</span></label>
				<input type="text" class="form-control" name="import_silver_jewellery" id="import_silver_jewellery" value="<?php echo $import_silver_jewellery; ?>" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
			
			<div class="form-group col-sm-6">
				<label class="form-label" for="import_rough_lgd">Rough Lab Grown Diamond : <span>*</span></label>
				<input type="text" class="form-control" name="import_rough_lgd" id="import_rough_lgd" value="<?php echo $import_rough_lgd; ?>" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
			
			<div class="form-group col-sm-6">
				<label class="form-label" for="import_cut_polished_lgd">Cut & Polished Lab Grown Diamond : <span>*</span></label>
				<input type="text" class="form-control" name="import_cut_polished_lgd" id="import_cut_polished_lgd" value="<?php echo $import_cut_polished_lgd; ?>" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
			
			<div class="form-group col-sm-6">
				<label class="form-label" for="import_cut_polished_lgd">Imitation Jewellery : <span>*</span></label>
				<input type="text" class="form-control" name="import_imitation_jewellery" id="import_imitation_jewellery" value="0" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
			
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_other_items">Other Items : <span>*</span></label>
				<input type="text" class="form-control"  name="import_other_items" id="import_other_items" value="<?php echo $import_other_items; ?>" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_total">Total : <span>*</span></label>
				<input type="text" class="form-control" name="import_total" id="import_total" value="<?php echo $import_total;?>" readonly onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/>
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="export_fob_value">F.O.B value of exports : <span>*</span></label>
				<input type="text" class="form-control" name="export_fob_value" id="export_fob_value" value="<?php echo $export_fob_value;?>" readonly />
			</div>
            
            <div class="form-group col-sm-6">
				<label class="form-label" for="import_cif_value">C.I.F value of imports : <span>*</span></label>
				<input type="text" class="form-control" name="import_cif_value" id="import_cif_value" value="<?php echo $import_cif_value;?>" readonly/>
			</div>         
                               
            <div class="form-group col-12"><p class="blue">Payment Details</p></div>
            <input type="hidden" class="form-control" id="gjepc_account_no" name="gjepc_account_no" value="<?php echo $gjepc_account_no;?>" readonly />
            <!--<div class="form-group col-sm-6">
				<label class="form-label" for="gjepc_account_no">GJEPC Account Number: <span>*</span></label>
				<div class="col-md-6"></div>
			</div>-->
            
            <div id="manufDiv" class="col-12">
            <div class="row">
				<div class="form-group col-12">
					<label class="form-label" for="company_name">Payment Mode: <span>*</span></label>
						<div class="radio inline-form">
                        <label for="No"> <input type="radio" name="payment_mode" id="payment_mode" value="3" /> NetBanking</label>			
							<label for="Yes"> <input type="radio" name="payment_mode" id="payment_mode" value="4" /> Debit Card</label>
							<label for="No"> <input type="radio" name="payment_mode" id="payment_mode" value="5" /> Credit Card</label>				  
                            <label for="No"> <input type="radio" name="payment_mode" id="payment_mode" value="2" /> RTGS/NEFT </label>
						</div>					
				</div>
                </div>
			</div>
            
             <div class="form-group col-sm-6">
				<label class="form-label" for="membership_fees">Membership Fees: <span>*</span></label>
				<input type="text" class="form-control" id="membership_fees" name="membership_fees" value="<?php echo $membership_fees;?>" readonly/>
			</div>
             <div class="form-group col-sm-6">
				<label class="form-label" for="admission_fees">Admission Fees: <span>*</span></label>
				<input type="text" class="form-control"id="admission_fees" name="admission_fees" value="<?php if($eligible_for_renewal=="Y"){echo "0";}else {echo $admission_fees;}?>" readonly/>
			</div>
             <div class="form-group col-sm-6">
				<label class="form-label" for="total">Total: <span>*</span></label>
				<input type="text" class="form-control" id="total" name="total" value="<?php echo $total;?>" readonly/>
			</div>
             <div class="form-group col-sm-6">
				<label class="form-label" for="service_tax">GST @ 18%: </label>
				<input type="text" class="form-control" id="service_tax" name="service_tax"  value="<?php echo $service_tax;?>" readonly/>
			</div>
             <div class="form-group col-sm-6">
				<label class="form-label" for="total_payable">Total Payable (in rupees): <span>*</span></label>
				<input type="text" class="form-control" id="total_payable" name="total_payable" value="<?php echo $total_payable;?>" readonly>
			</div>
            
            <div class="col-12" id="bank_details" id="bank_details" <?php if($payment_mode!='1'){?> style="display: none" <?php }?> >
            <div class="row">
            <div class="form-group col-sm-6">
				<label class="form-label" for="member_type_id">Drawn on Bank: <span>*</span></label>
                <select name="bank_name" id="bank_name" class="form_text_text">
				<option value="">---------- Select Bank ----------</option>
				<?php 
				$query = $conn ->query("select * from bank_master where status=1 order by bank_name");
				while($result = $query->fetch_assoc()){
				?>
				<option value="<?php echo $result['bank_name'];?>" <?php if($result['bank_name']==$bank_name){?> selected="selected" <?php }?>><?php echo strtoupper($result['bank_name']);?></option>
			   <?php }?>
				</select>				
			</div>
            
             <div class="form-group col-sm-6">
				<label class="form-label" for="branch_name">Bank Branch: <span>*</span></label>
				<input type="text" class="form-control" id="branch_name" name="branch_name" Placeholder="Branch" value="<?php echo $branch_name;?>"/>
			</div>
             <div class="form-group col-sm-6">
				<label class="form-label" for="branch_city">Bank City: <span>*</span></label>
				<input type="text" class="form-control" id="branch_city" name="branch_city" value="<?php echo $branch_city;?>" placeholder="City">
			</div>
             <div class="form-group col-sm-6">
				<label class="form-label" for="branch_postal_code">Branch Postal Code: <span>*</span></label>
				<input type="text" class="form-control" id="branch_postal_code" name="branch_postal_code" value="<?php echo $branch_postal_code;?>" placeholder="Postal Code" maxlength="6" minlength="6">
			</div>
            <div class="form-group col-sm-6">
				<label class="form-label" for="cheque_dd_scan_copy">Upload Cheque/DD scan copy: </label>
				<input type="file" id="cheque_dd_scan_copy" name="cheque_dd_scan_copy" value=""/>
				
			</div>
			<div class="form-group col-sm-6" id="bank_details" <?php if($payment_mode=='RTGS-NEFT'){?> style="display: none" <?php }?> >
				<label class="form-label" for="cheque_no">Cheque/DD No.: <span>*</span></label>
				<input type="text" class="form-control" id="cheque_no" name="cheque_no" value="<?php echo $cheque_no;?>" placeholder="Cheque/DD No." maxlength="6" minlength="6">
			</div>
            <div class="form-group col-sm-6">
				<label class="form-label" for="cheque_date">Date (DD-MM-YYYY): <span>*</span></label>
				<input type="text" class="form-control" id="cheque_date" name="cheque_date" value="<?php echo $cheque_date;?>" autocomplete="off" placeholder="Cheque Date" readonly />
			</div>
            </div>
			 </div>  
               
            <div class="form-group col-12"><p class="blue">Declaration</p></div>
            
            <div class="tablewidth_101 form-group col-12"> 
			<div class="chexbox">
			<input type="checkbox" name="declaration" id="declaration" value="1" <?php if($declaration=="1"){?> checked="checked"<?php }?>> I/We hereby solemnly affirm and declare that our previous financial year exports of gems and jewellery items and import of gems and jewellery raw materials amounted to the mentioned amount in this form.
			</div>
			</div>
			<div class="form-group col-sm-6">
					<input type="hidden" name="action" value="update" />
					<input type="hidden" name="registration_id" id="registration_id" value="<?php echo $registration_id;?>" />
					<input type="hidden" name="region_id" id="region_id" value="<?php echo $region_id;?>" />
                <?php
				/*if($Response_Code=="E000")
					echo "<div class='sub_head'>You have already made the payment</div>";
				else if($num>0)
					echo "<div class='sub_head'>You have already saved your challan</div>";
				else
                	echo "<input class='btn' type='submit' value='Submit' />";*/	
					
				if($Response_Code=="E000")
					echo "<div class='sub_head'>You have already made the payment</div>";
				else
                	echo "<input class='cta' type='submit' value='Submit' />";							
                ?>				
			</div>
		</form>
        </div>
        </div>
        </section>

<style>
#preloader {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #fff;
    z-index: 99999999999;
    height: 100%;
    width: 100%;
}

#status {
    width: 45px;
    height: 45px;
    position: absolute;
    left: 50%;
    top: 50%;
    margin: -22px 0 0 -22px;
}

#status img {
    width: 100%;
    height: auto;
}
</style>
<?php include 'include-new/footer.php'; ?>

<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 

<script type="text/javascript">
$().ready(function() { 

	$("#gst_check_loader").hide();
	$("#commentForm").validate();
	$("input[name='gst_holder']").on('change', function () {
         var gst_holder = $("input[name='gst_holder']:checked").val();
		 var export_fob_value=$("#export_fob_value").val();
         if (gst_holder=='N'){
			$("#gst_no").val("NA");
				if(export_fob_value>4000000){
					alert("GST is required as Total export amount is ");
					$('input:radio[name="gst_holder"][value="Y"]').attr('checked',true);
					$("#gst_no").val('');
				}
		 }
		  else{
		  	  $("#gst_no").val($('#gst_no_hid').val());
		  }
     });
	
$.validator.addMethod("gst_no", function(value, element) {
	 $('label[for="gst_no"]').html("");
	if(value=='NA'){
		return true;
	}else {
	var regex = /^([0][1-9]|[1-2][0-9]|[3][0-7])([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$/;
	var gst_val = value.toUpperCase();
	if(gst_val.match(regex)) {
		$("#gst_check_loader").hide();
       var gst_true = localStorage.getItem("gst_true");		
       var gst_false = localStorage.getItem("gst_false");		
		if(gst_true !=null && gst_val == gst_true){
            return true;
		}else if(gst_false !=null && gst_val == gst_false){
			$('label[for="gst_no"]').html("Invalid GST Number");
            return false;
		}else{
        	$.ajax({
	        type:'POST',
	        data: {gst_val:gst_val},
	        url:"gstCheck.php",
	        dataType: "json",
	        beforeSend: function()
	            {
	             $("#gst_check_loader").show();
	             $('label[for="gst_no"]').css("display","none");
	            },
	        success:function(result){
	        	 $("#gst_check_loader").hide();
	        	 $(".error").css("display","block");
			    if(result.status=="success")
			    {
			    	localStorage.setItem("gst_true", gst_val);
			    	$('label[for="gst_no"]').html("");
			        return true;
			    }else if(result.status=="error1")
			    {  
			    	$('label[for="gst_no"]').html("GST is Inactive");
			    	localStorage.setItem("gst_false", gst_val);
			        return false;
			    }else if(result.status=="error2")
			    {
			    	$('label[for="gst_no"]').html("Invalid GST Number");
			    	localStorage.setItem("gst_false", gst_val);
			        return false;
				}else{
					$('label[for="gst_no"]').html("No Record Found for this GST");
					localStorage.setItem("gst_false", gst_val);
					return false;
				}
		    }
	    });
		}   
    }else{
      return false;
    }
	} }, "Please Enter Valid GSTIN No.");
	
	
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
			export_imitation_jewellery: {required: true,number :true},
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
			import_imitation_jewellery: "required",
			import_total: "required",
			export_fob_value: "required",
			import_cif_value: "required",
			gjepc_account_no: "required",
			pan_no: "required",
			gst_holder:"required",
			e_sanchit_status:"required",
			gst_no: {
                required: true,
				gst_no: true
            },		
			payment_mode: "required",
			membership_fees: "required",
			admission_fees: "required",
			total: "required",
			service_tax: "required",
			total_payable: "required",			
			bank_name: "required",			
			branch_name: "required",
			branch_city: "required",
			branch_postal_code: {
				required: true,
				number:true,
				minlength:6,
				maxlength:6
			},
			cheque_no: {
				required: true,
				number:true,
				minlength:6,
				maxlength:6
			},
			cheque_date: "required",
			declaration: "required"
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
			required:"Please enter Silver jewellery",
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
			export_imitation_jewellery: 
			{
			required:"Please enter Imitation  Jewellery",
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
			import_imitation_jewellery: "Please enter Imitation Jewellery",
			import_total: "Please enter total",
			export_fob_value: "Please enter F.O.B value of exports",
			import_cif_value: "Please enter C.I.F value of imports",
			gjepc_account_no: "Please enter GJEPC account number",
			pan_no: "Please Enter PAN number",
			gst_holder: "Please select your eligibility for GST",
			e_sanchit_status: "Required",
			gst_no: {
				required: "Please Enter GSTIN No.",
				minlength:"Please enter not less than 15 characters",
				maxlength:"Please enter not more than 15 characters"
				},
			payment_mode: "Required.",
			membership_fees: "Please Enter Membership Fees",
			admission_fees: "Please Enter Admission Fees",
			total: "Please enter total amount",
			service_tax: "Please enter service tax",
			total_payable: "Please enter total payable",
			
			bank_name: "Please Enter Bank Name",
			
			branch_name: "Please Enter Branch Name",
			branch_city: "Please Enter Bank City",
			branch_postal_code: 
			{
				required: "Please Enter your Pin Code",
				number:"please enter numbers only",
				minlength:"please enter not less than 6 characters",
				maxlength:"please enter not more than 6 characters"	
			},  
			cheque_no: 
			{
				required: "Please Enter Cheque/DD No",
				number:"Please Enter numbers only",
				minlength:"please enter not less than 6 characters",
				maxlength:"please enter not more than 6 characters"	
			},
			cheque_date: "Please Enter Cheque Date",
		    declaration: "Please Select Declaration",
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
	var export_imitation_jewellery=document.getElementById("export_imitation_jewellery").value;
	if(export_imitation_jewellery==""){export_imitation_jewellery=0;}
	
	var export_other_items=document.getElementById("export_other_items").value;
	if(export_other_items==""){export_other_items=0;}
	
	
	var tot_examount=parseInt(export_sales_to_foreign_tourists)+parseInt(export_synthetic_stones)+parseInt(export_costume_jewellery)+parseInt(export_other_precious_metal_jewellery)+parseInt(export_pearls)+parseInt(export_coloured_gemstones)+parseInt(export_gold_jewellery)+parseInt(export_studded_gold_jewellery)+parseInt(export_silver_jewellery)+parseInt(export_studded_silver_jewellery)+parseInt(export_rough_diamonds)+parseInt(export_cut_polished_diamonds)+parseInt(export_rough_lgd)+parseInt(export_cut_polished_lgd)+parseInt(export_imitation_jewellery)+parseInt(export_other_items);
	//alert(tot_examount);
	document.getElementById("export_total").value = tot_examount;
	document.getElementById("export_fob_value").value = tot_examount;
	
	if(gst_holder=="N" && tot_examount>4000000){
		alert("GST is required as Total export amount is exceeding 40,00,000");
		$('input:radio[name="gst_holder"][value="Y"]').attr('checked',true);
		$("#gst_no").val('');
		return false;
	}
	
	$.ajax({
			   type: "POST",
			   url: "ajax.php",
			   data: "actiontype=paymentdetailsexport&paymentamnt="+tot_examount+"&gst_holder="+gst_holder,
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
	var import_imitation_jewellery=document.getElementById("import_imitation_jewellery").value;
	if(import_imitation_jewellery==""){import_imitation_jewellery=0;}
	
	var import_other_items=document.getElementById("import_other_items").value;
	if(import_other_items==""){import_other_items=0;}
	
	
	var tot_imamount=parseInt(import_findings_mountings)+parseInt(import_false_pearls)+parseInt(import_rough_imitation_stones)+parseInt(import_silver)+parseInt(import_raw_pearls)+parseInt(import_cut_polished_gemstones)+parseInt(import_rough_gemstones)+parseInt(import_gold)+parseInt(import_cut_polished_diamonds)+parseInt(import_rough_diamonds)+parseInt(import_synthetic_stones)+parseInt(import_gold_jewellery)+parseInt(import_silver_jewellery)+parseInt(import_rough_lgd)+parseInt(import_cut_polished_lgd)+parseInt(import_imitation_jewellery)+parseInt(import_other_items);
	
	document.getElementById("import_total").value = tot_imamount;
	document.getElementById("import_cif_value").value = tot_imamount;
	
	export_amnt=document.getElementById("export_fob_value").value;
	
	if(gst_holder=="N" && export_amnt>4000000){
		alert("GST is required as Total export amount is exceeding 40,00,000");
		$("#gst_no").val('');
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

<script>
$(document).ready(function () { 
				$('#cheque_date').datepicker({
                minDate: 0,
                autoclose: true, 
                todayHighlight: true,
                format: "dd/mm/yyyy"
                }).on('changeDate', function (ev) {
					 $(this).datepicker('hide');
				}); 
				});  
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("input[name='payment_mode']").click(function () {
			if($(this).val()=="1") {
				$("#bank_details").show();		
				$("#bank_name").removeAttr("disabled");
				$("#branch_name").removeAttr("disabled");
				$("#branch_city").removeAttr("disabled");
				$("#branch_postal_code").removeAttr("disabled");
				$("#cheque_no").removeAttr("disabled");
				$("#cheque_date").removeAttr("disabled");				
				
            } else {
                $("#bank_details").hide();
				$("#bank_name").attr("disabled", "disabled"); 
				$("#branch_name").attr("disabled", "disabled"); 
				$("#branch_city").attr("disabled", "disabled"); 
				$("#branch_postal_code").attr("disabled", "disabled"); 
				$("#cheque_no").attr("disabled", "disabled"); 
				$("#cheque_date").attr("disabled", "disabled"); 
            }
        });
    });
</script>
<style type="text/css">
.inputcontainer {
          position: relative;
        }
      
        .icon-container {
          position: absolute;
          right: 10px;
          top: calc(50% - 10px);
        }
        .loader_input {
          position: relative;
          height: 20px;
          width: 20px;
          display: inline-block;
          animation: around 5.4s infinite;
        }

        @keyframes around {
          0% {
            transform: rotate(0deg)
          }
          100% {
            transform: rotate(360deg)
          }
        }

        .loader_input::after, .loader_input::before {
          content: "";
          background: white;
          position: absolute;
          display: inline-block;
          width: 100%;
          height: 100%;
          border-width: 2px;
          border-color: #333 #333 transparent transparent;
          border-style: solid;
          border-radius: 20px;
          box-sizing: border-box;
          top: 0;
          left: 0;
          animation: around 0.7s ease-in-out infinite;
        }

        .loader_input::after {
          animation: around 0.7s ease-in-out 0.1s infinite;
          background: transparent;
        }
</style>