<?php include 'include/header.php'; ?>
<?php if(!isset($_SESSION['USERID'])){header('location:login.php');}?>
<?php
include 'db.inc.php';
include 'functions.php';
?>

<?php 
$registration_id=$_SESSION['USERID'];

include 'indivisual_payment_status_update.php';

$info_status=mysql_query("select gst_no,pan_no,status,region_id,member_type_id,new_update_status from information_master where registration_id='$registration_id' and status=1");
$info_result=mysql_fetch_array($info_status);
$gst_no = strip_tags($info_result['gst_no']);
$pan_no = strip_tags($info_result['pan_no']);
$region_id=$info_result['region_id'];
$member_type_id=$info_result['member_type_id'];
$gjepc_account_no=getRegionAccNo($region_id);
$info_num=mysql_num_rows($info_status);

$comm_status=mysql_query("select status,new_update_status from communication_details_master where registration_id='$registration_id' and status=1");
$comm_result=mysql_fetch_array($comm_status);
$comm_num=mysql_num_rows($comm_status);

if($info_num==0 && $comm_num==0)
{ 
	$_SESSION['form_chk_msg']="Please first fill Information form";
	$_SESSION['form_chk_msg1']="Please first fill Communication form";
	header('location:information_form.php');exit;
}
if($info_result['new_update_status']=='No')
{
	$_SESSION['form_chk_msg1']="Please update the information form";
	header('location:information_form.php');exit;
}

if($comm_num==0)
{ 
	$_SESSION['form_chk_msg1']="Please first fill Communication form";
	header('location:communication_form.php');exit;
}
if($comm_result['new_update_status']=='No')
{ 
	$_SESSION['form_chk_msg1']="Please update Communication form";
	header('location:communication_form.php');exit;
}


?>

<?php
$action=$_REQUEST['action'];
if($action=="save")
{
$registration_id=$_REQUEST['registration_id'];
$region_id=$_REQUEST['region_id'];

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
$import_other_items=$_REQUEST['import_other_items'];
$import_total=$_REQUEST['import_total'];
$export_fob_value=$_REQUEST['export_fob_value'];
$import_cif_value=$_REQUEST['import_cif_value'];
$ip_address=$_SERVER['REMOTE_ADDR'];

/*............................. SAVE PAN & GST NO START .............................*/
$pan_no =  strip_tags($_REQUEST['pan_no']);
$gst_no =  strip_tags($_REQUEST['gst_no']);

$getsqlx = "select gst_no,pan_no from information_master where pan_no='$pan_no' AND gst_no='$gst_no' AND registration_id='$registration_id' and status='1'";
$gstx = mysql_query($getsqlx);
$countx = mysql_num_rows($gstx);
if($countx>0)
{
	$gstUpdatex = "UPDATE `information_master` SET pan_no='$pan_no', gst_no='$gst_no' where registration_id='$registration_id'";
	$gstResultx = mysql_query($gstUpdatex);
} else {
	$gstUpdatex = "UPDATE `information_master` SET pan_no='$pan_no', gst_no='$gst_no' where registration_id='$registration_id'"; 
	$gstResultx = mysql_query($gstUpdatex);
}
/*............................. SAVE PAN & GST NO END   .............................*/ 

/*............................. Update Pan in registraiton Table .............................*/
$getsqlx1 = "SELECT * FROM  `registration_master` WHERE  `company_pan_no` = '$pan_no'";
$gstx1 = mysql_query($getsqlx1);
$countx1 = mysql_num_rows($gstx1);
if($countx1==0)
	mysql_query("UPDATE `registration_master` SET company_pan_no='$pan_no' where id='$registration_id'");
	
	
	
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
	
	
/*...........................Fetch challan no. .......................................*/
$last_challan_no = mysql_fetch_array(mysql_query("SELECT challan_region_no FROM challan_master WHERE  challan_region_name = '$region_id' AND challan_financial_year = '$cur_fin_yr' ORDER BY id desc limit 1"));

    $region_code = $region_id;
   	$last_challan_no=$last_challan_no['challan_region_no'];
    
	$sequence = substr($last_challan_no, 10);
	$next_sequence = sprintf('%04d', $sequence + 1);
	$challan_no = substr($region_code, 3,3) . '/' .$cur_finyr. '/' . $next_sequence;
	
/*.............................Payment data.............................*/
$qrenewded=mysql_query("select deadline_date from renewal_deadline_master");
$rrenewded=mysql_fetch_array($qrenewded);
$deadline_date=$rrenewded['deadline_date'];

/*$qfees=mysql_query("select membership_fee,admission_fee,ad_valorem from export_amount_master where financial_year='$cur_fin_yr' and export_start_amount=0 and status=1");
$rfees=mysql_fetch_array($qfees);
$membership_fees=$rfees['membership_fee'];
	if($deadline_date>=date("Y-m-d"))
	{
	$admission_fees='0';
	}else
	{
	$admission_fees=$rfees['admission_fee'];
	}
	
$ad_valorem=$rfees['ad_valorem'];
*/
$payment_mode=$_REQUEST['payment_mode'];
$membership_fees=$_REQUEST['membership_fees'];
$admission_fees=$_REQUEST['admission_fees'];
$total=$_REQUEST['total'];
$service_tax=$_REQUEST['service_tax'];
$total_payable=$_REQUEST['total_payable'];
$bank_name=$_REQUEST['bank_name'];
$branch_name=$_REQUEST['branch_name'];
$branch_city=$_REQUEST['branch_city'];
$branch_postal_code=$_REQUEST['branch_postal_code'];
$cheque_no=$_REQUEST['cheque_no'];
$cheque_date=$_REQUEST['cheque_date'];
$payment_id=$_REQUEST['payment_id'];
$declaration=$_REQUEST['declaration'];
$post_date=date('Y-m-d');

$query=mysql_query("select * from challan_master where registration_id='$registration_id' and challan_financial_year='$cur_fin_yr' order by id desc limit 0,1");
$result=mysql_fetch_array($query);
$num=mysql_num_rows($query);
if($num>0)
{
	$_SESSION['ReferenceNo']=$ReferenceNo=rand(100,9999999);
	mysql_query("insert into challan_payment_log set registration_id='$registration_id',ReferenceNo='$ReferenceNo',post_date='$post_date'");
	$sql1="update challan_master set registration_id='$registration_id',export_sales_to_foreign_tourists='$export_sales_to_foreign_tourists',export_synthetic_stones='$export_synthetic_stones',export_costume_jewellery='$export_costume_jewellery',export_other_precious_metal_jewellery='$export_other_precious_metal_jewellery',export_pearls='$export_pearls',export_coloured_gemstones='$export_coloured_gemstones',export_gold_jewellery='$export_gold_jewellery',export_studded_gold_jewellery='$export_studded_gold_jewellery',export_silver_jewellery='$export_silver_jewellery',export_studded_silver_jewellery='$export_studded_silver_jewellery',export_rough_diamonds='$export_rough_diamonds',export_cut_polished_diamonds='$export_cut_polished_diamonds',export_other_items='$export_other_items',export_total='$export_total',import_findings_mountings='$import_findings_mountings',import_false_pearls='$import_false_pearls',import_rough_imitation_stones='$import_rough_imitation_stones',import_silver='$import_silver',import_raw_pearls='$import_raw_pearls',import_cut_polished_gemstones='$import_cut_polished_gemstones',import_rough_gemstones='$import_rough_gemstones',import_gold='$import_gold',import_cut_polished_diamonds='$import_cut_polished_diamonds',import_rough_diamonds='$import_rough_diamonds',import_synthetic_stones='$import_synthetic_stones',import_gold_jewellery='$import_gold_jewellery',import_silver_jewellery='$import_silver_jewellery',import_other_items='$import_other_items',import_total='$import_total',export_fob_value='$export_fob_value',import_cif_value='$import_cif_value',challan_financial_year='$cur_fin_yr',challan_region_name='$region_code',challan_region_no='$challan_no',gjepc_account_no='$gjepc_account_no',payment_mode='$payment_mode',membership_fees='$membership_fees',admission_fees='$admission_fees',ad_valorem='$ad_valorem',total='$total',service_tax='$service_tax',total_payable='$total_payable',bank_name='$bank_name',branch_name='$branch_name',branch_city='$branch_city',branch_postal_code='$branch_postal_code',cheque_no='$cheque_no',cheque_date='$cheque_date',ReferenceNo='$ReferenceNo',declaration='$declaration',ReferenceNo='$ReferenceNo',status='1',post_date='$post_date',ip_address='$ip_address' where registration_id='$registration_id' and challan_financial_year='$cur_fin_yr'";
	if (!mysql_query($sql1))
	{
		die('Error: ' . mysql_error());
	}
	
}else{
$_SESSION['ReferenceNo']=$ReferenceNo=rand(100,9999999);
mysql_query("insert into challan_payment_log set registration_id='$registration_id',ReferenceNo='$ReferenceNo',post_date='$post_date'");
$sql1="insert into challan_master set registration_id='$registration_id',export_sales_to_foreign_tourists='$export_sales_to_foreign_tourists',export_synthetic_stones='$export_synthetic_stones',export_costume_jewellery='$export_costume_jewellery',export_other_precious_metal_jewellery='$export_other_precious_metal_jewellery',export_pearls='$export_pearls',export_coloured_gemstones='$export_coloured_gemstones',export_gold_jewellery='$export_gold_jewellery',export_studded_gold_jewellery='$export_studded_gold_jewellery',export_silver_jewellery='$export_silver_jewellery',export_studded_silver_jewellery='$export_studded_silver_jewellery',export_rough_diamonds='$export_rough_diamonds',export_cut_polished_diamonds='$export_cut_polished_diamonds',export_other_items='$export_other_items',export_total='$export_total',import_findings_mountings='$import_findings_mountings',import_false_pearls='$import_false_pearls',import_rough_imitation_stones='$import_rough_imitation_stones',import_silver='$import_silver',import_raw_pearls='$import_raw_pearls',import_cut_polished_gemstones='$import_cut_polished_gemstones',import_rough_gemstones='$import_rough_gemstones',import_gold='$import_gold',import_cut_polished_diamonds='$import_cut_polished_diamonds',import_rough_diamonds='$import_rough_diamonds',import_synthetic_stones='$import_synthetic_stones',import_gold_jewellery='$import_gold_jewellery',import_silver_jewellery='$import_silver_jewellery',import_other_items='$import_other_items',import_total='$import_total',export_fob_value='$export_fob_value',import_cif_value='$import_cif_value',challan_financial_year='$cur_fin_yr',challan_region_name='$region_code',challan_region_no='$challan_no',gjepc_account_no='$gjepc_account_no',payment_mode='$payment_mode',membership_fees='$membership_fees',admission_fees='$admission_fees',ad_valorem='$ad_valorem',total='$total',service_tax='$service_tax',total_payable='$total_payable',bank_name='$bank_name',branch_name='$branch_name',branch_city='$branch_city',branch_postal_code='$branch_postal_code',cheque_no='$cheque_no',cheque_date='$cheque_date',ReferenceNo='$ReferenceNo',declaration='$declaration',status='1',post_date='$post_date',ip_address='$ip_address'";

	if (!mysql_query($sql1))
	{
		die('Error: ' . mysql_error());
	}
}	
	$sql2="update approval_master set membership_type='R',renewal_download_status='N',membership_expiry_status='N',membership_renewal_dt='$post_date',post_date='$post_date' where registration_id='$registration_id'";
	if (!mysql_query($sql2))
	{
		die('Error: ' . mysql_error());
	}
	
	echo "Email:".$email_id=getUserEmail($registration_id);echo "<br/>";
	echo "Company Name".$company_name=getNameCompany($registration_id);echo "<br/>";
	echo "Pan No".$comoany_pan_no=getCompanyPan($registration_id);echo "<br/>";
	echo "BP N".$company_bp_no=getBPNO($registration_id);
	
	$key="2200043013901118";
	
	$mandate_str=aes128Encrypt($ReferenceNo."|1|".$total_payable."|".$email_id."|".$company_name."|".$comoany_pan_no,$key);
	$optional_str=aes128Encrypt($company_bp_no,$key);
	
	$return_url_str=aes128Encrypt("https://gjepc.org/payment_success.php",$key);
	$reference_str=aes128Encrypt($ReferenceNo,$key);
	$submerchant_str=aes128Encrypt("1",$key);
	$amount_str=aes128Encrypt($total_payable,$key);
	$payment_mode_str=aes128Encrypt($payment_mode,$key);
	
	//echo "plain text:".$encypted_text="https://eazypay.icicibank.com/EazyPG?merchantid=221392&mandatory fields=".$ReferenceNo."|1|".$total_payable."|".$email_id."|".$company_name."|".$comoany_pan_no."&optional fields=".$company_bp_no."&returnurl=https://gjepc.org/payment_success.php&Reference No=".$ReferenceNo."&submerchantid=1&transaction amount=".$total_payable."&paymode=".$payment_mode;

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

?>

<?php 
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


$qrenewded=mysql_query("select deadline_date from renewal_deadline_master");
$rrenewded=mysql_fetch_array($qrenewded);
$deadline_date=$rrenewded['deadline_date'];

$qfees=mysql_query("select membership_fee,admission_fee,ad_valorem from export_amount_master where financial_year='$cur_fin_yr' and export_start_amount='0' and status='1'");
	$rfees=mysql_fetch_array($qfees);
	$membership_fees=$rfees['membership_fee'];
	
	if($deadline_date>=date("Y-m-d"))
	{
		 $admission_fees='0';
	}else
	{
	    $admission_fees=$rfees['admission_fee'];
	}
	
	
	//$ad_valorem=$rfees['ad_valorem'];
	$total=$membership_fees+$admission_fees;
	if($_SESSION['sez_member']=="Y")
		$service_tax=0;
	else
		$service_tax=round(($total*18)/100);
		
	$total_payable=$total+$service_tax;

?>

<script>
$('input[type="date"]').datepicker({
	    minDate: 0,
	    autoclose: true, 
	    todayHighlight: true,
	    format: "dd/mm/yyyy"
    });
</script>	
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<script type="text/javascript">
$().ready(function() { 
	$("input[name='gst_holder']").on('change', function () {
         var gst_holder = $("input[name='gst_holder']:checked").val();
         if (gst_holder=='N')
               $("#gst_no").val("NA");
		  else
		  	$("#gst_no").val($('#gst_no_hid').val());
     });
	$.validator.addMethod("gst_no", function(value, element) {
	if(value=='NA')
		return true;
	else {
	return this.optional(element) || /^([0][1-9]|[1-2][0-9]|[3][0-7])([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$/.test(value);
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
			import_total: "required",
			export_fob_value: "required",
			import_cif_value: "required",
			gjepc_account_no: "required",
			pan_no: "required",
			gst_holder:"required",
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
			cheque_no: "required",
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
			import_total: "Please enter total",
			export_fob_value: "Please enter F.O.B value of exports",
			import_cif_value: "Please enter C.I.F value of imports",
			gjepc_account_no: "Please enter GJEPC account number",
			pan_no: "Please Enter PAN number",
			gst_holder: "Please Select GST Status",
			gst_no: {
				required: "Please Enter GSTIN No.",
				minlength:"Please enter not less than 15 characters",
				maxlength:"Please enter not more than 15 characters"
				},
			payment_mode: "Required.",
			membership_fees: "Please enter membership fees",
			admission_fees: "Please enter admission fees",
			total: "Please enter total amount",
			service_tax: "Please enter service tax",
			total_payable: "Please enter total payable",
			
			bank_name: "Please enter bank name",
			
			branch_name: "Please enter branch name",
			branch_city: "Please enter bank city",
			branch_postal_code: 
			{
				required: "Please enter your pin code",
				number:"please enter numbers only",
				minlength:"please enter not less than 6 characters",
				maxlength:"please enter not more than 6 characters"	
			},  
			cheque_no: "Please enter Cheque/DD No",
			cheque_date: "Please enter Cheque Date",
		    declaration: "Please select declaration",
		}
	});
});
</script>
<!--.....................Get And Set value for export.....................-->

<script>
function getexportdata()
{
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
	var export_other_items=document.getElementById("export_other_items").value;
	if(export_other_items==""){export_other_items=0;}
	
	var tot_examount=parseInt(export_sales_to_foreign_tourists)+parseInt(export_synthetic_stones)+parseInt(export_costume_jewellery)+parseInt(export_other_precious_metal_jewellery)+parseInt(export_pearls)+parseInt(export_coloured_gemstones)+parseInt(export_gold_jewellery)+parseInt(export_studded_gold_jewellery)+parseInt(export_silver_jewellery)+parseInt(export_studded_silver_jewellery)+parseInt(export_rough_diamonds)+parseInt(export_cut_polished_diamonds)+parseInt(export_other_items);
	
	document.getElementById("export_total").value = tot_examount;
	document.getElementById("export_fob_value").value = tot_examount;
	
	$.ajax({
			   type: "POST",
			   url: "ajax.php",
			   data: "actiontype=paymentdetailsexport_renew&paymentamnt="+tot_examount,
			   success: function(data){ //alert(data);
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
	var import_other_items=document.getElementById("import_other_items").value;
	if(import_other_items==""){import_other_items=0;}
	
	var tot_imamount=parseInt(import_findings_mountings)+parseInt(import_false_pearls)+parseInt(import_rough_imitation_stones)+parseInt(import_silver)+parseInt(import_raw_pearls)+parseInt(import_cut_polished_gemstones)+parseInt(import_rough_gemstones)+parseInt(import_gold)+parseInt(import_cut_polished_diamonds)+parseInt(import_rough_diamonds)+parseInt(import_synthetic_stones)+parseInt(import_gold_jewellery)+parseInt(import_silver_jewellery)+parseInt(import_other_items);
	
	document.getElementById("import_total").value = tot_imamount;
	document.getElementById("import_cif_value").value = tot_imamount;
	
	export_amnt=document.getElementById("export_fob_value").value;
	
		$.ajax({
			   type: "POST",
			   url: "ajax.php",
			   data: "actiontype=paymentdetailsimport_renew&paymentamnt_import="+tot_imamount+"&export_amnt="+export_amnt,
			   success: function(data){ //alert(data);
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

<!-- Datepicker Start -->
<script src="js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link href="css/datepicker.css" rel="stylesheet" type="text/css" />

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
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="title">
			<h4>My Account - Membership & RCMC - Challan Form</h4>
		</div>
	</div>

	<div class="col-md-4 col-sm-4 col-xs-12 wrapper selectedSpeaker">
		<?php include 'include/regMenu.php'; ?>
	</div>

	<div class="col-md-8 col-sm-8 col-xs-12  speakerSelector">
		<div class="sub_head">Export Performance Details, FOB in INR</div>
		
<form action="" method="post" id="challanForm" name="challanForm">			
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}

if($_SESSION['form_chk_msg']!="" || $_SESSION['form_chk_msg1']!="" || $_SESSION['form_chk_msg2']!=""){
echo "<span class='notification n-attention'>";
if($_SESSION['form_chk_msg']!=""){
echo $_SESSION['form_chk_msg']."<br>";
}
if($_SESSION['form_chk_msg1']!=""){
echo $_SESSION['form_chk_msg1']."<br>";
}
if($_SESSION['form_chk_msg2']!=""){
echo $_SESSION['form_chk_msg2'];
}
echo "</span>";
$_SESSION['form_chk_msg']="";
$_SESSION['form_chk_msg1']="";
$_SESSION['form_chk_msg2']="";
}
?>
<?php 
$sql="SELECT * FROM `challan_master` WHERE 1 and registration_id='$registration_id' order by id desc limit 1";
$result=mysql_query($sql);
$rows=mysql_fetch_array($result);
$Response_Code=$rows['Response_Code'];
			
?>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="export_coloured_gemstones">Coloured Gemstones : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control"  id="export_coloured_gemstones" name="export_coloured_gemstones" value="0" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"></div>
			</div>
            
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="export_costume_jewellery">Costume/Fashion Jewellery : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control"  id="export_costume_jewellery" name="export_costume_jewellery" value="0" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"></div>
			</div>
            
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="export_cut_polished_diamonds">Cut & Polished Diamonds : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control"  id="export_cut_polished_diamonds" name="export_cut_polished_diamonds" value="0" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"></div>
			</div>
            
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="export_gold_jewellery">Plain Gold Jewellery : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control"  id="export_gold_jewellery" name="export_gold_jewellery" value="0" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"></div>
			</div>
            
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="export_studded_gold_jewellery">Studded Gold Jewellery : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control"  id="export_studded_gold_jewellery" name="export_studded_gold_jewellery" value="0" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"></div>
			</div>
            
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="export_silver_jewellery">Plain Silver Jewellery : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="export_silver_jewellery" name="export_silver_jewellery" value="0" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"></div>
			</div>
            
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="export_studded_silver_jewellery">Studded Silver Jewellery : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control"  id="export_studded_silver_jewellery" name="export_studded_silver_jewellery" value="0" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"></div>
			</div>
            
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="export_other_precious_metal_jewellery">Other Precious Metal Jewellery : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control"  id="export_other_precious_metal_jewellery" name="export_other_precious_metal_jewellery" value="0" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"></div>
			</div>
            
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="export_pearls">Pearls : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="export_pearls" name="export_pearls" value="0" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"></div>
			</div>
            
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="export_rough_diamonds">Rough Diamonds : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="export_rough_diamonds" name="export_rough_diamonds"value="0" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"></div>
			</div>
            
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="export_sales_to_foreign_tourists">Sales to Foreign Tourists : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="export_sales_to_foreign_tourists" name="export_sales_to_foreign_tourists" value="0" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"></div>
			</div>
            
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="export_synthetic_stones">Synthetic Stones : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control"  id="export_synthetic_stones" name="export_synthetic_stones" value="0" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"></div>
			</div>
            
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="export_other_items">Other Items : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="export_other_items" name="export_other_items" value="0" onKeyUp="getexportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"></div>
			</div>
            
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="export_total">Total : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="export_total" name="export_total" value="0" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"></div>
			</div>
            
            
            
            <div class="sub_head">Import Performance Details, CIF in INR</div>
            
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="import_cut_polished_diamonds">Cut & Polished Diamonds : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" name="import_cut_polished_diamonds" id="import_cut_polished_diamonds" value="0" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/></div>
			</div>
            
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="import_cut_polished_gemstones">Cut & Polished Gemstones : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" name="import_cut_polished_gemstones" id="import_cut_polished_gemstones" value="0" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/></div>
			</div>
            
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="import_false_pearls">Processed & Finished Pearls : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" name="import_false_pearls" id="import_false_pearls" value="0" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/></div>
			</div>
            
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="import_findings_mountings">Findings & Mountings : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" name="import_findings_mountings" id="import_findings_mountings" value="0" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/></div>
			</div>
            
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="import_gold">Gold Bar : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" name="import_gold" id="import_gold" value="0" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/></div>
			</div>
            
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="import_raw_pearls">Raw Pearls : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" name="import_raw_pearls" id="import_raw_pearls" value="0" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/></div>
			</div>
            
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="import_rough_diamonds">Rough Diamond: : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" name="import_rough_diamonds" id="import_rough_diamonds" value="0" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/></div>
			</div>
            
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="import_rough_gemstones">Rough Gemstones : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" name="import_rough_gemstones" id="import_rough_gemstones" value="0" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/></div>
			</div>
            
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="import_rough_imitation_stones">Rough Imitation Stones, Glass Beads/ Glass Chattons : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control"  name="import_rough_imitation_stones" id="import_rough_imitation_stones" value="0" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/></div>
			</div>
            
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="import_silver">Silver, Platinum, Palladium : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" name="import_silver" id="import_silver" value="0" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';" /></div>
			</div>
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="import_synthetic_stones">Synthetic stones : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" name="import_synthetic_stones" id="import_synthetic_stones" value="0" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/></div>
			</div>
            
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="import_gold_jewellery">Gold Jewellery : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" name="import_gold_jewellery" id="import_gold_jewellery" value="<?php echo $import_gold_jewellery; ?>" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/></div>
			</div>
            
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="import_silver_jewellery">Silver Jewellery : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" name="import_silver_jewellery" id="import_silver_jewellery" value="<?php echo $import_silver_jewellery; ?>" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/></div>
			</div>
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="import_other_items">Other Items : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" name="import_other_items" id="import_other_items" value="0" onKeyUp="getimportdata()" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/></div>
			</div>
            
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="import_total">Total : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control"  name="import_total" id="import_total" value="0" readonly="readonly" onFocus="if(this.value=='0')value='';" onBlur="if(this.value=='')value='0';"/></div>
			</div>
            
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="export_fob_value">F.O.B value of exports : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" name="export_fob_value" id="export_fob_value" value="0" readonly="readonly" /></div>
			</div>
            
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="import_cif_value">C.I.F value of imports : <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control"  name="import_cif_value" id="import_cif_value" value="0" readonly="readonly"/></div>
			</div>
            
            <div class="sub_head">Payment Details</div>
            
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="pan_no">PAN No.: <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="pan_no" name="pan_no" 
				 <?php if(!empty($pan_no)){?> value="<?php echo $pan_no;?>" readonly="readonly" <?php } ?>/></div>
			</div>
            
            <div class="form-group row">
                <div class="col-md-6"><label class="form-label" for="company_name">GST Holder: <span>*</span></label></div>
                <div class="col-md-6">
                    <div class="form-group radio inline-form">
                        <label for="Yes"><input type="radio" name="gst_holder" id="gst_holder" value="Y"/>Yes</label>			
                        <label for="No"><input type="radio" name="gst_holder" id="gst_holder" value="N"/>No</label>
                    </div>
                </div>
            </div>
            
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="gst_no">GSTIN No.: <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="gst_no" name="gst_no" maxlength="15" value="<?php echo $gst_no;?>"/></div>
			</div>
			<!--<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="gst_no">GSTIN No.: <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="gst_no" name="gst_no" maxlength="15" <?php if(empty($gst_no)){?> value="NA"<?php } else {?> value="<?php echo $gst_no;?>" <?php } ?>/></div>
			</div>-->
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="gjepc_account_no">GJEPC Account Number: <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="gjepc_account_no" name="gjepc_account_no" value="<?php echo $gjepc_account_no;?>" placeholder="GJEPC Account Number" readonly="readonly" /></div>
			</div>
            <div id="manufDiv">
				<div class="form-group row">
					<div class="col-md-6"><label class="form-label" for="company_name">Payment Mode: <span>*</span></label></div>
					<div class="col-md-6">
						<div class="form-group radio inline-form">
							<label for="No"><input type="radio" name="payment_mode" id="payment_mode" value="3" <?php if($payment_mode=="3"){?> checked="checked"<?php }?>/>NetBanking</label>			
							<label for="Yes"><input type="radio" name="payment_mode" id="payment_mode" value="4" <?php if($payment_mode=="4"){?> checked="checked"<?php }?>/>Debit Card</label>
							<label for="No"><input type="radio" name="payment_mode" id="payment_mode" value="5" <?php if($payment_mode=="5"){?> checked="checked"<?php }?>/>Credit Card</label>				  
                            <label for="No"><input type="radio" name="payment_mode" id="payment_mode" value="2" <?php if($payment_mode=="2"){ ?> checked="checked"<?php } ?>/>RTGS/NEFT </label>
                            <label for="No"><input type="radio" name="payment_mode" id="payment_mode" value="1" <?php if($payment_mode=="1"){ ?> checked="checked"<?php } ?>/>Cheque/DD </label>
						</div>
					</div>
				</div>
			</div>
             <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="membership_fees">Membership Fees: <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="membership_fees" name="membership_fees" value="<?php echo $membership_fees;?>" readonly="readonly" placeholder="Membership Fees"/></div>
			</div>
             <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="admission_fees">Admission Fees: <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="admission_fees" name="admission_fees" value="<?php echo $admission_fees;?>" readonly="readonly" placeholder="Admission Fees"/></div>
			</div>
             <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="total">Total: <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="total" name="total" value="<?php echo $total;?>" readonly="readonly"/></div>
			</div>
             <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="service_tax">GST @ 18%</label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="service_tax" name="service_tax"  value="<?php echo $service_tax;?>" readonly="readonly"/></div>
			</div>
             <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="total_payable">Total Payable (in rupees): <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="total_payable" name="total_payable" value="<?php echo $total_payable;?>" readonly="readonly"/></div>
			</div>
            
            <div id="bank_details" <?php if($payment_mode!='1'){?> style="display: none" <?php }?>>
            <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="member_type_id">Drawn on Bank: <span>*</span></label></div>
				<div class="col-md-6">					
				<select name="bank_name" id="bank_name" class="form_text_text">
				<option value="">---------- Select Bank ----------</option>
				<?php 
				$query=mysql_query("select * from bank_master where status=1 order by bank_name");
				while($result=mysql_fetch_array($query)){
				?>
				<option value="<?php echo $result['bank_name'];?>" <?php if($result['bank_name']==$bank_name){?> selected="selected" <?php }?>><?php echo strtoupper($result['bank_name']);?></option>
			   <?php }?>
				</select> 
				</div>
			</div>
            
             <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="branch_name">Bank Branch: <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="branch_name" name="branch_name" value="<?php echo $branch_name;?>" placeholder="Branch" /></div>
			</div>
             <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="branch_city">Bank City: <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="branch_city" name="branch_city" value="<?php echo $branch_city;?>" placeholder="City"></div>
			</div>
             <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="branch_postal_code">Branch Postal Code: <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="branch_postal_code" name="branch_postal_code" value="<?php echo $branch_postal_code;?>" placeholder="Postal Code" /></div>
			</div>
			<div class="form-group row" >
				<div class="col-md-6"><label class="form-label" for="cheque_no">Cheque/DD No.: <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="cheque_no" name="cheque_no" value="<?php echo $cheque_no;?>" placeholder="Cheque/DD No."></div>
			</div>
           
             <div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="cheque_date">Cheque Date (DD-MM-YYYY): <span>*</span></label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="cheque_date" name="cheque_date" value="<?php echo $cheque_date;?>" readonly/></div>
			</div>
            </div>        
            <div class="sub_head">Declaration</div>
            
            <div class="tablewidth_101"> 
			<div class="chexbox"><input type="checkbox" name="declaration" id="declaration" value="1"  checked="checked"></div>
			<div class="normal_text">I/We hereby solemnly affirm and declare that our previous financial year exports of gems and jewellery items and import of gems and jewellery raw materials amounted to the mentioned amount in this form.</div>
			</div>
			
			<div class="form-group row">
				<div class="col-md-offset-6 col-md-6">
				<input type="hidden" name="action" value="save" />
				<input type="hidden" name="registration_id" id="registration_id" value="<?php echo $registration_id;?>" />
				<input type="hidden" name="region_id" id="region_id" value="<?php echo $region_id;?>" />
                
				<?php if($Response_Code!="E000"){?><input class="btn" type="submit" value="Submit" /><?php } else {?>
                <div class="sub_head">You have already made the payment</div>
                <?php }?>
					
				</div>
			</div>

		</form>
	


<?php include 'include/footer.php'; ?>