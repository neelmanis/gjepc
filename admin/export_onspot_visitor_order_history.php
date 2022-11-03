<?php 
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
include('../db.inc.php');
?>

<?php 
function getStateName($id)
{
	$query_sel = "SELECT state_name FROM  state_master  where state_code='$id'";
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['state_name'];		
	}
}

function getVisitorDesignationID($id)
{
	$query_sel = "SELECT type_of_designation FROM visitor_designation_master where id='$id'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['type_of_designation'];
	}
}

function getBPNO($registration_id)
{
	$query_sel = "SELECT c_bp_number FROM communication_address_master where registration_id='$registration_id' and type_of_address='2'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['c_bp_number'];
	}
}

function CheckMembership($registration_id)
{
	$sql="SELECT * FROM `approval_master` WHERE 1 and `registration_id`='$registration_id' and issue_membership_certificate_expire_status='Y'";
	$result=mysql_query($sql);
	$num_rows=mysql_num_rows($result);
	if($num_rows>0)
	{
		return 'M';
	} else {
		return 'NM';
	}
}

function getCompanyNonMemBPNO($registration_id)
{
	$sql="SELECT NM_bp_number FROM registration_master where id='$registration_id'";
	$result=mysql_query($sql);
	if($row = mysql_fetch_array($result))		 	
	{ 		
		return $row['NM_bp_number'];
	}
}
?>

<?php
$table = $display = "";	
$fn = "onspot_report";

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>ID</td>
<td>Company BP</td>
<td>Company Name</td>
<td>Company PAN</td>
<td>Company GST</td>
<td>Order ID</td>
<td>SO No</td>
<td>Payment Date</td>
<td>Badge ID</td>
<td>Person BP</td>
<td>Payment Status</td>
<td>First Name</td>
<td>Last Name</td>
<td>Designation</td>
<td>address1</td>
<td>address2</td>
<td>State</td>
<td>City</td>
<td>Pincode</td>
<td>Company Tel</td>
<td>Company Mobile</td>
<td>Company Email</td>
<td>Person Mobile</td>
<td>Person PAN</td>
<td>Person Email</td>
<td>Gender</td>
<td>Image</td>
<td>SHOW</td>
<td>Amount</td>
<td>Payment Mode</td>
</tr>';

//$sql="select oh.create_date as 'create_date', rm.id,rm.company_name,rm.company_pan_no,rm.company_gstn,rm.land_line_no,rm.mobile_no,rm.email_id, oh.orderId, vd.badge_id,vd.bp_number,vd.name,vd.lname,vd.designation,vd.pan_no,vd.gender,vd.mobile,vd.email,vd.photo, oh.payment_made_for, oh.amount as 'Amount', oh.payment_status as 'payment_status' from visitor_order_history oh inner join registration_master rm on oh.registration_id=rm.id inner join visitor_directory vd on oh.visitor_id=vd.visitor_id where oh.payment_status='Y' and oh.status = '1'";
$sql = "select oh.create_date as 'create_date', rm.id,rm.company_name,rm.company_pan_no,rm.company_gstn,rm.land_line_no,rm.mobile_no,rm.email_id, oh.orderId, vd.badge_id,vd.bp_number,vd.name,vd.lname,vd.designation,vd.pan_no,vd.gender,vd.mobile,vd.email,vd.photo, oh.payment_made_for, oh.amount as 'Amount', oh.payment_status as 'payment_status',vo.payment_type,vo.payment_mode
	from visitor_order_history oh 
	inner join registration_master rm on oh.registration_id=rm.id 
	inner join visitor_directory vd on oh.visitor_id=vd.visitor_id 
	inner join visitor_order_detail vo on vo.regId=vd.registration_id
	where vo.payment_type='offline' AND vo.orderId=oh.orderId AND oh.payment_status='Y' and oh.status = '1'";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result))
{
$registration_id=$row['id'];
$company_name=$row['company_name'];
$company_pan_no=$row['company_pan_no'];
$company_gstn=$row['company_gstn'];
$orderid=$row['orderId'];
$payment_date = date("d-m-Y", strtotime($row['create_date']));
$badge_id=$row['badge_id'];
$bp_number=$row['bp_number'];
$payment_status=$row['payment_status'];
$name=$row['name'];
$lname=$row['lname'];
$designation=getVisitorDesignationID($row['designation']);
$land_line_no=$row['land_line_no'];
$c_mobile_no=$row['mobile_no'];
$c_email_id=$row['email_id'];
$p_mobile=$row['mobile'];
$p_email=$row['email'];
$pan_no=$row['pan_no'];
$gender=$row['gender'];
$photo="https://registration.gjepc.org/images/employee_directory/".$registration_id."/photo/".$row['photo'];
$payment_made_for=$row['payment_made_for'];
$payment_amount=$row['Amount'];
$payment_mode=$row['payment_mode'];

$checkMember = CheckMembership($registration_id);
if($checkMember=="M")
{
 $memberBP = getBPNO($registration_id);
} else {
  $memberBP = getCompanyNonMemBPNO($registration_id);
}
  
		$getAddress ="SELECT * FROM `registration_master` WHERE `id` = '$registration_id'";
		$getAddressResult = mysql_query($getAddress);
		$getAddressRow = mysql_fetch_array($getAddressResult);
		$address_line1=strtoupper($getAddressRow['address_line1']);
		$address_line2=strtoupper($getAddressRow['address_line2']);
		$city=strtoupper($getAddressRow['city']);
		$country=strtoupper($getAddressRow['country']);
		$state=strtoupper(getStateName($getAddressRow['state']));
		$pincode=$getAddressRow['pin_code'];
		
		$getapplication ="SELECT * FROM `visitor_order_detail` WHERE `regId` = '$registration_id' AND orderId='$orderid' AND payment_status='Y'";
		$getApplicationResult = mysql_query($getapplication);
		$getApplicationRow=mysql_fetch_array($getApplicationResult);
		$type_of_member = $getApplicationRow['type_of_member'];
		$delivery_id = $getApplicationRow['delivery_id'];
		$sales_order_no = $getApplicationRow['sales_order_no'];

		/*if($type_of_member == "M"){
		$addflag = "SELECT * FROM `communication_address_master` WHERE `address_identity`='CTC' and `registration_id`='$registration_id' AND id='$delivery_id'";
		$deliveryQuery = mysql_query($addflag);
		$deliveryResult = mysql_fetch_array($deliveryQuery);
		$d_address1=strtoupper($deliveryResult['address1']);
		$d_address2=strtoupper($deliveryResult['address2']);
		$d_city=strtoupper($deliveryResult['city']);
		$d_country=strtoupper($deliveryResult['country']);
		$d_state=strtoupper(getStateName($deliveryResult['state']));
		$d_pincode=$deliveryResult['pincode'];
		} else {
		$addflag = "SELECT * FROM `n_m_billing_address` WHERE `registration_id`='$registration_id' AND id='$delivery_id'";
		$deliveryQuery = mysql_query($addflag);
		$deliveryResult = mysql_fetch_array($deliveryQuery);
		$d_address1=strtoupper($deliveryResult['address1']); if($d_address1==""){ $d_address1=$address_line1; } else { $d_address1; } 
		$d_address2=strtoupper($deliveryResult['address2']); if($d_address2==""){ $d_address2=$address_line2; } else { $d_address2; } 
		$d_city=strtoupper($deliveryResult['city']);		 if($d_city==""){ $d_city=$city; } else { $d_city; } 
		$d_country=strtoupper($deliveryResult['country']);	 if($d_country==""){ $d_country=$country; } else { $d_country; } 
		$d_state=strtoupper(getStateName($deliveryResult['state'])); if($d_state==""){ $d_state=$state; } else { $d_state; } 
		$d_pincode=$deliveryResult['pin_code'];				 if($d_pincode==""){ $d_pincode=$pincode; } else { $d_pincode; } 
		} */
	
$table .= '<tr>
<td>'.$registration_id.'</td>
<td>'.$memberBP.'</td>
<td>'.$company_name.'</td>
<td>'.$company_pan_no.'</td>
<td>'.$company_gstn.'</td>
<td>'.$orderid.'</td>
<td>'.$sales_order_no.'</td>
<td>'.$payment_date.'</td>
<td>'.$badge_id.'</td>
<td>'.$bp_number.'</td>
<td>'.$payment_status.'</td>
<td>'.$name.'</td>
<td>'.$lname.'</td>
<td>'.$designation.'</td>
<td>'.$address_line1.'</td>
<td>'.$address_line2.'</td>
<td>'.$state.'</td>
<td>'.$city.'</td>
<td>'.$pincode.'</td>
<td>'.$land_line_no.'</td>
<td>'.$c_mobile_no.'</td>
<td>'.$c_email_id.'</td>
<td>'.$p_mobile.'</td>
<td>'.$pan_no.'</td>
<td>'.$p_email.'</td>
<td>'.$gender.'</td>
<td>'.$photo.'</td>
<td>'.$payment_made_for.'</td>
<td>'.$payment_amount.'</td>
<td>'.$payment_mode.'</td>
</tr>';
	
}
$table .= $display;
$table .= '</table>';

		header("Content-type: application/x-msdownload"); 
		# replace excelfile.xls with whatever you want the filename to default to
		header("Content-Disposition: attachment; filename=$fn.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $table;
exit;	
?>
