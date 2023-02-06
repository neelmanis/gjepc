<?php
session_start(); 
ob_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
include('../db.inc.php');
$date=date("d_m_Y");

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

$category = 'VISITOR';
$report_name = 'VISITOR Disapprove Data';
$logs = reportLogs($category,$report_name,$conn);
?>
<?php
	function getStateName($id,$conn)
	{
		$query_sel = "SELECT state_name FROM state_master where state_code='$id'";
		$result = $conn->query($query_sel);
		$row = $result->fetch_assoc(); 		
		return $row['state_name'];	
	}
	
	function getStateID($id,$conn)
	{
		$query_sel = "SELECT state FROM registration_master where id='$id'";
		$result = $conn->query($query_sel);
		$row = $result->fetch_assoc();  		
			return $row['state'];
	}
	
	function getaddress1($id,$conn)
	{
		$query_sel = "SELECT address_line1 FROM registration_master where id='$id'";
		$result = $conn->query($query_sel);
		$row = $result->fetch_assoc();  		
			return $row['address_line1'];			
	}
	
	function getaddress2($id,$conn)
	{
		$query_sel = "SELECT address_line2 FROM registration_master where id='$id'";
		$result = $conn->query($query_sel);
		$row = $result->fetch_assoc();  		
			return $row['address_line2'];
	}
	
	function getCityName($id,$conn)
	{
		$query_sel = "SELECT city FROM registration_master where id='$id'";
		$result = $conn->query($query_sel);
		$row = $result->fetch_assoc(); 		
			return $row['city'];
	}
	
	function getVisitorDesignationID($id,$conn)
	{
		$query_sel = "SELECT type_of_designation FROM visitor_designation_master where id='$id'";	
		$result = $conn->query($query_sel);
		$row = $result->fetch_assoc();  		
			return $row['type_of_designation'];
	}
	
	function getCompanyName($id,$conn)
	{
		$query_sel = "SELECT company_name FROM registration_master where id='$id'";	
		$result = $conn->query($query_sel);
		$row = $result->fetch_assoc();  	
			$company_name=	$row['company_name'];
			return $company_name;
	}
	
	function getAdminName($id,$conn)
	{
	$query_sel = "SELECT `contact_name` FROM `admin_master` WHERE id='$id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
	return $row['contact_name'];
	}

$table = $display = "";	
$fn = "DISAPPROVED_EMP_DIR_";

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>Disapprove Date</td>
<td>Visitor Id</td>
<td>Company Name</td>
<td>First Name</td>
<td>Last Name</td>
<td>Designation</td>
<td>Person Mobile</td>
<td>Person PAN</td>
<td>Person Email</td>
<td>Gender</td>
<td>Address 1</td>
<td>Address 2</td>
<td>State</td>
<td>City</td>
<td>Admin</td>
<td>Disapprove Reason</td>
</tr>';

$sql="SELECT * FROM `visitor_directory` WHERE `visitor_approval` = 'D' AND `isApplied` = 'Y' AND registration_id!='0' AND visitor_approval!='O' AND mod_date between '2022-05-01' AND CURDATE()";
$result = $conn ->query($sql);
while($row = $result->fetch_assoc())
{	
$registration_id=$row['registration_id'];
$modify_date = date("d-m-Y", strtotime($row['mod_date']));
$visitor_id=$row['visitor_id'];
$company_name=getCompanyName($registration_id,$conn);
$name	= filter($row['name']);
$lname  = filter($row['lname']);
$designation=getVisitorDesignationID($row['designation'],$conn);
$p_mobile= filter($row['mobile']);
$pan_no  = filter($row['pan_no']);
$p_email = filter($row['email']);
$gender  = filter($row['gender']);
$stateid = getStateID($registration_id,$conn);
$state = getStateName($stateid,$conn);
$address1 = getaddress1($registration_id,$conn);
$address2 = getaddress2($registration_id,$conn);
$city = getCityName($registration_id,$conn);
$adminId = $row['adminId'];
$admin = getAdminName($adminId,$conn);
$disapprove_reason = $row['disapprove_reason'];
	
$table .= '<tr>
<td>'.$modify_date.'</td>
<td>'.$visitor_id.'</td>
<td>'.$company_name.'</td>
<td>'.$name.'</td>
<td>'.$lname.'</td>
<td>'.$designation.'</td>
<td>'.$p_mobile.'</td>
<td>'.$pan_no.'</td>
<td>'.$p_email.'</td>
<td>'.$gender.'</td>
<td>'.$address1.'</td>
<td>'.$address2.'</td>
<td>'.$state.'</td>
<td>'.$city.'</td>
<td>'.$admin.'</td>
<td>'.$disapprove_reason.'</td>
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

