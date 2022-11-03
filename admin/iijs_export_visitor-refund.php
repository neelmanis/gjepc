<?php
include('../db.inc.php'); 
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
?>
<?php  
function getStateName($id,$conn)
{
	$query_sel = "SELECT state_name FROM  state_master  where state_code='$id'";
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
		return $row['state_name'];		
}

function getRegionName($id,$conn)
{
	$query_sel = "SELECT region FROM state_master where state_code='$id'";
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
		return $row['region'];
}

function getVisitorDesignationID($id,$conn)
{
	$query_sel = "SELECT type_of_designation FROM visitor_designation_master where id='$id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();  		
		return $row['type_of_designation'];
}

function getBPNO($registration_id,$conn)
{
	$query_sel = "SELECT c_bp_number FROM communication_address_master where registration_id='$registration_id' and type_of_address='2'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();  		
		return $row['c_bp_number'];
}

function CheckMembership($registration_id,$conn)
{
	//$sql="select * from approval_master where registration_id='".$registration_id."' AND (`membership_issued_certificate_dt` between '2018-03-31' and '2019-03-31' || membership_renewal_dt between '2018-03-31' and '2019-03-31')";
	$sql = "SELECT * FROM `approval_master` WHERE 1 and `registration_id`='$registration_id' and issue_membership_certificate_expire_status='Y'";
	$result = $conn ->query($sql);
	$num_rows = $result->num_rows;
	if($num_rows>0)
	{
		return 'M';
	} else {
		return 'NM';
	}
}

function getCompanyNonMemBPNO($registration_id,$conn)
{
	$sql="SELECT NM_bp_number FROM registration_master where id='$registration_id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();  		
		return $row['NM_bp_number'];
}

?>

<?php
$table = $display = "";	
$fn = "refund_report_". date('Ymd');

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>ID</td>
<td>Registration No</td>
<td>UniqueID</td>
<td>Company BP</td>
<td>Company Name</td>
<td>Company PAN</td>
<td>Company GST</td>
<td>Order ID</td>
<td>TRANSACTION ID</td>
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
<td>Region</td>
<td>Head Office City</td>
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
<td>Category</td>
</tr>';

$sql="select gb.uniqueIdentifier,oh.visitor_id, oh.create_date as 'create_date', rm.id,rm.company_name,rm.company_pan_no,rm.company_gstn,rm.land_line_no,rm.mobile_no,rm.email_id, oh.orderId, vd.badge_id,vd.bp_number,vd.name,vd.lname,vd.designation,vd.pan_no,vd.gender,vd.mobile,vd.email,vd.photo,vd.category, oh.payment_made_for, oh.amount as 'Amount', oh.payment_status as 'payment_status' from visitor_order_history oh inner join registration_master rm on oh.registration_id=rm.id inner join visitor_directory vd on oh.visitor_id=vd.visitor_id inner join globalExhibition gb on gb.visitor_id=vd.visitor_id where oh.payment_status='R' and oh.status = '1' and (oh.show='signature22' or oh.show='igjme22') and gb.participant_Type='VIS'";
$result = $conn ->query($sql);
while($row = $result->fetch_assoc())
{	
$registration_id=$row['id'];
$visitor_id=$row['visitor_id'];
$unique_id=$row['uniqueIdentifier'];
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
$designation=getVisitorDesignationID($row['designation'],$conn);
$land_line_no=$row['land_line_no'];
$c_mobile_no=$row['mobile_no'];
$c_email_id=$row['email_id'];
$p_mobile=$row['mobile'];
$p_email=$row['email'];
$pan_no=$row['pan_no'];
$gender=$row['gender'];
$photo="https://registration.gjepc.org/images/employee_directory/".$registration_id."/photo/".$row['photo'];
if($row['payment_made_for']=="signature22"){ $payment_made_for = 'IIJS SIGNATURE 2022'; } else { $payment_made_for = 'MACHINERY'; }
//$payment_made_for = $row['payment_made_for'];
//$payment_made_for = 'IIJS 2021';
$amount=$row['Amount'];
$category=$row['category'];

$checkMember = CheckMembership($registration_id,$conn);
if($checkMember=="M")
{
 $memberBP = getBPNO($registration_id,$conn);
} else {
  $memberBP = getCompanyNonMemBPNO($registration_id,$conn);
}
  
		$getAddress ="SELECT * FROM `registration_master` WHERE `id` = '$registration_id'";
		$getAddressResult = $conn ->query($getAddress);
		$getAddressRow = $getAddressResult->fetch_assoc();
		$address_line1=strtoupper($getAddressRow['address_line1']);
		$address_line2=strtoupper($getAddressRow['address_line2']);
		$city=strtoupper($getAddressRow['city']);
		$country=strtoupper($getAddressRow['country']);
		$state=strtoupper(getStateName($getAddressRow['state'],$conn));
		$pincode=$getAddressRow['pin_code'];		
		$region=strtoupper(getRegionName($getAddressRow['state'],$conn));
	//	$category=$getAddressRow['category'];
		
		$getapplication ="SELECT * FROM `visitor_order_detail` WHERE `regId` = '$registration_id' AND orderId='$orderid' AND payment_status='Y'";
		$getApplicationResult = $conn ->query($getapplication);
		$getApplicationRow= $getApplicationResult->fetch_assoc();
		$type_of_member = $getApplicationRow['type_of_member']; 
		$delivery_id = $getApplicationRow['delivery_id'];
		$sales_order_no = $getApplicationRow['sales_order_no'];
		$tpsl_txn_id = $getApplicationRow['tpsl_txn_id'];

$table .= '<tr>
<td>'.$registration_id.'</td>
<td>'.$visitor_id.'</td>
<td>'.$unique_id.'</td>

<td>'.$memberBP.'</td>
<td>'.$company_name.'</td>
<td>'.$company_pan_no.'</td>
<td>'.$company_gstn.'</td>
<td>'.$orderid.'</td>
<td>'.$tpsl_txn_id.'</td>
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
<td>'.$region.'</td>

<td>'.$city.'</td>
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
<td>'.$amount.'</td>
<td>'.$category.'</td>
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
