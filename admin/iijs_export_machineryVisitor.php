<?php
include('../db.inc.php'); 
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
	
function reportLogs($category,$report_name,$conn)
{
	$adminID = intval($_SESSION['curruser_login_id']);
	$adminName = strtoupper($_SESSION['curruser_contact_name']);
	$ip = get_client_ip();
	$query = "INSERT INTO report_logs SET post_date=NOW(),admin_id='$adminID',admin_name='$adminName',category='$category',report_name='$report_name',ip='$ip'";
	$result = $conn->query($query);
	if($result)
	{
		return "TRUE";
	} else {
		return "FALSE";
	}
}

$category = 'MACHINERY VISITOR';
$report_name = 'MACHINERY VISITOR';
$logs = reportLogs($category,$report_name,$conn);
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
$fn = "report_". date('Ymd');

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
<td>TXN ID</td>
<td>SO No</td>
<td>Payment Date</td>
<td>Person BP</td>
<td>Payment Status</td>
<td>First Name</td>
<td>Last Name</td>
<td>Designation Type</td>
<td>Designation</td>
<td>Address 1</td>
<td>Address 2</td>
<td>State</td>
<td>State ID</td>
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
<!--<td>Image</td>-->
<td>Member</td>
<td>SHOW</td>
<td>Amount</td>
<td>Category</td>
<td>Phase</td>
<!--<td>FR Apply</td>-->
</tr>';

//$sql="select gb.uniqueIdentifier,oh.visitor_id, oh.create_date as 'create_date', rm.id,rm.company_name,rm.company_pan_no,rm.company_gstn,rm.land_line_no,rm.mobile_no,rm.email_id, oh.orderId, vd.badge_id,vd.bp_number,vd.name,vd.lname,vd.designation,vd.pan_no,vd.gender,vd.mobile,vd.email,vd.photo,vd.category, oh.payment_made_for, oh.amount as 'Amount', oh.payment_status as 'payment_status' from visitor_order_history oh inner join registration_master rm on oh.registration_id=rm.id inner join visitor_directory vd on oh.visitor_id=vd.visitor_id inner join globalExhibition gb on gb.visitor_id=vd.visitor_id where oh.payment_status='Y' and oh.status = '1' and (oh.show='signature22' or oh.show='igjme22') and (gb.participant_Type='VIS' or gb.participant_Type='IGJME')";

//$sql="select gb.uniqueIdentifier,oh.visitor_id, oh.create_date as 'create_date', rm.id,rm.company_name,rm.company_pan_no,rm.company_gstn,rm.land_line_no,rm.mobile_no,rm.email_id, oh.orderId, vd.badge_id,vd.bp_number,vd.name,vd.lname,vd.designation,vd.pan_no,vd.gender,vd.mobile,vd.email,vd.photo,vd.category, oh.payment_made_for, oh.amount as 'Amount', oh.payment_status as 'payment_status' from visitor_order_history oh inner join registration_master rm on oh.registration_id=rm.id inner join visitor_directory vd on oh.visitor_id=vd.visitor_id inner join globalExhibition gb on gb.visitor_id=vd.visitor_id where oh.payment_status='Y' and oh.status = '1' and (oh.show='signature23' || oh.show='iijs22' || oh.show='iijstritiya23' || oh.show='combo23') and gb.participant_Type='VIS'"; /* 03-06-2022 */

$sql="select gb.uniqueIdentifier,oh.visitor_id, oh.create_date as 'create_date', rm.id,rm.company_name,rm.company_pan_no,rm.company_gstn,rm.land_line_no,rm.mobile_no,rm.email_id, oh.orderId, vd.bp_number,vd.name,vd.lname,vd.degn_type,vd.designation,vd.pan_no,vd.gender,vd.mobile,vd.email,vd.photo,vd.category,vd.face_isApplied, oh.payment_made_for, oh.amount as 'Amount', oh.payment_status as 'payment_status' 
from visitor_order_history oh inner join registration_master rm on oh.registration_id=rm.id 
inner join visitor_directory vd on oh.visitor_id=vd.visitor_id 
inner join globalExhibition gb on gb.visitor_id=vd.visitor_id 
where oh.payment_status='Y' and oh.status = '1' AND oh.show = gb.event and oh.show='igjme23' and gb.participant_Type='IGJME'";
$result = $conn ->query($sql);
while($row = $result->fetch_assoc())
{	
$registration_id=$row['id'];
$visitor_id=$row['visitor_id'];
$unique_id=$row['uniqueIdentifier'];
$company_name = trim($row['company_name']);
$company_pan_no = trim($row['company_pan_no']);
$company_gstn = trim($row['company_gstn']);
$orderid=$row['orderId'];
$payment_date = date("d-m-Y", strtotime($row['create_date']));
$bp_number = $row['bp_number'];
$payment_status = $row['payment_status'];
$name = trim($row['name']);
$lname= trim($row['lname']);
$degn_type = trim($row['degn_type']);
$designation = getVisitorDesignationID($row['designation'],$conn);
$land_line_no = trim($row['land_line_no']);
$c_mobile_no = trim($row['mobile_no']);
$c_email_id = trim($row['email_id']);
$p_mobile = $row['mobile'];
$p_email = $row['email'];
$pan_no = trim($row['pan_no']);
$gender = $row['gender'];
//$face_isApplied = $row['face_isApplied'];
//$photo="https://registration.gjepc.org/images/employee_directory/".$registration_id."/photo/".$row['photo'];
if($row['payment_made_for']=="signature23"){ $payment_made_for = 'IIJS SIGNATURE 2023'; }
 else if($row['payment_made_for']=="iijs22"){ $payment_made_for = 'IIJS PREMIERE 2022'; } 
 else if($row['payment_made_for']=="iijstritiya23"){ $payment_made_for = 'IIJS TRITIYA 2023'; }
 else if($row['payment_made_for']=="combo23"){ $payment_made_for = 'IIJS PREMIERE 22 & IIJS SIGNATURE 23 & IIJS TRITIYA 23';}
 else if($row['payment_made_for']=="stcombo23"){ $payment_made_for = 'IIJS SIGNATURE 23 & IIJS TRITIYA 23';}
$amount = $row['Amount'];

if($amount=="4000" || $amount=="5200" || $amount=="2000" || $amount=="2500" || $amount=="2700" || $amount=="0"){ $phase = 'PHASE 1'; } 
else if($amount=="7000" || $amount=="9100" || $amount=="3500" || $amount=="4000"){ $phase = 'PHASE 2'; }
else if($amount=="6500" || $amount=="8500"){ $phase = 'PHASE 3'; }
else { $phase = 'PHASE missing';  }
$category = $row['category'];

	$checkMember = CheckMembership($registration_id,$conn);
	if($checkMember=="M")
	{
	 $memberBP = getBPNO($registration_id,$conn);
	} else {
		$memberBP = getBPNO($registration_id,$conn);
	 if($memberBP !=''){
		$memberBP = getBPNO($registration_id,$conn);
	 } else {
	 $memberBP = getCompanyNonMemBPNO($registration_id,$conn);
	 }
	}
  
		$getAddress ="SELECT address_line1,address_line2,city,state,pin_code FROM `registration_master` WHERE `id` = '$registration_id'";
		$getAddressResult = $conn ->query($getAddress);
		$getAddressRow = $getAddressResult->fetch_assoc();
		$address_line1=strtoupper($getAddressRow['address_line1']);
		$address_line2=strtoupper($getAddressRow['address_line2']);
		$city=strtoupper($getAddressRow['city']);		
		$state=strtoupper(getStateName($getAddressRow['state'],$conn));
		$stateid = $getAddressRow['state'];
		$pincode=$getAddressRow['pin_code'];		
		$region=strtoupper(getRegionName($getAddressRow['state'],$conn));
			
		$getapplication ="SELECT delivery_id,sales_order_no,tpsl_txn_id FROM `visitor_order_detail` WHERE `regId` = '$registration_id' AND orderId='$orderid' AND payment_status='Y'";
		$getApplicationResult = $conn ->query($getapplication);
		$getApplicationRow= $getApplicationResult->fetch_assoc();
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
<td>'.$bp_number.'</td>
<td>'.$payment_status.'</td>
<td>'.$name.'</td>
<td>'.$lname.'</td>
<td>'.$degn_type.'</td>
<td>'.$designation.'</td>
<td>'.$address_line1.'</td>
<td>'.$address_line2.'</td>
<td>'.$state.'</td>
<td>'.$stateid.'</td>
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
<td>'.$checkMember.'</td>
<!--<td>'.$photo.'</td>-->
<td>'.$payment_made_for.'</td>
<td>'.$amount.'</td>
<td>'.$category.'</td>
<td>'.$phase.'</td>
<!--<td>'.$face_isApplied.'</td>-->
</tr>';
}
$table .= $display;
$table .= '</table>';

		header("Content-type: application/vnd-ms-excel"); 
		# replace excelfile.xls with whatever you want the filename to default to
		header("Content-Disposition: attachment; filename=$fn.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $table;

$conn -> close();
exit;	
?>