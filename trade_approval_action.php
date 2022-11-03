<?php
ob_start();
session_start(); 
include('db.inc.php');
include('functions.php');

$app_id 			= 	filter($_SESSION['APP_ID']);
$registration_id	=   filter($_SESSION['USERID']); 
$application_status	=	filter($_REQUEST['application_status']);
$application_date 	= 	filter($_REQUEST['application_date']);
$permission_no 		= 	filter($_REQUEST['permission_no']);
$gcode 				= 	filter($_REQUEST['membership_id']);
$membership_id 		= 	filter($_REQUEST['membership_id']);
$communication_id   =   filter($_REQUEST['communication_id']);
$email 				=   filter($_REQUEST['email']);
$commemail			=	filter($_REQUEST['commemail']);
$member_name 		= 	filter($_REQUEST['member_name']);
$customer_add 		= 	filter($_REQUEST['customer_add']);
$address1 			= 	filter($_REQUEST['address1']);
$address2 			= 	filter($_REQUEST['address2']);
$pincode 			= 	filter($_REQUEST['pincode']);
$city 				= 	filter($_REQUEST['city']);
$permission_type 	= 	filter($_REQUEST['permission_type']);
$visiting_country	=	$_REQUEST['visiting_country'];
$visiting_city		=	$_REQUEST['visiting_city'];

$region_code  = getRegion($registration_id,$conn);
$region_email = getRegionEmail($region_code,$conn);

for($i=0;$i<=count($visiting_country);$i++)
{	
	${visiting_country.$i}=$visiting_country[$i];
}

for($i=0;$i<=count($visiting_city);$i++)
{	
	${visiting_city.$i}=$visiting_city[$i];
}

if($visiting_country0=="")
	$country1="";
else
	$country1=$visiting_country0;

if($visiting_country1=="")
	$country2="";
else
	$country2=$visiting_country1;
	
if($visiting_country2=="")
	$country3="";
else
	$country3=$visiting_country2;

if($visiting_country3=="")
	$country4="";
else
	$country4=$visiting_country3;

if($visiting_country4=="")
	$country5="";
else
	$country5=$visiting_country4;

if($visiting_country5=="")
	$country6="";
else
	$country6=$visiting_country5;
	
if($visiting_city=="")
	$city1="";
else
	$city1=$visiting_city0;

if($visiting_city1=="")
	$city2="";
else
	$city2=$visiting_city1;

if($visiting_city2=="")
	$city3="";
else
	$city3=$visiting_city2;

if($visiting_city3=="")
	$city4="";
else
	$city4=$visiting_city3;

if($visiting_city4=="")
	$city5="";
else
	$city5=$visiting_city4;

if($visiting_city5=="")
	$city6="";
else
	$city6=$visiting_city5;	
	
$item1 = $_REQUEST['item1'];
$invoice_value1 = $_REQUEST['invoice_value1'];
$item2 = $_REQUEST['item2'];
$invoice_value2 = $_REQUEST['invoice_value2'];
$item3 = $_REQUEST['item3'];
$invoice_value3 = $_REQUEST['invoice_value3'];
$item4 = $_REQUEST['item4'];
$invoice_value4 = $_REQUEST['invoice_value4'];
$item5 = $_REQUEST['item5'];
$invoice_value5 = $_REQUEST['invoice_value5'];
$app_invoice_value = $_REQUEST['apprx_invoice_value'];

$bank_name = filter($_REQUEST['bank_name']);

if($bank_name=='other')
	$other_bank_name = filter($_REQUEST['other_bank_name']);
else
	$other_bank_name ='';
	
$branch_name =  filter($_REQUEST['bank_branch']);
$person_name_carrying = filter($_REQUEST['person_name_carrying']);
$passport_no = filter($_REQUEST['passport_no']);
$passport_issue_date = $_REQUEST['passport_issue_date'];
$passport_expiry_date = $_REQUEST['passport_expiry_date']; 
$date_of_departure = $_REQUEST['date_of_daparture'];
$reg_brand_name_of_j = $_REQUEST['reg_brand_name_of_j'];
$reg_brand_name_of_a = $_REQUEST['reg_brand_name_of_a'];
$address_of_place_of_dis = $_REQUEST['address_of_place_of_dis'];

$region_code = $_REQUEST['region_code'];

$from_date = $_REQUEST['from_date'];
$to_date = $_REQUEST['to_date'];
$date_of_data_entry = $_REQUEST['date_of_data_entry'];

$actual_invoice_amt = $_REQUEST['actual_invoice_amt'];

$merchant_reg_no = $_REQUEST['merchant_reg_no'];
$manufacture_reg_no = $_REQUEST['manufacture_reg_no'];
$member_id = $_REQUEST['member_id'];
$old_ref_no = $_REQUEST['old_reference_no'];
$new_ref_no = $_REQUEST['new_reference_no'];
$permission_status = $_REQUEST['permission_status'];
$created_date = date('d-m-Y');
$modified_date = date('d-m-Y');

$q_ref = $conn ->query("select * from trade_general_info where region_code='$region_code' ORDER BY app_id desc limit 1");
$r_ref = $q_ref->fetch_assoc();
$start=$r_ref['end']+1;
$end=$start+2;
$app_id=$_REQUEST['app_id'];

$gInfo =  $conn ->query("select * from trade_general_info where app_id='$app_id'");
$num = $gInfo->num_rows;
if($num==0){
$sql = "insert into trade_general_info 
set registration_id='$registration_id',permission_no='$permission_no',membership_id='$membership_id',communication_id='$communication_id',type_of_address='$customer_add',email='$email',commemail='$commemail',member_name='$member_name',address1='$address1',address2='$address2',pincode='$pincode',city='$city',permission_type='$permission_type',visiting_country1='$country1',city1='$city1',visiting_country2='$country2',city2='$city2',visiting_country3='$country3',city3='$city3',visiting_country4='$country4',city4='$city4',visiting_country5='$country5',city5='$city5',visiting_country6='$country6',city6='$city6',item1='$item1',invoice_value1='$invoice_value1',item2='$item2',invoice_value2='$invoice_value2',item3='$item3',invoice_value3='$invoice_value3',item4='$item4',invoice_value4='$invoice_value4',item5='$item5',invoice_value5='$invoice_value5',apprx_invoice_value='$app_invoice_value',bank_name='$bank_name',other_bank_name='$other_bank_name',branch_name='$branch_name',person_name_carrying='$person_name_carrying',passport_no='$passport_no',passport_issue_date='$passport_issue_date',passport_expiry_date='$passport_expiry_date',date_of_departure='$date_of_departure',region_code='$region_code',start='$start',end='$end',from_date='$from_date',to_date='$to_date',date_of_data_entry='$date_of_data_entry',application_date='$application_date',merchant_reg_no='$merchant_reg_no',manufacturer_reg_no='$manufacture_reg_no',member_id='$member_id',old_ref_no='$old_ref_no',new_ref_no='$new_ref_no',created_date='$created_date',app_report_status='P'";
$query = $conn ->query($sql);   
$app_id= $conn -> insert_id;
$_SESSION['APP_ID']=$app_id;
}
else if($application_status=="N")
{
$sql = "update trade_general_info 
set registration_id='$registration_id',permission_no='$permission_no',membership_id='$membership_id',commemail='$commemail',type_of_address='$customer_add',email='$email',communication_id='$communication_id',member_name='$member_name',address1='$address1',address2='$address2',pincode='$pincode',city='$city',permission_type='$permission_type',visiting_country1='$country1',city1='$city1',visiting_country2='$country2',city2='$city2',visiting_country3='$country3',city3='$city3',visiting_country4='$country4',city4='$city4',visiting_country5='$country5',city5='$city5',visiting_country6='$country6',city6='$city6',item1='$item1',invoice_value1='$invoice_value1',item2='$item2',invoice_value2='$invoice_value2',item3='$item3',invoice_value3='$invoice_value3',item4='$item4',invoice_value4='$invoice_value4',item5='$item5',invoice_value5='$invoice_value5',apprx_invoice_value='$app_invoice_value',bank_name='$bank_name',other_bank_name='$other_bank_name',branch_name='$branch_name',person_name_carrying='$person_name_carrying',passport_no='$passport_no',passport_issue_date='$passport_issue_date',passport_expiry_date='$passport_expiry_date',date_of_departure='$date_of_departure',region_code='$region_code',from_date='$from_date',to_date='$to_date',date_of_data_entry='$date_of_data_entry',application_date='$application_date',merchant_reg_no='$merchant_reg_no',manufacturer_reg_no='$manufacture_reg_no',member_id='$member_id',old_ref_no='$old_ref_no',new_ref_no='$new_ref_no',modified_date='$modified_date',app_report_status='P' where app_id='$app_id'"; 
$query = $conn ->query($sql);  

if($permission_type=="exhibition") { 
	
$sqlx = $conn ->query("select exhibition_id from trade_exhibition_info where `app_id` = '$app_id'");
$rowx = $sqlx->fetch_assoc();
$exhibition_id = $rowx['exhibition_id'];

$sql = $conn ->query("select * from trade_exhibition_master where `Exhibition_Id`= '$exhibition_id'");
$row = $sqlx->fetch_assoc();
$exhibition_id=$row['exhibition_id'];
$from_date=$row['From_Date'];
$To_Date=$row['To_Date'];
$exh_name=$row['Exhibition_Name'];
//$country=$row['Country'];
$permission_type=getPermissionType($app_id,$conn); 
$exhibition_type=getExhibitionType($app_id,$conn);
$member_name=getMemberName($app_id,$conn);
$email=getMemberEmail($app_id,$conn);

$message ='<table width="96%" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
		<tr>
		<td style="padding:30px;">
		<table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">		
		<tr>
		<td align="left"><img src="https://gjepc.org/images/gjepc_logon.png" width="238" height="78" /></td>
		</tr>
		<tr><td></td><td align="right"></td></tr>
		<tr><td align="right" colspan="2" height="30px"><hr /></td></tr>
		<tr>
		<td colspan="2" style="font-size:13px; line-height:22px;">
		<p><strong>Kindly find revised application details of '.$exh_name.' (From Date:'.$from_date.' To Date:'.$To_Date.')</strong></p>
            <p><strong>Applicant Detail</strong> </p>
            <p>Company Name: <strong>'.$member_name.'</strong> </p>
			<p>Email: <strong>'.$email.'</strong> </p>
			<p>Permission Type: <strong>'.$permission_type.'</strong> </p>
		</td>		
		</tr>
		</table>
		</td>		
		</tr>
</table>'; 
	$to =$region_email;
	 $subject = "Trade Application";
	 $headers  = 'MIME-Version: 1.0' . "\n"; 
	 $headers .= 'Content-type: text/html; charset=iso-8859-1'. "\n"; 
	 $headers .= 'From: GJEPC INDIA <admin@gjepc.org>';	
	 $cc = "";		
	 send_mail($to, $subject, $message, $cc);
	
} elseif($permission_type=="promotional_tour") { 

$sqlx = $conn ->query("select * from  trade_general_info where `app_id` =  '$app_id'");
$rowx = $sqlx->fetch_assoc();
$country=$rowx['visiting_country1'];
$from_date=$rowx['from_date'];
$to_date=$rowx['to_date'];

$permission_type=	getPermissionType($app_id,$conn); 
$exhibition_type=	getExhibitionType($app_id,$conn);
$member_name	=	getMemberName($app_id,$conn);
$email			=	getMemberEmail($app_id,$conn);

$message ='<table width="96%" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
		<tr>
		<td style="padding:30px;">
		<table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">		
		<tr>
		<td align="left"><img src="https://gjepc.org/images/gjepc_logon.png" width="238" height="78" /></td>
		</tr>
		<tr><td></td><td align="right"></td></tr>
		<tr><td align="right" colspan="2" height="30px"><hr /></td></tr>
		<tr>
		<td colspan="2" style="font-size:13px; line-height:22px;">
		<p><strong>Kindly find revised application details of Export Promotional Tour to '.$country.' (From Date:'.$from_date.' To Date:'.$to_date.'). </strong></p>
            <p><strong>Applicant Detail</strong> </p>
            <p>Company Name: <strong>'.$member_name.'</strong> </p>
			<p>Email: <strong>'.$email.'</strong> </p>
			<p>Permission Type: <strong>'.$permission_type.'</strong> </p>
		</td>
		
		</tr>
		</table>
		</td>		
		</tr>
</table>'; 

	 $to = $region_email;
	 $subject = "Trade Application";
	 $headers  = 'MIME-Version: 1.0' . "\n"; 
	 $headers .= 'Content-type: text/html; charset=iso-8859-1'. "\n"; 
	 $headers .= 'From: GJEPC INDIA <admin@gjepc.org>';			
	// mail($to, $subject, $message, $headers);
	 $cc = "";
	 send_mail($to, $subject, $message, $cc);
}

}
	
if($permission_type=="promotional_tour")
{
	header('location:trade_approval_documents.php');
}
else
{
	header('location:trade_exhibition.php');
}
exit;
?>