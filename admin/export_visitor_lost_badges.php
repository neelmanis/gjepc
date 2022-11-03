<?php
session_start(); 
ob_start();
include('../db.inc.php');
?>
<?php
	function getStateName($id)
	{
		$query_sel = "SELECT state_name FROM state_master where state_code='$id'";
		$result_sel = mysql_query($query_sel);								
		if($row = mysql_fetch_array($result_sel))		 	
		{ 		
			return $row['state_name'];			
		}
	}
	
	function getRegionName($id)
	{
		$query_sel = "SELECT region FROM state_master where state_code='$id'";
		$result_sel = mysql_query($query_sel);								
		if($row = mysql_fetch_array($result_sel))		 	
		{ 		
			return $row['region'];		
		}
	}
	
	function getStateID($id)
	{
		$query_sel = "SELECT state FROM registration_master where id='$id'";
		$result_sel = mysql_query($query_sel);								
		if($row = mysql_fetch_array($result_sel))		 	
		{ 		
			return $row['state'];			
		}
	}
	
	function getaddress1($id)
	{
		$query_sel = "SELECT address_line1 FROM registration_master where id='$id'";
		$result_sel = mysql_query($query_sel);								
		if($row = mysql_fetch_array($result_sel))		 	
		{ 		
			return $row['address_line1'];			
		}
	}
	
	function getaddress2($id)
	{
		$query_sel = "SELECT address_line2 FROM registration_master where id='$id'";
		$result_sel = mysql_query($query_sel);								
		if($row = mysql_fetch_array($result_sel))		 	
		{ 		
			return $row['address_line2'];			
		}
	}
	
	function getCityName($id)
	{
		$query_sel = "SELECT city FROM registration_master where id='$id'";
		$result_sel = mysql_query($query_sel);								
		if($row = mysql_fetch_array($result_sel))		 	
		{ 		
			return $row['city'];			
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
	
	function getCompanyName($id)
	{
		$query_sel = "SELECT company_name FROM registration_master where id='$id'";	
		$result_sel = mysql_query($query_sel);								
		if($row = mysql_fetch_array($result_sel))		 	
		{ 	
			$company_name=	$row['company_name'];
			return $company_name;
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

	function getCompanyNonMemBPNO($registration_id)
	{
	$sql="SELECT NM_bp_number FROM registration_master where id='$registration_id'";
	$result=mysql_query($sql);
	if($row = mysql_fetch_array($result))		 	
	{ 		
		return $row['NM_bp_number'];
	}
	}

$table = $display = "";	
$fn = "LOST_BADGES_REPORT_" . date('d-m-Y');

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>Company ID</td>
<td>Registration No</td>
<td>Company BP NO</td>
<td>Company Name</td>
<td>Company PAN</td>
<td>Order ID</td>
<td>SO No</td>
<td>Payment Date</td>
<td>Badge ID</td>
<td>Person BP</td>
<td>Payment Status</td>
<td>First Name</td>
<td>Last Name</td>
<td>Designation</td>
<td>Address1</td>
<td>Address2</td>
<td>State</td>
<td>Region</td>
<td>City</td>
<td>Pincode</td>
<td>Person Mobile</td>
<td>Person PAN</td>
<td>Person Email</td>
<td>Gender</td>
<td>Event</td>
<td>Show</td>
<td>Amount</td>
</tr>';

$sql="SELECT * FROM `visitor_lost_badges` WHERE payment_status='Y'"; 
$result = mysql_query($sql);
while($row = mysql_fetch_array($result))
{	
$registration_id=$row['regId'];
$visitor_id=$row['visitor_id'];
$company_name = getCompanyName($registration_id);
$company_pan_no = $row['company_pan_no'];
$orderid=$row['orderId'];
$sales_order_no = $row['sales_order_no'];
$payment_date = date("d-m-Y", strtotime($row['create_date']));
$badge_id=$row['badge_id'];
$bp_number=$row['bp_number'];
$payment_status=$row['payment_status'];
$name=$row['name'];
$lname=$row['lname'];
$type_of_member = $row['type_of_member'];
$delivery_id = $row['delivery_id'];

$designation=getVisitorDesignationID($row['designation']);

$p_mobile=$row['mobile'];
$pan_no=$row['pan_no'];
$p_email=$row['email'];
$gender=$row['gender'];
$payment_made_for=$row['event'];
$show=$row['show'];
$amount=$row['total_payable'];

		if($type_of_member == "M"){
			
		$memberBP = getBPNO($registration_id);
		
		$addflag = "SELECT * FROM `communication_address_master` WHERE `address_identity`='CTC' and `registration_id`='$registration_id' AND id='$delivery_id'";
		$deliveryQuery = mysql_query($addflag);
		$deliveryResult = mysql_fetch_array($deliveryQuery);
		$d_address1=strtoupper($deliveryResult['address1']);
		$d_address2=strtoupper($deliveryResult['address2']);
		$d_city=strtoupper($deliveryResult['city']);
		$d_country=strtoupper($deliveryResult['country']);
		$d_state=strtoupper(getStateName($deliveryResult['state']));
		$d_region=strtoupper(getRegionName($deliveryResult['state']));
		$d_pincode=$deliveryResult['pincode'];
		} else {
			
		$memberBP = getCompanyNonMemBPNO($registration_id);
		
		$addflag = "SELECT * FROM `n_m_billing_address` WHERE `registration_id`='$registration_id' AND id='$delivery_id'";
		$deliveryQuery = mysql_query($addflag);
		$deliveryResult = mysql_fetch_array($deliveryQuery);
		$d_address1=strtoupper($deliveryResult['address1']); if($d_address1==""){ $d_address1=$address_line1; } else { $d_address1; } 
		$d_address2=strtoupper($deliveryResult['address2']); if($d_address2==""){ $d_address2=$address_line2; } else { $d_address2; } 
		$d_city=strtoupper($deliveryResult['city']);		 if($d_city==""){ $d_city=$city; } else { $d_city; } 
		$d_country=strtoupper($deliveryResult['country']);	 if($d_country==""){ $d_country=$country; } else { $d_country; } 
		$d_state=strtoupper(getStateName($deliveryResult['state'])); if($d_state==""){ $d_state=$state; } else { $d_state; } 
		$d_region=strtoupper(getRegionName($deliveryResult['state']));
		$d_pincode=$deliveryResult['pin_code'];				 if($d_pincode==""){ $d_pincode=$pincode; } else { $d_pincode; } 
		}
	
$table .= '<tr>
<td>'.$registration_id.'</td>
<td>'.$visitor_id.'</td>
<td>'.$memberBP.'</td>
<td>'.$company_name.'</td>
<td>'.$company_pan_no.'</td>
<td>'.$orderid.'</td>
<td>'.$sales_order_no.'</td>
<td>'.$payment_date.'</td>
<td>'.$badge_id.'</td>
<td>'.$bp_number.'</td>
<td>'.$payment_status.'</td>
<td>'.$name.'</td>
<td>'.$lname.'</td>
<td>'.$designation.'</td>
<td>'.$d_address1.'</td>
<td>'.$d_address2.'</td>
<td>'.$d_state.'</td>
<td>'.$d_region.'</td>

<td>'.$d_city.'</td>
<td>'.$d_pincode.'</td>
<td>'.$p_mobile.'</td>
<td>'.$pan_no.'</td>
<td>'.$p_email.'</td>
<td>'.$gender.'</td>
<td>'.$payment_made_for.'</td>
<td>'.$show.'</td>
<td>'.$amount.'</td>
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

