<?php session_start(); 
ob_start();?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>

<?php 
$gid=intval($_REQUEST['gid']);
$registration_id=intval($_REQUEST['registration_id']);
$modified_date = date("Y-m-d");

$show = "IIJS Signature 2019";
$sql1="select * from exh_reg_general_info where uid='$registration_id' and event_for='$show' and id='$gid'";

$result1=mysql_query($sql1);

$rows1=mysql_fetch_array($result1);
$country=$rows1['country'];

if($country=='INDIA' || $country=='IND' || $country=='IN')
{
	$currency='INR';
	$int_type = "N";
}
else
{
	$currency='USD';
	$int_type = "I";
}
?>
<?php
$sqlm="select * from  exh_registration where uid='$registration_id' and gid='$gid' and `show`='$show'";
$querym=mysql_query($sqlm);		
$resultm=mysql_fetch_array($querym);
$grandTotals = $resultm["grand_total"];
?>
<?php
$sql="select * from exh_reg_payment_details where gid='$gid' and uid='$registration_id' AND `show` = '$show'";
$result=mysql_query($sql);
$rows=mysql_fetch_array($result);
$payment_id = $rows["payment_id"];
$payment_mode = $rows["payment_mode"];

$percentage = $rows["percentage"];
$net_payable_amount = $rows["net_payable_amount"];

$cheque_dd_no = stripslashes($rows["cheque_dd_no"]);
$cheque_dd_date = date("d-m-Y",strtotime($rows["cheque_dd_date"]));
$cheque_drawn_bank_name = stripslashes($rows["cheque_drawn_bank_name"]);
$cheque_drawn_branch_name = stripslashes($rows["cheque_drawn_branch_name"]);

$bank_acc_no = stripslashes($rows["bank_acc_no"]);
$name_bank = stripslashes($rows["name_bank"]);
$name_bank_branch = stripslashes($rows["name_bank_branch"]);
$ifsc_code = stripslashes($rows["ifsc_code"]);

$int_acc_type = stripslashes($rows["int_acc_type"]);
$int_bank_acc_no = stripslashes($rows["int_bank_acc_no"]);
$int_name_bank = stripslashes($rows["int_name_bank"]);
$int_name_bank_branch = stripslashes($rows["int_name_bank_branch"]);
$int_bank_address = stripslashes($rows["int_bank_address"]);
$int_beneficiary_name = stripslashes($rows["int_beneficiary_name"]);
$int_swift_code = stripslashes($rows["int_swift_code"]);
$int_iban_no = stripslashes($rows["int_iban_no"]);
$payment_status=$rows["payment_status"];
$document_status=$rows["document_status"];
$payment_dissapprove_reason=$rows["payment_dissapprove_reason"];
$document_dissapprove_reason=$rows["document_dissapprove_reason"];
?>

<?php
if(isset($_REQUEST["action"]))
{
	$action = mysql_real_escape_string($_REQUEST["action"]);
	$payment_mode = mysql_real_escape_string($_REQUEST["payment_mode"]);
	/* 50% or 100% */
	$amount_payable = mysql_real_escape_string($_POST["amount_payable"]);
	$net_payable_amount = mysql_real_escape_string($_POST["net_payable_amount"]);
		
	$approval = $_REQUEST["approval"];
	$doc_approval = $_REQUEST["doc_approval"];
	if($approval=="rejected")
	{
		$payment_dissapprove_reason=mysql_real_escape_string($_REQUEST['payment_dissapprove_reason']);
	}
	else
	{
		$payment_dissapprove_reason="";
	}
	
	if($doc_approval=="rejected")
	{
		$document_dissapprove_reason=mysql_real_escape_string($_REQUEST['document_dissapprove_reason']);
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
					$cheque_dd_no = mysql_real_escape_string($_POST["cheque_dd_no"]);
					$cheque_dd_date = date("Y-m-d", strtotime($_POST["cheque_dd_date"]));
					$cheque_drawn_bank_name = mysql_real_escape_string($_POST["cheque_drawn_bank_name"]);
					$cheque_drawn_branch_name = mysql_real_escape_string($_POST["cheque_drawn_branch_name"]);
				}
				
				$bank_acc_no = mysql_real_escape_string($_POST["bank_acc_no"]);
				$name_bank = mysql_real_escape_string($_POST["bank_name"]);
				$name_bank_branch = mysql_real_escape_string($_POST["branch_name"]);
				$ifsc_code = mysql_real_escape_string($_POST["ifsc_code"]);
				$int_acc_type = mysql_real_escape_string($_POST["int_acc_type"]);
				
				$netTotal = $grandTotals * $amount_payable/100;
				//echo '---'.$net_payable_amount .'=='. $netTotal; exit;
				if($net_payable_amount == $netTotal)
				{
				$update_query = "update exh_reg_payment_details set payment_mode='$payment_mode', cheque_dd_no='$cheque_dd_no', cheque_dd_date='$cheque_dd_date', cheque_drawn_bank_name='$cheque_drawn_bank_name', cheque_drawn_branch_name='$cheque_drawn_branch_name', bank_acc_no='$bank_acc_no', name_bank='$name_bank', name_bank_branch='$name_bank_branch', ifsc_code='$ifsc_code', int_acc_type='$int_acc_type', modified_date='$modified_date', payment_status='$approval', document_status='$doc_approval',payment_dissapprove_reason='$payment_dissapprove_reason',document_dissapprove_reason='$document_dissapprove_reason',`net_payable_amount`='$net_payable_amount',`percentage`='$amount_payable' where payment_id='$payment_id' and gid='$gid' and uid='$registration_id' and `show`='$show'";
				}else { echo 'wrong amount';}
							
		}
		else
		{
				$int_acc_type = mysql_real_escape_string($_POST["int_acc_type"]);
				$int_bank_acc_no = mysql_real_escape_string($_POST["bank_acc_no"]);
				$int_name_bank = mysql_real_escape_string($_POST["bank_name"]);
				$int_name_bank_branch = mysql_real_escape_string($_POST["branch_name"]);	
				$int_bank_address = mysql_real_escape_string($_POST["int_bank_address"]);
				$int_beneficiary_name = mysql_real_escape_string($_POST["int_beneficiary_name"]);
				$int_swift_code = mysql_real_escape_string($_POST["int_swift_code"]);
				$int_iban_no = mysql_real_escape_string($_POST["int_iban_no"]);				
				
				$update_query = "update exh_reg_payment_details set int_acc_type='$int_acc_type', int_bank_acc_no='$int_bank_acc_no', int_name_bank='$int_name_bank', int_name_bank_branch='$int_name_bank_branch', int_bank_address='$int_bank_address', int_beneficiary_name='$int_beneficiary_name', int_swift_code='$int_swift_code', int_iban_no='$int_iban_no', modified_date='$modified_date', payment_status='$approval', document_status='$doc_approval',payment_dissapprove_reason='$payment_dissapprove_reason',document_dissapprove_reason='$document_dissapprove_reason' where payment_id='$payment_id' and gid='$gid' and uid='$registration_id' and `show`='$show'";
				//exit;				
		}
		
		$result_update=mysql_query($update_query);
		
		if(!$result_update)
			$_SESSION['succ_msg']="Problems while updating Record";
		else
		{
			$app_query = "select payment_status,document_status from exh_reg_payment_details where payment_id='$payment_id' and gid='$gid' and uid='$registration_id' and `show`='$show'";
			$result_app = mysql_query($app_query);
			if($result_app)
			{
				$app_array = mysql_fetch_assoc($result_app);
				$ps = $app_array["payment_status"];
				$ds = $app_array["document_status"];
				
				if($ps=="pending" || $ds=="pending")
					$app_status = "pending";
				elseif($ps=="rejected" || $ds=="rejected")
					$app_status = "rejected";
				else
					$app_status = "approved";
					
				$update_app_query = "update exh_reg_payment_details set application_status='$app_status' where payment_id='$payment_id' and gid='$gid' and uid='$registration_id' and `show`='$show'";
				
				$update_app = mysql_query($update_app_query);
				
$message ='<table width="100%" bgcolor="#fbfbfb" style="margin:20px auto; border:2px solid #dddddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
<tr>
<td style="padding:30px;">
<table width="100%" border="0" background="#fbfbfb" cellpadding="0" cellspacing="0">
    
	<tr>
    	<td align="left" valign="top"><a href="https://www.iijs-signature.org"><img src="https://iijs-signature.org/images/logo.png" width="174" height="105" /></a></td>
    	<td align="right"><a href="https://www.gjepc.org"><img src="https://iijs.org/images/gjepc_logo.png" width="174" height="105"/></a></td>
    </tr>	
    <tr>
    	<td colspan="2" height="25px">&nbsp;</td>
    </tr>
    
    <tr>
    	<td colspan="2" height="1px" bgcolor="#333333"></td>
    </tr>
    
    <tr>
    	<td colspan="2" height="25px">&nbsp;</td>
    </tr>
    
    <tr>
    	<td colspan="2" valign="top" style="font-size:13px;">
    	<p><strong>Dear '.getUserName($registration_id).',</strong> </p>
    	</td>
    </tr>
    
    <tr>
    <td colspan="2">

<table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" style="border-collapse:collapse; float:right;">
  <tr valign="top">
    <td colspan="2" style="color:#14b3da;"><strong>Application Approval Summary</strong><br /></td>
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

<p><strong>IIJS-Signature Web Team,</strong></p>

<p>Important Links : <br />
<a href="#" style="text-decoration:none; color:#14b3da;">Registration Status</a> | <a href="#" style="text-decoration:none; color:#14b3da;">Travel & Hotel</a> | <a href="#" style="text-decoration:none; color:#14b3da;">Show Updates</a> | <a href="#" style="text-decoration:none; color:#14b3da;">Helpdesk</a> | <a href="#" style="text-decoration:none; color:#14b3da;">FAQs</a> | <a href="#" style="text-decoration:none; color:#14b3da;">OBMP</a>

</p>
</td>
</tr>
</table>

</td>
</tr>

</table>';
	
	//$to=getUserEmail($registration_id).',notification@gjepcindia.com';	
	$subject = "IIJS-Signature Exhibitor Registration Approval Status/dated".date('Y-m-d').")";
	$headers  = 'MIME-Version: 1.0' . "\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";	
	$headers .='From: IIJS-Signature <admin@gjepc.org>';	
	mail($to, $subject, $message, $headers);
				if($update_app)
				{
					header("Location:signature_exhibitor_rgistration.php");
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
<title>IIJS-Signature &gt; Exhibitor Registration &gt; Step-4</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/formAdmin.css"/>
<!--navigation-->
<script type="text/javascript" src="js/jqueryNew.js"></script>      
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<link rel="stylesheet" href="css/jquery-ui.css" />
  <!--<script src="js/jquery-1.9.1.js"></script>
  <script src="js/jquery-ui.js"></script>-->
<!--<script type="text/javascript">
$(function() {
    $( "#datepicker" ).datepicker({ dateFormat: "dd-mm-yy"});
	
});
function showDate(date) {
	alert('The date chosen is ' + date);}
</script>-->

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
    
    <div class="content_head">IIJS-Signature > Exhibitor Registration
      <div style="float:right; padding-right:10px; font-size:12px;"><a href="signature_exhibitor_rgistration.php">Back to Search</a></div>
    </div>
    	
<div class="clear"></div>
<div class="content_details1">
<form name="form1" action="signature_exh_registration_step4.php?gid=<?php echo $gid; ?>&registration_id=<?php echo $registration_id; ?>&action=update" method="post" onsubmit="return validation()"> 
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
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11" >Payment Details</td>
</tr>
		<?php 
		$sql="select * from  exh_registration where uid='$registration_id' and gid='$gid' and `show`='$show'";		
		$query=mysql_query($sql);		
		$result=mysql_fetch_array($query);
		?>  
<tr>
	<td>
    <strong style="text-transform:uppercase; font-size:14px;">Application Summary(Exh<?php echo $result['gid'];?>)</strong><br />
    <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
    <strong>Last Year Participant :</strong>&nbsp; <?php echo $result['last_yr_participant'];?> <br />
    <strong>Option :</strong>&nbsp; <?php echo $result['options'];?> <br />
    <strong>Section :</strong>&nbsp; <?php echo $result['section'];?> <br />
    <strong>Area :</strong>&nbsp; <?php echo $result['selected_area'];?> &nbsp;sqrt<br />
    <strong>Scheme :</strong>&nbsp; Shell Scheme <br />
    <strong>Category : <?php echo $result['category'];?> <br />
    <strong>Premium :</strong>&nbsp; <?php echo $result['selected_premium_type'];?><br />
 
    </td>
    <td>
    <strong style="text-transform:uppercase; font-size:14px;">Application Payment Summary</strong><br />
    <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
    <strong>Total Space Cost <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['tot_space_cost_rate'];?> <br />
    <strong>Selected Category rate <?php echo $currency;?> :</strong>&nbsp; <?php echo round($result['selected_scheme_rate']);?> <br />
    <strong>Selected premium rate <?php echo $currency;?> :</strong>&nbsp; <?php echo round($result['selected_premium_rate']);?> <br />
    <strong>Sub Total <?php echo $currency;?> :</strong>&nbsp; <?php echo round($result['sub_total_cost']);?> <br />
    <strong>Security Deposit (10% on Sub Total) <?php echo $currency;?> :</strong>&nbsp; <?php echo round($result['security_deposit']);?> <br />
    <strong>GST (18% on Sub Total) <?php echo $currency;?> :</strong>&nbsp; <?php echo round($result['govt_service_tax']);?><br />
    <strong>Grand Total <?php echo $currency;?> :</strong>&nbsp; <?php echo round($result['grand_total']);?><br/>
    </td>
</tr>


<?php if($_SESSION['succ_msg']!=""){ ?>
<tr>
<td colspan="11"><?php echo $_SESSION['succ_msg']; ?></td>
</tr>
<?php }?>
</tr>
<tr class="orange1">
    <td colspan="11" >Payment Details</td>
</tr>

<tr>
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
        </select>
		<br><label class="error" id="payment_mode_error"></label></div>
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
                <div class="field_input"><input name="cheque_dd_no" id="cheque_dd_no" type="text" class="bgcolor" value="<?php if($cheque_dd_no=="0")	echo "";
				else echo $cheque_dd_no; ?>" /><br><label class="error" id="cheque_dd_no_error"></label></div>
                <div class="clear"></div>
            </div>
             
            <div class="field_box">
                <div class="field_name">Cheque / DD Date. <span>*</span> :</div>
                <div class="field_input"><input name="cheque_dd_date" id="datepicker" type="text" class="bgcolor" value="<?php if($cheque_dd_date=="01-01-1970")
				echo ""; else echo $cheque_dd_date; ?>" /><br><label class="error" id="datepicker_error"></label></div>
                <div class="clear"></div>
            </div>
            
            <div class="field_box">
                <div class="field_name">Cheque / DD Drawn (Bank Name) <span>*</span> :</div>
                <div class="field_input"> 
                <select class="bgcolor" name="cheque_drawn_bank_name" id="cheque_drawn_bank_name" >
                <?php
                    $fetch_bank = "select * from bank_master where status = 1";
                    $e_fb = mysql_query($fetch_bank);
                    echo "<option value=''>--- Select Your Bank ---</option>";
                    while($bd = mysql_fetch_array($e_fb))
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


</div></div></div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>
