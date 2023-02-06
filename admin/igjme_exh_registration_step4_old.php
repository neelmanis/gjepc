<?php 
session_start(); 
ob_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
include('../db.inc.php');
include('../functions.php');
?>

<?php 
$gid	=	intval(filter($_REQUEST['id']));
$registration_id	=	intval(filter($_REQUEST['registration_id']));
$modified_date = date("Y-m-d");

$show = "IGJME";
$sql1="select * from exh_reg_general_info where  uid='$registration_id' and event_for='$show' and id='$gid'";
$result1=$conn->query($sql1);
$rows1=$result1->fetch_assoc();
$country = filter($rows1['country']);
$contact_person	=	filter($rows1['contact_person']);
$company_name	=	filter($rows1['company_name']);

if($country=='IN'){
	$currency='INR';
	$int_type = "N";
} else {
	$currency='USD';
	$int_type = "I";
}
?>

<?php
$saveUTR = $_POST['saveUTR'];
if($saveUTR=="saveinfo")
{
	$gcodes = "";
	$utr_number = $_POST['utr_number'];
	$event = $_POST['event'];
	$year = 2022;
	$amountPaid = $_POST['amountPaid'];
	$tdsAmount = $_POST['tdsAmount'];
	if(empty($event)) { $eventError = "Plz Select Event Participated"; }
	elseif(empty($utr_number)) { $utrNameError = "Plz Enter UTR Number"; }
	elseif(empty($amountPaid)) { $amountPaidError = "Plz Enter Amount Paid"; }
	else {
		if($event=="igjme22"){ $event_for="IGJME"; } 
		$mmx = "SELECT * FROM `utr_history` WHERE registration_id='$registration_id' AND utr_number='$utr_number' AND `show`='$event_for' AND `event_selected`='$event'";
		$mmxResult = $conn->query($mmx);
		$countUTR = $mmxResult->num_rows;
		if($countUTR > 0)
		{
			$mmRowx = $mmxResult->fetch_assoc();
			$id = $mmRowx['id'];
			
		$updateUTR = "UPDATE `utr_history` SET `modified_date`=NOW(),`utr_number`='$utr_number',`amountPaid`='$amountPaid', `tdsAmount`='$tdsAmount' WHERE `registration_id`='$registration_id' AND id='$id' AND `show`='$event_for' AND `event_selected`='$event'";
			$resultUTR = $conn->query($updateUTR);
			if($resultUTR) { $utrNameSuccess = "Saved Successfully"; }
		} else {
		$insertUTR = "INSERT INTO `utr_history`(`post_date`, `registration_id`, `utr_number`,`amountPaid`, `tdsAmount`, `show`,`event_selected`, `status`) VALUES (NOW(),'$registration_id','$utr_number','$amountPaid','$tdsAmount','$event_for','$event','1')";
			$resultUTR = $conn->query($insertUTR);
			if($resultUTR) { $utrNameSuccess = "Saved Successfully"; }
		}
	}
}
?>

<?php
$sqlm="select * from exh_registration where uid='$registration_id' and gid='$gid' and `show`='$show'";
$querym=$conn->query($sqlm);		
$resultm=$querym->fetch_assoc();
$grandTotals = $resultm["grand_total"];
?>
<?php
$sql="select  * from exh_reg_payment_details where gid='$gid' and uid='$registration_id' AND  `show` =  '$show'";
$result=$conn->query($sql);
$rows=$result->fetch_assoc();
$payment_id = $rows["payment_id"];
$payment_mode = $rows["payment_mode"];
$percentage = $rows["percentage"];
$net_payable_amount = $rows["net_payable_amount"];

$cheque_dd_no = filter($rows["cheque_dd_no"]);
$cheque_dd_date = date("d-m-Y",strtotime($rows["cheque_dd_date"]));
$cheque_drawn_bank_name = filter($rows["cheque_drawn_bank_name"]);
$cheque_drawn_branch_name = filter($rows["cheque_drawn_branch_name"]);

$bank_acc_no = filter($rows["bank_acc_no"]);
$name_bank = filter($rows["name_bank"]);
$name_bank_branch = filter($rows["name_bank_branch"]);
$ifsc_code = filter($rows["ifsc_code"]);

$int_acc_type = filter($rows["int_acc_type"]);
$int_bank_acc_no = filter($rows["int_bank_acc_no"]);
$int_name_bank = filter($rows["int_name_bank"]);
$int_name_bank_branch = filter($rows["int_name_bank_branch"]);
$int_bank_address = filter($rows["int_bank_address"]);
$int_beneficiary_name = filter($rows["int_beneficiary_name"]);
$int_swift_code = filter($rows["int_swift_code"]);
$int_iban_no = filter($rows["int_iban_no"]);

$tds_holder = filter($rows["tds_holder"]);
$cheque_tds_per = filter($rows["cheque_tds_per"]);
$cheque_tds_amount = filter($rows["cheque_tds_amount"]);
$cheque_tds_Netamount = filter($rows["cheque_tds_Netamount"]);

$payment_status=$rows["payment_status"];
$document_status=$rows["document_status"];
$payment_dissapprove_reason=$rows["payment_dissapprove_reason"];
$document_dissapprove_reason=$rows["document_dissapprove_reason"];
?>

<?php
if(isset($_REQUEST["action"]))
{
	$utr_id = $_POST['utr_id'];
	$utr_date = $_POST['utr_date'];
	$utr_approved = $_POST['utr_approved'];
	for($i=0;$i<sizeof($utr_id);$i++) {
	if(in_array($utr_id[$i], $utr_approved))
		$utr_approve="Y";
	else
		$utr_approve="P";
		
	$sqll = "UPDATE `utr_history` SET utr_date='$utr_date[$i]',utr_approved='$utr_approve' WHERE id='$utr_id[$i]' AND `registration_id`='$registration_id'";
	$mmx= $conn->query($sqll);
	}
	
	$action = mysqli_real_escape_string($conn,$_REQUEST["action"]);
	$payment_mode = mysqli_real_escape_string($conn,$_REQUEST["payment_mode"]);
	/* 50% or 100% */
	$amount_payable = mysqli_real_escape_string($conn,$_POST["amount_payable"]);
	$net_payable_amount = mysqli_real_escape_string($conn,$_POST["net_payable_amount"]);
	
	$approval = $_REQUEST["approval"];
	$doc_approval = $_REQUEST["doc_approval"];
	if($approval=="rejected")
	{
		$payment_dissapprove_reason=mysqli_real_escape_string($conn,$_REQUEST['payment_dissapprove_reason']);
	}
	else
	{
		$payment_dissapprove_reason="";
	}
	
	if($doc_approval=="rejected")
	{
		$document_dissapprove_reason=mysqli_real_escape_string($conn,$_REQUEST['document_dissapprove_reason']);
	}
	else
	{
		$document_dissapprove_reason="";
	}
	
	if($action=='UPDATE')
	{
		
		if($country == "INDIA" || $country == "IND" || $country == "IN")
		{
				if($payment_mode=="RTGS")
				{
					$cheque_dd_no = "";
					$cheque_dd_date = "";
					$cheque_drawn_bank_name = "";
					$cheque_drawn_branch_name = "";
				}
				else
				{
					$cheque_dd_no = mysqli_real_escape_string($conn,$_POST["cheque_dd_no"]);
					$cheque_dd_date = mysqli_real_escape_string($conn,date("Y-m-d", strtotime($_POST["cheque_dd_date"])));
					$cheque_drawn_bank_name = mysqli_real_escape_string($conn,$_POST["cheque_drawn_bank_name"]);
					$cheque_drawn_branch_name = mysqli_real_escape_string($conn,$_POST["cheque_drawn_branch_name"]);
				}
				
				$bank_acc_no = mysqli_real_escape_string($conn,$_POST["bank_acc_no"]);
				$name_bank = mysqli_real_escape_string($conn,$_POST["bank_name"]);
				$name_bank_branch = mysqli_real_escape_string($conn,$_POST["branch_name"]);
				$ifsc_code = mysqli_real_escape_string($conn,$_POST["ifsc_code"]);
				$int_acc_type = mysqli_real_escape_string($conn,$_POST["int_acc_type"]);
				
				/*  TDS Start */
				$tds_holder = mysqli_real_escape_string($conn,$_POST["tds_holder"]);
				if($tds_holder == 'Yes') {
				$cheque_tds_per = mysqli_real_escape_string($conn,$_POST["cheque_tds_per"]);				
				$cheque_tds_amount = mysqli_real_escape_string($conn,$_POST["cheque_tds_amount"]);
				$cheque_tds_Netamount = mysqli_real_escape_string($conn,$_POST["cheque_tds_Netamount"]);		
				} else {						
				$cheque_tds_per = "";				
				$cheque_tds_amount = "";
				$cheque_tds_Netamount = "";
				}
				/*  TDS End */
				$netTotal = $grandTotals * $amount_payable/100;
				//echo '---'.$net_payable_amount .'=='. $netTotal; exit;
				/*if($net_payable_amount == $netTotal)
				{*/
				$update_query = "update exh_reg_payment_details set payment_mode='$payment_mode', cheque_dd_no='$cheque_dd_no', cheque_dd_date='$cheque_dd_date', cheque_drawn_bank_name='$cheque_drawn_bank_name', cheque_drawn_branch_name='$cheque_drawn_branch_name', bank_acc_no='$bank_acc_no', name_bank='$name_bank', name_bank_branch='$name_bank_branch', ifsc_code='$ifsc_code', int_acc_type='$int_acc_type', modified_date='$modified_date', payment_status='$approval', document_status='$doc_approval',payment_dissapprove_reason='$payment_dissapprove_reason',document_dissapprove_reason='$document_dissapprove_reason',`net_payable_amount`='$net_payable_amount',`percentage`='$amount_payable',`tds_holder`='$tds_holder',`cheque_tds_per`='$cheque_tds_per',`cheque_tds_amount`='$cheque_tds_amount',`cheque_tds_Netamount`='$cheque_tds_Netamount' where payment_id='$payment_id' and gid='$gid' and uid='$registration_id' and `show`='$show'";
				//} else { echo 'wrong amount';}				
		}
		else
		{
				$int_acc_type = mysqli_real_escape_string($conn,$_POST["int_acc_type"]);
				$int_bank_acc_no = mysqli_real_escape_string($conn,$_POST["bank_acc_no"]);
				$int_name_bank = mysqli_real_escape_string($conn,$_POST["bank_name"]);
				$int_name_bank_branch = mysqli_real_escape_string($conn,$_POST["branch_name"]);	
				$int_bank_address = mysqli_real_escape_string($conn,$_POST["int_bank_address"]);
				$int_beneficiary_name = mysqli_real_escape_string($conn,$_POST["int_beneficiary_name"]);
				$int_swift_code = mysqli_real_escape_string($conn,$_POST["int_swift_code"]);
				$int_iban_no = mysqli_real_escape_string($conn,$_POST["int_iban_no"]);				
				
				$update_query = "update exh_reg_payment_details set int_acc_type='$int_acc_type', int_bank_acc_no='$int_bank_acc_no', int_name_bank='$int_name_bank', int_name_bank_branch='$int_name_bank_branch', int_bank_address='$int_bank_address', int_beneficiary_name='$int_beneficiary_name', int_swift_code='$int_swift_code', int_iban_no='$int_iban_no', modified_date='$modified_date', payment_status='$approval', document_status='$doc_approval',payment_dissapprove_reason='$payment_dissapprove_reason',document_dissapprove_reason='$document_dissapprove_reason' where payment_id='$payment_id' and gid='$gid' and uid='$registration_id' and `show`='$show'";				
		}
		
		$result_update=$conn->query($update_query);
		
		if(!$result_update)
			$_SESSION['succ_msg']="Problems while updating Record";
		else
		{
			$app_query = "select payment_status,document_status from exh_reg_payment_details where payment_id='$payment_id' and gid='$gid' and uid='$registration_id' and `show`='$show'";
			$result_app = $conn->query($app_query);
			if($result_app)
			{
				$app_array =$result_app->fetch_assoc();
				$ps = $app_array["payment_status"];
				$ds = $app_array["document_status"];
				
				if($ps=="pending" || $ds=="pending")
					$app_status = "pending";
				elseif($ps=="rejected" || $ds=="rejected")
					$app_status = "rejected";
				else
					$app_status = "approved";
					
				$update_app_query = "update exh_reg_payment_details set application_status='$app_status' where payment_id='$payment_id' and gid='$gid' and uid='$registration_id' and `show`='$show'";
				
				$update_app = $conn->query($update_app_query);
				
				$message ='<table width="100%" bgcolor="#fbfbfb" style="margin:20px auto; border:2px solid #dddddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
<tr>
<td style="padding:30px;">
<table width="100%" border="0" background="#fbfbfb" cellpadding="0" cellspacing="0">
    <tr>
	<td align="left"><a href="http://www.gjepc.org"><img src="https://gjepc.org/assets/images/logo.png" /></a></td>
    <td align="right" valign="top"><a href="https://gjepc.org/igjme"><img src="https://gjepc.org/igjme/assets-new/images/logo.jpg" width="140" height="70" /></a></td>
    </tr>     
    <tr><td colspan="2" height="25px">&nbsp;</td></tr>
    <tr><td colspan="2" height="1px" bgcolor="#333333"></td></tr>
    <tr><td colspan="2" height="25px">&nbsp;</td></tr>    
    <tr>
    	<td colspan="2" valign="top" style="font-size:13px;">
    	<p><strong>Dear '.$contact_person.',</strong> </p>
    	<p><strong>Company Name : '.$company_name.'</strong> </p>
    	</td>
    </tr>    
    <tr>
    <td colspan="2">

<table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" style="border-collapse:collapse; float:right;">
  <tr valign="top">
    <td colspan="2"  style="color:#14b3da;"><strong>Application Approval Summary</strong><br /></td>
    </tr>
  <tr valign="top">
    <td width="30%"><strong>Payment Approval Status </strong></td>
    <td width="21%">'.$approval.'</td>
  </tr>
  <tr valign="top">
    <td><strong>Document Approval Status</strong></td>
    <td>'.$doc_approval.'</td>
  </tr>
  <tr valign="top">
    <td><strong>Application Approval Status</strong></td>
    <td>'.$app_status.'</td>
  </tr>
  <tr valign="top">
    <td valign="top"><strong>Payment Dissapproval Reason</strong></td>
    <td valign="top">'.$payment_dissapprove_reason.'</td>
  </tr>
  <tr valign="top">
    <td><strong>Document Dissapproval Reason</strong></td>
    <td>'.$document_dissapprove_reason.'<br /></td>
  </tr>
</table>
	</td>
  </tr>  
    <tr>
    	<td colspan="2" height="25px">&nbsp;</td>
    </tr>
    <tr>
</tr>
    
    <tr>
    <td colspan="2" style="line-height:20px;">
<p>Kind Regards,</p>

<p><strong>IGJME Web Team,</strong></p>

</td>
</tr>
</table>

</td>
</tr>

</table>';
	
				//$to=getUserEmail($registration_id,$conn).',notification@gjepcindia.com';
				$to='mukesh@gjepcindia.com,neelmani@kwebmaker.com';
				$subject = "IGJME Exhibitor Registration Approval Status/dated".date('Y-m-d').")";
				$headers  = 'MIME-Version: 1.0' . "\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";	
				$headers .='From: IGJME 2023 <admin@gjepc.org>';	
				@mail($to, $subject, $message, $headers);
				if($update_app)
				{
					header("Location:igjme_exhibitor_rgistration.php");
				}
			}
		}	
	}	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IGJME &gt; Exhibitor Registration &gt; Step-4</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/formAdmin.css"/>
<!--navigation-->
<script type="text/javascript" src="js/jqueryNew.js"></script>  
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	$('#popupDatepicker').datepick();
	$('#inlineDatepicker').datepick({onSelect: showDate});
	$('#popupDatepicker1').datepick();
	$('#inlineDatepicker1').datepick({onSelect: showDate});
});
function showDate(date) {
	alert('The date chosen is ' + date);}
</script>

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

<!-- lightbox Thum -->
<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen" />
	
	<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="js/jquery.fancybox-1.2.1.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("div.fancyDemo a").fancybox();
		});
	</script>
<!-- lightbox Thum -->

<script type="text/javascript" src="../js/member_directory_pvr.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	if($("#payment_mode").val()=="RTGS")
	{
		$("#rtgs_desc").css("display","block");
		$("#chequeordd").css("display","none");
	}
	else
	{
		$("#rtgs_desc").css("display","none");
		$("#chequeordd").css("display","block");
	}
	
	$("#payment_mode").change(function(){
		var value = $(this).val();
		//alert(value);
		
		if(value == "RTGS")
		{
			$("#rtgs_desc").css("display","block");
			$("#chequeordd").css("display","none");
		}
		else
		{
			$("#rtgs_desc").css("display","none");
			$("#chequeordd").css("display","block");
		}
	});
});
</script>

<script type="text/javascript">
function validation()
{
var payment_mode=$("#payment_mode").val();
var cheque_dd_no=$("#cheque_dd_no").val();
var datepicker=$("#datepicker").val();
var cheque_drawn_bank_name=$("#cheque_drawn_bank_name").val();
var cheque_drawn_branch_name=$("#cheque_drawn_branch_name").val();
var bank_acc_no=$("#bank_acc_no").val();
var bank_name=$("#bank_name").val();
var branch_name=$("#branch_name").val();

var ifsc_code=$("#ifsc_code").val();
var int_bank_address=$("#int_bank_address").val();
var int_beneficiary_name=$("#int_beneficiary_name").val();
var int_swift_code=$("#int_swift_code").val();
var int_iban_no=$("#int_iban_no").val();
var int_acc_type=$("#int_acc_type").val();

var flagpay = flagddno = flagdddate = flagcbankname = flagcbranchname = flagaccno = flagbankname = flagbranchname = flagifsc = flagiadd = flagibeneficiary = flagswift = flagiban = flagacctype = 0;

if(payment_mode=="")
{
	$("#payment_mode_error").text("Please Select One");
	var flagpay = 1;
}
else
{
	$("#payment_mode_error").text("");
	var flagpay = 0;
}

if($("#payment_mode").val()!="RTGS")
{

		if(cheque_dd_no=="")
		{
			$("#cheque_dd_no_error").text("Required");
			var flagddno = 1;
		}
		else
		{
			$("#cheque_dd_no_error").text("");
			var flagddno = 0;
		}
		
		if(datepicker=="")
		{
			$("#datepicker_error").text("Required");
			var flagdddate = 1;
		}
		else
		{
			$("#datepicker_error").text("");
			var flagdddate = 0;
		}
		
		if(cheque_drawn_bank_name=="")
		{
			$("#cheque_drawn_bank_name_error").text("Please Select One");
			var flagcbankname = 1;
		}
		else
		{
			$("#cheque_drawn_bank_name_error").text("");
			var flagcbankname = 0;
		}
		
		if(cheque_drawn_branch_name=="")
		{
			$("#cheque_drawn_branch_name_error").text("Required");
			var flagcbranchname = 1;
		}
		else
		{
			$("#cheque_drawn_branch_name_error").text("");
			var flagcbranchname = 0;
		}
}
if(bank_acc_no=="")
{
	$("#bank_acc_no_error").text("Required");
	var flagaccno = 1;
}
else
{
	$("#bank_acc_no_error").text("");
	var flagaccno = 0;
}

if(bank_name=="")
{
	$("#bank_name_error").text("Required");
	var flagbankname = 1;
}
else
{
	$("#bank_name_error").text("");
	var flagbankname = 0;
}

if(branch_name=="")
{
	$("#branch_name_error").text("Required");
	var flagbranchname = 1;
}
else
{
	$("#branch_name_error").text("");
	var flagbranchname = 0;
}

if(ifsc_code=="")
{
	$("#ifsc_code_error").text("Required");
	var flagifsc = 1;
}
else
{
	$("#ifsc_code_error").text("");
	var flagifsc = 0;
}

if(int_bank_address=="")
{
	$("#int_bank_address_error").text("Required");
	var flagiadd = 1;
}
else
{
	$("#int_bank_address_error").text("");
	var flagiadd = 0;
}

if(int_beneficiary_name=="")
{
	$("#int_beneficiary_name_error").text("Required");
	var flagibeneficiary = 1;
}
else
{
	$("#int_beneficiary_name_error").text("");
	var flagibeneficiary = 0;
}

if(int_swift_code=="")
{
	$("#int_swift_code_error").text("Required");
	var flagswift = 1;
}
else
{
	$("#int_swift_code_error").text("");
	var flagswift = 0;
}
if(int_iban_no=="")
{
	$("#int_iban_no_error").text("Required");
	var flagiban = 1;
}
else
{
	$("#int_iban_no_error").text("");
	var flagiban = 0;
}

if(int_acc_type=="")
{
	$("#int_acc_type_error").text("Please Select One");
	var flagacctype = 1;
}
else
{
	$("#int_acc_type_error").text("");
	var flagacctype = 0;
}

if(flagpay==1 || flagddno==1 || flagdddate==1 || flagcbankname==1 || flagcbranchname==1 || flagaccno==1 || flagbankname==1 || flagbranchname==1 || flagifsc==1 || flagiadd==1 || flagibeneficiary==1 || flagswift==1 || flagiban==1 || flagacctype==1)
	return false;
else
	return true;

}
</script>
<script type="text/javascript">
    $(function () {
		$("#amount_payable").on('change',function(){
			var amount_payable=$('#amount_payable').val(); 
			var gross_total=$('#grand_total').val()*amount_payable/100;
			$("#net_payable_amount").val(gross_total);
		});
    });
</script>
</head>

<body>


<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> Exhibitor Registration</div>
</div>

<div id="main">
	<div class="content">
    
    <div class="content_head">IGJME > Exhibitor Registration
      <div style="float:right; padding-right:10px; font-size:12px;"><a href="igjme_exhibitor_rgistration.php">Back to Search</a></div>
    </div>
    	
<div class="clear"></div>
<div class="content_details1">
<form name="form1" action="igjme_exh_registration_step4.php?id=<?php echo $gid; ?>&registration_id=<?php echo $registration_id; ?>&action=update" method="post" onsubmit="return validation()"> 
<?php 
if($_SESSION['error_msg']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
$_SESSION['error_msg']="";
}
?>

<ul id="tabs" class="tab_1">
    <li id=""><a href="#"><strong>Step 1 GENERAL INFORMATION</strong></a></li>
    <li id=""><a href="#"><strong>Step 2 Company Details</strong></a></li>  
    <li id=""><a href="#"><strong>Step 3 Participation Stall Details</strong></a></li>
    <li id=""><a href="#" class="lastBg active"><strong>Step 4 Payment Details</strong></a></li>  
    <div class="clear"></div>
</ul>

<div id="formCon">
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt">
<tr class="orange1"><td colspan="11" >UTR Details</td></tr>
	
<tr class="orange1">
    <td colspan="11" >Payment Details</td>
</tr>
		<?php 
		 $sql="select * from  exh_registration where uid='$registration_id' and gid='$gid' and `show`='$show'";
		
		$query=$conn->query($sql);		
		$result=$query->fetch_assoc();
		?>  
<tr>
	<td>
    <strong style="text-transform:uppercase; font-size:14px;">Application Summary(Exh<?php echo $result['gid'];?>)</strong><br />
    <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
    
    <strong>Option :</strong>&nbsp; <?php echo $result['options'];?> <br />
    <strong>Area :</strong>&nbsp; <?php echo $result['selected_area'];?> &nbsp;sqrt<br />
    <strong>Scheme :</strong>&nbsp; <?php  if($result['selected_scheme_type']=='RW'){echo 'Raw Space'; } else {echo 'Shell Scheme';}?> <br />
    <strong>Premium :</strong>&nbsp; <?php echo getPremiumName($result['selected_premium_type'],$conn);?><br /><br /><br />
 
    </td>
    <td>
    <strong style="text-transform:uppercase; font-size:14px;">Application Payment Summary</strong><br />
    <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
    <strong>Total Space Cost <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['tot_space_cost_rate'];?> <br />
    
    <strong>Selected premium rate <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['selected_premium_rate'];?> <br />
    <strong>Sub Total <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['sub_total_cost'];?> <br />
    <strong>Security Deposit (10% on Sub Total) <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['security_deposit'];?> <br />
    <strong>GST (18% on Sub Total) <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['govt_service_tax'];?><br />
    <strong>Grand Total <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['grand_total'];?><br/>    
    </td>
</tr>


<?php if($_SESSION['succ_msg']!=""){ ?>
<tr>
<td colspan="11"><?php echo $_SESSION['succ_msg']; ?></td>
</tr>
<?php }?>
</tr>
<tr><td>
	<table border="1" cellspacing="0" cellpadding="5" style="margin-bottom:10px;" width="100%">
			<thead>
				<th align="center">UTR No</th>
				<th align="center">Amount Paid</th>
				<th align="center">TDS Amount</th>
                <th align="center">Date</th>
                <th align="center" colspan="2">Approve / Disapprove</th>
			</thead>
			<tbody>
				<?php
				$utrExist = "SELECT * FROM `utr_history` WHERE registration_id='$registration_id' AND `show`='IGJME 2022' order by `utr_date` asc";
				$existResult = $conn->query($utrExist);
				$totalPrice = 0;
				while($printutr = $existResult->fetch_assoc())
				{
					$id = $printutr['id']; 
					$getUTR_no = $printutr['utr_number']; 
					$amountPaid = $printutr['amountPaid']; 
					$tdsAmount = $printutr['tdsAmount']; 
					$utr_approved = $printutr['utr_approved']; 
					$utr_date = $printutr['utr_date'];
				?>
				<tr>
                    <td align="center"><input type="hidden" name="utr_id[]" value="<?php echo $id;?>"><?php echo $getUTR_no;?></td>
                    <td align="center"><?php echo $amountPaid;?></td>
                    <td align="center"><?php echo $tdsAmount;?></td>
                    <td align="center"><input type="date" name="utr_date[]" value="<?php echo $utr_date;?>" /></td>
                    <td align="center"><input type="checkbox" name="utr_approved[]" value="<?php echo $id;?>" <?php if($utr_approved == "Y") echo 'checked="checked"';?>></td>
				</tr>
				<?php }	?>
			</tbody>
	</table>
		 </td>
</tr>
<tr class="orange1">
    <td colspan="11" >Payment Details</td>
</tr>

<tr >
  <td colspan="11"> 
		<input type="hidden" name="grand_total" id="grand_total" value="<?php echo round($result['grand_total']);?>"/>
		<div class="field_box">
        <div class="field_name">Amount Payable <span>*</span>:</div>
        <div class="field_input">
				<select class="textField" name="amount_payable" id="amount_payable">
				 <option value=""> Select Payable Amount  </option>
				 <?php if($result['last_yr_participant']=="NO" || $result['last_yr_participant']=="No"){?>				
				 <option value="50" <?php if($percentage==50){?> selected="selected"<?php }?>> 50% </option>
				 <?php } else {?>
				 <option value="50" <?php if($percentage==50){?> selected="selected"<?php }?>> 50% </option>
				 <option value="100" <?php if($percentage==100){?> selected="selected"<?php }?>>100%</option>
				 <?php }?>
				</select>
		<br><label class="error" id="payment_mode_error"></label>
		</div>
        <div class="clear"></div>
        </div> 
		
		<div class="field_box">
        <div class="field_name">Gross Amount <span>*</span>:</div>
        <div class="field_input">              
                <input name="net_payable_amount" id="net_payable_amount" type="text" class="textField" <?php if(!empty($net_payable_amount)){?>value="<?php echo $net_payable_amount;?>" <?php } ?>readonly/>
                <br><label class="error" id="cheque_tds_gross_amount_error"></label>            	
                <div class="clear"></div>
        </div>
        <div class="clear"></div>
        </div> 
		
		<!---- Start TDS ----->
			<div class="field_box">
				<div class="field_name">TDS Deducted : </div>
				<div class="field_input">
				YES <input type="radio" id="chkYes" value="Yes" name="tds_holder" <?php if($tds_holder=='Yes'){ echo 'checked="checked"'; } ?>/>
				NO <input type="radio" id="chkNo" value="No" name="tds_holder" <?php if($tds_holder=='No'){ echo 'checked="checked"'; } ?> /></label>
				<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>		
            <div class="field_box">
				<div class="field_name">TDS Percentage @2 % or 10% : </div>  
				<select class="textField" name="cheque_tds_per" id="cheque_tds_per">
				<option value="">--Select TDS percentage--</option>
			     <option value="2" <?php if($cheque_tds_per==2){?> selected="selected" <?php }?>>2 %</option>
				 <option value="10" <?php if($cheque_tds_per==10){?> selected="selected" <?php }?>>10 %</option>
				</select>				
                <br><label class="error" id="cheque_tds_per_error"></label>				
                <div class="clear"></div>
            </div>			
			<div class="field_box">
                <div class="field_name">TDS Amount :</div>                
				<input name="cheque_tds_amount" type="text" id="cheque_tds_amount" class="textField" value="<?php echo $cheque_tds_amount;?>" autocomplete="off"/>
                <br><label class="error" id="cheque_tds_amount_error"></label>
                <div class="clear"></div>
            </div>			
			<div class="field">
                <div class="field_name">Net Amount :</div>                
				<input name="cheque_tds_Netamount" type="text" id="cheque_tds_Netamount" class="textField" value="<?php echo $cheque_tds_Netamount;?>" autocomplete="off"/>
                <br><label class="error" id="cheque_tds_Netamount_error"></label>
                <div class="clear"></div>
            </div>		
		<!---- End TDS ----->
		
        <div class="field_box">
        <div class="field_name">Mode of Payment <span>*</span>:</div>
        <div class="field_input">
        <select class="bgcolor" name="payment_mode" id="payment_mode">
			<?php
			if($int_type=="N")
			{			
				$option='<option value="">--- Please Select Payment Mode ---</option>';
				$option.='<option value="RTGS"';
				if($payment_mode=="RTGS")
					$option.= 'selected';
				$option.='>RTGS</option>';				
				echo $option;			
			}
			else
			{
				$option='';
				$option.='<option value="Wire Transfer"';				
				if($payment_mode=="Wire Transfer")
					$option.= 'selected';
				$option.='>Wire Transfer</option>';
				echo $option;
			}
			?>
            
        </select><br><label class="error" id="payment_mode_error"></label></div>
        <div class="clear"></div>
        </div>  
    	<!-- RTGS description -->
        <div id="rtgs_desc" style="margin-bottom:10px;font-size:12px;">
        <p><strong>Please note the RTGS instructions for participation cost payment.</strong> </p>
		<strong>BENIFICIARY NAME:</strong>	THE GEM & JEWELLERY EXPORT PROMOTION COUNCIL.<br/>
		<strong>ACCOUNT NO.:</strong>			026894600001826<br/>
		<strong>BANK NAME:</strong>			Yes Bank Ltd<br/>
		<strong>BRANCH CODE:</strong>			Kalanagar, Bandra<br/>
		<strong>IFSC Code:</strong>	YESB0000268<br/>
All the applicants will have to send the print acknowledgement receipt along with the RTGS Details (With UTR / Reference no.) The same has to be compulsorily signed ONLY by the Director / Partner / Proprietor on all the pages (including the terms & conditions section) including company seal within 4 working days from the date of successful online submission.
        <span class="clear" style="height:1px; background:#ccc; display:block; margin-top:8px;"></span></div>
        <!-- RTGS description end -->
        <div class="clear" style="height:10px;"></div>
        <?php
		if($int_type=="N")
		{
		?>
        <!--<div id="chequeordd">
            <div class="field_box">
                <div class="field_name">Cheque / DD No. <span>*</span> :</div>
                <div class="field_input"><input name="cheque_dd_no" id="cheque_dd_no" type="text" class="bgcolor" value="<?php if($cheque_dd_no=="0")echo "";			else
																																	echo $cheque_dd_no; ?>" /><br><label class="error" id="cheque_dd_no_error"></label></div>
                <div class="clear"></div>
            </div>
             
            <div class="field_box">
                <div class="field_name">Cheque / DD Date. <span>*</span> :</div>
                <div class="field_input"><input name="cheque_dd_date" id="datepicker" type="text" class="bgcolor" value="<?php if($cheque_dd_date=="01-01-1970")
																																	echo "";
																																else
																																	echo $cheque_dd_date; ?>" /><br><label class="error" id="datepicker_error"></label></div>
                <div class="clear"></div>
            </div>
            
            <div class="field_box">
                <div class="field_name">Cheque / DD Drawn (Bank Name) <span>*</span> :</div>
                <div class="field_input"> 
                <select class="bgcolor" name="cheque_drawn_bank_name" id="cheque_drawn_bank_name" >
                <?php
                    $fetch_bank = "select * from bank_master where status = 1";
                    $e_fb = $conn->query($fetch_bank);
                    echo "<option value=''>--- Select Your Bank ---</option>";
                    while($bd = $e_fb->fetch_assoc())
					{
                        $bank_option ="";
						$bank_option.= "<option value='".$bd['bank_name']."'";
						
						if($cheque_drawn_bank_name == $bd['bank_name'])
							$bank_option.="selected";
						$bank_option.=">".$bd['bank_name']."</option>";
						
						echo $bank_option;
					}
                ?>
            	</select>
                <br><label class="error" id="cheque_drawn_bank_name_error"></label>
            	</div>
                <div class="clear"></div>
            </div>
                
            <div class="field_box">
                <div class="field_name">Cheque / DD Drawn (Branch Name) <span>*</span> :</div>
                <div class="field_input"><input name="cheque_drawn_branch_name" type="text" id="cheque_drawn_branch_name" class="bgcolor" value="<?php echo $cheque_drawn_branch_name; ?>" />
                <br><label class="error" id="cheque_drawn_branch_name_error"></label></div>
                <div class="clear"></div>
            </div>
    	</div>-->
            <div class="clear" style="height:10px;"></div>
        <?php } ?>
   		<?php 
		if($int_type=="I")
		{
		/* for International Login Remittance */
		?>
            <div style="margin-bottom:10px; font-size:14px;"><strong>USD REMITTANCES</strong><span class="clear" style="height:1px; background:#ccc; display:block; margin-top:8px;"></span></div>
            
            
    
            <div class="summary_box">
            <p><strong>Remit to :</strong> <br/>
            SWIFT Code No. ABNAUS33 <br/>
            THE ROYAL BANK OF SCOTLAND N.V <br/>
            335, Madison Avenue <br/>
            New York. N.Y. 10017.</p>
            </div>
            
            <div class="summary_box">
            <p><strong>For further credit to :</strong> <br/>
            Nostro Account No. 661-001007341<br/>
            Brady House, 14, Veer Nariman Road <br/>
            Fort, Mumbai - 400 023.<br/>
            India</p>
            </div>
        
            <div class="clear"></div>
                    
            <p>Beneficiary Name : <strong>The Gem & Jewellery Export Promotion Council Beneficiary</strong></p>
        
            <p>A/c Number : <strong>000007422504</strong></p>
            
            <div class="clear" style="height:20px;"></div>
            
            <div style="margin-bottom:10px; font-size:14px;"><strong>Remittance details for refund of security deposit for International applicant</strong></div>
        <?php } ?>
        
        <?php 
		if($int_type == "N" )
		{
		/* For National Login Remittance */
        ?>
            <div style="margin-bottom:10px; font-size:14px;"><strong>RTGS / Bank detials for Refund</strong><span class="clear" style="height:1px; background:#ccc;margin-top:8px;"></span></div>
            
        <?php 
		}
		?>
        
        <div class="field_box">
        <div class="field_name">Bank A/c No. <span>*</span> :</div>
        <div class="field_input"><input type="text" name="bank_acc_no" id="bank_acc_no" class="bgcolor" value="<?php if($int_type == "N")
																										echo $bank_acc_no;
																									else
																										echo $int_bank_acc_no; ?>"/><br><label class="error" id="bank_acc_no_error"></label></div>
        <div class="clear"></div>
        </div>
        
        <div class="field_box">
        <div class="field_name">Name of Bank <span>*</span> :</div>
        <div class="field_input"><input type="text" name="bank_name" id="bank_name" class="bgcolor" value="<?php if($int_type == "N")
																										echo $name_bank;
																									else
																										echo $int_name_bank; ?>" /><br><label class="error" id="bank_name_error"></label></div>
        <div class="clear"></div>
        </div>
        
        <div class="field_box">
        <div class="field_name">Name of Branch <span>*</span> :</div>
        <div class="field_input"><input type="text" name="branch_name" id="branch_name" class="bgcolor" value="<?php if($int_type == "N")
																										echo $name_bank_branch;
																									else
																										echo $int_name_bank_branch; ?>" /><br><label class="error" id="branch_name_error"></label></div>
        <div class="clear"></div>
        </div>
         <?php 
		if($int_type == "N" )
		{
		/* For National Login Remittance */
        ?>
        <div class="field_box">
        <div class="field_name">IFSC Code <span>*</span> :</div>
        <div class="field_input"><input type="text" name="ifsc_code" id="ifsc_code" class="bgcolor" value="<?php echo $ifsc_code; ?>" /><br><label class="error" id="ifsc_code_error"></label></div>
        <div class="clear"></div>
        </div>
        <?php 
		}
		?>
        
        <?php 
		if($int_type=="I")
		{
		?>
            <div class="field_box">
            <div class="field_name">Address of Bank <span>*</span> :</div>
            <div class="field_input"><input type="text" id="int_bank_address" name="int_bank_address" class="bgcolor" value="<?php echo $int_bank_address; ?>" /><br><label class="error" id="int_bank_address_error"></label></div>
            <div class="clear"></div>
            </div>
            
            <div class="field_box">
            <div class="field_name">Beneficiary Name <span>*</span> :</div>
            <div class="field_input"><input type="text" id="int_beneficiary_name" name="int_beneficiary_name" class="bgcolor" value="<?php echo $int_beneficiary_name; ?>" /><br><label class="error" id="int_beneficiary_name_error"></label></div>
            <div class="clear"></div>
            </div>
            
            <div class="field_box">
            <div class="field_name">Swift Code <span>*</span> :</div>
            <div class="field_input"><input type="text" id="int_swift_code" name="int_swift_code" class="bgcolor" value="<?php echo $int_swift_code; ?>" /><br><label class="error" id="int_swift_code_error"></label></div>
            <div class="clear"></div>
            </div>
            
            <div class="field_box">
            <div class="field_name">IBAN Number <span>*</span> :</div>
            <div class="field_input"><input type="text" id="int_iban_no" name="int_iban_no" class="bgcolor" value="<?php echo $int_iban_no; ?>" />
            <br><label class="error" id="int_iban_no_error"></label>
            </div>
            <div class="clear"></div>
            </div>
        <?php
		}
		?>
        
        <div class="field_box">
        <div class="field_name">Type of Account <span>*</span> :</div>
        <div class="field_input">
            <select class="bgcolor" name="int_acc_type" id="int_acc_type" >
            <option value="">--- Please Select Account Type ---</option>
            <option value="Saving" <?php if($int_acc_type=="Saving") echo "selected";?> >Saving</option>
            <option value="Current" <?php if($int_acc_type=="Current") echo "selected";?> >Current</option>
            </select>
            <br><label class="error" id="int_acc_type_error"></label>
        </div>
        <div class="clear"></div>
        </div>     

    	<div class="clear" style="height:20px;"></div>
    
        <div class="field_box">
        <div class="field_name"></div>
        <div class="field_input">
          
        <div class="clear"></div>
        </div>
        <input type="hidden" name="exh_id" id="exh_id" value="<?php echo $exh_id;?>"/>
        
        
        
        </td>
    </tr>
<tr>
<td>Payment Approval</td>
<td>
<input type="radio" value="approved" name="approval" <?php if(preg_match('/approved/',$payment_status)){echo 'checked="checked"'; } ?>>Approve
<input type="radio" value="rejected" name="approval" <?php if(preg_match('/rejected/',$payment_status)){echo 'checked="checked"'; } ?>>Disapprove
<input type="radio" value="pending" name="approval" <?php if(preg_match('/pending/',$payment_status)){echo 'checked="checked"'; } ?>>Pending
<textarea name="payment_dissapprove_reason" id="payment_dissapprove_reason"><?php echo $payment_dissapprove_reason ?></textarea>
Disapprove Reson
</td>

</tr>

<tr>
<td>Document Approval</td>
<td>
<input type="radio" value="approved" name="doc_approval" <?php if(preg_match('/approved/',$document_status)){echo 'checked="checked"'; } ?>>Approve
<input type="radio" value="rejected" name="doc_approval" <?php if(preg_match('/rejected/',$document_status)){echo 'checked="checked"'; } ?>>Disapprove
<input type="radio" value="pending" name="doc_approval" <?php if(preg_match('/pending/',$document_status)){echo 'checked="checked"'; } ?>>Pending
<textarea name="document_dissapprove_reason" id="document_dissapprove_reason"><?php echo $document_dissapprove_reason;?></textarea>
Disapprove Reson
</td>

</tr>


<?php /*?><tr >
  <td valign="top"><strong>Information Approval Status</strong></td>
  <td><input type="radio" name="personal_info_approval" id="personal_info_approval" value="Y" onchange="check_disable1()" <?php if($personal_info_approval=="Y"){?> checked="checked" <?php }?> />Approval
  <input type="radio" name="personal_info_approval" id="personal_info_approval" value="N" onchange="check_disable1()"  <?php if($personal_info_approval=="N"){?> checked="checked" <?php }?> />Disapprove
  <br />
  	<p id="personal_info_reason_text" <?php if($personal_info_approval=="Y"){?> style="display:none;" <?php }?>>
	<textarea name="personal_info_reason" cols="40" rows="6" id="personal_info_reason"  ><?php echo $personal_info_reason;?></textarea></p>
  </td>
</tr><?php */?>

</table>
</div>
<div style="padding-left:250px; margin-top:5px;">
<input type="hidden" name="country" id="country" value="<?php echo $country;?>" />
<input type="hidden" name="action" id="action" value="UPDATE" />
<input type="hidden" name="registration_id" id="registration_id" value="<?php echo $registration_id;?>" />    	
<input type="submit" value="Update" class="input_submit"/>
<!--<a href="obmp_info_IVR.php?id=<?php// echo $id;?>&registration_id=<?php// echo $registration_id;?>"><div class="button">Next</div></a>-->
</div>
</form>

<form name="utr" method="POST" action="" id="form-horizontal">
		<input type="hidden" name="saveUTR" value="saveinfo">
		<table border="1" cellspacing="0" cellpadding="5" style="margin-bottom:10px;" width="100%">
			<th>ADD UTR DETAIL</th>
		</table>
		<table border="1" cellspacing="0" cellpadding="5" style="margin-bottom:10px;" width="100%">
			<thead>
				<th align="center">Event Participated: </th>
				<th align="center">UTR Number :</th>
				<th align="center">Amount Paid :</th>
				<th align="center">TDS Amount(If Any) :</th>
			</thead>
			<tr>
				<td>
				<select name="event" id="event" class="select-control">
					<option value="">--Select Event--</option>
					<option value="igjme22">IGJME 2022</option>
				</select>
				<?php if(isset($eventError)) { echo  '<span style="color: red;"/>'.$eventError.'</span>';} ?>
				</td>
				<td>
				<input type="text" class="form-control" id="utr_number" name="utr_number" value=""/>
				<?php if(isset($utrNameError)) { echo  '<span style="color: red;"/>'.$utrNameError.'</span>';} ?>
				</td>
				<td>
				<input type="number" class="form-control" id="amountPaid" name="amountPaid" value="" onkeypress="return isNumberKey(event)"/>
				<?php if(isset($amountPaidError)) { echo  '<span style="color: red;"/>'.$amountPaidError.'</span>';} ?>
				</td>
				<td>
				<input type="number" class="form-control" id="tdsAmount" name="tdsAmount" value=""/>
				<?php if(isset($utrNameSuccess)){ echo '<span style="color: green;"/>'.$utrNameSuccess.'</span>';} ?>
				</td>
			</tr>
			<tr><td><input type="submit" class="cta" id="submit" value="SAVE"/></td></tr>
	    </table>
</form>

</div></div></div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>
