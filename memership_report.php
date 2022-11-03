<?php 
date_default_timezone_set('Asia/Calcutta');
error_reporting(0);

$hostname = "localhost";
$uname = "gjepcliveuserdb";
$pwd = "KGj&6(pcvmLk5";
$database = "gjepclivedatabase";

// Create connection
$conn = new mysqli($hostname, $uname, $pwd, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
	
}
function getAdminName($id,$conn)
{
	$query_sel = "SELECT `contact_name` FROM `admin_master` WHERE id='$id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
	return $row['contact_name'];
}
header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=membrship_report.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");
echo '<table border="1">';
echo '<tr>
		<th>Sr. No.</th>
		<th>BP No.</th>
		<th>Name of company</th>
		<th>Application date</th>
		<th>Date of payment </th>
		<th>GJEPC Region</th>
		<th>Approved by ( Name of  admin approval users)</th>
		<th>Date of issue of Certificate</th>
		<th>Date of issue of RCMC </th>
		<th>Name of the user who issued membership</th>
		<th>No. of days Dept took to complete membership cycle</th>	
	</tr>';
$sql="SELECT a.id,a.company_name,b.post_date,b.Transaction_Date,b.challan_region_name,c.c_bp_number,d.sap_push_admin,d.membership_type,d.membership_issued_dt,
d.membership_renewal_dt,d.rcmc_certificate_issue_date,d.admin_issue_certificate FROM registration_master a,challan_master b,communication_address_master c,approval_master d 
where a.id=b.registration_id and a.id=c.registration_id and a.id=d.registration_id and d.issue_membership_certificate_expire_status='Y' and c.type_of_address='2' and b.challan_financial_year='2020'";
$result = $conn ->query($sql);
$i=0;
while ($row = $result->fetch_assoc()) {
	if($row['membership_type']=="R")
		$membership_issued_dt=$row['membership_renewal_dt'];
	else
		$membership_issued_dt=$row['membership_issued_dt'];	
	
	$date1 = $row['post_date']; 
	$date2 = $membership_issued_dt; 

	$diff = abs(strtotime($date2) - strtotime($date1)); 

	$years   = floor($diff / (365*60*60*24)); 
	$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
	$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	
	echo "<tr>
			<td>".$i."</td>
			<td>".$row['c_bp_number']."</td>
			<td>".$row['company_name']."</td>
			<td>".$row['post_date']."</td>
			<td>".$row['Transaction_Date']."</td>
			<td>".$row['challan_region_name']."</td>
			<td>".getAdminName($row['sap_push_admin'],$conn)."</td>
			<td>".$membership_issued_dt."</td>
			<td>".$row['rcmc_certificate_issue_date']."</td>
			<td>".getAdminName($row['admin_issue_certificate'],$conn)."</td>
			<td>".$days."</td>			
		</tr>";
	$i++;
}
echo '</table>';
?>