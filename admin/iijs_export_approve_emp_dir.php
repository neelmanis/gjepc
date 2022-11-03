<?php
session_start(); 
ob_start();
include('../db.inc.php');
$date=date("d_m_Y");

function reportLogs($category,$report_name,$conn)
{
	$adminID = intval($_SESSION['curruser_login_id']);
	$adminName = strtoupper($_SESSION['curruser_contact_name']);
	$ip = $_SERVER['REMOTE_ADDR'];
	$query = "INSERT INTO report_logs SET post_date=NOW(),admin_id='$adminID',admin_name='$adminName',category='$category',report_name='$report_name',ip='$ip'";
	$result = $conn->query($query);
	if($result)
	{
		return "TRUE";
	} else {
		return "FALSE";
	}
}

$category = 'VISITOR';
$report_name = 'VISITOR Approve Data';
$logs = reportLogs($category,$report_name,$conn);

/*
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
function getRegionName($id,$conn)
{
	$query_sel = "SELECT region FROM state_master where state_code='$id'";
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
		return $row['region'];
} */
?>

<?php /*
$table = $display = "";	
$fn = "APPROVED_EMP_DIR_". date('Ymd');

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>Company Registration ID</td>
<td>Company BP</td>
<td>Company Name</td>
<td>Company PAN</td>
<td>Company GSTIN</td>
<td>Company Email</td>
<td>Address 1</td>
<td>Address 2</td>
<td>City</td>
<td>State</td>
<td>Region</td>
<td>Pincode</td>
<td>Company Tel</td>
<td>Company Mobile</td>
<td>Person BP</td>
<td>First Name</td>
<td>Last Name</td>
<td>Designation</td>
<td>Gender</td>
<td>Person Mobile</td>
<td>Person PAN</td>
<td>Person Email</td>
<td>Nature of Business</td>
</tr>';

$sql="select rm.id,rm.company_name,rm.company_pan_no,rm.company_gstn,rm.email_id,rm.address_line1,rm.address_line2,rm.city,rm.state,sm.state_name,sm.region,rm.pin_code,rm.land_line_no,rm.mobile_no, vd.bp_number, vd.shows, vd.year, vd.name, vd.lname, vd.degn_type,vd.designation, vd.gender, vd.mobile, vd.email, vd.aadhar_no, vd.pan_no, vd.photo, vd.salary_slip_copy, vd.pan_copy, vd.partner, vd.visitor_approval, vd.disapprove_reason,rm.nature_of_buisness from visitor_directory vd inner join registration_master rm on vd.registration_id = rm.id 
 left join state_master sm on sm.state_code = rm.state where vd.visitor_approval='Y' and vd.status = '1' order by rm.state";
$result = $conn ->query($sql);
while($row = $result->fetch_assoc())
{
	$registration_id=$row['id'];
	$company_name=$row['company_name'];
	$company_pan_no=$row['company_pan_no'];
	$company_gstn=$row['company_gstn'];
	$address_line1=strtoupper($row['address_line1']);
	$address_line2=strtoupper($row['address_line2']);
	$city=strtoupper($row['city']);
	$state=strtoupper($row['state']);
	$state_name=strtoupper($row['state_name']);
	$region=strtoupper(getRegionName($row['state'],$conn));
	$pincode=$row['pin_code'];
		
	$bp_number=$row['bp_number'];
	$checkMember = CheckMembership($registration_id,$conn);
	if($checkMember=="M")
	{
	 $memberBP = getBPNO($registration_id,$conn);
	} else {
	  $memberBP = getCompanyNonMemBPNO($registration_id,$conn);
	}

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
	$nature_of_buisness=$row['nature_of_buisness'];
	
	$table .= '<tr>	
<td>'.$registration_id.'</td>
<td>'.$memberBP.'</td>
<td>'.$company_name.'</td>
<td>'.$company_pan_no.'</td>
<td>'.$company_gstn.'</td>
<td>'.$c_email_id.'</td>
<td>'.$address_line1.'</td>
<td>'.$address_line2.'</td>
<td>'.$city.'</td>
<td>'.$state_name.'</td>
<td>'.$region.'</td>
<td>'.$pincode.'</td>
<td>'.$land_line_no.'</td>
<td>'.$c_mobile_no.'</td>
<td>'.$bp_number.'</td>
<td>'.$name.'</td>
<td>'.$lname.'</td>
<td>'.$designation.'</td>
<td>'.$gender.'</td>
<td>'.$p_mobile.'</td>
<td>'.$pan_no.'</td>
<td>'.$p_email.'</td>
<td>'.$nature_of_buisness.'</td>
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
exit; */
?>

<?php
  
  function cleanData(&$str)
  {
    if($str == 't') $str = 'TRUE';
    if($str == 'f') $str = 'FALSE';
    if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
      $str = "'$str";
    }
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }

  // filename for download
  $filename = "APPROVED_EMP_DIR_" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv;");

  $out = fopen("php://output", 'w');

  $flag = false;
 
  $sql = "select rm.id AS 'Company Registration ID',rm.company_name AS 'Company Name',rm.company_pan_no AS 'Company PAN',rm.company_gstn AS 'Company GSTIN',rm.email_id,rm.address_line1,rm.address_line2,rm.city,rm.state,sm.state_name,sm.region,rm.pin_code,rm.land_line_no,rm.mobile_no, vd.bp_number, vd.shows, vd.year, vd.name, vd.lname, vd.degn_type,vd.designation, vd.gender, vd.mobile, vd.email, vd.aadhar_no, vd.pan_no, vd.photo, vd.salary_slip_copy, vd.pan_copy, vd.partner, vd.visitor_approval, vd.disapprove_reason,rm.nature_of_buisness AS 'Nature of Business' from visitor_directory vd inner join registration_master rm on vd.registration_id = rm.id 
 left join state_master sm on sm.state_code = rm.state where vd.visitor_approval='Y' and vd.status = '1' order by rm.state";
  $result = $conn ->query($sql);
  while($row = $result->fetch_assoc()) {
    if(!$flag) {
      // display field/column names as first row
      fputcsv($out, array_keys($row), ',', '"');
      $flag = true;
    }
    array_walk($row, 'cleanData');
    fputcsv($out, array_values($row), ',', '"');
  }

  fclose($out);
  exit;
  
  
  /* overAll Approved Data
  select rm.id,rm.company_name,rm.company_pan_no,rm.company_gstn,rm.email_id,rm.address_line1,rm.address_line2,rm.city,rm.state,sm.state_name,sm.region,rm.pin_code,rm.land_line_no,rm.mobile_no, vd.registration_id,vd.bp_number, vd.shows, vd.year, vd.name, vd.lname, vd.degn_type,vd.designation, vd.gender, vd.mobile, vd.email, vd.aadhar_no, vd.pan_no, vd.photo, vd.salary_slip_copy, vd.pan_copy, vd.partner, vd.visitor_approval, vd.disapprove_reason 
from visitor_directory vd inner join registration_master rm on vd.registration_id = rm.id 
	inner join state_master sm on sm.state_code = rm.state 
where vd.visitor_approval='Y' and vd.status = '1' 
  */
  
?>