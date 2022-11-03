<?php
session_start(); 
ob_start();
include('../db.inc.php');
$date=date("d_m_Y");
?>

<?php
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

$category = 'MEMBERSHIP';
$report_name = 'Member Payments Data';
$logs = reportLogs($category,$report_name,$conn);
?>

<?php
/*
$filename = "member_payment_list_" . date('Ymd') . ".csv";  

$result =$conn ->query("SELECT c.`gcode`,t.`type_of_firm_name` as 'Type of Firm',c.`company_name`, a.`Response_Code`,a.`ReferenceNo`,a.`Unique_Ref_Number`,a.`Transaction_Date`,a.total_payable,b.`c_bp_number`,b.`landline_no1`,b.`mobile_no`,a.`sales_order_no`,c.region_id ,d.`issue_membership_certificate_expire_status` as 'Issued Membership Certificate',d.membership_certificate_type as 'Membership Type',if(c.member_type_id = '5', 'Merchant','Manufacturer') as 'Member Type'  FROM `challan_master` a,`communication_address_master` b , `information_master` c ,`approval_master` d,type_of_firm_master t WHERE a.`registration_id`=b.`registration_id` and a.`registration_id`=c.`registration_id` and a.`registration_id`=d.`registration_id` and c.type_of_firm=t.sap_value and a.`challan_financial_year`='2021' and b.type_of_address='2' and a.`Response_Code`='E000' group by b.`registration_id` order by region_id");

$users = array();
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
}
 
header('Content-Type: text/csv; charset=utf-8');
header("Content-Disposition: attachment; filename=\"$filename\"");
$output = fopen('php://output', 'w');
//fputcsv($output, array($users), ',', '"');
//print_r($users); exit;
fputcsv($output, array('Gcode', 'Type of Firm','Company Name','Response Code', 'Reference No','Unique_Ref_Number', 'Transaction_Date','total_payable','c_bp_number','landline_no1','mobile_no','sales_order_no','region_id','Issued Membership Certificate','Membership Type','Member Type'));
 
if (count($users) > 0) {
    foreach ($users as $row) {
        fputcsv($output, $row);
    }
}
*/
?>
<?php
$table = $display = "";	
$fn = "member_payment_list_" . date('Ymd');

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>Type of Firm</td>
<td>Company Name</td>
<td>Response Code</td>
<td>Reference No</td>
<td>Unique_Ref_Number</td>
<td>Transaction_Date</td>
<td>Total Payable</td>
<td>BP No</td>
<td>Phone No</td>
<td>Mobile No</td>
<td>SO</td>
<td>Region</td>
<td>Issue Membership Certificate</td>
<td>Membership Type</td>
<td>Member Type</td>
<td>Renewal Status</td>
</tr>';

$sql = "SELECT a.registration_id,c.`gcode`,t.`type_of_firm_name`,c.`company_name`, a.`Response_Code`,a.`ReferenceNo`,a.`Unique_Ref_Number`,a.`Transaction_Date`,a.total_payable,b.`c_bp_number`,b.`landline_no1`,b.`mobile_no`,a.`sales_order_no`,c.region_id ,d.`issue_membership_certificate_expire_status` as 'Issued Membership Certificate',d.membership_certificate_type,if(c.member_type_id = '5', 'Merchant','Manufacturer') as 'Member Type',d.eligible_for_renewal  FROM `challan_master` a,`communication_address_master` b , `information_master` c ,`approval_master` d,type_of_firm_master t WHERE a.`registration_id`=b.`registration_id` and a.`registration_id`=c.`registration_id` and a.`registration_id`=d.`registration_id` and c.type_of_firm=t.sap_value and a.`challan_financial_year`='2022' and b.type_of_address='2' and a.`Response_Code`='E000' group by b.`registration_id` order by region_id";
$result = $conn ->query($sql);
while($row = $result->fetch_assoc())
{	
$gcode = $row['gcode'];
$type_of_firm_name = $row['type_of_firm_name'];
$company_name = $row['company_name'];
$Response_Code = $row['Response_Code'];
$ReferenceNo = $row['ReferenceNo'];
$Unique_Ref_Number = $row['Unique_Ref_Number'];
$gettransaction_Date = $row['Transaction_Date'];
$transaction_date = date("Y-m-d", strtotime($gettransaction_Date));
	
$total_payable = $row['total_payable'];
$sales_order_no = $row['sales_order_no'];
$c_bp_number = $row['c_bp_number'];
$landline_no1 = $row['landline_no1'];
$mobile_no = $row['mobile_no'];
$region_id = $row['region_id'];
$Issued_Membership_Certificate = $row['Issued Membership Certificate'];
$membership_certificate_type = $row['membership_certificate_type'];
$Member_Type = $row['Member Type'];
$eligible_for_renewal = $row['eligible_for_renewal'];
if($eligible_for_renewal=="Y"){ $renewStatus = "Renewal"; } else { $renewStatus = "New";} 
$table .= '<tr>
<td>'.$type_of_firm_name.'</td>
<td>'.$company_name.'</td>
<td>'.$Response_Code.'</td>
<td>'.$ReferenceNo.'</td>
<td>'.$Unique_Ref_Number.'</td>
<td>'.$transaction_date.'</td>
<td>'.$total_payable.'</td>
<td>'.$c_bp_number.'</td>
<td>'.$landline_no1.'</td>
<td>'.$mobile_no.'</td>
<td>'.$sales_order_no.'</td>
<td>'.$region_id.'</td>
<td>'.$Issued_Membership_Certificate.'</td>
<td>'.$membership_certificate_type.'</td>
<td>'.$Member_Type.'</td>
<td>'.$renewStatus.'</td>
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